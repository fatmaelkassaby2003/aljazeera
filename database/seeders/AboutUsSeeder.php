<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if record exists, if not create one
        if (!AboutUs::exists()) {
            AboutUs::create([
                'description' => 'نحن شركة رائدة في مجال إدارة وتشغيل القطاعات الحيوية، نسعى دائماً للتميز والابتكار في خدماتنا.',
                'vision' => [
                    ['point' => 'أن نكون الخيار الأول للعملاء في المملكة.'],
                    ['point' => 'تحقيق الريادة العالمية في إدارة المرافق.'],
                ],
                'mission' => [
                    ['point' => 'تقديم خدمات عالية الجودة.'],
                    ['point' => 'الالتزام بالمعايير العالمية.'],
                ],
                'values' => [
                    ['point' => 'الشفافية'],
                    ['point' => 'الجودة'],
                    ['point' => 'الابتكار'],
                ],
            ]);
        }
    }
}
