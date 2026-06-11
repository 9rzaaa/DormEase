@extends('fdlayout')

@section('title', 'DormEase: Front Desk Dashboard')
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
        grid-template-columns: repeat(4, 1fr);
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

    .chart-card-title { font-size: 1rem; font-weight: 700; color: var(--ink); line-height: 1.2; display: flex; align-items: center; gap: .45rem; }
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

    .panel-body {
        border-top: 1px solid var(--petal);
        overflow: hidden;
        max-height: 0;
        transition: max-height .38s cubic-bezier(.4,0,.2,1);
    }
    .panel-body.open { max-height: 700px; }

    .panel-inner { padding: .3rem .5rem .5rem; }

    .activity-row {
        display: grid;
        grid-template-columns: 1fr 16px;
        align-items: center;
        gap: 1rem;
        padding: .85rem .5rem;
        border-bottom: 1px solid var(--petal);
        cursor: pointer; transition: background .15s; border-radius: 8px;
    }
    .activity-row:last-child { border-bottom: none; }
    .activity-row:hover { background: var(--petal); }

    .activity-info { min-width: 0; }
    .activity-title { font-size: .88rem; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .activity-time  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .activity-arrow { color: var(--hot-pink); font-size: 1rem; flex-shrink: 0; }

    .announce-item {
        padding: .85rem .5rem;
        border-bottom: 1px solid var(--petal);
        border-radius: 8px;
        transition: background .15s;
        cursor: pointer;
    }
    .announce-item:last-child { border-bottom: none; }
    .announce-item:hover { background: var(--petal); }
    .announce-title { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .announce-date  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }

    .priority-badge { display: inline-block; font-size: .68rem; font-weight: 800; padding: .15rem .5rem; border-radius: 5px; border: 1.5px solid; margin-left: .4rem; vertical-align: middle; }
    .priority-low      { color: #1a7a4a; border-color: #5bcb8a;            background: #eafbf0; }
    .priority-moderate { color: #a84c00; border-color: #f5a24b;            background: #fff6ed; }
    .priority-high     { color: #C4003A; border-color: var(--bright-pink); background: var(--baby-pink); }

    .empty-state { text-align: center; padding: 1.8rem; color: var(--ink-muted); font-size: .88rem; }

    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .right-col .card h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: .9rem; }

    .notif-item {
        display: flex; align-items: flex-start; gap: .7rem;
        padding: .6rem .5rem;
        border-bottom: 1px solid var(--petal);
        cursor: pointer;
        transition: background .15s;
        border-radius: 6px;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--petal); }

    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }
    .notif-ico { width: 28px; height: 28px; border-radius: 8px; background: var(--petal); border: 1.5px solid var(--baby-pink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .notif-ico img { width: 14px; height: 14px; object-fit: contain; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }

    .icon-sm { width: 16px; height: 16px; object-fit: contain; }
    .icon-md { width: 20px; height: 20px; object-fit: contain; }

    .content-col .card,
    .right-col .card {
        border-color: var(--baby-pink);
    }

    .emerg-modal-list {
        display: flex;
        flex-direction: column;
        gap: .65rem;
        max-height: 380px;
        overflow-y: auto;
        padding: .2rem .25rem .4rem .25rem;
        margin: .2rem 0 .4rem;
        scrollbar-width: thin;
        scrollbar-color: var(--baby-pink) transparent;
    }
    .emerg-modal-list::-webkit-scrollbar { width: 5px; }
    .emerg-modal-list::-webkit-scrollbar-track { background: transparent; }
    .emerg-modal-list::-webkit-scrollbar-thumb { background: var(--baby-pink); border-radius: 99px; }
    .emerg-modal-list::-webkit-scrollbar-thumb:hover { background: var(--bright-pink); }

    .ann-modal-header { padding: 1.4rem 1.5rem 0; }
    .ann-modal-top {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 1rem; margin-bottom: 1rem;
    }
    .ann-modal-title-text { font-size: 1.1rem; font-weight: 800; color: var(--ink); line-height: 1.3; flex: 1; }
    .ann-modal-badges { display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; margin-bottom: .9rem; }
    .ann-modal-meta-row {
        display: flex; align-items: center; gap: 1.2rem;
        font-size: .78rem; color: var(--ink-muted);
        padding-bottom: .9rem; border-bottom: 1.5px solid var(--petal);
    }
    .ann-modal-meta-item { display: flex; align-items: center; gap: .3rem; }
    .ann-modal-meta-item img { width: 13px; height: 13px; opacity: .45; }

    .ann-tabs {
        display: flex; align-items: center; gap: 0;
        padding: 0 1.5rem;
        border-bottom: 1.5px solid var(--petal);
        margin-top: .1rem;
    }
    .ann-tab {
        padding: .65rem 1rem; font-size: .8rem; font-weight: 700;
        color: var(--ink-muted); cursor: pointer; border: none;
        background: transparent; border-bottom: 2.5px solid transparent;
        margin-bottom: -1.5px; transition: color .2s, border-color .2s;
        font-family: var(--ff-body); display: flex; align-items: center; gap: .35rem;
    }
    .ann-tab:hover { color: var(--bright-pink); }
    .ann-tab.active { color: var(--bright-pink); border-bottom-color: var(--bright-pink); }
    .ann-tab-badge {
        background: var(--petal); color: var(--hot-pink);
        font-size: .65rem; font-weight: 800; padding: .1rem .4rem;
        border-radius: 999px; border: 1px solid var(--baby-pink);
    }
    .ann-tab-pane { display: none; padding: 1.2rem 1.5rem 1.5rem; }
    .ann-tab-pane.active { display: block; }
    .ann-content-body { font-size: .875rem; color: var(--ink); line-height: 1.75; white-space: pre-wrap; }

    .ann-priority {
        display: inline-flex; align-items: center; padding: .18rem .55rem;
        border-radius: 6px; font-size: .68rem; font-weight: 800;
        letter-spacing: .04em; text-transform: uppercase; width: fit-content;
    }
    .ann-priority-low      { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .ann-priority-moderate { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .ann-priority-high     { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }

    .file-preview-grid { display: flex; flex-direction: column; gap: .75rem; }
    .file-preview-item { border: 1.5px solid var(--baby-pink); border-radius: 14px; overflow: hidden; background: var(--white); }
    .file-preview-bar {
        display: flex; align-items: center; justify-content: space-between;
        padding: .6rem .9rem; background: var(--petal);
        border-bottom: 1px solid var(--baby-pink);
    }
    .file-preview-name { font-size: .78rem; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: .4rem; }
    .file-preview-name img { width: 13px; height: 13px; opacity: .5; }
    .file-preview-actions { display: flex; align-items: center; gap: .35rem; }
    .file-action-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--baby-pink); background: var(--white);
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: .2s; text-decoration: none; flex-shrink: 0;
    }
    .file-action-btn:hover { border-color: var(--bright-pink); background: var(--petal); box-shadow: 0 3px 10px rgba(255,45,120,.15); }
    .file-action-btn svg { width: 14px; height: 14px; stroke: var(--bright-pink); flex-shrink: 0; }
    .file-preview-body { padding: .8rem; }
    .file-preview-body img {
        width: 100%; max-height: 260px; object-fit: cover;
        border-radius: 8px; display: block; cursor: zoom-in; transition: opacity .2s;
    }
    .file-preview-body img:hover { opacity: .88; }
    .file-preview-body iframe { width: 100%; height: 320px; border: none; border-radius: 8px; display: block; }
    .file-preview-unsupported {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: .5rem; padding: 1.5rem;
        color: var(--ink-muted); font-size: .8rem; text-align: center;
    }
    .file-preview-unsupported img { width: 32px; height: 32px; opacity: .3; margin-bottom: .25rem; }
    .no-files-state {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 2rem; gap: .5rem;
        color: var(--ink-muted); font-size: .82rem; text-align: center;
    }
    .no-files-state img { width: 36px; height: 36px; opacity: .25; margin-bottom: .25rem; }

    .lightbox-overlay {
        position: fixed; inset: 0; z-index: 2000;
        background: rgba(0,0,0,.92); display: none;
        align-items: center; justify-content: center;
        padding: 1.5rem; box-sizing: border-box;
    }
    .lightbox-overlay.open { display: flex; }
    .lightbox-inner { position: relative; max-width: 100%; max-height: 100%; display: flex; align-items: center; justify-content: center; }
    .lightbox-inner img { max-width: min(92vw,1100px); max-height: 88vh; object-fit: contain; border-radius: 10px; box-shadow: 0 24px 64px rgba(0,0,0,.6); display: block; }
    .lightbox-close {
        position: fixed; top: 1.1rem; right: 1.3rem;
        width: 38px; height: 38px; border-radius: 50%;
        background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.25);
        color: #fff; font-size: 1.1rem; display: flex;
        align-items: center; justify-content: center;
        cursor: pointer; transition: background .2s; z-index: 2001;
    }
    .lightbox-close:hover { background: rgba(255,255,255,.22); }

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
        .emerg-modal-list { max-height: 260px; }
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
                    <div class="stat-icon"><img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt=""></div>
                    <div class="stat-num">{{ $totalTenants ?? 0 }}</div>
                    <div class="stat-label">Active Tenants</div>
                    <div class="stat-sub">Currently Active</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/bed.png') }}" class="icon-md" alt=""></div>
                    <div class="stat-num">{{ $occupiedUnits ?? 0 }}</div>
                    <div class="stat-label">Units Occupied</div>
                    <div class="stat-sub">Out of {{ $totalUnits ?? 0 }} total units</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/visitor.png') }}" class="icon-md" alt=""></div>
                    <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                    <div class="stat-label">Visitors Today</div>
                    <div class="stat-sub">Logged in today</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/warn.png') }}" class="icon-md" alt=""></div>
                    <div class="stat-num">{{ $activeEmergencies ?? 0 }}</div>
                    <div class="stat-label">Active Emergencies</div>
                    <div class="stat-sub">Ongoing reports</div>
                </div>
            </div>
        </div>

        <div class="chart-card fade-up d3">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title">
                        <span id="chart-title">Visitor Traffic This Week</span>
                    </div>
                    <div class="chart-card-sub" id="chart-sub">Daily visitor count for the last 7 days</div>
                </div>
                <div class="chart-switcher">
                    <button class="sw-btn active" onclick="switchChart('visitors', this)">Visitors</button>
                    <button class="sw-btn" onclick="switchChart('tenants', this)">Tenants</button>
                    <button class="sw-btn" onclick="switchChart('emergency', this)">Emergencies</button>
                </div>
            </div>
            <div class="chart-legend" id="chart-legend">
                <div class="chart-legend-item">
                    <div class="chart-legend-dot" style="background:#E8175D;"></div>
                    Visitors
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

        <div class="panel fade-up d4" id="panel-activity">
            <div class="panel-head" onclick="togglePanel('activity')">
                <div class="panel-head-left">
                    <img src="{{ asset('icons/visitor.png') }}" alt="">
                    Recent Visitor Activity
                </div>
                <div class="panel-head-right">
                    <span class="panel-badge">{{ $recentActivities->count() }} entries</span>
                    <a href="{{ route('frontdesk.visitors') }}" class="panel-link" onclick="event.stopPropagation()">See All</a>
                    <span class="panel-chevron open" id="chevron-activity">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
            </div>
            <div class="panel-body open" id="body-activity">
                <div class="panel-inner">
                    @if($recentActivities->isEmpty())
                        <div class="empty-state">No recent visitor activity.</div>
                    @else
                        @foreach($recentActivities as $log)
                            <div class="activity-row"
                                 onclick="openVisitorModal(this)"
                                 data-visitor='{!! json_encode([
                                     "name"      => $log->visitor_name,
                                     "status"    => $log->departure_time ? "Checked Out" : "Checked In",
                                     "tenant"    => $log->tenant ? $log->tenant->first_name . " " . $log->tenant->last_name : "N/A",
                                     "arrival"   => \Carbon\Carbon::parse($log->arrival_time)->format("F d, Y, g:i A"),
                                     "departure" => $log->departure_time ? \Carbon\Carbon::parse($log->departure_time)->format("F d, Y, g:i A") : "",
                                 ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}'>
                                <div class="activity-info">
                                    <div class="activity-title">
                                        {{ $log->visitor_name }} &mdash; {{ $log->departure_time ? 'Checked Out' : 'Checked In' }}
                                        @if($log->tenant) for {{ $log->tenant->first_name }} {{ $log->tenant->last_name }} @endif
                                    </div>
                                    <div class="activity-time">{{ \Carbon\Carbon::parse($log->arrival_time)->format('F d, Y, g:i A') }}</div>
                                </div>
                                <div class="activity-arrow">&#8250;</div>
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
                    <span class="panel-badge">{{ $announcements->count() }} {{ Str::plural('announcement', $announcements->count()) }}</span>
                    <a href="{{ route('frontdesk.announcements') }}" class="panel-link" onclick="event.stopPropagation()">See All</a>
                    <span class="panel-chevron open" id="chevron-ann">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
            </div>
            <div class="panel-body open" id="body-ann">
                <div class="panel-inner">
                    @if($announcements->isEmpty())
                        <div class="empty-state">No announcements yet.</div>
                    @else
                        @foreach($announcements as $ann)
                            <div class="announce-item"
                                 onclick="openAnnModal(this)"
                                 data-ann='{!! json_encode([
                                     "title"      => $ann->title,
                                     "content"    => $ann->content,
                                     "priority"   => $ann->priority ?? "low",
                                     "status"     => $ann->status ?? "active",
                                     "posted_at"  => \Carbon\Carbon::parse($ann->posted_at)->format("F d, Y · g:i A"),
                                     "attachment" => $ann->attachment ?? "",
                                 ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}'>
                                <div style="display:flex;align-items:center;gap:.4rem;">
                                    <div class="announce-title">{{ $ann->title }}</div>
                                    <span class="priority-badge priority-{{ strtolower($ann->priority ?? 'low') }}">
                                        {{ ucfirst($ann->priority ?? 'Low') }}
                                    </span>
                                </div>
                                <div class="announce-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F d, Y · g:i A') }}</div>
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
                @foreach($notifications->take(6) as $notif)
                    @php
                        $notifTypeLabel = match($notif->type ?? '') {
                            'visitor_registration', 'visitor_checkin', 'visitor_checkout' => 'visitor',
                            'emergency_new'    => 'emergency',
                            'announcement_new' => 'announcement',
                            default            => 'general',
                        };
                        $notifIcon = match($notif->type ?? '') {
                            'visitor_registration', 'visitor_checkin', 'visitor_checkout' => 'nav-visit',
                            'emergency_new'    => 'warn',
                            'announcement_new' => 'nav-announ',
                            default            => 'bell',
                        };
                    @endphp
                    <div class="notif-item"
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
                        <div class="notif-ico">
                            <img src="{{ asset('icons/' . $notifIcon . '.png') }}" alt=""
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
    </div>

