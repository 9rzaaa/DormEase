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
        --hot-pink:   #E8175D;
        --bright-pink:#FF2D78;
        --mid-pink:   #FF6BA8;
        --baby-pink:  #FFD6E7;
        --blush:      #FFF0F6;
        --petal:      #FFE4F0;

        --pink-50:    #FFF0F6;
        --pink-100:   #FFD6E7;
        --pink-200:   #FFB3D0;
        --pink-400:   #FF2D78;
        --pink-500:   #E8175D;

        --soft-bg:    #fff7fb;
        --pink-bg:    var(--petal);
        --gradient-pink: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);

        --gray:       #B5B7C0;
        --gray-light: #E5ECF6;
        --mint:       #A6E7D8;
        --green:      #29BD9B;
        --peach:      #FFD7C7;
        --salmon:     #EB9C7D;
        --red:        #DF0404;
        --white:      #ffffff;
        --ink:        #2D0A1A;
        --ink-muted:  #7A3A55;
        --black:      #1A1A1A;

        --ease:   all .2s cubic-bezier(.4,0,.2,1);
        --border: rgba(255,45,120,.15);
        --shadow: 0 2px 16px rgba(232,23,93,.10);

        --ff-display: 'DM Serif Display', Georgia, serif;
        --ff-body:    'DM Sans', sans-serif;
        --sidebar-w:  260px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
        font-family: var(--ff-body);
        background: var(--blush);
        color: var(--ink);
        display: flex; min-height: 100vh; overflow-x: hidden;
    }
    a { text-decoration: none; color: inherit; }
    button { font-family: var(--ff-body); cursor: pointer; }

    .sidebar {
        width: var(--sidebar-w);
        background: var(--white);
        display: flex; flex-direction: column;
        position: fixed; top: 0; left: 0; bottom: 0;
        z-index: 100;
        border-right: 1.5px solid var(--baby-pink);
        box-shadow: 2px 0 20px rgba(232,23,93,.08);
        transition: transform .3s ease;
    }
    .sidebar-logo {
        padding: 1.4rem 1.5rem 1rem;
        display: flex; align-items: center; gap: .65rem;
        border-bottom: 1.5px solid var(--baby-pink);
    }
    .sidebar-logo-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, var(--bright-pink) 0%, var(--hot-pink) 100%);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .sidebar-logo-icon img { width: 24px; height: 24px; object-fit: contain; }
    .sidebar-logo-text {
        font-family: var(--ff-display); font-size: 1.3rem;
        font-weight: 700; color: var(--ink); letter-spacing: -.01em;
    }
    .sidebar-logo-text em { font-style: italic; color: var(--hot-pink); }

    .sidebar-role {
        margin: .8rem 1.5rem;
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--petal); border: 1.5px solid var(--baby-pink);
        border-radius: 6px; padding: .28rem .7rem;
        font-size: .72rem; font-weight: 800; color: var(--hot-pink);
        letter-spacing: .06em; text-transform: uppercase;
    }

    .sidebar-nav { flex: 1; padding: .5rem 1rem 1rem; overflow-y: auto; }
    .nav-item {
        display: flex; align-items: center; gap: .75rem;
        padding: .68rem .85rem; border-radius: 10px;
        font-size: .87rem; font-weight: 500; color: var(--black);
        cursor: pointer; margin-bottom: .15rem;
        transition: background .2s, color .2s;
        border: none; background: none; width: 100%; text-align: left;
    }
    .nav-item:hover  { background: var(--petal); color: var(--hot-pink); }
    .nav-item:hover .nav-icon img {
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .nav-item.active {
        background: linear-gradient(135deg, var(--bright-pink) 0%, var(--hot-pink) 100%);
        color: var(--white); font-weight: 700;
        box-shadow: 0 4px 14px rgba(232,23,93,.30);
    }
    .nav-item.active .nav-icon img { filter: brightness(0) invert(1); }
    .nav-icon { font-size: 1.05rem; width: 22px; text-align: center; flex-shrink: 0; }
    .nav-icon img {
        width: 18px; height: 18px; object-fit: contain; vertical-align: middle;
        filter: brightness(0);
    }

    .nav-divider { height: 1.5px; background: var(--baby-pink); margin: .6rem 0; }

    .sidebar-logout { padding: 1rem 1.5rem; border-top: 1.5px solid var(--baby-pink); }
    
    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        width: 100%;
        padding: .55rem .8rem;

        border: none;
        border-radius: 10px;

        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);

        font-size: .8rem;
        font-weight: 700;

        cursor: pointer;
        transition: var(--ease);

        box-shadow: 0 3px 10px rgba(232,23,93,.22);
    }

    .logout-btn:hover {
        transform: translateY(-1px);
        opacity: .95;
    }

    .logout-btn img {
        width: 15px;
        height: 15px;
        filter: brightness(0) invert(1);
    }

    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

    .topbar {
        position: sticky; top: 0; z-index: 50;
        background: var(--white);
        border-bottom: 1.5px solid var(--baby-pink);
        padding: .85rem 2rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 2px 12px rgba(232,23,93,.07);
    }
    .breadcrumb { font-size: .8rem; color: var(--ink-muted); }
    .breadcrumb span { color: var(--hot-pink); font-weight: 700; }

    .topbar-right { display: flex; align-items: center; gap: 1rem; }
    .notif-bell {
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--petal); border: 1.5px solid var(--baby-pink);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 16px; position: relative; transition: var(--ease);
    }
    .notif-bell:hover { background: var(--baby-pink); }
    .notif-badge {
        position: absolute; top: -3px; right: -3px;
        width: 16px; height: 16px;
        background: var(--bright-pink);
        border-radius: 50%; font-size: 9px; color: var(--white); font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid var(--white);
    }

    .avatar-wrap { position: relative; }
    .avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        border: 2px solid var(--baby-pink);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 800; color: var(--white);
        cursor: pointer; overflow: hidden;
        transition: box-shadow .2s;
        flex-shrink: 0;
    }
    .avatar:hover { box-shadow: 0 0 0 3px rgba(232,23,93,.25); }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-dropdown {
        position: absolute; top: calc(100% + 10px); right: 0;
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(232,23,93,.14);
        width: 210px;
        overflow: hidden;
        opacity: 0; transform: translateY(8px) scale(.97);
        pointer-events: none;
        transition: opacity .2s ease, transform .2s ease;
        z-index: 200;
    }
    .avatar-dropdown.open {
        opacity: 1; transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .dropdown-header {
        padding: .9rem 1rem .75rem;
        border-bottom: 1px solid var(--baby-pink);
        display: flex; align-items: center; gap: .7rem;
    }
    .dropdown-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 800; color: var(--white);
        flex-shrink: 0; overflow: hidden;
    }
    .dropdown-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .dropdown-name { font-size: .85rem; font-weight: 700; color: var(--ink); line-height: 1.2; }
    .dropdown-role { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    .dropdown-menu { padding: .4rem; }
    .dropdown-item {
        display: flex; align-items: center; gap: .6rem;
        padding: .55rem .75rem; border-radius: 9px;
        font-size: .84rem; font-weight: 500; color: var(--ink-muted);
        cursor: pointer; transition: background .15s, color .15s;
        text-decoration: none; border: none; background: none; width: 100%;
    }
    .dropdown-item:hover { background: var(--petal); color: var(--hot-pink); }
    .dropdown-item img { width: 16px; height: 16px; object-fit: contain; flex-shrink: 0; opacity: .7; }
    .dropdown-item:hover img { opacity: 1; }
    .dropdown-divider { height: 1px; background: var(--baby-pink); margin: .3rem .4rem; }
    .dropdown-item.danger { color: var(--red); }
    .dropdown-item.danger:hover { background: #fff0f0; color: var(--red); }

    .card {
        background: var(--white);
        border-radius: 16px;
        border: 1.5px solid var(--baby-pink);
        box-shadow: var(--shadow);
        padding: 1.5rem;
    }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .card-title { font-size: 1.05rem; font-weight: 700; color: var(--ink); }
    .card-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .15rem; }
    .see-all { font-size: .8rem; font-weight: 700; color: var(--hot-pink); background: none; border: none; cursor: pointer; transition: opacity .2s; }
    .see-all:hover { opacity: .7; }
    .icon-sm { width: 18px; height: 18px; object-fit: contain; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { opacity:0; animation: fadeUp .5s ease forwards; }
    .d1 { animation-delay:.05s; } .d2 { animation-delay:.12s; }
    .d3 { animation-delay:.19s; } .d4 { animation-delay:.26s; }
    .d5 { animation-delay:.33s; } .d6 { animation-delay:.40s; }

    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(45,10,26,.50);
        backdrop-filter: blur(4px); z-index: 300;
        display: none; align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: var(--white); border-radius: 20px;
        padding: 2rem; width: 90%; max-width: 480px;
        box-shadow: 0 20px 60px rgba(232,23,93,.18);
        animation: fadeUp .3s ease;
        max-height: 90vh; overflow-y: auto;
        border: 1.5px solid var(--baby-pink);
    }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .modal-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
    .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
    .modal-close:hover { color: var(--red); }
    .modal-field { margin-bottom: 1rem; }
    .modal-field label { display: block; font-size: .82rem; font-weight: 700; color: var(--ink-muted); margin-bottom: .4rem; }
    .modal-field input,
    .modal-field textarea {
        width: 100%; padding: .6rem .85rem; border-radius: 9px;
        border: 1.5px solid var(--baby-pink);
        font-family: var(--ff-body); font-size: .87rem; color: var(--ink);
        outline: none; transition: border-color .2s;
        background: var(--blush);
    }
    .modal-field textarea { min-height: 100px; resize: vertical; }
    .modal-field input:focus,
    .modal-field textarea:focus { border-color: var(--bright-pink); background: var(--white); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.4rem; justify-content: flex-end; }
    .btn-cancel {
        padding: .6rem 1.2rem; border-radius: 9px;
        border: 1.5px solid var(--baby-pink); background: var(--petal);
        font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer;
    }
    .btn-cancel:hover { border-color: var(--mid-pink); color: var(--hot-pink); }
    .btn-submit {
        padding: .6rem 1.4rem; border-radius: 9px; border: none;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white); font-size: .87rem; font-weight: 800; cursor: pointer;
        transition: opacity .2s, transform .15s;
    }
    .btn-submit:hover { opacity: .9; transform: translateY(-1px); }

    .alert-item { border-radius: 12px; padding: 1rem; border: 1.5px solid; margin-bottom: .8rem; }
    .alert-item.active   { background: #fff0f5; border-color: var(--baby-pink); }
    .alert-item.resolved { background: #f0fdf8; border-color: var(--mint); }
    .alert-room   { font-weight: 700; font-size: .9rem; color: var(--ink); }
    .alert-status { font-size: .8rem; color: var(--ink-muted); margin-top: .2rem; }

    .toast {
        position: fixed; bottom: 2rem; right: 2rem; z-index: 400;
        background: var(--ink); color: var(--white);
        padding: .85rem 1.4rem; border-radius: 12px;
        font-size: .87rem; font-weight: 600;
        box-shadow: 0 8px 24px rgba(232,23,93,.20);
        transform: translateY(80px); opacity: 0;
        transition: transform .35s ease, opacity .35s ease;
        display: flex; align-items: center; gap: .6rem;
    }
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
            Log Out
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

            <div class="avatar-wrap" id="avatar-wrap">
                <div class="avatar" id="topbar-avatar" onclick="toggleAvatarDropdown()" title="{{ $staff->first_name ?? 'Account' }}">
                    @if(isset($staff->profile_photo) && $staff->profile_photo)
                        <img src="{{ asset('storage/' . $staff->profile_photo) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}
                    @endif
                </div>

                <div class="avatar-dropdown" id="avatar-dropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-avatar">
                            @if(isset($staff->profile_photo) && $staff->profile_photo)
                                <img src="{{ asset('storage/' . $staff->profile_photo) }}" alt="">
                            @else
                                {{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="dropdown-name">{{ ($staff->first_name ?? '') . ' ' . ($staff->last_name ?? '') }}</div>
                            <div class="dropdown-role">{{ ucfirst($staff->role ?? 'Staff') }}</div>
                        </div>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.index') }}" class="dropdown-item" onclick="event.stopPropagation();">
                            <img src="{{ asset('icons/staff-2.png') }}" alt=""> My Profile
                        </a>
                        <a href="{{ route('settings.index') }}" class="dropdown-item">
                            <img src="{{ asset('icons/nav-settings.png') }}" alt=""> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item danger" onclick="closeAvatarDropdown(); openModal('logout-modal');">
                            <img src="{{ asset('icons/logout.png') }}" alt=""> Log Out
                        </button>
                    </div>
                </div>
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

    function toggleAvatarDropdown() {
        document.getElementById('avatar-dropdown').classList.toggle('open');
    }
    function closeAvatarDropdown() {
        document.getElementById('avatar-dropdown').classList.remove('open');
    }
    document.addEventListener('click', e => {
        const wrap = document.getElementById('avatar-wrap');
        if (wrap && !wrap.contains(e.target)) closeAvatarDropdown();
    });
    document.querySelectorAll('.dropdown-item[href]').forEach(el => {
        el.addEventListener('click', () => closeAvatarDropdown());
    });
</script>

@yield('scripts')

</body>
</html>