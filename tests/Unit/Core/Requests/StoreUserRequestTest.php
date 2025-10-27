<?php

use App\Http\Requests\Users\StoreUserRequest;
use Illuminate\Support\Facades\Validator;

it('passes with valid user data', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'StrongPass1!',
    ];

    $request = new StoreUserRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
});

it('fails when email is invalid', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'not-an-email',
        'password' => 'StrongPass1!',
    ];

    $request = new StoreUserRequest();
    $validator = Validator::make($data, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('email'))
        ->toContain('valid email');
});

it('fails when password is too weak', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => '1234',
    ];

    $request = new StoreUserRequest();
    $validator = Validator::make($data, $request->rules());
    expect($validator->fails())->toBeTrue();
});
