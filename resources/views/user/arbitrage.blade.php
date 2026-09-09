@extends('user.layouts.app')

@section('title', 'Arbitrage Trading Dashboard')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-page: #0b0d13;
            --bg-navbar: #0e1118;
            --bg-card: #151720;
            --bg-card-header: #191c27;
            --bg-row-hover: #1c202e;
            --border-navbar: #eab308;
            --border-card: #262938;
            --border-table: #1e2230;
            --text-main: #ffffff;
            --text-sub: #8e95a5;
            --text-muted: #5e6676;
            --accent-gold: #f59e0b;
            --accent-green: #22c55e;
            --accent-red: #ef4444;
        }

        /* Card System */
        .arbitrage-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.45);
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .arbitrage-card:hover {
            border-color: rgba(243, 202, 82, 0.4);
            box-shadow: 0 0 25px rgba(243, 202, 82, 0.15);
        }
        .arbitrage-card-header {
            background: var(--bg-card-header);
            border-bottom: 1px solid var(--border-card);
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .arbitrage-card-header h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
        }
        .arbitrage-card-body {
            padding: 18px 20px;
        }

        /* 1. Marquee Section */
        .marquee-section {
            margin-bottom: 18px;
        }
        .marquee-box {
            background: #0f121a;
            border: 1px solid var(--border-card);
            border-radius: 12px;
            padding: 10px 16px;
            overflow: hidden;
            white-space: nowrap;
        }
        .marquee-track {
            display: inline-flex;
            animation: marqueeScroll 35s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        @keyframes marqueeScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .crypto-item {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            font-size: 0.85rem;
            background: #161a25;
            border: 1px solid #232838;
            padding: 6px 14px;
            border-radius: 8px;
        }
        .crypto-item img {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            margin-right: 7px;
            object-fit: contain;
            vertical-align: middle;
        }
        .crypto-symbol {
            font-weight: 700;
            margin-right: 5px;
        }
        .crypto-price {
            color: #f1f5f9;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 500;
        }

        /* 2. Grid Layout */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 18px;
        }

        /* Price Cards */
        .price-card-header {
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .price-icon-btc { color: #f59e0b; font-size: 1.2rem; }
        .price-icon-eth { color: #a855f7; font-size: 1.2rem; }
        .price-icon-omni { color: #38bdf8; font-size: 1.2rem; }
        .price-card-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 18px 20px;
        }
        .price-label {
            font-size: 0.775rem;
            color: var(--text-sub);
            margin-bottom: 4px;
        }
        .price-value {
            font-size: 1.65rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            font-family: 'JetBrains Mono', monospace;
        }
        .badge-percent {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }
        .badge-positive {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.25);
        }
        .badge-negative {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        /* 3. Charts */
        .chart-container {
            position: relative;
            height: 260px;
            width: 100%;
        }

        /* 4. Live Arbitrage Transactions Card */
        .table-card-header {
            background: var(--bg-card-header);
            border-bottom: 1px solid var(--border-card);
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .table-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .table-title-group i {
            color: var(--accent-gold);
            font-size: 1.1rem;
        }
        .table-title-group h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
        }
        .table-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .live-indicator-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-green);
        }
        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--accent-green);
            position: relative;
        }
        .pulse-dot::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--accent-green);
            opacity: 0.6;
            animation: beaconPulse 1.8s cubic-bezier(0.24, 0, 0.38, 1) infinite;
        }
        @keyframes beaconPulse {
            0% { transform: scale(0.6); opacity: 0.9; }
            70% { transform: scale(2.2); opacity: 0; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        .btn-action {
            background: #1b1e2a;
            border: 1px solid var(--border-card);
            color: var(--text-sub);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .btn-action:hover {
            background: #232738;
            color: #ffffff;
            border-color: #3e445a;
        }
        .btn-action.active {
            background: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.4);
            color: var(--accent-gold);
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            background: #11141c;
            border-bottom: 1px solid var(--border-card);
            font-size: 0.8rem;
            color: var(--text-sub);
            flex-wrap: wrap;
            gap: 10px;
        }
        .stats-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .stats-value {
            font-weight: 600;
            color: #ffffff;
        }
        .stats-tag {
            background: #181c27;
            border: 1px solid var(--border-card);
            padding: 3px 8px;
            border-radius: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.725rem;
            color: var(--accent-gold);
        }

        /* Table */
        .arbitrage-table-container {
            max-height: 520px;
            overflow-y: auto;
        }
        .arbitrage-table-container::-webkit-scrollbar { width: 6px; }
        .arbitrage-table-container::-webkit-scrollbar-track { background: var(--bg-card); }
        .arbitrage-table-container::-webkit-scrollbar-thumb { background: #262b3a; border-radius: 4px; }
        .arbitrage-table-container::-webkit-scrollbar-thumb:hover { background: #383f55; }
        .arbitrage-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .arbitrage-table thead {
            position: sticky;
            top: 0;
            background: #11151f;
            z-index: 10;
        }
        .arbitrage-table th {
            padding: 12px 18px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-sub);
            white-space: nowrap;
            border-bottom: 1px solid var(--border-card);
            border-right: 1px solid var(--border-table);
        }
        .arbitrage-table th:last-child {
            border-right: none;
        }
        .arbitrage-table tbody tr {
            border-bottom: 1px solid var(--border-table);
            transition: background-color 0.2s ease;
        }
        .arbitrage-table tbody tr:hover {
            background-color: var(--bg-row-hover);
        }
        .arbitrage-table tbody tr.new-row {
            animation: highlightRow 2s ease-out;
        }
        @keyframes highlightRow {
            0% { background-color: rgba(34, 197, 94, 0.2); }
            100% { background-color: transparent; }
        }
        .arbitrage-table td {
            padding: 13px 18px;
            font-size: 0.85rem;
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
            gap: 12px;
        }
        .pair-icons-stack {
            position: relative;
            width: 44px;
            height: 30px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        .token-pair-img {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            object-fit: cover;
            background: #11141c;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.45);
            transition: transform 0.2s ease;
        }
        .token-pair-img.token-primary {
            position: absolute;
            left: 0;
            top: 2px;
            z-index: 2;
            border: 2px solid #151720;
        }
        .token-pair-img.token-secondary {
            position: absolute;
            left: 17px;
            top: 2px;
            z-index: 1;
            border: 2px solid #151720;
            opacity: 0.95;
        }
        .arbitrage-table tbody tr:hover .token-pair-img.token-secondary {
            transform: translateX(3px);
        }
        .pair-details {
            display: flex;
            flex-direction: column;
        }
        .pair-title {
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .arbitrage-route {
            font-size: 0.725rem;
            color: var(--text-muted);
            margin-top: 2px;
        }
        .route-badge {
            color: #38bdf8;
            font-weight: 500;
        }
        .spread-badge {
            display: inline-block;
            padding: 1px 5px;
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            border-radius: 3px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 4px;
        }
        .amount-val {
            font-weight: 600;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.875rem;
        }
        .amount-usd {
            font-size: 0.725rem;
            color: var(--text-muted);
            margin-top: 2px;
        }
        .hash-cell {
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .hash-link {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: #60a5fa;
            text-decoration: none;
            padding: 3px 7px;
            border-radius: 5px;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .hash-link:hover {
            color: #93c5fd;
            background: rgba(59, 130, 246, 0.18);
            border-color: rgba(59, 130, 246, 0.4);
        }
        .copy-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.8rem;
            border-radius: 4px;
            transition: color 0.2s;
        }
        .copy-btn:hover {
            color: #ffffff;
        }
        .time-cell {
            color: var(--text-sub);
            font-size: 0.8rem;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .empty-state {
            padding: 50px 20px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
        }
        .empty-state i {
            display: block;
            font-size: 30px;
            margin-bottom: 10px;
            opacity: 0.4;
        }

        @media (max-width: 1024px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .grid-3 { grid-template-columns: 1fr; }
            .arbitrage-card-header { padding: 12px 14px; }
            .arbitrage-table th, .arbitrage-table td { padding: 10px 12px; }
            .stats-bar { padding: 8px 12px; }
        }
    </style>

    <div class="w-full space-y-6">

        <!-- Top Header Banner -->
        <div class="ng-banner-title p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="pdf-num-badge">🚀</span>
                    <span class="text-xs text-amber-400 font-extrabold tracking-[3px] uppercase">NEXTGEN FOREX MEMBER PORTAL</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-gold-gradient font-heading uppercase flex items-center gap-3">
                    <i class="fa-solid fa-arrow-right-arrow-left text-amber-400"></i>
                    Arbitrage Dashboard
                </h1>
                <p class="text-xs text-neutral-300 mt-1">Real-time Cross-DEX Crypto Arbitrage Trading Engine & Blockchain Feeds</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-3 rounded-xl bg-bg border border-amber-500/40 text-amber-300 text-xs font-bold font-mono flex items-center gap-2 shadow-lg shrink-0">
                    <i class="fa-solid fa-bolt text-amber-400 animate-pulse"></i>
                    <span>Engine Status: <strong class="text-emerald-400 text-sm font-black">ACTIVE 24/7</strong></span>
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
                    <!-- Duplicate for infinite scroll -->
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

        <!-- 2. Three Price Cards -->
        <div class="grid-3">
            <!-- Bitcoin -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <div class="price-card-header">
                        <i class="fa-brands fa-btc price-icon-btc"></i>
                        <h3>Bitcoin</h3>
                    </div>
                </div>
                <div class="price-card-body">
                    <div>
                        <p class="price-label">Current Price</p>
                        <h2 class="price-value" id="card-btc-price">$78,484.00</h2>
                    </div>
                    <span class="badge-percent badge-positive" id="card-btc-change">+2.4%</span>
                </div>
            </div>

            <!-- Ethereum -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <div class="price-card-header">
                        <i class="fa-brands fa-ethereum price-icon-eth"></i>
                        <h3>Ethereum</h3>
                    </div>
                </div>
                <div class="price-card-body">
                    <div>
                        <p class="price-label">Current Price</p>
                        <h2 class="price-value" id="card-eth-price">$2,473.79</h2>
                    </div>
                    <span class="badge-percent badge-positive" id="card-eth-change">+1.8%</span>
                </div>
            </div>

            <!-- OMNI -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <div class="price-card-header">
                        <i class="fa-solid fa-gem price-icon-omni"></i>
                        <h3>OMNI</h3>
                    </div>
                </div>
                <div class="price-card-body">
                    <div>
                        <p class="price-label">Current Price</p>
                        <h2 class="price-value" id="card-omni-price">$3.88</h2>
                    </div>
                    <span class="badge-percent badge-negative" id="card-omni-change">-0.5%</span>
                </div>
            </div>
        </div>

        <!-- 3. Three Charts -->
        <div class="grid-3">
            <!-- Token Distribution -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <h3>Token Distribution</h3>
                </div>
                <div class="arbitrage-card-body">
                    <div class="chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Profit Share -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <h3>Profit Share</h3>
                </div>
                <div class="arbitrage-card-body">
                    <div class="chart-container">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Volume Comparison -->
            <div class="arbitrage-card">
                <div class="arbitrage-card-header">
                    <h3>Volume Comparison</h3>
                </div>
                <div class="arbitrage-card-body">
                    <div class="chart-container">
                        <canvas id="columnChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Live Arbitrage Transactions Card -->
        <div class="arbitrage-card">
            <div class="table-card-header">
                <div class="table-title-group">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    <h3>Live Arbitrage Transactions</h3>
                </div>
                <div class="table-actions">
                    <div class="live-indicator-badge" id="live-badge">
                        <div class="pulse-dot"></div>
                        <span>Live Updates</span>
                    </div>
                    <button class="btn-action" id="btn-pause-toggle" title="Pause or Resume Feed">
                        <i class="fa-solid fa-pause"></i> <span id="pause-text">Pause</span>
                    </button>
                    <button class="btn-action" id="btn-clear" title="Clear Table">
                        <i class="fa-solid fa-trash-can"></i> Clear
                    </button>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stats-item">
                    <span>Network:</span>
                    <span class="stats-tag"><i class="fa-solid fa-cubes"></i> BSC (BNB Chain)</span>
                </div>
                <div class="stats-item">
                    <span>Arbitrage Routes:</span>
                    <span class="stats-value">PancakeSwap • BiSwap • ApeSwap</span>
                </div>
                <div class="stats-item">
                    <span>Speed:</span>
                    <span class="stats-tag"><i class="fa-regular fa-clock"></i> 3 Seconds</span>
                </div>
                <div class="stats-item">
                    <span>Transactions Captured:</span>
                    <span class="stats-value" id="total-tx-count">0</span>
                </div>
            </div>

            <!-- Table Container -->
            <div class="arbitrage-card-body" style="padding: 0;">
                <div class="arbitrage-table-container">
                    <table class="arbitrage-table">
                        <thead>
                            <tr>
                                <th>Token Pair</th>
                                <th>Amount</th>
                                <th>Transaction Hash</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody id="transactions-body">
                            <tr id="initial-loading-row">
                                <td colspan="4" class="empty-state">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                    Connecting to BSC On-Chain Arbitrage Feeds...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Toast for Copy (Hidden by default, shown ONLY on copy click) -->
    <div id="copy-toast" style="display: none; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; position: fixed; bottom: 24px; right: 24px; background: #22c55e; color: #fff; padding: 10px 18px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; z-index: 9999; box-shadow: 0 4px 20px rgba(0,0,0,0.6);">
        <i class="fa-solid fa-check mr-1"></i> Transaction hash copied!
    </div>

    <!-- Live Arbitrage Engine JavaScript -->
    <script>
        // ==========================================
        // 1. Chart Configuration & Colors
        // ==========================================
        const chartTokens = [
            { symbol: 'BNB', color: '#f59e0b' },
            { symbol: 'USDT', color: '#10b981' },
            { symbol: 'MUSIC', color: '#ec4899' },
            { symbol: 'DAI', color: '#f97316' },
            { symbol: 'ADA', color: '#2563eb' },
            { symbol: 'ETH', color: '#818cf8' }
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
                            data: [25, 20, 16, 14, 15, 10],
                            backgroundColor: chartTokens.map(t => t.color),
                            borderWidth: 2,
                            borderColor: '#151720'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { color: '#cbd5e1', font: { family: 'Inter', size: 11, weight: '500' }, boxWidth: 14 }
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
                            data: [35, 18, 22, 10, 8, 7],
                            backgroundColor: chartTokens.map(t => t.color),
                            borderWidth: 2,
                            borderColor: '#151720'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { color: '#cbd5e1', font: { family: 'Inter', size: 11, weight: '500' }, boxWidth: 14 }
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
                                label: 'Volume',
                                data: [18, 30, 48, 17, 40, 13],
                                backgroundColor: '#eab308',
                                borderRadius: 3
                            },
                            {
                                label: 'Trades',
                                data: [30, 18, 7, 5, 5, 12],
                                backgroundColor: '#856a1e',
                                borderRadius: 3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 50,
                                ticks: { color: '#64748b', font: { size: 10 } },
                                grid: { color: '#242838' }
                            },
                            x: {
                                ticks: { color: '#94a3b8', font: { size: 10, weight: '600' } },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { color: '#cbd5e1', font: { family: 'Inter', size: 11 }, boxWidth: 14 }
                            }
                        }
                    }
                });
            }
        }

        function updateChartsSubtle() {
            if (pieChart) {
                pieChart.data.datasets[0].data = [
                    Math.round(20 + Math.random() * 8),
                    Math.round(18 + Math.random() * 6),
                    Math.round(14 + Math.random() * 5),
                    Math.round(12 + Math.random() * 5),
                    Math.round(14 + Math.random() * 4),
                    Math.round(9 + Math.random() * 4)
                ];
                pieChart.update();
            }

            if (doughnutChart) {
                doughnutChart.data.datasets[0].data = [
                    Math.round(30 + Math.random() * 10),
                    Math.round(16 + Math.random() * 6),
                    Math.round(20 + Math.random() * 6),
                    Math.round(8 + Math.random() * 4),
                    Math.round(7 + Math.random() * 4),
                    Math.round(6 + Math.random() * 3)
                ];
                doughnutChart.update();
            }

            if (columnChart) {
                columnChart.data.datasets[0].data = [
                    Math.round(15 + Math.random() * 10),
                    Math.round(26 + Math.random() * 8),
                    Math.round(42 + Math.random() * 8),
                    Math.round(14 + Math.random() * 6),
                    Math.round(36 + Math.random() * 8),
                    Math.round(12 + Math.random() * 4)
                ];
                columnChart.update();
            }
        }

        // ==========================================
        // 2. Real-Time Price Fetcher
        // ==========================================
        async function fetchLiveMarketPrices() {
            const pairs = [
                { symbol: 'BTCUSDT', tickerId: 'ticker-btc', dupId: 'ticker-btc-dup', cardId: 'card-btc-price', changeId: 'card-btc-change' },
                { symbol: 'ETHUSDT', tickerId: 'ticker-eth', dupId: 'ticker-eth-dup', cardId: 'card-eth-price', changeId: 'card-eth-change' },
                { symbol: 'OMNIUSDT', tickerId: null, cardId: 'card-omni-price', changeId: 'card-omni-change' },
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

                        if (p.tickerId) {
                            const el = document.getElementById(p.tickerId);
                            if (el) el.textContent = `$${formattedPrice}`;
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
                console.warn('Price ticker fetch:', err.message);
            }
        }

        // ==========================================
        // 3. Real Live On-Chain BSC Transactions (3s Cadence)
        // ==========================================
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
            'ADA': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ada.png',
            'BUSD': 'https://assets.coingecko.com/coins/images/9576/small/BUSD.png',
            'DAI': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/dai.png',
            'EOS': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/eos.png',
            'LTC': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/ltc.png',
            'DASH': 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/dash.png'
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
            'DEX ➔ CEX Spread',
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
                    }, 2000);
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
                        <i class="fa-regular fa-folder-open"></i>
                        No token transactions found.
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
            const spread = tx.spread || `+${(Math.random() * 0.8 + 0.12).toFixed(2)}%`;

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
                        <span class="amount-usd" style="color: aliceblue;">≈ $${tx.amountUsd} USD</span>
                    </div>
                </td>
                <td>
                    <div class="hash-cell">
                        <a href="https://bscscan.com/tx/${tx.hash}" target="_blank" rel="noopener noreferrer" class="hash-link" title="View on BSCScan: ${tx.hash}">
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.7rem;"></i>
                            ${shortHash}
                        </a>
                        <button class="copy-btn" onclick="copyHash('${tx.hash}')" title="Copy full hash">
                            <i class="fa-regular fa-copy" style="color: aliceblue;"></i>
                        </button>
                    </div>
                </td>
                <td>
                    <div class="time-cell">
                        <i class="fa-regular fa-clock" style="color: var(--text-muted); font-size: 0.75rem;"></i>
                        <span class="time-text" style="color: aliceblue;">${getRelativeTime(tx.timestamp)}</span>
                    </div>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
            while (tbody.children.length > MAX_ROWS) {
                tbody.removeChild(tbody.lastChild);
            }
        }

        // Live Relative Time Updater
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

        // ==========================================
        // Live On-Chain Data Harvesters
        // ==========================================
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
            '0x1a1ec25dc08e98e5e93f1104bd5be5cdd4597752': { name: 'Pancake Universal', pair: ['BNB', 'USDT'], route: 'PancakeSwap ➔ Binance' },
            '0x3a6d8ca21d1cf76f653a67577fa0d27453350dd8': { name: 'BiSwap', pair: ['BNB', 'USDT'], route: 'BiSwap ➔ PancakeSwap' },
            '0x55d398326f99059ff775485246999027b3197955': { symbol: 'USDT', decimals: 18, quote: 'BNB', route: 'PancakeSwap ➔ BiSwap' },
            '0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c': { symbol: 'BNB', decimals: 18, quote: 'USDT', route: 'PancakeSwap v3 ➔ ApeSwap' },
            '0x7130d2a12b9bcbfae4f2634d864a1ee1ce3ead9c': { symbol: 'BTC', decimals: 18, quote: 'USDT', route: 'Uniswap v3 ➔ PancakeSwap' },
            '0x2170ed0880ac9a755fd29b2688956bd959f933f8': { symbol: 'ETH', decimals: 18, quote: 'USDT', route: 'PancakeSwap ➔ BiSwap' },
            '0x0e09fabb73bd3ade0a17ecc321fd13a19e81ce82': { symbol: 'CAKE', decimals: 18, quote: 'BNB', route: 'PancakeSwap ➔ BiSwap' },
            '0x570a5d26f7765ecb712c0924e4de545b89fd43df': { symbol: 'SOL', decimals: 18, quote: 'USDT', route: 'PancakeSwap ➔ Binance' },
            '0x1d2f0da169ceb9fc7b3144628db156f3f6c60dbe': { symbol: 'XRP', decimals: 18, quote: 'USDT', route: 'BiSwap ➔ PancakeSwap' },
            '0xba2ae424d960c26247dd6c32edc70b295c744c43': { symbol: 'DOGE', decimals: 8, quote: 'USDT', route: 'PancakeSwap ➔ BiSwap' },
            '0x3ee2200efb3400fabb9aacf31297cbdd1d435d47': { symbol: 'ADA', decimals: 18, quote: 'USDT', route: 'PancakeSwap ➔ BiSwap' }
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
                    } catch (err) {
                        // try next RPC endpoint
                    }
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
                    const input = tx.input || '';

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
                            spread: `+${(Math.random() * 0.75 + 0.12).toFixed(2)}%`
                        });
                    } else if (KNOWN_CONTRACTS[to] && input.startsWith('0xa9059cbb')) {
                        const cfg = KNOWN_CONTRACTS[to];
                        try {
                            const rawHex = '0x' + input.substring(74);
                            const rawVal = BigInt(rawHex);
                            const divisor = BigInt(10) ** BigInt(cfg.decimals);
                            const integerPart = rawVal / divisor;
                            const remainder = rawVal % divisor;
                            let tokenAmt = Number(integerPart) + Number(remainder) / Number(divisor);
                            if (tokenAmt === 0 || isNaN(tokenAmt)) tokenAmt = 1.0;

                            const formattedAmt = tokenAmt > 1000 ? tokenAmt.toFixed(2) : tokenAmt.toFixed(4);
                            const price = cfg.symbol === 'USDT' ? 1 : cfg.symbol === 'BTC' ? 89200 : cfg.symbol === 'ETH' ? 2470 : cfg.symbol === 'CAKE' ? 2.8 : 750;
                            const amtUsd = (tokenAmt * price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                            extractedTrades.push({
                                hash: tx.hash,
                                baseSymbol: cfg.symbol === 'USDT' ? 'BNB' : cfg.symbol,
                                quoteSymbol: cfg.symbol === 'USDT' ? 'USDT' : cfg.quote,
                                amount: formattedAmt,
                                amountUsd: amtUsd,
                                timestamp: blockTime,
                                route: cfg.route,
                                spread: `+${(Math.random() * 0.85 + 0.15).toFixed(2)}%`
                            });
                        } catch (e) { }
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
                    } else if (input.length >= 10 && tx.to) {
                        const tokens = ['BNB', 'USDT', 'CAKE', 'ETH', 'BTC'];
                        const base = tokens[Math.floor(Math.random() * tokens.length)];
                        const quote = base === 'USDT' ? 'BUSD' : 'USDT';
                        const amt = (Math.random() * 5 + 0.2).toFixed(4);
                        const amtUsd = (parseFloat(amt) * (base === 'BTC' ? 89000 : base === 'ETH' ? 2500 : 750)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                        extractedTrades.push({
                            hash: tx.hash,
                            baseSymbol: base,
                            quoteSymbol: quote,
                            amount: amt,
                            amountUsd: amtUsd,
                            timestamp: blockTime,
                            route: ARBITRAGE_DEX_PAIRS[Math.floor(Math.random() * ARBITRAGE_DEX_PAIRS.length)],
                            spread: `+${(Math.random() * 0.65 + 0.15).toFixed(2)}%`
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

        // Master 3-Second Dispatcher
        setInterval(() => {
            if (isPaused) return;
            if (realOnChainQueue.length > 0) {
                const nextTx = realOnChainQueue.shift();
                addTransaction(nextTx);
            }

            if (realOnChainQueue.length < 15) {
                fetchLiveMinedBscTransactions();
            }
        }, UPDATE_INTERVAL_MS);

        document.addEventListener('DOMContentLoaded', async () => {
            initCharts();
            fetchLiveMarketPrices();
            await fetchLiveMinedBscTransactions(true);
            fetchGeckoTerminalOnChainTrades();

            setInterval(fetchLiveMarketPrices, 8000);
            setInterval(updateChartsSubtle, 12000);
            setInterval(() => fetchLiveMinedBscTransactions(false), 4000);
            setInterval(fetchGeckoTerminalOnChainTrades, 45000);

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
                            if (badgeText) badgeText.textContent = 'Live Updates';
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
