<?php

namespace App\DTOs\Permissions;

use App\ValueObjects\Permissions\PermissionName;

/**
 * UpdatePermissionDTO - Using Value Objects
 */
readonly class UpdatePermissionDTO
{
    public function __construct(
        public ?PermissionName $name = null,
        public ?string         $description = null,
        public ?string         $group = null,
        public ?array          $roles = null,
        public ?bool           $allowSystemUpdate = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? PermissionName::fromString($data['name']) : null,
            description: $data['description'] ?? null,
            group: $data['group'] ?? null,
            roles: $data['roles'] ?? null,
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

        if ($this->group !== null) {
            $data['group'] = $this->group;
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

    /**
     * Check if group is being updated
     */
    public function hasGroupUpdate(): bool
    {
        return $this->group !== null;
    }
}
