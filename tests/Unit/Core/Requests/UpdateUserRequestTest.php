<?php

use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

it('passes with valid update data', function () {
    $data = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'UpdatedPass1!',
    ];

    $request = new UpdateUserRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
});

it('fails when email is invalid', function () {
    $data = [
        'name' => 'Jane Doe',
        'email' => 'invalid-email',
    ];

    $request = new UpdateUserRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('email'))
        ->toContain('valid email');
});
