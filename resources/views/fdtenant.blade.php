@extends('fdlayout')

@section('title', 'DormEase: Tenant Directory')
@section('page-title', 'Tenant Directory')

@section('styles')
<style>
.page-body {
    padding: 1.8rem 1.8rem 1.8rem 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
    background: var(--soft-bg);
    box-sizing: border-box;
    min-width: 0;
}

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--black);
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0;
}

.dorm-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bright-pink);
    margin-top: .2rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: var(--white);
    color: var(--hot-pink);
    border: 1.5px solid var(--pink-100);
    font-size: .87rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    white-space: nowrap;
}

.btn-outline:hover {
    border-color: var(--bright-pink);
    color: var(--bright-pink);
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
}

.stat-box {
    border-radius: 14px;
    padding: 1.1rem;
    border: none;
    background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
    transition: transform .2s, box-shadow .2s;
}

.stat-box:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(232,23,93,.25); }

.stat-icon-circle {
    width: 40px; height: 40px; border-radius: 10px;
    background: var(--white);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: .8rem;
}

.stat-icon-circle img {
    width: 22px; height: 22px; object-fit: contain;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}

.stat-num   { font-size: 1.9rem; font-weight: 800; color: var(--white); line-height: 1; letter-spacing: -.03em; }
.stat-label { font-size: .85rem; font-weight: 700; color: rgba(255,255,255,.92); margin-top: .3rem; }
.stat-sub   { font-size: .75rem; color: rgba(255,255,255,.72); margin-top: .15rem; }

.table-card {
    background: var(--white);
    border-radius: 18px;
    border: 1px solid var(--bright-pink);
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,.05), 0 18px 45px rgba(232,23,93,.15);
    box-sizing: border-box;
}

.table-header {
    padding: 1.2rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .8rem;
    background: var(--white);
    border-bottom: 1px solid var(--bright-pink);
}

.table-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0; }
.table-date  { font-size: .78rem; color: var(--bright-pink); margin-top: .1rem; }

.table-controls {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    display: flex;
}

.search-wrap input {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    font-size: .85rem;
    width: 150px;
    outline: none;
    background: var(--white);
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    color: var(--ink);
}

.sort-select {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    font-size: .82rem;
    font-weight: 400;
    background: var(--white);
    color: var(--ink-muted);
    cursor: pointer;
    outline: none;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23E8175D' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .7rem center;
    padding-right: 2rem;
}

.sort-select:focus { box-shadow: 0 0 0 2px rgba(232,23,93,.25); }

.table-wrap { overflow-x: auto; background: var(--white); }

table { width: 100%; border-collapse: collapse; background: var(--white); }

thead tr {
    background: var(--white);
    border-bottom: 1px solid var(--bright-pink);
}

th {
    padding: .75rem 1rem;
    font-size: .75rem;
    font-weight: 600;
    color: var(--bright-pink);
    letter-spacing: .04em;
    text-transform: uppercase;
    white-space: nowrap;
    background: var(--white);
    text-align: left;
}

th.th-center { text-align: center; }

td {
    padding: .85rem 1rem;
    font-size: .875rem;
    border-bottom: 1px solid var(--pink-100);
    color: var(--ink);
    text-align: left;
    vertical-align: middle;
}

td.td-center { text-align: center; }

tbody tr:hover { background: var(--soft-bg); }

.badge {
    display: inline-flex;
    align-items: center;
    padding: .28rem .75rem;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 700;
}

