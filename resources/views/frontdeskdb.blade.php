@extends('fdlayout')

@section('title', 'DormEase: Front Desk Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>

    .page-body {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 1.5rem;
        padding: 1.8rem 2rem;
        flex: 1;
        background: var(--pink-bg);
    }

    .content-col { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }

    .dorm-name { font-size: 1rem; font-weight: 600; color: var(--bright-pink); margin-top: .2rem; }

    .export-btn {
        display: flex; align-items: center; gap: .4rem;
        padding: .45rem 1rem; border-radius: 8px;
        border: 1.5px solid var(--bright-pink);
        background: var(--pink-card);
        font-size: .82rem; font-weight: 700; color: var(--hot-pink);
        transition: background .2s; cursor: pointer;
    }
    .export-btn:hover { background: var(--pink-100); }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-top: 1rem; }

    .stat-box {
        border-radius: 14px; padding: 1.1rem; border: none;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(232,23,93,.25); }

    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .8rem;
    }
    .stat-icon img { filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }
    .stat-num   { font-size: 1.9rem; font-weight: 800; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; font-weight: 700; color: rgba(255,255,255,.92); margin-top: .3rem; }
    .stat-sub   { font-size: .75rem; color: rgba(255,255,255,.72); margin-top: .15rem; }

    .bottom-row { display: grid; grid-template-columns: 1fr 260px; gap: 1.2rem; }

    .activity-row {
        display: flex; align-items: center;
        padding: .95rem .5rem; border-bottom: 1px solid var(--pink-card);
        cursor: pointer; transition: background .15s; border-radius: 8px;
    }
    .activity-row:last-child { border-bottom: none; }
    .activity-row:hover { background: var(--pink-card); }
    .activity-text  { flex: 1; }
    .activity-title { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .activity-time  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .activity-arrow { color: var(--hot-pink); font-size: .9rem; flex-shrink: 0; }

    .emergency-card {
        background: var(--white);
        border: 1.5px solid var(--bright-pink);
        border-radius: 16px; padding: 1.4rem;
        display: flex; flex-direction: column; align-items: center; text-align: center; gap: .6rem;
    }
    .emergency-title { font-size: 1rem; font-weight: 800; color: var(--ink); }
    .emergency-icon-wrap {
        width: 78px; height: 78px; border-radius: 50%;
        border: 3px solid var(--pink-100);
        background: var(--pink-card);
        display: flex; align-items: center; justify-content: center;
        margin: .5rem 0;
        box-shadow: 0 4px 14px rgba(232,23,93,.12);
    }
    .emergency-icon-wrap img {
        width: 28px; height: 28px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .check-icon { width: 42px !important; height: 42px !important; object-fit: contain; filter: none !important; }
    .emergency-room   { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .emergency-type   { font-size: .82rem; font-weight: 600; color: var(--bright-pink); }
    .emergency-status { font-size: .78rem; color: var(--ink-muted); font-style: italic; }
    .emergency-btn {
        margin-top: .5rem; width: 100%;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        color: var(--white); border: none; border-radius: 10px;
        padding: .65rem; font-size: .85rem; font-weight: 800;
        cursor: pointer; transition: opacity .2s;
    }
    .emergency-btn:hover { opacity: .88; }

    .announce-item { padding: .9rem 0; border-bottom: 1px solid var(--pink-card); }
    .announce-item:last-child { border-bottom: none; padding-bottom: 0; }
    .announce-title { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .announce-date  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }

    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .right-col .card h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: 0; }

    .notif-item {
        display: flex; align-items: flex-start; gap: .7rem;
        padding: .6rem 0; border-bottom: 1px solid var(--pink-card);
        cursor: pointer; border-radius: 8px; transition: background .15s;
        margin: 0 -.4rem; padding-left: .4rem; padding-right: .4rem;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--pink-card); }
    .notif-ico  { flex-shrink: 0; margin-top: .1rem; }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    .notif-ico img {
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .notif-unread-indicator {
        width: 7px; height: 7px; border-radius: 50%;
        background: var(--hot-pink); flex-shrink: 0; margin-top: .4rem;
    }

    .empty-state { text-align: center; padding: 2rem; color: var(--ink-muted); font-size: .88rem; }

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
                        <img src="{{ asset('icons/panic.png') }}" class="icon-lg" alt="">
                    </div>
                    <div class="emergency-room">{{ $latestEmergency->location ?? 'Unknown Location' }}:</div>
                    <div class="emergency-type">{{ $latestEmergency->emergency_type }}</div>
                    <div class="emergency-status">{{ $latestEmergency->status }}</div>
                    <button class="emergency-btn" onclick="openModal('emergency-modal')">View All Alerts</button>
                </div>
            @else
                <div class="emergency-card">
                    <div class="emergency-title">Emergency Reports</div>
                    <div class="emergency-icon-wrap">
                        <img src="{{ asset('icons/check.png') }}" alt="" class="check-icon">
                    </div>
                    <div class="emergency-type">All Clear</div>
                    <div class="emergency-status">No active emergencies</div>
                    <button class="emergency-btn" onclick="openModal('emergency-modal')">View History</button>
                </div>
            @endif

        </div>

        <div class="card fade-up d4">
            <div class="card-header">
                <div class="card-title">Latest Announcements</div>
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

    {{-- ═══ RIGHT COLUMN ═══ --}}
    <div class="right-col fade-up d5">

        <div class="card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem;">
                <h3>Notifications</h3>
            </div>

            @php $recentNotifs = $notifications->take(8); @endphp

            @if($recentNotifs->isEmpty())
                <div class="empty-state" style="padding:1rem 0;">No new notifications.</div>
            @else
                @foreach($recentNotifs as $notif)
                    @php
                        $icon = match(true) {
                            in_array($notif->type, ['emergency_new', 'emergency_updated']) => 'warn.png',
                            in_array($notif->type, ['visitor_checkin', 'visitor_checkout']) => 'nav-visit.png',
                            in_array($notif->type, ['maintenance_new', 'maintenance_updated']) => 'nav-settings.png',
                            $notif->type === 'announcement' => 'nav-announ.png',
                            default => 'bell.png',
                        };
                        $typeLabel = match(true) {
                            in_array($notif->type, ['emergency_new', 'emergency_updated']) => 'emergency',
                            in_array($notif->type, ['visitor_checkin', 'visitor_checkout']) => 'visitor',
                            in_array($notif->type, ['maintenance_new', 'maintenance_updated']) => 'maintenance',
                            $notif->type === 'announcement' => 'announcement',
                            default => 'general',
                        };
                    @endphp
                    <div class="notif-item"
                         onclick="openNotifDetail({
                             id:      {{ $notif->notif_id }},
                             type:    '{{ $typeLabel }}',
                             icon:    '{{ asset('icons/' . $icon) }}',
                             message: {{ json_encode($notif->message) }},
                             time:    '{{ \Carbon\Carbon::parse($notif->created_at)->format('F j, Y \a\t g:i A') }}',
                             ago:     '{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}',
                             url:     '{{ $notif->url ?? '' }}',
                             isRead:  {{ $notif->is_read ? 'true' : 'false' }}
                         })">
                        @if(!$notif->is_read)
                            <div class="notif-unread-indicator"></div>
                        @else
                            <div style="width:7px;flex-shrink:0;"></div>
                        @endif
                        <div class="notif-ico">
                            <img src="{{ asset('icons/' . $icon) }}" class="icon-sm" alt="">
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

{{-- ═══ EMERGENCY MODAL ═══ --}}
<div class="modal-overlay" id="emergency-modal" onclick="handleOverlayClick(event, 'emergency-modal')">
    <div class="modal" onclick="event.stopPropagation()">
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