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
    .icon-md {width: 26px; height: 26px; object-fit: contain; }

    .table-card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden;}
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
    .td-id   { color: var(--ink-muted); font-size: .82rem; }

    .badge { display: inline-flex; align-items: center; justify-content: center; padding: .28rem .75rem; border-radius: 7px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
    .badge-active   { background: #e8faf5; color: var(--green);  border: 1.5px solid var(--green); }
    .badge-pending  { background: #fff9e6; color: #c8960c;       border: 1.5px solid #f0c040; }
    .badge-inactive { background: #fff0f0; color: var(--red);    border: 1.5px solid var(--blush); }
    .badge-moveout  { background: var(--peach); color: #8b4513;  border: 1.5px solid var(--salmon); }

    .action-group { display: flex; align-items: center; gap: .5rem; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn:hover        { border-color: var(--pink); background: var(--pink-bg); }
    .act-btn.delete:hover { border-color: var(--red);  background: #fff0f0; }

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

    .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; }
    .view-val   { font-weight: 600; color: var(--ink); }

    .delete-warning { background: #fff0f0; border: 1px solid var(--blush); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--red); line-height: 1.6; }

    .empty-state { text-align: center; padding: 2.5rem; color: var(--ink-muted); font-size: .88rem; }

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
          <input type="text" name="first_name" placeholder="e.g. Maria" required value="{{ old('first_name') }}">
        </div>
        <div class="modal-field">
          <label>Last Name</label>
          <input type="text" name="last_name" placeholder="e.g. Ramos" required value="{{ old('last_name') }}">
        </div>
        <div class="modal-field">
          <label>Email</label>
          <input type="email" name="email" placeholder="e.g. maria@email.com" required value="{{ old('email') }}">
        </div>
        <div class="modal-field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Min. 6 characters" required>
        </div>
        <div class="modal-field">
          <label>Room No.</label>
          <input type="text" name="room_number" placeholder="e.g. 304" required value="{{ old('room_number') }}">
        </div>
        <div class="modal-field">
          <label>Move-In Date</label>
          <input type="date" name="move_in_date" required value="{{ old('move_in_date') }}">
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
        <div class="modal-actions">
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
        <div class="modal-field">
          <label>Email</label>
          <input type="email" name="email" id="edit-email" required>
        </div>
        <div class="modal-field">
          <label>New Password <span style="font-weight:400;color:var(--ink-muted)">(leave blank to keep)</span></label>
          <input type="password" name="password" placeholder="Leave blank to keep current">
        </div>
        <div class="modal-field">
          <label>Room No.</label>
          <input type="text" name="room_number" id="edit-room" required>
        </div>
        <div class="modal-field">
          <label>Move-In Date</label>
          <input type="date" name="move_in_date" id="edit-date" required>
        </div>
        <div class="modal-field full">
          <label>Contact No.</label>
          <input type="text" name="contact_number" id="edit-contact">
        </div>
        <div class="modal-field full">
          <label>Status</label>
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
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">🗑 Delete Tenant</div>
      <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
    </div>
    <div class="delete-warning">⚠️ This action cannot be undone. The tenant record will be permanently removed.</div>
    <p style="font-size:.9rem;color:var(--ink-muted);">Are you sure you want to delete <strong id="delete-name" style="color:var(--ink);"></strong>?</p>
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
  // Real tenant data from Laravel
  const tenants = @json($tenants);

  const PER_PAGE = 8;
  let currentPage = 1;
  let filtered = [...tenants];

  function badge(isActive) {
    return isActive
      ? `<span class="badge badge-active">Active</span>`
      : `<span class="badge badge-inactive">Inactive</span>`;
  }

  function fmtDate(d) {
    if (!d) return '—';
    const dt = new Date(d + 'T00:00:00');
    return dt.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
  }

  function renderTable() {
    const start = (currentPage - 1) * PER_PAGE;
    const pageData = filtered.slice(start, start + PER_PAGE);
    const tbody = document.getElementById('tenant-tbody');

    if (pageData.length === 0) {
      tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>`;
    } else {
      tbody.innerHTML = pageData.map(t => `<tr>
        <td class="td-id">#${t.tenant_id}</td>
        <td class="td-name">${t.first_name} ${t.last_name}</td>
        <td>${t.room_number ?? '—'}</td>
        <td>${fmtDate(t.move_in_date)}</td>
        <td>${t.contact_number ?? '—'}</td>
        <td>${t.email}</td>
        <td>${badge(t.is_active)}</td>
        <td>
          <div class="action-group">
            <button class="act-btn" title="View" onclick='viewTenant(${JSON.stringify(t)})'>👁</button>
            <button class="act-btn" title="Edit" onclick='openEditModal(${JSON.stringify(t)})'>✏️</button>
            <button class="act-btn delete" title="Delete" onclick="openDeleteModal(${t.tenant_id}, '${t.first_name} ${t.last_name}')">🗑</button>
          </div>
        </td>
      </tr>`).join('');
    }

    const total = filtered.length;
    const from  = total === 0 ? 0 : start + 1;
    const to    = Math.min(start + PER_PAGE, total);
    document.getElementById('showing-label').textContent = `Showing data ${from} to ${to} of ${total} entries`;

    renderPagination();
    updateStats();
  }

  function renderPagination() {
    const totalPages = Math.ceil(filtered.length / PER_PAGE);
    const pg = document.getElementById('pagination');
    let html = '';
    html += `<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>‹</button>`;
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
      (t.room_number ?? '').toLowerCase().includes(q) ||
      (t.email ?? '').toLowerCase().includes(q) ||
      (t.contact_number ?? '').toLowerCase().includes(q)
    );
    currentPage = 1;
    renderTable();
  }

  function sortTable() {
    const val = document.getElementById('sort-select').value;
    if (val === 'newest') filtered.sort((a,b) => new Date(b.move_in_date) - new Date(a.move_in_date));
    if (val === 'oldest') filtered.sort((a,b) => new Date(a.move_in_date) - new Date(b.move_in_date));
    if (val === 'name')   filtered.sort((a,b) => a.first_name.localeCompare(b.first_name));
    if (val === 'room')   filtered.sort((a,b) => (a.room_number??'').localeCompare(b.room_number??''));
    currentPage = 1;
    renderTable();
  }

  function updateStats() {
    document.getElementById('count-total').textContent   = tenants.length;
    document.getElementById('count-pending').textContent = tenants.filter(t => !t.is_active).length;
  }

  function viewTenant(t) {
    document.getElementById('view-content').innerHTML = `
      <div class="view-row"><span class="view-label">Tenant ID</span><span class="view-val">#${t.tenant_id}</span></div>
      <div class="view-row"><span class="view-label">Full Name</span><span class="view-val">${t.first_name} ${t.last_name}</span></div>
      <div class="view-row"><span class="view-label">Email</span><span class="view-val">${t.email}</span></div>
      <div class="view-row"><span class="view-label">Room No.</span><span class="view-val">${t.room_number ?? '—'}</span></div>
      <div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">${fmtDate(t.move_in_date)}</span></div>
      <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact_number ?? '—'}</span></div>
      <div class="view-row"><span class="view-label">Status</span><span class="view-val">${badge(t.is_active)}</span></div>
    `;
    openModal('view-modal');
  }

  function openEditModal(t) {
    document.getElementById('edit-form').action = `/tenants/${t.tenant_id}`;
    document.getElementById('edit-first-name').value = t.first_name;
    document.getElementById('edit-last-name').value  = t.last_name;
    document.getElementById('edit-email').value      = t.email;
    document.getElementById('edit-room').value       = t.room_number ?? '';
    document.getElementById('edit-date').value       = t.move_in_date ?? '';
    document.getElementById('edit-contact').value    = t.contact_number ?? '';
    document.getElementById('edit-is-active').value  = t.is_active ? '1' : '0';
    openModal('edit-modal');
  }

  function openDeleteModal(id, name) {
    document.getElementById('delete-name').textContent = name;
    document.getElementById('delete-form').action = `/tenants/${id}`;
    openModal('delete-modal');
  }

  function exportTenants() {
    const rows = [['ID','First Name','Last Name','Email','Room','Move-In Date','Contact','Status']];
    tenants.forEach(t => rows.push([
      t.tenant_id, t.first_name, t.last_name, t.email,
      t.room_number ?? '', t.move_in_date ?? '', t.contact_number ?? '',
      t.is_active ? 'Active' : 'Inactive'
    ]));
    const csv  = rows.map(r => r.join(',')).join('\n');
    const blob = new Blob([csv], {type:'text/csv'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'dormease-tenants.csv'; a.click();
    showToast('📥 Tenants exported as CSV!', 'success');
  }

  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
  });

  function showToast(msg, type='') {
    const t = document.getElementById('toast');
    t.textContent = msg; t.className = 'toast ' + type;
    setTimeout(()=> t.classList.add('show'), 10);
    setTimeout(()=> t.classList.remove('show'), 3200);
  }

  // Auto-open add modal if there were validation errors
  @if($errors->any())
    document.addEventListener('DOMContentLoaded', () => openModal('add-modal'));
  @endif

  // Show success toast
  @if(session('success'))
    document.addEventListener('DOMContentLoaded', () => showToast('✅ {{ session("success") }}', 'success'));
  @endif

  document.getElementById('table-date').textContent =
    'as of ' + new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'});

  filtered = [...tenants];
  renderTable();
</script>
@endsection