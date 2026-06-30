@extends('layout')
@section('title', 'DormEase: Contact Inquiries')
@section('page-title', 'Contact Inquiries')
@section('styles')
<style>
.ci-page {
    padding: 1.8rem 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    background: var(--soft-bg, #fdf6f9);
    box-sizing: border-box;
}
.ci-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
.ci-page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0;
}
.ci-page-header .dorm-name {
    font-size: .95rem;
    font-weight: 600;
    color: var(--bright-pink);
    margin-top: .2rem;
}
.ci-header-actions {
    display: flex;
    align-items: center;
    gap: .7rem;
    flex-wrap: wrap;
}
.btn-ci-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: #fff;
    color: var(--hot-pink);
    border: 1.5px solid var(--baby-pink);
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
    font-family: var(--ff-body);
    white-space: nowrap;
}
.btn-ci-outline:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 4px 14px rgba(232,23,93,.12);
}
.btn-ci-outline svg { width: 14px; height: 14px; }
.ci-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
}
.ci-stat-card {
    background: var(--gradient-pink);
    border-radius: 18px;
    border: none;
    box-shadow: 0 8px 18px rgba(0,0,0,.05), 0 18px 40px rgba(232,23,93,.25);
    padding: 1.4rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    box-sizing: border-box;
    min-width: 0;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    cursor: default;
}
.ci-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(232,23,93,.38);
}
.ci-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    flex-shrink: 0;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 16px rgba(0,0,0,.15);
}
.ci-stat-icon svg {
    width: 26px;
    height: 26px;
    color: var(--hot-pink);
    flex-shrink: 0;
}
.ci-stat-num   { font-size: 1.7rem; font-weight: 800; color: #fff; line-height: 1; }
.ci-stat-label { font-size: .8rem; color: rgba(247,245,245,.97); margin-bottom: .15rem; font-weight: 700; }
.ci-stat-sub   { font-size: .75rem; color: rgba(255,255,255,.82); font-weight: 600; letter-spacing: .04em; margin-top: .2rem; }
.ci-filter {
    display: grid;
    grid-template-columns: minmax(220px, 1fr) 160px 180px auto;
    gap: .75rem;
    align-items: end;
    background: #fff;
    border: 1.5px solid var(--baby-pink);
    border-radius: 16px;
    padding: 1rem 1.2rem;
    box-shadow: 0 2px 10px rgba(232,23,93,.05);
}
.ci-field label {
    display: block;
    font-size: .72rem;
    font-weight: 800;
    color: var(--ink-muted);
    letter-spacing: .06em;
    text-transform: uppercase;
    margin-bottom: .35rem;
}
.ci-field input,
.ci-field select {
    width: 100%;
    box-sizing: border-box;
    border: 1.5px solid var(--baby-pink);
    border-radius: 10px;
    background: var(--blush);
    color: var(--ink);
    font-family: var(--ff-body);
    font-size: .88rem;
    padding: .65rem .8rem;
    outline: none;
    transition: border-color .2s, background .2s;
}
.ci-field input:focus,
.ci-field select:focus {
    border-color: var(--bright-pink);
    background: #fff;
}
.ci-filter-actions {
    display: flex;
    gap: .5rem;
    align-items: center;
}
.ci-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    min-height: 40px;
    padding: .62rem 1.1rem;
    border: 0;
    border-radius: 10px;
    background: var(--gradient-pink);
    color: #fff;
    font-family: var(--ff-body);
    font-size: .84rem;
    font-weight: 800;
    cursor: pointer;
    white-space: nowrap;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 4px 14px rgba(232,23,93,.28);
}
.ci-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(232,23,93,.38);
}
.ci-btn.secondary {
    background: var(--petal);
    color: var(--hot-pink);
    border: 1.5px solid var(--baby-pink);
    box-shadow: none;
}
.ci-btn.secondary:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 4px 12px rgba(232,23,93,.12);
    transform: translateY(-1px);
}
.ci-btn.danger {
    background: #fff0f0;
    color: #c0392b;
    border: 1.5px solid #f3c4c0;
    box-shadow: none;
}
.ci-btn.danger:hover {
    background: #ffe2e0;
    border-color: #c0392b;
    box-shadow: 0 4px 12px rgba(192,57,43,.15);
    transform: translateY(-1px);
}
.ci-list {
    display: flex;
    flex-direction: column;
    gap: .9rem;
}
.ci-card {
    background: #fff;
    border: 1.5px solid var(--baby-pink);
    border-left: 5px solid var(--baby-pink);
    border-radius: 16px;
    padding: 1.1rem 1.2rem;
    box-shadow: 0 2px 10px rgba(232,23,93,.05);
    transition: border-color .2s, box-shadow .2s, transform .15s;
    cursor: pointer;
}
.ci-card:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 6px 22px rgba(232,23,93,.11);
    transform: translateY(-1px);
}
.ci-card.status-new      { border-left-color: var(--hot-pink); }
.ci-card.status-read     { border-left-color: #f59e0b; }
.ci-card.status-resolved { border-left-color: var(--green, #1f9d69); }
.ci-card-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: .85rem;
}
.ci-sender { min-width: 0; }
.ci-name {
    font-size: 1rem;
    font-weight: 800;
    color: var(--ink);
}
.ci-meta {
    margin-top: .2rem;
    display: flex;
    gap: .6rem;
    flex-wrap: wrap;
    font-size: .78rem;
    color: var(--ink-muted);
}
.ci-meta a { color: var(--hot-pink); text-decoration: none; }
.ci-meta a:hover { text-decoration: underline; }
.ci-badges {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .45rem;
    flex-wrap: wrap;
}
.ci-badge {
    display: inline-flex;
    align-items: center;
    padding: .28rem .65rem;
    border-radius: 999px;
    font-size: .68rem;
    font-weight: 800;
    letter-spacing: .04em;
    text-transform: uppercase;
    background: var(--petal);
    color: var(--hot-pink);
    border: 1px solid var(--baby-pink);
}
.ci-badge.status-new      { background: #fff0f6; color: var(--hot-pink); border-color: var(--baby-pink); }
.ci-badge.status-read     { background: #fff8e6; color: #a15c00; border-color: #f8d78b; }
.ci-badge.status-resolved { background: #effdf6; color: #16835b; border-color: #a6e7d8; }
.ci-message-preview {
    color: var(--ink-muted);
    font-size: .85rem;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    padding: .75rem .9rem;
    border-radius: 10px;
    background: var(--blush);
    border: 1px solid var(--border-pink-mid, #f4c0d0);
}
.ci-card-foot {
    margin-top: .85rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .8rem;
    flex-wrap: wrap;
}
.ci-handler {
    font-size: .78rem;
    color: var(--ink-muted);
}
.ci-foot-actions {
    display: flex;
    gap: .5rem;
    align-items: center;
    flex-wrap: wrap;
}
.ci-view-btn {
    display: inline-flex;
    align-items: center;
    gap: .38rem;
    padding: .45rem .9rem;
    border-radius: 9px;
    border: 1.5px solid var(--baby-pink);
    background: #fff;
    font-size: .78rem;
    font-weight: 700;
    color: var(--hot-pink);
    cursor: pointer;
    transition: .2s;
    font-family: var(--ff-body);
}
.ci-view-btn:hover {
    border-color: var(--bright-pink);
    background: var(--petal);
    transform: translateY(-1px);
}
.ci-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    border: 1.5px solid var(--baby-pink);
    background: #fff;
    color: var(--hot-pink);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
    flex-shrink: 0;
}
.ci-icon-btn svg { width: 15px; height: 15px; }
.ci-icon-btn:hover {
    border-color: var(--bright-pink);
    background: var(--petal);
    transform: translateY(-1px);
}
.ci-icon-btn.danger {
    color: #c0392b;
    border-color: #f3c4c0;
    background: #fff0f0;
}
.ci-icon-btn.danger:hover {
    background: #ffe2e0;
    border-color: #c0392b;
    box-shadow: 0 4px 12px rgba(192,57,43,.15);
}
.ci-status-form {
    display: flex;
    gap: .5rem;
    align-items: center;
    flex-wrap: wrap;
}
.ci-status-form select {
    border: 1.5px solid var(--baby-pink);
    border-radius: 9px;
    background: #fff;
    padding: .46rem .65rem;
    font-family: var(--ff-body);
    font-weight: 700;
    font-size: .82rem;
    color: var(--ink);
    outline: none;
    transition: border-color .2s;
}
.ci-status-form select:focus { border-color: var(--bright-pink); }
.ci-empty {
    background: #fff;
    border: 1.5px dashed var(--baby-pink);
    border-radius: 16px;
    padding: 2.5rem;
    text-align: center;
    color: var(--ink-muted);
    font-weight: 700;
    font-size: .9rem;
}
.ci-pagination { display: flex; justify-content: flex-end; }
.ci-pagination nav { display: flex; gap: .35rem; align-items: center; flex-wrap: wrap; }
.ci-pagination span,
.ci-pagination a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px; height: 34px;
    padding: 0 .65rem;
    border-radius: 9px;
    border: 1.5px solid var(--baby-pink);
    background: #fff;
    color: var(--ink-muted);
    font-size: .8rem;
    font-weight: 800;
    text-decoration: none;
    transition: border-color .2s, background .2s;
}
.ci-pagination a:hover { border-color: var(--bright-pink); background: var(--petal); color: var(--hot-pink); }
.ci-pagination span[aria-current="page"] span {
    border: 0; background: transparent; color: inherit;
    min-width: 0; height: auto; padding: 0;
}
.ci-pagination span[aria-current="page"] {
    background: var(--gradient-pink);
    color: #fff;
    border-color: transparent;
}
#ci-view-modal {
    position: fixed; inset: 0; z-index: 600;
    background: rgba(232,23,93,.15);
    backdrop-filter: blur(3px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .25s ease;
    padding: 1rem;
}
#ci-view-modal.open { opacity: 1; pointer-events: auto; }
.ci-modal-box {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 24px 64px rgba(26,26,46,.22);
    width: min(580px, 100%);
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    transform: translateY(10px) scale(.97);
    transition: transform .25s ease;
    overflow: hidden;
}
#ci-view-modal.open .ci-modal-box { transform: none; }
.ci-modal-header {
    padding: 1.3rem 1.5rem 0;
    border-bottom: 1px solid var(--baby-pink);
    background: #fff;
    flex-shrink: 0;
}
.ci-modal-header-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: 1rem;
}
.ci-modal-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--gradient-pink);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ci-modal-icon svg { width: 17px; height: 17px; color: #fff; }
.ci-modal-title-group { display: flex; align-items: center; gap: .65rem; }
.ci-modal-title { font-size: 1rem; font-weight: 800; color: var(--ink); }
.ci-modal-sub   { font-size: .7rem; color: var(--ink-muted); margin-top: .1rem; }
.ci-modal-close {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1px solid var(--baby-pink);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: .85rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}
.ci-modal-close:hover { background: var(--baby-pink); }
.ci-modal-tabs { display: flex; }
.ci-modal-tab {
    padding: .62rem 1.1rem;
    font-size: .8rem; font-weight: 700;
    color: var(--ink-muted);
    cursor: pointer;
    border: none; background: none;
    border-bottom: 2.5px solid transparent;
    transition: color .18s, border-color .18s;
    display: flex; align-items: center; gap: .38rem;
    font-family: var(--ff-body);
    margin-bottom: -1px;
    white-space: nowrap;
}
.ci-modal-tab:hover { color: var(--hot-pink); }
.ci-modal-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }
.ci-modal-tab svg { width: 13px; height: 13px; opacity: .6; transition: opacity .18s; flex-shrink: 0; }
.ci-modal-tab.active svg { opacity: 1; }
.ci-modal-body {
    flex: 1; overflow-y: auto;
    padding: 1.3rem 1.5rem;
}
.ci-modal-body::-webkit-scrollbar { width: 4px; }
.ci-modal-body::-webkit-scrollbar-thumb { background: var(--baby-pink); border-radius: 99px; }
.ci-modal-panel { display: none; flex-direction: column; gap: .85rem; animation: ciPanelIn .18s ease both; }
.ci-modal-panel.active { display: flex; }
@keyframes ciPanelIn { from { opacity:0; transform: translateY(4px); } to { opacity:1; transform: none; } }
.ci-view-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding: .62rem 0; border-bottom: 1px solid var(--baby-pink);
    font-size: .88rem; gap: 1rem;
}
.ci-view-row:last-child { border-bottom: none; }
.ci-view-label { color: var(--ink-muted); font-weight: 500; flex-shrink: 0; }
.ci-view-val   { font-weight: 600; color: var(--ink); text-align: right; }
.ci-view-val a { color: var(--hot-pink); }
.ci-view-message {
    white-space: pre-wrap;
    font-size: .92rem; color: var(--ink);
    line-height: 1.75;
    padding: 1rem; border-radius: 12px;
    background: var(--blush);
    border: 1px solid var(--border-pink-mid, #f4c0d0);
}
.ci-update-panel { display: flex; flex-direction: column; gap: 1rem; }
.ci-update-label { font-size: .72rem; font-weight: 800; color: var(--ink-muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: .35rem; }
.ci-status-pills { display: flex; gap: .55rem; flex-wrap: wrap; }
.ci-status-pill {
    padding: .42rem 1.1rem; border-radius: 99px;
    border: 1.5px solid var(--baby-pink);
    font-size: .82rem; font-weight: 700;
    color: var(--ink-muted); cursor: pointer;
    transition: .18s; user-select: none; background: #fff;
}
.ci-status-pill:hover { border-color: var(--hot-pink); color: var(--hot-pink); background: var(--petal); }
.ci-status-pill.sel-new      { border-color: var(--hot-pink); color: var(--hot-pink); background: #fff0f6; }
.ci-status-pill.sel-read     { border-color: #f59e0b; color: #a15c00; background: #fff8e6; }
.ci-status-pill.sel-resolved { border-color: #1f9d69; color: #1f9d69; background: #effdf6; }
.ci-note-box {
    width: 100%; box-sizing: border-box;
    border: 1.5px solid var(--baby-pink); border-radius: 10px;
    background: var(--blush); padding: .7rem .85rem;
    font-family: var(--ff-body); font-size: .88rem; color: var(--ink);
    resize: vertical; min-height: 80px; outline: none;
    transition: border-color .2s, background .2s;
}
.ci-note-box:focus { border-color: var(--bright-pink); background: #fff; }
.ci-modal-footer {
    padding: .9rem 1.5rem;
    border-top: 1px solid var(--baby-pink);
    display: flex; align-items: center; justify-content: space-between; gap: .75rem;
    flex-shrink: 0; background: #fff;
}
.ci-modal-footer-left { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
.fade-up { animation: fadeUp .42s ease both; }
.d1 { animation-delay: .05s; }
.d2 { animation-delay: .12s; }
.d3 { animation-delay: .2s;  }
.d4 { animation-delay: .28s; }
@keyframes fadeUp { from { opacity:0; transform: translateY(12px); } to { opacity:1; transform: none; } }
.ci-loading-overlay {
    position: fixed; inset: 0; z-index: 1200;
    display: none; align-items: center; justify-content: center;
    background: rgba(255,255,255,.72); backdrop-filter: blur(2px);
}
.ci-loading-overlay.open { display: flex; }
.ci-loading-box {
    display: flex; align-items: center; flex-direction: column; gap: .75rem;
    padding: 1.25rem 1.6rem;
    border: 1px solid var(--baby-pink); border-radius: 12px;
    background: #fff; box-shadow: 0 12px 32px rgba(26,26,46,.14);
    color: var(--ink); font-size: .9rem; font-weight: 700;
}
.ci-loading-logo {
    width: 56px; height: 56px; border-radius: 50%;
    background: var(--gradient-pink);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(232,23,93,.3);
    animation: pulseLogo 1s ease-in-out infinite;
}
.ci-loading-logo svg { width: 28px; height: 28px; color: #fff; }
@keyframes pulseLogo { 0%,100% { transform: scale(1); } 50% { transform: scale(1.07); } }
.ci-archive-backdrop {
    position: fixed; inset: 0;
    background: rgba(232,23,93,.18);
    backdrop-filter: blur(3px);
    z-index: 499; opacity: 0; pointer-events: none;
    transition: opacity .38s ease;
}
.ci-archive-backdrop.open { opacity: 1; pointer-events: auto; }
.ci-archive-drawer {
    position: fixed;
    top: 0; right: 0; bottom: 0;
    width: min(620px, 100vw);
    background: var(--soft-bg, #fdf6f9);
    z-index: 500;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    box-shadow: -8px 0 40px rgba(214,51,117,.15);
}
.ci-archive-drawer.open { transform: translateX(0); }
.ciad-header {
    padding: 1.4rem 1.6rem 1rem;
    border-bottom: 1px solid var(--baby-pink);
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 1rem; flex-shrink: 0;
}
.ciad-title { font-size: 1.15rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
.ciad-sub   { font-size: .78rem; color: var(--ink-muted); margin-top: .2rem; }
.ciad-close {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: 1px solid var(--baby-pink);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: .95rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}
.ciad-close:hover { background: var(--baby-pink); }
.ciad-search-bar { padding: 1rem 1.6rem .65rem; flex-shrink: 0; }
.ciad-search-inner { position: relative; display: flex; align-items: center; }
.ciad-search-inner input {
    width: 100%;
    padding: .52rem .9rem .52rem 2.1rem;
    border-radius: 10px;
    border: 1px solid var(--baby-pink);
    background: #fff;
    font-size: .82rem;
    font-family: var(--ff-body);
    outline: none;
    box-sizing: border-box;
}
#ci-delete-confirm-modal {
    position: fixed; inset: 0; z-index: 700;
    background: rgba(232,23,93,.15);
    backdrop-filter: blur(3px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .25s ease;
    padding: 1rem;
}
#ci-delete-confirm-modal.open { opacity: 1; pointer-events: auto; }
.ci-confirm-box {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 24px 64px rgba(26,26,46,.22);
    width: min(420px, 100%);
    padding: 1.6rem;
    transform: translateY(10px) scale(.97);
    transition: transform .25s ease;
}
#ci-delete-confirm-modal.open .ci-confirm-box { transform: none; }
.ci-confirm-icon {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: #fff0f0;
    border: 1.5px solid #f3c4c0;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
}
.ci-confirm-icon svg { width: 24px; height: 24px; color: #c0392b; }
.ci-confirm-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--ink);
    text-align: center;
    margin-bottom: .5rem;
}
.ci-confirm-text {
    font-size: .87rem;
    color: var(--ink-muted);
    text-align: center;
    line-height: 1.6;
    margin-bottom: 1.4rem;
}
.ci-confirm-text strong { color: var(--ink); }
.ci-confirm-actions {
    display: flex;
    gap: .6rem;
}
.ci-confirm-actions .ci-btn,
.ci-confirm-actions .ci-btn.secondary {
    flex: 1;
    justify-content: center;
}
.ciad-search-inner input:focus { border-color: var(--bright-pink); background: var(--blush); }
.ciad-search-icon { position: absolute; left: .72rem; width: 13px; height: 13px; opacity: .45; pointer-events: none; }
.ciad-list {
    flex: 1; overflow-y: auto;
    padding: 0 1.6rem 1.6rem;
    display: flex; flex-direction: column; gap: .7rem;
}
.ciad-list::-webkit-scrollbar { width: 4px; }
.ciad-list::-webkit-scrollbar-thumb { background: var(--pink-200, #f4b8d0); border-radius: 99px; }
.ciad-card {
    background: #fff;
    border: 1px solid var(--baby-pink);
    border-radius: 12px;
    padding: .9rem 1rem;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    animation: ciadSlide .3s ease both;
}
@keyframes ciadSlide { from { opacity:0; transform: translateX(10px); } to { opacity:1; transform: none; } }
.ciad-card:hover { border-color: var(--bright-pink); background: var(--blush); }
.ciad-card-top { display: flex; justify-content: space-between; gap: .8rem; margin-bottom: .4rem; }
.ciad-card-id  { font-size: .72rem; font-weight: 800; color: var(--bright-pink); font-family: monospace; }
.ciad-card-time { font-size: .68rem; color: var(--ink-muted); white-space: nowrap; }
.ciad-card-title { font-size: .88rem; font-weight: 700; color: var(--ink); margin-bottom: .18rem; }
.ciad-card-desc { font-size: .74rem; color: var(--ink-muted); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.ciad-card-meta { display: flex; gap: .4rem; margin-top: .55rem; flex-wrap: wrap; }
.ciad-pill { font-size: .66rem; font-weight: 700; padding: .16rem .52rem; border-radius: 99px; text-transform: uppercase; letter-spacing: .03em; }
.ciad-card-deleted {
    font-size: .68rem; color: var(--ink-muted);
    margin-top: .55rem; padding-top: .5rem;
    border-top: 1px solid var(--baby-pink);
}
.ciad-card-deleted span { color: #e04867; font-weight: 700; }
.ciad-empty { text-align: center; padding: 2.5rem 1rem; color: var(--ink-muted); font-size: .84rem; }
.ciad-footer {
    padding: .85rem 1.6rem;
    border-top: 1px solid var(--baby-pink);
    background: #fff;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.ciad-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
.ciad-export-btn {
    display: inline-flex; align-items: center; gap: .38rem;
    font-size: .74rem; font-weight: 700; color: var(--bright-pink);
    background: var(--petal); border: 1px solid var(--baby-pink);
    border-radius: 8px; padding: .32rem .8rem;
    cursor: pointer; transition: background .2s; font-family: var(--ff-body);
}
.ciad-export-btn:hover { background: var(--gradient-pink); color: #fff; border-color: transparent; }
.ciad-export-btn svg { width: 12px; height: 12px; }
#ciadd-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 800;
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
}
#ciadd-backdrop.open { opacity: 1; pointer-events: auto; }
#ciadd-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -48%) scale(.97);
    width: min(560px, calc(100vw - 2rem));
    max-height: 88vh;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 24px 64px rgba(26,26,46,.22);
    z-index: 801;
    display: flex;
    flex-direction: column;
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease, transform .25s ease;
    overflow: hidden;
}
#ciadd-modal.open {
    opacity: 1;
    pointer-events: auto;
    transform: translate(-50%, -50%) scale(1);
}
#ciadd-modal .ciadd-header {
    padding: 1.3rem 1.5rem 0;
    border-bottom: 1px solid var(--baby-pink);
    background: #fff;
    flex-shrink: 0;
}
#ciadd-modal .ciadd-header-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: 1rem;
}
#ciadd-modal .ciadd-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
#ciadd-modal .ciadd-icon svg { width: 16px; height: 16px; color: #888; }
#ciadd-modal .ciadd-title { font-size: 1rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
#ciadd-modal .ciadd-sub { font-size: .7rem; color: var(--ink-muted); font-weight: 500; margin-top: .1rem; }
#ciadd-modal .ciadd-close {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1px solid var(--baby-pink);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: .8rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}
#ciadd-modal .ciadd-close:hover { background: var(--baby-pink); }
#ciadd-modal .ciadd-body {
    padding: 1.3rem 1.5rem;
    overflow-y: auto;
    flex: 1;
}
#ciadd-modal .ciadd-footer {
    padding: .9rem 1.5rem;
    border-top: 1px solid var(--baby-pink);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-shrink: 0;
}
@media (max-width: 1024px) {
    .ci-stats-row { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 960px) {
    .ci-filter { grid-template-columns: 1fr 1fr; }
    .ci-filter-actions { grid-column: 1 / -1; }
}
@media (max-width: 640px) {
    .ci-page { padding: 1.2rem 1rem; }
    .ci-stats-row,
    .ci-filter { grid-template-columns: 1fr; }
    .ci-card-head { flex-direction: column; }
    .ci-badges { justify-content: flex-start; }
    .ci-stat-card { padding: 1rem 1.2rem; gap: .9rem; }
    .ci-stat-icon { width: 44px; height: 44px; }
    .ci-stat-icon svg { width: 20px; height: 20px; }
    .ci-stat-num { font-size: 1.5rem; }
    .ci-modal-tabs { overflow-x: auto; }
}
</style>
@endsection
@section('content')
<div class="ci-page">

    <div class="ci-page-header fade-up d1">
        <div>
            <h1>Contact Inquiries</h1>
            <div class="dorm-name">Messages submitted from the public Contact Us form</div>
        </div>
        <div class="ci-header-actions">
            <button class="btn-ci-outline" onclick="openCiArchive()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                Archive / History
            </button>
        </div>
    </div>

    <div class="ci-stats-row fade-up d2">
        <div class="ci-stat-card">
            <div class="ci-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <div class="ci-stat-label">Total Inquiries</div>
                <div class="ci-stat-num">{{ $stats['total'] }}</div>
                <div class="ci-stat-sub">All Time</div>
            </div>
        </div>
        <div class="ci-stat-card">
            <div class="ci-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <div class="ci-stat-label">New</div>
                <div class="ci-stat-num">{{ $stats['new'] }}</div>
                <div class="ci-stat-sub">Needs Attention</div>
            </div>
        </div>
        <div class="ci-stat-card">
            <div class="ci-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div>
                <div class="ci-stat-label">Read</div>
                <div class="ci-stat-num">{{ $stats['read'] }}</div>
                <div class="ci-stat-sub">In Progress</div>
            </div>
        </div>
        <div class="ci-stat-card">
            <div class="ci-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <div class="ci-stat-label">Resolved</div>
                <div class="ci-stat-num">{{ $stats['resolved'] }}</div>
                <div class="ci-stat-sub">Completed</div>
            </div>
        </div>
    </div>

    <form class="ci-filter fade-up d3" method="GET" action="{{ route('contact-inquiries.index') }}">
        <div class="ci-field">
            <label for="search">Search</label>
            <input id="search" type="search" name="search" value="{{ $search }}" placeholder="Name, email, phone, or message…">
        </div>
        <div class="ci-field">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="all"      {{ $status === 'all' ? 'selected' : '' }}>All</option>
                <option value="new"      {{ $status === 'new' ? 'selected' : '' }}>New</option>
                <option value="read"     {{ $status === 'read' ? 'selected' : '' }}>Read</option>
                <option value="resolved" {{ $status === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div class="ci-field">
            <label for="type">Inquiry Type</label>
            <select id="type" name="type">
                <option value="all"         {{ $type === 'all' ? 'selected' : '' }}>All Types</option>
                <option value="general"     {{ $type === 'general' ? 'selected' : '' }}>General</option>
                <option value="reservation" {{ $type === 'reservation' ? 'selected' : '' }}>Reservation</option>
                <option value="concern"     {{ $type === 'concern' ? 'selected' : '' }}>Concern</option>
                <option value="feedback"    {{ $type === 'feedback' ? 'selected' : '' }}>Feedback</option>
                <option value="maintenance" {{ $type === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>
        <div class="ci-filter-actions">
            <button class="ci-btn" type="submit">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Apply
            </button>
            <a class="ci-btn secondary" href="{{ route('contact-inquiries.index') }}">Reset</a>
        </div>
    </form>

    <div class="ci-list fade-up d4">
        @forelse($inquiries as $inquiry)
            <article class="ci-card status-{{ $inquiry->status }}"
                     onclick="openCiModal({{ $inquiry->getKey() }})"
                     data-id="{{ $inquiry->getKey() }}">
                <div class="ci-card-head">
                    <div class="ci-sender">
                        <div class="ci-name">{{ $inquiry->name }}</div>
                        <div class="ci-meta">
                            <a href="mailto:{{ $inquiry->email }}" onclick="event.stopPropagation()">{{ $inquiry->email }}</a>
                            @if($inquiry->phone)
                                <span>·</span>
                                <span>{{ $inquiry->phone }}</span>
                            @endif
                            <span>·</span>
                            <span>{{ $inquiry->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>
                    <div class="ci-badges">
                        <span class="ci-badge">{{ ucwords(str_replace('_', ' ', $inquiry->inquiry_type)) }}</span>
                        <span class="ci-badge status-{{ $inquiry->status }}">{{ ucfirst($inquiry->status) }}</span>
                    </div>
                </div>
                <div class="ci-message-preview">{{ $inquiry->message }}</div>
                <div class="ci-card-foot">
                    <div class="ci-handler">
                        @if($inquiry->handler)
                            Handled by <strong>{{ $inquiry->handler->first_name }} {{ $inquiry->handler->last_name }}</strong>
                            @if($inquiry->handled_at)
                                · {{ $inquiry->handled_at->format('M j, Y') }}
                            @endif
                        @else
                            <em>Not yet handled</em>
                        @endif
                    </div>
                    <div class="ci-foot-actions" onclick="event.stopPropagation()">
                        <button class="ci-view-btn" onclick="openCiModal({{ $inquiry->getKey() }})">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            View
                        </button>
                        <form class="ci-status-form" method="POST"
                              action="{{ route('contact-inquiries.update-status', $inquiry) }}"
                              onsubmit="showCiLoading()">
                            @csrf
                            @method('PATCH')
                            <select name="status" aria-label="Update status">
                                <option value="new"      {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="read"     {{ $inquiry->status === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="resolved" {{ $inquiry->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            <button class="ci-btn" type="submit" style="min-height:36px;padding:.45rem .9rem;font-size:.8rem;">
                                Update
                            </button>
                        </form>
                        <form method="POST"
                              action="{{ route('contact-inquiries.destroy', $inquiry) }}"
                              onsubmit="return confirmCiDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button class="ci-icon-btn danger" type="submit" title="Delete inquiry" aria-label="Delete inquiry">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="ci-empty">No contact inquiries found.</div>
        @endforelse
    </div>

    @if($inquiries->hasPages())
        <div class="ci-pagination">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>
@endsection
@section('modals')

<div id="ci-view-modal" onclick="if(event.target===this) closeCiModal()">
    <div class="ci-modal-box">

        <div class="ci-modal-header">
            <div class="ci-modal-header-top">
                <div class="ci-modal-title-group">
                    <div class="ci-modal-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div>
                        <div class="ci-modal-title" id="ci-modal-name">Contact Inquiry</div>
                        <div class="ci-modal-sub"  id="ci-modal-sub">View details</div>
                    </div>
                </div>
                <button class="ci-modal-close" onclick="closeCiModal()">&#x2715;</button>
            </div>
            <div class="ci-modal-tabs">
                <button class="ci-modal-tab active" onclick="switchCiTab(0)" id="ci-tab-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Details
                </button>
                <button class="ci-modal-tab" onclick="switchCiTab(1)" id="ci-tab-1">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Message
                </button>
                <button class="ci-modal-tab" onclick="switchCiTab(2)" id="ci-tab-2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Update Status
                </button>
            </div>
        </div>

        <div class="ci-modal-body">

            <div class="ci-modal-panel active" id="ci-panel-0">
                <div class="ci-view-row">
                    <span class="ci-view-label">Name</span>
                    <span class="ci-view-val" id="ci-v-name">—</span>
                </div>
                <div class="ci-view-row">
                    <span class="ci-view-label">Email</span>
                    <span class="ci-view-val"><a id="ci-v-email" href="#">—</a></span>
                </div>
                <div class="ci-view-row" id="ci-v-phone-row">
                    <span class="ci-view-label">Phone</span>
                    <span class="ci-view-val" id="ci-v-phone">—</span>
                </div>
                <div class="ci-view-row">
                    <span class="ci-view-label">Inquiry Type</span>
                    <span class="ci-view-val" id="ci-v-type">—</span>
                </div>
                <div class="ci-view-row">
                    <span class="ci-view-label">Status</span>
                    <span class="ci-view-val" id="ci-v-status">—</span>
                </div>
                <div class="ci-view-row">
                    <span class="ci-view-label">Submitted</span>
                    <span class="ci-view-val" id="ci-v-date">—</span>
                </div>
                <div class="ci-view-row" id="ci-v-handler-row">
                    <span class="ci-view-label">Handled By</span>
                    <span class="ci-view-val" id="ci-v-handler">—</span>
                </div>
            </div>

            <div class="ci-modal-panel" id="ci-panel-1">
                <div class="ci-view-message" id="ci-v-message"></div>
            </div>

            <div class="ci-modal-panel" id="ci-panel-2">
                <form id="ci-update-form" method="POST" onsubmit="showCiLoading()">
                    @csrf
                    @method('PATCH')
                    <div class="ci-update-panel">
                        <div>
                            <div class="ci-update-label">Set Status</div>
                            <div class="ci-status-pills">
                                <span class="ci-status-pill" data-val="new"      onclick="selectCiStatus('new')">New</span>
                                <span class="ci-status-pill" data-val="read"     onclick="selectCiStatus('read')">Read</span>
                                <span class="ci-status-pill" data-val="resolved" onclick="selectCiStatus('resolved')">Resolved</span>
                            </div>
                            <input type="hidden" name="status" id="ci-status-input">
                        </div>
                        <div>
                            <div class="ci-update-label">Internal Note <span style="font-weight:500;text-transform:none;letter-spacing:0;opacity:.7;">(optional)</span></div>
                            <textarea class="ci-note-box" name="note" placeholder="Add a note about how this was handled…"></textarea>
                        </div>
                        <button type="submit" class="ci-btn" style="align-self:flex-end;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Save Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="ci-modal-footer">
            <div class="ci-modal-footer-left" id="ci-modal-footer-label"></div>
            <div style="display:flex;gap:.5rem;">
                <form id="ci-delete-form" method="POST" onsubmit="return confirmCiDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ci-icon-btn danger" title="Delete inquiry" aria-label="Delete inquiry">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                </form>
                <button class="ci-btn secondary" onclick="switchCiTab(2)" style="font-size:.8rem;min-height:36px;padding:.45rem .9rem;">
                    Update Status
                </button>
                <button class="ci-btn" onclick="switchCiTab(1)" style="font-size:.8rem;min-height:36px;padding:.45rem .9rem;">
                    Read Message
                </button>
            </div>
        </div>
    </div>
</div>

<div class="ci-archive-backdrop" id="ciad-backdrop" onclick="closeCiArchive()"></div>

<div class="ci-archive-drawer" id="ciad-drawer">
    <div class="ciad-header">
        <div>
            <div class="ciad-title">Archive / History</div>
            <div class="ciad-sub">Deleted contact inquiries</div>
        </div>
        <button class="ciad-close" onclick="closeCiArchive()">&#x2715;</button>
    </div>
    <div class="ciad-search-bar">
        <div class="ciad-search-inner">
            <svg class="ciad-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="ciad-search" placeholder="Search deleted inquiries..." oninput="renderCiArchive()">
        </div>
    </div>
    <div class="ciad-list" id="ciad-list"></div>
    <div class="ciad-footer">
        <div class="ciad-count-label" id="ciad-count-label">0 records</div>
        <button class="ciad-export-btn" onclick="exportCiArchive()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </button>
    </div>
</div>

<div id="ci-delete-confirm-modal" onclick="if(event.target===this) closeCiDeleteConfirm()">
    <div class="ci-confirm-box">
        <div class="ci-confirm-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <div class="ci-confirm-title">Delete this inquiry?</div>
        <div class="ci-confirm-text">
            Are you sure you want to delete the inquiry from <strong id="ci-confirm-name">this sender</strong>? This action cannot be undone.
        </div>
        <div class="ci-confirm-actions">
            <button class="ci-btn secondary" onclick="closeCiDeleteConfirm()">Cancel</button>
            <button class="ci-btn danger" onclick="confirmCiDeleteProceed()">Delete</button>
        </div>
    </div>
</div>

<div class="ci-loading-overlay" id="ci-loading">
    <div class="ci-loading-box">
        <div class="ci-loading-logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <span>Please wait…</span>
    </div>
</div>
@endsection
@section('scripts')
@php
$ciDataMap = [];
foreach ($inquiries as $i) {
    $pk = $i->getKey();
    $ciDataMap[$pk] = [
        'id'           => $pk,
        'name'         => $i->name,
        'email'        => $i->email,
        'phone'        => $i->phone ?? null,
        'inquiry_type' => $i->inquiry_type,
        'status'       => $i->status,
        'message'      => $i->message,
        'created_at'   => $i->created_at->format('M j, Y g:i A'),
        'handler'      => $i->handler
                            ? ($i->handler->first_name . ' ' . $i->handler->last_name)
                            : null,
        'handled_at'   => $i->handled_at ? $i->handled_at->format('M j, Y g:i A') : null,
        'update_url'   => route('contact-inquiries.update-status', $i),
        'delete_url'   => route('contact-inquiries.destroy', $i),
    ];
}

$ciDeletedMap = [];
foreach (($deletedInquiries ?? collect()) as $d) {
    $ciDeletedMap[] = [
        'id'           => $d->getKey(),
        'name'         => $d->name,
        'email'        => $d->email,
        'phone'        => $d->phone ?? null,
        'inquiry_type' => $d->inquiry_type,
        'status'       => $d->status,
        'message'      => $d->message,
        'created_at'   => optional($d->created_at)->format('M j, Y g:i A'),
        'deleted_at'   => optional($d->deleted_at)->format('M j, Y g:i A'),
        'handler'      => $d->handler
                            ? ($d->handler->first_name . ' ' . $d->handler->last_name)
                            : null,
    ];
}
@endphp
<script>
const ciData          = {!! json_encode($ciDataMap, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
const ciDeletedArchive = {!! json_encode($ciDeletedMap, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

function showCiLoading() {
    document.getElementById('ci-loading').classList.add('open');
}

let _ciPendingDeleteForm = null;

function confirmCiDelete(e) {
    e.preventDefault();
    _ciPendingDeleteForm = e.target;
    const card = _ciPendingDeleteForm.closest('.ci-card');
    const name = card ? card.querySelector('.ci-name')?.textContent : document.getElementById('ci-modal-name')?.textContent;
    document.getElementById('ci-confirm-name').textContent = name || 'this sender';
    document.getElementById('ci-delete-confirm-modal').classList.add('open');
    return false;
}

function closeCiDeleteConfirm() {
    document.getElementById('ci-delete-confirm-modal').classList.remove('open');
    _ciPendingDeleteForm = null;
}

async function confirmCiDeleteProceed() {
    if (!_ciPendingDeleteForm) return;
    const form = _ciPendingDeleteForm;
    closeCiDeleteConfirm();
    showCiLoading();

    try {
        const formData = new FormData(form);
        const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        });

        if (!res.ok) throw new Error('Delete failed');

        const data = await res.json();
        const deletedRecord = data.deleted;

        const id = form.closest('.ci-card')?.dataset.id || (deletedRecord ? deletedRecord.id : null);

        if (id) {
            delete ciData[id];
            const card = document.querySelector('.ci-card[data-id="' + id + '"]');
            if (card) {
                card.style.transition = 'opacity .2s, transform .2s';
                card.style.opacity = '0';
                card.style.transform = 'translateX(8px)';
                setTimeout(() => {
                    card.remove();
                    refreshCiStatsAfterDelete();
                }, 200);
            }
        }

        if (deletedRecord) {
            ciDeletedArchive.unshift(deletedRecord);
        }

        if (document.getElementById('ci-view-modal').classList.contains('open')) {
            closeCiModal();
        }

        document.getElementById('ci-loading').classList.remove('open');
        if (typeof showToast === 'function') showToast('Inquiry deleted successfully.', 'success');

        openCiArchive();
    } catch (err) {
        document.getElementById('ci-loading').classList.remove('open');
        if (typeof showToast === 'function') showToast('Failed to delete inquiry.', 'error');
    } finally {
        _ciPendingDeleteForm = null;
    }
}

function refreshCiStatsAfterDelete() {
    const total = document.querySelectorAll('.ci-card[data-id]').length;
    if (!total) {
        const list = document.querySelector('.ci-list');
        if (list) list.innerHTML = '<div class="ci-empty">No contact inquiries found.</div>';
    }
}

function openCiModal(id) {
    const d = ciData[id];
    if (!d) return;
    document.getElementById('ci-modal-name').textContent = d.name;
    document.getElementById('ci-modal-sub').textContent  =
        ucFirst(d.inquiry_type.replace('_',' ')) + ' · ' + ucFirst(d.status);
    document.getElementById('ci-v-name').textContent = d.name;
    const emailEl = document.getElementById('ci-v-email');
    emailEl.textContent = d.email;
    emailEl.href = 'mailto:' + d.email;
    const phoneRow = document.getElementById('ci-v-phone-row');
    if (d.phone) {
        document.getElementById('ci-v-phone').textContent = d.phone;
        phoneRow.style.display = '';
    } else {
        phoneRow.style.display = 'none';
    }
    document.getElementById('ci-v-type').textContent =
        ucFirst(d.inquiry_type.replace(/_/g,' '));
    document.getElementById('ci-v-status').innerHTML = statusBadge(d.status);
    document.getElementById('ci-v-date').textContent = d.created_at;
    const handlerRow = document.getElementById('ci-v-handler-row');
    if (d.handler) {
        document.getElementById('ci-v-handler').textContent =
            d.handler + (d.handled_at ? ' · ' + d.handled_at : '');
        handlerRow.style.display = '';
    } else {
        document.getElementById('ci-v-handler').textContent = 'Not yet handled';
        handlerRow.style.display = '';
    }
    document.getElementById('ci-v-message').textContent = d.message;
    document.getElementById('ci-modal-footer-label').textContent =
        'ID #' + d.id + ' · ' + d.created_at;
    document.getElementById('ci-update-form').action = d.update_url;
    document.getElementById('ci-delete-form').action = d.delete_url;
    selectCiStatus(d.status);
    document.querySelector('#ci-update-form textarea[name="note"]').value = '';
    switchCiTab(0);
    document.getElementById('ci-view-modal').classList.add('open');
}

function closeCiModal() {
    document.getElementById('ci-view-modal').classList.remove('open');
}

let _ciTab = 0;
function switchCiTab(idx) {
    _ciTab = idx;
    [0, 1, 2].forEach(i => {
        document.getElementById('ci-tab-' + i).classList.toggle('active', i === idx);
        document.getElementById('ci-panel-' + i).classList.toggle('active', i === idx);
    });
}

function selectCiStatus(val) {
    document.querySelectorAll('.ci-status-pill').forEach(p => {
        p.className = 'ci-status-pill';
        if (p.dataset.val === val) p.classList.add('sel-' + val);
    });
    document.getElementById('ci-status-input').value = val;
}

function ucFirst(str) {
    return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
}

function statusBadge(status) {
    const map = {
        new:      ['#fff0f6', 'var(--hot-pink)',  'var(--baby-pink)', 'New'],
        read:     ['#fff8e6', '#a15c00',           '#f8d78b',          'Read'],
        resolved: ['#effdf6', '#16835b',           '#a6e7d8',          'Resolved'],
    };
    const [bg, color, border, label] = map[status] || map.new;
    return `<span style="display:inline-flex;align-items:center;padding:.26rem .65rem;border-radius:999px;font-size:.7rem;font-weight:800;letter-spacing:.04em;text-transform:uppercase;background:${bg};color:${color};border:1px solid ${border};">${label}</span>`;
}

function escapeHtml(v) {
    return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

(function buildCiadd() {
    const backdrop = document.createElement('div');
    backdrop.id = 'ciadd-backdrop';
    backdrop.onclick = closeCiArchiveDetail;

    const modal = document.createElement('div');
    modal.id = 'ciadd-modal';
    modal.innerHTML = `
        <div class="ciadd-header">
            <div class="ciadd-header-top">
                <div style="display:flex;align-items:center;gap:.65rem;">
                    <div class="ciadd-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                    </div>
                    <div>
                        <div class="ciadd-title" id="ciadd-title">Deleted Inquiry</div>
                        <div class="ciadd-sub" id="ciadd-sub">Archived record</div>
                    </div>
                </div>
                <button class="ciadd-close" onclick="closeCiArchiveDetail()">&#x2715;</button>
            </div>
        </div>
        <div class="ciadd-body" id="ciadd-body"></div>
        <div class="ciadd-footer">
            <button class="ci-btn secondary" onclick="closeCiArchiveDetail()">Close</button>
        </div>
    `;

    document.body.appendChild(backdrop);
    document.body.appendChild(modal);
})();

function openCiArchive() {
    document.getElementById('ciad-drawer').classList.add('open');
    document.getElementById('ciad-backdrop').classList.add('open');
    document.getElementById('ciad-search').value = '';
    renderCiArchive();
}

function closeCiArchive() {
    document.getElementById('ciad-drawer').classList.remove('open');
    document.getElementById('ciad-backdrop').classList.remove('open');
}

function fmtDatePlain(d) {
    if (!d) return '—';
    return d;
}

function renderCiArchive() {
    const q = document.getElementById('ciad-search').value.toLowerCase();
    const data = ciDeletedArchive.filter(r =>
        (r.name    || '').toLowerCase().includes(q) ||
        (r.email   || '').toLowerCase().includes(q) ||
        (r.message || '').toLowerCase().includes(q) ||
        (r.inquiry_type || '').toLowerCase().includes(q)
    );
    const list = document.getElementById('ciad-list');
    document.getElementById('ciad-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');

    if (!data.length) {
        list.innerHTML = '<div class="ciad-empty">No deleted inquiries found.</div>';
        return;
    }

    list.innerHTML = data.map((r, i) => {
        return '<div class="ciad-card" style="animation-delay:' + (i * 0.04) + 's;" onclick=\'openCiArchiveDetail(' + JSON.stringify(r).replace(/</g,'\\u003c').replace(/'/g,'\\u0027') + ')\'>'
            + '<div class="ciad-card-top">'
                + '<div class="ciad-card-id">#' + r.id + '</div>'
                + '<div class="ciad-card-time">' + (r.created_at || '—') + '</div>'
            + '</div>'
            + '<div class="ciad-card-title">' + escapeHtml(r.name || '') + '</div>'
            + '<div class="ciad-card-desc">' + escapeHtml(r.message || '') + '</div>'
            + '<div class="ciad-card-meta">'
                + '<span class="ciad-pill" style="background:var(--petal);color:var(--hot-pink);border:1px solid var(--baby-pink);">' + ucFirst((r.inquiry_type || '').replace(/_/g,' ')) + '</span>'
                + '<span class="ciad-pill" style="background:#f3f4f6;color:#888;border:1px solid #d0d0d8;">' + ucFirst(r.status || 'new') + '</span>'
            + '</div>'
            + '<div class="ciad-card-deleted">Deleted on: <span>' + (r.deleted_at || '—') + '</span></div>'
        + '</div>';
    }).join('');
}

function openCiArchiveDetail(record) {
    document.getElementById('ciadd-title').textContent = record.name || 'Untitled';
    document.getElementById('ciadd-sub').textContent   = '#' + record.id + ' · Deleted ' + (record.deleted_at || '—');

    document.getElementById('ciadd-body').innerHTML = `
        <div class="ci-view-row"><span class="ci-view-label">Name</span><span class="ci-view-val">${escapeHtml(record.name || '')}</span></div>
        <div class="ci-view-row"><span class="ci-view-label">Email</span><span class="ci-view-val"><a href="mailto:${escapeHtml(record.email || '')}">${escapeHtml(record.email || '')}</a></span></div>
        ${record.phone ? `<div class="ci-view-row"><span class="ci-view-label">Phone</span><span class="ci-view-val">${escapeHtml(record.phone)}</span></div>` : ''}
        <div class="ci-view-row"><span class="ci-view-label">Inquiry Type</span><span class="ci-view-val">${ucFirst((record.inquiry_type || '').replace(/_/g,' '))}</span></div>
        <div class="ci-view-row"><span class="ci-view-label">Status</span><span class="ci-view-val">${statusBadge(record.status)}</span></div>
        <div class="ci-view-row"><span class="ci-view-label">Submitted</span><span class="ci-view-val">${record.created_at || '—'}</span></div>
        <div class="ci-view-row"><span class="ci-view-label">Deleted On</span><span class="ci-view-val" style="color:#e04867;">${record.deleted_at || '—'}</span></div>
        ${record.handler ? `<div class="ci-view-row"><span class="ci-view-label">Handled By</span><span class="ci-view-val">${escapeHtml(record.handler)}</span></div>` : ''}
        <div style="margin-top:1rem;">
            <div class="ci-update-label">Message</div>
            <div class="ci-view-message">${escapeHtml(record.message || '')}</div>
        </div>
    `;

    document.getElementById('ciadd-backdrop').classList.add('open');
    document.getElementById('ciadd-modal').classList.add('open');
}

function closeCiArchiveDetail() {
    document.getElementById('ciadd-backdrop').classList.remove('open');
    document.getElementById('ciadd-modal').classList.remove('open');
}

function exportCiArchive() {
    if (!ciDeletedArchive.length) return;
    const rows = [['ID','Name','Email','Phone','Inquiry Type','Status','Message','Submitted','Deleted On']];
    ciDeletedArchive.forEach(r => {
        rows.push([
            r.id,
            r.name        || '',
            r.email       || '',
            r.phone       || '',
            r.inquiry_type || '',
            r.status      || '',
            r.message     || '',
            r.created_at  || '',
            r.deleted_at  || '',
        ]);
    });
    const csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g,'""') + '"').join(',')).join('\n');
    const a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'contact_inquiries_deleted.csv';
    a.click();
}

@if(session('success'))
if (typeof showToast === 'function') showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
if (typeof showToast === 'function') showToast("{{ session('error') }}", 'error');
@endif

(function () {
    const POLL_URL         = '{{ route("contact-inquiries.index") }}';
    const POLL_INTERVAL_MS = 15000;
    let lastSignature = buildSignature();
    let pollTimer     = null;
    let inFlight      = false;

    function buildSignature() {
        const ids = Array.from(
            document.querySelectorAll('.ci-card[data-id]')
        ).map(el => el.dataset.id).sort().join(',');
        const statNums = Array.from(
            document.querySelectorAll('.ci-stat-num')
        ).map(el => el.textContent.trim()).join('|');
        return statNums + '::' + ids;
    }

    function buildSignatureFromDoc(doc) {
        const ids = Array.from(
            doc.querySelectorAll('.ci-card[data-id]')
        ).map(el => el.dataset.id).sort().join(',');
        const statNums = Array.from(
            doc.querySelectorAll('.ci-stat-num')
        ).map(el => el.textContent.trim()).join('|');
        return statNums + '::' + ids;
    }

    function isBusy() {
        if (document.getElementById('ci-view-modal').classList.contains('open')) return true;
        if (document.getElementById('ciad-drawer').classList.contains('open')) return true;
        if (document.getElementById('ciadd-modal').classList.contains('open')) return true;
        const a = document.activeElement;
        if (a && a !== document.body) {
            const t = a.tagName;
            if (t === 'INPUT' || t === 'TEXTAREA' || t === 'SELECT') return true;
        }
        return false;
    }

    function showNewInquiryBanner(diff) {
        const existing = document.getElementById('ci-new-banner');
        if (existing) existing.remove();
        const banner = document.createElement('div');
        banner.id = 'ci-new-banner';
        banner.style.cssText = [
            'position:fixed','top:1.2rem','left:50%','transform:translateX(-50%)',
            'z-index:3000','background:#fff',
            'border:1.5px solid var(--baby-pink)',
            'border-left:4px solid var(--hot-pink)',
            'border-radius:12px','padding:.65rem 1.1rem',
            'display:flex','align-items:center','gap:.65rem',
            'font-size:.83rem','font-weight:700','color:var(--ink)',
            'box-shadow:0 8px 28px rgba(232,23,93,.18)',
            'cursor:pointer','opacity:0','transition:opacity .3s',
            'white-space:nowrap',
        ].join(';');
        const dot = document.createElement('span');
        dot.style.cssText = 'width:8px;height:8px;border-radius:50%;background:var(--hot-pink);flex-shrink:0;animation:pulseLogo 1s ease-in-out infinite';
        banner.appendChild(dot);
        const msg = document.createElement('span');
        msg.textContent = (diff > 1)
            ? diff + ' new inquiries — click to refresh'
            : 'New inquiry received — click to refresh';
        banner.appendChild(msg);
        const x = document.createElement('button');
        x.innerHTML = '&#x2715;';
        x.style.cssText = 'background:none;border:none;cursor:pointer;font-size:.75rem;color:var(--ink-muted);margin-left:.4rem;padding:0;';
        x.onclick = function (e) { e.stopPropagation(); banner.remove(); };
        banner.appendChild(x);
        banner.addEventListener('click', function () {
            banner.remove();
            showCiLoading();
            window.location.reload();
        });
        document.body.appendChild(banner);
        requestAnimationFrame(() => { banner.style.opacity = '1'; });
        setTimeout(() => {
            if (banner.parentNode) {
                banner.style.opacity = '0';
                setTimeout(() => banner.remove(), 350);
            }
        }, 12000);
    }

    async function softRefresh() {
        try {
            const params = new URLSearchParams(window.location.search);
            const url    = POLL_URL + (params.toString() ? '?' + params.toString() : '');
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return;
            const html = await res.text();
            const doc  = new DOMParser().parseFromString(html, 'text/html');
            const fs = doc.querySelector('.ci-stats-row');
            const cs = document.querySelector('.ci-stats-row');
            if (fs && cs) cs.innerHTML = fs.innerHTML;
            const fl = doc.querySelector('.ci-list');
            const cl = document.querySelector('.ci-list');
            if (fl && cl) cl.innerHTML = fl.innerHTML;
            const fp = doc.querySelector('.ci-pagination');
            const cp = document.querySelector('.ci-pagination');
            if (fp && cp) cp.innerHTML = fp.innerHTML;
            const freshScript = Array.from(doc.querySelectorAll('script')).find(s =>
                s.textContent.includes('const ciData ')
            );
            if (freshScript) {
                const m  = freshScript.textContent.match(/const ciData\s*=\s*(\{[\s\S]*?\});/);
                const dm = freshScript.textContent.match(/const ciDeletedArchive\s*=\s*(\[[\s\S]*?\]);/);
                if (m) {
                    try {
                        const freshMap = JSON.parse(m[1]);
                        Object.keys(ciData).forEach(k => delete ciData[k]);
                        Object.assign(ciData, freshMap);
                    } catch (_) {}
                }
                if (dm) {
                    try {
                        const freshDeleted = JSON.parse(dm[1]);
                        ciDeletedArchive.length = 0;
                        ciDeletedArchive.push(...freshDeleted);
                    } catch (_) {}
                }
            }
            lastSignature = buildSignature();
        } catch (_) {}
    }

    async function poll() {
        if (inFlight || isBusy()) return;
        inFlight = true;
        try {
            const params = new URLSearchParams(window.location.search);
            const url    = POLL_URL + (params.toString() ? '?' + params.toString() : '');
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return;
            const html     = await res.text();
            const doc      = new DOMParser().parseFromString(html, 'text/html');
            const freshSig = buildSignatureFromDoc(doc);
            if (freshSig !== lastSignature) {
                const oldTotal = parseInt(
                    document.querySelector('.ci-stat-num')?.textContent || '0', 10
                );
                const newTotal = parseInt(
                    doc.querySelector('.ci-stat-num')?.textContent || '0', 10
                );
                lastSignature = freshSig;
                if (!isBusy()) {
                    await softRefresh();
                    const diff = newTotal - oldTotal;
                    if (diff > 0) showNewInquiryBanner(diff);
                }
            }
        } catch (_) {
        } finally {
            inFlight = false;
        }
    }

    function startPolling() {
        if (pollTimer) return;
        pollTimer = setInterval(poll, POLL_INTERVAL_MS);
    }

    function stopPolling() {
        clearInterval(pollTimer);
        pollTimer = null;
    }

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) { stopPolling(); }
        else { startPolling(); poll(); }
    });

    startPolling();
})();
</script>
@endsection