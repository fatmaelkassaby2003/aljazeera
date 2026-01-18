<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        ContactMessage::create([
            'full_name' => 'سارة أحمد القحطاني',
            'phone' => '0502223344',
            'email' => 'sarah@example.com',
            'message' => 'السلام عليكم، أرغب في الاستفسار عن خدماتكم في مجال القوائم المالية. هل يمكنكم التواصل معي للحصول على المزيد من التفاصيل؟',
            'status' => 'new',
        ]);

        ContactMessage::create([
            'full_name' => 'محمد سعد الدوسري',
            'phone' => '0555556666',
            'email' => 'mohammed.s@example.com',
            'message' => 'مرحباً، أنا مهتم بخدمات تكامل الأنظمة. أود معرفة الأسعار والمدة الزمنية المتوقعة لتنفيذ المشروع.',
            'status' => 'read',
        ]);

        ContactMessage::create([
            'full_name' => 'نورة عبدالرحمن العتيبي',
            'phone' => '0507778899',
            'email' => 'norah@example.com',
            'message' => 'تحية طيبة، نحن شركة متوسطة الحجم ونبحث عن شريك موثوق لإدارة المرافق. هل لديكم خبرة في هذا المجال؟',
            'status' => 'replied',
            'admin_notes' => 'تم الرد على العميل بالبريد الإلكتروني بتاريخ 17/01/2026 وإرسال العرض التعريفي.',
        ]);

        ContactMessage::create([
            'full_name' => 'عبدالله حسن الشمري',
            'phone' => '0561112233',
            'email' => 'abdullah@example.com',
            'message' => 'أود الحصول على استشارة مجانية بخصوص تطوير نظام محاسبي متكامل لشركتنا.',
            'status' => 'new',
        ]);

        ContactMessage::create([
            'full_name' => 'ريم خالد الغامدي',
            'phone' => '0544445555',
            'email' => 'reem.k@example.com',
            'message' => 'شكراً لكم على الخدمات الممتازة. أود الاستفسار عن إمكانية توسيع العقد الحالي ليشمل خدمات إضافية.',
            'status' => 'archived',
            'admin_notes' => 'عميل حالي، تم الانتهاء من التعامل مع الطلب وإحالته للقسم المختص.',
        ]);
    }
}
