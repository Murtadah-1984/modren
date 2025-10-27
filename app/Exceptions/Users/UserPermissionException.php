<?php

namespace App\Exceptions\Users;

class UserPermissionException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'User does not have required permission', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function missing(string $permission): self
    {
        return new self("User does not have '{$permission}' permission");
    }

    public static function cannotAssign(string $permission): self
    {
        return new self("Cannot assign '{$permission}' permission to user");
    }
}
