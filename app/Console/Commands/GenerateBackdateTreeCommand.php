<?php

namespace App\Console\Commands;

use App\Models\Package;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\Incomes\BoosterBonusService;
use App\Services\Incomes\LevelIncomeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GenerateBackdateTreeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:generate-backdate-tree {--reset : Wipe non-admin demo users and recalculate clean backdate state}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate exact 10-user demo hierarchy with backdated registrations, package purchases, daily ROI yields, direct commissions, and level incomes (Sep 9 to Sep 13, 2026)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('===========================================================');
        $this->info(' STARTING EXACT 10-USER BACKDATE TREE & INCOME ENGINE     ');
        $this->info('===========================================================');

        if ($this->option('reset')) {
            $this->warn('Resetting non-admin demo users and transactions...');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Transaction::truncate();
            UserPackage::truncate();
            User::where('role_id', '!=', 1)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info('Database reset clean.');
        }

        if (Role::count() === 0 || Package::count() === 0) {
            $this->warn('Seeding initial database roles and packages...');
            $this->call('db:seed', ['--force' => true]);
        }

        // Load Packages 1, 2, 3, 4
        $pkg1 = Package::where('name', 'LIKE', '%PACKAGE 1%')->first() ?? Package::find(1);
        $pkg2 = Package::where('name', 'LIKE', '%PACKAGE 2%')->first() ?? Package::find(2);
        $pkg3 = Package::where('name', 'LIKE', '%PACKAGE 3%')->first() ?? Package::find(3);
        $pkg4 = Package::where('name', 'LIKE', '%PACKAGE 4%')->first() ?? Package::find(4);

        // Define Exact 10-User Schedule from Sep 9 to Sep 13, 2026 (matching uploaded screenshot)
        $schedule = [
            '2026-09-09' => [
                [
                    'name' => 'Root User',
                    'email' => 'root@nextgenforex.com',
                    'mobile' => '9876543210',
                    'referral_code' => 'NGF-0000001',
                    'sponsor_code' => null,
                    'status' => 'active',
                    'is_bot_active' => false,
                    'reg_time' => '2026-09-09 17:59:00',
                    'act_time' => null,
                    'package' => null,
                ],
                [
                    'name' => 'Yuwansh',
                    'email' => 'yuwanshtraders@gmail.com',
                    'mobile' => '9519761855',
                    'referral_code' => 'NGF-8756057',
                    'sponsor_code' => 'NGF-0000001',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'reg_time' => '2026-09-09 19:41:00',
                    'act_time' => '2026-09-09 19:50:00',
                    'package' => $pkg4,
                    'invested_amount' => 1010.00,
                ],
                [
                    'name' => 'Pradeep Gupta',
                    'email' => 'jayambey2022@gmail.com',
                    'mobile' => '9198844255',
                    'referral_code' => 'NGF-8792947',
                    'sponsor_code' => 'NGF-8756057',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'deposit_wallet' => 2020.00,
                    'reg_time' => '2026-09-09 19:56:00',
                    'act_time' => '2026-09-09 21:02:00',
                    'package' => $pkg4,
                    'invested_amount' => 1010.00,
                ],
            ],
            '2026-09-10' => [
                [
                    'name' => 'Pradeep Arya',
                    'email' => 'sachinroy77774@gmail.com',
                    'mobile' => '9718528335',
                    'referral_code' => 'NGF-3517323',
                    'sponsor_code' => 'NGF-8792947',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'reg_time' => '2026-09-10 20:00:00',
                    'act_time' => '2026-09-10 21:02:00',
                    'package' => $pkg4,
                    'invested_amount' => 3001.00,
                ],
            ],
            '2026-09-11' => [
                [
                    'name' => 'Raja',
                    'email' => 'rajayadav22@gmail.com',
                    'mobile' => '9198543269',
                    'referral_code' => 'NGF-4361034',
                    'sponsor_code' => 'NGF-8792947',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'reg_time' => '2026-09-11 08:44:00',
                    'act_time' => '2026-09-11 08:54:00',
                    'package' => $pkg2,
                    'invested_amount' => 120.00,
                ],
            ],
            '2026-09-12' => [
                [
                    'name' => 'Rajan',
                    'email' => 'rajankumar55@gmail.com',
                    'mobile' => '9198253614',
                    'referral_code' => 'NGF-1863724',
                    'sponsor_code' => 'NGF-8792947',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'reg_time' => '2026-09-12 09:00:00',
                    'act_time' => '2026-09-12 10:00:00',
                    'package' => $pkg2,
                    'invested_amount' => 150.00,
                ],
                [
                    'name' => 'Ram Kumar',
                    'email' => 'ramkumar33@gmail.com',
                    'mobile' => '9198042646',
                    'referral_code' => 'NGF-7759007',
                    'sponsor_code' => 'NGF-8792947',
                    'status' => 'active',
                    'is_bot_active' => false,
                    'reg_time' => '2026-09-12 13:30:00',
                    'act_time' => '2026-09-12 13:42:00',
                    'package' => $pkg1,
                    'invested_amount' => 50.00,
                ],
            ],
            '2026-09-13' => [
                [
                    'name' => 'Rahul soni',
                    'email' => 'rahulsdr@gmail.com',
                    'mobile' => '7589044265',
                    'referral_code' => 'NGF-0878279',
                    'sponsor_code' => 'NGF-3517323',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'reg_time' => '2026-09-13 13:39:00',
                    'act_time' => '2026-09-13 13:45:00',
                    'package' => $pkg1,
                    'invested_amount' => 100.00,
                ],
                [
                    'name' => 'Abid',
                    'email' => 'abidh0064@gmail.com',
                    'mobile' => '9565188416',
                    'referral_code' => 'NGF-5727120',
                    'sponsor_code' => 'NGF-8756057',
                    'status' => 'active',
                    'is_bot_active' => true,
                    'reg_time' => '2026-09-13 13:45:00',
                    'act_time' => '2026-09-13 14:25:00',
                    'package' => $pkg3,
                    'invested_amount' => 1000.00,
                ],
                [
                    'name' => 'Ravi',
                    'email' => 'ravi432@gmail.com',
                    'mobile' => '9504573256',
                    'referral_code' => 'NGF-4536631',
                    'sponsor_code' => 'NGF-8792947',
                    'status' => 'inactive',
                    'is_bot_active' => false,
                    'reg_time' => '2026-09-13 13:47:00',
                    'act_time' => null,
                    'package' => null,
                ],
            ],
        ];

        // Process Date-by-Date Timeline
        foreach ($schedule as $dateStr => $usersData) {
            $this->info("\n>>> PROCESSING BACKDATE: {$dateStr} <<<");

            // 1. Create / Setup Users and Packages for this Day
            foreach ($usersData as $uData) {
                $user = User::where('referral_code', $uData['referral_code'])->first();

                if ($user) {
                    $user->name = $uData['name'];
                    $user->email = $uData['email'];
                    $user->mobile = $uData['mobile'];
                    $user->sponsor_code = $uData['sponsor_code'];
                    $user->status = $uData['status'];
                    $user->is_bot_active = $uData['is_bot_active'];
                    $user->deposit_wallet = $uData['deposit_wallet'] ?? 0.00;
                    $user->earning_wallet = 0.00;
                    $user->activated_at = $uData['act_time'] ? Carbon::parse($uData['act_time']) : null;
                    $user->bot_activated_at = ($uData['is_bot_active'] && $uData['act_time']) ? Carbon::parse($uData['act_time']) : null;
                    $user->created_at = Carbon::parse($uData['reg_time']);
                    $user->updated_at = Carbon::parse($uData['reg_time']);
                    $user->save();

                    $this->line("  Updated User: {$user->name} ({$user->referral_code}) on {$user->created_at}");
                } else {
                    $user = new User([
                        'role_id' => 2,
                        'name' => $uData['name'],
                        'email' => $uData['email'],
                        'mobile' => $uData['mobile'],
                        'password' => Hash::make('12345678'),
                        'referral_code' => $uData['referral_code'],
                        'sponsor_code' => $uData['sponsor_code'],
                        'status' => $uData['status'],
                        'is_bot_active' => $uData['is_bot_active'],
                        'deposit_wallet' => $uData['deposit_wallet'] ?? 0.00,
                        'earning_wallet' => 0.00,
                        'activated_at' => $uData['act_time'] ? Carbon::parse($uData['act_time']) : null,
                        'bot_activated_at' => ($uData['is_bot_active'] && $uData['act_time']) ? Carbon::parse($uData['act_time']) : null,
                    ]);
                    $user->created_at = Carbon::parse($uData['reg_time']);
                    $user->updated_at = Carbon::parse($uData['reg_time']);
                    $user->save();

                    $this->line("  Created User: {$user->name} ({$user->referral_code}) on {$user->created_at}");
                }

                // If user has a package to purchase on this day
                if (! empty($uData['package'])) {
                    $pkgModel = $uData['package'];
                    $amount = (float) $uData['invested_amount'];
                    $actTime = Carbon::parse($uData['act_time']);

                    // Create UserPackage with exact backdate timestamp
                    $userPkg = new UserPackage([
                        'user_id' => $user->id,
                        'package_id' => $pkgModel->id,
                        'invested_amount' => $amount,
                        'daily_roi' => $pkgModel->daily_roi,
                        'daily_roi_amount' => ($amount * $pkgModel->daily_roi) / 100,
                        'total_return_amount' => $amount * 2, // 2X Cap
                        'paid_roi_amount' => 0.00,
                        'status' => 'active',
                        'purchased_at' => $actTime,
                    ]);
                    $userPkg->created_at = $actTime;
                    $userPkg->updated_at = $actTime;
                    $userPkg->save();

                    $this->line("  Purchased Package: {$pkgModel->name} (\${$amount}) for {$user->name} on {$actTime}");

                    // 10% Direct Referral Commission
                    if ($user->sponsor_code) {
                        $sponsor = User::where('referral_code', $user->sponsor_code)->first();
                        if ($sponsor && $sponsor->status === 'active') {
                            $comm = ($amount * 10) / 100;
                            $sponsor->increment('earning_wallet', $comm);

                            $txn = Transaction::create([
                                'user_id' => $sponsor->id,
                                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                                'wallet_type' => 'earning_wallet',
                                'amount' => $comm,
                                'charge' => 0.00,
                                'post_balance' => $sponsor->fresh()->earning_wallet,
                                'trx_type' => '+',
                                'type' => 'direct_commission',
                                'description' => 'Received 10% Direct Commission of $'.number_format($comm, 2)." from {$user->name} ({$user->referral_code}) package purchase of \$".number_format($amount, 2),
                                'reference_id' => $userPkg->id,
                                'status' => 'completed',
                            ]);
                            $txn->created_at = $actTime;
                            $txn->updated_at = $actTime;
                            $txn->save();

                            $this->line("    Direct Commission: \${$comm} awarded to Sponsor {$sponsor->name} ({$sponsor->referral_code})");

                            // Check 24H Booster Bonus ($50)
                            app(BoosterBonusService::class)->evaluateBoosterBonus($sponsor);
                        }
                    }
                }
            }

            // 2. End-of-Day Daily ROI Yield & 10-Level Income Payout for this Date
            $endOfDay = Carbon::parse($dateStr.' 23:59:59');

            $activePackages = UserPackage::with(['user', 'package'])
                ->where('status', 'active')
                ->where('created_at', '<=', $endOfDay)
                ->whereHas('user', function ($query) {
                    $query->where('is_bot_active', true);
                })
                ->whereColumn('paid_roi_amount', '<', 'total_return_amount')
                ->get();

            $this->info("  Processing Daily ROI & Level Income for {$activePackages->count()} active bot package(s) on {$dateStr}...");

            foreach ($activePackages as $userPkg) {
                $user = $userPkg->user;
                $remainingCap = (float) $userPkg->total_return_amount - (float) $userPkg->paid_roi_amount;
                $dailyYield = min((float) $userPkg->daily_roi_amount, $remainingCap);

                if ($dailyYield <= 0) {
                    $userPkg->update(['status' => 'completed']);

                    continue;
                }

                // Credit Earning Wallet
                $user->increment('earning_wallet', $dailyYield);

                // Update Contract Paid ROI
                $newPaid = (float) $userPkg->paid_roi_amount + $dailyYield;
                $newStatus = ($newPaid >= (float) $userPkg->total_return_amount) ? 'completed' : 'active';

                $userPkg->update([
                    'paid_roi_amount' => $newPaid,
                    'status' => $newStatus,
                ]);

                // Create Daily ROI Transaction
                $roiTxn = Transaction::create([
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
                $roiTxn->created_at = $endOfDay;
                $roiTxn->updated_at = $endOfDay;
                $roiTxn->save();

                $this->line("    ROI Credited: \${$dailyYield} to {$user->name} ({$user->referral_code})");

                // Distribute Level Income up to 10 Levels based on this daily yield
                $this->distributeBackdatedLevelIncome($user, $dailyYield, $endOfDay);
            }
        }

        $this->info("\n===========================================================");
        $this->info(' BACKDATE USER TREE & INCOME DISTRIBUTION FINISHED 100%!  ');
        $this->info('===========================================================');

        return Command::SUCCESS;
    }

    /**
     * Distribute Level Income (10 Levels) for backdated ROI yield.
     */
    private function distributeBackdatedLevelIncome(User $downline, float $baseAmount, Carbon $timestamp): void
    {
        if ($baseAmount <= 0 || ! $downline->sponsor_code) {
            return;
        }

        $levelService = app(LevelIncomeService::class);
        $currentSponsorCode = $downline->sponsor_code;

        for ($level = 1; $level <= 10; $level++) {
            if (! $currentSponsorCode) {
                break;
            }

            $upline = User::where('referral_code', $currentSponsorCode)->first();
            if (! $upline) {
                break;
            }

            // Check if upline is active and has unlocked this level
            if ($upline->status === 'active' && $levelService->isLevelUnlocked($upline, $level)) {
                $rate = LevelIncomeService::LEVEL_RATES[$level] ?? 0.0;
                $incomeAmount = ($baseAmount * $rate) / 100;

                if ($incomeAmount > 0) {
                    $upline->increment('earning_wallet', $incomeAmount);

                    $lvlTxn = Transaction::create([
                        'user_id' => $upline->id,
                        'txn_number' => 'TXN-'.rand(10000000, 99999999),
                        'wallet_type' => 'earning_wallet',
                        'amount' => $incomeAmount,
                        'charge' => 0.00,
                        'post_balance' => $upline->fresh()->earning_wallet,
                        'trx_type' => '+',
                        'type' => 'level_income',
                        'description' => "Received Level {$level} Income ({$rate}%) of \$".number_format($incomeAmount, 2)." from downline {$downline->name} ({$downline->referral_code}) via Daily ROI Yield",
                        'reference_id' => $downline->id,
                        'status' => 'completed',
                    ]);
                    $lvlTxn->created_at = $timestamp;
                    $lvlTxn->updated_at = $timestamp;
                    $lvlTxn->save();

                    $this->line("      Level {$level} Income ({$rate}%): \${$incomeAmount} -> Upline {$upline->name} ({$upline->referral_code})");
                }
            }

            $currentSponsorCode = $upline->sponsor_code;
        }
    }
}
