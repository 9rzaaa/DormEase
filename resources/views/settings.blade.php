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

    .archive-warning-banner {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        padding: .9rem 1.1rem;
        border-radius: 10px;
        background: var(--petal);
        border: 1.5px solid var(--bright-pink);
        color: var(--hot-pink);
        font-size: .84rem;
        font-weight: 600;
        line-height: 1.55;
        margin-bottom: 1.4rem;
    }
    .archive-warning-banner strong { color: var(--hot-pink); font-weight: 800; text-decoration: underline; }
    
    .archive-table { width: 100%; border-collapse: collapse; }
    .archive-table th {
        font-size: .72rem;
        font-weight: 700;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        padding: .5rem .75rem;
        text-align: left;
        border-bottom: 1.5px solid var(--petal);
        white-space: nowrap;
    }
    .archive-table td {
        padding: .85rem .75rem;
        border-bottom: 1px solid var(--petal);
        vertical-align: middle;
        font-size: .87rem;
        color: var(--ink);
    }
    .archive-table tr:last-child td { border-bottom: none; }
    .archive-table tr:hover td { background: var(--blush); }
    
    .archive-module-name { font-weight: 700; font-size: .88rem; color: var(--ink); }
    .archive-last-cleared { font-size: .75rem; color: var(--ink-muted); margin-top: .18rem; }
    
    .retention-input {
        width: 80px;
        padding: .42rem .6rem;
        border-radius: 8px;
        border: 1.5px solid var(--baby-pink);
        font-family: var(--ff-body);
        font-size: .85rem;
        color: var(--ink);
        background: var(--blush);
        outline: none;
        text-align: center;
        transition: border-color .2s;
    }
    .retention-input:focus { border-color: var(--bright-pink); background: var(--white); }
    .retention-input:disabled { opacity: .45; cursor: not-allowed; }
    
    .warn-input {
        width: 60px;
        padding: .42rem .6rem;
        border-radius: 8px;
        border: 1.5px solid var(--baby-pink);
        font-family: var(--ff-body);
        font-size: .85rem;
        color: var(--ink);
        background: var(--blush);
        outline: none;
        text-align: center;
        transition: border-color .2s;
    }
    .warn-input:focus { border-color: var(--bright-pink); background: var(--white); }
    .warn-input:disabled { opacity: .45; cursor: not-allowed; }
    
    .btn-clear-now {
        padding: .38rem .85rem;
        border-radius: 8px;
        border: 1.5px solid var(--bright-pink);
        background: var(--petal);
        color: var(--hot-pink);
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, color .2s;
        font-family: var(--ff-body);
        white-space: nowrap;
    }
    .btn-clear-now:hover { background: var(--gradient-pink); color: var(--white); border-color: var(--bright-pink); }
    .btn-clear-now:disabled { opacity: .4; cursor: not-allowed; }
    
    .apply-all-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .85rem 0 1rem;
        border-bottom: 1.5px solid var(--petal);
        margin-bottom: .5rem;
        flex-wrap: wrap;
    }
    .apply-all-label { font-size: .84rem; font-weight: 700; color: var(--ink-muted); flex-shrink: 0; }
    .btn-apply-all {
        padding: .42rem 1rem;
        border-radius: 8px;
        border: none;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .8rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--ff-body);
        transition: opacity .2s;
        box-shadow: var(--shadow-pink-btn);
    }
    .btn-apply-all:hover { opacity: .88; }

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
        <button class="tab-btn"
            onclick="switchTab('archive')">
            <img src="{{ asset('icons/archive.png') }}" alt="">
            Archive Clearing
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
        <div class="tab-panel fade-up d3" id="tab-archive">
 
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">
                    <img src="{{ asset('icons/archive.png') }}" alt="">
                </div>
                <div>
                    <div class="settings-card-title">Archive Auto-Clear Settings</div>
                    <div class="settings-card-sub">Configure automatic clearing of archive records per module.</div>
                </div>
            </div>
 
            <div class="archive-warning-banner">
                <span style="font-size:1.1rem;flex-shrink:0;">&#9888;</span>
                <span>
                    All clearing is <strong>permanent and cannot be undone</strong>.
                    Records deleted by auto-clear or manual clear are <strong>gone forever</strong>.
                    You will receive a notification <strong>before the scheduled clear runs</strong> based on your warn days setting.
                    To cancel, <strong>disable the toggle</strong> for that module before the clear date.
                    <strong>Save settings first</strong> before using Clear Now.
                </span>
            </div>
 
            <div class="apply-all-row">
                <span class="apply-all-label">Apply retention period to all modules:</span>
                <input type="number" id="apply-all-days" min="30" max="3650" value="365"
                    class="retention-input" style="width:90px;">
                <span style="font-size:.82rem;color:var(--ink-muted);">days</span>
                <button type="button" class="btn-apply-all" onclick="applyAllRetention()">Apply to All</button>
            </div>
 
            <table class="archive-table" id="archive-table">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Enable</th>
                        <th>Retention (days)</th>
                        <th>Warn Before (days)</th>
                        <th>Last Cleared</th>
                        <th>Clear Now</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $moduleLabels = [
                            'water_billing'       => 'Water Billing',
                            'visitor_logs'        => 'Visitor Logs',
                            'announcements'       => 'Announcements',
                            'tenant_archive'      => 'Tenant Archive',
                            'maintenance_archive' => 'Maintenance Archive',
                            'emergency_archive'   => 'Emergency Archive',
                            'staff_archive'       => 'Staff Archive',
                        ];
                    @endphp
                    @foreach($moduleLabels as $moduleKey => $moduleLabel)
                        @php $s = $archiveSettings[$moduleKey] ?? null; @endphp
                        <tr data-module="{{ $moduleKey }}">
                            <td>
                                <div class="archive-module-name">{{ $moduleLabel }}</div>
                                <div class="archive-last-cleared">
                                    Last cleared:
                                    <span class="last-cleared-val">
                                        {{ $s?->last_cleared_at ? $s->last_cleared_at->format('M d, Y h:i A') : 'Never' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <label class="toggle-wrap">
                                    <input type="checkbox" class="module-enable-toggle"
                                        data-module="{{ $moduleKey }}"
                                        {{ $s?->is_enabled ? 'checked' : '' }}
                                        onchange="toggleModuleRow('{{ $moduleKey }}', this.checked)">
                                    <span class="toggle-track"></span>
                                </label>
                            </td>
                            <td>
                                <input type="number" class="retention-input module-retention"
                                    data-module="{{ $moduleKey }}"
                                    min="30" max="3650"
                                    value="{{ $s?->retention_days ?? 365 }}"
                                    {{ $s?->is_enabled ? '' : 'disabled' }}>
                            </td>
                            <td>
                                <input type="number" class="warn-input module-warn"
                                    data-module="{{ $moduleKey }}"
                                    min="1" max="30"
                                    value="{{ $s?->warn_days_before ?? 7 }}"
                                    {{ $s?->is_enabled ? '' : 'disabled' }}>
                            </td>
                            <td>
                                <span class="last-cleared-display" style="font-size:.8rem;color:var(--ink-muted);">
                                    {{ $s?->last_cleared_at ? $s->last_cleared_at->format('M d, Y') : 'Never' }}
                                </span>
                            </td>
                            <td>
                                <button type="button"
                                    class="btn-clear-now"
                                    data-module="{{ $moduleKey }}"
                                    data-label="{{ $moduleLabel }}"
                                    {{ $s?->is_enabled ? '' : 'disabled' }}
                                    onclick="confirmClearNow('{{ $moduleKey }}', '{{ $moduleLabel }}', this)">
                                    Clear Now
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
 
            <div class="form-actions">
                <button type="button" class="btn-save" onclick="saveArchiveSettings()">Save Archive Settings</button>
            </div>
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
        switchTab("{{ session('open_tab') }}");
    @endif
    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif

    function toggleModuleRow(module, enabled) {
        document.querySelector(`.module-retention[data-module="${module}"]`).disabled = !enabled;
        document.querySelector(`.module-warn[data-module="${module}"]`).disabled = !enabled;
        var clearBtn = document.querySelector(`.btn-clear-now[data-module="${module}"]`);
        if (clearBtn) clearBtn.disabled = !enabled;
    }
    
    function applyAllRetention() {
        var days = parseInt(document.getElementById('apply-all-days').value);
        if (!days || days < 30 || days > 3650) {
            showToast('Enter a valid retention period between 30 and 3650 days.', 'error');
            return;
        }
        document.querySelectorAll('.module-retention').forEach(function(input) {
            input.value = days;
        });
        showToast('Retention period applied to all modules. Save to confirm.', 'success');
    }
    
    function saveArchiveSettings() {
        var modules = [];
        document.querySelectorAll('#archive-table tbody tr').forEach(function(row) {
            var module = row.dataset.module;
            modules.push({
                module:           module,
                is_enabled:       row.querySelector('.module-enable-toggle').checked,
                retention_days:   parseInt(row.querySelector('.module-retention').value),
                warn_days_before: parseInt(row.querySelector('.module-warn').value),
            });
        });
    
        showActionLoading('Saving archive settings...');
    
        fetch('{{ route("settings.archive.update") }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ modules: modules }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            document.getElementById('action-loading').classList.remove('open');
            if (data.success) {
                showToast('Archive settings saved.', 'success');
            } else {
                showToast(data.message || 'Failed to save.', 'error');
            }
        })
        .catch(function() {
            document.getElementById('action-loading').classList.remove('open');
            showToast('Network error.', 'error');
        });
    }
    
    function confirmClearNow(module, label, btn) {
        var retentionInput = document.querySelector(`.module-retention[data-module="${module}"]`);
        var retentionDays  = retentionInput ? parseInt(retentionInput.value) : null;

        if (!confirm('This will permanently delete all ' + label + ' records older than ' + retentionDays + ' day(s). This action cannot be undone. Proceed?')) {
            return;
        }
    
        btn.disabled = true;
        btn.textContent = 'Clearing...';
        showActionLoading('Clearing ' + label + '...');
    
        fetch('{{ route("settings.archive.clearNow") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ module: module, retention_days: retentionDays }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            document.getElementById('action-loading').classList.remove('open');
            btn.disabled = false;
            btn.textContent = 'Clear Now';
            if (data.success) {
                showToast(data.message, 'success');
                var row = btn.closest('tr');
                row.querySelectorAll('.last-cleared-val, .last-cleared-display').forEach(function(el) {
                    el.textContent = data.last_cleared_at;
                });
            } else {
                showToast(data.message || 'Failed to clear.', 'error');
            }
        })
        .catch(function() {
            document.getElementById('action-loading').classList.remove('open');
            btn.disabled = false;
            btn.textContent = 'Clear Now';
            showToast('Network error.', 'error');
        });
    }
</script>
@endsection