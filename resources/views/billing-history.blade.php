@extends('layout')

@section('title', 'DormEase: Billing History')
@section('page-title', 'Billing History')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        background: var(--pink-bg-page);
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -.02em;
        line-height: 1.15;
    }

    .page-header .dorm-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--hot-pink);
        margin-top: .2rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .85rem;
        font-weight: 600;
        color: var(--hot-pink);
        text-decoration: none;
        margin-bottom: .5rem;
        transition: opacity .15s;
    }

    .back-link:hover { opacity: .75; }

    .overview-strip {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: .75rem;
    }

    .overview-card {
        background: var(--white);
        border: 1.5px solid var(--border-pink);
        border-radius: 18px;
        padding: 1rem 1.2rem;
        display: flex;
        flex-direction: column;
        gap: .25rem;
        transition: box-shadow .15s, border-color .15s;
        cursor: default;
    }

    .overview-card:hover {
        border-color: var(--bright-pink);
        box-shadow: 0 4px 16px rgba(232,23,93,.1);
    }

    .oc-month {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--hot-pink);
    }

    .oc-bill {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -.02em;
        line-height: 1.1;
    }

    .oc-meta {
        font-size: .75rem;
        font-weight: 500;
        color: var(--ink-soft);
    }

    .oc-bar-track {
        height: 5px;
        border-radius: 999px;
        background: var(--border-pink);
        margin-top: .35rem;
        overflow: hidden;
    }

    .oc-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: var(--gradient-pink);
        transition: width .4s ease;
    }

    .filters-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: .6rem .95rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        font-size: .83rem;
        color: var(--black);
        outline: none;
        cursor: pointer;
        transition: border-color .18s;
        box-shadow: var(--shadow);
    }

    .filter-select:focus { border-color: var(--bright-pink); }

    .search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
        max-width: 260px;
    }

    .search-input-wrap svg {
        position: absolute;
        left: .75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        stroke: var(--hot-pink);
        stroke-width: 2;
        fill: none;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: .6rem .85rem .6rem 2.2rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        font-size: .83rem;
        color: var(--black);
        outline: none;
        box-sizing: border-box;
        transition: border-color .18s;
    }

    .search-input:focus { border-color: var(--bright-pink); }

    .btn-filter {
        display: flex;
        align-items: center;
        gap: .4rem;
        padding: .65rem 1.15rem;
        border-radius: 12px;
        background: var(--gradient-pink);
        color: var(--white);
        border: none;
        font-size: .85rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s;
        box-shadow: var(--shadow-pink-btn);
    }

    .btn-filter:hover { transform: translateY(-1px); }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .65rem 1.1rem;
        border-radius: 12px;
        background: var(--white);
        color: var(--black);
        border: 1.5px solid var(--border-pink);
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        transition: border-color .15s, color .15s;
        box-shadow: var(--shadow);
        text-decoration: none;
    }

    .btn-outline:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .ms-auto { margin-left: auto; }

    .month-block {
        background: var(--white);
        border-radius: 22px;
        border: 1.5px solid var(--border-pink);
        overflow: hidden;
        box-shadow: var(--shadow-pink-card);
        margin-bottom: 1rem;
    }

    .month-header {
        background: var(--gradient-pink);
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .8rem;
        flex-wrap: wrap;
        cursor: pointer;
        user-select: none;
    }

    .month-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--white);
        letter-spacing: -.01em;
    }

    .month-chip {
        display: inline-flex;
        align-items: center;
        padding: .18rem .65rem;
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 700;
        background: rgba(255,255,255,.2);
        color: var(--white);
        border: 1px solid rgba(255,255,255,.3);
        white-space: nowrap;
    }

    .month-chip.paid-chip {
        background: rgba(46,194,126,.25);
        border-color: rgba(46,194,126,.5);
    }

    .month-chip.unpaid-chip {
        background: rgba(255,93,115,.25);
        border-color: rgba(255,93,115,.5);
    }

    .month-chevron {
        margin-left: auto;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform .25s;
        flex-shrink: 0;
    }

    .month-chevron svg {
        width: 11px;
        height: 11px;
        stroke: var(--white);
        stroke-width: 2.5;
        fill: none;
        transition: transform .25s;
    }

    .month-block.collapsed .month-chevron svg { transform: rotate(-90deg); }

    .month-body { padding: 1.2rem; display: flex; flex-direction: column; gap: 1rem; }
    .month-block.collapsed .month-body { display: none; }

    .floor-group {
        border: 1.5px solid var(--bright-pink);
        border-radius: 16px;
        overflow: hidden;
    }

    .floor-header {
        padding: .65rem 1.1rem;
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
        background: var(--white);
        border-bottom: 1.5px solid var(--bright-pink);
    }

    .floor-name {
        font-size: .82rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .floor-chip {
        display: inline-flex;
        align-items: center;
        padding: .15rem .55rem;
        border-radius: 999px;
        font-size: .73rem;
        font-weight: 700;
        background: #fff0f6;
        color: #191617;
        border: 1px solid #ffc7dc;
    }

    .floor-due { font-size: .74rem; font-weight: 700; color: var(--black); margin-left: auto; }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        background: var(--border-pink-mid);
        border-top: 2px solid #ff8fbc;
    }

    .room-card {
        background: var(--white);
        padding: 1.1rem;
        border-right: 2px solid #ff8fbc;
        border-bottom: 2px solid #ff8fbc;
        position: relative;
        transition: background .15s;
    }

    .room-card:hover { background: var(--pink-bg-soft); }

    .room-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .55rem;
        gap: .5rem;
    }

    .room-card-left { display: flex; align-items: center; gap: .5rem; }

    .room-number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .8rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .room-meta-stack { display: flex; flex-direction: column; gap: 0; }
    .room-meta-label { font-size: .9rem; font-weight: 700; color: var(--bright-pink); line-height: 1.2; }
    .room-meta-occ { font-size: .77rem; font-weight: 500; color: var(--ink-soft); }

    .room-reading-pills {
        display: flex;
        gap: .4rem;
        flex-wrap: wrap;
        margin-bottom: .55rem;
    }

    .reading-pill {
        font-size: .72rem;
        font-weight: 600;
        color: var(--ink-soft);
        background: var(--pink-bg-page);
        border: 1px solid var(--border-pink);
        border-radius: 999px;
        padding: .12rem .55rem;
    }

    .btn-update {
        width: 28px;
        height: 28px;
        border-radius: 10px;
        background: var(--gradient-pink);
        border: none;
        cursor: pointer;
        transition: var(--ease);
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(255,79,147,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .btn-update img {
        width: 12px;
        height: 12px;
        filter: brightness(0) invert(1);
    }

    .btn-update:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(255,79,147,.28);
    }

    .tenants-list {
        display: flex;
        flex-direction: column;
        border-top: 1px solid var(--border-pink-mid);
    }

    .tenant-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .45rem 0;
        gap: .5rem;
    }

    .tenant-row + .tenant-row { border-top: 1px dashed rgba(255,150,180,.18); }

    .tenant-left { display: flex; align-items: center; gap: .4rem; min-width: 0; flex: 1; }

    .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .dot-green  { background: #2ec27e; }
    .dot-orange { background: #f0a500; }
    .dot-red    { background: #ff5d73; }
    .dot-gray   { background: #bbb; }

    .tname {
        font-size: .79rem;
        font-weight: 500;
        color: var(--ink-deep);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tenant-right { display: flex; align-items: center; gap: .4rem; flex-shrink: 0; }

    .t-amount { font-size: .83rem; font-weight: 700; color: var(--hot-pink); white-space: nowrap; }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .16rem .5rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-paid       { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
    .badge-unpaid     { background: #fff6dc; color: #c58a00; border: 1px solid #f2cd63; }
    .badge-overdue    { background: #ffe9ee; color: #e04867; border: 1px solid #ff9db0; }
    .badge-pending    { background: #edf1ff; color: #5570ff; border: 1px solid #b6c2ff; }
    .badge-not-billed { background: #f5f5f5; color: #999;    border: 1px solid #ddd; }

    .pagination-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        flex-wrap: wrap;
        padding-top: .5rem;
    }

    .pg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        font-size: .82rem;
        font-weight: 700;
        color: var(--ink-deep);
        cursor: pointer;
        text-decoration: none;
        transition: border-color .15s, background .15s, color .15s;
    }

    .pg-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .pg-btn.active { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
    .pg-btn.disabled { opacity: .4; pointer-events: none; }

    .pg-sep { font-size: .82rem; color: var(--ink-soft); padding: 0 .2rem; }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--ink-soft);
    }

    .empty-state-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: .35;
    }

    .empty-state-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--black);
        margin-bottom: .35rem;
    }

    .empty-state-sub { font-size: .88rem; }

    .export-month-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .75rem;
        border-radius: 10px;
        border: 1.5px solid rgba(255,255,255,.35);
        background: rgba(255,255,255,.15);
        color: var(--white);
        font-size: .76rem;
        font-weight: 700;
        cursor: pointer;
        transition: background .15s;
        flex-shrink: 0;
    }

    .export-month-btn:hover { background: rgba(255,255,255,.28); }

    .export-month-btn svg {
        width: 12px;
        height: 12px;
        stroke: var(--white);
        stroke-width: 2.5;
        fill: none;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.35);
        backdrop-filter: blur(4px);
        z-index: 300;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.open { display: flex; }

    .modal {
        background: var(--white);
        border-radius: 26px;
        padding: 2rem;
        width: 90%;
        max-width: 500px;
        box-shadow: var(--shadow-pink-modal);
        animation: fadeUp .3s ease;
        max-height: 90vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--bright-pink) transparent;
    }

    .modal::-webkit-scrollbar { width: 6px; }
    .modal::-webkit-scrollbar-thumb { background: var(--bright-pink); border-radius: 20px; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.4rem;
    }

    .modal-title { font-size: 1.15rem; font-weight: 700; color: var(--ink-soft); }
    .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-soft); }
    .modal-close:hover { color: var(--bright-pink); }

    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field.full { grid-column: 1 / -1; }

    .modal-field label {
        display: block;
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink-soft);
        margin-bottom: .35rem;
    }

    .modal-field input,
    .modal-field select {
        width: 100%;
        padding: .7rem .95rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-pink);
        font-size: .88rem;
        color: var(--ink-deep);
        background: var(--pink-bg-soft);
        outline: none;
        transition: border-color .18s;
        box-sizing: border-box;
    }

    .modal-field input:focus,
    .modal-field select:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }

    .modal-actions {
        display: flex;
        gap: .7rem;
        margin-top: 1.5rem;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: .65rem 1.2rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        font-size: .87rem;
        font-weight: 600;
        color: var(--ink-soft);
        cursor: pointer;
        transition: border-color .15s, color .15s;
    }

    .btn-cancel:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .btn-submit {
        padding: .65rem 1.4rem;
        border-radius: 12px;
        border: none;
        background: var(--bright-pink);
        color: var(--white);
        font-size: .87rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s;
    }

    .btn-submit:hover { transform: translateY(-1px); }

    .view-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .7rem 0;
        border-bottom: 1px solid var(--border-pink-mid);
        font-size: .88rem;
    }

    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-soft); font-weight: 500; }
    .view-val   { font-weight: 600; color: var(--ink-deep); }

    .payment-proof-card {
        margin-top: .85rem;
        padding: .9rem;
        border: 1px solid var(--border-pink-mid);
        border-radius: 14px;
        background: var(--pink-bg-soft);
    }

    .payment-proof-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        margin-bottom: .75rem;
        color: var(--ink-soft);
        font-size: .82rem;
        font-weight: 700;
    }

    .payment-proof-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem;
        margin-bottom: .75rem;
    }

    .payment-proof-meta .view-row {
        padding: .45rem .55rem;
        border: 1px solid var(--border-pink-mid);
        border-radius: 10px;
        background: var(--white);
    }

    .proof-image-link {
        display: block;
        border: 1px solid var(--border-pink);
        border-radius: 12px;
        overflow: hidden;
        background: var(--white);
    }

    .proof-image {
        width: 100%;
        max-height: 220px;
        object-fit: contain;
        display: block;
        background: var(--white);
    }

    .proof-empty {
        margin-top: .75rem;
        padding: .8rem;
        border: 1px dashed var(--border-pink);
        border-radius: 12px;
        background: var(--white);
        color: #b77a94;
        font-size: .82rem;
        text-align: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-up { animation: fadeIn .4s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .1s; }
    .d3 { animation-delay: .18s; }
    .d4 { animation-delay: .26s; }

    @media (max-width: 768px) {
        .page-body { padding: 1.2rem 1rem; }
        .overview-strip { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
        .rooms-grid { grid-template-columns: 1fr; }
        .filters-row { gap: .5rem; }
        .search-input-wrap { max-width: 100%; min-width: 140px; }
        .month-header { gap: .5rem; }
        .modal-grid { grid-template-columns: 1fr; }
        .payment-proof-meta { grid-template-columns: 1fr; }
    }

    @media (max-width: 480px) {
        .page-header h1 { font-size: 1.5rem; }
        .overview-strip { grid-template-columns: 1fr 1fr; }
        .filter-select { font-size: .78rem; padding: .5rem .75rem; }
        .search-input { font-size: .78rem; }
        .btn-filter { font-size: .78rem; padding: .5rem .9rem; }
        .btn-outline { font-size: .78rem; padding: .5rem .9rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="fade-up d1">
        <a href="{{ route('billing.index') }}" class="back-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Back to Billing
        </a>
        <div class="page-header" style="margin-top:.25rem;">
            <h1>Billing History</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
    </div>

    @if(count($summaryByMonth) > 0)
    <div class="overview-strip fade-up d2">
        @foreach($summaryByMonth as $mk => $s)
        @php $pct = $s['total_count'] > 0 ? round(($s['paid_count'] / $s['total_count']) * 100) : 0; @endphp
        <div class="overview-card">
            <div class="oc-month">{{ $s['label'] }}</div>
            <div class="oc-bill">&#8369;{{ number_format($s['total_bill'], 0) }}</div>
            <div class="oc-meta">{{ $s['paid_count'] }}/{{ $s['total_count'] }} paid</div>
            <div class="oc-bar-track">
                <div class="oc-bar-fill" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="filters-row fade-up d3">
        <div class="search-input-wrap">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" class="search-input" id="filter-search" placeholder="Search tenant..." value="{{ $search }}">
        </div>
        <select class="filter-select" id="filter-floor">
            <option value="">All Floors</option>
            @foreach($floors as $floor)
                <option value="{{ $floor }}" {{ $selectedFloor == $floor ? 'selected' : '' }}>Floor {{ $floor }}</option>
            @endforeach
        </select>
        <select class="filter-select" id="filter-status">
            <option value="">All Statuses</option>
            <option value="paid"    {{ $selectedStatus === 'paid'    ? 'selected' : '' }}>Paid</option>
            <option value="unpaid"  {{ $selectedStatus === 'unpaid'  ? 'selected' : '' }}>Unpaid</option>
            <option value="overdue" {{ $selectedStatus === 'overdue' ? 'selected' : '' }}>Overdue</option>
            <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        <select class="filter-select" id="filter-month">
            <option value="">All Months</option>
            @foreach($months as $month)
                <option value="{{ $month['key'] }}" {{ $selectedMonth == $month['key'] ? 'selected' : '' }}>
                    {{ $month['label'] }}
                </option>
            @endforeach
        </select>
        <button class="btn-filter" onclick="applyFilters()">Filter</button>
        @if($search || $selectedFloor || $selectedStatus)
        <a href="{{ route('billing.history') }}" class="btn-outline">Clear</a>
        @endif
        <button class="ms-auto btn-outline" onclick="exportAllHistory()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export All
        </button>
    </div>

    <div id="history-content" class="fade-up d4">
        @forelse($historyGroups as $hg)
        <div class="month-block" data-month="{{ $hg['month_key'] }}">
            <div class="month-header" onclick="toggleMonth(this)">
                <span class="month-title">{{ $hg['month_label'] }}</span>
                <span class="month-chip">&#8369;{{ number_format($hg['total_bill'], 0) }}</span>
                <span class="month-chip paid-chip">{{ $hg['paid_count'] }} paid</span>
                @if($hg['unpaid_count'] > 0)
                <span class="month-chip unpaid-chip">{{ $hg['unpaid_count'] }} unpaid</span>
                @endif
                <button class="export-month-btn" onclick="event.stopPropagation(); exportMonth('{{ $hg['month_key'] }}')" title="Export {{ $hg['month_label'] }}">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                </button>
                <div class="month-chevron">
                    <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>
            <div class="month-body">
                @foreach($hg['floor_groups'] as $fg)
                <div class="floor-group">
                    <div class="floor-header">
                        <span class="floor-name">{{ $fg['submeter_label'] }}</span>
                        <span class="floor-chip">{{ $fg['floor_consumption_m3'] }} m&#179;</span>
                        <span class="floor-chip">&#8369;{{ number_format($fg['total_floor_bill'], 2) }}</span>
                        <span class="floor-chip">{{ $fg['room_count'] }} rooms</span>
                        <span class="floor-due">Due: {{ $fg['due_date'] }}</span>
                    </div>
                    <div class="rooms-grid">
                        @foreach($fg['rooms'] as $room)
                        <div class="room-card">
                            <div class="room-card-head">
                                <div class="room-card-left">
                                    <div class="room-number-badge">{{ $room['room_number'] }}</div>
                                    <div class="room-meta-stack">
                                        <span class="room-meta-label">Room {{ $room['room_number'] }}</span>
                                        <span class="room-meta-occ">{{ $room['occupants_in_room'] }} occupant{{ $room['occupants_in_room'] != 1 ? 's' : '' }}</span>
                                    </div>
                                </div>
                                <button class="btn-update" onclick='openHistoryUpdateModal(@json($room), "{{ $hg['month_key'] }}")' title="Edit Status">
                                    <img src="{{ asset('icons/edit.png') }}" alt="Edit">
                                </button>
                            </div>
                            <div class="room-reading-pills">
                                <span class="reading-pill">Prev: {{ number_format($room['prev_reading'], 2) }} m&#179;</span>
                                <span class="reading-pill">Curr: {{ number_format($room['curr_reading'], 2) }} m&#179;</span>
                                <span class="reading-pill">{{ number_format($room['floor_consumption_m3'], 2) }} m&#179; used</span>
                            </div>
                            <div class="tenants-list">
                                @foreach($room['tenants'] as $t)
                                <div class="tenant-row">
                                    <div class="tenant-left">
                                        <span class="dot {{ $t['dot_class'] }}"></span>
                                        <span class="tname">{{ $t['name'] }}</span>
                                    </div>
                                    <div class="tenant-right">
                                        <span class="t-amount">&#8369;{{ number_format($t['room_share'], 2) }}</span>
                                        <span class="badge badge-{{ str_replace(' ', '-', $t['payment_status']) }}">{{ ucfirst($t['payment_status']) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--hot-pink)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4;margin:0 auto;display:block;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div class="empty-state-title">No billing records found</div>
            <div class="empty-state-sub">Try adjusting your filters or log a new billing period.</div>
        </div>
        @endforelse
    </div>

    @if($totalPages > 1)
    <div class="pagination-row fade-up">
        @php
            $prevPage = max(1, $page - 1);
            $nextPage = min($totalPages, $page + 1);
            $queryBase = http_build_query(array_filter([
                'floor'  => $selectedFloor,
                'status' => $selectedStatus,
                'search' => $search,
                'month' => $selectedMonth,
            ]));
        @endphp
        <a href="{{ route('billing.history') }}?{{ $queryBase }}&page={{ $prevPage }}" class="pg-btn {{ $page <= 1 ? 'disabled' : '' }}">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        @for($i = 1; $i <= $totalPages; $i++)
            @if($i === 1 || $i === $totalPages || abs($i - $page) <= 1)
                @if($i > 1 && abs(($i - 1) - $page) > 1 && $i !== 2)
                    <span class="pg-sep">...</span>
                @endif
                <a href="{{ route('billing.history') }}?{{ $queryBase }}&page={{ $i }}" class="pg-btn {{ $i === $page ? 'active' : '' }}">{{ $i }}</a>
            @endif
        @endfor
        <a href="{{ route('billing.history') }}?{{ $queryBase }}&page={{ $nextPage }}" class="pg-btn {{ $page >= $totalPages ? 'disabled' : '' }}">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <span class="pg-sep" style="margin-left:.5rem;font-size:.8rem;">Page {{ $page }} of {{ $totalPages }}</span>
    </div>
    @endif

</div>
@endsection

@section('modals')
<div class="modal-overlay" id="history-update-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Update Payment Status</div>
            <button class="modal-close" onclick="closeModal('history-update-modal')">&#10005;</button>
        </div>
        <div id="history-update-content"></div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('history-update-modal')">Cancel</button>
            <button type="button" class="btn-submit" id="history-save-btn" onclick="saveHistoryStatus()">Save Changes</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const historyData = @json($historyGroups);

function toggleMonth(header) {
    const block = header.closest('.month-block');
    block.classList.toggle('collapsed');
}

function applyFilters() {
    const floor  = document.getElementById('filter-floor').value;
    const status = document.getElementById('filter-status').value;
    const search = document.getElementById('filter-search').value.trim();
    const month = document.getElementById('filter-month').value;

    const params = new URLSearchParams();
    if (floor)  params.set('floor',  floor);
    if (status) params.set('status', status);
    if (month) params.set('month', month);
    if (search) params.set('search', search);
    params.set('page', '1');

    window.location.href = '{{ route("billing.history") }}?' + params.toString();
}

document.getElementById('filter-search').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') applyFilters();
});

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function(c) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c];
    });
}

