<?php

declare(strict_types=1);

namespace Modules\User\Domain\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Find a user by ID
     */
    public function findById(int $id): ?User;

    /**
     * Find a user by email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Get all users
     */
    public function all(array $relations): Collection;

    /**
     * Get paginated users
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Create a new user
     */
    public function create(array $data): User;

    /**
     * Update an existing user
     */
    public function update(User $user, array $data): User;

    /**
     * Delete a user
     */
    public function delete(User $user): bool;

    /**
     * Update user's avatar
     */
    public function updateAvatar(User $user, string $avatarPath): User;

    /**
     * Remove user's avatar
     */
    public function removeAvatar(User $user): User;

    /**
     * Update user's password
     */
    public function updatePassword(User $user, string $password): User;

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName): Collection;

    /**
     * Get users with specific permission
     */
    public function getUsersWithPermission(string $permissionName): Collection;

    /**
     * Assign role to user
     */
    public function assignRole(User $user, string|array $roles): User;

    /**
     * Remove role from user
     */
    public function removeRole(User $user, string|array $roles): User;

    /**
     * Sync user roles
     */
    public function syncRoles(User $user, array $roles): User;

    /**
     * Give permission to user directly
     */
    public function givePermission(User $user, string|array $permissions): User;

    /**
     * Revoke permission from user
     */
    public function revokePermission(User $user, string|array $permissions): User;

    /**
     * Sync user permissions
     */
    public function syncPermissions(User $user, array $permissions): User;

    /**
     * Check if user has role
     */
    public function hasRole(User $user, string $role): bool;

    /**
     * Check if user has permission
     */
    public function hasPermission(User $user, string $permission): bool;

    /**
     * Search users by name or email
     */
    public function search(string $query): Collection;
}
