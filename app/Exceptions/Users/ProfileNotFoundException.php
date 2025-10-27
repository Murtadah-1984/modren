<?php

namespace App\Exceptions\Users;

class ProfileNotFoundException extends UserException
{
    protected $code = 404;

    public function __construct(string $message = 'User profile not found', ?\Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function forUser(int $userId): self
    {
        return new self("Profile for user ID {$userId} not found");
    }
}
