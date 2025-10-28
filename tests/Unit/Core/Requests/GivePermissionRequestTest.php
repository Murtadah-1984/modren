<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Modules\User\Interface\Http\Requests\Users\GivePermissionRequest;

it('passes with valid permissions array', function () {
    $data = ['permissions' => ['view-users', 'edit-users']];
    $request = new GivePermissionRequest();

    $validator = Validator::make($data, $request->rules());
    expect($validator->passes())->toBeTrue();
});

it('fails if permissions is not an array', function () {
    $data = ['permissions' => 'invalid'];
    $request = new GivePermissionRequest();

    $validator = Validator::make($data, $request->rules(), $request->messages());
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('permissions'))
        ->toContain('array');
});