</div>

@endsection


@section('modals')

<div class="lightbox-overlay" id="dash-lightbox" onclick="closeDashLightbox()">
    <button class="lightbox-close" onclick="closeDashLightbox()">&#x2715;</button>
    <div class="lightbox-inner" onclick="event.stopPropagation()">
        <img id="dash-lightbox-img" src="" alt="">
    </div>
</div>

<div class="modal-overlay" id="ann-view-modal" onclick="handleOverlayClick(event,'ann-view-modal')">
    <div class="modal" style="max-width:560px;padding:0;overflow:hidden;" onclick="event.stopPropagation()">
        <div class="ann-modal-header">
            <div class="ann-modal-top">
                <div class="ann-modal-title-text" id="avm-title"></div>
                <button class="modal-close" onclick="closeModal('ann-view-modal')" style="flex-shrink:0;">&#x2715;</button>
            </div>
            <div class="ann-modal-badges" id="avm-badges"></div>
            <div class="ann-modal-meta-row" id="avm-meta"></div>
        </div>

        <div class="ann-tabs" id="avm-tabs">
            <button class="ann-tab active" data-avmtab="content" onclick="switchAvmTab(this,'content')">
                <img src="{{ asset('icons/eye.png') }}" style="width:13px;height:13px;opacity:.6;" alt="">
                Content
            </button>
            <button class="ann-tab" data-avmtab="files" onclick="switchAvmTab(this,'files')">
                <img src="{{ asset('icons/attach.png') }}" style="width:13px;height:13px;opacity:.6;" alt="">
                Attachments
                <span class="ann-tab-badge" id="avm-file-count">0</span>
            </button>
        </div>

        <div class="ann-tab-pane active" id="avmtab-content">
            <div class="ann-content-body" id="avm-body"></div>
        </div>
        <div class="ann-tab-pane" id="avmtab-files">
            <div class="file-preview-grid" id="avm-files"></div>
        </div>
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
                    <div style="
                        display:flex;align-items:center;gap:.85rem;
                        padding:.85rem 1rem;border-radius:12px;border:1.5px solid;
                        flex-shrink:0;
                        {{ $isResolved ? 'border-color:#5bcb8a;background:#eafbf0;' : 'border-color:var(--bright-pink);background:var(--petal);' }}
                    ">
                        <div style="
                            width:40px;height:40px;border-radius:10px;flex-shrink:0;
                            display:flex;align-items:center;justify-content:center;
                            {{ $isResolved ? 'background:#d3f7e6;' : 'background:var(--baby-pink);' }}
                        ">
                            @if($isResolved)
                                <img src="{{ asset('icons/check.png') }}"
                                     style="width:18px;height:18px;object-fit:contain;filter:brightness(0) saturate(100%) invert(27%) sepia(97%) saturate(500%) hue-rotate(100deg) brightness(90%);"
                                     alt="Resolved">
                            @else
                                <img src="{{ asset('icons/panic.png') }}"
                                     style="width:18px;height:18px;object-fit:contain;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);"
                                     alt="Active">
                            @endif
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.88rem;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $emergency->location ?? 'Unknown Location' }} &mdash; {{ $emergency->emergency_type }}
                            </div>
                            <div style="font-size:.75rem;color:var(--ink-muted);margin-top:.18rem;">
                                {{ \Carbon\Carbon::parse($emergency->created_at)->format('F d, Y · g:i A') }}
                            </div>
                        </div>
                        <div style="
                            font-size:.7rem;font-weight:800;padding:.22rem .7rem;
                            border-radius:6px;border:1.5px solid;flex-shrink:0;white-space:nowrap;
                            {{ $isResolved
                                ? 'color:#1a7a4a;border-color:#5bcb8a;background:#eafbf0;'
                                : 'color:#C4003A;border-color:var(--bright-pink);background:var(--baby-pink);' }}
                        ">
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

