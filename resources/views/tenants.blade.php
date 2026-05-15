@extends('layout')

@section('title', 'DormEase — Manage Tenants')

@section('page-title', 'Manage Tenants')

@section('styles')
<style>
:root{
    --pink-1: #E8175D;
    --pink-2: #FF2D78;
    --gradient-pink: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
    --soft-bg: #fff7fb;
}

/* ───────── PAGE ───────── */
.page-body {
    padding: 1.8rem 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
    background: var(--soft-bg);
    box-sizing: border-box;
    min-width: 0;
}

/* ───────── HEADER ───────── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--pink-1);
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0;
}

.page-header .dorm-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pink-2);
    margin-top: .2rem;
}

/* ───────── HEADER ACTIONS ───────── */
.header-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
}

/* ───────── BUTTONS ───────── */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: var(--gradient-pink);
    color: #fff;
    border: none;
    font-size: .87rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(232,23,93,.25);
    transition: .2s ease;
    white-space: nowrap;
    text-decoration: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 35px rgba(232,23,93,.35);
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: #fff;
    color: var(--pink-1);
    border: 1.5px solid #ffd3e3;
    font-size: .87rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    white-space: nowrap;
}

.btn-outline:hover {
    border-color: var(--pink-2);
    color: var(--pink-2);
}

/* ───────── STATS ───────── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
}

.stat-box {
    background: var(--gradient-pink);
    border-radius: 18px;
    border: none;
    box-shadow:
        0 8px 18px rgba(0,0,0,.05),
        0 18px 40px rgba(232,23,93,.25);
    padding: 1.4rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    box-sizing: border-box;
    min-width: 0;
    overflow: hidden;
}

.stat-icon-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    flex-shrink: 0;
    background: rgba(255,255,255,.22);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 16px rgba(0,0,0,.15);
}

.stat-icon-circle img {
    width: 28px;
    height: 28px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}

.stat-num {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
}

.stat-label {
    font-size: .8rem;
    color: rgba(255,255,255,.85);
    margin-bottom: .15rem;
}

.stat-sub {
    font-size: .73rem;
    color: rgba(255,255,255,.65);
    font-weight: 600;
    margin-top: .15rem;
}

/* ───────── TABLE CARD ───────── */
.table-card {
    background: #fff;
    border-radius: 18px;
    border: none;
    overflow: hidden;
    box-shadow:
        0 10px 20px rgba(0,0,0,.05),
        0 18px 45px rgba(232,23,93,.15);
    box-sizing: border-box;
}

/* ───────── TABLE HEADER ───────── */
.table-header {
    padding: 1.2rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .8rem;
    background: var(--gradient-pink);
}

.table-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}

.table-date {
    font-size: .78rem;
    color: rgba(255,255,255,.75);
    margin-top: .1rem;
}

/* ───────── TABLE CONTROLS ───────── */
.table-controls {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}

/* ───────── SEARCH ───────── */
.search-wrap {
    position: relative;
}

.search-wrap input {
    padding: .5rem .9rem .5rem 2.1rem;
    border-radius: 10px;
    border: none;
    font-size: .85rem;
    width: 200px;
    outline: none;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    color: #333;
}

.search-wrap::before {
    content: '🔍';
    position: absolute;
    left: .6rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: .8rem;
    pointer-events: none;
}

/* ───────── SORT SELECT ───────── */
.sort-select {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: none;
    font-size: .82rem;
    font-weight: 600;
    background: #fff;
    color: var(--pink-1);
    cursor: pointer;
    outline: none;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23E8175D' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .7rem center;
    padding-right: 2rem;
}

.sort-select:focus {
    box-shadow: 0 0 0 2px rgba(232,23,93,.25);
}

/* ───────── TABLE ───────── */
.table-wrap { overflow-x: auto; }

table {
    width: 100%;
    border-collapse: collapse;
}

thead tr {
    background: #ffe3ef;
}

th {
    padding: .75rem 1rem;
    font-size: .75rem;
    font-weight: 700;
    color: var(--pink-1);
    text-transform: uppercase;
    white-space: nowrap;
}

td {
    padding: .85rem 1rem;
    font-size: .875rem;
    border-bottom: 1px solid #ffe0eb;
    color: #7a2d4f;
}

tbody tr:hover {
    background: var(--soft-bg);
}

/* ───────── BADGES ───────── */
.badge {
    display: inline-flex;
    align-items: center;
    padding: .28rem .75rem;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 700;
}

