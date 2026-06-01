@extends('layout')

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

    .page-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -.02em;
        line-height: 1.2;
    }
    .page-header p {
        font-size: .88rem;
        color: var(--ink-muted);
        margin-top: .25rem;
    }
    .settings-tabs {
        display: flex;
        gap: .4rem;
        border-bottom: 2px solid var(--baby-pink);
        padding-bottom: 0;
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
    .tab-btn:hover {
        color: var(--hot-pink);
        background: var(--petal);
    }
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
    .field-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem 1.4rem;
    }
    .field-grid.single { grid-template-columns: 1fr; max-width: 440px; }
    .field {
        display: flex;
        flex-direction: column;
        gap: .35rem;
    }
    .field label {
        font-size: .8rem;
        font-weight: 700;
        color: var(--ink-muted);
        letter-spacing: .02em;
        text-transform: uppercase;
    }
    .field input {
        padding: .6rem .9rem;
        border-radius: 9px;
        border: 1.5px solid var(--baby-pink);
        font-family: var(--ff-body);
        font-size: .88rem;
        color: var(--ink);
        background: var(--blush);
        outline: none;
        transition: border-color .2s, background .2s;
    }
    .field input:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }
    .field input.is-error { border-color: var(--red); background: #fff5f5; }
    .field-error {
        font-size: .75rem;
        color: var(--red);
        margin-top: .1rem;
    }
    .field-hint {
        font-size: .75rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

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
    .pw-strength-bar {
        height: 4px;
        border-radius: 99px;
        background: var(--gray-light);
        margin-top: .5rem;
        overflow: hidden;
    }
    .pw-strength-fill {
        height: 100%;
        border-radius: 99px;
        width: 0%;
        transition: width .3s ease, background .3s ease;
    }
    .pw-strength-label {
        font-size: .72rem;
        color: var(--ink-muted);
        margin-top: .25rem;
    }
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
    .alert-banner {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .8rem 1.1rem;
        border-radius: 10px;
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: 1rem;
        animation: fadeUp .3s ease;
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
    .current-chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--petal);
        border: 1.5px solid var(--baby-pink);
        border-radius: 7px;
        padding: .25rem .7rem;
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink-muted);
        margin-bottom: .6rem;
    }
    .current-chip span { color: var(--hot-pink); font-weight: 700; }

    @media (max-width: 700px) {
        .field-grid { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
    }
    /* ── action loading overlay ── */
    .action-loading-overlay {
        position: fixed; inset: 0; z-index: 1200;
        display: none; align-items: center; justify-content: center;
        background: rgba(255,255,255,.72); backdrop-filter: blur(2px);
    }
    .action-loading-overlay.open { display: flex; }

    .action-loading-box {
        display: flex; align-items: center; flex-direction: column;
        gap: .75rem; padding: 1.25rem 1.6rem;
        border: 1px solid var(--baby-pink); border-radius: 12px;
        background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14);
        color: var(--ink); font-size: .9rem; font-weight: 700;
    }

    .loading-logo-wrap {
        width: 86px; height: 86px;
        border: 3px solid var(--baby-pink); border-radius: 50%;
        background: var(--gradient-pink);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 24px rgba(232,23,93,.25);
        animation: pulseLogo 1s ease-in-out infinite; flex-shrink: 0;
    }
    .loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }
    .is-loading { opacity: .75; pointer-events: none; }

    @keyframes pulseLogo {
        0%, 100% { transform: scale(1);     box-shadow: 0 10px 24px rgba(232,23,93,.25); }
        50%       { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); }
    }
</style>
@endsection

