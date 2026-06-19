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
        background: var(--blush);
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

    .btn-archive-open img { width: 14px; height: 14px; object-fit: contain; }

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
        transition: transform .2s, box-shadow .2s;
    }

    .stat-icon {
        width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
        background: var(--white); display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,.15);
    }

    .stat-icon img {
        width: 28px; height: 28px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .stat-num { font-size: 2rem; font-weight: 700; color: var(--white); line-height: 1; }
    .stat-label { font-size: .8rem; color: rgba(247,245,245,.967); font-weight: 700; margin-bottom: .15rem;}

    .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(232,23,93,.35);
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

    .table-heading { font-size: 1rem; font-weight: 800; color: var(--ink); }
    .table-sub { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; }

    .table-controls { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }

    .search-box { position: relative; display: flex; align-items: center; }

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

    .search-box input:focus { border-color: var(--bright-pink); background: var(--white); width: 210px; }

    .search-icon { position: absolute; left: .6rem; width: 14px; height: 14px; object-fit: contain; opacity: .4; pointer-events: none; }

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

    .filter-select:focus { border-color: var(--bright-pink); background-color: var(--white); }

    .date-filter {
        display: flex; align-items: center; gap: .35rem;
        padding: .35rem .65rem; border-radius: 10px;
        border: 1.5px solid var(--pink-200); background: var(--pink-50);
    }

    .date-filter input {
        border: none; outline: none; background: transparent;
        color: var(--ink); font-size: .81rem; font-weight: 600; font-family: var(--ff-body);
    }

    .date-filter span { color: var(--ink-muted); font-size: .78rem; font-weight: 700; }

    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; table-layout: fixed; font-size: .88rem; }

    thead th {
        padding: .75rem .85rem;
        text-align: left;
        font-size: .78rem; font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .05em;
        background: var(--pink-100);
        border-bottom: 1px solid var(--bright-pink);
        white-space: nowrap;
    }

    thead th:nth-child(7), thead th:nth-child(8) { text-align: center; }

    tbody tr { border-bottom: 2px solid var(--pink-100); transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--pink-50); }

    tbody td {
        padding: .8rem .85rem; color: var(--ink);
        vertical-align: middle; text-align: left; font-weight: 500;
    }

    tbody td:nth-child(7), tbody td:nth-child(8) { text-align: center; }

    .type-cell { display: flex; align-items: center; justify-content: flex-start; gap: .5rem; flex-wrap: wrap; }

    .panic-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--bright-pink); flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(255,45,120,.2);
        animation: pulseDot 1.5s infinite;
    }

    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%       { transform: scale(1.4); opacity: .7; }
    }

    .badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .71rem; font-weight: 700; white-space: nowrap;
    }

    .badge-active   { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .badge-resolved { background: #e8faf5; color: #1a9d6e; border: 1px solid #8cdebb; }
    .badge-closed   { background: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }
    .badge-panic    { background: var(--bright-pink); color: var(--white); border: none; }
    .badge-critical { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .badge-urgent   { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .badge-moderate { background: #eef2ff; color: #4f6ef7; border: 1px solid #c7d2fe; }

    .location-cell, .date-cell, .reporter-cell, .desc-cell { font-size: .84rem; }
    .date-cell { white-space: nowrap; color: var(--ink-muted); }
    .reporter-name { font-weight: 600; color: var(--ink); }
    .reporter-room { font-size: .76rem; color: var(--ink-muted); margin-top: .08rem; }
    .desc-cell { color: var(--ink-muted); line-height: 1.35; overflow-wrap: break-word; }

    .action-group { display: flex; align-items: center; justify-content: center; gap: .35rem; }

    .act-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid var(--pink-200); background: var(--white);
        cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
        transition: .2s; font-family: var(--ff-body);
    }

    .act-btn:hover { border-color: var(--bright-pink); box-shadow: 0 3px 10px rgba(255,45,120,.15); }
    .act-btn img { width: 16px; height: 16px; object-fit: contain; object-position: center; }
    .act-btn.danger:hover { border-color: #e04867; }

    .table-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: .8rem 1.2rem; flex-wrap: wrap; gap: .5rem;
        border-top: 1.5px solid var(--pink-100);
    }

    .showing-label { font-size: .78rem; color: var(--ink-muted); }

    .pagination { display: flex; align-items: center; gap: .3rem; }

    .page-btn {
        min-width: 32px; height: 32px; padding: 0 .5rem;
        border-radius: 8px; border: 1.5px solid var(--pink-200);
        background: var(--white); color: var(--hot-pink);
        font-size: .81rem; font-weight: 700; cursor: pointer;
        font-family: var(--ff-body); transition: .2s;
    }

    .page-btn:hover:not(:disabled) {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white); border-color: transparent;
    }

    .page-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white); border-color: transparent;
        box-shadow: 0 4px 12px rgba(255,45,120,.25);
    }

    .page-btn:disabled { opacity: .35; cursor: default; }
    .empty-row td { text-align: center; padding: 2.5rem 1rem; color: var(--ink-muted); font-size: .9rem; }

    .modal-overlay {
        position: fixed; inset: 0; z-index: 800;
        display: none; align-items: center; justify-content: center;
        background: rgba(90,30,56,.38);
        backdrop-filter: blur(4px);
        padding: 1rem;
    }

    .modal-overlay.open { display: flex; }

    .modal {
        background: var(--white);
        border-radius: 20px;
        width: 100%; max-width: 540px;
        box-shadow: 0 24px 60px rgba(232,23,93,.18), 0 4px 16px rgba(0,0,0,.08);
        display: flex; flex-direction: column;
        max-height: 92vh;
        overflow: hidden;
        animation: modalIn .28s cubic-bezier(.34,1.3,.64,1) both;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: translateY(18px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header {
        padding: .85rem 1.1rem .75rem;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1.5px solid var(--pink-100);
        flex-shrink: 0;
    }

    .modal-title {
        font-size: 1.05rem; font-weight: 800; color: var(--ink);
        letter-spacing: -.02em; display: flex; align-items: center; gap: .5rem;
    }

    .modal-close {
        width: 30px; height: 30px; border-radius: 8px;
        border: 1.5px solid var(--pink-100); background: var(--petal);
        color: var(--bright-pink); font-size: .95rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, color .2s, border-color .2s; flex-shrink: 0;
    }

    .modal-close:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }

    .modal-body {
        flex: 1; overflow-y: auto; padding: .9rem 1.1rem;
        scrollbar-width: thin; scrollbar-color: var(--pink-200) transparent;
    }

    .modal-body::-webkit-scrollbar { width: 4px; }
    .modal-body::-webkit-scrollbar-track { background: transparent; }
    .modal-body::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

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
    .modal-field { display: flex; flex-direction: column; gap: .25rem; }
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

    .modal-field input:hover, .modal-field select:hover, .modal-field textarea:hover { border-color: var(--pink-200); background: #fff5f9; }
    .modal-field input:focus, .modal-field select:focus, .modal-field textarea:focus {
        border-color: var(--bright-pink);
        box-shadow: 0 0 0 3px rgba(232,23,93,.1);
        background: var(--white);
    }

    .modal-field input::placeholder, .modal-field textarea::placeholder { color: #c4a0af; }

    .modal-footer {
        padding: .7rem 1.1rem;
        border-top: 1.5px solid var(--pink-100);
        display: flex; align-items: center; justify-content: flex-end; gap: .55rem;
        flex-shrink: 0; background: #fffafd;
    }

    .btn-cancel {
        padding: .55rem 1.1rem; border-radius: 10px;
        border: 1.5px solid var(--pink-100); background: var(--white);
        color: var(--ink-muted); font-size: .85rem; font-weight: 600;
        cursor: pointer; transition: .2s; font-family: inherit;
    }

    .btn-cancel:hover { border-color: var(--bright-pink); color: var(--hot-pink); background: var(--petal); }

    .btn-submit {
        padding: .55rem 1.25rem; border-radius: 10px;
        border: none; background: var(--gradient-pink);
        color: var(--white); font-size: .85rem; font-weight: 700;
        cursor: pointer; transition: .2s; font-family: inherit;
        box-shadow: 0 6px 18px rgba(232,23,93,.25);
    }

    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(232,23,93,.35); }

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
    .vdi-val.mono  { font-family: monospace; }

    .panic-banner {
        display: flex; align-items: center; gap: .65rem;
        padding: .6rem .85rem; border-radius: 12px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white); font-size: .82rem; font-weight: 700;
        margin-bottom: .8rem;
    }

    .panic-banner img { width: 16px; height: 16px; object-fit: contain; filter: brightness(0) invert(1); flex-shrink: 0; }

    .dir-suggested-wrap {
        background: linear-gradient(135deg, #fff0f3, #fff7fb);
        border: 1.5px solid var(--pink-200);
        border-radius: 12px;
        padding: .7rem .85rem;
        margin-bottom: .8rem;
    }

    .dir-suggested-label {
        font-size: .67rem; font-weight: 800; color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .07em;
        margin-bottom: .5rem;
        display: flex; align-items: center; gap: .4rem;
    }

    .dir-suggested-label::before {
        content: '';
        display: block; width: 6px; height: 6px;
        border-radius: 50%; background: var(--hot-pink);
        animation: pulseDot 1.5s infinite;
    }

    .dir-suggested-chips { display: flex; flex-wrap: wrap; gap: .35rem; }

    .dir-suggested-chip {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .3rem .7rem; border-radius: 8px;
        background: var(--white); border: 1.5px solid var(--pink-200);
        font-size: .75rem; font-weight: 700; color: var(--ink);
        cursor: pointer; transition: .15s;
    }

    .dir-suggested-chip .chip-icon { width: 13px; height: 13px; object-fit: contain; }
    .dir-suggested-chip:hover .chip-icon { filter: brightness(0) invert(1); }
    .dir-suggested-chip:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }
    .dir-suggested-chip span { font-family: monospace; color: var(--hot-pink); font-size: .78rem; }
    .dir-suggested-chip:hover span { color: var(--white); }

    .modal-warn-banner {
        background: #fff9e6; border: 1.5px solid #f0c040; border-radius: 10px;
        padding: .5rem .8rem; font-size: .78rem; color: #7a5400; line-height: 1.5;
        display: flex; gap: .5rem; align-items: flex-start; margin-bottom: .6rem;
    }

    .delete-warn {
        background: #fff0f0; border: 1.5px solid #ffc8d0; border-radius: 10px;
        padding: .6rem .85rem; font-size: .82rem; color: #c0303a;
        margin-bottom: .75rem; line-height: 1.5;
    }

    .status-select-wrap { position: relative; }
    .status-dot {
        position: absolute; left: .75rem; top: 50%; transform: translateY(-50%);
        width: 8px; height: 8px; border-radius: 50%; pointer-events: none;
        transition: background .2s;
    }
    .status-select-wrap select { padding-left: 1.9rem; }

    .dir-modal .modal-header {
        border-bottom: none;
        padding-bottom: .75rem;
    }
    
    .dir-modal {
        max-height: 85vh;
        height: 85vh;
    }

    .dir-tabs {
        display: flex;
        gap: 0;
        padding: 0 1.1rem;
        border-top: 1.5px solid var(--pink-100);
        border-bottom: 1.5px solid var(--pink-100);
        flex-shrink: 0;
        overflow-x: auto;
        overflow-y: visible;
        scrollbar-width: none;
        background: var(--white);
        margin: 0;
    }

    .dir-tabs::-webkit-scrollbar { display: none; }

    .dir-tab {
        position: relative;
        padding: .65rem .75rem;
        font-size: .75rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: none;
        border: none;
        border-bottom: none;
        margin-bottom: -1.5px;
        cursor: pointer;
        transition: color .2s;
        white-space: nowrap;
        font-family: var(--ff-body);
        display: inline-flex;
        align-items: center;
        gap: .35rem;
    }

    .dir-tab::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 60%;
        height: 2.5px;
        background: var(--hot-pink);
        border-radius: 2px 2px 0 0;
        transform-origin: center;
        transition: transform .22s ease;
    }

    .dir-tab:hover { color: var(--hot-pink); }
    .dir-tab:hover::after { transform: translateX(-50%) scaleX(0.45); }
    .dir-tab.active { color: var(--hot-pink); }
    .dir-tab.active::after { transform: translateX(-50%) scaleX(1); }

    .dir-tab-icon { width: 14px; height: 14px; object-fit: contain; opacity: .5; }
    .dir-tab.active .dir-tab-icon { opacity: 1; }

    .dir-search-bar {
        padding: .85rem .75rem;
        flex-shrink: 0;
    }

    .dir-search-inner { position: relative; display: flex; align-items: center; }

    .dir-search-inner input {
        width: 100%; padding: .5rem .9rem .5rem 2.1rem;
        border-radius: 10px; border: 1.5px solid var(--pink-100);
        background: #fffafd; color: var(--ink); font-size: .83rem;
        font-family: var(--ff-body); outline: none;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }

    .dir-search-inner input:focus {
        border-color: var(--bright-pink);
        box-shadow: 0 0 0 3px rgba(232,23,93,.1);
    }

    .dir-search-icon {
        position: absolute; left: .7rem; width: 13px; height: 13px;
        opacity: .4; pointer-events: none;
    }

    .dir-list { flex: 1; overflow-y: auto; padding: 0 1.1rem 1rem; display: flex; flex-direction: column; gap: .45rem; }
    .dir-list::-webkit-scrollbar { width: 4px; }
    .dir-list::-webkit-scrollbar-track { background: transparent; }
    .dir-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

    .dir-section-heading {
        font-size: .65rem; font-weight: 800; color: var(--bright-pink);
        text-transform: uppercase; letter-spacing: .08em;
        margin: .6rem 0 .3rem;
        display: flex; align-items: center; gap: .35rem;
    }

    .dir-section-heading::before {
        content: ''; display: inline-block;
        width: 3px; height: 10px;
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
        font-family: monospace; white-space: nowrap;
        cursor: pointer; transition: .15s;
    }

    .dir-number-chip:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }

    .dir-hint {
        margin: .5rem 0 0;
        background: var(--blush); border: 1px solid var(--pink-100); border-radius: 10px;
        padding: .5rem .8rem; font-size: .73rem; color: var(--ink-muted); line-height: 1.55;
    }

    .archive-backdrop {
        position: fixed; inset: 0;
        background: rgba(232,23,93,.15);
        backdrop-filter: blur(3px);
        z-index: 499; opacity: 0; pointer-events: none;
        transition: opacity .38s ease;
    }

    .archive-backdrop.open { opacity: 1; pointer-events: auto; }

    .archive-drawer {
        position: fixed; top: 0; right: 0; bottom: 0;
        width: min(680px, 100vw);
        background: var(--pink-bg); z-index: 500;
        display: flex; flex-direction: column;
        transform: translateX(100%);
        transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(0,0,0,.25);
    }

    .archive-drawer.open { transform: translateX(0); }

    .archive-drawer-header {
        padding: 1.4rem 1.6rem 1rem; border-bottom: 2px solid var(--bright-pink);
        display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
        background: var(--white); flex-shrink: 0;
    }

    .archive-drawer-title { font-size: 1.2rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
    .archive-drawer-sub { font-size: .76rem; color: var(--ink-muted); margin-top: .2rem; font-weight: 500; }

    .archive-close-btn {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--petal); border: 1.5px solid var(--pink-200);
        color: var(--hot-pink); font-size: .95rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center; transition: .2s; flex-shrink: 0;
    }

    .archive-close-btn:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }

    .archive-tabs {
        display: flex; gap: 0; padding: 0 1.6rem;
        border-bottom: 1.5px solid var(--pink-100);
        background: var(--white); flex-shrink: 0;
    }

    .archive-tab {
        padding: .8rem 1.1rem; font-size: .81rem; font-weight: 700;
        color: var(--ink-muted); background: none; border: none;
        border-bottom: 2px solid transparent; margin-bottom: -1px;
        cursor: pointer; transition: color .2s, border-color .2s;
        display: flex; align-items: center; gap: .45rem; font-family: var(--ff-body);
    }

    .archive-tab:hover, .archive-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

    .archive-tab-count {
        font-size: .67rem; font-weight: 800; padding: .1rem .42rem;
        border-radius: 99px; background: var(--pink-100); color: var(--hot-pink);
    }

    .archive-search-bar { padding: .9rem 1.6rem .7rem; flex-shrink: 0; }

    .archive-search-inner { position: relative; display: flex; align-items: center; }

    .archive-search-inner input {
        width: 100%; padding: .5rem .9rem .5rem 2.1rem;
        border-radius: 10px; border: 1.5px solid var(--pink-200);
        background: var(--white); color: var(--ink); font-size: .82rem;
        font-family: var(--ff-body); outline: none; transition: border-color .2s;
    }

    .archive-search-inner input:focus { border-color: var(--bright-pink); }

    .archive-search-icon { position: absolute; left: .72rem; width: 13px; height: 13px; opacity: .35; pointer-events: none; }

    .archive-list {
        flex: 1; overflow-y: auto; padding: 0 1.6rem 1.6rem;
        display: flex; flex-direction: column; gap: .7rem;
    }

    .archive-card {
        background: var(--white); border: 1.5px solid var(--pink-200);
        border-radius: 14px; padding: .9rem 1rem;
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
        display: flex; align-items: flex-start; justify-content: space-between; gap: .8rem; margin-bottom: .55rem;
    }

    .archive-card-id { font-size: .76rem; font-weight: 800; color: var(--hot-pink); letter-spacing: .02em; }
    .archive-card-time { font-size: .7rem; color: var(--ink-muted); font-weight: 500; white-space: nowrap; flex-shrink: 0; }
    .archive-card-title { font-size: .87rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
    .archive-card-room { font-size: .74rem; color: var(--ink-muted); margin-top: .1rem; }

    .archive-card-meta { display: flex; align-items: center; gap: .45rem; margin-top: .6rem; flex-wrap: wrap; }

    .archive-pill {
        font-size: .67rem; font-weight: 800; padding: .17rem .5rem;
        border-radius: 99px; letter-spacing: .03em; text-transform: uppercase;
        display: inline-flex; align-items: center; line-height: 1;
    }

    .archive-pill-type     { background: var(--pink-100); color: var(--hot-pink); border: 1px solid var(--pink-200); }
    .archive-pill-critical { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .archive-pill-urgent   { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .archive-pill-moderate { background: #eef2ff; color: #4f6ef7; border: 1px solid #c7d2fe; }

    .archive-card-desc {
        font-size: .77rem; color: var(--ink-muted); margin-top: .45rem; line-height: 1.5;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    .archive-card-archived {
        display: flex; align-items: center; gap: .4rem;
        margin-top: .7rem; padding-top: .55rem; border-top: 1px solid var(--pink-100);
        font-size: .69rem; color: var(--ink-muted); font-weight: 500;
    }

    .archive-card-archived span { color: var(--bright-pink); font-weight: 700; }

    .archive-empty { text-align: center; padding: 3rem 1rem; color: var(--ink-muted); font-size: .85rem; }
    .archive-empty-icon { width: 38px; height: 38px; margin: 0 auto .7rem; opacity: .25; display: block; }

    .archive-footer {
        padding: .8rem 1.6rem; border-top: 2px solid var(--pink-100);
        background: var(--white); display: flex; align-items: center;
        justify-content: space-between; flex-shrink: 0; flex-wrap: wrap; gap: .5rem;
    }

    .archive-count-label { font-size: .74rem; color: var(--ink-muted); font-weight: 600; }

    .archive-export-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .74rem; font-weight: 700; color: var(--hot-pink);
        background: var(--white); border: 1.5px solid var(--pink-200);
        border-radius: 8px; padding: .32rem .8rem;
        cursor: pointer; transition: .2s; font-family: var(--ff-body);
    }

    .archive-export-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .65; }

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-100); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .62rem 1rem; background: none; border: none; text-align: left; font-size: .83rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
    .export-menu button:hover { background: var(--petal); color: var(--hot-pink); }

    .btn-export {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.1rem; border-radius: 10px;
        background: var(--white); color: var(--hot-pink);
        border: 1.5px solid var(--pink-100); font-size: .85rem; font-weight: 600;
        cursor: pointer; transition: .2s; font-family: var(--ff-body);
    }

    .btn-export:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .btn-export img { width: 14px; height: 14px; object-fit: contain; opacity: .6; }

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

    .fade-up { animation: fdFadeUp .45s ease both; }
    @keyframes fdFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s; }

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
    .is-loading { opacity: .75; pointer-events: none; }

    @keyframes pulseLogo {
        0%, 100% { transform: scale(1);     box-shadow: 0 10px 24px rgba(232,23,93,.25); }
        50%       { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); }
    }

    @media (max-width: 900px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .modal-grid-2 { grid-template-columns: 1fr; }
        .view-detail-grid { grid-template-columns: 1fr; }
        .archive-drawer-header { padding: 1.1rem 1rem .85rem; }
        .archive-list { padding: 0 1rem 1.2rem; }
        .archive-search-bar { padding: .75rem 1rem .6rem; }
        .archive-footer { padding: .7rem 1rem; }
        .archive-tabs { padding: 0 1rem; }
        .dir-tabs { padding: 0 .75rem; }
        .dir-list { padding: 0 .85rem .85rem; }
    }

    @media (max-width: 580px) { .stats-row { grid-template-columns: 1fr; } }

    .status-legend-wrap {
        position: static;
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
        box-shadow: 0 12px 32px rgba(232,23,93,.13), 0 2px 8px rgba(0,0,0,.07);
        padding: .75rem .9rem;
        min-width: 320px;
        z-index: 9999;
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
    .slp-badge { flex-shrink: 0; min-width: 90px; }
    .slp-desc {
        font-size: .75rem;
        color: var(--ink-muted);
        font-weight: 500;
        line-height: 1.45;
    }

    .kw-modal-header-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .8rem;
    }

    .kw-modal-icon-badge {
        width: 38px; height: 38px;
        border-radius: 11px;
        background: var(--gradient-pink);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 16px rgba(232,23,93,.3);
    }

    .kw-modal-icon-badge img {
        width: 19px; height: 19px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .kw-modal-title-block { display: flex; flex-direction: column; gap: .1rem; }

    .kw-modal-sub {
        font-size: .76rem;
        color: var(--ink-muted);
        font-weight: 500;
        line-height: 1.4;
    }

    .kw-help-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--pink-100);
        color: var(--hot-pink);
        font-size: .68rem;
        font-weight: 800;
        cursor: pointer;
        flex-shrink: 0;
        user-select: none;
        transition: background .2s, color .2s;
    }

    .kw-help-wrap:hover { background: var(--bright-pink); color: var(--white); }

    .kw-help-popup {
        display: none;
        position: fixed;
        background: #2a1320;
        color: var(--white);
        border-radius: 14px;
        padding: .9rem 1rem;
        font-size: .76rem;
        font-weight: 500;
        line-height: 1.5;
        width: 280px;
        z-index: 9999;
        box-shadow: 0 16px 36px rgba(0,0,0,.3);
        --kw-arrow-left: 50%;
    }

    .kw-help-popup::before {
        content: '';
        position: absolute;
        top: -6px;
        left: var(--kw-arrow-left);
        width: 12px; height: 12px;
        background: #2a1320;
        transform: rotate(45deg);
        border-radius: 2px;
    }

    .kw-help-popup-title {
        font-size: .72rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .07em;
        margin-bottom: .7rem;
        padding-bottom: .55rem;
        border-bottom: 1px solid rgba(255,255,255,.12);
    }

    .kw-help-step {
        display: flex;
        align-items: flex-start;
        gap: .55rem;
        margin-bottom: .6rem;
    }

    .kw-help-step:last-child { margin-bottom: 0; }

    .kw-help-step-num {
        flex-shrink: 0;
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .67rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kw-help-step span:last-child {
        color: rgba(255,255,255,.92);
    }

    .kw-help-step strong { color: var(--white); }

    .kw-segmented {
        display: flex;
        gap: .25rem;
        padding: .9rem 1.1rem .8rem;
        flex-shrink: 0;
        background: var(--white);
    }

    .kw-tab {
        flex: 1;
        position: relative;
        padding: .55rem .7rem;
        font-size: .78rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: var(--blush);
        border: 1.5px solid transparent;
        border-radius: 10px;
        cursor: pointer;
        font-family: var(--ff-body);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        transition: .2s;
    }

    .kw-tab:hover { border-color: var(--pink-200); }

    .kw-tab.active {
        background: var(--gradient-pink);
        color: var(--white);
        box-shadow: 0 6px 16px rgba(232,23,93,.25);
    }

    .kw-tab-count {
        font-size: .65rem; font-weight: 800; padding: .08rem .42rem;
        border-radius: 99px; background: rgba(255,255,255,.85); color: var(--hot-pink);
    }

    .kw-tab.active .kw-tab-count { background: rgba(255,255,255,.3); color: var(--white); }

    .kw-search-bar { padding: 0 1.1rem .8rem; flex-shrink: 0; }

    .kw-summary-bar {
        padding: 0 1.1rem .6rem;
        font-size: .72rem;
        color: var(--ink-muted);
        font-weight: 600;
        flex-shrink: 0;
    }

    .kw-summary-bar strong {
        color: var(--hot-pink);
        font-weight: 800;
    }

    .kw-search-inner { position: relative; display: flex; align-items: center; }

    .kw-search-inner input {
        width: 100%;
        padding: .5rem .85rem .5rem 2rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-100);
        background: #fffafd;
        color: var(--ink);
        font-size: .82rem;
        font-family: var(--ff-body);
        outline: none;
        box-sizing: border-box;
        transition: border-color .2s, box-shadow .2s;
    }

    .kw-search-inner input:focus {
        border-color: var(--bright-pink);
        box-shadow: 0 0 0 3px rgba(232,23,93,.1);
    }

    .kw-search-icon { position: absolute; left: .65rem; width: 13px; height: 13px; opacity: .35; pointer-events: none; }

    .kw-list {
        flex: 1 1 auto; overflow-y: scroll;
        padding: 0 1.1rem 1.1rem;
        display: flex; flex-direction: column; gap: .75rem;
        scrollbar-width: thin; scrollbar-color: var(--pink-200) transparent;
        min-height: 0;
        max-height: none;
    }

    .kw-list::-webkit-scrollbar { width: 4px; }
    .kw-list::-webkit-scrollbar-track { background: transparent; }
    .kw-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

    .kw-card {
        position: relative;
        background: var(--white);
        border: 1.5px solid var(--pink-100);
        border-radius: 16px;
        padding: 1rem 1.1rem 1.1rem 1.3rem;
        animation: kwCardIn .3s ease both;
        transition: border-color .2s, box-shadow .2s;
        flex-shrink: 0;
    }

    .kw-card:hover { border-color: var(--pink-200); box-shadow: 0 8px 22px rgba(232,23,93,.08); }

    .kw-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; bottom: 0;
        width: 4px;
        background: var(--gradient-pink);
    }

    @keyframes kwCardIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .kw-card-label-row {
        display: flex; align-items: center; gap: .4rem;
        margin-bottom: .5rem;
    }

    .kw-card-label {
        font-size: .65rem; font-weight: 800; color: var(--bright-pink);
        text-transform: uppercase; letter-spacing: .07em;
    }

    .kw-card-snippet {
        font-size: .85rem;
        color: var(--ink);
        line-height: 1.55;
        background: var(--blush);
        border-radius: 10px;
        padding: .65rem .8rem;
        margin-bottom: .8rem;
        font-style: italic;
    }

    .kw-word-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        margin-bottom: .7rem;
    }

    .kw-word {
        display: inline-flex;
        padding: .3rem .65rem;
        border-radius: 999px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink);
        cursor: pointer;
        transition: .15s;
        user-select: none;
    }

    .kw-word:hover { border-color: var(--bright-pink); transform: translateY(-1px); }

    .kw-word.selected {
        background: var(--gradient-pink);
        color: var(--white);
        border-color: transparent;
        box-shadow: 0 4px 10px rgba(232,23,93,.3);
    }

    .kw-phrase-preview {
        display: flex;
        align-items: center;
        gap: .55rem;
        background: #fff5f9;
        border: 1.5px dashed var(--pink-200);
        border-radius: 10px;
        padding: .5rem .7rem;
        margin-bottom: .8rem;
    }

    .kw-phrase-preview-label {
        font-size: .67rem; font-weight: 800; color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .05em;
        flex-shrink: 0;
    }

    .kw-phrase-input {
        flex: 1;
        padding: .35rem .1rem;
        border: none;
        background: transparent;
        font-size: .85rem;
        font-weight: 700;
        color: var(--ink);
        outline: none;
        font-family: var(--ff-body);
        min-width: 0;
    }

    .kw-field-label {
        font-size: .67rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .04em;
        margin-bottom: .25rem;
        display: block;
    }

    .kw-card-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem;
        margin-bottom: .7rem;
    }

    .kw-card-row select {
        width: 100%;
        padding: .5rem .7rem;
        border-radius: 9px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink);
        outline: none;
        box-sizing: border-box;
        font-family: var(--ff-body);
        cursor: pointer;
        transition: border-color .2s;
    }

    .kw-card-row select:focus { border-color: var(--bright-pink); }

    .kw-checkbox-row {
        display: flex;
        align-items: center;
        gap: .45rem;
        font-size: .77rem;
        color: var(--ink-muted);
        margin-bottom: .8rem;
        font-weight: 600;
    }

    .kw-checkbox-row input { accent-color: var(--bright-pink); cursor: pointer; }

    .kw-card-actions {
        display: flex;
        gap: .5rem;
        justify-content: flex-end;
    }

    .kw-btn-ignore {
        padding: .45rem .9rem;
        border-radius: 9px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        color: var(--ink-muted);
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        transition: .2s;
    }

    .kw-btn-ignore:hover { border-color: #e04867; color: #e04867; background: #fff0f0; }

    .kw-btn-save {
        padding: .45rem 1rem;
        border-radius: 9px;
        border: none;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        box-shadow: 0 5px 14px rgba(232,23,93,.25);
        transition: transform .15s, box-shadow .15s;
    }

    .kw-btn-save:hover { transform: translateY(-1px); box-shadow: 0 8px 18px rgba(232,23,93,.35); }

    .kw-trained-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .8rem;
        background: var(--white);
        border: 1.5px solid var(--pink-100);
        border-radius: 14px;
        padding: .75rem .95rem;
        animation: kwCardIn .3s ease both;
        transition: border-color .2s, transform .2s;
    }

    .kw-trained-card:hover { border-color: var(--pink-200); transform: translateX(2px); }

    .kw-trained-left { display: flex; flex-direction: column; gap: .25rem; min-width: 0; }
    .kw-trained-phrase {
        font-size: .87rem; font-weight: 700; color: var(--ink);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .kw-trained-meta { display: flex; align-items: center; gap: .4rem; }

    .kw-trained-audit {
        font-size: .68rem;
        color: var(--ink-muted);
        font-weight: 600;
        margin-top: .25rem;
    }

    .kw-validation-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .6rem;
        margin: .3rem 0 .7rem;
        min-height: 16px;
    }

    .kw-char-counter {
        font-size: .68rem;
        font-weight: 600;
        color: var(--ink-muted);
        flex-shrink: 0;
    }

    .kw-validation-msg {
        font-size: .72rem;
        font-weight: 600;
        color: #1a9d6e;
        text-align: right;
    }

    .kw-validation-msg.error { color: #c0303a; }

    .kw-btn-save:disabled {
        opacity: .45;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .kw-type-pill {
        font-size: .67rem; font-weight: 800; padding: .15rem .55rem;
        border-radius: 999px; background: var(--pink-100); color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .03em;
    }

    .kw-urgency-pill {
        font-size: .67rem; font-weight: 800; padding: .15rem .55rem;
        border-radius: 999px; text-transform: uppercase; letter-spacing: .03em;
    }

    .kw-urgency-pill.critical { background: #fff0f0; color: #c0303a; }
    .kw-urgency-pill.urgent { background: #fff8e1; color: #c07800; }
    .kw-urgency-pill.moderate { background: #eef2ff; color: #4f6ef7; }

    .kw-trained-actions { display: flex; gap: .35rem; flex-shrink: 0; }

    .kw-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
    }

    .kw-empty-icon {
        width: 40px; height: 40px;
        margin: 0 auto .8rem;
        opacity: .25;
        display: block;
    }

    .kw-ref-note {
        display: flex;
        align-items: flex-start;
        gap: .5rem;
        background: #fff9e6;
        border: 1.5px solid #f0c040;
        border-radius: 10px;
        padding: .6rem .8rem;
        font-size: .77rem;
        color: #7a5400;
        line-height: 1.5;
        margin-bottom: .4rem;
    }

    .kw-ref-group {
        background: var(--white);
        border: 1.5px solid var(--pink-100);
        border-radius: 14px;
        padding: .85rem 1rem;
    }

    .kw-ref-group-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .6rem;
    }

    .kw-ref-group-title {
        font-size: .85rem;
        font-weight: 800;
        color: var(--ink);
    }

    .kw-ref-chip-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
    }

    .kw-ref-chip {
        display: inline-flex;
        padding: .28rem .6rem;
        border-radius: 999px;
        background: var(--blush);
        border: 1.5px solid var(--pink-100);
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink-muted);
    }

    .kw-ref-empty-type {
        font-size: .76rem;
        color: var(--ink-muted);
        font-style: italic;
    }

    .kw-add-btn {
        display: none;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: .5rem .9rem;
        border-radius: 10px;
        border: none;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        white-space: nowrap;
        box-shadow: 0 5px 14px rgba(232,23,93,.25);
        flex-shrink: 0;
        transition: transform .15s, box-shadow .15s;
    }

    .kw-add-btn.visible { display: inline-flex; }
    .kw-add-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 18px rgba(232,23,93,.35); }
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
            <button class="btn-directory" onclick="openModal('dir-modal')">
                <img src="{{ asset('icons/emergdir.png') }}" alt="">
                Emergency Directory
            </button>
            <button class="btn-archive-open" onclick="openKeywordModal()">
                <img src="{{ asset('icons/keyword.png') }}" alt="">
                Keyword Training
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
            <div class="stat-icon"><img src="{{ asset('icons/nav-emerg.png') }}" alt=""></div>
            <div>
                <div class="stat-label">Active Emergencies</div>
                <div class="stat-num">{{ $activeCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/warn.png') }}" alt=""></div>
            <div>
                <div class="stat-label">Critical Emergencies</div>
                <div class="stat-num">{{ $criticalCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/resolved.png') }}" alt=""></div>
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
                <div style="display:flex;align-items:center;gap:.45rem;">
                    <div class="search-box">
                        <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                        <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
                    </div>
                    <div class="status-legend-wrap">
                        <img src="{{ asset('icons/info.png') }}" alt="Status guide">
                        <div class="status-legend-popup">
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
            Closed <span class="archive-tab-count" id="acount-closed">0</span>
        </button>
        <button class="archive-tab" id="atab-resolved" onclick="switchArchiveTab('resolved')">
            Resolved <span class="archive-tab-count" id="acount-resolved">0</span>
        </button>
        <button class="archive-tab" id="atab-deleted" onclick="switchArchiveTab('deleted')">
            Deleted <span class="archive-tab-count" id="acount-deleted">0</span>
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
                <img src="{{ asset('icons/export.png') }}" alt="">Export
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
            <div class="modal-title">
                Emergency Directory
            </div>
            <button class="modal-close" onclick="closeModal('dir-modal')">&#x2715;</button>
        </div>

        <div class="dir-tabs" id="dir-tabs">
            <button class="dir-tab active" onclick="switchDirTab('all', this)">
                All
            </button>
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

        <div class="modal-footer">
            <div class="dir-hint" style="flex:1;margin:0;">
                Tap any number to copy it to your clipboard.
            </div>
            <button class="btn-cancel" onclick="closeModal('dir-modal')">Close</button>
        </div>
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
                                <option value="resolved">Resolve &amp; Archive</option>
                                <option value="closed">Close &amp; Archive</option>
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
                <div class="modal-section-title">Admin Notes</div>
                <div class="modal-field">
                    <textarea id="edit-notes" placeholder="Add notes or action taken..."></textarea>
                </div>
            </div>
            <div class="modal-warn-banner">
                <span style="font-size:.95rem;flex-shrink:0;"></span>
                <span>Setting status to <strong>Closed</strong> will move this report to the closed archive.</span>
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
            <p style="font-size:.88rem;color:var(--ink-muted);margin:0;">
                Delete report for <strong id="delete-label" style="color:var(--ink);"></strong>?
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <button type="button" class="btn-submit" style="background:#e04867;box-shadow:0 6px 16px rgba(224,72,103,.3);" onclick="submitDelete()">Delete</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="keyword-modal" onclick="handleOverlayClick(event, 'keyword-modal')">
    <div class="modal dir-modal" style="max-width:620px;">
        <div class="modal-header">
            <div class="kw-modal-header-row">
                <div class="kw-modal-icon-badge">
                    <img src="{{ asset('icons/keyword.png') }}" alt="">
                </div>
                <div class="kw-modal-title-block">
                    <div class="modal-title">Keyword Training</div>
                    <div class="kw-modal-sub">Teach the system to recognize unmatched reports</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:.5rem;">
                <div class="kw-help-wrap" id="kw-help-trigger">?</div>
                <button class="modal-close" onclick="closeModal('keyword-modal')">&#x2715;</button>
            </div>
        </div>
        <div class="kw-segmented">
            <button class="kw-tab active" id="kwtab-pending" onclick="switchKwTab('pending')">
                Pending <span class="kw-tab-count" id="kwcount-pending">0</span>
            </button>
            <button class="kw-tab" id="kwtab-trained" onclick="switchKwTab('trained')">
                Trained <span class="kw-tab-count" id="kwcount-trained">0</span>
            </button>
            <button class="kw-tab" id="kwtab-reference" onclick="switchKwTab('reference')">
                Built-in Rules <span class="kw-tab-count" id="kwcount-reference">0</span>
            </button>
        </div>
        <div class="kw-summary-bar" id="kw-summary-bar"></div>
        <div class="kw-search-bar" style="display:flex;gap:.5rem;">
            <div class="kw-search-inner" style="flex:1;">
                <img src="{{ asset('icons/search.png') }}" class="kw-search-icon" alt="">
                <input type="text" id="kw-search" placeholder="Search..." oninput="renderKwList()">
            </div>
            <button class="kw-add-btn" id="kw-add-btn" onclick="showAddKeywordForm()">+ Add Keyword</button>
        </div>
        <div id="kw-add-form-wrap" style="padding:0 1.1rem;flex-shrink:0;"></div>
        <div class="kw-list" id="kw-list"></div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('keyword-modal')">Close</button>
        </div>
    </div>
</div>

<div class="kw-help-popup" id="kw-help-popup">
    <div class="kw-help-popup-title">How Keyword Training Works</div>
    <div class="kw-help-step"><span class="kw-help-step-num">1</span><span>Reports that miss every known keyword land in <strong>Pending</strong>.</span></div>
    <div class="kw-help-step"><span class="kw-help-step-num">2</span><span>Tap words in the snippet to build the exact phrase, then assign a type.</span></div>
    <div class="kw-help-step"><span class="kw-help-step-num">3</span><span>Saved phrases appear in <strong>Trained</strong>, editable or removable anytime.</span></div>
    <div class="kw-help-step"><span class="kw-help-step-num">4</span><span><strong>Built-in Rules</strong> shows the system defaults for reference only.</span></div>
</div>

@endsection

@section('scripts')
<script>
    const reports          = @json($reports);
    const closedArchive    = @json($closedArchive);
    const resolvedArchive  = @json($resolvedArchive);
    const deletedArchive   = @json($deletedArchive);
    let pendingTerms       = @json($pendingTerms);
    let trainedKeywords    = @json($trainedKeywords);
    const hardcodedRules   = @json($hardcodedRules);
    const PER_PAGE = 8;
    let currentPage = 1;
    let filtered    = [...reports];
    let currentRep  = null;
    let deleteId    = null;
    let archiveTab  = 'closed';

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    function handleOverlayClick(event, id) { if (event.target === event.currentTarget) closeModal(id); }

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    const normalizeFilterValue = value => String(value ?? '').trim().toLowerCase();

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

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    function handleOverlayClick(event, id) { if (event.target === event.currentTarget) closeModal(id); }

    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    function updateEditStatusDot(sel) {
        var dot = document.getElementById('edit-status-dot');
        if (!dot) return;
        var colors = { active: 'var(--bright-pink)', resolved: '#1a9d6e', closed: '#616161' };
        dot.style.background = colors[sel.value] || '#ccc';
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

    function fmtDateShort(d) {
        if (!d) return '—';
        const dt = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date}<br><span style="font-size:.75rem;color:var(--ink-muted);font-weight:400;">${time}</span>`;
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

    function populateTypeFilter() {
        const select = document.getElementById('type-filter');
        const types = [...new Set(
            reports.map(r => String(r.emergency_type ?? '').trim()).filter(t => t && t !== '—')
        )].sort((a, b) => a.localeCompare(b));
        select.innerHTML = '<option value="">All Types</option>' +
            types.map(t => `<option value="${escHtml(t)}">${escHtml(t)}</option>`).join('');
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('em-tbody');

        if (pageData.length === 0) {
            const hasFilters = document.getElementById('search-input').value
                || document.getElementById('status-filter').value
                || document.getElementById('type-filter').value
                || document.getElementById('urgency-filter').value
                || document.getElementById('date-from').value
                || document.getElementById('date-to').value;
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

        const dateFromEl = document.getElementById('date-from');
        const dateToEl   = document.getElementById('date-to');
        if (from && to && from > to) {
            dateToEl.style.borderColor = '#e04867';
            dateFromEl.style.borderColor = '#e04867';
            return;
        } else {
            dateFromEl.style.borderColor = '';
            dateToEl.style.borderColor = '';
        }

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
            ${buildSuggestedHotlines(r.emergency_type, r.urgency_level, r.is_panic_alert)}
            <div class="modal-section-title" style="margin-top:${r.is_panic_alert || (r.urgency_level && r.urgency_level !== 'moderate') ? '.1rem' : '0'};">Report Information</div>
            <div class="view-detail-grid">
                <div class="view-detail-item">
                    <div class="vdi-label">Emergency Type</div>
                    <div class="vdi-val">${escHtml(r.emergency_type)}</div>
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
                    <div class="vdi-val">${escHtml(r.location)}</div>
                </div>
                <div class="view-detail-item">
                    <div class="vdi-label">Reported By</div>
                    <div class="vdi-val">${escHtml(r.tenant_name)}${r.room_number && r.room_number !== '—' ? '<span class="muted" style="font-size:.78rem;color:var(--ink-muted);"> · Room ' + escHtml(String(r.room_number)) + '</span>' : ''}</div>
                </div>
                <div class="view-detail-item">
                    <div class="vdi-label">Date Reported</div>
                    <div class="vdi-val muted">${fmtDate(r.reported_at)}</div>
                </div>
                ${r.resolved_at ? `
                <div class="view-detail-item">
                    <div class="vdi-label">Date Resolved</div>
                    <div class="vdi-val muted">${fmtDate(r.resolved_at)}</div>
                </div>` : ''}
                <div class="view-detail-item full">
                    <div class="vdi-label">Description</div>
                    <div class="vdi-val" style="white-space:pre-wrap;">${escHtml(r.description)}</div>
                </div>
                ${r.admin_notes ? `
                <div class="view-detail-item full">
                    <div class="vdi-label">Admin Notes</div>
                    <div class="vdi-val" style="white-space:pre-wrap;">${escHtml(r.admin_notes)}</div>
                </div>` : ''}
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

    async function submitUpdate() {
        if (!currentRep) return;
        const btn = document.querySelector('#edit-modal .btn-submit');
        btn.disabled = true; btn.textContent = 'Saving...';
        showActionLoading('Updating report...');
        try {
            const res = await fetch(`/emergency/${currentRep.report_id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
        } finally {
            hideActionLoading();
            btn.disabled = false;
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
        btn.disabled = true; btn.textContent = 'Deleting...';
        showActionLoading('Deleting report...');
        try {
            const res = await fetch(`/emergency/${deleteId}`, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
        } finally {
            hideActionLoading();
            btn.disabled = false;
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
        const fa   = data.filter(r =>
            normalizeFilterValue(r.emergency_type).includes(q) ||
            normalizeFilterValue(r.urgency_level).includes(q) ||
            normalizeFilterValue(r.location).includes(q) ||
            normalizeFilterValue(r.tenant_name).includes(q) ||
            normalizeFilterValue(r.room_number).includes(q) ||
            normalizeFilterValue(r.description).includes(q) ||
            normalizeFilterValue(r.status).includes(q)
        );

        document.getElementById('archive-count-label').textContent =
            `${fa.length} record${fa.length !== 1 ? 's' : ''}`;

        if (fa.length === 0) {
            list.innerHTML = `<div class="archive-empty"><img class="archive-empty-icon" src="{{ asset('icons/nav-emerg.png') }}" alt="">No ${archiveTab === 'resolved' ? 'resolved' : archiveTab} emergency reports found.</div>`;
            return;
        }

        const urgCls = { critical:'archive-pill-critical', urgent:'archive-pill-urgent', moderate:'archive-pill-moderate' };
        const archiveLabel = archiveTab === 'closed' ? 'Closed on' : archiveTab === 'resolved' ? 'Resolved on' : 'Deleted on';
        const byLabel      = archiveTab === 'closed' ? 'Closed by' : archiveTab === 'resolved' ? 'Resolved by' : 'Deleted by';

        list.innerHTML = fa.map((r, i) => `
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
                    <span class="archive-pill ${urgCls[normalizeFilterValue(r.urgency_level)] ?? 'archive-pill-moderate'}">${escHtml(r.urgency_level ?? 'moderate')}</span>
                    ${r.is_panic_alert ? '<span class="archive-pill archive-pill-critical">Panic</span>' : ''}
                </div>
                ${r.description ? `<div class="archive-card-desc">${escHtml(r.description)}</div>` : ''}
                <div class="archive-card-archived">${archiveLabel}: <span>${fmtDatePlain(r.archived_at)}</span></div>
                <div class="archive-card-archived">${byLabel}: <span>${escHtml(r.archived_by_label ?? 'Unknown')}</span></div>
            </div>
        `).join('');
    }

    const baseUrl = '{{ asset("icons") }}/';

    const DIR_DATA = [
        { name: 'National Emergency Hotline', numbers: ['911'], category: 'general', icon: baseUrl + 'phone.png', tags: ['general','panic','emergency'] },
        { name: 'Philippine National Police (PNP)', numbers: ['117', '(02) 8722-0650'], category: 'police', icon: baseUrl + 'police.png', tags: ['crime','theft','assault','violence','intruder','security'] },
        { name: 'Manila Police District', numbers: ['0919-995-0976', '0917-899-2092'], category: 'police', icon: baseUrl + 'police.png', tags: ['crime','theft','assault','violence','intruder','security'] },
        { name: 'PNP Text Hotline', numbers: ['0917-847-5757'], category: 'police', icon: baseUrl + 'police.png', tags: ['crime','security'] },
        { name: 'Bureau of Fire Protection (NCR)', numbers: ['(02) 8426-0219', '(02) 8426-0246'], category: 'fire', icon: baseUrl + 'fire.png', tags: ['fire','smoke','burning','flames'] },
        { name: 'University of Santo Tomas Hospital', numbers: ['(02) 8731-3001'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','unconscious','seizure','health'] },
        { name: 'Ospital ng Sampaloc', numbers: ['(02) 8749-0207', '0915-069-4087'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','health'] },
        { name: 'Chinese General Hospital', numbers: ['(02) 8711-4141'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','health'] },
        { name: 'Jose R. Reyes Memorial Medical Center', numbers: ['(02) 8711-9491'], category: 'medical', icon: baseUrl + 'hospital.png', tags: ['medical','injury','accident','health'] },
        { name: 'Philippine Red Cross', numbers: ['143', '(02) 8790-2300'], category: 'redcross', icon: baseUrl + 'redcross.png', tags: ['medical','injury','disaster','flood','fire','emergency'] },
    ];

    const CATEGORY_LABELS = {
        general: 'National Emergency',
        police: 'Police',
        fire: 'Fire',
        medical: 'Medical',
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
                    <div class="dir-card-icon">
                        <img src="${d.icon}" alt="">
                    </div>
                    <div class="dir-card-name">${escHtml(d.name)}</div>
                </div>
                <div class="dir-card-numbers">
                    ${d.numbers.map(n => `
                        <div class="dir-number-chip" onclick="copyHotline('${n.replace(/[^0-9+]/g, '')}', this)">${escHtml(n)}</div>
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
                    ${escHtml(h.name.length > 26 ? h.name.slice(0,26)+'…' : h.name)}
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

    function exportTable(format) {
        if (format === 'pdf') {
            const win  = window.open('', '_blank');
            const rows = filtered.map(r =>
                `<tr><td>${escHtml(r.emergency_type||'')}</td><td>${escHtml(r.urgency_level||'')}</td><td>${escHtml(r.location||'')}</td><td>${fmtDatePlain(r.reported_at)}</td><td>${escHtml(r.tenant_name||'')}</td><td>${r.room_number && r.room_number!=='—'?escHtml(String(r.room_number)):''}</td><td>${escHtml(r.status||'')}</td><td>${escHtml(r.description||'')}</td></tr>`
            ).join('');
            win.document.write(`<!DOCTYPE html><html><head><title>Emergency Reports</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style></head><body><h2>Sanctissimo Rosario Ladies Dormitory</h2><p>Emergency Reports as of ${new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})}</p><table><thead><tr><th>Type</th><th>Urgency</th><th>Location</th><th>Date Reported</th><th>Staff / Tenant</th><th>Room</th><th>Status</th><th>Description</th></tr></thead><tbody>${rows}</tbody></table></body></html>`);
            win.document.close(); win.print(); return;
        }
        const rows = [['Report ID','Reported At','Type','Urgency','Location','Staff / Tenant','Room','Status','Description']];
        filtered.forEach(r => rows.push([
            '#EM-'+String(r.report_id).padStart(3,'0'), fmtDatePlain(r.reported_at),
            r.emergency_type||'', r.urgency_level||'', r.location||'',
            r.tenant_name||'', r.room_number||'', r.status||'', r.description||'',
        ]));
        const csv = rows.map(r => r.map(c => '"'+String(c).replace(/"/g,'""')+'"').join(',')).join('\n');
        const a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv],{type:'text/csv;charset=utf-8;'}));
        a.download = 'emergency_reports.csv'; a.click(); URL.revokeObjectURL(a.href);
    }

    function exportArchive(format) {
        const data  = archiveTab === 'closed' ? closedArchive : archiveTab === 'resolved' ? resolvedArchive : deletedArchive;
        const label = archiveTab === 'closed' ? 'Closed On' : archiveTab === 'resolved' ? 'Resolved On' : 'Deleted On';
        const byLbl = archiveTab === 'closed' ? 'Closed By' : archiveTab === 'resolved' ? 'Resolved By' : 'Deleted By';
        if (format === 'pdf') {
            const win  = window.open('', '_blank');
            const tLbl = archiveTab === 'closed' ? 'Closed' : archiveTab === 'resolved' ? 'Resolved' : 'Deleted';
            const rows = data.map(r =>
                `<tr><td>#EM-${String(r.id).padStart(3,'0')}</td><td>${escHtml(r.emergency_type||'')}</td><td>${escHtml(r.urgency_level||'')}</td><td>${escHtml(r.location||'')}</td><td>${escHtml(r.tenant_name||'')}</td><td>${escHtml(r.status||'')}</td><td>${fmtDatePlain(r.archived_at)}</td><td>${escHtml(r.archived_by_label||'')}</td></tr>`
            ).join('');
            win.document.write(`<!DOCTYPE html><html><head><title>Archive - ${tLbl}</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style></head><body><h2>Emergency Archive - ${tLbl}</h2><p>Sanctissimo Rosario Ladies Dormitory &mdash; exported ${new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})}</p><table><thead><tr><th>Report ID</th><th>Type</th><th>Urgency</th><th>Location</th><th>Staff / Tenant</th><th>Status</th><th>${label}</th><th>${byLbl}</th></tr></thead><tbody>${rows}</tbody></table></body></html>`);
            win.document.close(); win.print(); return;
        }
        const rows = [['Report ID','Reported At','Type','Urgency','Location','Staff / Tenant','Room','Status','Description',label,byLbl]];
        data.forEach(r => rows.push([
            '#EM-'+String(r.id).padStart(3,'0'), fmtDatePlain(r.reported_at),
            r.emergency_type||'', r.urgency_level||'', r.location||'',
            r.tenant_name||'', r.room_number||'', r.status||'', r.description||'',
            fmtDatePlain(r.archived_at), r.archived_by_label||'',
        ]));
        const csv = rows.map(r => r.map(c => '"'+String(c).replace(/"/g,'""')+'"').join(',')).join('\n');
        const a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv],{type:'text/csv;charset=utf-8;'}));
        a.download = `emergency_${archiveTab}_archive.csv`;
        a.click();
        URL.revokeObjectURL(a.href);
    }

    function getMenuForDropdown(id) {
        return Array.from(document.querySelectorAll('.export-menu')).find(m => m._sourceDropdownId === id)
            || document.querySelector('#' + id + ' .export-menu');
    }

    function positionExportMenu(dropdown) {
        const btn  = dropdown.querySelector('button');
        const menu = getMenuForDropdown(dropdown.id);
        const rect = btn.getBoundingClientRect();
        if (!menu._movedToBody) { menu._sourceDropdownId = dropdown.id; document.body.appendChild(menu); menu._movedToBody = true; }
        menu.style.position = 'fixed'; menu.style.zIndex = '99999';
        menu.style.right = (window.innerWidth - rect.right) + 'px';
        menu.style.left = 'auto'; menu.style.minWidth = rect.width + 'px';
        menu.style.top = 'auto'; menu.style.bottom = 'auto';
        const menuHeight = menu.offsetHeight || 80;
        const spaceBelow = window.innerHeight - rect.bottom;
        if (spaceBelow >= menuHeight + 6) { menu.style.top = (rect.bottom + 6) + 'px'; menu.style.bottom = 'auto'; }
        else { menu.style.bottom = (window.innerHeight - rect.top + 6) + 'px'; menu.style.top = 'auto'; }
    }

    function toggleExportDropdown(id) {
        const dropdown = document.getElementById(id);
        const menu     = getMenuForDropdown(id);
        const isOpen   = menu.classList.contains('open');
        closeAllExportDropdowns();
        if (!isOpen) { positionExportMenu(dropdown); getMenuForDropdown(id).classList.add('open'); }
    }

    function closeAllExportDropdowns() {
        document.querySelectorAll('.export-menu').forEach(m => m.classList.remove('open'));
    }

    document.addEventListener('click', e => {
        if (!e.target.closest('.export-dropdown')) closeAllExportDropdowns();
    });

    (function() {
        var popup = document.querySelector('.status-legend-popup');
        if (!popup) return;

        document.body.appendChild(popup);
        popup.style.display = 'none';
        popup.style.position = 'fixed';
        popup.style.zIndex = '9999';

        var hideTimer = null;

        document.querySelectorAll('.status-legend-wrap').forEach(function(wrap) {
            wrap.addEventListener('mouseenter', function() {
                clearTimeout(hideTimer);
                var rect = wrap.getBoundingClientRect();
                var popupWidth = 320;
                var left = rect.left;
                if (left + popupWidth > window.innerWidth - 12) {
                    left = window.innerWidth - popupWidth - 12;
                }
                popup.style.top = (rect.bottom + 8) + 'px';
                popup.style.left = left + 'px';
                popup.style.display = 'block';
            });

            wrap.addEventListener('mouseleave', function() {
                hideTimer = setTimeout(function() {
                    popup.style.display = 'none';
                }, 150);
            });
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
        document.getElementById('urgency-filter').value = '';
        document.getElementById('urgency-filter').value = '';
        document.getElementById('sort-select').value = 'newest';
        document.getElementById('date-from').value = '';
        document.getElementById('date-to').value = '';
        applyFilters();
    }

    populateTypeFilter();
    applyFilters();
    renderDirList();

    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif

    (function() {
        var lastPanicId = null;
        function checkPanic() {
            fetch('{{ url("/emergency/poll/panic") }}', { headers: { 'Accept': 'application/json' } })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.has_panic && data.report_id !== lastPanicId) {
                        lastPanicId = data.report_id;
                        showToast('PANIC ALERT: ' + (data.type || 'Emergency') + ' at ' + (data.location || 'unknown'), 'error');
                    }
                })
                .catch(function() {});
        }
        setInterval(checkPanic, 30000);
    })();

    const kwEditIcon = "{{ asset('icons/edit.png') }}";
    const kwDeleteIcon = "{{ asset('icons/delete.png') }}";
    const kwEmptyIcon = "{{ asset('icons/nav-emerg.png') }}";
    const EMERGENCY_TYPE_OPTIONS = ['Medical', 'Fire/Smoke', 'Electrical Hazard', 'Security', 'Flood/Water Leak', 'Other'];
    let kwActiveTab = 'pending';
    const kwPhraseState = {};

    (function() {
        var popup = document.getElementById('kw-help-popup');
        var trigger = document.getElementById('kw-help-trigger');
        if (!popup || !trigger) return;
        document.body.appendChild(popup);
        popup.style.position = 'fixed';
        popup.style.zIndex = '9999';
        var hideTimer = null;
        function show() {
            clearTimeout(hideTimer);
            var rect = trigger.getBoundingClientRect();
            var width = 280;
            var centerX = rect.left + rect.width / 2;
            var left = centerX - width / 2;
            if (left < 12) left = 12;
            if (left + width > window.innerWidth - 12) left = window.innerWidth - width - 12;
            var arrowLeft = centerX - left - 6;
            popup.style.setProperty('--kw-arrow-left', arrowLeft + 'px');
            popup.style.top = (rect.bottom + 12) + 'px';
            popup.style.left = left + 'px';
            popup.style.display = 'block';
        }
        function hide() {
            hideTimer = setTimeout(function() { popup.style.display = 'none'; }, 150);
        }
        trigger.addEventListener('mouseenter', show);
        trigger.addEventListener('mouseleave', hide);
        trigger.addEventListener('click', show);
        popup.addEventListener('mouseenter', function() { clearTimeout(hideTimer); });
        popup.addEventListener('mouseleave', hide);
    })();

    function typeOptionsHtml(selected) {
        return EMERGENCY_TYPE_OPTIONS.map(function(t) {
            return '<option value="' + escHtml(t) + '"' + (t === selected ? ' selected' : '') + '>' + escHtml(t) + '</option>';
        }).join('');
    }

    function urgencyOptionsHtml(selected) {
        const opts = [['', 'Use type default'], ['moderate', 'Moderate'], ['urgent', 'Urgent'], ['critical', 'Critical']];
        return opts.map(function(o) {
            return '<option value="' + o[0] + '"' + (o[0] === (selected || '') ? ' selected' : '') + '>' + o[1] + '</option>';
        }).join('');
    }

    function openKeywordModal() {
        kwActiveTab = 'pending';
        document.getElementById('kwtab-pending').classList.add('active');
        document.getElementById('kwtab-trained').classList.remove('active');
        document.getElementById('kwtab-reference').classList.remove('active');
        document.getElementById('kw-add-btn').classList.remove('visible');
        document.getElementById('kw-search').value = '';
        document.getElementById('kw-search').placeholder = 'Search pending snippets...';
        renderKwList();
        openModal('keyword-modal');
    }

    function switchKwTab(tab) {
        kwActiveTab = tab;
        document.getElementById('kwtab-pending').classList.toggle('active', tab === 'pending');
        document.getElementById('kwtab-trained').classList.toggle('active', tab === 'trained');
        document.getElementById('kwtab-reference').classList.toggle('active', tab === 'reference');
        document.getElementById('kw-add-btn').classList.toggle('visible', tab === 'trained');
        document.getElementById('kw-add-form-wrap').innerHTML = '';
        document.getElementById('kw-search').value = '';
        const placeholders = { pending: 'Search pending snippets...', trained: 'Search trained keywords...', reference: 'Search built-in rules...' };
        document.getElementById('kw-search').placeholder = placeholders[tab];
        renderKwList();
    }

    function renderKwList() {
        document.getElementById('kwcount-pending').textContent = pendingTerms.length;
        document.getElementById('kwcount-trained').textContent = trainedKeywords.length;
        const refCount = Object.values(hardcodedRules.emergency_rules || {}).reduce(function(sum, rule) {
            return sum + (rule.keywords ? rule.keywords.length : 0);
        }, 0);
        document.getElementById('kwcount-reference').textContent = refCount;
        const totalCount = refCount + trainedKeywords.length;
        document.getElementById('kw-summary-bar').innerHTML =
            '<strong>' + refCount + '</strong> built-in + <strong>' + trainedKeywords.length + '</strong> trained = <strong>' + totalCount + '</strong> active keyword rules';
        if (kwActiveTab === 'pending') {
            renderPendingTerms();
        } else if (kwActiveTab === 'trained') {
            renderTrainedKeywords();
        } else {
            renderHardcodedReference();
        }
    }

    function renderHardcodedReference() {
        const list = document.getElementById('kw-list');
        const q = normalizeFilterValue(document.getElementById('kw-search').value);
        const rules = hardcodedRules.emergency_rules || {};
        const types = Object.keys(rules).filter(function(t) { return t !== 'Other'; });

        const groupsHtml = types.map(function(type) {
            const rule = rules[type];
            const keywords = (rule.keywords || []).filter(function(k) {
                return !q || k.toLowerCase().includes(q) || type.toLowerCase().includes(q);
            });
            if (q && keywords.length === 0) return '';
            const chips = keywords.length > 0
                ? keywords.map(function(k) { return '<span class="kw-ref-chip">' + escHtml(k) + '</span>'; }).join('')
                : '<span class="kw-ref-empty-type">No keywords defined</span>';
            return '' +
                '<div class="kw-ref-group">' +
                '<div class="kw-ref-group-title-row">' +
                '<span class="kw-ref-group-title">' + escHtml(type) + '</span>' +
                '<span class="kw-urgency-pill ' + escHtml(rule.urgency || 'moderate') + '">' + escHtml(rule.urgency || 'moderate') + '</span>' +
                '</div>' +
                '<div class="kw-ref-chip-wrap">' + chips + '</div>' +
                '</div>';
        }).filter(Boolean).join('');

        if (!groupsHtml) {
            list.innerHTML = '<div class="kw-empty">No built-in keywords match your search.</div>';
            return;
        }

        list.innerHTML = '' +
            '<div class="kw-ref-note">These are hardcoded in the system and cannot be edited or removed here. They take priority when no trained keyword matches the same phrase. Use the Add Keyword button on the Trained tab to set a different rule for a specific phrase.</div>' +
            groupsHtml;
    }

    function renderPendingTerms() {
        const list = document.getElementById('kw-list');
        const q = normalizeFilterValue(document.getElementById('kw-search').value);
        const visible = pendingTerms.filter(function(t) {
            return !q || normalizeFilterValue(t.description_snapshot).includes(q);
        });
        if (visible.length === 0) {
            list.innerHTML = pendingTerms.length === 0
                ? '<div class="kw-empty"><img class="kw-empty-icon" src="' + kwEmptyIcon + '" alt="">No pending snippets to classify.</div>'
                : '<div class="kw-empty">No pending snippets match your search.</div>';
            return;
        }
        list.innerHTML = visible.map(function(term) {
            const words = (term.description_snapshot || '').split(/\s+/).filter(Boolean);
            if (!kwPhraseState[term.id]) {
                kwPhraseState[term.id] = [];
            }
            const wordSpans = words.map(function(w, i) {
                const selected = kwPhraseState[term.id].some(function(s) { return s.index === i; });
                return '<span class="kw-word' + (selected ? ' selected' : '') + '" onclick="toggleKwWord(' + term.id + ', ' + i + ', \'' + escHtml(w).replace(/'/g, "\\'") + '\')">' + escHtml(w) + '</span>';
            }).join('');
            return '' +
                '<div class="kw-card" id="kw-card-' + term.id + '">' +
                '<div class="kw-card-label-row"><span class="kw-card-label">Unclassified snippet</span></div>' +
                '<div class="kw-card-snippet">' + escHtml(term.description_snapshot || '') + '</div>' +
                '<span class="kw-field-label">Tap words to build the phrase</span>' +
                '<div class="kw-word-wrap">' + wordSpans + '</div>' +
                '<div class="kw-phrase-preview">' +
                '<span class="kw-phrase-preview-label">Phrase</span>' +
                '<input type="text" class="kw-phrase-input" id="kw-phrase-' + term.id + '" placeholder="Selected phrase" value="' + escHtml(buildKwPhrase(term.id)) + '" oninput="validateKwPhraseInput(\'kw-phrase-' + term.id + '\', \'kw-counter-' + term.id + '\', \'kw-msg-' + term.id + '\', \'#kw-card-' + term.id + ' .kw-btn-save\', null)">' +
                '</div>' +
                '<div class="kw-validation-row"><span class="kw-char-counter" id="kw-counter-' + term.id + '">' + buildKwPhrase(term.id).length + '/255</span><span class="kw-validation-msg" id="kw-msg-' + term.id + '"></span></div>' +
                '<div class="kw-card-row">' +
                '<div><span class="kw-field-label">Emergency type</span><select id="kw-type-' + term.id + '">' + typeOptionsHtml('Other') + '</select></div>' +
                '<div><span class="kw-field-label">Urgency override</span><select id="kw-urgency-' + term.id + '">' + urgencyOptionsHtml('') + '</select></div>' +
                '</div>' +
                '<label class="kw-checkbox-row"><input type="checkbox" id="kw-reclassify-' + term.id + '"> Also reclassify matching past reports still marked Other</label>' +
                '<div class="kw-card-actions">' +
                '<button class="kw-btn-ignore" onclick="ignoreKwTerm(' + term.id + ')">Ignore</button>' +
                '<button class="kw-btn-save" onclick="submitKwClassify(' + term.id + ')">Save Keyword</button>' +
                '</div>' +
                '</div>';
        }).join('');

        visible.forEach(function(term) {
            validateKwPhraseInput('kw-phrase-' + term.id, 'kw-counter-' + term.id, 'kw-msg-' + term.id, '#kw-card-' + term.id + ' .kw-btn-save', null);
        });
    }

    function buildKwPhrase(termId) {
        const sel = kwPhraseState[termId] || [];
        return sel.sort(function(a, b) { return a.index - b.index; }).map(function(s) { return s.word; }).join(' ');
    }

    function toggleKwWord(termId, index, word) {
        if (!kwPhraseState[termId]) kwPhraseState[termId] = [];
        const existing = kwPhraseState[termId].findIndex(function(s) { return s.index === index; });
        if (existing >= 0) {
            kwPhraseState[termId].splice(existing, 1);
        } else {
            kwPhraseState[termId].push({ index: index, word: word });
        }
        renderPendingTerms();
    }

    function validateKwPhraseInput(inputId, counterId, msgId, saveBtnSelector, excludeId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const counter = counterId ? document.getElementById(counterId) : null;
        const msg = msgId ? document.getElementById(msgId) : null;
        const saveBtn = saveBtnSelector ? document.querySelector(saveBtnSelector) : null;
        const value = input.value.trim();

        if (counter) counter.textContent = input.value.length + '/255';

        let error = '';
        if (value.length === 0) {
            error = '';
        } else if (value.length < 2) {
            error = 'Phrase must contain at least 2 characters';
        } else if (!/[a-zA-Z0-9]/.test(value)) {
            error = 'Phrase must contain at least one letter or number';
        } else if (trainedKeywords.some(function(k) {
            return k.keyword.toLowerCase() === value.toLowerCase() && k.id !== excludeId;
        })) {
            error = 'This keyword already exists';
        }

        if (msg) {
            msg.textContent = error;
            msg.className = 'kw-validation-msg' + (error ? ' error' : '');
        }
        if (saveBtn) saveBtn.disabled = value.length === 0 || !!error;
    }

    function extractErrorMessage(data, fallback) {
        if (data && data.errors) {
            const firstKey = Object.keys(data.errors)[0];
            if (firstKey && data.errors[firstKey] && data.errors[firstKey][0]) {
                return data.errors[firstKey][0];
            }
        }
        return (data && data.message) ? data.message : fallback;
    }

    async function submitKwClassify(termId) {
        const phraseInput = document.getElementById('kw-phrase-' + termId);
        const keyword = phraseInput.value.trim();
        if (!keyword) {
            showToast('Select or type a phrase first.', 'error');
            return;
        }
        if (keyword.length < 2) {
            showToast('The phrase is too short.', 'error');
            return;
        }
        const saveBtn = document.querySelector('#kw-card-' + termId + ' .kw-btn-save');
        const type = document.getElementById('kw-type-' + termId).value;
        const urgency = document.getElementById('kw-urgency-' + termId).value;
        const reclassify = document.getElementById('kw-reclassify-' + termId).checked;

        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving...'; }
        showActionLoading('Saving keyword...');
        try {
            const res = await fetch('/emergency/terms/' + termId + '/classify', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    keyword: keyword,
                    emergency_type: type,
                    urgency_level: urgency || null,
                    reclassify_matching: reclassify,
                }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Keyword saved' + (data.reclassified_count > 0 ? ' and ' + data.reclassified_count + ' report(s) reclassified' : ''), 'success');
                pendingTerms = pendingTerms.filter(function(t) { return t.id !== termId; });
                delete kwPhraseState[termId];
                trainedKeywords.unshift(data.keyword);
                renderKwList();
            } else {
                showToast(extractErrorMessage(data, 'Failed to save keyword.'), 'error');
                if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Save Keyword'; }
            }
        } catch (err) {
            showToast('Network error: ' + err.message, 'error');
            if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Save Keyword'; }
        } finally {
            hideActionLoading();
        }
    }

    async function ignoreKwTerm(termId) {
        showActionLoading('Ignoring snippet...');
        try {
            const res = await fetch('/emergency/terms/' + termId + '/ignore', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            });
            const data = await res.json();
            if (res.ok && data.success) {
                pendingTerms = pendingTerms.filter(function(t) { return t.id !== termId; });
                delete kwPhraseState[termId];
                renderKwList();
            } else {
                showToast('Failed to ignore snippet.', 'error');
            }
        } catch (err) {
            showToast('Error: ' + err.message, 'error');
        } finally {
            hideActionLoading();
        }
    }

    function renderTrainedKeywords() {
        const list = document.getElementById('kw-list');
        const q = normalizeFilterValue(document.getElementById('kw-search').value);
        const visible = trainedKeywords.filter(function(k) {
            return !q || normalizeFilterValue(k.keyword).includes(q) || normalizeFilterValue(k.emergency_type).includes(q);
        });
        if (visible.length === 0) {
            list.innerHTML = trainedKeywords.length === 0
                ? '<div class="kw-empty"><img class="kw-empty-icon" src="' + kwEmptyIcon + '" alt="">No trained keywords yet.</div>'
                : '<div class="kw-empty">No trained keywords match your search.</div>';
            return;
        }
        list.innerHTML = visible.map(function(kw) {
            const urgencyClass = kw.urgency_level ? kw.urgency_level : '';
            const addedBy = kw.added_by_name || 'Unknown';
            const addedAt = kw.added_at_formatted;
            return '' +
                '<div class="kw-trained-card" id="kw-trained-' + kw.id + '">' +
                '<div class="kw-trained-left">' +
                '<div class="kw-trained-phrase" title="' + escHtml(kw.keyword) + '">' + escHtml(kw.keyword) + '</div>' +
                '<div class="kw-trained-meta">' +
                '<span class="kw-type-pill">' + escHtml(kw.emergency_type) + '</span>' +
                (kw.urgency_level ? '<span class="kw-urgency-pill ' + urgencyClass + '">' + escHtml(kw.urgency_level) + '</span>' : '') +
                '</div>' +
                '<div class="kw-trained-audit">Added by ' + escHtml(addedBy) + (addedAt ? ' on ' + escHtml(addedAt) : '') + '</div>' +
                '</div>' +
                '<div class="kw-trained-actions">' +
                '<button class="act-btn" title="Edit" onclick="editKwKeyword(' + kw.id + ')"><img src="' + kwEditIcon + '" alt="Edit"></button>' +
                '<button class="act-btn danger" title="Delete" onclick="deleteKwKeyword(' + kw.id + ')"><img src="' + kwDeleteIcon + '" alt="Delete"></button>' +
                '</div>' +
                '</div>';
        }).join('');
    }

    function showAddKeywordForm() {
        const wrap = document.getElementById('kw-add-form-wrap');
        wrap.innerHTML = '' +
            '<div class="kw-card" id="kw-add-new" style="margin-bottom:.75rem;">' +
            '<div class="kw-card-label-row"><span class="kw-card-label">New keyword</span></div>' +
            '<span class="kw-field-label">Phrase to match</span>' +
            '<div class="kw-phrase-preview">' +
            '<input type="text" class="kw-phrase-input" id="kw-add-phrase" placeholder="Type the phrase, e.g. amoy gas" oninput="validateKwPhraseInput(\'kw-add-phrase\', \'kw-add-counter\', \'kw-add-msg\', \'#kw-add-new .kw-btn-save\', null)">' +
            '</div>' +
            '<div class="kw-validation-row"><span class="kw-char-counter" id="kw-add-counter">0/255</span><span class="kw-validation-msg" id="kw-add-msg"></span></div>' +
            '<div class="kw-card-row">' +
            '<div><span class="kw-field-label">Emergency type</span><select id="kw-add-type">' + typeOptionsHtml('Other') + '</select></div>' +
            '<div><span class="kw-field-label">Urgency override</span><select id="kw-add-urgency">' + urgencyOptionsHtml('') + '</select></div>' +
            '</div>' +
            '<div class="kw-card-actions">' +
            '<button class="kw-btn-ignore" onclick="cancelAddKeywordForm()">Cancel</button>' +
            '<button class="kw-btn-save" id="kw-add-save-btn" onclick="submitAddKeyword()" disabled>Save Keyword</button>' +
            '</div>' +
            '</div>';
        document.getElementById('kw-add-phrase').focus();
    }

    function cancelAddKeywordForm() {
        document.getElementById('kw-add-form-wrap').innerHTML = '';
    }

    async function submitAddKeyword() {
        const keyword = document.getElementById('kw-add-phrase').value.trim();
        if (!keyword) {
            showToast('Type a phrase first.', 'error');
            return;
        }
        if (keyword.length < 2) {
            showToast('The phrase is too short.', 'error');
            return;
        }
        const saveBtn = document.querySelector('#kw-add-new .kw-btn-save');
        const type = document.getElementById('kw-add-type').value;
        const urgency = document.getElementById('kw-add-urgency').value;

        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving...'; }
        showActionLoading('Saving keyword...');
        try {
            const res = await fetch('/emergency/keywords', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ keyword: keyword, emergency_type: type, urgency_level: urgency || null }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                trainedKeywords.unshift(data.keyword);
                document.getElementById('kw-add-form-wrap').innerHTML = '';
                showToast('Keyword added.', 'success');
                renderKwList();
            } else {
                showToast(extractErrorMessage(data, 'Failed to add keyword.'), 'error');
                if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Save Keyword'; }
            }
        } catch (err) {
            showToast('Network error: ' + err.message, 'error');
            if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Save Keyword'; }
        } finally {
            hideActionLoading();
        }
    }

    function editKwKeyword(id) {
        const kw = trainedKeywords.find(function(k) { return k.id === id; });
        if (!kw) return;
        const card = document.getElementById('kw-trained-' + id);
        card.outerHTML = '' +
            '<div class="kw-card" id="kw-trained-' + id + '">' +
            '<input type="text" class="kw-phrase-input" id="kw-edit-phrase-' + id + '" value="' + escHtml(kw.keyword) + '" oninput="validateKwPhraseInput(\'kw-edit-phrase-' + id + '\', \'kw-edit-counter-' + id + '\', \'kw-edit-msg-' + id + '\', \'#kw-trained-' + id + ' .kw-btn-save\', ' + id + ')">' +
            '<div class="kw-validation-row"><span class="kw-char-counter" id="kw-edit-counter-' + id + '">' + kw.keyword.length + '/255</span><span class="kw-validation-msg" id="kw-edit-msg-' + id + '"></span></div>' +
            '<div class="kw-card-row">' +
            '<select id="kw-edit-type-' + id + '">' + typeOptionsHtml(kw.emergency_type) + '</select>' +
            '<select id="kw-edit-urgency-' + id + '">' + urgencyOptionsHtml(kw.urgency_level) + '</select>' +
            '</div>' +
            '<div class="kw-card-actions">' +
            '<button class="kw-btn-ignore" onclick="renderTrainedKeywords()">Cancel</button>' +
            '<button class="kw-btn-save" onclick="saveKwKeywordEdit(' + id + ')">Save</button>' +
            '</div>' +
            '</div>';
    }

    async function saveKwKeywordEdit(id) {
        const keyword = document.getElementById('kw-edit-phrase-' + id).value.trim();
        const type = document.getElementById('kw-edit-type-' + id).value;
        const urgency = document.getElementById('kw-edit-urgency-' + id).value;
        if (!keyword) {
            showToast('Keyword cannot be empty.', 'error');
            return;
        }
        if (keyword.length < 2) {
            showToast('The phrase is too short.', 'error');
            return;
        }
        const saveBtn = document.querySelector('#kw-trained-' + id + ' .kw-btn-save');
        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving...'; }
        showActionLoading('Updating keyword...');
        try {
            const res = await fetch('/emergency/keywords/' + id, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ keyword: keyword, emergency_type: type, urgency_level: urgency || null }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                const idx = trainedKeywords.findIndex(function(k) { return k.id === id; });
                if (idx >= 0) trainedKeywords[idx] = data.keyword;
                showToast('Keyword updated.', 'success');
                renderTrainedKeywords();
            } else {
                showToast(extractErrorMessage(data, 'Failed to update keyword.'), 'error');
                if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Save'; }
            }
        } catch (err) {
            showToast('Network error: ' + err.message, 'error');
            if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Save'; }
        } finally {
            hideActionLoading();
        }
    }

    async function deleteKwKeyword(id) {
        const kw = trainedKeywords.find(function(k) { return k.id === id; });
        const label = kw ? kw.keyword : 'this keyword';
        if (!window.confirm('Delete trained keyword "' + label + '"? This cannot be undone.')) {
            return;
        }
        showActionLoading('Deleting keyword...');
        try {
            const res = await fetch('/emergency/keywords/' + id, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            });
            const data = await res.json();
            if (res.ok && data.success) {
                trainedKeywords = trainedKeywords.filter(function(k) { return k.id !== id; });
                showToast('Keyword deleted.', 'success');
                renderKwList();
            } else {
                showToast('Failed to delete keyword.', 'error');
            }
        } catch (err) {
            showToast('Error: ' + err.message, 'error');
        } finally {
            hideActionLoading();
        }
    }
</script>
@endsection