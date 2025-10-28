<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Events\Permissions;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;

/**
 * Permissions Synced To Role Event
 */
final class PermissionsSyncedToRole
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
        $count = count($this->permissions);

        return "Synced {$count} permission(s) to role '{$this->role->name}'";
    }
}
