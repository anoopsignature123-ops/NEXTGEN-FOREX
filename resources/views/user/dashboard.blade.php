@extends('user.layouts.app')

@section('title', 'User Dashboard Overview')

@section('content')
    <style>
        .pdf-package-card {
            background: linear-gradient(180deg, #063824 0%, #021d12 50%, #000000 100%) !important;
            border: 2px solid rgba(243, 202, 82, 0.8) !important;
            box-shadow: 0 0 25px rgba(243, 202, 82, 0.25), inset 0 1px 2px rgba(255, 255, 255, 0.2) !important;
            transition: all 0.3s ease-in-out !important;
        }

    .pdf-package-card:hover {
        transform: translateY(-4px) scale(1.02) !important;
        box-shadow: 0 0 35px rgba(243, 202, 82, 0.45) !important;
    }

    .pdf-gold-badge {
        background: linear-gradient(180deg, #fef08a 0%, #f59e0b 50%, #b45309 100%) !important;
        border: 2px solid #fef08a !important;
        box-shadow: 0 0 15px rgba(243, 202, 82, 0.7), inset 0 2px 4px rgba(255, 255, 255, 0.8) !important;
        color: #000000 !important;
    }

    .pdf-gold-ribbon {
        background: linear-gradient(90deg, #d97706 0%, #fef08a 50%, #d97706 100%) !important;
        color: #000000 !important;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.4);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
    }

    .gold-highlight {
        color: #f3ca52 !important;
        font-weight: 800 !important;
        text-shadow: 0 0 10px rgba(243, 202, 82, 0.35) !important;
    }
    .five-cards-row {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 0.875rem;
    }
    @media (min-width: 640px) {
        .five-cards-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .dashboard-two-cards-row {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 1rem !important;
        }
    }
    @media (min-width: 1024px) {
        .five-cards-row {
            grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
        }
    }
    </style>

    <div class="w-full space-y-6 font-sans relative">

        <!-- Ambient Gold Radial Glow Decorator -->
        <div
            class="absolute -top-24 left-1/2 -translate-x-1/2 w-[900px] h-[450px] bg-amber-500/10 blur-[130px] pointer-events-none rounded-full">
        </div>

        <!-- Top Header Banner -->
        <div
            class="p-6 rounded-3xl pdf-package-card flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
            <div>
                <div class="flex items-center gap-2 text-amber-400 text-xs font-bold uppercase tracking-widest mb-1">
                    @if($user->status === 'active')
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                        NEXTGEN FOREX MEMBER PORTAL • LIVE ACTIVE ACCOUNT
                    @else
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                        NEXTGEN FOREX MEMBER PORTAL • INACTIVE ACCOUNT
                    @endif
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white font-heading">Welcome Back, <span
                        class="gold-highlight">{{ $user->name }}</span></h1>
                <p class="text-xs text-neutral-300 mt-1">Referral Code: <span
                        class="text-amber-400 font-bold font-mono">{{ $user->referral_code }}</span> • Status:
                    @if($user->status === 'active')
                        <span class="text-emerald-400 font-bold uppercase">ACTIVE MEMBER</span>
                    @else
                        <span class="text-amber-400 font-bold uppercase">INACTIVE (PURCHASE PACKAGE TO ACTIVATE)</span>
                    @endif
                </p>
                </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                @if($user->is_bot_active)
                    <a href="{{ route('user.bot.trading') }}" class="px-4 py-2.5 rounded-2xl bg-emerald-500/20 border-2 border-emerald-500/80 text-emerald-300 text-xs font-black uppercase tracking-wider flex items-center gap-2 shadow-[0_0_15px_rgba(16,185,129,0.4)] animate-pulse hover:scale-105 transition" title="Quant Bot is Active & Mining ROI">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span>BOT: ACTIVE ⚡</span>
                    </a>
                @else
                    <a href="{{ route('user.bot.index') }}" class="px-4 py-2.5 rounded-2xl bg-amber-500/20 border-2 border-amber-400/80 text-amber-300 text-xs font-black uppercase tracking-wider flex items-center gap-2 shadow-[0_0_15px_rgba(243,202,82,0.4)] animate-pulse hover:scale-105 transition" title="Click to Start Quant Bot for Daily ROI">
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                        <span>BOT: INACTIVE (START BOT) ⚡</span>
                    </a>
                @endif

                <div class="px-4 py-2.5 rounded-2xl bg-black/80 border-2 border-amber-400/80 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-xl">
                    <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
                    <span>{{ date('l, d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- 1 SINGLE ROW GRID: BOT STATUS BANNER & REFERRAL LINK CARD -->
        <div class="grid grid-cols-1 dashboard-two-cards-row gap-4 relative z-10">
            <!-- BOT STATUS CARD -->
            @if(!$user->is_bot_active)
                <div class="p-4 rounded-3xl pdf-package-card flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xl animate-pulse">
                    <div class="flex items-center gap-3 text-left overflow-hidden min-w-0 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/50 flex items-center justify-center text-amber-400 shrink-0">
                            <i data-lucide="zap" class="w-5 h-5 text-amber-400 fill-amber-400"></i>
                        </div>
                        <div class="overflow-hidden min-w-0 flex-1 text-left">
                            <h4 class="text-xs sm:text-sm font-black text-amber-300 uppercase tracking-wider truncate text-left">⚡ ATTENTION: TRADING BOT IS INACTIVE</h4>
                            <p class="text-[11px] text-neutral-200 truncate text-left">Daily ROI income is ONLY paid with an active Trading Bot.</p>
                        </div>
                    </div>
                    <a href="{{ route('user.bot.index') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-300 hover:to-yellow-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition shrink-0 flex items-center gap-1.5 border border-yellow-200 whitespace-nowrap">
                        <i data-lucide="play-circle" class="w-4 h-4 text-black fill-black"></i>
                        <span>START BOT</span>
                    </a>
                </div>
            @else
                <div class="p-4 rounded-3xl pdf-package-card flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xl">
                    <div class="flex items-center gap-3 text-left overflow-hidden min-w-0 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/50 flex items-center justify-center text-emerald-400 shrink-0">
                            <i data-lucide="cpu" class="w-5 h-5 text-emerald-400"></i>
                        </div>
                        <div class="overflow-hidden min-w-0 flex-1 text-left">
                            <h4 class="text-xs sm:text-sm font-black text-emerald-300 uppercase tracking-wider truncate text-left">🚀 TRADING BOT IS ACTIVE & MINING</h4>
                            <p class="text-[11px] text-neutral-200 truncate text-left">Activated on <strong class="text-amber-300 font-mono">{{ $user->bot_activated_at?->format('M d, Y H:i') }}</strong>. Yield mining 24/7.</p>
                        </div>
                    </div>
                    <a href="{{ route('user.bot.trading') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 border border-emerald-500/50 font-black text-xs uppercase tracking-wider shadow-md hover:scale-105 transition shrink-0 flex items-center gap-1.5 whitespace-nowrap">
                        <i data-lucide="line-chart" class="w-4 h-4 text-emerald-400"></i>
                        <span>TERMINAL</span>
                    </a>
                </div>
            @endif

            <!-- REFERRAL LINK CARD -->
            <div class="p-4 rounded-3xl pdf-package-card flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-xl">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                        <i data-lucide="link" class="w-5 h-5 text-black"></i>
                    </div>
                    <div class="overflow-hidden">
                        <span class="text-xs font-extrabold text-amber-400 uppercase tracking-wider block">OFFICIAL REFERRAL LINK</span>
                        <p class="text-xs text-neutral-200 font-mono font-bold truncate mt-0.5">
                            {{ url('/user/register?sponsor=' . $user->referral_code) }}
                        </p>
                    </div>
                </div>
                <button
                    onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=' . $user->referral_code) }}'); showToast('Copied!', 'Referral link copied to clipboard.', 'success');"
                    class="px-4 py-2.5 rounded-xl pdf-gold-ribbon hover:brightness-110 text-black font-black text-xs uppercase tracking-wider transition shrink-0 flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                    <i data-lucide="copy" class="w-4 h-4 text-black"></i> Copy Link
                </button>
            </div>
        </div>

        <!-- 5 MAIN FINANCIAL WALLET & CAPITAL CARDS (ALWAYS 1 SINGLE ROW ON DESKTOP) -->
        <div class="five-cards-row relative z-10">

            <!-- WALLET 1: Deposit Wallet -->
            <div class="p-4 rounded-3xl pdf-package-card relative overflow-hidden group flex flex-col justify-between">
                <div class="flex justify-between items-center mb-3">
                    <div class="w-9 h-9 rounded-xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                        <i data-lucide="wallet" class="w-4 h-4 text-black"></i>
                    </div>
                    <a href="{{ route('user.deposits.index') }}"
                        class="text-[10px] font-black pdf-gold-ribbon px-2.5 py-0.5 rounded-full shrink-0">
                        + Add Fund
                    </a>
                    </div>
                <div>
                    <div class="text-[11px] font-extrabold text-neutral-300 uppercase tracking-wider truncate">Deposit
                        Wallet</div>
                    <h3 class="text-xl sm:text-2xl font-black text-emerald-400 font-mono mt-0.5">
                        ${{ number_format($user->deposit_wallet, 2) }}</h3>
                </div>
                </div>

            <!-- WALLET 2: Earning Wallet -->
            <div class="p-4 rounded-3xl pdf-package-card relative overflow-hidden group flex flex-col justify-between">
                <div class="flex justify-between items-center mb-3">
                    <div class="w-9 h-9 rounded-xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                        <i data-lucide="coins" class="w-4 h-4 text-black"></i>
                    </div>
                    <a href="{{ route('user.withdrawals.index') }}"
                        class="text-[10px] font-black text-amber-300 font-mono bg-black/60 px-2.5 py-0.5 rounded-full border border-amber-400/50 hover:bg-amber-400 hover:text-black transition shrink-0">
                        Withdraw &rarr;
                    </a>
                    </div>
                <div>
                    <div class="text-[11px] font-extrabold text-neutral-300 uppercase tracking-wider truncate">Earning
                        Wallet</div>
                    <h3 class="text-xl sm:text-2xl font-black text-amber-300 font-mono mt-0.5">
                        ${{ number_format($user->earning_wallet, 2) }}</h3>
                </div>
                </div>

            <!-- WALLET 3: Withdrawal Wallet / Total Withdrawn -->
            <div class="p-4 rounded-3xl pdf-package-card relative overflow-hidden group flex flex-col justify-between">
                <div class="flex justify-between items-center mb-3">
                    <div class="w-9 h-9 rounded-xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-black"></i>
                    </div>
                    <a href="{{ route('user.withdrawals.history') }}"
                        class="text-[10px] font-black text-rose-300 font-mono bg-black/60 px-2.5 py-0.5 rounded-full border border-rose-400/50 hover:bg-rose-400 hover:text-black transition shrink-0">
                        History &rarr;
                    </a>
                    </div>
                    <div>
                        <div class="text-[11px] font-extrabold text-neutral-300 uppercase tracking-wider truncate">Withdrawal
                            Wallet</div>
                        <h3 class="text-xl sm:text-2xl font-black text-rose-300 font-mono mt-0.5">
                            ${{ number_format($totalWithdrawn, 2) }}</h3>
                    </div>
                    </div>

                    <!-- WALLET 4: Total Invested Capital -->
                    <div class="p-4 rounded-3xl pdf-package-card relative overflow-hidden group flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <div class="w-9 h-9 rounded-xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                                <i data-lucide="package-check" class="w-4 h-4 text-black"></i>
                            </div>
                            <span
                                class="text-[10px] font-black text-sky-300 font-mono bg-black/60 px-2 py-0.5 rounded-full border border-sky-400/50 shrink-0">
                                {{ $activeInvestmentsCount }} Active
                            </span>
                        </div>
                <div>
                    <div class="text-[11px] font-extrabold text-neutral-300 uppercase tracking-wider truncate">Invested
                        Capital</div>
                    <h3 class="text-xl sm:text-2xl font-black text-sky-300 font-mono mt-0.5">
                        ${{ number_format($totalInvested, 2) }}</h3>
                </div>
                </div>

            <!-- WALLET 5: Total Income Earned -->
            <div class="p-4 rounded-3xl pdf-package-card relative overflow-hidden group flex flex-col justify-between">
                <div class="flex justify-between items-center mb-3">
                    <div class="w-9 h-9 rounded-xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                        <i data-lucide="award" class="w-4 h-4 text-black"></i>
                    </div>
                    <span
                        class="text-[10px] font-black text-purple-300 font-mono bg-black/60 px-2 py-0.5 rounded-full border border-purple-400/50 shrink-0">Total
                        Earned</span>
                    </div>
                <div>
                    <div class="text-[11px] font-extrabold text-neutral-300 uppercase tracking-wider truncate">Total Income
                        Earned</div>
                    <h3 class="text-xl sm:text-2xl font-black text-purple-300 font-mono mt-0.5">
                        ${{ number_format($totalIncomeEarned, 2) }}</h3>
                </div>
                </div>

        </div>

        <!-- 2-COLUMN GRID (COL-SM-6 EQUIVALENT): EARNINGS SUMMARY & TEAM OVERVIEW SIDE-BY-SIDE -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 relative z-10">

            <!-- LEFT CARD: EARNINGS SUMMARY -->
            <div class="p-4 sm:p-5 rounded-3xl pdf-package-card space-y-3 shadow-xl overflow-hidden flex flex-col justify-between">
                <div class="flex items-center justify-between border-b border-amber-500/20 pb-3">
                    <div>
                        <span class="text-amber-400 font-extrabold text-[10px] uppercase tracking-widest block mb-0.5">FINANCIAL OVERVIEW</span>
                        <h2 class="text-base sm:text-lg font-black text-white font-heading">Earnings Summary</h2>
                    </div>
                    <a href="{{ route('user.reports.summary') }}"
                        class="px-3 py-1 rounded-full bg-black/60 hover:bg-amber-400 hover:text-black border border-amber-400/60 text-amber-300 text-[11px] font-bold font-heading uppercase tracking-wider transition inline-flex items-center gap-1 shadow">
                        <span>View History</span>
                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="border-b border-amber-500/20 text-amber-400 font-extrabold text-[10px] tracking-wider uppercase font-mono">
                            <tr>
                                <th class="py-2 px-3">INCOME TYPE / METRIC</th>
                                <th class="py-2 px-3 text-center">TODAY INCOME</th>
                                <th class="py-2 px-3 text-right">TOTAL INCOME / VOLUME</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10 text-xs">
                            <!-- 1. Total Team Business -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg pdf-gold-badge flex items-center justify-center shrink-0 shadow">
                                        <i data-lucide="users" class="w-3 h-3 text-black"></i>
                                    </span>
                                    <div>
                                        <span class="block text-xs font-bold">Total Team Business</span>
                                        <span class="text-[9px] text-neutral-400 font-normal font-mono block">Power: ${{ number_format($powerLegVolume, 2) }} • Weaker: ${{ number_format($weakerLegVolume, 2) }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono text-xs text-neutral-400">-</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-amber-300 text-xs sm:text-sm">${{ number_format($totalTeamBusiness, 2) }}</td>
                            </tr>

                            <!-- 2. Referral / Direct Income -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-sky-500/20 text-sky-400 border border-sky-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="user-plus" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.direct') }}" class="hover:text-amber-300 transition text-xs font-bold">Referral / Direct Income</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">Flat 10% Instant Commission</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayDirectEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalDirectEarned, 2) }}</td>
                            </tr>

                            <!-- 3. Daily ROI Income -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="line-chart" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.roi') }}" class="hover:text-amber-300 transition text-xs font-bold">Daily ROI Income</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">0.5%–1.5% Daily Yield (2X Return Cap)</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayRoiEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalRoiEarned, 2) }}</td>
                            </tr>

                            <!-- 4. 24H Special Booster Bonus -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="zap" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.bonus') }}" class="hover:text-amber-300 transition text-xs font-bold">24H Special Bonus</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">5 Direct Referrals in 24 Hours</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayBonusEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalBonusEarned, 2) }}</td>
                            </tr>

                            <!-- 5. Level Income -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-400 border border-teal-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="layers" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.level') }}" class="hover:text-amber-300 transition text-xs font-bold">Level Income</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">10-Tier Team Commissions (20% to 1%)</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayLevelEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalLevelEarned, 2) }}</td>
                            </tr>

                            <!-- 6. Matching Income -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-purple-500/20 text-purple-400 border border-purple-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="git-merge" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.matching') }}" class="hover:text-amber-300 transition text-xs font-bold">Matching Income</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">5% on Matched Vol (${{ number_format($matchedVolume, 2) }})</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayMatchingEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalMatchingEarned, 2) }}</td>
                            </tr>
                            <!-- 7. Direct Salary Income -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-rose-500/20 text-rose-400 border border-rose-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.direct-salary') }}" class="hover:text-amber-300 transition text-xs font-bold">Direct Salary Income</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">$1 to $1,000/day for 365 Days</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayDirectSalaryEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalDirectSalaryEarned, 2) }}</td>
                            </tr>

                            <!-- 8. Team Salary Income -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-orange-500/20 text-orange-400 border border-orange-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="award" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.team-salary') }}" class="hover:text-amber-300 transition text-xs font-bold">Team Salary Income</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">Recurring $75 per 15 Days for 12 Months</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayTeamSalaryEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalTeamSalaryEarned, 2) }}</td>
                            </tr>

                            <!-- 9. Leadership / Reward Bonus -->
                            <tr class="hover:bg-amber-500/5 transition">
                                <td class="py-2 px-3 font-semibold text-white flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg bg-violet-500/20 text-violet-400 border border-violet-500/40 flex items-center justify-center shrink-0">
                                        <i data-lucide="trophy" class="w-3 h-3"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('user.reports.rewards') }}" class="hover:text-amber-300 transition text-xs font-bold">Leadership / Reward Bonus</a>
                                        <span class="text-[9px] text-neutral-400 font-normal block">10% Milestone Cash Rewards ($100 to $5 Lacs)</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center font-mono font-bold text-emerald-400 text-xs">${{ number_format($todayRewardsEarned, 2) }}</td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-emerald-400 text-xs sm:text-sm">${{ number_format($totalRewardsEarned, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- RIGHT CARD: TEAM OVERVIEW & NETWORK METRICS (PREMIUM TILE DESIGN) -->
            <div class="p-4 sm:p-5 rounded-3xl pdf-package-card space-y-3 shadow-xl overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-amber-500/20 pb-2.5 mb-2.5">
                        <div>
                            <span class="text-amber-400 font-extrabold text-[10px] uppercase tracking-widest block mb-0.5">NETWORK OVERVIEW</span>
                            <h2 class="text-base sm:text-lg font-black text-white font-heading flex items-center gap-2">
                                <span>Team Overview</span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black pdf-gold-ribbon font-mono">LIVE NETWORK</span>
                            </h2>
                        </div>
                        <a href="{{ route('user.network.direct') }}"
                            class="px-3 py-1 rounded-full bg-black/60 hover:bg-amber-400 hover:text-black border border-amber-400/60 text-amber-300 text-[11px] font-bold font-heading uppercase tracking-wider transition inline-flex items-center gap-1 shadow">
                            <span>Direct Team</span>
                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>

                    <!-- Power Leg vs Weaker Leg (50:50 Matching Volume & Carry Forward Banner) -->
                    <div class="grid grid-cols-2 gap-2 mb-2.5">
                        <div class="p-2 sm:p-2.5 rounded-2xl bg-amber-950/40 border border-amber-400/40 flex items-center gap-2 shadow-sm">
                            <div class="w-7 h-7 rounded-lg bg-amber-400/20 text-amber-300 border border-amber-400/50 flex items-center justify-center shrink-0">
                                <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-400"></i>
                            </div>
                            <div class="overflow-hidden min-w-0">
                                <span class="text-[9px] text-amber-400 font-extrabold uppercase tracking-wider block truncate">POWER LEG</span>
                                <span class="text-xs font-mono font-black text-amber-300 block truncate">${{ number_format($powerLegVolume, 2) }}</span>
                                <span class="text-[8px] text-neutral-400 font-mono block truncate">Carry: ${{ number_format($powerLegCarry, 2) }}</span>
                            </div>
                        </div>
                        <div class="p-2 sm:p-2.5 rounded-2xl bg-emerald-950/40 border border-emerald-500/40 flex items-center gap-2 shadow-sm">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/50 flex items-center justify-center shrink-0">
                                <i data-lucide="scale" class="w-3.5 h-3.5 text-emerald-400"></i>
                            </div>
                            <div class="overflow-hidden min-w-0">
                                <span class="text-[9px] text-emerald-400 font-extrabold uppercase tracking-wider block truncate">WEAKER LEG</span>
                                <span class="text-xs font-mono font-black text-emerald-300 block truncate">${{ number_format($weakerLegVolume, 2) }}</span>
                                <span class="text-[8px] text-neutral-400 font-mono block truncate">Carry: ${{ number_format($weakerLegCarry, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Network Ratio Bar Banner -->
                    @php
                        $teamRatio = $totalTeamCount > 0 ? round(($activeTeamCount / $totalTeamCount) * 100) : 0;
                    @endphp
                    <div class="p-2.5 rounded-2xl bg-black/50 border border-amber-500/20 mb-2.5 space-y-1">
                        <div class="flex justify-between items-center text-[10px] font-mono">
                            <span class="text-neutral-300 font-bold uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="activity" class="w-3 h-3 text-amber-400"></i> Active Network Ratio
                            </span>
                            <span class="text-amber-300 font-black">{{ $teamRatio }}% Active</span>
                        </div>
                        <div class="w-full bg-neutral-800 rounded-full h-1.5 overflow-hidden flex">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-1.5 rounded-full transition-all duration-500" style="width: {{ $teamRatio }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- 5 Sleek Interactive Metric Tiles -->
                <div class="space-y-2.5 flex-1 flex flex-col justify-between">
                    <!-- 1. Total Active Direct Count & Business -->
                    <div class="p-2.5 sm:p-3 rounded-2xl bg-emerald-950/30 border border-emerald-500/30 hover:border-emerald-500/60 transition flex items-center justify-between gap-3 shadow-md group">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                                <i data-lucide="user-check" class="w-4 h-4"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-xs font-black text-emerald-300 truncate">Active Directs & Business</span>
                                <span class="text-[10px] text-amber-300 font-mono font-bold block">Volume: ${{ number_format($activeDirectBusiness, 2) }}</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0 font-mono">
                            <span class="text-sm sm:text-base font-black text-emerald-400 block">{{ $activeDirectMembersCount }}</span>
                            <span class="px-1.5 py-0.2 rounded text-[8px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase">ACTIVE</span>
                        </div>
                    </div>

                    <!-- 2. Total Inactive Count -->
                    <div class="p-2.5 sm:p-3 rounded-2xl bg-amber-950/20 border border-amber-500/25 hover:border-amber-500/50 transition flex items-center justify-between gap-3 shadow-md group">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                                <i data-lucide="user-x" class="w-4 h-4"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-xs font-black text-amber-300 truncate">Inactive Direct Count</span>
                                <span class="text-[10px] text-neutral-400 font-sans block">Awaiting package activation</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0 font-mono">
                            <span class="text-sm sm:text-base font-black text-amber-400 block">{{ $inactiveDirectMembersCount }}</span>
                            <span class="px-1.5 py-0.2 rounded text-[8px] font-extrabold bg-amber-500/20 text-amber-300 border border-amber-500/40 uppercase">INACTIVE</span>
                        </div>
                    </div>

                    <!-- 3. Total Team -->
                    <div class="p-2.5 sm:p-3 rounded-2xl bg-black/60 border border-amber-400/40 hover:border-amber-400/80 transition flex items-center justify-between gap-3 shadow-md group">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-9 h-9 rounded-xl pdf-gold-badge flex items-center justify-center shrink-0 shadow group-hover:scale-110 transition">
                                <i data-lucide="users" class="w-4 h-4 text-black"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-xs font-black text-white truncate">Total Team</span>
                                <span class="text-[10px] text-neutral-300 font-sans block">Full downline (All 10 Tiers)</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0 font-mono">
                            <span class="text-sm sm:text-base font-black text-amber-300 block">{{ $totalTeamCount }}</span>
                            <span class="px-1.5 py-0.2 rounded text-[8px] font-extrabold bg-purple-500/20 text-purple-300 border border-purple-500/40 uppercase">ALL TIERS</span>
                        </div>
                    </div>

                    <!-- 4. Total Active Team -->
                    <div class="p-2.5 sm:p-3 rounded-2xl bg-teal-950/20 border border-teal-500/30 hover:border-teal-500/60 transition flex items-center justify-between gap-3 shadow-md group">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-9 h-9 rounded-xl bg-teal-500/20 text-teal-400 border border-teal-500/40 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-xs font-black text-teal-300 truncate">Total Active Team</span>
                                <span class="text-[10px] text-neutral-400 font-sans block">Active paid network members</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0 font-mono">
                            <span class="text-sm sm:text-base font-black text-teal-300 block">{{ $activeTeamCount }}</span>
                            <span class="px-1.5 py-0.2 rounded text-[8px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase">ACTIVE</span>
                        </div>
                    </div>

                    <!-- 5. Total Inactive Team -->
                    <div class="p-2.5 sm:p-3 rounded-2xl bg-rose-950/20 border border-rose-500/25 hover:border-rose-500/50 transition flex items-center justify-between gap-3 shadow-md group">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-9 h-9 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/40 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                                <i data-lucide="user-minus" class="w-4 h-4"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-xs font-black text-rose-300 truncate">Total Inactive Team</span>
                                <span class="text-[10px] text-neutral-400 font-sans block">Unpaid network members</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0 font-mono">
                            <span class="text-sm sm:text-base font-black text-rose-400 block">{{ $inactiveTeamCount }}</span>
                            <span class="px-1.5 py-0.2 rounded text-[8px] font-extrabold bg-rose-500/20 text-rose-400 border border-rose-500/40 uppercase">INACTIVE</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- DYNAMIC SIDE-BY-SIDE TABLES GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 relative z-10">

            <!-- LEFT: MY ACTIVE PACKAGES -->
            <div class="p-6 rounded-3xl pdf-package-card space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-amber-500/20">
                    <div class="px-3.5 py-1 rounded-xl pdf-gold-ribbon font-black text-xs uppercase tracking-wider shadow">
                        My Active Packages
                    </div>
                    <a href="{{ route('user.packages.history') }}" class="text-xs text-amber-300 font-bold hover:underline">View
                        All &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-amber-400 font-bold uppercase border-b border-amber-500/20">
                            <tr>
                                <th class="pb-2">PACKAGE</th>
                                <th class="pb-2">INVESTED</th>
                                <th class="pb-2">DAILY ROI</th>
                                <th class="pb-2">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10 text-neutral-300 font-mono">
                            @forelse($activePackages as $ap)
                                <tr>
                                    <td class="py-2.5 font-sans font-bold text-white">{{ $ap->package->name ?? 'Package' }}</td>
                                    <td class="py-2.5 font-black text-amber-300">${{ number_format($ap->invested_amount, 2) }}</td>
                                    <td class="py-2.5 font-bold text-emerald-400">{{ number_format($ap->daily_roi, 2) }}%</td>
                                    <td class="py-2.5">
                                        <span
                                            class="px-2 py-0.5 rounded text-[9px] font-black bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 uppercase">ACTIVE</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-neutral-500 font-sans">No active packages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>

            <!-- RIGHT: RECENT TRANSACTIONS LOG -->
            <div class="p-6 rounded-3xl pdf-package-card space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-amber-500/20">
                    <div class="px-3.5 py-1 rounded-xl pdf-gold-ribbon font-black text-xs uppercase tracking-wider shadow">
                        Recent Transactions
                    </div>
                    <a href="{{ route('user.transactions.index') }}" class="text-xs text-amber-300 font-bold hover:underline">View
                        All &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-amber-400 font-bold uppercase border-b border-amber-500/20">
                            <tr>
                                <th class="pb-2">TXN ID</th>
                                <th class="pb-2">TYPE</th>
                                <th class="pb-2">AMOUNT</th>
                                <th class="pb-2">DATE</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10 text-neutral-300 font-mono">
                            @forelse($recentTransactions as $rt)
                                <tr>
                                    <td class="py-2.5 font-bold text-amber-400 text-[11px]">{{ $rt->txn_number }}</td>
                                    <td class="py-2.5 font-sans capitalize text-neutral-200">{{ str_replace('_', ' ', $rt->type) }}</td>
                                    <td class="py-2.5 font-black {{ $rt->trx_type === '+' ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $rt->trx_type }}${{ number_format($rt->amount, 2) }}
                                    </td>
                                    <td class="py-2.5 text-[10px] text-neutral-400">{{ $rt->created_at->format('M d, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-neutral-500 font-sans">No recent transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>

        </div>

    </div>
@endsection
