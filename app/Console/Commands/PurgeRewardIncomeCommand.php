<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurgeRewardIncomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'income:remove-rewards
                            {user? : Optional User ID, Email, or Referral Code to remove reward income for}
                            {--all : Remove reward income for all users}
                            {--dry-run : Simulate the removal without making changes to the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove reward income transactions and deduct credited reward amounts from user earning wallets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userInput = $this->argument('user');
        $isAll = $this->option('all');
        $isDryRun = $this->option('dry-run');

        $query = Transaction::whereIn('type', ['reward_income', 'reward']);

        if ($userInput) {
            $user = User::where('id', $userInput)
                ->orWhere('email', $userInput)
                ->orWhere('referral_code', $userInput)
                ->first();

            if (! $user) {
                $this->error("User not found matching '{$userInput}'.");

                return Command::FAILURE;
            }

            $query->where('user_id', $user->id);
        }

        $rewardTransactions = $query->get();

        if ($rewardTransactions->isEmpty()) {
            $this->info('No reward income transactions found matching criteria.');

            return Command::SUCCESS;
        }

        $grouped = $rewardTransactions->groupBy('user_id');

        $rows = [];
        $totalRemovedCount = 0;
        $totalDeductedAmount = 0.00;

        foreach ($grouped as $userId => $transactions) {
            $user = User::find($userId);
            if (! $user) {
                continue;
            }

            $rewardSum = (float) $transactions->sum('amount');
            $txCount = $transactions->count();
            $oldBalance = (float) $user->earning_wallet;
            $newBalance = max(0.00, $oldBalance - $rewardSum);

            $rows[] = [
                'user_id' => $user->id,
                'name' => $user->name,
                'referral_code' => $user->referral_code,
                'tx_count' => $txCount,
                'reward_total' => '$'.number_format($rewardSum, 2),
                'old_wallet' => '$'.number_format($oldBalance, 2),
                'new_wallet' => '$'.number_format($newBalance, 2),
            ];

            $totalRemovedCount += $txCount;
            $totalDeductedAmount += $rewardSum;

            if (! $isDryRun) {
                DB::transaction(function () use ($user, $newBalance, $transactions) {
                    $user->update(['earning_wallet' => $newBalance]);

                    Transaction::whereIn('id', $transactions->pluck('id'))->delete();
                });
            }
        }

        $this->table(
            ['User ID', 'Name', 'Referral Code', 'Tx Count', 'Reward Total', 'Old Wallet', 'New Wallet'],
            $rows
        );

        $actionText = $isDryRun ? '[DRY RUN - No changes saved]' : '[SUCCESS - Purged from DB]';
        $this->info("{$actionText} Total Transactions Removed: {$totalRemovedCount} | Total Rewards Purged: \$".number_format($totalDeductedAmount, 2));

        return Command::SUCCESS;
    }
}
