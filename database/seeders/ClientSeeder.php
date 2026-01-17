<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['name' => 'أرامكو السعودية', 'logo' => 'clients/aramco.png'],
            ['name' => 'شركة الكهرباء السعودية', 'logo' => 'clients/sec.png'],
            ['name' => 'سابك', 'logo' => 'clients/sabic.png'],
            ['name' => 'البنك الأهلي', 'logo' => 'clients/alahli.png'],
            ['name' => 'مطارات الرياض', 'logo' => 'clients/riyadh-airports.png'],
            ['name' => 'وزارة التعليم', 'logo' => 'clients/moe.png'],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
