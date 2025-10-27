<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\View\Factory;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;

final class PermissionDataTableController extends Controller
{
    public function __construct(
        protected PermissionService $permissionService
    ) {
        // Permission middleware
        $this->middleware('permission:view users')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @throws Exception
     */
    public function index(): View|Factory|JsonResponse|DataTableAbstract
    {
        $columns = json_encode(['name', 'guard_name']);

        // If the request is made through AJAX, retrieve the users data and return it as a JSON response
        if (request()->ajax()) {
            $permissions = $this->permissionService->getAllPermissions();

            return dataTables($permissions)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox"  class="checkbox" value="'.$data->id.'" name="checkbox[]" data-id="'.$data->id.'" >';
                })
                ->addColumn('role', function ($item) {
                    return $item->role->display_name;
                })
                ->addColumn('roles', function ($item) {
                    return $item->roles->pluck('display_name')->implode('<br>');
                })
                ->addColumn('action', function ($data) {
                    return view('users.action', compact('data'));
                })
                ->rawColumns(['action', 'checkbox', 'role', 'roles'])
                ->addIndexColumn()
                ->make(true);
        }

        // If the request is not made through AJAX, return a view that renders the DataTable
        return view('users.index', compact('columns'));
    }
}
