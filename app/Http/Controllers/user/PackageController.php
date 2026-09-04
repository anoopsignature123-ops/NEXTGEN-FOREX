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

        // Get user's active non-expired packages grouped/keyed by package_id with total sum & count
        $userActivePackages = UserPackage::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->selectRaw('package_id, SUM(invested_amount) as total_invested, COUNT(id) as active_count, MAX(expires_at) as max_expires_at')
            ->groupBy('package_id')
            ->get()
            ->keyBy('package_id');

        return view('user.packages.index', compact('user', 'packages', 'userActivePackages'));
    }

    /**
     * Buy / Invest in a Package using Deposit Wallet balance.
     */
    public function buy(Request $request): RedirectResponse
    {
        $request->validate([
            'invested_amount' => 'required|numeric|min:10',
        ]);

        $investedAmount = (float) $request->invested_amount;
        $user = Auth::user();

        // 1. Auto-detect matching active package tier based on invested amount range
        $package = Package::where('status', 'active')
            ->where('min_amount', '<=', $investedAmount)
            ->where(function ($q) use ($investedAmount) {
                $q->where('max_amount', '>=', $investedAmount)
                    ->orWhere('max_amount', '>=', 999999);
            })
            ->first();

        if (! $package && $request->filled('package_id')) {
            $package = Package::where('status', 'active')->find($request->package_id);
        }

        if (! $package) {
            return redirect()->back()->with('error', "No active investment package found matching \${$investedAmount}. Please enter an amount within valid package ranges.");
        }

        // 2. Check min / max limits for the matched package
        if ($investedAmount < $package->min_amount || ($package->max_amount < 999999 && $investedAmount > $package->max_amount)) {
            return redirect()->back()->with('error', "Investment amount must be between \${$package->min_amount} and \${$package->max_amount} for {$package->name}.");
        }

        // 3. Check Deposit Wallet Balance
        if ((float) $user->deposit_wallet < $investedAmount) {
            return redirect()->route('user.deposits.index')->with('error', "Insufficient Deposit Wallet Balance (\${$user->deposit_wallet}). Please add funds first to invest \${$investedAmount} in {$package->name}!");
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
                'description' => 'Invested $'.number_format($investedAmount, 2)." in {$package->name} via Deposit Wallet",
                'reference_id' => $userPackage->id,
                'status' => 'completed',
            ]);

            // Delegate 10% Direct Referral Commission to Dedicated DirectIncomeService
            app(DirectIncomeService::class)->distributeDirectCommission($user, $userPackage, $investedAmount);
        });

        return redirect()->route('user.packages.history')->with('success', 'Congratulations! You have successfully invested $'.number_format($investedAmount, 2)." in {$package->name}! Daily ROI activated.");
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
