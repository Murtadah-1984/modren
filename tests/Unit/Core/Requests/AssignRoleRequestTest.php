<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Modules\User\Interface\Http\Requests\Users\AssignRoleRequest;

it('passes with valid roles array', function () {
    $data = ['roles' => ['admin', 'editor']];
    $request = new AssignRoleRequest();

    $validator = Validator::make($data, $request->rules());
    expect($validator->passes())->toBeTrue();
});

it('fails if roles is not an array', function () {
    $data = ['roles' => 'admin'];
    $request = new AssignRoleRequest();

    $validator = Validator::make($data, $request->rules(), $request->messages());
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('roles'))
        ->toContain('array');
});

it('fails if roles array is empty', function () {
    $data = ['roles' => []];
    $request = new AssignRoleRequest();

    $validator = Validator::make($data, $request->rules());
    expect($validator->fails())->toBeTrue();
});
