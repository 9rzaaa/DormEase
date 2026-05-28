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
        transition: background .2s, color .2s;
        font-family: var(--ff-body);
        white-space: nowrap;
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
        margin-left: auto;
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

    .doc-layout {
        display: flex;
        gap: 1.2rem;
        align-items: flex-start;
    }

    .type-sidebar {
        width: 210px;
        flex-shrink: 0;
        background: var(--white);
        border-radius: 14px;
        border: 1.5px solid var(--baby-pink);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(232,23,93,.06);
    }

    .sidebar-heading {
        padding: .7rem 1rem .5rem;
        font-size: .7rem;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        border-bottom: 1.5px solid var(--baby-pink);
    }

    .type-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: .65rem 1rem;
        border: none;
        border-bottom: 1px solid var(--petal);
        background: transparent;
        color: var(--ink);
        font-size: .81rem;
        font-family: var(--ff-body);
        font-weight: 500;
        text-align: left;
        cursor: pointer;
        transition: background .15s, color .15s;
    }

    .type-btn:last-child { border-bottom: none; }
    .type-btn:hover:not(.active) { background: var(--blush); color: var(--hot-pink); }

    .type-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-weight: 700;
    }

    .type-count {
        background: rgba(232,23,93,.12);
        color: var(--hot-pink);
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 800;
        padding: 1px 7px;
        min-width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    .type-btn.active .type-count {
        background: rgba(255,255,255,.25);
        color: var(--white);
    }

    .table-card {
        flex: 1;
        background: var(--white);
        border-radius: 14px;
        border: 1.5px solid var(--baby-pink);
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(232,23,93,.07);
    }

    .table-card-header {
        padding: 1rem 1.4rem;
        border-bottom: 1.5px solid var(--petal);
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
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        background: var(--blush);
        border-bottom: 1.5px solid var(--baby-pink);
        white-space: nowrap;
    }

    tbody tr {
        border-bottom: 1px solid var(--petal);
        transition: background .15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fff7fb; }

    tbody td {
        padding: .75rem 1rem;
        color: var(--ink);
        vertical-align: middle;
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

    .visibility-badge {
        display: inline-flex;
        align-items: center;
        padding: .18rem .55rem;
        border-radius: 6px;
        font-size: .7rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .vis-all      { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .vis-specific { background: #f3e5f5; color: #6a1b9a; border: 1px solid #ce93d8; }
    .vis-admin    { background: #f5f5f5; color: #424242; border: 1px solid #e0e0e0; }

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
    .ft-other{ background: #f5f5f5; color: #666; border: 1px solid #ddd; }

    .req-status-badge {
        display: inline-flex;
        align-items: center;
        padding: .2rem .65rem;
        border-radius: 20px;
        font-size: .71rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .req-pending    { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .req-approved   { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .req-denied     { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }
    .req-processing { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .req-ready      { background: #f3e5f5; color: #6a1b9a; border: 1px solid #ce93d8; }

    .action-group {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .act-btn {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        border: 1.5px solid var(--baby-pink);
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
        width: 13px;
        height: 13px;
        object-fit: contain;
    }

    .act-btn.danger:hover { border-color: #e04867; }

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
        border: 1.5px solid var(--baby-pink);
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
        padding: 3rem 1rem;
        color: var(--ink-muted);
        font-size: .88rem;
    }

    .empty-state img {
        width: 44px;
        height: 44px;
        object-fit: contain;
        opacity: .35;
        display: block;
        margin: 0 auto .6rem;
    }

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

    .modal-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
    }

    .modal-full { grid-column: 1 / -1; }

    .view-detail-row {
        display: flex;
        flex-direction: column;
        gap: .15rem;
        padding: .6rem 0;
        border-bottom: 1px solid var(--petal);
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
        margin-top: .6rem;
        transition: opacity .2s;
    }

    .btn-view-file:hover { opacity: .88; }

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

    .archive-drawer-overlay.open {
        display: flex;
    }

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

    @media (max-width: 900px) {
        .doc-layout { flex-direction: column; }
        .type-sidebar { width: 100%; }
        .modal-two-col { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .archive-drawer { width: 100vw; }
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
                Archive
            </button>
            <button class="btn-upload" onclick="openModal('upload-modal')">
                <img src="{{ asset('icons/attach.png') }}" alt="">
                Upload Document
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
        </div>
    </div>

    <div class="tab-panel active fade-up d3" id="panel-docs">
        <div class="toolbar">
            <span class="toolbar-label">Category:</span>
            <select class="toolbar-select" id="doc-filter-type" onchange="docApplyFilters()">
                <option value="">All Types</option>
                @foreach($docTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>

            <span class="toolbar-label">Visibility:</span>
            <select class="toolbar-select" id="doc-filter-vis" onchange="docApplyFilters()">
                <option value="">All</option>
                <option value="all">All Tenants</option>
                <option value="specific">Specific Tenant</option>
                <option value="admin">Admin Only</option>
            </select>

            <div class="search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                <input type="text" id="doc-search" placeholder="Search title, tenant..." oninput="docApplyFilters()">
            </div>
        </div>

        <div class="doc-layout">
            <div class="type-sidebar">
                <div class="sidebar-heading">Categories</div>
                <button class="type-btn active" data-type="" onclick="docSetType(this, '')">
                    All Documents
                    <span class="type-count" id="sc-all">0</span>
                </button>
                @foreach($docTypes as $type)
                <button class="type-btn" data-type="{{ $type }}" onclick="docSetType(this, '{{ $type }}')">
                    {{ $type }}
                    <span class="type-count" id="sc-{{ Str::slug($type) }}">0</span>
                </button>
                @endforeach
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    <div>
                        <div class="table-card-title">Documents</div>
                        <div class="table-card-sub" id="doc-date-label">as of {{ now()->format('F d, Y') }}</div>
                    </div>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Visibility</th>
                                <th>Tenant</th>
                                <th>File Type</th>
                                <th>Date Uploaded</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="doc-tbody"></tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <div class="table-info" id="doc-info">Showing 0 entries</div>
                    <div class="pagination" id="doc-pagination"></div>
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
                    <div class="table-card-sub">Requests submitted by tenants via the mobile app</div>
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
                            <th>Date Needed</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th></th>
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

</div>

<div class="archive-drawer-overlay" id="archive-drawer-overlay" onclick="handleDrawerOverlayClick(event)">
    <div class="archive-drawer" id="archive-drawer">
        <div class="drawer-header">
            <div class="drawer-header-text">
                <h2>Document Archive</h2>
                <span>Records archived from Document Management</span>
            </div>
            <button class="drawer-close" onclick="closeArchiveDrawer()">&#x2715;</button>
        </div>

        <div class="drawer-tab-bar">
            <button class="drawer-tab-btn active" id="dtab-docs-btn" onclick="switchDrawerTab('docs')">
                Archived Documents
                <span class="drawer-tab-badge" id="dtab-docs-count">0</span>
            </button>
            <button class="drawer-tab-btn" id="dtab-reqs-btn" onclick="switchDrawerTab('reqs')">
                Archived Requests
                <span class="drawer-tab-badge" id="dtab-reqs-count">0</span>
            </button>
        </div>

        <div class="drawer-body">

            <div class="drawer-panel active" id="dpanel-docs">
                <div class="drawer-toolbar">
                    <span class="toolbar-label">Category:</span>
                    <select class="toolbar-select" id="adoc-filter-type" onchange="adocApplyFilters()">
                        <option value="">All Categories</option>
                    </select>

                    <span class="toolbar-label">Visibility:</span>
                    <select class="toolbar-select" id="adoc-filter-vis" onchange="adocApplyFilters()">
                        <option value="">All</option>
                        <option value="all">All Tenants</option>
                        <option value="specific">Specific Tenant</option>
                        <option value="admin">Admin Only</option>
                    </select>

                    <span class="toolbar-label">Sort:</span>
                    <select class="toolbar-select" id="adoc-sort" onchange="adocApplyFilters()">
                        <option value="newest">Newest Archived</option>
                        <option value="oldest">Oldest Archived</option>
                    </select>

                    <div class="search-wrap" style="margin-left:auto;">
                        <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                        <input type="text" id="adoc-search" placeholder="Search title, tenant..." oninput="adocApplyFilters()">
                    </div>
                </div>

                <div class="table-card" style="flex:unset;">
                    <div class="table-card-header">
                        <div>
                            <div class="table-card-title">Archived Documents</div>
                            <div class="table-card-sub">Documents removed from the active list</div>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Visibility</th>
                                    <th>Tenant</th>
                                    <th>File Type</th>
                                    <th>Uploaded</th>
                                    <th>Archived On</th>
                                    <th></th>
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
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Archived On</th>
                                    <th></th>
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

        </div>
    </div>
</div>
@endsection

@section('modals')

<div class="modal-overlay" id="upload-modal">
    <div class="modal" style="max-width:560px;">
        <div class="modal-header">
            <div class="modal-title">Upload Document</div>
            <button class="modal-close" onclick="closeModal('upload-modal')">&#x2715;</button>
        </div>
        <div class="modal-two-col">
            <div class="modal-field modal-full">
                <label>Title</label>
                <input type="text" id="up-title" placeholder="e.g. March 2026 Voucher">
            </div>
            <div class="modal-field">
                <label>Category</label>
                <select id="up-type">
                    @foreach($docTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                    <option value="__new__">+ New Category</option>
                </select>
            </div>
            <div class="modal-field" id="new-category-field" style="display:none;">
                <label>New Category Name</label>
                <input type="text" id="up-new-type" placeholder="e.g. Incident Report">
            </div>
            <div class="modal-field">
                <label>Visibility</label>
                <select id="up-visibility" onchange="toggleTenantSelect()">
                    <option value="all">All Tenants</option>
                    <option value="specific">Specific Tenant</option>
                    <option value="admin">Admin Only</option>
                </select>
            </div>
            <div class="modal-field modal-full" id="tenant-select-field" style="display:none;">
                <label>Select Tenant</label>
                <select id="up-tenant">
                    <option value="">Choose a tenant...</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->tenant_id }}">
                            {{ $tenant->first_name }} {{ $tenant->last_name }}
                            @if($tenant->room_number) — Rm {{ $tenant->room_number }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-field modal-full">
                <label>File (PDF, PNG, JPG, DOCX, XLSX — max 20MB)</label>
                <input type="file" id="up-file" accept=".pdf,.png,.jpg,.jpeg,.docx,.doc,.xlsx,.xls">
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('upload-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitUpload()">Upload Document</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="view-doc-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Document Details</div>
            <button class="modal-close" onclick="closeModal('view-doc-modal')">&#x2715;</button>
        </div>
        <div id="view-doc-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-doc-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEditDoc()">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-doc-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Edit Document</div>
            <button class="modal-close" onclick="closeModal('edit-doc-modal')">&#x2715;</button>
        </div>
        <input type="hidden" id="edit-doc-id">
        <div class="modal-field">
            <label>Title</label>
            <input type="text" id="edit-doc-title">
        </div>
        <div class="modal-field">
            <label>Category</label>
            <select id="edit-doc-type">
                @foreach($docTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-field">
            <label>Visibility</label>
            <select id="edit-doc-vis" onchange="toggleEditTenantSelect()">
                <option value="all">All Tenants</option>
                <option value="specific">Specific Tenant</option>
                <option value="admin">Admin Only</option>
            </select>
        </div>
        <div class="modal-field" id="edit-tenant-field" style="display:none;">
            <label>Tenant</label>
            <select id="edit-doc-tenant">
                <option value="">Choose a tenant...</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->tenant_id }}">
                        {{ $tenant->first_name }} {{ $tenant->last_name }}
                        @if($tenant->room_number) — Rm {{ $tenant->room_number }} @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('edit-doc-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitEditDoc()">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-doc-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Delete Document</div>
            <button class="modal-close" onclick="closeModal('delete-doc-modal')">&#x2715;</button>
        </div>
        <div class="delete-warn">This action cannot be undone. The document will be moved to the archive.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Delete <strong id="delete-doc-label" style="color:var(--ink);"></strong>?
        </p>
        <input type="hidden" id="delete-doc-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-doc-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmDeleteDoc()">Delete</button>
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
            <select id="upd-req-status">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="approved">Approved</option>
                <option value="ready">Ready for Pickup / Sending</option>
                <option value="denied">Denied</option>
            </select>
        </div>
        <div class="modal-field">
            <label>Admin Remarks</label>
            <textarea id="upd-req-remarks" placeholder="Add remarks or reason for denial..."></textarea>
        </div>
        <div class="modal-field" id="upd-doc-field">
            <label>Attach Fulfilled Document — PDF only (optional)</label>
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
            <div class="modal-title">Archived Document Details</div>
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

@endsection

@section('scripts')
<script>
    const CSRF     = document.querySelector('meta[name="csrf-token"]').content;
    const docTypes = @json($docTypes);

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

    let docState  = { type: '', vis: '', search: '', page: 1, perPage: 10, data: [], filtered: [] };
    let reqState  = { status: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
    let adocState = { filterType: '', filterVis: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
    let areqState = { filterStatus: '', sort: 'newest', search: '', page: 1, perPage: 10, data: [], filtered: [] };
    let currentDoc = null;
    let currentReq = null;

    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + tab + '-btn').classList.add('active');
        document.getElementById('panel-' + tab).classList.add('active');
        if (tab === 'docs') fetchDocs();
        if (tab === 'reqs') fetchReqs();
    }

    function switchDrawerTab(tab) {
        document.querySelectorAll('.drawer-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.drawer-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('dtab-' + tab + '-btn').classList.add('active');
        document.getElementById('dpanel-' + tab).classList.add('active');
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

    function toggleTenantSelect() {
        const v = document.getElementById('up-visibility').value;
        document.getElementById('tenant-select-field').style.display = v === 'specific' ? 'flex' : 'none';
    }

    function toggleEditTenantSelect() {
        const v = document.getElementById('edit-doc-vis').value;
        document.getElementById('edit-tenant-field').style.display = v === 'specific' ? 'flex' : 'none';
    }

    document.getElementById('up-type').addEventListener('change', function () {
        document.getElementById('new-category-field').style.display = this.value === '__new__' ? 'flex' : 'none';
    });

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

    function visBadge(v) {
        if (v === 'all')      return '<span class="visibility-badge vis-all">All Tenants</span>';
        if (v === 'specific') return '<span class="visibility-badge vis-specific">Specific Tenant</span>';
        return '<span class="visibility-badge vis-admin">Admin Only</span>';
    }

    function reqStatusBadge(s) {
        const map = {
            pending:    '<span class="req-status-badge req-pending">Pending</span>',
            processing: '<span class="req-status-badge req-processing">Processing</span>',
            approved:   '<span class="req-status-badge req-approved">Approved</span>',
            ready:      '<span class="req-status-badge req-ready">Ready</span>',
            denied:     '<span class="req-status-badge req-denied">Denied</span>',
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
        document.getElementById('doc-tbody').innerHTML = `<tr><td colspan="7"><div class="empty-state">Loading...</div></td></tr>`;
        try {
            const res  = await fetch('/admin/documents', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
            const data = await res.json();
            if (data.error) {
                document.getElementById('doc-tbody').innerHTML = `<tr><td colspan="7"><div class="empty-state" style="color:red">${data.error}</div></td></tr>`;
                return;
            }
            docState.data = data.data ?? data;
            docApplyFilters();
            updateDocCounts();
            document.getElementById('tab-docs-count').textContent = docState.data.length;
        } catch (e) {
            document.getElementById('doc-tbody').innerHTML = `<tr><td colspan="7"><div class="empty-state" style="color:var(--red)">Failed to load documents.</div></td></tr>`;
        }
    }

    function docApplyFilters() {
        const q   = document.getElementById('doc-search').value.toLowerCase();
        const vis = document.getElementById('doc-filter-vis').value;
        docState.vis    = vis;
        docState.search = q;
        docState.filtered = docState.data.filter(d => {
            const matchType   = !docState.type || d.document_type === docState.type;
            const matchVis    = !vis || d.visibility === vis;
            const matchSearch = !q ||
                (d.title         ?? '').toLowerCase().includes(q) ||
                (d.tenant_name   ?? '').toLowerCase().includes(q) ||
                (d.document_type ?? '').toLowerCase().includes(q);
            return matchType && matchVis && matchSearch;
        });
        docState.page = 1;
        renderDocTable();
    }

    function docSetType(btn, type) {
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        docState.type = type;
        document.getElementById('doc-filter-type').value = type;
        docApplyFilters();
    }

    function updateDocCounts() {
        const counts = {};
        docState.data.forEach(d => { counts[d.document_type] = (counts[d.document_type] || 0) + 1; });
        document.getElementById('sc-all').textContent = docState.data.length;
        document.querySelectorAll('.type-btn[data-type]').forEach(btn => {
            const t = btn.dataset.type;
            if (!t) return;
            const slug    = t.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            const countEl = document.getElementById('sc-' + slug);
            if (countEl) countEl.textContent = counts[t] || 0;
        });
    }

    function renderDocTable() {
        const start = (docState.page - 1) * docState.perPage;
        const page  = docState.filtered.slice(start, start + docState.perPage);
        const tbody = document.getElementById('doc-tbody');

        if (!page.length) {
            tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><img src="{{ asset('icons/nav-docu.png') }}" alt="">No documents found.</div></td></tr>`;
        } else {
            tbody.innerHTML = page.map(d => {
                const color = TYPE_COLORS[d.document_type] || '#B5B7C0';
                return `<tr>
                    <td>
                        <div class="doc-title-cell">
                            <span class="doc-dot" style="background:${color}"></span>
                            ${escHtml(d.title)}
                        </div>
                    </td>
                    <td style="font-size:.8rem;color:var(--ink-muted);">${escHtml(d.document_type)}</td>
                    <td>${visBadge(d.visibility)}</td>
                    <td style="font-size:.82rem;">${escHtml(d.tenant_name || '—')}</td>
                    <td>${fileTypeBadge(d.file_path)}</td>
                    <td style="font-size:.8rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(d.date_posted)}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewDoc(${JSON.stringify(d)})'>
                                <img src="${eyeIcon}" alt="View">
                            </button>
                            <button class="act-btn" title="Edit" onclick='openEditDoc(${JSON.stringify(d)})'>
                                <img src="${editIcon}" alt="Edit">
                            </button>
                            <button class="act-btn danger" title="Delete" onclick="promptDeleteDoc(${d.document_id}, '${escHtml(d.title)}')">
                                <img src="${deleteIcon}" alt="Delete">
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }

        const total  = docState.filtered.length;
        const endIdx = Math.min(start + docState.perPage, total);
        document.getElementById('doc-info').textContent = `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
        renderPagination('doc-pagination', docState.page, Math.ceil(total / docState.perPage), p => { docState.page = p; renderDocTable(); });
    }

    function viewDoc(d) {
        currentDoc = d;
        document.getElementById('view-doc-content').innerHTML = `
            <div class="view-detail-row">
                <div class="view-detail-label">Title</div>
                <div class="view-detail-val">${escHtml(d.title)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Category</div>
                <div class="view-detail-val">${escHtml(d.document_type)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Visibility</div>
                <div class="view-detail-val">${visBadge(d.visibility)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Tenant</div>
                <div class="view-detail-val">${escHtml(d.tenant_name || '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">File Type</div>
                <div class="view-detail-val">${fileTypeBadge(d.file_path)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Uploaded</div>
                <div class="view-detail-val">${fmtDate(d.created_at)}</div>
            </div>
            ${d.file_path
                ? `<a class="btn-view-file" href="/storage/${d.file_path}" target="_blank">Open File</a>`
                : '<p style="font-size:.82rem;color:var(--ink-muted);margin-top:.5rem;">No file attached.</p>'}
        `;
        openModal('view-doc-modal');
    }

    function switchToEditDoc() {
        if (currentDoc) { closeModal('view-doc-modal'); setTimeout(() => openEditDoc(currentDoc), 200); }
    }

    function openEditDoc(d) {
        currentDoc = d;
        document.getElementById('edit-doc-id').value     = d.document_id;
        document.getElementById('edit-doc-title').value  = d.title;
        document.getElementById('edit-doc-type').value   = d.document_type;
        document.getElementById('edit-doc-vis').value    = d.visibility ?? 'admin';
        document.getElementById('edit-doc-tenant').value = d.tenant_id ?? '';
        toggleEditTenantSelect();
        openModal('edit-doc-modal');
    }

    async function submitEditDoc() {
        const id    = document.getElementById('edit-doc-id').value;
        const title = document.getElementById('edit-doc-title').value.trim();
        const type  = document.getElementById('edit-doc-type').value;
        const vis   = document.getElementById('edit-doc-vis').value;
        const tid   = document.getElementById('edit-doc-tenant').value;
        if (!title) { showToast('Title is required', 'error'); return; }
        try {
            const res = await fetch(`/admin/documents/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ title, document_type: type, visibility: vis, tenant_id: tid || null }),
            });
            if (!res.ok) throw new Error();
            closeModal('edit-doc-modal');
            showToast('Document updated successfully.', 'success');
            fetchDocs();
        } catch { showToast('Update failed.', 'error'); }
    }

    function promptDeleteDoc(id, title) {
        document.getElementById('delete-doc-id').value          = id;
        document.getElementById('delete-doc-label').textContent = title;
        openModal('delete-doc-modal');
    }

    async function confirmDeleteDoc() {
        const id = document.getElementById('delete-doc-id').value;
        try {
            const res = await fetch(`/admin/documents/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            if (!res.ok) throw new Error();
            closeModal('delete-doc-modal');
            showToast('Document deleted and archived.', 'success');
            fetchDocs();
        } catch { showToast('Delete failed.', 'error'); }
    }

    async function submitUpload() {
        const title = document.getElementById('up-title').value.trim();
        let   type  = document.getElementById('up-type').value;
        const vis   = document.getElementById('up-visibility').value;
        const tid   = document.getElementById('up-tenant').value;
        const file  = document.getElementById('up-file').files[0];

        if (type === '__new__') {
            type = document.getElementById('up-new-type').value.trim();
            if (!type) { showToast('Please enter a category name.', 'error'); return; }
        }
        if (!title) { showToast('Title is required.', 'error'); return; }

        const fd = new FormData();
        fd.append('title', title);
        fd.append('document_type', type);
        fd.append('visibility', vis);
        if (vis === 'specific' && tid) fd.append('tenant_id', tid);
        if (file) fd.append('file', file);

        try {
            const res = await fetch('/admin/documents', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: fd,
            });
            if (!res.ok) throw new Error();
            closeModal('upload-modal');
            document.getElementById('up-title').value = '';
            document.getElementById('up-file').value  = '';
            showToast('Document uploaded successfully.', 'success');
            fetchDocs();
        } catch { showToast('Upload failed.', 'error'); }
    }

    async function fetchReqs() {
        document.getElementById('req-tbody').innerHTML = `<tr><td colspan="9"><div class="empty-state">Loading...</div></td></tr>`;
        try {
            const res  = await fetch('/admin/document-requests', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
            const data = await res.json();
            if (data.error) {
                document.getElementById('req-tbody').innerHTML = `<tr><td colspan="9"><div class="empty-state" style="color:red">${data.error}</div></td></tr>`;
                return;
            }
            reqState.data = data.data ?? data;
            const pending = reqState.data.filter(r => r.status === 'pending').length;
            document.getElementById('tab-reqs-count').textContent = pending;
            reqApplyFilters();
        } catch (e) {
            document.getElementById('req-tbody').innerHTML = `<tr><td colspan="9"><div class="empty-state" style="color:var(--red)">Failed to load requests.</div></td></tr>`;
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
            tbody.innerHTML = `<tr><td colspan="9"><div class="empty-state"><img src="{{ asset('icons/pending.png') }}" alt="">No document requests found.</div></td></tr>`;
        } else {
            tbody.innerHTML = page.map(r => `<tr>
                <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#DRQ-${String(r.doc_request_id).padStart(3, '0')}</td>
                <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${escHtml(r.tenant_name ?? '—')}</td>
                <td style="font-size:.82rem;">${escHtml(r.document_type)}</td>
                <td style="font-size:.8rem;color:var(--ink-muted);max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${escHtml(r.purpose)}">${escHtml(r.purpose ?? '—')}</td>
                <td style="font-size:.8rem;">${escHtml(r.delivery_type ?? '—')}</td>
                <td style="font-size:.8rem;white-space:nowrap;">${fmtDate(r.date_needed)}</td>
                <td style="font-size:.78rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(r.submitted_at)}</td>
                <td>${reqStatusBadge(r.status)}</td>
                <td>
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
        document.getElementById('req-info').textContent = `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
        renderPagination('req-pagination', reqState.page, Math.ceil(total / reqState.perPage), p => { reqState.page = p; renderReqTable(); });
    }

    function viewReq(r) {
        currentReq = r;

        const attachmentHtml = r.attachment
            ? `<a class="btn-view-file" href="/storage/${r.attachment}" target="_blank">View Tenant's Uploaded Form</a>`
            : '<span style="font-size:.82rem;color:var(--ink-muted);">No attachment uploaded.</span>';

        const fulfilledHtml = r.fulfilled_file
            ? `<a class="btn-view-file" href="/storage/${r.fulfilled_file}" target="_blank">View Fulfilled Document</a>`
            : '<span style="font-size:.82rem;color:var(--ink-muted);">No document sent yet.</span>';

        document.getElementById('view-req-content').innerHTML = `
            <div class="view-detail-row">
                <div class="view-detail-label">Request ID</div>
                <div class="view-detail-val" style="font-weight:700;color:var(--hot-pink);">#DRQ-${String(r.doc_request_id).padStart(3, '0')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Tenant</div>
                <div class="view-detail-val">${escHtml(r.tenant_name ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Document Type</div>
                <div class="view-detail-val">${escHtml(r.document_type)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Purpose</div>
                <div class="view-detail-val">${escHtml(r.purpose ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Delivery Type</div>
                <div class="view-detail-val">${escHtml(r.delivery_type ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Needed</div>
                <div class="view-detail-val">${fmtDate(r.date_needed)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Submitted</div>
                <div class="view-detail-val">${fmtDate(r.submitted_at)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Status</div>
                <div class="view-detail-val">${reqStatusBadge(r.status)}</div>
            </div>
            ${r.admin_remarks ? `
            <div class="view-detail-row">
                <div class="view-detail-label">Admin Remarks</div>
                <div class="view-detail-val"><div class="remark-box">${escHtml(r.admin_remarks)}</div></div>
            </div>` : ''}
            <div class="view-detail-row">
                <div class="view-detail-label">Tenant Attachment</div>
                <div class="view-detail-val">${attachmentHtml}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Fulfilled Document</div>
                <div class="view-detail-val">${fulfilledHtml}</div>
            </div>
        `;
        document.getElementById('view-req-actions').innerHTML = `
            <button class="btn-cancel" onclick="closeModal('view-req-modal')">Close</button>
            <button class="btn-submit" onclick="closeModal('view-req-modal');setTimeout(()=>openUpdateReq(currentReq),200);">Update Status</button>
        `;
        openModal('view-req-modal');
    }

    function openUpdateReq(r) {
        currentReq = r;
        document.getElementById('upd-req-id').value      = r.doc_request_id;
        document.getElementById('upd-req-status').value  = r.status ?? 'pending';
        document.getElementById('upd-req-remarks').value = r.admin_remarks ?? '';
        document.getElementById('upd-req-file').value    = '';
        openModal('update-req-modal');
    }

    async function submitUpdateReq() {
        const id      = document.getElementById('upd-req-id').value;
        const status  = document.getElementById('upd-req-status').value;
        const remarks = document.getElementById('upd-req-remarks').value;
        const file    = document.getElementById('upd-req-file').files[0];

        if (file) {
            if (file.type !== 'application/pdf') {
                showToast('Only PDF files are allowed.', 'error');
                return;
            }
            if (file.size > 20 * 1024 * 1024) {
                showToast('File must be under 20MB.', 'error');
                return;
            }
        }

        const fd = new FormData();
        fd.append('_method', 'PUT');
        fd.append('status', status);
        fd.append('admin_remarks', remarks);
        if (file) fd.append('fulfilled_file', file);

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
        }
    }

    function promptDeleteReq(id, label) {
        document.getElementById('delete-req-id').value          = id;
        document.getElementById('delete-req-label').textContent = label;
        openModal('delete-req-modal');
    }

    async function confirmDeleteReq() {
        const id = document.getElementById('delete-req-id').value;
        try {
            const res = await fetch(`/admin/document-requests/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            if (!res.ok) throw new Error();
            closeModal('delete-req-modal');
            showToast('Request archived.', 'success');
            fetchReqs();
        } catch { showToast('Archive failed.', 'error'); }
    }

    async function fetchArchive() {
        try {
            const res  = await fetch('/admin/archive-docus', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
            const data = await res.json();
            if (data.error) return;

            adocState.data = data.filter(r => r.archivable_type === 'document');
            areqState.data = data.filter(r => r.archivable_type === 'document_request');

            document.getElementById('dtab-docs-count').textContent = adocState.data.length;
            document.getElementById('dtab-reqs-count').textContent = areqState.data.length;

            populateAdocTypeFilter();
            adocApplyFilters();
            areqApplyFilters();
        } catch (e) {
            document.getElementById('adoc-tbody').innerHTML = `<tr><td colspan="8"><div class="empty-state" style="color:var(--red)">Failed to load archive.</div></td></tr>`;
        }
    }

    function populateAdocTypeFilter() {
        const types   = [...new Set(adocState.data.map(r => r.data?.document_type).filter(Boolean))].sort();
        const sel     = document.getElementById('adoc-filter-type');
        const current = sel.value;
        sel.innerHTML = '<option value="">All Categories</option>';
        types.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t;
            opt.textContent = t;
            if (t === current) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    function adocApplyFilters() {
        const q    = document.getElementById('adoc-search').value.toLowerCase();
        const type = document.getElementById('adoc-filter-type').value;
        const vis  = document.getElementById('adoc-filter-vis').value;
        const sort = document.getElementById('adoc-sort').value;

        adocState.filtered = adocState.data.filter(r => {
            const d           = r.data ?? {};
            const matchType   = !type || d.document_type === type;
            const matchVis    = !vis  || d.visibility === vis;
            const matchSearch = !q   ||
                (d.title         ?? '').toLowerCase().includes(q) ||
                (d.tenant_name   ?? '').toLowerCase().includes(q) ||
                (d.document_type ?? '').toLowerCase().includes(q);
            return matchType && matchVis && matchSearch;
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
            tbody.innerHTML = `<tr><td colspan="8"><div class="empty-state"><img src="{{ asset('icons/nav-docu.png') }}" alt="">No archived documents found.</div></td></tr>`;
        } else {
            tbody.innerHTML = page.map(r => {
                const d     = r.data ?? {};
                const color = TYPE_COLORS[d.document_type] || '#B5B7C0';
                return `<tr>
                    <td>
                        <div class="doc-title-cell">
                            <span class="doc-dot" style="background:${color}"></span>
                            ${escHtml(d.title)}
                        </div>
                    </td>
                    <td style="font-size:.8rem;color:var(--ink-muted);">${escHtml(d.document_type)}</td>
                    <td>${visBadge(d.visibility)}</td>
                    <td style="font-size:.82rem;">${escHtml(d.tenant_name || '—')}</td>
                    <td>${fileTypeBadge(d.file_path)}</td>
                    <td style="font-size:.8rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(d.date_posted)}</td>
                    <td style="font-size:.8rem;white-space:nowrap;">
                        <span class="archive-badge">${fmtDate(r.archived_at)}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewAdoc(${JSON.stringify(r)})'>
                                <img src="${eyeIcon}" alt="View">
                            </button>
                            <button class="act-btn danger" title="Remove from Archive" onclick="promptRemoveAdoc(${r.archive_id}, '${escHtml(d.title)}')">
                                <img src="${deleteIcon}" alt="Remove">
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }

        const total  = adocState.filtered.length;
        const endIdx = Math.min(start + adocState.perPage, total);
        document.getElementById('adoc-info').textContent = `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
        renderPagination('adoc-pagination', adocState.page, Math.ceil(total / adocState.perPage), p => { adocState.page = p; renderAdocTable(); });
    }

    function viewAdoc(r) {
        const d = r.data ?? {};
        document.getElementById('view-adoc-content').innerHTML = `
            <div class="view-detail-row">
                <div class="view-detail-label">Title</div>
                <div class="view-detail-val">${escHtml(d.title)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Category</div>
                <div class="view-detail-val">${escHtml(d.document_type)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Visibility</div>
                <div class="view-detail-val">${visBadge(d.visibility)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Tenant</div>
                <div class="view-detail-val">${escHtml(d.tenant_name || '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">File Type</div>
                <div class="view-detail-val">${fileTypeBadge(d.file_path)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Uploaded</div>
                <div class="view-detail-val">${fmtDate(d.date_posted)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Archived On</div>
                <div class="view-detail-val"><span class="archive-badge">${fmtDate(r.archived_at)}</span></div>
            </div>
        `;
        openModal('view-adoc-modal');
    }

    function promptRemoveAdoc(id, title) {
        document.getElementById('remove-adoc-id').value          = id;
        document.getElementById('remove-adoc-label').textContent = title;
        openModal('remove-adoc-modal');
    }

    async function confirmRemoveAdoc() {
        const id = document.getElementById('remove-adoc-id').value;
        try {
            const res = await fetch(`/admin/archive-docus/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            if (!res.ok) throw new Error();
            closeModal('remove-adoc-modal');
            showToast('Archive record removed.', 'success');
            fetchArchive();
        } catch { showToast('Remove failed.', 'error'); }
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
                    <td style="font-weight:700;color:var(--hot-pink);font-size:.8rem;white-space:nowrap;">#DRQ-${String(d.doc_request_id ?? 0).padStart(3, '0')}</td>
                    <td style="font-weight:600;font-size:.84rem;white-space:nowrap;">${escHtml(d.tenant_name ?? '—')}</td>
                    <td style="font-size:.82rem;">${escHtml(d.document_type)}</td>
                    <td style="font-size:.8rem;color:var(--ink-muted);max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${escHtml(d.purpose)}">${escHtml(d.purpose ?? '—')}</td>
                    <td style="font-size:.8rem;">${escHtml(d.delivery_type ?? '—')}</td>
                    <td>${reqStatusBadge(d.status)}</td>
                    <td style="font-size:.78rem;color:var(--ink-muted);white-space:nowrap;">${fmtDate(d.submitted_at)}</td>
                    <td style="font-size:.8rem;white-space:nowrap;">
                        <span class="archive-badge">${fmtDate(r.archived_at)}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewAreq(${JSON.stringify(r)})'>
                                <img src="${eyeIcon}" alt="View">
                            </button>
                            <button class="act-btn danger" title="Remove from Archive" onclick="promptRemoveAreq(${r.archive_id}, '#DRQ-${String(d.doc_request_id ?? 0).padStart(3, '0')}')">
                                <img src="${deleteIcon}" alt="Remove">
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }

        const total  = areqState.filtered.length;
        const endIdx = Math.min(start + areqState.perPage, total);
        document.getElementById('areq-info').textContent = `Showing data ${total ? start + 1 : 0} to ${endIdx} of ${total} entries`;
        renderPagination('areq-pagination', areqState.page, Math.ceil(total / areqState.perPage), p => { areqState.page = p; renderAreqTable(); });
    }

    function viewAreq(r) {
        const d = r.data ?? {};
        document.getElementById('view-areq-content').innerHTML = `
            <div class="view-detail-row">
                <div class="view-detail-label">Request ID</div>
                <div class="view-detail-val" style="font-weight:700;color:var(--hot-pink);">#DRQ-${String(d.doc_request_id ?? 0).padStart(3, '0')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Tenant</div>
                <div class="view-detail-val">${escHtml(d.tenant_name ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Document Type</div>
                <div class="view-detail-val">${escHtml(d.document_type)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Purpose</div>
                <div class="view-detail-val">${escHtml(d.purpose ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Delivery Type</div>
                <div class="view-detail-val">${escHtml(d.delivery_type ?? '—')}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Date Needed</div>
                <div class="view-detail-val">${fmtDate(d.date_needed)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Submitted</div>
                <div class="view-detail-val">${fmtDate(d.submitted_at)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Status at Archive</div>
                <div class="view-detail-val">${reqStatusBadge(d.status)}</div>
            </div>
            ${d.admin_remarks ? `
            <div class="view-detail-row">
                <div class="view-detail-label">Admin Remarks</div>
                <div class="view-detail-val"><div class="remark-box">${escHtml(d.admin_remarks)}</div></div>
            </div>` : ''}
            <div class="view-detail-row">
                <div class="view-detail-label">Archived On</div>
                <div class="view-detail-val"><span class="archive-badge">${fmtDate(r.archived_at)}</span></div>
            </div>
        `;
        openModal('view-areq-modal');
    }

    function promptRemoveAreq(id, label) {
        document.getElementById('remove-areq-id').value          = id;
        document.getElementById('remove-areq-label').textContent = label;
        openModal('remove-areq-modal');
    }

    async function confirmRemoveAreq() {
        const id = document.getElementById('remove-areq-id').value;
        try {
            const res = await fetch(`/admin/archive-docus/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            if (!res.ok) throw new Error();
            closeModal('remove-areq-modal');
            showToast('Archive record removed.', 'success');
            fetchArchive();
        } catch { showToast('Remove failed.', 'error'); }
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast('{{ session("success") }}', 'success'));
    @endif

    fetchDocs();
    fetchReqs();
</script>
@endsection