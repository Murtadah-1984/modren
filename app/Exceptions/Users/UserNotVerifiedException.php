<?php

namespace App\Exceptions\Users;

class UserNotVerifiedException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'User email is not verified', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }
}
