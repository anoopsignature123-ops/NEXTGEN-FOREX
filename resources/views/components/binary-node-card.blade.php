@props(['node', 'role' => '', 'routePrefix' => 'user', 'isSmall' => false])

@php
    $leftStats = $node->left_leg_stats;
    $rightStats = $node->right_leg_stats;
@endphp

<div class="relative group-node inline-block text-center">
    
    <!-- 1. DESKTOP ONLY HOVER TOOLTIP CARD (Hidden on mobile, opens on desktop hover via CSS) -->
    <div class="desktop-node-tooltip hidden md:block absolute bottom-[108%] left-1/2 -translate-x-1/2 mb-2 w-72 sm:w-80 p-4 rounded-2xl border-2 border-[#f3ca52] shadow-[0_20px_50px_rgba(0,0,0,0.95)] text-left space-y-2 text-xs"
         style="background-color: #07120a !important; z-index: 99999 !important;">
        
        <!-- Tooltip Header -->
        <div class="flex justify-between items-center pb-1 border-b border-amber-500/20">
            <span class="text-neutral-400 font-semibold">Full Name</span>
            <span class="font-black text-white font-heading">{{ $node->name }}</span>
        </div>

        <div class="flex justify-between items-center pb-1 border-b border-amber-500/20">
            <span class="text-neutral-400 font-semibold">Self ID</span>
            <span class="font-black text-amber-400 font-mono">{{ $node->referral_code }}</span>
        </div>

        <div class="flex justify-between items-center pb-1 border-b border-amber-500/20">
            <span class="text-neutral-400 font-semibold">SponsorID</span>
            <span class="font-black text-gold-gradient font-mono">{{ $node->sponsor_code ?? 'NGF-0000001' }}</span>
        </div>

        <div class="flex justify-between items-center pb-1 border-b border-amber-500/20">
            <span class="text-neutral-400 font-semibold">Sponsor Name</span>
            <span class="font-bold text-sky-400">{{ $node->sponsor ? $node->sponsor->name : 'Rooter' }}</span>
        </div>

        <div class="flex justify-between items-center pb-1 border-b border-amber-500/20">
            <span class="text-neutral-400 font-semibold">Package Name</span>
            <span class="font-black text-amber-300">{{ $node->status === 'active' ? 'Partner / Active' : 'Inactive' }}</span>
        </div>

        <!-- Left Team Members Pill -->
        <div class="p-2 rounded-xl bg-emerald-950/80 border border-emerald-500/40 flex justify-between items-center text-[11px]">
            <span class="font-extrabold text-emerald-400 uppercase">Left Team Members</span>
            <span class="font-black text-emerald-300 font-mono">{{ $leftStats['active'] }} Act, {{ $leftStats['inactive'] }} Inact (Tot: {{ $leftStats['total'] }})</span>
        </div>

        <!-- Right Team Members Pill -->
        <div class="p-2 rounded-xl bg-sky-950/80 border border-sky-500/40 flex justify-between items-center text-[11px]">
            <span class="font-extrabold text-sky-400 uppercase">Right Team Members</span>
            <span class="font-black text-sky-300 font-mono">{{ $rightStats['active'] }} Act, {{ $rightStats['inactive'] }} Inact (Tot: {{ $rightStats['total'] }})</span>
        </div>

        <div class="flex justify-between items-center pt-1 border-t border-amber-500/20">
            <span class="text-neutral-400 font-semibold">Left Business</span>
            <span class="font-black text-emerald-400 font-mono">{{ $leftStats['business'] }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-neutral-400 font-semibold">Right Business</span>
            <span class="font-black text-sky-400 font-mono">{{ $rightStats['business'] }}</span>
        </div>

        <!-- Arrow Pointer at Bottom of Tooltip Card -->
        <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-[#f3ca52]"></div>
    </div>

    <!-- MAIN TREE NODE CARD -->
    <div class="relative inline-block">
        
        <!-- 2. MOBILE ONLY (i) INFO BADGE BUTTON (Neatly Positioned Inside Card at Top Right md:hidden) -->
        <button type="button" 
                onclick="openMobileMemberModal(event, {{ json_encode([
                    'name' => $node->name,
                    'code' => $node->referral_code,
                    'sponsor_code' => $node->sponsor_code ?? 'NGF-0000001',
                    'sponsor_name' => $node->sponsor ? $node->sponsor->name : 'Rooter',
                    'package' => $node->status === 'active' ? 'Partner / Active' : 'Inactive',
                    'left_members' => $leftStats['active'].' Act, '.$leftStats['inactive'].' Inact (Tot: '.$leftStats['total'].')',
                    'right_members' => $rightStats['active'].' Act, '.$rightStats['inactive'].' Inact (Tot: '.$rightStats['total'].')',
                    'left_business' => $leftStats['business'],
                    'right_business' => $rightStats['business'],
                ]) }})"
                class="flex md:hidden absolute top-2 right-2 w-5 h-5 rounded-full bg-amber-400 text-black hover:bg-amber-300 font-black text-[10px] items-center justify-center z-30 shadow-md cursor-pointer transition hover:scale-110 border border-black" 
                title="Tap for Info">
            i
        </button>

        <a href="{{ route($routePrefix . '.network.tree', ['code' => $node->referral_code]) }}" 
           class="block p-3.5 rounded-2xl border-2 border-amber-400/90 shadow-[0_0_20px_rgba(243,202,82,0.35)] text-center {{ $isSmall ? 'w-32 p-2.5' : 'w-44' }} transition-all duration-300 hover:scale-105 hover:border-amber-300"
           style="background-color: #09150e !important;">
            
            <!-- CIRCULAR INITIAL AVATAR WITH LIVE GREEN DOT -->
            <div class="relative {{ $isSmall ? 'w-9 h-9' : 'w-11 h-11' }} mx-auto mb-1.5">
                <div class="w-full h-full rounded-full border-2 border-amber-400 text-amber-300 font-black {{ $isSmall ? 'text-xs' : 'text-base' }} flex items-center justify-center shadow-inner"
                     style="background-color: #050c08 !important;">
                    {{ strtoupper(substr($node->name, 0, 1)) }}
                </div>
                <!-- Live Active Status Dot -->
                <span class="absolute top-0 right-0 {{ $isSmall ? 'w-2.5 h-2.5' : 'w-3 h-3' }} rounded-full {{ $node->status === 'active' ? 'bg-emerald-400 ring-2 ring-[#061009] animate-pulse' : 'bg-rose-500 ring-2 ring-[#061009]' }}"></span>
            </div>

            <!-- NAME PILL CONTAINER -->
            <div class="px-2.5 py-0.5 rounded-full border border-amber-500/30 mb-1" style="background-color: #122217 !important;">
                <span class="font-black text-white {{ $isSmall ? 'text-[10px]' : 'text-xs' }} block truncate font-heading group-hover/node:text-amber-300 transition">{{ $node->name }}</span>
            </div>

            <!-- SELF ID & SPONSOR ID TEXT -->
            <div class="{{ $isSmall ? 'text-[9px]' : 'text-[10px]' }} text-neutral-300 font-mono">SelfID: <span class="text-white font-bold">{{ $node->referral_code }}</span></div>
            <div class="{{ $isSmall ? 'text-[9px]' : 'text-[10px]' }} text-amber-400 font-mono font-bold mt-0.5">SponsorID: {{ $node->sponsor_code ?? 'NGF-0000001' }}</div>
        </a>
    </div>
</div>
