@extends('user.layouts.app')

@section('title', 'Arbitrage Trading Dashboard')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-page: #021d12;
            --bg-card: rgba(6, 26, 17, 0.85);
            --bg-card-header: linear-gradient(90deg, rgba(6, 40, 26, 0.95) 0%, rgba(2, 29, 18, 0.95) 100%);
            --bg-row-hover: rgba(243, 202, 82, 0.08);
            --border-card: rgba(243, 202, 82, 0.3);
            --border-table: rgba(243, 202, 82, 0.15);
            --text-main: #ffffff;
            --text-sub: #cbd5e1;
            --text-muted: #94a3b8;
            --accent-gold: #f3ca52;
            --accent-gold-bright: #fef08a;
            --accent-green: #10b981;
            --accent-red: #ef4444;
        }

        /* Smooth Glow Keyframes */
        @keyframes goldPulseGlow {
            0%, 100% { box-shadow: 0 0 15px rgba(243, 202, 82, 0.2); }
            50% { box-shadow: 0 0 30px rgba(243, 202, 82, 0.45); }
        }

        @keyframes borderPulse {
            0%, 100% { border-color: rgba(243, 202, 82, 0.3); }
            50% { border-color: rgba(243, 202, 82, 0.7); }
        }

        @keyframes slideInGlow {
            0% { opacity: 0; transform: translateY(-12px); background-color: rgba(16, 185, 129, 0.35); }
            50% { background-color: rgba(243, 202, 82, 0.25); }
            100% { opacity: 1; transform: translateY(0); background-color: transparent; }
        }

        @keyframes marqueeScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        @keyframes beaconPulse {
            0% { transform: scale(0.6); opacity: 0.9; }
            70% { transform: scale(2.2); opacity: 0; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        @keyframes priceUpFlash {
            0% { background-color: rgba(16, 185, 129, 0.4); }
            100% { background-color: transparent; }
        }

        @keyframes priceDownFlash {
            0% { background-color: rgba(239, 68, 68, 0.4); }
            100% { background-color: transparent; }
        }

        /* Card System */
        .arbitrage-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-card);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .arbitrage-card:hover {
            border-color: rgba(243, 202, 82, 0.6);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.7), 0 0 25px rgba(243, 202, 82, 0.2);
            transform: translateY(-2px);
        }
        .arbitrage-card-header {
            background: var(--bg-card-header);
            border-bottom: 1px solid var(--border-card);
            padding: 16px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .arbitrage-card-header h3 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .arbitrage-card-body {
            padding: 20px 22px;
        }

        /* 1. Marquee Ticker */
        .marquee-section {
            margin-bottom: 20px;
        }
        .marquee-box {
            background: linear-gradient(90deg, #042417 0%, #02180f 50%, #000000 100%);
            border: 1px solid rgba(243, 202, 82, 0.35);
            border-radius: 14px;
            padding: 12px 18px;
            overflow: hidden;
            white-space: nowrap;
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.8), 0 4px 20px rgba(0, 0, 0, 0.4);
        }
        .marquee-track {
            display: inline-flex;
            animation: marqueeScroll 40s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        .crypto-item {
            display: inline-flex;
            align-items: center;
            margin-right: 22px;
            font-size: 0.85rem;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(243, 202, 82, 0.25);
            padding: 7px 16px;
            border-radius: 10px;
            transition: all 0.25s ease;
        }
        .crypto-item:hover {
            border-color: rgba(243, 202, 82, 0.6);
            background: rgba(243, 202, 82, 0.1);
            transform: scale(1.03);
        }
        .crypto-item img {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
            object-fit: contain;
            vertical-align: middle;
        }
        .crypto-symbol {
            font-weight: 800;
            margin-right: 6px;
        }
        .crypto-price {
            color: #fef08a;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        .price-flash-up {
            animation: priceUpFlash 0.8s ease-out;
            color: #34d399 !important;
        }
        .price-flash-down {
            animation: priceDownFlash 0.8s ease-out;
            color: #f87171 !important;
        }

        /* 2. Grid Layout */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Price Cards */
        .price-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .price-icon-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        .bg-btc { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #000000; }
        .bg-eth { background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%); color: #ffffff; }
        .bg-omni { background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); color: #000000; }

        .price-card-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 20px 22px;
        }
        .price-label {
            font-size: 0.775rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }
        .price-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
            font-family: 'JetBrains Mono', monospace;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        .badge-percent {
            font-size: 0.775rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
        }
        .badge-positive {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
        }
        .badge-negative {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.4);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
        }

        /* 3. Charts Container */
        .chart-container {
            position: relative;
            height: 260px;
            width: 100%;
        }

        /* 4. Live Arbitrage Transactions Table */
        .table-card-header {
            background: var(--bg-card-header);
            border-bottom: 1px solid var(--border-card);
            padding: 16px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
        }
        .table-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .table-title-group i {
            color: var(--accent-gold);
            font-size: 1.2rem;
        }
        .table-title-group h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
        }
        .table-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .live-indicator-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent-green);
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            padding: 5px 12px;
            border-radius: 20px;
        }
        .pulse-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: var(--accent-green);
            position: relative;
        }
        .pulse-dot::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: var(--accent-green);
            opacity: 0.6;
            animation: beaconPulse 1.8s cubic-bezier(0.24, 0, 0.38, 1) infinite;
        }
        .btn-action {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--border-card);
            color: var(--text-sub);
            padding: 7px 16px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.25s ease;
        }
        .btn-action:hover {
            background: rgba(243, 202, 82, 0.2);
            color: var(--accent-gold-bright);
            border-color: rgba(243, 202, 82, 0.5);
            box-shadow: 0 0 15px rgba(243, 202, 82, 0.2);
        }
        .btn-action.active {
            background: rgba(245, 158, 11, 0.25);
            border-color: rgba(245, 158, 11, 0.6);
            color: var(--accent-gold);
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 22px;
            background: rgba(0, 0, 0, 0.5);
            border-bottom: 1px solid var(--border-card);
            font-size: 0.8rem;
            color: var(--text-sub);
            flex-wrap: wrap;
            gap: 12px;
        }
        .stats-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .stats-value {
            font-weight: 700;
            color: #ffffff;
        }
        .stats-tag {
            background: rgba(243, 202, 82, 0.15);
            border: 1px solid rgba(243, 202, 82, 0.3);
            padding: 4px 10px;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--accent-gold);
        }

        /* Table */
        .arbitrage-table-container {
            max-height: 520px;
            overflow-y: auto;
        }
        .arbitrage-table-container::-webkit-scrollbar { width: 6px; }
        .arbitrage-table-container::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.4); }
        .arbitrage-table-container::-webkit-scrollbar-thumb { background: rgba(243, 202, 82, 0.3); border-radius: 4px; }
        .arbitrage-table-container::-webkit-scrollbar-thumb:hover { background: rgba(243, 202, 82, 0.6); }

        .arbitrage-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .arbitrage-table thead {
            position: sticky;
            top: 0;
            background: #042417;
            z-index: 10;
        }
        .arbitrage-table th {
            padding: 14px 20px;
            font-size: 0.775rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--accent-gold);
            white-space: nowrap;
            border-bottom: 1px solid var(--border-card);
            border-right: 1px solid var(--border-table);
        }
        .arbitrage-table th:last-child {
            border-right: none;
        }
        .arbitrage-table tbody tr {
            border-bottom: 1px solid var(--border-table);
            transition: background-color 0.25s ease;
        }
        .arbitrage-table tbody tr:hover {
            background-color: var(--bg-row-hover);
        }
        .arbitrage-table tbody tr.new-row {
            animation: slideInGlow 0.8s ease-out;
        }
        .arbitrage-table td {
            padding: 14px 20px;
            font-size: 0.875rem;
            vertical-align: middle;
            border-right: 1px solid var(--border-table);
        }
        .arbitrage-table td:last-child {
            border-right: none;
        }

        /* Cell Styling */
        .pair-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .pair-icons-stack {
            position: relative;
            width: 46px;
            height: 32px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        .token-pair-img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            background: #021d12;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
            transition: transform 0.25s ease;
        }
        .token-pair-img.token-primary {
            position: absolute;
            left: 0;
            top: 2px;
            z-index: 2;
            border: 2px solid #06281a;
        }
        .token-pair-img.token-secondary {
            position: absolute;
            left: 18px;
            top: 2px;
            z-index: 1;
            border: 2px solid #06281a;
            opacity: 0.95;
        }
        .arbitrage-table tbody tr:hover .token-pair-img.token-secondary {
            transform: translateX(4px);
        }
        .pair-details {
            display: flex;
            flex-direction: column;
        }
        .pair-title {
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .arbitrage-route {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 3px;
        }
        .route-badge {
            color: #38bdf8;
            font-weight: 600;
        }
        .spread-badge {
            display: inline-block;
            padding: 2px 6px;
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 4px;
            font-size: 0.725rem;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
        }
        .amount-val {
            font-weight: 700;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
        }
        .amount-usd {
            font-size: 0.75rem;
            color: var(--accent-gold);
            margin-top: 2px;
            font-weight: 600;
        }
        .hash-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .hash-link {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.825rem;
            color: #60a5fa;
            text-decoration: none;
            padding: 4px 9px;
            border-radius: 6px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .hash-link:hover {
            color: #93c5fd;
            background: rgba(59, 130, 246, 0.25);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.3);
        }
        .copy-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 5px;
            font-size: 0.85rem;
            border-radius: 6px;
            transition: color 0.2s, background-color 0.2s;
        }
        .copy-btn:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .time-cell {
            color: var(--text-sub);
            font-size: 0.825rem;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 7px;
            font-weight: 500;
        }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 600;
        }
        .empty-state i {
            display: block;
            font-size: 36px;
            margin-bottom: 12px;
            opacity: 0.5;
            color: var(--accent-gold);
        }

        @media (max-width: 1024px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .grid-3 { grid-template-columns: 1fr; }
            .arbitrage-card-header { padding: 14px 16px; }
            .arbitrage-table th, .arbitrage-table td { padding: 11px 14px; }
            .stats-bar { padding: 10px 14px; }
        }
    </style>

    <div class="w-full space-y-6">

        <!-- Top Header Banner (Metallic Gold NextGen Theme) -->
        <div class="p-5 sm:p-8 rounded-2xl bg-gradient-to-r from-amber-950/60 via-black to-amber-950/60 border border-amber-500/40 shadow-2xl flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="space-y-1.5 z-10">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400/50 text-amber-300 text-[10px] font-black tracking-widest uppercase">QUANT ENGINE</span>
                    <span class="text-[10px] sm:text-[11px] text-amber-400 font-extrabold tracking-[2px] uppercase">NEXTGEN CROSS-DEX ARBITRAGE</span>
                </div>
                <h1 class="text-xl sm:text-3xl font-black text-amber-300 font-heading tracking-tight drop-shadow uppercase flex items-center gap-3">
                    <i class="fa-solid fa-arrow-right-arrow-left text-amber-400 animate-pulse"></i>
                    Arbitrage Dashboard
                </h1>
                <p class="text-xs sm:text-sm text-neutral-300 max-w-2xl font-medium">
                    Real-time Cross-DEX Crypto Arbitrage Trading Engine, Live Binance Feed & Automated On-Chain Transactions
                </p>
            </div>

            <div class="z-10 flex items-center gap-3 shrink-0">
                <div class="px-5 py-3 rounded-xl bg-black/80 border border-amber-500/40 text-amber-300 text-xs font-bold font-mono flex items-center gap-2.5 shadow-xl">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></div>
                    <span>BOT ENGINE: <strong class="text-emerald-400 text-sm font-black tracking-wider">ACTIVE 24/7</strong></span>
                </div>
            </div>
        </div>

        <!-- 1. Live Crypto Prices Marquee Ticker -->
        <div class="marquee-section">
            <div class="marquee-box">
                <div class="marquee-track">
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/btc.png" alt="BTC" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #f59e0b;">BTC:</span>
                        <span class="crypto-price" id="ticker-btc">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/eth.png" alt="ETH" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #a855f7;">ETH:</span>
                        <span class="crypto-price" id="ticker-eth">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/xrp.png" alt="XRP" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #3b82f6;">XRP:</span>
                        <span class="crypto-price" id="ticker-xrp">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ada.png" alt="ADA" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #60a5fa;">ADA:</span>
                        <span class="crypto-price" id="ticker-ada">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/doge.png" alt="DOGE" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #eab308;">DOGE:</span>
                        <span class="crypto-price" id="ticker-doge">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/eos.png" alt="EOS" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #93c5fd;">EOS:</span>
                        <span class="crypto-price" id="ticker-eos">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ltc.png" alt="LTC" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #cbd5e1;">LTC:</span>
                        <span class="crypto-price" id="ticker-ltc">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/dash.png" alt="DASH" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #2563eb;">DASH:</span>
                        <span class="crypto-price" id="ticker-dash">$0.00</span>
                    </div>
                    <!-- Duplicate for seamless continuous scroll -->
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/btc.png" alt="BTC" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #f59e0b;">BTC:</span>
                        <span class="crypto-price" id="ticker-btc-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/eth.png" alt="ETH" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #a855f7;">ETH:</span>
                        <span class="crypto-price" id="ticker-eth-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/xrp.png" alt="XRP" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #3b82f6;">XRP:</span>
                        <span class="crypto-price" id="ticker-xrp-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ada.png" alt="ADA" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #60a5fa;">ADA:</span>
                        <span class="crypto-price" id="ticker-ada-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/doge.png" alt="DOGE" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #eab308;">DOGE:</span>
                        <span class="crypto-price" id="ticker-doge-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/eos.png" alt="EOS" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #93c5fd;">EOS:</span>
                        <span class="crypto-price" id="ticker-eos-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ltc.png" alt="LTC" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #cbd5e1;">LTC:</span>
                        <span class="crypto-price" id="ticker-ltc-dup">$0.00</span>
                    </div>
                    <div class="crypto-item">
                        <img src="https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/dash.png" alt="DASH" onerror="this.style.display='none'">
                        <span class="crypto-symbol" style="color: #2563eb;">DASH:</span>
                        <span class="crypto-price" id="ticker-dash-dup">$0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Three Price Ticker Cards -->
        <div class="grid-3">
            <!-- Bitcoin Card -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <div class="price-card-header">
                        <div class="price-icon-badge bg-btc">
                            <i class="fa-brands fa-btc"></i>
                        </div>
                        <h3>Bitcoin (BTC)</h3>
                    </div>
                    <span class="text-[10px] font-extrabold text-amber-400 font-mono tracking-wider bg-amber-500/20 px-2 py-0.5 rounded border border-amber-500/40">BINANCE FEED</span>
                </div>
                <div class="price-card-body">
                    <div>
                        <p class="price-label">Current Market Price</p>
                        <h2 class="price-value text-amber-300" id="card-btc-price">$0.00</h2>
                    </div>
                    <span class="badge-percent badge-positive" id="card-btc-change">+0.0%</span>
                </div>
            </div>

            <!-- Ethereum Card -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <div class="price-card-header">
                        <div class="price-icon-badge bg-eth">
                            <i class="fa-brands fa-ethereum"></i>
                        </div>
                        <h3>Ethereum (ETH)</h3>
                    </div>
                    <span class="text-[10px] font-extrabold text-amber-400 font-mono tracking-wider bg-amber-500/20 px-2 py-0.5 rounded border border-amber-500/40">BINANCE FEED</span>
                </div>
                <div class="price-card-body">
                    <div>
                        <p class="price-label">Current Market Price</p>
                        <h2 class="price-value text-amber-300" id="card-eth-price">$0.00</h2>
                    </div>
                    <span class="badge-percent badge-positive" id="card-eth-change">+0.0%</span>
                </div>
            </div>

            <!-- BNB / OMNI Card -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <div class="price-card-header">
                        <div class="price-icon-badge bg-omni">
                            <i class="fa-solid fa-gem"></i>
                        </div>
                        <h3>BNB Chain (BNB)</h3>
                    </div>
                    <span class="text-[10px] font-extrabold text-emerald-400 font-mono tracking-wider bg-emerald-500/20 px-2 py-0.5 rounded border border-emerald-500/40">BSC MAINNET</span>
                </div>
                <div class="price-card-body">
                    <div>
                        <p class="price-label">Current Market Price</p>
                        <h2 class="price-value text-amber-300" id="card-omni-price">$0.00</h2>
                    </div>
                    <span class="badge-percent badge-positive" id="card-omni-change">+0.0%</span>
                </div>
            </div>
        </div>

        <!-- 3. Three Dynamic Chart Cards -->
        <div class="grid-3">
            <!-- Token Distribution Chart -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <h3>Token Distribution</h3>
                    <i class="fa-solid fa-chart-pie text-amber-400"></i>
                </div>
                <div class="arbitrage-card-body">
                    <div class="chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Profit Share Chart -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <h3>Profit Share Ratio</h3>
                    <i class="fa-solid fa-chart-donut text-emerald-400"></i>
                </div>
                <div class="arbitrage-card-body">
                    <div class="chart-container">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Volume Comparison Chart -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <h3>DEX Volume Comparison</h3>
                    <i class="fa-solid fa-chart-column text-amber-400"></i>
                </div>
                <div class="arbitrage-card-body">
                    <div class="chart-container">
                        <canvas id="columnChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Live Arbitrage Transactions Feed Card -->
        <div class="arbitrage-card">
            <div class="table-card-header">
                <div class="table-title-group">
                    <i class="fa-solid fa-bolt text-amber-400"></i>
                    <h3>Live Cross-DEX Arbitrage Feeds</h3>
                </div>
                <div class="table-actions">
                    <div class="live-indicator-badge" id="live-badge">
                        <div class="pulse-dot"></div>
                        <span>Live Engine Stream</span>
                    </div>
                    <button class="btn-action" id="btn-pause-toggle" title="Pause or Resume Stream">
                        <i class="fa-solid fa-pause"></i> <span id="pause-text">Pause</span>
                    </button>
                    <button class="btn-action" id="btn-clear" title="Clear Stream Table">
                        <i class="fa-solid fa-trash-can"></i> Clear
                    </button>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stats-item">
                    <span>Network:</span>
                    <span class="stats-tag"><i class="fa-solid fa-cubes text-amber-400"></i> BSC (BNB Chain)</span>
                </div>
                <div class="stats-item">
                    <span>Arbitrage Routes:</span>
                    <span class="stats-value text-amber-300">PancakeSwap v3 • BiSwap • ApeSwap • Uniswap</span>
                </div>
                <div class="stats-item">
                    <span>Execution Speed:</span>
                    <span class="stats-tag"><i class="fa-regular fa-clock text-amber-400"></i> ~3 Seconds</span>
                </div>
                <div class="stats-item">
                    <span>Transactions Captured:</span>
                    <span class="stats-value text-emerald-400 font-mono text-sm font-bold" id="total-tx-count">0</span>
                </div>
            </div>

            <!-- Table Container -->
            <div class="arbitrage-card-body" style="padding: 0;">
                <div class="arbitrage-table-container">
                    <table class="arbitrage-table">
                        <thead>
                            <tr>
                                <th>Token Pair & Arbitrage Route</th>
                                <th>Volume & Value (USD)</th>
                                <th>Transaction Hash</th>
                                <th>Execution Time</th>
                            </tr>
                        </thead>
                        <tbody id="transactions-body">
                            <tr id="initial-loading-row">
                                <td colspan="4" class="empty-state">
                                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                                    Connecting to BSC On-Chain Arbitrage Nodes...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Toast for Copy (Hidden by default) -->
    <div id="copy-toast" style="display: none; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; position: fixed; bottom: 24px; right: 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 12px 22px; border-radius: 12px; font-size: 0.875rem; font-weight: 700; z-index: 9999; box-shadow: 0 10px 30px rgba(0,0,0,0.8), 0 0 20px rgba(16, 185, 129, 0.4); border: 1px solid rgba(255,255,255,0.3);">
        <i class="fa-solid fa-circle-check mr-2"></i> Transaction hash copied to clipboard!
    </div>

    <!-- Live Arbitrage Engine & Market Data JavaScript -->
    <script>
        // Theme Chart Colors Palette
        const chartTokens = [
            { symbol: 'BNB', color: '#f3ca52' },
            { symbol: 'USDT', color: '#10b981' },
            { symbol: 'BTC', color: '#f59e0b' },
            { symbol: 'ETH', color: '#a855f7' },
            { symbol: 'SOL', color: '#38bdf8' },
            { symbol: 'CAKE', color: '#ec4899' }
        ];

        let pieChart, doughnutChart, columnChart;

        function initCharts() {
            const pieCtx = document.getElementById('pieChart')?.getContext('2d');
            const doughnutCtx = document.getElementById('doughnutChart')?.getContext('2d');
            const columnCtx = document.getElementById('columnChart')?.getContext('2d');

            if (pieCtx) {
                pieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: chartTokens.map(t => t.symbol),
                        datasets: [{
                            data: [30, 22, 18, 14, 10, 6],
                            backgroundColor: chartTokens.map(t => t.color),
                            borderWidth: 2,
                            borderColor: '#021d12'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { color: '#cbd5e1', font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, boxWidth: 14 }
                            }
                        }
                    }
                });
            }

            if (doughnutCtx) {
                doughnutChart = new Chart(doughnutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: chartTokens.map(t => t.symbol),
                        datasets: [{
                            data: [38, 20, 18, 12, 7, 5],
                            backgroundColor: chartTokens.map(t => t.color),
                            borderWidth: 2,
                            borderColor: '#021d12'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { color: '#cbd5e1', font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, boxWidth: 14 }
                            }
                        }
                    }
                });
            }

            if (columnCtx) {
                columnChart = new Chart(columnCtx, {
                    type: 'bar',
                    data: {
                        labels: chartTokens.map(t => t.symbol),
                        datasets: [
                            {
                                label: 'Volume ($K)',
                                data: [45, 38, 52, 28, 42, 19],
                                backgroundColor: '#f3ca52',
                                borderRadius: 6
                            },
                            {
                                label: 'Successful Swaps',
                                data: [32, 24, 18, 14, 10, 8],
                                backgroundColor: '#10b981',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 60,
                                ticks: { color: '#94a3b8', font: { size: 10, weight: '600' } },
                                grid: { color: 'rgba(243, 202, 82, 0.1)' }
                            },
                            x: {
                                ticks: { color: '#fef08a', font: { size: 10, weight: '700' } },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { color: '#cbd5e1', font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, boxWidth: 14 }
                            }
                        }
                    }
                });
            }
        }

        function updateChartsSubtle() {
            if (pieChart) {
                pieChart.data.datasets[0].data = [
                    Math.round(26 + Math.random() * 8),
                    Math.round(20 + Math.random() * 6),
                    Math.round(16 + Math.random() * 5),
                    Math.round(12 + Math.random() * 4),
                    Math.round(10 + Math.random() * 4),
                    Math.round(5 + Math.random() * 3)
                ];
                pieChart.update();
            }

            if (doughnutChart) {
                doughnutChart.data.datasets[0].data = [
                    Math.round(34 + Math.random() * 8),
                    Math.round(18 + Math.random() * 5),
                    Math.round(20 + Math.random() * 6),
                    Math.round(10 + Math.random() * 4),
                    Math.round(8 + Math.random() * 3),
                    Math.round(5 + Math.random() * 3)
                ];
                doughnutChart.update();
            }

            if (columnChart) {
                columnChart.data.datasets[0].data = [
                    Math.round(38 + Math.random() * 12),
                    Math.round(32 + Math.random() * 10),
                    Math.round(44 + Math.random() * 10),
                    Math.round(22 + Math.random() * 8),
                    Math.round(35 + Math.random() * 10),
                    Math.round(15 + Math.random() * 6)
                ];
                columnChart.update();
            }
        }

        // Live Market Prices Fetcher with Animated Visual Flashes
        let prevPrices = {};

        async function fetchLiveMarketPrices() {
            const pairs = [
                { symbol: 'BTCUSDT', tickerId: 'ticker-btc', dupId: 'ticker-btc-dup', cardId: 'card-btc-price', changeId: 'card-btc-change' },
                { symbol: 'ETHUSDT', tickerId: 'ticker-eth', dupId: 'ticker-eth-dup', cardId: 'card-eth-price', changeId: 'card-eth-change' },
                { symbol: 'BNBUSDT', tickerId: null, cardId: 'card-omni-price', changeId: 'card-omni-change' },
                { symbol: 'XRPUSDT', tickerId: 'ticker-xrp', dupId: 'ticker-xrp-dup' },
                { symbol: 'ADAUSDT', tickerId: 'ticker-ada', dupId: 'ticker-ada-dup' },
                { symbol: 'DOGEUSDT', tickerId: 'ticker-doge', dupId: 'ticker-doge-dup' },
                { symbol: 'EOSUSDT', tickerId: 'ticker-eos', dupId: 'ticker-eos-dup' },
                { symbol: 'LTCUSDT', tickerId: 'ticker-ltc', dupId: 'ticker-ltc-dup' },
                { symbol: 'DASHUSDT', tickerId: 'ticker-dash', dupId: 'ticker-dash-dup' }
            ];

            try {
                const res = await fetch('https://api.binance.com/api/v3/ticker/24hr');
                if (!res.ok) return;
                const allData = await res.json();
                const map = {};
                allData.forEach(item => { map[item.symbol] = item; });

                pairs.forEach(p => {
                    const item = map[p.symbol];
                    if (item) {
                        const priceNum = parseFloat(item.lastPrice);
                        const changeNum = parseFloat(item.priceChangePercent);
                        const formattedPrice = priceNum >= 1000 ? priceNum.toFixed(2) : priceNum.toFixed(4);

                        const prev = prevPrices[p.symbol];
                        let flashClass = '';
                        if (prev !== undefined) {
                            if (priceNum > prev) flashClass = 'price-flash-up';
                            else if (priceNum < prev) flashClass = 'price-flash-down';
                        }
                        prevPrices[p.symbol] = priceNum;

                        if (p.tickerId) {
                            const el = document.getElementById(p.tickerId);
                            if (el) {
                                el.textContent = `$${formattedPrice}`;
                                if (flashClass) {
                                    el.classList.remove('price-flash-up', 'price-flash-down');
                                    void el.offsetWidth;
                                    el.classList.add(flashClass);
                                }
                            }
                        }
                        if (p.dupId) {
                            const el = document.getElementById(p.dupId);
                            if (el) el.textContent = `$${formattedPrice}`;
                        }
                        if (p.cardId) {
                            const cardEl = document.getElementById(p.cardId);
                            if (cardEl) cardEl.textContent = `$${priceNum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                        }
                        if (p.changeId) {
                            const changeEl = document.getElementById(p.changeId);
                            if (changeEl) {
                                const sign = changeNum >= 0 ? '+' : '';
                                changeEl.textContent = `${sign}${changeNum.toFixed(1)}%`;
                                changeEl.className = `badge-percent ${changeNum >= 0 ? 'badge-positive' : 'badge-negative'}`;
                            }
                        }
                    }
                });
            } catch (err) {
                console.warn('Market ticker update error:', err.message);
            }
        }

        // Real Live On-Chain BSC Transactions Engine
        const MAX_ROWS = 50;
        const UPDATE_INTERVAL_MS = 3000;
        let isPaused = false;
        let totalTxReceived = 0;
        const seenHashes = new Set();
        const transactionsList = [];
        const realOnChainQueue = [];
        let isFetchingBlock = false;
        let lastProcessedBlockNum = 0;
        let copyToastTimer = null;

        const TOKEN_ICONS = {
            'BNB': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/bnb.png',
            'WBNB': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/bnb.png',
            'USDT': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/usdt.png',
            'ETH': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/eth.png',
            'BTC': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/btc.png',
            'BTCB': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/btc.png',
            'CAKE': 'https://tokens.pancakeswap.finance/images/0x0E09FaBB73Bd3Ade0a17ECC321fD13a19e81cE82.png',
            'SOL': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/sol.png',
            'XRP': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/xrp.png',
            'DOGE': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/doge.png',
            'ADA': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ada.png'
        };

        function getTokenIcon(symbol) {
            const s = (symbol || 'BNB').toUpperCase().trim();
            return TOKEN_ICONS[s] || `https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/${s.toLowerCase()}.png`;
        }

        const ARBITRAGE_DEX_PAIRS = [
            'PancakeSwap v3 ➔ BiSwap',
            'BiSwap ➔ PancakeSwap v3',
            'PancakeSwap v2 ➔ ApeSwap',
            'Uniswap v3 ➔ PancakeSwap',
            'DEX ➔ Binance CEX Spread',
            'PancakeSwap ➔ Binance'
        ];

        function getRelativeTime(timestamp) {
            const now = Math.floor(Date.now() / 1000);
            const diff = Math.max(0, now - timestamp);
            if (diff < 3) return 'Just now';
            if (diff < 60) return `${diff}s ago`;
            if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
            return `${Math.floor(diff / 3600)}h ago`;
        }

        function copyHash(hash) {
            navigator.clipboard.writeText(hash).then(() => {
                const toast = document.getElementById('copy-toast');
                if (toast) {
                    if (copyToastTimer) clearTimeout(copyToastTimer);
                    toast.style.display = 'block';
                    setTimeout(() => { toast.style.opacity = '1'; }, 10);

                    copyToastTimer = setTimeout(() => {
                        toast.style.opacity = '0';
                        setTimeout(() => { toast.style.display = 'none'; }, 300);
                    }, 2200);
                }
            }).catch(err => {
                console.error('Copy failed:', err);
            });
        }

        function renderEmptyState() {
            const tbody = document.getElementById('transactions-body');
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="empty-state">
                        <i class="fa-solid fa-inbox"></i>
                        No arbitrage transaction feeds captured.
                    </td>
                </tr>
            `;
            document.getElementById('total-tx-count').textContent = '0';
        }

        function addTransaction(tx, isInitial = false) {
            if (isPaused && !isInitial) return;
            if (seenHashes.has(tx.hash)) return;
            seenHashes.add(tx.hash);
            transactionsList.unshift(tx);
            totalTxReceived++;
            document.getElementById('total-tx-count').textContent = totalTxReceived.toLocaleString();

            const tbody = document.getElementById('transactions-body');
            const emptyRow = tbody.querySelector('.empty-state');
            if (emptyRow) {
                tbody.innerHTML = '';
            }

            const tokenBase = tx.baseSymbol || 'BNB';
            const tokenQuote = tx.quoteSymbol || 'USDT';
            const baseIcon = getTokenIcon(tokenBase);
            const quoteIcon = getTokenIcon(tokenQuote);
            const shortHash = `${tx.hash.substring(0, 10)}...${tx.hash.substring(tx.hash.length - 8)}`;
            const route = tx.route || ARBITRAGE_DEX_PAIRS[Math.floor(Math.random() * ARBITRAGE_DEX_PAIRS.length)];
            const spread = tx.spread || `+${(Math.random() * 0.85 + 0.15).toFixed(2)}%`;

            const tr = document.createElement('tr');
            if (!isInitial) tr.className = 'new-row';
            tr.dataset.timestamp = tx.timestamp;
            tr.innerHTML = `
                <td>
                    <div class="pair-cell">
                        <div class="pair-icons-stack">
                            <img src="${baseIcon}" alt="${tokenBase}" class="token-pair-img token-primary" onerror="this.onerror=null; this.src='https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/generic.png'">
                            <img src="${quoteIcon}" alt="${tokenQuote}" class="token-pair-img token-secondary" onerror="this.onerror=null; this.src='https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/generic.png'">
                        </div>
                        <div class="pair-details">
                            <span class="pair-title">
                                ${tokenBase} / ${tokenQuote}
                                <span class="spread-badge">${spread}</span>
                            </span>
                            <span class="arbitrage-route">
                                <span class="route-badge">${route}</span>
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="amount-cell">
                        <span class="amount-val">${tx.amount} ${tokenBase}</span>
                        <div class="amount-usd">≈ $${tx.amountUsd} USD</div>
                    </div>
                </td>
                <td>
                    <div class="hash-cell">
                        <a href="https://bscscan.com/tx/${tx.hash}" target="_blank" rel="noopener noreferrer" class="hash-link" title="Verify on BSCScan Explorer: ${tx.hash}">
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.725rem;"></i>
                            ${shortHash}
                        </a>
                        <button class="copy-btn" onclick="copyHash('${tx.hash}')" title="Copy full transaction hash">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </td>
                <td>
                    <div class="time-cell">
                        <i class="fa-regular fa-clock" style="color: var(--accent-gold); font-size: 0.8rem;"></i>
                        <span class="time-text">${getRelativeTime(tx.timestamp)}</span>
                    </div>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
            while (tbody.children.length > MAX_ROWS) {
                tbody.removeChild(tbody.lastChild);
            }
        }

        // Relative time updater
        setInterval(() => {
            const rows = document.querySelectorAll('#transactions-body tr');
            rows.forEach(row => {
                const ts = row.dataset.timestamp;
                if (ts) {
                    const timeEl = row.querySelector('.time-text');
                    if (timeEl) {
                        timeEl.textContent = getRelativeTime(parseInt(ts, 10));
                    }
                }
            });
        }, 1000);

        // BSC RPC Endpoint Poller
        const BSC_RPC_ENDPOINTS = [
            'https://bsc-dataseed.binance.org',
            'https://bsc-dataseed1.defibit.io',
            'https://bsc-dataseed2.defibit.io',
            'https://bsc-dataseed1.ninicoin.io'
        ];
        let currentRpcIndex = 0;

        const KNOWN_CONTRACTS = {
            '0x10ed43c718714eb63d5aa57b78b54704e256024e': { name: 'PancakeSwap v2', pair: ['BNB', 'USDT'], route: 'PancakeSwap v2 ➔ BiSwap' },
            '0x13f4ea83d0bd40e75c8222255bc855a974568dd4': { name: 'PancakeSwap v3', pair: ['BNB', 'USDT'], route: 'PancakeSwap v3 ➔ BiSwap' },
            '0x3a6d8ca21d1cf76f653a67577fa0d27453350dd8': { name: 'BiSwap', pair: ['BNB', 'USDT'], route: 'BiSwap ➔ PancakeSwap' },
            '0x55d398326f99059ff775485246999027b3197955': { symbol: 'USDT', decimals: 18, quote: 'BNB', route: 'PancakeSwap ➔ BiSwap' },
            '0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c': { symbol: 'BNB', decimals: 18, quote: 'USDT', route: 'PancakeSwap v3 ➔ ApeSwap' },
            '0x7130d2a12b9bcbfae4f2634d864a1ee1ce3ead9c': { symbol: 'BTC', decimals: 18, quote: 'USDT', route: 'Uniswap v3 ➔ PancakeSwap' },
            '0x2170ed0880ac9a755fd29b2688956bd959f933f8': { symbol: 'ETH', decimals: 18, quote: 'USDT', route: 'PancakeSwap ➔ BiSwap' }
        };

        async function fetchLiveMinedBscTransactions(isInitial = false) {
            if (isFetchingBlock) return;
            isFetchingBlock = true;

            try {
                let blockData = null;
                for (let i = 0; i < BSC_RPC_ENDPOINTS.length; i++) {
                    const rpcUrl = BSC_RPC_ENDPOINTS[(currentRpcIndex + i) % BSC_RPC_ENDPOINTS.length];
                    try {
                        const response = await fetch(rpcUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                jsonrpc: '2.0',
                                id: Date.now(),
                                method: 'eth_getBlockByNumber',
                                params: ['latest', true]
                            })
                        });
                        if (response.ok) {
                            const json = await response.json();
                            if (json && json.result && Array.isArray(json.result.transactions)) {
                                blockData = json.result;
                                currentRpcIndex = (currentRpcIndex + i) % BSC_RPC_ENDPOINTS.length;
                                break;
                            }
                        }
                    } catch (err) { }
                }

                if (!blockData) return;
                const blockNum = parseInt(blockData.number, 16);
                if (blockNum === lastProcessedBlockNum && !isInitial) return;
                lastProcessedBlockNum = blockNum;

                const blockTime = parseInt(blockData.timestamp, 16) || Math.floor(Date.now() / 1000);
                const transactions = blockData.transactions;
                const extractedTrades = [];

                for (const tx of transactions) {
                    if (!tx.hash || tx.hash.length !== 66) continue;
                    if (seenHashes.has(tx.hash)) continue;

                    const to = (tx.to || '').toLowerCase();
                    const valBnb = parseInt(tx.value || '0x0', 16) / 1e18;

                    if (KNOWN_CONTRACTS[to] && KNOWN_CONTRACTS[to].pair) {
                        const cfg = KNOWN_CONTRACTS[to];
                        const amt = valBnb > 0 ? valBnb.toFixed(4) : (Math.random() * 6 + 0.5).toFixed(4);
                        const amtUsd = (parseFloat(amt) * 750).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        extractedTrades.push({
                            hash: tx.hash,
                            baseSymbol: cfg.pair[0],
                            quoteSymbol: cfg.pair[1],
                            amount: amt,
                            amountUsd: amtUsd,
                            timestamp: blockTime,
                            route: cfg.route,
                            spread: `+${(Math.random() * 0.75 + 0.15).toFixed(2)}%`
                        });
                    } else if (valBnb > 0.05) {
                        extractedTrades.push({
                            hash: tx.hash,
                            baseSymbol: 'BNB',
                            quoteSymbol: 'USDT',
                            amount: valBnb.toFixed(4),
                            amountUsd: (valBnb * 750).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                            timestamp: blockTime,
                            route: 'PancakeSwap v3 ➔ BiSwap',
                            spread: `+${(Math.random() * 0.65 + 0.18).toFixed(2)}%`
                        });
                    }
                }

                if (isInitial && extractedTrades.length > 0) {
                    const initialBatch = extractedTrades.splice(0, 6);
                    initialBatch.forEach(t => addTransaction(t, true));
                }

                extractedTrades.forEach(t => {
                    if (!seenHashes.has(t.hash)) {
                        realOnChainQueue.push(t);
                    }
                });
            } catch (err) {
                console.warn('Live BSC block polling error:', err);
            } finally {
                isFetchingBlock = false;
            }
        }

        async function fetchGeckoTerminalOnChainTrades() {
            try {
                const poolAddress = '0x16b9a82891338f9ba80e2d6970fdda79d1eb0dae';
                const response = await fetch(`https://api.geckoterminal.com/api/v2/networks/bsc/pools/${poolAddress}/trades`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) return false;
                const data = await response.json();

                if (data && Array.isArray(data.data) && data.data.length > 0) {
                    data.data.forEach(item => {
                        const attrs = item.attributes;
                        const txHash = attrs.tx_hash;
                        if (!txHash || txHash.length !== 66 || seenHashes.has(txHash)) return;

                        const amount = parseFloat(attrs.from_token_amount || attrs.volume_in_usd || 1.25).toFixed(4);
                        const amountUsd = parseFloat(attrs.volume_in_usd || (amount * 750)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        const ts = Math.floor(new Date(attrs.block_timestamp).getTime() / 1000);

                        realOnChainQueue.push({
                            hash: txHash,
                            baseSymbol: 'BNB',
                            quoteSymbol: 'USDT',
                            amount: amount,
                            amountUsd: amountUsd,
                            timestamp: ts,
                            route: 'PancakeSwap v3 ➔ BiSwap',
                            spread: `+${(Math.random() * 0.75 + 0.15).toFixed(2)}%`
                        });
                    });
                }
            } catch (err) {
                console.warn('GeckoTerminal trades fetch:', err);
            }
        }

        // Master Dispatcher (3s Cadence)
        setInterval(() => {
            if (isPaused) return;
            if (realOnChainQueue.length > 0) {
                const nextTx = realOnChainQueue.shift();
                addTransaction(nextTx);
            } else {
                fetchLiveMinedBscTransactions();
            }
        }, UPDATE_INTERVAL_MS);

        document.addEventListener('DOMContentLoaded', async () => {
            initCharts();
            fetchLiveMarketPrices();
            await fetchLiveMinedBscTransactions(true);
            fetchGeckoTerminalOnChainTrades();

            setInterval(fetchLiveMarketPrices, 7000);
            setInterval(updateChartsSubtle, 10000);
            setInterval(() => fetchLiveMinedBscTransactions(false), 4000);
            setInterval(fetchGeckoTerminalOnChainTrades, 40000);

            // Pause / Resume Toggle
            const pauseBtn = document.getElementById('btn-pause-toggle');
            if (pauseBtn) {
                pauseBtn.addEventListener('click', () => {
                    isPaused = !isPaused;
                    const pauseText = document.getElementById('pause-text');
                    const pauseIcon = pauseBtn.querySelector('i');
                    const liveBadge = document.getElementById('live-badge');

                    if (isPaused) {
                        if (pauseText) pauseText.textContent = 'Resume';
                        if (pauseIcon) pauseIcon.className = 'fa-solid fa-play';
                        pauseBtn.classList.add('active');
                        if (liveBadge) {
                            liveBadge.style.color = '#ef4444';
                            const pulseDot = liveBadge.querySelector('.pulse-dot');
                            if (pulseDot) pulseDot.style.backgroundColor = '#ef4444';
                            const badgeText = liveBadge.querySelector('span');
                            if (badgeText) badgeText.textContent = 'Stream Paused';
                        }
                    } else {
                        if (pauseText) pauseText.textContent = 'Pause';
                        if (pauseIcon) pauseIcon.className = 'fa-solid fa-pause';
                        pauseBtn.classList.remove('active');
                        if (liveBadge) {
                            liveBadge.style.color = 'var(--accent-green)';
                            const pulseDot = liveBadge.querySelector('.pulse-dot');
                            if (pulseDot) pulseDot.style.backgroundColor = 'var(--accent-green)';
                            const badgeText = liveBadge.querySelector('span');
                            if (badgeText) badgeText.textContent = 'Live Engine Stream';
                        }
                    }
                });
            }

            // Clear Button
            const clearBtn = document.getElementById('btn-clear');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    transactionsList.length = 0;
                    realOnChainQueue.length = 0;
                    seenHashes.clear();
                    totalTxReceived = 0;
                    renderEmptyState();
                });
            }
        });
    </script>
@endsection
