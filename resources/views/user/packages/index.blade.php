@extends('user.layouts.app')

@section('content')
<style>
.pdf-gold-badge {
    background: linear-gradient(180deg, #fef08a 0%, #f59e0b 50%, #b45309 100%) !important;
    border: 2px solid #fef08a !important;
    box-shadow: 0 0 20px rgba(243, 202, 82, 0.7), inset 0 2px 4px rgba(255, 255, 255, 0.8) !important;
}

.pdf-gold-ribbon {
    background: linear-gradient(90deg, #d97706 0%, #fef08a 50%, #d97706 100%) !important;
    color: #000000 !important;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.4);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
}

.pdf-package-card {
    background: linear-gradient(180deg, #063824 0%, #021d12 50%, #000000 100%) !important;
    border: 2px solid rgba(243, 202, 82, 0.8) !important;
    box-shadow: 0 0 25px rgba(243, 202, 82, 0.25), inset 0 1px 2px rgba(255, 255, 255, 0.2) !important;
}

/* Force Exactly 3 Cards Per Row on Screens >= 768px */
@media (min-width: 768px) {
    .grid-3-cards {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 2rem !important;
    }
}
</style>

<div class="w-full space-y-6">
    
    <!-- Top Header Banner -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">BP</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX MEMBER PORTAL</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">BUY INVESTMENT PACKAGE</h1>
            <p class="text-xs text-neutral-300 mt-1">Select your preferred growth package (PDF Slides 11 & 13) and start earning daily ROI.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3">
            <div class="px-5 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-lg shrink-0">
                <i data-lucide="wallet" class="w-4 h-4 text-amber-400"></i>
                <span>Deposit Wallet: <strong class="text-emerald-400 text-sm font-black">${{ number_format($user->deposit_wallet, 2) }}</strong></span>
            </div>
            <a href="{{ route('user.deposits.index') }}" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-black text-xs font-black uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center gap-1.5 shrink-0">
                <i data-lucide="plus-circle" class="w-4 h-4 text-black"></i> Add Fund
            </a>
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

    <!-- Main Panel Container -->
    <div class="bg-panel p-6 sm:p-8 shadow-2xl rounded-3xl border border-amber-500/30 space-y-8">
        
        <!-- Section Header Banner matching PDF -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center px-8 py-2 rounded-full pdf-gold-ribbon text-base font-black uppercase tracking-widest shadow-xl">
                👑 CHOOSE YOUR PACKAGE
            </div>
            <p class="text-xs text-amber-400 font-extrabold tracking-widest uppercase">AND START YOUR GROWTH JOURNEY TODAY</p>
        </div>

        <!-- PACKAGES GRID CARDS (MATCHING PDF SLIDE DESIGN 100%) -->
        <div class="grid grid-cols-1 grid-3-cards gap-8 pt-4">
            @foreach($packages as $pkg)
            <div class="pdf-package-card rounded-3xl p-6 pt-6 relative flex flex-col justify-between space-y-4 text-center group hover:scale-[1.03] transition duration-300">
                
                <div class="space-y-4">
                    <!-- TOP CIRCULAR GOLD BADGE (MATCHING PDF ICON CLEANLY INLINED) -->
                    <div class="w-14 h-14 rounded-full pdf-gold-badge text-black flex items-center justify-center font-black text-xl shadow-2xl mx-auto">
                        @if($loop->index == 0)
                            <i data-lucide="coins" class="w-7 h-7 text-black"></i>
                        @elseif($loop->index == 1)
                            <i data-lucide="rocket" class="w-7 h-7 text-black"></i>
                        @elseif($loop->index == 2)
                            <i data-lucide="trending-up" class="w-7 h-7 text-black"></i>
                        @elseif($loop->index == 3)
                            <i data-lucide="globe" class="w-7 h-7 text-black"></i>
                        @else
                            <i data-lucide="shield-check" class="w-7 h-7 text-black"></i>
                        @endif
                    </div>

                    <!-- GOLD RIBBON PACKAGE NAME HEADER -->
                    <div>
                        <div class="inline-block px-6 py-1.5 rounded-full pdf-gold-ribbon text-xs font-black uppercase tracking-widest shadow-md">
                            PACKAGE {{ $loop->iteration }}
                        </div>
                    </div>

                    <!-- METALLIC PRICE RANGE TITLE (e.g. $10 to $100) -->
                    <h3 class="text-2xl font-black text-white font-mono tracking-tight pt-1">
                        ${{ number_format($pkg->min_amount, 0) }} to {{ $pkg->max_amount >= 999999 ? 'Above' : '$'.number_format($pkg->max_amount, 0) }}
                    </h3>

                    <!-- PACKAGE DETAILS BOX -->
                    <div class="p-4 rounded-2xl bg-black/70 border border-amber-500/40 space-y-2 font-mono text-left">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-neutral-400 font-sans font-bold">Daily Income:</span>
                            <span class="text-amber-300 font-black text-sm">{{ number_format($pkg->daily_roi, 2) }}% / Day</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-neutral-400 font-sans font-bold">Duration:</span>
                            <span class="text-white font-black text-sm">{{ $pkg->duration_days }} Days</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-neutral-400 font-sans font-bold">Total Return:</span>
                            <span class="text-amber-300 font-black text-sm">{{ number_format($pkg->total_return_multiplier, 1) }}X Return</span>
                        </div>
                    </div>
                </div>

                <!-- Purchase Form -->
                <form action="{{ route('user.packages.buy') }}" method="POST" class="space-y-3 pt-2 text-left" onsubmit="return confirm('Confirm purchasing {{ $pkg->name }} with your Deposit Wallet balance?')">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $pkg->id }}">

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-amber-400 uppercase tracking-wider block">Investment Amount ($)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400 font-bold text-xs">$</span>
                            <input type="number" step="0.01" min="{{ $pkg->min_amount }}" max="{{ $pkg->max_amount }}" name="invested_amount" value="{{ old('invested_amount', $pkg->min_amount) }}" class="w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/80 border border-amber-500/40 text-white font-mono font-bold text-xs focus:outline-none focus:border-amber-400" required>
                        </div>
                        <p class="text-[10px] text-neutral-400">Min: ${{ number_format($pkg->min_amount, 0) }} | Max: ${{ $pkg->max_amount >= 999999 ? 'Unlimited' : '$'.number_format($pkg->max_amount, 0) }}</p>
                    </div>

                    <!-- Bottom Metallic Gold Button -->
                    <button type="submit" class="w-full py-3 rounded-xl pdf-gold-ribbon hover:brightness-110 text-black font-black text-xs uppercase tracking-wider shadow-lg transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-black"></i> BUY PACKAGE {{ $loop->iteration }} NOW
                    </button>
                </form>

            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