<div class="modal-overlay" id="visitor-detail-modal" onclick="handleOverlayClick(event, 'visitor-detail-modal')">
    <div class="modal" style="max-width:420px;" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title" id="vd-name"></div>
            <button class="modal-close" onclick="closeModal('visitor-detail-modal')">&#x2715;</button>
        </div>
        <div style="display:flex; flex-direction:column; gap:.75rem; padding:.2rem 0 .4rem;">
            <div>
                <span style="font-size:.75rem; font-weight:700; color:var(--ink-muted); text-transform:uppercase; letter-spacing:.05em;">Status</span>
                <div id="vd-status" style="font-size:.9rem; font-weight:600; color:var(--ink); margin-top:.2rem;"></div>
            </div>
            <div>
                <span style="font-size:.75rem; font-weight:700; color:var(--ink-muted); text-transform:uppercase; letter-spacing:.05em;">Visiting</span>
                <div id="vd-tenant" style="font-size:.9rem; font-weight:600; color:var(--ink); margin-top:.2rem;"></div>
            </div>
            <div>
                <span style="font-size:.75rem; font-weight:700; color:var(--ink-muted); text-transform:uppercase; letter-spacing:.05em;">Arrival Time</span>
                <div id="vd-arrival" style="font-size:.9rem; font-weight:600; color:var(--ink); margin-top:.2rem;"></div>
            </div>
            <div id="vd-departure-wrap">
                <span style="font-size:.75rem; font-weight:700; color:var(--ink-muted); text-transform:uppercase; letter-spacing:.05em;">Departure Time</span>
                <div id="vd-departure" style="font-size:.9rem; font-weight:600; color:var(--ink); margin-top:.2rem;"></div>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('visitor-detail-modal')">Close</button>
            <button class="btn-submit" onclick="window.location='{{ route('frontdesk.visitors') }}'">View All Visitors</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {

    var CHARTS = {
        visitors: {
            title: 'Visitor Traffic This Week',
            sub:   'Daily visitor count for the last 7 days',
            legend: [{ color: '#E8175D', label: 'Visitors' }],
            type: 'line',
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Visitors',
                    data:  @json($chartVisitors),
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
        emergency: {
            title: 'Emergencies by Status',
            sub:   'Breakdown of all emergency reports by status',
            legend: [
                { color: '#E8175D', label: 'Active' },
                { color: '#f5a24b', label: 'Pending' },
                { color: '#29BD9B', label: 'Resolved' }
            ],
            type: 'doughnut',
            labels: @json($emergencyByType->pluck('status')->map(fn($s) => ucfirst($s))->values()),
            datasets: [
                {
                    label: 'Emergencies',
                    data:  @json($emergencyByType->pluck('cnt')->values()),
                    backgroundColor: ['rgba(232,23,93,0.85)', 'rgba(245,162,75,0.85)', 'rgba(29,189,155,0.85)', 'rgba(56,141,255,0.85)'],
                    borderWidth: 0,
                    hoverOffset: 6
                }
            ],
            useScales: false,
            yFmt: function(v){ return v; },
            tipFmt: function(ctx){ return ' ' + ctx.label + ': ' + ctx.raw + ' reports'; }
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

    buildChart('visitors');
})();

window.togglePanel = function(id) {
    var body = document.getElementById('body-' + id);
    var chev = document.getElementById('chevron-' + id);
    var open = body.classList.contains('open');
    body.classList.toggle('open', !open);
    chev.classList.toggle('open', !open);
};

window.exportSummary = function() {
    var rows = [
        ['Metric', 'Value'],
        ['Total Tenants',      '{{ $totalTenants ?? 0 }}'],
        ['Units Occupied',     '{{ $occupiedUnits ?? 0 }}'],
        ['Visitors Today',     '{{ $visitorsToday ?? 0 }}'],
        ['Active Emergencies', '{{ $activeEmergencies ?? 0 }}'],
    ];
    var csv  = rows.map(function(r){ return r.join(','); }).join('\n');
    var blob = new Blob([csv], { type: 'text/csv' });
    var a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'frontdesk-summary.csv';
    a.click();
    showToast('Summary exported as CSV!', 'success');
};

window.openVisitorModal = function(el) {
    var data;
    try { data = JSON.parse(el.dataset.visitor); }
    catch(e) { return; }
    document.getElementById('vd-name').textContent    = data.name;
    document.getElementById('vd-status').textContent  = data.status;
    document.getElementById('vd-tenant').textContent  = data.tenant;
    document.getElementById('vd-arrival').textContent = data.arrival;
    var depWrap = document.getElementById('vd-departure-wrap');
    if (data.departure) {
        document.getElementById('vd-departure').textContent = data.departure;
        depWrap.style.display = 'block';
    } else {
        depWrap.style.display = 'none';
    }
    openModal('visitor-detail-modal');
};

function escHtml(str) {
    return (str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function getFiles(attachment) {
    if (!attachment) return [];
    return attachment.split(',').map(function(f){ return f.trim(); }).filter(Boolean);
}

function fileExt(path) {
    return (path.split('.').pop() || '').toLowerCase();
}

function avmPriorityBadge(p) {
    var map = {
        low:      '<span class="ann-priority ann-priority-low">Low</span>',
        moderate: '<span class="ann-priority ann-priority-moderate">Moderate</span>',
        high:     '<span class="ann-priority ann-priority-high">High</span>',
    };
    return map[p] ?? '<span class="ann-priority ann-priority-low">Low</span>';
}

function avmStatusBadge(s) {
    return s === 'closed'
        ? '<span class="ann-priority" style="background:#f5f5f5;color:#666;border:1px solid #ddd;">Closed</span>'
        : '<span class="ann-priority" style="background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7;">Active</span>';
}

window.openDashLightbox = function(url) {
    document.getElementById('dash-lightbox-img').src = url;
    document.getElementById('dash-lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
};

window.closeDashLightbox = function() {
    document.getElementById('dash-lightbox').classList.remove('open');
    document.getElementById('dash-lightbox-img').src = '';
    document.body.style.overflow = '';
};

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDashLightbox();
});

function buildAvmFilePreview(filePath) {
    var name     = filePath.split('/').pop();
    var ext      = fileExt(filePath);
    var url      = filePath.startsWith('http') ? filePath : '/storage/' + filePath;
    var isImage  = ['jpg','jpeg','png','gif','webp','svg','bmp'].includes(ext);
    var isPdf    = ext === 'pdf';

    var previewHtml = '';
    if (isImage) {
        previewHtml = '<div class="file-preview-body"><img src="' + url + '" alt="' + escHtml(name) + '" loading="lazy" onclick="openDashLightbox(\'' + url + '\')" title="Click to view full size"></div>';
    } else if (isPdf) {
        previewHtml = '<div class="file-preview-body"><iframe src="' + url + '" title="' + escHtml(name) + '"></iframe></div>';
    } else {
        previewHtml = '<div class="file-preview-unsupported"><img src="{{ asset("icons/attach.png") }}" alt=""><span>Preview not available for <strong>.' + ext + '</strong> files.</span></div>';
    }

    var expandIcon = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>';
    var openIcon   = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>';
    var dlIcon     = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>';

    var primaryBtn = isImage
        ? '<button class="file-action-btn" onclick="openDashLightbox(\'' + url + '\')" title="View full size">' + expandIcon + '</button>'
        : '<a href="' + url + '" target="_blank" class="file-action-btn" title="Open">' + openIcon + '</a>';

    return '<div class="file-preview-item">'
        + '<div class="file-preview-bar">'
        + '<div class="file-preview-name"><img src="{{ asset("icons/attach.png") }}" alt="">' + escHtml(name) + '</div>'
        + '<div class="file-preview-actions">' + primaryBtn + '<a href="' + url + '" download class="file-action-btn" title="Download">' + dlIcon + '</a></div>'
        + '</div>'
        + previewHtml
        + '</div>';
}

window.switchAvmTab = function(btn, tabId) {
    document.querySelectorAll('#ann-view-modal .ann-tab').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('#ann-view-modal .ann-tab-pane').forEach(function(p){ p.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('avmtab-' + tabId).classList.add('active');
};

window.openAnnModal = function(el) {
    var data;
    try { data = JSON.parse(el.dataset.ann); }
    catch(e) { return; }

    var files = getFiles(data.attachment);

    document.getElementById('avm-title').textContent = data.title ?? '';
    document.getElementById('avm-badges').innerHTML  = avmPriorityBadge(data.priority) + ' ' + avmStatusBadge(data.status);
    document.getElementById('avm-meta').innerHTML    =
        '<div class="ann-modal-meta-item"><img src="{{ asset("icons/eye.png") }}" alt=""><span>Posted ' + escHtml(data.posted_at) + '</span></div>'
        + '<div class="ann-modal-meta-item"><img src="{{ asset("icons/attach.png") }}" alt=""><span>' + files.length + ' attachment' + (files.length !== 1 ? 's' : '') + '</span></div>';

    document.getElementById('avm-body').textContent      = data.content ?? '';
    document.getElementById('avm-file-count').textContent = files.length;
    document.getElementById('avm-files').innerHTML        = files.length
        ? files.map(buildAvmFilePreview).join('')
        : '<div class="no-files-state"><img src="{{ asset("icons/attach.png") }}" alt=""><span>No attachments on this announcement.</span></div>';

    document.querySelectorAll('#ann-view-modal .ann-tab').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('#ann-view-modal .ann-tab-pane').forEach(function(p){ p.classList.remove('active'); });
    document.querySelector('#ann-view-modal .ann-tab[data-avmtab="content"]').classList.add('active');
    document.getElementById('avmtab-content').classList.add('active');

    openModal('ann-view-modal');
};

window.handleOverlayClick = function(e, modalId) {
    if (e.target === document.getElementById(modalId)) closeModal(modalId);
};

@if(session('success'))
    showToast("{{ addslashes(session('success')) }}", 'success');
@endif
@if(session('error'))
    showToast("{{ addslashes(session('error')) }}", 'error');
@endif
</script>
@endsection