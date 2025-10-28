<?php

declare(strict_types=1);

namespace Modules\RBAC\Interface\Http\Controllers;

use Modules\Core\Interface\Http\Controllers\CoreWebController;

final class PermissionWebController extends CoreWebController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rbac::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rbac::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('rbac::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('rbac::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
