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

.site-header {
  position: relative;
  background: var(--pink-pale);
  border-bottom: 1px solid rgba(232,23,93,0.12);
}

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

nav {
  position: fixed; top: 54px; left: 50%; z-index: 100;
  width: min(1220px, calc(100% - 12%));
  transform: translateX(-50%);
  background: rgba(255, 228, 240, 0.96);
  backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
  border: 1.5px solid rgba(36,16,24,0.78);
  border-radius: 999px;
  padding: 0 38px; height: 86px;
  display: flex; align-items: center; justify-content: space-between;
  transition: top 0.25s ease, box-shadow 0.3s;
}
nav.scrolled { top: 18px; box-shadow: 0 16px 34px rgba(36,16,24,0.12); }

.top-notice {
  position: absolute;
  top: 0; left: 0; right: 0;
  z-index: 101;
  min-height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 6px 5%;
  background: var(--gradient-pink);
  color: white;
  font-family: var(--font-head);
  font-size: .86rem;
  font-weight: 800;
  text-align: center;
}

.nav-logo { display: flex; align-items: center; text-decoration: none; gap: 10px; }
.nav-logo img { height: 58px; width: auto; object-fit: contain; display: block; background:var(--gradient-pink); border-radius:50%; padding:8px; filter: drop-shadow(0 2px 7px rgba(36, 16, 24, 0.22)); }
.nav-logo-fb {
  font-family: var(--font-head); font-size: 1.55rem; font-weight: 800;
  color: var(--brown); letter-spacing: -0.02em;
}
.nav-logo-fb span { color: var(--pink); }

.nav-links { display: flex; align-items: center; gap: 30px; list-style: none; }
.nav-links a {
  text-decoration: none; font-size: .98rem; font-weight: 700;
  color: var(--brown); letter-spacing: 0.01em; transition: color 0.2s, background 0.2s;
}
.nav-links a:hover { color: var(--pink); }
.nav-links a.nav-active { color:var(--pink); position:relative; }
.nav-links a.nav-active::after { content:''; position:absolute; bottom:-4px; left:0; right:0; height:2.5px; border-radius:99px; background:var(--gradient-pink); }
.nav-cta {
  background: var(--gradient-pink) !important; color: white !important;
  padding: 11px 26px !important; border-radius: 100px !important;
  font-weight: 700 !important; transition: filter 0.2s, transform 0.15s !important;
  box-shadow: 0 8px 18px rgba(232,23,93,0.24);
}
.nav-cta:hover { filter: brightness(0.94); transform: translateY(-1px); }

.header-info-strip {
  padding: 154px 6% 16px;
  background: var(--pink-pale);
  border-bottom: 1px solid rgba(232,23,93,0.12);
}
.header-info-inner {
  max-width: 1280px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
}
.header-info-item {
  display: grid;
  grid-template-columns: 46px 1fr;
  gap: 16px;
  align-items: center;
  padding: 0 24px;
  border-left: 1px solid rgba(36,16,24,0.20);
}
.header-info-item:last-child { border-right: 1px solid rgba(36,16,24,0.20); }
.header-info-icon {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  background: white;
  color: var(--pink);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 18px rgba(232,23,93,0.10);
}
.header-info-icon svg {
  width: 24px;
  height: 24px;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.9;
  stroke-linecap: round;
  stroke-linejoin: round;
}
.header-info-title {
  font-family: var(--font-head);
  font-size: .98rem;
  font-weight: 800;
  color: var(--brown);
  line-height: 1.25;
}
.header-info-text {
  font-size: .82rem;
  color: var(--brown-light);
  line-height: 1.45;
  margin-top: 3px;
}

.hero {
  min-height: 100svh;
  padding: 0 5% 0 8%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: center;
  gap: 48px;
  position: relative;
  overflow: hidden;
  background: var(--cream);
}

.hero-content {
  position: relative;
  z-index: 2;
  padding: 100px 0 80px;
}

