@extends('user.layouts.app')

@section('title', 'Trading BOT Overview')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-card: rgba(6, 26, 17, 0.85);
            --bg-card-header: linear-gradient(90deg, rgba(6, 40, 26, 0.95) 0%, rgba(2, 29, 18, 0.95) 100%);
            --border-card: rgba(243, 202, 82, 0.35);
            --accent-gold: #f3ca52;
            --accent-gold-bright: #fef08a;
            --accent-emerald: #10b981;
        }

        /* 3D Glass Card Styling */
        .ng-bot-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-card);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .ng-bot-card:hover {
            border-color: rgba(243, 202, 82, 0.65);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.7), 0 0 25px rgba(243, 202, 82, 0.25);
            transform: translateY(-3px);
        }

        /* Pulse Beacon Ring */
        @keyframes beaconRing {
            0% { transform: scale(0.6); opacity: 0.9; }
            70% { transform: scale(2.2); opacity: 0; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        .beacon-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            position: relative;
        }
        .beacon-dot::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: inherit;
            opacity: 0.6;
            animation: beaconRing 1.8s cubic-bezier(0.24, 0, 0.38, 1) infinite;
        }

        /* Force 3 Cards in 1 Row on screens >= 768px */
        @media (min-width: 768px) {
            .bot-cards-row {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 1.25rem !important;
            }
        }
    </style>

    <div class="w-full space-y-6">

        <!-- Top Header Banner (NextGen Forex Gold & Emerald Theme) -->
        <div class="p-5 sm:p-8 rounded-2xl bg-gradient-to-r from-amber-950/60 via-black to-amber-950/60 border border-amber-500/40 shadow-2xl flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 relative overflow-hidden text-left">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="space-y-1.5 z-10 text-left">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400/50 text-amber-300 text-[10px] font-black tracking-widest uppercase">BOT OVERVIEW</span>
                    <span class="text-[10px] sm:text-[11px] text-amber-400 font-extrabold tracking-[2px] uppercase">NEXTGEN QUANT TRADING SYSTEM</span>
                </div>
                <h1 class="text-xl sm:text-3xl font-black text-amber-300 font-heading tracking-tight drop-shadow uppercase flex items-center gap-3 text-left">
                    <i class="fa-solid fa-robot text-amber-400 animate-pulse"></i>
                    QUANT TRADING BOT SYSTEM
                </h1>
                <p class="text-xs sm:text-sm text-neutral-300 max-w-2xl font-medium text-left">
                    Activate NextGen Autonomous Quant Bot to execute high-frequency crypto trading and compound your daily ROI.
                </p>
            </div>

            <div class="z-10 w-full lg:w-auto flex items-center justify-start lg:justify-end shrink-0">
                @if($user->is_bot_active)
                    <div class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-500/20 border border-emerald-500/60 text-emerald-300 text-xs font-black flex items-center justify-center gap-2.5 shadow-xl">
                        <div class="beacon-dot bg-emerald-400"></div>
                        <span>BOT ACTIVE (Since {{ $user->bot_activated_at?->format('M d, Y H:i') }})</span>
                    </div>
                @else
                    <div class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-amber-500/20 border border-amber-500/60 text-amber-300 text-xs font-black flex items-center justify-center gap-2.5 shadow-xl">
                        <div class="beacon-dot bg-amber-400"></div>
                        <span>STATUS: READY FOR ACTIVATION</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- 4 Stat Summary Cards (2-Column Mobile Grid) -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            <!-- Card 1 -->
            <div class="ng-bot-card p-4 sm:p-5 flex items-center gap-4 overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-black flex items-center justify-center font-black text-xl shadow-lg shrink-0">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <div class="text-[11px] text-amber-400/90 font-extrabold uppercase tracking-wider truncate text-left">Bot Status</div>
                    <div class="text-xs sm:text-sm md:text-base font-black truncate text-left {{ $user->is_bot_active ? 'text-emerald-400' : 'text-amber-400' }}">
                        {{ $user->is_bot_active ? 'ACTIVE 24/7' : 'READY TO START' }}
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="ng-bot-card p-4 sm:p-5 flex items-center gap-4 overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 text-black flex items-center justify-center font-black text-xl shadow-lg shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <div class="text-[11px] text-emerald-400/90 font-extrabold uppercase tracking-wider truncate text-left">Daily ROI Yield</div>
                    <div class="text-xs sm:text-sm md:text-base font-black text-white font-mono truncate text-left">0.50% - 1.50%</div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="ng-bot-card p-4 sm:p-5 flex items-center gap-4 overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-400 to-amber-600 text-black flex items-center justify-center font-black text-xl shadow-lg shrink-0">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <div class="text-[11px] text-amber-300/90 font-extrabold uppercase tracking-wider truncate text-left">Earning Wallet</div>
                    <div class="text-xs sm:text-sm md:text-base font-black text-amber-300 font-mono truncate text-left">${{ number_format($user->earning_wallet, 2) }}</div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="ng-bot-card p-4 sm:p-5 flex items-center gap-4 overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 text-black flex items-center justify-center font-black text-xl shadow-lg shrink-0">
                    <i class="fa-solid fa-server"></i>
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <div class="text-[11px] text-cyan-400/90 font-extrabold uppercase tracking-wider truncate text-left">Exchange Nodes</div>
                    <div class="text-xs sm:text-sm font-black text-white truncate text-left">Binance • OKX • Bybit</div>
                </div>
            </div>
        </div>

        <!-- 3 Feature Cards (1 Row on Desktop/Tablet, Stacking cleanly on Mobile) -->
        <div class="grid grid-cols-1 bot-cards-row gap-4 sm:gap-5">

            <!-- Card 1 -->
            <div class="ng-bot-card p-5 sm:p-6 flex flex-col justify-between text-left">
                <div class="text-left">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-500 text-black flex items-center justify-center mb-4 shadow-lg text-xl">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-white mb-2 flex items-center gap-2 text-left">
                        High-Frequency Quant Engine
                    </h3>
                    <p class="text-xs text-neutral-300 leading-relaxed font-normal text-left">
                        Our Quant Bot continuously scans sub-second liquidity orderbooks across Binance, OKX, and Bybit to capture arbitrage opportunities instantly.
                    </p>
                </div>
                <div class="mt-5 pt-3.5 border-t border-amber-500/20 text-xs text-amber-400 font-mono font-bold flex items-center gap-2 text-left">
                    <i class="fa-solid fa-gauge-high text-amber-400"></i> Sub-millisecond Execution
                </div>
            </div>

            <!-- Card 2 -->
            <div class="ng-bot-card p-5 sm:p-6 flex flex-col justify-between text-left">
                <div class="text-left">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-black flex items-center justify-center mb-4 shadow-lg text-xl">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-white mb-2 flex items-center gap-2 text-left">
                        Automated Daily ROI Mining
                    </h3>
                    <p class="text-xs text-neutral-300 leading-relaxed font-normal text-left">
                        Once triggered, the Bot manages position sizing and risk profiles automatically, compounding your daily yield 24/7 up to your 2X return cap.
                    </p>
                </div>
                <div class="mt-5 pt-3.5 border-t border-emerald-500/20 text-xs text-emerald-400 font-mono font-bold flex items-center gap-2 text-left">
                    <i class="fa-solid fa-clock-rotate-left text-emerald-400"></i> 24/7 Yield Compounding
                </div>
            </div>

            <!-- Card 3 -->
            <div class="ng-bot-card p-5 sm:p-6 flex flex-col justify-between text-left">
                <div class="text-left">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-400 to-amber-600 text-black flex items-center justify-center mb-4 shadow-lg text-xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-white mb-2 flex items-center gap-2 text-left">
                        One-Time Lifetime Activation
                    </h3>
                    <p class="text-xs text-neutral-300 leading-relaxed font-normal text-left">
                        Activation requires only one simple click on our Live Trading Terminal. No re-subscriptions or manual server configuration required.
                    </p>
                </div>
                <div class="mt-5 pt-3.5 border-t border-amber-500/20 text-xs text-amber-300 font-mono font-bold flex items-center gap-2 text-left">
                    <i class="fa-solid fa-circle-check text-amber-300"></i> Single Click Launch
                </div>
            </div>

        </div>

        <!-- Full Width CTA Card with Left Icon Badge & Left-Aligned Text -->
        <div class="w-full p-6 sm:p-8 rounded-2xl bg-gradient-to-r from-amber-950/80 via-black to-amber-950/80 border border-amber-500/50 shadow-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden text-left">
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-start sm:items-center gap-5 sm:gap-6 z-10 w-full md:w-auto text-left">
                <!-- Glowing Metallic Icon Badge on Left -->
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-amber-400 via-yellow-400 to-amber-600 text-black flex items-center justify-center shadow-[0_0_25px_rgba(243,202,82,0.5)] text-2xl sm:text-3xl shrink-0 border border-yellow-200 mr-1 sm:mr-2">
                    <i class="fa-solid fa-robot animate-pulse"></i>
                </div>

                <div class="space-y-1.5 text-left min-w-0 flex-1 pl-1">
                    <div class="flex items-center gap-2 text-left">
                        <span class="text-[10px] font-black text-amber-400 tracking-[2px] uppercase">QUANT ENGINE CONTROL</span>
                        @if($user->is_bot_active)
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-500/60 text-emerald-400 text-[10px] font-extrabold uppercase flex items-center gap-1.5">
                                <div class="beacon-dot bg-emerald-400"></div>
                                BOT ACTIVE
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-500/60 text-amber-400 text-[10px] font-extrabold uppercase">
                                ⚡ PENDING ACTIVATION
                            </span>
                        @endif
                    </div>
                    <h2 class="text-base sm:text-xl font-black text-amber-300 tracking-wide uppercase text-left">
                        {{ $user->is_bot_active ? 'Trading BOT is Active & Mining ROI 24/7' : 'Ready to Launch Quant Trading BOT?' }}
                    </h2>
                    <p class="text-xs text-neutral-300 font-normal max-w-xl text-left">
                        @if($user->is_bot_active)
                            Activated on <strong class="text-amber-300 font-mono">{{ $user->bot_activated_at?->format('F d, Y \a\t H:i A') }}</strong>. Automated yield compounding is active 24/7.
                        @else
                            Open the interactive TradingView market terminal, monitor real-time crypto charts, select trading pairs, and launch your bot.
                        @endif
                    </p>
                </div>
            </div>

            <div class="shrink-0 w-full md:w-auto flex justify-start md:justify-end z-10">
                <a href="{{ route('user.bot.trading') }}"
                    class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-yellow-300 text-black font-black text-xs sm:text-sm uppercase tracking-wider shadow-[0_0_25px_rgba(243,202,82,0.5)] hover:scale-105 transition flex items-center justify-center gap-2.5 border border-yellow-200">
                    <i class="fa-solid fa-circle-play text-black text-base"></i>
                    <span>{{ $user->is_bot_active ? 'View Live Trading Terminal' : 'Start BOT & Open Terminal' }}</span>
                </a>
            </div>
        </div>

    </div>
@endsection