.badge-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-pending  { background: #eef4ff; color: #3b6fd4; border: 1px solid #a8c4f5; }
.badge-inactive { background: #fff0f0; color: #e04867; border: 1px solid var(--pink-200); }
.badge-reserved { background: #fff8e0; color: #9a6200; border: 1px solid #f0c840; }
.badge-moveout  { background: var(--petal); color: var(--hot-pink); border: 1px solid #ff9db0; }

.inside-indicator {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .75rem;
    font-weight: 700;
}

.inside-dot {
    width: 9px; height: 9px;
    border-radius: 50%;
    flex-shrink: 0;
    display: inline-block;
}

.dot-inside  { background: #1f9d69; box-shadow: 0 0 0 3px rgba(31,157,105,.2); animation: pulseGreen 2s infinite; }
.dot-outside { background: #c8c8d4; }

@keyframes pulseGreen {
    0%, 100% { box-shadow: 0 0 0 3px rgba(31,157,105,.2); }
    50%       { box-shadow: 0 0 0 5px rgba(31,157,105,.3); }
}

.btn-timein {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .3rem .7rem; border-radius: 8px;
    background: #e8faf5; color: #1a7a52;
    border: 1.5px solid #8ce0bb;
    font-size: .74rem; font-weight: 700;
    cursor: pointer; transition: .2s; font-family: inherit;
    white-space: nowrap;
}

.btn-timein:hover { background: #1f9d69; color: var(--white); border-color: transparent; }

.btn-timeout {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .3rem .7rem; border-radius: 8px;
    background: #fff0f4; color: #b0163a;
    border: 1.5px solid #ffc2d1;
    font-size: .74rem; font-weight: 700;
    cursor: pointer; transition: .2s; font-family: inherit;
    white-space: nowrap;
}

.btn-timeout:hover { background: #e04867; color: var(--white); border-color: transparent; }

.action-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    flex-wrap: wrap;
}

.act-btn {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid var(--pink-100); background: var(--white);
    cursor: pointer; transition: .2s;
    display: inline-flex; align-items: center; justify-content: center;
}

.act-btn:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 6px 14px rgba(232,23,93,.15);
}

.act-btn img { width: 15px; height: 15px; object-fit: contain; }

.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .9rem 1.2rem;
    flex-wrap: wrap;
    gap: .5rem;
    border-top: 1px solid var(--pink-100);
}

.table-showing { font-size: .8rem; color: #b06080; }

.pagination {
    display: flex;
    align-items: center;
    gap: .3rem;
}

.page-btn {
    min-width: 32px;
    height: 32px;
    padding: 0 .5rem;
    border-radius: 8px;
    border: 1.5px solid var(--pink-100);
    background: var(--white);
    color: var(--hot-pink);
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-btn:hover:not(:disabled) {
    background: var(--gradient-pink);
    color: var(--white);
    border-color: transparent;
}

.page-btn.active {
    background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
    color: var(--white);
    border-color: transparent;
}

.page-btn:disabled { opacity: .4; cursor: default; }

.empty-state { text-align: center; color: #b06080; padding: 2rem 1rem; font-size: .9rem; }

.modal-field {
    display: flex;
    flex-direction: column;
    gap: .35rem;
    margin-bottom: .9rem;
}

.modal-field label {
    font-size: .75rem;
    font-weight: 700;
    color: var(--hot-pink);
    text-transform: uppercase;
    letter-spacing: .04em;
}

.modal-field textarea {
    width: 100%;
    padding: .6rem .9rem;
    border-radius: 10px;
    border: 1.5px solid var(--baby-pink);
    background: var(--blush);
    font-size: .875rem;
    color: var(--ink);
    font-family: var(--ff-body);
    outline: none;
    box-sizing: border-box;
    transition: border-color .2s, background .2s;
    min-height: 100px;
    resize: vertical;
}

.modal-field textarea:focus {
    border-color: var(--bright-pink);
    background: var(--white);
}

.fade-up { animation: fadeIn .45s ease both; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

.d1 { animation-delay: .05s; }
.d2 { animation-delay: .12s; }
.d3 { animation-delay: .2s; }

.tenant-archive-drawer {
    position: fixed;
    top: 0; right: 0; bottom: 0;
    width: min(660px, 100vw);
    background: var(--pink-bg);
    z-index: 500;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    box-shadow: -8px 0 40px rgba(214,51,117,.15);
}

.tenant-archive-drawer.open { transform: translateX(0); }

.tenant-archive-backdrop {
    position: fixed; inset: 0;
    background: rgba(232,23,93,.18);
    backdrop-filter: blur(3px);
    z-index: 499;
    opacity: 0; pointer-events: none;
    transition: opacity .38s ease;
}

.tenant-archive-backdrop.open { opacity: 1; pointer-events: auto; }

.tad-header {
    padding: 1.6rem 1.8rem 1.2rem;
    border-bottom: 1px solid var(--pink-100);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}

.tad-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -.02em;
    line-height: 1.2;
}

.tad-sub {
    font-size: .78rem;
    color: var(--ink-muted);
    margin-top: .25rem;
    font-weight: 500;
}

.tad-close {
    width: 34px; height: 34px;
    border-radius: 8px;
    border: 1px solid var(--pink-100);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: 1rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s, color .2s;
    flex-shrink: 0;
}

.tad-close:hover { background: var(--pink-100); color: var(--hot-pink); }

.tad-tabs {
    display: flex;
    gap: 0;
    padding: 0 1.8rem;
    border-bottom: 1px solid var(--pink-100);
    flex-shrink: 0;
    background: var(--white);
    overflow-x: auto;
}

.tad-tab {
    padding: .85rem 1.1rem;
    font-size: .82rem;
    font-weight: 700;
    color: var(--ink-muted);
    background: none;
    border: none;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1px;
    cursor: pointer;
    transition: color .2s, border-color .2s;
    display: flex;
    align-items: center;
    gap: .45rem;
    letter-spacing: .01em;
    font-family: var(--ff-body);
    white-space: nowrap;
}

.tad-tab:hover { color: var(--hot-pink); }
.tad-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

.tad-tab-count {
    font-size: .68rem;
    font-weight: 800;
    padding: .1rem .45rem;
    border-radius: 99px;
    background: var(--petal);
    color: var(--ink-muted);
    letter-spacing: .02em;
    min-width: 18px;
    text-align: center;
}

.tad-tab.active .tad-tab-count {
    background: var(--bright-pink);
    color: var(--white);
}

.tad-search-bar {
    padding: 1rem 1.8rem .8rem;
    flex-shrink: 0;
}

.tad-search-inner {
    position: relative;
    display: flex;
    align-items: center;
}

.tad-search-inner input {
    width: 100%;
    padding: .55rem .9rem .55rem 2.2rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    background: var(--white);
    color: var(--ink);
    font-size: .83rem;
    font-family: var(--ff-body);
    outline: none;
    transition: border-color .2s, background .2s;
    box-sizing: border-box;
}

.tad-search-inner input::placeholder { color: var(--ink-muted); }
.tad-search-inner input:focus { border-color: var(--bright-pink); background: var(--blush); }

.tad-search-icon {
    position: absolute; left: .75rem;
    width: 13px; height: 13px;
    opacity: .5; pointer-events: none;
}

.tad-list {
    flex: 1;
    overflow-y: auto;
    padding: 0 1.8rem 1.8rem;
    display: flex;
    flex-direction: column;
    gap: .75rem;
}

.tad-list::-webkit-scrollbar { width: 4px; }
.tad-list::-webkit-scrollbar-track { background: transparent; }
.tad-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

.tad-card {
    background: var(--white);
    border: 1px solid var(--pink-100);
    border-radius: 14px;
    padding: 1rem 1.1rem;
    transition: background .2s, border-color .2s;
    animation: tadSlideIn .3s ease both;
}

@keyframes tadSlideIn {
    from { opacity: 0; transform: translateX(12px); }
    to   { opacity: 1; transform: translateX(0); }
}

.tad-card:hover { background: var(--blush); border-color: var(--bright-pink); }

.tad-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .8rem;
    margin-bottom: .5rem;
}

.tad-card-id {
    font-size: .75rem;
    font-weight: 800;
    color: var(--bright-pink);
    letter-spacing: .02em;
    font-family: monospace;
}

.tad-card-time {
    font-size: .7rem;
    color: var(--ink-muted);
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
}

.tad-card-name {
    font-size: .9rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.3;
}

.tad-card-email {
    font-size: .73rem;
    color: var(--ink-muted);
    margin-top: .1rem;
}

.tad-card-meta {
    display: flex;
    align-items: center;
    gap: .45rem;
    margin-top: .6rem;
    flex-wrap: wrap;
}

.tad-pill {
    font-size: .68rem;
    font-weight: 700;
    padding: .18rem .55rem;
    border-radius: 99px;
    letter-spacing: .03em;
    text-transform: uppercase;
}

.tad-pill-room     { background: var(--petal);   color: var(--ink-muted); border: 1px solid var(--pink-100); }
.tad-pill-stay     { background: var(--pink-100); color: var(--hot-pink);  border: 1px solid var(--pink-200); }
.tad-pill-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.tad-pill-pending  { background: #fff9e6; color: #c8960c; border: 1px solid #f0c040; }
.tad-pill-moveout  { background: var(--petal);  color: var(--hot-pink);  border: 1px solid var(--pink-200); }
.tad-pill-inactive { background: var(--blush);  color: var(--ink-muted); border: 1px solid var(--pink-100); }
.tad-pill-reserved { background: #eef4ff; color: #3b6fd4; border: 1px solid #a8c4f5; }
.tad-pill-timein   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.tad-pill-timeout  { background: #fff0f4; color: #b0163a; border: 1px solid #ffc2d1; }

.tad-card-archived {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-top: .75rem;
    padding-top: .6rem;
    border-top: 1px solid var(--pink-100);
    font-size: .7rem;
    color: var(--ink-muted);
    font-weight: 500;
}

.tad-card-archived span { color: var(--bright-pink); font-weight: 600; }

.tad-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--ink-muted);
    font-size: .85rem;
}

.tad-empty-icon {
    width: 40px; height: 40px;
    margin: 0 auto .75rem;
    opacity: .3;
    display: block;
}

.tad-footer {
    padding: .9rem 1.8rem;
    border-top: 1px solid var(--pink-100);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    flex-wrap: wrap;
    gap: .5rem;
}

.tad-count-label {
    font-size: .75rem;
    color: var(--ink-muted);
    font-weight: 600;
}

.tad-export-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .75rem;
    font-weight: 700;
    color: var(--bright-pink);
    background: var(--petal);
    border: 1px solid var(--pink-100);
    border-radius: 8px;
    padding: .35rem .85rem;
    cursor: pointer;
    transition: background .2s, color .2s, border-color .2s;
    font-family: var(--ff-body);
}

.tad-export-btn:hover { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.tad-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .7; }

.action-loading-overlay {
    position: fixed; inset: 0; z-index: 1200;
    display: none; align-items: center; justify-content: center;
    background: rgba(255,255,255,.72); backdrop-filter: blur(2px);
}

.action-loading-overlay.open { display: flex; }

.action-loading-box {
    display: flex; align-items: center; flex-direction: column;
    gap: .75rem; padding: 1.25rem 1.6rem;
    border: 1px solid var(--baby-pink); border-radius: 12px;
    background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14);
    color: var(--ink); font-size: .9rem; font-weight: 700;
}

.loading-logo-wrap {
    width: 86px; height: 86px;
    border: 3px solid var(--baby-pink); border-radius: 50%;
    background: var(--gradient-pink);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 10px 24px rgba(232,23,93,.25);
    animation: pulseLogo 1s ease-in-out infinite; flex-shrink: 0;
}

.loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }

.is-loading { opacity: .75; pointer-events: none; }

@keyframes pulseLogo {
    0%, 100% { transform: scale(1);     box-shadow: 0 10px 24px rgba(232,23,93,.25); }
    50%       { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); }
}

.export-dropdown { position: relative; display: inline-flex; }

.export-menu {
    display: none;
    background: var(--white);
    border: 1.5px solid var(--pink-100);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(232,23,93,.15);
    min-width: 160px;
    overflow: hidden;
}

.export-menu.open { display: block; }

.export-menu button {
    display: block; width: 100%;
    padding: .65rem 1rem;
    background: none; border: none;
    text-align: left; font-size: .84rem; font-weight: 600;
    color: var(--ink); cursor: pointer; transition: background .15s;
    font-family: var(--ff-body);
}

.export-menu button:hover { background: var(--petal); color: var(--hot-pink); }

.log-card {
    background: var(--white);
    border: 1px solid var(--pink-100);
    border-radius: 12px;
    padding: .75rem 1rem;
    display: flex;
    align-items: center;
    gap: .85rem;
    transition: background .2s, border-color .2s;
    animation: tadSlideIn .3s ease both;
}

.log-card:hover { background: var(--blush); border-color: var(--bright-pink); }

.log-action-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.log-action-icon.in  { background: #e8faf5; border: 1.5px solid #8ce0bb; }
.log-action-icon.out { background: #fff0f4; border: 1.5px solid #ffc2d1; }

.log-info { flex: 1; min-width: 0; }
.log-name { font-size: .87rem; font-weight: 700; color: var(--ink); }
.log-meta { font-size: .72rem; color: var(--ink-muted); margin-top: .15rem; }

.log-time-col {
    font-size: .7rem; font-weight: 600;
    color: var(--ink-muted); text-align: right;
    flex-shrink: 0; white-space: nowrap;
}

.td-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(20, 0, 10, .55);
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
    backdrop-filter: blur(4px);
}

.td-modal-card {
    background: var(--white);
    width: 520px;
    max-width: 100%;
    max-height: 92vh;
    border-radius: 24px;
    box-shadow: 0 24px 64px rgba(232,23,93,.2), 0 8px 24px rgba(0,0,0,.12);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: tdModalFade .25s cubic-bezier(.22,1,.36,1);
}

@keyframes tdModalFade {
    from { opacity: 0; transform: translateY(16px) scale(.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

.td-modal-hero {
    position: relative;
    padding: 1.6rem 1.8rem 1.4rem;
    background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
    flex-shrink: 0;
}

.td-modal-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Ccircle cx='30' cy='30' r='30'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    pointer-events: none;
}

.td-modal-close {
    position: absolute;
    top: 1rem; right: 1rem;
    width: 30px; height: 30px;
    border-radius: 8px;
    border: 1.5px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15);
    color: var(--white);
    font-size: .95rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    z-index: 1;
    line-height: 1;
}

.td-modal-close:hover { background: rgba(255,255,255,.28); }

.td-modal-name {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--white);
    letter-spacing: -.02em;
    line-height: 1.2;
    position: relative;
    z-index: 1;
}

.td-modal-meta {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-top: .45rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.td-modal-pill {
    font-size: .68rem;
    font-weight: 700;
    padding: .22rem .65rem;
    border-radius: 99px;
    background: rgba(255,255,255,.2);
    color: var(--white);
    border: 1px solid rgba(255,255,255,.3);
    letter-spacing: .03em;
    text-transform: uppercase;
}

.td-modal-pill.pill-status-active   { background: rgba(31,157,105,.30);  border-color: rgba(140,224,187,.50); }
.td-modal-pill.pill-status-pending  { background: rgba(200,150,12,.30);  border-color: rgba(240,192,64,.50); }
.td-modal-pill.pill-status-inactive { background: rgba(224,72,103,.30);  border-color: rgba(255,155,176,.50); }
.td-modal-pill.pill-status-reserved { background: rgba(154,98,0,.25);    border-color: rgba(240,200,64,.50); }
.td-modal-pill.pill-status-moveout  { background: rgba(232,23,93,.18);   border-color: rgba(255,157,176,.40); }

.td-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.4rem 1.8rem 1.6rem;
}

.td-modal-body::-webkit-scrollbar { width: 4px; }
.td-modal-body::-webkit-scrollbar-track { background: transparent; }
.td-modal-body::-webkit-scrollbar-thumb { background: var(--pink-100); border-radius: 99px; }

.td-section-label {
    font-size: .63rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: var(--bright-pink);
    margin: 1.1rem 0 .6rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.td-section-label:first-child { margin-top: 0; }

.td-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, var(--pink-100), transparent);
}

.td-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .55rem .75rem;
}

.td-info-item {
    background: #fff5f9;
    border: 1px solid #fce4ef;
    border-radius: 11px;
    padding: .65rem .9rem;
    transition: background .15s, border-color .15s;
    cursor: default;
}

.td-info-item:hover { background: #ffeef5; border-color: #f9c6dc; }

.td-info-item.full { grid-column: 1 / -1; }

.td-info-label {
    font-size: .62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--hot-pink);
    opacity: .8;
    margin-bottom: .2rem;
}

.td-info-value {
    font-size: .87rem;
    font-weight: 600;
    color: var(--black);
    line-height: 1.35;
}

.td-info-value.empty {
    color: var(--ink-muted);
    font-style: italic;
    font-weight: 400;
    font-size: .82rem;
}

.td-modal-footer {
    padding: .9rem 1.8rem;
    border-top: 1px solid var(--pink-100);
    display: flex;
    justify-content: flex-end;
    flex-shrink: 0;
    background: #fff8fb;
}

.td-modal-close-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .55rem 1.3rem;
    border-radius: 10px;
    background: var(--white);
    color: var(--hot-pink);
    border: 1.5px solid var(--pink-100);
    font-size: .85rem;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
    font-family: var(--ff-body);
}

.td-modal-close-btn:hover {
    border-color: var(--bright-pink);
    background: var(--petal);
}

.quick-panel {
    background: var(--white);
    border-radius: 18px;
    border: 1px solid var(--bright-pink);
    box-shadow: 0 10px 20px rgba(0,0,0,.05), 0 18px 45px rgba(232,23,93,.15);
    overflow: hidden;
}

.quick-panel-inner {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: stretch;
    min-height: 88px;
}

.quick-panel-left {
    padding: 1.4rem 1.6rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: .55rem;
    border-right: 1px solid var(--pink-100);
}

.quick-panel-label {
    font-size: .7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: var(--bright-pink);
}

.quick-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.quick-search-icon {
    position: absolute;
    left: 1rem;
    width: 16px; height: 16px;
    opacity: .45;
    pointer-events: none;
    flex-shrink: 0;
}

.quick-search-input {
    width: 100%;
    padding: .7rem 1rem .7rem 2.6rem;
    border-radius: 12px;
    border: 1.5px solid var(--pink-100);
    background: var(--soft-bg);
    font-size: .95rem;
    font-weight: 500;
    color: var(--ink);
    font-family: var(--ff-body);
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    box-sizing: border-box;
}

.quick-search-input::placeholder { color: var(--ink-muted); font-weight: 400; }

.quick-search-input:focus {
    border-color: var(--bright-pink);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(232,23,93,.1);
}

.quick-results {
    display: none;
    flex-direction: column;
    gap: .35rem;
    margin-top: .6rem;
    max-height: 220px;
    overflow-y: auto;
}

.quick-results.open { display: flex; }
.quick-results::-webkit-scrollbar { width: 4px; }
.quick-results::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }

.quick-result-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: .65rem .9rem;
    border-radius: 10px;
    border: 1.5px solid var(--pink-100);
    background: var(--white);
    cursor: pointer;
    transition: border-color .18s, background .18s, box-shadow .18s;
    animation: qriFade .18s ease both;
}

