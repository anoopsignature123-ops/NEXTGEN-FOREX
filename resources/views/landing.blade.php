<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>NEXTGEN FOREX - Coming Soon</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nextgen-theme.css') }}" rel="stylesheet">
</head>

<body id="dashboard" class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-black text-slate-100">

    <!-- High-Tech Forex Background Artwork -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black z-10 opacity-90"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-amber-500/10 blur-[150px]"></div>
    </div>

    <!-- Super Simple Coming Soon View -->
    <div class="w-full max-w-lg relative z-20 space-y-6 text-center my-auto px-4">
        <!-- Logo -->
        <div class="space-y-3">
            <div class="ng-logo-box mx-auto flex items-center justify-center">
                <svg class="w-20 h-20 drop-shadow-[0_0_25px_rgba(243,202,82,0.9)]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="44" stroke="url(#goldGradSimple)" stroke-width="4" fill="url(#bgGlobeSimple)"/>
                    <circle cx="50" cy="50" r="39" stroke="rgba(243,202,82,0.4)" stroke-width="1.5" stroke-dasharray="4 2" fill="none"/>
                    <path d="M 28 70 L 28 30 L 46 70 L 46 30" stroke="url(#goldGradSimple)" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M 32 68 L 74 24" stroke="url(#goldGradSimple)" stroke-width="6" stroke-linecap="round"/>
                    <path d="M 60 22 L 78 22 L 78 40" stroke="url(#goldGradSimple)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="goldGradSimple" x1="0" y1="0" x2="100" y2="100">
                            <stop offset="0%" stop-color="#fff5c0"/>
                            <stop offset="35%" stop-color="#f3ca52"/>
                            <stop offset="70%" stop-color="#d4af37"/>
                            <stop offset="100%" stop-color="#aa771c"/>
                        </linearGradient>
                        <radialGradient id="bgGlobeSimple" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#093822"/>
                            <stop offset="70%" stop-color="#041d11"/>
                            <stop offset="100%" stop-color="#020d07"/>
                        </radialGradient>
                    </defs>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-black text-gold-gradient tracking-wider uppercase leading-none font-heading">NEXTGEN</h1>
                <p class="text-xs text-amber-400 font-extrabold tracking-[4px] uppercase mt-2">— FOREX TRADING —</p>
            </div>
        </div>

        <!-- Simple Coming Soon Text -->
        <div class="space-y-2 pt-4">
            <h2 class="text-4xl sm:text-5xl font-black text-white uppercase tracking-wider font-heading">COMING SOON</h2>
            <p class="text-xs sm:text-sm text-neutral-400 font-medium">Next Generation Forex Trading Platform</p>
        </div>
    </div>

</body>

</html>
