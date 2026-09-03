@extends('admin.layouts.app')

@section('title', 'Withdrawal Requests Audit')

@section('content')
<div class="w-full space-y-6 font-sans">
    
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-amber-400 uppercase tracking-widest mb-1">
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-amber-400"></i>
                <span>Financial Payout Audit</span>
            </div>
            <h1 class="text-2xl font-black font-heading text-white uppercase tracking-wider">
                Withdrawal Requests Audit
            </h1>
            <p class="text-xs text-neutral-400 mt-1">Approve or reject member withdrawal requests with instant 10% deduction calculation and USDT (BEP20) transfer tracking</p>
        </div>
        
        <div class="flex items-center gap-3">
            @if($pendingCount > 0)
                <span class="px-4 py-2 rounded-xl bg-rose-500 text-white font-black text-xs uppercase animate-pulse border border-rose-400 shadow-lg">
                    {{ $pendingCount }} PENDING REQUESTS
                </span>
            @endif
        </div>
    </div>

    <!-- SUMMARY KPI TILES -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6 text-amber-400"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-amber-400/80 uppercase">Pending Requests</p>
                <p class="text-2xl font-black text-white font-mono mt-0.5">{{ number_format($pendingCount) }}</p>
            </div>
        </div>

        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-400"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-emerald-400/80 uppercase">Total Net Approved Payouts</p>
                <p class="text-2xl font-black text-emerald-400 font-mono mt-0.5">${{ number_format($approvedSum, 2) }}</p>
            </div>
        </div>

        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-500/20 border border-rose-500/40 flex items-center justify-center shrink-0">
                <i data-lucide="scissors" class="w-6 h-6 text-rose-400"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-rose-400/80 uppercase">Total 10% Service Deductions</p>
                <p class="text-2xl font-black text-rose-300 font-mono mt-0.5">${{ number_format($totalDeductionsSum, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- TABLE & FILTER CARD CONTAINER -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        
        <!-- STATUS FILTER TABS & SEARCH BAR ROW -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 border-b border-amber-500/20 pb-4">
            
            <!-- Quick Status Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.withdrawals.index') }}" class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i> All
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}" class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> Pending
                    @if($pendingCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-rose-500 text-white animate-pulse">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'approved']) }}" class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-emerald-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-emerald-400' }}">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Approved
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}" class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/50 font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-rose-400' }}">
                    <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Rejected
                </a>
            </div>

            <!-- Date Range & Search Form -->
            <form action="{{ route('admin.withdrawals.index') }}" method="GET" class="flex flex-nowrap items-end gap-3 overflow-x-auto text-xs font-sans pb-1">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <!-- 1. FROM DATE -->
                <div class="w-36 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">FROM DATE</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="start_date" value="{{ request('start_date') }}" placeholder="YYYY-MM-DD" class="datepicker w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 2. TO DATE -->
                <div class="w-36 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">TO DATE</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="end_date" value="{{ request('end_date') }}" placeholder="YYYY-MM-DD" class="datepicker w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 3. SEARCH MEMBER / TXN # -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">SEARCH MEMBER / TXN #</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, code, WD-..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 4. BUTTONS -->
                <div class="flex items-center gap-2 shrink-0">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-[0_0_15px_rgba(243,202,82,0.5)] transition flex items-center justify-center gap-1.5 shrink-0">
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-black"></i> FILTER
                    </button>
                    <a href="{{ route('admin.withdrawals.index') }}" class="py-2.5 px-4 rounded-xl bg-black/60 border border-white/60 text-white hover:bg-white/10 font-bold text-xs transition flex items-center justify-center shrink-0">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- BULK ACTIONS TOOLBAR -->
        <form id="bulkActionForm" method="POST" action="">
            @csrf
            <div class="p-3.5 mb-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-amber-500/40 bg-black/60 text-amber-400 focus:ring-amber-400 cursor-pointer">
                    <label for="selectAll" class="text-xs font-bold text-amber-300 cursor-pointer uppercase tracking-wider">Select All Pending Requests</label>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="submitBulkAction('{{ route('admin.withdrawals.bulk-approve') }}', 'Approve all selected withdrawal requests?')" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-black font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                        <i data-lucide="check-check" class="w-4 h-4"></i> Bulk Approve Selected
                    </button>
                    <button type="button" onclick="submitBulkAction('{{ route('admin.withdrawals.bulk-reject') }}', 'Reject all selected withdrawal requests and refund amounts back to user earning wallets?')" class="px-4 py-2 rounded-xl bg-rose-500/20 border border-rose-500/50 hover:bg-rose-500 text-rose-300 hover:text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                        <i data-lucide="x-circle" class="w-4 h-4"></i> Bulk Reject Selected
                    </button>
                </div>
            </div>

            <!-- WITHDRAWAL REQUESTS AUDIT TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                        <tr>
                            <th class="p-4 rounded-l-xl w-10 text-center">#</th>
                            <th class="p-4">TXN NUMBER</th>
                            <th class="p-4">MEMBER PROFILE</th>
                            <th class="p-4">REQUESTED ($)</th>
                            <th class="p-4">10% DEDUCTION</th>
                            <th class="p-4">NET PAYABLE ($)</th>
                            <th class="p-4">USDT (BEP20) ADDRESS</th>
                            <th class="p-4">DATE & TIME</th>
                            <th class="p-4">STATUS</th>
                            <th class="p-4 rounded-r-xl text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                        @forelse($withdrawals as $w)
                        <tr class="hover:bg-amber-500/10 transition">
                            <td class="p-4 text-center">
                                @if($w->status === 'pending')
                                    <input type="checkbox" name="withdrawal_ids[]" value="{{ $w->id }}" class="withdrawal-checkbox w-4 h-4 rounded border-amber-500/40 bg-black/60 text-amber-400 focus:ring-amber-400 cursor-pointer">
                                @else
                                    <span class="text-neutral-600 text-xs">-</span>
                                @endif
                            </td>

                            <td class="p-4 font-mono font-bold text-amber-400 text-xs">{{ $w->trx_number }}</td>
                            
                            <!-- Member Profile -->
                            <td class="p-4">
                                @if($w->user)
                                    <a href="{{ route('admin.users.show', $w->user->id) }}" class="flex items-center gap-2.5 group">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow shrink-0">
                                            {{ strtoupper(substr($w->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-white group-hover:text-amber-300 transition text-xs">{{ $w->user->name }}</div>
                                            <div class="text-[10px] text-amber-400 font-mono">{{ $w->user->referral_code }}</div>
                                        </div>
                                    </a>
                                @else
                                    <span class="text-neutral-500 italic">User Deleted</span>
                                @endif
                            </td>

                            <td class="p-4 font-mono font-black text-white">${{ number_format($w->amount, 2) }}</td>
                            <td class="p-4 font-mono font-bold text-rose-400">-${{ number_format($w->charge, 2) }}</td>
                            <td class="p-4 font-mono font-black text-emerald-400 text-base">${{ number_format($w->net_amount, 2) }}</td>
                            <td class="p-4 font-mono text-xs text-amber-300 max-w-xs truncate" title="{{ $w->usdt_address }}">
                                {{ $w->usdt_address }}
                            </td>
                            <td class="p-4 text-xs text-neutral-400 font-mono">{{ $w->created_at->format('M d, Y h:i A') }}</td>
                            
                            <!-- Status -->
                            <td class="p-4">
                                @if($w->status === 'approved')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase">
                                        APPROVED
                                    </span>
                                @elseif($w->status === 'rejected')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-500/20 text-rose-300 border border-rose-500/40 uppercase" title="{{ $w->admin_remark }}">
                                        REJECTED (REFUNDED)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-500/20 text-amber-300 border border-amber-500/40 uppercase animate-pulse">
                                        PENDING
                                    </span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="p-4 text-center">
                                @if($w->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Approve Button -->
                                        <button type="submit" formaction="{{ route('admin.withdrawals.approve', $w->id) }}" onclick="return confirm('Approve withdrawal of ${{ number_format($w->net_amount, 2) }} to {{ $w->usdt_address }}?');" class="px-3 py-1.5 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-black border border-emerald-500/40 font-bold text-xs transition flex items-center gap-1 shadow">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i> Approve
                                        </button>

                                        <!-- Reject Button -->
                                        <button type="submit" formaction="{{ route('admin.withdrawals.reject', $w->id) }}" onclick="return confirm('Reject withdrawal and refund ${{ number_format($w->amount, 2) }} back to user earning wallet?');" class="px-3 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 font-bold text-xs transition flex items-center gap-1 shadow">
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i> Reject
                                        </button>
                                    </div>
                                @else
                                    <span class="text-neutral-500 text-xs font-semibold">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="p-8 text-center text-neutral-400 text-sm font-semibold">
                                No withdrawal requests found matching your filters.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if($withdrawals->hasPages())
        <div class="pt-4 border-t border-amber-500/20">
            {{ $withdrawals->links() }}
        </div>
        @endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.withdrawal-checkbox');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });
    }
});

function submitBulkAction(actionUrl, confirmMsg) {
    const checkboxes = document.querySelectorAll('.withdrawal-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Please select at least one pending withdrawal request.');
        return;
    }

    if (confirm(confirmMsg)) {
        const form = document.getElementById('bulkActionForm');
        form.action = actionUrl;
        form.submit();
    }
}
</script>
@endsection
