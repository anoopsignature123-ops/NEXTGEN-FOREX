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
            <div
                class="px-5 py-2.5 rounded-2xl bg-black/80 border-2 border-amber-400/80 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-xl">
                <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
                <span>{{ date('l, d M Y') }}</span>
            </div>
            </div>

        <!-- SINGLE OFFICIAL MEMBER REFERRAL LINK CARD -->
        <div
            class="p-5 rounded-3xl pdf-package-card flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 relative z-10 shadow-xl">
            <div class="flex items-center gap-4 overflow-hidden">
                <div class="w-12 h-12 rounded-2xl pdf-gold-badge flex items-center justify-center font-black shrink-0">
                    <i data-lucide="link" class="w-6 h-6 text-black"></i>
                </div>
                <div class="overflow-hidden">
                    <span class="text-xs font-extrabold text-amber-400 uppercase tracking-wider block">YOUR OFFICIAL
                        REFERRAL LINK</span>
                    <p class="text-sm text-neutral-200 font-mono font-bold truncate mt-0.5">
                        {{ url('/user/register?sponsor=' . $user->referral_code) }}
                    </p>
                    </div>
                    </div>
            <button
                onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=' . $user->referral_code) }}'); showToast('Copied!', 'Referral link copied to clipboard.', 'success');"
                class="px-6 py-3 rounded-2xl pdf-gold-ribbon hover:brightness-110 text-black font-black text-xs uppercase tracking-wider transition shrink-0 flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="copy" class="w-4 h-4 text-black"></i> Copy Referral Link
            </button>
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

        <!-- DYNAMIC 7 INCOME STREAMS BREAKDOWN CARDS (SLEEK & COMPACT EMERALD-GOLD DESIGN) -->
        <div class="space-y-3 pt-2 relative z-10">
            <div class="flex items-center justify-between border-b border-amber-400/30 pb-2.5">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-xl pdf-gold-badge flex items-center justify-center text-black font-black text-sm shadow">
                        🛡️
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-gold-gradient font-heading tracking-wide uppercase">
                            MY 7 INCOME CATEGORIES</h2>
                        <p class="text-[11px] text-neutral-300">Live Breakdown of Your Earned Incomes Across All 7 Business
                            Streams</p>
                        </div>
                        </div>
                <a href="{{ route('user.reports.summary') }}"
                    class="px-4 py-1.5 rounded-full pdf-gold-ribbon text-[11px] font-black uppercase tracking-wider shadow transition">
                    View Summary &rarr;
                </a>
                </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- 1. ROI INCOME -->
                <a href="{{ route('user.reports.roi') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-amber-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">1</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-amber-300 text-[9px] font-black font-mono uppercase border border-amber-500/40">Daily
                            Yield</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">Daily ROI Income</h4>
                    <h3 class="text-xl sm:text-2xl font-black text-amber-300 font-mono mt-0.5">
                        ${{ number_format($totalRoiEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        0.5%–1.5% daily yield (<span class="text-emerald-400 font-bold">2X Return Cap</span>).
                    </p>
                    </a>

                <!-- 2. 24H SPECIAL BONUS -->
                <a href="{{ route('user.reports.bonus') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-emerald-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">2</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-emerald-300 text-[9px] font-black font-mono uppercase border border-emerald-500/40">Booster</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">24H Special Bonus
                    </h4>
                    <h3 class="text-xl sm:text-2xl font-black text-emerald-300 font-mono mt-0.5">
                        ${{ number_format($totalBonusEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        Earned via <span class="text-emerald-400 font-bold">5 direct referrals</span> in 24 hours.
                    </p>
                    </a>

                <!-- 3. DIRECT INCOME (10%) -->
                <a href="{{ route('user.reports.direct') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-sky-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">3</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-sky-300 text-[9px] font-black font-mono uppercase border border-sky-500/40">Flat
                            10%</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">Direct Income</h4>
                    <h3 class="text-xl sm:text-2xl font-black text-sky-300 font-mono mt-0.5">
                        ${{ number_format($totalDirectEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        <span class="text-sky-300 font-bold">Flat 10% instant</span> referral commission.
                    </p>
                    </a>

                <!-- 4. MATCHING INCOME (5%) -->
                <a href="{{ route('user.reports.matching') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-purple-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">4</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-purple-300 text-[9px] font-black font-mono uppercase border border-purple-500/40">Team
                            5%</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">Matching Income</h4>
                    <h3 class="text-xl sm:text-2xl font-black text-purple-300 font-mono mt-0.5">
                        ${{ number_format($totalMatchingEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        <span class="text-purple-300 font-bold">5% matching volume</span> (50:50 ratio).
                    </p>
                    </a>

                <!-- 5. DIRECT SALARY INCOME -->
                <a href="{{ route('user.reports.direct-salary') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-rose-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">5</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-rose-300 text-[9px] font-black font-mono uppercase border border-rose-500/40">365
                            Days</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">Direct Salary Income
                    </h4>
                    <h3 class="text-xl sm:text-2xl font-black text-rose-300 font-mono mt-0.5">
                        ${{ number_format($totalSalaryEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        Daily salary (<span class="text-rose-300 font-bold">$1 to $1,000/day</span> for 365 days).
                    </p>
                    </a>

                <!-- 6. TEAM SALARY INCOME -->
                <a href="{{ route('user.reports.team-salary') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-orange-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">6</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-orange-300 text-[9px] font-black font-mono uppercase border border-orange-500/40">12
                            Months</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">Team Salary Income
                    </h4>
                    <h3 class="text-xl sm:text-2xl font-black text-orange-300 font-mono mt-0.5">
                        ${{ number_format($totalSalaryEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        Recurring <span class="text-orange-300 font-bold">$75 per 15 days</span> cycle for 12 months.
                    </p>
                    </a>

                <!-- 7. REWARD INCOME -->
                <a href="{{ route('user.reports.rewards') }}"
                    class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group block hover:border-violet-400 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-6 h-6 rounded-lg pdf-gold-badge font-black text-[10px] flex items-center justify-center">7</span>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-violet-300 text-[9px] font-black font-mono uppercase border border-violet-500/40">10%
                            Reward</span>
                    </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">Reward Income</h4>
                    <h3 class="text-xl sm:text-2xl font-black text-violet-300 font-mono mt-0.5">
                        ${{ number_format($totalRewardsEarned, 2) }}</h3>
                    <p class="text-[11px] text-neutral-400 font-normal mt-1 leading-snug">
                        <span class="text-violet-300 font-bold">10% milestone cash rewards</span> ($100 to $5 Lacs).
                    </p>
                    </a>

                <!-- MY NETWORK QUICK STAT CARD -->
                <div class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative group">
                    <div class="flex justify-between items-center mb-2">
                        <div
                            class="w-6 h-6 rounded-lg pdf-gold-badge text-black font-black text-[10px] flex items-center justify-center shadow">
                            <i data-lucide="users" class="w-3.5 h-3.5 text-black"></i>
                        </div>
                        <span
                            class="px-2 py-0.5 rounded-full bg-black/60 text-teal-300 text-[9px] font-black font-mono uppercase border border-teal-500/40">Direct
                            Team</span>
                        </div>
                    <h4 class="text-xs font-extrabold text-white font-heading uppercase tracking-wide">My Direct Network
                    </h4>
                    <h3 class="text-xl sm:text-2xl font-black text-teal-300 font-mono mt-0.5">{{ $directMembersCount }}
                        Members</h3>
                    <div class="mt-1 text-[11px] font-semibold text-neutral-400">
                        Active Directs: <strong class="text-emerald-400 font-mono font-black">{{ $activeDirectMembersCount }}</strong>
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
