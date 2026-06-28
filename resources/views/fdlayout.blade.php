<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DormEase: Front Desk')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --hot-pink:   #E8175D;
            --bright-pink: #d63375;
            --pink:       #CA5D86;
            --pink-light: #FFB0CE;
            --pink-soft:  #FF7E86;
            --pink-bg:    #fdf0f5;
            --pink-card:  #fce8f1;
            --petal:     #fce8f1;
            --baby-pink: #fce4ec;

            --gray:       #B5B7C0;
            --gray-light: #E5ECF6;
            --mint:       #A6E7D8;
            --green:      #29BD9B;
            --peach:      #FFD7C7;
            --salmon:     #EB9C7D;
            --blush:      #FFF0F6;
            --red:        #DF0404;

            --white:      #ffffff;
            --ink:        #1a1a2e;
            --ink-muted:  #7a5f6e;
            --black:     #1a1a2e;

            --pink-50:    #fdf2f6;
            --pink-100:   #fce4ec;
            --pink-200:   #f8bbd0;
            --pink-400:   #f06292;
            --pink-500:   #ec407a;
            --pink-600:   #d81b60;
            --gradient-pink: linear-gradient(135deg, #cd215a 0%, #d63375 100%);

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
            border-right: 1.5px solid var(--pink-light);
            box-shadow: 2px 0 20px rgba(202,93,134,.08);
            transition: transform .3s ease;
        }

        .sidebar-logo {
            padding: 1.4rem 1.5rem 1rem;
            display: flex; align-items: center; gap: .65rem;
            border-bottom: 1.5px solid var(--pink-light);
        }

        .sidebar-logo-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--bright-pink) 0%, var(--hot-pink) 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
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
            background: var(--pink-card); border: 1.5px solid var(--pink-light);
            border-radius: 6px; padding: .28rem .7rem;
            font-size: .72rem; font-weight: 800; color: var(--hot-pink);
            letter-spacing: .06em; text-transform: uppercase;
        }

        .sidebar-nav { flex: 1; padding: .5rem 1rem 1rem; overflow-y: auto; }

        .nav-item {
            display: flex; align-items: center; gap: .75rem;
            padding: .68rem .85rem; border-radius: 10px;
            font-size: .87rem; font-weight: 500; color: var(--ink);
            cursor: pointer; margin-bottom: .15rem;
            transition: background .2s, color .2s;
            border: none; background: none; width: 100%; text-align: left;
        }

        .nav-item:hover { background: var(--pink-card); color: var(--hot-pink); }
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

        .nav-divider { height: 1.5px; background: var(--pink-light); margin: .6rem 0; }

        .sidebar-logout { padding: 1rem 1.5rem; border-top: 1.5px solid var(--pink-light); }

        .content-col .card,
        .right-col .card {
            border-color: var(--baby-pink);
        }

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

        .logout-btn:hover { transform: translateY(-1px); opacity: .95; }
        .logout-btn img { width: 15px; height: 15px; filter: brightness(0) invert(1); }

        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            position: sticky; top: 0; z-index: 50;
            background: var(--white);
            border-bottom: 1.5px solid var(--pink-light);
            padding: .85rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 12px rgba(202,93,134,.07);
        }

        .breadcrumb { font-size: .8rem; color: var(--ink-muted); }
        .breadcrumb span { color: var(--hot-pink); font-weight: 700; }

        .topbar-right { display: flex; align-items: center; gap: 1rem; }

        .notif-bell {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--pink-card); border: 1.5px solid var(--pink-light);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 16px; position: relative; transition: var(--ease);
        }
        .notif-bell:hover { background: var(--pink-light); box-shadow: 0 0 0 3px rgba(232,23,93,.25); }
        .notif-badge {
            position: absolute; top: -3px; right: -3px;
            width: 16px; height: 16px; background: var(--bright-pink);
            border-radius: 50%; font-size: 9px; color: var(--white); font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--white);
        }

        #notif-wrap { position: relative; }

        .notif-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            padding-top: 8px;
            width: 320px;
            z-index: 200;
            opacity: 0;
            transform: translateY(4px) scale(.97);
            pointer-events: none;
            transition: opacity .2s ease, transform .2s ease;
        }
        #notif-wrap:hover .notif-dropdown,
        .notif-dropdown.locked {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .notif-dropdown-inner {
            background: var(--white);
            border: 1.5px solid var(--pink-light);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(202,93,134,.14);
            overflow: hidden;
        }
        .notif-dropdown-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: .85rem 1rem .7rem;
            border-bottom: 1.5px solid var(--pink-card);
        }
        .notif-dropdown-title { font-size: .88rem; font-weight: 700; color: var(--ink); }
        .notif-mark-all {
            font-size: .75rem; font-weight: 700; color: var(--hot-pink);
            background: none; border: none; cursor: pointer; padding: 0;
        }
        .notif-mark-all:hover { opacity: .7; }
        .notif-dropdown-list { max-height: 340px; overflow-y: auto; }
        .notif-dd-item {
            display: flex; align-items: flex-start; gap: .7rem;
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--pink-card);
            cursor: pointer;
            transition: background .15s;
            text-decoration: none; color: inherit;
        }
        .notif-dd-item:last-child { border-bottom: none; }
        .notif-dd-item:hover { background: var(--blush); }
        .notif-dd-item.unread { background: var(--pink-50); }
        .notif-dd-item.unread:hover { background: var(--pink-100); }
        .notif-unread-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--hot-pink); flex-shrink: 0; margin-top: .35rem;
        }
        .notif-dd-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--pink-card); border: 1.5px solid var(--pink-light);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .notif-dd-icon img {
            width: 14px; height: 14px; object-fit: contain;
            filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
        }
        .notif-dd-body { flex: 1; min-width: 0; }
        .notif-dd-msg {
            font-size: .81rem; font-weight: 500; color: var(--ink); line-height: 1.4;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .notif-dd-time { font-size: .71rem; color: var(--ink-muted); margin-top: .15rem; }
        .notif-dropdown-footer {
            padding: .6rem 1rem; border-top: 1.5px solid var(--pink-card); text-align: center;
        }
        .notif-see-all {
            font-size: .78rem; font-weight: 700; color: var(--hot-pink);
            background: none; border: none; cursor: pointer;
        }
        .notif-see-all:hover { opacity: .7; }
        .notif-empty {
            padding: 1.5rem 1rem; text-align: center;
            font-size: .83rem; color: var(--ink-muted);
        }

        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
            border: 2px solid var(--pink-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 800; color: var(--white); cursor: pointer;
            transition: box-shadow .2s;
            overflow: hidden;
        }
        .avatar:hover { box-shadow: 0 0 0 3px rgba(232,23,93,.25); }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }

        .card {
            background: var(--white); border-radius: 16px;
            border: 1.5px solid var(--pink-light);
            box-shadow: var(--shadow); padding: 1.5rem;
        }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
        .card-title { font-size: 1.05rem; font-weight: 700; color: var(--ink); }
        .card-sub   { font-size: .78rem; color: var(--ink-muted); margin-top: .15rem; }

        .see-all { font-size: .8rem; font-weight: 700; color: var(--hot-pink); background: none; border: none; cursor: pointer; transition: opacity .2s; }
        .see-all:hover { opacity: .7; }

        .icon-sm { width: 18px; height: 18px; object-fit: contain; }
        .icon-md { width: 24px; height: 24px; object-fit: contain; }
        .icon-lg { width: 30px; height: 30px; object-fit: contain; }

        .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

        .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
        .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
        .header-actions { display: flex; gap: .75rem; align-items: center; margin-top: .5rem; }

        .btn-outline {
            display: flex; align-items: center; gap: .45rem;
            padding: .55rem 1.2rem; border-radius: 10px;
            background: var(--white); color: var(--ink-muted);
            border: 1.5px solid var(--gray-light); font-size: .87rem; font-weight: 600;
            transition: border-color .2s, color .2s; cursor: pointer;
        }
        .btn-outline:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
        .btn-outline img { width: 16px; height: 16px; opacity: .6; }

        .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
        .view-row:last-child { border-bottom: none; }
        .view-label { color: var(--ink-muted); font-weight: 500; }
        .view-val { font-weight: 600; color: var(--ink); text-align: right; }

        .modal-field select {
            width: 100%; padding: .6rem .85rem; border-radius: 9px;
            border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
            font-size: .87rem; color: var(--ink); outline: none; transition: border-color .2s;
            background: var(--pink-bg);
        }
        .modal-field select:focus { border-color: var(--bright-pink); background: var(--white); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }

        .fade-up { opacity: 0; animation: fadeUp .5s ease forwards; }
        .d1 { animation-delay: .05s; }
        .d2 { animation-delay: .12s; }
        .d3 { animation-delay: .19s; }
        .d4 { animation-delay: .26s; }
        .d5 { animation-delay: .33s; }
        .d6 { animation-delay: .40s; }

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(26,26,46,.45);
            backdrop-filter: blur(4px); z-index: 300;
            display: none; align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: var(--white); border-radius: 20px;
            padding: 2rem; width: 90%; max-width: 440px;
            box-shadow: 0 20px 60px rgba(202,93,134,.18);
            animation: fadeUp .3s ease;
            max-height: 90vh; overflow-y: auto;
            border: 1.5px solid var(--pink-light);
        }

        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
        .modal-title  { font-size: 1.1rem; font-weight: 700; color: var(--ink); }
        .modal-close  { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
        .modal-close:hover { color: var(--red); }

        .modal-field { margin-bottom: 1rem; }
        .modal-field label { display: block; font-size: .82rem; font-weight: 700; color: var(--ink-muted); margin-bottom: .4rem; }
        .modal-field input,
        .modal-field textarea {
            width: 100%; padding: .6rem .85rem; border-radius: 9px;
            border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
            font-size: .87rem; color: var(--ink); outline: none; transition: border-color .2s;
            background: var(--pink-bg);
        }
        .modal-field textarea { min-height: 100px; resize: vertical; }
        .modal-field input:focus,
        .modal-field textarea:focus { border-color: var(--bright-pink); background: var(--white); }

        .modal-actions { display: flex; gap: .7rem; margin-top: 1.4rem; justify-content: flex-end; }

        .btn-cancel {
            padding: .6rem 1.2rem; border-radius: 9px;
            border: 1.5px solid var(--pink-light); background: var(--pink-card);
            font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer;
        }
        .btn-cancel:hover { border-color: var(--pink); color: var(--hot-pink); }

        .btn-submit {
            padding: .6rem 1.4rem; border-radius: 9px; border: none;
            background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
            color: var(--white);
            font-size: .87rem; font-weight: 800; cursor: pointer;
            transition: opacity .2s, transform .15s;
        }
        .btn-submit:hover { opacity: .9; transform: translateY(-1px); }

        /* â”€â”€ Notification Detail Modal â”€â”€ */
        .notif-detail-modal { max-width: 520px; }

        .notif-detail-type-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .3rem .75rem; border-radius: 20px;
            font-size: .72rem; font-weight: 800; letter-spacing: .05em; text-transform: uppercase;
            margin-bottom: 1.2rem;
        }
        .notif-detail-type-badge.maintenance  { background: #fff7e6; color: #b45309; border: 1.5px solid #fde68a; }
        .notif-detail-type-badge.emergency    { background: #fff0f0; color: var(--red);   border: 1.5px solid #fca5a5; }
        .notif-detail-type-badge.billing      { background: #f0fdf4; color: #15803d; border: 1.5px solid #86efac; }
        .notif-detail-type-badge.document     { background: var(--blush); color: var(--hot-pink); border: 1.5px solid var(--pink-light); }
        .notif-detail-type-badge.announcement { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
        .notif-detail-type-badge.visitor      { background: #f5f3ff; color: #6d28d9; border: 1.5px solid #ddd6fe; }
        .notif-detail-type-badge.general      { background: var(--pink-card); color: var(--ink-muted); border: 1.5px solid var(--pink-light); }

        .notif-detail-icon-wrap {
            width: 56px; height: 56px; border-radius: 14px;
            background: var(--pink-card); border: 1.5px solid var(--pink-light);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem; flex-shrink: 0;
        }
        .notif-detail-icon-wrap img {
            width: 26px; height: 26px; object-fit: contain;
            filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
        }
        .notif-detail-message {
            font-size: 1rem; font-weight: 600; color: var(--ink); line-height: 1.55;
            margin-bottom: .9rem;
        }
        .notif-detail-meta {
            display: flex; flex-direction: column; gap: .5rem;
            background: var(--blush); border-radius: 10px;
            padding: .85rem 1rem; margin-bottom: 1.2rem;
            border: 1.5px solid var(--pink-light);
        }
        .notif-detail-meta-row {
            display: flex; align-items: center; gap: .6rem;
            font-size: .82rem; color: var(--ink-muted);
        }
        .notif-detail-meta-row strong { color: var(--ink); font-weight: 700; min-width: 60px; }
        .notif-detail-actions { display: flex; gap: .7rem; justify-content: flex-end; flex-wrap: wrap; }
        .notif-view-btn {
            padding: .6rem 1.4rem; border-radius: 9px; border: none;
            background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
            color: var(--white); font-size: .87rem; font-weight: 800; cursor: pointer;
            transition: opacity .2s, transform .15s; text-decoration: none;
            display: inline-flex; align-items: center; gap: .4rem;
        }
        .notif-view-btn:hover { opacity: .9; transform: translateY(-1px); }

        .alert-item { border-radius: 12px; padding: 1rem; border: 1.5px solid; margin-bottom: .8rem; }
        .alert-item.active   { background: var(--pink-bg); border-color: var(--pink-light); }
        .alert-item.resolved { background: #f0fdf8; border-color: var(--mint); }
        .alert-room   { font-weight: 700; font-size: .9rem; color: var(--ink); }
        .alert-status { font-size: .8rem; color: var(--ink-muted); margin-top: .2rem; }

        .toast {
            position: fixed; bottom: 2rem; right: 2rem; z-index: 9999;
            background: var(--ink); color: var(--white);
            padding: .85rem 1.4rem; border-radius: 12px;
            font-size: .87rem; font-weight: 600;
            box-shadow: 0 8px 24px rgba(202,93,134,.20);
            transform: translateY(80px); opacity: 0;
            transition: transform .35s ease, opacity .35s ease;
            display: flex; align-items: center; gap: .6rem;
        }
        .toast.show    { transform: translateY(0); opacity: 1; }
        .toast.success { background: var(--green); }
        .toast.error   { background: var(--red); }

        .avatar-wrap { position: relative; }
        .avatar-dropdown {
            position: absolute; top: 100%; right: 0;
            background: var(--white);
            border: 1.5px solid var(--pink-light);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(232,23,93,.14);
            width: 210px;
            overflow: hidden;
            opacity: 0; transform: translateY(8px) scale(.97);
            pointer-events: none;
            transition: opacity .2s ease, transform .2s ease;
            z-index: 200;
        }
        .avatar-wrap:hover .avatar-dropdown {
            opacity: 1; transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .dropdown-header {
            padding: .9rem 1rem .75rem;
            border-bottom: 1px solid var(--pink-light);
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
        .dropdown-item:hover { background: var(--pink-card); color: var(--hot-pink); }
        .dropdown-item img { width: 16px; height: 16px; object-fit: contain; flex-shrink: 0; opacity: .7; }
        .dropdown-item:hover img { opacity: 1; }
        .dropdown-divider { height: 1px; background: var(--pink-light); margin: .3rem .4rem; }
        .dropdown-item.danger { color: var(--red); }
        .dropdown-item.danger:hover { background: #fff0f0; color: var(--red); }

        .sidebar-toggle {
            display: none; flex-direction: column; justify-content: center; gap: 5px;
            width: 36px; height: 36px;
            background: var(--pink-card); border: 1.5px solid var(--pink-light);
            border-radius: 9px; cursor: pointer; padding: 7px; flex-shrink: 0;
        }
        .sidebar-toggle span { display: block; height: 2px; background: var(--hot-pink); border-radius: 2px; transition: .2s; }

        .sidebar-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(26,26,46,.4); z-index: 99;
        }
        .sidebar-backdrop.open { display: block; }

        @media (max-width: 1024px) {
            .sidebar-toggle { display: flex; }
        }

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

<div class="sidebar-backdrop" id="sidebar-backdrop" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </div>
        <div class="sidebar-logo-text">Dorm<em>Ease</em></div>
    </div>

    <div class="sidebar-role">Front Desk</div>

    <nav class="sidebar-nav">
        <a href="{{ route('frontdesk.dashboard') }}" class="nav-item {{ request()->routeIs('frontdesk.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-db.png') }}" alt=""></span> Dashboard
        </a>
        <a href="{{ route('frontdesk.tenants') }}" class="nav-item {{ request()->routeIs('frontdesk.tenants') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-tenants.png') }}" alt=""></span> Tenant Directory
        </a>
        <a href="{{ route('frontdesk.emergency') }}" class="nav-item {{ request()->routeIs('frontdesk.emergency') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-emerg.png') }}" alt=""></span> Emergency Reports
        </a>
        <a href="{{ route('frontdesk.visitors') }}" class="nav-item {{ request()->routeIs('frontdesk.visitors') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-visit.png') }}" alt=""></span> Visitor Logs
        </a>
        <a href="{{ route('frontdesk.announcements') }}" class="nav-item {{ request()->routeIs('frontdesk.announcements*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-announ.png') }}" alt=""></span> Announcements
        </a>

        <div class="nav-divider"></div>

        <a href="{{ route('frontdesk.settings.index') }}" class="nav-item {{ request()->routeIs('frontdesk.settings*') ? 'active' : '' }}">
            <span class="nav-icon"><img src="{{ asset('icons/nav-settings.png') }}" alt=""></span> Settings
        </a>
    </nav>

    <div class="sidebar-logout">
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
        <button class="sidebar-toggle" id="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <div class="breadcrumb">Pages / <span>@yield('page-title', 'Dashboard')</span></div>
        <div class="topbar-right">

            <div id="notif-wrap">
                <div class="notif-bell" id="notif-bell" title="Notifications" onclick="toggleNotifDropdown(event)">
                    <img src="{{ asset('icons/bell.png') }}" class="icon-sm" alt="Notifications">
                    @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                        <span class="notif-badge" id="notif-badge">{{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}</span>
                    @endif
                </div>

                <div class="notif-dropdown" id="notif-dropdown">
                    <div class="notif-dropdown-inner">
                        <div class="notif-dropdown-header">
                            <div class="notif-dropdown-title">
                                Notifications
                                @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                                    <span style="color:var(--ink-muted);font-weight:500;font-size:.78rem;">({{ $unreadNotifCount }} unread)</span>
                                @endif
                            </div>
                            @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                                <button class="notif-mark-all" onclick="markAllRead()">Mark all read</button>
                            @endif
                        </div>

                        <div class="notif-dropdown-list">
                            @if(isset($notifications) && $notifications->count())
                                @foreach($notifications as $notif)
                                    @php
                                        $notifIcon = match($notif->type) {
                                            'visitor_registration' => 'nav-visit',
                                            'visitor_checkin'      => 'nav-visit',
                                            'visitor_checkout'     => 'nav-visit',
                                            'visitor_cancelled'    => 'nav-visit',
                                            'emergency_new'        => 'warn',
                                            'announcement_new'     => 'nav-announ',
                                            default                => 'bell',
                                        };
                                        $notifTypeLabel = match($notif->type) {
                                            'visitor_registration' => 'visitor',
                                            'visitor_checkin'      => 'visitor',
                                            'visitor_checkout'     => 'visitor',
                                            'visitor_cancelled'    => 'visitor',
                                            'emergency_new'        => 'emergency',
                                            'announcement_new'     => 'announcement',
                                            default                => 'general',
                                        };
                                    @endphp

                                    <div class="notif-dd-item {{ $notif->is_read ? '' : 'unread' }}"
                                         onclick="handleNotifClick(event, this)"
                                         data-notif='{!! json_encode([
                                             "id"      => $notif->notif_id,
                                             "type"    => $notifTypeLabel,
                                             "icon"    => asset("icons/{$notifIcon}.png"),
                                             "message" => $notif->message,
                                             "time"    => \Carbon\Carbon::parse($notif->created_at)->format("F j, Y \\a\\t g:i A"),
                                             "ago"     => \Carbon\Carbon::parse($notif->created_at)->diffForHumans(),
                                             "url"     => $notif->url ?? "",
                                             "isRead"  => (bool) $notif->is_read,
                                         ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}'>
                                        @if(!$notif->is_read)
                                            <div class="notif-unread-dot"></div>
                                        @else
                                            <div style="width:7px;flex-shrink:0;"></div>
                                        @endif
                                        <div class="notif-dd-icon">
                                            <img src="{{ asset('icons/' . $notifIcon . '.png') }}"
                                                 alt=""
                                                 onerror="this.src='{{ asset('icons/bell.png') }}'">
                                        </div>
                                        <div class="notif-dd-body">
                                            <div class="notif-dd-msg">{{ $notif->message }}</div>
                                            <div class="notif-dd-time">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="notif-empty">No notifications yet.</div>
                            @endif
                        </div>

                        <div class="notif-dropdown-footer" style="display: flex; align-items: center; justify-content: space-between; padding: .6rem 1rem; border-top: 1.5px solid var(--petal);">
                            <span style="font-size:.72rem;color:var(--ink-muted);">Click to view details</span>
                            <a href="{{ route('notifications.index') }}" class="notif-see-all" style="text-decoration: none;">View Previous</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="avatar-wrap" id="avatar-wrap">
                <div class="avatar" id="topbar-avatar" title="{{ $staff->first_name ?? 'F' }}">
                    @if($staff->profile_picture ?? null)
                        <img src="{{ $staff->profile_picture }}" alt="Avatar"
                             onerror="this.style.display='none'; this.parentElement.innerText='{{ strtoupper(substr($staff->first_name ?? 'F', 0, 1)) }}'">
                    @else
                        {{ strtoupper(substr($staff->first_name ?? 'F', 0, 1)) }}
                    @endif
                </div>

                <div class="avatar-dropdown" id="avatar-dropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-avatar">
                            @if($staff->profile_picture ?? null)
                                <img src="{{ $staff->profile_picture }}" alt=""
                                     onerror="this.style.display='none'; this.parentElement.innerText='{{ strtoupper(substr($staff->first_name ?? 'F', 0, 1)) }}'">
                            @else
                                {{ strtoupper(substr($staff->first_name ?? 'F', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="dropdown-name">{{ ($staff->first_name ?? '') . ' ' . ($staff->last_name ?? '') }}</div>
                            <div class="dropdown-role">{{ ucfirst($staff->role ?? 'Front Desk') }}</div>
                        </div>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('fdprofile.index') }}" class="dropdown-item">
                            <img src="{{ asset('icons/staff-2.png') }}" alt=""> My Profile
                        </a>
                        <a href="{{ route('frontdesk.settings.index') }}" class="dropdown-item">
                            <img src="{{ asset('icons/nav-settings.png') }}" alt=""> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item danger" onclick="openModal('logout-modal')">
                            <img src="{{ asset('icons/logout.png') }}" alt=""> Log Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')
</div>

<div class="modal-overlay" id="logout-modal" onclick="handleOverlayClick(event, 'logout-modal')">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Log Out</div>
            <button class="modal-close" onclick="closeModal('logout-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;">Are you sure you want to log out of DormEase?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('logout-modal')">Cancel</button>
            <button class="btn-submit" onclick="document.getElementById('logout-form').submit()" style="background:var(--red);">Log Out</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="notif-detail-modal" onclick="handleOverlayClick(event, 'notif-detail-modal')">
    <div class="modal notif-detail-modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Notification Detail</div>
            <button class="modal-close" onclick="closeNotifDetail()">&#x2715;</button>
        </div>

        <div id="notif-detail-badge" class="notif-detail-type-badge general">General</div>

        <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1rem;">
            <div class="notif-detail-icon-wrap" id="notif-detail-icon-wrap">
                <img id="notif-detail-icon" src="" alt="">
            </div>
            <div id="notif-detail-message" class="notif-detail-message" style="padding-top:.3rem;"></div>
        </div>

        <div class="notif-detail-meta" id="notif-detail-meta">
            <div class="notif-detail-meta-row">
                <strong>When</strong>
                <span id="notif-detail-time"></span>
            </div>
            <div class="notif-detail-meta-row">
                <strong>Status</strong>
                <span id="notif-detail-status"></span>
            </div>
            <div class="notif-detail-meta-row" id="notif-detail-url-row" style="display:none;">
                <strong>Link</strong>
                <span id="notif-detail-url-text" style="color:var(--hot-pink);font-size:.8rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
            </div>
        </div>

        <div class="notif-detail-actions">
            <button class="btn-cancel" onclick="closeNotifDetail()">Close</button>
            <a id="notif-detail-view-btn" href="#" class="notif-view-btn" style="display:none;">
                View Details &#8594;
            </a>
        </div>
    </div>
</div>

@if(session('prompt_temp_password'))
<div class="modal-overlay open" id="temp-pw-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:38px;height:38px;border-radius:10px;background:var(--pink-card);border:1.5px solid var(--pink-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <img src="{{ asset('icons/nav-settings.png') }}" style="width:18px;height:18px;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);" alt="">
                </div>
                <div>
                    <div class="modal-title">Change Your Password</div>
                    <div style="font-size:.75rem;color:var(--ink-muted);margin-top:.1rem;">You are using a temporary password</div>
                </div>
            </div>
        </div>

        <div style="background:var(--pink-card);border:1.5px solid var(--pink-light);border-radius:10px;padding:.8rem 1rem;margin-bottom:1.2rem;font-size:.83rem;color:var(--hot-pink);line-height:1.55;">
            For your account security, please set a new personal password. You can change it later but will be reminded on your next login.
        </div>

        <form method="POST" action="{{ route('fdprofile.updatePassword') }}" id="temp-pw-form">
            @csrf
            @method('PUT')

            <div class="modal-field">
                <label>Current (Temporary) Password</label>
                <div style="position:relative;">
                    <input type="password" name="current_password" id="tmp-cur-pw"
                        placeholder="Enter temporary password" required autocomplete="current-password"
                        style="padding-right:2.5rem;">
                    <button type="button" onclick="toggleTmpPw('tmp-cur-pw', this)"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;display:flex;align-items:center;padding:0;">
                        <img src="{{ asset('icons/eye.png') }}" style="width:15px;height:15px;opacity:.35;transition:opacity .2s;" alt="">
                    </button>
                </div>
            </div>

            <div class="modal-field">
                <label>New Password</label>
                <div style="position:relative;">
                    <input type="password" name="password" id="tmp-new-pw"
                        placeholder="Min. 8 characters" required autocomplete="new-password"
                        oninput="checkTmpStrength(this.value)"
                        style="padding-right:2.5rem;">
                    <button type="button" onclick="toggleTmpPw('tmp-new-pw', this)"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;display:flex;align-items:center;padding:0;">
                        <img src="{{ asset('icons/eye.png') }}" style="width:15px;height:15px;opacity:.35;transition:opacity .2s;" alt="">
                    </button>
                </div>
                <div style="height:3px;border-radius:2px;background:var(--pink-100);overflow:hidden;margin-top:.5rem;">
                    <div id="tmp-strength-fill" style="height:100%;border-radius:2px;width:0%;transition:width .3s,background .3s;"></div>
                </div>
                <div id="tmp-strength-label" style="font-size:.67rem;color:var(--ink-muted);margin-top:.2rem;"></div>
                <div id="tmp-pw-requirements" style="margin-top:.6rem;display:flex;flex-direction:column;gap:.25rem;">
                    <div id="tmp-preq-length" style="display:flex;align-items:center;gap:.4rem;font-size:.69rem;color:var(--ink-muted);font-weight:500;transition:color .25s;">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--pink-100);flex-shrink:0;transition:background .25s;display:inline-block;" id="tmp-dot-length"></span>At least 8 characters
                    </div>
                    <div id="tmp-preq-upper" style="display:flex;align-items:center;gap:.4rem;font-size:.69rem;color:var(--ink-muted);font-weight:500;transition:color .25s;">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--pink-100);flex-shrink:0;transition:background .25s;display:inline-block;" id="tmp-dot-upper"></span>One uppercase letter
                    </div>
                    <div id="tmp-preq-number" style="display:flex;align-items:center;gap:.4rem;font-size:.69rem;color:var(--ink-muted);font-weight:500;transition:color .25s;">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--pink-100);flex-shrink:0;transition:background .25s;display:inline-block;" id="tmp-dot-number"></span>One number
                    </div>
                    <div id="tmp-preq-special" style="display:flex;align-items:center;gap:.4rem;font-size:.69rem;color:var(--ink-muted);font-weight:500;transition:color .25s;">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--pink-100);flex-shrink:0;transition:background .25s;display:inline-block;" id="tmp-dot-special"></span>One special character
                    </div>
                </div>
            </div>

            <div class="modal-field">
                <label>Confirm New Password</label>
                <div style="position:relative;">
                    <input type="password" name="password_confirmation" id="tmp-conf-pw"
                        placeholder="Repeat new password" required autocomplete="new-password"
                        style="padding-right:2.5rem;">
                    <button type="button" onclick="toggleTmpPw('tmp-conf-pw', this)"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;display:flex;align-items:center;padding:0;">
                        <img src="{{ asset('icons/eye.png') }}" style="width:15px;height:15px;opacity:.35;transition:opacity .2s;" alt="">
                    </button>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="dismissTempPassword()">Change Later</button>
                <button type="submit" class="btn-submit">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endif

@yield('modals')

<div class="toast" id="toast"></div>

<form method="POST" action="/logout" id="logout-form" style="display:none;">@csrf</form>

<script>
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-backdrop').classList.toggle('open');
    }

    function handleOverlayClick(e, id) {
        if (e.target === document.getElementById(id)) closeModal(id);
    }

    function toggleNotifDropdown(e) {
        e.stopPropagation();
        var dd = document.getElementById('notif-dropdown');
        if (!dd) return;
        dd.classList.toggle('locked');
    }

    document.addEventListener('click', function(e) {
        var wrap = document.getElementById('notif-wrap');
        if (wrap && !wrap.contains(e.target)) {
            var dd = document.getElementById('notif-dropdown');
            if (dd) dd.classList.remove('locked');
        }
    });

    window.handleNotifClick = function(e, el) {
        e.stopPropagation();
        var dd = document.getElementById('notif-dropdown');
        if (dd) dd.classList.remove('locked');
        openNotifDetail(el);
    };

    function showToast(msg, type) {
        type = type || '';
        var t = document.getElementById('toast');
        t.textContent = msg;
        t.className   = 'toast ' + type;
        setTimeout(function() { t.classList.add('show'); },    10);
        setTimeout(function() { t.classList.remove('show'); }, 3200);
    }

    var __typeLabels = {
        maintenance:  'Maintenance',
        emergency:    'Emergency',
        billing:      'Billing',
        document:     'Document',
        announcement: 'Announcement',
        visitor:      'Visitor',
        general:      'General',
    };

    window.openNotifDetail = function(source) {
        var notif;

        if (source && source.nodeType) {
            try {
                notif = JSON.parse(source.dataset.notif);
            } catch (e) {
                console.error('openNotifDetail: failed to parse data-notif', e);
                openModal('notif-detail-modal');
                return;
            }
        } else if (source && typeof source === 'object') {
            notif = source;
        } else {
            console.error('openNotifDetail: unexpected argument', source);
            return;
        }

        try {
            var badge = document.getElementById('notif-detail-badge');
            if (badge) {
                badge.className   = 'notif-detail-type-badge ' + (notif.type || 'general');
                badge.textContent = __typeLabels[notif.type] || 'General';
            }

            var icon = document.getElementById('notif-detail-icon');
            if (icon) {
                icon.src = notif.icon || '';
                icon.onerror = function() { this.src = '{{ asset("icons/bell.png") }}'; };
            }

            var msgEl = document.getElementById('notif-detail-message');
            if (msgEl) msgEl.textContent = notif.message || '';

            var timeEl = document.getElementById('notif-detail-time');
            if (timeEl) timeEl.textContent = (notif.time || '') + (notif.ago ? ' (' + notif.ago + ')' : '');

            var statusEl = document.getElementById('notif-detail-status');
            if (statusEl) {
                statusEl.innerHTML = notif.isRead
                    ? '<span style="color:var(--green);font-weight:700;">&#10003; Read</span>'
                    : '<span style="color:var(--hot-pink);font-weight:700;">&#9679; Unread</span>';
            }

            var urlRow  = document.getElementById('notif-detail-url-row');
            var viewBtn = document.getElementById('notif-detail-view-btn');
            if (notif.url) {
                if (urlRow)  urlRow.style.display = 'flex';
                var urlText = document.getElementById('notif-detail-url-text');
                if (urlText) urlText.textContent  = notif.url;
                if (viewBtn) { viewBtn.style.display = 'inline-flex'; viewBtn.href = notif.url; }
            } else {
                if (urlRow)  urlRow.style.display  = 'none';
                if (viewBtn) viewBtn.style.display  = 'none';
            }

            if (!notif.isRead && notif.id) {
                fetch('/notifications/' + notif.id + '/read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                }).then(function() {
                    var b = document.getElementById('notif-badge');
                    if (b) {
                        var current = parseInt(b.textContent) || 0;
                        if (current <= 1) { b.remove(); }
                        else              { b.textContent = current - 1; }
                    }
                    if (source && source.nodeType) {
                        source.classList.remove('unread');
                        var dot = source.querySelector('.notif-unread-dot');
                        if (dot) dot.style.background = 'transparent';
                    }
                }).catch(function() {});
            }
        } catch (e) {
            console.error('openNotifDetail: error populating modal', e);
        }

        openModal('notif-detail-modal');
    };

    window.closeNotifDetail = function() {
        closeModal('notif-detail-modal');
    };

    function markAllRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        }).then(function() { location.reload(); });
    }

    (function monitorStaffSession() {
        var redirecting = false;

        function forceLogin() {
            if (redirecting) return;
            redirecting = true;
            window.location.replace('{{ route('login') }}');
        }

        function checkSession() {
            fetch('{{ route('session.check') }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                cache: 'no-store',
            }).then(function(response) {
                if (response.status === 401 || response.status === 403 || response.redirected) {
                    forceLogin();
                }
            }).catch(function() {});
        }

        checkSession();
        setInterval(checkSession, 5000);
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) checkSession();
        });
    })();

    function toggleTmpPw(inputId, btn) {
        var inp = document.getElementById(inputId);
        inp.type = inp.type === 'text' ? 'password' : 'text';
        btn.querySelector('img').style.opacity = inp.type === 'text' ? '.8' : '.35';
    }

    function checkTmpStrength(val) {
        var fill  = document.getElementById('tmp-strength-fill');
        var label = document.getElementById('tmp-strength-label');
        if (!fill || !label) return;
        if (!val) {
            fill.style.width  = '0%';
            label.textContent = '';
            [['tmp-preq-length','tmp-dot-length'],['tmp-preq-upper','tmp-dot-upper'],
             ['tmp-preq-number','tmp-dot-number'],['tmp-preq-special','tmp-dot-special']].forEach(function(p) {
                var r = document.getElementById(p[0]); var d = document.getElementById(p[1]);
                if (r) r.style.color = 'var(--ink-muted)';
                if (d) d.style.background = 'var(--pink-100)';
            });
            return;
        }
        var score = 0;
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        var levels = [
            { w: '20%',  color: '#DF0404', text: 'Weak' },
            { w: '50%',  color: '#f59e0b', text: 'Fair' },
            { w: '75%',  color: '#29BD9B', text: 'Good' },
            { w: '100%', color: '#16a34a', text: 'Strong' },
        ];
        var lvl = levels[score - 1] || levels[0];
        fill.style.width      = lvl.w;
        fill.style.background = lvl.color;
        label.textContent     = lvl.text;
        label.style.color     = lvl.color;

        function toggle(reqId, dotId, met) {
            var r = document.getElementById(reqId); var d = document.getElementById(dotId);
            if (r) r.style.color = met ? '#16a34a' : 'var(--ink-muted)';
            if (d) d.style.background = met ? '#16a34a' : 'var(--pink-100)';
        }
        toggle('tmp-preq-length',  'tmp-dot-length',  val.length >= 8);
        toggle('tmp-preq-upper',   'tmp-dot-upper',   /[A-Z]/.test(val));
        toggle('tmp-preq-number',  'tmp-dot-number',  /[0-9]/.test(val));
        toggle('tmp-preq-special', 'tmp-dot-special', /[^A-Za-z0-9]/.test(val));
    }

    function dismissTempPassword() {
        fetch('{{ route('fdprofile.dismissTempPassword') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        }).then(function() {
            var m = document.getElementById('temp-pw-modal');
            if (m) m.classList.remove('open');
        });
    }

    /* â”€â”€ Session flash toasts â”€â”€ */
    @if(session('error') && session('prompt_temp_password'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ addslashes(session("error")) }}', 'error');
            var m = document.getElementById('temp-pw-modal');
            if (m) m.classList.add('open');
        });
    @endif

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ addslashes(session("success")) }}', 'success');
        });
    @endif
</script>

@include('partials.emergency-live-alerts')
@include('partials.live-notifications')

@yield('scripts')
</body>
</html>
