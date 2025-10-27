<?php

declare(strict_types=1);

namespace App\Actions\User\Retrieve;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class GetUsersByRoleAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $roleName): Collection
    {
        return $this->userRepository->getUsersByRole($roleName);
    }
}
