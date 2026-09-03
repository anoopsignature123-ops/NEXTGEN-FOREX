<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPackage;
use App\Services\Incomes\BoosterBonusService;
use App\Services\Incomes\DirectIncomeService;
use App\Services\Incomes\DirectSalaryService;
use App\Services\Incomes\MatchingIncomeService;
use App\Services\Incomes\RewardIncomeService;
use App\Services\Incomes\RoiIncomeService;
use App\Services\Incomes\TeamSalaryService;

/**
 * Class IncomeEngineService
 *
 * MASTER FINANCIAL INCOME ENGINE (NextGen Forex Business Plan Architecture)
 * -------------------------------------------------------------------------
 * Description:
 * Central orchestrator service that encapsulates all 7 business income logic
 * services, ensuring strict separation of concerns, maintainability, and clean
 * financial execution.
 *
 * Encapsulated Income Services:
 * 1. RoiIncomeService       - 0.5% - 1.5% Daily ROI Yield (200 Days / 2X Cap)
 * 2. DirectIncomeService    - 10% Flat Direct Referral Commission
 * 3. BoosterBonusService    - 24 Hours Special Booster Bonus ($50 / $250 / $500)
 * 4. MatchingIncomeService  - 5% Team Matching Commission (50:50 Power/Weaker Ratio)
 * 5. DirectSalaryService    - 365 Days Direct Business Salary ($1/day to $1,000/day)
 * 6. TeamSalaryService      - 15-Day Cycle Team Salary ($75/cycle for 12 Months)
 * 7. RewardIncomeService    - 10% Team Business Milestone Rewards ($100 to $5 Lacs)
 */
class IncomeEngineService
{
    public function __construct(
        public RoiIncomeService $roiService,
        public DirectIncomeService $directService,
        public BoosterBonusService $boosterService,
        public MatchingIncomeService $matchingService,
        public DirectSalaryService $directSalaryService,
        public TeamSalaryService $teamSalaryService,
        public RewardIncomeService $rewardService
    ) {}

    /**
     * Trigger 10% Direct Commission upon package purchase.
     */
    public function triggerDirectCommission(User $purchaser, UserPackage $userPackage, float $investedAmount): float
    {
        return $this->directService->distributeDirectCommission($purchaser, $userPackage, $investedAmount);
    }

    /**
     * Run system-wide daily ROI yield distribution.
     */
    public function runDailyRoiDistribution(): array
    {
        return $this->roiService->processAllDailyRoi();
    }

    /**
     * Evaluate 24-hour booster bonus for a sponsor.
     */
    public function checkBoosterBonus(User $user): float
    {
        return $this->boosterService->evaluateBoosterBonus($user);
    }

    /**
     * Process 5% matching income for a member.
     */
    public function calculateMatching(User $user, float $powerLeg, float $weakerLeg): float
    {
        return $this->matchingService->processUserMatching($user, $powerLeg, $weakerLeg);
    }

    /**
     * Process daily direct salary income.
     */
    public function processDirectSalary(User $user): float
    {
        return $this->directSalaryService->processUserDirectSalary($user);
    }

    /**
     * Process 15-day team salary cycle payout.
     */
    public function processTeamSalary(User $user, float $matchingBusiness): float
    {
        return $this->teamSalaryService->processUserTeamSalary($user, $matchingBusiness);
    }

    /**
     * Evaluate team business reward milestones.
     */
    public function checkRewardMilestones(User $user, float $teamBusiness): float
    {
        return $this->rewardService->evaluateRewardMilestones($user, $teamBusiness);
    }
}
