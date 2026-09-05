@extends('user.layouts.app')

@section('title', 'My Withdrawal History')

@section('content')
<div class="w-full space-y-6 font-sans">
    
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-amber-400 uppercase tracking-widest mb-1">
                <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                <span>Earning Wallet Payouts</span>
            </div>
            <h1 class="text-2xl font-black font-heading text-white uppercase tracking-wider">
                My Withdrawal History
            </h1>
            <p class="text-xs text-neutral-400 mt-1">Track status, net received amounts, 10% deductions and USDT BEP20 destination addresses</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('user.withdrawals.index') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-black"></i> New Withdrawal
            </a>
        </div>
    </div>

    <!-- SUMMARY KPI TILES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center shrink-0">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-amber-400"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-amber-400/80 uppercase">Total Requested Amount</p>
                <p class="text-2xl font-black text-white font-mono mt-0.5">${{ number_format($totalRequested, 2) }}</p>
            </div>
        </div>

        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-400"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-emerald-400/80 uppercase">Total Net Amount Paid</p>
                <p class="text-2xl font-black text-emerald-400 font-mono mt-0.5">${{ number_format($totalNetPaid, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- TABLE & FILTER CARD CONTAINER -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        
        <!-- 1-ROW COMPACT MULTI-FILTER FORM -->
        <div class="p-3.5 rounded-2xl bg-bg/80 border border-amber-500/40 shadow-lg">
            <form action="{{ route('user.withdrawals.history') }}" method="GET" class="flex flex-nowrap items-end gap-3 w-full overflow-x-auto text-xs font-sans pb-1">
                
                <!-- 1. FROM DATE -->
                <div class="w-40 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">FROM DATE</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="start_date" value="{{ request('start_date') }}" placeholder="YYYY-MM-DD" class="datepicker w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 2. TO DATE -->
                <div class="w-40 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">TO DATE</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="end_date" value="{{ request('end_date') }}" placeholder="YYYY-MM-DD" class="datepicker w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 3. STATUS -->
                <div class="w-36 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">STATUS</label>
                    <select name="status" class="w-full px-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400 cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- 4. SEARCH TXN # / ADDRESS -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">SEARCH TXN # / WALLET</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="WD-..., USDT address" class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 5. BUTTONS -->
                <div class="flex items-center gap-2 shrink-0">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-[0_0_15px_rgba(243,202,82,0.5)] transition flex items-center justify-center gap-1.5 shrink-0">
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-black"></i> FILTER
                    </button>
                    <a href="{{ route('user.withdrawals.history') }}" class="py-2.5 px-4 rounded-xl bg-black/60 border border-white/60 text-white hover:bg-white/10 font-bold text-xs transition flex items-center justify-center shrink-0">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- WITHDRAWAL HISTORY TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl">TXN NUMBER</th>
                        <th class="p-4">REQUESTED ($)</th>
                        <th class="p-4">10% DEDUCTION</th>
                        <th class="p-4">NET PAYABLE ($)</th>
                        <th class="p-4">USDT (BEP20) ADDRESS</th>
                        <th class="p-4">DATE & TIME</th>
                        <th class="p-4 rounded-r-xl">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($withdrawals as $w)
                    <tr class="hover:bg-amber-500/10 transition">
                        <td class="p-4 font-mono font-bold text-amber-400 text-xs">{{ $w->trx_number }}</td>
                        <td class="p-4 font-mono font-black text-white">${{ number_format($w->amount, 2) }}</td>
                        <td class="p-4 font-mono font-bold text-rose-400">-${{ number_format($w->charge, 2) }}</td>
                        <td class="p-4 font-mono font-black text-emerald-400">${{ number_format($w->net_amount, 2) }}</td>
                        <td class="p-4 font-mono text-xs text-neutral-300 max-w-xs truncate" title="{{ $w->usdt_address }}">
                            {{ $w->usdt_address }}
                        </td>
                        <td class="p-4 text-xs text-neutral-400 font-mono">{{ $w->created_at->format('M d, Y h:i A') }}</td>
                        <td class="p-4">
                            @if($w->status === 'completed')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase inline-flex items-center gap-1">
                                    <i data-lucide="check-check" class="w-3 h-3 text-emerald-400"></i> COMPLETED
                                </span>
                            @elseif($w->status === 'approved')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-sky-500/20 text-sky-300 border border-sky-500/40 uppercase inline-flex items-center gap-1">
                                    <i data-lucide="check-circle" class="w-3 h-3 text-sky-400"></i> APPROVED
                                </span>
                            @elseif($w->status === 'rejected')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-500/20 text-rose-300 border border-rose-500/40 uppercase" title="{{ $w->admin_remark }}">
                                    REJECTED (REFUNDED)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-500/20 text-amber-300 border border-amber-500/40 uppercase animate-pulse inline-flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3 text-amber-400"></i> PENDING
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-neutral-400 text-sm font-semibold">
                            No withdrawal records found matching your filters.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($withdrawals->hasPages())
        <div class="pt-4 border-t border-amber-500/20">
            {{ $withdrawals->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
