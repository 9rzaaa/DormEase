<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DormEase — Manage Tenants</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --pink:       #CA5D86;
      --pink-light: #FFB0CE;
      --pink-soft:  #FF7E86;
      --pink-bg:    #fdf0f5;
      --pink-card:  #fce8f1;
      --gray:       #B5B7C0;
      --gray-light: #E5ECF6;
      --mint:       #A6E7D8;
      --green:      #29BD9B;
      --peach:      #FFD7C7;
      --salmon:     #EB9C7D;
      --blush:      #FFC5C5;
      --red:        #DF0404;
      --white:      #ffffff;
      --ink:        #1a1a2e;
      --ink-muted:  #7a5f6e;
      --border:     rgba(202,93,134,.12);
      --shadow:     0 2px 16px rgba(202,93,134,.08);
      --ff-display: 'DM Serif Display', Georgia, serif;
      --ff-body:    'DM Sans', sans-serif;
      --sidebar-w:  260px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: var(--ff-body); background: var(--pink-bg); color: var(--ink); display: flex; min-height: 100vh; overflow-x: hidden; }
    a { text-decoration: none; color: inherit; }
    button { font-family: var(--ff-body); cursor: pointer; }

    /* ══ SIDEBAR ══ */
    .sidebar {
      width: var(--sidebar-w); background: var(--white);
      display: flex; flex-direction: column;
      position: fixed; top: 0; left: 0; bottom: 0;
      z-index: 100; border-right: 1px solid var(--border);
      box-shadow: 2px 0 20px rgba(202,93,134,.06);
    }
    .sidebar-logo {
      padding: 1.4rem 1.5rem 1rem;
      display: flex; align-items: center; gap: .65rem;
      border-bottom: 1px solid var(--border);
    }
    .sidebar-logo-icon {
      width: 38px; height: 38px; border-radius: 10px;
      background: linear-gradient(135deg, var(--pink) 0%, #a8446c 100%);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; flex-shrink: 0;
    }
    .sidebar-logo-text { font-family: var(--ff-display); font-size: 1.3rem; font-weight: 700; color: var(--ink); letter-spacing: -.01em; }
    .sidebar-logo-text em { font-style: italic; color: var(--pink); }
    .sidebar-role {
      margin: .8rem 1.5rem;
      display: inline-flex; align-items: center; gap: .4rem;
      background: var(--pink-card); border: 1px solid var(--pink-light);
      border-radius: 6px; padding: .28rem .7rem;
      font-size: .72rem; font-weight: 700; color: var(--pink);
      letter-spacing: .06em; text-transform: uppercase;
    }
    .sidebar-nav { flex: 1; padding: .5rem 1rem 1rem; overflow-y: auto; }
    .nav-item {
      display: flex; align-items: center; gap: .75rem;
      padding: .68rem .85rem; border-radius: 10px;
      font-size: .87rem; font-weight: 500; color: var(--ink-muted);
      cursor: pointer; margin-bottom: .15rem;
      transition: background .2s, color .2s;
      border: none; background: none; width: 100%; text-align: left;
    }
    .nav-item:hover { background: var(--pink-bg); color: var(--pink); }
    .nav-item.active { background: var(--pink-card); color: var(--pink); font-weight: 600; }
    .nav-icon { font-size: 1.05rem; width: 22px; text-align: center; flex-shrink: 0; }
    .nav-divider { height: 1px; background: var(--border); margin: .6rem 0; }
    .sidebar-logout { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
    .logout-btn {
      display: flex; align-items: center; gap: .65rem;
      font-size: .87rem; font-weight: 500; color: var(--ink-muted);
      background: none; border: none; cursor: pointer;
      padding: .5rem .3rem; width: 100%; transition: color .2s;
    }
    .logout-btn:hover { color: var(--red); }

    /* ══ MAIN ══ */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

    /* TOPBAR */
    .topbar {
      background: var(--white); border-bottom: 1px solid var(--border);
      padding: .85rem 2rem;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }
    .breadcrumb { font-size: .8rem; color: var(--ink-muted); }
    .breadcrumb span { color: var(--pink); font-weight: 600; }
    .topbar-right { display: flex; align-items: center; gap: 1rem; }
    .notif-btn { position: relative; background: none; border: none; font-size: 1.2rem; color: var(--ink-muted); cursor: pointer; padding: .3rem; transition: color .2s; }
    .notif-btn:hover { color: var(--pink); }
    .notif-badge { position: absolute; top: 0; right: 0; width: 8px; height: 8px; border-radius: 50%; background: var(--red); border: 2px solid var(--white); }
    .avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--pink-light), var(--pink)); display: flex; align-items: center; justify-content: center; font-size: .85rem; font-weight: 700; color: var(--white); cursor: pointer; border: 2px solid var(--pink-light); }

    /* PAGE BODY */
    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    /* PAGE HEADER */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }
    .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .5rem; }

    /* BUTTONS */
    .btn-primary {
      display: flex; align-items: center; gap: .45rem;
      padding: .55rem 1.2rem; border-radius: 10px;
      background: var(--pink); color: var(--white);
      border: none; font-size: .87rem; font-weight: 600;
      box-shadow: 0 3px 12px rgba(202,93,134,.3);
      transition: background .2s, transform .15s;
    }
    .btn-primary:hover { background: #a8446c; transform: translateY(-1px); }
    .btn-outline {
      display: flex; align-items: center; gap: .45rem;
      padding: .55rem 1.2rem; border-radius: 10px;
      background: var(--white); color: var(--ink-muted);
      border: 1.5px solid var(--gray-light); font-size: .87rem; font-weight: 600;
      transition: border-color .2s, color .2s;
    }
    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }

    /* CARD */
    .card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); padding: 1.5rem; }

    /* STATS ROW */
    .stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.2rem; }
    .stat-box {
      background: var(--white); border-radius: 16px;
      border: 1px solid var(--border); box-shadow: var(--shadow);
      padding: 1.3rem 1.5rem;
      display: flex; align-items: center; gap: 1.2rem;
    }
    .stat-icon-circle {
      width: 58px; height: 58px; border-radius: 50%; flex-shrink: 0;
      background: var(--pink-card);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem;
    }
    .stat-num { font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .8rem; color: var(--ink-muted); margin-top: .1rem; }
    .stat-sub { font-size: .75rem; color: var(--pink); font-weight: 600; margin-top: .2rem; }

    /* TABLE CARD */
    .table-card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
    .table-header {
      padding: 1.3rem 1.5rem;
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: .8rem;
    }
    .table-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .table-date { font-size: .78rem; color: var(--pink); font-weight: 500; margin-top: .15rem; }
    .table-controls { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }

    /* Search */
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

    /* Sort */
    .sort-select {
      padding: .5rem .8rem; border-radius: 9px;
      border: 1.5px solid var(--gray-light); background: var(--white);
      font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
      outline: none; cursor: pointer;
    }
    .sort-select:focus { border-color: var(--pink); }

    /* TABLE */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--pink-bg); }
    th {
      padding: .75rem 1rem; text-align: left;
      font-size: .75rem; font-weight: 700; color: var(--ink-muted);
      text-transform: uppercase; letter-spacing: .06em;
      white-space: nowrap;
    }
    td { padding: .85rem 1rem; font-size: .875rem; color: var(--ink); border-bottom: 1px solid var(--border); vertical-align: middle; }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: var(--pink-bg); }
    tbody tr:last-child td { border-bottom: none; }
    .td-name { font-weight: 600; }
    .td-id { color: var(--ink-muted); font-size: .82rem; }

    /* Status badges */
    .badge {
      display: inline-flex; align-items: center; justify-content: center;
      padding: .28rem .75rem; border-radius: 7px;
      font-size: .75rem; font-weight: 700; white-space: nowrap;
    }
    .badge-active   { background: #e8faf5; color: var(--green); border: 1.5px solid var(--green); }
    .badge-pending  { background: #fff9e6; color: #c8960c; border: 1.5px solid #f0c040; }
    .badge-inactive { background: #fff0f0; color: var(--red); border: 1.5px solid var(--blush); }
    .badge-moveout  { background: var(--peach); color: #8b4513; border: 1.5px solid var(--salmon); }

    /* Action icons */
    .action-group { display: flex; align-items: center; gap: .5rem; }
    .act-btn {
      width: 30px; height: 30px; border-radius: 7px;
      border: 1.5px solid var(--gray-light); background: var(--white);
      display: flex; align-items: center; justify-content: center;
      font-size: .85rem; cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn:hover { border-color: var(--pink); background: var(--pink-bg); }
    .act-btn.delete:hover { border-color: var(--red); background: #fff0f0; }

    /* PAGINATION */
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
    .page-btn:hover { border-color: var(--pink); color: var(--pink); }
    .page-btn.active { background: var(--pink); color: var(--white); border-color: var(--pink); }
    .page-btn:disabled { opacity: .4; cursor: default; }
    .page-ellipsis { font-size: .85rem; color: var(--ink-muted); padding: 0 .2rem; }

    /* ══ MODAL ══ */
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
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
    .modal-title { font-size: 1.15rem; font-weight: 700; color: var(--ink); }
    .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); transition: color .2s; }
    .modal-close:hover { color: var(--red); }

    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field { margin-bottom: .0rem; }
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

    /* View modal */
    .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; }
    .view-val { font-weight: 600; color: var(--ink); }

    /* Confirm delete modal */
    .delete-warning { background: #fff0f0; border: 1px solid var(--blush); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--red); line-height: 1.6; }

    /* ══ TOAST ══ */
    .toast {
      position: fixed; bottom: 2rem; right: 2rem; z-index: 400;
      background: var(--ink); color: var(--white);
      padding: .85rem 1.4rem; border-radius: 12px;
      font-size: .87rem; font-weight: 500;
      box-shadow: 0 8px 24px rgba(26,26,46,.25);
      transform: translateY(80px); opacity: 0;
      transition: transform .35s ease, opacity .35s ease;
    }
    .toast.show { transform: translateY(0); opacity: 1; }
    .toast.success { background: var(--green); }
    .toast.error   { background: var(--red); }

    /* ══ ANIMATIONS ══ */
    @keyframes fadeIn { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
    .fade-up { animation: fadeIn .45s ease both; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.2s;}

    /* ══ RESPONSIVE ══ */
    @media(max-width:900px){
      :root{--sidebar-w:0px;}
      .sidebar{transform:translateX(-260px);width:260px;}
      .main{margin-left:0;}
      .stats-row{grid-template-columns:1fr;}
      .modal-grid{grid-template-columns:1fr;}
    }
  </style>
</head>
<body>

<!-- ══ SIDEBAR ══ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="sidebar-logo-icon">🏠</div>
    <div class="sidebar-logo-text">Dorm<em>Ease</em></div>
  </div>
  <div class="sidebar-role">👤 Admin</div>
  <nav class="sidebar-nav">
    
    <a href="{{ route('dashboard') }}" class="nav-item">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('tenants') }}" class="nav-item active">
        <span class="nav-icon">👥</span> Manage Tenants
    </a>
    <a href="{{ route('documents') }}" class="nav-item">
        <span class="nav-icon">📄</span> Document Management
    </a>
    <a href="/emergency" class="nav-item">
        <span class="nav-icon">🚨</span> Emergency Reports
    </a>
    <a href="/maintenance" class="nav-item">
        <span class="nav-icon">🔧</span> Maintenance Requests
    </a>
    <a href="/billing" class="nav-item">
        <span class="nav-icon">💧</span> Water Billing
    </a>
    <a href="/visitors" class="nav-item">
        <span class="nav-icon">🚪</span> Visitor Logs
    </a>
    <a href="/announcements" class="nav-item">
        <span class="nav-icon">📢</span> Announcements
    </a>
    <div class="nav-divider"></div>
    <a href="/staff" class="nav-item">
        <span class="nav-icon">🧑‍💼</span> Manage Staff
    </a>
    <a href="/settings" class="nav-item">
        <span class="nav-icon">⚙️</span> Settings
    </a>

</nav>
  <div class="sidebar-logout">
    <form method="POST" action="{{ route('logout') }}" id="logout-form">@csrf</form>
    <button class="logout-btn" onclick="document.getElementById('logout-form').submit()">
      <span>↩</span> Log Out
    </button>
  </div>
</aside>

<!-- ══ MAIN ══ -->
<div class="main">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="breadcrumb">Pages / <span>Manage Tenants</span></div>
    <div class="topbar-right">
      <button class="notif-btn">🔔<span class="notif-badge"></span></button>
      <div class="avatar">K</div>
    </div>
  </header>

  <!-- PAGE BODY -->
  <div class="page-body">

    <!-- Header -->
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

    <!-- Stats -->
    <div class="stats-row fade-up d2">
      <div class="stat-box">
        <div class="stat-icon-circle">👥</div>
        <div>
          <div class="stat-label">Total Tenants</div>
          <div class="stat-num" id="count-total">67</div>
          <div class="stat-sub">Currently Registered</div>
        </div>
      </div>
      <div class="stat-box">
        <div class="stat-icon-circle">🛏</div>
        <div>
          <div class="stat-label">Units Occupied</div>
          <div class="stat-num" id="count-units">36</div>
          <div class="stat-sub">Out of 40 available</div>
        </div>
      </div>
      <div class="stat-box">
        <div class="stat-icon-circle">💳</div>
        <div>
          <div class="stat-label">Pending Tenants</div>
          <div class="stat-num" id="count-pending">4</div>
          <div class="stat-sub">Payment Pending</div>
        </div>
      </div>
    </div>

    <!-- Table Card -->
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

  </div><!-- /page-body -->
</div><!-- /main -->

<!-- ══ ADD TENANT MODAL ══ -->
<div class="modal-overlay" id="add-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">➕ Add New Tenant</div>
      <button class="modal-close" onclick="closeModal('add-modal')">✕</button>
    </div>
    <div class="modal-grid">
      <div class="modal-field">
        <label>Tenant Name</label>
        <input type="text" id="add-name" placeholder="e.g. Maria Ramos">
      </div>
      <div class="modal-field">
        <label>Room No.</label>
        <input type="text" id="add-room" placeholder="e.g. 304">
      </div>
      <div class="modal-field">
        <label>Move-In Date</label>
        <input type="date" id="add-date">
      </div>
      <div class="modal-field">
        <label>Contact No.</label>
        <input type="text" id="add-contact" placeholder="e.g. 0912-345-6789">
      </div>
      <div class="modal-field">
        <label>Pending Bill (₱)</label>
        <input type="number" id="add-bill" placeholder="0.00" min="0" step="0.01">
      </div>
      <div class="modal-field">
        <label>Status</label>
        <select id="add-status">
          <option value="Active">Active</option>
          <option value="Pending">Pending</option>
          <option value="Inactive">Inactive</option>
          <option value="Move-Out">Move-Out</option>
        </select>
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
      <button class="btn-submit" onclick="addTenant()">Add Tenant</button>
    </div>
  </div>
</div>

<!-- ══ VIEW TENANT MODAL ══ -->
<div class="modal-overlay" id="view-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">👤 Tenant Details</div>
      <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
    </div>
    <div id="view-content"></div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
      <button class="btn-submit" onclick="closeModal('view-modal');openEdit()">Edit</button>
    </div>
  </div>
</div>

<!-- ══ EDIT TENANT MODAL ══ -->
<div class="modal-overlay" id="edit-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">✏️ Edit Tenant</div>
      <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
    </div>
    <div class="modal-grid">
      <div class="modal-field">
        <label>Tenant Name</label>
        <input type="text" id="edit-name">
      </div>
      <div class="modal-field">
        <label>Room No.</label>
        <input type="text" id="edit-room">
      </div>
      <div class="modal-field">
        <label>Move-In Date</label>
        <input type="date" id="edit-date">
      </div>
      <div class="modal-field">
        <label>Contact No.</label>
        <input type="text" id="edit-contact">
      </div>
      <div class="modal-field">
        <label>Pending Bill (₱)</label>
        <input type="number" id="edit-bill" min="0" step="0.01">
      </div>
      <div class="modal-field">
        <label>Status</label>
        <select id="edit-status">
          <option value="Active">Active</option>
          <option value="Pending">Pending</option>
          <option value="Inactive">Inactive</option>
          <option value="Move-Out">Move-Out</option>
        </select>
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
      <button class="btn-submit" onclick="saveEdit()">Save Changes</button>
    </div>
  </div>
</div>

<!-- ══ DELETE CONFIRM MODAL ══ -->
<div class="modal-overlay" id="delete-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">🗑 Delete Tenant</div>
      <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
    </div>
    <div class="delete-warning">⚠️ This action cannot be undone. The tenant record will be permanently removed.</div>
    <p style="font-size:.9rem;color:var(--ink-muted);">Are you sure you want to delete <strong id="delete-name" style="color:var(--ink);"></strong>?</p>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
      <button class="btn-submit" style="background:var(--red);" onclick="confirmDelete()">Delete</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
  // ── DATA ──
  let tenants = [
    { id:'R304-01', name:'Maria Ramos',    room:'304', date:'2026-01-10', bill:300.00, contact:'0912-345-6789', status:'Pending'  },
    { id:'R105-02', name:'Juana Dela Cruz',room:'105', date:'2025-12-28', bill:0.00,   contact:'0923-456-7890', status:'Active'   },
    { id:'R302-02', name:'Angela Reyes',   room:'302', date:'2025-11-21', bill:220.00, contact:'0934-567-8901', status:'Pending'  },
    { id:'R202-01', name:'Rosa Bautista',  room:'202', date:'2025-11-05', bill:0.00,   contact:'0945-678-9012', status:'Move-Out' },
    { id:'R301-01', name:'Kristen Rodis',  room:'301', date:'2025-10-28', bill:150.00, contact:'0956-789-0123', status:'Pending'  },
    { id:'R105-03', name:'Neri Carpio',    room:'105', date:'2025-10-20', bill:110.00, contact:'0967-890-1234', status:'Inactive' },
    { id:'R102-03', name:'Jane Sta. Ana',  room:'102', date:'2025-09-21', bill:0.00,   contact:'0978-901-2345', status:'Active'   },
    { id:'R202-01', name:'Mae Abad',       room:'202', date:'2025-09-10', bill:0.00,   contact:'0989-012-3456', status:'Pending'  },
    { id:'R401-01', name:'Luz Santos',     room:'401', date:'2025-08-15', bill:80.00,  contact:'0991-123-4567', status:'Active'   },
    { id:'R303-02', name:'Clara Vidal',    room:'303', date:'2025-07-22', bill:0.00,   contact:'0992-234-5678', status:'Active'   },
    { id:'R201-01', name:'Donna Cruz',     room:'201', date:'2025-06-30', bill:200.00, contact:'0993-345-6789', status:'Pending'  },
    { id:'R403-01', name:'Ella Mateo',     room:'403', date:'2025-05-18', bill:0.00,   contact:'0994-456-7890', status:'Active'   },
  ];

  const PER_PAGE = 8;
  let currentPage = 1;
  let filtered = [...tenants];
  let editIndex = -1;
  let deleteIndex = -1;

  // ── BADGE ──
  function badge(status) {
    const map = {
      Active: 'badge-active', Pending: 'badge-pending',
      Inactive: 'badge-inactive', 'Move-Out': 'badge-moveout'
    };
    return `<span class="badge ${map[status]||'badge-pending'}">${status}</span>`;
  }

  // ── FORMAT DATE ──
  function fmtDate(d) {
    if (!d) return '—';
    const dt = new Date(d + 'T00:00:00');
    return dt.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
  }

  // ── RENDER TABLE ──
  function renderTable() {
    const start = (currentPage - 1) * PER_PAGE;
    const pageData = filtered.slice(start, start + PER_PAGE);
    const tbody = document.getElementById('tenant-tbody');

    if (pageData.length === 0) {
      tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>`;
    } else {
      tbody.innerHTML = pageData.map((t, i) => {
        const realIdx = tenants.indexOf(t);
        return `<tr>
          <td class="td-id">${t.id}</td>
          <td class="td-name">${t.name}</td>
          <td>${t.room}</td>
          <td>${fmtDate(t.date)}</td>
          <td>${t.bill > 0 ? '₱' + t.bill.toFixed(2) : '0.00'}</td>
          <td>${t.contact}</td>
          <td>${badge(t.status)}</td>
          <td>
            <div class="action-group">
              <button class="act-btn" title="View" onclick="viewTenant(${realIdx})">👁</button>
              <button class="act-btn" title="Edit" onclick="openEditModal(${realIdx})">✏️</button>
              <button class="act-btn delete" title="Delete" onclick="openDeleteModal(${realIdx})">🗑</button>
            </div>
          </td>
        </tr>`;
      }).join('');
    }

    // showing label
    const total = filtered.length;
    const from  = total === 0 ? 0 : start + 1;
    const to    = Math.min(start + PER_PAGE, total);
    document.getElementById('showing-label').textContent = `Showing data ${from} to ${to} of ${total} entries`;

    renderPagination();
    updateStats();
  }

  // ── PAGINATION ──
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

  // ── SEARCH ──
  function filterTable() {
    const q = document.getElementById('search-input').value.toLowerCase();
    filtered = tenants.filter(t =>
      t.name.toLowerCase().includes(q) ||
      t.id.toLowerCase().includes(q) ||
      t.room.toLowerCase().includes(q) ||
      t.contact.toLowerCase().includes(q) ||
      t.status.toLowerCase().includes(q)
    );
    currentPage = 1;
    renderTable();
  }

  // ── SORT ──
  function sortTable() {
    const val = document.getElementById('sort-select').value;
    if (val === 'newest') filtered.sort((a,b) => new Date(b.date) - new Date(a.date));
    if (val === 'oldest') filtered.sort((a,b) => new Date(a.date) - new Date(b.date));
    if (val === 'name')   filtered.sort((a,b) => a.name.localeCompare(b.name));
    if (val === 'room')   filtered.sort((a,b) => a.room.localeCompare(b.room));
    currentPage = 1;
    renderTable();
  }

  // ── STATS ──
  function updateStats() {
    document.getElementById('count-total').textContent   = tenants.length;
    document.getElementById('count-pending').textContent = tenants.filter(t=>t.status==='Pending').length;
  }

  // ── VIEW ──
  function viewTenant(i) {
    const t = tenants[i];
    editIndex = i;
    document.getElementById('view-content').innerHTML = `
      <div class="view-row"><span class="view-label">Account ID</span><span class="view-val">${t.id}</span></div>
      <div class="view-row"><span class="view-label">Tenant Name</span><span class="view-val">${t.name}</span></div>
      <div class="view-row"><span class="view-label">Room No.</span><span class="view-val">${t.room}</span></div>
      <div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">${fmtDate(t.date)}</span></div>
      <div class="view-row"><span class="view-label">Pending Bill</span><span class="view-val">₱${t.bill.toFixed(2)}</span></div>
      <div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">${t.contact}</span></div>
      <div class="view-row"><span class="view-label">Status</span><span class="view-val">${badge(t.status)}</span></div>
    `;
    openModal('view-modal');
  }

  function openEdit() { openEditModal(editIndex); }

  // ── EDIT ──
  function openEditModal(i) {
    editIndex = i;
    const t = tenants[i];
    document.getElementById('edit-name').value    = t.name;
    document.getElementById('edit-room').value    = t.room;
    document.getElementById('edit-date').value    = t.date;
    document.getElementById('edit-contact').value = t.contact;
    document.getElementById('edit-bill').value    = t.bill;
    document.getElementById('edit-status').value  = t.status;
    openModal('edit-modal');
  }

  function saveEdit() {
    const name    = document.getElementById('edit-name').value.trim();
    const room    = document.getElementById('edit-room').value.trim();
    const date    = document.getElementById('edit-date').value;
    const contact = document.getElementById('edit-contact').value.trim();
    const bill    = parseFloat(document.getElementById('edit-bill').value) || 0;
    const status  = document.getElementById('edit-status').value;
    if (!name || !room) { showToast('Name and Room are required.', 'error'); return; }
    tenants[editIndex] = { ...tenants[editIndex], name, room, date, contact, bill, status };
    filtered = [...tenants];
    filterTable();
    closeModal('edit-modal');
    showToast('✅ Tenant updated successfully!', 'success');
  }

  // ── ADD ──
  function addTenant() {
    const name    = document.getElementById('add-name').value.trim();
    const room    = document.getElementById('add-room').value.trim();
    const date    = document.getElementById('add-date').value;
    const contact = document.getElementById('add-contact').value.trim();
    const bill    = parseFloat(document.getElementById('add-bill').value) || 0;
    const status  = document.getElementById('add-status').value;
    if (!name || !room) { showToast('Name and Room are required.', 'error'); return; }
    const newId = 'R' + room.padStart(3,'0') + '-0' + (Math.floor(Math.random()*9)+1);
    tenants.unshift({ id:newId, name, room, date, contact, bill, status });
    filtered = [...tenants];
    currentPage = 1;
    renderTable();
    closeModal('add-modal');
    ['add-name','add-room','add-date','add-contact','add-bill'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('add-status').value = 'Active';
    showToast('✅ Tenant added successfully!', 'success');
  }

  // ── DELETE ──
  function openDeleteModal(i) {
    deleteIndex = i;
    document.getElementById('delete-name').textContent = tenants[i].name;
    openModal('delete-modal');
  }
  function confirmDelete() {
    tenants.splice(deleteIndex, 1);
    filtered = [...tenants];
    if ((currentPage-1)*PER_PAGE >= filtered.length && currentPage > 1) currentPage--;
    renderTable();
    closeModal('delete-modal');
    showToast('🗑 Tenant deleted.', '');
  }

  // ── EXPORT ──
  function exportTenants() {
    const rows = [['Account ID','Tenant Name','Room No.','Move-In Date','Pending Bill','Contact No.','Status']];
    tenants.forEach(t => rows.push([t.id, t.name, t.room, t.date, t.bill.toFixed(2), t.contact, t.status]));
    const csv  = rows.map(r => r.join(',')).join('\n');
    const blob = new Blob([csv], {type:'text/csv'});
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
    a.download = 'dormease-tenants.csv'; a.click();
    showToast('📥 Tenants exported as CSV!', 'success');
  }

  // ── MODALS ──
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
  });

  // ── TOAST ──
  function showToast(msg, type='') {
    const t = document.getElementById('toast');
    t.textContent = msg; t.className = 'toast ' + type;
    setTimeout(()=> t.classList.add('show'), 10);
    setTimeout(()=> t.classList.remove('show'), 3200);
  }

  // ── INIT ──
  document.getElementById('table-date').textContent =
    'as of ' + new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'});
  filtered = [...tenants];
  renderTable();
</script>
</body>
</html>