<?php

declare(strict_types=1);

namespace Modules\Core\Interface\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CoreWebController extends Controller
{
    /**
     * Render a view with standardized data
     */
    protected function render(string $view, array $data = []): View
    {
        // You can add default layout variables here if needed
        $defaultData = [
            'appName' => config('app.name'),
        ];

        return view($view, array_merge($defaultData, $data));
    }

    /**
     * Redirect back with success message
     */
    protected function redirectSuccess(string $message, ?string $route = null): RedirectResponse
    {
        $redirect = $route ? redirect()->route($route) : redirect()->back();

        return $redirect->with('success', $message);
    }

    /**
     * Redirect back with error message
     */
    protected function redirectError(string $message, ?string $route = null): RedirectResponse
    {
        $redirect = $route ? redirect()->route($route) : redirect()->back();

        return $redirect->with('error', $message);
    }

    /**
     * Optional: Flash warning message
     */
    protected function redirectWarning(string $message, ?string $route = null): RedirectResponse
    {
        $redirect = $route ? redirect()->route($route) : redirect()->back();

        return $redirect->with('warning', $message);
    }
}
