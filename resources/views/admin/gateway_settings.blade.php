@extends('admin.layouts.app')

@section('content')
    <div class="w-full space-y-6">

        <!-- Top Header Banner -->
        <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="pdf-num-badge">GW</span>
                    <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX ADMIN CONTROL</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading uppercase">PAYMENT GATEWAY CONFIGURATION</h1>
                <p class="text-xs text-neutral-300 mt-1">Manage iPaymentWallet API Key & Live USDT Payment Engine</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-3 rounded-xl bg-black/80 border border-emerald-500/60 text-emerald-300 text-xs font-bold font-mono flex items-center gap-2 shadow-xl shrink-0">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span>Current Mode: 
                        <strong class="text-emerald-400 text-sm font-black uppercase tracking-wider">
                            LIVE PRODUCTION API
                        </strong>
                    </span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 text-xs font-bold flex items-center gap-2 shadow-lg">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 shrink-0"></i> 
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-500/20 border border-rose-500/50 text-rose-300 text-xs font-bold space-y-1 shadow-lg">
                <div class="flex items-center gap-2 text-rose-400">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span>Validation Error:</span>
                </div>
                <ul class="list-disc list-inside pl-6 space-y-0.5 text-rose-200 text-[11px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- LEFT CARD: Gateway Credentials Form -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6 flex flex-col justify-between">
                <div class="space-y-5">
                    <div class="flex items-center gap-3 border-b border-amber-500/20 pb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-base flex items-center justify-center shadow-md shrink-0">
                            ⚙️
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white font-heading tracking-wide uppercase">GATEWAY API SETTINGS</h3>
                            <p class="text-xs text-neutral-400">Manage iPaymentWallet Live API Key</p>
                        </div>
                    </div>

                    <!-- Live Gateway Status Indicator (Testing Mode Hidden) -->
                    <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-950/60 via-black to-emerald-950/60 border-2 border-emerald-500/50 space-y-2 shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <i data-lucide="globe" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                                <span class="font-black text-xs uppercase text-emerald-300 tracking-wider">LIVE PRODUCTION GATEWAY</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-500/60 text-emerald-400 text-[10px] font-black tracking-wider uppercase flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                ACTIVE
                            </span>
                        </div>
                        <p class="text-[11px] text-neutral-300 leading-relaxed font-medium">
                            System executes real-time HTTP checkout sessions directly via <strong class="text-amber-300">iPaymentWallet API</strong> on Binance Smart Chain (BEP20).
                        </p>
                    </div>

                    <form action="{{ route('admin.gateway-settings.update') }}" method="POST" class="space-y-5" id="gatewaySettingForm">
                        @csrf
                        @method('PUT')

                        <!-- Hidden mode set strictly to live -->
                        <input type="hidden" name="mode" value="live">

                        <!-- API Key Input Field -->
                        <div class="space-y-2">
                            <label class="text-xs font-black text-amber-400 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="key" class="w-4 h-4 text-amber-400"></i>
                                <span>Gateway API Key (iPaymentWallet Key) *</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="api_key" value="{{ old('api_key', $settings['api_key'] ?? '') }}" placeholder="Enter Gateway API Key (pk_...)" class="w-full px-4 py-3.5 rounded-xl bg-black/80 border-2 border-amber-500/40 text-amber-300 font-mono text-xs focus:outline-none focus:border-amber-400 shadow-inner tracking-wider" required>
                            </div>
                            <p class="text-[10px] text-neutral-400 leading-normal">
                                Required for generating live USDT deposit addresses and checking instant confirmation statuses.
                            </p>
                        </div>
                    </form>
                </div>

                <div class="pt-4 border-t border-amber-500/20">
                    <button type="submit" form="gatewaySettingForm" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-yellow-400 text-black font-black text-xs uppercase tracking-wider shadow-xl hover:scale-[1.01] transition flex items-center justify-center gap-2 border border-yellow-200 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4 text-black font-black"></i> Save Gateway Settings
                    </button>
                </div>
            </div>

            <!-- RIGHT CARD: Operational Guide & Security Info -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-6 flex flex-col justify-between">
                <div class="space-y-5">
                    <div class="flex items-center gap-3 border-b border-amber-500/20 pb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-base flex items-center justify-center shadow-md shrink-0">
                            📖
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white font-heading tracking-wide uppercase">LIVE GATEWAY OPERATIONAL GUIDE</h3>
                            <p class="text-xs text-neutral-400">Production USDT payment engine workflow</p>
                        </div>
                    </div>

                    <div class="p-4.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 space-y-2.5 text-xs text-neutral-300 shadow-lg">
                        <div class="flex items-center gap-2 border-b border-emerald-500/20 pb-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            <span class="font-black text-emerald-400 uppercase tracking-wider">
                                🌐 LIVE PRODUCTION INTEGRATION:
                            </span>
                        </div>
                        <ul class="list-disc list-inside space-y-2 text-neutral-300 leading-relaxed text-[11px]">
                            <li>System communicates directly with <strong class="text-emerald-400 font-mono">https://ipaymentwallet.com/api</strong>.</li>
                            <li>Deposit checkouts generate dynamic Binance Smart Chain (BEP20) USDT wallet addresses.</li>
                            <li>Real-time automated polling confirms user transactions on the blockchain before updating member deposit balances.</li>
                        </ul>
                    </div>

                    <div class="p-4.5 rounded-xl bg-amber-500/10 border border-amber-500/30 space-y-2.5 text-xs text-neutral-300 shadow-lg">
                        <div class="flex items-center gap-2 border-b border-amber-500/20 pb-2">
                            <i data-lucide="lock" class="w-4 h-4 text-amber-400"></i>
                            <span class="font-black text-amber-400 uppercase tracking-wider">
                                🔑 API KEY SECURITY & MANAGEMENT:
                            </span>
                        </div>
                        <ul class="list-disc list-inside space-y-2 text-neutral-300 leading-relaxed text-[11px]">
                            <li>Ensure your **iPaymentWallet API Key** is active and valid.</li>
                            <li>Changes saved in this panel apply immediately across all user deposit transactions.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

