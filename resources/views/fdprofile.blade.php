@extends('fdlayout')

@section('title', 'DormEase: My Profile')
@section('page-title', 'My Profile')

@section('styles')
<style>
    .page-body {
        padding: 2rem 2.2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
        background: var(--pink-bg);
        box-sizing: border-box;
    }

    .page-header-text h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.15;
        margin: 0;
    }

    .page-header-text .dorm-sub {
        font-size: .9rem;
        font-weight: 600;
        color: var(--bright-pink);
        margin-top: .2rem;
    }

    .hero-card {
        position: relative;
        background: var(--white);
        border-radius: 22px;
        border: 2px solid var(--pink-200);
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(255,45,120,.10);
    }

    .hero-banner {
        height: 90px;
        background: linear-gradient(120deg, #e8175d 0%, #ff6ba8 50%, #ffb3d0 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(
            45deg,
            rgba(255,255,255,.04) 0px,
            rgba(255,255,255,.04) 1px,
            transparent 1px,
            transparent 18px
        );
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        right: -60px;
        top: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .hero-body {
        padding: 0 1.8rem 1.6rem;
        display: flex;
        align-items: flex-end;
        gap: 1.2rem;
    }

    .hero-avatar-wrap {
        flex-shrink: 0;
        margin-top: -36px;
        position: relative;
        cursor: pointer;
    }

    .hero-avatar {
        width: 78px;
        height: 78px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e8175d, #ff6ba8);
        border: 4px solid var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--white);
        box-shadow: 0 4px 18px rgba(232,23,93,.30);
        font-family: var(--ff-display);
        letter-spacing: -.02em;
        overflow: hidden;
        position: relative;
        transition: box-shadow .2s;
    }

    .hero-avatar img.avatar-photo {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .avatar-overlay {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(0,0,0,.42);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        opacity: 0;
        transition: opacity .2s;
        pointer-events: none;
    }

    .avatar-overlay svg {
        width: 18px;
        height: 18px;
        stroke: #fff;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .avatar-overlay span {
        font-size: .6rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .hero-avatar-wrap:hover .avatar-overlay { opacity: 1; }
    .hero-avatar-wrap:hover .hero-avatar { box-shadow: 0 6px 24px rgba(232,23,93,.45); }

    .hero-info {
        flex: 1;
        padding-top: .9rem;
        min-width: 0;
    }

    .hero-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .hero-email {
        font-size: .82rem;
        color: var(--ink-muted);
        margin-top: .18rem;
    }

    .hero-chips {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        margin-top: .55rem;
    }

    .hchip {
        display: inline-flex;
        align-items: center;
        gap: .28rem;
        padding: .2rem .65rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
        border: 1.5px solid;
        white-space: nowrap;
        letter-spacing: .02em;
    }

    .forms-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.4rem;
        align-items: start;
    }

    .section-card {
        background: var(--white);
        border-radius: 18px;
        border: 2px solid var(--pink-200);
        box-shadow: 0 4px 18px rgba(255,45,120,.07);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s;
    }

    .section-card:hover { box-shadow: 0 8px 28px rgba(255,45,120,.12); }

    .section-head {
        padding: 1rem 1.4rem;
        border-bottom: 2px solid var(--pink-100);
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(255,45,120,.22);
    }

    .section-icon img {
        width: 17px;
        height: 17px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .section-title {
        font-size: .95rem;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.01em;
    }

    .section-sub {
        font-size: .73rem;
        color: var(--ink-muted);
        margin-top: .06rem;
    }

    .section-body {
        padding: 1.3rem 1.4rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .section-body form {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .form-fields { flex: 1; }

    .field-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
    }

    .field-grid.cols-1 { grid-template-columns: 1fr; }

    .form-field {
        display: flex;
        flex-direction: column;
        gap: .3rem;
    }

    .form-field.full { grid-column: 1 / -1; }

    .form-field label {
        font-size: .68rem;
        font-weight: 800;
        color: var(--hot-pink);
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .form-field input {
        padding: .58rem .9rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--pink-50);
        font-family: var(--ff-body);
        font-size: .855rem;
        color: var(--ink);
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
        width: 100%;
        box-sizing: border-box;
    }

    .form-field input:focus {
        border-color: var(--bright-pink);
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(255,45,120,.09);
    }

    .readonly-val {
        padding: .58rem .9rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-100);
        background: var(--pink-50);
        font-size: .855rem;
        color: var(--ink-muted);
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .input-wrap { position: relative; }
    .input-wrap input { padding-right: 2.5rem; }

    .toggle-pw {
        position: absolute;
        right: .75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 0;
    }

    .toggle-pw img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        opacity: .35;
        transition: opacity .2s;
    }

    .toggle-pw:hover img { opacity: .8; }

    .pw-strength-bar {
        height: 3px;
        border-radius: 2px;
        background: var(--pink-100);
        overflow: hidden;
        margin-top: .5rem;
    }

    .pw-strength-fill {
        height: 100%;
        border-radius: 2px;
        transition: width .3s, background .3s;
        width: 0%;
    }

    .pw-strength-label {
        font-size: .67rem;
        color: var(--ink-muted);
        margin-top: .2rem;
    }

    .pw-hint {
        font-size: .69rem;
        color: var(--ink-muted);
        margin-top: .2rem;
        line-height: 1.5;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
        margin-top: 1.2rem;
        padding-top: 1rem;
        border-top: 1.5px solid var(--pink-100);
    }

    .btn-ghost {
        padding: .48rem 1rem;
        border-radius: 9px;
        border: 1.5px solid var(--pink-200);
        background: none;
        font-family: var(--ff-body);
        font-size: .82rem;
        font-weight: 600;
        color: var(--ink-muted);
        cursor: pointer;
        transition: border-color .2s, color .2s;
    }

    .btn-ghost:hover {
        border-color: var(--bright-pink);
        color: var(--bright-pink);
    }

    .btn-save {
        padding: .48rem 1.2rem;
        border-radius: 9px;
        border: none;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-family: var(--ff-body);
        font-size: .82rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(255,45,120,.25);
        transition: opacity .2s, transform .15s;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .btn-save:hover { opacity: .88; transform: translateY(-1px); }

    .btn-save img {
        width: 13px;
        height: 13px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .shift-dot {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .72rem;
        font-weight: 700;
    }

    .shift-dot::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .shift-dot.day::before   { background: #f59e0b; }
    .shift-dot.night::before { background: #6366f1; }

    .fade-up { animation: fdFadeUp .45s ease both; }
    @keyframes fdFadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .d1 { animation-delay: .04s; }
    .d2 { animation-delay: .1s; }
    .d3 { animation-delay: .17s; }
    .d4 { animation-delay: .24s; }

    @media (max-width: 900px) {
        .forms-grid { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
    }

    @media (max-width: 580px) {
        .field-grid { grid-template-columns: 1fr; }
        .hero-body { flex-direction: column; align-items: flex-start; gap: .5rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header-text fade-up d1">
        <h1>My Profile</h1>
        <div class="dorm-sub">Sanctissimo Rosario Ladies Dormitory</div>
    </div>

    @php
        $rc = ['bg'=>'#e8f4ff','color'=>'#1a6fbd','border'=>'#90c4f8'];

        $dutyColors = [
            'on_duty'  => ['bg'=>'#f0fdf8','color'=>'#166534','border'=>'#86efac'],
            'off_duty' => ['bg'=>'#fff0f6','color'=>'#E8175D','border'=>'#FFB3D0'],
            'on_leave' => ['bg'=>'#fff8eb','color'=>'#c8960c','border'=>'#f0c040'],
        ];
        $dc = $dutyColors[$staff->duty_status ?? 'off_duty'] ?? $dutyColors['off_duty'];

        $dutyLabel = [
            'on_duty'  => 'On Duty',
            'off_duty' => 'Off Duty',
            'on_leave' => 'On Leave',
        ];

        $shiftClass = strtolower($staff->shift_schedule ?? 'day') === 'night' ? 'night' : 'day';
    @endphp

    <div class="hero-card fade-up d2">
        <div class="hero-banner"></div>
        <div class="hero-body">
            <form method="POST" action="{{ route('fdprofile.avatar') }}" enctype="multipart/form-data" id="avatar-form">
                @csrf
                @method('PUT')
                <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display:none;">
                <div class="hero-avatar-wrap" onclick="document.getElementById('avatar-input').click()">
                    <div class="hero-avatar">
                        @if($staff->profile_picture)
                            <img src="{{ Storage::url($staff->profile_picture) }}" alt="Avatar" class="avatar-photo" id="avatar-preview">
                        @else
                            <span id="avatar-initials">{{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}</span>
                            <img src="" alt="Avatar" class="avatar-photo" id="avatar-preview" style="display:none;">
                        @endif
                        <div class="avatar-overlay">
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            <span>Change</span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="hero-info">
                <div class="hero-name" id="hero-display-name">
                    {{ $staff->first_name }} {{ $staff->last_name }}
                </div>
                <div class="hero-email">{{ $staff->email }}</div>
                <div class="hero-chips">
                    <span class="hchip" style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border-color:{{ $rc['border'] }};">
                        Front Desk
                    </span>
                    <span class="hchip" style="background:{{ $dc['bg'] }};color:{{ $dc['color'] }};border-color:{{ $dc['border'] }};">
                        {{ $dutyLabel[$staff->duty_status ?? 'off_duty'] ?? 'Off Duty' }}
                    </span>
                    @if($staff->shift_schedule)
                        <span class="hchip" style="background:{{ $shiftClass === 'night' ? '#f0f0ff' : '#fff8eb' }};color:{{ $shiftClass === 'night' ? '#6366f1' : '#c8960c' }};border-color:{{ $shiftClass === 'night' ? '#a5b4fc' : '#f0c040' }};">
                            <span class="shift-dot {{ $shiftClass }}"></span>
                            {{ ucfirst($staff->shift_schedule) }} Shift
                        </span>
                    @endif
                    <span class="hchip" style="background:#f5f5f5;color:#555;border-color:#ddd;">
                        ST-{{ str_pad($staff->staff_id, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="forms-grid">

        <div class="section-card fade-up d3">
            <div class="section-head">
                <div class="section-icon">
                    <img src="{{ asset('icons/staff-2.png') }}" alt="">
                </div>
                <div>
                    <div class="section-title">Personal Information</div>
                    <div class="section-sub">Update your name and contact details</div>
                </div>
            </div>
            <div class="section-body">
                <form method="POST" action="{{ route('fdprofile.updateInfo') }}" id="info-form">
                    @csrf
                    @method('PUT')
                    <div class="form-fields">
                        <div class="field-grid">
                            <div class="form-field">
                                <label>First Name</label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', $staff->first_name) }}"
                                    required oninput="updateDisplayName()">
                            </div>
                            <div class="form-field">
                                <label>Last Name</label>
                                <input type="text" name="last_name"
                                    value="{{ old('last_name', $staff->last_name) }}"
                                    required oninput="updateDisplayName()">
                            </div>
                            <div class="form-field full">
                                <label>Email Address</label>
                                <input type="email" name="email"
                                    value="{{ old('email', $staff->email) }}" required>
                            </div>
                            <div class="form-field full">
                                <label>Contact Number</label>
                                <input type="text" name="contact_number"
                                    value="{{ old('contact_number', $staff->contact_number) }}"
                                    placeholder="e.g. 0912-345-6789">
                            </div>
                            <div class="form-field full">
                                <label>Staff ID</label>
                                <div class="readonly-val">
                                    ST-{{ str_pad($staff->staff_id, 3, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                            <div class="form-field full">
                                <label>Role</label>
                                <div class="readonly-val">
                                    <span style="padding:.14rem .58rem;border-radius:5px;font-size:.72rem;font-weight:700;
                                        background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border:1.5px solid {{ $rc['border'] }};">
                                        Front Desk
                                    </span>
                                </div>
                            </div>
                            <div class="form-field full">
                                <label>Duty Status</label>
                                <div class="readonly-val">
                                    <span style="padding:.14rem .58rem;border-radius:5px;font-size:.72rem;font-weight:700;
                                        background:{{ $dc['bg'] }};color:{{ $dc['color'] }};border:1.5px solid {{ $dc['border'] }};">
                                        {{ $dutyLabel[$staff->duty_status ?? 'off_duty'] ?? 'Off Duty' }}
                                    </span>
                                </div>
                            </div>
                            <div class="form-field full">
                                <label>Shift Schedule</label>
                                <div class="readonly-val">
                                    <span class="shift-dot {{ $shiftClass }}"></span>
                                    {{ ucfirst($staff->shift_schedule ?? 'Not set') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-ghost" onclick="document.getElementById('info-form').reset(); updateDisplayName();">Reset</button>
                        <button type="submit" class="btn-save">
                            <img src="{{ asset('icons/export.png') }}" alt="">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="section-card fade-up d4">
            <div class="section-head">
                <div class="section-icon">
                    <img src="{{ asset('icons/nav-settings.png') }}" alt="">
                </div>
                <div>
                    <div class="section-title">Change Password</div>
                    <div class="section-sub">Keep your account secure</div>
                </div>
            </div>
            <div class="section-body">
                <form method="POST" action="{{ route('fdprofile.updatePassword') }}" id="pw-form">
                    @csrf
                    @method('PUT')
                    <div class="form-fields">
                        <div class="field-grid cols-1">
                            <div class="form-field">
                                <label>Current Password</label>
                                <div class="input-wrap">
                                    <input type="password" name="current_password" id="cur-pw"
                                        placeholder="Enter current password" required autocomplete="current-password">
                                    <button type="button" class="toggle-pw" onclick="togglePw('cur-pw', this)">
                                        <img src="{{ asset('icons/eye.png') }}" alt="Show">
                                    </button>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>New Password</label>
                                <div class="input-wrap">
                                    <input type="password" name="password" id="new-pw"
                                        placeholder="Min. 8 characters" required autocomplete="new-password"
                                        oninput="checkStrength(this.value)">
                                    <button type="button" class="toggle-pw" onclick="togglePw('new-pw', this)">
                                        <img src="{{ asset('icons/eye.png') }}" alt="Show">
                                    </button>
                                </div>
                                <div class="pw-strength-bar">
                                    <div class="pw-strength-fill" id="strength-fill"></div>
                                </div>
                                <div class="pw-strength-label" id="strength-label"></div>
                            </div>
                            <div class="form-field">
                                <label>Confirm New Password</label>
                                <div class="input-wrap">
                                    <input type="password" name="password_confirmation" id="conf-pw"
                                        placeholder="Repeat new password" required autocomplete="new-password">
                                    <button type="button" class="toggle-pw" onclick="togglePw('conf-pw', this)">
                                        <img src="{{ asset('icons/eye.png') }}" alt="Show">
                                    </button>
                                </div>
                                <div class="pw-hint">At least 8 characters — mix letters, numbers &amp; symbols.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-ghost"
                            onclick="document.getElementById('pw-form').reset(); resetStrength();">Reset</button>
                        <button type="submit" class="btn-save">
                            <img src="{{ asset('icons/nav-settings.png') }}" alt="">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection

@section('modals')
@endsection

@section('scripts')
<script>
    document.getElementById('avatar-input').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const preview  = document.getElementById('avatar-preview');
        const initials = document.getElementById('avatar-initials');
        const reader   = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initials) initials.style.display = 'none';
        };
        reader.readAsDataURL(file);
        document.getElementById('avatar-form').submit();
    });

    function updateDisplayName() {
        const fn = document.querySelector('[name="first_name"]').value;
        const ln = document.querySelector('[name="last_name"]').value;
        document.getElementById('hero-display-name').textContent = fn + ' ' + ln;
    }

    function togglePw(inputId, btn) {
        const inp = document.getElementById(inputId);
        inp.type = inp.type === 'text' ? 'password' : 'text';
        btn.querySelector('img').style.opacity = inp.type === 'text' ? '.8' : '.35';
    }

    function checkStrength(val) {
        const fill  = document.getElementById('strength-fill');
        const label = document.getElementById('strength-label');
        if (!val) { fill.style.width = '0%'; label.textContent = ''; return; }
        let score = 0;
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const levels = [
            { w: '20%',  color: '#DF0404', text: 'Weak' },
            { w: '50%',  color: '#f59e0b', text: 'Fair' },
            { w: '75%',  color: '#29BD9B', text: 'Good' },
            { w: '100%', color: '#16a34a', text: 'Strong' },
        ];
        const lvl = levels[score - 1] ?? levels[0];
        fill.style.width      = lvl.w;
        fill.style.background = lvl.color;
        label.textContent     = lvl.text;
        label.style.color     = lvl.color;
    }

    function resetStrength() {
        document.getElementById('strength-fill').style.width = '0%';
        document.getElementById('strength-label').textContent = '';
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast('{{ session("success") }}', 'success'));
    @endif
    @if(session('error'))
        document.addEventListener('DOMContentLoaded', () => showToast('{{ session("error") }}', 'error'));
    @endif
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => showToast('{{ $errors->first() }}', 'error'));
    @endif
</script>
@endsection