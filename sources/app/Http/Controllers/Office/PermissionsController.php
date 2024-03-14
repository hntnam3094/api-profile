<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Services\PermissionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware(['role:system-admin|admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->permissionService->getAllRoles();
        return Inertia::render('Office/Permission/PermissionList', [
            'role' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->permissionService->getPermissionByRoleId($id);
        $permission = $this->permissionService->getDefaultPermisson($id);
        return Inertia::render('Office/Permission/PermissionDetail', [
            'role' => $role,
            'permission' => $permission,
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->permissionService->getPermissionByRoleId($id);
        $permission = $this->permissionService->getDefaultPermisson($id);
        return Inertia::render('Office/Permission/PermissionAdd', [
            'role' => $role,
            'permission' => $permission,
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->permissionService->updatePermissionByRole($id, $request->all());

        return redirect(route('permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
