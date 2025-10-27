<?php

namespace App\Exceptions\Permissions;

/**
 * Permission Dependency Exception
 */
class PermissionDependencyException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Permission dependency error', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function missing(string $permission, array $requiredPermissions): self
    {
        $required = implode(', ', $requiredPermissions);
        return new self("Permission '{$permission}' requires the following permissions: {$required}");
    }

    public static function circular(string $permission1, string $permission2): self
    {
        return new self("Circular dependency detected between '{$permission1}' and '{$permission2}'");
    }
}