.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: white; border: 1px solid var(--border);
  color: var(--pink-deep); font-size: 0.68rem; font-weight: 700;
  letter-spacing: 0.09em; text-transform: uppercase;
  padding: 6px 16px; border-radius: 100px; margin-bottom: 28px;
  box-shadow: 0 1px 6px rgba(214,56,104,0.10);
}
.hero-badge::before {
  content: ''; width: 6px; height: 6px;
  background: var(--pink); border-radius: 50%;
  animation: pulse 2s infinite; flex-shrink: 0;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

.hero h1 {
  font-family: var(--font-head);
  font-size: clamp(2.8rem, 4.5vw, 4.2rem);
  font-weight: 800; line-height: 1.08;
  color: var(--brown); margin-bottom: 22px; letter-spacing: -0.03em;
}
.hero h1 em { font-style: italic; color: var(--pink); font-weight: 700; }

.hero-sub {
  font-size: 0.97rem; color: var(--brown-light);
  line-height: 1.85; max-width: 420px; margin-bottom: 36px;
}

.hero-actions {
  display: flex; gap: 14px; align-items: center;
  flex-wrap: wrap; margin-bottom: 44px;
}

.btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--gradient-pink); color: white; text-decoration: none;
  font-family: var(--font-body); font-size: 0.9rem; font-weight: 700;
  padding: 14px 32px; border-radius: 100px;
  transition: filter 0.2s, transform 0.15s, box-shadow 0.2s;
  box-shadow: 0 8px 24px rgba(232,23,93,0.32);
}
.btn-primary:hover { filter: brightness(0.94); transform: translateY(-2px); }

.btn-outline {
  display: inline-flex; align-items: center; gap: 8px;
  background: transparent; color: var(--brown); text-decoration: none;
  font-family: var(--font-body); font-size: 0.9rem; font-weight: 600;
  padding: 13px 28px; border-radius: 100px;
  border: 1.5px solid rgba(58,32,16,0.20);
  transition: border-color 0.2s, color 0.2s;
}
.btn-outline:hover { border-color: var(--pink); color: var(--pink); }

.hero-stats-row {
  display: flex;
  align-items: center;
  gap: 0;
  padding-top: 32px;
  border-top: 1px solid var(--border);
}
.hero-stat-item {
  flex: 1;
}
.hero-stat-divider {
  width: 1px;
  height: 36px;
  background: var(--border);
  flex-shrink: 0;
}
.hero-stat-num {
  font-family: var(--font-head);
  font-size: 2rem; font-weight: 800;
  color: var(--pink); line-height: 1;
}
.hero-stat-label {
  font-size: 0.68rem; color: var(--brown-light);
  margin-top: 5px; text-transform: uppercase;
  letter-spacing: 0.10em; font-weight: 700;
}

.hero-arch-wrap {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  min-height: 100svh;
  z-index: 1;
}

.hero-blob-top {
  position: absolute;
  top: 12%; right: 4%;
  width: 220px; height: 200px;
  background: var(--pink-light);
  border-radius: 60% 80% 40% 70% / 50% 60% 80% 40%;
  opacity: 0.40;
  z-index: 0;
}
.hero-blob-bottom {
  position: absolute;
  bottom: 14%; left: 2%;
  width: 160px; height: 150px;
  background: var(--pink-pale);
  border-radius: 70% 40% 60% 50% / 60% 80% 40% 70%;
  opacity: 0.75;
  z-index: 0;
}

.hero-arch {
  position: relative;
  z-index: 1;
  width: 380px;
  height: 520px;
  border-radius: 220px 220px 36px 36px;
  overflow: hidden;
  box-shadow: 0 40px 90px rgba(58,32,16,0.16), 0 0 0 10px rgba(214,56,104,0.07);
}
.hero-arch img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center top;
  display: block;
  filter: brightness(0.93) saturate(0.90);
  transition: transform 0.6s ease;
}
.hero-arch:hover img { transform: scale(1.04); }

.hero-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 32px;
  padding-top: 28px;
  border-top: 1px solid var(--border);
}

