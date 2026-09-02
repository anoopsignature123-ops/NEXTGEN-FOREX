@extends('admin.layouts.app')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Banner Full Width -->
    <div class="ng-banner-title p-6 sm:p-8 flex items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">ID</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">MEMBER PROFILE CARD</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">{{ $user->name }}</h1>
            <p class="text-xs text-neutral-300 mt-1">Referral Code: <span class="text-amber-400 font-bold font-mono">{{ $user->referral_code }}</span></p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 rounded-xl bg-amber-500 text-black font-extrabold text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center gap-2">
                <i data-lucide="edit-3" class="w-4 h-4 text-black"></i> Edit Member
            </a>
            <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-xl bg-panel border border-amber-500/40 text-amber-300 font-bold text-xs uppercase tracking-wider hover:bg-amber-500/20 transition flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
            </a>
        </div>
    </div>

    <!-- Member Details Grid Full Width -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Account Info Card -->
        <div class="bg-panel p-6 space-y-4 rounded-2xl border border-amber-500/30 shadow-xl">
            <h3 class="text-lg font-bold text-white flex items-center gap-2 border-b border-amber-500/20 pb-3">
                <i data-lucide="user" class="w-5 h-5 text-amber-400"></i> Basic Account Details
            </h3>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Referral / Member Code:</span>
                    <span class="font-black text-amber-400 font-mono text-sm">{{ $user->referral_code }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Sponsor Code:</span>
                    <span class="font-bold text-white font-mono">{{ $user->sponsor_code ?? 'NGF-0000001' }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Member Full Name:</span>
                    <span class="font-bold text-white">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Registered Email:</span>
                    <span class="font-bold text-white">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Mobile Phone:</span>
                    <span class="font-bold text-white">{{ $user->mobile ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-neutral-400">Registration Date:</span>
                    <span class="font-bold text-neutral-300">{{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Binary & Network Card -->
        <div class="bg-panel p-6 space-y-4 rounded-2xl border border-amber-500/30 shadow-xl">
            <h3 class="text-lg font-bold text-white flex items-center gap-2 border-b border-amber-500/20 pb-3">
                <i data-lucide="git-merge" class="w-5 h-5 text-emerald-400"></i> Binary Placement & Network
            </h3>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Binary Tree Position:</span>
                    @if(strtolower($user->position) === 'left')
                        <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 font-black uppercase">LEFT LEG (POWER)</span>
                    @else
                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 font-black uppercase">RIGHT LEG (WEAKER)</span>
                    @endif
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Account Status:</span>
                    @if($user->status === 'active')
                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 font-black uppercase">ACTIVE</span>
                    @else
                        <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-400 border border-amber-500/40 font-black uppercase">INACTIVE</span>
                    @endif
                </div>
                <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                    <span class="text-neutral-400">Assigned Role:</span>
                    <span class="font-bold text-amber-400 uppercase">{{ $user->role ? $user->role->name : 'User' }}</span>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-neutral-400">Direct Sponsor Link:</span>
                    <span class="font-mono text-amber-300 text-[11px] truncate max-w-[200px]">{{ url('/user/register?sponsor=' . $user->referral_code) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
