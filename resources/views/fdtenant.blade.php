@extends('fdlayout')

@section('title', 'DormEase: Tenant Directory')
@section('page-title', 'Tenant Directory')

@section('styles')
<style>
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
    color: var(--black);
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0;
}

.dorm-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bright-pink);
    margin-top: .2rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: var(--white);
    color: var(--hot-pink);
    border: 1.5px solid var(--pink-100);
    font-size: .87rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    white-space: nowrap;
}

.btn-outline:hover {
    border-color: var(--bright-pink);
    color: var(--bright-pink);
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
}

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

.table-card {
    background: var(--white);
    border-radius: 18px;
    border: 2px solid var(--bright-pink);
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,.05), 0 18px 45px rgba(232,23,93,.15);
    box-sizing: border-box;
}

.table-header {
    padding: 1.2rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .8rem;
    background: var(--white);
    border-bottom: 2px solid var(--bright-pink);
}

.table-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0; }
.table-date  { font-size: .78rem; color: var(--bright-pink); margin-top: .1rem; }

.table-controls {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    display: flex;
}

.search-wrap input {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    font-size: .85rem;
    width: 150px;
    outline: none;
    background: var(--white);
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    color: var(--ink);
}

.sort-select {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    font-size: .82rem;
    font-weight: 400;
    background: var(--white);
    color: var(--ink-muted);
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

.sort-select:focus { box-shadow: 0 0 0 2px rgba(232,23,93,.25); }

.table-wrap { overflow-x: auto; background: var(--white); }

table { width: 100%; border-collapse: collapse; background: var(--white); }

thead tr {
    background: var(--white);
    border-bottom: 2px solid var(--bright-pink);
}

th {
    padding: .75rem 1rem;
    font-size: .75rem;
    font-weight: 600;
    color: var(--bright-pink);
    letter-spacing: .04em;
    text-transform: uppercase;
    white-space: nowrap;
    background: var(--white);
}

td {
    padding: .85rem 1rem;
    font-size: .875rem;
    border-bottom: 1px solid var(--pink-100);
    color: var(--ink);
}

tbody tr:hover { background: var(--soft-bg); }

table th, table td { text-align: center; vertical-align: middle; }
.td-name { text-align: left; }

.name-cell {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: .75rem;
}

.tenant-avatar {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
    display: flex; align-items: center; justify-content: center;
    font-size: .78rem; font-weight: 700; color: var(--white);
}

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
.badge-inactive { background: #fff0f0; color: #e04867; border: 1px solid var(--pink-200); }
.badge-moveout  { background: var(--petal); color: var(--hot-pink); border: 1px solid #ff9db0; }

.action-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
}

.act-btn {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid var(--pink-100); background: var(--white);
    cursor: pointer; transition: .2s;
    display: inline-flex; align-items: center; justify-content: center;
}

.act-btn:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 6px 14px rgba(232,23,93,.15);
}

.act-btn img { width: 15px; height: 15px; object-fit: contain; }

.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .9rem 1.2rem;
    flex-wrap: wrap;
    gap: .5rem;
    border-top: 1px solid var(--pink-100);
}

