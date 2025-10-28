<?php

declare(strict_types=1);

namespace Modules\User\Application\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Application\Actions\Auth\AssignRoleAction;
use Modules\User\Application\Actions\Auth\GivePermissionAction;
use Modules\User\Application\Actions\Auth\RemoveRoleAction;
use Modules\User\Application\Actions\Auth\RevokePermissionAction;
use Modules\User\Application\Actions\Auth\SyncPermissionsAction;
use Modules\User\Application\Actions\Auth\SyncRolesAction;
use Modules\User\Application\Actions\Avatar\RemoveAvatarAction;
use Modules\User\Application\Actions\Avatar\UpdateAvatarAction;
use Modules\User\Application\Actions\Manage\CreateUserAction;
use Modules\User\Application\Actions\Manage\DeleteUserAction;
use Modules\User\Application\Actions\Manage\UpdatePasswordAction;
use Modules\User\Application\Actions\Manage\UpdateUserAction;
use Modules\User\Application\Actions\Retrieve\FindUserByEmailAction;
use Modules\User\Application\Actions\Retrieve\FindUserByIdAction;
use Modules\User\Application\Actions\Retrieve\GetAllUsersAction;
use Modules\User\Application\Actions\Retrieve\GetPaginatedUsersAction;
use Modules\User\Application\Actions\Retrieve\GetUsersByRoleAction;
use Modules\User\Application\Actions\Retrieve\GetUsersWithPermissionAction;
use Modules\User\Application\Actions\Retrieve\SearchUsersAction;
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

        UserCreated::dispatch($user);

        return $user;
    }

    /**
     * Update an existing user
     */
    public function updateUser(int $id, array $data): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(UpdateUserAction::class)->execute($user, $data);

        UserUpdated::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $id): bool
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $isDeleted = app(DeleteUserAction::class)->execute($user);

        UserDeleted::dispatch($isDeleted);

        return $isDeleted;
    }

    /**
     * Update user password
     */
    public function updatePassword(int $id, string $password): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(UpdatePasswordAction::class)->execute($user, $password);

        UserPasswordUpdated::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(int $id, $avatarFile): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(UpdateAvatarAction::class)->execute($user, $avatarFile);

        UserAvatarUpdated::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Remove user avatar
     */
    public function removeAvatar(int $id): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(RemoveAvatarAction::class)->execute($user);

        UserAvatarRemoved::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Assign role(s) to user
     */
    public function assignRole(AssignRoleAction $action, int $id, array $roles): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(AssignRoleAction::class)->execute($user, $roles);

        UserRoleAssigned::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Remove role(s) from user
     */
    public function removeRole(int $id, array $roles): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(RemoveRoleAction::class)->execute($user, $roles);

        UserRoleRemoved::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Sync user roles
     */
    public function syncRoles(int $id, array $roles): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(SyncRolesAction::class)->execute($user, $roles);

        UserRolesSynced::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Give permission(s) to user
     */
    public function givePermission(int $id, array $permissions): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(GivePermissionAction::class)->execute($user, $permissions);

        UserPermissionGiven::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Revoke permission(s) from user
     */
    public function revokePermission(int $id, array $permissions): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(RevokePermissionAction::class)->execute($user, $permissions);

        UserPermissionRevoked::dispatch($updatedUser);

        return $updatedUser;
    }

    /**
     * Sync user permissions
     */
    public function syncPermissions(int $id, array $permissions): User
    {
        $user = app(FindUserByIdAction::class)->execute($id);

        $updatedUser = app(SyncPermissionsAction::class)->execute($user, $permissions);

        UserPermissionsSynced::dispatch($updatedUser);

        return $updatedUser;
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
