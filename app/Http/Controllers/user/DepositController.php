<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepositController extends Controller
{
    /**
     * Display Add Fund / Deposit page for User.
     */
    public function index(): View
    {
        $user = Auth::user();
        $deposits = Deposit::where('user_id', $user->id)->latest()->paginate(10);

        // System USDT BEP20 Official Deposit Wallet Address
        $usdtWalletAddress = config('app.usdt_wallet', '0x71C7656EC7ab88b098defB751B7401B5f6d8976F');

        return view('user.deposits.index', compact('user', 'deposits', 'usdtWalletAddress'));
    }

    /**
     * Store new Deposit Request from User.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10', // Min deposit $10 as per Terms (Slide 20)
            'payment_gateway' => 'required|string',
            'txn_hash' => 'required|string|max:255',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('deposits', 'public');
        }

        $user = Auth::user();

        DB::transaction(function () use ($user, $validated, $proofPath) {
            // 1. Create Deposit Record with INSTANT APPROVED status (No Admin Approval Required)
            $deposit = Deposit::create([
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'payment_gateway' => $validated['payment_gateway'],
                'txn_hash' => $validated['txn_hash'],
                'proof_image' => $proofPath,
                'status' => 'approved',
            ]);

            // 2. Increment User Deposit Wallet INSTANTLY
            $user->increment('deposit_wallet', $validated['amount']);

            // 3. Create Financial Audit Transaction Record
            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'deposit_wallet',
                'amount' => $validated['amount'],
                'charge' => 0.00,
                'post_balance' => $user->fresh()->deposit_wallet,
                'trx_type' => '+',
                'type' => 'deposit',
                'description' => 'Deposit of $'.number_format($validated['amount'], 2)." via {$validated['payment_gateway']} (Ref: {$deposit->deposit_ref})",
                'reference_id' => $deposit->id,
                'status' => 'completed',
            ]);
        });

        return redirect()->route('user.deposits.history')->with('success', 'Congratulations! $'.number_format($validated['amount'], 2).' has been instantly credited to your Deposit Wallet!');
    }

    /**
     * Display dedicated My Deposit History page with date range & status filters.
     */
    public function history(Request $request): View
    {
        $user = Auth::user();
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $search = $request->query('search');

        $query = Deposit::with(['user', 'transaction'])->where('user_id', $user->id);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($search) {
            $query->where('txn_hash', 'like', "%{$search}%");
        }

        $deposits = $query->latest()->paginate(15)->withQueryString();

        return view('user.deposits.history', compact('user', 'deposits'));
    }
}
