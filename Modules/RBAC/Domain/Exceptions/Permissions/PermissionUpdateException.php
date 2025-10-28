<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Permission Update Exception
 */
final class PermissionUpdateException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to update permission', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function nameConflict(string $newName, string $guardName): self
    {
        return new self("Permission name '{$newName}' already exists for guard '{$guardName}'");
    }

    public static function isSystem(string $permissionName): self
    {
        return new self("Cannot update system permission '{$permissionName}'");
    }

    public static function invalidGuard(string $guardName): self
    {
        return new self("Cannot change to invalid guard '{$guardName}'");
    }
}
