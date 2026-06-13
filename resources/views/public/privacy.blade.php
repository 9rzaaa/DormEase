<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy Policy: DormEase</title>
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
    .nav-cta { background:var(--gradient-pink) !important; color:white !important; padding:11px 26px !important; border-radius:100px !important; font-weight:700 !important; transition:filter .2s,transform .15s !important; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-cta:hover { filter:brightness(.94); transform:translateY(-1px); }
    .nav-toggle { display:none; width:44px; height:44px; border:0; border-radius:50%; background:var(--gradient-pink); color:white; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-toggle svg { width:22px; height:22px; stroke:currentColor; fill:none; stroke-width:2.4; stroke-linecap:round; }
    .mobile-nav { display:none; position:absolute; top:calc(100% + 10px); left:0; right:0; padding:10px; background:rgba(255,228,240,.98); border:1.5px solid rgba(36,16,24,.55); border-radius:24px; box-shadow:0 18px 36px rgba(36,16,24,.16); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }
    .mobile-nav.open { display:grid; gap:4px; }
    .mobile-nav a { color:var(--brown); text-decoration:none; font-size:.95rem; font-weight:800; padding:12px 14px; border-radius:16px; display:block; }
    .mobile-nav a:hover { color:var(--pink); background:rgba(255,255,255,.62); }
    .header-spacer { height:154px; background:var(--cream); }

    .privacy-hero { padding:70px 6% 52px; background:var(--cream); }
    .privacy-hero-inner { max-width:1180px; margin:0 auto; }
    .section-tag { font-size:.72rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
    h1 { font-family:var(--font-head); font-size:clamp(2.35rem,4.6vw,4.4rem); line-height:1.08; color:var(--brown); letter-spacing:-.03em; max-width:880px; }
    h1 em { color:var(--pink); font-style:italic; }
    .hero-copy { color:var(--brown-light); font-size:1.05rem; line-height:1.8; max-width:680px; margin-top:22px; }
    .hero-meta { display:flex; align-items:center; gap:24px; margin-top:28px; flex-wrap:wrap; }
    .hero-meta-item { display:flex; align-items:center; gap:8px; font-size:.82rem; font-weight:700; color:var(--brown-light); }
    .hero-meta-item svg { width:15px; height:15px; stroke:var(--pink); fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }

    .privacy-section { padding:0 6% 100px; background:var(--cream); }
    .privacy-inner { max-width:1180px; margin:0 auto; display:grid; grid-template-columns:260px 1fr; gap:72px; align-items:start; }

    .privacy-nav { position:sticky; top:160px; }
    .privacy-nav-label { font-size:.66rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink-light); margin-bottom:14px; }
    .privacy-nav-list { display:flex; flex-direction:column; gap:4px; }
    .privacy-nav-link {
      display:block; text-decoration:none; font-size:.88rem; font-weight:700;
      color:var(--brown-light); padding:10px 14px; border-radius:12px;
      border-left:2.5px solid transparent; transition:all .2s;
    }
    .privacy-nav-link:hover { color:var(--pink); background:var(--pink-pale); border-left-color:var(--pink-light); }
    .privacy-nav-link.active { color:var(--pink); background:var(--pink-pale); border-left-color:var(--pink); }

    .privacy-content { display:flex; flex-direction:column; gap:48px; }

    .privacy-block { background:white; border:1.5px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--shadow-card); overflow:hidden; transition:box-shadow .25s; }
    .privacy-block:hover { box-shadow:0 4px 28px rgba(232,23,93,.10); }
    .privacy-block-header { padding:28px 32px 22px; border-bottom:1px solid rgba(232,23,93,.08); display:flex; align-items:center; gap:16px; }
    .privacy-block-icon { width:44px; height:44px; border-radius:12px; background:var(--pink-pale); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .privacy-block-icon svg { width:20px; height:20px; stroke:var(--pink); fill:none; stroke-width:1.9; stroke-linecap:round; stroke-linejoin:round; }
    .privacy-block-title { font-family:var(--font-head); font-size:1.1rem; font-weight:800; color:var(--brown); }
    .privacy-block-body { padding:24px 32px 30px; color:var(--brown-light); font-size:.95rem; line-height:1.82; }
    .privacy-block-body p + p { margin-top:14px; }
    .privacy-block-body ul { margin:14px 0 0 0; display:flex; flex-direction:column; gap:9px; list-style:none; }
    .privacy-block-body ul li { display:flex; gap:10px; }
    .privacy-block-body ul li::before { content:''; width:7px; height:7px; margin-top:9px; border-radius:50%; background:var(--pink-light); flex-shrink:0; }
    .privacy-block-body strong { color:var(--brown); font-weight:700; }

    .privacy-highlight { background:var(--gradient-pink); border-radius:var(--r-lg); padding:36px 40px; color:white; display:flex; align-items:flex-start; gap:20px; }
    .privacy-highlight-icon { width:48px; height:48px; border-radius:12px; background:rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .privacy-highlight-icon svg { width:22px; height:22px; stroke:white; fill:none; stroke-width:1.9; stroke-linecap:round; stroke-linejoin:round; }
    .privacy-highlight-title { font-family:var(--font-head); font-size:1.05rem; font-weight:800; color:white; margin-bottom:8px; }
    .privacy-highlight-body { font-size:.92rem; color:rgba(255,255,255,.82); line-height:1.78; }
    .privacy-highlight-body a { color:white; font-weight:700; }

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
    .footer-btm a:hover { color:var(--pink-light); }
    .footer-socials { display:flex; align-items:center; gap:12px; }
    .footer-social-icon { position:relative; width:46px; height:46px; border-radius:50%; background:#111; color:white; display:inline-flex; align-items:center; justify-content:center; overflow:hidden; border:1px solid rgba(255,255,255,.14); transition:transform .2s,background .2s,border-color .2s; text-decoration:none; }
    .footer-social-icon:hover { transform:translateY(-2px); background:var(--pink); border-color:var(--pink-light); }
    .footer-social-icon img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block; }

    #scrollTopBtn { position:fixed; bottom:32px; right:32px; z-index:999; width:50px; height:50px; border:none; border-radius:50%; background:var(--gradient-pink); color:white; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 24px rgba(232,23,93,.36); opacity:0; transform:translateY(16px) scale(.85); transition:opacity .3s ease,transform .3s ease,box-shadow .2s; pointer-events:none; }
    #scrollTopBtn.visible { opacity:1; transform:translateY(0) scale(1); pointer-events:auto; }
    #scrollTopBtn:hover { box-shadow:0 12px 32px rgba(232,23,93,.52); transform:translateY(-3px) scale(1.07); }
    #scrollTopBtn:active { transform:translateY(0) scale(.96); }
    #scrollTopBtn svg { width:22px; height:22px; stroke:white; fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; }

    @media(max-width:960px) {
      .nav-links { display:none; }
      .nav-toggle { display:inline-flex; flex-shrink:0; }
      .footer-inner { grid-template-columns:1fr 1fr; }
      .privacy-inner { grid-template-columns:1fr; gap:40px; }
      .privacy-nav { position:static; }
      .privacy-nav-list { flex-direction:row; flex-wrap:wrap; gap:8px; }
      .privacy-nav-link { border-left:none; border-bottom:2.5px solid transparent; padding:8px 14px; }
      .privacy-nav-link:hover, .privacy-nav-link.active { border-left:none; border-bottom-color:var(--pink); }
    }
    @media(max-width:760px) {
      nav { top:46px; height:auto; min-height:76px; padding:10px 5%; gap:14px; flex-wrap:wrap; border-radius:28px; width:calc(100% - 28px); }
      nav.scrolled { top:12px; }
      .top-notice { font-size:.74rem; min-height:30px; }
      .header-spacer { height:138px; }
      .nav-logo img { height:44px; }
      .nav-logo-fb { font-size:1.22rem; }
      .privacy-hero { padding:72px 5% 44px; }
      .privacy-section { padding:0 5% 80px; }
      .privacy-block-header { padding:22px 24px 18px; }
      .privacy-block-body { padding:20px 24px 26px; }
      .privacy-highlight { flex-direction:column; gap:14px; padding:28px 24px; }
      .footer-btm { flex-direction:column; gap:16px; align-items:flex-start; }
      .footer-btm-right { align-items:flex-start; }
      #scrollTopBtn { bottom:22px; right:18px; width:44px; height:44px; }
    }
    @media(max-width:600px) {
      .footer-inner { grid-template-columns:1fr; }
    }
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
      <svg viewBox="0 0 24 24" aria-hidden="true"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
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
  <section class="privacy-hero">
    <div class="privacy-hero-inner">
      <div class="section-tag">Legal</div>
      <h1>Privacy <em>Policy</em></h1>
      <p class="hero-copy">This Privacy Policy explains how DormEase and Sanctissimo Rosario Ladies Dormitory collect, use, and protect the personal information of tenants and visitors who use our platform.</p>
      <div class="hero-meta">
        <div class="hero-meta-item">
          <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Effective: January 1, 2026
        </div>
        <div class="hero-meta-item">
          <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Sanctissimo Rosario Ladies Dormitory
        </div>
      </div>
    </div>
  </section>

  <section class="privacy-section">
    <div class="privacy-inner">

      <nav class="privacy-nav" aria-label="Privacy sections">
        <div class="privacy-nav-label">On this page</div>
        <div class="privacy-nav-list">
          <a href="#info-collect" class="privacy-nav-link active">Information We Collect</a>
          <a href="#info-use" class="privacy-nav-link">How We Use It</a>
          <a href="#info-share" class="privacy-nav-link">Sharing of Information</a>
          <a href="#data-security" class="privacy-nav-link">Data Security</a>
          <a href="#your-rights" class="privacy-nav-link">Your Rights</a>
          <a href="#retention" class="privacy-nav-link">Data Retention</a>
          <a href="#changes" class="privacy-nav-link">Policy Changes</a>
          <a href="#contact" class="privacy-nav-link">Contact Us</a>
        </div>
      </nav>

      <div class="privacy-content">

        <div class="privacy-highlight">
          <div class="privacy-highlight-icon">
            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
          </div>
          <div>
            <div class="privacy-highlight-title">Your privacy is important to us</div>
            <div class="privacy-highlight-body">DormEase is used exclusively by tenants of Sanctissimo Rosario Ladies Dormitory. We only collect what is necessary to manage your tenancy and keep the dormitory running safely. We do not sell your data to third parties. For questions, contact us at <a href="tel:+639175359723">+63 917 535 9723</a>.</div>
          </div>
        </div>

        <div class="privacy-block" id="info-collect">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="privacy-block-title">Information We Collect</div>
          </div>
          <div class="privacy-block-body">
            <p>When you register as a tenant or use the DormEase platform, we collect the following categories of personal information:</p>
            <ul>
              <li><strong>Identity information:</strong> full name, school ID number, school name, and enrollment certificate details.</li>
              <li><strong>Contact information:</strong> mobile number and email address used for your account and notifications.</li>
              <li><strong>Room and tenancy information:</strong> your assigned room, floor, move-in date, lease terms, and payment history.</li>
              <li><strong>Maintenance and service requests:</strong> descriptions, voice recordings (when using voice input), and any media you submit with a request.</li>
              <li><strong>Visitor records:</strong> names, contact numbers, ID types, and visit details of visitors you pre-register through the app.</li>
              <li><strong>Billing information:</strong> water consumption data, billing amounts, payment proof uploads, and transaction records.</li>
              <li><strong>Device and usage data:</strong> device type, operating system, and general app usage patterns collected for platform improvement.</li>
            </ul>
          </div>
        </div>

        <div class="privacy-block" id="info-use">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
            </div>
            <div class="privacy-block-title">How We Use Your Information</div>
          </div>
          <div class="privacy-block-body">
            <p>The information collected through DormEase is used solely for dormitory management and tenant service purposes, including:</p>
            <ul>
              <li>Processing and managing your tenancy, room assignment, and lease agreement.</li>
              <li>Generating and delivering monthly water billing statements and payment records.</li>
              <li>Receiving, routing, and resolving maintenance and emergency reports.</li>
              <li>Sending push notifications for announcements, billing reminders, and request status updates.</li>
              <li>Managing and verifying visitor pre-registrations at the front desk.</li>
              <li>Processing document requests and generating administrative documents.</li>
              <li>Monitoring building safety through biometric arrival and departure logs.</li>
              <li>Improving the DormEase platform based on usage patterns.</li>
            </ul>
          </div>
        </div>

        <div class="privacy-block" id="info-share">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            </div>
            <div class="privacy-block-title">Sharing of Information</div>
          </div>
          <div class="privacy-block-body">
            <p>We do not sell, rent, or trade your personal information to any third party. Your data is only accessible to authorized dormitory personnel (the Administrator and Front Desk Staff) who need it to carry out their duties.</p>
            <p>We may disclose your information only in the following limited circumstances:</p>
            <ul>
              <li>When required by law, court order, or lawful request from a government authority.</li>
              <li>To protect the safety or security of tenants, staff, or the building.</li>
              <li>With your explicit written consent for a specific purpose.</li>
            </ul>
          </div>
        </div>

        <div class="privacy-block" id="data-security">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="privacy-block-title">Data Security</div>
          </div>
          <div class="privacy-block-body">
            <p>DormEase implements reasonable technical and organizational measures to protect your personal information from unauthorized access, disclosure, alteration, or destruction. These include:</p>
            <ul>
              <li>Secure authentication for all tenant and administrator accounts.</li>
              <li>Encrypted transmission of data between the app and our servers.</li>
              <li>Access controls that limit data visibility to authorized personnel only.</li>
              <li>Regular review of our data handling and security practices.</li>
            </ul>
            <p>While we take these precautions seriously, no system is completely immune to risk. We encourage tenants to keep their account credentials private and to log out of shared devices.</p>
          </div>
        </div>

        <div class="privacy-block" id="your-rights">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div class="privacy-block-title">Your Rights</div>
          </div>
          <div class="privacy-block-body">
            <p>As a tenant of Sanctissimo Rosario Ladies Dormitory, you have the following rights with respect to your personal information:</p>
            <ul>
              <li><strong>Access:</strong> you may request a copy of the personal data we hold about you.</li>
              <li><strong>Correction:</strong> you may request that inaccurate or outdated information be corrected.</li>
              <li><strong>Deletion:</strong> you may request deletion of your data after your tenancy ends, subject to legal and operational retention requirements.</li>
              <li><strong>Objection:</strong> you may object to specific uses of your data by contacting dormitory management directly.</li>
            </ul>
            <p>To exercise any of these rights, contact the dormitory office directly at <strong>+63 917 535 9723</strong> or visit us at 1229 Navarra Street, Sampaloc, Manila.</p>
          </div>
        </div>

        <div class="privacy-block" id="retention">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="privacy-block-title">Data Retention</div>
          </div>
          <div class="privacy-block-body">
            <p>We retain your personal information for as long as your tenancy is active and for a reasonable period afterward as required for administrative, legal, or dispute resolution purposes.</p>
            <p>Billing and payment records are retained in accordance with standard accounting and legal requirements. Visitor logs are retained for building safety and security review purposes. Maintenance and emergency request records are retained for service quality monitoring.</p>
            <p>Once retention periods expire, your data is securely deleted or anonymized.</p>
          </div>
        </div>

        <div class="privacy-block" id="changes">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.09"/></svg>
            </div>
            <div class="privacy-block-title">Changes to This Policy</div>
          </div>
          <div class="privacy-block-body">
            <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal obligations. When we do, the updated policy will be posted on the DormEase platform and the effective date at the top of this page will be revised.</p>
            <p>Continued use of DormEase after a policy update constitutes your acceptance of the revised terms. We encourage you to review this page periodically.</p>
          </div>
        </div>

        <div class="privacy-block" id="contact">
          <div class="privacy-block-header">
            <div class="privacy-block-icon">
              <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <div class="privacy-block-title">Contact Us</div>
          </div>
          <div class="privacy-block-body">
            <p>If you have questions, concerns, or requests regarding this Privacy Policy or the handling of your personal data, please reach out to the dormitory management directly:</p>
            <ul>
              <li><strong>Phone:</strong> <a href="tel:+639175359723" style="color:var(--pink);font-weight:700;">+63 917 535 9723</a></li>
              <li><strong>Address:</strong> 1229 Navarra Street, Sampaloc, Manila</li>
              <li><strong>Facebook:</strong> <a href="https://www.facebook.com/USTNavarra" target="_blank" rel="noopener noreferrer" style="color:var(--pink);font-weight:700;">facebook.com/USTNavarra</a></li>
              <li><strong>Instagram:</strong> <a href="https://www.instagram.com/SRBdormitory" target="_blank" rel="noopener noreferrer" style="color:var(--pink);font-weight:700;">@SRBdormitory</a></li>
            </ul>
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
        <img src="{{ asset('images/logo.png') }}" alt="DormEase" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        <span class="footer-logo-fb" style="display:none;">Dorm<span>Ease</span></span>
      </a>
      <p class="footer-brand">A web and mobile dormitory management system for Sanctissimo Rosario Ladies Dormitory, Sampaloc, Manila.</p>
    </div>
    <div class="footer-col">
      <h4>Features</h4>
      <a href="{{ route('features') }}#maintenance">Maintenance</a>
      <a href="{{ route('features') }}#announcements">Announcements</a>
      <a href="{{ route('features') }}#water-bill">Water Billing</a>
      <a href="{{ route('features') }}#visitor">Visitor Log</a>
      <a href="{{ route('features') }}#emergency">Emergency</a>
      <a href="{{ route('safety.features') }}">Safety Features</a>
    </div>
    <div class="footer-col">
      <h4>Dormitory</h4>
      <a href="{{ route('home') }}#about">About</a>
      <a href="{{ route('gallery') }}">Gallery</a>
      <a href="{{ route('gallery') }}">Amenities</a>
      <a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">Location</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="tel:+639175359723">+63 917 535 9723</a>
      <a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">1229 Navarra St.</a>
      <a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">Sampaloc, Manila</a>
    </div>
  </div>
  <div class="footer-btm">
    <span>&copy; 2026 DormEase: Sanctissimo Rosario Ladies Dormitory</span>
    <div class="footer-btm-right">
      <div class="footer-socials">
        <a class="footer-social-icon" href="https://www.facebook.com/USTNavarra" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
          <img src="{{ asset('icons/facebook.png') }}" alt="" onerror="this.style.display='none'">
        </a>
        <a class="footer-social-icon" href="https://www.instagram.com/SRBdormitory" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <img src="{{ asset('icons/instagram.png') }}" alt="" onerror="this.style.display='none'">
        </a>
        <a class="footer-social-icon" href="https://tiktok.com/@srbdormitory" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
          <img src="{{ asset('icons/tiktok.png') }}" alt="" onerror="this.style.display='none'">
        </a>
      </div>
      <div class="footer-links">
        <a href="{{ route('privacy') }}">Privacy Policy</a>
        <a href="{{ route('faqs') }}">FAQs</a>
        <a href="{{ route('login') }}">Admin Portal</a>
      </div>
    </div>
  </div>
</footer>

<button id="scrollTopBtn" aria-label="Scroll to top">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
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
    document.addEventListener('click', (e) => {
      if (!nav.contains(e.target)) {
        mobileNav.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  const scrollTopBtn = document.getElementById('scrollTopBtn');
  window.addEventListener('scroll', () => scrollTopBtn.classList.toggle('visible', scrollY > 300));
  scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  const navLinks = document.querySelectorAll('.privacy-nav-link');
  const sections = document.querySelectorAll('.privacy-block[id]');
  const sectionObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        navLinks.forEach(l => l.classList.remove('active'));
        const active = document.querySelector(`.privacy-nav-link[href="#${entry.target.id}"]`);
        if (active) active.classList.add('active');
      }
    });
  }, { rootMargin: '-20% 0px -70% 0px', threshold: 0 });
  sections.forEach(s => sectionObs.observe(s));
</script>
</body>
</html>