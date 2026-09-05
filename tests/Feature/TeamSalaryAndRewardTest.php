<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\Incomes\RewardIncomeService;
use App\Services\Incomes\TeamSalaryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamSalaryAndRewardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_team_salary_and_reward_income_processing(): void
    {
        $pkg = Package::first();

        $sponsor = User::factory()->create([
            'status' => 'active',
            'earning_wallet' => 0.00,
        ]);

        // Leg 1 (Power Leg): $5,000 package
        $direct1 = User::factory()->create([
            'sponsor_code' => $sponsor->referral_code,
            'status' => 'active',
        ]);
        UserPackage::create([
            'user_id' => $direct1->id,
            'package_id' => $pkg->id,
            'invested_amount' => 5000.00,
            'daily_roi_percentage' => 1.0,
            'status' => 'active',
            'activated_at' => now(),
        ]);

        // Leg 2 (Weaker Leg): $5,000 package
        $direct2 = User::factory()->create([
            'sponsor_code' => $sponsor->referral_code,
            'status' => 'active',
        ]);
        UserPackage::create([
            'user_id' => $direct2->id,
            'package_id' => $pkg->id,
            'invested_amount' => 5000.00,
            'daily_roi_percentage' => 1.0,
            'status' => 'active',
            'activated_at' => now(),
        ]);

        // Power Leg = $5,000, Weaker Leg = $5,000, Total Team Business = $10,000
        $legStats = $sponsor->leg_volume_stats;
        $this->assertEquals(5000.00, $legStats['power_leg']);
        $this->assertEquals(5000.00, $legStats['remaining_leg']);
        $this->assertEquals(10000.00, $legStats['total_team']);

        // Process Team Salary ($5,000 matching business -> $75 cycle payout)
        $teamSalaryService = app(TeamSalaryService::class);
        $salaryPaid = $teamSalaryService->processUserTeamSalary($sponsor, $legStats['remaining_leg']);
        $this->assertEquals(75.00, $salaryPaid);

        // Process Reward Income ($10,000 total business -> milestone rewards $100, $500, $1000)
        $rewardService = app(RewardIncomeService::class);
        $rewardPaid = $rewardService->evaluateRewardMilestones($sponsor, $legStats['total_team']);
        $this->assertEquals(1600.00, $rewardPaid); // $100 + $500 + $1000

        $sponsor->refresh();
        $this->assertEquals(1675.00, (float) $sponsor->earning_wallet);

        // Verify transaction logs created
        $this->assertDatabaseHas('transactions', [
            'user_id' => $sponsor->id,
            'type' => 'team_salary',
            'amount' => 75.00,
        ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $sponsor->id,
            'type' => 'reward_income',
            'amount' => 1000.00,
        ]);
    }
}