.hero-chip {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  background: white;
  border: 1px solid var(--border);
  border-radius: 100px;
  padding: 7px 14px;
  font-size: 0.80rem;
  font-weight: 600;
  color: var(--brown);
  font-family: var(--font-body);
  transition: border-color 0.2s, color 0.2s, background 0.2s;
}
.hero-chip:hover {
  border-color: var(--pink-light);
  background: var(--pink-pale);
  color: var(--pink-deep);
}

.hero-chip-dot {
  width: 7px;
  height: 7px;
  background: var(--pink-light);
  border-radius: 50%;
  flex-shrink: 0;
}

@media (max-width: 960px) {
  .hero {
    grid-template-columns: 1fr;
    padding: 120px 6% 80px;
    min-height: auto;
  }
  .hero-content { padding: 0; }
  .hero-arch-wrap { min-height: 420px; }
  .hero-arch { width: 300px; height: 400px; }
}
@media (max-width: 600px) {
  .hero-arch-wrap { display: none; }
  .hero-stats-row { gap: 0; }
}

section { padding: 100px 6%; }
.section-tag { font-size:.70rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--pink); margin-bottom:12px; }
.section-title { font-family:var(--font-head); font-size:clamp(1.8rem,3.2vw,2.8rem); font-weight:800; line-height:1.15; color:var(--brown); letter-spacing:-.03em; margin-bottom:18px; }
.section-title em { color:var(--pink); font-style:italic; font-weight:700; }
.section-sub { font-size:1rem; color:var(--brown-light); line-height:1.8; max-width:540px; }

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
  background:var(--gradient-pink);
  transform:scaleX(0); transform-origin:left; transition:transform .3s;
}
.feat-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-soft); }
.feat-card:hover::before { transform:scaleX(1); }
.feat-icon { width:50px; height:50px; background:var(--pink-pale); border-radius:var(--r-md); display:flex; align-items:center; justify-content:center; margin-bottom:18px; }
.feat-icon svg { width:25px; height:25px; stroke:var(--pink); fill:none; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
.feat-title { font-family:var(--font-head); font-size:1.0rem; font-weight:700; color:var(--brown); margin-bottom:8px; letter-spacing:-.01em; }
.feat-desc { font-size:.87rem; color:var(--brown-light); line-height:1.75; }

.gallery { background:var(--cream-dark); padding-top:80px; padding-bottom:80px; }

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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
  aspect-ratio: 1 / 1;
  background: transparent;
}

.gal-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
  transition: transform .4s;
  background: transparent;
}

.gal-item:hover .gal-img { transform: scale(1.02); }

.gal-label {
  padding: 16px 20px 20px;
  background: white;
}

.gal-label-top { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
.gal-badge {
  background: var(--gradient-pink); color: white;
  font-size: 0.68rem; font-weight: 700;
  letter-spacing: 0.08em; text-transform: uppercase;
  padding: 4px 12px; border-radius: 100px;
}
.gal-occupants { font-size: 0.82rem; color: var(--brown-light); font-weight: 600; }
.gal-title { font-family: var(--font-head); font-size: 1rem; font-weight: 700; color: var(--brown); margin-bottom: 4px; }
.gal-desc { font-size: 0.85rem; color: var(--brown-light); line-height: 1.7; }

.how { background:var(--cream); position:relative; overflow:hidden; }
.how::before { content:''; position:absolute; top:-200px; right:-200px; width:500px; height:500px; border-radius:50%; background:rgba(214,56,104,0.04); }
.how-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
.steps { display:flex; flex-direction:column; gap:30px; }
.step { display:flex; gap:18px; align-items:flex-start; }
.step-num { width:42px; height:42px; background:var(--gradient-pink); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--font-head); font-size:1rem; font-weight:800; flex-shrink:0; }
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

.about { background:var(--brown); color:white; position:relative; overflow:hidden; }
.about::before { content:''; position:absolute; bottom:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:rgba(255,45,120,0.16); }
.about-inner { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; position:relative; z-index:1; }
.about .section-tag { color:var(--pink-light); }
.about .section-title { color:white; }
.about .section-sub { color:rgba(255,255,255,0.60); }
.amenities { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:32px; }
.amenity { display:flex; align-items:center; gap:10px; font-size:.85rem; color:rgba(255,255,255,0.78); }
.amenity-dot { width:7px; height:7px; background:var(--pink-light); border-radius:50%; flex-shrink:0; }


