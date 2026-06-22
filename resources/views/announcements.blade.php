@extends('layout')

@section('title', 'DormEase: Announcements')
@section('page-title', 'Announcements')

@section('styles')
<style>
.ann-page {
    padding: 1.8rem 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    flex: 1;
    background: var(--soft-bg, #fdf6f9);
    box-sizing: border-box;
}
.ann-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
.ann-page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--ink, #1a1a2e);
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0;
}
.ann-page-header .dorm-name {
    font-size: .95rem;
    font-weight: 600;
    color: var(--bright-pink, #E8175D);
    margin-top: .2rem;
}
.ann-header-actions {
    display: flex;
    align-items: center;
    gap: .7rem;
    flex-wrap: wrap;
}
.btn-ann-primary {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.3rem;
    border-radius: 12px;
    background: var(--gradient-pink, linear-gradient(135deg,#E8175D,#c0103e));
    color: #fff;
    border: none;
    font-size: .87rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(232,23,93,.28);
    transition: transform .2s, box-shadow .2s;
    font-family: var(--ff-body);
    white-space: nowrap;
}
.btn-ann-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(232,23,93,.38);
}
.btn-ann-primary img { width: 15px; height: 15px; object-fit: contain; filter: brightness(0) invert(1); }
.btn-ann-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: #fff;
    color: var(--hot-pink, #d6175a);
    border: 1.5px solid var(--pink-100, #f9c5d6);
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
    font-family: var(--ff-body);
    white-space: nowrap;
}
.btn-ann-outline:hover {
    border-color: var(--bright-pink, #E8175D);
    box-shadow: 0 4px 14px rgba(232,23,93,.12);
}
.btn-ann-outline img {
    width: 14px; height: 14px; object-fit: contain;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.ann-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
}
.ann-stat-sub {
    font-size: .75rem;
    color: rgba(255,255,255,.82);
    font-weight: 600;
    letter-spacing: .04em;
    margin-top: .2rem;
}
.ann-stat-card {
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
}
.ann-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(232,23,93,.35);
}
.ann-stat-icon {
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
.ann-stat-icon img {
    width: 28px;
    height: 28px;
    object-fit: contain;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.ann-stat-num { font-size: 1.7rem; font-weight: 800; color: #fff; line-height: 1; }
.ann-stat-label { font-size: .8rem; color: rgba(247,245,245,.967); margin-bottom: .15rem; font-weight: 700; }
.ann-compose-strip {
    background: #fff;
    border: 1.5px solid var(--pink-100, #f9c5d6);
    border-radius: 16px;
    padding: .85rem 1.3rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 10px rgba(232,23,93,.05);
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
}
.ann-compose-strip:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 4px 18px rgba(232,23,93,.12);
}
.ann-compose-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: var(--gradient-pink);
    display: flex; align-items: center; justify-content: center;
    font-size: .88rem; font-weight: 800; color: #fff;
    flex-shrink: 0;
}
.ann-compose-placeholder {
    flex: 1;
    font-size: .9rem;
    color: #bbb;
    user-select: none;
    font-style: italic;
}
.ann-compose-actions {
    display: flex;
    align-items: center;
    gap: .5rem;
}
.ann-compose-chip {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .35rem .8rem;
    border-radius: 99px;
    border: 1.5px solid var(--pink-100);
    background: var(--petal, #ffeef4);
    font-size: .75rem;
    font-weight: 600;
    color: var(--hot-pink);
    cursor: pointer;
    transition: background .2s, border-color .2s;
}
.ann-compose-chip:hover { background: var(--blush); border-color: var(--bright-pink); }
.ann-compose-chip img { width: 12px; height: 12px; object-fit: contain; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }
.ann-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .75rem;
}
.ann-filter-group {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-wrap: wrap;
}
.ann-filter-select {
    display: inline-flex;
    align-items: center;
    padding: .42rem 2rem .42rem .85rem;
    border-radius: 99px;
    border: 1.5px solid var(--pink-100, #f9c5d6);
    background: #fff;
    font-size: .8rem;
    font-weight: 600;
    color: var(--ink-muted, #888);
    cursor: pointer;
    transition: all .2s;
    font-family: var(--ff-body);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%23E8175D' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .7rem center;
    outline: none;
}
.ann-filter-select:hover { border-color: var(--bright-pink, #E8175D); color: var(--hot-pink, #d6175a); background-color: var(--petal, #ffeef4); }
.ann-filter-select:focus { border-color: var(--bright-pink, #E8175D); color: var(--hot-pink, #d6175a); }
.ann-filter-select.has-value {
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%23E8175D' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .7rem center;
    color: var(--hot-pink, #d6175a);
    border-color: var(--bright-pink, #E8175D);
    box-shadow: 0 4px 12px rgba(232,23,93,.12);
}
.ann-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.ann-search-wrap input {
    padding: .45rem .85rem .45rem 2.1rem;
    border-radius: 10px;
    border: 1.5px solid var(--pink-100);
    background: #fff;
    font-size: .82rem;
    color: var(--ink);
    outline: none;
    width: 200px;
    font-family: var(--ff-body);
    transition: border-color .2s, width .3s;
    box-shadow: 0 2px 8px rgba(232,23,93,.04);
}
.ann-search-wrap input:focus { border-color: var(--bright-pink); width: 240px; }
.ann-search-icon { position: absolute; left: .65rem; width: 14px; height: 14px; opacity: .35; pointer-events: none; }
.ann-main-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.2rem;
    align-items: start;
}
.ann-list-panel {
    display: flex;
    flex-direction: column;
    gap: .75rem;
}
.ann-row-card {
    background: #fff;
    border: 1px solid var(--pink-100);
    border-radius: 14px;
    padding: 1rem 1.2rem 1rem 1.6rem;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: .75rem 1rem;
    align-items: start;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s, transform .15s;
    position: relative;
    overflow: hidden;
}
.ann-row-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    background: var(--pink-200, #f4b8d0);
    transition: background .2s;
}
.ann-row-card:hover {
    border-color: var(--bright-pink);
    box-shadow: 0 6px 22px rgba(232,23,93,.11);
    transform: translateY(-1px);
}
.ann-row-card:hover::before { background: var(--gradient-pink); }
.ann-row-card.status-active::before { background: linear-gradient(180deg, #1f9d69, #4ecb8d); }
.ann-row-card.status-scheduled::before { background: var(--gradient-pink); }
.ann-row-left {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
    padding-top: .15rem;
}
.ann-row-priority-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.prio-low      { background: #1f9d69; }
.prio-moderate { background: #f59e0b; }
.prio-high     { background: #e04867; }
.ann-row-body { min-width: 0; }
.ann-row-title {
    font-size: .93rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: .28rem;
    line-height: 1.35;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ann-row-excerpt {
    font-size: .78rem;
    color: var(--ink-muted);
    line-height: 1.55;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: .55rem;
}
.ann-row-meta {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}
.ann-meta-chip {
    display: inline-flex;
    align-items: center;
    gap: .28rem;
    font-size: .7rem;
    font-weight: 600;
    color: var(--ink-muted);
}
.ann-meta-chip img { width: 11px; height: 11px; object-fit: contain; opacity: .5; }
.ann-badge {
    display: inline-flex;
    align-items: center;
    padding: .18rem .58rem;
    border-radius: 99px;
    font-size: .68rem;
    font-weight: 800;
    letter-spacing: .02em;
}
.badge-active     { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-closed     { background: #f3f4f6; color: #888; border: 1px solid #d0d0d8; }
.badge-scheduled  { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--pink-200, #f4b8d0); }
.badge-low        { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-moderate   { background: #fff8e1; color: #c8960c; border: 1px solid #f0c040; }
.badge-high       { background: #fff0f0; color: #e04867; border: 1px solid #ffb3c0; }
.ann-row-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: .4rem;
    flex-shrink: 0;
}
.ann-row-time {
    font-size: .68rem;
    color: var(--ink-muted);
    white-space: nowrap;
    font-weight: 500;
}
.ann-menu-btn {
    width: 28px; height: 28px;
    border-radius: 7px;
    border: 1px solid var(--pink-100);
    background: #fff;
    cursor: pointer;
    color: var(--ink-muted);
    font-size: 1.1rem;
    font-weight: 800;
    line-height: 1;
    display: flex; align-items: center; justify-content: center;
    transition: .2s;
    position: relative;
}
.ann-menu-btn:hover, .ann-menu-btn.active {
    color: var(--hot-pink);
    border-color: var(--bright-pink);
    background: var(--petal);
}
.ann-dropdown {
    position: fixed;
    background: #fff;
    border: 1px solid var(--pink-100, #f9c5d6);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(26,26,46,.14), 0 2px 8px rgba(232,23,93,.08);
    z-index: 99999;
    min-width: 170px;
    display: none;
    flex-direction: column;
    padding: .35rem;
    overflow: hidden;
}
.ann-dropdown.open { display: flex; }
.ann-dropdown-item {
    padding: .55rem .85rem;
    font-size: .82rem;
    font-weight: 600;
    color: var(--ink, #1a1a2e);
    cursor: pointer;
    transition: background .15s, color .15s;
    border: none;
    background: none;
    text-align: left;
    width: 100%;
    display: flex;
    align-items: center;
    gap: .6rem;
    font-family: var(--ff-body);
    border-radius: 8px;
}
.ann-dropdown-item:hover {
    background: var(--petal, #ffeef4);
    color: var(--hot-pink, #d6175a);
}
.ann-dropdown-item:hover .dd-icon { opacity: 1; }
.ann-dropdown-item.danger { color: #e04867; }
.ann-dropdown-item.danger:hover { background: #fff0f0; color: #c0103e; }
.dd-icon {
    width: 16px; height: 16px;
    object-fit: contain;
    opacity: .55;
    transition: opacity .15s;
    flex-shrink: 0;
}
.ann-dropdown-item:not(.danger) .dd-icon {
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.ann-dropdown-item.danger .dd-icon {
    filter: brightness(0) saturate(100%) invert(30%) sepia(80%) saturate(2000%) hue-rotate(330deg) brightness(90%) contrast(95%);
}
.ann-dropdown-divider {
    height: 1px;
    background: var(--pink-100, #f9c5d6);
    margin: .25rem .1rem;
}
.sched-inline-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .7rem;
    font-weight: 700;
    color: var(--hot-pink);
    background: var(--petal);
    border: 1px solid var(--pink-200);
    border-radius: 6px;
    padding: .18rem .5rem;
}
.sched-inline-badge svg { width: 10px; height: 10px; flex-shrink: 0; }
.ann-list-empty {
    text-align: center;
    padding: 3rem 1rem;
    background: #fff;
    border: 1px solid var(--pink-100);
    border-radius: 14px;
    color: var(--ink-muted);
    font-size: .85rem;
}
.ann-list-empty img {
    width: 42px; height: 42px;
    opacity: .25;
    display: block;
    margin: 0 auto .75rem;
}
.ann-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    position: sticky;
    top: 5rem;
    align-self: flex-start;
}
.ann-sidebar-card {
    background: #fff;
    border: 1px solid var(--pink-100);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(232,23,93,.05);
}
.ann-sidebar-header {
    padding: .85rem 1.1rem;
    border-bottom: 1px solid var(--pink-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ann-sidebar-title {
    font-size: .82rem;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -.01em;
    display: flex;
    align-items: center;
    gap: .45rem;
}
.ann-sidebar-title img {
    width: 14px; height: 14px; object-fit: contain;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.ann-sidebar-body { padding: .75rem 1.1rem; }
.ann-prio-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .45rem 0;
    border-bottom: 1px solid var(--pink-100);
    font-size: .8rem;
}
.ann-prio-row:last-child { border-bottom: none; }
.ann-prio-label {
    display: flex;
    align-items: center;
    gap: .45rem;
    font-weight: 600;
    color: var(--ink);
}
.ann-prio-label .dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.ann-prio-count {
    font-weight: 800;
    color: var(--hot-pink);
}
.ann-sched-item {
    padding: .65rem 0;
    border-bottom: 1px solid var(--pink-100);
    cursor: pointer;
    transition: background .15s;
}
.ann-sched-item:last-child { border-bottom: none; }
.ann-sched-item:hover .ann-sched-title { color: var(--hot-pink); }
.ann-sched-title {
    font-size: .82rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.3;
    margin-bottom: .22rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ann-sched-time {
    font-size: .7rem;
    color: var(--hot-pink);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: .3rem;
}
.ann-sched-time svg { width: 10px; height: 10px; flex-shrink: 0; }
.ann-sched-empty {
    font-size: .8rem;
    color: var(--ink-muted);
    padding: .5rem 0;
    text-align: center;
}
.action-loading-overlay {
    position: fixed; inset: 0; z-index: 1200;
    display: none; align-items: center; justify-content: center;
    background: rgba(255,255,255,.72); backdrop-filter: blur(2px);
}
.action-loading-overlay.open { display: flex; }
.action-loading-box {
    display: flex; align-items: center; flex-direction: column;
    gap: .75rem; padding: 1.25rem 1.6rem;
    border: 1px solid var(--pink-100); border-radius: 12px;
    background: #fff; box-shadow: 0 12px 32px rgba(26,26,46,.14);
    color: var(--ink); font-size: .9rem; font-weight: 700;
}
.loading-logo-wrap {
    width: 86px; height: 86px;
    border: 3px solid var(--pink-100); border-radius: 50%;
    background: var(--gradient-pink);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 10px 24px rgba(232,23,93,.25);
    animation: pulseLogo 1s ease-in-out infinite;
}
.loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }
.is-loading { opacity: .75; pointer-events: none; }
.ann-archive-drawer {
    position: fixed;
    top: 0; right: 0; bottom: 0;
    width: min(660px, 100vw);
    background: var(--soft-bg, #fdf6f9);
    z-index: 500;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    box-shadow: -8px 0 40px rgba(214,51,117,.15);
}
.ann-archive-drawer.open { transform: translateX(0); }
.ann-archive-backdrop {
    position: fixed; inset: 0;
    background: rgba(232,23,93,.18);
    backdrop-filter: blur(3px);
    z-index: 499; opacity: 0; pointer-events: none;
    transition: opacity .38s ease;
}
.ann-archive-backdrop.open { opacity: 1; pointer-events: auto; }
.aad-header {
    padding: 1.4rem 1.6rem 1rem;
    border-bottom: 1px solid var(--pink-100);
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 1rem; flex-shrink: 0;
}
.aad-title { font-size: 1.15rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
.aad-sub   { font-size: .78rem; color: var(--ink-muted); margin-top: .2rem; }
.aad-close {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: 1px solid var(--pink-100);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: .95rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}
.aad-close:hover { background: var(--pink-100); }
.aad-tabs {
    display: flex;
    gap: 0;
    padding: 0 1.6rem;
    border-bottom: 1px solid var(--pink-100);
    flex-shrink: 0;
    background: #fff;
}
.aad-tab {
    padding: .75rem 1rem;
    font-size: .8rem;
    font-weight: 700;
    color: var(--ink-muted);
    background: none;
    border: none;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1px;
    cursor: pointer;
    transition: color .18s, border-color .18s;
    display: flex;
    align-items: center;
    gap: .4rem;
    font-family: var(--ff-body);
    white-space: nowrap;
}
.aad-tab:hover { color: var(--hot-pink); }
.aad-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }
.aad-tab-count {
    font-size: .66rem;
    font-weight: 800;
    padding: .1rem .42rem;
    border-radius: 99px;
    background: var(--petal);
    color: var(--ink-muted);
    min-width: 16px;
    text-align: center;
}
.aad-tab.active .aad-tab-count {
    background: var(--bright-pink);
    color: #fff;
}
.aad-pill-status-closed { background: #f3f4f6; color: #888; border: 1px solid #d0d0d8; }
.aad-search-bar { padding: .85rem 1.6rem .65rem; flex-shrink: 0; }
.aad-search-inner { position: relative; display: flex; align-items: center; }
.aad-search-inner input {
    width: 100%;
    padding: .52rem .9rem .52rem 2.1rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    background: #fff;
    font-size: .82rem;
    font-family: var(--ff-body);
    outline: none;
    box-sizing: border-box;
}
.aad-search-inner input:focus { border-color: var(--bright-pink); background: var(--blush); }
.aad-search-icon { position: absolute; left: .72rem; width: 13px; height: 13px; opacity: .45; pointer-events: none; }
.aad-list {
    flex: 1; overflow-y: auto;
    padding: 0 1.6rem 1.6rem;
    display: flex; flex-direction: column; gap: .7rem;
}
.aad-list::-webkit-scrollbar { width: 4px; }
.aad-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }
.aad-card {
    background: #fff;
    border: 1px solid var(--pink-100);
    border-radius: 12px;
    padding: .9rem 1rem;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    animation: aadSlide .3s ease both;
}
@keyframes aadSlide { from { opacity:0; transform: translateX(10px); } to { opacity:1; transform: none; } }
.aad-card:hover { border-color: var(--bright-pink); background: var(--blush); }
.aad-card-top { display: flex; justify-content: space-between; gap: .8rem; margin-bottom: .4rem; }
.aad-card-id  { font-size: .72rem; font-weight: 800; color: var(--bright-pink); font-family: monospace; }
.aad-card-time { font-size: .68rem; color: var(--ink-muted); white-space: nowrap; }
.aad-card-title { font-size: .88rem; font-weight: 700; color: var(--ink); margin-bottom: .18rem; }
.aad-card-desc { font-size: .74rem; color: var(--ink-muted); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.aad-card-meta { display: flex; gap: .4rem; margin-top: .55rem; flex-wrap: wrap; }
.aad-pill { font-size: .66rem; font-weight: 700; padding: .16rem .52rem; border-radius: 99px; text-transform: uppercase; letter-spacing: .03em; }
.aad-pill-low      { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.aad-pill-moderate { background: #fff8e1; color: #c8960c; border: 1px solid #f0c040; }
.aad-pill-high     { background: #fff0f0; color: #e04867; border: 1px solid #ffb3c0; }
.aad-pill-active   { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--pink-200); }
.aad-pill-closed   { background: #f3f4f6; color: #888; border: 1px solid #d0d0d8; }
.aad-pill-scheduled { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--pink-200); }
.aad-card-deleted {
    font-size: .68rem; color: var(--ink-muted);
    margin-top: .55rem; padding-top: .5rem;
    border-top: 1px solid var(--pink-100);
}
.aad-card-deleted span { color: var(--bright-pink); font-weight: 600; }
.aad-empty { text-align: center; padding: 2.5rem 1rem; color: var(--ink-muted); font-size: .84rem; }
.aad-empty img { width: 38px; height: 38px; opacity: .25; display: block; margin: 0 auto .65rem; }
.aad-footer {
    padding: .85rem 1.6rem;
    border-top: 1px solid var(--pink-100);
    background: #fff;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.aad-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
.aad-export-btn {
    display: inline-flex; align-items: center; gap: .38rem;
    font-size: .74rem; font-weight: 700; color: var(--bright-pink);
    background: var(--petal); border: 1px solid var(--pink-100);
    border-radius: 8px; padding: .32rem .8rem;
    cursor: pointer; transition: background .2s; font-family: var(--ff-body);
}
.aad-export-btn:hover { background: var(--gradient-pink); color: #fff; border-color: transparent; }
.aad-export-btn img { width: 12px; height: 12px; opacity: .7; }
.delete-warning {
    background: #fff0f0; border: 1px solid #ffd6d6;
    border-radius: 12px; padding: 1rem; margin-bottom: 1rem;
    font-size: .88rem; color: var(--red); line-height: 1.6;
}
.modal-field select {
    width: 100%; box-sizing: border-box;
    border: 1.5px solid var(--border); border-radius: 9px;
    padding: .55rem .85rem;
    font-size: .88rem; color: var(--ink); background: #fff;
    appearance: none; -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .85rem center;
    padding-right: 2.2rem;
    cursor: pointer; transition: border-color .15s;
}
.modal-field select:focus { border-color: var(--hot-pink); outline: none; }
.modal-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: .9rem; }
.modal-actions { display: flex; gap: .7rem; margin-top: 1.5rem; justify-content: flex-end; }
.btn-cancel {
    padding: .58rem 1.2rem; border-radius: 9px;
    border: 1.5px solid var(--border); background: #fff;
    font-size: .87rem; font-weight: 600; color: var(--hot-pink); cursor: pointer;
    transition: .2s;
}
.btn-cancel:hover { border-color: var(--hot-pink); background: var(--pink-bg); }
.btn-submit {
    padding: .58rem 1.4rem; border-radius: 9px;
    border: none; background: var(--hot-pink); color: #fff;
    font-size: .87rem; font-weight: 700; cursor: pointer; transition: .2s;
}
.btn-submit:hover { background: var(--bright-pink); }
.btn-danger {
    padding: .58rem 1.4rem; border-radius: 9px;
    border: none; background: var(--red); color: #fff;
    font-size: .87rem; font-weight: 700; cursor: pointer;
}
.schedule-toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: .7rem .9rem;
    background: var(--petal); border: 1.5px solid var(--pink-100);
    border-radius: 10px; cursor: pointer;
    transition: background .2s; user-select: none;
}
.schedule-toggle-row:hover { background: var(--blush); border-color: var(--pink-200); }
.schedule-toggle-label { display: flex; align-items: center; gap: .55rem; font-size: .87rem; font-weight: 700; color: var(--hot-pink); }
.schedule-toggle-label svg { width: 16px; height: 16px; }
.schedule-toggle-switch { width: 36px; height: 20px; border-radius: 99px; background: var(--pink-200); position: relative; transition: background .2s; }
.schedule-toggle-switch.on { background: var(--hot-pink); }
.schedule-toggle-switch::after { content: ''; position: absolute; top: 2px; left: 2px; width: 16px; height: 16px; border-radius: 50%; background: #fff; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
.schedule-toggle-switch.on::after { transform: translateX(16px); }
.schedule-fields { display: none; padding: .8rem; background: var(--blush); border: 1.5px solid var(--pink-100); border-radius: 10px; gap: .8rem; flex-direction: column; }
.schedule-fields.open { display: flex; }
.schedule-fields .modal-field { margin-bottom: 0; }
.schedule-fields input[type="datetime-local"] { width: 100%; box-sizing: border-box; border: 1.5px solid var(--pink-100); border-radius: 9px; padding: .55rem .85rem; font-size: .88rem; color: var(--ink); background: #fff; font-family: var(--ff-body); }
.schedule-note { font-size: .75rem; color: var(--bright-pink); margin-top: .3rem; line-height: 1.5; }
.form-progress-wrap { padding: .7rem 1.5rem .1rem; display: flex; flex-direction: column; gap: .35rem; flex-shrink: 0; }
.form-progress-bar { width: 100%; height: 3px; background: var(--pink-100); border-radius: 99px; overflow: hidden; }
.form-progress-fill { height: 100%; border-radius: 99px; transition: width .35s cubic-bezier(.4,0,.2,1), background .35s; }
.form-progress-label { display: flex; align-items: center; justify-content: space-between; font-size: .68rem; font-weight: 700; color: var(--ink-muted); }
.form-progress-label span.ready { color: #1f9d69; font-weight: 800; }
.form-progress-label span.partial { color: var(--hot-pink); }
.field-req-star { color: var(--bright-pink); font-size: .75rem; font-weight: 900; margin-left: .18rem; opacity: .8; vertical-align: middle; }
#edit-modal .modal, #post-modal .modal, #view-modal .modal {
    max-width: 560px; width: 100%; padding: 0;
    overflow: hidden; max-height: 92vh;
    display: flex; flex-direction: column;
}
#view-modal .em-panels, #view-modal #vm-edit-panels { overflow-y: auto; flex: 1; }
#post-modal .em-panels, #edit-modal .em-panels { overflow-y: auto; flex: 1; }
.em-header { padding: 1.3rem 1.5rem 0; border-bottom: 1px solid var(--pink-100); background: #fff; flex-shrink: 0; }
.em-header-top { display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem; margin-bottom: 1rem; }
.em-title-group { display: flex; align-items: center; gap: .65rem; }
.em-icon { width: 34px; height: 34px; border-radius: 9px; background: var(--gradient-pink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.em-icon img { width: 16px; height: 16px; object-fit: contain; filter: brightness(10); }
.em-title { font-size: 1rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
.em-sub { font-size: .7rem; color: var(--ink-muted); font-weight: 500; margin-top: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px; }
.em-close { width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--pink-100); background: var(--petal); color: var(--bright-pink); font-size: .8rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s; }
.em-close:hover { background: var(--pink-100); }
.em-tabs { display: flex; }
.em-tab { padding: .62rem 1.1rem; font-size: .8rem; font-weight: 700; color: var(--ink-muted); cursor: pointer; border: none; background: none; border-bottom: 2.5px solid transparent; transition: color .18s, border-color .18s; display: flex; align-items: center; gap: .38rem; font-family: var(--ff-body); margin-bottom: -1px; }
.em-tab img { width: 13px; height: 13px; opacity: .5; transition: opacity .18s; }
.em-tab svg { width: 13px; height: 13px; flex-shrink: 0; opacity: .6; transition: opacity .18s; }
.em-tab:hover { color: var(--hot-pink); }
.em-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }
.em-tab.active img { opacity: 1; }
.em-tab.active svg { opacity: 1; }
.em-panels { padding: 1.3rem 1.5rem; min-height: 220px; }
.em-panel { display: none; flex-direction: column; gap: .9rem; animation: emFadeIn .18s ease both; }
.em-panel.active { display: flex; }
@keyframes emFadeIn { from { opacity:0; transform: translateY(4px); } to { opacity:1; transform: none; } }
#edit-modal .modal-field, #post-modal .modal-field { margin-bottom: 0; }
.em-pill-row { display: flex; gap: .45rem; flex-wrap: wrap; }
.em-pill-opt { padding: .36rem .85rem; border-radius: 99px; border: 1.5px solid var(--border); font-size: .78rem; font-weight: 700; color: var(--ink-muted); cursor: pointer; transition: .18s; user-select: none; background: #fff; }
.em-pill-opt:hover { border-color: var(--hot-pink); color: var(--hot-pink); background: var(--petal); }
.em-pill-opt.sel-low      { border-color: var(--green); color: var(--green); background: #f0fdf8; }
.em-pill-opt.sel-moderate { border-color: #f59e0b; color: #c8960c; background: #fff8eb; }
.em-pill-opt.sel-high     { border-color: var(--red); color: var(--red); background: #fff0f0; }
.em-pill-opt.sel-active   { border-color: var(--hot-pink); color: var(--hot-pink); background: var(--petal); }
.em-pill-opt.sel-closed   { border-color: var(--ink-muted); color: var(--ink-muted); background: #f3f4f6; }
.em-file-zone { border: 1.5px dashed var(--pink-200); border-radius: 12px; padding: 1rem 1.1rem; background: var(--blush); display: flex; flex-direction: column; gap: .45rem; }
.em-file-note { font-size: .72rem; color: var(--ink-muted); line-height: 1.5; }
.em-file-error { font-size: .76rem; font-weight: 700; color: #e04867; line-height: 1.5; display: none; }
.em-file-error.show { display: block; }
.em-file-zone.has-error { border-color: #e04867; background: #fff5f5; }
.em-replace-row { display: flex; align-items: center; gap: .5rem; padding: .5rem .75rem; border-radius: 9px; border: 1px solid var(--pink-100); background: var(--petal); cursor: pointer; }
.em-replace-row input[type="checkbox"] { width: 14px; height: 14px; accent-color: var(--hot-pink); cursor: pointer; }
.em-replace-row span { font-size: .77rem; font-weight: 600; color: var(--hot-pink); }
.em-footer { padding: .9rem 1.5rem; border-top: 1px solid var(--pink-100); display: flex; align-items: center; justify-content: space-between; gap: .75rem; flex-shrink: 0; }
.em-tab-nav { display: flex; align-items: center; gap: .5rem; }
.em-nav-btn { padding: .45rem .9rem; border-radius: 8px; border: 1.5px solid var(--border); background: #fff; font-size: .78rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; transition: .2s; font-family: var(--ff-body); display: flex; align-items: center; gap: .3rem; }
.em-nav-btn:hover { border-color: var(--hot-pink); color: var(--hot-pink); background: var(--pink-bg); }
.em-nav-btn:disabled { opacity: .35; pointer-events: none; }
.em-footer-actions { display: flex; gap: .6rem; }
#edit-modal .schedule-toggle-row, #post-modal .schedule-toggle-row { margin-bottom: 0; }
.view-title { font-size: 1.3rem; font-weight: 800; color: var(--ink); line-height: 1.25; margin-bottom: .65rem; }
.view-row { display: flex; justify-content: space-between; align-items: flex-start; padding: .62rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
.view-row:last-child { border-bottom: none; }
.view-label { color: var(--ink-muted); font-weight: 500; }
.view-val { font-weight: 600; color: var(--ink); text-align: right; }
.view-content { margin-top: 1rem; white-space: pre-wrap; font-size: .92rem; color: var(--ink-muted); line-height: 1.75; }
.attachment-grid { margin-top: 1rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap: .8rem; }
.attachment-card { border: 1px solid var(--border); border-radius: 10px; overflow: hidden; background: #fff; }
.attachment-card img { width: 100%; max-height: 360px; object-fit: contain; display: block; background: var(--gray-light); }
.attachment-link { display: flex; align-items: center; gap: .45rem; padding: .7rem .85rem; color: var(--hot-pink); font-size: .82rem; font-weight: 700; text-decoration: none; }
.attachment-link img { width: 16px; height: 16px; }
.current-files-note { margin-top: .35rem; font-size: .76rem; color: var(--ink-muted); line-height: 1.5; }

#aadd-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 800;
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
}
#aadd-backdrop.open { opacity: 1; pointer-events: auto; }

#aadd-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -48%) scale(.97);
    width: min(540px, calc(100vw - 2rem));
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
#aadd-modal.open {
    opacity: 1;
    pointer-events: auto;
    transform: translate(-50%, -50%) scale(1);
}
#aadd-modal .aadd-header {
    padding: 1.3rem 1.5rem 0;
    border-bottom: 1px solid var(--pink-100);
    background: #fff;
    flex-shrink: 0;
}
#aadd-modal .aadd-header-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: 1rem;
}
#aadd-modal .aadd-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
#aadd-modal .aadd-icon img {
    width: 16px; height: 16px; object-fit: contain;
    filter: brightness(0) saturate(100%) invert(40%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(60%);
}
#aadd-modal .aadd-title { font-size: 1rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
#aadd-modal .aadd-sub { font-size: .7rem; color: var(--ink-muted); font-weight: 500; margin-top: .1rem; }
#aadd-modal .aadd-close {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1px solid var(--pink-100);
    background: var(--petal);
    color: var(--bright-pink);
    font-size: .8rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}
#aadd-modal .aadd-close:hover { background: var(--pink-100); }
#aadd-modal .aadd-body {
    padding: 1.3rem 1.5rem;
    overflow-y: auto;
    flex: 1;
}
#aadd-modal .aadd-footer {
    padding: .9rem 1.5rem;
    border-top: 1px solid var(--pink-100);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-shrink: 0;
}

@media (max-width: 1100px) { .ann-main-layout { grid-template-columns: 1fr; } .ann-sidebar { position: static; } }
@media (max-width: 1100px) { .ann-stats-row { grid-template-columns: repeat(3, 1fr); } .ann-stat-num { font-size: 1.6rem; } }
@media (max-width: 900px) { .ann-stats-row { grid-template-columns: 1fr 1fr; } .ann-page { padding: 1.2rem 1rem; } .ann-stat-card { padding: 1rem 1.1rem; gap: .9rem; } .ann-stat-icon { width: 44px; height: 44px; } .ann-stat-icon img { width: 22px; height: 22px; } .ann-stat-num { font-size: 1.5rem; } }
@media (max-width: 600px) { .ann-stats-row { grid-template-columns: 1fr; } .ann-page { padding: 1rem; } .ann-compose-chip { display: none; } .ann-stat-card { padding: 1rem 1.2rem; } .ann-stat-num { font-size: 1.75rem; } }
.ann-legend-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    flex-shrink: 0;
}
.ann-legend-wrap img {
    display: block;
    width: 15px;
    height: 15px;
    object-fit: contain;
    opacity: .65;
    transition: opacity .2s;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.ann-legend-wrap:hover img { opacity: 1; }
.ann-legend-popup {
    display: none;
    position: fixed;
    background: #fff;
    border: 1.5px solid var(--pink-100, #f9c5d6);
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(232,23,93,.16), 0 2px 8px rgba(0,0,0,.08);
    padding: .85rem 1rem;
    min-width: 300px;
    max-width: 340px;
    z-index: 999999;
    pointer-events: none;
    overflow-y: auto;
    max-height: 80vh;
}
.ann-legend-popup.open {
    display: block;
    pointer-events: auto;
}
.alp-title {
    font-size: .67rem;
    font-weight: 800;
    color: var(--bright-pink, #E8175D);
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .55rem;
    padding-bottom: .4rem;
    border-bottom: 1.5px solid var(--petal, #ffeef4);
}
.alp-row {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    padding: .35rem 0;
    border-bottom: 1px solid var(--pink-100, #f9c5d6);
}
.alp-row:last-child { border-bottom: none; }
.alp-badge-cell {
    flex-shrink: 0;
    width: 82px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
.alp-dot-cell {
    flex-shrink: 0;
    width: 82px;
    display: flex;
    align-items: center;
    gap: .4rem;
}
.alp-dot-label { font-size: .75rem; font-weight: 700; }
.alp-desc {
    font-size: .75rem;
    color: var(--ink-muted, #888);
    font-weight: 500;
    line-height: 1.45;
    padding-top: .1rem;
    flex: 1;
}
.fade-up { animation: fadeUp .42s ease both; }
.d1 { animation-delay: .05s; } .d2 { animation-delay: .12s; } .d3 { animation-delay: .2s; } .d4 { animation-delay: .28s; }
@keyframes fadeUp { from { opacity:0; transform: translateY(12px); } to { opacity:1; transform: none; } }
@keyframes pulseLogo { 0%,100% { transform: scale(1); } 50% { transform: scale(1.06); } }
</style>
@endsection

@section('content')
<div class="ann-page">

    <div class="ann-page-header fade-up d1">
        <div>
            <h1>Announcements</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="ann-header-actions">
            <button class="btn-ann-outline" onclick="openAnnArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>
            <button class="btn-ann-primary" onclick="openPostModal()">
                <img src="{{ asset('icons/announce.png') }}" alt="">
                Post Announcement
            </button>
        </div>
    </div>

    <div class="ann-stats-row fade-up d2">
        @php $allForStats = $announcements->merge($scheduled)->merge($closedArchive); @endphp

        <div class="ann-stat-card">
            <div class="ann-stat-icon">
                <img src="{{ asset('icons/announce.png') }}" alt="">
            </div>
            <div>
                <div class="ann-stat-label">Total Announcements</div>
                <div class="ann-stat-num">{{ $allForStats->count() }}</div>
                <div class="ann-stat-sub">All Posted &amp; Scheduled</div>
            </div>
        </div>

        <div class="ann-stat-card">
            <div class="ann-stat-icon">
                <img src="{{ asset('icons/active.png') }}" alt="">
            </div>
            <div>
                <div class="ann-stat-label">Active</div>
                <div class="ann-stat-num">{{ $announcements->where('status','active')->count() }}</div>
                <div class="ann-stat-sub">{{ $scheduled->count() }} Scheduled</div>
            </div>
            @if($scheduled->count() > 0)
            <div style="margin-left:auto;flex-shrink:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(255,255,255,.18);border:1.5px solid rgba(255,255,255,.35);border-radius:12px;padding:.45rem .75rem;min-width:48px;gap:.1rem;">
                <span style="font-size:1.1rem;font-weight:800;color:#fff;line-height:1;">{{ $scheduled->count() }}</span>
                <span style="font-size:.58rem;font-weight:700;color:rgba(255,255,255,.88);text-transform:uppercase;letter-spacing:.05em;white-space:nowrap;">Scheduled</span>
            </div>
            @endif
        </div>

        <div class="ann-stat-card">
            <div class="ann-stat-icon">
                <img src="{{ asset('icons/archive.png') }}" alt="">
            </div>
            <div>
                <div class="ann-stat-label">Closed</div>
                <div class="ann-stat-num">{{ $closedArchive->count() }}</div>
                <div class="ann-stat-sub">Archived Announcements</div>
            </div>
        </div>
    </div>

    <div class="ann-compose-strip fade-up d3" onclick="openPostModal()">
        <div class="ann-compose-avatar">
            @if($staff->profile_picture)
                <img src="{{ $staff->profile_picture }}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            @else
                {{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}
            @endif
        </div>
        <div class="ann-compose-placeholder">What do you want to announce today?</div>
        <div class="ann-compose-actions">
            <span class="ann-compose-chip"><img src="{{ asset('icons/flag.png') }}" alt=""> Priority</span>
            <span class="ann-compose-chip"><img src="{{ asset('icons/attach.png') }}" alt=""> Attach</span>
            <span class="ann-compose-chip"><img src="{{ asset('icons/clock.png') }}" alt=""> Schedule</span>
        </div>
    </div>

    <div class="ann-toolbar fade-up d3">
        <div class="ann-filter-group">
            <select class="ann-filter-select" id="filter-status" onchange="applyDropdownFilters(this)">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="scheduled">Scheduled</option>
            </select>
            <select class="ann-filter-select" id="filter-priority" onchange="applyDropdownFilters(this)">
                <option value="">All Priorities</option>
                <option value="high">High Priority</option>
                <option value="moderate">Moderate Priority</option>
                <option value="low">Low Priority</option>
            </select>
            <select class="ann-filter-select" id="filter-date" onchange="applyDropdownFilters(this)">
                <option value="">Any Date</option>
                <option value="this_week">This Week</option>
                <option value="last_week">Last Week</option>
                <option value="two_weeks">Last 2 Weeks</option>
                <option value="this_month">This Month</option>
            </select>
        </div>
        <div style="display:flex;align-items:center;gap:.6rem;">
            <div class="ann-legend-wrap" id="ann-legend-trigger">
                <img src="{{ asset('icons/info.png') }}" alt="Guide">
                <div class="ann-legend-popup" id="ann-legend-popup">
                    <div class="alp-title">Status Guide</div>
                    <div class="alp-row">
                        <div class="alp-badge-cell"><span class="ann-badge badge-active">Active</span></div>
                        <div class="alp-desc">Announcement is live and visible to all tenants.</div>
                    </div>
                    <div class="alp-row">
                        <div class="alp-badge-cell"><span class="ann-badge badge-scheduled">Scheduled</span></div>
                        <div class="alp-desc">Set to go live automatically at a future date and time.</div>
                    </div>
                    <div class="alp-row">
                        <div class="alp-badge-cell"><span class="ann-badge badge-closed">Closed</span></div>
                        <div class="alp-desc">No longer active. Moved to the archive and hidden from tenants.</div>
                    </div>
                    <div class="alp-title" style="margin-top:.65rem;">Priority Guide</div>
                    <div class="alp-row">
                        <div class="alp-dot-cell"><span class="ann-row-priority-dot prio-high"></span><span class="alp-dot-label" style="color:#e04867;">High</span></div>
                        <div class="alp-desc">Urgent or time-sensitive. Shown with a red indicator.</div>
                    </div>
                    <div class="alp-row">
                        <div class="alp-dot-cell"><span class="ann-row-priority-dot prio-moderate"></span><span class="alp-dot-label" style="color:#f59e0b;">Moderate</span></div>
                        <div class="alp-desc">Important but not urgent. Shown with an orange indicator.</div>
                    </div>
                    <div class="alp-row">
                        <div class="alp-dot-cell"><span class="ann-row-priority-dot prio-low"></span><span class="alp-dot-label" style="color:#1f9d69;">Low</span></div>
                        <div class="alp-desc">General information. Shown with a green indicator.</div>
                    </div>
                    <div class="alp-title" style="margin-top:.65rem;">Quick Actions</div>
                    <div class="alp-row">
                        <div class="alp-badge-cell" style="font-size:.7rem;font-weight:700;color:var(--ink-muted);">Close</div>
                        <div class="alp-desc">Archives the announcement. It can be reopened from the archive drawer.</div>
                    </div>
                    <div class="alp-row">
                        <div class="alp-badge-cell" style="font-size:.7rem;font-weight:700;color:var(--ink-muted);">Publish Now</div>
                        <div class="alp-desc">Immediately publishes a scheduled announcement ahead of its set time.</div>
                    </div>
                    <div class="alp-row">
                        <div class="alp-badge-cell" style="font-size:.7rem;font-weight:700;color:var(--ink-muted);">Reopen</div>
                        <div class="alp-desc">Sets a closed announcement back to active from the archive drawer.</div>
                    </div>
                </div>
            </div>
            <div class="ann-search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="ann-search-icon" alt="">
                <input type="text" id="ann-search-input" placeholder="Search announcements..." oninput="applyDropdownFilters()">
            </div>
        </div>
    </div>

    <div class="ann-main-layout fade-up d4">

        <div class="ann-list-panel" id="ann-list-panel">
            @php
                $merged = $announcements->merge($scheduled)
                    ->unique('announcement_id')
                    ->sortByDesc(function($a) {
                        return \Carbon\Carbon::parse(
                            $a->posted_at ?? $a->scheduled_at ?? $a->created_at
                        )->timestamp;
                    });
            @endphp
            @forelse($merged as $ann)
                @php $isScheduled = $ann->status === 'scheduled'; @endphp
                <div class="ann-row-card status-{{ $ann->status }}"
                     data-status="{{ $ann->status }}"
                     data-priority="{{ strtolower($ann->priority ?? 'low') }}"
                     data-posted="{{ $ann->posted_at ?? $ann->scheduled_at }}"
                     data-title="{{ strtolower($ann->title) }}"
                     data-content="{{ strtolower($ann->content) }}"
                     onclick="openViewModal({{ $ann->announcement_id }})">

                    <div class="ann-row-left">
                        <span class="ann-row-priority-dot prio-{{ strtolower($ann->priority ?? 'low') }}" title="{{ ucfirst($ann->priority ?? 'low') }} priority"></span>
                    </div>

                    <div class="ann-row-body">
                        <div class="ann-row-title">{{ $ann->title }}</div>
                        <div class="ann-row-excerpt">{{ $ann->content }}</div>
                        <div class="ann-row-meta">
                            <span class="ann-badge badge-{{ $ann->status }}">{{ ucfirst($ann->status) }}</span>
                            <span class="ann-badge badge-{{ strtolower($ann->priority ?? 'low') }}">{{ ucfirst($ann->priority ?? 'Low') }}</span>
                            @if($ann->attachment)
                                <span class="ann-meta-chip">
                                    <img src="{{ asset('icons/attach.png') }}" alt="">
                                    {{ count(explode(',', $ann->attachment)) }} file(s)
                                </span>
                            @endif
                            @if($isScheduled)
                                <span class="sched-inline-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ \Carbon\Carbon::parse($ann->scheduled_at)->format('M j · g:i A') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="ann-row-right">
                        <span class="ann-row-time">
                            {{ \Carbon\Carbon::parse($isScheduled ? $ann->scheduled_at : $ann->posted_at)->format('M j, Y') }}
                        </span>
                        <button class="ann-menu-btn"
                                onclick="toggleMenu(event, {{ $ann->announcement_id }})"
                                aria-label="Actions">···</button>
                    </div>
                </div>

                @if(!$isScheduled)
                    @if($ann->status !== 'closed')
                        <form id="close-{{ $ann->announcement_id }}" method="POST" action="{{ route('announcements.archive', $ann->announcement_id) }}" style="display:none;">@csrf</form>
                    @endif
                @else
                    <form id="publish-now-{{ $ann->announcement_id }}" method="POST" action="{{ route('announcements.restore', $ann->announcement_id) }}" style="display:none;">@csrf</form>
                @endif

            @empty
                <div class="ann-list-empty">
                    <img src="{{ asset('icons/announce.png') }}" alt="">
                    No announcements yet. Post your first one!
                </div>
            @endforelse

            <div class="ann-list-empty" id="ann-no-results" style="display:none;">
                <img src="{{ asset('icons/search.png') }}" alt="">
                No announcements match your search.
            </div>
        </div>

        <div class="ann-sidebar">

            <div class="ann-sidebar-card">
                <div class="ann-sidebar-header">
                    <div class="ann-sidebar-title">
                        <img src="{{ asset('icons/flag.png') }}" alt="">
                        Priority Breakdown
                    </div>
                </div>
                <div class="ann-sidebar-body">
                    @php
                        $all = $announcements->merge($scheduled);
                        $highCount = $all->where('priority','high')->count();
                        $modCount  = $all->where('priority','moderate')->count();
                        $lowCount  = $all->where('priority','low')->count();
                    @endphp
                    <div class="ann-prio-row">
                        <div class="ann-prio-label"><span class="dot" style="background:#e04867"></span> High</div>
                        <span class="ann-prio-count">{{ $highCount }}</span>
                    </div>
                    <div class="ann-prio-row">
                        <div class="ann-prio-label"><span class="dot" style="background:#f59e0b"></span> Moderate</div>
                        <span class="ann-prio-count">{{ $modCount }}</span>
                    </div>
                    <div class="ann-prio-row">
                        <div class="ann-prio-label"><span class="dot" style="background:#1f9d69"></span> Low</div>
                        <span class="ann-prio-count">{{ $lowCount }}</span>
                    </div>
                </div>
            </div>

            <div class="ann-sidebar-card">
                <div class="ann-sidebar-header">
                    <div class="ann-sidebar-title">
                        <img src="{{ asset('icons/clock.png') }}" alt="">
                        Scheduled
                    </div>
                    <span style="font-size:.72rem;font-weight:700;background:var(--petal);color:var(--hot-pink);padding:.12rem .5rem;border-radius:99px;border:1px solid var(--pink-100);">{{ $scheduled->count() }}</span>
                </div>
                <div class="ann-sidebar-body">
                    @forelse($scheduled->take(5) as $s)
                        <div class="ann-sched-item" onclick="openViewModal({{ $s->announcement_id }})">
                            <div class="ann-sched-title">{{ $s->title }}</div>
                            <div class="ann-sched-time">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ \Carbon\Carbon::parse($s->scheduled_at)->format('M j, Y · g:i A') }}
                            </div>
                        </div>
                    @empty
                        <div class="ann-sched-empty">No upcoming scheduled announcements.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('modals')

<div class="ann-dropdown" id="ann-global-dropdown"></div>

<div class="ann-archive-backdrop" id="aad-backdrop" onclick="closeAnnArchive()"></div>

<div class="ann-archive-drawer" id="aad-drawer">
    <div class="aad-header">
        <div>
            <div class="aad-title">Archive / History</div>
            <div class="aad-sub">Closed and deleted announcements</div>
        </div>
        <button class="aad-close" onclick="closeAnnArchive()">&#x2715;</button>
    </div>
    <div class="aad-tabs">
        <button class="aad-tab active" id="aad-tab-closed" onclick="switchAnnArchiveTab('closed')">
            Closed <span class="aad-tab-count" id="aad-count-closed">0</span>
        </button>
        <button class="aad-tab" id="aad-tab-deleted" onclick="switchAnnArchiveTab('deleted')">
            Deleted <span class="aad-tab-count" id="aad-count-deleted">0</span>
        </button>
    </div>
    <div class="aad-search-bar">
        <div class="aad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="aad-search-icon" alt="">
            <input type="text" id="aad-search" placeholder="Search archived announcements..." oninput="renderAnnArchive()">
        </div>
    </div>
    <div class="aad-list" id="aad-list"></div>
    <div class="aad-footer">
        <div class="aad-count-label" id="aad-count-label">0 records</div>
        <button class="aad-export-btn" onclick="exportAnnArchive()">
            <img src="{{ asset('icons/export.png') }}" alt=""> Export CSV
        </button>
    </div>
</div>

<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="modal-overlay" id="post-modal">
    <div class="modal">
        <div class="em-header">
            <div class="em-header-top">
                <div class="em-title-group">
                    <div class="em-icon"><img src="{{ asset('icons/announce.png') }}" alt=""></div>
                    <div>
                        <div class="em-title">Post New Announcement</div>
                        <div class="em-sub">Sanctissimo Rosario Ladies Dormitory</div>
                    </div>
                </div>
                <button class="em-close" onclick="closeModal('post-modal')">&#x2715;</button>
            </div>
            <div class="em-tabs">
                <button class="em-tab active" onclick="switchPostTab(0)" id="pm-tab-0"><img src="{{ asset('icons/edit.png') }}" alt=""> Content</button>
                <button class="em-tab" onclick="switchPostTab(1)" id="pm-tab-1"><img src="{{ asset('icons/flag.png') }}" alt=""> Settings</button>
                <button class="em-tab" onclick="switchPostTab(2)" id="pm-tab-2"><img src="{{ asset('icons/attach.png') }}" alt=""> Attachments</button>
            </div>
        </div>
        <form method="POST" action="{{ route('announcements.store') }}" id="post-form" enctype="multipart/form-data" data-loading-message="Please wait...">
            @csrf
            <div class="form-progress-wrap" id="post-progress-wrap">
                <div class="form-progress-label">
                    <span id="post-progress-text">Fill in required fields</span>
                    <span id="post-progress-count" class="partial"></span>
                </div>
                <div class="form-progress-bar">
                    <div class="form-progress-fill" id="post-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                </div>
            </div>
            <div class="em-panels">
                <div class="em-panel active" id="pm-panel-0">
                    <div class="modal-field">
                        <label>Title <span class="field-req-star">*</span></label>
                        <input type="text" name="title" id="post-title" placeholder="e.g. Water Interruption Notice" required>
                    </div>
                    <div class="modal-field">
                        <label>Content <span class="field-req-star">*</span></label>
                        <textarea name="content" id="post-content" placeholder="Write your announcement here..." required></textarea>
                    </div>
                </div>
                <div class="em-panel" id="pm-panel-1">
                    <div class="modal-field">
                        <label>Priority</label>
                        <div class="em-pill-row" id="post-priority-pills">
                            <span class="em-pill-opt sel-low" data-val="low" onclick="selectPostPill('priority','low')">Low</span>
                            <span class="em-pill-opt" data-val="moderate" onclick="selectPostPill('priority','moderate')">Moderate</span>
                            <span class="em-pill-opt" data-val="high" onclick="selectPostPill('priority','high')">High</span>
                        </div>
                        <input type="hidden" name="priority" id="post-priority" value="low">
                    </div>
                    <div class="modal-field" id="post-status-field">
                        <label>Status</label>
                        <div class="em-pill-row" id="post-status-pills">
                            <span class="em-pill-opt sel-active" data-val="active" onclick="selectPostPill('status','active')">Active</span>
                            <span class="em-pill-opt" data-val="closed" onclick="selectPostPill('status','closed')">Closed</span>
                        </div>
                        <input type="hidden" name="status" id="post-status" value="active">
                    </div>
                    <div class="schedule-toggle-row" onclick="toggleSchedule('post')">
                        <span class="schedule-toggle-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Schedule for later
                        </span>
                        <span class="schedule-toggle-switch" id="post-sched-switch"></span>
                    </div>
                    <div class="schedule-fields" id="post-sched-fields">
                        <div class="modal-field">
                            <label>Publish Date &amp; Time</label>
                            <input type="datetime-local" name="scheduled_at" id="post-scheduled-at">
                            <div class="schedule-note">The announcement will go live automatically at this time.</div>
                        </div>
                    </div>
                </div>
                <div class="em-panel" id="pm-panel-2">
                    <div class="em-file-zone">
                        <input type="file" name="files[]" id="post-files-input" multiple accept=".png,.jpg,.jpeg,.pdf,.docx" onchange="validateFileInput(this,'post-file-error')">
                        <div class="em-file-note">Accepted types: PNG, JPG, PDF, DOCX. Max 5 MB per file. Optional, up to 10 files.</div>
                        <div class="em-file-error" id="post-file-error"></div>
                    </div>
                </div>
            </div>
            <div class="em-footer">
                <div class="em-tab-nav">
                    <button type="button" class="em-nav-btn" id="pm-prev-btn" onclick="switchPostTab(window._pmTab - 1)" disabled>&#8592; Prev</button>
                    <button type="button" class="em-nav-btn" id="pm-next-btn" onclick="switchPostTab(window._pmTab + 1)">Next &#8594;</button>
                </div>
                <div class="em-footer-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('post-modal')">Cancel</button>
                    <button type="button" class="btn-submit" id="post-submit-btn" onclick="submitPostModal()">Post Announcement</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="em-header">
            <div class="em-header-top">
                <div class="em-title-group">
                    <div class="em-icon"><img src="{{ asset('icons/edit.png') }}" alt=""></div>
                    <div>
                        <div class="em-title">Edit Announcement</div>
                        <div class="em-sub" id="em-sub-label">Editing announcement</div>
                    </div>
                </div>
                <button class="em-close" onclick="closeModal('edit-modal')">&#x2715;</button>
            </div>
            <div class="em-tabs">
                <button class="em-tab active" onclick="switchTab(0)" id="em-tab-0"><img src="{{ asset('icons/edit.png') }}" alt=""> Content</button>
                <button class="em-tab" onclick="switchTab(1)" id="em-tab-1"><img src="{{ asset('icons/flag.png') }}" alt=""> Settings</button>
                <button class="em-tab" onclick="switchTab(2)" id="em-tab-2"><img src="{{ asset('icons/attach.png') }}" alt=""> Attachments</button>
            </div>
        </div>
        <form method="POST" id="edit-form" enctype="multipart/form-data" data-loading-message="Please wait...">
            @csrf @method('PUT')
            <div class="form-progress-wrap" id="edit-progress-wrap">
                <div class="form-progress-label">
                    <span id="edit-progress-text">Fill in required fields</span>
                    <span id="edit-progress-count" class="partial"></span>
                </div>
                <div class="form-progress-bar">
                    <div class="form-progress-fill" id="edit-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                </div>
            </div>
            <div class="em-panels">
                <div class="em-panel active" id="em-panel-0">
                    <div class="modal-field"><label>Title <span class="field-req-star">*</span></label><input type="text" name="title" id="edit-title" required placeholder="Announcement title"></div>
                    <div class="modal-field"><label>Content <span class="field-req-star">*</span></label><textarea name="content" id="edit-content" required placeholder="Write the full announcement here..."></textarea></div>
                </div>
                <div class="em-panel" id="em-panel-1">
                    <div class="modal-field">
                        <label>Priority</label>
                        <div class="em-pill-row" id="edit-priority-pills">
                            <span class="em-pill-opt" data-val="low" onclick="selectPill('priority','low')">Low</span>
                            <span class="em-pill-opt" data-val="moderate" onclick="selectPill('priority','moderate')">Moderate</span>
                            <span class="em-pill-opt" data-val="high" onclick="selectPill('priority','high')">High</span>
                        </div>
                        <input type="hidden" name="priority" id="edit-priority">
                    </div>
                    <div class="modal-field" id="edit-status-field">
                        <label>Status</label>
                        <div class="em-pill-row" id="edit-status-pills">
                            <span class="em-pill-opt" data-val="active" onclick="selectPill('status','active')">Active</span>
                            <span class="em-pill-opt" data-val="closed" onclick="selectPill('status','closed')">Closed</span>
                        </div>
                        <input type="hidden" name="status" id="edit-status">
                    </div>
                    <div class="schedule-toggle-row" onclick="toggleSchedule('edit')">
                        <span class="schedule-toggle-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Schedule for later
                        </span>
                        <span class="schedule-toggle-switch" id="edit-sched-switch"></span>
                    </div>
                    <div class="schedule-fields" id="edit-sched-fields">
                        <div class="modal-field">
                            <label>Publish Date &amp; Time</label>
                            <input type="datetime-local" name="scheduled_at" id="edit-scheduled-at">
                            <div class="schedule-note">The announcement will go live automatically at this time.</div>
                        </div>
                    </div>
                </div>
                <div class="em-panel" id="em-panel-2">
                    <div class="em-file-zone">
                        <input type="file" name="files[]" id="edit-files-input" multiple accept=".png,.jpg,.jpeg,.pdf,.docx" onchange="validateFileInput(this,'edit-file-error')">
                        <div class="em-file-note">Accepted types: PNG, JPG, PDF, DOCX. Max 5 MB per file. Up to 10 files.</div>
                        <div class="em-file-note" id="edit-current-files">No existing files.</div>
                        <div class="em-file-error" id="edit-file-error"></div>
                    </div>
                    <label class="em-replace-row">
                        <input type="checkbox" name="replace_attachments" value="1">
                        <span>Replace existing files with the new upload</span>
                    </label>
                </div>
            </div>
            <div class="em-footer">
                <div class="em-tab-nav">
                    <button type="button" class="em-nav-btn" id="em-prev-btn" onclick="switchTab(window._emTab - 1)" disabled>&#8592; Prev</button>
                    <button type="button" class="em-nav-btn" id="em-next-btn" onclick="switchTab(window._emTab + 1)">Next &#8594;</button>
                </div>
                <div class="em-footer-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
                    <button type="button" class="btn-submit" id="edit-submit-btn" onclick="submitEditModal()">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="em-header">
            <div class="em-header-top">
                <div class="em-title-group">
                    <div class="em-icon" id="view-em-icon"><img src="{{ asset('icons/announce.png') }}" alt=""></div>
                    <div>
                        <div class="em-title" id="view-modal-title">Announcement</div>
                        <div class="em-sub" id="view-em-sub">View details</div>
                    </div>
                </div>
                <button class="em-close" onclick="closeModal('view-modal')">&#x2715;</button>
            </div>
            <div class="em-tabs">
                <button class="em-tab active" onclick="switchViewTab(0)" id="vm-tab-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Details
                </button>
                <button class="em-tab" onclick="switchViewTab(1)" id="vm-tab-1"><img src="{{ asset('icons/edit.png') }}" alt=""> Content</button>
                <button class="em-tab" onclick="switchViewTab(2)" id="vm-tab-2"><img src="{{ asset('icons/flag.png') }}" alt=""> Settings</button>
                <button class="em-tab" onclick="switchViewTab(3)" id="vm-tab-3"><img src="{{ asset('icons/attach.png') }}" alt=""> Attachments</button>
            </div>
        </div>
        <div id="vm-details-panel" class="em-panels">
            <div class="em-panel active" id="vm-panel-0">
                <div id="view-modal-content"></div>
            </div>
        </div>
        <form method="POST" id="view-edit-form" enctype="multipart/form-data" data-loading-message="Please wait...">
            @csrf @method('PUT')
            <div class="form-progress-wrap" id="view-edit-progress-wrap" style="display:none;">
                <div class="form-progress-label">
                    <span id="view-edit-progress-text">Fill in required fields</span>
                    <span id="view-edit-progress-count" class="partial"></span>
                </div>
                <div class="form-progress-bar">
                    <div class="form-progress-fill" id="view-edit-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                </div>
            </div>
            <div class="em-panels" id="vm-edit-panels" style="display:none;">
                <div class="em-panel" id="vm-panel-1">
                    <div class="modal-field"><label>Title <span class="field-req-star">*</span></label><input type="text" name="title" id="view-edit-title" required></div>
                    <div class="modal-field"><label>Content <span class="field-req-star">*</span></label><textarea name="content" id="view-edit-content" required></textarea></div>
                </div>
                <div class="em-panel" id="vm-panel-2">
                    <div class="modal-field">
                        <label>Priority</label>
                        <div class="em-pill-row" id="view-edit-priority-pills">
                            <span class="em-pill-opt" data-val="low" onclick="selectViewPill('priority','low')">Low</span>
                            <span class="em-pill-opt" data-val="moderate" onclick="selectViewPill('priority','moderate')">Moderate</span>
                            <span class="em-pill-opt" data-val="high" onclick="selectViewPill('priority','high')">High</span>
                        </div>
                        <input type="hidden" name="priority" id="view-edit-priority">
                    </div>
                    <div class="modal-field">
                        <label>Status</label>
                        <div class="em-pill-row" id="view-edit-status-pills">
                            <span class="em-pill-opt" data-val="active" onclick="selectViewPill('status','active')">Active</span>
                            <span class="em-pill-opt" data-val="closed" onclick="selectViewPill('status','closed')">Closed</span>
                        </div>
                        <input type="hidden" name="status" id="view-edit-status">
                    </div>
                    <div class="schedule-toggle-row" onclick="toggleSchedule('view-edit')">
                        <span class="schedule-toggle-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Schedule for later
                        </span>
                        <span class="schedule-toggle-switch" id="view-edit-sched-switch"></span>
                    </div>
                    <div class="schedule-fields" id="view-edit-sched-fields">
                        <div class="modal-field">
                            <label>Publish Date &amp; Time</label>
                            <input type="datetime-local" name="scheduled_at" id="view-edit-scheduled-at">
                            <div class="schedule-note">The announcement will go live automatically at this time.</div>
                        </div>
                    </div>
                </div>
                <div class="em-panel" id="vm-panel-3">
                    <div class="em-file-zone">
                        <input type="file" name="files[]" id="view-edit-files-input" multiple accept=".png,.jpg,.jpeg,.pdf,.docx" onchange="validateFileInput(this,'view-edit-file-error')">
                        <div class="em-file-note">Accepted types: PNG, JPG, PDF, DOCX. Max 5 MB per file. Up to 10 files.</div>
                        <div class="em-file-note" id="view-current-files">No existing files.</div>
                        <div class="em-file-error" id="view-edit-file-error"></div>
                    </div>
                    <label class="em-replace-row">
                        <input type="checkbox" name="replace_attachments" value="1">
                        <span>Replace existing files with the new upload</span>
                    </label>
                </div>
            </div>
            <div class="em-footer" id="vm-edit-footer" style="display:none;">
                <div class="em-tab-nav">
                    <button type="button" class="em-nav-btn" id="vm-prev-btn" onclick="switchViewTab(window._vmTab - 1)" disabled>&#8592; Prev</button>
                    <button type="button" class="em-nav-btn" id="vm-next-btn" onclick="switchViewTab(window._vmTab + 1)">Next &#8594;</button>
                </div>
                <div class="em-footer-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('view-modal')">Cancel</button>
                    <button type="button" class="btn-submit" onclick="submitViewEditModal()">Save Changes</button>
                </div>
            </div>
        </form>
        <div class="em-footer" id="vm-details-footer">
            <div></div>
            <div class="em-footer-actions">
                <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
                <button class="btn-submit" onclick="enableViewEdit()">Edit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Delete Announcement</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">&#x2715;</button>
        </div>
        <div class="delete-warning">This action cannot be undone. The announcement will be permanently removed.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);">Are you sure you want to delete <strong id="delete-ann-name" style="color:var(--ink);"></strong>?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <form method="POST" id="delete-form" style="display:inline;" data-loading-message="Please wait...">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function() {
    var trigger = document.getElementById('ann-legend-trigger');
    var popup   = document.getElementById('ann-legend-popup');
    if (!trigger || !popup) return;

    document.body.appendChild(popup);

    var hideTimer = null;

    function positionPopup() {
        var rect       = trigger.getBoundingClientRect();
        var popupWidth = 340;
        var left       = rect.left;
        var top        = rect.bottom + 8;
        if (left + popupWidth > window.innerWidth - 12) left = window.innerWidth - popupWidth - 12;
        if (left < 12) left = 12;
        popup.style.left   = left + 'px';
        popup.style.top    = top + 'px';
        popup.style.right  = 'auto';
        popup.style.bottom = 'auto';
    }

    function showPopup() {
        clearTimeout(hideTimer);
        positionPopup();
        popup.classList.add('open');
    }

    function hidePopup() {
        hideTimer = setTimeout(function() { popup.classList.remove('open'); }, 180);
    }

    trigger.addEventListener('mouseenter', showPopup);
    trigger.addEventListener('mouseleave', hidePopup);
    popup.addEventListener('mouseenter', function() { clearTimeout(hideTimer); });
    popup.addEventListener('mouseleave', hidePopup);

    window.addEventListener('resize', function() { if (popup.classList.contains('open')) positionPopup(); });
    window.addEventListener('scroll', function() { if (popup.classList.contains('open')) positionPopup(); }, true);
})();
const annData           = @json($announcements->merge($scheduled)->keyBy('announcement_id'));
const deletedAnnArchive = @json($deletedArchive);
const closedAnnArchive  = @json($closedArchive);
const storageBaseUrl    = "{{ asset('storage') }}";
const editIcon          = "{{ asset('icons/edit.png') }}";
const announceIcon      = "{{ asset('icons/announce.png') }}";
const archiveIcon       = "{{ asset('icons/archive.png') }}";
const deleteIcon        = "{{ asset('icons/delete.png') }}";
const attachIcon        = "{{ asset('icons/attach.png') }}";
const archiveIconAsset  = "{{ asset('icons/archive.png') }}";

(function buildAadd() {
    const backdrop = document.createElement('div');
    backdrop.id = 'aadd-backdrop';
    backdrop.onclick = closeAnnArchiveDetail;

    const modal = document.createElement('div');
    modal.id = 'aadd-modal';
    modal.innerHTML = `
        <div class="aadd-header">
            <div class="aadd-header-top">
                <div style="display:flex;align-items:center;gap:.65rem;">
                    <div class="aadd-icon">
                        <img src="${archiveIconAsset}" alt="">
                    </div>
                    <div>
                        <div class="aadd-title" id="aadd-title">Archived Announcement</div>
                        <div class="aadd-sub" id="aadd-sub">Deleted record</div>
                    </div>
                </div>
                <button class="aadd-close" onclick="closeAnnArchiveDetail()">&#x2715;</button>
            </div>
        </div>
        <div class="aadd-body" id="aadd-body"></div>
        <div class="aadd-footer" style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;">
            <div id="aadd-reopen-wrap"></div>
            <button class="btn-cancel" onclick="closeAnnArchiveDetail()">Close</button>
        </div>
    `;

    document.body.appendChild(backdrop);
    document.body.appendChild(modal);
})();

const _autoPublishedIds = new Set();

function checkScheduledAnnouncements() {
    const now = new Date();
    Object.values(annData).forEach(ann => {
        if (ann.status !== 'scheduled' || !ann.scheduled_at) return;
        if (_autoPublishedIds.has(ann.announcement_id)) return;
        const scheduledTime = new Date(ann.scheduled_at);
        if (scheduledTime <= now) {
            _autoPublishedIds.add(ann.announcement_id);
            const form = document.getElementById('publish-now-' + ann.announcement_id);
            if (form) { showActionLoading('Publishing scheduled announcement...'); form.submit(); }
        }
    });
}

checkScheduledAnnouncements();
setInterval(checkScheduledAnnouncements, 30000);

(function() {
    const pollUrl = "{{ route('announcements.poll') }}";
    const fetchUrl = "{{ route('announcements.index') }}";
    let lastSignature = null;
    let pollTimer = null;
    let inFlight = false;

    function isAnnBusy() {
        if (document.querySelector('.modal-overlay.open')) return true;
        if (document.getElementById('aad-drawer').classList.contains('open')) return true;
        if (document.getElementById('aadd-modal').classList.contains('open')) return true;
        if (globalDropdown.classList.contains('open')) return true;

        const active = document.activeElement;
        if (active && active !== document.body) {
            const tag = active.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return true;
        }
        return false;
    }

    function showAnnPollToast() {
        const existing = document.getElementById('ann-poll-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'ann-poll-toast';
        toast.style.cssText = `
            position:fixed;bottom:1.2rem;left:50%;transform:translateX(-50%);
            background:#fff;border:1.5px solid var(--pink-100);
            border-radius:10px;padding:.45rem 1rem;font-size:.78rem;font-weight:600;
            color:var(--ink-muted);box-shadow:0 4px 16px rgba(232,23,93,.1);
            z-index:2000;opacity:0;transition:opacity .3s;white-space:nowrap;
            pointer-events:none;
        `;
        toast.textContent = 'Announcements refreshed';
        document.body.appendChild(toast);
        requestAnimationFrame(() => { toast.style.opacity = '1'; });
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

    async function softReloadAnnouncements() {
        try {
            const res = await fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) return;
            const html = await res.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');

            const freshListPanel = doc.getElementById('ann-list-panel');
            const currentListPanel = document.getElementById('ann-list-panel');
            if (freshListPanel && currentListPanel) {
                currentListPanel.innerHTML = freshListPanel.innerHTML;
            }

            const freshSidebar = doc.querySelector('.ann-sidebar');
            const currentSidebar = document.querySelector('.ann-sidebar');
            if (freshSidebar && currentSidebar) {
                currentSidebar.innerHTML = freshSidebar.innerHTML;
            }

            const freshStats = doc.querySelector('.ann-stats-row');
            const currentStats = document.querySelector('.ann-stats-row');
            if (freshStats && currentStats) {
                currentStats.innerHTML = freshStats.innerHTML;
            }

            const freshScript = Array.from(doc.querySelectorAll('script')).find(s =>
                s.textContent.includes('const annData ')
            );
            if (freshScript) {
                const annMatch = freshScript.textContent.match(/const annData\s*=\s*(\{[\s\S]*?\});/);
                const closedMatch = freshScript.textContent.match(/const closedAnnArchive\s*=\s*(\[[\s\S]*?\]);/);
                const deletedMatch = freshScript.textContent.match(/const deletedAnnArchive\s*=\s*(\[[\s\S]*?\]);/);

                if (annMatch) {
                    const fresh = JSON.parse(annMatch[1]);
                    Object.keys(annData).forEach(k => delete annData[k]);
                    Object.assign(annData, fresh);
                }
                if (closedMatch) {
                    closedAnnArchive.length = 0;
                    closedAnnArchive.push(...JSON.parse(closedMatch[1]));
                }
                if (deletedMatch) {
                    deletedAnnArchive.length = 0;
                    deletedAnnArchive.push(...JSON.parse(deletedMatch[1]));
                }
            }

            applyDropdownFilters();
            showAnnPollToast();
        } catch {
        }
    }

    async function pollAnnouncements() {
        if (inFlight || isAnnBusy()) return;
        inFlight = true;
        try {
            const res = await fetch(pollUrl, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();

            if (lastSignature === null) {
                lastSignature = data.signature;
                return;
            }
            if (data.signature !== lastSignature) {
                lastSignature = data.signature;
                if (!isAnnBusy()) await softReloadAnnouncements();
            }
        } catch {
        } finally {
            inFlight = false;
        }
    }

    function startPolling() {
        if (pollTimer) return;
        pollTimer = setInterval(pollAnnouncements, 15000);
    }

    function stopPolling() {
        if (pollTimer) {
            clearInterval(pollTimer);
            pollTimer = null;
        }
    }

    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopPolling();
        } else {
            startPolling();
            pollAnnouncements();
        }
    });

    startPolling();
})();

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});

document.querySelectorAll('form[data-loading-message]').forEach(form => {
    form.addEventListener('submit', () => setFormLoading(form, form.dataset.loadingMessage || 'Processing...'));
});

const globalDropdown = document.getElementById('ann-global-dropdown');
let activeMenuId = null;

function buildDropdownHTML(id, ann) {
    var isScheduled = ann.status === 'scheduled';
    var middle = '';
    if (isScheduled) {
        middle = '<button class="ann-dropdown-item" onclick="submitForm(\'publish-now-' + id + '\',event)"><img class="dd-icon" src="' + announceIcon + '" alt=""> Publish Now</button>';
    } else {
        middle = '<button class="ann-dropdown-item" onclick="submitForm(\'close-' + id + '\',event)"><img class="dd-icon" src="' + archiveIcon + '" alt=""> Close</button>';
    }
    return '<button class="ann-dropdown-item" onclick="openEditModal(' + id + ',event)"><img class="dd-icon" src="' + editIcon + '" alt=""> Edit</button>'
        + middle
        + '<div class="ann-dropdown-divider"></div>'
        + '<button class="ann-dropdown-item danger" onclick="openDeleteModal(' + id + ',\'' + escapeHtml(ann.title || '').replace(/'/g, "\\'") + '\',event)"><img class="dd-icon" src="' + deleteIcon + '" alt=""> Delete</button>';
}

function toggleMenu(e, id) {
    e.stopPropagation();
    if (activeMenuId === id) { closeGlobalDropdown(); return; }
    activeMenuId = id;
    const ann = annData[id];
    if (!ann) return;
    const btn = e.currentTarget;
    document.querySelectorAll('.ann-menu-btn.active').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    globalDropdown.innerHTML = buildDropdownHTML(id, ann);
    globalDropdown.classList.add('open');
    positionDropdown(btn);
}

function positionDropdown(btn) {
    const rect = btn.getBoundingClientRect();
    const ddW  = 170;
    let left   = rect.right - ddW;
    let top    = rect.bottom + 6;
    if (left < 8) left = 8;
    if (top + 140 > window.innerHeight) top = rect.top - 140;
    globalDropdown.style.left = left + 'px';
    globalDropdown.style.top  = top + 'px';
}

function closeGlobalDropdown() {
    globalDropdown.classList.remove('open');
    globalDropdown.innerHTML = '';
    document.querySelectorAll('.ann-menu-btn.active').forEach(b => b.classList.remove('active'));
    activeMenuId = null;
}

document.addEventListener('click', e => {
    if (!globalDropdown.contains(e.target) && !e.target.classList.contains('ann-menu-btn')) closeGlobalDropdown();
});
window.addEventListener('scroll', () => { if (activeMenuId !== null) closeGlobalDropdown(); }, true);
window.addEventListener('resize', () => { if (activeMenuId !== null) closeGlobalDropdown(); });

function applyDropdownFilters(changedEl) {
    if (changedEl) changedEl.classList.toggle('has-value', changedEl.value !== '');
    const status   = document.getElementById('filter-status').value;
    const priority = document.getElementById('filter-priority').value;
    const date     = document.getElementById('filter-date').value;
    const q        = document.getElementById('ann-search-input').value.toLowerCase();
    const now      = new Date();
    let weekStart, weekEnd;
    if (date === 'this_week') {
        weekStart = new Date(now); weekStart.setDate(now.getDate() - now.getDay()); weekStart.setHours(0,0,0,0);
        weekEnd   = new Date(weekStart); weekEnd.setDate(weekStart.getDate() + 6); weekEnd.setHours(23,59,59,999);
    } else if (date === 'last_week') {
        weekEnd   = new Date(now); weekEnd.setDate(now.getDate() - now.getDay() - 1); weekEnd.setHours(23,59,59,999);
        weekStart = new Date(weekEnd); weekStart.setDate(weekEnd.getDate() - 6); weekStart.setHours(0,0,0,0);
    } else if (date === 'two_weeks') {
        weekStart = new Date(now); weekStart.setDate(now.getDate() - 13); weekStart.setHours(0,0,0,0);
        weekEnd   = now;
    } else if (date === 'this_month') {
        weekStart = new Date(now.getFullYear(), now.getMonth(), 1);
        weekEnd   = now;
    }
    document.querySelectorAll('.ann-row-card').forEach(card => {
        const cardStatus   = card.dataset.status;
        const cardPriority = card.dataset.priority;
        const cardPosted   = new Date(card.dataset.posted);
        const cardTitle    = card.dataset.title   || '';
        const cardContent  = card.dataset.content || '';
        let show = true;
        if (status && cardStatus !== status) show = false;
        if (priority && cardPriority !== priority) show = false;
        if (date && weekStart && weekEnd && (cardPosted < weekStart || cardPosted > weekEnd)) show = false;
        if (q && !cardTitle.includes(q) && !cardContent.includes(q)) show = false;
        card.style.display = show ? '' : 'none';
    });
    updateEmptyState();
}

function updateEmptyState() {
    const visible = document.querySelectorAll('.ann-row-card:not([style*="display: none"])').length;
    document.getElementById('ann-no-results').style.display = visible === 0 ? '' : 'none';
}

function submitForm(formId, e) {
    e.stopPropagation();
    closeGlobalDropdown();
    showActionLoading('Please wait...');
    document.getElementById(formId).submit();
}

function setFormLoading(form, message) { showActionLoading(message); }

function showActionLoading(message) {
    const overlay = document.getElementById('action-loading');
    document.getElementById('action-loading-text').textContent = message;
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
}

function toggleSchedule(prefix, forceState) {
    const sw     = document.getElementById(prefix + '-sched-switch');
    const fields = document.getElementById(prefix + '-sched-fields');
    const input  = document.getElementById(prefix + '-scheduled-at');
    const turnOn = forceState !== undefined ? forceState : !sw.classList.contains('on');
    if (turnOn) {
        sw.classList.add('on'); fields.classList.add('open'); input.required = true;
        ['post','edit'].forEach(p => { if (prefix === p) { const sf = document.getElementById(p + '-status-field'); if (sf) sf.style.display = 'none'; } });
    } else {
        sw.classList.remove('on'); fields.classList.remove('open'); input.required = false; input.value = '';
        ['post','edit'].forEach(p => { if (prefix === p) { const sf = document.getElementById(p + '-status-field'); if (sf) sf.style.display = ''; } });
    }
}

window._pmTab = 0;
const PM_TABS = 3;
function switchPostTab(idx) {
    if (idx < 0 || idx >= PM_TABS) return;
    window._pmTab = idx;
    for (let i = 0; i < PM_TABS; i++) {
        document.getElementById('pm-tab-' + i).classList.toggle('active', i === idx);
        document.getElementById('pm-panel-' + i).classList.toggle('active', i === idx);
    }
    document.getElementById('pm-prev-btn').disabled = (idx === 0);
    document.getElementById('pm-next-btn').disabled = (idx === PM_TABS - 1);
}
function selectPostPill(type, val) {
    const row = document.getElementById('post-' + type + '-pills');
    row.querySelectorAll('.em-pill-opt').forEach(p => { p.className = 'em-pill-opt'; if (p.dataset.val === val) p.classList.add('sel-' + val); });
    document.getElementById('post-' + type).value = val;
}
const ALLOWED_FILE_TYPES = ['image/png','image/jpeg','application/pdf','application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
const ALLOWED_EXTENSIONS = ['png','jpg','jpeg','pdf','docx'];
const MAX_FILE_SIZE_BYTES = 5 * 1024 * 1024;
const MAX_FILE_COUNT = 10;

function validateFileInput(input, errorId) {
    const errorBox = document.getElementById(errorId);
    const zone      = input.closest('.em-file-zone');
    const files     = Array.from(input.files || []);
    let message     = '';

    if (files.length > MAX_FILE_COUNT) {
        message = 'You can attach up to ' + MAX_FILE_COUNT + ' files at a time.';
    } else {
        for (const file of files) {
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            if (!ALLOWED_EXTENSIONS.includes(ext)) {
                message = '"' + file.name + '" is not a supported file type. Use PNG, JPG, PDF, or DOCX.';
                break;
            }
            if (file.size > MAX_FILE_SIZE_BYTES) {
                message = '"' + file.name + '" is too large. Maximum size is 5 MB per file.';
                break;
            }
        }
    }

    if (message) {
        errorBox.textContent = message;
        errorBox.classList.add('show');
        zone.classList.add('has-error');
        input.value = '';
        return false;
    }

    errorBox.textContent = '';
    errorBox.classList.remove('show');
    zone.classList.remove('has-error');
    return true;
}
function submitPostModal() {
    const form = document.getElementById('post-form');
    if (!form.checkValidity()) { form.reportValidity(); return; }
    if (!validateFileInput(document.getElementById('post-files-input'), 'post-file-error')) return;
    setFormLoading(form, 'Posting...'); form.submit();
}
function openPostModal() {
    document.getElementById('post-form').reset();
    selectPostPill('priority', 'low');
    selectPostPill('status', 'active');
    toggleSchedule('post', false);
    switchPostTab(0);
    openModal('post-modal');
    setTimeout(function() { updateAnnFormProgress('post', ['post-title', 'post-content']); }, 50);
}

window._emTab = 0;
const EM_TABS = 3;
function switchTab(idx) {
    if (idx < 0 || idx >= EM_TABS) return;
    window._emTab = idx;
    for (let i = 0; i < EM_TABS; i++) {
        document.getElementById('em-tab-' + i).classList.toggle('active', i === idx);
        document.getElementById('em-panel-' + i).classList.toggle('active', i === idx);
    }
    document.getElementById('em-prev-btn').disabled = (idx === 0);
    document.getElementById('em-next-btn').disabled = (idx === EM_TABS - 1);
}
function selectPill(type, val) {
    const row = document.getElementById('edit-' + type + '-pills');
    row.querySelectorAll('.em-pill-opt').forEach(p => { p.className = 'em-pill-opt'; if (p.dataset.val === val) p.classList.add('sel-' + val); });
    document.getElementById('edit-' + type).value = val;
}
function openEditModal(id, e) {
    if (e) e.stopPropagation();
    closeGlobalDropdown();
    const ann = annData[id];
    if (!ann) return;
    document.getElementById('edit-form').reset();
    setTimeout(function() { updateAnnFormProgress('edit', ['edit-title', 'edit-content']); }, 50);
    document.getElementById('edit-form').action = '{{ url("announcements") }}/' + id;
    document.getElementById('edit-title').value   = ann.title   || '';
    document.getElementById('edit-content').value = ann.content || '';
    document.getElementById('edit-current-files').textContent = filesNote(ann.attachment);
    document.getElementById('em-sub-label').textContent = `#${id} · ${(ann.title || '').slice(0,42)}`;
    selectPill('priority', ann.priority || 'low');
    selectPill('status',   ann.status   || 'active');
    switchTab(0);
    const isScheduled = ann.status === 'scheduled' && ann.scheduled_at;
    if (isScheduled) {
        const dt = new Date(ann.scheduled_at);
        document.getElementById('edit-scheduled-at').value = new Date(dt.getTime() - dt.getTimezoneOffset() * 60000).toISOString().slice(0,16);
        toggleSchedule('edit', true);
    } else {
        toggleSchedule('edit', false);
    }
    openModal('edit-modal');
}
function submitEditModal() {
    const form = document.getElementById('edit-form');
    if (!form.checkValidity()) { form.reportValidity(); return; }
    if (!validateFileInput(document.getElementById('edit-files-input'), 'edit-file-error')) return;
    setFormLoading(form, 'Saving changes...'); form.submit();
}

window._vmTab = 0;
const VM_TABS = 4;
let _vmEditOn = false;
function switchViewTab(idx) {
    if (idx < 0 || idx >= VM_TABS) return;
    if (idx === 0 && _vmEditOn) return;
    window._vmTab = idx;
    for (let i = 0; i < VM_TABS; i++) document.getElementById('vm-tab-' + i).classList.toggle('active', i === idx);
    if (idx === 0) {
        document.getElementById('vm-details-panel').style.display  = '';
        document.getElementById('vm-edit-panels').style.display    = 'none';
        document.getElementById('vm-details-footer').style.display = '';
        document.getElementById('vm-edit-footer').style.display    = 'none';
    } else {
        document.getElementById('vm-details-panel').style.display  = 'none';
        document.getElementById('vm-edit-panels').style.display    = '';
        document.getElementById('vm-details-footer').style.display = 'none';
        document.getElementById('vm-edit-footer').style.display    = '';
        for (let i = 1; i < VM_TABS; i++) document.getElementById('vm-panel-' + i).classList.toggle('active', i === idx);
        document.getElementById('vm-prev-btn').disabled = (idx === 1);
        document.getElementById('vm-next-btn').disabled = (idx === VM_TABS - 1);
    }
}
function enableViewEdit() {
    _vmEditOn = true;
    document.getElementById('vm-tab-0').classList.remove('active');
    switchViewTab(1);
    var bar = document.getElementById('view-edit-progress-wrap');
    if (bar) bar.style.display = '';
    updateAnnFormProgress('view-edit', ['view-edit-title', 'view-edit-content']);
}
function selectViewPill(type, val) {
    const row = document.getElementById('view-edit-' + type + '-pills');
    row.querySelectorAll('.em-pill-opt').forEach(p => { p.className = 'em-pill-opt'; if (p.dataset.val === val) p.classList.add('sel-' + val); });
    document.getElementById('view-edit-' + type).value = val;
}
function openViewModal(id) {
    const ann = annData[id];
    if (!ann) return;
    _vmEditOn = false; window._vmTab = 0;
    var bar = document.getElementById('view-edit-progress-wrap');
    if (bar) bar.style.display = 'none';
    for (let i = 0; i < VM_TABS; i++) document.getElementById('vm-tab-' + i).classList.toggle('active', i === 0);
    for (let i = 1; i < VM_TABS; i++) document.getElementById('vm-panel-' + i).classList.remove('active');
    document.getElementById('vm-panel-0').classList.add('active');
    document.getElementById('vm-details-panel').style.display  = '';
    document.getElementById('vm-edit-panels').style.display    = 'none';
    document.getElementById('vm-details-footer').style.display = '';
    document.getElementById('vm-edit-footer').style.display    = 'none';
    document.getElementById('view-modal-title').textContent = ann.title;
    document.getElementById('view-em-sub').textContent = ucFirst(ann.priority || 'low') + ' priority · ' + ucFirst(ann.status || 'active');
    const isScheduled = ann.status === 'scheduled' && ann.scheduled_at;
    document.getElementById('view-modal-content').innerHTML = `
        <div class="view-title">${escapeHtml(ann.title || '')}</div>
        <div class="view-row"><span class="view-label">Priority</span><span class="view-val"><span class="ann-badge badge-${(ann.priority||'low').toLowerCase()}">${ucFirst(ann.priority||'low')}</span></span></div>
        <div class="view-row"><span class="view-label">Status</span><span class="view-val"><span class="ann-badge badge-${ann.status||'active'}">${ucFirst(ann.status||'active')}</span></span></div>
        ${isScheduled
            ? `<div class="view-row"><span class="view-label">Posted</span><span class="view-val">${formatDate(ann.posted_at || ann.scheduled_at || ann.created_at)}</span></div>
               <div class="view-row"><span class="view-label">Scheduled For</span><span class="view-val" style="color:var(--hot-pink);">${formatDate(ann.scheduled_at)}</span></div>`
            : `<div class="view-row"><span class="view-label">Posted</span><span class="view-val">${formatDate(ann.posted_at || ann.scheduled_at || ann.created_at)}</span></div>`}
        <div class="view-content">${escapeHtml(ann.content || '')}</div>
        ${renderInlineAttachments(ann.attachment)}
    `;
    document.getElementById('view-edit-form').action = '{{ url("announcements") }}/' + id;
    document.getElementById('view-edit-title').value   = ann.title   || '';
    document.getElementById('view-edit-content').value = ann.content || '';
    document.getElementById('view-current-files').textContent = filesNote(ann.attachment);
    selectViewPill('priority', ann.priority || 'low');
    selectViewPill('status',   ann.status   || 'active');
    if (isScheduled) {
        const dt = new Date(ann.scheduled_at);
        document.getElementById('view-edit-scheduled-at').value = new Date(dt.getTime() - dt.getTimezoneOffset() * 60000).toISOString().slice(0,16);
        toggleSchedule('view-edit', true);
    } else { toggleSchedule('view-edit', false); }
    openModal('view-modal');
}
function submitViewEditModal() {
    const form = document.getElementById('view-edit-form');
    if (!form.checkValidity()) { form.reportValidity(); return; }
    if (!validateFileInput(document.getElementById('view-edit-files-input'), 'view-edit-file-error')) return;
    setFormLoading(form, 'Saving changes...'); form.submit();
}
function openDeleteModal(id, name, e) {
    if (e) e.stopPropagation();
    closeGlobalDropdown();
    document.getElementById('delete-ann-name').textContent = name;
    document.getElementById('delete-form').action = '{{ url("announcements") }}/' + id;
    openModal('delete-modal');
}

function ucFirst(str) { return str ? str.charAt(0).toUpperCase() + str.slice(1) : ''; }

function updateAnnFormProgress(prefix, fieldIds) {
    var filled = fieldIds.filter(function(id) {
        var el = document.getElementById(id);
        return el && el.value && el.value.trim() !== '';
    }).length;
    var total = fieldIds.length;
    var pct   = total > 0 ? Math.round((filled / total) * 100) : 0;
    var fill  = document.getElementById(prefix + '-progress-fill');
    var text  = document.getElementById(prefix + '-progress-text');
    var count = document.getElementById(prefix + '-progress-count');
    if (!fill) return;
    fill.style.width = pct + '%';
    if (pct === 100) {
        fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
        if (text)  { text.textContent = 'All required fields filled'; text.className = 'ready'; }
        if (count) { count.textContent = filled + '/' + total; count.className = 'ready'; }
    } else {
        fill.style.background = 'var(--gradient-pink)';
        if (text)  { text.textContent = 'Fill in required fields'; text.className = ''; }
        if (count) { count.textContent = filled + '/' + total; count.className = 'partial'; }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var postFields = ['post-title', 'post-content'];
    var postModalEl = document.getElementById('post-modal');
    if (postModalEl) {
        postModalEl.addEventListener('input', function() { updateAnnFormProgress('post', postFields); });
        updateAnnFormProgress('post', postFields);
    }

    var editFields = ['edit-title', 'edit-content'];
    var editModalEl = document.getElementById('edit-modal');
    if (editModalEl) {
        editModalEl.addEventListener('input', function() { updateAnnFormProgress('edit', editFields); });
    }

    var viewEditFields = ['view-edit-title', 'view-edit-content'];
    var viewModalEl = document.getElementById('view-modal');
    if (viewModalEl) {
        viewModalEl.addEventListener('input', function() { updateAnnFormProgress('view-edit', viewEditFields); });
    }
});

function getAttachments(att) {
    if (!att) return [];
    return String(att).split(',').map(p => p.trim()).filter(Boolean);
}
function filesNote(att) {
    const total = getAttachments(att).length;
    return total ? `${total} existing file(s). Upload new to add, or tick replace to change.` : 'No files attached yet.';
}
function renderAttachments(att) {
    const files = getAttachments(att);
    if (!files.length) return '<div class="current-files-note">No files attached.</div>';
    return `<div class="attachment-grid">${files.map(path => {
        const url  = `${storageBaseUrl}/${encodeURI(path)}`;
        const name = path.split('/').pop();
        if (/\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(path))
            return `<div class="attachment-card"><a href="${url}" target="_blank"><img src="${url}" alt="${escapeHtml(name)}"></a></div>`;
        return `<div class="attachment-card"><a class="attachment-link" href="${url}" target="_blank"><img src="${attachIcon}" alt=""> ${escapeHtml(name)}</a></div>`;
    }).join('')}</div>`;
}
function renderInlineAttachments(att) {
    const files = getAttachments(att);
    if (!files.length) return '';
    const imgs = files.filter(p => /\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(p));
    const docs = files.filter(p => !/\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(p));
    let html = `<div style="margin-top:1.1rem;border-top:1px solid var(--pink-100);padding-top:.85rem;">`;
    html += `<div style="font-size:.7rem;font-weight:800;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.6rem;">Attachments (${files.length})</div>`;
    if (imgs.length) {
        html += `<div style="display:flex;gap:.55rem;flex-wrap:wrap;margin-bottom:.55rem;">`;
        imgs.forEach(path => {
            const url  = `${storageBaseUrl}/${encodeURI(path)}`;
            const name = path.split('/').pop();
            html += `<div style="position:relative;width:80px;height:80px;border-radius:10px;overflow:hidden;border:1.5px solid var(--pink-100);cursor:pointer;flex-shrink:0;" onclick="openImagePreview('${url}','${escapeHtml(name)}')" title="${escapeHtml(name)}">`;
            html += `<img src="${url}" alt="${escapeHtml(name)}" style="width:100%;height:100%;object-fit:cover;display:block;">`;
            html += `<div style="position:absolute;inset:0;background:rgba(0,0,0,0);display:flex;align-items:center;justify-content:center;transition:background .18s;" onmouseover="this.style.background='rgba(0,0,0,.38)';this.querySelector('span').style.opacity=1" onmouseout="this.style.background='rgba(0,0,0,0)';this.querySelector('span').style.opacity=0"><span style="opacity:0;transition:opacity .18s;font-size:.65rem;font-weight:800;color:#fff;background:rgba(0,0,0,.55);padding:.18rem .5rem;border-radius:6px;">Preview</span></div>`;
            html += `</div>`;
        });
        html += `</div>`;
    }
    if (docs.length) {
        html += `<div style="display:flex;flex-direction:column;gap:.35rem;">`;
        docs.forEach(path => {
            const url  = `${storageBaseUrl}/${encodeURI(path)}`;
            const name = path.split('/').pop();
            html += `<a href="${url}" target="_blank" style="display:inline-flex;align-items:center;gap:.4rem;font-size:.78rem;font-weight:600;color:var(--hot-pink);text-decoration:none;padding:.35rem .7rem;border-radius:8px;border:1px solid var(--pink-100);background:var(--petal);width:fit-content;"><img src="${attachIcon}" alt="" style="width:13px;height:13px;"> ${escapeHtml(name)}</a>`;
        });
        html += `</div>`;
    }
    html += `</div>`;
    return html;
}
function openImagePreview(url, name) {
    let lb = document.getElementById('ann-lightbox');
    if (!lb) {
        lb = document.createElement('div');
        lb.id = 'ann-lightbox';
        lb.style.cssText = 'position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.82);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.75rem;cursor:zoom-out;';
        lb.innerHTML = `<button onclick="document.getElementById('ann-lightbox').style.display='none'" style="position:absolute;top:1rem;right:1.2rem;background:rgba(255,255,255,.15);border:none;color:#fff;font-size:1.3rem;width:36px;height:36px;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;">&#x2715;</button><img id="ann-lb-img" src="" alt="" style="max-width:90vw;max-height:80vh;border-radius:10px;object-fit:contain;box-shadow:0 20px 60px rgba(0,0,0,.5);"><a id="ann-lb-link" href="" target="_blank" style="font-size:.78rem;color:rgba(255,255,255,.75);text-decoration:underline;"></a>`;
        lb.addEventListener('click', e => { if (e.target === lb) lb.style.display = 'none'; });
        document.body.appendChild(lb);
    }
    document.getElementById('ann-lb-img').src = url;
    document.getElementById('ann-lb-img').alt = name;
    document.getElementById('ann-lb-link').href = url;
    document.getElementById('ann-lb-link').textContent = name;
    lb.style.display = 'flex';
}
function formatDate(value) {
    if (!value) return '';
    const d = new Date(value);
    return isNaN(d) ? value : d.toLocaleString([], { year:'numeric', month:'long', day:'numeric', hour:'numeric', minute:'2-digit' });
}
function escapeHtml(v) {
    return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}
function fmtDate(d) {
    if (!d) return '—';
    return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month:'short', day:'numeric', year:'numeric' });
}
function fmtDatePlain(d) {
    if (!d) return '—';
    const dt = new Date(d);
    return dt.toLocaleDateString('en-US', { month:'2-digit', day:'2-digit', year:'numeric' }) + ' ' +
           dt.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit', hour12:true });
}

var _annArchiveTab = 'closed';

function openAnnArchive() {
    document.getElementById('aad-drawer').classList.add('open');
    document.getElementById('aad-backdrop').classList.add('open');
    document.getElementById('aad-search').value = '';
    document.getElementById('aad-count-closed').textContent  = closedAnnArchive.length;
    document.getElementById('aad-count-deleted').textContent = deletedAnnArchive.length;
    renderAnnArchive();
}

function closeAnnArchive() {
    document.getElementById('aad-drawer').classList.remove('open');
    document.getElementById('aad-backdrop').classList.remove('open');
}

function switchAnnArchiveTab(tab) {
    _annArchiveTab = tab;
    document.getElementById('aad-tab-closed').classList.toggle('active',  tab === 'closed');
    document.getElementById('aad-tab-deleted').classList.toggle('active', tab === 'deleted');
    document.getElementById('aad-search').value = '';
    renderAnnArchive();
}

function renderAnnArchive() {
    var q      = document.getElementById('aad-search').value.toLowerCase();
    var source = _annArchiveTab === 'closed' ? closedAnnArchive : deletedAnnArchive;
    var data   = source.filter(function(r) {
        return (r.title    || '').toLowerCase().indexOf(q) !== -1 ||
               (r.content  || '').toLowerCase().indexOf(q) !== -1 ||
               (r.priority || '').toLowerCase().indexOf(q) !== -1;
    });
    var list = document.getElementById('aad-list');
    document.getElementById('aad-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');
    if (!data.length) {
        list.innerHTML = '<div class="aad-empty"><img src="' + announceIcon + '" alt="">No ' + _annArchiveTab + ' announcements found.</div>';
        return;
    }
    list.innerHTML = data.map(function(r, i) {
        var dateLabel    = _annArchiveTab === 'closed' ? 'Posted' : 'Deleted on';
        var dateValue    = _annArchiveTab === 'closed'
            ? (r.posted_at ? fmtDatePlain(r.posted_at) : '—')
            : fmtDatePlain(r.deleted_at);
        var dateColor    = _annArchiveTab === 'deleted' ? 'color:#e04867;' : '';
        var attachCount  = r.attachment ? r.attachment.split(',').length : 0;
        return '<div class="aad-card" style="animation-delay:' + (i * 0.04) + 's;" onclick=\'openAnnArchiveDetail(' + JSON.stringify(r).replace(/</g,'\\u003c').replace(/'/g,'\\u0027') + ')\'>'
            + '<div class="aad-card-top">'
                + '<div class="aad-card-id">#' + r.announcement_id + '</div>'
                + '<div class="aad-card-time">' + (r.posted_at ? fmtDate(r.posted_at.split('T')[0]) : (r.scheduled_at ? fmtDate(r.scheduled_at.split('T')[0]) : '—')) + '</div>'
            + '</div>'
            + '<div class="aad-card-title">' + escapeHtml(r.title || '') + '</div>'
            + '<div class="aad-card-desc">'  + escapeHtml(r.content || '') + '</div>'
            + '<div class="aad-card-meta">'
                + '<span class="aad-pill aad-pill-' + (r.priority || 'low').toLowerCase() + '">' + ucFirst(r.priority || 'low') + '</span>'
                + '<span class="aad-pill aad-pill-' + (r.status || 'active').toLowerCase() + '">' + ucFirst(r.status || 'active') + '</span>'
                + (attachCount ? '<span class="aad-pill aad-pill-closed">' + attachCount + ' file(s)</span>' : '')
            + '</div>'
            + '<div class="aad-card-deleted" style="' + dateColor + '">' + dateLabel + ': <span>' + dateValue + '</span></div>'
        + '</div>';
    }).join('');
}

function openAnnArchiveDetail(record) {
    const prio   = (record.priority || 'low').toLowerCase();
    const status = (record.status   || 'active').toLowerCase();
    const priorityBadge = { high:'badge-high', moderate:'badge-moderate', low:'badge-low' };
    const statusBadge   = { active:'badge-active', closed:'badge-closed', scheduled:'badge-scheduled' };

    const files = record.attachment
        ? record.attachment.split(',').map(p => p.trim()).filter(Boolean)
        : [];

    const filesHTML = files.length
        ? `<div class="attachment-grid" style="margin-top:.5rem;">${files.map(path => {
              const url  = storageBaseUrl + '/' + encodeURI(path);
              const name = path.split('/').pop();
              if (/\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(path))
                  return `<div class="attachment-card"><a href="${url}" target="_blank"><img src="${url}" alt="${escapeHtml(name)}"></a></div>`;
              return `<div class="attachment-card"><a class="attachment-link" href="${url}" target="_blank"><img src="${attachIcon}" alt=""> ${escapeHtml(name)}</a></div>`;
          }).join('')}</div>`
        : '<p style="font-size:.78rem;color:var(--ink-muted);margin:0;">No files attached.</p>';

    document.getElementById('aadd-title').textContent = record.title || 'Untitled';
    document.getElementById('aadd-sub').textContent   = '#' + record.announcement_id + ' · Deleted ' + fmtDatePlain(record.deleted_at);

    document.getElementById('aadd-body').innerHTML = `
        <div style="margin-bottom:1rem;">
            <div style="font-size:1.1rem;font-weight:800;color:var(--ink);line-height:1.3;margin-bottom:.55rem;">${escapeHtml(record.title || '')}</div>
            <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                <span class="ann-badge ${priorityBadge[prio] || 'badge-low'}">${ucFirst(prio)}</span>
                <span class="ann-badge ${statusBadge[status] || 'badge-active'}">${ucFirst(status)}</span>
                ${files.length ? `<span class="ann-badge badge-closed">${files.length} file(s)</span>` : ''}
            </div>
        </div>
        <div class="view-row"><span class="view-label">ID</span><span class="view-val" style="font-family:monospace;color:var(--bright-pink);">#${record.announcement_id}</span></div>
        ${record.posted_at    ? `<div class="view-row"><span class="view-label">Posted</span><span class="view-val">${fmtDatePlain(record.posted_at)}</span></div>` : ''}
        ${record.scheduled_at ? `<div class="view-row"><span class="view-label">Scheduled for</span><span class="view-val" style="color:var(--hot-pink);">${fmtDatePlain(record.scheduled_at)}</span></div>` : ''}
        <div class="view-row"><span class="view-label">Deleted on</span><span class="view-val" style="color:#e04867;">${fmtDatePlain(record.deleted_at)}</span></div>
        <div style="margin-top:1rem;padding-top:.5rem;border-top:1px solid var(--white);">
            <div style="font-size:.72rem;font-weight:700;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem;">Content</div>
            <div style="font-size:.88rem;color:var(--ink-muted);line-height:1.75;white-space:pre-wrap;">${escapeHtml(record.content || '')}</div>
        </div>
        ${files.length ? `<div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--pink-100);">
            <div style="font-size:.72rem;font-weight:700;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem;">Attachments</div>
            ${filesHTML}
        </div>` : ''}
    `;

    var reopenWrap = document.getElementById('aadd-reopen-wrap');
    if (reopenWrap) {
        if (record.status === 'closed' && record.announcement_id) {
            reopenWrap.innerHTML = '<form method="POST" action="/announcements/' + record.announcement_id + '/reopen" style="display:inline;" onsubmit="showActionLoading(\'Reopening announcement...\');">'
                + '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                + '<button type="submit" class="btn-submit" style="font-size:.82rem;padding:.5rem 1rem;">Reopen as Active</button>'
                + '</form>';
        } else {
            reopenWrap.innerHTML = '';
        }
    }
    document.getElementById('aadd-backdrop').classList.add('open');
    document.getElementById('aadd-modal').classList.add('open');
}

function closeAnnArchiveDetail() {
    document.getElementById('aadd-backdrop').classList.remove('open');
    document.getElementById('aadd-modal').classList.remove('open');
}

function exportAnnArchive() {
    var source   = _annArchiveTab === 'closed' ? closedAnnArchive : deletedAnnArchive;
    var filename = _annArchiveTab === 'closed' ? 'announcements_closed.csv' : 'announcements_deleted.csv';
    if (!source.length) { showToast('No records to export.', 'error'); return; }
    var rows = [['ID','Title','Content','Priority','Status','Posted At','Scheduled At','Closed/Deleted On']];
    source.forEach(function(r) {
        rows.push([
            r.announcement_id,
            r.title        || '',
            r.content      || '',
            r.priority     || '',
            r.status       || '',
            r.posted_at    || '',
            r.scheduled_at || '',
            _annArchiveTab === 'closed' ? (r.posted_at || '') : (r.deleted_at || ''),
        ]);
    });
    var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g,'""') + '"'; }).join(','); }).join('\n');
    var a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = filename;
    a.click();
}

updateEmptyState();

@if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
@if(session('error'))   showToast("{{ session('error') }}", 'error'); @endif
@if($errors->any())
    showToast("{{ $errors->first() }}", 'error');
@endif
</script>
@endsection