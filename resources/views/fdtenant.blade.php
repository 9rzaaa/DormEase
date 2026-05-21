@extends('fdlayout')

@section('title', 'DormEase: Tenant Directory')
@section('page-title', 'Tenant Directory')

@section('styles')
<style>
    .dorm-name { font-size: 1rem; font-weight: 600; color: var(--bright-pink); margin-top: .2rem; }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
    .stat-box {
        border-radius: 14px; padding: 1.1rem;
        border: none;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(232,23,93,.25); }
    .stat-icon-circle {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .8rem;
    }
    .stat-icon-circle img {
        width: 22px; height: 22px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .stat-num   { font-size: 1.9rem; font-weight: 800; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; font-weight: 700; color: rgba(255,255,255,.92); margin-top: .3rem; }
    .stat-sub   { font-size: .75rem; color: rgba(255,255,255,.72); margin-top: .15rem; }

    .table-card { background: var(--white); border-radius: 16px; border: 1.5px solid var(--bright-pink); box-shadow: var(--shadow); overflow: hidden; }
    .table-header {
        padding: 1.3rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1.5px solid var(--pink-light); flex-wrap: wrap; gap: .8rem;
    }
    .table-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .table-date  { font-size: .78rem; color: var(--bright-pink); font-weight: 600; margin-top: .15rem; }
    .table-controls { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }

    .search-wrap { position: relative; }
    .search-wrap input {
        padding: .5rem .9rem .5rem 2.2rem;
        border-radius: 9px; border: 1.5px solid var(--pink-light);
        font-family: var(--ff-body); font-size: .85rem; color: var(--ink);
        background: var(--pink-bg); outline: none; width: 200px;
        transition: border-color .2s, width .3s;
    }
    .search-wrap input:focus { border-color: var(--bright-pink); width: 240px; }
    .search-icon { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); pointer-events: none; display: flex; align-items: center; }
    .search-icon img { width: 14px; height: 14px; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }

    .sort-select {
        padding: .5rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
        outline: none; cursor: pointer;
    }
    .sort-select:focus { border-color: var(--bright-pink); }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--pink-bg); }
    th {
        padding: .75rem 1rem; text-align: left;
        font-size: .75rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
    }
    td { padding: .85rem 1rem; font-size: .875rem; color: var(--ink); border-bottom: 1px solid var(--border); vertical-align: middle; }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: var(--pink-bg); }
    tbody tr:last-child td { border-bottom: none; }
    .td-name { font-weight: 600; }
    .td-muted { color: var(--ink-muted); font-size: .85rem; }

    .action-group { display: flex; align-items: center; gap: .5rem; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn img { width: 15px; height: 15px; opacity: .6; }
    .act-btn:hover { border-color: var(--bright-pink); background: var(--pink-bg); }
    .act-btn:hover img { opacity: 1; }

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

    .tenant-avatar {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        display: flex; align-items: center; justify-content: center;
        font-size: .82rem; font-weight: 700; color: var(--white);
    }
    .name-cell { display: flex; align-items: center; gap: .75rem; }

    @media(max-width:900px) {
        .stats-row { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; gap: 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div>
            <h1>Tenant Directory</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-outline" onclick="exportTenants()">
                <img src="{{ asset('icons/export.png') }}" alt=""> Export
            </button>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" alt="">
            </div>
            <div class="stat-label">Total Tenants</div>
            <div class="stat-num">{{ $totalTenants }}</div>
            <div class="stat-sub">Currently Registered</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" alt="">
            </div>
            <div class="stat-label">Units Occupied</div>
            <div class="stat-num">{{ $occupiedUnits }}</div>
            <div class="stat-sub">Out of {{ $totalUnits }} available</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" alt="">
            </div>
            <div class="stat-label">Vacant Units</div>
            <div class="stat-num">{{ $vacantUnits }}</div>
            <div class="stat-sub">Out of {{ $totalUnits }} units</div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div>
                <div class="table-title">All Tenants</div>
                <div class="table-date" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <span class="search-icon">
                    <img src="{{ asset('icons/search.png') }}" alt="">
            </span>
                <input type="text" id="search-input" placeholder="Search..." oninput="filterTable()">
        </div>
            <select class="sort-select" id="sort-select" onchange="sortTable()">
            <option value="newest">Sort by: Newest</option>
            <option value="oldest">Sort by: Oldest</option>
            <option value="name">Sort by: Name</option>
            <option value="floor">Sort by: Floor</option>
            <option value="room">Sort by: Room</option>
    </select>
    <select class="sort-select" id="floor-filter" onchange="filterTable()">
        <option value="">All Floors</option>
        <option value="2">Floor 2</option>
        <option value="3">Floor 3</option>
        <option value="4">Floor 4</option>
        <option value="5">Floor 5</option>
    </select>
</div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Floor No.</th>
                        <th>Room No.</th>
                        <th>Contact No.</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tenant-tbody"></tbody>
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

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/tenants.png') }}" alt=""> Tenant Details
            </div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="notes-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/edit.png') }}" alt=""> Add Note
            </div>
            <button class="modal-close" onclick="closeModal('notes-modal')">✕</button>
        </div>
        <p style="font-size:.85rem;color:var(--ink-muted);margin-bottom:1rem;">
            Adding note for <strong id="notes-tenant-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="notes-form">
            @csrf
            @method('PATCH')
            <div class="modal-field">
                <label>Note</label>
                <textarea name="notes" id="notes-input" placeholder="e.g. Expecting visitor this weekend..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('notes-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Note</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const tenants = @json($tenants);

    const PER_PAGE  = 8;
    let currentPage = 1;
    let filtered    = [...tenants];

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    function initials(first, last) {
        return ((first?.[0] ?? '') + (last?.[0] ?? '')).toUpperCase();
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('tenant-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:2.5rem;color:var(--ink-muted);">No tenants found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(t => `
                <tr>
                    <td>
                        <div class="name-cell">
                            <div class="tenant-avatar">${initials(t.first_name, t.last_name)}</div>
                            <span class="td-name">${t.first_name} ${t.last_name}</span>
                        </div>
                    </td>
                    <td>${t.floor ? 'Floor ' + t.floor : '—'}</td>
                    <td>${t.room_number ?? '—'}</td>
                    <td>${t.contact_number ?? '—'}</td>
                    <td class="td-muted">${t.notes ?? '---'}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewTenant(${JSON.stringify(t)})'>
                                <img src="{{ asset('icons/bell.png') }}" alt="Notify">
                            </button>
                            <button class="act-btn" title="View Profile" onclick='viewTenant(${JSON.stringify(t)})'>
                                <img src="{{ asset('icons/eye.png') }}" alt="View">
                            </button>
                            <button class="act-btn" title="Add Note" onclick='openNotesModal(${t.tenant_id}, "${t.first_name} ${t.last_name}", "${t.notes ?? ''}")'>
                                <img src="{{ asset('icons/edit.png') }}" alt="Note">
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        const total = filtered.length;
        const from  = total === 0 ? 0 : start + 1;
        const to    = Math.min(start + PER_PAGE, total);
        document.getElementById('showing-label').textContent =
            `Showing data ${from} to ${to} of ${total} entries`;

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
                html += `<span style="color:var(--ink-muted);padding:0 .2rem">…</span>`;
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
    const q = document.getElementById('search-input').value.toLowerCase();
    const floorVal = document.getElementById('floor-filter').value;

    filtered = tenants.filter(t => {
        const matchesSearch =
            (t.first_name + ' ' + t.last_name).toLowerCase().includes(q) ||
            (t.room_number    ?? '').toLowerCase().includes(q) ||
            (t.contact_number ?? '').toLowerCase().includes(q) ||
            String(t.floor ?? '').includes(q);

        const matchesFloor = floorVal === '' || String(t.floor) === floorVal;

        return matchesSearch && matchesFloor;
    });

    currentPage = 1;
    renderTable();
}

    function sortTable() {
        const val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort((a, b) => new Date(b.move_in_date) - new Date(a.move_in_date));
        if (val === 'oldest') filtered.sort((a, b) => new Date(a.move_in_date) - new Date(b.move_in_date));
        if (val === 'name')   filtered.sort((a, b) => a.first_name.localeCompare(b.first_name));
        if (val === 'floor')  filtered.sort((a, b) => (a.floor ?? 0) - (b.floor ?? 0));
        if (val === 'room')   filtered.sort((a, b) => (a.room_number ?? '').localeCompare(b.room_number ?? ''));
        currentPage = 1;
        renderTable();
    }

    function viewTenant(t) {
        document.getElementById('view-content').innerHTML = `
            <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${t.first_name} ${t.last_name}</span></div>
            <div class="view-row"><span class="view-label">Email</span><span class="view-val">${t.email ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Room No.</span><span class="view-val">${t.room_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Floor</span><span class="view-val">${t.floor ? 'Floor ' + t.floor : '—'}</span></div>
            <div class="view-row"><span class="view-label">Stay Type</span><span class="view-val">${t.stay_type ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">${fmtDate(t.move_in_date)}</span></div>
            <div class="view-row"><span class="view-label">Notes</span><span class="view-val">${t.notes ?? '—'}</span></div>
        `;
        openModal('view-modal');
    }

    function openNotesModal(id, name, currentNote) {
        document.getElementById('notes-tenant-name').textContent = name;
        document.getElementById('notes-input').value = currentNote;
        document.getElementById('notes-form').action = `/tenants/${id}/notes`;
        openModal('notes-modal');
    }

    function exportTenants() {
        const rows = [['Tenant Name', 'Floor No.', 'Room No.', 'Contact No.', 'Notes']];
        tenants.forEach(t => rows.push([
            `${t.first_name} ${t.last_name}`,
            t.floor ?? '',
            t.room_number ?? '',
            t.contact_number ?? '',
            t.notes ?? '',
        ]));
        const csv  = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'tenant-directory.csv';
        a.click();
        showToast('Tenants exported as CSV!', 'success');
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    renderTable();
</script>
@endsection