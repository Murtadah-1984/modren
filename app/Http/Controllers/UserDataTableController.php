<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UserService;
use Yajra\DataTables\Facades\DataTables;

final class UserDataTableController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        $this->middleware('permission:users.view')->only(['index']);
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        $columns = json_encode(['name', 'email', 'roles']);

        if (request()->ajax()) {
            // IMPORTANT: Keep it as a query, don't call ->get()
            $users = $this->userService->getAllUsers(['roles:id,name']);

            return DataTables::collection($users)
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="checkbox" value="'.$user->id.'" name="checkbox[]" data-id="'.$user->id.'">';
                })
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode('<br>');
                })
                ->addColumn('actions', function ($user) {
                    return view('users.action', compact('user'))->render();
                })
                ->rawColumns(['checkbox', 'actions', 'roles'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('users.index', compact('columns'));
    }
}
