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

    <div class="w-full space-y-6">

        <!-- Top Header Banner -->
        <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="pdf-num-badge">AF</span>
                    <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX MEMBER
                        PORTAL</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading">ADD FUND / DEPOSIT WALLET</h1>
                <p class="text-xs text-neutral-300 mt-1">Deposit USDT (BEP20) into your Deposit Wallet to purchase NextGen
                    Forex Investment Packages.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('user.deposits.history') }}"
                    class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center gap-2 shrink-0">
                    <i data-lucide="clock" class="w-4 h-4 text-black"></i> View Deposit History
                </a>
                <div
                    class="px-5 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-lg shrink-0">
                    <i data-lucide="wallet" class="w-4 h-4 text-amber-400"></i>
                    <span>Deposit Wallet: <strong
                            class="text-emerald-400 text-sm font-black">${{ number_format($user->deposit_wallet, 2) }}</strong></span>
                </div>
            </div>
            </div>

        @if(session('success'))
            <div
                class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 text-xs font-bold flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                class="p-4 rounded-xl bg-rose-500/20 border border-rose-500/50 text-rose-300 text-xs font-bold flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Deposit Details & Form Split (FORCE BOTH CARDS SIDE-BY-SIDE IN 1 ROW via .grid-2-cards) -->
        <div class="grid grid-cols-1 grid-2-cards gap-6">

            <!-- LEFT CARD: Official Wallet Address & QR -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5 flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                            🪙
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white font-heading">USDT (BEP20) OFFICIAL WALLET</h3>
                            <p class="text-xs text-neutral-400">Send only USDT on Binance Smart Chain (BEP20) Network</p>
                        </div>
                    </div>

                    <div
                        class="flex flex-col items-center justify-center p-5 bg-bg rounded-2xl border border-amber-500/30 text-center space-y-4">
                        <div class="p-2.5 bg-white rounded-2xl shadow-xl border-4 border-amber-400">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $usdtWalletAddress }}"
                                alt="USDT BEP20 Deposit QR" class="w-40 h-40 rounded-lg">
                        </div>

                        <div class="w-full space-y-1">
                            <span class="text-[11px] font-extrabold text-amber-400 uppercase tracking-wider block">OFFICIAL USDT (BEP20)
                                ADDRESS</span>
                            <div
                                class="p-3 rounded-xl bg-black border border-amber-500/40 text-xs font-mono text-amber-300 break-all flex items-center justify-between gap-2 shadow-inner">
                                <span id="usdtAddressText">{{ $usdtWalletAddress }}</span>
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $usdtWalletAddress }}'); showToast('Copied!', 'Wallet address copied.', 'success');"
                                    class="px-3 py-1.5 rounded-lg bg-amber-500 text-black font-black text-xs uppercase hover:bg-amber-400 transition shrink-0 shadow">
                                    Copy
                                </button>
                            </div>
                        </div>
                        </div>
                        </div>

                <div
                    class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-xs text-neutral-300 space-y-1 leading-relaxed mt-2">
                    <p class="font-bold text-amber-300">📌 Deposit Rules & Instructions (PDF Terms Page 20):</p>
                    <ul class="list-disc list-inside space-y-1 text-neutral-300">
                        <li>Minimum deposit amount is <strong class="text-emerald-400">$10.00 USDT</strong>.</li>
                        <li>Deposits are instantly credited 24/7 to your Deposit Wallet.</li>
                        <li>Enter your exact transaction hash (Txn Hash) after sending payment.</li>
                    </ul>
                </div>
                </div>

            <!-- RIGHT CARD: Submit Deposit Form -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5 flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                            📝
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white font-heading">SUBMIT DEPOSIT PAYMENT</h3>
                            <p class="text-xs text-neutral-400">Fill in transaction details after completing your transfer</p>
                        </div>
                    </div>

                    <form action="{{ route('user.deposits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4"
                        id="depositSubmitForm"
                        onsubmit="return confirm('Are you sure you want to submit this deposit? Funds will be instantly credited to your Deposit Wallet!');">
                        @csrf
                        <input type="hidden" name="payment_gateway" value="USDT (BEP20)">

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Deposit Amount ($ USDT)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-amber-400 font-bold">$</span>
                                <input type="number" step="0.01" min="10" name="amount" value="{{ old('amount', 100) }}" placeholder="100.00"
                                    class="w-full pl-8 pr-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-mono font-bold text-xs focus:outline-none focus:border-amber-400"
                                    required>
                            </div>
                            <p class="text-[11px] text-neutral-400">Minimum Deposit: $10.00</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Transaction Hash / TXID</label>
                            <input type="text" name="txn_hash" value="{{ old('txn_hash') }}" placeholder="e.g. 0x3a4b...8f9c"
                                class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white font-mono text-xs focus:outline-none focus:border-amber-400"
                                required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-amber-400 uppercase tracking-wider">Payment Proof Screenshot (Optional)</label>
                            <input type="file" name="proof_image" accept="image/*"
                                class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-white text-xs focus:outline-none focus:border-amber-400">
                        </div>
                        </form>
                        </div>

                <div class="pt-4 border-t border-amber-500/20">
                    <button type="submit" form="depositSubmitForm"
                        class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-[1.01] transition flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-4 h-4 text-black"></i> Submit Deposit
                        </button>
                        </div>
                        </div>
        </div>
    </div>
@endsection
