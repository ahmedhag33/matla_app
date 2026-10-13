<?php

namespace Database\Seeders;

use App\Models\WorkspaceRoles;
use Illuminate\Database\Seeder;

class WorkspaceRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [
            [
                'name' => 'رئيس التحرير',
                'name_en' => 'Chief Editor',
                'level' => 1,
            ],
            [
                'name' => 'محرر',
                'name_en' => 'Editor',
                'level' => 2,
            ],
            [
                'name' => 'معدّ',
                'name_en' => 'Preparer',
                'level' => 3,
            ],
            [
                'name' => 'مذيع',
                'name_en' => 'Presenter',
                'level' => 3,
            ],
        ];
        foreach ($arr as $value) {
            WorkspaceRoles::create($value);
        }
    }
}
