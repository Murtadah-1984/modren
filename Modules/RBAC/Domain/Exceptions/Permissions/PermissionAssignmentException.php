<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Permission Assignment Exception
 */
final class PermissionAssignmentException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Cannot assign permission', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function toRole(string $permissionName, string $roleName): self
    {
        return new self("Cannot assign permission '{$permissionName}' to role '{$roleName}'");
    }

    public static function toUser(string $permissionName, int $userId): self
    {
        return new self("Cannot assign permission '{$permissionName}' to user ID {$userId}");
    }

    public static function guardMismatch(string $permissionName, string $expectedGuard, string $actualGuard): self
    {
        return new self(
            "Permission '{$permissionName}' guard '{$actualGuard}' does not match expected guard '{$expectedGuard}'"
        );
    }
}
