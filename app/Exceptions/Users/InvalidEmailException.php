<?php

namespace App\Exceptions\Users;

class InvalidEmailException extends UserException
{
    protected $code = 422;

    public function __construct(string $message = 'Invalid email address', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function format(string $email): self
    {
        return new self("Email address '{$email}' has invalid format");
    }

    public static function domain(string $email): self
    {
        return new self("Email domain for '{$email}' is not allowed");
    }
}
