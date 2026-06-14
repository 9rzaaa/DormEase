@extends('layout')

@section('title', 'DormEase: Manage Staff')
@section('page-title', 'Manage Staff')

@section('styles')
<style>
    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--black); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--hot-pink); margin-top: .2rem; }
    .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .5rem; flex-wrap: wrap; }

    .btn-primary {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--gradient-pink); color: var(--white);
        border: none; font-size: .87rem; font-weight: 600;
        box-shadow: var(--shadow-pink-btn);
        transition: opacity .2s, transform .15s; cursor: pointer;
        white-space: nowrap;
    }
    .btn-primary:hover { opacity: .88; transform: translateY(-1px); }
    .btn-outline {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--ink-muted);
        border: 1.5px solid var(--gray-light); font-size: .87rem; font-weight: 600;
        transition: border-color .2s, color .2s; cursor: pointer;
        white-space: nowrap;
    }
    .btn-outline:hover { border-color: var(--hot-pink); color: var(--hot-pink); }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
    .stat-box {
        background: var(--gradient-pink);
        border-radius: 20px;
        border: none;
        box-shadow: var(--shadow-stats);
        padding: 1.6rem 1.8rem;
        display: flex; align-items: center; gap: 1.4rem;
        box-sizing: border-box; min-width: 0; overflow: hidden;
    }
    .stat-box:hover { box-shadow: var(--shadow-pink-card); }
    .stat-icon-circle {
        width: 72px; height: 72px; border-radius: 50%;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; border: 2px solid var(--white);
    }
    .stat-icon-circle img {
        width: 34px; height: 34px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(11%) sepia(93%) saturate(6000%) hue-rotate(327deg) brightness(95%);
    }
    .stat-num   { font-size: 2.2rem; font-weight: 700; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; color: var(--white); font-weight: 700; margin-top: .2rem; }
    .stat-sub   { font-size: .76rem; color: var(--white); font-weight: 500; margin-top: .15rem; }

    .table-card {
        background: var(--white);
        border-radius: 18px;
        border: 1px solid var(--bright-pink);
        box-shadow: 0 2px 16px rgba(232,23,93,.07);
        overflow: hidden;
    }

    .table-header {
        padding: 1.1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        background: var(--white); flex-wrap: wrap; gap: .8rem;
        border-bottom: 1px solid var(--bright-pink);
    }
    .table-title { font-size: 1rem; font-weight: 800; color: var(--ink); }
    .table-date  { font-size: .75rem; color: var(--ink-muted); margin-top: .15rem; }

    .table-controls { display: flex; align-items: center; gap: .6rem; flex-wrap: nowrap; }

    .search-wrap { position: relative; flex-shrink: 0; }
    .search-wrap input {
        padding: .45rem .85rem; border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        font-family: var(--ff-body); font-size: .82rem; font-weight: 600;
        width: 190px; background: var(--white); color: var(--ink);
        outline: none; transition: box-shadow .2s, border-color .2s;
        box-shadow: 0 2px 8px rgba(232,23,93,.05);
    }
    .search-wrap input:focus { border-color: var(--bright-pink); box-shadow: 0 2px 8px rgba(232,23,93,.08); }
    .search-wrap input::placeholder { color: var(--gray); }

    .sort-select {
        padding: .45rem 1.8rem .45rem .75rem; border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white); font-family: var(--ff-body);
        font-size: .82rem; font-weight: 600; color: var(--ink);
        outline: none; cursor: pointer; transition: border-color .2s;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .6rem center;
        box-shadow: 0 2px 8px rgba(232,23,93,.05);
    }
    .sort-select:focus { border-color: var(--bright-pink); }
    .sort-select option { color: var(--black); background: var(--white); }

    .filter-divider { width: 1px; height: 20px; background: var(--baby-pink); flex-shrink: 0; }
    .filter-label { font-size: .82rem; font-weight: 700; color: var(--ink-muted); white-space: nowrap; }
    .status-legend-wrap { position: relative; display: inline-flex; align-items: center; cursor: pointer; flex-shrink: 0; }
    .status-legend-wrap img { display: block; opacity: .75; transition: opacity .2s; }
    .status-legend-wrap:hover img { opacity: 1; }
    .status-legend-popup {
        display: none;
        position: fixed;
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 14px;
        box-shadow: 0 12px 32px rgba(232,23,93,.15), 0 2px 8px rgba(0,0,0,.08);
        padding: .8rem .9rem;
        width: 320px;
        max-width: calc(100vw - 24px);
        z-index: 99999;
    }
    .status-legend-popup.open { display: block; }
    .slg-title { font-size: .67rem; font-weight: 800; color: var(--bright-pink); text-transform: uppercase; letter-spacing: .08em; margin-bottom: .5rem; padding-bottom: .35rem; border-bottom: 1.5px solid var(--petal); }
    .slg-title.second { margin-top: .65rem; }
    .slg-row { display: flex; align-items: flex-start; gap: .6rem; padding: .32rem 0; border-bottom: 1px solid var(--baby-pink); }
    .slg-row:last-child { border-bottom: none; }
    .slg-row .badge { flex-shrink: 0; width: 92px; justify-content: center; text-align: center; white-space: nowrap; }
    .slg-desc { font-size: .75rem; color: var(--ink-muted); font-weight: 500; line-height: 1.45; padding-top: .12rem; }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; table-layout: fixed; min-width: 980px; }
    th {
        padding: .75rem .85rem;
        text-align: center;
        font-size: .78rem;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        white-space: nowrap;
        background: var(--blush);
        border-bottom: 1px solid var(--bright-pink);
    }
    td {
        padding: .8rem .85rem;
        font-size: .875rem;
        color: var(--ink);
        vertical-align: middle;
        text-align: center;
    }
    tbody tr { border-bottom: 2px solid var(--baby-pink); transition: background .15s; }
    tbody tr:hover { background: #fff7fb; }
    tbody tr:last-child { border-bottom: none; }
    .td-name { font-weight: 600; }
    .td-id   { color: var(--ink-muted); font-size: .82rem; font-family: monospace; }

    .badge { display: inline-flex; align-items: center; justify-content: center; padding: .28rem .75rem; border-radius: 7px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
    .badge-onduty    { background: var(--mint); color: var(--green); border: 1.5px solid var(--green); }
    .badge-offduty   { background: var(--blush); color: var(--red); border: 1.5px solid var(--baby-pink); }
    .badge-leave     { background: var(--peach); color: var(--badge-leave-text); border: 1.5px solid var(--badge-leave-border); }
    .badge-admin     { background: var(--petal); color: var(--hot-pink); border: 1.5px solid var(--baby-pink); }
    .badge-frontdesk { background: var(--gray-light); color: var(--badge-frontdesk-text); border: 1.5px solid var(--badge-frontdesk-border); }
    .badge-staff     { background: var(--mint); color: var(--green); border: 1.5px solid var(--green); }

    .action-group { display: flex; align-items: center; justify-content: center; gap: .4rem; }
    .act-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1px solid var(--baby-pink); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: .2s;
    }
    .act-btn:hover        { border-color: var(--bright-pink); box-shadow: 0 6px 14px rgba(232,23,93,.15); }
    .act-btn.delete:hover { border-color: var(--red); box-shadow: 0 6px 14px rgba(224,72,103,.15); }
    .act-btn.toggle:hover { border-color: var(--badge-leave-border); box-shadow: 0 6px 14px rgba(240,192,64,.18); }

    .icon-sm { width: 16px; height: 16px; object-fit: contain; }
    .icon-md { width: 28px; height: 28px; object-fit: contain; }

    .table-footer {
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid var(--border); flex-wrap: wrap; gap: .5rem;
    }
    .table-showing { font-size: .8rem; color: var(--ink-muted); }
    .pagination { display: flex; align-items: center; gap: .35rem; }
    .page-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        font-size: .83rem; font-weight: 600; color: var(--ink-muted);
        cursor: pointer; transition: border-color .2s, background .2s, color .2s;
        display: flex; align-items: center; justify-content: center;
    }
    .page-btn:hover  { border-color: var(--hot-pink); color: var(--hot-pink); }
    .page-btn.active { background: var(--gradient-pink); color: var(--white); border-color: var(--hot-pink); }
    .page-btn:disabled { opacity: .4; cursor: default; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(26,26,46,.45); backdrop-filter: blur(4px); z-index: 300; display: none; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal { background: var(--white); border-radius: 20px; padding: 2rem; width: 90%; max-width: 480px; box-shadow: var(--shadow-pink-modal); animation: fadeUp .3s ease; max-height: 90vh; overflow-y: auto; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
    .modal-title  { font-size: 1.15rem; font-weight: 700; color: var(--ink); }
    .modal-close  { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); transition: color .2s; }
    .modal-close:hover { color: var(--red); }

    .modal-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field { margin-bottom: 0; }
    .modal-field.full { grid-column: 1/-1; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .35rem; }
    .modal-field input, .modal-field select {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: var(--soft-bg); outline: none;
        transition: border-color .2s; box-sizing: border-box;
    }
    .modal-field input:focus, .modal-field select:focus { border-color: var(--hot-pink); background: var(--white); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.5rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-cancel:hover { border-color: var(--hot-pink); color: var(--hot-pink); }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--gradient-pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-pink-btn); transition: opacity .2s; }
    .btn-submit:hover { opacity: .88; }

    .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; }
    .view-val   { font-weight: 600; color: var(--ink); }

    .delete-warning { background: var(--blush); border: 1px solid var(--baby-pink); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--red); line-height: 1.6; }

    .credentials-box { background: var(--petal); border: 1.5px solid var(--baby-pink); padding: 1rem; border-radius: 14px; margin-bottom: 1rem; }
    .credentials-box h4 { margin-bottom: .8rem; color: var(--hot-pink); font-size: .95rem; }
    .credential-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: .7rem; }
    .credential-row:last-child { margin-bottom: 0; }
    .credential-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
    .credential-value { font-weight: 700; font-family: monospace; color: var(--ink); font-size: .95rem; }
    .copy-btn { padding: .3rem .8rem; border-radius: 7px; border: 1.5px solid var(--baby-pink); background: var(--white); color: var(--hot-pink); font-weight: 600; cursor: pointer; font-size: .8rem; transition: background .2s, color .2s; }
    .copy-btn:hover { background: var(--hot-pink); color: var(--white); }
    .credentials-warning { background: var(--blush); border: 1px solid var(--baby-pink); padding: .8rem; border-radius: 10px; font-size: .8rem; color: var(--red); margin-bottom: 1rem; }

    .reset-staff-card { background: var(--petal); border-radius: 12px; padding: 1rem; margin-bottom: 1.1rem; display: flex; align-items: center; gap: 12px; }
    .reset-staff-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--baby-pink); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; color: var(--hot-pink); flex-shrink: 0; border: 2px solid var(--baby-pink); }
    .reset-staff-name { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .reset-staff-meta { font-size: .78rem; color: var(--ink-muted); }
    .reset-warning-box { background: var(--petal); border: 1px solid var(--bright-pink); border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1.25rem; display: flex; gap: 10px; align-items: flex-start; }
    .reset-warning-box p { font-size: .82rem; color: var(--bright-pink); margin: 0; line-height: 1.55; }

    .shift-dot { display: inline-flex; align-items: center; gap: .4rem; }
    .shift-dot::before { content: ''; width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .shift-dot.day::before   { background: var(--shift-day); }
    .shift-dot.night::before { background: var(--shift-night); }

    .staff-archive-drawer {
        position: fixed;
        top: 0; right: 0; bottom: 0;
        width: min(660px, 100vw);
        background: var(--soft-bg);
        z-index: 500;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(214,51,117,.15);
    }

    .staff-archive-drawer.open { transform: translateX(0); }

    .staff-archive-backdrop {
        position: fixed; inset: 0;
        background: rgba(232,23,93,.18);
        backdrop-filter: blur(3px);
        z-index: 499;
        opacity: 0; pointer-events: none;
        transition: opacity .38s ease;
    }

    .staff-archive-backdrop.open { opacity: 1; pointer-events: auto; }

    .sad-header {
        padding: 1.6rem 1.8rem 1.2rem;
        border-bottom: 1px solid var(--pink-100);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-shrink: 0;
    }

    .sad-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .sad-sub {
        font-size: .78rem;
        color: var(--ink-muted);
        margin-top: .25rem;
        font-weight: 500;
    }

    .sad-close {
        width: 34px; height: 34px;
        border-radius: 8px;
        border: 1px solid var(--pink-100);
        background: var(--petal);
        color: var(--bright-pink);
        font-size: 1rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, color .2s;
        flex-shrink: 0;
    }

    .sad-close:hover { background: var(--pink-100); color: var(--hot-pink); }

    .sad-tabs {
        display: flex;
        gap: 0;
        padding: 0 1.8rem;
        border-bottom: 1px solid var(--pink-100);
        flex-shrink: 0;
        background: var(--white);
    }

    .sad-tab {
        padding: .85rem 1.1rem;
        font-size: .82rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: none;
        border: none;
        border-bottom: 2.5px solid transparent;
        margin-bottom: -1px;
        cursor: pointer;
        transition: color .2s, border-color .2s;
        display: flex;
        align-items: center;
        gap: .45rem;
        letter-spacing: .01em;
        font-family: var(--ff-body);
        white-space: nowrap;
    }

    .sad-tab:hover { color: var(--hot-pink); }
    .sad-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

    .sad-tab-count {
        font-size: .68rem;
        font-weight: 800;
        padding: .1rem .45rem;
        border-radius: 99px;
        background: var(--petal);
        color: var(--ink-muted);
        letter-spacing: .02em;
        min-width: 18px;
        text-align: center;
    }

    .sad-tab.active .sad-tab-count { background: var(--bright-pink); color: var(--white); }

    .sad-search-bar {
        padding: 1rem 1.8rem .8rem;
        flex-shrink: 0;
    }

    .sad-search-inner {
        position: relative;
        display: flex;
        align-items: center;
    }

    .sad-search-inner input {
        width: 100%;
        padding: .55rem .9rem .55rem 2.2rem;
        border-radius: 10px;
        border: 1px solid var(--pink-100);
        background: var(--white);
        color: var(--ink);
        font-size: .83rem;
        font-family: var(--ff-body);
        outline: none;
        transition: border-color .2s, background .2s;
        box-sizing: border-box;
    }

    .sad-search-inner input::placeholder { color: var(--ink-muted); }
    .sad-search-inner input:focus { border-color: var(--bright-pink); background: var(--blush); }

    .sad-search-icon {
        position: absolute; left: .75rem;
        width: 13px; height: 13px;
        opacity: .5; pointer-events: none;
    }

    .sad-list {
        flex: 1;
        overflow-y: auto;
        padding: 0 1.8rem 1.8rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .sad-list::-webkit-scrollbar { width: 4px; }
    .sad-list::-webkit-scrollbar-track { background: transparent; }
    .sad-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

    .sad-card {
        background: var(--white);
        border: 1px solid var(--pink-100);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s;
        animation: sadSlideIn .3s ease both;
    }

    @keyframes sadSlideIn {
        from { opacity: 0; transform: translateX(12px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .sad-card:hover { background: var(--blush); border-color: var(--bright-pink); }

    .sad-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .8rem;
        margin-bottom: .5rem;
    }

    .sad-card-id {
        font-size: .75rem;
        font-weight: 800;
        color: var(--bright-pink);
        letter-spacing: .02em;
        font-family: monospace;
    }

    .sad-card-time {
        font-size: .7rem;
        color: var(--ink-muted);
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .sad-card-name {
        font-size: .9rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.3;
    }

    .sad-card-email {
        font-size: .73rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .sad-card-meta {
        display: flex;
        align-items: center;
        gap: .45rem;
        margin-top: .6rem;
        flex-wrap: wrap;
    }

    .sad-pill {
        font-size: .68rem;
        font-weight: 700;
        padding: .18rem .55rem;
        border-radius: 99px;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    .sad-pill-role     { background: var(--petal);   color: var(--hot-pink);  border: 1px solid var(--baby-pink); }
    .sad-pill-shift    { background: var(--pink-100); color: var(--hot-pink);  border: 1px solid var(--pink-200); }
    .sad-pill-onduty   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
    .sad-pill-offduty  { background: var(--blush); color: var(--red); border: 1px solid var(--baby-pink); }
    .sad-pill-onleave  { background: var(--peach); color: var(--badge-leave-text); border: 1px solid var(--badge-leave-border); }
    .sad-pill-inactive { background: var(--blush); color: var(--ink-muted); border: 1px solid var(--pink-100); }

    .sad-card-archived {
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

    .sad-card-archived span { color: var(--bright-pink); font-weight: 600; }

    .sad-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
    }

    .sad-empty-icon {
        width: 40px; height: 40px;
        margin: 0 auto .75rem;
        opacity: .3;
        display: block;
    }

    .sad-footer {
        padding: .9rem 1.8rem;
        border-top: 1px solid var(--pink-100);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .sad-count-label {
        font-size: .75rem;
        color: var(--ink-muted);
        font-weight: 600;
    }

    .sad-export-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .75rem;
        font-weight: 700;
        color: var(--bright-pink);
        background: var(--petal);
        border: 1px solid var(--pink-100);
        border-radius: 8px;
        padding: .35rem .85rem;
        cursor: pointer;
        transition: background .2s, color .2s, border-color .2s;
        font-family: var(--ff-body);
    }

    .sad-export-btn:hover { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
    .sad-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .7; }

    @keyframes fadeIn { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
    .fade-up { animation: fadeIn .45s ease both; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.2s;}

    @media(max-width:900px) {
        .stats-row  { grid-template-columns: 1fr 1fr; }
        .modal-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; gap: 1rem; }
        .table-header { flex-direction: column; align-items: flex-start; }
        .table-controls { flex-wrap: wrap; }
        .search-wrap input { width: 150px; }
        .sad-header { padding: 1.2rem 1rem .9rem; }
        .sad-list { padding: 0 1rem 1.2rem; }
        .sad-search-bar { padding: .8rem 1rem .6rem; }
        .sad-footer { padding: .75rem 1rem; }
        .sad-tabs { padding: 0 1rem; }
        .sad-tab { padding: .75rem .75rem; font-size: .76rem; }
    }
    @media(max-width:600px) {
        .stats-row { grid-template-columns: 1fr; }
        .header-actions { width: 100%; }
        .header-actions .btn-primary,
        .header-actions .btn-outline { flex: 1; justify-content: center; }
        .table-controls { flex-direction: column; align-items: stretch; }
        .search-wrap { width: 100%; }
        .search-wrap input { width: 100%; }
        .sort-select { width: 100%; }
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

    .atd-pill-onduty  { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
    .atd-pill-offduty { background: var(--blush); color: var(--red); border: 1px solid var(--baby-pink); }

    .atd-duration {
        font-size: .72rem;
        font-weight: 600;
        color: var(--ink-muted);
        background: var(--blush);
        border: 1px solid var(--pink-100);
        border-radius: 99px;
        padding: .15rem .55rem;
        white-space: nowrap;
    }

    .atd-date-divider {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .35rem 0 .1rem;
        position: sticky;
        top: 0;
        background: var(--soft-bg);
        z-index: 2;
    }

    .atd-date-label {
        font-size: .72rem;
        font-weight: 800;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
        background: var(--petal);
        border: 1px solid var(--pink-100);
        border-radius: 99px;
        padding: .2rem .75rem;
    }

    .atd-date-line {
        flex: 1;
        height: 1px;
        background: var(--pink-100);
    }

    .atd-day-count {
        font-size: .68rem;
        font-weight: 700;
        color: var(--ink-muted);
        white-space: nowrap;
    }

    .atd-filter-bar {
        display: flex;
        gap: .5rem;
        padding: .6rem 1.8rem .2rem;
        flex-shrink: 0;
        flex-wrap: wrap;
        align-items: center;
    }

    .atd-filter-select {
        padding: .38rem 1.6rem .38rem .65rem;
        border-radius: 8px;
        border: 1px solid var(--pink-100);
        background: var(--white);
        font-family: var(--ff-body);
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .5rem center;
        transition: border-color .2s;
    }

    .atd-filter-select:focus { border-color: var(--bright-pink); }

    .atd-card-login-time {
        font-size: .72rem;
        color: var(--ink-muted);
        font-weight: 500;
        margin-top: .55rem;
        padding-top: .55rem;
        border-top: 1px solid var(--pink-100);
        display: flex;
        gap: 1.2rem;
        flex-wrap: wrap;
    }

    .atd-card-login-time span { color: var(--bright-pink); font-weight: 600; }

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--gray-light); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
    .export-menu button:hover { background: var(--blush); color: var(--hot-pink); }

    .atdlog-backdrop {
        position: fixed; inset: 0;
        background: rgba(232,23,93,.18);
        z-index: 499;
        opacity: 0; pointer-events: none;
        transition: opacity .38s ease;
    }
    .atdlog-backdrop.open { opacity: 1; pointer-events: auto; }

    .atdlog-drawer {
        position: fixed;
        top: 0; right: 0; bottom: 0;
        width: min(700px, 100vw);
        background: var(--soft-bg);
        z-index: 500;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        will-change: transform;
        transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(214,51,117,.15);
    }
    .atdlog-drawer.open { transform: translateX(0); }

    .atdlog-header {
        padding: 1.6rem 1.8rem 1.2rem;
        border-bottom: 1px solid var(--pink-100);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-shrink: 0;
        background: var(--white);
    }

    .atdlog-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .atdlog-sub {
        font-size: .78rem;
        color: var(--ink-muted);
        margin-top: .25rem;
        font-weight: 500;
    }

    .atdlog-close {
        width: 34px; height: 34px;
        border-radius: 8px;
        border: 1px solid var(--pink-100);
        background: var(--petal);
        color: var(--bright-pink);
        font-size: 1rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, color .2s;
        flex-shrink: 0;
    }
    .atdlog-close:hover { background: var(--pink-100); color: var(--hot-pink); }

    .atdlog-toolbar {
        padding: 1rem 1.8rem .6rem;
        flex-shrink: 0;
        background: var(--white);
        border-bottom: 1px solid var(--pink-100);
        display: flex;
        flex-direction: column;
        gap: .65rem;
    }

    .atdlog-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .atdlog-search-wrap input {
        width: 100%;
        padding: .55rem .9rem .55rem 2.2rem;
        border-radius: 10px;
        border: 1px solid var(--pink-100);
        background: var(--soft-bg);
        color: var(--ink);
        font-size: .83rem;
        font-family: var(--ff-body);
        outline: none;
        transition: border-color .2s, background .2s;
        box-sizing: border-box;
    }
    .atdlog-search-wrap input::placeholder { color: var(--ink-muted); }
    .atdlog-search-wrap input:focus { border-color: var(--bright-pink); background: var(--white); }

    .atdlog-search-icon {
        position: absolute; left: .75rem;
        width: 13px; height: 13px;
        color: var(--ink-muted);
        pointer-events: none;
    }

    .atdlog-filters {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .atdlog-select {
        padding: .38rem 1.6rem .38rem .65rem;
        border-radius: 8px;
        border: 1px solid var(--pink-100);
        background: var(--soft-bg);
        font-family: var(--ff-body);
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .5rem center;
        transition: border-color .2s;
    }
    .atdlog-select:focus { border-color: var(--bright-pink); }

    .atdlog-list {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 1.8rem 1.8rem;
        display: flex;
        flex-direction: column;
        gap: .6rem;
    }
    .atdlog-list::-webkit-scrollbar { width: 4px; }
    .atdlog-list::-webkit-scrollbar-track { background: transparent; }
    .atdlog-list::-webkit-scrollbar-thumb { background: var(--pink-200, #fbbdd1); border-radius: 99px; }

    .atdlog-date-divider {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .5rem 0 .1rem;
        position: sticky;
        top: 0;
        background: var(--soft-bg);
        z-index: 2;
    }
    .atdlog-date-label {
        font-size: .72rem;
        font-weight: 800;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
        background: var(--petal);
        border: 1px solid var(--pink-100);
        border-radius: 99px;
        padding: .2rem .75rem;
    }
    .atdlog-date-line { flex: 1; height: 1px; background: var(--pink-100); }
    .atdlog-day-count { font-size: .68rem; font-weight: 700; color: var(--ink-muted); white-space: nowrap; }

    .atdlog-card {
        background: var(--white);
        border: 1px solid var(--pink-100);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s;
        animation: atdCardIn .28s ease both;
    }
    @keyframes atdCardIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .atdlog-card:hover { background: var(--blush); border-color: var(--bright-pink); }

    .atdlog-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .45rem;
    }

    .atdlog-card-id {
        font-size: .75rem;
        font-weight: 800;
        color: var(--bright-pink);
        font-family: monospace;
        letter-spacing: .03em;
    }

    .atdlog-card-duration {
        font-size: .7rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: var(--blush);
        border: 1px solid var(--pink-100);
        border-radius: 99px;
        padding: .15rem .6rem;
    }

    .atdlog-card-name {
        font-size: .92rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: .35rem;
    }

    .atdlog-card-pills {
        display: flex;
        align-items: center;
        gap: .4rem;
        flex-wrap: wrap;
        margin-bottom: .5rem;
    }

    .atdlog-pill {
        font-size: .68rem;
        font-weight: 700;
        padding: .2rem .6rem;
        border-radius: 99px;
        letter-spacing: .03em;
        text-transform: uppercase;
    }
    .atdlog-pill-role   { background: var(--petal);   color: var(--hot-pink);  border: 1px solid var(--baby-pink); }
    .atdlog-pill-shift  { background: var(--pink-100, #fce4ec); color: var(--hot-pink); border: 1px solid var(--pink-100); }
    .atdlog-pill-on     { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
    .atdlog-pill-off    { background: var(--blush); color: var(--red); border: 1px solid var(--baby-pink); }

    .atdlog-card-times {
        display: flex;
        gap: 1.5rem;
        font-size: .75rem;
        color: var(--ink-muted);
        font-weight: 500;
        padding-top: .5rem;
        border-top: 1px solid var(--pink-100);
        flex-wrap: wrap;
    }
    .atdlog-card-times span { color: var(--bright-pink); font-weight: 700; }

    .atdlog-empty {
        text-align: center;
        padding: 3.5rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
    }
    .atdlog-empty-icon {
        width: 38px;
        height: 38px;
        display: block;
        margin: 0 auto .75rem;
        opacity: .35;
        object-fit: contain;
    }

    .atdlog-footer {
        padding: .9rem 1.8rem;
        border-top: 1px solid var(--pink-100);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .atdlog-foot-count {
        font-size: .75rem;
        color: var(--ink-muted);
        font-weight: 600;
    }

    .atdlog-clear-btn {
        padding: .35rem .85rem;
        border-radius: 8px;
        border: 1.5px solid var(--red);
        background: #fff0f3;
        color: var(--red);
        font-size: .75rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        transition: background .2s, color .2s;
    }
    .atdlog-clear-btn:hover { background: var(--red); color: var(--white); }

    @media(max-width:900px) {
        .atdlog-header { padding: 1.2rem 1rem .9rem; }
        .atdlog-list   { padding: 0 1rem 1.2rem; }
        .atdlog-toolbar { padding: .8rem 1rem .5rem; }
        .atdlog-footer { padding: .75rem 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    @if(session('new_temp_password'))
    <div class="modal-overlay open" id="staff-credentials-modal">
        <div class="modal" style="max-width:440px;">
            <div class="modal-header">
                <div class="modal-title">Staff Account Created Successfully</div>
                <button class="modal-close" onclick="closeModal('staff-credentials-modal')">&#x2715;</button>
            </div>
            <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
                Please provide these temporary login credentials to the staff member.
            </p>
            <div class="credentials-box">
                <h4>Temporary Login Credentials</h4>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Email</div>
                        <div class="credential-value" id="new-email">{{ session('new_email') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('new-email', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Staff ID</div>
                        <div class="credential-value" id="new-staff-id">{{ session('new_staff_id') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('new-staff-id', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Temporary Password</div>
                        <div class="credential-value" id="new-temp-password">{{ session('new_temp_password') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('new-temp-password', this)">Copy</button>
                </div>
            </div>
            <div class="credentials-warning">
                This temporary password will <strong>not be shown again</strong>.
                Please inform the staff member immediately.
            </div>
            <div class="modal-actions">
                <button class="btn-submit" onclick="closeModal('staff-credentials-modal')">Got it</button>
            </div>
        </div>
    </div>
    @endif

    <div class="page-header fade-up d1">
        <div>
            <h1>Manage Staff</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openModal('add-modal')">+ Add Staff</button>
            <button class="btn-outline" onclick="openAttendanceLog()">
                <img src="{{ asset('icons/clock.png') }}" class="icon-sm" alt="Attendance">
                Attendance Log
            </button>
            <button class="btn-outline" onclick="openStaffArchive()">
                <img src="{{ asset('icons/archive.png') }}" class="icon-sm" alt="Archive">
                Archive / History
            </button>
            <div class="export-dropdown" id="export-dropdown-main">
                <button class="btn-outline" onclick="toggleExportDropdown('export-dropdown-main')">
                    <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                    Export
                </button>
                <div class="export-menu" id="export-menu-main">
                    <button onclick="exportStaffCsv(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportStaffPdf(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/staff-2.png') }}" class="icon-md" alt="staff">
            </div>
            <div>
                <div class="stat-label">Total Staff</div>
                <div class="stat-num">{{ $totalStaff }}</div>
                <div class="stat-sub">All Registered</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/onduty.png') }}" class="icon-md" alt="on duty">
            </div>
            <div>
                <div class="stat-label">On Duty Today</div>
                <div class="stat-num">{{ $onDutyCount }}</div>
                <div class="stat-sub">Currently Active</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/offduty.png') }}" class="icon-md" alt="off duty">
            </div>
            <div>
                <div class="stat-label">Off Duty</div>
                <div class="stat-num">{{ $offDutyCount }}</div>
                <div class="stat-sub">Not on shift</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div>
                <div class="table-title">All Staff</div>
                <div class="table-date" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Search..." oninput="filterTable()">
                </div>
                <div class="filter-divider"></div>
                <span class="filter-label">Role:</span>
                <select class="sort-select" id="filter-role" onchange="filterTable()">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="secretary">Secretary</option>
                    <option value="frontdesk">Front Desk</option>
                </select>
                <div class="filter-divider"></div>
                <span class="filter-label">Duty:</span>
                <select class="sort-select" id="filter-duty" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="on_duty">On Duty</option>
                    <option value="off_duty">Off Duty</option>
                    <option value="on_leave">On Leave</option>
                </select>
                <div class="filter-divider"></div>
                <div class="status-legend-wrap" id="status-legend-trigger" onclick="toggleStatusLegend(event)">
                    <img src="{{ asset('icons/info.png') }}" style="width:15px;height:15px;object-fit:contain;filter:brightness(0) saturate(100%) invert(11%) sepia(93%) saturate(6000%) hue-rotate(327deg) brightness(95%);">
                </div>
                <div class="filter-divider"></div>
                <span class="filter-label">Sort:</span>
                <select class="sort-select" id="sort-select" onchange="sortTable()">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="name">Name</option>
                    <option value="role">Role</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                        <th>Role</th>
                        <th>Shift Sched.</th>
                        <th>Contact No.</th>
                        <th>Duty Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="staff-tbody"></tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="table-showing" id="showing-label"></div>
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
<div class="status-legend-popup" id="status-legend-popup">
    <div class="slg-title">Duty Status</div>
    <div class="slg-row"><span class="badge badge-onduty">On Duty</span><span class="slg-desc">Staff member is currently active and on shift.</span></div>
    <div class="slg-row"><span class="badge badge-offduty">Off Duty</span><span class="slg-desc">Staff member is not currently on shift.</span></div>
    <div class="slg-row"><span class="badge badge-leave">On Leave</span><span class="slg-desc">Staff member is on approved leave and unavailable.</span></div>
    <div class="slg-title second">Role</div>
    <div class="slg-row"><span class="badge badge-admin">Admin</span><span class="slg-desc">Full administrative access to manage staff, tenants, and dorm settings.</span></div>
    <div class="slg-row"><span class="badge badge-admin">Secretary</span><span class="slg-desc">Handles records, documentation, and clerical support tasks.</span></div>
    <div class="slg-row"><span class="badge badge-frontdesk">Front Desk</span><span class="slg-desc">Manages guest check-ins, inquiries, and daily front desk duties.</span></div>
</div>

<div class="staff-archive-backdrop" id="sad-backdrop" onclick="closeStaffArchive()"></div>

<div class="staff-archive-drawer" id="sad-drawer">
    <div class="sad-header">
        <div>
            <div class="sad-title">Archive / History</div>
            <div class="sad-sub">Records of deleted and inactive staff</div>
        </div>
        <button class="sad-close" onclick="closeStaffArchive()">&#x2715;</button>
    </div>

    <div class="sad-tabs">
        <button class="sad-tab active" id="stab-deleted" onclick="switchStaffArchiveTab('deleted')">
            Deleted <span class="sad-tab-count" id="scount-deleted">0</span>
        </button>
        <button class="sad-tab" id="stab-inactive" onclick="switchStaffArchiveTab('inactive')">
            Inactive <span class="sad-tab-count" id="scount-inactive">0</span>
        </button>
    </div>

    <div class="sad-search-bar">
        <div class="sad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="sad-search-icon" alt="">
            <input type="text" id="sad-search" placeholder="Search archived staff..." oninput="renderStaffArchive()">
        </div>
    </div>

    <div class="sad-list" id="sad-list"></div>

    <div class="sad-footer">
        <div class="sad-count-label" id="sad-count-label">0 records</div>
        <div style="display:flex;align-items:center;gap:.6rem;">
            <div class="export-dropdown" id="export-dropdown-archive">
                <button class="sad-export-btn" onclick="toggleExportDropdown('export-dropdown-archive')">
                    <img src="{{ asset('icons/export.png') }}" alt="">
                    Export
                </button>
                <div class="export-menu" id="export-menu-archive">
                    <button onclick="exportStaffArchive('csv'); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportStaffArchive('pdf'); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="atdlog-backdrop" id="atdlog-backdrop" onclick="closeAttendanceLog()"></div>

<div class="atdlog-drawer" id="atdlog-drawer">
    <div class="atdlog-header">
        <div>
            <div class="atdlog-title">Attendance Log</div>
            <div class="atdlog-sub" id="atdlog-count-sub">Loading records...</div>
        </div>
        <button class="atdlog-close" onclick="closeAttendanceLog()">&#x2715;</button>
    </div>

    <div class="atdlog-toolbar">
        <div class="atdlog-search-wrap">
            <svg class="atdlog-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="atdlog-search" placeholder="Search by name..." oninput="renderAtdLog()">
        </div>
        <div class="atdlog-filters">
            <select class="atdlog-select" id="atdlog-role" onchange="renderAtdLog()">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="secretary">Secretary</option>
                <option value="frontdesk">Front Desk</option>
            </select>
            <select class="atdlog-select" id="atdlog-duty" onchange="renderAtdLog()">
                <option value="">All Status</option>
                <option value="on_duty">On Duty</option>
                <option value="off_duty">Off Duty</option>
            </select>
            <select class="atdlog-select" id="atdlog-shift" onchange="renderAtdLog()">
                <option value="">All Shifts</option>
                <option value="Day">Day</option>
                <option value="Night">Night</option>
            </select>
        </div>
    </div>

    <div class="atdlog-list" id="atdlog-list"></div>

    <div class="atdlog-footer">
        <div class="atdlog-foot-count" id="atdlog-foot-count">0 records</div>
        <div style="display:flex;align-items:center;gap:.6rem;">
            <button class="atdlog-clear-btn" onclick="confirmClearAttendanceLog()">Clear Log</button>
            <div class="export-dropdown" id="export-dropdown-atdlog">
                <button class="sad-export-btn" onclick="toggleExportDropdown('export-dropdown-atdlog')">
                    <img src="{{ asset('icons/export.png') }}" alt="">
                    Export
                </button>
                <div class="export-menu" id="export-menu-atdlog">
                    <button onclick="exportAttendanceLogs('csv'); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportAttendanceLogs('pdf'); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="add-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Add New Staff</div>
            <button class="modal-close" onclick="closeModal('add-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('staff.store') }}" data-loading-message="Adding staff...">
            @csrf
            <div class="modal-grid">
                <div class="modal-field">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="e.g. Juan" required value="{{ old('first_name') }}">
                </div>
                <div class="modal-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="e.g. Dela Cruz" required value="{{ old('last_name') }}">
                </div>
                <div class="modal-field full">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="e.g. juan@dormease.com" required value="{{ old('email') }}">
                </div>
                <div class="modal-field">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">Select role</option>
                        <option value="admin"     {{ old('role') === 'admin'     ? 'selected' : '' }}>Admin</option>
                        <option value="secretary" {{ old('role') === 'secretary' ? 'selected' : '' }}>Secretary</option>
                        <option value="frontdesk" {{ old('role') === 'frontdesk' ? 'selected' : '' }}>Front Desk</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Shift Schedule</label>
                    <select name="shift_schedule">
                        <option value="">Select shift</option>
                        <option value="Day"   {{ old('shift_schedule') === 'Day'   ? 'selected' : '' }}>Day</option>
                        <option value="Night" {{ old('shift_schedule') === 'Night' ? 'selected' : '' }}>Night</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" placeholder="e.g. 0912-345-6789" value="{{ old('contact_number') }}">
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Add Staff</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Staff Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/edit.png') }}" class="icon-sm" alt="Edit">
                Edit Staff
            </div>
            <button class="modal-close" onclick="closeModal('edit-modal')">&#x2715;</button>
        </div>
        <form method="POST" id="edit-form" action="" data-loading-message="Saving changes...">
            @csrf
            @method('PUT')
            <div class="modal-grid">
                <div class="modal-field">
                    <label>First Name</label>
                    <input type="text" name="first_name" id="edit-first-name" required>
                </div>
                <div class="modal-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" id="edit-last-name" required>
                </div>
                <div class="modal-field full">
                    <label>Email</label>
                    <input type="email" name="email" id="edit-email" required>
                </div>
                <div class="modal-field">
                    <label>Role</label>
                    <select name="role" id="edit-role">
                        <option value="admin">Admin</option>
                        <option value="secretary">Secretary</option>
                        <option value="frontdesk">Front Desk</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Shift Schedule</label>
                    <select name="shift_schedule" id="edit-shift">
                        <option value="Day">Day</option>
                        <option value="Night">Night</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" id="edit-contact">
                </div>
                <div class="modal-field full">
                    <label>Duty Status</label>
                    <select name="duty_status" id="edit-duty-status">
                        <option value="on_duty">On Duty</option>
                        <option value="off_duty">Off Duty</option>
                        <option value="on_leave">On Leave</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Active</label>
                    <select name="is_active" id="edit-is-active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div style="background:#fff9e6;border:1.5px solid #f0c040;border-radius:10px;padding:.6rem .9rem;font-size:.78rem;color:#7a5400;margin-bottom:.9rem;line-height:1.5;">
                Setting status to <strong>Inactive</strong> will move this staff member to the archive.
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
            <div class="modal-title">
                <img src="{{ asset('icons/delete.png') }}" class="icon-sm" alt="Delete">
                Delete Staff
            </div>
            <button class="modal-close" onclick="closeModal('delete-modal')">&#x2715;</button>
        </div>
        <div class="delete-warning">
            This action cannot be undone. The staff record will be permanently removed.
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);">
            Are you sure you want to delete
            <strong id="delete-name" style="color:var(--ink);"></strong>?
        </p>
        <form method="POST" id="delete-form" action="" data-loading-message="Deleting staff...">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:var(--red);">Delete</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function showActionLoading(message) {
        var overlay = document.getElementById('action-loading');
        document.getElementById('action-loading-text').textContent = message || 'Please wait...';
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
    }

    function hideActionLoading() {
        var overlay = document.getElementById('action-loading');
        overlay.classList.remove('open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    function setFormLoading(form, message) {
        form.querySelectorAll('button[type="submit"]').forEach(function(btn) {
            btn.textContent = 'Please wait...';
            btn.disabled    = true;
            btn.classList.add('is-loading');
        });
        form.querySelectorAll('button:not([type="submit"])').forEach(function(btn) {
            btn.disabled = true;
            btn.classList.add('is-loading');
        });
        showActionLoading(message);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[data-loading-message]').forEach(function(form) {
            form.addEventListener('submit', function() {
                setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
            });
        });
    });

    var staffList  = @json($staffList);
    var PER_PAGE   = 8;
    var currentPage  = 1;
    var filtered     = staffList.slice();
    var currentStaff = null;

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    function dutyBadge(status) {
        var map = {
            on_duty:  '<span class="badge badge-onduty">On Duty</span>',
            off_duty: '<span class="badge badge-offduty">Off Duty</span>',
            on_leave: '<span class="badge badge-leave">On Leave</span>',
        };
        return map[status] || ('<span class="badge badge-offduty">' + (status || '\u2014') + '</span>');
    }

    function roleBadge(role) {
        var map = {
            admin:     '<span class="badge badge-admin">Admin</span>',
            secretary: '<span class="badge badge-admin">Secretary</span>',
            frontdesk: '<span class="badge badge-frontdesk">Front Desk</span>',
            staff:     '<span class="badge badge-staff">Staff</span>',
        };
        return map[role] || ('<span class="badge badge-staff">' + (role || '\u2014') + '</span>');
    }

    function shiftLabel(shift) {
        if (!shift) return '\u2014';
        var cls = shift.toLowerCase() === 'night' ? 'night' : 'day';
        return '<span class="shift-dot ' + cls + '">' + shift + '</span>';
    }

    function fmtStaffId(id) {
        return 'ST-' + String(id).padStart(3, '0');
    }

    function renderTable() {
        var start    = (currentPage - 1) * PER_PAGE;
        var pageData = filtered.slice(start, start + PER_PAGE);
        var tbody    = document.getElementById('staff-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ink-muted);">No staff found.</td></tr>';
        } else {
            tbody.innerHTML = pageData.map(function(s) {
                return '<tr>'
                    + '<td class="td-id">' + fmtStaffId(s.staff_id) + '</td>'
                    + '<td class="td-name">' + s.first_name + ' ' + s.last_name + '</td>'
                    + '<td>' + roleBadge(s.role) + '</td>'
                    + '<td>' + shiftLabel(s.shift_schedule) + '</td>'
                    + '<td>' + (s.contact_number || '\u2014') + '</td>'
                    + '<td>' + dutyBadge(s.duty_status) + '</td>'
                    + '<td>'
                        + '<div class="action-group">'
                            + '<button class="act-btn" title="View" onclick=\'viewStaff(' + JSON.stringify(s).replace(/'/g, "&#39;") + ')\'>'
                                + '<img src="{{ asset("icons/eye.png") }}" class="icon-sm" alt="View">'
                            + '</button>'
                            + '<button class="act-btn" title="Edit" onclick=\'openEditModal(' + JSON.stringify(s).replace(/'/g, "&#39;") + ')\'>'
                                + '<img src="{{ asset("icons/edit.png") }}" class="icon-sm" alt="Edit">'
                            + '</button>'
                            + '<button class="act-btn delete" title="Delete" onclick="openDeleteModal(' + s.staff_id + ', \'' + (s.first_name + ' ' + s.last_name).replace(/'/g, "\\'") + '\')">'
                                + '<img src="{{ asset("icons/delete.png") }}" class="icon-sm" alt="Delete">'
                            + '</button>'
                            + '<button class="act-btn toggle" title="Reset Password" onclick=\'resetTempPassword(' + JSON.stringify(s).replace(/'/g, "&#39;") + ')\'>'
                                + '<img src="{{ asset("icons/reset.png") }}" class="icon-sm" alt="Reset">'
                            + '</button>'
                        + '</div>'
                    + '</td>'
                    + '</tr>';
            }).join('');
        }

        var total = filtered.length;
        var from  = total === 0 ? 0 : start + 1;
        var to    = Math.min(start + PER_PAGE, total);
        document.getElementById('showing-label').textContent =
            'Showing data ' + from + ' to ' + to + ' of ' + total + ' entries';

        renderPagination();
    }

    function renderPagination() {
        var totalPages = Math.ceil(filtered.length / PER_PAGE);
        var pg = document.getElementById('pagination');
        var html = '<button class="page-btn" onclick="goPage(' + (currentPage - 1) + ')" ' + (currentPage === 1 ? 'disabled' : '') + '>&#8249;</button>';
        for (var i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += '<button class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goPage(' + i + ')">' + i + '</button>';
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += '<span style="color:var(--ink-muted);padding:0 .2rem">&#8230;</span>';
            }
        }
        html += '<button class="page-btn" onclick="goPage(' + (currentPage + 1) + ')" ' + (currentPage === totalPages || totalPages === 0 ? 'disabled' : '') + '>&#8250;</button>';
        pg.innerHTML = html;
    }

    function goPage(p) {
        var totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        renderTable();
    }

    function filterTable() {
        var q    = document.getElementById('search-input').value.toLowerCase();
        var role = document.getElementById('filter-role').value;
        var duty = document.getElementById('filter-duty').value;
        filtered = staffList.filter(function(s) {
            var matchSearch = (s.first_name + ' ' + s.last_name).toLowerCase().includes(q) ||
                fmtStaffId(s.staff_id).toLowerCase().includes(q) ||
                (s.role           || '').toLowerCase().includes(q) ||
                (s.contact_number || '').toLowerCase().includes(q) ||
                (s.email          || '').toLowerCase().includes(q);
            var matchRole = role === '' || s.role === role;
            var matchDuty = duty === '' || s.duty_status === duty;
            return matchSearch && matchRole && matchDuty;
        });
        currentPage = 1;
        renderTable();
    }

    function sortTable() {
        var val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort(function(a, b) { return new Date(b.created_at) - new Date(a.created_at); });
        if (val === 'oldest') filtered.sort(function(a, b) { return new Date(a.created_at) - new Date(b.created_at); });
        if (val === 'name')   filtered.sort(function(a, b) { return a.first_name.localeCompare(b.first_name); });
        if (val === 'role')   filtered.sort(function(a, b) { return (a.role || '').localeCompare(b.role || ''); });
        currentPage = 1;
        renderTable();
    }

    function viewStaff(s) {
        currentStaff = s;
        document.getElementById('view-content').innerHTML =
            '<div class="view-row"><span class="view-label">Staff ID</span><span class="view-val" style="font-family:monospace">' + fmtStaffId(s.staff_id) + '</span></div>'
            + '<div class="view-row"><span class="view-label">Full Name</span><span class="view-val">' + s.first_name + ' ' + s.last_name + '</span></div>'
            + '<div class="view-row"><span class="view-label">Email</span><span class="view-val">' + s.email + '</span></div>'
            + '<div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">' + (s.contact_number || '\u2014') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Role</span><span class="view-val">' + roleBadge(s.role) + '</span></div>'
            + '<div class="view-row"><span class="view-label">Shift Schedule</span><span class="view-val">' + shiftLabel(s.shift_schedule) + '</span></div>'
            + '<div class="view-row"><span class="view-label">Duty Status</span><span class="view-val">' + dutyBadge(s.duty_status) + '</span></div>'
            + '<div class="view-row"><span class="view-label">Account Status</span><span class="view-val">' + (s.is_active ? 'Active' : 'Inactive') + '</span></div>';
        openModal('view-modal');
    }

    function switchToEdit() {
        if (currentStaff) {
            closeModal('view-modal');
            setTimeout(function() { openEditModal(currentStaff); }, 200);
        }
    }

    function openEditModal(s) {
        currentStaff = s;
        document.getElementById('edit-form').action           = '/staff/' + s.staff_id;
        document.getElementById('edit-first-name').value      = s.first_name     || '';
        document.getElementById('edit-last-name').value       = s.last_name      || '';
        document.getElementById('edit-email').value           = s.email          || '';
        document.getElementById('edit-role').value            = s.role           || '';
        document.getElementById('edit-shift').value           = s.shift_schedule || '';
        document.getElementById('edit-contact').value         = s.contact_number || '';
        document.getElementById('edit-duty-status').value     = s.duty_status    || 'off_duty';
        document.getElementById('edit-is-active').value       = s.is_active ? '1' : '0';
        openModal('edit-modal');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = '/staff/' + id;
        openModal('delete-modal');
    }

    function exportStaffCsv() {
        var rows = [['Staff ID', 'First Name', 'Last Name', 'Email', 'Role', 'Shift', 'Contact', 'Duty Status']];
        staffList.forEach(function(s) {
            rows.push([
                fmtStaffId(s.staff_id),
                s.first_name, s.last_name, s.email,
                s.role            || '',
                s.shift_schedule  || '',
                s.contact_number  || '',
                s.duty_status     || '',
            ]);
        });
        var csv  = rows.map(function(r) { return r.map(function(v) { return '"' + String(v).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var blob = new Blob([csv], { type: 'text/csv' });
        var a    = document.createElement('a');
        a.href   = URL.createObjectURL(blob);
        a.download = 'dormease-staff.csv';
        a.click();
        URL.revokeObjectURL(a.href);
        showToast('Staff list exported as CSV!', 'success');
    }

    function exportStaffPdf() {
        if (!staffList.length) { showToast('No data to export.', 'error'); return; }
        var win  = window.open('', '_blank');
        var rows = staffList.map(function(s) {
            return '<tr>'
                + '<td>' + fmtStaffId(s.staff_id) + '</td>'
                + '<td>' + s.first_name + ' ' + s.last_name + '</td>'
                + '<td>' + (s.email || '') + '</td>'
                + '<td>' + (s.role || '') + '</td>'
                + '<td>' + (s.shift_schedule || '') + '</td>'
                + '<td>' + (s.contact_number || '') + '</td>'
                + '<td>' + (s.duty_status || '') + '</td>'
                + '</tr>';
        }).join('');
        win.document.write('<!DOCTYPE html><html><head><title>Staff List</title>'
            + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<p>Staff List - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
            + '<table><thead><tr><th>Staff ID</th><th>Name</th><th>Email</th><th>Role</th><th>Shift</th><th>Contact</th><th>Duty Status</th></tr></thead>'
            + '<tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
    }

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) {
        var el = document.getElementById(id);
        if (el) el.classList.remove('open');
        if ((id === 'reset-credentials-modal' || id === 'reset-confirm-modal') && el) el.remove();
    }

    document.querySelectorAll('.modal-overlay').forEach(function(m) {
        m.addEventListener('click', function(e) { if (e.target === m) m.classList.remove('open'); });
    });

    function copyText(id, btn) {
        var text = document.getElementById(id) ? document.getElementById(id).innerText.trim() : '';
        if (!text) return;
        navigator.clipboard.writeText(text).then(function() {
            var old = btn.innerText;
            btn.innerText = 'Copied!';
            setTimeout(function() { btn.innerText = old; }, 1500);
            showToast('Copied to clipboard!', 'success');
        });
    }

    function copyResetText(id, btn) {
        var text = document.getElementById(id) ? document.getElementById(id).innerText.trim() : '';
        if (!text) return;
        navigator.clipboard.writeText(text).then(function() {
            var old = btn.innerText;
            btn.innerText = 'Copied!';
            setTimeout(function() { btn.innerText = old; }, 1500);
            showToast('Copied to clipboard!', 'success');
        });
    }

    function resetTempPassword(s) {
        var existing = document.getElementById('reset-confirm-modal');
        if (existing) existing.remove();
        var initials = (s.first_name[0] || '') + (s.last_name[0] || '');
        document.body.insertAdjacentHTML('beforeend',
            '<div class="modal-overlay open" id="reset-confirm-modal">'
            + '<div class="modal" style="max-width:420px;">'
                + '<div class="modal-header">'
                    + '<div style="display:flex;align-items:center;gap:10px;">'
                        + '<div style="width:38px;height:38px;border-radius:10px;background:var(--petal);display:flex;align-items:center;justify-content:center;flex-shrink:0;">'
                            + '<img src="{{ asset("icons/reset.png") }}" style="width:18px;height:18px;" alt="">'
                        + '</div>'
                        + '<div>'
                            + '<div class="modal-title">Reset password</div>'
                            + '<div style="font-size:.78rem;color:var(--ink-muted);">This will generate new credentials</div>'
                        + '</div>'
                    + '</div>'
                    + '<button class="modal-close" onclick="closeModal(\'reset-confirm-modal\')">&#x2715;</button>'
                + '</div>'
                + '<div class="reset-staff-card">'
                    + '<div class="reset-staff-avatar">' + initials + '</div>'
                    + '<div>'
                        + '<div class="reset-staff-name">' + s.first_name + ' ' + s.last_name + '</div>'
                        + '<div class="reset-staff-meta">' + fmtStaffId(s.staff_id) + ' &middot; ' + (s.role || '\u2014') + '</div>'
                    + '</div>'
                + '</div>'
                + '<div class="reset-warning-box">'
                    + '<p>A new temporary password will be generated. Share it with the staff member immediately as it will not be shown again.</p>'
                + '</div>'
                + '<div class="modal-actions">'
                    + '<button class="btn-cancel" onclick="closeModal(\'reset-confirm-modal\')">Cancel</button>'
                    + '<button class="btn-submit" style="background:var(--bright-pink);" onclick="confirmReset(' + s.staff_id + ')">Reset password</button>'
                + '</div>'
            + '</div>'
            + '</div>'
        );
        document.getElementById('reset-confirm-modal').addEventListener('click', function(e) {
            if (e.target === document.getElementById('reset-confirm-modal')) closeModal('reset-confirm-modal');
        });
    }

    function confirmReset(id) {
        closeModal('reset-confirm-modal');
        showActionLoading('Resetting password...');
        fetch('/staff/' + id + '/reset-password', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            hideActionLoading();
            var existing = document.getElementById('reset-credentials-modal');
            if (existing) existing.remove();
            document.body.insertAdjacentHTML('beforeend',
                '<div class="modal-overlay open" id="reset-credentials-modal">'
                + '<div class="modal" style="max-width:460px;">'
                    + '<div class="modal-header">'
                        + '<div class="modal-title">Password Reset Successful</div>'
                        + '<button class="modal-close" onclick="closeModal(\'reset-credentials-modal\')">&#x2715;</button>'
                    + '</div>'
                    + '<p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">Share these credentials with the staff member immediately.</p>'
                    + '<div class="credentials-box">'
                        + '<h4>New Temporary Credentials</h4>'
                        + '<div class="credential-row">'
                            + '<div><div class="credential-label">Email</div><div class="credential-value" id="reset-email">' + data.reset_email + '</div></div>'
                            + '<button class="copy-btn" onclick="copyResetText(\'reset-email\', this)">Copy</button>'
                        + '</div>'
                        + '<div class="credential-row">'
                            + '<div><div class="credential-label">Staff ID</div><div class="credential-value" id="reset-staff-id">' + data.reset_staff_id + '</div></div>'
                            + '<button class="copy-btn" onclick="copyResetText(\'reset-staff-id\', this)">Copy</button>'
                        + '</div>'
                        + '<div class="credential-row">'
                            + '<div><div class="credential-label">Temporary Password</div><div class="credential-value" id="reset-temp-password">' + data.reset_temp_password + '</div></div>'
                            + '<button class="copy-btn" onclick="copyResetText(\'reset-temp-password\', this)">Copy</button>'
                        + '</div>'
                    + '</div>'
                    + '<div class="credentials-warning">This password will <strong>not be shown again</strong>.</div>'
                    + '<div class="modal-actions"><button class="btn-submit" onclick="closeModal(\'reset-credentials-modal\')">Got it</button></div>'
                + '</div>'
                + '</div>'
            );
            document.getElementById('reset-credentials-modal').addEventListener('click', function(e) {
                if (e.target === document.getElementById('reset-credentials-modal')) closeModal('reset-credentials-modal');
            });
            showToast('Password reset successfully!', 'success');
        })
        .catch(function() {
            hideActionLoading();
            showToast('Failed to reset password.', 'error');
        });
    }

    var deletedStaffArchive   = @json($deletedArchive);
    var inactiveStaffArchive  = @json($inactiveArchive);
    var attendanceLogsArchive = @json($attendanceLogs);
    var staffArchiveTab       = 'deleted';

    function openAttendanceLog() {
        document.getElementById('atdlog-drawer').classList.add('open');
        document.getElementById('atdlog-backdrop').classList.add('open');
        document.getElementById('atdlog-search').value  = '';
        document.getElementById('atdlog-role').value    = '';
        document.getElementById('atdlog-duty').value    = '';
        document.getElementById('atdlog-shift').value   = '';
        renderAtdLog();
    }

    function closeAttendanceLog() {
        document.getElementById('atdlog-drawer').classList.remove('open');
        document.getElementById('atdlog-backdrop').classList.remove('open');
    }

    function renderAtdLog() {
        var q     = document.getElementById('atdlog-search').value.toLowerCase();
        var role  = document.getElementById('atdlog-role').value;
        var duty  = document.getElementById('atdlog-duty').value;
        var shift = document.getElementById('atdlog-shift').value;

        var data = attendanceLogsArchive.filter(function(r) {
            var matchQ     = (r.staff_name || '').toLowerCase().includes(q);
            var matchRole  = role  === '' || (r.role           || '') === role;
            var matchDuty  = duty  === '' || (r.duty_status    || '') === duty;
            var matchShift = shift === '' || (r.shift_schedule || '') === shift;
            return matchQ && matchRole && matchDuty && matchShift;
        });

        document.getElementById('atdlog-foot-count').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');
        document.getElementById('atdlog-count-sub').textContent  = data.length + ' session' + (data.length !== 1 ? 's' : '') + ' logged';

        var list = document.getElementById('atdlog-list');

        if (data.length === 0) {
            list.innerHTML = '<div class="atdlog-empty"><img src="{{ asset("icons/calendar.png") }}" class="atdlog-empty-icon" alt="">No attendance records found.</div>';
            return;
        }

        var grouped = {};
        data.forEach(function(r) {
            var dk = r.login_at
                ? new Date(r.login_at).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' })
                : 'Unknown Date';
            if (!grouped[dk]) grouped[dk] = [];
            grouped[dk].push(r);
        });

        var html = '';
        var idx  = 0;

        Object.keys(grouped).forEach(function(dk) {
            var grp = grouped[dk];
            html += '<div class="atdlog-date-divider">'
                + '<div class="atdlog-date-label">' + dk + '</div>'
                + '<div class="atdlog-date-line"></div>'
                + '<div class="atdlog-day-count">' + grp.length + ' session' + (grp.length !== 1 ? 's' : '') + '</div>'
                + '</div>';

            grp.forEach(function(r) {
                var loginTime  = r.login_at  ? new Date(r.login_at).toLocaleTimeString('en-US',  { hour: '2-digit', minute: '2-digit', hour12: true }) : '\u2014';
                var logoutTime = r.logout_at ? new Date(r.logout_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }) : 'Still logged in';
                var dutyClass  = r.duty_status === 'on_duty' ? 'atdlog-pill-on' : 'atdlog-pill-off';
                var dutyLabel  = r.duty_status === 'on_duty' ? 'On Duty' : 'Off Duty';

                html += '<div class="atdlog-card" style="animation-delay:' + (idx * 0.025) + 's;">'
                    + '<div class="atdlog-card-top">'
                        + '<div class="atdlog-card-id">ST-' + String(r.staff_id).padStart(3, '0') + '</div>'
                        + (r.duration ? '<div class="atdlog-card-duration">' + r.duration + '</div>' : '')
                    + '</div>'
                    + '<div class="atdlog-card-name">' + r.staff_name + '</div>'
                    + '<div class="atdlog-card-pills">'
                        + (r.role           ? '<span class="atdlog-pill atdlog-pill-role">' + r.role + '</span>' : '')
                        + (r.shift_schedule ? '<span class="atdlog-pill atdlog-pill-shift">' + r.shift_schedule + '</span>' : '')
                        + '<span class="atdlog-pill ' + dutyClass + '">' + dutyLabel + '</span>'
                    + '</div>'
                    + '<div class="atdlog-card-times">'
                        + 'Login: <span>' + loginTime + '</span>'
                        + 'Logout: <span>' + logoutTime + '</span>'
                    + '</div>'
                + '</div>';
                idx++;
            });
        });

        list.innerHTML = html;
    }

    function fmtDatePlain(d) {
        if (!d) return '\u2014';
        var dt   = new Date(d);
        var date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        var time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return date + ' ' + time;
    }

    function openStaffArchive() {
        document.getElementById('sad-drawer').classList.add('open');
        document.getElementById('sad-backdrop').classList.add('open');
        document.getElementById('sad-search').value = '';
        document.getElementById('scount-deleted').textContent  = deletedStaffArchive.length;
        document.getElementById('scount-inactive').textContent = inactiveStaffArchive.length;
        renderStaffArchive();
    }

    function closeStaffArchive() {
        document.getElementById('sad-drawer').classList.remove('open');
        document.getElementById('sad-backdrop').classList.remove('open');
    }

    function switchStaffArchiveTab(tab) {
        staffArchiveTab = tab;
        document.getElementById('stab-deleted').classList.toggle('active',  tab === 'deleted');
        document.getElementById('stab-inactive').classList.toggle('active', tab === 'inactive');
        document.getElementById('sad-search').placeholder = 'Search archived staff...';
        document.getElementById('sad-search').value = '';
        renderStaffArchive();
    }

    function dutyPillClass(status) {
        var map = { on_duty: 'sad-pill-onduty', off_duty: 'sad-pill-offduty', on_leave: 'sad-pill-onleave' };
        return map[status] || 'sad-pill-offduty';
    }

    function renderStaffArchive() {
        var q = document.getElementById('sad-search').value.toLowerCase();

        if (staffArchiveTab === 'attendance') {
            renderAttendanceLog(q);
            return;
        }

        var source = staffArchiveTab === 'deleted' ? deletedStaffArchive : inactiveStaffArchive;

        var data = source.filter(function(r) {
            return (r.account_id  || '').toLowerCase().includes(q) ||
                (r.first_name + ' ' + r.last_name).toLowerCase().includes(q) ||
                (r.email          || '').toLowerCase().includes(q) ||
                (r.role           || '').toLowerCase().includes(q) ||
                (r.shift_schedule || '').toLowerCase().includes(q);
        });

        var list = document.getElementById('sad-list');
        document.getElementById('sad-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');

        if (data.length === 0) {
            var labelMap = { deleted: 'deleted', inactive: 'inactive' };
            list.innerHTML = '<div class="sad-empty">'
                + '<img class="sad-empty-icon" src="{{ asset("icons/staff-2.png") }}" alt="">No ' + labelMap[staffArchiveTab] + ' staff found.'
                + 'No ' + labelMap[staffArchiveTab] + ' staff found.'
                + '</div>';
            return;
        }

        var archiveLabelMap = { deleted: 'Deleted on', inactive: 'Marked inactive on' };
        var archiveLabel = archiveLabelMap[staffArchiveTab];

        list.innerHTML = data.map(function(r, i) {
            var dateValue = staffArchiveTab === 'deleted' ? r.archived_at : r.inactivated_at;
            var timeDisplay = fmtDatePlain(dateValue);
            var archivedDisplay = fmtDatePlain(dateValue);

            return '<div class="sad-card" style="animation-delay:' + (i * 0.04) + 's;">'
                + '<div class="sad-card-top">'
                    + '<div class="sad-card-id">' + (r.account_id || (r.staff_code || '\u2014')) + '</div>'
                    + '<div class="sad-card-time">' + timeDisplay + '</div>'
                + '</div>'
                + '<div class="sad-card-name">' + r.first_name + ' ' + r.last_name + '</div>'
                + '<div class="sad-card-email">' + (r.email || '\u2014') + '</div>'
                + '<div class="sad-card-meta">'
                    + (r.role         ? '<span class="sad-pill sad-pill-role">' + r.role + '</span>' : '')
                    + (r.shift_schedule ? '<span class="sad-pill sad-pill-shift">' + r.shift_schedule + '</span>' : '')
                    + (r.duty_status  ? '<span class="sad-pill ' + dutyPillClass(r.duty_status) + '">' + r.duty_status.replace('_', ' ') + '</span>' : '')
                    + (staffArchiveTab === 'inactive' ? '<span class="sad-pill sad-pill-inactive">Inactive</span>' : '')
                + '</div>'
                + '<div class="sad-card-archived">' + archiveLabel + ': <span>' + archivedDisplay + '</span></div>'
                + (staffArchiveTab === 'inactive'
                    ? '<form method="POST" action="/staff/' + r.staff_id + '/reactivate" style="margin-top:.75rem;" onsubmit="this.querySelector(\'button\').disabled=true;showActionLoading(\'Reactivating staff...\');">'
                        + '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                        + '<button type="submit" style="width:100%;padding:.45rem 0;border-radius:8px;border:none;background:var(--gradient-pink);color:var(--white);font-size:.76rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);letter-spacing:.02em;">Reactivate Account</button>'
                        + '</form>'
                    : '')
                + '</div>';
        }).join('');
    }

    function renderAttendanceLog(q) {
        var roleFilter  = document.getElementById('atd-filter-role')  ? document.getElementById('atd-filter-role').value  : '';
        var dutyFilter  = document.getElementById('atd-filter-duty')  ? document.getElementById('atd-filter-duty').value  : '';
        var shiftFilter = document.getElementById('atd-filter-shift') ? document.getElementById('atd-filter-shift').value : '';

        var data = attendanceLogsArchive.filter(function(r) {
            var matchSearch = (r.staff_name || '').toLowerCase().includes(q);
            var matchRole   = roleFilter  === '' || (r.role           || '') === roleFilter;
            var matchDuty   = dutyFilter  === '' || (r.duty_status    || '') === dutyFilter;
            var matchShift  = shiftFilter === '' || (r.shift_schedule || '') === shiftFilter;
            return matchSearch && matchRole && matchDuty && matchShift;
        });

        var list = document.getElementById('sad-list');
        document.getElementById('sad-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');

        if (data.length === 0) {
            list.innerHTML = '<div class="sad-empty"><img class="sad-empty-icon" src="{{ asset("icons/staff-2.png") }}" alt="">No attendance records found.</div>';
            return;
        }

        var grouped = {};
        data.forEach(function(r) {
            var dateKey = r.login_at ? new Date(r.login_at).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) : 'Unknown Date';
            if (!grouped[dateKey]) grouped[dateKey] = [];
            grouped[dateKey].push(r);
        });

        var html = '';
        var cardIndex = 0;

        Object.keys(grouped).forEach(function(dateKey) {
            var group = grouped[dateKey];
            html += '<div class="atd-date-divider">'
                + '<div class="atd-date-label">' + dateKey + '</div>'
                + '<div class="atd-date-line"></div>'
                + '<div class="atd-day-count">' + group.length + ' session' + (group.length !== 1 ? 's' : '') + '</div>'
            + '</div>';

            group.forEach(function(r) {
                var dutyClass = r.duty_status === 'on_duty' ? 'atd-pill-onduty' : 'atd-pill-offduty';
                var dutyLabel = r.duty_status === 'on_duty' ? 'On Duty' : 'Off Duty';
                var loginTime  = r.login_at  ? new Date(r.login_at).toLocaleTimeString('en-US',  { hour: '2-digit', minute: '2-digit', hour12: true }) : '\u2014';
                var logoutTime = r.logout_at ? new Date(r.logout_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }) : 'Still logged in';

                html += '<div class="sad-card" style="animation-delay:' + (cardIndex * 0.025) + 's;">'
                    + '<div class="sad-card-top">'
                        + '<div class="sad-card-id">ST-' + String(r.staff_id).padStart(3, '0') + '</div>'
                        + (r.duration ? '<span class="atd-duration">' + r.duration + '</span>' : '')
                    + '</div>'
                    + '<div class="sad-card-name">' + r.staff_name + '</div>'
                    + '<div class="sad-card-meta">'
                        + (r.role           ? '<span class="sad-pill sad-pill-role">' + r.role + '</span>' : '')
                        + (r.shift_schedule ? '<span class="sad-pill sad-pill-shift">' + r.shift_schedule + '</span>' : '')
                        + '<span class="sad-pill ' + dutyClass + '">' + dutyLabel + '</span>'
                    + '</div>'
                    + '<div class="atd-card-login-time">'
                        + 'Login: <span>' + loginTime + '</span>'
                        + '&nbsp;&nbsp;&nbsp;Logout: <span>' + logoutTime + '</span>'
                    + '</div>'
                + '</div>';

                cardIndex++;
            });
        });

        list.innerHTML = html;
    }

    function exportStaffArchive(format) {
        if (staffArchiveTab === 'attendance') {
            exportAttendanceLogs(format);
            return;
        }

        var source = staffArchiveTab === 'deleted' ? deletedStaffArchive : inactiveStaffArchive;
        var tabLabel = staffArchiveTab === 'deleted' ? 'Deleted' : 'Inactive';
        var archiveColLabel = staffArchiveTab === 'deleted' ? 'Deleted On' : 'Marked Inactive On';

        if (!source.length) { showToast('No archive data to export.', 'error'); return; }

        if (format === 'pdf') {
            var win  = window.open('', '_blank');
            var rows = source.map(function(r) {
                var dateValue = staffArchiveTab === 'deleted' ? r.archived_at : r.inactivated_at;
                return '<tr>'
                    + '<td>' + (r.account_id || r.staff_code || '') + '</td>'
                    + '<td>' + r.first_name + ' ' + r.last_name + '</td>'
                    + '<td>' + (r.email || '') + '</td>'
                    + '<td>' + (r.role || '') + '</td>'
                    + '<td>' + (r.shift_schedule || '') + '</td>'
                    + '<td>' + (r.duty_status || '') + '</td>'
                    + '<td>' + fmtDatePlain(dateValue) + '</td>'
                    + '</tr>';
            }).join('');
            win.document.write('<!DOCTYPE html><html><head><title>Staff Archive - ' + tabLabel + '</title>'
                + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
                + '</head><body>'
                + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
                + '<p>Staff Archive (' + tabLabel + ') - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
                + '<table><thead><tr><th>Account ID</th><th>Name</th><th>Email</th><th>Role</th><th>Shift</th><th>Duty Status</th><th>' + archiveColLabel + '</th></tr></thead>'
                + '<tbody>' + rows + '</tbody></table>'
                + '</body></html>');
            win.document.close();
            win.print();
            return;
        }

        var rows = [['Account ID', 'First Name', 'Last Name', 'Email', 'Contact', 'Role', 'Shift', 'Duty Status', archiveColLabel]];
        source.forEach(function(r) {
            var dateValue = staffArchiveTab === 'deleted' ? (r.archived_at || '') : (r.inactivated_at || '');
            rows.push([
                r.account_id     || r.staff_code || '',
                r.first_name,
                r.last_name,
                r.email          || '',
                r.contact_number || '',
                r.role           || '',
                r.shift_schedule || '',
                r.duty_status    || '',
                dateValue,
            ]);
        });
        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var a   = document.createElement('a');
        a.href  = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
        a.download = 'staff-' + staffArchiveTab + '-archive.csv';
        a.click();
        URL.revokeObjectURL(a.href);
        showToast('Archive exported as CSV!', 'success');
    }

    function confirmClearAttendanceLog() {
        var existing = document.getElementById('clear-log-confirm-modal');
        if (existing) existing.remove();

        document.body.insertAdjacentHTML('beforeend',
            '<div class="modal-overlay open" id="clear-log-confirm-modal" style="z-index:9999;">'
            + '<div class="modal" style="max-width:400px;">'
                + '<div class="modal-header">'
                    + '<div class="modal-title">Clear Attendance Log</div>'
                    + '<button class="modal-close" onclick="document.getElementById(\'clear-log-confirm-modal\').remove()">&#x2715;</button>'
                + '</div>'
                + '<div class="delete-warning">This will permanently delete all attendance records. This action cannot be undone.</div>'
                + '<p style="font-size:.9rem;color:var(--ink-muted);">Are you sure you want to clear the entire attendance log?</p>'
                + '<div class="modal-actions">'
                    + '<button class="btn-cancel" onclick="document.getElementById(\'clear-log-confirm-modal\').remove()">Cancel</button>'
                    + '<button class="btn-submit" style="background:var(--red);" onclick="executeClearAttendanceLog()">Clear All</button>'
                + '</div>'
            + '</div>'
            + '</div>'
        );

        document.getElementById('clear-log-confirm-modal').addEventListener('click', function(e) {
            if (e.target === this) this.remove();
        });
    }

    function executeClearAttendanceLog() {
        var modal = document.getElementById('clear-log-confirm-modal');
        if (modal) modal.remove();

        showActionLoading('Clearing attendance log...');

        fetch('/staff/attendance/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            hideActionLoading();
            if (data.success) {
                attendanceLogsArchive = [];
                renderAtdLog();
                document.getElementById('atdlog-foot-count').textContent = '0 records';
                document.getElementById('atdlog-count-sub').textContent  = '0 sessions logged';
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Failed to clear.', 'error');
            }
        })
        .catch(function() {
            hideActionLoading();
            showToast('Network error.', 'error');
        });
    }

    function exportAttendanceLogs(format) {
        if (!attendanceLogsArchive.length) { showToast('No attendance data to export.', 'error'); return; }

        if (format === 'pdf') {
            var win  = window.open('', '_blank');
            var rows = attendanceLogsArchive.map(function(r) {
                return '<tr>'
                    + '<td>' + 'ST-' + String(r.staff_id).padStart(3, '0') + '</td>'
                    + '<td>' + r.staff_name + '</td>'
                    + '<td>' + (r.role || '') + '</td>'
                    + '<td>' + (r.shift_schedule || '') + '</td>'
                    + '<td>' + fmtDatePlain(r.login_at) + '</td>'
                    + '<td>' + (r.logout_at ? fmtDatePlain(r.logout_at) : 'Still logged in') + '</td>'
                    + '<td>' + (r.duration || '') + '</td>'
                    + '<td>' + (r.duty_status || '') + '</td>'
                    + '</tr>';
            }).join('');
            win.document.write('<!DOCTYPE html><html><head><title>Staff Attendance Log</title>'
                + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
                + '</head><body>'
                + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
                + '<p>Staff Attendance Log - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
                + '<table><thead><tr><th>Staff ID</th><th>Name</th><th>Role</th><th>Shift</th><th>Login</th><th>Logout</th><th>Duration</th><th>Duty Status</th></tr></thead>'
                + '<tbody>' + rows + '</tbody></table>'
                + '</body></html>');
            win.document.close();
            win.print();
            return;
        }

        var rows = [['Staff ID', 'Name', 'Role', 'Shift', 'Login', 'Logout', 'Duration', 'Duty Status']];
        attendanceLogsArchive.forEach(function(r) {
            rows.push([
                'ST-' + String(r.staff_id).padStart(3, '0'),
                r.staff_name,
                r.role           || '',
                r.shift_schedule || '',
                r.login_at       || '',
                r.logout_at      || 'Still logged in',
                r.duration       || '',
                r.duty_status    || '',
            ]);
        });
        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var a   = document.createElement('a');
        a.href  = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
        a.download = 'staff-attendance-log.csv';
        a.click();
        URL.revokeObjectURL(a.href);
        showToast('Attendance log exported as CSV!', 'success');
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
        var spaceBelow = window.innerHeight - rect.bottom;
        if (spaceBelow >= (menu.offsetHeight || 80) + 6) {
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

    function toggleStatusLegend(e) {
        e.stopPropagation();
        var popup   = document.getElementById('status-legend-popup');
        var trigger = document.getElementById('status-legend-trigger');
        if (popup.classList.contains('open')) {
            popup.classList.remove('open');
            return;
        }
        var rect = trigger.getBoundingClientRect();
        popup.style.left = '8px';
        popup.style.top  = (rect.bottom + 8) + 'px';
        popup.classList.add('open');
        requestAnimationFrame(function() {
            var pw = popup.offsetWidth;
            var ph = popup.offsetHeight;
            var left = rect.left + (rect.width / 2) - (pw / 2);
            left = Math.max(8, Math.min(left, window.innerWidth - pw - 8));
            popup.style.left = left + 'px';
            if (rect.bottom + ph + 8 > window.innerHeight) {
                popup.style.top = Math.max(8, rect.top - ph - 8) + 'px';
            } else {
                popup.style.top = (rect.bottom + 8) + 'px';
            }
        });
    }

    document.addEventListener('click', function(e) {
        var popup = document.getElementById('status-legend-popup');
        if (popup && popup.classList.contains('open') &&
            !e.target.closest('#status-legend-popup') &&
            !e.target.closest('#status-legend-trigger')) {
            popup.classList.remove('open');
        }
    });

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() { openModal('add-modal'); });
    @endif

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session("success") }}', 'success');
        });
    @endif

    filtered = staffList.slice();
    renderTable();
</script>
@endsection