.badge-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-pending  { background: #fff9e6; color: #c8960c; border: 1px solid #f0c040; }
.badge-inactive { background: #fff0f0; color: #e04867; border: 1px solid #ffb3c1; }
.badge-moveout  { background: #ffe3ef; color: var(--pink-1); border: 1px solid #ff9db0; }

/* ───────── ACTION BUTTONS ───────── */
.action-group {
    display: flex;
    align-items: center;
    gap: .4rem;
}

.act-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid #ffd3e3;
    background: #fff;
    cursor: pointer;
    transition: .2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
}

.act-btn:hover {
    border-color: var(--pink-2);
    box-shadow: 0 6px 14px rgba(232,23,93,.15);
}

/* ───────── TABLE FOOTER ───────── */
.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .9rem 1.2rem;
    flex-wrap: wrap;
    gap: .5rem;
    border-top: 1px solid #ffe0eb;
}

.table-showing {
    font-size: .8rem;
    color: #b06080;
}

.pagination {
    display: flex;
    align-items: center;
    gap: .3rem;
}

.page-btn {
    min-width: 32px;
    height: 32px;
    padding: 0 .5rem;
    border-radius: 8px;
    border: 1.5px solid #ffd3e3;
    background: #fff;
    color: var(--pink-1);
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.page-btn:hover:not(:disabled) {
    background: var(--gradient-pink);
    color: #fff;
    border-color: transparent;
}

.page-btn.active {
    background: var(--gradient-pink);
    color: #fff;
    border-color: transparent;
}

.page-btn:disabled {
    opacity: .4;
    cursor: default;
}

.page-ellipsis {
    color: #b06080;
    font-size: .85rem;
    padding: 0 .2rem;
}

.empty-state {
    text-align: center;
    color: #b06080;
    padding: 2rem 1rem;
    font-size: .9rem;
}

/* ───────── MODAL ───────── */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.35);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 300;
}

.modal-overlay.open { display: flex; }

.modal {
    background: #fff;
    border-radius: 22px;
    padding: 2rem;
    width: 90%;
    max-width: 480px;
    box-shadow:
        0 15px 40px rgba(0,0,0,.12),
        0 25px 70px rgba(232,23,93,.2);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.2rem;
}

.modal-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--pink-1);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1rem;
    color: #b06080;
    cursor: pointer;
    padding: .2rem .4rem;
    border-radius: 6px;
    transition: .2s;
}

.modal-close:hover { background: #ffe3ef; color: var(--pink-1); }

.modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .9rem;
    margin-bottom: 1.2rem;
}

.modal-field {
    display: flex;
    flex-direction: column;
    gap: .35rem;
}

.modal-field label {
    font-size: .78rem;
    font-weight: 700;
    color: var(--pink-1);
    text-transform: uppercase;
    letter-spacing: .03em;
}

.modal-field input,
.modal-field select {
    width: 100%;
    padding: .65rem .9rem;
    border-radius: 10px;
    border: 1.5px solid #ffd3e3;
    background: #fffafd;
    font-size: .875rem;
    color: #5a1e38;
    outline: none;
    box-sizing: border-box;
    transition: border-color .2s;
}

.modal-field input:focus,
.modal-field select:focus {
    border-color: var(--pink-2);
}

.modal-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .75rem;
}

.btn-cancel {
    padding: .6rem 1.2rem;
    border-radius: 10px;
    background: #fff;
    border: 1.5px solid #ffd3e3;
    color: #b06080;
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.btn-cancel:hover { border-color: var(--pink-2); color: var(--pink-1); }

.btn-submit {
    padding: .6rem 1.4rem;
    border-radius: 10px;
    background: var(--gradient-pink);
    border: none;
    color: #fff;
    font-size: .875rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(232,23,93,.25);
    transition: .2s;
}

.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 12px 28px rgba(232,23,93,.35); }

.delete-warning {
    background: #fff0f0;
    border: 1px solid #ffb3c1;
    border-radius: 10px;
    padding: .75rem 1rem;
    font-size: .85rem;
    color: #e04867;
    margin-bottom: 1rem;
}

.view-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .6rem 0;
    border-bottom: 1px solid #ffe0eb;
}

.view-row:last-child { border-bottom: none; }

.view-label {
    font-size: .78rem;
    font-weight: 700;
    color: var(--pink-1);
    text-transform: uppercase;
    letter-spacing: .03em;
}

.view-val {
    font-size: .875rem;
    color: #5a1e38;
    font-weight: 500;
}

