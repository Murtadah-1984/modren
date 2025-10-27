<?php

use App\Http\Requests\Permissions\UpdatePermissionRequest;
use Illuminate\Support\Facades\Validator;

it('passes with valid update data', function () {
    $data = ['name' => 'update-users', 'guard_name' => 'web'];

    $request = new UpdatePermissionRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBeTrue();
});

it('fails when name format is invalid', function () {
    $data = ['name' => 'bad@name'];

    $request = new UpdatePermissionRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('name'))
        ->toContain('can only contain');
});
