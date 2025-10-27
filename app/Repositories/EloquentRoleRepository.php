<?php

namespace App\Repositories;

use App\Contracts\RoleRepositoryInterface;
use App\Exceptions\Roles\RoleNotFoundException;
use App\Exceptions\Roles\RoleCreationException;
use App\Exceptions\Roles\RoleUpdateException;
use App\Exceptions\Roles\RoleDeletionException;
use App\Events\Roles\RoleCreated;
use App\Events\Roles\RoleUpdated;
use App\Events\Roles\RoleDeleted;
use App\Events\Roles\RolePermissionGiven;
use App\Events\Roles\RolePermissionRevoked;
use App\Events\Roles\RolePermissionsSynced;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    public function __construct(
        protected Role $model
    ) {}

    public function findById(int $id, ?string $guardName = null): ?Role
    {
        $query = $this->model->where('id', $id);

        if ($guardName) {
            $query->where('guard_name', $guardName);
        }

        $role = $query->first();

        if (!$role) {
            throw new RoleNotFoundException("Role with ID {$id} not found.");
        }

        return $role;
    }

    public function findByName(string $name, ?string $guardName = null): ?Role
    {
        try {
            return Role::findByName($name, $guardName ?? config('auth.defaults.guard'));
        } catch (\Exception $e) {
            throw new RoleNotFoundException("Role '{$name}' not found.");
        }
    }

    public function all(?string $guardName = null): Collection
    {
        $query = $this->model->query();

        if ($guardName) {
            $query->where('guard_name', $guardName);
        }

        return $query->get();
    }

    public function create(array $data): Role
    {
        try {
            DB::beginTransaction();

            $role = $this->model->create($data);

            DB::commit();

            event(new RoleCreated($role));

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleCreationException("Failed to create role: {$e->getMessage()}");
        }
    }

    public function createByName(string $name, ?string $guardName = null): Role
    {
        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $name,
                'guard_name' => $guardName ?? config('auth.defaults.guard')
            ]);

            DB::commit();

            event(new RoleCreated($role));

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleCreationException("Failed to create role: {$e->getMessage()}");
        }
    }

    public function update(Role $role, array $data): Role
    {
        try {
            DB::beginTransaction();

            $role->update($data);
            $role->refresh();

            DB::commit();

            event(new RoleUpdated($role));

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleUpdateException("Failed to update role: {$e->getMessage()}");
        }
    }

    public function delete(Role $role): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $role->delete();

            DB::commit();

            event(new RoleDeleted($role));

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleDeletionException("Failed to delete role: {$e->getMessage()}");
        }
    }

    public function getByGuard(string $guardName): Collection
    {
        return $this->model->where('guard_name', $guardName)->get();
    }

    public function findOrCreate(string $name, ?string $guardName = null): Role
    {
        try {
            return Role::findOrCreate($name, $guardName ?? config('auth.defaults.guard'));
        } catch (\Exception $e) {
            throw new RoleCreationException("Failed to find or create role: {$e->getMessage()}");
        }
    }

    public function exists(string $name, ?string $guardName = null): bool
    {
        return $this->model
            ->where('name', $name)
            ->where('guard_name', $guardName ?? config('auth.defaults.guard'))
            ->exists();
    }

    public function givePermissionTo(Role $role, string|array $permissions): Role
    {
        try {
            DB::beginTransaction();

            $role->givePermissionTo($permissions);
            $role->refresh();

            DB::commit();

            event(new RolePermissionGiven($role, is_array($permissions) ? $permissions : [$permissions]));

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleUpdateException("Failed to give permission to role: {$e->getMessage()}");
        }
    }

    public function revokePermissionTo(Role $role, string|array $permissions): Role
    {
        try {
            DB::beginTransaction();

            $role->revokePermissionTo($permissions);
            $role->refresh();

            DB::commit();

            event(new RolePermissionRevoked($role, is_array($permissions) ? $permissions : [$permissions]));

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleUpdateException("Failed to revoke permission from role: {$e->getMessage()}");
        }
    }

    public function syncPermissions(Role $role, array $permissions): Role
    {
        try {
            DB::beginTransaction();

            $role->syncPermissions($permissions);
            $role->refresh();

            DB::commit();

            event(new RolePermissionsSynced($role, $permissions));

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RoleUpdateException("Failed to sync permissions: {$e->getMessage()}");
        }
    }

    public function getPermissions(Role $role): Collection
    {
        return $role->permissions;
    }

    public function hasPermissionTo(Role $role, string $permission): bool
    {
        return $role->hasPermissionTo($permission);
    }

    public function getByNames(array $names, ?string $guardName = null): Collection
    {
        $query = $this->model->whereIn('name', $names);

        if ($guardName) {
            $query->where('guard_name', $guardName);
        }

        return $query->get();
    }

    public function getUsersWithRole(Role $role): Collection
    {
        return $role->users;
    }

    public function getAllGuardNames(): Collection
    {
        return $this->model->distinct()->pluck('guard_name');
    }

    public function search(string $query, ?string $guardName = null): Collection
    {
        $queryBuilder = $this->model->where('name', 'like', "%{$query}%");

        if ($guardName) {
            $queryBuilder->where('guard_name', $guardName);
        }

        return $queryBuilder->get();
    }

    public function hasAnyPermission(Role $role, array $permissions): bool
    {
        return $role->hasAnyPermission($permissions);
    }

    public function hasAllPermissions(Role $role, array $permissions): bool
    {
        return $role->hasAllPermissions($permissions);
    }
}
