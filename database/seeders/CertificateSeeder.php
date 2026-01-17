<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Certificate::create([
            'name' => 'شهادة الأيزو 9001',
            'image' => 'certificates/iso-9001.png',
            'issue_date' => '2023-01-15',
            'issuing_authority' => 'منظمة المعايير الدولية',
        ]);

        Certificate::create([
            'name' => 'شهادة التميز في الجودة',
            'image' => 'certificates/quality-excellence.png',
            'issue_date' => '2024-05-20',
            'issuing_authority' => 'الهيئة السعودية للمواصفات',
        ]);

        Certificate::create([
            'name' => 'اعتماد إدارة المشاريع PMP',
            'image' => 'certificates/pmp.png',
            'issue_date' => '2022-11-10',
            'issuing_authority' => 'معهد إدارة المشاريع PMI',
        ]);
    }
}
