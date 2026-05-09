<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DormEase – Sanctissimo Rosario Ladies Dormitory</title>

<!--
=======================================================================
  DORMEASE LANDING PAGE

  IMAGE SLOTS SUMMARY — search "IMAGE SLOT" to jump to each one:
    Slot 1 – NAV LOGO          → src/images/logo.png            160×40px PNG transparent
    Slot 2 – HERO BACKGROUND   → src/images/hero-bg.jpg         1920×1080px (optional)
    Slot 3 – APP MOCKUP        → src/images/app-mockup.png      560×800px PNG transparent
    Slot 4 – ABOUT EXTERIOR    → src/images/dorm-exterior.jpg   800×520px
    Slot 5 – ABOUT ROOM        → src/images/dorm-room.jpg       800×360px
    Slot 6 – GALLERY MAIN      → src/images/gallery-1.jpg       600×900px
    Slot 7 – GALLERY TOP-RIGHT → src/images/gallery-2.jpg       600×400px
    Slot 8 – GALLERY BOT-RIGHT → src/images/gallery-3.jpg       600×400px
    Slot 9 – FOOTER LOGO       → src/images/logo-white.png      160×40px white version

  Laravel asset path syntax:  src="{{ asset('images/filename.ext') }}"
  Plain HTML path syntax:     src="src/images/filename.ext"
=======================================================================
-->

<!-- Fonts: Montserrat (Headlines) + Nunito (Body – closest open-source to Google Sans) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!--
  NOTE ON GOOGLE SANS:
  "Google Sans" is not publicly available on Google Fonts.
  Nunito is the closest open-source match (similar x-height, roundness, weight range).
  If you have access to Google Sans, replace --font-body below with:
    font-family: 'Google Sans', 'Nunito', sans-serif;
  and serve it from your Laravel public/fonts folder via @font-face.
-->

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --pink:        #D63868;
  --pink-light:  #F4A8C0;
  --pink-pale:   #FDE8EF;
  --pink-deep:   #9C2046;
  --cream:       #FBF6F0;
  --cream-dark:  #F2EAE2;
  --brown:       #3A2010;
  --brown-mid:   #6B3D25;
  --brown-light: #9A6850;
  --white:       #FFFFFF;
  --border:      rgba(214,56,104,0.15);
  --font-head:   'Montserrat', 'Segoe UI', sans-serif;
  --font-body:   'Nunito', 'Google Sans', sans-serif;
  --shadow-soft: 0 4px 32px rgba(214,56,104,0.12);
  --shadow-card: 0 2px 20px rgba(58,32,16,0.08);
  --r-sm: 8px; --r-md: 16px; --r-lg: 28px; --r-xl: 48px;
}

html { scroll-behavior: smooth; }
body { font-family: var(--font-body); background: var(--cream); color: var(--brown); overflow-x: hidden; line-height: 1.6; }

/* ── IMAGE PLACEHOLDER UTILITY ── */
.img-ph {
  background: linear-gradient(135deg, var(--cream-dark) 0%, #e8ddd4 100%);
  border: 2px dashed rgba(214,56,104,0.30);
  border-radius: var(--r-md);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 10px;
  color: var(--brown-light);
  font-family: var(--font-body);
  font-size: 0.72rem; font-weight: 700;
  text-align: center; letter-spacing: 0.05em;
  text-transform: uppercase;
  position: relative; overflow: hidden;
}
.img-ph::before {
  content: '';
  position: absolute; inset: 0;
  background: repeating-linear-gradient(45deg, transparent, transparent 12px, rgba(214,56,104,0.04) 12px, rgba(214,56,104,0.04) 14px);
}
.img-ph-ico {
  width: 40px; height: 40px;
  background: rgba(214,56,104,0.10);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  position: relative; z-index: 1;
}
.img-ph-ico svg { width: 20px; height: 20px; stroke: var(--pink); fill: none; stroke-width: 1.8; stroke-linecap: round; }
.img-ph span { position: relative; z-index: 1; line-height: 1.6; }

/* ── NAV ── */
nav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 100;
  background: rgba(253, 232, 239, 0.95);
  backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--border);
  padding: 0 6%; height: 70px;
  display: flex; align-items: center; justify-content: space-between;
  transition: box-shadow 0.3s;
}
nav.scrolled { box-shadow: var(--shadow-soft); }

/* ── IMAGE SLOT 1: NAV LOGO ──────────────────────────────────────
   Plain HTML:  <img src="src/images/logo.png" ...>
   Laravel:     <img src="{{ asset('images/logo.png') }}" ...>
   Size: 160×40px PNG with transparency recommended.
──────────────────────────────────────────────────────────────── */
.nav-logo { display: flex; align-items: center; text-decoration: none; gap: 10px; }
.nav-logo img { height: 38px; width: auto; object-fit: contain; display: block; filter: drop-shadow(0 2px 4px rgba(58, 32, 16, 0.2)); }
.nav-logo-fb {
  font-family: var(--font-head); font-size: 1.3rem; font-weight: 800;
  color: var(--brown); letter-spacing: -0.02em;
}
.nav-logo-fb span { color: var(--pink); }