.about-photos {
  display: flex;
  align-items: stretch;
  justify-content: center;
  height: 100%;
}

.about-photo {
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: 0 16px 34px rgba(0,0,0,0.18);
}

.about-main-photo {
  width: min(100%, 460px);
  height: clamp(500px, 42vw, 620px);
}

.about-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
  border-radius: var(--r-lg);
  background: transparent;
  filter: brightness(1.05) saturate(1.1); /* counteract dark bg */
}

.info-card { background:rgba(255,255,255,0.08); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.13); border-radius:var(--r-lg); padding:24px; }
.ic-lbl { font-size:.66rem; text-transform:uppercase; letter-spacing:.12em; color:var(--pink-light); margin-bottom:5px; font-weight:700; }
.ic-val { font-family:var(--font-head); font-size:2.2rem; font-weight:800; color:white; line-height:1; margin-bottom:2px; }
.ic-sub { font-size:.76rem; color:rgba(255,255,255,0.40); }
.ic-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.07); font-size:.80rem; }
.ic-row:last-child { border-bottom:none; }
.ic-rl { color:rgba(255,255,255,0.48); }
.ic-rv { color:white; font-weight:600; }

.cta-section { background:var(--pink-pale); }
.contact-inner {
  display: grid;
  grid-template-columns: minmax(460px, 1fr) minmax(260px, 360px);
  gap: 54px;
  align-items: center;
  max-width: 1100px;
  margin: 0 auto;
}
.contact-copy { text-align: left; }
.cta-section .section-tag { margin-bottom: 9px; }
.cta-section .section-title { color:var(--brown); margin:0 0 16px; font-size:clamp(2.35rem,4vw,3.35rem); max-width:620px; }
.cta-section .section-sub { margin:0 0 32px; color:var(--brown-light); font-size:1.12rem; line-height:1.7; max-width:620px; }
.cta-section .btn-primary { font-size:1.02rem; padding:16px 38px; }
.cta-contact { margin-top:26px; font-size:1rem; line-height:1.65; color:var(--brown-light); max-width:520px; }
.cta-contact a { color:var(--pink); text-decoration:none; font-weight:700; }
.contact-map-wrap {
  position: relative;
  width: 100%;
  margin: 0;
  border-radius: var(--r-lg);
  overflow: hidden;
  border: 1px solid rgba(232,23,93,0.20);
  background: transparent;
  box-shadow: var(--shadow-card);
  display: block;
  transition: transform .2s ease, box-shadow .2s ease;
}
.contact-map-wrap:hover {
  transform: translateY(-3px);
  box-shadow: 0 18px 36px rgba(232,23,93,0.18);
}
.contact-map-prompt {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-top: 14px;
  color: var(--pink-deep);
  font-size: .82rem;
  font-weight: 800;
  text-decoration: none;
}
.contact-map-prompt svg {
  width: 16px;
  height: 16px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2.2;
  stroke-linecap: round;
  stroke-linejoin: round;
  transition: transform .2s ease;
}
.contact-map-link:hover .contact-map-prompt svg { transform: translate(2px, -2px); }
.contact-map-wrap.map-missing::after {
  content: 'Add map image at public/images/map.jpg';
  display: block;
  padding: 34px 18px;
  color: var(--brown-light);
  font-size: .85rem;
  font-weight: 700;
}
.contact-map-img {
  width: 100%;
  height: auto;
  display: block;
  background: transparent;
}
.contact-map-link {
  color: inherit;
  text-decoration: none;
}
.app-screenshots {
  display: flex;
  align-items: flex-end;
  justify-content: center;
  gap: 12px;
  padding: 8px 0 4px;
}

.app-screenshot-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.app-screenshot-item.center {
  transform: translateY(-16px);
}

