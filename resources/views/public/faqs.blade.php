<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQs: DormEase</title>
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
    .nav-links a { text-decoration:none; font-size:.98rem; font-weight:700; color:var(--brown); letter-spacing:.01em; transition:color 0.3s ease; position:relative; }
    .nav-links a::after { content:''; position:absolute; bottom:-4px; left:0; width:0; height:2.5px; border-radius:99px; background:var(--gradient-pink); transition:width 0.3s ease; }
    .nav-links a:hover::after, .nav-links a.nav-active::after { width:100%; }
    .nav-links a:hover, .nav-links a.nav-active { color:var(--pink); }
    .nav-cta { background:var(--gradient-pink) !important; color:white !important; padding:11px 26px !important; border-radius:100px !important; font-weight:700 !important; transition:filter .2s,transform .15s !important; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-cta:hover { filter:brightness(.94); transform:translateY(-1px); }
    .nav-toggle { display:none; width:44px; height:44px; border:0; border-radius:50%; background:var(--gradient-pink); color:white; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 8px 18px rgba(232,23,93,.24); }
    .nav-toggle svg { width:22px; height:22px; stroke:currentColor; fill:none; stroke-width:2.4; stroke-linecap:round; }
    .mobile-nav { display:none; position:absolute; top:calc(100% + 10px); left:0; right:0; padding:10px; background:rgba(255,228,240,.98); border:1.5px solid rgba(36,16,24,.55); border-radius:24px; box-shadow:0 18px 36px rgba(36,16,24,.16); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }
    .mobile-nav.open { display:grid; gap:4px; }
    .mobile-nav a { color:var(--brown); text-decoration:none; font-size:.95rem; font-weight:800; padding:12px 14px; border-radius:16px; }
    .mobile-nav a:hover, .mobile-nav a.nav-active { color:var(--pink); background:rgba(255,255,255,.62); }
    .header-spacer { height:154px; background:var(--cream); }

    .faq-hero { padding:70px 6% 52px; background:var(--cream); }
    .faq-hero-inner { max-width:1180px; margin:0 auto; }
    .section-tag { font-size:.72rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
    h1 { font-family:var(--font-head); font-size:clamp(2.35rem,4.6vw,4.4rem); line-height:1.08; color:var(--brown); letter-spacing:-.03em; max-width:880px; }
    h1 em { color:var(--pink); font-style:normal; }
    .hero-copy { color:var(--brown-light); font-size:1.05rem; line-height:1.8; max-width:680px; margin-top:22px; }

    .faq-section { padding:0 6% 100px; background:var(--cream); }
    .faq-inner { max-width:1180px; margin:0 auto; display:grid; grid-template-columns:1fr 1.72fr; gap:72px; align-items:start; }

    .faq-left { position:sticky; top:160px; opacity:0; transform:translateX(-20px); animation:faqLeftFade 0.85s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes faqLeftFade { to { opacity:1; transform:translateX(0); } }
    .faq-left-tag { font-size:.72rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:14px; }
    .faq-left-title { font-family:var(--font-head); font-size:clamp(2rem,3.2vw,3.1rem); line-height:1.1; font-weight:800; color:var(--brown); letter-spacing:-.03em; margin-bottom:18px; }
    .faq-left-title em { color:var(--pink); font-style:italic; }
    .faq-left-body { color:var(--brown-light); font-size:.96rem; line-height:1.78; margin-bottom:28px; }
    .faq-contact-link { display:inline-flex; align-items:center; gap:8px; font-family:var(--font-head); font-size:.88rem; font-weight:800; color:var(--pink); text-decoration:none; letter-spacing:.02em; transition:gap .2s; }
    .faq-contact-link:hover { gap:14px; }
    .faq-contact-link svg { width:16px; height:16px; stroke:currentColor; fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }

    .faq-list { display:flex; flex-direction:column; gap:12px; }
    .faq-item { background:white; border:1.5px solid var(--border); border-radius:var(--r-md); box-shadow:var(--shadow-card); overflow:hidden; transition:box-shadow 0.3s ease, border-color 0.3s ease, transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); scroll-margin-top: 140px; }
    .faq-item:hover { transform: translateY(-2px); border-color: rgba(232, 23, 93, 0.25); box-shadow: 0 6px 20px rgba(232, 23, 93, 0.08); }
    .faq-item.open:hover { transform: none; }
    .faq-item.open { border-color:rgba(232,23,93,.38); box-shadow:0 4px 28px rgba(232,23,93,.12); }
    .faq-btn { width:100%; background:none; border:none; cursor:pointer; padding:22px 26px; display:flex; align-items:center; justify-content:space-between; gap:18px; text-align:left; }
    .faq-question { font-family:var(--font-head); font-size:1rem; font-weight:700; color:var(--brown); line-height:1.35; flex:1; transition:color .2s; }
    .faq-item.open .faq-question { color:var(--pink); }
    .faq-icon { flex-shrink:0; width:34px; height:34px; border-radius:50%; border:1.5px solid var(--border); display:inline-flex; align-items:center; justify-content:center; transition:background .25s, border-color .25s, transform .3s; }
    .faq-icon svg { width:16px; height:16px; stroke:var(--brown-light); fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; transition:stroke .25s; }
    .faq-item.open .faq-icon { background:var(--gradient-pink); border-color:var(--pink); transform:rotate(180deg); }
    .faq-item.open .faq-icon svg { stroke:white; }
    .faq-answer { max-height:0; overflow:hidden; transition:max-height .4s cubic-bezier(.16,1,.3,1), padding .3s; }
    .faq-answer-inner { padding:0 26px 22px; color:var(--brown-light); font-size:.95rem; line-height:1.78; border-top:1px solid rgba(232,23,93,.10); padding-top:18px; opacity:0; transform:translateY(-8px); transition:opacity 0.3s ease, transform 0.3s ease; }
    .faq-item.open .faq-answer { max-height:600px; }
    .faq-item.open .faq-answer-inner { opacity:1; transform:translateY(0); transition-delay:0.1s; }

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
    #scrollTopBtn.visible { opacity:1; transform:translateY(0) scale(1); pointer-events:auto; }
    #scrollTopBtn:hover { box-shadow:0 12px 32px rgba(232,23,93,.52); transform:translateY(-3px) scale(1.07); }
    #scrollTopBtn:active { transform:translateY(0) scale(.96); }
    #scrollTopBtn svg { width:22px; height:22px; stroke:white; fill:none; stroke-width:2.4; stroke-linecap:round; stroke-linejoin:round; }

    @media(max-width:960px){
      .nav-links{display:none}
      .nav-toggle{display:inline-flex;flex-shrink:0}
      .footer-inner{grid-template-columns:1fr 1fr}
      .faq-inner{grid-template-columns:1fr; gap:40px;}
      .faq-left{position:static;}
    }
    @media(max-width:760px){
      nav{top:46px;height:auto;min-height:76px;padding:10px 5%;gap:14px;flex-wrap:wrap;border-radius:28px;width:calc(100% - 28px)}
      nav.scrolled{top:12px}
      .top-notice{font-size:.74rem;min-height:30px}
      .header-spacer{height:138px}
      .nav-logo img{height:44px}
      .nav-logo-fb{font-size:1.22rem}
      .nav-links{gap:0;margin-left:auto}
      .faq-hero{padding:72px 5% 44px}
      .faq-section{padding:0 5% 80px}
      .footer-btm{flex-direction:column;gap:16px;align-items:flex-start}
      .footer-btm-right{align-items:flex-start}
      #scrollTopBtn{bottom:22px;right:18px;width:44px;height:44px;}
    }
    @media(max-width:600px){
      .footer-inner{grid-template-columns:1fr}
      .faq-btn{padding:18px 20px;}
      .faq-answer-inner{padding:0 20px 18px;padding-top:16px;}
    }
    @media (max-width: 480px) {
      .faq-hero { padding: 48px 5% 36px; }
      .faq-section { padding: 0 5% 60px; }
      .faq-left-title { font-size: 2.1rem; }
      .faq-btn { padding: 16px 20px; }
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
      <li><a href="{{ route('faqs') }}" class="nav-active">FAQs</a></li>
      <li><a href="{{ route('home') }}#contact" class="nav-cta">Contact Us</a></li>
    </ul>
    <button class="nav-toggle" id="navToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileNav">
      <svg viewBox="0 0 24 24" aria-hidden="true"><line x1="4" y1="7" x2="20" y2="7"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="17" x2="20" y2="17"></line></svg>
    </button>
    <div class="mobile-nav" id="mobileNav">
      <a href="{{ route('gallery') }}">Gallery</a>
      <a href="{{ route('home') }}#how">How it Works</a>
      <a href="{{ route('home') }}#about">About</a>
      <a href="{{ route('faqs') }}" class="nav-active">FAQs</a>
      <a href="{{ route('home') }}#contact">Contact Us</a>
    </div>
  </nav>
  <div class="header-spacer"></div>
</header>

<main>
  <section class="faq-hero">
    <div class="faq-hero-inner">
      <div class="section-tag">Help Center</div>
      <h1>Frequently Asked <em>Questions</em></h1>
      <p class="hero-copy">Find answers to the most common questions about living at Sanctissimo Rosario Ladies Dormitory!</p>
    </div>
  </section>

  <section class="faq-section">
    <div class="faq-inner">

      <div class="faq-left">
        <div class="faq-left-tag">FAQs</div>
        <h2 class="faq-left-title">Dormitory <em>FAQs</em></h2>
        <p class="faq-left-body">Have a question that isn't answered here? Reach out to our dormitory management and we'll be happy to assist you directly.</p>
        <a href="{{ route('home') }}#contact" class="faq-contact-link">
          Contact us
          <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>

      <div class="faq-list" id="faqList">

        <div class="faq-item open">
          <button class="faq-btn" aria-expanded="true">
            <span class="faq-question">Who is eligible to stay at Sanctissimo Rosario Ladies Dormitory?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
<div class="faq-answer-inner">The dormitory is open to anyone, though it primarily caters to female students, particularly those enrolled at the University of Santo Tomas (UST) and nearby schools in Sampaloc, Manila. Applicants must present a valid school ID and enrollment certificate upon move-in. Priority is given to students who need safe and affordable housing close to their campus.</div>          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">What are the available room types and what is included?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">We offer single, double, and quad-sharing room configurations. Rooms are semi-furnished and come with a study table and bookshelves. Air conditioning units and other electrical appliances are not provided and must be brought and set up by the tenant. For the latest pricing per room type, please reach out to the management office through the Contact page.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">How does water billing work and is laundry available on-site?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
<div class="faq-answer-inner">Monthly rates typically cover water (up to a set consumption limit billed separately), electricity, Wi-Fi access, use of common areas, and building maintenance services. Water billing beyond the standard allowance is computed separately and reflected in your monthly statement through DormEase. Each room has its own private comfort room.</div>          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Is Wi-Fi available and how do I connect?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">We offer Globe Wi-Fi for <strong>₱300.00</strong> per device per month to connect to the building's internet connection. Alternatively, tenants are welcome to provide and set up their own Wi-Fi inside their rooms—just be sure to inform the Admin office.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">What is the curfew policy?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">The building gate is closed at 10:00 p.m. every night. No tenants will be allowed entry or allowed to leave after 10:00 p.m. unless they have a written approval of request (Curfew Slip) from the Admin office. Doctors undergoing residency training may be exempt upon proper written notification with the Admin office. Repeated violations of the curfew policy may result in a notice or penalty.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Are visitors allowed inside the dormitory?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Male visitors are strictly not allowed inside the units, including male relatives. Female guests are allowed provided they secure authorization from the Admin office. All visitors must log in and out with the guard at the main entrance for reasons of safety and security.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Can someone stay overnight with me in the dormitory?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Sleepovers are permitted exclusively for female friends or family members. Male overnight guests are strictly not allowed under any circumstances. To request a sleepover, the tenant must submit a <strong>Non-Tenant Sleepover Request</strong> through the DormEase app prior to the intended date. Once the request is reviewed and approved by management, a sleepover fee of <strong>₱200.00</strong> must be paid before the guest is permitted to stay. Unapproved overnight guests are a violation of dormitory policy and may result in a notice or penalty.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Is log in/log out required every time I enter or leave the building?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Yes. All tenants are required to log in and log out with the guard every time they enter or exit the building. This is a mandatory safety and security measure and applies at all times, regardless of the duration of your absence.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">What are the rules about keeping rooms clean and disposing of garbage?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Tenants are required to keep their rooms neat and clean at all times. Garbage disposal is the tenant's responsibility — trash must be regularly brought down to the ground floor under the stairs. Please keep lobbies and landings clear of personal belongings. Do not throw anything out of the window.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Are laundry and flat ironing allowed inside the dormitory?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Laundry inside the units is not allowed. Flat ironing is also strictly prohibited throughout the building to prevent fire hazards. Tenants are encouraged to use laundry services available near the dormitory.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">How does the maintenance request process work?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Tenants must submit a written report of any damages in the unit to the Admin office for repair and maintenance. You can also file a maintenance request directly through the DormEase app or web portal — describe the issue, specify the location, and submit. Management will review and assign it to the appropriate personnel, and you can track the status in real time through your tenant dashboard.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Is smoking or drinking alcohol allowed in the building?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">No. Smoking and drinking alcohol are strictly prohibited anywhere inside the building. This rule applies to tenants and any guests at all times to maintain a safe and respectful environment for all residents.</div>
          </div>
        </div>


        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">What coffee shops and convenience stores are nearby?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Cotti Coffee is located just downstairs, making it a convenient study spot or quick break option. CoffeePages and Uncle John's Convenience Store are also among the nearby establishments within easy walking distance from the dormitory.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">How much is the reservation fee and when does the contract start?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">A reservation fee equivalent to one month advance payment is required to secure a slot. Contracts typically start in August in line with the school year, but tenants may move in at any time of the year if a room is available. Please coordinate with the management office to check current availability.</div>
          </div>
        </div>


        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">Is there 24/7 security in the building?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">Yes. A guard is on duty at all times at the main lobby. The building is also equipped with CCTV cameras covering hallways and entry points, a biometric monitoring system for tenant arrivals and departures, and in-room intercoms connected directly to the guard station. These systems work together to ensure tenant safety around the clock.</div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn" aria-expanded="false">
            <span class="faq-question">How do I view and pay my water bill?</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
          </button>
          <div class="faq-answer">
<div class="faq-answer-inner">Water billing charges can be conveniently paid through the DormEase tenant portal, with statements generated and posted each billing cycle so you can review your consumption in detail. Electricity is billed directly through Meralco and is settled separately from the app. Rent payments are currently coordinated with the management office, though we're working on expanding the app to support this in the future. We recommend always keeping a record of your payment receipts.</div>          </div>
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
      <a href="{{ route('features') }}#maintenance">Maintenance</a>
      <a href="{{ route('features') }}#announcements">Announcements</a>
      <a href="{{ route('features') }}#water-billing">Water Billing</a>
      <a href="{{ route('features') }}#visitor-log">Visitor Log</a>
      <a href="{{ route('features') }}#emergency">Emergency</a>
      <a href="{{ route('safety.features') }}">Safety Features</a>
    </div>
    <div class="footer-col">
      <h4>Dormitory</h4>
      <a href="{{ route('home') }}#about">About</a>
      <a href="{{ route('home') }}#gallery">Room Types</a>
      <a href="{{ route('home') }}#about">Amenities</a>
      <a href="{{ route('home') }}#contact">Location</a>
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
        <a class="footer-social-icon" href="https://www.instagram.com/SRBdormitory" aria-label="Instagram">
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
  window.addEventListener('scroll', () => {
    scrollTopBtn.classList.toggle('visible', scrollY > 300);
  });
  scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  const items = document.querySelectorAll('.faq-item');
  items.forEach(item => {
    const btn = item.querySelector('.faq-btn');
    
    // Open FAQ on hover
    item.addEventListener('mouseenter', () => {
      items.forEach(i => {
        i.classList.remove('open');
        i.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
      });
      item.classList.add('open');
      btn.setAttribute('aria-expanded', 'true');
    });

    // Toggle FAQ on click (for mobile support)
    btn.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      items.forEach(i => {
        i.classList.remove('open');
        i.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
      });
      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });
</script>
</body>
</html>