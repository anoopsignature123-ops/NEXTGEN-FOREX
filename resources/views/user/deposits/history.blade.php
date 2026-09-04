@extends('user.layouts.app')

@section('content')
<div class="w-full space-y-6">
    
    <!-- Top Header Banner (Matching User Management & Admin Flow Exactly) -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">DH</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX MEMBER PORTAL</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">MY DEPOSIT HISTORY</h1>
            <p class="text-xs text-neutral-300 mt-1">Track status and verification records of all your submitted funding requests.</p>
        </div>

        <a href="{{ route('user.deposits.index') }}" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition shrink-0 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4 text-black"></i> Add Fund Now
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 text-xs font-bold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> {{ session('success') }}
        </div>
    @endif

    <!-- DEPOSIT HISTORY TABLE CONTAINER -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        
        <!-- Filter Bar with JS Datepicker & Search in 1 Single Row -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-end justify-end gap-4 border-b border-amber-500/20 pb-4">

            <!-- Date Range & Search Form (100% MATCHING REFERENCE UI CARD) -->
            <form action="{{ route('user.deposits.history') }}" method="GET" class="flex flex-nowrap items-end gap-3 overflow-x-auto text-xs font-sans pb-1">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <!-- 1. FROM DATE -->
                <div class="w-36 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">FROM DATE</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="start_date" value="{{ request('start_date') }}" placeholder="YYYY-MM-DD" class="datepicker w-full pl-8 pr-3 py-2 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 2. TO DATE -->
                <div class="w-36 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">TO DATE</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="end_date" value="{{ request('end_date') }}" placeholder="YYYY-MM-DD" class="datepicker w-full pl-8 pr-3 py-2 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 3. SEARCH TXN HASH -->
                <div class="min-w-[180px] shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">SEARCH TXN HASH</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Txn Hash..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 4. FILTER ACTIONS -->
                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-[0_0_15px_rgba(243,202,82,0.5)] transition flex items-center justify-center gap-1.5 shrink-0" title="Apply Filter">
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-black"></i> FILTER
                    </button>
                    <a href="{{ route('user.deposits.history') }}" class="py-2 px-3 rounded-xl bg-black/60 border border-white/60 text-white hover:bg-white/10 font-bold text-xs transition flex items-center justify-center shrink-0" title="Reset Filters">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl">AMOUNT ($)</th>
                        <th class="p-4">GATEWAY</th>
                        <th class="p-4">TRANSACTION HASH</th>
                        <th class="p-4">SUBMITTED DATE & TIME</th>
                        <th class="p-4 rounded-r-xl">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($deposits as $dep)
                    <tr class="hover:bg-amber-500/10 transition">
                        <td class="p-4 font-mono font-black text-emerald-400 text-base">
                            ${{ number_format($dep->amount, 2) }}
                        </td>
                        <td class="p-4 font-bold text-amber-300">
                            {{ $dep->payment_gateway }}
                        </td>
                        <td class="p-4 font-mono text-xs text-neutral-300">
                            <span class="truncate inline-block max-w-[200px] text-amber-400 font-bold" title="{{ $dep->txn_hash }}">{{ $dep->txn_hash }}</span>
                        </td>
                        <td class="p-4">
                            <div class="text-xs font-semibold text-white">{{ $dep->created_at ? $dep->created_at->format('M d, Y') : 'N/A' }}</div>
                            <div class="text-[10px] text-neutral-400 font-mono">{{ $dep->created_at ? $dep->created_at->format('h:i A') : '' }}</div>
                        </td>
                        <td class="p-4">
                            @if($dep->status === 'approved')
                                <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">APPROVED</span>
                            @elseif($dep->status === 'rejected')
                                <span class="px-2.5 py-1 rounded bg-rose-500/20 text-rose-300 border border-rose-500/40 text-[10px] font-black uppercase">REJECTED</span>
                            @else
                                <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-black uppercase">PENDING</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-neutral-400 text-sm">
                            You have not submitted any deposit requests yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-amber-500/20">
            {{ $deposits->links() }}
        </div>
    </div>

</div>
@endsection
