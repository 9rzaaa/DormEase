@extends('layout')

@section('title', 'DormEase: Visitor Logs')
@section('page-title', 'Visitor Logs')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
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

    .header-actions {
        display: flex;
        gap: .75rem;
        align-items: center;
        margin-top: .5rem;
    }

    .btn-outline {
        display: flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1.2rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--ink-muted);
        border: 1.5px solid var(--gray-light);
        font-size: .87rem;
        font-weight: 600;
        transition: border-color .2s, color .2s;
        cursor: pointer;
        font-family: var(--ff-body);
    }
    .btn-outline:hover { border-color: var(--hot-pink); color: var(--hot-pink); }

    .btn-archive-open {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1.2rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--hot-pink);
        border: 1.5px solid var(--gray-light);
        font-size: .87rem;
        font-weight: 600;
        cursor: pointer;
        transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }
    .btn-archive-open:hover { border-color: var(--hot-pink); color: var(--hot-pink); }
    .btn-archive-open img { width: 14px; height: 14px; object-fit: contain; opacity: .55; }
    .btn-archive-open:hover img { opacity: 1; }

    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }

    .stat-box {
        background: var(--gradient-pink);
        border-radius: 20px;
        border: none;
        box-shadow: var(--shadow-stats);
        padding: 1.6rem 1.8rem;
        display: flex;
        align-items: center;
        gap: 1.4rem;
        box-sizing: border-box;
        min-width: 0;
        overflow: hidden;
    }

    .stat-icon-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,.25);
    }

    .stat-icon-circle img {
        width: 34px;
        height: 34px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
    }

    .stat-num {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--white);
        line-height: 1;
        letter-spacing: -.03em;
    }

    .stat-label {
        font-size: .85rem;
        color: var(--white);
        font-weight: 700;
        margin-top: .2rem;
    }

    .stat-sub {
        font-size: .76rem;
        color: var(--white);
        font-weight: 500;
        margin-top: .15rem;
    }

    @media (max-width: 640px) {
        .stats-row { grid-template-columns: 1fr; }
    }

    .table-card {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--bright-pink);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-header {
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--white);
        flex-wrap: wrap;
        gap: .8rem;
        border-bottom: 1px solid var(--bright-pink);
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--bright-pink);
        line-height: 1.2;
    }

    .table-date {
        font-size: .78rem;
        color: var(--black);
        margin-top: .1rem;
    }

    .table-controls {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: nowrap;
    }

    .ctrl-input {
        padding: .5rem .9rem;
        border-radius: 10px;
        border: 1px solid var(--pink-100);
        font-size: .85rem;
        outline: none;
        background: var(--white);
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
        color: var(--ink);
        font-family: var(--ff-body);
        transition: border-color .2s, box-shadow .2s;
    }
    .ctrl-input::placeholder { color: var(--gray); }
    .ctrl-input:focus {
        border-color: var(--hot-pink);
        box-shadow: 0 0 0 2px rgba(232,23,93,.12), 0 4px 12px rgba(0,0,0,.08);
    }

    .ctrl-input-search { width: 160px; }
    .ctrl-input-sort   { width: 120px; cursor: pointer; }
    .ctrl-input-date   { width: 130px; cursor: pointer; }

    .ctrl-label {
        font-size: .8rem;
        font-weight: 700;
        color: var(--ink);
        white-space: nowrap;
    }

    .filter-divider {
        width: 1px;
        height: 20px;
        background: var(--bright-pink);
        flex-shrink: 0;
    }

    .range-sep {
        font-size: .8rem;
        font-weight: 700;
        color: var(--gray);
        white-space: nowrap;
    }

    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        min-width: 980px;
    }

    th {
        padding: .75rem 1rem;
        font-size: .75rem;
        text-transform: uppercase;
        color: var(--bright-pink);
        background: var(--pink-bg);
        text-align: left;
        font-weight: 700;
        white-space: nowrap;
        border-bottom: 1px solid var(--bright-pink);
    }

    th:nth-child(8),
    th:nth-child(9) { text-align: center; }

    td {
        padding: .9rem 1rem;
        font-size: .875rem;
        text-align: left;
        vertical-align: middle;
    }

    td:nth-child(8),
    td:nth-child(9) { text-align: center; }

    tbody tr:hover { background: #fff7fb; }

    .badge { padding: .28rem .75rem; border-radius: 7px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
    .badge-approved,
    .badge-completed { background: #e8faf5; color: var(--green); border: 1.5px solid var(--green); }
    .badge-pending   { background: #fff9e6; color: #c8960c;      border: 1.5px solid #f0c040;      }
    .badge-denied    { background: #fff0f0; color: var(--red);   border: 1.5px solid var(--baby-pink); }
    .badge-inside    { background: var(--petal); color: var(--hot-pink); border: 1.5px solid var(--baby-pink); }

    .time-pending { color: var(--gray); font-style: italic; font-size: .78rem; }

    .act-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--baby-pink);
        background: var(--white);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
        font-family: var(--ff-body);
    }
    .act-btn:hover {
        border-color: var(--blush-pink);
        box-shadow: 0 4px 12px rgba(232,23,93,.18);
        background: #fff7fb;
    }
    .act-btn img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .visitor-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(20,0,10,.55);
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        backdrop-filter: blur(3px);
    }

    .visitor-modal-card {
        background: var(--white);
        width: 580px;
        max-width: 100%;
        max-height: 92vh;
        overflow-y: auto;
        border-radius: 24px;
        box-shadow: 0 24px 64px rgba(232,23,93,.18), 0 8px 24px rgba(0,0,0,.1);
        position: relative;
        animation: modalFade .25s cubic-bezier(.22,1,.36,1);
        display: flex;
        flex-direction: column;
    }

    .visitor-modal-card::-webkit-scrollbar { width: 4px; }
    .visitor-modal-card::-webkit-scrollbar-track { background: transparent; }
    .visitor-modal-card::-webkit-scrollbar-thumb { background: #f5b8cf; border-radius: 99px; }

    @keyframes modalFade {
        from { opacity: 0; transform: translateY(14px) scale(.97); }
        to   { opacity: 1; transform: translateY(0)    scale(1);   }
    }

    .modal-header {
        padding: 1.2rem 1.8rem .6rem;
        border-bottom: 1px solid var(--bright-pink);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-shrink: 0;
        background: linear-gradient(135deg, #fff5f9 0%, #ffffff 100%);
        border-radius: 24px 24px 0 0;
    }

    .modal-header-info { flex: 1; min-width: 0; }

    .modal-header-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--black);
        letter-spacing: -.02em;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .modal-header-id {
        font-size: .78rem;
        font-weight: 700;
        color: var(--hot-pink);
        margin-top: .25rem;
        letter-spacing: .04em;
    }

    .modal-header-badges {
        display: flex;
        gap: .4rem;
        margin-top: .35rem;
        flex-wrap: wrap;
    }

    .modal-header-badge {
        font-size: .7rem;
        font-weight: 700;
        padding: .22rem .65rem;
        border-radius: 99px;
        background: var(--petal);
        color: var(--hot-pink);
        border: 1px solid var(--baby-pink);
        letter-spacing: .02em;
    }

    .modal-close-btn {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        color: var(--ink-muted);
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color .2s, color .2s, background .2s;
        line-height: 1;
        flex-shrink: 0;
        margin-top: .1rem;
    }
    .modal-close-btn:hover { border-color: var(--hot-pink); color: var(--hot-pink); background: #fff0f5; }

    .modal-tabs {
        display: flex;
        border-bottom: 1px solid var(--bright-pink);
        background: var(--white);
        padding: 0 1.2rem;
        flex-shrink: 0;
        margin-top: -1.2rem;
    }

    .modal-tab {
        padding: .8rem 1.1rem;
        font-size: .8rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: none;
        border: none;
        border-bottom: 2.5px solid transparent;
        margin-bottom: -1px;
        cursor: pointer;
        transition: color .2s, border-color .2s;
        font-family: var(--ff-body);
        letter-spacing: .02em;
    }
    .modal-tab:hover { color: var(--hot-pink); }
    .modal-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

    .modal-body {
        padding: 1.2rem 1.8rem 1.2rem;
        flex: 1;
    }

    .modal-tab-panel { display: none; }
    .modal-tab-panel.active { display: block; }

    .modal-section-label {
        font-size: .67rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--hot-pink);
        margin: 1rem 0 .55rem;
    }
    .modal-section-label:first-child { margin-top: 0; }

    .modal-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem .8rem;
    }

    .modal-info-item {
        background: #fff5f9;
        border: 1px solid #fce4ef;
        border-radius: 12px;
        padding: .7rem 1rem;
        transition: background .15s;
    }
    .modal-info-item:hover { background: #ffeef5; }
    .modal-info-item.full { grid-column: 1 / -1; }

    .modal-info-item-label {
        font-size: .65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--hot-pink);
        margin-bottom: .22rem;
        opacity: .8;
    }

    .modal-info-item-value {
        font-size: .88rem;
        font-weight: 600;
        color: var(--black);
        line-height: 1.35;
    }

    .modal-time-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: .6rem .8rem;
        margin-top: .55rem;
    }

    .modal-photo-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: .25rem 0;
    }

    .modal-photo-frame {
        width: 100%;
        aspect-ratio: 4 / 3;
        background: #fff5f9;
        border: 1.5px solid #fce4ef;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .modal-photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 12px;
    }

    .modal-photo-no {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--ink-muted);
    }

    .modal-photo-no-icon {
        font-size: 2.4rem;
        margin-bottom: .45rem;
        opacity: .3;
        display: block;
    }

    .modal-photo-no p {
        margin: 0;
        font-size: .83rem;
        font-weight: 600;
        color: var(--ink-muted);
    }

    .modal-photo-actions {
        display: flex;
        gap: .65rem;
    }

    .modal-photo-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.2rem;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
        font-family: var(--ff-body);
        text-decoration: none;
    }

    .modal-photo-btn-primary {
        background: var(--hot-pink);
        color: var(--white);
        border: none;
    }
    .modal-photo-btn-primary:hover { background: #c8144f; }

    .modal-photo-btn-outline {
        background: var(--white);
        color: var(--hot-pink);
        border: 1.5px solid var(--baby-pink);
    }
    .modal-photo-btn-outline:hover { border-color: var(--hot-pink); background: #fff7fb; }

    .photo-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(10,0,6,.88);
        z-index: 10001;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(6px);
        animation: lbFade .2s ease;
    }

    @keyframes lbFade {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .photo-lightbox-inner {
        position: relative;
        max-width: min(860px, 100%);
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .photo-lightbox-inner img {
        max-width: 100%;
        max-height: 78vh;
        object-fit: contain;
        border-radius: 14px;
        box-shadow: 0 24px 80px rgba(0,0,0,.6);
        animation: lbImg .25s cubic-bezier(.22,1,.36,1);
    }

    @keyframes lbImg {
        from { transform: scale(.92); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .photo-lightbox-close {
        position: absolute;
        top: -14px;
        right: -14px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        border: 1.5px solid rgba(255,255,255,.3);
        color: var(--white);
        font-size: 1.2rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
    }
    .photo-lightbox-close:hover { background: rgba(255,255,255,.28); }

    .photo-lightbox-caption {
        font-size: .78rem;
        color: rgba(255,255,255,.55);
        font-weight: 500;
        text-align: center;
    }

    .photo-lightbox-open-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .45rem 1.1rem;
        border-radius: 9px;
        font-size: .8rem;
        font-weight: 700;
        cursor: pointer;
        background: rgba(255,255,255,.12);
        color: var(--white);
        border: 1.5px solid rgba(255,255,255,.25);
        text-decoration: none;
        transition: background .2s;
        font-family: var(--ff-body);
    }
    .photo-lightbox-open-btn:hover { background: rgba(255,255,255,.22); }

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
        background: #fff5f8;
        z-index: 500;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(0,0,0,.18);
    }
    .archive-drawer.open { transform: translateX(0); }

    .archive-drawer-header {
        padding: 1.6rem 1.8rem 1.2rem;
        border-bottom: 1.5px solid var(--gray-light);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-shrink: 0;
        background: var(--white);
    }
    .archive-drawer-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--black);
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
        border: 1.5px solid var(--gray-light);
        color: var(--hot-pink);
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color .2s, background .2s;
        flex-shrink: 0;
    }
    .archive-close-btn:hover { border-color: var(--hot-pink); background: #fff7fb; }

    .archive-tabs {
        display: flex;
        gap: 0;
        padding: 0 1.8rem;
        border-bottom: 1.5px solid var(--gray-light);
        flex-shrink: 0;
        background: var(--white);
    }
    .archive-tab {
        padding: .85rem 1.2rem;
        font-size: .82rem;
        font-weight: 700;
        color: var(--ink-muted);
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -1.5px;
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
        background: var(--gray-light);
        color: var(--ink-muted);
        letter-spacing: .02em;
    }
    .archive-tab.active .archive-tab-count {
        background: var(--hot-pink);
        color: var(--white);
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
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        color: var(--black);
        font-size: .83rem;
        font-family: var(--ff-body);
        outline: none;
        transition: border-color .2s;
    }
    .archive-search-inner input::placeholder { color: var(--gray); }
    .archive-search-inner input:focus { border-color: var(--hot-pink); }
    .archive-search-icon {
        position: absolute;
        left: .75rem;
        width: 13px;
        height: 13px;
        opacity: .4;
        pointer-events: none;
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
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
    .archive-list::-webkit-scrollbar-thumb { background: var(--gray-light); border-radius: 99px; }

    .archive-card {
        background: var(--white);
        border: 1.5px solid var(--gray-light);
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
        background: #fff7fb;
        border-color: var(--bright-pink);
        box-shadow: 0 6px 18px rgba(232,23,93,.12);
        transform: translateY(-1px);
    }

    .archive-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .8rem;
        margin-bottom: .5rem;
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
    .archive-card-visitor {
        font-size: .88rem;
        font-weight: 700;
        color: var(--black);
        line-height: 1.3;
    }
    .archive-card-tenant {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .archive-card-meta {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-top: .6rem;
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
    }
    .archive-pill-purpose   { background: #fff0f7; color: var(--hot-pink); border: 1px solid var(--baby-pink); }
    .archive-pill-completed { background: #f0f0f0; color: #555; border: 1px solid #ddd; }
    .archive-pill-deleted   { background: #fff0f0; color: var(--red); border: 1px solid #ffc8d0; }

    .archive-card-footer {
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-top: .7rem;
        padding-top: .6rem;
        border-top: 1px solid var(--gray-light);
        font-size: .7rem;
        color: var(--ink-muted);
        font-weight: 500;
    }
    .archive-card-footer span { color: var(--black); font-weight: 600; }

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
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(14%) sepia(90%) saturate(4000%) hue-rotate(320deg) brightness(95%);
    }

    .archive-footer {
        padding: .9rem 1.8rem;
        border-top: 1.5px solid var(--gray-light);
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
        border: 1.5px solid var(--gray-light);
        border-radius: 8px;
        padding: .35rem .85rem;
        cursor: pointer;
        transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }
    .archive-export-btn:hover { border-color: var(--hot-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .6; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    .fade-up { animation: fadeIn .45s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s;  }
    .d4 { animation-delay: .28s; }

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--gray-light); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--black); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
    .export-menu button:hover { background: #fff7fb; color: var(--hot-pink); }
</style>
@endsection

@section('content')

<div class="archive-backdrop" id="archive-backdrop" onclick="closeArchive()"></div>

<div class="archive-drawer" id="archive-drawer">
    <div class="archive-drawer-header">
        <div>
            <div class="archive-drawer-title">Archive &amp; History</div>
            <div class="archive-drawer-sub">Record of completed and cancelled visitor logs</div>
        </div>
        <button class="archive-close-btn" onclick="closeArchive()">&#x2715;</button>
    </div>

    <div class="archive-tabs">
        <button class="archive-tab active" id="atab-completed" onclick="switchArchiveTab('completed')">
            Completed
            <span class="archive-tab-count" id="acount-completed">0</span>
        </button>
        <button class="archive-tab" id="atab-deleted" onclick="switchArchiveTab('deleted')">
            Deleted
            <span class="archive-tab-count" id="acount-deleted">0</span>
        </button>
        <button class="archive-tab" id="atab-cancelled" onclick="switchArchiveTab('cancelled')">
            Cancelled
            <span class="archive-tab-count" id="acount-cancelled">0</span>
        </button>
    </div>

    <div class="archive-search-bar">
        <div class="archive-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="archive-search-icon" alt="">
            <input type="text" id="archive-search" placeholder="Search archived visitor logs..." oninput="renderArchive()">
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
                <button onclick="exportArchiveCsv(); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportArchivePdf(); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

<div id="visitorModal" class="visitor-modal">
    <div class="visitor-modal-card">

        <div class="modal-header">
            <div class="modal-header-info">
                <div class="modal-header-name" id="modalHeaderName">—</div>
                <div class="modal-header-id"   id="modalHeaderId">VST-000</div>
                <div class="modal-header-badges" id="modalHeaderBadges"></div>
            </div>
            <button class="modal-close-btn" onclick="closeModal()">&#x2715;</button>
        </div>

        <div class="modal-tabs">
            <button class="modal-tab active" id="mtab-info"  onclick="switchModalTab('info')">Visitor Info</button>
            <button class="modal-tab"        id="mtab-photo" onclick="switchModalTab('photo')">ID Photo</button>
        </div>

        <div class="modal-body">

            <div class="modal-tab-panel active" id="mpanel-info">
                <div class="modal-section-label">Personal</div>
                <div class="modal-info-grid" id="minfo-personal"></div>

                <div class="modal-section-label">Visit Details</div>
                <div class="modal-info-grid" id="minfo-visit"></div>

                <div class="modal-section-label">Schedule &amp; Attendance</div>
                <div class="modal-info-grid modal-time-row" id="minfo-schedule"></div>

                <div class="modal-section-label">Log Info</div>
                <div class="modal-info-grid" id="minfo-log"></div>
            </div>

            <div class="modal-tab-panel" id="mpanel-photo">
                <div class="modal-section-label">ID Verification</div>
                <div class="modal-info-grid" id="minfo-idtype" style="margin-bottom:1rem;"></div>
                <div class="modal-photo-area" id="minfo-photo"></div>
            </div>

        </div>
    </div>
</div>

<div id="photoLightbox" class="photo-lightbox" onclick="closeLightbox(event)">
    <div class="photo-lightbox-inner">
        <button class="photo-lightbox-close" onclick="closeLightboxBtn()">&#x2715;</button>
        <img id="lightboxImg" src="" alt="ID Photo">
        <div style="display:flex;gap:.7rem;align-items:center;">
            <div class="photo-lightbox-caption" id="lightboxCaption">ID Photo</div>
            <a id="lightboxOpenLink" href="#" target="_blank" rel="noopener" class="photo-lightbox-open-btn">
                Open full image &#x2197;
            </a>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="page-header">
        <div>
            <h1>Visitor Logs</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-archive-open" onclick="openArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>
            <div class="export-dropdown" id="export-dropdown-main">
                <button class="btn-outline" onclick="toggleExportDropdown('export-dropdown-main')">
                    <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                    Export
                </button>
                <div class="export-menu" id="export-menu-main">
                    <button onclick="exportLogsCsv(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportLogsPdf(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/visitor.png') }}" alt="Visitors">
            </div>
            <div>
                <div class="stat-num">{{ $visitorsToday }}</div>
                <div class="stat-label">Visitors Today</div>
                <div class="stat-sub">Expected for {{ now()->format('M d, Y') }}</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" alt="Inside">
            </div>
            <div>
                <div class="stat-num">{{ $currentlyInside }}</div>
                <div class="stat-label">Currently Inside</div>
                <div class="stat-sub">Checked in, not yet checked out</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="table-title">All Visitors</div>
                <div class="table-date">as of {{ now()->format('F d, Y') }}</div>
            </div>

            <div class="table-controls">
                <input
                    type="text"
                    id="search-input"
                    class="ctrl-input ctrl-input-search"
                    placeholder="Search visitor..."
                    onkeyup="applyFilters()"
                >

                <div class="filter-divider"></div>

                <span class="ctrl-label">Sort:</span>
                <select id="sort-select" class="ctrl-input ctrl-input-sort" onchange="applyFilters()">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="name">Name</option>
                </select>

                <div class="filter-divider"></div>

                <span class="ctrl-label">Date:</span>
                <input type="date" id="date-from" class="ctrl-input ctrl-input-date" onchange="applyFilters()">
                <span class="range-sep">—</span>
                <input type="date" id="date-to" class="ctrl-input ctrl-input-date" onchange="applyFilters()">
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <colgroup>
                    <col style="width:12%;">
                    <col style="width:12%;">
                    <col style="width:12%;">
                    <col style="width:12%;">
                    <col style="width:13%;">
                    <col style="width:14%;">
                    <col style="width:10%;">
                    <col style="width:8%;">
                    <col style="width:7%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Expected Visit</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Purpose</th>
                        <th>Tenant Visited</th>
                        <th>Logged By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="logs-tbody"></tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>

    const logs              = @json($logs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    const completedVisitors = @json($completedVisitors, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    const deletedVisitors   = @json($deletedVisitors, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    const cancelledVisitors = @json($cancelledVisitors, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    let filtered   = Array.isArray(logs) ? [...logs] : [];
    let archiveTab = 'completed';

    const eyeIcon = "{{ asset('icons/eye.png') }}";

    function fmtDateTime(dt) {
        if (!dt) return '—';
        const d = new Date(dt);
        return d.toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' })
             + ' ' + d.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit' });
    }

    function fmtDate(s) {
        if (!s) return '—';
        const d = new Date(s + 'T00:00:00');
        return d.toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' });
    }

    function fmtTime(s) {
        if (!s) return '—';
        const [h, m] = s.split(':');
        const hour = parseInt(h, 10);
        return `${hour % 12 || 12}:${m} ${hour >= 12 ? 'PM' : 'AM'}`;
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
        const dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month:'2-digit', day:'2-digit', year:'numeric' })
             + ' ' + dt.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit', hour12:true });
    }

    function applyFilters() {
        const q    = document.getElementById('search-input').value.toLowerCase().trim();
        const from = document.getElementById('date-from').value;
        const to   = document.getElementById('date-to').value;
        const sort = document.getElementById('sort-select').value;

        filtered = logs.filter(function(v) {
            const matchesSearch = !q
                || (v.visitor_name ?? '').toLowerCase().includes(q)
                || (v.tenant?.name ?? '').toLowerCase().includes(q)
                || (v.purpose      ?? '').toLowerCase().includes(q)
                || (v.staff?.name  ?? '').toLowerCase().includes(q);

            const visitDate   = v.date_of_visit ?? '';
            const matchesFrom = !from || visitDate >= from;
            const matchesTo   = !to   || visitDate <= to;

            return matchesSearch && matchesFrom && matchesTo;
        });

        filtered.sort(function(a, b) {
            if (sort === 'newest') return (b.date_of_visit ?? '').localeCompare(a.date_of_visit ?? '') || (b.id - a.id);
            if (sort === 'oldest') return (a.date_of_visit ?? '').localeCompare(b.date_of_visit ?? '') || (a.id - b.id);
            if (sort === 'name')   return (a.visitor_name  ?? '').localeCompare(b.visitor_name  ?? '');
            return 0;
        });

        renderTable();
    }

    function renderTable() {
        const tbody = document.getElementById('logs-tbody');

        if (!filtered.length) {
            tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:2.5rem;color:#bbb;font-size:.9rem;border:1px solid var(--bright-pink);">No visitor logs found.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(function(v) {
            const expectedVisit = (v.date_of_visit || v.time_of_visit)
                ? fmtDate(v.date_of_visit) + ' ' + fmtTime(v.time_of_visit)
                : '—';

            const timeIn = v.arrival_time
                ? fmtDateTime(v.arrival_time)
                : '<span class="time-pending">Not yet</span>';

            const timeOut = v.departure_time
                ? fmtDateTime(v.departure_time)
                : (v.arrival_time
                    ? '<span style="color:#c8960c;font-size:.8rem;font-weight:600">Still Inside</span>'
                    : '—');

            return '<tr>'
                + '<td style="font-weight:600">' + (v.visitor_name ?? '—') + '</td>'
                + '<td>' + expectedVisit + '</td>'
                + '<td>' + timeIn + '</td>'
                + '<td>' + timeOut + '</td>'
                + '<td>' + (v.purpose ?? '—') + '</td>'
                + '<td>' + (v.tenant?.full_name ?? '—') + '</td>'
                + '<td>' + (v.staff?.name ?? '—') + '</td>'
                + '<td>' + getStatusBadge(v.status) + '</td>'
                + '<td>'
                    + '<button class="act-btn" title="View details" onclick="viewVisitor(' + v.id + ')">'
                        + '<img src="' + eyeIcon + '" alt="View">'
                    + '</button>'
                + '</td>'
                + '</tr>';
        }).join('');
    }

    function getStatusBadge(status) {
        if (!status) return '—';
        const map = {
            approved:           'badge-approved',
            completed:          'badge-completed',
            pending:            'badge-pending',
            denied:             'badge-denied',
            rejected:           'badge-denied',
            cancelled:          'badge-denied',
            deleted:            'badge-denied',
            inside:             'badge-inside',
            'currently inside': 'badge-inside',
        };
        const cls   = map[status.toLowerCase()] ?? '';
        const label = status.replace(/\b\w/g, function(c) { return c.toUpperCase(); });
        return '<span class="badge ' + cls + '">' + label + '</span>';
    }

    function infoItem(label, value, full) {
        return '<div class="modal-info-item' + (full ? ' full' : '') + '">'
            + '<div class="modal-info-item-label">' + label + '</div>'
            + '<div class="modal-info-item-value">' + value + '</div>'
            + '</div>';
    }

    function switchModalTab(tab) {
        ['info', 'photo'].forEach(function(t) {
            document.getElementById('mtab-' + t).classList.toggle('active',   t === tab);
            document.getElementById('mpanel-' + t).classList.toggle('active', t === tab);
        });
    }

    function viewVisitor(id) {
        const v = logs.find(function(item) { return item.id === id; });
        if (!v) return;

        document.getElementById('modalHeaderName').textContent = v.visitor_name ?? '—';
        document.getElementById('modalHeaderId').textContent   = 'VST-' + String(v.id).padStart(3, '0');

        var bBadges = '';
        if (v.status)  bBadges += '<span class="modal-header-badge">' + v.status.replace(/\b\w/g, function(c){ return c.toUpperCase(); }) + '</span>';
        if (v.purpose) bBadges += '<span class="modal-header-badge">' + v.purpose + '</span>';
        document.getElementById('modalHeaderBadges').innerHTML = bBadges;

        document.getElementById('minfo-personal').innerHTML =
            infoItem('Full Name',    v.visitor_name ?? '—')
            + infoItem('Contact No.', v.contact_no  ?? '—');

        document.getElementById('minfo-visit').innerHTML =
            infoItem('Purpose',        v.purpose            ?? '—')
            + infoItem('Tenant Visited', v.tenant?.full_name ?? '—');

        const timeInVal  = v.arrival_time   ? fmtDateTime(v.arrival_time)   : '<span style="color:#bbb;font-style:italic;font-size:.8rem">Not yet</span>';
        const timeOutVal = v.departure_time ? fmtDateTime(v.departure_time) : (v.arrival_time ? '<span style="color:#c8960c;font-weight:700">Still Inside</span>' : '—');

        document.getElementById('minfo-schedule').innerHTML =
            infoItem('Expected Date', fmtDate(v.date_of_visit))
            + infoItem('Expected Time', fmtTime(v.time_of_visit))
            + infoItem('Time In',  timeInVal)
            + infoItem('Time Out', timeOutVal);

        document.getElementById('minfo-log').innerHTML =
            infoItem('Status',    getStatusBadge(v.status))
            + infoItem('Logged By', v.staff?.name ?? '—');

        document.getElementById('minfo-idtype').innerHTML =
            infoItem('ID Type', v.id_type ?? '—', true);

        var photoArea = '';
        if (v.id_photo) {
            var src = v.id_photo.startsWith('http') ? v.id_photo : '/storage/' + v.id_photo;
            window.__currentPhotoSrc = src;
            photoArea =
                '<div class="modal-photo-frame">'
                    + '<img src="' + src + '" alt="ID Photo" id="modal-id-photo" onerror="document.getElementById(\'modal-id-photo\').style.display=\'none\'; document.getElementById(\'modal-photo-error\').style.display=\'flex\';">'
                    + '<div id="modal-photo-error" class="modal-photo-no" style="display:none;">'
                        + '<span class="modal-photo-no-icon"></span>'
                        + '<p>Could not load photo.</p>'
                    + '</div>'
                + '</div>'
                + '<div class="modal-photo-actions">'
                    + '<button class="modal-photo-btn modal-photo-btn-primary" onclick="openLightbox(window.__currentPhotoSrc, \'' + (v.id_type ?? 'ID Photo') + '\')">'
                        + '🔍 View Photo'
                    + '</button>'
                    + '<a class="modal-photo-btn modal-photo-btn-outline" href="' + src + '" target="_blank" rel="noopener">'
                        + '↗ Open Full Image'
                    + '</a>'
                + '</div>';
        } else {
            photoArea =
                '<div class="modal-photo-frame">'
                    + '<div class="modal-photo-no">'
                        + '<span class="modal-photo-no-icon"></span>'
                        + '<p>No ID photo uploaded.</p>'
                    + '</div>'
                + '</div>';
        }
        document.getElementById('minfo-photo').innerHTML = photoArea;

        switchModalTab('info');
        document.getElementById('visitorModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('visitorModal').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('visitorModal')) closeModal();
    });

    function openLightbox(src, caption) {
        var lb = document.getElementById('photoLightbox');
        document.getElementById('lightboxImg').src             = src;
        document.getElementById('lightboxOpenLink').href       = src;
        document.getElementById('lightboxCaption').textContent = caption || 'ID Photo';
        lb.style.display = 'flex';
    }

    function closeLightbox(e) {
        if (e.target === document.getElementById('photoLightbox')) {
            document.getElementById('photoLightbox').style.display = 'none';
        }
    }

    function closeLightboxBtn() {
        document.getElementById('photoLightbox').style.display = 'none';
    }

    function openArchive() {
        document.getElementById('acount-completed').textContent  = Array.isArray(completedVisitors)  ? completedVisitors.length  : 0;
        document.getElementById('acount-deleted').textContent    = Array.isArray(deletedVisitors)    ? deletedVisitors.length    : 0;
        document.getElementById('acount-cancelled').textContent  = Array.isArray(cancelledVisitors)  ? cancelledVisitors.length  : 0;
        document.getElementById('archive-search').value = '';
        archiveTab = 'completed';
        document.getElementById('atab-completed').classList.add('active');
        document.getElementById('atab-deleted').classList.remove('active');
        document.getElementById('atab-cancelled').classList.remove('active');
        renderArchive();
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-completed').classList.toggle('active', tab === 'completed');
        document.getElementById('atab-deleted').classList.toggle('active',   tab === 'deleted');
        document.getElementById('atab-cancelled').classList.toggle('active', tab === 'cancelled');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    function renderArchive() {
        const q = document.getElementById('archive-search').value.toLowerCase();

        let data;
        if (archiveTab === 'completed') {
            data = Array.isArray(completedVisitors) ? completedVisitors : [];
        } else if (archiveTab === 'deleted') {
            data = Array.isArray(deletedVisitors) ? deletedVisitors : [];
        } else {
            data = Array.isArray(cancelledVisitors) ? cancelledVisitors : [];
        }

        const result = data.filter(function(v) {
            return (v.visitor_name ?? '').toLowerCase().includes(q)
                || (v.purpose      ?? '').toLowerCase().includes(q)
                || (v.tenant?.name ?? v.tenant?.full_name ?? '').toLowerCase().includes(q);
        });

        const list = document.getElementById('archive-list');
        document.getElementById('archive-count-label').textContent = result.length + ' record' + (result.length !== 1 ? 's' : '');

        if (result.length === 0) {
            list.innerHTML = '<div class="archive-empty">'
                + '<img class="archive-empty-icon" src="{{ asset('icons/visitor.png') }}" alt="">'
                + 'No ' + archiveTab + ' visitor logs found.'
                + '</div>';
            return;
        }

        const pillClass   = archiveTab === 'completed' ? 'archive-pill-completed' : 'archive-pill-deleted';
        const pillLabel   = archiveTab === 'completed' ? 'Completed' : (archiveTab === 'deleted' ? 'Deleted' : 'Cancelled');
        const footerLabel = archiveTab === 'completed' ? 'Checked out on' : (archiveTab === 'deleted' ? 'Deleted on' : 'Cancelled on');

        list.innerHTML = result.map(function(v, i) {
            const tenantName = v.tenant?.full_name ?? v.tenant?.name ?? null;
            const roomNum    = v.tenant?.room_number ?? null;
            const logId      = v.visitor_id ?? v.id ?? 0;
            const logTime = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
            const footerDate = archiveTab === 'completed'
                ? fmtDatePlain(v.departure_time ?? v.arrival_time)
                : logTime;

            return '<div class="archive-card" style="animation-delay:' + (i * 0.04) + 's;">'
                + '<div class="archive-card-top">'
                    + '<div class="archive-card-id">VST-' + String(logId).padStart(3, '0') + '</div>'
                    + '<div class="archive-card-time">' + logTime + '</div>'
                + '</div>'
                + '<div class="archive-card-visitor">' + (v.visitor_name ?? '—') + '</div>'
                + (tenantName ? '<div class="archive-card-tenant">Visited: ' + tenantName + (roomNum ? ' - Rm ' + roomNum : '') + '</div>' : '')
                + '<div class="archive-card-meta">'
                    + '<span class="archive-pill archive-pill-purpose">' + (v.purpose ?? 'Other') + '</span>'
                    + '<span class="archive-pill ' + pillClass + '">' + pillLabel + '</span>'
                + '</div>'
                + '<div class="archive-card-footer">'
                    + footerLabel + ': <span>' + footerDate + '</span>'
                + '</div>'
                + '</div>';
        }).join('');
    }

    function exportLogsCsv() {
        if (!filtered.length) { alert('No data to export.'); return; }

        var rows = [['Name', 'Expected Date', 'Expected Time', 'Time In', 'Time Out', 'Purpose', 'Tenant Visited', 'Logged By', 'Status']];
        filtered.forEach(function(v) {
            rows.push([
                v.visitor_name     ?? '',
                fmtDate(v.date_of_visit),
                fmtTime(v.time_of_visit),
                v.arrival_time   ? fmtDateTime(v.arrival_time)   : 'Not yet',
                v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside',
                v.purpose        ?? '',
                v.tenant?.full_name ?? '',
                v.staff?.name    ?? '',
                v.status         ?? '',
            ]);
        });

        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var a   = document.createElement('a');
        a.href  = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
        a.download = 'visitor_logs_' + new Date().toISOString().slice(0, 10) + '.csv';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    function exportLogsPdf() {
        if (!filtered.length) { alert('No data to export.'); return; }

        var win  = window.open('', '_blank');
        var rows = filtered.map(function(v) {
            return '<tr>'
                + '<td>' + (v.visitor_name ?? '') + '</td>'
                + '<td>' + fmtDate(v.date_of_visit) + ' ' + fmtTime(v.time_of_visit) + '</td>'
                + '<td>' + (v.arrival_time   ? fmtDateTime(v.arrival_time)   : 'Not yet') + '</td>'
                + '<td>' + (v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside') + '</td>'
                + '<td>' + (v.purpose ?? '') + '</td>'
                + '<td>' + (v.tenant?.full_name ?? '') + '</td>'
                + '<td>' + (v.staff?.name ?? '') + '</td>'
                + '<td>' + (v.status ?? '') + '</td>'
                + '</tr>';
        }).join('');

        win.document.write('<!DOCTYPE html><html><head><title>Visitor Logs</title>'
            + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<p>Visitor Logs - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
            + '<table><thead><tr><th>Name</th><th>Expected Visit</th><th>Time In</th><th>Time Out</th><th>Purpose</th><th>Tenant Visited</th><th>Logged By</th><th>Status</th></tr></thead>'
            + '<tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
    }

    function exportArchiveCsv() {
        let data;
        if (archiveTab === 'completed') {
            data = Array.isArray(completedVisitors) ? completedVisitors : [];
        } else if (archiveTab === 'deleted') {
            data = Array.isArray(deletedVisitors) ? deletedVisitors : [];
        } else {
            data = Array.isArray(cancelledVisitors) ? cancelledVisitors : [];
        }

        if (!data.length) { alert('No archive data to export.'); return; }

        const label = archiveTab === 'completed' ? 'Checked Out On' : (archiveTab === 'deleted' ? 'Deleted On' : 'Cancelled On');
        var rows = [['Log ID', 'Visitor Name', 'Contact No.', 'Purpose', 'Tenant Visited', 'Time In', 'Time Out', 'Status', label]];

        data.forEach(function(v) {
            const logId      = v.visitor_id ?? v.id ?? 0;
            const tenantName = v.tenant?.full_name ?? v.tenant?.name ?? '';
            const logTime = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
            const footerDate = archiveTab === 'completed'
                ? fmtDatePlain(v.departure_time ?? v.arrival_time)
                : logTime;

            rows.push([
                'VST-' + String(logId).padStart(3, '0'),
                v.visitor_name   ?? '',
                v.contact_no     ?? '',
                v.purpose        ?? '',
                tenantName,
                v.arrival_time   ?? '',
                v.departure_time ?? '',
                v.status         ?? '',
                footerDate,
            ]);
        });

        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var a   = document.createElement('a');
        a.href  = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
        a.download = 'visitor_logs_' + archiveTab + '_archive_' + new Date().toISOString().slice(0, 10) + '.csv';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    function exportArchivePdf() {
        let data;
        if (archiveTab === 'completed') {
            data = Array.isArray(completedVisitors) ? completedVisitors : [];
        } else if (archiveTab === 'deleted') {
            data = Array.isArray(deletedVisitors) ? deletedVisitors : [];
        } else {
            data = Array.isArray(cancelledVisitors) ? cancelledVisitors : [];
        }

        if (!data.length) { alert('No archive data to export.'); return; }

        const tabLabel   = archiveTab === 'completed' ? 'Completed' : (archiveTab === 'deleted' ? 'Deleted' : 'Cancelled');
        const footerHead = archiveTab === 'completed' ? 'Checked Out On' : (archiveTab === 'deleted' ? 'Deleted On' : 'Cancelled On');

        var win  = window.open('', '_blank');
        var rows = data.map(function(v) {
            const logId      = v.visitor_id ?? v.id ?? 0;
            const tenantName = v.tenant?.full_name ?? v.tenant?.name ?? '';
            const logTime = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
            const footerDate = archiveTab === 'completed'
                ? fmtDatePlain(v.departure_time ?? v.arrival_time)
                : logTime;

            return '<tr>'
                + '<td>VST-' + String(logId).padStart(3, '0') + '</td>'
                + '<td>' + (v.visitor_name ?? '') + '</td>'
                + '<td>' + (v.contact_no ?? '') + '</td>'
                + '<td>' + (v.purpose ?? '') + '</td>'
                + '<td>' + tenantName + '</td>'
                + '<td>' + (v.arrival_time   ? fmtDatePlain(v.arrival_time)   : '') + '</td>'
                + '<td>' + (v.departure_time ? fmtDatePlain(v.departure_time) : '') + '</td>'
                + '<td>' + (v.status ?? '') + '</td>'
                + '<td>' + footerDate + '</td>'
                + '</tr>';
        }).join('');

        win.document.write('<!DOCTYPE html><html><head><title>Visitor Logs Archive - ' + tabLabel + '</title>'
            + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<p>Visitor Logs Archive - ' + tabLabel + ' - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
            + '<table><thead><tr><th>Log ID</th><th>Visitor Name</th><th>Contact No.</th><th>Purpose</th><th>Tenant Visited</th><th>Time In</th><th>Time Out</th><th>Status</th><th>' + footerHead + '</th></tr></thead>'
            + '<tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
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

    applyFilters();

</script>
@endsection