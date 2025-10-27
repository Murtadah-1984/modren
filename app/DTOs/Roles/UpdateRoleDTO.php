<?php

namespace App\DTOs\Roles;

use App\ValueObjects\Roles\RoleDescription;
use App\ValueObjects\Roles\RoleName;

/**
 * UpdateRoleDTO - Using Value Objects
 */
readonly class UpdateRoleDTO
{
    public function __construct(
        public ?RoleName        $name = null,
        public ?RoleDescription $description = null,
        public ?array           $permissions = null,
        public ?bool            $allowSystemUpdate = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? RoleName::fromString($data['name']) : null,
            description: isset($data['description'])
                ? RoleDescription::fromString($data['description'])
                : null,
            permissions: $data['permissions'] ?? null,
            allowSystemUpdate: $data['allow_system_update'] ?? false,
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
            $data['name'] = $this->name;
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        return $data;
    }

    /**
     * Check if name is being updated
     */
    public function hasNameUpdate(): bool
    {
        return $this->name !== null;
    }

    /**
     * Check if description is being updated
     */
    public function hasDescriptionUpdate(): bool
    {
        return $this->description !== null;
    }
}
