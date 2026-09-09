<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    /**
     * Display listing of all withdrawal requests for Admin audit.
     */
    public function index(Request $request): View
    {
        $query = Withdrawal::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('trx_number', 'like', "%{$search}%")
                    ->orWhere('usdt_address', 'like', "%{$search}%")
                    ->orWhere('txn_hash', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('referral_code', 'like', "%{$search}%");
                    });
            });
        }

        $withdrawals = (clone $query)->latest('id')->paginate(15)->withQueryString();

        $pendingCount = Withdrawal::where('status', 'pending')->count();
        $approvedCount = Withdrawal::where('status', 'approved')->count();
        $completedCount = Withdrawal::where('status', 'completed')->count();
        $rejectedCount = Withdrawal::where('status', 'rejected')->count();

        $approvedSum = Withdrawal::whereIn('status', ['approved', 'completed'])->sum('net_amount');
        $totalDeductionsSum = Withdrawal::whereIn('status', ['approved', 'completed'])->sum('charge');

        return view('admin.withdrawals.index', compact(
            'withdrawals',
            'pendingCount',
            'approvedCount',
            'completedCount',
            'rejectedCount',
            'approvedSum',
            'totalDeductionsSum'
        ));
    }

    /**
     * Step 1 -> Step 2: Approve a pending withdrawal request (Pending -> Approved).
     */
    public function approve(Request $request, Withdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This withdrawal request has already been processed beyond pending status.');
        }

        DB::transaction(function () use ($withdrawal, $request) {
            $withdrawal->update([
                'status' => 'approved',
                'admin_remark' => $request->input('admin_remark') ?: 'Approved by Admin. Pending Crypto Payout Completion.',
            ]);

            // Transaction status remains pending until payout is marked completed
            Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'pending']);
        });

        return redirect()->back()->with('success', "Withdrawal request {$withdrawal->trx_number} approved successfully! Moved to Approved status.");
    }

    /**
     * Step 2 -> Step 3: Mark an approved or pending withdrawal request as Completed (Approved -> Completed).
     */
    public function complete(Request $request, Withdrawal $withdrawal): RedirectResponse
    {
        if (! in_array($withdrawal->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Only Pending or Approved withdrawal requests can be marked as Completed.');
        }

        $txnHash = trim($request->input('txn_hash', ''));
        $remark = $request->input('admin_remark') ?: 'Payout transferred to USDT BEP20 wallet and marked Completed.';

        DB::transaction(function () use ($withdrawal, $txnHash, $remark) {
            $withdrawal->update([
                'status' => 'completed',
                'txn_hash' => $txnHash ?: $withdrawal->txn_hash,
                'admin_remark' => $remark,
            ]);

            // Update corresponding transaction status to completed
            Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'completed']);
        });

        return redirect()->back()->with('success', "Withdrawal request {$withdrawal->trx_number} marked as Completed! Net amount \${$withdrawal->net_amount} transferred.");
    }

    /**
     * Reject a pending or approved withdrawal request and refund amount back to user's Earning Wallet.
     */
    public function reject(Request $request, Withdrawal $withdrawal): RedirectResponse
    {
        if (! in_array($withdrawal->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Only Pending or Approved withdrawal requests can be rejected.');
        }

        $remark = $request->input('admin_remark') ?: 'Rejected by Admin. Refunded to Earning Wallet.';

        DB::transaction(function () use ($withdrawal, $remark) {
            $withdrawal->update([
                'status' => 'rejected',
                'admin_remark' => $remark,
            ]);

            // Refund requested amount back to User Earning Wallet
            $user = $withdrawal->user;
            if ($user) {
                $user->increment('earning_wallet', $withdrawal->amount);

                // Create refund transaction log
                Transaction::create([
                    'user_id' => $user->id,
                    'txn_number' => 'RFD-'.rand(10000000, 99999999),
                    'wallet_type' => 'earning_wallet',
                    'amount' => $withdrawal->amount,
                    'charge' => 0.00,
                    'post_balance' => $user->fresh()->earning_wallet,
                    'trx_type' => '+',
                    'type' => 'withdrawal_refund',
                    'description' => "Refunded \${$withdrawal->amount} from Rejected Withdrawal ({$withdrawal->trx_number}). Reason: {$remark}",
                    'reference_id' => $withdrawal->id,
                    'status' => 'completed',
                ]);
            }

            // Update original request transaction status
            Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'cancelled']);
        });

        return redirect()->back()->with('success', "Withdrawal request {$withdrawal->trx_number} rejected. \${$withdrawal->amount} refunded back to member's Earning Wallet.");
    }

    /**
     * Bulk Approve selected pending withdrawal requests (Pending -> Approved).
     */
    public function bulkApprove(Request $request): RedirectResponse
    {
        $request->validate([
            'withdrawal_ids' => 'required|array|min:1',
            'withdrawal_ids.*' => 'exists:withdrawals,id',
        ]);

        $ids = $request->withdrawal_ids;
        $pendingWithdrawals = Withdrawal::whereIn('id', $ids)->where('status', 'pending')->get();

        if ($pendingWithdrawals->isEmpty()) {
            return redirect()->back()->with('error', 'No pending withdrawal requests selected for bulk approval.');
        }

        $count = 0;

        DB::transaction(function () use ($pendingWithdrawals, &$count) {
            foreach ($pendingWithdrawals as $withdrawal) {
                $withdrawal->update([
                    'status' => 'approved',
                    'admin_remark' => 'Bulk approved by Admin.',
                ]);

                Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'pending']);
                $count++;
            }
        });

        return redirect()->back()->with('success', "Successfully bulk approved {$count} withdrawal requests! Moved to Approved status.");
    }

    /**
     * Bulk Complete selected approved/pending withdrawal requests (Approved -> Completed).
     */
    public function bulkComplete(Request $request): RedirectResponse
    {
        $request->validate([
            'withdrawal_ids' => 'required|array|min:1',
            'withdrawal_ids.*' => 'exists:withdrawals,id',
        ]);

        $ids = $request->withdrawal_ids;
        $eligibleWithdrawals = Withdrawal::whereIn('id', $ids)->whereIn('status', ['pending', 'approved'])->get();

        if ($eligibleWithdrawals->isEmpty()) {
            return redirect()->back()->with('error', 'No pending or approved withdrawal requests selected for bulk completion.');
        }

        $count = 0;
        $totalCompleted = 0.00;

        DB::transaction(function () use ($eligibleWithdrawals, &$count, &$totalCompleted) {
            foreach ($eligibleWithdrawals as $withdrawal) {
                $withdrawal->update([
                    'status' => 'completed',
                    'admin_remark' => 'Bulk completed by Admin.',
                ]);

                Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'completed']);
                $count++;
                $totalCompleted += (float) $withdrawal->net_amount;
            }
        });

        return redirect()->back()->with('success', "Successfully bulk completed {$count} withdrawal requests! Total net payouts completed: \$".number_format($totalCompleted, 2));
    }

    /**
     * Bulk Reject selected withdrawal requests and refund back to members' Earning Wallets.
     */
    public function bulkReject(Request $request): RedirectResponse
    {
        $request->validate([
            'withdrawal_ids' => 'required|array|min:1',
            'withdrawal_ids.*' => 'exists:withdrawals,id',
        ]);

        $ids = $request->withdrawal_ids;
        $eligibleWithdrawals = Withdrawal::whereIn('id', $ids)->whereIn('status', ['pending', 'approved'])->get();

        if ($eligibleWithdrawals->isEmpty()) {
            return redirect()->back()->with('error', 'No pending or approved withdrawal requests selected for bulk rejection.');
        }

        $count = 0;

        DB::transaction(function () use ($eligibleWithdrawals, &$count) {
            foreach ($eligibleWithdrawals as $withdrawal) {
                $withdrawal->update([
                    'status' => 'rejected',
                    'admin_remark' => 'Bulk rejected by Admin. Refunded to Earning Wallet.',
                ]);

                $user = $withdrawal->user;
                if ($user) {
                    $user->increment('earning_wallet', $withdrawal->amount);

                    Transaction::create([
                        'user_id' => $user->id,
                        'txn_number' => 'RFD-'.rand(10000000, 99999999),
                        'wallet_type' => 'earning_wallet',
                        'amount' => $withdrawal->amount,
                        'charge' => 0.00,
                        'post_balance' => $user->fresh()->earning_wallet,
                        'trx_type' => '+',
                        'type' => 'withdrawal_refund',
                        'description' => "Bulk Refunded \${$withdrawal->amount} from Rejected Withdrawal ({$withdrawal->trx_number})",
                        'reference_id' => $withdrawal->id,
                        'status' => 'completed',
                    ]);
                }

                Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'cancelled']);
                $count++;
            }
        });

        return redirect()->back()->with('success', "Successfully bulk rejected {$count} withdrawal requests. All requested amounts have been refunded back to members' Earning Wallets.");
    }
}
