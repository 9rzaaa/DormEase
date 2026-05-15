@extends('fdlayout')

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
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }

    .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .4rem; }

    .btn-primary {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--pink); color: var(--white);
        border: none; font-size: .87rem; font-weight: 600;
        box-shadow: 0 3px 12px rgba(202,93,134,.3);
        transition: background .2s, transform .15s; cursor: pointer;
    }
    .btn-primary:hover { background: #a8446c; transform: translateY(-1px); }

    .btn-outline {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--ink-muted);
        border: 1.5px solid var(--gray-light); font-size: .87rem; font-weight: 600;
        transition: border-color .2s, color .2s; cursor: pointer;
    }
    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }

    .stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.2rem; }

    .stat-box {
        background: var(--white); border-radius: 16px;
        border: 1px solid var(--border); box-shadow: var(--shadow);
        padding: 1.3rem 1.5rem;
        display: flex; align-items: center; gap: 1.2rem;
    }

    .stat-icon-circle {
        width: 64px; height: 64px; border-radius: 50%;
        flex-shrink: 0; background: var(--pink);
        display: flex; align-items: center; justify-content: center;
    }

    .stat-num   { font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; color: var(--ink-muted); margin-top: .1rem; font-weight: 500; }

    .table-card {
        background: var(--white); border-radius: 16px;
        border: 1px solid var(--border); box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-header {
        padding: 1.2rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: .8rem;
    }

    .table-controls { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }

    .sort-wrap { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--ink-muted); font-weight: 500; }

    .sort-select {
        padding: .45rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
        outline: none; cursor: pointer;
    }
    .sort-select:focus { border-color: var(--pink); }

    .date-wrap { display: flex; align-items: center; gap: .4rem; font-size: .82rem; color: var(--ink-muted); font-weight: 500; }

    .date-input {
        padding: .45rem .7rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        font-family: var(--ff-body); font-size: .82rem; color: var(--ink); outline: none;
    }
    .date-input:focus { border-color: var(--pink); }

    .search-wrap { position: relative; }
    .search-wrap input {
        padding: .48rem .9rem .48rem 2.2rem;
        border-radius: 9px; border: 1.5px solid var(--gray-light);
        font-family: var(--ff-body); font-size: .85rem; color: var(--ink);
        background: var(--pink-bg); outline: none; width: 210px;
        transition: border-color .2s, width .3s;
    }
    .search-wrap input:focus { border-color: var(--pink); width: 250px; }
    .search-icon {
        position: absolute; left: .65rem; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; object-fit: contain; opacity: .4; pointer-events: none;
    }

    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--pink-bg); }
    th {
        padding: .75rem 1rem; text-align: left;
        font-size: .73rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
    }
    td {
        padding: .85rem 1rem; font-size: .875rem; color: var(--ink);
        border-bottom: 1px solid var(--border); vertical-align: middle;
    }
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
        border: 1.5px solid var(--gray-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s, background .2s;
        position: relative;
    }
    .act-btn img { width: 14px; height: 14px; object-fit: contain; opacity: .55; }
    .act-btn:hover { border-color: var(--pink); background: var(--pink-bg); }
    .act-btn:hover img { opacity: 1; }
    .act-btn.green:hover  { border-color: var(--green); background: #f0fdf8; }
    .act-btn.red:hover    { border-color: var(--red);   background: #fff0f0; }
    .act-btn.blue:hover   { border-color: #1a6fbf;      background: #e8f4ff; }
    .act-btn[disabled]    { opacity: .35; cursor: not-allowed; pointer-events: none; }

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
    .page-btn:hover  { border-color: var(--pink); color: var(--pink); }
    .page-btn.active { background: var(--pink); color: var(--white); border-color: var(--pink); }
    .page-btn:disabled { opacity: .4; cursor: default; }
    .page-ellipsis { font-size: .85rem; color: var(--ink-muted); padding: 0 .2rem; }

    .empty-state { text-align: center; padding: 2.5rem; color: var(--ink-muted); font-size: .88rem; }

    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field { margin-bottom: 0; }
    .modal-field.full { grid-column: 1 / -1; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .35rem; }
    .modal-field input,
    .modal-field select {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: #fafafa; outline: none;
        transition: border-color .2s;
    }
    .modal-field input:focus,
    .modal-field select:focus { border-color: var(--pink); background: var(--white); }
    .modal-field .hint { font-size: .74rem; color: var(--ink-muted); margin-top: .3rem; }

    .view-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem;
    }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; flex-shrink: 0; margin-right: 1rem; }
    .view-val   { font-weight: 600; color: var(--ink); text-align: right; }

    .status-select {
        padding: .4rem .7rem; border-radius: 8px;
        border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
        font-size: .83rem; color: var(--ink); outline: none; cursor: pointer;
    }
    .status-select:focus { border-color: var(--pink); }

    .modal-section-title {
        font-size: .78rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .07em;
        margin: 1.2rem 0 .6rem;
        padding-bottom: .4rem;
        border-bottom: 1px solid var(--border);
    }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeIn .45s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .20s; }

    @media (max-width: 900px) {
        .stats-row  { grid-template-columns: 1fr; }
        .modal-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; }
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
            <button class="btn-outline" onclick="exportVisitors()">
                <img src="{{ asset('icons/export.png') }}" alt="" style="width:14px; height:14px; object-fit:contain; margin-right:4px;">
                Export
            </button>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/visitor.png') }}" class="icon-md" style="filter:brightness(0) invert(1)" alt="">
            </div>
            <div>
                <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                <div class="stat-label">Visitors Today</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/nav-db.png') }}" class="icon-md" style="filter:brightness(0) invert(1)" alt="">
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
                        <option value="name">Name A–Z</option>
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
                <input type="text" id="search-input" placeholder="Search by ID, Tenant, Room..." oninput="filterTable()">
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Visitor Name</th>
                        <th>Date & Time In</th>
                        <th>Date & Time Out</th>
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

