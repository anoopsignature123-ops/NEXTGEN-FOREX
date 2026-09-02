@extends('admin.layouts.app')

@section('content')
<style>
@keyframes goldPulseGlow {
    0%, 100% { box-shadow: 0 0 15px rgba(243, 202, 82, 0.2); }
    50% { box-shadow: 0 0 30px rgba(243, 202, 82, 0.45); }
}

.gold-card-animated {
    background: linear-gradient(135deg, rgba(9, 21, 14, 0.96) 0%, rgba(4, 10, 6, 0.98) 100%) !important;
    border: 2px solid rgba(243, 202, 82, 0.65) !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 15px rgba(243, 202, 82, 0.15) !important;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.gold-card-animated:hover {
    transform: translateY(-6px) scale(1.015) !important;
    border-color: #f3ca52 !important;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.95), 0 0 35px rgba(243, 202, 82, 0.45) !important;
}

.gold-3d-badge {
    background: linear-gradient(180deg, #fef08a 0%, #f59e0b 50%, #b45309 100%) !important;
    border: 2px solid #fef08a !important;
    box-shadow: 0 4px 15px rgba(243, 202, 82, 0.4), inset 0 2px 4px rgba(255, 255, 255, 0.6) !important;
}

.gold-highlight {
    color: #f3ca52 !important;
    font-weight: 800 !important;
    text-shadow: 0 0 10px rgba(243, 202, 82, 0.35) !important;
}
</style>

<div class="w-full space-y-6 font-sans relative">
    
    <!-- Ambient Gold Radial Glow Background Decorator -->
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[900px] h-[450px] bg-amber-500/10 blur-[130px] pointer-events-none rounded-full"></div>

    <!-- Top Header Banner (Matching Reference Screenshot) -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-6 rounded-3xl gold-card-animated relative z-10">
        <div>
            <div class="text-[11px] font-black text-amber-400 uppercase tracking-widest mb-0.5 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                ADMIN OVERVIEW CONTROL
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white font-heading tracking-tight">Welcome back, <span class="gold-highlight">Admin</span></h1>
            <p class="text-xs text-neutral-300 mt-1">Track your platform activity, users, rewards and revenue from one place.</p>
        </div>
        <div class="px-5 py-2.5 rounded-2xl bg-black/80 border-2 border-amber-400/80 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-xl">
            <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
            <span>{{ date('l, d M Y') }}</span>
        </div>
    </div>

    <!-- 8 STAT CARDS GRID (Luxury 3D Gold Badges & Animated Glow) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 relative z-10">
        
        <!-- CARD 1: Total Users -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">+12.5%</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Total Users</div>
            <h3 class="text-3xl font-black text-white font-heading mt-1">152</h3>
        </div>

        <!-- CARD 2: Active Packages -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="package-check" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">Active now</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Active Packages</div>
            <h3 class="text-3xl font-black text-white font-heading mt-1">67</h3>
        </div>

        <!-- CARD 3: Total Deposits Wallet -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">All time</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Total Deposits Wallet</div>
            <h3 class="text-3xl font-black gold-highlight font-mono mt-1">$149.40</h3>
        </div>

        <!-- CARD 4: Total Withdrawals -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-neutral-300 font-mono bg-neutral-800/80 px-2.5 py-1 rounded-full border border-neutral-600">All time</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Total Withdrawals</div>
            <h3 class="text-3xl font-black text-white font-mono mt-1">$0.00</h3>
        </div>

        <!-- CARD 5: Total Commission -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="coins" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">Bonuses paid</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Total Commission</div>
            <h3 class="text-3xl font-black gold-highlight font-mono mt-1">$19,902.86</h3>
        </div>

        <!-- CARD 6: Rank Rewards Paid -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="trophy" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">Milestones</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Rank Rewards Paid</div>
            <h3 class="text-3xl font-black gold-highlight font-mono mt-1">$3,940.00</h3>
        </div>

        <!-- CARD 7: Entertaining Bonuses -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="gift" class="w-5 h-5"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">Direct rewards</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Entertaining Bonuses</div>
            <h3 class="text-3xl font-black text-white font-mono mt-1">$0.00</h3>
        </div>

        <!-- CARD 8: Pending Requests -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex justify-between items-center mb-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black relative">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-0 right-0 w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 font-mono bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/50">1 pending</span>
            </div>
            <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">Pending Requests</div>
            <h3 class="text-3xl font-black text-white font-heading mt-1">1</h3>
        </div>

    </div>

    <!-- LUXURY NEXTGEN FOREX PDF PLAN INCOME CARDS (Matching PDF Page 10 & 12 Gold Shield & Highlights Style) -->
    <div class="space-y-4 pt-4 relative z-10">
        <div class="flex items-center justify-between border-b-2 border-amber-400/40 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge flex items-center justify-center text-black font-black text-xl shadow-lg">
                    🛡️
                </div>
                <div>
                    <h2 class="text-xl font-black text-gold-gradient font-heading tracking-wide uppercase">NEXTGEN FOREX 7 TYPES OF INCOMES</h2>
                    <p class="text-xs text-neutral-300">Official Business Presentation Plan Highlights (PDF Slide 12)</p>
                </div>
            </div>
            <span class="px-4 py-1.5 rounded-full bg-amber-500/20 text-amber-300 border-2 border-amber-400/60 font-mono text-xs font-black uppercase tracking-wider shadow-lg">
                7 Active Income Streams
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- 1. ROI INCOME CARD (Matching PDF Slide 10 & 12) -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">1</span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-black font-mono uppercase border border-emerald-500/40">Daily Return</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">ROI Income</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$12,450.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earn <span class="gold-highlight">0.5% to 1.5% daily</span> return on investment for 200 Days (<span class="text-emerald-400 font-bold">2X Total Return</span>).
                </p>
            </div>

            <!-- 2. 24H SPECIAL BONUS CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">2</span>
                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black font-mono uppercase border border-amber-500/40">24h Offer</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">24 Hours Special Bonus</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$1,250.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Complete <span class="gold-highlight">5 direct referrals</span> within 24 hours to unlock <span class="text-amber-300 font-bold">$50, $250, or $500 Gift</span> bonus!
                </p>
            </div>

            <!-- 3. DIRECT INCOME (10%) CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">3</span>
                    <span class="px-2.5 py-1 rounded-full bg-sky-500/20 text-sky-300 text-[10px] font-black font-mono uppercase border border-sky-500/40">Flat 10%</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Direct Income</h4>
                <h3 class="text-2xl font-black text-sky-400 font-mono mt-1">$4,820.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earn a <span class="gold-highlight">flat 10% instant</span> commission on every direct customer purchase with no limits.
                </p>
            </div>

            <!-- 4. MATCHING INCOME (5%) CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">4</span>
                    <span class="px-2.5 py-1 rounded-full bg-purple-500/20 text-purple-300 text-[10px] font-black font-mono uppercase border border-purple-500/40">Binary 5%</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Matching Income</h4>
                <h3 class="text-2xl font-black text-purple-300 font-mono mt-1">$2,632.86</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earn <span class="gold-highlight">5% binary matching</span> income based on a 50:50 ratio between Power & Weaker leg.
                </p>
            </div>

            <!-- 5. DIRECT SALARY INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">5</span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black font-mono uppercase border border-emerald-500/40">365 Days</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Direct Salary Income</h4>
                <h3 class="text-2xl font-black text-emerald-400 font-mono mt-1">$1,825.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earn a <span class="gold-highlight">stable daily salary</span> ($1 to $1,000/day) for 365 days based on direct volume.
                </p>
            </div>

            <!-- 6. TEAM SALARY INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">6</span>
                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black font-mono uppercase border border-amber-500/40">12 Months</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Team Salary Income</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$2,250.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earn <span class="gold-highlight">$75 per 15 days</span> for 12 months based on matching team business milestones.
                </p>
            </div>

            <!-- 7. REWARD INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">7</span>
                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black font-mono uppercase border border-amber-500/40">10% Reward</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Reward Income</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$3,940.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Achieve team volume targets and earn <span class="gold-highlight">10% exciting cash</span> & career rewards.
                </p>
            </div>

            <!-- TERMS & SYSTEM CAPPING CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">⚖️</span>
                    <span class="px-2.5 py-1 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-black font-mono uppercase border border-rose-500/40">Rules</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Plan Terms & Capping</h4>
                <h3 class="text-base font-black text-rose-300 font-mono mt-1">5X Capping Capped</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Min Deposit/Withdrawal $10. <span class="gold-highlight">10% Withdrawal deduction</span>. USDT (BEP20) 24x7.
                </p>
            </div>

        </div>
    </div>

    <!-- SIDE-BY-SIDE TABLES GRID (Col-sm-6 Split: Left Col-6 Recent Users Directory & Right Col-6 Recent Deposits) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 relative z-10">
        
        <!-- LEFT COL-6: RECENT USERS DIRECTORY -->
        <div class="p-6 rounded-3xl gold-card-animated space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-amber-500/20">
                <div class="px-3.5 py-1 rounded-xl bg-sky-500 text-black font-black text-xs uppercase tracking-wider shadow">
                    Recent Users
                </div>
                <a href="{{ route('admin.users') }}" class="px-3.5 py-1.5 rounded-xl border border-neutral-700 hover:bg-neutral-800 text-neutral-300 text-xs font-bold transition">
                    View All
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap">
                    <thead class="bg-[#050e08] text-amber-400 uppercase text-xs font-bold font-heading tracking-wider border-b border-amber-500/30">
                        <tr>
                            <th class="p-3.5 rounded-l-xl">USER PROFILE</th>
                            <th class="p-3.5">REFERRAL CODE & LINK</th>
                            <th class="p-3.5">SPONSOR INFO</th>
                            <th class="p-3.5">BINARY SIDE</th>
                            <th class="p-3.5">REGISTRATION DATE & TIME</th>
                            <th class="p-3.5">ACTIVATION DATE & TIME</th>
                            <th class="p-3.5">STATUS</th>
                            <th class="p-3.5 rounded-r-xl text-center">DIRECT ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/20 text-neutral-200">
                        <!-- User Row 1 -->
                        <tr class="hover:bg-amber-500/10 transition">
                            <td class="p-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow-md shrink-0">
                                        S
                                    </div>
                                    <div>
                                        <div class="font-black text-white text-xs">SANJOY DAS</div>
                                        <div class="text-[10px] text-neutral-400">chiltanew21@gmail.com</div>
                                        <div class="text-[10px] text-amber-400 font-mono">8754875487</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-black text-amber-400 font-mono text-xs">FE4754563</span>
                                        <button onclick="navigator.clipboard.writeText('FE4754563'); showToast('Copied!', 'Code copied.', 'success')" class="p-1 rounded hover:bg-amber-500/20 text-amber-400 transition">
                                            <i data-lucide="copy" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-[10px] text-neutral-400">Link:</span>
                                        <button onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=FE4754563') }}'); showToast('Copied!', 'Link copied.', 'success')" class="text-[10px] text-amber-300 hover:underline font-mono flex items-center gap-1">
                                            <i data-lucide="link" class="w-3 h-3 text-amber-400"></i> Copy Link
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <div>
                                    <div class="font-bold text-white text-xs">Anoop Kumar Yadav</div>
                                    <div class="text-[10px] text-amber-400 font-mono">NGF-8650830</div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-black uppercase">LEFT (POWER)</span>
                            </td>

                            <td class="p-3.5">
                                <div class="text-xs font-semibold text-white">Sep 01, 2026</div>
                                <div class="text-[10px] text-neutral-400 font-mono">08:02 PM</div>
                            </td>

                            <td class="p-3.5">
                                <div class="text-xs font-semibold text-emerald-400">Sep 01, 2026</div>
                                <div class="text-[10px] text-neutral-400 font-mono">08:10 PM</div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">ACTIVE</span>
                            </td>

                            <td class="p-3.5">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.users.impersonate', 1) }}" target="_blank" class="px-2.5 py-1 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 transition text-[10px] font-extrabold" title="Login as User">
                                        Login as User
                                    </a>
                                    <a href="{{ route('admin.network.direct', ['search' => 'FE4754563']) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Direct Team"><i data-lucide="users" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.network.tree', ['code' => 'FE4754563']) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Binary Tree"><i data-lucide="git-merge" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.users.show', 1) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="View Profile"><i data-lucide="eye" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.users.edit', 1) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Edit Member"><i data-lucide="edit-3" class="w-3.5 h-3.5"></i></a>
                                </div>
                            </td>
                        </tr>

                        <!-- User Row 2 -->
                        <tr class="hover:bg-amber-500/10 transition">
                            <td class="p-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow-md shrink-0">
                                        S
                                    </div>
                                    <div>
                                        <div class="font-black text-white text-xs">SAFI KAMAL MONDAL</div>
                                        <div class="text-[10px] text-neutral-400">safikamalmondal05@gmail.com</div>
                                        <div class="text-[10px] text-amber-400 font-mono">8745125478</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-black text-amber-400 font-mono text-xs">FE5124160</span>
                                        <button onclick="navigator.clipboard.writeText('FE5124160'); showToast('Copied!', 'Code copied.', 'success')" class="p-1 rounded hover:bg-amber-500/20 text-amber-400 transition">
                                            <i data-lucide="copy" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-[10px] text-neutral-400">Link:</span>
                                        <button onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=FE5124160') }}'); showToast('Copied!', 'Link copied.', 'success')" class="text-[10px] text-amber-300 hover:underline font-mono flex items-center gap-1">
                                            <i data-lucide="link" class="w-3 h-3 text-amber-400"></i> Copy Link
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <div>
                                    <div class="font-bold text-white text-xs">John Trader</div>
                                    <div class="text-[10px] text-amber-400 font-mono">NGF-0967542</div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-black uppercase">LEFT (POWER)</span>
                            </td>

                            <td class="p-3.5">
                                <div class="text-xs font-semibold text-white">Sep 01, 2026</div>
                                <div class="text-[10px] text-neutral-400 font-mono">07:39 PM</div>
                            </td>

                            <td class="p-3.5">
                                <div class="text-xs font-semibold text-emerald-400">Sep 01, 2026</div>
                                <div class="text-[10px] text-neutral-400 font-mono">07:45 PM</div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">ACTIVE</span>
                            </td>

                            <td class="p-3.5">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.users.impersonate', 2) }}" target="_blank" class="px-2.5 py-1 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 transition text-[10px] font-extrabold" title="Login as User">
                                        Login as User
                                    </a>
                                    <a href="{{ route('admin.network.direct', ['search' => 'FE5124160']) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Direct Team"><i data-lucide="users" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.network.tree', ['code' => 'FE5124160']) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Binary Tree"><i data-lucide="git-merge" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.users.show', 2) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="View Profile"><i data-lucide="eye" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.users.edit', 2) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Edit Member"><i data-lucide="edit-3" class="w-3.5 h-3.5"></i></a>
                                </div>
                            </td>
                        </tr>

                        <!-- User Row 3 -->
                        <tr class="hover:bg-amber-500/10 transition">
                            <td class="p-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-xs flex items-center justify-center shadow-md shrink-0">
                                        S
                                    </div>
                                    <div>
                                        <div class="font-black text-white text-xs">SUBHAS NAYAK</div>
                                        <div class="text-[10px] text-neutral-400">subhasnayak709@gmail.com</div>
                                        <div class="text-[10px] text-amber-400 font-mono">9876543210</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-black text-amber-400 font-mono text-xs">FE4718026</span>
                                        <button onclick="navigator.clipboard.writeText('FE4718026'); showToast('Copied!', 'Code copied.', 'success')" class="p-1 rounded hover:bg-amber-500/20 text-amber-400 transition">
                                            <i data-lucide="copy" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-[10px] text-neutral-400">Link:</span>
                                        <button onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=FE4718026') }}'); showToast('Copied!', 'Link copied.', 'success')" class="text-[10px] text-amber-300 hover:underline font-mono flex items-center gap-1">
                                            <i data-lucide="link" class="w-3 h-3 text-amber-400"></i> Copy Link
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <div>
                                    <div class="font-bold text-white text-xs">Super Admin</div>
                                    <div class="text-[10px] text-amber-400 font-mono">NGF-0000001</div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-black uppercase">LEFT (POWER)</span>
                            </td>

                            <td class="p-3.5">
                                <div class="text-xs font-semibold text-white">Aug 31, 2026</div>
                                <div class="text-[10px] text-neutral-400 font-mono">12:33 PM</div>
                            </td>

                            <td class="p-3.5">
                                <div class="text-xs font-semibold text-emerald-400">Aug 31, 2026</div>
                                <div class="text-[10px] text-neutral-400 font-mono">12:40 PM</div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] font-black uppercase">ACTIVE</span>
                            </td>

                            <td class="p-3.5">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.users.impersonate', 3) }}" target="_blank" class="px-2.5 py-1 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30 transition text-[10px] font-extrabold" title="Login as User">
                                        Login as User
                                    </a>
                                    <a href="{{ route('admin.network.direct', ['search' => 'FE4718026']) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Direct Team"><i data-lucide="users" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.network.tree', ['code' => 'FE4718026']) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Binary Tree"><i data-lucide="git-merge" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.users.show', 3) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="View Profile"><i data-lucide="eye" class="w-3.5 h-3.5"></i></a>
                                    <a href="{{ route('admin.users.edit', 3) }}" class="p-1.5 rounded-lg border border-amber-500/60 bg-amber-500/10 text-amber-300 hover:bg-amber-500/30" title="Edit Member"><i data-lucide="edit-3" class="w-3.5 h-3.5"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT COL-6: RECENT PLATFORM DEPOSITS -->
        <div class="p-6 rounded-3xl gold-card-animated space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-amber-500/20">
                <h3 class="text-base font-black text-white font-heading">Recent Platform Deposits</h3>
                <span class="text-xs text-neutral-400 font-semibold">Latest Records</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-amber-500/20 text-amber-400 font-black uppercase">
                            <th class="py-2.5 px-3">User</th>
                            <th class="py-2.5 px-3">Amount</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-right">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/10 text-neutral-300 font-medium">
                        <!-- Row 1 -->
                        <tr class="hover:bg-amber-500/5 transition">
                            <td class="py-3 px-3 font-black text-white">SANCHAITA RAM</td>
                            <td class="py-3 px-3 font-mono font-bold text-emerald-400 text-sm">$100.00</td>
                            <td class="py-3 px-3">
                                <span class="px-2.5 py-0.5 rounded bg-rose-500 text-white font-black text-[10px] uppercase tracking-wider shadow">SUCCESS</span>
                            </td>
                            <td class="py-3 px-3 text-right font-mono text-neutral-400">01 Sep 2026, 08:15 PM</td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-amber-500/5 transition">
                            <td class="py-3 px-3 font-black text-white">SANCHAITA RAM</td>
                            <td class="py-3 px-3 font-mono font-bold text-emerald-400 text-sm">$100.00</td>
                            <td class="py-3 px-3">
                                <span class="px-2.5 py-0.5 rounded bg-rose-500 text-white font-black text-[10px] uppercase tracking-wider shadow">SUCCESS</span>
                            </td>
                            <td class="py-3 px-3 text-right font-mono text-neutral-400">01 Sep 2026, 08:10 PM</td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-amber-500/5 transition">
                            <td class="py-3 px-3 font-black text-white">NEMAI CHANDRA KUNDU</td>
                            <td class="py-3 px-3 font-mono font-bold text-amber-400 text-sm">$10.00</td>
                            <td class="py-3 px-3">
                                <span class="px-2.5 py-0.5 rounded bg-amber-500 text-black font-black text-[10px] uppercase tracking-wider shadow">PENDING</span>
                            </td>
                            <td class="py-3 px-3 text-right font-mono text-neutral-400">01 Sep 2026, 07:50 PM</td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="hover:bg-amber-500/5 transition">
                            <td class="py-3 px-3 font-black text-white">SUBHAS NAYAK</td>
                            <td class="py-3 px-3 font-mono font-bold text-emerald-400 text-sm">$100.00</td>
                            <td class="py-3 px-3">
                                <span class="px-2.5 py-0.5 rounded bg-rose-500 text-white font-black text-[10px] uppercase tracking-wider shadow">SUCCESS</span>
                            </td>
                            <td class="py-3 px-3 text-right font-mono text-neutral-400">31 Aug 2026, 01:20 PM</td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="hover:bg-amber-500/5 transition">
                            <td class="py-3 px-3 font-black text-white">BIREN MONDAL</td>
                            <td class="py-3 px-3 font-mono font-bold text-emerald-400 text-sm">$100.00</td>
                            <td class="py-3 px-3">
                                <span class="px-2.5 py-0.5 rounded bg-rose-500 text-white font-black text-[10px] uppercase tracking-wider shadow">SUCCESS</span>
                            </td>
                            <td class="py-3 px-3 text-right font-mono text-neutral-400">28 Aug 2026, 11:45 AM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection