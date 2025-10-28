<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Modules\RBAC\Interface\Http\Requests\Roles\UpdateRoleRequest;

it('passes with valid data', function () {
    $data = ['name' => 'manager', 'guard_name' => 'web'];

    $request = new UpdateRoleRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
});

it('fails with invalid name format', function () {
    $data = ['name' => 'bad@role'];

    $request = new UpdateRoleRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('name'))
        ->toContain('can only contain');
});
