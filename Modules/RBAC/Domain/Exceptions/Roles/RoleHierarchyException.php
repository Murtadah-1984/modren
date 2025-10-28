<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Roles;

use Throwable;

/**
 * Role Hierarchy Exception
 */
final class RoleHierarchyException extends RoleException
{
    protected $code = 403;

    public function __construct(string $message = 'Role hierarchy violation', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function cannotAssignHigherRole(string $userRole, string $targetRole): self
    {
        return new self("Role '{$userRole}' cannot assign higher role '{$targetRole}'");
    }

    public static function cannotModifyHigherRole(string $userRole, string $targetRole): self
    {
        return new self("Role '{$userRole}' cannot modify higher role '{$targetRole}'");
    }
}
