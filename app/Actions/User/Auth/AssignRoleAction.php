<?php

declare(strict_types=1);

namespace App\Actions\User\Auth;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final readonly class AssignRoleAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, array $roles): User
    {
        return $this->userRepository->assignRole($user, $roles);
    }
}
