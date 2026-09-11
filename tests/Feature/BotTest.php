<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\Incomes\RoiIncomeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BotTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_is_redirected_from_bot_pages(): void
    {
        $responseIndex = $this->get('/user/bot');
        $responseIndex->assertRedirect('/user/login');

        $responseTrading = $this->get('/user/bot/trading');
        $responseTrading->assertRedirect('/user/login');

        $responseActivate = $this->post('/user/bot/activate');
        $responseActivate->assertRedirect('/user/login');
    }

    public function test_authenticated_user_can_access_bot_overview_page(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
            'is_bot_active' => false,
        ]);

        $response = $this->actingAs($user)->get('/user/bot');

        $response->assertStatus(200);
        $response->assertSee('QUANT TRADING BOT SYSTEM');
        $response->assertSee('STATUS: READY FOR ACTIVATION');
    }

    public function test_authenticated_user_can_access_bot_trading_view_page(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
            'is_bot_active' => false,
        ]);

        $response = $this->actingAs($user)->get('/user/bot/trading');

        $response->assertStatus(200);
        $response->assertSee('QUANT TRADING TERMINAL');
        $response->assertSee('Crypto Pair Selector');
        $response->assertSee('START BOT');
    }

    public function test_inactive_user_cannot_activate_bot(): void
    {
        $user = User::factory()->create([
            'status' => 'inactive',
            'is_bot_active' => false,
        ]);

        $response = $this->actingAs($user)->post('/user/bot/activate');

        $response->assertRedirect('/user/bot/trading');
        $response->assertSessionHas('error');
        $this->assertFalse((bool) $user->fresh()->is_bot_active);
    }

    public function test_authenticated_user_can_activate_bot(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
            'is_bot_active' => false,
            'bot_activated_at' => null,
        ]);

        $response = $this->actingAs($user)->post('/user/bot/activate');

        $response->assertRedirect('/user/bot/trading');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue((bool) $user->is_bot_active);
        $this->assertNotNull($user->bot_activated_at);
    }

    public function test_already_active_bot_cannot_be_re_activated(): void
    {
        $activatedTime = now()->subDays(2);
        $user = User::factory()->create([
            'status' => 'active',
            'is_bot_active' => true,
            'bot_activated_at' => $activatedTime,
        ]);

        $response = $this->actingAs($user)->post('/user/bot/activate');

        $response->assertRedirect('/user/bot/trading');
        $response->assertSessionHas('info');

        $user->refresh();
        $this->assertTrue((bool) $user->is_bot_active);
    }

    public function test_roi_income_is_only_paid_when_bot_is_activated(): void
    {
        $package = Package::first();

        // User A: Active package BUT Bot is INACTIVE
        $userInactiveBot = User::factory()->create([
            'is_bot_active' => false,
            'earning_wallet' => 0.00,
        ]);

        $pkgInactive = UserPackage::create([
            'user_id' => $userInactiveBot->id,
            'package_id' => $package->id,
            'invested_amount' => 100.00,
            'daily_roi' => 1.00,
            'daily_roi_amount' => 1.00,
            'total_return_amount' => 200.00,
            'paid_roi_amount' => 0.00,
            'status' => 'active',
            'purchased_at' => now(),
        ]);

        // User B: Active package AND Bot is ACTIVE
        $userActiveBot = User::factory()->create([
            'is_bot_active' => true,
            'bot_activated_at' => now(),
            'earning_wallet' => 0.00,
        ]);

        $pkgActive = UserPackage::create([
            'user_id' => $userActiveBot->id,
            'package_id' => $package->id,
            'invested_amount' => 100.00,
            'daily_roi' => 1.00,
            'daily_roi_amount' => 1.00,
            'total_return_amount' => 200.00,
            'paid_roi_amount' => 0.00,
            'status' => 'active',
            'purchased_at' => now(),
        ]);

        $service = app(RoiIncomeService::class);

        // Process Single for inactive bot -> 0
        $creditedInactive = $service->processSinglePackageRoi($pkgInactive);
        $this->assertEquals(0.00, $creditedInactive);
        $this->assertEquals(0.00, (float) $userInactiveBot->fresh()->earning_wallet);

        // Process Single for active bot -> 1.00
        $creditedActive = $service->processSinglePackageRoi($pkgActive);
        $this->assertEquals(1.00, $creditedActive);
        $this->assertEquals(1.00, (float) $userActiveBot->fresh()->earning_wallet);
    }
}
