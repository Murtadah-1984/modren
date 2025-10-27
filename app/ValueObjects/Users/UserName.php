<?php

declare(strict_types=1);

namespace App\ValueObjects\Users;

use App\Exceptions\Users\InvalidUserDataException;
use JsonSerializable;

final class UserName implements JsonSerializable
{
    private string $value;

    public function __construct(string $name)
    {
        $this->validate($name);
        $this->value = mb_trim($name);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getFirstName(): string
    {
        $parts = explode(' ', $this->value);

        return $parts[0];
    }

    public function getLastName(): ?string
    {
        $parts = explode(' ', $this->value);

        return count($parts) > 1 ? end($parts) : null;
    }

    public function getInitials(): string
    {
        $parts = explode(' ', $this->value);
        $initials = '';

        foreach ($parts as $part) {
            if (! empty($part)) {
                $initials .= mb_strtoupper(mb_substr($part, 0, 1));
            }
        }

        return $initials;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    private function validate(string $name): void
    {
        $name = mb_trim($name);

        if (empty($name)) {
            throw InvalidUserDataException::missingField('name');
        }

        if (mb_strlen($name) < 2) {
            throw InvalidUserDataException::invalidField('name', 'must be at least 2 characters long');
        }

        if (mb_strlen($name) > 255) {
            throw InvalidUserDataException::invalidField('name', 'must not exceed 255 characters');
        }

        // Allow letters, spaces, hyphens, and apostrophes
        if (! preg_match("/^[\p{L}\s\-'\.]+$/u", $name)) {
            throw InvalidUserDataException::invalidField('name', 'contains invalid characters');
        }
    }
}
