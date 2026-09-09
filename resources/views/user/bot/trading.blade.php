@extends('user.layouts.app')

@section('title', 'Live Trading Terminal & Bot Activation')

@section('content')
    <style>
        /* Custom scrollbar for horizontal pair switcher on mobile */
        .pair-switcher-scroll::-webkit-scrollbar {
            height: 4px;
        }
        .pair-switcher-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 9999px;
        }
        .pair-switcher-scroll::-webkit-scrollbar-thumb {
            background: rgba(243, 202, 82, 0.4);
            border-radius: 9999px;
        }
    </style>

    <div class="w-full space-y-6">

        <!-- Top Header Banner (Full Mobile Responsive) -->
        <div class="p-4 sm:p-6 rounded-2xl bg-gradient-to-r from-amber-950/60 via-black to-amber-950/60 border border-amber-500/40 shadow-xl flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="space-y-1 w-full lg:w-auto">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400/50 text-amber-300 text-[10px] font-black tracking-widest uppercase">LIVE ENGINE</span>
                    <span class="text-[10px] sm:text-[11px] text-amber-400 font-extrabold tracking-[2px] uppercase">TRADINGVIEW ENGINE</span>
                </div>
                <h1 class="text-lg sm:text-2xl lg:text-3xl font-black text-amber-300 font-heading tracking-tight drop-shadow">
                    QUANT TRADING TERMINAL
                </h1>
                <p class="text-xs sm:text-sm text-neutral-300 max-w-2xl font-medium">
                    Monitor real-time crypto markets, switch live trading pairs, and launch your NextGen Autonomous Bot.
                </p>
            </div>

            <div class="w-full lg:w-auto flex items-center justify-start lg:justify-end shrink-0">
                <a href="{{ route('user.bot.index') }}"
                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-neutral-900 hover:bg-neutral-800 text-amber-300 font-bold text-xs border border-amber-500/40 hover:border-amber-400 shadow-md transition flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4 text-amber-400"></i>
                    <span>Back to Overview</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/60 text-emerald-300 text-xs sm:text-sm font-bold flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 rounded-xl bg-amber-500/20 border border-amber-500/60 text-amber-300 text-xs sm:text-sm font-bold flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="info" class="w-5 h-5 text-amber-400 shrink-0"></i>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        @endif

        <!-- Pair Selection & High-Definition Responsive TradingView Container -->
        <div class="p-4 sm:p-6 rounded-2xl bg-neutral-900/95 border border-amber-500/30 shadow-xl space-y-4 sm:space-y-5">
            
            <!-- Pair Selector Controls Bar (Mobile Swipe Scrollable) -->
            <div class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 border-b border-neutral-800 pb-4">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                        <i data-lucide="line-chart" class="w-5 h-5 text-amber-400"></i>
                        Crypto Pair Selector
                    </h2>
                    <p class="text-xs text-neutral-400">Select a cryptocurrency pair to update the live TradingView market chart.</p>
                </div>

                <!-- Touch-scrollable pair buttons on mobile -->
                <div class="flex flex-nowrap sm:flex-wrap overflow-x-auto pair-switcher-scroll w-full xl:w-auto gap-2 sm:gap-2.5 pb-2 sm:pb-0" id="pairSelectorButtons">
                    <button type="button" onclick="switchPair('BTCUSDT', this)" 
                        class="pair-btn active-pair shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-black tracking-wide border transition-all shadow-[0_0_15px_rgba(243,202,82,0.4)] bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 text-black border-amber-300 scale-105 flex items-center gap-1.5">
                        <span>₿</span>
                        <span>BTC / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('ETHUSDT', this)" 
                        class="pair-btn shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-neutral-950 text-neutral-300 border-neutral-800 hover:border-amber-500/50 hover:text-amber-300 flex items-center gap-1.5">
                        <span>Ξ</span>
                        <span>ETH / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('SOLUSDT', this)" 
                        class="pair-btn shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-neutral-950 text-neutral-300 border-neutral-800 hover:border-amber-500/50 hover:text-amber-300 flex items-center gap-1.5">
                        <span>◎</span>
                        <span>SOL / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('BNBUSDT', this)" 
                        class="pair-btn shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-neutral-950 text-neutral-300 border-neutral-800 hover:border-amber-500/50 hover:text-amber-300 flex items-center gap-1.5">
                        <span>🔶</span>
                        <span>BNB / USDT</span>
                    </button>
                    <button type="button" onclick="switchPair('XRPUSDT', this)" 
                        class="pair-btn shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-neutral-950 text-neutral-300 border-neutral-800 hover:border-amber-500/50 hover:text-amber-300 flex items-center gap-1.5">
                        <span>✕</span>
                        <span>XRP / USDT</span>
                    </button>
                </div>
            </div>

            <!-- Fully Mobile Responsive TradingView Chart Container -->
            <div id="chartContainerFrame" class="relative w-full rounded-xl overflow-hidden border border-amber-500/30 bg-black shadow-inner" style="min-height: 450px;">
                <div id="tradingview_widget_container" class="w-full" style="height: 650px; min-height: 450px;"></div>
            </div>
        </div>

        <!-- Bot Activation Control Box (Full Width Mobile Responsive Row) -->
        <div class="w-full p-4 sm:p-5 rounded-2xl bg-neutral-900/90 border border-amber-500/40 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="space-y-1.5 text-center md:text-left w-full md:w-auto">
                <div class="flex items-center justify-center md:justify-start gap-2">
                    <span class="text-[10px] font-black text-amber-400 tracking-[2px] uppercase">QUANT ENGINE CONTROL</span>
                    @if($user->is_bot_active)
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-500/60 text-emerald-400 text-[10px] font-extrabold uppercase flex items-center gap-1.5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            BOT ACTIVE
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-500/60 text-amber-400 text-[10px] font-extrabold uppercase">
                            ⚡ PENDING ACTIVATION
                        </span>
                    @endif
                </div>
                <h3 class="text-base sm:text-lg font-black text-white">
                    {{ $user->is_bot_active ? 'Trading BOT is Active & Mining ROI 24/7' : 'Ready to Launch Quant Trading BOT?' }}
                </h3>
                <p class="text-xs text-neutral-300 font-normal leading-relaxed">
                    @if($user->is_bot_active)
                        Activated on <strong class="text-amber-300 font-mono">{{ $user->bot_activated_at?->format('F d, Y \a\t H:i A') }}</strong>.
                    @else
                        Clicking <strong class="text-amber-300 font-semibold">START BOT</strong> triggers one-time activation of your NextGen Quant Trading Engine to unlock daily ROI.
                    @endif
                </p>
            </div>

            <div class="shrink-0 w-full md:w-auto flex justify-center">
                @if($user->is_bot_active)
                    <button type="button" disabled
                        class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600/30 border border-emerald-500/80 text-emerald-300 font-extrabold text-xs uppercase tracking-wider shadow-md flex items-center justify-center gap-2 cursor-not-allowed opacity-90">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>BOT ACTIVE & MINING 24/7</span>
                    </button>
                @else
                    <form action="{{ route('user.bot.activate') }}" method="POST" onsubmit="return confirm('Are you sure you want to START the Trading BOT? This will initiate automated ROI mining.');" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-yellow-300 text-black font-black text-xs sm:text-sm uppercase tracking-wider shadow-[0_0_20px_rgba(243,202,82,0.5)] hover:scale-105 transition flex items-center justify-center gap-2 border border-yellow-200 cursor-pointer">
                            <i data-lucide="zap" class="w-4 h-4 text-black fill-black"></i>
                            <span>START BOT</span>
                        </button>
                    </form>
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
                    "toolbar_bg": "#0b0d13",
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
                btn.className = 'pair-btn shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold tracking-wide border transition-all bg-neutral-950 text-neutral-300 border-neutral-800 hover:border-amber-500/50 hover:text-amber-300 flex items-center gap-1.5';
            });

            // Set clicked button to active state
            btnElement.className = 'pair-btn active-pair shrink-0 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-black tracking-wide border transition-all shadow-[0_0_15px_rgba(243,202,82,0.4)] bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 text-black border-amber-300 scale-105 flex items-center gap-1.5';

            loadTradingViewChart(symbol);
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadTradingViewChart('BTCUSDT');
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
