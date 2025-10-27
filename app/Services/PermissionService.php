<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PermissionRepositoryInterface;
use App\DTOs\Permissions\CreatePermissionDTO;
use App\DTOs\Permissions\UpdatePermissionDTO;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

final readonly class PermissionService
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    /**
     * Get all permissions
     */
    public function getAllPermissions(?string $guardName = null): Collection
    {
        return $this->permissionRepository->all($guardName);
    }

    /**
     * Search permissions
     */
    public function searchPermissions(string $query, ?string $guardName = null): Collection
    {
        return $this->permissionRepository->search($query, $guardName);
    }

    /**
     * Find permission by ID
     */
    public function findPermissionById(int $id, ?string $guardName = null): Permission
    {
        return $this->permissionRepository->findById($id, $guardName);
    }

    /**
     * Find permission by name
     */
    public function findPermissionByName(string $name, ?string $guardName = null): Permission
    {
        return $this->permissionRepository->findByName($name, $guardName);
    }

    /**
     * Create a new permission
     */
    public function createPermission(CreatePermissionDTO $dto): Permission
    {
        return $this->permissionRepository->create($dto->toArray());
    }

    /**
     * Update an existing permission
     */
    public function updatePermission(int $id, UpdatePermissionDTO $dto, ?string $guardName = null): Permission
    {
        $permission = $this->permissionRepository->findById($id, $guardName);

        return $this->permissionRepository->update($permission, $dto->toArray());
    }

    /**
     * Delete a permission
     */
    public function deletePermission(int $id, ?string $guardName = null): bool
    {
        $permission = $this->permissionRepository->findById($id, $guardName);

        return $this->permissionRepository->delete($permission);
    }

    /**
     * Get permissions by role
     */
    public function getPermissionsByRole(string $roleName, ?string $guardName = null): Collection
    {
        return $this->permissionRepository->getPermissionsByRole($roleName, $guardName);
    }

    /**
     * Get permissions by guard
     */
    public function getPermissionsByGuard(string $guardName): Collection
    {
        return $this->permissionRepository->getByGuard($guardName);
    }

    /**
     * Get all guard names
     */
    public function getAllGuards(): Collection
    {
        return $this->permissionRepository->getAllGuardNames();
    }

    /**
     * Check if permission exists
     */
    public function permissionExists(string $name, ?string $guardName = null): bool
    {
        return $this->permissionRepository->exists($name, $guardName);
    }

    /**
     * Find or create permission
     */
    public function findOrCreate(string $name, ?string $guardName = null): Permission
    {
        return $this->permissionRepository->findOrCreate($name, $guardName);
    }
}
