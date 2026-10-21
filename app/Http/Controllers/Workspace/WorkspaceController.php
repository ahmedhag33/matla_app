<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\WorkspaceType;
use App\Service\Base\JsonAPIMessages;

class WorkspaceController extends Controller
{
    use JsonAPIMessages;
    /**
     * show create workspace page
     *
     * @return \Illuminate\View\View
     */
    public function createPage()
    {
        // select all workspace types
        $workspaceTypes = WorkspaceType::all();
        // select all countries
        $countries = Country::all();
        // return view
        return view('membership.workspace.create', compact('workspaceTypes', 'countries'));
    }
}
