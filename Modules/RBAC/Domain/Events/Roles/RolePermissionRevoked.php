<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Events\Roles;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;

/**
 * Role Permission Revoked Event
 */
final class RolePermissionRevoked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Role $role,
        public readonly array $permissions
    ) {}

    /**
     * Get the permission names
     */
    public function getPermissionNames(): array
    {
        return $this->permissions;
    }

    /**
     * Get the role name
     */
    public function getRoleName(): string
    {
        return $this->role->name;
    }

    /**
     * Get event description
     */
    public function getDescription(): string
    {
        $permissionList = implode(', ', $this->permissions);

        return "Revoked permission(s) [{$permissionList}] from role '{$this->role->name}'";
    }
}
