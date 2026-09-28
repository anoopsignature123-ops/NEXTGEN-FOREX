<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\Incomes\DirectSalaryService;
use App\Services\Incomes\RewardIncomeService;
use App\Services\Incomes\TeamSalaryService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IncomeRules5050Test extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_direct_salary_requires_at_least_5_active_directs(): void
    {
        $sponsor = User::factory()->create(['status' => 'active', 'referral_code' => 'NGF-5DIRECTTEST']);
        $service = new DirectSalaryService;
        $pkgId = Package::first()->id ?? 1;

        // Case 1: Create 4 active directs with $10,000 direct business volume
        for ($i = 1; $i <= 4; $i++) {
            $direct = User::factory()->create(['status' => 'active', 'sponsor_code' => 'NGF-5DIRECTTEST']);
            UserPackage::create([
                'user_id' => $direct->id,
                'package_id' => $pkgId,
                'invested_amount' => 2500.00,
                'daily_roi' => 1.0,
                'total_return_amount' => 5000.00,
                'status' => 'active',
            ]);
        }

        // 4 active directs total $10,000 business -> should be 0 because active directs < 5
        $payout1 = $service->processUserDirectSalary($sponsor);
        $this->assertEquals(0.00, $payout1);

        // Case 2: Add 5th active direct referral
        $direct5 = User::factory()->create(['status' => 'active', 'sponsor_code' => 'NGF-5DIRECTTEST']);
        UserPackage::create([
            'user_id' => $direct5->id,
            'package_id' => $pkgId,
            'invested_amount' => 500.00,
            'daily_roi' => 1.0,
            'total_return_amount' => 1000.00,
            'status' => 'active',
        ]);

        // 5 active directs total $10,500 business -> should hit $10,000 tier ($10.00/day)
        $payout2 = $service->processUserDirectSalary($sponsor);
        $this->assertEquals(10.00, $payout2);
    }

    public function test_team_salary_evaluates_on_50_50_matching_volume(): void
    {
        $user = User::factory()->create(['status' => 'active']);
        $service = new TeamSalaryService;

        // If matched 50:50 volume is below 5000, payout is 0
        $payout1 = $service->processUserTeamSalary($user, 4900.00);
        $this->assertEquals(0.00, $payout1);

        // If matched 50:50 volume is 5000+, payouts $75/cycle
        $payout2 = $service->processUserTeamSalary($user, 5000.00);
        $this->assertEquals(75.00, $payout2);
    }

    public function test_reward_income_evaluates_on_50_50_matching_volume(): void
    {
        $user = User::factory()->create(['status' => 'active']);
        $service = new RewardIncomeService;

        // Matched 50:50 volume $5,000 triggers $1,000 milestone ($100) + $5,000 milestone ($500) = $600 total
        $payout = $service->evaluateRewardMilestones($user, 5000.00);
        $this->assertEquals(600.00, $payout);
    }
}
