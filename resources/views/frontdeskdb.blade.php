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
    .emergency-banner.clear { border-color: #5bcb8a; }

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
    .emerg-btn.ok { background: linear-gradient(135deg, #1a7a4a, #2ecc71); }

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

    .activity-avatar {
        width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--baby-pink), var(--hot-pink));
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; font-weight: 800; color: var(--white);
    }
    .activity-info { min-width: 0; }
    .activity-title { font-size: .88rem; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .activity-time  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .activity-arrow { color: var(--hot-pink); font-size: 1rem; flex-shrink: 0; }

    .announce-item { padding: .85rem .5rem; border-bottom: 1px solid var(--petal); border-radius: 8px; transition: background .15s; }
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

    .notif-item { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem 0; border-bottom: 1px solid var(--petal); cursor: pointer; transition: background .15s; border-radius: 6px; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--petal); padding-left: 4px; }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }
    .notif-ico { width: 28px; height: 28px; border-radius: 8px; background: var(--petal); border: 1.5px solid var(--baby-pink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .notif-ico img { width: 14px; height: 14px; object-fit: contain; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }

    .icon-sm { width: 16px; height: 16px; object-fit: contain; }
    .icon-md { width: 20px; height: 20px; object-fit: contain; }

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
                    <div class="stat-label">Total Tenants</div>
                    <div class="stat-sub">Currently Registered</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><img src="{{ asset('icons/bed.png') }}" class="icon-md" alt=""></div>
                    <div class="stat-num">{{ $occupiedUnits ?? 0 }}</div>
                    <div class="stat-label">Units Occupied</div>
                    <div class="stat-sub">Out of {{ $totalUnits ?? 0 }} available</div>
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
                            <div class="activity-row">
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
                            <div class="announce-item">
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
                @foreach($notifications as $notif)
                    <div class="notif-item">
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
</div>

</div>

@endsection


@section('modals')

<div class="modal-overlay" id="emergency-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Emergency Alerts</div>
            <button class="modal-close" onclick="closeModal('emergency-modal')">&#x2715;</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:.8rem;">
            @if($allEmergencies->isEmpty())
                <p style="color:var(--ink-muted);font-size:.88rem;">No emergency reports found.</p>
            @else
                @foreach($allEmergencies as $emergency)
                    <div class="alert-item {{ $emergency->status === 'resolved' ? 'resolved' : 'active' }}">
                        <div class="alert-room">{{ $emergency->location ?? 'Unknown' }}: {{ $emergency->emergency_type }}</div>
                        <div class="alert-status">{{ $emergency->status === 'resolved' ? 'Resolved' : $emergency->status }}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('emergency-modal')">Close</button>
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

@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
    showToast("{{ session('error') }}", 'error');
@endif
</script>
@endsection