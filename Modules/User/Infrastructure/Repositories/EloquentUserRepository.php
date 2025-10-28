<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Domain\Events\UserAvatarRemoved;
use Modules\User\Domain\Events\UserAvatarUpdated;
use Modules\User\Domain\Events\UserCreated;
use Modules\User\Domain\Events\UserDeleted;
use Modules\User\Domain\Events\UserPasswordUpdated;
use Modules\User\Domain\Events\UserPermissionGiven;
use Modules\User\Domain\Events\UserPermissionRevoked;
use Modules\User\Domain\Events\UserPermissionsSynced;
use Modules\User\Domain\Events\UserRoleAssigned;
use Modules\User\Domain\Events\UserRoleRemoved;
use Modules\User\Domain\Events\UserRolesSynced;
use Modules\User\Domain\Events\UserUpdated;
use Modules\User\Domain\Exceptions\UserCreationException;
use Modules\User\Domain\Exceptions\UserDeletionException;
use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserUpdateException;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private User $model
    ) {}

    public function findById(int $id): ?User
    {
        $user = $this->model->find($id);

        if (! $user) {
            throw new UserNotFoundException("old with ID {$id} not found.");
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        $user = $this->model->where('email', $email)->first();

        if (! $user) {
            throw new UserNotFoundException("old with email {$email} not found.");
        }

        return $user;
    }

    public function all(array $relations): Collection
    {
        // Use 'with' if relations are provided
        if (! empty($relations)) {
            return $this->model->with($relations)->get();
        }

        return $this->model->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * @throws UserCreationException
     */
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
