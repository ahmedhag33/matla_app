<?php

namespace Database\Seeders;

use App\Models\ProgramTypes;
use Illuminate\Database\Seeder;

class ProgramTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programTypes = [
            [
                'name' => 'إخباري',
                'slug' => 'news',
                'icon' => 'newspaper-solid-full.svg',
                'description' => 'برامج تغطي الأخبار المحلية والعالمية والتقارير الإخبارية.',
            ],
            [
                'name' => 'حواري',
                'slug' => 'talk',
                'icon' => 'microphone-lines-solid-full.svg',
                'description' => 'برامج تعتمد على الحوار واستضافة الضيوف ومناقشة الموضوعات المختلفة.',
            ],
            [
                'name' => 'رياضي',
                'slug' => 'sports',
                'icon' => 'trophy-solid-full.svg',
                'description' => 'برامج تناقش الأحداث الرياضية والمباريات والتحليلات والبطولات.',
            ],
            [
                'name' => 'ثقافي',
                'slug' => 'cultural',
                'icon' => 'book-open-reader-solid-full.svg',
                'description' => 'برامج تهتم بالثقافة والأدب والفنون والمعرفة العامة.',
            ],
            [
                'name' => 'تعليمي',
                'slug' => 'educational',
                'icon' => 'graduation-cap-solid-full.svg',
                'description' => 'برامج تهدف إلى التعليم وتطوير المهارات ونشر المعرفة.',
            ],
            [
                'name' => 'ترفيهي',
                'slug' => 'entertainment',
                'icon' => 'film-solid-full.svg',
                'description' => 'برامج تقدم محتوى ترفيهيًا ومسابقات وفقرات ممتعة للجمهور.',
            ],
            [
                'name' => 'منوع',
                'slug' => 'variety',
                'icon' => 'table-columns-solid-full.svg',
                'description' => 'برامج تجمع بين أنواع متعددة من المحتوى والفقرات المختلفة.',
            ],
            [
                'name' => 'ديني',
                'slug' => 'religious',
                'icon' => 'moon-solid-full.svg',
                'description' => 'برامج تتناول الموضوعات الدينية والتوعية والقيم الروحية.',
            ],
            [
                'name' => 'صحي',
                'slug' => 'health',
                'icon' => 'heart-pulse-solid-full.svg',
                'description' => 'برامج تناقش الصحة والطب والتوعية والعادات الصحية.',
            ],
            [
                'name' => 'طبخ',
                'slug' => 'cooking',
                'icon' => 'kitchen-set-solid-full.svg',
                'description' => 'برامج تقدم وصفات الطعام وطرق الطهي والتغذية.',
            ],
            [
                'name' => 'اجتماعي',
                'slug' => 'social',
                'icon' => 'people-roof-solid-full.svg',
                'description' => 'برامج تناقش القضايا الاجتماعية والأسرية ومشكلات المجتمع.',
            ],
            [
                'name' => 'وثائقي',
                'slug' => 'documentary',
                'icon' => 'video-solid-full.svg',
                'description' => 'برامج تعرض محتوى وثائقيًا عن الأشخاص والأحداث والظواهر.',
            ],
            [
                'name' => 'أخرى',
                'slug' => 'other',
                'icon' => 'ellipsis-solid-full.svg',
                'description' => 'نوع عام للمحتوى الذي لا يندرج ضمن الأنواع المتاحة.',
            ],
        ];
        foreach ($programTypes as $programType) {
            ProgramTypes::create($programType);
        }
    }
}
