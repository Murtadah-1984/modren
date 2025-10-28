<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Modules\RBAC\Interface\Http\Requests\Roles\StoreRoleRequest;

it('passes with valid role data', function () {
    $data = [
        'name' => 'admin-role',
        'guard_name' => 'web',
        'permissions' => ['view-users'],
    ];

    $request = new StoreRoleRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
});

it('fails when name is missing', function () {
    $data = ['guard_name' => 'web'];

    $request = new StoreRoleRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('name'))
        ->toContain('required');
});

it('sets default guard_name if not provided', function () {
    config(['auth.defaults.guard' => 'web']);

    $request = new StoreRoleRequest();
    $request->merge(['name' => 'editor-role']);
    $request->prepareForValidation();

    expect($request->input('guard_name'))->toBe('web');
});
