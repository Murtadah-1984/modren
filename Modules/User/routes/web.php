<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Interface\Http\Controllers\UserWebController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserWebController::class)->names('user');
});
