<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $validated['amount'],
            'payment_gateway' => $validated['payment_gateway'],
            'txn_hash' => $validated['txn_hash'],
            'proof_image' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('user.deposits.history')->with('success', 'Your deposit request of $'.number_format($validated['amount'], 2).' has been submitted successfully! Admin will review and credit your wallet shortly.');
    }

    /**
     * Display dedicated My Deposit History page.
     */
    public function history(Request $request): View
    {
        $user = Auth::user();
        $status = $request->query('status');

        $query = Deposit::where('user_id', $user->id);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $deposits = $query->latest()->paginate(15);

        return view('user.deposits.history', compact('user', 'deposits'));
    }
}
