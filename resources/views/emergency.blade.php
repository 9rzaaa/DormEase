@extends('layout')

@section('title', 'DormEase: Emergency Reports')
@section('page-title', 'Emergency Reports')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        background: var(--pink-bg);
        box-sizing: border-box;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header-text h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.15;
        margin: 0;
    }

    .page-header-text .dorm-sub {
        font-size: .95rem;
        font-weight: 600;
        color: var(--bright-pink);
        margin-top: .2rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .btn-archive-open {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .6rem 1.2rem;
        border-radius: 12px;
        background: var(--white);
        color: var(--hot-pink);
        border: 1.5px solid var(--pink-100);
        font-size: .87rem;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
        white-space: nowrap;
        font-family: var(--ff-body);
        letter-spacing: .01em;
    }

    .btn-archive-open:hover {
        border-color: var(--bright-pink);
        color: var(--bright-pink);
        box-shadow: 0 6px 16px rgba(232,23,93,.12);
    }

    .btn-archive-open img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.2rem;
        box-sizing: border-box;
    }

    .stat-card {
        background: var(--gradient-pink);
        border-radius: 18px;
        border: none;
        box-shadow: 0 8px 18px rgba(0,0,0,.05), 0 18px 40px rgba(232,23,93,.25);
        padding: 1.4rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        box-sizing: border-box;
        min-width: 0;
        overflow: hidden;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        flex-shrink: 0;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,.15);
        padding: 0;
        box-sizing: border-box;
    }

    .stat-icon img {
        width: 28px;
        height: 28px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .stat-num {
        font-size: 2rem;
        font-weight: 700;
        color: var(--white);
        line-height: 1;
    }

    .stat-label {
        font-size: .8rem;
        color: rgba(247,245,245,.967);
        font-weight: 700;
        margin-bottom: .15rem;
        text-transform: none;
        letter-spacing: normal;
    }

    .table-card {
        background: var(--white);
        border-radius: 18px;
        border: 2px solid var(--bright-pink);
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(255,45,120,.1);
    }

    .table-topbar {
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .8rem;
        border-bottom: 2px solid var(--bright-pink);
        background: var(--white);
    }

    .table-heading {
        font-size: 1rem;
        font-weight: 800;
        color: var(--ink);
    }

    .table-sub {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .table-controls {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-box input {
        padding: .45rem .85rem .45rem 2rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--pink-50);
        font-size: .82rem;
        color: var(--ink);
        outline: none;
        width: 170px;
        font-family: var(--ff-body);
        transition: border-color .2s, width .3s;
    }

    .search-box input:focus {
        border-color: var(--bright-pink);
        background: var(--white);
        width: 210px;
    }

    .search-icon {
        position: absolute;
        left: .6rem;
        width: 14px;
        height: 14px;
        object-fit: contain;
        opacity: .4;
        pointer-events: none;
    }

    .filter-select {
        padding: .45rem 1.8rem .45rem .75rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--pink-50);
        color: var(--ink);
        font-size: .81rem;
        font-weight: 600;
        font-family: var(--ff-body);
        cursor: pointer;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .6rem center;
        transition: border-color .2s;
    }

    .filter-select:focus {
        border-color: var(--bright-pink);
        background-color: var(--white);
    }

    .date-filter {
        display: flex;
        align-items: center;
        gap: .35rem;
        padding: .35rem .65rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--pink-50);
    }

    .date-filter input {
        border: none;
        outline: none;
        background: transparent;
        color: var(--ink);
        font-size: .81rem;
        font-weight: 600;
        font-family: var(--ff-body);
    }

    .date-filter span {
        color: var(--ink-muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: .88rem;
    }

    thead th {
        padding: .75rem .85rem;
        text-align: center;
        font-size: .78rem;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        background: var(--pink-100);
        border-bottom: 2px solid var(--bright-pink);
        white-space: nowrap;
    }

    tbody tr {
        border-bottom: 2px solid var(--pink-100);
        transition: background .15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--pink-50); }

    tbody td {
        padding: .8rem .85rem;
        color: var(--ink);
        vertical-align: middle;
        text-align: center;
        font-weight: 500;
    }

    .type-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .panic-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--bright-pink);
        flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(255,45,120,.2);
        animation: pulseDot 1.5s infinite;
    }

    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%       { transform: scale(1.4); opacity: .7; }
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .22rem .65rem;
        border-radius: 999px;
        font-size: .71rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-pending  { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .badge-active   { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .badge-ongoing  { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .badge-resolved { background: #e8faf5; color: #1a9d6e; border: 1px solid #8cdebb; }
    .badge-panic    { background: var(--bright-pink); color: var(--white); border: none; }
    .badge-critical { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .badge-urgent   { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .badge-moderate { background: #eef2ff; color: #4f6ef7; border: 1px solid #c7d2fe; }

    .location-cell,
    .date-cell,
    .reporter-cell,
    .desc-cell {
        font-size: .84rem;
    }

    .date-cell { white-space: nowrap; color: var(--ink-muted); }

    .reporter-name { font-weight: 600; color: var(--ink); }

    .reporter-room {
        font-size: .76rem;
        color: var(--ink-muted);
        margin-top: .08rem;
    }

    .desc-cell {
        color: var(--ink-muted);
        line-height: 1.35;
        overflow-wrap: break-word;
    }

    .action-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
    }

    .act-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
        font-family: var(--ff-body);
    }

    .act-btn:hover {
        border-color: var(--bright-pink);
        box-shadow: 0 3px 10px rgba(255,45,120,.15);
    }

    .act-btn img {
        width: 16px;
        height: 16px;
        object-fit: contain;
        object-position: center;
    }

    .act-btn.danger:hover { border-color: #e04867; }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .8rem 1.2rem;
        flex-wrap: wrap;
        gap: .5rem;
        border-top: 1.5px solid var(--pink-100);
    }

    .showing-label {
        font-size: .78rem;
        color: var(--ink-muted);
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 .5rem;
        border-radius: 8px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        color: var(--hot-pink);
        font-size: .81rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        transition: .2s;
    }

    .page-btn:hover:not(:disabled) {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border-color: transparent;
    }

    .page-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(255,45,120,.25);
    }

    .page-btn:disabled { opacity: .35; cursor: default; }

    .empty-row td {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--ink-muted);
        font-size: .9rem;
    }

    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .9rem;
        margin-bottom: 1.2rem;
    }

    .modal-field-full { grid-column: 1 / -1; }

    .em-modal-field {
        display: flex;
        flex-direction: column;
        gap: .35rem;
    }

    .em-modal-field label {
        font-size: .76rem;
        font-weight: 700;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .em-modal-field input,
    .em-modal-field select,
    .em-modal-field textarea {
        width: 100%;
        padding: .6rem .9rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--pink-50);
        font-size: .875rem;
        color: var(--ink);
        font-family: var(--ff-body);
        outline: none;
        box-sizing: border-box;
        transition: border-color .2s, background .2s;
    }

    .em-modal-field textarea { min-height: 90px; resize: vertical; }

    .em-modal-field input:focus,
    .em-modal-field select:focus,
    .em-modal-field textarea:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }

    .view-detail-row {
        display: flex;
        flex-direction: column;
        gap: .18rem;
        padding: .7rem 0;
        border-bottom: 1px solid var(--pink-100);
    }

    .view-detail-row:last-child { border-bottom: none; }

    .view-detail-label {
        font-size: .7rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .view-detail-val {
        font-size: .875rem;
        color: var(--ink);
        font-weight: 500;
        line-height: 1.5;
    }

    .delete-warn {
        background: #fff0f0;
        border: 1.5px solid #ffc8d0;
        border-radius: 10px;
        padding: .7rem 1rem;
        font-size: .83rem;
        color: #c0303a;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .panic-banner {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-size: .84rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .panic-banner img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        filter: brightness(0) invert(1);
        flex-shrink: 0;
    }

    .fade-up { animation: fdFadeUp .45s ease both; }
    @keyframes fdFadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s; }

    .archive-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(232, 23, 93, 0.15);
        backdrop-filter: blur(3px);
        z-index: 499;
        opacity: 0;
        pointer-events: none;
        transition: opacity .38s ease;
    }

    .archive-backdrop.open { opacity: 1; pointer-events: auto; }

    .archive-drawer {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        width: min(680px, 100vw);
        background: var(--pink-bg);
        z-index: 500;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(0,0,0,.25);
    }

    .archive-drawer.open { transform: translateX(0); }

    .archive-drawer-header {
        padding: 1.6rem 1.8rem 1.2rem;
        border-bottom: 2px solid var(--bright-pink);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        background: var(--white);
        flex-shrink: 0;
    }

    .archive-drawer-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .archive-drawer-sub {
        font-size: .78rem;
        color: var(--ink-muted);
        margin-top: .25rem;
        font-weight: 500;
    }

    .archive-close-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: var(--white);
        border: 1.5px solid var(--pink-200);
        color: var(--hot-pink);
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
        flex-shrink: 0;
    }

    .archive-close-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .archive-tabs {
        display: flex;
        gap: 0;
        padding: 0 1.8rem;
        border-bottom: 1.5px solid var(--pink-100);
        background: var(--white);
        flex-shrink: 0;
    }

    .archive-tab {
        padding: .85rem 1.2rem;
        font-size: .82rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        cursor: pointer;
        transition: color .2s, border-color .2s;
        display: flex;
        align-items: center;
        gap: .5rem;
        font-family: var(--ff-body);
    }

    .archive-tab:hover,
    .archive-tab.active {
        color: var(--hot-pink);
        border-bottom-color: var(--hot-pink);
    }

    .archive-tab-count {
        font-size: .68rem;
        font-weight: 800;
        padding: .1rem .45rem;
        border-radius: 99px;
        background: var(--pink-100);
        color: var(--hot-pink);
    }

    .archive-search-bar {
        padding: 1rem 1.8rem .8rem;
        flex-shrink: 0;
    }

    .archive-search-inner {
        position: relative;
        display: flex;
        align-items: center;
    }

    .archive-search-inner input {
        width: 100%;
        padding: .55rem .9rem .55rem 2.2rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        color: var(--ink);
        font-size: .83rem;
        font-family: var(--ff-body);
        outline: none;
        transition: border-color .2s, background .2s;
    }

    .archive-search-inner input:focus { border-color: var(--bright-pink); }

    .archive-search-icon {
        position: absolute;
        left: .75rem;
        width: 13px;
        height: 13px;
        opacity: .35;
        pointer-events: none;
    }

    .archive-list {
        flex: 1;
        overflow-y: auto;
        padding: 0 1.8rem 1.8rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .archive-card {
        background: var(--white);
        border: 1.5px solid var(--pink-200);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s, transform .2s;
        animation: archiveSlideIn .3s ease both;
    }

    @keyframes archiveSlideIn {
        from { opacity: 0; transform: translateX(12px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .archive-card:hover {
        background: var(--pink-50);
        border-color: var(--bright-pink);
        box-shadow: 0 6px 18px rgba(232, 23, 93, .12);
        transform: translateY(-1px);
    }

    .archive-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .8rem;
        margin-bottom: .65rem;
    }

    .archive-card-id {
        font-size: .78rem;
        font-weight: 800;
        color: var(--hot-pink);
        letter-spacing: .02em;
    }

    .archive-card-time {
        font-size: .7rem;
        color: var(--ink-muted);
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .archive-card-title {
        font-size: .88rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.3;
    }

    .archive-card-room {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .archive-card-meta {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-top: .65rem;
        flex-wrap: wrap;
    }

    .archive-pill {
        font-size: .68rem;
        font-weight: 800;
        padding: .18rem .55rem;
        border-radius: 99px;
        letter-spacing: .03em;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .archive-pill-type { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .archive-pill-critical { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .archive-pill-urgent { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .archive-pill-moderate { background: #eef2ff; color: #4f6ef7; border: 1px solid #c7d2fe; }

    .archive-card-desc {
        font-size: .78rem;
        color: var(--ink-muted);
        margin-top: .5rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .archive-card-archived {
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-top: .75rem;
        padding-top: .6rem;
        border-top: 1px solid var(--pink-100);
        font-size: .7rem;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .archive-card-archived span { color: var(--bright-pink); font-weight: 700; }

    .archive-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
    }

    .archive-empty-icon {
        width: 40px;
        height: 40px;
        margin: 0 auto .75rem;
        opacity: .25;
        display: block;
    }

    .archive-footer {
        padding: .9rem 1.8rem;
        border-top: 2px solid var(--pink-100);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .archive-count-label {
        font-size: .75rem;
        color: var(--ink-muted);
        font-weight: 600;
    }

    .archive-export-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .75rem;
        font-weight: 700;
        color: var(--hot-pink);
        background: var(--white);
        border: 1.5px solid var(--pink-200);
        border-radius: 8px;
        padding: .35rem .85rem;
        cursor: pointer;
        transition: .2s;
        font-family: var(--ff-body);
    }

    .archive-export-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .65; }

    @media (max-width: 900px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .modal-grid { grid-template-columns: 1fr; }
        .archive-tabs { padding: 0 1rem; }
        .archive-drawer-header { padding: 1.2rem 1rem .9rem; }
        .archive-list { padding: 0 1rem 1.2rem; }
        .archive-search-bar { padding: .8rem 1rem .6rem; }
        .archive-footer { padding: .75rem 1rem; }
    }

    @media (max-width: 580px) {
        .stats-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-text">
            <h1>Emergency Reports</h1>
            <div class="dorm-sub">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-archive-open" onclick="openArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/nav-emerg.png') }}" alt="">
            </div>
            <div>
                <div class="stat-label">Total Emergencies</div>
                <div class="stat-num">{{ $totalCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/warn.png') }}" alt="">
            </div>
            <div>
                <div class="stat-label">Critical Emergencies</div>
                <div class="stat-num">{{ $criticalCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/resolved.png') }}" alt="">
            </div>
            <div>
                <div class="stat-label">Resolved Emergencies</div>
                <div class="stat-num">{{ $resolvedCount }}</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-topbar">
            <div>
                <div class="table-heading">All Emergencies</div>
                <div class="table-sub" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div class="search-box">
                    <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                    <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
                </div>
                <select class="filter-select" id="status-filter" onchange="applyFilters()">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="active">Active</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="resolved">Resolved</option>
                </select>
                <select class="filter-select" id="type-filter" onchange="applyFilters()">
                    <option value="">All Types</option>
                </select>
                <select class="filter-select" id="urgency-filter" onchange="applyFilters()">
                    <option value="">All Urgency</option>
                    <option value="critical">Critical</option>
                    <option value="urgent">Urgent</option>
                    <option value="moderate">Moderate</option>
                </select>
                <select class="filter-select" id="sort-select" onchange="applyFilters()">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
                <div class="date-filter">
                    <input type="date" id="date-from" onchange="applyFilters()">
                    <span>to</span>
                    <input type="date" id="date-to" onchange="applyFilters()">
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Urgency</th>
                        <th>Location</th>
                        <th>Date &amp; Time</th>
                        <th>Description</th>
                        <th>Staff / Tenant</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="em-tbody"></tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-label" id="showing-label"></div>
            <div class="pagination" id="pagination"></div>
        </div>
    </div>

</div>
@endsection

@section('modals')

<div class="archive-backdrop" id="archive-backdrop" onclick="closeArchive()"></div>

<div class="archive-drawer" id="archive-drawer">
    <div class="archive-drawer-header">
        <div>
            <div class="archive-drawer-title">Archive / History</div>
            <div class="archive-drawer-sub">Record of resolved and deleted emergency reports</div>
        </div>
        <button class="archive-close-btn" onclick="closeArchive()">&#x2715;</button>
    </div>

    <div class="archive-tabs">
        <button class="archive-tab active" id="atab-resolved" onclick="switchArchiveTab('resolved')">
            Resolved
            <span class="archive-tab-count" id="acount-resolved">0</span>
        </button>
        <button class="archive-tab" id="atab-deleted" onclick="switchArchiveTab('deleted')">
            Deleted
            <span class="archive-tab-count" id="acount-deleted">0</span>
        </button>
    </div>

    <div class="archive-search-bar">
        <div class="archive-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="archive-search-icon" alt="">
            <input type="text" id="archive-search" placeholder="Search archived emergencies..." oninput="renderArchive()">
        </div>
    </div>

    <div class="archive-list" id="archive-list"></div>

    <div class="archive-footer">
        <div class="archive-count-label" id="archive-count-label">0 records</div>
        <button class="archive-export-btn" onclick="exportArchive()">
            <img src="{{ asset('icons/export.png') }}" alt="">
            Export CSV
        </button>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Emergency Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit / Update</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Update Emergency Report</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
        </div>
        <div class="modal-grid">
            <div class="em-modal-field">
                <label>Status</label>
                <select id="edit-status">
                    <option value="pending">Pending</option>
                    <option value="active">Active</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>
            <div class="em-modal-field">
                <label>Location</label>
                <input type="text" id="edit-location" placeholder="e.g. Room 301">
            </div>
            <div class="em-modal-field modal-field-full">
                <label>Admin Notes</label>
                <textarea id="edit-notes" placeholder="Add notes or action taken..."></textarea>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
            <button type="button" class="btn-submit" onclick="submitUpdate()">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Delete Report</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <div class="delete-warn">This emergency report will be removed from the active list and saved to archive history.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Delete report for <strong id="delete-label" style="color:var(--ink);"></strong>?
        </p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <button type="button" class="btn-submit" style="background:var(--red);" onclick="submitDelete()">Delete</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const reports         = @json($reports);
    const resolvedArchive = @json($resolvedArchive);
    const deletedArchive  = @json($deletedArchive);
    const PER_PAGE = 8;
    let currentPage = 1;
    let filtered    = [...reports];
    let currentRep  = null;
    let deleteId    = null;
    let archiveTab  = 'resolved';

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    const normalizeFilterValue = value => String(value ?? '').trim().toLowerCase();

    function populateTypeFilter() {
        const select = document.getElementById('type-filter');
        const types = [...new Set(
            reports
                .map(r => String(r.emergency_type ?? '').trim())
                .filter(type => type && type !== 'â€”')
        )].sort((a, b) => a.localeCompare(b));

        select.innerHTML = '<option value="">All Types</option>' +
            types.map(type => `<option value="${escHtml(type)}">${escHtml(type)}</option>`).join('');
    }

    function urgencyBadge(u) {
        const level = (u ?? 'moderate').toLowerCase();
        const label = level.charAt(0).toUpperCase() + level.slice(1);
        const cls = { critical: 'badge-critical', urgent: 'badge-urgent', moderate: 'badge-moderate' }[level] ?? 'badge-moderate';
        return `<span class="badge ${cls}">${label}</span>`;
    }

    function statusBadge(s) {
        const map = {
            pending:  '<span class="badge badge-pending">Pending</span>',
            active:   '<span class="badge badge-active">Active</span>',
            ongoing:  '<span class="badge badge-ongoing">Ongoing</span>',
            resolved: '<span class="badge badge-resolved">Resolved</span>',
        };
        return map[s] ?? `<span class="badge badge-pending">${s}</span>`;
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
    }

    function fmtDateShort(d) {
        if (!d) return '—';
        const dt = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date}<br><span style="font-size:.75rem;color:var(--ink-muted);font-weight:400;">${time}</span>`;
    }

    function fmtDatePlain(d) {
        if (!d) return 'â€”';
        const dt = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date} ${time}`;
    }

    function truncate(str, n) {
        if (!str || str === '—') return '—';
        return str.length > n ? str.slice(0, n) + '…' : str;
    }

    function escHtml(str) {
        return (str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('em-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr class="empty-row"><td colspan="8">No emergency reports found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(r => `
                <tr>
                    <td>
                        <div class="type-cell">
                            ${r.is_panic_alert ? '<span class="panic-dot"></span>' : ''}
                            <span style="font-weight:600;">${escHtml(r.emergency_type)}</span>
                            ${r.is_panic_alert ? '<span class="badge badge-panic" style="font-size:.65rem;padding:.15rem .5rem;">PANIC</span>' : ''}
                        </div>
                    </td>
                    <td>${urgencyBadge(r.urgency_level)}</td>
                    <td class="location-cell">${escHtml(r.location)}</td>
                    <td class="date-cell">${fmtDateShort(r.reported_at)}</td>
                    <td><div class="desc-cell" title="${escHtml(r.description)}">${truncate(r.description, 45)}</div></td>
                    <td>
                        <div class="reporter-cell">
                            <div class="reporter-name">${escHtml(r.tenant_name)}</div>
                            ${r.room_number && r.room_number !== '—' ? `<div class="reporter-room">Room ${escHtml(String(r.room_number))}</div>` : ''}
                        </div>
                    </td>
                    <td>${statusBadge(r.status)}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewReport(${JSON.stringify(r)})'>
                                <img src="{{ asset('icons/eye.png') }}" alt="View">
                            </button>
                            <button class="act-btn" title="Edit" onclick='openEditModal(${JSON.stringify(r)})'>
                                <img src="{{ asset('icons/edit.png') }}" alt="Edit">
                            </button>
                            <button class="act-btn danger" title="Delete" onclick="openDeleteModal(${r.report_id}, '${escHtml(r.emergency_type)}')">
                                <img src="{{ asset('icons/delete.png') }}" alt="Delete">
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        const total = filtered.length;
        const from  = total === 0 ? 0 : start + 1;
        const to    = Math.min(start + PER_PAGE, total);
        document.getElementById('showing-label').textContent = `Showing data ${from} to ${to} of ${total} entries`;
        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        const pg = document.getElementById('pagination');
        let html = `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>`;
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goPage(${i})">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += `<span style="color:var(--ink-muted);padding:0 .2rem;">…</span>`;
            }
        }
        html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}>›</button>`;
        pg.innerHTML = html;
    }

    function goPage(p) {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        renderTable();
    }

    function applyFilters() {
        const q       = normalizeFilterValue(document.getElementById('search-input').value);
        const status  = normalizeFilterValue(document.getElementById('status-filter').value);
        const type    = normalizeFilterValue(document.getElementById('type-filter').value);
        const urgency = normalizeFilterValue(document.getElementById('urgency-filter').value);
        const sort    = document.getElementById('sort-select').value;
        const from    = document.getElementById('date-from').value;
        const to      = document.getElementById('date-to').value;

        filtered = reports.filter(r => {
            const matchSearch =
                normalizeFilterValue(r.emergency_type).includes(q) ||
                normalizeFilterValue(r.urgency_level).includes(q) ||
                normalizeFilterValue(r.location).includes(q) ||
                normalizeFilterValue(r.tenant_name).includes(q) ||
                normalizeFilterValue(r.room_number).includes(q) ||
                normalizeFilterValue(r.description).includes(q) ||
                normalizeFilterValue(r.status).includes(q);

            const matchStatus  = !status || normalizeFilterValue(r.status) === status;
            const matchType    = !type || normalizeFilterValue(r.emergency_type) === type;
            const matchUrgency = !urgency || normalizeFilterValue(r.urgency_level) === urgency;

            let matchDate = true;
            if (from || to) {
                const reportedAt = r.reported_at ? new Date(r.reported_at) : null;
                if (!reportedAt || Number.isNaN(reportedAt.getTime())) {
                    matchDate = false;
                } else {
                    if (from && reportedAt < new Date(from + 'T00:00:00')) matchDate = false;
                    if (to && reportedAt > new Date(to + 'T23:59:59')) matchDate = false;
                }
            }

            return matchSearch && matchStatus && matchType && matchUrgency && matchDate;
        });

        filtered.sort((a, b) => {
            const dateA = a.reported_at ? new Date(a.reported_at).getTime() : 0;
            const dateB = b.reported_at ? new Date(b.reported_at).getTime() : 0;
            return sort === 'oldest' ? dateA - dateB : dateB - dateA;
        });

        currentPage = 1;
        renderTable();
    }

    function viewReport(r) {
        currentRep = r;
        document.getElementById('view-content').innerHTML = `
            ${r.is_panic_alert ? `<div class="panic-banner"><img src="{{ asset('icons/warning.png') }}" alt=""> This is a Panic Alert</div>` : ''}
            <div class="view-detail-row">
                <div class="view-detail-label">Emergency Type</div>
                <div class="view-detail-val">${escHtml(r.emergency_type)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Urgency Level</div>
                <div class="view-detail-val">${urgencyBadge(r.urgency_level)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Location</div>
                <div class="view-detail-val">${escHtml(r.location)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Reported By</div>
                <div class="view-detail-val">
                    ${escHtml(r.tenant_name)}
                    ${r.room_number && r.room_number !== '—' ? ' — Room ' + escHtml(String(r.room_number)) : ''}
                </div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Description</div>
                <div class="view-detail-val" style="white-space:pre-wrap;">${escHtml(r.description)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Status</div>
                <div class="view-detail-val">${statusBadge(r.status)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Reported</div>
                <div class="view-detail-val">${fmtDate(r.reported_at)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Resolved</div>
                <div class="view-detail-val">${r.resolved_at ? fmtDate(r.resolved_at) : '—'}</div>
            </div>
            ${r.admin_notes ? `
            <div class="view-detail-row">
                <div class="view-detail-label">Admin Notes</div>
                <div class="view-detail-val" style="white-space:pre-wrap;">${escHtml(r.admin_notes)}</div>
            </div>` : ''}
        `;
        openModal('view-modal');
    }

    function switchToEdit() {
        if (currentRep) {
            closeModal('view-modal');
            setTimeout(() => openEditModal(currentRep), 200);
        }
    }

    function openEditModal(r) {
        currentRep = r;
        document.getElementById('edit-status').value   = r.status      ?? 'pending';
        document.getElementById('edit-location').value = r.location    ?? '';
        document.getElementById('edit-notes').value    = r.admin_notes ?? '';
        openModal('edit-modal');
    }

    async function submitUpdate() {
        if (!currentRep) return;
        const btn = document.querySelector('#edit-modal .btn-submit');
        btn.disabled    = true;
        btn.textContent = 'Saving...';

        try {
            const res = await fetch(`/emergency/${currentRep.report_id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    status:      document.getElementById('edit-status').value,
                    location:    document.getElementById('edit-location').value,
                    admin_notes: document.getElementById('edit-notes').value,
                }),
            });

            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Report updated successfully!', 'success');
                closeModal('edit-modal');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast('Failed to update report.', 'error');
            }
        } catch (err) {
        showToast('Error: ' + err.message, 'error');
        console.error(err);
        }

        btn.disabled    = false;
        btn.textContent = 'Save Changes';
    }

    function openDeleteModal(id, type) {
        deleteId = id;
        document.getElementById('delete-label').textContent = type;
        openModal('delete-modal');
    }

    async function submitDelete() {
        if (!deleteId) return;
        const btn = document.querySelector('#delete-modal .btn-submit');
        btn.disabled    = true;
        btn.textContent = 'Deleting...';

        try {
            const res = await fetch(`/emergency/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            });

            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Report moved to archive.', 'success');
                closeModal('delete-modal');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast('Failed to delete.', 'error');
            }
        } catch {
            showToast('Network error.');
        }

        btn.disabled    = false;
        btn.textContent = 'Delete';
    }

    function openArchive() {
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        document.getElementById('acount-resolved').textContent = resolvedArchive.length;
        document.getElementById('acount-deleted').textContent  = deletedArchive.length;
        renderArchive();
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-resolved').classList.toggle('active', tab === 'resolved');
        document.getElementById('atab-deleted').classList.toggle('active', tab === 'deleted');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    function renderArchive() {
        const q = normalizeFilterValue(document.getElementById('archive-search').value);
        const list = document.getElementById('archive-list');
        const data = archiveTab === 'resolved' ? resolvedArchive : deletedArchive;
        const filteredArchive = data.filter(r =>
            normalizeFilterValue(r.emergency_type).includes(q) ||
            normalizeFilterValue(r.urgency_level).includes(q) ||
            normalizeFilterValue(r.location).includes(q) ||
            normalizeFilterValue(r.tenant_name).includes(q) ||
            normalizeFilterValue(r.room_number).includes(q) ||
            normalizeFilterValue(r.description).includes(q) ||
            normalizeFilterValue(r.status).includes(q)
        );

        document.getElementById('archive-count-label').textContent =
            `${filteredArchive.length} record${filteredArchive.length !== 1 ? 's' : ''}`;

        if (filteredArchive.length === 0) {
            list.innerHTML = `<div class="archive-empty">
                <img class="archive-empty-icon" src="{{ asset('icons/nav-emerg.png') }}" alt="">
                No ${archiveTab} emergency reports found.
            </div>`;
            return;
        }

        const urgencyPillClass = {
            critical: 'archive-pill-critical',
            urgent: 'archive-pill-urgent',
            moderate: 'archive-pill-moderate',
        };
        const archiveLabel = archiveTab === 'resolved' ? 'Resolved on' : 'Deleted on';

        list.innerHTML = filteredArchive.map((r, i) => `
            <div class="archive-card" style="animation-delay:${i * 0.04}s;">
                <div class="archive-card-top">
                    <div class="archive-card-id">#EM-${String(r.id).padStart(3,'0')}</div>
                    <div class="archive-card-time">${fmtDatePlain(r.reported_at)}</div>
                </div>
                <div class="archive-card-title">${escHtml(r.emergency_type ?? 'â€”')}</div>
                <div class="archive-card-room">
                    ${escHtml(r.location ?? 'â€”')}
                    ${r.tenant_name ? ` - ${escHtml(r.tenant_name)}` : ''}
                    ${r.room_number && r.room_number !== 'â€”' ? ` - Room ${escHtml(String(r.room_number))}` : ''}
                </div>
                <div class="archive-card-meta">
                    <span class="archive-pill archive-pill-type">${escHtml(r.status ?? 'pending')}</span>
                    <span class="archive-pill ${urgencyPillClass[normalizeFilterValue(r.urgency_level)] ?? 'archive-pill-moderate'}">${escHtml(r.urgency_level ?? 'moderate')}</span>
                    ${r.is_panic_alert ? '<span class="archive-pill archive-pill-critical">Panic</span>' : ''}
                </div>
                ${r.description ? `<div class="archive-card-desc">${escHtml(r.description)}</div>` : ''}
                <div class="archive-card-archived">
                    ${archiveLabel}: <span>${fmtDatePlain(r.archived_at)}</span>
                </div>
            </div>
        `).join('');
    }

    function exportArchive() {
        const data  = archiveTab === 'resolved' ? resolvedArchive : deletedArchive;
        const label = archiveTab === 'resolved' ? 'Resolved On' : 'Deleted On';
        const rows = [[
            'Report ID',
            'Reported At',
            'Type',
            'Urgency',
            'Location',
            'Staff / Tenant',
            'Room',
            'Status',
            'Description',
            label,
        ]];

        data.forEach(r => {
            rows.push([
                `#EM-${String(r.id).padStart(3,'0')}`,
                fmtDatePlain(r.reported_at),
                r.emergency_type ?? '',
                r.urgency_level ?? '',
                r.location ?? '',
                r.tenant_name ?? '',
                r.room_number ?? '',
                r.status ?? '',
                r.description ?? '',
                fmtDatePlain(r.archived_at),
            ]);
        });

        const csv = rows.map(row =>
            row.map(value => `"${String(value).replace(/"/g, '""')}"`).join(',')
        ).join('\n');

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `emergency_${archiveTab}_archive.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    populateTypeFilter();
    applyFilters();
</script>
@endsection
