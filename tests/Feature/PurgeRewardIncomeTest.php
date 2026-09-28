<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurgeRewardIncomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_purge_reward_income_command(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
            'earning_wallet' => 600.00,
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'txn_number' => 'TXN-10000001',
            'wallet_type' => 'earning_wallet',
            'amount' => 100.00,
            'charge' => 0.00,
            'post_balance' => 100.00,
            'trx_type' => '+',
            'type' => 'reward_income',
            'description' => 'Received 10% Reward Income of $100.00 ($1K Team Business Milestone)',
            'status' => 'completed',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'txn_number' => 'TXN-10000002',
            'wallet_type' => 'earning_wallet',
            'amount' => 500.00,
            'charge' => 0.00,
            'post_balance' => 600.00,
            'trx_type' => '+',
            'type' => 'reward_income',
            'description' => 'Received 10% Reward Income of $500.00 ($5K Team Business Milestone)',
            'status' => 'completed',
        ]);

        $this->artisan('income:remove-rewards', ['--dry-run' => true])
            ->assertExitCode(0);

        $this->assertEquals(600.00, (float) $user->fresh()->earning_wallet);
        $this->assertDatabaseCount('transactions', 2);

        $this->artisan('income:remove-rewards')
            ->assertExitCode(0);

        $this->assertEquals(0.00, (float) $user->fresh()->earning_wallet);
        $this->assertDatabaseMissing('transactions', [
            'type' => 'reward_income',
        ]);
    }
}
