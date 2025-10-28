<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Modules\User\Domain\Exceptions\UserCreationException;
use Modules\User\Domain\Exceptions\UserDeletionException;
use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserUpdateException;
use Modules\User\Infrastructure\Repositories\EloquentUserRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('auth.defaults.guard', 'web');
    Event::fake();
    $this->repository = new EloquentUserRepository(new User());
});

it('can create a user', function () {
    $user = $this->repository->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret123',
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and(Hash::check('secret123', $user->password))->toBeTrue()
        ->and($user->email)->toBe('john@example.com');
});

it('throws exception when user creation fails', function () {
    $repo = new EloquentUserRepository(new class
    {
        public function create()
        {
            throw new Exception('fail');
        }
    });

    $repo->create(['email' => 'x@example.com']);
})->throws(UserCreationException::class);

it('can find a user by id', function () {
    $user = User::factory()->create();
    $found = $this->repository->findById($user->id);
    expect($found->id)->toBe($user->id);
});

it('throws exception when user not found by id', function () {
    $this->repository->findById(9999);
})->throws(UserNotFoundException::class);

it('can update a user', function () {
    $user = User::factory()->create(['name' => 'Old']);
    $updated = $this->repository->update($user, ['name' => 'New']);
    expect($updated->name)->toBe('New');
});

it('throws exception when update fails', function () {
    $repo = new EloquentUserRepository(new class
    {
        public function update()
        {
            throw new Exception('fail');
        }
    });

    $repo->update(new User(), ['name' => 'X']);
})->throws(UserUpdateException::class);

it('can delete a user', function () {
    $user = User::factory()->create();
    $deleted = $this->repository->delete($user);
    expect($deleted)->toBeTrue()
        ->and(User::find($user->id))->toBeNull();
});

it('throws exception when delete fails', function () {
    $repo = new EloquentUserRepository(new class
    {
        public function delete()
        {
            throw new Exception('fail');
        }
    });
    $repo->delete(new User());
})->throws(UserDeletionException::class);

it('can update avatar', function () {
    $user = User::factory()->create(['avatar' => null]);
    $updated = $this->repository->updateAvatar($user, 'avatars/avatar1.png');
    expect($updated->avatar)->toBe('avatars/avatar1.png');
});

it('can remove avatar', function () {
    $user = User::factory()->create(['avatar' => 'old.png']);
    $updated = $this->repository->removeAvatar($user);
    expect($updated->avatar)->toBeNull();
});

it('can update password', function () {
    $user = User::factory()->create(['password' => bcrypt('oldpass')]);
    $updated = $this->repository->updatePassword($user, 'newpass');
    expect(Hash::check('newpass', $updated->password))->toBeTrue();
});

it('can assign and remove roles', function () {
    $user = User::factory()->create();
    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);

    $this->repository->assignRole($user, 'admin');
    expect($user->hasRole('admin'))->toBeTrue();

    $this->repository->removeRole($user, 'admin');
    expect($user->hasRole('admin'))->toBeFalse();
});

it('can sync roles', function () {
    $user = User::factory()->create();
    Role::create(['name' => 'editor', 'guard_name' => 'web']);
    Role::create(['name' => 'viewer', 'guard_name' => 'web']);

    $this->repository->syncRoles($user, ['editor', 'viewer']);
    expect($user->roles->pluck('name')->toArray())->toContain('editor', 'viewer');
});

it('can give, revoke and sync permissions', function () {
    $user = User::factory()->create();
    Permission::create(['name' => 'edit posts', 'guard_name' => 'web']);
    Permission::create(['name' => 'delete posts', 'guard_name' => 'web']);

    $this->repository->givePermission($user, 'edit posts');
    expect($user->hasPermissionTo('edit posts'))->toBeTrue();

    $this->repository->revokePermission($user, 'edit posts');
    expect($user->hasPermissionTo('edit posts'))->toBeFalse();

    $this->repository->syncPermissions($user, ['edit posts', 'delete posts']);
    expect($user->permissions->pluck('name')->toArray())->toContain('edit posts', 'delete posts');
});

it('can search by name or email', function () {
    User::factory()->create(['name' => 'Alice', 'email' => 'alice@mail.com']);
    User::factory()->create(['name' => 'Bob', 'email' => 'bob@mail.com']);

    $results = $this->repository->search('Ali');
    expect($results)->toHaveCount(1)
        ->and($results->first()->name)->toBe('Alice');
});
