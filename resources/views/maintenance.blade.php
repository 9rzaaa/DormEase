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

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(232,23,93,.35);
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
    .stat-sub { font-size: .73rem; color: rgba(248,246,246,.955); font-weight: 600; margin-top: .15rem; }

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

    .date-range { user-select: none; }

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
        border: 1px solid var(--bright-pink);
        box-shadow: 0 2px 16px rgba(232,23,93,.07);
        overflow: hidden;
    }

    .table-card-header {
        padding: 1.2rem 1.5rem .8rem;
        border-bottom: 1px solid var(--bright-pink);
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
        border-bottom: 1px solid var(--bright-pink);
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
    tbody td:nth-child(3) {
        padding-left: .55rem;
    }

    thead th:nth-child(4),
    tbody td:nth-child(4) {
        padding-left: 1.15rem;
    }

    thead th:nth-child(6),
    tbody td:nth-child(6) {
        text-align: center;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    thead th:nth-child(7),
    tbody td:nth-child(7) {
        padding-left: 2.5rem;
        padding-right: 1rem;
    }

    thead th:nth-child(8),
    tbody td:nth-child(8) {
        text-align: center;
        padding-left: 1rem;
        padding-right: 1rem;
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

    .issue-plumbing,
    .issue-electrical,
    .issue-hvac,
    .issue-carpentry,
    .issue-general,
    .issue-pest,
    .issue-other      { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--baby-pink); }

        .desc-cell {
        display: block;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--ink-muted); font-size: .86rem; text-align: left; line-height: 1.35;
        box-sizing: border-box;
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

    #keyword-modal .modal {
        max-height: 85vh;
        height: 85vh;
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

    .btn-resubmit-request {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        width: 100%;
        margin-top: .5rem;
        padding: .65rem 1rem;
        border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--blush);
        color: var(--hot-pink);
        font-size: .82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
        font-family: var(--ff-body);
    }

    .btn-resubmit-request:hover {
        background: var(--petal);
        border-color: var(--bright-pink);
        color: var(--bright-pink);
        box-shadow: 0 6px 16px rgba(232,23,93,.18);
    }

    .btn-resubmit-request.already-requested {
        background: rgba(232,23,93,.08);
        border-color: rgba(232,23,93,.25);
        color: var(--bright-pink);
        cursor: default;
        pointer-events: none;
    }

    .btn-resubmit-request img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .resubmit-confirm-overlay {
        position: fixed;
        inset: 0;
        background: rgba(26,26,46,.48);
        backdrop-filter: blur(4px);
        z-index: 1500;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .resubmit-confirm-overlay.open {
        display: flex;
    }

    .resubmit-confirm-box {
        background: var(--white);
        border-radius: 18px;
        padding: 1.8rem 1.8rem 1.4rem;
        width: 90%;
        max-width: 400px;
        border: 1px solid var(--baby-pink);
        box-shadow: 0 20px 60px rgba(232,23,93,.15);
        animation: rcFadeUp .28s ease both;
    }

    @keyframes rcFadeUp {
        from { opacity: 0; transform: translateY(16px) scale(.97); }
        to   { opacity: 1; transform: translateY(0)    scale(1);   }
    }

    .resubmit-confirm-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--hot-pink);
        margin-bottom: .35rem;
        letter-spacing: -.01em;
    }

    .resubmit-confirm-sub {
        font-size: .83rem;
        color: var(--ink-muted);
        line-height: 1.6;
        margin-bottom: 1.2rem;
    }

    .resubmit-confirm-actions {
        display: flex;
        gap: .6rem;
        justify-content: flex-end;
    }

    .resubmit-confirm-cancel {
        padding: .55rem 1.2rem;
        border-radius: 9px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        color: var(--ink-muted);
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        font-family: var(--ff-body);
        transition: all .2s ease;
    }

    .resubmit-confirm-cancel:hover {
        border-color: var(--bright-pink);
        color: var(--hot-pink);
        background: var(--blush);
    }

    .resubmit-confirm-send {
        padding: .55rem 1.3rem;
        border-radius: 9px;
        border: none;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .85rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        box-shadow: 0 4px 14px rgba(232,23,93,.28);
        transition: transform .15s ease, opacity .2s ease;
    }

    .resubmit-confirm-send:hover {
        transform: translateY(-1px);
        opacity: .95;
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
        box-shadow: -8px 0 40px rgba(0,0,0,.25);
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
        width: 34px; height: 34px;
        border-radius: 8px;
        background: var(--white);
        border: 1.5px solid var(--pink-100);
        color: var(--hot-pink);
        font-size: 1rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
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
        letter-spacing: .02em;
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
        letter-spacing: .02em;
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
        border: 1.5px solid var(--pink-100);
        background: var(--white);
        color: var(--ink);
        font-size: .83rem;
        font-family: var(--ff-body);
        outline: none;
        transition: border-color .2s, background .2s;
    }

    .archive-search-inner input::placeholder { color: var(--ink-muted); }
    .archive-search-inner input:focus { border-color: var(--bright-pink); }

    .archive-search-icon {
        position: absolute; left: .75rem;
        width: 13px; height: 13px;
        opacity: .35; pointer-events: none;
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
    .archive-list::-webkit-scrollbar-thumb { background: var(--pink-100); border-radius: 99px; }

    .archive-card {
        background: var(--white);
        border: 1.5px solid var(--pink-100);
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

    .archive-card-tenant {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .1rem;
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
        vertical-align: middle;
    }

    .archive-pill-issue {
        background: var(--pink-100);
        color: var(--hot-pink);
        border: 1px solid var(--pink-100);
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
        border-top: 1px solid var(--pink-100);
        font-size: .7rem;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .archive-card-archived span { color: var(--bright-pink); font-weight: 700; }

    .archive-divider-label {
        font-size: .7rem;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: .5rem 0 .3rem;
    }

    .archive-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
    }

    .archive-empty-icon {
        width: 40px; height: 40px;
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
        border: 1.5px solid var(--pink-100);
        border-radius: 8px;
        padding: .35rem .85rem;
        cursor: pointer;
        transition: .2s;
        font-family: var(--ff-body);
    }

    .archive-export-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .65; }

    @media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
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

.maint-legend-wrap {
    position: static;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    flex-shrink: 0;
}
.maint-legend-wrap img {
    width: 15px;
    height: 15px;
    object-fit: contain;
    opacity: .6;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    transition: opacity .2s;
}
.maint-legend-wrap:hover img { opacity: 1; }
.maint-legend-popup {
    display: none;
    position: fixed;
    background: var(--white);
    border: 1.5px solid var(--pink-200);
    border-radius: 14px;
    box-shadow: 0 12px 32px rgba(232,23,93,.13), 0 2px 8px rgba(0,0,0,.07);
    padding: .75rem .9rem;
    min-width: 380px;
    z-index: 9999;
}
.mlp-title {
    font-size: .67rem;
    font-weight: 800;
    color: var(--bright-pink);
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .45rem;
    padding-bottom: .35rem;
    border-bottom: 1.5px solid var(--petal);
}
.mlp-section {
    margin-top: .55rem;
    margin-bottom: .2rem;
}
.mlp-section-label {
    font-size: .62rem;
    font-weight: 800;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: .09em;
    margin-bottom: .3rem;
    display: flex;
    align-items: center;
    gap: .3rem;
}
.mlp-section-label::before {
    content: '';
    display: inline-block;
    width: 3px;
    height: 9px;
    background: var(--gradient-pink);
    border-radius: 2px;
}
.mlp-row {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    padding: .32rem 0;
    border-bottom: 1px solid var(--pink-100);
}
.mlp-row:last-child { border-bottom: none; }
.mlp-badge { flex-shrink: 0; min-width: 110px; display: flex; align-items: center; }
.mlp-desc {
    font-size: .73rem;
    color: var(--ink-muted);
    font-weight: 500;
    line-height: 1.45;
    padding-top: .1rem;
}

.export-dropdown { position: relative; display: inline-flex; }
.export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-100); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
.export-menu.open { display: block; }
.export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
.export-menu button:hover { background: var(--petal); color: var(--hot-pink); }
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

.kw-tab:hover { border-color: var(--baby-pink); }

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
    flex-shrink: 0;
    padding: 0 1.1rem .6rem;
}

