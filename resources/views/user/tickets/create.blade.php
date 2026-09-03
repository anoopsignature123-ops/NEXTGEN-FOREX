@extends('user.layouts.app')

@section('title', 'Open Support Ticket')

@section('content')
<div class="w-full space-y-6">

    <!-- Top Header Banner (FULL WIDTH MATCHING ALL PAGES) -->
    <div class="ng-banner-title p-6 sm:p-8 flex items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pdf-num-badge">📝</span>
                <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">HELP & SUPPORT</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white font-heading">OPEN NEW SUPPORT TICKET</h1>
            <p class="text-xs text-neutral-300 mt-1">Fill in details below. Our support team responds within 24 hours.</p>
        </div>

        <a href="{{ route('user.tickets.index') }}" class="px-4 py-2 rounded-xl bg-black/80 hover:bg-black border border-amber-500/40 text-amber-300 font-bold text-xs flex items-center gap-1.5 transition shadow shrink-0">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to List
        </a>
    </div>

    <!-- TICKET FORM CONTAINER (COMPACT & ELEGANT CENTRAL FORM) -->
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 rounded-3xl pdf-package-card space-y-4 shadow-2xl">
            @csrf

            <!-- Subject Field -->
            <div>
                <label class="block text-xs font-bold text-amber-400 uppercase tracking-wider mb-1.5">Ticket Subject *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Brief summary of your query or issue..." required class="w-full px-4 py-2.5 rounded-xl bg-black/80 border border-amber-500/40 text-white font-semibold text-xs focus:outline-none focus:border-amber-400 shadow-inner">
                @error('subject')
                    <p class="text-rose-400 text-xs font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2-Column Split: Category & Priority -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase tracking-wider mb-1.5">Category *</label>
                    <select name="category" required class="w-full px-4 py-2.5 rounded-xl bg-black/80 border border-amber-500/40 text-amber-300 font-bold text-xs focus:outline-none focus:border-amber-400 cursor-pointer">
                        <option value="deposit" {{ old('category') === 'deposit' ? 'selected' : '' }}>Deposit & Fund Wallet</option>
                        <option value="withdrawal" {{ old('category') === 'withdrawal' ? 'selected' : '' }}>Withdrawal & Payout</option>
                        <option value="package" {{ old('category') === 'package' ? 'selected' : '' }}>Investment Packages</option>
                        <option value="network" {{ old('category') === 'network' ? 'selected' : '' }}>Team & Network Referral</option>
                        <option value="account" {{ old('category') === 'account' ? 'selected' : '' }}>Account & Security</option>
                        <option value="other" {{ old('category', 'other') === 'other' ? 'selected' : '' }}>General Query / Other</option>
                    </select>
                    @error('category')
                        <p class="text-rose-400 text-xs font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-xs font-bold text-amber-400 uppercase tracking-wider mb-1.5">Priority Level *</label>
                    <select name="priority" required class="w-full px-4 py-2.5 rounded-xl bg-black/80 border border-amber-500/40 text-amber-300 font-bold text-xs focus:outline-none focus:border-amber-400 cursor-pointer">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low Priority</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium Priority</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High Priority</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent Priority</option>
                    </select>
                    @error('priority')
                        <p class="text-rose-400 text-xs font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Detailed Message Field -->
            <div>
                <label class="block text-xs font-bold text-amber-400 uppercase tracking-wider mb-1.5">Message Description *</label>
                <textarea name="message" rows="4" placeholder="Explain your request or issue in detail..." required class="w-full p-3.5 rounded-xl bg-black/80 border border-amber-500/40 text-white font-medium text-xs focus:outline-none focus:border-amber-400 shadow-inner">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-rose-400 text-xs font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Attachment (Optional) -->
            <div>
                <label class="block text-xs font-bold text-amber-400 uppercase tracking-wider mb-1.5">Attach Screenshot or PDF (Optional)</label>
                <input type="file" name="attachment" accept="image/jpeg,image/png,image/jpg,application/pdf" class="w-full p-2 rounded-xl bg-black/80 border border-amber-500/40 text-neutral-300 font-mono text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:pdf-gold-ribbon file:font-black file:text-[10px] file:uppercase file:cursor-pointer cursor-pointer">
                <p class="text-[10px] text-neutral-400 mt-1">Allowed formats: JPG, PNG, PDF (Max 5MB).</p>
                @error('attachment')
                    <p class="text-rose-400 text-xs font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button (ALIGNED RIGHT) -->
            <div class="pt-3 border-t border-amber-500/20 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-full pdf-gold-ribbon font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center justify-center gap-2 text-black">
                    <i data-lucide="send" class="w-3.5 h-3.5 text-black font-black"></i>
                    <span class="text-black font-black">Submit Ticket Now</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
