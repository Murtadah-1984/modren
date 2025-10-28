<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class UserDeletionException extends UserException
{
    protected $code = 400;

    public function __construct(string $message = 'Cannot delete user', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function hasActiveData(): self
    {
        return new self('Cannot delete user with active data. Please archive or transfer data first.');
    }

    public static function isSystemUser(): self
    {
        return new self('Cannot delete system user');
    }
}
