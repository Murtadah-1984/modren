<?php

use App\Services\RoleService;
use App\Contracts\RoleRepositoryInterface;
use App\DTOs\Roles\CreateRoleDTO;
use App\DTOs\Roles\UpdateRoleDTO;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->repository = Mockery::mock(RoleRepositoryInterface::class);
    $this->service = new RoleService($this->repository);
});

it('creates a role with permissions', function () {
    $dto = Mockery::mock(CreateRoleDTO::class);
    $dto->shouldReceive('toArray')->andReturn(['name' => 'admin']);
    $dto->shouldReceive('hasPermissions')->andReturnTrue();
    $dto->shouldReceive('getPermissions')->andReturn(['edit users']);

    $role = new Role(['name' => 'admin']);
    $this->repository->shouldReceive('create')->andReturn($role);
    $this->repository->shouldReceive('syncPermissions')->with($role, ['edit users']);

    $role->shouldReceive('fresh')->andReturnSelf();

    $result = $this->service->createRole($dto);

    expect($result)->toBeInstanceOf(Role::class);
});

it('updates a role', function () {
    $dto = Mockery::mock(UpdateRoleDTO::class);
    $dto->shouldReceive('toArray')->andReturn(['name' => 'manager']);

    $role = new Role(['id' => 1]);
    $this->repository->shouldReceive('findById')->with(1, null)->andReturn($role);
    $this->repository->shouldReceive('update')->with($role, ['name' => 'manager'])->andReturn($role);

    $result = $this->service->updateRole(1, $dto);

    expect($result)->toBe($role);
});

it('deletes a role', function () {
    $role = new Role(['id' => 1]);
    $this->repository->shouldReceive('findById')->andReturn($role);
    $this->repository->shouldReceive('delete')->with($role)->andReturnTrue();

    $result = $this->service->deleteRole(1);

    expect($result)->toBeTrue();
});
