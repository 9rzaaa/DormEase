@extends('layout')

@section('title', 'DormEase: Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .page-body {
        display: grid;
        grid-template-columns: 1fr 290px;
        gap: 1.5rem;
        padding: 1.8rem 2rem;
        flex: 1;
        background: var(--blush);
        align-items: start;
    }

    .content-col { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--black); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--bright-pink); margin-top: .2rem; }

    .export-btn {
        display: flex; align-items: center; gap: .4rem;
        padding: .45rem 1rem; border-radius: 8px;
        border: 1.5px solid var(--bright-pink);
        background: var(--petal);
        font-size: .82rem; font-weight: 700; color: var(--hot-pink);
        transition: background .2s;
        cursor: pointer;
        white-space: nowrap;
    }
    .export-btn:hover { background: var(--baby-pink); }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .stat-box {
        border-radius: 14px; padding: 1.1rem; border: none;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        transition: transform .2s, box-shadow .2s;
        cursor: default;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(232,23,93,.25); }

    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .8rem;
    }
    .stat-icon img {
        width: 20px; height: 20px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .stat-num   { font-size: 1.9rem; font-weight: 800; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; font-weight: 700; color: rgba(255,255,255,.92); margin-top: .3rem; }
    .stat-sub   { font-size: .75rem; color: rgba(255,255,255,.72); margin-top: .15rem; }

    .chart-card {
        background: var(--white);
        border-radius: 16px;
        border: 1.5px solid var(--baby-pink);
        box-shadow: var(--shadow);
        padding: 1.4rem 1.6rem;
    }

    .chart-card-header {
        display: flex; align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap; gap: .8rem; margin-bottom: 1rem;
    }

    .chart-card-title { font-size: 1rem; font-weight: 700; color: var(--ink); line-height: 1.2; }
    .chart-card-sub   { font-size: .78rem; color: var(--ink-muted); margin-top: .15rem; }

    .chart-switcher {
        display: flex; gap: 4px;
        background: var(--petal);
        border-radius: 9px;
        padding: 3px;
        flex-shrink: 0;
    }

    .sw-btn {
        font-size: .72rem; font-weight: 700;
        padding: 5px 12px; border-radius: 7px;
        border: none; background: transparent;
        color: var(--ink-muted);
        cursor: pointer;
        transition: background .15s, color .15s;
        white-space: nowrap;
        font-family: var(--ff-body);
    }
    .sw-btn.active {
        background: var(--white);
        color: var(--hot-pink);
        border: 1.5px solid var(--baby-pink);
        box-shadow: 0 1px 4px rgba(232,23,93,.1);
    }

    .chart-legend { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: .75rem; }
    .chart-legend-item { display: flex; align-items: center; gap: .4rem; font-size: .78rem; font-weight: 600; color: var(--ink-muted); }
    .chart-legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

    .chart-wrap { position: relative; width: 100%; height: 200px; }

    .emergency-banner {
        display: flex; align-items: center; gap: 1rem;
        background: var(--white);
        border: 1.5px solid var(--bright-pink);
        border-radius: 14px;
        padding: .85rem 1.2rem;
        box-shadow: var(--shadow);
    }
    .emergency-banner.clear { border-color: var(--bright-pink); }

    .emerg-ico-wrap {
        width: 42px; height: 42px; border-radius: 50%;
        border: 2px solid var(--baby-pink);
        background: var(--petal);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        position: relative;
    }
    .emerg-ico-wrap.pulse::after {
        content: '';
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        border: 2px solid var(--bright-pink);
        opacity: 0.35;
        animation: pulse-ring 1.8s ease-out infinite;
    }
    @keyframes pulse-ring {
        0%   { transform: scale(0.9); opacity: 0.45; }
        100% { transform: scale(1.35); opacity: 0; }
    }
    .emerg-ico-wrap img {
        width: 20px; height: 20px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .emerg-ico-wrap img.check-icon { filter: none; }

    .emerg-body { flex: 1; min-width: 0; }
    .emerg-label  { font-size: .7rem; font-weight: 800; color: var(--ink-muted); text-transform: uppercase; letter-spacing: .06em; }
    .emerg-detail { font-size: .88rem; font-weight: 700; color: var(--ink); margin-top: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .emerg-status { font-size: .75rem; font-style: italic; margin-top: .05rem; color: var(--bright-pink); }
    .emerg-status.ok { color: #1a7a4a; }

    .emerg-btn {
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        color: var(--white); border: none; border-radius: 8px;
        padding: .42rem .9rem; font-size: .78rem; font-weight: 800;
        cursor: pointer; transition: opacity .2s;
        font-family: var(--ff-body); white-space: nowrap;
    }
    .emerg-btn:hover { opacity: .88; }
    .emerg-btn.ok { background: var(--bright-pink); }

    .panel {
        background: var(--white);
        border-radius: 16px;
        border: 1.5px solid var(--baby-pink);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .panel-head {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 1rem 1.2rem;
        cursor: pointer;
        user-select: none;
        transition: background .15s;
    }
    .panel-head:hover { background: var(--petal); }

    .panel-head-left {
        display: flex; align-items: center; gap: .55rem;
        font-size: .95rem; font-weight: 700; color: var(--ink);
    }
    .panel-head-left img { width: 18px; height: 18px; object-fit: contain; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }

    .panel-head-right { display: flex; align-items: center; gap: .65rem; }

    .panel-badge {
        font-size: .7rem; font-weight: 800;
        background: var(--petal); color: var(--hot-pink);
        border: 1.5px solid var(--baby-pink);
        border-radius: 100px; padding: 2px 9px;
    }

    .panel-chevron {
        width: 18px; height: 18px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: transform .3s cubic-bezier(.4,0,.2,1);
    }
    .panel-chevron svg {
        width: 14px; height: 14px;
        stroke: var(--hot-pink);
        fill: none;
        stroke-width: 2.2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .panel-chevron.open { transform: rotate(180deg); }

    .panel-link {
        font-size: .78rem; font-weight: 700;
        color: var(--hot-pink); text-decoration: none;
        transition: opacity .2s;
    }
    .panel-link:hover { opacity: .7; }

    .post-announce-btn {
        font-size: .78rem; font-weight: 700;
        color: var(--hot-pink); background: var(--petal);
        border: 1.5px solid var(--baby-pink); border-radius: 7px;
        padding: .28rem .75rem; cursor: pointer;
        font-family: var(--ff-body);
        transition: background .2s;
    }
    .post-announce-btn:hover { background: var(--baby-pink); }

    .panel-body {
        border-top: 1px solid var(--petal);
        overflow: hidden;
        max-height: 0;
        transition: max-height .38s cubic-bezier(.4,0,.2,1);
    }
    .panel-body.open { max-height: 700px; }

    .panel-inner { padding: .3rem .5rem .5rem; }

    .maint-row {
        display: grid;
        grid-template-columns: 38px 160px 1fr 120px 16px;
        align-items: center; gap: 1rem;
        padding: .85rem .5rem; border-bottom: 1px solid var(--petal);
        cursor: pointer; transition: background .15s; border-radius: 8px;
    }
    .maint-row:last-child { border-bottom: none; }
    .maint-row:hover { background: var(--petal); }

    .maint-type-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--petal); border: 1.5px solid var(--baby-pink);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .maint-type-icon img {
        width: 18px; height: 18px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .maint-info { min-width: 0; }
    .maint-title { font-size: .88rem; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-width: 0;}
    .maint-id    { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; min-width: 0; }

    .maint-desc-col { flex: 1; min-width: 0; }
    .maint-desc  { font-size: .83rem; color: var(--ink); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .maint-tags  { display: flex; gap: .35rem; margin-top: .3rem; flex-wrap: wrap; }

    .tag          { font-size: .7rem; font-weight: 700; padding: .18rem .55rem; border-radius: 5px; border: 1.5px solid; }
    .tag-urgent   { color: #C4003A; border-color: var(--bright-pink); background: var(--baby-pink); }
    .tag-moderate { color: #a84c00; border-color: #f5a24b;            background: #fff6ed; }
    .tag-low      { color: #1a7a4a; border-color: #5bcb8a;            background: #eafbf0; }
    .tag-progress { color: #185FA5; border-color: #B5D4F4;            background: #E6F1FB; }
    .tag-pending  { color: #8A1040; border-color: var(--pink-200);    background: var(--baby-pink); }

    .maint-assign { font-size: .82rem; color: var(--ink-muted); white-space: nowrap; flex-shrink: 0; }
    .maint-arrow  { color: var(--hot-pink); font-size: 1rem; flex-shrink: 0; }

    .empty-state { text-align: center; padding: 1.8rem; color: var(--ink-muted); font-size: .88rem; }

    .announce-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .85rem .5rem;
        border-bottom: 1px solid var(--petal);
        border-radius: 8px;
        transition: background .15s;
    }
    .announce-item:last-child { border-bottom: none; }
    .announce-item:hover { background: var(--petal); }

    .announce-item-left { flex: 1; min-width: 0; }
    .announce-title   { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .announce-date    { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }

    .announce-actions { display: flex; gap: .4rem; flex-shrink: 0; align-items: center; }
    .announce-action-btn { font-size: .75rem; font-weight: 700; padding: .28rem .7rem; border-radius: 6px; border: 1.5px solid var(--baby-pink); background: var(--petal); color: var(--hot-pink); cursor: pointer; transition: background .2s; font-family: var(--ff-body); white-space: nowrap; }
    .announce-action-btn:hover { background: var(--baby-pink); }
    .announce-action-btn.delete { background: #fff0f3; border-color: var(--mid-pink); color: #C4003A; }
    .announce-action-btn.delete:hover { background: var(--baby-pink); }

    .priority-badge { display: inline-block; font-size: .68rem; font-weight: 800; padding: .15rem .5rem; border-radius: 5px; border: 1.5px solid; margin-left: .4rem; vertical-align: middle; }
    .priority-low      { color: #1a7a4a; border-color: #5bcb8a;           background: #eafbf0; }
    .priority-moderate { color: #a84c00; border-color: #f5a24b;           background: #fff6ed; }
    .priority-high     { color: #C4003A; border-color: var(--bright-pink); background: var(--baby-pink); }

    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .right-col .card h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: .9rem; }

    .notif-item { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem 0; border-bottom: 1px solid var(--petal); cursor: pointer; transition: background .15s; border-radius: 6px; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--petal); }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }
    .notif-ico { width: 28px; height: 28px; border-radius: 8px; background: var(--petal); border: 1.5px solid var(--baby-pink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .notif-ico img { width: 14px; height: 14px; object-fit: contain; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }

    .activity-item { display: flex; align-items: flex-start; gap: .75rem; padding: .6rem 0; border-bottom: 1px solid var(--petal); }
    .activity-item:last-child { border-bottom: none; }
    .activity-avatar { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; background: linear-gradient(135deg, var(--baby-pink), var(--hot-pink)); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 800; color: var(--white); }
    .activity-text { font-size: .8rem; color: var(--ink); line-height: 1.4; }
    .activity-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    .icon-sm { width: 16px; height: 16px; object-fit: contain; }
    .icon-md { width: 20px; height: 20px; object-fit: contain; }
    .icon-lg { width: 28px; height: 28px; object-fit: contain; }

    .emerg-modal-list {
        display: flex;
        flex-direction: column;
        gap: .65rem;
        overflow-y: auto;
        max-height: 400px;
        padding: .75rem 0 .25rem;
        scrollbar-width: thin;
        scrollbar-color: var(--mid-pink) transparent;
    }
    .emerg-modal-list::-webkit-scrollbar       { width: 4px; }
    .emerg-modal-list::-webkit-scrollbar-track { background: transparent; }
    .emerg-modal-list::-webkit-scrollbar-thumb { background: var(--mid-pink); border-radius: 99px; }

    .emerg-alert-card {
        display: flex;
        align-items: flex-start;
        gap: .85rem;
        padding: .85rem 1rem;
        border-radius: 12px;
        border: 1.5px solid;
    }
    .emerg-alert-card.is-active   { border-color: var(--mid-pink);  background: var(--petal); }
    .emerg-alert-card.is-resolved { border-color: #b8edd1;          background: #f2fbf6; }

    .emerg-alert-icon {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .emerg-alert-card.is-active .emerg-alert-icon   { background: var(--baby-pink); }
    .emerg-alert-card.is-resolved .emerg-alert-icon { background: #d3f7e6; }
    .emerg-alert-icon img { width: 18px; height: 18px; object-fit: contain; }
    .emerg-alert-card.is-active .emerg-alert-icon img {
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .emerg-alert-card.is-resolved .emerg-alert-icon img {
        filter: brightness(0) saturate(100%) invert(27%) sepia(97%) saturate(500%) hue-rotate(100deg) brightness(90%);
    }

    .emerg-alert-body      { flex: 1; min-width: 0; }
    .emerg-alert-location  {
        font-size: .88rem; font-weight: 700; color: var(--ink);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .emerg-alert-time      { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }

    .emerg-alert-badge {
        font-size: .7rem; font-weight: 800;
        padding: .22rem .7rem; border-radius: 6px;
        border: 1.5px solid; flex-shrink: 0;
        white-space: nowrap; align-self: center;
    }
    .badge-active   { color: #C4003A; border-color: var(--bright-pink); background: var(--baby-pink); }
    .badge-resolved { color: #1a7a4a; border-color: #5bcb8a;           background: #eafbf0; }

    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .page-body  { grid-template-columns: 1fr; }
        .right-col  { display: grid; grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 820px) {
        .right-col  { grid-template-columns: 1fr; }
        .chart-wrap { height: 180px; }
        .chart-card-header { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 540px) {
        .page-body  { padding: 1rem; gap: 1rem; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .chart-wrap { height: 160px; }
        .chart-switcher { flex-wrap: wrap; }
        .emerg-detail { font-size: .82rem; }
        .emerg-modal-list { max-height: 260px; }
        .announce-item { flex-wrap: wrap; }
        .announce-actions { width: 100%; justify-content: flex-end; }
    }

    .shift-pill {
        display: flex;
        align-items: center;
        gap: 0;
        width: fit-content;
        background: var(--petal);
        border: 1.5px solid var(--baby-pink);
        border-radius: 100px;
        overflow: hidden;
        transition: all .3s cubic-bezier(.4,0,.2,1);
        cursor: default;
    }
    .shift-pill-icon {
        position: relative;
        width: 38px;
        height: 38px;
        border-radius: 100px;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .shift-pill-icon img {
        filter: brightness(0) invert(1);
        width: 16px;
        height: 16px;
    }
    .shift-pill-count {
        position: absolute;
        top: 0px;
        right: -2px;
        background: #C4003A;
        color: #fff;
        font-size: .6rem;
        font-weight: 800;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid var(--petal);
    }
    .shift-pill-content {
        display: flex;
        flex-direction: column;
        max-width: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-width .35s cubic-bezier(.4,0,.2,1), opacity .25s ease, padding .3s ease;
        white-space: nowrap;
    }
    .shift-pill:hover .shift-pill-content {
        max-width: 180px;
        opacity: 1;
        padding: 0 1rem 0 .6rem;
    }
    .shift-pill-label {
        font-size: .78rem;
        font-weight: 700;
        color: var(--hot-pink);
    }
    .shift-pill-sub {
        font-size: .7rem;
        color: var(--bright-pink);
        margin-top: .1rem;
    }
</style>
@endsection

@section('content')

<div class="page-body">

    <div class="content-col">

        <div class="page-header fade-up d1">
            <div>
                <h1>Welcome, {{ $staff->first_name }}!</h1>
                <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
            </div>
            @if(($expectedAbsent ?? 0) > 0)
            <div class="shift-pill">
                <div class="shift-pill-icon">
                    <img src="{{ asset('icons/staff-2.png') }}" class="icon-md" alt="absent">
                    <span class="shift-pill-count">{{ $expectedAbsent }}</span>
                </div>
                <div class="shift-pill-content">
                    <span class="shift-pill-label">Expected On Shift</span>
                    <span class="shift-pill-sub">Not yet logged in</span>
                </div>
            </div>
            @endif
        </div>

        <div class="card fade-up d2">
            <div class="card-header">
                <div>
                    <div class="card-title">Quick Summary</div>
                    <div class="card-sub">As of {{ now()->format('F d, Y') }}</div>
                </div>
                <button class="export-btn" onclick="exportSummary()">
                    <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="">
                    Export
                </button>
            </div>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt="tenants"></div>
                    <div class="stat-num">{{ $totalTenants ?? 0 }}</div>
                    <div class="stat-label">Total Tenants</div>
                    <div class="stat-sub">Currently Registered</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/billing.png') }}" class="icon-md" alt="payments"></div>
                    <div class="stat-num">{{ $pendingPayments ?? 0 }}</div>
                    <div class="stat-label">Unpaid Bills</div>
                    <div class="stat-sub">Unsettled water charges</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/maintenance.png') }}" class="icon-md" alt="maintenance"></div>
                    <div class="stat-num">{{ $pendingMaintenance ?? 0 }}</div>
                    <div class="stat-label">Maintenance Requests</div>
                    <div class="stat-sub">Pending &amp; in progress</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/warn.png') }}" class="icon-md" alt="reports"></div>
                    <div class="stat-num">{{ $unresolvedReports ?? 0 }}</div>
                    <div class="stat-label">Unresolved Reports</div>
                    <div class="stat-sub">Ongoing concerns</div>
                </div>
            </div>
        </div>

        <div class="chart-card fade-up d3">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title" id="chart-title">Monthly Payment Overview</div>
                    <div class="chart-card-sub" id="chart-sub">Collected vs unpaid water billing for the last 6 months</div>
                </div>
                <div class="chart-switcher">
                    <button class="sw-btn active" onclick="switchChart('payment', this)">Payments</button>
                    <button class="sw-btn" onclick="switchChart('tenants', this)">Tenants</button>
                    <button class="sw-btn" onclick="switchChart('maintenance', this)">Maintenance</button>
                    <button class="sw-btn" onclick="switchChart('visitors', this)">Visitors</button>
                </div>
            </div>
            <div class="chart-legend" id="chart-legend">
                <div class="chart-legend-item">
                    <div class="chart-legend-dot" style="background:#E8175D;"></div>
                    Collected
                </div>
                <div class="chart-legend-item">
                    <div class="chart-legend-dot" style="background:#f5a24b;"></div>
                    Unpaid
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        @if($latestEmergency)
            <div class="emergency-banner fade-up d4">
                <div class="emerg-ico-wrap pulse">
                    <img src="{{ asset('icons/panic.png') }}" alt="">
                </div>
                <div class="emerg-body">
                    <div class="emerg-label">Emergency Report</div>
                    <div class="emerg-detail">{{ $latestEmergency->location ?? 'Unknown Location' }} &mdash; {{ $latestEmergency->emergency_type }}</div>
                    <div class="emerg-status">{{ $latestEmergency->status }}</div>
                </div>
                <button class="emerg-btn" onclick="openModal('emergency-modal')">View All</button>
            </div>
        @else
            <div class="emergency-banner clear fade-up d4">
                <div class="emerg-ico-wrap">
                    <img src="{{ asset('icons/check.png') }}" alt="" class="check-icon">
                </div>
                <div class="emerg-body">
                    <div class="emerg-label">Emergency Status</div>
                    <div class="emerg-detail">All Clear</div>
                    <div class="emerg-status ok">No active emergencies</div>
                </div>
                <button class="emerg-btn ok" onclick="openModal('emergency-modal')">View History</button>
            </div>
        @endif

        <div class="panel fade-up d4" id="panel-maint">
            <div class="panel-head" onclick="togglePanel('maint')">
                <div class="panel-head-left">
                    <img src="{{ asset('icons/maintenance.png') }}" alt="">
                    Maintenance Requests
                </div>
                <div class="panel-head-right">
                    <span class="panel-badge">{{ $pendingMaintenance ?? 0 }} open</span>
                    <a href="{{ route('maintenance.index') }}" class="panel-link" onclick="event.stopPropagation()">See All</a>
                    <span class="panel-chevron open" id="chevron-maint">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
            </div>
            <div class="panel-body open" id="body-maint">
                <div class="panel-inner">
                    @if($maintenanceRequests->isEmpty())
                        <div class="empty-state">No pending maintenance requests.</div>
                    @else
                        @foreach($maintenanceRequests as $req)
                            <div class="maint-row" onclick="openMaintenanceModal({{ $req->request_id }}, '{{ addslashes($req->issue_type) }}', '{{ addslashes($req->description) }}', '{{ $req->urgency_level }}', '{{ $req->status }}', '{{ $req->assigned_to ?? 'Unassigned' }}', '{{ $req->tenant->room_number ?? 'N/A' }}')">
                                <div class="maint-type-icon">
                                    @if(str_contains(strtolower($req->issue_type ?? ''), 'plumb'))
                                        <img src="{{ asset('icons/plumbing.png') }}" alt="Plumbing" onerror="this.src='{{ asset('icons/maintenance.png') }}'">
                                    @elseif(str_contains(strtolower($req->issue_type ?? ''), 'elec'))
                                        <img src="{{ asset('icons/electrical.png') }}" alt="Electrical" onerror="this.src='{{ asset('icons/maintenance.png') }}'">
                                    @elseif(str_contains(strtolower($req->issue_type ?? ''), 'hvac'))
                                        <img src="{{ asset('icons/hvac.png') }}" alt="HVAC" onerror="this.src='{{ asset('icons/maintenance.png') }}'">
                                    @else
                                        <img src="{{ asset('icons/maintenance.png') }}" alt="Maintenance">
                                    @endif
                                </div>
                                <div class="maint-info">
                                    <div class="maint-title">
                                        {{ $req->issue_type }}
                                        @if($req->tenant) | {{ $req->tenant->room_number }} @endif
                                    </div>
                                    <div class="maint-id">REQ-{{ str_pad($req->request_id, 3, '0', STR_PAD_LEFT) }}</div>
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
                                <div class="maint-arrow">&#8250;</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="panel fade-up d5" id="panel-ann">
            <div class="panel-head" onclick="togglePanel('ann')">
                <div class="panel-head-left">
                    <img src="{{ asset('icons/announce.png') }}" alt="" onerror="this.src='{{ asset('icons/bell.png') }}'">
                    Latest Announcements
                </div>
                <div class="panel-head-right">
                    <span class="panel-badge">{{ $announcements->count() }} posted</span>
                    <button class="post-announce-btn" onclick="event.stopPropagation(); openPostModal()">+ Post</button>
                    <a href="{{ route('announcements.index') }}" class="panel-link" onclick="event.stopPropagation()">See All</a>
                    <span class="panel-chevron open" id="chevron-ann">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
            </div>
            <div class="panel-body open" id="body-ann">
                <div class="panel-inner">
                    @if($announcements->isEmpty())
                        <div class="empty-state" id="ann-empty">No announcements yet.</div>
                    @else
                        @foreach($announcements as $ann)
                            <div class="announce-item" id="ann-row-{{ $ann->announcement_id }}">
                                <div class="announce-item-left">
                                    <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;">
                                        <div class="announce-title">{{ $ann->title }}</div>
                                        <span class="priority-badge priority-{{ strtolower($ann->priority ?? 'low') }}">
                                            {{ ucfirst($ann->priority ?? 'Low') }}
                                        </span>
                                    </div>
                                    <div class="announce-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F d, Y · g:i A') }}</div>
                                </div>
                                <div class="announce-actions">
                                    <button class="announce-action-btn"
                                        onclick="openEditModal({{ $ann->announcement_id }}, '{{ addslashes($ann->title) }}', '{{ addslashes($ann->content) }}', '{{ $ann->priority }}', '{{ $ann->status }}')">
                                        Edit
                                    </button>
                                    <button class="announce-action-btn delete"
                                        onclick="openDeleteModal({{ $ann->announcement_id }})">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="right-col fade-up d5">

        <div class="card">
            <h3>Notifications</h3>
            @if($notifications->isEmpty())
                <div class="empty-state" style="padding:1rem 0;">No new notifications.</div>
            @else
                @foreach($notifications as $notif)
                    <div class="notif-item" onclick="openNotifModal('{{ addslashes($notif->message) }}', '{{ $notif->type ?? 'bell' }}', '{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}')">
                        <div class="notif-ico">
                            <img src="{{ asset('icons/' . ($notif->type ?? 'bell') . '.png') }}" alt=""
                                 onerror="this.src='{{ asset('icons/bell.png') }}'">
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
                                @if($log->tenant) for {{ $log->tenant->first_name }} {{ $log->tenant->last_name }} @endif
                            </div>
                            <div class="activity-time">{{ \Carbon\Carbon::parse($log->arrival_time)->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

</div>

@endsection


@section('modals')

<div class="modal-overlay" id="announce-modal" onclick="handleOverlayClick(event, 'announce-modal')">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Post Announcement</div>
            <button class="modal-close" onclick="closeModal('announce-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('announcements.store') }}" id="post-ann-form">
            @csrf
            <div class="modal-field">
                <label>Title *</label>
                <input type="text" name="title" id="ann-title" placeholder="e.g. Water Billing Reminder" required>
            </div>
            <div class="modal-field">
                <label>Message *</label>
                <textarea name="description" id="ann-body" placeholder="Write your announcement here..." required></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="modal-field">
                    <label>Priority</label>
                    <select name="priority" style="width:100%;padding:.6rem .85rem;border-radius:9px;border:1.5px solid var(--gray-light);font-family:var(--ff-body);font-size:.87rem;color:var(--ink);outline:none;">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status" style="width:100%;padding:.6rem .85rem;border-radius:9px;border:1.5px solid var(--gray-light);font-family:var(--ff-body);font-size:.87rem;color:var(--ink);outline:none;">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('announce-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Post</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="edit-ann-modal" onclick="handleOverlayClick(event, 'edit-ann-modal')">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Edit Announcement</div>
            <button class="modal-close" onclick="closeModal('edit-ann-modal')">&#x2715;</button>
        </div>
        <form method="POST" id="edit-ann-form">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Title *</label>
                <input type="text" name="title" id="edit-ann-title" required>
            </div>
            <div class="modal-field">
                <label>Message *</label>
                <textarea name="description" id="edit-ann-body" required></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="modal-field">
                    <label>Priority</label>
                    <select name="priority" id="edit-ann-priority" style="width:100%;padding:.6rem .85rem;border-radius:9px;border:1.5px solid var(--gray-light);font-family:var(--ff-body);font-size:.87rem;color:var(--ink);outline:none;">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status" id="edit-ann-status" style="width:100%;padding:.6rem .85rem;border-radius:9px;border:1.5px solid var(--gray-light);font-family:var(--ff-body);font-size:.87rem;color:var(--ink);outline:none;">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-ann-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="delete-ann-modal" onclick="handleOverlayClick(event, 'delete-ann-modal')">
    <div class="modal" style="max-width:380px;" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Delete Announcement</div>
            <button class="modal-close" onclick="closeModal('delete-ann-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;padding:.2rem 0 .4rem;">
            Are you sure you want to delete this announcement? This cannot be undone.
        </p>
        <form method="POST" id="delete-ann-form">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('delete-ann-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:var(--red);">Delete</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="emergency-modal" onclick="handleOverlayClick(event, 'emergency-modal')">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Emergency Alerts</div>
            <button class="modal-close" onclick="closeModal('emergency-modal')">&#x2715;</button>
        </div>
        <div class="emerg-modal-list">
            @if($allEmergencies->isEmpty())
                <div class="empty-state" style="padding:1.2rem 0;">No emergency reports found.</div>
            @else
                @foreach($allEmergencies as $emergency)
                    @php $isResolved = strtolower($emergency->status) === 'resolved'; @endphp
                    <div class="emerg-alert-card {{ $isResolved ? 'is-resolved' : 'is-active' }}">
                        <div class="emerg-alert-icon">
                            @if($isResolved)
                                <img src="{{ asset('icons/check.png') }}" alt="Resolved">
                            @else
                                <img src="{{ asset('icons/panic.png') }}" alt="Active">
                            @endif
                        </div>
                        <div class="emerg-alert-body">
                            <div class="emerg-alert-location">
                                {{ $emergency->location ?? 'Unknown Location' }} &mdash; {{ $emergency->emergency_type }}
                            </div>
                            <div class="emerg-alert-time">
                                {{ \Carbon\Carbon::parse($emergency->created_at)->format('F d, Y · g:i A') }}
                            </div>
                        </div>
                        <div class="emerg-alert-badge {{ $isResolved ? 'badge-resolved' : 'badge-active' }}">
                            {{ $isResolved ? 'Resolved' : ucfirst($emergency->status) }}
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

<div class="modal-overlay" id="notif-detail-modal" onclick="handleOverlayClick(event, 'notif-detail-modal')">
    <div class="modal" style="max-width:420px;" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title">Notification</div>
            <button class="modal-close" onclick="closeModal('notif-detail-modal')">&#x2715;</button>
        </div>
        <div style="padding:.3rem 0 .5rem;">
            <div style="display:flex;gap:1rem;align-items:flex-start;">
                <div style="width:48px;height:48px;border-radius:12px;flex-shrink:0;background:var(--petal);border:1.5px solid var(--baby-pink);display:flex;align-items:center;justify-content:center;">
                    <img id="nd-icon" src=""
                         style="width:22px;height:22px;object-fit:contain;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);"
                         alt="">
                </div>
                <div style="flex:1;min-width:0;">
                    <div id="nd-type" style="font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--ink-muted);"></div>
                    <div id="nd-message" style="font-size:.93rem;font-weight:600;color:var(--ink);margin-top:.25rem;line-height:1.55;"></div>
                    <div id="nd-time" style="font-size:.77rem;color:var(--ink-muted);margin-top:.45rem;"></div>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('notif-detail-modal')">Dismiss</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="maint-detail-modal" onclick="handleOverlayClick(event, 'maint-detail-modal')">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title" id="md-title"></div>
            <button class="modal-close" onclick="closeModal('maint-detail-modal')">&#x2715;</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:.75rem;padding:.2rem 0 .4rem;">
            <div>
                <span style="font-size:.75rem;font-weight:700;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.05em;">Room</span>
                <div id="md-room" style="font-size:.9rem;font-weight:600;color:var(--ink);margin-top:.2rem;"></div>
            </div>
            <div>
                <span style="font-size:.75rem;font-weight:700;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.05em;">Description</span>
                <div id="md-desc" style="font-size:.9rem;color:var(--ink);margin-top:.2rem;line-height:1.5;"></div>
            </div>
            <div>
                <span style="font-size:.75rem;font-weight:700;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.05em;">Assigned To</span>
                <div id="md-assign" style="font-size:.9rem;font-weight:600;color:var(--ink);margin-top:.2rem;"></div>
            </div>
            <div style="display:flex;gap:.5rem;" id="md-tags"></div>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('maint-detail-modal')">Close</button>
            <button class="btn-submit" id="md-view-btn">View Full Request</button>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {

    var CHARTS = {
        payment: {
            title: 'Monthly Payment Overview',
            sub:   'Collected vs unpaid water billing for the last 6 months',
            legend: [
                { color: '#E8175D', label: 'Collected' },
                { color: '#f5a24b', label: 'Unpaid' }
            ],
            type: 'bar',
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Collected',
                    data:  @json($chartCollected),
                    backgroundColor: @json($chartCollected).map(function(v){ return v === 0 ? 'rgba(232,23,93,0.12)' : 'rgba(232,23,93,0.85)'; }),
                    borderRadius: 6, borderSkipped: false,
                    barPercentage: 0.55, categoryPercentage: 0.7, minBarLength: 6
                },
                {
                    label: 'Unpaid',
                    data:  @json($chartUnpaid),
                    backgroundColor: @json($chartUnpaid).map(function(v){ return v === 0 ? 'rgba(245,162,75,0.12)' : 'rgba(245,162,75,0.85)'; }),
                    borderRadius: 6, borderSkipped: false,
                    barPercentage: 0.55, categoryPercentage: 0.7, minBarLength: 6
                }
            ],
            useScales: true,
            yFmt: function(v){ return v >= 1000 ? 'PHP ' + (v/1000).toFixed(0) + 'k' : 'PHP ' + v; },
            tipFmt: function(ctx){
                if (ctx.parsed.y === 0) return ' ' + ctx.dataset.label + ': No data';
                return ' ' + ctx.dataset.label + ': PHP ' + Number(ctx.parsed.y).toLocaleString('en-PH', { minimumFractionDigits: 2 });
            }
        },
        tenants: {
            title: 'Tenant Occupancy by Floor',
            sub:   'Active tenants per floor based on room number',
            legend: [{ color: '#E8175D', label: 'Tenants' }],
            type: 'bar',
            labels: @json($tenantsByFloor->pluck('floor')->map(fn($f) => 'Floor ' . $f)->values()),
            datasets: [
                {
                    label: 'Tenants',
                    data:  @json($tenantsByFloor->pluck('cnt')->values()),
                    backgroundColor: 'rgba(232,23,93,0.82)',
                    borderRadius: 6, borderSkipped: false,
                    barPercentage: 0.5, categoryPercentage: 0.65, minBarLength: 4
                }
            ],
            useScales: true,
            yFmt: function(v){ return Math.round(v); },
            tipFmt: function(ctx){ return ' ' + ctx.dataset.label + ': ' + ctx.parsed.y + ' tenants'; }
        },
        maintenance: {
            title: 'Maintenance by Urgency',
            sub:   'Open requests grouped by priority level',
            legend: [
                { color: '#E8175D', label: 'Urgent' },
                { color: '#f5a24b', label: 'Moderate' },
                { color: '#29BD9B', label: 'Low' }
            ],
            type: 'doughnut',
            labels: @json($maintenanceByUrgency->pluck('urgency_level')->map(fn($u) => ucfirst($u))->values()),
            datasets: [
                {
                    label: 'Requests',
                    data:  @json($maintenanceByUrgency->pluck('cnt')->values()),
                    backgroundColor: ['rgba(232,23,93,0.85)', 'rgba(245,162,75,0.85)', 'rgba(29,189,155,0.85)'],
                    borderWidth: 0,
                    hoverOffset: 6
                }
            ],
            useScales: false,
            yFmt: function(v){ return v; },
            tipFmt: function(ctx){ return ' ' + ctx.label + ': ' + ctx.raw + ' requests'; }
        },
        visitors: {
            title: 'Visitor Log Activity',
            sub:   'Daily visitor entries over the past 7 days',
            legend: [{ color: '#E8175D', label: 'Visitors' }],
            type: 'line',
            labels: @json($visitorsByDay->pluck('day')->values()),
            datasets: [
                {
                    label: 'Visitors',
                    data:  @json($visitorsByDay->pluck('cnt')->values()),
                    borderColor: 'rgba(232,23,93,0.9)',
                    backgroundColor: 'rgba(232,23,93,0.08)',
                    fill: true, tension: 0.4,
                    pointRadius: 4, pointBackgroundColor: '#E8175D',
                    borderWidth: 2
                }
            ],
            useScales: true,
            yFmt: function(v){ return Math.round(v); },
            tipFmt: function(ctx){ return ' ' + ctx.dataset.label + ': ' + ctx.parsed.y; }
        }
    };

    var activeChart = null;

    function buildLegend(items) {
        var el = document.getElementById('chart-legend');
        el.innerHTML = items.map(function(item) {
            return '<div class="chart-legend-item"><div class="chart-legend-dot" style="background:' + item.color + ';"></div>' + item.label + '</div>';
        }).join('');
    }

    function buildChart(key) {
        var cfg = CHARTS[key];

        document.getElementById('chart-title').textContent = cfg.title;
        document.getElementById('chart-sub').textContent   = cfg.sub;
        buildLegend(cfg.legend);

        if (activeChart) { activeChart.destroy(); activeChart = null; }

        var ctx = document.getElementById('mainChart').getContext('2d');

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 320, easing: 'easeInOutQuart' },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    borderColor: 'rgba(232,23,93,0.2)',
                    borderWidth: 1,
                    titleColor: '#1a1a2e',
                    bodyColor: '#555',
                    padding: 12,
                    callbacks: { label: cfg.tipFmt }
                }
            }
        };

        if (cfg.useScales) {
            options.scales = {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { size: 11, weight: '600' }, color: '#999', maxRotation: 45, minRotation: 45, autoSkip: false, padding: 8 }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    border: { display: false, dash: [4,4] },
                    ticks: { font: { size: 11 }, color: '#bbb', callback: cfg.yFmt },
                    beginAtZero: true
                }
            };
        }

        if (cfg.type === 'doughnut') { options.cutout = '62%'; }

        activeChart = new Chart(ctx, {
            type: cfg.type,
            data: { labels: cfg.labels, datasets: cfg.datasets },
            options: options
        });
    }

    window.switchChart = function(key, btn) {
        document.querySelectorAll('.sw-btn').forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        buildChart(key);
    };

    buildChart('payment');

})();

window.togglePanel = function(id) {
    var body = document.getElementById('body-' + id);
    var chev = document.getElementById('chevron-' + id);
    var open = body.classList.contains('open');
    body.classList.toggle('open', !open);
    chev.classList.toggle('open', !open);
};

window.handleOverlayClick = function(event, modalId) {
    if (event.target === event.currentTarget) {
        closeModal(modalId);
    }
};

window.openPostModal = function() {
    document.getElementById('ann-title').value = '';
    document.getElementById('ann-body').value  = '';
    openModal('announce-modal');
};

window.openEditModal = function(id, title, content, priority, status) {
    document.getElementById('edit-ann-title').value    = title;
    document.getElementById('edit-ann-body').value     = content;
    document.getElementById('edit-ann-priority').value = priority;
    document.getElementById('edit-ann-status').value   = status;
    document.getElementById('edit-ann-form').action    = '/announcements/' + id;
    openModal('edit-ann-modal');
};

window.openDeleteModal = function(id) {
    document.getElementById('delete-ann-form').action = '/announcements/' + id;
    openModal('delete-ann-modal');
};

window.openNotifModal = function(message, type, time) {
    document.getElementById('nd-message').textContent = message;
    document.getElementById('nd-time').textContent    = time;
    document.getElementById('nd-type').textContent    = type.charAt(0).toUpperCase() + type.slice(1);
    var icon = document.getElementById('nd-icon');
    icon.src = '{{ asset('icons/') }}' + type + '.png';
    icon.onerror = function() { this.src = '{{ asset('icons/bell.png') }}'; };
    openModal('notif-detail-modal');
};

window.exportSummary = function() {
    var rows = [
        ['Metric', 'Value'],
        ['Total Tenants',        '{{ $totalTenants }}'],
        ['Unpaid Bills',         '{{ $pendingPayments }}'],
        ['Maintenance Requests', '{{ $pendingMaintenance }}'],
        ['Unresolved Reports',   '{{ $unresolvedReports }}'],
    ];
    var csv  = rows.map(function(r){ return r.join(','); }).join('\n');
    var blob = new Blob([csv], { type: 'text/csv' });
    var a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'dormease-summary.csv';
    a.click();
    showToast('Summary exported as CSV!', 'success');
};

@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
    showToast("{{ session('error') }}", 'error');
@endif

window.openMaintenanceModal = function(id, type, desc, urgency, status, assigned, room) {
    document.getElementById('md-title').textContent  = type;
    document.getElementById('md-room').textContent   = room;
    document.getElementById('md-desc').textContent   = desc;
    document.getElementById('md-assign').textContent = assigned;

    var urgencyClass = { urgent: 'tag-urgent', moderate: 'tag-moderate' }[urgency.toLowerCase()] || 'tag-low';
    var statusClass  = status.toLowerCase() === 'in_progress' ? 'tag-progress' : 'tag-pending';

    document.getElementById('md-tags').innerHTML =
        '<span class="tag ' + urgencyClass + '">' + urgency + '</span>' +
        '<span class="tag ' + statusClass  + '">' + status.replace('_', ' ') + '</span>';

    document.getElementById('md-view-btn').onclick = function() {
        window.location = '{{ route('maintenance.index') }}';
    };

    openModal('maint-detail-modal');
};
</script>
@endsection