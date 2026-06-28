@extends('fdlayout')

@section('title', 'DormEase: Previous Notifications')
@section('page-title', 'Previous Notifications')

@section('styles')
<style>
    .notif-page {
        padding: 1.8rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        flex: 1;
        background: var(--soft-bg, #fdf6f9);
        box-sizing: border-box;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .85rem;
        font-weight: 600;
        color: var(--hot-pink);
        text-decoration: none;
        margin-bottom: .2rem;
        transition: opacity .15s;
        align-self: flex-start;
    }
    .back-link:hover { opacity: .75; }

    .notif-header {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .notif-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink, #1a1a2e);
        letter-spacing: -.02em;
        line-height: 1.15;
        margin: 0;
    }
    .notif-header .subtitle {
        font-size: 0.9rem;
        color: var(--ink-muted, #7c7c8c);
        font-weight: 500;
    }
    .notif-card {
        background: var(--white, #ffffff);
        border: 1.5px solid var(--border-pink, #fce4ec);
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(232,23,93,0.03);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .notif-list-header {
        padding: 1rem 1.5rem;
        border-bottom: 1.5px solid var(--petal, #fce4ec);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .notif-list-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ink, #1a1a2e);
    }
    .filter-select {
        padding: .45rem .85rem;
        border-radius: 10px;
        border: 1.5px solid var(--border-pink);
        background: var(--white);
        font-size: .82rem;
        color: var(--black);
        font-weight: 600;
        outline: none;
        cursor: pointer;
        transition: border-color .18s;
    }
    .filter-select:focus {
        border-color: var(--bright-pink);
    }
    .notif-date-group-header {
        padding: 0.6rem 1.5rem;
        background: var(--petal, #fce4ec);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--hot-pink, #e8175d);
        border-bottom: 1px solid var(--baby-pink, #f8bbd0);
    }
    .notif-list {
        display: flex;
        flex-direction: column;
    }
    .notif-page-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.65rem 1.5rem;
        border-bottom: 1px solid var(--petal, #fce4ec);
        cursor: pointer;
        transition: background .15s;
        text-decoration: none;
        color: inherit;
    }
    .notif-page-item:last-child {
        border-bottom: none;
    }
    .notif-page-item:hover {
        background: var(--soft-bg, #fdf6f9);
    }
    .notif-page-item.unread {
        background: var(--pink-50, #fff0f3);
    }
    .notif-page-item.unread:hover {
        background: var(--pink-100, #ffe0e6);
    }
    .notif-page-item.reservation {
        border-left: 4px solid #f0c840;
        background: #fffbf0;
    }
    .notif-page-item.reservation:hover {
        background: #fff7e0;
    }
    .notif-dot-col {
        width: 8px;
        display: flex;
        justify-content: center;
        flex-shrink: 0;
    }
    .notif-page-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--bright-pink, #E8175D);
    }
    .notif-page-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--petal, #fce4ec);
        border: 1.5px solid var(--baby-pink, #f8bbd0);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .notif-page-icon.reservation-icon {
        background: #fff8e0;
        border-color: #f0c840;
    }
    .notif-page-icon img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .notif-page-icon.reservation-icon img {
        filter: brightness(0) saturate(100%) invert(55%) sepia(80%) saturate(600%) hue-rotate(5deg) brightness(95%) contrast(95%);
    }
    .notif-page-body {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }
    .notif-page-msg {
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--ink, #1a1a2e);
        line-height: 1.35;
    }
    .notif-page-time {
        font-size: 0.76rem;
        color: var(--ink-muted, #7c7c8c);
    }
    .notif-page-type-badge {
        display: inline-block;
        font-size: 0.6rem;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
        padding: .1rem .35rem;
        border-radius: 4px;
        align-self: flex-start;
    }
    .notif-page-type-badge.reservation { background: #fff0c0; color: #9a6200; border: 1px solid #f0c840; }
    .notif-page-type-badge.maintenance { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .notif-page-type-badge.emergency { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .notif-page-type-badge.billing { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .notif-page-type-badge.document { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
    .notif-page-type-badge.announcement { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
    .notif-page-type-badge.visitor { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .notif-page-type-badge.general { background: #f4f4f5; color: #71717a; border: 1px solid #e4e4e7; }
    
    .notif-page-action {
        flex-shrink: 0;
    }
    .notif-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        background: var(--bright-pink, #E8175D);
        color: var(--white, #ffffff);
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .notif-action-btn:hover {
        opacity: 0.9;
    }

    .notif-empty {
        padding: 3rem 2rem;
        text-align: center;
        font-size: 0.95rem;
        color: var(--ink-muted, #7c7c8c);
    }
    .notif-pagination {
        padding: 1rem 1.5rem;
        border-top: 1.5px solid var(--petal, #fce4ec);
    }

    /* Fix Laravel default paginator SVG size and duplicate layout issues */
    .notif-pagination nav > div:first-child {
        display: none !important;
    }
    .notif-pagination nav > div:last-child {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .notif-pagination svg {
        width: 1.1rem !important;
        height: 1.1rem !important;
        display: inline-block !important;
        vertical-align: middle;
    }
    .notif-pagination nav div:last-child > div:first-child {
        font-size: 0.83rem;
        color: var(--ink-muted);
    }
    .notif-pagination nav div:last-child > div:last-child {
        display: flex;
        gap: 0.25rem;
        align-items: center;
    }
    .notif-pagination nav a, .notif-pagination nav span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 .5rem;
        border-radius: 8px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        color: var(--ink-muted);
        font-size: .8rem;
        font-weight: 700;
        text-decoration: none;
        box-sizing: border-box;
    }
    .notif-pagination nav span[aria-current="page"] {
        background: var(--bright-pink);
        color: var(--white);
        border-color: transparent;
    }
    .notif-pagination nav span[aria-disabled="true"] {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')
<main class="notif-page">
    <a href="{{ route('frontdesk.dashboard') }}" class="back-link">
        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back to Dashboard
    </a>

    <div class="notif-header">
        <h1>Notifications History</h1>
        <div class="subtitle">Access and manage all your historical notifications</div>
    </div>

    <div class="notif-card">
        <div class="notif-list-header">
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div class="notif-list-title">All Notifications</div>
                
                <select id="type-filter" onchange="filterType(this.value)" class="filter-select">
                    <option value="">All Types</option>
                    <option value="emergency" {{ request('type') === 'emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="announcement" {{ request('type') === 'announcement' ? 'selected' : '' }}>Announcements</option>
                    <option value="visitor" {{ request('type') === 'visitor' ? 'selected' : '' }}>Visitors</option>
                    <option value="tenant" {{ request('type') === 'tenant' ? 'selected' : '' }}>Tenants</option>
                </select>
            </div>
            
            @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                <button class="notif-mark-all" onclick="markAllRead()">Mark all read</button>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="notif-empty">No notifications found.</div>
        @else
            @php
                $grouped = $notifications->groupBy(function($notif) {
                    $date = \Carbon\Carbon::parse($notif->created_at);
                    if ($date->isToday()) {
                        return 'Today';
                    } elseif ($date->isYesterday()) {
                        return 'Yesterday';
                    } else {
                        return $date->format('F j, Y');
                    }
                });
            @endphp

            @foreach($grouped as $day => $dayNotifs)
                <div class="notif-date-group-header">{{ $day }}</div>
                <div class="notif-list">
                    @foreach($dayNotifs as $notif)
                        @php
                            $isReservation = $notif->type === 'tenant_reserved';

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

                        <div class="notif-page-item {{ $notif->is_read ? '' : 'unread' }} {{ $isReservation ? 'reservation' : '' }}"
                             onclick="handleNotifClick(event, this); this.classList.remove('unread'); var dot = this.querySelector('.notif-page-dot'); if(dot) dot.remove();"
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
                            <div class="notif-dot-col">
                                @if(!$notif->is_read)
                                    <div class="notif-page-dot"></div>
                                @endif
                            </div>
                            <div class="notif-page-icon {{ $isReservation ? 'reservation-icon' : '' }}">
                                <img src="{{ asset('icons/' . $notifIcon . '.png') }}"
                                     alt=""
                                     onerror="this.src='{{ asset('icons/bell.png') }}'">
                            </div>
                            <div class="notif-page-body">
                                <span class="notif-page-type-badge {{ $notifTypeLabel }}">{{ $notifTypeLabel }}</span>
                                <div class="notif-page-msg">{{ $notif->message }}</div>
                                <div class="notif-page-time">{{ \Carbon\Carbon::parse($notif->created_at)->format('g:i A') }}</div>
                            </div>
                            @if($notif->url)
                                <div class="notif-page-action">
                                    <span class="notif-action-btn">View Details</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif

        @if($notifications->hasPages())
            <div class="notif-pagination">
                {{ $notifications->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
    function filterType(value) {
        var url = new URL(window.location.href);
        if (value) {
            url.searchParams.set('type', value);
        } else {
            url.searchParams.delete('type');
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
</script>
@endsection
