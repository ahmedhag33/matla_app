<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkspacePermission;
use App\Models\WorkspaceRolePermission;
use App\Models\WorkspaceRoles;
use App\Service\Base\JsonAPIMessages;
use Illuminate\Http\Request;

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
        $code = null;
        // get all permissions
        $permissions_ids = [];
        // get all permissions
        $permissions = WorkspacePermission::with('children')
            ->parentIsNull()
            ->get();
        // get all permissions
        $roles = WorkspaceRoles::select('id', 'name', 'slug')->get();
        // get the role
        if (request()->filled('role')) {
            // get the role
            $code = request()->input('role');
            // get the role permissions
            $permissions_ids = WorkspaceRolePermission::whereIn(
                'workspace_role_id',
                WorkspaceRoles::where('slug', $code)->pluck('id')
            )->pluck('workspace_permission_id')->toArray();
        }
        return view(
            'dashboard.permissions.index',
            compact('permissions', 'roles', 'code', 'permissions_ids')
        );
    }
    /**
     * role permission store and update
     *
     * @return \Illuminate\Http\JsonResponse|string
     * */
    public function update_permission(Request $request)
    {
        try {
            runTransaction(function () use ($request) {
                WorkspaceRolePermission::create([
                    'workspace_role_id' => $request->input('role_id'),
                    'workspace_permission_id' => $request->input('permission_id'),
                ]);
            });
            return $this->returnData(['message' => 'success']);
        } catch (\Exception $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        }
    }
    /**
     * role permission delete
     *
     * @return \Illuminate\Http\JsonResponse|string
     * */
    public function delete_permission(Request $request)
    {
        try {
            runTransaction(function () use ($request) {
                WorkspaceRolePermission::where('workspace_role_id', $request->input('role_id'))->where('workspace_permission_id', $request->input('permission_id'))->delete();
            });
            return $this->returnData(['message' => 'success']);
        } catch (\Exception $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        }
    }
}
