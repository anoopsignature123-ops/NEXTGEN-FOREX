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
        // Default Super Admin User (Role 1)
        User::updateOrCreate(
            ['email' => 'admin@nextgenforex.com'],
            [
                'role_id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@nextgenforex.com',
                'mobile' => '1234567890',
                'referral_code' => 'NGF-0000001',
                'sponsor_code' => null,
                'position' => 'left',
                'status' => 'active',
                'password' => Hash::make('password123'),
            ]
        );

        // Default Member User (Role 2) - Inactive by default until package investment
        User::updateOrCreate(
            ['email' => 'user@nextgenforex.com'],
            [
                'role_id' => 2,
                'name' => 'John Trader',
                'email' => 'user@nextgenforex.com',
                'mobile' => '9876543210',
                'referral_code' => 'NGF-0967542',
                'sponsor_code' => 'NGF-0000001',
                'position' => 'left',
                'status' => 'inactive',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
