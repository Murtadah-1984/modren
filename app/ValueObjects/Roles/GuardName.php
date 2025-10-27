<?php

declare(strict_types=1);

namespace App\ValueObjects\Roles;

use App\Exceptions\Permissions\GuardNotFoundException;
use JsonSerializable;

/**
 * GuardName Value Object
 * Immutable guard name representation with validation
 */
final class GuardName implements JsonSerializable
{
    private const array VALID_GUARDS = ['web', 'api', 'admin'];

    private const string DEFAULT_GUARD = 'web';

    public string $value {
        get {
            return $this->value;
        }
    }

    public function __construct(string $guardName)
    {
        $this->validate($guardName);
        $this->value = mb_strtolower(mb_trim($guardName));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $guardName): self
    {
        return new self($guardName);
    }

    public static function default(): self
    {
        return new self(self::DEFAULT_GUARD);
    }

    public static function web(): self
    {
        return new self('web');
    }

    public static function api(): self
    {
        return new self('api');
    }

    public static function admin(): self
    {
        return new self('admin');
    }

    /**
     * Get all valid guards
     */
    public static function validGuards(): array
    {
        return self::VALID_GUARDS;
    }

    public function isWeb(): bool
    {
        return $this->value === 'web';
    }

    public function isApi(): bool
    {
        return $this->value === 'api';
    }

    public function isAdmin(): bool
    {
        return $this->value === 'admin';
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
     * @throws GuardNotFoundException
     */
    private function validate(string $guardName): void
    {
        $guardName = mb_strtolower(mb_trim($guardName));

        if (empty($guardName)) {
            throw GuardNotFoundException::withName($guardName);
        }

        // Check if guard is in the list of valid guards
        if (! in_array($guardName, self::VALID_GUARDS)) {
            throw GuardNotFoundException::withName($guardName);
        }
    }
}
