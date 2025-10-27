<?php

declare(strict_types=1);

namespace App\ValueObjects\Users;

use App\Exceptions\Users\AvatarUploadException;
use JsonSerializable;

/**
 * Avatar Value Object
 * Immutable value object representing a user's avatar/photo
 */
final class Avatar implements JsonSerializable
{
    private const array ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    private const int MAX_FILE_SIZE = 5242880; // 5MB in bytes

    public ?string $path {
        get {
            return $this->path;
        }
    }

    /**
     * @throws AvatarUploadException
     */
    public function __construct(?string $path)
    {
        if ($path !== null) {
            $this->validate($path);
        }
        $this->path = $path;
    }

    public function __toString(): string
    {
        return $this->path ?? '';
    }

    /**
     * @throws AvatarUploadException
     */
    public static function validateFile(string $filePath, int $fileSize): void
    {
        if ($fileSize > self::MAX_FILE_SIZE) {
            $maxSizeMB = self::MAX_FILE_SIZE / 1048576;
            throw AvatarUploadException::fileTooLarge((int) $maxSizeMB);
        }

        $extension = mb_strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (! in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw AvatarUploadException::invalidFileType();
        }

        // Validate it's actually an image
        $imageInfo = @getimagesize($filePath);
        if ($imageInfo === false) {
            throw AvatarUploadException::invalidFileType();
        }
    }

    /**
     * @throws AvatarUploadException
     */
    public static function fromString(?string $path): self
    {
        return new self($path);
    }

    public static function empty(): self
    {
        return new self(null);
    }

    public static function getAllowedExtensions(): array
    {
        return self::ALLOWED_EXTENSIONS;
    }

    public static function getMaxFileSize(): int
    {
        return self::MAX_FILE_SIZE;
    }

    public static function getMaxFileSizeMB(): int
    {
        return (int) (self::MAX_FILE_SIZE / 1048576);
    }

    public function getUrl(?string $defaultUrl = null): string
    {
        if ($this->path === null) {
            return $defaultUrl ?? $this->getDefaultAvatarUrl();
        }

        // If path is already a full URL
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }

        // Otherwise, prepend storage URL
        return asset('storage/'.$this->path);
    }

    public function getFileName(): ?string
    {
        if ($this->path === null) {
            return null;
        }

        return basename($this->path);
    }

    public function getExtension(): ?string
    {
        if ($this->path === null) {
            return null;
        }

        return mb_strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
    }

    public function isEmpty(): bool
    {
        return $this->path === null;
    }

    public function isNotEmpty(): bool
    {
        return $this->path !== null;
    }

    public function equals(self $other): bool
    {
        return $this->path === $other->path;
    }

    public function jsonSerialize(): ?string
    {
        return $this->path;
    }

    private function validate(string $path): void
    {
        // Get file extension
        $extension = mb_strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (! in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw AvatarUploadException::invalidFileType();
        }
    }

    private function getDefaultAvatarUrl(): string
    {
        return asset('images/default-avatar.png');
    }
}
