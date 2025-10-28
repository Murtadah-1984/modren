<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Modules\RBAC\Domain\Events\Permissions\PermissionCreated;
use Modules\RBAC\Domain\Events\Permissions\PermissionDeleted;
use Modules\RBAC\Domain\Events\Permissions\PermissionsSyncedToRole;
use Modules\RBAC\Domain\Events\Permissions\PermissionUpdated;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionCreationException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionNotFoundException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionUpdateException;
use Modules\RBAC\Infrastructure\Repositories\EloquentPermissionRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = new EloquentPermissionRepository(new Permission());
    Event::fake();
});

it('creates a permission successfully', function () {
    $permission = $this->repository->create([
        'name' => 'edit articles',
        'guard_name' => 'web',
    ]);

    expect($permission)->toBeInstanceOf(Permission::class)
        ->and($permission->name)->toBe('edit articles');

    Event::assertDispatched(PermissionCreated::class);
});

it('throws creation exception on failure', function () {
    DB::shouldReceive('beginTransaction')->once();
    DB::shouldReceive('commit')->never();
    DB::shouldReceive('rollBack')->once();

    $this->repository = Mockery::mock(EloquentPermissionRepository::class.'[create]', [new Permission()])
        ->shouldAllowMockingProtectedMethods();
    $this->repository->shouldReceive('create')->andThrow(new Exception('DB error'));

    expect(fn () => $this->repository->create(['name' => 'fail']))->toThrow(PermissionCreationException::class);
});

it('finds permission by id', function () {
    $permission = Permission::create(['name' => 'view users', 'guard_name' => 'web']);
    $found = $this->repository->findById($permission->id);

    expect($found->id)->toBe($permission->id);
});

it('throws exception if permission not found by id', function () {
    expect(fn () => $this->repository->findById(9999))->toThrow(PermissionNotFoundException::class);
});

it('finds permission by name', function () {
    $permission = Permission::create(['name' => 'delete users', 'guard_name' => 'web']);
    $found = $this->repository->findByName('delete users');

    expect($found->name)->toBe('delete users');
});

it('returns all permissions', function () {
    Permission::factory()->count(3)->create(['guard_name' => 'web']);
    $all = $this->repository->all();

    expect($all)->toHaveCount(3);
});

it('updates permission successfully', function () {
    $permission = Permission::create(['name' => 'publish', 'guard_name' => 'web']);

    $updated = $this->repository->update($permission, ['name' => 'publish articles']);

    expect($updated->name)->toBe('publish articles');
    Event::assertDispatched(PermissionUpdated::class);
});

it('throws update exception on failure', function () {
    $permission = Permission::create(['name' => 'to-update', 'guard_name' => 'web']);

    $mock = Mockery::mock($this->repository)->makePartial();
    $mock->shouldReceive('update')->andThrow(new Exception('DB failed'));

    expect(fn () => $mock->update($permission, []))->toThrow(PermissionUpdateException::class);
});

it('deletes permission successfully', function () {
    $permission = Permission::create(['name' => 'archive', 'guard_name' => 'web']);

    $result = $this->repository->delete($permission);

    expect($result)->toBeTrue();
    Event::assertDispatched(PermissionDeleted::class);
});

it('finds or creates permission', function () {
    $permission = $this->repository->findOrCreate('export data');
    expect($permission)->toBeInstanceOf(Permission::class)
        ->and($permission->name)->toBe('export data');
});

it('returns permissions by guard name', function () {
    Permission::create(['name' => 'manage', 'guard_name' => 'api']);
    $result = $this->repository->getByGuard('api');

    expect($result->first()->guard_name)->toBe('api');
});

it('returns all guard names distinct', function () {
    Permission::create(['name' => 'a', 'guard_name' => 'web']);
    Permission::create(['name' => 'b', 'guard_name' => 'api']);

    $guards = $this->repository->getAllGuardNames();

    expect($guards)->toContain('web', 'api');
});

it('searches permissions by name', function () {
    Permission::create(['name' => 'read articles', 'guard_name' => 'web']);
    Permission::create(['name' => 'write posts', 'guard_name' => 'web']);

    $results = $this->repository->search('read');

    expect($results)->toHaveCount(1)
        ->and($results->first()->name)->toBe('read articles');
});

it('syncs permissions to a role', function () {
    $role = Role::create(['name' => 'editor', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit', 'guard_name' => 'web']);

    $this->repository->syncToRole('editor', [$permission->name]);

    expect($role->permissions->pluck('name'))->toContain('edit');

    Event::assertDispatched(PermissionsSyncedToRole::class);
});
