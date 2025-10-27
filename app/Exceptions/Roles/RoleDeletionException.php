<?php

namespace App\Exceptions\Roles;

/**
 * Role Deletion Exception
 */
class RoleDeletionException extends RoleException
{
    protected $code = 400;

    public function __construct(string $message = 'Cannot delete role', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function hasUsers(string $roleName, int $userCount): self
    {
        return new self("Cannot delete role '{$roleName}' assigned to {$userCount} user(s). Remove users first or use force delete.");
    }

    public static function isSystem(string $roleName): self
    {
        return new self("Cannot delete system role '{$roleName}'");
    }
}