.app-screenshot-frame {
  width: 100px;
  aspect-ratio: 9 / 19.5;
  border-radius: 18px;
  overflow: hidden;
  border: 3px solid var(--brown);
  box-shadow: 0 10px 28px rgba(36,16,24,0.18);
  background: var(--pink-pale);
  position: relative;
}

.app-screenshot-frame.featured {
  width: 118px;
  border-color: var(--pink);
  box-shadow: 0 16px 36px rgba(232,23,93,0.28);
}

.app-screenshot-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top center;
  display: block;
}

.app-screenshot-fallback {
  width: 100%;
  height: 100%;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--brown-light);
  font-size: 0.62rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  text-align: center;
  padding: 12px;
}

.app-screenshot-fallback svg {
  width: 28px;
  height: 28px;
  stroke: var(--pink-light);
  fill: none;
  stroke-width: 1.5;
  stroke-linecap: round;
}

.app-screenshot-label {
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--brown-light);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-family: var(--font-head);
}

footer { background:var(--brown); color:rgba(255,255,255,0.48); padding:64px 6% 40px; }
.footer-inner { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; margin-bottom:48px; }
.footer-logo { display:flex; align-items:center; margin-bottom:16px; text-decoration: none; }
.footer-logo img { height:56px; width:auto; object-fit:contain; filter: drop-shadow(0 4px 12px rgba(0,0,0,0.22)); }
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
.footer-social-icon {
  position:relative;
  width:46px;
  height:46px;
  border-radius:50%;
  background:#111;
  color:white;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  overflow:hidden;
  border:1px solid rgba(255,255,255,0.14);
  transition:transform .2s, background .2s, border-color .2s;
}
.footer-social-icon:hover { transform:translateY(-2px); background:var(--pink); border-color:var(--pink-light); }
.footer-social-icon img {
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}
.footer-social-fallback {
  font-family:var(--font-head);
  font-size:1rem;
  font-weight:900;
  letter-spacing:.02em;
}

/* Scroll-to-top button */
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

