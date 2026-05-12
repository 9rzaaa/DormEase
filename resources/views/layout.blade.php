<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DormEase')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

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
        .sidebar-logo-icon img { width: 24px; height: 24px; object-fit: contain; }
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
        .nav-icon { font-size: 1.05rem; width: 22px; text-align: center; flex-shrink: 0; }
        .nav-icon img { width: 18px; height: 18px; object-fit: contain; vertical-align: middle; }
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

        .card { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); padding: 1.5rem; }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
        .card-title { font-size: 1.05rem; font-weight: 700; color: var(--ink); }
        .card-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .15rem; }
        .see-all { font-size: .8rem; font-weight: 600; color: var(--pink); background: none; border: none; cursor: pointer; transition: opacity .2s; }
        .see-all:hover { opacity: .7; }
        .icon-sm {width: 18px; height: 18px; object-fit: contain; }

        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { opacity:0; animation: fadeUp .5s ease forwards; }
        .d1 { animation-delay:.05s; } .d2 { animation-delay:.12s; }
        .d3 { animation-delay:.19s; } .d4 { animation-delay:.26s; }
        .d5 { animation-delay:.33s; } .d6 { animation-delay:.40s; }

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
        .modal-field { margin-bottom: 1rem; }
        .modal-field label { display: block; font-size: .82rem; font-weight: 600; color: var(--ink-muted); margin-bottom: .4rem; }
        .modal-field input,
        .modal-field textarea {
            width: 100%; padding: .6rem .85rem; border-radius: 9px;
            border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
            font-size: .87rem; color: var(--ink); outline: none; transition: border-color .2s;
        }
        .modal-field textarea { min-height: 100px; resize: vertical; }
        .modal-field input:focus,
        .modal-field textarea:focus { border-color: var(--pink); }
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

        @media (max-width: 820px) {
            :root { --sidebar-w: 0px; }
            .sidebar { transform: translateX(-260px); width: 260px; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
        }
    </style>

    @yield('styles')
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </div>
        <div class="sidebar-logo-text">Dorm<em>Ease</em></div>
    </div>

    <div class="sidebar-role">👤 Admin</div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-db.png') }}" alt=""></span> Dashboard
        </a>

        <a href="{{ route('tenants.index') }}" class="nav-item {{ request()->routeIs('tenants.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-tenants.png') }}" alt=""></span> Manage Tenants
        </a>

        <a href="{{ route('documents.index') }}" class="nav-item {{ request()->routeIs('documents.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-docu.png') }}" alt=""></span> Document Management
        </a>

        <a href="{{ route('emergency.index') }}" class="nav-item {{ request()->routeIs('emergency.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-emerg.png') }}" alt=""></span> Emergency Reports
        </a>

        <a href="{{ route('maintenance.index') }}" class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-maint.png') }}" alt=""></span> Maintenance Requests
        </a>

        <a href="{{ route('billing.index') }}" class="nav-item {{ request()->routeIs('billing.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-bill.png') }}" alt=""></span> Water Billing
        </a>

        <a href="{{ route('visitors.index') }}" class="nav-item {{ request()->routeIs('visitors.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-visit.png') }}" alt=""></span> Visitor Logs
        </a>

        <a href="{{ route('announcements.index') }}" class="nav-item {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-announ.png') }}" alt=""></span> Announcements
        </a>

        <div class="nav-divider"></div>

        <a href="{{ route('staff.index') }}" class="nav-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-staff.png') }}" alt=""></span> Manage Staff
        </a>

        <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-settings.png') }}" alt=""></span> Settings
        </a>
    </nav>

    <div class="sidebar-logout">
        <form method="POST" action="/logout" id="logout-form">@csrf</form>
        <button class="logout-btn" onclick="openModal('logout-modal')">
            <span class="nav-icon">
                <img src="{{ asset('icons/logout.png') }}" alt="Logout">
            </span>
        </button>
    </div>
</aside>

<div class="main">

    <header class="topbar">
        <div class="breadcrumb">Pages / <span>@yield('page-title', 'Dashboard')</span></div>
        <div class="topbar-right">
            <div class="notif-bell" title="Notifications">
                <img src="{{ asset('icons/bell.png') }}" class="icon-sm" alt="Notifications">
                @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                    <span class="notif-badge">{{ $unreadNotifCount }}</span>
                @endif
            </div>
            <div class="avatar" title="{{ $staff->first_name ?? 'A' }}">
                {{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </header>

    @yield('content')

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

@yield('modals')

<div class="toast" id="toast"></div>

<script>
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    function showToast(msg, type = '') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className   = 'toast ' + type;
        setTimeout(() => t.classList.add('show'),    10);
        setTimeout(() => t.classList.remove('show'), 3200);
    }
</script>

@yield('scripts')

</body>
</html>