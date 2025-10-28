<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Retrieve;

use App\Models\User;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

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
