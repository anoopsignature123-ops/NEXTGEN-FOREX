@extends('admin.layouts.app')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Banner -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">UM</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX NETWORK</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">USER MANAGEMENT MODULE</h1>
            <p class="text-xs text-neutral-300 mt-1">Inspect registered accounts, binary leg placements, referral links, and member actions.</p>
        </div>

        <!-- Right Side Header Controls -->
        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <a href="{{ route('admin.users.create') }}" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center gap-2 shrink-0">
                <i data-lucide="user-plus" class="w-4 h-4 text-black"></i> ADD NEW USER
            </a>

            <!-- Search Form with Real-time & Debounce Search -->
            <form id="userSearchForm" action="{{ route('admin.users') }}" method="GET" class="flex items-center gap-2 flex-1 lg:flex-none">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request('position'))
                    <input type="hidden" name="position" value="{{ request('position') }}">
                @endif

                <div class="relative flex-1 lg:w-72">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                    <input type="text" id="liveSearchInput" name="search" value="{{ request('search') }}" placeholder="Search name, email, code..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400">
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-300 font-bold text-xs hover:bg-amber-500/30 transition flex items-center gap-1.5 shrink-0">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Status Filter Tabs & Table Container -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        <!-- Top Status Tabs & Leg Filters -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-amber-500/20 pb-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.users', array_merge(request()->except('status'), ['status' => ''])) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-amber-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-amber-400' }}">
                    <i data-lucide="users" class="w-4 h-4"></i> All Users
                </a>
                <a href="{{ route('admin.users', array_merge(request()->except('status'), ['status' => 'active'])) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'active' ? 'bg-emerald-500 text-black font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-emerald-400' }}">
                    <i data-lucide="user-check" class="w-4 h-4"></i> Active Users
                </a>
                <a href="{{ route('admin.users', array_merge(request()->except('status'), ['status' => 'inactive'])) }}" class="whitespace-nowrap inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition {{ request('status') === 'inactive' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/50 font-black shadow-md' : 'bg-bg border border-amber-500/30 text-neutral-300 hover:text-rose-400' }}">
                    <i data-lucide="user-x" class="w-4 h-4"></i> Inactive Users
                </a>
            </div>

            <!-- Binary Leg Quick Dropdown -->
            <form action="{{ route('admin.users') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="position" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl bg-bg border border-amber-500/40 text-amber-400 font-bold text-xs focus:outline-none cursor-pointer w-full md:w-auto">
                    <option value="">All Binary Legs</option>
                    <option value="left" {{ request('position') === 'left' ? 'selected' : '' }}>Left Leg (Power Leg)</option>
                    <option value="right" {{ request('position') === 'right' ? 'selected' : '' }}>Right Leg (Weaker Leg)</option>
                </select>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-bg text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                    <tr>
                        <th class="p-4 rounded-l-xl">User Profile</th>
                        <th class="p-4">Referral Code & Link</th>
                        <th class="p-4">Sponsor Info</th>
                        <th class="p-4">Binary Side</th>
                        <th class="p-4">Registration Date & Time</th>
                        <th class="p-4">Activation Date & Time</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 rounded-r-xl text-center">DIRECT ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody" class="divide-y divide-amber-500/20 text-neutral-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-amber-500/10 transition user-row">
                        <!-- User Profile -->
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-black text-white text-sm user-name">{{ $user->name }}</div>
                                    <div class="text-xs text-neutral-400 user-email">{{ $user->email }}</div>
                                    <div class="text-[11px] text-amber-400 font-mono">{{ $user->mobile ?? 'No Mobile' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Referral Code & Link -->
                        <td class="p-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-black text-amber-400 font-mono text-sm user-code">{{ $user->referral_code }}</span>
                                    <button onclick="copyToClipboard('{{ $user->referral_code }}', 'Referral Code copied!')" class="p-1 rounded hover:bg-amber-500/20 text-amber-400 transition" title="Copy Referral Code">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-[11px] text-neutral-400">Link:</span>
                                    <button onclick="copyToClipboard('{{ url('/user/register?sponsor=' . $user->referral_code) }}', 'Referral Link copied!')" class="text-[11px] text-amber-300 hover:underline font-mono flex items-center gap-1" title="Copy Registration Link">
                                        <i data-lucide="link" class="w-3 h-3 text-amber-400"></i> Copy Link
                                    </button>
                                </div>
                            </div>
                        </td>

                        <!-- Sponsor Info -->
                        <td class="p-4">
                            <div>
                                <div class="font-bold text-white text-xs">
                                    {{ $user->sponsor ? $user->sponsor->name : ($user->sponsor_code ? 'Super Admin' : 'No Sponsor') }}
                                </div>
                                <div class="text-[11px] text-amber-400 font-mono">
                                    {{ $user->sponsor_code ?? 'NGF-0000001' }}
                                </div>
                            </div>
                        </td>

                        <!-- Binary Side -->
                        <td class="p-4">
                            @if(strtolower($user->position) === 'left')
                                <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-black uppercase">LEFT (POWER)</span>
                            @else
                                <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">RIGHT (WEAKER)</span>
                            @endif
                        </td>

                        <!-- Registration Date & Time -->
                        <td class="p-4">
                            <div class="text-xs font-semibold text-white">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
                            <div class="text-[11px] text-neutral-400 font-mono">{{ $user->created_at ? $user->created_at->format('h:i A') : '' }}</div>
                        </td>

                        <!-- Activation Date & Time -->
                        <td class="p-4">
                            @if($user->status === 'active' && $user->activated_at)
                                <div class="text-xs font-semibold text-emerald-400">{{ $user->activated_at->format('M d, Y') }}</div>
                                <div class="text-[11px] text-neutral-400 font-mono">{{ $user->activated_at->format('h:i A') }}</div>
                            @else
                                <span class="px-2.5 py-1 rounded bg-rose-500/10 text-rose-400 border border-rose-500/30 text-[10px] font-bold uppercase">NOT ACTIVATED</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="p-4">
                            @if($user->status === 'active')
                                <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">ACTIVE</span>
                            @else
                                <span class="px-2.5 py-1 rounded bg-rose-500/20 text-rose-300 border border-rose-500/40 text-[10px] font-black uppercase">INACTIVE</span>
                            @endif
                        </td>

                        <!-- DIRECT ACTIONS (Including Direct Members Icon Button) -->
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.users.impersonate', $user->id) }}" target="_blank" class="px-3 py-1.5 rounded-xl border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 hover:border-amber-400 transition flex items-center gap-1.5 text-xs font-bold shadow" title="Login as User in New Tab">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5 text-amber-400"></i> Login as User
                                </a>
                                <a href="{{ route('admin.network.direct', ['search' => $user->referral_code]) }}" class="p-2 rounded-xl border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 hover:border-amber-400 transition shadow flex items-center justify-center" title="View Direct Members Sponsored By User">
                                    <i data-lucide="users" class="w-4 h-4 text-amber-400"></i>
                                </a>
                                <a href="{{ route('admin.network.tree', ['code' => $user->referral_code]) }}" class="p-2 rounded-xl border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 hover:border-amber-400 transition shadow flex items-center justify-center" title="View Binary Tree">
                                    <i data-lucide="git-merge" class="w-4 h-4 text-amber-400"></i>
                                </a>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="p-2 rounded-xl border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 hover:border-amber-400 transition shadow flex items-center justify-center" title="View Profile">
                                    <i data-lucide="eye" class="w-4 h-4 text-amber-400"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-xl border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 hover:border-amber-400 transition shadow flex items-center justify-center" title="Edit Member">
                                    <i data-lucide="edit-3" class="w-4 h-4 text-amber-400"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-neutral-400 text-sm font-semibold">
                            No platform members found matching your search parameters.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Clean Styled Pagination Links -->
        <div class="pt-4 border-t border-amber-500/20 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-neutral-400 font-semibold">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} registered members
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Instant Client-side Real-time Search Filter + Debounced Server Submit
        const searchInput = document.getElementById('liveSearchInput');
        if (searchInput) {
            let debounceTimer = null;

            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.user-row');

                // Instant 0ms visual row filtering
                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Debounced server search execution
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (this.form) {
                        this.form.submit();
                    }
                }, 700);
            });
        }
    });

    function copyToClipboard(text, msg) {
        navigator.clipboard.writeText(text).then(() => {
            if (typeof showToast === 'function') {
                showToast('Copied!', msg, 'success');
            } else {
                alert(msg);
            }
        });
    }
</script>
@endsection
