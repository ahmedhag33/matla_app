<?php

namespace Database\Seeders;

use App\Models\WorkspaceType;
use Illuminate\Database\Seeder;

class WorkspaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'name' => 'برنامج تلفزيوني',
                'slug' => 'tv_program',
                'description' => 'إدارة الحلقات، الرانداون، السكريبت، الضيوف وأسئلة الحلقات',
                'photo' => 'tv-solid-full-2.svg',
            ],
            [
                'name' => 'برنامج إذاعي',
                'slug' => 'radio_program',
                'description' => 'إدارة الفقرات، النصوص، الضيوف ومواعيد البث',
                'photo' => 'radio-solid-full.svg',
            ],
            [
                'name' => 'مؤسسة إخبارية',
                'slug' => 'news_agency',
                'description' => 'تنظيم التغطيات الإخبارية، التكليفات، المصادر والفرق التحريرية',
                'photo' => 'newspaper-regular-full.svg',
            ],
            [
                'name' => 'بودكاست',
                'slug' => 'podcast',
                'description' => 'إدارة الحلقات، السكريبت، الضيوف والتسجيلات.',
                'photo' => 'tower-broadcast-solid-full.svg',
            ],
            [
                'name' => 'صناعة المحتوى الرقمي',
                'slug' => 'digital_content',
                'description' => 'إدارة الفيديوهات، الأفكار، خطط النشر والمهام الإنتاجية.',
                'photo' => 'film-solid-full.svg',
            ],
            [
                'name' => 'شركة إنتاج إعلامي',
                'slug' => 'media_production',
                'description' => 'إدارة المشروعات الإنتاجية، فرق العمل، التصوير والسكريبتات.',
                'photo' => 'video-solid-full.svg',
            ],
            [
                'name' => 'تحليل رياضي',
                'slug' => 'sports_analysis',
                'description' => 'إعداد التحليلات، الإحصائيات، الفقرات الرياضية والمواد الخاصة بالمباريات.',
                'photo' => 'futbol-solid-full.svg',
            ],
            [
                'name' => 'فريق إعداد إعلامي',
                'slug' => 'media_editorial_team',
                'description' => 'تنظيم الأبحاث، الموضوعات، السكريبتات والتنسيق بين أعضاء فريق الإعداد.',
                'photo' => 'people-group-solid-full.svg',
            ],
            [
                'name' => 'نشاط إعلامي آخر',
                'slug' => 'other',
                'description' => 'لأي نشاط قريب من مجال المنصة ولا يندرج تحت الأنواع السابقة.',
                'photo' => 'layer-group-solid-full.svg',
            ]
        ];
        foreach ($data as $item) {
           WorkspaceType::create($item);
        }
    }
}
