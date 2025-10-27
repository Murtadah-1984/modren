<?php

namespace App\Exceptions\Roles;

/**
 * Role Creation Exception
 */
class RoleCreationException extends RoleException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to create role', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function alreadyExists(string $roleName, string $guardName): self
    {
        return new self("Role '{$roleName}' already exists for guard '{$guardName}'");
    }

    public static function invalidGuard(string $guardName): self
    {
        return new self("Invalid guard name '{$guardName}'");
    }

    public static function invalidName(string $roleName): self
    {
        return new self("Invalid role name '{$roleName}'");
    }

    public static function invalidPermissions(array $permissions): self
    {
        $permissionList = implode(', ', $permissions);
        return new self("Invalid permissions: {$permissionList}");
    }
}
