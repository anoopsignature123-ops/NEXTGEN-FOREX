<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArbitrageTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_is_redirected_from_arbitrage(): void
    {
        $response = $this->get('/user/arbitrage');
        $response->assertRedirect('/user/login');
    }

    public function test_authenticated_user_can_access_arbitrage_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/user/arbitrage');

        $response->assertStatus(200);
        $response->assertSee('Arbitrage Dashboard');
        $response->assertSee('Live Arbitrage Transactions');
    }

    public function test_authenticated_user_can_access_arbitration_alias_route(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/user/arbitration');

        $response->assertStatus(200);
        $response->assertSee('Arbitrage Dashboard');
    }
}
