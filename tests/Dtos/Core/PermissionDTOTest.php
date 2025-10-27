<?php

namespace Tests\Dtos\Core;

use App\DTOs\Permissions\CreatePermissionDTO;
use App\DTOs\Permissions\UpdatePermissionDTO;
use App\ValueObjects\Permissions\PermissionName;
use App\ValueObjects\Roles\GuardName;
use PHPUnit\Framework\TestCase;

class PermissionDTOTest extends TestCase
{
    public function test_create_permission_dto_from_array()
    {
        $data = [
            'name' => 'create_post',
            'guard_name' => 'web',
            'description' => 'Can create posts',
            'group' => 'Posts',
            'is_system' => true,
            'roles' => ['admin', 'editor'],
        ];

        $dto = CreatePermissionDTO::fromArray($data);

        $this->assertInstanceOf(CreatePermissionDTO::class, $dto);
        $this->assertInstanceOf(PermissionName::class, $dto->name);
        $this->assertInstanceOf(GuardName::class, $dto->guardName);
        $this->assertEquals('Can create posts', $dto->description);
        $this->assertEquals('Posts', $dto->group);
        $this->assertTrue($dto->isSystem);
        $this->assertEquals(['admin', 'editor'], $dto->roles);
    }

    public function test_create_permission_dto_to_array()
    {
        $dto = new CreatePermissionDTO(
            name: PermissionName::fromString('edit_post'),
            guardName: GuardName::fromString('web'),
            description: 'Edit post permission',
            group: 'Posts',
            isSystem: false
        );

        $array = $dto->toArray();

        $this->assertEquals('edit_post', $array['name']);
        $this->assertEquals('web', $array['guard_name']);
        $this->assertEquals('Edit post permission', $array['description']);
        $this->assertEquals('Posts', $array['group']);
        $this->assertFalse($array['is_system']);
    }

    public function test_create_permission_dto_helpers()
    {
        $dto = new CreatePermissionDTO(
            name: PermissionName::fromString('delete_post'),
            guardName: GuardName::default(),
            isSystem: true
        );

        $this->assertIsString($dto->getDisplayName());
        $this->assertIsString($dto->getAction());
        $this->assertIsString($dto->getResource());
        $this->assertTrue($dto->isSystemPermission());
        $this->assertIsBool($dto->isCrudPermission());
    }

    public function test_update_permission_dto_from_array()
    {
        $data = [
            'name' => 'update_post',
            'description' => 'Update posts',
            'group' => 'Posts',
            'roles' => ['editor'],
            'allow_system_update' => true,
        ];

        $dto = UpdatePermissionDTO::fromArray($data);

        $this->assertInstanceOf(UpdatePermissionDTO::class, $dto);
        $this->assertInstanceOf(PermissionName::class, $dto->name);
        $this->assertEquals('Update posts', $dto->description);
        $this->assertEquals('Posts', $dto->group);
        $this->assertEquals(['editor'], $dto->roles);
        $this->assertTrue($dto->allowSystemUpdate);
    }

    public function test_update_permission_dto_to_array()
    {
        $dto = new UpdatePermissionDTO(
            name: PermissionName::fromString('update_post'),
            description: 'Update posts',
            group: 'Posts'
        );

        $array = $dto->toArray();

        $this->assertEquals('update_post', $array['name']);
        $this->assertEquals('Update posts', $array['description']);
        $this->assertEquals('Posts', $array['group']);
    }

    public function test_update_permission_dto_helpers()
    {
        $dto = new UpdatePermissionDTO(
            name: PermissionName::fromString('update_post'),
            description: 'Update posts',
            group: 'Posts'
        );

        $this->assertTrue($dto->hasNameUpdate());
        $this->assertTrue($dto->hasDescriptionUpdate());
        $this->assertTrue($dto->hasGroupUpdate());
    }
}

