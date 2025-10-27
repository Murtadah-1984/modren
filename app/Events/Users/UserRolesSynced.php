<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * User Roles Synced Event
 */
class UserRolesSynced
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user,
        public readonly array $roles
    ) {}

    /**
     * Get the role names
     */
    public function getRoleNames(): array
    {
        return $this->roles;
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
        $count = count($this->roles);
        return "Synced {$count} role(s) for user '{$this->user->name}'";
    }
}
