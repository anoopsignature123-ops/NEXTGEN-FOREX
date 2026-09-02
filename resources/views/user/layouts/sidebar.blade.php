<!-- ======================================
     Start User Sidebar Area
     ====================================== -->
<div id="sidebarOverlay"
    class="fixed inset-0 bg-black/70 z-40 hidden lg:hidden transition-opacity duration-300 opacity-0"
    aria-hidden="true"></div>
<aside class="sidebar" id="sidebar">
    <!-- Logo Section -->
    <div class="logo-section flex items-center gap-3 px-4 py-4 border-b border-amber-500/30 shrink-0 bg-gradient-to-b from-amber-500/10 to-transparent">
        <div class="ng-logo-box shrink-0 flex items-center justify-center">
            <svg class="w-10 h-10 drop-shadow-[0_0_8px_rgba(243,202,82,0.6)]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="44" stroke="url(#goldGradientUser)" stroke-width="4" fill="url(#bgGlobeGradientUser)"/>
                <circle cx="50" cy="50" r="39" stroke="rgba(243,202,82,0.4)" stroke-width="1.5" stroke-dasharray="4 2" fill="none"/>
                <ellipse cx="50" cy="50" rx="36" ry="14" stroke="rgba(0,230,118,0.3)" stroke-width="1" fill="none"/>
                <ellipse cx="50" cy="50" rx="14" ry="36" stroke="rgba(0,230,118,0.3)" stroke-width="1" fill="none"/>
                <line x1="14" y1="50" x2="86" y2="50" stroke="rgba(0,230,118,0.3)" stroke-width="1"/>
                <path d="M 28 70 L 28 30 L 46 70 L 46 30" stroke="url(#goldGradientUser)" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M 32 68 L 74 24" stroke="url(#goldGradientUser)" stroke-width="6" stroke-linecap="round"/>
                <path d="M 60 22 L 78 22 L 78 40" stroke="url(#goldGradientUser)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                <defs>
                    <linearGradient id="goldGradientUser" x1="0" y1="0" x2="100" y2="100">
                        <stop offset="0%" stop-color="#fff5c0"/>
                        <stop offset="35%" stop-color="#f3ca52"/>
                        <stop offset="70%" stop-color="#d4af37"/>
                        <stop offset="100%" stop-color="#aa771c"/>
                    </linearGradient>
                    <radialGradient id="bgGlobeGradientUser" cx="50%" cy="50%" r="50%">
                        <stop offset="0%" stop-color="#093822"/>
                        <stop offset="70%" stop-color="#041d11"/>
                        <stop offset="100%" stop-color="#020d07"/>
                    </radialGradient>
                </defs>
            </svg>
        </div>
        <div class="logo-text min-w-0 flex-1">
            <h1 class="text-xl font-black tracking-wider leading-none text-gold-gradient uppercase whitespace-nowrap">NEXTGEN</h1>
            <p class="text-[10px] text-amber-400 font-bold tracking-[2px] uppercase leading-tight mt-1 whitespace-nowrap">— MEMBER PORTAL —</p>
        </div>
        <button
            class="lg:hidden! flex w-8 h-8 items-center justify-center rounded-lg text-amber-400 hover:bg-amber-500/20 transition js-mobile-menu-toggle shrink-0"
            aria-label="Close sidebar">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="py-4 flex-1 overflow-y-auto space-y-1">
        <div class="nav-section-title px-5 pt-3 pb-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            Active Modules
        </div>

        <!-- Dashboard -->
        <a class='nav-item {{ request()->routeIs("user.dashboard") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.dashboard") }}'>
            <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <!-- INVESTMENTS & FUNDINGS SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            Investments & Fundings
        </div>

        <!-- Add Fund / Deposit Wallet -->
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

        <!-- Buy Packages -->
        <a class='nav-item {{ request()->routeIs("user.packages.index") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.packages.index") }}'>
            <i data-lucide="package-check" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Buy Packages</span>
        </a>

        <!-- Packages History -->
        <a class='nav-item {{ request()->routeIs("user.packages.history") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.packages.history") }}'>
            <i data-lucide="history" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">Packages History</span>
        </a>

        <!-- MY NETWORK SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            My Network & Team
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

        <!-- ACCOUNT & SETTINGS SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            Account & Security
        </div>

        <!-- My Profile -->
        <a class='nav-item {{ request()->routeIs("user.profile*") ? "active bg-amber-500/15 text-amber-300 border-r-4 border-amber-400 font-bold shadow-lg" : "" }} flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-300 hover:bg-amber-500/10 hover:text-amber-300 transition'
            href='{{ route("user.profile") }}'>
            <i data-lucide="user-cog" class="w-5 h-5 shrink-0 text-amber-400"></i>
            <span class="nav-text">My Profile</span>
        </a>

        <!-- COMING SOON MODULES SECTION -->
        <div class="nav-section-title px-5 pt-4 pb-2 mt-2 text-[10px] font-black uppercase tracking-[2px] text-amber-400/70">
            Upcoming Features
        </div>

        <div class="flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-500 opacity-60 cursor-not-allowed">
            <i data-lucide="building-2" class="w-5 h-5 shrink-0 text-neutral-500"></i>
            <span class="nav-text">Company Overview</span>
            <span class="ml-auto text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded font-black">COMING SOON</span>
        </div>

        <div class="flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-500 opacity-60 cursor-not-allowed">
            <i data-lucide="coins" class="w-5 h-5 shrink-0 text-neutral-500"></i>
            <span class="nav-text">My Incomes</span>
            <span class="ml-auto text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded font-black">COMING SOON</span>
        </div>

        <div class="flex items-center gap-3 mx-3 my-0.5 px-4 py-3 rounded-xl text-sm font-medium text-neutral-500 opacity-60 cursor-not-allowed">
            <i data-lucide="shield-check" class="w-5 h-5 shrink-0 text-neutral-500"></i>
            <span class="nav-text">Terms & Rules</span>
            <span class="ml-auto text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded font-black">COMING SOON</span>
        </div>
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
     End Sidebar Area
     ====================================== -->
