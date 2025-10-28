<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class ProfileUpdateException extends UserException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to update profile', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }
}
