<?php

declare(strict_types=1);

namespace Modules\Core\Interface\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CoreApiController extends Controller
{
    /**
     * Return a standardized JSON success response
     *
     * @param  mixed  $data
     */
    protected function success($data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message ?? 'Request successful',
            'data' => $data,
        ];

        return response()->json($response, $status);
    }

    /**
     * Return a standardized JSON error response
     *
     * @param  mixed  $errors
     */
    protected function error(?string $message = null, int $status = 400, $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message ?? 'Something went wrong',
            'errors' => $errors,
        ];

        return response()->json($response, $status);
    }

    /**
     * Return a standardized JSON paginated response
     *
     * @param  LengthAwarePaginator  $paginator
     */
    protected function paginate($paginator, ?string $message = null): JsonResponse
    {
        return $this->success([
            'items' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ], $message ?? 'Paginated results');
    }

    /**
     * Optional: Handle request validation in a standardized way
     */
    protected function validateRequest(Request $request, array $rules, array $messages = []): void
    {
        $request->validate($rules, $messages);
    }
}
