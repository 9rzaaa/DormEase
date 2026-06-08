@extends('layout')

@section('title', 'DormEase: Document Management')
@section('page-title', 'Document Management')

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
    }

    .btn-archive {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .58rem 1.2rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--ink);
        border: 1.5px solid var(--baby-pink);
        font-size: .85rem;
        font-weight: 700;
        cursor: pointer;
        transition: border-color .2s, box-shadow .2s;
        font-family: var(--ff-body);
    }

    .btn-archive:hover {
        border-color: var(--bright-pink);
        box-shadow: 0 4px 14px rgba(232,23,93,.15);
    }

    .btn-archive img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        opacity: .5;
    }

    .tab-bar {
        display: flex;
        align-items: center;
        gap: 0;
        background: var(--white);
        border-radius: 12px;
        border: 1.5px solid var(--baby-pink);
        padding: .3rem;
        width: fit-content;
        box-shadow: 0 2px 8px rgba(232,23,93,.06);
    }

    .tab-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1.2rem;
        border-radius: 9px;
        border: none;
        background: transparent;
        font-size: .84rem;
        font-weight: 600;
        color: var(--ink-muted);
        cursor: pointer;
        transition: background .2s, color .2s, box-shadow .2s;
        font-family: var(--ff-body);
        white-space: nowrap;
    }

    .tab-btn:not(.active):hover {
        background: rgba(232,23,93,.07);
        color: var(--bright-pink);
    }

    .tab-btn:not(.active):hover img {
        opacity: .75;
        filter: invert(27%) sepia(90%) saturate(2000%) hue-rotate(315deg) brightness(90%);
    }

    .tab-btn img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        opacity: .5;
        transition: opacity .2s;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        box-shadow: 0 3px 10px rgba(232,23,93,.25);
    }

    .tab-btn.active img {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    .tab-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(232,23,93,.15);
        color: var(--bright-pink);
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 800;
        padding: 1px 6px;
        min-width: 18px;
    }

    .tab-btn.active .tab-badge {
        background: rgba(255,255,255,.25);
        color: var(--white);
    }

    .tab-panel { display: none; }
    .tab-panel.active { display: flex; flex-direction: column; gap: 1.2rem; }

    .toolbar {
        display: flex;
        align-items: center;
        gap: .7rem;
        flex-wrap: wrap;
    }

    .toolbar-label {
        font-size: .82rem;
        font-weight: 700;
        color: var(--ink-muted);
    }

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

    .search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-wrap input {
        padding: .45rem .85rem .45rem 2rem;
        border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        font-size: .82rem;
        color: var(--ink);
        outline: none;
        width: 200px;
        font-family: var(--ff-body);
        transition: border-color .2s, width .3s;
        box-shadow: 0 2px 8px rgba(232,23,93,.05);
    }

    .search-wrap input:focus {
        border-color: var(--bright-pink);
        width: 240px;
    }

    .search-icon {
        position: absolute;
        left: .6rem;
        width: 14px;
        height: 14px;
        opacity: .4;
        pointer-events: none;
    }

    .toolbar .search-wrap { margin-left: auto; }

    .toolbar-forms .search-wrap { margin-left: 0; }
    .toolbar-forms .btn-upload  { margin-left: auto; }

    .btn-upload {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .58rem 1.2rem;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border: none;
        font-size: .85rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(232,23,93,.3);
        transition: transform .2s, box-shadow .2s;
        font-family: var(--ff-body);
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(232,23,93,.38);
    }

    .btn-upload img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .table-card {
        flex: 1;
        background: var(--white);
        border-radius: 14px;
        border: 1px solid var(--bright-pink);
        box-shadow: 0 2px 16px rgba(232,23,93,.07);
        overflow: hidden;
    }

    .table-card-header {
        padding: 1rem 1.4rem;
        border-bottom: 1px solid var(--bright-pink);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .8rem;
        flex-wrap: wrap;
    }

    .table-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--ink);
    }

    .table-card-sub {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: .83rem;
    }

    thead th {
        padding: .65rem 1rem;
        text-align: left;
        font-size: .71rem;
        font-weight: 800;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .05em;
        background: linear-gradient(135deg, #fff0f7 0%, #fde8f0 100%);
        border-bottom: 1.5px solid rgba(232,23,93,.18);
        white-space: nowrap;
    }

    thead th.th-center {
        text-align: center;
    }

    tbody tr {
        border-bottom: 1px solid var(--petal);
        transition: background .18s, box-shadow .18s;
        position: relative;
    }

    tbody tr:last-child { border-bottom: none; }

    tbody tr:hover { background: linear-gradient(90deg, #fff0f7 0%, #fff7fb 100%); }

    tbody tr:hover td:first-child {
        box-shadow: inset 3px 0 0 var(--bright-pink);
    }

    tbody td {
        padding: .75rem 1rem;
        color: var(--ink);
        vertical-align: middle;
    }

    tbody td.td-center {
        text-align: center;
    }

    .doc-title-cell {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-weight: 600;
    }

    .doc-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .file-type-badge {
        display: inline-flex;
        align-items: center;
        padding: .18rem .5rem;
        border-radius: 5px;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .02em;
        white-space: nowrap;
        text-transform: uppercase;
    }

    .ft-pdf  { background: #fde8e8; color: #c0392b; border: 1px solid #f5b7b1; }
    .ft-img  { background: #e8f8e8; color: #27ae60; border: 1px solid #a9dfbf; }
    .ft-word { background: #e8f0fe; color: #1a73e8; border: 1px solid #aecbfa; }
    .ft-xl   { background: #e6f4ea; color: #188038; border: 1px solid #a8d5b5; }
    .ft-other{ background: #f5f5f5; color: #666;    border: 1px solid #ddd; }

    .req-status-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .75rem;
        border-radius: 20px;
        font-size: .7rem;
        font-weight: 800;
        white-space: nowrap;
        letter-spacing: .01em;
    }

    .req-status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
        display: inline-block;
    }

    .req-pending       { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .req-pending::before { background: #f9a825; box-shadow: 0 0 0 2px rgba(249,168,37,.2); }

    .req-approved      { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .req-approved::before { background: #43a047; box-shadow: 0 0 0 2px rgba(67,160,71,.2); }

    .req-denied        { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .req-denied::before { background: #e53935; box-shadow: 0 0 0 2px rgba(229,57,53,.2); }

    .req-processing    { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .req-processing::before { background: #1e88e5; box-shadow: 0 0 0 2px rgba(30,136,229,.2); }

    .req-ready         { background: #f3e5f5; color: #6a1b9a; border: 1px solid #ce93d8; }
    .req-ready::before { background: #8e24aa; box-shadow: 0 0 0 2px rgba(142,36,170,.2); }

    .req-resubmission  { background: #fff3e0; color: #bf360c; border: 1px solid #ffcc80; }
    .req-resubmission::before { background: #fb8c00; box-shadow: 0 0 0 2px rgba(251,140,0,.2); }

    .action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .3rem;
    }

    .act-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1.5px solid transparent;
        background: var(--white);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background .2s, border-color .2s, box-shadow .2s, transform .15s;
        font-family: var(--ff-body);
        position: relative;
    }

    .act-btn img {
        width: 13px;
        height: 13px;
        object-fit: contain;
        transition: transform .15s;
    }

    .act-btn:hover img { transform: scale(1.12); }

    .act-btn {
        background: rgba(232,23,93,.06);
        border-color: rgba(232,23,93,.18);
    }

    .act-btn:hover {
        background: rgba(232,23,93,.13);
        border-color: rgba(232,23,93,.38);
        box-shadow: 0 3px 10px rgba(232,23,93,.15);
    }

    .act-btn.danger {
        background: rgba(232,23,93,.06);
        border-color: rgba(232,23,93,.18);
    }

    .act-btn.danger:hover {
        background: rgba(232,23,93,.13);
        border-color: rgba(232,23,93,.38);
        box-shadow: 0 3px 10px rgba(232,23,93,.15);
    }

    .table-footer {
        padding: .85rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1.5px solid var(--petal);
        flex-wrap: wrap;
        gap: .5rem;
    }

    .table-info {
        font-size: .78rem;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .page-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid var(--bright-pink);
        background: var(--white);
        font-size: .8rem;
        font-weight: 700;
        color: var(--ink-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
        font-family: var(--ff-body);
    }

    .page-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .page-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        border-color: transparent;
        color: var(--white);
        box-shadow: 0 3px 10px rgba(232,23,93,.3);
    }

    .page-btn:disabled { opacity: .35; cursor: default; }

    .empty-state {
        text-align: center;
        padding: 2.8rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
        font-weight: 500;
        line-height: 1.6;
    }

    .empty-state img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        opacity: .25;
        display: block;
        margin: 0 auto .7rem;
        filter: invert(27%) sepia(90%) saturate(1500%) hue-rotate(315deg) brightness(85%);
        background: linear-gradient(135deg, #fff0f7, #fde8f0);
        padding: .6rem;
        border-radius: 12px;
        box-sizing: content-box;
        border: 1.5px solid rgba(232,23,93,.12);
    }

    .vd-tab-bar {
        display: flex;
        align-items: center;
        gap: 0;
        border-top: 1px solid var(--baby-pink);
        border-bottom: 1.5px solid var(--baby-pink);
        margin: 0 -1.4rem;
        padding: 0 1.4rem;
        background: var(--white);
    }

    .vd-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .55rem 1rem;
        border: none;
        border-bottom: 2.5px solid transparent;
        background: transparent;
        font-size: .8rem;
        font-weight: 700;
        color: var(--ink-muted);
        cursor: pointer;
        transition: color .2s, border-color .2s;
        font-family: var(--ff-body);
        white-space: nowrap;
        margin-bottom: -1.5px;
    }

    .vd-tab-btn.active {
        color: var(--bright-pink);
        border-bottom-color: var(--bright-pink);
    }

    .vd-tab-btn svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
        opacity: .6;
    }

    .vd-tab-btn.active svg {
        opacity: 1;
    }

    .vd-panel { display: none; padding-top: 1rem; }
    .vd-panel.active { display: block; }

    .vd-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem .8rem;
    }

    .vd-detail-grid.full { grid-template-columns: 1fr; }

    .vd-detail-item {
        display: flex;
        flex-direction: column;
        gap: .18rem;
        background: var(--blush);
        border: 1px solid var(--baby-pink);
        border-radius: 9px;
        padding: .55rem .75rem;
    }

    .vd-detail-item.span2 { grid-column: 1 / -1; }

    .vd-detail-label {
        font-size: .67rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .vd-detail-val {
        font-size: .84rem;
        color: var(--ink);
        font-weight: 600;
        line-height: 1.5;
    }

    .vd-file-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .8rem;
        padding: 1.6rem 1rem;
        background: var(--blush);
        border: 1.5px dashed var(--baby-pink);
        border-radius: 12px;
        text-align: center;
    }

    .vd-file-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        box-shadow: 0 4px 14px rgba(232,23,93,.25);
    }

    .vd-file-icon svg {
        width: 22px;
        height: 22px;
        color: white;
    }

    .vd-file-box p {
        font-size: .8rem;
        color: var(--ink-muted);
        margin: 0;
        line-height: 1.5;
    }

    .vd-file-box strong {
        display: block;
        font-size: .85rem;
        color: var(--ink);
        font-weight: 700;
        margin-bottom: .15rem;
    }

    .remark-box {
        background: var(--blush);
        border: 1.5px solid var(--baby-pink);
        border-radius: 10px;
        padding: .65rem .9rem;
        font-size: .83rem;
        color: var(--ink-muted);
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .btn-view-file {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1.1rem;
        border-radius: 9px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-size: .82rem;
        font-weight: 700;
        text-decoration: none;
        transition: opacity .2s;
    }

    .btn-view-file:hover { opacity: .88; }

    .vd-status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .6rem;
        padding: .6rem .75rem;
        background: var(--blush);
        border: 1px solid var(--baby-pink);
        border-radius: 9px;
    }

    .vd-status-label {
        font-size: .67rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    /* ── Other modal fields ── */
    .modal-field {
        display: flex;
        flex-direction: column;
        gap: .35rem;
        margin-bottom: .9rem;
    }

    .modal-field label {
        font-size: .75rem;
        font-weight: 700;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .modal-field input,
    .modal-field select,
    .modal-field textarea {
        width: 100%;
        padding: .6rem .9rem;
        border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--blush);
        font-size: .875rem;
        color: var(--ink);
        font-family: var(--ff-body);
        outline: none;
        box-sizing: border-box;
        transition: border-color .2s, background .2s;
    }

    .modal-field textarea { min-height: 80px; resize: vertical; }

    .modal-field input:focus,
    .modal-field select:focus,
    .modal-field textarea:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }

    .modal-field input[type="file"] {
        padding: .45rem .75rem;
        cursor: pointer;
    }

    .resubmission-toggle {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .65rem .9rem;
        background: #fff3e0;
        border: 1.5px solid #ffcc80;
        border-radius: 10px;
        margin-bottom: .9rem;
        cursor: pointer;
        user-select: none;
    }

    .resubmission-toggle input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--bright-pink);
        cursor: pointer;
        flex-shrink: 0;
        margin: 0;
        padding: 0;
        border: none;
        background: transparent;
    }

    .resubmission-toggle span {
        font-size: .82rem;
        font-weight: 700;
        color: #bf360c;
        line-height: 1.4;
    }

    .resubmission-toggle span small {
        display: block;
        font-weight: 500;
        color: #e65100;
        font-size: .75rem;
        margin-top: .15rem;
    }

    .view-detail-row {
        display: flex;
        flex-direction: column;
        gap: .15rem;
        padding: .6rem 0;
        border-bottom: 1px solid var(--bright-pink);
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
        line-height: 1.6;
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

    .archive-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.35);
        z-index: 1000;
        display: none;
        align-items: stretch;
        justify-content: flex-end;
    }

    .archive-drawer-overlay.open { display: flex; }

    .archive-drawer {
        width: min(780px, 100vw);
        background: var(--white);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        box-shadow: -6px 0 32px rgba(232,23,93,.12);
    }

    .drawer-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1.5px solid var(--baby-pink);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-shrink: 0;
        background: var(--white);
    }

    .drawer-header-text h2 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0;
    }

    .drawer-header-text span {
        font-size: .8rem;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .drawer-close {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ink-muted);
        transition: .2s;
        flex-shrink: 0;
        font-family: var(--ff-body);
    }

    .drawer-close:hover {
        border-color: var(--bright-pink);
        color: var(--bright-pink);
    }

    .drawer-tab-bar {
        display: flex;
        align-items: center;
        gap: 0;
        background: var(--blush);
        border-bottom: 1.5px solid var(--baby-pink);
        padding: .5rem 1.5rem 0;
        flex-shrink: 0;
    }

    .drawer-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1rem;
        border: none;
        border-bottom: 2.5px solid transparent;
        background: transparent;
        font-size: .83rem;
        font-weight: 600;
        color: var(--ink-muted);
        cursor: pointer;
        transition: color .2s, border-color .2s;
        font-family: var(--ff-body);
        white-space: nowrap;
        margin-bottom: -1.5px;
    }

    .drawer-tab-btn.active {
        color: var(--bright-pink);
        border-bottom-color: var(--bright-pink);
    }

    .drawer-tab-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(232,23,93,.12);
        color: var(--bright-pink);
        border-radius: 20px;
        font-size: .65rem;
        font-weight: 800;
        padding: 1px 6px;
        min-width: 18px;
    }

    .drawer-tab-btn.active .drawer-tab-badge {
        background: var(--bright-pink);
        color: var(--white);
    }

    .drawer-body {
        flex: 1;
        overflow-y: auto;
        padding: 1.2rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .drawer-panel { display: none; flex-direction: column; gap: 1rem; }
    .drawer-panel.active { display: flex; }

    .drawer-toolbar {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .archive-badge {
        display: inline-flex;
        align-items: center;
        padding: .18rem .55rem;
        border-radius: 6px;
        font-size: .68rem;
        font-weight: 800;
        background: #fff3e0;
        color: #e65100;
        border: 1px solid #ffcc80;
        white-space: nowrap;
    }

    .fade-up { animation: mFadeUp .45s ease both; }
    @keyframes mFadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
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
        .modal-two-col { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .archive-drawer { width: 100vw; }
        .vd-detail-grid { grid-template-columns: 1fr; }
    }

    .approved-zone {
        border-top: 1.5px solid var(--baby-pink);
        background: linear-gradient(135deg, #fff0f7 0%, #fff7fb 60%, #ffeef5 100%);
        position: relative;
    }

    .approved-zone::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--bright-pink) 0%, var(--hot-pink) 100%);
    }

    .approved-zone::after {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(232,23,93,.07) 0%, transparent 70%);
        pointer-events: none;
    }

    .approved-zone-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .8rem 1.4rem .8rem 1.4rem;
        cursor: pointer;
        user-select: none;
        transition: background .2s;
        position: relative;
        z-index: 1;
    }

    .approved-zone-header:hover {
        background: rgba(232,23,93,.045);
    }

    .approved-zone-header-left {
        display: flex;
        align-items: center;
        gap: .55rem;
    }

    .approved-zone-icon {
        width: 22px;
        height: 22px;
        border-radius: 7px;
        background: linear-gradient(135deg, var(--bright-pink) 0%, var(--hot-pink) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: white;
        box-shadow: 0 3px 8px rgba(232,23,93,.35);
    }

    .approved-zone-title {
        font-size: .85rem;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.015em;
    }

    .approved-zone-count {
        font-size: .66rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: white;
        border-radius: 100px;
        padding: 2px 9px;
        box-shadow: 0 2px 7px rgba(232,23,93,.3);
        letter-spacing: .01em;
    }

    .approved-zone-header-right {
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    .approved-zone-hint {
        font-size: .72rem;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .approved-chevron {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--hot-pink);
        background: rgba(232,23,93,.1);
        border-radius: 7px;
        border: 1px solid rgba(232,23,93,.2);
        transition: transform .35s cubic-bezier(.4,0,.2,1), background .2s, color .2s;
    }

    .approved-chevron.open {
        transform: rotate(180deg);
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: white;
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(232,23,93,.3);
    }

    .approved-zone-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height .42s cubic-bezier(.4,0,.2,1);
    }

    .approved-zone-body.open {
        max-height: 340px;
    }

    .approved-zone-inner {
        display: flex;
        flex-direction: column;
        gap: .8rem;
        padding: .9rem 1.4rem 1.1rem 1.4rem;
        border-top: 1px solid rgba(232,23,93,.12);
        position: relative;
        z-index: 1;
    }

    .approved-zone-toolbar {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .approved-tray-search {
        position: relative;
        display: flex;
        align-items: center;
    }

    .approved-tray-search input {
        padding: .36rem .8rem .36rem 1.85rem;
        border-radius: 9px;
        border: 1.5px solid rgba(232,23,93,.2);
        background: rgba(255,255,255,.85);
        font-size: .78rem;
        color: var(--ink);
        outline: none;
        width: 175px;
        font-family: var(--ff-body);
        transition: border-color .2s, width .3s, background .2s, box-shadow .2s;
        backdrop-filter: blur(4px);
    }

    .approved-tray-search input:focus {
        border-color: var(--bright-pink);
        background: var(--white);
        width: 210px;
        box-shadow: 0 0 0 3px rgba(232,23,93,.08);
    }

    .approved-tray-search img {
        position: absolute;
        left: .58rem;
        width: 12px;
        height: 12px;
        opacity: .45;
        pointer-events: none;
    }

    .approved-tray-info {
        font-size: .72rem;
        color: var(--ink-muted);
        font-weight: 600;
        background: rgba(255,255,255,.6);
        border: 1px solid rgba(232,23,93,.15);
        border-radius: 7px;
        padding: .22rem .6rem;
    }

    .approved-tray {
        display: flex;
        gap: .7rem;
        overflow-x: auto;
        padding: .25rem .25rem .45rem .25rem;
        margin: -.25rem -.25rem -.25rem -.25rem;
        scrollbar-width: thin;
        scrollbar-color: rgba(232,23,93,.25) transparent;
    }

    .approved-tray::-webkit-scrollbar { height: 3px; }
    .approved-tray::-webkit-scrollbar-track { background: transparent; }
    .approved-tray::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, var(--bright-pink), var(--hot-pink));
        border-radius: 99px;
    }

    .approved-card {
        flex-shrink: 0;
        width: 188px;
        background: var(--white);
        border-radius: 12px;
        border: 1.5px solid rgba(232,23,93,.15);
        padding: 0;
        display: flex;
        flex-direction: column;
        cursor: default;
        position: relative;
        transition: border-color .25s, background .2s;
        overflow: hidden;
    }

    .approved-card::before {
        content: '';
        display: block;
        height: 3px;
        width: 100%;
        background: linear-gradient(90deg, var(--bright-pink), var(--hot-pink));
        flex-shrink: 0;
    }

    .approved-card-inner {
        padding: .65rem .85rem .7rem;
        display: flex;
        flex-direction: column;
        gap: .42rem;
        flex: 1;
    }

    .approved-card:hover {
        border-color: rgba(232,23,93,.35);
        background: #fff8fb;
    }

    .approved-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .3rem;
    }

    .approved-card-id {
        font-size: .67rem;
        font-weight: 800;
        color: var(--hot-pink);
        letter-spacing: .01em;
    }

    .approved-card-approved-badge {
        display: inline-flex;
        align-items: center;
        gap: .22rem;
        font-size: .6rem;
        font-weight: 800;
        color: #2e7d32;
        background: #e8f5e9;
        border: 1px solid #a5d6a7;
        border-radius: 100px;
        padding: .12rem .45rem;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .approved-card-approved-badge svg {
        width: 7px;
        height: 7px;
        flex-shrink: 0;
        stroke: #2e7d32;
    }

    .approved-card-type {
        font-size: .8rem;
        font-weight: 700;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: .32rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .approved-card-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(255,255,255,.8), 0 0 0 3px currentColor;
    }

    .approved-card-tenant {
        font-size: .73rem;
        color: var(--ink-muted);
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .approved-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: .4rem;
        border-top: 1px solid rgba(232,23,93,.1);
        margin-top: auto;
    }

    .approved-card-date {
        font-size: .65rem;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .approved-card-view-btn {
        display: inline-flex;
        align-items: center;
        gap: .22rem;
        font-size: .65rem;
        font-weight: 700;
        color: var(--hot-pink);
        background: rgba(232,23,93,.08);
        border: 1px solid rgba(232,23,93,.2);
        border-radius: 6px;
        padding: .17rem .48rem;
        cursor: pointer;
        transition: background .2s, border-color .2s, box-shadow .2s;
        font-family: var(--ff-body);
    }

    .approved-card-view-btn:hover {
        background: rgba(232,23,93,.15);
        border-color: rgba(232,23,93,.35);
        box-shadow: 0 2px 6px rgba(232,23,93,.15);
    }

    .approved-empty {
        font-size: .82rem;
        color: var(--ink-muted);
        padding: .25rem 0;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-text">
            <h1>Document Management</h1>
            <div class="dorm-sub">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-archive" onclick="openArchiveDrawer()">
                <img src="{{ asset('icons/nav-docu.png') }}" alt="">
                Archive / History
            </button>
        </div>
    </div>

    <div class="fade-up d2">
        <div class="tab-bar">
            <button class="tab-btn active" id="tab-docs-btn" onclick="switchTab('docs')">
                <img src="{{ asset('icons/nav-docu.png') }}" alt="">
                Documents
                <span class="tab-badge" id="tab-docs-count">0</span>
            </button>
            <button class="tab-btn" id="tab-reqs-btn" onclick="switchTab('reqs')">
                <img src="{{ asset('icons/pending.png') }}" alt="">
                Document Requests
                <span class="tab-badge" id="tab-reqs-count">0</span>
            </button>
            <button class="tab-btn" id="tab-forms-btn" onclick="switchTab('forms')">
                <img src="{{ asset('icons/attach.png') }}" alt="">
                Downloadable Forms
                <span class="tab-badge" id="tab-forms-count">0</span>
            </button>
        </div>
    </div>

    <div class="tab-panel active fade-up d3" id="panel-docs">
        <div class="toolbar">
            <span class="toolbar-label">Status:</span>
            <select class="toolbar-select" id="doc-filter-status" onchange="docApplyFilters()">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="approved">Approved</option>
                <option value="resubmission">For Resubmission</option>
                <option value="denied">Denied</option>
            </select>

            <span class="toolbar-label">Sort:</span>
            <select class="toolbar-select" id="doc-sort" onchange="docApplyFilters()">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>

            <div class="search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                <input type="text" id="doc-search" placeholder="Search tenant, form type..." oninput="docApplyFilters()">
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <div class="table-card-title">Submitted Forms</div>
                    <div class="table-card-sub">Filled forms uploaded by tenants via the mobile app</div>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Submission ID</th>
                            <th>Tenant</th>
                            <th>Form Type</th>
                            <th>File</th>
                            <th>Submitted</th>
                            <th class="th-center">Status</th>
                            <th class="th-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="doc-tbody"></tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info" id="doc-info">Showing 0 entries</div>
                <div class="pagination" id="doc-pagination"></div>
            </div>
            <div class="approved-zone" id="approved-zone">
                <div class="approved-zone-header" onclick="toggleApprovedPanel()">
                    <div class="approved-zone-header-left">
                        <div class="approved-zone-icon">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <span class="approved-zone-title">Approved Submissions</span>
                        <span class="approved-zone-count" id="approved-count-badge">0</span>
                    </div>
                    <div class="approved-zone-header-right">
                        <span class="approved-zone-hint" id="approved-panel-hint">Click to expand</span>
                        <div class="approved-chevron" id="approved-chevron">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                </div>
                <div class="approved-zone-body" id="approved-panel-body">
                    <div class="approved-zone-inner">
                        <div class="approved-zone-toolbar">
                            <div class="approved-tray-search">
                                <img src="{{ asset('icons/search.png') }}" alt="">
                                <input type="text" id="approved-search" placeholder="Search approved..." oninput="approvedApplyFilters()">
                            </div>
                            <span class="approved-tray-info" id="approved-info"></span>
                            <div class="pagination" id="approved-pagination" style="margin-left:auto;"></div>
                        </div>
                        <div class="approved-tray" id="approved-cards-grid"></div>
                    </div>
                </div>
            </div>
        </div>

    <div class="tab-panel" id="panel-reqs">
        <div class="toolbar">
            <span class="toolbar-label">Status:</span>
            <select class="toolbar-select" id="req-filter-status" onchange="reqApplyFilters()">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="approved">Approved</option>
                <option value="ready">Ready</option>
                <option value="denied">Denied</option>
            </select>

            <span class="toolbar-label">Sort:</span>
            <select class="toolbar-select" id="req-sort" onchange="reqApplyFilters()">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>

            <div class="search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                <input type="text" id="req-search" placeholder="Search tenant, document type..." oninput="reqApplyFilters()">
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <div class="table-card-title">Document Requests</div>
                    <div class="table-card-sub">Certificate and document requests submitted by tenants</div>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Tenant</th>
                            <th>Document Type</th>
                            <th>Purpose</th>
                            <th>Delivery</th>
                            <th>Submitted</th>
                            <th class="th-center">Status</th>
                            <th class="th-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="req-tbody"></tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info" id="req-info">Showing 0 entries</div>
                <div class="pagination" id="req-pagination"></div>
            </div>
        </div>
    </div>

    <div class="tab-panel" id="panel-forms">
        <div class="toolbar toolbar-forms">
            <div class="search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                <input type="text" id="form-search" placeholder="Search form name..." oninput="formApplyFilters()">
            </div>
            <button class="btn-upload" onclick="openModal('upload-form-modal')">
                <img src="{{ asset('icons/attach.png') }}" alt="">
                Upload Form
            </button>
        </div>
        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <div class="table-card-title">Downloadable Forms</div>
                    <div class="table-card-sub">PDF forms tenants can download and fill out, automatically listed in the mobile app</div>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>File</th>
                            <th>Uploaded</th>
                            <th class="th-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="form-tbody"></tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info" id="form-info">Showing 0 entries</div>
                <div class="pagination" id="form-pagination"></div>
            </div>
        </div>
    </div>

</div>

<div class="archive-drawer-overlay" id="archive-drawer-overlay" onclick="handleDrawerOverlayClick(event)">
    <div class="archive-drawer" id="archive-drawer">
        <div class="drawer-header">
            <div class="drawer-header-text">
                <h2>Document Archive</h2>
                <span>Archived form submissions and document requests</span>
            </div>
            <button class="drawer-close" onclick="closeArchiveDrawer()">&#x2715;</button>
        </div>

        <div class="drawer-tab-bar">
            <button class="drawer-tab-btn active" id="dtab-docs-btn" onclick="switchDrawerTab('docs')">
                Submitted Forms
                <span class="drawer-tab-badge" id="dtab-docs-count">0</span>
            </button>
            <button class="drawer-tab-btn" id="dtab-reqs-btn" onclick="switchDrawerTab('reqs')">
                Document Requests
                <span class="drawer-tab-badge" id="dtab-reqs-count">0</span>
            </button>
            <button class="drawer-tab-btn" id="dtab-denied-btn" onclick="switchDrawerTab('denied')">
                Denied Submissions
                <span class="drawer-tab-badge" id="dtab-denied-count">0</span>
            </button>
        </div>

        <div class="drawer-body">
            <div class="drawer-panel active" id="dpanel-docs">
                <div class="drawer-toolbar">
                    <span class="toolbar-label">Status:</span>
                    <select class="toolbar-select" id="adoc-filter-status" onchange="adocApplyFilters()">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="approved">Approved</option>
                        <option value="resubmission">For Resubmission</option>
                        <option value="denied">Denied</option>
                    </select>
                    <span class="toolbar-label">Sort:</span>
                    <select class="toolbar-select" id="adoc-sort" onchange="adocApplyFilters()">
                        <option value="newest">Newest Archived</option>
                        <option value="oldest">Oldest Archived</option>
                    </select>
                    <div class="search-wrap" style="margin-left:auto;">
                        <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                        <input type="text" id="adoc-search" placeholder="Search tenant, form type..." oninput="adocApplyFilters()">
                    </div>
                </div>
                <div class="table-card" style="flex:unset;">
                    <div class="table-card-header">
                        <div>
                            <div class="table-card-title">Archived Form Submissions</div>
                            <div class="table-card-sub">Form submissions removed from the active list</div>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Submission ID</th>
                                    <th>Tenant</th>
                                    <th>Form Type</th>
                                    <th>File</th>
                                    <th class="th-center">Status</th>
                                    <th>Submitted</th>
                                    <th>Archived On</th>
                                    <th class="th-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="adoc-tbody"></tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="table-info" id="adoc-info">Showing 0 entries</div>
                        <div class="pagination" id="adoc-pagination"></div>
                    </div>
                </div>
            </div>

            <div class="drawer-panel" id="dpanel-reqs">
                <div class="drawer-toolbar">
                    <span class="toolbar-label">Status:</span>
                    <select class="toolbar-select" id="areq-filter-status" onchange="areqApplyFilters()">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="approved">Approved</option>
                        <option value="ready">Ready</option>
                        <option value="denied">Denied</option>
                    </select>
                    <span class="toolbar-label">Sort:</span>
                    <select class="toolbar-select" id="areq-sort" onchange="areqApplyFilters()">
                        <option value="newest">Newest Archived</option>
                        <option value="oldest">Oldest Archived</option>
                    </select>
                    <div class="search-wrap" style="margin-left:auto;">
                        <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                        <input type="text" id="areq-search" placeholder="Search tenant, document type..." oninput="areqApplyFilters()">
                    </div>
                </div>
                <div class="table-card" style="flex:unset;">
                    <div class="table-card-header">
                        <div>
                            <div class="table-card-title">Archived Document Requests</div>
                            <div class="table-card-sub">Requests removed from the active list</div>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Tenant</th>
                                    <th>Document Type</th>
                                    <th>Purpose</th>
                                    <th>Delivery</th>
                                    <th class="th-center">Status</th>
                                    <th>Submitted</th>
                                    <th>Archived On</th>
                                    <th class="th-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="areq-tbody"></tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="table-info" id="areq-info">Showing 0 entries</div>
                        <div class="pagination" id="areq-pagination"></div>
                    </div>
                </div>
            </div>

            <div class="drawer-panel" id="dpanel-denied">
            <div class="drawer-toolbar">
                <span class="toolbar-label">Sort:</span>
                <select class="toolbar-select" id="adenied-sort" onchange="adeniedApplyFilters()">
                    <option value="newest">Newest Archived</option>
                    <option value="oldest">Oldest Archived</option>
                </select>
                <div class="search-wrap" style="margin-left:auto;">
                    <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                    <input type="text" id="adenied-search" placeholder="Search tenant, form type..." oninput="adeniedApplyFilters()">
                </div>
            </div>
            <div class="table-card" style="flex:unset;">
                <div class="table-card-header">
                    <div>
                        <div class="table-card-title">Denied Submissions</div>
                        <div class="table-card-sub">Rejected and resubmission-flagged form submissions</div>
                    </div>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Submission ID</th>
                                <th>Tenant</th>
                                <th>Form Type</th>
                                <th>File</th>
                                <th class="th-center">Status</th>
                                <th>Submitted</th>
                                <th>Archived On</th>
                                <th class="th-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adenied-tbody"></tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <div class="table-info" id="adenied-info">Showing 0 entries</div>
                    <div class="pagination" id="adenied-pagination"></div>
                </div>
            </div>
        </div>

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

<div class="modal-overlay" id="view-doc-modal">
    <div class="modal" style="max-width:540px;">
        <div class="modal-header">
            <div class="modal-title">Form Submission Details</div>
            <button class="modal-close" onclick="closeModal('view-doc-modal')">&#x2715;</button>
        </div>

        <div class="vd-tab-bar">
            <button class="vd-tab-btn active" id="vd-tab-info-btn" onclick="switchVdTab('info')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Details
            </button>
            <button class="vd-tab-btn" id="vd-tab-file-btn" onclick="switchVdTab('file')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Uploaded File
            </button>
            <button class="vd-tab-btn" id="vd-tab-remarks-btn" onclick="switchVdTab('remarks')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Remarks
            </button>
        </div>

        <div class="vd-panel active" id="vd-panel-info">
            <div class="vd-detail-grid" id="vd-info-grid"></div>
        </div>

        <div class="vd-panel" id="vd-panel-file">
            <div id="vd-file-content"></div>
        </div>

        <div class="vd-panel" id="vd-panel-remarks">
            <div id="vd-remarks-content"></div>
        </div>

        <div class="modal-actions" style="margin-top:1rem;" id="view-doc-actions"></div>
    </div>
</div>

<div class="modal-overlay" id="update-doc-modal">
    <div class="modal" style="max-width:480px;">
        <div class="modal-header">
            <div class="modal-title">Review Submission</div>
            <button class="modal-close" onclick="closeModal('update-doc-modal')">&#x2715;</button>
        </div>
        <input type="hidden" id="upd-doc-id">
        <div class="modal-field">
            <label>Status</label>
            <select id="upd-doc-status" onchange="toggleRejectionField()">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="approved">Approved</option>
                <option value="denied">Denied</option>
            </select>
        </div>
        <div id="rejection-reason-wrap" style="display:none;">
            <div class="modal-field">
                <label>Reason for Rejection</label>
                <select id="upd-doc-rejection-preset" onchange="handleRejectionPreset()">
                    <option value="">Select a reason...</option>
                    <option value="Blurry or unreadable submission">Blurry or unreadable submission</option>
                    <option value="Incomplete form fields">Incomplete form fields</option>
                    <option value="Wrong form submitted">Wrong form submitted</option>
                    <option value="File is corrupted or unreadable">File is corrupted or unreadable</option>
                    <option value="Missing required signature">Missing required signature</option>
                    <option value="Photo or scan is too dark">Photo or scan is too dark</option>
                    <option value="File format not supported">File format not supported</option>
                    <option value="other">Other (specify below)</option>
                </select>
            </div>
            <div class="modal-field" id="rejection-other-wrap" style="display:none;">
                <label>Specify Reason</label>
                <input type="text" id="upd-doc-rejection-other" placeholder="Describe the rejection reason...">
            </div>
            <label class="resubmission-toggle" for="upd-doc-allow-resubmission">
                <input type="checkbox" id="upd-doc-allow-resubmission">
                <span>
                    Allow tenant to resubmit
                    <small>The tenant will be notified and can upload a corrected file through the mobile app.</small>
                </span>
            </label>
        </div>
        <div class="modal-field">
            <label>Additional Remarks (optional)</label>
            <textarea id="upd-doc-remarks" placeholder="Add any extra notes for the tenant..."></textarea>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('update-doc-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitUpdateDoc()">Save</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-doc-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Archive Submission</div>
            <button class="modal-close" onclick="closeModal('delete-doc-modal')">&#x2715;</button>
        </div>
        <div class="delete-warn">This submission will be moved to the archive and removed from the active list.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Archive submission <strong id="delete-doc-label" style="color:var(--ink);"></strong>?
        </p>
        <input type="hidden" id="delete-doc-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-doc-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmDeleteDoc()">Archive</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="view-req-modal">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">Request Details</div>
            <button class="modal-close" onclick="closeModal('view-req-modal')">&#x2715;</button>
        </div>
        <div id="view-req-content"></div>
        <div class="modal-actions" style="margin-top:1rem;" id="view-req-actions"></div>
    </div>
</div>

<div class="modal-overlay" id="update-req-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Update Request</div>
            <button class="modal-close" onclick="closeModal('update-req-modal')">&#x2715;</button>
        </div>
        <input type="hidden" id="upd-req-id">
        <div class="modal-field">
            <label>Status</label>
            <select id="upd-req-status" onchange="toggleReqRejectionField()">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="approved">Approved</option>
                <option value="ready">Ready for Pickup / Sending</option>
                <option value="denied">Denied</option>
            </select>
        </div>
        <div id="req-rejection-reason-wrap" style="display:none;">
            <div class="modal-field">
                <label>Reason for Denial</label>
                <select id="upd-req-rejection-preset" onchange="handleReqRejectionPreset()">
                    <option value="">Select a reason...</option>
                    <option value="Incomplete request details">Incomplete request details</option>
                    <option value="Purpose not clearly stated">Purpose not clearly stated</option>
                    <option value="Document type not offered by the dormitory">Document type not offered by the dormitory</option>
                    <option value="Tenant is not currently active">Tenant is not currently active</option>
                    <option value="Insufficient processing time given">Insufficient processing time given</option>
                    <option value="Document currently unavailable">Document currently unavailable</option>
                    <option value="other">Other (specify below)</option>
                </select>
            </div>
            <div class="modal-field" id="req-rejection-other-wrap" style="display:none;">
                <label>Specify Reason</label>
                <input type="text" id="upd-req-rejection-other" placeholder="Describe the denial reason...">
            </div>
        </div>
        <div class="modal-field">
            <label>Admin Remarks</label>
            <textarea id="upd-req-remarks" placeholder="Add remarks, denial reason, or pickup instructions..."></textarea>
        </div>
        <div class="modal-field">
            <label>Attach Fulfilled Document - PDF only (optional, for digital delivery)</label>
            <input type="file" id="upd-req-file" accept=".pdf">
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('update-req-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitUpdateReq()">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-req-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Archive Request</div>
            <button class="modal-close" onclick="closeModal('delete-req-modal')">&#x2715;</button>
        </div>
        <div class="delete-warn">This request will be moved to the archive and removed from the active list.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Archive request <strong id="delete-req-label" style="color:var(--ink);"></strong>?
        </p>
        <input type="hidden" id="delete-req-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-req-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmDeleteReq()">Archive</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="view-adoc-modal">
    <div class="modal" style="max-width:500px;z-index:1100;">
        <div class="modal-header">
            <div class="modal-title">Archived Submission Details</div>
            <button class="modal-close" onclick="closeModal('view-adoc-modal')">&#x2715;</button>
        </div>
        <div id="view-adoc-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-adoc-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="view-areq-modal">
    <div class="modal" style="max-width:520px;z-index:1100;">
        <div class="modal-header">
            <div class="modal-title">Archived Request Details</div>
            <button class="modal-close" onclick="closeModal('view-areq-modal')">&#x2715;</button>
        </div>
        <div id="view-areq-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-areq-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="remove-adoc-modal">
    <div class="modal" style="max-width:400px;z-index:1100;">
        <div class="modal-header">
            <div class="modal-title">Remove Archive Record</div>
            <button class="modal-close" onclick="closeModal('remove-adoc-modal')">&#x2715;</button>
        </div>
        <div class="delete-warn">This will permanently remove this record from the archive. This action cannot be undone.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Remove <strong id="remove-adoc-label" style="color:var(--ink);"></strong> from the archive?
        </p>
        <input type="hidden" id="remove-adoc-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('remove-adoc-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmRemoveAdoc()">Remove</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="remove-areq-modal">
    <div class="modal" style="max-width:400px;z-index:1100;">
        <div class="modal-header">
            <div class="modal-title">Remove Archive Record</div>
            <button class="modal-close" onclick="closeModal('remove-areq-modal')">&#x2715;</button>
        </div>
        <div class="delete-warn">This will permanently remove this record from the archive. This action cannot be undone.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Remove request <strong id="remove-areq-label" style="color:var(--ink);"></strong> from the archive?
        </p>
        <input type="hidden" id="remove-areq-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('remove-areq-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmRemoveAreq()">Remove</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="upload-form-modal">
    <div class="modal" style="max-width:480px;">
        <div class="modal-header">
            <div class="modal-title">Upload Downloadable Form</div>
            <button class="modal-close" onclick="closeModal('upload-form-modal')">&#x2715;</button>
        </div>
        <div class="modal-field">
            <label>Form Label</label>
            <input type="text" id="uf-label" placeholder="e.g. Guards Form">
        </div>
        <div class="modal-field">
            <label>PDF File (max 20MB)</label>
            <input type="file" id="uf-file" accept=".pdf">
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('upload-form-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitUploadForm()">Upload</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-form-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Rename Form</div>
            <button class="modal-close" onclick="closeModal('edit-form-modal')">&#x2715;</button>
        </div>
        <input type="hidden" id="edit-form-id">
        <div class="modal-field">
            <label>Label</label>
            <input type="text" id="edit-form-label">
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('edit-form-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitEditForm()">Save</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-form-modal">
    <div class="modal" style="max-width:380px;">
        <div class="modal-header">
            <div class="modal-title">Delete Form</div>
            <button class="modal-close" onclick="closeModal('delete-form-modal')">&#x2715;</button>
        </div>
        <div class="delete-warn">Tenants will no longer be able to download this form and it will be removed from the mobile app dropdown.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Delete <strong id="delete-form-label" style="color:var(--ink);"></strong>?
        </p>
        <input type="hidden" id="delete-form-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-form-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmDeleteForm()">Delete</button>
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

function setButtonLoading(btn, text) {
    if (!btn) return;
    btn.disabled = true;
    btn.dataset.originalText = btn.textContent;
    btn.textContent = text;
    btn.classList.add('is-loading');
}

function resetButton(btn) {
    if (!btn) return;
    btn.disabled = false;
    btn.textContent = btn.dataset.originalText || btn.textContent;
    btn.classList.remove('is-loading');
}

const CSRF = document.querySelector('meta[name="csrf-token"]').content;

const TYPE_COLORS = {
    'Voucher':                        '#FF6BA8',
    'Turnover Sheet':                 '#E8175D',
    'Tenant Info Sheet':              '#FF2D78',
    'Sleepover of Non-Tenants':       '#A06CD5',
    'Letter for Renewal':             '#4ECDC4',
    'Guards Form':                    '#45B7D1',
    'Approval to Leave After Curfew': '#F7B731',
    'After Curfew Arrivals':          '#FC5C65',
    'Move In/Out List':               '#26de81',
};

const eyeIcon    = "{{ asset('icons/eye.png') }}";
const editIcon   = "{{ asset('icons/edit.png') }}";
const deleteIcon = "{{ asset('icons/delete.png') }}";

let docState  = { status: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
let reqState  = { status: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
let adocState = { filterStatus: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
let areqState = { filterStatus: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
let formState = { search: '', page: 1, perPage: 10, data: [], filtered: [] };
let currentDoc = null;
let currentReq = null;

function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + tab + '-btn').classList.add('active');
    document.getElementById('panel-' + tab).classList.add('active');
    if (tab === 'docs')  fetchDocs();
    if (tab === 'reqs')  fetchReqs();
    if (tab === 'forms') fetchForms();
}

function switchDrawerTab(tab) {
    document.querySelectorAll('.drawer-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.drawer-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('dtab-' + tab + '-btn').classList.add('active');
    document.getElementById('dpanel-' + tab).classList.add('active');
}

function switchVdTab(tab) {
    document.querySelectorAll('.vd-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.vd-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('vd-tab-' + tab + '-btn').classList.add('active');
    document.getElementById('vd-panel-' + tab).classList.add('active');
}

function openArchiveDrawer() {
    document.getElementById('archive-drawer-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    fetchArchive();
}

function closeArchiveDrawer() {
    document.getElementById('archive-drawer-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

function handleDrawerOverlayClick(e) {
    if (e.target === document.getElementById('archive-drawer-overlay')) {
        closeArchiveDrawer();
    }
}

function fmtDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function escHtml(str) {
    return (str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function fileTypeBadge(path) {
    if (!path) return '<span class="file-type-badge ft-other">—</span>';
    const ext = path.split('.').pop().toLowerCase();
    if (ext === 'pdf')                          return '<span class="file-type-badge ft-pdf">PDF</span>';
    if (['png', 'jpg', 'jpeg'].includes(ext))   return '<span class="file-type-badge ft-img">Image</span>';
    if (['doc', 'docx'].includes(ext))          return '<span class="file-type-badge ft-word">Word</span>';
    if (['xls', 'xlsx'].includes(ext))          return '<span class="file-type-badge ft-xl">Excel</span>';
    return `<span class="file-type-badge ft-other">${ext.toUpperCase()}</span>`;
}

function reqStatusBadge(s) {
    const map = {
        pending:       '<span class="req-status-badge req-pending">Pending</span>',
        processing:    '<span class="req-status-badge req-processing">Processing</span>',
        approved:      '<span class="req-status-badge req-approved">Approved</span>',
        ready:         '<span class="req-status-badge req-ready">Ready</span>',
        denied:        '<span class="req-status-badge req-denied">Denied</span>',
        resubmission:  '<span class="req-status-badge req-resubmission">For Resubmission</span>',
    };
    return map[s] ?? '<span class="req-status-badge req-pending">Pending</span>';
}

function renderPagination(containerId, currentPage, totalPages, onGo) {
    const pg = document.getElementById(containerId);
    if (totalPages <= 1) { pg.innerHTML = ''; return; }
    let html = `<button class="page-btn" onclick="(${onGo.toString()})(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>&#8249;</button>`;
    for (let i = 1; i <= totalPages; i++) {
        html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="(${onGo.toString()})(${i})">${i}</button>`;
    }
    html += `<button class="page-btn" onclick="(${onGo.toString()})(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>&#8250;</button>`;
    pg.innerHTML = html;
}

async function fetchDocs() {
    document.getElementById('doc-tbody').innerHTML =
        `<tr><td colspan="7"><div class="empty-state">Loading...</div></td></tr>`;
    try {
        const res  = await fetch('/admin/document-requests', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        const all  = data.data ?? data;
        docState.data = all.filter(r => r.category === 'form');
        document.getElementById('tab-docs-count').textContent = docState.data.filter(r => r.status === 'pending').length;
        docApplyFilters();
        approvedApplyFilters();
    } catch {
        document.getElementById('doc-tbody').innerHTML =
            `<tr><td colspan="7"><div class="empty-state" style="color:var(--red)">Failed to load submissions.</div></td></tr>`;
    }
}

async function fetchReqs() {
    document.getElementById('req-tbody').innerHTML =
        `<tr><td colspan="8"><div class="empty-state">Loading...</div></td></tr>`;
    try {
        const res  = await fetch('/admin/document-requests', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        const all  = data.data ?? data;
        reqState.data = all.filter(r => r.category === 'certificate');
        document.getElementById('tab-reqs-count').textContent = reqState.data.filter(r => r.status === 'pending').length;
        reqApplyFilters();
    } catch {
        document.getElementById('req-tbody').innerHTML =
            `<tr><td colspan="8"><div class="empty-state" style="color:var(--red)">Failed to load requests.</div></td></tr>`;
    }
}

function docApplyFilters() {
    const q      = document.getElementById('doc-search').value.toLowerCase();
    const status = document.getElementById('doc-filter-status').value;
    const sort   = document.getElementById('doc-sort').value;

    docState.filtered = docState.data.filter(r => {
        if (r.status === 'approved') return false;
        if (r.status === 'denied')   return false;
        if (r.status === 'resubmission') return false;
        const matchStatus = !status || r.status === status;
        const matchSearch = !q ||
            (r.document_type ?? '').toLowerCase().includes(q) ||
            (r.tenant_name   ?? '').toLowerCase().includes(q) ||
            (r.full_name     ?? '').toLowerCase().includes(q);
        return matchStatus && matchSearch;
    });

    if (sort === 'newest') docState.filtered.sort((a, b) => new Date(b.submitted_at) - new Date(a.submitted_at));
    if (sort === 'oldest') docState.filtered.sort((a, b) => new Date(a.submitted_at) - new Date(b.submitted_at));

    docState.page = 1;
    renderDocTable();
}

function renderDocTable() {
    const start = (docState.page - 1) * docState.perPage;
    const page  = docState.filtered.slice(start, start + docState.perPage);
    const tbody = document.getElementById('doc-tbody');

    if (!page.length) {
        tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><img src="{{ asset('icons/nav-docu.png') }}" alt="">No form submissions found.</div></td></tr>`;
    } else {
        tbody.innerHTML = page.map(r => {
            const color      = TYPE_COLORS[r.document_type] || '#B5B7C0';
            const tenantName = escHtml(r.tenant_name ?? r.full_name ?? '—');
            return `<tr>
                <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#FSB-${String(r.doc_request_id).padStart(3,'0')}</td>
                <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${tenantName}</td>
                <td><div class="doc-title-cell"><span class="doc-dot" style="background:${color}"></span>${escHtml(r.document_type)}</div></td>
                <td>${fileTypeBadge(r.attachment)}</td>
                <td style="font-size:.8rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(r.submitted_at)}</td>
                <td class="td-center">${reqStatusBadge(r.status)}</td>
                <td class="td-center">
                    <div class="action-group">
                        <button class="act-btn" title="View" onclick='viewDoc(${JSON.stringify(r)})'>
                            <img src="${eyeIcon}" alt="View">
                        </button>
                        <button class="act-btn" title="Review" onclick='openUpdateDoc(${JSON.stringify(r)})'>
                            <img src="${editIcon}" alt="Review">
                        </button>
                        <button class="act-btn danger" title="Archive" onclick="promptDeleteDoc(${r.doc_request_id}, '#FSB-${String(r.doc_request_id).padStart(3,'0')}')">
                            <img src="${deleteIcon}" alt="Archive">
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    const total  = docState.filtered.length;
    const endIdx = Math.min(start + docState.perPage, total);
    document.getElementById('doc-info').textContent =
        `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
    renderPagination('doc-pagination', docState.page,
        Math.ceil(total / docState.perPage),
        p => { docState.page = p; renderDocTable(); });
}

function viewDoc(r) {
    currentDoc = r;
    const color = TYPE_COLORS[r.document_type] || '#B5B7C0';

    switchVdTab('info');

    document.getElementById('vd-info-grid').innerHTML = `
        <div class="vd-detail-item">
            <div class="vd-detail-label">Submission ID</div>
            <div class="vd-detail-val" style="font-weight:800;color:var(--hot-pink);">#FSB-${String(r.doc_request_id).padStart(3,'0')}</div>
        </div>
        <div class="vd-detail-item">
            <div class="vd-detail-label">Submitted</div>
            <div class="vd-detail-val">${fmtDate(r.submitted_at)}</div>
        </div>
        <div class="vd-detail-item span2">
            <div class="vd-detail-label">Tenant</div>
            <div class="vd-detail-val">${escHtml(r.tenant_name ?? r.full_name ?? '—')}</div>
        </div>
        <div class="vd-detail-item span2">
            <div class="vd-detail-label">Form Type</div>
            <div class="vd-detail-val" style="display:flex;align-items:center;gap:.45rem;">
                <span style="width:9px;height:9px;border-radius:50%;background:${color};display:inline-block;flex-shrink:0;"></span>
                ${escHtml(r.document_type)}
            </div>
        </div>
        <div class="vd-detail-item span2">
            <div class="vd-detail-label">Status</div>
            <div class="vd-detail-val">${reqStatusBadge(r.status)}</div>
        </div>
    `;

    if (r.attachment) {
        const ext = r.attachment.split('.').pop().toLowerCase();
        const isPdf = ext === 'pdf';
        document.getElementById('vd-file-content').innerHTML = `
            <div class="vd-file-box">
                <div class="vd-file-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div>
                    <strong>${isPdf ? 'PDF Document' : ext.toUpperCase() + ' File'}</strong>
                    <p>Tap the button below to open the uploaded file in a new tab.</p>
                </div>
                <a class="btn-view-file" href="/storage/${escHtml(r.attachment)}" target="_blank">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Open File
                </a>
            </div>
        `;
    } else {
        document.getElementById('vd-file-content').innerHTML = `
            <div class="vd-file-box">
                <div style="opacity:.35;">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="var(--ink-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <p>No file was uploaded with this submission.</p>
            </div>
        `;
    }

    if (r.admin_remarks) {
        document.getElementById('vd-remarks-content').innerHTML = `
            <div class="vd-detail-item" style="background:var(--blush);border-radius:10px;padding:.8rem .95rem;border:1.5px solid var(--baby-pink);">
                <div class="vd-detail-label" style="margin-bottom:.4rem;">Admin Remarks</div>
                <div class="remark-box" style="margin:0;">${escHtml(r.admin_remarks)}</div>
            </div>
        `;
    } else {
        document.getElementById('vd-remarks-content').innerHTML = `
            <div class="vd-file-box" style="padding:1.4rem 1rem;">
                <p style="color:var(--ink-muted);font-size:.82rem;">No remarks have been added for this submission.</p>
            </div>
        `;
    }

    document.getElementById('view-doc-actions').innerHTML = `
        <button class="btn-cancel" onclick="closeModal('view-doc-modal')">Close</button>
        <button class="btn-submit" onclick="closeModal('view-doc-modal');setTimeout(()=>openUpdateDoc(currentDoc),200);">Review / Set Status</button>
    `;
    openModal('view-doc-modal');
}

function toggleRejectionField() {
    const status = document.getElementById('upd-doc-status').value;
    const wrap   = document.getElementById('rejection-reason-wrap');
    wrap.style.display = status === 'denied' ? '' : 'none';
    if (status !== 'denied') {
        document.getElementById('upd-doc-rejection-preset').value = '';
        document.getElementById('rejection-other-wrap').style.display = 'none';
        document.getElementById('upd-doc-rejection-other').value = '';
        document.getElementById('upd-doc-allow-resubmission').checked = false;
    }
}

function handleRejectionPreset() {
    const val  = document.getElementById('upd-doc-rejection-preset').value;
    const wrap = document.getElementById('rejection-other-wrap');
    wrap.style.display = val === 'other' ? '' : 'none';
    if (val !== 'other') document.getElementById('upd-doc-rejection-other').value = '';
}

function openUpdateDoc(r) {
    currentDoc = r;
    document.getElementById('upd-doc-id').value      = r.doc_request_id;
    document.getElementById('upd-doc-status').value  = (r.status === 'resubmission') ? 'denied' : (r.status ?? 'pending');
    document.getElementById('upd-doc-remarks').value = r.admin_remarks ?? '';
    document.getElementById('upd-doc-rejection-preset').value = '';
    document.getElementById('upd-doc-rejection-other').value  = '';
    document.getElementById('rejection-other-wrap').style.display = 'none';
    document.getElementById('upd-doc-allow-resubmission').checked = (r.status === 'resubmission');
    toggleRejectionField();
    openModal('update-doc-modal');
}

async function submitUpdateDoc() {
    const id      = document.getElementById('upd-doc-id').value;
    const status  = document.getElementById('upd-doc-status').value;
    const remarks = document.getElementById('upd-doc-remarks').value;

    let rejectionReason = '';
    if (status === 'denied') {
        const preset = document.getElementById('upd-doc-rejection-preset').value;
        if (!preset) { showToast('Please select a rejection reason.', 'error'); return; }
        rejectionReason = preset === 'other'
            ? document.getElementById('upd-doc-rejection-other').value.trim()
            : preset;
        if (!rejectionReason) { showToast('Please specify the rejection reason.', 'error'); return; }
    }

    const allowResubmission = status === 'denied'
        ? document.getElementById('upd-doc-allow-resubmission').checked
        : false;

    const fd = new FormData();
    fd.append('_method', 'PUT');
    fd.append('status', status);
    fd.append('admin_remarks', remarks);
    fd.append('allow_resubmission', allowResubmission ? '1' : '0');
    if (rejectionReason) fd.append('rejection_reason', rejectionReason);

    const btn = document.querySelector('#update-doc-modal .btn-submit');
    setButtonLoading(btn, 'Saving...');
    showActionLoading('Updating submission...');

    try {
        const res = await fetch(`/admin/document-requests/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message ?? 'Update failed');
        }
        closeModal('update-doc-modal');
        showToast('Submission updated successfully.', 'success');
        fetchDocs();
    } catch (e) {
        showToast(e.message ?? 'Update failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

function promptDeleteDoc(id, label) {
    document.getElementById('delete-doc-id').value          = id;
    document.getElementById('delete-doc-label').textContent = label;
    openModal('delete-doc-modal');
}

async function confirmDeleteDoc() {
    const id  = document.getElementById('delete-doc-id').value;
    const btn = document.querySelector('#delete-doc-modal .btn-submit[style*="red"]');
    setButtonLoading(btn, 'Archiving...');
    showActionLoading('Archiving submission...');
    try {
        const res = await fetch(`/admin/document-requests/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error();
        closeModal('delete-doc-modal');
        showToast('Submission archived.', 'success');
        fetchDocs();
    } catch {
        showToast('Archive failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

function reqApplyFilters() {
    const q      = document.getElementById('req-search').value.toLowerCase();
    const status = document.getElementById('req-filter-status').value;
    const sort   = document.getElementById('req-sort').value;

    reqState.filtered = reqState.data.filter(r => {
        const matchStatus = !status || r.status === status;
        const matchSearch = !q ||
            (r.document_type ?? '').toLowerCase().includes(q) ||
            (r.tenant_name   ?? '').toLowerCase().includes(q) ||
            (r.purpose       ?? '').toLowerCase().includes(q);
        return matchStatus && matchSearch;
    });

    if (sort === 'newest') reqState.filtered.sort((a, b) => new Date(b.submitted_at) - new Date(a.submitted_at));
    if (sort === 'oldest') reqState.filtered.sort((a, b) => new Date(a.submitted_at) - new Date(b.submitted_at));

    reqState.page = 1;
    renderReqTable();
}

function renderReqTable() {
    const start = (reqState.page - 1) * reqState.perPage;
    const page  = reqState.filtered.slice(start, start + reqState.perPage);
    const tbody = document.getElementById('req-tbody');

    if (!page.length) {
        tbody.innerHTML = `<tr><td colspan="8"><div class="empty-state"><img src="{{ asset('icons/pending.png') }}" alt="">No document requests found.</div></td></tr>`;
    } else {
        tbody.innerHTML = page.map(r => `<tr>
            <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#DRQ-${String(r.doc_request_id).padStart(3,'0')}</td>
            <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${escHtml(r.tenant_name ?? '—')}</td>
            <td style="font-size:.82rem;">${escHtml(r.document_type)}</td>
            <td style="font-size:.8rem;color:var(--ink-muted);max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${escHtml(r.purpose)}">${escHtml(r.purpose ?? '—')}</td>
            <td style="font-size:.8rem;">${escHtml(r.delivery_type ?? r.delivery_method ?? '—')}</td>
            <td style="font-size:.78rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(r.submitted_at)}</td>
            <td class="td-center">${reqStatusBadge(r.status)}</td>
            <td class="td-center">
                <div class="action-group">
                    <button class="act-btn" title="View" onclick='viewReq(${JSON.stringify(r)})'>
                        <img src="${eyeIcon}" alt="View">
                    </button>
                    <button class="act-btn" title="Update" onclick='openUpdateReq(${JSON.stringify(r)})'>
                        <img src="${editIcon}" alt="Update">
                    </button>
                    <button class="act-btn danger" title="Archive" onclick="promptDeleteReq(${r.doc_request_id}, '#DRQ-${String(r.doc_request_id).padStart(3,'0')}')">
                        <img src="${deleteIcon}" alt="Archive">
                    </button>
                </div>
            </td>
        </tr>`).join('');
    }

    const total  = reqState.filtered.length;
    const endIdx = Math.min(start + reqState.perPage, total);
    document.getElementById('req-info').textContent =
        `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
    renderPagination('req-pagination', reqState.page,
        Math.ceil(total / reqState.perPage),
        p => { reqState.page = p; renderReqTable(); });
}

function viewReq(r) {
    currentReq = r;
    const deliveryType = (r.delivery_type ?? r.delivery_method ?? '').toLowerCase();
    const isHardCopy   = deliveryType.includes('printed') || deliveryType.includes('hard');

    const fulfilledHtml = r.fulfilled_file
        ? `<a class="btn-view-file" href="/storage/${r.fulfilled_file}" target="_blank">View Fulfilled Document</a>`
        : isHardCopy
            ? '<span style="font-size:.82rem;color:var(--ink-muted);">Hard copy — tenant will pick up at admin office.</span>'
            : '<span style="font-size:.82rem;color:var(--ink-muted);">No document uploaded yet.</span>';

    document.getElementById('view-req-content').innerHTML = `
        <div class="view-detail-row"><div class="view-detail-label">Request ID</div><div class="view-detail-val" style="font-weight:700;color:var(--hot-pink);">#DRQ-${String(r.doc_request_id).padStart(3,'0')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Tenant</div><div class="view-detail-val">${escHtml(r.tenant_name ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Document Type</div><div class="view-detail-val">${escHtml(r.document_type)}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Purpose</div><div class="view-detail-val">${escHtml(r.purpose ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Delivery</div><div class="view-detail-val">${escHtml(r.delivery_type ?? r.delivery_method ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Submitted</div><div class="view-detail-val">${fmtDate(r.submitted_at)}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Status</div><div class="view-detail-val">${reqStatusBadge(r.status)}</div></div>
        ${r.admin_remarks ? `<div class="view-detail-row"><div class="view-detail-label">Admin Remarks</div><div class="view-detail-val"><div class="remark-box">${escHtml(r.admin_remarks)}</div></div></div>` : ''}
        <div class="view-detail-row"><div class="view-detail-label">Fulfilled Document</div><div class="view-detail-val">${fulfilledHtml}</div></div>
    `;
    document.getElementById('view-req-actions').innerHTML = `
        <button class="btn-cancel" onclick="closeModal('view-req-modal')">Close</button>
        <button class="btn-submit" onclick="closeModal('view-req-modal');setTimeout(()=>openUpdateReq(currentReq),200);">Update Status</button>
    `;
    openModal('view-req-modal');
}

function toggleReqRejectionField() {
    const status = document.getElementById('upd-req-status').value;
    const wrap   = document.getElementById('req-rejection-reason-wrap');
    wrap.style.display = status === 'denied' ? '' : 'none';
    if (status !== 'denied') {
        document.getElementById('upd-req-rejection-preset').value = '';
        document.getElementById('req-rejection-other-wrap').style.display = 'none';
        document.getElementById('upd-req-rejection-other').value = '';
    }
}

function handleReqRejectionPreset() {
    const val  = document.getElementById('upd-req-rejection-preset').value;
    const wrap = document.getElementById('req-rejection-other-wrap');
    wrap.style.display = val === 'other' ? '' : 'none';
    if (val !== 'other') document.getElementById('upd-req-rejection-other').value = '';
}

function openUpdateReq(r) {
    currentReq = r;
    document.getElementById('upd-req-id').value      = r.doc_request_id;
    document.getElementById('upd-req-status').value  = r.status ?? 'pending';
    document.getElementById('upd-req-remarks').value = r.admin_remarks ?? '';
    document.getElementById('upd-req-file').value    = '';
    document.getElementById('upd-req-rejection-preset').value = '';
    document.getElementById('upd-req-rejection-other').value  = '';
    document.getElementById('req-rejection-other-wrap').style.display = 'none';
    toggleReqRejectionField();
    openModal('update-req-modal');
}

async function submitUpdateReq() {
    const id      = document.getElementById('upd-req-id').value;
    const status  = document.getElementById('upd-req-status').value;
    const remarks = document.getElementById('upd-req-remarks').value;
    const file    = document.getElementById('upd-req-file').files[0];

    let rejectionReason = '';
    if (status === 'denied') {
        const preset = document.getElementById('upd-req-rejection-preset').value;
        if (!preset) { showToast('Please select a denial reason.', 'error'); return; }
        rejectionReason = preset === 'other'
            ? document.getElementById('upd-req-rejection-other').value.trim()
            : preset;
        if (!rejectionReason) { showToast('Please specify the denial reason.', 'error'); return; }
    }

    if (file) {
        if (file.type !== 'application/pdf') { showToast('Only PDF files are allowed.', 'error'); return; }
        if (file.size > 20 * 1024 * 1024)   { showToast('File must be under 20MB.', 'error'); return; }
    }

    const fd = new FormData();
    fd.append('_method', 'PUT');
    fd.append('status', status);
    fd.append('admin_remarks', remarks);
    if (rejectionReason) fd.append('rejection_reason', rejectionReason);
    if (file) fd.append('fulfilled_file', file);

    const btn = document.querySelector('#update-req-modal .btn-submit');
    setButtonLoading(btn, 'Saving...');
    showActionLoading('Updating request...');

    try {
        const res = await fetch(`/admin/document-requests/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message ?? 'Update failed');
        }
        closeModal('update-req-modal');
        showToast('Request updated successfully.', 'success');
        fetchReqs();
    } catch (e) {
        showToast(e.message ?? 'Update failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

function promptDeleteReq(id, label) {
    document.getElementById('delete-req-id').value          = id;
    document.getElementById('delete-req-label').textContent = label;
    openModal('delete-req-modal');
}

async function confirmDeleteReq() {
    const id  = document.getElementById('delete-req-id').value;
    const btn = document.querySelector('#delete-req-modal .btn-submit[style*="red"]');
    setButtonLoading(btn, 'Archiving...');
    showActionLoading('Archiving request...');
    try {
        const res = await fetch(`/admin/document-requests/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error();
        closeModal('delete-req-modal');
        showToast('Request archived.', 'success');
        fetchReqs();
    } catch {
        showToast('Archive failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

async function fetchArchive() {
    try {
        const res  = await fetch('/admin/archive-docus', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        if (data.error) return;

        adocState.data   = data.filter(r =>
            r.archivable_type === 'document_request' && r.data?.category === 'form' &&
            r.data?.status !== 'denied' && r.data?.status !== 'resubmission'
        );
        areqState.data   = data.filter(r =>
            r.archivable_type === 'document_request' && r.data?.category !== 'form'
        );
        adeniedState.data = data.filter(r =>
            r.archivable_type === 'document_request' && r.data?.category === 'form' &&
            (r.data?.status === 'denied' || r.data?.status === 'resubmission')
        );

        document.getElementById('dtab-docs-count').textContent   = adocState.data.length;
        document.getElementById('dtab-reqs-count').textContent   = areqState.data.length;
        document.getElementById('dtab-denied-count').textContent = adeniedState.data.length;

        adocApplyFilters();
        areqApplyFilters();
        adeniedApplyFilters();
    } catch {
        document.getElementById('adoc-tbody').innerHTML =
            `<tr><td colspan="8"><div class="empty-state" style="color:var(--red)">Failed to load archive.</div></td></tr>`;
    }
}

function adocApplyFilters() {
    const q      = document.getElementById('adoc-search').value.toLowerCase();
    const status = document.getElementById('adoc-filter-status').value;
    const sort   = document.getElementById('adoc-sort').value;

    adocState.filtered = adocState.data.filter(r => {
        const d           = r.data ?? {};
        const matchStatus = !status || d.status === status;
        const matchSearch = !q      ||
            (d.document_type ?? '').toLowerCase().includes(q) ||
            (d.tenant_name   ?? '').toLowerCase().includes(q) ||
            (d.full_name     ?? '').toLowerCase().includes(q);
        return matchStatus && matchSearch;
    });

    if (sort === 'newest') adocState.filtered.sort((a, b) => new Date(b.archived_at) - new Date(a.archived_at));
    if (sort === 'oldest') adocState.filtered.sort((a, b) => new Date(a.archived_at) - new Date(b.archived_at));

    adocState.page = 1;
    renderAdocTable();
}

function renderAdocTable() {
    const start = (adocState.page - 1) * adocState.perPage;
    const page  = adocState.filtered.slice(start, start + adocState.perPage);
    const tbody = document.getElementById('adoc-tbody');

    if (!page.length) {
        tbody.innerHTML = `<tr><td colspan="8"><div class="empty-state"><img src="{{ asset('icons/nav-docu.png') }}" alt="">No archived submissions found.</div></td></tr>`;
    } else {
        tbody.innerHTML = page.map(r => {
            const d     = r.data ?? {};
            const color = TYPE_COLORS[d.document_type] || '#B5B7C0';
            return `<tr>
                <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#FSB-${String(d.doc_request_id ?? 0).padStart(3,'0')}</td>
                <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${escHtml(d.tenant_name ?? d.full_name ?? '—')}</td>
                <td><div class="doc-title-cell"><span class="doc-dot" style="background:${color}"></span>${escHtml(d.document_type)}</div></td>
                <td>${fileTypeBadge(d.attachment)}</td>
                <td class="td-center">${reqStatusBadge(d.status)}</td>
                <td style="font-size:.8rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(d.submitted_at)}</td>
                <td style="font-size:.8rem;white-space:nowrap;"><span class="archive-badge">${fmtDate(r.archived_at)}</span></td>
                <td class="td-center">
                    <div class="action-group">
                        <button class="act-btn" title="View" onclick='viewAdoc(${JSON.stringify(r)})'>
                            <img src="${eyeIcon}" alt="View">
                        </button>
                        <button class="act-btn danger" title="Remove from Archive" onclick="promptRemoveAdoc(${r.archive_id}, '#FSB-${String(d.doc_request_id ?? 0).padStart(3,'0')}')">
                            <img src="${deleteIcon}" alt="Remove">
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    const total  = adocState.filtered.length;
    const endIdx = Math.min(start + adocState.perPage, total);
    document.getElementById('adoc-info').textContent =
        `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
    renderPagination('adoc-pagination', adocState.page,
        Math.ceil(total / adocState.perPage),
        p => { adocState.page = p; renderAdocTable(); });
}

function viewAdoc(r) {
    const d = r.data ?? {};
    const fileHtml = d.attachment
        ? `<a class="btn-view-file" href="/storage/${d.attachment}" target="_blank">View Uploaded Form</a>`
        : '<span style="font-size:.82rem;color:var(--ink-muted);">No file uploaded.</span>';

    document.getElementById('view-adoc-content').innerHTML = `
        <div class="view-detail-row"><div class="view-detail-label">Submission ID</div><div class="view-detail-val" style="font-weight:700;color:var(--hot-pink);">#FSB-${String(d.doc_request_id ?? 0).padStart(3,'0')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Tenant</div><div class="view-detail-val">${escHtml(d.tenant_name ?? d.full_name ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Form Type</div><div class="view-detail-val">${escHtml(d.document_type)}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Submitted</div><div class="view-detail-val">${fmtDate(d.submitted_at)}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Status at Archive</div><div class="view-detail-val">${reqStatusBadge(d.status)}</div></div>
        ${d.admin_remarks ? `<div class="view-detail-row"><div class="view-detail-label">Admin Remarks</div><div class="view-detail-val"><div class="remark-box">${escHtml(d.admin_remarks)}</div></div></div>` : ''}
        <div class="view-detail-row"><div class="view-detail-label">Uploaded File</div><div class="view-detail-val">${fileHtml}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Archived On</div><div class="view-detail-val"><span class="archive-badge">${fmtDate(r.archived_at)}</span></div></div>
    `;
    openModal('view-adoc-modal');
}

function promptRemoveAdoc(id, label) {
    document.getElementById('remove-adoc-id').value          = id;
    document.getElementById('remove-adoc-label').textContent = label;
    openModal('remove-adoc-modal');
}

async function confirmRemoveAdoc() {
    const id  = document.getElementById('remove-adoc-id').value;
    const btn = document.querySelector('#remove-adoc-modal .btn-submit[style*="red"]');
    setButtonLoading(btn, 'Removing...');
    showActionLoading('Removing archive record...');
    try {
        const res = await fetch(`/admin/archive-docus/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error();
        closeModal('remove-adoc-modal');
        showToast('Archive record removed.', 'success');
        fetchArchive();
    } catch {
        showToast('Remove failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

function areqApplyFilters() {
    const q      = document.getElementById('areq-search').value.toLowerCase();
    const status = document.getElementById('areq-filter-status').value;
    const sort   = document.getElementById('areq-sort').value;

    areqState.filtered = areqState.data.filter(r => {
        const d           = r.data ?? {};
        const matchStatus = !status || d.status === status;
        const matchSearch = !q      ||
            (d.document_type ?? '').toLowerCase().includes(q) ||
            (d.tenant_name   ?? '').toLowerCase().includes(q) ||
            (d.purpose       ?? '').toLowerCase().includes(q);
        return matchStatus && matchSearch;
    });

    if (sort === 'newest') areqState.filtered.sort((a, b) => new Date(b.archived_at) - new Date(a.archived_at));
    if (sort === 'oldest') areqState.filtered.sort((a, b) => new Date(a.archived_at) - new Date(b.archived_at));

    areqState.page = 1;
    renderAreqTable();
}

function renderAreqTable() {
    const start = (areqState.page - 1) * areqState.perPage;
    const page  = areqState.filtered.slice(start, start + areqState.perPage);
    const tbody = document.getElementById('areq-tbody');

    if (!page.length) {
        tbody.innerHTML = `<tr><td colspan="9"><div class="empty-state"><img src="{{ asset('icons/pending.png') }}" alt="">No archived requests found.</div></td></tr>`;
    } else {
        tbody.innerHTML = page.map(r => {
            const d = r.data ?? {};
            return `<tr>
                <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#DRQ-${String(d.doc_request_id ?? 0).padStart(3,'0')}</td>
                <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${escHtml(d.tenant_name ?? '—')}</td>
                <td style="font-size:.82rem;">${escHtml(d.document_type)}</td>
                <td style="font-size:.8rem;color:var(--ink-muted);max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${escHtml(d.purpose)}">${escHtml(d.purpose ?? '—')}</td>
                <td style="font-size:.8rem;">${escHtml(d.delivery_type ?? d.delivery_method ?? '—')}</td>
                <td class="td-center">${reqStatusBadge(d.status)}</td>
                <td style="font-size:.78rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(d.submitted_at)}</td>
                <td style="font-size:.8rem;white-space:nowrap;"><span class="archive-badge">${fmtDate(r.archived_at)}</span></td>
                <td class="td-center">
                    <div class="action-group">
                        <button class="act-btn" title="View" onclick='viewAreq(${JSON.stringify(r)})'>
                            <img src="${eyeIcon}" alt="View">
                        </button>
                        <button class="act-btn danger" title="Remove from Archive" onclick="promptRemoveAreq(${r.archive_id}, '#DRQ-${String(d.doc_request_id ?? 0).padStart(3,'0')}')">
                            <img src="${deleteIcon}" alt="Remove">
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    const total  = areqState.filtered.length;
    const endIdx = Math.min(start + areqState.perPage, total);
    document.getElementById('areq-info').textContent =
        `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
    renderPagination('areq-pagination', areqState.page,
        Math.ceil(total / areqState.perPage),
        p => { areqState.page = p; renderAreqTable(); });
}

function viewAreq(r) {
    const d = r.data ?? {};
    const fulfilledHtml = d.fulfilled_file
        ? `<a class="btn-view-file" href="/storage/${d.fulfilled_file}" target="_blank">View Fulfilled Document</a>`
        : '<span style="font-size:.82rem;color:var(--ink-muted);">No fulfilled document.</span>';

    document.getElementById('view-areq-content').innerHTML = `
        <div class="view-detail-row"><div class="view-detail-label">Request ID</div><div class="view-detail-val" style="font-weight:700;color:var(--hot-pink);">#DRQ-${String(d.doc_request_id ?? 0).padStart(3,'0')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Tenant</div><div class="view-detail-val">${escHtml(d.tenant_name ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Document Type</div><div class="view-detail-val">${escHtml(d.document_type)}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Purpose</div><div class="view-detail-val">${escHtml(d.purpose ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Delivery</div><div class="view-detail-val">${escHtml(d.delivery_type ?? d.delivery_method ?? '—')}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Submitted</div><div class="view-detail-val">${fmtDate(d.submitted_at)}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Status at Archive</div><div class="view-detail-val">${reqStatusBadge(d.status)}</div></div>
        ${d.admin_remarks ? `<div class="view-detail-row"><div class="view-detail-label">Admin Remarks</div><div class="view-detail-val"><div class="remark-box">${escHtml(d.admin_remarks)}</div></div></div>` : ''}
        <div class="view-detail-row"><div class="view-detail-label">Fulfilled Document</div><div class="view-detail-val">${fulfilledHtml}</div></div>
        <div class="view-detail-row"><div class="view-detail-label">Archived On</div><div class="view-detail-val"><span class="archive-badge">${fmtDate(r.archived_at)}</span></div></div>
    `;
    openModal('view-areq-modal');
}

function promptRemoveAreq(id, label) {
    document.getElementById('remove-areq-id').value          = id;
    document.getElementById('remove-areq-label').textContent = label;
    openModal('remove-areq-modal');
}

async function confirmRemoveAreq() {
    const id  = document.getElementById('remove-areq-id').value;
    const btn = document.querySelector('#remove-areq-modal .btn-submit[style*="red"]');
    setButtonLoading(btn, 'Removing...');
    showActionLoading('Removing archive record...');
    try {
        const res = await fetch(`/admin/archive-docus/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error();
        closeModal('remove-areq-modal');
        showToast('Archive record removed.', 'success');
        fetchArchive();
    } catch {
        showToast('Remove failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

async function fetchForms() {
    document.getElementById('form-tbody').innerHTML =
        `<tr><td colspan="4"><div class="empty-state">Loading...</div></td></tr>`;
    try {
        const res  = await fetch('/admin/downloadable-forms', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        formState.data = data;
        document.getElementById('tab-forms-count').textContent = data.length;
        formApplyFilters();
    } catch {
        document.getElementById('form-tbody').innerHTML =
            `<tr><td colspan="4"><div class="empty-state" style="color:var(--red)">Failed to load forms.</div></td></tr>`;
    }
}

function formApplyFilters() {
    const q = document.getElementById('form-search').value.toLowerCase();
    formState.filtered = formState.data.filter(f =>
        !q || (f.label ?? '').toLowerCase().includes(q)
    );
    formState.page = 1;
    renderFormTable();
}

function openFormFile(filePath) {
    const url = filePath.startsWith('forms/') ? '/' + filePath : '/storage/' + filePath;
    window.open(url, '_blank');
}

function renderFormTable() {
    const start = (formState.page - 1) * formState.perPage;
    const page  = formState.filtered.slice(start, start + formState.perPage);
    const tbody = document.getElementById('form-tbody');

    if (!page.length) {
        tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state">No forms uploaded yet.</div></td></tr>`;
    } else {
        tbody.innerHTML = page.map(f => `<tr>
            <td style="font-weight:600;font-size:.88rem;">${escHtml(f.label)}</td>
            <td>${fileTypeBadge(f.file_path)}</td>
            <td style="font-size:.8rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(f.created_at)}</td>
            <td class="td-center">
                <div class="action-group">
                    <button class="act-btn" title="Open" onclick="openFormFile('${escHtml(f.file_path)}')">
                        <img src="${eyeIcon}" alt="Open">
                    </button>
                    <button class="act-btn" title="Rename" onclick="openEditForm(${f.id}, '${escHtml(f.label)}')">
                        <img src="${editIcon}" alt="Rename">
                    </button>
                    <button class="act-btn danger" title="Delete" onclick="promptDeleteForm(${f.id}, '${escHtml(f.label)}')">
                        <img src="${deleteIcon}" alt="Delete">
                    </button>
                </div>
            </td>
        </tr>`).join('');
    }

    const total  = formState.filtered.length;
    const endIdx = Math.min(start + formState.perPage, total);
    document.getElementById('form-info').textContent =
        `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
    renderPagination('form-pagination', formState.page,
        Math.ceil(total / formState.perPage),
        p => { formState.page = p; renderFormTable(); });
}

async function submitUploadForm() {
    const label = document.getElementById('uf-label').value.trim();
    const file  = document.getElementById('uf-file').files[0];
    if (!label) { showToast('Label is required.', 'error'); return; }
    if (!file)  { showToast('Please select a PDF file.', 'error'); return; }

    const fd = new FormData();
    fd.append('label', label);
    fd.append('file', file);

    const btn = document.querySelector('#upload-form-modal .btn-submit');
    setButtonLoading(btn, 'Uploading...');
    showActionLoading('Uploading form...');

    try {
        const res = await fetch('/admin/downloadable-forms', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            const msg = err.message ?? (err.errors ? Object.values(err.errors)[0]?.[0] : null) ?? 'Upload failed.';
            throw new Error(msg);
        }
        closeModal('upload-form-modal');
        document.getElementById('uf-label').value = '';
        document.getElementById('uf-file').value  = '';
        showToast('Form uploaded. Tenants can now see it in the app.', 'success');
        fetchForms();
    } catch (e) {
        showToast(e.message ?? 'Upload failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

function openEditForm(id, label) {
    document.getElementById('edit-form-id').value    = id;
    document.getElementById('edit-form-label').value = label;
    openModal('edit-form-modal');
}

async function submitEditForm() {
    const id    = document.getElementById('edit-form-id').value;
    const label = document.getElementById('edit-form-label').value.trim();
    if (!label) { showToast('Label is required.', 'error'); return; }

    const btn = document.querySelector('#edit-form-modal .btn-submit');
    setButtonLoading(btn, 'Saving...');
    showActionLoading('Saving...');

    try {
        const res = await fetch(`/admin/downloadable-forms/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ label }),
        });
        if (!res.ok) throw new Error();
        closeModal('edit-form-modal');
        showToast('Form renamed.', 'success');
        fetchForms();
    } catch {
        showToast('Save failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

function promptDeleteForm(id, label) {
    document.getElementById('delete-form-id').value          = id;
    document.getElementById('delete-form-label').textContent = label;
    openModal('delete-form-modal');
}

async function confirmDeleteForm() {
    const id  = document.getElementById('delete-form-id').value;
    const btn = document.querySelector('#delete-form-modal .btn-submit[style*="red"]');
    setButtonLoading(btn, 'Deleting...');
    showActionLoading('Deleting form...');

    try {
        const res = await fetch(`/admin/downloadable-forms/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error();
        closeModal('delete-form-modal');
        showToast('Form deleted and removed from the mobile app.', 'success');
        fetchForms();
    } catch {
        showToast('Delete failed.', 'error');
    } finally {
        hideActionLoading();
        resetButton(btn);
    }
}

@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => showToast('{{ session("success") }}', 'success'));
@endif

let approvedState = { search: '', page: 1, perPage: 8, data: [], filtered: [] };
let adeniedState  = { sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };

function toggleApprovedPanel() {
    const body = document.getElementById('approved-panel-body');
    const chev = document.getElementById('approved-chevron');
    const hint = document.getElementById('approved-panel-hint');
    const open = body.classList.contains('open');
    body.classList.toggle('open', !open);
    chev.classList.toggle('open', !open);
    hint.textContent = open ? 'Click to expand' : 'Click to collapse';
}

function approvedApplyFilters() {
    const q = (document.getElementById('approved-search')?.value ?? '').toLowerCase();
    approvedState.data = docState.data.filter(r => r.status === 'approved');
    document.getElementById('approved-count-badge').textContent = approvedState.data.length;

    approvedState.filtered = approvedState.data.filter(r => {
        return !q ||
            (r.document_type ?? '').toLowerCase().includes(q) ||
            (r.tenant_name   ?? '').toLowerCase().includes(q) ||
            (r.full_name     ?? '').toLowerCase().includes(q);
    });

    approvedState.filtered.sort((a, b) => new Date(b.submitted_at) - new Date(a.submitted_at));
    approvedState.page = 1;
    renderApprovedCards();
}

function renderApprovedCards() {
    const start = (approvedState.page - 1) * approvedState.perPage;
    const page  = approvedState.filtered.slice(start, start + approvedState.perPage);
    const grid  = document.getElementById('approved-cards-grid');

    if (!page.length) {
        grid.innerHTML = `<div class="approved-empty">No approved submissions found.</div>`;
        document.getElementById('approved-info').textContent = '';
        document.getElementById('approved-pagination').innerHTML = '';
        return;
    }

    grid.innerHTML = page.map(r => {
        const color = TYPE_COLORS[r.document_type] || '#B5B7C0';
        const name  = escHtml(r.tenant_name ?? r.full_name ?? '—');
        const id    = String(r.doc_request_id).padStart(3, '0');
        return `<div class="approved-card">
            <div class="approved-card-inner">
                <div class="approved-card-top">
                    <span class="approved-card-id">#FSB-${id}</span>
                    <span class="approved-card-approved-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Approved
                    </span>
                </div>
                <div class="approved-card-type">
                    <span class="approved-card-dot" style="background:${color}"></span>
                    ${escHtml(r.document_type)}
                </div>
                <div class="approved-card-tenant">${name}</div>
                <div class="approved-card-footer">
                    <span class="approved-card-date">${fmtDate(r.submitted_at)}</span>
                    <button class="approved-card-view-btn" onclick='viewDoc(${JSON.stringify(r)})'>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        View
                    </button>
                </div>
            </div>
        </div>`;
    }).join('');

    const total  = approvedState.filtered.length;
    const endIdx = Math.min(start + approvedState.perPage, total);
    document.getElementById('approved-info').textContent =
        `${total ? start + 1 : 0}–${endIdx} of ${total}`;
    renderPagination('approved-pagination', approvedState.page,
        Math.ceil(total / approvedState.perPage),
        p => { approvedState.page = p; renderApprovedCards(); });
}

function adeniedApplyFilters() {
    const q    = document.getElementById('adenied-search').value.toLowerCase();
    const sort = document.getElementById('adenied-sort').value;

    adeniedState.filtered = adeniedState.data.filter(r => {
        const d = r.data ?? {};
        return !q ||
            (d.document_type ?? '').toLowerCase().includes(q) ||
            (d.tenant_name   ?? '').toLowerCase().includes(q) ||
            (d.full_name     ?? '').toLowerCase().includes(q);
    });

    if (sort === 'newest') adeniedState.filtered.sort((a, b) => new Date(b.archived_at) - new Date(a.archived_at));
    if (sort === 'oldest') adeniedState.filtered.sort((a, b) => new Date(a.archived_at) - new Date(b.archived_at));

    adeniedState.page = 1;
    renderAdeniedTable();
}

function renderAdeniedTable() {
    const start = (adeniedState.page - 1) * adeniedState.perPage;
    const page  = adeniedState.filtered.slice(start, start + adeniedState.perPage);
    const tbody = document.getElementById('adenied-tbody');

    if (!page.length) {
        tbody.innerHTML = `<tr><td colspan="8"><div class="empty-state">No denied submissions found.</div></td></tr>`;
        document.getElementById('adenied-info').textContent = 'Showing 0 entries';
        document.getElementById('adenied-pagination').innerHTML = '';
        return;
    }

    tbody.innerHTML = page.map(r => {
        const d     = r.data ?? {};
        const color = TYPE_COLORS[d.document_type] || '#B5B7C0';
        return `<tr>
            <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#FSB-${String(d.doc_request_id ?? 0).padStart(3,'0')}</td>
            <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${escHtml(d.tenant_name ?? d.full_name ?? '—')}</td>
            <td><div class="doc-title-cell"><span class="doc-dot" style="background:${color}"></span>${escHtml(d.document_type)}</div></td>
            <td>${fileTypeBadge(d.attachment)}</td>
            <td class="td-center">${reqStatusBadge(d.status)}</td>
            <td style="font-size:.8rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(d.submitted_at)}</td>
            <td style="font-size:.8rem;white-space:nowrap;"><span class="archive-badge">${fmtDate(r.archived_at)}</span></td>
            <td class="td-center">
                <div class="action-group">
                    <button class="act-btn" title="View" onclick='viewAdoc(${JSON.stringify(r)})'>
                        <img src="${eyeIcon}" alt="View">
                    </button>
                    <button class="act-btn danger" title="Remove" onclick="promptRemoveAdoc(${r.archive_id}, '#FSB-${String(d.doc_request_id ?? 0).padStart(3,'0')}')">
                        <img src="${deleteIcon}" alt="Remove">
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');

    const total  = adeniedState.filtered.length;
    const endIdx = Math.min(start + adeniedState.perPage, total);
    document.getElementById('adenied-info').textContent =
        `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
    renderPagination('adenied-pagination', adeniedState.page,
        Math.ceil(total / adeniedState.perPage),
        p => { adeniedState.page = p; renderAdeniedTable(); });
}

fetchDocs();
fetchReqs();
fetchForms();
</script>
@endsection