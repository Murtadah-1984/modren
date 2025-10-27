<?php

declare(strict_types=1);

namespace App\Actions\User\Retrieve;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

final readonly class FindUserByEmailAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}
