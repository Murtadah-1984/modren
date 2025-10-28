<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

final class AvatarUploadException extends UserException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to upload avatar', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function invalidFileType(): self
    {
        return new self('Avatar must be an image file (jpg, jpeg, png, gif)');
    }

    public static function fileTooLarge(int $maxSizeMB): self
    {
        return new self("Avatar file size must not exceed {$maxSizeMB}MB");
    }
}
