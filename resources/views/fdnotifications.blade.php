@extends('fdlayout')

@section('title', 'DormEase: Previous Notifications')
@section('page-title', 'Previous Notifications')

@section('styles')
<style>
    .notif-page {
        padding: 1.8rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        flex: 1;
        background: var(--soft-bg, #fdf6f9);
        box-sizing: border-box;
    }
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
        padding: 1.2rem 1.5rem;
        border-bottom: 1.5px solid var(--petal, #fce4ec);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .notif-list-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ink, #1a1a2e);
    }
    .notif-list {
        display: flex;
        flex-direction: column;
    }
    .notif-page-item {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        padding: 1.2rem 1.5rem;
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
        width: 10px;
        display: flex;
        justify-content: center;
        flex-shrink: 0;
    }
    .notif-page-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--bright-pink, #E8175D);
    }
    .notif-page-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
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
        width: 20px;
        height: 20px;
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
        gap: 0.25rem;
    }
    .notif-page-msg {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--ink, #1a1a2e);
        line-height: 1.4;
    }
    .notif-page-time {
        font-size: 0.8rem;
        color: var(--ink-muted, #7c7c8c);
    }
    .notif-page-type-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
        padding: .15rem .45rem;
        border-radius: 4px;
        align-self: flex-start;
        margin-bottom: 0.15rem;
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
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: var(--bright-pink, #E8175D);
        color: var(--white, #ffffff);
        font-size: 0.8rem;
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
        padding: 1.2rem 1.5rem;
        border-top: 1.5px solid var(--petal, #fce4ec);
        display: flex;
        justify-content: center;
    }
    
    .notif-pagination nav {
        display: flex;
        gap: 0.25rem;
    }
    .notif-pagination span, .notif-pagination a {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        border: 1px solid var(--border-pink);
        text-decoration: none;
        color: var(--ink);
        font-size: 0.85rem;
    }
    .notif-pagination .active span {
        background: var(--bright-pink);
        color: var(--white);
        border-color: var(--bright-pink);
    }
</style>
@endsection

@section('content')
<main class="notif-page">
    <div class="notif-header">
        <h1>Notifications History</h1>
        <div class="subtitle">Access and manage all your historical notifications</div>
    </div>

    <div class="notif-card">
        <div class="notif-list-header">
            <div class="notif-list-title">All Notifications</div>
            @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                <button class="notif-mark-all" onclick="markAllRead()">Mark all read</button>
            @endif
        </div>

        <div class="notif-list">
            @forelse($notifications as $notif)
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
                        <div class="notif-page-time">{{ \Carbon\Carbon::parse($notif->created_at)->format('F j, Y \a\t g:i A') }} ({{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }})</div>
                    </div>
                    @if($notif->url)
                        <div class="notif-page-action">
                            <span class="notif-action-btn">View Details</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="notif-empty">No notifications found.</div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="notif-pagination">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</main>
@endsection
