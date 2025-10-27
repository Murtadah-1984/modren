<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('belongs to a user', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    expect($profile->user)->toBeInstanceOf(User::class);
    expect($profile->user->id)->toBe($user->id);
});

it('returns a full address correctly', function () {
    $profile = Profile::factory()->make([
        'address' => '123 Main St',
        'city' => 'Basra',
        'state' => 'Basra Governorate',
        'postal_code' => '61001',
        'country' => 'Iraq',
    ]);

    expect($profile->full_address)->toBe('123 Main St, Basra, Basra Governorate, 61001, Iraq');
});

it('returns age correctly from date of birth', function () {
    $profile = Profile::factory()->make([
        'date_of_birth' => now()->subYears(25),
    ]);

    expect($profile->age)->toBe(25);
});

it('returns null age if no date of birth', function () {
    $profile = Profile::factory()->make(['date_of_birth' => null]);

    expect($profile->age)->toBeNull();
});
