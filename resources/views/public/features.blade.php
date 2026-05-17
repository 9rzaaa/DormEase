<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Features | DormEase</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --pink-1:#E8175D; --pink-2:#FF2D78;
      --gradient-pink:linear-gradient(135deg,#E8175D 0%,#FF2D78 100%);
      --soft-bg:#fff7fb; --pink:var(--pink-1); --pink-light:#FF7FB0;
      --pink-pale:#FFE4F0; --pink-deep:#8A123B; --cream:var(--soft-bg);
      --cream-dark:#FFEAF3; --brown:#241018; --brown-light:#744B5D;
      --white:#fff; --border:rgba(232,23,93,.18);
      --font-head:'Montserrat','Segoe UI',sans-serif;
      --font-body:'Nunito','Google Sans',sans-serif;
      --shadow-soft:0 4px 32px rgba(232,23,93,.16);
      --shadow-card:0 2px 20px rgba(36,16,24,.09);
      --r-md:16px; --r-lg:28px;
    }
    html { scroll-behavior:smooth; }
    body { font-family:var(--font-body); background:var(--cream); color:var(--brown); line-height:1.6; overflow-x:hidden; }

    /* ── HEADER / NAV ── */
    .site-header { position:relative; background:var(--cream); }
    .top-notice { position:absolute; top:0; left:0; right:0; z-index:101; min-height:34px; display:flex; align-items:center; justify-content:center; padding:6px 5%; background:var(--gradient-pink); color:white; font-family:var(--font-head); font-size:.86rem; font-weight:800; text-align:center; }
    nav { position:fixed; top:54px; left:50%; z-index:100; width:min(1220px,calc(100% - 12%)); transform:translateX(-50%); background:rgba(255,228,240,.96); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid rgba(36,16,24,.78); border-radius:999px; padding:0 38px; height:86px; display:flex; align-items:center; justify-content:space-between; transition:top .25s ease,box-shadow .3s; }
    nav.scrolled { top:18px; box-shadow:0 16px 34px rgba(36,16,24,.12); }
    .nav-logo { display:flex; align-items:center; gap:10px; text-decoration:none; }
    .nav-logo img { height:58px; width:auto; object-fit:contain; display:block; background:var(--gradient-pink); border-radius:50%; padding:8px; filter:drop-shadow(0 2px 7px rgba(36,16,24,.22)); }
    .nav-logo-fb { font-family:var(--font-head); font-size:1.55rem; font-weight:800; color:var(--brown); letter-spacing:-.02em; }
    .nav-logo-fb span { color:var(--pink); }
    .nav-links { display:flex; align-items:center; gap:30px; list-style:none; }
    .nav-links a { text-decoration:none; font-size:.98rem; font-weight:700; color:var(--brown); letter-spacing:.01em; transition:color .2s; }
    .nav-links a:hover { color:var(--pink); }
    .nav-links a.nav-active { color:var(--pink); position:relative; }
    .nav-links a.nav-active::after { content:''; position:absolute; bottom:-4px; left:0; right:0; height:2.5px; border-radius:99px; background:var(--gradient-pink); }
    .nav-cta { background:var(--gradient-pink) !important; color:white !important; padding:11px 26px !important; border-radius:100px !important; font-weight:700 !important; transition:filter .2s,transform .15s !important; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-cta:hover { filter:brightness(.94); transform:translateY(-1px); }
    .header-spacer { height:154px; background:var(--cream); }

    /* ── HERO ── */
    .features-hero { padding:70px 6% 60px; background:var(--cream); }
    .features-hero-inner { max-width:1180px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; }
    .section-tag { font-size:.72rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
    .hero-headline { font-family:var(--font-head); font-size:clamp(2.35rem,4.2vw,4rem); line-height:1.08; color:var(--brown); letter-spacing:-.03em; }
    .hero-headline em { color:var(--pink); font-style:italic; }
    .hero-copy { color:var(--brown-light); font-size:1.05rem; line-height:1.8; margin-top:18px; margin-bottom:30px; }
    .hero-badges { display:flex; flex-wrap:wrap; gap:10px; }
    .hero-badge { display:inline-flex; align-items:center; gap:7px; background:white; border:1.5px solid var(--border); border-radius:100px; padding:8px 16px; font-size:.82rem; font-weight:700; color:var(--brown); box-shadow:var(--shadow-card); }
    .hero-badge svg { width:15px; height:15px; stroke:var(--pink); fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }
    /* Hero phone cluster */
    .hero-phones { position:relative; display:flex; justify-content:center; align-items:flex-end; gap:-20px; height:420px; }
    .hero-phone { width:180px; background:var(--brown); border-radius:28px; box-shadow:0 24px 56px rgba(36,16,24,.28); overflow:hidden; position:absolute; border:3px solid rgba(255,255,255,.12); }
    .hero-phone-1 { left:50%; transform:translateX(-120%) rotate(-8deg); bottom:0; height:340px; }
    .hero-phone-2 { left:50%; transform:translateX(-50%); bottom:20px; height:380px; z-index:2; }
    .hero-phone-3 { left:50%; transform:translateX(20%) rotate(8deg); bottom:0; height:340px; }
    .phone-screen { width:100%; height:100%; background:linear-gradient(160deg,#2a0f1e 0%,#1a0810 100%); display:flex; flex-direction:column; padding:14px 12px 12px; }
    .phone-statusbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .phone-time { font-family:var(--font-head); font-size:.6rem; font-weight:800; color:rgba(255,255,255,.7); }
    .phone-icons { display:flex; gap:3px; align-items:center; }
    .phone-icons span { width:4px; height:4px; border-radius:50%; background:rgba(255,255,255,.5); }
    .phone-notch { width:50px; height:8px; background:#000; border-radius:99px; margin:0 auto 10px; }
    .phone-app-grid { display:grid; grid-template-columns:1fr 1fr; gap:6px; flex:1; }
    .phone-app-tile { background:rgba(232,23,93,.15); border:1px solid rgba(232,23,93,.25); border-radius:10px; padding:8px 6px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px; }
    .phone-app-tile svg { width:18px; height:18px; stroke:var(--pink-light); fill:none; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
    .phone-app-label { font-size:.42rem; font-weight:700; color:rgba(255,255,255,.6); text-align:center; font-family:var(--font-head); }

    /* ── FEATURES GRID ── */
    .features-section { padding:20px 6% 100px; background:var(--cream); }
    .features-inner { max-width:1180px; margin:0 auto; }
    .features-grid { display:grid; grid-template-columns:1fr 1fr; gap:28px; }

    /* Feature card */
    .feat-card { background:white; border:1.5px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--shadow-card); overflow:hidden; display:grid; grid-template-columns:1fr 1fr; min-height:380px; transition:box-shadow .3s, transform .3s; }
    .feat-card:hover { box-shadow:var(--shadow-soft); transform:translateY(-4px); }
    /* Alternate layout for odd cards */
    .feat-card.flip { direction:rtl; }
    .feat-card.flip > * { direction:ltr; }

    /* Card info side */
    .feat-info { padding:36px 32px; display:flex; flex-direction:column; justify-content:center; }
    .feat-number { font-family:var(--font-head); font-size:.68rem; font-weight:900; letter-spacing:.14em; text-transform:uppercase; color:var(--pink-light); margin-bottom:10px; }
    .feat-title { font-family:var(--font-head); font-size:1.35rem; font-weight:800; color:var(--brown); line-height:1.2; margin-bottom:12px; }
    .feat-desc { font-size:.9rem; color:var(--brown-light); line-height:1.72; margin-bottom:18px; }
    .feat-tags { display:flex; flex-wrap:wrap; gap:7px; }
    .feat-tag { font-size:.72rem; font-weight:700; color:var(--pink); background:var(--pink-pale); border-radius:100px; padding:4px 12px; }

    /* Card phone side */
    .feat-phone-wrap { background:linear-gradient(135deg, #2c0f1f 0%, #160810 100%); display:flex; align-items:center; justify-content:center; padding:28px 20px; position:relative; overflow:hidden; }
    .feat-phone-wrap::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse at 60% 40%, rgba(232,23,93,.18) 0%, transparent 70%); }
    .feat-phone-mock { width:130px; background:#1a0810; border-radius:22px; border:2.5px solid rgba(255,255,255,.1); box-shadow:0 16px 40px rgba(0,0,0,.45); overflow:hidden; position:relative; z-index:1; }
    .fpm-bar { height:8px; background:#000; display:flex; align-items:center; justify-content:center; }
    .fpm-notch { width:36px; height:5px; background:#111; border-radius:99px; }
    .fpm-screen { padding:10px 9px 9px; background:linear-gradient(170deg,#1e0a14 0%,#120609 100%); }
    /* Screen content variants */
    .fpm-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
    .fpm-greeting { font-family:var(--font-head); font-size:.48rem; font-weight:800; color:rgba(255,255,255,.85); }
    .fpm-avatar { width:16px; height:16px; border-radius:50%; background:var(--gradient-pink); }
    .fpm-card { background:var(--gradient-pink); border-radius:8px; padding:8px; margin-bottom:7px; }
    .fpm-card-label { font-size:.38rem; color:rgba(255,255,255,.7); font-weight:600; margin-bottom:2px; }
    .fpm-card-amount { font-family:var(--font-head); font-size:.7rem; font-weight:800; color:white; }
    .fpm-row { display:flex; gap:5px; margin-bottom:5px; }
    .fpm-mini-card { flex:1; background:rgba(232,23,93,.15); border:1px solid rgba(232,23,93,.22); border-radius:6px; padding:6px 5px; }
    .fpm-mini-label { font-size:.35rem; color:rgba(255,255,255,.5); margin-bottom:2px; }
    .fpm-mini-val { font-family:var(--font-head); font-size:.52rem; font-weight:800; color:rgba(255,255,255,.85); }
    .fpm-list-item { display:flex; align-items:center; gap:5px; padding:5px 0; border-bottom:1px solid rgba(255,255,255,.06); }
    .fpm-list-dot { width:6px; height:6px; border-radius:50%; background:var(--pink-light); flex-shrink:0; }
    .fpm-list-text { font-size:.38rem; color:rgba(255,255,255,.6); flex:1; line-height:1.3; }
    .fpm-list-badge { font-size:.3rem; font-weight:700; background:rgba(232,23,93,.3); color:var(--pink-light); padding:2px 5px; border-radius:99px; }
    .fpm-section-label { font-size:.38rem; font-weight:800; color:rgba(255,255,255,.35); text-transform:uppercase; letter-spacing:.08em; margin-bottom:5px; margin-top:5px; }
    .fpm-announce-item { background:rgba(255,255,255,.05); border-radius:5px; padding:5px; margin-bottom:4px; }
    .fpm-announce-title { font-size:.4rem; font-weight:700; color:rgba(255,255,255,.8); margin-bottom:1px; }
    .fpm-announce-body { font-size:.33rem; color:rgba(255,255,255,.4); line-height:1.4; }
    .fpm-announce-time { font-size:.3rem; color:var(--pink-light); margin-top:2px; }
    .fpm-voice-btn { background:var(--gradient-pink); border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; margin:8px auto 5px; box-shadow:0 4px 12px rgba(232,23,93,.4); }
    .fpm-voice-btn svg { width:13px; height:13px; stroke:white; fill:none; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }
    .fpm-voice-label { text-align:center; font-size:.35rem; color:rgba(255,255,255,.5); margin-bottom:6px; }
    .fpm-input-bar { background:rgba(255,255,255,.08); border-radius:5px; padding:5px 7px; font-size:.38rem; color:rgba(255,255,255,.4); margin-bottom:6px; }
    .fpm-urgency-row { display:flex; gap:4px; margin-bottom:6px; }
    .fpm-urgency-chip { flex:1; border-radius:99px; padding:3px 0; text-align:center; font-size:.33rem; font-weight:700; }
    .fpm-u-low { background:rgba(34,197,94,.15); color:#4ade80; border:1px solid rgba(34,197,94,.25); }
    .fpm-u-med { background:rgba(251,191,36,.15); color:#fbbf24; border:1px solid rgba(251,191,36,.25); }
    .fpm-u-high { background:rgba(232,23,93,.2); color:var(--pink-light); border:1px solid rgba(232,23,93,.3); }
    .fpm-alert-btn { background:linear-gradient(135deg,#dc2626,#ef4444); border-radius:8px; padding:8px; text-align:center; margin-bottom:6px; }
    .fpm-alert-btn-icon { font-size:.9rem; display:block; margin-bottom:2px; }
    .fpm-alert-btn-text { font-family:var(--font-head); font-size:.42rem; font-weight:800; color:white; }
    .fpm-bill-amount { text-align:center; margin:6px 0; }
    .fpm-bill-label { font-size:.35rem; color:rgba(255,255,255,.4); }
    .fpm-bill-value { font-family:var(--font-head); font-size:.9rem; font-weight:800; color:white; }
    .fpm-bill-due { font-size:.33rem; color:var(--pink-light); }
    .fpm-qr { width:38px; height:38px; background:white; border-radius:5px; margin:5px auto; display:grid; grid-template-columns:repeat(5,1fr); gap:1px; padding:3px; }
    .fpm-qr span { background:#1a0810; border-radius:1px; }
    .fpm-qr span.w { background:white; }
    .fpm-payment-row { display:flex; gap:4px; }
    .fpm-pay-chip { flex:1; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:5px; padding:4px 2px; text-align:center; font-size:.32rem; font-weight:700; color:rgba(255,255,255,.55); }
    .fpm-form-field { background:rgba(255,255,255,.06); border-radius:5px; padding:5px 7px; margin-bottom:4px; }
    .fpm-form-field-label { font-size:.3rem; color:rgba(255,255,255,.35); margin-bottom:1px; }
    .fpm-form-field-val { font-size:.4rem; color:rgba(255,255,255,.7); font-weight:600; }
    .fpm-submit-btn { background:var(--gradient-pink); border-radius:6px; padding:5px; text-align:center; font-family:var(--font-head); font-size:.4rem; font-weight:800; color:white; margin-top:4px; }
    .fpm-doc-item { display:flex; align-items:center; gap:5px; background:rgba(255,255,255,.05); border-radius:5px; padding:5px; margin-bottom:4px; }
    .fpm-doc-icon { width:18px; height:18px; background:rgba(232,23,93,.2); border-radius:4px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .fpm-doc-icon svg { width:10px; height:10px; stroke:var(--pink-light); fill:none; stroke-width:2; stroke-linecap:round; }
    .fpm-doc-name { font-size:.38rem; color:rgba(255,255,255,.7); font-weight:600; flex:1; }
    .fpm-doc-status { font-size:.3rem; padding:2px 5px; border-radius:99px; font-weight:700; }
    .fpm-status-ready { background:rgba(34,197,94,.2); color:#4ade80; }
    .fpm-status-proc { background:rgba(251,191,36,.15); color:#fbbf24; }
    .fpm-notif-item { display:flex; gap:5px; padding:5px 0; border-bottom:1px solid rgba(255,255,255,.05); }
    .fpm-notif-dot { width:6px; height:6px; border-radius:50%; margin-top:4px; flex-shrink:0; }
    .fpm-notif-content { flex:1; }
    .fpm-notif-title { font-size:.38rem; font-weight:700; color:rgba(255,255,255,.8); margin-bottom:1px; }
    .fpm-notif-body { font-size:.32rem; color:rgba(255,255,255,.4); line-height:1.3; }
    .fpm-notif-time { font-size:.28rem; color:rgba(255,255,255,.25); margin-top:1px; }

    /* ── FOOTER ── */
    footer { background:var(--brown); color:rgba(255,255,255,.48); padding:64px 6% 40px; }
    .footer-inner { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; margin-bottom:48px; }
    .footer-logo { display:flex; align-items:center; margin-bottom:16px; text-decoration:none; }
    .footer-logo img { height:56px; width:auto; object-fit:contain; filter:drop-shadow(0 4px 12px rgba(0,0,0,.22)); }
    .footer-logo-fb { font-family:var(--font-head); font-size:1.2rem; font-weight:800; color:white; letter-spacing:-.02em; }
    .footer-logo-fb span { color:var(--pink-light); }
    .footer-brand { font-size:.83rem; line-height:1.75; max-width:250px; }
    .footer-col h4 { font-size:.66rem; text-transform:uppercase; letter-spacing:.12em; color:rgba(255,255,255,.32); margin-bottom:16px; font-weight:700; }
    .footer-col a { display:block; font-size:.87rem; color:rgba(255,255,255,.52); text-decoration:none; margin-bottom:10px; transition:color .2s; }
    .footer-col a:hover { color:var(--pink-light); }
    .footer-btm { border-top:1px solid rgba(255,255,255,.07); padding-top:24px; display:flex; justify-content:space-between; align-items:center; gap:22px; font-size:.78rem; }
    .footer-btm-right { display:flex; gap:22px; align-items:center; flex-wrap:wrap; }
    .footer-links { display:flex; gap:20px; align-items:center; flex-wrap:wrap; }
    .footer-btm a { color:rgba(255,255,255,.32); text-decoration:none; }
    .footer-socials { display:flex; align-items:center; gap:12px; }
    .footer-social-icon { position:relative; width:46px; height:46px; border-radius:50%; background:#111; color:white; display:inline-flex; align-items:center; justify-content:center; overflow:hidden; border:1px solid rgba(255,255,255,.14); transition:transform .2s,background .2s,border-color .2s; }
    .footer-social-icon:hover { transform:translateY(-2px); background:var(--pink); border-color:var(--pink-light); }
    .footer-social-icon img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block; }

    /* ── SCROLL TO TOP ── */
    #scrollTopBtn { position:fixed; bottom:32px; right:32px; z-index:999; width:50px; height:50px; border:none; border-radius:50%; background:var(--gradient-pink); color:white; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 24px rgba(232,23,93,.36); opacity:0; transform:translateY(16px) scale(.85); transition:opacity .3s ease,transform .3s ease,box-shadow .2s; pointer-events:none; }
    #scrollTopBtn.visible { opacity:1; transform:translateY(0) scale(1); pointer-events:auto; }
    #scrollTopBtn:hover { box-shadow:0 12px 32px rgba(232,23,93,.52); transform:translateY(-3px) scale(1.07); }
    #scrollTopBtn:active { transform:translateY(0) scale(.96); }
    #scrollTopBtn svg { width:22px; height:22px; stroke:white; fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; }

    /* ── RESPONSIVE ── */
    @media(max-width:1060px){
      .features-grid { grid-template-columns:1fr; }
      .feat-card { grid-template-columns:1fr 1fr; }
      .feat-card.flip { direction:ltr; }
    }
    @media(max-width:960px){
      .nav-links li:not(:last-child){ display:none; }
      .footer-inner{ grid-template-columns:1fr 1fr; }
      .features-hero-inner{ grid-template-columns:1fr; }
      .hero-phones{ display:none; }
    }
    @media(max-width:760px){
      nav{top:46px;height:auto;min-height:76px;padding:10px 5%;gap:14px;flex-wrap:wrap;border-radius:28px;width:calc(100% - 28px)}
      nav.scrolled{top:12px}
      .top-notice{font-size:.74rem;min-height:30px}
      .header-spacer{height:138px}
      .nav-logo img{height:44px}
      .nav-logo-fb{font-size:1.22rem}
      .nav-links{gap:0;margin-left:auto}
      .features-hero{padding:60px 5% 48px}
      .features-section{padding:0 5% 80px}
      .feat-card{ grid-template-columns:1fr; min-height:auto; }
      .feat-phone-wrap{ min-height:220px; }
      .feat-card.flip{ direction:ltr; }
      .footer-btm{flex-direction:column;gap:16px;align-items:flex-start}
      .footer-btm-right{align-items:flex-start}
      #scrollTopBtn{bottom:22px;right:18px;width:44px;height:44px;}
    }
    @media(max-width:600px){
      .footer-inner{grid-template-columns:1fr}
    }

    /* Entrance animation */
    .feat-card { opacity:0; transform:translateY(30px); transition:opacity .5s ease, transform .5s ease, box-shadow .3s, border-color .3s; }
    .feat-card.visible { opacity:1; transform:translateY(0); }
    .feat-card:hover { transform:translateY(-4px) !important; }
  </style>
</head>
<body>

<header class="site-header">
  <div class="top-notice">Sanctissimo Rosario Ladies Dormitory &middot; Safe student housing near UST</div>
  <nav id="navbar">
    <a href="{{ route('home') }}" class="nav-logo">
      <img src="{{ asset('images/logo.png') }}" alt="DormEase Logo" onerror="this.style.display='none'">
      <span class="nav-logo-fb">Dorm<span>Ease</span></span>
    </a>
    <ul class="nav-links">
      <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
      <li><a href="{{ route('home') }}#how">How it Works</a></li>
      <li><a href="{{ route('home') }}#about">About</a></li>
      <li><a href="{{ route('faqs') }}">FAQs</a></li>
      <li><a href="{{ route('home') }}#contact" class="nav-cta">Contact Us</a></li>
    </ul>
  </nav>
  <div class="header-spacer"></div>
</header>

<main>

  <!-- HERO -->
  <section class="features-hero">
    <div class="features-hero-inner">
      <div>
        <div class="section-tag">Mobile Application</div>
        <h1 class="hero-headline">Everything a Tenant Needs,<br><em>In One App.</em></h1>
        <p class="hero-copy">DormEase gives Sanctissimo Rosario tenants a complete mobile experience — from paying water bills to filing maintenance requests, all from their phone.</p>
        <div class="hero-badges">
          <span class="hero-badge"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Secure & Private</span>
          <span class="hero-badge"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Real-time Updates</span>
          <span class="hero-badge"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>Voice Input</span>
          <span class="hero-badge"><svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Android & iOS</span>
        </div>
      </div>
      <!-- Phone cluster decoration -->
      <div class="hero-phones" aria-hidden="true">
        <div class="hero-phone hero-phone-1">
          <div class="phone-screen">
            <div class="phone-statusbar"><span class="phone-time">9:41</span><div class="phone-icons"><span></span><span></span><span></span></div></div>
            <div class="phone-notch"></div>
            <div class="phone-app-grid">
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg><span class="phone-app-label">Dashboard</span></div>
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg><span class="phone-app-label">Alerts</span></div>
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg><span class="phone-app-label">Maintenance</span></div>
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg><span class="phone-app-label">Emergency</span></div>
            </div>
          </div>
        </div>
        <div class="hero-phone hero-phone-2">
          <div class="phone-screen">
            <div class="phone-statusbar"><span class="phone-time">9:41</span><div class="phone-icons"><span></span><span></span><span></span></div></div>
            <div class="phone-notch"></div>
            <div style="padding:0 2px;">
              <div class="fpm-header"><span class="fpm-greeting">Hi, Maria 👋</span><div class="fpm-avatar"></div></div>
              <div class="fpm-card"><div class="fpm-card-label">Current Water Bill</div><div class="fpm-card-amount">₱ 320.00</div></div>
              <div class="fpm-row">
                <div class="fpm-mini-card"><div class="fpm-mini-label">Requests</div><div class="fpm-mini-val">2</div></div>
                <div class="fpm-mini-card"><div class="fpm-mini-label">Announcements</div><div class="fpm-mini-val">3</div></div>
              </div>
              <div class="fpm-section-label">Recent Activity</div>
              <div class="fpm-list-item"><div class="fpm-list-dot"></div><div class="fpm-list-text">Leaky faucet — Room 204</div><div class="fpm-list-badge">In Progress</div></div>
              <div class="fpm-list-item"><div class="fpm-list-dot" style="background:#4ade80"></div><div class="fpm-list-text">Water bill for May paid</div><div class="fpm-list-badge" style="background:rgba(74,222,128,.2);color:#4ade80">Done</div></div>
            </div>
          </div>
        </div>
        <div class="hero-phone hero-phone-3">
          <div class="phone-screen">
            <div class="phone-statusbar"><span class="phone-time">9:41</span><div class="phone-icons"><span></span><span></span><span></span></div></div>
            <div class="phone-notch"></div>
            <div class="phone-app-grid">
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="phone-app-label">Visitor Log</span></div>
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span class="phone-app-label">Documents</span></div>
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg><span class="phone-app-label">Water Bill</span></div>
              <div class="phone-app-tile"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span class="phone-app-label">Notices</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES GRID -->
  <section class="features-section">
    <div class="features-inner">
      <div class="features-grid">

        <!-- 1. Dashboard -->
        <div class="feat-card">
          <div class="feat-info">
            <div class="feat-number">Feature 01</div>
            <div class="feat-title">Dashboard</div>
            <p class="feat-desc">A personalized home screen showing your current water bill, pending request count, latest announcements, and quick-access buttons to every feature — all in one glance.</p>
            <div class="feat-tags"><span class="feat-tag">Overview</span><span class="feat-tag">Quick Access</span><span class="feat-tag">Personalized</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Hi, Maria 👋</span><div class="fpm-avatar"></div></div>
                <div class="fpm-card"><div class="fpm-card-label">Current Water Bill</div><div class="fpm-card-amount">₱ 320.00</div></div>
                <div class="fpm-row">
                  <div class="fpm-mini-card"><div class="fpm-mini-label">Requests</div><div class="fpm-mini-val">2 Pending</div></div>
                  <div class="fpm-mini-card"><div class="fpm-mini-label">Notices</div><div class="fpm-mini-val">3 New</div></div>
                </div>
                <div class="fpm-section-label">Quick Access</div>
                <div class="fpm-row">
                  <div class="fpm-mini-card" style="text-align:center"><div class="fpm-mini-val" style="font-size:.38rem">🔧 Maintenance</div></div>
                  <div class="fpm-mini-card" style="text-align:center"><div class="fpm-mini-val" style="font-size:.38rem">💧 Water Bill</div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Announcements -->
        <div class="feat-card flip">
          <div class="feat-info">
            <div class="feat-number">Feature 02</div>
            <div class="feat-title">Announcements</div>
            <p class="feat-desc">View all active announcements posted by the Administrator. Push notifications alert you the moment a new post goes live — so you never miss an important update.</p>
            <div class="feat-tags"><span class="feat-tag">Push Notifications</span><span class="feat-tag">Real-time</span><span class="feat-tag">Admin Posts</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Announcements</span></div>
                <div class="fpm-announce-item">
                  <div class="fpm-announce-title">🔔 Water Interruption Notice</div>
                  <div class="fpm-announce-body">Water supply will be cut on May 20, 8AM–12PM for pipe maintenance.</div>
                  <div class="fpm-announce-time">Today, 8:30 AM</div>
                </div>
                <div class="fpm-announce-item">
                  <div class="fpm-announce-title">📋 May Billing Statement</div>
                  <div class="fpm-announce-body">May water bills are now available. Please settle by May 28.</div>
                  <div class="fpm-announce-time">Yesterday, 3:00 PM</div>
                </div>
                <div class="fpm-announce-item">
                  <div class="fpm-announce-title">🏠 Dorm Clean-up Day</div>
                  <div class="fpm-announce-body">General cleaning scheduled for Saturday. All tenants must participate.</div>
                  <div class="fpm-announce-time">May 14, 10:00 AM</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Maintenance Request -->
        <div class="feat-card">
          <div class="feat-info">
            <div class="feat-number">Feature 03</div>
            <div class="feat-title">Maintenance Request</div>
            <p class="feat-desc">Submit requests via typed text or voice input powered by the Vosk Speech Recognition Engine. The system auto-classifies urgency (Low / Medium / High) and detects the issue category using rule-based NLP before you confirm.</p>
            <div class="feat-tags"><span class="feat-tag">Voice Input</span><span class="feat-tag">NLP Classification</span><span class="feat-tag">Urgency Detection</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">New Request</span></div>
                <div class="fpm-voice-btn"><svg viewBox="0 0 24 24"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg></div>
                <div class="fpm-voice-label">Tap to speak or type below</div>
                <div class="fpm-input-bar">Leaking faucet in bathroom...</div>
                <div class="fpm-section-label">Detected — Plumbing · Urgency</div>
                <div class="fpm-urgency-row">
                  <div class="fpm-urgency-chip fpm-u-low">Low</div>
                  <div class="fpm-urgency-chip fpm-u-med" style="border-width:2px">Medium ✓</div>
                  <div class="fpm-urgency-chip fpm-u-high">High</div>
                </div>
                <div class="fpm-submit-btn">Confirm & Submit</div>
              </div>
            </div>
          </div>
        </div>

        <!-- 4. Emergency Report -->
        <div class="feat-card flip">
          <div class="feat-info">
            <div class="feat-number">Feature 04</div>
            <div class="feat-title">Emergency Report</div>
            <p class="feat-desc">Quickly report emergencies using the alert button, text, or voice input. Upon submission, an immediate push notification is sent to the Administrator and Front Desk Staff so help can arrive fast.</p>
            <div class="feat-tags"><span class="feat-tag">Instant Alert</span><span class="feat-tag">Voice Input</span><span class="feat-tag">Staff Notified</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Emergency Report</span></div>
                <div class="fpm-alert-btn">
                  <span class="fpm-alert-btn-icon">🚨</span>
                  <span class="fpm-alert-btn-text">TAP TO REPORT EMERGENCY</span>
                </div>
                <div class="fpm-voice-btn" style="background:linear-gradient(135deg,#dc2626,#ef4444);width:24px;height:24px"><svg viewBox="0 0 24 24"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/></svg></div>
                <div class="fpm-voice-label">Or describe the emergency</div>
                <div class="fpm-input-bar">Fire on 3rd floor hallway...</div>
                <div class="fpm-section-label">Notification will be sent to</div>
                <div class="fpm-list-item"><div class="fpm-list-dot" style="background:#ef4444"></div><div class="fpm-list-text">Administrator</div></div>
                <div class="fpm-list-item"><div class="fpm-list-dot" style="background:#ef4444"></div><div class="fpm-list-text">Front Desk Staff</div></div>
              </div>
            </div>
          </div>
        </div>

        <!-- 5. Water Bill -->
        <div class="feat-card">
          <div class="feat-info">
            <div class="feat-number">Feature 05</div>
            <div class="feat-title">Water Bill</div>
            <p class="feat-desc">View your current billing amount, consumption breakdown, due date, and payment history. Pay directly via QR code using GCash, Maya, or bank transfer, then upload your proof of payment right in the app.</p>
            <div class="feat-tags"><span class="feat-tag">GCash / Maya</span><span class="feat-tag">QR Payment</span><span class="feat-tag">Proof Upload</span><span class="feat-tag">History</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Water Bill</span></div>
                <div class="fpm-bill-amount">
                  <div class="fpm-bill-label">Amount Due</div>
                  <div class="fpm-bill-value">₱320.00</div>
                  <div class="fpm-bill-due">Due: May 28, 2026</div>
                </div>
                <div class="fpm-section-label">Pay via QR Code</div>
                <div class="fpm-qr">
                  <span></span><span class="w"></span><span></span><span class="w"></span><span></span>
                  <span class="w"></span><span></span><span class="w"></span><span></span><span class="w"></span>
                  <span></span><span class="w"></span><span></span><span class="w"></span><span></span>
                  <span class="w"></span><span></span><span class="w"></span><span></span><span class="w"></span>
                  <span></span><span class="w"></span><span></span><span class="w"></span><span></span>
                </div>
                <div class="fpm-payment-row">
                  <div class="fpm-pay-chip">GCash</div>
                  <div class="fpm-pay-chip">Maya</div>
                  <div class="fpm-pay-chip">Bank</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 6. Visitor Registration -->
        <div class="feat-card flip">
          <div class="feat-info">
            <div class="feat-number">Feature 06</div>
            <div class="feat-title">Visitor Registration</div>
            <p class="feat-desc">Pre-register your expected visitors by entering their name, contact number, purpose of visit, ID type, and expected arrival time. Front Desk Staff can verify them quickly upon arrival.</p>
            <div class="feat-tags"><span class="feat-tag">Pre-registration</span><span class="feat-tag">Staff Verification</span><span class="feat-tag">Visitor Log</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Register Visitor</span></div>
                <div class="fpm-form-field"><div class="fpm-form-field-label">Visitor Name</div><div class="fpm-form-field-val">Ana Santos</div></div>
                <div class="fpm-form-field"><div class="fpm-form-field-label">Contact Number</div><div class="fpm-form-field-val">+63 912 345 6789</div></div>
                <div class="fpm-form-field"><div class="fpm-form-field-label">Purpose of Visit</div><div class="fpm-form-field-val">Study session</div></div>
                <div class="fpm-form-field"><div class="fpm-form-field-label">ID Type</div><div class="fpm-form-field-val">School ID</div></div>
                <div class="fpm-form-field"><div class="fpm-form-field-label">Expected Arrival</div><div class="fpm-form-field-val">May 17 · 2:00 PM</div></div>
                <div class="fpm-submit-btn">Pre-register Visitor</div>
              </div>
            </div>
          </div>
        </div>

        <!-- 7. Document Request -->
        <div class="feat-card">
          <div class="feat-info">
            <div class="feat-number">Feature 07</div>
            <div class="feat-title">Document Request</div>
            <p class="feat-desc">Submit requests for administrative documents, choose between a digital or printed copy, and track your request status in real time — from submission all the way to download or pickup.</p>
            <div class="feat-tags"><span class="feat-tag">Digital or Print</span><span class="feat-tag">Status Tracking</span><span class="feat-tag">Download</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Document Requests</span></div>
                <div class="fpm-doc-item">
                  <div class="fpm-doc-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                  <div class="fpm-doc-name">Certificate of Residency</div>
                  <div class="fpm-doc-status fpm-status-ready">Ready</div>
                </div>
                <div class="fpm-doc-item">
                  <div class="fpm-doc-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                  <div class="fpm-doc-name">Good Moral Certificate</div>
                  <div class="fpm-doc-status fpm-status-proc">Processing</div>
                </div>
                <div class="fpm-section-label">Request New Document</div>
                <div class="fpm-form-field"><div class="fpm-form-field-label">Document Type</div><div class="fpm-form-field-val">Select document...</div></div>
                <div class="fpm-row">
                  <div class="fpm-mini-card" style="text-align:center"><div class="fpm-mini-val" style="font-size:.38rem">📄 Digital</div></div>
                  <div class="fpm-mini-card" style="text-align:center;background:rgba(232,23,93,.22);border-color:rgba(232,23,93,.4)"><div class="fpm-mini-val" style="font-size:.38rem;color:var(--pink-light)">🖨️ Print ✓</div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 8. Notifications -->
        <div class="feat-card flip">
          <div class="feat-info">
            <div class="feat-number">Feature 08</div>
            <div class="feat-title">Notifications</div>
            <p class="feat-desc">See all your push notifications in one place — announcement alerts, maintenance request updates, billing reminders, and document request status changes, all organized and timestamped.</p>
            <div class="feat-tags"><span class="feat-tag">Push Alerts</span><span class="feat-tag">All-in-one</span><span class="feat-tag">Timestamped</span></div>
          </div>
          <div class="feat-phone-wrap">
            <div class="feat-phone-mock">
              <div class="fpm-bar"><div class="fpm-notch"></div></div>
              <div class="fpm-screen">
                <div class="fpm-header"><span class="fpm-greeting">Notifications</span></div>
                <div class="fpm-notif-item">
                  <div class="fpm-notif-dot" style="background:var(--pink-light)"></div>
                  <div class="fpm-notif-content"><div class="fpm-notif-title">📢 New Announcement</div><div class="fpm-notif-body">Water interruption scheduled for May 20.</div><div class="fpm-notif-time">Just now</div></div>
                </div>
                <div class="fpm-notif-item">
                  <div class="fpm-notif-dot" style="background:#4ade80"></div>
                  <div class="fpm-notif-content"><div class="fpm-notif-title">🔧 Request Updated</div><div class="fpm-notif-body">Your maintenance request is now In Progress.</div><div class="fpm-notif-time">2 hrs ago</div></div>
                </div>
                <div class="fpm-notif-item">
                  <div class="fpm-notif-dot" style="background:#fbbf24"></div>
                  <div class="fpm-notif-content"><div class="fpm-notif-title">💧 Billing Reminder</div><div class="fpm-notif-body">May water bill due in 3 days. ₱320.00</div><div class="fpm-notif-time">Yesterday</div></div>
                </div>
                <div class="fpm-notif-item">
                  <div class="fpm-notif-dot" style="background:#818cf8"></div>
                  <div class="fpm-notif-content"><div class="fpm-notif-title">📄 Document Ready</div><div class="fpm-notif-body">Your Certificate of Residency is ready for download.</div><div class="fpm-notif-time">May 15</div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /.features-grid -->
    </div><!-- /.features-inner -->
  </section>

</main>

<footer>
  <div class="footer-inner">
    <div>
      <a href="{{ route('login') }}" class="footer-logo">
        <img src="{{ asset('images/logo.png') }}" alt="DormEase" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        <span class="footer-logo-fb" style="display:none;">Dorm<span>Ease</span></span>
      </a>
      <p class="footer-brand">A web and mobile dormitory management system for Sanctissimo Rosario Ladies Dormitory, Sampaloc, Manila.</p>
    </div>
    <div class="footer-col"><h4>Features</h4><a href="{{ route('home') }}#features">Maintenance</a><a href="{{ route('home') }}#features">Announcements</a><a href="{{ route('home') }}#features">Water Billing</a><a href="{{ route('home') }}#features">Visitor Log</a><a href="{{ route('safety.features') }}">Safety Features</a></div>
    <div class="footer-col"><h4>Dormitory</h4><a href="{{ route('home') }}#about">About</a><a href="{{ route('home') }}#gallery">Room Types</a><a href="{{ route('home') }}#about">Amenities</a><a href="{{ route('home') }}#contact">Location</a></div>
    <div class="footer-col"><h4>Contact</h4><a href="tel:+639175359723">+63 917 535 9723</a><a href="#">1229 Navarra St.</a><a href="#">Sampaloc, Manila</a></div>
  </div>
  <div class="footer-btm">
    <span>&copy; 2026 DormEase: Sanctissimo Rosario Ladies Dormitory</span>
    <div class="footer-btm-right">
      <div class="footer-socials">
        <a class="footer-social-icon" href="https://www.facebook.com/USTNavarra" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
          <img src="{{ asset('icons/facebook.png') }}" alt="" onerror="this.style.display='none'">
        </a>
        <a class="footer-social-icon" href="https://www.instagram.com/SRBdormitory" aria-label="Instagram">
          <img src="{{ asset('icons/instagram.png') }}" alt="" onerror="this.style.display='none'">
        </a>
        <a class="footer-social-icon" href="#" aria-label="TikTok">
          <img src="{{ asset('icons/tiktok.png') }}" alt="" onerror="this.style.display='none'">
        </a>
      </div>
      <div class="footer-links"><a href="#">Privacy Policy</a><a href="{{ route('faqs') }}">FAQs</a><a href="{{ route('login') }}">Admin Portal</a></div>
    </div>
  </div>
</footer>

<button id="scrollTopBtn" aria-label="Scroll to top">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg>
</button>

<script>
  // Nav scroll
  const nav = document.getElementById('navbar');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 20));

  // Scroll-to-top
  const scrollTopBtn = document.getElementById('scrollTopBtn');
  window.addEventListener('scroll', () => scrollTopBtn.classList.toggle('visible', scrollY > 300));
  scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  // Entrance animations via IntersectionObserver
  const cards = document.querySelectorAll('.feat-card');
  const cardObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        entry.target.style.transitionDelay = '0.08s';
        entry.target.classList.add('visible');
        cardObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });
  cards.forEach(card => cardObserver.observe(card));
</script>
</body>
</html>