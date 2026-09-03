<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\UserPackage;
use App\Services\Incomes\DirectIncomeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display Available NextGen Forex Packages for Purchase.
     */
    public function index(): View
    {
        $user = Auth::user();
        $packages = Package::where('status', 'active')->orderBy('id', 'asc')->get();

        return view('user.packages.index', compact('user', 'packages'));
    }

    /**
     * Buy / Invest in a Package using Deposit Wallet balance.
     */
    public function buy(Request $request): RedirectResponse
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'invested_amount' => 'required|numeric|min:1',
        ]);

        $package = Package::findOrFail($request->package_id);
        $investedAmount = (float) $request->invested_amount;
        $user = Auth::user();

        // 1. Check if package is active
        if ($package->status !== 'active') {
            return redirect()->back()->with('error', 'This package is currently disabled.');
        }

        // 2. Check min / max limits for the selected package
        if ($investedAmount < $package->min_amount || $investedAmount > $package->max_amount) {
            return redirect()->back()->with('error', "Investment amount must be between \${$package->min_amount} and \${$package->max_amount} for {$package->name}.");
        }

        // 3. Check Deposit Wallet Balance
        if ((float) $user->deposit_wallet < $investedAmount) {
            return redirect()->route('user.deposits.index')->with('error', "Insufficient Deposit Wallet Balance (\${$user->deposit_wallet}). Please add funds first to purchase {$package->name}!");
        }

        // 4. Perform Transaction: Deduct Deposit Wallet, Create UserPackage, Activate User Account
        DB::transaction(function () use ($user, $package, $investedAmount) {
            // Deduct Deposit Wallet
            $user->decrement('deposit_wallet', $investedAmount);

            // Activate User and set activated_at timestamp if not set
            $user->update([
                'status' => 'active',
                'activated_at' => $user->activated_at ?? now(),
            ]);

            // Calculate ROI amounts
            $dailyRoiAmount = ($investedAmount * $package->daily_roi) / 100;
            $totalReturnAmount = $investedAmount * $package->total_return_multiplier; // 2X

            $userPackage = UserPackage::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'invested_amount' => $investedAmount,
                'daily_roi' => $package->daily_roi,
                'daily_roi_amount' => $dailyRoiAmount,
                'duration_days' => $package->duration_days,
                'total_return_amount' => $totalReturnAmount,
                'paid_roi_amount' => 0.00,
                'status' => 'active',
                'purchased_at' => now(),
                'expires_at' => now()->addDays($package->duration_days),
            ]);

            // Log detailed financial transaction for package purchase
            Transaction::create([
                'user_id' => $user->id,
                'txn_number' => 'TXN-'.rand(10000000, 99999999),
                'wallet_type' => 'deposit_wallet',
                'amount' => $investedAmount,
                'charge' => 0.00,
                'post_balance' => $user->fresh()->deposit_wallet,
                'trx_type' => '-',
                'type' => 'package_purchase',
                'description' => "Purchased {$package->name} for \$".number_format($investedAmount, 2).' via Deposit Wallet',
                'reference_id' => $userPackage->id,
                'status' => 'completed',
            ]);

            // Delegate 10% Direct Referral Commission to Dedicated DirectIncomeService (PDF Page 15)
            app(DirectIncomeService::class)->distributeDirectCommission($user, $userPackage, $investedAmount);
        });

        return redirect()->route('user.packages.history')->with('success', "Congratulations! You have successfully purchased {$package->name} for \$".number_format($investedAmount, 2).'! Account is active.');
    }

    /**
     * View User's Purchased Packages History.
     */
    public function history(): View
    {
        $user = Auth::user();
        $userPackages = UserPackage::with('package')->where('user_id', $user->id)->latest()->paginate(10);

        return view('user.packages.history', compact('user', 'userPackages'));
    }
}
