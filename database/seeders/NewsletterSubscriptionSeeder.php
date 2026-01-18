<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Seeder;

class NewsletterSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        NewsletterSubscription::create([
            'email' => 'ahmed.ali@example.com',
            'status' => 'active',
        ]);

        NewsletterSubscription::create([
            'email' => 'fatima.hassan@example.com',
            'status' => 'active',
        ]);

        NewsletterSubscription::create([
            'email' => 'mohammed.saeed@example.com',
            'status' => 'active',
        ]);

        NewsletterSubscription::create([
            'email' => 'norah.abdullah@example.com',
            'status' => 'unsubscribed',
            'unsubscribed_at' => now()->subDays(5),
        ]);

        NewsletterSubscription::create([
            'email' => 'khalid.omar@example.com',
            'status' => 'active',
        ]);
    }
}
