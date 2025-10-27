<?php

namespace App\Exceptions\Roles;

/**
 * Role Assignment Exception
 */
class RoleAssignmentException extends RoleException
{
    protected $code = 400;

    public function __construct(string $message = 'Cannot assign role', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function toUser(string $roleName, int $userId): self
    {
        return new self("Cannot assign role '{$roleName}' to user ID {$userId}");
    }

    public static function guardMismatch(string $roleName, string $expectedGuard, string $actualGuard): self
    {
        return new self("Role '{$roleName}' guard '{$actualGuard}' does not match expected guard '{$expectedGuard}'");
    }

    public static function insufficientPrivileges(): self
    {
        return new self("Insufficient privileges to assign this role");
    }
}
