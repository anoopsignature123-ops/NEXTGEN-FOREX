<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds matching official NextGen Forex PDF Presentation (Slides 11 & 13).
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'PACKAGE 1',
                'min_amount' => 10.00,
                'max_amount' => 100.00,
                'daily_roi' => 0.50, // 0.5% Daily
                'duration_days' => 200,
                'total_return_multiplier' => 2.00, // 2X Return
                'status' => 'active',
                'description' => 'Starter Forex Package: $10 - $100 | 0.5% Daily Income | 200 Days Duration | 2X Total Return',
            ],
            [
                'name' => 'PACKAGE 2',
                'min_amount' => 100.00,
                'max_amount' => 500.00,
                'daily_roi' => 0.75, // 0.75% Daily
                'duration_days' => 200,
                'total_return_multiplier' => 2.00, // 2X Return
                'status' => 'active',
                'description' => 'Standard Forex Package: $100 - $500 | 0.75% Daily Income | 200 Days Duration | 2X Total Return',
            ],
            [
                'name' => 'PACKAGE 3',
                'min_amount' => 500.00,
                'max_amount' => 1000.00,
                'daily_roi' => 1.00, // 1.00% Daily
                'duration_days' => 200,
                'total_return_multiplier' => 2.00, // 2X Return
                'status' => 'active',
                'description' => 'Premium Forex Package: $500 - $1,000 | 1.00% Daily Income | 200 Days Duration | 2X Total Return',
            ],
            [
                'name' => 'PACKAGE 4',
                'min_amount' => 1000.00,
                'max_amount' => 5000.00,
                'daily_roi' => 1.25, // 1.25% Daily
                'duration_days' => 200,
                'total_return_multiplier' => 2.00, // 2X Return
                'status' => 'active',
                'description' => 'Executive Forex Package: $1,000 - $5,000 | 1.25% Daily Income | 200 Days Duration | 2X Total Return',
            ],
            [
                'name' => 'PACKAGE 5',
                'min_amount' => 5000.00,
                'max_amount' => 100000.00,
                'daily_roi' => 1.50, // 1.50% Daily
                'duration_days' => 200,
                'total_return_multiplier' => 2.00, // 2X Return
                'status' => 'active',
                'description' => 'VIP Elite Forex Package: $5,000 & Above | 1.50% Daily Income | 200 Days Duration | 2X Total Return',
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['name' => $pkg['name']],
                $pkg
            );
        }
    }
}
