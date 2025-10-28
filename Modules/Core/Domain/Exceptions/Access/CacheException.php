<?php

declare(strict_types=1);

namespace Modules\Core\Domain\Exceptions\Access;

use Throwable;

/**
 * Cache Exception
 */
final class CacheException extends AccessException
{
    protected $code = 500;

    public function __construct(string $message = 'Cache operation failed', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function clearFailed(): self
    {
        return new self('Failed to clear permissions cache');
    }
}
