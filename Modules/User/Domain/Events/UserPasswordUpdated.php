<?php

declare(strict_types=1);

namespace Modules\User\Domain\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * User Password Updated Event
 */
final class UserPasswordUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user
    ) {}

    /**
     * Get the user name
     */
    public function getUserName(): string
    {
        return $this->user->name;
    }

    /**
     * Get the user email
     */
    public function getUserEmail(): string
    {
        return $this->user->email;
    }

    /**
     * Get event description
     */
    public function getDescription(): string
    {
        return "Password updated for user '{$this->user->name}'";
    }
}
