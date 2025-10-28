<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class BulkOperationException extends UserException
{
    protected $code = 400;

    protected array $failedIds = [];

    public function __construct(string $message = 'Bulk operation failed', array $failedIds = [], ?Throwable $previous = null)
    {
        $this->failedIds = $failedIds;
        parent::__construct($message, $this->code, $previous);
    }

    public static function withFailedIds(array $failedIds, string $operation): self
    {
        $count = count($failedIds);

        return new self(
            "Bulk {$operation} failed for {$count} user(s)",
            $failedIds
        );
    }

    public function getFailedIds(): array
    {
        return $this->failedIds;
    }
}
