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

        // 4. Direct & Downline Network Team Statistics
        $directMembersCount = User::where('sponsor_code', $user->referral_code)->count();
        $activeDirectMembersCount = User::where('sponsor_code', $user->referral_code)->where('status', 'active')->count();
        $inactiveDirectMembersCount = User::where('sponsor_code', $user->referral_code)->where('status', 'inactive')->count();

        $activeDirectMemberIds = User::where('sponsor_code', $user->referral_code)->where('status', 'active')->pluck('id');
        $activeDirectBusiness = UserPackage::whereIn('user_id', $activeDirectMemberIds)->sum('invested_amount');

        $downlineUserIds = $user->getDownlineUserIds();
        $totalTeamCount = count($downlineUserIds);
        $activeTeamCount = empty($downlineUserIds) ? 0 : User::whereIn('id', $downlineUserIds)->where('status', 'active')->count();
        $inactiveTeamCount = empty($downlineUserIds) ? 0 : User::whereIn('id', $downlineUserIds)->where('status', 'inactive')->count();

        // 5. Power Leg vs Weaker Leg Volume Statistics & Carry Forward
        $legStats = $user->leg_volume_stats;
        $powerLegVolume = (float) ($legStats['power_leg'] ?? 0.00);
        $weakerLegVolume = (float) ($legStats['remaining_leg'] ?? 0.00);
        $powerLegCarry = (float) ($legStats['power_leg_carry'] ?? 0.00);
        $weakerLegCarry = (float) ($legStats['weaker_leg_carry'] ?? 0.00);
        $matchedVolume = min($powerLegVolume, $weakerLegVolume);

        // 6. Personal Recent Collections
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
            'directMembersCount', 'activeDirectMembersCount', 'inactiveDirectMembersCount',
            'activeDirectBusiness', 'totalTeamCount', 'activeTeamCount', 'inactiveTeamCount',
            'legStats', 'powerLegVolume', 'weakerLegVolume', 'powerLegCarry', 'weakerLegCarry', 'matchedVolume',
            'activePackages', 'recentTransactions', 'recentDeposits'
        ));
    }
}
