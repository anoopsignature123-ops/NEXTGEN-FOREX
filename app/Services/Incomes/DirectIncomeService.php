<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Support\Facades\DB;

/**
 * Class DirectIncomeService
 *
 * BUSINESS INCOME RULE 2: DIRECT INCOME (10%) (PDF Presentation Slide 15)
 * -------------------------------------------------------------------------
 * Description:
 * Instant 10% referral commission earned by direct sponsors whenever a newly
 * referred customer purchases or upgrades an investment package.
 *
 * Rules & Percentages:
 * - Direct Referral Commission Rate: Flat 10.00% of invested capital.
 * - Upper Limits: No limit on direct referrals or direct income earned.
 * - Wallet Type Credited: Earning Wallet ('earning_wallet').
 *
 * Eligibility & Execution Flow:
 * 1. Triggered immediately inside PackageController upon package purchase.
 * 2. Checks if purchaser has a valid sponsor_code linked to a registered User.
 * 3. Calculates: $directCommission = ($investedAmount * 10) / 100.
 * 4. Sponsor's 'earning_wallet' is incremented instantly by $directCommission.
 * 5. Creates financial transaction record with type 'direct_commission'.
 */
class DirectIncomeService
{
    /**
     * Constant Direct Referral Income Rate (10%).
     */
    public const DIRECT_COMMISSION_PERCENTAGE = 10.0;

    /**
     * Calculate and distribute 10% Direct Referral Commission to purchaser's sponsor.
     *
     * @param  User  $purchaser  The member purchasing the package.
     * @param  UserPackage  $userPackage  The purchased package model instance.
     * @param  float  $investedAmount  The invested capital amount ($).
     * @return float Amount of direct commission credited to sponsor.
     */
    public function distributeDirectCommission(User $purchaser, UserPackage $userPackage, float $investedAmount): float
    {
        if (! $purchaser->sponsor_code) {
            return 0.00;
        }

        $sponsor = User::where('referral_code', $purchaser->sponsor_code)->first();

        if (! $sponsor || $sponsor->status !== 'active') {
            return 0.00;
        }

        $commissionAmount = ($investedAmount * self::DIRECT_COMMISSION_PERCENTAGE) / 100;

        if ($commissionAmount <= 0) {
            return 0.00;
        }

        DB::transaction(function () use ($sponsor, $purchaser, $userPackage, $investedAmount, $commissionAmount) {
            // 1. Credit Sponsor Earning Wallet
            $sponsor->increment('earning_wallet', $commissionAmount);

            // 2. Create Audit Transaction Record
            Transaction::create([
                'user_id' => $sponsor->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'earning_wallet',
                'amount' => $commissionAmount,
                'charge' => 0.00,
                'post_balance' => $sponsor->fresh()->earning_wallet,
                'trx_type' => '+',
                'type' => 'direct_commission',
                'description' => 'Received 10% Direct Commission of $'.number_format($commissionAmount, 2)." from {$purchaser->name} ({$purchaser->referral_code}) package purchase of \$".number_format($investedAmount, 2),
                'reference_id' => $userPackage->id,
                'status' => 'completed',
            ]);
        });

        return $commissionAmount;
    }
}
