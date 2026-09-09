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
                <p class="text-xs text-neutral-300 mt-1">Manage iPaymentWallet API Key & Toggle Testing / Live Production Mode</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-lg shrink-0">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>Current Mode: 
                        <strong class="{{ ($settings['mode'] ?? 'testing') === 'live' ? 'text-rose-400' : 'text-emerald-400' }} text-sm font-black uppercase">
                            {{ ($settings['mode'] ?? 'testing') === 'live' ? 'LIVE (Real API)' : 'TESTING (Simulated Direct)' }}
                        </strong>
                    </span>
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

            <!-- LEFT CARD: Gateway Credentials & Mode Form -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5 flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                            ⚙️
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white font-heading">GATEWAY API & MODE SETTINGS</h3>
                            <p class="text-xs text-neutral-400">Configure API Key and environment mode</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.gateway-settings.update') }}" method="POST" class="space-y-5" id="gatewaySettingForm">
                        @csrf
                        @method('PUT')

                        <!-- Gateway Environment Mode Toggle -->
                        <div class="space-y-2 p-4 rounded-xl bg-black/80 border-2 border-amber-500/40">
                            <label class="text-xs font-black text-amber-400 uppercase tracking-wider block">
                                🔌 Select Gateway Mode *
                            </label>
                            
                            <div class="grid grid-cols-2 gap-3 pt-1">
                                <label class="flex flex-col p-3.5 rounded-xl border-2 cursor-pointer transition {{ ($settings['mode'] ?? 'testing') === 'testing' ? 'bg-emerald-500/10 border-emerald-500 text-white' : 'bg-black/60 border-neutral-700 text-neutral-400' }}">
                                    <div class="flex items-center gap-2 mb-1">
                                        <input type="radio" name="mode" value="testing" {{ ($settings['mode'] ?? 'testing') === 'testing' ? 'checked' : '' }} class="accent-emerald-400">
                                        <span class="font-black text-xs uppercase text-emerald-400">⚡ TESTING MODE</span>
                                    </div>
                                    <span class="text-[10px] text-neutral-300 leading-tight">Direct approval without external API HTTP calls. Ideal for instant testing & staging.</span>
                                </label>

                                <label class="flex flex-col p-3.5 rounded-xl border-2 cursor-pointer transition {{ ($settings['mode'] ?? 'testing') === 'live' ? 'bg-rose-500/10 border-rose-500 text-white' : 'bg-black/60 border-neutral-700 text-neutral-400' }}">
                                    <div class="flex items-center gap-2 mb-1">
                                        <input type="radio" name="mode" value="live" {{ ($settings['mode'] ?? 'testing') === 'live' ? 'checked' : '' }} class="accent-rose-400">
                                        <span class="font-black text-xs uppercase text-rose-400">🌐 LIVE PRODUCTION</span>
                                    </div>
                                    <span class="text-[10px] text-neutral-300 leading-tight">Sends real HTTP requests to iPaymentWallet API server for production payments.</span>
                                </label>
                            </div>
                        </div>

                        <!-- API Key Input Field -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-amber-400 uppercase tracking-wider block">
                                🔑 Gateway API Key (iPaymentWallet Key) *
                            </label>
                            <input type="text" name="api_key" value="{{ old('api_key', $settings['api_key'] ?? '') }}" placeholder="Enter Gateway API Key (pk_...)" class="w-full px-4 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 font-mono text-xs focus:outline-none focus:border-amber-400" required>
                            <p class="text-[10px] text-neutral-400">This key is used for live payment checkout sessions and status verification.</p>
                        </div>
                    </form>
                </div>

                <div class="pt-4 border-t border-amber-500/20">
                    <button type="submit" form="gatewaySettingForm" class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider shadow-lg hover:scale-[1.01] transition flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4 text-black"></i> Save Gateway Settings
                    </button>
                </div>
            </div>

            <!-- RIGHT CARD: Mode Explanation & Rule Instructions -->
            <div class="bg-panel p-6 shadow-2xl rounded-2xl border border-amber-500/30 space-y-5 flex flex-col justify-between">
                <div class="space-y-5">
                    <div class="flex items-center gap-3 border-b border-amber-500/20 pb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-black font-black text-sm flex items-center justify-center shadow-md shrink-0">
                            📖
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white font-heading">GATEWAY OPERATIONAL GUIDE</h3>
                            <p class="text-xs text-neutral-400">How Testing Mode vs Live Production Mode works</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 space-y-2 text-xs text-neutral-300">
                        <span class="font-black text-emerald-400 uppercase tracking-wider block border-b border-emerald-500/20 pb-1">
                            ⚡ TESTING MODE (Direct Addition):
                        </span>
                        <ul class="list-disc list-inside space-y-1.5 text-neutral-300 leading-relaxed text-[11px]">
                            <li>System **skips external API HTTP calls** (`ipaymentwallet.com`).</li>
                            <li>Deposit session generates instantly using system USDT wallet address.</li>
                            <li>Live status check **auto-approves & credits deposit wallet** immediately for testing.</li>
                            <li>Perfect for testing user deposit flow, package purchase, and internal logic without spending real USDT.</li>
                        </ul>
                    </div>

                    <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 space-y-2 text-xs text-neutral-300">
                        <span class="font-black text-rose-400 uppercase tracking-wider block border-b border-rose-500/20 pb-1">
                            🌐 LIVE PRODUCTION MODE:
                        </span>
                        <ul class="list-disc list-inside space-y-1.5 text-neutral-300 leading-relaxed text-[11px]">
                            <li>System sends **real HTTP POST requests** to `https://ipaymentwallet.com/api`.</li>
                            <li>Uses the configured **iPaymentWallet API Key**.</li>
                            <li>Requires genuine Binance Smart Chain (BEP20) USDT transactions to verify and credit user wallets.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
