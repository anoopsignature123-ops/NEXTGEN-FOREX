@extends('admin.layouts.app')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Banner Full Width -->
    <div class="ng-banner-title p-4 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">ED</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">MEMBER MODIFICATION</span>
            </div>
            <h1 class="text-xl sm:text-3xl font-black text-gold-gradient font-heading">EDIT MEMBER: {{ $user->referral_code }}</h1>
            <p class="text-xs text-neutral-300 mt-1">Update profile information, binary leg placement, or reset password</p>
        </div>
        <a href="{{ route('admin.users') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-panel border border-amber-500/40 text-amber-300 font-bold text-xs uppercase tracking-wider hover:bg-amber-500/20 transition flex items-center justify-center gap-2 shrink-0">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Directory
        </a>
    </div>

    <!-- Form Card Compact Width Centered -->
    <div class="w-full max-w-2xl mx-auto bg-panel p-4 sm:p-8 space-y-6 border border-amber-500/30 rounded-2xl shadow-xl">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Reusable Form Partial -->
            @include('admin.users.form', ['user' => $user])

            <div class="pt-6 border-t border-amber-500/20 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.users') }}" class="px-6 py-3.5 rounded-xl bg-neutral-900 border border-amber-500/20 text-neutral-300 font-bold text-xs uppercase tracking-wider hover:bg-neutral-800 transition text-center">
                    CANCEL
                </a>
                <button type="submit" class="px-8 py-3.5 rounded-xl bg-amber-500 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-102 transition flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4 text-black"></i>
                    UPDATE MEMBER DETAILS
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
