@extends('layout')

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
        height: 110px;
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
        margin-top: -42px;
        position: relative;
        cursor: pointer;
        z-index: 1;
    }

    .hero-avatar {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e8175d, #ff6ba8);
        border: 4px solid var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
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
    .hero-avatar-wrap:hover .hero-avatar    { box-shadow: 0 6px 24px rgba(232,23,93,.45); }

    .hero-info {
        flex: 1;
        padding-bottom: .25rem;
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

    .pw-requirements {
        margin-top: .6rem;
        display: flex;
        flex-direction: column;
        gap: .25rem;
    }

    .pw-req {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .69rem;
        color: var(--ink-muted);
        font-weight: 500;
        transition: color .25s;
    }

    .pw-req.met { color: #16a34a; }

    .pw-req-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--pink-100);
        flex-shrink: 0;
        transition: background .25s;
    }

    .pw-req.met .pw-req-dot { background: #16a34a; }

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
        .hero-avatar-wrap { margin-top: -42px; }
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
        border: 1px solid var(--pink-200); border-radius: 12px;
        background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14);
        color: var(--ink); font-size: .9rem; font-weight: 700;
    }

    .loading-logo-wrap {
        width: 86px; height: 86px;
        border: 3px solid var(--pink-200); border-radius: 50%;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
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

    <div class="page-header-text fade-up d1">
        <h1>My Profile</h1>
        <div class="dorm-sub">Sanctissimo Rosario Ladies Dormitory</div>
    </div>

    @php
        $roleMap = [
            'admin'     => ['bg'=>'#FFE4F0','color'=>'#E8175D','border'=>'#FFB3D0'],
            'secretary' => ['bg'=>'#FFE4F0','color'=>'#E8175D','border'=>'#FFB3D0'],
            'frontdesk' => ['bg'=>'#e8f4ff','color'=>'#1a6fbd','border'=>'#90c4f8'],
            'staff'     => ['bg'=>'#f0fdf8','color'=>'#166534','border'=>'#86efac'],
        ];
        $rc = $roleMap[strtolower($staff->role ?? '')] ?? ['bg'=>'#f0f0f0','color'=>'#555','border'=>'#ccc'];
    @endphp

    <div class="hero-card fade-up d2">

        <div class="hero-banner"></div>

        <div class="hero-body">
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatar-form">
                @csrf
                @method('PUT')
                <input type="file" name="avatar" id="avatar-input" accept="image/jpeg,image/png" style="display:none;">
                <div class="hero-avatar-wrap" onclick="openAvatarModal()">
                    <div class="hero-avatar">
                        @if($staff->profile_picture)
                            <img src="{{ $staff->profile_picture }}" class="avatar-photo" id="avatar-preview">
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
                        {{ ucfirst($staff->role ?? '—') }}
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
                <form method="POST" action="{{ route('profile.update') }}" id="info-form" data-loading-message="Saving changes...">
                    @csrf
                    @method('PUT')
                    <div class="form-fields">
                        <div class="field-grid">
                            <div class="form-field">
                                <label>First Name</label>
                                <input type="text" name="first_name" id="info-fn"
                                    value="{{ old('first_name', $staff->first_name) }}"
                                    required oninput="updateDisplayName(); clearFieldError(this)">
                            </div>
                            <div class="form-field">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="info-ln"
                                    value="{{ old('last_name', $staff->last_name) }}"
                                    required oninput="updateDisplayName(); clearFieldError(this)">
                            </div>
                            <div class="form-field full">
                                <label>Email Address</label>
                                <input type="email" name="email" id="info-em"
                                    value="{{ old('email', $staff->email) }}" required
                                    oninput="clearFieldError(this)">
                            </div>
                            <div class="form-field full">
                                <label>Contact Number</label>
                                <input type="text" name="contact_number" id="info-ct"
                                    value="{{ old('contact_number', $staff->contact_number) }}"
                                    placeholder="e.g. 0912-345-6789"
                                    maxlength="13"
                                    oninput="formatContactNumber(this); clearFieldError(this)">
                                @error('contact_number')
                                    <span style="font-size:.7rem; color:#e8175d; margin-top:.2rem; display:block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-field full">
                                <label>Role</label>
                                <div class="readonly-val">
                                    <span style="padding:.14rem .58rem;border-radius:5px;font-size:.72rem;font-weight:700;
                                        background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border:1.5px solid {{ $rc['border'] }};">
                                        {{ ucfirst($staff->role ?? '—') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-ghost" onclick="document.getElementById('info-form').reset(); setTimeout(updateDisplayName, 0);">Reset</button>
                        <button type="submit" class="btn-save" onclick="if(!validateInfoForm()){event.preventDefault();}">
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
                <form method="POST" action="{{ route('profile.password') }}" id="pw-form" data-loading-message="Updating password...">
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
                                <div class="pw-requirements" id="pw-requirements">
                                    <div class="pw-req" id="preq-length"><span class="pw-req-dot"></span>At least 8 characters</div>
                                    <div class="pw-req" id="preq-upper"><span class="pw-req-dot"></span>One uppercase letter</div>
                                    <div class="pw-req" id="preq-number"><span class="pw-req-dot"></span>One number</div>
                                    <div class="pw-req" id="preq-special"><span class="pw-req-dot"></span>One special character</div>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>Confirm New Password</label>
                                <div class="input-wrap">
                                    <input type="password" name="password_confirmation" id="conf-pw"
                                        placeholder="Repeat new password" required autocomplete="new-password"
                                        oninput="checkConfirm()">
                                    <button type="button" class="toggle-pw" onclick="togglePw('conf-pw', this)">
                                        <img src="{{ asset('icons/eye.png') }}" alt="Show">
                                    </button>
                                </div>
                                <div id="conf-pw-match" style="font-size:.69rem;margin-top:.2rem;display:none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-ghost"
                            onclick="document.getElementById('pw-form').reset(); resetStrength(); document.getElementById('conf-pw-match').style.display='none'; document.getElementById('conf-pw').style.borderColor=''; document.getElementById('new-pw').style.borderColor='';">Reset</button>
                        <button type="submit" class="btn-save" onclick="if(!validatePasswordForm()){event.preventDefault();}">
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
<div class="modal-overlay" id="avatar-modal" style="position:fixed;inset:0;background:rgba(26,26,46,.45);backdrop-filter:blur(4px);z-index:400;display:none;align-items:center;justify-content:center;">
    <div style="background:var(--white);border-radius:20px;padding:2rem;width:90%;max-width:420px;box-shadow:0 24px 64px rgba(232,23,93,.18);animation:fdFadeUp .3s ease;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.3rem;">
            <div>
                <div style="font-size:1.05rem;font-weight:800;color:var(--ink);letter-spacing:-.01em;">Update Profile Photo</div>
                <div style="font-size:.73rem;color:var(--ink-muted);margin-top:.18rem;">Choose a photo to represent you</div>
            </div>
            <button onclick="closeAvatarModal()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--ink-muted);line-height:1;transition:color .2s;" onmouseenter="this.style.color='#e8175d'" onmouseleave="this.style.color=''">&#x2715;</button>
        </div>

        <div id="avatar-drop-zone" style="border:2px dashed var(--pink-200);border-radius:14px;padding:2rem 1rem;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;background:var(--pink-50);margin-bottom:1rem;" onclick="document.getElementById('avatar-input').click()" ondragover="event.preventDefault();this.style.borderColor='var(--bright-pink)';this.style.background='#fff0f6';" ondragleave="this.style.borderColor='';this.style.background='var(--pink-50)';" ondrop="handleAvatarDrop(event)">
            <div id="avatar-modal-preview-wrap" style="display:none;margin-bottom:.85rem;">
                <img id="avatar-modal-preview" src="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--bright-pink);box-shadow:0 4px 14px rgba(232,23,93,.22);">
            </div>
            <div id="avatar-drop-icon" style="margin-bottom:.65rem;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#ffb3d0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            </div>
            <div id="avatar-drop-label" style="font-size:.82rem;font-weight:700;color:var(--ink);margin-bottom:.3rem;">Click to upload or drag and drop</div>
            <div style="font-size:.7rem;color:var(--ink-muted);">JPG, PNG</div>
        </div>

        <div style="background:var(--pink-50);border:1.5px solid var(--pink-200);border-radius:11px;padding:.8rem 1rem;margin-bottom:1.2rem;">
            <div style="font-size:.7rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.45rem;">Requirements</div>
            <div style="display:flex;flex-direction:column;gap:.28rem;">
                <div style="display:flex;align-items:center;gap:.5rem;font-size:.73rem;color:var(--ink-muted);font-weight:500;">
                    <span style="width:5px;height:5px;border-radius:50%;background:var(--bright-pink);flex-shrink:0;display:inline-block;"></span>
                        Accepted formats: JPG, PNG
                    </div>
                <div style="display:flex;align-items:center;gap:.5rem;font-size:.73rem;color:var(--ink-muted);font-weight:500;">
                    <span style="width:5px;height:5px;border-radius:50%;background:var(--bright-pink);flex-shrink:0;display:inline-block;"></span>
                    Maximum file size: <strong style="color:var(--ink);">2 MB</strong>
                </div>
                <div style="display:flex;align-items:center;gap:.5rem;font-size:.73rem;color:var(--ink-muted);font-weight:500;">
                    <span style="width:5px;height:5px;border-radius:50%;background:var(--bright-pink);flex-shrink:0;display:inline-block;"></span>
                    Recommended size: <strong style="color:var(--ink);">at least 200 x 200 px</strong>
                </div>
                <div style="display:flex;align-items:center;gap:.5rem;font-size:.73rem;color:var(--ink-muted);font-weight:500;">
                    <span style="width:5px;height:5px;border-radius:50%;background:var(--bright-pink);flex-shrink:0;display:inline-block;"></span>
                    Square photos look best
                </div>
            </div>
        </div>

        <div id="avatar-file-error" style="display:none;font-size:.75rem;color:#e8175d;background:#fff0f3;border:1px solid #fbbdd1;border-radius:8px;padding:.5rem .75rem;margin-bottom:.9rem;"></div>

        <div style="display:flex;gap:.6rem;justify-content:flex-end;">
            <button type="button" onclick="closeAvatarModal()" style="padding:.48rem 1rem;border-radius:9px;border:1.5px solid var(--pink-200);background:none;font-family:var(--ff-body);font-size:.82rem;font-weight:600;color:var(--ink-muted);cursor:pointer;transition:border-color .2s,color .2s;" onmouseenter="this.style.borderColor='var(--bright-pink)';this.style.color='var(--bright-pink)'" onmouseleave="this.style.borderColor='';this.style.color=''">Cancel</button>
            <button type="button" id="avatar-upload-btn" onclick="submitAvatar()" disabled style="padding:.48rem 1.2rem;border-radius:9px;border:none;background:linear-gradient(135deg,var(--bright-pink),var(--hot-pink));color:var(--white);font-family:var(--ff-body);font-size:.82rem;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(255,45,120,.25);transition:opacity .2s;opacity:.45;">Upload Photo</button>
        </div>
    </div>
</div>
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
            form.addEventListener('submit', function (e) {
                if (e.defaultPrevented) return;
                setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
            });
        });
    });

    function openAvatarModal() {
        document.getElementById('avatar-modal').style.display = 'flex';
        document.getElementById('avatar-file-error').style.display = 'none';
        document.getElementById('avatar-upload-btn').disabled = true;
        document.getElementById('avatar-upload-btn').style.opacity = '.45';
        document.getElementById('avatar-modal-preview-wrap').style.display = 'none';
        document.getElementById('avatar-drop-icon').style.display = 'block';
        document.getElementById('avatar-drop-label').textContent = 'Click to upload or drag and drop';
        document.getElementById('avatar-input').value = '';
    }

    function closeAvatarModal() {
        document.getElementById('avatar-modal').style.display = 'none';
        document.getElementById('avatar-input').value = '';
    }

    document.getElementById('avatar-modal').addEventListener('click', function(e) {
        if (e.target === this) closeAvatarModal();
    });

    function handleAvatarFile(file) {
        var errEl = document.getElementById('avatar-file-error');
        var btn   = document.getElementById('avatar-upload-btn');
        errEl.style.display = 'none';

        var allowed = ['image/jpeg','image/png','image/jpg'];
        if (!allowed.includes(file.type)) {
            errEl.textContent = 'Only JPG and PNG files are allowed.';
            errEl.style.display = 'block';
            btn.disabled = true;
            btn.style.opacity = '.45';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            errEl.textContent = 'File size must not exceed 2MB.';
            errEl.style.display = 'block';
            btn.disabled = true;
            btn.style.opacity = '.45';
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            var prev = document.getElementById('avatar-modal-preview');
            prev.src = e.target.result;
            document.getElementById('avatar-modal-preview-wrap').style.display = 'block';
            document.getElementById('avatar-drop-icon').style.display = 'none';
            document.getElementById('avatar-drop-label').textContent = file.name;
        };
        reader.readAsDataURL(file);

        btn.disabled = false;
        btn.style.opacity = '1';
    }

    function handleAvatarDrop(event) {
        event.preventDefault();
        var zone = document.getElementById('avatar-drop-zone');
        zone.style.borderColor = '';
        zone.style.background  = 'var(--pink-50)';
        var file = event.dataTransfer.files[0];
        if (!file) return;
        var dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('avatar-input').files = dt.files;
        handleAvatarFile(file);
    }

    document.getElementById('avatar-input').addEventListener('change', function() {
        if (!this.files[0]) return;
        handleAvatarFile(this.files[0]);
    });

    function submitAvatar() {
        var preview  = document.getElementById('avatar-preview');
        var initials = document.getElementById('avatar-initials');
        var modalPrev = document.getElementById('avatar-modal-preview');
        preview.src = modalPrev.src;
        preview.style.display = 'block';
        if (initials) initials.style.display = 'none';
        closeAvatarModal();
        showActionLoading('Uploading photo...');
        document.getElementById('avatar-form').submit();
    }

    function updateDisplayName() {
        const form = document.getElementById('info-form');
        const fn = form.querySelector('[name="first_name"]').value;
        const ln = form.querySelector('[name="last_name"]').value;
        document.getElementById('hero-display-name').textContent = (fn + ' ' + ln).trim() || 'Your Name';
    }

    function formatContactNumber(input) {
        var digits = input.value.replace(/\D/g, '').slice(0, 11);
        var formatted = digits;
        if (digits.length > 4 && digits.length <= 7) {
            formatted = digits.slice(0, 4) + '-' + digits.slice(4);
        } else if (digits.length > 7) {
            formatted = digits.slice(0, 4) + '-' + digits.slice(4, 7) + '-' + digits.slice(7);
        }
        input.value = formatted;
    }

    function showFieldError(input, msg) {
        input.style.borderColor = '#e8175d';
        var errId = input.id + '-err';
        var existing = document.getElementById(errId);
        if (!existing) {
            var el = document.createElement('div');
            el.id = errId;
            el.style.cssText = 'font-size:.69rem;color:#e8175d;margin-top:.2rem;';
            input.parentNode.insertBefore(el, input.nextSibling);
        }
        document.getElementById(errId).textContent = msg;
    }

    function clearFieldError(input) {
        input.style.borderColor = '';
        var el = document.getElementById(input.id + '-err');
        if (el) el.textContent = '';
    }

    function validateInfoForm() {
        var ok = true;
        var form = document.getElementById('info-form');
        var fn = form.querySelector('[name="first_name"]');
        var ln = form.querySelector('[name="last_name"]');
        var em = form.querySelector('[name="email"]');
        var ct = form.querySelector('[name="contact_number"]');

        if (!fn.value.trim()) { showFieldError(fn, 'First name is required.'); ok = false; } else clearFieldError(fn);
        if (!ln.value.trim()) { showFieldError(ln, 'Last name is required.');  ok = false; } else clearFieldError(ln);

        var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value.trim());
        if (!em.value.trim()) { showFieldError(em, 'Email is required.'); ok = false; }
        else if (!emailOk)    { showFieldError(em, 'Enter a valid email address.'); ok = false; }
        else clearFieldError(em);

        var digits = ct.value.replace(/\D/g, '');
        if (digits.length > 0 && digits.length < 11) {
            showFieldError(ct, 'Enter a valid 11-digit phone number.');
            ok = false;
        } else if (digits.length > 0 && !digits.startsWith('09')) {
            showFieldError(ct, 'Contact number must start with 09.');
            ok = false;
        } else {
            clearFieldError(ct);
        }
        return ok;
    }

    function validatePasswordForm() {
        var ok = true;
        var cur  = document.getElementById('cur-pw');
        var npw  = document.getElementById('new-pw');
        var conf = document.getElementById('conf-pw');

        if (!cur.value) { showFieldError(cur, 'Current password is required.'); ok = false; } else clearFieldError(cur);
        if (!npw.value) { showFieldError(npw, 'New password is required.'); ok = false; }
        else if (npw.value.length < 8) { showFieldError(npw, 'Password must be at least 8 characters.'); ok = false; }
        else clearFieldError(npw);

        if (conf.value && npw.value && conf.value !== npw.value) {
            showFieldError(conf, 'Passwords do not match.');
            ok = false;
        } else if (!conf.value) {
            showFieldError(conf, 'Please confirm your new password.');
            ok = false;
        } else {
            clearFieldError(conf);
        }
        return ok;
    }

    function togglePw(inputId, btn) {
        const inp = document.getElementById(inputId);
        inp.type = inp.type === 'text' ? 'password' : 'text';
        btn.querySelector('img').style.opacity = inp.type === 'text' ? '.8' : '.35';
    }

    function checkStrength(val) {
        const fill  = document.getElementById('strength-fill');
        const label = document.getElementById('strength-label');
        if (!val) {
            fill.style.width  = '0%';
            label.textContent = '';
            ['preq-length','preq-upper','preq-number','preq-special'].forEach(id => document.getElementById(id).classList.remove('met'));
            return;
        }
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

        const toggle = (id, met) => document.getElementById(id).classList.toggle('met', met);
        toggle('preq-length',  val.length >= 8);
        toggle('preq-upper',   /[A-Z]/.test(val));
        toggle('preq-number',  /[0-9]/.test(val));
        toggle('preq-special', /[^A-Za-z0-9]/.test(val));
    }

    function checkConfirm() {
        var npw  = document.getElementById('new-pw').value;
        var conf = document.getElementById('conf-pw').value;
        var el   = document.getElementById('conf-pw-match');
        if (!conf) { el.style.display = 'none'; return; }
        el.style.display = 'block';
        if (conf === npw) {
            el.textContent  = 'Passwords match.';
            el.style.color  = '#16a34a';
            document.getElementById('conf-pw').style.borderColor = '#16a34a';
        } else {
            el.textContent  = 'Passwords do not match.';
            el.style.color  = '#e8175d';
            document.getElementById('conf-pw').style.borderColor = '#e8175d';
        }
    }

    function resetStrength() {
        document.getElementById('strength-fill').style.width = '0%';
        document.getElementById('strength-label').textContent = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var ct = document.getElementById('info-ct');
        if (ct && ct.value) formatContactNumber(ct);
    });

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
