<?php

use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has one profile', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    expect($user->profile)->toBeInstanceOf(Profile::class);
    expect($user->profile->id)->toBe($profile->id);
});

it('scopeActive returns only active users', function () {
    $activeUser = User::factory()->create(['is_active' => true]);
    User::factory()->create(['is_active' => false]);

    $result = User::active()->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->id)->toBe($activeUser->id);
});

it('scopeInactive returns only inactive users', function () {
    User::factory()->create(['is_active' => true]);
    $inactiveUser = User::factory()->create(['is_active' => false]);

    $result = User::inactive()->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->id)->toBe($inactiveUser->id);
});

it('scopeVerified returns users with verified emails', function () {
    $verifiedUser = User::factory()->create(['email_verified_at' => now()]);
    User::factory()->create(['email_verified_at' => null]);

    $result = User::verified()->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->id)->toBe($verifiedUser->id);
});

it('scopeUnverified returns users with null email_verified_at', function () {
    User::factory()->create(['email_verified_at' => now()]);
    $unverifiedUser = User::factory()->create(['email_verified_at' => null]);

    $result = User::unverified()->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->id)->toBe($unverifiedUser->id);
});

it('checks if user is active', function () {
    $user = User::factory()->make(['is_active' => true]);
    expect($user->isActive())->toBeTrue();
});

it('checks if user is inactive', function () {
    $user = User::factory()->make(['is_active' => false]);
    expect($user->isActive())->toBeFalse();
});

it('checks if user is verified', function () {
    $user = User::factory()->make(['email_verified_at' => now()]);
    expect($user->isVerified())->toBeTrue();
});

it('checks if user is unverified', function () {
    $user = User::factory()->make(['email_verified_at' => null]);
    expect($user->isVerified())->toBeFalse();
});
