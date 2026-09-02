@extends('user.layouts.app')

@section('content')
<style>
.gold-3d-badge {
    background: linear-gradient(180deg, #fef08a 0%, #f59e0b 50%, #b45309 100%) !important;
    border: 2px solid #fef08a !important;
    box-shadow: 0 4px 15px rgba(243, 202, 82, 0.4), inset 0 2px 4px rgba(255, 255, 255, 0.6) !important;
}

/* Force Exactly 3 Cards Per Row on Screens >= 768px */
@media (min-width: 768px) {
    .grid-3-cards {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 1.5rem !important;
    }
}
</style>

<div class="w-full space-y-6">
    
    <!-- Top Header Banner (Matching User Management & Admin Flow Exactly) -->
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
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        
        <!-- Filter Header Bar -->
        <div class="flex items-center justify-between border-b border-amber-500/20 pb-4">
            <div class="flex items-center gap-2.5">
                <span class="px-5 py-2.5 rounded-xl text-xs font-black bg-amber-500 text-black shadow-md flex items-center gap-2">
                    <i data-lucide="package" class="w-4 h-4"></i> Available Packages ({{ $packages->count() }})
                </span>
            </div>
        </div>

        <!-- PACKAGES GRID CARDS (EXACTLY 3 CARDS PER ROW: .grid-3-cards) -->
        <div class="grid grid-cols-1 grid-3-cards gap-6">
            @foreach($packages as $pkg)
            <div class="p-6 rounded-3xl bg-bg border border-amber-500/40 space-y-4 relative overflow-hidden group flex flex-col justify-between hover:border-amber-400/80 transition shadow-xl">
                
                <div class="space-y-3">
                    <!-- Top Row with 3D Gold Badge & ROI Pill -->
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl gold-3d-badge text-black flex items-center justify-center font-black text-lg shadow-md shrink-0">
                            @if($loop->index == 0)
                                <i data-lucide="coins" class="w-5 h-5"></i>
                            @elseif($loop->index == 1)
                                <i data-lucide="rocket" class="w-5 h-5"></i>
                            @elseif($loop->index == 2)
                                <i data-lucide="trending-up" class="w-5 h-5"></i>
                            @elseif($loop->index == 3)
                                <i data-lucide="globe" class="w-5 h-5"></i>
                            @else
                                <i data-lucide="trophy" class="w-5 h-5"></i>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-bold font-mono uppercase">
                            {{ number_format($pkg->daily_roi, 2) }}% / Day
                        </span>
                    </div>

                    <!-- Package Title & Range -->
                    <div>
                        <div class="text-xs font-extrabold text-neutral-300 uppercase tracking-wider">{{ $pkg->name }}</div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gold-gradient font-mono mt-1">${{ number_format($pkg->min_amount, 0) }} - ${{ number_format($pkg->max_amount, 0) }}</h3>
                    </div>

                    <!-- Package Details Box -->
                    <div class="p-4 rounded-2xl bg-panel border border-amber-500/30 space-y-2 font-mono">
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
                <form action="{{ route('user.packages.buy') }}" method="POST" class="space-y-3 pt-2" onsubmit="return confirm('Confirm purchasing {{ $pkg->name }} with your Deposit Wallet balance?')">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $pkg->id }}">

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-amber-400 uppercase tracking-wider block">Investment Amount ($)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400 font-bold text-xs">$</span>
                            <input type="number" step="0.01" min="{{ $pkg->min_amount }}" max="{{ $pkg->max_amount }}" name="invested_amount" value="{{ old('invested_amount', $pkg->min_amount) }}" class="w-full pl-8 pr-3 py-2.5 rounded-xl bg-panel border border-amber-500/40 text-white font-mono font-bold text-xs focus:outline-none focus:border-amber-400" required>
                        </div>
                        <p class="text-[10px] text-neutral-400">Min: ${{ number_format($pkg->min_amount, 0) }} | Max: ${{ number_format($pkg->max_amount, 0) }}</p>
                    </div>

                    <!-- Bottom Solid Gold Button -->
                    <button type="submit" class="w-full py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-[1.02] transition flex items-center justify-center gap-1.5">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-black"></i> BUY {{ $pkg->name }} NOW
                    </button>
                </form>

            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
