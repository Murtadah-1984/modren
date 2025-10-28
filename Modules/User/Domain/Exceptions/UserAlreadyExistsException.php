<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class UserAlreadyExistsException extends UserException
{
    protected $code = 409;

    public function __construct(string $message = 'old already exists', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withEmail(string $email): self
    {
        return new self("old with email {$email} already exists");
    }
}
