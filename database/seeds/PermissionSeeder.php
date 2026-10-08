<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create = [
            [
                'name' => 'show_setting',
                'name_ar' => 'الاعدادت العامة',
                'name_en' => 'App Setting'
            ],
            [
                'name' => 'edit_setting',
                'name_ar' => 'ضبط الاعدات العامة',
                'name_en' => 'Edit App Setting'
            ],
            [
                'name' => 'edit_photo',
                'name_ar' => 'تعديل صورة',
                'name_en' => 'Edit Photo'
            ],
            [
                'name' => 'show_employee',
                'name_ar' => 'عرض الموظفين',
                'name_en' => 'Show Employee'
            ],
            [
                'name' => 'add_employee',
                'name_ar' => 'اضافة موظف',
                'name_en' => 'Add Employee'
            ],
            [
                'name' => 'edit_employee',
                'name_ar' => 'تعديل موظف',
                'name_en' => 'Edit Employee'
            ],
            [
                'name' => 'delete_employee',
                'name_ar' => 'حذف موظف',
                'name_en' => 'Delete Employee'
            ],
        ];
        foreach ($create as $value) {
            Permission::create($value);
        }
    }
}
