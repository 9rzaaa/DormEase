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
        color: #E8175D;
        letter-spacing: -.02em;
        line-height: 1.15;
    }

    .page-header .dorm-name {
        font-size: 1rem;
        font-weight: 600;
        color: #E8175D;
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

    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }

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

    .stat-box:hover { box-shadow: 0 4px 20px rgba(220,80,120,.1); }

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
        color: white;
        font-weight: 700;
        margin-top: .2rem;
    }

    .stat-sub {
        font-size: .76rem;
        color: white;
        font-weight: 500;
        margin-top: .15rem;
    }

    @media (max-width: 640px) {
        .stats-row { grid-template-columns: 1fr; }
    }

    /* ───────── TABLE CARD ───────── */
    .table-card {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    /* ───────── TABLE HEADER ───────── */
    .table-header {
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
        flex-wrap: wrap;
        gap: .8rem;
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
    }

    .table-date {
        font-size: .78rem;
        color: rgba(255,255,255,.75);
        margin-top: .1rem;
    }

    /* ───────── TABLE CONTROLS (inside header) ───────── */
.table-controls {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: nowrap;
}

.table-controls .search-wrap {
    position: relative;
    flex-shrink: 0;
}

.table-controls .search-wrap .search-icon {
    position: absolute;
    left: 9px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #e8175d;
    pointer-events: none;
}

.table-controls .search-wrap input {
    padding: .45rem .9rem;
    border-radius: 9px;
    border: none;
    font-size: .83rem;
    width: 190px;
    background: #ffffff;
    color: #e8175d;
    outline: none;
    transition: box-shadow .2s;
}

.table-controls .search-wrap input:focus {
    box-shadow: 0 0 0 2px rgba(255,255,255,.6);
}

.table-controls .search-wrap input::placeholder {
    color: #f0a0b8;
}

.table-controls .date-range-wrap {
    display: flex;
    align-items: center;
    gap: .35rem;
    flex-shrink: 0;
}

.table-controls .date-range-wrap .range-label {
    font-size: .8rem;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
}

.table-controls .date-range-wrap .range-sep {
    font-size: .8rem;
    font-weight: 700;
    color: rgba(255,255,255,.75);
    white-space: nowrap;
}

.table-controls .date-input {
    padding: .42rem .7rem;
    border-radius: 9px;
    border: none;
    background: #ffffff;
    font-size: .82rem;
    color: #e8175d;
    cursor: pointer;
    outline: none;
    transition: box-shadow .2s;
    white-space: nowrap;
}

.table-controls .date-input:focus {
    box-shadow: 0 0 0 2px rgba(255,255,255,.6);
}

.table-controls .filter-label {
    font-size: .8rem;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
}

.table-controls .sort-select,
.table-controls .date-input {
    padding: .42rem .7rem;
    border-radius: 9px;
    border: none;
    background: #ffffff;
    font-size: .82rem;
    color: #e8175d;
    cursor: pointer;
    outline: none;
    transition: box-shadow .2s;
    white-space: nowrap;
}

.table-controls .sort-select:focus,
.table-controls .date-input:focus {
    box-shadow: 0 0 0 2px rgba(255,255,255,.6);
}

.table-controls .sort-select option {
    color: #e8175d;
    background: #fff;
    font-weight: 700;
}

.table-controls .filter-divider {
    width: 1px;
    height: 20px;
    background: rgba(255,255,255,.45);
    flex-shrink: 0;
}
    /* ───────── TABLE ───────── */
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; min-width: 980px; }

    th {
        padding: .75rem 1rem;
        font-size: .75rem;
        text-transform: uppercase;
        color: #e8175d;
        background: var(--pink-bg);
        text-align: center;
        font-weight: 700;
        white-space: nowrap;
    }

    td {
        padding: .9rem 1rem;
        font-size: .875rem;
        border-bottom: 1px solid var(--border);
        text-align: center;
        vertical-align: middle;
    }

    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: var(--pink-bg); }

    /* ───────── BADGES ───────── */
    .badge { padding: .28rem .75rem; border-radius: 7px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
    .badge-approved,
    .badge-completed { background: #e8faf5; color: var(--green); border: 1.5px solid var(--green); }
    .badge-pending   { background: #fff9e6; color: #c8960c;      border: 1.5px solid #f0c040;      }
    .badge-denied    { background: #fff0f0; color: var(--red);   border: 1.5px solid var(--blush); }
    .badge-inside    { background: var(--pink-card); color: var(--pink); border: 1.5px solid var(--pink-light); }

    .time-pending { color: #bbb; font-style: italic; font-size: .78rem; }

    /* ───────── ACTION BUTTON ───────── */
    .act-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        cursor: pointer;
    }

    .act-btn:hover { border-color: var(--pink); background: var(--pink-bg); }

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
        width: 660px;
        max-width: 100%;
        max-height: 90vh;
        overflow-y: auto;
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
        line-height: 1;
        transition: color .2s;
    }

    .visitor-modal-close:hover { color: var(--pink); }

    .visitor-modal-header {
        display: flex;
        align-items: center;
        gap: .8rem;
        margin-bottom: 1.6rem;
    }

    .visitor-modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.02em;
    }

    .modal-section-title {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--pink);
        margin: 1.1rem 0 .3rem;
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
        <button type="button" class="visitor-modal-close" onclick="closeModal()">&times;</button>
        <div class="visitor-modal-header">
            <span style="font-size:1.7rem">👤</span>
            <h2>Visitor Details</h2>
        </div>
        <div id="modalContent"></div>
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

    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="table-title">All Visitors</div>
                <div class="table-date">as of {{ now()->format('F d, Y') }}</div>
            </div>

            <div class="table-controls">
    <div class="search-wrap">
        <input
            type="text"
            id="search-input"
            placeholder="Search visitor..."
            onkeyup="applyFilters()"
        >
    </div>

    <div class="filter-divider"></div>

    <div class="filter-group">
        <span class="filter-label">Sort:</span>
        <select id="sort-select" class="sort-select" onchange="applyFilters()">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
            <option value="name">Name</option>
        </select>
    </div>

    <div class="filter-divider"></div>

    {{-- Single date range --}}
    <div class="date-range-wrap">
        <span class="range-label">Date:</span>
        <input type="date" id="date-from" class="date-input" onchange="applyFilters()">
        <span class="range-sep">—</span>
        <input type="date" id="date-to" class="date-input" onchange="applyFilters()">
    </div>
</div>
        </div>

        <div class="table-wrap">
            <table>
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

    const logs = @json($logs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    let filtered = Array.isArray(logs) ? [...logs] : [];

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

    function applyFilters() {
        const q    = document.getElementById('search-input').value.toLowerCase().trim();
        const from = document.getElementById('date-from').value;
        const to   = document.getElementById('date-to').value;
        const sort = document.getElementById('sort-select').value;

        filtered = logs.filter(v => {
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

        filtered.sort((a, b) => {
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
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align:center;padding:2.5rem;color:#bbb;font-size:.9rem;">
                        No visitor logs found.
                    </td>
                </tr>`;
            return;
        }

        tbody.innerHTML = filtered.map(v => {

            const expectedVisit = (v.date_of_visit || v.time_of_visit)
                ? `${fmtDate(v.date_of_visit)}<br><small style="color:#aaa">${fmtTime(v.time_of_visit)}</small>`
                : '—';

            const timeIn = v.arrival_time
                ? fmtDateTime(v.arrival_time)
                : `<span class="time-pending">Not yet</span>`;

            const timeOut = v.departure_time
                ? fmtDateTime(v.departure_time)
                : (v.arrival_time
                    ? `<span style="color:#c8960c;font-size:.8rem;font-weight:600">Still Inside</span>`
                    : '—');

            return `
                <tr>
                    <td style="font-weight:600;text-align:left">${v.visitor_name ?? '—'}</td>
                    <td>${expectedVisit}</td>
                    <td>${timeIn}</td>
                    <td>${timeOut}</td>
                    <td>${v.purpose ?? '—'}</td>
                    <td>${v.tenant?.full_name ?? '—'}</td>
                    <td>${v.staff?.name  ?? '—'}</td>
                    <td>${getStatusBadge(v.status)}</td>
                    <td>
                        <button class="act-btn" title="View details" onclick="viewVisitor(${v.id})">👁</button>
                    </td>
                </tr>`;
        }).join('');
    }

    function getStatusBadge(status) {
        if (!status) return '—';
        const map = {
            approved:  'badge-approved',
            completed: 'badge-completed',
            pending:   'badge-pending',
            denied:    'badge-denied',
            rejected:  'badge-denied',
            inside:    'badge-inside',
            'currently inside': 'badge-inside',
        };
        const cls   = map[status.toLowerCase()] ?? '';
        const label = status.replace(/\b\w/g, c => c.toUpperCase());
        return `<span class="badge ${cls}">${label}</span>`;
    }

    function exportLogs() {
        if (!filtered.length) { alert('No data to export.'); return; }

        let csv = 'Name,Expected Date,Expected Time,Time In,Time Out,Purpose,Tenant Visited,Logged By,Status\n';
        filtered.forEach(v => {
            csv += [
                `"${v.visitor_name     ?? ''}"`,
                `"${fmtDate(v.date_of_visit)}"`,
                `"${fmtTime(v.time_of_visit)}"`,
                `"${v.arrival_time   ? fmtDateTime(v.arrival_time)   : 'Not yet'}"`,
                `"${v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside'}"`,
                `"${v.purpose        ?? ''}"`,
                `"${v.tenant?.full_name ?? ''}"`,
                `"${v.staff?.name    ?? ''}"`,
                `"${v.status         ?? ''}"`,
            ].join(',') + '\n';
        });

        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
        a.download = `visitor_logs_${new Date().toISOString().slice(0,10)}.csv`;
        a.click();
        URL.revokeObjectURL(a.href);
    }

    function viewVisitor(id) {
        const v = logs.find(item => item.id === id);
        if (!v) return;

        const timeInDisplay = v.arrival_time
            ? fmtDateTime(v.arrival_time)
            : '<span style="color:#bbb;font-style:italic">Not yet checked in</span>';

        const timeOutDisplay = v.departure_time
            ? fmtDateTime(v.departure_time)
            : (v.arrival_time ? '<span style="color:#c8960c">Still Inside</span>' : '—');

        let idPhotoHtml = '';
        if (v.id_photo) {
            const src = v.id_photo.startsWith('http') ? v.id_photo : `/storage/${v.id_photo}`;
            idPhotoHtml = `
                <div class="id-photo-wrap">
                    <img src="${src}" alt="ID Photo" onerror="this.style.display='none'">
                    <a href="${src}" target="_blank" rel="noopener">Open full image ↗</a>
                </div>`;
        } else {
            idPhotoHtml = `<div class="id-photo-wrap"><p class="no-id-photo">No ID photo uploaded.</p></div>`;
        }

        document.getElementById('modalContent').innerHTML = `

            <div class="modal-section-title">Visitor Info</div>
            ${row('Visitor ID',     'VST-' + String(v.id).padStart(3, '0'))}
            ${row('Full Name',      v.visitor_name ?? '—')}
            ${row('Contact No.',    v.contact_no   ?? '—')}
            ${row('Purpose',        v.purpose      ?? '—')}
            ${row('Tenant Visited', v.tenant?.full_name ?? '—')}

            <div class="modal-section-title">Schedule</div>
            ${row('Expected Date',  fmtDate(v.date_of_visit))}
            ${row('Expected Time',  fmtTime(v.time_of_visit))}
            ${row('Time In',        timeInDisplay)}
            ${row('Time Out',       timeOutDisplay)}

            <div class="modal-section-title">Log Info</div>
            ${row('Status',    getStatusBadge(v.status))}
            ${row('Logged By', v.staff?.name ?? '—')}

            <div class="modal-section-title">ID Verification</div>
            ${row('ID Type', v.id_type ?? '—')}
            ${idPhotoHtml}
        `;

        document.getElementById('visitorModal').style.display = 'flex';
    }

    function row(label, value) {
        return `
            <div class="modal-row">
                <span class="modal-label">${label}</span>
                <span class="modal-value">${value}</span>
            </div>`;
    }

    function closeModal() {
        document.getElementById('visitorModal').style.display = 'none';
    }

    window.onclick = e => {
        if (e.target === document.getElementById('visitorModal')) closeModal();
    };

    applyFilters();

</script>
@endsection