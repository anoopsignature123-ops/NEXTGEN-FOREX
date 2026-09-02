@extends('user.layouts.app')

@section('content')
<style>
/* Force Exactly 2 Cards Side-by-Side in 1 Row on Screens >= 768px */
@media (min-width: 768px) {
    .grid-2-cards {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 1.5rem !important;
    }
}
</style>

<div class="w-full space-y-6 font-sans">
    
    <!-- Top Header Banner (Matching User Management & Admin Flow Exactly) -->
    <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">MP</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX MEMBER PORTAL</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">MY PROFILE & ACCOUNT SETTINGS</h1>
            <p class="text-xs text-neutral-300 mt-1">Manage your account information, binary referral links, sponsor info, and update security password.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-5 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-lg shrink-0">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                <span>Status: <strong class="{{ $user->status === 'active' ? 'text-emerald-400' : 'text-amber-400' }} text-sm font-black uppercase">{{ $user->status === 'active' ? 'ACTIVE MEMBER' : 'INACTIVE MEMBER' }}</strong></span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 text-xs font-bold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-500/20 border border-rose-500/50 text-rose-300 text-xs font-bold space-y-1">
            @foreach($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400 shrink-0"></i> {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    <!-- Profile Summary Overview -->
    <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-amber-500/20">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-amber-400 via-yellow-500 to-amber-600 text-black font-black text-2xl flex items-center justify-center shadow-xl border-2 border-amber-300 shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-black text-white font-heading">{{ $user->name }}</h2>
                    <p class="text-xs text-neutral-400 font-mono">{{ $user->email }} • {{ $user->mobile }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2.5 py-0.5 rounded bg-amber-500/20 border border-amber-500/40 text-amber-300 font-mono font-bold text-[10px]">CODE: {{ $user->referral_code }}</span>
                        <span class="px-2.5 py-0.5 rounded bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 font-mono font-bold text-[10px]">WALLETS: ${{ number_format($user->deposit_wallet, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Meta Grid Overview -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 font-mono text-xs">
            <div class="p-3.5 rounded-xl bg-bg border border-amber-500/30">
                <span class="text-neutral-400 block text-[10px] uppercase font-sans font-bold">Sponsor Name:</span>
                <strong class="text-amber-300 font-black text-sm block truncate">{{ $user->sponsor->name ?? 'Direct System' }}</strong>
                <span class="text-[10px] text-neutral-400">{{ $user->sponsor->referral_code ?? 'NGF-000000' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-bg border border-amber-500/30">
                <span class="text-neutral-400 block text-[10px] uppercase font-sans font-bold">Binary Leg Position:</span>
                <strong class="text-sky-300 font-black text-sm block uppercase">{{ $user->position ?? 'LEFT' }} LEG</strong>
                <span class="text-[10px] text-neutral-400">Team Placement</span>
            </div>

            <div class="p-3.5 rounded-xl bg-bg border border-amber-500/30">
                <span class="text-neutral-400 block text-[10px] uppercase font-sans font-bold">Registration Date:</span>
                <strong class="text-white font-black text-sm block">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</strong>
                <span class="text-[10px] text-neutral-400">{{ $user->created_at ? $user->created_at->format('h:i A') : '' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-bg border border-amber-500/30">
                <span class="text-neutral-400 block text-[10px] uppercase font-sans font-bold">Account Status:</span>
                <strong class="{{ $user->status === 'active' ? 'text-emerald-400' : 'text-amber-400' }} font-black text-sm block uppercase">{{ strtoupper($user->status) }}</strong>
                <span class="text-[10px] text-neutral-400">{{ $user->activated_at ? 'Activated: '.$user->activated_at->format('M d, Y') : 'Not Activated' }}</span>
            </div>
        </div>
    </div>

    <!-- ROW 1: BINARY REFERRAL LINK CARDS IN COL-SM-6 (2 CARDS SIDE-BY-SIDE IN 1 ROW) -->
    <div class="grid grid-cols-1 grid-2-cards gap-6">
        
        <!-- LEFT LEG REFERRAL LINK CARD -->
        <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                        👈
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white font-heading uppercase">LEFT LEG REFERRAL LINK</h3>
                        <p class="text-xs text-neutral-400">Sponsor members directly into your Left Binary Leg</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-bg border border-amber-500/30 space-y-2">
                    <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider block">SHAREABLE LEFT REFERRAL URL</span>
                    <div class="flex items-center gap-2">
                        <input type="text" id="leftRefInput" readonly value="{{ url('/user/register?sponsor='.$user->referral_code.'&position=left') }}" class="w-full px-3.5 py-2.5 rounded-xl bg-black border border-amber-500/40 text-amber-300 font-mono text-xs truncate focus:outline-none">
                        <button onclick="navigator.clipboard.writeText(document.getElementById('leftRefInput').value); showToast('Copied!', 'Left Leg Referral link copied to clipboard.', 'success');" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider transition shrink-0 shadow">
                            Copy Left
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT LEG REFERRAL LINK CARD -->
        <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                        👉
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white font-heading uppercase">RIGHT LEG REFERRAL LINK</h3>
                        <p class="text-xs text-neutral-400">Sponsor members directly into your Right Binary Leg</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-bg border border-amber-500/30 space-y-2">
                    <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider block">SHAREABLE RIGHT REFERRAL URL</span>
                    <div class="flex items-center gap-2">
                        <input type="text" id="rightRefInput" readonly value="{{ url('/user/register?sponsor='.$user->referral_code.'&position=right') }}" class="w-full px-3.5 py-2.5 rounded-xl bg-black border border-amber-500/40 text-amber-300 font-mono text-xs truncate focus:outline-none">
                        <button onclick="navigator.clipboard.writeText(document.getElementById('rightRefInput').value); showToast('Copied!', 'Right Leg Referral link copied to clipboard.', 'success');" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider transition shrink-0 shadow">
                            Copy Right
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ROW 2: FORMS IN COL-SM-6 (MANAGE PROFILE LEFT 50% & CHANGE PASSWORD RIGHT 50%) -->
    <div class="grid grid-cols-1 grid-2-cards gap-6">
        
        <!-- LEFT FORM: Update Profile Information -->
        <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                        👤
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white font-heading uppercase">UPDATE PROFILE DETAILS</h3>
                        <p class="text-xs text-neutral-400">Modify your personal contact information</p>
                    </div>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4" id="profileUpdateForm">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400" required>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Email Address (Read Only)</label>
                        <input type="email" value="{{ $user->email }}" readonly class="w-full px-4 py-3 rounded-xl bg-black border border-amber-500/20 text-neutral-400 font-mono text-xs cursor-not-allowed">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Mobile Number</label>
                        <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400" required>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Referral Code (Read Only)</label>
                        <input type="text" value="{{ $user->referral_code }}" readonly class="w-full px-4 py-3 rounded-xl bg-black border border-amber-500/20 text-amber-400 font-mono font-bold text-xs cursor-not-allowed">
                    </div>
                </form>
            </div>

            <div class="pt-4 border-t border-amber-500/20">
                <button type="submit" form="profileUpdateForm" class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-[1.01] transition flex items-center justify-center gap-2">
                    <i data-lucide="check" class="w-4 h-4 text-black"></i> Save Profile Details
                </button>
            </div>
        </div>

        <!-- RIGHT FORM: Change Password (WITH VISIBLE EYE ICONS) -->
        <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                        🔒
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white font-heading uppercase">CHANGE ACCOUNT PASSWORD</h3>
                        <p class="text-xs text-neutral-400">Update your security password for account login</p>
                    </div>
                </div>

                <form action="{{ route('user.password.update') }}" method="POST" class="space-y-4" id="passwordUpdateForm">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Current Password</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" placeholder="••••••••" class="w-full pl-4 pr-12 py-3 rounded-xl bg-bg border border-amber-500/40 text-white text-xs focus:outline-none focus:border-amber-400" required>
                            <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-amber-400 hover:text-amber-300 transition focus:outline-none bg-black/40 hover:bg-black/70 rounded-lg border border-amber-500/30 flex items-center justify-center" title="Toggle Password Visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400 eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400 eye-off-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="password" placeholder="Minimum 6 characters" class="w-full pl-4 pr-12 py-3 rounded-xl bg-bg border border-amber-500/40 text-white text-xs focus:outline-none focus:border-amber-400" required>
                            <button type="button" onclick="togglePasswordVisibility('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-amber-400 hover:text-amber-300 transition focus:outline-none bg-black/40 hover:bg-black/70 rounded-lg border border-amber-500/30 flex items-center justify-center" title="Toggle Password Visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400 eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400 eye-off-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" id="confirm_password" name="password_confirmation" placeholder="Re-enter new password" class="w-full pl-4 pr-12 py-3 rounded-xl bg-bg border border-amber-500/40 text-white text-xs focus:outline-none focus:border-amber-400" required>
                            <button type="button" onclick="togglePasswordVisibility('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-amber-400 hover:text-amber-300 transition focus:outline-none bg-black/40 hover:bg-black/70 rounded-lg border border-amber-500/30 flex items-center justify-center" title="Toggle Password Visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400 eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400 eye-off-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="pt-4 border-t border-amber-500/20">
                <button type="submit" form="passwordUpdateForm" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:brightness-110 transition flex items-center justify-center gap-2">
                    <i data-lucide="key" class="w-4 h-4 text-black"></i> Update Account Password
                </button>
            </div>
        </div>

    </div>

</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeIcon = btn.querySelector('.eye-icon');
    const eyeOffIcon = btn.querySelector('.eye-off-icon');
    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        if (eyeIcon) eyeIcon.classList.add('hidden');
        if (eyeOffIcon) eyeOffIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        if (eyeIcon) eyeIcon.classList.remove('hidden');
        if (eyeOffIcon) eyeOffIcon.classList.add('hidden');
    }
}
</script>
@endsection
