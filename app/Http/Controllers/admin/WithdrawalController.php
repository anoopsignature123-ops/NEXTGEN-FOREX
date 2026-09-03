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
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('referral_code', 'like', "%{$search}%");
                    });
            });
        }

        $withdrawals = (clone $query)->latest('id')->paginate(15)->withQueryString();

        $pendingCount = Withdrawal::where('status', 'pending')->count();
        $approvedSum = Withdrawal::where('status', 'approved')->sum('net_amount');
        $totalDeductionsSum = Withdrawal::where('status', 'approved')->sum('charge');

        return view('admin.withdrawals.index', compact('withdrawals', 'pendingCount', 'approvedSum', 'totalDeductionsSum'));
    }

    /**
     * Approve a pending withdrawal request.
     */
    public function approve(Request $request, Withdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This withdrawal request has already been processed.');
        }

        DB::transaction(function () use ($withdrawal, $request) {
            $withdrawal->update([
                'status' => 'approved',
                'admin_remark' => $request->input('admin_remark') ?: 'Approved and transferred to USDT BEP20 wallet.',
            ]);

            // Update corresponding transaction status
            Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'completed']);
        });

        return redirect()->back()->with('success', "Withdrawal request {$withdrawal->trx_number} approved successfully! Net amount \${$withdrawal->net_amount} transferred.");
    }

    /**
     * Reject a pending withdrawal request and refund amount back to user's Earning Wallet.
     */
    public function reject(Request $request, Withdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This withdrawal request has already been processed.');
        }

        $remark = $request->input('admin_remark') ?: 'Rejected by Admin. Refunded to Earning Wallet.';

        DB::transaction(function () use ($withdrawal, $remark) {
            $withdrawal->update([
                'status' => 'rejected',
                'admin_remark' => $remark,
            ]);

            // Refund requested amount back to User Earning Wallet
            $user = $withdrawal->user;
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

            // Update original request transaction status
            Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'rejected']);
        });

        return redirect()->back()->with('success', "Withdrawal request {$withdrawal->trx_number} rejected. \${$withdrawal->amount} refunded back to member's Earning Wallet.");
    }

    /**
     * Bulk Approve multiple selected pending withdrawal requests.
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
        $totalApproved = 0.00;

        DB::transaction(function () use ($pendingWithdrawals, &$count, &$totalApproved) {
            foreach ($pendingWithdrawals as $withdrawal) {
                $withdrawal->update([
                    'status' => 'approved',
                    'admin_remark' => 'Bulk approved by Admin.',
                ]);

                Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'completed']);
                $count++;
                $totalApproved += (float) $withdrawal->net_amount;
            }
        });

        return redirect()->back()->with('success', "Successfully bulk approved {$count} withdrawal requests! Total net payouts processed: \$".number_format($totalApproved, 2));
    }

    /**
     * Bulk Reject multiple selected pending withdrawal requests and refund back to members' Earning Wallets.
     */
    public function bulkReject(Request $request): RedirectResponse
    {
        $request->validate([
            'withdrawal_ids' => 'required|array|min:1',
            'withdrawal_ids.*' => 'exists:withdrawals,id',
        ]);

        $ids = $request->withdrawal_ids;
        $pendingWithdrawals = Withdrawal::whereIn('id', $ids)->where('status', 'pending')->get();

        if ($pendingWithdrawals->isEmpty()) {
            return redirect()->back()->with('error', 'No pending withdrawal requests selected for bulk rejection.');
        }

        $count = 0;

        DB::transaction(function () use ($pendingWithdrawals, &$count) {
            foreach ($pendingWithdrawals as $withdrawal) {
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

                Transaction::where('txn_number', $withdrawal->trx_number)->update(['status' => 'rejected']);
                $count++;
            }
        });

        return redirect()->back()->with('success', "Successfully bulk rejected {$count} withdrawal requests. All requested amounts have been refunded back to members' Earning Wallets.");
    }
}
