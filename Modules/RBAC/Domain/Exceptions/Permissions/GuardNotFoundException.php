<?php

declare(strict_types=1);

namespace Modules\RBAC\Domain\Exceptions\Permissions;

use Modules\Core\Domain\Exceptions\Access\AccessException;
use Throwable;

/**
 * Guard Not Found Exception
 */
final class GuardNotFoundException extends AccessException implements Throwable
{
    protected $code = 404;

    public function __construct(string $message = 'Guard not found', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }

    public static function withName(string $guardName): self
    {
        return new self("Guard '{$guardName}' not found");
    }

    public function getMessage(): string
    {
        // TODO: Implement getMessage() method.
    }

    public function getCode()
    {
        // TODO: Implement getCode() method.
    }

    public function getFile(): string
    {
        // TODO: Implement getFile() method.
    }

    public function getLine(): int
    {
        // TODO: Implement getLine() method.
    }

    public function getTrace(): array
    {
        // TODO: Implement getTrace() method.
    }

    public function getTraceAsString(): string
    {
        // TODO: Implement getTraceAsString() method.
    }

    public function getPrevious()
    {
        // TODO: Implement getPrevious() method.
    }
}
