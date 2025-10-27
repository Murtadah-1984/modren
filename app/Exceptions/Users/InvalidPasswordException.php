<?php

namespace App\Exceptions\Users;

class InvalidPasswordException extends UserException
{
    protected $code = 422;

    public function __construct(string $message = 'Invalid password provided', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function tooShort(int $minLength): self
    {
        return new self("Password must be at least {$minLength} characters long");
    }

    public static function tooWeak(): self
    {
        return new self('Password is too weak. Must contain uppercase, lowercase, numbers, and special characters');
    }
}
