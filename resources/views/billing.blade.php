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
        font-size: .85rem;
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
        font-size: .75rem;
        font-weight: 700;
        background: rgba(255,255,255,.6);
        color: var(--black);
        border: 1px solid rgba(255,105,155,.2);
    }

    .floor-summary-chip {
        background: #fff0f6;
        color: #191617;
        border-color: #ffc7dc;
        box-shadow: 0 3px 10px rgba(255,79,147,.08);
    }

    .floor-due {
        font-size: .75rem;
        font-weight: 700;
        color: var(--black);
        margin-left: auto;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 0;
        background: var(--border-pink-mid);
        border-top: 2px solid #ff8fbc;
    }

    .room-card {
        background: var(--white);
        padding: 1.15rem;
        display: flex;
        flex-direction: column;
        gap: 0;
        transition: all .15s ease;
        border-right: 2px solid #ff8fbc;
        border-bottom: 2px solid #ff8fbc;
        position: relative;
    }

    .room-card:hover { background: var(--pink-bg-soft); z-index: 2; box-shadow: 0 6px 18px rgba(232,23,93,.12); }

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
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: .01em;
        flex-shrink: 0;
    }

    .room-meta-stack { display: flex; flex-direction: column; gap: 0; }

    .room-meta-label {
        font-size: .95rem;
        font-weight: 700;
        color: var(--bright-pink);
        line-height: 1.2;
    }

    .room-meta-occ {
        font-size: .8rem;
        font-weight: 500;
        color: var(--ink-soft);
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
        gap: 0;
        border-top: 1px solid var(--border-pink-mid);
    }

    .tenant-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .5rem 0;
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
        font-size: .85rem;
        font-weight: 700;
        color: var(--hot-pink);
        white-space: nowrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .18rem .55rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-paid       { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
    .badge-unpaid     { background: #fff6dc; color: #c58a00; border: 1px solid #f2cd63; }
    .badge-overdue    { background: #ffe9ee; color: #e04867; border: 1px solid #ff9db0; }
    .badge-pending    { background: #edf1ff; color: #5570ff; border: 1px solid #b6c2ff; }
    .badge-not-billed { background: #f5f5f5; color: #999;    border: 1px solid #ddd; }
    .badge-rejected   { background: #fff3eb; color: #c94a00; border: 1px solid #ffb380; }
    .badge-pending-tenant  { background: #edf1ff; color: #5570ff; border: 1px solid #b6c2ff; }
    .badge-inactive-tenant { background: #fff0f0; color: #e04867; border: 1px solid var(--pink-200); }

    .rejection-reason-wrap {
        overflow: hidden;
        max-height: 0;
        transition: max-height .25s ease, opacity .25s ease, margin .25s ease;
        opacity: 0;
        margin-top: 0;
    }
    .rejection-reason-wrap.visible {
        max-height: 120px;
        opacity: 1;
        margin-top: .6rem;
    }
    .rejection-reason-input {
        width: 100%;
        padding: .55rem .8rem;
        border-radius: 10px;
        border: 1.5px solid #ffb380;
        background: #fff8f4;
        font-size: .82rem;
        color: var(--ink-deep);
        font-family: var(--ff-body);
        resize: none;
        outline: none;
        box-sizing: border-box;
        transition: border-color .18s;
    }
    .rejection-reason-input:focus { border-color: #c94a00; background: var(--white); }
    .rejection-reason-label {
        font-size: .72rem;
        font-weight: 700;
        color: #c94a00;
        margin-bottom: .3rem;
        display: block;
    }

    .field-error {
        font-size: .72rem;
        font-weight: 600;
        color: #e04867;
        margin-top: .3rem;
        display: none;
    }
    .field-error.visible { display: block; }

    .input-invalid {
        border-color: #e04867 !important;
        background: #fff5f7 !important;
    }

    .input-valid {
        border-color: #2ec27e !important;
    }

    .char-counter {
        font-size: .7rem;
        color: var(--ink-soft);
        text-align: right;
        margin-top: .2rem;
    }
    .char-counter.near-limit { color: #f0a500; }
    .char-counter.at-limit   { color: #e04867; font-weight: 700; }

    .inline-notice {
        padding: .6rem .85rem;
        border-radius: 10px;
        font-size: .8rem;
        font-weight: 600;
        margin-top: .6rem;
        display: flex;
        align-items: flex-start;
        gap: .5rem;
    }
    .inline-notice-warn {
        background: #fff6dc;
        color: #c58a00;
        border: 1px solid #f2cd63;
    }
    .inline-notice-error {
        background: #ffe9ee;
        color: #e04867;
        border: 1px solid #ff9db0;
    }
    .inline-notice-info {
        background: #edf1ff;
        color: #5570ff;
        border: 1px solid #b6c2ff;
    }

    .floor-reading-row.row-error {
        border-color: #e04867;
        background: #fff5f7;
    }

    .frr-error {
        grid-column: 1 / -1;
        font-size: .72rem;
        font-weight: 600;
        color: #e04867;
        margin-top: -.3rem;
        display: none;
    }
    .frr-error.visible { display: block; }

    .modal-field-wrap { display: flex; flex-direction: column; }
    .modal-field-wrap .modal-field { margin: 0; }

    .section-divider {
        grid-column: 1 / -1;
        border: none;
        border-top: 1px solid var(--border-pink-mid);
        margin: .25rem 0;
    }

    .onsite-track {
        width: 42px;
        height: 24px;
        border-radius: 999px;
        background: var(--border-pink);
        border: 1.5px solid var(--border-pink);
        transition: background .2s, border-color .2s;
        position: relative;
        flex-shrink: 0;
    }

    .onsite-track::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--white);
        box-shadow: 0 1px 4px rgba(0,0,0,.15);
        transition: transform .2s;
    }

    input[type="checkbox"].onsite-toggle:checked + .onsite-track {
        background: #2ec27e;
        border-color: #2ec27e;
    }

    input[type="checkbox"].onsite-toggle:checked + .onsite-track::after {
        transform: translateX(18px);
    }

    .confirm-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.45);
        backdrop-filter: blur(4px);
        z-index: 500;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .confirm-overlay.open { display: flex; }

    .confirm-box {
        background: var(--white);
        border-radius: 22px;
        padding: 1.8rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        animation: fadeUp .25s ease;
    }

    .confirm-box-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink-deep);
        margin-bottom: .5rem;
    }

    .confirm-box-body {
        font-size: .86rem;
        color: var(--ink-soft);
        line-height: 1.6;
        margin-bottom: 1.4rem;
    }

    .confirm-box-actions {
        display: flex;
        gap: .6rem;
        justify-content: flex-end;
    }

    .btn-confirm-yes {
        padding: .6rem 1.3rem;
        border-radius: 12px;
        border: none;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .86rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--ease);
    }
    .btn-confirm-yes:hover { transform: translateY(-1px); }

    .btn-confirm-no {
        padding: .6rem 1.1rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        color: var(--ink-soft);
        font-size: .86rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-confirm-no:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .empty-floor {
        padding: 1.5rem;
        text-align: center;
        color: var(--ink-soft);
        font-size: 1rem;
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
        font-size: .79rem;
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

    .btn-receipt {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        margin-top: .85rem;
        padding: .55rem 1rem;
        border-radius: 10px;
        background: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
        color: #fff;
        font-size: .82rem;
        font-weight: 700;
        text-decoration: none;
        transition: opacity .18s, transform .15s;
        box-shadow: 0 4px 14px rgba(232,23,93,.28);
        width: 100%;
        justify-content: center;
        box-sizing: border-box;
    }

    .btn-receipt:hover {
        opacity: .9;
        transform: translateY(-1px);
    }

    .btn-preview-proof {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        width: 100%;
        padding: .55rem 1rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--hot-pink);
        border: 1.5px solid var(--border-pink);
        font-size: .82rem;
        font-weight: 700;
        cursor: pointer;
        transition: border-color .18s, background .18s, transform .15s;
        box-sizing: border-box;
        font-family: inherit;
        margin-top: .6rem;
    }

    .btn-preview-proof:hover {
        border-color: var(--hot-pink);
        background: var(--pink-bg-soft);
        transform: translateY(-1px);
    }

    .proof-lightbox-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(10,0,8,.88);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        animation: lbFadeIn .2s ease;
    }

    .proof-lightbox-overlay.open { display: flex; }

    @keyframes lbFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .proof-lightbox-inner {
        position: relative;
        max-width: 860px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        animation: lbSlideUp .28s cubic-bezier(.22,1,.36,1);
    }

    @keyframes lbSlideUp {
        from { opacity: 0; transform: translateY(20px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .proof-lightbox-header {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .proof-lightbox-name {
        font-size: .9rem;
        font-weight: 700;
        color: rgba(255,255,255,.85);
        letter-spacing: .01em;
    }

    .proof-lightbox-actions {
        display: flex;
        align-items: center;
        gap: .55rem;
    }

    .lb-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .45rem .9rem;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity .15s, transform .15s;
        text-decoration: none;
        border: none;
        font-family: inherit;
    }

    .lb-btn-open {
        background: rgba(255,255,255,.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,.25);
    }

    .lb-btn-open:hover { background: rgba(255,255,255,.25); }

    .lb-btn-close {
        background: var(--gradient-pink);
        color: #fff;
        box-shadow: 0 4px 14px rgba(232,23,93,.35);
    }

    .lb-btn-close:hover { opacity: .88; transform: translateY(-1px); }

    .proof-lightbox-img-wrap {
        width: 100%;
        border-radius: 18px;
        overflow: hidden;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        display: flex;
        align-items: center;
        justify-content: center;
        max-height: 75vh;
    }

    .proof-lightbox-img {
        width: 100%;
        max-height: 75vh;
        object-fit: contain;
        display: block;
    }

    .action-loading-overlay {
        position: fixed;
        inset: 0;
        z-index: 1200;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.72);
        backdrop-filter: blur(2px);
    }
    .action-loading-overlay.open { display: flex; }

    .action-loading-box {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: .75rem;
        padding: 1.25rem 1.6rem;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--white);
        box-shadow: 0 12px 32px rgba(26,26,46,.14);
        color: var(--ink);
        font-size: .9rem;
        font-weight: 700;
    }

    .loading-logo-wrap {
        width: 86px;
        height: 86px;
        border: 3px solid var(--pink-50);
        border-radius: 50%;
        background: var(--gradient-pink);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 24px rgba(232,23,93,.25);
        animation: pulseLogo 1s ease-in-out infinite;
        flex-shrink: 0;
    }

    .loading-logo-wrap img {
        width: 62px;
        height: 62px;
        object-fit: contain;
    }

    .is-loading {
        opacity: .75;
        pointer-events: none;
    }

    @keyframes pulseLogo {
        0%, 100% { transform: scale(1);     box-shadow: 0 10px 24px rgba(232,23,93,.25); }
        50%       { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); }
    }
    .billing-legend-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        flex-shrink: 0;
    }

    .billing-legend-wrap img {
        display: block;
        width: 15px;
        height: 15px;
        object-fit: contain;
        opacity: .75;
        transition: opacity .2s;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .billing-legend-wrap:hover img { opacity: 1; }

    .billing-legend-popup {
        display: none;
        position: fixed;
        background: var(--white);
        border: 1.5px solid var(--border-pink);
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(232,23,93,.16), 0 2px 8px rgba(0,0,0,.08);
        padding: .85rem 1rem;
        min-width: 300px;
        max-width: 340px;
        z-index: 999999;
        pointer-events: none;
        overflow-y: auto;
        max-height: 80vh;
    }

    .billing-legend-popup.open {
        display: block;
        pointer-events: auto;
    }

    .blp-title {
        font-size: .67rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: .55rem;
        padding-bottom: .4rem;
        border-bottom: 1.5px solid var(--petal);
    }

    .blp-row {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        padding: .35rem 0;
        border-bottom: 1px solid var(--border-pink-mid);
    }

    .blp-row:last-child { border-bottom: none; }

    .blp-badge-cell {
        flex-shrink: 0;
        width: 80px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .blp-desc {
        font-size: .75rem;
        color: var(--ink-soft);
        font-weight: 500;
        line-height: 1.45;
        padding-top: .1rem;
        flex: 1;
    }

    .blp-dot-cell {
        flex-shrink: 0;
        width: 80px;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .blp-dot-label {
        font-size: .75rem;
        font-weight: 700;
    }

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-100, #fce8f1); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--black); cursor: pointer; transition: background .15s; font-family: inherit; }
    .export-menu button:hover { background: var(--pink-bg-soft, #fff5f8); color: var(--hot-pink); }

    .form-progress-wrap {
        padding: .5rem 1.8rem .4rem;
        display: flex;
        flex-direction: column;
        gap: .2rem;
        flex-shrink: 0;
        border-bottom: 1px solid var(--border-pink-mid);
        background: var(--pink-bg-soft);
    }
    .form-progress-bar {
        width: 100%;
        height: 3px;
        background: var(--border-pink);
        border-radius: 99px;
        overflow: hidden;
    }
    .form-progress-fill {
        height: 100%;
        border-radius: 99px;
        transition: width .35s cubic-bezier(.4,0,.2,1), background .35s;
    }
    .form-progress-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: .68rem;
        font-weight: 700;
        color: var(--ink-soft);
    }
    .form-progress-label span.ready {
        color: #1f9d69;
        font-weight: 800;
    }
    .form-progress-label span.partial {
        color: var(--bright-pink);
    }
    .field-req-star {
        color: var(--bright-pink);
        font-size: .75rem;
        font-weight: 900;
        margin-left: .15rem;
        opacity: .8;
        vertical-align: middle;
        pointer-events: none;
        user-select: none;
    }
    .um-progress-wrap {
        padding: .6rem 1rem .35rem;
        display: flex;
        flex-direction: column;
        gap: .2rem;
        border-bottom: 1px solid var(--border-pink-mid);
        background: var(--pink-bg-soft);
        flex-shrink: 0;
    }
    .um-progress-bar {
        width: 100%;
        height: 3px;
        background: var(--border-pink);
        border-radius: 99px;
        overflow: hidden;
    }
    .um-progress-fill {
        height: 100%;
        border-radius: 99px;
        transition: width .35s cubic-bezier(.4,0,.2,1), background .35s;
    }
    .um-progress-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: .68rem;
        font-weight: 700;
        color: var(--ink-soft);
    }
    .um-progress-label span.ready { color: #1f9d69; font-weight: 800; }
    .um-progress-label span.partial { color: var(--bright-pink); }

    .tab-icon {
        width: 14px;
        height: 14px;
        object-fit: contain;
        flex-shrink: 0;
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
        vertical-align: middle;
        margin-right: 3px;
    }

    .um-tab.active .tab-icon,
    .um-tab[style*="var(--bright-pink)"] .tab-icon {
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
    }
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
        <button class="btn-filter" onclick="applyMonthFilter()">
            <img src="{{ asset('icons/filter.png') }}" alt="" style="width:14px;height:14px;filter:brightness(0) invert(1);flex-shrink:0;">
            Filter
        </button>
        <div class="billing-legend-wrap" id="billing-legend-trigger">
            <img src="{{ asset('icons/info.png') }}" alt="Status guide">
            <div class="billing-legend-popup" id="billing-legend-popup">
                <div class="blp-title">Payment Status Guide</div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-paid">Paid</span></div>
                    <div class="blp-desc">Tenant has submitted proof and payment has been verified.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-unpaid">Unpaid</span></div>
                    <div class="blp-desc">Bill has been issued but no payment has been submitted yet.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-overdue">Overdue</span></div>
                    <div class="blp-desc">The due date has passed and the tenant has not paid.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-pending">Pending</span></div>
                    <div class="blp-desc">Tenant has submitted proof and it is awaiting admin review.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-rejected">Rejected</span></div>
                    <div class="blp-desc">Submitted proof was rejected. Tenant must resubmit payment.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-not-billed">Not Billed</span></div>
                    <div class="blp-desc">No billing record exists for this tenant for the current period.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-pending-tenant">Pending</span></div>
                    <div class="blp-desc">Tenant account exists but has not activated the app yet. No billing assigned.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-badge-cell"><span class="badge badge-inactive-tenant">Inactive</span></div>
                    <div class="blp-desc">Tenant account is disabled. Billing is paused for this tenant.</div>
                </div>
                <div class="blp-title" style="margin-top:.65rem;">Dot Indicators</div>
                <div class="blp-row">
                    <div class="blp-dot-cell">
                        <span class="dot dot-green"></span>
                        <span class="blp-dot-label" style="color:#1f9d69;">Green</span>
                    </div>
                    <div class="blp-desc">Payment is verified and confirmed as paid.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-dot-cell">
                        <span class="dot dot-orange"></span>
                        <span class="blp-dot-label" style="color:#f0a500;">Orange</span>
                    </div>
                    <div class="blp-desc">Payment is unpaid, pending review, or not yet submitted.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-dot-cell">
                        <span class="dot dot-red"></span>
                        <span class="blp-dot-label" style="color:#ff5d73;">Red</span>
                    </div>
                    <div class="blp-desc">Payment is overdue or has been rejected.</div>
                </div>
                <div class="blp-row">
                    <div class="blp-dot-cell">
                        <span class="dot dot-gray"></span>
                        <span class="blp-dot-label" style="color:#bbb;">Gray</span>
                    </div>
                    <div class="blp-desc">Not billed, inactive tenant, or account pending activation.</div>
                </div>
                <div class="blp-title" style="margin-top:.65rem;">Other Indicators</div>
                <div class="blp-row">
                    <div class="blp-badge-cell" style="align-items:center;gap:.35rem;display:flex;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#b0b0c0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        <span style="font-size:.72rem;font-weight:700;color:#b0b0c0;">Phone</span>
                    </div>
                    <div class="blp-desc">Tenant has not activated their mobile app account yet. A temporary password is still in use.</div>
                </div>
            </div>
        </div>
        <button class="ms-auto btn-primary" onclick="openLogModal()">Log Water Consumption</button>
        <a href="{{ route('billing.history') }}" class="btn-outline">
            <img src="{{ asset('icons/pending.png') }}" alt="" class="export-icon">
            History
        </a>
        <div class="export-dropdown" id="export-dropdown-billing">
            <button class="btn-outline" onclick="toggleExportDropdown('export-dropdown-billing')">
                <img src="{{ asset('icons/export.png') }}" alt="" class="export-icon">
                Export
            </button>
            <div class="export-menu" id="export-menu-billing">
                <button onclick="exportBillingCsv(); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportBillingPdf(); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>

    <div id="billing-groups" class="fade-up d4">
        @forelse($billingGroups as $group)
        <div class="floor-group" data-floor="{{ $group['floor'] }}">

            <div class="floor-header">
                <span class="floor-name">{{ $group['submeter_label'] }}</span>
                <span class="floor-chip floor-summary-chip">{{ $group['floor_consumption_m3'] }} m³</span>
                <span class="floor-chip floor-summary-chip">₱{{ number_format($group['total_floor_bill'], 2) }}</span>
                <span class="floor-chip floor-summary-chip">{{ $group['room_count'] }} rooms</span>
                @if($group['past_due_count'] > 0)
                    <span class="floor-chip" style="background:#ffe9ee;color:#e04867;border-color:#ffb3c1;">{{ $group['past_due_count'] }} past due</span>
                @endif
                <span class="floor-due">Due: {{ $group['due_date'] }}</span>
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
                        <button class="btn-update" onclick='openUpdateModal(@json($room))' title="Edit Billing">
                            <img src="{{ asset('icons/edit.png') }}" alt="Edit">
                        </button>
                    </div>
                    <div class="tenants-list">
                        @foreach($room['tenants'] as $t)
                        <div class="tenant-row">
                            <div class="tenant-left">
                                <span class="dot {{ $t['dot_class'] }}"></span>
                                <span class="tname">{{ $t['name'] }}</span>
                                @if(!empty($t['is_temp_password']))
                                <span title="Tenant hasn't activated their app account yet" style="display:inline-flex;align-items:center;justify-content:center;width:15px;height:15px;border-radius:50%;background:#f2f2f5;border:1px solid #e0e0e8;flex-shrink:0;margin-left:3px;vertical-align:middle;position:relative;top:-1px;">
                                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#b0b0c0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                </span>
                                @endif
                            </div>
                            <div class="tenant-right">
                                <span class="t-amount">{{ in_array($t['payment_status'], ['pending-tenant', 'inactive-tenant']) ? '-' : '₱' . number_format($t['room_share'], 2) }}</span>
                                @php
                                    $badgeLabels = [
                                        'pending-tenant'  => 'Pending',
                                        'inactive-tenant' => 'Inactive',
                                        'not-billed'      => 'Not Billed',
                                        'not billed'      => 'Not Billed',
                                    ];
                                    $badgeText = $badgeLabels[$t['payment_status']] ?? ucfirst($t['payment_status']);
                                @endphp
                                <span class="badge badge-{{ str_replace(' ', '-', $t['payment_status']) }}">{{ $badgeText }}</span>
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
<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

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
            <div class="form-progress-wrap" id="log-progress-wrap">
                <div class="form-progress-label">
                    <span id="log-progress-text">Fill in required fields</span>
                    <span id="log-progress-count" class="partial"></span>
                </div>
                <div class="form-progress-bar">
                    <div class="form-progress-fill" id="log-progress-fill" style="width:0%;background:linear-gradient(90deg,#E8175D,#FF2D78);"></div>
                </div>
            </div>
            <div class="log-modal-body">

                <div class="section-label">Billing Period</div>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>Billing Month <span class="field-req-star">*</span></label>
                        <input type="month" name="billing_month" id="log-billing-month" required value="{{ now()->format('Y-m') }}" max="{{ now()->format('Y-m') }}">
                        <span class="field-error">Billing month is required.</span>
                    </div>
                    <div class="modal-field">
                        <label>Due Date <span class="field-req-star">*</span></label>
                        <input type="date" name="due_date" id="log-due-date" required min="{{ now()->format('Y-m-d') }}">
                        <span class="field-error">Due date is required and must be after the billing month.</span>
                    </div>
                </div>

                <div class="section-label">Maynilad Bill (Mother Meter)</div>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>Total Cubic Meters (m3) <span class="field-req-star">*</span></label>
                        <input type="number" step="0.01" min="0.01" name="maynilad_total_m3" id="log-maynilad-m3" placeholder="e.g. 120.00" required oninput="recalcRate()">
                        <span class="field-error">Enter the total cubic meters from the Maynilad bill.</span>
                    </div>
                    <div class="modal-field">
                        <label>Total Amount Due (P) <span class="field-req-star">*</span></label>
                        <input type="number" step="0.01" min="0.01" name="maynilad_total_amount" id="log-maynilad-amount" placeholder="e.g. 4800.00" required oninput="recalcRate()">
                        <span class="field-error">Enter the total amount due from the Maynilad bill.</span>
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
  <div class="modal" style="max-width:540px;padding:0;border-radius:20px;overflow:hidden;">

    <div class="modal-top" style="padding:1.25rem 1.5rem 0;border-bottom:1.5px solid var(--border-pink-mid);">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem;">
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:38px;height:38px;border-radius:10px;background:#fff0f6;display:flex;align-items:center;justify-content:center;">
            <img src="{{ asset('icons/bed.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;filter:brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);">
          </div>
          <div>
            <div style="font-size:11px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">Update billing</div>
            <div id="um-room-title" style="font-size:16px;font-weight:700;color:var(--ink-deep);">Room —</div>
            <div id="um-room-sub" style="font-size:12px;color:var(--ink-soft);">Floor — · — occupants</div>
          </div>
        </div>
        <button class="modal-close" onclick="closeModal('update-modal')" style="width:30px;height:30px;border-radius:8px;border:1.5px solid var(--border-pink);display:flex;align-items:center;justify-content:center;">✕</button>
      </div>

      <div style="display:flex;gap:0;" role="tablist" id="um-tab-bar">
        <button class="um-tab active" role="tab" onclick="umTab('readings',this)" style="flex:1;padding:.6rem .5rem;background:none;border:none;border-bottom:2px solid var(--bright-pink);cursor:pointer;font-size:12.5px;font-weight:700;color:var(--bright-pink);font-family:inherit;display:flex;align-items:center;justify-content:center;gap:5px;">
            <img src="{{ asset('icons/chart.png') }}" alt="" class="tab-icon">
            Readings
        </button>
        <button class="um-tab" role="tab" onclick="umTab('payments',this)" style="flex:1;padding:.6rem .5rem;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;font-size:12.5px;font-weight:600;color:var(--ink-soft);font-family:inherit;display:flex;align-items:center;justify-content:center;gap:5px;">
            <img src="{{ asset('icons/billing.png') }}" alt="" class="tab-icon" style="filter:brightness(0) saturate(100%) invert(50%);">
            Payments
        </button>
        <button class="um-tab" role="tab" onclick="umTab('proof',this)" style="flex:1;padding:.6rem .5rem;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;font-size:12.5px;font-weight:600;color:var(--ink-soft);font-family:inherit;display:flex;align-items:center;justify-content:center;gap:5px;">
            <img src="{{ asset('icons/attach.png') }}" alt="" class="tab-icon" style="filter:brightness(0) saturate(100%) invert(50%);">
            Proof
        </button>
      </div>
    </div>

    <form id="update-form">
      @csrf
      <div style="padding:1.25rem 1.5rem;max-height:420px;overflow-y:auto;">

        <div class="um-panel" id="um-tab-readings">
          <div class="um-progress-wrap" id="um-progress-wrap">
              <div class="um-progress-label">
                  <span id="um-progress-text">Fill in required fields</span>
                  <span id="um-progress-count" class="partial"></span>
              </div>
              <div class="um-progress-bar">
                  <div class="um-progress-fill" id="um-progress-fill" style="width:0%;background:linear-gradient(90deg,#E8175D,#FF2D78);"></div>
              </div>
          </div>
          <div style="display:flex;gap:8px;margin-bottom:14px;" id="um-stat-row">
            <div style="flex:1;padding:.65rem .85rem;border-radius:12px;background:var(--pink-bg-soft);border:1px solid var(--border-pink);">
              <div style="font-size:10.5px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">Consumption</div>
              <div id="um-disp-cons" style="font-size:17px;font-weight:700;color:var(--bright-pink);margin-top:2px;">— m³</div>
            </div>
            <div style="flex:1;padding:.65rem .85rem;border-radius:12px;background:var(--pink-bg-soft);border:1px solid var(--border-pink);">
              <div style="font-size:10.5px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">Floor total</div>
              <div id="um-disp-total" style="font-size:17px;font-weight:700;color:var(--bright-pink);margin-top:2px;">₱—</div>
            </div>
            <div style="flex:1;padding:.65rem .85rem;border-radius:12px;background:var(--pink-bg-soft);border:1px solid var(--border-pink);">
              <div style="font-size:10.5px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">Per tenant</div>
              <div id="um-disp-share" style="font-size:17px;font-weight:700;color:var(--bright-pink);margin-top:2px;">₱—</div>
            </div>
          </div>
          <div class="modal-grid">
            <div class="modal-field">
              <label>Previous reading (m³) <span class="field-req-star">*</span></label>
              <input type="number" step="0.01" id="edit-prev" oninput="recalcUpdateShare()">
            </div>
            <div class="modal-field">
              <label>Current reading (m³) <span class="field-req-star">*</span></label>
              <input type="number" step="0.01" id="edit-curr" oninput="recalcUpdateShare()">
            </div>
            <div class="modal-field">
              <label>Consumption (auto)</label>
              <input type="text" id="edit-consumption" disabled>
            </div>
            <div class="modal-field">
              <label>Due date <span class="field-req-star">*</span></label>
              <input type="date" id="edit-due-date">
              <span class="field-error">Please set a due date.</span>
            </div>
            <div class="field-error full" id="edit-reading-error" style="grid-column:1/-1;display:none;"></div>
          </div>
        </div>

        <div class="um-panel" id="um-tab-payments" style="display:none;">
          <div id="um-tenant-statuses"></div>
        </div>

        <div class="um-panel" id="um-tab-proof" style="display:none;">
          <div id="um-proof-content"></div>
        </div>

      </div>

      <div class="modal-actions" style="background:var(--pink-bg-soft);border-top:1px solid var(--border-pink-mid);padding:1rem 1.5rem;">
        <button type="button" class="btn-cancel" onclick="closeModal('update-modal')">Cancel</button>
        <button type="submit" class="btn-submit">Save changes</button>
      </div>
    </form>
  </div>
</div>

<div class="proof-lightbox-overlay" id="proof-lightbox" onclick="if(event.target===this)closeLightbox()">
    <div class="proof-lightbox-inner">
        <div class="proof-lightbox-header">
            <span class="proof-lightbox-name" id="lb-tenant-name"></span>
            <div class="proof-lightbox-actions">
                <a id="lb-open-link" href="#" target="_blank" class="lb-btn lb-btn-open">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M1 12L12 1M12 1H5M12 1V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Open in new tab
                </a>
                <button class="lb-btn lb-btn-close" onclick="closeLightbox()">✕ Close</button>
            </div>
        </div>
        <div class="proof-lightbox-img-wrap">
            <img id="lb-img" src="" alt="Proof of payment" class="proof-lightbox-img">
        </div>
    </div>
</div>

<div class="confirm-overlay" id="confirm-dialog">
    <div class="confirm-box">
        <div class="confirm-box-title" id="confirm-title">Are you sure?</div>
        <div class="confirm-box-body" id="confirm-body"></div>
        <div class="confirm-box-actions">
            <button class="btn-confirm-no" id="confirm-no">Cancel</button>
            <button class="btn-confirm-yes" id="confirm-yes">Confirm</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function() {
    var url = new URL(window.location.href);
    var hasParams = url.searchParams.has('month') || url.searchParams.has('floor');
    if (!hasParams) {
        var selects = document.querySelectorAll('.filter-select');
        selects.forEach(function(s) { s.selectedIndex = 0; });
    }
    var inputs = document.querySelectorAll('input[type="text"], input[type="search"], input[type="month"], input[type="date"]');
    inputs.forEach(function(inp) {
        if (!inp.closest('form') || inp.closest('.modal-overlay')) return;
        inp.setAttribute('autocomplete', 'off');
    });
})();
(function() {
    var pollUrl = "{{ route('billing.poll') }}";
    var lastSignature = null;
    var pollIntervalMs = 12000;
    var pollTimer = null;
    var inFlight = false;

    function isUserBusy() {
        if (document.querySelector('.modal-overlay.open')) return true;
        if (document.querySelector('.confirm-overlay.open')) return true;
        if (document.querySelector('.proof-lightbox-overlay.open')) return true;
        if (document.querySelector('.export-menu.open')) return true;
        if (document.querySelector('.export-month-menu.open')) return true;
        if (document.querySelector('.action-loading-overlay.open')) return true;
        if (document.querySelector('.billing-legend-popup.open')) return true;

        var active = document.activeElement;
        if (active && active !== document.body) {
            var tag = active.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return true;
        }
        return false;
    }

    function currentParams() {
        var url = new URL(window.location.href);
        return {
            month: url.searchParams.get('month') || @json($selectedMonth),
            floor: url.searchParams.get('floor') || ''
        };
    }

    function softReload() {
        var url = new URL(window.location.href);
        url.searchParams.set('_silent', '1');
        fetch(url.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function(res) {
            return res.text();
        }).then(function(html) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');
            var freshGroups = doc.getElementById('billing-groups');
            var currentGroups = document.getElementById('billing-groups');
            var freshStats = doc.querySelector('.stats-card');
            var currentStats = document.querySelector('.stats-card');

            if (freshGroups && currentGroups) {
                currentGroups.innerHTML = freshGroups.innerHTML;
            }
            if (freshStats && currentStats) {
                currentStats.innerHTML = freshStats.innerHTML;
            }
        }).catch(function() {
        });
    }

    function poll() {
        if (inFlight || isUserBusy()) return;
        inFlight = true;

        var params = currentParams();
        var pollFetchUrl = pollUrl + '?month=' + encodeURIComponent(params.month) + '&floor=' + encodeURIComponent(params.floor);

        fetch(pollFetchUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function(res) {
            if (!res.ok) throw new Error('poll failed');
            return res.json();
        }).then(function(data) {
            if (lastSignature === null) {
                lastSignature = data.signature;
                return;
            }
            if (data.signature !== lastSignature) {
                lastSignature = data.signature;
                if (!isUserBusy()) softReload();
            }
        }).catch(function() {
        }).finally(function() {
            inFlight = false;
        });
    }

    function startPolling() {
        if (pollTimer) return;
        pollTimer = setInterval(poll, pollIntervalMs);
    }

    function stopPolling() {
        if (pollTimer) {
            clearInterval(pollTimer);
            pollTimer = null;
        }
    }

    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopPolling();
        } else {
            startPolling();
            poll();
        }
    });

    window.addEventListener('focus', poll);

    startPolling();
})();
(function() {
    var trigger = document.getElementById('billing-legend-trigger');
    var popup   = document.getElementById('billing-legend-popup');
    if (!trigger || !popup) return;

    var hideTimer = null;

    document.body.appendChild(popup);

    function positionPopup() {
        var rect       = trigger.getBoundingClientRect();
        var popupWidth = 340;
        var left       = rect.left;
        var top        = rect.bottom + 8;

        if (left + popupWidth > window.innerWidth - 12) {
            left = window.innerWidth - popupWidth - 12;
        }
        if (left < 12) left = 12;

        popup.style.left   = left + 'px';
        popup.style.top    = top + 'px';
        popup.style.right  = 'auto';
        popup.style.bottom = 'auto';
    }

    function showPopup() {
        clearTimeout(hideTimer);
        positionPopup();
        popup.classList.add('open');
    }

    function hidePopup() {
        hideTimer = setTimeout(function() {
            popup.classList.remove('open');
        }, 180);
    }

    trigger.addEventListener('mouseenter', showPopup);
    trigger.addEventListener('mouseleave', hidePopup);
    popup.addEventListener('mouseenter', function() { clearTimeout(hideTimer); });
    popup.addEventListener('mouseleave', hidePopup);

    window.addEventListener('resize', function() {
        if (popup.classList.contains('open')) positionPopup();
    });
    window.addEventListener('scroll', function() {
        if (popup.classList.contains('open')) positionPopup();
    }, true);
})();
function showActionLoading(message) {
    const overlay = document.getElementById('action-loading');
    document.getElementById('action-loading-text').textContent = message || 'Please wait...';
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
}

function hideActionLoading() {
    const overlay = document.getElementById('action-loading');
    overlay.classList.remove('open');
    overlay.setAttribute('aria-hidden', 'true');
}

function setButtonLoading(btn, loadingText) {
    btn.disabled = true;
    btn.classList.add('is-loading');
    btn.dataset.originalText = btn.innerHTML;
    btn.innerHTML = loadingText;
}

function resetButton(btn, originalText) {
    btn.disabled = false;
    btn.classList.remove('is-loading');
    btn.innerHTML = originalText || btn.dataset.originalText || originalText;
}

function showConfirm(title, body, onConfirm) {
    document.getElementById('confirm-title').textContent = title;
    document.getElementById('confirm-body').textContent = body;
    document.getElementById('confirm-dialog').classList.add('open');
    const yes = document.getElementById('confirm-yes');
    const no  = document.getElementById('confirm-no');
    const close = () => document.getElementById('confirm-dialog').classList.remove('open');
    yes.onclick = () => { close(); onConfirm(); };
    no.onclick  = close;
}

@php
    $tenantsByFloorData = $allTenants->whereIn('status', ['active', 'pending'])->groupBy('floor')->map(fn($tenants) =>
        $tenants->map(fn($t) => [
            'name'        => $t->first_name . ' ' . $t->last_name,
            'room_number' => $t->room_number,
        ])->values()
    );
@endphp
const tenantsByFloor = {!! json_encode($tenantsByFloorData) !!};

const activeFloors      = @json($activeFloors->values());
const unloggedFloors    = @json($unloggedFloors->values());
const lastMonthReadings = @json($lastMonthReadings);
const billingExportGroups = @json($billingGroups);
const selectedBillingMonth = @json($selectedMonth);

function recalcRate() {
    const m3     = parseFloat(document.getElementById('log-maynilad-m3')?.value)     || 0;
    const amount = parseFloat(document.getElementById('log-maynilad-amount')?.value) || 0;
    const box    = document.getElementById('rate-preview-box');
    const rp     = document.getElementById('rp-rate');

    validateLogField(document.getElementById('log-maynilad-m3'));
    validateLogField(document.getElementById('log-maynilad-amount'));

    if (m3 > 0 && amount > 0) {
        const rate = amount / m3;
        rp.textContent = '₱' + rate.toFixed(2) + ' / m³';
        box.classList.add('visible');
        document.querySelectorAll('.floor-reading-row').forEach(row => recalcFloorRow(row));
    } else {
        box.classList.remove('visible');
    }
}

function validateLogField(input) {
    if (!input) return true;
    const val = parseFloat(input.value);
    const errEl = input.parentElement?.querySelector('.field-error');
    if (!input.value || isNaN(val) || val <= 0) {
        input.classList.add('input-invalid');
        input.classList.remove('input-valid');
        if (errEl) { errEl.textContent = 'Enter a value greater than 0.'; errEl.classList.add('visible'); }
        return false;
    }
    input.classList.remove('input-invalid');
    input.classList.add('input-valid');
    if (errEl) errEl.classList.remove('visible');
    return true;
}

function validateLogDate(input) {
    if (!input) return true;
    const errEl = input.parentElement?.querySelector('.field-error');
    if (!input.value) {
        input.classList.add('input-invalid');
        if (errEl) { errEl.textContent = 'This date is required.'; errEl.classList.add('visible'); }
        return false;
    }
    input.classList.remove('input-invalid');
    input.classList.add('input-valid');
    if (errEl) errEl.classList.remove('visible');
    return true;
}

let floorRowIdx = 0;

function addFloorRow(defaultFloor) {
    const list   = document.getElementById('floor-readings-list');
    const idx    = floorRowIdx++;
    const floors = activeFloors;

    let opts = floors.map(f => {
        const warned = unloggedFloors.includes(f) ? '' : ' [already logged]';
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
                    onchange="updateFloorPreview(this); checkDuplicateFloors();" required>
                <option value="">Select floor</option>
                ${opts}
            </select>
        </div>
        <div>
            <div class="frr-label">Prev Reading (m3)</div>
            <input type="number" step="0.01" min="0"
                   name="floor_readings[${idx}][prev]"
                   placeholder="0.00" required
                   oninput="recalcFloorRow(this.closest('.floor-reading-row')); validateFloorRow(this.closest('.floor-reading-row'));">
        </div>
        <div>
            <div class="frr-label">Curr Reading (m3)</div>
            <input type="number" step="0.01" min="0"
                   name="floor_readings[${idx}][curr]"
                   placeholder="0.00" required
                   oninput="recalcFloorRow(this.closest('.floor-reading-row')); validateFloorRow(this.closest('.floor-reading-row'));">
        </div>
        <div>
            <div class="frr-label">Consumption</div>
            <input type="text" disabled placeholder="auto" class="frr-consumption">
        </div>
        <div style="display:flex;flex-direction:column;gap:.4rem;align-items:center;">
            <span class="floor-bill-preview frr-bill-preview">--</span>
            <button type="button" class="btn-remove-floor" onclick="removeFloorRow(this); checkDuplicateFloors();" title="Remove">x</button>
        </div>
    `;

    const errorRow = document.createElement('div');
    errorRow.className = 'frr-error';
    row.appendChild(errorRow);

    const pillDiv = document.createElement('div');
    pillDiv.style.cssText = 'grid-column:1/-1;margin-top:-.3rem;';
    pillDiv.innerHTML = `<span class="tenant-pill frr-tenant-pill" style="display:none;"></span>`;
    row.appendChild(pillDiv);

    list.appendChild(row);

    if (defaultFloor) {
        const sel = row.querySelector('.frr-floor-sel');
        sel.value = defaultFloor;
        updateFloorPreview(sel);
        autoFillPrevReading(row, defaultFloor);
    }
}

function autoFillPrevReading(row, floor) {
    if (!floor) return;
    var key = lastMonthReadings[floor] !== undefined ? floor : String(floor);
    if (lastMonthReadings[key] === undefined) return;
    floor = key;
    const prevInput = row.querySelector('[name$="[prev]"]');
    if (!prevInput || prevInput.value !== '') return;
    prevInput.value = parseFloat(lastMonthReadings[floor] ?? lastMonthReadings[String(floor)] ?? 0).toFixed(2);
    prevInput.classList.add('input-valid');
    recalcFloorRow(row);
}

function removeFloorRow(btn) {
    btn.closest('.floor-reading-row').remove();
}

function validateFloorRow(row) {
    const prev    = parseFloat(row.querySelector('[name$="[prev]"]')?.value) || 0;
    const curr    = parseFloat(row.querySelector('[name$="[curr]"]')?.value) || 0;
    const errEl   = row.querySelector('.frr-error');
    const currInp = row.querySelector('[name$="[curr]"]');

    if (currInp && currInp.value !== '' && curr < prev) {
        row.classList.add('row-error');
        if (errEl) { errEl.textContent = 'Current reading cannot be less than previous reading.'; errEl.classList.add('visible'); }
        currInp.classList.add('input-invalid');
        return false;
    }
    row.classList.remove('row-error');
    if (errEl) errEl.classList.remove('visible');
    if (currInp) currInp.classList.remove('input-invalid');
    return true;
}

function checkDuplicateFloors() {
    const rows   = document.querySelectorAll('.floor-reading-row');
    const seen   = {};
    rows.forEach(row => {
        const sel   = row.querySelector('.frr-floor-sel');
        const errEl = row.querySelector('.frr-error');
        if (!sel || !sel.value) return;
        if (seen[sel.value]) {
            row.classList.add('row-error');
            if (errEl) { errEl.textContent = `Floor ${sel.value} is already added above. Remove the duplicate.`; errEl.classList.add('visible'); }
        } else {
            seen[sel.value] = true;
            row.classList.remove('row-error');
            if (errEl && errEl.textContent.includes('already added')) errEl.classList.remove('visible');
        }
    });
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

    autoFillPrevReading(row, floor);
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

    if (consInput) consInput.value = consumption.toFixed(2) + ' m3';

    if (billSpan && ratePerM3 > 0) {
        const floorBill   = consumption * ratePerM3;
        const floor       = floorSel?.value;
        const tenantCount = (floor && tenantsByFloor[floor]) ? tenantsByFloor[floor].length : 0;
        const perHead     = tenantCount > 0 ? floorBill / tenantCount : 0;

        billSpan.textContent = tenantCount > 0
            ? `P${floorBill.toFixed(2)} / P${perHead.toFixed(2)} per head`
            : `P${floorBill.toFixed(2)}`;
    } else if (billSpan) {
        billSpan.textContent = '--';
    }
}

function openLogModal() {
    document.getElementById('floor-readings-list').innerHTML = '';
    floorRowIdx = 0;

    const billingMonthInput = document.getElementById('log-billing-month');
    if (billingMonthInput) billingMonthInput.value = new Date().toISOString().slice(0, 7);

    const dueDateInput = document.getElementById('log-due-date');
    if (dueDateInput) {
        const nextMonth = new Date();
        nextMonth.setMonth(nextMonth.getMonth() + 1);
        nextMonth.setDate(1);
        dueDateInput.min = new Date().toISOString().split('T')[0];
        dueDateInput.value = '';
    }

    document.querySelectorAll('#log-form .field-error').forEach(e => e.classList.remove('visible'));
    document.querySelectorAll('#log-form .input-invalid, #log-form .input-valid').forEach(e => {
        e.classList.remove('input-invalid', 'input-valid');
    });
    document.getElementById('rate-preview-box')?.classList.remove('visible');

    document.getElementById('log-maynilad-m3').value     = '';
    document.getElementById('log-maynilad-amount').value = '';

    const toAdd = unloggedFloors.length > 0 ? unloggedFloors : [activeFloors[0] ?? ''];
    toAdd.forEach(f => addFloorRow(f));
    openModal('log-modal');
}

function applyFloorFilter() {
    const floor = document.getElementById('filter-floor').value;
    const month = document.getElementById('filter-month').value;
    let url = "{{ route('billing.index') }}?month=" + month;
    if (floor) url += '&floor=' + floor;
    window.location.href = url;
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

function getBadgeLabel(status) {
    var labels = {'pending-tenant':'Pending','inactive-tenant':'Inactive','not billed':'Not Billed','not-billed':'Not Billed'};
    return labels[status] || escapeHtml(status || 'unpaid');
}

function toggleRejectionReason(select) {
    var wrap = select.closest('.modal-field').querySelector('.rejection-reason-wrap');
    if (!wrap) return;
    if (select.value === 'rejected') {
        wrap.classList.add('visible');
        const sel = wrap.querySelector('.rejection-reason-select');
        if (sel) { sel.value = ''; sel.focus(); }
        const ta = wrap.querySelector('.rejection-reason-input');
        if (ta) { ta.style.display = 'none'; ta.value = ''; }
    } else {
        wrap.classList.remove('visible');
        const sel = wrap.querySelector('.rejection-reason-select');
        if (sel) sel.value = '';
        const ta = wrap.querySelector('.rejection-reason-input');
        if (ta) { ta.style.display = 'none'; ta.value = ''; }
    }
}

function toggleRejectionOther(select) {
    const wrap     = select.closest('.rejection-reason-wrap');
    const textarea = wrap.querySelector('.rejection-reason-input');
    const counter  = wrap.querySelector('.char-counter');
    if (select.value === 'other') {
        textarea.style.display = 'block';
        textarea.value = '';
        if (counter) { counter.style.display = 'block'; counter.textContent = '0 / 500'; }
        textarea.focus();
    } else {
        textarea.style.display = 'none';
        textarea.value = select.value;
        if (counter) counter.style.display = 'none';
    }
}

function updateCharCounter(textarea) {
    const wrap    = textarea.closest('.rejection-reason-wrap');
    const counter = wrap?.querySelector('.char-counter');
    if (!counter) return;
    const len = textarea.value.length;
    counter.textContent = `${len} / 500`;
    counter.className = 'char-counter';
    if (len >= 500) counter.classList.add('at-limit');
    else if (len >= 400) counter.classList.add('near-limit');
}

function handleOnsiteToggle(checkbox) {
    const billingId  = checkbox.dataset.billingId;
    const statusSel  = document.querySelector(`.status-select[data-billing-id="${billingId}"]`);
    const wrap       = checkbox.closest('div[style]').parentElement;
    const noticeEl   = wrap?.querySelector('.inline-notice-warn');

    if (checkbox.checked) {
        if (statusSel) {
            statusSel.value = 'paid';
            toggleRejectionReason(statusSel);
        }
        if (noticeEl) noticeEl.style.display = 'none';
        checkbox.closest('label').previousElementSibling?.querySelector('div:last-child')?.setAttribute('style', 'font-size:.72rem;color:#2ec27e;margin-top:.1rem;');
    } else {
        if (statusSel && statusSel.value === 'paid') {
            statusSel.value = 'unpaid';
        }
        if (noticeEl) noticeEl.style.display = '';
    }
}

function recalcUpdateShare() {
    const prev        = parseFloat(document.getElementById('edit-prev')?.value) || 0;
    const curr        = parseFloat(document.getElementById('edit-curr')?.value) || 0;
    const consumption = Math.max(0, curr - prev);
    if (document.getElementById('edit-consumption'))
        document.getElementById('edit-consumption').value = consumption.toFixed(2) + ' m3';

    const prevInp = document.getElementById('edit-prev');
    const currInp = document.getElementById('edit-curr');
    const errEl   = document.getElementById('edit-reading-error');
    if (currInp && currInp.value !== '' && curr < prev) {
        currInp.classList.add('input-invalid');
        if (errEl) { errEl.textContent = 'Current reading cannot be less than previous reading.'; errEl.classList.add('visible'); }
    } else {
        if (currInp) currInp.classList.remove('input-invalid');
        if (errEl) errEl.classList.remove('visible');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('update-form');
    if (updateForm) {
        updateForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const prev = parseFloat(document.getElementById('edit-prev')?.value) || 0;
            const curr = parseFloat(document.getElementById('edit-curr')?.value) || 0;
            if (curr < prev) {
                showToast('Current reading cannot be less than previous reading.', 'error');
                return;
            }
            if (document.getElementById('edit-curr')?.value === '') {
                showToast('Current reading is required.', 'error');
                document.getElementById('edit-curr')?.classList.add('input-invalid');
                return;
            }

            const due = document.getElementById('edit-due-date')?.value;
            if (!due) {
                showToast('Please set a due date before saving.', 'error');
                document.getElementById('edit-due-date')?.classList.add('input-invalid');
                return;
            }

            const statusSelects  = updateForm.querySelectorAll('.status-select');
            const rejectedWithoutReason = Array.from(statusSelects).some(sel => {
                if (sel.value !== 'rejected') return false;
                const field = sel.closest('.modal-field');
                const reasonSel = field?.querySelector('.rejection-reason-select');
                const ta        = field?.querySelector('.rejection-reason-input');
                if (!reasonSel) return false;
                if (reasonSel.value === '') return true;
                if (reasonSel.value === 'other' && (!ta || !ta.value.trim())) return true;
                return false;
            });

            if (rejectedWithoutReason) {
                showToast('Please select a rejection reason for all rejected payments.', 'error');
                return;
            }

            const billing_id     = this.dataset.billingId;
            const firstSelect    = Array.from(statusSelects).find(s => s.value !== 'pending-tenant' && s.value !== 'inactive-tenant');
            const payment_status = firstSelect ? firstSelect.value : 'unpaid';
            const status_updates = Array.from(statusSelects)
                .filter(select => select.value !== 'pending-tenant' && select.value !== 'inactive-tenant')
                .map(select => {
                    const field    = select.closest('.modal-field');
                    const sel      = field ? field.querySelector('.rejection-reason-select') : null;
                    const ta       = field ? field.querySelector('.rejection-reason-input') : null;
                    let rejReason  = null;
                    if (select.value === 'rejected' && sel) {
                        rejReason = sel.value === 'other' ? (ta ? ta.value.trim() : null) : sel.value;
                    }
                    return {
                        billing_id:       parseInt(select.dataset.billingId),
                        payment_status:   select.value,
                        rejection_reason: rejReason,
                    };
                })
                .filter(update => Number.isInteger(update.billing_id));

            if (!billing_id) {
                showToast('No billing record for this room as all tenants are pending or inactive.', 'error');
                return;
            }

            const saveBtn = updateForm.querySelector('.btn-submit');

            const doSave = async (forcePaid = false) => {
                setButtonLoading(saveBtn, 'Saving...');
                showActionLoading('Saving billing changes...');

                try {
                    const response = await fetch("{{ route('billing.updateFull') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            billing_id               : parseInt(billing_id),
                            prev_reading             : parseFloat(prev),
                            curr_reading             : parseFloat(curr),
                            due_date                 : due,
                            payment_status           : payment_status,
                            status_updates           : status_updates,
                            force_paid_without_proof : forcePaid,
                        })
                    });

                    const data = await response.json();
                    if (response.ok && data.success) {
                        saveBtn.innerHTML = `<span style="font-size:1rem;">ok</span> Saved`;
                        showToast('Billing updated successfully.', 'success');
                        closeModal('update-modal');
                        hideActionLoading();
                        setTimeout(() => location.reload(), 800);
                    } else {
                        showToast(data.message || 'Failed to update. Please check your inputs.', 'error');
                        resetButton(saveBtn, 'Save changes');
                        hideActionLoading();
                    }
                } catch (err) {
                    showToast('Network error. Please try again.', 'error');
                    resetButton(saveBtn, 'Save changes');
                    hideActionLoading();
                }
            };

            const onsiteChecked = new Set(
                Array.from(document.querySelectorAll('.onsite-toggle:checked'))
                    .map(cb => parseInt(cb.dataset.billingId))
            );

            const hasPaidWithoutProofOrOnsite = status_updates.some(u => {
                if (u.payment_status !== 'paid') return false;
                if (onsiteChecked.has(u.billing_id)) return false;
                const billing = Array.from(statusSelects).find(s => parseInt(s.dataset.billingId) === u.billing_id);
                return !billing?.dataset.hasProof || billing.dataset.hasProof === 'false';
            });

            const forcePaid = onsiteChecked.size > 0;

            if (hasPaidWithoutProofOrOnsite) {
                showConfirm(
                    'Mark as paid without proof?',
                    'One or more tenants do not have a proof of payment and were not marked as onsite payments. Are you sure you want to continue?',
                    () => doSave(forcePaid)
                );
            } else {
                await doSave(forcePaid);
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

        const m3Input     = document.getElementById('log-maynilad-m3');
        const amountInput = document.getElementById('log-maynilad-amount');
        const monthInput  = document.getElementById('log-billing-month');
        const dueInput    = document.getElementById('log-due-date');

        let formValid = true;

        if (!validateLogDate(monthInput)) formValid = false;
        if (!validateLogDate(dueInput))   formValid = false;
        if (!validateLogField(m3Input))   formValid = false;
        if (!validateLogField(amountInput)) formValid = false;

        if (monthInput.value) {
            const [mYear, mMonth] = monthInput.value.split('-').map(Number);
            const now = new Date();
            if (mYear > now.getFullYear() || (mYear === now.getFullYear() && mMonth > now.getMonth() + 1)) {
                monthInput.classList.add('input-invalid');
                const errEl = monthInput.parentElement?.querySelector('.field-error');
                if (errEl) { errEl.textContent = 'Billing month cannot be in the future.'; errEl.classList.add('visible'); }
                formValid = false;
            }
        }

        if (monthInput.value && dueInput.value) {
            const [mYear, mMonth] = monthInput.value.split('-').map(Number);
            const billingStart = new Date(mYear, mMonth - 1, 1);
            const dueDateVal   = new Date(dueInput.value + 'T00:00:00');
            if (dueDateVal <= billingStart) {
                dueInput.classList.add('input-invalid');
                const errEl = dueInput.parentElement?.querySelector('.field-error');
                if (errEl) { errEl.textContent = 'Due date must be after the start of the billing month.'; errEl.classList.add('visible'); }
                formValid = false;
            }
        }

        const rows = document.querySelectorAll('.floor-reading-row');
        if (rows.length === 0) {
            showToast('Add at least one floor reading before logging.', 'error');
            return;
        }

        const floorsSeen = {};
        rows.forEach(row => {
            const floorSel  = row.querySelector('.frr-floor-sel');
            const prevInput = row.querySelector('[name$="[prev]"]');
            const currInput = row.querySelector('[name$="[curr]"]');
            const errEl     = row.querySelector('.frr-error');
            let rowOk = true;

            if (!floorSel?.value) {
                row.classList.add('row-error');
                if (errEl) { errEl.textContent = 'Select a floor for this row.'; errEl.classList.add('visible'); }
                formValid = false;
                rowOk = false;
            } else if (floorsSeen[floorSel.value]) {
                row.classList.add('row-error');
                if (errEl) { errEl.textContent = `Floor ${floorSel.value} is already added. Remove this duplicate.`; errEl.classList.add('visible'); }
                formValid = false;
                rowOk = false;
            } else {
                floorsSeen[floorSel.value] = true;
            }

            if (rowOk) {
                const prev = parseFloat(prevInput?.value);
                const curr = parseFloat(currInput?.value);
                const prevEmpty = !prevInput?.value && prevInput?.value !== '0';
                const currEmpty = !currInput?.value && currInput?.value !== '0';
                const errEl2 = row.querySelector('.frr-error');

                if (prevEmpty || isNaN(prev) || prev < 0) {
                    row.classList.add('row-error');
                    if (errEl2) { errEl2.textContent = 'Previous reading is required and must be 0 or greater.'; errEl2.classList.add('visible'); }
                    if (prevInput) prevInput.classList.add('input-invalid');
                    formValid = false;
                } else if (currEmpty || isNaN(curr) || curr < 0) {
                    row.classList.add('row-error');
                    if (errEl2) { errEl2.textContent = 'Current reading is required and must be 0 or greater.'; errEl2.classList.add('visible'); }
                    if (currInput) currInput.classList.add('input-invalid');
                    formValid = false;
                } else if (curr < prev) {
                    row.classList.add('row-error');
                    if (errEl2) { errEl2.textContent = 'Current reading cannot be less than previous reading.'; errEl2.classList.add('visible'); }
                    if (currInput) currInput.classList.add('input-invalid');
                    formValid = false;
                }
            }
        });

        if (!formValid) {
            showToast('Please fix the errors highlighted in red before submitting.', 'error');
            return;
        }

        const billingDate = new Date(monthInput.value);
        const dueDate     = new Date(dueInput.value);
        if (dueDate < billingDate) {
            showToast('Due date should not be before the billing month start.', 'error');
            dueInput.classList.add('input-invalid');
            return;
        }

        setButtonLoading(submitBtn, 'Logging...');
        showActionLoading('Logging water consumption...');

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
                showToast('Unexpected server response. Please contact support.', 'error');
                resetButton(submitBtn, 'Log and Distribute');
                hideActionLoading();
                return;
            }

            const data = await response.json();

            if (response.ok && data.success) {
                submitBtn.innerHTML = `<span style="font-size:1rem;">ok</span> Done`;
                showToast(data.message || 'Water billing logged successfully.', 'success');

                const billingMonth = document.getElementById('log-billing-month').value;
                const monthForUrl  = billingMonth + '-01';
                const floor        = document.getElementById('filter-floor').value;
                let   url          = "{{ route('billing.index') }}?month=" + monthForUrl;
                if (floor) url    += '&floor=' + floor;

                setTimeout(() => { window.location.href = url; }, 1000);

            } else {
                let errMsg = 'Failed to log billing. Please check your inputs.';
                if (data.message) errMsg = data.message;
                else if (data.errors) errMsg = Object.values(data.errors).flat().join(' ');
                showToast(errMsg, 'error');
                resetButton(submitBtn, 'Log and Distribute');
                hideActionLoading();
            }

        } catch (err) {
            showToast('Network error. Please check your connection and try again.', 'error');
            resetButton(submitBtn, 'Log and Distribute');
            hideActionLoading();
        }
    });
});

function exportBillingCsv() {
    const rows = [[
        'Billing Month',
        'Floor',
        'Due Date',
        'Floor Consumption (m3)',
        'Total Floor Bill',
        'Room Number',
        'Occupants',
        'Tenant',
        'Tenant Share',
        'Payment Status',
        'Reference Code',
        'Payment Submitted At'
    ]];

    billingExportGroups.forEach(function(group) {
        group.rooms.forEach(function(room) {
            room.tenants.filter(function(tenant) {
                return tenant.payment_status !== 'pending-tenant' && tenant.payment_status !== 'inactive-tenant';
            }).forEach(function(tenant) {
                rows.push([
                    selectedBillingMonth,
                    group.floor,
                    group.due_date,
                    group.floor_consumption_m3,
                    Number(group.total_floor_bill || 0).toFixed(2),
                    room.room_number,
                    room.occupants_in_room,
                    tenant.name,
                    Number(tenant.room_share || 0).toFixed(2),
                    tenant.payment_status,
                    tenant.payment_reference_code || '',
                    tenant.payment_submitted_at || ''
                ]);
            });
        });
    });

    if (rows.length === 1) {
        showToast('No billing data to export.', 'error');
        return;
    }

    const csv = rows
        .map(function(row) { return row.map(function(value) { return '"' + String(value ?? '').replace(/"/g, '""') + '"'; }).join(','); })
        .join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const a = document.createElement('a');
    const monthLabel = String(selectedBillingMonth || new Date().toISOString().slice(0, 10)).slice(0, 7);
    a.href = URL.createObjectURL(blob);
    a.download = 'water-billing-' + monthLabel + '.csv';
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(a.href);
    showToast('Billing data exported as CSV.', 'success');
}

function exportBillingPdf() {
    if (!billingExportGroups || billingExportGroups.length === 0) {
        showToast('No billing data to export.', 'error');
        return;
    }

    var win = window.open('', '_blank');
    var rows = '';
    billingExportGroups.forEach(function(group) {
        group.rooms.forEach(function(room) {
            room.tenants.filter(function(tenant) {
                return tenant.payment_status !== 'pending-tenant' && tenant.payment_status !== 'inactive-tenant';
            }).forEach(function(tenant) {
                rows += '<tr>'
                    + '<td>' + escHtml(group.floor) + '</td>'
                    + '<td>' + escHtml(String(room.room_number)) + '</td>'
                    + '<td>' + escHtml(tenant.name) + '</td>'
                    + '<td>' + Number(tenant.room_share || 0).toFixed(2) + '</td>'
                    + '<td>' + escHtml(tenant.payment_status || '') + '</td>'
                    + '<td>' + escHtml(group.due_date || '') + '</td>'
                    + '<td>' + escHtml(String(group.floor_consumption_m3 || '')) + ' m3</td>'
                    + '<td>P' + Number(group.total_floor_bill || 0).toFixed(2) + '</td>'
                    + '</tr>';
            });
        });
    });

    win.document.write('<!DOCTYPE html><html><head><title>Water Billing - ' + escHtml(selectedBillingMonth || '') + '</title>'
        + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
        + '</head><body>'
        + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
        + '<p>Water Billing - ' + escHtml(selectedBillingMonth || '') + ' - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
        + '<table><thead><tr><th>Floor</th><th>Room</th><th>Tenant</th><th>Share (P)</th><th>Status</th><th>Due Date</th><th>Consumption</th><th>Floor Total</th></tr></thead>'
        + '<tbody>' + rows + '</tbody></table>'
        + '</body></html>');
    win.document.close();
    win.print();
}

function escHtml(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function getMenuForDropdown(id) {
    return Array.from(document.querySelectorAll('.export-menu')).find(function(m) {
        return m._sourceDropdownId === id;
    }) || document.querySelector('#' + id + ' .export-menu');
}

function positionExportMenu(dropdown) {
    var btn  = dropdown.querySelector('button');
    var menu = getMenuForDropdown(dropdown.id);
    var rect = btn.getBoundingClientRect();

    if (!menu._movedToBody) {
        menu._sourceDropdownId = dropdown.id;
        document.body.appendChild(menu);
        menu._movedToBody = true;
    }

    menu.style.position = 'fixed';
    menu.style.zIndex   = '99999';
    menu.style.right    = (window.innerWidth - rect.right) + 'px';
    menu.style.left     = 'auto';
    menu.style.minWidth = rect.width + 'px';
    menu.style.top      = 'auto';
    menu.style.bottom   = 'auto';

    var menuHeight = menu.offsetHeight || 80;
    var spaceBelow = window.innerHeight - rect.bottom;

    if (spaceBelow >= menuHeight + 6) {
        menu.style.top    = (rect.bottom + 6) + 'px';
        menu.style.bottom = 'auto';
    } else {
        menu.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
        menu.style.top    = 'auto';
    }
}

function toggleExportDropdown(id) {
    var dropdown = document.getElementById(id);
    var menu     = getMenuForDropdown(id);
    var isOpen   = menu.classList.contains('open');
    closeAllExportDropdowns();
    if (!isOpen) {
        positionExportMenu(dropdown);
        getMenuForDropdown(id).classList.add('open');
    }
}

function closeAllExportDropdowns() {
    document.querySelectorAll('.export-menu').forEach(function(m) { m.classList.remove('open'); });
    var lp = document.getElementById('billing-legend-popup');
    if (lp) lp.classList.remove('open');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.export-dropdown')) {
        closeAllExportDropdowns();
    }
});

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

function umTab(name, btn) {
    document.querySelectorAll('.um-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.um-tab').forEach(b => {
        b.style.borderBottomColor = 'transparent';
        b.style.color = 'var(--ink-soft)';
        b.style.fontWeight = '600';
        const icon = b.querySelector('.tab-icon');
        if (icon) icon.style.filter = 'brightness(0) saturate(100%) invert(50%)';
    });
    document.getElementById('um-tab-' + name).style.display = 'block';
    btn.style.borderBottomColor = 'var(--bright-pink)';
    btn.style.color = 'var(--bright-pink)';
    btn.style.fontWeight = '700';
    const activeIcon = btn.querySelector('.tab-icon');
    if (activeIcon) activeIcon.style.filter = 'brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%)';
}

function openLightbox(proofUrl, tenantName) {
    document.getElementById('lb-img').src         = proofUrl;
    document.getElementById('lb-open-link').href  = proofUrl;
    document.getElementById('lb-tenant-name').textContent = tenantName + ' - Proof of Payment';
    document.getElementById('proof-lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('proof-lightbox').classList.remove('open');
    document.getElementById('lb-img').src = '';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeLightbox(); document.getElementById('confirm-dialog')?.classList.remove('open'); }
});

function openUpdateModal(room) {
    document.querySelectorAll('.um-panel').forEach(p => p.style.display = 'none');
    document.getElementById('um-tab-readings').style.display = 'block';
    document.querySelectorAll('.um-tab').forEach((b, i) => {
        b.style.borderBottomColor = i === 0 ? 'var(--bright-pink)' : 'transparent';
        b.style.color = i === 0 ? 'var(--bright-pink)' : 'var(--ink-soft)';
        b.style.fontWeight = i === 0 ? '700' : '600';
        const icon = b.querySelector('.tab-icon');
        if (icon) icon.style.filter = i === 0
            ? 'brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%)'
            : 'brightness(0) saturate(100%) invert(50%)';
    });

    document.getElementById('um-room-title').textContent = 'Room ' + room.room_number;
    document.getElementById('um-room-sub').textContent = 'Floor ' + room.floor + ' - ' + room.occupants_in_room + ' occupant' + (room.occupants_in_room !== 1 ? 's' : '');

    const prevField = document.getElementById('edit-prev');
    const currField = document.getElementById('edit-curr');
    prevField.value = parseFloat(room.prev_reading ?? 0).toFixed(2);
    currField.value = parseFloat(room.curr_reading ?? 0).toFixed(2);
    prevField.classList.remove('input-invalid', 'input-valid');
    currField.classList.remove('input-invalid', 'input-valid');

    const dueDateField = document.getElementById('edit-due-date');
    dueDateField.value = room.due_date !== '--' ? new Date(room.due_date).toISOString().split('T')[0] : '';
    dueDateField.removeAttribute('min');
    dueDateField.classList.remove('input-invalid');

    const errEl = document.getElementById('edit-reading-error');
    if (errEl) errEl.classList.remove('visible');

    const initCons = Math.max(0, parseFloat(room.curr_reading ?? 0) - parseFloat(room.prev_reading ?? 0));
    document.getElementById('um-disp-cons').textContent  = initCons.toFixed(2) + ' m3';
    document.getElementById('um-disp-total').textContent = 'P' + parseFloat(room.total_floor_bill ?? 0).toFixed(2);
    const firstBilledTenant = room.tenants.find(t => t.payment_status !== 'pending-tenant' && t.payment_status !== 'inactive-tenant');
    document.getElementById('um-disp-share').textContent = firstBilledTenant ? 'P' + parseFloat(firstBilledTenant.room_share ?? 0).toFixed(2) : '--';
    recalcUpdateShare();

    let paymentsHtml = '';
    room.tenants.forEach(function(t) {
        const initials     = t.name.split(' ').slice(0,2).map(n => n[0]).join('');
        const isPaid       = t.payment_status === 'paid';
        const hasProof     = t.proof_of_payment_url ? 'true' : 'false';
        const safeProofUrl = t.proof_of_payment_url ? t.proof_of_payment_url : '';
        const receiptBtn   = isPaid && t.billing_id
            ? `<a href="/billing/receipt/${t.billing_id}" target="_blank" class="btn-receipt" style="margin-top:8px;">
                   <img src="/icons/export.png" alt="" style="width:13px;height:13px;filter:brightness(0) invert(1);flex-shrink:0;">
                   Download invoice
               </a>`
            : '';

        const isPendingOrInactive = t.payment_status === 'pending-tenant' || t.payment_status === 'inactive-tenant';

        const predefinedReasons = ['Blurry or unreadable image','Wrong reference number','Amount does not match','Payment already expired','Duplicate submission','No proof attached'];
        const currentRejReason  = t.rejection_reason || '';
        const isOtherReason     = currentRejReason && !predefinedReasons.some(r => r === currentRejReason);
        const rejReasonSelect   = predefinedReasons.map(r => `<option value="${escapeHtml(r)}" ${currentRejReason === r ? 'selected' : ''}>${escapeHtml(r)}</option>`).join('') + `<option value="other" ${isOtherReason ? 'selected' : ''}>Other (specify)</option>`;

        const textareaDisplay = isOtherReason ? 'block' : 'none';
        const textareaValue   = isOtherReason ? escapeHtml(currentRejReason) : '';
        const counterDisplay  = isOtherReason ? 'block' : 'none';
        const charCount       = isOtherReason ? currentRejReason.length : 0;

        const noProofWarning = !isPendingOrInactive && !t.proof_of_payment_url
            ? `<div class="inline-notice inline-notice-warn" style="margin-top:.6rem;">No proof of payment has been uploaded. If this tenant paid in person or via cash, enable the onsite payment toggle below and then set the status to Paid.</div>`
            : '';

        const onsiteToggle = !isPendingOrInactive
            ? `<div style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;margin-top:.75rem;padding:.65rem .85rem;border-radius:12px;background:var(--pink-bg-soft);border:1.5px solid var(--border-pink);">
                <div>
                    <div style="font-size:.8rem;font-weight:700;color:var(--ink-deep);">Paid onsite (face to face)</div>
                    <div style="font-size:.72rem;color:var(--ink-soft);margin-top:.1rem;">Toggle this if the tenant paid in person. No proof required.</div>
                </div>
                <label style="position:relative;display:inline-flex;align-items:center;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" class="onsite-toggle" data-billing-id="${t.billing_id??''}" style="opacity:0;width:0;height:0;position:absolute;"
                        onchange="handleOnsiteToggle(this)" ${t.payment_status === 'paid' && !t.proof_of_payment_url ? 'checked' : ''}>
                    <div class="onsite-track"></div>
                </label>
              </div>`
            : '';

        paymentsHtml += `
            <div style="border:1.5px solid var(--border-pink);border-radius:14px;overflow:hidden;margin-bottom:12px;">
                <div style="padding:.7rem 1rem;background:var(--pink-bg-soft);display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--border-pink-mid);">
                    <div style="width:30px;height:30px;border-radius:50%;background:#fff0f6;color:var(--bright-pink);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">${initials}</div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;color:var(--ink-deep);">${escapeHtml(t.name)}${t.is_temp_password ? '<span title="Tenant has not activated their app account yet" style="display:inline-flex;align-items:center;justify-content:center;width:15px;height:15px;border-radius:50%;background:#f2f2f5;border:1px solid #e0e0e8;flex-shrink:0;margin-left:4px;vertical-align:middle;position:relative;top:-1px;"><svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#b0b0c0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></span>' : ''}</div>
                        <div style="font-size:12px;color:var(--ink-soft);">${isPendingOrInactive ? 'No billing record' : 'Share: P' + parseFloat(t.room_share).toFixed(2)}</div>
                    </div>
                    <span class="badge badge-${String(t.payment_status||'unpaid').replaceAll(' ','-')}">${getBadgeLabel(t.payment_status)}</span>
                </div>
                <div style="padding:.9rem 1rem;">
                    <div class="modal-field">
                        <label>Payment status</label>
                        <select class="status-select" data-billing-id="${t.billing_id??''}" data-has-proof="${hasProof}" onchange="toggleRejectionReason(this)">
                            <option value="unpaid"   ${t.payment_status==='unpaid'  ?'selected':''}>Unpaid</option>
                            <option value="paid"     ${t.payment_status==='paid'    ?'selected':''}>Paid</option>
                            <option value="overdue"  ${t.payment_status==='overdue' ?'selected':''}>Overdue</option>
                            <option value="pending"  ${t.payment_status==='pending' ?'selected':''}>Pending</option>
                            <option value="rejected" ${t.payment_status==='rejected'?'selected':''}>Rejected</option>
                            <option value="pending-tenant"  disabled ${t.payment_status==='pending-tenant' ?'selected':''}>Pending Tenant</option>
                            <option value="inactive-tenant" disabled ${t.payment_status==='inactive-tenant'?'selected':''}>Inactive Tenant</option>
                        </select>
                        <div class="rejection-reason-wrap ${t.payment_status==='rejected'?'visible':''}">
                            <label class="rejection-reason-label">Reason for rejection</label>
                            <select class="rejection-reason-select" onchange="toggleRejectionOther(this)" style="width:100%;padding:.55rem .8rem;border-radius:10px;border:1.5px solid #ffb380;background:#fff8f4;font-size:.82rem;color:var(--ink-deep);font-family:inherit;outline:none;box-sizing:border-box;margin-bottom:.4rem;cursor:pointer;">
                                <option value="">Select a reason</option>
                                ${rejReasonSelect}
                            </select>
                            <textarea class="rejection-reason-input" rows="2" maxlength="500" placeholder="Describe the reason" style="display:${textareaDisplay};" oninput="updateCharCounter(this)">${textareaValue}</textarea>
                            <div class="char-counter" style="display:${counterDisplay};">${charCount} / 500</div>
                        </div>
                    </div>
                    ${noProofWarning}
                    ${onsiteToggle}
                    ${receiptBtn}
                </div>
            </div>`;
    });
    document.getElementById('um-tenant-statuses').innerHTML = paymentsHtml;

    let proofHtml = '';
    room.tenants.filter(t => t.payment_status !== 'pending-tenant' && t.payment_status !== 'inactive-tenant').forEach(function(t) {
        const refCode  = t.payment_reference_code ? escapeHtml(t.payment_reference_code) : '--';
        const subAt    = t.payment_submitted_at   ? escapeHtml(t.payment_submitted_at)   : '--';
        const proofUrl = t.proof_of_payment_url   ? escapeHtml(t.proof_of_payment_url)   : '';
        const safeUrl  = t.proof_of_payment_url   ? t.proof_of_payment_url               : '';
        const safeName = t.name;

        const imgHtml = proofUrl
            ? `<div style="border:1px solid var(--border-pink);border-radius:12px;overflow:hidden;background:var(--white);cursor:pointer;"
                    onclick="openLightbox('${safeUrl.replace(/'/g,"\\'")}', '${safeName.replace(/'/g,"\\'")}')">
                   <img src="${proofUrl}" style="width:100%;max-height:200px;object-fit:contain;display:block;transition:opacity .15s;"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
               </div>`
            : `<div style="border:1.5px dashed var(--border-pink);border-radius:12px;padding:1.2rem;text-align:center;color:var(--ink-soft);font-size:13px;background:var(--pink-bg-soft);">No proof of payment submitted yet.</div>`;

        proofHtml += `
            <div style="margin-bottom:16px;">
                <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--ink-soft);border-bottom:1px solid var(--border-pink-mid);padding-bottom:6px;margin-bottom:10px;">${escapeHtml(t.name)}</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px;">
                    <div style="padding:.5rem .7rem;border:1px solid var(--border-pink-mid);border-radius:10px;background:var(--pink-bg-soft);">
                        <div style="font-size:10px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">Reference</div>
                        <div style="font-size:12.5px;font-weight:700;color:var(--ink-deep);margin-top:2px;">${refCode}</div>
                    </div>
                    <div style="padding:.5rem .7rem;border:1px solid var(--border-pink-mid);border-radius:10px;background:var(--pink-bg-soft);">
                        <div style="font-size:10px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">Submitted</div>
                        <div style="font-size:12.5px;font-weight:700;color:var(--ink-deep);margin-top:2px;">${subAt}</div>
                    </div>
                </div>
                ${imgHtml}
            </div>`;
    });
    document.getElementById('um-proof-content').innerHTML = proofHtml ||
        `<div style="border:1.5px dashed var(--border-pink);border-radius:12px;padding:1.4rem;text-align:center;color:var(--ink-soft);font-size:13px;background:var(--pink-bg-soft);">No active tenants with billing in this room.</div>`;

    const primaryBilling = room.tenants.find(t => t.billing_id && t.payment_status !== 'pending-tenant' && t.payment_status !== 'inactive-tenant');
    document.getElementById('update-form').dataset.billingId = primaryBilling?.billing_id ?? '';
    openModal('update-modal');
}

function enforceIntegerInput(input) {
    if (input._intEnforced) return;
    input._intEnforced = true;
    input.addEventListener('keydown', function(e) {
        var allowed = ['Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Tab','Home','End'];
        if (allowed.indexOf(e.key) !== -1 || e.ctrlKey || e.metaKey) return;
        if (!/^\d$/.test(e.key)) e.preventDefault();
    });
    input.addEventListener('input', function() {
        var clean = this.value.replace(/[^\d]/g, '');
        if (this.value !== clean) this.value = clean;
    });
    input.addEventListener('paste', function(e) {
        e.preventDefault();
        var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^\d]/g, '');
        var max = parseInt(this.getAttribute('maxlength')) || 20;
        this.value = (this.value + pasted).substring(0, max);
        this.dispatchEvent(new Event('input'));
    });
}

function enforceDecimalInput(input) {
    if (input._decimalEnforced) return;
    input._decimalEnforced = true;
    input.addEventListener('keydown', function(e) {
        var allowed = ['Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Tab','Home','End'];
        if (allowed.indexOf(e.key) !== -1 || e.ctrlKey || e.metaKey) return;
        if (e.key === '.' && this.value.indexOf('.') === -1) return;
        if (!/^\d$/.test(e.key)) e.preventDefault();
    });
    input.addEventListener('input', function() {
        var clean = this.value.replace(/[^\d.]/g, '');
        var parts = clean.split('.');
        if (parts.length > 2) clean = parts[0] + '.' + parts.slice(1).join('');
        if (this.value !== clean) this.value = clean;
    });
    input.addEventListener('paste', function(e) {
        e.preventDefault();
        var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^\d.]/g, '');
        var combined = this.value + pasted;
        var parts = combined.split('.');
        if (parts.length > 2) combined = parts[0] + '.' + parts.slice(1).join('');
        this.value = combined;
        this.dispatchEvent(new Event('input'));
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var decimalIds = [
        'log-maynilad-m3',
        'log-maynilad-amount',
        'edit-prev',
        'edit-curr'
    ];
    decimalIds.forEach(function(id) {
        var el = document.getElementById(id);
        if (el) enforceDecimalInput(el);
    });

    var origAddFloorRowEnforce = window.addFloorRow;
    window.addFloorRow = function(defaultFloor) {
        origAddFloorRowEnforce(defaultFloor);
        setTimeout(function() {
            document.querySelectorAll('.floor-reading-row').forEach(function(row) {
                var prevInp = row.querySelector('[name$="[prev]"]');
                var currInp = row.querySelector('[name$="[curr]"]');
                if (prevInp) enforceDecimalInput(prevInp);
                if (currInp) enforceDecimalInput(currInp);
            });
        }, 30);
    };
});

function refreshLogProgress() {
    var m3El     = document.getElementById('log-maynilad-m3');
    var amountEl = document.getElementById('log-maynilad-amount');
    var monthEl  = document.getElementById('log-billing-month');
    var dueEl    = document.getElementById('log-due-date');
    var fill     = document.getElementById('log-progress-fill');
    var text     = document.getElementById('log-progress-text');
    var count    = document.getElementById('log-progress-count');
    if (!fill || !text || !count) return;

    var fields = [m3El, amountEl, monthEl, dueEl];
    var filled = fields.filter(function(el) {
        return el && el.value && el.value.trim() !== '' && parseFloat(el.value) !== 0;
    }).length;

    var rows         = document.querySelectorAll('.floor-reading-row');
    var floorRowsFilled = Array.from(rows).every(function(row) {
        var prevInput = row.querySelector('[name$="[prev]"]');
        var currInput = row.querySelector('[name$="[curr]"]');
        var prevOk = prevInput && prevInput.value && prevInput.value.trim() !== '';
        var currOk = currInput && currInput.value && currInput.value.trim() !== '';
        return prevOk && currOk;
    });
    var hasFloorRows = rows.length > 0;
    var total        = fields.length + 1;
    var filledTotal  = filled + (hasFloorRows && floorRowsFilled ? 1 : 0);
    var pct          = Math.round((filledTotal / total) * 100);

    fill.style.width = pct + '%';

    if (pct === 100) {
        fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
        text.textContent = 'All required fields filled';
        text.className = 'ready';
        count.textContent = filledTotal + '/' + total;
        count.className = 'ready';
    } else if (pct >= 50) {
        fill.style.background = 'linear-gradient(90deg,#E8175D,#FF2D78)';
        text.textContent = 'Almost there';
        text.className = 'partial';
        count.textContent = filledTotal + '/' + total;
        count.className = 'partial';
    } else {
        fill.style.background = 'linear-gradient(90deg,#E8175D,#FF2D78)';
        text.textContent = 'Fill in required fields';
        text.className = '';
        count.textContent = filledTotal + '/' + total;
        count.className = '';
    }
}

function refreshUmProgress() {
    var currEl = document.getElementById('edit-curr');
    var dueEl  = document.getElementById('edit-due-date');
    var fill   = document.getElementById('um-progress-fill');
    var text   = document.getElementById('um-progress-text');
    var count  = document.getElementById('um-progress-count');
    if (!fill || !text || !count) return;

    var prevEl = document.getElementById('edit-prev');
    var fields = [prevEl, currEl, dueEl];
    var filled = fields.filter(function(el) {
        return el && el.value && el.value.trim() !== '';
    }).length;
    var total = fields.length;
    var pct   = Math.round((filled / total) * 100);

    fill.style.width = pct + '%';

    if (pct === 100) {
        fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
        text.textContent = 'Required fields complete';
        text.className = 'ready';
        count.textContent = filled + '/' + total;
        count.className = 'ready';
    } else {
        fill.style.background = 'linear-gradient(90deg,#E8175D,#FF2D78)';
        text.textContent = 'Fill in required fields';
        text.className = '';
        count.textContent = filled + '/' + total;
        count.className = 'partial';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var logModal = document.getElementById('log-modal');
    if (logModal) {
        logModal.addEventListener('input', refreshLogProgress);
        logModal.addEventListener('change', refreshLogProgress);
    }

    var updateModal = document.getElementById('update-modal');
    if (updateModal) {
        updateModal.addEventListener('input', function(e) {
            if (e.target.id === 'edit-curr' || e.target.id === 'edit-due-date') {
                refreshUmProgress();
            }
        });
        updateModal.addEventListener('change', function(e) {
            if (e.target.id === 'edit-curr' || e.target.id === 'edit-due-date') {
                refreshUmProgress();
            }
        });
    }

    var origOpenLogModal = window.openLogModal;
    window.openLogModal = function() {
        origOpenLogModal();
        setTimeout(refreshLogProgress, 80);
    };

    var origOpenUpdateModal = window.openUpdateModal;
    window.openUpdateModal = function(room) {
        origOpenUpdateModal(room);
        setTimeout(refreshUmProgress, 80);
    };

    var origAddFloorRow = window.addFloorRow;
    window.addFloorRow = function(defaultFloor) {
        origAddFloorRow(defaultFloor);
        setTimeout(refreshLogProgress, 50);
    };

    var origRemoveFloorRow = window.removeFloorRow;
    window.removeFloorRow = function(btn) {
        origRemoveFloorRow(btn);
        setTimeout(refreshLogProgress, 50);
    };
});

@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session("success") }}', 'success');
    });
@endif

</script>
@endsection