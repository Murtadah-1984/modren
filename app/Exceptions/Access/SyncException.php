<?php

namespace App\Exceptions\Access;

/**
 * Sync Exception
 */
class SyncException extends AccessException
{
    protected $code = 400;

    public function __construct(string $message = 'Sync operation failed', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function rolePermissions(string $roleName): self
    {
        return new self("Failed to sync permissions for role '{$roleName}'");
    }

    public static function userRoles(int $userId): self
    {
        return new self("Failed to sync roles for user ID {$userId}");
    }

    public static function userPermissions(int $userId): self
    {
        return new self("Failed to sync permissions for user ID {$userId}");
    }
}
