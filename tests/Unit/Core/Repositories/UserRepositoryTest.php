<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;
use Tests\TestCase;

final class UserRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_find_by_id_returns_user_or_null()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn($user);

        $result = $this->repository->findById(1);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('john@example.com', $result->email);
    }

    public function test_find_by_email_returns_user_or_null()
    {
        $user = new User(['name' => 'Jane Doe', 'email' => 'jane@example.com']);
        $this->repository
            ->shouldReceive('findByEmail')
            ->with('jane@example.com')
            ->once()
            ->andReturn($user);

        $result = $this->repository->findByEmail('jane@example.com');
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('Jane Doe', $result->name);
    }

    public function test_all_returns_collection()
    {
        $collection = new Collection([new User(['name' => 'Alice'])]);
        $this->repository
            ->shouldReceive('all')
            ->once()
            ->andReturn($collection);

        $result = $this->repository->all();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function test_paginate_returns_length_aware_paginator()
    {
        $paginator = Mockery::mock(LengthAwarePaginator::class);
        $this->repository
            ->shouldReceive('paginate')
            ->with(10)
            ->once()
            ->andReturn($paginator);

        $result = $this->repository->paginate(10);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_create_update_delete_user()
    {
        $data = ['name' => 'Bob', 'email' => 'bob@example.com'];
        $user = new User($data);

        $this->repository
            ->shouldReceive('create')->with($data)->once()->andReturn($user)
            ->shouldReceive('update')->with($user, $data)->once()->andReturn($user)
            ->shouldReceive('delete')->with($user)->once()->andReturn(true);

        $this->assertInstanceOf(User::class, $this->repository->create($data));
        $this->assertInstanceOf(User::class, $this->repository->update($user, $data));
        $this->assertTrue($this->repository->delete($user));
    }

    public function test_avatar_methods()
    {
        $user = new User(['name' => 'Charlie']);
        $this->repository
            ->shouldReceive('updateAvatar')->with($user, 'avatar.png')->once()->andReturn($user)
            ->shouldReceive('removeAvatar')->with($user)->once()->andReturn($user);

        $this->assertInstanceOf(User::class, $this->repository->updateAvatar($user, 'avatar.png'));
        $this->assertInstanceOf(User::class, $this->repository->removeAvatar($user));
    }

    public function test_password_methods()
    {
        $user = new User(['name' => 'Diana']);
        $this->repository
            ->shouldReceive('updatePassword')->with($user, 'secret')->once()->andReturn($user);

        $this->assertInstanceOf(User::class, $this->repository->updatePassword($user, 'secret'));
    }

    public function test_role_and_permission_methods()
    {
        $user = new User(['name' => 'Eve']);
        $roles = ['admin', 'editor'];
        $permissions = ['edit articles', 'delete articles'];

        $this->repository
            ->shouldReceive('assignRole')->with($user, $roles)->once()->andReturn($user)
            ->shouldReceive('removeRole')->with($user, $roles)->once()->andReturn($user)
            ->shouldReceive('syncRoles')->with($user, $roles)->once()->andReturn($user)
            ->shouldReceive('givePermission')->with($user, $permissions)->once()->andReturn($user)
            ->shouldReceive('revokePermission')->with($user, $permissions)->once()->andReturn($user)
            ->shouldReceive('syncPermissions')->with($user, $permissions)->once()->andReturn($user)
            ->shouldReceive('hasRole')->with($user, 'admin')->once()->andReturn(true)
            ->shouldReceive('hasPermission')->with($user, 'edit articles')->once()->andReturn(true);

        $this->assertInstanceOf(User::class, $this->repository->assignRole($user, $roles));
        $this->assertInstanceOf(User::class, $this->repository->removeRole($user, $roles));
        $this->assertInstanceOf(User::class, $this->repository->syncRoles($user, $roles));
        $this->assertInstanceOf(User::class, $this->repository->givePermission($user, $permissions));
        $this->assertInstanceOf(User::class, $this->repository->revokePermission($user, $permissions));
        $this->assertInstanceOf(User::class, $this->repository->syncPermissions($user, $permissions));
        $this->assertTrue($this->repository->hasRole($user, 'admin'));
        $this->assertTrue($this->repository->hasPermission($user, 'edit articles'));
    }
}
