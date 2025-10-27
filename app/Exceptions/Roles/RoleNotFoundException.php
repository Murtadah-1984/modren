<?php

namespace App\Exceptions\Roles;

class RoleNotFoundException extends RoleException
{
    protected $code = 404;

    public function __construct(string $message = 'Role not found', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withId(int $id): self
    {
        return new self("Role with ID {$id} not found");
    }

    public static function withName(string $name): self
    {
        return new self("Role '{$name}' not found");
    }

    public static function withNameAndGuard(string $name, string $guard): self
    {
        return new self("Role '{$name}' not found for guard '{$guard}'");
    }
}