@keyframes qriFade {
    from { opacity: 0; transform: translateY(4px); }
    to   { opacity: 1; transform: translateY(0); }
}

.quick-result-item:hover {
    border-color: var(--bright-pink);
    background: var(--blush);
    box-shadow: 0 4px 14px rgba(232,23,93,.1);
}

.quick-result-item.is-inside {
    border-color: #8ce0bb;
    background: #f2fbf7;
}

.quick-result-item.is-inside:hover {
    border-color: #1f9d69;
    background: #e3f8ef;
    box-shadow: 0 4px 14px rgba(31,157,105,.12);
}

.quick-result-left {
    display: flex;
    align-items: center;
    gap: .65rem;
    min-width: 0;
}

.quick-result-avatar {
    width: 34px; height: 34px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--hot-pink) 0%, var(--bright-pink) 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; font-weight: 800; color: var(--white);
    flex-shrink: 0;
    letter-spacing: -.01em;
}

.quick-result-avatar.avatar-inside {
    background: linear-gradient(135deg, #1f9d69 0%, #2ec082 100%);
}

.quick-result-info { min-width: 0; }

.quick-result-name {
    font-size: .875rem;
    font-weight: 700;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.quick-result-meta {
    font-size: .72rem;
    color: var(--ink-muted);
    margin-top: .1rem;
    white-space: nowrap;
}

.quick-result-right {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-shrink: 0;
}

.quick-result-status {
    font-size: .68rem;
    font-weight: 700;
    padding: .2rem .55rem;
    border-radius: 99px;
    text-transform: uppercase;
    letter-spacing: .03em;
    white-space: nowrap;
}

.qrs-inside  { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.qrs-outside { background: var(--petal); color: var(--ink-muted); border: 1px solid var(--pink-100); }

.quick-action-btn {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .32rem .8rem; border-radius: 8px;
    font-size: .74rem; font-weight: 700;
    cursor: pointer; transition: .18s; font-family: inherit;
    white-space: nowrap; border: 1.5px solid;
}

.qab-in  { background: #e8faf5; color: #1a7a52; border-color: #8ce0bb; }
.qab-in:hover  { background: #1f9d69; color: var(--white); border-color: transparent; }
.qab-out { background: #fff0f4; color: #b0163a; border-color: #ffc2d1; }
.qab-out:hover { background: #e04867; color: var(--white); border-color: transparent; }
.qab-in:disabled, .qab-out:disabled { opacity: .5; cursor: default; pointer-events: none; }

.quick-no-results {
    padding: .9rem;
    text-align: center;
    font-size: .82rem;
    color: var(--ink-muted);
    font-style: italic;
}

.quick-panel-right {
    padding: 1.4rem 1.6rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .3rem;
    min-width: 120px;
    background: linear-gradient(135deg, rgba(232,23,93,.04) 0%, rgba(232,23,93,.08) 100%);
}

.quick-live-num {
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--hot-pink);
    line-height: 1;
    letter-spacing: -.04em;
}

.quick-live-label {
    font-size: .72rem;
    font-weight: 700;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: .06em;
    text-align: center;
}

.quick-live-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #1f9d69;
    margin-top: .25rem;
    animation: pulseGreen 2s infinite;
}

.reserved-collapse-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px; height: 30px;
    border-radius: 8px;
    border: 1.5px solid var(--pink-100);
    background: var(--white);
    color: var(--bright-pink);
    cursor: pointer;
    flex-shrink: 0;
    transition: background .2s, border-color .2s;
}

.reserved-collapse-btn:hover {
    background: var(--petal);
    border-color: var(--bright-pink);
}

.reserved-collapse-btn svg {
    transition: transform .25s cubic-bezier(.4,0,.2,1);
}

@media (max-width: 1100px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .page-body { padding: 1.2rem .85rem 1.2rem 1rem; }
    .td-info-grid { grid-template-columns: 1fr; }
}

@media (max-width: 700px) {
    .tad-header { padding: 1.2rem 1rem .9rem; }
    .tad-list { padding: 0 1rem 1.2rem; }
    .tad-search-bar { padding: .8rem 1rem .6rem; }
    .tad-footer { padding: .75rem 1rem; }
    .tad-tabs { padding: 0 1rem; }
    .tad-tab { padding: .75rem .75rem; font-size: .76rem; }
}

@media (max-width: 600px) {
    .stats-row { grid-template-columns: 1fr 1fr; }
    .table-card { margin: 0; }
    .search-wrap input { width: 140px; }
    .td-modal-card { border-radius: 16px; }
    .td-modal-hero { padding: 1.3rem 1.4rem 1.2rem; }
    .td-modal-body { padding: 1.1rem 1.4rem 1.4rem; }
    .td-modal-footer { padding: .75rem 1.4rem; }
}

.log-ddf-item {
    display: block;
    width: 100%;
    padding: .6rem 1rem;
    background: none;
    border: none;
    text-align: left;
    font-size: .82rem;
    font-weight: 600;
    color: var(--ink);
    cursor: pointer;
    transition: background .15s;
    font-family: var(--ff-body);
    border-bottom: 1px solid var(--pink-100);
}
.log-ddf-item:last-child { border-bottom: none; }
.log-ddf-item:hover { background: var(--blush); color: var(--hot-pink); }
.log-ddf-item.active { background: var(--petal); color: var(--hot-pink); }
.modal-overlay {
    position: fixed; inset: 0; z-index: 800;
    display: none; align-items: center; justify-content: center;
    background: rgba(90,30,56,.38);
    backdrop-filter: blur(4px);
    padding: 1rem;
}
.modal-overlay.open { display: flex; }
.modal {
    background: var(--white);
    border-radius: 20px;
    width: 100%; max-width: 540px;
    box-shadow: 0 24px 60px rgba(232,23,93,.18), 0 4px 16px rgba(0,0,0,.08);
    display: flex; flex-direction: column;
    max-height: 92vh; overflow: hidden;
    animation: modalIn .28s cubic-bezier(.34,1.3,.64,1) both;
}
@keyframes modalIn {
    from { opacity: 0; transform: translateY(18px) scale(.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-header {
    padding: .75rem 1.1rem;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--pink-100); flex-shrink: 0;
}
.modal-title { font-size: 1rem; font-weight: 800; color: var(--ink); }
.modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    border: 1.5px solid var(--pink-100); background: var(--petal);
    color: var(--bright-pink); font-size: .95rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s, color .2s;
}
.modal-close:hover { background: var(--bright-pink); color: var(--white); }
.modal-actions {
    padding: .65rem 1.1rem;
    border-top: 1px solid var(--pink-100);
    display: flex; align-items: center; justify-content: flex-end;
    gap: .55rem; flex-shrink: 0; background: #fffafd;
}
.btn-cancel {
    padding: .55rem 1.2rem; border-radius: 10px;
    border: 1.5px solid var(--pink-100); background: var(--white);
    color: var(--ink-muted); font-size: .875rem; font-weight: 600;
    cursor: pointer; transition: .2s; font-family: inherit;
}
.btn-cancel:hover { border-color: var(--bright-pink); color: var(--hot-pink); background: var(--petal); }
.btn-submit {
    padding: .55rem 1.3rem; border-radius: 10px;
    border: none; background: var(--gradient-pink);
    color: var(--white); font-size: .875rem; font-weight: 700;
    cursor: pointer; transition: .2s; font-family: inherit;
    box-shadow: 0 8px 20px rgba(232,23,93,.25);
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 12px 28px rgba(232,23,93,.35); }
.icon-sm { width: 16px; height: 16px; object-fit: contain; }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div>
            <h1>Tenant Directory</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-outline" onclick="openLogDrawer()">
                <img src="{{ asset('icons/archive.png') }}" class="icon-sm" alt="Log">
                Entry / Exit Log
            </button>
            <button class="btn-outline" onclick="openTenantArchive()">
                <img src="{{ asset('icons/archive.png') }}" class="icon-sm" alt="Archive">
                Archive / History
            </button>
            <div class="export-dropdown" id="export-dropdown-main">
                <button class="btn-outline" onclick="toggleExportDropdown('export-dropdown-main')">
                    <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                    Export
                </button>
                <div class="export-menu" id="export-menu-main">
                    <button onclick="exportTenants(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportTenantsPDF(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" alt="">
            </div>
            <div class="stat-label">Active Tenants</div>
            <div class="stat-num">{{ $activeCount }}</div>
            <div class="stat-sub">Out of {{ $totalTenants }} registered</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" alt="">
            </div>
            <div class="stat-label">Units Occupied</div>
            <div class="stat-num">{{ $activeOccupied }}</div>
            <div class="stat-sub">By active tenants</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" alt="">
            </div>
            <div class="stat-label">Vacant Units</div>
            <div class="stat-num">{{ $totalUnits - $activeOccupied }}</div>
            <div class="stat-sub">Out of {{ $totalUnits }} total units</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" alt="">
            </div>
            <div class="stat-label">Inside Now</div>
            <div class="stat-num" id="stat-inside-count">{{ $insideCount }}</div>
            <div class="stat-sub">Currently in building</div>
        </div>
    </div>

    <div class="quick-panel fade-up d3">
        <div class="quick-panel-inner">
            <div class="quick-panel-left">
                <div class="quick-panel-label">Quick Time In / Out</div>
                <div class="quick-search-wrap">
                    <img src="{{ asset('icons/search.png') }}" class="quick-search-icon" alt="">
                    <input
                        type="text"
                        id="quick-search-input"
                        class="quick-search-input"
                        placeholder="Type a tenant name or room number..."
                        oninput="runQuickSearch()"
                        autocomplete="off"
                    >
                </div>
                <div class="quick-results" id="quick-results"></div>
            </div>
            <div class="quick-panel-right">
                <div class="quick-live-num" id="quick-live-num">{{ $insideCount }}</div>
                <div class="quick-live-label">Inside Now</div>
                <div class="quick-live-dot"></div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up" style="animation-delay:.28s;">
        <div class="table-header">
            <div>
                <div class="table-title">All Tenants</div>
                <div class="table-date" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
                </div>
                <select class="sort-select" id="sort-select" onchange="applyFilters()">
                    <option value="newest">Sort by: Newest</option>
                    <option value="oldest">Sort by: Oldest</option>
                    <option value="floor">Sort by: Floor</option>
                    <option value="name">Sort by: Name</option>
                    <option value="room">Sort by: Room</option>
                </select>
                <select class="sort-select" id="floor-filter" onchange="applyFilters()">
                    <option value="">All Floors</option>
                    @for($i = 2; $i <= 5; $i++)
                        <option value="{{ $i }}">Floor {{ $i }}</option>
                    @endfor
                </select>
                <select class="sort-select" id="status-filter" onchange="applyFilters()">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                </select>
                <select class="sort-select" id="inside-filter" onchange="applyFilters()">
                    <option value="">All Locations</option>
                    <option value="inside">Inside</option>
                    <option value="outside">Outside</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Floor No.</th>
                        <th>Room No.</th>
                        <th>Contact No.</th>
                        <th class="th-center">Status</th>
                        <th class="th-center">Location</th>
                        <th>Notes</th>
                        <th class="th-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tenant-tbody"></tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="table-showing" id="showing-label"></div>
            <div class="pagination" id="pagination"></div>
        </div>
    </div>

    <div class="table-card fade-up" style="animation-delay:.34s;">
        <div class="table-header" style="cursor:pointer;" onclick="toggleReservedTable()">
            <div>
                <div class="table-title">Reserved Tenants</div>
                <div class="table-date" id="reserved-table-date"></div>
            </div>
            <div style="display:flex;align-items:center;gap:.6rem;">
                <div class="table-controls" id="reserved-table-controls" onclick="event.stopPropagation()">
                    <div class="search-wrap">
                        <input type="text" id="reserved-search-input" placeholder="Search..." oninput="applyReservedFilters()">
                    </div>
                    <select class="sort-select" id="reserved-sort-select" onchange="applyReservedFilters()">
                        <option value="newest">Sort by: Newest</option>
                        <option value="oldest">Sort by: Oldest</option>
                        <option value="floor">Sort by: Floor</option>
                        <option value="name">Sort by: Name</option>
                        <option value="room">Sort by: Room</option>
                    </select>
                    <select class="sort-select" id="reserved-floor-filter" onchange="applyReservedFilters()">
                        <option value="">All Floors</option>
                        @for($i = 2; $i <= 5; $i++)
                            <option value="{{ $i }}">Floor {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <button
                    class="reserved-collapse-btn"
                    id="reserved-collapse-btn"
                    onclick="event.stopPropagation(); toggleReservedTable()"
                    title="Collapse / Expand"
                >
                    <svg id="reserved-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
            </div>
        </div>

        <div id="reserved-table-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Tenant Name</th>
                            <th>Floor No.</th>
                            <th>Room No.</th>
                            <th>Contact No.</th>
                            <th class="th-center">Status</th>
                            <th>Notes</th>
                            <th class="th-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="reserved-tenant-tbody"></tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-showing" id="reserved-showing-label"></div>
                <div class="pagination" id="reserved-pagination"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('modals')

<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="tenant-archive-backdrop" id="log-backdrop" onclick="closeLogDrawer()"></div>

<div class="tenant-archive-drawer" id="log-drawer">
    <div class="tad-header">
        <div>
            <div class="tad-title">Entry / Exit Log</div>
            <div class="tad-sub">Real-time record of tenant time-ins and time-outs</div>
        </div>
        <button class="tad-close" onclick="closeLogDrawer()">&#x2715;</button>
    </div>
    <div class="tad-search-bar">
        <div class="tad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="tad-search-icon" alt="">
            <input type="text" id="log-search" placeholder="Search by name, room..." oninput="renderLogDrawer()">
        </div>
    </div>
    <div style="padding: 0 1.8rem .75rem; flex-shrink: 0; border-bottom: 1px solid var(--pink-100); display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;">
        <button class="page-btn active" id="log-filter-all"     onclick="setLogFilter('')">All</button>
        <button class="page-btn"        id="log-filter-timein"  onclick="setLogFilter('time_in')">Time In</button>
        <button class="page-btn"        id="log-filter-timeout" onclick="setLogFilter('time_out')">Time Out</button>
        <div style="position:relative; display:inline-flex; align-items:center;">
            <button id="log-date-dropdown-btn" onclick="toggleLogDateDropdown()" style="display:inline-flex;align-items:center;gap:.45rem;padding:.38rem .85rem;border-radius:99px;border:1.5px solid var(--pink-100);background:var(--white);color:var(--hot-pink);font-size:.78rem;font-weight:700;cursor:pointer;font-family:inherit;transition:border-color .2s,background .2s;white-space:nowrap;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span id="log-date-dropdown-label">All Dates</span>
                <svg id="log-date-dropdown-chevron" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" style="flex-shrink:0;transition:transform .2s;"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="log-date-dropdown-menu" style="display:none;position:absolute;top:calc(100% + 6px);left:0;background:var(--white);border:1.5px solid var(--pink-100);border-radius:12px;box-shadow:0 8px 24px rgba(232,23,93,.13);min-width:150px;overflow:hidden;z-index:600;">
                <button onclick="setLogDateFilter('all')"       class="log-ddf-item active" data-val="all">All Dates</button>
                <button onclick="setLogDateFilter('today')"     class="log-ddf-item"        data-val="today">Today</button>
                <button onclick="setLogDateFilter('yesterday')" class="log-ddf-item"        data-val="yesterday">Yesterday</button>
                <button onclick="setLogDateFilter('week')"      class="log-ddf-item"        data-val="week">This Week</button>
            </div>
        </div>
    </div>
    <div class="tad-list" id="log-list"></div>
    <div class="tad-footer">
        <div class="tad-count-label" id="log-count-label">0 records</div>
        <div class="export-dropdown" id="export-dropdown-log">
            <button class="tad-export-btn" onclick="toggleExportDropdown('export-dropdown-log')">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
            <div class="export-menu" id="export-menu-log">
                <button onclick="exportLog('csv'); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportLog('pdf'); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

<div class="tenant-archive-backdrop" id="tad-backdrop" onclick="closeTenantArchive()"></div>

<div class="tenant-archive-drawer" id="tad-drawer">
    <div class="tad-header">
        <div>
            <div class="tad-title">Archive / History</div>
            <div class="tad-sub">Records of deleted, inactive, and moved-out tenants</div>
        </div>
        <button class="tad-close" onclick="closeTenantArchive()">&#x2715;</button>
    </div>

    <div class="tad-tabs">
        <button class="tad-tab active" id="ttab-deleted"  onclick="switchTenantArchiveTab('deleted')">
            Deleted
            <span class="tad-tab-count" id="tcount-deleted">0</span>
        </button>
        <button class="tad-tab" id="ttab-inactive" onclick="switchTenantArchiveTab('inactive')">
            Inactive
            <span class="tad-tab-count" id="tcount-inactive">0</span>
        </button>
        <button class="tad-tab" id="ttab-moveout"  onclick="switchTenantArchiveTab('move_out')">
            Move Out
            <span class="tad-tab-count" id="tcount-moveout">0</span>
        </button>
    </div>

    <div class="tad-search-bar">
        <div class="tad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="tad-search-icon" alt="">
            <input type="text" id="tad-search" placeholder="Search archived tenants..." oninput="renderTenantArchive()">
        </div>
    </div>

    <div class="tad-list" id="tad-list"></div>

    <div class="tad-footer">
        <div class="tad-count-label" id="tad-count-label">0 records</div>
        <div class="export-dropdown" id="export-dropdown-archive">
            <button class="tad-export-btn" onclick="toggleExportDropdown('export-dropdown-archive')">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
            <div class="export-menu" id="export-menu-archive">
                <button onclick="exportTenantArchive('csv'); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportTenantArchive('pdf'); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

<div class="td-modal" id="view-modal">
    <div class="td-modal-card">
        <div class="td-modal-hero">
            <button class="td-modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
            <div class="td-modal-name" id="td-modal-name">—</div>
            <div class="td-modal-meta" id="td-modal-meta"></div>
        </div>
        <div class="td-modal-body" id="td-modal-body"></div>
        <div class="td-modal-footer">
            <button class="td-modal-close-btn" onclick="closeModal('view-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="notes-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">Add / Edit Note</div>
            <button class="modal-close" onclick="closeModal('notes-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.85rem;color:var(--ink-muted);margin-bottom:1rem;padding:0 1.1rem;">
            Adding note for <strong id="notes-tenant-name" style="color:var(--ink);"></strong>
        </p>
        <div style="padding: 0 1.1rem;">
            <div class="modal-field">
                <label>Note</label>
                <textarea id="notes-input" placeholder="e.g. Expecting visitor this weekend..."></textarea>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('notes-modal')">Cancel</button>
            <button type="button" class="btn-submit" id="notes-save-btn" onclick="submitNote()">Save Note</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const tenants = @json($tenants);

const deletedTenantArchive  = @json($deletedArchive);
const inactiveTenantArchive = @json($inactiveArchive);
const moveoutTenantArchive  = @json($moveoutArchive);

const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
const PER_PAGE  = 8;
let currentPage      = 1;
let filtered         = [];
let tenantArchiveTab = 'deleted';
let currentNoteId    = null;
let logData          = [];
let logFilter        = '';
let logDateFilter    = 'all';
let reservedTableOpen = true;

document.getElementById('table-date').textContent =
    'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

document.getElementById('reserved-table-date').textContent =
    'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

function showActionLoading(message) {
    var overlay = document.getElementById('action-loading');
    document.getElementById('action-loading-text').textContent = message || 'Please wait...';
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
}

function hideActionLoading() {
    var overlay = document.getElementById('action-loading');
    overlay.classList.remove('open');
    overlay.setAttribute('aria-hidden', 'true');
}

function fmtDate(d) {
    if (!d) return '\u2014';
    return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function fmtDateTime(d) {
    if (!d) return '\u2014';
    var dt = new Date(d);
    return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
        + ' ' + dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
}

function fmtDatePlain(d) {
    if (!d) return '\u2014';
    var dt   = new Date(d);
    var date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
    var time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    return date + ' ' + time;
}

function statusBadge(status) {
    var map = {
        active:   '<span class="badge badge-active">Active</span>',
        pending:  '<span class="badge badge-pending">Pending</span>',
        reserved: '<span class="badge badge-reserved">Reserved</span>',
        move_out: '<span class="badge badge-moveout">Move Out</span>',
        inactive: '<span class="badge badge-inactive">Inactive</span>',
    };
    return map[status] || ('<span class="badge badge-inactive">' + status + '</span>');
}

function insideIndicator(isInside) {
    if (isInside) {
        return '<span class="inside-indicator"><span class="inside-dot dot-inside"></span><span style="color:#1f9d69;">Inside</span></span>';
    }
    return '<span class="inside-indicator"><span class="inside-dot dot-outside"></span><span style="color:var(--ink-muted);">Outside</span></span>';
}

function statusPillClass(status) {
    var map = {
        active:   'tad-pill-active',
        pending:  'tad-pill-pending',
        reserved: 'tad-pill-reserved',
        move_out: 'tad-pill-moveout',
        inactive: 'tad-pill-inactive',
    };
    return map[status] || 'tad-pill-inactive';
}

function toggleReservedTable() {
    reservedTableOpen = !reservedTableOpen;
    var body     = document.getElementById('reserved-table-body');
    var chevron  = document.getElementById('reserved-chevron');
    var controls = document.getElementById('reserved-table-controls');
    if (reservedTableOpen) {
        body.style.display     = '';
        controls.style.display = '';
        chevron.style.transform = '';
    } else {
        body.style.display     = 'none';
        controls.style.display = 'none';
        chevron.style.transform = 'rotate(-90deg)';
    }
}

function renderTable() {
    var start    = (currentPage - 1) * PER_PAGE;
    var pageData = filtered.slice(start, start + PER_PAGE);
    var tbody    = document.getElementById('tenant-tbody');

    if (pageData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(function(t) {
            var timeBtnHtml = t.is_inside
                ? '<button class="btn-timeout" onclick="doTimeOut(' + t.tenant_id + ', this)">Time Out</button>'
                : '<button class="btn-timein"  onclick="doTimeIn('  + t.tenant_id + ', this)">Time In</button>';

            return '<tr id="tenant-row-' + t.tenant_id + '">' +
                (function() {
                    var nameCell = t.first_name + ' ' + t.last_name;
                    if (t.estimated_move_in_date) {
                        var today = new Date(); today.setHours(0,0,0,0);
                        var est   = new Date(t.estimated_move_in_date + 'T00:00:00');
                        if (est < today) {
                            var days = Math.floor((today - est) / 86400000);
                            nameCell += ' <span style="font-size:.65rem;font-weight:800;padding:.15rem .45rem;border-radius:99px;background:#fff0f0;color:#e04867;border:1px solid #ffc2d1;vertical-align:middle;">' + days + 'd overdue</span>';
                        }
                    }
                    return '<td style="font-weight:600;">' + nameCell + '</td>';
                })() +
                '<td>' + (t.floor ? 'Floor ' + t.floor : '\u2014') + '</td>' +
                '<td>' + (t.room_number || '\u2014') + '</td>' +
                '<td>' + (t.contact_number || '\u2014') + '</td>' +
                '<td class="td-center">' + statusBadge(t.status) + '</td>' +
                '<td class="td-center" id="inside-cell-' + t.tenant_id + '">' + insideIndicator(t.is_inside) + '</td>' +
                '<td style="color:var(--ink-muted);font-size:.85rem;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + (t.notes || '\u2014') + '</td>' +
                '<td class="td-center"><div class="action-group">' +
                    '<button class="act-btn" title="View Details" onclick=\'viewTenant(' + JSON.stringify(t).replace(/'/g, "&#39;") + ')\'><img src="{{ asset('icons/eye.png') }}" alt="View"></button>' +
                    '<button class="act-btn" title="Add / Edit Note" onclick=\'openNotesModal(' + t.tenant_id + ', "' + t.first_name + ' ' + t.last_name + '", `' + (t.notes || '').replace(/`/g, "'") + '`)\'><img src="{{ asset('icons/edit.png') }}" alt="Note"></button>' +
                    '<span id="timebtn-' + t.tenant_id + '">' + timeBtnHtml + '</span>' +
                '</div></td>' +
            '</tr>';
        }).join('');
    }

    var total = filtered.length;
    var from  = total === 0 ? 0 : start + 1;
    var to    = Math.min(start + PER_PAGE, total);
    document.getElementById('showing-label').textContent = 'Showing data ' + from + ' to ' + to + ' of ' + total + ' entries';

    renderPagination();
}

function renderPagination() {
    var totalPages = Math.ceil(filtered.length / PER_PAGE);
    var pg   = document.getElementById('pagination');
    var html = '<button class="page-btn" onclick="goPage(' + (currentPage - 1) + ')" ' + (currentPage === 1 ? 'disabled' : '') + '>\u2039</button>';

    for (var i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += '<button class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goPage(' + i + ')">' + i + '</button>';
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += '<button class="page-btn" disabled>...</button>';
        }
    }

    html += '<button class="page-btn" onclick="goPage(' + (currentPage + 1) + ')" ' + (currentPage === totalPages || totalPages === 0 ? 'disabled' : '') + '>\u203a</button>';
    pg.innerHTML = html;
}

let reservedFiltered    = [];
let reservedCurrentPage = 1;

function renderReservedTable() {
    var start    = (reservedCurrentPage - 1) * PER_PAGE;
    var pageData = reservedFiltered.slice(start, start + PER_PAGE);
    var tbody    = document.getElementById('reserved-tenant-tbody');

    if (pageData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ink-muted);">No reserved tenants found.</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(function(t) {
            return '<tr id="reserved-tenant-row-' + t.tenant_id + '">' +
                '<td style="font-weight:600;">' + t.first_name + ' ' + t.last_name + '</td>' +
                '<td>' + (t.floor ? 'Floor ' + t.floor : '\u2014') + '</td>' +
                '<td>' + (t.room_number || '\u2014') + '</td>' +
                '<td>' + (t.contact_number || '\u2014') + '</td>' +
                '<td class="td-center">' + statusBadge(t.status) + '</td>' +
                '<td style="color:var(--ink-muted);font-size:.85rem;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + (t.notes || '\u2014') + '</td>' +
                '<td class="td-center"><div class="action-group">' +
                    '<button class="act-btn" title="View Details" onclick=\'viewTenant(' + JSON.stringify(t).replace(/'/g, "&#39;") + ')\'><img src="{{ asset('icons/eye.png') }}" alt="View"></button>' +
                    '<button class="act-btn" title="Add / Edit Note" onclick=\'openNotesModal(' + t.tenant_id + ', "' + t.first_name + ' ' + t.last_name + '", `' + (t.notes || '').replace(/`/g, "'") + '`)\'><img src="{{ asset('icons/edit.png') }}" alt="Note"></button>' +
                '</div></td>' +
            '</tr>';
        }).join('');
    }

    var total = reservedFiltered.length;
    var from  = total === 0 ? 0 : start + 1;
    var to    = Math.min(start + PER_PAGE, total);
    document.getElementById('reserved-showing-label').textContent = 'Showing data ' + from + ' to ' + to + ' of ' + total + ' entries';

    renderReservedPagination();
}

function renderReservedPagination() {
    var totalPages = Math.ceil(reservedFiltered.length / PER_PAGE);
    var pg   = document.getElementById('reserved-pagination');
    var html = '<button class="page-btn" onclick="goReservedPage(' + (reservedCurrentPage - 1) + ')" ' + (reservedCurrentPage === 1 ? 'disabled' : '') + '>\u2039</button>';

    for (var i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= reservedCurrentPage - 1 && i <= reservedCurrentPage + 1)) {
            html += '<button class="page-btn ' + (i === reservedCurrentPage ? 'active' : '') + '" onclick="goReservedPage(' + i + ')">' + i + '</button>';
        } else if (i === reservedCurrentPage - 2 || i === reservedCurrentPage + 2) {
            html += '<button class="page-btn" disabled>...</button>';
        }
    }

    html += '<button class="page-btn" onclick="goReservedPage(' + (reservedCurrentPage + 1) + ')" ' + (reservedCurrentPage === totalPages || totalPages === 0 ? 'disabled' : '') + '>\u203a</button>';
    pg.innerHTML = html;
}

function goReservedPage(p) {
    var totalPages = Math.ceil(reservedFiltered.length / PER_PAGE);
    if (p < 1 || p > totalPages) return;
    reservedCurrentPage = p;
    renderReservedTable();
}

function applyReservedFilters() {
    var q     = document.getElementById('reserved-search-input').value.toLowerCase();
    var sort  = document.getElementById('reserved-sort-select').value;
    var floor = document.getElementById('reserved-floor-filter').value;

    reservedFiltered = tenants.filter(function(t) {
        if (t.status !== 'reserved') return false;
        var matchesSearch =
            (t.first_name + ' ' + t.last_name).toLowerCase().indexOf(q) !== -1 ||
            (t.room_number    || '').toLowerCase().indexOf(q) !== -1 ||
            (t.contact_number || '').toLowerCase().indexOf(q) !== -1 ||
            String(t.floor || '').indexOf(q) !== -1;
        var matchesFloor = floor === '' || String(t.floor) === floor;
        return matchesSearch && matchesFloor;
    });

    if (sort === 'newest') reservedFiltered.sort(function(a, b) { return new Date(b.created_at) - new Date(a.created_at); });
    if (sort === 'oldest') reservedFiltered.sort(function(a, b) { return new Date(a.created_at) - new Date(b.created_at); });
    if (sort === 'name')   reservedFiltered.sort(function(a, b) { return a.first_name.localeCompare(b.first_name); });
    if (sort === 'room')   reservedFiltered.sort(function(a, b) { return (a.room_number || '').localeCompare(b.room_number || ''); });
    if (sort === 'floor')  reservedFiltered.sort(function(a, b) { return parseInt(a.floor || 0) - parseInt(b.floor || 0); });

    reservedCurrentPage = 1;
    renderReservedTable();
}

function goPage(p) {
    var totalPages = Math.ceil(filtered.length / PER_PAGE);
    if (p < 1 || p > totalPages) return;
    currentPage = p;
    renderTable();
}

function applyFilters() {
    var q      = document.getElementById('search-input').value.toLowerCase();
    var sort   = document.getElementById('sort-select').value;
    var floor  = document.getElementById('floor-filter').value;
    var status = document.getElementById('status-filter').value;
    var inside = document.getElementById('inside-filter').value;

    filtered = tenants.filter(function(t) {
        if (t.status === 'inactive' || t.status === 'move_out' || t.status === 'reserved') return false;
        var matchesSearch =
            (t.first_name + ' ' + t.last_name).toLowerCase().indexOf(q) !== -1 ||
            (t.room_number    || '').toLowerCase().indexOf(q) !== -1 ||
            (t.contact_number || '').toLowerCase().indexOf(q) !== -1 ||
            String(t.floor || '').indexOf(q) !== -1;
        var matchesFloor  = floor  === '' || String(t.floor) === floor;
        var matchesStatus = status === '' || t.status === status;
        var matchesInside = inside === '' || (inside === 'inside' ? t.is_inside : !t.is_inside);
        return matchesSearch && matchesFloor && matchesStatus && matchesInside;
    });

    if (sort === 'newest') filtered.sort(function(a, b) { return new Date(b.created_at) - new Date(a.created_at); });
    if (sort === 'oldest') filtered.sort(function(a, b) { return new Date(a.created_at) - new Date(b.created_at); });
    if (sort === 'name')   filtered.sort(function(a, b) { return a.first_name.localeCompare(b.first_name); });
    if (sort === 'room')   filtered.sort(function(a, b) { return (a.room_number || '').localeCompare(b.room_number || ''); });
    if (sort === 'floor')  filtered.sort(function(a, b) { return parseInt(a.floor || 0) - parseInt(b.floor || 0); });

    currentPage = 1;
    renderTable();
}

async function doTimeIn(id, btn) {
    btn.disabled = true;
    showActionLoading('Recording time in...');
    try {
        var res  = await fetch('/tenants/' + id + '/time-in', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Failed.');
        updateTenantInsideState(id, true);
        showToast(data.message, 'success');
    } catch(e) {
        showToast(e.message, 'error');
        btn.disabled = false;
    } finally {
        hideActionLoading();
    }
}

async function doTimeOut(id, btn) {
    btn.disabled = true;
    showActionLoading('Recording time out...');
    try {
        var res  = await fetch('/tenants/' + id + '/time-out', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Failed.');
        updateTenantInsideState(id, false);
        showToast(data.message, 'success');
    } catch(e) {
        showToast(e.message, 'error');
        btn.disabled = false;
    } finally {
        hideActionLoading();
    }
}

function updateTenantInsideState(id, isInside) {
    var t = tenants.find(function(x) { return x.tenant_id === id; });
    if (t) t.is_inside = isInside;

    var cell = document.getElementById('inside-cell-' + id);
    if (cell) cell.innerHTML = insideIndicator(isInside);

    var btnWrap = document.getElementById('timebtn-' + id);
    if (btnWrap) {
        btnWrap.innerHTML = isInside
            ? '<button class="btn-timeout" onclick="doTimeOut(' + id + ', this)">Time Out</button>'
            : '<button class="btn-timein"  onclick="doTimeIn('  + id + ', this)">Time In</button>';
    }

    var insideCount = tenants.filter(function(x) { return x.is_inside; }).length;
    var el = document.getElementById('stat-inside-count');
    if (el) el.textContent = insideCount;
    var ql = document.getElementById('quick-live-num');
    if (ql) ql.textContent = insideCount;
}

function openLogDrawer() {
    document.getElementById('log-drawer').classList.add('open');
    document.getElementById('log-backdrop').classList.add('open');
    fetchLogs();
}

function closeLogDrawer() {
    document.getElementById('log-drawer').classList.remove('open');
    document.getElementById('log-backdrop').classList.remove('open');
}

function setLogFilter(val) {
    logFilter = val;
    document.getElementById('log-filter-all').classList.toggle('active',     val === '');
    document.getElementById('log-filter-timein').classList.toggle('active',  val === 'time_in');
    document.getElementById('log-filter-timeout').classList.toggle('active', val === 'time_out');
    renderLogDrawer();
}

function toggleLogDateDropdown() {
    var menu    = document.getElementById('log-date-dropdown-menu');
    var chevron = document.getElementById('log-date-dropdown-chevron');
    var isOpen  = menu.style.display !== 'none';
    menu.style.display      = isOpen ? 'none' : 'block';
    chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
}

function setLogDateFilter(val) {
    logDateFilter = val;
    var labels = { all: 'All Dates', today: 'Today', yesterday: 'Yesterday', week: 'This Week' };
    document.getElementById('log-date-dropdown-label').textContent = labels[val] || 'All Dates';
    document.getElementById('log-date-dropdown-menu').style.display = 'none';
    document.getElementById('log-date-dropdown-chevron').style.transform = '';
    document.querySelectorAll('.log-ddf-item').forEach(function(b) {
        b.classList.toggle('active', b.dataset.val === val);
    });
    renderLogDrawer();
}

function matchesLogDateFilter(loggedAt) {
    if (logDateFilter === 'all') return true;
    var d         = new Date(loggedAt);
    var now       = new Date();
    var today     = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    var yesterday = new Date(today); yesterday.setDate(today.getDate() - 1);
    var weekStart = new Date(today); weekStart.setDate(today.getDate() - today.getDay());
    if (logDateFilter === 'today')     return d >= today;
    if (logDateFilter === 'yesterday') return d >= yesterday && d < today;
    if (logDateFilter === 'week')      return d >= weekStart;
    return true;
}

async function fetchLogs() {
    document.getElementById('log-list').innerHTML = '<div class="tad-empty">Loading...</div>';
    try {
        var res = await fetch('/tenant-logs', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
        logData = await res.json();
        renderLogDrawer();
    } catch(e) {
        document.getElementById('log-list').innerHTML = '<div class="tad-empty">Failed to load logs.</div>';
    }
}

function renderLogDrawer() {
    var q    = document.getElementById('log-search').value.toLowerCase();
    var data = logData.filter(function(l) {
        var matchFilter = logFilter === '' || l.action === logFilter;
        var matchDate   = matchesLogDateFilter(l.logged_at);
        var matchSearch = !q
            || (l.first_name + ' ' + l.last_name).toLowerCase().indexOf(q) !== -1
            || (l.room_number || '').toLowerCase().indexOf(q) !== -1
            || (l.account_id  || '').toLowerCase().indexOf(q) !== -1;
        return matchFilter && matchDate && matchSearch;
    });

    document.getElementById('log-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');
    var list = document.getElementById('log-list');

    if (data.length === 0) {
        list.innerHTML = '<div class="tad-empty"><img class="tad-empty-icon" src="{{ asset("icons/tenants.png") }}" alt="">No log records found.</div>';
        return;
    }

    var inSvg  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>';
    var outSvg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b0163a" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>';

    var grouped = {};
    var order   = [];
    data.forEach(function(l) {
        var dt  = new Date(l.logged_at);
        var key = dt.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
        if (!grouped[key]) { grouped[key] = []; order.push(key); }
        grouped[key].push(l);
    });

    var today     = new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    var yesterday = new Date(Date.now() - 86400000).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });

    var html = '';
    var globalIdx = 0;
    order.forEach(function(dateKey) {
        var label    = dateKey === today ? 'Today' : dateKey === yesterday ? 'Yesterday' : dateKey;
        var inCount  = grouped[dateKey].filter(function(l) { return l.action === 'time_in'; }).length;
        var outCount = grouped[dateKey].filter(function(l) { return l.action === 'time_out'; }).length;

        html += '<div style="position:sticky;top:0;z-index:10;background:var(--pink-bg);padding:.55rem 0 .4rem;margin-bottom:.3rem;">'
            + '<div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">'
                + '<div style="display:flex;align-items:center;gap:.5rem;">'
                    + '<span style="display:inline-block;width:3px;height:13px;background:var(--gradient-pink);border-radius:2px;flex-shrink:0;"></span>'
                    + '<span style="font-size:.72rem;font-weight:800;color:var(--ink);letter-spacing:-.01em;">' + label + '</span>'
                + '</div>'
                + '<div style="display:flex;align-items:center;gap:.35rem;">'
                    + (inCount  ? '<span style="font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:#e8faf5;color:#1f9d69;border:1px solid #8ce0bb;">' + inCount  + ' in</span>'  : '')
                    + (outCount ? '<span style="font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:#fff0f4;color:#b0163a;border:1px solid #ffc2d1;">' + outCount + ' out</span>' : '')
                + '</div>'
            + '</div>'
        + '</div>';

        grouped[dateKey].forEach(function(l) {
            var isIn      = l.action === 'time_in';
            var roomLabel = (l.floor && l.room_number)
                ? 'Floor ' + l.floor + ' \u00b7 Rm ' + l.room_number
                : (l.room_number ? 'Rm ' + l.room_number : 'No room');
            var timeOnly  = new Date(l.logged_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

            html += '<div class="log-card" style="animation-delay:' + (globalIdx * 0.02) + 's;margin-bottom:.5rem;">'
                + '<div class="log-action-icon ' + (isIn ? 'in' : 'out') + '">' + (isIn ? inSvg : outSvg) + '</div>'
                + '<div class="log-info">'
                    + '<div class="log-name">' + l.first_name + ' ' + l.last_name + '</div>'
                    + '<div class="log-meta">' + roomLabel + ' &nbsp;&middot;&nbsp; '
                        + '<span class="tad-pill ' + (isIn ? 'tad-pill-timein' : 'tad-pill-timeout') + '" style="font-size:.65rem;">' + (isIn ? 'Time In' : 'Time Out') + '</span>'
                    + '</div>'
                + '</div>'
                + '<div class="log-time-col">' + timeOnly + '<br><span style="font-size:.65rem;color:var(--ink-muted);">' + (l.logged_by || '') + '</span></div>'
            + '</div>';
            globalIdx++;
        });
    });

    list.innerHTML = html;
}

function exportLog(format) {
    var q    = document.getElementById('log-search').value.toLowerCase();
    var data = logData.filter(function(l) {
        var matchFilter = logFilter === '' || l.action === logFilter;
        var matchDate   = matchesLogDateFilter(l.logged_at);
        var matchSearch = !q
            || (l.first_name + ' ' + l.last_name).toLowerCase().indexOf(q) !== -1
            || (l.room_number || '').toLowerCase().indexOf(q) !== -1;
        return matchFilter && matchDate && matchSearch;
    });

    if (format === 'pdf') {
        var win         = window.open('', '_blank');
        var actionLabel = { '': 'All', 'time_in': 'Time In', 'time_out': 'Time Out' };
        var dateLabel   = { all: 'All Dates', today: 'Today', yesterday: 'Yesterday', week: 'This Week' };
        var subtitle    = 'Filter: ' + (actionLabel[logFilter] || 'All') + '  \u2022  Date: ' + (dateLabel[logDateFilter] || 'All Dates');
        var rows = data.map(function(l) {
            var isIn = l.action === 'time_in';
            return '<tr>'
                + '<td>' + l.first_name + ' ' + l.last_name + '</td>'
                + '<td>' + (l.account_id || '') + '</td>'
                + '<td>' + (l.floor ? 'Floor ' + l.floor : '') + '</td>'
                + '<td>' + (l.room_number || '') + '</td>'
                + '<td style="color:' + (isIn ? '#1f9d69' : '#b0163a') + ';font-weight:700;">' + (isIn ? 'Time In' : 'Time Out') + '</td>'
                + '<td>' + (l.logged_at ? new Date(l.logged_at).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }) : '') + '</td>'
                + '</tr>';
        }).join('');
        var exportedOn = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        win.document.write('<!DOCTYPE html><html><head><title>Entry / Exit Log</title>'
            + '<style>'
            + 'body{font-family:sans-serif;font-size:12px;padding:24px;color:#1a1a2e}'
            + 'h2{color:#E8175D;margin:0 0 2px;font-size:16px}'
            + '.sub{color:#888;font-size:11px;margin-bottom:4px}'
            + '.meta{color:#b06080;font-size:10px;margin-bottom:16px}'
            + 'table{width:100%;border-collapse:collapse}'
            + 'thead tr{background:#fce8f1}'
            + 'th{padding:8px 10px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#E8175D;letter-spacing:.04em}'
            + 'td{padding:7px 10px;border-bottom:1px solid #fce4ec;font-size:11px}'
            + 'tbody tr:nth-child(even){background:#fff8fb}'
            + '</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<div class="sub">Entry / Exit Log</div>'
            + '<div class="meta">' + subtitle + ' &nbsp;&bull;&nbsp; Exported ' + exportedOn + '</div>'
            + '<table><thead><tr>'
            + '<th>Name</th><th>Account ID</th><th>Floor</th><th>Room</th><th>Action</th><th>Date / Time</th>'
            + '</tr></thead><tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
        return;
    }

    var rows = [['Name', 'Account ID', 'Floor', 'Room', 'Action', 'Logged At']];
    data.forEach(function(l) {
        rows.push([l.first_name + ' ' + l.last_name, l.account_id || '', l.floor || '', l.room_number || '', l.action, l.logged_at || '']);
    });
    var csv = rows.map(function(r) { return r.map(function(v) { return '"' + String(v).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
    var a   = document.createElement('a');
    a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'tenant-entry-exit-log.csv';
    a.click();
}

function infoItem(label, value, full) {
    var isEmpty  = !value || String(value).trim() === '' || value === '\u2014';
    var valClass = isEmpty ? 'td-info-value empty' : 'td-info-value';
    var display  = isEmpty ? 'Not provided' : value;
    return '<div class="td-info-item' + (full ? ' full' : '') + '">'
        + '<div class="td-info-label">' + label + '</div>'
        + '<div class="' + valClass + '">' + display + '</div>'
        + '</div>';
}

function statusPillModalClass(status) {
    var map = {
        active:   'pill-status-active',
        pending:  'pill-status-pending',
        reserved: 'pill-status-reserved',
        inactive: 'pill-status-inactive',
        move_out: 'pill-status-moveout',
    };
    return map[status] || '';
}

function viewTenant(t) {
    document.getElementById('td-modal-name').textContent = t.first_name + ' ' + t.last_name;

    var statusLabel = { active: 'Active', pending: 'Pending', inactive: 'Inactive', move_out: 'Move Out' };
    var metaHtml = '';

    if (t.status) {
        metaHtml += '<span class="td-modal-pill ' + statusPillModalClass(t.status) + '">'
            + (statusLabel[t.status] || t.status)
            + '</span>';
    }
    if (t.floor && t.room_number) {
        metaHtml += '<span class="td-modal-pill">Floor ' + t.floor + ' &bull; Rm ' + t.room_number + '</span>';
    } else if (t.room_number) {
        metaHtml += '<span class="td-modal-pill">Rm ' + t.room_number + '</span>';
    }
    if (t.stay_type) {
        metaHtml += '<span class="td-modal-pill">' + t.stay_type + '</span>';
    }
    metaHtml += '<span class="td-modal-pill" style="' + (t.is_inside ? 'background:rgba(31,157,105,.3);border-color:rgba(140,224,187,.5);' : '') + '">'
        + (t.is_inside ? 'Inside' : 'Outside') + '</span>';

    document.getElementById('td-modal-meta').innerHTML = metaHtml;

    var bodyHtml = '';

    bodyHtml += '<div class="td-section-label">Contact</div>';
    bodyHtml += '<div class="td-info-grid">';
    bodyHtml += infoItem('Contact No.', t.contact_number);
    bodyHtml += infoItem('Stay Type', t.stay_type);
    bodyHtml += '</div>';

    bodyHtml += '<div class="td-section-label">Room Assignment</div>';
    bodyHtml += '<div class="td-info-grid">';
    bodyHtml += infoItem('Floor', t.floor ? 'Floor ' + t.floor : '');
    bodyHtml += infoItem('Room No.', t.room_number);
    bodyHtml += '</div>';

    bodyHtml += '<div class="td-section-label">Stay Period</div>';
    bodyHtml += '<div class="td-info-grid">';
    bodyHtml += infoItem('Move-In Date',  fmtDate(t.move_in_date));
    bodyHtml += infoItem('Move-Out Date', fmtDate(t.move_out_date));
    bodyHtml += '</div>';

    bodyHtml += '<div class="td-section-label">Notes</div>';
    bodyHtml += '<div class="td-info-grid">';
    bodyHtml += infoItem('Note', t.notes, true);
    bodyHtml += '</div>';

    document.getElementById('td-modal-body').innerHTML = bodyHtml;

    document.getElementById('view-modal').style.display = 'flex';
}

function openNotesModal(id, name, currentNote) {
    currentNoteId = id;
    document.getElementById('notes-tenant-name').textContent = name;
    document.getElementById('notes-input').value = currentNote || '';
    openModal('notes-modal');
}

async function submitNote() {
    if (!currentNoteId) return;

    var note = document.getElementById('notes-input').value.trim();
    var btn  = document.getElementById('notes-save-btn');

    btn.disabled    = true;
    btn.textContent = 'Saving...';
    btn.classList.add('is-loading');
    showActionLoading('Saving note...');

    try {
        var res = await fetch('/tenants/' + currentNoteId + '/notes', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ notes: note }),
        });

        if (!res.ok) {
            var err = await res.json().catch(function() { return {}; });
            throw new Error(err.message || 'Failed to save note.');
        }

        var idx = tenants.findIndex(function(t) { return t.tenant_id === currentNoteId; });
        if (idx !== -1) tenants[idx].notes = note;

        var filteredIdx = filtered.findIndex(function(t) { return t.tenant_id === currentNoteId; });
        if (filteredIdx !== -1) filtered[filteredIdx].notes = note;

        renderTable();
        closeModal('notes-modal');
        showToast('Note saved successfully.', 'success');
    } catch(e) {
        showToast(e.message || 'Failed to save note.', 'error');
    } finally {
        hideActionLoading();
        btn.disabled    = false;
        btn.textContent = 'Save Note';
        btn.classList.remove('is-loading');
    }
}

function openTenantArchive() {
    document.getElementById('tad-drawer').classList.add('open');
    document.getElementById('tad-backdrop').classList.add('open');
    document.getElementById('tad-search').value = '';
    document.getElementById('tcount-deleted').textContent  = deletedTenantArchive.length;
    document.getElementById('tcount-inactive').textContent = inactiveTenantArchive.length;
    document.getElementById('tcount-moveout').textContent  = moveoutTenantArchive.length;
    renderTenantArchive();
}

function closeTenantArchive() {
    document.getElementById('tad-drawer').classList.remove('open');
    document.getElementById('tad-backdrop').classList.remove('open');
}

function switchTenantArchiveTab(tab) {
    tenantArchiveTab = tab;
    document.getElementById('ttab-deleted').classList.toggle('active',  tab === 'deleted');
    document.getElementById('ttab-inactive').classList.toggle('active', tab === 'inactive');
    document.getElementById('ttab-moveout').classList.toggle('active',  tab === 'move_out');
    document.getElementById('tad-search').value = '';
    renderTenantArchive();
}

function renderTenantArchive() {
    var q = document.getElementById('tad-search').value.toLowerCase();
    var source;
    if (tenantArchiveTab === 'deleted')  source = deletedTenantArchive;
    if (tenantArchiveTab === 'inactive') source = inactiveTenantArchive;
    if (tenantArchiveTab === 'move_out') source = moveoutTenantArchive;

    var data = source.filter(function(r) {
        return (r.account_id  || '').toLowerCase().indexOf(q) !== -1 ||
               (r.first_name + ' ' + r.last_name).toLowerCase().indexOf(q) !== -1 ||
               (r.email       || '').toLowerCase().indexOf(q) !== -1 ||
               (r.room_number || '').toLowerCase().indexOf(q) !== -1 ||
               (r.stay_type   || '').toLowerCase().indexOf(q) !== -1;
    });

    var list = document.getElementById('tad-list');
    document.getElementById('tad-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');

    if (data.length === 0) {
        var labelMap = { deleted: 'deleted', inactive: 'inactive', move_out: 'move out' };
        list.innerHTML = '<div class="tad-empty"><img class="tad-empty-icon" src="{{ asset("icons/tenants.png") }}" alt="">No ' + labelMap[tenantArchiveTab] + ' records found.</div>';
        return;
    }

    var archiveLabelMap = { deleted: 'Deleted on', inactive: 'Marked inactive on', move_out: 'Moved out on' };
    var archiveLabel    = archiveLabelMap[tenantArchiveTab];

    list.innerHTML = data.map(function(r, i) {
        var roomPill = (r.floor && r.room_number)
            ? '<span class="tad-pill tad-pill-room">' + r.floor + '-' + r.room_number + '</span>'
            : (r.room_number ? '<span class="tad-pill tad-pill-room">' + r.room_number + '</span>' : '');
        var stayPill = r.stay_type ? '<span class="tad-pill tad-pill-stay">' + r.stay_type + '</span>' : '';

        return '<div class="tad-card" style="animation-delay:' + (i * 0.04) + 's;">' +
            '<div class="tad-card-top"><div class="tad-card-id">' + (r.account_id || '\u2014') + '</div><div class="tad-card-time">' + (r.move_in_date ? fmtDate(r.move_in_date) : '\u2014') + '</div></div>' +
            '<div class="tad-card-name">' + r.first_name + ' ' + r.last_name + '</div>' +
            '<div class="tad-card-email">' + (r.email || '\u2014') + '</div>' +
            '<div class="tad-card-meta">' + roomPill + stayPill + '<span class="tad-pill ' + statusPillClass(r.status) + '">' + (r.status || '\u2014') + '</span></div>' +
            '<div class="tad-card-archived">' + archiveLabel + ': <span>' + fmtDatePlain(r.archived_at) + '</span></div>' +
        '</div>';
    }).join('');
}

function exportTenants() {
    var rows = [['Tenant Name', 'Floor No.', 'Room No.', 'Contact No.', 'Status', 'Location', 'Notes']];
    filtered.forEach(function(t) {
        rows.push([
            t.first_name + ' ' + t.last_name,
            t.floor || '',
            t.room_number || '',
            t.contact_number || '',
            t.status || '',
            t.is_inside ? 'Inside' : 'Outside',
            t.notes || '',
        ]);
    });
    var csv  = rows.map(function(r) { return r.map(function(v) { return '"' + String(v).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
    var blob = new Blob([csv], { type: 'text/csv' });
    var a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'tenant-directory.csv';
    a.click();
}

function exportTenantsPDF() {
    var win  = window.open('', '_blank');
    var rows = filtered.map(function(t) {
        return '<tr><td>' + t.first_name + ' ' + t.last_name + '</td><td>' + (t.floor ? 'Floor ' + t.floor : '') + '</td><td>' + (t.room_number || '') + '</td><td>' + (t.contact_number || '') + '</td><td>' + (t.status || '') + '</td><td>' + (t.is_inside ? 'Inside' : 'Outside') + '</td><td>' + (t.notes || '') + '</td></tr>';
    }).join('');
    win.document.write('<!DOCTYPE html><html><head><title>Tenant Directory</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec}</style></head><body><h2>Sanctissimo Rosario Ladies Dormitory</h2><p>Tenant Directory as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p><table><thead><tr><th>Name</th><th>Floor</th><th>Room</th><th>Contact</th><th>Status</th><th>Location</th><th>Notes</th></tr></thead><tbody>' + rows + '</tbody></table></body></html>');
    win.document.close();
    win.print();
}

function exportTenantArchive(format) {
    var source;
    if (tenantArchiveTab === 'deleted')  source = deletedTenantArchive;
    if (tenantArchiveTab === 'inactive') source = inactiveTenantArchive;
    if (tenantArchiveTab === 'move_out') source = moveoutTenantArchive;

    var labelMap = { deleted: 'Deleted On', inactive: 'Marked Inactive On', move_out: 'Moved Out On' };

    if (format === 'pdf') {
        var win      = window.open('', '_blank');
        var tabLabel = { deleted: 'Deleted', inactive: 'Inactive', move_out: 'Move Out' };
        var rows     = source.map(function(r) {
            return '<tr><td>' + (r.account_id || '') + '</td><td>' + r.first_name + ' ' + r.last_name + '</td><td>' + (r.email || '') + '</td><td>' + (r.floor && r.room_number ? r.floor + '-' + r.room_number : (r.room_number || '')) + '</td><td>' + (r.stay_type || '') + '</td><td>' + (r.status || '') + '</td><td>' + (r.archived_at || '') + '</td></tr>';
        }).join('');
        win.document.write('<!DOCTYPE html><html><head><title>Archive - ' + tabLabel[tenantArchiveTab] + '</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec}</style></head><body><h2>Tenant Archive - ' + tabLabel[tenantArchiveTab] + '</h2><p>Sanctissimo Rosario Ladies Dormitory - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p><table><thead><tr><th>Account ID</th><th>Name</th><th>Email</th><th>Room</th><th>Stay Type</th><th>Status</th><th>' + labelMap[tenantArchiveTab] + '</th></tr></thead><tbody>' + rows + '</tbody></table></body></html>');
        win.document.close();
        win.print();
        return;
    }

    var rows = [['Account ID', 'First Name', 'Last Name', 'Email', 'Contact', 'Floor', 'Room', 'Stay Type', 'Move-In', 'Move-Out', 'Status', labelMap[tenantArchiveTab]]];
    source.forEach(function(r) {
        rows.push([r.account_id || '', r.first_name, r.last_name, r.email || '', r.contact_number || '', r.floor || '', r.room_number || '', r.stay_type || '', r.move_in_date || '', r.move_out_date || '', r.status || '', r.archived_at || '']);
    });

    var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
    var a   = document.createElement('a');
    a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'tenants_' + tenantArchiveTab + '_archive.csv';
    a.click();
}

function getMenuForDropdown(id) {
    return Array.from(document.querySelectorAll('.export-menu')).find(function(m) {
        return m._sourceDropdownId === id;
    }) || document.querySelector('#' + id + ' .export-menu');
}

function positionExportMenu(dropdown) {
    var btn  = dropdown.querySelector('button');
    var menu = getMenuForDropdown(dropdown.id);
    var rect = btn.getBoundingClientRect();

    if (!menu._movedToBody) {
        menu._sourceDropdownId = dropdown.id;
        document.body.appendChild(menu);
        menu._movedToBody = true;
    }

    menu.style.position = 'fixed';
    menu.style.zIndex   = '99999';
    menu.style.right    = (window.innerWidth - rect.right) + 'px';
    menu.style.left     = 'auto';
    menu.style.minWidth = rect.width + 'px';
    menu.style.top      = 'auto';
    menu.style.bottom   = 'auto';

    var menuHeight = menu.offsetHeight || 80;
    var spaceBelow = window.innerHeight - rect.bottom;

    if (spaceBelow >= menuHeight + 6) {
        menu.style.top    = (rect.bottom + 6) + 'px';
        menu.style.bottom = 'auto';
    } else {
        menu.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
        menu.style.top    = 'auto';
    }
}

function toggleExportDropdown(id) {
    var dropdown = document.getElementById(id);
    var menu     = getMenuForDropdown(id);
    var isOpen   = menu.classList.contains('open');
    closeAllExportDropdowns();
    if (!isOpen) {
        positionExportMenu(dropdown);
        getMenuForDropdown(id).classList.add('open');
    }
}

function closeAllExportDropdowns() {
    document.querySelectorAll('.export-menu').forEach(function(m) { m.classList.remove('open'); });
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.export-dropdown')) {
        closeAllExportDropdowns();
    }
    if (!e.target.closest('#log-date-dropdown-btn') && !e.target.closest('#log-date-dropdown-menu')) {
        var m = document.getElementById('log-date-dropdown-menu');
        var c = document.getElementById('log-date-dropdown-chevron');
        if (m) { m.style.display = 'none'; }
        if (c) { c.style.transform = ''; }
    }
});

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) {
    var el = document.getElementById(id);
    if (el.classList.contains('td-modal')) {
        el.style.display = 'none';
    } else {
        el.classList.remove('open');
    }
}

window.addEventListener('click', function(e) {
    var vm = document.getElementById('view-modal');
    if (e.target === vm) vm.style.display = 'none';
});

document.querySelectorAll('.modal-overlay').forEach(function(m) {
    m.addEventListener('click', function(e) { if (e.target === m) m.classList.remove('open'); });
});

@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });
@endif

function runQuickSearch() {
    var q       = document.getElementById('quick-search-input').value.trim().toLowerCase();
    var results = document.getElementById('quick-results');

    if (q.length < 1) {
        results.classList.remove('open');
        results.innerHTML = '';
        return;
    }

    var pool = tenants.filter(function(t) {
        return t.status !== 'inactive' && t.status !== 'move_out';
    });

    var matches = pool.filter(function(t) {
        return (t.first_name + ' ' + t.last_name).toLowerCase().indexOf(q) !== -1
            || (t.room_number || '').toLowerCase().indexOf(q) !== -1;
    }).slice(0, 6);

    if (matches.length === 0) {
        results.innerHTML = '<div class="quick-no-results">No tenants found for &ldquo;' + q + '&rdquo;</div>';
        results.classList.add('open');
        return;
    }

    results.innerHTML = matches.map(function(t, i) {
        var initials  = (t.first_name.charAt(0) + t.last_name.charAt(0)).toUpperCase();
        var roomLabel = (t.floor && t.room_number) ? 'Floor ' + t.floor + ' \u00b7 Rm ' + t.room_number : (t.room_number ? 'Rm ' + t.room_number : 'No room assigned');
        var isInside  = !!t.is_inside;
        var actionBtn = isInside
            ? '<button class="quick-action-btn qab-out" onclick="quickTimeOut(' + t.tenant_id + ', this)" style="animation-delay:' + (i * 0.04) + 's;">Time Out</button>'
            : '<button class="quick-action-btn qab-in"  onclick="quickTimeIn('  + t.tenant_id + ', this)" style="animation-delay:' + (i * 0.04) + 's;">Time In</button>';

        return '<div class="quick-result-item ' + (isInside ? 'is-inside' : '') + '" style="animation-delay:' + (i * 0.04) + 's;">'
            + '<div class="quick-result-left">'
                + '<div class="quick-result-avatar ' + (isInside ? 'avatar-inside' : '') + '">' + initials + '</div>'
                + '<div class="quick-result-info">'
                    + '<div class="quick-result-name">' + t.first_name + ' ' + t.last_name + '</div>'
                    + '<div class="quick-result-meta">' + roomLabel + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="quick-result-right">'
                + '<span class="quick-result-status ' + (isInside ? 'qrs-inside' : 'qrs-outside') + '">' + (isInside ? 'Inside' : 'Outside') + '</span>'
                + actionBtn
            + '</div>'
        + '</div>';
    }).join('');

    results.classList.add('open');
}

async function quickTimeIn(id, btn) {
    btn.disabled = true;
    showActionLoading('Recording time in...');
    try {
        var res  = await fetch('/tenants/' + id + '/time-in', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Failed.');
        updateTenantInsideState(id, true);
        runQuickSearch();
        showToast(data.message, 'success');
    } catch(e) {
        showToast(e.message, 'error');
        btn.disabled = false;
    } finally {
        hideActionLoading();
    }
}

async function quickTimeOut(id, btn) {
    btn.disabled = true;
    showActionLoading('Recording time out...');
    try {
        var res  = await fetch('/tenants/' + id + '/time-out', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Failed.');
        updateTenantInsideState(id, false);
        runQuickSearch();
        showToast(data.message, 'success');
    } catch(e) {
        showToast(e.message, 'error');
        btn.disabled = false;
    } finally {
        hideActionLoading();
    }
}

document.addEventListener('click', function(e) {
    var panel = document.getElementById('quick-results');
    var input = document.getElementById('quick-search-input');
    if (!panel || !input) return;
    if (panel.contains(e.target) || e.target === input) return;
    panel.classList.remove('open');
});

applyFilters();
applyReservedFilters();
</script>
@endsection