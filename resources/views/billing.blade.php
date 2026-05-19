@extends('layout')

@section('title', 'DormEase: Water Billing')
@section('page-title', 'Water Billing')

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

    .stats-card {
        background: var(--gradient-pink);
        border-radius: 24px;
        border: none;
        box-shadow: var(--shadow-stats);
        padding: 2rem 1.5rem;
        display: flex;
        align-items: stretch;
        justify-content: stretch;
        gap: 0;
        flex-wrap: wrap;
        width: 100%;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        flex: 1;
        justify-content: center;
        min-width: 200px;
        padding: .5rem 2rem;
    }

    .stat-icon-circle {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,.25);
    }

    .icon-md {
        width: 50px;
        height: 50px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
    }

    .stat-label { font-size: .85rem; color: #ffe3ef; font-weight: 500; }
    .stat-num   { font-size: 2.2rem; font-weight: 700; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-sub   { font-size: .78rem; color: #fff0f7; font-weight: 600; margin-top: .2rem; }

    .stat-divider {
        width: 1px;
        background: rgba(255,255,255,.25);
        align-self: stretch;
        flex-shrink: 0;
        margin: .5rem 0;
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
        transition: var(--ease);
        box-shadow: var(--shadow);
    }

    .filter-select:focus { border-color: var(--bright-pink); }

    .btn-filter,
    .btn-primary {
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
        transition: var(--ease);
        box-shadow: var(--shadow-pink-btn);
    }

    .btn-filter:hover,
    .btn-primary:hover { transform: translateY(-1px); }

    .btn-outline {
        display: flex;
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
        transition: var(--ease);
        box-shadow: var(--shadow);
    }

    .btn-outline:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .btn-outline .export-icon {
        width: 1rem;
        height: 1rem;
        object-fit: contain;
        flex-shrink: 0;
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
        transition: transform .15s;
    }

    .btn-outline:hover .export-icon { transform: translateY(-1px); }

    .ms-auto { margin-left: auto; }

    .floor-group {
        background: var(--white);
        border-radius: 20px;
        border: 1.5px solid var(--bright-pink);
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-pink-card);
    }

    .floor-header {
        padding: .7rem 1.2rem;
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
        background: var(--white);
        border-bottom: 1.5px solid var(--bright-pink);
    }

    .floor-name {
        font-size: .8rem;
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
        font-size: .7rem;
        font-weight: 700;
        background: rgba(255,255,255,.6);
        color: var(--black);
        border: 1px solid rgba(255,105,155,.2);
    }

    .floor-due {
        font-size: .72rem;
        font-weight: 700;
        color: var(--black);
        margin-left: auto;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1px;
        background: var(--border-pink-mid);
    }

    .room-card {
        background: var(--white);
        padding: .85rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0;
        transition: background .12s;
    }

    .room-card:hover { background: var(--pink-bg-soft); }

    .room-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .6rem;
        gap: .5rem;
    }

    .room-card-left {
        display: flex;
        align-items: center;
        gap: .55rem;
    }

    .room-number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .01em;
        flex-shrink: 0;
    }

    .room-meta-stack { display: flex; flex-direction: column; gap: 0; }

    .room-meta-label {
        font-size: .8rem;
        font-weight: 700;
        color: var(--bright-pink);
        line-height: 1.2;
    }

    .room-meta-occ {
        font-size: .68rem;
        font-weight: 500;
        color: var(--ink-soft);
    }

    .btn-update {
        padding: .26rem .65rem;
        border-radius: 8px;
        background: var(--gradient-pink);
        color: var(--white);
        border: none;
        font-size: .7rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--ease);
        white-space: nowrap;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(255,79,147,.18);
    }

    .btn-update:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(255,79,147,.28);
    }

    .tenants-list {
        display: flex;
        flex-direction: column;
        gap: 0;
        border-top: 1px solid var(--border-pink-mid);
    }

    .tenant-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .38rem 0;
        gap: .5rem;
    }

    .tenant-row + .tenant-row {
        border-top: 1px dashed rgba(255,150,180,.18);
    }

    .tenant-left {
        display: flex;
        align-items: center;
        gap: .4rem;
        min-width: 0;
        flex: 1;
    }

    .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dot-green  { background: #2ec27e; }
    .dot-orange { background: #f0a500; }
    .dot-red    { background: #ff5d73; }
    .dot-gray   { background: #bbb; }

    .tname {
        font-size: .8rem;
        font-weight: 500;
        color: var(--ink-deep);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tenant-right {
        display: flex;
        align-items: center;
        gap: .45rem;
        flex-shrink: 0;
    }

    .t-amount {
        font-size: .78rem;
        font-weight: 700;
        color: var(--hot-pink);
        white-space: nowrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .12rem .45rem;
        border-radius: 999px;
        font-size: .6rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-paid       { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
    .badge-unpaid     { background: #fff6dc; color: #c58a00; border: 1px solid #f2cd63; }
    .badge-overdue    { background: #ffe9ee; color: #e04867; border: 1px solid #ff9db0; }
    .badge-pending    { background: #edf1ff; color: #5570ff; border: 1px solid #b6c2ff; }
    .badge-not-billed { background: #f5f5f5; color: #999;    border: 1px solid #ddd; }

    .empty-floor {
        padding: 1.5rem;
        text-align: center;
        color: var(--ink-soft);
        font-size: .88rem;
        grid-column: 1 / -1;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-up { animation: fadeIn .45s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s; }
    .d4 { animation-delay: .28s; }

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
        transition: var(--ease);
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
        transition: var(--ease);
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

    #log-modal .modal {
        padding: 0;
        border-radius: 28px;
        overflow: hidden;
        max-width: 640px;
    }

    .log-modal-header {
        padding: 1.5rem 1.8rem 1.3rem;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        color: var(--hot-pink);
    }

    .log-modal-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        pointer-events: none;
    }

    .log-modal-header::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 40px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        pointer-events: none;
    }

    .log-header-left {
        display: flex;
        align-items: center;
        gap: .75rem;
        position: relative;
        z-index: 1;
    }

    .log-header-title { font-size: 1.13rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.15; color: var(--hot-pink); }
    .log-header-sub   { font-size: .76rem; color: var(--hot-pink); font-weight: 600; margin-top: .15rem; }

    #log-modal .modal-close {
        position: relative;
        z-index: 1;
        width: 32px; height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.28);
        color: var(--ink-soft);
        font-size: .85rem;
        display: flex; align-items: center; justify-content: center;
        transition: background .18s;
        flex-shrink: 0;
    }

    #log-modal .modal-close:hover { background: rgba(255,255,255,.28); }

    .log-modal-body {
        padding: 1.5rem 1.8rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        max-height: 62vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--pink-200) transparent;
    }

    .log-modal-body::-webkit-scrollbar { width: 5px; }
    .log-modal-body::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 20px; }

    .section-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .71rem;
        font-weight: 800;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .09em;
        margin-bottom: -.2rem;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border-pink);
        margin-left: .3rem;
    }

    #log-modal .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; align-items: start; }
    #log-modal .modal-field { display: flex; flex-direction: column; gap: .3rem; }
    #log-modal .modal-field.full { grid-column: 1 / -1; }

    #log-modal .modal-field label { font-size: .74rem; font-weight: 700; color: var(--ink-soft); letter-spacing: .02em; margin-bottom: 0; }

    #log-modal .modal-field input,
    #log-modal .modal-field select {
        padding: .6rem .9rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-pink);
        background: var(--pink-bg-soft);
        font-size: .85rem;
        color: var(--ink-deep);
        transition: border-color .18s, box-shadow .18s;
    }

    #log-modal .modal-field input:focus,
    #log-modal .modal-field select:focus {
        border-color: var(--hot-pink);
        box-shadow: 0 0 0 3px rgba(232,23,93,.1);
        background: var(--white);
    }

    .rate-preview-box {
        grid-column: 1 / -1;
        display: none;
        align-items: center;
        gap: .6rem;
        padding: .65rem 1rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--pink-50) 0%, var(--petal) 100%);
        border: 1.5px solid var(--pink-200);
    }

    .rate-preview-box.visible { display: flex; }

    .rate-preview-box::before {
        content: '';
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--hot-pink);
        flex-shrink: 0;
        animation: rateBlip 1.6s infinite;
    }

    @keyframes rateBlip {
        0%,100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.5); opacity: .6; }
    }

    .rate-preview-box > span:first-of-type { font-size: .82rem; color: var(--ink-soft); font-weight: 600; }
    .rate-preview-box > span:first-of-type strong { color: var(--hot-pink); font-weight: 800; }
    .rate-preview-box > span:last-of-type { font-size: .75rem; color: #c8708a; margin-left: auto; }

    .floor-readings-list { grid-column: 1 / -1; display: flex; flex-direction: column; gap: .7rem; }

    .floor-reading-row {
        background: var(--pink-bg-page);
        border: 1.5px solid var(--border-pink);
        border-radius: 16px;
        padding: .9rem 1rem;
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr 1fr auto;
        gap: .6rem;
        align-items: end;
        transition: border-color .18s, box-shadow .18s;
    }

    .floor-reading-row:hover { border-color: var(--mid-pink); box-shadow: 0 4px 14px rgba(232,23,93,.08); }

    .frr-label { font-size: .69rem; font-weight: 700; color: var(--ink-soft); text-transform: uppercase; letter-spacing: .06em; margin-bottom: .26rem; }

    .floor-reading-row input,
    .floor-reading-row select {
        padding: .55rem .75rem;
        border-radius: 10px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        font-size: .82rem;
        color: var(--ink-deep);
        outline: none;
        transition: border-color .18s;
        width: 100%;
        box-sizing: border-box;
        font-family: inherit;
    }

    .floor-reading-row input:focus,
    .floor-reading-row select:focus { border-color: var(--hot-pink); }

    .floor-reading-row input:disabled { background: var(--pink-bg-soft); color: #c08090; }

    .floor-bill-preview {
        display: inline-flex;
        align-items: center;
        padding: .28rem .65rem;
        border-radius: 999px;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .71rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .btn-remove-floor {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--white);
        border: 1.5px solid var(--border-pink);
        color: #e04870;
        font-size: .75rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: var(--ease);
        font-family: inherit;
    }

    .btn-remove-floor:hover { background: var(--pink-50); border-color: var(--bright-pink); }

    .tenant-pill {
        grid-column: 1 / -1;
        font-size: .72rem;
        font-weight: 700;
        color: var(--ink-soft);
        background: var(--petal);
        border-radius: 999px;
        padding: .22rem .8rem;
        width: fit-content;
        margin-top: -.15rem;
    }

    .btn-add-floor {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        padding: .65rem;
        border-radius: 12px;
        border: 1.5px dashed var(--pink-200);
        background: transparent;
        color: var(--hot-pink);
        font-size: .83rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--ease);
        font-family: inherit;
        width: 100%;
        box-sizing: border-box;
        margin-top: .1rem;
    }

    .btn-add-floor:hover { background: var(--pink-50); border-color: var(--hot-pink); }

    .log-modal-footer {
        padding: 1rem 1.8rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .7rem;
        justify-content: flex-end;
        border-top: 1px solid var(--border-pink-mid);
        background: var(--pink-bg-soft);
    }

    #log-modal .btn-cancel { padding: .62rem 1.3rem; border-radius: 12px; border: 1.5px solid var(--border-pink); background: var(--white); color: var(--ink-soft); font-size: .86rem; font-weight: 700; cursor: pointer; transition: var(--ease); }
    #log-modal .btn-cancel:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    #log-modal .btn-submit { padding: .62rem 1.6rem; border-radius: 12px; border: none; background: var(--gradient-pink); color: var(--white); font-size: .86rem; font-weight: 800; cursor: pointer; transition: var(--ease); box-shadow: 0 6px 18px rgba(232,23,93,.28); }
    #log-modal .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(232,23,93,.35); }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <h1>Water Billing</h1>
        <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
    </div>

    <div class="stats-card fade-up d2">
        <div class="stat-item">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/billing.png') }}" class="icon-md" alt="billing">
            </div>
            <div>
                <div class="stat-label">Water Consumption</div>
                <div class="stat-num">₱ {{ number_format($totalBill, 0) }}</div>
                <div class="stat-sub">This Month</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/pending.png') }}" class="icon-md" alt="unpaid">
            </div>
            <div>
                <div class="stat-label">Unpaid Tenants</div>
                <div class="stat-num">{{ $unpaidCount }}</div>
                <div class="stat-sub">Out of {{ $totalTenants }} tenants</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/warn.png') }}" class="icon-md" alt="overdue">
            </div>
            <div>
                <div class="stat-label">Overdue Tenants</div>
                <div class="stat-num">{{ $overdueCount }}</div>
                <div class="stat-sub">Out of {{ $totalTenants }} tenants</div>
            </div>
        </div>
    </div>

    <div class="filters-row fade-up d3">
        <select class="filter-select" id="filter-floor" onchange="applyFloorFilter()">
            <option value="">All Floors</option>
            @foreach($floors as $floor)
                <option value="{{ $floor }}" {{ $selectedFloor == $floor ? 'selected' : '' }}>
                    Floor {{ $floor }}
                </option>
            @endforeach
        </select>
        <select class="filter-select" id="filter-month" onchange="applyMonthFilter()">
            @foreach($months as $m)
                <option value="{{ $m['value'] }}" {{ $m['selected'] ? 'selected' : '' }}>
                    {{ $m['label'] }}
                </option>
            @endforeach
        </select>
        <button class="btn-filter" onclick="applyMonthFilter()">≡ Filter</button>
        <button class="ms-auto btn-primary" onclick="openLogModal()">Log Water Consumption</button>
        <button class="btn-outline" onclick="exportBilling()">
            <img src="{{ asset('icons/export.png') }}" alt="" class="export-icon">
            Export
        </button>
    </div>

    <div id="billing-groups" class="fade-up d4">
        @forelse($billingGroups as $group)
        <div class="floor-group" data-floor="{{ $group['floor'] }}">

            <div class="floor-header">
                <span class="floor-name">{{ $group['submeter_label'] }}</span>
                <span class="floor-chip">{{ $group['floor_consumption_m3'] }} m³</span>
                <span class="floor-chip">₱{{ number_format($group['total_floor_bill'], 2) }}</span>
                <span class="floor-chip">{{ $group['room_count'] }} rooms</span>
                @if($group['past_due_count'] > 0)
                    <span class="floor-chip" style="background:#ffe9ee;color:#e04867;border-color:#ffb3c1;">{{ $group['past_due_count'] }} past due</span>
                @endif
                <span class="floor-due">Due {{ $group['due_date'] }}</span>
            </div>

            <div class="rooms-grid">
                @forelse($group['rooms'] as $room)
                <div class="room-card">
                    <div class="room-card-head">
                        <div class="room-card-left">
                            <div class="room-number-badge">{{ $room['room_number'] }}</div>
                            <div class="room-meta-stack">
                                <span class="room-meta-label">Room {{ $room['room_number'] }}</span>
                                <span class="room-meta-occ">{{ $room['occupants_in_room'] }} occupant{{ $room['occupants_in_room'] != 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                        <button class="btn-update" onclick='openUpdateModal(@json($room))'>View</button>
                    </div>
                    <div class="tenants-list">
                        @foreach($room['tenants'] as $t)
                        <div class="tenant-row">
                            <div class="tenant-left">
                                <span class="dot {{ $t['dot_class'] }}"></span>
                                <span class="tname">{{ $t['name'] }}</span>
                            </div>
                            <div class="tenant-right">
                                <span class="t-amount">₱{{ number_format($t['room_share'], 2) }}</span>
                                <span class="badge badge-{{ str_replace(' ', '-', $t['payment_status']) }}">{{ ucfirst($t['payment_status']) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="empty-floor">No rooms found for this floor.</div>
                @endforelse
            </div>

        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--ink-muted);">No billing data for this period.</div>
        @endforelse
    </div>

</div>
@endsection

@section('modals')

<div class="modal-overlay" id="log-modal">
    <div class="modal" style="max-width:640px;">

        <div class="log-modal-header">
            <div class="log-header-left">
                <div>
                    <div class="log-header-title">Log Water Consumption</div>
                    <div class="log-header-sub">Sanctissimo Rosario Ladies Dormitory</div>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('log-modal')">✕</button>
        </div>

        <form method="POST" action="{{ route('billing.log') }}" id="log-form">
            @csrf
            <div class="log-modal-body">

                <div class="section-label">Billing Period</div>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>Billing Month</label>
                        <input type="date" name="billing_month" id="log-billing-month" required value="{{ now()->format('Y-m-01') }}">
                    </div>
                    <div class="modal-field">
                        <label>Due Date</label>
                        <input type="date" name="due_date" id="log-due-date" required>
                    </div>
                </div>

                <div class="section-label">Maynilad Bill (Mother Meter)</div>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>Total Cubic Meters (m³)</label>
                        <input type="number" step="0.01" min="0.01" name="maynilad_total_m3" id="log-maynilad-m3" placeholder="e.g. 120.00" required oninput="recalcRate()">
                    </div>
                    <div class="modal-field">
                        <label>Total Amount Due (₱)</label>
                        <input type="number" step="0.01" min="0.01" name="maynilad_total_amount" id="log-maynilad-amount" placeholder="e.g. 4,800.00" required oninput="recalcRate()">
                    </div>
                    <div class="rate-preview-box" id="rate-preview-box">
                        <span>Rate per m³: <strong id="rp-rate">—</strong></span>
                        <span>= Total Amount ÷ Total m³ (from Maynilad bill)</span>
                    </div>
                </div>

                <div class="section-label">Floor Submeter Readings</div>
                <div class="modal-grid">
                    <div class="floor-readings-list" id="floor-readings-list"></div>
                    <button type="button" class="btn-add-floor" id="btn-add-floor" onclick="addFloorRow()">＋ Add Floor Reading</button>
                </div>

            </div>

            <div class="log-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('log-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Log &amp; Distribute →</button>
            </div>
        </form>

    </div>
</div>

<div class="modal-overlay" id="update-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Update / View Billing</div>
            <button class="modal-close" onclick="closeModal('update-modal')">✕</button>
        </div>
        <form id="update-form">
            @csrf
            <div id="update-content"></div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('update-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>

function setButtonLoading(btn, loadingText) {
    btn.disabled = true;
    btn.classList.add('loading');
    btn.innerHTML = `<span class="btn-spinner"></span>${loadingText}`;
}

function resetButton(btn, originalText) {
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.textContent = originalText;
}

const tenantsByFloor = @json(
    $allTenants->groupBy('floor')->map(fn($tenants) =>
        $tenants->map(fn($t) => [
            'name'        => $t->first_name . ' ' . $t->last_name,
            'room_number' => $t->room_number,
        ])->values()
    )
);

const activeFloors   = @json($activeFloors->values());
const unloggedFloors = @json($unloggedFloors->values());

function recalcRate() {
    const m3     = parseFloat(document.getElementById('log-maynilad-m3')?.value)     || 0;
    const amount = parseFloat(document.getElementById('log-maynilad-amount')?.value) || 0;
    const box    = document.getElementById('rate-preview-box');
    const rp     = document.getElementById('rp-rate');

    if (m3 > 0 && amount > 0) {
        const rate = amount / m3;
        rp.textContent = '₱' + rate.toFixed(4) + ' / m³';
        box.classList.add('visible');
        document.querySelectorAll('.floor-reading-row').forEach(row => recalcFloorRow(row));
    } else {
        box.classList.remove('visible');
    }
}

let floorRowIdx = 0;

function addFloorRow(defaultFloor) {
    const list   = document.getElementById('floor-readings-list');
    const idx    = floorRowIdx++;
    const floors = activeFloors;

    let opts = floors.map(f => {
        const warned = unloggedFloors.includes(f) ? '' : ' ✓';
        const sel    = (defaultFloor && f == defaultFloor) ? ' selected' : '';
        return `<option value="${f}"${sel}>Floor ${f}${warned}</option>`;
    }).join('');

    const row = document.createElement('div');
    row.className = 'floor-reading-row';
    row.dataset.idx = idx;
    row.innerHTML = `
        <div>
            <div class="frr-label">Floor</div>
            <select name="floor_readings[${idx}][floor]" class="frr-floor-sel"
                    style="width:100%;padding:.55rem .5rem;border-radius:8px;border:1.5px solid var(--gray-light);font-size:.83rem;font-family:var(--ff-body);background:var(--white);outline:none;"
                    onchange="updateFloorPreview(this)" required>
                <option value="">—</option>
                ${opts}
            </select>
        </div>
        <div>
            <div class="frr-label">Prev Reading (m³)</div>
            <input type="number" step="0.01" min="0"
                   name="floor_readings[${idx}][prev]"
                   placeholder="0.00" required
                   oninput="recalcFloorRow(this.closest('.floor-reading-row'))">
        </div>
        <div>
            <div class="frr-label">Curr Reading (m³)</div>
            <input type="number" step="0.01" min="0"
                   name="floor_readings[${idx}][curr]"
                   placeholder="0.00" required
                   oninput="recalcFloorRow(this.closest('.floor-reading-row'))">
        </div>
        <div>
            <div class="frr-label">Consumption</div>
            <input type="text" disabled placeholder="—" class="frr-consumption">
        </div>
        <div style="display:flex;flex-direction:column;gap:.4rem;align-items:center;">
            <span class="floor-bill-preview frr-bill-preview">—</span>
            <button type="button" class="btn-remove-floor" onclick="removeFloorRow(this)" title="Remove">✕</button>
        </div>
    `;

    const pillDiv = document.createElement('div');
    pillDiv.style.cssText = 'grid-column:1/-1;margin-top:-.3rem;';
    pillDiv.innerHTML = `<span class="tenant-pill frr-tenant-pill" style="display:none;"></span>`;
    row.appendChild(pillDiv);

    list.appendChild(row);

    if (defaultFloor) {
        const sel = row.querySelector('.frr-floor-sel');
        sel.value = defaultFloor;
        updateFloorPreview(sel);
    }
}

function removeFloorRow(btn) {
    btn.closest('.floor-reading-row').remove();
}

function updateFloorPreview(sel) {
    const row   = sel.closest('.floor-reading-row');
    const floor = sel.value;
    const pill  = row.querySelector('.frr-tenant-pill');

    if (!floor || !tenantsByFloor[floor]) {
        pill.style.display = 'none';
        return;
    }

    const count = tenantsByFloor[floor].length;
    pill.textContent = `${count} tenant${count !== 1 ? 's' : ''} on Floor ${floor}`;
    pill.style.display = 'inline-flex';

    recalcFloorRow(row);
}

function recalcFloorRow(row) {
    const m3        = parseFloat(document.getElementById('log-maynilad-m3')?.value)     || 0;
    const amount    = parseFloat(document.getElementById('log-maynilad-amount')?.value) || 0;
    const ratePerM3 = m3 > 0 ? amount / m3 : 0;

    const prevInput = row.querySelector('[name$="[prev]"]');
    const currInput = row.querySelector('[name$="[curr]"]');
    const consInput = row.querySelector('.frr-consumption');
    const billSpan  = row.querySelector('.frr-bill-preview');
    const floorSel  = row.querySelector('.frr-floor-sel');

    const prev        = parseFloat(prevInput?.value) || 0;
    const curr        = parseFloat(currInput?.value) || 0;
    const consumption = Math.max(0, curr - prev);

    if (consInput) consInput.value = consumption.toFixed(2) + ' m³';

    if (billSpan && ratePerM3 > 0) {
        const floorBill   = consumption * ratePerM3;
        const floor       = floorSel?.value;
        const tenantCount = (floor && tenantsByFloor[floor]) ? tenantsByFloor[floor].length : 0;
        const perHead     = tenantCount > 0 ? floorBill / tenantCount : 0;

        billSpan.textContent = tenantCount > 0
            ? `₱${floorBill.toFixed(2)} · ₱${perHead.toFixed(2)}/head`
            : `₱${floorBill.toFixed(2)}`;
    } else if (billSpan) {
        billSpan.textContent = '—';
    }
}

function openLogModal() {
    document.getElementById('floor-readings-list').innerHTML = '';
    floorRowIdx = 0;
    const toAdd = unloggedFloors.length > 0 ? unloggedFloors : [activeFloors[0] ?? ''];
    toAdd.forEach(f => addFloorRow(f));
    openModal('log-modal');
}

function applyFloorFilter() {
    const floor = document.getElementById('filter-floor').value;
    document.querySelectorAll('.floor-group').forEach(g => {
        g.style.display = (!floor || g.dataset.floor == floor) ? '' : 'none';
    });
}

function applyMonthFilter() {
    const month = document.getElementById('filter-month').value;
    const floor = document.getElementById('filter-floor').value;
    let url = "{{ route('billing.index') }}?month=" + month;
    if (floor) url += '&floor=' + floor;
    window.location.href = url;
}

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function(char) {
        return { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;' }[char];
    });
}

function openUpdateModal(room) {
    let html = `
        <div class="modal-grid" style="margin-bottom:1rem;">
            <div class="modal-field">
                <label>Room</label>
                <input type="text" value="${room.room_number}" disabled>
            </div>
            <div class="modal-field">
                <label>Floor</label>
                <input type="text" value="${room.floor}" disabled>
            </div>
            <div class="modal-field">
                <label>Previous Reading (m³)</label>
                <input type="number" step="0.01" id="edit-prev" value="${parseFloat(room.prev_reading ?? 0).toFixed(2)}" oninput="recalcUpdateShare()">
            </div>
            <div class="modal-field">
                <label>Current Reading (m³)</label>
                <input type="number" step="0.01" id="edit-curr" value="${parseFloat(room.curr_reading ?? 0).toFixed(2)}" oninput="recalcUpdateShare()">
            </div>
            <div class="modal-field">
                <label>Floor Consumption (m³)</label>
                <input type="text" id="edit-consumption" value="${parseFloat(room.floor_consumption_m3 ?? 0).toFixed(2)}" disabled>
            </div>
            <div class="modal-field">
                <label>Total Floor Bill (₱)</label>
                <input type="text" id="edit-total-bill" value="${parseFloat(room.total_floor_bill ?? 0).toFixed(2)}" disabled>
            </div>
            <div class="modal-field">
                <label>Per Tenant Share (₱)</label>
                <input type="text" id="edit-room-share" value="${parseFloat(room.tenants[0]?.room_share ?? 0).toFixed(2)}" disabled>
            </div>
            <div class="modal-field">
                <label>Due Date</label>
                <input type="date" id="edit-due-date" value="${room.due_date !== '—' ? new Date(room.due_date).toISOString().split('T')[0] : ''}">
            </div>
        </div>
    `;

    room.tenants.forEach(function(t) {
        const referenceCode = t.payment_reference_code ? escapeHtml(t.payment_reference_code) : '—';
        const submittedAt   = t.payment_submitted_at   ? escapeHtml(t.payment_submitted_at)   : '—';
        const proofUrl      = t.proof_of_payment_url   ? escapeHtml(t.proof_of_payment_url)   : '';
        const proofHtml     = proofUrl
            ? `<a class="proof-image-link" href="${proofUrl}" target="_blank" rel="noopener">
                   <img src="${proofUrl}" alt="Proof of payment for ${escapeHtml(t.name)}" class="proof-image">
               </a>`
            : `<div class="proof-empty">No proof of payment submitted yet.</div>`;

        html += `
            <div style="margin-top:1rem;padding:1rem;border:1px solid var(--border);border-radius:12px;background:#fafafa;">
                <div class="view-row">
                    <span class="view-label">Tenant</span>
                    <span class="view-val">${escapeHtml(t.name)}</span>
                </div>
                <div class="view-row">
                    <span class="view-label">Share</span>
                    <span class="view-val tenant-share-display">₱${parseFloat(t.room_share).toFixed(2)}</span>
                </div>
                <div class="payment-proof-card">
                    <div class="payment-proof-head">
                        <span>Payment Proof</span>
                        <span class="badge badge-${String(t.payment_status || 'unpaid').replaceAll(' ', '-')}">${escapeHtml(t.payment_status || 'unpaid')}</span>
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
                    <select class="status-select" data-billing-id="${t.billing_id ?? ''}">
                        <option value="unpaid"  ${t.payment_status === 'unpaid'  ? 'selected' : ''}>Unpaid</option>
                        <option value="paid"    ${t.payment_status === 'paid'    ? 'selected' : ''}>Paid</option>
                        <option value="overdue" ${t.payment_status === 'overdue' ? 'selected' : ''}>Overdue</option>
                        <option value="pending" ${t.payment_status === 'pending' ? 'selected' : ''}>Pending</option>
                    </select>
                </div>
            </div>
        `;
    });

    document.getElementById('update-form').dataset.billingId = room.tenants[0]?.billing_id ?? '';
    document.getElementById('update-content').innerHTML = html;
    openModal('update-modal');
}

function recalcUpdateShare() {
    const prev        = parseFloat(document.getElementById('edit-prev')?.value) || 0;
    const curr        = parseFloat(document.getElementById('edit-curr')?.value) || 0;
    const consumption = Math.max(0, curr - prev);
    if (document.getElementById('edit-consumption'))
        document.getElementById('edit-consumption').value = consumption.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('update-form');
    if (updateForm) {
        updateForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const saveBtn        = updateForm.querySelector('.btn-submit');
            const billing_id     = this.dataset.billingId;
            const prev_reading   = document.getElementById('edit-prev').value;
            const curr_reading   = document.getElementById('edit-curr').value;
            const due_date       = document.getElementById('edit-due-date').value;
            const statusSelects  = updateForm.querySelectorAll('.status-select');
            const firstSelect    = statusSelects[0];
            const payment_status = firstSelect ? firstSelect.value : 'unpaid';
            const status_updates = Array.from(statusSelects)
                .map(select => ({
                    billing_id: parseInt(select.dataset.billingId),
                    payment_status: select.value,
                }))
                .filter(update => Number.isInteger(update.billing_id));

            if (!billing_id) {
                showToast('No billing record found.', 'error');
                return;
            }

            setButtonLoading(saveBtn, 'Saving...');

            try {
                const response = await fetch("{{ route('billing.updateFull') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        billing_id     : parseInt(billing_id),
                        prev_reading   : parseFloat(prev_reading),
                        curr_reading   : parseFloat(curr_reading),
                        due_date       : due_date,
                        payment_status : payment_status,
                        status_updates : status_updates,
                    })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    saveBtn.innerHTML = `<span style="font-size:1rem;">✓</span> Saved!`;
                    showToast('Billing updated successfully!', 'success');
                    closeModal('update-modal');
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast(data.message || 'Failed to update.', 'error');
                    resetButton(saveBtn, 'Save Changes');
                }
            } catch (err) {
                showToast('Network error.', 'error');
                resetButton(saveBtn, 'Save Changes');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const logForm = document.getElementById('log-form');
    if (!logForm) return;

    logForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitBtn = logForm.querySelector('.btn-submit');

        const m3     = parseFloat(document.getElementById('log-maynilad-m3')?.value);
        const amount = parseFloat(document.getElementById('log-maynilad-amount')?.value);

        if (!m3 || !amount || m3 <= 0 || amount <= 0) {
            showToast('Please enter valid Maynilad bill figures.', 'error');
            return;
        }

        const rows = document.querySelectorAll('.floor-reading-row');
        if (rows.length === 0) {
            showToast('Please add at least one floor reading.', 'error');
            return;
        }

        let valid = true;
        rows.forEach(row => {
            const floorSel = row.querySelector('.frr-floor-sel');
            const prev     = parseFloat(row.querySelector('[name$="[prev]"]')?.value) || 0;
            const curr     = parseFloat(row.querySelector('[name$="[curr]"]')?.value) || 0;

            if (!floorSel?.value) {
                showToast('Please select a floor for every reading row.', 'error');
                valid = false;
            }
            if (curr < prev) {
                showToast(`Floor ${floorSel?.value || ''}: Current reading cannot be less than previous.`, 'error');
                valid = false;
            }
        });
        if (!valid) return;

        setButtonLoading(submitBtn, 'Logging...');

        try {
            const response = await fetch("{{ route('billing.log') }}", {
                method  : 'POST',
                headers : {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body    : new FormData(logForm),
            });

            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Non-JSON response from server:', text);
                showToast('Unexpected server response. Check Laravel logs.', 'error');
                resetButton(submitBtn, 'Log & Distribute');
                return;
            }

            const data = await response.json();

            if (response.ok && data.success) {
                submitBtn.innerHTML = `<span style="font-size:1rem;">✓</span> Done!`;
                showToast('✓ ' + (data.message || 'Water billing logged successfully!'), 'success');

                const billingMonth = document.getElementById('log-billing-month').value;
                const monthForUrl  = billingMonth.substring(0, 7) + '-01';
                const floor        = document.getElementById('filter-floor').value;
                let   url          = "{{ route('billing.index') }}?month=" + monthForUrl;
                if (floor) url    += '&floor=' + floor;

                setTimeout(() => { window.location.href = url; }, 1000);

            } else {
                const msg = data.message || data.errors
                    ? (data.message || Object.values(data.errors).flat().join(' '))
                    : 'Failed to log billing. Please check your inputs.';
                showToast(msg, 'error');
                resetButton(submitBtn, 'Log & Distribute');
            }

        } catch (err) {
            console.error('Fetch error:', err);
            showToast('Network error — please try again.', 'error');
            resetButton(submitBtn, 'Log & Distribute');
        }
    });
});

function exportBilling() {
    showToast('Billing data exported!', 'success');
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