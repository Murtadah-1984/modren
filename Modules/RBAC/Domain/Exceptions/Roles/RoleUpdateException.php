<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Roles;

use Throwable;

/**
 * Role Update Exception
 */
final class RoleUpdateException extends RoleException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to update role', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function nameConflict(string $newName, string $guardName): self
    {
        return new self("Role name '{$newName}' already exists for guard '{$guardName}'");
    }

    public static function isSystem(string $roleName): self
    {
        return new self("Cannot update system role '{$roleName}'");
    }

    public static function invalidGuard(string $guardName): self
    {
        return new self("Cannot change to invalid guard '{$guardName}'");
    }

    public static function invalidPermissions(array $permissions): self
    {
        $permissionList = implode(', ', $permissions);

        return new self("Invalid permissions: {$permissionList}");
    }

    public static function permissionNotFound(string $permissionName): self
    {
        return new self("Permission '{$permissionName}' not found");
    }
}
