<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Throwable;

/**
 * Invalid Permission Data Exception
 */
final class InvalidPermissionDataException extends PermissionException
{
    protected $code = 422;

    public function __construct(string $message = 'Invalid permission data provided', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function missingField(string $field): self
    {
        return new self("Required field '{$field}' is missing");
    }

    public static function invalidField(string $field, string $reason): self
    {
        return new self("Field '{$field}' is invalid: {$reason}");
    }

    public static function invalidName(string $name): self
    {
        return new self("Permission name '{$name}' is invalid. Use format: action-resource (e.g., view-posts)");
    }
}
