@extends('user.layouts.app')

@section('title', 'Request Withdrawal')

@section('content')
<div class="w-full space-y-6 font-sans">
    
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-amber-400 uppercase tracking-widest mb-1">
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-amber-400"></i>
                <span>Earning Wallet Withdrawal</span>
            </div>
            <h1 class="text-2xl font-black font-heading text-white uppercase tracking-wider">
                Withdrawal Request (USDT BEP20)
            </h1>
            <p class="text-xs text-neutral-400 mt-1">Withdraw your earnings 24x7 to your USDT (BEP20) crypto wallet with instant 10% deduction calculation</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('user.withdrawals.history') }}" class="px-4 py-2.5 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-300 font-bold text-xs hover:bg-amber-500/30 transition flex items-center gap-2">
                <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i> Withdrawal History
            </a>
        </div>
    </div>

    <!-- 1 ROW SIDE-BY-SIDE CARDS CONTAINER (REQUEST PAYOUT & WITHDRAWAL RULES) -->
    <div class="flex flex-col lg:flex-row gap-6 w-full items-start">
        
        <!-- LEFT CARD: WITHDRAWAL FORM (50% WIDTH / 1 ROW LEFT SIDE) -->
        <div class="w-full lg:w-1/2 bg-panel p-5 sm:p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5">
            <div class="flex items-center justify-between border-b border-amber-500/20 pb-3">
                <div>
                    <h3 class="text-base font-black text-white uppercase font-heading">Request Payout</h3>
                    <p class="text-[11px] text-neutral-400">Enter withdrawal amount ($10 min)</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-[10px] font-black font-mono">
                    24x7 Active
                </span>
            </div>

            @if(session('error'))
                <div class="p-3 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('user.withdrawals.store') }}" method="POST" class="space-y-4" onsubmit="return confirm('Are you sure you want to submit this withdrawal request?');">
                @csrf

                <!-- 1. EARNING WALLET BALANCE DISPLAY -->
                <div class="p-3.5 rounded-xl bg-black/60 border border-amber-500/40 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold text-amber-400 uppercase tracking-wider block">EARNING WALLET</span>
                        <span class="text-xl font-black font-mono text-emerald-400">${{ number_format($user->earning_wallet, 2) }}</span>
                    </div>
                    <i data-lucide="wallet" class="w-6 h-6 text-amber-400 opacity-60"></i>
                </div>

                <!-- 2. WITHDRAWAL AMOUNT INPUT -->
                <div>
                    <label class="block text-[11px] font-extrabold text-amber-400 uppercase tracking-wider mb-1">WITHDRAWAL AMOUNT ($)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-400 font-bold font-mono text-xs">$</span>
                        <input type="number" step="0.01" min="10" name="amount" id="withdrawAmount" required placeholder="Minimum $10.00" class="w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono font-bold text-xs focus:outline-none focus:border-amber-400">
                    </div>
                    <span class="text-[10px] text-neutral-400 mt-1 block">Min withdrawal: <strong class="text-amber-400">$10.00</strong></span>
                </div>

                <!-- 3. LIVE 10% DEDUCTION CALCULATOR DISPLAY -->
                <div class="p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/30 space-y-1.5 text-xs">
                    <div class="flex justify-between text-neutral-300">
                        <span class="text-[11px]">Requested:</span>
                        <span id="previewRequested" class="font-mono font-bold text-white text-xs">$0.00</span>
                    </div>
                    <div class="flex justify-between text-rose-400">
                        <span class="text-[11px]">10% Deduction:</span>
                        <span id="previewDeduction" class="font-mono font-bold text-xs">-$0.00</span>
                    </div>
                    <div class="flex justify-between border-t border-amber-500/20 pt-1.5 text-xs font-black text-emerald-400">
                        <span>Net Payable:</span>
                        <span id="previewNet" class="font-mono text-sm">$0.00</span>
                    </div>
                </div>

                <!-- 4. USDT (BEP20) WALLET ADDRESS (AUTO-FETCHED FROM PROFILE) -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-[11px] font-extrabold text-amber-400 uppercase tracking-wider">USDT (BEP20) WALLET ADDRESS *</label>
                        @if($user->wallet_address)
                            <span class="text-[9px] text-emerald-400 font-mono font-bold">⚡ AUTO-FETCHED FROM PROFILE</span>
                        @endif
                    </div>
                    <div class="relative">
                        <i data-lucide="qr-code" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-amber-400"></i>
                        <input type="text" name="usdt_address" value="{{ old('usdt_address', $user->wallet_address) }}" required placeholder="USDT BEP20 address (0x...)" class="w-full pl-8 pr-3 py-2.5 rounded-xl bg-black/60 border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400">
                    </div>
                    @if(!$user->wallet_address)
                        <span class="text-[10px] text-neutral-400 mt-1 block">Tip: Save your payout address in <a href="{{ route('user.profile') }}" class="text-amber-400 underline font-bold">My Profile</a> to auto-fill automatically!</span>
                    @endif
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-black text-xs uppercase tracking-wider transition shadow-[0_0_15px_rgba(243,202,82,0.4)] flex items-center justify-center gap-1.5">
                    <i data-lucide="send" class="w-4 h-4 text-black"></i> Submit Withdrawal Request
                </button>
            </form>
        </div>

        <!-- RIGHT CARD: PDF PLAN TERMS & RULES (50% WIDTH / 1 ROW RIGHT SIDE) -->
        <div class="w-full lg:w-1/2 bg-panel p-5 sm:p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-4">
            <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-amber-400 font-bold">
                    ⚖️
                </div>
                <div>
                    <h4 class="text-sm font-black text-white uppercase">Withdrawal Rules</h4>
                    <p class="text-[11px] text-neutral-400">PDF Slide 20 Terms & Conditions</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs text-neutral-300">
                <li class="flex items-start gap-2">
                    <span class="text-amber-400 font-black">1.</span>
                    <span><strong>Minimum Withdrawal:</strong> $10.00.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-400 font-black">2.</span>
                    <span><strong>Payment Currency:</strong> USDT (BEP20 Network).</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-400 font-black">3.</span>
                    <span><strong>Deduction Fee:</strong> 10% Admin Service Deduction.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-400 font-black">4.</span>
                    <span><strong>Timing:</strong> 24x7 Instant System Processing.</span>
                </li>
            </ul>

            <div class="p-4 rounded-2xl bg-black/40 border border-amber-500/20 text-[11px] text-neutral-400 leading-relaxed">
                <strong class="text-amber-300 block mb-1">Notice:</strong>
                Withdrawal requests are processed securely after admin verification. Once approved, net funds will arrive in your wallet address.
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('withdrawAmount');
    const previewReq = document.getElementById('previewRequested');
    const previewDed = document.getElementById('previewDeduction');
    const previewNet = document.getElementById('previewNet');

    function updateCalculations() {
        const val = parseFloat(input.value) || 0;
        const ded = (val * 10) / 100;
        const net = val - ded;

        previewReq.textContent = '$' + val.toFixed(2);
        previewDed.textContent = '-$' + ded.toFixed(2);
        previewNet.textContent = '$' + (net > 0 ? net.toFixed(2) : '0.00');
    }

    input.addEventListener('input', updateCalculations);
});
</script>
@endsection