function openHistoryUpdateModal(room, monthKey) {
    let html = `
        <div style="margin-bottom:1rem;padding:.75rem 1rem;background:var(--pink-bg-soft);border-radius:12px;border:1px solid var(--border-pink);">
            <div style="font-size:.78rem;font-weight:700;color:var(--hot-pink);margin-bottom:.25rem;text-transform:uppercase;letter-spacing:.05em;">Room Details</div>
            <div style="font-size:.88rem;font-weight:600;color:var(--ink-deep);">Room ${escapeHtml(room.room_number)} &mdash; Floor ${escapeHtml(room.floor)}</div>
            <div style="font-size:.78rem;color:var(--ink-soft);margin-top:.2rem;">
                ${escapeHtml(parseFloat(room.floor_consumption_m3 || 0).toFixed(2))} m&#179; consumed &nbsp;&bull;&nbsp; Due: ${escapeHtml(room.due_date)}
            </div>
        </div>
    `;

    room.tenants.forEach(function(t) {
        const referenceCode = t.payment_reference_code ? escapeHtml(t.payment_reference_code) : '&mdash;';
        const submittedAt   = t.payment_submitted_at   ? escapeHtml(t.payment_submitted_at)   : '&mdash;';
        const proofUrl      = t.proof_of_payment_url   ? escapeHtml(t.proof_of_payment_url)   : '';
        const proofHtml     = proofUrl
            ? `<a class="proof-image-link" href="${proofUrl}" target="_blank" rel="noopener">
                   <img src="${proofUrl}" alt="Proof of payment" class="proof-image">
               </a>`
            : `<div class="proof-empty">No proof of payment submitted yet.</div>`;

        html += `
            <div style="margin-top:.85rem;padding:1rem;border:1px solid var(--border-pink-mid);border-radius:14px;background:#fafafa;">
                <div class="view-row">
                    <span class="view-label">Tenant</span>
                    <span class="view-val">${escapeHtml(t.name)}</span>
                </div>
                <div class="view-row">
                    <span class="view-label">Share</span>
                    <span class="view-val">&#8369;${parseFloat(t.room_share || 0).toFixed(2)}</span>
                </div>
                <div class="payment-proof-card">
                    <div class="payment-proof-head">
                        <span>Payment Proof</span>
                        <span class="badge badge-${String(t.payment_status || 'unpaid').replaceAll(' ','-')}">${escapeHtml(t.payment_status || 'unpaid')}</span>
                    </div>
                    <div class="payment-proof-meta">
                        <div class="view-row">
                            <span class="view-label">Reference</span>
                            <span class="view-val">${referenceCode}</span>
                        </div>
                        <div class="view-row">
                            <span class="view-label">Submitted</span>
                            <span class="view-val">${submittedAt}</span>
                        </div>
                    </div>
                    ${proofHtml}
                </div>
                <div class="modal-field" style="margin-top:1rem;">
                    <label>Payment Status</label>
                    <select class="history-status-select" data-billing-id="${escapeHtml(String(t.billing_id ?? ''))}">
                        <option value="unpaid"  ${t.payment_status === 'unpaid'  ? 'selected' : ''}>Unpaid</option>
                        <option value="paid"    ${t.payment_status === 'paid'    ? 'selected' : ''}>Paid</option>
                        <option value="overdue" ${t.payment_status === 'overdue' ? 'selected' : ''}>Overdue</option>
                        <option value="pending" ${t.payment_status === 'pending' ? 'selected' : ''}>Pending</option>
                    </select>
                </div>
            </div>
        `;
    });

    document.getElementById('history-update-content').innerHTML = html;
    openModal('history-update-modal');
}

