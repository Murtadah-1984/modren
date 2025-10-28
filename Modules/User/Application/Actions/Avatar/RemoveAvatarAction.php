<?php

declare(strict_types=1);

namespace Modules\User\Application\Actions\Avatar;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

final readonly class RemoveAvatarAction
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(User $user): User
    {
        // Delete avatar file if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        return $this->userRepository->removeAvatar($user);
    }
}
