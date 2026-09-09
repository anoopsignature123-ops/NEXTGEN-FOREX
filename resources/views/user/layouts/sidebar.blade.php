<!-- ======================================
     Start User Sidebar Area
     ====================================== -->
<div id="sidebarOverlay"
    class="fixed inset-0 bg-black/70 z-40 hidden lg:hidden transition-opacity duration-300 opacity-0"
    aria-hidden="true"></div>
<aside class="sidebar" id="sidebar">
    <!-- Logo Section -->
    <div class="logo-section flex items-center justify-between gap-2 px-4 py-4 border-b border-amber-500/30 shrink-0 bg-gradient-to-b from-amber-500/20 via-amber-500/5 to-transparent">
        <a href="{{ route('user.dashboard') }}" class="flex items-center justify-center flex-1 min-w-0">
            <img src="{{ asset('images/nextgen_logo.png') }}" alt="NEXTGEN FOREX Logo" class="full-logo h-12 sm:h-14 w-auto max-w-[210px] object-contain drop-shadow-[0_0_16px_rgba(243,202,82,0.9)] hover:scale-105 transition duration-300">
            <img src="{{ asset('assets/images/favicon.png') }}" alt="NEXTGEN Emblem" class="mini-logo hidden w-10 h-10 object-contain drop-shadow-[0_0_15px_rgba(243,202,82,0.9)] hover:scale-110 transition duration-300 mx-auto">
        </a>
        <button
            class="lg:hidden! flex w-8 h-8 items-center justify-center rounded-lg text-amber-400 hover:bg-amber-500/20 transition js-mobile-menu-toggle shrink-0"
            aria-label="Close sidebar">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="py-4 flex-1 overflow-y-auto space-y-1">
        
        <!-- 0. MAIN OVERVIEW SECTION -->
        <div class="nav-section-title px-5 pt-3 pb-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
        Dashboard
        </div>

        <!-- Dashboard Link -->
        <a class='nav-item {{ request()->routeIs("user.dashboard") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.dashboard") }}'>
            <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <style>
            @keyframes arbitrageGoldGlow {
                0%, 100% {
                    box-shadow: 0 0 15px rgba(243, 202, 82, 0.75), 0 0 25px rgba(212, 175, 55, 0.45);
                    filter: brightness(1);
                }
                50% {
                    box-shadow: 0 0 28px rgba(243, 202, 82, 1), 0 0 45px rgba(255, 215, 0, 0.85);
                    filter: brightness(1.15);
                }
            }

            .arbitrage-gold-pill {
                background: linear-gradient(90deg, #d4af37 0%, #fef08a 45%, #eab308 80%, #d4af37 100%) !important;
                color: #000000 !important;
                border-radius: 9999px !important;
                animation: arbitrageGoldGlow 2.2s infinite ease-in-out !important;
                border: 1.5px solid rgba(255, 255, 255, 0.6) !important;
                transition: all 0.3s ease !important;
            }
            .arbitrage-gold-pill .nav-text,
            .arbitrage-gold-pill i,
            .arbitrage-gold-pill svg {
                color: #000000 !important;
                font-weight: 900 !important;
                stroke: #000000 !important;
            }
            .arbitrage-gold-pill:hover {
                transform: scale(1.04) !important;
            }
        </style>

        <!-- Arbitrage Link -->
        <a class='nav-item arbitrage-gold-pill flex items-center gap-3 mx-3 my-1.5 px-4 py-2.5 rounded-full text-sm font-black text-black shadow-xl transition'
            href='{{ route("user.arbitrage") }}'>
            <i data-lucide="rocket" class="w-5 h-5 shrink-0 text-black"></i>
            <span class="nav-text text-black font-black">Arbitrage</span>
        </a>

        <!-- 1. ADD FUND & WITHDRAWAL SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            ADD FUND & WITHDRAWAL
        </div>

        <!-- Add Fund / Deposit -->
        <a class='nav-item {{ request()->routeIs("user.deposits.index") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.deposits.index") }}'>
            <i data-lucide="wallet" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Add Fund / Deposit</span>
        </a>

        <!-- Deposit History -->
        <a class='nav-item {{ request()->routeIs("user.deposits.history") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.deposits.history") }}'>
            <i data-lucide="clock" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Deposit History</span>
        </a>

        <!-- Withdrawal Request -->
        <a class='nav-item {{ request()->routeIs("user.withdrawals.index") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.withdrawals.index") }}'>
            <i data-lucide="arrow-up-right" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Withdrawal</span>
        </a>

        <!-- Withdrawal History -->
        <a class='nav-item {{ request()->routeIs("user.withdrawals.history") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.withdrawals.history") }}'>
            <i data-lucide="receipt" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Withdrawal History</span>
        </a>

        <!-- 2. INVESTMENT SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            INVESTMENT
        </div>

        <!-- Buy Packages -->
        <a class='nav-item {{ request()->routeIs("user.packages.index") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.packages.index") }}'>
            <i data-lucide="package-check" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Buy Packages</span>
        </a>

        <!-- BOT -->
        <a class='nav-item {{ request()->routeIs("user.bot*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.bot.index") }}'>
            <i data-lucide="bot" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">BOT</span>
        </a>

        <!-- Packages History -->
        <a class='nav-item {{ request()->routeIs("user.packages.history") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.packages.history") }}'>
            <i data-lucide="history" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Packages History</span>
        </a>

        <!-- 3. TRANSACTIONS SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            TRANSACTIONS
        </div>

        <!-- Transaction Logs -->
        <a class='nav-item {{ request()->routeIs("user.transactions*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.transactions.index") }}'>
            <i data-lucide="receipt" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Transaction History</span>
        </a>

        <!-- 4. MY NETWORK SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            MY NETWORK & TEAM
        </div>

        <!-- Direct Members -->
        <a class='nav-item {{ request()->routeIs("user.network.direct*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.network.direct") }}'>
            <i data-lucide="users" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Direct Members</span>
        </a>

        <!-- My Team Tree -->
        <a class='nav-item {{ request()->routeIs("user.network.tree*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.network.tree") }}'>
            <i data-lucide="git-merge" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">My Team Tree</span>
        </a>

        <!-- 5. MY INCOMES & REPORTS SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            MY INCOMES & REPORTS
        </div>

        <!-- 0. Income Overview Summary -->
        <a class='nav-item {{ request()->routeIs("user.reports.summary") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.summary") }}'>
            <i data-lucide="bar-chart-3" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Income Overview Summary</span>
        </a>

        <!-- 1. My ROI Income -->
        <a class='nav-item {{ request()->routeIs("user.reports.roi") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.roi") }}'>
            <i data-lucide="trending-up" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">My ROI Income</span>
        </a>

        <!-- 2. My Direct Income -->
        <a class='nav-item {{ request()->routeIs("user.reports.direct") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.direct") }}'>
            <i data-lucide="user-check" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Direct Commission Report</span>
        </a>

        <!-- 3. My Special Bonus -->
        <a class='nav-item {{ request()->routeIs("user.reports.bonus") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.bonus") }}'>
            <i data-lucide="gift" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">24H Special Bonus</span>
        </a>

        <!-- 4. Level Income Report -->
        <a class='nav-item {{ request()->routeIs("user.reports.level") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.level") }}'>
            <i data-lucide="layers" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Level Income Report</span>
        </a>

        <!-- 4. My Matching Income -->
        <a class='nav-item {{ request()->routeIs("user.reports.matching") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.matching") }}'>
            <i data-lucide="git-merge" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Matching Income</span>
        </a>

        <!-- 5. My Direct Salary -->
        <a class='nav-item {{ request()->routeIs("user.reports.direct-salary") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.direct-salary") }}'>
            <i data-lucide="banknote" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Direct Salary Income</span>
        </a>

        <!-- 6. My Team Salary -->
        <a class='nav-item {{ request()->routeIs("user.reports.team-salary") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.team-salary") }}'>
            <i data-lucide="users" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Team Salary Income</span>
        </a>

        <!-- 7. My Rewards -->
        <a class='nav-item {{ request()->routeIs("user.reports.rewards") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-2.5 rounded-xl text-xs font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.reports.rewards") }}'>
            <i data-lucide="trophy" class="w-4 h-4 shrink-0 text-amber-400"></i>
            <span class="nav-text">Reward Income</span>
        </a>

        <!-- 6. ACCOUNT & SECURITY SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            ACCOUNT & SECURITY
        </div>

        <!-- My Profile -->
        <a class='nav-item {{ request()->routeIs("user.profile*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.profile") }}'>
            <i data-lucide="user-cog" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">My Profile</span>
        </a>

        <!-- Support Tickets -->
        <a class='nav-item {{ request()->routeIs("user.tickets*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.tickets.index") }}'>
            <i data-lucide="headphones" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Support Tickets</span>
        </a>

    </nav>

    <!-- User Footprint -->
    <div class="user-section mt-auto p-4 border-t border-amber-500/30 shrink-0 bg-neutral-950/80">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-black text-sm shadow-md">
                US
            </div>
            <div class="user-info flex-1 min-w-0">
                <p class="font-bold text-sm text-white truncate">{{ Auth::user() ? Auth::user()->name : 'Member' }}</p>
                <p class="text-[11px] font-semibold truncate {{ Auth::user() && Auth::user()->status === 'active' ? 'text-emerald-400' : 'text-amber-400' }}">
                    {{ Auth::user() && Auth::user()->status === 'active' ? 'Active Member' : 'Inactive Member' }}
                </p>
            </div>
        </div>
    </div>
</aside>
<!-- ======================================
     End User Sidebar Area
     ====================================== -->
