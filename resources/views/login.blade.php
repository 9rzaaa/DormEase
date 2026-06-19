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
        --green:       #16a34a;
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
        background: #fff;
    }

    .left {
        flex: 1;
        background: linear-gradient(160deg, #FF2D78 0%, #E8175D 45%, #a50e37 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        z-index: 2;
        box-shadow: 6px 0 48px rgba(232,23,93,.22);
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
        border: 1.5px dashed rgba(255,255,255,.8);
        animation: spinSlow 22s linear infinite;
    }

    .ring-2 {
        width: 360px; height: 360px;
        border: 1px dashed rgba(255,255,255,.55);
        animation: spinSlow 38s linear infinite reverse;
    }

    .ring-3 {
        width: 500px; height: 500px;
        border: 1px dashed rgba(255,255,255,.35);
        animation: spinSlow 55s linear infinite;
    }

    @keyframes spinSlow {
        to { transform: translate(-50%,-50%) rotate(360deg); }
    }

    .dot-grid {
        position: absolute;
        bottom: 130px; left: 3rem;
        display: grid;
        grid-template-columns: repeat(6,1fr);
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
        height: 700px;
        z-index: 1;
        pointer-events: none;
        animation: float 5s ease-in-out infinite;
        opacity: .85;
        will-change: transform;
        transition: transform .1s ease-out;
    }

    .student-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: bottom;
        display: block;
        position: absolute;
        bottom: 0;
        left: 0;
        top: 0;
        transition: opacity .4s ease;
        z-index: 1;
        opacity: 1;
    }

    .student-img-cover {
        opacity: 0;
        top: 0;
    }

    #student-normal {
        opacity: 1;
    }

    #student-cover {
        opacity: 0;
    }

    .student-wrap::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 160px;
        background: linear-gradient(to top, #a50e37 0%, #a50e3700 100%);
        pointer-events: none;
        z-index: 2;
    }

    @keyframes float {
        0%,100% { transform: translateY(0) translateX(0); }
        50%      { transform: translateY(-14px) translateX(0); }
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
        background: rgba(255,255,255,.2);
        border: 2px solid rgba(255,255,255,.4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        overflow: hidden;
        transition: background var(--transition);
    }

    .logo-mark:hover { background: rgba(255,255,255,.32); }

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
    }

    .left-body h1 {
        font-family: var(--ff-display);
        font-size: clamp(2.2rem,3.4vw,3.3rem);
        color: #fff;
        line-height: 1.12;
        letter-spacing: -.02em;
        margin-bottom: 1.1rem;
    }

    .left-body h1 em {
        font-style: italic;
        color: var(--pink-light);
        display: inline-block;
        animation: confidenceBloom .9s cubic-bezier(.22,1,.36,1) .72s both;
    }

    @keyframes confidenceBloom {
        0%   { opacity: 0; transform: translateY(12px); color: #fff; }
        60%  { color: #fff; }
        100% { opacity: 1; transform: translateY(0); color: var(--pink-light); }
    }

    .left-body p {
        font-size: .94rem;
        color: rgba(255,255,255,.72);
        line-height: 1.75;
        max-width: 310px;
        margin-bottom: 1.8rem;
        opacity: 0;
        animation: leftFadeUp .6s ease .88s forwards;
    }

    @keyframes leftFadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .h1-line {
        display: block;
        opacity: 0;
        animation: h1LineIn .55s cubic-bezier(.34,1.56,.64,1) both;
    }

    .h1-line-1 { animation-delay: .18s; }
    .h1-line-2 { animation-delay: .34s; }
    .h1-line-3 { animation-delay: .52s; }

    @keyframes h1LineIn {
        from { opacity: 0; transform: translateX(-22px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .feature-strip {
        display: flex;
        align-items: center;
        gap: .65rem;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: var(--radius-pill);
        padding: .45rem .9rem .45rem .6rem;
        width: fit-content;
        backdrop-filter: blur(6px);
        animation: leftSlide .6s ease .32s both;
    }

    .feature-strip-icon {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background .3s;
    }

    .feature-strip-icon img {
        width: 14px; height: 14px;
        filter: brightness(0) invert(1);
        object-fit: contain;
    }

    .feature-strip-text {
        font-size: .82rem;
        font-weight: 600;
        color: #fff;
        letter-spacing: .01em;
        min-width: 170px;
    }

    .feature-cursor {
        display: inline-block;
        width: 2px;
        height: .85em;
        background: rgba(255,255,255,.8);
        margin-left: 2px;
        vertical-align: middle;
        animation: blink .75s step-end infinite;
    }

    @keyframes blink {
        0%,100% { opacity: 1; }
        50%      { opacity: 0; }
    }

    .left-footer {
        position: relative;
        z-index: 2;
        font-size: .75rem;
        color: rgba(255,255,255,.38);
        animation: leftSlide .6s ease .38s both;
    }

    .right {
        width: 500px;
        flex-shrink: 0;
        background-color: #fdf6f9;
        background-image:
            linear-gradient(to right, rgba(232,23,93,.08) 0%, transparent 38%),
            radial-gradient(circle, rgba(232,23,93,.055) 1px, transparent 1px);
        background-size: 100% 100%, 22px 22px;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 2.5rem 3.5rem 3rem;
        position: relative;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .right::-webkit-scrollbar {
        width: 0px;
    }

    .right::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 320px; height: 320px;
        background: radial-gradient(ellipse at center, rgba(255,176,206,.2) 0%, transparent 68%);
        border-radius: 50%;
        pointer-events: none;
        animation: orbDrift1 12s ease-in-out infinite;
    }

    .right::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 280px; height: 280px;
        background: radial-gradient(ellipse at center, rgba(232,23,93,.08) 0%, transparent 68%);
        border-radius: 50%;
        pointer-events: none;
        animation: orbDrift2 16s ease-in-out infinite;
    }

    @keyframes orbDrift1 {
        0%,100% { transform: translate(0,0) scale(1); }
        50%      { transform: translate(-18px, 22px) scale(1.08); }
    }

    @keyframes orbDrift2 {
        0%,100% { transform: translate(0,0) scale(1); }
        50%      { transform: translate(14px,-18px) scale(1.06); }
    }

    .form-wrap {
        width: 100%;
        max-width: 380px;
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,.96);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 22px;
        padding: 2.4rem 2.2rem;
        box-shadow:
            0 8px 48px rgba(232,23,93,.14),
            0 2px 8px rgba(0,0,0,.06),
            inset 0 1px 0 rgba(255,255,255,1);
        border: 1px solid rgba(255,255,255,.7);
        overflow: visible;
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

    .form-header { margin-bottom: 1.2rem; }

    .form-header-eyebrow {
        opacity: 0;
        animation: slideUp .5s cubic-bezier(.22,1,.36,1) .08s forwards;
    }

    .form-header-title {
        opacity: 0;
        animation: slideUp .55s cubic-bezier(.34,1.56,.64,1) .18s forwards;
        position: relative;
        cursor: default;
        isolation: isolate;
        overflow: visible;
    }

    .form-header-title em {
        font-style: italic;
        color: var(--hot-pink);
        display: inline-block;
    }

    .form-header-title .title-halo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.6);
        width: 140px;
        height: 140px;
        background: radial-gradient(ellipse at center, rgba(232,23,93,.13) 0%, transparent 70%);
        border-radius: 50%;
        opacity: 0;
        pointer-events: none;
        transition: opacity .35s ease, transform .4s cubic-bezier(.22,1,.36,1);
        z-index: 0;
    }

    .form-header-title:hover .title-halo {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }

    .form-header-sub {
        opacity: 0;
        animation: slideUp .5s cubic-bezier(.22,1,.36,1) .28s forwards;
    }

    .eyebrow {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--bright-pink);
        margin-bottom: .65rem;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        position: relative;
        padding-bottom: .3rem;
    }

    .eyebrow::before {
        display: none;
    }

    .eyebrow::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 100%;
        background: linear-gradient(90deg, var(--hot-pink), var(--bright-pink));
        border-radius: 2px;
        transform: scaleX(0);
        transform-origin: left center;
        transition: transform .38s cubic-bezier(.22,1,.36,1);
    }

    .eyebrow.line-drawn::after {
        transform: scaleX(1);
    }

    .eyebrow-inner {
        display: inline-block;
        transition: opacity .22s ease, transform .22s cubic-bezier(.4,0,.2,1);
    }

    .eyebrow-inner.switching {
        opacity: 0;
        transform: translateY(-6px);
    }

    .eyebrow-inner.entering {
        animation: eyebrowEnter .28s cubic-bezier(.22,1,.36,1) forwards;
    }

    @keyframes eyebrowEnter {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
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
        margin-bottom: 1.1rem;
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
                    box-shadow var(--transition);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        will-change: transform;
    }

    .role-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg,rgba(255,45,120,.07) 0%,transparent 60%);
        opacity: 0;
        transition: opacity var(--transition);
    }

    .role-btn:hover::before { opacity: 1; }

    .role-btn:hover {
        border-color: var(--pink-light);
    }

    .role-btn:active { transform: scale(.97); }

    .role-btn.active {
        border-color: var(--bright-pink);
        background: var(--pink-tint);
        box-shadow: 0 0 0 3px rgba(255,45,120,.12);
        transform: scale(1.03);
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,45,120,.18);
        transform: scale(0);
        animation: rippleAnim .5s linear;
        pointer-events: none;
    }

    @keyframes rippleAnim {
        to { transform: scale(4); opacity: 0; }
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
        position: relative;
    }

    .role-icon img {
        width: 20px; height: 20px;
        object-fit: contain;
        position: relative;
        z-index: 1;
    }

    .role-btn.active .role-icon {
        background: linear-gradient(135deg,var(--hot-pink),var(--bright-pink));
    }

    .role-btn.active .role-icon img { filter: brightness(0) invert(1); }

    .role-icon::after {
        content: '';
        position: absolute;
        top: -3px; right: -3px;
        width: 9px; height: 9px;
        border-radius: 50%;
        background: var(--bright-pink);
        border: 2px solid var(--white);
        opacity: 0;
        transform: scale(0);
        transition: opacity .2s, transform .25s cubic-bezier(.34,1.56,.64,1);
    }

    .role-btn.active .role-icon::after {
        opacity: 1;
        transform: scale(1);
        animation: pulseDot 1.8s ease-in-out infinite;
    }

    @keyframes pulseDot {
        0%,100% { box-shadow: 0 0 0 0 rgba(255,45,120,.5); }
        50%      { box-shadow: 0 0 0 5px rgba(255,45,120,0); }
    }

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

    .field { margin-bottom: .9rem; }

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
        background: linear-gradient(90deg,var(--hot-pink),var(--bright-pink));
        border-radius: 0 0 var(--radius-md) var(--radius-md);
        transition: left .25s ease, right .25s ease;
        pointer-events: none;
    }

    .input-wrap:focus-within::after { left: 1px; right: 1px; }

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

    .caps-icon {
        position: absolute;
        right: 2.8rem;
        top: 50%;
        transform: translateY(-50%);
        display: none;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        pointer-events: none;
    }

    .caps-icon.visible {
        display: flex;
    }

    .caps-icon svg {
        width: 15px;
        height: 15px;
    }

    .email-check {
        position: absolute;
        right: .9rem; top: 50%;
        transform: translateY(-50%);
        width: 18px; height: 18px;
        opacity: 0;
        transition: opacity .25s;
        pointer-events: none;
    }

    .email-check.visible { opacity: 1; }

    .email-check svg {
        width: 18px; height: 18px;
    }

    .field-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: .9rem;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .82rem;
        color: var(--ink-muted);
        cursor: pointer;
        user-select: none;
    }

    .remember input[type="checkbox"] {
        display: none;
    }

    .toggle-track {
        width: 34px;
        height: 19px;
        border-radius: 999px;
        background: var(--gray-light);
        border: 1.5px solid #d1d5db;
        position: relative;
        flex-shrink: 0;
        transition: background .22s ease, border-color .22s ease, box-shadow .22s ease;
    }

    .toggle-knob {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,.18);
        transition: transform .22s cubic-bezier(.34,1.56,.64,1);
    }

    .remember input[type="checkbox"]:checked ~ .toggle-track {
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        border-color: var(--hot-pink);
        box-shadow: 0 0 0 3px rgba(255,45,120,.15);
    }

    .remember input[type="checkbox"]:checked ~ .toggle-track .toggle-knob {
        transform: translateX(15px);
    }

    .remember-label {
        font-size: .82rem;
        color: var(--ink-muted);
        transition: color .2s;
    }

    .remember:has(input:checked) .remember-label {
        color: var(--hot-pink);
        font-weight: 600;
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

    .de-input.input-valid {
        border-color: var(--green);
        padding-right: 2.6rem;
    }

    @keyframes shake {
        0%,100% { transform: translateX(0); }
        15%      { transform: translateX(-6px); }
        30%      { transform: translateX(6px); }
        45%      { transform: translateX(-4px); }
        60%      { transform: translateX(4px); }
        75%      { transform: translateX(-2px); }
        90%      { transform: translateX(2px); }
    }

    .input-error-state { border-color: var(--hot-pink) !important; }

    .field-error {
        font-size: .74rem;
        font-weight: 600;
        color: var(--hot-pink);
        padding-left: .1rem;
        height: 1rem;
        line-height: 1rem;
        margin-top: .3rem;
        visibility: hidden;
    }

    .field-error.visible {
        visibility: visible;
    }

    .de-alert-error {
        display: flex;
        align-items: center;
        gap: .5rem;
        background: #fff0f3;
        border-left: 3px solid var(--hot-pink);
        border-radius: 8px;
        padding: .45rem .8rem;
        font-size: .78rem;
        color: var(--hot-pink);
        font-weight: 600;
        margin-bottom: .75rem;
        animation: slideDown .2s ease;
    }

    .de-alert-error img {
        width: 13px; height: 13px;
        flex-shrink: 0;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .de-btn-primary {
        width: 100%;
        padding: .75rem 1.4rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg,var(--hot-pink) 0%,var(--bright-pink) 100%);
        color: var(--white);
        font-family: var(--ff-body);
        font-size: .93rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(232,23,93,.35);
        transition: box-shadow .22s ease, transform .15s ease;
        margin-top: .2rem;
        position: relative;
        overflow: hidden;
    }

    .de-btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent 0%,
            rgba(255,255,255,.0) 30%,
            rgba(255,255,255,.38) 50%,
            rgba(255,255,255,.0) 70%,
            transparent 100%
        );
        transform: skewX(-18deg);
        transition: left .52s cubic-bezier(.4,0,.2,1);
        pointer-events: none;
    }

    .de-btn-primary:hover::after {
        left: 160%;
    }

    .de-btn-primary:hover {
        box-shadow: 0 10px 32px rgba(232,23,93,.48);
        transform: translateY(-2px);
    }

    .de-btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(232,23,93,.3);
    }

    .btn-spinner {
        width: 16px; height: 16px;
        border: 2.5px solid rgba(255,255,255,.35);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spinBtn .6s linear infinite;
        display: none;
    }

    @keyframes spinBtn {
        to { transform: rotate(360deg); }
    }

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
        .left { min-height: 200px; padding: 1.8rem 1.5rem; }
        .left-body h1 { font-size: 1.8rem; }
        .left-body p { font-size: .85rem; max-width: 100%; }
        .right { width: 100%; padding: 2rem 1.5rem 3rem; align-items: flex-start; overflow-y: visible; }
        .ring, .dot-grid, .student-wrap { display: none; }
        .form-wrap { padding: 2rem 1.5rem; }
    }

    @media (max-width: 540px) {
        .left { min-height: 180px; padding: 1.5rem 1.2rem; }
        .left-body h1 { font-size: 1.5rem; }
        .left-body p { display: none; }
        .feature-strip { display: none; }
        .right { padding: 1.5rem 1rem 2.5rem; }
        .form-wrap { padding: 1.6rem 1.2rem; border-radius: 16px; }
        .form-header h2 { font-size: 1.7rem; }
        .role-row { gap: .4rem; }
        .role-btn { padding: .7rem .8rem; }
        .de-input { font-size: .85rem; }
        .de-btn-primary { font-size: .88rem; padding: .7rem 1rem; }
    }

    @media (max-width: 380px) {
        .left { min-height: 160px; padding: 1.2rem 1rem; }
        .logo-text { font-size: 1.2rem; }
        .form-wrap { padding: 1.4rem 1rem; }
        .form-header h2 { font-size: 1.5rem; }
        .role-row { grid-template-columns: 1fr; }
        .field-row { flex-direction: column; align-items: flex-start; gap: .6rem; }
    }

    #fp-overlay {
        position: fixed;
        inset: 0;
        background: rgba(26,10,20,.55);
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
        box-shadow: 0 32px 80px rgba(232,23,93,.18), 0 8px 24px rgba(0,0,0,.12);
        animation: fpSlideUp .3s cubic-bezier(.22,1,.36,1);
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
        background: linear-gradient(90deg,#E8175D,#FF2D78);
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

    .fp-title em { font-style: italic; color: #E8175D; }

    .fp-sub {
        font-size: .85rem;
        color: #7a5f6e;
        line-height: 1.65;
        margin-bottom: 1.4rem;
    }

    .fp-role-row { display: flex; flex-direction: column; gap: .7rem; }

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
        background: linear-gradient(135deg,rgba(255,45,120,.06) 0%,transparent 60%);
        opacity: 0;
        transition: opacity .2s;
    }

    .fp-role-btn:hover {
        border-color: #FFB0CE;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(232,23,93,.12);
    }

    .fp-role-btn:hover::before { opacity: 1; }
    .fp-role-btn:active { transform: translateY(0); }

    .fp-role-icon {
        width: 42px; height: 42px;
        flex-shrink: 0;
        border-radius: 11px;
        background: linear-gradient(135deg,#E8175D,#FF2D78);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fp-role-icon img {
        width: 22px; height: 22px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .fp-role-name { font-size: .86rem; font-weight: 700; color: #1a1a2e; }
    .fp-role-desc { font-size: .72rem; color: #7a5f6e; margin-top: .1rem; }

    .fp-arrow {
        margin-left: auto;
        flex-shrink: 0;
        color: #CA5D86;
        transition: transform .2s, opacity .2s;
    }

    .fp-role-btn:hover .fp-arrow { transform: translateX(3px); opacity: .7; }

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
        background: linear-gradient(90deg,#E8175D,#FF2D78);
        border-radius: 0 0 10px 10px;
        transition: left .25s ease, right .25s ease;
        pointer-events: none;
    }

    .fp-input-wrap:focus-within::after { left: 1px; right: 1px; }

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

    .fp-input:focus { border-color: #FF2D78; background: #fff; }
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
        width: 7px; height: 7px;
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
        background: linear-gradient(135deg,#E8175D 0%,#FF2D78 100%);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(232,23,93,.32);
        transition: opacity .2s, transform .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        margin-top: .4rem;
    }

    .fp-btn-primary:hover { opacity: .9; transform: translateY(-1px); }
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

    .fp-btn-outline:hover { background: #E8175D; color: #fff; transform: translateY(-1px); }
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

    .fp-alert img { width: 15px; height: 15px; flex-shrink: 0; }

    .fp-loader {
        width: 16px; height: 16px;
        border: 2.5px solid rgba(255,255,255,.35);
        border-top-color: #fff;
        border-radius: 50%;
        animation: fpSpin .7s linear infinite;
        display: inline-block;
    }

    .fp-success-wrap { text-align: center; padding: .8rem 0 .4rem; }

    .fp-success-icon {
        width: 64px; height: 64px;
        background: linear-gradient(135deg,#E8175D,#FF2D78);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.3rem;
        box-shadow: 0 10px 32px rgba(232,23,93,.35);
        animation: fpPop .4s cubic-bezier(.22,1,.36,1);
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
        background: linear-gradient(135deg,#E8175D,#FF2D78);
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

    .fp-fd-card-title { font-size: .85rem; font-weight: 700; color: #1a1a2e; margin-bottom: .25rem; }
    .fp-fd-card-desc  { font-size: .78rem; color: #7a5f6e; line-height: 1.6; }

    .fp-fd-steps { display: flex; flex-direction: column; gap: .75rem; margin-bottom: 1.2rem; }

    .fp-fd-step { display: flex; align-items: flex-start; gap: .85rem; }

    .fp-fd-step-num {
        width: 26px; height: 26px;
        flex-shrink: 0;
        border-radius: 50%;
        background: linear-gradient(135deg,#E8175D,#FF2D78);
        color: #fff;
        font-size: .75rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 10px rgba(232,23,93,.3);
        margin-top: .05rem;
    }

    .fp-fd-step-text { font-size: .82rem; color: #7a5f6e; line-height: 1.6; }

    @keyframes fpFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fpSlideUp { from { opacity: 0; transform: translateY(24px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes fpSpin    { to { transform: rotate(360deg); } }
    @keyframes fpPop     { from { transform: scale(.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    @media (max-width: 480px) {
        #fp-sheet { padding: 1.8rem 1.5rem 2rem; border-radius: 18px; }
        .fp-title { font-size: 1.65rem; }
    }
</style>


<div class="left" id="left-panel">

    <div class="ring ring-1"></div>
    <div class="ring ring-2"></div>
    <div class="ring ring-3"></div>

    <div class="dot-grid">
        @for ($i = 0; $i < 30; $i++)
            <span></span>
        @endfor
    </div>

    <div class="student-wrap" id="student-wrap">
        <img src="{{ asset('images/girl.png') }}" alt="Student" class="student-img" id="student-normal">
        <img src="{{ asset('images/girl-cover.png') }}" alt="Student covering eyes" class="student-img student-img-cover" id="student-cover">
    </div>

    <a href="{{ route('home') }}" class="left-logo" style="text-decoration:none;">
        <div class="logo-mark">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </div>
        <div class="logo-text">Dorm<span>Ease</span></div>
    </a>

    <div class="left-body">
        <h1>
            <span class="h1-line h1-line-1">Manage with</span>
            <span class="h1-line h1-line-2">ease &amp;</span>
            <span class="h1-line h1-line-3"><em>confidence.</em></span>
        </h1>
        <p>Keeping up with tenants, rooms, and requests has never been this straightforward. Everything in one place, the way it should be.</p>

        <div class="feature-strip" id="feature-strip">
            <div class="feature-strip-icon" id="feature-icon">
                <img src="{{ asset('icons/bed.png') }}" alt="" id="feature-img">
            </div>
            <div class="feature-strip-text">
                <span id="feature-text"></span><span class="feature-cursor"></span>
            </div>
        </div>
    </div>

    <div class="left-footer">&copy; {{ date('Y') }} DormEase. All rights reserved.</div>

</div>


<div class="right">
    <div class="form-wrap">

        <div class="form-header">
            <div class="eyebrow form-header-eyebrow" id="eyebrow-label">
                <span class="eyebrow-inner" id="eyebrow-text">Admin Portal</span>
            </div>
            <h2 class="form-header-title">
                <span class="title-halo"></span>
                Welcome to<br><em>DormEase</em>
            </h2>
            <p class="form-header-sub">Select your role and sign in with your credentials to continue.</p>
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

        <form method="POST" action="/login" id="login-form">
            @csrf

            <input type="hidden" name="role" id="role-input" value="{{ old('role', 'admin') }}">

            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <img class="input-icon" src="{{ asset('icons/email.png') }}" alt="">
                    <input
                        class="de-input{{ $errors->has('email') ? ' input-error-state' : '' }}"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        maxlength="255"
                        required
                        autofocus
                        oninvalid="this.setCustomValidity('')"
                        oninput="this.setCustomValidity('')"
                    >
                </div>
                <div class="field-error{{ $errors->has('email') ? ' visible' : '' }}" id="email-field-error">
                    <span id="email-error-text">{{ $errors->first('email') }}</span>
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
                        maxlength="128"
                        required
                    >
                    <span class="caps-icon" id="caps-icon">
                        <img src="{{ asset('icons/caps.png') }}" alt="Caps Lock" style="width:15px;height:15px;object-fit:contain;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);">
                    </span>
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
                            style="width:18px;height:18px;"
                        >
                    </button>
                </div>
                <div class="field-error" id="pw-field-error">
                    <span id="pw-error-text"></span>
                </div>
            </div>

            <div class="field-row">
                <label class="remember">
                    <input type="checkbox" name="remember" id="remember-cb" aria-label="Remember me">
                    <div class="toggle-track" role="switch" aria-checked="false" aria-label="Remember me" id="remember-track">
                        <div class="toggle-knob"></div>
                    </div>
                    <span class="remember-label">Remember me</span>
                </label>
                <a href="#" class="forgot" onclick="event.preventDefault(); openFP()">Forgot password?</a>
            </div>

            <button type="submit" class="de-btn-primary" id="login-btn">
                <span id="login-btn-text">Sign In</span>
                <span class="btn-spinner" id="login-spinner"></span>
            </button>
        </form>

    </div>
</div>


<div id="fp-overlay" style="display:none;" onclick="if(event.target===this)closeFP()">
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
                    <div class="fp-role-icon"><img src="{{ asset('icons/admin.png') }}" alt="Admin"></div>
                    <div>
                        <div class="fp-role-name">Admin</div>
                        <div class="fp-role-desc">Full access account</div>
                    </div>
                    <svg class="fp-arrow" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <button type="button" class="fp-role-btn" onclick="fpSetRole('frontdesk')">
                    <div class="fp-role-icon"><img src="{{ asset('icons/staff.png') }}" alt="Front Desk"></div>
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

        <div id="fp-step-admin" style="display:none;">
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
                <div id="fp-admin-err" class="fp-alert" style="display:none;">
                    <img src="{{ asset('icons/warning.png') }}" alt="Error"><span></span>
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
                    <span id="fp-verify-loader" class="fp-loader" style="display:none;"></span>
                </button>
            </div>

            <div id="fp-admin-pw-step" style="display:none;">
                <p class="fp-sub">Choose a strong new password for your account.</p>
                <div id="fp-pw-err" class="fp-alert" style="display:none;">
                    <img src="{{ asset('icons/warning.png') }}" alt="Error"><span></span>
                </div>
                <div class="fp-field">
                    <label>New Password</label>
                    <div class="fp-input-wrap">
                        <img class="fp-input-icon" src="{{ asset('icons/lock.png') }}" alt="">
                        <input type="password" id="fp-new-pw" class="fp-input" placeholder="Minimum 8 characters" style="padding-right:5rem;">
                        <span class="fp-caps-icon" id="fp-caps-icon" style="display:none;position:absolute;right:2.8rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                            <img src="{{ asset('icons/caps.png') }}" alt="Caps Lock" style="width:15px;height:15px;object-fit:contain;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);">
                        </span>
                        <button type="button" class="fp-eye-btn" onclick="fpTogglePw('fp-new-pw',this)">
                            <img id="fp-eye-new" src="{{ asset('icons/eye.png') }}" alt="Toggle">
                        </button>
                    </div>
                    <div class="fp-strength-bar"><div id="fp-strength-fill"></div></div>
                    <div id="fp-strength-label" class="fp-strength-label"></div>
                    <div class="fp-requirements" id="fp-requirements">
                        <div class="fp-req" id="req-length"><span class="fp-req-dot"></span>At least 8 characters</div>
                        <div class="fp-req" id="req-upper"><span class="fp-req-dot"></span>One uppercase letter</div>
                        <div class="fp-req" id="req-number"><span class="fp-req-dot"></span>One number</div>
                        <div class="fp-req" id="req-special"><span class="fp-req-dot"></span>One special character</div>
                    </div>
                </div>
                <div class="fp-field">
                    <label>Confirm Password</label>
                    <div class="fp-input-wrap">
                        <img class="fp-input-icon" src="{{ asset('icons/lock.png') }}" alt="">
                        <input type="password" id="fp-confirm-pw" class="fp-input" placeholder="Re-enter password" style="padding-right:5rem;">
                        <span class="fp-caps-icon" id="fp-confirm-caps-icon" style="display:none;position:absolute;right:2.8rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                            <img src="{{ asset('icons/caps.png') }}" alt="Caps Lock" style="width:15px;height:15px;object-fit:contain;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);">
                        </span>
                        <button type="button" class="fp-eye-btn" onclick="fpTogglePw('fp-confirm-pw',this)">
                            <img id="fp-eye-confirm" src="{{ asset('icons/eye.png') }}" alt="Toggle">
                        </button>
                    </div>
                </div>
                <button type="button" class="fp-btn-primary" onclick="fpResetAdminPassword()">
                    <span id="fp-reset-txt">Update Password</span>
                    <span id="fp-reset-loader" class="fp-loader" style="display:none;"></span>
                </button>
            </div>

            <div id="fp-admin-done" style="display:none;">
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

        <div id="fp-step-frontdesk" style="display:none;">
            <button type="button" class="fp-back" onclick="fpBack('frontdesk')">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M12 7H2M6 3L2 7l4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
            </button>

            <div class="fp-eyebrow">Staff Recovery</div>
            <h3 class="fp-title">Contact your<br><em>Admin</em></h3>

            <div class="fp-fd-card">
                <div class="fp-fd-icon-wrap"><img src="{{ asset('icons/lock.png') }}" alt=""></div>
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
    var features = [
        { text: 'Room Management',     icon: "{{ asset('icons/bed.png') }}" },
        { text: 'Tenant Records',       icon: "{{ asset('icons/tenants.png') }}" },
        { text: 'Billing & Payments',   icon: "{{ asset('icons/billing.png') }}" },
        { text: 'Announcements',        icon: "{{ asset('icons/announce.png') }}" },
        { text: 'Maintenance Reports',  icon: "{{ asset('icons/maintenance.png') }}" },
    ];
    var fIdx = 0, fCharIdx = 0, fDeleting = false, fPause = 0;
    var fTextEl = document.getElementById('feature-text');
    var fImgEl  = document.getElementById('feature-img');

    function typeFeature() {
        var current = features[fIdx].text;
        if (fPause > 0) { fPause--; setTimeout(typeFeature, 80); return; }
        if (!fDeleting) {
            fTextEl.textContent = current.slice(0, fCharIdx + 1);
            fCharIdx++;
            if (fCharIdx === current.length) { fDeleting = true; fPause = 22; }
            setTimeout(typeFeature, 75);
        } else {
            fTextEl.textContent = current.slice(0, fCharIdx - 1);
            fCharIdx--;
            if (fCharIdx === 0) {
                fDeleting = false;
                fIdx = (fIdx + 1) % features.length;
                fImgEl.src = features[fIdx].icon;
                fPause = 4;
            }
            setTimeout(typeFeature, 38);
        }
    }
    setTimeout(typeFeature, 900);

    var leftPanel  = document.getElementById('left-panel');
    var studentWrap = document.getElementById('student-wrap');

    leftPanel.addEventListener('mousemove', function (e) {
        var rect = leftPanel.getBoundingClientRect();
        var cx   = rect.width  / 2;
        var cy   = rect.height / 2;
        var dx   = (e.clientX - rect.left - cx) / cx;
        var dy   = (e.clientY - rect.top  - cy) / cy;
        studentWrap.style.transform = 'translateX(' + (dx * 14) + 'px) translateY(' + (dy * 8) + 'px)';
    });

    leftPanel.addEventListener('mouseleave', function () {
        studentWrap.style.transform = '';
    });

    (function () {
        var cards = document.querySelectorAll('.role-btn');
        cards.forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var dx = (e.clientX - (rect.left + rect.width / 2)) / (rect.width / 2);
                var dy = (e.clientY - (rect.top + rect.height / 2)) / (rect.height / 2);
                card.style.transform = 'translate(' + (dx * 6) + 'px,' + (dy * 4) + 'px) scale(1.03)';
                card.style.boxShadow = '0 8px 28px rgba(232,23,93,.18)';
            });
            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
                card.style.boxShadow = '';
            });
            card.addEventListener('mousedown', function () { card.style.transform = 'scale(.97)'; });
            card.addEventListener('mouseup', function () { card.style.transform = ''; });
        });
    })();

    (function () {
        var pwInput = document.getElementById('password');
        var normal  = document.getElementById('student-normal');
        var cover   = document.getElementById('student-cover');
        if (!pwInput || !normal || !cover) return;
        pwInput.addEventListener('focus', function () { normal.style.opacity = '0'; cover.style.opacity = '1'; });
        pwInput.addEventListener('blur',  function () { normal.style.opacity = '1'; cover.style.opacity = '0'; });
    })();

    var fpAdminEmail = '';

    function setRole(role, skipAnim) {
        ['admin', 'frontdesk'].forEach(function (r) {
            document.getElementById('role-' + r).classList.toggle('active', r === role);
        });
        document.getElementById('role-input').value = role;
        var textEl  = document.getElementById('eyebrow-text');
        var eyebrow = document.getElementById('eyebrow-label');
        var next    = role === 'admin' ? 'Admin Portal' : 'Staff Portal';
        if (skipAnim) {
            textEl.textContent = next;
            setTimeout(function () { eyebrow.classList.add('line-drawn'); }, 320);
            return;
        }
        eyebrow.classList.remove('line-drawn');
        textEl.classList.remove('entering');
        textEl.classList.add('switching');
        setTimeout(function () {
            textEl.textContent = next;
            textEl.classList.remove('switching');
            textEl.classList.add('entering');
        }, 220);
        setTimeout(function () { eyebrow.classList.add('line-drawn'); }, 280);
    }

    (function () {
        var saved = document.getElementById('role-input').value;
        if (saved) setRole(saved, true);
    })();

    document.querySelectorAll('.role-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var r    = document.createElement('span');
            r.className = 'ripple';
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            r.style.width  = r.style.height = size + 'px';
            r.style.left   = (e.clientX - rect.left - size / 2) + 'px';
            r.style.top    = (e.clientY - rect.top  - size / 2) + 'px';
            btn.appendChild(r);
            setTimeout(function () { r.remove(); }, 500);
        });
    });

    function togglePw() {
        var input = document.getElementById('password');
        var icon  = document.getElementById('pw-eye-icon');
        var show  = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.src   = show ? "{{ asset('icons/eye-off.png') }}" : "{{ asset('icons/eye.png') }}";
    }

    (function () {
        var pwInput  = document.getElementById('password');
        var capsIcon = document.getElementById('caps-icon');

        function checkCaps(e) {
            var caps = e.getModifierState && e.getModifierState('CapsLock');
            capsIcon.classList.toggle('visible', !!caps);
        }

        pwInput.addEventListener('keyup',  checkCaps);
        pwInput.addEventListener('keydown', checkCaps);
        pwInput.addEventListener('focus', function (e) { checkCaps(e); });
        pwInput.addEventListener('blur',  function () { capsIcon.classList.remove('visible'); });
    })();

    var emailInput    = document.getElementById('email');
    var emailFieldErr = document.getElementById('email-field-error');
    var emailErrText  = document.getElementById('email-error-text');

    function isValidEmail(v) {
        return /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(v);
    }

    function showEmailErr(msg) {
        emailErrText.textContent = msg;
        emailFieldErr.classList.add('visible');
        emailInput.style.borderColor = 'var(--hot-pink)';
    }

    function clearEmailErr() {
        emailFieldErr.classList.remove('visible');
        emailInput.style.borderColor = '';
    }

    function showPwErr(msg) {
        document.getElementById('pw-error-text').textContent = msg;
        document.getElementById('pw-field-error').classList.add('visible');
        document.getElementById('password').style.borderColor = 'var(--hot-pink)';
    }

    function clearPwErr() {
        document.getElementById('pw-field-error').classList.remove('visible');
        document.getElementById('password').style.borderColor = '';
    }

    emailInput.addEventListener('input', function () {
        clearEmailErr();
    });

    emailInput.addEventListener('blur', function () {
        var val = this.value.trim();
        if (!val) { clearEmailErr(); return; }
        if (!isValidEmail(val)) showEmailErr('Invalid email format.');
    });

    document.getElementById('password').addEventListener('input', function () {
        clearPwErr();
    });

    @if ($errors->has('email'))
        (function () {
            var inp = document.getElementById('email');
            if (!inp) return;
            inp.classList.add('input-shake');
            inp.addEventListener('animationend', function () {
                inp.classList.remove('input-shake');
            }, { once: true });
        })();
    @endif

    document.getElementById('login-btn').addEventListener('click', function () {
        var form     = document.getElementById('login-form');
        var emailVal = emailInput.value.trim();
        var pwVal    = document.getElementById('password').value;
        var valid    = true;

        clearEmailErr();
        clearPwErr();

        if (!emailVal) {
            showEmailErr('This field is required.');
            valid = false;
        } else if (!isValidEmail(emailVal)) {
            showEmailErr('Invalid email format.');
            valid = false;
        }

        if (!pwVal) {
            showPwErr('This field is required.');
            valid = false;
        }

        if (!valid) return;

        var btn = this;
        btn.disabled = true;
        document.getElementById('login-btn-text').style.display = 'none';
        document.getElementById('login-spinner').style.display  = 'inline-block';

        var timeout = setTimeout(function () {
            btn.disabled = false;
            document.getElementById('login-btn-text').style.display = 'inline';
            document.getElementById('login-spinner').style.display  = 'none';
            showEmailErr('Connection timed out. Try again.');
        }, 12000);

        form.addEventListener('submit', function () { clearTimeout(timeout); }, { once: true });
        form.submit();
    });

    function openFP() {
        document.getElementById('fp-overlay').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        fpResetAll();
        document.addEventListener('keydown', fpKeyHandler);
        setTimeout(function () {
            var first = getFocusable()[0];
            if (first) first.focus();
        }, 50);
    }

    function closeFP() {
        document.getElementById('fp-overlay').style.display = 'none';
        document.body.style.overflow = '';
        document.removeEventListener('keydown', fpKeyHandler);
    }

    function getFocusable() {
        var sheet = document.getElementById('fp-sheet');
        return Array.from(sheet.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
        )).filter(function (el) { return el.offsetParent !== null; });
    }

    function fpKeyHandler(e) {
        if (e.key === 'Escape') { closeFP(); return; }
        if (e.key !== 'Tab') return;
        var focusable = getFocusable();
        if (!focusable.length) return;
        var first = focusable[0];
        var last  = focusable[focusable.length - 1];
        if (e.shiftKey) {
            if (document.activeElement === first) { e.preventDefault(); last.focus(); }
        } else {
            if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
        }
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
        fpAdminEmail     = '';
        fpVerifyInFlight = false;
        fpResetInFlight  = false;
    }

    function fpSetRole(role) {
        document.getElementById('fp-step-role').style.display    = 'none';
        document.getElementById('fp-step-' + role).style.display = '';
    }

    function fpBack(role) {
        document.getElementById('fp-step-' + role).style.display = 'none';
        document.getElementById('fp-step-role').style.display    = '';
    }

    function fpShowErr(id, msg) {
        var el   = document.getElementById(id);
        var span = el.querySelector('span');
        if (span) span.textContent = msg;
        else el.textContent = msg;
        el.style.display = 'flex';
    }

    function fpHideErr(id) { document.getElementById(id).style.display = 'none'; }

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

    document.getElementById('fp-new-pw').addEventListener('input', function () {
        var val    = this.value;
        var score  = fpCheckStrength(val);
        var fill   = document.getElementById('fp-strength-fill');
        var label  = document.getElementById('fp-strength-label');
        var colors = ['#DF0404','#FF8C00','#f0c040','#22c55e'];
        var labels = ['Weak','Fair','Good','Strong'];
        if (!val) {
            fill.style.width  = '0%';
            label.textContent = '';
        } else {
            fill.style.width      = (score * 25) + '%';
            fill.style.background = colors[score - 1] || colors[0];
            label.textContent     = labels[score - 1] || labels[0];
            label.style.color     = colors[score - 1] || colors[0];
        }
        var toggle = function (id, met) { document.getElementById(id).classList.toggle('met', met); };
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

    var fpVerifyInFlight = false;
    function fpVerifyAdmin() {
        if (fpVerifyInFlight) return;
        var email = document.getElementById('fp-admin-email').value.trim();
        fpHideErr('fp-admin-err');
        if (!email) { fpShowErr('fp-admin-err', 'Please enter your email address.'); return; }
        if (!/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(email)) {
            fpShowErr('fp-admin-err', 'Please enter a valid email address.');
            return;
        }
        fpVerifyInFlight = true;
        var txt    = document.getElementById('fp-verify-txt');
        var loader = document.getElementById('fp-verify-loader');
        txt.style.display    = 'none';
        loader.style.display = 'inline-block';
        fetch('/forgot-password/verify', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': fpGetCsrf(), 'Accept': 'application/json' },
            body: JSON.stringify({ email: email })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            fpVerifyInFlight = false;
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
        .catch(function () {
            fpVerifyInFlight = false;
            txt.style.display    = 'inline';
            loader.style.display = 'none';
            fpShowErr('fp-admin-err', 'Something went wrong. Please try again.');
        });
    }

    var fpResetInFlight = false;
    function fpResetAdminPassword() {
        if (fpResetInFlight) return;
        var pw      = document.getElementById('fp-new-pw').value;
        var confirm = document.getElementById('fp-confirm-pw').value;
        fpHideErr('fp-pw-err');
        if (pw.length < 8)           { fpShowErr('fp-pw-err', 'Password must be at least 8 characters.'); return; }
        if (!confirm)                { fpShowErr('fp-pw-err', 'Please confirm your new password.'); return; }
        if (pw !== confirm)          { fpShowErr('fp-pw-err', 'Passwords do not match.'); return; }
        if (fpCheckStrength(pw) < 3) { fpShowErr('fp-pw-err', 'Password must include uppercase, a number, and a special character.'); return; }
        fpResetInFlight = true;
        var txt    = document.getElementById('fp-reset-txt');
        var loader = document.getElementById('fp-reset-loader');
        txt.style.display    = 'none';
        loader.style.display = 'inline-block';
        fetch('/forgot-password/reset', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': fpGetCsrf(), 'Accept': 'application/json' },
            body: JSON.stringify({ password: pw, password_confirmation: confirm })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            fpResetInFlight = false;
            txt.style.display    = 'inline';
            loader.style.display = 'none';
            if (data.success) {
                document.getElementById('fp-admin-pw-step').style.display = 'none';
                document.getElementById('fp-admin-done').style.display    = '';
            } else if (data.same_password) {
                fpShowErr('fp-pw-err', 'This is your current password. Please choose a different one.');
            } else if (data.message && data.message.toLowerCase().includes('session expired')) {
                var count = 3;
                function fpExpiredTick() {
                    fpShowErr('fp-pw-err', 'Session expired. Restarting in ' + count + '...');
                    if (count <= 0) {
                        document.getElementById('fp-admin-pw-step').style.display    = 'none';
                        document.getElementById('fp-admin-email-step').style.display = '';
                        document.getElementById('fp-admin-email').value              = '';
                        fpAdminEmail    = '';
                        fpResetInFlight = false;
                        return;
                    }
                    count--;
                    setTimeout(fpExpiredTick, 1000);
                }
                fpExpiredTick();
            } else {
                fpShowErr('fp-pw-err', data.message || 'Could not update password. Please try again.');
            }
        })
        .catch(function () {
            fpResetInFlight = false;
            txt.style.display    = 'inline';
            loader.style.display = 'none';
            fpShowErr('fp-pw-err', 'Something went wrong. Please try again.');
        });
    }

   (function () {
        var fpNewPw      = document.getElementById('fp-new-pw');
        var fpConfirmPw  = document.getElementById('fp-confirm-pw');
        var fpCapsNew    = document.getElementById('fp-caps-icon');
        var fpCapsConf   = document.getElementById('fp-confirm-caps-icon');

        function checkFpCaps(e, iconEl) {
            var caps = e.getModifierState && e.getModifierState('CapsLock');
            iconEl.style.display = caps ? 'inline-flex' : 'none';
        }

        ['keyup', 'keydown', 'focus'].forEach(function(evt) {
            if (fpNewPw && fpCapsNew) {
                fpNewPw.addEventListener(evt, function(e) { checkFpCaps(e, fpCapsNew); });
            }
            if (fpConfirmPw && fpCapsConf) {
                fpConfirmPw.addEventListener(evt, function(e) { checkFpCaps(e, fpCapsConf); });
            }
        });

        if (fpNewPw && fpCapsNew) {
            fpNewPw.addEventListener('blur', function() { fpCapsNew.style.display = 'none'; });
        }
        if (fpConfirmPw && fpCapsConf) {
            fpConfirmPw.addEventListener('blur', function() { fpCapsConf.style.display = 'none'; });
        }
    })();

    document.getElementById('remember-cb').addEventListener('change', function () {
        document.getElementById('remember-track').setAttribute('aria-checked', this.checked ? 'true' : 'false');
    });
</script>

</body>
</html>