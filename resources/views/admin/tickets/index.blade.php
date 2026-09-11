@extends('admin.layouts.app')

@section('title', 'Support Tickets Management')

@section('content')
<div class="w-full space-y-6">

    <!-- Top Header Banner (Matching PDF Deep Emerald & Gold Theme) -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">🎧</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">ADMINISTRATIVE HELP DESK</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white font-heading">SUPPORT TICKETS MANAGEMENT</h1>
            <p class="text-xs text-neutral-300 mt-1">Review user support requests, respond to tickets, and resolve customer inquiries.</p>
        </div>

        <div class="px-5 py-2.5 rounded-2xl bg-black/80 border-2 border-amber-400/80 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-xl">
            <i data-lucide="headphones" class="w-4 h-4 text-amber-400"></i>
            <span>{{ $pendingCount }} Pending Attention</span>
        </div>
    </div>

    <!-- 4 KPI SUMMARY CARDS (2-COLUMN GRID ON MOBILE) -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
        <a href="{{ route('admin.tickets.index') }}" class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative overflow-hidden group block">
            <div class="text-[11px] font-extrabold text-neutral-300 uppercase tracking-wider truncate">TOTAL TICKETS</div>
            <h3 class="text-xl sm:text-2xl font-black text-white font-heading mt-0.5">{{ number_format($allCount) }}</h3>
        </a>

        <a href="{{ route('admin.tickets.index', ['status' => 'pending']) }}" class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative overflow-hidden group block">
            <div class="flex justify-between items-center mb-1">
                <span class="text-[11px] font-extrabold text-amber-400 uppercase tracking-wider truncate">PENDING OPEN</span>
                @if($pendingCount > 0)
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                @endif
            </div>
            <h3 class="text-xl sm:text-2xl font-black text-amber-300 font-heading mt-0.5">{{ number_format($pendingCount) }}</h3>
        </a>

        <a href="{{ route('admin.tickets.index', ['status' => 'answered']) }}" class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative overflow-hidden group block">
            <div class="text-[11px] font-extrabold text-emerald-400 uppercase tracking-wider truncate">ANSWERED</div>
            <h3 class="text-xl sm:text-2xl font-black text-emerald-400 font-heading mt-0.5">{{ number_format($answeredCount) }}</h3>
        </a>

        <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="p-3.5 sm:p-4 rounded-2xl pdf-package-card relative overflow-hidden group block">
            <div class="text-[11px] font-extrabold text-neutral-400 uppercase tracking-wider truncate">RESOLVED / CLOSED</div>
            <h3 class="text-xl sm:text-2xl font-black text-neutral-400 font-heading mt-0.5">{{ number_format($closedCount) }}</h3>
        </a>
    </div>

    <!-- MAIN TICKET AUDIT CONTAINER -->
    <div class="p-6 rounded-3xl pdf-package-card space-y-6">
        
        <!-- Filter Tabs & Search Form -->
        <form action="{{ route('admin.tickets.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-amber-500/20">
            
            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto shrink-0 pb-1 sm:pb-0">
                <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ !request('status') ? 'pdf-gold-ribbon shadow-md text-black' : 'bg-black/80 text-neutral-300 border border-amber-500/40 hover:bg-amber-500/10' }}">
                    All ({{$allCount}})
                </a>
                <a href="{{ route('admin.tickets.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ request('status') === 'pending' ? 'pdf-gold-ribbon shadow-md text-black' : 'bg-black/80 text-amber-300 border border-amber-500/40 hover:bg-amber-500/10' }}">
                    Pending ({{$pendingCount}})
                </a>
                <a href="{{ route('admin.tickets.index', ['status' => 'answered']) }}" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ request('status') === 'answered' ? 'pdf-gold-ribbon shadow-md text-black' : 'bg-black/80 text-emerald-300 border border-emerald-500/40 hover:bg-emerald-500/10' }}">
                    Answered ({{$answeredCount}})
                </a>
                <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ request('status') === 'closed' ? 'pdf-gold-ribbon shadow-md text-black' : 'bg-black/80 text-neutral-400 border border-neutral-700 hover:bg-neutral-800' }}">
                    Closed ({{$closedCount}})
                </a>
            </div>

            <!-- Filters & Search -->
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto shrink-0">
                <select name="category" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-black/90 border border-amber-500/40 text-amber-300 text-xs font-bold focus:outline-none cursor-pointer">
                    <option value="">All Categories</option>
                    <option value="deposit" {{ request('category') === 'deposit' ? 'selected' : '' }}>Deposit</option>
                    <option value="withdrawal" {{ request('category') === 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                    <option value="package" {{ request('category') === 'package' ? 'selected' : '' }}>Package</option>
                    <option value="network" {{ request('category') === 'network' ? 'selected' : '' }}>Network</option>
                    <option value="account" {{ request('category') === 'account' ? 'selected' : '' }}>Account</option>
                    <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other</option>
                </select>

                <div class="relative w-full sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ticket #, subject, user..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-black/90 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                </div>
            </div>

        </form>

        <!-- Tickets Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead class="bg-black/80 text-amber-400 uppercase text-[10px] font-bold border-b border-amber-500/30">
                    <tr>
                        <th class="p-3">TICKET #</th>
                        <th class="p-3">MEMBER DETAILS</th>
                        <th class="p-3">SUBJECT & CATEGORY</th>
                        <th class="p-3">PRIORITY</th>
                        <th class="p-3">STATUS</th>
                        <th class="p-3">LAST UPDATE</th>
                        <th class="p-3 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/10 text-neutral-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-amber-500/10 transition group">
                        
                        <!-- Ticket # -->
                        <td class="p-3 font-mono font-black text-amber-400 text-sm">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="hover:underline">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>

                        <!-- Member Details -->
                        <td class="p-3">
                            @if($ticket->user)
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full pdf-gold-badge text-black font-black text-[10px] flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.show', $ticket->user->id) }}" class="font-bold text-white hover:text-amber-300 transition block">
                                        {{ $ticket->user->name }}
                                    </a>
                                    <span class="text-[10px] text-amber-400 font-mono">{{ $ticket->user->referral_code }}</span>
                                </div>
                            </div>
                            @else
                                <span class="text-neutral-500 italic">User Deleted</span>
                            @endif
                        </td>

                        <!-- Subject & Category -->
                        <td class="p-3">
                            <div>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="font-bold text-white text-xs hover:text-amber-300 transition block">
                                    {{ Str::limit($ticket->subject, 35) }}
                                </a>
                                <span class="text-[9px] text-neutral-400 font-mono uppercase bg-black/60 px-2 py-0.5 rounded border border-amber-500/20">
                                    {{ strtoupper($ticket->category) }}
                                </span>
                            </div>
                        </td>

                        <!-- Priority -->
                        <td class="p-3">
                            @if($ticket->priority === 'urgent')
                                <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 border border-rose-500/40 text-[9px] font-black uppercase">URGENT</span>
                            @elseif($ticket->priority === 'high')
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[9px] font-black uppercase">HIGH</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 border border-sky-500/40 text-[9px] font-black uppercase">{{ strtoupper($ticket->priority) }}</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="p-3">
                            @if($ticket->status === 'open' || $ticket->status === 'user_reply')
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/50 text-[9px] font-black uppercase animate-pulse">
                                    PENDING REPLY
                                </span>
                            @elseif($ticket->status === 'answered')
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/50 text-[9px] font-black uppercase">
                                    ANSWERED
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 text-[9px] font-black uppercase">
                                    CLOSED
                                </span>
                            @endif
                        </td>

                        <!-- Last Update -->
                        <td class="p-3 font-mono text-[11px] text-neutral-400">
                            {{ $ticket->updated_at ? $ticket->updated_at->diffForHumans() : 'N/A' }}
                        </td>

                        <!-- Action -->
                        <td class="p-3 text-right">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="px-3 py-1.5 rounded-lg pdf-gold-ribbon text-[10px] font-black uppercase tracking-wider inline-flex items-center gap-1 shadow">
                                <span>Audit & Reply</span>
                                <i data-lucide="chevron-right" class="w-3 h-3 text-black"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-neutral-400 font-medium">
                            No support tickets found in system.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tickets->hasPages())
        <div class="pt-4 border-t border-amber-500/20">
            {{ $tickets->links() }}
        </div>
        @endif

    </div>

</div>
@endsection