.nav-links { display: flex; align-items: center; gap: 36px; list-style: none; }
.nav-links a {
  text-decoration: none; font-size: 0.875rem; font-weight: 500;
  color: var(--brown-light); letter-spacing: 0.01em; transition: color 0.2s;
}
.nav-links a:hover { color: var(--pink); }
.nav-cta {
  background: var(--pink) !important; color: white !important;
  padding: 9px 24px !important; border-radius: 100px !important;
  font-weight: 700 !important; transition: background 0.2s, transform 0.15s !important;
}
.nav-cta:hover { background: var(--pink-deep) !important; transform: translateY(-1px); }

/* ── HERO ── */
.hero {
  min-height: 100svh; padding: 100px 6% 80px;
  display: grid; grid-template-columns: 1fr 1fr;
  align-items: center; gap: 64px;
  position: relative; overflow: hidden;
}
/* ── IMAGE SLOT 2: HERO BACKGROUND (optional) ────────────────────
   To add a background photo, add to .hero style:
     background-image: url('src/images/hero-bg.jpg');
     background-size: cover; background-position: center;
   Then adjust the ::before overlay opacity for readability.
──────────────────────────────────────────────────────────────── */
.hero::before {
  content: ''; position: absolute; top: -140px; right: -140px;
  width: 580px; height: 580px; border-radius: 50%;
  background: var(--pink-pale); z-index: 0;
}
.hero::after {
  content: ''; position: absolute; bottom: -80px; left: 28%;
  width: 320px; height: 320px; border-radius: 50%;
  background: rgba(214,56,104,0.05); z-index: 0;
}
.hero-content { position: relative; z-index: 1; }

.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--pink-pale); border: 1px solid var(--pink-light);
  color: var(--pink-deep); font-size: 0.70rem; font-weight: 700;
  letter-spacing: 0.09em; text-transform: uppercase;
  padding: 6px 16px; border-radius: 100px; margin-bottom: 28px;
}
.hero-badge::before {
  content: ''; width: 6px; height: 6px;
  background: var(--pink); border-radius: 50%;
  animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

.hero h1 {
  font-family: var(--font-head);
  font-size: clamp(2.4rem, 4.5vw, 3.8rem);
  font-weight: 800; line-height: 1.1;
  color: var(--brown); margin-bottom: 24px; letter-spacing: -0.03em;
}
.hero h1 em { font-style: italic; color: var(--pink); font-weight: 700; }

.hero-sub {
  font-size: 1rem; color: var(--brown-light);
  line-height: 1.8; max-width: 460px; margin-bottom: 40px;
}
.hero-actions { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; }

.btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--pink); color: white; text-decoration: none;
  font-family: var(--font-body); font-size: 0.9rem; font-weight: 700;
  padding: 14px 32px; border-radius: 100px;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
  box-shadow: 0 8px 24px rgba(214,56,104,0.30);
}
.btn-primary:hover { background: var(--pink-deep); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(214,56,104,0.40); }
.btn-primary svg { width: 18px; height: 18px; fill: white; flex-shrink: 0; }

.btn-outline {
  display: inline-flex; align-items: center; gap: 8px;
  background: transparent; color: var(--brown); text-decoration: none;
  font-family: var(--font-body); font-size: 0.9rem; font-weight: 600;
  padding: 13px 28px; border-radius: 100px;
  border: 1.5px solid rgba(58,32,16,0.20);
  transition: border-color 0.2s, color 0.2s;
}
.btn-outline:hover { border-color: var(--pink); color: var(--pink); }

.hero-stats {
  display: flex; gap: 36px;
  margin-top: 48px; padding-top: 32px;
  border-top: 1px solid var(--border);
}
.hero-stat-num {
  font-family: var(--font-head); font-size: 2rem; font-weight: 800;
  color: var(--pink); line-height: 1;
}
.hero-stat-label {
  font-size: 0.70rem; color: var(--brown-light);
  margin-top: 4px; text-transform: uppercase; letter-spacing: 0.09em; font-weight: 700;
}

/* ── PHONE MOCKUP ── */
.hero-visual { position: relative; z-index: 1; display: flex; justify-content: center; align-items: center; }

