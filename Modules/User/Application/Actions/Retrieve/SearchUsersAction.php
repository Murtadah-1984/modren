<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Retrieve;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final readonly class SearchUsersAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $query): Collection
    {
        return $this->userRepository->search($query);
    }
}
