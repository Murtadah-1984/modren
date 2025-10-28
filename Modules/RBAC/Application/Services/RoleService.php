<?php

declare(strict_types=1);

namespace Modules\RBAC\Application\Services;

use App\DTOs\Roles\CreateRoleDTO;
use App\DTOs\Roles\UpdateRoleDTO;
use Illuminate\Database\Eloquent\Collection;
use Modules\RBAC\Domain\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

final readonly class RoleService
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {}

    /**
     * Get all roles
     */
    public function getAllRoles(?string $guardName = null): Collection
    {
        return $this->roleRepository->all($guardName);
    }

    /**
     * Search roles
     */
    public function searchRoles(string $query, ?string $guardName = null): Collection
    {
        return $this->roleRepository->search($query, $guardName);
    }

    /**
     * Find role by ID
     */
    public function findRoleById(int $id, ?string $guardName = null): Role
    {
        return $this->roleRepository->findById($id, $guardName);
    }

    /**
     * Find role by name
     */
    public function findRoleByName(string $name, ?string $guardName = null): Role
    {
        return $this->roleRepository->findByName($name, $guardName);
    }

    /**
     * Create a new role
     */
    public function createRole(CreateRoleDTO $dto): Role
    {
        // Create role
        $role = $this->roleRepository->create($dto->toArray());

        // Assign permissions if provided
        if ($dto->hasPermissions()) {
            $this->roleRepository->syncPermissions($role, $dto->getPermissions());
        }

        return $role->fresh(['permissions']);
    }

    /**
     * Update an existing role
     */
    public function updateRole(int $id, UpdateRoleDTO $dto, ?string $guardName = null): Role
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->update($role, $dto->toArray());
    }

    /**
     * Delete a role
     */
    public function deleteRole(int $id, ?string $guardName = null): bool
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->delete($role);
    }

    /**
     * Give permission(s) to role
     */
    public function givePermission(int $id, array $permissions, ?string $guardName = null): Role
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->givePermissionTo($role, $permissions);
    }

    /**
     * Revoke permission(s) from role
     */
    public function revokePermission(int $id, array $permissions, ?string $guardName = null): Role
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->revokePermissionTo($role, $permissions);
    }

    /**
     * Sync permissions to role
     */
    public function syncPermissions(int $id, array $permissions, ?string $guardName = null): Role
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->syncPermissions($role, $permissions);
    }

    /**
     * Get all permissions for a role
     */
    public function getRolePermissions(int $id, ?string $guardName = null): Collection
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->getPermissions($role);
    }

    /**
     * Get all users with this role
     */
    public function getRoleUsers(int $id, ?string $guardName = null): Collection
    {
        $role = $this->roleRepository->findById($id, $guardName);

        return $this->roleRepository->getUsersWithRole($role);
    }

    /**
     * Get roles by guard
     */
    public function getRolesByGuard(string $guardName): Collection
    {
        return $this->roleRepository->getByGuard($guardName);
    }

    /**
     * Get all guard names
     */
    public function getAllGuards(): Collection
    {
        return $this->roleRepository->getAllGuardNames();
    }

    /**
     * Check if role exists
     */
    public function roleExists(string $name, ?string $guardName = null): bool
    {
        return $this->roleRepository->exists($name, $guardName);
    }
}
