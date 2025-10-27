<?php

declare(strict_types=1);

namespace App\ValueObjects\Users;

use App\Exceptions\Users\InvalidPasswordException;
use JsonSerializable;

/**
 * Password Value Object
 * Immutable value object representing a hashed password
 */
final class Password implements JsonSerializable
{
    private const int MIN_LENGTH = 8;

    private const int MAX_LENGTH = 255;

    private string $hashedValue;

    private function __construct(string $hashedPassword)
    {
        $this->hashedValue = $hashedPassword;
    }

    public static function fromPlainText(mixed $password): Password
    {
        return new self(Password::hash($password));
    }

    public function __toString(): string
    {
        return $this->hashedValue;
    }

    /**
     * Create from plain text password
     * @throws InvalidPasswordException
     */
    public static function fromPlain(string $plainPassword): self
    {
        self::validatePlainPassword($plainPassword);

        return new self(self::hash($plainPassword));
    }

    /**
     * Create from already hashed password
     */
    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    /**
     * Calculate password strength score (0-4)
     */
    public static function calculateStrength(string $password): int
    {
        $strength = 0;

        if (mb_strlen($password) >= 8) {
            $strength++;
        }
        if (mb_strlen($password) >= 12) {
            $strength++;
        }
        if (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
            $strength++;
        }
        if (preg_match('/[0-9]/', $password)) {
            $strength++;
        }
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            $strength++;
        }

        return min($strength, 4);
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }

    public function needsRehash(): bool
    {
        return password_needs_rehash($this->hashedValue, PASSWORD_BCRYPT);
    }

    public function getHash(): string
    {
        return $this->hashedValue;
    }

    public function equals(self $other): bool
    {
        return $this->hashedValue === $other->hashedValue;
    }

    public function jsonSerialize(): string
    {
        return '***HIDDEN***'; // Never expose password hash in JSON
    }

    private static function validatePlainPassword(string $password): void
    {
        if (empty($password)) {
            throw InvalidPasswordException::missingField('password');
        }

        if (mb_strlen($password) < self::MIN_LENGTH) {
            throw InvalidPasswordException::tooShort(self::MIN_LENGTH);
        }

        if (mb_strlen($password) > self::MAX_LENGTH) {
            throw new InvalidPasswordException('Password must not exceed '.self::MAX_LENGTH.' characters');
        }

        // Check password strength
        if (! self::isStrong($password)) {
            throw InvalidPasswordException::tooWeak();
        }
    }

    private static function isStrong(string $password): bool
    {
        // Require at least:
        // - 1 uppercase letter
        // - 1 lowercase letter
        // - 1 number
        // - 1 special character (optional for basic strength)

        $hasUpperCase = preg_match('/[A-Z]/', $password);
        $hasLowerCase = preg_match('/[a-z]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        // $hasSpecialChar = preg_match('/[^A-Za-z0-9]/', $password);

        return $hasUpperCase && $hasLowerCase && $hasNumber;
    }

    private static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function getHashedValue(): string
    {
        return $this->hashedValue;
    }
}
