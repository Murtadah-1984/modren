<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class UserNotVerifiedException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'User email is not verified', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }
}
