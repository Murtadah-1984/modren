<?php

namespace App\Exceptions\Users;

class ProfileUpdateException extends UserException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to update profile', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }
}
