<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Retrieve;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

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
