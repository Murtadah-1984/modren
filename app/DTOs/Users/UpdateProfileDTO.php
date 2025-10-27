<?php

namespace App\DTOs\Users;

use App\ValueObjects\Users\Avatar;

/**
 * UpdateProfileDTO
 */
readonly class UpdateProfileDTO
{
    public function __construct(
        public ?string $phone = null,
        public ?Avatar $avatar = null,
        public ?string $bio = null,
        public ?string $dateOfBirth = null,
        public ?string $address = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $country = null,
        public ?string $postalCode = null,
        public ?string $timezone = null,
        public ?string $language = null,
        public ?array  $socialLinks = null,
        public ?array  $preferences = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            phone: $data['phone'] ?? null,
            avatar: isset($data['avatar']) ? Avatar::fromPath($data['avatar']) : null,
            bio: $data['bio'] ?? null,
            dateOfBirth: $data['date_of_birth'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            country: $data['country'] ?? null,
            postalCode: $data['postal_code'] ?? null,
            timezone: $data['timezone'] ?? null,
            language: $data['language'] ?? null,
            socialLinks: $data['social_links'] ?? null,
            preferences: $data['preferences'] ?? null,
        );
    }

    public static function fromRequest(array $data): self
    {
        return self::fromArray($data);
    }

    /**
     * Convert to array for repository (only non-null values)
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->phone !== null) {
            $data['phone'] = $this->phone;
        }

        if ($this->avatar !== null) {
            $data['avatar'] = $this->avatar;
        }

        if ($this->bio !== null) {
            $data['bio'] = $this->bio;
        }

        if ($this->dateOfBirth !== null) {
            $data['date_of_birth'] = $this->dateOfBirth;
        }

        if ($this->address !== null) {
            $data['address'] = $this->address;
        }

        if ($this->city !== null) {
            $data['city'] = $this->city;
        }

        if ($this->state !== null) {
            $data['state'] = $this->state;
        }

        if ($this->country !== null) {
            $data['country'] = $this->country;
        }

        if ($this->postalCode !== null) {
            $data['postal_code'] = $this->postalCode;
        }

        if ($this->timezone !== null) {
            $data['timezone'] = $this->timezone;
        }

        if ($this->language !== null) {
            $data['language'] = $this->language;
        }

        if ($this->socialLinks !== null) {
            $data['social_links'] = $this->socialLinks;
        }

        if ($this->preferences !== null) {
            $data['preferences'] = $this->preferences;
        }

        return $data;
    }

    /**
     * Get avatar URL for response
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatar?->getUrl();
    }
}
