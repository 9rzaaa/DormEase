@extends('layout')

@section('title', 'DormEase: Manage Tenants')
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
    display: flex;
    text-align: left;
}

.search-wrap input {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: none;
    font-size: .85rem;
    width: 150px;
    outline: none;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    color: #333;
    text-align: left;
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

.badge-temp {
    background: #fff3b0;
    color: #5a3d00;
    border: 1px solid #ffd84d;
    font-weight: 700;
    box-shadow: 0 4px 10px rgba(255, 216, 77, 0.25);
}

table th,
table td {
    text-align: center;
    vertical-align: middle;
}

/* Account ID LEFT aligned */
.td-id {
    text-align: left;
}

/* Tenant Name LEFT aligned */
.td-name {
    text-align: left;
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
            <button class="btn-outline" onclick="exportTenants()">
                <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                Export
            </button>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt="tenants">
            </div>
            <div>
                <div class="stat-label">Total Tenants</div>
                <div class="stat-num" id="count-total">{{ $totalTenants }}</div>
                <div class="stat-sub">Currently Registered</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" class="icon-md" alt="units">
            </div>
            <div>
                <div class="stat-label">Active Tenants</div>
                <div class="stat-num" id="count-active">{{ $activeCount }}</div>
                <div class="stat-sub">Currently Active</div>
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

                <!-- NEW FLOOR FILTER -->
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
                        <th>Account ID</th>
                        <th>Tenant Name</th>
                        <th>Floor & Room No.</th>
                        <th>Move-In Date</th>
                        <th>Move-Out Date</th>
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

@if(session('new_account_id'))
<div class="modal-overlay open" id="credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">Tenant Account Created</div>
            <button class="modal-close" onclick="closeModal('credentials-modal')">✕</button>
        </div>
        <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
            The account for <strong style="color:var(--ink);">{{ session('new_tenant_name') }}</strong>
            has been created. Please provide the following credentials to the tenant:
        </p>
        <div class="credentials-box">
            <h4>Login Credentials</h4>
            <div class="credential-row">
                <div>
                    <div class="credential-label">Account ID</div>
                    <div class="credential-value" id="cred-account-id">{{ session('new_account_id') }}</div>
                </div>
                <button class="copy-btn" onclick="copyText('cred-account-id', this)">Copy</button>
            </div>
            <div class="credential-row">
                <div>
                    <div class="credential-label">Temporary Password</div>
                    <div class="credential-value" id="cred-temp-password">{{ session('new_temp_password') }}</div>
                </div>
                <button class="copy-btn" onclick="copyText('cred-temp-password', this)">Copy</button>
            </div>
        </div>
        <div class="credentials-warning">
            This temporary password will <strong>not be shown again</strong>.
            Please write it down or inform the tenant immediately.
            The tenant will be prompted to change their password on first login.
        </div>
        <div class="modal-actions">
            <button class="btn-submit" onclick="closeModal('credentials-modal')">
                Got it, I've noted the credentials
            </button>
        </div>
    </div>
</div>
@endif

@if(session('reset_account_id'))
<div class="modal-overlay open" id="reset-credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">Password Reset Successfully</div>
            <button class="modal-close" onclick="closeModal('reset-credentials-modal')">✕</button>
        </div>
        <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
            The password for <strong style="color:var(--ink);">{{ session('reset_tenant_name') }}</strong>
            has been reset. Please provide the new temporary credentials to the tenant:
        </p>
        <div class="credentials-box">
            <h4>New Temporary Credentials</h4>
            <div class="credential-row">
                <div>
                    <div class="credential-label">Account ID</div>
                    <div class="credential-value" id="reset-account-id">{{ session('reset_account_id') }}</div>
                </div>
                <button class="copy-btn" onclick="copyText('reset-account-id', this)">Copy</button>
            </div>
            <div class="credential-row">
                <div>
                    <div class="credential-label">New Temporary Password</div>
                    <div class="credential-value" id="reset-temp-password">{{ session('reset_temp_password') }}</div>
                </div>
                <button class="copy-btn" onclick="copyText('reset-temp-password', this)">Copy</button>
            </div>
        </div>
        <div class="credentials-warning">
            This temporary password will <strong>not be shown again</strong>.
            Please inform the tenant of their new password immediately.
        </div>
        <div class="modal-actions">
            <button class="btn-submit" onclick="closeModal('reset-credentials-modal')">
                Got it, I've noted the credentials
            </button>
        </div>
    </div>
</div>
@endif

<div class="modal-overlay" id="add-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Add New Tenant</div>
            <button class="modal-close" onclick="closeModal('add-modal')">✕</button>
        </div>
        <p style="font-size:.82rem;color:var(--ink-muted);margin-bottom:1.2rem;background:var(--pink-bg);padding:.7rem 1rem;border-radius:10px;">
            Account ID and temporary password will be <strong>auto-generated</strong>
            and shown to you after saving.
        </p>
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf
            <div class="modal-grid">
                <div class="modal-field">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="e.g. Maria" required value="{{ old('first_name') }}">
                </div>
                <div class="modal-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="e.g. Ramos" required value="{{ old('last_name') }}">
                </div>
                <div class="modal-field full">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="e.g. maria@email.com" required value="{{ old('email') }}">
                </div>
                <div class="modal-field">
                    <label>Room No.</label>
                    <input type="text" name="room_number" placeholder="e.g. 304" value="{{ old('room_number') }}">
                </div>
                <div class="modal-field">
                    <label>Floor</label>
                    <select name="floor">
                        <option value="">Select floor</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>Floor {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="modal-field">
                    <label>Stay Type</label>
                    <select name="stay_type">
                        <option value="">Select type</option>
                        <option value="Bed Spacer" {{ old('stay_type') === 'Bed Spacer' ? 'selected' : '' }}>Bed Spacer</option>
                        <option value="Solo Room"  {{ old('stay_type') === 'Solo Room'  ? 'selected' : '' }}>Solo Room</option>
                        <option value="Shared Room"{{ old('stay_type') === 'Shared Room'? 'selected' : '' }}>Shared Room</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Move-In Date</label>
                    <input type="date" name="move_in_date" value="{{ old('move_in_date') }}">
                </div>
                <div class="modal-field full">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" placeholder="e.g. 0912-345-6789" value="{{ old('contact_number') }}">
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
            <button class="btn-submit" id="view-edit-btn" onclick="switchToEdit()">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/edit.png') }}" class="icon-sm" alt="Edit">
                Edit Tenant
            </div>
            <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
        </div>
        <form method="POST" id="edit-form" action="">
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
                <div class="modal-field full">
                    <label>Email</label>
                    <input type="email" name="email" id="edit-email" required>
                </div>
                <div class="modal-field">
                    <label>Room No.</label>
                    <input type="text" name="room_number" id="edit-room">
                </div>
                <div class="modal-field">
                    <label>Floor</label>
                    <select name="floor" id="edit-floor">
                        <option value="">Select floor</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">Floor {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="modal-field">
                    <label>Stay Type</label>
                    <select name="stay_type" id="edit-stay-type">
                        <option value="">Select type</option>
                        <option value="Bed Spacer">Bed Spacer</option>
                        <option value="Solo Room">Solo Room</option>
                        <option value="Shared Room">Shared Room</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Move-In Date</label>
                    <input type="date" name="move_in_date" id="edit-date">
                </div>
                <div class="modal-field">
                    <label>Move-Out Date</label>
                    <input type="date" name="move_out_date" id="edit-moveout">
                </div>
                <div class="modal-field full">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" id="edit-contact">
                </div>
                <div class="modal-field full">
                    <label>Status</label>
                    <select name="status" id="edit-status">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="move_out">Move Out</option>
                        <option value="inactive">Inactive</option>
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

<div class="modal-overlay" id="reset-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/reset.png') }}" class="icon-sm" alt="Reset">
                Reset Password
            </div>
            <button class="modal-close" onclick="closeModal('reset-modal')">✕</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:1rem;">
            Are you sure you want to reset the password for
            <strong id="reset-name" style="color:var(--ink);"></strong>?
            A new temporary password will be generated.
        </p>
        <form method="POST" id="reset-form" action="">
            @csrf
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('reset-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:#f0c040;color:#1a1a2e;">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/delete.png') }}" class="icon-sm" alt="Delete">
                Delete Tenant
            </div>
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
        <p style="font-size:.9rem;color:var(--ink-muted);">
            Are you sure you want to delete
            <strong id="delete-name" style="color:var(--ink);"></strong>?
        </p>
        <form method="POST" id="delete-form" action="">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:var(--red);">Delete</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const tenants = @json($tenants);

    const PER_PAGE   = 8;
    let currentPage  = 1;
    let filtered     = [...tenants];
    let currentTenant = null;
    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    function statusBadge(status) {
        const map = {
            active:   '<span class="badge badge-active">Active</span>',
            pending:  '<span class="badge badge-pending">Pending</span>',
            move_out: '<span class="badge badge-moveout">Move Out</span>',
            inactive: '<span class="badge badge-inactive">Inactive</span>',
        };
        return map[status] ?? `<span class="badge badge-inactive">${status}</span>`;
    }

    function tempBadge(isTemp) {
        return isTemp ? '<span class="badge badge-temp">Temp Pass</span>' : '';
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
            tbody.innerHTML = `<tr><td colspan="9" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(t => `
                <tr>
    <td class="td-id">${t.account_id ?? '—'}</td>

    <td class="td-name">
        ${t.first_name} ${t.last_name}
        ${tempBadge(t.is_temp_password)}
    </td>

    <td>
    ${t.floor && t.room_number
        ? `${t.floor}-${t.room_number}`
        : (t.room_number ?? '—')}
    </td>

    <td>${fmtDate(t.move_in_date)}</td>

    <td>${t.move_out_date ? fmtDate(t.move_out_date) : '—'}</td>

    <td>${t.contact_number ?? '—'}</td>

    <td>${statusBadge(t.status)}</td>

    <td>
        <div class="action-group">
            <button class="act-btn" title="View"
                onclick='viewTenant(${JSON.stringify(t)})'>
                <img src="{{ asset('icons/eye.png') }}" class="icon-sm">
            </button>

            <button class="act-btn" title="Edit"
                onclick='openEditModal(${JSON.stringify(t)})'>
                <img src="{{ asset('icons/edit.png') }}" class="icon-sm">
            </button>

            <button class="act-btn reset" title="Reset Password"
                onclick="openResetModal(${t.tenant_id}, '${t.first_name} ${t.last_name}')">
                <img src="{{ asset('icons/reset.png') }}" class="icon-sm">
            </button>

            <button class="act-btn delete" title="Delete"
                onclick="openDeleteModal(${t.tenant_id}, '${t.first_name} ${t.last_name}')">
                <img src="{{ asset('icons/delete.png') }}" class="icon-sm">
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

    function applyFilters() {
    const q = document.getElementById('search-input').value.toLowerCase();
    const sort = document.getElementById('sort-select').value;
    const floor = document.getElementById('floor-filter').value;

    filtered = tenants.filter(t => {

        const matchesSearch =
            (t.first_name + ' ' + t.last_name).toLowerCase().includes(q) ||
            (t.account_id  ?? '').toLowerCase().includes(q) ||
            (t.room_number ?? '').toLowerCase().includes(q) ||
            (t.email ?? '').toLowerCase().includes(q) ||
            (t.contact_number ?? '').toLowerCase().includes(q);

        const matchesFloor =
            floor === "" || String(t.floor) === floor;

        return matchesSearch && matchesFloor;
    });

    // sorting
    if (sort === 'newest') filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    if (sort === 'oldest') filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
    if (sort === 'name')   filtered.sort((a, b) => a.first_name.localeCompare(b.first_name));
    if (sort === 'room')   filtered.sort((a, b) => (a.room_number ?? '').localeCompare(b.room_number ?? ''));

    currentPage = 1;
    renderTable();
}

    function sortTable() {
        const val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        if (val === 'oldest') filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        if (val === 'name')   filtered.sort((a, b) => a.first_name.localeCompare(b.first_name));
        if (val === 'room')   filtered.sort((a, b) => (a.room_number ?? '').localeCompare(b.room_number ?? ''));
        if (val === 'floor') {
        filtered.sort((a, b) => {
        const fa = parseInt(a.floor ?? 0);
        const fb = parseInt(b.floor ?? 0);
        return fa - fb;
    });
}
        currentPage = 1;
        renderTable();
    }

    function viewTenant(t) {
        currentTenant = t;
        document.getElementById('view-content').innerHTML = `
            <div class="view-row"><span class="view-label">Account ID</span><span class="view-val" style="font-family:monospace">${t.account_id ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${t.first_name} ${t.last_name}</span></div>
            <div class="view-row"><span class="view-label">Email</span><span class="view-val">${t.email}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact_number ?? '—'}</span></div>
            <div class="view-row">
            <span class="view-label">Floor & Room No.</span>
            <span class="view-val">
                ${t.floor && t.room_number
                ? `${t.floor}-${t.room_number}`
                : (t.room_number ?? '—')}
            </span>
            </div>
            <div class="view-row"><span class="view-label">Stay Type</span><span class="view-val">${t.stay_type ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">${fmtDate(t.move_in_date)}</span></div>
            <div class="view-row"><span class="view-label">Move-Out Date</span><span class="view-val">${fmtDate(t.move_out_date)}</span></div>
            <div class="view-row"><span class="view-label">Status</span><span class="view-val">${statusBadge(t.status)}</span></div>
            <div class="view-row"><span class="view-label">Password Status</span><span class="view-val">${t.is_temp_password ? tempBadge(true) + ' Not yet changed' : '✅ Changed by tenant'}</span></div>
        `;
        openModal('view-modal');
    }

    function switchToEdit() {
        if (currentTenant) {
            closeModal('view-modal');
            setTimeout(() => openEditModal(currentTenant), 200);
        }
    }

    function openEditModal(t) {
        currentTenant = t;
        document.getElementById('edit-form').action        = `/tenants/${t.tenant_id}`;
        document.getElementById('edit-first-name').value  = t.first_name ?? '';
        document.getElementById('edit-last-name').value   = t.last_name  ?? '';
        document.getElementById('edit-email').value       = t.email      ?? '';
        document.getElementById('edit-room').value        = t.room_number ?? '';
        document.getElementById('edit-floor').value       = t.floor      ?? '';
        document.getElementById('edit-stay-type').value   = t.stay_type  ?? '';
        document.getElementById('edit-date').value        = t.move_in_date  ?? '';
        document.getElementById('edit-moveout').value     = t.move_out_date ?? '';
        document.getElementById('edit-contact').value     = t.contact_number ?? '';
        document.getElementById('edit-status').value      = t.status ?? 'pending';
        openModal('edit-modal');
    }

    function openResetModal(id, name) {
        document.getElementById('reset-name').textContent = name;
        document.getElementById('reset-form').action = `/tenants/${id}/reset-password`;
        openModal('reset-modal');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = `/tenants/${id}`;
        openModal('delete-modal');
    }

    function exportTenants() {
        const rows = [['Account ID', 'First Name', 'Last Name', 'Email', 'Room', 'Floor', 'Move-In Date', 'Move-Out Date', 'Contact', 'Status']];        tenants.forEach(t => rows.push([
            t.account_id ?? '',
            t.first_name, t.last_name, t.email,
            t.room_number ?? '', t.floor ?? '',
            t.move_in_date ?? '',
            t.move_out_date ?? '',
            t.contact_number ?? '',
            t.status
        ]));
        const csv  = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'dormease-tenants.csv';
        a.click();
        showToast('Tenants exported as CSV!', 'success');
    }

    function copyText(elementId, btn) {
        const text = document.getElementById(elementId).textContent;
        navigator.clipboard.writeText(text).then(() => {
            btn.textContent = 'Copied';
            setTimeout(() => btn.textContent = 'Copy', 2000);
        });
    }

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    function showToast(msg, type = '') {
        const t = document.getElementById('toast');
        if (!t) return;
        t.textContent  = msg;
        t.className    = 'toast ' + type;
        setTimeout(() => t.classList.add('show'), 10);
        setTimeout(() => t.classList.remove('show'), 3200);
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('add-modal'));
    @endif

    @if(session('success') && !session('new_account_id') && !session('reset_account_id'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    filtered = [...tenants];
    renderTable();
</script>
@endsection