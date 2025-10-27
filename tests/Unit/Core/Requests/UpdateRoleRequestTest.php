<?php

use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Support\Facades\Validator;

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
