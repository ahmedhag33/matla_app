<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\WorkspaceRoles;

class InventionController extends Controller
{
    /**
     * show the index page for inventions
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = WorkspaceRoles::notHighest()->get();
        // Pass the non-highest level roles to the view
        return view('workspace.invention.index', compact('roles'));
    }
}