async function saveHistoryStatus() {
    const selects = document.querySelectorAll('.history-status-select');
    if (!selects.length) return;

    const statusUpdates = Array.from(selects).map(s => ({
        billing_id: parseInt(s.dataset.billingId),
        payment_status: s.value,
    })).filter(u => Number.isInteger(u.billing_id) && u.billing_id > 0);

    if (!statusUpdates.length) {
        showToast('No valid billing records to update.', 'error');
        return;
    }

    const saveBtn = document.getElementById('history-save-btn');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    try {
        const response = await fetch('{{ route("billing.history.updateStatus") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status_updates: statusUpdates })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            saveBtn.textContent = 'Saved!';
            showToast('Payment status updated successfully!', 'success');
            closeModal('history-update-modal');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'Failed to update status.', 'error');
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Changes';
        }
    } catch (err) {
        showToast('Network error. Please try again.', 'error');
        saveBtn.disabled = false;
        saveBtn.textContent = 'Save Changes';
    }
}

function exportMonth(monthKey) {
    const group = historyData.find(g => g.month_key === monthKey);
    if (!group) {
        showToast('No data for this month.', 'error');
        return;
    }

    const rows = [[
        'Billing Month', 'Floor', 'Due Date',
        'Floor Consumption (m3)', 'Total Floor Bill',
        'Room Number', 'Occupants',
        'Tenant', 'Tenant Share', 'Payment Status',
        'Reference Code', 'Payment Submitted At'
    ]];

    group.floor_groups.forEach(fg => {
        fg.rooms.forEach(room => {
            room.tenants.forEach(t => {
                rows.push([
                    group.month_label,
                    fg.floor,
                    fg.due_date,
                    fg.floor_consumption_m3,
                    Number(fg.total_floor_bill || 0).toFixed(2),
                    room.room_number,
                    room.occupants_in_room,
                    t.name,
                    Number(t.room_share || 0).toFixed(2),
                    t.payment_status,
                    t.payment_reference_code || '',
                    t.payment_submitted_at   || ''
                ]);
            });
        });
    });

    downloadCsv(rows, 'water-billing-' + monthKey.slice(0, 7));
    showToast('Exported ' + group.month_label + ' billing data.', 'success');
}

