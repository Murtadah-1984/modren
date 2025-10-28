<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Retrieve;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final readonly class GetPaginatedUsersAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return $this->userRepository->paginate($perPage);
    }
}
