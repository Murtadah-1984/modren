<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\User\Auth\AssignRoleAction;
use App\Actions\User\Auth\GivePermissionAction;
use App\Actions\User\Auth\RemoveRoleAction;
use App\Actions\User\Auth\RevokePermissionAction;
use App\Actions\User\Auth\SyncPermissionsAction;
use App\Actions\User\Auth\SyncRolesAction;
use App\Actions\User\Avatar\RemoveAvatarAction;
use App\Actions\User\Avatar\UpdateAvatarAction;
use App\Actions\User\Manage\CreateUserAction;
use App\Actions\User\Manage\DeleteUserAction;
use App\Actions\User\Manage\UpdatePasswordAction;
use App\Actions\User\Manage\UpdateUserAction;
use App\Actions\User\Retrieve\FindUserByEmailAction;
use App\Actions\User\Retrieve\FindUserByIdAction;
use App\Actions\User\Retrieve\GetAllUsersAction;
use App\Actions\User\Retrieve\GetPaginatedUsersAction;
use App\Actions\User\Retrieve\GetUsersByRoleAction;
use App\Actions\User\Retrieve\GetUsersWithPermissionAction;
use App\Actions\User\Retrieve\SearchUsersAction;
use App\Events\Users\UserAvatarRemoved;
use App\Events\Users\UserAvatarUpdated;
use App\Events\Users\UserCreated;
use App\Events\Users\UserDeleted;
use App\Events\Users\UserPasswordUpdated;
use App\Events\Users\UserPermissionGiven;
use App\Events\Users\UserPermissionRevoked;
use App\Events\Users\UserPermissionsSynced;
use App\Events\Users\UserRoleAssigned;
use App\Events\Users\UserRoleRemoved;
use App\Events\Users\UserRolesSynced;
use App\Events\Users\UserUpdated;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final readonly class UserService
{
    /**
     * Get all users
     */
    public function getAllUsers(array $relations = []): Collection
    {
        return app(GetAllUsersAction::class)->execute($relations);
    }

    /**
     * Get paginated users
     */
    public function getPaginatedUsers(int $perPage = 15): LengthAwarePaginator
    {
        return app(GetPaginatedUsersAction::class)->execute($perPage);
    }

    /**
     * Search users
     */
    public function searchUsers(string $query): Collection
    {
        return app(SearchUsersAction::class)->execute($query);
    }

    /**
     * Find user by ID
     */
    public function findUserById(int $id): User
    {
        return app(FindUserByIdAction::class)->execute($id);
    }

    /**
     * Find user by email
     */
    public function findUserByEmail(string $email): User
    {
        return app(FindUserByEmailAction::class)->execute($email);
    }

    /**
     * Create a new user
     */
    public function createUser(array $data): User
    {
        $user = app(CreateUserAction::class)->execute($data);

        return $user->fresh(['roles', 'permissions']);
    }

    /**
     * Update an existing user
     */
    public function updateUser(int $id, array $data): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(UpdateUserAction::class)->execute($user, $data);
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $id): bool
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(DeleteUserAction::class)->execute($user);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $id, string $password): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(UpdatePasswordAction::class)->execute($user, $password);
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(int $id, $avatarFile): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(UpdateAvatarAction::class)->execute($user, $avatarFile);
    }

    /**
     * Remove user avatar
     */
    public function removeAvatar(int $id): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(RemoveAvatarAction::class)->execute($user);
    }

    /**
     * Assign role(s) to user
     */
    public function assignRole(AssignRoleAction $action, int $id, array $roles): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(AssignRoleAction::class)->execute($user, $roles);
    }

    /**
     * Remove role(s) from user
     */
    public function removeRole(int $id, array $roles): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(RemoveRoleAction::class)->execute($user, $roles);
    }

    /**
     * Sync user roles
     */
    public function syncRoles(int $id, array $roles): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(SyncRolesAction::class)->execute($user, $roles);
    }

    /**
     * Give permission(s) to user
     */
    public function givePermission(int $id, array $permissions): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(GivePermissionAction::class)->execute($user, $permissions);
    }

    /**
     * Revoke permission(s) from user
     */
    public function revokePermission(int $id, array $permissions): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(RevokePermissionAction::class)->execute($user, $permissions);
    }

    /**
     * Sync user permissions
     */
    public function syncPermissions(int $id, array $permissions): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        return app(SyncPermissionsAction::class)->execute($user, $permissions);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(GetUsersByRoleAction $action, string $roleName): Collection
    {
        return app(GetUsersByRoleAction::class)->execute($roleName);
    }

    /**
     * Get users with specific permission
     */
    public function getUsersWithPermission(string $permissionName): Collection
    {
        return app(GetUsersWithPermissionAction::class)->execute($permissionName);
    }
}
