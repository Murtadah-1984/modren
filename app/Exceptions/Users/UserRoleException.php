<?php

namespace App\Exceptions\Users;

class UserRoleException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'User role error', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function cannotAssign(string $role): self
    {
        return new self("Cannot assign '{$role}' role to user");
    }

    public static function cannotRemove(string $role): self
    {
        return new self("Cannot remove '{$role}' role from user");
    }

    public static function systemRole(): self
    {
        return new self("Cannot modify system role assignment");
    }
}
