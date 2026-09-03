<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IncomeReportController extends Controller
{
    /**
     * Common helper for authenticated user income reports.
     */
    private function getUserIncomeReport(Request $request, string $type)
    {
        $userId = Auth::id();
        $query = Transaction::where('user_id', $userId)->where('type', $type);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('txn_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = (clone $query)->latest('id')->paginate(15)->withQueryString();
        $totalAmount = (clone $query)->sum('amount');
        $totalCount = (clone $query)->count();

        return compact('logs', 'totalAmount', 'totalCount');
    }

    /**
     * Master Income Summary Report across all 7 income types for authenticated user.
     */
    public function summary(Request $request): View
    {
        $userId = Auth::id();
        $roiTotal = Transaction::where('user_id', $userId)->where('type', 'daily_roi')->sum('amount');
        $directTotal = Transaction::where('user_id', $userId)->where('type', 'direct_commission')->sum('amount');
        $bonusTotal = Transaction::where('user_id', $userId)->where('type', '24h_bonus')->sum('amount');
        $matchingTotal = Transaction::where('user_id', $userId)->where('type', 'matching_income')->sum('amount');
        $directSalaryTotal = Transaction::where('user_id', $userId)->where('type', 'direct_salary')->sum('amount');
        $teamSalaryTotal = Transaction::where('user_id', $userId)->where('type', 'team_salary')->sum('amount');
        $rewardTotal = Transaction::where('user_id', $userId)->where('type', 'reward_income')->sum('amount');

        $grandTotal = $roiTotal + $directTotal + $bonusTotal + $matchingTotal + $directSalaryTotal + $teamSalaryTotal + $rewardTotal;

        $recentIncomes = Transaction::where('user_id', $userId)
            ->whereIn('type', ['daily_roi', 'direct_commission', '24h_bonus', 'matching_income', 'direct_salary', 'team_salary', 'reward_income'])
            ->latest('id')
            ->paginate(15);

        return view('user.reports.summary', compact(
            'roiTotal', 'directTotal', 'bonusTotal', 'matchingTotal',
            'directSalaryTotal', 'teamSalaryTotal', 'rewardTotal', 'grandTotal', 'recentIncomes'
        ));
    }

    public function roi(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, 'daily_roi');

        return view('user.reports.roi', $data);
    }

    public function direct(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, 'direct_commission');

        return view('user.reports.direct', $data);
    }

    public function bonus(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, '24h_bonus');

        return view('user.reports.bonus', $data);
    }

    public function matching(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, 'matching_income');

        return view('user.reports.matching', $data);
    }

    public function directSalary(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, 'direct_salary');

        return view('user.reports.direct_salary', $data);
    }

    public function teamSalary(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, 'team_salary');

        return view('user.reports.team_salary', $data);
    }

    public function reward(Request $request): View
    {
        $data = $this->getUserIncomeReport($request, 'reward_income');

        return view('user.reports.reward', $data);
    }
}
