<?php

namespace Tests\Dtos\Core;

use App\DTOs\Roles\CreateRoleDTO;
use App\DTOs\Roles\UpdateRoleDTO;
use App\ValueObjects\Roles\GuardName;
use App\ValueObjects\Roles\RoleDescription;
use App\ValueObjects\Roles\RoleName;
use PHPUnit\Framework\TestCase;

class RoleDTOTest extends TestCase
{
    public function test_create_role_dto_from_array()
    {
        $data = [
            'name' => 'admin',
            'guard_name' => 'web',
            'description' => 'Administrator role',
            'is_system' => true,
            'permissions' => ['create_post', 'edit_post'],
        ];

        $dto = CreateRoleDTO::fromArray($data);

        $this->assertInstanceOf(CreateRoleDTO::class, $dto);
        $this->assertInstanceOf(RoleName::class, $dto->name);
        $this->assertInstanceOf(GuardName::class, $dto->guardName);
        $this->assertInstanceOf(RoleDescription::class, $dto->description);
        $this->assertTrue($dto->isSystem);
        $this->assertEquals(['create_post', 'edit_post'], $dto->permissions);
    }

    public function test_create_role_dto_to_array()
    {
        $dto = new CreateRoleDTO(
            name: RoleName::fromString('editor'),
            guardName: GuardName::fromString('web'),
            description: RoleDescription::fromString('Editor role'),
            isSystem: false
        );

        $array = $dto->toArray();

        $this->assertEquals('editor', $array['name']);
        $this->assertEquals('web', $array['guard_name']);
        $this->assertEquals('Editor role', $array['description']);
        $this->assertFalse($array['is_system']);
    }

    public function test_create_role_dto_helpers()
    {
        $dto = new CreateRoleDTO(
            name: RoleName::fromString('manager'),
            guardName: GuardName::default(),
            isSystem: true
        );

        $this->assertIsString($dto->getDisplayName());
        $this->assertTrue($dto->isSystemRole());
    }

    public function test_update_role_dto_from_array()
    {
        $data = [
            'name' => 'editor',
            'description' => 'Editor role description',
            'permissions' => ['edit_post'],
            'allow_system_update' => true,
        ];

        $dto = UpdateRoleDTO::fromArray($data);

        $this->assertInstanceOf(UpdateRoleDTO::class, $dto);
        $this->assertInstanceOf(RoleName::class, $dto->name);
        $this->assertInstanceOf(RoleDescription::class, $dto->description);
        $this->assertEquals(['edit_post'], $dto->permissions);
        $this->assertTrue($dto->allowSystemUpdate);
    }

    public function test_update_role_dto_to_array()
    {
        $dto = new UpdateRoleDTO(
            name: RoleName::fromString('editor'),
            description: RoleDescription::fromString('Editor description')
        );

        $array = $dto->toArray();

        $this->assertEquals('editor', $array['name']);
        $this->assertEquals('Editor description', $array['description']);
    }

    public function test_update_role_dto_helpers()
    {
        $dto = new UpdateRoleDTO(
            name: RoleName::fromString('editor'),
            description: RoleDescription::fromString('Editor description')
        );

        $this->assertTrue($dto->hasNameUpdate());
        $this->assertTrue($dto->hasDescriptionUpdate());
    }
}
