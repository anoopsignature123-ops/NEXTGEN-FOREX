@extends('user.auth.app')

@section('title', 'NEXTGEN FOREX - Admin Portal Login')

@section('content')
    <!-- Login Container -->
    <div class="w-full max-w-md relative z-20 space-y-6 my-auto">
        <!-- Logo Header -->
        <div class="text-center space-y-3">
            <div class="ng-logo-box mx-auto flex items-center justify-center">
                <svg class="w-16 h-16 drop-shadow-[0_0_20px_rgba(243,202,82,0.8)]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="44" stroke="url(#goldGradLogin)" stroke-width="4" fill="url(#bgGlobeGradLogin)"/>
                    <circle cx="50" cy="50" r="39" stroke="rgba(243,202,82,0.4)" stroke-width="1.5" stroke-dasharray="4 2" fill="none"/>
                    <ellipse cx="50" cy="50" rx="36" ry="14" stroke="rgba(0,230,118,0.3)" stroke-width="1" fill="none"/>
                    <ellipse cx="50" cy="50" rx="14" ry="36" stroke="rgba(0,230,118,0.3)" stroke-width="1" fill="none"/>
                    <line x1="14" y1="50" x2="86" y2="50" stroke="rgba(0,230,118,0.3)" stroke-width="1"/>
                    <path d="M 28 70 L 28 30 L 46 70 L 46 30" stroke="url(#goldGradLogin)" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M 32 68 L 74 24" stroke="url(#goldGradLogin)" stroke-width="6" stroke-linecap="round"/>
                    <path d="M 60 22 L 78 22 L 78 40" stroke="url(#goldGradLogin)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="goldGradLogin" x1="0" y1="0" x2="100" y2="100">
                            <stop offset="0%" stop-color="#fff5c0"/>
                            <stop offset="35%" stop-color="#f3ca52"/>
                            <stop offset="70%" stop-color="#d4af37"/>
                            <stop offset="100%" stop-color="#aa771c"/>
                        </linearGradient>
                        <radialGradient id="bgGlobeGradLogin" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#093822"/>
                            <stop offset="70%" stop-color="#041d11"/>
                            <stop offset="100%" stop-color="#020d07"/>
                        </radialGradient>
                    </defs>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-gold-gradient tracking-wider uppercase leading-none">NEXTGEN</h1>
                <p class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase mt-1.5">— FOREX TRADING —</p>
            </div>
        </div>

        <!-- Login Form Card -->
        <div class="ng-pkg-card p-8 border-2 border-amber-400 shadow-[0_0_40px_rgba(0,0,0,0.9)] space-y-6 relative backdrop-blur-xl">
            <div class="text-center space-y-1">
                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black uppercase tracking-widest border border-amber-500/40">
                    RESTRICTED ACCESS
                </span>
                <h2 class="text-2xl font-black text-white uppercase tracking-tight font-heading mt-2">ADMINISTRATOR PORTAL</h2>
                <p class="text-xs text-neutral-400">Enter your master credentials to access system controls</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Admin Email / Referral Code</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                        </div>
                        <input type="text" name="email" value="{{ old('email', 'admin@nextgenforex.com') }}" required placeholder="admin@nextgenforex.com or NGF-0000001" class="w-full pl-11 pr-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Admin Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>

                        <input type="password" id="adminPassword" name="password" value="password123" required placeholder="••••••••" class="w-full pl-11 pr-12 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">

                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-amber-400 hover:text-amber-300 transition focus:outline-none" aria-label="Toggle Password Visibility">
                            <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                <line x1="2" y1="2" x2="22" y2="22"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-neutral-300">
                        <input type="checkbox" name="remember" checked class="w-4 h-4 rounded accent-amber-500">
                        <span>Remember me</span>
                    </label>
                    <a href="javascript:void(0)" onclick="alert('Password reset link sent to admin email.');" class="text-amber-400 font-bold hover:underline">Forgot password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full py-3.5 rounded-xl bg-amber-500 text-black font-black text-sm uppercase tracking-wider shadow-xl hover:scale-102 transition flex items-center justify-center gap-2 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    LOG IN TO ADMIN CONTROL
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const pass = document.getElementById('adminPassword');
            const openSvg = document.getElementById('eyeIconOpen');
            const closedSvg = document.getElementById('eyeIconClosed');

            if (pass.type === 'password') {
                pass.type = 'text';
                openSvg.classList.add('hidden');
                closedSvg.classList.remove('hidden');
            } else {
                pass.type = 'password';
                openSvg.classList.remove('hidden');
                closedSvg.classList.add('hidden');
            }
        }
    </script>
@endpush
