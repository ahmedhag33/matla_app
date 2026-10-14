<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkspacePermission;
use App\Models\WorkspaceRoles;
use App\Service\Base\JsonAPIMessages;

class RoleController extends Controller
{
    use JsonAPIMessages;
    /**
     * Show the application dashboard.
     *
     *  @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = WorkspaceRoles::get();
        // get all roles
        return view('dashboard.role.index', compact('roles'));
    }
    /**
     * Show the application dashboard.
     *
     *  @return \Illuminate\View\View
     */
    public function role_permission()
    {
        $permissions = WorkspacePermission::with('children')->parentIsNull()->get();

        $roles = WorkspaceRoles::select('id', 'name','slug')->get();
        // get all permissions
        return view('dashboard.permissions.index', compact('permissions', 'roles'));
    }
}
