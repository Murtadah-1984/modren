<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

final class LoadUserPreferences
{
    public function handle($request, Closure $next)
    {
        if ($user = auth()->user()) {
            $prefs = $user->preference;

            if ($prefs) {
                // Apply language
                App::setLocale($prefs->language ?? 'en');

                // Share with all Blade views
                View::share('userTheme', [
                    'theme' => $prefs->theme,
                    'layout' => $prefs->layout,
                    'vibe' => $prefs->vibe,
                    'language' => $prefs->language,
                ]);
            }
        }

        return $next($request);
    }
}
