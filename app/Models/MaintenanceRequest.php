<header class="topbar">
    <div class="breadcrumb">Pages / <span id="breadcrumb-label">Dashboard</span></div>
    <div class="topbar-right">
        <button class="notif-btn" onclick="toggleNotifPanel()" title="Notifications">
            🔔
            @if($unreadNotifCount > 0)
                <span class="notif-badge"></span>
            @endif
        </button>
        <div class="avatar" title="{{ $staff->first_name }}">
            {{ strtoupper(substr($staff->first_name, 0, 1)) }}
        </div>
    </div>
</header>