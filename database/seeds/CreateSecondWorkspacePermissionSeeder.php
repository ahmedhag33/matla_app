<?php

namespace Database\Seeders;

use App\Models\WorkspacePermission;
use Illuminate\Database\Seeder;

class CreateSecondWorkspacePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'name' => 'ادارة المراجعة',
            'slug' => 'review-manager',
            'children' => [
                [
                    'name' => 'تعديل المراجعة',
                    'slug' => 'edit-review',
                ],
                [
                    'name' => 'حذف المراجعة',
                    'slug' => 'delete-review',
                ],
                [
                    'name' => 'عرض المراجعة',
                    'slug' => 'view-review',
                ],
                [
                    'name' => 'اضافة المراجعة',
                    'slug' => 'add-review',
                ],
            ]
        ];
        $create = WorkspacePermission::create([
            'name' => $permissions['name'],
            'slug' => $permissions['slug'],
        ]);
        foreach ($permissions['children'] as $child) {
            $child['parent_id'] = $create->id;
            WorkspacePermission::create($child);
        }
    }
}
