@extends('user.layouts.app')

@section('title', 'Trading BOT Overview')

@section('content')
    <style>
        /* Force Exactly 3 Cards in 1 Row on screens >= 640px */
        @media (min-width: 640px) {
            .bot-cards-row {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 1.25rem !important;
            }
        }
    </style>

    <div class="w-full space-y-6">

        <!-- Top Header Banner (Full Mobile Responsive) -->
        <div class="p-4 sm:p-6 rounded-2xl bg-gradient-to-r from-amber-950/60 via-black to-amber-950/60 border border-amber-500/40 shadow-xl flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="space-y-1 w-full lg:w-auto">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400/50 text-amber-300 text-[10px] font-black tracking-widest uppercase">BOT OVERVIEW</span>
                    <span class="text-[10px] sm:text-[11px] text-amber-400 font-extrabold tracking-[2px] uppercase">NEXTGEN QUANT SYSTEM</span>
                </div>
                <h1 class="text-lg sm:text-2xl lg:text-3xl font-black text-amber-300 font-heading tracking-tight drop-shadow">
                    QUANT TRADING BOT SYSTEM
                </h1>
                <p class="text-xs sm:text-sm text-neutral-300 max-w-2xl font-medium">
                    Activate NextGen Autonomous Quant Bot to execute high-frequency crypto trading and compound your daily ROI.
                </p>
            </div>

            <div class="w-full lg:w-auto flex items-center justify-start lg:justify-end shrink-0">
                @if($user->is_bot_active)
                    <div class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-500/20 border border-emerald-500/60 text-emerald-300 text-xs font-black flex items-center justify-center gap-2 shadow-md">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span>BOT ACTIVE (Since {{ $user->bot_activated_at?->format('M d, Y H:i') }})</span>
                    </div>
                @else
                    <div class="w-full sm:w-auto px-4 py-2 rounded-xl bg-amber-500/20 border border-amber-500/60 text-amber-300 text-xs font-black flex items-center justify-center gap-2 shadow-md">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                        </span>
                        <span>STATUS: READY FOR ACTIVATION</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- 3 Feature Cards (1 Row on Desktop/Tablet, Stacking cleanly on Mobile) -->
        <div class="grid grid-cols-1 bot-cards-row gap-4 sm:gap-5">

            <!-- Card 1 -->
            <div class="p-4 sm:p-5 rounded-2xl bg-neutral-900/90 border border-amber-500/30 hover:border-amber-400/70 transition shadow-lg flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-400 mb-3 shadow-inner">
                        <i data-lucide="cpu" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1.5">High-Frequency Quant Engine</h3>
                    <p class="text-xs text-neutral-300 leading-relaxed font-normal">
                        Our Quant Bot continuously scans sub-second liquidity orderbooks across Binance, OKX, and Bybit to capture arbitrage opportunities.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-neutral-800 text-[11px] text-amber-400 font-mono font-semibold flex items-center gap-1.5">
                    <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-400"></i> Sub-millisecond Execution
                </div>
            </div>

            <!-- Card 2 -->
            <div class="p-4 sm:p-5 rounded-2xl bg-neutral-900/90 border border-amber-500/30 hover:border-amber-400/70 transition shadow-lg flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-400 mb-3 shadow-inner">
                        <i data-lucide="trending-up" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1.5">Automated Daily ROI Mining</h3>
                    <p class="text-xs text-neutral-300 leading-relaxed font-normal">
                        Once triggered, the Bot manages position sizing and risk profiles automatically, compounding your daily yield 24/7.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-neutral-800 text-[11px] text-emerald-400 font-mono font-semibold flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-400"></i> 24/7 Yield Compounding
                </div>
            </div>

            <!-- Card 3 -->
            <div class="p-4 sm:p-5 rounded-2xl bg-neutral-900/90 border border-amber-500/30 hover:border-amber-400/70 transition shadow-lg flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-400 mb-3 shadow-inner">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1.5">One-Time Lifetime Activation</h3>
                    <p class="text-xs text-neutral-300 leading-relaxed font-normal">
                        Activation requires only one simple click on our Live Trading Terminal. No re-subscriptions or manual setups.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-neutral-800 text-[11px] text-amber-300 font-mono font-semibold flex items-center gap-1.5">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-amber-300"></i> Single Click Setup
                </div>
            </div>

        </div>

        <!-- Full Width, Slim & Compact CTA Card (Mobile Responsive) -->
        <div class="w-full p-4 sm:p-5 rounded-2xl bg-neutral-900/90 border border-amber-500/40 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="space-y-1 text-center md:text-left w-full md:w-auto">
                <h2 class="text-base sm:text-lg font-black text-amber-300 tracking-wide">
                    Ready to Launch Live Trading Terminal?
                </h2>
                <p class="text-xs text-neutral-300 font-normal">
                    Open the interactive TradingView market terminal, monitor real-time crypto charts, select trading pairs, and activate your Quant Bot.
                </p>
            </div>
            <div class="shrink-0 w-full md:w-auto flex justify-center">
                <a href="{{ route('user.bot.trading') }}"
                    class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-yellow-300 text-black font-black text-xs sm:text-sm uppercase tracking-wider shadow-[0_0_20px_rgba(243,202,82,0.5)] hover:scale-105 transition flex items-center justify-center gap-2 border border-yellow-200">
                    <i data-lucide="play-circle" class="w-4 h-4 text-black fill-black"></i>
                    <span>{{ $user->is_bot_active ? 'View Live Trading Terminal' : 'Start BOT & Open Terminal' }}</span>
                </a>
            </div>
        </div>

    </div>
@endsection
