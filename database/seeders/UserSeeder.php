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
        // 1. Default Super Admin User (Role 1 - System Admin, Not a Member)
        User::updateOrCreate(
            ['email' => 'admin@nextgenforex.com'],
            [
                'role_id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@nextgenforex.com',
                'mobile' => '1234567890',
                'referral_code' => 'NGF-ADMIN01',
                'sponsor_code' => null,
                'status' => 'active',
                'password' => Hash::make('Admin@123'),
            ]
        );

        // 2. Default Root Member User (Role 2 - Top MLM Member with No Sponsor)
        User::updateOrCreate(
            ['email' => 'root@nextgenforex.com'],
            [
                'role_id' => 2,
                'name' => 'Root User',
                'email' => 'root@nextgenforex.com',
                'mobile' => '9876543210',
                'referral_code' => 'NGF-0000001',
                'sponsor_code' => null, // Top Root member has no sponsor
                'status' => 'active',
                'deposit_wallet' => 0.00,
                'earning_wallet' => 0.00,
                'password' => Hash::make('Root@123'),
            ]
        );
    }
}