/* ── IMAGE SLOT 3: APP MOCKUP ────────────────────────────────────
   Replace the entire .phone-frame div with:
     <img src="src/images/app-mockup.png" alt="DormEase App" class="app-mockup-img">
   In Laravel: src="{{ asset('images/app-mockup.png') }}"
   Add CSS:    .app-mockup-img { width:280px; animation: float 6s ease-in-out infinite; }
──────────────────────────────────────────────────────────────── */
.phone-frame {
  width: 276px; background: var(--brown); border-radius: 44px; padding: 11px;
  box-shadow: 0 40px 80px rgba(58,32,16,0.28), 0 0 0 1px rgba(58,32,16,0.12);
  position: relative; animation: float 6s ease-in-out infinite;
}
@keyframes float { 0%,100%{transform:translateY(0) rotate(-1.5deg)} 50%{transform:translateY(-18px) rotate(-0.5deg)} }
.phone-notch { width: 76px; height: 26px; background: var(--brown); border-radius: 100px; margin: 0 auto 8px; }
.phone-screen { background: #FFF0F5; border-radius: 34px; overflow: hidden; min-height: 500px; }
.phone-status { background:var(--pink); padding:10px 20px 5px; color:white; font-size:10px; font-weight:600; display:flex; justify-content:space-between; }
.phone-app-bar { background:var(--pink); padding:8px 20px 14px; font-family:var(--font-head); font-size:15px; font-weight:700; color:white; text-align:center; }
.phone-body { padding:14px; }
.phone-greeting { font-size:11px; color:var(--brown-light); margin-bottom:2px; }
.phone-name { font-family:var(--font-head); font-size:17px; font-weight:700; color:var(--brown); margin-bottom:13px; }
.phone-card { background:white; border-radius:13px; padding:11px; margin-bottom:8px; box-shadow:var(--shadow-card); display:flex; align-items:center; gap:10px; }
.phone-card-icon { width:37px; height:37px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.phone-card-title { font-size:11px; font-weight:600; color:var(--brown); font-family:var(--font-body); }
.phone-card-sub { font-size:9px; color:var(--brown-light); margin-top:2px; }
.badge-l { background:#FFF3CD; color:#856404; font-size:8px; padding:2px 6px; border-radius:100px; font-weight:700; }
.badge-h { background:#FFE0E8; color:var(--pink-deep); font-size:8px; padding:2px 6px; border-radius:100px; font-weight:700; }
.phone-tabs { display:grid; grid-template-columns:repeat(5,1fr); border-top:1px solid rgba(214,56,104,0.10); padding:7px 0 3px; margin-top:6px; }
.phone-tab { text-align:center; }
.t-icon { font-size:15px; color:#ccc; display:block; }
.t-icon.on { color:var(--pink); }
.t-lbl { font-size:7px; color:#bbb; display:block; margin-top:1px; font-weight:600; }
.t-lbl.on { color:var(--pink); }

.fl-card { position:absolute; background:white; border-radius:var(--r-md); padding:11px 15px; box-shadow:0 8px 32px rgba(58,32,16,0.12); border:1px solid var(--border); }
.fl-card.tr { top:30px; right:-56px; animation:f2 5s ease-in-out infinite; }
.fl-card.bl { bottom:80px; left:-76px; animation:f3 7s ease-in-out infinite; }
@keyframes f2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes f3 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(10px)} }
.fl-lbl { font-size:10px; color:var(--brown-light); font-weight:700; letter-spacing:.04em; text-transform:uppercase; }
.fl-val { font-family:var(--font-head); font-size:17px; font-weight:800; color:var(--pink); margin-top:2px; }

/* ── SECTION COMMONS ── */
section { padding: 100px 6%; }
.section-tag { font-size:.70rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
.section-title { font-family:var(--font-head); font-size:clamp(1.8rem,3.2vw,2.8rem); font-weight:800; line-height:1.15; color:var(--brown); letter-spacing:-.03em; margin-bottom:18px; }
.section-title em { color:var(--pink); font-style:italic; font-weight:700; }
.section-sub { font-size:1rem; color:var(--brown-light); line-height:1.8; max-width:540px; }

/* ── FEATURES ── */
.features { background:var(--cream); }
.features-header { max-width:620px; margin-bottom:60px; }
.features-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; }
.feat-card {
  background:white; border:1px solid var(--border); border-radius:var(--r-lg);
  padding:34px 26px; transition:transform .25s,box-shadow .25s;
  position:relative; overflow:hidden;
}
.feat-card::before {
  content:''; position:absolute; top:0; left:0; right:0; height:3px;
  background:linear-gradient(90deg,var(--pink),var(--pink-light));
  transform:scaleX(0); transform-origin:left; transition:transform .3s;
}
.feat-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-soft); }
.feat-card:hover::before { transform:scaleX(1); }
.feat-icon { width:50px; height:50px; background:var(--pink-pale); border-radius:var(--r-md); display:flex; align-items:center; justify-content:center; margin-bottom:18px; }
.feat-icon svg { width:25px; height:25px; stroke:var(--pink); fill:none; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
.feat-title { font-family:var(--font-head); font-size:1.0rem; font-weight:700; color:var(--brown); margin-bottom:8px; letter-spacing:-.01em; }
.feat-desc { font-size:.87rem; color:var(--brown-light); line-height:1.75; }


/* ── GALLERY ── */
.gallery { background:var(--cream-dark); padding-top:80px; padding-bottom:80px; }

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-top: 48px;
}

.gal-item {
  border-radius: var(--r-lg);
  overflow: hidden;
  position: relative;
  background: white;
  box-shadow: var(--shadow-card);
}

.gal-img-wrap {
  border-radius: 0;
  overflow: hidden;
  width: 100%;
  height: 320px;              
  background: none; 
}

.gal-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
  transition: transform .4s;
  background: none;
}

.gal-item:hover .gal-img { transform: scale(1.02); }

.gal-label {
  padding: 16px 20px 20px;
  background: white;
}

/* ── GALLERY LABEL ── */
.gal-label-top { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
.gal-badge {
  background: var(--pink); color: white;
  font-size: 0.68rem; font-weight: 700;
  letter-spacing: 0.08em; text-transform: uppercase;
  padding: 4px 12px; border-radius: 100px;
}
.gal-occupants { font-size: 0.82rem; color: var(--brown-light); font-weight: 600; }
.gal-title { font-family: var(--font-head); font-size: 1rem; font-weight: 700; color: var(--brown); margin-bottom: 4px; }
.gal-desc { font-size: 0.85rem; color: var(--brown-light); line-height: 1.7; }

/* ── HOW IT WORKS ── */
.how { background:var(--cream); position:relative; overflow:hidden; }
.how::before { content:''; position:absolute; top:-200px; right:-200px; width:500px; height:500px; border-radius:50%; background:rgba(214,56,104,0.04); }
.how-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
.steps { display:flex; flex-direction:column; gap:30px; }
.step { display:flex; gap:18px; align-items:flex-start; }
.step-num { width:42px; height:42px; background:var(--pink); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--font-head); font-size:1rem; font-weight:800; flex-shrink:0; }
.step-title { font-family:var(--font-head); font-size:1.0rem; font-weight:700; color:var(--brown); margin-bottom:5px; }
.step-desc { font-size:.87rem; color:var(--brown-light); line-height:1.75; }
.how-img-main { background:white; border-radius:var(--r-xl); box-shadow:var(--shadow-soft); padding:36px 28px; text-align:center; }
.mini-phones { display:flex; justify-content:center; gap:13px; }
.mini-ph { width:86px; background:var(--brown); border-radius:16px; padding:5px; box-shadow:0 10px 28px rgba(58,32,16,0.15); }
.mini-ph:nth-child(2) { transform:translateY(17px); }
.mini-scr { background:var(--pink-pale); border-radius:11px; height:152px; display:flex; flex-direction:column; }
.mini-hdr { background:var(--pink); border-radius:11px 11px 0 0; padding:7px; text-align:center; }
.mini-hdr-txt { font-size:6px; font-weight:700; color:white; font-family:var(--font-head); letter-spacing:.06em; }
.mini-bdy { padding:7px; flex:1; display:flex; flex-direction:column; gap:5px; }
.mini-row { background:white; border-radius:5px; height:17px; opacity:.8; }

/* ── ABOUT ── */
.about { background:var(--brown); color:white; position:relative; overflow:hidden; }
.about::before { content:''; position:absolute; bottom:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:rgba(214,56,104,0.13); }
.about-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; position:relative; z-index:1; }
.about .section-tag { color:var(--pink-light); }
.about .section-title { color:white; }
.about .section-sub { color:rgba(255,255,255,0.60); }
.amenities { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:32px; }
.amenity { display:flex; align-items:center; gap:10px; font-size:.85rem; color:rgba(255,255,255,0.78); }
.amenity-dot { width:7px; height:7px; background:var(--pink-light); border-radius:50%; flex-shrink:0; }

