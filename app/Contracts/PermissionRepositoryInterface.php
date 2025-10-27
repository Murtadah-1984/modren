<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    /**
     * Find a permission by ID
     */
    public function findById(int $id, ?string $guardName = null): ?Permission;

    /**
     * Find a permission by name
     */
    public function findByName(string $name, ?string $guardName = null): ?Permission;

    /**
     * Get all permissions
     */
    public function all(?string $guardName = null): Collection;

    /**
     * Create a new permission
     */
    public function create(array $data): Permission;

    /**
     * Create a permission by name
     */
    public function createByName(string $name, ?string $guardName = null): Permission;

    /**
     * Update an existing permission
     */
    public function update(Permission $permission, array $data): Permission;

    /**
     * Delete a permission
     */
    public function delete(Permission $permission): bool;

    /**
     * Get permissions by guard name
     */
    public function getByGuard(string $guardName): Collection;

    /**
     * Get permissions for a specific role
     */
    public function getPermissionsByRole(string $roleName, ?string $guardName = null): Collection;

    /**
     * Find or create a permission
     */
    public function findOrCreate(string $name, ?string $guardName = null): Permission;

    /**
     * Check if permission exists
     */
    public function exists(string $name, ?string $guardName = null): bool;

    /**
     * Get permissions by names
     */
    public function getByNames(array $names, ?string $guardName = null): Collection;

    /**
     * Sync permissions to a role
     */
    public function syncToRole(string $roleName, array $permissions, ?string $guardName = null): void;

    /**
     * Get all guard names
     */
    public function getAllGuardNames(): Collection;

    /**
     * Search permissions by name
     */
    public function search(string $query, ?string $guardName = null): Collection;
}
