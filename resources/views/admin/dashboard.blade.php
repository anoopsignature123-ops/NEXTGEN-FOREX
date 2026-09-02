@extends('admin.layouts.app')

@section('content')
<!-- Header Banner -->
<div class="p-6 rounded-2xl bg-gradient-to-r from-amber-950 via-neutral-900 to-black border border-amber-500/30 shadow-2xl relative overflow-hidden">
    <div class="absolute right-0 top-0 translate-x-8 -translate-y-8 w-64 h-64 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
        <div>
            <div class="flex items-center gap-2 text-amber-400 text-xs font-bold uppercase tracking-widest mb-1">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                NEXTGEN FOREX TRADING • ADMIN CONTROL
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">System Overview & Analytics</h1>
            <p class="text-sm text-neutral-400 mt-1">Welcome back, Super Admin. Here is the live status of your platform.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-bold text-sm shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
                <i data-lucide="users" class="w-4 h-4 text-black"></i> Manage Users
            </a>
        </div>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat 1 -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg relative group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Total System Users</span>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-white">12,480</h3>
            <p class="text-xs text-emerald-400 font-semibold mt-1 flex items-center gap-1">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +145 joined today
            </p>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg relative group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Total Active Investment</span>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                <i data-lucide="dollar-sign" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-amber-400">$3,450,000</h3>
            <p class="text-xs text-emerald-400 font-semibold mt-1 flex items-center gap-1">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +$24,500 today
            </p>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg relative group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Total Incomes Paid</span>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <i data-lucide="coins" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-emerald-400">$1,890,250</h3>
            <p class="text-xs text-muted font-medium mt-1">Across 7 Income Types</p>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg relative group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Pending Withdrawals</span>
            <div class="w-10 h-10 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-rose-400">$18,400</h3>
            <p class="text-xs text-amber-400 font-semibold mt-1">24 Pending USDT (BEP20)</p>
        </div>
    </div>
</div>

<!-- 7 Incomes Quick Summary Cards -->
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i data-lucide="layers" class="w-5 h-5 text-amber-400"></i> NextGen Compensation Plan Summary
        </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. ROI -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">1</span>
                <div>
                    <h4 class="text-sm font-bold text-white">ROI Income</h4>
                    <p class="text-xs text-amber-400 font-medium">0.5% to 1.5% Daily (200 Days)</p>
                </div>
            </div>
        </div>
        <!-- 2. 24h Bonus -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">2</span>
                <div>
                    <h4 class="text-sm font-bold text-white">24h Special Bonus</h4>
                    <p class="text-xs text-amber-400 font-medium">$50, $250, $500 Gift</p>
                </div>
            </div>
        </div>
        <!-- 3. Direct -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">3</span>
                <div>
                    <h4 class="text-sm font-bold text-white">Direct Income</h4>
                    <p class="text-xs text-emerald-400 font-medium">Flat 10% Commission</p>
                </div>
            </div>
        </div>
        <!-- 4. Matching -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">4</span>
                <div>
                    <h4 class="text-sm font-bold text-white">Matching Income</h4>
                    <p class="text-xs text-sky-400 font-medium">5% (50:50 Leg Ratio)</p>
                </div>
            </div>
        </div>
        <!-- 5. Direct Salary -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">5</span>
                <div>
                    <h4 class="text-sm font-bold text-white">Direct Salary</h4>
                    <p class="text-xs text-amber-400 font-medium">365 Days Daily Payout</p>
                </div>
            </div>
        </div>
        <!-- 6. Team Salary -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">6</span>
                <div>
                    <h4 class="text-sm font-bold text-white">Team Salary</h4>
                    <p class="text-xs text-purple-400 font-medium">12 Months ($75/15 days)</p>
                </div>
            </div>
        </div>
        <!-- 7. Reward -->
        <div class="p-4 rounded-xl bg-panel border border-border">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 font-black text-xs flex items-center justify-center">7</span>
                <div>
                    <h4 class="text-sm font-bold text-white">Reward Income</h4>
                    <p class="text-xs text-amber-400 font-medium">10% on Team Business</p>
                </div>
            </div>
        </div>
        <!-- Rules -->
        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30">
            <div class="flex items-center gap-3">
                <i data-lucide="shield-alert" class="w-5 h-5 text-amber-400"></i>
                <div>
                    <h4 class="text-sm font-bold text-amber-400">System Capping</h4>
                    <p class="text-xs text-neutral-300 font-medium">5X Capping & 10% W/D Fee</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Table -->
<div class="p-6 rounded-2xl bg-panel border border-border shadow-xl">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-bold text-white">Recent System Transactions</h3>
            <p class="text-xs text-muted">USDT (BEP20) Deposits & Withdrawals</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-bg text-muted uppercase text-[11px] font-bold tracking-wider">
                <tr>
                    <th class="p-3 rounded-l-xl">User</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Network</th>
                    <th class="p-3">Deduction (10%)</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 rounded-r-xl">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border text-neutral-300">
                <tr class="hover:bg-border/30 transition">
                    <td class="p-3 font-semibold text-white">Michael S. (#NX8821)</td>
                    <td class="p-3"><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded">Deposit</span></td>
                    <td class="p-3 font-bold text-amber-400">$1,000.00</td>
                    <td class="p-3 text-xs font-mono">USDT (BEP20)</td>
                    <td class="p-3 text-xs text-muted">$0.00</td>
                    <td class="p-3"><span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded">Completed</span></td>
                    <td class="p-3 text-xs text-muted">5 mins ago</td>
                </tr>
                <tr class="hover:bg-border/30 transition">
                    <td class="p-3 font-semibold text-white">Sarah Connor (#NX4419)</td>
                    <td class="p-3"><span class="px-2 py-1 bg-rose-500/10 text-rose-400 text-xs font-bold rounded">Withdrawal</span></td>
                    <td class="p-3 font-bold text-rose-400">$500.00</td>
                    <td class="p-3 text-xs font-mono">USDT (BEP20)</td>
                    <td class="p-3 text-xs text-amber-400 font-bold">$50.00 (10%)</td>
                    <td class="p-3"><span class="px-2 py-1 bg-amber-500/20 text-amber-400 text-xs font-bold rounded">Pending</span></td>
                    <td class="p-3 text-xs text-muted">12 mins ago</td>
                </tr>
                <tr class="hover:bg-border/30 transition">
                    <td class="p-3 font-semibold text-white">David Miller (#NX9902)</td>
                    <td class="p-3"><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded">Deposit</span></td>
                    <td class="p-3 font-bold text-amber-400">$5,000.00</td>
                    <td class="p-3 text-xs font-mono">USDT (BEP20)</td>
                    <td class="p-3 text-xs text-muted">$0.00</td>
                    <td class="p-3"><span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded">Completed</span></td>
                    <td class="p-3 text-xs text-muted">30 mins ago</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection