<?php

namespace App\DTOs\Users;

use App\ValueObjects\Users\Avatar;
use App\ValueObjects\Users\Email;
use App\ValueObjects\Users\Password;
use App\ValueObjects\Users\UserName;

/**
 * UpdateUserDTO - Using Value Objects
 */
readonly class UpdateUserDTO
{
    public function __construct(
        public ?UserName $name = null,
        public ?Email    $email = null,
        public ?Password $password = null,
        public ?bool     $isActive = null,
        public ?array    $roles = null,
        public ?array    $permissions = null,
        public ?Avatar   $avatar = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? UserName::fromString($data['name']) : null,
            email: isset($data['email']) ? Email::fromString($data['email']) : null,
            password: isset($data['password']) ? Password::fromPlainText($data['password']) : null,
            isActive: $data['is_active'] ?? null,
            roles: $data['roles'] ?? null,
            permissions: $data['permissions'] ?? null,
            avatar: isset($data['avatar']) ? Avatar::fromPath($data['avatar']) : null,
        );
    }

    public static function fromRequest(array $data): self
    {
        return self::fromArray($data);
    }

    /**
     * Convert to array for repository (only non-null values)
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->name !== null) {
            $data['name'] = $this->name->getValue();
        }

        if ($this->email !== null) {
            $data['email'] = $this->email;
        }

        if ($this->password !== null) {
            $data['password'] = $this->password->getHashedValue();
        }

        if ($this->isActive !== null) {
            $data['is_active'] = $this->isActive;
        }

        return $data;
    }

    /**
     * Get avatar path for storage
     */
    public function getAvatarPath(): ?string
    {
        return $this->avatar;
    }
}

