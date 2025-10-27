<?php

namespace App\Repositories;

use App\Contracts\PermissionRepositoryInterface;
use App\Exceptions\Permissions\PermissionNotFoundException;
use App\Exceptions\Permissions\PermissionCreationException;
use App\Exceptions\Permissions\PermissionUpdateException;
use App\Exceptions\Permissions\PermissionDeletionException;
use App\Events\Permissions\PermissionCreated;
use App\Events\Permissions\PermissionUpdated;
use App\Events\Permissions\PermissionDeleted;
use App\Events\Permissions\PermissionsSyncedToRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class EloquentPermissionRepository implements PermissionRepositoryInterface
{
    public function __construct(
        protected Permission $model
    ) {}

    public function findById(int $id, ?string $guardName = null): ?Permission
    {
        $query = $this->model->where('id', $id);

        if ($guardName) {
            $query->where('guard_name', $guardName);
        }

        $permission = $query->first();

        if (!$permission) {
            throw new PermissionNotFoundException("Permission with ID {$id} not found.");
        }

        return $permission;
    }

    public function findByName(string $name, ?string $guardName = null): ?Permission
    {
        try {
            return Permission::findByName($name, $guardName ?? config('auth.defaults.guard'));
        } catch (\Exception $e) {
            throw new PermissionNotFoundException("Permission '{$name}' not found.");
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

    public function create(array $data): Permission
    {
        try {
            DB::beginTransaction();

            $permission = $this->model->create($data);

            DB::commit();

            event(new PermissionCreated($permission));

            return $permission;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new PermissionCreationException("Failed to create permission: {$e->getMessage()}");
        }
    }

    public function createByName(string $name, ?string $guardName = null): Permission
    {
        try {
            DB::beginTransaction();

            $permission = Permission::create([
                'name' => $name,
                'guard_name' => $guardName ?? config('auth.defaults.guard')
            ]);

            DB::commit();

            event(new PermissionCreated($permission));

            return $permission;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new PermissionCreationException("Failed to create permission: {$e->getMessage()}");
        }
    }

    public function update(Permission $permission, array $data): Permission
    {
        try {
            DB::beginTransaction();

            $permission->update($data);
            $permission->refresh();

            DB::commit();

            event(new PermissionUpdated($permission));

            return $permission;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new PermissionUpdateException("Failed to update permission: {$e->getMessage()}");
        }
    }

    public function delete(Permission $permission): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $permission->delete();

            DB::commit();

            event(new PermissionDeleted($permission));

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new PermissionDeletionException("Failed to delete permission: {$e->getMessage()}");
        }
    }

    public function getByGuard(string $guardName): Collection
    {
        return $this->model->where('guard_name', $guardName)->get();
    }

    public function getPermissionsByRole(string $roleName, ?string $guardName = null): Collection
    {
        try {
            $role = \Spatie\Permission\Models\Role::findByName(
                $roleName,
                $guardName ?? config('auth.defaults.guard')
            );

            return $role->permissions;
        } catch (\Exception $e) {
            throw new PermissionNotFoundException("Role '{$roleName}' not found.");
        }
    }

    public function findOrCreate(string $name, ?string $guardName = null): Permission
    {
        try {
            return Permission::findOrCreate($name, $guardName ?? config('auth.defaults.guard'));
        } catch (\Exception $e) {
            throw new PermissionCreationException("Failed to find or create permission: {$e->getMessage()}");
        }
    }

    public function exists(string $name, ?string $guardName = null): bool
    {
        return $this->model
            ->where('name', $name)
            ->where('guard_name', $guardName ?? config('auth.defaults.guard'))
            ->exists();
    }

    public function getByNames(array $names, ?string $guardName = null): Collection
    {
        $query = $this->model->whereIn('name', $names);

        if ($guardName) {
            $query->where('guard_name', $guardName);
        }

        return $query->get();
    }

    public function syncToRole(string $roleName, array $permissions, ?string $guardName = null): void
    {
        try {
            DB::beginTransaction();

            $role = \Spatie\Permission\Models\Role::findByName(
                $roleName,
                $guardName ?? config('auth.defaults.guard')
            );

            $role->syncPermissions($permissions);

            DB::commit();

            event(new PermissionsSyncedToRole($role, $permissions));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new PermissionUpdateException("Failed to sync permissions to role: {$e->getMessage()}");
        }
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
}
