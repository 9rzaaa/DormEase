<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DormEase — Dashboard</title>
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
      --pink-50:    #fdf2f6;
      --pink-100:   #fce4ec;
      --pink-200:   #f8bbd0;
      --pink-400:   #f06292;
      --pink-500:   #ec407a;
      --pink-600:   #d81b60;
      --ease:       all .2s cubic-bezier(.4,0,.2,1);
      --border:     rgba(202,93,134,.12);
      --shadow:     0 2px 16px rgba(202,93,134,.08);
      --ff-display: 'DM Serif Display', Georgia, serif;
      --ff-body:    'DM Sans', sans-serif;
      --sidebar-w:  260px;
      --topbar-h:   0px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: var(--ff-body); background: var(--pink-bg); color: var(--ink); display: flex; min-height: 100vh; overflow-x: hidden; }
    a { text-decoration: none; color: inherit; }
    button { font-family: var(--ff-body); cursor: pointer; }

    .sidebar {
      width: var(--sidebar-w);
      background: var(--white);
      display: flex; flex-direction: column;
      position: fixed; top: 0; left: 0; bottom: 0;
      z-index: 100;
      border-right: 1px solid var(--border);
      box-shadow: 2px 0 20px rgba(202,93,134,.06);
      transition: transform .3s ease;
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
    .sidebar-logo-text {
      font-family: var(--ff-display); font-size: 1.3rem;
      font-weight: 700; color: var(--ink); letter-spacing: -.01em;
    }
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
    .nav-item.active .nav-icon { color: var(--pink); }
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

    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

    .topbar {
      position: sticky; top: 0; z-index: 50;
      background: var(--white); border-bottom: 1px solid var(--border);
      padding: .85rem 2rem;
      display: flex; align-items: center; justify-content: space-between;
    }
    .breadcrumb { font-size: .8rem; color: var(--ink-muted); }
    .breadcrumb span { color: var(--pink); font-weight: 600; }
    .topbar-right { display: flex; align-items: center; gap: 1rem; }
    .notif-bell {
      width: 36px; height: 36px; border-radius: 50%;
      background: var(--pink-50); border: 1.5px solid var(--pink-100);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 16px; position: relative; transition: var(--ease);
    }
    .notif-bell:hover { background: var(--pink-100); }
    .notif-badge {
      position: absolute; top: -3px; right: -3px;
      width: 16px; height: 16px; background: var(--pink-500);
      border-radius: 50%; font-size: 9px; color: #fff; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      border: 2px solid #fff;
    }
    .avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: linear-gradient(135deg, var(--pink-400), var(--pink-600));
      border: 2px solid var(--pink-200);
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; font-weight: 700; color: #fff; cursor: pointer;
    }

    .page-body {
      display: grid; grid-template-columns: 1fr 280px;
      gap: 1.5rem; padding: 1.8rem 2rem; flex: 1;
    }
    .content-col { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }
    .page-header { margin-bottom: .25rem; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }

    .card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); padding: 1.5rem; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .card-title { font-size: 1.05rem; font-weight: 700; color: var(--ink); }
    .card-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .15rem; }
    .see-all { font-size: .8rem; font-weight: 600; color: var(--pink); background: none; border: none; cursor: pointer; transition: opacity .2s; }
    .see-all:hover { opacity: .7; }

    .export-btn {
      display: flex; align-items: center; gap: .4rem;
      padding: .45rem 1rem; border-radius: 8px;
      border: 1.5px solid var(--gray-light); background: var(--white);
      font-size: .82rem; font-weight: 600; color: var(--ink-muted);
      transition: border-color .2s, color .2s;
    }
    .export-btn:hover { border-color: var(--pink); color: var(--pink); }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-top: 1rem; }
    .stat-box {
      background: var(--pink-card); border-radius: 12px; padding: 1.1rem;
      border: 1px solid rgba(202,93,134,.1); transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(202,93,134,.14); }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(202,93,134,.18); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: .8rem; }
    .stat-num { font-size: 1.8rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.02em; }
    .stat-label { font-size: .85rem; font-weight: 600; color: var(--ink); margin-top: .3rem; }
    .stat-sub { font-size: .75rem; color: var(--pink); font-weight: 500; margin-top: .15rem; }

    .bottom-row { display: grid; grid-template-columns: 1fr 260px; gap: 1.2rem; }

    .maint-row {
      display: flex; align-items: center; gap: 1rem;
      padding: .9rem .5rem; border-bottom: 1px solid var(--border);
      cursor: pointer; transition: background .15s; border-radius: 8px;
    }
    .maint-row:last-child { border-bottom: none; }
    .maint-row:hover { background: var(--pink-bg); }
    .maint-type-icon { width: 38px; height: 38px; border-radius: 10px; background: var(--pink-card); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .maint-info { flex: 1; min-width: 0; }
    .maint-title { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .maint-id { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; }
    .maint-desc-col { flex: 1; min-width: 0; }
    .maint-desc { font-size: .83rem; color: var(--ink); font-weight: 500; }
    .maint-tags { display: flex; gap: .35rem; margin-top: .3rem; flex-wrap: wrap; }
    .tag { font-size: .7rem; font-weight: 600; padding: .18rem .55rem; border-radius: 5px; border: 1.5px solid; }
    .tag-urgent   { color: var(--red);    border-color: var(--red);        background: #fff0f0; }
    .tag-moderate { color: var(--salmon); border-color: var(--salmon);     background: #fff6f2; }
    .tag-low      { color: var(--green);  border-color: var(--green);      background: #f0fdf8; }
    .tag-progress { color: var(--pink);   border-color: var(--pink-light); background: var(--pink-card); }
    .tag-pending  { color: var(--salmon); border-color: var(--peach);      background: #fff8f4; }
    .maint-assign { font-size: .82rem; color: var(--ink-muted); white-space: nowrap; flex-shrink: 0; }
    .maint-arrow  { color: var(--gray); font-size: .9rem; flex-shrink: 0; }

    .empty-state { text-align: center; padding: 2rem; color: var(--ink-muted); font-size: .88rem; }

    .emergency-card {
      background: var(--pink-card); border: 1.5px solid var(--pink-light);
      border-radius: 16px; padding: 1.4rem;
      display: flex; flex-direction: column; align-items: center; text-align: center; gap: .6rem;
    }
    .emergency-title { font-size: 1rem; font-weight: 700; color: var(--ink); }
    .emergency-icon-wrap { width: 70px; height: 70px; border-radius: 50%; border: 3px solid var(--ink); background: var(--white); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: .4rem 0; }
    .emergency-room { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .emergency-type { font-size: .82rem; font-weight: 600; color: var(--pink); }
    .emergency-status { font-size: .78rem; color: var(--ink-muted); font-style: italic; }
    .emergency-btn { margin-top: .5rem; width: 100%; background: var(--pink); color: var(--white); border: none; border-radius: 10px; padding: .65rem; font-size: .85rem; font-weight: 700; cursor: pointer; transition: background .2s, transform .15s; }
    .emergency-btn:hover { background: #a8446c; transform: translateY(-1px); }

    .announce-item { padding: .9rem 0; border-bottom: 1px solid var(--border); }
    .announce-item:last-child { border-bottom: none; padding-bottom: 0; }
    .announce-title { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .announce-date { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .announce-actions { display: flex; gap: .5rem; margin-top: .5rem; }
    .announce-action-btn { font-size: .75rem; font-weight: 600; padding: .28rem .7rem; border-radius: 6px; border: 1.5px solid var(--border); background: none; color: var(--ink-muted); cursor: pointer; transition: border-color .2s, color .2s; }
    .announce-action-btn:hover { border-color: var(--pink); color: var(--pink); }
    .post-announce-btn { font-size: .8rem; font-weight: 600; color: var(--pink); background: none; border: none; cursor: pointer; }
    .post-announce-btn:hover { text-decoration: underline; }

    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .right-col .card h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: .9rem; }

    .notif-item { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem 0; border-bottom: 1px solid var(--border); cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-ico { font-size: 1rem; flex-shrink: 0; margin-top: .1rem; }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    .activity-item { display: flex; align-items: flex-start; gap: .75rem; padding: .6rem 0; border-bottom: 1px solid var(--border); }
    .activity-item:last-child { border-bottom: none; }
    .activity-avatar { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; background: linear-gradient(135deg, var(--pink-light), var(--pink)); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; color: var(--white); }
    .activity-text { font-size: .8rem; color: var(--ink); line-height: 1.4; }
    .activity-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { opacity:0; animation: fadeUp .5s ease forwards; }
    .d1 { animation-delay:.05s; } .d2 { animation-delay:.12s; }
    .d3 { animation-delay:.19s; } .d4 { animation-delay:.26s; }
    .d5 { animation-delay:.33s; } .d6 { animation-delay:.40s; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(26,26,46,.45); backdrop-filter: blur(4px); z-index: 300; display: none; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal { background: var(--white); border-radius: 20px; padding: 2rem; width: 90%; max-width: 440px; box-shadow: 0 20px 60px rgba(26,26,46,.2); animation: fadeUp .3s ease; }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .modal-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
    .modal-field { margin-bottom: 1rem; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .35rem; }
    .modal-field input, .modal-field select, .modal-field textarea { width: 100%; padding: .65rem .9rem; border-radius: 10px; border: 1.5px solid var(--gray-light); font-family: var(--ff-body); font-size: .88rem; color: var(--ink); background: #fafafa; outline: none; transition: border-color .2s; }
    .modal-field input:focus, .modal-field select:focus, .modal-field textarea:focus { border-color: var(--pink); }
    .modal-field textarea { resize: vertical; min-height: 80px; }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.4rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; transition: background .2s; }
    .btn-submit:hover { background: #a8446c; }

    .alert-item { border-radius: 12px; padding: 1rem; border: 1px solid; margin-bottom: .8rem; }
    .alert-item.active   { background: #fff0f0; border-color: var(--blush); }
    .alert-item.resolved { background: #f0fdf8; border-color: var(--mint); }
    .alert-room   { font-weight: 700; font-size: .9rem; }
    .alert-status { font-size: .8rem; color: var(--ink-muted); margin-top: .2rem; }

    .toast { position: fixed; bottom: 2rem; right: 2rem; z-index: 400; background: var(--ink); color: var(--white); padding: .85rem 1.4rem; border-radius: 12px; font-size: .87rem; font-weight: 500; box-shadow: 0 8px 24px rgba(26,26,46,.25); transform: translateY(80px); opacity: 0; transition: transform .35s ease, opacity .35s ease; display: flex; align-items: center; gap: .6rem; }
    .toast.show    { transform: translateY(0); opacity: 1; }
    .toast.success { background: var(--green); }
    .toast.error   { background: var(--red); }

    @media (max-width: 1100px) {
      .stats-grid { grid-template-columns: repeat(2,1fr); }
      .page-body { grid-template-columns: 1fr; }
      .right-col { display: grid; grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 820px) {
      :root { --sidebar-w: 0px; }
      .sidebar { transform: translateX(-260px); width: 260px; }
      .sidebar.open { transform: translateX(0); }
      .main { margin-left: 0; }
      .bottom-row { grid-template-columns: 1fr; }
      .right-col { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="sidebar-logo-icon">🏠</div>
    <div class="sidebar-logo-text">Dorm<em>Ease</em></div>
  </div>
  <div class="sidebar-role">👤 Admin</div>
  <nav class="sidebar-nav">
    <a href="{{ route('dashboard') }}" class="nav-item active"><span class="nav-icon">🏠</span> Dashboard</a>
    <a href="{{ route('tenants') }}" class="nav-item"><span class="nav-icon">👥</span> Manage Tenants</a>
    <a href="/documents" class="nav-item"><span class="nav-icon">📄</span> Document Management</a>
    <a href="/emergency" class="nav-item"><span class="nav-icon">🚨</span> Emergency Reports</a>
    <a href="/maintenance" class="nav-item"><span class="nav-icon">🔧</span> Maintenance Requests</a>
    <a href="/billing" class="nav-item"><span class="nav-icon">💧</span> Water Billing</a>
    <a href="/visitors" class="nav-item"><span class="nav-icon">🚪</span> Visitor Logs</a>
    <a href="/announcements" class="nav-item"><span class="nav-icon">📢</span> Announcements</a>
    <div class="nav-divider"></div>
    <a href="/staff" class="nav-item"><span class="nav-icon">🧑‍💼</span> Manage Staff</a>
    <a href="/settings" class="nav-item"><span class="nav-icon">⚙️</span> Settings</a>
  </nav>
  <div class="sidebar-logout">
    <form method="POST" action="/logout" id="logout-form">@csrf</form>
    <button class="logout-btn" onclick="openModal('logout-modal')">
      <span class="nav-icon">🔓</span> Log Out
    </button>
  </div>
</aside>

<div class="main">

  <header class="topbar">
    <div class="breadcrumb">Pages / <span>Dashboard</span></div>
    <div class="topbar-right">
      <div class="notif-bell" onclick="toggleNotifPanel()" title="Notifications">
        🔔
        @if($unreadNotifCount > 0)
          <span class="notif-badge">{{ $unreadNotifCount }}</span>
        @endif
      </div>
      <div class="avatar" title="{{ $staff->first_name }}">
        {{ strtoupper(substr($staff->first_name, 0, 1)) }}
      </div>
    </div>
  </header>

  <div class="page-body">

    <div class="content-col">

      <div class="page-header fade-up d1">
        <h1>Welcome, {{ $staff->first_name }}!</h1>
        <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
      </div>

      <div class="card fade-up d2">
        <div class="card-header">
          <div>
            <div class="card-title">Quick Summary</div>
            <div class="card-sub">As of {{ now()->format('F d, Y') }}</div>
          </div>
          <button class="export-btn" onclick="exportSummary()">⬇ Export</button>
        </div>
        <div class="stats-grid">
          <div class="stat-box">
            <div class="stat-icon">👥</div>
            <div class="stat-num">{{ $totalTenants }}</div>
            <div class="stat-label">Total Tenants</div>
            <div class="stat-sub">Currently Registered</div>
          </div>
          <div class="stat-box">
            <div class="stat-icon">💳</div>
            <div class="stat-num">{{ $pendingPayments }}</div>
            <div class="stat-label">Pending Payments</div>
            <div class="stat-sub">Unsettled water charges</div>
          </div>
          <div class="stat-box">
            <div class="stat-icon">🔧</div>
            <div class="stat-num">{{ $pendingMaintenance }}</div>
            <div class="stat-label">Maintenance Requests</div>
            <div class="stat-sub">Pending &amp; in progress</div>
          </div>
          <div class="stat-box">
            <div class="stat-icon">⚠️</div>
            <div class="stat-num">{{ $unresolvedReports }}</div>
            <div class="stat-label">Unresolved Reports</div>
            <div class="stat-sub">Ongoing concerns</div>
          </div>
        </div>
      </div>

      <div class="bottom-row fade-up d3">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Maintenance Requests</div>
            <a href="/maintenance" class="see-all">See All</a>
          </div>
          @if($maintenanceRequests->isEmpty())
            <div class="empty-state">No pending maintenance requests.</div>
          @else
            @foreach($maintenanceRequests as $req)
              <div class="maint-row">
                <div class="maint-type-icon">
                  @if(str_contains(strtolower($req->issue_type ?? ''), 'plumb')) 🔧
                  @elseif(str_contains(strtolower($req->issue_type ?? ''), 'elec')) ⚡
                  @elseif(str_contains(strtolower($req->issue_type ?? ''), 'hvac')) ❄️
                  @else 🛠
                  @endif
                </div>
                <div class="maint-info">
                  <div class="maint-title">
                    {{ $req->issue_type }}@if($req->tenant) | {{ $req->tenant->room_number }}@endif
                  </div>
                  <div class="maint-id">Request ID: REQ-{{ str_pad($req->request_id, 3, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="maint-desc-col">
                  <div class="maint-desc">{{ $req->description }}</div>
                  <div class="maint-tags">
                    @php
                      $urgencyClass = match(strtolower($req->urgency_level ?? '')) {
                        'urgent'   => 'tag-urgent',
                        'moderate' => 'tag-moderate',
                        default    => 'tag-low',
                      };
                      $statusClass = match(strtolower($req->status ?? '')) {
                        'in_progress' => 'tag-progress',
                        default       => 'tag-pending',
                      };
                    @endphp
                    <span class="tag {{ $urgencyClass }}">{{ ucfirst($req->urgency_level) }}</span>
                    <span class="tag {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span>
                  </div>
                </div>
                <div class="maint-assign">{{ $req->assigned_to ?? 'Unassigned' }}</div>
                <div class="maint-arrow">›</div>
              </div>
            @endforeach
          @endif
        </div>

        @if($latestEmergency)
          <div class="emergency-card">
            <div class="emergency-title">Emergency Report</div>
            <div class="emergency-icon-wrap">⚠️</div>
            <div class="emergency-room">{{ $latestEmergency->location ?? 'Unknown Location' }}:</div>
            <div class="emergency-type">{{ $latestEmergency->emergency_type }}</div>
            <div class="emergency-status">{{ $latestEmergency->status }}</div>
            <button class="emergency-btn" onclick="openModal('emergency-modal')">View All Alerts</button>
          </div>
        @else
          <div class="emergency-card" style="opacity:.65;">
            <div class="emergency-title">Emergency Reports</div>
            <div class="emergency-icon-wrap">✅</div>
            <div class="emergency-type" style="color:var(--green);">All Clear</div>
            <div class="emergency-status">No active emergencies</div>
            <button class="emergency-btn" style="background:var(--green);" onclick="openModal('emergency-modal')">View History</button>
          </div>
        @endif
      </div>

      <div class="card fade-up d4">
        <div class="card-header">
          <div class="card-title">Latest Announcements</div>
          <div style="display:flex;gap:.8rem;align-items:center;">
            <button class="post-announce-btn" onclick="openModal('announce-modal')">Post Announcement</button>
            <span style="color:var(--gray);font-size:.8rem;">|</span>
            <a href="/announcements" class="see-all">See All</a>
          </div>
        </div>
        @if($announcements->isEmpty())
          <div class="empty-state">No announcements yet.</div>
        @else
          @foreach($announcements as $ann)
            <div class="announce-item">
              <div class="announce-title">{{ $ann->title }}</div>
              <div class="announce-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F d, Y') }}</div>
              <div class="announce-actions">
                <button class="announce-action-btn">Edit</button>
                <button class="announce-action-btn">Delete</button>
              </div>
            </div>
          @endforeach
        @endif
      </div>

    </div>

    <div class="right-col fade-up d5">

      <div class="card">
        <h3>Notifications</h3>
        @if($notifications->isEmpty())
          <div class="empty-state" style="padding:1rem 0;">No new notifications.</div>
        @else
          @foreach($notifications as $notif)
            <div class="notif-item">
              <div class="notif-ico">
                @if($notif->type === 'emergency') 🚨
                @elseif($notif->type === 'maintenance') 🔧
                @elseif($notif->type === 'visitor') 🚪
                @elseif($notif->type === 'tenant') 👤
                @else 🔔
                @endif
              </div>
              <div>
                <div class="notif-text">{{ $notif->message }}</div>
                <div class="notif-time">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

      <div class="card">
        <h3>Activities</h3>
        @if($recentActivities->isEmpty())
          <div class="empty-state" style="padding:1rem 0;">No recent activity.</div>
        @else
          @foreach($recentActivities as $log)
            <div class="activity-item">
              <div class="activity-avatar">
                {{ strtoupper(substr($log->visitor_name ?? 'A', 0, 1)) }}
              </div>
              <div>
                <div class="activity-text">
                  Visitor {{ $log->visitor_name }} logged {{ $log->departure_time ? 'out' : 'in' }}
                  @if($log->tenant) for {{ $log->tenant->first_name }} {{ $log->tenant->last_name }}@endif
                </div>
                <div class="activity-time">{{ \Carbon\Carbon::parse($log->arrival_time)->diffForHumans() }}</div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

    </div>

  </div>
</div>

<div class="modal-overlay" id="announce-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">📢 Post Announcement</div>
      <button class="modal-close" onclick="closeModal('announce-modal')">✕</button>
    </div>
    <div class="modal-field">
      <label>Title</label>
      <input type="text" id="ann-title" placeholder="e.g. Water Billing Reminder">
    </div>
    <div class="modal-field">
      <label>Message</label>
      <textarea id="ann-body" placeholder="Write your announcement here..."></textarea>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('announce-modal')">Cancel</button>
      <button class="btn-submit">Post</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="emergency-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">🚨 Emergency Alerts</div>
      <button class="modal-close" onclick="closeModal('emergency-modal')">✕</button>
    </div>
    <div style="display:flex;flex-direction:column;gap:.8rem;">
      @if($allEmergencies->isEmpty())
        <p style="color:var(--ink-muted);font-size:.88rem;">No emergency reports found.</p>
      @else
        @foreach($allEmergencies as $emergency)
          <div class="alert-item {{ $emergency->status === 'resolved' ? 'resolved' : 'active' }}">
            <div class="alert-room">{{ $emergency->location ?? 'Unknown' }}: {{ $emergency->emergency_type }}</div>
            <div class="alert-status">
              {{ $emergency->status === 'resolved' ? '✅ Resolved' : $emergency->status }}
            </div>
          </div>
        @endforeach
      @endif
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('emergency-modal')">Close</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="logout-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Log Out</div>
      <button class="modal-close" onclick="closeModal('logout-modal')">✕</button>
    </div>
    <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;">Are you sure you want to log out of DormEase?</p>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('logout-modal')">Cancel</button>
      <button class="btn-submit" onclick="document.getElementById('logout-form').submit()" style="background:var(--red);">Log Out</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }

  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
  });

  function toggleNotifPanel() {
    document.querySelector('.right-col').scrollIntoView({ behavior: 'smooth' });
  }

  function exportSummary() {
    const rows = [
      ['Metric', 'Value'],
      ['Total Tenants',        '{{ $totalTenants }}'],
      ['Pending Payments',     '{{ $pendingPayments }}'],
      ['Maintenance Requests', '{{ $pendingMaintenance }}'],
      ['Unresolved Reports',   '{{ $unresolvedReports }}'],
    ];
    const csv  = rows.map(r => r.join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'dormease-summary.csv';
    a.click();
    showToast('📥 Summary exported as CSV!', 'success');
  }

  function showToast(msg, type = '') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className   = 'toast ' + type;
    setTimeout(() => t.classList.add('show'),    10);
    setTimeout(() => t.classList.remove('show'), 3200);
  }
</script>
</body>
</html>