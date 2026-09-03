<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Default Super Admin User (Role 1)
        User::updateOrCreate(
            ['email' => 'admin@nextgenforex.com'],
            [
                'role_id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@nextgenforex.com',
                'mobile' => '1234567890',
                'referral_code' => 'NGF-0000001',
                'sponsor_code' => null,

                'status' => 'active',
                'password' => Hash::make('Admin@123'),
            ]
        );

        // 2. Default Member User (Role 2) - John Trader
        User::updateOrCreate(
            ['email' => 'user@nextgenforex.com'],
            [
                'role_id' => 2,
                'name' => 'Root User',
                'email' => 'root@nextgenforex.com',
                'mobile' => '9876543210',
                'referral_code' => 'NGF-0967542',
                'sponsor_code' => null,

                'deposit_wallet' => 00.00,
                'earning_wallet' => 00.00,

                'password' => Hash::make('Root@123'),
            ]
        );
    }
}
