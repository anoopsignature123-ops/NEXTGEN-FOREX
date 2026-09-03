<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class BoosterBonusService
 *
 * BUSINESS INCOME RULE 3: 24 HOURS SPECIAL BONUS (PDF Presentation Slide 14)
 * -------------------------------------------------------------------------
 * Description:
 * Special time-sensitive booster incentive given to members who sponsor 5 direct
 * active referrals within 24 hours of creating their account.
 *
 * Booster Tiers & Gift Rewards:
 * - Tier 1: 5 Direct Members × $100 Package ($500 Direct Business)  --> $50 GIFT BONUS
 * - Tier 2: 5 Direct Members × $500 Package ($2500 Direct Business) --> $250 GIFT BONUS
 * - Tier 3: 5 Direct Members × $1000 Package ($5000 Direct Business)--> $500 GIFT BONUS
 *
 * Eligibility Conditions:
 * 1. Time Constraint: Direct referrals must register within 24 hours of Sponsor's account creation.
 * 2. Quantity Constraint: Minimum 5 active direct sponsored members.
 * 3. Volume Constraint: Total direct volume must satisfy Tier 1 ($500), Tier 2 ($2,500), or Tier 3 ($5,000).
 * 4. Frequency Limit: Bonus is rewarded once per user account.
 */
class BoosterBonusService
{
    /**
     * Evaluate and distribute 24 Hours Special Bonus for a user.
     *
     * @param  User  $user  The sponsor being evaluated.
     * @return float Amount of booster bonus credited ($0 if not eligible).
     */
    public function evaluateBoosterBonus(User $user): float
    {
        // 0. MANDATORY CHECK: User/Sponsor MUST HAVE AN ACTIVE ACCOUNT ($user->status === 'active' && $user->activated_at)
        if ($user->status !== 'active' || ! $user->activated_at) {
            return 0.00;
        }

        // 1. Check if user already received 24h bonus
        $alreadyClaimed = Transaction::where('user_id', $user->id)
            ->where('type', '24h_bonus')
            ->exists();

        if ($alreadyClaimed) {
            return 0.00;
        }

        // 2. Calculate 24h window from exact Account Activation Time (activated_at)
        $activationTime = $user->activated_at;
        $windowEnd = $activationTime->copy()->addHours(24);

        // 3. Count direct referrals who activated their accounts within sponsor's 24h activation window
        $directReferralsWithin24h = User::where('sponsor_code', $user->referral_code)
            ->where('activated_at', '>=', $activationTime)
            ->where('activated_at', '<=', $windowEnd)
            ->where('status', 'active')
            ->with('userPackages')
            ->get();

        if ($directReferralsWithin24h->count() < 5) {
            return 0.00;
        }

        // 4. Calculate total direct business volume within 24h window
        $totalDirectBusiness = 0.00;
        foreach ($directReferralsWithin24h as $ref) {
            $totalDirectBusiness += $ref->userPackages->where('purchased_at', '<=', $windowEnd)->sum('invested_amount');
        }

        // 5. Determine Bonus Tier
        $bonusAmount = 0.00;
        $tierName = '';

        if ($totalDirectBusiness >= 5000) {
            $bonusAmount = 500.00;
            $tierName = 'Tier 3 (5 Directs x $1000 = $5000 Business)';
        } elseif ($totalDirectBusiness >= 2500) {
            $bonusAmount = 250.00;
            $tierName = 'Tier 2 (5 Directs x $500 = $2500 Business)';
        } elseif ($totalDirectBusiness >= 500) {
            $bonusAmount = 50.00;
            $tierName = 'Tier 1 (5 Directs x $100 = $500 Business)';
        }

        if ($bonusAmount <= 0) {
            return 0.00;
        }

        // 6. Credit Bonus to Earning Wallet
        DB::transaction(function () use ($user, $bonusAmount, $tierName) {
            $user->increment('earning_wallet', $bonusAmount);

            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'earning_wallet',
                'amount' => $bonusAmount,
                'charge' => 0.00,
                'post_balance' => $user->fresh()->earning_wallet,
                'trx_type' => '+',
                'type' => '24h_bonus',
                'description' => 'Received 24 Hours Special Booster Bonus of $'.number_format($bonusAmount, 2)." ({$tierName})",
                'status' => 'completed',
            ]);
        });

        return $bonusAmount;
    }
}
