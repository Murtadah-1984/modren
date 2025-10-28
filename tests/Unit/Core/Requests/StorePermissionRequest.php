<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Modules\RBAC\Interface\Http\Requests\Permissions\StorePermissionRequest;

it('passes validation with valid data', function () {
    $data = [
        'name' => 'view-users',
        'guard_name' => 'web',
    ];

    $request = new StorePermissionRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBeTrue();
});

it('fails validation if name is missing', function () {
    $data = ['guard_name' => 'web'];

    $request = new StorePermissionRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('name'))
        ->toContain('required');
});

it('fails validation if name contains invalid characters', function () {
    $data = ['name' => 'invalid@name', 'guard_name' => 'web'];

    $request = new StorePermissionRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('name'))
        ->toContain('can only contain');
});

it('sets default guard_name if not provided', function () {
    config(['auth.defaults.guard' => 'web']);
    $request = new StorePermissionRequest();

    $request->merge(['name' => 'create-user']);
    $request->prepareForValidation();

    expect($request->input('guard_name'))->toBe('web');
});
