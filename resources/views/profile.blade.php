@extends('layout')

@section('title', 'DormEase: My Profile')
@section('page-title', 'My Profile')

@section('styles')
<style>
    .page-body {
        padding: 1.6rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    /* ── PAGE HEADER ── */
    .page-header h1 {
        font-size: 1.6rem; font-weight: 700;
        color: var(--hot-pink); letter-spacing: -.02em; line-height: 1.2;
    }
    .page-header .dorm-name {
        font-size: .8rem;   color: var(--hot-pink) ; margin-top: .1rem;
    }

    /* ══════════════════════════════════════════
       IDENTITY CARD
    ══════════════════════════════════════════ */
    .identity-card {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 1rem 1.4rem;
        gap: 1rem;
    }

    .identity-initial {
        width: 52px; height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF2D78, #E8175D);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.35rem; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }

    .identity-main {
        flex: 1;
        min-width: 0;
    }
    .identity-name {
        font-size: .98rem; font-weight: 700; color: var(--ink); line-height: 1.2;
    }
    .identity-email {
        font-size: .75rem; color: var(--ink-muted); margin-top: .15rem;
    }
    .identity-chips {
        display: flex; flex-wrap: wrap; gap: .35rem; margin-top: .4rem;
    }
    .chip {
        display: inline-flex; align-items: center; gap: .28rem;
        padding: .16rem .6rem; border-radius: 20px;
        font-size: .68rem; font-weight: 700; border: 1.5px solid; white-space: nowrap;
    }
    .chip-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

    /* meta pills — right side of identity card */
    .identity-meta {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-shrink: 0;
    }
    .meta-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .08rem;
        background: var(--blush);
        border: 1.5px solid var(--baby-pink);
        border-radius: 10px;
        padding: .5rem .85rem;
        min-width: 90px;
        text-align: center;
    }
    .meta-pill-label {
        font-size: .62rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .04em; white-space: nowrap;
    }
    .meta-pill-val {
        font-size: .8rem; font-weight: 700; color: var(--hot-pink);
        font-family: monospace; white-space: nowrap;
    }
    .meta-pill-val.normal {
        font-family: var(--ff-body); color: var(--ink);
    }

    /* ══════════════════════════════════════════
       FORMS ROW — equal height side by side
    ══════════════════════════════════════════ */
    .forms-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        align-items: stretch;   /* equal height */
    }

    /* ── SECTION CARDS ── */
    .section-card {
        background: var(--white);
        border-radius: 16px;
        border: 1.5px solid var(--baby-pink);
        box-shadow: var(--shadow);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .section-head {
        padding: .85rem 1.2rem;
        border-bottom: 1.5px solid var(--baby-pink);
        display: flex; align-items: center; gap: .5rem;
        flex-shrink: 0;
    }
    .section-title-icon {
        width: 26px; height: 26px; border-radius: 7px;
        background: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .section-title-icon img {
        width: 13px; height: 13px; object-fit: contain;
        filter: brightness(0) invert(1);
    }
    .section-title  { font-size: .9rem; font-weight: 700; color: var(--ink); }
    .section-sub    { font-size: .71rem; color: var(--ink-muted); margin-top: .04rem; }
    .section-body   {
        padding: 1rem 1.2rem;
        flex: 1;                /* stretch to fill card height */
        display: flex;
        flex-direction: column;
    }
    /* push form-actions to the bottom of the card */
    .section-body form {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .form-fields { flex: 1; }

    /* ── FORM FIELDS ── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .72rem; }
    .form-grid.single { grid-template-columns: 1fr; }
    .form-field { display: flex; flex-direction: column; gap: .26rem; }
    .form-field.full { grid-column: 1 / -1; }
    .form-field label {
        font-size: .68rem; font-weight: 700; color: var(--ink-muted);
        letter-spacing: .04em; text-transform: uppercase;
    }
    .form-field input {
        padding: .5rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        font-family: var(--ff-body); font-size: .84rem;
        color: var(--ink); background: #fafafa;
        outline: none; transition: border-color .2s, background .2s; width: 100%;
    }
    .form-field input:focus {
        border-color: #E8175D; background: var(--white);
        box-shadow: 0 0 0 3px rgba(232,23,93,.08);
    }
    .readonly-field {
        padding: .5rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light);
        background: var(--pink-bg);
        display: flex; align-items: center; gap: .45rem; min-height: 35px;
    }

    /* password toggle */
    .input-wrap { position: relative; }
    .input-wrap input { padding-right: 2.4rem; }
    .toggle-pw {
        position: absolute; right: .7rem; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; display: flex; align-items: center;
    }
    .toggle-pw img { width: 14px; height: 14px; object-fit: contain; opacity: .4; }
    .toggle-pw:hover img { opacity: 1; }

    .pw-hint { font-size: .68rem; color: var(--ink-muted); margin-top: .18rem; line-height: 1.5; }
    .pw-strength-wrap { margin-top: .28rem; }
    .pw-strength-bar { height: 3px; border-radius: 2px; background: var(--gray-light); overflow: hidden; }
    .pw-strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0%; }
    .pw-strength-label { font-size: .66rem; color: var(--ink-muted); margin-top: .2rem; }

    /* form actions always pinned to bottom */
    .form-actions {
        display: flex; justify-content: flex-end; gap: .5rem;
        margin-top: auto;
        padding-top: .85rem;
        border-top: 1.5px solid var(--baby-pink);
    }
    .btn-cancel {
        padding: .42rem .9rem; border-radius: 8px;
        border: 1.5px solid var(--gray-light); background: none;
        font-family: var(--ff-body); font-size: .81rem; font-weight: 600;
        color: var(--ink-muted); cursor: pointer; transition: border-color .2s, color .2s;
    }
    .btn-cancel:hover { border-color: #E8175D; color: #E8175D; }
    .btn-submit {
        padding: .42rem 1.05rem; border-radius: 8px; border: none;
        background: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
        color: #fff; font-family: var(--ff-body); font-size: .81rem; font-weight: 700;
        cursor: pointer; box-shadow: 0 3px 10px rgba(232,23,93,.24);
        transition: opacity .2s, transform .15s;
        display: flex; align-items: center; gap: .38rem;
    }
    .btn-submit:hover { opacity: .88; transform: translateY(-1px); }

    /* ══════════════════════════════════════════
       DANGER ZONE — full width below forms
    ══════════════════════════════════════════ */
    .danger-card {
        background: var(--white);
        border-radius: 16px;
        border: 1.5px solid #ffd0d0;
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .danger-head {
        padding: .75rem 1.2rem;
        background: #fff5f5;
        border-bottom: 1.5px solid #ffd0d0;
        display: flex; align-items: center; gap: .5rem;
    }
    .danger-title-icon {
        width: 26px; height: 26px; border-radius: 7px;
        background: var(--red);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .danger-title-icon img {
        width: 13px; height: 13px; object-fit: contain;
        filter: brightness(0) invert(1);
    }
    .danger-title { font-size: .9rem; font-weight: 700; color: var(--red); }
    .danger-sub   { font-size: .71rem; color: var(--ink-muted); margin-top: .04rem; }

    .danger-body {
        padding: .85rem 1.2rem;
        display: flex; align-items: center;
        justify-content: space-between; gap: 1rem;
    }
    .danger-text strong { font-size: .83rem; color: var(--red); font-weight: 700; }
    .danger-text span   { font-size: .76rem; color: var(--ink-muted); display: block; margin-top: .1rem; }
    .btn-danger {
        padding: .4rem 1rem; border-radius: 8px;
        border: 1.5px solid var(--red); background: none;
        font-family: var(--ff-body); font-size: .79rem; font-weight: 700;
        color: var(--red); cursor: pointer; white-space: nowrap;
        transition: background .2s, color .2s; flex-shrink: 0;
    }
    .btn-danger:hover { background: var(--red); color: #fff; }

    /* animations */
    @keyframes fadeIn { from{opacity:0;transform:translateY(8px);} to{opacity:1;transform:translateY(0);} }
    .fade-up { animation: fadeIn .38s ease both; }
    .d1{animation-delay:.04s;} .d2{animation-delay:.1s;}
    .d3{animation-delay:.16s;} .d4{animation-delay:.22s;}
    .d5{animation-delay:.28s;}

    @media (max-width: 900px) {
        .forms-row { grid-template-columns: 1fr; }
        .identity-meta { display: none; }
    }
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .page-body { padding: 1rem; }
        .danger-body { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    {{-- PAGE HEADER --}}
    <div class="page-header fade-up d1">
        <h1>My Profile</h1>
        <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
    </div>

    {{-- ══ IDENTITY CARD ══ --}}
    @php
        $roleMap = [
            'admin'     => ['bg'=>'#FFE4F0','color'=>'#E8175D','border'=>'#FFB3D0'],
            'frontdesk' => ['bg'=>'#e8f4ff','color'=>'#1a6fbd','border'=>'#90c4f8'],
            'guard'     => ['bg'=>'#f3f0ff','color'=>'#6d4fc4','border'=>'#c4b5fd'],
            'staff'     => ['bg'=>'#f0fdf8','color'=>'#166534','border'=>'#86efac'],
        ];
        $rc = $roleMap[strtolower($staff->role ?? '')] ?? ['bg'=>'#f0f0f0','color'=>'#555','border'=>'#ccc'];

        $dutyMap = [
            'on_duty'  => ['bg'=>'#e8faf5','color'=>'#29BD9B','border'=>'#29BD9B','dot'=>'#29BD9B'],
            'off_duty' => ['bg'=>'#fff0f0','color'=>'#DF0404','border'=>'#FFC5C5','dot'=>'#DF0404'],
            'on_leave' => ['bg'=>'#fff9e6','color'=>'#c8960c','border'=>'#f0c040','dot'=>'#c8960c'],
        ];
        $dc = $dutyMap[$staff->duty_status ?? ''] ?? ['bg'=>'#f0f0f0','color'=>'#555','border'=>'#ccc','dot'=>'#999'];

        $isNight  = $staff->shift_schedule && strtolower($staff->shift_schedule) === 'night';
        $shiftDot = $isNight ? '#6366f1' : '#f59e0b';
        $shiftBg  = $isNight ? '#f3f0ff' : '#fff9e6';
        $shiftClr = $isNight ? '#6366f1' : '#c8960c';
        $shiftBrd = $isNight ? '#c4b5fd' : '#f0c040';

        $memberSince = \Carbon\Carbon::parse($staff->created_at)->format('M d, Y');
    @endphp

    <div class="identity-card fade-up d2">

        <div class="identity-initial">
            {{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}
        </div>

        <div class="identity-main">
            <div class="identity-name" id="sidebar-display-name">
                {{ $staff->first_name }} {{ $staff->last_name }}
            </div>
            <div class="identity-email">{{ $staff->email }}</div>
            <div class="identity-chips">
                <span class="chip" style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border-color:{{ $rc['border'] }};">
                    {{ ucfirst($staff->role ?? '—') }}
                </span>
                <span class="chip" style="background:{{ $dc['bg'] }};color:{{ $dc['color'] }};border-color:{{ $dc['border'] }};">
                    <span class="chip-dot" style="background:{{ $dc['dot'] }};"></span>
                    {{ ucwords(str_replace('_', ' ', $staff->duty_status ?? 'Unknown')) }}
                </span>
                @if($staff->shift_schedule)
                <span class="chip" style="background:{{ $shiftBg }};color:{{ $shiftClr }};border-color:{{ $shiftBrd }};">
                    <span class="chip-dot" style="background:{{ $shiftDot }};"></span>
                    {{ $staff->shift_schedule }} shift
                </span>
                @endif
            </div>
        </div>

        {{-- Meta pills — no dividers, just spaced pills --}}
        <div class="identity-meta">
            <div class="meta-pill">
                <div class="meta-pill-label">Staff ID</div>
                <div class="meta-pill-val">ST-{{ str_pad($staff->staff_id, 3, '0', STR_PAD_LEFT) }}</div>
            </div>
            @if($staff->staff_code)
            <div class="meta-pill">
                <div class="meta-pill-label">Staff Code</div>
                <div class="meta-pill-val">{{ $staff->staff_code }}</div>
            </div>
            @endif
            <div class="meta-pill">
                <div class="meta-pill-label">Member Since</div>
                <div class="meta-pill-val normal">{{ $memberSince }}</div>
            </div>
        </div>

    </div>{{-- end identity-card --}}

    {{-- ══ FORMS ROW — equal height ══ --}}
    <div class="forms-row">

        {{-- Personal Information --}}
        <div class="section-card fade-up d3">
            <div class="section-head">
                <div class="section-title-icon">
                    <img src="{{ asset('icons/staff-2.png') }}" alt="">
                </div>
                <div>
                    <div class="section-title">Personal Information</div>
                    <div class="section-sub">Update your name and contact details</div>
                </div>
            </div>
            <div class="section-body">
                <form method="POST" action="{{ route('profile.update') }}" id="info-form">
                    @csrf
                    @method('PUT')
                    <div class="form-fields">
                        <div class="form-grid">
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
                            <div class="form-field">
                                <label>Role <span style="font-size:.61rem;font-weight:400;text-transform:none;">(admin managed)</span></label>
                                <div class="readonly-field">
                                    <span style="padding:.14rem .58rem;border-radius:5px;font-size:.7rem;font-weight:700;
                                        background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border:1.5px solid {{ $rc['border'] }};">
                                        {{ ucfirst($staff->role ?? '—') }}
                                    </span>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>Shift <span style="font-size:.61rem;font-weight:400;text-transform:none;">(admin managed)</span></label>
                                <div class="readonly-field">
                                    @if($staff->shift_schedule)
                                        <span style="width:7px;height:7px;border-radius:50%;flex-shrink:0;display:inline-block;background:{{ $shiftDot }};"></span>
                                        <span style="font-size:.83rem;font-weight:600;color:var(--ink-muted);">{{ $staff->shift_schedule }}</span>
                                    @else
                                        <span style="color:var(--ink-muted);font-size:.83rem;">—</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="resetInfoForm()">Reset</button>
                        <button type="submit" class="btn-submit">
                            <img src="{{ asset('icons/export.png') }}"
                                style="width:12px;height:12px;object-fit:contain;filter:brightness(0) invert(1);" alt="">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="section-card fade-up d4">
            <div class="section-head">
                <div class="section-title-icon">
                    <img src="{{ asset('icons/nav-settings.png') }}" alt="">
                </div>
                <div>
                    <div class="section-title">Change Password</div>
                    <div class="section-sub">Keep your account secure</div>
                </div>
            </div>
            <div class="section-body">
                <form method="POST" action="{{ route('profile.password') }}" id="pw-form">
                    @csrf
                    @method('PUT')
                    <div class="form-fields">
                        <div class="form-grid single">
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
                                <div class="pw-strength-wrap">
                                    <div class="pw-strength-bar">
                                        <div class="pw-strength-fill" id="strength-fill"></div>
                                    </div>
                                    <div class="pw-strength-label" id="strength-label"></div>
                                </div>
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
                        <button type="button" class="btn-cancel"
                            onclick="document.getElementById('pw-form').reset(); resetStrength();">Reset</button>
                        <button type="submit" class="btn-submit">
                            <img src="{{ asset('icons/nav-settings.png') }}"
                                style="width:12px;height:12px;object-fit:contain;filter:brightness(0) invert(1);" alt="">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- end forms-row --}}

    {{-- ══ DANGER ZONE — full width ══ --}}
    <div class="danger-card fade-up d5">
        <div class="danger-head">
            <div class="danger-title-icon">
                <img src="{{ asset('icons/delete.png') }}" alt="">
            </div>
            <div>
                <div class="danger-title">Danger Zone</div>
                <div class="danger-sub">Irreversible account actions</div>
            </div>
        </div>
        <div class="danger-body">
            <div class="danger-text">
                <strong>Deactivate Account</strong>
                <span>Your account will be deactivated and you will be logged out immediately. Admin assistance is required to reactivate.</span>
            </div>
            <button class="btn-danger" onclick="openModal('deactivate-modal')">Deactivate</button>
        </div>
    </div>

</div>{{-- end page-body --}}
@endsection

@section('modals')
<div class="modal-overlay" id="deactivate-modal">
    <div class="modal" style="max-width:380px;">
        <div class="modal-header">
            <div class="modal-title">Deactivate Account</div>
            <button class="modal-close" onclick="closeModal('deactivate-modal')">✕</button>
        </div>
        <p style="font-size:.86rem;color:var(--ink-muted);line-height:1.65;margin-bottom:.5rem;">
            Are you sure you want to deactivate your account?
            <strong style="color:var(--ink);">This action cannot be undone</strong> without admin assistance.
        </p>
        <form method="POST" action="{{ route('profile.deactivate') }}">
            @csrf
            @method('PUT')
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('deactivate-modal')">Cancel</button>
                <button type="submit" class="btn-submit"
                    style="background:var(--red);box-shadow:0 3px 10px rgba(223,4,4,.22);">
                    Yes, Deactivate
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateDisplayName() {
        const fn = document.querySelector('[name="first_name"]').value;
        const ln = document.querySelector('[name="last_name"]').value;
        document.getElementById('sidebar-display-name').textContent = fn + ' ' + ln;
    }
    function resetInfoForm() {
        document.getElementById('info-form').reset();
        updateDisplayName();
    }
    function togglePw(inputId, btn) {
        const inp = document.getElementById(inputId);
        inp.type = inp.type === 'text' ? 'password' : 'text';
        btn.querySelector('img').style.opacity = inp.type === 'text' ? '1' : '.4';
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
            {w:'20%', color:'#DF0404', text:'Weak'},
            {w:'45%', color:'#f59e0b', text:'Fair'},
            {w:'70%', color:'#29BD9B', text:'Good'},
            {w:'100%',color:'#16a34a', text:'Strong'},
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