<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * User Avatar Removed Event
 */
class UserAvatarRemoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user,
        public readonly ?string $oldAvatarPath
    ) {}

    /**
     * Get the old avatar path
     */
    public function getOldAvatarPath(): ?string
    {
        return $this->oldAvatarPath;
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
        return "Avatar removed for user '{$this->user->name}'";
    }
}
