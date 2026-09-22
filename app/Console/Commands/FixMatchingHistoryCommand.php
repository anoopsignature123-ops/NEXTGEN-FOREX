<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixMatchingHistoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'income:fix-matching-history {user? : Optional User ID, Email, or Referral Code to target}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit and recalculate 5% matching income history for members based on Power Leg vs Weaker Leg volume, removing duplicate payouts while preserving backdate timestamps.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userInput = $this->argument('user');

        if ($userInput) {
            $users = User::where('id', $userInput)
                ->orWhere('email', $userInput)
                ->orWhere('referral_code', $userInput)
                ->get();
        } else {
            $users = User::where('status', 'active')->get();
        }

        if ($users->isEmpty()) {
            $this->error('No active users found matching your selection criteria.');

            return Command::FAILURE;
        }

        $this->info('Starting Matching Income Backdate History Audit & Recalculation for '.$users->count().' user(s)...');

        $rows = [];

        foreach ($users as $user) {
            DB::transaction(function () use ($user, &$rows) {
                // Find all distinct package purchase dates across downline to evaluate
                $directs = User::where('sponsor_code', $user->referral_code)->get();

                if ($directs->isEmpty()) {
                    return;
                }

                // Collect all downline user IDs
                $allDownlineIds = $user->getDownlineUserIds();
                if (empty($allDownlineIds)) {
                    return;
                }

                // Get all dates when packages were purchased in downline
                $pkgDates = UserPackage::whereIn('user_id', $allDownlineIds)
                    ->selectRaw('DATE(created_at) as pkg_date')
                    ->distinct()
                    ->orderBy('pkg_date', 'asc')
                    ->pluck('pkg_date')
                    ->toArray();

                if (empty($pkgDates)) {
                    return;
                }

                // Track matched volume across dates
                $alreadyMatchedVolume = 0.0;
                $validTxnIds = [];
                $newTxnLogsCount = 0;

                foreach ($pkgDates as $dateStr) {
                    $asOfDate = Carbon::parse($dateStr.' 23:59:59');

                    // Calculate leg volumes as of this date
                    $legVolumes = [];
                    foreach ($directs as $direct) {
                        $branchUserIds = array_merge([$direct->id], $direct->getDownlineUserIds());
                        $vol = (float) UserPackage::whereIn('user_id', $branchUserIds)
                            ->where('created_at', '<=', $asOfDate)
                            ->sum('invested_amount');
                        $legVolumes[] = $vol;
                    }

                    rsort($legVolumes);
                    $powerLeg = $legVolumes[0] ?? 0.0;
                    $weakerLeg = array_sum(array_slice($legVolumes, 1));
                    $cumMatchedVolume = min($powerLeg, $weakerLeg);

                    $incrementalMatched = max(0.0, $cumMatchedVolume - $alreadyMatchedVolume);

                    if ($incrementalMatched > 0.0) {
                        $matchingIncome = ($incrementalMatched * 5.0) / 100.0;
                        $alreadyMatchedVolume += $incrementalMatched;

                        $payoutTime = Carbon::parse($dateStr.' 05:35:00');

                        // Check if a transaction exists for this user on this date
                        $existingTxn = Transaction::where('user_id', $user->id)
                            ->where('type', 'matching_income')
                            ->whereDate('created_at', $dateStr)
                            ->first();

                        if ($existingTxn) {
                            $existingTxn->amount = $matchingIncome;
                            $existingTxn->description = 'Received 5% Matching Income of $'.number_format($matchingIncome, 2).' on matched volume of $'.number_format($cumMatchedVolume, 2);
                            $existingTxn->created_at = $payoutTime;
                            $existingTxn->updated_at = $payoutTime;
                            $existingTxn->save();

                            $validTxnIds[] = $existingTxn->id;
                        } else {
                            $newTxn = new Transaction([
                                'user_id' => $user->id,
                                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                                'wallet_type' => 'earning_wallet',
                                'amount' => $matchingIncome,
                                'charge' => 0.00,
                                'post_balance' => 0.00,
                                'trx_type' => '+',
                                'type' => 'matching_income',
                                'description' => 'Received 5% Matching Income of $'.number_format($matchingIncome, 2).' on matched volume of $'.number_format($cumMatchedVolume, 2),
                                'status' => 'completed',
                            ]);
                            $newTxn->created_at = $payoutTime;
                            $newTxn->updated_at = $payoutTime;
                            $newTxn->save();

                            $validTxnIds[] = $newTxn->id;
                        }
                        $newTxnLogsCount++;
                    }
                }

                // Delete any invalid duplicate matching transactions for this user
                Transaction::where('user_id', $user->id)
                    ->where('type', 'matching_income')
                    ->whereNotIn('id', $validTxnIds)
                    ->delete();

                // Recalculate post balances and earning_wallet for user to keep wallet 100% accurate
                $userFresh = $user->fresh();
                $allUserTxns = Transaction::where('user_id', $userFresh->id)->orderBy('created_at', 'asc')->get();
                $runningBalance = 0.0;
                foreach ($allUserTxns as $t) {
                    if ($t->trx_type === '+') {
                        $runningBalance += (float) $t->amount;
                    } else {
                        $runningBalance -= (float) $t->amount;
                    }
                    $t->update(['post_balance' => $runningBalance]);
                }
                $userFresh->update(['earning_wallet' => $runningBalance]);

                // Collect summary for table display
                $legStats = $userFresh->leg_volume_stats;
                $powerLeg = (float) ($legStats['power_leg'] ?? 0.00);
                $weakerLeg = (float) ($legStats['remaining_leg'] ?? 0.00);
                $matchedVolume = min($powerLeg, $weakerLeg);
                $totalPaid = (float) Transaction::where('user_id', $userFresh->id)->where('type', 'matching_income')->sum('amount');
                $payoutLogsCount = Transaction::where('user_id', $userFresh->id)->where('type', 'matching_income')->count();

                $matchingTxns = Transaction::where('user_id', $userFresh->id)->where('type', 'matching_income')->orderBy('created_at', 'asc')->get();
                $firstBackdate = $matchingTxns->isNotEmpty() ? $matchingTxns->first()->created_at : null;
                $latestBackdate = $matchingTxns->isNotEmpty() ? $matchingTxns->last()->created_at : null;

                $powerCarry = max(0.00, $powerLeg - ($totalPaid * 100.0 / 5.0));
                $weakerCarry = max(0.00, $weakerLeg - ($totalPaid * 100.0 / 5.0));

                $rows[] = [
                    'user' => $userFresh->name.' ('.$userFresh->referral_code.')',
                    'power_leg' => '$'.number_format($powerLeg, 2).' (Carry: $'.number_format($powerCarry, 2).')',
                    'weaker_leg' => '$'.number_format($weakerLeg, 2).' (Carry: $'.number_format($weakerCarry, 2).')',
                    'matched_vol' => '$'.number_format($matchedVolume, 2),
                    'matching_income' => '$'.number_format($totalPaid, 2),
                    'payout_logs' => $payoutLogsCount.' Log(s)',
                    'dates' => ($firstBackdate ? $firstBackdate->format('Y-m-d') : 'N/A').' to '.($latestBackdate ? $latestBackdate->format('Y-m-d') : 'N/A'),
                    'earning_wallet' => '$'.number_format((float) $userFresh->earning_wallet, 2),
                ];
            });
        }

        $this->table(
            ['User / Referral', 'Power Leg (Total & Carry)', 'Weaker Leg (Total & Carry)', 'Matched Vol', 'Matching Earned', 'Payout Logs', 'History Dates', 'Earning Wallet'],
            $rows
        );

        $this->info('Matching Income Backdate History Audit & Recalculation Completed Successfully!');

        return Command::SUCCESS;
    }
}
