<?php

namespace App\Exceptions\Permissions;

/**
 * Permission Already Exists Exception
 */
class PermissionAlreadyExistsException extends PermissionException
{
    protected $code = 409;

    public function __construct(string $message = 'Permission already exists', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withName(string $name): self
    {
        return new self("Permission '{$name}' already exists");
    }

    public static function withNameAndGuard(string $name, string $guard): self
    {
        return new self("Permission '{$name}' already exists for guard '{$guard}'");
    }
}
