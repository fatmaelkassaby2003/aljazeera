<?php

namespace Database\Seeders;

use App\Models\QuoteRequest;
use Illuminate\Database\Seeder;

class QuoteRequestSeeder extends Seeder
{
    public function run(): void
    {
        QuoteRequest::create([
            'full_name' => 'أحمد محمد السعيد',
            'company_name' => 'شركة النور للتجارة',
            'phone' => '0501234567',
            'email' => 'ahmed@alnoor.com',
            'service_type' => 'financial',
            'budget_range' => '50,000 - 100,000 ر.س',
            'project_description' => 'نحتاج لإعداد القوائم المالية السنوية للشركة وفقاً للمعايير المحاسبية السعودية. الشركة تعمل في القطاع التجاري ولديها فروع متعددة.',
            'status' => 'pending',
        ]);

        QuoteRequest::create([
            'full_name' => 'فاطمة علي الحربي',
            'company_name' => 'مؤسسة الأمل للتطوير',
            'phone' => '0559876543',
            'email' => 'fatima@alamal.com',
            'service_type' => 'integration',
            'budget_range' => '100,000 - 200,000 ر.س',
            'project_description' => 'نرغب في ربط نظام إدارة المخزون مع نظام المحاسبة والمبيعات. لدينا 3 أنظمة منفصلة نحتاج لتكاملها.',
            'status' => 'reviewed',
            'admin_notes' => 'تم التواصل مع العميل وتحديد موعد للاجتماع الأسبوع القادم.',
        ]);

        QuoteRequest::create([
            'full_name' => 'خالد عبدالله المطيري',
            'company_name' => 'مجمع الفيصلية التجاري',
            'phone' => '0567891234',
            'email' => 'khaled@faisaliah.com',
            'service_type' => 'facility',
            'budget_range' => '200,000 - 300,000 ر.س',
            'project_description' => 'نحتاج خدمات إدارة ومرافق شاملة لمجمع تجاري مساحته 10,000 متر مربع، يشمل الصيانة والنظافة والأمن.',
            'status' => 'quoted',
            'admin_notes' => 'تم إرسال عرض السعر التفصيلي بتاريخ 15/01/2026',
        ]);
    }
}
