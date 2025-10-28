<?php

declare(strict_types=1);

namespace Modules\Auth\Interface\Http\Controllers\Web;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Routing\Controller;

final class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset BaseController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';
}
