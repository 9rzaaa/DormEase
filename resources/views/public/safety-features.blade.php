<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Safety Features: DormEase</title>
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
    .nav-links a { text-decoration:none; font-size:.98rem; font-weight:700; color:var(--brown); letter-spacing:.01em; transition:color .2s,background .2s; }
    .nav-links a:hover { color:var(--pink); }
    .nav-cta { background:var(--gradient-pink) !important; color:white !important; padding:11px 26px !important; border-radius:100px !important; font-weight:700 !important; transition:filter .2s,transform .15s !important; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-cta:hover { filter:brightness(.94); transform:translateY(-1px); }
    .header-spacer { height:154px; background:var(--cream); }
    .safety-hero { padding:70px 6% 52px; background:var(--cream); }
    .safety-hero-inner { max-width:1180px; margin:0 auto; }
    .section-tag { font-size:.72rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
    h1 { font-family:var(--font-head); font-size:clamp(2.35rem,4.6vw,4.4rem); line-height:1.08; color:var(--brown); letter-spacing:-.03em; max-width:880px; }
    h1 em { color:var(--pink); font-style:italic; }
    .hero-copy { color:var(--brown-light); font-size:1.05rem; line-height:1.8; max-width:680px; margin-top:22px; }
    .slideshow-section { padding:0 6% 94px; background:var(--cream); }
    .slideshow-shell { max-width:1020px; margin:0 auto; background:white; border:1px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--shadow-soft); overflow:hidden; }
    .slide-stage { display:grid; grid-template-columns:minmax(0,1.12fr) minmax(300px,.88fr); min-height:440px; }
    .slide-media { background:white; display:flex; align-items:center; justify-content:center; padding:20px; }
    .slide-media img { width:100%; height:auto; display:block; border-radius:var(--r-md); box-shadow:0 14px 30px rgba(36,16,24,.10); }
    .slide-info { padding:38px 40px; display:flex; flex-direction:column; justify-content:center; }
    .slide-kicker { color:var(--pink); font-size:.72rem; font-weight:900; letter-spacing:.12em; text-transform:uppercase; margin-bottom:12px; }
    .slide-title { font-family:var(--font-head); font-size:clamp(1.65rem,2.7vw,2.45rem); line-height:1.1; font-weight:800; color:var(--brown); margin-bottom:16px; }
    .slide-body { color:var(--brown-light); font-size:.95rem; line-height:1.75; margin-bottom:24px; }
    .slide-list { display:grid; gap:9px; margin-bottom:0; }
    .slide-list span { display:flex; gap:9px; color:var(--brown); font-weight:700; font-size:.88rem; }
    .slide-list span::before { content:''; width:8px; height:8px; margin-top:9px; border-radius:50%; background:var(--pink-light); flex-shrink:0; }
    .slide-controls { display:flex; align-items:center; justify-content:center; gap:18px; margin:22px auto 0; }
    .slide-btn { width:46px; height:46px; border:none; border-radius:50%; background:var(--gradient-pink); color:white; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .slide-btn svg { width:20px; height:20px; stroke:currentColor; fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round; }
    .slide-count { font-family:var(--font-head); color:var(--brown-light); font-weight:800; font-size:.9rem; }
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
    .footer-social-fallback { font-family:var(--font-head); font-size:1rem; font-weight:900; letter-spacing:.02em; }

    #scrollTopBtn {
      position:fixed; bottom:32px; right:32px; z-index:999;
      width:50px; height:50px; border:none; border-radius:50%;
      background:var(--gradient-pink); color:white;
      display:inline-flex; align-items:center; justify-content:center;
      cursor:pointer; box-shadow:0 8px 24px rgba(232,23,93,.36);
      opacity:0; transform:translateY(16px) scale(.85);
      transition:opacity .3s ease, transform .3s ease, box-shadow .2s;
      pointer-events:none;
    }
    #scrollTopBtn.visible {
      opacity:1; transform:translateY(0) scale(1);
      pointer-events:auto;
    }
    #scrollTopBtn:hover {
      box-shadow:0 12px 32px rgba(232,23,93,.52);
      transform:translateY(-3px) scale(1.07);
    }
    #scrollTopBtn:active { transform:translateY(0) scale(.96); }
    #scrollTopBtn svg { width:22px; height:22px; stroke:white; fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; }
    @media(max-width:960px){
      .nav-links li:not(:last-child){display:none}
      .slide-stage{grid-template-columns:1fr}
      .footer-inner{grid-template-columns:1fr 1fr}
    }
    @media(max-width:760px){
      nav{top:46px;height:auto;min-height:76px;padding:10px 5%;gap:14px;flex-wrap:wrap;border-radius:28px;width:calc(100% - 28px)}
      nav.scrolled{top:12px}
      .top-notice{font-size:.74rem;min-height:30px}
      .header-spacer{height:138px}
      .nav-logo img{height:44px}
      .nav-logo-fb{font-size:1.22rem}
      .nav-links{gap:0;margin-left:auto}
      .safety-hero{padding:72px 5% 54px}
      .slideshow-section{padding:0 5% 80px}
      .slide-info{padding:34px 26px}
      .footer-btm{flex-direction:column;gap:16px;align-items:flex-start}
      .footer-btm-right{align-items:flex-start}
      #scrollTopBtn { bottom:22px; right:18px; width:44px; height:44px; }
    }
    @media(max-width:600px){
      .footer-inner{grid-template-columns:1fr}
      .slide-media{padding:12px}
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
  </nav>
  <div class="header-spacer"></div>
</header>

<main>
  <section class="safety-hero">
    <div class="safety-hero-inner">
      <div class="section-tag">Building Safety</div>
      <h1>A Guide to <em>Sanctissiomo Rosario</em> Building's Safety Features</h1>
      <p class="hero-copy">Review the safety systems, building rules, and tenant support areas that help keep Sanctissimo Rosario Ladies Dormitory organized, monitored, and secure.</p>
    </div>
  </section>

  <section class="slideshow-section">
    <div class="slideshow-shell">
      <div class="slide-stage">
        <div class="slide-media">
          <img id="slideImage" src="{{ asset('images/f2.jpg') }}" alt="Sanctissimo safety feature">
        </div>
        <div class="slide-info">
          <div class="slide-kicker" id="slideKicker">Location Safety</div>
          <h2 class="slide-title" id="slideTitle">Nearby Barangay Outpost and Tricycle Terminal</h2>
          <p class="slide-body" id="slideBody">The dormitory is positioned near helpful neighborhood points, including a barangay outpost and a tricycle terminal for nearby transport access.</p>
          <div class="slide-list" id="slideList"></div>
        </div>
      </div>
    </div>
    <div class="slide-controls">
      <button class="slide-btn" type="button" id="prevSlide" aria-label="Previous safety feature"><svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"></path></svg></button>
      <div class="slide-count" id="slideCount">1 / 7</div>
      <button class="slide-btn" type="button" id="nextSlide" aria-label="Next safety feature"><svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"></path></svg></button>
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
      <a class="footer-social-icon" href="https://www.instagram.com/SRBdormitory?fbclid=IwY2xjawR1agFleHRuA2FlbQIxMABicmlkETFSMGd2UUk5MFBOMmltNUFuc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHm3CWQe1WuTvPBmFvhFx21eNhAD0Y0JvuJhC5csQx8pZ743hf2XciRZ6CKtT_aem_C2XJTMgOF6fVl_8IZKtidQ" aria-label="Instagram">
        <img src="{{ asset('icons/instagram.png') }}" alt="" onerror="this.style.display='none'">
      </a>
      <a class="footer-social-icon" href="https://l.facebook.com/l.php?u=https%3A%2F%2Ftiktok.com%2F%40srbdormitory%3Ffbclid%3DIwZXh0bgNhZW0CMTAAYnJpZBExUjBndlFJOTBQTjJpbTVBbnNydGMGYXBwX2lkEDIyMjAzOTE3ODgyMDA4OTIAAR6_VD_SV6fgSa0DXK4qeWb12Ne2lLBJb3G41h5iz8rzZUjFq372zpT3q8ls0g_aem_9JUss0K1Lc7HjetMsE4voA&h=AUDRue1ADoYkZA6tVa6ikWVG8ujEpdIZMrpxzczAeWIhOpmRnEhV3IRWDokouMeG0yF_vyQsoztM2tgpcrMEqluI-XTDcAmfFZi035sm-pFYQRrSvR8MsbVDjhygV88LNg7M" aria-label="TikTok">
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
  const nav = document.getElementById('navbar');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 20));

  const scrollTopBtn = document.getElementById('scrollTopBtn');
  window.addEventListener('scroll', () => {
    scrollTopBtn.classList.toggle('visible', scrollY > 300);
  });
  scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  const slides = [
    { image: "{{ asset('images/f2.jpg') }}", kicker: "Location Safety", title: "Nearby Barangay Outpost and Tricycle Terminal", body: "The dormitory is positioned near helpful neighborhood points, including a barangay outpost and a tricycle terminal for nearby transport access.", points: ["Barangay outpost nearby", "Tricycle terminal beside the area", "Accessible street-level location"] },
    { image: "{{ asset('images/f3.jpg') }}", kicker: "Curfew Control", title: "Gate Closed at 10:00 p.m.", body: "The building gate is closed every night at curfew to help manage access and protect tenants inside the dormitory.", points: ["Nightly 10:00 p.m. curfew", "Controlled building entry", "Main gate access management"] },
    { image: "{{ asset('images/f4.jpg') }}", kicker: "Lobby Monitoring", title: "Biometric, CCTV, and Guard on Duty", body: "The lobby area supports daily monitoring through tenant biometric logs, CCTV coverage, and a guard stationed for building support.", points: ["Biometric arrival and departure monitoring", "CCTV directed outside the building", "24/7 guard on duty"] },
    { image: "{{ asset('images/f5.jpg') }}", kicker: "Visitor Control", title: "Visitor Area and Unit Restrictions", body: "Visitors are managed in a designated area, with clear rules that help maintain privacy and safety inside tenant units.", points: ["Designated visitor waiting area", "No male visitors allowed inside units", "Clear house rules for guests"] },
    { image: "{{ asset('images/f6.jpg') }}", kicker: "Per-Floor Safety", title: "CCTV, Emergency Lights, Fire Hose, and Alarm", body: "Each floor includes safety equipment and monitoring features that support emergency readiness throughout the building.", points: ["CCTV overlooking hallways", "Emergency lights", "Fire hose cabinet and fire alarm"] },
    { image: "{{ asset('images/f7.jpg') }}", kicker: "Exit Access", title: "Fire Escape, Stairway, and Elevator", body: "Each floor provides practical movement and exit routes, including stairway access, fire escape access, and elevator service.", points: ["Fire escape access", "Stairway route", "Elevator access"] },
    { image: "{{ asset('images/f8.jpg') }}", kicker: "Room Support", title: "Room Intercom Connected to the Guard Station", body: "Rooms include intercom access connected to the guard station, giving tenants a direct way to reach building support when needed.", points: ["In-room intercom", "Connected to guard station", "Quick tenant-to-frontdesk communication"] }
  ];

  let currentSlide = 0;
  const image = document.getElementById('slideImage');
  const kicker = document.getElementById('slideKicker');
  const title = document.getElementById('slideTitle');
  const body = document.getElementById('slideBody');
  const list = document.getElementById('slideList');
  const count = document.getElementById('slideCount');

  function renderSlide(index) {
    const slide = slides[index];
    image.src = slide.image;
    image.alt = slide.title;
    kicker.textContent = slide.kicker;
    title.textContent = slide.title;
    body.textContent = slide.body;
    list.innerHTML = slide.points.map(point => `<span>${point}</span>`).join('');
    count.textContent = `${index + 1} / ${slides.length}`;
  }

  document.getElementById('prevSlide').addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    renderSlide(currentSlide);
  });

  document.getElementById('nextSlide').addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % slides.length;
    renderSlide(currentSlide);
  });

  renderSlide(currentSlide);
</script>
</body>
</html>
