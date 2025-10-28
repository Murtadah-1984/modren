<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Permission Group Exception
 */
final class PermissionGroupException extends PermissionException
{
    protected $code = 400;

    public function __construct(string $message = 'Permission group error', ?Throwable $previous = null)
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
