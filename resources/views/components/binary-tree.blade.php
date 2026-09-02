@props(['treeData', 'routePrefix' => 'user'])

@php
    $root = $treeData['root'] ?? null;
    $left1 = $treeData['left1'] ?? null;
    $right1 = $treeData['right1'] ?? null;
    $left_left2 = $treeData['left_left2'] ?? null;
    $left_right2 = $treeData['left_right2'] ?? null;
    $right_left2 = $treeData['right_left2'] ?? null;
    $right_right2 = $treeData['right_right2'] ?? null;
@endphp

<div class="w-full space-y-6 select-none font-sans">

    <!-- TOP 4 GENEALOGY SUMMARY CARDS (Matching Reference Screenshot) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: USER NAME -->
        <div class="p-4 rounded-2xl bg-[#0f1b23] border border-amber-500/30 shadow-lg relative overflow-hidden">
            <div class="text-[11px] font-bold uppercase tracking-wider text-amber-400">USER NAME</div>
            <h3 class="text-xl font-black text-gold-gradient font-heading mt-1">{{ $root ? $root->name : 'N/A' }}</h3>
        </div>

        <!-- Card 2: USER ID -->
        <div class="p-4 rounded-2xl bg-[#0f1b23] border border-amber-500/30 shadow-lg relative overflow-hidden">
            <div class="text-[11px] font-bold uppercase tracking-wider text-amber-400">USER ID</div>
            <h3 class="text-xl font-black text-amber-300 font-mono tracking-wider mt-1">{{ $root ? $root->referral_code : 'N/A' }}</h3>
        </div>

        <!-- Card 3: LEFT BUSINESS -->
        <div class="p-4 rounded-2xl bg-[#0f1b23] border border-amber-500/30 shadow-lg relative overflow-hidden">
            <div class="text-[11px] font-bold uppercase tracking-wider text-amber-400">LEFT BUSINESS</div>
            <h3 class="text-xl font-black text-gold-gradient font-mono mt-1">{{ $root ? $root->left_leg_stats['business'] : '$0.00' }}</h3>
        </div>

        <!-- Card 4: RIGHT BUSINESS -->
        <div class="p-4 rounded-2xl bg-[#0f1b23] border border-amber-500/30 shadow-lg relative overflow-hidden">
            <div class="text-[11px] font-bold uppercase tracking-wider text-amber-400">RIGHT BUSINESS</div>
            <h3 class="text-xl font-black text-gold-gradient font-mono mt-1">{{ $root ? $root->right_leg_stats['business'] : '$0.00' }}</h3>
        </div>
    </div>

    <!-- CANVAS HEADER TOOLBAR WITH DOWNLOAD IMAGE BUTTON -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-[#09150e] p-4 rounded-2xl border border-amber-500/30">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
            <span class="text-xs font-bold text-amber-300 uppercase tracking-wider font-heading">BINARY TEAM TREE GRAPH</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3">
            <!-- DOWNLOAD TREE IMAGE BUTTON -->
            <button type="button" 
                    onclick="downloadTreeImage()" 
                    id="downloadTreeBtn"
                    class="px-4 py-2 rounded-xl bg-amber-500/15 hover:bg-amber-500/30 border border-amber-400/60 text-amber-300 font-extrabold text-xs flex items-center gap-2 transition shadow-md hover:scale-105 active:scale-95 cursor-pointer">
                <span>📸 Download Tree Image</span>
            </button>

            <!-- RECENTER TREE BUTTON -->
            <a href="{{ route($routePrefix . '.network.tree') }}" 
               class="px-4 py-2 rounded-xl bg-neutral-900/90 hover:bg-neutral-800 border border-neutral-700 text-neutral-300 font-bold text-xs flex items-center gap-2 transition shadow-md">
                <span>🎯 Recenter Root</span>
            </a>
        </div>
    </div>

    <!-- MAIN GENEALOGY TREE GRAPH CANVAS (With Generous Top Padding pt-20 on Inner Canvas) -->
    <div id="treeCanvasContainer" class="w-full overflow-x-auto px-6 py-12 rounded-2xl bg-[#0b161e] border-2 border-amber-500/30 shadow-2xl relative flex justify-start sm:justify-center">
        
        <div class="flex flex-col items-center min-w-[680px] mx-auto pt-20 pb-8">

            <!-- ================= LEVEL 0: ROOT NODE ================= -->
            <div class="flex justify-center">
                @if($root)
                    @include('components.binary-node-card', ['node' => $root, 'role' => 'ROOTER', 'isRoot' => true, 'routePrefix' => $routePrefix])
                @endif
            </div>

            <!-- LEVEL 0 -> LEVEL 1 SVG CONNECTOR (Exact 680px Fixed Min-Width Grid Alignment) -->
            <div class="w-[680px] min-w-[680px] flex justify-center">
                <svg class="w-[680px] h-12 overflow-visible" viewBox="0 0 680 48" fill="none">
                    <!-- Vertical Line Down from Root Center (340, 0) to (340, 24) -->
                    <path d="M 340 0 L 340 24" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                    <!-- Single Continuous Unbroken Horizontal Dashed Line (170, 24) to (510, 24) -->
                    <path d="M 170 24 L 510 24" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                    <!-- Vertical Drop Line to Left Child (170, 24) to (170, 48) -->
                    <path d="M 170 24 L 170 48" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                    <!-- Vertical Drop Line to Right Child (510, 24) to (510, 48) -->
                    <path d="M 510 24 L 510 48" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                </svg>
            </div>

            <!-- ================= LEVEL 1: LEFT & RIGHT BRANCHES ================= -->
            <div class="grid grid-cols-2 w-[680px] min-w-[680px] justify-items-center">
                
                <!-- LEFT CHILD BRANCH (340px Column Width -> Center = 170px) -->
                <div class="flex flex-col items-center w-[340px] min-w-[340px]">
                    @if($left1)
                        @include('components.binary-node-card', ['node' => $left1, 'role' => 'LEFT LEG', 'routePrefix' => $routePrefix])
                    @else
                        <a href="{{ route('user.register', ['sponsor' => $root->referral_code, 'position' => 'left']) }}" target="_blank" class="p-3.5 rounded-2xl bg-[#0e1a22] border-2 border-dashed border-amber-400/70 hover:bg-amber-500/15 transition text-center w-44 shadow-lg block group">
                            <div class="w-9 h-9 mx-auto rounded-full bg-amber-500/20 text-amber-400 font-black text-base flex items-center justify-center mb-1 group-hover:scale-110 transition">+</div>
                            <div class="text-[11px] font-black text-amber-300 uppercase tracking-wider">ADD LEFT MEMBER</div>
                            <div class="text-[10px] text-neutral-400 mt-0.5 font-semibold">Empty Slot</div>
                        </a>
                    @endif

                    <!-- LEVEL 1 LEFT -> LEVEL 2 SVG CONNECTOR (Exact 320px Fixed Min-Width Grid Alignment) -->
                    <div class="w-[320px] min-w-[320px] flex justify-center">
                        <svg class="w-[320px] h-10 overflow-visible" viewBox="0 0 320 40" fill="none">
                            <path d="M 160 0 L 160 20" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                            <path d="M 80 20 L 240 20" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                            <path d="M 80 20 L 80 40" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                            <path d="M 240 20 L 240 40" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                        </svg>
                    </div>

                    <!-- LEVEL 2 LEFT SUB-CHILDREN (L-L & L-R) -->
                    <div class="grid grid-cols-2 w-[320px] min-w-[320px] justify-items-center">
                        <div>
                            @if($left_left2)
                                @include('components.binary-node-card', ['node' => $left_left2, 'role' => 'L-L', 'routePrefix' => $routePrefix, 'isSmall' => true])
                            @else
                                <div class="p-2.5 rounded-xl bg-[#091218] border border-dashed border-amber-500/30 text-center w-28 opacity-70">
                                    <span class="text-[10px] text-neutral-400 font-bold">Empty Slot</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            @if($left_right2)
                                @include('components.binary-node-card', ['node' => $left_right2, 'role' => 'L-R', 'routePrefix' => $routePrefix, 'isSmall' => true])
                            @else
                                <div class="p-2.5 rounded-xl bg-[#091218] border border-dashed border-amber-500/30 text-center w-28 opacity-70">
                                    <span class="text-[10px] text-neutral-400 font-bold">Empty Slot</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- RIGHT CHILD BRANCH (340px Column Width -> Center = 510px) -->
                <div class="flex flex-col items-center w-[340px] min-w-[340px]">
                    @if($right1)
                        @include('components.binary-node-card', ['node' => $right1, 'role' => 'RIGHT LEG', 'routePrefix' => $routePrefix])
                    @else
                        <a href="{{ route('user.register', ['sponsor' => $root->referral_code, 'position' => 'right']) }}" target="_blank" class="p-3.5 rounded-2xl bg-[#0e1a22] border-2 border-dashed border-emerald-400/70 hover:bg-emerald-500/15 transition text-center w-44 shadow-lg block group">
                            <div class="w-9 h-9 mx-auto rounded-full bg-emerald-500/20 text-emerald-400 font-black text-base flex items-center justify-center mb-1 group-hover:scale-110 transition">+</div>
                            <div class="text-[11px] font-black text-emerald-300 uppercase tracking-wider">ADD RIGHT MEMBER</div>
                            <div class="text-[10px] text-neutral-400 mt-0.5 font-semibold">Empty Slot</div>
                        </a>
                    @endif

                    <!-- LEVEL 1 RIGHT -> LEVEL 2 SVG CONNECTOR (Exact 320px Fixed Min-Width Grid Alignment) -->
                    <div class="w-[320px] min-w-[320px] flex justify-center">
                        <svg class="w-[320px] h-10 overflow-visible" viewBox="0 0 320 40" fill="none">
                            <path d="M 160 0 L 160 20" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                            <path d="M 80 20 L 240 20" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                            <path d="M 80 20 L 80 40" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                            <path d="M 240 20 L 240 40" stroke="#f3ca52" stroke-width="2" stroke-dasharray="4 3"/>
                        </svg>
                    </div>

                    <!-- LEVEL 2 RIGHT SUB-CHILDREN (R-L & R-R) -->
                    <div class="grid grid-cols-2 w-[320px] min-w-[320px] justify-items-center">
                        <div>
                            @if($right_left2)
                                @include('components.binary-node-card', ['node' => $right_left2, 'role' => 'R-L', 'routePrefix' => $routePrefix, 'isSmall' => true])
                            @else
                                <div class="p-2.5 rounded-xl bg-[#091218] border border-dashed border-emerald-500/30 text-center w-28 opacity-70">
                                    <span class="text-[10px] text-neutral-400 font-bold">Empty Slot</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            @if($right_right2)
                                @include('components.binary-node-card', ['node' => $right_right2, 'role' => 'R-R', 'routePrefix' => $routePrefix, 'isSmall' => true])
                            @else
                                <div class="p-2.5 rounded-xl bg-[#091218] border border-dashed border-emerald-500/30 text-center w-28 opacity-70">
                                    <span class="text-[10px] text-neutral-400 font-bold">Empty Slot</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<!-- MOBILE ONLY MEMBER INFO MODAL OVERLAY (Opens on Mobile (i) Badge Tap) -->
<div id="mobileMemberModal" style="display: none;" class="md:hidden fixed inset-0 z-[99999] bg-black/85 backdrop-blur-sm items-center justify-center p-4">
    <div class="relative w-full max-w-xs sm:max-w-sm p-5 rounded-3xl border-2 border-amber-400 shadow-[0_0_50px_rgba(243,202,82,0.4)] text-left space-y-3 text-xs"
         style="background-color: #07120a !important;">
        
        <!-- Header -->
        <div class="flex justify-between items-center pb-2.5 border-b border-amber-500/30">
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-amber-500/20 border border-amber-400/40 text-amber-300 flex items-center justify-center font-bold text-xs">ID</span>
                <div>
                    <h3 id="mobileModalName" class="font-black text-white text-sm font-heading">Member Name</h3>
                    <p id="mobileModalCode" class="text-[11px] text-amber-400 font-mono">NGF-0000000</p>
                </div>
            </div>
            <button type="button" onclick="closeMobileMemberModal()" class="w-7 h-7 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 hover:bg-rose-500/40 flex items-center justify-center font-black text-sm transition">
                ✕
            </button>
        </div>

        <!-- Details Rows -->
        <div class="space-y-2 py-1">
            <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                <span class="text-neutral-400 font-medium">Sponsor ID:</span>
                <span id="mobileModalSponsorCode" class="font-bold text-gold-gradient font-mono">NGF-0000001</span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                <span class="text-neutral-400 font-medium">Sponsor Name:</span>
                <span id="mobileModalSponsorName" class="font-bold text-sky-400">Rooter</span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-amber-500/10">
                <span class="text-neutral-400 font-medium">Package Status:</span>
                <span id="mobileModalPackage" class="font-black text-amber-300 uppercase">Partner / Active</span>
            </div>

            <!-- Left Team Members Pill -->
            <div class="p-2.5 rounded-xl bg-emerald-950/80 border border-emerald-500/40 flex justify-between items-center text-[11px]">
                <span class="font-extrabold text-emerald-400 uppercase">Left Team Members:</span>
                <span id="mobileModalLeftMembers" class="font-black text-emerald-300 font-mono">0 Act, 0 Inact</span>
            </div>

            <!-- Right Team Members Pill -->
            <div class="p-2.5 rounded-xl bg-sky-950/80 border border-sky-500/40 flex justify-between items-center text-[11px]">
                <span class="font-extrabold text-sky-400 uppercase">Right Team Members:</span>
                <span id="mobileModalRightMembers" class="font-black text-sky-300 font-mono">0 Act, 0 Inact</span>
            </div>

            <div class="flex justify-between items-center pt-1 border-t border-amber-500/20">
                <span class="text-neutral-400 font-medium">Left Business:</span>
                <span id="mobileModalLeftBusiness" class="font-black text-emerald-400 font-mono text-sm">$0.00</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-neutral-400 font-medium">Right Business:</span>
                <span id="mobileModalRightBusiness" class="font-black text-sky-400 font-mono text-sm">$0.00</span>
            </div>
        </div>

        <button type="button" onclick="closeMobileMemberModal()" class="w-full py-2.5 rounded-xl bg-amber-400 text-black font-black text-xs uppercase tracking-wider hover:bg-amber-300 transition">
            Close Member Info
        </button>
    </div>
</div>

<style>
.desktop-node-tooltip {
    opacity: 0 !important;
    pointer-events: none !important;
    transition: opacity 0.2s ease, transform 0.2s ease !important;
    transform: translateX(-50%) translateY(8px) !important;
}

.group-node:hover .desktop-node-tooltip {
    opacity: 1 !important;
    pointer-events: auto !important;
    transform: translateX(-50%) translateY(0) !important;
}
</style>

<!-- HTML2CANVAS SCRIPT FOR 1-CLICK TREE IMAGE EXPORT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function downloadTreeImage() {
        const btn = document.getElementById('downloadTreeBtn');
        const container = document.getElementById('treeCanvasContainer');
        if (!container) return;

        const originalText = btn.innerHTML;
        btn.innerHTML = '<span>⏳ Generating PNG...</span>';
        btn.disabled = true;

        html2canvas(container, {
            backgroundColor: '#0b161e',
            scale: 2,
            useCORS: true,
            logging: false
        }).then(canvas => {
            const image = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            const userCode = "{{ $root->referral_code ?? 'TREE' }}";
            link.download = `NextGen_Forex_Genealogy_Tree_${userCode}.png`;
            link.href = image;
            link.click();

            btn.innerHTML = originalText;
            btn.disabled = false;
        }).catch(err => {
            console.error(err);
            alert('Could not capture tree image. Please try again.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function openMobileMemberModal(event, data) {
        event.stopPropagation();
        event.preventDefault();
        
        document.getElementById('mobileModalName').textContent = data.name;
        document.getElementById('mobileModalCode').textContent = data.code;
        document.getElementById('mobileModalSponsorCode').textContent = data.sponsor_code;
        document.getElementById('mobileModalSponsorName').textContent = data.sponsor_name;
        document.getElementById('mobileModalPackage').textContent = data.package;
        document.getElementById('mobileModalLeftMembers').textContent = data.left_members;
        document.getElementById('mobileModalRightMembers').textContent = data.right_members;
        document.getElementById('mobileModalLeftBusiness').textContent = data.left_business;
        document.getElementById('mobileModalRightBusiness').textContent = data.right_business;

        const modal = document.getElementById('mobileMemberModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeMobileMemberModal() {
        const modal = document.getElementById('mobileMemberModal');
        if (modal) modal.style.display = 'none';
    }

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('mobileMemberModal');
        if (modal && e.target === modal) {
            closeMobileMemberModal();
        }
    });
</script>
