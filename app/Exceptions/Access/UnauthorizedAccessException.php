<?php

namespace App\Exceptions\Access;

/**
 * Unauthorized Access Exception
 */
class UnauthorizedAccessException extends AccessException
{
    protected $code = 403;

    public function __construct(string $message = 'Unauthorized access', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function missingPermission(string $permission): self
    {
        return new self("Missing required permission: {$permission}");
    }

    public static function missingRole(string $role): self
    {
        return new self("Missing required role: {$role}");
    }

    public static function insufficientPrivileges(): self
    {
        return new self("Insufficient privileges to perform this action");
    }
}
