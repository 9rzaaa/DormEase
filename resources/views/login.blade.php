<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DormEase: Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<style>

    body {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    .left {
        flex: 1;
        background: linear-gradient(160deg, #CA5D86 0%, #a8446c 40%, #7b2d50 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    .left::before {
        content: '';
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        background: transparent;
        top: -120px;
        left: -120px;
        pointer-events: none;
    }

    .left::after {
        content: '';
        position: absolute;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: transparent;
        bottom: -90px;
        right: -90px;
        pointer-events: none;
    }

    .ring {
        position: absolute;
        border-radius: 50%;
        top: 50%;
        left: 55%;
        pointer-events: none;
        transform: translate(-50%, -50%);
        background: transparent;
    }

    .ring-1 {
        width: 220px;
        height: 220px;
        border: 1.5px dashed rgba(255, 255, 255, .8);
        animation: spinSlow 22s linear infinite;
    }

    .ring-2 {
        width: 360px;
        height: 360px;
        border: 1px dashed rgba(255, 255, 255, .6);
        animation: spinSlow 38s linear infinite reverse;
    }

    .ring-3 {
        width: 500px;
        height: 500px;
        border: 1px dashed rgba(255, 255, 255, .4);
        animation: spinSlow 55s linear infinite;
    }

    @keyframes spinSlow {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .dot-grid {
        position: absolute;
        bottom: 130px;
        left: 3rem;
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        opacity: .16;
        pointer-events: none;
    }

    .dot-grid span {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #fff;
        display: block;
    }

    .student-wrap {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 600px;
        z-index: 1;
        pointer-events: none;
        animation: float 5s ease-in-out infinite;
        opacity: 0.85;
    }

    .student-wrap::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 120px;
        background: linear-gradient(to top, #7b2d50 0%, transparent 100%);
        pointer-events: none;
    }

    .student-wrap img {
        width: 100%;
        display: block;
        filter: drop-shadow(-8px 0 32px rgba(0, 0, 0, .25));
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-14px); }
    }

    .left-logo {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .logo-mark {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, .2);
        border: 2px solid rgba(255, 255, 255, .4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        overflow: hidden;
        transition: background var(--transition);
    }

    .logo-mark:hover {
        background: rgba(255, 255, 255, .32);
    }

    .logo-mark img {
        width: 26px;
        height: 26px;
        object-fit: contain;
    }

    .logo-text {
        font-family: var(--ff-display);
        font-size: 1.5rem;
        color: #fff;
        letter-spacing: -.01em;
    }

    .logo-text span {
        font-style: italic;
        opacity: .85;
    }

    .left-body {
        position: relative;
        z-index: 2;
    }

    .left-body h1 {
        font-family: var(--ff-display);
        font-size: clamp(2.2rem, 3.4vw, 3.3rem);
        color: #fff;
        line-height: 1.12;
        letter-spacing: -.02em;
        margin-bottom: 1.1rem;
    }

    .left-body h1 em {
        font-style: italic;
        color: var(--pink-light);
    }

    .left-body p {
        font-size: .94rem;
        color: rgba(255, 255, 255, .7);
        line-height: 1.75;
        max-width: 310px;
    }

    .pills {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        margin-top: 1.8rem;
    }

    .pill {
        background: rgba(255, 255, 255, .13);
        border: 1px solid rgba(255, 255, 255, .22);
        color: #fff;
        font-size: .76rem;
        font-weight: 500;
        padding: .32rem .8rem;
        border-radius: var(--radius-pill);
        display: flex;
        align-items: center;
        gap: .4rem;
        backdrop-filter: blur(4px);
        transition: background var(--transition), border-color var(--transition);
        cursor: default;
    }

    .pill:hover {
        background: rgba(255, 255, 255, .22);
        border-color: rgba(255, 255, 255, .4);
    }

    .pill img {
        width: 13px;
        height: 13px;
        filter: brightness(0) invert(1);
    }

    .left-footer {
        position: relative;
        z-index: 2;
        font-size: .75rem;
        color: rgba(255, 255, 255, .38);
    }

    .right {
        width: 500px;
        flex-shrink: 0;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 3.5rem;
        position: relative;
        overflow-y: auto;
    }

    .right::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(ellipse at top right, #ffe4ef 0%, transparent 70%);
        pointer-events: none;
    }

    .form-wrap {
        width: 100%;
        max-width: 380px;
        position: relative;
        z-index: 1;
    }

    .form-header {
        margin-bottom: 1.8rem;
    }

    .eyebrow {
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--pink);
        margin-bottom: .55rem;
        display: flex;
        align-items: center;
        gap: .45rem;
    }

    .eyebrow::before {
        content: '';
        display: block;
        width: 20px;
        height: 2px;
        background: var(--pink);
        border-radius: 2px;
    }

    .form-header h2 {
        font-family: var(--ff-display);
        font-size: 2.1rem;
        font-weight: 400;
        color: var(--ink);
        line-height: 1.15;
        letter-spacing: -.02em;
    }

    .form-header h2 em {
        font-style: italic;
        color: var(--pink);
    }

    .form-header p {
        font-size: .86rem;
        color: var(--ink-muted);
        margin-top: .55rem;
        line-height: 1.6;
    }

    .role-label {
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: .5rem;
        display: block;
    }

    .role-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem;
        margin-bottom: 1.6rem;
    }

    .role-btn {
        border: 1.5px solid var(--gray-light);
        border-radius: 14px;
        padding: .85rem 1rem;
        background: var(--white);
        text-align: left;
        display: flex;
        align-items: center;
        gap: .65rem;
        transition: border-color var(--transition), background var(--transition),
                    box-shadow var(--transition), transform .15s;
        position: relative;
        overflow: hidden;
    }

    .role-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(202, 93, 134, .06) 0%, transparent 60%);
        opacity: 0;
        transition: opacity var(--transition);
    }

    .role-btn:hover::before { opacity: 1; }

    .role-btn:hover {
        border-color: var(--pink-light);
        transform: translateY(-1px);
    }

    .role-btn:active {
        transform: translateY(0);
    }

    .role-btn.active {
        border-color: var(--pink);
        background: var(--pink-tint);
        box-shadow: 0 0 0 3px rgba(202, 93, 134, .1);
    }

    .role-icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        border-radius: 10px;
        background: var(--gray-light);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background var(--transition);
    }

    .role-icon img {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    .role-btn.active .role-icon {
        background: var(--pink-light);
    }

    .role-name {
        font-size: .84rem;
        font-weight: 600;
        color: var(--ink);
    }

    .role-desc {
        font-size: .71rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .role-btn.active .role-name {
        color: var(--pink);
    }

    .field {
        margin-bottom: 1.15rem;
    }

    .field label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: .42rem;
    }

    .input-wrap {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        pointer-events: none;
        opacity: .4;
    }

    .input-wrap::after {
        content: '';
        position: absolute;
        bottom: 1px;
        left: 50%;
        right: 50%;
        height: 2px;
        background: var(--pink);
        border-radius: 0 0 var(--radius-md) var(--radius-md);
        transition: left .25s ease, right .25s ease;
        pointer-events: none;
    }

    .input-wrap:focus-within::after {
        left: 1px;
        right: 1px;
    }

    .toggle-pw {
        position: absolute;
        right: .9rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        opacity: .38;
        transition: opacity var(--transition);
    }

    .toggle-pw:hover {
        opacity: .85;
    }

    .toggle-pw span {
        font-size: 1rem;
        line-height: 1;
    }

    .field-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .82rem;
        color: var(--ink-muted);
        cursor: pointer;
    }

    .remember input[type="checkbox"] {
        accent-color: var(--pink);
        width: 15px;
        height: 15px;
    }

    .forgot {
        font-size: .82rem;
        color: var(--pink);
        font-weight: 600;
        transition: opacity var(--transition);
    }

    .forgot:hover {
        opacity: .7;
    }

    .btn-login {
        margin-top: .2rem;
        gap: .5rem;
    }

    .divider {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 1.3rem 0;
        font-size: .74rem;
        color: var(--gray);
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--gray-light);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-wrap > * {
        opacity: 0;
        animation: slideUp .55s ease forwards;
    }

    .form-wrap > *:nth-child(1) { animation-delay: .06s; }
    .form-wrap > *:nth-child(2) { animation-delay: .13s; }
    .form-wrap > *:nth-child(3) { animation-delay: .19s; }
    .form-wrap > *:nth-child(4) { animation-delay: .26s; }
    .form-wrap > *:nth-child(5) { animation-delay: .33s; }
    .form-wrap > *:nth-child(6) { animation-delay: .40s; }
    .form-wrap > *:nth-child(7) { animation-delay: .47s; }

    @keyframes leftSlide {
        from { opacity: 0; transform: translateX(-28px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .left-logo   { animation: leftSlide .6s ease .10s both; }
    .left-body   { animation: leftSlide .6s ease .24s both; }
    .left-footer { animation: leftSlide .6s ease .38s both; }

    @media (max-width: 820px) {
        body {
            flex-direction: column;
            overflow: auto;
        }

        .left {
            min-height: 240px;
            padding: 2rem;
        }

        .left-body h1 {
            font-size: 2rem;
        }

        .right {
            width: 100%;
            padding: 2.5rem 1.5rem;
        }

        .ring,
        .dot-grid,
        .student-wrap {
            display: none;
        }
    }

</style>

<div class="left">

    <div class="ring ring-1"></div>
    <div class="ring ring-2"></div>
    <div class="ring ring-3"></div>

    <div class="dot-grid">
        @for ($i = 0; $i < 30; $i++)
            <span></span>
        @endfor
    </div>

    <div class="student-wrap">
        <img src="{{ asset('images/girl.png') }}" alt="Student">
    </div>

    <div class="left-logo">
        <div class="logo-mark">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </div>
        <div class="logo-text">Dorm<span>Ease</span></div>
    </div>

    <div class="left-body">
        <h1>Manage with<br>ease &amp;<br><em>confidence.</em></h1>
        <p>The DormEase portal gives you full control over rooms, tenants, payments, and maintenance all in one place.</p>

        <div class="pills">
            <span class="pill"><img src="{{ asset('icons/bed.png') }}" alt="">Room Management</span>
            <span class="pill"><img src="{{ asset('icons/tenants.png') }}" alt="">Tenant Records</span>
            <span class="pill"><img src="{{ asset('icons/billing.png') }}" alt="">Billing &amp; Payments</span>
            <span class="pill"><img src="{{ asset('icons/announce.png') }}" alt="">Announcements</span>
            <span class="pill"><img src="{{ asset('icons/maintenance.png') }}" alt="">Maintenance</span>
        </div>
    </div>

    <div class="left-footer">&copy; {{ date('Y') }} DormEase. All rights reserved.</div>

</div>

<div class="right">

    <div class="form-wrap">

        <div class="form-header">
            <div class="eyebrow">Admin Portal</div>
            <h2>Welcome to<br><em>DormEase</em></h2>
            <p>Select your role and sign in with your credentials to continue.</p>
        </div>

        <span class="role-label">Sign in as</span>

        <div class="role-row">
            <button type="button" class="role-btn active" id="role-admin" onclick="setRole('admin')">
                <div class="role-icon">
                    <img src="{{ asset('icons/admin.png') }}" alt="Admin">
                </div>
                <div>
                    <div class="role-name">Admin</div>
                    <div class="role-desc">Full access</div>
                </div>
            </button>

            <button type="button" class="role-btn" id="role-frontdesk" onclick="setRole('frontdesk')">
                <div class="role-icon">
                    <img src="{{ asset('icons/staff.png') }}" alt="Front Desk">
                </div>
                <div>
                    <div class="role-name">Front Desk</div>
                    <div class="role-desc">Staff access</div>
                </div>
            </button>
        </div>

        <form method="POST" action="/login">
            @csrf

            <input type="hidden" name="role" id="role-input" value="admin">

            @if ($errors->any())
                <div class="de-alert-error">
                    <img src="{{ asset('icons/warning.png') }}" alt="Error">
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <img class="input-icon" src="{{ asset('icons/email.png') }}" alt="">
                    <input
                        class="de-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <img class="input-icon" src="{{ asset('icons/lock.png') }}" alt="">
                    <input
                        class="de-input"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        style="padding-right: 2.8rem;"
                        required
                    >
                    <button
                        class="toggle-pw"
                        type="button"
                        onclick="togglePw()"
                        id="pw-toggle"
                        aria-label="Toggle password visibility"
                    >
                        <img 
                        id="pw-eye-icon"
                        src="{{ asset('icons/eyeon.png') }}"
                        alt="Toggle Password"
                        style="width:18px; height:18px;"
                    >
                    </button>
                </div>
            </div>

            <div class="field-row">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                <a href="#" class="forgot">Forgot password?</a>
            </div>

            <button class="de-btn-primary btn-login" type="submit">
                <span>→</span>
                Sign In
            </button>

        </form>

        <div class="divider">or</div>

        <div class="de-status-strip">
            <div class="de-status-dot"></div>
            <span>All systems operational &nbsp;·&nbsp; Secure connection</span>
        </div>

    </div>

</div>


<script>

    function setRole(role) {
        ['admin', 'frontdesk'].forEach(r => {
            document.getElementById('role-' + r).classList.toggle('active', r === role);
        });
        document.getElementById('role-input').value = role;
        document.querySelector('.eyebrow').textContent = role === 'admin' ? 'Admin Portal' : 'Staff Portal';
    }

    function togglePw() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('pw-eye-icon');
        const show  = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.src = show
            ? "{{ asset('icons/eye-off.png') }}"
            : "{{ asset('icons/eye.png') }}";
    }

</script>

</body>
</html>