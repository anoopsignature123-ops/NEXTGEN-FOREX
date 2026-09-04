<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PackagePurchaseTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test user can view the packages page cleanly.
     */
    public function test_user_can_view_packages_page(): void
    {
        $user = User::factory()->create([
            'deposit_wallet' => 500.00,
        ]);

        $response = $this->actingAs($user)->get(route('user.packages.index'));

        $response->assertStatus(200);
        $response->assertSee('BUY INVESTMENT PACKAGE');
        $response->assertSee('ENTER INVESTMENT AMOUNT', false);
    }

    /**
     * Test buying a package auto-detects tier, deducts deposit wallet, and activates account.
     */
    public function test_user_can_invest_amount_and_auto_match_package_tier(): void
    {
        $user = User::factory()->create([
            'status' => 'inactive',
            'deposit_wallet' => 200.00,
        ]);

        $response = $this->actingAs($user)->post(route('user.packages.buy'), [
            'invested_amount' => 50.00,
        ]);

        $response->assertRedirect(route('user.packages.history'));
        $response->assertSessionHas('success');

        // Check user wallet deducted and activated
        $this->assertEquals(150.00, $user->fresh()->deposit_wallet);
        $this->assertEquals('active', $user->fresh()->status);

        // Check UserPackage created for matched tier (Package 1: $10 - $100)
        $pkg1 = Package::where('min_amount', '<=', 50)->where('max_amount', '>=', 50)->first();
        $this->assertDatabaseHas('user_packages', [
            'user_id' => $user->id,
            'package_id' => $pkg1->id,
            'invested_amount' => 50.00,
            'status' => 'active',
            'total_return_amount' => 100.00, // 2X Return
        ]);
    }

    /**
     * Test user can make multiple consecutive investments without card lockout.
     */
    public function test_user_can_make_multiple_investments(): void
    {
        $user = User::factory()->create([
            'deposit_wallet' => 1000.00,
        ]);

        // First investment of $50
        $this->actingAs($user)->post(route('user.packages.buy'), [
            'invested_amount' => 50.00,
        ]);

        // Second investment of $200 (Package 2: $101 - $500)
        $this->actingAs($user)->post(route('user.packages.buy'), [
            'invested_amount' => 200.00,
        ]);

        $this->assertEquals(750.00, $user->fresh()->deposit_wallet);

        // Verify 2 active user_packages records exist
        $activePackagesCount = UserPackage::where('user_id', $user->id)->where('status', 'active')->count();
        $this->assertEquals(2, $activePackagesCount);
    }

    /**
     * Test insufficient deposit wallet prevents investment.
     */
    public function test_insufficient_wallet_fails_investment(): void
    {
        $user = User::factory()->create([
            'deposit_wallet' => 10.00,
        ]);

        $response = $this->actingAs($user)->post(route('user.packages.buy'), [
            'invested_amount' => 500.00,
        ]);

        $response->assertRedirect(route('user.deposits.index'));
        $response->assertSessionHas('error');
        $this->assertEquals(10.00, $user->fresh()->deposit_wallet);
    }
}
