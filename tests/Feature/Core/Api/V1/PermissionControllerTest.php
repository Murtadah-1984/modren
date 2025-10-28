<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Api\V1;

use App\DTOs\Permissions\CreatePermissionDTO;
use App\DTOs\Permissions\UpdatePermissionDTO;
use Mockery;
use Modules\RBAC\Application\Services\PermissionService;
use Tests\TestCase;

final class PermissionControllerTest extends TestCase
{
    protected $permissionService;

    protected function setUp(): void
    {
        parent::setUp();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $this->permissionService = Mockery::mock(PermissionService::class);
        $this->app->instance(PermissionService::class, $this->permissionService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_returns_permissions()
    {
        $this->permissionService
            ->shouldReceive('getAllPermissions')
            ->once()
            ->with(null)
            ->andReturn([
                ['id' => 1, 'name' => 'view posts'],
            ]);

        $response = $this->getJson('/api/v1/permissions');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [['id' => 1, 'name' => 'view posts']],
            ]);
    }

    public function test_store_creates_permission()
    {
        $data = ['name' => 'edit posts', 'guard_name' => 'web'];

        $this->permissionService
            ->shouldReceive('createPermission')
            ->once()
            ->with(Mockery::type(CreatePermissionDTO::class))
            ->andReturn(['id' => 2, 'name' => 'edit posts']);

        $response = $this->postJson('/api/v1/permissions', $data);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 2, 'name' => 'edit posts'],
            ]);
    }

    public function test_show_returns_permission()
    {
        $this->permissionService
            ->shouldReceive('findPermissionById')
            ->once()
            ->with(1, null)
            ->andReturn(['id' => 1, 'name' => 'view posts']);

        $response = $this->getJson('/api/v1/permissions/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'name' => 'view posts'],
            ]);
    }

    public function test_update_modifies_permission()
    {
        $data = ['name' => 'edit posts'];

        $this->permissionService
            ->shouldReceive('updatePermission')
            ->once()
            ->with(1, Mockery::type(UpdatePermissionDTO::class), null)
            ->andReturn(['id' => 1, 'name' => 'edit posts']);

        $response = $this->putJson('/api/v1/permissions/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'name' => 'edit posts'],
            ]);
    }

    public function test_destroy_deletes_permission()
    {
        $this->permissionService
            ->shouldReceive('deletePermission')
            ->once()
            ->with(1, null)
            ->andReturnTrue();

        $response = $this->deleteJson('/api/v1/permissions/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Permission deleted successfully',
            ]);
    }

    public function test_exists_returns_true()
    {
        $this->permissionService
            ->shouldReceive('permissionExists')
            ->once()
            ->with('view posts', null)
            ->andReturn(true);

        $response = $this->postJson('/api/v1/permissions/exists', ['name' => 'view posts']);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['exists' => true],
            ]);
    }
}
