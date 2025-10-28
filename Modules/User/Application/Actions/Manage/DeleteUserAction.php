<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Manage;

use App\Models\User;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final readonly class DeleteUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}
