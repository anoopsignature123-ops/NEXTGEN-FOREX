<?php

namespace App\Services\Incomes;

use App\Models\Transaction;
use App\Models\UserPackage;
use Illuminate\Support\Facades\DB;

/**
 * Class RoiIncomeService
 *
 * BUSINESS INCOME RULE 1: DAILY ROI INCOME (PDF Presentation Slide 13)
 * -------------------------------------------------------------------------
 * Description:
 * Every active package investor receives a daily Return on Investment (ROI) yield
 * based on their selected package tier for a duration of 200 days or until the
 * total earnings hit the 2X Total Return Cap (200% of invested capital).
 *
 * Tiers & Yield Percentages:
 * - Package 1 ($10 to $100):     0.50% Daily Yield | 200 Days | 2X Cap Limit
 * - Package 2 ($100 to $500):    0.75% Daily Yield | 200 Days | 2X Cap Limit
 * - Package 3 ($500 to $1000):   1.00% Daily Yield | 200 Days | 2X Cap Limit
 * - Package 4 ($1000 to $5000):  1.25% Daily Yield | 200 Days | 2X Cap Limit
 * - Package 5 ($5000 & Above):   1.50% Daily Yield | 200 Days | 2X Cap Limit
 *
 * Eligibility & Capping Rules:
 * 1. UserPackage must be in 'active' status.
 * 2. Cumulative paid_roi_amount must be strictly less than total_return_amount (2X cap).
 * 3. Daily yield = min(daily_roi_amount, (total_return_amount - paid_roi_amount)).
 * 4. Yield amount is credited directly to user's 'earning_wallet'.
 * 5. Once paid_roi_amount hits 2X cap, UserPackage status transitions to 'completed'.
 */
class RoiIncomeService
{
    /**
     * Process Daily ROI Payout for a single active UserPackage contract.
     *
     * @param  UserPackage  $userPkg  The active investment package contract.
     * @return float Amount of ROI credited during this transaction.
     */
    public function processSinglePackageRoi(UserPackage $userPkg): float
    {
        if ($userPkg->status !== 'active' || ! $userPkg->user || ! $userPkg->user->is_bot_active) {
            return 0.00;
        }

        $creditedAmount = 0.00;

        DB::transaction(function () use ($userPkg, &$creditedAmount) {
            $remainingCap = (float) $userPkg->total_return_amount - (float) $userPkg->paid_roi_amount;
            $dailyYield = min((float) $userPkg->daily_roi_amount, $remainingCap);

            if ($dailyYield <= 0) {
                $userPkg->update(['status' => 'completed']);

                return;
            }

            // 1. Credit Earning Wallet
            $user = $userPkg->user;
            $user->increment('earning_wallet', $dailyYield);

            // 2. Update Contract Paid ROI and Status
            $newPaidRoi = (float) $userPkg->paid_roi_amount + $dailyYield;
            $newStatus = ($newPaidRoi >= (float) $userPkg->total_return_amount) ? 'completed' : 'active';

            $userPkg->update([
                'paid_roi_amount' => $newPaidRoi,
                'status' => $newStatus,
            ]);

            // 3. Log Financial Transaction Audit
            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'earning_wallet',
                'amount' => $dailyYield,
                'charge' => 0.00,
                'post_balance' => $user->fresh()->earning_wallet,
                'trx_type' => '+',
                'type' => 'daily_roi',
                'description' => 'Daily ROI Yield of $'.number_format($dailyYield, 2)." credited from {$userPkg->package->name} contract (\${$userPkg->invested_amount})",
                'reference_id' => $userPkg->id,
                'status' => 'completed',
            ]);

            $creditedAmount = $dailyYield;

            // 4. Distribute 10-Tier Level Income to Upline Sponsors based on Daily ROI Yield
            app(LevelIncomeService::class)->distributeLevelIncome($user, $dailyYield, 'roi');
        });

        return $creditedAmount;
    }

    /**
     * Process Daily ROI Payouts for all active contracts in system.
     *
     * @return array Summary of contracts processed and total ROI amount credited.
     */
    public function processAllDailyRoi(): array
    {
        $activePackages = UserPackage::with(['user', 'package'])
            ->where('status', 'active')
            ->whereHas('user', function ($query) {
                $query->where('is_bot_active', true);
            })
            ->whereColumn('paid_roi_amount', '<', 'total_return_amount')
            ->get();

        $processedCount = 0;
        $totalAmountCredited = 0.00;

        foreach ($activePackages as $pkg) {
            $amount = $this->processSinglePackageRoi($pkg);
            if ($amount > 0) {
                $processedCount++;
                $totalAmountCredited += $amount;
            }
        }

        return [
            'processed_contracts' => $processedCount,
            'total_roi_amount' => $totalAmountCredited,
        ];
    }
}
