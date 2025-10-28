<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class InvalidUserDataException extends UserException
{
    protected $code = 422;

    public function __construct(string $message = 'Invalid user data provided', ?Throwable $previous = null)
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
}