/* ── IMAGE SLOTS 4–5: ABOUT PHOTOS ──────────────────────────────
   Replace .img-ph divs with:
     <img src="src/images/dorm-exterior.jpg" alt="..." class="about-img">
   Laravel: src="{{ asset('images/dorm-exterior.jpg') }}"
   .about-img { width:100%; height:100%; object-fit:cover; display:block; }
──────────────────────────────────────────────────────────────── */
.about-photos { display:grid; grid-template-rows:260px 175px; gap:14px; }
.about-img { width:100%; height:100%; object-fit:cover; display:block; border-radius:var(--r-lg); }

.info-card { background:rgba(255,255,255,0.08); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.13); border-radius:var(--r-lg); padding:24px; }
.ic-lbl { font-size:.66rem; text-transform:uppercase; letter-spacing:.12em; color:var(--pink-light); margin-bottom:5px; font-weight:700; }
.ic-val { font-family:var(--font-head); font-size:2.2rem; font-weight:800; color:white; line-height:1; margin-bottom:2px; }
.ic-sub { font-size:.76rem; color:rgba(255,255,255,0.40); }
.ic-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.07); font-size:.80rem; }
.ic-row:last-child { border-bottom:none; }
.ic-rl { color:rgba(255,255,255,0.48); }
.ic-rv { color:white; font-weight:600; }

/* ── CTA ── */
.cta-section { background:var(--pink-pale); text-align:center; }
.cta-section .section-title { color:var(--brown); margin:0 auto 14px; }
.cta-section .section-sub { margin:0 auto 40px; color:var(--brown-light); }
.cta-contact { margin-top:26px; font-size:.88rem; color:var(--brown-light); }
.cta-contact a { color:var(--pink); text-decoration:none; font-weight:700; }

/* ── FOOTER ── */
footer { background:var(--brown); color:rgba(255,255,255,0.48); padding:64px 6% 40px; }
.footer-inner { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; margin-bottom:48px; }
.footer-logo { display:flex; align-items:center; margin-bottom:16px; text-decoration: none; }
/* ── IMAGE SLOT 9: FOOTER LOGO (white version) ───────────────────
   Plain HTML:  src="src/images/logo-white.png"
   Laravel:     src="{{ asset('images/logo-white.png') }}"
──────────────────────────────────────────────────────────────── */
.footer-logo img { height:32px; width:auto; object-fit:contain; }
.footer-logo-fb { font-family:var(--font-head); font-size:1.2rem; font-weight:800; color:white; letter-spacing:-.02em; }
.footer-logo-fb span { color:var(--pink-light); }
.footer-brand p { font-size:.83rem; line-height:1.75; max-width:250px; }
.footer-col h4 { font-size:.66rem; text-transform:uppercase; letter-spacing:.12em; color:rgba(255,255,255,0.32); margin-bottom:16px; font-weight:700; }
.footer-col a { display:block; font-size:.87rem; color:rgba(255,255,255,0.52); text-decoration:none; margin-bottom:10px; transition:color .2s; }
.footer-col a:hover { color:var(--pink-light); }
.footer-btm { border-top:1px solid rgba(255,255,255,0.07); padding-top:24px; display:flex; justify-content:space-between; align-items:center; font-size:.78rem; }
.footer-btm a { color:rgba(255,255,255,0.32); text-decoration:none; }
.footer-btm a:hover { color:var(--pink-light); }

