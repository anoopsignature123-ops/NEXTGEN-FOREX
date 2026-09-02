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
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">DEPOSIT REQUESTS MANAGEMENT</h1>
            <p class="text-xs text-neutral-300 mt-1">Review USDT (BEP20) funding requests and credit user deposit wallets.</p>
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
        
        <!-- Status Tabs (Matching User Management Tabs) -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-amber-500/20 pb-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.deposits.index') }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="wallet" class="w-4 h-4"></i> All Deposits
                </a>
                <a href="{{ route('admin.deposits.index', ['status' => 'pending']) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="clock" class="w-4 h-4"></i> ⏳ Pending
                </a>
                <a href="{{ route('admin.deposits.index', ['status' => 'approved']) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-emerald-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-emerald-400' }}">
                    <i data-lucide="check-circle" class="w-4 h-4"></i> ✅ Approved
                </a>
                <a href="{{ route('admin.deposits.index', ['status' => 'rejected']) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/50 font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-rose-400' }}">
                    <i data-lucide="x-circle" class="w-4 h-4"></i> ❌ Rejected
                </a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl">USER DETAILS</th>
                        <th class="p-4">AMOUNT ($)</th>
                        <th class="p-4">GATEWAY</th>
                        <th class="p-4">TRANSACTION HASH</th>
                        <th class="p-4">SUBMITTED DATE & TIME</th>
                        <th class="p-4">STATUS</th>
                        <th class="p-4 rounded-r-xl text-center">DIRECT ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($deposits as $dep)
                    <tr class="hover:bg-amber-500/10 transition">
                        <!-- User Info -->
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                                    {{ strtoupper(substr($dep->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-black text-white text-sm">{{ $dep->user->name ?? 'Unknown User' }}</div>
                                    <div class="text-xs text-neutral-400">{{ $dep->user->email ?? '' }}</div>
                                    <div class="text-xs text-amber-400 font-mono">{{ $dep->user->referral_code ?? '' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="p-4 font-mono font-black text-emerald-400 text-base">
                            ${{ number_format($dep->amount, 2) }}
                        </td>

                        <!-- Gateway -->
                        <td class="p-4 font-bold text-amber-300">
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
                            @if($dep->status === 'approved')
                                <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">APPROVED</span>
                            @elseif($dep->status === 'rejected')
                                <span class="px-2.5 py-1 rounded bg-rose-500/20 text-rose-300 border border-rose-500/40 text-[10px] font-black uppercase">REJECTED</span>
                            @else
                                <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-black uppercase">PENDING</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="p-4 text-center">
                            @if($dep->status === 'pending')
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('admin.deposits.approve', $dep->id) }}" method="POST" onsubmit="return confirm('Approve deposit of ${{ number_format($dep->amount, 2) }} and credit user wallet?')">
                                        @csrf
                                        <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-emerald-500 text-black text-xs font-black uppercase hover:bg-emerald-400 transition shadow">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.deposits.reject', $dep->id) }}" method="POST" onsubmit="return confirm('Reject this deposit request?')">
                                        @csrf
                                        <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-rose-500/20 border border-rose-500/50 text-rose-300 text-xs font-bold hover:bg-rose-500/40 transition">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-neutral-400 italic">Processed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-neutral-400 text-sm">
                            No deposit requests found.
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
