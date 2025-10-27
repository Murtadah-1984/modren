<?php

declare(strict_types=1);

namespace App\Actions\User\Retrieve;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class GetUsersWithPermissionAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $permission): Collection
    {
        return $this->userRepository->getUsersWithPermission($permission);
    }
}