<div class="modal-overlay" id="add-modal">
    <div class="modal" style="max-width:540px;">
        <div class="modal-header">
            <div class="modal-title">Add Walk-in Visitor</div>
            <button class="modal-close" onclick="closeModal('add-modal')">✕</button>
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
                                @if($tenant->room_number) — Rm {{ $tenant->room_number }} @endif
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
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" id="view-actions"></div>
    </div>
</div>

<div class="modal-overlay" id="timein-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Log Time In</div>
            <button class="modal-close" onclick="closeModal('timein-modal')">✕</button>
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
            <button class="modal-close" onclick="closeModal('timeout-modal')">✕</button>
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
            <button class="modal-close" onclick="closeModal('status-modal')">✕</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Update status for <strong id="status-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="status-form" action="">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Status</label>
                <select name="status" id="status-select" class="status-select" style="width:100%;">
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

    const visitors = @json($visitors);
    const PER_PAGE = 7;
    let currentPage = 1;
    let filtered    = [...visitors];

    function fmtDateTime(d) {
        if (!d) return '—';
        const dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
             + ', ' + dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }

    function badge(status) {
        const map = {
            'inside':    `<span class="badge badge-inside">Inside</span>`,
            'approved':  `<span class="badge badge-approved">Approved</span>`,
            'pending':   `<span class="badge badge-pending">Pending</span>`,
            'rejected':  `<span class="badge badge-rejected">Rejected</span>`,
            'completed': `<span class="badge badge-completed">Completed</span>`,
        };
        return map[status] ?? `<span class="badge badge-pending">${status}</span>`;
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('visitor-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="empty-state">No visitor logs found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(v => {
                const canTimein  = !v.arrival_time && v.status !== 'rejected';
                const canTimeout = v.arrival_time && !v.departure_time;
                const canStatus  = v.status === 'pending' || v.status === 'approved';

                return `<tr>
                    <td class="td-name">${v.visitor_name}</td>
                    <td>${fmtDateTime(v.arrival_time)}</td>
                    <td>${v.departure_time ? fmtDateTime(v.departure_time) : '—'}</td>
                    <td>${v.purpose ?? '—'}</td>
                    <td>
                        <div class="td-name">${v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '—'}</div>
                        ${v.tenant && v.tenant.room_number ? `<div class="td-sub">Rm ${v.tenant.room_number}</div>` : ''}
                    </td>
                    <td>
                        <div class="td-name">${v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '—'}</div>
                    </td>
                    <td>${badge(v.status)}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View Details" onclick='viewVisitor(${JSON.stringify(v).replace(/'/g, "&#39;")})'>
                                <img src="{{ asset('icons/eye.png') }}" alt="View">
                            </button>
                            <button class="act-btn green" title="Log Time In" ${!canTimein ? 'disabled' : ''} onclick="openTimein(${v.visitor_id}, '${v.visitor_name}')">
                                <img src="{{ asset('icons/check.png') }}" alt="Time In">
                            </button>
                            <button class="act-btn blue" title="Log Time Out" ${!canTimeout ? 'disabled' : ''} onclick="openTimeout(${v.visitor_id}, '${v.visitor_name}')">
                                <img src="{{ asset('icons/logout.png') }}" alt="Time Out">
                            </button>
                            <button class="act-btn" title="Notify Tenant (coming soon)" onclick="showToast('Notify Tenant feature coming soon.', '')">
                                <img src="{{ asset('icons/bell.png') }}" alt="Notify">
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }

        const total = filtered.length;
        const from  = total === 0 ? 0 : start + 1;
        const to    = Math.min(start + PER_PAGE, total);
        document.getElementById('showing-label').textContent = `Showing data ${from} to ${to} of ${total} entries`;

        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        const pg = document.getElementById('pagination');
        let html = '';
        html += `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>`;
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goPage(${i})">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += `<span class="page-ellipsis">…</span>`;
            }
        }
        html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}>›</button>`;
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

        filtered = visitors.filter(v => {
            const matchQ = !q ||
                (v.visitor_name ?? '').toLowerCase().includes(q) ||
                (v.purpose ?? '').toLowerCase().includes(q) ||
                (v.tenant ? (v.tenant.first_name + ' ' + v.tenant.last_name).toLowerCase().includes(q) : false) ||
                (v.tenant?.room_number ?? '').toLowerCase().includes(q);

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
        if (val === 'newest') filtered.sort((a, b) => new Date(b.arrival_time ?? b.date_of_visit) - new Date(a.arrival_time ?? a.date_of_visit));
        if (val === 'oldest') filtered.sort((a, b) => new Date(a.arrival_time ?? a.date_of_visit) - new Date(b.arrival_time ?? b.date_of_visit));
        if (val === 'name')   filtered.sort((a, b) => (a.visitor_name ?? '').localeCompare(b.visitor_name ?? ''));
        if (val === 'status') filtered.sort((a, b) => (a.status ?? '').localeCompare(b.status ?? ''));
        currentPage = 1;
        renderTable();
    }

    function viewVisitor(v) {
        document.getElementById('view-content').innerHTML = `
            <div class="modal-section-title">Visitor Information</div>
            <div class="view-row"><span class="view-label">Visitor Name</span><span class="view-val">${v.visitor_name}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${v.contact_no ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Purpose</span><span class="view-val">${v.purpose ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">ID Type</span><span class="view-val">${v.id_type ?? '—'}</span></div>
            <div class="modal-section-title">Visit Details</div>
            <div class="view-row"><span class="view-label">Tenant Visited</span><span class="view-val">${v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '—'}</span></div>
            <div class="view-row"><span class="view-label">Room</span><span class="view-val">${v.tenant?.room_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Date of Visit</span><span class="view-val">${v.date_of_visit ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Time In</span><span class="view-val">${fmtDateTime(v.arrival_time)}</span></div>
            <div class="view-row"><span class="view-label">Time Out</span><span class="view-val">${v.departure_time ? fmtDateTime(v.departure_time) : 'Still Inside'}</span></div>
            <div class="view-row"><span class="view-label">Logged By</span><span class="view-val">${v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '—'}</span></div>
            <div class="view-row"><span class="view-label">Status</span><span class="view-val">${badge(v.status)}</span></div>
        `;

        const actions = document.getElementById('view-actions');
        let btns = `<button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>`;

        if (v.status === 'pending') {
            btns += `
                <button class="btn-submit" style="background:var(--red);" onclick="quickStatus(${v.visitor_id}, 'rejected', '${v.visitor_name}')">Reject</button>
                <button class="btn-submit" onclick="quickStatus(${v.visitor_id}, 'approved', '${v.visitor_name}')">Approve</button>
            `;
        }

        actions.innerHTML = btns;
        openModal('view-modal');
    }

    function quickStatus(id, status, name) {
        if (!confirm(`Set status to "${status}" for ${name}?`)) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/visitors/${id}/status`;
        form.innerHTML = `
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="status" value="${status}">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    function openTimein(id, name) {
        document.getElementById('timein-name').textContent  = name;
        document.getElementById('timein-form').action       = `/visitors/timein/${id}`;
        document.getElementById('timein-input').value       = new Date().toISOString().slice(0, 16);
        closeModal('view-modal');
        openModal('timein-modal');
    }

    function openTimeout(id, name) {
        document.getElementById('timeout-name').textContent = name;
        document.getElementById('timeout-form').action      = `/visitors/checkout/${id}`;
        document.getElementById('timeout-input').value      = new Date().toISOString().slice(0, 16);
        closeModal('view-modal');
        openModal('timeout-modal');
    }

    function exportVisitors() {
        const rows = [['Visitor Name', 'Time In', 'Time Out', 'Purpose', 'Tenant', 'Room', 'Logged By', 'Status']];
        visitors.forEach(v => rows.push([
            v.visitor_name,
            v.arrival_time ?? '',
            v.departure_time ?? '',
            v.purpose ?? '',
            v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '',
            v.tenant?.room_number ?? '',
            v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '',
            v.status ?? '',
        ]));
        const csv  = rows.map(r => r.map(c => `"${c}"`).join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'dormease-visitors.csv';
        a.click();
        showToast('Visitors exported as CSV!', 'success');
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast('{{ session("success") }}', 'success'));
    @endif

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('add-modal'));
    @endif

    filtered = [...visitors];
    renderTable();

</script>
@endsection