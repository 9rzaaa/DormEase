<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DormEase: Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<style>
    :root {
        --hot-pink:    #E8175D;
        --bright-pink: #FF2D78;
        --pink:        #CA5D86;
        --pink-light:  #FFB0CE;
        --pink-card:   #fce8f1;
        --pink-bg:     #fdf0f5;
        --pink-tint:   #fff0f6;
        --pink-100:    #fce4ec;
        --gray-light:  #E5ECF6;
        --gray:        #B5B7C0;
        --white:       #ffffff;
        --ink:         #1a1a2e;
        --ink-muted:   #7a5f6e;
        --red:         #DF0404;
        --ff-display:  'DM Serif Display', Georgia, serif;
        --ff-body:     'DM Sans', sans-serif;
        --transition:  .2s cubic-bezier(.4, 0, .2, 1);
        --radius-md:   10px;
        --radius-pill: 999px;
    }

    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--ff-body);
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    .left {
        flex: 1;
        background: linear-gradient(160deg, var(--bright-pink) 0%, var(--hot-pink) 45%, #b0103f 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    .left::before {
        content: '';
        position: absolute;
        width: 420px; height: 420px;
        border-radius: 50%;
        background: transparent;
        top: -120px; left: -120px;
        pointer-events: none;
    }

    .left::after {
        content: '';
        position: absolute;
        width: 340px; height: 340px;
        border-radius: 50%;
        background: transparent;
        bottom: -90px; right: -90px;
        pointer-events: none;
    }

    .ring {
        position: absolute;
        border-radius: 50%;
        top: 50%; left: 55%;
        transform: translate(-50%, -50%);
        background: transparent;
        pointer-events: none;
    }

    .ring-1 {
        width: 220px; height: 220px;
        border: 1.5px dashed rgba(255, 255, 255, .8);
        animation: spinSlow 22s linear infinite;
    }

    .ring-2 {
        width: 360px; height: 360px;
        border: 1px dashed rgba(255, 255, 255, .55);
        animation: spinSlow 38s linear infinite reverse;
    }

    .ring-3 {
        width: 500px; height: 500px;
        border: 1px dashed rgba(255, 255, 255, .35);
        animation: spinSlow 55s linear infinite;
    }

    @keyframes spinSlow {
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .dot-grid {
        position: absolute;
        bottom: 130px; left: 3rem;
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        opacity: .18;
        pointer-events: none;
    }

    .dot-grid span {
        width: 4px; height: 4px;
        border-radius: 50%;
        background: #fff;
        display: block;
    }

    .student-wrap {
        position: absolute;
        bottom: 0; right: 0;
        width: 600px;
        z-index: 1;
        pointer-events: none;
        animation: float 5s ease-in-out infinite;
        opacity: .85;
    }

    .student-wrap::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 120px;
        background: linear-gradient(to top, #b0103f 0%, transparent 100%);
        pointer-events: none;
    }

    .student-wrap img {
        width: 100%;
        display: block;
        filter: drop-shadow(-8px 0 32px rgba(0, 0, 0, .25));
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-14px); }
    }

    .left-logo {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: .75rem;
        animation: leftSlide .6s ease .10s both;
    }

    .logo-mark {
        width: 44px; height: 44px;
        background: rgba(255, 255, 255, .2);
        border: 2px solid rgba(255, 255, 255, .4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        overflow: hidden;
        transition: background var(--transition);
    }

    .logo-mark:hover { background: rgba(255, 255, 255, .32); }

    .logo-mark img {
        width: 26px; height: 26px;
        object-fit: contain;
    }

    .logo-text {
        font-family: var(--ff-display);
        font-size: 1.5rem;
        color: #fff;
        letter-spacing: -.01em;
    }

    .logo-text span {
        font-style: italic;
        opacity: .85;
    }

    .left-body {
        position: relative;
        z-index: 2;
        animation: leftSlide .6s ease .24s both;
    }

    .left-body h1 {
        font-family: var(--ff-display);
        font-size: clamp(2.2rem, 3.4vw, 3.3rem);
        color: #fff;
        line-height: 1.12;
        letter-spacing: -.02em;
        margin-bottom: 1.1rem;
    }

    .left-body h1 em {
        font-style: italic;
        color: var(--pink-light);
    }

    .left-body p {
        font-size: .94rem;
        color: rgba(255, 255, 255, .72);
        line-height: 1.75;
        max-width: 310px;
    }

    .pills {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        margin-top: 1.8rem;
    }

    .pill {
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .25);
        color: #fff;
        font-size: .76rem;
        font-weight: 500;
        padding: .32rem .8rem;
        border-radius: var(--radius-pill);
        display: flex;
        align-items: center;
        gap: .4rem;
        backdrop-filter: blur(4px);
        transition: background var(--transition), border-color var(--transition);
        cursor: default;
    }

    .pill:hover {
        background: rgba(255, 255, 255, .25);
        border-color: rgba(255, 255, 255, .45);
    }

    .pill img {
        width: 13px; height: 13px;
        filter: brightness(0) invert(1);
    }

    .left-footer {
        position: relative;
        z-index: 2;
        font-size: .75rem;
        color: rgba(255, 255, 255, .38);
        animation: leftSlide .6s ease .38s both;
    }

    .right {
        width: 500px;
        flex-shrink: 0;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 3.5rem;
        position: relative;
        overflow-y: auto;
    }

    .right::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 220px; height: 220px;
        background: radial-gradient(ellipse at top right, var(--pink-100) 0%, transparent 70%);
        pointer-events: none;
    }

    .right::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 180px; height: 180px;
        background: radial-gradient(ellipse at bottom left, var(--pink-100) 0%, transparent 70%);
        pointer-events: none;
    }

    .form-wrap {
        width: 100%;
        max-width: 380px;
        position: relative;
        z-index: 1;
    }

    .form-wrap > * {
        opacity: 0;
        animation: slideUp .55s ease forwards;
    }

    .form-wrap > *:nth-child(1) { animation-delay: .06s; }
    .form-wrap > *:nth-child(2) { animation-delay: .13s; }
    .form-wrap > *:nth-child(3) { animation-delay: .19s; }
    .form-wrap > *:nth-child(4) { animation-delay: .26s; }
    .form-wrap > *:nth-child(5) { animation-delay: .33s; }
    .form-wrap > *:nth-child(6) { animation-delay: .40s; }
    .form-wrap > *:nth-child(7) { animation-delay: .47s; }

    .form-header { margin-bottom: 1.8rem; }

    .eyebrow {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--bright-pink);
        margin-bottom: .55rem;
        display: flex;
        align-items: center;
        gap: .45rem;
    }

    .eyebrow::before {
        content: '';
        display: block;
        width: 20px; height: 2px;
        background: linear-gradient(90deg, var(--hot-pink), var(--bright-pink));
        border-radius: 2px;
    }

    .form-header h2 {
        font-family: var(--ff-display);
        font-size: 2.1rem;
        font-weight: 400;
        color: var(--ink);
        line-height: 1.15;
        letter-spacing: -.02em;
    }

    .form-header h2 em {
        font-style: italic;
        color: var(--hot-pink);
    }

    .form-header p {
        font-size: .86rem;
        color: var(--ink-muted);
        margin-top: .55rem;
        line-height: 1.6;
    }

    .role-label {
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: .5rem;
        display: block;
    }

    .role-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem;
        margin-bottom: 1.6rem;
    }

    .role-btn {
        border: 1.5px solid var(--gray-light);
        border-radius: 14px;
        padding: .85rem 1rem;
        background: var(--white);
        text-align: left;
        display: flex;
        align-items: center;
        gap: .65rem;
        transition: border-color var(--transition), background var(--transition),
                    box-shadow var(--transition), transform .15s;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .role-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 45, 120, .07) 0%, transparent 60%);
        opacity: 0;
        transition: opacity var(--transition);
    }

    .role-btn:hover::before { opacity: 1; }

    .role-btn:hover {
        border-color: var(--pink-light);
        transform: translateY(-1px);
    }

    .role-btn:active { transform: translateY(0); }

    .role-btn.active {
        border-color: var(--bright-pink);
        background: var(--pink-tint);
        box-shadow: 0 0 0 3px rgba(255, 45, 120, .12);
    }

    .role-icon {
        width: 38px; height: 38px;
        flex-shrink: 0;
        border-radius: 10px;
        background: var(--gray-light);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background var(--transition);
    }

    .role-icon img {
        width: 20px; height: 20px;
        object-fit: contain;
    }

    .role-btn.active .role-icon {
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
    }

    .role-btn.active .role-icon img { filter: brightness(0) invert(1); }

    .role-name {
        font-size: .84rem;
        font-weight: 600;
        color: var(--ink);
    }

    .role-desc {
        font-size: .71rem;
        color: var(--ink-muted);
        margin-top: .1rem;
    }

    .role-btn.active .role-name { color: var(--hot-pink); }

    .field { margin-bottom: 1.15rem; }

    .field label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: .42rem;
    }

    .input-wrap { position: relative; }

    .input-wrap::after {
        content: '';
        position: absolute;
        bottom: 1px;
        left: 50%; right: 50%;
        height: 2px;
        background: linear-gradient(90deg, var(--hot-pink), var(--bright-pink));
        border-radius: 0 0 var(--radius-md) var(--radius-md);
        transition: left .25s ease, right .25s ease;
        pointer-events: none;
    }

    .input-wrap:focus-within::after {
        left: 1px;
        right: 1px;
    }

    .input-icon {
        position: absolute;
        left: .9rem; top: 50%;
        transform: translateY(-50%);
        width: 18px; height: 18px;
        pointer-events: none;
        opacity: .35;
    }

    .toggle-pw {
        position: absolute;
        right: .9rem; top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px; height: 24px;
        opacity: .38;
        transition: opacity var(--transition);
        cursor: pointer;
    }

    .toggle-pw:hover { opacity: .85; }

    .field-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .82rem;
        color: var(--ink-muted);
        cursor: pointer;
    }

    .remember input[type="checkbox"] {
        accent-color: var(--bright-pink);
        width: 15px; height: 15px;
    }

    .forgot {
        font-size: .82rem;
        color: var(--hot-pink);
        font-weight: 600;
        text-decoration: none;
        transition: opacity var(--transition);
    }

    .forgot:hover { opacity: .7; }

    .de-input {
        width: 100%;
        padding: .72rem .9rem .72rem 2.6rem;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--gray-light);
        font-family: var(--ff-body);
        font-size: .88rem;
        color: var(--ink);
        background: var(--pink-bg);
        outline: none;
        transition: border-color var(--transition), background var(--transition);
    }

    .de-input:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }

    .de-input::placeholder { color: var(--gray); }

    .de-alert-error {
        display: flex;
        align-items: center;
        gap: .5rem;
        background: #fff0f3;
        border: 1.5px solid var(--pink-light);
        border-radius: 10px;
        padding: .65rem .9rem;
        font-size: .83rem;
        color: var(--hot-pink);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .de-alert-error img {
        width: 16px; height: 16px;
        flex-shrink: 0;
    }

    .de-btn-primary {
        width: 100%;
        padding: .75rem 1.4rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
        color: var(--white);
        font-family: var(--ff-body);
        font-size: .93rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(232, 23, 93, .35);
        transition: opacity var(--transition), transform .15s;
        margin-top: .2rem;
    }

    .de-btn-primary:hover {
        opacity: .92;
        transform: translateY(-1px);
    }

    .de-btn-primary:active { transform: translateY(0); }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes leftSlide {
        from { opacity: 0; transform: translateX(-28px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @media (max-width: 820px) {
        body { flex-direction: column; overflow: auto; }
        .left { min-height: 240px; padding: 2rem; }
        .left-body h1 { font-size: 2rem; }
        .right { width: 100%; padding: 2.5rem 1.5rem; }
        .ring, .dot-grid, .student-wrap { display: none; }
    }

    #fp-overlay {
        position: fixed;
        inset: 0;
        background: rgba(26, 10, 20, .55);
        backdrop-filter: blur(6px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        animation: fpFadeIn .22s ease;
    }

    #fp-sheet {
        background: #fff;
        border-radius: 22px;
        width: 100%;
        max-width: 440px;
        padding: 2.2rem 2.4rem 2.4rem;
        position: relative;
        box-shadow: 0 32px 80px rgba(232, 23, 93, .18), 0 8px 24px rgba(0, 0, 0, .12);
        animation: fpSlideUp .3s cubic-bezier(.22, 1, .36, 1);
        max-height: 90vh;
        overflow-y: auto;
    }

    #fp-close {
        position: absolute;
        top: 1.1rem; right: 1.1rem;
        width: 32px; height: 32px;
        border-radius: 50%;
        background: #fdf0f5;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .2s, transform .15s;
        color: #CA5D86;
    }

    #fp-close:hover {
        background: #E8175D;
        color: #fff;
        transform: rotate(90deg);
    }

    .fp-eyebrow {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #E8175D;
        margin-bottom: .45rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .fp-eyebrow::before {
        content: '';
        display: block;
        width: 16px; height: 2px;
        background: linear-gradient(90deg, #E8175D, #FF2D78);
        border-radius: 2px;
    }

    .fp-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 1.95rem;
        font-weight: 400;
        color: #1a1a2e;
        line-height: 1.15;
        letter-spacing: -.02em;
        margin-bottom: .6rem;
    }

    .fp-title em {
        font-style: italic;
        color: #E8175D;
    }

    .fp-sub {
        font-size: .85rem;
        color: #7a5f6e;
        line-height: 1.65;
        margin-bottom: 1.4rem;
    }

    .fp-role-row {
        display: flex;
        flex-direction: column;
        gap: .7rem;
    }

    .fp-role-btn {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: 1rem 1.1rem;
        border-radius: 14px;
        border: 1.5px solid #E5ECF6;
        background: #fff;
        text-align: left;
        cursor: pointer;
        transition: border-color .2s, background .2s, transform .15s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .fp-role-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 45, 120, .06) 0%, transparent 60%);
        opacity: 0;
        transition: opacity .2s;
    }

    .fp-role-btn:hover {
        border-color: #FFB0CE;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(232, 23, 93, .12);
    }

    .fp-role-btn:hover::before { opacity: 1; }
    .fp-role-btn:active { transform: translateY(0); }

    .fp-role-icon {
        width: 42px; height: 42px;
        flex-shrink: 0;
        border-radius: 11px;
        background: linear-gradient(135deg, #E8175D, #FF2D78);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fp-role-icon img {
        width: 22px; height: 22px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .fp-role-name {
        font-size: .86rem;
        font-weight: 700;
        color: #1a1a2e;
    }

    .fp-role-desc {
        font-size: .72rem;
        color: #7a5f6e;
        margin-top: .1rem;
    }

    .fp-arrow {
        margin-left: auto;
        flex-shrink: 0;
        color: #CA5D86;
        transition: transform .2s, opacity .2s;
    }

    .fp-role-btn:hover .fp-arrow {
        transform: translateX(3px);
        opacity: .7;
    }

    .fp-back {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .78rem;
        font-weight: 600;
        color: #7a5f6e;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        margin-bottom: 1.2rem;
        transition: color .2s;
    }

    .fp-back:hover { color: #E8175D; }

    .fp-field { margin-bottom: 1.1rem; }

    .fp-field label {
        display: block;
        font-size: .76rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: .4rem;
    }

    .fp-input-wrap { position: relative; }

    .fp-input-wrap::after {
        content: '';
        position: absolute;
        bottom: 1px;
        left: 50%; right: 50%;
        height: 2px;
        background: linear-gradient(90deg, #E8175D, #FF2D78);
        border-radius: 0 0 10px 10px;
        transition: left .25s ease, right .25s ease;
        pointer-events: none;
    }

    .fp-input-wrap:focus-within::after {
        left: 1px;
        right: 1px;
    }

    .fp-input-icon {
        position: absolute;
        left: .85rem; top: 50%;
        transform: translateY(-50%);
        width: 18px; height: 18px;
        pointer-events: none;
        opacity: .35;
    }

    .fp-input {
        width: 100%;
        padding: .7rem .85rem .7rem 2.55rem;
        border-radius: 10px;
        border: 1.5px solid #E5ECF6;
        background: #fdf0f5;
        font-family: 'DM Sans', sans-serif;
        font-size: .87rem;
        color: #1a1a2e;
        outline: none;
        transition: border-color .2s, background .2s;
    }

    .fp-input:focus {
        border-color: #FF2D78;
        background: #fff;
    }

    .fp-input::placeholder { color: #B5B7C0; }

    .fp-eye-btn {
        position: absolute;
        right: .8rem; top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .fp-eye-btn img {
        width: 18px; height: 18px;
        opacity: .35;
        transition: opacity .2s;
    }

    .fp-eye-btn:hover img { opacity: .8; }

    .fp-strength-bar {
        height: 3px;
        background: #E5ECF6;
        border-radius: 3px;
        margin-top: .55rem;
        overflow: hidden;
    }

    #fp-strength-fill {
        height: 100%;
        width: 0%;
        border-radius: 3px;
        transition: width .35s ease, background .35s ease;
    }

    .fp-strength-label {
        font-size: .7rem;
        font-weight: 600;
        margin-top: .3rem;
        height: .9rem;
        transition: color .3s;
    }

    .fp-requirements {
        margin-top: .65rem;
        display: flex;
        flex-direction: column;
        gap: .28rem;
    }

    .fp-req {
        display: flex;
        align-items: center;
        gap: .45rem;
        font-size: .72rem;
        color: #b5b7c0;
        font-weight: 500;
        transition: color .25s;
    }

    .fp-req.met { color: #16a34a; }

    .fp-req-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #e5ecf6;
        flex-shrink: 0;
        transition: background .25s;
    }

    .fp-req.met .fp-req-dot { background: #16a34a; }

    .fp-btn-primary {
        width: 100%;
        padding: .75rem 1.2rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #E8175D 0%, #FF2D78 100%);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(232, 23, 93, .32);
        transition: opacity .2s, transform .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        margin-top: .4rem;
    }

    .fp-btn-primary:hover {
        opacity: .9;
        transform: translateY(-1px);
    }

    .fp-btn-primary:active { transform: translateY(0); }

    .fp-btn-outline {
        width: 100%;
        padding: .72rem 1.2rem;
        border-radius: 12px;
        border: 1.5px solid #E8175D;
        background: transparent;
        color: #E8175D;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, color .2s, transform .15s;
        margin-top: .6rem;
    }

    .fp-btn-outline:hover {
        background: #E8175D;
        color: #fff;
        transform: translateY(-1px);
    }

    .fp-btn-outline:active { transform: translateY(0); }

    .fp-alert {
        display: flex;
        align-items: center;
        gap: .5rem;
        background: #fff0f3;
        border: 1.5px solid #FFB0CE;
        border-radius: 9px;
        padding: .6rem .85rem;
        font-size: .81rem;
        font-weight: 600;
        color: #E8175D;
        margin-bottom: .9rem;
    }

    .fp-alert img {
        width: 15px; height: 15px;
        flex-shrink: 0;
    }

    .fp-loader {
        width: 16px; height: 16px;
        border: 2.5px solid rgba(255, 255, 255, .35);
        border-top-color: #fff;
        border-radius: 50%;
        animation: fpSpin .7s linear infinite;
        display: inline-block;
    }

    .fp-success-wrap {
        text-align: center;
        padding: .8rem 0 .4rem;
    }

    .fp-success-icon {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, #E8175D, #FF2D78);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.3rem;
        box-shadow: 0 10px 32px rgba(232, 23, 93, .35);
        animation: fpPop .4s cubic-bezier(.22, 1, .36, 1);
    }

    .fp-done-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 1.5rem;
        color: #1a1a2e;
        margin-bottom: .6rem;
    }

    .fp-done-sub {
        font-size: .84rem;
        color: #7a5f6e;
        line-height: 1.65;
        margin-bottom: 1.4rem;
    }

    .fp-fd-card {
        display: flex;
        align-items: flex-start;
        gap: .9rem;
        background: #fdf0f5;
        border: 1.5px solid #FFB0CE;
        border-radius: 14px;
        padding: 1rem 1.1rem;
        margin-bottom: 1.3rem;
    }

    .fp-fd-icon-wrap {
        width: 40px; height: 40px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #E8175D, #FF2D78);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: .1rem;
    }

    .fp-fd-icon-wrap img {
        width: 20px; height: 20px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .fp-fd-card-title {
        font-size: .85rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: .25rem;
    }

    .fp-fd-card-desc {
        font-size: .78rem;
        color: #7a5f6e;
        line-height: 1.6;
    }

    .fp-fd-steps {
        display: flex;
        flex-direction: column;
        gap: .75rem;
        margin-bottom: 1.2rem;
    }

    .fp-fd-step {
        display: flex;
        align-items: flex-start;
        gap: .85rem;
    }

    .fp-fd-step-num {
        width: 26px; height: 26px;
        flex-shrink: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, #E8175D, #FF2D78);
        color: #fff;
        font-size: .75rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 10px rgba(232, 23, 93, .3);
        margin-top: .05rem;
    }

    .fp-fd-step-text {
        font-size: .82rem;
        color: #7a5f6e;
        line-height: 1.6;
    }

    @keyframes fpFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    @keyframes fpSlideUp {
        from { opacity: 0; transform: translateY(24px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes fpSpin {
        to { transform: rotate(360deg); }
    }

    @keyframes fpPop {
        from { transform: scale(.5); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 480px) {
        #fp-sheet { padding: 1.8rem 1.5rem 2rem; border-radius: 18px; }
        .fp-title { font-size: 1.65rem; }
    }
</style>


<div class="left">

    <div class="ring ring-1"></div>
    <div class="ring ring-2"></div>
    <div class="ring ring-3"></div>

    <div class="dot-grid">
        @for ($i = 0; $i < 30; $i++)
            <span></span>
        @endfor
    </div>

    <div class="student-wrap">
        <img src="{{ asset('images/girl.png') }}" alt="Student">
    </div>

    <a href="{{ route('home') }}" class="left-logo" style="text-decoration: none;">
        <div class="logo-mark">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </div>
        <div class="logo-text">Dorm<span>Ease</span></div>
    </a>

    <div class="left-body">
        <h1>Manage with<br>ease &amp;<br><em>confidence.</em></h1>
        <p>The DormEase portal gives you full control over rooms, tenants, payments, and maintenance all in one place.</p>

        <div class="pills">
            <span class="pill"><img src="{{ asset('icons/bed.png') }}" alt="">Room Management</span>
            <span class="pill"><img src="{{ asset('icons/tenants.png') }}" alt="">Tenant Records</span>
            <span class="pill"><img src="{{ asset('icons/billing.png') }}" alt="">Billing &amp; Payments</span>
            <span class="pill"><img src="{{ asset('icons/announce.png') }}" alt="">Announcements</span>
            <span class="pill"><img src="{{ asset('icons/maintenance.png') }}" alt="">Maintenance</span>
        </div>
    </div>

    <div class="left-footer">&copy; {{ date('Y') }} DormEase. All rights reserved.</div>

</div>


<div class="right">
    <div class="form-wrap">

        <div class="form-header">
            <div class="eyebrow">Admin Portal</div>
            <h2>Welcome to<br><em>DormEase</em></h2>
            <p>Select your role and sign in with your credentials to continue.</p>
        </div>

        <span class="role-label">Sign in as</span>

        <div class="role-row">
            <button type="button" class="role-btn {{ old('role', 'admin') === 'admin' ? 'active' : '' }}" id="role-admin" onclick="setRole('admin')">
                <div class="role-icon">
                    <img src="{{ asset('icons/admin.png') }}" alt="Admin">
                </div>
                <div>
                    <div class="role-name">Admin</div>
                    <div class="role-desc">Full access</div>
                </div>
            </button>

            <button type="button" class="role-btn {{ old('role') === 'frontdesk' ? 'active' : '' }}" id="role-frontdesk" onclick="setRole('frontdesk')">
                <div class="role-icon">
                    <img src="{{ asset('icons/staff.png') }}" alt="Front Desk">
                </div>
                <div>
                    <div class="role-name">Front Desk</div>
                    <div class="role-desc">Staff access</div>
                </div>
            </button>
        </div>

        <form method="POST" action="/login">
            @csrf

            <input type="hidden" name="role" id="role-input" value="{{ old('role', 'admin') }}">

            @if ($errors->any())
                <div class="de-alert-error">
                    <img src="{{ asset('icons/warning.png') }}" alt="Error">
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <img class="input-icon" src="{{ asset('icons/email.png') }}" alt="">
                    <input
                        class="de-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <img class="input-icon" src="{{ asset('icons/lock.png') }}" alt="">
                    <input
                        class="de-input"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        style="padding-right: 2.8rem;"
                        required
                    >
                    <button
                        type="button"
                        class="toggle-pw"
                        id="pw-toggle"
                        onclick="togglePw()"
                        aria-label="Toggle password visibility"
                    >
                        <img
                            id="pw-eye-icon"
                            src="{{ asset('icons/eye.png') }}"
                            alt="Toggle Password"
                            style="width: 18px; height: 18px;"
                        >
                    </button>
                </div>
            </div>

            <div class="field-row">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                <a href="#" class="forgot" onclick="event.preventDefault(); openFP()">Forgot password?</a>
            </div>

            <button type="submit" class="de-btn-primary">
                <span>&#8594;</span>
                Sign In
            </button>
        </form>

    </div>
</div>


<div id="fp-overlay" style="display: none;" onclick="if (event.target === this) closeFP()">
    <div id="fp-sheet">

        <button id="fp-close" type="button" onclick="closeFP()" aria-label="Close">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M2 2L16 16M16 2L2 16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
            </svg>
        </button>

        <div id="fp-step-role">
            <div class="fp-eyebrow">Account Recovery</div>
            <h3 class="fp-title">Reset your<br><em>password</em></h3>
            <p class="fp-sub">First, tell us which role your account belongs to.</p>

            <div class="fp-role-row">
                <button type="button" class="fp-role-btn" onclick="fpSetRole('admin')">
                    <div class="fp-role-icon">
                        <img src="{{ asset('icons/admin.png') }}" alt="Admin">
                    </div>
                    <div>
                        <div class="fp-role-name">Admin</div>
                        <div class="fp-role-desc">Full access account</div>
                    </div>
                    <svg class="fp-arrow" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <button type="button" class="fp-role-btn" onclick="fpSetRole('frontdesk')">
                    <div class="fp-role-icon">
                        <img src="{{ asset('icons/staff.png') }}" alt="Front Desk">
                    </div>
                    <div>
                        <div class="fp-role-name">Front Desk</div>
                        <div class="fp-role-desc">Staff access account</div>
                    </div>
                    <svg class="fp-arrow" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="fp-step-admin" style="display: none;">
            <button type="button" class="fp-back" onclick="fpBack('admin')">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M12 7H2M6 3L2 7l4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
            </button>

            <div class="fp-eyebrow">Admin Recovery</div>
            <h3 class="fp-title">Reset your<br><em>password</em></h3>

            <div id="fp-admin-email-step">
                <p class="fp-sub">Enter your admin email address to verify your account.</p>
                <div id="fp-admin-err" class="fp-alert" style="display: none;">
                    <img src="{{ asset('icons/warning.png') }}" alt="Error">
                    <span></span>
                </div>
                <div class="fp-field">
                    <label>Email Address</label>
                    <div class="fp-input-wrap">
                        <img class="fp-input-icon" src="{{ asset('icons/email.png') }}" alt="">
                        <input type="email" id="fp-admin-email" class="fp-input" placeholder="admin@dormease.com" autocomplete="off">
                    </div>
                </div>
                <button type="button" class="fp-btn-primary" onclick="fpVerifyAdmin()">
                    <span id="fp-verify-txt">Verify Account</span>
                    <span id="fp-verify-loader" class="fp-loader" style="display: none;"></span>
                </button>
            </div>

            <div id="fp-admin-pw-step" style="display: none;">
                <p class="fp-sub">Choose a strong new password for your account.</p>
                <div id="fp-pw-err" class="fp-alert" style="display: none;">
                    <img src="{{ asset('icons/warning.png') }}" alt="Error">
                    <span></span>
                </div>
                <div class="fp-field">
                    <label>New Password</label>
                    <div class="fp-input-wrap">
                        <img class="fp-input-icon" src="{{ asset('icons/lock.png') }}" alt="">
                        <input type="password" id="fp-new-pw" class="fp-input" placeholder="Minimum 8 characters" style="padding-right: 2.8rem;">
                        <button type="button" class="fp-eye-btn" onclick="fpTogglePw('fp-new-pw', this)">
                            <img id="fp-eye-new" src="{{ asset('icons/eye.png') }}" alt="Toggle">
                        </button>
                    </div>
                    <div class="fp-strength-bar"><div id="fp-strength-fill"></div></div>
                    <div id="fp-strength-label" class="fp-strength-label"></div>
                    <div class="fp-requirements" id="fp-requirements">
                        <div class="fp-req" id="req-length">
                            <span class="fp-req-dot"></span>At least 8 characters
                        </div>
                        <div class="fp-req" id="req-upper">
                            <span class="fp-req-dot"></span>One uppercase letter
                        </div>
                        <div class="fp-req" id="req-number">
                            <span class="fp-req-dot"></span>One number
                        </div>
                        <div class="fp-req" id="req-special">
                            <span class="fp-req-dot"></span>One special character
                        </div>
                    </div>
                </div>
                <div class="fp-field">
                    <label>Confirm Password</label>
                    <div class="fp-input-wrap">
                        <img class="fp-input-icon" src="{{ asset('icons/lock.png') }}" alt="">
                        <input type="password" id="fp-confirm-pw" class="fp-input" placeholder="Re-enter password" style="padding-right: 2.8rem;">
                        <button type="button" class="fp-eye-btn" onclick="fpTogglePw('fp-confirm-pw', this)">
                            <img id="fp-eye-confirm" src="{{ asset('icons/eye.png') }}" alt="Toggle">
                        </button>
                    </div>
                </div>
                <button type="button" class="fp-btn-primary" onclick="fpResetAdminPassword()">
                    <span id="fp-reset-txt">Update Password</span>
                    <span id="fp-reset-loader" class="fp-loader" style="display: none;"></span>
                </button>
            </div>

            <div id="fp-admin-done" style="display: none;">
                <div class="fp-success-wrap">
                    <div class="fp-success-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <h4 class="fp-done-title">Password Updated</h4>
                    <p class="fp-done-sub">Your password has been changed successfully. You can now sign in with your new credentials.</p>
                    <button type="button" class="fp-btn-primary" onclick="closeFP()">Back to Sign In</button>
                </div>
            </div>
        </div>

        <div id="fp-step-frontdesk" style="display: none;">
            <button type="button" class="fp-back" onclick="fpBack('frontdesk')">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M12 7H2M6 3L2 7l4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
            </button>

            <div class="fp-eyebrow">Staff Recovery</div>
            <h3 class="fp-title">Contact your<br><em>Admin</em></h3>

            <div class="fp-fd-card">
                <div class="fp-fd-icon-wrap">
                    <img src="{{ asset('icons/lock.png') }}" alt="">
                </div>
                <div class="fp-fd-card-body">
                    <div class="fp-fd-card-title">Request a temporary password</div>
                    <div class="fp-fd-card-desc">Ask your admin to reset your account. They will generate a temporary password for you to use.</div>
                </div>
            </div>

            <div class="fp-fd-steps">
                <div class="fp-fd-step">
                    <div class="fp-fd-step-num">1</div>
                    <div class="fp-fd-step-text">Contact the administrator and request a password reset for your front desk account.</div>
                </div>
                <div class="fp-fd-step">
                    <div class="fp-fd-step-num">2</div>
                    <div class="fp-fd-step-text">The admin will navigate to Staff Management and reset your password, generating a temporary one.</div>
                </div>
                <div class="fp-fd-step">
                    <div class="fp-fd-step-num">3</div>
                    <div class="fp-fd-step-text">Use that temporary password to log in. You will be prompted to set a personal password right away.</div>
                </div>
            </div>

            <button type="button" class="fp-btn-outline" onclick="closeFP()">Got it, I'll contact admin</button>
        </div>

    </div>
</div>


<script>
    var fpAdminEmail = '';

    function setRole(role) {
        ['admin', 'frontdesk'].forEach(function(r) {
            document.getElementById('role-' + r).classList.toggle('active', r === role);
        });
        document.getElementById('role-input').value = role;
        document.querySelector('.eyebrow').textContent = role === 'admin' ? 'Admin Portal' : 'Staff Portal';
    }

    function togglePw() {
        var input = document.getElementById('password');
        var icon  = document.getElementById('pw-eye-icon');
        var show  = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.src   = show ? "{{ asset('icons/eye-off.png') }}" : "{{ asset('icons/eye.png') }}";
    }

    function openFP() {
        document.getElementById('fp-overlay').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        fpResetAll();
    }

    function closeFP() {
        document.getElementById('fp-overlay').style.display = 'none';
        document.body.style.overflow = '';
    }

    function fpResetAll() {
        document.getElementById('fp-step-role').style.display        = '';
        document.getElementById('fp-step-admin').style.display       = 'none';
        document.getElementById('fp-step-frontdesk').style.display   = 'none';
        document.getElementById('fp-admin-email-step').style.display = '';
        document.getElementById('fp-admin-pw-step').style.display    = 'none';
        document.getElementById('fp-admin-done').style.display       = 'none';
        document.getElementById('fp-admin-email').value              = '';
        document.getElementById('fp-new-pw').value                   = '';
        document.getElementById('fp-confirm-pw').value               = '';
        document.getElementById('fp-admin-err').style.display        = 'none';
        document.getElementById('fp-pw-err').style.display           = 'none';
        fpAdminEmail = '';
    }

    function fpSetRole(role) {
        document.getElementById('fp-step-role').style.display = 'none';
        document.getElementById('fp-step-' + role).style.display = '';
    }

    function fpBack(role) {
        document.getElementById('fp-step-' + role).style.display = 'none';
        document.getElementById('fp-step-role').style.display = '';
    }

    function fpShowErr(id, msg) {
        var el   = document.getElementById(id);
        var span = el.querySelector('span');
        if (span) span.textContent = msg;
        else el.textContent = msg;
        el.style.display = 'flex';
    }

    function fpHideErr(id) {
        document.getElementById(id).style.display = 'none';
    }

    function fpTogglePw(inputId, btn) {
        var input = document.getElementById(inputId);
        var img   = btn.querySelector('img');
        var show  = input.type === 'password';
        input.type = show ? 'text' : 'password';
        if (img) img.src = show ? "{{ asset('icons/eye-off.png') }}" : "{{ asset('icons/eye.png') }}";
    }

    function fpCheckStrength(pw) {
        var score = 0;
        if (pw.length >= 8)          score++;
        if (/[A-Z]/.test(pw))        score++;
        if (/[0-9]/.test(pw))        score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;
        return score;
    }

    document.getElementById('fp-new-pw').addEventListener('input', function() {
        var val    = this.value;
        var score  = fpCheckStrength(val);
        var fill   = document.getElementById('fp-strength-fill');
        var label  = document.getElementById('fp-strength-label');
        var colors = ['#DF0404', '#FF8C00', '#f0c040', '#22c55e'];
        var labels = ['Weak', 'Fair', 'Good', 'Strong'];

        if (!val) {
            fill.style.width  = '0%';
            label.textContent = '';
        } else {
            fill.style.width      = (score * 25) + '%';
            fill.style.background = colors[score - 1] || colors[0];
            label.textContent     = labels[score - 1] || labels[0];
            label.style.color     = colors[score - 1] || colors[0];
        }

        var toggle = function(id, met) {
            var el = document.getElementById(id);
            if (met) el.classList.add('met');
            else el.classList.remove('met');
        };
        toggle('req-length',  val.length >= 8);
        toggle('req-upper',   /[A-Z]/.test(val));
        toggle('req-number',  /[0-9]/.test(val));
        toggle('req-special', /[^A-Za-z0-9]/.test(val));
    });

    function fpGetCsrf() {
        var meta  = document.querySelector('meta[name="csrf-token"]');
        var input = document.querySelector('input[name="_token"]');
        return meta ? meta.content : (input ? input.value : '');
    }

    function fpVerifyAdmin() {
        var email = document.getElementById('fp-admin-email').value.trim();
        fpHideErr('fp-admin-err');

        if (!email) {
            fpShowErr('fp-admin-err', 'Please enter your email address.');
            return;
        }

        var txt    = document.getElementById('fp-verify-txt');
        var loader = document.getElementById('fp-verify-loader');
        txt.style.display    = 'none';
        loader.style.display = 'inline-block';

        fetch('/forgot-password/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': fpGetCsrf(),
                'Accept':       'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            txt.style.display    = 'inline';
            loader.style.display = 'none';

            if (data.success) {
                fpAdminEmail = email;
                document.getElementById('fp-admin-email-step').style.display = 'none';
                document.getElementById('fp-admin-pw-step').style.display    = '';
            } else {
                fpShowErr('fp-admin-err', data.message || 'No admin account found with that email.');
            }
        })
        .catch(function() {
            txt.style.display    = 'inline';
            loader.style.display = 'none';
            fpShowErr('fp-admin-err', 'Something went wrong. Please try again.');
        });
    }

    function fpResetAdminPassword() {
        var pw      = document.getElementById('fp-new-pw').value;
        var confirm = document.getElementById('fp-confirm-pw').value;
        fpHideErr('fp-pw-err');

        if (pw.length < 8) {
            fpShowErr('fp-pw-err', 'Password must be at least 8 characters.');
            return;
        }
        if (pw !== confirm) {
            fpShowErr('fp-pw-err', 'Passwords do not match.');
            return;
        }
        if (fpCheckStrength(pw) < 2) {
            fpShowErr('fp-pw-err', 'Please choose a stronger password.');
            return;
        }

        var txt    = document.getElementById('fp-reset-txt');
        var loader = document.getElementById('fp-reset-loader');
        txt.style.display    = 'none';
        loader.style.display = 'inline-block';

        fetch('/forgot-password/reset', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': fpGetCsrf(),
                'Accept':       'application/json'
            },
            body: JSON.stringify({
                email:                 fpAdminEmail,
                password:              pw,
                password_confirmation: confirm
            })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            txt.style.display    = 'inline';
            loader.style.display = 'none';

            if (data.success) {
                document.getElementById('fp-admin-pw-step').style.display = 'none';
                document.getElementById('fp-admin-done').style.display    = '';
            } else if (data.same_password) {
                fpShowErr('fp-pw-err', 'This is your current password. Please choose a different one.');
            } else {
                fpShowErr('fp-pw-err', data.message || 'Could not update password. Please try again.');
            }
        })
        .catch(function() {
            txt.style.display    = 'inline';
            loader.style.display = 'none';
            fpShowErr('fp-pw-err', 'Something went wrong. Please try again.');
        });
    }
</script>

</body>
</html>