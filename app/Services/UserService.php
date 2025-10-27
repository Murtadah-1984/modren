<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\DTOs\Users\CreateUserDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

final readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Get all users
     */
    public function getAllUsers(array $relations = []): Collection
    {
        return $this->userRepository->all($relations);
    }

    /**
     * Get paginated users
     */
    public function getPaginatedUsers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->paginate($perPage);
    }

    /**
     * Search users
     */
    public function searchUsers(string $query): Collection
    {
        return $this->userRepository->search($query);
    }

    /**
     * Find user by ID
     */
    public function findUserById(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Find user by email
     */
    public function findUserByEmail(string $email): User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Create a new user
     */
    public function createUser(CreateUserDTO $dto): User
    {
        // Create user
        $user = $this->userRepository->create($dto->toArray());

        // Assign roles if provided
        if ($dto->hasRoles()) {
            $this->userRepository->assignRole($user, $dto->getRoles());
        }

        // Give permissions if provided
        if ($dto->hasPermissions()) {
            $this->userRepository->givePermission($user, $dto->getPermissions());
        }

        return $user->fresh(['roles', 'permissions']);
    }

    /**
     * Update an existing user
     */
    public function updateUser(int $id, UpdateUserDTO $dto): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->update($user, $dto->toArray());
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->userRepository->findById($id);

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        return $this->userRepository->delete($user);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $id, string $password): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->updatePassword($user, $password);
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(int $id, $avatarFile): User
    {
        $user = $this->userRepository->findById($id);

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $avatarFile->store('avatars', 'public');

        return $this->userRepository->updateAvatar($user, $avatarPath);
    }

    /**
     * Remove user avatar
     */
    public function removeAvatar(int $id): User
    {
        $user = $this->userRepository->findById($id);

        // Delete avatar file if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        return $this->userRepository->removeAvatar($user);
    }

    /**
     * Assign role(s) to user
     */
    public function assignRole(int $id, array $roles): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->assignRole($user, $roles);
    }

    /**
     * Remove role(s) from user
     */
    public function removeRole(int $id, array $roles): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->removeRole($user, $roles);
    }

    /**
     * Sync user roles
     */
    public function syncRoles(int $id, array $roles): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->syncRoles($user, $roles);
    }

    /**
     * Give permission(s) to user
     */
    public function givePermission(int $id, array $permissions): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->givePermission($user, $permissions);
    }

    /**
     * Revoke permission(s) from user
     */
    public function revokePermission(int $id, array $permissions): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->revokePermission($user, $permissions);
    }

    /**
     * Sync user permissions
     */
    public function syncPermissions(int $id, array $permissions): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->syncPermissions($user, $permissions);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName): Collection
    {
        return $this->userRepository->getUsersByRole($roleName);
    }

    /**
     * Get users with specific permission
     */
    public function getUsersWithPermission(string $permissionName): Collection
    {
        return $this->userRepository->getUsersWithPermission($permissionName);
    }
}
