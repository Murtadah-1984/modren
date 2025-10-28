<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Permission Not Found Exception
 */
final class PermissionNotFoundException extends PermissionException
{
    protected $code = 404;

    public function __construct(string $message = 'Permission not found', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withId(int $id): self
    {
        return new self("Permission with ID {$id} not found");
    }

    public static function withName(string $name): self
    {
        return new self("Permission '{$name}' not found");
    }

    public static function withNameAndGuard(string $name, string $guard): self
    {
        return new self("Permission '{$name}' not found for guard '{$guard}'");
    }
}
