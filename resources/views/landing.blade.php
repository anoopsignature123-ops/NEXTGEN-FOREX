<!doctype html>
<html lang="en" class="dark scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>NEXTGEN FOREX - Next Generation Forex & Crypto Automated Trading</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon.png') }}?v=2" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}?v=2" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon.png') }}?v=2" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nextgen-theme.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body.ng-landing-bg {
            background-color: #010603 !important;
            background-image:
                radial-gradient(circle at 50% 15%, rgba(243, 202, 82, 0.20) 0%, rgba(2, 22, 13, 0.96) 50%, #010704 100%),
                url('{{ asset("images/auth_bg.jpg") }}') !important;
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
            min-height: 100vh;
        }
    
        .ng-glass-nav {
            background: rgba(2, 14, 9, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(243, 202, 82, 0.3);
        }
    
        .ng-landing-card {
            background: rgba(4, 25, 15, 0.88);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(243, 202, 82, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
    
        .card-hover-animate {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    
        .card-hover-animate:hover {
            transform: translateY(-8px) scale(1.015);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8), 0 0 35px rgba(243, 202, 82, 0.35);
            border-color: rgba(243, 202, 82, 0.9);
        }
    
        .hero-logo-glow {
            filter: drop-shadow(0 0 35px rgba(243, 202, 82, 0.75));
            animation: floatLogo 4s ease-in-out infinite;
        }
    
        @keyframes floatLogo {
    
            0%,
            100% {
                transform: translateY(0px);
            }
    
            50% {
                transform: translateY(-10px);
            }
        }
    
        @keyframes goldPulse {
    
            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }
    
            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }
    
        .animate-aura {
            animation: goldPulse 3.5s ease-in-out infinite;
        }
    
        @keyframes goldShimmer {
            0% {
                background-position: -200% 0;
            }
    
            100% {
                background-position: 200% 0;
            }
        }
    
        .gold-shimmer-btn {
            background: linear-gradient(90deg, #d4af37 0%, #fff5c0 25%, #f3ca52 50%, #aa771c 75%, #d4af37 100%);
            background-size: 200% 100%;
            animation: goldShimmer 3s infinite linear;
        }
    
        @keyframes tickerScroll {
            0% {
                transform: translateX(0);
            }
    
            100% {
                transform: translateX(-50%);
            }
        }
    
        .animate-ticker {
            display: inline-flex;
            white-space: nowrap;
            animation: tickerScroll 25s linear infinite;
        }
    
        /* Scroll Reveal Animation Classes */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
    
        .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    </head>
    
    <body
        class="ng-landing-bg text-slate-100 font-sans min-h-screen flex flex-col justify-between selection:bg-amber-500 selection:text-black overflow-x-hidden">
    
        <!-- 1. STICKY HEADER NAVBAR -->
        <header class="sticky top-0 inset-x-0 z-50 ng-glass-nav transition-all duration-300">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between gap-4">
    
                <!-- Official PDF Logo Emblem -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/nextgen_logo.png') }}" alt="NEXTGEN FOREX Official Logo"
                        class="h-12 sm:h-16 w-auto object-contain drop-shadow-[0_0_15px_rgba(243,202,82,0.8)] group-hover:scale-105 transition duration-300 shrink-0">
                </a>
    
                <!-- Centered Nav Links Pill Container -->
                <nav
                    class="hidden lg:flex items-center gap-6 px-6 py-2 rounded-full bg-black/80 border border-amber-500/30 text-xs font-extrabold uppercase tracking-wider text-neutral-300">
                    <a href="#home" class="hover:text-amber-400 transition">Home</a>
                    <a href="#about" class="hover:text-amber-400 transition">About</a>
                    <a href="#analytics" class="hover:text-amber-400 transition">Analytics</a>
                    <a href="#calculator" class="hover:text-amber-400 transition">Calculator</a>
                    <a href="#packages" class="hover:text-amber-400 transition">Packages</a>
                    <a href="#faq" class="hover:text-amber-400 transition">FAQ</a>
                </nav>
    
                <!-- Action Buttons Right -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.login') }}"
                        class="hidden sm:inline-flex px-5 py-2.5 rounded-full bg-black/80 border border-amber-500/50 text-amber-300 font-extrabold text-xs uppercase tracking-wider hover:bg-amber-500/20 hover:scale-105 transition duration-300 items-center gap-1.5 shadow">
                        Login
                    </a>
                    <a href="{{ route('user.register') }}"
                        class="px-6 py-2.5 rounded-full gold-shimmer-btn font-black text-xs uppercase tracking-wider shadow-xl hover:scale-105 transition duration-300 flex items-center gap-1.5 text-black">
                        Sign Up
                    </a>
                    <!-- Mobile Menu Toggle -->
                    <button id="mobileMenuBtn" onclick="toggleMobileMenu()"
                        class="lg:hidden p-2 rounded-xl bg-black/80 border border-amber-500/40 text-amber-400 hover:text-white transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
    
            <!-- Mobile Drawer -->
            <div id="mobileDrawer"
                class="hidden lg:hidden bg-black/95 border-b border-amber-500/40 p-6 space-y-3 text-xs font-extrabold uppercase tracking-wider text-neutral-200">
                <a href="#home" onclick="toggleMobileMenu()"
                    class="block py-2 border-b border-amber-500/10 hover:text-amber-400">Home</a>
                <a href="#about" onclick="toggleMobileMenu()"
                    class="block py-2 border-b border-amber-500/10 hover:text-amber-400">About Us</a>
                <a href="#analytics" onclick="toggleMobileMenu()"
                    class="block py-2 border-b border-amber-500/10 hover:text-amber-400">Market Analytics</a>
                <a href="#calculator" onclick="toggleMobileMenu()"
                    class="block py-2 border-b border-amber-500/10 hover:text-amber-400">ROI Calculator</a>
                <a href="#packages" onclick="toggleMobileMenu()"
                    class="block py-2 border-b border-amber-500/10 hover:text-amber-400">Investment Packages</a>
                <a href="#faq" onclick="toggleMobileMenu()"
                    class="block py-2 border-b border-amber-500/10 hover:text-amber-400">FAQ</a>
    
            </div>
        </header>
    
        <!-- MAIN CONTENT CONTAINER: STRICTLY NARROW CENTRED COLUMN (max-w-2xl mx-auto) -->
        <main class="py-10">
            <div class="container mx-auto px-4">
                <div class="flex justify-center">
                    <!-- NARROW COMPACT COLUMN (max-w-2xl / ~670px) -->
                    <div class="w-full max-w-2xl space-y-12">
    
                        <!-- 2. HERO SECTION CARD WITH OFFICIAL 3D LOGO -->
                        <section id="home"
                            class="p-6 sm:p-8 rounded-3xl ng-landing-card card-hover-animate scroll-reveal text-center space-y-6 relative overflow-hidden">
    
                            <!-- Top Star Pill Badge -->
                            <div
                                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/80 border border-amber-400/80 shadow-xl mx-auto hover:scale-105 transition">
                                <span class="text-amber-400 animate-spin" style="animation-duration: 6s;">★</span>
                                <span
                                    class="text-[11px] font-black text-amber-300 uppercase tracking-widest font-mono">WELCOME
                                    TO NEXTGEN FOREX</span>
                                <span class="text-amber-400 animate-spin" style="animation-duration: 6s;">★</span>
                            </div>
    
                            <!-- Official 3D NextGen Forex Full Logo Image -->
                            <div class="flex justify-center items-center py-3">
                                <div class="relative w-full max-w-md flex items-center justify-center">
                                    <div class="absolute inset-0 rounded-full bg-amber-500/20 blur-3xl animate-aura"></div>
                                    <img src="{{ asset('images/nextgen_logo.png') }}" alt="Official NextGen Forex Logo"
                                        class="h-20 sm:h-24 w-auto object-contain hero-logo-glow relative z-10">
                                </div>
                            </div>
    
                            <!-- Subtitle -->
                            <div class="space-y-1">
                                <p
                                    class="text-[11px] sm:text-xs font-extrabold text-amber-400 tracking-[3px] uppercase font-mono">
                                    WHERE TRADING MEETS HIGH YIELD REWARDS
                                </p>
                            </div>
    
                            <!-- Description -->
                            <p class="text-xs text-neutral-300 font-medium max-w-lg mx-auto leading-relaxed">
                                Earn daily ROI rewards through automated FX algorithmic trading. Transparent contract limits
                                up to <strong class="text-amber-400 font-black">200% Return Capping</strong> with instant
                                USDT BEP20 payouts!
                            </p>
    
                            <!-- 4 Icon Steps Row -->
                            <div class="grid grid-cols-4 gap-2 pt-1 max-w-sm mx-auto font-mono text-center">
                                <div
                                    class="p-2 rounded-xl bg-black/70 border border-amber-500/30 space-y-1 hover:border-amber-400 hover:scale-105 transition">
                                    <span class="text-lg block">📈</span>
                                    <span class="text-[9px] text-amber-300 font-bold uppercase block">TRADE</span>
                                </div>
                                <div
                                    class="p-2 rounded-xl bg-black/70 border border-amber-500/30 space-y-1 hover:border-amber-400 hover:scale-105 transition">
                                    <span class="text-lg block">🏆</span>
                                    <span class="text-[9px] text-amber-300 font-bold uppercase block">COMPETE</span>
                                </div>
                                <div
                                    class="p-2 rounded-xl bg-black/70 border border-amber-500/30 space-y-1 hover:border-amber-400 hover:scale-105 transition">
                                    <span class="text-lg block">💰</span>
                                    <span class="text-[9px] text-amber-300 font-bold uppercase block">EARN</span>
                                </div>
                                <div
                                    class="p-2 rounded-xl bg-black/70 border border-amber-500/30 space-y-1 hover:border-amber-400 hover:scale-105 transition">
                                    <span class="text-lg block">💎</span>
                                    <span class="text-[9px] text-amber-300 font-bold uppercase block">REDEEM</span>
                                </div>
                            </div>
    
                            <!-- Shimmering Metallic Gold Action Buttons -->
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                                <a href="{{ route('user.register') }}"
                                    class="px-6 py-3 rounded-full gold-shimmer-btn font-black text-xs uppercase tracking-wider shadow-xl hover:scale-105 transition flex items-center justify-center gap-2 text-black">
                                    <i data-lucide="user-plus" class="w-4 h-4 text-black font-black"></i> Sign Up & Start
                                    Earning
                                </a>
                                <a href="#about"
                                    class="px-6 py-3 rounded-full bg-black/80 border-2 border-amber-500/50 text-amber-300 font-black text-xs uppercase tracking-wider hover:bg-amber-500/20 hover:scale-105 transition flex items-center justify-center gap-2 shadow-xl">
                                    <i data-lucide="play-circle" class="w-4 h-4 text-amber-400"></i> Learn More
                                </a>
                            </div>
    
                            <!-- 3 Stat Metrics Bar -->
                            <div class="grid grid-cols-3 gap-2 pt-5 border-t border-amber-500/20 font-mono text-center">
                                <div>
                                    <h4 class="text-lg sm:text-xl font-black text-amber-400">12.5K+</h4>
                                    <span class="text-[9px] text-neutral-400 font-sans uppercase font-bold">ACTIVE
                                        TRADERS</span>
                                </div>
                                <div>
                                    <h4 class="text-lg sm:text-xl font-black text-emerald-400">$2.5M+</h4>
                                    <span class="text-[9px] text-neutral-400 font-sans uppercase font-bold">REWARDS
                                        PAID</span>
                                </div>
                                <div>
                                    <h4 class="text-lg sm:text-xl font-black text-sky-400">200%</h4>
                                    <span class="text-[9px] text-neutral-400 font-sans uppercase font-bold">CONTRACT
                                        CAP</span>
                                </div>
                            </div>
    
                        </section>
    
                        <!-- 3. TICKER TAPE BANNER -->
                        <div
                            class="rounded-2xl bg-amber-500/10 border border-amber-500/40 py-2.5 overflow-hidden text-xs font-mono font-bold text-amber-300 shadow-lg scroll-reveal">
                            <div class="flex animate-ticker gap-10">
                                <span>▶ JOIN THOUSANDS OF TRADERS ALREADY EARNING DAILY!</span>
                                <span>⚡ AUTOMATED FOREX TRADING ENGINE 24/5 ACTIVE!</span>
                                <span>🏆 10% DIRECT REFERRAL + 10% TEAM A & B MATCHING BONUSES!</span>
                                <span>💎 100% INSTANT USDT BEP20 WITHDRAWAL PROCESSING!</span>
                                <!-- Loop repeat -->
                                <span>▶ JOIN THOUSANDS OF TRADERS ALREADY EARNING DAILY!</span>
                                <span>⚡ AUTOMATED FOREX TRADING ENGINE 24/5 ACTIVE!</span>
                                <span>🏆 10% DIRECT REFERRAL + 10% TEAM A & B MATCHING BONUSES!</span>
                            </div>
                        </div>
    
                        <!-- 4. ABOUT US SECTION WITH 3D GOLDEN GLOBE MATCHING PDF -->
                        <section id="about" class="space-y-6 scroll-reveal">
    
                            <div class="text-center space-y-2">
                                <div
                                    class="inline-block px-4 py-1 rounded-full bg-black/80 border border-amber-500/40 text-amber-400 text-xs font-mono font-bold uppercase">
                                    [ ABOUT US ]
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-black text-white uppercase font-heading">
                                    ABOUT <span class="text-gold-gradient">NEXTGEN FOREX</span>
                                </h2>
                                <div class="w-16 h-1 bg-amber-400 mx-auto rounded-full mt-1"></div>
                            </div>
    
                            <div class="space-y-4">
    
                                <!-- PDF 3D Golden Globe Image Card -->
                                <div
                                    class="p-4 rounded-3xl ng-landing-card card-hover-animate relative overflow-hidden flex justify-center items-center">
                                    <div
                                        class="relative w-full rounded-2xl overflow-hidden border border-amber-500/40 shadow-2xl">
                                        <span
                                            class="absolute top-3 left-3 z-20 px-3 py-1 rounded-full bg-black/90 border border-amber-400 text-amber-300 text-[10px] font-mono font-bold flex items-center gap-1.5 shadow-lg">
                                            <i data-lucide="globe" class="w-3.5 h-3.5 text-amber-400"></i> Global Financial
                                            Markets
                                        </span>
                                        <img src="{{ asset('images/pdf_gold_globe.png') }}"
                                            alt="3D Golden Globe & Currency Symbols"
                                            class="w-full h-60 object-cover rounded-2xl">
                                    </div>
                                </div>
    
                                <div
                                    class="p-5 rounded-3xl ng-landing-card card-hover-animate space-y-3 relative overflow-hidden">
                                    <div
                                        class="w-9 h-9 rounded-xl pdf-gold-badge text-black font-black flex items-center justify-center text-base">
                                        🚀
                                    </div>
                                    <h3 class="text-sm font-black text-white uppercase font-heading">The Future of Forex
                                        Trading is Here</h3>
                                    <p class="text-xs text-neutral-300 leading-relaxed">
                                        <strong class="text-amber-400 font-bold">NextGen Forex</strong> combines
                                        high-frequency Forex algorithmic execution with transparent yield contracts —
                                        offering daily ROI returns, deposit wallet funding, and complete financial clarity.
                                    </p>
                                </div>
    
                                <div
                                    class="p-5 rounded-3xl ng-landing-card card-hover-animate space-y-3 relative overflow-hidden">
                                    <div
                                        class="w-9 h-9 rounded-xl pdf-gold-badge text-black font-black flex items-center justify-center text-base">
                                        🔗
                                    </div>
                                    <h3 class="text-sm font-black text-white uppercase font-heading">MT5 & Binary Rewards
                                        System</h3>
                                    <p class="text-xs text-neutral-300 leading-relaxed">
                                        Earn 10% Direct Commissions and 10% Binary Matching rewards across Team A and Team B
                                        network branches, backed by auto-fetched USDT BEP20 withdrawals.
                                    </p>
                                </div>
    
                            </div>
                        </section>
    
                        <!-- 5. 3D GOLDEN BULL & PACKAGES SECTION MATCHING PDF SLIDES -->
                        <section id="packages" class="space-y-6 scroll-reveal">
                            <div class="text-center space-y-2">
                                <div
                                    class="inline-block px-4 py-1 rounded-full bg-black/80 border border-amber-500/40 text-amber-400 text-xs font-mono font-bold uppercase">
                                    [ INVESTMENT PACKAGES ]
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-black text-white uppercase font-heading">CHOOSE YOUR
                                    PACKAGE</h2>
                            </div>
    
                            <!-- 3D Golden Bull Graphic Card from PDF -->
                            <div
                                class="p-4 rounded-3xl ng-landing-card card-hover-animate relative overflow-hidden flex justify-center items-center">
                                <div
                                    class="relative w-full rounded-2xl overflow-hidden border border-amber-500/40 shadow-2xl">
                                    <span
                                        class="absolute top-3 left-3 z-20 px-3 py-1 rounded-full bg-black/90 border border-amber-400 text-amber-300 text-[10px] font-mono font-bold flex items-center gap-1.5 shadow-lg">
                                        <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-400"></i> Forex Bull
                                        Market
                                    </span>
                                    <img src="{{ asset('images/pdf_gold_bull.png') }}" alt="3D Golden Bull Statue & Coins"
                                        class="w-full h-60 object-cover rounded-2xl">
                                </div>
                            </div>
    
                            <!-- 2x2 Package Grid fitting inside max-w-2xl -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @forelse($packages as $pkg)
                                    <div
                                        class="p-5 rounded-3xl ng-landing-card card-hover-animate space-y-4 flex flex-col justify-between">
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between border-b border-amber-500/20 pb-2.5">
                                                <h3 class="text-sm font-black text-white font-heading uppercase">📦
                                                    {{ $pkg->name }}
                                                </h3>
                                                <span
                                                    class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[9px] font-mono font-bold">2X
                                                    CAP</span>
                                            </div>

                                            <div class="space-y-1">
                                                <span class="text-[9px] text-neutral-400 font-mono uppercase block">INVESTMENT
                                                    RANGE</span>
                                                <div class="text-lg font-black text-amber-400 font-mono">
                                                    ${{ number_format($pkg->min_amount) }} -
                                                    ${{ number_format($pkg->max_amount) }}
                                                </div>
                                            </div>

                                            <div class="space-y-1.5 text-xs pt-1">
                                                <div
                                                    class="flex justify-between py-1 border-b border-amber-500/10 text-neutral-300">
                                                    <span>Daily ROI Payout:</span>
                                                    <strong
                                                        class="text-emerald-400 font-mono font-black">+{{ $pkg->daily_roi }}% /
                                                        Day</strong>
                                                </div>
                                                <div
                                                    class="flex justify-between py-1 border-b border-amber-500/10 text-neutral-300">
                                                    <span>Total Return Limit:</span>
                                                    <strong class="text-white font-mono font-bold">200% (2X Cap)</strong>
                                                </div>
                                                <div class="flex justify-between py-1 text-neutral-300">
                                                    <span>Withdrawal Fee:</span>
                                                    <strong class="text-rose-400 font-mono">10% Standard</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('user.register') }}"
                                            class="w-full py-2.5 rounded-full gold-shimmer-btn font-black text-xs uppercase tracking-wider text-center shadow-lg transition text-black">
                                            Invest Now &rarr;
                                        </a>
                                    </div>
                                @empty
                                    @foreach([
                                            ['name' => 'PACKAGE 1', 'min' => 10, 'max' => 100, 'roi' => '0.5'],
                                            ['name' => 'PACKAGE 2', 'min' => 100, 'max' => 500, 'roi' => '0.75'],
                                            ['name' => 'PACKAGE 3', 'min' => 500, 'max' => 1000, 'roi' => '1.0'],
                                            ['name' => 'PACKAGE 4', 'min' => 1000, 'max' => 5000, 'roi' => '1.25'],
                                        ] as $defaultPkg)
                                        <div
                                            class="p-5 rounded-3xl ng-landing-card card-hover-animate space-y-4 flex flex-col justify-between">
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between border-b border-amber-500/20 pb-2.5">
                                                    <h3 class="text-sm font-black text-white font-heading uppercase">📦
                                                        {{ $defaultPkg['name'] }}
                                                    </h3>
                                                    <span
                                                        class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[9px] font-mono font-bold">2X
                                                        CAP</span>
                                                </div>

                                                <div class="space-y-1">
                                                    <span class="text-[9px] text-neutral-400 font-mono uppercase block">INVESTMENT
                                                        RANGE</span>
                                                    <div class="text-lg font-black text-amber-400 font-mono">
                                                        ${{ number_format($defaultPkg['min']) }} -
                                                        ${{ number_format($defaultPkg['max']) }}
                                                    </div>
                                                </div>

                                                <div class="space-y-1.5 text-xs pt-1">
                                                    <div
                                                        class="flex justify-between py-1 border-b border-amber-500/10 text-neutral-300">
                                                        <span>Daily ROI Payout:</span>
                                                        <strong
                                                            class="text-emerald-400 font-mono font-black">+{{ $defaultPkg['roi'] }}%
                                                            / Day</strong>
                                                    </div>
                                                    <div
                                                        class="flex justify-between py-1 border-b border-amber-500/10 text-neutral-300">
                                                        <span>Total Return Limit:</span>
                                                        <strong class="text-white font-mono font-bold">200% (2X Cap)</strong>
                                                    </div>
                                                    <div class="flex justify-between py-1 text-neutral-300">
                                                        <span>Withdrawal Fee:</span>
                                                        <strong class="text-rose-400 font-mono">10% Standard</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="{{ route('user.register') }}"
                                                class="w-full py-2.5 rounded-full gold-shimmer-btn font-black text-xs uppercase tracking-wider text-center shadow-lg transition text-black">
                                                Invest Now &rarr;
                                            </a>
                                        </div>
                                    @endforeach
                                @endforelse
                            </div>
                        </section>
    
                        <!-- 6. ROI CALCULATOR SECTION -->
                        <section id="calculator"
                            class="p-6 rounded-3xl ng-landing-card card-hover-animate scroll-reveal space-y-6">
                            <div class="text-center space-y-2">
                                <div
                                    class="inline-block px-4 py-1 rounded-full bg-black/80 border border-amber-500/40 text-amber-400 text-xs font-mono font-bold uppercase">
                                    [ ROI ESTIMATOR ]
                                </div>
                                <h2 class="text-2xl font-black text-white uppercase font-heading">EARNINGS & ROI CALCULATOR
                                </h2>
                            </div>
    
                            <div class="space-y-6 pt-2">
                                <div class="space-y-3 p-4 rounded-2xl bg-black/80 border border-amber-500/30">
                                    <div class="flex justify-between items-center text-xs font-mono font-bold">
                                        <span class="text-neutral-400 uppercase font-sans">Select Investment Amount ($
                                            USD):</span>
                                        <span id="calcAmountLabel"
                                            class="text-xl font-black text-amber-400 font-mono">$1,000.00</span>
                                    </div>
                                    <input type="range" id="calcRange" min="100" max="25000" step="100" value="1000"
                                        oninput="updateCalculator(this.value)"
                                        class="w-full h-3 bg-black rounded-lg appearance-none cursor-pointer accent-amber-400 border border-amber-500/40">
                                    <div class="flex justify-between text-[10px] font-mono text-neutral-400">
                                        <span>$100 (Min)</span>
                                        <span>$5,000</span>
                                        <span>$10,000</span>
                                        <span>$25,000 (VIP)</span>
                                    </div>
                                </div>
    
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    <span class="text-xs text-neutral-400 font-bold uppercase mr-1">Presets:</span>
                                    <button onclick="setCalcPreset(100)"
                                        class="px-3.5 py-1.5 rounded-xl bg-black border border-amber-500/40 text-amber-300 font-mono font-bold text-xs hover:bg-amber-500/20 transition">$100</button>
                                    <button onclick="setCalcPreset(500)"
                                        class="px-3.5 py-1.5 rounded-xl bg-black border border-amber-500/40 text-amber-300 font-mono font-bold text-xs hover:bg-amber-500/20 transition">$500</button>
                                    <button onclick="setCalcPreset(1000)"
                                        class="px-3.5 py-1.5 rounded-xl bg-black border border-amber-500/40 text-amber-300 font-mono font-bold text-xs hover:bg-amber-500/20 transition">$1,000</button>
                                    <button onclick="setCalcPreset(5000)"
                                        class="px-3.5 py-1.5 rounded-xl bg-black border border-amber-500/40 text-amber-300 font-mono font-bold text-xs hover:bg-amber-500/20 transition">$5,000</button>
                                </div>
    
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1 font-mono">
                                    <div
                                        class="p-3.5 rounded-2xl bg-black/90 border border-emerald-500/40 space-y-1 text-center sm:text-left">
                                        <span class="text-[10px] text-neutral-400 uppercase font-sans font-bold block">DAILY
                                            ROI ESTIMATE (1.5%):</span>
                                        <strong id="calcDailyRoi" class="text-xl font-black text-emerald-400 block">$15.00 /
                                            Day</strong>
                                    </div>
                                    <div
                                        class="p-3.5 rounded-2xl bg-black/90 border border-amber-500/40 space-y-1 text-center sm:text-left">
                                        <span class="text-[10px] text-neutral-400 uppercase font-sans font-bold block">TOTAL
                                            200% CAP RETURN:</span>
                                        <strong id="calcTotalReturn"
                                            class="text-xl font-black text-amber-300 block">$2,000.00 (2X)</strong>
                                    </div>
                                </div>
    
                                <div class="pt-1 flex justify-center">
                                    <a href="{{ route('user.register') }}"
                                        class="px-7 py-3 rounded-full gold-shimmer-btn font-black text-xs uppercase tracking-wider text-center text-black shadow-lg hover:scale-105 transition flex items-center gap-2">
                                        <span>Start Investing $<span id="btnAmount">1,000</span> Now &rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </section>
    
                        <!-- 8. FREQUENTLY ASKED QUESTIONS -->
                        <section id="faq" class="space-y-5 scroll-reveal">
                            <div class="text-center space-y-2 mb-4">
                                <div
                                    class="inline-block px-4 py-1 rounded-full bg-black/80 border border-amber-500/40 text-amber-400 text-xs font-mono font-bold uppercase">
                                    [ FREQUENTLY ASKED QUESTIONS ]
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-black text-white uppercase font-heading">FREQUENTLY
                                    ASKED QUESTIONS</h2>
                            </div>
    
                            <div class="space-y-3">
                                <div class="p-4 rounded-2xl ng-landing-card card-hover-animate space-y-2 cursor-pointer"
                                    onclick="toggleFaq('faq1')">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs sm:text-sm font-black text-white uppercase font-heading">How does
                                            NextGen Forex generate daily ROI returns?</h4>
                                        <i data-lucide="chevron-down" id="faq1-icon"
                                            class="w-4 h-4 text-amber-400 transition transform shrink-0"></i>
                                    </div>
                                    <p id="faq1"
                                        class="hidden text-xs text-neutral-300 leading-relaxed pt-2 border-t border-amber-500/20">
                                        Our proprietary algorithmic trading engine executes high-frequency trades on major
                                        Forex currency pairs (EUR/USD, GBP/USD, USD/JPY) and Gold. Daily profits are
                                        automatically distributed into investor Earning Wallets.
                                    </p>
                                </div>
    
                                <div class="p-4 rounded-2xl ng-landing-card card-hover-animate space-y-2 cursor-pointer"
                                    onclick="toggleFaq('faq2')">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs sm:text-sm font-black text-white uppercase font-heading">What is
                                            the 200% ROI Contract Capping Rule?</h4>
                                        <i data-lucide="chevron-down" id="faq2-icon"
                                            class="w-4 h-4 text-amber-400 transition transform shrink-0"></i>
                                    </div>
                                    <p id="faq2"
                                        class="hidden text-xs text-neutral-300 leading-relaxed pt-2 border-t border-amber-500/20">
                                        Each purchased package contract has a maximum earnings limit of 200% (2X the
                                        invested amount). Once your total ROI and referral commissions reach 200%, the
                                        contract completes and can be renewed.
                                    </p>
                                </div>
    
                                <div class="p-4 rounded-2xl ng-landing-card card-hover-animate space-y-2 cursor-pointer"
                                    onclick="toggleFaq('faq3')">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs sm:text-sm font-black text-white uppercase font-heading">What is
                                            the minimum withdrawal amount?</h4>
                                        <i data-lucide="chevron-down" id="faq3-icon"
                                            class="w-4 h-4 text-amber-400 transition transform shrink-0"></i>
                                    </div>
                                    <p id="faq3"
                                        class="hidden text-xs text-neutral-300 leading-relaxed pt-2 border-t border-amber-500/20">
                                        The minimum withdrawal limit is $10.00 USD. All payouts are processed in USDT
                                        (BEP20) directly to your saved crypto wallet address with a 10% standard processing
                                        fee.
                                    </p>
                                </div>
    
                                <div class="p-4 rounded-2xl ng-landing-card card-hover-animate space-y-2 cursor-pointer"
                                    onclick="toggleFaq('faq4')">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs sm:text-sm font-black text-white uppercase font-heading">How do
                                            Team A & Team B Binary bonuses work?</h4>
                                        <i data-lucide="chevron-down" id="faq4-icon"
                                            class="w-4 h-4 text-amber-400 transition transform shrink-0"></i>
                                    </div>
                                    <p id="faq4"
                                        class="hidden text-xs text-neutral-300 leading-relaxed pt-2 border-t border-amber-500/20">
                                        Members earn 10% Direct Sponsor Commission on direct referrals, plus 10% Binary
                                        Matching Bonus calculated on the business volume generated between your Team A and
                                        Team B network branches.
                                    </p>
                                </div>
                            </div>
                        </section>
    
                    </div>
                </div>
            </div>
        </main>
    
        <!-- 9. REAL FULL-WIDTH WEBSITE FOOTER (EXACT MATCH FOR REFERENCE IMAGE media_1788501701622.png) -->
        <footer class="w-full bg-[#030303] text-neutral-400 text-xs mt-16 relative z-20">
            <!-- Top Full-Width Golden Line -->
            <div style="height: 1px; background: #f3ca52; box-shadow: 0 0 10px rgba(243, 202, 82, 0.6);" class="w-full">
            </div>
    
            <!-- Main Footer Content Container -->
            <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-3 pb-4 space-y-8">
    
                <!-- 4 Columns Grid Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 pb-8"
                    style="border-bottom: 1px solid rgba(243, 202, 82, 0.2);">
    
                    <!-- Column 1: Brand Info, Bio, Social Icons & NGT Token -->
                    <div class="space-y-4 text-left">
                        <!-- Logo -->
                        <a href="{{ url('/') }}" class="inline-block mb-1">
                            <img src="{{ asset('images/nextgen_logo.png') }}" alt="NEXTGEN FOREX Logo" class="h-10 sm:h-12 w-auto object-contain drop-shadow-[0_0_12px_rgba(243,202,82,0.6)]">
                        </a>
    
                        <!-- Bio Paragraph -->
                        <p class="text-[12px] text-neutral-400 leading-relaxed font-sans">
                            The future of automated forex & crypto trading is here. Join us for seamless, secure, and
                            profitable algorithmic trading.
                        </p>
    
                        <!-- Circular Gold Social Icons -->
                        <div class="flex items-center gap-2 pt-1">
                            <!-- Twitter / X -->
                            <a href="https://twitter.com" target="_blank" aria-label="Twitter"
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-amber-400 hover:bg-amber-500/20 hover:border-amber-400 hover:scale-110 transition duration-300"
                                style="border: 1px solid rgba(243, 202, 82, 0.5); background: #000000;">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                            <!-- Facebook -->
                            <a href="https://facebook.com" target="_blank" aria-label="Facebook"
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-amber-400 hover:bg-amber-500/20 hover:border-amber-400 hover:scale-110 transition duration-300"
                                style="border: 1px solid rgba(243, 202, 82, 0.5); background: #000000;">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <!-- Instagram -->
                            <a href="https://instagram.com" target="_blank" aria-label="Instagram"
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-amber-400 hover:bg-amber-500/20 hover:border-amber-400 hover:scale-110 transition duration-300"
                                style="border: 1px solid rgba(243, 202, 82, 0.5); background: #000000;">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
    
                            <!-- YouTube -->
                            <a href="https://youtube.com" target="_blank" aria-label="YouTube"
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-amber-400 hover:bg-amber-500/20 hover:border-amber-400 hover:scale-110 transition duration-300"
                                style="border: 1px solid rgba(243, 202, 82, 0.5); background: #000000;">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                        </div>
    
                        <!-- Token Badge Pill -->
    
                    </div>
    
                    <!-- Column 2: QUICK LINKS -->
                    <div class="space-y-2 text-left">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 font-mono">
                            QUICK LINKS
                        </h4>
                        <div style="height: 1px; background: rgba(255, 255, 255, 0.12); margin-top: 6px; margin-bottom: 12px;"
                            class="w-full"></div>
                        <ul class="space-y-2 text-[12px] text-neutral-300 font-sans">
                            <li><a href="#home"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Home</a></li>
                            <li><a href="#about"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> About Us</a></li>
                            <li><a href="#analytics"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Analytics</a></li>
                            <li><a href="#calculator"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> ROI Calculator</a></li>
                            <li><a href="#packages"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Packages</a></li>
                        </ul>
                    </div>
                    <!-- Column 3: SUPPORT -->
                    <div class="space-y-2 text-left">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 font-mono">
                            SUPPORT
                        </h4>
                        <div style="height: 1px; background: rgba(255, 255, 255, 0.12); margin-top: 6px; margin-bottom: 12px;"
                            class="w-full"></div>
                        <ul class="space-y-2 text-[12px] text-neutral-300 font-sans">
                            <li><a href="{{ route('user.login') }}"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Member Login</a></li>
                            <li><a href="{{ route('user.register') }}"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Register Account</a></li>
    
                            <li><a href="#faq"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> FAQ & Help</a></li>
                        </ul>
                    </div>
                    <!-- Column 4: LEGAL -->
                    <div class="space-y-2 text-left">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 font-mono">
                            LEGAL
                        </h4>
                        <div style="height: 1px; background: rgba(255, 255, 255, 0.12); margin-top: 6px; margin-bottom: 12px;"
                            class="w-full"></div>
                        <ul class="space-y-2 text-[12px] text-neutral-300 font-sans">
                            <li><a href="#faq"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Terms & Conditions</a></li>
                            <li><a href="#faq"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Privacy Policy</a></li>
                            <li><a href="#faq"
                                    class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span
                                        class="text-amber-400 font-bold">›</span> Risk Disclaimer</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Bottom Copyright & Website Domain -->
                <div class="pt-2 text-center space-y-1 text-[11px] text-neutral-400 font-sans">
                    <p>
                        &copy; {{ date('Y') }} <strong class="text-amber-400 font-bold">NextGen Forex</strong>. All rights
                        reserved. |
                        Automated Trading Platform!
                    </p>
                    <p class="text-[10px] text-amber-400/80 font-mono">
                        www.nextgenforex.com
                    </p>
                </div>

        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Scroll Reveal Intersection Observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
        });

        function toggleMobileMenu() {
            const drawer = document.getElementById('mobileDrawer');
            drawer.classList.toggle('hidden');
        }

        function updateCalculator(val) {
            val = parseFloat(val);
            document.getElementById('calcAmountLabel').innerText = '$' + val.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('btnAmount').innerText = val.toLocaleString('en-US');

            const daily = (val * 1.5) / 100;
            const total = val * 2;

            document.getElementById('calcDailyRoi').innerText = '$' + daily.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' / Day';
            document.getElementById('calcTotalReturn').innerText = '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' (2X)';
        }

        function setCalcPreset(val) {
            document.getElementById('calcRange').value = val;
            updateCalculator(val);
        }

        function toggleFaq(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');

            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                el.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</body>

</html>