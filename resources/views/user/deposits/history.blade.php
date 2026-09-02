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
        
        <!-- Quick Status Filter Tabs -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-amber-500/20 pb-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('user.deposits.history') }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="wallet" class="w-4 h-4"></i> All Deposits
                </a>
                <a href="{{ route('user.deposits.history', ['status' => 'pending']) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="clock" class="w-4 h-4"></i> ⏳ Pending
                </a>
                <a href="{{ route('user.deposits.history', ['status' => 'approved']) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-emerald-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-emerald-400' }}">
                    <i data-lucide="check-circle" class="w-4 h-4"></i> ✅ Approved
                </a>
                <a href="{{ route('user.deposits.history', ['status' => 'rejected']) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/50 font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-rose-400' }}">
                    <i data-lucide="x-circle" class="w-4 h-4"></i> ❌ Rejected
                </a>
            </div>
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
