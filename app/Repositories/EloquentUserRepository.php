<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Exceptions\Users\UserNotFoundException;
use App\Exceptions\Users\UserCreationException;
use App\Exceptions\Users\UserUpdateException;
use App\Exceptions\Users\UserDeletionException;
use App\Events\Users\UserCreated;
use App\Events\Users\UserUpdated;
use App\Events\Users\UserDeleted;
use App\Events\Users\UserAvatarUpdated;
use App\Events\Users\UserAvatarRemoved;
use App\Events\Users\UserPasswordUpdated;
use App\Events\Users\UserRoleAssigned;
use App\Events\Users\UserRoleRemoved;
use App\Events\Users\UserRolesSynced;
use App\Events\Users\UserPermissionGiven;
use App\Events\Users\UserPermissionRevoked;
use App\Events\Users\UserPermissionsSynced;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function findById(int $id): ?User
    {
        $user = $this->model->find($id);

        if (!$user) {
            throw new UserNotFoundException("User with ID {$id} not found.");
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        $user = $this->model->where('email', $email)->first();

        if (!$user) {
            throw new UserNotFoundException("User with email {$email} not found.");
        }

        return $user;
    }

    public function all(array $relations = []): Collection
    {
        // Use 'with' if relations are provided
        if (!empty($relations)) {
            return $this->model->with($relations)->get();
        }

        return $this->model->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data): User
    {
        try {
            DB::beginTransaction();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->model->create($data);

            DB::commit();

            event(new UserCreated($user));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserCreationException("Failed to create user: {$e->getMessage()}");
        }
    }

    public function update(User $user, array $data): User
    {
        try {
            DB::beginTransaction();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);
            $user->refresh();

            DB::commit();

            event(new UserUpdated($user));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to update user: {$e->getMessage()}");
        }
    }

    public function delete(User $user): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $user->delete();

            DB::commit();

            event(new UserDeleted($user));

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserDeletionException("Failed to delete user: {$e->getMessage()}");
        }
    }

    public function updateAvatar(User $user, string $avatarPath): User
    {
        try {
            DB::beginTransaction();

            $user->update(['avatar' => $avatarPath]);
            $user->refresh();

            DB::commit();

            event(new UserAvatarUpdated($user, $avatarPath));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to update avatar: {$e->getMessage()}");
        }
    }

    public function removeAvatar(User $user): User
    {
        try {
            DB::beginTransaction();

            $oldAvatar = $user->avatar;
            $user->update(['avatar' => null]);
            $user->refresh();

            DB::commit();

            event(new UserAvatarRemoved($user, $oldAvatar));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to remove avatar: {$e->getMessage()}");
        }
    }

    public function updatePassword(User $user, string $password): User
    {
        try {
            DB::beginTransaction();

            $user->update(['password' => Hash::make($password)]);
            $user->refresh();

            DB::commit();

            event(new UserPasswordUpdated($user));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to update password: {$e->getMessage()}");
        }
    }

    public function getUsersByRole(string $roleName): Collection
    {
        return $this->model->role($roleName)->get();
    }

    public function getUsersWithPermission(string $permissionName): Collection
    {
        return $this->model->permission($permissionName)->get();
    }

    public function assignRole(User $user, string|array $roles): User
    {
        try {
            DB::beginTransaction();

            $user->assignRole($roles);
            $user->refresh();

            DB::commit();

            event(new UserRoleAssigned($user, is_array($roles) ? $roles : [$roles]));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to assign role: {$e->getMessage()}");
        }
    }

    public function removeRole(User $user, string|array $roles): User
    {
        try {
            DB::beginTransaction();

            $user->removeRole($roles);
            $user->refresh();

            DB::commit();

            event(new UserRoleRemoved($user, is_array($roles) ? $roles : [$roles]));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to remove role: {$e->getMessage()}");
        }
    }

    public function syncRoles(User $user, array $roles): User
    {
        try {
            DB::beginTransaction();

            $user->syncRoles($roles);
            $user->refresh();

            DB::commit();

            event(new UserRolesSynced($user, $roles));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to sync roles: {$e->getMessage()}");
        }
    }

    public function givePermission(User $user, string|array $permissions): User
    {
        try {
            DB::beginTransaction();

            $user->givePermissionTo($permissions);
            $user->refresh();

            DB::commit();

            event(new UserPermissionGiven($user, is_array($permissions) ? $permissions : [$permissions]));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to give permission: {$e->getMessage()}");
        }
    }

    public function revokePermission(User $user, string|array $permissions): User
    {
        try {
            DB::beginTransaction();

            $user->revokePermissionTo($permissions);
            $user->refresh();

            DB::commit();

            event(new UserPermissionRevoked($user, is_array($permissions) ? $permissions : [$permissions]));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to revoke permission: {$e->getMessage()}");
        }
    }

    public function syncPermissions(User $user, array $permissions): User
    {
        try {
            DB::beginTransaction();

            $user->syncPermissions($permissions);
            $user->refresh();

            DB::commit();

            event(new UserPermissionsSynced($user, $permissions));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UserUpdateException("Failed to sync permissions: {$e->getMessage()}");
        }
    }

    public function hasRole(User $user, string $role): bool
    {
        return $user->hasRole($role);
    }

    public function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission);
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
    }
}
