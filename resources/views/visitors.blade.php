@extends('layout')

@section('title', 'DormEase — Visitor Logs')

@section('page-title', 'Visitor Logs')

@section('styles')
<style>
    /* =========================
       (UNCHANGED — YOUR FULL UI)
       ========================= */

    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }
    .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .5rem; }

    .btn-outline {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--ink-muted);
        border: 1.5px solid var(--gray-light); font-size: .87rem; font-weight: 600;
        transition: border-color .2s, color .2s; cursor: pointer;
    }
    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.2rem;
        max-width: 680px;
    }

    .stat-box {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        padding: 1.3rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }

    .stat-icon-circle {
        width: 58px; height: 58px; border-radius: 50%;
        flex-shrink: 0;
        background: var(--pink);
        display: flex; align-items: center; justify-content: center;
    }

    .stat-num {
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
        letter-spacing: -.03em;
    }

    .stat-label {
        font-size: .8rem;
        color: var(--pink);
        font-weight: 600;
        margin-top: .2rem;
    }

    .icon-md { width: 26px; height: 26px; object-fit: contain; }

    .filters-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-group { display: flex; align-items: center; gap: .5rem; }

    .filter-label {
        font-size: .83rem;
        font-weight: 600;
        color: var(--ink-muted);
    }

    .sort-select {
        padding: .5rem .8rem;
        border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        font-size: .83rem;
        color: var(--ink-muted);
        cursor: pointer;
    }

    .date-input {
        padding: .5rem .8rem;
        border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        font-size: .83rem;
    }

    .search-wrap { position: relative; margin-left: auto; }

    .search-wrap input {
        padding: .5rem .9rem .5rem 2.2rem;
        border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        font-size: .85rem;
        width: 220px;
    }

    .table-card {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }

    th {
        padding: .75rem 1rem;
        font-size: .75rem;
        text-transform: uppercase;
        color: var(--ink-muted);
        background: var(--pink-bg);
    }

    td {
        padding: .85rem 1rem;
        font-size: .875rem;
        border-bottom: 1px solid var(--border);
    }

    tbody tr:hover { background: var(--pink-bg); }

    .badge {
        padding: .28rem .75rem;
        border-radius: 7px;
        font-size: .75rem;
        font-weight: 700;
    }

    .badge-approved { background: #e8faf5; color: var(--green); border: 1.5px solid var(--green); }
    .badge-pending { background: #fff9e6; color: #c8960c; border: 1.5px solid #f0c040; }
    .badge-denied { background: #fff0f0; color: var(--red); border: 1.5px solid var(--blush); }
    .badge-inside { background: var(--pink-card); color: var(--pink); border: 1.5px solid var(--pink-light); }

    .act-btn {
        width: 30px; height: 30px;
        border-radius: 7px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        cursor: pointer;
    }
    table th,
    table td {
    text-align: center !important;
    vertical-align: middle !important;
    }

    tbody td {
    padding: 0.9rem 1rem;
    }

    .td-name {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    }

    td .td-sub {
    text-align: center;
    }

    table {
    border-collapse: collapse;
    }

    th {
    text-align: center;
    font-weight: 700;
    }

    td {
    text-align: center;
    vertical-align: middle;
    }

</style>
@endsection

@section('content')

<div class="page-body">

    <div class="page-header">
        <div>
            <h1>Visitor Logs</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>

        <div class="header-actions">
            <button class="btn-outline" onclick="exportLogs()">🔒 Export</button>
        </div>
    </div>

    <div class="stats-row">

        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/nav-visit.png') }}" class="icon-md">
            </div>
            <div>
                <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                <div class="stat-label">Visitors Today</div>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" class="icon-md">
            </div>
            <div>
                <div class="stat-num">{{ $currentlyInside ?? 0 }}</div>
                <div class="stat-label">Currently Inside</div>
            </div>
        </div>

    </div>

    <div class="filters-row">

        <div class="filter-group">
            <span class="filter-label">Sort:</span>
            <select id="sort-select" class="sort-select" onchange="applyFilters()">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="name">Name</option>
            </select>
        </div>

        <input type="date" id="date-from" class="date-input" onchange="applyFilters()">
        <input type="date" id="date-to" class="date-input" onchange="applyFilters()">

        <div class="search-wrap">
            <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
        </div>

    </div>

    <div class="table-card">

        <table>
            <thead>
                <tr>
                    <th>Name</th>
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

@endsection

@section('scripts')
<script>

    // ✅ FIX 1: Safe JSON output
    const logs = @json($logs ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    const PER_PAGE = 7;
    let currentPage = 1;
    let filtered = Array.isArray(logs) ? [...logs] : [];

    function fmtDateTime(dt) {
        if (!dt) return '—';
        const d = new Date(dt);
        return d.toLocaleDateString() + ' ' + d.toLocaleTimeString();
    }

    function applyFilters() {

        const q = document.getElementById('search-input').value.toLowerCase();

        const from = document.getElementById('date-from').value;
        const to = document.getElementById('date-to').value;

        filtered = logs.filter(v => {

            const name = (v.visitor_name ?? '').toLowerCase();

            const arrDate = v.arrival_time
                ? new Date(v.arrival_time).toISOString().split('T')[0]
                : '';

            return (!q || name.includes(q))
                && (!from || arrDate >= from)
                && (!to || arrDate <= to);
        });

        renderTable();
    }

    function renderTable() {

        const tbody = document.getElementById('logs-tbody');

        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;">No logs found</td></tr>`;
            return;
        }

        tbody.innerHTML = filtered.map(v => `
            <tr>
                <td>${v.visitor_name ?? '—'}</td>
                <td>${fmtDateTime(v.arrival_time)}</td>
                <td>${v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside'}</td>
                <td>${v.purpose ?? '—'}</td>
                <td>${v.tenant?.name ?? '—'}</td>
                <td>${v.staff?.name ?? '—'}</td>
                <td>${getStatusBadge(v.status)}</td>
                <td><button class="act-btn">👁</button></td>
            </tr>
        `).join('');
    }

    renderTable();

    function getStatusBadge(status) {
    if (!status) return '—';

    let cls = '';

    switch (status.toLowerCase()) {
        case 'approved':
            cls = 'badge badge-approved';
            break;
        case 'pending':
            cls = 'badge badge-pending';
            break;
        case 'denied':
        case 'rejected':
            cls = 'badge badge-denied';
            break;
        case 'inside':
        case 'currently inside':
            cls = 'badge badge-inside';
            break;
        default:
            cls = 'badge';
    }

    return `<span class="${cls}">${status}</span>`;
}

</script>
@endsection