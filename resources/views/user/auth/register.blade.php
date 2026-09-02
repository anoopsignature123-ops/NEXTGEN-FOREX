@extends('user.auth.app')

@section('title', 'NEXTGEN FOREX - Member Registration')

@section('content')
    <!-- Registration Container -->
    <div class="w-full max-w-xl relative z-20 space-y-6 my-8">
        <!-- Logo Header -->
        <div class="text-center space-y-3">
            <div class="ng-logo-box mx-auto flex items-center justify-center">
                <svg class="w-16 h-16 drop-shadow-[0_0_20px_rgba(243,202,82,0.8)]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="44" stroke="url(#goldGradReg)" stroke-width="4" fill="url(#bgGlobeReg)"/>
                    <circle cx="50" cy="50" r="39" stroke="rgba(243,202,82,0.4)" stroke-width="1.5" stroke-dasharray="4 2" fill="none"/>
                    <path d="M 28 70 L 28 30 L 46 70 L 46 30" stroke="url(#goldGradReg)" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M 32 68 L 74 24" stroke="url(#goldGradReg)" stroke-width="6" stroke-linecap="round"/>
                    <path d="M 60 22 L 78 22 L 78 40" stroke="url(#goldGradReg)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="goldGradReg" x1="0" y1="0" x2="100" y2="100">
                            <stop offset="0%" stop-color="#fff5c0"/>
                            <stop offset="35%" stop-color="#f3ca52"/>
                            <stop offset="70%" stop-color="#d4af37"/>
                            <stop offset="100%" stop-color="#aa771c"/>
                        </linearGradient>
                        <radialGradient id="bgGlobeReg" cx="50%" cy="50%" r="50%">
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

        <!-- Form Card -->
        <div class="ng-pkg-card p-6 sm:p-8 border-2 border-amber-400 shadow-[0_0_40px_rgba(0,0,0,0.9)] space-y-6 relative backdrop-blur-xl">
            <div class="text-center space-y-1">
                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black uppercase tracking-widest border border-amber-500/40">
                    CREATE NEW ACCOUNT
                </span>
                <h2 class="text-2xl font-black text-white uppercase tracking-tight font-heading mt-2">MEMBER REGISTRATION</h2>
                <p class="text-xs text-neutral-400">Join the next-generation binary forex investment ecosystem</p>
            </div>

            <!-- Form -->
            <form action="{{ route('user.register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Sponsor ID Input -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Sponsor Code / ID *</label>
                    <div class="relative">
                        <input type="text" name="sponsor_id" value="{{ old('sponsor_id', $sponsor ?? 'NGF-0000001') }}" required placeholder="e.g. NGF-0000001" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- Binary Position Selection -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Binary Tree Placement Leg *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="p-3.5 rounded-xl border border-amber-500/40 bg-bg cursor-pointer hover:bg-amber-500/10 transition flex items-center gap-3">
                            <input type="radio" name="position" value="left" checked class="w-4 h-4 accent-amber-500">
                            <div>
                                <span class="text-xs font-bold text-white block uppercase">LEFT LEG</span>
                                <span class="text-[10px] text-amber-400 font-semibold block">Power Leg</span>
                            </div>
                        </label>

                        <label class="p-3.5 rounded-xl border border-amber-500/40 bg-bg cursor-pointer hover:bg-amber-500/10 transition flex items-center gap-3">
                            <input type="radio" name="position" value="right" class="w-4 h-4 accent-amber-500">
                            <div>
                                <span class="text-xs font-bold text-white block uppercase">RIGHT LEG</span>
                                <span class="text-[10px] text-emerald-400 font-semibold block">Weaker Leg</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Full Name & Email -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Mobile Phone *</label>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" required placeholder="+1 234 567 890" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                </div>

                <!-- Password & Confirm Password with Pure Vector SVG Eye Toggle -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Account Password *</label>
                        <div class="relative">
                            <input type="password" id="regPassword" name="password" required placeholder="••••••••" class="w-full pl-4 pr-12 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                            
                            <button type="button" onclick="togglePassVisibility('regPassword', 'regEyeOpen', 'regEyeClosed')" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-amber-400 hover:text-amber-300 transition focus:outline-none" aria-label="Toggle Password Visibility">
                                <svg id="regEyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="regEyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                    <line x1="2" y1="2" x2="22" y2="22"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-amber-400 uppercase mb-1.5">Confirm Password *</label>
                        <div class="relative">
                            <input type="password" id="regPasswordConfirm" name="password_confirmation" required placeholder="••••••••" class="w-full pl-4 pr-12 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-sm focus:outline-none focus:border-amber-400">
                            
                            <button type="button" onclick="togglePassVisibility('regPasswordConfirm', 'regConfirmEyeOpen', 'regConfirmEyeClosed')" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-amber-400 hover:text-amber-300 transition focus:outline-none" aria-label="Toggle Password Visibility">
                                <svg id="regConfirmEyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="regConfirmEyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                    <line x1="2" y1="2" x2="22" y2="22"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-neutral-300">
                        <input type="checkbox" required checked class="w-4 h-4 rounded accent-amber-500">
                        <span>I agree to the <a href="javascript:void(0)" class="text-amber-400 font-bold hover:underline">Terms & Conditions</a> of NextGen Forex.</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 rounded-xl bg-amber-500 text-black font-black text-sm uppercase tracking-wider shadow-xl hover:scale-102 transition flex items-center justify-center gap-2 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    REGISTER & GET MEMBER ID
                </button>
            </form>

            <div class="text-center pt-2 border-t border-amber-500/20">
                <p class="text-xs text-neutral-400">
                    Already have an account? 
                    <a href="{{ route('user.login') }}" class="text-amber-400 font-black hover:underline ml-1">LOG IN HERE</a>
                </p>
            </div>
        </div>
    </div>

    <!-- CONGRATULATIONS SUCCESS MODAL POPUP -->
    @if(isset($showModal) && $showModal && isset($registeredUser))
    <div id="congratsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
        <div class="w-full max-w-md ng-pkg-card p-6 sm:p-8 border-2 border-amber-400 shadow-[0_0_60px_rgba(243,202,82,0.5)] text-center space-y-5 animate-fadeInUp">
            
            <!-- Trophy Badge -->
            <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg border-2 border-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                    <path d="M4 22h16"/>
                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                </svg>
            </div>

            <div>
                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black uppercase tracking-widest border border-amber-500/40">
                    CONGRATULATIONS!
                </span>
                <h3 class="text-2xl font-black text-white uppercase tracking-tight mt-2 font-heading">REGISTRATION SUCCESSFUL</h3>
                <p class="text-xs text-neutral-300 mt-1">Welcome to NextGen Forex Trading. Please save your login credentials below.</p>
            </div>

            <!-- Credentials Box -->
            <div class="p-4 rounded-xl bg-black/80 border border-amber-500/40 text-left space-y-2 text-xs">
                <div class="flex justify-between items-center pb-1.5 border-b border-amber-500/20">
                    <span class="text-neutral-400">Referral / Member Code:</span>
                    <span id="copyUserId" class="font-black text-amber-400 text-sm tracking-wider">{{ $registeredUser['user_id'] }}</span>
                </div>
                <div class="flex justify-between items-center pb-1.5 border-b border-amber-500/20">
                    <span class="text-neutral-400">Sponsor Code:</span>
                    <span class="font-bold text-white">{{ $registeredUser['sponsor_id'] }}</span>
                </div>
                <div class="flex justify-between items-center pb-1.5 border-b border-amber-500/20">
                    <span class="text-neutral-400">Member Name:</span>
                    <span class="font-bold text-white">{{ $registeredUser['name'] }}</span>
                </div>
                <div class="flex justify-between items-center pb-1.5 border-b border-amber-500/20">
                    <span class="text-neutral-400">Binary Position:</span>
                    <span class="font-bold text-emerald-400">{{ $registeredUser['position'] }} LEG</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-neutral-400">Transaction PIN:</span>
                    <span class="font-black text-amber-400 text-sm tracking-widest">{{ $registeredUser['tx_pin'] }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-2 pt-1">
                <button onclick="copyDetails('{{ $registeredUser['user_id'] }}', '{{ $registeredUser['tx_pin'] }}')" class="w-full py-3 rounded-xl bg-amber-500/20 border border-amber-500/50 text-amber-300 font-bold text-xs uppercase tracking-wider hover:bg-amber-500/30 transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    Copy Member Details
                </button>

                <a href="{{ route('user.dashboard') }}" class="w-full py-3.5 rounded-xl bg-amber-500 text-black font-black text-sm uppercase tracking-wider shadow-lg hover:scale-102 transition flex items-center justify-center gap-2">
                    PROCEED TO DASHBOARD
                </a>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (isset($showModal) && $showModal)
                showToast('Welcome!', "Registration successful! Member Code generated.", 'success');
            @endif
        });

        function togglePassVisibility(inputId, openId, closedId) {
            const pass = document.getElementById(inputId);
            const openSvg = document.getElementById(openId);
            const closedSvg = document.getElementById(closedId);

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

        function copyDetails(userId, pin) {
            const details = `NEXTGEN FOREX MEMBER CREDENTIALS\nMember Code: ${userId}\nTransaction PIN: ${pin}\nPortal: {{ url('/user/login') }}`;
            navigator.clipboard.writeText(details).then(() => {
                showToast('Copied!', 'Member details copied to clipboard.', 'success');
            });
        }
    </script>
@endpush
