<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    public function run(): void
    {
        // Delete existing records
        ContactInfo::query()->delete();
        
        ContactInfo::create([
            'phone' => '+966 50 123 4567',
            'email' => 'info@aljazeera.com',
            'description' => 'نحن هنا لمساعدتك. لا تتردد في التواصل معنا في أي وقت للحصول على المزيد من المعلومات حول خدماتنا.',
        ]);
    }
}
