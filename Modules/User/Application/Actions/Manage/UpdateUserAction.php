<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Manage;

use App\Models\User;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final readonly class UpdateUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, array $data): User
    {
        return $this->userRepository->update($user, $data);
    }
}
