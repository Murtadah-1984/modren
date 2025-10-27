<?php

declare(strict_types=1);

namespace App\DTOs\Users;

use App\ValueObjects\Users\Avatar;
use App\ValueObjects\Users\Email;
use App\ValueObjects\Users\Password;
use App\ValueObjects\Users\UserName;

/**
 * CreateUserDTO - Using Value Objects
 */
final readonly class CreateUserDTO
{
    public function __construct(
        public UserName $name,
        public Email $email,
        public Password $password,
        public ?bool $emailVerified = false,
        public ?bool $isActive = true,
        public ?array $roles = null,
        public ?array $permissions = null,
        public ?array $profileData = null,
        public ?Avatar $avatar = null,
    ) {}

    public static function fromArray(array  $data): self
    {
        return new self(
            name: UserName::fromString($data['name']),
            email: Email::fromString($data['email']),
            password: Password::fromPlainText($data['password']),
            emailVerified: $data['email_verified'] ?? false,
            isActive: $data['is_active'] ?? true,
            roles: $data['roles'] ?? null,
            permissions: $data['permissions'] ?? null,
            profileData: $data['profile'] ?? null,
            avatar: isset($data['avatar']) ? Avatar::fromPath($data['avatar']) : null,
        );
    }

    public static function fromRequest(array $data): self
    {
        return self::fromArray($data);
    }

    /**
     * Convert to array for repository
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->getValue(),
            'email' => $this->email,
            'password' => $this->password->getHashedValue(),
            'email_verified_at' => $this->emailVerified ? now() : null,
            'is_active' => $this->isActive,
        ];
    }

    /**
     * Get avatar path for storage
     */
    public function getAvatarPath(): ?string
    {
        return $this->avatar;
    }

    public function hasRoles(): bool
    {
        return $this->roles !== null;
    }

    public function hasPermissions(): bool
    {
        return $this->roles !== null;
    }
}
