<?php

declare(strict_types=1);

namespace App\Actions\User\Auth;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

final readonly class SyncRolesAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, array $roles): User
    {
        return $this->userRepository->syncRoles($user, $roles);
    }
}
