<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DormEase: Sanctissimo Rosario Ladies Dormitory</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --pink-1:      #E8175D;
      --pink-2:      #FF2D78;
      --gradient-pink: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
      --soft-bg:     #fff7fb;
      --pink:        var(--pink-1);
      --pink-light:  #FF7FB0;
      --pink-pale:   #FFE4F0;
      --pink-deep:   #8A123B;
      --cream:       var(--soft-bg);
      --cream-dark:  #FFEAF3;
      --brown:       #241018;
      --brown-mid:   #5A2638;
      --brown-light: #744B5D;
      --white:       #FFFFFF;
      --border:      rgba(232,23,93,0.18);
      --font-head:   'Montserrat', 'Segoe UI', sans-serif;
      --font-body:   'Nunito', 'Google Sans', sans-serif;
      --shadow-soft: 0 4px 32px rgba(232,23,93,0.16);
      --shadow-card: 0 2px 20px rgba(36,16,24,0.09);
      --r-sm: 8px; --r-md: 16px; --r-lg: 28px; --r-xl: 48px;
    }

    html { scroll-behavior: smooth; }
    body { font-family: var(--font-body); background: var(--cream); color: var(--brown); overflow-x: hidden; line-height: 1.6; }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
    }

    .site-header {
      position: relative;
      background: var(--pink-pale);
      border-bottom: 1px solid rgba(232,23,93,0.12);
    }

    nav {
      position: fixed; top: 54px; left: 50%; z-index: 100;
      width: min(1220px, calc(100% - 12%));
      transform: translateX(-50%);
      background: rgba(255,228,240,0.96);
      backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
      border: 1.5px solid rgba(36,16,24,0.78);
      border-radius: 999px;
      padding: 0 38px; height: 86px;
      display: flex; align-items: center; justify-content: space-between;
      transition: top 0.25s ease, box-shadow 0.3s;
    }
    nav.scrolled { top: 18px; box-shadow: 0 16px 34px rgba(36,16,24,0.12); }

    .top-notice {
      position: absolute; top: 0; left: 0; right: 0; z-index: 101;
      min-height: 34px; display: flex; align-items: center; justify-content: center;
      padding: 6px 5%; background: var(--gradient-pink); color: white;
      font-family: var(--font-head); font-size: .86rem; font-weight: 800; text-align: center;
    }

    .nav-logo { display: flex; align-items: center; text-decoration: none; gap: 10px; }
    .nav-logo img { height: 58px; width: auto; object-fit: contain; display: block; background: var(--gradient-pink); border-radius: 50%; padding: 8px; filter: drop-shadow(0 2px 7px rgba(36,16,24,0.22)); }
    .nav-logo-fb { font-family: var(--font-head); font-size: 1.55rem; font-weight: 800; color: var(--brown); letter-spacing: -0.02em; }
    .nav-logo-fb span { color: var(--pink); }

    .nav-links { display: flex; align-items: center; gap: 30px; list-style: none; }
    .nav-links a { text-decoration: none; font-size: .98rem; font-weight: 700; color: var(--brown); letter-spacing: 0.01em; transition: color 0.2s; }
    .nav-links a:hover { color: var(--pink); }
    .nav-links a.nav-active { color: var(--pink); position: relative; }
    .nav-links a.nav-active::after { content: ''; position: absolute; bottom: -4px; left: 0; right: 0; height: 2.5px; border-radius: 99px; background: var(--gradient-pink); }
    .nav-cta {
      background: var(--gradient-pink) !important; color: white !important;
      padding: 11px 26px !important; border-radius: 100px !important;
      font-weight: 700 !important; transition: filter 0.2s, transform 0.15s !important;
      box-shadow: 0 8px 18px rgba(232,23,93,0.24);
    }
    .nav-cta:hover { filter: brightness(0.94); transform: translateY(-1px); }

    .nav-toggle {
      display: none; width: 44px; height: 44px; border: 0; border-radius: 50%;
      background: var(--gradient-pink); color: white; align-items: center; justify-content: center;
      cursor: pointer; box-shadow: 0 8px 18px rgba(232,23,93,0.24); flex-shrink: 0;
    }
    .nav-toggle svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 2.4; stroke-linecap: round; }

    .mobile-nav {
      display: none; position: absolute; top: calc(100% + 10px); left: 0; right: 0;
      padding: 10px; background: rgba(255,228,240,0.98);
      border: 1.5px solid rgba(36,16,24,0.55); border-radius: 24px;
      box-shadow: 0 18px 36px rgba(36,16,24,0.16);
      backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
    }
    .mobile-nav.open { display: grid; gap: 4px; }
    .mobile-nav a {
      color: var(--brown); text-decoration: none; font-size: .95rem; font-weight: 800;
      padding: 12px 14px; border-radius: 16px; display: block;
    }
    .mobile-nav a:hover, .mobile-nav a.nav-active { color: var(--pink); background: rgba(255,255,255,0.62); }

    .header-info-strip { padding: 154px 6% 16px; background: var(--pink-pale); border-bottom: 1px solid rgba(232,23,93,0.12); }
    .header-info-inner { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: repeat(4,1fr); }
    .header-info-item {
      display: grid; grid-template-columns: 46px 1fr; gap: 16px; align-items: center;
      padding: 0 24px; border-left: 1px solid rgba(36,16,24,0.20);
    }
    .header-info-item:last-child { border-right: 1px solid rgba(36,16,24,0.20); }
    .header-info-icon { width: 46px; height: 46px; border-radius: 50%; background: white; color: var(--pink); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 18px rgba(232,23,93,0.10); }
    .header-info-icon svg { width: 24px; height: 24px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
    .header-info-title { font-family: var(--font-head); font-size: .98rem; font-weight: 800; color: var(--brown); line-height: 1.25; }
    .header-info-text { font-size: .82rem; color: var(--brown-light); line-height: 1.45; margin-top: 3px; }

    .hero {
      min-height: 100svh; padding: 0 5% 0 8%;
      display: grid; grid-template-columns: 1fr 1fr; align-items: center;
      gap: 48px; position: relative; overflow: hidden; background: var(--cream);
    }

    .hero-bg-lines {
      position: absolute; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
    }
    .hero-bg-lines::before {
      content: '';
      position: absolute; top: -20%; left: -10%; width: 120%; height: 140%;
      background:
        repeating-linear-gradient(
          -45deg,
          transparent,
          transparent 60px,
          rgba(232,23,93,0.03) 60px,
          rgba(232,23,93,0.03) 61px
        );
      animation: lineDrift 20s linear infinite;
    }
    @keyframes lineDrift {
      0% { transform: translate(0,0); }
      100% { transform: translate(61px, 61px); }
    }

    .hero-content { position: relative; z-index: 2; padding: 100px 0 80px; }

    .hero h1 {
      font-family: var(--font-head);
      font-size: clamp(2.8rem,4.5vw,4.2rem);
      font-weight: 800; line-height: 1.08;
      color: var(--brown); margin-bottom: 22px; letter-spacing: -0.03em;
    }
    .hero h1 em { font-style: italic; color: var(--pink); font-weight: 700; }

    .hero-title-word {
      display: inline-block;
      opacity: 0;
      transform: translateY(40px) skewY(3deg);
      animation: wordReveal 0.7s cubic-bezier(0.22,1,0.36,1) forwards;
    }
    @keyframes wordReveal {
      to { opacity: 1; transform: translateY(0) skewY(0deg); }
    }

    .hero-sub {
      font-size: 0.97rem; color: var(--brown-light); line-height: 1.85;
      max-width: 420px; margin-bottom: 36px;
      opacity: 0; animation: fadeUp 0.7s 0.5s ease forwards;
    }
    .hero-actions {
      display: flex; gap: 14px; align-items: center; flex-wrap: wrap; margin-bottom: 44px;
      opacity: 0; animation: fadeUp 0.7s 0.65s ease forwards;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .btn-primary {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--gradient-pink); color: white; text-decoration: none;
      font-family: var(--font-body); font-size: 0.9rem; font-weight: 700;
      padding: 14px 32px; border-radius: 100px;
      transition: filter 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 8px 24px rgba(232,23,93,0.32);
      position: relative; overflow: hidden;
    }
    .btn-primary::after {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.18) 50%, transparent 70%);
      transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .btn-primary:hover::after { transform: translateX(100%); }
    .btn-primary:hover { filter: brightness(0.94); transform: translateY(-2px); }
    .btn-outline {
      display: inline-flex; align-items: center; gap: 8px;
      background: transparent; color: var(--brown); text-decoration: none;
      font-family: var(--font-body); font-size: 0.9rem; font-weight: 600;
      padding: 13px 28px; border-radius: 100px; border: 1.5px solid rgba(58,32,16,0.20);
      transition: border-color 0.2s, color 0.2s;
    }
    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }

    .hero-stats {
      display: grid; grid-template-columns: repeat(3, 1fr);
      gap: 16px; margin-top: 32px; padding-top: 28px;
      border-top: 1px solid var(--border);
      opacity: 0; animation: fadeUp 0.7s 0.8s ease forwards;
    }
    .hero-stat-item {
      display: flex; flex-direction: column; gap: 4px;
      padding: 14px 16px; background: white;
      border: 1px solid var(--border); border-radius: 16px;
      cursor: pointer;
      position: relative; overflow: hidden;
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s;
    }
    .hero-stat-item::before {
      content: '';
      position: absolute; inset: 0;
      background: var(--gradient-pink);
      opacity: 0; transition: opacity 0.3s ease;
      z-index: 0;
    }
    .hero-stat-item:hover {
      transform: translateY(-4px) scale(1.03);
      box-shadow: 0 14px 32px rgba(232,23,93,0.22);
      border-color: var(--pink-light);
    }
    .hero-stat-item:hover::before { opacity: 1; }
    .hero-stat-item:hover .hero-stat-number,
    .hero-stat-item:hover .hero-stat-label {
      color: white;
    }
    .hero-stat-number, .hero-stat-label {
      position: relative; z-index: 1;
      transition: color 0.3s ease;
    }
    .hero-stat-number {
      font-family: var(--font-head); font-size: 1.6rem; font-weight: 800;
      color: var(--pink); line-height: 1; letter-spacing: -0.03em;
    }
    .hero-stat-label {
      font-size: 0.72rem; font-weight: 700; color: var(--brown-light);
      text-transform: uppercase; letter-spacing: 0.07em;
    }

    .hero-arch-wrap {
      position: relative; display: flex; justify-content: center; align-items: center;
      height: 100%; min-height: 100svh; z-index: 1;
    }
    .hero-blob-top {
      position: absolute; top: 12%; right: 4%; width: 220px; height: 200px;
      background: var(--pink-light); border-radius: 60% 80% 40% 70% / 50% 60% 80% 40%;
      opacity: 0.40; z-index: 0;
    }
    .hero-blob-bottom {
      position: absolute; bottom: 14%; left: 2%; width: 160px; height: 150px;
      background: var(--pink-pale); border-radius: 70% 40% 60% 50% / 60% 80% 40% 70%;
      opacity: 0.75; z-index: 0;
    }

    .hero-arch {
      position: relative; z-index: 1; width: 380px; height: 520px;
      border-radius: 220px 220px 36px 36px; overflow: hidden;
      box-shadow: 0 40px 90px rgba(58,32,16,0.16), 0 0 0 10px rgba(214,56,104,0.07);
      opacity: 0; animation: archReveal 1s 0.3s cubic-bezier(0.22,1,0.36,1) forwards;
    }
    @keyframes archReveal {
      from { opacity: 0; transform: scale(0.92) translateY(30px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .hero-arch img {
      width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block;
      filter: brightness(0.93) saturate(0.90);
      transition: transform 0.8s cubic-bezier(0.22,1,0.36,1);
    }
    .hero-arch:hover img { transform: scale(1.06); }

    .hero-arch-ring {
      position: absolute; z-index: 0;
      width: 420px; height: 560px;
      border-radius: 230px 230px 46px 46px;
      border: 1.5px dashed rgba(232,23,93,0.22);
      top: 50%; left: 50%; transform: translate(-50%,-50%);
      animation: ringPulse 4s ease-in-out infinite;
    }
    @keyframes ringPulse {
      0%, 100% { opacity: 0.5; transform: translate(-50%,-50%) scale(1); }
      50% { opacity: 1; transform: translate(-50%,-50%) scale(1.02); }
    }

    section { padding: 100px 6%; }
    .section-tag { font-size:.70rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
    .section-title { font-family:var(--font-head); font-size:clamp(1.8rem,3.2vw,2.8rem); font-weight:800; line-height:1.15; color:var(--brown); letter-spacing:-.03em; margin-bottom:18px; }
    .section-title em { color:var(--pink); font-style:italic; font-weight:700; }
    .section-sub { font-size:1rem; color:var(--brown-light); line-height:1.8; max-width:540px; }

    .gallery { background:var(--cream-dark); padding-top:80px; padding-bottom:80px; }
    .gallery-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:24px; margin-top:48px; }
    .gal-item {
      border-radius:var(--r-lg); overflow:hidden; position:relative; background:white;
      box-shadow:var(--shadow-card);
      transition: transform 0.4s cubic-bezier(0.22,1,0.36,1), box-shadow 0.4s ease;
    }
    .gal-item { cursor: pointer; }
    .gal-item:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(36,16,24,0.14); border-color: var(--pink-light); }
    .gal-img-wrap { overflow:hidden; width:100%; aspect-ratio:1/1; }
    .gal-img { width:100%; height:100%; object-fit:cover; object-position:center; display:block; transition:transform .6s cubic-bezier(0.22,1,0.36,1); }
    .gal-item:hover .gal-img { transform:scale(1.08); }
    .gal-label { padding:16px 20px 20px; background:white; }
    .gal-label-top { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
    .gal-badge { background:var(--gradient-pink); color:white; font-size:0.68rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; padding:4px 12px; border-radius:100px; }
    .gal-occupants { font-size:0.82rem; color:var(--brown-light); font-weight:600; }
    .gal-title { font-family:var(--font-head); font-size:1rem; font-weight:700; color:var(--brown); margin-bottom:4px; }
    .gal-desc { font-size:0.85rem; color:var(--brown-light); line-height:1.7; }
    .gal-item-overlay { display: none; }

    .how { background:var(--cream); position:relative; overflow:hidden; }
    .how::before { content:''; position:absolute; top:-200px; right:-200px; width:500px; height:500px; border-radius:50%; background:rgba(214,56,104,0.04); }
    .how-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
    .steps { display:flex; flex-direction:column; gap:18px; }
    .step {
      display:flex; gap:20px; align-items:flex-start;
      padding: 22px 24px; background: white; border-radius: var(--r-lg);
      border: 1px solid var(--border);
      box-shadow: var(--shadow-card);
      position: relative; overflow: hidden;
      transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .step::before {
      content: '';
      position: absolute; top: 0; left: 0; bottom: 0; width: 4px;
      background: var(--gradient-pink);
      transform: scaleY(0); transform-origin: bottom;
      transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
    }
    .step:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 38px rgba(232,23,93,0.14);
      border-color: var(--pink-light);
    }
    .step:hover::before { transform: scaleY(1); }
    .step-num {
      width:46px; height:46px; background:var(--gradient-pink); color:white;
      border-radius:16px; display:flex; align-items:center; justify-content:center;
      font-family:var(--font-head); font-size:1.1rem; font-weight:800; flex-shrink:0;
      box-shadow: 0 8px 18px rgba(232,23,93,0.28);
      transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
    }
    .step:hover .step-num { transform: rotate(-8deg) scale(1.08); }
    .step-title { font-family:var(--font-head); font-size:1.05rem; font-weight:800; color:var(--brown); margin-bottom:6px; letter-spacing:-0.01em; }
    .step-desc { font-size:.87rem; color:var(--brown-light); line-height:1.75; }
    .how-img-main { background:white; border-radius:var(--r-xl); box-shadow:var(--shadow-soft); padding:36px 28px; text-align:center; }

    .de-mockup-wrap {
      background: var(--pink-pale); border-radius: 20px;
      padding: 32px 16px 24px; display: flex;
      align-items: flex-end; justify-content: center; gap: 14px;
    }
    .de-phone {
      background: #fff; border-radius: 28px; border: 2.5px solid var(--brown);
      box-shadow: 0 12px 32px rgba(36,16,24,0.15); overflow: hidden;
      flex-shrink: 0; position: relative; display: flex; flex-direction: column;
    }
    .de-phone.side { width: 128px; height: 272px; }
    .de-phone.center {
      width: 150px; height: 320px; transform: translateY(-20px);
      border-color: var(--pink); box-shadow: 0 20px 48px rgba(232,23,93,0.22);
    }
    .de-notch { position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 44px; height: 9px; background: var(--brown); border-radius: 0 0 7px 7px; z-index: 10; }
    .de-screen { width: 100%; height: 100%; display: flex; flex-direction: column; background: var(--cream); }
    .de-statusbar { display: flex; justify-content: space-between; align-items: center; padding: 12px 10px 3px; font-size: 7.5px; font-weight: 700; color: var(--brown); font-family: var(--font-head); }
    .de-bars { display: flex; gap: 2px; align-items: flex-end; }
    .de-bar { width: 3px; border-radius: 1px; background: var(--brown); }
    .de-header { padding: 3px 10px 7px; display: flex; justify-content: space-between; align-items: center; }
    .de-greeting { font-size: 7.5px; color: var(--brown-light); font-weight: 600; }
    .de-name { font-size: 10px; font-weight: 800; color: var(--brown); font-family: var(--font-head); }
    .de-avatar { width: 22px; height: 22px; border-radius: 50%; background: var(--gradient-pink); display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; color: #fff; font-family: var(--font-head); }
    .de-bill-card { margin: 0 9px 7px; background: var(--gradient-pink); border-radius: 9px; padding: 9px 11px; }
    .de-bill-label { font-size: 6.5px; color: rgba(255,255,255,0.78); font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 2px; }
    .de-bill-amount { font-size: 15px; font-weight: 800; color: #fff; font-family: var(--font-head); line-height: 1; }
    .de-stats-row { display: flex; gap: 5px; padding: 0 9px 7px; }
    .de-stat { flex: 1; background: #fff; border-radius: 7px; padding: 6px 7px; border: 1px solid var(--border); }
    .de-stat-lbl { font-size: 6px; color: var(--brown-light); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px; }
    .de-stat-num { font-size: 12px; font-weight: 800; color: var(--brown); font-family: var(--font-head); line-height: 1; }
    .de-section-lbl { font-size: 6.5px; font-weight: 700; color: var(--brown-light); text-transform: uppercase; letter-spacing: 0.07em; padding: 0 9px 4px; }
    .de-activity { display: flex; flex-direction: column; gap: 4px; padding: 0 9px; }
    .de-act-item { display: flex; align-items: center; gap: 5px; background: #fff; border-radius: 6px; padding: 5px 7px; border: 1px solid var(--border); }
    .de-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .de-act-text { font-size: 6.5px; color: var(--brown); font-weight: 600; flex: 1; line-height: 1.3; }
    .de-badge { font-size: 5px; font-weight: 700; padding: 2px 5px; border-radius: 99px; white-space: nowrap; }
    .de-badge.prog { background: var(--pink-pale); color: var(--pink); }
    .de-badge.done { background: #EAF3DE; color: #3B6D11; }
    .de-navbar { display: flex; margin-top: auto; border-top: 1px solid var(--border); background: #fff; padding: 6px 0 3px; }
    .de-nav-item { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 2px; }
    .de-nav-ico { width: 15px; height: 15px; border-radius: 4px; display: flex; align-items: center; justify-content: center; }
    .de-nav-ico.active { background: var(--pink-pale); }
    .de-nav-ico svg { width: 10px; height: 10px; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; fill: none; }
    .de-nav-lbl { font-size: 5px; font-weight: 700; color: var(--brown-light); }
    .de-nav-item.active .de-nav-lbl { color: var(--pink); }
    .de-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5px; padding: 0 9px; }
    .de-grid-item { background: #fff; border-radius: 9px; padding: 9px 7px 7px; border: 1px solid var(--border); display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .de-grid-ico { width: 26px; height: 26px; border-radius: 7px; background: var(--pink-pale); display: flex; align-items: center; justify-content: center; }
    .de-grid-ico svg { width: 13px; height: 13px; stroke: var(--pink); stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; fill: none; }
    .de-grid-lbl { font-size: 6.5px; font-weight: 700; color: var(--brown); text-align: center; }
    .de-topbar { display: flex; align-items: center; justify-content: space-between; padding: 5px 10px 7px; }
    .de-topbar-title { font-size: 10px; font-weight: 800; color: var(--brown); font-family: var(--font-head); }
    .de-topbar-bell { width: 18px; height: 18px; border-radius: 50%; background: var(--pink-pale); display: flex; align-items: center; justify-content: center; }
    .de-topbar-bell svg { width: 10px; height: 10px; stroke: var(--pink); stroke-width: 2; fill: none; stroke-linecap: round; }
    .de-notices { display: flex; flex-direction: column; gap: 4px; padding: 0 9px; }
    .de-notice-item { background: #fff; border-radius: 7px; padding: 7px 8px; border: 1px solid var(--border); border-left: 3px solid var(--pink); }
    .de-notice-title { font-size: 7.5px; font-weight: 800; color: var(--brown); margin-bottom: 2px; font-family: var(--font-head); }
    .de-notice-body { font-size: 6px; color: var(--brown-light); line-height: 1.5; }
    .de-notice-date { font-size: 5.5px; color: var(--pink-light); font-weight: 700; margin-top: 2px; }

    .about { background:var(--brown); color:white; position:relative; overflow:hidden; }
    .about::before { content:''; position:absolute; bottom:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:rgba(255,45,120,0.16); }
    .about-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; position:relative; z-index:1; }
    .about .section-tag { color:var(--pink-light); }
    .about .section-title { color:white; }
    .about .section-sub { color:rgba(255,255,255,0.60); }
    .amenities { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:32px; }
    .amenity { display:flex; align-items:center; gap:10px; font-size:.85rem; color:rgba(255,255,255,0.78); }
    .amenity-dot { width:7px; height:7px; background:var(--pink-light); border-radius:50%; flex-shrink:0; }
    .about-photos { display:flex; align-items:stretch; justify-content:center; height:100%; }
    .about-photo { border-radius:var(--r-lg); overflow:hidden; box-shadow:0 16px 34px rgba(0,0,0,0.18); }
    .about-main-photo { width:min(100%,460px); height:clamp(500px,42vw,620px); }
    .about-img { width:100%; height:100%; object-fit:cover; object-position:center; display:block; border-radius:var(--r-lg); filter:brightness(1.05) saturate(1.1); }

    .cta-section { background:var(--pink-pale); }
    .contact-inner { display:grid; grid-template-columns:minmax(460px,1fr) minmax(260px,360px); gap:54px; align-items:center; max-width:1100px; margin:0 auto; }
    .contact-copy { text-align:left; }
    .cta-section .section-tag { margin-bottom:9px; }
    .cta-section .section-title { color:var(--brown); margin:0 0 16px; font-size:clamp(2.35rem,4vw,3.35rem); max-width:620px; }
    .cta-section .section-sub { margin:0 0 32px; color:var(--brown-light); font-size:1.12rem; line-height:1.7; max-width:620px; }
    .cta-section .btn-primary { font-size:1.02rem; padding:16px 38px; }
    .cta-contact { margin-top:26px; font-size:1rem; line-height:1.65; color:var(--brown-light); max-width:520px; }
    .cta-contact a { color:var(--pink); text-decoration:none; font-weight:700; }
    .contact-map-wrap {
      position:relative; width:100%; margin:0; border-radius:var(--r-lg); overflow:hidden;
      border:1px solid rgba(232,23,93,0.20); box-shadow:var(--shadow-card); display:block;
      transition:transform .2s ease, box-shadow .2s ease;
    }
    .contact-map-wrap:hover { transform:translateY(-3px); box-shadow:0 18px 36px rgba(232,23,93,0.18); }
    .contact-map-prompt { display:inline-flex; align-items:center; gap:8px; margin-top:14px; color:var(--pink-deep); font-size:.82rem; font-weight:800; text-decoration:none; }
    .contact-map-prompt svg { width:16px; height:16px; stroke:currentColor; fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round; transition:transform .2s ease; }
    .contact-map-link:hover .contact-map-prompt svg { transform:translate(2px,-2px); }
    .contact-map-wrap.map-missing::after { content:'Add map image at public/images/map.jpg'; display:block; padding:34px 18px; color:var(--brown-light); font-size:.85rem; font-weight:700; }
    .contact-map-img { width:100%; height:auto; display:block; }
    .contact-map-link { color:inherit; text-decoration:none; }

    footer { background:var(--brown); color:rgba(255,255,255,0.48); padding:64px 6% 40px; }
    .footer-inner { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; margin-bottom:48px; }
    .footer-logo { display:flex; align-items:center; margin-bottom:16px; text-decoration:none; }
    .footer-logo img { height:56px; width:auto; object-fit:contain; filter:drop-shadow(0 4px 12px rgba(0,0,0,0.22)); }
    .footer-logo-fb { font-family:var(--font-head); font-size:1.2rem; font-weight:800; color:white; letter-spacing:-.02em; }
    .footer-logo-fb span { color:var(--pink-light); }
    .footer-brand p { font-size:.83rem; line-height:1.75; max-width:250px; }
    .footer-col h4 { font-size:.66rem; text-transform:uppercase; letter-spacing:.12em; color:rgba(255,255,255,0.32); margin-bottom:16px; font-weight:700; }
    .footer-col a { display:block; font-size:.87rem; color:rgba(255,255,255,0.52); text-decoration:none; margin-bottom:10px; transition:color .2s; }
    .footer-col a:hover { color:var(--pink-light); }
    .footer-btm { border-top:1px solid rgba(255,255,255,0.07); padding-top:24px; display:flex; justify-content:space-between; align-items:center; gap:22px; font-size:.78rem; }
    .footer-btm-right { display:flex; gap:22px; align-items:center; flex-wrap:wrap; }
    .footer-links { display:flex; gap:20px; align-items:center; flex-wrap:wrap; }
    .footer-btm a { color:rgba(255,255,255,0.32); text-decoration:none; }
    .footer-btm a:hover { color:var(--pink-light); }
    .footer-socials { display:flex; align-items:center; gap:12px; }
    .footer-social-icon { position:relative; width:46px; height:46px; border-radius:50%; background:#111; color:white; display:inline-flex; align-items:center; justify-content:center; overflow:hidden; border:1px solid rgba(255,255,255,0.14); transition:transform .2s, background .2s, border-color .2s; }
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

    .reveal {
      opacity: 0;
      transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.from-left { transform: translateX(-40px); }
    .reveal.from-right { transform: translateX(40px); }
    .reveal.from-bottom { transform: translateY(40px); }
    .reveal.scale-in { transform: scale(0.92); }
    .reveal.visible { opacity: 1; transform: none; }

    .d1 { transition-delay: .10s; }
    .d2 { transition-delay: .22s; }
    .d3 { transition-delay: .34s; }
    .d4 { transition-delay: .46s; }

    @media(max-width:960px){
      .hero { grid-template-columns:1fr; padding:120px 6% 80px; min-height:auto; }
      .hero-content { padding:0; }
      .hero-arch-wrap { min-height:420px; }
      .hero-arch { width:300px; height:400px; }
      .gallery-grid { grid-template-columns:1fr 1fr; }
      .how-inner { grid-template-columns:1fr; gap:48px; }
      .about-inner { grid-template-columns:1fr; }
      .about-photos { max-width:760px; width:100%; margin:0 auto; }
      .footer-inner { grid-template-columns:1fr 1fr; }
      .nav-links { display:none; }
      .nav-toggle { display:inline-flex; }
      .contact-inner { grid-template-columns:minmax(0,1fr) minmax(240px,320px); gap:36px; }
      .cta-section .section-title { font-size:clamp(2rem,4vw,2.7rem); }
      .cta-section .section-sub { font-size:1rem; }
      .header-info-inner { grid-template-columns:1fr 1fr; gap:18px; }
      .header-info-item { border:1px solid rgba(36,16,24,0.14); border-radius:var(--r-md); padding:16px; background:rgba(255,255,255,0.55); }
      .header-info-item:last-child { border-right:1px solid rgba(36,16,24,0.14); }
      .de-phone.side { width:110px; height:238px; }
      .de-phone.center { width:132px; height:284px; }
      .hero-stats { grid-template-columns: repeat(3,1fr); }
    }

    @media(max-width:760px){
      nav { top:46px; height:auto; min-height:76px; padding:10px 5%; gap:14px; flex-wrap:wrap; border-radius:28px; width:calc(100% - 28px); }
      nav.scrolled { top:12px; }
      .top-notice { font-size:.74rem; min-height:30px; }
      .header-info-strip { padding:138px 5% 10px; }
      .nav-logo img { height:44px; }
      .nav-logo-fb { font-size:1.22rem; }
      section { padding:72px 5%; }
      .hero { padding:108px 5% 70px; }
      .hero-actions { align-items:stretch; }
      .btn-primary,.btn-outline { justify-content:center; width:100%; }
      .gallery-grid { grid-template-columns:1fr; max-width:460px; margin-left:auto; margin-right:auto; }
      .about-photos { max-width:460px; }
      .about-main-photo { height:min(560px,120vw); }
      .contact-inner { grid-template-columns:1fr; gap:32px; max-width:460px; }
      .contact-copy { text-align:center; }
      .cta-section .section-title,.cta-section .section-sub { margin-left:auto; margin-right:auto; }
      .cta-contact { margin-left:auto; margin-right:auto; text-align:center; }
      .footer-btm { flex-direction:column; gap:16px; align-items:flex-start; }
      .footer-btm-right { align-items:flex-start; }
      #scrollTopBtn { bottom:22px; right:18px; width:44px; height:44px; }
      .de-phone.side { display:none; }
      .de-phone.center { width:180px; height:340px; transform:none; }
      .de-mockup-wrap { padding:24px 16px 20px; }
      .hero-stats { grid-template-columns: 1fr 1fr; }
    }

    @media(max-width:600px){
      .gallery-grid { grid-template-columns:1fr; }
      .footer-inner { grid-template-columns:1fr; }
      .hero h1 { font-size:2.2rem; }
      .hero-arch-wrap { display:none; }
      .amenities { grid-template-columns:1fr; }
      .contact-map-wrap { border-radius:var(--r-md); }
      .header-info-inner { grid-template-columns:1fr; }
      .header-info-item { grid-template-columns:40px 1fr; }
      .header-info-icon { width:40px; height:40px; }
      .how-img-main { padding:24px 16px; border-radius:var(--r-lg); }
      .de-phone.center { width:200px; height:370px; }
      .hero-stats { grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
    }

    @media(max-width:420px){
      .section-title { font-size:1.72rem; }
      .gal-label { padding:14px 16px 18px; }
      .gal-label-top { align-items:flex-start; flex-direction:column; gap:6px; }
      .hero-actions { gap:10px; }
      .btn-primary,.btn-outline { font-size:.85rem; padding:12px 20px; }
      .footer-inner { gap:32px; }
      .de-phone.center { width:175px; height:330px; }
      .steps { gap:20px; }
      .step-num { width:36px; height:36px; font-size:.88rem; }
    }

    .cursor-glow {
      position: fixed; pointer-events: none; z-index: 9999;
      width: 180px; height: 180px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(232,23,93,0.07) 0%, transparent 70%);
      transform: translate(-50%, -50%);
      transition: left 0.12s ease, top 0.12s ease;
      mix-blend-mode: multiply;
    }

    .room-modal-overlay {
      position: fixed; inset: 0; z-index: 2000;
      background: rgba(36,16,24,0.55);
      backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
      display: flex; align-items: center; justify-content: center;
      padding: 24px;
      opacity: 0; visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .room-modal-overlay.open { opacity: 1; visibility: visible; }

    .room-modal {
      background: var(--cream); border-radius: var(--r-xl);
      max-width: 880px; width: 100%; max-height: 88vh; overflow: hidden;
      display: grid; grid-template-columns: 1fr 1fr;
      box-shadow: 0 40px 90px rgba(36,16,24,0.30);
      transform: scale(0.92) translateY(20px);
      transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
      position: relative;
    }
    .room-modal-overlay.open .room-modal { transform: scale(1) translateY(0); }

    .room-modal-img-wrap { position: relative; overflow: hidden; min-height: 320px; }
    .room-modal-img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .room-modal-badge {
      position: absolute; top: 20px; left: 20px;
      background: var(--gradient-pink); color: white;
      font-size: 0.74rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
      padding: 6px 16px; border-radius: 100px;
      box-shadow: 0 8px 18px rgba(232,23,93,0.30);
    }

    .room-modal-body { padding: 40px 36px; display: flex; flex-direction: column; overflow-y: auto; }
    .room-modal-occupants {
      font-size: 0.82rem; font-weight: 700; color: var(--pink);
      text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 10px;
    }
    .room-modal-title {
      font-family: var(--font-head); font-size: 1.8rem; font-weight: 800;
      color: var(--brown); letter-spacing: -0.02em; margin-bottom: 16px;
    }
    .room-modal-desc { font-size: 0.95rem; color: var(--brown-light); line-height: 1.8; margin-bottom: 24px; }

    .room-modal-features { display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
    .room-modal-feature {
      display: flex; align-items: center; gap: 12px;
      font-size: 0.88rem; color: var(--brown); font-weight: 600;
    }
    .room-modal-feature-icon {
      width: 32px; height: 32px; border-radius: 10px; flex-shrink: 0;
      background: var(--pink-pale); color: var(--pink);
      display: flex; align-items: center; justify-content: center;
    }
    .room-modal-feature-icon svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    .room-modal-actions { display: flex; gap: 12px; margin-top: auto; flex-wrap: wrap; }

    .room-modal-close {
      position: absolute; top: 18px; right: 18px; z-index: 5;
      width: 40px; height: 40px; border-radius: 50%; border: none;
      background: rgba(255,255,255,0.92); color: var(--brown);
      display: flex; align-items: center; justify-content: center; cursor: pointer;
      box-shadow: 0 6px 18px rgba(36,16,24,0.18);
      transition: background 0.2s, transform 0.2s, color 0.2s;
    }
    .room-modal-close:hover { background: var(--pink); color: white; transform: rotate(90deg); }
    .room-modal-close svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.4; stroke-linecap: round; }

    @media(max-width:760px){
      .room-modal { grid-template-columns: 1fr; max-height: 92vh; }
      .room-modal-img-wrap { min-height: 200px; }
      .room-modal-body { padding: 28px 24px; }
      .room-modal-title { font-size: 1.5rem; }
    }

    #de-chat-btn {
      position: fixed; bottom: 96px; right: 32px; z-index: 3000;
      width: 56px; height: 56px; border-radius: 50%; border: none;
      background: var(--gradient-pink);
      color: white; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 6px 24px rgba(232,23,93,0.40);
      transition: transform 0.22s cubic-bezier(0.22,1,0.36,1), box-shadow 0.22s;
    }
    #de-chat-btn:hover { transform: translateY(-3px) scale(1.07); box-shadow: 0 12px 32px rgba(232,23,93,0.52); }
    #de-chat-btn svg { width: 24px; height: 24px; stroke: white; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1); }
    #de-chat-btn.open svg#de-btn-open { transform: scale(0) rotate(90deg); }
    #de-chat-btn.open svg#de-btn-close { transform: scale(1) rotate(0deg); }
    #de-btn-close { position: absolute; transform: scale(0) rotate(-90deg); }

    #de-chat-pulse {
      position: fixed; bottom: 160px; right: 28px; z-index: 3001;
      background: white; color: var(--brown);
      font-family: var(--font-body); font-size: 12px; font-weight: 700;
      padding: 7px 13px 7px 10px; border-radius: 20px;
      border: 1.5px solid rgba(232,23,93,0.18);
      white-space: nowrap;
      box-shadow: 0 4px 20px rgba(36,16,24,0.12);
      display: flex; align-items: center; gap: 7px;
      animation: pulseFloat 3s ease-in-out infinite;
      pointer-events: none;
    }
    #de-chat-pulse::before {
      content: '';
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--pink);
      flex-shrink: 0;
      animation: pulseDot 1.4s ease-in-out infinite;
    }
    #de-chat-pulse::after {
      content: '';
      position: absolute; bottom: -7px; right: 18px;
      border-left: 6px solid transparent; border-right: 6px solid transparent;
      border-top: 7px solid white;
    }
    @keyframes pulseFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-4px); }
    }
    @keyframes pulseDot {
      0%, 100% { opacity: 0.5; transform: scale(0.85); }
      50% { opacity: 1; transform: scale(1); }
    }

    #de-chat-window {
      position: fixed; bottom: 168px; right: 32px; z-index: 3000;
      width: 420px;
      background: #fdf4f8;
      border-radius: 22px;
      box-shadow: 0 20px 60px rgba(36,16,24,0.18), 0 0 0 1px rgba(232,23,93,0.10);
      display: flex; flex-direction: column; overflow: hidden;
      transform: scale(0.90) translateY(20px); opacity: 0; pointer-events: none;
      transition: transform 0.32s cubic-bezier(0.22,1,0.36,1), opacity 0.28s ease;
      max-height: 600px;
      overflow: hidden;
    }
    #de-chat-window.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: all; }

    .de-cw-header {
      background: var(--gradient-pink);
      padding: 16px 18px 14px;
      display: flex; align-items: center; gap: 12px; flex-shrink: 0;
      position: relative;
    }
    .de-cw-header::after {
      content: '';
      position: absolute; bottom: -6px; left: 0; right: 0; height: 6px;
      background: linear-gradient(to bottom, rgba(232,23,93,0.08), transparent);
    }
    .de-cw-avatar {
      width: 38px; height: 38px; border-radius: 50%;
      background: rgba(255,255,255,0.18);
      border: 1.5px solid rgba(255,255,255,0.30);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .de-cw-avatar svg { width: 20px; height: 20px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .de-cw-header-text { flex: 1; min-width: 0; }
    .de-cw-header-name { font-family: var(--font-head); font-size: 0.9rem; font-weight: 800; color: white; line-height: 1.2; }
    .de-cw-header-sub { font-size: 0.70rem; color: rgba(255,255,255,0.76); font-weight: 600; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .de-cw-header-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
    .de-cw-status { display: flex; align-items: center; gap: 5px; }
    .de-cw-online { width: 7px; height: 7px; border-radius: 50%; background: #7EF08A; box-shadow: 0 0 0 2px rgba(255,255,255,0.25); }
    .de-cw-status-lbl { font-size: 0.65rem; color: rgba(255,255,255,0.80); font-weight: 600; }
    .de-cw-icon-btn {
      width: 30px; height: 30px; border-radius: 50%; border: none;
      background: rgba(255,255,255,0.18); color: white;
      display: flex; align-items: center; justify-content: center; cursor: pointer;
      transition: background 0.18s; flex-shrink: 0;
    }
    .de-cw-icon-btn:hover { background: rgba(255,255,255,0.30); }
    .de-cw-icon-btn svg { width: 14px; height: 14px; stroke: white; fill: none; stroke-width: 2.4; stroke-linecap: round; stroke-linejoin: round; }

    .de-policy-screen {
      flex: 1; overflow-y: auto; padding: 20px 18px 16px;
      display: flex; flex-direction: column; gap: 14px;
    }
    .de-policy-screen::-webkit-scrollbar { width: 4px; }
    .de-policy-screen::-webkit-scrollbar-thumb { background: rgba(232,23,93,0.20); border-radius: 99px; }
    .de-policy-icon {
      width: 48px; height: 48px; border-radius: 50%; background: var(--pink-pale);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .de-policy-icon svg { width: 24px; height: 24px; stroke: var(--pink); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .de-policy-title {
      font-family: var(--font-head); font-size: 0.95rem; font-weight: 800;
      color: var(--brown); line-height: 1.3;
    }
    .de-policy-subtitle {
      font-size: 0.72rem; font-weight: 600; color: var(--brown-light);
      margin-top: 2px;
    }
    .de-policy-box {
      background: white; border-radius: 14px;
      border: 1.5px solid var(--border);
      padding: 14px 16px;
      max-height: 200px; overflow-y: auto;
      flex-shrink: 0;
    }
    .de-policy-box::-webkit-scrollbar { width: 3px; }
    .de-policy-box::-webkit-scrollbar-thumb { background: rgba(232,23,93,0.20); border-radius: 99px; }
    .de-policy-item {
      display: flex; gap: 10px; align-items: flex-start;
      padding: 8px 0;
      border-bottom: 1px solid rgba(232,23,93,0.08);
      font-size: 0.76rem; color: var(--brown-light); line-height: 1.55; font-weight: 600;
    }
    .de-policy-item:last-child { border-bottom: none; padding-bottom: 0; }
    .de-policy-dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--pink); flex-shrink: 0; margin-top: 5px;
    }
    .de-policy-note {
      font-size: 0.68rem; color: var(--brown-light); font-weight: 600;
      text-align: center; line-height: 1.5; opacity: 0.75;
    }
    .de-policy-actions {
      display: flex; gap: 8px; padding: 12px 18px 16px;
      flex-shrink: 0;
    }
    .de-policy-agree {
      flex: 1; padding: 11px 0; border: none; border-radius: 100px;
      background: var(--gradient-pink); color: white;
      font-family: var(--font-body); font-size: 0.84rem; font-weight: 700;
      cursor: pointer; transition: filter 0.2s, transform 0.15s;
      box-shadow: 0 6px 18px rgba(232,23,93,0.30);
    }
    .de-policy-agree:hover { filter: brightness(0.94); transform: translateY(-1px); }
    .de-policy-disagree {
      flex: 1; padding: 11px 0; border: 1.5px solid rgba(36,16,24,0.18); border-radius: 100px;
      background: transparent; color: var(--brown-light);
      font-family: var(--font-body); font-size: 0.84rem; font-weight: 700;
      cursor: pointer; transition: border-color 0.2s, color 0.2s;
    }
    .de-policy-disagree:hover { border-color: var(--brown-mid); color: var(--brown); }

    .de-cw-body {
      flex: 1; overflow-y: auto; padding: 16px 14px 8px;
      display: flex; flex-direction: column; gap: 10px;
      scroll-behavior: smooth;
    }
    .de-cw-body::-webkit-scrollbar { width: 4px; }
    .de-cw-body::-webkit-scrollbar-track { background: transparent; }
    .de-cw-body::-webkit-scrollbar-thumb { background: rgba(232,23,93,0.20); border-radius: 99px; }

    .de-msg { display: flex; flex-direction: column; gap: 3px; }
    .de-msg.user {
      align-items: flex-end;
      max-width: calc(100% - 28px);
      margin-left: auto;
    }
    .de-msg.bot { align-items: flex-start; }

    .de-msg-row { display: flex; gap: 8px; align-items: flex-end; }
    .de-msg.user .de-msg-row {
      flex-direction: row-reverse;
      max-width: 100%;
      min-width: 0;
    }

    .de-msg-bubble {
      max-width: 82%; padding: 10px 14px;
      border-radius: 18px 18px 18px 4px;
      font-size: 0.83rem; line-height: 1.55; font-family: var(--font-body); font-weight: 600; color: var(--brown);
      background: white;
      box-shadow: 0 2px 10px rgba(36,16,24,0.07);
    }

    .de-msg.user .de-msg-bubble {
      background: var(--gradient-pink); color: white;
      border-radius: 18px 18px 4px 18px;
      box-shadow: 0 4px 14px rgba(232,23,93,0.26);
      width: fit-content;
      max-width: 100%;
      word-break: break-word;
      overflow-wrap: break-word;
    }

    .de-msg-ico {
      width: 28px; height: 28px; border-radius: 50%;
      background: var(--gradient-pink);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
      box-shadow: 0 3px 10px rgba(232,23,93,0.28);
    }
    .de-msg-ico svg { width: 13px; height: 13px; stroke: white; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }

    .de-msg-time {
      font-size: 0.60rem; color: rgba(116,75,93,0.55); font-weight: 600;
      padding: 0 6px;
    }
    .de-msg.user .de-msg-time { text-align: right; }
    .de-msg.bot .de-msg-time { padding-left: 36px; }

    .de-typing-bubble {
      display: flex; gap: 8px; align-items: flex-end;
    }
    .de-typing {
      display: flex; gap: 5px; align-items: center;
      padding: 12px 16px;
      background: white; border-radius: 18px 18px 18px 4px;
      box-shadow: 0 2px 10px rgba(36,16,24,0.07);
    }
    .de-typing span {
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--pink-light); opacity: 0.6;
      animation: typingDot 1.1s infinite;
    }
    .de-typing span:nth-child(2) { animation-delay: 0.18s; }
    .de-typing span:nth-child(3) { animation-delay: 0.36s; }
    @keyframes typingDot {
      0%, 80%, 100% { opacity: 0.3; transform: scale(0.75); }
      40% { opacity: 1; transform: scale(1); }
    }

    .de-suggestions {
      padding: 6px 14px 4px;
      flex-shrink: 0;
    }
    .de-suggestions-label {
      font-size: 0.60rem; font-weight: 700; color: var(--brown-light);
      text-transform: uppercase; letter-spacing: 0.09em;
      margin-bottom: 7px; font-family: var(--font-head);
    }
    .de-suggestions-row {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      padding-bottom: 4px;
    }
    .de-sug-btn {
      background: white;
      border: 1.5px solid rgba(232,23,93,0.20);
      border-radius: 100px;
      padding: 6px 13px;
      white-space: nowrap;
      font-size: 0.74rem; font-weight: 600; color: var(--brown-mid);
      font-family: var(--font-body);
      cursor: pointer;
      flex-shrink: 0;
      transition: border-color 0.16s, background 0.16s, color 0.16s, transform 0.14s, box-shadow 0.14s;
      display: inline-flex; align-items: center; gap: 5px;
      box-shadow: 0 1px 6px rgba(36,16,24,0.06);
      line-height: 1.2;
    }
    .de-sug-btn:hover {
      border-color: var(--pink);
      background: #fff5f8;
      color: var(--pink);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(232,23,93,0.18);
    }
    .de-sug-btn .de-sug-icon { font-size: 0.80rem; }

    .de-cw-input-wrap {
      display: flex; align-items: center; gap: 8px;
      padding: 10px 14px 14px;
      border-top: 1px solid rgba(232,23,93,0.08);
      flex-shrink: 0; background: #fdf4f8;
    }
    #de-chat-input {
      flex: 1; border: 1.5px solid rgba(232,23,93,0.18); border-radius: 14px;
      padding: 9px 13px; font-size: 0.83rem; font-family: var(--font-body); font-weight: 600;
      color: var(--brown); background: white; outline: none;
      transition: border-color 0.18s, box-shadow 0.18s;
    }
    #de-chat-input:focus { border-color: var(--pink); box-shadow: 0 0 0 3px rgba(232,23,93,0.09); }
    #de-chat-input::placeholder { color: #c4a8b3; font-weight: 500; }
    #de-chat-send {
      width: 36px; height: 36px; border-radius: 12px; border: none; flex-shrink: 0;
      background: var(--gradient-pink);
      cursor: pointer; display: flex; align-items: center; justify-content: center;
      transition: transform 0.15s, box-shadow 0.15s;
      box-shadow: 0 4px 12px rgba(232,23,93,0.30);
    }
    #de-chat-send:hover { transform: scale(1.10); box-shadow: 0 6px 18px rgba(232,23,93,0.44); }
    #de-chat-send svg { width: 15px; height: 15px; stroke: white; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }

    @media(max-width:760px){
      #de-chat-btn { right: 18px; bottom: 80px; }
      #de-chat-pulse { right: 20px; bottom: 142px; }
      #de-chat-window { width: calc(100vw - 24px); right: 12px; bottom: 148px; }
    }
  </style>
</head>
<body>

<div class="cursor-glow" id="cursorGlow"></div>

<header class="site-header">
  <div class="top-notice">Sanctissimo Rosario Ladies Dormitory &middot; Safe student housing near UST</div>

  <nav id="navbar">
    <a href="{{ route('home') }}" class="nav-logo">
      <img src="{{ asset('images/logo.png') }}" alt="DormEase Logo" onerror="this.style.display='none'">
      <span class="nav-logo-fb">Dorm<span>Ease</span></span>
    </a>

    <ul class="nav-links">
      <li><a href="{{ route('gallery') }}">Gallery</a></li>
      <li><a href="#how">How it Works</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="{{ route('faqs') }}">FAQs</a></li>
      <li><a href="#contact" class="nav-cta">Contact Us</a></li>
    </ul>

    <button class="nav-toggle" id="navToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileNav">
      <svg viewBox="0 0 24 24" aria-hidden="true"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
    </button>

    <div class="mobile-nav" id="mobileNav">
      <a href="{{ route('gallery') }}">Gallery</a>
      <a href="#how">How it Works</a>
      <a href="#about">About</a>
      <a href="{{ route('faqs') }}">FAQs</a>
      <a href="#contact">Contact Us</a>
    </div>
  </nav>

  <div class="header-info-strip">
    <div class="header-info-inner">
      <div class="header-info-item">
        <div class="header-info-icon">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/></svg>
        </div>
        <div>
          <div class="header-info-title">Ladies Dormitory</div>
          <div class="header-info-text">Study-friendly rooms for female students in Sampaloc.</div>
        </div>
      </div>
      <div class="header-info-item">
        <div class="header-info-icon">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
        </div>
        <div>
          <div class="header-info-title">Near UST &amp; UBelt</div>
          <div class="header-info-text">Located along Navarra Street with nearby campus access.</div>
        </div>
      </div>
      <div class="header-info-item">
        <div class="header-info-icon">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"/><path d="M9.5 12l1.8 1.8 3.7-4"/></svg>
        </div>
        <div>
          <div class="header-info-title">24/7 Security</div>
          <div class="header-info-text">CCTV, secure entry, and dorm support for tenants.</div>
        </div>
      </div>
      <div class="header-info-item">
        <div class="header-info-icon">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16"/><path d="M6 7v13h12V7"/><path d="M9 7V5h6v2"/><path d="M9 12h6"/><path d="M9 16h4"/></svg>
        </div>
        <div>
          <div class="header-info-title">Rooms &amp; Amenities</div>
          <div class="header-info-text">Semi-furnished rooms with Wi-Fi, elevator, and own bathroom.</div>
        </div>
      </div>
    </div>
  </div>
</header>

<section class="hero" id="hero">
  <div class="hero-bg-lines"></div>
  <div class="hero-content">
    <h1>
      <span class="hero-title-word" style="animation-delay:0.05s">Your&nbsp;</span><span class="hero-title-word" style="animation-delay:0.15s">home&nbsp;</span><span class="hero-title-word" style="animation-delay:0.25s">away</span><br>
      <span class="hero-title-word" style="animation-delay:0.35s">from&nbsp;</span><em class="hero-title-word" style="animation-delay:0.45s">home</em>
    </h1>
    <p class="hero-sub">Sanctissimo Rosario Ladies Dormitory: a safe, study-friendly home for female students in the heart of Sampaloc, Manila.</p>
    <div class="hero-actions">
      <a href="{{ route('gallery') }}" class="btn-primary">Explore Rooms</a>
      <a href="{{ route('safety.features') }}" class="btn-outline">Safety Features</a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat-item">
        <span class="hero-stat-number" data-target="5" data-suffix="">0</span>
        <span class="hero-stat-label">Floors</span>
      </div>
      <div class="hero-stat-item">
        <span class="hero-stat-number" data-target="24" data-suffix="/7">0</span>
        <span class="hero-stat-label">Security</span>
      </div>
      <div class="hero-stat-item">
        <span class="hero-stat-number" data-target="4" data-suffix="">0</span>
        <span class="hero-stat-label">Room Types</span>
      </div>
    </div>
  </div>
  <div class="hero-arch-wrap">
    <div class="hero-blob-top"></div>
    <div class="hero-blob-bottom"></div>
    <div class="hero-arch-ring"></div>
    <div class="hero-arch">
      <img src="{{ asset('images/sancti.png') }}" alt="Sanctissimo Rosario Dormitory">
    </div>
  </div>
</section>

<section class="gallery" id="gallery">
  <div class="reveal from-bottom">
    <div class="section-tag">Our Rooms</div>
    <h2 class="section-title">Room Types at <em>Sanctissimo Rosario</em></h2>
    <p class="section-sub">Choose the setup that fits your lifestyle, safe, clean, and near UST and the University Belt.</p>
  </div>
  <div class="gallery-grid">
    <div class="gal-item reveal from-bottom d1" data-room="solo">
      <div class="gal-img-wrap">
        <div class="gal-item-overlay"></div>
        <img src="{{ asset('images/solo.jpg') }}" alt="Solo Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top"><span class="gal-badge">Solo</span><span class="gal-occupants">1 Occupant</span></div>
        <h3 class="gal-title">Solo Room</h3>
        <p class="gal-desc">Semi-furnished private room ideal for one student. Includes a bed, wardrobe, and study desk.</p>
      </div>
    </div>
    <div class="gal-item reveal from-bottom d2" data-room="double">
      <div class="gal-img-wrap">
        <div class="gal-item-overlay"></div>
        <img src="{{ asset('images/two.jpg') }}" alt="Double Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top"><span class="gal-badge">Double</span><span class="gal-occupants">2 Occupants</span></div>
        <h3 class="gal-title">Double Room</h3>
        <p class="gal-desc">Semi-furnished room for two. Each occupant gets a bed, individual wardrobe, and shared study area.</p>
      </div>
    </div>
    <div class="gal-item reveal from-bottom d3" data-room="triple">
      <div class="gal-img-wrap">
        <div class="gal-item-overlay"></div>
        <img src="{{ asset('images/three.jpg') }}" alt="Triple Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top"><span class="gal-badge">Triple</span><span class="gal-occupants">3 Occupants</span></div>
        <h3 class="gal-title">Triple Room</h3>
        <p class="gal-desc">Spacious room for three students. Comes with three beds, wardrobes, and a shared study corner.</p>
      </div>
    </div>
    <div class="gal-item reveal from-bottom d4" data-room="quad">
      <div class="gal-img-wrap">
        <div class="gal-item-overlay"></div>
        <img src="{{ asset('images/four.jpg') }}" alt="Quad Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top"><span class="gal-badge">Quad</span><span class="gal-occupants">4 Occupants</span></div>
        <h3 class="gal-title">Quad Room</h3>
        <p class="gal-desc">Best value for groups of four. Fully utilizes shared space with four beds and communal storage.</p>
      </div>
    </div>
  </div>
</section>

<section class="how" id="how">
  <div class="how-inner">
    <div>
      <div class="section-tag reveal from-left">Simple Process</div>
      <h2 class="section-title reveal from-left d1">Getting started is <em>effortless</em></h2>
      <p class="section-sub reveal from-left d2">DormEase is designed so every tenant can use it with zero learning curve.</p>
      <div class="steps" style="margin-top:48px;">
        <div class="step reveal from-left d1">
          <div class="step-num">1</div>
          <div>
            <div class="step-title">Inquire now and be a Tenant</div>
            <p class="step-desc">Contact us to learn more about our dormitory and start your application process.</p>
          </div>
        </div>
        <div class="step reveal from-left d2">
          <div class="step-num">2</div>
          <div>
            <div class="step-title">Access all dorm services</div>
            <p class="step-desc">Report issues by voice or text, check your water bill, register visitors, and receive announcements instantly.</p>
          </div>
        </div>
        <div class="step reveal from-left d3">
          <div class="step-num">3</div>
          <div>
            <div class="step-title">Stay informed, stay safe</div>
            <p class="step-desc">Receive real-time announcements and emergency alerts. Everything you need, always within reach.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="how-img-main reveal from-right">
      <div class="de-mockup-wrap">
        <div class="de-phone side">
          <div class="de-notch"></div>
          <div class="de-screen">
            <div class="de-statusbar"><span>9:41</span><div class="de-bars"><div class="de-bar" style="height:4px"></div><div class="de-bar" style="height:6px"></div><div class="de-bar" style="height:8px"></div><div class="de-bar" style="height:10px"></div></div></div>
            <div class="de-topbar" style="padding-top:9px">
              <div class="de-topbar-title">Menu</div>
              <div class="de-topbar-bell"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
            </div>
            <div class="de-grid">
              <div class="de-grid-item"><div class="de-grid-ico"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div><div class="de-grid-lbl">Dashboard</div></div>
              <div class="de-grid-item"><div class="de-grid-ico"><svg viewBox="0 0 24 24"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg></div><div class="de-grid-lbl">Water Bill</div></div>
              <div class="de-grid-item"><div class="de-grid-ico"><svg viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div><div class="de-grid-lbl">Maintenance</div></div>
              <div class="de-grid-item"><div class="de-grid-ico"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><div class="de-grid-lbl">Documents</div></div>
            </div>
            <div class="de-navbar" style="margin-top:auto">
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div><div class="de-nav-lbl">Home</div></div>
              <div class="de-nav-item active"><div class="de-nav-ico active"><svg viewBox="0 0 24 24" stroke="#E8175D"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg></div><div class="de-nav-lbl">Menu</div></div>
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div class="de-nav-lbl">Profile</div></div>
            </div>
          </div>
        </div>

        <div class="de-phone center">
          <div class="de-notch"></div>
          <div class="de-screen">
            <div class="de-statusbar"><span>9:41</span><div class="de-bars"><div class="de-bar" style="height:4px"></div><div class="de-bar" style="height:6px"></div><div class="de-bar" style="height:8px"></div><div class="de-bar" style="height:10px"></div></div></div>
            <div class="de-header"><div><div class="de-greeting">Welcome back,</div><div class="de-name">Hi, Maria</div></div><div class="de-avatar">M</div></div>
            <div class="de-bill-card"><div class="de-bill-label">Current Water Bill</div><div class="de-bill-amount">P 320.00</div></div>
            <div class="de-stats-row"><div class="de-stat"><div class="de-stat-lbl">Requests</div><div class="de-stat-num">2</div></div><div class="de-stat"><div class="de-stat-lbl">Announcements</div><div class="de-stat-num">3</div></div></div>
            <div class="de-section-lbl">Recent Activity</div>
            <div class="de-activity">
              <div class="de-act-item"><div class="de-dot" style="background:#E8175D"></div><div class="de-act-text">Leaky faucet · Room 204</div><div class="de-badge prog">In Progress</div></div>
              <div class="de-act-item"><div class="de-dot" style="background:#639922"></div><div class="de-act-text">Water bill for May paid</div><div class="de-badge done">Done</div></div>
            </div>
            <div class="de-navbar">
              <div class="de-nav-item active"><div class="de-nav-ico active"><svg viewBox="0 0 24 24" stroke="#E8175D"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div><div class="de-nav-lbl">Home</div></div>
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div><div class="de-nav-lbl">Alerts</div></div>
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div class="de-nav-lbl">Visitor Log</div></div>
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg></div><div class="de-nav-lbl">Docs</div></div>
            </div>
          </div>
        </div>

        <div class="de-phone side">
          <div class="de-notch"></div>
          <div class="de-screen">
            <div class="de-statusbar"><span>9:41</span><div class="de-bars"><div class="de-bar" style="height:4px"></div><div class="de-bar" style="height:6px"></div><div class="de-bar" style="height:8px"></div><div class="de-bar" style="height:10px"></div></div></div>
            <div class="de-topbar" style="padding-top:9px"><div class="de-topbar-title">Notices</div><div class="de-topbar-bell"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div></div>
            <div class="de-notices">
              <div class="de-notice-item"><div class="de-notice-title">Water Interruption</div><div class="de-notice-body">No water supply on June 10, 8AM to 12NN for maintenance.</div><div class="de-notice-date">Jun 9, 2026</div></div>
              <div class="de-notice-item"><div class="de-notice-title">Curfew Reminder</div><div class="de-notice-body">10PM curfew strictly enforced. Late arrivals must coordinate.</div><div class="de-notice-date">Jun 8, 2026</div></div>
              <div class="de-notice-item"><div class="de-notice-title">Room Inspection</div><div class="de-notice-body">Monthly check on June 15. Please keep rooms tidy.</div><div class="de-notice-date">Jun 7, 2026</div></div>
            </div>
            <div class="de-navbar" style="margin-top:auto">
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div><div class="de-nav-lbl">Home</div></div>
              <div class="de-nav-item active"><div class="de-nav-ico active"><svg viewBox="0 0 24 24" stroke="#E8175D"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div><div class="de-nav-lbl">Notices</div></div>
              <div class="de-nav-item"><div class="de-nav-ico"><svg viewBox="0 0 24 24" stroke="#744B5D"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div class="de-nav-lbl">Profile</div></div>
            </div>
          </div>
        </div>
      </div>

      <p style="font-family:var(--font-head);font-size:1.05rem;font-weight:800;color:var(--brown);margin-top:20px;line-height:1.4;">
        Dorm life, <em style="color:var(--pink);font-style:italic;">simplified.</em>
      </p>
      <p style="font-size:.82rem;color:var(--brown-light);margin-top:6px;font-weight:600;letter-spacing:0.02em;">
        Everything your tenants need is in one place.
      </p>
      <a href="{{ route('features') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;margin-top:16px;">
        More Features
        <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:white;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round;"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<section class="about" id="about">
  <div class="about-inner">
    <div>
      <div class="section-tag reveal from-left">About the Dormitory</div>
      <h2 class="section-title reveal from-left d1">Sanctissimo Rosario<br><em>Ladies Dormitory</em></h2>
      <p class="section-sub reveal from-left d2">A five-storey residential building at 1229 Navarra Street, Sampaloc, Manila. A safe, comfortable, study-friendly home for female students near UST and the University Belt.</p>
      <div class="amenities reveal from-left d3">
        <div class="amenity"><div class="amenity-dot"></div>24/7 Security + CCTV</div>
        <div class="amenity"><div class="amenity-dot"></div>Elevator Access</div>
        <div class="amenity"><div class="amenity-dot"></div>Wi-Fi Available</div>
        <div class="amenity"><div class="amenity-dot"></div>Own Bathroom per Room</div>
        <div class="amenity"><div class="amenity-dot"></div>Semi-Furnished Rooms</div>
        <div class="amenity"><div class="amenity-dot"></div>Aircon Slot per Room</div>
        <div class="amenity"><div class="amenity-dot"></div>Near UST &amp; UBelt</div>
        <div class="amenity"><div class="amenity-dot"></div>Strong Water Supply</div>
      </div>
      <div style="margin-top:40px;" class="reveal from-left d4">
        <a href="tel:+639175359723" class="btn-primary" style="display:inline-flex;">
          <svg viewBox="0 0 20 20" style="width:18px;height:18px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
          Reserve: +63 917 535 9723
        </a>
      </div>
    </div>
    <div class="about-photos reveal from-right">
      <div class="about-photo about-main-photo">
        <img src="{{ asset('images/main.png') }}" alt="Sanctissimo Rosario Ladies Dormitory" class="about-img" style="object-position:center;">
      </div>
    </div>
  </div>
</section>

<section class="cta-section" id="contact">
  <div class="contact-inner reveal from-bottom">
    <div class="contact-copy">
      <div class="section-tag">Get DormEase</div>
      <h2 class="section-title">Ready to experience<br>a <em>smarter</em> dorm life?</h2>
      <p class="section-sub">DormEase is available to all tenants of Sanctissimo Rosario Ladies Dormitory. Contact the administration to get access.</p>
      <a href="tel:+639175359723" class="btn-primary" style="display:inline-flex;">
        <svg viewBox="0 0 20 20" style="width:18px;height:18px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
        Call +63 917 535 9723
      </a>
      <div class="cta-contact">1229 Navarra Street, Sampaloc, Manila &nbsp;&middot;&nbsp; Near UST &amp; University Belt</div>
    </div>
    <a class="contact-map-link"
       href="https://maps.google.com/?q=1235%20Navarra%20St,%20Sampaloc,%20Manila,%201015%20Metro%20Manila&ftid=0x3397b5ffdcdacc75:0x38ad8e34f1c2236f&entry=gps&lucs=,94284469,94231188,47071704,94218641,94282134,94286869&g_st=ipc"
       target="_blank" rel="noopener noreferrer"
       aria-label="Open Sanctissimo Rosario Ladies Dormitory in Google Maps">
      <span class="contact-map-wrap">
        <img src="{{ asset('images/map.jpg') }}" alt="Map to Sanctissimo Rosario Ladies Dormitory" class="contact-map-img" onerror="this.style.display='none';this.parentElement.classList.add('map-missing')">
      </span>
      <span class="contact-map-prompt">
        Click here to see directions
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17L17 7"/><path d="M9 7h8v8"/></svg>
      </span>
    </a>
  </div>
</section>

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
    </div>
    <div class="footer-col">
      <h4>Dormitory</h4>
      <a href="#about">About</a>
      <a href="#gallery">Room Types</a>
      <a href="{{ route('gallery') }}">Amenities</a>
      <a href="https://maps.google.com/?q=1235%20Navarra%20St,%20Sampaloc,%20Manila,%201015%20Metro%20Manila&ftid=0x3397b5ffdcdacc75:0x38ad8e34f1c2236f&entry=gps&lucs=,94284469,94231188,47071704,94218641,94282134,94286869&g_st=ipc">Location</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="tel:+639175359723">+63 917 535 9723</a>
      <a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">1229 Navarra St.</a>
      <a href="https://maps.google.com/?q=1229+Navarra+St,+Sampaloc,+Manila" target="_blank" rel="noopener noreferrer">Sampaloc, Manila</a>
    </div>
  </div>
  <div class="footer-btm">
    <span>2026 DormEase: Sanctissimo Rosario Ladies Dormitory</span>
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
      <div class="footer-links">
        <a href="{{ route('faqs') }}">FAQs</a>
        <a href="{{ route('login') }}">Admin Portal</a>
      </div>
    </div>
  </div>
</footer>

<button id="scrollTopBtn" aria-label="Scroll to top">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg>
</button>

<div class="room-modal-overlay" id="roomModalOverlay">
  <div class="room-modal" role="dialog" aria-modal="true" aria-labelledby="roomModalTitle">
    <button class="room-modal-close" id="roomModalClose" aria-label="Close">
      <svg viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>
    </button>
    <div class="room-modal-img-wrap">
      <span class="room-modal-badge" id="roomModalBadge"></span>
      <img src="" alt="" class="room-modal-img" id="roomModalImg">
    </div>
    <div class="room-modal-body">
      <div class="room-modal-occupants" id="roomModalOccupants"></div>
      <h3 class="room-modal-title" id="roomModalTitle"></h3>
      <p class="room-modal-desc" id="roomModalDesc"></p>
      <div class="room-modal-features" id="roomModalFeatures"></div>
      <div class="room-modal-actions">
        <a href="tel:+639175359723" class="btn-primary">
          <svg viewBox="0 0 20 20" style="width:18px;height:18px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
          Inquire Now
        </a>
        <button class="btn-outline" id="roomModalCloseBtn" type="button">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="de-chat-pulse">Ask about the dorm!</div>

<button id="de-chat-btn" aria-label="Open dorm info chat">
  <svg id="de-btn-open" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
  <svg id="de-btn-close" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>
</button>

<div id="de-chat-window" role="dialog" aria-label="DormEase Info Assistant">
  <div class="de-cw-header">
    <div class="de-cw-avatar">
      <svg viewBox="0 0 24 24"><path d="M3 11l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
    </div>
    <div class="de-cw-header-text">
      <div class="de-cw-header-name">DormEase Assistant</div>
      <div class="de-cw-header-sub">Sanctissimo Rosario Ladies Dorm</div>
    </div>
    <div class="de-cw-header-actions">
      <div class="de-cw-status">
        <div class="de-cw-online"></div>
        <span class="de-cw-status-lbl">Online</span>
      </div>
      <button class="de-cw-icon-btn" id="de-cw-clear-btn" aria-label="Clear conversation" title="Clear conversation">
        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
      </button>
      <button class="de-cw-icon-btn" id="de-cw-close-header" aria-label="Close chat">
        <svg viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>
      </button>
    </div>
  </div>

  <div id="de-policy-panel" style="display:flex;flex-direction:column;flex:1;overflow:hidden;">
    <div class="de-policy-screen">
      <div style="display:flex;align-items:center;gap:12px;">
        <div class="de-policy-icon">
          <svg viewBox="0 0 24 24"><path d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"/><path d="M9.5 12l1.8 1.8 3.7-4"/></svg>
        </div>
        <div>
          <div class="de-policy-title">Before we begin</div>
          <div class="de-policy-subtitle">Please read and accept our chat guidelines</div>
        </div>
      </div>
      <div class="de-policy-box">
        <div class="de-policy-item"><div class="de-policy-dot"></div><span>This chat is for general inquiries about Sanctissimo Rosario Ladies Dormitory only. It is not a substitute for official communication with the dorm administration.</span></div>
        <div class="de-policy-item"><div class="de-policy-dot"></div><span>Responses are automated and may not reflect real-time availability or pricing. For confirmed details, please contact us directly at +63 917 535 9723.</span></div>
        <div class="de-policy-item"><div class="de-policy-dot"></div><span>Do not share sensitive personal information such as full names, addresses, or financial details through this chat.</span></div>
        <div class="de-policy-item"><div class="de-policy-dot"></div><span>Messages sent here are not monitored in real time. For urgent concerns, please call or visit us in person at 1229 Navarra St., Sampaloc, Manila.</span></div>
      </div>
      <p class="de-policy-note">Tap <strong>I Agree</strong> to start chatting, or <strong>I Disagree</strong> to close.</p>
    </div>
    <div class="de-policy-actions">
      <button class="de-policy-disagree" id="de-policy-no">I Disagree</button>
      <button class="de-policy-agree" id="de-policy-yes">I Agree</button>
    </div>
  </div>

  <div id="de-chat-panel" style="display:none;flex-direction:column;flex:1;overflow:hidden;">
    <div class="de-cw-body" id="de-chat-body"></div>
    <div class="de-suggestions" id="de-suggestions"></div>
    <div class="de-cw-input-wrap">
      <input type="text" id="de-chat-input" placeholder="Ask anything about the dorm…" autocomplete="off" maxlength="200">
      <button id="de-chat-send" aria-label="Send">
        <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      </button>
    </div>
  </div>
</div>

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

  const revealEls = document.querySelectorAll('.reveal');
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.10 });
  revealEls.forEach(el => obs.observe(el));

  const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');
  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        navLinks.forEach(link => link.classList.remove('nav-active'));
        const active = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
        if (active) active.classList.add('nav-active');
      }
    });
  }, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });
  document.querySelectorAll('section[id]').forEach(section => sectionObserver.observe(section));

  function animateCounter(el) {
    const target = parseInt(el.dataset.target, 10);
    const suffix = el.dataset.suffix || '';
    const duration = 1400;
    const start = performance.now();
    function step(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(eased * target);
      el.textContent = current + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = target + suffix;
    }
    requestAnimationFrame(step);
  }

  const counterEls = document.querySelectorAll('.hero-stat-number[data-target]');
  const counterObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { animateCounter(e.target); counterObs.unobserve(e.target); }
    });
  }, { threshold: 0.5 });
  counterEls.forEach(el => counterObs.observe(el));

  const roomData = {
    solo: {
      title: 'Solo Room', occupants: '1 Occupant', badge: 'Solo',
      img: "{{ asset('images/solo.jpg') }}",
      desc: 'A semi-furnished private room ideal for one student who values quiet, focus, and personal space. Comes with a comfortable bed, a dedicated wardrobe, and a study desk set up for long sessions.',
      features: [
        { icon: 'bed', label: '1 bed, 1 wardrobe' }, { icon: 'desk', label: 'Private study desk' },
        { icon: 'bath', label: 'Own bathroom' }, { icon: 'snow', label: 'Aircon slot included' }
      ]
    },
    double: {
      title: 'Double Room', occupants: '2 Occupants', badge: 'Double',
      img: "{{ asset('images/two.jpg') }}",
      desc: 'A semi-furnished room designed for two students. Each occupant gets their own bed and individual wardrobe, with a shared study area that keeps things organized and comfortable.',
      features: [
        { icon: 'bed', label: '2 beds, 2 wardrobes' }, { icon: 'desk', label: 'Shared study area' },
        { icon: 'bath', label: 'Own bathroom' }, { icon: 'snow', label: 'Aircon slot included' }
      ]
    },
    triple: {
      title: 'Triple Room', occupants: '3 Occupants', badge: 'Triple',
      img: "{{ asset('images/three.jpg') }}",
      desc: 'A spacious room built for three students. Three individual beds and wardrobes are paired with a shared study corner, giving everyone enough room to settle in comfortably.',
      features: [
        { icon: 'bed', label: '3 beds, 3 wardrobes' }, { icon: 'desk', label: 'Shared study corner' },
        { icon: 'bath', label: 'Own bathroom' }, { icon: 'snow', label: 'Aircon slot included' }
      ]
    },
    quad: {
      title: 'Quad Room', occupants: '4 Occupants', badge: 'Quad',
      img: "{{ asset('images/four.jpg') }}",
      desc: 'The best value option for groups of four. This room makes the most of shared space with four beds and communal storage, perfect for students who want to stay close to friends.',
      features: [
        { icon: 'bed', label: '4 beds, communal storage' }, { icon: 'desk', label: 'Shared study space' },
        { icon: 'bath', label: 'Own bathroom' }, { icon: 'snow', label: 'Aircon slot included' }
      ]
    }
  };

  const roomIcons = {
    bed: '<svg viewBox="0 0 24 24"><path d="M2 17h20"/><path d="M4 17v-5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5"/><path d="M4 12V7a1 1 0 0 1 1-1h6v6"/></svg>',
    desk: '<svg viewBox="0 0 24 24"><path d="M3 8h18"/><path d="M3 8v11"/><path d="M21 8v11"/><path d="M3 19h18"/><path d="M9 8v4"/></svg>',
    bath: '<svg viewBox="0 0 24 24"><path d="M9 6V4a2 2 0 0 1 4 0v2"/><path d="M4 10h16v2a6 6 0 0 1-6 6H10a6 6 0 0 1-6-6v-2z"/><path d="M5 20h14"/></svg>',
    snow: '<svg viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/><line x1="19.07" y1="4.93" x2="4.93" y2="19.07"/></svg>'
  };

  const roomModalOverlay = document.getElementById('roomModalOverlay');
  const roomModalImg = document.getElementById('roomModalImg');
  const roomModalBadge = document.getElementById('roomModalBadge');
  const roomModalOccupants = document.getElementById('roomModalOccupants');
  const roomModalTitle = document.getElementById('roomModalTitle');
  const roomModalDesc = document.getElementById('roomModalDesc');
  const roomModalFeatures = document.getElementById('roomModalFeatures');

  function openRoomModal(key) {
    const data = roomData[key];
    if (!data) return;
    roomModalImg.src = data.img; roomModalImg.alt = data.title;
    roomModalBadge.textContent = data.badge; roomModalOccupants.textContent = data.occupants;
    roomModalTitle.textContent = data.title; roomModalDesc.textContent = data.desc;
    roomModalFeatures.innerHTML = data.features.map(f =>
      `<div class="room-modal-feature"><span class="room-modal-feature-icon">${roomIcons[f.icon]}</span>${f.label}</div>`
    ).join('');
    roomModalOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeRoomModal() {
    roomModalOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('.gal-item[data-room]').forEach(item => {
    item.addEventListener('click', () => openRoomModal(item.dataset.room));
  });
  document.getElementById('roomModalClose').addEventListener('click', closeRoomModal);
  document.getElementById('roomModalCloseBtn').addEventListener('click', closeRoomModal);
  roomModalOverlay.addEventListener('click', (e) => { if (e.target === roomModalOverlay) closeRoomModal(); });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && roomModalOverlay.classList.contains('open')) closeRoomModal();
  });

  const cursorGlow = document.getElementById('cursorGlow');
  if (window.matchMedia('(pointer: fine)').matches) {
    document.addEventListener('mousemove', (e) => {
      cursorGlow.style.left = e.clientX + 'px';
      cursorGlow.style.top = e.clientY + 'px';
    });
  } else {
    cursorGlow.style.display = 'none';
  }

  (function(){
    const ANSWERS = [
      { id: 'solo', keys: ['solo','1 person','1 occupant','private room','single room','para sa isa','isang tao'], answer: "🛏️ The Solo Room is a private semi-furnished room for 1 student. It includes 1 bed, 1 wardrobe, a study desk, your own private bathroom, and an aircon slot. Perfect if you love your own space!", follow: ['double','amenities','price'] },
      { id: 'sleepover', keys: ['sleepover', 'visiting', 'guest', 'stay over', 'stay the night', 'matulog', 'makitulog'], answer: "Only Female family members, friends, or classmates are allowed to stay overnight. However, tenants must first submit a 'Sleepover of Non-Tenants' request through the DormEase app. The overnight stay will only be permitted once the request has been approved, and a ₱200 sleepover fee must be paid."},    { id: 'double', keys: ['double','2 person','2 occupant','two person','for two','room for 2','dalawa','dalawang tao'], answer: "🛏️🛏️ The Double Room fits 2 students. Each gets their own bed and wardrobe, plus a shared study area, private bathroom, and an aircon slot. Great for roommates!", follow: ['triple','amenities','price'] },
      { id: 'triple', keys: ['triple','3 person','3 occupant','three person','for three','room for 3','tatlo','tatlong tao'], answer: "🛏️🛏️🛏️ The Triple Room fits 3 students — 3 beds, 3 wardrobes, a shared study corner, private bathroom, and aircon slot. Spacious and perfect for study groups!", follow: ['quad','amenities','price'] },
      { id: 'quad', keys: ['quad','4 person','4 occupant','four person','for four','room for 4','apat','apat na tao'], answer: "🛏️×4 The Quad Room is best value for 4 students. It has 4 beds, communal storage, shared study space, private bathroom, and an aircon slot. Ideal for friend groups!", follow: ['solo','amenities','price'] },
      { id: 'roomtypes', keys: ['room type','room types','available room','what room','kinds of room','types of room','ano ang kwarto','uri ng kwarto','what rooms are available'], answer: "🏠 We have four room types:\n\n• Solo Room — 1 student, fully private\n• Double Room — 2 students, individual beds & wardrobes\n• Triple Room — 3 students, spacious shared setup\n• Quad Room — 4 students, best value option\n\nAll rooms include a private bathroom and aircon slot. Want details on a specific type?", follow: ['solo','price','amenities'] },
      { id: 'price', keys: ['price','rate','fee','cost','how much','monthly','rent','bayad','magkano','presyo','rental fee','room rate'], answer: "💰 For the latest room rates and availability, please contact us directly:\n\n📞 +63 917 535 9723\n📍 1229 Navarra St., Sampaloc, Manila\n\nOur admin team will give you an updated price list!", follow: ['contact','roomtypes','apply'] },
      { id: 'curfew', keys: ['curfew','gating time','lock time','gate time','anong oras pasok','uwi','gabi}','hours}','anong oras}','gate close}','time in}','time out'], answer: "🕙 Our curfew is strictly at 10:00 PM every night. Tenants arriving later must coordinate with the front desk in advance. Late arrivals without prior notice may not be allowed in.", follow: ['rules ','visitor ','security '] },
      { id: 'visitor', keys: ['visitor','bisita','guest','bring visitor','male visitor','lalaki','boyfriend','puwede bang magdala','pwede bang magdala','visitor policy','bisita policy'], answer: "👤 All visitors must register at the front desk before entering. Visitors are only allowed in common areas and must leave before curfew. Male visitors are not permitted inside dormitory rooms.", follow: ['curfew','rules','security'] },
      { id: 'inspection', keys: ['inspection','inspect','room check','room inspection','linis','clean room','cleanliness check','monthly inspection'], answer: "🔍 Monthly room inspections are conducted to ensure cleanliness and safety. Tenants are notified in advance via DormEase announcements. Please keep your room tidy and free of prohibited items.", follow: ['rules','dormease','announcements'] },
      { id: 'rules', keys: ['rule','rules','policy','policies','conduct','allowed','prohibited','bawal','alak','alcohol','house rule','house rules','dorm rules','dorm policy'], answer: "📋 Key house rules:\n\n• Curfew at 10:00 PM strictly enforced\n• All visitors must register at the front desk\n• Male visitors not allowed inside rooms\n• No alcohol or illegal substances\n• No cooking appliances without admin approval\n• Noise must be minimal, especially at night\n• Monthly room inspections conducted\n• Own furniture allowed with admin permission\n\nViolations may result in a warning or termination of tenancy.", follow: ['curfew','visitor','furniture'] },
      { id: 'wifi', keys: ['wifi','wi-fi','internet','connection','internet connection','may wifi','may internet','signal'], answer: "📶 Yes! Wi-Fi is available in the dormitory. For speed and coverage details, contact our admin at +63 917 535 9723.", follow: ['amenities','dormease','contact'] },
      { id: 'aircon', keys: ['aircon','air con','air conditioning','ac unit','malamig','cold room','may aircon','aircon slot'], answer: "❄️ Every room has an aircon slot — you can install your own air conditioning unit. Contact our admin for more details on aircon policies.", follow: ['amenities','furnished','price'] },
      { id: 'elevator', keys: ['elevator', 'elev', 'lift','may elevator','floor','storey','floors','palapag','piso','gaano kataas'], answer: "🏢 Sanctissimo Rosario is a 5-storey building with elevator access, so you don't have to worry about climbing stairs with your luggage!", follow: ['amenities','location','about'] },
      { id: 'bathroom', keys: ['bathroom','cr','comfort room','toilet','shower','own cr','private cr','banyo','may sariling cr','sariling banyo'], answer: "🚿 Every room has its own private bathroom — no sharing with other rooms. You get your own comfort room regardless of room type.", follow: ['amenities','roomtypes','furnished'] },
      { id: 'amenities', keys: ['amenity','amenities','facilities','what is included','kasama','may nandoon','what does it include','ano ang kasama','dorm facilities'], answer: "🏠 Our amenities include:\n\n• 24/7 Security + CCTV\n• Elevator access (5 floors)\n• Wi-Fi available\n• Private bathroom per room\n• Aircon slot in every room\n• Semi-furnished rooms (bed, wardrobe, desk)\n• Strong, reliable water supply\n• DormEase app for bills & announcements", follow: ['price','security','dormease'] },
      { id: 'nogym', keys: ['gym','pool','swimming pool','swimming','exercise room','fitness','may gym','may pool','may swimming'], answer: "ℹ️ Sanctissimo Rosario does not have a gym or swimming pool. However, we do have a safe, comfortable environment with Wi-Fi, elevator, private bathrooms, and 24/7 security. For fitness needs, there are nearby public facilities in the area.", follow: ['amenities','location','contact'] },
      { id: 'security', keys: ['security','cctv','camera','safe','safety','secure','guard','bantay','safe ba','is it safe','24 7','24/7 security'], answer: "🔒 We have 24/7 security with CCTV cameras throughout the building, a secure entry system, and front desk monitoring to keep all tenants safe at all times.", follow: ['rules','curfew','amenities'] },
      { id: 'water', keys: ['water supply','tubig','water bill','bill sa tubig','water interruption','water pressure','suplay ng tubig'], answer: "💧 We have a strong and reliable water supply. Water bills are tracked and viewable through the DormEase app. For billing questions, contact our admin team.", follow: ['dormease','price','contact'] },
      { id: 'location', keys: ['location','address','where','saan','how to get there','directions','map','navarra','sampaloc','manila','nasaan','how to go'], answer: "📍 We are located at 1229 Navarra Street, Sampaloc, Manila — just a short walk from UST and the University Belt area. Click the map on our homepage for full directions!", follow: ['near','transport','contact'] },
      { id: 'near', keys: ['near','close to','how far','malapit','ust','university','school','campus','espana','nearby','nearby places','paligid'], answer: "🎓 We are very close to UST (University of Santo Tomas) and the University Belt. Nearby landmarks include:\n\n• Barangay Hall — just around the corner\n• Tricycle station — steps away from the dorm\n• Major universities (FEU, CEU, UE) — short commute\n• Espana Blvd — easy jeepney and bus access", follow: ['transport','location','contact'] },
      { id: 'transport', keys: ['transport','tricycle','jeepney','commute','paano pumunta','how to commute','sakay','lrt','bus','mrt','tricycle station','trike'], answer: "🛺 Getting to the dorm is easy! There is a tricycle station right near the dormitory. You can also take a jeepney or bus along Espana Blvd and ride a tricycle to Navarra Street. The Barangay Hall is also nearby, making the area very accessible.", follow: ['location','near','contact'] },
      { id: 'barangay', keys: ['barangay','barangay hall','brgy','brgy hall','malapit sa barangay','near barangay'], answer: "🏛️ Yes! The Barangay Hall is located near the dormitory, making it very convenient for official documents, community services, and local needs.", follow: ['location','near','transport'] },
      { id: 'furniture', keys: ['furniture','bring furniture','own furniture','magdala ng gamit','sariling kasangkapan','ref','refrigerator','appliance','cabinet','sala set','pwede magdala','puwede magdala','bring own','own items','furniture policy','kasangkapan'], answer: "🛋️ Yes, tenants may bring their own furniture or appliances! However, you will need to get the admin's permission first, and some paperwork will need to be completed. Please contact the admin team to find out the specific requirements before bringing in any additional furniture or appliances.\n\n📞 +63 917 535 9723\n📍 1229 Navarra St., Sampaloc, Manila", follow: ['rules','contact','apply'] },
      { id: 'apply', keys: ['apply','reserve','reservation','how to apply','how to avail','sign up','mag-apply','mag-reserve','slot','availability','available','vacant','book a room','how to reserve'], answer: "📝 To reserve a room:\n\n1️⃣ Call or message us at +63 917 535 9723\n2️⃣ Visit us at 1229 Navarra St., Sampaloc, Manila\n3️⃣ Our admin team will walk you through the requirements\n\nOnce you're a tenant, you'll get DormEase app access for all dorm services!", follow: ['requirements','price','contact'] },
      { id: 'requirements', keys: ['requirement','requirements','needed','documents','bring','id','contract','ano ang kailangan','papeles','what to bring','requirements to apply'], answer: "📄 For requirements and documentary needs, please contact our admin team directly:\n\n📞 +63 917 535 9723\n📍 1229 Navarra St., Sampaloc, Manila\n\nThey'll give you a complete checklist based on current policies.", follow: ['apply','contact','price'] },
      { id: 'contact', keys: ['contact','number','phone','call','message','reach','fb','facebook','instagram','ig','social media','email','makipag-ugnayan','how to contact','contact number'], answer: "📞 Contact us through:\n\n• Phone / Viber: +63 917 535 9723\n• Facebook: facebook.com/USTNavarra\n• Instagram: @SRBdormitory\n• Address: 1229 Navarra St., Sampaloc, Manila\n\nFeel free to drop by or message us anytime!", follow: ['location','apply','price'] },
      { id: 'dormease', keys: ['dormease','app','system','features','portal','how it works','platform','tenant app','dorm app','what is dormease'], answer: "📱 DormEase is our dormitory management app for all tenants. Features include:\n\n• View and track your water bill\n• Submit maintenance requests\n• Receive real-time announcements\n• Register visitors at the front desk\n• Access documents and notices\n• Emergency reports and alerts\n\nAll tenants get access upon move-in!", follow: ['apply','announcements','maintenance'] },
      { id: 'maintenance', keys: ['maintenance','repair','fix','broken','issue','request','problem','leaky','faucet','sira','report problem','report issue','repair request'], answer: "🔧 Tenants can submit maintenance requests directly through the DormEase app — just describe the issue and our team will respond. You can also track the status of your request in real time.", follow: ['dormease','announcements','water'] },
      { id: 'announcements', keys: ['announcement','notice','update','notification','alert','emergency','balita','dorm announcement','mga abiso'], answer: "📢 All announcements, notices, and emergency alerts are sent through the DormEase app in real time. You'll never miss an important update from the dorm administration!", follow: ['dormease','maintenance','rules'] },
      { id: 'furnished', keys: ['furnished','furniture included','semi-furnished','kasama na ba','what furniture','bed included','may bed','may lamesa','desk included','wardrobe included'], answer: "🛋️ All rooms are semi-furnished and include a bed, wardrobe/cabinet, and study desk per occupant. If you want to bring additional furniture or appliances, you may do so with admin permission and proper paperwork.", follow: ['furniture','aircon','amenities'] },
      { id: 'about', keys: ['about','sino kayo','what is','ano ang','history','about the dorm','tell me about','about dormitory'], answer: "🏠 Sanctissimo Rosario Ladies Dormitory is a five-storey residential building at 1229 Navarra Street, Sampaloc, Manila. We provide a safe, comfortable, and study-friendly home for female students near UST and the University Belt. The Barangay Hall and a tricycle station are conveniently located nearby.", follow: ['amenities','location','contact'] },
      { id: 'greeting', keys: ['hi','hello','hey','good morning','good afternoon','good evening','kumusta','kamusta','musta','magandang umaga','magandang hapon','magandang gabi'], answer: "👋 Hi there! Welcome to Sanctissimo Rosario Ladies Dormitory. I'm here to help you with anything about our rooms, amenities, rules, and more.\n\nWhat would you like to know?", follow: ['roomtypes','price','location'] },
      { id: 'thanks', keys: ['thank','thanks','salamat','ty','maraming salamat','thank you','appreciated'], answer: "😊 You're welcome! Feel free to ask anytime if you have more questions. We'd love to have you at Sanctissimo Rosario! 🏠", follow: ['apply','contact','price'] },
      { id: 'bye', keys: ['bye','goodbye','paalam','see you','sige na','take care'], answer: "👋 Take care! Feel free to come back anytime. We hope to welcome you to Sanctissimo Rosario soon! 🌸", follow: ['contact','apply','location'] },
      { id: 'pets', keys: ['pets','animal','dog','cat','animals'], answer: "🐾 Pets are not allowed in the dormitory. For more information, please contact our admin team directly.\n\n📞 +63 917 535 9723\n📍 1229 Navarra St., Sampaloc, Manila", follow: ['rules','contact','amenities'] }
    ];

    const SUGGESTION_MAP = {
      solo:          { icon: '🛏️', text: 'Solo rooms' },
      double:        { icon: '🛏️', text: 'Double rooms' },
      triple:        { icon: '🛏️', text: 'Triple rooms' },
      quad:          { icon: '🛏️', text: 'Quad rooms' },
      roomtypes:     { icon: '🏠', text: 'Room types' },
      price:         { icon: '💰', text: 'Monthly rate' },
      curfew:        { icon: '🕙', text: 'Curfew' },
      visitor:       { icon: '👤', text: 'Visitors' },
      inspection:    { icon: '🔍', text: 'Room inspections' },
      rules:         { icon: '📋', text: 'House rules' },
      wifi:          { icon: '📶', text: 'Wi-Fi' },
      aircon:        { icon: '❄️', text: 'Aircon slots' },
      elevator:      { icon: '🏢', text: 'Elevator' },
      bathroom:      { icon: '🚿', text: 'Own bathroom' },
      amenities:     { icon: '🏠', text: 'Amenities' },
      nogym:         { icon: 'ℹ️', text: 'Gym / Pool?' },
      security:      { icon: '🔒', text: 'Security' },
      water:         { icon: '💧', text: 'Water supply' },
      location:      { icon: '📍', text: 'Location' },
      near:          { icon: '🎓', text: 'Nearby places' },
      transport:     { icon: '🛺', text: 'How to commute' },
      barangay:      { icon: '🏛️', text: 'Barangay Hall' },
      furniture:     { icon: '🛋️', text: 'Bring furniture' },
      apply:         { icon: '📝', text: 'How to apply' },
      requirements:  { icon: '📄', text: 'Requirements' },
      contact:       { icon: '📞', text: 'Contact us' },
      dormease:      { icon: '📱', text: 'DormEase app' },
      maintenance:   { icon: '🔧', text: 'Report a repair' },
      announcements: { icon: '📢', text: 'Notices' },
      furnished:     { icon: '🛋️', text: 'Furniture included' },
      about:         { icon: 'ℹ️', text: 'About the dorm' }
    };

    function matchAnswer(text) {
      const t = text.toLowerCase().trim();
      for (const item of ANSWERS) {
        for (const kw of item.keys) {
          if (t.includes(kw)) return item;
        }
      }
      return null;
    }

    const chatBody      = document.getElementById('de-chat-body');
    const suggestionsEl = document.getElementById('de-suggestions');
    const chatWindow    = document.getElementById('de-chat-window');
    const chatBtn       = document.getElementById('de-chat-btn');
    const pulse         = document.getElementById('de-chat-pulse');
    const input         = document.getElementById('de-chat-input');
    const sendBtn       = document.getElementById('de-chat-send');
    const headerClose   = document.getElementById('de-cw-close-header');
    const clearBtn      = document.getElementById('de-cw-clear-btn');
    const policyPanel   = document.getElementById('de-policy-panel');
    const chatPanel     = document.getElementById('de-chat-panel');
    const policyYes     = document.getElementById('de-policy-yes');
    const policyNo      = document.getElementById('de-policy-no');

    let isOpen = false, initialized = false;

    function getTime() {
      return new Date().toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit' });
    }

    function toggleChat() {
      isOpen = !isOpen;
      chatWindow.classList.toggle('open', isOpen);
      chatBtn.classList.toggle('open', isOpen);
      pulse.style.display = isOpen ? 'none' : 'flex';
    }

    function closeChat() {
      isOpen = false;
      chatWindow.classList.remove('open');
      chatBtn.classList.remove('open');
      pulse.style.display = 'flex';
    }

    function resetToPolicy() {
      chatBody.innerHTML = '';
      clearSuggestions();
      input.value = '';
      initialized = false;
      chatPanel.style.display = 'none';
      policyPanel.style.display = 'flex';
    }

    chatBtn.addEventListener('click', toggleChat);
    if (headerClose) headerClose.addEventListener('click', closeChat);

    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        resetToPolicy();
      });
    }

    policyNo.addEventListener('click', () => {
      closeChat();
    });

    policyYes.addEventListener('click', () => {
      policyPanel.style.display = 'none';
      chatPanel.style.display = 'flex';
      if (!initialized) {
        initialized = true;
        startChat();
      }
      setTimeout(() => input.focus(), 100);
    });

    function addBotMsg(text, delay) {
      return new Promise(resolve => {
        const typingWrap = document.createElement('div');
        typingWrap.className = 'de-typing-bubble';
        typingWrap.innerHTML = `<div class="de-msg-ico"><svg viewBox="0 0 24 24"><path d="M3 11l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg></div><div class="de-typing"><span></span><span></span><span></span></div>`;
        chatBody.appendChild(typingWrap);
        chatBody.scrollTop = chatBody.scrollHeight;

        setTimeout(() => {
          typingWrap.remove();
          const msg = document.createElement('div');
          msg.className = 'de-msg bot';
          const lines = text.split('\n').map(l =>
            l ? `<span style="display:block;margin-bottom:2px">${l}</span>` : '<span style="display:block;height:4px"></span>'
          ).join('');
          msg.innerHTML = `<div class="de-msg-row"><div class="de-msg-ico"><svg viewBox="0 0 24 24"><path d="M3 11l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg></div><div class="de-msg-bubble">${lines}</div></div><span class="de-msg-time">${getTime()}</span>`;
          chatBody.appendChild(msg);
          chatBody.scrollTop = chatBody.scrollHeight;
          resolve();
        }, delay || 850);
      });
    }

    function addUserMsg(text) {
      const msg = document.createElement('div');
      msg.className = 'de-msg user';
      msg.innerHTML = `<div class="de-msg-row"><div class="de-msg-bubble">${text}</div></div><span class="de-msg-time">${getTime()}</span>`;
      chatBody.appendChild(msg);
      chatBody.scrollTop = chatBody.scrollHeight;
    }

    function clearSuggestions() { suggestionsEl.innerHTML = ''; }

    function showSuggestions(followIds) {
      clearSuggestions();
      const valid = (followIds || []).filter(id => SUGGESTION_MAP[id]).slice(0, 4);
      if (!valid.length) return;

      const lbl = document.createElement('div');
      lbl.className = 'de-suggestions-label';
      lbl.textContent = 'Quick topics';
      suggestionsEl.appendChild(lbl);

      const row = document.createElement('div');
      row.className = 'de-suggestions-row';

      valid.forEach(id => {
        const sug = SUGGESTION_MAP[id];
        const btn = document.createElement('button');
        btn.className = 'de-sug-btn';
        btn.innerHTML = `<span class="de-sug-icon">${sug.icon}</span>${sug.text}`;
        btn.addEventListener('click', () => handleUserMessage(sug.text));
        row.appendChild(btn);
      });

      suggestionsEl.appendChild(row);
    }

    async function handleUserMessage(text) {
      text = text.trim();
      if (!text) return;

      addUserMsg(text);
      clearSuggestions();
      input.value = '';

      const match = matchAnswer(text);

      if (match) {
        await addBotMsg(match.answer, 800);
        showSuggestions(match.follow);
      } else {
        await addBotMsg(
          "Hmm, I'm not sure about that one. 😊 For the best answer, reach out to us directly:\n\n📞 +63 917 535 9723\n📘 facebook.com/USTNavarra\n📍 1229 Navarra St., Sampaloc, Manila\n\nFeel free to try another question!",
          950
        );
        showSuggestions(['roomtypes','price','contact']);
      }
    }

    sendBtn.addEventListener('click', () => handleUserMessage(input.value));
    input.addEventListener('keydown', e => { if (e.key === 'Enter') handleUserMessage(input.value); });

    async function startChat() {
      await addBotMsg("Hi there! 👋 Welcome to Sanctissimo Rosario Ladies Dormitory. I'm here to help!", 700);
      await addBotMsg("Type any question below, or tap a topic to get started. 😊", 550);
      showSuggestions(['roomtypes','price','location']);
    }
  })();
</script>
</body>
</html>