/* ───────── ANIMATION ───────── */
.fade-up { animation: fadeIn .45s ease both; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

.d1 { animation-delay: .05s; }
.d2 { animation-delay: .12s; }
.d3 { animation-delay: .2s; }

/* ───────── RESPONSIVE ───────── */
@media (max-width: 900px) {
    .stats-row { grid-template-columns: 1fr; }
    .modal-grid { grid-template-columns: 1fr; }
    .page-body { padding: 1.2rem 1rem; }
}

@media (max-width: 600px) {
    .table-card { margin: 0; }
    .search-wrap input { width: 140px; }
}
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div>
            <h1>Manage Tenants</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openModal('add-modal')">＋ Add Tenant</button>
            <button class="btn-outline" onclick="exportTenants()">⬇ Export</button>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt="tenants">
            </div>
            <div>
                <div class="stat-label">Total Tenants</div>
                <div class="stat-num">{{ $totalTenants }}</div>
                <div class="stat-sub">Currently Registered</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" class="icon-md" alt="units">
            </div>
            <div>
                <div class="stat-label">Units Occupied</div>
                <div class="stat-num">{{ $occupiedUnits }}</div>
                <div class="stat-sub">Out of {{ $totalUnits }} available</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/pending.png') }}" class="icon-md" alt="pending">
            </div>
            <div>
                <div class="stat-label">Pending Tenants</div>
                <div class="stat-num">{{ $pendingCount }}</div>
                <div class="stat-sub">Payment Pending</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div>
                <div class="table-title">All Tenants</div>
                <div class="table-date">as of {{ now()->format('F d, Y') }}</div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Search..." oninput="filterTable()">
                </div>
                <select class="sort-select" id="sort-select" onchange="sortTable()">
                    <option value="newest">Sort by: Newest</option>
                    <option value="oldest">Sort by: Oldest</option>
                    <option value="name">Sort by: Name</option>
                    <option value="room">Sort by: Room</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Tenant Name</th>
                        <th>Room No.</th>
                        <th>Move-In Date</th>
                        <th>Pending Bill</th>
                        <th>Contact No.</th>
                        <th>Status</th>
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

<div class="modal-overlay" id="add-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Add New Tenant</div>
            <button class="modal-close" onclick="closeModal('add-modal')">✕</button>
        </div>
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf
            <div class="modal-grid">
                <div class="modal-field">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="e.g. Maria" required>
                </div>
                <div class="modal-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="e.g. Ramos" required>
                </div>
                <div class="modal-field">
                    <label>Room No.</label>
                    <input type="text" name="room_number" placeholder="e.g. 304" required>
                </div>
                <div class="modal-field">
                    <label>Move-In Date</label>
                    <input type="date" name="move_in_date">
                </div>
                <div class="modal-field">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" placeholder="e.g. 0912-345-6789">
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                        <option value="move_out">Move-Out</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Add Tenant</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">👤 Tenant Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" id="view-edit-btn">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">✏️ Edit Tenant</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
        </div>
        <form method="POST" id="edit-form">
            @csrf
            @method('PUT')
            <div class="modal-grid">
                <div class="modal-field">
                    <label>First Name</label>
                    <input type="text" name="first_name" id="edit-first-name" required>
                </div>
                <div class="modal-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" id="edit-last-name" required>
                </div>
                <div class="modal-field">
                    <label>Room No.</label>
                    <input type="text" name="room_number" id="edit-room">
                </div>
                <div class="modal-field">
                    <label>Move-In Date</label>
                    <input type="date" name="move_in_date" id="edit-date">
                </div>
                <div class="modal-field">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" id="edit-contact">
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status" id="edit-status">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                        <option value="move_out">Move-Out</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">🗑 Delete Tenant</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <div class="delete-warning">⚠️ This action cannot be undone. The tenant record will be permanently removed.</div>
        <p style="font-size:.9rem;color:#b06080;">Are you sure you want to delete <strong id="delete-name" style="color:#5a1e38;"></strong>?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <form method="POST" id="delete-form" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-submit" style="background:#e04867;box-shadow:0 8px 20px rgba(224,72,103,.3);">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const tenants = @json($tenants);

    const PER_PAGE = 8;
    let currentPage = 1;
    let filtered = [...tenants];

    function badge(status) {
        const map = {
            active:   ['badge-active',   'Active'],
            pending:  ['badge-pending',  'Pending'],
            inactive: ['badge-inactive', 'Inactive'],
            move_out: ['badge-moveout',  'Move-Out'],
        };
        const [cls, label] = map[status] ?? ['badge-pending', status];
        return `<span class="badge ${cls}">${label}</span>`;
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month:'short', day:'numeric', year:'numeric' });
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('tenant-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="empty-state">No tenants found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(t => `
                <tr>
                    <td class="td-id">TNT-${String(t.tenant_id).padStart(4,'0')}</td>
                    <td class="td-name">${t.first_name} ${t.last_name}</td>
                    <td>${t.room_number ?? '—'}</td>
                    <td>${fmtDate(t.move_in_date)}</td>
                    <td>${t.pending_bill > 0 ? '₱' + parseFloat(t.pending_bill).toFixed(2) : '—'}</td>
                    <td>${t.contact_number ?? '—'}</td>
                    <td>${badge(t.status)}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View"   onclick='viewTenant(${JSON.stringify(t)})'>👁</button>
                            <button class="act-btn" title="Edit"   onclick='openEditModal(${JSON.stringify(t)})'>✏️</button>
                            <button class="act-btn delete" title="Delete" onclick='openDeleteModal(${t.tenant_id}, "${t.first_name} ${t.last_name}")'>🗑</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        const total = filtered.length;
        const from  = total === 0 ? 0 : start + 1;
        const to    = Math.min(start + PER_PAGE, total);
        document.getElementById('showing-label').textContent = `Showing ${from} to ${to} of ${total} entries`;
        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        const pg = document.getElementById('pagination');
        let html = `<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>‹</button>`;
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage-1 && i <= currentPage+1)) {
                html += `<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
            } else if (i === currentPage-2 || i === currentPage+2) {
                html += `<span class="page-ellipsis">…</span>`;
            }
        }
        html += `<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===totalPages||totalPages===0?'disabled':''}>›</button>`;
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
        filtered = tenants.filter(t =>
            (t.first_name + ' ' + t.last_name).toLowerCase().includes(q) ||
            String(t.tenant_id).includes(q) ||
            (t.room_number ?? '').toLowerCase().includes(q) ||
            (t.contact_number ?? '').toLowerCase().includes(q) ||
            (t.status ?? '').toLowerCase().includes(q)
        );
        currentPage = 1;
        renderTable();
    }

    function sortTable() {
        const val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort((a,b) => new Date(b.move_in_date) - new Date(a.move_in_date));
        if (val === 'oldest') filtered.sort((a,b) => new Date(a.move_in_date) - new Date(b.move_in_date));
        if (val === 'name')   filtered.sort((a,b) => a.first_name.localeCompare(b.first_name));
        if (val === 'room')   filtered.sort((a,b) => (a.room_number ?? '').localeCompare(b.room_number ?? ''));
        currentPage = 1;
        renderTable();
    }

    function viewTenant(t) {
        document.getElementById('view-content').innerHTML = `
            <div class="view-row"><span class="view-label">Account ID</span><span class="view-val">TNT-${String(t.tenant_id).padStart(4,'0')}</span></div>
            <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${t.first_name} ${t.last_name}</span></div>
            <div class="view-row"><span class="view-label">Room No.</span><span class="view-val">${t.room_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">${fmtDate(t.move_in_date)}</span></div>
            <div class="view-row"><span class="view-label">Pending Bill</span><span class="view-val">₱${parseFloat(t.pending_bill ?? 0).toFixed(2)}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Status</span><span class="view-val">${badge(t.status)}</span></div>
        `;
        document.getElementById('view-edit-btn').onclick = () => { closeModal('view-modal'); openEditModal(t); };
        openModal('view-modal');
    }

    function openEditModal(t) {
        document.getElementById('edit-form').action = `/tenants/${t.tenant_id}`;
        document.getElementById('edit-first-name').value = t.first_name;
        document.getElementById('edit-last-name').value  = t.last_name;
        document.getElementById('edit-room').value       = t.room_number ?? '';
        document.getElementById('edit-date').value       = t.move_in_date ?? '';
        document.getElementById('edit-contact').value    = t.contact_number ?? '';
        document.getElementById('edit-status').value     = t.status ?? 'active';
        openModal('edit-modal');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = `/tenants/${id}`;
        openModal('delete-modal');
    }

    function exportTenants() {
        const rows = [['Account ID','First Name','Last Name','Room No.','Move-In Date','Pending Bill','Contact No.','Status']];
        tenants.forEach(t => rows.push([
            'TNT-' + String(t.tenant_id).padStart(4,'0'),
            t.first_name, t.last_name,
            t.room_number ?? '',
            t.move_in_date ?? '',
            parseFloat(t.pending_bill ?? 0).toFixed(2),
            t.contact_number ?? '',
            t.status
        ]));
        const csv  = rows.map(r => r.join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'dormease-tenants.csv';
        a.click();
        showToast('📥 Tenants exported as CSV!', 'success');
    }

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    renderTable();
</script>
@endsection