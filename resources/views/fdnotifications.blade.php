@extends('fdlayout')

@section('title', 'DormEase: Notifications History')
@section('page-title', 'Notifications History')

@section('styles')
<style>
    .np-page {
        padding: 1.8rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
        flex: 1;
        background: var(--pink-bg, #fdf0f5);
        box-sizing: border-box;
        min-height: 100vh;
    }

    .np-back {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .82rem;
        font-weight: 600;
        color: var(--hot-pink);
        text-decoration: none;
        align-self: flex-start;
        transition: opacity .15s;
    }
    .np-back:hover { opacity: .7; }
    .np-back svg { flex-shrink: 0; }

    .np-toprow {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .np-heading { margin: 0; }
    .np-heading h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--ink, #1a1a2e);
        letter-spacing: -.025em;
        line-height: 1.1;
        margin: 0 0 .2rem;
    }
    .np-heading p {
        font-size: .85rem;
        color: var(--ink-muted, #7a5f6e);
        margin: 0;
        font-weight: 400;
    }

    .np-mark-all-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-light, #FFB0CE);
        background: var(--white, #fff);
        color: var(--hot-pink, #e8175d);
        font-size: .82rem;
        font-weight: 700;
        cursor: pointer;
        transition: background .15s, border-color .15s;
        white-space: nowrap;
    }
    .np-mark-all-btn:hover {
        background: var(--pink-card, #fce8f1);
        border-color: var(--hot-pink);
    }
    .np-mark-all-btn svg { flex-shrink: 0; }

    .np-filters {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
    }
    .np-filter-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .38rem .85rem;
        border-radius: 999px;
        border: 1.5px solid var(--pink-light, #FFB0CE);
        background: var(--white, #fff);
        color: var(--ink-muted, #7a5f6e);
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s, border-color .15s, color .15s;
        white-space: nowrap;
    }
    .np-filter-pill:hover {
        background: var(--pink-card, #fce8f1);
        color: var(--hot-pink);
        border-color: var(--hot-pink);
    }
    .np-filter-pill.active {
        background: var(--hot-pink, #e8175d);
        border-color: var(--hot-pink);
        color: #fff;
    }
    .np-filter-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .np-shell {
        background: var(--white, #fff);
        border: 1.5px solid var(--pink-light, #FFB0CE);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 20px rgba(202,93,134,.05);
    }

    .np-day-label {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .55rem 1.5rem;
        background: var(--pink-bg, #fdf0f5);
        border-bottom: 1px solid var(--pink-light, #FFB0CE);
    }
    .np-day-label span {
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--hot-pink, #e8175d);
        white-space: nowrap;
    }
    .np-day-line {
        flex: 1;
        height: 1px;
        background: var(--pink-light, #FFB0CE);
    }

    .np-item {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: .8rem 1.5rem .8rem 0;
        border-bottom: 1px solid var(--pink-light, #FFB0CE);
        cursor: pointer;
        transition: background .13s;
        border-left: 3px solid transparent;
        position: relative;
    }
    .np-item:last-child { border-bottom: none; }
    .np-item:hover { background: var(--pink-bg, #fdf0f5); }

    .np-item.unread { background: #fdf5f8; }
    .np-item.unread:hover { background: var(--pink-bg, #fdf0f5); }

    .np-item.type-emergency    { border-left-color: #f87171; }
    .np-item.type-announcement { border-left-color: #fb923c; }
    .np-item.type-visitor      { border-left-color: #34d399; }
    .np-item.type-general      { border-left-color: #d1d5db; }

    .np-unread-col {
        width: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding-left: 6px;
    }
    .np-unread-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--hot-pink, #e8175d);
        flex-shrink: 0;
    }

    .np-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1.5px solid transparent;
    }
    .np-icon img {
        width: 16px;
        height: 16px;
        object-fit: contain;
    }

    .np-icon.type-emergency    { background: #fff1f2; border-color: #fecdd3; }
    .np-icon.type-emergency img { filter: brightness(0) saturate(100%) invert(52%) sepia(60%) saturate(700%) hue-rotate(315deg) brightness(90%) contrast(95%); }
    .np-icon.type-announcement { background: #fff7ed; border-color: #fed7aa; }
    .np-icon.type-announcement img { filter: brightness(0) saturate(100%) invert(55%) sepia(80%) saturate(500%) hue-rotate(15deg) brightness(90%) contrast(95%); }
    .np-icon.type-visitor      { background: #f0fdf4; border-color: #a7f3d0; }
    .np-icon.type-visitor img { filter: brightness(0) saturate(100%) invert(62%) sepia(50%) saturate(400%) hue-rotate(120deg) brightness(85%) contrast(90%); }
    .np-icon.type-general      { background: #f9fafb; border-color: #e5e7eb; }
    .np-icon.type-general img  { filter: brightness(0) saturate(100%) invert(60%); }

    .np-body {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: .18rem;
    }
    .np-body-top {
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .np-badge {
        font-size: .6rem;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
        padding: .12rem .45rem;
        border-radius: 999px;
        border: 1px solid transparent;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .np-badge.type-emergency    { background: #fff1f2; color: #be123c; border-color: #fecdd3; }
    .np-badge.type-announcement { background: #fff7ed; color: #c2410c; border-color: #fed7aa; }
    .np-badge.type-visitor      { background: #f0fdf4; color: #166534; border-color: #a7f3d0; }
    .np-badge.type-general      { background: #f9fafb; color: #6b7280; border-color: #e5e7eb; }

    .np-msg {
        font-size: .875rem;
        font-weight: 500;
        color: var(--ink, #1a1a2e);
        line-height: 1.4;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .np-item.unread .np-msg { font-weight: 600; }

    .np-time {
        font-size: .78rem;
        color: var(--ink-soft, #5a5a75);
        font-weight: 600;
        margin-top: .05rem;
    }

    .np-action {
        flex-shrink: 0;
        padding-right: 1.5rem;
    }
    .np-action-btn {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .38rem .8rem;
        border-radius: 8px;
        background: var(--pink-card, #fce8f1);
        color: var(--hot-pink, #e8175d);
        font-size: .75rem;
        font-weight: 700;
        border: 1.5px solid var(--pink-light, #FFB0CE);
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
        white-space: nowrap;
    }
    .np-action-btn:hover { background: var(--pink-light, #FFB0CE); }

    .np-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .75rem;
        padding: 4rem 2rem;
        text-align: center;
    }
    .np-empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: var(--pink-card, #fce8f1);
        border: 1.5px solid var(--pink-light, #FFB0CE);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .np-empty-icon img {
        width: 22px;
        height: 22px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .np-empty h3 {
        font-size: .95rem;
        font-weight: 700;
        color: var(--ink, #1a1a2e);
        margin: 0;
    }
    .np-empty p {
        font-size: .82rem;
        color: var(--ink-muted, #7a5f6e);
        margin: 0;
    }

    .np-pagination {
        padding: .9rem 1.5rem;
        border-top: 1.5px solid var(--pink-light, #FFB0CE);
        background: var(--pink-bg, #fdf0f5);
    }
    .np-pagination nav > div:first-child { display: none !important; }
    .np-pagination nav > div:last-child {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        flex-wrap: wrap;
        gap: .75rem;
    }
    .np-pagination svg {
        width: 1rem !important;
        height: 1rem !important;
        display: inline-block !important;
        vertical-align: middle;
    }
    .np-pagination nav div:last-child > div:first-child {
        font-size: .78rem;
        color: var(--ink-muted, #7a5f6e);
    }
    .np-pagination nav div:last-child > div:last-child {
        display: flex;
        gap: .25rem;
        align-items: center;
    }
    .np-pagination nav a,
    .np-pagination nav span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 .45rem;
        border-radius: 8px;
        border: 1.5px solid var(--pink-light, #FFB0CE);
        background: var(--white, #fff);
        color: var(--ink-muted, #7a5f6e);
        font-size: .78rem;
        font-weight: 700;
        text-decoration: none;
        box-sizing: border-box;
        transition: background .13s, border-color .13s;
    }
    .np-pagination nav a:hover {
        background: var(--pink-card, #fce8f1);
        border-color: var(--hot-pink);
        color: var(--hot-pink);
    }
    .np-pagination nav span[aria-current="page"] {
        background: var(--hot-pink, #e8175d);
        color: #fff;
        border-color: transparent;
    }
    .np-pagination nav span[aria-disabled="true"] {
        opacity: .4;
        cursor: not-allowed;
    }

    @media (max-width: 600px) {
        .np-page { padding: 1.2rem 1rem; }
        .np-item { padding: .7rem 1rem .7rem 0; gap: .65rem; }
        .np-action { padding-right: 1rem; }
        .np-action-btn span { display: none; }
    }
</style>
@endsection

@section('content')
<main class="np-page">

    <a href="{{ route('frontdesk.dashboard') }}" class="np-back">
        <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back to Dashboard
    </a>

    <div class="np-toprow">
        <div class="np-heading">
            <h1>Notification History</h1>
            <p>All your past notifications in one place</p>
        </div>
        @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
            <button class="np-mark-all-btn" onclick="markAllRead()">
                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Mark all read
            </button>
        @endif
    </div>

    <div class="np-filters">
        @php
            $currentType = request('type', '');
            $pills = [
                ''             => ['label' => 'All',           'color' => '#e8175d'],
                'emergency'    => ['label' => 'Emergency',     'color' => '#f87171'],
                'announcement' => ['label' => 'Announcements', 'color' => '#fb923c'],
                'visitor'      => ['label' => 'Visitors',      'color' => '#34d399'],
            ];
        @endphp
        @foreach($pills as $value => $pill)
            @php
                $url = request()->fullUrlWithQuery(['type' => $value ?: null, 'page' => null]);
                $isActive = $currentType === $value;
            @endphp
            <a href="{{ $url }}" class="np-filter-pill {{ $isActive ? 'active' : '' }}">
                @if(!$isActive)
                    <span class="np-filter-dot" style="background: {{ $pill['color'] }};"></span>
                @endif
                {{ $pill['label'] }}
            </a>
        @endforeach
    </div>

    <div class="np-shell">
        @if($notifications->isEmpty())
            <div class="np-empty">
                <div class="np-empty-icon">
                    <img src="{{ asset('icons/bell.png') }}" alt="">
                </div>
                <h3>No notifications found</h3>
                <p>Try a different filter or check back later.</p>
            </div>
        @else
            @php
                $grouped = $notifications->groupBy(function($notif) {
                    $date = \Carbon\Carbon::parse($notif->created_at);
                    if ($date->isToday())     return 'Today';
                    if ($date->isYesterday()) return 'Yesterday';
                    return $date->format('F j, Y');
                });
            @endphp

            @foreach($grouped as $day => $dayNotifs)
                <div class="np-day-label">
                    <span>{{ $day }}</span>
                    <div class="np-day-line"></div>
                </div>

                @foreach($dayNotifs as $notif)
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

                    <div class="np-item type-{{ $notifTypeLabel }} {{ $notif->is_read ? '' : 'unread' }}"
                         onclick="handleNotifClick(event, this); this.classList.remove('unread'); var dot = this.querySelector('.np-unread-dot'); if(dot) dot.remove();"
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
                        <div class="np-unread-col">
                            @if(!$notif->is_read)
                                <div class="np-unread-dot"></div>
                            @endif
                        </div>
                        <div class="np-icon type-{{ $notifTypeLabel }}">
                            <img src="{{ asset('icons/' . $notifIcon . '.png') }}" alt="" onerror="this.src='{{ asset('icons/bell.png') }}'">
                        </div>
                        <div class="np-body">
                            <div class="np-body-top">
                                <span class="np-badge type-{{ $notifTypeLabel }}">{{ $notifTypeLabel }}</span>
                            </div>
                            <div class="np-msg">{{ $notif->message }}</div>
                            <div class="np-time">{{ \Carbon\Carbon::parse($notif->created_at)->format('g:i A') }}</div>
                        </div>
                        @if($notif->url)
                            <div class="np-action">
                                <span class="np-action-btn">
                                    <span>View</span>
                                    <svg viewBox="0 0 24 24" width="11" height="11" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        @endif

        @if($notifications->hasPages())
            <div class="np-pagination">
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
        if (value) { url.searchParams.set('type', value); }
        else        { url.searchParams.delete('type'); }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
</script>
@endsection