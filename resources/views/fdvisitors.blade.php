@extends('fdlayout')

@section('title', 'DormEase: Visitor Logs')
@section('page-title', 'Visitor Logs')

@section('styles')
<style>

    .dorm-name { font-size: 1rem; font-weight: 600; color: var(--bright-pink); margin-top: .2rem; }

    .btn-primary {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        color: var(--white); border: none; font-size: .87rem; font-weight: 700;
        box-shadow: 0 3px 12px rgba(232,23,93,.3);
        transition: opacity .2s, transform .15s; cursor: pointer;
    }
    .btn-primary:hover { opacity: .9; transform: translateY(-1px); }

    .btn-archive-open {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--hot-pink);
        border: 1.5px solid var(--pink-light);
        font-size: .87rem; font-weight: 600;
        cursor: pointer; transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }
    .btn-archive-open:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .btn-archive-open img { width: 14px; height: 14px; object-fit: contain; opacity: .6; }
    .btn-archive-open:hover img { opacity: 1; }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1.2rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--bright-pink);
        border: 1.5px solid var(--pink-light);
        font-size: .87rem;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .btn-outline:hover {
        border-color: var(--bright-pink);
        color: var(--bright-pink);
        background: var(--pink-bg);
    }

    .stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.2rem; }

    .stat-box {
        background: var(--bright-pink);
        border-radius: 18px; border: none;
        box-shadow: 0 8px 18px rgba(0,0,0,.05), 0 18px 40px rgba(232,23,93,.25);
        padding: 1.4rem 1.5rem;
        display: flex; align-items: center; gap: 1.2rem;
        box-sizing: border-box; min-width: 0; overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,23,93,.35); }

    .stat-icon-circle {
        width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
        background: var(--white); display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,.15);
    }
    .stat-icon-circle img {
        width: 28px; height: 28px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .stat-num { font-size: 2rem; font-weight: 700; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; color: rgba(247,245,245,.967); margin-top: .1rem; font-weight: 600; }

    .table-card { background: var(--white); border-radius: 16px; border: 1.5px solid var(--bright-pink); box-shadow: var(--shadow); overflow: hidden; }

    .table-header {
        padding: 1.2rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1.5px solid var(--pink-light);
        flex-wrap: wrap; gap: .8rem;
    }

    .table-controls { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }

    .sort-wrap { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--ink-muted); font-weight: 500; }

    .sort-select {
        padding: .45rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
        outline: none; cursor: pointer;
    }
    .sort-select:focus { border-color: var(--bright-pink); }

    .date-wrap { display: flex; align-items: center; gap: .4rem; font-size: .82rem; color: var(--ink-muted); font-weight: 500; }

    .date-input {
        padding: .45rem .7rem; border-radius: 9px;
        border: 1.5px solid var(--pink-light);
        font-family: var(--ff-body); font-size: .82rem; color: var(--ink); outline: none;
    }
    .date-input:focus { border-color: var(--bright-pink); }

    .search-wrap { position: relative; }
    .search-wrap input {
        padding: .48rem .9rem .48rem 2.2rem;
        border-radius: 9px; border: 1.5px solid var(--pink-light);
        font-family: var(--ff-body); font-size: .85rem; color: var(--ink);
        background: var(--pink-bg); outline: none; width: 210px;
        transition: border-color .2s, width .3s;
    }
    .search-wrap input:focus { border-color: var(--bright-pink); width: 250px; }
    .search-icon {
        position: absolute; left: .65rem; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; object-fit: contain; pointer-events: none;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--pink-100); }
    th {
        padding: .75rem 1rem; text-align: left;
        font-size: .73rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
        border-bottom: 1.5px solid var(--bright-pink);
    }
    td { padding: .85rem 1rem; font-size: .875rem; color: var(--ink); border-bottom: 1.5px solid var(--border); vertical-align: middle; }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: var(--pink-bg); }
    tbody tr:last-child td { border-bottom: none; }
    .td-name { font-weight: 600; }
    .td-sub  { font-size: .78rem; color: var(--ink-muted); margin-top: .1rem; }

    .badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .25rem .7rem; border-radius: 7px;
        font-size: .74rem; font-weight: 700; white-space: nowrap;
    }
    .badge-inside    { background: #e8f4ff; color: #1a6fbf; border: 1.5px solid #90c3ef; }
    .badge-approved  { background: #e8faf5; color: var(--green); border: 1.5px solid var(--green); }
    .badge-pending   { background: #fff9e6; color: #c8960c; border: 1.5px solid #f0c040; }
    .badge-rejected  { background: #fff0f0; color: var(--red); border: 1.5px solid var(--blush); }
    .badge-completed { background: var(--gray-light); color: var(--ink-muted); border: 1.5px solid var(--gray); }

    .action-group { display: flex; align-items: center; gap: .4rem; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn img { width: 14px; height: 14px; object-fit: contain; opacity: .55; }
    .act-btn:hover { border-color: var(--bright-pink); background: var(--pink-bg); }
    .act-btn:hover img { opacity: 1; }
    .act-btn.green:hover { border-color: var(--green); background: #f0fdf8; }
    .act-btn.red:hover   { border-color: var(--red); background: #fff0f0; }
    .act-btn.blue:hover  { border-color: #1a6fbf; background: #e8f4ff; }
    .act-btn[disabled]   { opacity: .35; cursor: not-allowed; pointer-events: none; }

    .table-footer {
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid var(--border); flex-wrap: wrap; gap: .5rem;
    }
    .table-showing { font-size: .8rem; color: var(--ink-muted); }

    .pagination { display: flex; align-items: center; gap: .35rem; }
    .page-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        font-size: .83rem; font-weight: 600; color: var(--bright-pink);
        cursor: pointer; transition: border-color .2s, background .2s, color .2s;
        display: flex; align-items: center; justify-content: center;
    }
    .page-btn:hover { border-color: var(--bright-pink); background: var(--pink-card); }
    .page-btn.active { background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink)); color: var(--white); border-color: var(--hot-pink); }
    .page-btn:disabled { opacity: .4; cursor: default; }
    .page-ellipsis { font-size: .85rem; color: var(--ink-muted); padding: 0 .2rem; }

    .empty-state { text-align: center; padding: 2.5rem; color: var(--ink-muted); font-size: .88rem; }

    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field.full { grid-column: 1 / -1; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 700; color: var(--ink-muted); margin-bottom: .35rem; }
    .modal-field input,
    .modal-field select {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: var(--pink-bg); outline: none;
        transition: border-color .2s;
    }
    .modal-field input:focus,
    .modal-field select:focus { border-color: var(--bright-pink); background: var(--white); }
    .modal-field .hint { font-size: .74rem; color: var(--ink-muted); margin-top: .3rem; }

    .modal-section-title {
        font-size: .78rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .07em;
        margin: 1.2rem 0 .6rem;
        padding-bottom: .4rem;
        border-bottom: 1px solid var(--border);
    }

    .status-select {
        padding: .4rem .7rem; border-radius: 8px;
        border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
        font-size: .83rem; color: var(--ink); outline: none; cursor: pointer; width: 100%;
    }
    .status-select:focus { border-color: var(--bright-pink); }

    .archive-backdrop {
        position: fixed; inset: 0;
        background: rgba(232, 23, 93, 0.15);
        backdrop-filter: blur(3px);
        z-index: 499;
        opacity: 0; pointer-events: none;
        transition: opacity .38s ease;
    }
    .archive-backdrop.open { opacity: 1; pointer-events: auto; }

    .archive-drawer {
        position: fixed;
        top: 0; right: 0; bottom: 0;
        width: min(680px, 100vw);
        background: var(--blush, #fff5f8);
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
        border-bottom: 1.5px solid var(--pink-light);
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1rem; flex-shrink: 0;
        background: var(--white);
    }
    .archive-drawer-title { font-size: 1.2rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; line-height: 1.2; }
    .archive-drawer-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .25rem; font-weight: 500; }

    .archive-close-btn {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--white); border: 1.5px solid var(--pink-light);
        color: var(--hot-pink); font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: border-color .2s, background .2s; flex-shrink: 0;
    }
    .archive-close-btn:hover { border-color: var(--bright-pink); background: var(--pink-bg); }

    .archive-tabs {
        display: flex; gap: 0; padding: 0 1.8rem;
        border-bottom: 1.5px solid var(--pink-light);
        flex-shrink: 0; background: var(--white);
    }
    .archive-tab {
        padding: .85rem 1.2rem; font-size: .82rem; font-weight: 700;
        color: var(--ink-muted); background: none; border: none;
        border-bottom: 2px solid transparent; margin-bottom: -1.5px;
        cursor: pointer; transition: color .2s, border-color .2s;
        display: flex; align-items: center; gap: .5rem;
        letter-spacing: .02em; font-family: var(--ff-body);
    }
    .archive-tab:hover { color: var(--hot-pink); }
    .archive-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }
    .archive-tab-count {
        font-size: .68rem; font-weight: 800;
        padding: .1rem .45rem; border-radius: 99px;
        background: var(--pink-light); color: var(--ink-muted); letter-spacing: .02em;
    }
    .archive-tab.active .archive-tab-count { background: var(--hot-pink); color: var(--white); }

    .archive-search-bar { padding: 1rem 1.8rem .8rem; flex-shrink: 0; }
    .archive-search-inner { position: relative; display: flex; align-items: center; }
    .archive-search-inner input {
        width: 100%; padding: .55rem .9rem .55rem 2.2rem;
        border-radius: 10px; border: 1.5px solid var(--pink-light);
        background: var(--white); color: var(--ink);
        font-size: .83rem; font-family: var(--ff-body); outline: none;
        transition: border-color .2s;
    }
    .archive-search-inner input::placeholder { color: var(--ink-muted); }
    .archive-search-inner input:focus { border-color: var(--bright-pink); }
    .archive-search-icon {
        position: absolute; left: .75rem; width: 13px; height: 13px;
        opacity: .4; pointer-events: none;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .archive-list {
        flex: 1; overflow-y: auto; padding: 0 1.8rem 1.8rem;
        display: flex; flex-direction: column; gap: .75rem;
    }
    .archive-list::-webkit-scrollbar { width: 4px; }
    .archive-list::-webkit-scrollbar-track { background: transparent; }
    .archive-list::-webkit-scrollbar-thumb { background: var(--pink-light); border-radius: 99px; }

    .archive-card {
        background: var(--white); border: 1.5px solid var(--pink-light);
        border-radius: 14px; padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s, transform .2s;
        animation: archiveSlideIn .3s ease both;
    }
    @keyframes archiveSlideIn {
        from { opacity: 0; transform: translateX(12px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .archive-card:hover {
        background: var(--pink-bg); border-color: var(--bright-pink);
        box-shadow: 0 6px 18px rgba(232,23,93,.12); transform: translateY(-1px);
    }

    .archive-card-top {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: .8rem; margin-bottom: .5rem;
    }
    .archive-card-id { font-size: .78rem; font-weight: 800; color: var(--hot-pink); letter-spacing: .02em; }
    .archive-card-time { font-size: .7rem; color: var(--ink-muted); font-weight: 500; white-space: nowrap; flex-shrink: 0; }
    .archive-card-visitor { font-size: .88rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
    .archive-card-tenant { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; }

    .archive-card-meta {
        display: flex; align-items: center; gap: .5rem;
        margin-top: .6rem; flex-wrap: wrap;
    }
    .archive-pill {
        font-size: .68rem; font-weight: 700;
        padding: .18rem .55rem; border-radius: 99px;
        letter-spacing: .03em; text-transform: uppercase;
        display: inline-flex; align-items: center; justify-content: center;
        line-height: 1; vertical-align: middle;
    }
    .archive-pill-purpose { background: var(--pink-bg); color: var(--hot-pink); border: 1px solid var(--pink-light); }
    .archive-pill-completed { background: #f0f0f0; color: #555; border: 1px solid #ddd; }
    .archive-pill-deleted { background: #fff0f0; color: var(--red); border: 1px solid #ffc8d0; }

    .archive-card-footer {
        display: flex; align-items: center; gap: .4rem;
        margin-top: .7rem; padding-top: .6rem;
        border-top: 1px solid var(--pink-light);
        font-size: .7rem; color: var(--ink-muted); font-weight: 500;
    }
    .archive-card-footer span { color: var(--ink); font-weight: 600; }

    .archive-empty {
        text-align: center; padding: 3rem 1rem;
        color: var(--ink-muted); font-size: .85rem;
    }
    .archive-empty-icon {
        width: 40px; height: 40px; margin: 0 auto .75rem;
        opacity: .25; display: block; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .archive-footer {
        padding: .9rem 1.8rem;
        border-top: 1.5px solid var(--pink-light);
        background: var(--white);
        display: flex; align-items: center; justify-content: space-between;
        flex-shrink: 0; flex-wrap: wrap; gap: .5rem;
    }
    .archive-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
    .archive-export-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .75rem; font-weight: 700; color: var(--hot-pink);
        background: var(--white); border: 1.5px solid var(--pink-light);
        border-radius: 8px; padding: .35rem .85rem;
        cursor: pointer; transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }
    .archive-export-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .6; }

    @media (max-width: 900px) {
        .stats-row  { grid-template-columns: 1fr; }
        .modal-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; }
        .archive-drawer { width: 100vw; }
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
        <div>
            <h1>Visitor Logs</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openModal('add-modal')">
                + Add Walk-in Visitor
            </button>

            <button class="btn-archive-open" onclick="openArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>

            <button class="btn-outline" onclick="exportVisitors()">
                <img src="{{ asset('icons/export.png') }}" alt=""> Export
            </button>

        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/visitor.png') }}" alt="">
            </div>
            <div>
                <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                <div class="stat-label">Visitors Today</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/nav-db.png') }}" alt="">
            </div>
            <div>
                <div class="stat-num">{{ $currentlyInside ?? 0 }}</div>
                <div class="stat-label">Currently Inside</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div class="table-controls">
                <div class="sort-wrap">
                    Sort By:
                    <select class="sort-select" id="sort-select" onchange="sortTable()">
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="name">Name A-Z</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <div class="date-wrap">
                    From:
                    <input type="date" class="date-input" id="date-from" onchange="filterTable()">
                    to
                    <input type="date" class="date-input" id="date-to" onchange="filterTable()">
                </div>
            </div>
            <div class="search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                <input type="text" id="search-input" placeholder="Search by name, tenant, room..." oninput="filterTable()">
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Visitor Name</th>
                        <th>Date &amp; Time In</th>
                        <th>Date &amp; Time Out</th>
                        <th>Purpose of Visit</th>
                        <th>Tenant Visited</th>
                        <th>Logged By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="visitor-tbody"></tbody>
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

<div class="archive-backdrop" id="archive-backdrop" onclick="closeArchive()"></div>

<div class="archive-drawer" id="archive-drawer">
    <div class="archive-drawer-header">
        <div>
            <div class="archive-drawer-title">Archive &amp; History</div>
            <div class="archive-drawer-sub">Record of completed and deleted visitor logs</div>
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
        <button class="archive-export-btn" onclick="exportArchive()">
            <img src="{{ asset('icons/export.png') }}" alt="">
            Export CSV
        </button>
    </div>
</div>

<div class="modal-overlay" id="add-modal">
    <div class="modal" style="max-width:540px;">
        <div class="modal-header">
            <div class="modal-title">Add Walk-in Visitor</div>
            <button class="modal-close" onclick="closeModal('add-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('visitors.store') }}">
            @csrf
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Visitor Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="visitor_name" placeholder="e.g. Maria Santos" required value="{{ old('visitor_name') }}">
                </div>
                <div class="modal-field">
                    <label>Contact No.</label>
                    <input type="text" name="contact_no" placeholder="e.g. 0912-345-6789" value="{{ old('contact_no') }}">
                </div>
                <div class="modal-field">
                    <label>Tenant to Visit <span style="color:var(--red)">*</span></label>
                    <select name="tenant_id" required>
                        <option value="">Select Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id') == $tenant->tenant_id ? 'selected' : '' }}>
                                {{ $tenant->first_name }} {{ $tenant->last_name }}
                                @if($tenant->room_number) &mdash; Rm {{ $tenant->room_number }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-field">
                    <label>Purpose of Visit <span style="color:var(--red)">*</span></label>
                    <select name="purpose" required>
                        <option value="">Select Purpose</option>
                        <option value="Visiting Tenant">Visiting Tenant</option>
                        <option value="Food Delivery">Food Delivery</option>
                        <option value="Laundry Pickup">Laundry Pickup</option>
                        <option value="Package Delivery">Package Delivery</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>ID Type</label>
                    <select name="id_type">
                        <option value="">Select ID Type</option>
                        <option value="School ID">School ID</option>
                        <option value="Government ID">Government ID</option>
                        <option value="Passport">Passport</option>
                        <option value="Driver's License">Driver's License</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Time In <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="arrival_time" required value="{{ old('arrival_time', now()->format('Y-m-d\TH:i')) }}">
                    <div class="hint">Status will auto-set to "Inside"</div>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Log Visitor</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Visitor Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" id="view-actions"></div>
    </div>
</div>

<div class="modal-overlay" id="timein-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Log Time In</div>
            <button class="modal-close" onclick="closeModal('timein-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Log time in for <strong id="timein-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="timein-form" action="">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Time In</label>
                <input type="datetime-local" name="arrival_time" id="timein-input" required>
                <div class="hint">Status will automatically change to "Inside"</div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('timein-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Confirm Time In</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="timeout-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Log Time Out</div>
            <button class="modal-close" onclick="closeModal('timeout-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Log time out for <strong id="timeout-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="timeout-form" action="">
            @csrf
            <div class="modal-field">
                <label>Time Out</label>
                <input type="datetime-local" name="departure_time" id="timeout-input" required>
                <div class="hint">Status will automatically change to "Completed"</div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('timeout-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:var(--green);">Confirm Time Out</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="status-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Update Visitor Status</div>
            <button class="modal-close" onclick="closeModal('status-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Update status for <strong id="status-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="status-form" action="">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Status</label>
                <select name="status" id="status-select" class="status-select">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('status-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Status</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>

    const visitors          = @json($visitors);
    const completedVisitors = @json($completedVisitors);
    const deletedVisitors   = @json($deletedVisitors);

    const PER_PAGE = 7;
    let currentPage = 1;
    let filtered    = [...visitors];
    let archiveTab  = 'completed';

    function fmtDateTime(d) {
        if (!d) return '&mdash;';
        const dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
             + ', ' + dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
        const dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' })
             + ' ' + dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }

    function badge(status) {
        const map = {
            'inside':    '<span class="badge badge-inside">Inside</span>',
            'approved':  '<span class="badge badge-approved">Approved</span>',
            'pending':   '<span class="badge badge-pending">Pending</span>',
            'rejected':  '<span class="badge badge-rejected">Rejected</span>',
            'completed': '<span class="badge badge-completed">Completed</span>',
        };
        return map[status] ?? '<span class="badge badge-pending">' + (status ?? '') + '</span>';
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('visitor-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="empty-state">No visitor logs found.</td></tr>';
        } else {
            tbody.innerHTML = pageData.map(function(v) {
                const canTimein  = !v.arrival_time && v.status !== 'rejected';
                const canTimeout = v.arrival_time && !v.departure_time;

                return '<tr>'
                    + '<td class="td-name">' + (v.visitor_name ?? '') + '</td>'
                    + '<td>' + fmtDateTime(v.arrival_time) + '</td>'
                    + '<td>' + (v.departure_time ? fmtDateTime(v.departure_time) : '&mdash;') + '</td>'
                    + '<td>' + (v.purpose ?? '&mdash;') + '</td>'
                    + '<td>'
                        + '<div class="td-name">' + (v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '&mdash;') + '</div>'
                        + (v.tenant && v.tenant.room_number ? '<div class="td-sub">Rm ' + v.tenant.room_number + '</div>' : '')
                    + '</td>'
                    + '<td>'
                        + '<div class="td-name">' + (v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '&mdash;') + '</div>'
                    + '</td>'
                    + '<td>' + badge(v.status) + '</td>'
                    + '<td>'
                        + '<div class="action-group">'
                            + '<button class="act-btn" title="View Details" onclick=\'viewVisitor(' + JSON.stringify(v).replace(/'/g, "&#39;") + ')\'>'
                                + '<img src="{{ asset('icons/eye.png') }}" alt="View">'
                            + '</button>'
                            + '<button class="act-btn green" title="Log Time In" ' + (!canTimein ? 'disabled' : '') + ' onclick="openTimein(' + v.visitor_id + ', \'' + (v.visitor_name ?? '').replace(/'/g, "\\'") + '\')">'
                                + '<img src="{{ asset('icons/check.png') }}" alt="Time In">'
                            + '</button>'
                            + '<button class="act-btn blue" title="Log Time Out" ' + (!canTimeout ? 'disabled' : '') + ' onclick="openTimeout(' + v.visitor_id + ', \'' + (v.visitor_name ?? '').replace(/'/g, "\\'") + '\')">'
                                + '<img src="{{ asset('icons/logout.png') }}" alt="Time Out">'
                            + '</button>'
                            + '<button class="act-btn" title="Notify Tenant (coming soon)" onclick="showToast(\'Notify Tenant feature coming soon.\', \'\')">'
                                + '<img src="{{ asset('icons/bell.png') }}" alt="Notify">'
                            + '</button>'
                        + '</div>'
                    + '</td>'
                    + '</tr>';
            }).join('');
        }

        const total = filtered.length;
        const from  = total === 0 ? 0 : start + 1;
        const to    = Math.min(start + PER_PAGE, total);
        document.getElementById('showing-label').textContent = 'Showing data ' + from + ' to ' + to + ' of ' + total + ' entries';

        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        const pg = document.getElementById('pagination');
        let html = '';
        html += '<button class="page-btn" onclick="goPage(' + (currentPage - 1) + ')" ' + (currentPage === 1 ? 'disabled' : '') + '>&#8249;</button>';
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += '<button class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goPage(' + i + ')">' + i + '</button>';
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += '<span class="page-ellipsis">&#8230;</span>';
            }
        }
        html += '<button class="page-btn" onclick="goPage(' + (currentPage + 1) + ')" ' + (currentPage === totalPages || totalPages === 0 ? 'disabled' : '') + '>&#8250;</button>';
        pg.innerHTML = html;
    }

    function goPage(p) {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        renderTable();
    }

    function filterTable() {
        const q    = document.getElementById('search-input').value.toLowerCase();
        const from = document.getElementById('date-from').value;
        const to   = document.getElementById('date-to').value;

        filtered = visitors.filter(function(v) {
            const matchQ = !q ||
                (v.visitor_name ?? '').toLowerCase().includes(q) ||
                (v.purpose ?? '').toLowerCase().includes(q) ||
                (v.tenant ? (v.tenant.first_name + ' ' + v.tenant.last_name).toLowerCase().includes(q) : false) ||
                ((v.tenant && v.tenant.room_number) ? (v.tenant.room_number + '').toLowerCase().includes(q) : false);

            const arrDate   = v.arrival_time ? v.arrival_time.substring(0, 10) : (v.date_of_visit ?? '');
            const matchFrom = !from || arrDate >= from;
            const matchTo   = !to   || arrDate <= to;

            return matchQ && matchFrom && matchTo;
        });

        currentPage = 1;
        renderTable();
    }

    function sortTable() {
        const val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort(function(a, b) { return new Date(b.arrival_time ?? b.date_of_visit) - new Date(a.arrival_time ?? a.date_of_visit); });
        if (val === 'oldest') filtered.sort(function(a, b) { return new Date(a.arrival_time ?? a.date_of_visit) - new Date(b.arrival_time ?? b.date_of_visit); });
        if (val === 'name')   filtered.sort(function(a, b) { return (a.visitor_name ?? '').localeCompare(b.visitor_name ?? ''); });
        if (val === 'status') filtered.sort(function(a, b) { return (a.status ?? '').localeCompare(b.status ?? ''); });
        currentPage = 1;
        renderTable();
    }

    function viewVisitor(v) {
        document.getElementById('view-content').innerHTML =
            '<div class="modal-section-title">Visitor Information</div>'
            + '<div class="view-row"><span class="view-label">Visitor Name</span><span class="view-val">' + (v.visitor_name ?? '') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">' + (v.contact_no ?? '&mdash;') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Purpose</span><span class="view-val">' + (v.purpose ?? '&mdash;') + '</span></div>'
            + '<div class="view-row"><span class="view-label">ID Type</span><span class="view-val">' + (v.id_type ?? '&mdash;') + '</span></div>'
            + '<div class="modal-section-title">Visit Details</div>'
            + '<div class="view-row"><span class="view-label">Tenant Visited</span><span class="view-val">' + (v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '&mdash;') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Room</span><span class="view-val">' + ((v.tenant && v.tenant.room_number) ? v.tenant.room_number : '&mdash;') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Date of Visit</span><span class="view-val">' + (v.date_of_visit ?? '&mdash;') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Time In</span><span class="view-val">' + fmtDateTime(v.arrival_time) + '</span></div>'
            + '<div class="view-row"><span class="view-label">Time Out</span><span class="view-val">' + (v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Logged By</span><span class="view-val">' + (v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '&mdash;') + '</span></div>'
            + '<div class="view-row"><span class="view-label">Status</span><span class="view-val">' + badge(v.status) + '</span></div>';

        const actions = document.getElementById('view-actions');
        let btns = '<button class="btn-cancel" onclick="closeModal(\'view-modal\')">Close</button>';
        if (v.status === 'pending') {
            btns += '<button class="btn-submit" style="background:var(--red);" onclick="quickStatus(' + v.visitor_id + ', \'rejected\', \'' + (v.visitor_name ?? '').replace(/'/g, "\\'") + '\')">Reject</button>'
                  + '<button class="btn-submit" onclick="quickStatus(' + v.visitor_id + ', \'approved\', \'' + (v.visitor_name ?? '').replace(/'/g, "\\'") + '\')">Approve</button>';
        }
        actions.innerHTML = btns;
        openModal('view-modal');
    }

    function quickStatus(id, status, name) {
        if (!confirm('Set status to "' + status + '" for ' + name + '?')) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/visitors/' + id + '/status';
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                       + '<input type="hidden" name="_method" value="PUT">'
                       + '<input type="hidden" name="status" value="' + status + '">';
        document.body.appendChild(form);
        form.submit();
    }

    function openTimein(id, name) {
        document.getElementById('timein-name').textContent = name;
        document.getElementById('timein-form').action      = '/visitors/timein/' + id;
        document.getElementById('timein-input').value      = new Date().toISOString().slice(0, 16);
        closeModal('view-modal');
        openModal('timein-modal');
    }

    function openTimeout(id, name) {
        document.getElementById('timeout-name').textContent = name;
        document.getElementById('timeout-form').action      = '/visitors/checkout/' + id;
        document.getElementById('timeout-input').value      = new Date().toISOString().slice(0, 16);
        closeModal('view-modal');
        openModal('timeout-modal');
    }

    function exportVisitors() {
        const rows = [['Visitor Name', 'Time In', 'Time Out', 'Purpose', 'Tenant', 'Room', 'Logged By', 'Status']];
        visitors.forEach(function(v) {
            rows.push([
                v.visitor_name ?? '',
                v.arrival_time ?? '',
                v.departure_time ?? '',
                v.purpose ?? '',
                v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '',
                (v.tenant && v.tenant.room_number) ? v.tenant.room_number : '',
                v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '',
                v.status ?? '',
            ]);
        });
        const csv  = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'dormease-visitors.csv';
        a.click();
        showToast('Visitors exported as CSV!', 'success');
    }

    function openArchive() {
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        document.getElementById('acount-completed').textContent = completedVisitors.length;
        document.getElementById('acount-deleted').textContent   = deletedVisitors.length;
        renderArchive();
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-completed').classList.toggle('active', tab === 'completed');
        document.getElementById('atab-deleted').classList.toggle('active',   tab === 'deleted');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    function renderArchive() {
        const q    = document.getElementById('archive-search').value.toLowerCase();
        const data = archiveTab === 'completed' ? completedVisitors : deletedVisitors;

        const result = data.filter(function(v) {
            return (v.visitor_name ?? '').toLowerCase().includes(q)
                || (v.purpose ?? '').toLowerCase().includes(q)
                || (v.tenant ? (v.tenant.first_name + ' ' + v.tenant.last_name).toLowerCase().includes(q) : false)
                || ((v.tenant && v.tenant.room_number) ? (v.tenant.room_number + '').toLowerCase().includes(q) : false);
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

        const pillClass    = archiveTab === 'completed' ? 'archive-pill-completed' : 'archive-pill-deleted';
        const pillLabel    = archiveTab === 'completed' ? 'Completed' : 'Deleted';
        const footerLabel  = archiveTab === 'completed' ? 'Checked out on' : 'Deleted on';

        list.innerHTML = result.map(function(v, i) {
            const tenantName = v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : null;
            const roomNum    = v.tenant && v.tenant.room_number ? v.tenant.room_number : null;
            const footerDate = archiveTab === 'completed'
                ? (v.departure_time ? fmtDatePlain(v.departure_time) : fmtDatePlain(v.arrival_time))
                : fmtDatePlain(v.arrival_time);

            return '<div class="archive-card" style="animation-delay:' + (i * 0.04) + 's;">'
                + '<div class="archive-card-top">'
                    + '<div class="archive-card-id">LOG-' + String(v.visitor_id).padStart(4, '0') + '</div>'
                    + '<div class="archive-card-time">' + fmtDatePlain(v.arrival_time) + '</div>'
                + '</div>'
                + '<div class="archive-card-visitor">' + (v.visitor_name ?? '&mdash;') + '</div>'
                + (tenantName ? '<div class="archive-card-tenant">Visited: ' + tenantName + (roomNum ? ' &mdash; Rm ' + roomNum : '') + '</div>' : '')
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

    function exportArchive() {
        const data  = archiveTab === 'completed' ? completedVisitors : deletedVisitors;
        const label = archiveTab === 'completed' ? 'Checked Out On' : 'Deleted On';
        const rows  = [['Log ID', 'Visitor Name', 'Contact No.', 'Purpose', 'Tenant', 'Room', 'Time In', 'Time Out', 'Status', label]];
        data.forEach(function(v) {
            const footerDate = archiveTab === 'completed'
                ? (v.departure_time ? fmtDatePlain(v.departure_time) : fmtDatePlain(v.arrival_time))
                : fmtDatePlain(v.arrival_time);
            rows.push([
                'LOG-' + String(v.visitor_id).padStart(4, '0'),
                v.visitor_name ?? '',
                v.contact_no ?? '',
                v.purpose ?? '',
                v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '',
                (v.tenant && v.tenant.room_number) ? v.tenant.room_number : '',
                v.arrival_time ?? '',
                v.departure_time ?? '',
                v.status ?? '',
                footerDate,
            ]);
        });
        const csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        const a   = document.createElement('a');
        a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'dormease-visitors-' + archiveTab + '-archive.csv';
        a.click();
        showToast('Archive exported as CSV!', 'success');
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });
    @endif

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() { openModal('add-modal'); });
    @endif

    filtered = [...visitors];
    renderTable();

</script>
@endsection