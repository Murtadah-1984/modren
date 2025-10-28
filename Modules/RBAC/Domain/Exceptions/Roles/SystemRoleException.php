<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Roles;

use Throwable;

/**
 * System Role Exception
 */
final class SystemRoleException extends RoleException
{
    protected $code = 403;

    public function __construct(string $message = 'Cannot modify system role', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function cannotUpdate(string $roleName): self
    {
        return new self("Cannot update system role '{$roleName}'");
    }

    public static function cannotDelete(string $roleName): self
    {
        return new self("Cannot delete system role '{$roleName}'");
    }

    public static function cannotModify(string $roleName): self
    {
        return new self("Cannot modify system role '{$roleName}'");
    }
}
