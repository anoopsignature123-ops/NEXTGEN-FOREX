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

        $today = now()->startOfDay();

        // 1. Personal Investment Capital Statistics
        $totalInvested = UserPackage::where('user_id', $user->id)->sum('invested_amount');
        $activeInvestmentsCount = UserPackage::where('user_id', $user->id)->where('status', 'active')->count();

        // Team business volume
        $directMemberIds = User::where('sponsor_code', $user->referral_code)->pluck('id');
        $totalTeamBusiness = UserPackage::whereIn('user_id', $directMemberIds)->sum('invested_amount');

        // 2. Personal Income Summaries (Across all 8 Income Categories)
        $totalRoiEarned = Transaction::where('user_id', $user->id)->where('type', 'daily_roi')->sum('amount');
        $todayRoiEarned = Transaction::where('user_id', $user->id)->where('type', 'daily_roi')->where('created_at', '>=', $today)->sum('amount');

        $totalDirectEarned = Transaction::where('user_id', $user->id)->where('type', 'direct_commission')->sum('amount');
        $todayDirectEarned = Transaction::where('user_id', $user->id)->where('type', 'direct_commission')->where('created_at', '>=', $today)->sum('amount');

        $totalBonusEarned = Transaction::where('user_id', $user->id)->where('type', '24h_bonus')->sum('amount');
        $todayBonusEarned = Transaction::where('user_id', $user->id)->where('type', '24h_bonus')->where('created_at', '>=', $today)->sum('amount');

        $totalLevelEarned = Transaction::where('user_id', $user->id)->where('type', 'level_income')->sum('amount');
        $todayLevelEarned = Transaction::where('user_id', $user->id)->where('type', 'level_income')->where('created_at', '>=', $today)->sum('amount');

        $totalMatchingEarned = Transaction::where('user_id', $user->id)->where('type', 'matching_income')->sum('amount');
        $todayMatchingEarned = Transaction::where('user_id', $user->id)->where('type', 'matching_income')->where('created_at', '>=', $today)->sum('amount');

        $totalDirectSalaryEarned = Transaction::where('user_id', $user->id)->where('type', 'direct_salary')->sum('amount');
        $todayDirectSalaryEarned = Transaction::where('user_id', $user->id)->where('type', 'direct_salary')->where('created_at', '>=', $today)->sum('amount');

        $totalTeamSalaryEarned = Transaction::where('user_id', $user->id)->where('type', 'team_salary')->sum('amount');
        $todayTeamSalaryEarned = Transaction::where('user_id', $user->id)->where('type', 'team_salary')->where('created_at', '>=', $today)->sum('amount');

        $totalSalaryEarned = $totalDirectSalaryEarned + $totalTeamSalaryEarned;

        $totalRewardsEarned = Transaction::where('user_id', $user->id)->where('type', 'reward_income')->sum('amount');
        $todayRewardsEarned = Transaction::where('user_id', $user->id)->where('type', 'reward_income')->where('created_at', '>=', $today)->sum('amount');

        $totalIncomeEarned = $totalRoiEarned + $totalDirectEarned + $totalBonusEarned + $totalLevelEarned + $totalMatchingEarned + $totalSalaryEarned + $totalRewardsEarned;

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
            'totalInvested', 'activeInvestmentsCount', 'totalTeamBusiness',
            'totalRoiEarned', 'todayRoiEarned',
            'totalDirectEarned', 'todayDirectEarned',
            'totalBonusEarned', 'todayBonusEarned',
            'totalLevelEarned', 'todayLevelEarned',
            'totalMatchingEarned', 'todayMatchingEarned',
            'totalDirectSalaryEarned', 'todayDirectSalaryEarned',
            'totalTeamSalaryEarned', 'todayTeamSalaryEarned',
            'totalSalaryEarned',
            'totalRewardsEarned', 'todayRewardsEarned',
            'totalIncomeEarned', 'totalWithdrawn',
            'directMembersCount', 'activeDirectMembersCount',
            'activePackages', 'recentTransactions', 'recentDeposits'
        ));
    }
}
