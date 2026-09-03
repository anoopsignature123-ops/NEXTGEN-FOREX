<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class RewardIncomeService
 *
 * BUSINESS INCOME RULE 7: REWARD INCOME (10% ON TEAM BUSINESS) (PDF Presentation Slide 19)
 * -----------------------------------------------------------------------------------------
 * Description:
 * Milestone rewards credited to members upon reaching team business volume targets.
 *
 * Reward Tiers (10% Share on Team Business Volume):
 * - Team Business $1,000   --> Reward $100
 * - Team Business $5,000   --> Reward $500
 * - Team Business $10,000  --> Reward $1,000
 * - Team Business $25,000  --> Reward $2,500
 * - Team Business $50,000  --> Reward $5,000
 * - Team Business $100,000 --> Reward $10,000
 * - Team Business $250,000 --> Reward $25,000
 * - Team Business $500,000 --> Reward $50,000
 * - Team Business $10 Lac  --> Reward $1 Lac
 * - Team Business $20 Lac  --> Reward $2 Lac
 * - Team Business $50 Lac  --> Reward $5 Lac
 *
 * Conditions:
 * 1. Calculated on total team business volume (50:50 Power/Weaker ratio).
 * 2. Each milestone reward is credited once per user account upon achievement.
 */
class RewardIncomeService
{
    /**
     * Reward Tiers Definition Array.
     */
    public const REWARD_TIERS = [
        ['team_business' => 5000000.00, 'reward' => 500000.00, 'name' => '$50 Lac Team Business Milestone'],
        ['team_business' => 2000000.00, 'reward' => 200000.00, 'name' => '$20 Lac Team Business Milestone'],
        ['team_business' => 1000000.00, 'reward' => 100000.00, 'name' => '$10 Lac Team Business Milestone'],
        ['team_business' => 500000.00,  'reward' => 50000.00,  'name' => '$500K Team Business Milestone'],
        ['team_business' => 250000.00,  'reward' => 25000.00,  'name' => '$250K Team Business Milestone'],
        ['team_business' => 100000.00,  'reward' => 10000.00,  'name' => '$100K Team Business Milestone'],
        ['team_business' => 50000.00,   'reward' => 5000.00,   'name' => '$50K Team Business Milestone'],
        ['team_business' => 25000.00,   'reward' => 2500.00,   'name' => '$25K Team Business Milestone'],
        ['team_business' => 10000.00,   'reward' => 1000.00,   'name' => '$10K Team Business Milestone'],
        ['team_business' => 5000.00,    'reward' => 500.00,    'name' => '$5K Team Business Milestone'],
        ['team_business' => 1000.00,    'reward' => 100.00,    'name' => '$1K Team Business Milestone'],
    ];

    /**
     * Evaluate team business and credit reward income if milestone achieved.
     *
     * @param  User  $user  Target user.
     * @param  float  $teamBusiness  Total team business volume ($).
     * @return float Total amount of new milestone rewards credited ($).
     */
    public function evaluateRewardMilestones(User $user, float $teamBusiness): float
    {
        if ($user->status !== 'active' || $teamBusiness < 1000) {
            return 0.00;
        }

        $creditedTotal = 0.00;

        foreach (self::REWARD_TIERS as $tier) {
            if ($teamBusiness >= $tier['team_business']) {
                // Check if already claimed this specific reward tier
                $alreadyClaimed = Transaction::where('user_id', $user->id)
                    ->where('type', 'reward_income')
                    ->where('description', 'like', "%{$tier['name']}%")
                    ->exists();

                if (! $alreadyClaimed) {
                    $rewardAmount = $tier['reward'];

                    DB::transaction(function () use ($user, $rewardAmount, $tier, $teamBusiness) {
                        $user->increment('earning_wallet', $rewardAmount);

                        Transaction::create([
                            'user_id' => $user->id,
                            'txn_number' => 'TXN-'.rand(10000000, 99999999),
                            'wallet_type' => 'earning_wallet',
                            'amount' => $rewardAmount,
                            'charge' => 0.00,
                            'post_balance' => $user->fresh()->earning_wallet,
                            'trx_type' => '+',
                            'type' => 'reward_income',
                            'description' => 'Received 10% Reward Income of $'.number_format($rewardAmount, 2)." ({$tier['name']} achieved on team business volume of \$".number_format($teamBusiness, 2).')',
                            'status' => 'completed',
                        ]);
                    });

                    $creditedTotal += $rewardAmount;
                }
            }
        }

        return $creditedTotal;
    }
}
