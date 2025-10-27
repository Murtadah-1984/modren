<?php

use App\Http\Requests\Roles\AssignPermissionRequest;
use Illuminate\Support\Facades\Validator;

it('passes with valid permissions array', function () {
    $data = [
        'permissions' => ['view-users', 'edit-users'],
        'guard_name' => 'web',
    ];

    $request = new AssignPermissionRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
});

it('fails if permissions is not an array', function () {
    $data = ['permissions' => 'invalid-string'];

    $request = new AssignPermissionRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('permissions'))
        ->toContain('array');
});
