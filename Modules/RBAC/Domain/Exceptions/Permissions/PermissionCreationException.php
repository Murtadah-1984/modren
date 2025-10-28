<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Permission Creation Exception
 */
final class PermissionCreationException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to create permission', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function alreadyExists(string $permissionName, string $guardName): self
    {
        return new self("Permission '{$permissionName}' already exists for guard '{$guardName}'");
    }

    public static function invalidGuard(string $guardName): self
    {
        return new self("Invalid guard name '{$guardName}'");
    }

    public static function invalidName(string $permissionName): self
    {
        return new self("Invalid permission name '{$permissionName}'");
    }
}
