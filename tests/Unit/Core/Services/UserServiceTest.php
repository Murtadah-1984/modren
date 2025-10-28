<?php

declare(strict_types=1);

use App\DTOs\Users\CreateUserDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Modules\User\Application\Services\UserService;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;

beforeEach(function () {
    $this->repository = Mockery::mock(UserRepositoryInterface::class);
    $this->service = new UserService($this->repository);
});

it('creates a new user with roles and permissions', function () {
    $dto = Mockery::mock(CreateUserDTO::class);
    $dto->shouldReceive('toArray')->andReturn(['name' => 'John']);
    $dto->shouldReceive('hasRoles')->andReturnTrue();
    $dto->shouldReceive('getRoles')->andReturn(['admin']);
    $dto->shouldReceive('hasPermissions')->andReturnTrue();
    $dto->shouldReceive('getPermissions')->andReturn(['edit users']);

    $user = new User(['name' => 'John']);
    $this->repository->shouldReceive('create')->andReturn($user);
    $this->repository->shouldReceive('assignRole')->with($user, ['admin']);
    $this->repository->shouldReceive('givePermission')->with($user, ['edit users']);
    $user->shouldReceive('fresh')->andReturnSelf();

    $result = $this->service->createUser($dto);

    expect($result)->toBeInstanceOf(User::class);
});

it('updates a user', function () {
    $dto = Mockery::mock(UpdateUserDTO::class);
    $dto->shouldReceive('toArray')->andReturn(['name' => 'Ali']);

    $user = new User(['id' => 1]);
    $this->repository->shouldReceive('findById')->with(1)->andReturn($user);
    $this->repository->shouldReceive('update')->with($user, ['name' => 'Ali'])->andReturn($user);

    $result = $this->service->updateUser(1, $dto);

    expect($result)->toBe($user);
});

it('deletes a user and removes avatar', function () {
    Storage::fake('public');
    $user = new User(['id' => 1, 'avatar' => 'avatars/test.jpg']);

    $this->repository->shouldReceive('findById')->with(1)->andReturn($user);
    $this->repository->shouldReceive('delete')->with($user)->andReturnTrue();

    Storage::disk('public')->put('avatars/test.jpg', 'content');

    $result = $this->service->deleteUser(1);

    expect($result)->toBeTrue();
    Storage::disk('public')->assertMissing('avatars/test.jpg');
});
