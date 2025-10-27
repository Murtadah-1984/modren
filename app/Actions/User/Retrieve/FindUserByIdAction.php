<?php

declare(strict_types=1);

namespace App\Actions\User\Retrieve;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

final readonly class FindUserByIdAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $id): User
    {
        return $this->userRepository->findById($id);
    }
}
