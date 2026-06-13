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
      display: flex; flex-direction: column; gap: 2px;
      padding: 14px 16px; background: white;
      border: 1px solid var(--border); border-radius: 16px;
      cursor: default;
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s;
    }
    .hero-stat-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(232,23,93,0.14);
      border-color: var(--pink-light);
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
      animation: blobFloat 8s ease-in-out infinite;
    }
    .hero-blob-bottom {
      position: absolute; bottom: 14%; left: 2%; width: 160px; height: 150px;
      background: var(--pink-pale); border-radius: 70% 40% 60% 50% / 60% 80% 40% 70%;
      opacity: 0.75; z-index: 0;
      animation: blobFloat 11s ease-in-out infinite reverse;
    }
    @keyframes blobFloat {
      0%, 100% { transform: translate(0,0) scale(1); }
      33% { transform: translate(8px,-12px) scale(1.04); }
      66% { transform: translate(-6px,8px) scale(0.97); }
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
    .gal-item:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(36,16,24,0.14); }
    .gal-img-wrap { overflow:hidden; width:100%; aspect-ratio:1/1; }
    .gal-img { width:100%; height:100%; object-fit:cover; object-position:center; display:block; transition:transform .6s cubic-bezier(0.22,1,0.36,1); }
    .gal-item:hover .gal-img { transform:scale(1.08); }
    .gal-label { padding:16px 20px 20px; background:white; }
    .gal-label-top { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
    .gal-badge { background:var(--gradient-pink); color:white; font-size:0.68rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; padding:4px 12px; border-radius:100px; }
    .gal-occupants { font-size:0.82rem; color:var(--brown-light); font-weight:600; }
    .gal-title { font-family:var(--font-head); font-size:1rem; font-weight:700; color:var(--brown); margin-bottom:4px; }
    .gal-desc { font-size:0.85rem; color:var(--brown-light); line-height:1.7; }

    .gal-item-overlay {
      position: absolute; inset: 0 0 auto 0;
      height: 100%;
      background: linear-gradient(to top, rgba(36,16,24,0.55) 0%, transparent 50%);
      opacity: 0; transition: opacity 0.4s ease;
      pointer-events: none; border-radius: var(--r-lg) var(--r-lg) 0 0;
    }
    .gal-item:hover .gal-item-overlay { opacity: 1; }

    .how { background:var(--cream); position:relative; overflow:hidden; }
    .how::before { content:''; position:absolute; top:-200px; right:-200px; width:500px; height:500px; border-radius:50%; background:rgba(214,56,104,0.04); }
    .how-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
    .steps { display:flex; flex-direction:column; gap:30px; }
    .step { display:flex; gap:18px; align-items:flex-start; }
    .step-num { width:42px; height:42px; background:var(--gradient-pink); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--font-head); font-size:1rem; font-weight:800; flex-shrink:0; }
    .step-title { font-family:var(--font-head); font-size:1.0rem; font-weight:700; color:var(--brown); margin-bottom:5px; }
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
      .hero-stat-number { font-size: 1.3rem; }
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
      width: 320px; height: 320px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(232,23,93,0.07) 0%, transparent 70%);
      transform: translate(-50%, -50%);
      transition: left 0.12s ease, top 0.12s ease;
      mix-blend-mode: multiply;
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
    <div class="gal-item reveal from-bottom d1">
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
    <div class="gal-item reveal from-bottom d2">
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
    <div class="gal-item reveal from-bottom d3">
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
    <div class="gal-item reveal from-bottom d4">
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
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        obs.unobserve(e.target);
      }
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
      if (e.isIntersecting) {
        animateCounter(e.target);
        counterObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.5 });
  counterEls.forEach(el => counterObs.observe(el));

  const cursorGlow = document.getElementById('cursorGlow');
  if (window.matchMedia('(pointer: fine)').matches) {
    document.addEventListener('mousemove', (e) => {
      cursorGlow.style.left = e.clientX + 'px';
      cursorGlow.style.top = e.clientY + 'px';
    });
  } else {
    cursorGlow.style.display = 'none';
  }
</script>
</body>
</html>