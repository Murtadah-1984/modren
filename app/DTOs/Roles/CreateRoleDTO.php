<?php

namespace App\DTOs\Roles;

use App\ValueObjects\Roles\GuardName;
use App\ValueObjects\Roles\RoleDescription;
use App\ValueObjects\Roles\RoleName;

/**
 * CreateRoleDTO - Using Value Objects
 */
readonly class CreateRoleDTO
{
    public function __construct(
        public RoleName         $name,
        public GuardName        $guardName,
        public ?RoleDescription $description = null,
        public ?bool            $isSystem = false,
        public ?array           $permissions = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: RoleName::fromString($data['name']),
            guardName: isset($data['guard_name'])
                ? GuardName::fromString($data['guard_name'])
                : GuardName::default(),
            description: isset($data['description'])
                ? RoleDescription::fromString($data['description'])
                : null,
            isSystem: $data['is_system'] ?? false,
            permissions: $data['permissions'] ?? null,
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
            'name' => $this->name,
            'guard_name' => $this->guardName,
            'description' => $this->description,
            'is_system' => $this->isSystem,
        ];
    }

    /**
     * Get display name for UI
     */
    public function getDisplayName(): string
    {
        return $this->name->getDisplayName();
    }

    /**
     * Check if this is a system role
     */
    public function isSystemRole(): bool
    {
        return $this->isSystem || $this->name->isSystemRole();
    }
}
