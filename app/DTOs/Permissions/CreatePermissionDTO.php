<?php

namespace App\DTOs\Permissions;

use App\ValueObjects\Permissions\PermissionName;
use App\ValueObjects\Roles\GuardName;

/**
 * CreatePermissionDTO - Using Value Objects
 */
readonly class CreatePermissionDTO
{
    public function __construct(
        public PermissionName $name,
        public GuardName      $guardName,
        public ?string        $description = null,
        public ?string        $group = null,
        public ?bool          $isSystem = false,
        public ?array         $roles = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: PermissionName::fromString($data['name']),
            guardName: isset($data['guard_name'])
                ? GuardName::fromString($data['guard_name'])
                : GuardName::default(),
            description: $data['description'] ?? null,
            group: $data['group'] ?? null,
            isSystem: $data['is_system'] ?? false,
            roles: $data['roles'] ?? null,
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
            'group' => $this->group,
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
     * Get action from permission name
     */
    public function getAction(): string
    {
        return $this->name->getAction();
    }

    /**
     * Get resource from permission name
     */
    public function getResource(): string
    {
        return $this->name->getResource();
    }

    /**
     * Check if this is a system permission
     */
    public function isSystemPermission(): bool
    {
        return $this->isSystem || $this->name->isSystemPermission();
    }

    /**
     * Check if this is a CRUD permission
     */
    public function isCrudPermission(): bool
    {
        return $this->name->isCrudPermission();
    }
}
