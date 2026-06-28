<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Features: DormEase</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --pink-1:#E8175D; --pink-2:#FF2D78;
      --gradient-pink:linear-gradient(135deg,#E8175D 0%,#FF2D78 100%);
      --soft-bg:#fff7fb; --pink:var(--pink-1); --pink-light:#FF7FB0;
      --pink-pale:#FFE4F0; --pink-deep:#8A123B; --cream:var(--soft-bg);
      --cream-dark:#FFEAF3; --brown:#241018; --brown-light:#744B5D;
      --white:#fff; --border:rgba(232,23,93,.18);
      --font-head:'Poppins','Segoe UI',sans-serif;
      --font-body:'Poppins','Segoe UI',sans-serif;
      --shadow-soft:0 4px 32px rgba(232,23,93,.16);
      --shadow-card:0 2px 20px rgba(36,16,24,.09);
      --r-md:16px; --r-lg:28px;
    }
    html { scroll-behavior:smooth; }
    body { font-family:var(--font-body); background:var(--cream); color:var(--brown); line-height:1.6; overflow-x:hidden; }

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
    .nav-toggle { display:none; width:44px; height:44px; border:0; border-radius:50%; background:var(--gradient-pink); color:white; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-toggle svg { width:22px; height:22px; stroke:currentColor; fill:none; stroke-width:2.4; stroke-linecap:round; }
    .mobile-nav { display:none; position:absolute; top:calc(100% + 10px); left:0; right:0; padding:10px; background:rgba(255,228,240,.98); border:1.5px solid rgba(36,16,24,.55); border-radius:24px; box-shadow:0 18px 36px rgba(36,16,24,.16); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }
    .mobile-nav.open { display:grid; gap:4px; }
    .mobile-nav a { color:var(--brown); text-decoration:none; font-size:.95rem; font-weight:800; padding:12px 14px; border-radius:16px; }
    .mobile-nav a:hover, .mobile-nav a.nav-active { color:var(--pink); background:rgba(255,255,255,.62); }
    .header-spacer { height:154px; background:var(--cream); }

    .features-hero { padding:70px 6% 60px; background:var(--cream); }
    .features-hero-inner { max-width:1180px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; }
    .section-tag { font-size:.72rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
    .hero-headline { font-family:var(--font-head); font-size:clamp(2.35rem,4.2vw,4rem); line-height:1.08; color:var(--brown); letter-spacing:-.03em; }
    .hero-headline em { color:var(--pink); font-style:normal; }
    .hero-copy { color:var(--brown-light); font-size:1.05rem; line-height:1.8; margin-top:18px; margin-bottom:30px; }
    .hero-badges { display:flex; flex-wrap:wrap; gap:10px; }
    .hero-badge { display:inline-flex; align-items:center; gap:7px; background:white; border:1.5px solid var(--border); border-radius:100px; padding:8px 16px; font-size:.82rem; font-weight:700; color:var(--brown); box-shadow:var(--shadow-card); }
    .hero-badge svg { width:15px; height:15px; stroke:var(--pink); fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }
    .hero-phones { position:relative; display:flex; justify-content:center; align-items:flex-end; gap:-20px; height:420px; }
    .hero-phone { width:180px; background:white; border-radius:28px; box-shadow:0 24px 56px rgba(232,23,93,.18), 0 8px 24px rgba(36,16,24,.10); overflow:hidden; position:absolute; border:2px solid var(--border); }
    .hero-phone-1 { left:50%; transform:translateX(-120%) rotate(-8deg); bottom:0; height:340px; }
    .hero-phone-2 { left:50%; transform:translateX(-50%); bottom:20px; height:380px; z-index:2; border-color:rgba(232,23,93,.35); box-shadow:0 28px 64px rgba(232,23,93,.22), 0 8px 24px rgba(36,16,24,.10); }
    .hero-phone-3 { left:50%; transform:translateX(20%) rotate(8deg); bottom:0; height:340px; }
    .phone-screen { width:100%; height:100%; background:white; display:flex; flex-direction:column; padding:14px 12px 12px; }
    .phone-statusbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .phone-time { font-family:var(--font-head); font-size:.6rem; font-weight:800; color:var(--brown); }
    .phone-icons { display:flex; gap:3px; align-items:center; }
    .phone-icons span { width:4px; height:4px; border-radius:50%; background:var(--pink-light); }
    .phone-notch { width:50px; height:8px; background:var(--pink-pale); border-radius:99px; margin:0 auto 10px; }
    .phone-app-grid { display:grid; grid-template-columns:1fr 1fr; gap:6px; flex:1; }
    .phone-app-tile { background:var(--pink-pale); border:1px solid var(--border); border-radius:10px; padding:8px 6px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px; }
    .phone-app-tile svg { width:18px; height:18px; stroke:var(--pink); fill:none; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
    .phone-app-label { font-size:.42rem; font-weight:700; color:var(--brown-light); text-align:center; font-family:var(--font-head); }

    .features-section { padding:20px 6% 100px; background:var(--cream); }
    .features-inner { max-width:1180px; margin:0 auto; }
    .features-grid { display:grid; grid-template-columns:1fr 1fr; gap:28px; }

    .feat-card { background:white; border:1.5px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--shadow-card); overflow:hidden; display:grid; grid-template-columns:1fr 1fr; min-height:260px; transition:box-shadow .3s, transform .3s; }
    .feat-card:hover { box-shadow:var(--shadow-soft); transform:translateY(-4px); }
    .feat-card.flip { direction:rtl; }
    .feat-card.flip > * { direction:ltr; }

    .feat-info { padding:36px 32px; display:flex; flex-direction:column; justify-content:center; }
    .feat-number { font-family:var(--font-head); font-size:.68rem; font-weight:900; letter-spacing:.14em; text-transform:uppercase; color:var(--pink-light); margin-bottom:10px; }
    .feat-title { font-family:var(--font-head); font-size:1.35rem; font-weight:800; color:var(--brown); line-height:1.2; margin-bottom:12px; }
    .feat-desc { font-size:.9rem; color:var(--brown-light); line-height:1.72; margin-bottom:18px; }
    .feat-tags { display:flex; flex-wrap:wrap; gap:7px; }
    .feat-tag { font-size:.72rem; font-weight:700; color:var(--pink); background:var(--pink-pale); border-radius:100px; padding:4px 12px; }

    .feat-img-wrap {
      background: linear-gradient(135deg, var(--pink-light) 0%, #fce8f0 100%);
      display: flex; align-items: center; justify-content: center;
      padding: 24px 20px; position: relative; overflow: hidden;
    }
    .feat-img-wrap::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(ellipse at 60% 30%, rgba(232,23,93,.10) 0%, transparent 65%);
    }
    .phone-shell {
      position: relative; z-index: 1;
      width: 138px;
      border-radius: 22px;
      background: var(--brown);
      border: 3px solid rgba(255,255,255,.18);
      box-shadow: 0 12px 36px rgba(36,16,24,.22), 0 2px 8px rgba(232,23,93,.12),
                  inset 0 1px 0 rgba(255,255,255,.08);
      overflow: hidden;
      flex-shrink: 0;
    }
    .phone-shell-top {
      height: 20px; background: var(--brown);
      display: flex; align-items: center; justify-content: center;
      position: relative;
    }
    .phone-shell-top::before {
      content: ''; position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
      width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,.15);
    }
    .phone-shell-notch {
      width: 44px; height: 10px; background: #0e0408;
      border-radius: 0 0 8px 8px; margin-top: -10px;
    }
    .phone-shell-screen {
      width: 100%;
      aspect-ratio: 297 / 587;
      overflow: hidden; background: #000; display: block;
      position: relative;
    }
    .phone-shell-screen img {
      width: 100%; height: 100%; object-fit: cover;
      display: block;
    }
    .phone-shell-screen .feat-img-placeholder {
      position: absolute; inset: 0; width: 100%; height: 100%;
      background: linear-gradient(160deg, #1e0a14 0%, #120609 100%);
      display: flex; flex-direction: column; align-items: center;
      justify-content: center; gap: 8px; padding: 16px;
    }
    .phone-shell-screen .feat-img-placeholder svg {
      width: 28px; height: 28px; stroke: var(--pink-light);
      fill: none; stroke-width: 1.5; stroke-linecap: round;
      stroke-linejoin: round; opacity: .6;
    }
    .phone-shell-screen .feat-img-placeholder span {
      font-family: var(--font-head); font-size: .55rem; font-weight: 700;
      color: rgba(255,255,255,.4); text-align: center; letter-spacing: .04em;
    }
    .phone-shell-bottom {
      height: 16px; background: var(--brown);
      display: flex; align-items: center; justify-content: center;
    }
    .phone-shell-home {
      width: 32px; height: 3px; background: rgba(255,255,255,.2);
      border-radius: 99px;
    }

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

    #scrollTopBtn { position:fixed; bottom:32px; right:32px; z-index:999; width:50px; height:50px; border:none; border-radius:50%; background:var(--gradient-pink); color:white; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 24px rgba(232,23,93,.36); opacity:0; transform:translateY(16px) scale(.85); transition:opacity .3s ease,transform .3s ease,box-shadow .2s; pointer-events:none; }
    #scrollTopBtn.visible { opacity:1; transform:translateY(0) scale(1); pointer-events:auto; }
    #scrollTopBtn:hover { box-shadow:0 12px 32px rgba(232,23,93,.52); transform:translateY(-3px) scale(1.07); }
    #scrollTopBtn:active { transform:translateY(0) scale(.96); }
    #scrollTopBtn svg { width:22px; height:22px; stroke:white; fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; }

    @media(max-width:1060px){
      .features-grid { grid-template-columns:1fr; }
      .feat-card { grid-template-columns:1fr 1fr; }
      .feat-card.flip { direction:ltr; }
    }
    @media(max-width:960px){
      .nav-links{ display:none; }
      .nav-toggle{ display:inline-flex; flex-shrink:0; }
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
      <li><a href="{{ route('gallery') }}">Gallery</a></li>
      <li><a href="{{ route('home') }}#how">How it Works</a></li>
      <li><a href="{{ route('home') }}#about">About</a></li>
      <li><a href="{{ route('faqs') }}">FAQs</a></li>
      <li><a href="{{ route('home') }}#contact" class="nav-cta">Contact Us</a></li>
    </ul>
    <button class="nav-toggle" id="navToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileNav">
      <svg viewBox="0 0 24 24" aria-hidden="true"><line x1="4" y1="7" x2="20" y2="7"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="17" x2="20" y2="17"></line></svg>
    </button>
    <div class="mobile-nav" id="mobileNav">
      <a href="{{ route('gallery') }}">Gallery</a>
      <a href="{{ route('home') }}#how">How it Works</a>
      <a href="{{ route('home') }}#about">About</a>
      <a href="{{ route('faqs') }}">FAQs</a>
      <a href="{{ route('home') }}#contact">Contact Us</a>
    </div>
  </nav>
  <div class="header-spacer"></div>
</header>

<main>

  <section class="features-hero">
    <div class="features-hero-inner">
      <div>
        <div class="section-tag">Mobile Application</div>
        <h1 class="hero-headline">Everything a Tenant Needs,<br><em>In One App.</em></h1>
        <p class="hero-copy">DormEase gives Sanctissimo Rosario tenants a complete mobile experience!</p>
        <div class="hero-badges">
          <span class="hero-badge"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Secure & Private</span>
          <span class="hero-badge"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Real-time Updates</span>
          <span class="hero-badge"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>Voice Input</span>
          <span class="hero-badge"><svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Android & iOS</span>
        </div>
      </div>
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
              <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-family:var(--font-head);font-size:.48rem;font-weight:800;color:var(--brown);">Hi, Maria 👋</span>
                <div style="width:16px;height:16px;border-radius:50%;background:var(--gradient-pink);"></div>
              </div>
              <div style="background:var(--gradient-pink);border-radius:8px;padding:8px;margin-bottom:7px;">
                <div style="font-size:.35rem;color:rgba(255,255,255,.8);margin-bottom:2px;">Current Water Bill</div>
                <div style="font-family:var(--font-head);font-size:.7rem;font-weight:800;color:white;">₱ 320.00</div>
              </div>
              <div style="display:flex;gap:5px;margin-bottom:6px;">
                <div style="flex:1;background:var(--pink-pale);border:1px solid var(--border);border-radius:6px;padding:6px 5px;">
                  <div style="font-size:.32rem;color:var(--brown-light);margin-bottom:2px;">Requests</div>
                  <div style="font-family:var(--font-head);font-size:.52rem;font-weight:800;color:var(--brown);">2</div>
                </div>
                <div style="flex:1;background:var(--pink-pale);border:1px solid var(--border);border-radius:6px;padding:6px 5px;">
                  <div style="font-size:.32rem;color:var(--brown-light);margin-bottom:2px;">Announcements</div>
                  <div style="font-family:var(--font-head);font-size:.52rem;font-weight:800;color:var(--brown);">3</div>
                </div>
              </div>
              <div style="font-size:.35rem;font-weight:800;color:var(--pink-light);text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">Recent Activity</div>
              <div style="display:flex;align-items:center;gap:5px;padding:4px 0;border-bottom:1px solid var(--border);">
                <div style="width:6px;height:6px;border-radius:50%;background:var(--pink);flex-shrink:0;"></div>
                <div style="font-size:.36rem;color:var(--brown-light);flex:1;">Leaky faucet - Room 204</div>
                <div style="font-size:.28rem;font-weight:700;background:var(--pink-pale);color:var(--pink);padding:2px 5px;border-radius:99px;">In Progress</div>
              </div>
              <div style="display:flex;align-items:center;gap:5px;padding:4px 0;">
                <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;flex-shrink:0;"></div>
                <div style="font-size:.36rem;color:var(--brown-light);flex:1;">Water bill for May paid</div>
                <div style="font-size:.28rem;font-weight:700;background:rgba(34,197,94,.1);color:#16a34a;padding:2px 5px;border-radius:99px;">Done</div>
              </div>
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

  <section class="features-section">
    <div class="features-inner">
      <div class="features-grid">

        <div class="feat-card">
          <div class="feat-info">
            <div class="feat-number">Feature 01</div>
            <div class="feat-title">Dashboard</div>
            <p class="feat-desc">A personalized home screen showing your current water bill, pending request count, latest announcements, and quick-access buttons to every feature, all in one glance.</p>
            <div class="feat-tags"><span class="feat-tag">Overview</span><span class="feat-tag">Quick Access</span><span class="feat-tag">Personalized</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/upddashboard.png') }}" alt="Dashboard UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                  <span>Dashboard UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card flip" id="announcements">
          <div class="feat-info">
            <div class="feat-number">Feature 02</div>
            <div class="feat-title">Announcements</div>
            <p class="feat-desc">View all active announcements posted by the Administrator. Push notifications alert you the moment a new post goes live, so you never miss an important update.</p>
            <div class="feat-tags"><span class="feat-tag">Push Notifications</span><span class="feat-tag">Real-time</span><span class="feat-tag">Admin Posts</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/updannouncements.png') }}" alt="Announcements UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                  <span>Announcements UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card" id="maintenance">
          <div class="feat-info">
            <div class="feat-number">Feature 03</div>
            <div class="feat-title">Maintenance Request</div>
            <p class="feat-desc">Submit requests via typed text or voice input. You can also upload photos or capture images directly using your device's camera. Urgency and issue classification are processed automatically on the backend.</p>
            <div class="feat-tags"><span class="feat-tag">Voice Input</span><span class="feat-tag">Camera Capture</span><span class="feat-tag">Backend Processing</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/updmaintenance.png') }}" alt="Maintenance Request UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                  <span>Maintenance Request UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card flip">
          <div class="feat-info">
            <div class="feat-number">Feature 04</div>
            <div class="feat-title">Emergency Report</div>
            <p class="feat-desc">Quickly report emergencies using the alert button, text, or voice input. Upon submission, an immediate push notification is sent to the Administrator and Front Desk Staff so help can arrive fast.</p>
            <div class="feat-tags"><span class="feat-tag">Instant Alert</span><span class="feat-tag">Voice Input</span><span class="feat-tag">Staff Notified</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/updemergency.png') }}" alt="Emergency Report UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  <span>Emergency Report UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card" id="water-bill">
          <div class="feat-info">
            <div class="feat-number">Feature 05</div>
            <div class="feat-title">Water Bill</div>
            <p class="feat-desc">View your current billing amount, consumption breakdown, due date, and payment history. Pay directly via QR code using GCash or bank transfer and upload your proof of payment in the app, or pay via cash directly to the Admin.</p>
            <div class="feat-tags"><span class="feat-tag">GCash / Bank Transfer</span><span class="feat-tag">Cash to Admin</span><span class="feat-tag">QR Payment</span><span class="feat-tag">History</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/updwaterbill.png') }}" alt="Water Bill UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                  <span>Water Bill UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card flip" id="visitor">
          <div class="feat-info">
            <div class="feat-number">Feature 06</div>
            <div class="feat-title">Visitor Registration</div>
            <p class="feat-desc">Pre-register your expected visitors by entering their name, contact number, purpose of visit, ID type, and expected arrival time. Front Desk Staff can verify them quickly upon arrival.</p>
            <div class="feat-tags"><span class="feat-tag">Pre-registration</span><span class="feat-tag">Staff Verification</span><span class="feat-tag">Visitor Log</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/updvisitor.png') }}" alt="Visitor Registration UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  <span>Visitor Registration UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card">
          <div class="feat-info">
            <div class="feat-number">Feature 07</div>
            <div class="feat-title">Document Request</div>
            <p class="feat-desc">Request available administrative documents, fill out and submit fillable forms directly in the app, choose between digital or printed copies, and track your request status in real time.</p>
            <div class="feat-tags"><span class="feat-tag">Available Documents</span><span class="feat-tag">Fillable Forms</span><span class="feat-tag">Digital or Print</span><span class="feat-tag">Status Tracking</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/upddocuments.png') }}" alt="Document Request UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                  <span>Document Request UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

        <div class="feat-card flip">
          <div class="feat-info">
            <div class="feat-number">Feature 08</div>
            <div class="feat-title">Notifications</div>
            <p class="feat-desc">See all your push notifications in one place: announcement alerts, maintenance request updates, billing reminders, and document request status changes, all organized and timestamped.</p>
            <div class="feat-tags"><span class="feat-tag">Push Alerts</span><span class="feat-tag">All-in-one</span><span class="feat-tag">Timestamped</span></div>
          </div>
          <div class="feat-img-wrap">
            <div class="phone-shell">
              <div class="phone-shell-top"><div class="phone-shell-notch"></div></div>
              <div class="phone-shell-screen">
                <img src="{{ asset('images/features/updnotifs.png') }}" alt="Notifications UI"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="feat-img-placeholder" style="display:none">
                  <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/><line x1="12" y1="2" x2="12" y2="4"/></svg>
                  <span>Notifications UI</span>
                </div>
              </div>
              <div class="phone-shell-bottom"><div class="phone-shell-home"></div></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<footer>
  <div class="footer-inner">
    <div>
      <a href="{{ route('login') }}" class="footer-logo">
        <img src="{{ asset('images/logo.png') }}" alt="DormEase" onerror="this.style.display='none'">
        <span class="footer-logo-fb">Dorm<span>Ease</span></span>
      </a>
      <p class="footer-brand">A web and mobile dormitory management system for Sanctissimo Rosario Ladies Dormitory, Sampaloc, Manila.</p>
    </div>
    <div class="footer-col">
        <h4>Features</h4>
        <a href="#maintenance">Maintenance</a>
        <a href="#announcements">Announcements</a>
        <a href="#water-bill">Water Billing</a>
        <a href="#visitor">Visitor Log</a>
        <a href="{{ route('safety.features') }}">Safety Features</a>
    </div>
    <div class="footer-col"><h4>Dormitory</h4><a href="{{ route('home') }}#about">About</a><a href="{{ route('home') }}#gallery">Room Types</a><a href="{{ route('home') }}#about">Amenities</a><a href="{{ route('home') }}#contact">Location</a></div>
    <div class="footer-col"><h4>Contact</h4><a href="tel:+639175359723">+63 917 535 9723</a><a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">1229 Navarra St.</a><a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">Sampaloc, Manila</a></div>
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
        <a class="footer-social-icon" href="https://tiktok.com/@srbdormitory" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
          <img src="{{ asset('icons/tiktok.png') }}" alt="" onerror="this.style.display='none'">
        </a>
      </div>
      <div class="footer-links"><a href="{{ route('privacy') }}">Privacy Policy</a><a href="{{ route ('faqs') }}">FAQs</a><a href="{{ route('login') }}">Admin Portal</a></div>
    </div>
  </div>
</footer>

<button id="scrollTopBtn" aria-label="Scroll to top">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg>
</button>

<script>
  const nav = document.getElementById('navbar');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 20));
  const navToggle = document.getElementById('navToggle');
  const mobileNav = document.getElementById('mobileNav');
  if (navToggle && mobileNav) {
    navToggle.addEventListener('click', () => {
      const isOpen = mobileNav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', String(isOpen));
    });
    mobileNav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
      mobileNav.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
    }));
    document.addEventListener('click', (event) => {
      if (!nav.contains(event.target)) {
        mobileNav.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  const scrollTopBtn = document.getElementById('scrollTopBtn');
  window.addEventListener('scroll', () => scrollTopBtn.classList.toggle('visible', scrollY > 300));
  scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

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
