@extends('user.layouts.app')

@section('content')
<style>
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

    <!-- Top Header Banner -->
    <div class="p-6 rounded-3xl gold-card-animated flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
        <div>
            <div class="flex items-center gap-2 text-amber-400 text-xs font-bold uppercase tracking-widest mb-1">
                @if(Auth::user() && Auth::user()->status === 'active')
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                    NEXTGEN FOREX MEMBER PORTAL • LIVE ACTIVE ACCOUNT
                @else
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                    NEXTGEN FOREX MEMBER PORTAL • MEMBER PORTAL
                @endif
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white font-heading">Welcome Back, <span class="gold-highlight">{{ Auth::user() ? Auth::user()->name : 'Member' }}</span></h1>
            <p class="text-xs text-neutral-300 mt-1">Referral Code: <span class="text-amber-400 font-bold font-mono">{{ Auth::user() ? Auth::user()->referral_code : 'NGF-0967542' }}</span> • Status: 
                @if(Auth::user() && Auth::user()->status === 'active')
                    <span class="text-emerald-400 font-bold uppercase">ACTIVE MEMBER</span>
                @else
                    <span class="text-amber-400 font-bold uppercase">PARTNER ACCOUNT</span>
                @endif
            </p>
        </div>
        <div class="px-5 py-2.5 rounded-2xl bg-black/80 border-2 border-amber-400/80 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-xl">
            <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
            <span>{{ date('l, d M Y') }}</span>
        </div>
    </div>

    <!-- Dual Referral Links Banner (Left Leg & Right Leg) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
        <!-- LEFT LEG LINK -->
        <div class="p-4 rounded-3xl gold-card-animated flex items-center justify-between gap-3 shadow-xl">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black shrink-0">
                    <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
                </div>
                <div class="overflow-hidden">
                    <span class="text-xs font-extrabold text-amber-400 uppercase tracking-wider block">LEFT LEG REFERRAL LINK (POWER LEG)</span>
                    <p class="text-xs text-neutral-300 font-mono truncate">{{ url('/user/register?sponsor=' . (Auth::user() ? Auth::user()->referral_code : 'NGF-0967542') . '&position=left') }}</p>
                </div>
            </div>
            <button onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=' . (Auth::user() ? Auth::user()->referral_code : 'NGF-0967542') . '&position=left') }}'); showToast('Copied!', 'Left leg referral link copied.', 'success');" class="px-4 py-2 rounded-xl bg-amber-400 text-black text-xs font-black uppercase hover:bg-amber-300 transition shrink-0 shadow-lg">
                Copy Left
            </button>
        </div>

        <!-- RIGHT LEG LINK -->
        <div class="p-4 rounded-3xl gold-card-animated flex items-center justify-between gap-3 shadow-xl">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black shrink-0">
                    <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                </div>
                <div class="overflow-hidden">
                    <span class="text-xs font-extrabold text-emerald-400 uppercase tracking-wider block">RIGHT LEG REFERRAL LINK (WEAKER LEG)</span>
                    <p class="text-xs text-neutral-300 font-mono truncate">{{ url('/user/register?sponsor=' . (Auth::user() ? Auth::user()->referral_code : 'NGF-0967542') . '&position=right') }}</p>
                </div>
            </div>
            <button onclick="navigator.clipboard.writeText('{{ url('/user/register?sponsor=' . (Auth::user() ? Auth::user()->referral_code : 'NGF-0967542') . '&position=right') }}'); showToast('Copied!', 'Right leg referral link copied.', 'success');" class="px-4 py-2 rounded-xl bg-emerald-400 text-black text-xs font-black uppercase hover:bg-emerald-300 transition shrink-0 shadow-lg">
                Copy Right
            </button>
        </div>
    </div>

    <!-- 4 MAIN FINANCIAL WALLETS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 relative z-10">
        <!-- Stat 1: Total Investment -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-neutral-300">Total Investment</span>
                <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="landmark" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black text-amber-300 font-mono mt-1 gold-highlight">$500.00</h3>
            <p class="text-[11px] text-emerald-400 font-semibold mt-1">Package 2 Active (200 Days)</p>
        </div>

        <!-- Stat 2: Total Earnings -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-neutral-300">Total Earnings</span>
                <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="coins" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black text-emerald-400 font-mono mt-1">$185.50</h3>
            <p class="text-[11px] text-neutral-400 font-semibold mt-1">ROI + Referral + Matching</p>
        </div>

        <!-- Stat 3: Available Wallet Balance -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-neutral-300">Available Balance</span>
                <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black text-sky-400 font-mono mt-1">$125.00</h3>
            <p class="text-[11px] text-neutral-400 font-semibold mt-1">Ready for Withdrawal</p>
        </div>

        <!-- Stat 4: Total Withdrawal -->
        <div class="p-5 rounded-3xl gold-card-animated relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-neutral-300">Total Withdrawals</span>
                <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black">
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black text-purple-300 font-mono mt-1">$60.50</h3>
            <p class="text-[11px] text-neutral-400 font-semibold mt-1">USDT (BEP20) Paid</p>
        </div>
    </div>

    <!-- LUXURY NEXTGEN FOREX PDF PLAN INCOME CARDS (Matching PDF Slide 10 & 12) -->
    <div class="space-y-4 pt-4 relative z-10">
        <div class="flex items-center justify-between border-b-2 border-amber-400/40 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl gold-3d-badge flex items-center justify-center text-black font-black text-xl shadow-lg">
                    💎
                </div>
                <div>
                    <h2 class="text-xl font-black text-gold-gradient font-heading tracking-wide uppercase">MY 7 INCOME STREAMS SUMMARY</h2>
                    <p class="text-xs text-neutral-300">Official Compensation Plan Payout Breakdown (PDF Slide 12)</p>
                </div>
            </div>
            <span class="px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 border-2 border-emerald-400/60 font-mono text-xs font-black uppercase tracking-wider shadow-lg">
                Active Member Plan
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- 1. ROI INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">1</span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-black font-mono uppercase border border-emerald-500/40">Daily Return</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">ROI Income</h4>
                <h3 class="text-2xl font-black text-emerald-400 font-mono mt-1">$85.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Daily <span class="gold-highlight">0.75% Return</span> on $500 package for 200 Days (<span class="text-emerald-400 font-bold">2X Return</span>).
                </p>
            </div>

            <!-- 2. 24H SPECIAL BONUS CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">2</span>
                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black font-mono uppercase border border-amber-500/40">24h Offer</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">24 Hours Special Bonus</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$50.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Unlocked <span class="gold-highlight">Tier 1 Bonus</span> by completing 5 direct referrals in 24h!
                </p>
            </div>

            <!-- 3. DIRECT INCOME (10%) CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">3</span>
                    <span class="px-2.5 py-1 rounded-full bg-sky-500/20 text-sky-300 text-[10px] font-black font-mono uppercase border border-sky-500/40">Flat 10%</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Direct Income</h4>
                <h3 class="text-2xl font-black text-sky-400 font-mono mt-1">$50.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earned <span class="gold-highlight">flat 10% instant</span> commission from direct referrals.
                </p>
            </div>

            <!-- 4. MATCHING INCOME (5%) CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">4</span>
                    <span class="px-2.5 py-1 rounded-full bg-purple-500/20 text-purple-300 text-[10px] font-black font-mono uppercase border border-purple-500/40">Binary 5%</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Matching Income</h4>
                <h3 class="text-2xl font-black text-purple-300 font-mono mt-1">$25.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earned <span class="gold-highlight">5% binary volume</span> matching based on 50:50 leg ratio.
                </p>
            </div>

            <!-- 5. DIRECT SALARY INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">5</span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black font-mono uppercase border border-emerald-500/40">365 Days</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Direct Salary Income</h4>
                <h3 class="text-2xl font-black text-emerald-400 font-mono mt-1">$15.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    <span class="gold-highlight">Stable daily salary</span> paid for 365 days based on direct business.
                </p>
            </div>

            <!-- 6. TEAM SALARY INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">6</span>
                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black font-mono uppercase border border-amber-500/40">12 Months</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Team Salary Income</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$0.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Unlock <span class="gold-highlight">$75 per 15 days</span> for 12 months on reaching 5,000 team volume.
                </p>
            </div>

            <!-- 7. REWARD INCOME CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">7</span>
                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black font-mono uppercase border border-amber-500/40">10% Reward</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">Reward Income</h4>
                <h3 class="text-2xl font-black gold-highlight font-mono mt-1">$10.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    Earn <span class="gold-highlight">10% reward</span> on team volume milestones.
                </p>
            </div>

            <!-- TERMS & SYSTEM CAPPING CARD -->
            <div class="p-5 rounded-3xl gold-card-animated relative group">
                <div class="flex justify-between items-center mb-3">
                    <span class="w-8 h-8 rounded-xl gold-3d-badge text-black font-black text-xs flex items-center justify-center">⚖️</span>
                    <span class="px-2.5 py-1 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-black font-mono uppercase border border-rose-500/40">5X Limit</span>
                </div>
                <h4 class="text-sm font-black text-white font-heading uppercase tracking-wide">5X Capping Limit</h4>
                <h3 class="text-base font-black text-rose-300 font-mono mt-1">$185.50 / $1,000.00</h3>
                <p class="text-xs text-neutral-300 font-medium mt-2 leading-relaxed">
                    <span class="gold-highlight">18.5% progress</span>. 10% WD deduction applied on USDT.
                </p>
            </div>

        </div>
    </div>

</div>
@endsection
