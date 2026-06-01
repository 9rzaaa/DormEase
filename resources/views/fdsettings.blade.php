@extends('fdlayout')

@section('title', 'DormEase: Settings')
@section('page-title', 'Settings')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        flex: 1;
        background: var(--blush);
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .page-header-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: .25rem;
    }
    .page-header-text h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.2;
        margin: 0;
    }
    .page-header-text p {
        font-size: .88rem;
        color: var(--ink-muted);
        margin: 0;
    }
    .settings-tabs {
        display: flex;
        gap: .4rem;
        border-bottom: 2px solid var(--baby-pink);
    }
    .tab-btn {
        padding: .55rem 1.1rem;
        border: none;
        background: none;
        font-family: var(--ff-body);
        font-size: .86rem;
        font-weight: 600;
        color: var(--ink-muted);
        cursor: pointer;
        border-bottom: 2.5px solid transparent;
        margin-bottom: -2px;
        border-radius: 8px 8px 0 0;
        transition: color .2s, border-color .2s, background .2s;
        display: flex;
        align-items: center;
        gap: .45rem;
    }
    .tab-btn img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        opacity: .5;
        transition: opacity .2s;
    }
    .tab-btn:hover { color: var(--hot-pink); background: var(--petal); }
    .tab-btn:hover img { opacity: .85; }
    .tab-btn.active {
        color: var(--hot-pink);
        border-bottom-color: var(--hot-pink);
        background: var(--petal);
        font-weight: 700;
    }
    .tab-btn.active img { opacity: 1; }
    .tab-panel { display: none; flex-direction: column; gap: 1.4rem; }
    .tab-panel.active { display: flex; }
    .settings-card {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 16px;
        padding: 1.6rem 1.8rem;
        box-shadow: var(--shadow);
    }
    .settings-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-bottom: 1.4rem;
        padding-bottom: .9rem;
        border-bottom: 1.5px solid var(--petal);
    }
    .settings-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--petal);
        border: 1.5px solid var(--baby-pink);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .settings-card-icon img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .settings-card-title { font-size: 1rem; font-weight: 700; color: var(--ink); }
    .settings-card-sub   { font-size: .78rem; color: var(--ink-muted); margin-top: .1rem; }
    .notif-list { display: flex; flex-direction: column; gap: .1rem; }
    .notif-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .85rem .2rem;
        border-bottom: 1px solid var(--petal);
        gap: 1rem;
    }
    .notif-row:last-child { border-bottom: none; }
    .notif-info { flex: 1; }
    .notif-label { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .notif-desc  { font-size: .76rem; color: var(--ink-muted); margin-top: .15rem; }
    .toggle-wrap { position: relative; flex-shrink: 0; }
    .toggle-wrap input[type="checkbox"] { opacity: 0; width: 0; height: 0; position: absolute; }
    .toggle-track {
        display: block;
        width: 42px;
        height: 24px;
        border-radius: 99px;
        background: var(--gray-light);
        cursor: pointer;
        transition: background .25s;
        position: relative;
    }
    .toggle-track::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--white);
        box-shadow: 0 1px 4px rgba(0,0,0,.18);
        transition: transform .25s;
    }
    .toggle-wrap input:checked + .toggle-track { background: var(--hot-pink); }
    .toggle-wrap input:checked + .toggle-track::after { transform: translateX(18px); }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: .7rem;
        margin-top: 1.4rem;
        padding-top: 1rem;
        border-top: 1.5px solid var(--petal);
    }
    .btn-save {
        padding: .6rem 1.5rem;
        border-radius: 9px;
        border: none;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-size: .87rem;
        font-weight: 800;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        box-shadow: var(--shadow-pink-btn);
    }
    .btn-save:hover { opacity: .9; transform: translateY(-1px); }
    .btn-cancel {
        padding: .6rem 1.2rem;
        border-radius: 9px;
        border: 1.5px solid var(--baby-pink);
        background: none;
        font-size: .87rem;
        font-weight: 600;
        color: var(--ink-muted);
        cursor: pointer;
        transition: border-color .2s, color .2s;
    }
    .btn-cancel:hover { border-color: var(--hot-pink); color: var(--hot-pink); }
    .alert-banner {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .8rem 1.1rem;
        border-radius: 10px;
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .alert-banner.success {
        background: #eafbf0;
        border: 1.5px solid #5bcb8a;
        color: #1a7a4a;
    }
    .alert-banner.error {
        background: #fff5f5;
        border: 1.5px solid var(--red);
        color: var(--red);
    }
    @media (max-width: 700px) {
        .page-body { padding: 1.2rem 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-text">
            <h1>Settings</h1>
            <p>Manage your notification preferences.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-banner success">
            &nbsp;{{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert-banner error">
            &nbsp;Please fix the errors below.
        </div>
    @endif

    <div class="settings-tabs fade-up d2">
        <button class="tab-btn active" onclick="switchTab('notifications')">
            <img src="{{ asset('icons/bell.png') }}" alt="">
            Notifications
        </button>
    </div>

    <div class="tab-panel active fade-up d3" id="tab-notifications">
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">
                    <img src="{{ asset('icons/bell.png') }}" alt="">
                </div>
                <div>
                    <div class="settings-card-title">In-App Notification Events</div>
                    <div class="settings-card-sub">Choose which events show a notification badge in DormEase.</div>
                </div>
            </div>

            <form method="POST" action="{{ route('frontdesk.settings.updateNotifications') }}">
                @csrf
                @method('PUT')

                @php
                    $notifItems = [
                        'emergency_new' => [
                            'label' => 'Emergency Report Filed',
                            'desc'  => 'When a new emergency alert is logged.',
                            'icon'  => 'warn',
                        ],
                        'visitor_registration' => [
                            'label' => 'Visitor Registration',
                            'desc'  => 'When a tenant registers a visitor from the mobile app.',
                            'icon'  => 'nav-visit',
                        ],
                        'visitor_checkin' => [
                            'label' => 'Visitor Check-In',
                            'desc'  => 'When a visitor signs in at the front desk.',
                            'icon'  => 'nav-visit',
                        ],
                        'visitor_checkout' => [
                            'label' => 'Visitor Check-Out',
                            'desc'  => 'When a visitor departs and is logged out.',
                            'icon'  => 'nav-visit',
                        ],
                        'announcement_new' => [
                            'label' => 'New Announcement Posted',
                            'desc'  => 'When an announcement has been successfully posted.',
                            'icon'  => 'nav-announ',
                        ],
                    ];
                @endphp

                <div class="notif-list">
                    @foreach($notifItems as $key => $item)
                        <div class="notif-row">
                            <div class="notif-info">
                                <div class="notif-label">{{ $item['label'] }}</div>
                                <div class="notif-desc">{{ $item['desc'] }}</div>
                            </div>
                            <label class="toggle-wrap" title="{{ $item['label'] }}">
                                <input type="checkbox"
                                       name="{{ $key }}"
                                       value="1"
                                       {{ !empty($notifPrefs[$key]) ? 'checked' : '' }}>
                                <span class="toggle-track"></span>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="resetToggles()">Reset to Defaults</button>
                    <button type="submit" class="btn-save">Save Preferences</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function switchTab(name) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelector(`.tab-btn[onclick="switchTab('${name}')"]`).classList.add('active');
        document.getElementById('tab-' + name).classList.add('active');
    }

    const DEFAULTS = {
        emergency_new:    true,
        visitor_registration: true,
        visitor_checkin:  true,
        visitor_checkout: true,
        announcement_new: true,
    };

    function resetToggles() {
        Object.entries(DEFAULTS).forEach(([key, val]) => {
            const el = document.querySelector(`input[name="${key}"]`);
            if (el) el.checked = val;
        });
    }

    @if(session('open_tab'))
        switchTab('{{ session('open_tab') }}');
    @endif

    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
</script>
@endsection
