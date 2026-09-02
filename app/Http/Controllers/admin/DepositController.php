<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepositController extends Controller
{
    /**
     * Display listing of all deposit requests with status filters.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Deposit::with('user')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('referral_code', 'like', "%{$search}%");
            })->orWhere('txn_hash', 'like', "%{$search}%");
        }

        $deposits = $query->paginate(15)->withQueryString();

        return view('admin.deposits.index', compact('deposits'));
    }

    /**
     * Approve deposit request and credit user's deposit_wallet.
     */
    public function approve(Request $request, Deposit $deposit): RedirectResponse
    {
        if ($deposit->status !== 'pending') {
            return redirect()->back()->with('error', 'This deposit request has already been processed.');
        }

        DB::transaction(function () use ($deposit, $request) {
            $deposit->update([
                'status' => 'approved',
                'approved_at' => now(),
                'admin_notes' => $request->input('admin_notes', 'Approved by Admin'),
            ]);

            // Credit User's Deposit Wallet
            $user = $deposit->user;
            $user->increment('deposit_wallet', $deposit->amount);
        });

        return redirect()->back()->with('success', "Deposit of \${$deposit->amount} approved and credited to user's Deposit Wallet.");
    }

    /**
     * Reject deposit request.
     */
    public function reject(Request $request, Deposit $deposit): RedirectResponse
    {
        if ($deposit->status !== 'pending') {
            return redirect()->back()->with('error', 'This deposit request has already been processed.');
        }

        $deposit->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes', 'Rejected by Admin'),
        ]);

        return redirect()->back()->with('success', 'Deposit request has been rejected.');
    }
}
