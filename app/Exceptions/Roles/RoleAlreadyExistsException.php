<?php

namespace App\Exceptions\Roles;

class RoleAlreadyExistsException extends RoleException
{
    protected $code = 409;

    public function __construct(string $message = 'Role already exists', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withName(string $name): self
    {
        return new self("Role '{$name}' already exists");
    }

    public static function withNameAndGuard(string $name, string $guard): self
    {
        return new self("Role '{$name}' already exists for guard '{$guard}'");
    }
}
