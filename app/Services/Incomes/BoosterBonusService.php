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
        // 0. MANDATORY CHECK: User/Sponsor MUST HAVE AN ACTIVE ACCOUNT ($user->status === 'active')
        if ($user->status !== 'active') {
            return 0.00;
        }

        // 1. Check if user already received 24h bonus
        $alreadyClaimed = Transaction::where('user_id', $user->id)
            ->where('type', '24h_bonus')
            ->exists();

        if ($alreadyClaimed) {
            return 0.00;
        }

        // 2. Calculate 24h window from Account Activation / Creation Time
        $activationTime = $user->activated_at ?? $user->created_at ?? now();
        $windowEnd = $activationTime->copy()->addHours(24);

        // Ensure sponsor model has activated_at timestamp set if missing
        if (! $user->activated_at) {
            $user->update(['activated_at' => $activationTime]);
        }

        // 3. Get all active direct referrals sponsored by this user who registered/activated within 24h window of Sponsor
        $directReferrals = User::where('sponsor_code', $user->referral_code)
            ->where('status', 'active')
            ->with('userPackages')
            ->get()
            ->filter(function ($ref) use ($windowEnd) {
                $refTime = $ref->activated_at ?? $ref->created_at;
                if (! $refTime) {
                    return true;
                }

                return $refTime <= $windowEnd;
            });

        if ($directReferrals->count() < 5) {
            return 0.00;
        }

        // 4. Calculate total direct business volume within 24h window
        $totalDirectBusiness = 0.00;
        foreach ($directReferrals as $ref) {
            $refBusiness = $ref->userPackages->filter(function ($pkg) use ($windowEnd) {
                $purchasedAt = $pkg->purchased_at ?? $pkg->created_at;

                return ! $purchasedAt || $purchasedAt <= $windowEnd;
            })->sum('invested_amount');

            if ($refBusiness == 0 && $ref->userPackages->count() > 0) {
                $refBusiness = $ref->userPackages->sum('invested_amount');
            }

            $totalDirectBusiness += $refBusiness;
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
