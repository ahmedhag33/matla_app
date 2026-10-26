<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\WorkspaceInvitations;
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
        // Fetch all workspace invitations with their related invitedBy and role models
        $inventions = WorkspaceInvitations::with(['invitedBy', 'role'])->get();
        // Pass the non-highest level roles to the view
        return view('workspace.invention.index', compact('roles', 'inventions'));
    }
}
