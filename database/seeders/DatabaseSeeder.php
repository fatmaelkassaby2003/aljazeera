<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // Run other seeders
        $this->call([
            AboutUsSeeder::class,
            CertificateSeeder::class,
            ClientSeeder::class,
            IslandSeeder::class,
            SectorSeeder::class,
            ServiceSeeder::class,
            WorkMethodSeeder::class,
            QuoteRequestSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
