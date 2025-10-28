<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Retrieve;

use App\Models\User;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

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
