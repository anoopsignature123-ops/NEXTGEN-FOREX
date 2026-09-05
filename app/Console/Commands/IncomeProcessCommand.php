<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Incomes\DirectSalaryService;
use App\Services\Incomes\MatchingIncomeService;
use App\Services\Incomes\RewardIncomeService;
use App\Services\Incomes\TeamSalaryService;
use Illuminate\Console\Command;

class IncomeProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'income:process {user? : Optional User ID, Email, or Referral Code to target}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and distribute all NextGen Forex incomes (Matching 5%, Direct Salary, Team Salary, and Milestone Rewards)';

    /**
     * Execute the console command.
     */
    public function handle(
        MatchingIncomeService $matchingService,
        DirectSalaryService $directSalaryService,
        TeamSalaryService $teamSalaryService,
        RewardIncomeService $rewardService
    ): int {
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

        $this->info('Starting Income Processing Cycle for '.$users->count().' user(s)...');

        $rows = [];

        foreach ($users as $user) {
            $legStats = $user->leg_volume_stats;

            $powerLeg = (float) ($legStats['power_leg'] ?? 0);
            $weakerLeg = (float) ($legStats['remaining_leg'] ?? 0);
            $teamBusiness = (float) ($legStats['total_team'] ?? 0);

            // Process Incomes
            $matchingPaid = $matchingService->processUserMatching($user, $powerLeg, $weakerLeg);
            $directSalaryPaid = $directSalaryService->processUserDirectSalary($user);
            $teamSalaryPaid = $teamSalaryService->processUserTeamSalary($user, $weakerLeg);
            $rewardPaid = $rewardService->evaluateRewardMilestones($user, $teamBusiness);

            $rows[] = [
                'user' => $user->name.' ('.$user->referral_code.')',
                'matching' => '$'.number_format($matchingPaid, 2),
                'direct_salary' => '$'.number_format($directSalaryPaid, 2),
                'team_salary' => '$'.number_format($teamSalaryPaid, 2),
                'reward' => '$'.number_format($rewardPaid, 2),
                'earning_wallet' => '$'.number_format((float) $user->fresh()->earning_wallet, 2),
            ];
        }

        $this->table(
            ['User / Referral', 'Matching (5%)', 'Direct Salary', 'Team Salary', 'Reward (10%)', 'Earning Wallet'],
            $rows
        );

        $this->info('Income Distribution Cycle Completed Successfully!');

        return Command::SUCCESS;
    }
}
