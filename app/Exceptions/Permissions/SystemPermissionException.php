<?php

namespace App\Exceptions\Permissions;

/**
 * System Permission Exception
 */
class SystemPermissionException extends PermissionException
{
    protected $code = 403;

    public function __construct(string $message = 'Cannot modify system permission', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function cannotUpdate(string $permissionName): self
    {
        return new self("Cannot update system permission '{$permissionName}'");
    }

    public static function cannotDelete(string $permissionName): self
    {
        return new self("Cannot delete system permission '{$permissionName}'");
    }

    public static function cannotModify(string $permissionName): self
    {
        return new self("Cannot modify system permission '{$permissionName}'");
    }
}
