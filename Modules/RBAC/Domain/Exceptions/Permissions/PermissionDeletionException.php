<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Permission Deletion Exception
 */
final class PermissionDeletionException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Cannot delete permission', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function inUse(string $permissionName, int $roleCount, int $userCount): self
    {
        return new self(
            "Cannot delete permission '{$permissionName}' assigned to {$roleCount} role(s) and {$userCount} user(s). ".
            'Remove assignments first or use force delete.'
        );
    }

    public static function isSystem(string $permissionName): self
    {
        return new self("Cannot delete system permission '{$permissionName}'");
    }
}
