@extends('admin.layouts.app')

@section('title', 'Withdrawal Requests Audit')

@section('content')
        <div class="w-full space-y-6 font-sans">

            <!-- PAGE HEADER -->
            <div
                class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-amber-400 uppercase tracking-widest mb-1">
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-amber-400"></i>
                        <span>Financial Payout Audit</span>
                    </div>
                    <h1 class="text-2xl font-black font-heading text-white uppercase tracking-wider">
                        Withdrawal Requests Audit
                    </h1>
                    <p class="text-xs text-neutral-400 mt-1">3-Step Lifecycle Audit: Pending → Approved → Completed (with
                        instant 10% deduction & USDT BEP20 tracking)</p>
                    </div>

                    <div class="flex items-center gap-3">
                        @if($pendingCount > 0)
                        <span class="px-4 py-2 rounded-xl bg-amber-500 text-black font-black text-xs uppercase animate-pulse shadow-lg">
                            {{ $pendingCount }} PENDING REQUESTS
                        </span>
                    @endif
                        @if($approvedCount > 0)
                            <span class="px-4 py-2 rounded-xl bg-sky-500 text-white font-black text-xs uppercase shadow-lg">
                                {{ $approvedCount }} APPROVED (AWAITING TRANSFER)
                            </span>
                        @endif
                        </div>
                        </div>

            <!-- SUMMARY KPI TILES (2-COLUMN GRID ON MOBILE) -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                <!-- 1. PENDING -->
                <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center shrink-0">
                        <i data-lucide="clock" class="w-6 h-6 text-amber-400"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-amber-400/80 uppercase">Pending Requests</p>
                        <p class="text-2xl font-black text-white font-mono mt-0.5">{{ number_format($pendingCount) }}</p>
                    </div>
                    </div>

                <!-- 2. APPROVED -->
                <div class="bg-panel p-5 rounded-2xl border border-sky-500/30 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-500/20 border border-sky-500/40 flex items-center justify-center shrink-0">
                        <i data-lucide="check-circle" class="w-6 h-6 text-sky-400"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-sky-400/80 uppercase">Approved Requests</p>
                        <p class="text-2xl font-black text-sky-300 font-mono mt-0.5">{{ number_format($approvedCount) }}</p>
                    </div>
                    </div>

                <!-- 3. COMPLETED PAYOUTS -->
                <div class="bg-panel p-5 rounded-2xl border border-emerald-500/30 shadow-xl flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center shrink-0">
                        <i data-lucide="check-check" class="w-6 h-6 text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-emerald-400/80 uppercase">Total Net Payouts Paid</p>
                        <p class="text-2xl font-black text-emerald-400 font-mono mt-0.5">${{ number_format($approvedSum, 2) }}
                        </p>
                        </div>
                        </div>

                <!-- 4. DEDUCTIONS -->
                <div class="bg-panel p-5 rounded-2xl border border-rose-500/30 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-500/20 border border-rose-500/40 flex items-center justify-center shrink-0">
                        <i data-lucide="scissors" class="w-6 h-6 text-rose-400"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-rose-400/80 uppercase">10% Service Deductions</p>
                        <p class="text-2xl font-black text-rose-300 font-mono mt-0.5">
                            ${{ number_format($totalDeductionsSum, 2) }}</p>
                        </div>
                        </div>
                        </div>

            <!-- TABLE & FILTER CARD CONTAINER -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">

                <!-- STATUS FILTER TABS & SEARCH BAR ROW -->
                <div
                    class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 border-b border-amber-500/20 pb-4">

                    <!-- Quick Status Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('admin.withdrawals.index') }}"
                            class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                            <i data-lucide="layers" class="w-3.5 h-3.5"></i> All
                        </a>

                        <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}"
                            class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> Pending
                            @if($pendingCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-rose-500 text-white animate-pulse">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('admin.withdrawals.index', ['status' => 'approved']) }}"
                            class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-sky-500 text-white font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-sky-400' }}">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Approved
                            @if($approvedCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-sky-600 text-white">
                                    {{ $approvedCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('admin.withdrawals.index', ['status' => 'completed']) }}"
                            class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'completed' ? 'bg-emerald-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-emerald-400' }}">
                            <i data-lucide="check-check" class="w-3.5 h-3.5"></i> Completed
                        </a>

                        <a href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}"
                            class="whitespace-nowrap inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/50 font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-rose-400' }}">
                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Rejected
                        </a>
                        </div>

                    <!-- Date Range & Search Form -->
                    <form action="{{ route('admin.withdrawals.index') }}" method="GET"
                        class="flex flex-nowrap items-end gap-3 overflow-x-auto text-xs font-sans pb-1">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <!-- 1. FROM DATE -->
                        <div class="w-36 shrink-0">
                            <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">FROM
                                DATE</label>
                            <div class="relative">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                                <input type="text" name="start_date" value="{{ request('start_date') }}" placeholder="YYYY-MM-DD"
                                    class="datepicker w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                                </div>
                                </div>

                        <!-- 2. TO DATE -->
                        <div class="w-36 shrink-0">
                            <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">TO
                                DATE</label>
                            <div class="relative">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                                <input type="text" name="end_date" value="{{ request('end_date') }}" placeholder="YYYY-MM-DD"
                                    class="datepicker w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                                </div>
                                </div>

                        <!-- 3. SEARCH MEMBER / TXN # -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">SEARCH
                                MEMBER / TXN #</label>
                            <div class="relative">
                                <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, code, WD-..."
                                    class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                                </div>
                                </div>

                        <!-- 4. BUTTONS -->
                        <div class="flex items-center gap-2 shrink-0">
                            <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-[0_0_15px_rgba(243,202,82,0.5)] transition flex items-center justify-center gap-1.5 shrink-0">
                                <i data-lucide="filter" class="w-3.5 h-3.5 text-black"></i> FILTER
                            </button>
                            <a href="{{ route('admin.withdrawals.index') }}"
                                class="py-2.5 px-4 rounded-xl bg-black/60 border border-white/60 text-white hover:bg-white/10 font-bold text-xs transition flex items-center justify-center shrink-0">
                                Reset
                            </a>
                            </div>
                            </form>
                            </div>

                <!-- BULK ACTIONS TOOLBAR -->
                <form id="bulkActionForm" method="POST" action="">
                    @csrf
                    <div
                        class="p-3.5 mb-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="selectAll"
                                class="w-4 h-4 rounded border-amber-500/40 bg-black/60 text-amber-400 focus:ring-amber-400 cursor-pointer">
                            <label for="selectAll" class="text-xs font-bold text-amber-300 cursor-pointer uppercase tracking-wider">Select All
                                Pending / Approved Requests</label>
                            </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <button type="button"
                                onclick="showBulkModal()"
                                class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                                <i data-lucide="cpu" class="w-4 h-4 text-black"></i> Smart Contract Payout
                            </button>
                            <button type="button"
                                onclick="submitBulkAction('{{ route('admin.withdrawals.bulk-approve') }}', 'Approve all selected pending withdrawal requests? (Status: Pending → Approved)')"
                                class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                                <i data-lucide="check" class="w-4 h-4"></i> Bulk Approve
                            </button>
                            {{-- <button type="button"
                                onclick="submitBulkAction('{{ route('admin.withdrawals.bulk-complete') }}', 'Mark all selected withdrawal requests as Completed? (Status: Approved → Completed)')"
                                class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-black font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                                <i data-lucide="check-check" class="w-4 h-4"></i> Bulk Mark Completed
                            </button> --}}
                            <button type="button"
                                onclick="submitBulkAction('{{ route('admin.withdrawals.bulk-reject') }}', 'Reject selected withdrawal requests and refund amounts back to user earning wallets?')"
                                class="px-4 py-2 rounded-xl bg-rose-500/20 border border-rose-500/50 hover:bg-rose-500 text-rose-300 hover:text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                                <i data-lucide="x-circle" class="w-4 h-4"></i> Bulk Reject
                            </button>
                            </div>
                            </div>

                    <!-- WITHDRAWAL REQUESTS AUDIT TABLE -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead
                                class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
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
                                            @if(in_array($w->status, ['pending', 'approved']))
                                                <input type="checkbox" name="withdrawal_ids[]" value="{{ $w->id }}"
                                                    data-wallet="{{ $w->usdt_address ?: ($w->user->wallet_address ?? '') }}"
                                                    data-amount="{{ $w->net_amount }}"
                                                    data-user="{{ $w->user->name ?? 'User' }}"
                                                    class="withdrawal-checkbox w-4 h-4 rounded border-amber-500/40 bg-black/60 text-amber-400 focus:ring-amber-400 cursor-pointer">
                                            @else
                                                <span class="text-neutral-600 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="p-4 font-mono font-bold text-amber-400 text-xs">{{ $w->trx_number }}</td>

                                        <!-- Member Profile -->
                                        <td class="p-4">
                                            @if($w->user)
                                                <a href="{{ route('admin.users.show', $w->user->id) }}"
                                                    class="flex items-center gap-2.5 group">
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow shrink-0">
                                                        {{ strtoupper(substr($w->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="font-black text-white group-hover:text-amber-300 transition text-xs">
                                                            {{ $w->user->name }}</div>
                                                        <div class="text-[10px] text-amber-400 font-mono">{{ $w->user->referral_code }}
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <span class="text-neutral-500 italic">User Deleted</span>
                                            @endif
                                        </td>

                                        <td class="p-4 font-mono font-black text-white">${{ number_format($w->amount, 2) }}</td>
                                        <td class="p-4 font-mono font-bold text-rose-400">-${{ number_format($w->charge, 2) }}</td>
                                        <td class="p-4 font-mono font-black text-emerald-400 text-base">
                                            ${{ number_format($w->net_amount, 2) }}</td>
                                        <td class="p-4 font-mono text-xs text-amber-300 max-w-xs truncate"
                                            title="{{ $w->usdt_address ?: ($w->user->wallet_address ?? 'N/A') }}">
                                            <div>{{ $w->usdt_address ?: ($w->user->wallet_address ?? 'N/A') }}</div>
                                            @if($w->txn_hash)
                                                <div class="text-[10px] text-emerald-400 font-mono mt-0.5 truncate" title="{{ $w->txn_hash }}">Hash: {{ $w->txn_hash }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-4 text-xs text-neutral-400 font-mono">
                                            {{ $w->created_at->format('M d, Y h:i A') }}
                                        </td>

                                        <!-- Status -->
                                        <td class="p-4">
                                            @if($w->status === 'completed')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase inline-flex items-center gap-1">
                                                    <i data-lucide="check-check" class="w-3 h-3 text-emerald-400"></i> COMPLETED
                                                </span>
                                            @elseif($w->status === 'approved')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-black bg-sky-500/20 text-sky-300 border border-sky-500/40 uppercase inline-flex items-center gap-1">
                                                    <i data-lucide="check-circle" class="w-3 h-3 text-sky-400"></i> APPROVED
                                                </span>
                                            @elseif($w->status === 'rejected')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-500/20 text-rose-300 border border-rose-500/40 uppercase"
                                                    title="{{ $w->admin_remark }}">
                                                    REJECTED (REFUNDED)
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-500/20 text-amber-300 border border-amber-500/40 uppercase animate-pulse inline-flex items-center gap-1">
                                                    <i data-lucide="clock" class="w-3 h-3 text-amber-400"></i> PENDING
                                                </span>
                                            @endif
                                                </td>

                                        <!-- ACTION BUTTONS (MATCHING FUNEARN) -->
                                        <td class="p-4 text-center">
                                            @if($w->status === 'pending')
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="submit" formaction="{{ route('admin.withdrawals.approve', $w->id) }}"
                                                        onclick="return confirm('Approve withdrawal request {{ $w->trx_number }}?');"
                                                        class="p-2 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-black border border-emerald-500/40 font-bold text-xs transition flex items-center justify-center shadow" title="Approve Request">
                                                        <i data-lucide="check" class="w-4 h-4"></i>
                                                    </button>

                                                    <button type="button" onclick="showRejectModal({{ $w->id }})"
                                                        class="p-2 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 font-bold text-xs transition flex items-center justify-center shadow"
                                                    title="Reject & Refund">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @elseif($w->status === 'approved')
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="showRejectModal({{ $w->id }})"
                                                        class="p-2 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 font-bold text-xs transition flex items-center justify-center shadow"
                                                    title="Reject & Refund">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @elseif($w->status === 'completed')
                                                <span class="text-emerald-400 font-bold text-xs flex items-center justify-center gap-1">
                                                    <i data-lucide="check-check" class="w-3.5 h-3.5"></i> Completed
                                                </span>
                                            @else
                                                <span class="text-rose-400 font-bold text-xs flex items-center justify-center gap-1">
                                                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Refunded
                                                </span>
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
    @if($withdrawals->count() > 0)
        <tfoot class="bg-bg/80 font-bold border-t border-amber-500/30 text-xs">
            <tr>
                <td colspan="3" class="p-3 text-right uppercase text-amber-400 font-extrabold tracking-wider">SUBTOTAL:</td>
                <td class="p-3 text-white font-mono text-sm">${{ number_format($withdrawals->sum('amount'), 2) }}</td>
                <td class="p-3 text-rose-400 font-mono text-xs">-${{ number_format($withdrawals->sum('charge'), 2) }}</td>
                <td class="p-3 text-emerald-400 font-mono text-sm font-black">
                    ${{ number_format($withdrawals->sum('net_amount'), 2) }}</td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    @endif
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

        <!-- BULK SMART CONTRACT MODAL -->
        <div id="bulkModal"
            class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-panel border border-amber-500/40 rounded-2xl w-full max-w-2xl p-6 space-y-5 shadow-2xl text-white">
                <div class="flex items-center justify-between border-b border-amber-500/20 pb-3">
                    <h3 class="text-base font-black text-amber-400 uppercase font-heading flex items-center gap-2">
                        <i data-lucide="cpu" class="w-5 h-5 text-amber-400"></i> Smart Contract Payout (NextGen Forex)
                    </h3>
                    <button type="button" onclick="closeBulkModal()"
                        class="text-neutral-400 hover:text-white text-xl font-bold">&times;</button>
                </div>

                <!-- Step 1: Confirmation Table -->
                <div id="stepConfirm" class="space-y-4">
                    <p class="text-xs text-neutral-300">Confirm selected withdrawal requests to process via Smart Contract:
                        <code class="text-amber-400 font-mono text-[11px]">0xEe77...81f2</code>
                    </p>
                    <div class="max-h-60 overflow-y-auto border border-amber-500/20 rounded-xl">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-bg text-amber-400 uppercase font-bold sticky top-0">
                                <tr>
                                    <th class="p-2.5">ID</th>
                                    <th class="p-2.5">User</th>
                                    <th class="p-2.5">Wallet Address</th>
                                    <th class="p-2.5 text-right">Net Amount</th>
                                </tr>
                            </thead>
                            <tbody id="confirmRows" class="divide-y divide-amber-500/10"></tbody>
                            <tfoot class="bg-bg/80 font-bold border-t border-amber-500/30">
                                <tr>
                                    <td colspan="3" class="p-2.5 text-right uppercase text-neutral-400">Total Net Payout:</td>
                                    <td id="modalTotal" class="p-2.5 text-right font-mono text-emerald-400 font-black text-sm">
                                        $0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-[11px] text-amber-300 flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 text-amber-400"></i>
                        <span>Ensure MetaMask is connected to BSC Network with sufficient BNB gas balance.</span>
                    </div>
                </div>

                <!-- Step 2: Processing Spinner -->
                <div id="stepProcessing" class="hidden text-center py-8 space-y-3">
                    <div class="w-12 h-12 border-4 border-amber-400 border-t-transparent rounded-full animate-spin mx-auto">
                    </div>
                    <h4 id="procTitle" class="text-sm font-bold text-white">Connecting MetaMask...</h4>
                    <p id="procSub" class="text-xs text-neutral-400">Please confirm transaction in your Web3 wallet</p>
                </div>

                <!-- Step 3: Success Banner -->
                <div id="stepSuccess" class="hidden text-center py-6 space-y-3">
                    <div
                        class="w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center mx-auto text-2xl">
                        ✓</div>
                    <h4 class="text-base font-black text-emerald-400">Bulk Withdrawal Completed!</h4>
                    <p class="text-xs text-neutral-300">Txn Hash: <code id="txHash"
                            class="text-amber-300 font-mono block break-all text-[11px] mt-1"></code></p>
                    <a id="bscLink" href="#" target="_blank"
                        class="inline-flex items-center gap-1 text-xs text-amber-400 hover:underline font-bold">View on BscScan
                        &rarr;</a>
                </div>

                <!-- Step 4: Error Banner -->
                <div id="stepError" class="hidden text-center py-6 space-y-3">
                    <div
                        class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/40 flex items-center justify-center mx-auto text-2xl">
                        ✕</div>
                    <h4 class="text-base font-black text-rose-400">Transaction Failed</h4>
                    <p id="errMsg" class="text-xs text-neutral-300 font-mono"></p>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 border-t border-amber-500/20 pt-4">
                    <button type="button" onclick="closeBulkModal()" id="btnClose"
                        class="px-4 py-2 rounded-xl bg-black/60 border border-neutral-500/40 text-neutral-300 font-bold text-xs">Close</button>
                    <button type="button" id="btnProcess" onclick="processWithdrawal()"
                        class="px-5 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 text-black font-black text-xs uppercase tracking-wider shadow-lg flex items-center gap-1.5">
                        <i data-lucide="wallet" class="w-4 h-4 text-black"></i> Connect Wallet & Process
                    </button>
                </div>
            </div>
        </div>

        <!-- REJECT & REFUND MODAL (MATCHING FUNEARN) -->
        <div id="rejectModal"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
            <form id="rejectForm" method="POST" action=""
            class="w-full max-w-md bg-panel border border-rose-500/40 rounded-2xl p-6 space-y-4 shadow-2xl text-white">
                @csrf
                <div class="flex items-center justify-between border-b border-rose-500/20 pb-3">
                    <h3 class="text-base font-black text-rose-400 uppercase font-heading flex items-center gap-2">
                        <i data-lucide="x-circle" class="w-5 h-5 text-rose-400"></i> Reject Withdrawal
                    </h3>
                    <button type="button" onclick="closeRejectModal()"
                    class="text-neutral-400 hover:text-white text-xl font-bold">&times;</button>
                </div>
                <div>
                    <label class="block text-xs font-bold text-neutral-300 uppercase tracking-wider mb-1">Rejection Reason
                    *</label>
                    <textarea name="admin_remark" rows="3" required placeholder="Provide a reason for rejection..."
                    class="w-full p-3 rounded-xl bg-black/60 border border-rose-500/40 text-white font-mono text-xs focus:outline-none focus:border-rose-400"></textarea>
                </div>
                <div class="flex items-center justify-end gap-3 border-t border-rose-500/20 pt-3">
                    <button type="button" onclick="closeRejectModal()"
                    class="px-4 py-2 rounded-xl bg-black/60 border border-neutral-500/40 text-neutral-300 font-bold text-xs">Cancel</button>
                    <button type="submit"
                    class="px-5 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-black text-xs uppercase tracking-wider shadow-lg">Confirm
                    Reject & Refund</button>
                </div>
            </form>
        </div>

        <!-- HIDDEN FORM FOR COMPLETING WITH TXN HASH -->
        <form id="completeActionForm" method="POST" action="" class="hidden">
            @csrf
            <input type="hidden" name="txn_hash" id="completeTxnHash">
            <input type="hidden" name="admin_remark" id="completeRemark">
        </form>

        <script src="https://cdn.jsdelivr.net/npm/web3@1.8.0/dist/web3.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bignumber.js@9.1.1/bignumber.min.js"></script>
        <script>
            const CONTRACT_ADDRESS = "0xEe7783bC65623EE80b19Cda2B7F2314f811E81f2";
            const CONTRACT_ABI = [
                { "inputs": [{ "internalType": "address", "name": "_usdtTokenAddress", "type": "address" }, { "internalType": "address", "name": "_admin", "type": "address" }, { "internalType": "address", "name": "_FeeAddress", "type": "address" }], "stateMutability": "nonpayable", "type": "constructor" },
                { "inputs": [], "name": "owner", "outputs": [{ "internalType": "address", "name": "", "type": "address" }], "stateMutability": "view", "type": "function" },
                { "inputs": [{ "internalType": "address[]", "name": "recipients", "type": "address[]" }, { "internalType": "uint256[]", "name": "amounts", "type": "uint256[]" }], "name": "withdrawTokens", "outputs": [], "stateMutability": "nonpayable", "type": "function" }
            ];

            let selectedRows = [];

            document.addEventListener('DOMContentLoaded', function () {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.withdrawal-checkbox');

                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    });
                }
            });

            function submitBulkAction(actionUrl, confirmMsg) {
                const checkboxes = document.querySelectorAll('.withdrawal-checkbox:checked');
                if (checkboxes.length === 0) {
                    alert('Please select at least one withdrawal request.');
                    return;
                }

                if (confirm(confirmMsg)) {
                    const form = document.getElementById('bulkActionForm');
                    form.action = actionUrl;
                    form.submit();
                }
            }

            function showRejectModal(id) {
                const form = document.getElementById('rejectForm');
                form.action = '/admin/withdrawals/' + id + '/reject';
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }

            function showBulkModal() {
                const checkboxes = document.querySelectorAll('.withdrawal-checkbox:checked');
                if (checkboxes.length === 0) {
                    alert('Please select at least one withdrawal request for Smart Contract payout.');
                    return;
                }

                selectedRows = [];
                let rowsHtml = '';
                let total = 0;

                checkboxes.forEach(cb => {
                    const id = cb.value;
                    const wallet = cb.dataset.wallet || '';
                    const amount = parseFloat(cb.dataset.amount) || 0;
                    const user = cb.dataset.user || 'User';

                    if (!wallet) {
                        alert(`User ${user} (ID: ${id}) does not have a USDT wallet address.`);
                        return;
                    }

                    selectedRows.push({ id, wallet, amount, user });
                    total += amount;

                    rowsHtml += `<tr>
                        <td class="p-2.5 font-mono text-amber-400">#${id}</td>
                        <td class="p-2.5 font-bold">${user}</td>
                        <td class="p-2.5 font-mono text-neutral-300">${wallet.slice(0, 10)}...${wallet.slice(-8)}</td>
                        <td class="p-2.5 text-right font-mono text-emerald-400 font-bold">$${amount.toFixed(2)}</td>
                    </tr>`;
                });

                if (selectedRows.length === 0) return;

                document.getElementById('confirmRows').innerHTML = rowsHtml;
                document.getElementById('modalTotal').textContent = '$' + total.toFixed(2);

                showStep('confirm');
                document.getElementById('btnProcess').style.display = 'inline-flex';
                document.getElementById('btnProcess').textContent = 'Connect Wallet & Process';
                document.getElementById('btnClose').textContent = 'Close';
                document.getElementById('bulkModal').classList.remove('hidden');
            }

            function closeBulkModal() {
                document.getElementById('bulkModal').classList.add('hidden');
            }

            function showStep(step) {
                ['confirm', 'processing', 'success', 'error'].forEach(s => {
                    const el = document.getElementById('step' + s.charAt(0).toUpperCase() + s.slice(1));
                    if (el) {
                        if (s === step) {
                            el.classList.remove('hidden');
                        } else {
                            el.classList.add('hidden');
                        }
                    }
                });
            }

            function setProc(title, sub) {
                document.getElementById('procTitle').textContent = title;
                document.getElementById('procSub').textContent = sub;
            }

            async function processWithdrawal() {
                try {
                    showStep('processing');
                    document.getElementById('btnProcess').style.display = 'none';

                    setProc('Checking Web3 Provider...', 'Looking for MetaMask or Web3 Wallet');
                    if (typeof window.ethereum === 'undefined') {
                        throw new Error('MetaMask is not installed. Please install MetaMask browser extension.');
                    }

                    setProc('Initializing Web3...', 'Connecting to Blockchain');
                    const web3 = new Web3(window.ethereum);

                    setProc('Requesting Wallet Access...', 'Please approve account connection in MetaMask');
                    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                    const userAccount = accounts[0];

                    setProc('Loading Smart Contract...', 'Connecting to NextGen Forex Payout Contract');
                    const contract = new web3.eth.Contract(CONTRACT_ABI, CONTRACT_ADDRESS);

                    setProc('Preparing Batch Transaction...', 'Converting amounts to wei');
                    const recipients = selectedRows.map(r => r.wallet);
                    const amounts = selectedRows.map(r =>
                        new BigNumber(r.amount).multipliedBy('1000000000000000000').toFixed(0)
                    );

                    setProc('Awaiting Signature...', 'Please confirm batch payout transaction in MetaMask');
                    const tx = await contract.methods.withdrawTokens(recipients, amounts).send({ from: userAccount });
                    const txHash = tx.transactionHash;

                    setProc('Updating Records...', 'Saving batch payout completion to database');
                    await markCompletedBulk(txHash);

                    document.getElementById('txHash').textContent = txHash;
                    document.getElementById('bscLink').href = `https://bscscan.com/tx/${txHash}`;
                    showStep('success');
                    document.getElementById('btnClose').textContent = 'Done';
                    setTimeout(() => window.location.reload(), 3000);

                } catch (err) {
                    console.error(err);
                    document.getElementById('errMsg').textContent = err.message || 'An unexpected error occurred during Web3 transaction.';
                    showStep('error');
                    document.getElementById('btnProcess').style.display = 'inline-flex';
                    document.getElementById('btnProcess').textContent = 'Try Again';
                    document.getElementById('btnClose').textContent = 'Close';
                }
            }

            async function markCompletedBulk(txHash) {
                const ids = selectedRows.map(r => r.id);
                const CSRF_TOKEN = document.querySelector('input[name="_token"]')?.value;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.withdrawals.bulk-complete") }}';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = CSRF_TOKEN;
                form.appendChild(csrfInput);

                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'withdrawal_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }
        </script>
@endsection