<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Auth;

use App\Models\User;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final readonly class SyncRolesAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, array $roles): User
    {
        return $this->userRepository->syncRoles($user, $roles);
    }
}
