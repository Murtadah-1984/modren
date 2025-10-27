<?php

namespace App\ValueObjects\Users;

use App\Exceptions\Users\InvalidEmailException;
use JsonSerializable;

/**
 * Email Value Object
 * Immutable value object representing a valid email address
 */
final class Email implements JsonSerializable
{
    public string $value {
        get {
            return $this->value;
        }
    }

    /**
     * @throws InvalidEmailException
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = strtolower(trim($email));
    }

    /**
     * @throws InvalidEmailException
     */
    private function validate(string $email): void
    {
        $email = trim($email);

        if (empty($email)) {
            throw InvalidEmailException::format('Email cannot be empty');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::format($email);
        }

        // Check for valid domain
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            throw InvalidEmailException::format($email);
        }

        $domain = $parts[1];

        // Check if domain has valid format
        if (!preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/', $domain)) {
            throw InvalidEmailException::domain($email);
        }
    }

    public function getDomain(): string
    {
        return explode('@', $this->value)[1];
    }

    public function getLocalPart(): string
    {
        return explode('@', $this->value)[0];
    }

    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }
}

