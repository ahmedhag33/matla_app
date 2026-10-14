<?php

namespace Database\Seeders;

use App\Models\WorkspacePermission;
use App\Models\WorkspaceRolePermission;
use App\Models\WorkspaceRoles;
use Illuminate\Database\Seeder;

class ChiefOfEditorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = WorkspacePermission::whereNotNull('parent_id')->get();
        // get the role
        $role = WorkspaceRoles::where('slug', 'chief-editor')->first();
        // loop through the permissions
        foreach ($permissions as $permission) {
           WorkspaceRolePermission::create([
              'workspace_role_id' => $role->id,
              'workspace_permission_id' => $permission->id
           ]);
        }
    }
}
