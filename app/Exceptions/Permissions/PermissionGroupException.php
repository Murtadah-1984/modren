<?php

namespace App\Exceptions\Permissions;

/**
 * Permission Group Exception
 */
class PermissionGroupException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Permission group error', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function notFound(string $groupName): self
    {
        return new self("Permission group '{$groupName}' not found");
    }

    public static function invalid(string $groupName): self
    {
        return new self("Permission group '{$groupName}' is invalid");
    }
}
