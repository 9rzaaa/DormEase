@extends('layout')

@section('title', 'DormEase — Visitor Logs')

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
        color: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);;
        letter-spacing: -.02em;
        line-height: 1.15;
    }

    .page-header .dorm-name {
        font-size: 1rem;
        font-weight: 600;
        color: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);;
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
    }

    .btn-outline:hover {
        border-color: var(--pink);
        color: var(--pink);
    }

    /* ───────── STATS ───────── */
    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }

    .stat-box {
        background: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(255,79,147,.25);
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
        background: rgba(255,255,255,.18);
        backdrop-filter: blur(8px);
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
        filter: brightness(0) invert(1);
    }

    .stat-num {
        font-size: 2.2rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        letter-spacing: -.03em;
    }

    .stat-label {
        font-size: .85rem;
        color: rgba(255,255,255,.85);
        font-weight: 500;
        margin-top: .2rem;
    }

    .stat-sub {
        font-size: .76rem;
        color: rgba(255,255,255,.65);
        font-weight: 600;
        margin-top: .15rem;
    }

    @media (max-width: 640px) {
        .stats-row { grid-template-columns: 1fr; }
    }

    /* ───────── FILTERS ───────── */
    .filters-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: nowrap;
        padding: .75rem 1.1rem;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: .4rem;
        flex-shrink: 0;
    }

    .filter-label {
        font-size: .8rem;
        font-weight: 700;
        color: #b03060;
        background: #ffffff;
        white-space: nowrap;
    }

    .sort-select,
    .date-input {
        padding: .45rem .75rem;
        border-radius: 9px;
        border: 2px solid #ffd3e3;
        background: #ffffff;
        font-size: .82rem;
        color: #b03060;
        cursor: pointer;
        outline: none;
        transition: border-color .2s;
        white-space: nowrap;
    }

    .sort-select:focus,
    .date-input:focus {
        border-color: #E8175D;
    }

    .filter-divider {
        width: 1px;
        height: 22px;
        background: #ffd3e3;
        flex-shrink: 0;
    }

    .search-wrap {
        position: relative;
        margin-left: auto;
        flex-shrink: 0;
    }

    .search-wrap .search-icon {
        position: absolute;
        left: 9px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        opacity: 0.5;
        pointer-events: none;
    }

    .search-wrap input {
        padding: .45rem .9rem;
        border-radius: 9px;
        border: 2px solid #ffd3e3;
        font-size: .83rem;
        width: 200px;
        background: #ffffff;
        color: #b03060;
        outline: none;
        transition: border-color .2s;
    }

    .search-wrap input:focus {
        border-color: #E8175D;
    }

    .search-wrap input::placeholder {
        color: #d08aaa;
    }

    /* ───────── TABLE CARD ───────── */
    .table-card {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: .75rem 1rem;
        font-size: .75rem;
        text-transform: uppercase;
        color: var(--ink-muted);
        background: var(--pink-bg);
        text-align: center;
        font-weight: 700;
    }

    td {
        padding: .9rem 1rem;
        font-size: .875rem;
        border-bottom: 1px solid var(--border);
        text-align: center;
        vertical-align: middle;
    }

    tbody tr:hover {
        background: var(--pink-bg);
    }

    /* ───────── BADGES ───────── */
    .badge {
        padding: .28rem .75rem;
        border-radius: 7px;
        font-size: .75rem;
        font-weight: 700;
    }

    .badge-approved {
        background: #e8faf5;
        color: var(--green);
        border: 1.5px solid var(--green);
    }

    .badge-pending {
        background: #fff9e6;
        color: #c8960c;
        border: 1.5px solid #f0c040;
    }

    .badge-denied {
        background: #fff0f0;
        color: var(--red);
        border: 1.5px solid var(--blush);
    }

    .badge-inside {
        background: var(--pink-card);
        color: var(--pink);
        border: 1.5px solid var(--pink-light);
    }

    /* ───────── ACTION BUTTON ───────── */
    .act-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        cursor: pointer;
    }

    /* ───────── VISITOR MODAL ───────── */
    .visitor-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.45);
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .visitor-modal-card {
        background: var(--white);
        width: 620px;
        max-width: 100%;
        border-radius: 28px;
        padding: 2.2rem 2.5rem;
        box-shadow: 0 15px 40px rgba(0,0,0,.18);
        position: relative;
        animation: modalFade .25s ease;
    }

    @keyframes modalFade {
        from { opacity: 0; transform: translateY(10px) scale(.98); }
        to   { opacity: 1; transform: translateY(0)    scale(1);   }
    }

    .visitor-modal-close {
        position: absolute;
        top: 18px;
        right: 22px;
        border: none;
        background: none;
        font-size: 2rem;
        color: #8d7480;
        cursor: pointer;
        transition: .2s ease;
    }

    .visitor-modal-close:hover {
        color: var(--pink);
        transform: scale(1.08);
    }

    .visitor-modal-header {
        display: flex;
        align-items: center;
        gap: .8rem;
        margin-bottom: 2rem;
    }

    .visitor-modal-icon {
        font-size: 1.7rem;
        color: #6c3eb8;
    }

    .visitor-modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.02em;
    }

    .visitor-modal-content {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .modal-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.2rem;
        padding-bottom: .95rem;
        border-bottom: 1px solid #eee;
    }

    .modal-label {
        color: #8d7480;
        font-size: .82rem;
        font-weight: 500;
    }

    .modal-value {
        color: var(--ink);
        font-size: .82rem;
        font-weight: 600;
        text-align: right;
    }

    /* ───────── ANIMATIONS ───────── */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    .fade-up { animation: fadeIn .45s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s;  }
    .d4 { animation-delay: .28s; }
</style>
@endsection

@section('content')

