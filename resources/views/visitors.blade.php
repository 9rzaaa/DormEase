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
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.15;
    }

    .page-header .dorm-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--pink);
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
        width: 58px;
        height: 58px;
        border-radius: 50%;
        flex-shrink: 0;
        background: var(--pink);
        display: flex;
        align-items: center;
        justify-content: center;
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

    .filters-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

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

    .search-wrap {
        position: relative;
        margin-left: auto;
    }

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

    .act-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        cursor: pointer;
    }

    .search-wrap {
    position: relative;
    margin-left: auto;
}

.search-wrap .search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    opacity: 0.6;
    pointer-events: none;
}

.search-wrap input {
    padding: .5rem .9rem .5rem 2.2rem;
    border-radius: 9px;
    border: 1.5px solid var(--gray-light);
    font-size: .85rem;
    width: 220px;
}

.stat-icon-circle img {
    width: 24px;
    height: 24px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}

.stat-box:nth-child(2) .stat-icon-circle img {
    width: 34px;
    height: 34px;
}
.inside-icon {
    width: 34px; !important;
    height: 34px; !important;
    object-fit: contain;

}

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
    from {
        opacity: 0;
        transform: translateY(10px) scale(.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
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
</style>
@endsection

@section('content')

<div id="visitorModal" class="visitor-modal">

    <div class="visitor-modal-card">

        <button
            type="button"
            class="visitor-modal-close"
            onclick="closeModal()"
        >
            &times;
        </button>

        <div class="visitor-modal-header">
            <span class="visitor-modal-icon">👤</span>
            <h2>Visitor Details</h2>
        </div>

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
            <button class="btn-outline" onclick="exportLogs()">
                <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                Export
            </button>
        </div>
    </div>

    <div class="stats-row">

        <div class="stat-box">
                <div class="stat-icon-circle">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" class="icon-md">
        </div>

            <div>
                <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                <div class="stat-label">Visitors Today</div>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" class="icon-md inside-icon">            </div>

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

        <div class="filter-group">
            <span class="filter-label">From:</span>

            <input
                type="date"
                id="date-from"
                class="date-input"
                onchange="applyFilters()"
            >
        </div>

        <div class="filter-group">
            <span class="filter-label">To:</span>

            <input
                type="date"
                id="date-to"
                class="date-input"
                onchange="applyFilters()"
            >
        </div>

        <div class="search-wrap">
            <span class="search-icon">
                <img src="{{ asset('icons/search.png') }}" class="icon-sm" alt="Search">
            </span>

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