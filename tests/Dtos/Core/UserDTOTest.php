<?php

declare(strict_types=1);

namespace Tests\Dtos\Core;

use App\DTOs\Users\CreateUserDTO;
use App\DTOs\Users\UpdateProfileDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\ValueObjects\Users\Avatar;
use App\ValueObjects\Users\Email;
use App\ValueObjects\Users\Password;
use App\ValueObjects\Users\UserName;
use PHPUnit\Framework\TestCase;

final class UserDTOTest extends TestCase
{
    public function test_create_user_dto_from_array()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'email_verified' => true,
            'is_active' => true,
            'roles' => ['admin'],
            'permissions' => ['create_post'],
            'profile' => ['bio' => 'Developer'],
            'avatar' => '/avatars/john.png',
        ];

        $dto = CreateUserDTO::fromArray($data);

        $this->assertInstanceOf(CreateUserDTO::class, $dto);
        $this->assertInstanceOf(UserName::class, $dto->name);
        $this->assertInstanceOf(Email::class, $dto->email);
        $this->assertInstanceOf(Password::class, $dto->password);
        $this->assertTrue($dto->emailVerified);
        $this->assertTrue($dto->isActive);
        $this->assertEquals(['admin'], $dto->roles);
        $this->assertEquals(['create_post'], $dto->permissions);
        $this->assertEquals(['bio' => 'Developer'], $dto->profileData);
        $this->assertInstanceOf(Avatar::class, $dto->avatar);
    }

    public function test_create_user_dto_to_array()
    {
        $dto = new CreateUserDTO(
            name: UserName::fromString('Jane Doe'),
            email: Email::fromString('jane@example.com'),
            password: Password::fromPlainText('password123'),
        );

        $array = $dto->toArray();

        $this->assertEquals('Jane Doe', $array['name']);
        $this->assertEquals('jane@example.com', $array['email']);
        $this->assertNotEmpty($array['password']);
        $this->assertFalse(empty($array['is_active']));
    }

    public function test_create_user_dto_avatar()
    {
        $dto = new CreateUserDTO(
            name: UserName::fromString('Jane Doe'),
            email: Email::fromString('jane@example.com'),
            password: Password::fromPlainText('password123'),
            avatar: Avatar::fromPath('/avatars/jane.png')
        );

        $this->assertEquals('/avatars/jane.png', $dto->getAvatarPath());
    }

    public function test_update_user_dto_from_array()
    {
        $data = [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
            'password' => 'newpassword',
            'is_active' => false,
            'roles' => ['editor'],
            'permissions' => ['edit_post'],
            'avatar' => '/avatars/john_updated.png',
        ];

        $dto = UpdateUserDTO::fromArray($data);

        $this->assertInstanceOf(UpdateUserDTO::class, $dto);
        $this->assertInstanceOf(UserName::class, $dto->name);
        $this->assertInstanceOf(Email::class, $dto->email);
        $this->assertInstanceOf(Password::class, $dto->password);
        $this->assertFalse($dto->isActive);
        $this->assertEquals(['editor'], $dto->roles);
        $this->assertEquals(['edit_post'], $dto->permissions);
        $this->assertInstanceOf(Avatar::class, $dto->avatar);
    }

    public function test_update_user_dto_to_array()
    {
        $dto = new UpdateUserDTO(
            name: UserName::fromString('Jane Updated'),
            email: Email::fromString('jane.updated@example.com'),
            password: Password::fromPlainText('newpass')
        );

        $array = $dto->toArray();

        $this->assertEquals('Jane Updated', $array['name']);
        $this->assertEquals('jane.updated@example.com', $array['email']);
        $this->assertNotEmpty($array['password']);
    }

    public function test_update_profile_dto_from_array()
    {
        $data = [
            'phone' => '1234567890',
            'bio' => 'Updated bio',
            'avatar' => '/avatars/profile.png',
            'city' => 'New York',
            'preferences' => ['newsletter' => true],
        ];

        $dto = UpdateProfileDTO::fromArray($data);

        $this->assertInstanceOf(UpdateProfileDTO::class, $dto);
        $this->assertEquals('1234567890', $dto->phone);
        $this->assertEquals('Updated bio', $dto->bio);
        $this->assertInstanceOf(Avatar::class, $dto->avatar);
        $this->assertEquals('New York', $dto->city);
        $this->assertEquals(['newsletter' => true], $dto->preferences);
    }

    public function test_update_profile_dto_to_array()
    {
        $dto = new UpdateProfileDTO(
            phone: '9876543210',
            avatar: Avatar::fromPath('/avatars/profile2.png'),
            bio: 'Another bio'
        );

        $array = $dto->toArray();

        $this->assertEquals('9876543210', $array['phone']);
        $this->assertEquals('/avatars/profile2.png', $array['avatar']);
        $this->assertEquals('Another bio', $array['bio']);
    }

    public function test_update_profile_dto_avatar_url()
    {
        $dto = new UpdateProfileDTO(
            avatar: Avatar::fromPath('/avatars/profile3.png')
        );

        $this->assertStringContainsString('/avatars/profile3.png', $dto->getAvatarUrl());
    }
}
