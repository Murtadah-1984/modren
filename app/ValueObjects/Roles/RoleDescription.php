<?php

declare(strict_types=1);

namespace App\ValueObjects\Roles;

use App\Exceptions\Roles\InvalidRoleDataException;
use JsonSerializable;

/**
 * RoleDescription Value Object
 * Immutable role description representation with validation
 */
final class RoleDescription implements JsonSerializable
{
    private const int MAX_LENGTH = 500;

    public ?string $value {
        get {
            return $this->value;
        }
    }

    public function __construct(?string $description)
    {
        if ($description !== null) {
            $this->validate($description);
        }
        $this->value = $description ? mb_trim($description) : null;
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }

    public static function fromString(?string $description): self
    {
        return new self($description);
    }

    public static function empty(): self
    {
        return new self(null);
    }

    public function isEmpty(): bool
    {
        return $this->value === null || $this->value === '';
    }

    public function getExcerpt(int $length = 100): ?string
    {
        if ($this->value === null) {
            return null;
        }

        if (mb_strlen($this->value) <= $length) {
            return $this->value;
        }

        return mb_substr($this->value, 0, $length).'...';
    }

    public function equals(?self $other): bool
    {
        if ($other === null) {
            return $this->value === null;
        }

        return $this->value === $other->value;
    }

    public function jsonSerialize(): ?string
    {
        return $this->value;
    }

    private function validate(string $description): void
    {
        $description = mb_trim($description);

        $length = mb_strlen($description);

        if ($length > self::MAX_LENGTH) {
            throw InvalidRoleDataException::invalidField(
                'description',
                'must not exceed '.self::MAX_LENGTH.' characters'
            );
        }
    }
}
