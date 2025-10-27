<?php

namespace App\Exceptions\Users;

class UserAlreadyExistsException extends UserException
{
    protected $code = 409;

    public function __construct(string $message = 'User already exists', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withEmail(string $email): self
    {
        return new self("User with email {$email} already exists");
    }
}
