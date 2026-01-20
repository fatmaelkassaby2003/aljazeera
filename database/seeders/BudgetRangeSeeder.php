<?php

namespace Database\Seeders;

use App\Models\BudgetRange;
use Illuminate\Database\Seeder;

class BudgetRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranges = [
            [
                'label' => 'أقل من 50,000 ر.س',
                'min_amount' => null,
                'max_amount' => 50000,
                'is_active' => true,
            ],
            [
                'label' => '50,000 - 100,000 ر.س',
                'min_amount' => 50000,
                'max_amount' => 100000,
                'is_active' => true,
            ],
            [
                'label' => '100,000 - 200,000 ر.س',
                'min_amount' => 100000,
                'max_amount' => 200000,
                'is_active' => true,
            ],
            [
                'label' => '200,000 - 500,000 ر.س',
                'min_amount' => 200000,
                'max_amount' => 500000,
                'is_active' => true,
            ],
            [
                'label' => 'أكثر من 500,000 ر.س',
                'min_amount' => 500000,
                'max_amount' => null,
                'is_active' => true,
            ],
        ];

        foreach ($ranges as $range) {
            BudgetRange::create($range);
        }
    }
}
