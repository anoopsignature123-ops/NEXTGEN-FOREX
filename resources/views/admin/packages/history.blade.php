@extends('admin.layouts.app')

@section('content')
<div class="w-full space-y-6 font-sans">
    <!-- Header Banner -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">IH</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">FINANCIAL REPORT & LOGS</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">PACKAGE INVESTMENT HISTORY</h1>
            <p class="text-xs text-neutral-300 mt-1">Audit member investment contracts, daily ROI yields, 2X cap progress, and status logs across the network.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.packages.index') }}" class="px-4 py-2.5 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-300 font-bold text-xs hover:bg-amber-500/30 transition flex items-center gap-2">
                <i data-lucide="package-check" class="w-4 h-4 text-amber-400"></i> Manage Packages
            </a>
        </div>
    </div>

    <!-- Overview KPI Cards Grid (1 Row, 4 Columns) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Investments Count -->
        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black text-neutral-400 uppercase tracking-wider">Total Investments</span>
                <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="layers" class="w-4 h-4 text-amber-400"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white font-mono">{{ number_format($totalInvestments) }}</div>
            <div class="text-[10px] text-neutral-400">Total contracts purchased to date</div>
        </div>

        <!-- 2. Total Capital Invested -->
        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black text-neutral-400 uppercase tracking-wider">Total Capital Invested</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-4 h-4 text-emerald-400"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-emerald-400 font-mono">${{ number_format($totalCapitalInvested, 2) }}</div>
            <div class="text-[10px] text-neutral-400">Gross volume of active & closed plans</div>
        </div>

        <!-- 3. Total ROI Yield Paid -->
        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black text-neutral-400 uppercase tracking-wider">Total ROI Paid</span>
                <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-4 h-4 text-amber-400"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-amber-300 font-mono">${{ number_format($totalRoiPaid, 2) }}</div>
            <div class="text-[10px] text-neutral-400">Total daily ROI payout distributed</div>
        </div>

        <!-- 4. Active Packages Count -->
        <div class="bg-panel p-5 rounded-2xl border border-amber-500/30 shadow-xl space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black text-neutral-400 uppercase tracking-wider">Active Packages</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center">
                    <i data-lucide="activity" class="w-4 h-4 text-emerald-400"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-emerald-400 font-mono">{{ number_format($activePackagesCount) }}</div>
            <div class="text-[10px] text-neutral-400">Currently earning daily returns</div>
        </div>
    </div>

    <!-- Filter & Table Card Container -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        
        <!-- 1-ROW COMPACT MULTI-FILTER FORM (100% MATCHING REFERENCE UI CARD IMAGE) -->
        <div class="p-3.5 rounded-2xl bg-bg/80 border border-amber-500/40 shadow-lg">
            <form action="{{ route('admin.packages.history') }}" method="GET" class="flex flex-nowrap items-end gap-3 w-full overflow-x-auto text-xs font-sans pb-1">
                
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

                <!-- 3. PACKAGE -->
                <div class="w-44 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">PACKAGE</label>
                    <select name="package_id" class="w-full px-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400 cursor-pointer">
                        <option value="">All Packages</option>
                        @foreach($allPackages as $pkg)
                            <option value="{{ $pkg->id }}" {{ request('package_id') == $pkg->id ? 'selected' : '' }}>
                                {{ $pkg->name }} (${{ number_format($pkg->min_amount) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 4. STATUS -->
                <div class="w-36 shrink-0">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">STATUS</label>
                    <select name="status" class="w-full px-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400 cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- 5. SEARCH MEMBER / TXN # (FLEX-1 TO FILL) -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">SEARCH MEMBER / TXN #</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, code, TXN-..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- 6. FILTER & RESET BUTTONS -->
                <div class="flex items-center gap-2 shrink-0">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-[0_0_15px_rgba(243,202,82,0.5)] transition flex items-center justify-center gap-1.5 shrink-0" title="Apply Filter">
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-black"></i> FILTER
                    </button>
                    <a href="{{ route('admin.packages.history') }}" class="py-2.5 px-4 rounded-xl bg-black/60 border border-white/60 text-white hover:bg-white/10 font-bold text-xs transition flex items-center justify-center shrink-0" title="Reset Filters">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- INVESTMENT HISTORY TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl min-w-[200px]">Member Profile</th>
                        <th class="p-4 min-w-[160px]">Package Name</th>
                        <th class="p-4 min-w-[140px]">Invested Amount</th>
                        <th class="p-4 min-w-[150px]">Daily ROI Yield</th>
                        <th class="p-4 min-w-[170px]">Total Return / 2X Cap</th>
                        <th class="p-4 min-w-[150px]">Purchased Date</th>
                        <th class="p-4 min-w-[120px]">Status</th>
                        <th class="p-4 rounded-r-xl text-center min-w-[120px]">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($investments as $inv)
                    <tr class="hover:bg-amber-500/10 transition">
                        <!-- Member Profile -->
                        <td class="p-4 min-w-[200px]">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow-md shrink-0">
                                    {{ strtoupper(substr($inv->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-black text-white text-sm">{{ $inv->user->name ?? 'Deleted User' }}</div>
                                    <div class="text-xs text-neutral-400">{{ $inv->user->email ?? 'N/A' }}</div>
                                    <div class="text-[11px] text-amber-400 font-mono">{{ $inv->user->referral_code ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Package Name -->
                        <td class="p-4 min-w-[160px]">
                            <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-xs font-black uppercase font-heading block">
                                📦 {{ $inv->package->name ?? 'Investment Plan' }}
                            </span>
                        </td>

                        <!-- Invested Amount -->
                        <td class="p-4 min-w-[140px] font-mono">
                            <div class="text-sm font-black text-emerald-400">${{ number_format($inv->invested_amount, 2) }}</div>
                            <div class="text-[10px] text-neutral-400">Capital Volume</div>
                        </td>

                        <!-- Daily ROI Yield -->
                        <td class="p-4 min-w-[150px] font-mono">
                            <div class="text-xs font-bold text-amber-300">{{ $inv->daily_roi }}% Daily</div>
                            <div class="text-[11px] text-emerald-400 font-bold">${{ number_format($inv->daily_roi_amount, 2) }} / day</div>
                        </td>

                        <!-- Total Return / 2X Cap Progress -->
                        <td class="p-4 min-w-[170px] font-mono">
                            <div class="text-xs font-bold text-amber-400">
                                Paid: <strong class="text-emerald-400 font-black">${{ number_format($inv->paid_roi_amount, 2) }}</strong>
                            </div>
                            <div class="text-[11px] text-neutral-400">
                                Cap: ${{ number_format($inv->total_return_amount, 2) }}
                            </div>
                        </td>

                        <!-- Purchased Date & Time -->
                        <td class="p-4 min-w-[150px]">
                            <div class="text-xs font-semibold text-white">{{ $inv->purchased_at ? $inv->purchased_at->format('M d, Y') : 'N/A' }}</div>
                            <div class="text-[11px] text-neutral-400 font-mono">{{ $inv->purchased_at ? $inv->purchased_at->format('h:i A') : '' }}</div>
                        </td>

                        <!-- Status Badge -->
                        <td class="p-4 min-w-[120px]">
                            @if($inv->status === 'active')
                                <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    ACTIVE
                                </span>
                            @elseif($inv->status === 'completed')
                                <span class="px-2.5 py-1 rounded bg-sky-500/20 text-sky-300 border border-sky-500/40 text-[10px] font-black uppercase tracking-wider w-fit block">
                                    COMPLETED (2X MET)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded bg-rose-500/20 text-rose-300 border border-rose-500/40 text-[10px] font-black uppercase tracking-wider w-fit block">
                                    {{ strtoupper($inv->status) }}
                                </span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td class="p-4 min-w-[120px] text-center">
                            @if($inv->user)
                                <a href="{{ route('admin.users.show', $inv->user->id) }}" class="px-3 py-1.5 rounded-xl border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 transition text-xs font-bold flex items-center justify-center gap-1" title="View Member Profile">
                                    <i data-lucide="user" class="w-3.5 h-3.5 text-amber-400"></i> User Profile
                                </a>
                            @else
                                <span class="text-neutral-500 text-xs">N/A</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-neutral-400 text-sm font-semibold">
                            No investment records found matching your filter parameters.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-2 border-t border-amber-500/20">
            {{ $investments->links() }}
        </div>
    </div>
</div>
@endsection
