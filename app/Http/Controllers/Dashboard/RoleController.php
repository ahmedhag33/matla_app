<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        return view('dashboard.permissions.index');
    }
}