/* ── ANIMATIONS ── */
.reveal { opacity:0; transform:translateY(28px); transition:opacity .7s ease,transform .7s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.d1{transition-delay:.10s} .d2{transition-delay:.20s} .d3{transition-delay:.30s} .d4{transition-delay:.40s}

/* ── RESPONSIVE ── */
@media(max-width:960px){
  .hero{grid-template-columns:1fr;padding-top:120px}
  .hero-visual{display:none}
  .features-grid{grid-template-columns:1fr 1fr}
  .gallery-grid{grid-template-columns:1fr 1fr;grid-template-rows:auto}
  .gal-item.tall{grid-row:span 1}
  .how-inner{grid-template-columns:1fr}
  .about-inner{grid-template-columns:1fr}
  .footer-inner{grid-template-columns:1fr 1fr}
  .nav-links li:not(:last-child){display:none}
}
@media(max-width:600px){
  .features-grid{grid-template-columns:1fr}
  .gallery-grid{grid-template-columns:1fr}
  .footer-inner{grid-template-columns:1fr}
  .hero h1{font-size:2.2rem}
}

</style>
</head>
<body>

<!-- ════════════════════ NAV ════════════════════ -->
<nav id="navbar">
  <a href="#" class="nav-logo">
    <!--
    ╔══════════════════════════════════════════════════════════╗
    ║  IMAGE SLOT 1 — LOGO                                    ║
    ║  Plain HTML:  src="src/images/logo.png"                 ║
    ║  Laravel:     src="{{ asset('images/logo.png') }}"      ║
    ║  Size: 160×40px, PNG with transparency                  ║
    ╚══════════════════════════════════════════════════════════╝
    -->
    <img src="{{ asset('images/logo.png') }}"
         alt="DormEase Logo"
         style="height: 38px; width: auto; object-fit: contain; display: block;"
         onerror="this.style.display='none'">
    <span class="nav-logo-fb" style="font-family: var(--font-head); font-size: 1.3rem; font-weight: 800; color: var(--brown); letter-spacing: -0.02em;">Dorm<span style="color: var(--pink);">Ease</span></span>
  </a>

  <ul class="nav-links">
    <li><a href="#features">Features</a></li>
    <li><a href="#gallery">Gallery</a></li>
    <li><a href="#how">How it Works</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact" class="nav-cta">Contact Us</a></li>
  </ul>
</nav>


<!-- ════════════════════ HERO ════════════════════ -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">Now available on web &amp; mobile</div>
    <h1>Your dorm life,<br><em>finally simplified</em></h1>
    <p class="hero-sub">
      DormEase brings Sanctissimo Rosario Ladies Dormitory into the digital age — manage maintenance, bills, visitor logs, and announcements all from one app.
    </p>
    <div class="hero-actions">
      <a href="#features" class="btn-primary">
        <svg viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9V9h2v4zm0-6H9V5h2v2z"/></svg>
        Explore Features
      </a>
      <a href="#contact" class="btn-outline">Contact the Dorm →</a>
    </div>
    <div class="hero-stats">
      <div><div class="hero-stat-num">57</div><div class="hero-stat-label">Tenants</div></div>
      <div><div class="hero-stat-num">25</div><div class="hero-stat-label">Units</div></div>
      <div><div class="hero-stat-num">5F</div><div class="hero-stat-label">Floors</div></div>
      <div><div class="hero-stat-num">24/7</div><div class="hero-stat-label">Security</div></div>
    </div>
  </div>

  <!--
  ╔══════════════════════════════════════════════════════════════╗
  ║  IMAGE SLOT 3 — APP MOCKUP                                  ║
  ║  To use a real screenshot, replace .phone-frame div with:   ║
  ║    <img src="src/images/app-mockup.png"                     ║
  ║         alt="DormEase App" class="app-mockup-img">          ║
  ║  Laravel: src="{{ asset('images/app-mockup.png') }}"        ║
  ║  Add CSS: .app-mockup-img{width:280px;animation:float...}   ║
  ╚══════════════════════════════════════════════════════════════╝
  -->
  <div class="hero-visual">
    <div class="fl-card tr">
      <div class="fl-lbl">Water Bill</div>
      <div class="fl-val">₱248.50</div>
      <div style="font-size:9px;color:#bbb;margin-top:2px;font-weight:600;">Due Feb 28</div>
    </div>

    <div class="phone-frame">
      <div class="phone-notch"></div>
      <div class="phone-screen">
        <div class="phone-status"><span>9:41</span><span>●●●</span></div>
        <div class="phone-app-bar">DormEase</div>
        <div class="phone-body">
          <div class="phone-greeting">Good morning,</div>
          <div class="phone-name">Maria Santos 👋</div>
          <div class="phone-card">
            <div class="phone-card-icon" style="background:#FFE0E8;">
              <svg viewBox="0 0 24 24" style="width:19px;height:19px;stroke:var(--pink);fill:none;stroke-width:2;stroke-linecap:round;"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
            </div>
            <div>
              <div class="phone-card-title">Water Billing</div>
              <div class="phone-card-sub">February 2026 &nbsp;<span class="badge-l">Low</span></div>
            </div>
          </div>
          <div class="phone-card">
            <div class="phone-card-icon" style="background:#FFE8F0;">
              <svg viewBox="0 0 24 24" style="width:19px;height:19px;stroke:var(--pink);fill:none;stroke-width:2;stroke-linecap:round;"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
              <div class="phone-card-title">Urgent Pest Control Notice</div>
              <div class="phone-card-sub">Feb 17 &nbsp;<span class="badge-h">High</span></div>
            </div>
          </div>
          <div class="phone-card">
            <div class="phone-card-icon" style="background:#E8F0FF;">
              <svg viewBox="0 0 24 24" style="width:19px;height:19px;stroke:#4A78D9;fill:none;stroke-width:2;stroke-linecap:round;"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div>
              <div class="phone-card-title">Visitor Registered</div>
              <div class="phone-card-sub">Ana Cruz · Today 2:00 PM</div>
            </div>
          </div>
          <div class="phone-tabs">
            <div class="phone-tab"><span class="t-icon on">⌂</span><span class="t-lbl on">Home</span></div>
            <div class="phone-tab"><span class="t-icon">👤</span><span class="t-lbl">Visitor</span></div>
            <div class="phone-tab"><span class="t-icon">⚠</span><span class="t-lbl">Emergency</span></div>
            <div class="phone-tab"><span class="t-icon">💧</span><span class="t-lbl">Water</span></div>
            <div class="phone-tab"><span class="t-icon">◯</span><span class="t-lbl">Profile</span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="fl-card bl">
      <div class="fl-lbl">Maintenance</div>
      <div style="font-size:11px;color:var(--pink);font-weight:700;margin-top:4px;">✓ Request Sent</div>
      <div style="font-size:9px;color:#bbb;margin-top:2px;font-weight:600;">Avg. 2hr response</div>
    </div>
  </div>
</section>


<!-- ════════════════════ FEATURES ════════════════════ -->
<section class="features" id="features">
  <div class="features-header reveal">
    <div class="section-tag">What We Offer</div>
    <h2 class="section-title">Everything your dorm<br>life needs, <em>in one place</em></h2>
    <p class="section-sub">From submitting a maintenance request by voice to tracking your water bill in real time — DormEase handles it all, digitally.</p>
  </div>
  <div class="features-grid">
    <div class="feat-card reveal d1">
      <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg></div>
      <div class="feat-title">Maintenance Requests</div>
      <p class="feat-desc">Submit repair requests via text or voice using NLP — no forms to fill. Track every request status in real time.</p>
    </div>
    <div class="feat-card reveal d2">
      <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg></div>
      <div class="feat-title">Announcements</div>
      <p class="feat-desc">Stay updated with dorm-wide announcements tagged by priority — Low, Medium, or High. Never miss a notice.</p>
    </div>
    <div class="feat-card reveal d3">
      <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg></div>
      <div class="feat-title">Water Billing</div>
      <p class="feat-desc">Automatic, transparent water bill calculation per floor and per room. Track payment history with full clarity.</p>
    </div>
    <div class="feat-card reveal d1">
      <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></div>
      <div class="feat-title">Visitor Registration</div>
      <p class="feat-desc">Digitally register and log all visitors. Monitor entries and exits in real time for building security.</p>
    </div>
    <div class="feat-card reveal d2">
      <div class="feat-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
      <div class="feat-title">Emergency Reporting</div>
      <p class="feat-desc">One-tap emergency alerts sent directly to dorm administration. Quick, reliable, and logged for accountability.</p>
    </div>
    <div class="feat-card reveal d3">
      <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
      <div class="feat-title">Document Processing</div>
      <p class="feat-desc">Request and receive important dorm documents digitally. No more queuing or filling out paper forms.</p>
    </div>
  </div>
</section>


<!-- ════════════════════ GALLERY ════════════════════ -->
<section class="gallery" id="gallery">
  <div class="reveal">
    <div class="section-tag">Our Rooms</div>
    <h2 class="section-title">Room Types at <em>Sanctissimo Rosario</em></h2>
    <p class="section-sub">Choose the setup that fits your lifestyle — safe, clean, and near UST and the University Belt.</p>
  </div>

  <div class="gallery-grid reveal">

    <!-- SOLO ROOM -->
    <div class="gal-item">
      <div class="gal-img-wrap">
        <img src="{{ asset('images/solo.jpg') }}" alt="Solo Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top">
          <span class="gal-badge">Solo</span>
          <span class="gal-occupants">1 Occupant</span>
        </div>
        <h3 class="gal-title">Solo Room</h3>
        <p class="gal-desc">Semi-furnished private room ideal for one student. Includes a bed, wardrobe, and study desk.</p>
      </div>
    </div>

    <!-- DOUBLE ROOM -->
    <div class="gal-item">
      <div class="gal-img-wrap">
        <img src="{{ asset('images/two.jpg') }}" alt="Double Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top">
          <span class="gal-badge">Double</span>
          <span class="gal-occupants">2 Occupants</span>
        </div>
        <h3 class="gal-title">Double Room</h3>
        <p class="gal-desc">Semi-furnished room for two. Each occupant gets a bed, individual wardrobe, and shared study area.</p>
      </div>
    </div>

    <!-- TRIPLE ROOM -->
    <div class="gal-item">
      <div class="gal-img-wrap">
        <img src="{{ asset('images/three.jpg') }}" alt="Triple Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top">
          <span class="gal-badge">Triple</span>
          <span class="gal-occupants">3 Occupants</span>
        </div>
        <h3 class="gal-title">Triple Room</h3>
        <p class="gal-desc">Spacious room for three students. Comes with three beds, wardrobes, and a shared study corner.</p>
      </div>
    </div>

    <!-- QUAD ROOM -->
    <div class="gal-item">
      <div class="gal-img-wrap">
        <img src="{{ asset('images/four.jpg') }}" alt="Quad Room" class="gal-img">
      </div>
      <div class="gal-label">
        <div class="gal-label-top">
          <span class="gal-badge">Quad</span>
          <span class="gal-occupants">4 Occupants</span>
        </div>
        <h3 class="gal-title">Quad Room</h3>
        <p class="gal-desc">Best value for groups of four. Fully utilizes shared space with four beds and communal storage.</p>
      </div>
    </div>

  </div>
</section>

<!-- ════════════════════ HOW IT WORKS ════════════════════ -->
<section class="how" id="how">
  <div class="how-inner">
    <div>
      <div class="section-tag reveal">Simple Process</div>
      <h2 class="section-title reveal">Getting started is <em>effortless</em></h2>
      <p class="section-sub reveal">DormEase is designed so every tenant can use it with zero learning curve — from first-year students to reviewees.</p>
      <div class="steps" style="margin-top:48px;">
        <div class="step reveal d1">
          <div class="step-num">1</div>
          <div>
            <div class="step-title">Create your tenant account</div>
            <p class="step-desc">Sign up with your room information and get verified by the dormitory admin within 24 hours.</p>
          </div>
        </div>
        <div class="step reveal d2">
          <div class="step-num">2</div>
          <div>
            <div class="step-title">Access all dorm services</div>
            <p class="step-desc">Report issues by voice or text, check your water bill, register visitors, and receive announcements instantly.</p>
          </div>
        </div>
        <div class="step reveal d3">
          <div class="step-num">3</div>
          <div>
            <div class="step-title">Stay informed, stay safe</div>
            <p class="step-desc">Receive real-time announcements and emergency alerts. Everything you need, always within reach.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="how-img-main reveal">
      <div class="mini-phones">
        <div class="mini-ph"><div class="mini-scr"><div class="mini-hdr"><div class="mini-hdr-txt">DORMEASE</div></div><div class="mini-bdy"><div class="mini-row"></div><div class="mini-row" style="width:70%"></div><div class="mini-row"></div><div class="mini-row" style="width:80%"></div><div class="mini-row"></div></div></div></div>
        <div class="mini-ph"><div class="mini-scr"><div class="mini-hdr" style="background:#9C2046"><div class="mini-hdr-txt">ANNOUNCEMENTS</div></div><div class="mini-bdy"><div class="mini-row"></div><div class="mini-row" style="width:60%"></div><div class="mini-row"></div><div class="mini-row" style="width:85%"></div></div></div></div>
        <div class="mini-ph"><div class="mini-scr"><div class="mini-hdr"><div class="mini-hdr-txt">WATER BILL</div></div><div class="mini-bdy"><div style="background:white;border-radius:4px;height:26px;display:flex;align-items:center;justify-content:center;"><span style="font-size:8px;font-weight:800;color:var(--pink);font-family:var(--font-head)">₱248.50</span></div><div class="mini-row" style="width:75%"></div><div class="mini-row"></div><div class="mini-row" style="width:55%"></div></div></div></div>
      </div>
      <p style="font-family:var(--font-head);font-size:.95rem;font-weight:700;color:var(--brown);margin-top:24px;font-style:italic;">"Everything in one app — finally."</p>
      <p style="font-size:.76rem;color:var(--brown-light);margin-top:4px;font-weight:600;">— Room 3B Tenant</p>
    </div>
  </div>
</section>


<!-- ════════════════════ ABOUT ════════════════════ -->
<section class="about" id="about">
  <div class="about-inner">
    <div>
      <div class="section-tag reveal">About the Dormitory</div>
      <h2 class="section-title reveal">Sanctissimo Rosario<br><em>Ladies Dormitory</em></h2>
      <p class="section-sub reveal">A five-storey residential building at 1229 Navarra Street, Sampaloc, Manila — a safe, comfortable, study-friendly home for female students near UST and the University Belt.</p>
      <div class="amenities reveal">
        <div class="amenity"><div class="amenity-dot"></div>24/7 Security + CCTV</div>
        <div class="amenity"><div class="amenity-dot"></div>Elevator Access</div>
        <div class="amenity"><div class="amenity-dot"></div>Wi-Fi Available</div>
        <div class="amenity"><div class="amenity-dot"></div>Own Bathroom per Room</div>
        <div class="amenity"><div class="amenity-dot"></div>Semi-Furnished Rooms</div>
        <div class="amenity"><div class="amenity-dot"></div>Aircon Slot per Room</div>
        <div class="amenity"><div class="amenity-dot"></div>Near UST &amp; UBelt</div>
        <div class="amenity"><div class="amenity-dot"></div>Strong Water Supply</div>
      </div>
      <div style="margin-top:40px;" class="reveal">
        <a href="tel:+639175359723" class="btn-primary" style="display:inline-flex;">
          <svg viewBox="0 0 20 20" style="width:18px;height:18px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
          Reserve: +63 917 535 9723
        </a>
      </div>
    </div>

    <!--
    ╔═══════════════════════════════════════════════════════════╗
    ║  IMAGE SLOTS 4 & 5 — ABOUT PHOTOS                        ║
    ║                                                           ║
    ║  SLOT 4 (top, large): Dorm building exterior             ║
    ║    Plain:   <img src="src/images/dorm-exterior.jpg"      ║
    ║                  alt="Dorm exterior" class="about-img">  ║
    ║    Laravel: src="{{ asset('images/dorm-exterior.jpg') }}"║
    ║    Size: 800×520px                                        ║
    ║                                                           ║
    ║  SLOT 5 (bottom, small): Room interior / bathroom        ║
    ║    Plain:   <img src="src/images/dorm-room.jpg" ...>     ║
    ║    Laravel: src="{{ asset('images/dorm-room.jpg') }}"    ║
    ║    Size: 800×360px                                        ║
    ╚═══════════════════════════════════════════════════════════╝
    -->
    <div class="about-photos reveal">
      <div style="border-radius:var(--r-lg);overflow:hidden;">
        <!-- IMAGE SLOT 4: Replace div below with <img> tag -->
        <div class="img-ph" style="height:260px;border-color:rgba(255,255,255,0.18);background:rgba(255,255,255,0.04);">
          <div class="img-ph-ico" style="background:rgba(255,255,255,0.08);">
            <svg viewBox="0 0 24 24" style="stroke:rgba(255,255,255,0.45);"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
          <span style="color:rgba(255,255,255,0.45);">SLOT 4 · Dorm Exterior<br><small style="opacity:.7;font-size:.62rem;text-transform:none;">src/images/dorm-exterior.jpg · 800×520px</small></span>
        </div>
      </div>
      <div style="border-radius:var(--r-lg);overflow:hidden;">
        <!-- IMAGE SLOT 5: Replace div below with <img> tag -->
        <div class="img-ph" style="height:175px;border-color:rgba(255,255,255,0.18);background:rgba(255,255,255,0.04);">
          <div class="img-ph-ico" style="background:rgba(255,255,255,0.08);">
            <svg viewBox="0 0 24 24" style="stroke:rgba(255,255,255,0.45);"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
          <span style="color:rgba(255,255,255,0.45);">SLOT 5 · Room Interior<br><small style="opacity:.7;font-size:.62rem;text-transform:none;">src/images/dorm-room.jpg · 800×360px</small></span>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ════════════════════ CTA ════════════════════ -->
<section class="cta-section" id="contact">
  <div class="reveal">
    <div class="section-tag" style="text-align:center;">Get DormEase</div>
    <h2 class="section-title">Ready to experience<br>a <em>smarter</em> dorm life?</h2>
    <p class="section-sub">DormEase is available to all tenants of Sanctissimo Rosario Ladies Dormitory. Contact the administration to get access.</p>
    <a href="tel:+639175359723" class="btn-primary" style="display:inline-flex;">
      <svg viewBox="0 0 20 20" style="width:18px;height:18px;fill:white;flex-shrink:0;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
      Call +63 917 535 9723
    </a>
    <div class="cta-contact">
      1229 Navarra Street, Sampaloc, Manila &nbsp;·&nbsp; Near UST &amp; University Belt
    </div>
  </div>
</section>


<!-- ════════════════════ FOOTER ════════════════════ -->
<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-logo">
        <!--
        ╔══════════════════════════════════════════════════════╗
        ║  IMAGE SLOT 9 — FOOTER LOGO (white/light version)   ║
        ║  Plain:   src="src/images/logo-white.png"           ║
        ║  Laravel: src="{{ asset('images/logo-white.png') }}"║
        ╚══════════════════════════════════════════════════════╝
        -->
        <a href="{{ route('login') }}" class="footer-logo">
            <img src="YOUR_LOGO_WHITE_URL_HERE"
                alt="DormEase"
                onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
            <span class="footer-logo-fb" style="display:none;">Dorm<span>Ease</span></span>
        </a>
      </div>
      <p class="footer-brand">A web and mobile dormitory management system for Sanctissimo Rosario Ladies Dormitory, Sampaloc, Manila.</p>
    </div>
    <div class="footer-col">
      <h4>Features</h4>
      <a href="#">Maintenance</a>
      <a href="#">Announcements</a>
      <a href="#">Water Billing</a>
      <a href="#">Visitor Log</a>
      <a href="#">Emergency</a>
    </div>
    <div class="footer-col">
      <h4>Dormitory</h4>
      <a href="#">About</a>
      <a href="#">Room Types</a>
      <a href="#">Amenities</a>
      <a href="#">Location</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="tel:+639175359723">+63 917 535 9723</a>
      <a href="#">1229 Navarra St.</a>
      <a href="#">Sampaloc, Manila</a>
    </div>
  </div>
  <div class="footer-btm">
    <span>© 2026 DormEase · Sanctissimo Rosario Ladies Dormitory</span>
    <div style="display:flex;gap:20px;align-items:center;">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
    </div>
  </div>
</footer>

<script>
  const nav = document.getElementById('navbar');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 20));
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.10 });
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>