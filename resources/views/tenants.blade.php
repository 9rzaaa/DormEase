@extends('layout')

@section('title', 'DormEase — Manage Tenants')
@section('page-title', 'Manage Tenants')

@section('styles')
<style>
    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }
    .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .5rem; }

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

    .stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.2rem; }
    .stat-box {
        background: var(--white); border-radius: 16px;
        border: 1px solid var(--border); box-shadow: var(--shadow);
        padding: 1.3rem 1.5rem;
        display: flex; align-items: center; gap: 1.2rem;
    }
    .stat-icon-circle { width: 58px; height: 58px; border-radius: 50%; flex-shrink: 0; background: var(--pink); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .stat-num   { font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .8rem; color: var(--ink-muted); margin-top: .1rem; }
    .stat-sub   { font-size: .75rem; color: var(--pink); font-weight: 600; margin-top: .2rem; }
    .icon-md { width: 26px; height: 26px; object-fit: contain; }

    .table-card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
    .table-header {
        padding: 1.3rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: .8rem;
    }
    .table-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .table-date  { font-size: .78rem; color: var(--pink); font-weight: 500; margin-top: .15rem; }
    .table-controls { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }

    .search-wrap { position: relative; }
    .search-wrap input {
        padding: .5rem .9rem .5rem 2.2rem;
        border-radius: 9px; border: 1.5px solid var(--gray-light);
        font-family: var(--ff-body); font-size: .85rem; color: var(--ink);
        background: var(--pink-bg); outline: none; width: 200px;
        transition: border-color .2s, width .3s;
    }
    .search-wrap input:focus { border-color: var(--pink); width: 240px; }
    .search-wrap::before { content:'🔍'; position:absolute; left:.65rem; top:50%; transform:translateY(-50%); font-size:.8rem; pointer-events:none; }

    .sort-select {
        padding: .5rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
        outline: none; cursor: pointer;
    }
    .sort-select:focus { border-color: var(--pink); }

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
    .td-id   { color: var(--ink-muted); font-size: .82rem; font-family: monospace; }

    .badge { display: inline-flex; align-items: center; justify-content: center; padding: .28rem .75rem; border-radius: 7px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
    .badge-active   { background: #e8faf5; color: var(--green);  border: 1.5px solid var(--green); }
    .badge-pending  { background: #fff9e6; color: #c8960c;       border: 1.5px solid #f0c040; }
    .badge-inactive { background: #fff0f0; color: var(--red);    border: 1.5px solid var(--blush); }
    .badge-moveout  { background: var(--peach); color: #8b4513;  border: 1.5px solid var(--salmon); }
    .badge-temp     { background: #fff3cd; color: #856404;       border: 1.5px solid #ffc107; font-size: .7rem; }

    .action-group { display: flex; align-items: center; gap: .5rem; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn:hover        { border-color: var(--pink); background: var(--pink-bg); }
    .act-btn.delete:hover { border-color: var(--red);  background: #fff0f0; }
    .act-btn.reset:hover  { border-color: #f0c040; background: #fff9e6; }

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

    .modal-overlay {
        position: fixed; inset: 0; background: rgba(26,26,46,.45);
        backdrop-filter: blur(4px); z-index: 300;
        display: none; align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: var(--white); border-radius: 20px;
        padding: 2rem; width: 90%; max-width: 480px;
        box-shadow: 0 20px 60px rgba(26,26,46,.2);
        animation: fadeUp .3s ease;
        max-height: 90vh; overflow-y: auto;
    }
    @keyframes fadeUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
    .modal-title  { font-size: 1.15rem; font-weight: 700; color: var(--ink); }
    .modal-close  { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); transition: color .2s; }
    .modal-close:hover { color: var(--red); }

    .modal-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field { margin-bottom: 0; }
    .modal-field.full { grid-column: 1/-1; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .35rem; }
    .modal-field input, .modal-field select {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: #fafafa; outline: none;
        transition: border-color .2s;
    }
    .modal-field input:focus, .modal-field select:focus { border-color: var(--pink); background: var(--white); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.5rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-cancel:hover { border-color: var(--pink); color: var(--pink); }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; transition: background .2s; }
    .btn-submit:hover { background: #a8446c; }

    /* credentials modal */
    .credentials-box {
        background: #f0fdf4; border: 1.5px solid #86efac;
        border-radius: 14px; padding: 1.4rem; margin-bottom: 1rem;
    }
    .credentials-box h4 { font-size: 1rem; font-weight: 700; color: #166534; margin-bottom: .8rem; }
    .credential-row {
        display: flex; justify-content: space-between; align-items: center;
        background: var(--white); border: 1px solid #d1fae5;
        border-radius: 10px; padding: .7rem 1rem; margin-bottom: .6rem;
    }
    .credential-label { font-size: .8rem; color: var(--ink-muted); font-weight: 500; }
    .credential-value {
        font-size: .95rem; font-weight: 700; color: var(--ink);
        font-family: monospace; letter-spacing: .05em;
    }
    .copy-btn {
        background: none; border: 1px solid var(--gray-light); border-radius: 6px;
        padding: .25rem .6rem; font-size: .75rem; cursor: pointer; color: var(--ink-muted);
        transition: border-color .2s, color .2s;
    }
    .copy-btn:hover { border-color: var(--pink); color: var(--pink); }
    .credentials-warning {
        background: #fffbeb; border: 1px solid #fde68a;
        border-radius: 10px; padding: .75rem 1rem;
        font-size: .82rem; color: #92400e; line-height: 1.5;
    }

    .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; }
    .view-val   { font-weight: 600; color: var(--ink); }

    .delete-warning { background: #fff0f0; border: 1px solid var(--blush); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--red); line-height: 1.6; }

    @keyframes fadeIn { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
    .fade-up { animation: fadeIn .45s ease both; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.2s;}

    @media(max-width:900px) {
        .stats-row   { grid-template-columns: 1fr; }
        .modal-grid  { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; gap: 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    {{-- page header --}}
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

    {{-- stats row --}}
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
                <div class="stat-label">Pending Accounts</div>
                <div class="stat-num" id="count-pending">{{ $pendingCount }}</div>
                <div class="stat-sub">Not yet logged in</div>
            </div>
        </div>
    </div>

    {{-- tenants table --}}
    <div class="table-card fade-up d3">
        <div class="table-header">
            <div>
                <div class="table-title">All Tenants</div>
                <div class="table-date" id="table-date"></div>
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
                        <th>Floor</th>
                        <th>Move-In Date</th>
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

{{-- ── Credentials Modal — shown after adding a tenant ── --}}
@if(session('new_account_id'))
<div class="modal-overlay open" id="credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">✅ Tenant Account Created</div>
            <button class="modal-close" onclick="closeModal('credentials-modal')">✕</button>
        </div>
        <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
            The account for <strong style="color:var(--ink);">{{ session('new_tenant_name') }}</strong>
            has been created. Please provide the following credentials to the tenant:
        </p>
        <div class="credentials-box">
            <h4>🔑 Login Credentials</h4>
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
            ⚠️ This temporary password will <strong>not be shown again</strong>.
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

{{-- ── Credentials Modal — shown after password reset ── --}}
@if(session('reset_account_id'))
<div class="modal-overlay open" id="reset-credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">🔄 Password Reset Successfully</div>
            <button class="modal-close" onclick="closeModal('reset-credentials-modal')">✕</button>
        </div>
        <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
            The password for <strong style="color:var(--ink);">{{ session('reset_tenant_name') }}</strong>
            has been reset. Please provide the new temporary credentials to the tenant:
        </p>
        <div class="credentials-box">
            <h4>🔑 New Temporary Credentials</h4>
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
            ⚠️ This temporary password will <strong>not be shown again</strong>.
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

{{-- ── Add Tenant Modal ── --}}
<div class="modal-overlay" id="add-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Add New Tenant</div>
            <button class="modal-close" onclick="closeModal('add-modal')">✕</button>
        </div>
        {{-- account id and password are auto-generated — no need to enter them --}}
        <p style="font-size:.82rem;color:var(--ink-muted);margin-bottom:1.2rem;background:var(--pink-bg);padding:.7rem 1rem;border-radius:10px;">
            💡 Account ID and temporary password will be <strong>auto-generated</strong>
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

{{-- ── View Tenant Modal ── --}}
<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">👤 Tenant Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" id="view-edit-btn" onclick="switchToEdit()">Edit</button>
        </div>
    </div>
</div>

{{-- ── Edit Tenant Modal ── --}}
<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">✏️ Edit Tenant</div>
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

{{-- ── Reset Password Confirmation Modal ── --}}
<div class="modal-overlay" id="reset-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">🔄 Reset Password</div>
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

{{-- ── Delete Tenant Modal ── --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">🗑 Delete Tenant</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <div class="delete-warning">
            ⚠️ This action cannot be undone. The tenant record and all associated data will be permanently removed.
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
    // tenant data from Laravel
    const tenants = @json($tenants);

    const PER_PAGE   = 8;
    let currentPage  = 1;
    let filtered     = [...tenants];
    let currentTenant = null; // stores tenant being viewed for edit button

    // set table date
    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    // ── Badge helpers ────────────────────────────────────────────────────────
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
        return isTemp ? '<span class="badge badge-temp">Temp Password</span>' : '';
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    // ── Render table ─────────────────────────────────────────────────────────
    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('tenant-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(t => `
                <tr>
                    <td class="td-id">${t.account_id ?? '—'}</td>
                    <td class="td-name">
                        ${t.first_name} ${t.last_name}
                        ${tempBadge(t.is_temp_password)}
                    </td>
                    <td>${t.room_number ?? '—'}</td>
                    <td>${t.floor ? 'Floor ' + t.floor : '—'}</td>
                    <td>${fmtDate(t.move_in_date)}</td>
                    <td>${t.contact_number ?? '—'}</td>
                    <td>${statusBadge(t.status)}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewTenant(${JSON.stringify(t)})'>👁</button>
                            <button class="act-btn" title="Edit" onclick='openEditModal(${JSON.stringify(t)})'>✏️</button>
                            <button class="act-btn reset" title="Reset Password" onclick="openResetModal(${t.tenant_id}, '${t.first_name} ${t.last_name}')">🔑</button>
                            <button class="act-btn delete" title="Delete" onclick="openDeleteModal(${t.tenant_id}, '${t.first_name} ${t.last_name}')">🗑</button>
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

    // ── Pagination ────────────────────────────────────────────────────────────
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

    // ── Search and sort ───────────────────────────────────────────────────────
    function filterTable() {
        const q = document.getElementById('search-input').value.toLowerCase();
        filtered = tenants.filter(t =>
            (t.first_name + ' ' + t.last_name).toLowerCase().includes(q) ||
            (t.account_id  ?? '').toLowerCase().includes(q) ||
            (t.room_number ?? '').toLowerCase().includes(q) ||
            (t.email       ?? '').toLowerCase().includes(q) ||
            (t.contact_number ?? '').toLowerCase().includes(q)
        );
        currentPage = 1;
        renderTable();
    }

    function sortTable() {
        const val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        if (val === 'oldest') filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        if (val === 'name')   filtered.sort((a, b) => a.first_name.localeCompare(b.first_name));
        if (val === 'room')   filtered.sort((a, b) => (a.room_number ?? '').localeCompare(b.room_number ?? ''));
        currentPage = 1;
        renderTable();
    }

    // ── View modal ────────────────────────────────────────────────────────────
    function viewTenant(t) {
        currentTenant = t;
        document.getElementById('view-content').innerHTML = `
            <div class="view-row"><span class="view-label">Account ID</span><span class="view-val" style="font-family:monospace">${t.account_id ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${t.first_name} ${t.last_name}</span></div>
            <div class="view-row"><span class="view-label">Email</span><span class="view-val">${t.email}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Room No.</span><span class="view-val">${t.room_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Floor</span><span class="view-val">${t.floor ? 'Floor ' + t.floor : '—'}</span></div>
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

    // ── Edit modal ────────────────────────────────────────────────────────────
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

    // ── Reset password modal ──────────────────────────────────────────────────
    function openResetModal(id, name) {
        document.getElementById('reset-name').textContent = name;
        document.getElementById('reset-form').action = `/tenants/${id}/reset-password`;
        openModal('reset-modal');
    }

    // ── Delete modal ──────────────────────────────────────────────────────────
    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = `/tenants/${id}`;
        openModal('delete-modal');
    }

    // ── Export CSV ────────────────────────────────────────────────────────────
    function exportTenants() {
        const rows = [['Account ID', 'First Name', 'Last Name', 'Email', 'Room', 'Floor', 'Move-In Date', 'Contact', 'Status']];
        tenants.forEach(t => rows.push([
            t.account_id ?? '',
            t.first_name, t.last_name, t.email,
            t.room_number ?? '', t.floor ?? '',
            t.move_in_date ?? '', t.contact_number ?? '',
            t.status
        ]));
        const csv  = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'dormease-tenants.csv';
        a.click();
        showToast('📥 Tenants exported as CSV!', 'success');
    }

    // ── Copy to clipboard ─────────────────────────────────────────────────────
    function copyText(elementId, btn) {
        const text = document.getElementById(elementId).textContent;
        navigator.clipboard.writeText(text).then(() => {
            btn.textContent = '✓ Copied';
            setTimeout(() => btn.textContent = 'Copy', 2000);
        });
    }

    // ── Modal helpers ─────────────────────────────────────────────────────────
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    // ── Toast ─────────────────────────────────────────────────────────────────
    function showToast(msg, type = '') {
        const t = document.getElementById('toast');
        if (!t) return;
        t.textContent  = msg;
        t.className    = 'toast ' + type;
        setTimeout(() => t.classList.add('show'), 10);
        setTimeout(() => t.classList.remove('show'), 3200);
    }

    // ── Auto-open add modal on validation errors ──────────────────────────────
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('add-modal'));
    @endif

    // ── Show success toast ────────────────────────────────────────────────────
    @if(session('success') && !session('new_account_id') && !session('reset_account_id'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('✅ {{ session("success") }}', 'success')
        );
    @endif

    // ── Init ──────────────────────────────────────────────────────────────────
    filtered = [...tenants];
    renderTable();
</script>
@endsection