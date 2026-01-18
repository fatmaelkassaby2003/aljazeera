<?php

namespace Database\Seeders;

use App\Models\WorkMethod;
use Illuminate\Database\Seeder;

class WorkMethodSeeder extends Seeder
{
    public function run(): void
    {
        $workMethods = [
            [
                'title' => 'التخطيط الاستراتيجي',
                'description' => 'نبدأ بفهم أهداف عملائنا ورؤيتهم المستقبلية، ثم نضع خطة استراتيجية متكاملة تحدد الأهداف والمراحل والموارد المطلوبة لتحقيق النجاح.',
            ],
            [
                'title' => 'التحليل والدراسة',
                'description' => 'نقوم بتحليل شامل للسوق والمنافسين والفرص المتاحة، مع دراسة معمقة لاحتياجات العملاء لضمان تقديم حلول فعالة ومبتكرة.',
            ],
            [
                'title' => 'التنفيذ والمتابعة',
                'description' => 'ننفذ المشاريع بدقة عالية مع متابعة مستمرة لضمان الجودة، ونوفر تقارير دورية توضح مراحل التقدم والإنجازات المحققة.',
            ],
            [
                'title' => 'التطوير المستمر',
                'description' => 'نؤمن بأهمية التطوير المستمر، لذا نراجع أداءنا باستمرار ونطبق أفضل الممارسات لتحسين خدماتنا وتجاوز توقعات عملائنا.',
            ],
        ];

        foreach ($workMethods as $method) {
            WorkMethod::create($method);
        }
    }
}
