<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoosterBonusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_sponsor_earns_50_booster_bonus_upon_5_direct_100_dollar_referrals(): void
    {
        $sponsor = User::factory()->create([
            'role_id' => 2,
            'referral_code' => 'NGF-SPONSOR1',
            'status' => 'active',
            'activated_at' => now(),
            'earning_wallet' => 0.00,
        ]);

        $package = Package::where('min_amount', '<=', 100)->where('max_amount', '>=', 100)->first();

        // Create 5 direct referrals
        for ($i = 1; $i <= 5; $i++) {
            $referral = User::factory()->create([
                'role_id' => 2,
                'sponsor_code' => $sponsor->referral_code,
                'status' => 'active',
                'activated_at' => now(),
                'deposit_wallet' => 100.00,
            ]);

            $this->actingAs($referral)->post(route('user.packages.buy'), [
                'package_id' => $package->id,
                'invested_amount' => 100.00,
            ]);
        }

        $sponsor->refresh();

        // Check 10% Direct Commissions (5 x $10 = $50) + 20% Level 1 Commissions (5 x $20 = $100) + 24H Booster Bonus ($50) = $200 Earning Wallet
        $this->assertEquals(200.00, (float) $sponsor->earning_wallet);

        // Assert 24h_bonus transaction exists
        $this->assertDatabaseHas('transactions', [
            'user_id' => $sponsor->id,
            'type' => '24h_bonus',
            'amount' => 50.00,
            'wallet_type' => 'earning_wallet',
        ]);
    }
}
