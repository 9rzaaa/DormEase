@extends('layout')

@section('title', 'DormEase: Manage Staff')
@section('page-title', 'Manage Staff')

@section('styles')
<style>
    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--black); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--hot-pink); margin-top: .2rem; }
    .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .5rem; }

    .btn-primary {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--gradient-pink); color: var(--white);
        border: none; font-size: .87rem; font-weight: 600;
        box-shadow: var(--shadow-pink-btn);
        transition: opacity .2s, transform .15s; cursor: pointer;
    }
    .btn-primary:hover { opacity: .88; transform: translateY(-1px); }
    .btn-outline {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--ink-muted);
        border: 1.5px solid var(--gray-light); font-size: .87rem; font-weight: 600;
        transition: border-color .2s, color .2s; cursor: pointer;
    }
    .btn-outline:hover { border-color: var(--hot-pink); color: var(--hot-pink); }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
    .stat-box {
        background: var(--gradient-pink);
        border-radius: 20px;
        border: none;
        box-shadow: var(--shadow-stats);
        padding: 1.6rem 1.8rem;
        display: flex; align-items: center; gap: 1.4rem;
        box-sizing: border-box; min-width: 0; overflow: hidden;
    }
    .stat-box:hover { box-shadow: var(--shadow-pink-card); }
    .stat-icon-circle {
        width: 72px; height: 72px; border-radius: 50%;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; border: 2px solid var(--white);
    }
    .stat-icon-circle img {
        width: 34px; height: 34px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(11%) sepia(93%) saturate(6000%) hue-rotate(327deg) brightness(95%);
    }
    .stat-num   { font-size: 2.2rem; font-weight: 700; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; color: var(--white); font-weight: 700; margin-top: .2rem; }
    .stat-sub   { font-size: .76rem; color: var(--white); font-weight: 500; margin-top: .15rem; }

    .table-card { background: var(--white); border-radius: 16px; border: 2px solid var(--hot-pink); box-shadow: var(--shadow); overflow: hidden; }

    .table-header {
        padding: 1.1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        background: var(--white); flex-wrap: wrap; gap: .8rem;
    }
    .table-title { font-size: 1.1rem; font-weight: 700; color: var(--hot-pink); }
    .table-date  { font-size: .78rem; color: var(--black); margin-top: .1rem; }

    .table-controls { display: flex; align-items: center; gap: .6rem; flex-wrap: nowrap; }

    .search-wrap { position: relative; flex-shrink: 0; }
    .search-wrap input {
        padding: .45rem .9rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        font-family: var(--ff-body); font-size: .83rem;
        width: 190px; background: var(--white); color: var(--black);
        outline: none; transition: box-shadow .2s, border-color .2s;
    }
    .search-wrap input:focus { box-shadow: 0 0 0 2px var(--baby-pink); border-color: var(--hot-pink); }
    .search-wrap input::placeholder { color: var(--gray); }

    .sort-select {
        padding: .42rem .7rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        background: var(--white); font-family: var(--ff-body);
        font-size: .82rem; color: var(--black);
        outline: none; cursor: pointer; transition: box-shadow .2s, border-color .2s;
    }
    .sort-select:focus { box-shadow: 0 0 0 2px var(--baby-pink); border-color: var(--hot-pink); }
    .sort-select option { color: var(--black); background: var(--white); }

    .filter-divider { width: 1px; height: 20px; background: var(--gray-light); flex-shrink: 0; }
    .filter-label { font-size: .8rem; font-weight: 700; color: var(--black); white-space: nowrap; }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--petal); }
    th {
        padding: .75rem 1rem; text-align: left;
        font-size: .75rem; font-weight: 700; color: var(--hot-pink);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
    }
    td { padding: .85rem 1rem; font-size: .875rem; color: var(--ink); border-bottom: 1px solid var(--border); vertical-align: middle; }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: var(--petal); }
    tbody tr:last-child td { border-bottom: none; }
    .td-name { font-weight: 600; }
    .td-id   { color: var(--ink-muted); font-size: .82rem; font-family: monospace; }

    .badge { display: inline-flex; align-items: center; justify-content: center; padding: .28rem .75rem; border-radius: 7px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
    .badge-onduty    { background: var(--mint); color: var(--green); border: 1.5px solid var(--green); }
    .badge-offduty   { background: var(--blush); color: var(--red); border: 1.5px solid var(--baby-pink); }
    .badge-leave     { background: var(--peach); color: var(--badge-leave-text); border: 1.5px solid var(--badge-leave-border); }
    .badge-admin     { background: var(--petal); color: var(--hot-pink); border: 1.5px solid var(--baby-pink); }
    .badge-frontdesk { background: var(--gray-light); color: var(--badge-frontdesk-text); border: 1.5px solid var(--badge-frontdesk-border); }
    .badge-guard     { background: var(--blush); color: var(--badge-guard-text); border: 1.5px solid var(--badge-guard-border); }
    .badge-staff     { background: var(--mint); color: var(--green); border: 1.5px solid var(--green); }

    .action-group { display: flex; align-items: center; gap: .5rem; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn:hover        { border-color: var(--hot-pink); background: var(--petal); }
    .act-btn.delete:hover { border-color: var(--red); background: var(--blush); }
    .act-btn.toggle:hover { border-color: var(--badge-leave-border); background: var(--peach); }

    .icon-sm { width: 16px; height: 16px; object-fit: contain; }
    .icon-md { width: 28px; height: 28px; object-fit: contain; }

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
    .page-btn:hover  { border-color: var(--hot-pink); color: var(--hot-pink); }
    .page-btn.active { background: var(--gradient-pink); color: var(--white); border-color: var(--hot-pink); }
    .page-btn:disabled { opacity: .4; cursor: default; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(26,26,46,.45); backdrop-filter: blur(4px); z-index: 300; display: none; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal { background: var(--white); border-radius: 20px; padding: 2rem; width: 90%; max-width: 480px; box-shadow: var(--shadow-pink-modal); animation: fadeUp .3s ease; max-height: 90vh; overflow-y: auto; }
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
        font-size: .88rem; color: var(--ink); background: var(--soft-bg); outline: none;
        transition: border-color .2s;
    }
    .modal-field input:focus, .modal-field select:focus { border-color: var(--hot-pink); background: var(--white); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.5rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-cancel:hover { border-color: var(--hot-pink); color: var(--hot-pink); }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--gradient-pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-pink-btn); transition: opacity .2s; }
    .btn-submit:hover { opacity: .88; }

    .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; }
    .view-val   { font-weight: 600; color: var(--ink); }

    .delete-warning { background: var(--blush); border: 1px solid var(--baby-pink); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--red); line-height: 1.6; }

    .credentials-box { background: var(--petal); border: 1.5px solid var(--baby-pink); padding: 1rem; border-radius: 14px; margin-bottom: 1rem; }
    .credentials-box h4 { margin-bottom: .8rem; color: var(--hot-pink); font-size: .95rem; }
    .credential-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: .7rem; }
    .credential-row:last-child { margin-bottom: 0; }
    .credential-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
    .credential-value { font-weight: 700; font-family: monospace; color: var(--ink); font-size: .95rem; }
    .copy-btn { padding: .3rem .8rem; border-radius: 7px; border: 1.5px solid var(--baby-pink); background: var(--white); color: var(--hot-pink); font-weight: 600; cursor: pointer; font-size: .8rem; transition: background .2s, color .2s; }
    .copy-btn:hover { background: var(--hot-pink); color: var(--white); }
    .credentials-warning { background: var(--blush); border: 1px solid var(--baby-pink); padding: .8rem; border-radius: 10px; font-size: .8rem; color: var(--red); margin-bottom: 1rem; }

    .reset-staff-card { background: var(--petal); border-radius: 12px; padding: 1rem; margin-bottom: 1.1rem; display: flex; align-items: center; gap: 12px; }
    .reset-staff-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--baby-pink); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; color: var(--hot-pink); flex-shrink: 0; border: 2px solid var(--baby-pink); }
    .reset-staff-name { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .reset-staff-meta { font-size: .78rem; color: var(--ink-muted); }
    .reset-warning-box { background: var(--peach); border: 1px solid var(--badge-leave-border); border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1.25rem; display: flex; gap: 10px; align-items: flex-start; }
    .reset-warning-box p { font-size: .82rem; color: var(--badge-leave-text); margin: 0; line-height: 1.55; }

    .shift-dot { display: inline-flex; align-items: center; gap: .4rem; }
    .shift-dot::before { content: ''; width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .shift-dot.day::before   { background: var(--shift-day); }
    .shift-dot.night::before { background: var(--shift-night); }

    @keyframes fadeIn { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
    .fade-up { animation: fadeIn .45s ease both; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.2s;}

    @media(max-width:900px) {
        .stats-row  { grid-template-columns: 1fr 1fr; }
        .modal-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; gap: 1rem; }
        .table-header { flex-direction: column; align-items: flex-start; }
        .table-controls { flex-wrap: wrap; }
        .search-wrap input { width: 150px; }
    }
    @media(max-width:600px) {
        .stats-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    @if(session('new_temp_password'))
    <div class="modal-overlay open" id="staff-credentials-modal">
        <div class="modal" style="max-width:440px;">
            <div class="modal-header">
                <div class="modal-title">Staff Account Created Successfully</div>
                <button class="modal-close" onclick="closeModal('staff-credentials-modal')">✕</button>
            </div>
            <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
                Please provide these temporary login credentials to the staff member.
            </p>
            <div class="credentials-box">
                <h4>Temporary Login Credentials</h4>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Email</div>
                        <div class="credential-value" id="new-email">{{ session('new_email') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('new-email', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Staff ID</div>
                        <div class="credential-value" id="new-staff-id">{{ session('new_staff_id') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('new-staff-id', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Temporary Password</div>
                        <div class="credential-value" id="new-temp-password">{{ session('new_temp_password') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('new-temp-password', this)">Copy</button>
                </div>
            </div>
            <div class="credentials-warning">
                This temporary password will <strong>not be shown again</strong>.
                Please inform the staff member immediately.
            </div>
            <div class="modal-actions">
                <button class="btn-submit" onclick="closeModal('staff-credentials-modal')">Got it</button>
            </div>
        </div>
    </div>
    @endif

    <div class="page-header fade-up d1">
        <div>
            <h1>Manage Staff</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openModal('add-modal')">＋ Add Staff</button>
            <button class="btn-outline" onclick="exportStaff()">
                <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                Export
            </button>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/staff-2.png') }}" class="icon-md" alt="staff">
            </div>
            <div>
                <div class="stat-label">Total Staff</div>
                <div class="stat-num">{{ $totalStaff }}</div>
                <div class="stat-sub">All Registered</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/onduty.png') }}" class="icon-md" alt="on duty">
            </div>
            <div>
                <div class="stat-label">On Duty Today</div>
                <div class="stat-num">{{ $onDutyCount }}</div>
                <div class="stat-sub">Currently Active</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/offduty.png') }}" class="icon-md" alt="off duty">
            </div>
            <div>
                <div class="stat-label">Off Duty</div>
                <div class="stat-num">{{ $offDutyCount }}</div>
                <div class="stat-sub">Not on shift</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div>
                <div class="table-title">All Staff</div>
                <div class="table-date" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Search..." oninput="filterTable()">
                </div>
                <div class="filter-divider"></div>
                <span class="filter-label">Sort:</span>
                <select class="sort-select" id="sort-select" onchange="sortTable()">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="name">Name</option>
                    <option value="role">Role</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                        <th>Role</th>
                        <th>Shift Sched.</th>
                        <th>Contact No.</th>
                        <th>Duty Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="staff-tbody"></tbody>
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
            <div class="modal-title">Add New Staff</div>
            <button class="modal-close" onclick="closeModal('add-modal')">✕</button>
        </div>
        <form method="POST" action="{{ route('staff.store') }}">
            @csrf
            <div class="modal-grid">
                <div class="modal-field">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="e.g. Juan" required value="{{ old('first_name') }}">
                </div>
                <div class="modal-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="e.g. Dela Cruz" required value="{{ old('last_name') }}">
                </div>
                <div class="modal-field full">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="e.g. juan@dormease.com" required value="{{ old('email') }}">
                </div>
                <div class="modal-field">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">Select role</option>
                        <option value="admin"     {{ old('role') === 'admin'     ? 'selected' : '' }}>Admin</option>
                        <option value="frontdesk" {{ old('role') === 'frontdesk' ? 'selected' : '' }}>Front Desk</option>
                        <option value="guard"     {{ old('role') === 'guard'     ? 'selected' : '' }}>Guard</option>
                        <option value="staff"     {{ old('role') === 'staff'     ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Shift Schedule</label>
                    <select name="shift_schedule">
                        <option value="">Select shift</option>
                        <option value="Day"   {{ old('shift_schedule') === 'Day'   ? 'selected' : '' }}>Day</option>
                        <option value="Night" {{ old('shift_schedule') === 'Night' ? 'selected' : '' }}>Night</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" placeholder="e.g. 0912-345-6789" value="{{ old('contact_number') }}">
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Add Staff</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">👤 Staff Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/edit.png') }}" class="icon-sm" alt="Edit">
                Edit Staff
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
                    <label>Role</label>
                    <select name="role" id="edit-role">
                        <option value="admin">Admin</option>
                        <option value="frontdesk">Front Desk</option>
                        <option value="guard">Guard</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Shift Schedule</label>
                    <select name="shift_schedule" id="edit-shift">
                        <option value="Day">Day</option>
                        <option value="Night">Night</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Contact No.</label>
                    <input type="text" name="contact_number" id="edit-contact">
                </div>
                <div class="modal-field full">
                    <label>Duty Status</label>
                    <select name="duty_status" id="edit-duty-status">
                        <option value="on_duty">On Duty</option>
                        <option value="off_duty">Off Duty</option>
                        <option value="on_leave">On Leave</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Active</label>
                    <select name="is_active" id="edit-is-active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/delete.png') }}" class="icon-sm" alt="Delete">
                Delete Staff
            </div>
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <div class="delete-warning">
            This action cannot be undone. The staff record will be permanently removed.
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
    const staffList  = @json($staffList);
    const PER_PAGE   = 8;
    let currentPage  = 1;
    let filtered     = [...staffList];
    let currentStaff = null;

    document.getElementById('table-date').textContent =
        'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    function dutyBadge(status) {
        const map = {
            on_duty:  '<span class="badge badge-onduty">On Duty</span>',
            off_duty: '<span class="badge badge-offduty">Off Duty</span>',
            on_leave: '<span class="badge badge-leave">On Leave</span>',
        };
        return map[status] ?? `<span class="badge badge-offduty">${status ?? '—'}</span>`;
    }

    function roleBadge(role) {
        const map = {
            admin:     '<span class="badge badge-admin">Admin</span>',
            frontdesk: '<span class="badge badge-frontdesk">Front Desk</span>',
            guard:     '<span class="badge badge-guard">Guard</span>',
            staff:     '<span class="badge badge-staff">Staff</span>',
        };
        return map[role] ?? `<span class="badge badge-staff">${role ?? '—'}</span>`;
    }

    function shiftLabel(shift) {
        if (!shift) return '—';
        const cls = shift.toLowerCase() === 'night' ? 'night' : 'day';
        return `<span class="shift-dot ${cls}">${shift}</span>`;
    }

    function fmtStaffId(id) {
        return 'ST-' + String(id).padStart(3, '0');
    }

    function renderTable() {
        const start    = (currentPage - 1) * PER_PAGE;
        const pageData = filtered.slice(start, start + PER_PAGE);
        const tbody    = document.getElementById('staff-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ink-muted);">No staff found.</td></tr>`;
        } else {
            tbody.innerHTML = pageData.map(s => `
                <tr>
                    <td class="td-id">${fmtStaffId(s.staff_id)}</td>
                    <td class="td-name">${s.first_name} ${s.last_name}</td>
                    <td>${roleBadge(s.role)}</td>
                    <td>${shiftLabel(s.shift_schedule)}</td>
                    <td>${s.contact_number ?? '—'}</td>
                    <td>${dutyBadge(s.duty_status)}</td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="View" onclick='viewStaff(${JSON.stringify(s)})'>
                                <img src="{{ asset('icons/eye.png') }}" class="icon-sm" alt="View">
                            </button>
                            <button class="act-btn" title="Edit" onclick='openEditModal(${JSON.stringify(s)})'>
                                <img src="{{ asset('icons/edit.png') }}" class="icon-sm" alt="Edit">
                            </button>
                            <button class="act-btn delete" title="Delete" onclick="openDeleteModal(${s.staff_id}, '${s.first_name} ${s.last_name}')">
                                <img src="{{ asset('icons/delete.png') }}" class="icon-sm" alt="Delete">
                            </button>
                            <button class="act-btn toggle" title="Reset Password" onclick='resetTempPassword(${JSON.stringify(s)})'>
                                <img src="{{ asset('icons/reset.png') }}" class="icon-sm" alt="Reset">
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
        filtered = staffList.filter(s =>
            (s.first_name + ' ' + s.last_name).toLowerCase().includes(q) ||
            fmtStaffId(s.staff_id).toLowerCase().includes(q) ||
            (s.role           ?? '').toLowerCase().includes(q) ||
            (s.contact_number ?? '').toLowerCase().includes(q) ||
            (s.email          ?? '').toLowerCase().includes(q)
        );
        currentPage = 1;
        renderTable();
    }

    function sortTable() {
        const val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        if (val === 'oldest') filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        if (val === 'name')   filtered.sort((a, b) => a.first_name.localeCompare(b.first_name));
        if (val === 'role')   filtered.sort((a, b) => (a.role ?? '').localeCompare(b.role ?? ''));
        currentPage = 1;
        renderTable();
    }

    function viewStaff(s) {
        currentStaff = s;
        document.getElementById('view-content').innerHTML = `
            <div class="view-row"><span class="view-label">Staff ID</span><span class="view-val" style="font-family:monospace">${fmtStaffId(s.staff_id)}</span></div>
            <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${s.first_name} ${s.last_name}</span></div>
            <div class="view-row"><span class="view-label">Email</span><span class="view-val">${s.email}</span></div>
            <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${s.contact_number ?? '—'}</span></div>
            <div class="view-row"><span class="view-label">Role</span><span class="view-val">${roleBadge(s.role)}</span></div>
            <div class="view-row"><span class="view-label">Shift Schedule</span><span class="view-val">${shiftLabel(s.shift_schedule)}</span></div>
            <div class="view-row"><span class="view-label">Duty Status</span><span class="view-val">${dutyBadge(s.duty_status)}</span></div>
            <div class="view-row"><span class="view-label">Account Status</span><span class="view-val">${s.is_active ? '✅ Active' : '🚫 Inactive'}</span></div>
        `;
        openModal('view-modal');
    }

    function switchToEdit() {
        if (currentStaff) {
            closeModal('view-modal');
            setTimeout(() => openEditModal(currentStaff), 200);
        }
    }

    function openEditModal(s) {
        currentStaff = s;
        document.getElementById('edit-form').action           = `/staff/${s.staff_id}`;
        document.getElementById('edit-first-name').value      = s.first_name     ?? '';
        document.getElementById('edit-last-name').value       = s.last_name      ?? '';
        document.getElementById('edit-email').value           = s.email          ?? '';
        document.getElementById('edit-role').value            = s.role           ?? '';
        document.getElementById('edit-shift').value           = s.shift_schedule ?? '';
        document.getElementById('edit-contact').value         = s.contact_number ?? '';
        document.getElementById('edit-duty-status').value     = s.duty_status    ?? 'off_duty';
        document.getElementById('edit-is-active').value       = s.is_active ? '1' : '0';
        openModal('edit-modal');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = `/staff/${id}`;
        openModal('delete-modal');
    }

    function exportStaff() {
        const rows = [['Staff ID', 'First Name', 'Last Name', 'Email', 'Role', 'Shift', 'Contact', 'Duty Status']];
        staffList.forEach(s => rows.push([
            fmtStaffId(s.staff_id),
            s.first_name, s.last_name, s.email,
            s.role ?? '', s.shift_schedule ?? '',
            s.contact_number ?? '', s.duty_status ?? ''
        ]));
        const csv  = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'dormease-staff.csv';
        a.click();
        showToast('Staff list exported as CSV!', 'success');
    }

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.remove('open');
        if ((id === 'reset-credentials-modal' || id === 'reset-confirm-modal') && el) el.remove();
    }
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    function copyText(id, btn) {
        const text = document.getElementById(id)?.innerText.trim();
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            const old = btn.innerText;
            btn.innerText = 'Copied!';
            setTimeout(() => btn.innerText = old, 1500);
            showToast('Copied to clipboard!', 'success');
        });
    }

    function copyResetText(id, btn) {
        const text = document.getElementById(id)?.innerText.trim();
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            const old = btn.innerText;
            btn.innerText = 'Copied!';
            setTimeout(() => btn.innerText = old, 1500);
            showToast('Copied to clipboard!', 'success');
        });
    }

    function resetTempPassword(s) {
        const existing = document.getElementById('reset-confirm-modal');
        if (existing) existing.remove();

        const initials = (s.first_name[0] ?? '') + (s.last_name[0] ?? '');

        document.body.insertAdjacentHTML('beforeend', `
            <div class="modal-overlay open" id="reset-confirm-modal">
                <div class="modal" style="max-width:420px;">
                    <div class="modal-header">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:38px;height:38px;border-radius:10px;background:var(--peach);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <img src="{{ asset('icons/reset.png') }}" style="width:18px;height:18px;" alt="">
                            </div>
                            <div>
                                <div class="modal-title">Reset password</div>
                                <div style="font-size:.78rem;color:var(--ink-muted);">This will generate new credentials</div>
                            </div>
                        </div>
                        <button class="modal-close" onclick="closeModal('reset-confirm-modal')">✕</button>
                    </div>

                    <div class="reset-staff-card">
                        <div class="reset-staff-avatar">${initials}</div>
                        <div>
                            <div class="reset-staff-name">${s.first_name} ${s.last_name}</div>
                            <div class="reset-staff-meta">${fmtStaffId(s.staff_id)} · ${s.role ?? '—'}</div>
                        </div>
                    </div>

                    <div class="reset-warning-box">
                        <span style="font-size:1rem;flex-shrink:0;"></span>
                        <p>A new temporary password will be generated. Share it with the staff member immediately as it will not be shown again.</p>
                    </div>

                    <div class="modal-actions">
                        <button class="btn-cancel" onclick="closeModal('reset-confirm-modal')">Cancel</button>
                        <button class="btn-submit" style="background:var(--salmon);" onclick="confirmReset(${s.staff_id})">Reset password</button>
                    </div>
                </div>
            </div>
        `);

        document.getElementById('reset-confirm-modal').addEventListener('click', e => {
            if (e.target === document.getElementById('reset-confirm-modal'))
                closeModal('reset-confirm-modal');
        });
    }

    function confirmReset(id) {
        closeModal('reset-confirm-modal');

        fetch(`/staff/${id}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const existing = document.getElementById('reset-credentials-modal');
            if (existing) existing.remove();

            document.body.insertAdjacentHTML('beforeend', `
                <div class="modal-overlay open" id="reset-credentials-modal">
                    <div class="modal" style="max-width:460px;">
                        <div class="modal-header">
                            <div class="modal-title">Password Reset Successful</div>
                            <button class="modal-close" onclick="closeModal('reset-credentials-modal')">✕</button>
                        </div>
                        <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
                            Share these credentials with the staff member immediately.
                        </p>
                        <div class="credentials-box">
                            <h4>New Temporary Credentials</h4>
                            <div class="credential-row">
                                <div>
                                    <div class="credential-label">Email</div>
                                    <div class="credential-value" id="reset-email">${data.reset_email}</div>
                                </div>
                                <button class="copy-btn" onclick="copyResetText('reset-email', this)">Copy</button>
                            </div>
                            <div class="credential-row">
                                <div>
                                    <div class="credential-label">Staff ID</div>
                                    <div class="credential-value" id="reset-staff-id">${data.reset_staff_id}</div>
                                </div>
                                <button class="copy-btn" onclick="copyResetText('reset-staff-id', this)">Copy</button>
                            </div>
                            <div class="credential-row">
                                <div>
                                    <div class="credential-label">Temporary Password</div>
                                    <div class="credential-value" id="reset-temp-password">${data.reset_temp_password}</div>
                                </div>
                                <button class="copy-btn" onclick="copyResetText('reset-temp-password', this)">Copy</button>
                            </div>
                        </div>
                        <div class="credentials-warning">
                            This password will <strong>not be shown again</strong>.
                        </div>
                        <div class="modal-actions">
                            <button class="btn-submit" onclick="closeModal('reset-credentials-modal')">Got it</button>
                        </div>
                    </div>
                </div>
            `);

            document.getElementById('reset-credentials-modal').addEventListener('click', e => {
                if (e.target === document.getElementById('reset-credentials-modal'))
                    closeModal('reset-credentials-modal');
            });

            showToast('Password reset successfully!', 'success');
        })
        .catch(() => showToast('Failed to reset password.', 'error'));
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('add-modal'));
    @endif

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    filtered = [...staffList];
    renderTable();
</script>
@endsection