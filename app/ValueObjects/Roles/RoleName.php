<?php

declare(strict_types=1);

namespace App\ValueObjects\Roles;

use App\Exceptions\Roles\InvalidRoleDataException;
use JsonSerializable;

/**
 * RoleName Value Object
 * Immutable role name representation with validation
 */
final class RoleName implements JsonSerializable
{
    private const int MIN_LENGTH = 2;

    private const int MAX_LENGTH = 50;

    public string $value {
        get {
            return $this->value;
        }
    }

    /**
     * @throws InvalidRoleDataException
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

    public function getDisplayName(): string
    {
        // Convert 'super-admin' to 'Super Admin'
        return ucwords(str_replace(['-', '_'], ' ', $this->value));
    }

    public function isSystemRole(): bool
    {
        $systemRoles = ['super-admin', 'admin', 'system'];

        return in_array($this->value, $systemRoles);
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
     * @throws InvalidRoleDataException
     */
    private function validate(string $name): void
    {
        $name = mb_trim($name);

        if (empty($name)) {
            throw InvalidRoleDataException::missingField('name');
        }

        $length = mb_strlen($name);

        if ($length < self::MIN_LENGTH) {
            throw InvalidRoleDataException::invalidField(
                'name',
                'must be at least '.self::MIN_LENGTH.' characters'
            );
        }

        if ($length > self::MAX_LENGTH) {
            throw InvalidRoleDataException::invalidField(
                'name',
                'must not exceed '.self::MAX_LENGTH.' characters'
            );
        }

        // Role names should only contain lowercase letters, numbers, hyphens, and underscores
        if (! preg_match('/^[a-z0-9\-_]+$/', mb_strtolower($name))) {
            throw InvalidRoleDataException::invalidName($name);
        }

        // Should not start or end with hyphen or underscore
        if (preg_match('/^[\-_]|[\-_]$/', $name)) {
            throw InvalidRoleDataException::invalidField(
                'name',
                'cannot start or end with hyphen or underscore'
            );
        }
    }
}
