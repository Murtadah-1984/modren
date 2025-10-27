<?php

namespace Tests\Feature\Core\Api\V1;

use App\DTOs\Users\CreateUserDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class UserControllerTest extends TestCase
{
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $this->userService = Mockery::mock(UserService::class);
        $this->app->instance(UserService::class, $this->userService);
    }

    public function test_index_returns_users()
    {
        $this->userService
            ->shouldReceive('getAllUsers')
            ->once()
            ->andReturn([['id' => 1, 'name' => 'John Doe']]);

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [['id' => 1, 'name' => 'John Doe']]
            ]);
    }

    public function test_store_creates_user()
    {
        $data = ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'password' => 'secret'];

        $this->userService
            ->shouldReceive('createUser')
            ->once()
            ->with(Mockery::type(CreateUserDTO::class))
            ->andReturn(['id' => 2, 'name' => 'Jane Doe']);

        $response = $this->postJson('/api/v1/users', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 2, 'name' => 'Jane Doe']
            ]);
    }

    public function test_show_returns_user()
    {
        $this->userService
            ->shouldReceive('findUserById')
            ->once()
            ->with(1)
            ->andReturn(['id' => 1, 'name' => 'John Doe']);

        $response = $this->getJson('/api/v1/users/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'name' => 'John Doe']
            ]);
    }

    public function test_update_modifies_user()
    {
        $data = ['name' => 'John Updated'];

        $this->userService
            ->shouldReceive('updateUser')
            ->once()
            ->with(1, Mockery::type(UpdateUserDTO::class))
            ->andReturn(['id' => 1, 'name' => 'John Updated']);

        $response = $this->putJson('/api/v1/users/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => 1, 'name' => 'John Updated']
            ]);
    }

    public function test_destroy_deletes_user()
    {
        $this->userService
            ->shouldReceive('deleteUser')
            ->once()
            ->with(1)
            ->andReturnTrue();

        $response = $this->deleteJson('/api/v1/users/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => 'User Deleted Successfully'
            ]);
    }

    public function test_update_password()
    {
        $this->userService
            ->shouldReceive('updatePassword')
            ->once()
            ->with(1, 'newpassword')
            ->andReturn(['id' => 1, 'name' => 'John Doe']);

        $response = $this->putJson('/api/v1/users/1/password', ['password' => 'newpassword']);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_assign_role_to_user()
    {
        $userMock = Mockery::mock();
        $userMock->shouldReceive('load')->andReturn(['id' => 1, 'roles' => ['Admin']]);

        $this->userService
            ->shouldReceive('assignRole')
            ->once()
            ->with(1, ['Admin'])
            ->andReturn($userMock);

        $response = $this->postJson('/api/v1/users/1/assign-role', ['roles' => ['Admin']]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_give_permission_to_user()
    {
        $userMock = Mockery::mock();
        $userMock->shouldReceive('load')->with('permissions')->andReturn(['id' => 1, 'permissions' => ['edit posts']]);

        $this->userService
            ->shouldReceive('givePermission')
            ->once()
            ->with(1, ['edit posts'])
            ->andReturn($userMock);

        $response = $this->postJson('/api/v1/users/1/give-permission', ['permissions' => ['edit posts']]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_get_users_by_role()
    {
        $this->userService
            ->shouldReceive('getUsersByRole')
            ->once()
            ->with('Admin')
            ->andReturn([['id' => 1, 'name' => 'John Doe']]);

        $response = $this->getJson('/api/v1/users/role/Admin');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_get_users_with_permission()
    {
        $this->userService
            ->shouldReceive('getUsersWithPermission')
            ->once()
            ->with('edit posts')
            ->andReturn([['id' => 1, 'name' => 'John Doe']]);

        $response = $this->getJson('/api/v1/users/permission/edit posts');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
