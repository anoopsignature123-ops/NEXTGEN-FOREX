<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class MatchingIncomeService
 *
 * BUSINESS INCOME RULE 4: MATCHING INCOME (5%) (PDF Presentation Slide 16)
 * -------------------------------------------------------------------------
 * Description:
 * Team matching commission earned on matched business volume generated within
 * member network legs.
 *
 * Rules & Percentages:
 * - Matching Commission Rate: 5.00% on matched business volume.
 * - Business Volume Ratio: 50:50 ratio between Power Leg Business and Remaining Business Volume.
 * - Daily Capping: Maximum daily matching income = 5X of User's Active Package Amount.
 *
 * Calculation & Limits:
 * 1. Evaluates Power Leg (highest performing leg) volume vs Weaker Legs total volume.
 * 2. Matched Volume = min(PowerLegVolume, WeakerLegsVolume).
 * 3. Raw Matching Income = MatchedVolume * 0.05.
 * 4. Applied Capping = min(RawMatchingIncome, UserActivePackageAmount * 5).
 * 5. Credited to 'earning_wallet' with transaction type 'matching_income'.
 */
class MatchingIncomeService
{
    /**
     * Matching Income Percentage (5%).
     */
    public const MATCHING_PERCENTAGE = 5.0;

    /**
     * Process Matching Income calculation and credit for a member.
     *
     * @param  User  $user  Target user being evaluated.
     * @param  float  $powerLegVolume  Business volume in power leg ($).
     * @param  float  $weakerLegVolume  Business volume in remaining team legs ($).
     * @return float Amount of matching income credited after 5X capping ($).
     */
    public function processUserMatching(User $user, float $powerLegVolume, float $weakerLegVolume): float
    {
        if ($user->status !== 'active') {
            return 0.00;
        }

        // Matched Volume is min of Power Leg and Weaker Leg
        $matchedVolume = min($powerLegVolume, $weakerLegVolume);

        if ($matchedVolume <= 0) {
            return 0.00;
        }

        $rawIncome = ($matchedVolume * self::MATCHING_PERCENTAGE) / 100;

        // Calculate 5X Package Daily Capping Limit
        $maxPackageAmount = $user->userPackages()->where('status', 'active')->max('invested_amount') ?? 0;
        $dailyCappingLimit = $maxPackageAmount * 5;

        // If user has no active package, capped at 0
        if ($dailyCappingLimit <= 0) {
            return 0.00;
        }

        $finalIncome = min($rawIncome, $dailyCappingLimit);

        if ($finalIncome <= 0) {
            return 0.00;
        }

        DB::transaction(function () use ($user, $finalIncome, $matchedVolume) {
            $user->increment('earning_wallet', $finalIncome);

            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'earning_wallet',
                'amount' => $finalIncome,
                'charge' => 0.00,
                'post_balance' => $user->fresh()->earning_wallet,
                'trx_type' => '+',
                'type' => 'matching_income',
                'description' => 'Received 5% Matching Income of $'.number_format($finalIncome, 2).' on matched volume of $'.number_format($matchedVolume, 2),
                'status' => 'completed',
            ]);
        });

        return $finalIncome;
    }
}
