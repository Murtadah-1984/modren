<?php

namespace App\Exceptions\Access;

/**
 * Bulk Access Operation Exception
 */
class BulkAccessOperationException extends AccessException
{
    protected $code = 400;
    protected array $failedItems = [];

    public function __construct(string $message = 'Bulk operation failed', array $failedItems = [], ?\Throwable $previous = null)
    {
        $this->failedItems = $failedItems;
        parent::__construct($message, $this->code, $previous);
    }

    public function getFailedItems(): array
    {
        return $this->failedItems;
    }

    public static function withFailedItems(array $failedItems, string $operation, string $type): self
    {
        $count = count($failedItems);
        return new self(
            "Bulk {$operation} failed for {$count} {$type}(s)",
            $failedItems
        );
    }
}
