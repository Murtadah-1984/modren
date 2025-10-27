<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * User Permission Given Event
 */
class UserPermissionGiven
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user,
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
     * Get the user name
     */
    public function getUserName(): string
    {
        return $this->user->name;
    }

    /**
     * Get event description
     */
    public function getDescription(): string
    {
        $permissionList = implode(', ', $this->permissions);
        return "Permission(s) [{$permissionList}] given to user '{$this->user->name}'";
    }
}
