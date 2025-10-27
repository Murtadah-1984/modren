<?php

declare(strict_types=1);

namespace App\Actions\User\Avatar;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

final readonly class UpdateAvatarAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, $avatarFile): User
    {
        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $avatarFile->store('avatars', 'public');

        return $this->userRepository->updateAvatar($user, $avatarPath);
    }
}
