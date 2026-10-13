<?php

namespace Database\Seeders;

use App\Models\WorkspacePermission;
use Illuminate\Database\Seeder;

class WorkspacePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workspace_permissions = [
            [
                'name' => 'ادارة مساحة العمل',
                'slug' => 'manage-workspace',
                'children' => [
                    [
                        'name' => 'اضافة مساحة عمل',
                        'slug' => 'add-workspace',
                    ],
                    [
                        'name' => 'تعديل مساحة عمل',
                        'slug' => 'edit-workspace',
                    ],
                    [
                        'name' => 'حذف مساحة عمل',
                        'slug' => 'delete-workspace',
                    ],
                    [
                        'name' => 'عرض مساحة عمل',
                        'slug' => 'view-workspace',
                    ],
                    [
                        'name' => 'دعوة الاعضاء',
                        'slug' => 'invite-members',
                    ],
                    [
                        'name' => 'حذف الاعضاء',
                        'slug' => 'remove-members',
                    ],
                    [
                        'name' => 'عرض الاعضاء',
                        'slug' => 'view-members',
                    ],
                ]
            ],
            [
                'name' => 'ادارة البرامج',
                'slug' => 'manage-programs',
                'children' => [
                    [
                        'name' => 'اضافة برنامج',
                        'slug' => 'add-program',
                    ],
                    [
                        'name' => 'تعديل برنامج',
                        'slug' => 'edit-program',
                    ],
                    [
                        'name' => 'حذف برنامج',
                        'slug' => 'delete-program',
                    ],
                    [
                        'name' => 'عرض برنامج',
                        'slug' => 'view-program',
                    ],
                    [
                        'name' => 'اضافة الحلقات',
                        'slug' => 'add-episodes',
                    ],
                    [
                        'name' => 'تعديل الحلقات',
                        'slug' => 'edit-episodes',
                    ],
                    [
                        'name' => 'حذف الحلقات',
                        'slug' => 'delete-episodes',
                    ],
                    [
                        'name' => 'عرض الحلقات',
                        'slug' => 'view-episodes',
                    ],
                    [
                        'name' => 'اضافةالفقرات',
                        'slug' => 'add-segments',
                    ],
                    [
                        'name' => 'تعديل الفقرات',
                        'slug' => 'edit-segments',
                    ],
                    [
                        'name' => 'حذف الفقرات',
                        'slug' => 'delete-segments',
                    ],
                    [
                        'name' => 'عرض الفقرات',
                        'slug' => 'view-segments',
                    ],
                    [
                        'name' => 'اضافة المواضيع',
                        'slug' => 'add-topics',
                    ],
                    [
                        'name' => 'تعديل المواضيع',
                        'slug' => 'edit-topics',
                    ],
                    [
                        'name' => 'حذف المواضيع',
                        'slug' => 'delete-topics',
                    ],
                    [
                        'name' => 'عرض المواضيع',
                        'slug' => 'view-topics',
                    ],
                ]
            ],
            [
                'name' => 'ادارة المهام',
                'slug' => 'manage-tasks',
                'children' => [
                    [
                        'name' => 'اضافة مهمة',
                        'slug' => 'add-task',
                    ],
                    [
                        'name' => 'تعديل مهمة',
                        'slug' => 'edit-task',
                    ],
                    [
                        'name' => 'حذف مهمة',
                        'slug' => 'delete-task',
                    ],
                    [
                        'name' => 'عرض مهمة',
                        'slug' => 'view-task',
                    ],
                    [
                        'name' => 'تعديل حالة المهمة',
                        'slug' => 'edit-task-status',
                    ],
                    [
                        'name' => 'مهامى',
                        'slug' => 'my-tasks'
                    ]
                ]
            ],
            [
                'name' => 'ادارة الاخبار',
                'slug' => 'manage-news',
                'children' => [
                    [
                        'name' => 'اضافة خبر',
                        'slug' => 'add-news',
                    ],
                    [
                        'name' => 'تعديل خبر',
                        'slug' => 'edit-news',
                    ],
                    [
                        'name' => 'حذف خبر',
                        'slug' => 'delete-news',
                    ],
                    [
                        'name' => 'عرض خبر',
                        'slug' => 'view-news',
                    ],
                    [
                        'name' => 'استيراد الاخبار',
                        'slug' => 'import-news',
                    ],
                    [
                        'name' => 'RSS خدمة الاخبار',
                        'slug' => 'news-service',
                    ]
                ]
            ],
            [
                'name' => 'ادارة الابحاث',
                'slug' => 'manage-discovery',
                'children' => [
                    [
                        'name' => 'اضافة ابحاث',
                        'slug' => 'add-discovery',
                    ],
                    [
                        'name' => 'تعديل ابحاث',
                        'slug' => 'edit-discovery',
                    ],
                    [
                        'name' => 'حذف ابحاث',
                        'slug' => 'delete-discovery',
                    ],
                    [
                        'name' => 'عرض ابحاث',
                        'slug' => 'view-discovery',
                    ],
                    [
                        'name' => 'اضافة المصادر',
                        'slug' => 'add-sources',
                    ],
                    [
                        'name' => 'تعديل المصادر',
                        'slug' => 'edit-sources',
                    ],
                    [
                        'name' => 'حذف المصادر',
                        'slug' => 'delete-sources',
                    ],
                    [
                        'name' => 'عرض المصادر',
                        'slug' => 'view-sources',
                    ],
                ]
            ],
            [
                'name' => 'ادارة الضيوف',
                'slug' => 'manage-staff',
                'children' => [
                    [
                        'name' => 'اضافة ضيف',
                        'slug' => 'add-staff',
                    ],
                    [
                        'name' => 'تعديل ضيف',
                        'slug' => 'edit-staff',
                    ],
                    [
                        'name' => 'حذف ضيف',
                        'slug' => 'delete-staff',
                    ],
                    [
                        'name' => 'عرض ضيف',
                        'slug' => 'view-staff',
                    ],
                    [
                        'name' => 'تعديل حالة الضيف',
                        'slug' => 'edit-staff-status',
                    ],
                    [
                        'name' => 'تجهيز الضيف',
                        'slug' => 'staff-prep',
                    ],
                    [
                        'name' => 'اضافة الضيف لمساحة العمل',
                        'slug' => 'add-staff-to-workspace',
                    ],
                    [
                        'name' => 'حذف الضيف من مساحة العمل',
                        'slug' => 'remove-staff-from-workspace',
                    ],
                    [
                        'name' => 'البحث عن ضيف',
                        'slug' => 'search-staff'
                    ]
                ]
            ],
            [
                'name' => 'ادارة الRundown',
                'slug' => 'manage-rundown',
                'children' => [
                    [
                        'name' => 'اضافة Rundown',
                        'slug' => 'add-rundown',
                    ],
                    [
                        'name' => 'تعديل Rundown',
                        'slug' => 'edit-rundown',
                    ],
                    [
                        'name' => 'حذف Rundown',
                        'slug' => 'delete-rundown',
                    ],
                    [
                        'name' => 'عرض Rundown',
                        'slug' => 'view-rundown',
                    ],
                    [
                        'name' => 'تعديل حالة Rundown',
                        'slug' => 'edit-rundown-status',
                    ],
                    [
                        'name' => 'تجهيز Rundown',
                        'slug' => 'rundown-prep',
                    ],
                    [
                        'name' => 'اعداد سكربيت الحلقة',
                        'slug' => 'script-episode',
                    ],
                    [
                        'name' => 'انشاء سكربيت الحلقة',
                        'slug' => 'create-script-episode',
                    ],
                    [
                        'name' => 'عرض سكربيت الحلقة',
                        'slug' => 'view-script-episode'
                    ],
                    [
                        'name' => 'حذف سكربيت الحلقة',
                        'slug' => 'delete-script-episode'
                    ],
                    [
                        'name' => 'تعديل سكربيت الحلقة',
                        'slug' => 'edit-script-episode'
                    ]
                ]
            ],
            [
                'name' => 'ادارة النشاطات',
                'slug' => 'manage-activities',
                'children' => [
                    [
                        'name' => 'اضافة نشاطة',
                        'slug' => 'add-activity',
                    ],
                    [
                        'name' => 'تعديل نشاطة',
                        'slug' => 'edit-activity',
                    ],
                    [
                        'name' => 'حذف نشاطة',
                        'slug' => 'delete-activity',
                    ],
                    [
                        'name' => 'عرض نشاطة',
                        'slug' => 'view-activity',
                    ],
                    [
                        'name' => 'الاشعارات',
                        'slug' => 'notifications',
                    ],
                ]
            ],
        ];
        foreach ($workspace_permissions as $workspace_permission) {
            $create = WorkspacePermission::create([
                'name' => $workspace_permission['name'],
                'slug' => $workspace_permission['slug'],
            ]);
            if (isset($workspace_permission['children'])) {
                foreach ($workspace_permission['children'] as $child) {
                    $create->children()->create([
                        'name' => $child['name'],
                        'slug' => $child['slug'],
                    ]);
                }
            }
        }
    }
}