.kw-summary-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .6rem;
    width: 100%;
    background: var(--blush);
    border: 1.5px solid var(--baby-pink);
    border-radius: 10px;
    padding: .5rem .75rem;
    cursor: pointer;
    font-family: var(--ff-body);
    transition: border-color .2s, background .2s;
}

.kw-summary-toggle:hover {
    border-color: var(--bright-pink);
    background: var(--petal);
}

.kw-summary-toggle-text {
    font-size: .73rem;
    font-weight: 600;
    color: var(--ink-muted);
}

.kw-summary-toggle-text strong {
    color: var(--hot-pink);
    font-weight: 800;
}

.kw-summary-chevron {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    color: var(--hot-pink);
    transition: transform .25s ease;
}

.kw-summary-bar.open .kw-summary-chevron {
    transform: rotate(180deg);
}

.kw-summary-detail {
    max-height: 0;
    overflow: hidden;
    transition: max-height .28s ease, opacity .2s ease, margin-top .25s ease;
    opacity: 0;
}

.kw-summary-bar.open .kw-summary-detail {
    max-height: 110px;
    opacity: 1;
    margin-top: .5rem;
}

.kw-summary-split {
    display: flex;
    height: 8px;
    border-radius: 999px;
    overflow: hidden;
    background: var(--baby-pink);
    margin-bottom: .55rem;
}

.kw-summary-split-builtin {
    background: var(--pink-100);
    transition: width .3s ease;
}

.kw-summary-split-trained {
    background: var(--bright-pink);
    transition: width .3s ease;
}

.kw-summary-rows {
    display: flex;
    flex-direction: column;
    gap: .3rem;
}

.kw-summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .73rem;
    color: var(--ink-muted);
    font-weight: 600;
}

.kw-summary-row-label {
    display: flex;
    align-items: center;
    gap: .4rem;
}

.kw-summary-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.kw-summary-dot.builtin { background: var(--pink-100); border: 1px solid var(--baby-pink); }
.kw-summary-dot.trained { background: var(--bright-pink); }

.kw-summary-row-val {
    color: var(--ink);
    font-weight: 800;
}

.kw-search-inner { position: relative; display: flex; align-items: center; }

.kw-search-inner input {
    width: 100%;
    padding: .5rem .85rem .5rem 2rem;
    border-radius: 10px;
    border: 1.5px solid var(--baby-pink);
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
    scrollbar-width: thin; scrollbar-color: var(--baby-pink) transparent;
    min-height: 0;
    max-height: none;
}

.kw-list::-webkit-scrollbar { width: 4px; }
.kw-list::-webkit-scrollbar-track { background: transparent; }
.kw-list::-webkit-scrollbar-thumb { background: var(--baby-pink); border-radius: 99px; }

.kw-card {
    position: relative;
    background: var(--white);
    border: 1.5px solid var(--baby-pink);
    border-radius: 16px;
    padding: 1rem 1.1rem 1.1rem 1.3rem;
    animation: kwCardIn .3s ease both;
    transition: border-color .2s, box-shadow .2s;
    flex-shrink: 0;
}

.kw-card:hover { border-color: var(--bright-pink); box-shadow: 0 8px 22px rgba(232,23,93,.08); }

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
    border: 1.5px solid var(--baby-pink);
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
    border: 1.5px dashed var(--baby-pink);
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
    border: 1.5px solid var(--baby-pink);
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
    border: 1.5px solid var(--baby-pink);
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

.kw-btn-save:disabled {
    opacity: .45;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

.kw-trained-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .8rem;
    background: var(--white);
    border: 1.5px solid var(--baby-pink);
    border-radius: 14px;
    padding: .75rem .95rem;
    animation: kwCardIn .3s ease both;
    transition: border-color .2s, transform .2s;
}

.kw-trained-card:hover { border-color: var(--bright-pink); transform: translateX(2px); }

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
    flex-direction: column;
    gap: .3rem;
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
    line-height: 1.45;
}

.kw-validation-msg.error {
    display: flex;
    align-items: flex-start;
    gap: .4rem;
    background: #fff0f0;
    border: 1.5px solid #ffc8d0;
    border-radius: 8px;
    padding: .4rem .6rem;
    color: #c0303a;
}

.kw-validation-msg.error::before {
    content: '';
    display: inline-block;
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    margin-top: .05rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23c0303a' stroke-width='2.5'%3E%3Ccircle cx='12' cy='12' r='10'/%3E%3Cline x1='12' y1='8' x2='12' y2='12'/%3E%3Cline x1='12' y1='16' x2='12.01' y2='16'/%3E%3C/svg%3E");
    background-size: contain;
    background-repeat: no-repeat;
}

.kw-validation-msg.warning {
    display: flex;
    align-items: flex-start;
    gap: .4rem;
    background: #fff9e6;
    border: 1.5px solid #f0c040;
    border-radius: 8px;
    padding: .4rem .6rem;
    color: #7a5400;
}

.kw-validation-msg.warning::before {
    content: '';
    display: inline-block;
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    margin-top: .05rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237a5400' stroke-width='2.5'%3E%3Cpath d='M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z'/%3E%3Cline x1='12' y1='9' x2='12' y2='13'/%3E%3Cline x1='12' y1='17' x2='12.01' y2='17'/%3E%3C/svg%3E");
    background-size: contain;
    background-repeat: no-repeat;
}

.kw-type-pill {
    font-size: .67rem; font-weight: 800; padding: .15rem .55rem;
    border-radius: 999px; background: var(--petal); color: var(--hot-pink);
    text-transform: uppercase; letter-spacing: .03em;
}

.kw-urgency-pill {
    font-size: .67rem; font-weight: 800; padding: .15rem .55rem;
    border-radius: 999px; text-transform: uppercase; letter-spacing: .03em;
}

