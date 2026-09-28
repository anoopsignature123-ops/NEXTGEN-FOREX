<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreditManualIncomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'income:credit-manual
                            {user : User ID, Email, or Referral Code}
                            {amount : Amount to credit}
                            {--type=matching_income : Income type (matching_income, roi_income, direct_income, level_income, reward, team_salary, admin_add_fund)}
                            {--wallet=earning_wallet : Target wallet (earning_wallet, deposit_wallet)}
                            {--remark=Manual Credit by Admin : Custom transaction note/remark}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually credit matching income or direct fund to a member account with full audit trail log';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userInput = $this->argument('user');
        $amount = (float) $this->argument('amount');
        $type = $this->option('type');
        $walletType = $this->option('wallet');
        $userRemark = $this->option('remark');

        if ($amount <= 0) {
            $this->error('Amount must be greater than 0.');

            return Command::FAILURE;
        }

        $user = User::where('id', $userInput)
            ->orWhere('email', $userInput)
            ->orWhere('referral_code', $userInput)
            ->first();

        if (! $user) {
            $this->error("User not found matching '{$userInput}'.");

            return Command::FAILURE;
        }

        DB::transaction(function () use ($user, $amount, $type, $walletType, $userRemark) {
            $user->increment($walletType, $amount);

            $userFresh = $user->fresh();

            $incomeTypeLabels = [
                'matching_income' => 'Matching Income',
                'roi_income' => 'Daily ROI Income',
                'direct_income' => 'Direct Referral Income',
                'level_income' => 'Level Income',
                'reward' => 'Reward Income',
                'team_salary' => 'Team Salary Income',
                'admin_add_fund' => 'Direct Fund Credit',
            ];
            $label = $incomeTypeLabels[$type] ?? 'Fund Credit';

            $description = $type === 'matching_income'
                ? "Received 5% Matching Income of \${$amount} (Manual Credit by Admin: {$userRemark})"
                : "{$label} of \${$amount} (Manual Credit by Admin: {$userRemark})";

            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => $walletType,
                'amount' => $amount,
                'charge' => 0.00,
                'post_balance' => $userFresh->{$walletType},
                'trx_type' => '+',
                'type' => $type,
                'description' => $description,
                'reference_id' => 'ADMIN-MANUAL',
                'status' => 'completed',
            ]);
        });

        $userFresh = $user->fresh();

        $this->info("Successfully credited \${$amount} [{$type}] to {$userFresh->name} ({$userFresh->referral_code}).");
        $this->info("New {$walletType} balance: \${$userFresh->{$walletType}}");

        return Command::SUCCESS;
    }
}
