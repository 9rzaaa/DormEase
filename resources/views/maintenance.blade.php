@extends('layout')

@section('title', 'DormEase: Maintenance Requests')
@section('page-title', 'Maintenance Requests')

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

    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1.2rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--hot-pink);
        border: 1.5px solid var(--baby-pink);
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }

    .btn-export:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .btn-export img { width: 14px; height: 14px; object-fit: contain; opacity: .6; }
    .btn-export:hover img { opacity: 1; }

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
    }

    .btn-archive-open img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
        width: 56px; height: 56px;
        border-radius: 50%;
        flex-shrink: 0;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,.15);
    }

    .stat-icon img {
        width: 28px; height: 28px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .stat-info { flex: 1; min-width: 0; }
    .stat-num { font-size: 2rem; font-weight: 700; color: var(--white); line-height: 1; }
    .stat-label { font-size: .8rem; color: rgba(247,245,245,.967); font-weight: 700; margin-bottom: .15rem; }

    .toolbar {
        display: flex;
        align-items: center;
        gap: .7rem;
        flex-wrap: wrap;
    }

    .toolbar-label { font-size: .82rem; font-weight: 700; color: var(--ink-muted); }

    .toolbar-select {
        padding: .45rem 1.8rem .45rem .75rem;
        border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        color: var(--ink);
        font-size: .82rem;
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
        box-shadow: 0 2px 8px rgba(232,23,93,.05);
    }

    .toolbar-select:focus { border-color: var(--bright-pink); }

    .date-range {
        display: flex;
        align-items: center;
        gap: .4rem;
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 10px;
        padding: .4rem .75rem;
        font-size: .82rem;
        color: var(--ink-muted);
        font-weight: 600;
    }

    .date-range img { width: 14px; height: 14px; object-fit: contain; opacity: .5; }

    .date-range input[type="date"] {
        border: none; outline: none;
        font-family: var(--ff-body); font-size: .82rem;
        color: var(--ink); background: transparent; cursor: pointer;
    }

    .date-sep { color: var(--ink-muted); font-size: .8rem; }

    .search-wrap { margin-left: auto; position: relative; display: flex; align-items: center; }

    .search-wrap input {
        padding: .45rem .85rem .45rem 2rem;
        border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        font-size: .82rem; color: var(--ink);
        outline: none; width: 200px;
        font-family: var(--ff-body);
        transition: border-color .2s, width .3s;
        box-shadow: 0 2px 8px rgba(232,23,93,.05);
    }

    .search-wrap input:focus { border-color: var(--bright-pink); width: 240px; }
    .search-icon { position: absolute; left: .6rem; width: 14px; height: 14px; opacity: .4; pointer-events: none; }

    .table-card {
        background: var(--white);
        border-radius: 18px;
        border: 2px solid var(--bright-pink);
        box-shadow: 0 2px 16px rgba(232,23,93,.07);
        overflow: hidden;
    }

    .table-card-header {
        padding: 1.2rem 1.5rem .8rem;
        border-bottom: 2px solid var(--bright-pink);
        background: var(--white);
    }

    .table-card-title { font-size: 1rem; font-weight: 800; color: var(--ink); }
    .table-card-sub { font-size: .75rem; color: var(--ink-muted); margin-top: .15rem; }
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; table-layout: fixed; font-size: .88rem; }

    thead th {
        padding: .75rem .85rem;
        text-align: left;
        font-size: .78rem; font-weight: 800;
        color: var(--ink-muted); text-transform: uppercase; letter-spacing: .05em;
        background: var(--blush);
        border-bottom: 2px solid var(--bright-pink);
        white-space: nowrap;
    }

    thead th:nth-child(8),
    thead th:nth-child(9) {
        text-align: center;
    }

    tbody tr { border-bottom: 2px solid var(--baby-pink); transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fff7fb; }

    tbody td {
        padding: .8rem .85rem; color: var(--ink);
        vertical-align: middle; text-align: left; font-weight: 500;
    }

    tbody td:nth-child(8),
    tbody td:nth-child(9) {
        text-align: center;
    }

    thead th:nth-child(3),
    tbody td:nth-child(3),
    thead th:nth-child(6),
    tbody td:nth-child(6) {
        padding-left: .55rem;
    }

    thead th:nth-child(6),
    tbody td:nth-child(6) {
        padding-right: 1.50rem;
    }

    thead th:nth-child(4),
    tbody td:nth-child(4) {
        padding-left: 1.15rem;
    }

    thead th:nth-child(7),
    tbody td:nth-child(7) {
        padding-left: 1.25rem;
    }

    .req-id { font-weight: 700; color: var(--hot-pink); font-size: .86rem; white-space: nowrap; }
    .req-date { font-size: .84rem; color: var(--ink-muted); white-space: nowrap; }

    .room-badge {
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--petal); border: 1px solid var(--baby-pink);
        border-radius: 6px; padding: .22rem .56rem;
        font-size: .84rem; font-weight: 700; color: var(--hot-pink); white-space: nowrap;
    }

    .tenant-name { font-weight: 600; color: var(--ink); white-space: nowrap; }

    .issue-type {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .22rem .56rem; border-radius: 6px;
        font-size: .78rem; font-weight: 700; white-space: nowrap;
    }

    .issue-plumbing   { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .issue-electrical { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .issue-hvac       { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .issue-carpentry  { background: #fce4ec; color: #c62828; border: 1px solid #ef9a9a; }
    .issue-general    { background: #f3e5f5; color: #6a1b9a; border: 1px solid #ce93d8; }
    .issue-pest       { background: #fff3e0; color: #e65100; border: 1px solid #ffcc80; }
    .issue-other      { background: #f5f5f5; color: #424242; border: 1px solid #e0e0e0; }

    .desc-cell {
        max-width: 100%; overflow: visible; text-overflow: clip;
        white-space: normal; overflow-wrap: break-word;
        color: var(--ink-muted); font-size: .86rem; text-align: left; line-height: 1.35;
    }

    .urgency-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .22rem .56rem; border-radius: 6px;
        font-size: .78rem; font-weight: 800; text-transform: uppercase; letter-spacing: .03em; white-space: nowrap;
    }

    .urgency-low      { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .urgency-moderate { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .urgency-urgent   { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }

    .status-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .24rem .64rem; border-radius: 20px;
        font-size: .78rem; font-weight: 800; white-space: nowrap;
    }

    .status-pending     { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .status-in-progress { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .status-resolved    { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .status-closed      { background: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }

    .action-cell { display: flex; align-items: center; justify-content: center; gap: .4rem; }

    .action-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1px solid var(--baby-pink); background: var(--white);
        cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
        transition: .2s; font-family: var(--ff-body);
    }

    .action-btn:hover { border-color: var(--bright-pink); box-shadow: 0 6px 14px rgba(232,23,93,.15); }
    .action-btn img { width: 14px; height: 14px; object-fit: contain; }

    .table-footer {
        padding: .85rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 2px solid var(--petal);
        flex-wrap: wrap; gap: .5rem; background: var(--white);
    }

    .table-info { font-size: .78rem; color: var(--ink-muted); font-weight: 500; }

    .pagination { display: flex; align-items: center; gap: .3rem; }

    .page-btn {
        width: 30px; height: 30px; border-radius: 8px;
        border: 1.5px solid var(--baby-pink); background: var(--white);
        font-size: .8rem; font-weight: 700; color: var(--ink-muted);
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: .2s; font-family: var(--ff-body);
    }

    .page-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .page-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        border-color: transparent; color: var(--white);
        box-shadow: 0 3px 10px rgba(232,23,93,.3);
    }

    .maint-modal-field { display: flex; flex-direction: column; gap: .35rem; margin-bottom: .9rem; }

    .maint-modal-field label {
        font-size: .75rem; font-weight: 700; color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .04em;
    }

    .maint-modal-field input,
    .maint-modal-field select,
    .maint-modal-field textarea {
        width: 100%; padding: .6rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--baby-pink); background: var(--blush);
        font-size: .875rem; color: var(--ink); font-family: var(--ff-body);
        outline: none; box-sizing: border-box; transition: border-color .2s, background .2s;
    }

    .maint-modal-field textarea { min-height: 90px; resize: vertical; }

    .maint-modal-field input:focus,
    .maint-modal-field select:focus,
    .maint-modal-field textarea:focus { border-color: var(--bright-pink); background: var(--white); }

    .modal-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: .8rem; }

    .view-detail-row {
        display: flex; flex-direction: column; gap: .15rem;
        padding: .6rem 0; border-bottom: 1px solid var(--petal);
    }

    .view-detail-row:last-child { border-bottom: none; }
    .view-detail-label { font-size: .7rem; font-weight: 800; color: var(--bright-pink); text-transform: uppercase; letter-spacing: .05em; }
    .view-detail-val { font-size: .875rem; color: var(--ink); font-weight: 500; line-height: 1.6; }

    .remark-box {
        background: var(--blush); border: 1.5px solid var(--baby-pink);
        border-radius: 10px; padding: .75rem 1rem;
        font-size: .83rem; color: var(--ink-muted); line-height: 1.6; white-space: pre-wrap;
    }

    .empty-state { text-align: center; padding: 3rem 1rem; color: var(--ink-muted); font-size: .88rem; }

    .empty-state img {
        width: 48px; height: 48px; object-fit: contain; opacity: .4;
        margin-bottom: .5rem; display: block; margin-left: auto; margin-right: auto;
    }

    .fade-up { animation: mFadeUp .45s ease both; }

    @keyframes mFadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s; }
    .d4 { animation-delay: .28s; }
    .d5 { animation-delay: .36s; }

    .archive-drawer {
        position: fixed;
        top: 0; right: 0; bottom: 0;
        width: min(680px, 100vw);
        background: var(--blush);
        z-index: 500;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(0,0,0,.35);
    }

    .archive-drawer.open { transform: translateX(0); }

    .archive-backdrop {
        position: fixed; inset: 0;
        background: rgba(232, 23, 93, 0.15);
        backdrop-filter: blur(3px);
        z-index: 499;
        opacity: 0; pointer-events: none;
        transition: opacity .38s ease;
    }

    .archive-backdrop.open { opacity: 1; pointer-events: auto; }

    .archive-drawer-header {
        padding: 1.6rem 1.8rem 1.2rem;
        border-bottom: 1px solid rgba(255,255,255,.08);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
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
        width: 34px; height: 34px;
        border-radius: 8px;
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        color: var(--hot-pink);
        font-size: 1rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, color .2s;
        flex-shrink: 0;
    }

    .archive-close-btn:hover { background: rgba(255,255,255,.12); color: #fff; }

    .archive-tabs {
        display: flex;
        gap: 0;
        padding: 0 1.8rem;
        border-bottom: 1px solid rgba(255,255,255,.08);
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
        letter-spacing: .02em;
        font-family: var(--ff-body);
    }

    .archive-tab:hover { color: var(--hot-pink); }

    .archive-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

    .archive-tab-count {
        font-size: .68rem;
        font-weight: 800;
        padding: .1rem .45rem;
        border-radius: 99px;
        background: rgba(255,255,255,.08);
        color: rgba(255,255,255,.5);
        letter-spacing: .02em;
    }

    .archive-tab.active .archive-tab-count { background: var(--hot-pink); color: #fff; }

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
        border: 1px solid rgba(255,255,255,.1);
        background: var(--white);
        color: var(--ink);
        font-size: .83rem;
        font-family: var(--ff-body);
        outline: none;
        transition: border-color .2s, background .2s;
    }

    .archive-search-inner input::placeholder { color: var(--ink-muted); }
    .archive-search-inner input:focus { border-color: var(--hot-pink); background: rgba(255,255,255,.08); }

    .archive-search-icon {
        position: absolute; left: .75rem;
        width: 13px; height: 13px;
        opacity: .3; pointer-events: none;
        filter: brightness(0) invert(1);
    }

    .archive-list {
        flex: 1;
        overflow-y: auto;
        padding: 0 1.8rem 1.8rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .archive-list::-webkit-scrollbar { width: 4px; }
    .archive-list::-webkit-scrollbar-track { background: transparent; }
    .archive-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 99px; }

    .archive-card {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s;
        animation: archiveSlideIn .3s ease both;
    }

    @keyframes archiveSlideIn {
        from { opacity: 0; transform: translateX(12px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .archive-card:hover {
        background: var(--petal);
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

    .archive-card-tenant {
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
        font-weight: 700;
        padding: .18rem .55rem;
        border-radius: 99px;
        letter-spacing: .03em;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        vertical-align: middle;
    }

    .archive-pill-issue {
        background: var(--petal);
        color: var(--hot-pink);
        border: 1px solid var(--baby-pink);
    }
    
    .archive-pill-urgent   { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .archive-pill-moderate { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .archive-pill-low      { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }

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
        border-top: 1px solid rgba(255,255,255,.06);
        font-size: .7rem;
        color: rgba(255,255,255,.25);
        font-weight: 500;
    }

    .archive-card-archived span { color: rgba(255,255,255,.45); font-weight: 600; }

    .archive-divider-label {
        font-size: .7rem;
        font-weight: 800;
        color: rgba(255,255,255,.2);
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: .5rem 0 .3rem;
    }

    .archive-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: rgba(255,255,255,.2);
        font-size: .85rem;
    }

    .archive-empty-icon {
        width: 40px; height: 40px;
        margin: 0 auto .75rem;
        opacity: .15;
        filter: brightness(0) invert(1);
        display: block;
    }

    .archive-footer {
        padding: .9rem 1.8rem;
        border-top: 2px solid var(--baby-pink);
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
        color: rgba(255,255,255,.5);
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        padding: .35rem .85rem;
        cursor: pointer;
        transition: background .2s, color .2s;
        font-family: var(--ff-body);
    }

    .archive-export-btn:hover { background: rgba(255,255,255,.1); color: #fff; }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; filter: brightness(0) invert(1); opacity: .5; }

    @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 700px) {
        .stats-grid { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .modal-two-col { grid-template-columns: 1fr; }
        .archive-tabs { padding: 0 1rem; }
        .archive-drawer-header { padding: 1.2rem 1rem .9rem; }
        .archive-list { padding: 0 1rem 1.2rem; }
        .archive-search-bar { padding: .8rem 1rem .6rem; }
        .archive-footer { padding: .75rem 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-text">
            <h1>Maintenance Requests</h1>
            <div class="dorm-sub">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-archive-open" onclick="openArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>
            <button class="btn-export" onclick="exportTable()">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
        </div>
    </div>

    <div class="stats-grid fade-up d2">
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/nav-maint.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">Total Requests</div>
                <div class="stat-num" id="stat-total">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/warn.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">Urgent Requests</div>
                <div class="stat-num" id="stat-urgent">{{ $stats['urgent'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/pending.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">In-Progress Requests</div>
                <div class="stat-num" id="stat-progress">{{ $stats['in_progress'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/resolved.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">Resolved Requests</div>
                <div class="stat-num" id="stat-resolved">{{ $stats['resolved'] }}</div>
            </div>
        </div>
    </div>

    <div class="toolbar fade-up d3">
        <span class="toolbar-label">Sort By:</span>
        <select class="toolbar-select" id="sort-select" onchange="applyFilters()">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
            <option value="urgent">Urgency</option>
        </select>

        <span class="toolbar-label">From:</span>
        <div class="date-range">
            <img src="{{ asset('icons/calendar.png') }}" alt="">
            <input type="date" id="date-from" onchange="applyFilters()">
            <span class="date-sep">to</span>
            <input type="date" id="date-to" onchange="applyFilters()">
        </div>

        <select class="toolbar-select" id="status-filter" onchange="applyFilters()">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="in-progress">In-Progress</option>
            <option value="resolved">Resolved</option>
        </select>

        <select class="toolbar-select" id="urgency-filter" onchange="applyFilters()">
            <option value="">All Urgencies</option>
            <option value="urgent">Urgent</option>
            <option value="moderate">Moderate</option>
            <option value="low">Low</option>
        </select>

        <div class="search-wrap">
            <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
            <input type="text" id="search-input" placeholder="Search by ID, Tenant, Room..." oninput="applyFilters()">
        </div>
    </div>

    <div class="table-card fade-up d4">
        <div class="table-card-header">
            <div class="table-card-title">Maintenance Requests</div>
            <div class="table-card-sub" id="table-date-label">as of {{ now()->format('F d, Y') }}</div>
        </div>
        <div class="table-wrap">
            <table id="main-table">
                <colgroup>
                    <col style="width:10%;">
                    <col style="width:12%;">
                    <col style="width:7%;">
                    <col style="width:13%;">
                    <col style="width:12%;">
                    <col style="width:8%;">
                    <col style="width:19%;">
                    <col style="width:9%;">
                    <col style="width:10%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Date &amp; Time</th>
                        <th>Room No.</th>
                        <th>Tenant Name</th>
                        <th>Issue Type</th>
                        <th>Urgency</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-body"></tbody>
            </table>
        </div>
        <div class="table-footer">
            <div class="table-info" id="table-info">Showing 0 entries</div>
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
            <div class="archive-drawer-title">Archive & History</div>
            <div class="archive-drawer-sub">Record of closed and deleted requests</div>
        </div>
        <button class="archive-close-btn" onclick="closeArchive()">&#x2715;</button>
    </div>

    <div class="archive-tabs">
        <button class="archive-tab active" id="atab-closed" onclick="switchArchiveTab('closed')">
            Closed
            <span class="archive-tab-count" id="acount-closed">0</span>
        </button>
        <button class="archive-tab" id="atab-deleted" onclick="switchArchiveTab('deleted')">
            Deleted
            <span class="archive-tab-count" id="acount-deleted">0</span>
        </button>
    </div>

    <div class="archive-search-bar">
        <div class="archive-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="archive-search-icon" alt="">
            <input type="text" id="archive-search" placeholder="Search archived requests..." oninput="renderArchive()">
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
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">Request Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit / Update</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal" style="max-width:540px;">
        <div class="modal-header">
            <div class="modal-title">Update Request</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">&#x2715;</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-two-col">
                <div class="maint-modal-field">
                    <label>Status</label>
                    <select name="status" id="edit-status">
                        <option value="pending">Pending</option>
                        <option value="in-progress">In-Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="maint-modal-field">
                    <label>Urgency</label>
                    <select name="urgency" id="edit-urgency">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
            </div>
            <div class="maint-modal-field">
                <label>Admin Remarks (visible to tenant)</label>
                <textarea name="admin_remarks" id="edit-remarks" placeholder="Add comments or update for the tenant..."></textarea>
            </div>
            <div style="background:#fff8e1;border:1.5px solid #ffd54f;border-radius:10px;padding:.6rem .9rem;font-size:.78rem;color:#c07800;margin-bottom:.5rem;line-height:1.5;">
                Setting status to <strong>Closed</strong> will move this request to the archive permanently.
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Delete Request</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">&#x2715;</button>
        </div>
        <div style="background:#fff0f0;border:1.5px solid #ffc8d0;border-radius:10px;padding:.7rem 1rem;font-size:.83rem;color:#c0303a;margin-bottom:1rem;line-height:1.5;">
            This request will be permanently deleted but saved to the archive history.
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Delete <strong id="delete-label" style="color:var(--ink);"></strong>?
        </p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-submit" style="background:var(--red);">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const requests       = @json($requests);
    const closedArchive  = @json($closedArchive);
    const deletedArchive = @json($deletedArchive);

    const perPage  = 10;
    let filtered    = [...requests];
    let currentPage = 1;
    let currentReq  = null;
    let archiveTab  = 'closed';

    const issueClasses = {
        plumbing:   'issue-plumbing',
        electrical: 'issue-electrical',
        hvac:       'issue-hvac',
        appliance:  'issue-general',
        carpentry:  'issue-carpentry',
        pest:       'issue-pest',
        cleaning:   'issue-general',
        internet:   'issue-hvac',
        general:    'issue-general',
        other:      'issue-other',
    };

    function urgencyBadge(u) {
        const map = {
            low:      '<span class="urgency-badge urgency-low">Low</span>',
            moderate: '<span class="urgency-badge urgency-moderate">Moderate</span>',
            urgent:   '<span class="urgency-badge urgency-urgent">Urgent</span>',
        };
        return map[u] ?? '<span class="urgency-badge urgency-low">Low</span>';
    }

    function statusBadge(s) {
        const map = {
            'pending':     '<span class="status-badge status-pending">Pending</span>',
            'in-progress': '<span class="status-badge status-in-progress">In-Progress</span>',
            'resolved':    '<span class="status-badge status-resolved">Resolved</span>',
            'closed':      '<span class="status-badge status-closed">Closed</span>',
        };
        return map[s] ?? '<span class="status-badge status-pending">Pending</span>';
    }

    function issueBadge(type) {
        const cls = issueClasses[type?.toLowerCase()] ?? 'issue-other';
        return `<span class="issue-type ${cls}">${escHtml(type ?? '—')}</span>`;
    }

    function fmtDate(d) {
        if (!d) return '—';
        const dt   = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date}<br><span style="font-size:.75rem;color:var(--ink-muted);font-weight:400;">${time}</span>`;
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
        const dt   = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date} ${time}`;
    }

    function escHtml(str) {
        return (str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
    }

    const eyeIcon    = "{{ asset('icons/eye.png') }}";
    const editIcon   = "{{ asset('icons/edit.png') }}";
    const deleteIcon = "{{ asset('icons/delete.png') }}";
    const searchIcon = "{{ asset('icons/search.png') }}";
    const maintIcon  = "{{ asset('icons/maintenance.png') }}";

    function buildRow(r) {
        const issueKey = (r.issue_type ?? '').toLowerCase();
        const cls = issueClasses[issueKey] ?? 'issue-other';
        return `<tr>
            <td><span class="req-id">#REQ-${String(r.id).padStart(3,'0')}</span></td>
            <td><div class="req-date">${fmtDate(r.created_at)}</div></td>
            <td><span class="room-badge">${escHtml(r.room_number ?? '—')}</span></td>
            <td><span class="tenant-name">${escHtml(r.tenant_name ?? '—')}</span></td>
            <td><span class="issue-type ${cls}">${escHtml(r.issue_type ?? '—')}</span></td>
            <td>${urgencyBadge(r.urgency)}</td>
            <td><div class="desc-cell" title="${escHtml(r.description)}">${escHtml(r.description ?? '—')}</div></td>
            <td>${statusBadge(r.status)}</td>
            <td>
                <div class="action-cell">
                    <button class="action-btn" title="View" onclick='viewReq(${JSON.stringify(r)})'>
                        <img src="${eyeIcon}" alt="View">
                    </button>
                    <button class="action-btn" title="Edit" onclick='openEditModal(${JSON.stringify(r)})'>
                        <img src="${editIcon}" alt="Edit">
                    </button>
                    <button class="action-btn" title="Delete" onclick="openDeleteModal(${r.id}, '#REQ-${String(r.id).padStart(3,'0')}')">
                        <img src="${deleteIcon}" alt="Delete">
                    </button>
                </div>
            </td>
        </tr>`;
    }

    function renderTable() {
        const start = (currentPage - 1) * perPage;
        const page  = filtered.slice(start, start + perPage);
        const tbody = document.getElementById('table-body');

        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="9">
                <div class="empty-state">
                    <img src="${maintIcon}" alt="">
                    No maintenance requests found.
                </div>
            </td></tr>`;
        } else {
            tbody.innerHTML = page.map(buildRow).join('');
        }

        const total  = filtered.length;
        const endIdx = Math.min(start + perPage, total);
        document.getElementById('table-info').textContent =
            `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;

        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / perPage);
        const pg = document.getElementById('pagination');
        if (totalPages <= 1) { pg.innerHTML = ''; return; }

        let html = `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage===1?'disabled':''}>&#8249;</button>`;
        for (let i = 1; i <= totalPages; i++) {
            html += `<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
        }
        html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage===totalPages?'disabled':''}>&#8250;</button>`;
        pg.innerHTML = html;
    }

    function goPage(p) {
        const totalPages = Math.ceil(filtered.length / perPage);
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        renderTable();
    }

    function applyFilters() {
        const q       = document.getElementById('search-input').value.toLowerCase();
        const sort    = document.getElementById('sort-select').value;
        const status  = document.getElementById('status-filter').value;
        const urgency = document.getElementById('urgency-filter').value;
        const from    = document.getElementById('date-from').value;
        const to      = document.getElementById('date-to').value;

        filtered = requests.filter(r => {
            const matchSearch =
                ('#req-' + String(r.id).padStart(3,'0')).includes(q) ||
                (r.tenant_name ?? '').toLowerCase().includes(q) ||
                (r.room_number ?? '').toLowerCase().includes(q) ||
                (r.issue_type  ?? '').toLowerCase().includes(q) ||
                (r.description ?? '').toLowerCase().includes(q);
            const matchStatus  = !status  || r.status  === status;
            const matchUrgency = !urgency || r.urgency === urgency;

            let matchDate = true;
            if (from || to) {
                const d = new Date(r.created_at);
                if (from && d < new Date(from)) matchDate = false;
                if (to   && d > new Date(to + 'T23:59:59')) matchDate = false;
            }

            return matchSearch && matchStatus && matchUrgency && matchDate;
        });

        const urgencyOrder = { urgent: 0, moderate: 1, low: 2 };
        if (sort === 'newest') filtered.sort((a,b) => new Date(b.created_at) - new Date(a.created_at));
        if (sort === 'oldest') filtered.sort((a,b) => new Date(a.created_at) - new Date(b.created_at));
        if (sort === 'urgent') filtered.sort((a,b) => (urgencyOrder[a.urgency]??2) - (urgencyOrder[b.urgency]??2));

        currentPage = 1;
        renderTable();
    }

    function viewReq(r) {
        currentReq = r;
        document.getElementById('view-content').innerHTML = `
            <div class="view-detail-row">
                <div class="view-detail-label">Request ID</div>
                <div class="view-detail-val" style="font-weight:700;color:var(--hot-pink);">#REQ-${String(r.id).padStart(3,'0')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Tenant</div>
                <div class="view-detail-val">${escHtml(r.tenant_name ?? '—')} — Room ${escHtml(r.room_number ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Issue Type</div>
                <div class="view-detail-val">${issueBadge(r.issue_type)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Description</div>
                <div class="view-detail-val" style="white-space:pre-wrap;">${escHtml(r.description ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Urgency</div>
                <div class="view-detail-val">${urgencyBadge(r.urgency)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Status</div>
                <div class="view-detail-val">${statusBadge(r.status)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Submitted</div>
                <div class="view-detail-val">${fmtDatePlain(r.created_at)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Admin Remarks</div>
                <div class="view-detail-val">
                    ${r.admin_remarks
                        ? `<div class="remark-box">${escHtml(r.admin_remarks)}</div>`
                        : '<span style="color:var(--ink-muted);font-style:italic;">No remarks yet.</span>'}
                </div>
            </div>
        `;
        openModal('view-modal');
    }

    function switchToEdit() {
        if (currentReq) {
            closeModal('view-modal');
            setTimeout(() => openEditModal(currentReq), 200);
        }
    }

    function openEditModal(r) {
        currentReq = r;
        document.getElementById('edit-status').value  = r.status  ?? 'pending';
        document.getElementById('edit-urgency').value = r.urgency ?? 'low';
        document.getElementById('edit-remarks').value = r.admin_remarks ?? '';
        document.getElementById('edit-form').action   = `/maintenance/${r.id}`;
        openModal('edit-modal');
    }

    function openDeleteModal(id, label) {
        document.getElementById('delete-label').textContent = label;
        document.getElementById('delete-form').action = `/maintenance/${id}`;
        openModal('delete-modal');
    }

    function exportTable() {
        const rows = [['Request ID','Date','Room','Tenant','Issue Type','Description','Urgency','Status','Remarks']];
        filtered.forEach(r => {
            rows.push([
                '#REQ-' + String(r.id).padStart(3,'0'),
                fmtDatePlain(r.created_at),
                r.room_number   ?? '',
                r.tenant_name   ?? '',
                r.issue_type    ?? '',
                r.description   ?? '',
                r.urgency       ?? '',
                r.status        ?? '',
                r.admin_remarks ?? '',
            ]);
        });
        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g,'""')}"`).join(',')).join('\n');
        const a = document.createElement('a');
        a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'maintenance_requests.csv';
        a.click();
    }

    function openArchive() {
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        document.getElementById('acount-closed').textContent  = closedArchive.length;
        document.getElementById('acount-deleted').textContent = deletedArchive.length;
        renderArchive();
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-closed').classList.toggle('active',  tab === 'closed');
        document.getElementById('atab-deleted').classList.toggle('active', tab === 'deleted');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    function renderArchive() {
        const q    = document.getElementById('archive-search').value.toLowerCase();
        const data = archiveTab === 'closed' ? closedArchive : deletedArchive;

        const filtered = data.filter(r =>
            ('#req-' + String(r.id).padStart(3,'0')).includes(q) ||
            (r.tenant_name ?? '').toLowerCase().includes(q) ||
            (r.room_number ?? '').toLowerCase().includes(q) ||
            (r.issue_type  ?? '').toLowerCase().includes(q) ||
            (r.description ?? '').toLowerCase().includes(q)
        );

        const list = document.getElementById('archive-list');
        document.getElementById('archive-count-label').textContent = `${filtered.length} record${filtered.length !== 1 ? 's' : ''}`;

        if (filtered.length === 0) {
            list.innerHTML = `<div class="archive-empty">
                <img class="archive-empty-icon" src="{{ asset('icons/maintenance.png') }}" alt="">
                No ${archiveTab} requests found.
            </div>`;
            return;
        }

        const urgencyPillClass = { urgent: 'archive-pill-urgent', moderate: 'archive-pill-moderate', low: 'archive-pill-low' };
        const archiveLabel     = archiveTab === 'closed' ? 'Closed on' : 'Deleted on';

        list.innerHTML = filtered.map((r, i) => `
            <div class="archive-card" style="animation-delay:${i * 0.04}s;">
                <div class="archive-card-top">
                    <div class="archive-card-id">#REQ-${String(r.id).padStart(3,'0')}</div>
                    <div class="archive-card-time">${fmtDatePlain(r.created_at)}</div>
                </div>
                <div class="archive-card-tenant">${escHtml(r.tenant_name ?? '—')}</div>
                <div class="archive-card-room">Room ${escHtml(r.room_number ?? '—')}</div>
                <div class="archive-card-meta">
                    <span class="archive-pill archive-pill-issue">${escHtml(r.issue_type ?? '—')}</span>
                    <span class="archive-pill ${urgencyPillClass[r.urgency] ?? 'archive-pill-low'}">${escHtml(r.urgency ?? 'low')}</span>
                </div>
                ${r.description ? `<div class="archive-card-desc">${escHtml(r.description)}</div>` : ''}
                <div class="archive-card-archived">
                    ${archiveLabel}: <span>${fmtDatePlain(r.archived_at)}</span>
                </div>
            </div>
        `).join('');
    }

    function exportArchive() {
        const data  = archiveTab === 'closed' ? closedArchive : deletedArchive;
        const label = archiveTab === 'closed' ? 'Closed On' : 'Deleted On';
        const rows  = [['Request ID', 'Submitted', 'Room', 'Tenant', 'Issue Type', 'Description', 'Urgency', 'Status', 'Remarks', label]];
        data.forEach(r => {
            rows.push([
                '#REQ-' + String(r.id).padStart(3,'0'),
                fmtDatePlain(r.created_at),
                r.room_number   ?? '',
                r.tenant_name   ?? '',
                r.issue_type    ?? '',
                r.description   ?? '',
                r.urgency       ?? '',
                r.status        ?? '',
                r.admin_remarks ?? '',
                fmtDatePlain(r.archived_at),
            ]);
        });
        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g,'""')}"`).join(',')).join('\n');
        const a   = document.createElement('a');
        a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = `maintenance_${archiveTab}_archive.csv`;
        a.click();
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    applyFilters();
</script>
@endsection
