@extends('fdlayout')

@section('title', 'DormEase — Front Desk Dashboard')

@section('page-title', 'Dashboard')

@section('styles')
<style>

    .page-body {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 1.5rem;
        padding: 1.8rem 2rem;
        flex: 1;
    }

    .content-col { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }

    .page-header { margin-bottom: .25rem; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }

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
        border: 1px solid rgba(202,93,134,.1);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(202,93,134,.14); }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--pink); display: flex; align-items: center; justify-content: center; margin-bottom: .8rem; }
    .stat-num   { font-size: 1.8rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.02em; }
    .stat-label { font-size: .85rem; font-weight: 600; color: var(--ink); margin-top: .3rem; }
    .stat-sub   { font-size: .75rem; color: var(--pink); font-weight: 500; margin-top: .15rem; }

    .bottom-row { display: grid; grid-template-columns: 1fr 260px; gap: 1.2rem; }

    .activity-row {
        display: flex; align-items: center;
        padding: .95rem .5rem; border-bottom: 1px solid var(--border);
        cursor: pointer; transition: background .15s; border-radius: 8px;
    }
    .activity-row:last-child { border-bottom: none; }
    .activity-row:hover { background: var(--pink-bg); }
    .activity-text  { flex: 1; }
    .activity-title { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .activity-time  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .activity-arrow { color: var(--gray); font-size: .9rem; flex-shrink: 0; }

    .emergency-card {
        background: var(--pink-card); border: 1.5px solid var(--pink-light);
        border-radius: 16px; padding: 1.4rem;
        display: flex; flex-direction: column; align-items: center; text-align: center; gap: .6rem;
    }
    .emergency-title     { font-size: 1rem; font-weight: 700; color: var(--ink); }
    .emergency-icon-wrap { width: 70px; height: 70px; border-radius: 50%; border: 3px solid var(--ink); background: var(--white); display: flex; align-items: center; justify-content: center; margin: .4rem 0; }
    .emergency-room      { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .emergency-type      { font-size: .82rem; font-weight: 600; color: var(--pink); }
    .emergency-status    { font-size: .78rem; color: var(--ink-muted); font-style: italic; }
    .emergency-btn { margin-top: .5rem; width: 100%; background: var(--pink); color: var(--white); border: none; border-radius: 10px; padding: .65rem; font-size: .85rem; font-weight: 700; cursor: pointer; transition: background .2s, transform .15s; }
    .emergency-btn:hover { background: #a8446c; transform: translateY(-1px); }

    .announce-item { padding: .9rem 0; border-bottom: 1px solid var(--border); }
    .announce-item:last-child { border-bottom: none; padding-bottom: 0; }
    .announce-title { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .announce-date  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }

    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .right-col .card h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: .9rem; }

    .notif-item { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem 0; border-bottom: 1px solid var(--border); cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-ico  { flex-shrink: 0; margin-top: .1rem; }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    .empty-state { text-align: center; padding: 2rem; color: var(--ink-muted); font-size: .88rem; }

    .alert-resolve-btn { margin-top: .6rem; font-size: .78rem; font-weight: 600; padding: .3rem .8rem; border-radius: 7px; border: none; background: var(--green); color: var(--white); cursor: pointer; }

    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .page-body  { grid-template-columns: 1fr; }
        .right-col  { display: grid; grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 820px) {
        .bottom-row { grid-template-columns: 1fr; }
        .right-col  { grid-template-columns: 1fr; }
    }

</style>
@endsection


@section('content')

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
                <button class="export-btn" onclick="exportSummary()">
                    <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="">
                    Export
                </button>
            </div>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-icon">
                        <img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt="">
                    </div>
                    <div class="stat-num">{{ $totalTenants ?? 0 }}</div>
                    <div class="stat-label">Total Tenants</div>
                    <div class="stat-sub">Currently Registered</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">
                        <img src="{{ asset('icons/bed.png') }}" class="icon-md" alt="">
                    </div>
                    <div class="stat-num">{{ $occupiedUnits ?? 0 }}</div>
                    <div class="stat-label">Units Occupied</div>
                    <div class="stat-sub">Out of {{ $totalUnits ?? 0 }} available</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">
                        <img src="{{ asset('icons/visitor.png') }}" class="icon-md" alt="">
                    </div>
                    <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                    <div class="stat-label">Visitors Today</div>
                    <div class="stat-sub">Logged in today</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">
                        <img src="{{ asset('icons/warn.png') }}" class="icon-md" alt="">
                    </div>
                    <div class="stat-num">{{ $activeEmergencies ?? 0 }}</div>
                    <div class="stat-label">Active Emergencies</div>
                    <div class="stat-sub">Ongoing reports</div>
                </div>
            </div>
        </div>

        <div class="bottom-row fade-up d3">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recent Activity</div>
                    <a href="/visitors" class="see-all">See All</a>
                </div>

                @if($recentActivities->isEmpty())
                    <div class="empty-state">No recent activity.</div>
                @else
                    @foreach($recentActivities as $log)
                        <div class="activity-row">
                            <div class="activity-text">
                                <div class="activity-title">
                                    Visitor {{ $log->visitor_name }} logged {{ $log->departure_time ? 'out' : 'in' }}
                                    @if($log->tenant) for {{ $log->tenant->first_name }} {{ $log->tenant->last_name }} @endif
                                </div>
                                <div class="activity-time">{{ \Carbon\Carbon::parse($log->arrival_time)->format('F d, Y, g:i A') }}</div>
                            </div>
                            <div class="activity-arrow">›</div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if($latestEmergency)
                <div class="emergency-card">
                    <div class="emergency-title">Emergency Report</div>
                    <div class="emergency-icon-wrap">
                        <img src="{{ asset('icons/emergency.png') }}" class="icon-lg" alt="">
                    </div>
                    <div class="emergency-room">{{ $latestEmergency->location ?? 'Unknown Location' }}:</div>
                    <div class="emergency-type">{{ $latestEmergency->emergency_type }}</div>
                    <div class="emergency-status">{{ $latestEmergency->status }}</div>
                    <button class="emergency-btn" onclick="openModal('emergency-modal')">View All Alerts</button>
                </div>
            @else
                <div class="emergency-card" style="opacity:.65;">
                    <div class="emergency-title">Emergency Reports</div>
                    <div class="emergency-icon-wrap">
                        <img src="{{ asset('icons/check.png') }}" class="icon-lg" alt="">
                    </div>
                    <div class="emergency-type" style="color:var(--green);">All Clear</div>
                    <div class="emergency-status">No active emergencies</div>
                    <button class="emergency-btn" style="background:var(--green);" onclick="openModal('emergency-modal')">View History</button>
                </div>
            @endif

        </div>

        <div class="card fade-up d4">
            <div class="card-header">
                <div class="card-title">Latest Announcements</div>
                <a href="/announcements" class="see-all">See All</a>
            </div>

            @if($announcements->isEmpty())
                <div class="empty-state">No announcements yet.</div>
            @else
                @foreach($announcements as $ann)
                    <div class="announce-item">
                        <div class="announce-title">{{ $ann->title }}</div>
                        <div class="announce-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F d, Y') }}</div>
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
                            @if($notif->type === 'emergency')
                                <img src="{{ asset('icons/warn.png') }}" class="icon-sm" alt="">
                            @elseif($notif->type === 'visitor')
                                <img src="{{ asset('icons/visitor.png') }}" class="icon-sm" alt="">
                            @elseif($notif->type === 'tenant')
                                <img src="{{ asset('icons/tenants.png') }}" class="icon-sm" alt="">
                            @else
                                <img src="{{ asset('icons/bell.png') }}" class="icon-sm" alt="">
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

    </div>

</div>

@endsection


@section('modals')

<div class="modal-overlay" id="emergency-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Emergency Alerts</div>
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
                            {{ $emergency->status === 'resolved' ? 'Resolved' : $emergency->status }}
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

@endsection


@section('scripts')
<script>
    function exportSummary() {
        const rows = [
            ['Metric', 'Value'],
            ['Total Tenants',      '{{ $totalTenants ?? 0 }}'],
            ['Units Occupied',     '{{ $occupiedUnits ?? 0 }}'],
            ['Visitors Today',     '{{ $visitorsToday ?? 0 }}'],
            ['Active Emergencies', '{{ $activeEmergencies ?? 0 }}'],
        ];
        const csv  = rows.map(r => r.join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = 'frontdesk-summary.csv';
        a.click();
        showToast('Summary exported!', 'success');
    }
</script>
@endsection