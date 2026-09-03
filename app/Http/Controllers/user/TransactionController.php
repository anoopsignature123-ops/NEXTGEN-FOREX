<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display detailed financial transactions history log.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $walletType = $request->query('wallet_type');
        $type = $request->query('type');
        $search = $request->query('search');

        $query = Transaction::where('user_id', $user->id)->latest();

        if ($walletType && in_array($walletType, ['deposit_wallet', 'earning_wallet'])) {
            $query->where('wallet_type', $walletType);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('txn_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $transactions = $query->paginate(15)->withQueryString();

        return view('user.transactions.index', compact('user', 'transactions'));
    }
}
