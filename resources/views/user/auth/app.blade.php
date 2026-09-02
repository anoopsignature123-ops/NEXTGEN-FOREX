<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>@yield('title', 'NEXTGEN FOREX - Member Auth')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nextgen-theme.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body id="dashboard" class="min-h-screen flex items-center justify-center p-4 relative overflow-y-auto bg-black text-slate-100">

    <!-- High-Tech Forex Trading Graphic Overlay Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black z-10 opacity-90"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-black z-10 opacity-80"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full bg-amber-500/15 blur-[160px]"></div>
        <div class="absolute bottom-10 right-10 w-[500px] h-[500px] rounded-full bg-emerald-500/15 blur-[140px]"></div>

        <svg class="w-full h-full opacity-35 scale-105" viewBox="0 0 1440 900" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
            <path d="M0 900 V750 H40 V720 H70 V780 H120 V680 H170 V750 H220 V650 H260 V620 H300 V750 H360 V690 H420 V780 H480 V600 H530 V750 H600 V640 H660 V730 H720 V580 H780 V720 H840 V630 H900 V750 H960 V670 H1020 V780 H1080 V610 H1140 V750 H1200 V660 H1260 V740 H1320 V620 H1380 V750 H1440 V900 Z" fill="rgba(6, 35, 22, 0.7)"/>
            <g opacity="0.85">
                <rect x="120" y="480" width="16" height="140" rx="3" fill="#00e676"/>
                <rect x="220" y="420" width="16" height="180" rx="3" fill="#f3ca52"/>
                <rect x="360" y="340" width="16" height="220" rx="3" fill="#f3ca52"/>
                <rect x="520" y="270" width="16" height="240" rx="3" fill="#00e676"/>
                <rect x="700" y="220" width="16" height="270" rx="3" fill="#f3ca52"/>
            </g>
        </svg>
    </div>

    <!-- Main Auth Content Area -->
    @yield('content')

    <script src="{{ asset('js/app-validation.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->any())
                showToast('Authentication Error', "{{ $errors->first() }}", 'error');
            @endif
            @if (session('success'))
                showToast('Success', "{{ session('success') }}", 'success');
            @endif
            @if (session('info'))
                showToast('Info', "{{ session('info') }}", 'info');
            @endif
        });
    </script>
    @stack('scripts')
</body>

</html>
