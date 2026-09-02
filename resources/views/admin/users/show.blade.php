@extends('admin.layouts.app')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Banner Full Width -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">ID</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">MEMBER PROFILE CARD</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">{{ $user->name }}</h1>
            <p class="text-xs text-neutral-300 mt-1">Referral Code: <span class="text-amber-400 font-bold font-mono">{{ $user->referral_code }}</span></p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.users.impersonate', $user->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center gap-2">
                <i data-lucide="external-link" class="w-4 h-4 text-black"></i> Login as User
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 rounded-xl bg-sky-500/20 border border-sky-500/40 text-sky-300 font-bold text-xs uppercase tracking-wider hover:bg-sky-500/30 transition flex items-center gap-2">
                <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Member
            </a>
            <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-xl bg-panel border border-amber-500/40 text-amber-300 font-bold text-xs uppercase tracking-wider hover:bg-amber-500/20 transition flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
            </a>
        </div>
    </div>

    <!-- Member Details Grid: 6-6 Column Split (col-sm-6 col-sm-6 equal 50%-50% layout) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full items-start">
        
        <!-- CARD 1 (Col-6): Basic Account Details -->
        <div class="bg-panel p-6 space-y-4 rounded-2xl border border-amber-500/30 shadow-xl w-full">
            <h3 class="text-lg font-bold text-white flex items-center gap-2 border-b border-amber-500/20 pb-3">
                <i data-lucide="user" class="w-5 h-5 text-amber-400"></i> Basic Account Details
            </h3>

            <div class="space-y-3.5 text-xs">
                <div class="flex justify-between items-center py-1.5 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Referral / Member Code:</span>
                    <span class="font-black text-amber-400 font-mono text-sm">{{ $user->referral_code }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Sponsor Code:</span>
                    <span class="font-bold text-white font-mono">{{ $user->sponsor_code ?? 'NGF-0000001' }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Member Full Name:</span>
                    <span class="font-bold text-white">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Registered Email:</span>
                    <span class="font-bold text-white truncate max-w-[180px] sm:max-w-[220px]" title="{{ $user->email }}">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Mobile Phone:</span>
                    <span class="font-bold text-white">{{ $user->mobile ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5">
                    <span class="text-neutral-400 font-medium">Registration Date:</span>
                    <span class="font-bold text-neutral-300">{{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- CARD 2 (Col-6): Binary Placement, Navigation Links & Referral Links -->
        <div class="bg-panel p-6 space-y-4 rounded-2xl border border-amber-500/30 shadow-xl w-full">
            <h3 class="text-lg font-bold text-white flex items-center gap-2 border-b border-amber-500/20 pb-3">
                <i data-lucide="git-merge" class="w-5 h-5 text-emerald-400"></i> Binary Placement & Network Links
            </h3>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Binary Tree Position:</span>
                    @if(strtolower($user->position) === 'left')
                        <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 font-black uppercase">LEFT LEG (POWER)</span>
                    @else
                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 font-black uppercase">RIGHT LEG (WEAKER)</span>
                    @endif
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Account Status:</span>
                    @if($user->status === 'active')
                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 font-black uppercase">ACTIVE</span>
                    @else
                        <span class="px-2.5 py-1 rounded bg-rose-500/20 text-rose-300 border border-rose-500/40 font-black uppercase">INACTIVE</span>
                    @endif
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400 font-medium">Assigned Role:</span>
                    <span class="font-bold text-amber-400 uppercase">{{ $user->role ? $user->role->name : 'User' }}</span>
                </div>

                <!-- QUICK NAVIGATION ACTION BUTTONS -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1">
                    <!-- Binary Tree Link -->
                    <a href="{{ route('admin.network.tree', ['code' => $user->referral_code]) }}" 
                       class="p-2.5 rounded-xl bg-black/40 border border-amber-400/80 text-amber-300 font-bold text-[11px] flex items-center justify-between hover:bg-amber-500/15 transition group">
                        <span class="flex items-center gap-1.5 truncate">
                            <i data-lucide="git-merge" class="w-3.5 h-3.5 text-amber-400"></i> Binary Tree
                        </span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-neutral-400 group-hover:translate-x-0.5 transition"></i>
                    </a>

                    <!-- Direct Team Link -->
                    <a href="{{ route('admin.network.direct', ['search' => $user->referral_code]) }}" 
                       class="p-2.5 rounded-xl bg-black/40 border border-sky-500/60 text-sky-300 font-bold text-[11px] flex items-center justify-between hover:bg-sky-500/15 transition group">
                        <span class="flex items-center gap-1.5 truncate">
                            <i data-lucide="users" class="w-3.5 h-3.5 text-sky-400"></i> Direct Team
                        </span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-neutral-400 group-hover:translate-x-0.5 transition"></i>
                    </a>

                    <!-- Login to User Link -->
                    <a href="{{ route('admin.users.impersonate', $user->id) }}" target="_blank"
                       class="p-2.5 rounded-xl bg-black/40 border border-amber-400/80 text-amber-300 font-bold text-[11px] flex items-center justify-between hover:bg-amber-500/15 transition group">
                        <span class="flex items-center gap-1.5 truncate">
                            <i data-lucide="log-in" class="w-3.5 h-3.5 text-amber-400"></i> Login to User
                        </span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-neutral-400 group-hover:translate-x-0.5 transition"></i>
                    </a>
                </div>

                <!-- LEFT LEG REFERRAL LINK -->
                <div class="p-3 rounded-xl bg-black/60 border border-amber-500/30 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black text-amber-400 uppercase flex items-center gap-1 shrink-0">
                            <i data-lucide="arrow-left-circle" class="w-3.5 h-3.5 text-amber-400"></i> LEFT LEG REFERRAL LINK
                        </span>
                        <button onclick="copyLink('{{ url('/user/register?sponsor=' . $user->referral_code . '&position=left') }}', 'Left Leg Referral Link copied!')" class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 hover:bg-amber-500/40 transition font-bold text-[10px] uppercase flex items-center gap-1 shrink-0">
                            <i data-lucide="copy" class="w-3 h-3"></i> Copy Link
                        </button>
                    </div>
                    <p class="text-[11px] text-neutral-300 font-mono break-all">{{ url('/user/register?sponsor=' . $user->referral_code . '&position=left') }}</p>
                </div>

                <!-- RIGHT LEG REFERRAL LINK -->
                <div class="p-3 rounded-xl bg-black/60 border border-emerald-500/30 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black text-emerald-400 uppercase flex items-center gap-1 shrink-0">
                            <i data-lucide="arrow-right-circle" class="w-3.5 h-3.5 text-emerald-400"></i> RIGHT LEG REFERRAL LINK
                        </span>
                        <button onclick="copyLink('{{ url('/user/register?sponsor=' . $user->referral_code . '&position=right') }}', 'Right Leg Referral Link copied!')" class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 hover:bg-emerald-500/40 transition font-bold text-[10px] uppercase flex items-center gap-1 shrink-0">
                            <i data-lucide="copy" class="w-3 h-3"></i> Copy Link
                        </button>
                    </div>
                    <p class="text-[11px] text-neutral-300 font-mono break-all">{{ url('/user/register?sponsor=' . $user->referral_code . '&position=right') }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- PACKAGES HISTORY SECTION FULL WIDTH -->
    <div class="bg-panel p-6 space-y-4 rounded-2xl border border-amber-500/30 shadow-xl w-full">
        <div class="flex items-center justify-between border-b border-amber-500/20 pb-3">
            <h3 class="text-lg font-bold text-white flex items-center gap-2 font-heading">
                <i data-lucide="package-check" class="w-5 h-5 text-amber-400"></i> Packages History
            </h3>
            <span class="text-xs text-neutral-400 font-mono">Total Packages: <strong class="text-amber-400">1 Active</strong></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-amber-500/20 text-amber-400 font-black uppercase tracking-wider">
                        <th class="py-3 px-3">Package Name</th>
                        <th class="py-3 px-3">Price / Vol</th>
                        <th class="py-3 px-3">Daily ROI</th>
                        <th class="py-3 px-3">Purchased On</th>
                        <th class="py-3 px-3 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/10 text-neutral-300 font-medium">
                    <tr class="hover:bg-amber-500/5 transition">
                        <td class="py-3.5 px-3 font-bold text-white flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Forex Pro Starter Pack
                        </td>
                        <td class="py-3.5 px-3 font-mono font-bold text-amber-300">$100.00</td>
                        <td class="py-3.5 px-3 font-mono text-emerald-400">+1.5% / Day</td>
                        <td class="py-3.5 px-3 font-mono text-neutral-400">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                        <td class="py-3.5 px-3 text-right">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">ACTIVE</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyLink(link, msg) {
        navigator.clipboard.writeText(link).then(() => {
            if (typeof showToast === 'function') {
                showToast('Copied!', msg, 'success');
            } else {
                alert(msg);
            }
        });
    }
</script>
@endsection
