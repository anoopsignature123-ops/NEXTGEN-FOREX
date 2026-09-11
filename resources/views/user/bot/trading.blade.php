@extends('user.layouts.app')

@section('title', 'Live Trading Terminal & Bot Activation')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-card: rgba(6, 26, 17, 0.85);
            --border-card: rgba(243, 202, 82, 0.35);
            --accent-gold: #f3ca52;
            --accent-green: #10b981;
        }

        /* Custom Scrollbar for horizontal pair switcher on mobile */
        .pair-switcher-scroll::-webkit-scrollbar {
            height: 4px;
        }
        .pair-switcher-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 9999px;
        }
        .pair-switcher-scroll::-webkit-scrollbar-thumb {
            background: rgba(243, 202, 82, 0.4);
            border-radius: 9999px;
        }

        /* Glowing Pulse Rings */
        @keyframes beaconPulse {
            0% { transform: scale(0.6); opacity: 0.9; }
            70% { transform: scale(2.2); opacity: 0; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        .pulse-dot-ring {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            position: relative;
        }
        .pulse-dot-ring::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: inherit;
            opacity: 0.6;
            animation: beaconPulse 1.8s cubic-bezier(0.24, 0, 0.38, 1) infinite;
        }

        /* Order Log Row Slide Animation */
        @keyframes logSlide {
            0% { opacity: 0; transform: translateX(-10px); background: rgba(16, 185, 129, 0.2); }
            100% { opacity: 1; transform: translateX(0); background: transparent; }
        }
        .log-row-animate {
            animation: logSlide 0.6s ease-out;
        }
    </style>

    <div class="w-full space-y-6">

        <!-- Top Header Banner (Full Mobile Responsive NextGen Gold Theme) -->
        <div class="p-5 sm:p-7 rounded-2xl bg-gradient-to-r from-amber-950/60 via-black to-amber-950/60 border border-amber-500/40 shadow-2xl flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 relative overflow-hidden text-left">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="space-y-1.5 z-10 w-full lg:w-auto text-left">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400/50 text-amber-300 text-[10px] font-black tracking-widest uppercase">LIVE ENGINE</span>
                    <span class="text-[10px] sm:text-[11px] text-amber-400 font-extrabold tracking-[2px] uppercase">TRADINGVIEW SYSTEM</span>
                </div>
                <h1 class="text-xl sm:text-3xl font-black text-amber-300 font-heading tracking-tight drop-shadow uppercase flex items-center gap-3 text-left">
                    <i class="fa-solid fa-chart-line text-amber-400 animate-pulse"></i>
                    QUANT TRADING TERMINAL
                </h1>
                <p class="text-xs sm:text-sm text-neutral-300 max-w-2xl font-medium text-left">
                    Monitor real-time crypto markets, switch live trading pairs, and launch your NextGen Autonomous Bot.
                </p>
            </div>

            <div class="z-10 w-full lg:w-auto flex items-center justify-start lg:justify-end shrink-0">
                <a href="{{ route('user.bot.index') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-black/80 hover:bg-neutral-900 text-amber-300 font-bold text-xs border border-amber-500/40 hover:border-amber-400 shadow-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-amber-400"></i>
                    <span>Back to Overview</span>
                </a>
            </div>
        </div>

        @if($user->status !== 'active')
            <div
                class="p-4 rounded-xl bg-rose-500/20 border border-rose-500/80 text-rose-300 text-xs sm:text-sm font-bold flex flex-col sm:flex-row items-center justify-between gap-3 shadow-[0_0_20px_rgba(244,63,94,0.35)] text-left">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg shrink-0 animate-pulse"></i>
                    <span class="text-rose-300" style="color: #f3ca52">⚠️ Please activate your account first by purchasing an
                        investment package before
                        starting the Quant Trading BOT!</span>
                </div>
                <a href="{{ route('user.packages.index') }}"
                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-300 hover:to-yellow-400 text-black font-black text-xs uppercase tracking-wider shrink-0 shadow transition whitespace-nowrap">
                    Activate Account
                </a>
            </div>
        @endif

        @if(session('success'))
            <div
                class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/60 text-emerald-300 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xl text-left">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div
                class="p-4 rounded-xl bg-amber-500/20 border border-amber-500/60 text-amber-300 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xl text-left">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-info text-amber-400 text-base shrink-0"></i>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        @endif

        <!-- Pair Selection & High-Definition Responsive TradingView Container -->
        <div
            class="p-4 sm:p-6 rounded-2xl bg-gradient-to-b from-[#042417] via-[#021d12] to-black border border-amber-500/40 shadow-2xl space-y-4 sm:space-y-5 text-left">

            <!-- Pair Selector Controls Bar (Mobile Swipe Scrollable) -->
            <div
                class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 border-b border-amber-500/20 pb-4 text-left">
                <div class="text-left">
                    <h2 class="text-base sm:text-lg font-black text-white flex items-center gap-2 uppercase tracking-wide text-left">
                        <i class="fa-solid fa-layer-group text-amber-400"></i>
                        Crypto Pair Selector
                    </h2>
                    <p class="text-xs text-neutral-400 text-left">Select a cryptocurrency pair to update the live TradingView
                        market chart in real time.</p>
                </div>

                <!-- Touch-scrollable pair buttons on mobile -->
                <div class="flex flex-nowrap sm:flex-wrap overflow-x-auto pair-switcher-scroll w-full xl:w-auto gap-2 sm:gap-2.5 pb-2 sm:pb-0"
                    id="pairSelectorButtons">
                    <button type="button" onclick="switchPair('BTCUSDT', this)"
                        class="pair-btn active-pair shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-black tracking-wide border transition-all shadow-[0_0_15px_rgba(243,202,82,0.4)] bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 text-black border-amber-300 scale-105 flex items-center gap-2">
                        <i class="fa-brands fa-bitcoin text-base"></i>
                        <span>BTC / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('ETHUSDT', this)"
                        class="pair-btn shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-black/80 text-neutral-300 border-amber-500/30 hover:border-amber-400 hover:text-amber-300 flex items-center gap-2">
                        <i class="fa-brands fa-ethereum text-base"></i>
                        <span>ETH / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('SOLUSDT', this)"
                        class="pair-btn shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-black/80 text-neutral-300 border-amber-500/30 hover:border-amber-400 hover:text-amber-300 flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-base"></i>
                        <span>SOL / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('BNBUSDT', this)"
                        class="pair-btn shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-black/80 text-neutral-300 border-amber-500/30 hover:border-amber-400 hover:text-amber-300 flex items-center gap-2">
                        <i class="fa-solid fa-gem text-base"></i>
                        <span>BNB / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('XRPUSDT', this)"
                        class="pair-btn shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-black/80 text-neutral-300 border-amber-500/30 hover:border-amber-400 hover:text-amber-300 flex items-center gap-2">
                        <i class="fa-solid fa-xmark text-base"></i>
                        <span>XRP / USDT</span>
                    </button>
                </div>
            </div>

            <!-- Fully Mobile Responsive TradingView Chart Container -->
            <div id="chartContainerFrame"
                class="relative w-full rounded-xl overflow-hidden border border-amber-500/30 bg-black shadow-inner"
                style="min-height: 450px;">
                <div id="tradingview_widget_container" class="w-full" style="height: 650px; min-height: 450px;"></div>
            </div>
        </div>

        <!-- Live Quant Order Log Stream Widget -->
        <div
            class="p-4 sm:p-6 rounded-2xl bg-gradient-to-b from-[#042417] via-[#021d12] to-black border border-amber-500/40 shadow-2xl space-y-4 text-left">
            <div class="flex items-center justify-between border-b border-amber-500/20 pb-3">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-terminal text-amber-400 text-lg"></i>
                    <h3 class="text-base font-black text-white uppercase tracking-wide">Live Quant Execution Terminal Stream
                    </h3>
                </div>
                <div class="flex items-center gap-2">
                    <div class="pulse-dot-ring bg-emerald-400"></div>
                    <span class="text-xs font-mono font-bold text-emerald-400 uppercase">Live Feed</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 font-mono text-xs text-neutral-300">
                <div class="p-3 rounded-xl bg-black/60 border border-amber-500/20 flex items-center justify-between">
                    <span class="text-neutral-400">Execution Speed:</span>
                    <span class="text-amber-300 font-bold">~12.4ms (Ultra Latency)</span>
                </div>
                <div class="p-3 rounded-xl bg-black/60 border border-amber-500/20 flex items-center justify-between">
                    <span class="text-neutral-400">Algorithmic Win Rate:</span>
                    <span class="text-emerald-400 font-bold">99.4% Verified</span>
                </div>
                <div class="p-3 rounded-xl bg-black/60 border border-amber-500/20 flex items-center justify-between">
                    <span class="text-neutral-400">Active Liquidity:</span>
                    <span class="text-yellow-300 font-bold">$2.4M BSC Pool</span>
                </div>
            </div>

            <div class="max-h-36 overflow-y-auto font-mono text-[11px] space-y-1.5 pr-2" id="quantLogContainer">
                <!-- Dynamic execution log lines injected via JS -->
            </div>
        </div>

        <!-- Bot Activation Control Box (Left Icon Badge & Strictly Left-Aligned Text) -->
        <div class="w-full p-4 sm:p-6 rounded-2xl bg-gradient-to-r from-amber-950/80 via-black to-amber-950/80 border border-amber-500/50 shadow-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-5 relative overflow-hidden text-left">
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-start sm:items-center gap-5 sm:gap-6 z-10 w-full md:w-auto text-left">
                <!-- Glowing Metallic Icon Badge on Left -->
                <div
                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-amber-400 via-yellow-400 to-amber-600 text-black flex items-center justify-center shadow-[0_0_25px_rgba(243,202,82,0.5)] text-2xl sm:text-3xl shrink-0 border border-yellow-200 mr-1 sm:mr-2">
                    <i class="fa-solid fa-bolt-lightning animate-pulse"></i>
                </div>

                <div class="space-y-1.5 text-left min-w-0 flex-1 pl-1">
                    <div class="flex items-center gap-2 text-left">
                        <span class="text-[10px] font-black text-amber-400 tracking-[2px] uppercase">QUANT ENGINE CONTROL</span>
                        @if($user->is_bot_active)
                            <span
                                class="px-3 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-500/60 text-emerald-400 text-[10px] font-extrabold uppercase flex items-center gap-2">
                                <div class="pulse-dot-ring bg-emerald-400"></div>
                                BOT ACTIVE
                            </span>
                        @else
                            <span
                                class="px-3 py-0.5 rounded-full bg-amber-500/20 border border-amber-500/60 text-amber-400 text-[10px] font-extrabold uppercase">
                                ⚡ PENDING ACTIVATION
                            </span>
                        @endif
                    </div>
                    <h3 class="text-base sm:text-xl font-black text-white text-left">
                        {{ $user->is_bot_active ? 'Trading BOT is Active & Mining ROI 24/7' : 'Ready to Launch Quant Trading BOT?' }}
                    </h3>
                    <p class="text-xs text-neutral-300 font-normal leading-relaxed max-w-xl text-left">
                        @if($user->is_bot_active)
                            Activated on <strong
                                class="text-amber-300 font-mono">{{ $user->bot_activated_at?->format('F d, Y \a\t H:i A') }}</strong>.
                            Automated yield compounding is active 24/7.
                        @else
                            Clicking <strong class="text-amber-300 font-semibold">START BOT</strong> triggers one-time activation of
                            your NextGen Quant Trading Engine to unlock daily ROI.
                        @endif
                    </p>
                </div>
            </div>

            <div class="shrink-0 w-full md:w-auto flex justify-start md:justify-end z-10">
                @if($user->is_bot_active)
                    <button type="button" disabled
                        class="w-full sm:w-auto px-6 sm:px-8 py-3.5 rounded-xl bg-emerald-500/20 border-2 border-emerald-500/80 text-emerald-300 font-black text-xs uppercase tracking-wider shadow-xl flex items-center justify-center gap-2.5 cursor-not-allowed opacity-90 whitespace-nowrap">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-sm shrink-0"></i>
                        <span class="whitespace-nowrap">BOT ACTIVE & MINING 24/7</span>
                    </button>
                @elseif($user->status === 'active')
                    <form action="{{ route('user.bot.activate') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to START the Trading BOT? This will initiate automated ROI mining.');"
                        class="w-full sm:w-auto">
                            @csrf
                            <button type="submit"
                                        class="w-full sm:w-auto px-6 sm:px-9 py-3.5 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-yellow-300 text-black font-black text-xs sm:text-sm uppercase tracking-wider shadow-[0_0_25px_rgba(243,202,82,0.5)] hover:scale-105 transition flex items-center justify-center gap-2.5 border border-yellow-200 cursor-pointer whitespace-nowrap">
                                        <i class="fa-solid fa-bolt text-black text-sm shrink-0"></i>
                                        <span class="whitespace-nowrap">START BOT</span>
                                    </button>
                                </form>
                @else
                    <button type="button" disabled title="Account Activation Required: Purchase an investment package first to start BOT"
                        class="w-full sm:w-auto px-6 sm:px-8 py-3.5 rounded-xl bg-rose-950/70 border-2 border-rose-500/70 text-rose-300 font-black text-xs sm:text-sm uppercase tracking-wider flex items-center justify-center gap-3 cursor-not-allowed opacity-90 shadow-xl whitespace-nowrap">
                        <i class="fa-solid fa-lock text-rose-400 text-sm shrink-0"></i>
                        <span class="whitespace-nowrap">START BOT (DISABLED)</span>
                    </button>
                @endif
            </div>
        </div>

    </div>

    <!-- TradingView Embed Script -->
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        let tvWidget = null;

        function getResponsiveChartHeight() {
            return window.innerWidth < 640 ? 450 : 650;
        }

        function loadTradingViewChart(symbol) {
            const container = document.getElementById('tradingview_widget_container');
            const frame = document.getElementById('chartContainerFrame');
            if (!container) return;
            container.innerHTML = '';

            const height = getResponsiveChartHeight();
            if (frame) frame.style.minHeight = height + 'px';
            container.style.height = height + 'px';
            container.style.minHeight = height + 'px';

            if (typeof TradingView !== 'undefined') {
                tvWidget = new TradingView.widget({
                    "width": "100%",
                    "height": height,
                    "symbol": "BINANCE:" + symbol,
                    "interval": "D",
                    "timezone": "Etc/UTC",
                    "theme": "dark",
                    "style": "1",
                    "locale": "en",
                    "toolbar_bg": "#021d12",
                    "enable_publishing": false,
                    "hide_side_toolbar": false,
                    "allow_symbol_change": true,
                    "container_id": "tradingview_widget_container"
                });
            }
        }

        function switchPair(symbol, btnElement) {
            // Reset all buttons to inactive state
            const buttons = document.querySelectorAll('.pair-btn');
            buttons.forEach(btn => {
                btn.className = 'pair-btn shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-black/80 text-neutral-300 border-amber-500/30 hover:border-amber-400 hover:text-amber-300 flex items-center gap-2';
            });

            // Set clicked button to active state
            btnElement.className = 'pair-btn active-pair shrink-0 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-black tracking-wide border transition-all shadow-[0_0_15px_rgba(243,202,82,0.4)] bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 text-black border-amber-300 scale-105 flex items-center gap-2';

            loadTradingViewChart(symbol);
        }

        // Live Log Stream Simulator
        const LOG_SYMBOLS = ['BTC/USDT', 'ETH/USDT', 'SOL/USDT', 'BNB/USDT'];
        const EXCHANGES = ['Binance', 'OKX', 'Bybit'];

        function addQuantLog() {
            const container = document.getElementById('quantLogContainer');
            if (!container) return;

            const sym = LOG_SYMBOLS[Math.floor(Math.random() * LOG_SYMBOLS.length)];
            const exFrom = EXCHANGES[Math.floor(Math.random() * EXCHANGES.length)];
            let exTo = EXCHANGES[Math.floor(Math.random() * EXCHANGES.length)];
            while (exTo === exFrom) exTo = EXCHANGES[Math.floor(Math.random() * EXCHANGES.length)];

            const margin = (Math.random() * 0.75 + 0.15).toFixed(2);
            const timeStr = new Date().toLocaleTimeString();

            const div = document.createElement('div');
            div.className = 'log-row-animate flex items-center justify-between p-1.5 rounded bg-black/40 border border-amber-500/10 text-left';
            div.innerHTML = `
                <span class="text-neutral-400">[${timeStr}] <strong class="text-white">${sym}</strong> Arb Route: <span class="text-sky-400">${exFrom} ➔ ${exTo}</span></span>
                <span class="text-emerald-400 font-bold">+${margin}% Yield matched</span>
            `;

            container.insertBefore(div, container.firstChild);
            if (container.children.length > 8) {
                container.removeChild(container.lastChild);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadTradingViewChart('BTCUSDT');

            // Seed initial logs
            for (let i = 0; i < 4; i++) addQuantLog();
            setInterval(addQuantLog, 3500);
        });

        // Window resize event handler to recalculate responsive chart height
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                const activeBtn = document.querySelector('.pair-btn.active-pair');
                let symbol = 'BTCUSDT';
                if (activeBtn && activeBtn.getAttribute('onclick')) {
                    const match = activeBtn.getAttribute('onclick').match(/'([^']+)'/);
                    if (match) symbol = match[1];
                }
                loadTradingViewChart(symbol);
            }, 300);
        });
    </script>
@endsection
