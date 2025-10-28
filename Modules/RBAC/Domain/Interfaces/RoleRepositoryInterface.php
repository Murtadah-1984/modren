<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    /**
     * Find a role by ID
     */
    public function findById(int $id, ?string $guardName = null): ?Role;

    /**
     * Find a role by name
     */
    public function findByName(string $name, ?string $guardName = null): ?Role;

    /**
     * Get all roles
     */
    public function all(?string $guardName = null): Collection;

    /**
     * Create a new role
     */
    public function create(array $data): Role;

    /**
     * Create a role by name
     */
    public function createByName(string $name, ?string $guardName = null): Role;

    /**
     * Update an existing role
     */
    public function update(Role $role, array $data): Role;

    /**
     * Delete a role
     */
    public function delete(Role $role): bool;

    /**
     * Get roles by guard name
     */
    public function getByGuard(string $guardName): Collection;

    /**
     * Find or create a role
     */
    public function findOrCreate(string $name, ?string $guardName = null): Role;

    /**
     * Check if role exists
     */
    public function exists(string $name, ?string $guardName = null): bool;

    /**
     * Give permission to role
     */
    public function givePermissionTo(Role $role, string|array $permissions): Role;

    /**
     * Revoke permission from role
     */
    public function revokePermissionTo(Role $role, string|array $permissions): Role;

    /**
     * Sync permissions to role
     */
    public function syncPermissions(Role $role, array $permissions): Role;

    /**
     * Get all permissions for a role
     */
    public function getPermissions(Role $role): Collection;

    /**
     * Check if role has permission
     */
    public function hasPermissionTo(Role $role, string $permission): bool;

    /**
     * Get roles by names
     */
    public function getByNames(array $names, ?string $guardName = null): Collection;

    /**
     * Get users with this role
     */
    public function getUsersWithRole(Role $role): Collection;

    /**
     * Get all guard names
     */
    public function getAllGuardNames(): Collection;

    /**
     * Search roles by name
     */
    public function search(string $query, ?string $guardName = null): Collection;

    /**
     * Check if role has any of the given permissions
     */
    public function hasAnyPermission(Role $role, array $permissions): bool;

    /**
     * Check if role has all of the given permissions
     */
    public function hasAllPermissions(Role $role, array $permissions): bool;
}