function exportAllHistory() {
    const rows = [[
        'Billing Month', 'Floor', 'Due Date',
        'Floor Consumption (m3)', 'Total Floor Bill',
        'Room Number', 'Occupants',
        'Tenant', 'Tenant Share', 'Payment Status',
        'Reference Code', 'Payment Submitted At'
    ]];

    historyData.forEach(group => {
        group.floor_groups.forEach(fg => {
            fg.rooms.forEach(room => {
                room.tenants.forEach(t => {
                    rows.push([
                        group.month_label,
                        fg.floor,
                        fg.due_date,
                        fg.floor_consumption_m3,
                        Number(fg.total_floor_bill || 0).toFixed(2),
                        room.room_number,
                        room.occupants_in_room,
                        t.name,
                        Number(t.room_share || 0).toFixed(2),
                        t.payment_status,
                        t.payment_reference_code || '',
                        t.payment_submitted_at   || ''
                    ]);
                });
            });
        });
    });

    if (rows.length === 1) {
        showToast('No billing data to export.', 'error');
        return;
    }

    downloadCsv(rows, 'water-billing-history-all');
    showToast('Full history exported as CSV.', 'success');
}

function downloadCsv(rows, filename) {
    const csv  = rows.map(r => r.map(v => '"' + String(v ?? '').replace(/"/g, '""') + '"').join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = filename + '.csv';
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(a.href);
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(function(m) {
    m.addEventListener('click', function(e) {
        if (e.target === m) m.classList.remove('open');
    });
});

function showToast(msg, type) {
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg;
    t.className = 'toast ' + (type || '');
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3200);
}

@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session("success") }}', 'success');
    });
@endif
</script>
@endsection