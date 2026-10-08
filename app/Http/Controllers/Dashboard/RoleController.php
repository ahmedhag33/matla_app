<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
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
        $roles = Role::get();
        // get all roles
        return view('dashboard.role.index', compact('roles'));
    }
}
