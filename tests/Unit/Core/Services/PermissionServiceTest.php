<?php

use App\Services\PermissionService;
use App\Contracts\PermissionRepositoryInterface;
use App\DTOs\Permissions\CreatePermissionDTO;
use App\DTOs\Permissions\UpdatePermissionDTO;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->repository = Mockery::mock(PermissionRepositoryInterface::class);
    $this->service = new PermissionService($this->repository);
});

it('gets all permissions', function () {
    $expected = new Collection([new Permission(['name' => 'view users'])]);
    $this->repository->shouldReceive('all')->with(null)->once()->andReturn($expected);

    $result = $this->service->getAllPermissions();

    expect($result)->toBe($expected);
});

it('creates a new permission', function () {
    $dto = Mockery::mock(CreatePermissionDTO::class);
    $dto->shouldReceive('toArray')->andReturn(['name' => 'create users']);

    $permission = new Permission(['name' => 'create users']);
    $this->repository->shouldReceive('create')->with(['name' => 'create users'])->once()->andReturn($permission);

    $result = $this->service->createPermission($dto);

    expect($result)->toBe($permission);
});

it('updates a permission', function () {
    $dto = Mockery::mock(UpdatePermissionDTO::class);
    $dto->shouldReceive('toArray')->andReturn(['name' => 'edit users']);

    $permission = new Permission(['id' => 1, 'name' => 'old']);
    $this->repository->shouldReceive('findById')->with(1, null)->andReturn($permission);
    $this->repository->shouldReceive('update')->with($permission, ['name' => 'edit users'])->andReturn($permission);

    $result = $this->service->updatePermission(1, $dto);

    expect($result)->toBe($permission);
});

it('deletes a permission', function () {
    $permission = new Permission(['id' => 1]);
    $this->repository->shouldReceive('findById')->with(1, null)->andReturn($permission);
    $this->repository->shouldReceive('delete')->with($permission)->andReturnTrue();

    $result = $this->service->deletePermission(1);

    expect($result)->toBeTrue();
});
