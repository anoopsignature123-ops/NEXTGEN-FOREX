<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class LevelIncomeService
 *
 * BUSINESS INCOME RULE 4: LEVEL INCOME (10 LEVELS) (PDF Presentation Slide 15)
 * -------------------------------------------------------------------------
 * Description:
 * Multi-tier level commission distributed across 10 levels of active upline sponsors.
 *
 * Level Percentages:
 * - Level 1: 20.00%
 * - Level 2: 10.00%
 * - Level 3:  5.00%
 * - Level 4:  4.00%
 * - Level 5:  3.00%
 * - Level 6:  2.00%
 * - Level 7:  2.00%
 * - Level 8:  2.00%
 * - Level 9:  1.00%
 * - Level 10: 1.00%
 *
 * Unlocking Requirements (Direct Referral Unlocking Rule):
 * - 1 Direct Referral  -> Unlocks Level 1 & Level 2
 * - 2 Direct Referrals -> Unlocks Level 3 & Level 4
 * - 3 Direct Referrals -> Unlocks Level 5
 * - 4 Direct Referrals -> Unlocks Level 6, Level 7 & Level 8
 * - 5 Direct Referrals -> Unlocks Level 9 & Level 10 (All 10 Levels Unlocked)
 */
class LevelIncomeService
{
    /**
     * Level Rates Map (10 Levels).
     */
    public const LEVEL_RATES = [
        1 => 20.0,
        2 => 10.0,
        3 => 5.0,
        4 => 4.0,
        5 => 3.0,
        6 => 2.0,
        7 => 2.0,
        8 => 2.0,
        9 => 1.0,
        10 => 1.0,
    ];

    /**
     * Check if a sponsor user has unlocked a specific level (1-10) based on direct referrals.
     */
    public function isLevelUnlocked(User $sponsor, int $level): bool
    {
        $directCount = User::where('sponsor_code', $sponsor->referral_code)->count();

        if ($level <= 2 && $directCount >= 1) {
            return true;
        }
        if ($level <= 4 && $directCount >= 2) {
            return true;
        }
        if ($level <= 5 && $directCount >= 3) {
            return true;
        }
        if ($level <= 8 && $directCount >= 4) {
            return true;
        }
        if ($level <= 10 && $directCount >= 5) {
            return true;
        }

        return false;
    }

    /**
     * Distribute Level Income up to 10 levels of upline sponsors for a given base amount.
     *
     * @param  User  $downline  The member receiving ROI yield or purchasing package.
     * @param  float  $baseAmount  The base dollar amount ($).
     * @param  string  $sourceType  'roi' or 'package_purchase'
     * @return float Total level commission distributed across all 10 upline levels.
     */
    public function distributeLevelIncome(User $downline, float $baseAmount, string $sourceType = 'roi'): float
    {
        if ($baseAmount <= 0 || ! $downline->sponsor_code) {
            return 0.00;
        }

        $currentSponsorCode = $downline->sponsor_code;
        $totalDistributed = 0.00;

        for ($level = 1; $level <= 10; $level++) {
            if (! $currentSponsorCode) {
                break;
            }

            $upline = User::where('referral_code', $currentSponsorCode)->first();
            if (! $upline) {
                break;
            }

            // Verify upline is active and has unlocked this level
            if ($upline->status === 'active' && $this->isLevelUnlocked($upline, $level)) {
                $rate = self::LEVEL_RATES[$level] ?? 0.0;
                $incomeAmount = ($baseAmount * $rate) / 100;

                if ($incomeAmount > 0) {
                    DB::transaction(function () use ($upline, $downline, $incomeAmount, $level, $rate, $sourceType) {
                        $upline->increment('earning_wallet', $incomeAmount);

                        $sourceText = ($sourceType === 'roi') ? 'Daily ROI Yield' : 'Package Investment';

                        Transaction::create([
                            'user_id' => $upline->id,
                            'txn_number' => 'TXN-'.rand(10000000, 99999999),
                            'wallet_type' => 'earning_wallet',
                            'amount' => $incomeAmount,
                            'charge' => 0.00,
                            'post_balance' => $upline->fresh()->earning_wallet,
                            'trx_type' => '+',
                            'type' => 'level_income',
                            'description' => "Received Level {$level} Income ({$rate}%) of \$".number_format($incomeAmount, 2)." from downline {$downline->name} ({$downline->referral_code}) {$sourceText}",
                            'reference_id' => $downline->id,
                            'status' => 'completed',
                        ]);
                    });

                    $totalDistributed += $incomeAmount;
                }
            }

            $currentSponsorCode = $upline->sponsor_code;
        }

        return $totalDistributed;
    }
}
