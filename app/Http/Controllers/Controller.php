<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use ReflectionClass;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function success($data = [], string $message = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function error(string $message = null, int $status = 400, $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    /**
     * get the scope defined in model.
     * @throws \ReflectionException
     */

    public function getModelScopes($model_name): \Illuminate\Support\Traits\EnumeratesValues|\Illuminate\Support\Collection
    {
        $model="\\App\\Models\\".$model_name;
        $reflection = new ReflectionClass($model);

        return collect($reflection->getMethods())->filter(function ($method) {
            return Str::startsWith($method->name, 'scope');
        })->whereNotIn('name', ['scopeWithTranslations', 'scopeWithTranslation', 'scopeWhereTranslation'])->transform(function ($method) {
            return lcfirst(Str::replaceFirst('scope', '', $method->name));
        });
    }
}
