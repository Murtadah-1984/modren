<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Modules\User\Interface\Http\Requests\Users\UpdatePasswordRequest;

it('passes with valid password change data', function () {
    $data = [
        'current_password' => 'OldPass1!',
        'password' => 'NewPass2!',
        'password_confirmation' => 'NewPass2!',
    ];

    $request = new UpdatePasswordRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());
    expect($validator->passes())->toBeTrue();
});

it('fails when confirmation does not match', function () {
    $data = [
        'current_password' => 'OldPass1!',
        'password' => 'NewPass2!',
        'password_confirmation' => 'DifferentPass!',
    ];

    $request = new UpdatePasswordRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('password'))
        ->toContain('confirmation');
});
