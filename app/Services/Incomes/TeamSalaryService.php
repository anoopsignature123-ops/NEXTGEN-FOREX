<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class TeamSalaryService
 *
 * BUSINESS INCOME RULE 6: TEAM SALARY INCOME ON DIRECT BUSINESS (PDF Presentation Slide 18)
 * -------------------------------------------------------------------------------------------
 * Description:
 * Recurring 15-day team salary payouts earned on matching team business milestones
 * for a tenure of 12 months (24 payout cycles).
 *
 * Tiers & 15-Day Payout Schedule (12 Months Duration):
 * - Matching Business $5,000   --> Team Salary $150  ($75 per 15 Days for 12 Months)
 * - Matching Business $10,000  --> Team Salary $250  ($75 per 15 Days for 12 Months)
 * - Matching Business $25,000  --> Team Salary $500  ($75 per 15 Days for 12 Months)
 * - Matching Business $50,000  --> Team Salary $1000 ($75 per 15 Days for 12 Months)
 * - Matching Business $1 Lac   --> Team Salary $2000 ($75 per 15 Days for 12 Months)
 * - Matching Business $2.5 Lac --> Team Salary $4500 ($75 per 15 Days for 12 Months)
 * - Matching Business $5 Lac   --> Team Salary $9500 ($75 per 15 Days for 12 Months)
 * - Matching Business $10 Lac  --> Team Salary $20000($75 per 15 Days for 12 Months)
 * - Matching Business $25 Lac  --> Team Salary $42000($75 per 15 Days for 12 Months)
 * - Matching Business $50 Lac  --> Team Salary $1 Lac ($75 per 15 Days for 12 Months)
 * - Matching Business $100 Lac --> Team Salary $3 Lac ($75 per 15 Days for 12 Months)
 *
 * Conditions:
 * - 50:50 ratio between Power Leg and Weaker Leg.
 * - Note: 10% new business mandatory every next 3 months to maintain salary eligibility.
 */
class TeamSalaryService
{
    /**
     * Team Salary Tiers Definition Array.
     */
    public const TEAM_SALARY_TIERS = [
        ['matching_business' => 10000000.00, 'cycle_salary' => 75.00, 'total_salary' => 300000.00, 'label' => '100 Lac Matching Business'],
        ['matching_business' => 5000000.00,  'cycle_salary' => 75.00, 'total_salary' => 100000.00, 'label' => '50 Lac Matching Business'],
        ['matching_business' => 2500000.00,  'cycle_salary' => 75.00, 'total_salary' => 42000.00,  'label' => '25 Lac Matching Business'],
        ['matching_business' => 1000000.00,  'cycle_salary' => 75.00, 'total_salary' => 20000.00,  'label' => '10 Lac Matching Business'],
        ['matching_business' => 500000.00,   'cycle_salary' => 75.00, 'total_salary' => 9500.00,   'label' => '5 Lac Matching Business'],
        ['matching_business' => 250000.00,   'cycle_salary' => 75.00, 'total_salary' => 4500.00,   'label' => '2.5 Lac Matching Business'],
        ['matching_business' => 100000.00,   'cycle_salary' => 75.00, 'total_salary' => 2000.00,   'label' => '1 Lac Matching Business'],
        ['matching_business' => 50000.00,    'cycle_salary' => 75.00, 'total_salary' => 1000.00,   'label' => '50K Matching Business'],
        ['matching_business' => 25000.00,    'cycle_salary' => 75.00, 'total_salary' => 500.00,    'label' => '25K Matching Business'],
        ['matching_business' => 10000.00,    'cycle_salary' => 75.00, 'total_salary' => 250.00,    'label' => '10K Matching Business'],
        ['matching_business' => 5000.00,     'cycle_salary' => 75.00, 'total_salary' => 150.00,    'label' => '5K Matching Business'],
    ];

    /**
     * Process 15-day Team Salary payout cycle for a member.
     *
     * @param  User  $user  Target user.
     * @param  float  $matchingBusiness  User's team matching business volume ($).
     * @return float Amount of team salary credited ($75 per cycle).
     */
    public function processUserTeamSalary(User $user, float $matchingBusiness): float
    {
        if ($user->status !== 'active' || $matchingBusiness < 5000) {
            return 0.00;
        }

        $matchedTier = null;
        foreach (self::TEAM_SALARY_TIERS as $tier) {
            if ($matchingBusiness >= $tier['matching_business']) {
                $matchedTier = $tier;
                break;
            }
        }

        if (! $matchedTier) {
            return 0.00;
        }

        $cycleSalaryAmount = $matchedTier['cycle_salary'];

        DB::transaction(function () use ($user, $cycleSalaryAmount, $matchedTier, $matchingBusiness) {
            $user->increment('earning_wallet', $cycleSalaryAmount);

            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'earning_wallet',
                'amount' => $cycleSalaryAmount,
                'charge' => 0.00,
                'post_balance' => $user->fresh()->earning_wallet,
                'trx_type' => '+',
                'type' => 'team_salary',
                'description' => 'Received Team Salary Cycle Payout of $'.number_format($cycleSalaryAmount, 2)." ({$matchedTier['label']} for matching business of \$".number_format($matchingBusiness, 2).')',
                'status' => 'completed',
            ]);
        });

        return $cycleSalaryAmount;
    }
}
