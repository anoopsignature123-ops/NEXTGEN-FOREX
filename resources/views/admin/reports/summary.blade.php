@extends('admin.layouts.app')

@section('title', 'Master Income Overview')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-amber-400 uppercase tracking-widest mb-1">
                <i data-lucide="bar-chart-3" class="w-4 h-4 text-amber-400"></i>
                <span>Master Financial Reports</span>
            </div>
            <h1 class="text-2xl font-black font-heading text-white uppercase tracking-wider">
                System Income Overview
            </h1>
            <p class="text-xs text-neutral-400 mt-1">High-level financial audit dashboard summarizing payouts across all 8 NextGen Forex income streams</p>
        </div>
        <div class="px-5 py-3 rounded-2xl bg-amber-500/10 border border-amber-500/30 shrink-0">
            <span class="text-[10px] font-bold text-amber-400 uppercase block">Grand Total Incomes Distributed</span>
            <span class="text-2xl font-black font-mono text-emerald-400">${{ number_format($grandTotal, 2) }}</span>
        </div>
    </div>

    <!-- 8 INCOME SUMMARY KPI TILES (2-COLUMN GRID ON MOBILE) -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
        
        <!-- 1. ROI -->
        <a href="{{ route('admin.reports.roi') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">Daily ROI Yield</span>
                <i data-lucide="trending-up" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($roiTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>0.5% - 1.5% Daily Yield</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 2. Direct Income -->
        <a href="{{ route('admin.reports.direct') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">Direct Income (10%)</span>
                <i data-lucide="user-check" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($directTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>10% Flat Referral Share</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 3. Booster Bonus -->
        <a href="{{ route('admin.reports.bonus') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">24H Special Bonus</span>
                <i data-lucide="gift" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($bonusTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>5 Directs in 24 Hours</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 4. Level Income -->
        <a href="{{ route('admin.reports.level') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-teal-400 uppercase tracking-wider">Level Income (10 Levels)</span>
                <i data-lucide="layers" class="w-4 h-4 text-teal-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($levelTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>10-Tier Team Commissions</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 5. Matching Income -->
        <a href="{{ route('admin.reports.matching') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">Matching Income (5%)</span>
                <i data-lucide="git-merge" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($matchingTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>50:50 Power Leg Ratio</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 6. Direct Salary -->
        <a href="{{ route('admin.reports.direct-salary') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">Direct Salary Income</span>
                <i data-lucide="banknote" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($directSalaryTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>365 Days Daily Salary</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 7. Team Salary -->
        <a href="{{ route('admin.reports.team-salary') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">Team Salary Income</span>
                <i data-lucide="users" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($teamSalaryTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>12 Months Monthly Salary</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

        <!-- 8. Reward Income -->
        <a href="{{ route('admin.reports.rewards') }}" class="group bg-panel p-4 rounded-2xl border border-amber-500/30 hover:border-amber-400 shadow-lg transition block">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider">Reward Income (10%)</span>
                <i data-lucide="trophy" class="w-4 h-4 text-amber-400 group-hover:scale-110 transition"></i>
            </div>
            <p class="text-xl font-black text-white font-mono">${{ number_format($rewardTotal, 2) }}</p>
            <p class="text-[10px] text-neutral-400 mt-1 flex items-center justify-between">
                <span>10% Milestone Rewards</span>
                <span class="text-amber-400 group-hover:underline">View Audit &rarr;</span>
            </p>
        </a>

    </div>

    <!-- RECENT SYSTEM-WIDE INCOME PAYOUT AUDIT LOG -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-4">
        <div class="flex items-center justify-between border-b border-amber-500/20 pb-3">
            <h3 class="text-sm font-black text-white uppercase tracking-wider">Recent Income Payout Transactions</h3>
            <span class="text-xs text-amber-400 font-mono">Live Audit Trail</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl">TXN NUMBER</th>
                        <th class="p-4">INCOME EARNER</th>
                        <th class="p-4">SOURCE / SPONSOR</th>
                        <th class="p-4">INCOME TYPE</th>
                        <th class="p-4">AMOUNT ($)</th>
                        <th class="p-4">POST BALANCE</th>
                        <th class="p-4">DATE & TIME</th>
                        <th class="p-4 rounded-r-xl">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($recentIncomes as $log)
                    <tr class="hover:bg-amber-500/10 transition">
                        <td class="p-4 font-mono font-bold text-amber-400 text-xs">{{ $log->txn_number }}</td>
                        <!-- INCOME EARNER -->
                        <td class="p-4">
                            @if($log->user)
                                <a href="{{ route('admin.users.show', $log->user->id) }}" class="group block">
                                    <div class="font-bold text-white group-hover:text-amber-400 transition text-xs">{{ $log->user->name }}</div>
                                    <div class="text-[11px] text-amber-400 font-mono font-bold">{{ $log->user->referral_code }}</div>
                                </a>
                            @else
                                <span class="text-neutral-500 italic text-xs">Deleted Earner</span>
                            @endif
                        </td>

                        <!-- SOURCE / SPONSOR DETAILS -->
                        <td class="p-4">
                            @if($log->type === 'direct_commission' && $log->source_member)
                                <a href="{{ route('admin.users.show', $log->source_member->id) }}" class="group block">
                                    <div class="font-bold text-neutral-200 group-hover:text-amber-400 transition text-xs">{{ $log->source_member->name }}</div>
                                    <div class="text-[11px] text-amber-400/80 font-mono font-bold">{{ $log->source_member->referral_code }}</div>
                                </a>
                            @elseif($log->user && $log->user->sponsor)
                                <a href="{{ route('admin.users.show', $log->user->sponsor->id) }}" class="group block">
                                    <div class="font-bold text-neutral-200 group-hover:text-amber-400 transition text-xs">{{ $log->user->sponsor->name }}</div>
                                    <div class="text-[11px] text-amber-400/80 font-mono">{{ $log->user->sponsor->referral_code }}</div>
                                </a>
                            @else
                                <span class="text-neutral-500 italic text-xs">No Sponsor</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-500/10 text-amber-300 border border-amber-500/30">
                                {{ str_replace('_', ' ', $log->type) }}
                            </span>
                        </td>
                        <td class="p-4 font-mono font-black text-emerald-400">+${{ number_format($log->amount, 2) }}</td>
                        <td class="p-4 font-mono text-neutral-300">${{ number_format($log->post_balance, 2) }}</td>
                        <td class="p-4 text-xs text-neutral-400 font-mono">{{ $log->created_at->format('M d, Y h:i A') }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase">
                                Completed
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-neutral-400 font-medium">
                            No income transactions recorded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentIncomes->hasPages())
        <div class="pt-4 border-t border-amber-500/20">
            {{ $recentIncomes->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
