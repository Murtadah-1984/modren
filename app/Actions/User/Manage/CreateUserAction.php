<?php

declare(strict_types=1);

namespace App\Actions\User\Manage;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

final readonly class CreateUserAction
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(array $data): User
    {
        return $this->userRepository->create($data);
    }
}
