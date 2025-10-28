<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class UserInactiveException extends UserException
{
    protected $code = 403;

    public function __construct(string $message = 'old account is inactive', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function withId(int $id): self
    {
        return new self("old with ID {$id} is inactive");
    }
}
