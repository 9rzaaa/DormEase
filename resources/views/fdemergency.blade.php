@extends('fdlayout')

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

    .btn-report {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .62rem 1.3rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border: none;
        font-size: .87rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 22px rgba(255,45,120,.28);
        transition: transform .2s, box-shadow .2s;
        white-space: nowrap;
        font-family: var(--ff-body);
    }

    .btn-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(255,45,120,.38);
    }

    .btn-report img {
        width: 17px;
        height: 17px;
        object-fit: contain;
        object-position: center;
        filter: brightness(0) invert(1);
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

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(232,23,93,.35);
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
        border: 1px solid var(--bright-pink);
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
        border-bottom: 1px solid var(--bright-pink);
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

    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead tr { background: var(--pink-100); }

    th {
        padding: .65rem 1rem;
        font-size: .71rem;
        font-weight: 800;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .05em;
        white-space: nowrap;
        text-align: left;
        border-bottom: 1px solid var(--bright-pink);
    }

    td {
        padding: .85rem 1rem;
        font-size: .855rem;
        border-bottom: 1px solid var(--bright-pink);
        color: var(--ink);
        vertical-align: middle;
    }

    tbody tr:last-child td { border-bottom: none; }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: var(--pink-50); }

    .type-cell {
        display: flex;
        align-items: center;
        gap: .5rem;
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
        padding: .22rem .65rem;
        border-radius: 999px;
        font-size: .71rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-active   { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .badge-resolved { background: #e8faf5; color: #1a9d6e; border: 1px solid #8cdebb; }
    .badge-closed   { background: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }
    .badge-panic    { background: var(--bright-pink); color: var(--white); border: none; }
    .badge-critical { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .badge-urgent   { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .badge-moderate { background: #eef2ff; color: #4f6ef7; border: 1px solid #c7d2fe; }

    .action-group {
        display: flex;
        align-items: center;
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

    .modal-body {
        flex: 1; overflow-y: auto; padding: .9rem 1.1rem;
        scrollbar-width: thin; scrollbar-color: var(--pink-200) transparent;
    }

    .modal-body::-webkit-scrollbar { width: 4px; }
    .modal-body::-webkit-scrollbar-track { background: transparent; }
    .modal-body::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

    .modal-footer {
        padding: .7rem 1.1rem;
        border-top: 1.5px solid var(--pink-100);
        display: flex; align-items: center; justify-content: space-between; gap: .55rem;
        flex-shrink: 0; background: #fffafd;
    }

    .modal-section { margin-bottom: .9rem; }

    .modal-section-title {
        font-size: .68rem; font-weight: 800; color: var(--bright-pink);
        text-transform: uppercase; letter-spacing: .08em;
        margin-bottom: .5rem; padding-bottom: .3rem;
        border-bottom: 1.5px solid var(--petal);
        display: flex; align-items: center; gap: .35rem;
    }

    .modal-section-title::before {
        content: '';
        display: inline-block; width: 3px; height: 11px;
        background: var(--gradient-pink); border-radius: 2px;
    }

    .modal-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: .55rem; }
    .modal-grid-1 { display: grid; grid-template-columns: 1fr; gap: .55rem; }
    .modal-field  { display: flex; flex-direction: column; gap: .25rem; }
    .modal-field.full { grid-column: 1 / -1; }

    .modal-field label {
        font-size: .69rem; font-weight: 700; color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .04em;
    }

    .modal-field input,
    .modal-field select,
    .modal-field textarea {
        width: 100%; padding: .5rem .8rem; border-radius: 10px;
        border: 1.5px solid var(--pink-100); background: #fffafd;
        font-size: .875rem; color: #5a1e38; outline: none;
        box-sizing: border-box; transition: border-color .2s, box-shadow .2s, background .2s;
        font-family: inherit;
    }

    .modal-field textarea { min-height: 80px; resize: vertical; }

    .modal-field input:hover,  .modal-field select:hover,  .modal-field textarea:hover  { border-color: var(--pink-200); background: #fff5f9; }
    .modal-field input:focus,  .modal-field select:focus,  .modal-field textarea:focus  {
        border-color: var(--bright-pink);
        box-shadow: 0 0 0 3px rgba(232,23,93,.1);
        background: var(--white);
    }

    .modal-field input::placeholder, .modal-field textarea::placeholder { color: #c4a0af; }

    .view-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    .view-detail-item {
        padding: .6rem .75rem;
        border-bottom: 1px solid var(--pink-100);
        display: flex; flex-direction: column; gap: .15rem;
    }

    .view-detail-item.full { grid-column: 1 / -1; }
    .view-detail-item:nth-last-child(-n+2):not(.full) { border-bottom: none; }
    .view-detail-item.full:last-child { border-bottom: none; }

    .vdi-label {
        font-size: .67rem; font-weight: 800; color: var(--bright-pink);
        text-transform: uppercase; letter-spacing: .06em;
    }

    .vdi-val {
        font-size: .855rem; color: var(--ink); font-weight: 500;
        line-height: 1.45; word-break: break-word;
    }

    .vdi-val.muted { color: var(--ink-muted); }

    .status-select-wrap { position: relative; }
    .status-dot {
        position: absolute; left: .75rem; top: 50%; transform: translateY(-50%);
        width: 8px; height: 8px; border-radius: 50%; pointer-events: none;
        transition: background .2s;
    }
    .status-select-wrap select { padding-left: 1.9rem; }

    .modal-warn-banner {
        background: #fff9e6; border: 1.5px solid #f0c040; border-radius: 10px;
        padding: .5rem .8rem; font-size: .78rem; color: #7a5400; line-height: 1.5;
        display: flex; gap: .5rem; align-items: flex-start; margin-bottom: .6rem;
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
        gap: .65rem;
        padding: .6rem .85rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-size: .82rem;
        font-weight: 700;
        margin-bottom: .8rem;
    }

    .panic-banner img {
        width: 16px; height: 16px;
        object-fit: contain;
        filter: brightness(0) invert(1);
        flex-shrink: 0;
    }

    .action-loading-overlay {
        position: fixed; inset: 0; z-index: 1200;
        display: none; align-items: center; justify-content: center;
        background: rgba(255,255,255,.72); backdrop-filter: blur(2px);
    }
    .action-loading-overlay.open { display: flex; }

    .action-loading-box {
        display: flex; align-items: center; flex-direction: column;
        gap: .75rem; padding: 1.25rem 1.6rem;
        border: 1px solid var(--baby-pink); border-radius: 12px;
        background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14);
        color: var(--ink); font-size: .9rem; font-weight: 700;
    }

    .loading-logo-wrap {
        width: 86px; height: 86px;
        border: 3px solid var(--baby-pink); border-radius: 50%;
        background: var(--gradient-pink);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 24px rgba(232,23,93,.25);
        animation: pulseLogo 1s ease-in-out infinite; flex-shrink: 0;
    }
    .loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }

    @keyframes pulseLogo {
        0%, 100% { transform: scale(1);     box-shadow: 0 10px 24px rgba(232,23,93,.25); }
        50%       { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); }
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
        top: 0; right: 0; bottom: 0;
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
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--white); border: 1.5px solid var(--pink-200);
        color: var(--hot-pink); font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: .2s; flex-shrink: 0;
    }

    .archive-close-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .archive-tabs {
        display: flex; gap: 0; padding: 0 1.8rem;
        border-bottom: 1.5px solid var(--pink-100);
        background: var(--white); flex-shrink: 0;
    }

    .archive-tab {
        padding: .85rem 1.2rem;
        font-size: .82rem; font-weight: 700;
        color: var(--ink-muted); background: none; border: none;
        border-bottom: 2px solid transparent; margin-bottom: -1px;
        cursor: pointer; transition: color .2s, border-color .2s;
        display: flex; align-items: center; gap: .5rem;
        font-family: var(--ff-body);
    }

    .archive-tab:hover,
    .archive-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

    .archive-tab-count {
        font-size: .68rem; font-weight: 800; padding: .1rem .45rem;
        border-radius: 99px; background: var(--pink-100); color: var(--hot-pink);
    }

    .archive-search-bar { padding: 1rem 1.8rem .8rem; flex-shrink: 0; }

    .archive-search-inner { position: relative; display: flex; align-items: center; }

    .archive-search-inner input {
        width: 100%; padding: .55rem .9rem .55rem 2.2rem;
        border-radius: 10px; border: 1.5px solid var(--pink-200);
        background: var(--white); color: var(--ink); font-size: .83rem;
        font-family: var(--ff-body); outline: none; transition: border-color .2s;
    }

    .archive-search-inner input:focus { border-color: var(--bright-pink); }

    .archive-search-icon {
        position: absolute; left: .75rem; width: 13px; height: 13px;
        opacity: .35; pointer-events: none;
    }

    .archive-list {
        flex: 1; overflow-y: auto; padding: 0 1.8rem 1.8rem;
        display: flex; flex-direction: column; gap: .75rem;
    }

    .archive-card {
        background: var(--white); border: 1.5px solid var(--pink-200);
        border-radius: 14px; padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s, transform .2s;
        animation: archiveSlideIn .3s ease both;
    }

    @keyframes archiveSlideIn {
        from { opacity: 0; transform: translateX(12px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .archive-card:hover {
        background: var(--pink-50); border-color: var(--bright-pink);
        box-shadow: 0 6px 18px rgba(232,23,93,.12); transform: translateY(-1px);
    }

    .archive-card-top {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: .8rem; margin-bottom: .65rem;
    }

    .archive-card-id { font-size: .78rem; font-weight: 800; color: var(--hot-pink); letter-spacing: .02em; }
    .archive-card-time { font-size: .7rem; color: var(--ink-muted); font-weight: 500; white-space: nowrap; flex-shrink: 0; }
    .archive-card-title { font-size: .88rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
    .archive-card-room { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; }

    .archive-card-meta { display: flex; align-items: center; gap: .5rem; margin-top: .65rem; flex-wrap: wrap; }

    .archive-pill {
        font-size: .68rem; font-weight: 800; padding: .18rem .55rem;
        border-radius: 99px; letter-spacing: .03em; text-transform: uppercase;
        display: inline-flex; align-items: center; justify-content: center; line-height: 1;
    }

    .archive-pill-type     { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .archive-pill-critical { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .archive-pill-urgent   { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .archive-pill-moderate { background: #eef2ff; color: #4f6ef7; border: 1px solid #c7d2fe; }

    .archive-card-desc {
        font-size: .78rem; color: var(--ink-muted); margin-top: .5rem; line-height: 1.5;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    .archive-card-archived {
        display: flex; align-items: center; gap: .4rem;
        margin-top: .75rem; padding-top: .6rem; border-top: 1px solid var(--pink-100);
        font-size: .7rem; color: var(--ink-muted); font-weight: 500;
    }

    .archive-card-archived span { color: var(--bright-pink); font-weight: 700; }

    .archive-empty { text-align: center; padding: 3rem 1rem; color: var(--ink-muted); font-size: .85rem; }

    .archive-empty-icon { width: 40px; height: 40px; margin: 0 auto .75rem; opacity: .25; display: block; }

    .archive-footer {
        padding: .9rem 1.8rem; border-top: 2px solid var(--pink-100);
        background: var(--white); display: flex; align-items: center;
        justify-content: space-between; flex-shrink: 0; flex-wrap: wrap; gap: .5rem;
    }

    .archive-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }

    .archive-export-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .75rem; font-weight: 700; color: var(--hot-pink);
        background: var(--white); border: 1.5px solid var(--pink-200);
        border-radius: 8px; padding: .35rem .85rem;
        cursor: pointer; transition: .2s; font-family: var(--ff-body);
    }

    .archive-export-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .65; }

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-100); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
    .export-menu button:hover { background: var(--petal); color: var(--hot-pink); }

    .btn-export {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--hot-pink);
        border: 1.5px solid var(--pink-100); font-size: .85rem; font-weight: 600;
        cursor: pointer; transition: .2s; font-family: var(--ff-body);
    }

    .btn-export:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .btn-export img { width: 14px; height: 14px; object-fit: contain; opacity: .6; }
    .btn-export:hover img { opacity: 1; }

    .btn-directory {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.2rem; border-radius: 12px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white); border: none; font-size: .87rem; font-weight: 700;
        cursor: pointer; transition: opacity .2s, transform .15s;
        white-space: nowrap; font-family: var(--ff-body);
        box-shadow: 0 4px 14px rgba(232,23,93,.3);
    }
    .btn-directory:hover { opacity: .9; transform: translateY(-1px); }
    .btn-directory img { width: 14px; height: 14px; object-fit: contain; filter: brightness(0) invert(1); }

    .dir-modal .modal-header { border-bottom: none; padding-bottom: .75rem; }

    .dir-tabs {
        display: flex; gap: 0; padding: 0 1.1rem;
        border-top: 1.5px solid var(--pink-100);
        border-bottom: 1.5px solid var(--pink-100);
        flex-shrink: 0; overflow-x: auto; overflow-y: visible;
        scrollbar-width: none; background: var(--white); margin: 0;
    }
    .dir-tabs::-webkit-scrollbar { display: none; }

    .dir-tab {
        position: relative; padding: .65rem .75rem;
        font-size: .75rem; font-weight: 700; color: var(--ink-muted);
        background: none; border: none; border-bottom: none;
        margin-bottom: -1.5px; cursor: pointer; transition: color .2s;
        white-space: nowrap; font-family: var(--ff-body);
        display: inline-flex; align-items: center; gap: .35rem;
    }

    .dir-tab::after {
        content: ''; position: absolute; bottom: 0; left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 60%; height: 2.5px;
        background: var(--hot-pink); border-radius: 2px 2px 0 0;
        transform-origin: center; transition: transform .22s ease;
    }

    .dir-tab:hover { color: var(--hot-pink); }
    .dir-tab:hover::after { transform: translateX(-50%) scaleX(0.45); }
    .dir-tab.active { color: var(--hot-pink); }
    .dir-tab.active::after { transform: translateX(-50%) scaleX(1); }

    .dir-tab-icon { width: 14px; height: 14px; object-fit: contain; opacity: .5; }
    .dir-tab.active .dir-tab-icon { opacity: 1; }

    .dir-search-bar { padding: .85rem .75rem; flex-shrink: 0; }

    .dir-search-inner { position: relative; display: flex; align-items: center; }

    .dir-search-inner input {
        width: 100%; padding: .5rem .9rem .5rem 2.1rem;
        border-radius: 10px; border: 1.5px solid var(--pink-100);
        background: #fffafd; color: var(--ink); font-size: .83rem;
        font-family: var(--ff-body); outline: none;
        transition: border-color .2s, box-shadow .2s; box-sizing: border-box;
    }

    .dir-search-inner input:focus {
        border-color: var(--bright-pink);
        box-shadow: 0 0 0 3px rgba(232,23,93,.1);
    }

    .dir-search-icon {
        position: absolute; left: .7rem; width: 13px; height: 13px;
        opacity: .4; pointer-events: none;
    }

    .dir-list {
        flex: 1; overflow-y: auto; padding: 0 1.1rem 1rem;
        display: flex; flex-direction: column; gap: .45rem;
    }
    .dir-list::-webkit-scrollbar { width: 4px; }
    .dir-list::-webkit-scrollbar-track { background: transparent; }
    .dir-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

    .dir-section-heading {
        font-size: .65rem; font-weight: 800; color: var(--bright-pink);
        text-transform: uppercase; letter-spacing: .08em; margin: .6rem 0 .3rem;
        display: flex; align-items: center; gap: .35rem;
    }

    .dir-section-heading::before {
        content: ''; display: inline-block; width: 3px; height: 10px;
        background: var(--gradient-pink); border-radius: 2px;
    }

    .dir-section-heading:first-child { margin-top: 0; }

    .dir-card {
        display: flex; align-items: center; justify-content: space-between; gap: .8rem;
        padding: .6rem .85rem; border-radius: 12px;
        background: var(--blush); border: 1px solid var(--pink-100);
        transition: background .15s, border-color .15s, transform .15s;
        animation: dirSlideIn .25s ease both;
    }

    @keyframes dirSlideIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dir-card:hover { background: var(--petal); border-color: var(--pink-200); transform: translateX(2px); }

    .dir-card-left { display: flex; align-items: center; gap: .6rem; min-width: 0; }

    .dir-card-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; background: var(--pink-100);
    }

    .dir-card-icon img { width: 18px; height: 18px; object-fit: contain; }

    .dir-card-name {
        font-size: .82rem; font-weight: 700; color: var(--ink);
        line-height: 1.25; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .dir-card-numbers { display: flex; flex-direction: column; align-items: flex-end; gap: .2rem; flex-shrink: 0; }

    .dir-number-chip {
        display: inline-flex; align-items: center; gap: .3rem;
        background: var(--white); border: 1px solid var(--pink-200);
        border-radius: 7px; padding: .2rem .55rem;
        font-size: .75rem; font-weight: 700; color: var(--ink);
        font-family: monospace; white-space: nowrap; cursor: pointer; transition: .15s;
    }

    .dir-number-chip:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }

    .dir-hint {
        margin: .5rem 0 0; background: var(--blush);
        border: 1px solid var(--pink-100); border-radius: 10px;
        padding: .5rem .8rem; font-size: .73rem; color: var(--ink-muted); line-height: 1.55;
    }

    .dir-suggested-wrap {
        background: linear-gradient(135deg, #fff0f3, #fff7fb);
        border: 1.5px solid var(--pink-200); border-radius: 14px;
        padding: .9rem 1rem; margin-bottom: 1.1rem;
    }

    .dir-suggested-label {
        font-size: .68rem; font-weight: 800; color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .07em; margin-bottom: .55rem;
        display: flex; align-items: center; gap: .4rem;
    }

    .dir-suggested-label::before {
        content: ''; display: block; width: 6px; height: 6px;
        border-radius: 50%; background: var(--hot-pink);
        animation: pulseDot 1.5s infinite;
    }

    .dir-suggested-chips { display: flex; flex-wrap: wrap; gap: .4rem; }

    .dir-suggested-chip {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .35rem .8rem; border-radius: 8px;
        background: var(--white); border: 1.5px solid var(--pink-200);
        font-size: .78rem; font-weight: 700; color: var(--ink);
        cursor: pointer; transition: background .15s, border-color .15s, color .15s; white-space: nowrap;
    }

    #dir-modal .modal {
        display: flex;
        flex-direction: column;
        max-height: 92vh;
        overflow: hidden;
    }

    #view-modal .modal {
        display: flex;
        flex-direction: column;
        max-height: 92vh;
        overflow: hidden;
    }

    #view-modal .modal-header { flex-shrink: 0; }
    #view-modal .modal-body { flex: 1; overflow-y: auto; min-height: 0; }
    #view-modal .modal-footer { flex-shrink: 0; }

    #dir-modal .modal-header { flex-shrink: 0; }
    #dir-modal .dir-tabs { flex-shrink: 0; }
    #dir-modal .dir-search-bar { flex-shrink: 0; }
    #dir-modal .dir-list { flex: 1; overflow-y: auto; min-height: 0; }
    #dir-modal .modal-actions { flex-shrink: 0; }

    .dir-suggested-chip .chip-icon { width: 14px; height: 14px; object-fit: contain; flex-shrink: 0; }
    .dir-suggested-chip:hover .chip-icon { filter: brightness(0) invert(1); }
    .dir-suggested-chip:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }
    .dir-suggested-chip span { font-family: monospace; color: var(--hot-pink); font-size: .8rem; }
    .dir-suggested-chip:hover span { color: var(--white); }

    .report-hotline-wrap { margin-bottom: 1rem; display: none; }
    .report-hotline-wrap.visible { display: block; }

    .type-suggest-banner {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: .7rem;
        background: linear-gradient(135deg, #fff0f3, #fff7fb);
        border: 1.5px solid var(--pink-200);
        border-radius: 12px;
        padding: .55rem .8rem;
        margin-top: .5rem;
    }

    .type-suggest-banner.visible { display: flex; }

    .type-suggest-text {
        font-size: .78rem;
        color: var(--ink);
        font-weight: 600;
        line-height: 1.4;
    }

    .type-suggest-text strong { color: var(--hot-pink); }

    .type-suggest-apply {
        flex-shrink: 0;
        padding: .35rem .8rem;
        border-radius: 8px;
        border: none;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .76rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        white-space: nowrap;
        transition: transform .15s, box-shadow .15s;
    }

    .type-suggest-apply:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(232,23,93,.3); }

    .status-legend-wrap {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        flex-shrink: 0;
    }

    .status-legend-wrap img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        opacity: .6;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
        transition: opacity .2s;
    }

    .status-legend-wrap:hover img { opacity: 1; }

    .status-legend-popup {
        display: none;
        position: fixed;
        background: var(--white);
        border: 1.5px solid var(--pink-200);
        border-radius: 14px;
        box-shadow: 0 12px 32px rgba(232,23,93,.18), 0 2px 8px rgba(0,0,0,.1);
        padding: .75rem .9rem;
        min-width: 320px;
        z-index: 99999;
        pointer-events: auto;
    }

    .slp-title {
        font-size: .67rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: .55rem;
        padding-bottom: .4rem;
        border-bottom: 1.5px solid var(--petal);
    }

    .slp-row {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .35rem 0;
        border-bottom: 1px solid var(--pink-100);
    }

    .slp-row:last-child { border-bottom: none; }

    .slp-badge {
        flex-shrink: 0;
        min-width: 90px;
        display: flex;
        align-items: center;
    }

    .slp-desc {
        font-size: .75rem;
        color: var(--ink-muted);
        font-weight: 500;
        line-height: 1.45;
    }

    .location-search-wrap {
    position: relative;
}

.location-search-wrap > input[type="text"] {
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

.location-search-wrap > input[type="text"]:focus {
    border-color: var(--bright-pink);
    background: var(--white);
}

.location-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 4px);
    left: 0; right: 0;
    background: var(--white);
    border: 1.5px solid var(--pink-200);
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(232,23,93,.15);
    z-index: 9999;
    max-height: 220px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--pink-200) transparent;
}

.location-dropdown.open { display: block; }

.location-dropdown::-webkit-scrollbar { width: 4px; }
.location-dropdown::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

.loc-group-label {
    font-size: .65rem;
    font-weight: 800;
    color: var(--bright-pink);
    text-transform: uppercase;
    letter-spacing: .07em;
    padding: .5rem .85rem .2rem;
}

.loc-option {
    padding: .5rem .85rem;
    font-size: .84rem;
    color: var(--ink);
    cursor: pointer;
    transition: background .12s;
}

.loc-option:hover, .loc-option.highlighted {
    background: var(--pink-50);
    color: var(--hot-pink);
}

.loc-option.selected {
    background: var(--pink-100);
    color: var(--hot-pink);
    font-weight: 700;
}

.loc-no-results {
    padding: .75rem .85rem;
    font-size: .82rem;
    color: var(--ink-muted);
    text-align: center;
}

    @media (max-width: 900px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .modal-grid { grid-template-columns: 1fr; }
        .archive-tabs { padding: 0 1rem; }
        .archive-drawer-header { padding: 1.2rem 1rem .9rem; }
        .archive-list { padding: 0 1rem 1.2rem; }
        .archive-search-bar { padding: .8rem 1rem .6rem; }
        .archive-footer { padding: .75rem 1rem; }
        .dir-tabs { padding: 0 .75rem; }
        .dir-list { padding: 0 .85rem .85rem; }
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
            <button class="btn-report" onclick="openModal('report-modal')">
                <img src="{{ asset('icons/nav-emerg.png') }}" alt="">
                Report Emergency
            </button>
            <button class="btn-archive-open" onclick="openModal('dir-modal')">
                <img src="{{ asset('icons/emergdir.png') }}" alt="">
                Emergency Directory
            </button>
            <button class="btn-archive-open" onclick="openArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>
            <div class="export-dropdown" id="export-dropdown-main">
                <button class="btn-export" onclick="toggleExportDropdown('export-dropdown-main')">
                    <img src="{{ asset('icons/export.png') }}" alt="">
                    Export
                </button>
                <div class="export-menu" id="export-menu-main">
                    <button onclick="exportTable('csv'); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportTable('pdf'); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
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
                <div class="stat-label">Active Panic Alerts</div>
                <div class="stat-num">{{ $panicCount }}</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-topbar">
            <div>
                <div class="table-heading">All Emergency Reports</div>
                <div class="table-sub" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div style="display:flex;align-items:center;gap:.45rem;">
                    <div class="search-box">
                        <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                        <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
                    </div>
                    <div class="status-legend-wrap" id="fd-status-legend-wrap">
                        <img src="{{ asset('icons/info.png') }}" alt="Status guide">
                        <div class="status-legend-popup" id="fd-status-legend-popup">
                            <div class="slp-title">Urgency &amp; Status Guide</div>
                            <div class="slp-row"><span class="slp-badge"><span class="badge badge-critical">Critical</span></span><span class="slp-desc">Immediate danger to life or property. Requires urgent response.</span></div>
                            <div class="slp-row"><span class="slp-badge"><span class="badge badge-urgent">Urgent</span></span><span class="slp-desc">Serious situation that needs prompt attention but is not immediately life-threatening.</span></div>
                            <div class="slp-row"><span class="slp-badge"><span class="badge badge-moderate">Moderate</span></span><span class="slp-desc">Situation is under control but still requires monitoring or action.</span></div>
                            <div class="slp-row"><span class="slp-badge"><span class="badge badge-active">Active</span></span><span class="slp-desc">Report is open and being monitored or attended to.</span></div>
                            <div class="slp-row"><span class="slp-badge"><span class="badge badge-resolved">Resolved</span></span><span class="slp-desc">Situation has been addressed and the report is moved to the resolved archive.</span></div>
                            <div class="slp-row"><span class="slp-badge"><span class="badge badge-closed">Closed</span></span><span class="slp-desc">Report has been closed and moved to the closed archive.</span></div>
                        </div>
                    </div>
                </div>
                <select class="filter-select" id="status-filter" onchange="applyFilters()">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
                <select class="filter-select" id="type-filter" onchange="applyFilters()">
                    <option value="">All Types</option>
                </select>
                <select class="filter-select" id="sort-select" onchange="applyFilters()">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Urgency</th>
                        <th>Location</th>
                        <th>Tenant / Reporter</th>
                        <th>Date Reported</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th style="text-align:center;">Action</th>
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

<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="archive-backdrop" id="archive-backdrop" onclick="closeArchive()"></div>

<div class="archive-drawer" id="archive-drawer">
    <div class="archive-drawer-header">
        <div>
            <div class="archive-drawer-title">Archive / History</div>
            <div class="archive-drawer-sub">Record of closed and deleted emergency reports</div>
        </div>
        <button class="archive-close-btn" onclick="closeArchive()">&#x2715;</button>
    </div>

    <div class="archive-tabs">
        <button class="archive-tab active" id="atab-closed" onclick="switchArchiveTab('closed')">
            Closed
            <span class="archive-tab-count" id="acount-closed">0</span>
        </button>
        <button class="archive-tab" id="atab-resolved" onclick="switchArchiveTab('resolved')">
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
        <div class="export-dropdown" id="export-dropdown-archive">
            <button class="archive-export-btn" onclick="toggleExportDropdown('export-dropdown-archive')">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
            <div class="export-menu" id="export-menu-archive">
                <button onclick="exportArchive('csv'); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportArchive('pdf'); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="dir-modal" onclick="handleOverlayClick(event, 'dir-modal')">
    <div class="modal dir-modal" style="max-width:580px;">
        <div class="modal-header">
            <div class="modal-title">Emergency Directory</div>
            <button class="modal-close" onclick="closeModal('dir-modal')">&#x2715;</button>
        </div>

        <div class="dir-tabs" id="dir-tabs">
            <button class="dir-tab active" onclick="switchDirTab('all', this)">All</button>
            <button class="dir-tab" onclick="switchDirTab('police', this)">
                <img class="dir-tab-icon" src="{{ asset('icons/police.png') }}" alt=""> Police
            </button>
            <button class="dir-tab" onclick="switchDirTab('fire', this)">
                <img class="dir-tab-icon" src="{{ asset('icons/fire.png') }}" alt=""> Fire
            </button>
            <button class="dir-tab" onclick="switchDirTab('medical', this)">
                <img class="dir-tab-icon" src="{{ asset('icons/hospital.png') }}" alt=""> Medical
            </button>
            <button class="dir-tab" onclick="switchDirTab('redcross', this)">
                <img class="dir-tab-icon" src="{{ asset('icons/redcross.png') }}" alt=""> Red Cross
            </button>
        </div>

        <div class="dir-search-bar">
            <div class="dir-search-inner">
                <img src="{{ asset('icons/search.png') }}" class="dir-search-icon" alt="">
                <input type="text" id="dir-search" placeholder="Search contacts..." oninput="renderDirList()">
            </div>
        </div>

        <div class="dir-list" id="dir-list"></div>

        <div class="modal-actions" style="border-top:1.5px solid var(--pink-100);padding:.7rem 1.1rem;display:flex;align-items:center;justify-content:space-between;gap:.55rem; position:sticky; bottom:0; background:var(--white);">
            <div class="dir-hint" style="margin:0;flex:1;">
                Tap any number to copy it to your clipboard.
            </div>
            <button class="btn-cancel" onclick="closeModal('dir-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="report-modal" onclick="handleOverlayClick(event, 'report-modal')">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">Report Emergency</div>
            <button class="modal-close" onclick="closeModal('report-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('frontdesk.emergency.store') }}" id="report-form">
            @csrf
            <div class="modal-grid">
                <div class="em-modal-field">
                    <label>Emergency Type</label>
                    <select name="emergency_type" id="report-type-select" required onchange="updateReportHotlines(this.value)">
                        <option value="">Select type</option>
                        <option value="Medical">Medical</option>
                        <option value="Fire">Fire</option>
                        <option value="Electrical Hazard">Electrical Hazard</option>
                        <option value="Flood/Water Leak">Flood/Water Leak</option>
                        <option value="Lockout">Lockout</option>
                        <option value="Security">Security</option>
                        <option value="Structural">Structural</option>
                        <option value="Natural Disaster">Natural Disaster</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="em-modal-field">
    <label>Location</label>
    <div class="location-search-wrap" id="location-search-wrap">
        <input type="text" id="location-search-input" placeholder="Search or select location…"
               autocomplete="off" oninput="filterLocationOptions(this.value)" onfocus="openLocationDropdown()" onblur="closeLocationDropdown(500)">
        <input type="hidden" name="location" id="location-hidden-input" required>
        <div class="location-dropdown" id="location-dropdown"></div>
    </div>
</div>
                <div class="em-modal-field modal-field-full">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe the emergency..." oninput="handleDescriptionInput(this.value)"></textarea>
                    <div class="type-suggest-banner" id="type-suggest-banner">
                        <span class="type-suggest-text" id="type-suggest-text"></span>
                        <button type="button" class="type-suggest-apply" id="type-suggest-apply">Apply</button>
                    </div>
                </div>
                <div class="em-modal-field modal-field-full" style="flex-direction:row;align-items:center;gap:.6rem;">
                    <input type="checkbox" name="is_panic_alert" value="1" id="panic-check" style="width:16px;height:16px;accent-color:var(--bright-pink);flex-shrink:0;">
                    <label for="panic-check" style="text-transform:none;font-size:.87rem;color:var(--ink);font-weight:600;letter-spacing:0;cursor:pointer;">Mark as Panic Alert</label>
                </div>
                <div class="modal-field-full report-hotline-wrap" id="report-hotline-wrap"></div>
            </div>
            <div class="modal-actions" style="display:flex;align-items:center;justify-content:space-between;gap:.55rem;">
                <button type="button" class="btn-cancel" onclick="closeModal('report-modal')">Cancel</button>
                <button type="submit" class="btn-submit" id="report-submit-btn">Submit Report</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal" onclick="handleOverlayClick(event, 'view-modal')">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">Emergency Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div class="modal-body" id="view-content"></div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit / Update</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal" onclick="handleOverlayClick(event, 'edit-modal')">
    <div class="modal" style="max-width:480px;">
        <div class="modal-header">
            <div class="modal-title">Update Emergency Report</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="modal-section">
                <div class="modal-section-title">Status &amp; Location</div>
                <div class="modal-grid-2">
                    <div class="modal-field">
                        <label>Status</label>
                        <div class="status-select-wrap">
                            <span class="status-dot" id="edit-status-dot"></span>
                            <select id="edit-status" onchange="updateEditStatusDot(this)">
                                <option value="active">Active</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-field">
                        <label>Location</label>
                        <input type="text" id="edit-location" placeholder="e.g. Room 301">
                    </div>
                </div>
            </div>
            <div class="modal-section">
                <div class="modal-section-title">Frontdesk Notes</div>
                <div class="modal-field">
                    <textarea id="edit-notes" placeholder="Add notes or action taken..."></textarea>
                </div>
            </div>
            <div class="modal-warn-banner">
                <span style="font-size:.95rem;flex-shrink:0;"></span>
                <span>Setting status to <strong>Closed</strong> or <strong>Resolved</strong> will move this report to the archive permanently.</span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
            <button type="button" class="btn-submit" onclick="submitUpdate()">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-modal" onclick="handleOverlayClick(event, 'delete-modal')">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Delete Report</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warn">This emergency report will be removed from the active list and saved to archive history.</div>
            <p style="font-size:.9rem;color:var(--ink-muted);margin:0;">
                Delete report for <strong id="delete-label" style="color:var(--ink);"></strong>?
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <button type="button" class="btn-submit" style="background:var(--red);box-shadow:0 6px 16px rgba(224,72,103,.3);" onclick="submitDelete()">Delete</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const reports          = @json($reports);
    const closedArchive    = @json($closedArchive);
    const resolvedArchive  = @json($resolvedArchive);
    const deletedArchive   = @json($deletedArchive);
    const PER_PAGE = 10;
    let currentPage = 1;
    let filtered    = [...reports];
    let currentRep  = null;
    let deleteId    = null;
    let archiveTab  = 'closed';

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

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

    const normalizeFilterValue = value => String(value ?? '').trim().toLowerCase();

    const baseUrl = '{{ asset("icons") }}/';

    const DIR_DATA = [
        { name: 'National Emergency Hotline', numbers: ['911'], category: 'general', icon: baseUrl + 'phone.png', tags: ['general','panic','emergency','other','lockout','structural','security','medical','fire'] },
        { name: 'Philippine National Police (PNP)', numbers: ['117', '(02) 8722-0650'], category: 'police', icon: baseUrl + 'police.png', tags: ['crime','theft','assault','violence','intruder','break','panic','security','lockout'] },
        { name: 'Manila Police District', numbers: ['0919-995-0976', '0917-899-2092'], category: 'police', icon: baseUrl + 'police.png', tags: ['crime','theft','assault','violence','intruder','break','panic','security','lockout'] },
        { name: 'PNP Text Hotline', numbers: ['0917-847-5757'], category: 'police', icon: baseUrl + 'police.png', tags: ['crime','security','lockout'] },
        { name: 'Bureau of Fire Protection (NCR)', numbers: ['(02) 8426-0219', '(02) 8426-0246'], category: 'fire', icon: baseUrl + 'fire.png', tags: ['fire','smoke','burning','flames'] },
        { name: 'University of Santo Tomas Hospital', numbers: ['(02) 8731-3001'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','unconscious','seizure','heart','stroke','bleeding','health','sick'] },
        { name: 'Ospital ng Sampaloc', numbers: ['(02) 8749-0207', '0915-069-4087'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','unconscious','seizure','heart','stroke','bleeding','health','sick'] },
        { name: 'Chinese General Hospital', numbers: ['(02) 8711-4141'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','unconscious','seizure','heart','stroke','bleeding','health','sick'] },
        { name: 'Jose R. Reyes Memorial Medical Center', numbers: ['(02) 8711-9491'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','unconscious','seizure','heart','stroke','bleeding','health','sick'] },
        { name: 'Philippine Red Cross', numbers: ['143', '(02) 8790-2300'], category: 'redcross', icon: baseUrl + 'redcross.png', tags: ['medical','injury','accident','disaster','flood','fire','emergency'] },
    ];

    const CATEGORY_LABELS = {
        general:  'National Emergency',
        police:   'Police',
        fire:     'Fire',
        medical:  'Medical',
        redcross: 'Red Cross',
    };

    let dirActiveTab = 'all';

    function switchDirTab(tab, btn) {
        dirActiveTab = tab;
        document.querySelectorAll('.dir-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('dir-search').value = '';
        renderDirList();
    }

    function renderDirList() {
        const q    = normalizeFilterValue(document.getElementById('dir-search').value);
        const list = document.getElementById('dir-list');

        let data = DIR_DATA.filter(d => {
            const matchCat = dirActiveTab === 'all' || d.category === dirActiveTab;
            const matchQ   = !q || d.name.toLowerCase().includes(q) || d.numbers.some(n => n.includes(q));
            return matchCat && matchQ;
        });

        if (data.length === 0) {
            list.innerHTML = '<div style="text-align:center;padding:2rem 1rem;color:var(--ink-muted);font-size:.85rem;">No contacts found.</div>';
            return;
        }

        if (dirActiveTab === 'all') {
            const groups = {};
            data.forEach(d => {
                if (!groups[d.category]) groups[d.category] = [];
                groups[d.category].push(d);
            });
            const categoryOrder = ['general', 'police', 'fire', 'medical', 'redcross'];
            list.innerHTML = categoryOrder
                .filter(cat => groups[cat])
                .map(cat => `
                    <div class="dir-section-heading">${CATEGORY_LABELS[cat]}</div>
                    ${groups[cat].map((d, i) => renderDirCard(d, i)).join('')}
                `).join('');
        } else {
            list.innerHTML = data.map((d, i) => renderDirCard(d, i)).join('');
        }
    }

    function renderDirCard(d, i) {
        return `
            <div class="dir-card" style="animation-delay:${i * 0.04}s;">
                <div class="dir-card-left">
                    <div class="dir-card-icon"><img src="${d.icon}" alt=""></div>
                    <div class="dir-card-name">${escHtml(d.name)}</div>
                </div>
                <div class="dir-card-numbers">
                    ${d.numbers.map(n => `
                        <div class="dir-number-chip" onclick="copyHotline('${n.replace(/[^0-9+]/g,'')}', this)">${escHtml(n)}</div>
                    `).join('')}
                </div>
            </div>
        `;
    }

    function buildSuggestedHotlines(emergencyType, urgencyLevel, isPanic) {
        const type  = (emergencyType ?? '').toLowerCase();
        const level = (urgencyLevel ?? '').toLowerCase();

        if (!isPanic && level !== 'critical' && level !== 'urgent') return '';

        const matched = DIR_DATA.filter(h =>
            h.name === 'National Emergency Hotline' ||
            h.tags.some(tag => type.includes(tag))
        );

        if (!matched.length) return '';

        const chips = matched.map(h =>
            h.numbers.map(n => `
                <div class="dir-suggested-chip" onclick="copyHotline('${n.replace(/[^0-9]/g,'')}', this)">
                    <img class="chip-icon" src="${h.icon}" alt="">
                    ${escHtml(h.name.length > 28 ? h.name.slice(0,28)+'…' : h.name)}
                    &nbsp;<span>${n}</span>
                </div>
            `).join('')
        ).join('');

        return `
            <div class="dir-suggested-wrap">
                <div class="dir-suggested-label">Suggested Hotlines</div>
                <div class="dir-suggested-chips">${chips}</div>
            </div>
        `;
    }

    function toggleCustomLocation(val) {
    const custom = document.getElementById('report-location-custom');
    if (val === '__other__') {
        custom.style.display = 'block';
        custom.required = true;
    } else {
        custom.style.display = 'none';
        custom.required = false;
        custom.value = '';
    }
}

    function buildReportHotlines(emergencyType) {
        const type = (emergencyType ?? '').toLowerCase();
        if (!type) return '';

        const matched = DIR_DATA.filter(h => h.tags.some(tag => type.includes(tag)));
        if (!matched.length) return '';

        const chips = matched.map(h =>
            h.numbers.map(n => `
                <div class="dir-suggested-chip" onclick="copyHotline('${n.replace(/[^0-9]/g,'')}', this)">
                    <img class="chip-icon" src="${h.icon}" alt="">
                    ${escHtml(h.name.length > 28 ? h.name.slice(0,28)+'…' : h.name)}
                    &nbsp;<span>${n}</span>
                </div>
            `).join('')
        ).join('');

        return `
            <div class="dir-suggested-wrap" style="margin-bottom:0;">
                <div class="dir-suggested-label">Suggested Hotlines</div>
                <div class="dir-suggested-chips">${chips}</div>
            </div>
        `;
    }

    function updateReportHotlines(type) {
        const wrap = document.getElementById('report-hotline-wrap');
        const html = buildReportHotlines(type);
        if (html) {
            wrap.innerHTML = html;
            wrap.classList.add('visible');
        } else {
            wrap.innerHTML = '';
            wrap.classList.remove('visible');
        }
    }
    const TYPE_SUGGEST_MAP = {
        'Medical': 'Medical',
        'Fire/Smoke': 'Fire',
        'Security': 'Security',
        'Electrical Hazard': 'Electrical Hazard',
        'Flood/Water Leak': 'Flood/Water Leak',
        'Lockout': 'Lockout',
        'Structural': 'Structural',
        'Natural Disaster': 'Natural Disaster',
    };

    let suggestDebounceTimer = null;
    let lastSuggestedDescription = '';

    function handleDescriptionInput(value) {
        clearTimeout(suggestDebounceTimer);
        const trimmed = value.trim();

        if (trimmed.length < 4) {
            hideTypeSuggestion();
            return;
        }

        suggestDebounceTimer = setTimeout(function() {
            fetchTypeSuggestion(trimmed);
        }, 600);
    }

    async function fetchTypeSuggestion(description) {
        if (description === lastSuggestedDescription) return;
        lastSuggestedDescription = description;

        try {
            const res = await fetch('{{ route("frontdesk.emergency.suggestType") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ description: description }),
            });

            if (!res.ok) {
                hideTypeSuggestion();
                return;
            }

            const data = await res.json();
            renderTypeSuggestion(data.emergency_type, data.urgency_level);
        } catch {
            hideTypeSuggestion();
        }
    }

    function renderTypeSuggestion(emergencyType, urgencyLevel) {
        const select = document.getElementById('report-type-select');
        const checkbox = document.getElementById('panic-check');

        if (urgencyLevel === 'critical' || emergencyType === 'Panic Alert') {
            if (checkbox) {
                checkbox.checked = true;
            }
        }

        const mapped = TYPE_SUGGEST_MAP[emergencyType];
        if (mapped && select.value !== mapped) {
            select.value = mapped;
            updateReportHotlines(mapped);
        }

        hideTypeSuggestion();
    }

    function hideTypeSuggestion() {
        document.getElementById('type-suggest-banner').classList.remove('visible');
    }

    function copyHotline(number, btn) {
        const clean = number.replace(/[^0-9+]/g, '');
        const origWidth = btn.offsetWidth;
        const origHTML  = btn.innerHTML;

        function flash(success) {
            btn.style.minWidth = origWidth + 'px';
            btn.innerHTML = success ? 'Copied!' : 'Copy failed';
            btn.style.cssText += success
                ? ';background:var(--bright-pink)!important;color:#fff!important;border-color:var(--bright-pink)!important;'
                : ';background:#e04867!important;color:#fff!important;border-color:#e04867!important;';
            setTimeout(() => {
                btn.innerHTML = origHTML;
                btn.style.cssText = btn.style.cssText
                    .replace(/background:[^;]+;?/g,'')
                    .replace(/color:[^;]+;?/g,'')
                    .replace(/border-color:[^;]+;?/g,'');
                btn.style.minWidth = '';
            }, 1500);
        }

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(clean).then(() => flash(true)).catch(() => flash(false));
        } else {
            try {
                const ta = document.createElement('textarea');
                ta.value = clean;
                ta.style.cssText = 'position:fixed;opacity:0;top:0;left:0;';
                document.body.appendChild(ta);
                ta.focus(); ta.select();
                document.execCommand('copy');
                ta.remove();
                flash(true);
            } catch {
                flash(false);
            }
        }
    }

    function urgencyBadge(u) {
        const level = (u ?? 'moderate').toLowerCase();
        const label = level.charAt(0).toUpperCase() + level.slice(1);
        const cls = { critical: 'badge-critical', urgent: 'badge-urgent', moderate: 'badge-moderate' }[level] ?? 'badge-moderate';
        return `<span class="badge ${cls}">${label}</span>`;
    }

    function statusBadge(s) {
        const map = {
            active:   '<span class="badge badge-active">Active</span>',
            resolved: '<span class="badge badge-resolved">Resolved</span>',
            closed:   '<span class="badge badge-closed">Closed</span>',
        };
        return map[s] ?? '<span class="badge badge-active">Active</span>';
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
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
            const hasFilters = document.getElementById('search-input').value
                || document.getElementById('status-filter').value
                || document.getElementById('type-filter').value;
            tbody.innerHTML = `<tr class="empty-row"><td colspan="8">${hasFilters ? 'No results match your filters. <button onclick="resetFilters()" style="background:none;border:none;color:var(--bright-pink);font-weight:700;cursor:pointer;font-family:inherit;font-size:inherit;padding:0;margin-left:.3rem;">Clear filters</button>' : 'No emergency reports found.'}</td></tr>`;
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
                    <td style="font-size:.83rem;">${escHtml(r.location)}</td>
                    <td>
                        <div style="font-weight:600;font-size:.85rem;">${escHtml(r.tenant_name)}</div>
                        ${r.room_number && r.room_number !== '—' ? `<div style="font-size:.76rem;color:var(--ink-muted);">Room ${escHtml(String(r.room_number))}</div>` : ''}
                    </td>
                    <td style="font-size:.82rem;white-space:nowrap;">${fmtDate(r.reported_at)}</td>
                    <td style="font-size:.82rem;color:var(--ink-muted);max-width:180px;">${truncate(r.description, 55)}</td>
                    <td>${statusBadge(r.status)}</td>
                    <td>
                        <div class="action-group" style="justify-content:center;">
                            <button class="act-btn" title="View" onclick='viewReport(${JSON.stringify(r)})'>
                                <img src="{{ asset('icons/eye.png') }}" alt="View">
                            </button>
                            <button class="act-btn danger" title="Delete" onclick="openDeleteModal(${r.report_id}, ${JSON.stringify(r.emergency_type).replace(/"/g, '&quot;')})">
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
        document.getElementById('showing-label').textContent = `Showing ${from}–${to} of ${total} entries`;
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
        const q      = document.getElementById('search-input').value.toLowerCase();
        const status = document.getElementById('status-filter').value;
        const type   = document.getElementById('type-filter').value;
        const sort   = document.getElementById('sort-select').value;

        filtered = reports.filter(r => {
            const matchSearch =
                (r.emergency_type ?? '').toLowerCase().includes(q) ||
                (r.location       ?? '').toLowerCase().includes(q) ||
                (r.tenant_name    ?? '').toLowerCase().includes(q) ||
                (r.description    ?? '').toLowerCase().includes(q);
            const matchStatus = !status || r.status === status;
            const matchType   = !type   || r.emergency_type === type;
            return matchSearch && matchStatus && matchType;
        });

        if (sort === 'newest') filtered.sort((a, b) => new Date(b.reported_at) - new Date(a.reported_at));
        if (sort === 'oldest') filtered.sort((a, b) => new Date(a.reported_at) - new Date(b.reported_at));

        currentPage = 1;
        renderTable();
    }

    function viewReport(r) {
        currentRep = r;

        const reportedBy = [
            escHtml(r.tenant_name ?? '—'),
            r.room_number ? `<span style="color:var(--ink-muted);font-weight:400;"> · Room ${escHtml(String(r.room_number))}</span>` : ''
        ].join('');

        document.getElementById('view-content').innerHTML = `
            ${r.is_panic_alert
                ? `<div class="panic-banner"><img src="{{ asset('icons/warning.png') }}" alt=""> This is a Panic Alert</div>`
                : ''}
            ${buildSuggestedHotlines(r.emergency_type, r.urgency_level, r.is_panic_alert)}
            <div class="modal-section">
                <div class="modal-section-title">Report Information</div>
                <div class="view-detail-grid">
                    <div class="view-detail-item">
                        <div class="vdi-label">Emergency Type</div>
                        <div class="vdi-val">${escHtml(r.emergency_type ?? '—')}</div>
                    </div>
                    <div class="view-detail-item">
                        <div class="vdi-label">Urgency Level</div>
                        <div class="vdi-val">${urgencyBadge(r.urgency_level)}</div>
                    </div>
                    <div class="view-detail-item">
                        <div class="vdi-label">Status</div>
                        <div class="vdi-val">${statusBadge(r.status)}</div>
                    </div>
                    <div class="view-detail-item">
                        <div class="vdi-label">Location</div>
                        <div class="vdi-val">${escHtml(r.location ?? '—')}</div>
                    </div>
                    <div class="view-detail-item">
                        <div class="vdi-label">Reported By</div>
                        <div class="vdi-val">${reportedBy}</div>
                    </div>
                    <div class="view-detail-item">
                        <div class="vdi-label">Date Reported</div>
                        <div class="vdi-val">${fmtDate(r.reported_at)}</div>
                    </div>
                    <div class="view-detail-item full">
                        <div class="vdi-label">Date Resolved</div>
                        <div class="vdi-val ${!r.resolved_at ? 'muted' : ''}">${r.resolved_at ? fmtDate(r.resolved_at) : '—'}</div>
                    </div>
                    <div class="view-detail-item full">
                        <div class="vdi-label">Description</div>
                        <div class="vdi-val" style="white-space:pre-wrap;">${escHtml(r.description ?? '—')}</div>
                    </div>
                    ${r.admin_notes ? `
                    <div class="view-detail-item full">
                        <div class="vdi-label">Frontdesk Notes</div>
                        <div class="vdi-val" style="white-space:pre-wrap;">${escHtml(r.admin_notes)}</div>
                    </div>` : ''}
                </div>
            </div>
        `;
        openModal('view-modal');

        if (r && r.report_id) {
            var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
            fetch('/emergency/' + r.report_id + '/acknowledge', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }
            }).catch(function(e) {});
        }
    }

    function switchToEdit() {
        if (currentRep) {
            closeModal('view-modal');
            setTimeout(() => openEditModal(currentRep), 200);
        }
    }

    function openEditModal(r) {
        currentRep = r;
        document.getElementById('edit-status').value   = r.status ?? 'active';
        document.getElementById('edit-location').value = r.location    ?? '';
        document.getElementById('edit-notes').value    = r.admin_notes ?? '';
        updateEditStatusDot(document.getElementById('edit-status'));
        openModal('edit-modal');
    }

    function updateEditStatusDot(select) {
        const dot = document.getElementById('edit-status-dot');
        const colors = { active: 'var(--bright-pink)', resolved: '#1a9d6e', closed: '#9e9e9e' };
        dot.style.background = colors[select.value] ?? 'var(--bright-pink)';
    }

    async function submitUpdate() {
        if (!currentRep) return;
        const btn = document.querySelector('#edit-modal .btn-submit');
        btn.disabled    = true;
        btn.textContent = 'Saving...';
        showActionLoading('Updating report...');

        try {
            const res = await fetch(`/frontdesk/emergency/${currentRep.report_id}`, {
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
        } catch {
            showToast('Network error.', 'error');
        } finally {
            hideActionLoading();
            btn.disabled    = false;
            btn.textContent = 'Save Changes';
        }
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
        showActionLoading('Deleting report...');

        try {
            const res = await fetch(`/frontdesk/emergency/${deleteId}`, {
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
            showToast('Network error.', 'error');
        } finally {
            hideActionLoading();
            btn.disabled    = false;
            btn.textContent = 'Delete';
        }
    }

    function openArchive() {
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        document.getElementById('acount-closed').textContent    = closedArchive.length;
        document.getElementById('acount-resolved').textContent  = resolvedArchive.length;
        document.getElementById('acount-deleted').textContent   = deletedArchive.length;
        renderArchive();
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-closed').classList.toggle('active',   tab === 'closed');
        document.getElementById('atab-resolved').classList.toggle('active', tab === 'resolved');
        document.getElementById('atab-deleted').classList.toggle('active',  tab === 'deleted');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    function renderArchive() {
        const q    = normalizeFilterValue(document.getElementById('archive-search').value);
        const list = document.getElementById('archive-list');
        const data = archiveTab === 'closed' ? closedArchive : archiveTab === 'resolved' ? resolvedArchive : deletedArchive;
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
                No ${archiveTab === 'resolved' ? 'resolved' : archiveTab} emergency reports found.
            </div>`;
            return;
        }

        const urgencyPillClass = {
            critical: 'archive-pill-critical',
            urgent:   'archive-pill-urgent',
            moderate: 'archive-pill-moderate',
        };
        const archiveLabel = archiveTab === 'closed' ? 'Closed on' : archiveTab === 'resolved' ? 'Resolved on' : 'Deleted on';
        const byLabel      = archiveTab === 'closed' ? 'Closed by' : archiveTab === 'resolved' ? 'Resolved by' : 'Deleted by';

        list.innerHTML = filteredArchive.map((r, i) => `
            <div class="archive-card" style="animation-delay:${i * 0.04}s;">
                <div class="archive-card-top">
                    <div class="archive-card-id">#EM-${String(r.id).padStart(3,'0')}</div>
                    <div class="archive-card-time">${fmtDatePlain(r.reported_at)}</div>
                </div>
                <div class="archive-card-title">${escHtml(r.emergency_type ?? '—')}</div>
                <div class="archive-card-room">
                    ${escHtml(r.location ?? '—')}
                    ${r.tenant_name ? ` · ${escHtml(r.tenant_name)}` : ''}
                    ${r.room_number && r.room_number !== '—' ? ` · Room ${escHtml(String(r.room_number))}` : ''}
                </div>
                <div class="archive-card-meta">
                    <span class="archive-pill archive-pill-type">${escHtml(r.status ?? 'active')}</span>
                    <span class="archive-pill ${urgencyPillClass[normalizeFilterValue(r.urgency_level)] ?? 'archive-pill-moderate'}">${escHtml(r.urgency_level ?? 'moderate')}</span>
                    ${r.is_panic_alert ? '<span class="archive-pill archive-pill-critical">Panic</span>' : ''}
                </div>
                ${r.description ? `<div class="archive-card-desc">${escHtml(r.description)}</div>` : ''}
                <div class="archive-card-archived">
                    ${archiveLabel}: <span>${fmtDatePlain(r.archived_at)}</span>
                </div>
                <div class="archive-card-archived">
                    ${byLabel}: <span>${escHtml(r.archived_by_label ?? 'Unknown')}</span>
                </div>
            </div>
        `).join('');
    }

    function exportTable(format) {
        const columns = ['Report ID','Reported At','Type','Urgency','Location','Tenant / Reporter','Room','Status','Description'];
        const buildRow = r => [
            '#EM-' + String(r.report_id).padStart(3,'0'),
            fmtDatePlain(r.reported_at),
            r.emergency_type || '',
            r.urgency_level  || '',
            r.location       || '',
            r.tenant_name    || '',
            (r.room_number && r.room_number !== '—') ? String(r.room_number) : '',
            r.status         || '',
            r.description    || '',
        ];

        if (format === 'pdf') {
            DormEasePdfReport.printTableReport({
                title: 'Emergency Reports',
                subtitle: 'Current emergency report records',
                columns: columns,
                rows: filtered.map(buildRow),
                orientation: 'landscape'
            });
            return;
        }

        const rows = [columns];
        filtered.forEach(r => rows.push(buildRow(r)));
        const csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g,'""') + '"').join(',')).join('\n');
        const a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' }));
        a.download = 'frontdesk_emergency_reports.csv';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    function exportArchive(format) {
        const data     = archiveTab === 'closed' ? closedArchive : archiveTab === 'resolved' ? resolvedArchive : deletedArchive;
        const label    = archiveTab === 'closed' ? 'Closed On' : archiveTab === 'resolved' ? 'Resolved On' : 'Deleted On';
        const byLbl    = archiveTab === 'closed' ? 'Closed By' : archiveTab === 'resolved' ? 'Resolved By' : 'Deleted By';
        const columns  = ['Report ID','Reported At','Type','Urgency','Location','Tenant / Reporter','Room','Status','Description',label,byLbl];
        const buildRow = r => [
            '#EM-' + String(r.id).padStart(3,'0'),
            fmtDatePlain(r.reported_at),
            r.emergency_type    || '',
            r.urgency_level     || '',
            r.location          || '',
            r.tenant_name       || '',
            (r.room_number && r.room_number !== '—') ? String(r.room_number) : '',
            r.status            || '',
            r.description       || '',
            fmtDatePlain(r.archived_at),
            r.archived_by_label || '',
        ];

        if (format === 'pdf') {
            const win      = window.open('', '_blank');
            const tabLabel = archiveTab === 'closed' ? 'Closed' : archiveTab === 'resolved' ? 'Resolved' : 'Deleted';
            const rows = data.map(r => `<tr>${buildRow(r).map(c => `<td>${escHtml(String(c))}</td>`).join('')}</tr>`).join('');
            win.document.write(`<!DOCTYPE html><html><head><title>Emergency Archive - ${tabLabel}</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style></head><body><h2>Emergency Archive - ${tabLabel}</h2><p>Sanctissimo Rosario Ladies Dormitory — exported ${new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})}</p><table><thead><tr>${columns.map(c => `<th>${c}</th>`).join('')}</tr></thead><tbody>${rows}</tbody></table></body></html>`);
            win.document.close();
            win.print();
            return;
        }

        const rows = [columns];
        data.forEach(r => rows.push(buildRow(r)));
        const csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g,'""') + '"').join(',')).join('\n');
        const a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' }));
        a.download = `frontdesk_emergency_${archiveTab}_archive.csv`;
        a.click();
        URL.revokeObjectURL(a.href);
    }

    function getMenuForDropdown(id) {
        return Array.from(document.querySelectorAll('.export-menu')).find(function(m) {
            return m._sourceDropdownId === id;
        }) || document.querySelector('#' + id + ' .export-menu');
    }

    function positionExportMenu(dropdown) {
        const btn  = dropdown.querySelector('button');
        const menu = getMenuForDropdown(dropdown.id);
        const rect = btn.getBoundingClientRect();

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

        const menuHeight = menu.offsetHeight || 80;
        const spaceBelow = window.innerHeight - rect.bottom;

        if (spaceBelow >= menuHeight + 6) {
            menu.style.top    = (rect.bottom + 6) + 'px';
            menu.style.bottom = 'auto';
        } else {
            menu.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
            menu.style.top    = 'auto';
        }
    }

    function toggleExportDropdown(id) {
        const dropdown = document.getElementById(id);
        const menu     = getMenuForDropdown(id);
        const isOpen   = menu.classList.contains('open');
        closeAllExportDropdowns();
        if (!isOpen) {
            positionExportMenu(dropdown);
            getMenuForDropdown(id).classList.add('open');
        }
    }

    function closeAllExportDropdowns() {
        document.querySelectorAll('.export-menu').forEach(m => m.classList.remove('open'));
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.export-dropdown')) {
            closeAllExportDropdowns();
        }
    });

    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif

    document.getElementById('report-form').addEventListener('submit', function(event) {
    const btn  = document.getElementById('report-submit-btn');
    const type = document.querySelector('#report-modal select[name="emergency_type"]').value;
    const loc  = document.getElementById('location-hidden-input').value.trim();

    if (!type) {
        showToast('Please select an emergency type.', 'error');
        event.preventDefault();
        return;
    }
    if (!loc) {
        showToast('Please select a location.', 'error');
        event.preventDefault();
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Submitting...';
    showActionLoading('Submitting emergency report...');
});

    const LOCATION_OPTIONS = [
    { group: 'Common Areas', options: [
        'Lobby', 'Main Entrance',
        'Hallway – Ground Floor', 'Hallway – 2nd Floor', 'Hallway – 3rd Floor', 'Hallway – 4th Floor',
        'Stairwell', 'Fire Exit', 'Rooftop',
        'Comfort Room – Ground Floor', 'Comfort Room – 2nd Floor', 'Comfort Room – 3rd Floor', 'Comfort Room – 4th Floor',
        'Kitchen / Pantry', 'Laundry Area', 'Study Room', 'Dining Area', 'Receiving Area', 'Parking / Garage',
    ]},
    { group: 'Rooms', options: [
        'Room 101','Room 102','Room 103','Room 104',
        'Room 201','Room 202','Room 203','Room 204',
        'Room 301','Room 302','Room 303','Room 304',
        'Room 401','Room 402','Room 403','Room 404',
    ]},
];

function buildLocationDropdown(query) {
    const dd  = document.getElementById('location-dropdown');
    const q   = (query ?? '').trim().toLowerCase();
    let html  = '';
    let total = 0;

    LOCATION_OPTIONS.forEach(group => {
        const filtered = group.options.filter(o => !q || o.toLowerCase().includes(q));
        if (!filtered.length) return;
        html += `<div class="loc-group-label">${escHtml(group.group)}</div>`;
        filtered.forEach(o => {
            const selected = document.getElementById('location-hidden-input').value === o ? ' selected' : '';
            html += `<div class="loc-option${selected}" onmousedown="selectLocation('${o.replace(/'/g, "\\'")}')">${escHtml(o)}</div>`;
        });
        total += filtered.length;
    });

    if (q && total === 0) {
        html = `<div class="loc-option" onmousedown="selectLocation('${escHtml(q)}')" style="font-style:italic;">Use "${escHtml(query)}"</div>`;
    }

    dd.innerHTML = html;
}

function filterLocationOptions(val) {
    buildLocationDropdown(val);
    document.getElementById('location-dropdown').classList.add('open');
    if (!val.trim()) {
        document.getElementById('location-hidden-input').value = '';
    }
}

function openLocationDropdown() {
    buildLocationDropdown(document.getElementById('location-search-input').value);
    document.getElementById('location-dropdown').classList.add('open');
}

function closeLocationDropdown(delay) {
    setTimeout(() => {
        document.getElementById('location-dropdown').classList.remove('open');
    }, delay ?? 0);
}

function selectLocation(value) {
    document.getElementById('location-hidden-input').value = value;
    document.getElementById('location-search-input').value = value;
    document.getElementById('location-dropdown').classList.remove('open');
}

    function populateTypeFilter() {
        const select = document.getElementById('type-filter');
        const types = [...new Set(
            reports.map(r => String(r.emergency_type ?? '').trim()).filter(t => t && t !== '—')
        )].sort((a, b) => a.localeCompare(b));
        select.innerHTML = '<option value="">All Types</option>' +
            types.map(t => `<option value="${escHtml(t)}">${escHtml(t)}</option>`).join('');
    }

    (function() {
        var popup = document.getElementById('fd-status-legend-popup');
        var wrap  = document.getElementById('fd-status-legend-wrap');
        if (!popup || !wrap) return;

        document.body.appendChild(popup);
        popup.style.display = 'none';

        var hideTimer = null;

        wrap.addEventListener('mouseenter', function() {
            clearTimeout(hideTimer);
            var rect       = wrap.getBoundingClientRect();
            var popupWidth = 320;
            var left       = rect.left;
            if (left + popupWidth > window.innerWidth - 12) {
                left = window.innerWidth - popupWidth - 12;
            }
            popup.style.top     = (rect.bottom + 8) + 'px';
            popup.style.left    = left + 'px';
            popup.style.display = 'block';
        });

        wrap.addEventListener('mouseleave', function() {
            hideTimer = setTimeout(function() {
                popup.style.display = 'none';
            }, 150);
        });

        popup.addEventListener('mouseenter', function() {
            clearTimeout(hideTimer);
        });

        popup.addEventListener('mouseleave', function() {
            hideTimer = setTimeout(function() {
                popup.style.display = 'none';
            }, 150);
        });
    })();

    function resetFilters() {
        document.getElementById('search-input').value = '';
        document.getElementById('status-filter').value = '';
        document.getElementById('type-filter').value = '';
        document.getElementById('sort-select').value = 'newest';
        applyFilters();
    }
    populateTypeFilter();
    applyFilters();
    renderDirList();
    (function () {
        var POLL_INTERVAL     = 30000;
        var pollTimer         = null;
        var lastPanicId       = null;
        var lastReportFingerprint = null;

        function isAnyModalOpen() {
            var overlays = document.querySelectorAll('.modal-overlay');
            for (var i = 0; i < overlays.length; i++) {
                if (overlays[i].classList.contains('open')) return true;
            }
            return false;
        }

        function isArchiveDrawerOpen() {
            var drawer = document.getElementById('archive-drawer');
            return drawer && drawer.classList.contains('open');
        }

        function isUserTyping() {
            var active = document.activeElement;
            if (!active) return false;
            var tag = active.tagName.toLowerCase();
            return tag === 'input' || tag === 'textarea' || tag === 'select' || active.isContentEditable;
        }

        function shouldSkipDataPoll() {
            return isAnyModalOpen() || isArchiveDrawerOpen() || isUserTyping();
        }

        function updateStats(freshReports) {
            var critical = freshReports.filter(function (r) {
                return r.urgency_level === 'critical' || r.urgency_level === 'urgent';
            }).length;
            var panic = freshReports.filter(function (r) {
                return r.is_panic_alert && r.status === 'active';
            }).length;

            var statNums = document.querySelectorAll('.stat-num');
            if (statNums[1]) statNums[1].textContent = critical;
            if (statNums[2]) statNums[2].textContent = panic;
        }

        function applyFreshReports(freshReports) {
            var fingerprint = JSON.stringify(freshReports.map(function (r) {
                return r.report_id + '|' + r.status + '|' + r.urgency_level + '|' + r.is_panic_alert;
            }));

            if (fingerprint === lastReportFingerprint) return;
            lastReportFingerprint = fingerprint;

            reports.length = 0;
            freshReports.forEach(function (r) { reports.push(r); });

            populateTypeFilter();
            applyFilters();
            updateStats(freshReports);
        }

        function checkPanic(freshReports) {
            var panicReport = null;
            for (var i = 0; i < freshReports.length; i++) {
                if (freshReports[i].is_panic_alert && freshReports[i].status === 'active') {
                    panicReport = freshReports[i];
                    break;
                }
            }
            if (panicReport && panicReport.report_id !== lastPanicId) {
                lastPanicId = panicReport.report_id;
                showToast('PANIC ALERT: ' + (panicReport.emergency_type || 'Emergency') + ' at ' + (panicReport.location || 'unknown'), 'error');
            }
        }

        function poll() {
            var skipData = shouldSkipDataPoll();

            fetch('{{ url("/frontdesk/emergency/poll/panic") }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.has_panic && data.report_id !== lastPanicId) {
                    lastPanicId = data.report_id;
                    showToast('PANIC ALERT: ' + (data.type || 'Emergency') + ' at ' + (data.location || 'unknown'), 'error');
                }
            })
            .catch(function () {});

            if (skipData) {
                pollTimer = setTimeout(poll, POLL_INTERVAL);
                return;
            }

            fetch('{{ url("/frontdesk/emergency/poll/reports") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(function (r) { return r.json(); })
            .then(function (freshReports) {
                if (Array.isArray(freshReports)) {
                    applyFreshReports(freshReports);
                    checkPanic(freshReports);
                }
            })
            .catch(function () {})
            .finally(function () {
                pollTimer = setTimeout(poll, POLL_INTERVAL);
            });
        }

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                clearTimeout(pollTimer);
                poll();
            } else {
                clearTimeout(pollTimer);
            }
        });

        pollTimer = setTimeout(poll, POLL_INTERVAL);
    })();
</script>
@endsection
