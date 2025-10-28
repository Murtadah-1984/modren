<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class UserNotFoundException extends UserException
{
    protected $code = 404;

    public function __construct(string $message = 'User not found', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withId(int $id): self
    {
        return new self("User with ID {$id} not found");
    }

    public static function withEmail(string $email): self
    {
        return new self("User with email {$email} not found");
    }
}
