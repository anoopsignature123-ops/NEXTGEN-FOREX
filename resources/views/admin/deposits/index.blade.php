@extends('admin.layouts.app')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Banner (Matching User Management Module Exactly) -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">DM</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX NETWORK</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">MEMBER DEPOSIT HISTORY AUDIT</h1>
            <p class="text-xs text-neutral-300 mt-1">Audit USDT (BEP20) instant deposits credited to member deposit wallets.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 text-xs font-bold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-500/20 border border-rose-500/50 text-rose-300 text-xs font-bold flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Main Container Panel (Matching User Management Panel) -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        
        <!-- Filter Bar with JS Datepicker & Search in 1 Single Row -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-end justify-between gap-4 border-b border-amber-500/20 pb-4">
            
            <!-- Title Label -->
            <div class="flex items-center gap-2 text-xs font-black text-amber-400 uppercase tracking-wider">
                <i data-lucide="history" class="w-4 h-4 text-amber-400"></i>
                <span>INSTANT DEPOSIT AUDIT LOG</span>
            </div>

            <!-- Date Range & Search Form -->
            <form action="{{ route('admin.deposits.index') }}" method="GET" class="flex flex-nowrap items-end gap-3 overflow-x-auto text-xs font-sans pb-1">
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

                <!-- 3. SEARCH TXN HASH / MEMBER -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">SEARCH MEMBER / HASH</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Member name, code, hash..." class="w-full pl-8 pr-3 py-2 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 4. FILTER BUTTON -->
                <div class="flex items-center gap-2 shrink-0">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow transition flex items-center justify-center gap-1.5 shrink-0">
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-black"></i> FILTER
                    </button>
                    <a href="{{ route('admin.deposits.index') }}" class="py-2 px-3 rounded-xl bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400 font-bold text-xs transition flex items-center justify-center shrink-0">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- DEPOSIT HISTORY TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl">USER DETAILS</th>
                        <th class="p-4">AMOUNT ($)</th>
                        <th class="p-4">GATEWAY</th>
                        <th class="p-4">TRANSACTION HASH</th>
                        <th class="p-4">DEPOSIT DATE & TIME</th>
                        <th class="p-4 rounded-r-xl">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($deposits as $dep)
                    <tr class="hover:bg-amber-500/10 transition">
                        <!-- User Info -->
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow-md shrink-0">
                                    {{ strtoupper(substr($dep->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.show', $dep->user->id ?? 1) }}" class="font-black text-white hover:text-amber-300 transition text-xs block font-heading">{{ $dep->user->name ?? 'Unknown User' }}</a>
                                    <div class="text-[10px] text-neutral-400 font-mono">{{ $dep->user->email ?? '' }}</div>
                                    <div class="text-[10px] text-amber-400 font-mono">{{ $dep->user->referral_code ?? '' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="p-4 font-mono font-black text-emerald-400 text-base">
                            ${{ number_format($dep->amount, 2) }}
                        </td>

                        <!-- Gateway -->
                        <td class="p-4 font-bold text-amber-300 text-xs">
                            {{ $dep->payment_gateway }}
                        </td>

                        <!-- Hash -->
                        <td class="p-4 font-mono text-xs text-neutral-300">
                            <span class="truncate inline-block max-w-[180px] font-bold text-amber-400" title="{{ $dep->txn_hash }}">{{ $dep->txn_hash }}</span>
                        </td>

                        <!-- Date -->
                        <td class="p-4">
                            <div class="text-xs font-semibold text-white">{{ $dep->created_at ? $dep->created_at->format('M d, Y') : 'N/A' }}</div>
                            <div class="text-[10px] text-neutral-400 font-mono">{{ $dep->created_at ? $dep->created_at->format('h:i A') : '' }}</div>
                        </td>

                        <!-- Status -->
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase tracking-wider flex items-center gap-1 w-fit">
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-400"></i> INSTANT CREDITED
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-neutral-400 text-sm font-semibold">
                            No deposit records found in history.
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
