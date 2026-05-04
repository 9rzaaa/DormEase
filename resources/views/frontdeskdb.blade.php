<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DormEase — Front Desk Dashboard</title>
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
    .topbar-right { display: flex; align-items: center; gap: .8rem; }
    .notif-btn {
      position: relative; background: none; border: none;
      font-size: 1.2rem; color: var(--ink-muted); cursor: pointer;
      padding: .3rem; transition: color .2s;
    }
    .notif-btn:hover { color: var(--pink); }
    .notif-badge {
      position: absolute; top: 0; right: 0;
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--red); border: 2px solid var(--white);
    }
    /* chat icon */
    .chat-btn {
      position: relative; background: none; border: none;
      font-size: 1.2rem; color: var(--ink-muted); cursor: pointer;
      padding: .3rem; transition: color .2s;
    }
    .chat-btn:hover { color: var(--pink); }
    .chat-badge {
      position: absolute; top: 0; right: 0;
      width: 16px; height: 16px; border-radius: 50%;
      background: var(--pink); border: 2px solid var(--white);
      font-size: .6rem; font-weight: 700; color: var(--white);
      display: flex; align-items: center; justify-content: center;
    }
    .avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: linear-gradient(135deg, var(--salmon), var(--pink));
      display: flex; align-items: center; justify-content: center;
      font-size: .85rem; font-weight: 700; color: var(--white);
      cursor: pointer; border: 2px solid var(--pink-light);
    }

    /* PAGE BODY */
    .page-body {
      display: grid;
      grid-template-columns: 1fr 280px;
      gap: 1.5rem;
      padding: 1.8rem 2rem;
      flex: 1;
    }
    .content-col { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }

    /* PAGE HEADER */
    .page-header { margin-bottom: .25rem; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }

    /* CARD */
    .card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); padding: 1.5rem; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .card-title { font-size: 1.05rem; font-weight: 700; color: var(--ink); }
    .card-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .15rem; }
    .see-all { font-size: .8rem; font-weight: 600; color: var(--pink); background: none; border: none; cursor: pointer; transition: opacity .2s; }
    .see-all:hover { opacity: .7; }

    /* EXPORT BTN */
    .export-btn {
      display: flex; align-items: center; gap: .4rem;
      padding: .45rem 1rem; border-radius: 8px;
      border: 1.5px solid var(--gray-light); background: var(--white);
      font-size: .82rem; font-weight: 600; color: var(--ink-muted);
      transition: border-color .2s, color .2s;
    }
    .export-btn:hover { border-color: var(--pink); color: var(--pink); }

    /* STATS GRID */
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-top: 1rem; }
    .stat-box {
      background: var(--pink-card); border-radius: 12px; padding: 1.1rem;
      border: 1px solid rgba(202,93,134,.1);
      transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(202,93,134,.14); }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(202,93,134,.18); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: .8rem; }
    .stat-num { font-size: 1.8rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.02em; }
    .stat-label { font-size: .85rem; font-weight: 600; color: var(--ink); margin-top: .3rem; }
    .stat-sub { font-size: .75rem; color: var(--pink); font-weight: 500; margin-top: .15rem; }

    /* BOTTOM ROW */
    .bottom-row { display: grid; grid-template-columns: 1fr 260px; gap: 1.2rem; }

    /* RECENT ACTIVITY */
    .activity-row {
      display: flex; align-items: center;
      padding: .95rem 0; border-bottom: 1px solid var(--border);
      cursor: pointer; border-radius: 8px; padding-left: .5rem; padding-right: .5rem;
      transition: background .15s;
    }
    .activity-row:last-child { border-bottom: none; }
    .activity-row:hover { background: var(--pink-bg); }
    .activity-text { flex: 1; }
    .activity-title { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .activity-time { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .activity-arrow { color: var(--gray); font-size: .9rem; flex-shrink: 0; }

    /* EMERGENCY CARD */
    .emergency-card {
      background: var(--pink-card); border: 1.5px solid var(--pink-light);
      border-radius: 16px; padding: 1.4rem;
      display: flex; flex-direction: column; align-items: center;
      text-align: center; gap: .6rem;
    }
    .emergency-title { font-size: 1rem; font-weight: 700; color: var(--ink); }
    .emergency-icon-wrap {
      width: 70px; height: 70px; border-radius: 50%;
      border: 3px solid var(--ink); background: var(--white);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.8rem; margin: .4rem 0;
    }
    .emergency-room { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .emergency-type { font-size: .82rem; font-weight: 600; color: var(--pink); }
    .emergency-status { font-size: .78rem; color: var(--ink-muted); font-style: italic; }
    .emergency-btn {
      margin-top: .5rem; width: 100%;
      background: var(--pink); color: var(--white);
      border: none; border-radius: 10px;
      padding: .65rem; font-size: .85rem; font-weight: 700;
      cursor: pointer; transition: background .2s, transform .15s;
    }
    .emergency-btn:hover { background: #a8446c; transform: translateY(-1px); }

    /* ANNOUNCEMENTS */
    .announce-item { padding: .9rem 0; border-bottom: 1px solid var(--border); }
    .announce-item:last-child { border-bottom: none; padding-bottom: 0; }
    .announce-title { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .announce-date { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }

    /* RIGHT COLUMN */
    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .notif-section h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: .9rem; }
    .notif-item { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem 0; border-bottom: 1px solid var(--border); cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-ico { font-size: 1rem; flex-shrink: 0; margin-top: .1rem; }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    /* ANIMATIONS */
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse  { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .fade-up { opacity:0; animation: fadeUp .5s ease forwards; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.19s;} .d4{animation-delay:.26s;} .d5{animation-delay:.33s;}

    /* MODAL */
    .modal-overlay {
      position: fixed; inset: 0; background: rgba(26,26,46,.45);
      backdrop-filter: blur(4px); z-index: 300;
      display: none; align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
      background: var(--white); border-radius: 20px;
      padding: 2rem; width: 90%; max-width: 440px;
      box-shadow: 0 20px 60px rgba(26,26,46,.2);
      animation: fadeUp .3s ease;
      max-height: 90vh; overflow-y: auto;
    }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .modal-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
    .modal-close:hover { color: var(--red); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.4rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; transition: background .2s; }
    .btn-submit:hover { background: #a8446c; }

    /* Emergency alert items */
    .alert-item { background: #fff0f0; border-radius: 12px; padding: 1rem; border: 1px solid var(--blush); margin-bottom: .8rem; }
    .alert-item.resolved { background: #f0fdf8; border-color: var(--mint); }
    .alert-room { font-weight: 700; font-size: .9rem; }
    .alert-status { font-size: .8rem; color: var(--ink-muted); margin-top: .2rem; }
    .alert-resolve-btn { margin-top: .6rem; font-size: .78rem; font-weight: 600; padding: .3rem .8rem; border-radius: 7px; border: none; background: var(--green); color: var(--white); cursor: pointer; }

    /* TOAST */
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

    /* RESPONSIVE */
    @media(max-width:1100px) {
      .stats-grid { grid-template-columns: repeat(2,1fr); }
      .page-body { grid-template-columns: 1fr; }
      .right-col { display: grid; grid-template-columns: 1fr 1fr; }
    }
    @media(max-width:820px) {
      :root { --sidebar-w: 0px; }
      .sidebar { transform: translateX(-260px); width: 260px; }
      .main { margin-left: 0; }
      .bottom-row { grid-template-columns: 1fr; }
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
  <div class="sidebar-role">🧑‍💼 Front Desk</div>

  <nav class="sidebar-nav">
    <button class="nav-item active"><span class="nav-icon">🏠</span> Dashboard</button>
    <button class="nav-item" onclick="showToast('📄 Tenant Directory — coming soon!')"><span class="nav-icon">👤</span> Tenant Directory</button>
    <button class="nav-item" onclick="openModal('emergency-modal')"><span class="nav-icon">🚨</span> Emergency Reports</button>
    <button class="nav-item" onclick="showToast('📄 Visitor Logs — coming soon!')"><span class="nav-icon">🚪</span> Visitor Logs</button>
    <button class="nav-item" onclick="showToast('📄 Announcements — coming soon!')"><span class="nav-icon">📢</span> Announcements</button>
    <div class="nav-divider"></div>
    <button class="nav-item" onclick="showToast('📄 Settings — coming soon!')"><span class="nav-icon">⚙️</span> Settings</button>
  </nav>

  <div class="sidebar-logout">
    <form method="POST" action="/logout" id="logout-form">@csrf</form>
    <button class="logout-btn" onclick="openModal('logout-modal')">
      <span>↩</span> Log Out
    </button>
  </div>
</aside>

<!-- ══ MAIN ══ -->
<div class="main">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="breadcrumb">Pages / <span>Dashboard</span></div>
    <div class="topbar-right">
      <button class="notif-btn" title="Notifications">🔔<span class="notif-badge"></span></button>
      <button class="chat-btn" title="Messages">💬<span class="chat-badge">2</span></button>
      <div class="avatar" title="Erika">E</div>
    </div>
  </header>

  <!-- PAGE BODY -->
  <div class="page-body">

    <!-- MAIN COLUMN -->
    <div class="content-col">

      <!-- Page Header -->
      <div class="page-header fade-up d1">
        <h1>Welcome, Erika!</h1>
        <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
      </div>

      <!-- Quick Summary -->
      <div class="card fade-up d2">
        <div class="card-header">
          <div>
            <div class="card-title">Quick Summary</div>
            <div class="card-sub" id="summary-date"></div>
          </div>
          <button class="export-btn" onclick="exportSummary()">⬇ Export</button>
        </div>
        <div class="stats-grid">
          <div class="stat-box">
            <div class="stat-icon">👥</div>
            <div class="stat-num">67</div>
            <div class="stat-label">Total Tenants</div>
            <div class="stat-sub">Currently Registered</div>
          </div>
          <div class="stat-box">
            <div class="stat-icon">🛏</div>
            <div class="stat-num">36</div>
            <div class="stat-label">Units Occupied</div>
            <div class="stat-sub">Out of 40 available</div>
          </div>
          <div class="stat-box">
            <div class="stat-icon">🚪</div>
            <div class="stat-num" id="stat-visitors">12</div>
            <div class="stat-label">Visitors Today</div>
            <div class="stat-sub">0 currently inside</div>
          </div>
          <div class="stat-box">
            <div class="stat-icon">⚠️</div>
            <div class="stat-num" id="stat-emergencies">1</div>
            <div class="stat-label">Active Emergencies</div>
            <div class="stat-sub">Ongoing reports</div>
          </div>
        </div>
      </div>

      <!-- Recent Activity + Emergency -->
      <div class="bottom-row fade-up d3">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Recent Activity</div>
            <button class="see-all">See All</button>
          </div>
          <div id="activity-list"></div>
        </div>

        <div class="emergency-card">
          <div class="emergency-title">Emergency Report</div>
          <div class="emergency-icon-wrap">⚠️</div>
          <div class="emergency-room">Room 301:</div>
          <div class="emergency-type">Medical Emergency</div>
          <div class="emergency-status">Staff Responding Now</div>
          <button class="emergency-btn" onclick="openModal('emergency-modal')">View All Alerts</button>
        </div>
      </div>

      <!-- Latest Announcements -->
      <div class="card fade-up d4">
        <div class="card-header">
          <div class="card-title">Latest Announcements</div>
          <button class="see-all">See All</button>
        </div>
        <div id="announce-list"></div>
      </div>

    </div><!-- /content-col -->

    <!-- RIGHT COLUMN — Notifications -->
    <div class="right-col fade-up d5">
      <div class="card">
        <div class="notif-section">
          <h3>Notifications</h3>
          <div id="notif-list"></div>
        </div>
      </div>
    </div>

  </div><!-- /page-body -->
</div><!-- /main -->

<!-- ══ EMERGENCY MODAL ══ -->
<div class="modal-overlay" id="emergency-modal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">🚨 Emergency Alerts</div>
      <button class="modal-close" onclick="closeModal('emergency-modal')">✕</button>
    </div>
    <div id="emergency-list"></div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal('emergency-modal')">Close</button>
      <button class="btn-submit" onclick="markAllResolved()">Mark All Resolved</button>
    </div>
  </div>
</div>

<!-- ══ LOGOUT MODAL ══ -->
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

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
  // ── DATA ──
  const activityData = [
    { text:'Emergency reported at Room 301.',       time:'February 19, 2026, 5:27 PM' },
    { text:'You have logged out visitor Maricel Santos', time:'February 19, 2026, 1:19 PM' },
    { text:'You have logged in visitor Maricel Santos',  time:'February 19, 2026, 1:15 PM' },
  ];

  const announcementsData = [
    { title:'Water Billing Reminder: Due On The 28th', date:'February 18, 2026' },
    { title:'Curfew Reminder: Gates close at 10PM',   date:'February 15, 2026' },
    { title:'Dorm Inspection Scheduled — March 3',    date:'February 10, 2026' },
  ];

  const notifData = [
    { icon:'🚨', text:'Medical assistance needed at Room 301', time:'Just now' },
    { icon:'🚪', text:'New visitor registered',                time:'Today, 1:15 PM' },
    { icon:'🚪', text:'New visitor registered',                time:'Today, 12:45 PM' },
    { icon:'⚠️', text:'Room 103 triggered an emergency alert', time:'Today, 11:59 AM' },
  ];

  const emergencyData = [
    { room:'Room 301', type:'Medical Emergency',    status:'Staff Responding Now', resolved: false },
    { room:'Room 103', type:'Fire Alarm Triggered', status:'Under Investigation',  resolved: false },
  ];

  // ── RENDER ──
  function renderActivity() {
    document.getElementById('activity-list').innerHTML = activityData.map(a => `
      <div class="activity-row">
        <div class="activity-text">
          <div class="activity-title">${a.text}</div>
          <div class="activity-time">${a.time}</div>
        </div>
        <div class="activity-arrow">›</div>
      </div>`).join('');
  }

  function renderAnnouncements() {
    document.getElementById('announce-list').innerHTML = announcementsData.map(a => `
      <div class="announce-item">
        <div class="announce-title">${a.title}</div>
        <div class="announce-date">${a.date}</div>
      </div>`).join('');
  }

  function renderNotifications() {
    document.getElementById('notif-list').innerHTML = notifData.map(n => `
      <div class="notif-item">
        <div class="notif-ico">${n.icon}</div>
        <div>
          <div class="notif-text">${n.text}</div>
          <div class="notif-time">${n.time}</div>
        </div>
      </div>`).join('');
  }

  function renderEmergencies() {
    document.getElementById('emergency-list').innerHTML = emergencyData.map((e,i) => `
      <div class="alert-item ${e.resolved?'resolved':''}">
        <div class="alert-room">${e.room}: ${e.type}</div>
        <div class="alert-status">${e.resolved ? '✅ Resolved' : e.status}</div>
        ${!e.resolved ? `<button class="alert-resolve-btn" onclick="resolveEmergency(${i})">Mark Resolved</button>` : ''}
      </div>`).join('');
  }

  // ── EMERGENCY ──
  function resolveEmergency(i) {
    emergencyData[i].resolved = true;
    renderEmergencies();
    const count = emergencyData.filter(e => !e.resolved).length;
    document.getElementById('stat-emergencies').textContent = count;
    showToast('✅ Emergency marked as resolved.', 'success');
  }
  function markAllResolved() {
    emergencyData.forEach(e => e.resolved = true);
    renderEmergencies();
    document.getElementById('stat-emergencies').textContent = 0;
    showToast('✅ All alerts resolved.', 'success');
  }

  // ── EXPORT ──
  function exportSummary() {
    const rows = [
      ['Metric','Value'],
      ['Total Tenants','67'],
      ['Units Occupied','36'],
      ['Visitors Today', document.getElementById('stat-visitors').textContent],
      ['Active Emergencies', document.getElementById('stat-emergencies').textContent],
    ];
    const csv  = rows.map(r => r.join(',')).join('\n');
    const blob = new Blob([csv], {type:'text/csv'});
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
    a.download = 'frontdesk-summary.csv'; a.click();
    showToast('📥 Summary exported!', 'success');
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
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3200);
  }

  // ── DATE ──
  document.getElementById('summary-date').textContent =
    'As of ' + new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'});

  // ── INIT ──
  renderActivity();
  renderAnnouncements();
  renderNotifications();
  renderEmergencies();
</script>
</body>
</html>