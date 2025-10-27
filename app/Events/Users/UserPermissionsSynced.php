<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * User Permissions Synced Event
 */
class UserPermissionsSynced
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
        $count = count($this->permissions);
        return "Synced {$count} permission(s) for user '{$this->user->name}'";
    }
}
