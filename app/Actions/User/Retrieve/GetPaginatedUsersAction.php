<?php

declare(strict_types=1);

namespace App\Actions\User\Retrieve;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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
