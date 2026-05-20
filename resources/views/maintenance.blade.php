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
    }

    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1.2rem;
        border-radius: 10px;
        background: var(--white);
        color: var(--ink-muted);
        border: 1.5px solid var(--baby-pink);
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }

    .btn-export:hover {
        border-color: var(--bright-pink);
        color: var(--bright-pink);
    }

    .btn-export img {
        width: 14px;
        height: 14px;
        object-fit: contain;
        opacity: .6;
    }

    .btn-export:hover img { opacity: 1; }

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
        width: 56px;
        height: 56px;
        border-radius: 50%;
        flex-shrink: 0;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,.15);
    }

    .stat-icon img {
        width: 28px;
        height: 28px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .stat-info { flex: 1; min-width: 0; }

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
    }

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

    .date-range img {
        width: 14px;
        height: 14px;
        object-fit: contain;
        opacity: .5;
    }

    .date-range input[type="date"] {
        border: none;
        outline: none;
        font-family: var(--ff-body);
        font-size: .82rem;
        color: var(--ink);
        background: transparent;
        cursor: pointer;
    }

    .date-sep { color: var(--ink-muted); font-size: .8rem; }

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

    .table-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--ink);
    }

    .table-card-sub {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .15rem;
    }

    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: .83rem;
    }

    thead th {
        padding: .7rem 1rem;
        text-align: left;
        font-size: .72rem;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        background: var(--blush);
        border-bottom: 2px solid var(--bright-pink);
        white-space: nowrap;
    }

    tbody tr {
        border-bottom: 2px solid var(--baby-pink);
        transition: background .15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fff7fb; }

    tbody td {
        padding: .75rem 1rem;
        color: var(--ink);
        vertical-align: middle;
    }

    .req-id {
        font-weight: 700;
        color: var(--hot-pink);
        font-size: .8rem;
        white-space: nowrap;
    }

    .req-date {
        font-size: .78rem;
        color: var(--ink-muted);
        white-space: nowrap;
    }

    .room-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--petal);
        border: 1px solid var(--baby-pink);
        border-radius: 6px;
        padding: .18rem .55rem;
        font-size: .78rem;
        font-weight: 700;
        color: var(--hot-pink);
        white-space: nowrap;
    }

    .tenant-name {
        font-weight: 600;
        color: var(--ink);
        white-space: nowrap;
    }

    .issue-type {
        display: inline-flex;
        align-items: center;
        padding: .18rem .55rem;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .issue-plumbing    { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .issue-electrical  { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .issue-hvac        { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .issue-carpentry   { background: #fce4ec; color: #c62828; border: 1px solid #ef9a9a; }
    .issue-general     { background: #f3e5f5; color: #6a1b9a; border: 1px solid #ce93d8; }
    .issue-pest        { background: #fff3e0; color: #e65100; border: 1px solid #ffcc80; }
    .issue-other       { background: #f5f5f5; color: #424242; border: 1px solid #e0e0e0; }

    .desc-cell {
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--ink-muted);
        font-size: .8rem;
    }

    .urgency-badge {
        display: inline-flex;
        align-items: center;
        padding: .18rem .55rem;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .03em;
        white-space: nowrap;
    }

    .urgency-low      { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .urgency-moderate { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .urgency-urgent   { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: .2rem .65rem;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-pending     { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .status-in-progress { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .status-resolved    { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .status-closed      { background: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }

    .action-btn {
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

    .action-btn:hover {
        border-color: var(--bright-pink);
        box-shadow: 0 3px 10px rgba(255,45,120,.15);
    }

    .action-btn img {
        width: 13px;
        height: 13px;
        object-fit: contain;
    }

    .table-footer {
        padding: .85rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 2px solid var(--petal);
        flex-wrap: wrap;
        gap: .5rem;
        background: var(--white)
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

    .maint-modal-field {
        display: flex;
        flex-direction: column;
        gap: .35rem;
        margin-bottom: .9rem;
    }

    .maint-modal-field label {
        font-size: .75rem;
        font-weight: 700;
        color: var(--hot-pink);
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .maint-modal-field input,
    .maint-modal-field select,
    .maint-modal-field textarea {
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

    .maint-modal-field textarea { min-height: 90px; resize: vertical; }

    .maint-modal-field input:focus,
    .maint-modal-field select:focus,
    .maint-modal-field textarea:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }

    .modal-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
    }

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
        padding: .75rem 1rem;
        font-size: .83rem;
        color: var(--ink-muted);
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--ink-muted);
        font-size: .88rem;
    }

    .empty-state img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        opacity: .4;
        margin-bottom: .5rem;
        display: block;
        margin-left: auto;
        margin-right: auto;
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

    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 700px) {
        .stats-grid { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
        .modal-two-col { grid-template-columns: 1fr; }
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
            <button class="btn-export" onclick="exportTable()">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
        </div>
    </div>

    <div class="stats-grid fade-up d2">
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/nav-maint.png') }}" alt="">
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Requests</div>
                <div class="stat-num" id="stat-total">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/warn.png') }}" alt="">
            </div>
            <div class="stat-info">
                <div class="stat-label">Urgent Requests</div>
                <div class="stat-num" id="stat-urgent">{{ $stats['urgent'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/pending.png') }}" alt="">
            </div>
            <div class="stat-info">
                <div class="stat-label">In-Progress Requests</div>
                <div class="stat-num" id="stat-progress">{{ $stats['in_progress'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <img src="{{ asset('icons/resolved.png') }}" alt="">
            </div>
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
            <option value="closed">Closed</option>
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
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Room No.</th>
                        <th>Tenant Name</th>
                        <th>Issue Type</th>
                        <th>Description</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th></th>
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

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">Request Details</div>
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
    <div class="modal" style="max-width:540px;">
        <div class="modal-header">
            <div class="modal-title">Update Request</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
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
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <div style="background:#fff0f0;border:1.5px solid #ffc8d0;border-radius:10px;padding:.7rem 1rem;font-size:.83rem;color:#c0303a;margin-bottom:1rem;line-height:1.5;">
            This action cannot be undone. The request will be permanently deleted.
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
    const requests = @json($requests);
    const perPage  = 10;
    let filtered    = [...requests];
    let currentPage = 1;
    let currentReq  = null;

    const issueClasses = {
        plumbing:   'issue-plumbing',
        electrical: 'issue-electrical',
        hvac:       'issue-hvac',
        carpentry:  'issue-carpentry',
        general:    'issue-general',
        pest:       'issue-pest',
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
        return new Date(d).toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
    }

    function escHtml(str) {
        return (str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
    }

    const eyeIcon    = "{{ asset('icons/eye.png') }}";
    const editIcon   = "{{ asset('icons/edit.png') }}";
    const deleteIcon = "{{ asset('icons/delete.png') }}";

    function buildRow(r) {
        const issueKey = (r.issue_type ?? '').toLowerCase();
        const cls = issueClasses[issueKey] ?? 'issue-other';
        const safeR = escHtml(JSON.stringify(r));
        return `<tr>
            <td><span class="req-id">#REQ-${String(r.id).padStart(3,'0')}</span></td>
            <td><span class="req-date">${fmtDate(r.created_at)}</span></td>
            <td><span class="room-badge">${escHtml(r.room_number ?? '—')}</span></td>
            <td><span class="tenant-name">${escHtml(r.tenant_name ?? '—')}</span></td>
            <td><span class="issue-type ${cls}">${escHtml(r.issue_type ?? '—')}</span></td>
            <td><div class="desc-cell" title="${escHtml(r.description)}">${escHtml(r.description ?? '—')}</div></td>
            <td>${urgencyBadge(r.urgency)}</td>
            <td>${statusBadge(r.status)}</td>
            <td>
                <div style="display:flex;gap:.3rem;">
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
                    <img src="${"{{ asset('icons/maintenance.png') }}"}" alt="">
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
                <div class="view-detail-val">${fmtDate(r.created_at)}</div>
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
                fmtDate(r.created_at),
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

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    applyFilters();
</script>
@endsection