.table-showing { font-size: .8rem; color: #b06080; }

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
    border: 1.5px solid var(--pink-100);
    background: var(--white);
    color: var(--hot-pink);
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-btn:hover:not(:disabled) {
    background: var(--gradient-pink);
    color: var(--white);
    border-color: transparent;
}

.page-btn.active {
    background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
    color: var(--white);
    border-color: transparent;
}

.page-btn:disabled { opacity: .4; cursor: default; }

.empty-state { text-align: center; color: #b06080; padding: 2rem 1rem; font-size: .9rem; }

.view-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .6rem 0;
    border-bottom: 1px solid var(--pink-100);
}
.view-row:last-child { border-bottom: none; }
.view-label {
    font-size: .78rem; font-weight: 700; color: var(--hot-pink);
    text-transform: uppercase; letter-spacing: .03em;
}
.view-val { font-size: .875rem; color: #5a1e38; font-weight: 500; }

.fade-up { animation: fadeIn .45s ease both; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.d1 { animation-delay: .05s; }
.d2 { animation-delay: .12s; }
.d3 { animation-delay: .2s; }

.tenant-archive-drawer {
    position: fixed;
    top: 0; right: 0; bottom: 0;
    width: min(660px, 100vw);
    background: var(--blush);
    z-index: 500;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    box-shadow: -8px 0 40px rgba(214,51,117,.15);
}

.tenant-archive-drawer.open { transform: translateX(0); }

.tenant-archive-backdrop {
    position: fixed; inset: 0;
    background: rgba(232,23,93,.18);
    backdrop-filter: blur(3px);
    z-index: 499;
    opacity: 0; pointer-events: none;
    transition: opacity .38s ease;
}

.tenant-archive-backdrop.open { opacity: 1; pointer-events: auto; }

.tad-header {
    padding: 1.6rem 1.8rem 1.2rem;
    border-bottom: 1px solid var(--pink-100);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}

.tad-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -.02em;
    line-height: 1.2;
}

.tad-sub {
    font-size: .78rem;
    color: var(--ink-muted);
    margin-top: .25rem;
    font-weight: 500;
}

.tad-close {
    width: 34px; height: 34px;
    border-radius: 8px;
    border: 1px solid var(--pink-100);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: 1rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s, color .2s;
    flex-shrink: 0;
}

.tad-close:hover { background: var(--pink-100); color: var(--hot-pink); }

.tad-search-bar {
    padding: 1rem 1.8rem .8rem;
    flex-shrink: 0;
}

.tad-search-inner {
    position: relative;
    display: flex;
    align-items: center;
}

.tad-search-inner input {
    width: 100%;
    padding: .55rem .9rem .55rem 2.2rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    background: var(--white);
    color: var(--ink);
    font-size: .83rem;
    font-family: var(--ff-body);
    outline: none;
    transition: border-color .2s, background .2s;
    box-sizing: border-box;
}

.tad-search-inner input::placeholder { color: var(--ink-muted); }
.tad-search-inner input:focus { border-color: var(--bright-pink); background: var(--blush); }

.tad-search-icon {
    position: absolute; left: .75rem;
    width: 13px; height: 13px;
    opacity: .5; pointer-events: none;
}

.tad-list {
    flex: 1;
    overflow-y: auto;
    padding: 0 1.8rem 1.8rem;
    display: flex;
    flex-direction: column;
    gap: .75rem;
}

.tad-list::-webkit-scrollbar { width: 4px; }
.tad-list::-webkit-scrollbar-track { background: transparent; }
.tad-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

.tad-card {
    background: var(--white);
    border: 1px solid var(--pink-100);
    border-radius: 14px;
    padding: 1rem 1.1rem;
    transition: background .2s, border-color .2s;
    animation: tadSlideIn .3s ease both;
}

@keyframes tadSlideIn {
    from { opacity: 0; transform: translateX(12px); }
    to   { opacity: 1; transform: translateX(0); }
}

.tad-card:hover { background: var(--blush); border-color: var(--bright-pink); }

.tad-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .8rem;
    margin-bottom: .5rem;
}

.tad-card-id {
    font-size: .75rem;
    font-weight: 800;
    color: var(--bright-pink);
    letter-spacing: .02em;
    font-family: monospace;
}

.tad-card-time {
    font-size: .7rem;
    color: var(--ink-muted);
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
}

.tad-card-name {
    font-size: .9rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.3;
}

.tad-card-email {
    font-size: .73rem;
    color: var(--ink-muted);
    margin-top: .1rem;
}

.tad-card-meta {
    display: flex;
    align-items: center;
    gap: .45rem;
    margin-top: .6rem;
    flex-wrap: wrap;
}

.tad-pill {
    font-size: .68rem;
    font-weight: 700;
    padding: .18rem .55rem;
    border-radius: 99px;
    letter-spacing: .03em;
    text-transform: uppercase;
}

.tad-pill-room    { background: var(--petal);   color: var(--ink-muted); border: 1px solid var(--pink-100); }
.tad-pill-stay    { background: var(--pink-100); color: var(--hot-pink);  border: 1px solid var(--pink-200); }
.tad-pill-active  { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.tad-pill-pending { background: #fff9e6; color: #c8960c; border: 1px solid #f0c040; }
.tad-pill-moveout { background: var(--petal);  color: var(--hot-pink);  border: 1px solid var(--pink-200); }
.tad-pill-inactive{ background: var(--blush);  color: var(--ink-muted); border: 1px solid var(--pink-100); }

.tad-card-archived {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-top: .75rem;
    padding-top: .6rem;
    border-top: 1px solid var(--pink-100);
    font-size: .7rem;
    color: var(--ink-muted);
    font-weight: 500;
}

.tad-card-archived span { color: var(--bright-pink); font-weight: 600; }

.tad-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--ink-muted);
    font-size: .85rem;
}

.tad-empty-icon {
    width: 40px; height: 40px;
    margin: 0 auto .75rem;
    opacity: .3;
    display: block;
}

.tad-footer {
    padding: .9rem 1.8rem;
    border-top: 1px solid var(--pink-100);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    flex-wrap: wrap;
    gap: .5rem;
}

.tad-count-label {
    font-size: .75rem;
    color: var(--ink-muted);
    font-weight: 600;
}

.tad-export-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .75rem;
    font-weight: 700;
    color: var(--bright-pink);
    background: var(--petal);
    border: 1px solid var(--pink-100);
    border-radius: 8px;
    padding: .35rem .85rem;
    cursor: pointer;
    transition: background .2s, color .2s, border-color .2s;
    font-family: var(--ff-body);
}

