<?php

declare(strict_types=1);

namespace App\Actions\User\Manage;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

final readonly class UpdatePasswordAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, string $password): User
    {
        return $this->userRepository->update($user, ['password' => $password]);
    }
}
