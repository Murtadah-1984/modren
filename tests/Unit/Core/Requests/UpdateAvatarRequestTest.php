<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Modules\User\Interface\Http\Requests\Users\UpdateAvatarRequest;

it('passes with valid image upload', function () {
    $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

    $data = ['avatar' => $file];
    $request = new UpdateAvatarRequest();

    $validator = Validator::make($data, $request->rules(), $request->messages());
    expect($validator->passes())->toBeTrue();
});

it('fails when avatar is missing', function () {
    $request = new UpdateAvatarRequest();

    $validator = Validator::make([], $request->rules(), $request->messages());
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('avatar'))
        ->toContain('upload an avatar');
});
