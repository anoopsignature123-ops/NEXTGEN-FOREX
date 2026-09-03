<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display listing of all system financial transaction logs with date range & search filters.
     */
    public function index(Request $request): View
    {
        $walletType = $request->query('wallet_type');
        $trxType = $request->query('trx_type'); // + or -
        $type = $request->query('type');
        $status = $request->query('status');
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Transaction::with(['user'])->latest();

        // Wallet Type Filter
        if ($walletType && in_array($walletType, ['deposit_wallet', 'earning_wallet'])) {
            $query->where('wallet_type', $walletType);
        }

        // Credit / Debit Filter
        if ($trxType && in_array($trxType, ['+', '-'])) {
            $query->where('trx_type', $trxType);
        }

        // Transaction Type Filter
        if ($type) {
            $query->where('type', $type);
        }

        // Status Filter
        if ($status) {
            $query->where('status', $status);
        }

        // Date Range Filter
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Search Filter (User Name, Email, Code, Txn Number, Description)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('txn_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('referral_code', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->paginate(15)->withQueryString();

        // Calculate Summary Totals for Header Cards
        $totalCredits = (float) Transaction::where('trx_type', '+')->where('status', 'completed')->sum('amount');
        $totalDebits = (float) Transaction::where('trx_type', '-')->where('status', 'completed')->sum('amount');
        $totalTransactionsCount = Transaction::count();

        return view('admin.transactions.index', compact(
            'transactions',
            'totalCredits',
            'totalDebits',
            'totalTransactionsCount'
        ));
    }
}
