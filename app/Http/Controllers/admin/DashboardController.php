<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // 1. Member Management Statistics
        $totalMembers = User::count();
        $activeMembers = User::where('status', 'active')->count();
        $pendingMembers = User::where('status', 'pending')->count();

        // 2. Wallet & Balance Summaries
        $totalDepositWalletSum = User::sum('deposit_wallet');
        $totalEarningWalletSum = User::sum('earning_wallet');

        // 3. Deposit Request Statistics
        $totalApprovedDepositsSum = Deposit::where('status', 'approved')->sum('amount');
        $pendingDepositsCount = Deposit::where('status', 'pending')->count();

        // 4. Investment & Capital Statistics
        $totalPackagesPurchasedCount = UserPackage::count();
        $activePackagesCount = UserPackage::where('status', 'active')->count();
        $totalCapitalInvestedSum = UserPackage::sum('invested_amount');

        // 5. Income Payout Summaries (Across all 7 Income Streams)
        $totalRoiPaidSum = Transaction::where('type', 'daily_roi')->sum('amount');
        $totalDirectCommissionPaidSum = Transaction::where('type', 'direct_commission')->sum('amount');
        $totalBoosterBonusPaidSum = Transaction::where('type', '24h_bonus')->sum('amount');
        $totalMatchingPaidSum = Transaction::where('type', 'matching_income')->sum('amount');
        $totalDirectSalaryPaidSum = Transaction::where('type', 'direct_salary')->sum('amount');
        $totalTeamSalaryPaidSum = Transaction::where('type', 'team_salary')->sum('amount');
        $totalRewardPaidSum = Transaction::where('type', 'reward_income')->sum('amount');

        $totalIncomeDistributedSum = $totalRoiPaidSum + $totalDirectCommissionPaidSum + $totalBoosterBonusPaidSum
            + $totalMatchingPaidSum + $totalDirectSalaryPaidSum + $totalTeamSalaryPaidSum + $totalRewardPaidSum;

        // 6. Recent Live Activity Collections
        $recentUsers = User::latest()->take(5)->get();
        $recentDeposits = Deposit::with('user')->latest()->take(5)->get();
        $recentInvestments = UserPackage::with(['user', 'package'])->latest()->take(5)->get();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMembers', 'activeMembers', 'pendingMembers',
            'totalDepositWalletSum', 'totalEarningWalletSum',
            'totalApprovedDepositsSum', 'pendingDepositsCount',
            'totalPackagesPurchasedCount', 'activePackagesCount', 'totalCapitalInvestedSum',
            'totalRoiPaidSum', 'totalDirectCommissionPaidSum', 'totalBoosterBonusPaidSum',
            'totalMatchingPaidSum', 'totalDirectSalaryPaidSum', 'totalTeamSalaryPaidSum', 'totalRewardPaidSum',
            'totalIncomeDistributedSum',
            'recentUsers', 'recentDeposits', 'recentInvestments', 'recentTransactions'
        ));
    }
}
