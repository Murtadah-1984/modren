<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Retrieve;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

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
