<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        // 1. Personal Investment Capital Statistics
        $totalInvested = UserPackage::where('user_id', $user->id)->sum('invested_amount');
        $activeInvestmentsCount = UserPackage::where('user_id', $user->id)->where('status', 'active')->count();

        // 2. Personal Income Summaries (Across all 7 Income Categories)
        $totalRoiEarned = Transaction::where('user_id', $user->id)->where('type', 'daily_roi')->sum('amount');
        $totalDirectEarned = Transaction::where('user_id', $user->id)->where('type', 'direct_commission')->sum('amount');
        $totalBonusEarned = Transaction::where('user_id', $user->id)->where('type', '24h_bonus')->sum('amount');
        $totalMatchingEarned = Transaction::where('user_id', $user->id)->where('type', 'matching_income')->sum('amount');
        $totalSalaryEarned = Transaction::where('user_id', $user->id)->whereIn('type', ['direct_salary', 'team_salary'])->sum('amount');
        $totalRewardsEarned = Transaction::where('user_id', $user->id)->where('type', 'reward_income')->sum('amount');

        $totalIncomeEarned = $totalRoiEarned + $totalDirectEarned + $totalBonusEarned + $totalMatchingEarned + $totalSalaryEarned + $totalRewardsEarned;

        // 3. Withdrawal Wallet Statistics
        $totalWithdrawn = Withdrawal::where('user_id', $user->id)->whereIn('status', ['approved', 'completed'])->sum('net_amount');

        // 4. Direct Network Team Statistics
        $directMembersCount = User::where('sponsor_code', $user->referral_code)->count();
        $activeDirectMembersCount = User::where('sponsor_code', $user->referral_code)->where('status', 'active')->count();

        // 5. Personal Recent Collections
        $activePackages = UserPackage::with('package')->where('user_id', $user->id)->latest()->take(5)->get();
        $recentTransactions = Transaction::where('user_id', $user->id)->latest()->take(5)->get();
        $recentDeposits = Deposit::where('user_id', $user->id)->latest()->take(5)->get();

        return view('user.dashboard', compact(
            'user',
            'totalInvested', 'activeInvestmentsCount',
            'totalRoiEarned', 'totalDirectEarned', 'totalBonusEarned',
            'totalMatchingEarned', 'totalSalaryEarned', 'totalRewardsEarned',
            'totalIncomeEarned', 'totalWithdrawn',
            'directMembersCount', 'activeDirectMembersCount',
            'activePackages', 'recentTransactions', 'recentDeposits'
        ));
    }
}
