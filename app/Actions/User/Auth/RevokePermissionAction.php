<?php

declare(strict_types=1);

namespace App\Actions\User\Auth;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

final readonly class RevokePermissionAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, array $permissions): User
    {
        return $this->userRepository->revokePermission($user, $permissions);
    }
}
