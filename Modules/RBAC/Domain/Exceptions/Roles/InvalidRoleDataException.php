<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Roles;

use Throwable;

/**
 * Invalid Role Data Exception
 */
final class InvalidRoleDataException extends RoleException
{
    protected $code = 422;

    public function __construct(string $message = 'Invalid role data provided', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function missingField(string $field): self
    {
        return new self("Required field '{$field}' is missing");
    }

    public static function invalidField(string $field, string $reason): self
    {
        return new self("Field '{$field}' is invalid: {$reason}");
    }

    public static function invalidName(string $name): self
    {
        return new self("Role name '{$name}' is invalid. Only alphanumeric characters, dashes, and underscores allowed");
    }
}