.reveal { opacity:0; transform:translateY(28px); transition:opacity .7s ease,transform .7s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.d1{transition-delay:.10s} .d2{transition-delay:.20s} .d3{transition-delay:.30s} .d4{transition-delay:.40s}

@media(max-width:960px){
  .hero{grid-template-columns:1fr;padding-top:120px}
  .hero-visual{display:none}
  .features-grid{grid-template-columns:1fr 1fr}
  .gallery-grid{grid-template-columns:1fr 1fr;grid-template-rows:auto}
  .gal-item.tall{grid-row:span 1}
  .how-inner{grid-template-columns:1fr}
  .about-inner{grid-template-columns:1fr}
  .about-photos{max-width:760px;width:100%;margin:0 auto;}
  .footer-inner{grid-template-columns:1fr 1fr}
  .nav-links li:not(:last-child){display:none}
  .contact-inner{grid-template-columns:minmax(0,1fr) minmax(240px,320px);gap:36px;}
  .cta-section .section-title{font-size:clamp(2rem,4vw,2.7rem);}
  .cta-section .section-sub{font-size:1rem;}
  .header-info-inner{grid-template-columns:1fr 1fr;gap:18px;}
  .header-info-item{border:1px solid rgba(36,16,24,0.14);border-radius:var(--r-md);padding:16px;background:rgba(255,255,255,0.55);}
  .header-info-item:last-child{border-right:1px solid rgba(36,16,24,0.14);}
}
@media(max-width:760px){
  nav{top:46px;height:auto;min-height:76px;padding:10px 5%;gap:14px;flex-wrap:wrap;border-radius:28px;width:calc(100% - 28px);}
  nav.scrolled{top:12px;}
  .top-notice{font-size:.74rem;min-height:30px;}
  .header-info-strip{padding:138px 5% 10px;}
  .nav-logo img{height:44px;}
  .nav-logo-fb{font-size:1.22rem;}
  .nav-links{gap:0;margin-left:auto;}
  section{padding:72px 5%;}
  .hero{padding:108px 5% 70px;}
  .hero-actions{align-items:stretch;}
  .btn-primary,.btn-outline{justify-content:center;width:100%;}
  .gallery-grid{grid-template-columns:1fr;max-width:460px;margin-left:auto;margin-right:auto;}
  .about-photos{max-width:460px;}
  .about-main-photo{height:min(560px, 120vw);}
  .contact-inner{grid-template-columns:1fr;gap:32px;max-width:460px;}
  .contact-copy{text-align:center;}
  .cta-section .section-title,.cta-section .section-sub{margin-left:auto;margin-right:auto;}
  .cta-contact{margin-left:auto;margin-right:auto;}
  .footer-btm{flex-direction:column;gap:16px;align-items:flex-start;}
  .footer-btm-right{align-items:flex-start;}
  #scrollTopBtn { bottom:22px; right:18px; width:44px; height:44px; }
}
@media(max-width:600px){
  .features-grid{grid-template-columns:1fr}
  .gallery-grid{grid-template-columns:1fr}
  .footer-inner{grid-template-columns:1fr}
  .hero h1{font-size:2.2rem}
  .amenities{grid-template-columns:1fr;}
  .mini-phones{transform:scale(.9);transform-origin:center;}
  .contact-map-wrap{border-radius:var(--r-md);}
  .header-info-inner{grid-template-columns:1fr;}
  .header-info-item{grid-template-columns:40px 1fr;}
  .header-info-icon{width:40px;height:40px;}
}
@media(max-width:420px){
  .hero-chip{font-size:.74rem;padding:7px 11px;}
  .section-title{font-size:1.72rem;}
  .gal-label{padding:14px 16px 18px;}
  .gal-label-top{align-items:flex-start;flex-direction:column;gap:6px;}
}

</style>
</head>
<body>

<header class="site-header">
<div class="top-notice">Sanctissimo Rosario Ladies Dormitory &middot; Safe student housing near UST</div>

<nav id="navbar">
  <a href="{{ route('home') }}" class="nav-logo">
    <img src="{{ asset('images/logo.png') }}"
         alt="DormEase Logo"
         onerror="this.style.display='none'">
    <span class="nav-logo-fb">Dorm<span>Ease</span></span>
  </a>

  <ul class="nav-links">
    <li><a href="#gallery">Gallery</a></li>
    <li><a href="#how">How it Works</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="{{ route('faqs') }}">FAQs</a></li>
    <li><a href="#contact" class="nav-cta">Contact Us</a></li>
  </ul>
</nav>

<div class="header-info-strip">
  <div class="header-info-inner">
    <div class="header-info-item">
      <div class="header-info-icon">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M3 11l9-7 9 7"></path>
          <path d="M5 10v10h14V10"></path>
          <path d="M9 20v-6h6v6"></path>
        </svg>
      </div>
      <div>
        <div class="header-info-title">Ladies Dormitory</div>
        <div class="header-info-text">Study-friendly rooms for female students in Sampaloc.</div>
      </div>
    </div>
    <div class="header-info-item">
      <div class="header-info-icon">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11z"></path>
          <circle cx="12" cy="10" r="2.5"></circle>
        </svg>
      </div>
      <div>
        <div class="header-info-title">Near UST &amp; UBelt</div>
        <div class="header-info-text">Located along Navarra Street with nearby campus access.</div>
      </div>
    </div>
    <div class="header-info-item">
      <div class="header-info-icon">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"></path>
          <path d="M9.5 12l1.8 1.8 3.7-4"></path>
        </svg>
      </div>
      <div>
        <div class="header-info-title">24/7 Security</div>
        <div class="header-info-text">CCTV, secure entry, and dorm support for tenants.</div>
      </div>
    </div>
    <div class="header-info-item">
      <div class="header-info-icon">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M4 7h16"></path>
          <path d="M6 7v13h12V7"></path>
          <path d="M9 7V5h6v2"></path>
          <path d="M9 12h6"></path>
          <path d="M9 16h4"></path>
        </svg>
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

  <div class="hero-content">
    <div class="hero-badge">Safe &middot; Comfortable &middot; Near UST</div>
    <h1>Your home away<br>from <em>home</em></h1>
    <p class="hero-sub">
      Sanctissimo Rosario Ladies Dormitory: a safe, study-friendly home for female students in the heart of Sampaloc, Manila.
    </p>
    <div class="hero-actions">
      <a href="#features" class="btn-primary">Explore Rooms</a>
      <a href="{{ route('safety.features') }}" class="btn-outline">Safety Features</a>
    </div>

    <div class="hero-chips">
      <div class="hero-chip"><span class="hero-chip-dot"></span>24/7 Security</div>
      <div class="hero-chip"><span class="hero-chip-dot"></span>Wi-Fi</div>
      <div class="hero-chip"><span class="hero-chip-dot"></span>Elevator</div>
      <div class="hero-chip"><span class="hero-chip-dot"></span>Own Bathroom</div>
      <div class="hero-chip"><span class="hero-chip-dot"></span>Near UST</div>
      <div class="hero-chip"><span class="hero-chip-dot"></span>Aircon</div>
    </div>
  </div>

  <div class="hero-arch-wrap">
    <div class="hero-blob-top"></div>
    <div class="hero-blob-bottom"></div>
    <div class="hero-arch">
      <img src="{{ asset('images/sancti.png') }}" alt="Sanctissimo Rosario Dormitory">
    </div>
  </div>

</section>

<section class="gallery" id="gallery">
  <div class="reveal">
    <div class="section-tag">Our Rooms</div>
    <h2 class="section-title">Room Types at <em>Sanctissimo Rosario</em></h2>
    <p class="section-sub">Choose the setup that fits your lifestyle, that is safe, clean, and near UST and the University Belt.</p>
  </div>

  <div class="gallery-grid reveal">
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

<section class="how" id="how">
  <div class="how-inner">
    <div>
      <div class="section-tag reveal">Simple Process</div>
      <h2 class="section-title reveal">Getting started is <em>effortless</em></h2>
      <p class="section-sub reveal">DormEase is designed so every tenant can use it with zero learning curve.</p>
      <div class="steps" style="margin-top:48px;">
        <div class="step reveal d1">
          <div class="step-num">1</div>
          <div>
            <div class="step-title">Inquire now and be a Tenant</div>
            <p class="step-desc">Contact us to learn more about our dormitory and start your application process.</p>
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
  <div class="app-screenshots">
    <div class="app-screenshot-item">
      <div class="app-screenshot-frame">
        <img src="{{ asset('images/app_dashboard.png') }}"
             alt="DormEase App - Home Screen"
             class="app-screenshot-img"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
        <div class="app-screenshot-fallback" style="display:none">
          <svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="17" r="1"/></svg>
          <span>screen1.png</span>
        </div>
      </div>
      <p class="app-screenshot-label">Home</p>
    </div>

    <div class="app-screenshot-item center">
      <div class="app-screenshot-frame featured">
        <img src="{{ asset('images/app_announcements.png') }}"
             alt="DormEase App - Announcements"
             class="app-screenshot-img"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
        <div class="app-screenshot-fallback" style="display:none">
          <svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="17" r="1"/></svg>
          <span>screen2.png</span>
        </div>
      </div>
      <p class="app-screenshot-label">Announcements</p>
    </div>

    <div class="app-screenshot-item">
      <div class="app-screenshot-frame">
        <img src="{{ asset('images/app_waterbilling.png') }}"
             alt="DormEase App - Water Bill"
             class="app-screenshot-img"
             onerror="this.style.display:'none';this.nextElementSibling.style.display='flex'">
        <div class="app-screenshot-fallback" style="display:none">
          <svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="17" r="1"/></svg>
          <span>screen3.png</span>
        </div>
      </div>
      <p class="app-screenshot-label">Water Bill</p>
    </div>
  </div>

  <p style="font-family:var(--font-head);font-size:.95rem;font-weight:700;color:var(--brown);margin-top:24px;font-style:italic;">"Everything in one app — finally."</p>
  <p style="font-size:.76rem;color:var(--brown-light);margin-top:4px;font-weight:600;">— Room 3B Tenant</p>

  <a href="{{ route('features') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;margin-top:16px;">
    More Features
    <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:white;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round;">
      <path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path>
    </svg>
  </a>
</div>

</section>

<section class="about" id="about">
  <div class="about-inner">
    <div>
      <div class="section-tag reveal">About the Dormitory</div>
      <h2 class="section-title reveal">Sanctissimo Rosario<br><em>Ladies Dormitory</em></h2>
      <p class="section-sub reveal">A five-storey residential building at 1229 Navarra Street, Sampaloc, Manila. A safe, comfortable, study-friendly home for female students near UST and the University Belt.</p>
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

<div class="about-photos reveal">
  <div class="about-photo about-main-photo">
    <img src="{{ asset('images/main.jpg') }}"
         alt="Sanctissimo Rosario Ladies Dormitory"
         class="about-img"
         style="object-position: center;">
  </div>
</div>
</section>

<section class="cta-section" id="contact">
  <div class="contact-inner reveal">
    <div class="contact-copy">
      <div class="section-tag">Get DormEase</div>
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
    <a class="contact-map-link"
       href="https://maps.google.com/?q=1235%20Navarra%20St,%20Sampaloc,%20Manila,%201015%20Metro%20Manila&ftid=0x3397b5ffdcdacc75:0x38ad8e34f1c2236f&entry=gps&lucs=,94284469,94231188,47071704,94218641,94282134,94286869&g_st=ipc"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="Open Sanctissimo Rosario Ladies Dormitory in Google Maps">
      <span class="contact-map-wrap">
        <img src="{{ asset('images/map.jpg') }}"
             alt="Map to Sanctissimo Rosario Ladies Dormitory"
             class="contact-map-img"
             onerror="this.style.display='none';this.parentElement.classList.add('map-missing')">
      </span>
      <span class="contact-map-prompt">
        Click here to see directions
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M7 17L17 7"></path>
          <path d="M9 7h8v8"></path>
        </svg>
      </span>
    </a>
  </div>
</section>

<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-logo">

        <a href="{{ route('login') }}" class="footer-logo">
            <img src="{{ asset('images/logo.png') }}"
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
      <a href="#about">About</a>
      <a href="#gallery">Room Types</a>
      <a href="#">Amenities</a>
      <a href="https://maps.google.com/?q=1235%20Navarra%20St,%20Sampaloc,%20Manila,%201015%20Metro%20Manila&ftid=0x3397b5ffdcdacc75:0x38ad8e34f1c2236f&entry=gps&lucs=,94284469,94231188,47071704,94218641,94282134,94286869&g_st=ipc">Location</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="tel:+639175359723">+63 917 535 9723</a>
      <a href="#">1229 Navarra St.</a>
      <a href="#">Sampaloc, Manila</a>
    </div>
  </div>
<div class="footer-btm">
  <span>© 2026 DormEase: Sanctissimo Rosario Ladies Dormitory</span>
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
    <div class="footer-links">
    <a href="#">Privacy Policy</a>
    <a href="{{ route('faqs') }}">FAQs</a>
    <a href="{{ route('login') }}">Admin Portal</a>
    </div>
  </div>
</div>
</footer>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn" aria-label="Scroll to top">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"></polyline></svg>
</button>

<script>
  const nav = document.getElementById('navbar');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 20));

  // Scroll-to-top logic
  const scrollTopBtn = document.getElementById('scrollTopBtn');
  window.addEventListener('scroll', () => {
    scrollTopBtn.classList.toggle('visible', scrollY > 300);
  });
  scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
  
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.10 });
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

  // Highlight nav link matching the section currently in view
  const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        navLinks.forEach(link => link.classList.remove('nav-active'));
        const active = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
        if (active) active.classList.add('nav-active');
      }
    });
  }, {
    rootMargin: '-40% 0px -55% 0px', // triggers when section is near middle of viewport
    threshold: 0
  });

  document.querySelectorAll('section[id]').forEach(section => observer.observe(section));
</script>
</body>
</html>
