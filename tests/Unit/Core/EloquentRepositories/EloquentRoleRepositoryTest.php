<?php

use App\Repositories\EloquentRoleRepository;
use App\Exceptions\Roles\{
    RoleNotFoundException,
    RoleCreationException,
    RoleUpdateException,
    RoleDeletionException
};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->repository = new EloquentRoleRepository(new Role());
    config()->set('auth.defaults.guard', 'web');
    Event::fake();
});

it('can create a role', function () {
    $role = $this->repository->create([
        'name' => 'tester',
        'guard_name' => 'web',
    ]);

    expect($role)->toBeInstanceOf(Role::class)
        ->and($role->name)->toBe('tester')
        ->and(DB::table('roles')->where('name', 'tester')->exists())->toBeTrue();
});

it('throws exception if role creation fails', function () {
    $this->repository = new EloquentRoleRepository(new class {
        public function create() { throw new Exception('DB error'); }
    });

    $this->repository->create(['name' => 'x']);
})->throws(RoleCreationException::class);

it('can find a role by id', function () {
    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $found = $this->repository->findById($role->id);

    expect($found->id)->toBe($role->id);
});

it('throws exception when finding non-existent role by id', function () {
    $this->repository->findById(9999);
})->throws(RoleNotFoundException::class);

it('can update a role', function () {
    $role = Role::create(['name' => 'old', 'guard_name' => 'web']);
    $updated = $this->repository->update($role, ['name' => 'new']);

    expect($updated->name)->toBe('new');
});

it('throws exception when update fails', function () {
    $role = Role::create(['name' => 'test', 'guard_name' => 'web']);
    $mockRepo = new EloquentRoleRepository(new class {
        public function update() { throw new Exception('Update fail'); }
    });

    $mockRepo->update($role, ['name' => 'bad']);
})->throws(RoleUpdateException::class);

it('can delete a role', function () {
    $role = Role::create(['name' => 'temp', 'guard_name' => 'web']);
    $deleted = $this->repository->delete($role);

    expect($deleted)->toBeTrue()
        ->and(Role::find($role->id))->toBeNull();
});

it('throws exception when delete fails', function () {
    $mockRepo = new EloquentRoleRepository(new class {
        public function delete() { throw new Exception('delete fail'); }
    });

    $mockRepo->delete(new Role());
})->throws(RoleDeletionException::class);

it('can find or create a role', function () {
    $role = $this->repository->findOrCreate('super-admin');
    expect($role)->toBeInstanceOf(Role::class)
        ->and($role->name)->toBe('super-admin');
});

it('can check if role exists', function () {
    Role::create(['name' => 'moderator', 'guard_name' => 'web']);
    expect($this->repository->exists('moderator'))->toBeTrue()
        ->and($this->repository->exists('not-exist'))->toBeFalse();
});

it('can get all roles', function () {
    Role::create(['name' => 'a', 'guard_name' => 'web']);
    Role::create(['name' => 'b', 'guard_name' => 'web']);

    $roles = $this->repository->all();
    expect($roles)->toHaveCount(2);
});
