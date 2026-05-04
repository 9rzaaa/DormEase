<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DormEase — Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --pink:      #CA5D86;
      --pink-light:#FFB0CE;
      --pink-soft: #FF7E86;
      --gray:      #B5B7C0;
      --gray-light:#E5ECF6;
      --mint:      #A6E7D8;
      --green:     #29BD9B;
      --peach:     #FFD7C7;
      --salmon:    #EB9C7D;
      --blush:     #FFC5C5;
      --red:       #DF0404;
      --white:     #ffffff;
      --ink:       #2d1f28;
      --ink-muted: #7a5f6e;
      --ff-display:'DM Serif Display', Georgia, serif;
      --ff-body:   'DM Sans', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }
    body {
      font-family: var(--ff-body);
      background: #fdf5f8;
      color: var(--ink);
      display: flex;
      min-height: 100vh;
      overflow: hidden;
    }

    /* ── LEFT PANEL ── */
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
      width: 400px; height: 400px;
      border-radius: 50%;
      background: rgba(255,176,206,.18);
      top: -100px; left: -100px;
      pointer-events: none;
    }
    .left::after {
      content: '';
      position: absolute;
      width: 320px; height: 320px;
      border-radius: 50%;
      background: rgba(255,126,134,.14);
      bottom: -80px; right: -80px;
      pointer-events: none;
    }
    .blob-mid {
      position: absolute;
      width: 200px; height: 200px;
      border-radius: 50%;
      border: 2px dashed rgba(255,255,255,.2);
      top: 50%; left: 55%; transform: translate(-50%,-50%);
      animation: spinSlow 20s linear infinite;
      pointer-events: none;
    }
    @keyframes spinSlow { to { transform: translate(-50%,-50%) rotate(360deg); } }
    .dot-grid {
      position: absolute;
      bottom: 120px; left: 3rem;
      display: grid;
      grid-template-columns: repeat(6,1fr);
      gap: 10px;
      opacity: .2;
      pointer-events: none;
    }
    .dot-grid span { width: 4px; height: 4px; border-radius: 50%; background: var(--white); display: block; }
    .left-logo {
      position: relative; z-index: 1;
      display: flex; align-items: center; gap: .75rem;
    }
    .logo-mark {
      width: 42px; height: 42px;
      background: rgba(255,255,255,.2);
      border: 2px solid rgba(255,255,255,.4);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
      backdrop-filter: blur(6px);
    }
    .logo-text { font-family: var(--ff-display); font-size: 1.5rem; color: var(--white); letter-spacing: -.01em; }
    .logo-text span { font-style: italic; opacity: .85; }
    .left-body { position: relative; z-index: 1; }
    .left-body h1 {
      font-family: var(--ff-display);
      font-size: clamp(2.4rem, 4vw, 3.6rem);
      color: var(--white); line-height: 1.1;
      letter-spacing: -.02em; margin-bottom: 1.2rem;
    }
    .left-body h1 em { font-style: italic; color: var(--pink-light); }
    .left-body p { font-size: .97rem; color: rgba(255,255,255,.72); line-height: 1.75; max-width: 340px; }
    .left-pills { display: flex; gap: .6rem; flex-wrap: wrap; margin-top: 2rem; }
    .pill {
      background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
      color: var(--white); font-size: .78rem; font-weight: 500;
      padding: .35rem .85rem; border-radius: 100px; backdrop-filter: blur(4px);
    }
    .left-footer { position: relative; z-index: 1; font-size: .78rem; color: rgba(255,255,255,.45); }

    /* ── RIGHT PANEL ── */
    .right {
      width: 500px; flex-shrink: 0;
      background: var(--white);
      display: flex; align-items: center; justify-content: center;
      padding: 3rem 3.5rem;
      position: relative; overflow-y: auto;
    }
    .right::before {
      content: '';
      position: absolute; top: 0; right: 0;
      width: 200px; height: 200px;
      background: radial-gradient(ellipse at top right, #ffe4ef 0%, transparent 70%);
      pointer-events: none;
    }
    .form-wrap { width: 100%; max-width: 380px; position: relative; z-index: 1; }

    /* FORM HEADER */
    .form-header { margin-bottom: 2rem; }
    .form-header .eyebrow {
      font-size: .75rem; font-weight: 600;
      letter-spacing: .1em; text-transform: uppercase;
      color: var(--pink); margin-bottom: .6rem;
      display: flex; align-items: center; gap: .4rem;
    }
    .form-header .eyebrow::before {
      content: ''; display: block;
      width: 20px; height: 2px;
      background: var(--pink); border-radius: 2px;
    }
    .form-header h2 {
      font-family: var(--ff-display);
      font-size: 2.2rem; font-weight: 400;
      color: var(--ink); line-height: 1.15; letter-spacing: -.02em;
    }
    .form-header h2 em { font-style: italic; color: var(--pink); }
    .form-header p { font-size: .88rem; color: var(--ink-muted); margin-top: .6rem; line-height: 1.6; }

    /* ── ROLE SELECTOR ── */
    .role-label { font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .55rem; display: block; }
    .role-row {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: .6rem; margin-bottom: 1.6rem;
    }
    .role-btn {
      border: 1.5px solid var(--gray-light);
      border-radius: 12px; padding: .85rem 1rem;
      cursor: pointer; background: var(--white);
      text-align: left;
      transition: border-color .2s, background .2s, box-shadow .2s;
      display: flex; align-items: center; gap: .65rem;
    }
    .role-btn .role-icon {
      width: 36px; height: 36px; flex-shrink: 0;
      border-radius: 9px; background: var(--gray-light);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.05rem; transition: background .2s;
    }
    .role-btn .role-name { font-size: .84rem; font-weight: 600; color: var(--ink); }
    .role-btn .role-desc { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }
    .role-btn:hover { border-color: var(--pink-light); background: #fff9fb; }
    .role-btn.active {
      border-color: var(--pink);
      background: #fff5f9;
      box-shadow: 0 0 0 3px rgba(202,93,134,.1);
    }
    .role-btn.active .role-icon { background: var(--pink-light); }
    .role-btn.active .role-name { color: var(--pink); }

    /* FIELDS */
    .field { margin-bottom: 1.2rem; }
    .field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .45rem; }
    .input-wrap { position: relative; }
    .input-wrap .icon {
      position: absolute; left: .95rem; top: 50%; transform: translateY(-50%);
      font-size: 1rem; pointer-events: none; opacity: .5;
    }
    .input-wrap input {
      width: 100%;
      padding: .78rem 1rem .78rem 2.6rem;
      border: 1.5px solid var(--gray-light);
      border-radius: 12px;
      font-family: var(--ff-body); font-size: .9rem;
      color: var(--ink); background: #fafafa;
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .input-wrap input:focus {
      border-color: var(--pink); background: var(--white);
      box-shadow: 0 0 0 3px rgba(202,93,134,.12);
    }
    .input-wrap input::placeholder { color: var(--gray); }
    .toggle-pw {
      position: absolute; right: .95rem; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      font-size: .9rem; color: var(--gray); padding: 0; transition: color .2s;
    }
    .toggle-pw:hover { color: var(--pink); }

    .field-row {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 1.2rem;
    }
    .remember { display: flex; align-items: center; gap: .4rem; font-size: .82rem; color: var(--ink-muted); cursor: pointer; }
    .remember input[type="checkbox"] { accent-color: var(--pink); width: 15px; height: 15px; }
    .forgot { font-size: .82rem; color: var(--pink); font-weight: 600; text-decoration: none; transition: opacity .2s; }
    .forgot:hover { opacity: .75; }

    /* SUBMIT */
    .btn-login {
      width: 100%; padding: .88rem;
      background: linear-gradient(135deg, var(--pink) 0%, #a8446c 100%);
      color: var(--white); border: none; border-radius: 12px;
      font-family: var(--ff-body); font-size: .95rem; font-weight: 600;
      cursor: pointer; letter-spacing: .01em;
      box-shadow: 0 4px 20px rgba(202,93,134,.35);
      transition: transform .18s, box-shadow .18s, filter .18s;
      position: relative; overflow: hidden;
    }
    .btn-login::after {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.15) 0%, transparent 60%);
      pointer-events: none;
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 7px 28px rgba(202,93,134,.45); filter: brightness(1.05); }
    .btn-login:active { transform: translateY(0); }

    /* STATUS STRIP */
    .status-strip {
      display: flex; gap: .5rem; align-items: center;
      margin-top: 2rem; padding: .75rem 1rem;
      background: linear-gradient(90deg, #f0fdf8, #e8faf5);
      border: 1px solid var(--mint); border-radius: 10px;
    }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green); flex-shrink: 0; animation: pulse 2s ease-in-out infinite; }
    @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .status-strip span { font-size: .78rem; color: #1d7a63; font-weight: 500; }

    /* ANIMATIONS */
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .form-wrap > * { opacity: 0; animation: slideUp .55s ease forwards; }
    .form-wrap > *:nth-child(1) { animation-delay: .05s; }
    .form-wrap > *:nth-child(2) { animation-delay: .12s; }
    .form-wrap > *:nth-child(3) { animation-delay: .18s; }
    .form-wrap > *:nth-child(4) { animation-delay: .25s; }
    .form-wrap > *:nth-child(5) { animation-delay: .32s; }
    .form-wrap > *:nth-child(6) { animation-delay: .39s; }
    @keyframes leftSlide { from { opacity:0; transform:translateX(-30px); } to { opacity:1; transform:translateX(0); } }
    .left-logo   { animation: leftSlide .6s ease .1s both; }
    .left-body   { animation: leftSlide .6s ease .25s both; }
    .left-footer { animation: leftSlide .6s ease .4s both; }

    /* RESPONSIVE */
    @media (max-width: 800px) {
      body { flex-direction: column; overflow: auto; }
      .left { min-height: 240px; padding: 2rem; }
      .left-body h1 { font-size: 2rem; }
      .right { width: 100%; padding: 2.5rem 1.5rem; }
      .blob-mid, .dot-grid { display: none; }
    }
  </style>
</head>
<body>

  <!-- LEFT -->
  <div class="left">
    <div class="blob-mid"></div>
    <div class="dot-grid">
      @for ($i = 0; $i < 30; $i++)<span></span>@endfor
    </div>
    <div class="left-logo">
      <div class="logo-mark">🏠</div>
      <div class="logo-text">Dorm<span>Ease</span></div>
    </div>
    <div class="left-body">
      <h1>Manage with<br>ease &amp;<br><em>confidence.</em></h1>
      <p>The DormEase portal gives you full control over rooms, tenants, payments, and maintenance — all in one place.</p>
      <div class="left-pills">
        <span class="pill">🛏 Room Management</span>
        <span class="pill">👥 Tenant Records</span>
        <span class="pill">💳 Billing &amp; Payments</span>
        <span class="pill">📋 Announcements</span>
        <span class="pill">🔧 Maintenance</span>
      </div>
    </div>
    <div class="left-footer">
      &copy; {{ date('Y') }} DormEase. All rights reserved.
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="form-wrap">

      <div class="form-header">
        <div class="eyebrow">Staff Portal</div>
        <h2>Welcome to<br><em>DormEase</em></h2>
        <p>Select your role and sign in with your credentials to continue.</p>
      </div>

      <!-- Role Selector -->
      <span class="role-label">Sign in as</span>
      <div class="role-row">
        <button type="button" class="role-btn active" id="role-admin" onclick="setRole('admin')">
          <div class="role-icon">🏢</div>
          <div>
            <div class="role-name">Admin</div>
            <div class="role-desc">Full access</div>
          </div>
        </button>
        <button type="button" class="role-btn" id="role-frontdesk" onclick="setRole('frontdesk')">
          <div class="role-icon">🧑‍💼</div>
          <div>
            <div class="role-name">Front Desk</div>
            <div class="role-desc">Staff access</div>
          </div>
        </button>
      </div>

      <form method="POST" action="/login">
        @csrf

        {{-- Hidden role field sent with form --}}
        <input type="hidden" name="role" id="role-input" value="admin">

        {{-- Error Alert --}}
        @if ($errors->any())
          <div style="
            background:#fff0f0;
            border:1.5px solid #DF0404;
            border-radius:12px;
            padding:.85rem 1rem;
            margin-bottom:1.2rem;
            display:flex;
            align-items:center;
            gap:.6rem;
            font-size:.84rem;
            color:#DF0404;
            font-weight:500;
          ">
            <span>⚠️</span>
            <span>{{ $errors->first('email') }}</span>
          </div>
        @endif

        <!-- Email -->
        <div class="field">
          <label for="email">Email Address</label>
          <div class="input-wrap">
            <span class="icon">✉️</span>
            <input type="email" id="email" name="email"
                   placeholder="you@example.com"
                   autocomplete="email"
                   value="{{ old('email') }}">
          </div>
        </div>

        <!-- Password -->
        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <span class="icon">🔒</span>
            <input type="password" id="password" name="password"
                   placeholder="Enter your password"
                   autocomplete="current-password">
            <button class="toggle-pw" type="button" onclick="togglePw()" id="pw-toggle">👁</button>
          </div>
        </div>

        <!-- Remember + Forgot -->
        <div class="field-row">
          <label class="remember">
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a href="#" class="forgot">Forgot password?</a>
        </div>

        <!-- Submit -->
        <button class="btn-login" type="submit">Sign In →</button>

      </form>

      <div class="status-strip">
        <div class="status-dot"></div>
        <span>All systems operational · Secure connection</span>
      </div>

    </div>
  </div>

  <script>
    function setRole(role) {
      document.getElementById('role-admin').classList.toggle('active', role === 'admin');
      document.getElementById('role-frontdesk').classList.toggle('active', role === 'frontdesk');
      document.getElementById('role-input').value = role;
    }

    function togglePw() {
      const input = document.getElementById('password');
      const btn   = document.getElementById('pw-toggle');
      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
      } else {
        input.type = 'password';
        btn.textContent = '👁';
      }
    }
  </script>
</body>
</html>