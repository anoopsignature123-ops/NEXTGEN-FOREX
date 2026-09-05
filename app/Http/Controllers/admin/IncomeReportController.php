<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomeReportController extends Controller
{
    /**
     * Common helper to filter transactions by type and request filters.
     */
    private function getIncomeReport(Request $request, string $type)
    {
        $query = Transaction::with(['user', 'user.sponsor', 'userPackage.user'])->where('type', $type);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('txn_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('referral_code', 'like', "%{$search}%")
                            ->orWhereHas('sponsor', function ($sq) use ($search) {
                                $sq->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('referral_code', 'like', "%{$search}%");
                            });
                    });
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
     * Master Income Summary Report across all 7 income types.
     */
    public function summary(Request $request): View
    {
        $roiTotal = Transaction::where('type', 'daily_roi')->sum('amount');
        $directTotal = Transaction::where('type', 'direct_commission')->sum('amount');
        $bonusTotal = Transaction::where('type', '24h_bonus')->sum('amount');
        $matchingTotal = Transaction::where('type', 'matching_income')->sum('amount');
        $directSalaryTotal = Transaction::where('type', 'direct_salary')->sum('amount');
        $teamSalaryTotal = Transaction::where('type', 'team_salary')->sum('amount');
        $rewardTotal = Transaction::where('type', 'reward_income')->sum('amount');

        $grandTotal = $roiTotal + $directTotal + $bonusTotal + $matchingTotal + $directSalaryTotal + $teamSalaryTotal + $rewardTotal;

        $recentIncomes = Transaction::with(['user', 'user.sponsor', 'userPackage.user'])
            ->whereIn('type', ['daily_roi', 'direct_commission', '24h_bonus', 'matching_income', 'direct_salary', 'team_salary', 'reward_income'])
            ->latest('id')
            ->paginate(15);

        return view('admin.reports.summary', compact(
            'roiTotal', 'directTotal', 'bonusTotal', 'matchingTotal',
            'directSalaryTotal', 'teamSalaryTotal', 'rewardTotal', 'grandTotal', 'recentIncomes'
        ));
    }

    public function roi(Request $request): View
    {
        $data = $this->getIncomeReport($request, 'daily_roi');

        return view('admin.reports.roi', $data);
    }

    public function direct(Request $request): View
    {
        $data = $this->getIncomeReport($request, 'direct_commission');

        return view('admin.reports.direct', $data);
    }

    public function bonus(Request $request): View
    {
        $data = $this->getIncomeReport($request, '24h_bonus');

        return view('admin.reports.bonus', $data);
    }

    public function matching(Request $request): View
    {
        $data = $this->getIncomeReport($request, 'matching_income');

        return view('admin.reports.matching', $data);
    }

    public function directSalary(Request $request): View
    {
        $data = $this->getIncomeReport($request, 'direct_salary');

        return view('admin.reports.direct_salary', $data);
    }

    public function teamSalary(Request $request): View
    {
        $data = $this->getIncomeReport($request, 'team_salary');

        return view('admin.reports.team_salary', $data);
    }

    public function reward(Request $request): View
    {
        $data = $this->getIncomeReport($request, 'reward_income');

        return view('admin.reports.reward', $data);
    }
}
