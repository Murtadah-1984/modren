<?php

namespace Tests\Unit\Core\Repositories;

use App\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(RoleRepositoryInterface::class);
    }

    public function test_find_by_id_returns_role_or_null()
    {
        $role = new Role(['name' => 'admin']);
        $this->repository
            ->shouldReceive('findById')
            ->with(1, null)
            ->once()
            ->andReturn($role);

        $result = $this->repository->findById(1);
        $this->assertInstanceOf(Role::class, $result);
        $this->assertEquals('admin', $result->name);
    }

    public function test_find_by_name_returns_role_or_null()
    {
        $role = new Role(['name' => 'editor']);
        $this->repository
            ->shouldReceive('findByName')
            ->with('editor', null)
            ->once()
            ->andReturn($role);

        $result = $this->repository->findByName('editor');
        $this->assertInstanceOf(Role::class, $result);
        $this->assertEquals('editor', $result->name);
    }

    public function test_all_returns_collection()
    {
        $collection = new Collection([new Role(['name' => 'user'])]);
        $this->repository
            ->shouldReceive('all')
            ->with(null)
            ->once()
            ->andReturn($collection);

        $result = $this->repository->all();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function test_create_returns_role()
    {
        $data = ['name' => 'manager'];
        $role = new Role($data);

        $this->repository
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($role);

        $result = $this->repository->create($data);
        $this->assertInstanceOf(Role::class, $result);
        $this->assertEquals('manager', $result->name);
    }

    public function test_delete_returns_boolean()
    {
        $role = new Role(['name' => 'guest']);
        $this->repository
            ->shouldReceive('delete')
            ->with($role)
            ->once()
            ->andReturn(true);

        $result = $this->repository->delete($role);
        $this->assertTrue($result);
    }

    public function test_give_and_revoke_permission_to_role()
    {
        $role = new Role(['name' => 'admin']);
        $permissions = ['edit articles', 'delete articles'];

        $this->repository
            ->shouldReceive('givePermissionTo')
            ->with($role, $permissions)
            ->once()
            ->andReturn($role);

        $this->repository
            ->shouldReceive('revokePermissionTo')
            ->with($role, $permissions)
            ->once()
            ->andReturn($role);

        $this->assertInstanceOf(Role::class, $this->repository->givePermissionTo($role, $permissions));
        $this->assertInstanceOf(Role::class, $this->repository->revokePermissionTo($role, $permissions));
    }

    public function test_has_permission_methods_return_boolean()
    {
        $role = new Role(['name' => 'editor']);
        $this->repository
            ->shouldReceive('hasPermissionTo')
            ->with($role, 'edit articles')
            ->once()
            ->andReturn(true);

        $this->repository
            ->shouldReceive('hasAnyPermission')
            ->with($role, ['edit articles', 'delete articles'])
            ->once()
            ->andReturn(true);

        $this->repository
            ->shouldReceive('hasAllPermissions')
            ->with($role, ['edit articles', 'delete articles'])
            ->once()
            ->andReturn(false);

        $this->assertTrue($this->repository->hasPermissionTo($role, 'edit articles'));
        $this->assertTrue($this->repository->hasAnyPermission($role, ['edit articles', 'delete articles']));
        $this->assertFalse($this->repository->hasAllPermissions($role, ['edit articles', 'delete articles']));
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
