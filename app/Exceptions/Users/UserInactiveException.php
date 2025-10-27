<?php

namespace App\Exceptions\Users;

class UserInactiveException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'User account is inactive', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withId(int $id): self
    {
        return new self("User with ID {$id} is inactive");
    }
}
