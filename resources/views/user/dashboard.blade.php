@extends('user.layouts.app')

@section('content')
<!-- Header Banner -->
<div class="p-6 rounded-2xl bg-gradient-to-r from-amber-950 via-neutral-900 to-black border border-amber-500/30 shadow-2xl relative overflow-hidden">
    <div class="absolute right-0 top-0 translate-x-8 -translate-y-8 w-64 h-64 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
        <div>
            <div class="flex items-center gap-2 text-amber-400 text-xs font-bold uppercase tracking-widest mb-1">
                @if(Auth::user() && Auth::user()->status === 'active')
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    NEXTGEN FOREX MEMBER PORTAL • LIVE ACTIVE ACCOUNT
                @else
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    NEXTGEN FOREX MEMBER PORTAL • INACTIVE ACCOUNT
                @endif
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Welcome Back, {{ Auth::user() ? Auth::user()->name : 'Member' }}</h1>
            <p class="text-sm text-neutral-400 mt-1">Referral Code: <span class="text-amber-400 font-bold font-mono">{{ Auth::user() ? Auth::user()->referral_code : 'NGF-0967542' }}</span> • Status: 
                @if(Auth::user() && Auth::user()->status === 'active')
                    <span class="text-emerald-400 font-bold uppercase">ACTIVE MEMBER</span>
                @else
                    <span class="text-amber-400 font-bold uppercase">INACTIVE (PACKAGE INVESTMENT PENDING)</span>
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Referral Link Banner -->
<div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 flex flex-col sm:flex-row items-center justify-between gap-3">
    <div class="flex items-center gap-3">
        <i data-lucide="link" class="w-5 h-5 text-amber-400 shrink-0"></i>
        <div>
            <span class="text-xs font-bold text-white uppercase">Your Personal Referral Link (10% Direct Commission)</span>
            <p class="text-xs text-amber-300 font-mono">{{ url('/user/register?sponsor=' . (Auth::user() ? Auth::user()->referral_code : 'NGF-0967542')) }}</p>
        </div>
    </div>
    <button onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=' . (Auth::user() ? Auth::user()->referral_code : 'NGF-0967542')) }}'); showToast('Copied!', 'Referral link copied to clipboard.', 'success');" class="px-4 py-2 rounded-lg bg-amber-500 text-black text-xs font-bold hover:bg-amber-400 transition shrink-0">
        Copy Link
    </button>
</div>

<!-- User Earnings Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat 1: Total Earnings -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Total Earnings</span>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                <i data-lucide="dollar-sign" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-amber-400">$0.00</h3>
            <p class="text-xs text-amber-400 font-semibold mt-1 flex items-center gap-1">
                <i data-lucide="info" class="w-3.5 h-3.5"></i> Activate package to earn ROI & Commissions
            </p>
        </div>
    </div>

    <!-- Stat 2: Daily ROI Earned -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Daily ROI Income</span>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <i data-lucide="coins" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-emerald-400">$0.00</h3>
            <p class="text-xs text-muted font-medium mt-1">Daily 0.5% - 1.5% ROI Rate</p>
        </div>
    </div>

    <!-- Stat 3: Direct Income -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Direct Income (10%)</span>
            <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-sky-400">$0.00</h3>
            <p class="text-xs text-muted font-medium mt-1">Instant 10% Direct Referrals</p>
        </div>
    </div>

    <!-- Stat 4: Matching Income -->
    <div class="p-5 rounded-2xl bg-panel border border-border hover:border-amber-500/40 transition shadow-lg">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-muted">Matching Income (5%)</span>
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                <i data-lucide="git-merge" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-purple-400">$0.00</h3>
            <p class="text-xs text-amber-400 font-semibold mt-1">50:50 Power/Weaker Ratio</p>
        </div>
    </div>
</div>

<!-- 7 Incomes Breakdown Cards -->
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i data-lucide="layers" class="w-5 h-5 text-amber-400"></i> My 7 Income Streams Summary
        </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">1. ROI INCOME</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-muted">0.5% to 1.5% Daily Rate</p>
        </div>
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">2. 24H SPECIAL BONUS</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-amber-400">$50, $250, $500 Bonus</p>
        </div>
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">3. DIRECT INCOME (10%)</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-muted">10% Direct Sales Payout</p>
        </div>
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">4. MATCHING INCOME (5%)</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-muted">50:50 Volume Matching</p>
        </div>
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">5. DIRECT SALARY</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-muted">365 Days Daily Payout</p>
        </div>
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">6. TEAM SALARY</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-muted">12 Months Team Salary</p>
        </div>
        <div class="p-4 rounded-xl bg-panel border border-border">
            <span class="text-[10px] font-bold text-amber-400 uppercase">7. REWARD INCOME</span>
            <p class="text-lg font-extrabold text-white mt-1">$0.00</p>
            <p class="text-xs text-amber-400">10% Team Volume Reward</p>
        </div>
        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30">
            <span class="text-[10px] font-bold text-amber-400 uppercase">AVAILABLE BALANCE</span>
            <p class="text-lg font-extrabold text-amber-300 mt-1">$0.00 USDT</p>
            <span class="text-[11px] font-bold text-neutral-400">Withdrawals (10% Fee)</span>
        </div>
    </div>
</div>
@endsection
