@extends('admin.layouts.app')

@section('content')
    <div class="w-full space-y-6">
        <!-- Header Banner Full Width -->
        <div class="ng-banner-title p-4 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="pdf-num-badge">ED</span>
                    <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">MEMBER MODIFICATION</span>
                </div>
                <h1 class="text-xl sm:text-3xl font-black text-gold-gradient font-heading">EDIT MEMBER: {{ $user->referral_code }}</h1>
                <p class="text-xs text-neutral-300 mt-1">Update profile information, account status, or reset password</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users') }}"
                    class="px-5 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 font-bold text-xs uppercase tracking-wider hover:bg-amber-500/20 transition inline-flex items-center gap-2 shrink-0 shadow-lg">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Directory
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="w-full max-w-2xl mx-auto p-4 rounded-xl bg-rose-500/20 border border-rose-500/50 text-rose-300 text-xs font-bold space-y-1 shadow-lg">
                <div class="flex items-center gap-2 text-rose-400">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span>Please fix the following validation errors:</span>
                </div>
                <ul class="list-disc list-inside pl-6 space-y-0.5 text-rose-200 text-[11px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card Compact Width Centered -->
        <div
            class="w-full max-w-2xl mx-auto bg-panel p-4 sm:p-8 space-y-6 border border-amber-500/30 rounded-2xl shadow-xl">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Reusable Form Partial -->
                @include('admin.users.form', ['user' => $user])

                <div
                    class="pt-6 border-t border-amber-500/20 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                    <a href="{{ route('admin.users') }}"
                        class="px-6 py-3.5 rounded-xl bg-neutral-900 border border-amber-500/20 text-neutral-300 font-bold text-xs uppercase tracking-wider hover:bg-neutral-800 transition text-center">
                        CANCEL
                    </a>
                    <button type="submit"
                        class="px-8 py-3.5 rounded-xl bg-amber-500 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-102 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4 text-black"></i>
                        UPDATE MEMBER DETAILS
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection