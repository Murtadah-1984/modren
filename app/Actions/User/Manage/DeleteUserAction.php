<?php

declare(strict_types=1);

namespace App\Actions\User\Manage;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

final readonly class DeleteUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}
