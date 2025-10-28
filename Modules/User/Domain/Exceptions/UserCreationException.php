<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

/**
 * User Creation Exception
 */
final class UserCreationException extends UserException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to create user', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function emailExists(string $email): self
    {
        return new self("User with email '{$email}' already exists");
    }

    public static function invalidEmail(string $email): self
    {
        return new self("Invalid email address '{$email}'");
    }

    public static function weakPassword(): self
    {
        return new self('Password does not meet security requirements');
    }

    public static function invalidRole(string $roleName): self
    {
        return new self("Invalid role '{$roleName}'");
    }

    public static function missingRequiredFields(array $fields): self
    {
        $fieldList = implode(', ', $fields);

        return new self("Missing required fields: {$fieldList}");
    }
}
