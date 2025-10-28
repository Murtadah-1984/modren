<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class UserPermissionException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'old does not have required permission', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function missing(string $permission): self
    {
        return new self("old does not have '{$permission}' permission");
    }

    public static function cannotAssign(string $permission): self
    {
        return new self("Cannot assign '{$permission}' permission to user");
    }
}
