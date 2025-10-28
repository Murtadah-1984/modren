<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Api\V1;

use App\DTOs\Roles\CreateRoleDTO;
use App\DTOs\Roles\UpdateRoleDTO;
use Mockery;
use Modules\RBAC\Application\Services\RoleService;
use Tests\TestCase;

final class RoleControllerTest extends TestCase
{
    protected $roleService;

    protected function setUp(): void
    {
        parent::setUp();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $this->roleService = Mockery::mock(RoleService::class);
        $this->app->instance(RoleService::class, $this->roleService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_returns_roles()
    {
        $this->roleService
            ->shouldReceive('getAllRoles')
            ->once()
            ->with(null)
            ->andReturn([['id' => 1, 'name' => 'Admin']]);

        $response = $this->getJson('/api/v1/roles');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [['id' => 1, 'name' => 'Admin']],
            ]);
    }

    public function test_store_creates_role()
    {
        $data = ['name' => 'Editor', 'guard_name' => 'web'];

        $this->roleService
            ->shouldReceive('createRole')
            ->once()
            ->with(Mockery::type(CreateRoleDTO::class))
            ->andReturn(['id' => 2, 'name' => 'Editor']);

        $response = $this->postJson('/api/v1/roles', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 2, 'name' => 'Editor'],
            ]);
    }

    public function test_show_returns_role()
    {
        $this->roleService
            ->shouldReceive('findRoleById')
            ->once()
            ->with(1, null)
            ->andReturn(['id' => 1, 'name' => 'Admin']);

        $response = $this->getJson('/api/v1/roles/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'name' => 'Admin'],
            ]);
    }

    public function test_update_modifies_role()
    {
        $data = ['name' => 'Super Admin'];

        $this->roleService
            ->shouldReceive('updateRole')
            ->once()
            ->with(1, Mockery::type(UpdateRoleDTO::class), null)
            ->andReturn(['id' => 1, 'name' => 'Super Admin']);

        $response = $this->putJson('/api/v1/roles/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'name' => 'Super Admin'],
            ]);
    }

    public function test_destroy_deletes_role()
    {
        $this->roleService
            ->shouldReceive('deleteRole')
            ->once()
            ->with(1, null)
            ->andReturnTrue();

        $response = $this->deleteJson('/api/v1/roles/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => 'Role deleted successfully',
            ]);
    }

    public function test_give_permission_to_role()
    {
        $roleMock = Mockery::mock();
        $roleMock->shouldReceive('load')->with('permissions')->andReturn(['id' => 1, 'permissions' => ['edit posts']]);

        $this->roleService
            ->shouldReceive('givePermission')
            ->once()
            ->with(1, ['edit posts'], null)
            ->andReturn($roleMock);

        $response = $this->postJson('/api/v1/roles/1/give-permission', ['permissions' => ['edit posts']]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'permissions' => ['edit posts']],
            ]);
    }

    public function test_revoke_permission_from_role()
    {
        $roleMock = Mockery::mock();
        $roleMock->shouldReceive('load')->with('permissions')->andReturn(['id' => 1, 'permissions' => []]);

        $this->roleService
            ->shouldReceive('revokePermission')
            ->once()
            ->with(1, ['edit posts'], null)
            ->andReturn($roleMock);

        $response = $this->postJson('/api/v1/roles/1/revoke-permission', ['permissions' => ['edit posts']]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'permissions' => []],
            ]);
    }

    public function test_sync_permissions_to_role()
    {
        $roleMock = Mockery::mock();
        $roleMock->shouldReceive('load')->with('permissions')->andReturn(['id' => 1, 'permissions' => ['view posts']]);

        $this->roleService
            ->shouldReceive('syncPermissions')
            ->once()
            ->with(1, ['view posts'], null)
            ->andReturn($roleMock);

        $response = $this->postJson('/api/v1/roles/1/sync-permissions', ['permissions' => ['view posts']]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'permissions' => ['view posts']],
            ]);
    }

    public function test_get_permissions_for_role()
    {
        $this->roleService
            ->shouldReceive('getRolePermissions')
            ->once()
            ->with(1, null)
            ->andReturn(['view posts', 'edit posts']);

        $response = $this->getJson('/api/v1/roles/1/permissions');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['view posts', 'edit posts'],
            ]);
    }

    public function test_get_users_with_role()
    {
        $this->roleService
            ->shouldReceive('getRoleUsers')
            ->once()
            ->with(1, null)
            ->andReturn([['id' => 10, 'name' => 'John Doe']]);

        $response = $this->getJson('/api/v1/roles/1/users');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [['id' => 10, 'name' => 'John Doe']],
            ]);
    }
}
