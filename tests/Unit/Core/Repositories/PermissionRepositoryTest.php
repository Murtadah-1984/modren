<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Modules\RBAC\Domain\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class PermissionRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(PermissionRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_find_by_id_returns_permission_or_null()
    {
        $permission = new Permission(['name' => 'edit articles']);
        $this->repository
            ->shouldReceive('findById')
            ->with(1, null)
            ->once()
            ->andReturn($permission);

        $result = $this->repository->findById(1);
        $this->assertInstanceOf(Permission::class, $result);
        $this->assertEquals('edit articles', $result->name);
    }

    public function test_find_by_name_returns_permission_or_null()
    {
        $permission = new Permission(['name' => 'delete articles']);
        $this->repository
            ->shouldReceive('findByName')
            ->with('delete articles', null)
            ->once()
            ->andReturn($permission);

        $result = $this->repository->findByName('delete articles');
        $this->assertInstanceOf(Permission::class, $result);
        $this->assertEquals('delete articles', $result->name);
    }

    public function test_all_returns_collection()
    {
        $collection = new Collection([new Permission(['name' => 'view articles'])]);
        $this->repository
            ->shouldReceive('all')
            ->with(null)
            ->once()
            ->andReturn($collection);

        $result = $this->repository->all();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function test_create_returns_permission()
    {
        $data = ['name' => 'publish articles'];
        $permission = new Permission($data);

        $this->repository
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($permission);

        $result = $this->repository->create($data);
        $this->assertInstanceOf(Permission::class, $result);
        $this->assertEquals('publish articles', $result->name);
    }

    public function test_delete_returns_boolean()
    {
        $permission = new Permission(['name' => 'archive articles']);
        $this->repository
            ->shouldReceive('delete')
            ->with($permission)
            ->once()
            ->andReturn(true);

        $result = $this->repository->delete($permission);
        $this->assertTrue($result);
    }
}
