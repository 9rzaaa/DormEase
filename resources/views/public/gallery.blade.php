<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DormEase Gallery</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --pink:          #E8175D;
      --pink-2:        #FF2D78;
      --gradient:      linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
      --pink-light:    #FF7FB0;
      --pink-pale:     #FFE4F0;
      --pink-deep:     #8A123B;
      --cream:         #fff7fb;
      --cream-dark:    #FFEAF3;
      --brown:         #241018;
      --brown-light:   #744B5D;
      --white:         #FFFFFF;
      --border:        rgba(232,23,93,0.18);
      --shadow:        0 4px 32px rgba(232,23,93,0.16);
      --shadow-card:   0 2px 20px rgba(36,16,24,0.09);
      --font-head:     'Montserrat', sans-serif;
      --font-body:     'Nunito', sans-serif;
      --r-md: 16px; --r-lg: 28px; --r-xl: 48px;
    }
    html { scroll-behavior: smooth; }
    body { font-family: var(--font-body); background: var(--cream); color: var(--brown); overflow-x: hidden; line-height: 1.6; }

    /* ── notice bar ── */
    .top-notice {
      position: fixed; top: 0; left: 0; right: 0; z-index: 300;
      min-height: 34px; display: flex; align-items: center; justify-content: center;
      padding: 6px 5%; background: var(--gradient);
      color: white; font-family: var(--font-head); font-size: .86rem; font-weight: 800; text-align: center;
    }

    /* ── nav ── */
    nav {
      position: fixed; top: 54px; left: 50%; z-index: 200;
      width: min(1220px, calc(100% - 12%)); transform: translateX(-50%);
      background: rgba(255,228,240,0.96); backdrop-filter: blur(16px);
      border: 1.5px solid rgba(36,16,24,0.78); border-radius: 999px;
      padding: 0 38px; height: 86px;
      display: flex; align-items: center; justify-content: space-between;
      transition: top .25s ease, box-shadow .3s;
    }
    nav.scrolled { top: 18px; box-shadow: 0 16px 34px rgba(36,16,24,0.12); }
    .nav-logo { display: flex; align-items: center; text-decoration: none; gap: 10px; }
    .nav-logo img { height: 58px; background: var(--gradient); border-radius: 50%; padding: 8px; filter: drop-shadow(0 2px 7px rgba(36,16,24,0.22)); }
    .nav-logo-fb { font-family: var(--font-head); font-size: 1.55rem; font-weight: 800; color: var(--brown); letter-spacing: -.02em; }
    .nav-logo-fb span { color: var(--pink); }
    .nav-links { display: flex; align-items: center; gap: 30px; list-style: none; }
    .nav-links a { text-decoration: none; font-size: .98rem; font-weight: 700; color: var(--brown); transition: color .2s; }
    .nav-links a:hover, .nav-links a.nav-active { color: var(--pink); }
    .nav-links a.nav-active { position: relative; }
    .nav-links a.nav-active::after { content: ''; position: absolute; bottom: -4px; left: 0; right: 0; height: 2.5px; border-radius: 99px; background: var(--gradient); }
    .nav-cta { background: var(--gradient) !important; color: white !important; padding: 11px 26px !important; border-radius: 100px !important; font-weight: 700 !important; box-shadow: 0 8px 18px rgba(232,23,93,0.24); transition: filter .2s, transform .15s !important; }
    .nav-cta:hover { filter: brightness(.94); transform: translateY(-1px); }

    /* ── hero carousel ── */
    .hero-carousel {
      position: relative; height: 100svh; min-height: 560px;
      overflow: hidden; background: var(--brown);
    }
    .carousel-overlay {
    pointer-events: none;
    }
  .carousel-cta {
    pointer-events: auto;
  }
    .carousel-track {
      display: flex; height: 100%;
      transition: transform .7s cubic-bezier(.77,0,.18,1);
    }
    .carousel-slide {
      min-width: 100%; height: 100%; position: relative; flex-shrink: 0;
    }
    .carousel-slide-img {
      width: 100%; height: 100%; object-fit: cover; object-position: center;
      filter: brightness(.55); transition: transform 8s ease;
      display: block;
    }
    .carousel-slide.active .carousel-slide-img { transform: scale(1.06); }

    .carousel-ph {
      width: 100%; height: 100%;
      background: linear-gradient(135deg, #3a1020 0%, #1a0810 100%);
      display: flex; align-items: center; justify-content: center;
      flex-direction: column; gap: 12px;
      color: rgba(255,255,255,.22); font-size: .75rem; font-weight: 700;
      letter-spacing: .08em; text-transform: uppercase;
    }
    .carousel-ph svg { width: 48px; height: 48px; stroke: rgba(255,255,255,.18); fill: none; stroke-width: 1.4; }

    .carousel-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(36,16,24,0.82) 0%, rgba(36,16,24,0.18) 55%, transparent 100%);
      display: flex; flex-direction: column; justify-content: flex-end;
      padding: 0 7% 80px;
    }
    .carousel-label {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,.12); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.18); border-radius: 100px;
      padding: 6px 18px; margin-bottom: 18px; width: fit-content;
    }
    .carousel-label-dot { width: 7px; height: 7px; background: var(--pink-light); border-radius: 50%; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }
    .carousel-label span { font-size: .72rem; font-weight: 700; letter-spacing: .10em; text-transform: uppercase; color: rgba(255,255,255,.80); }
    .carousel-title { font-family: var(--font-head); font-size: clamp(2.2rem,5vw,4rem); font-weight: 800; color: white; line-height: 1.08; letter-spacing: -.03em; margin-bottom: 12px; }
    .carousel-title em { color: var(--pink-light); font-style: italic; }
    .carousel-desc { font-size: 1rem; color: rgba(255,255,255,.62); max-width: 500px; line-height: 1.75; margin-bottom: 28px; }
    .carousel-cta { display: inline-flex; align-items: center; gap: 8px; background: var(--gradient); color: white; text-decoration: none; font-weight: 700; font-size: .9rem; padding: 13px 28px; border-radius: 100px; box-shadow: 0 8px 24px rgba(232,23,93,.32); transition: filter .2s, transform .15s; width: fit-content; }
    .carousel-cta:hover { filter: brightness(.94); transform: translateY(-2px); }

    /* carousel controls */
    .carousel-btn {
      position: absolute; top: 50%; transform: translateY(-50%);
      width: 52px; height: 52px; border-radius: 50%; border: none; cursor: pointer;
      background: rgba(255,255,255,.12); backdrop-filter: blur(10px);
      border: 1.5px solid rgba(255,255,255,.22);
      display: flex; align-items: center; justify-content: center;
      transition: background .2s, transform .2s; z-index: 10;
    }
    .carousel-btn:hover { background: rgba(255,255,255,.24); transform: translateY(-50%) scale(1.08); }
    .carousel-btn svg { width: 22px; height: 22px; stroke: white; fill: none; stroke-width: 2.2; stroke-linecap: round; }
    .carousel-prev { left: 28px; }
    .carousel-next { right: 28px; }

    /* dots */
    .carousel-dots {
      position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
      display: flex; gap: 8px; z-index: 10;
    }
    .carousel-dot {
      width: 8px; height: 8px; border-radius: 4px; border: none; cursor: pointer;
      background: rgba(255,255,255,.35); transition: all .3s; padding: 0;
    }
    .carousel-dot.active { width: 28px; background: white; }

    /* thumb strip */
    .carousel-thumbs {
      position: absolute; right: 28px; top: 50%; transform: translateY(-50%);
      display: flex; flex-direction: column; gap: 10px; z-index: 10;
    }
    .carousel-thumb {
      width: 64px; height: 48px; border-radius: 10px; overflow: hidden;
      border: 2px solid rgba(255,255,255,.18); cursor: pointer;
      transition: border-color .25s, transform .25s; flex-shrink: 0;
    }
    .carousel-thumb.active { border-color: white; transform: scale(1.08); }
    .carousel-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; filter: brightness(.7); transition: filter .25s; }
    .carousel-thumb.active img, .carousel-thumb:hover img { filter: brightness(1); }
    .carousel-thumb-ph { width: 100%; height: 100%; background: rgba(255,255,255,.08); display: flex; align-items: center; justify-content: center; }
    .carousel-thumb-ph svg { width: 18px; height: 18px; stroke: rgba(255,255,255,.3); fill: none; stroke-width: 1.6; }

    /* ── section heading ── */
    .section-wrap { padding: 72px 6% 0; }
    .section-tag { font-size: .70rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--pink); margin-bottom: 10px; }
    .section-title { font-family: var(--font-head); font-size: clamp(1.9rem,3.2vw,2.8rem); font-weight: 800; color: var(--brown); letter-spacing: -.03em; margin-bottom: 14px; }
    .section-title em { color: var(--pink); font-style: italic; }
    .section-sub { font-size: 1rem; color: var(--brown-light); line-height: 1.8; max-width: 520px; }

    /* ── filter bar ── */
    .filter-wrap {
      padding: 32px 6% 0;
      display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .filter-btn {
      padding: 10px 22px; border-radius: 100px;
      border: 1.5px solid var(--border); background: white;
      color: var(--brown-light); font-family: var(--font-body);
      font-size: .88rem; font-weight: 700; cursor: pointer; transition: all .25s;
    }
    .filter-btn:hover { border-color: var(--pink-light); color: var(--pink); background: var(--pink-pale); }
    .filter-btn.active { background: var(--gradient); color: white; border-color: transparent; box-shadow: 0 6px 18px rgba(232,23,93,.28); }
    .filter-count {
      display: inline-flex; align-items: center; justify-content: center;
      width: 20px; height: 20px; border-radius: 50%; font-size: .68rem; font-weight: 800;
      background: rgba(255,255,255,.25); margin-left: 4px;
    }
    .filter-btn:not(.active) .filter-count { background: var(--pink-pale); color: var(--pink); }

    /* ── masonry grid ── */
    .gallery-grid-wrap { padding: 40px 6% 80px; }
    .masonry {
      columns: 3; column-gap: 22px;
    }
    .masonry-item {
      break-inside: avoid; margin-bottom: 22px;
      opacity: 0; transform: translateY(24px);
      transition: opacity .5s ease, transform .5s ease;
    }
    .masonry-item.visible { opacity: 1; transform: translateY(0); }
    .masonry-item.hidden { display: none; }

    /* card */
    .gal-card {
      background: white; border-radius: var(--r-lg); overflow: hidden;
      border: 1px solid var(--border); box-shadow: var(--shadow-card);
      cursor: pointer; transition: transform .3s, box-shadow .3s;
      position: relative;
    }
    .gal-card:hover { transform: translateY(-6px); box-shadow: var(--shadow); }
    .gal-card:hover .gal-img { transform: scale(1.05); }
    .gal-card:hover .gal-overlay { opacity: 1; }

    .gal-img-wrap { overflow: hidden; width: 100%; position: relative; }
    .gal-img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .55s ease; }

    .gal-overlay {
      position: absolute; inset: 0; opacity: 0; transition: opacity .3s;
      background: linear-gradient(to top, rgba(36,16,24,.75) 0%, transparent 60%);
      display: flex; align-items: flex-end; justify-content: space-between; padding: 16px;
    }
    .gal-overlay-tag { font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.85); letter-spacing: .06em; text-transform: uppercase; }
    .gal-overlay-zoom {
      width: 34px; height: 34px; border-radius: 50%;
      background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.25);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .gal-overlay-zoom svg { width: 14px; height: 14px; stroke: white; fill: none; stroke-width: 2.2; stroke-linecap: round; }

    /* card label */
    .gal-label { padding: 14px 18px 18px; }
    .gal-label-top { display: flex; align-items: center; gap: 8px; margin-bottom: 7px; flex-wrap: wrap; }
    .gal-badge { background: var(--gradient); color: white; font-size: .64rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 4px 12px; border-radius: 100px; }
    .gal-badge-cat { background: var(--pink-pale); color: var(--pink-deep); font-size: .64rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; padding: 4px 11px; border-radius: 100px; }
    .gal-title { font-family: var(--font-head); font-size: .94rem; font-weight: 700; color: var(--brown); margin-bottom: 4px; }
    .gal-desc { font-size: .82rem; color: var(--brown-light); line-height: 1.7; }

    /* img placeholder */
    .img-ph {
      background: linear-gradient(135deg, var(--cream-dark) 0%, #e8ddd4 100%);
      border: 2px dashed rgba(214,56,104,.22); display: flex; flex-direction: column;
      align-items: center; justify-content: center; gap: 8px;
      color: var(--brown-light); font-size: .70rem; font-weight: 700;
      text-align: center; letter-spacing: .05em; text-transform: uppercase;
      position: relative; overflow: hidden; min-height: 200px;
    }
    .img-ph::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(45deg, transparent, transparent 12px, rgba(214,56,104,.04) 12px, rgba(214,56,104,.04) 14px); }
    .img-ph-ico { width: 36px; height: 36px; background: rgba(214,56,104,.10); border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; }
    .img-ph-ico svg { width: 17px; height: 17px; stroke: var(--pink); fill: none; stroke-width: 1.8; stroke-linecap: round; }
    .img-ph span { position: relative; z-index: 1; }

    /* empty state */
    .no-results { display: none; text-align: center; padding: 70px 20px; }
    .no-results.show { display: block; }
    .no-results-emoji { font-size: 3rem; margin-bottom: 14px; }
    .no-results p { font-size: 1rem; color: var(--brown-light); }

    /* ── lightbox ── */
    .lightbox {
      position: fixed; inset: 0; z-index: 999;
      background: rgba(20,8,14,0.95); backdrop-filter: blur(12px);
      display: flex; align-items: center; justify-content: center; padding: 20px;
      opacity: 0; pointer-events: none; transition: opacity .3s;
    }
    .lightbox.open { opacity: 1; pointer-events: all; }
    .lightbox-inner {
      max-width: 940px; width: 100%; position: relative;
      transform: scale(.94); transition: transform .3s;
    }
    .lightbox.open .lightbox-inner { transform: scale(1); }
    .lightbox-img-wrap { border-radius: var(--r-lg); overflow: hidden; background: rgba(255,255,255,.04); }
    .lightbox-img { width: 100%; max-height: 72vh; object-fit: contain; display: block; }
    .lightbox-ph {
      width: 100%; min-height: 340px; border-radius: var(--r-lg);
      background: rgba(255,255,255,.04); border: 1.5px dashed rgba(255,255,255,.12);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 10px; color: rgba(255,255,255,.35); font-size: .80rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .08em;
    }
    .lightbox-ph svg { width: 38px; height: 38px; stroke: rgba(255,255,255,.25); fill: none; stroke-width: 1.4; }
    .lightbox-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 20px; gap: 16px; }
    .lightbox-caption-badge { display: inline-block; background: var(--gradient); color: white; font-size: .65rem; font-weight: 700; letter-spacing: .10em; text-transform: uppercase; padding: 4px 14px; border-radius: 100px; margin-bottom: 6px; }
    .lightbox-caption h3 { font-family: var(--font-head); font-size: 1.2rem; font-weight: 800; color: white; margin-bottom: 4px; }
    .lightbox-caption p { font-size: .86rem; color: rgba(255,255,255,.50); line-height: 1.7; max-width: 440px; }
    .lightbox-counter { font-size: .80rem; color: rgba(255,255,255,.35); font-weight: 700; white-space: nowrap; }
    .lightbox-close {
      position: absolute; top: -16px; right: -16px;
      width: 44px; height: 44px; border-radius: 50%;
      background: white; border: none; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 16px rgba(0,0,0,.3); transition: background .2s, transform .2s;
    }
    .lightbox-close:hover { background: var(--pink-pale); transform: scale(1.1); }
    .lightbox-close svg { width: 17px; height: 17px; stroke: var(--brown); fill: none; stroke-width: 2.4; stroke-linecap: round; }
    .lightbox-nav {
      position: absolute; top: 38%; transform: translateY(-50%);
      width: 48px; height: 48px; border-radius: 50%; border: none; cursor: pointer;
      background: rgba(255,255,255,.10); backdrop-filter: blur(8px);
      border: 1.5px solid rgba(255,255,255,.16);
      display: flex; align-items: center; justify-content: center; transition: background .2s;
    }
    .lightbox-nav:hover { background: rgba(255,255,255,.22); }
    .lightbox-nav svg { width: 20px; height: 20px; stroke: white; fill: none; stroke-width: 2.2; stroke-linecap: round; }
    .lightbox-prev { left: -62px; }
    .lightbox-next { right: -62px; }

    /* ── stats strip ── */
    .stats-strip {
      background: var(--brown); padding: 48px 6%;
      display: grid; grid-template-columns: repeat(4,1fr); gap: 1px;
      border-top: 1px solid rgba(255,255,255,.06);
    }
    .stat-item { text-align: center; padding: 24px 20px; position: relative; }
    .stat-item::after { content: ''; position: absolute; right: 0; top: 20%; height: 60%; width: 1px; background: rgba(255,255,255,.08); }
    .stat-item:last-child::after { display: none; }
    .stat-num { font-family: var(--font-head); font-size: 2.4rem; font-weight: 800; color: var(--pink-light); line-height: 1; margin-bottom: 6px; }
    .stat-label { font-size: .80rem; color: rgba(255,255,255,.40); font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }

    /* ── cta ── */
    .gallery-cta { background: var(--pink-pale); padding: 80px 6%; text-align: center; }
    .gallery-cta h2 { font-family: var(--font-head); font-size: clamp(1.9rem,3.5vw,2.8rem); font-weight: 800; color: var(--brown); letter-spacing: -.03em; margin-bottom: 14px; }
    .gallery-cta h2 em { color: var(--pink); font-style: italic; }
    .gallery-cta p { font-size: 1rem; color: var(--brown-light); max-width: 460px; margin: 0 auto 30px; line-height: 1.8; }
    .cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
    .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: var(--gradient); color: white; text-decoration: none; font-family: var(--font-body); font-size: .9rem; font-weight: 700; padding: 14px 32px; border-radius: 100px; box-shadow: 0 8px 24px rgba(232,23,93,.32); transition: filter .2s, transform .15s; }
    .btn-primary:hover { filter: brightness(.94); transform: translateY(-2px); }
    .btn-outline { display: inline-flex; align-items: center; gap: 8px; background: transparent; color: var(--brown); text-decoration: none; font-size: .9rem; font-weight: 600; padding: 13px 28px; border-radius: 100px; border: 1.5px solid rgba(36,16,24,.20); transition: border-color .2s, color .2s; }
    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }

    /* ── footer ── */
    footer { background: var(--brown); color: rgba(255,255,255,.48); padding: 64px 6% 40px; }
    .footer-inner { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 48px; }
    .footer-logo { display: flex; align-items: center; margin-bottom: 16px; text-decoration: none; }
    .footer-logo img { height: 56px; filter: drop-shadow(0 4px 12px rgba(0,0,0,.22)); }
    .footer-logo-fb { font-family: var(--font-head); font-size: 1.2rem; font-weight: 800; color: white; letter-spacing: -.02em; }
    .footer-logo-fb span { color: var(--pink-light); }
    .footer-brand p { font-size: .83rem; line-height: 1.75; max-width: 250px; }
    .footer-col h4 { font-size: .66rem; text-transform: uppercase; letter-spacing: .12em; color: rgba(255,255,255,.32); margin-bottom: 16px; font-weight: 700; }
    .footer-col a { display: block; font-size: .87rem; color: rgba(255,255,255,.52); text-decoration: none; margin-bottom: 10px; transition: color .2s; }
    .footer-col a:hover { color: var(--pink-light); }
    .footer-btm { border-top: 1px solid rgba(255,255,255,.07); padding-top: 24px; display: flex; justify-content: space-between; align-items: center; gap: 22px; font-size: .78rem; flex-wrap: wrap; }
    .footer-btm-right { display: flex; gap: 22px; align-items: center; flex-wrap: wrap; }
    .footer-links { display: flex; gap: 20px; flex-wrap: wrap; }
    .footer-btm a { color: rgba(255,255,255,.32); text-decoration: none; }
    .footer-btm a:hover { color: var(--pink-light); }
    .footer-socials { display: flex; gap: 12px; }
    .footer-social-icon { width: 46px; height: 46px; border-radius: 50%; background: #111; display: inline-flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid rgba(255,255,255,.14); transition: transform .2s, background .2s; text-decoration: none; position: relative; }
    .footer-social-icon:hover { transform: translateY(-2px); background: var(--pink); }
    .footer-social-icon img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

    /* scroll top */
    #scrollTopBtn { position: fixed; bottom: 32px; right: 32px; z-index: 999; width: 50px; height: 50px; border: none; border-radius: 50%; background: var(--gradient); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 8px 24px rgba(232,23,93,.36); opacity: 0; transform: translateY(16px) scale(.85); transition: opacity .3s, transform .3s; pointer-events: none; }
    #scrollTopBtn.visible { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
    #scrollTopBtn:hover { transform: translateY(-3px) scale(1.07); }
    #scrollTopBtn svg { width: 22px; height: 22px; stroke: white; fill: none; stroke-width: 2.4; stroke-linecap: round; }

    /* reveal */
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .d1{transition-delay:.10s} .d2{transition-delay:.20s} .d3{transition-delay:.30s}

    /* ── responsive ── */
    @media (max-width: 960px) {
      nav { top: 46px; height: auto; min-height: 76px; padding: 10px 5%; flex-wrap: wrap; border-radius: 28px; width: calc(100% - 28px); }
      nav.scrolled { top: 12px; }
      .top-notice { font-size: .74rem; min-height: 30px; }
      .nav-logo img { height: 44px; }
      .nav-logo-fb { font-size: 1.22rem; }
      .nav-links { gap: 0; margin-left: auto; }
      .nav-links li:not(:last-child) { display: none; }
      .masonry { columns: 2; }
      .carousel-thumbs { display: none; }
      .stats-strip { grid-template-columns: 1fr 1fr; }
      .stat-item:nth-child(2)::after { display: none; }
      .footer-inner { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
      .masonry { columns: 1; }
      .carousel-btn { width: 40px; height: 40px; }
      .carousel-prev { left: 12px; }
      .carousel-next { right: 12px; }
      .hero-carousel { min-height: 480px; }
      .carousel-overlay { padding: 0 5% 60px; }
      .stats-strip { grid-template-columns: 1fr 1fr; }
      .footer-inner { grid-template-columns: 1fr; }
      .lightbox-prev { left: 6px; } .lightbox-next { right: 6px; }
      .lightbox-close { top: 8px; right: 8px; }
      .lightbox-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
    }
  </style>
</head>
<body>

<div class="top-notice">Sanctissimo Rosario Ladies Dormitory &middot; Safe student housing near UST</div>

<nav id="navbar">
  <a href="{{ route('home') }}" class="nav-logo">
    <img src="{{ asset('images/logo.png') }}" alt="DormEase" onerror="this.style.display='none'">
    <span class="nav-logo-fb">Dorm<span>Ease</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="{{ route('gallery') }}" class="nav-active">Gallery</a></li>
    <li><a href="{{ route('home') }}#how">How it Works</a></li>
    <li><a href="{{ route('home') }}#about">About</a></li>
    <li><a href="{{ route('faqs') }}">FAQs</a></li>
    <li><a href="{{ route('home') }}#contact" class="nav-cta">Contact Us</a></li>
  </ul>
</nav>

{{-- ── hero carousel ── --}}
<div class="hero-carousel" id="heroCarousel">
  <div class="carousel-track" id="carouselTrack">

    <div class="carousel-slide active" id="slide-0">
      <img src="{{ asset('images/lobby2.jpg') }}" alt="Solo Room" class="carousel-slide-img"
           onerror="this.parentElement.innerHTML='<div class=carousel-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg><span>Add solo.jpg</span></div>'">
      <div class="carousel-overlay">
        <div class="carousel-label"><div class="carousel-label-dot"></div><span>Lobby</span></div>
        <h1 class="carousel-title">A warm and inviting<br><em>lobby experience</em></h1>
        <p class="carousel-desc">A comfortable and inviting space where guests can relax, meet, and feel at home the moment they arrive.</p>
        <a href="#gallery-section" class="carousel-cta">
          Explore All Rooms
          <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:white;fill:none;stroke-width:2.2;stroke-linecap:round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>

    <div class="carousel-slide" id="slide-1">
      <img src="{{ asset('images/pic1.jpg') }}" alt="Double Room" class="carousel-slide-img"
           onerror="this.parentElement.innerHTML='<div class=carousel-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg><span>Add pic1.jpg</span></div>'">
      <div class="carousel-overlay">
        <div class="carousel-label"><div class="carousel-label-dot"></div><span>Solo Room</span></div>
        <h1 class="carousel-title">Your own space,<br>your own <em>comfort</em></h1>
        <p class="carousel-desc">A private space designed for rest, study, and independence — simple, quiet, and all yours.</p>
        <a href="#gallery-section" class="carousel-cta">View All Photos</a>
      </div>
    </div>

    <div class="carousel-slide" id="slide-2">
      <img src="{{ asset('images/roomfor2.jpg') }}" alt="Triple Room" class="carousel-slide-img"
           onerror="this.parentElement.innerHTML='<div class=carousel-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg><span>Add three.jpg</span></div>'">
      <div class="carousel-overlay">
        <div class="carousel-label"><div class="carousel-label-dot"></div><span>Triple Room · 3 Occupants</span></div>
        <h1 class="carousel-title">More room,<br>more <em>laughter</em></h1>
        <p class="carousel-desc">Triple rooms for three — spacious, well-lit, and perfect for close-knit groups of students.</p>
        <a href="#gallery-section" class="carousel-cta">View All Photos</a>
      </div>
    </div>

    <div class="carousel-slide" id="slide-3">
      <img src="{{ asset('images/main.jpg') }}" alt="Building" class="carousel-slide-img"
           onerror="this.parentElement.innerHTML='<div class=carousel-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg><span>Add main.jpg</span></div>'">
      <div class="carousel-overlay">
        <div class="carousel-label"><div class="carousel-label-dot"></div><span>Sanctissimo Rosario · Sampaloc, Manila</span></div>
        <h1 class="carousel-title">Five storeys of <em>safety</em><br>near UST</h1>
        <p class="carousel-desc">Located at 1229 Navarra Street, Sampaloc — a secure, study-friendly home close to the University Belt.</p>
        <a href="tel:+639175359723" class="carousel-cta">
          <svg viewBox="0 0 20 20" style="width:16px;height:16px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
          Inquire Now
        </a>
      </div>
    </div>

  </div>

  {{-- controls --}}
  <button class="carousel-btn carousel-prev" id="carouselPrev" aria-label="Previous">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <button class="carousel-btn carousel-next" id="carouselNext" aria-label="Next">
    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
  </button>

  {{-- dots --}}
  <div class="carousel-dots" id="carouselDots">
    <button class="carousel-dot active" data-index="0"></button>
    <button class="carousel-dot" data-index="1"></button>
    <button class="carousel-dot" data-index="2"></button>
    <button class="carousel-dot" data-index="3"></button>
  </div>

  {{-- thumbnail strip --}}
  <div class="carousel-thumbs" id="carouselThumbs">
    <div class="carousel-thumb active" data-index="0">
      <img src="{{ asset('images/lobby2.jpg') }}" alt="Solo" onerror="this.parentElement.innerHTML='<div class=carousel-thumb-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/></svg></div>'">
    </div>
    <div class="carousel-thumb" data-index="1">
      <img src="{{ asset('images/pic1.jpg') }}" alt="Double" onerror="this.parentElement.innerHTML='<div class=carousel-thumb-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/></svg></div>'">
    </div>
    <div class="carousel-thumb" data-index="2">
      <img src="{{ asset('images/roomfor2.jpg') }}" alt="Triple" onerror="this.parentElement.innerHTML='<div class=carousel-thumb-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/></svg></div>'">
    </div>
    <div class="carousel-thumb" data-index="3">
      <img src="{{ asset('images/main.jpg') }}" alt="Building" onerror="this.parentElement.innerHTML='<div class=carousel-thumb-ph><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/></svg></div>'">
    </div>
  </div>
</div>

{{-- ── stats strip ── --}}
<div class="stats-strip">
  <div class="stat-item reveal"><div class="stat-num">4</div><div class="stat-label">Room Types</div></div>
  <div class="stat-item reveal d1"><div class="stat-num">5F</div><div class="stat-label">Storeys</div></div>
  <div class="stat-item reveal d2"><div class="stat-num">24/7</div><div class="stat-label">Security</div></div>
  <div class="stat-item reveal d3"><div class="stat-num">UST</div><div class="stat-label">Near Campus</div></div>
</div>

{{-- ── gallery section ── --}}
<div id="gallery-section">
  <div class="section-wrap reveal">
    <div class="section-tag">Photo Gallery</div>
    <h2 class="section-title">Inside <em>Sanctissimo Rosario</em></h2>
    <p class="section-sub">Browse our rooms, common areas, and amenities. Click any photo to view it in full.</p>
  </div>

  {{-- filter --}}
  <div class="filter-wrap reveal">
    <button class="filter-btn active" data-filter="all">All <span class="filter-count" id="cnt-all">11</span></button>
    <button class="filter-btn" data-filter="rooms">Rooms <span class="filter-count" id="cnt-rooms">4</span></button>
    <button class="filter-btn" data-filter="common">Common Areas <span class="filter-count" id="cnt-common">3</span></button>
    <button class="filter-btn" data-filter="amenities">Amenities <span class="filter-count" id="cnt-amenities">3</span></button>
    <button class="filter-btn" data-filter="exterior">Exterior <span class="filter-count" id="cnt-exterior">2</span></button>
  </div>

  {{-- masonry --}}
  <div class="gallery-grid-wrap">
    <div class="masonry" id="masonryGrid">

      {{-- rooms --}}
      <div class="masonry-item" data-cat="rooms">
        <div class="gal-card" data-title="Solo Room" data-badge="Solo" data-desc="Semi-furnished private room ideal for one student. Includes a bed, wardrobe, and study desk.">
          <div class="gal-img-wrap" style="aspect-ratio:4/3">
            <img src="{{ asset('images/roomfor1.jpg') }}" alt="Solo Room" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:220px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>solo.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Solo Room</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge">Solo</span><span class="gal-badge-cat">1 Occupant</span></div>
            <h3 class="gal-title">Solo Room</h3>
            <p class="gal-desc">Private room with bed,and study desk. </p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="rooms">
        <div class="gal-card" data-title="Double Room" data-badge="Double" data-desc="Semi-furnished room for two. Each occupant gets a bed, individual wardrobe, and shared study area.">
          <div class="gal-img-wrap" style="aspect-ratio:3/4">
            <img src="{{ asset('images/roomfor2.jpg') }}" alt="Double Room" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:280px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>two.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Double Room</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge">Double</span><span class="gal-badge-cat">2 Occupants</span></div>
            <h3 class="gal-title">Double Room</h3>
            <p class="gal-desc">Two beds and a shared study area for two students.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="rooms">
        <div class="gal-card" data-title="Triple Room" data-badge="Triple" data-desc="Spacious room for three students. Three beds, wardrobes, and a shared study corner.">
          <div class="gal-img-wrap" style="aspect-ratio:4/3">
            <img src="{{ asset('images/roomfor3.jpg') }}" alt="Triple Room" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:220px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>three.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Triple Room</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge">Triple</span><span class="gal-badge-cat">3 Occupants</span></div>
            <h3 class="gal-title">Triple Room</h3>
            <p class="gal-desc">Spacious room for three with beds and a shared study corner.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="rooms">
        <div class="gal-card" data-title="Quad Room" data-badge="Quad" data-desc="Best value for groups of four. Four beds and communal storage, fully utilized.">
          <div class="gal-img-wrap" style="aspect-ratio:4/3">
            <img src="{{ asset('images/roomfor4.jpg') }}" alt="Quad Room" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:220px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>four.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Quad Room</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge">Quad</span><span class="gal-badge-cat">4 Occupants</span></div>
            <h3 class="gal-title">Quad Room</h3>
            <p class="gal-desc">Best value for four — four beds and communal storage, fully utilized.</p>
          </div>
        </div>
      </div>

      {{-- common areas --}}
      <div class="masonry-item" data-cat="common">
        <div class="gal-card" data-title="Study Lounge" data-badge="Common Area" data-desc="A quiet shared study lounge available to all tenants on designated floors.">
          <div class="gal-img-wrap" style="aspect-ratio:16/9">
            <img src="{{ asset('images/studyarea.jpg') }}" alt="Study Lounge" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:180px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>lounge.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Common Area</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Common Area</span></div>
            <h3 class="gal-title">Study Lounge</h3>
            <p class="gal-desc">Quiet shared study area available to rooms.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="common">
        <div class="gal-card" data-title="Hallway" data-badge="Common Area" data-desc="Well-lit hallways with CCTV coverage on every floor for tenant safety.">
          <div class="gal-img-wrap" style="aspect-ratio:3/4">
            <img src="{{ asset('images/hallway.jpg') }}" alt="Hallway" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:260px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>hallway.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Common Area</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Common Area</span></div>
            <h3 class="gal-title">Hallway</h3>
            <p class="gal-desc">Well-lit CCTV-covered hallways on every floor for tenant safety.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="common">
        <div class="gal-card" data-title="Lobby & Reception" data-badge="Common Area" data-desc="Secure reception with 24/7 security staff and visitor registration.">
          <div class="gal-img-wrap" style="aspect-ratio:4/3">
            <img src="{{ asset('images/lobby.jpg') }}" alt="Lobby" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:220px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>lobby.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Common Area</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Common Area</span></div>
            <h3 class="gal-title">Lobby &amp; Reception</h3>
            <p class="gal-desc">Secure reception with 24/7 security staff and visitor registration.</p>
          </div>
        </div>
      </div>

      {{-- amenities --}}
      <div class="masonry-item" data-cat="amenities">
        <div class="gal-card" data-title="Private Bathroom" data-badge="Amenity" data-desc="Each room has its own private bathroom — clean, well-ventilated, and maintained regularly.">
          <div class="gal-img-wrap" style="aspect-ratio:3/4">
            <img src="{{ asset('images/bathroom.jpg') }}" alt="Bathroom" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:260px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>bathroom.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Amenity</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Amenity</span></div>
            <h3 class="gal-title">Private Bathroom</h3>
            <p class="gal-desc">Each room includes its own bathroom.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="amenities">
        <div class="gal-card" data-title="Elevator" data-badge="Amenity" data-desc="Elevator access for all floors — easy for tenants moving in or carrying loads.">
          <div class="gal-img-wrap" style="aspect-ratio:4/5">
            <img src="{{ asset('images/elevator.jpg') }}" alt="Elevator" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:240px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>elevator.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Amenity</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Amenity</span></div>
            <h3 class="gal-title">Elevator</h3>
            <p class="gal-desc">Elevator access for all floors — easy for tenants moving in or carrying loads.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="amenities">
        <div class="gal-card" data-title="CCTV & Security" data-badge="Amenity" data-desc="CCTV cameras throughout the building, monitored 24/7 by on-site security staff.">
          <div class="gal-img-wrap" style="aspect-ratio:16/9">
            <img src="{{ asset('images/cctv.jpg') }}" alt="CCTV" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:180px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>cctv.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Amenity</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Amenity</span></div>
            <h3 class="gal-title">CCTV &amp; Security</h3>
            <p class="gal-desc">Cameras throughout the building, monitored 24/7 by on-site security staff.</p>
          </div>
        </div>
      </div>

      {{-- exterior --}}
      <div class="masonry-item" data-cat="exterior">
        <div class="gal-card" data-title="Building Exterior" data-badge="Exterior" data-desc="Five-storey building at 1229 Navarra Street, Sampaloc, Manila — close to UST and the University Belt.">
          <div class="gal-img-wrap" style="aspect-ratio:3/4">
            <img src="{{ asset('images/main.jpg') }}" alt="Building Exterior" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:280px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>main.jpg</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Exterior</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Exterior</span></div>
            <h3 class="gal-title">Building Exterior</h3>
            <p class="gal-desc">Five-storey building at 1229 Navarra St., Sampaloc — close to UST and UBelt.</p>
          </div>
        </div>
      </div>

      <div class="masonry-item" data-cat="exterior">
        <div class="gal-card" data-title="Building Entrance" data-badge="Exterior" data-desc="Secure main entrance with guard station, key card access, and curfew enforcement.">
          <div class="gal-img-wrap" style="aspect-ratio:4/3">
            <img src="{{ asset('images/sancti.png') }}" alt="Building Entrance" class="gal-img" onerror="this.parentElement.innerHTML='<div class=img-ph style=min-height:220px><div class=img-ph-ico><svg viewBox=\'0 0 24 24\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div><span>sancti.png</span></div>'">
            <div class="gal-overlay"><span class="gal-overlay-tag">Exterior</span><div class="gal-overlay-zoom"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg></div></div>
          </div>
          <div class="gal-label">
            <div class="gal-label-top"><span class="gal-badge-cat">Exterior</span></div>
            <h3 class="gal-title">Building Entrance</h3>
            <p class="gal-desc">Secure main entrance with guard station and curfew enforcement.</p>
          </div>
        </div>
      </div>

    </div>

    <div class="no-results" id="noResults">
      <div class="no-results-emoji">📷</div>
      <p>No photos in this category yet.</p>
    </div>
  </div>
</div>

{{-- ── cta ── --}}
<div class="gallery-cta reveal">
  <h2>Ready to call this <em>home?</em></h2>
  <p>Contact us to inquire about room availability, pricing, and how to get started with DormEase.</p>
  <div class="cta-btns">
    <a href="tel:+639175359723" class="btn-primary">
      <svg viewBox="0 0 20 20" style="width:18px;height:18px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
      Call +63 917 535 9723
    </a>
    <a href="{{ route('home') }}#about" class="btn-outline">Learn More About Us</a>
  </div>
</div>

{{-- ── footer ── --}}
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
      <a href="#">Maintenance</a><a href="#">Announcements</a>
      <a href="#">Water Billing</a><a href="#">Visitor Log</a><a href="#">Emergency</a>
    </div>
    <div class="footer-col">
      <h4>Dormitory</h4>
      <a href="{{ route('home') }}#about">About</a>
      <a href="{{ route('gallery') }}">Gallery</a>
      <a href="#">Amenities</a>
      <a href="https://maps.google.com/?q=1235+Navarra+St,+Sampaloc,+Manila">Location</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="tel:+639175359723">+63 917 535 9723</a>
      <a href="#">1229 Navarra St.</a><a href="#">Sampaloc, Manila</a>
    </div>
  </div>
  <div class="footer-btm">
    <span>© 2026 DormEase: Sanctissimo Rosario Ladies Dormitory</span>
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
        <a href="#">Privacy Policy</a>
        <a href="{{ route('faqs') }}">FAQs</a>
        <a href="{{ route('login') }}">Admin Portal</a>
      </div>
    </div>
  </div>
</footer>

{{-- ── lightbox ── --}}
<div class="lightbox" id="lightbox">
  <div class="lightbox-inner">
    <button class="lightbox-close" id="lightboxClose">
      <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
      <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="lightbox-nav lightbox-next" id="lightboxNext">
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
    <div class="lightbox-img-wrap" id="lightboxImgWrap"></div>
    <div class="lightbox-footer">
      <div class="lightbox-caption" id="lightboxCaption"></div>
      <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>
  </div>
</div>

<button id="scrollTopBtn" aria-label="Scroll to top">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script>
  // nav
  const nav = document.getElementById('navbar');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 20));

  // scroll top
  const scrollTopBtn = document.getElementById('scrollTopBtn');
  window.addEventListener('scroll', () => scrollTopBtn.classList.toggle('visible', scrollY > 400));
  scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  // reveal
  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.08 });
  document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

  // masonry reveal
  const itemObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.05 });
  document.querySelectorAll('.masonry-item').forEach(el => itemObs.observe(el));

  // ── carousel ──
  const track  = document.getElementById('carouselTrack');
  const slides  = track.querySelectorAll('.carousel-slide');
  const dots    = document.querySelectorAll('.carousel-dot');
  const thumbs  = document.querySelectorAll('.carousel-thumb');
  let current  = 0;
  let autoTimer = null;

  function goTo(n) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    thumbs[current]?.classList.remove('active');
    current = (n + slides.length) % slides.length;
    track.style.transform = `translateX(-${current * 100}%)`;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
    thumbs[current]?.classList.add('active');
  }

  function startAuto() {
    stopAuto();
    autoTimer = setInterval(() => goTo(current + 1), 5000);
  }
  function stopAuto() { clearInterval(autoTimer); }

  document.getElementById('carouselPrev').addEventListener('click', () => { goTo(current - 1); startAuto(); });
  document.getElementById('carouselNext').addEventListener('click', () => { goTo(current + 1); startAuto(); });
  dots.forEach(d => d.addEventListener('click', () => { goTo(+d.dataset.index); startAuto(); }));
  thumbs.forEach(t => t.addEventListener('click', () => { goTo(+t.dataset.index); startAuto(); }));

  // swipe support
  let touchX = 0;
  track.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', e => {
    const diff = touchX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) { goTo(diff > 0 ? current + 1 : current - 1); startAuto(); }
  });

  startAuto();

  // ── filter ──
  const filterBtns  = document.querySelectorAll('.filter-btn');
  const items       = document.querySelectorAll('.masonry-item');
  const noResults   = document.getElementById('noResults');
  const cats        = ['rooms', 'common', 'amenities', 'exterior'];

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      let visible = 0;
      items.forEach(item => {
        const match = filter === 'all' || item.dataset.cat === filter;
        item.classList.toggle('hidden', !match);
        if (match) visible++;
      });
      noResults.classList.toggle('show', visible === 0);
    });
  });

  // update counts
  cats.forEach(cat => {
    const el = document.getElementById('cnt-' + cat);
    if (el) el.textContent = document.querySelectorAll(`.masonry-item[data-cat="${cat}"]`).length;
  });
  document.getElementById('cnt-all').textContent = items.length;

  // ── lightbox ──
  const lightbox        = document.getElementById('lightbox');
  const lightboxClose   = document.getElementById('lightboxClose');
  const lightboxPrev    = document.getElementById('lightboxPrev');
  const lightboxNext    = document.getElementById('lightboxNext');
  const lightboxImgWrap = document.getElementById('lightboxImgWrap');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const lightboxCounter = document.getElementById('lightboxCounter');
  let lbIndex = 0;
  let lbItems = [];

  function getVisibleItems() {
    return [...items].filter(i => !i.classList.contains('hidden'));
  }

  function openLightbox(idx) {
    lbItems = getVisibleItems();
    lbIndex = idx;
    renderLightbox();
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  }

  function renderLightbox() {
    const item  = lbItems[lbIndex];
    const card  = item.querySelector('.gal-card');
    const img   = item.querySelector('.gal-img');
    const title = card.dataset.title ?? '';
    const badge = card.dataset.badge ?? '';
    const desc  = card.dataset.desc  ?? '';
    const src   = img?.src ?? '';

    if (src && !src.includes('onerror')) {
      lightboxImgWrap.innerHTML = `<img src="${src}" alt="${title}" class="lightbox-img">`;
    } else {
      lightboxImgWrap.innerHTML = `<div class="lightbox-ph"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg><span>${title}</span></div>`;
    }

    lightboxCaption.innerHTML = `<span class="lightbox-caption-badge">${badge}</span><h3>${title}</h3><p>${desc}</p>`;
    lightboxCounter.textContent = `${lbIndex + 1} / ${lbItems.length}`;
    lightboxPrev.style.visibility = lbIndex === 0 ? 'hidden' : 'visible';
    lightboxNext.style.visibility = lbIndex === lbItems.length - 1 ? 'hidden' : 'visible';
  }

  items.forEach((item) => {
    item.querySelector('.gal-card').addEventListener('click', () => {
      lbItems = getVisibleItems();
      openLightbox(lbItems.indexOf(item));
    });
  });

  lightboxClose.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
  lightboxPrev.addEventListener('click', () => { if (lbIndex > 0) { lbIndex--; renderLightbox(); } });
  lightboxNext.addEventListener('click', () => { if (lbIndex < lbItems.length - 1) { lbIndex++; renderLightbox(); } });

  document.addEventListener('keydown', e => {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft'  && lbIndex > 0)                  { lbIndex--; renderLightbox(); }
    if (e.key === 'ArrowRight' && lbIndex < lbItems.length - 1) { lbIndex++; renderLightbox(); }
  });

  // swipe lightbox
  let lbTouchX = 0;
  lightbox.addEventListener('touchstart', e => { lbTouchX = e.touches[0].clientX; }, { passive: true });
  lightbox.addEventListener('touchend', e => {
    const diff = lbTouchX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) {
      if (diff > 0 && lbIndex < lbItems.length - 1) { lbIndex++; renderLightbox(); }
      if (diff < 0 && lbIndex > 0)                  { lbIndex--; renderLightbox(); }
    }
  });
</script>
</body>
</html>