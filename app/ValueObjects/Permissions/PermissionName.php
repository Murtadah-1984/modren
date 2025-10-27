<?php

declare(strict_types=1);

namespace App\ValueObjects\Permissions;

use App\Exceptions\Permissions\InvalidPermissionDataException;
use JsonSerializable;

/**
 * PermissionName Value Object
 * Immutable permission name representation with validation
 */
final class PermissionName implements JsonSerializable
{
    private const int MIN_LENGTH = 3;

    private const int MAX_LENGTH = 100;

    public string $value {
        get {
            return $this->value;
        }
    }

    /**
     * @throws InvalidPermissionDataException
     */
    public function __construct(string $name)
    {
        $this->validate($name);
        $this->value = mb_strtolower(mb_trim($name));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public static function create(string $action, string $resource): self
    {
        return new self($action.'-'.$resource);
    }

    public function getAction(): string
    {
        $parts = explode('-', $this->value);

        return $parts[0];
    }

    public function getResource(): string
    {
        $parts = explode('-', $this->value);
        array_shift($parts); // Remove action

        return implode('-', $parts);
    }

    public function getDisplayName(): string
    {
        // Convert 'view-posts' to 'View Posts'
        return ucwords(str_replace('-', ' ', $this->value));
    }

    public function isSystemPermission(): bool
    {
        $systemPermissions = [
            'super-admin-access',
            'access-admin-panel',
            'manage-system-settings',
        ];

        return in_array($this->value, $systemPermissions);
    }

    public function isCrudPermission(): bool
    {
        $crudActions = ['view', 'create', 'update', 'edit', 'delete', 'restore'];

        return in_array($this->getAction(), $crudActions);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidPermissionDataException
     */
    private function validate(string $name): void
    {
        $name = mb_trim($name);

        if (empty($name)) {
            throw InvalidPermissionDataException::missingField('name');
        }

        $length = mb_strlen($name);

        if ($length < self::MIN_LENGTH) {
            throw InvalidPermissionDataException::invalidField(
                'name',
                'must be at least '.self::MIN_LENGTH.' characters'
            );
        }

        if ($length > self::MAX_LENGTH) {
            throw InvalidPermissionDataException::invalidField(
                'name',
                'must not exceed '.self::MAX_LENGTH.' characters'
            );
        }

        // Permission names should follow format: action-resource (e.g., view-posts, edit-users)
        if (! preg_match('/^[a-z0-9]+\-[a-z0-9\-]+$/', mb_strtolower($name))) {
            throw InvalidPermissionDataException::invalidName($name);
        }
    }
}
