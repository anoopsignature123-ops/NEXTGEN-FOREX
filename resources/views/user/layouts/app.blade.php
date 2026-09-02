<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>NEXTGEN FOREX - User Member Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nextgen-theme.css') }}" rel="stylesheet">
</head>

<body id="dashboard" class="relative overflow-x-hidden min-h-screen text-slate-100">
    <!-- User Sidebar -->
    @include('user.layouts.sidebar')

    <!-- Main Content Area -->
    <div class="main-content min-h-screen flex flex-col transition-all duration-300">
        <!-- User Header -->
        @include('user.layouts.header')

        <!-- Page Content -->
        <main class="flex-1 p-3 sm:p-6 lg:p-8 space-y-6 inner-content">
            @yield('content')
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/app-validation.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.lucide) {
                window.lucide.createIcons();
            }

            // Mobile Sidebar Drawer Controller
            const mobileBtns = document.querySelectorAll('.js-mobile-menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            mobileBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (sidebar) sidebar.classList.toggle('mobile-sidebar-open');
                    if (overlay) {
                        overlay.classList.toggle('hidden');
                        overlay.classList.toggle('opacity-100');
                    }
                });
            });

            if (overlay) {
                overlay.addEventListener('click', function() {
                    if (sidebar) sidebar.classList.remove('mobile-sidebar-open');
                    overlay.classList.add('hidden');
                    overlay.classList.remove('opacity-100');
                });
            }

            // Trigger Global Toasts for Session Flashes
            @if (session('success'))
                showToast('Success', "{{ session('success') }}", 'success');
            @endif
            @if (session('error'))
                showToast('Error', "{{ session('error') }}", 'error');
            @endif
            @if (session('info'))
                showToast('Info', "{{ session('info') }}", 'info');
            @endif
        });
    </script>
</body>

</html>