.kw-urgency-pill.low { background: #e8f5e9; color: #2e7d32; }
.kw-urgency-pill.moderate { background: #fff8e1; color: #c07800; }
.kw-urgency-pill.urgent { background: #fff0f0; color: #c0303a; }

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
    border: 1.5px solid var(--baby-pink);
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
    border: 1.5px solid var(--baby-pink);
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
    background: var(--petal);
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
                    <button onclick="exportTable(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportTablePDF(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-grid fade-up d2">
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/nav-maint.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">Total Requests</div>
                <div class="stat-num" id="stat-total">{{ $stats['total'] }}</div>
                <div class="stat-sub">All Time Submitted</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/pending.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">In-Progress</div>
                <div class="stat-num" id="stat-progress">{{ $stats['in_progress'] }}</div>
                <div class="stat-sub">Currently Being Worked On</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('icons/resolved.png') }}" alt=""></div>
            <div class="stat-info">
                <div class="stat-label">Resolved</div>
                <div class="stat-num" id="stat-resolved">{{ $stats['resolved'] }}</div>
                <div class="stat-sub">Successfully Closed</div>
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
            <input type="date" id="date-from" onchange="applyFilters()">
            <span class="date-sep">to</span>
            <input type="date" id="date-to" onchange="applyFilters()">
            <button type="button" id="date-clear-btn" onclick="clearDates()" style="display:none;margin-left:.25rem;background:none;border:none;cursor:pointer;color:var(--bright-pink);font-size:.8rem;font-weight:700;padding:0 .2rem;font-family:var(--ff-body);line-height:1;transition:opacity .2s;" title="Clear dates">&#x2715;</button>
        </div>
        <div id="date-error" style="display:none;position:fixed;background:#fff0f4;border:1.5px solid #ffc2d1;border-radius:8px;padding:.3rem .75rem;font-size:.75rem;font-weight:700;color:#b0163a;white-space:nowrap;z-index:9999;box-shadow:0 4px 12px rgba(232,23,93,.12);">End date cannot be before start date.</div>

        <select class="toolbar-select" id="status-filter" onchange="applyFilters()">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="in-progress">In-Progress</option>
        </select>

        <select class="toolbar-select" id="urgency-filter" onchange="applyFilters()">
            <option value="">All Urgencies</option>
            <option value="urgent">Urgent</option>
            <option value="moderate">Moderate</option>
            <option value="low">Low</option>
        </select>

        <div class="maint-legend-wrap">
            <img src="{{ asset('icons/info.png') }}" alt="Guide">
            <div class="maint-legend-popup">
                <div class="mlp-title">Urgency, Status &amp; Issue Guide</div>

                <div class="mlp-section">
                    <div class="mlp-section-label">Urgency</div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="urgency-badge urgency-urgent">Urgent</span></span><span class="mlp-desc">Immediate attention required as safety or habitability at risk.</span></div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="urgency-badge urgency-moderate">Moderate</span></span><span class="mlp-desc">Needs prompt attention but is not an immediate danger.</span></div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="urgency-badge urgency-low">Low</span></span><span class="mlp-desc">Minor issue that can be addressed in routine maintenance.</span></div>
                </div>

                <div class="mlp-section">
                    <div class="mlp-section-label">Status</div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="status-badge status-pending">Pending</span></span><span class="mlp-desc">Request received and awaiting assignment or action.</span></div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="status-badge status-in-progress">In-Progress</span></span><span class="mlp-desc">Assigned and currently being worked on.</span></div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="status-badge status-resolved">Resolved</span></span><span class="mlp-desc">Issue fixed and moved to the resolved archive.</span></div>
                    <div class="mlp-row"><span class="mlp-badge"><span class="status-badge status-closed">Closed</span></span><span class="mlp-desc">Request closed and moved to the closed archive.</span></div>
                </div>
            </div>
        </div>

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
                    <col style="width:11%;">
                    <col style="width:7%;">
                    <col style="width:12%;">
                    <col style="width:11%;">
                    <col style="width:9%;">
                    <col style="width:15%;">
                    <col style="width:11%;">
                    <col style="width:14%;">
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
<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="resubmit-confirm-overlay" id="resubmit-confirm-overlay">
    <div class="resubmit-confirm-box">
        <div class="resubmit-confirm-title">Request photo resubmission?</div>
        <div class="resubmit-confirm-sub">
            A notification will be sent to the tenant asking them to resubmit a photo for this request.
        </div>
        <div style="display:flex;flex-direction:column;gap:.35rem;margin-bottom:1rem;">
            <label style="font-size:.72rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.04em;">Reason for resubmission</label>
            <select id="resubmit-reason-select" style="padding:.6rem 2rem .6rem .85rem;border-radius:10px;border:1.5px solid var(--baby-pink);background:var(--blush);color:var(--ink);font-size:.84rem;font-family:var(--ff-body);font-weight:600;outline:none;appearance:none;-webkit-appearance:none;background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E&quot;);background-repeat:no-repeat;background-position:right .65rem center;cursor:pointer;transition:border-color .2s,background .2s;width:100%;box-sizing:border-box;" onfocus="this.style.borderColor='var(--bright-pink)';this.style.background='var(--white)'" onblur="this.style.borderColor='var(--baby-pink)';this.style.background='var(--blush)'">
                <option value="">Select a reason...</option>
                <option value="Photo is blurry or out of focus">Photo is blurry or out of focus</option>
                <option value="Photo is too dark or poorly lit">Photo is too dark or poorly lit</option>
                <option value="Photo does not show the issue clearly">Photo does not show the issue clearly</option>
                <option value="Wrong area or location photographed">Wrong area or location photographed</option>
                <option value="Photo is corrupted or unreadable">Photo is corrupted or unreadable</option>
                <option value="Multiple issues shown — need focused photo">Multiple issues shown — need focused photo</option>
                <option value="No photo was attached">No photo was attached</option>
            </select>
            <div id="resubmit-reason-error" style="display:none;font-size:.75rem;color:#c0303a;font-weight:600;margin-top:.15rem;">Please select a reason before sending.</div>
        </div>
        <div style="background:#fff8e1;border:1.5px solid #ffd54f;border-radius:10px;padding:.6rem .85rem;font-size:.78rem;color:#c07800;margin-bottom:1.2rem;line-height:1.55;">
            The tenant will be notified via push notification and in-app message.
        </div>
        <div class="resubmit-confirm-actions">
            <button class="resubmit-confirm-cancel" onclick="closeResubmitConfirm()">Cancel</button>
            <button class="resubmit-confirm-send" id="resubmit-confirm-btn" onclick="executeResubmitRequest()">Send Request</button>
        </div>
    </div>
</div>

<div class="archive-backdrop" id="archive-backdrop" onclick="closeArchive()"></div>

<div class="archive-drawer" id="archive-drawer">
    <div class="archive-drawer-header">
        <div>
            <div class="archive-drawer-title">Archive / History</div>
            <div class="archive-drawer-sub">Record of closed and deleted requests</div>
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
        <button class="archive-tab" id="atab-cancelled" onclick="switchArchiveTab('cancelled')">
            Cancelled
            <span class="archive-tab-count" id="acount-cancelled">0</span>
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

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:560px;padding:0;overflow:hidden;border-radius:18px;">
        <div style="background:var(--gradient-pink);padding:1.2rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:38px;height:38px;background:rgba(255,255,255,.22);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <img src="{{ asset('icons/nav-maint.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;filter:brightness(0) invert(1);">
                </div>
                <div>
                    <div style="font-size:1rem;font-weight:800;color:#fff;line-height:1.2;">Request Details</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.78);font-weight:500;">Maintenance request information</div>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('view-modal')" style="background:transparent;border-color:rgba(255,255,255,.5);color:#fff;">&#x2715;</button>
        </div>
        <div id="view-content" style="padding:1.2rem 1.5rem;max-height:55vh;overflow-y:auto;"></div>
        <div class="modal-actions" style="margin:0;padding:1rem 1.5rem;border-top:1.5px solid var(--baby-pink);background:var(--white);position:sticky;bottom:0;z-index:1;">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit / Update</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal" style="max-width:540px;padding:0;overflow:hidden;border-radius:18px;">
        <div style="background:var(--gradient-pink);padding:1.2rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:38px;height:38px;background:rgba(255,255,255,.22);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <img src="{{ asset('icons/edit.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;filter:brightness(0) invert(1);">
                </div>
                <div>
                    <div style="font-size:1rem;font-weight:800;color:#fff;line-height:1.2;">Update Request</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.78);font-weight:500;">Edit status, urgency and remarks</div>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('edit-modal')" style="background:transparent;border-color:rgba(255,255,255,.5);color:#fff;">&#x2715;</button>
        </div>

        <form id="edit-form" method="POST" data-loading-message="Saving changes..." onsubmit="return validateEditMaintForm(event)">
            @csrf
            @method('PUT')
            <div style="padding:1.4rem 1.5rem;display:flex;flex-direction:column;gap:1rem;">

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.9rem;">
                    <div style="display:flex;flex-direction:column;gap:.4rem;">
                        <label style="font-size:.72rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;">Status</label>
                        <select name="status" id="edit-status" style="padding:.65rem 2rem .65rem .9rem;border-radius:10px;border:1.5px solid var(--baby-pink);background:var(--blush);color:var(--ink);font-size:.875rem;font-family:var(--ff-body);font-weight:600;outline:none;appearance:none;-webkit-appearance:none;background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E&quot;);background-repeat:no-repeat;background-position:right .7rem center;cursor:pointer;transition:border-color .2s;">
                            <option value="pending">Pending</option>
                            <option value="in-progress">In-Progress</option>
                            <option value="resolved">Resolve &amp; Archive</option>
                            <option value="closed">Close &amp; Archive</option>
                        </select>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:.4rem;">
                        <label style="font-size:.72rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;">Urgency</label>
                        <select name="urgency" id="edit-urgency" style="padding:.65rem 2rem .65rem .9rem;border-radius:10px;border:1.5px solid var(--baby-pink);background:var(--blush);color:var(--ink);font-size:.875rem;font-family:var(--ff-body);font-weight:600;outline:none;appearance:none;-webkit-appearance:none;background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E&quot;);background-repeat:no-repeat;background-position:right .7rem center;cursor:pointer;transition:border-color .2s;">
                            <option value="low">Low</option>
                            <option value="moderate">Moderate</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:.4rem;">
                    <label style="font-size:.72rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;">Admin Remarks <span style="text-transform:none;font-weight:500;color:var(--ink-muted);">(visible to tenant)</span></label>
                    <textarea name="admin_remarks" id="edit-remarks"
                        placeholder="Add comments or updates for the tenant..."
                        style="padding:.75rem .9rem;border-radius:10px;border:1.5px solid var(--baby-pink);background:var(--blush);color:var(--ink);font-size:.875rem;font-family:var(--ff-body);min-height:100px;resize:vertical;outline:none;transition:border-color .2s,background .2s;width:100%;box-sizing:border-box;line-height:1.6;"
                        onfocus="this.style.borderColor='var(--bright-pink)';this.style.background='var(--white)'"
                        onblur="this.style.borderColor='var(--baby-pink)';this.style.background='var(--blush)'"
                    ></textarea>
                </div>

                <div style="display:flex;align-items:flex-start;gap:.6rem;background:#fff8e1;border:1.5px solid #ffd54f;border-radius:10px;padding:.7rem .9rem;">
                    <span style="font-size:1rem;flex-shrink:0;margin-top:.05rem;">⚠️</span>
                    <span style="font-size:.78rem;color:#c07800;line-height:1.55;">Setting status to <strong>Closed</strong> or <strong>Resolved</strong> will move this request to the archive permanently.</span>
                </div>

            </div>

            <div style="padding:.9rem 1.5rem;border-top:1.5px solid var(--baby-pink);background:var(--white);display:flex;align-items:center;justify-content:flex-end;gap:.6rem;">
                <button type="button" onclick="closeModal('edit-modal')"
                    style="padding:.6rem 1.4rem;border-radius:10px;border:1.5px solid var(--baby-pink);background:var(--white);color:var(--hot-pink);font-size:.875rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);transition:.2s;"
                    onmouseover="this.style.borderColor='var(--bright-pink)'"
                    onmouseout="this.style.borderColor='var(--baby-pink)'"
                >Cancel</button>
                <button type="submit"
                    style="padding:.6rem 1.6rem;border-radius:10px;border:none;background:var(--gradient-pink);color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);box-shadow:0 4px 14px rgba(232,23,93,.3);transition:.2s;"
                    onmouseover="this.style.boxShadow='0 6px 18px rgba(232,23,93,.45)'"
                    onmouseout="this.style.boxShadow='0 4px 14px rgba(232,23,93,.3)'"
                >Save Changes</button>
            </div>
        </form>
    </div>
</div>
<div class="modal-overlay" id="keyword-modal">
    <div class="modal" style="max-width:620px;">
        <div class="modal-header">
            <div class="kw-modal-header-row">
                <div class="kw-modal-icon-badge">
                    <img src="{{ asset('icons/keyword.png') }}" alt="">
                </div>
                <div class="kw-modal-title-block">
                    <div class="modal-title">Keyword Training</div>
                    <div class="kw-modal-sub">Teach the system to recognize unmatched requests</div>
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
        <div class="kw-summary-bar" id="kw-summary-bar">
            <button class="kw-summary-toggle" id="kw-summary-toggle" onclick="toggleKwSummary()">
                <span class="kw-summary-toggle-text" id="kw-summary-toggle-text"></span>
                <svg class="kw-summary-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="kw-summary-detail">
                <div class="kw-summary-split" id="kw-summary-split"></div>
                <div class="kw-summary-rows" id="kw-summary-rows"></div>
            </div>
        </div>
        <div class="kw-search-bar" style="display:flex;gap:.5rem;">
            <div class="kw-search-inner" style="flex:1;">
                <img src="{{ asset('icons/search.png') }}" class="kw-search-icon" alt="">
                <input type="text" id="kw-search" placeholder="Search..." oninput="renderKwList()">
            </div>
            <button class="kw-add-btn" id="kw-add-btn" onclick="showAddKeywordForm()">+ Add Keyword</button>
        </div>
        <div id="kw-add-form-wrap" style="padding:0 1.1rem;flex-shrink:0;"></div>
        <div class="kw-list" id="kw-list"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('keyword-modal')">Close</button>
        </div>
    </div>
</div>

<div class="kw-help-popup" id="kw-help-popup">
    <div class="kw-help-popup-title">How Keyword Training Works</div>
    <div class="kw-help-step"><span class="kw-help-step-num">1</span><span>Requests that miss every known keyword land in <strong>Pending</strong>.</span></div>
    <div class="kw-help-step"><span class="kw-help-step-num">2</span><span>Tap words in the snippet to build the exact phrase, then assign an issue type.</span></div>
    <div class="kw-help-step"><span class="kw-help-step-num">3</span><span>Saved phrases appear in <strong>Trained</strong>, editable or removable anytime.</span></div>
    <div class="kw-help-step"><span class="kw-help-step-num">4</span><span><strong>Built-in Rules</strong> shows the system defaults for reference only.</span></div>
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
            <form id="delete-form" method="POST" data-loading-message="Deleting request...">
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

function setFormLoading(form, message) {
    form.querySelectorAll('button[type="submit"]').forEach(btn => {
        btn.textContent = 'Please wait...';
        btn.disabled    = true;
        btn.classList.add('is-loading');
    });
    form.querySelectorAll('button:not([type="submit"])').forEach(btn => {
        btn.disabled = true;
        btn.classList.add('is-loading');
    });
    showActionLoading(message);
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-loading-message]').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (e.defaultPrevented) return;
            setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
        });
    });
});
    const requests       = @json($requests);
    const closedArchive  = @json($closedArchive);
    const resolvedArchive = @json($resolvedArchive);
    const deletedArchive    = @json($deletedArchive);
    const cancelledArchive  = @json($cancelledArchive);
    let pendingTerms       = @json($pendingTerms);
    let trainedKeywords    = @json($trainedKeywords);
    const hardcodedRules   = @json($hardcodedRules);
    const kwEditIcon = "{{ asset('icons/edit.png') }}";
    const kwDeleteIcon = "{{ asset('icons/delete.png') }}";
    const kwEmptyIcon = "{{ asset('icons/maintenance.png') }}";
    const ISSUE_TYPE_OPTIONS = ['Plumbing', 'Electrical', 'Hvac', 'Appliance', 'Carpentry', 'Pest', 'Cleaning', 'Internet', 'Other'];
    let kwActiveTab = 'pending';
    const kwPhraseState = {};
    const perPage  = 10;
    let filtered    = [];
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
        const label = type ? type.charAt(0).toUpperCase() + type.slice(1).toLowerCase() : '—';
        return `<span class="issue-type ${cls}">${escHtml(label)}</span>`;
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

    var _rowDataMap = {};

    function buildRow(r) {
        const issueKey = (r.issue_type ?? '').toLowerCase();
        const cls = issueClasses[issueKey] ?? 'issue-other';
        _rowDataMap[r.id] = r;
        return `<tr>
            <td><span class="req-id">#REQ-${String(r.id).padStart(3,'0')}</span></td>
            <td><div class="req-date">${fmtDate(r.created_at)}</div></td>
            <td><span class="room-badge">${escHtml(r.room_number ?? '—')}</span></td>
            <td><span class="tenant-name">${escHtml(r.tenant_name ?? '—')}</span></td>
            <td><span class="issue-type ${cls}">${escHtml(r.issue_type ? r.issue_type.charAt(0).toUpperCase() + r.issue_type.slice(1).toLowerCase() : '—')}</span></td>
            <td>${urgencyBadge(r.urgency)}</td>
            <td><div class="desc-cell" title="${escHtml(r.description)}">${escHtml(r.description ?? '—')}</div></td>
            <td>${statusBadge(r.status)}</td>
            <td>
                <div class="action-cell">
                    <button class="action-btn" title="View" onclick="viewReq(_rowDataMap[${r.id}])">
                        <img src="${eyeIcon}" alt="View">
                    </button>
                    <button class="action-btn" title="Edit" onclick="openEditModal(_rowDataMap[${r.id}])">
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
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += `<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += `<span style="color:var(--ink-muted);padding:0 .2rem;line-height:30px;">&#8230;</span>`;
            }
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

    var _filterDebounce = null;

    function applyFilters() {
        clearTimeout(_filterDebounce);
        _filterDebounce = setTimeout(function() {
            _runFilters();
        }, 180);
    }

    function _runFilters() {
        var q       = document.getElementById('search-input').value.toLowerCase();
        var sort    = document.getElementById('sort-select').value;
        var status  = document.getElementById('status-filter').value;
        var urgency = document.getElementById('urgency-filter').value;
        var from    = document.getElementById('date-from').value;
        var to      = document.getElementById('date-to').value;
        var dateErr = document.getElementById('date-error');

        if (from && to && from > to) {
            var toEl  = document.getElementById('date-to');
            var rect  = toEl.getBoundingClientRect();
            dateErr.style.visibility = 'hidden';
            dateErr.style.display    = 'block';
            dateErr.style.top  = (rect.bottom + 6) + 'px';
            dateErr.style.left = rect.left + 'px';
            dateErr.style.visibility = '';
            document.getElementById('date-from').style.borderColor = '#ffc2d1';
            toEl.style.borderColor = '#ffc2d1';
            return;
        }

        dateErr.style.display = 'none';
        document.getElementById('date-from').style.borderColor = '';
        document.getElementById('date-to').style.borderColor   = '';
        document.getElementById('date-clear-btn').style.display = (from || to) ? 'inline' : 'none';

        filtered = requestsData.filter(function(r) {
            var matchSearch =
                ('#req-' + String(r.id).padStart(3,'0')).includes(q) ||
                (r.tenant_name || '').toLowerCase().includes(q) ||
                (r.room_number || '').toLowerCase().includes(q) ||
                (r.issue_type  || '').toLowerCase().includes(q) ||
                (r.description || '').toLowerCase().includes(q);
            var matchStatus  = !status  || r.status  === status;
            var matchUrgency = !urgency || r.urgency === urgency;

            var matchDate = true;
            if (from || to) {
                var d = new Date(r.created_at);
                if (from && d < new Date(from)) matchDate = false;
                if (to   && d > new Date(to + 'T23:59:59')) matchDate = false;
            }

            return matchSearch && matchStatus && matchUrgency && matchDate;
        });

        var urgencyOrder = { urgent: 0, moderate: 1, low: 2 };
        if (sort === 'newest') filtered.sort(function(a,b){ return new Date(b.created_at) - new Date(a.created_at); });
        if (sort === 'oldest') filtered.sort(function(a,b){ return new Date(a.created_at) - new Date(b.created_at); });
        if (sort === 'urgent') filtered.sort(function(a,b){ return (urgencyOrder[a.urgency] ?? 2) - (urgencyOrder[b.urgency] ?? 2); });

        currentPage = 1;
        renderTable();
    }

    function viewReq(r) {
    currentReq = r;

    const alreadyRequested = !!r.resubmission_requested_at;
    const resubmitBtnHtml = r.photo_url ? `
    <button
        class="btn-resubmit-request${alreadyRequested ? ' already-requested' : ''}"
        id="resubmit-request-btn"
        onclick="openResubmitConfirm()"
    >
        <img src="{{ asset('icons/reset.png') }}" alt="">
        ${alreadyRequested
            ? 'Resubmission already requested on ' + fmtDatePlain(r.resubmission_requested_at)
            : 'Request Photo Resubmission'}
    </button>
` : '';

    document.getElementById('view-content').innerHTML = `
        <div style="display:flex;gap:.6rem;margin-bottom:1.1rem;flex-wrap:wrap;align-items:center;">
            <span style="font-size:1.1rem;font-weight:800;color:var(--hot-pink);letter-spacing:-.01em;">#REQ-${String(r.id).padStart(3,'0')}</span>
            ${statusBadge(r.status)}
            ${urgencyBadge(r.urgency)}
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem .9rem;margin-bottom:.9rem;">
            <div style="background:var(--blush);border-radius:10px;padding:.65rem .85rem;">
                <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem;">Tenant</div>
                <div style="font-size:.875rem;font-weight:600;color:var(--ink);">${escHtml(r.tenant_name ?? '—')}</div>
            </div>
            <div style="background:var(--blush);border-radius:10px;padding:.65rem .85rem;">
                <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem;">Room</div>
                <div style="font-size:.875rem;font-weight:600;color:var(--ink);">${escHtml(r.room_number ?? '—')}</div>
            </div>
            <div style="background:var(--blush);border-radius:10px;padding:.65rem .85rem;">
                <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem;">Issue Type</div>
                <div style="margin-top:.2rem;">${issueBadge(r.issue_type)}</div>
            </div>
            <div style="background:var(--blush);border-radius:10px;padding:.65rem .85rem;">
                <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem;">Date Submitted</div>
                <div style="font-size:.82rem;color:var(--ink-muted);font-weight:500;">${fmtDatePlain(r.created_at)}</div>
            </div>
        </div>

        <div style="background:var(--blush);border-radius:10px;padding:.75rem .85rem;margin-bottom:.6rem;">
            <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.35rem;">Description</div>
            <div style="font-size:.875rem;color:var(--ink);line-height:1.65;white-space:pre-wrap;">${escHtml(r.description ?? '—')}</div>
        </div>

        <div style="margin-bottom:.6rem;">
            <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.45rem;">Attached Photo</div>
            ${r.photo_url ? `
            <div style="border-radius:12px;overflow:hidden;border:1.5px solid var(--baby-pink);background:var(--blush);position:relative;">
                <img src="${escHtml(r.photo_url)}"
                    alt="Maintenance photo"
                    style="width:100%;max-height:260px;object-fit:cover;display:block;cursor:pointer;"
                    onclick="window.open('${escHtml(r.photo_url)}','_blank')"
                    onerror="this.parentElement.innerHTML='<div style=\'padding:1rem;text-align:center;font-size:.8rem;color:var(--ink-muted);\'>Photo could not be loaded.</div>'"
                />
                <a href="${escHtml(r.photo_url)}" target="_blank"
                    style="position:absolute;bottom:.55rem;right:.55rem;background:rgba(0,0,0,.52);color:#fff;font-size:.72rem;font-weight:700;padding:.3rem .65rem;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;backdrop-filter:blur(4px);">
                    &#x2197; View full
                </a>
            </div>
            ` : `
            <div style="background:var(--blush);border:1.5px dashed var(--baby-pink);border-radius:12px;padding:1.4rem 1rem;text-align:center;color:var(--ink-muted);font-size:.82rem;">
                No photo attached to this request.
            </div>
            `}
            ${resubmitBtnHtml}
        </div>

        <div style="background:var(--blush);border-radius:10px;padding:.75rem .85rem;">
            <div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.35rem;">Admin Remarks</div>
            ${r.admin_remarks
                ? `<div class="remark-box" style="margin-top:0;">${escHtml(r.admin_remarks)}</div>`
                : `<span style="font-size:.83rem;color:var(--ink-muted);font-style:italic;">No remarks yet.</span>`}
        </div>
    `;
    openModal('view-modal');
}

    function openResubmitConfirm() {
        if (!currentReq) return;
        document.getElementById('resubmit-confirm-overlay').classList.add('open');
    }

    function closeResubmitConfirm() {
        document.getElementById('resubmit-confirm-overlay').classList.remove('open');
        document.getElementById('resubmit-reason-select').value = '';
        document.getElementById('resubmit-reason-error').style.display = 'none';
    }

    function executeResubmitRequest() {
        if (!currentReq) return;

        const reasonSelect = document.getElementById('resubmit-reason-select');
        const reasonError  = document.getElementById('resubmit-reason-error');
        const reason       = reasonSelect.value;

        if (!reason) {
            reasonError.style.display = 'block';
            reasonSelect.style.borderColor = '#ffc8d0';
            reasonSelect.focus();
            return;
        }

        reasonError.style.display = 'none';
        reasonSelect.style.borderColor = '';

        const btn = document.getElementById('resubmit-confirm-btn');
        btn.textContent = 'Sending...';
        btn.disabled    = true;

        fetch('/maintenance/' + currentReq.id + '/request-resubmission', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ reason: reason }),
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            closeResubmitConfirm();

            if (data.success) {
                const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
                currentReq.resubmission_requested_at = now;

                const reqBtn = document.getElementById('resubmit-request-btn');
                if (reqBtn) {
                    reqBtn.classList.add('already-requested');
                    reqBtn.innerHTML = '<img src="{{ asset("icons/reset.png") }}" alt=""> Resubmission already requested on ' + fmtDatePlain(now);
                }

                const idx = requests.findIndex(function(r) { return r.id === currentReq.id; });
                if (idx !== -1) requests[idx].resubmission_requested_at = now;

                showToast('Resubmission request sent to tenant.', 'success');
            } else {
                showToast('Failed to send resubmission request.', 'error');
            }
        })
        .catch(function() {
            closeResubmitConfirm();
            showToast('Network error. Please try again.', 'error');
        })
        .finally(function() {
            btn.textContent = 'Send Request';
            btn.disabled    = false;
        });
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
        var rows = [['Request ID','Date','Room','Tenant','Issue Type','Description','Urgency','Status','Remarks']];
        filtered.forEach(function(r) {
            rows.push([
                '#REQ-' + String(r.id).padStart(3,'0'),
                fmtDatePlain(r.created_at),
                r.room_number   || '',
                r.tenant_name   || '',
                r.issue_type    || '',
                r.description   || '',
                r.urgency       || '',
                r.status        || '',
                r.admin_remarks || '',
            ]);
        });
        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g,'""') + '"'; }).join(','); }).join('\n');
        var a = document.createElement('a');
        a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'maintenance_requests.csv';
        a.click();
    }

    function exportTablePDF() {
        var win = window.open('', '_blank');
        if (!win) { showToast('PDF export was blocked. Please allow popups for this site.', 'error'); return; }
        var rows = filtered.map(function(r) {
            return '<tr><td>#REQ-' + String(r.id).padStart(3,'0') + '</td><td>' + fmtDatePlain(r.created_at) + '</td><td>' + (r.room_number || '') + '</td><td>' + (r.tenant_name || '') + '</td><td>' + (r.issue_type || '') + '</td><td>' + (r.urgency || '') + '</td><td>' + (r.status || '') + '</td><td>' + (r.description || '') + '</td></tr>';
        }).join('');
        win.document.write('<!DOCTYPE html><html><head><title>Maintenance Requests</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style></head><body><h2>Sanctissimo Rosario Ladies Dormitory</h2><p>Maintenance Requests as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p><table><thead><tr><th>Request ID</th><th>Date</th><th>Room</th><th>Tenant</th><th>Issue Type</th><th>Urgency</th><th>Status</th><th>Description</th></tr></thead><tbody>' + rows + '</tbody></table></body></html>');
        win.document.close();
        win.print();
    }

    function openArchive() {
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        document.getElementById('acount-closed').textContent    = closedArchive.length;
        document.getElementById('acount-resolved').textContent  = resolvedArchive.length;
        document.getElementById('acount-cancelled').textContent = cancelledArchive.length;
        document.getElementById('acount-deleted').textContent   = deletedArchive.length;
        renderArchive();
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-closed').classList.toggle('active',     tab === 'closed');
        document.getElementById('atab-resolved').classList.toggle('active',   tab === 'resolved');
        document.getElementById('atab-cancelled').classList.toggle('active',  tab === 'cancelled');
        document.getElementById('atab-deleted').classList.toggle('active',    tab === 'deleted');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    var _archiveDebounce = null;

    function renderArchive() {
        clearTimeout(_archiveDebounce);
        _archiveDebounce = setTimeout(function() { _runRenderArchive(); }, 150);
    }

    function _runRenderArchive() {
        const q    = document.getElementById('archive-search').value.toLowerCase();
        const data = archiveTab === 'closed' ? closedArchive
                   : archiveTab === 'resolved' ? resolvedArchive
                   : archiveTab === 'cancelled' ? cancelledArchive
                   : deletedArchive;

        const archiveFiltered = data.filter(r =>
            ('#req-' + String(r.id).padStart(3,'0')).includes(q) ||
            (r.tenant_name ?? '').toLowerCase().includes(q) ||
            (r.room_number ?? '').toLowerCase().includes(q) ||
            (r.issue_type  ?? '').toLowerCase().includes(q) ||
            (r.description ?? '').toLowerCase().includes(q)
        );

        const list = document.getElementById('archive-list');
        document.getElementById('archive-count-label').textContent = `${archiveFiltered.length} record${archiveFiltered.length !== 1 ? 's' : ''}`;

        if (archiveFiltered.length === 0) {
            list.innerHTML = `<div class="archive-empty">
                <img class="archive-empty-icon" src="{{ asset('icons/maintenance.png') }}" alt="">
                No ${archiveTab === 'resolved' ? 'resolved' : archiveTab === 'cancelled' ? 'cancelled' : archiveTab} requests found.
            </div>`;
            return;
        }

        const urgencyPillClass = { urgent: 'archive-pill-urgent', moderate: 'archive-pill-moderate', low: 'archive-pill-low' };
        const archiveLabel = archiveTab === 'closed' ? 'Closed on'
                           : archiveTab === 'resolved' ? 'Resolved on'
                           : archiveTab === 'cancelled' ? 'Cancelled on'
                           : 'Deleted on';

        list.innerHTML = archiveFiltered.map((r, i) => `
            <div class="archive-card" style="animation-delay:${i * 0.04}s;">
                <div class="archive-card-top">
                    <div class="archive-card-id">#REQ-${String(r.id).padStart(3,'0')}</div>
                    <div class="archive-card-time">${fmtDatePlain(r.created_at)}</div>
                </div>
                <div class="archive-card-tenant">${escHtml(r.tenant_name ?? '—')}</div>
                <div class="archive-card-room">Room ${escHtml(r.room_number ?? '—')}</div>
                <div class="archive-card-meta">
                    <span class="archive-pill archive-pill-issue">${escHtml(r.status ?? 'pending')}</span>
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

    function exportArchive(format) {
        var data  = archiveTab === 'closed' ? closedArchive
                  : archiveTab === 'resolved' ? resolvedArchive
                  : archiveTab === 'cancelled' ? cancelledArchive
                  : deletedArchive;
        var label = archiveTab === 'closed' ? 'Closed On'
                  : archiveTab === 'resolved' ? 'Resolved On'
                  : archiveTab === 'cancelled' ? 'Cancelled On'
                  : 'Deleted On';

        if (format === 'pdf') {
            var win = window.open('', '_blank');
            if (!win) { showToast('PDF export was blocked. Please allow popups for this site.', 'error'); return; }
            var tabLabel = archiveTab === 'closed' ? 'Closed'
                         : archiveTab === 'resolved' ? 'Resolved'
                         : archiveTab === 'cancelled' ? 'Cancelled'
                         : 'Deleted';
            var rows = data.map(function(r) {
                return '<tr><td>#REQ-' + String(r.id).padStart(3,'0') + '</td><td>' + fmtDatePlain(r.created_at) + '</td><td>' + (r.room_number || '') + '</td><td>' + (r.tenant_name || '') + '</td><td>' + (r.issue_type || '') + '</td><td>' + (r.urgency || '') + '</td><td>' + (r.status || '') + '</td><td>' + fmtDatePlain(r.archived_at) + '</td></tr>';
            }).join('');
            win.document.write('<!DOCTYPE html><html><head><title>Maintenance Archive - ' + tabLabel + '</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style></head><body><h2>Maintenance Archive - ' + tabLabel + '</h2><p>Sanctissimo Rosario Ladies Dormitory - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p><table><thead><tr><th>Request ID</th><th>Submitted</th><th>Room</th><th>Tenant</th><th>Issue Type</th><th>Urgency</th><th>Status</th><th>' + label + '</th></tr></thead><tbody>' + rows + '</tbody></table></body></html>');
            win.document.close();
            win.print();
            return;
        }

        var rows = [['Request ID','Submitted','Room','Tenant','Issue Type','Description','Urgency','Status','Remarks', label]];
        data.forEach(function(r) {
            rows.push([
                '#REQ-' + String(r.id).padStart(3,'0'),
                fmtDatePlain(r.created_at),
                r.room_number   || '',
                r.tenant_name   || '',
                r.issue_type    || '',
                r.description   || '',
                r.urgency       || '',
                r.status        || '',
                r.admin_remarks || '',
                fmtDatePlain(r.archived_at),
            ]);
        });
        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g,'""') + '"'; }).join(','); }).join('\n');
        var a   = document.createElement('a');
        a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'maintenance_' + archiveTab + '_archive.csv';
        a.click();
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
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.export-dropdown')) {
            closeAllExportDropdowns();
        }
    });

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    const MAINT_POLL_INTERVAL = 30000;
    let requestsData = [...requests];

    function isAnyMaintModalOpen() {
        return document.querySelector('.modal-overlay.open') !== null ||
            document.getElementById('archive-drawer').classList.contains('open') ||
            document.getElementById('resubmit-confirm-overlay').classList.contains('open');
    }

    function showMaintPollToast() {
        const existing = document.getElementById('maint-poll-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'maint-poll-toast';
        toast.style.cssText = `
            position:fixed;bottom:1.2rem;left:50%;transform:translateX(-50%);
            background:var(--white);border:1.5px solid var(--baby-pink);
            border-radius:10px;padding:.45rem 1rem;font-size:.78rem;font-weight:600;
            color:var(--ink-muted);box-shadow:0 4px 16px rgba(232,23,93,.1);
            z-index:2000;opacity:0;transition:opacity .3s;white-space:nowrap;
            pointer-events:none;
        `;
        toast.textContent = 'Data refreshed';
        document.body.appendChild(toast);
        requestAnimationFrame(() => { toast.style.opacity = '1'; });
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

    async function pollMaintRequests() {
        if (isAnyMaintModalOpen()) return;

        const activeEl = document.activeElement;

        try {
            const res = await fetch('/maintenance/poll/requests', {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const fresh = await res.json();

            const prevIds = new Set(requestsData.map(r => r.id));
            const freshIds = new Set(fresh.map(r => r.id));

            const hasChanges =
                fresh.length !== requestsData.length ||
                fresh.some(r => {
                    const old = requestsData.find(o => o.id === r.id);
                    return !old || old.status !== r.status || old.urgency !== r.urgency;
                }) ||
                [...prevIds].some(id => !freshIds.has(id));

            if (!hasChanges) return;

            requestsData = fresh;
            _rowDataMap = {};
            fresh.forEach(r => { _rowDataMap[r.id] = r; });

            applyFilters();
            showMaintPollToast();

            if (activeEl && activeEl.id) {
                const refocus = document.getElementById(activeEl.id);
                if (refocus && refocus !== document.activeElement) refocus.focus();
            }
        } catch {
        }
    }

    setInterval(pollMaintRequests, MAINT_POLL_INTERVAL);

    applyFilters();

    (function() {
        var popup = document.querySelector('.maint-legend-popup');
        if (!popup) return;

        document.body.appendChild(popup);
        popup.style.display = 'none';
        popup.style.position = 'fixed';
        popup.style.zIndex = '9999';

        var hideTimer = null;
        var popupWidth = 380;

        document.querySelectorAll('.maint-legend-wrap').forEach(function(wrap) {
            wrap.addEventListener('mouseenter', function() {
                clearTimeout(hideTimer);
                popup.style.visibility = 'hidden';
                popup.style.display = 'block';
                var rect = wrap.getBoundingClientRect();
                var popupH = popup.offsetHeight || 260;
                popup.style.display = 'none';
                popup.style.visibility = '';

                var left = rect.left;
                if (left + popupWidth > window.innerWidth - 12) {
                    left = window.innerWidth - popupWidth - 12;
                }
                if (left < 8) left = 8;

                var spaceBelow = window.innerHeight - rect.bottom;
                var top;
                if (spaceBelow >= popupH + 10) {
                    top = rect.bottom + 8;
                } else {
                    top = rect.top - popupH - 8;
                    if (top < 8) top = 8;
                }

                popup.style.top = top + 'px';
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

    function validateEditMaintForm(e) {
        var status  = document.getElementById('edit-status').value;
        var urgency = document.getElementById('edit-urgency').value;
        if (!status || !urgency) {
            e.preventDefault();
            e.stopImmediatePropagation();
            showToast('Please select a status and urgency before saving.', 'error');
            return false;
        }
        return true;
    }
    function clearDates() {
        document.getElementById('date-from').value = '';
        document.getElementById('date-to').value   = '';
        document.getElementById('date-from').style.borderColor = '';
        document.getElementById('date-to').style.borderColor   = '';
        document.getElementById('date-error').style.display    = 'none';
        document.getElementById('date-clear-btn').style.display = 'none';
        applyFilters();
    }

    function typeOptionsHtml(selected) {
        return ISSUE_TYPE_OPTIONS.map(function(t) {
            return '<option value="' + escHtml(t.toLowerCase()) + '"' + (t.toLowerCase() === (selected || '').toLowerCase() ? ' selected' : '') + '>' + escHtml(t) + '</option>';
        }).join('');
    }

    function urgencyOptionsHtml(selected) {
        const opts = [['', 'Use type default'], ['low', 'Low'], ['moderate', 'Moderate'], ['urgent', 'Urgent']];
        return opts.map(function(o) {
            return '<option value="' + o[0] + '"' + (o[0] === (selected || '') ? ' selected' : '') + '>' + o[1] + '</option>';
        }).join('');
    }

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

    function openKeywordModal() {
        kwActiveTab = 'pending';
        document.getElementById('kwtab-pending').classList.add('active');
        document.getElementById('kwtab-trained').classList.remove('active');
        document.getElementById('kwtab-reference').classList.remove('active');
        document.getElementById('kw-add-btn').classList.remove('visible');
        document.getElementById('kw-search').value = '';
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
        renderKwList();
    }

    let kwSummaryOpen = false;

    function toggleKwSummary() {
        kwSummaryOpen = !kwSummaryOpen;
        document.getElementById('kw-summary-bar').classList.toggle('open', kwSummaryOpen);
    }

    function renderKwSummary() {
        const refCount = Object.values(hardcodedRules.issue_rules || {}).reduce(function(sum, rule) {
            return sum + (rule.keywords ? rule.keywords.length : 0);
        }, 0);
        const trainedCount = trainedKeywords.length;
        const totalCount = refCount + trainedCount;
        const builtinPct = totalCount === 0 ? 50 : (refCount / totalCount) * 100;
        const trainedPct = totalCount === 0 ? 50 : 100 - builtinPct;

        document.getElementById('kw-summary-toggle-text').innerHTML =
            '<strong>' + refCount + '</strong> built-in + <strong>' + trainedCount + '</strong> trained = <strong>' + totalCount + '</strong> active keyword rules';

        document.getElementById('kw-summary-split').innerHTML =
            '<div class="kw-summary-split-builtin" style="width:' + builtinPct + '%;"></div>' +
            '<div class="kw-summary-split-trained" style="width:' + trainedPct + '%;"></div>';

        document.getElementById('kw-summary-rows').innerHTML =
            '<div class="kw-summary-row"><span class="kw-summary-row-label"><span class="kw-summary-dot builtin"></span>Built-in rules</span><span class="kw-summary-row-val">' + refCount + '</span></div>' +
            '<div class="kw-summary-row"><span class="kw-summary-row-label"><span class="kw-summary-dot trained"></span>Trained by your team</span><span class="kw-summary-row-val">' + trainedCount + '</span></div>';

        return refCount;
    }

    function renderKwList() {
        document.getElementById('kwcount-pending').textContent = pendingTerms.length;
        document.getElementById('kwcount-trained').textContent = trainedKeywords.length;
        const refCount = renderKwSummary();
        document.getElementById('kwcount-reference').textContent = refCount;
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
        const q = (document.getElementById('kw-search').value || '').trim().toLowerCase();
        const rules = hardcodedRules.issue_rules || {};
        const types = Object.keys(rules);

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
                '<span class="kw-ref-group-title">' + escHtml(type.charAt(0).toUpperCase() + type.slice(1)) + '</span>' +
                '<span class="kw-urgency-pill ' + escHtml(rule.priority || 'low') + '">' + escHtml(rule.priority || 'low') + '</span>' +
                '</div>' +
                '<div class="kw-ref-chip-wrap">' + chips + '</div>' +
                '</div>';
        }).filter(Boolean).join('');

        if (!groupsHtml) {
            list.innerHTML = '<div class="kw-empty">No built-in keywords match your search.</div>';
            return;
        }

        list.innerHTML = '' +
            '<div class="kw-ref-note">These are hardcoded in the system and cannot be edited or removed here. They take priority when no trained keyword matches the same phrase.</div>' +
            groupsHtml;
    }

    function renderPendingTerms() {
        const list = document.getElementById('kw-list');
        const q = (document.getElementById('kw-search').value || '').trim().toLowerCase();
        const visible = pendingTerms.filter(function(t) {
            return !q || (t.description_snapshot || '').toLowerCase().includes(q);
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
                '<div><span class="kw-field-label">Issue type</span><select id="kw-type-' + term.id + '">' + typeOptionsHtml('other') + '</select></div>' +
                '<div><span class="kw-field-label">Urgency override</span><select id="kw-urgency-' + term.id + '">' + urgencyOptionsHtml('') + '</select></div>' +
                '</div>' +
                '<label class="kw-checkbox-row"><input type="checkbox" id="kw-reclassify-' + term.id + '"> Also reclassify matching past requests still marked Other</label>' +
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
        let warning = '';
        let isHardBlock = false;

        if (value.length === 0) {
            error = '';
        } else if (value.length < 2) {
            error = 'Phrase must contain at least 2 characters';
            isHardBlock = true;
        } else if (!/[a-zA-Z0-9]/.test(value)) {
            error = 'Phrase must contain at least one letter or number';
            isHardBlock = true;
        } else {
            const dupTrained = trainedKeywords.find(function(k) {
                return k.keyword.toLowerCase() === value.toLowerCase() && k.id !== excludeId;
            });
            if (dupTrained) {
                const urgencyLabel = dupTrained.urgency_level
                    ? dupTrained.urgency_level.charAt(0).toUpperCase() + dupTrained.urgency_level.slice(1)
                    : 'default urgency';
                error = 'Already trained as ' + dupTrained.issue_type + ' / ' + urgencyLabel + '. Edit the existing entry instead.';
                isHardBlock = true;
            } else {
                const builtinMatch = findBuiltinMatch(value);
                if (builtinMatch) {
                    const urgencyLabel = builtinMatch.urgency.charAt(0).toUpperCase() + builtinMatch.urgency.slice(1);
                    warning = 'Covered by built-in rule for ' + builtinMatch.type + ' at ' + urgencyLabel + '. Your keyword will take priority.';
                }
            }
        }

        if (msg) {
            if (error) {
                msg.textContent = error;
                msg.className = 'kw-validation-msg error';
            } else if (warning) {
                msg.textContent = warning;
                msg.className = 'kw-validation-msg warning';
            } else {
                msg.textContent = '';
                msg.className = 'kw-validation-msg';
            }
        }

        if (saveBtn) saveBtn.disabled = value.length === 0 || isHardBlock;
    }

    function findBuiltinMatch(value) {
        const rules = hardcodedRules.issue_rules || {};
        const lower = value.toLowerCase();
        for (const type in rules) {
            if (type === 'other') continue;
            const rule = rules[type];
            if ((rule.keywords || []).some(function(k) { return k.toLowerCase() === lower; })) {
                return { type: type, urgency: rule.priority || 'low' };
            }
        }
        return null;
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
        if (!keyword || keyword.length < 2) {
            showToast('Select or type a valid phrase first.', 'error');
            return;
        }
        const saveBtn = document.querySelector('#kw-card-' + termId + ' .kw-btn-save');
        const type = document.getElementById('kw-type-' + termId).value;
        const urgency = document.getElementById('kw-urgency-' + termId).value;
        const reclassify = document.getElementById('kw-reclassify-' + termId).checked;

        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving...'; }
        showActionLoading('Saving keyword...');
        try {
            const res = await fetch('/maintenance/terms/' + termId + '/classify', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    keyword: keyword,
                    issue_type: type,
                    urgency_level: urgency || null,
                    reclassify_matching: reclassify,
                }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Keyword saved' + (data.reclassified_count > 0 ? ' and ' + data.reclassified_count + ' request(s) reclassified' : ''), 'success');
                pendingTerms = pendingTerms.filter(function(t) { return t.id !== termId; });
                delete kwPhraseState[termId];
                trainedKeywords.unshift(data.keyword);
                renderKwList();
            } else {
                const errMsg = extractErrorMessage(data, 'Failed to save keyword.');
                if (data.existing_keyword) {
                    const ek = data.existing_keyword;
                    const urgencyLabel = ek.urgency_level
                        ? ek.urgency_level.charAt(0).toUpperCase() + ek.urgency_level.slice(1)
                        : 'default urgency';
                    showToast('Already trained as ' + ek.issue_type + ' / ' + urgencyLabel + '. Edit the existing entry instead.', 'error');
                    highlightTrainedKeyword(ek.id);
                } else {
                    showToast(errMsg, 'error');
                }
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
            const res = await fetch('/maintenance/terms/' + termId + '/ignore', {
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
        const q = (document.getElementById('kw-search').value || '').trim().toLowerCase();
        const visible = trainedKeywords.filter(function(k) {
            return !q || k.keyword.toLowerCase().includes(q) || k.issue_type.toLowerCase().includes(q);
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
                '<span class="kw-type-pill">' + escHtml(kw.issue_type) + '</span>' +
                (kw.urgency_level ? '<span class="kw-urgency-pill ' + urgencyClass + '">' + escHtml(kw.urgency_level) + '</span>' : '') +
                '</div>' +
                '<div class="kw-trained-audit">Added by ' + escHtml(addedBy) + (addedAt ? ' on ' + escHtml(addedAt) : '') + '</div>' +
                '</div>' +
                '<div class="kw-trained-actions">' +
                '<button class="action-btn" title="Edit" onclick="editKwKeyword(' + kw.id + ')"><img src="' + kwEditIcon + '" alt="Edit"></button>' +
                '<button class="action-btn" title="Delete" onclick="deleteKwKeyword(' + kw.id + ')"><img src="' + kwDeleteIcon + '" alt="Delete"></button>' +
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
            '<input type="text" class="kw-phrase-input" id="kw-add-phrase" placeholder="Type the phrase, e.g. tagas ng tubo" oninput="validateKwPhraseInput(\'kw-add-phrase\', \'kw-add-counter\', \'kw-add-msg\', \'#kw-add-new .kw-btn-save\', null)">' +
            '</div>' +
            '<div class="kw-validation-row"><span class="kw-char-counter" id="kw-add-counter">0/255</span><span class="kw-validation-msg" id="kw-add-msg"></span></div>' +
            '<div class="kw-card-row">' +
            '<div><span class="kw-field-label">Issue type</span><select id="kw-add-type">' + typeOptionsHtml('other') + '</select></div>' +
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
        if (!keyword || keyword.length < 2) {
            showToast('Type a valid phrase first.', 'error');
            return;
        }
        const saveBtn = document.querySelector('#kw-add-new .kw-btn-save');
        const type = document.getElementById('kw-add-type').value;
        const urgency = document.getElementById('kw-add-urgency').value;

        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving...'; }
        showActionLoading('Saving keyword...');
        try {
            const res = await fetch('/maintenance/keywords', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ keyword: keyword, issue_type: type, urgency_level: urgency || null }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                trainedKeywords.unshift(data.keyword);
                document.getElementById('kw-add-form-wrap').innerHTML = '';
                showToast('Keyword added.', 'success');
                renderKwList();
            } else {
                const errMsg = extractErrorMessage(data, 'Failed to add keyword.');
                if (data.existing_keyword) {
                    const ek = data.existing_keyword;
                    const urgencyLabel = ek.urgency_level
                        ? ek.urgency_level.charAt(0).toUpperCase() + ek.urgency_level.slice(1)
                        : 'default urgency';
                    showToast('Already trained as ' + ek.issue_type + ' / ' + urgencyLabel + '. Edit the existing entry instead.', 'error');
                    highlightTrainedKeyword(ek.id);
                } else {
                    showToast(errMsg, 'error');
                }
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
            '<select id="kw-edit-type-' + id + '">' + typeOptionsHtml(kw.issue_type) + '</select>' +
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
        if (!keyword || keyword.length < 2) {
            showToast('Keyword must be at least 2 characters.', 'error');
            return;
        }
        const saveBtn = document.querySelector('#kw-trained-' + id + ' .kw-btn-save');
        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving...'; }
        showActionLoading('Updating keyword...');
        try {
            const res = await fetch('/maintenance/keywords/' + id, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ keyword: keyword, issue_type: type, urgency_level: urgency || null }),
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

    function highlightTrainedKeyword(id) {
        switchKwTab('trained');
        setTimeout(function() {
            const card = document.getElementById('kw-trained-' + id);
            if (!card) return;
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            card.style.transition = 'box-shadow .2s, border-color .2s';
            card.style.borderColor = 'var(--bright-pink)';
            card.style.boxShadow = '0 0 0 3px rgba(232,23,93,.25)';
            setTimeout(function() {
                card.style.borderColor = '';
                card.style.boxShadow = '';
            }, 2500);
        }, 320);
    }

    async function deleteKwKeyword(id) {
        const kw = trainedKeywords.find(function(k) { return k.id === id; });
        const label = kw ? kw.keyword : 'this keyword';
        if (!window.confirm('Delete trained keyword "' + label + '"? This cannot be undone.')) {
            return;
        }
        showActionLoading('Deleting keyword...');
        try {
            const res = await fetch('/maintenance/keywords/' + id, {
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
