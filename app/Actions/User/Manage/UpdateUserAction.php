<?php

declare(strict_types=1);

namespace App\Actions\User\Manage;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;


final readonly class UpdateUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, array $data): User
    {
        return $this->userRepository->update($user, $data);
    }
}
