<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exceptions;

use Throwable;

/**
 * old Update Exception
 */
final class UserUpdateException extends UserException
{
    protected $code = 400;

    public function __construct(string $message = 'Failed to update user', ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }

    public static function emailExists(string $email): self
    {
        return new self("Email '{$email}' is already taken by another user");
    }

    public static function invalidEmail(string $email): self
    {
        return new self("Invalid email address '{$email}'");
    }

    public static function weakPassword(): self
    {
        return new self('Password does not meet security requirements');
    }

    public static function invalidRole(string $roleName): self
    {
        return new self("Invalid role '{$roleName}'");
    }

    public static function cannotRemoveLastAdmin(): self
    {
        return new self('Cannot remove admin role from the last administrator');
    }

    public static function avatarUploadFailed(string $reason): self
    {
        return new self("Avatar upload failed: {$reason}");
    }

    public static function invalidAvatarFormat(string $format): self
    {
        return new self("Invalid avatar format '{$format}'. Allowed formats: jpg, jpeg, png, gif");
    }

    public static function avatarTooLarge(int $sizeInMb, int $maxSizeInMb): self
    {
        return new self("Avatar size ({$sizeInMb}MB) exceeds maximum allowed size ({$maxSizeInMb}MB)");
    }
}