.tad-export-btn:hover { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.tad-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .7; }

@media (max-width: 900px) {
    .stats-row { grid-template-columns: 1fr; }
    .page-body { padding: 1.2rem 1rem; }
}

@media (max-width: 700px) {
    .tad-header { padding: 1.2rem 1rem .9rem; }
    .tad-list { padding: 0 1rem 1.2rem; }
    .tad-search-bar { padding: .8rem 1rem .6rem; }
    .tad-footer { padding: .75rem 1rem; }
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
            <h1>Tenant Directory</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-outline" onclick="openTenantArchive()">
                <img src="{{ asset('icons/archive.png') }}" class="icon-sm" alt="Archive">
                Archive / History
            </button>
            <button class="btn-outline" onclick="exportTenants()">
                <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                Export
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
                    <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
                </div>
                <select class="sort-select" id="sort-select" onchange="applyFilters()">
                    <option value="newest">Sort by: Newest</option>
                    <option value="oldest">Sort by: Oldest</option>
                    <option value="floor">Sort by: Floor</option>
                    <option value="name">Sort by: Name</option>
                    <option value="room">Sort by: Room</option>
                </select>
                <select class="sort-select" id="floor-filter" onchange="applyFilters()">
                    <option value="">All Floors</option>
                    @for($i = 2; $i <= 5; $i++)
                        <option value="{{ $i }}">Floor {{ $i }}</option>
                    @endfor
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
                        <th>Status</th>
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

<div class="tenant-archive-backdrop" id="tad-backdrop" onclick="closeTenantArchive()"></div>

<div class="tenant-archive-drawer" id="tad-drawer">
    <div class="tad-header">
        <div>
            <div class="tad-title">Archive / History</div>
            <div class="tad-sub">Read-only record of deleted tenant accounts</div>
        </div>
        <button class="tad-close" onclick="closeTenantArchive()">&#x2715;</button>
    </div>

    <div class="tad-search-bar">
        <div class="tad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="tad-search-icon" alt="">
            <input type="text" id="tad-search" placeholder="Search archived tenants..." oninput="renderTenantArchive()">
        </div>
    </div>

    <div class="tad-list" id="tad-list"></div>

    <div class="tad-footer">
        <div class="tad-count-label" id="tad-count-label">0 records</div>
        <button class="tad-export-btn" onclick="exportTenantArchive()">
            <img src="{{ asset('icons/export.png') }}" alt="">
            Export CSV
        </button>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Tenant Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="notes-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">Add / Edit Note</div>
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
    const deletedTenantArchive = @json($deletedArchive);

    const PER_PAGE   = 8;
    let currentPage  = 1;
    let filtered     = [...tenants];

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    function initials(first, last) {
        return ((first?.[0] ?? '') + (last?.[0] ?? '')).toUpperCase();
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
        const dt   = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date} ${time}`;
    }

    function statusBadge(status) {
        const map = {
            active:   '<span class="badge badge-active">Active</span>',
            pending:  '<span class="badge badge-pending">Pending</span>',
            move_out: '<span class="badge badge-moveout">Move Out</span>',
            inactive: '<span class="badge badge-inactive">Inactive</span>',
        };
        return map[status] ?? `<span class="badge badge-inactive">${status}</span>`;
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('tenant-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(t => `
                <tr>
                    <td class="td-name">
                        <div class="name-cell">
                            <div class="tenant-avatar">${initials(t.first_name, t.last_name)}</div>
                            <span style="font-weight:600;">${t.first_name} ${t.last_name}</span>
                        </div>
                    </td>
                    <td>${t.floor ? 'Floor ' + t.floor : '—'}</td>
                    <td>${t.room_number ?? '—'}</td>
                    <td>${t.contact_number ?? '—'}</td>
                    <td>${statusBadge(t.status)}</td>
                    <td style="color:var(--ink-muted);font-size:.85rem;">${t.notes ?? '—'}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View Details"
                                onclick='viewTenant(${JSON.stringify(t)})'>
                                <img src="{{ asset('icons/eye.png') }}" alt="View">
                            </button>
                            <button class="act-btn" title="Add / Edit Note"
                                onclick='openNotesModal(${t.tenant_id}, "${t.first_name} ${t.last_name}", \`${(t.notes ?? '').replace(/`/g, "'")}\`)'>
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
                html += `<button class="page-btn" disabled>...</button>`;
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

    function applyFilters() {
        const q     = document.getElementById('search-input').value.toLowerCase();
        const sort  = document.getElementById('sort-select').value;
        const floor = document.getElementById('floor-filter').value;

        filtered = tenants.filter(t => {
            const matchesSearch =
                (t.first_name + ' ' + t.last_name).toLowerCase().includes(q) ||
                (t.room_number    ?? '').toLowerCase().includes(q) ||
                (t.contact_number ?? '').toLowerCase().includes(q) ||
                String(t.floor ?? '').includes(q);

            const matchesFloor = floor === '' || String(t.floor) === floor;
            return matchesSearch && matchesFloor;
        });

        if (sort === 'newest') filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        if (sort === 'oldest') filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        if (sort === 'name')   filtered.sort((a, b) => a.first_name.localeCompare(b.first_name));
        if (sort === 'room')   filtered.sort((a, b) => (a.room_number ?? '').localeCompare(b.room_number ?? ''));
        if (sort === 'floor')  filtered.sort((a, b) => parseInt(a.floor ?? 0) - parseInt(b.floor ?? 0));

        currentPage = 1;
        renderTable();
    }

    function viewTenant(t) {
        document.getElementById('view-content').innerHTML = `
            <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${t.first_name} ${t.last_name}</span></div>
            <div class="view-row"><span class="view-label">Email</span><span class="view-val">${t.email ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact_number ?? '—'}</span></div>
            <div class="view-row">
                <span class="view-label">Floor & Room</span>
                <span class="view-val">${t.floor && t.room_number ? t.floor + '-' + t.room_number : (t.room_number ?? '—')}</span>
            </div>
            <div class="view-row"><span class="view-label">Stay Type</span><span class="view-val">${t.stay_type ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">${fmtDate(t.move_in_date)}</span></div>
            <div class="view-row"><span class="view-label">Move-Out Date</span><span class="view-val">${fmtDate(t.move_out_date)}</span></div>
            <div class="view-row"><span class="view-label">Status</span><span class="view-val">${statusBadge(t.status)}</span></div>
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
        const rows = [['Tenant Name', 'Floor No.', 'Room No.', 'Contact No.', 'Status', 'Notes']];
        tenants.forEach(t => rows.push([
            `${t.first_name} ${t.last_name}`,
            t.floor ?? '',
            t.room_number ?? '',
            t.contact_number ?? '',
            t.status ?? '',
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

    function statusPillClass(status) {
        const map = {
            active:   'tad-pill-active',
            pending:  'tad-pill-pending',
            move_out: 'tad-pill-moveout',
            inactive: 'tad-pill-inactive',
        };
        return map[status] ?? 'tad-pill-inactive';
    }

    function openTenantArchive() {
        document.getElementById('tad-drawer').classList.add('open');
        document.getElementById('tad-backdrop').classList.add('open');
        document.getElementById('tad-search').value = '';
        renderTenantArchive();
    }

    function closeTenantArchive() {
        document.getElementById('tad-drawer').classList.remove('open');
        document.getElementById('tad-backdrop').classList.remove('open');
    }

    function renderTenantArchive() {
        const q = document.getElementById('tad-search').value.toLowerCase();

        const data = deletedTenantArchive.filter(r =>
            (r.account_id    ?? '').toLowerCase().includes(q) ||
            (r.first_name + ' ' + r.last_name).toLowerCase().includes(q) ||
            (r.email         ?? '').toLowerCase().includes(q) ||
            (r.room_number   ?? '').toLowerCase().includes(q) ||
            (r.stay_type     ?? '').toLowerCase().includes(q)
        );

        const list = document.getElementById('tad-list');
        document.getElementById('tad-count-label').textContent =
            `${data.length} record${data.length !== 1 ? 's' : ''}`;

        if (data.length === 0) {
            list.innerHTML = `<div class="tad-empty">
                <img class="tad-empty-icon" src="{{ asset('icons/tenants.png') }}" alt="">
                No archived tenants found.
            </div>`;
            return;
        }

        list.innerHTML = data.map((r, i) => `
            <div class="tad-card" style="animation-delay:${i * 0.04}s;">
                <div class="tad-card-top">
                    <div class="tad-card-id">${r.account_id ?? '—'}</div>
                    <div class="tad-card-time">${r.move_in_date ? fmtDate(r.move_in_date) : '—'}</div>
                </div>
                <div class="tad-card-name">${r.first_name} ${r.last_name}</div>
                <div class="tad-card-email">${r.email ?? '—'}</div>
                <div class="tad-card-meta">
                    ${r.floor && r.room_number
                        ? `<span class="tad-pill tad-pill-room">${r.floor}-${r.room_number}</span>`
                        : (r.room_number ? `<span class="tad-pill tad-pill-room">${r.room_number}</span>` : '')}
                    ${r.stay_type
                        ? `<span class="tad-pill tad-pill-stay">${r.stay_type}</span>`
                        : ''}
                    <span class="tad-pill ${statusPillClass(r.status)}">${r.status ?? '—'}</span>
                </div>
                <div class="tad-card-archived">
                    Deleted on: <span>${fmtDatePlain(r.archived_at)}</span>
                </div>
            </div>
        `).join('');
    }

    function exportTenantArchive() {
        const rows = [['Account ID', 'First Name', 'Last Name', 'Email', 'Contact', 'Floor', 'Room', 'Stay Type', 'Move-In', 'Move-Out', 'Status', 'Deleted On']];
        deletedTenantArchive.forEach(r => {
            rows.push([
                r.account_id     ?? '',
                r.first_name,
                r.last_name,
                r.email          ?? '',
                r.contact_number ?? '',
                r.floor          ?? '',
                r.room_number    ?? '',
                r.stay_type      ?? '',
                r.move_in_date   ?? '',
                r.move_out_date  ?? '',
                r.status         ?? '',
                r.archived_at    ?? '',
            ]);
        });
        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
        const a   = document.createElement('a');
        a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'tenants_deleted_archive.csv';
        a.click();
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    renderTable();
</script>
@endsection