@section('content')
<div class="page-body">
    <div class="page-header fade-up d1">
        <h1>Settings</h1>
        <p>Manage your account security and notification preferences.</p>
    </div>
    @if(session('success'))
        <div class="alert-banner success">
             &nbsp;{{ session('success') }}
        </div>
    @endif
    @if($errors->any() && !$errors->has('current_password') && !$errors->has('email') && !$errors->has('new_password'))
        <div class="alert-banner error">
             &nbsp;Please fix the errors below.
        </div>
    @endif
    <div class="settings-tabs fade-up d2" id="settings-tabs">
        <button class="tab-btn active"
            onclick="switchTab('notifications')">
            <img src="{{ asset('icons/bell.png') }}" alt="">
            Notifications
        </button>
    </div>

    <div class="tab-panel active fade-up d3"
        id="tab-notifications">

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

            <form method="POST" action="{{ route('settings.updateNotifications') }}" data-loading-message="Saving preferences...">
                @csrf
                @method('PUT')

                <div class="notif-list">

                    @php
                        $notifItems = [
                            'maintenance_new'  => [
                                'label' => 'New Maintenance Request',
                                'desc'  => 'When a tenant submits a new maintenance or repair request.',
                                'icon'  => 'maintenance',
                            ],
                            'emergency_new'    => [
                                'label' => 'Emergency Report Filed',
                                'desc'  => 'When a front desk staff or tenant logs a new emergency alert.',
                                'icon'  => 'warn',
                            ],
                            'visitor_checkin'  => [
                                'label' => 'Visitor Check-In',
                                'desc'  => 'When a visitor signs in at the front desk.',
                                'icon'  => 'nav-visit',
                            ],
                            'visitor_checkout' => [
                                'label' => 'Visitor Check-Out',
                                'desc'  => 'When a visitor departs and is logged out.',
                                'icon'  => 'nav-visit',
                            ],
                            'billing_overdue'  => [
                                'label' => 'Overdue Water Bill',
                                'desc' => 'When a tenant\'s water billing payment is past due.',
                                'icon'  => 'billing',
                            ],
                            'document_request' => [
                                'label' => 'Document Request',
                                'desc'  => 'When a tenant submits a request for a document.',
                                'icon'  => 'nav-docu',
                            ],
                            'announcement_new' => [
                                'label' => 'New Announcement Posted',
                                'desc'  => 'When an announcement has been succesfully posted.',
                                'icon'  => 'nav-announ',
                            ],
                        ];
                    @endphp

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

@section('modals')
    <div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
        <div class="action-loading-box">
            <span class="loading-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="DormEase">
            </span>
            <span id="action-loading-text">Please wait...</span>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        function showActionLoading(message) {
        const overlay = document.getElementById('action-loading');
        document.getElementById('action-loading-text').textContent = message || 'Please wait...';
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
    }

    function setFormLoading(form, message) {
        form.querySelectorAll('button[type="submit"]').forEach(btn => {
            btn.textContent = 'Please wait...';
            btn.disabled    = true;
            btn.classList.add('is-loading');
        });
        form.querySelectorAll('button:not([type="submit"])').forEach(btn => {
            btn.disabled = true;
            btn.classList.add('is-loading');
        });
        showActionLoading(message);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form[data-loading-message]').forEach(form => {
            form.addEventListener('submit', function () {
                setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
            });
        });
    });
    function switchTab(name) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

        document.querySelector(`.tab-btn[onclick="switchTab('${name}')"]`).classList.add('active');
        document.getElementById('tab-' + name).classList.add('active');
    }
    function checkStrength(val) {
        const fill  = document.getElementById('pw-fill');
        const label = document.getElementById('pw-label');
        let score = 0;
        if (val.length >= 8)                        score++;
        if (/[A-Z]/.test(val))                      score++;
        if (/[0-9]/.test(val))                      score++;
        if (/[^A-Za-z0-9]/.test(val))               score++;

        const levels = [
            { w: '0%',   bg: 'var(--gray-light)', text: '' },
            { w: '25%',  bg: 'var(--red)',         text: 'Weak' },
            { w: '50%',  bg: 'var(--salmon)',      text: 'Fair' },
            { w: '75%',  bg: 'var(--shift-day)',   text: 'Good' },
            { w: '100%', bg: 'var(--green)',        text: 'Strong' },
        ];
        const lv = levels[score] || levels[0];
        fill.style.width      = val.length ? lv.w  : '0%';
        fill.style.background = lv.bg;
        label.textContent     = val.length ? lv.text : '';
    }
    const DEFAULTS = {
        maintenance_new:  true,
        emergency_new:    true,
        visitor_checkin:  false,
        visitor_checkout: false,
        billing_overdue:  true,
        document_request: true,
        announcement_new: false,
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