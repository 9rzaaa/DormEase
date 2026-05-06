@extends('layout')

@section('title', 'DormEase — Dashboard')

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
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--pink); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: .8rem; }
    .stat-num   { font-size: 1.8rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.02em; }
    .stat-label { font-size: .85rem; font-weight: 600; color: var(--ink); margin-top: .3rem; }
    .stat-sub   { font-size: .75rem; color: var(--pink); font-weight: 500; margin-top: .15rem; }

    .bottom-row { display: grid; grid-template-columns: 1fr 260px; gap: 1.2rem; }

    .maint-row {
        display: flex; align-items: center; gap: 1rem;
        padding: .9rem .5rem; border-bottom: 1px solid var(--border);
        cursor: pointer; transition: background .15s; border-radius: 8px;
    }
    .maint-row:last-child { border-bottom: none; }
    .maint-row:hover { background: var(--pink-bg); }
    .maint-type-icon { width: 38px; height: 38px; border-radius: 10px; background: var(--pink-card); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .maint-info      { flex: 1; min-width: 0; }
    .maint-title     { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .maint-id        { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; }
    .maint-desc-col  { flex: 1; min-width: 0; }
    .maint-desc      { font-size: .83rem; color: var(--ink); font-weight: 500; }
    .maint-tags      { display: flex; gap: .35rem; margin-top: .3rem; flex-wrap: wrap; }

    .tag          { font-size: .7rem; font-weight: 600; padding: .18rem .55rem; border-radius: 5px; border: 1.5px solid; }
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
    .emergency-title  { font-size: 1rem; font-weight: 700; color: var(--ink); }
    .emergency-icon-wrap { width: 70px; height: 70px; border-radius: 50%; border: 3px solid var(--ink); background: var(--white); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: .4rem 0; }
    .emergency-room   { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .emergency-type   { font-size: .82rem; font-weight: 600; color: var(--pink); }
    .emergency-status { font-size: .78rem; color: var(--ink-muted); font-style: italic; }
    .emergency-btn { margin-top: .5rem; width: 100%; background: var(--pink); color: var(--white); border: none; border-radius: 10px; padding: .65rem; font-size: .85rem; font-weight: 700; cursor: pointer; transition: background .2s, transform .15s; }
    .emergency-btn:hover { background: #a8446c; transform: translateY(-1px); }

    .announce-item { padding: .9rem 0; border-bottom: 1px solid var(--border); }
    .announce-item:last-child { border-bottom: none; padding-bottom: 0; }
    .announce-title { font-size: .9rem; font-weight: 600; color: var(--ink); }
    .announce-date  { font-size: .75rem; color: var(--ink-muted); margin-top: .2rem; }
    .announce-actions { display: flex; gap: .5rem; margin-top: .5rem; }
    .announce-action-btn { font-size: .75rem; font-weight: 600; padding: .28rem .7rem; border-radius: 6px; border: 1.5px solid var(--border); background: none; color: var(--ink-muted); cursor: pointer; transition: border-color .2s, color .2s; }
    .announce-action-btn:hover { border-color: var(--pink); color: var(--pink); }
    .post-announce-btn { font-size: .8rem; font-weight: 600; color: var(--pink); background: none; border: none; cursor: pointer; }
    .post-announce-btn:hover { text-decoration: underline; }

    .right-col { display: flex; flex-direction: column; gap: 1.4rem; }
    .right-col .card h3 { font-size: .9rem; font-weight: 700; color: var(--ink); margin-bottom: .9rem; }

    .notif-item { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem 0; border-bottom: 1px solid var(--border); cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-ico  { font-size: 1rem; flex-shrink: 0; margin-top: .1rem; }
    .notif-text { font-size: .8rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
    .notif-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }

    .activity-item { display: flex; align-items: flex-start; gap: .75rem; padding: .6rem 0; border-bottom: 1px solid var(--border); }
    .activity-item:last-child { border-bottom: none; }
    .activity-avatar { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; background: linear-gradient(135deg, var(--pink-light), var(--pink)); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; color: var(--white); }
    .activity-text { font-size: .8rem; color: var(--ink); line-height: 1.4; }
    .activity-time { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }
    .icon-md { width: 24px; height: 24px; }

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

        {{-- Quick Summary --}}
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
                    <div class="stat-icon">
                       <img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt="tenants">
                      </div>
                    <div class="stat-num">{{ $totalTenants ?? 0 }}</div>
                    <div class="stat-label">Total Tenants</div>
                    <div class="stat-sub">Currently Registered</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">
                      <img src="{{ asset('icons/billing.png') }}" class="icon-md" alt="payments">
                    </div>
                    <div class="stat-num">{{ $pendingPayments ?? 0 }}</div>
                    <div class="stat-label">Pending Payments</div>
                    <div class="stat-sub">Unsettled water charges</div>
                </div>
                <div class="stat-box">
                     <div class="stat-icon">
                      <img src="{{ asset('icons/maintenance.png') }}" class="icon-md" alt="maintenance">
                    </div>
                    <div class="stat-num">{{ $pendingMaintenance ?? 0 }}</div>
                    <div class="stat-label">Maintenance Requests</div>
                    <div class="stat-sub">Pending &amp; in progress</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">
                      <img src="{{ asset('icons/warn.png') }}" class="icon-md" alt="reports">
                    </div>
                    <div class="stat-num">{{ $unresolvedReports ?? 0 }}</div>
                    <div class="stat-label">Unresolved Reports</div>
                    <div class="stat-sub">Ongoing concerns</div>
                </div>
            </div>
        </div>

        {{-- Maintenance + Emergency row --}}
        <div class="bottom-row fade-up d3">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Maintenance Requests</div>
                    <a href="{{ route('maintenance.index') }}" class="see-all">See All</a>
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
                                    {{ $req->issue_type }}
                                    @if($req->tenant) | {{ $req->tenant->room_number }} @endif
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

        {{-- Announcements --}}
        <div class="card fade-up d4">
            <div class="card-header">
                <div class="card-title">Latest Announcements</div>
                <div style="display:flex;gap:.8rem;align-items:center;">
                    <button class="post-announce-btn" onclick="openModal('announce-modal')">Post Announcement</button>
                    <span style="color:var(--gray);font-size:.8rem;">|</span>
                    <a href="{{ route('announcements.index') }}" class="see-all">See All</a>
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

    </div>{{-- /content-col --}}

    {{-- Right column --}}
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

{{-- Announce Modal --}}
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

{{-- Emergency Modal --}}
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

@endsection

@section('scripts')
<script>
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
</script>
@endsection