<div id="visitorModal" class="visitor-modal">

    <div class="visitor-modal-card">

        <!-- Close Button -->
        <button
            type="button"
            class="visitor-modal-close"
            onclick="closeModal()"
        >
            &times;
        </button>

        <!-- Header -->
        <div class="visitor-modal-header">
            <span class="visitor-modal-icon">👤</span>
            <h2>Visitor Details</h2>
        </div>

        <!-- Dynamic Content -->
        <div id="modalContent" class="visitor-modal-content"></div>

    </div>

</div>

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

    <div class="stats-row fade-up d2">
    <div class="stat-box">
        <div class="stat-icon-circle">
            <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Visitors">
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

    <div class="filters-row">

    <div class="filter-group">
        <span class="filter-label">Sort:</span>
        <select id="sort-select" class="sort-select" onchange="applyFilters()">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
            <option value="name">Name</option>
        </select>
    </div>

    <div class="filter-divider"></div>

    <div class="filter-group">
        <span class="filter-label">From:</span>
        <input type="date" id="date-from" class="date-input" onchange="applyFilters()">
    </div>

    <div class="filter-group">
        <span class="filter-label">To:</span>
        <input type="date" id="date-to" class="date-input" onchange="applyFilters()">
    </div>

    <div class="filter-divider"></div>

    <div class="search-wrap">
        <input
            type="text"
            id="search-input"
            placeholder="Search visitor..."
            onkeyup="applyFilters()"
        >
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

        const q = document
            .getElementById('search-input')
            .value
            .toLowerCase()
            .trim();

        const from = document.getElementById('date-from').value;
        const to = document.getElementById('date-to').value;

        const sort = document.getElementById('sort-select').value;

        filtered = logs.filter(v => {

            const visitor = (v.visitor_name ?? '').toLowerCase();
            const tenant = (v.tenant?.name ?? '').toLowerCase();
            const purpose = (v.purpose ?? '').toLowerCase();
            const staff = (v.staff?.name ?? '').toLowerCase();

            const arrDate = v.arrival_time
                ? new Date(v.arrival_time).toISOString().split('T')[0]
                : '';

            const matchesSearch =
                !q ||
                visitor.includes(q) ||
                tenant.includes(q) ||
                purpose.includes(q) ||
                staff.includes(q);

            const matchesFrom = !from || arrDate >= from;
            const matchesTo = !to || arrDate <= to;

            return matchesSearch && matchesFrom && matchesTo;
        });

        filtered.sort((a, b) => {

            if (sort === 'newest') {
                return new Date(b.arrival_time) - new Date(a.arrival_time);
            }

            if (sort === 'oldest') {
                return new Date(a.arrival_time) - new Date(b.arrival_time);
            }

            if (sort === 'name') {
                return (a.visitor_name || '')
                    .localeCompare(b.visitor_name || '');
            }

            return 0;
        });

        renderTable();
    }

    function renderTable() {

        const tbody = document.getElementById('logs-tbody');

        if (filtered.length === 0) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align:center;">
                        No logs found
                    </td>
                </tr>
            `;

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
                <td>
                <button class="act-btn" onclick="viewVisitor(${v.id})">👁</button>
                </td>
            </tr>
        `).join('');
    }

    function getStatusBadge(status) {

        if (!status) return '—';

        const s = status.toLowerCase();

        let cls = '';

        switch (s) {

            case 'approved':
            case 'completed':
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

        const label = status
            .toString()
            .toLowerCase()
            .replace(/\b\w/g, char => char.toUpperCase());

        return `<span class="${cls}">${label}</span>`;
    }

    applyFilters();
function exportLogs() {

    if (!filtered.length) {
        alert("No data to export.");
        return;
    }

    let csv = "Name,Time In,Time Out,Purpose,Tenant Visited,Logged By,Status\n";

    filtered.forEach(v => {
        csv += `"${v.visitor_name ?? ''}",`
            + `"${fmtDateTime(v.arrival_time)}",`
            + `"${v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside'}",`
            + `"${v.purpose ?? ''}",`
            + `"${v.tenant?.name ?? ''}",`
            + `"${v.staff?.name ?? ''}",`
            + `"${v.status ?? ''}"\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.href = url;
    a.download = "visitor_logs.csv";
    a.click();

    window.URL.revokeObjectURL(url);
}

function viewVisitor(id) {

    const v = logs.find(item => item.id === id);

    if (!v) return;

    document.getElementById('modalContent').innerHTML = `

        ${detailRow(
            'Visitor ID',
            'VST-' + String(v.id).padStart(3, '0')
        )}

        ${detailRow(
            'Full Name',
            v.visitor_name ?? '—'
        )}

        ${detailRow(
            'Time In',
            fmtDateTime(v.arrival_time)
        )}

        ${detailRow(
            'Time Out',
            v.departure_time
                ? fmtDateTime(v.departure_time)
                : 'Still Inside'
        )}

        ${detailRow(
            'Purpose',
            v.purpose ?? '—'
        )}

        ${detailRow(
            'Tenant Visited',
            v.tenant?.name ?? '—'
        )}

        ${detailRow(
            'Logged By',
            v.staff?.name ?? '—'
        )}

        ${detailRow(
            'Status',
            v.status ?? '—'
        )}
    `;

    document.getElementById('visitorModal').style.display = 'flex';
}

function detailRow(label, value) {

    return `
        <div class="modal-row">

            <span class="modal-label">
                ${label}
            </span>

            <span class="modal-value">
                ${value}
            </span>

        </div>
    `;
}

function closeModal() {

    const modal = document.getElementById('visitorModal');

    modal.style.display = 'none';
}

window.onclick = function(event) {

    const modal = document.getElementById('visitorModal');

    if (event.target === modal) {
        closeModal();
    }
}

</script>
@endsection