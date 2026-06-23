@extends('fdlayout')

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

.ann-stats-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
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
    background: var(--white);
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

.ann-stat-num { font-size: 2rem; font-weight: 700; color: var(--white); line-height: 1; }
.ann-stat-label { font-size: .8rem; color: rgba(247,245,245,.967); margin-bottom: .15rem; font-weight: 700; }
.ann-stat-sub { font-size: .73rem; color: rgba(248,246,246,.955); font-weight: 600; margin-top: .15rem; }

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

.ann-filter-select:hover {
    border-color: var(--bright-pink, #E8175D);
    color: var(--hot-pink, #d6175a);
    background-color: var(--petal, #ffeef4);
}

.ann-filter-select:focus {
    border-color: var(--bright-pink, #E8175D);
    color: var(--hot-pink, #d6175a);
}

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
    border: 1.5px solid var(--pink-100, #f9c5d6);
    background: #fff;
    font-size: .82rem;
    color: var(--ink);
    outline: none;
    width: 200px;
    font-family: var(--ff-body);
    transition: border-color .2s, width .3s;
    box-shadow: 0 2px 8px rgba(232,23,93,.04);
}

.ann-search-wrap input:focus { border-color: var(--bright-pink, #E8175D); width: 240px; }
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
    border: 1px solid var(--pink-100, #f9c5d6);
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
    border-color: var(--bright-pink, #E8175D);
    box-shadow: 0 6px 22px rgba(232,23,93,.11);
    transform: translateY(-1px);
}

.ann-row-card:hover::before { background: var(--gradient-pink, linear-gradient(135deg,#E8175D,#c0103e)); }
.ann-row-card.status-active::before { background: var(--gradient-pink); }

.ann-row-card.status-closed {
    opacity: .58;
    background: #f7f7f9;
    border-color: #e0e0e8;
}

.ann-row-card.status-closed .ann-row-title,
.ann-row-card.status-closed .ann-row-excerpt { color: #999; }
.ann-row-card.status-closed .ann-row-time { color: #bbb; }
.ann-row-card.status-closed::before { background: #c8c8d4; }

.ann-row-card.status-closed:hover {
    border-color: #c0c0cc;
    box-shadow: 0 4px 14px rgba(0,0,0,.06);
    opacity: .72;
    transform: translateY(-1px);
}

.ann-row-card.status-closed:hover::before { background: #a0a0b8; }

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
    color: var(--ink-muted, #888);
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
    color: var(--ink-muted, #888);
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

.badge-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-closed   { background: #f3f4f6; color: #888; border: 1px solid #d0d0d8; }
.badge-low      { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-moderate { background: #fff8e1; color: #c8960c; border: 1px solid #f0c040; }
.badge-high     { background: #fff0f0; color: #e04867; border: 1px solid #ffb3c0; }

.ann-row-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: .4rem;
    flex-shrink: 0;
}

.ann-row-time {
    font-size: .68rem;
    color: var(--ink-muted, #888);
    white-space: nowrap;
    font-weight: 500;
}

.ann-view-btn {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .3rem .75rem;
    border-radius: 8px;
    border: 1.5px solid var(--pink-100, #f9c5d6);
    background: var(--petal, #ffeef4);
    color: var(--hot-pink, #d6175a);
    font-size: .73rem;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
    font-family: var(--ff-body);
    white-space: nowrap;
}

.ann-view-btn:hover { background: var(--bright-pink, #E8175D); color: #fff; border-color: transparent; }
.ann-view-btn img { width: 12px; height: 12px; object-fit: contain; filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%); }
.ann-view-btn:hover img { filter: brightness(0) invert(1); }

.ann-list-empty {
    text-align: center;
    padding: 3rem 1rem;
    background: #fff;
    border: 1px solid var(--pink-100, #f9c5d6);
    border-radius: 14px;
    color: var(--ink-muted, #888);
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
    border: 1px solid var(--pink-100, #f9c5d6);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(232,23,93,.05);
}

.ann-sidebar-header {
    padding: .85rem 1.1rem;
    border-bottom: 1px solid var(--pink-100, #f9c5d6);
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
    border-bottom: 1px solid var(--pink-100, #f9c5d6);
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
    color: var(--hot-pink, #d6175a);
}

.ann-recent-item {
    padding: .65rem 0;
    border-bottom: 1px solid var(--pink-100, #f9c5d6);
    cursor: pointer;
    transition: background .15s;
}

.ann-recent-item:last-child { border-bottom: none; }
.ann-recent-item:hover .ann-recent-title { color: var(--hot-pink, #d6175a); }

.ann-recent-title {
    font-size: .82rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.3;
    margin-bottom: .22rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color .15s;
}

.ann-recent-time {
    font-size: .7rem;
    color: var(--ink-muted, #888);
    font-weight: 500;
}

.ann-recent-empty {
    font-size: .8rem;
    color: var(--ink-muted, #888);
    padding: .5rem 0;
    text-align: center;
}

.vm-header { padding: 1.3rem 1.5rem 0; border-bottom: 1px solid var(--pink-100, #f9c5d6); flex-shrink: 0; }
.vm-header-top { display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem; margin-bottom: 1rem; }
.vm-title-group { display: flex; align-items: center; gap: .65rem; }
.vm-icon { width: 34px; height: 34px; border-radius: 9px; background: var(--gradient-pink, linear-gradient(135deg,#E8175D,#c0103e)); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.vm-icon img { width: 16px; height: 16px; object-fit: contain; filter: brightness(0) invert(1); }
.vm-title { font-size: 1rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
.vm-sub { font-size: .7rem; color: var(--ink-muted, #888); font-weight: 500; margin-top: .1rem; }
.vm-close { width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--pink-100, #f9c5d6); background: var(--petal, #ffeef4); color: var(--bright-pink, #E8175D); font-size: .8rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s; }
.vm-close:hover { background: var(--pink-100, #f9c5d6); }

.vm-tabs { display: flex; }
.vm-tab { padding: .62rem 1.1rem; font-size: .8rem; font-weight: 700; color: var(--ink-muted, #888); cursor: pointer; border: none; background: none; border-bottom: 2.5px solid transparent; transition: color .18s, border-color .18s; display: flex; align-items: center; gap: .38rem; font-family: var(--ff-body); margin-bottom: -1px; }
.vm-tab img { width: 13px; height: 13px; opacity: .5; transition: opacity .18s; }
.vm-tab svg { width: 13px; height: 13px; flex-shrink: 0; opacity: .6; transition: opacity .18s; }
.vm-tab:hover { color: var(--hot-pink, #d6175a); }
.vm-tab.active { color: var(--hot-pink, #d6175a); border-bottom-color: var(--hot-pink, #d6175a); }
.vm-tab.active img { opacity: 1; }
.vm-tab.active svg { opacity: 1; }
.vm-tab-badge { background: var(--petal, #ffeef4); color: var(--hot-pink, #d6175a); border: 1px solid var(--pink-100, #f9c5d6); font-size: .65rem; font-weight: 800; padding: .1rem .4rem; border-radius: 999px; }

.vm-panels { padding: 1.3rem 1.5rem 1.5rem; overflow-y: auto; flex: 1; }
.vm-panel { display: none; flex-direction: column; gap: .9rem; animation: vmFadeIn .18s ease both; }
.vm-panel.active { display: flex; }
@keyframes vmFadeIn { from { opacity:0; transform: translateY(4px); } to { opacity:1; transform: none; } }
@keyframes pulseLogo { 0%,100% { transform: scale(1); } 50% { transform: scale(1.06); } }

.vm-ann-title { font-size: 1.25rem; font-weight: 800; color: var(--ink); line-height: 1.3; }
.vm-detail-row { display: flex; justify-content: space-between; align-items: center; padding: .55rem 0; border-bottom: 1px solid var(--pink-100, #f9c5d6); font-size: .86rem; }
.vm-detail-row:last-child { border-bottom: none; }
.vm-detail-label { color: var(--ink-muted, #888); font-weight: 500; }
.vm-detail-val { font-weight: 600; color: var(--ink); }
.vm-content-body { font-size: .9rem; color: var(--ink-muted, #888); line-height: 1.75; white-space: pre-wrap; margin-top: .5rem; }

.vm-file-grid { display: flex; flex-direction: column; gap: .75rem; }
.vm-file-item { border: 1.5px solid var(--pink-100, #f9c5d6); border-radius: 14px; overflow: hidden; background: #fff; }
.vm-file-bar { display: flex; align-items: center; justify-content: space-between; padding: .55rem .85rem; background: var(--petal, #ffeef4); border-bottom: 1px solid var(--pink-100, #f9c5d6); gap: .75rem; }
.vm-file-name { font-size: .76rem; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: .38rem; min-width: 0; flex: 1; }
.vm-file-name img { width: 13px; height: 13px; opacity: .45; flex-shrink: 0; }
.vm-file-name span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.vm-file-actions { display: flex; align-items: center; gap: .3rem; flex-shrink: 0; }
.vm-file-dl { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: 1.5px solid var(--pink-100, #f9c5d6); background: #fff; color: var(--bright-pink, #E8175D); text-decoration: none; transition: .2s; font-size: .85rem; cursor: pointer; }
.vm-file-dl:hover { background: var(--bright-pink, #E8175D); border-color: var(--bright-pink, #E8175D); color: #fff; }
.vm-file-dl svg { width: 14px; height: 14px; flex-shrink: 0; }
.vm-file-body { padding: .75rem; }
.vm-file-body img { width: 100%; max-height: 280px; object-fit: contain; border-radius: 8px; display: block; cursor: zoom-in; transition: opacity .2s; background: var(--soft-bg, #fdf6f9); }
.vm-file-body img:hover { opacity: .88; }
.vm-file-body iframe { width: 100%; height: 300px; border: none; border-radius: 8px; display: block; }
.vm-file-unsupported { display: flex; flex-direction: column; align-items: center; padding: 1.5rem; color: var(--ink-muted, #888); font-size: .8rem; text-align: center; gap: .4rem; }
.vm-file-unsupported img { width: 28px; height: 28px; opacity: .3; }
.vm-no-files { display: flex; flex-direction: column; align-items: center; padding: 2rem; color: var(--ink-muted, #888); font-size: .82rem; text-align: center; gap: .4rem; }
.vm-no-files img { width: 36px; height: 36px; opacity: .25; }

.vm-footer { padding: .9rem 1.5rem; border-top: 1px solid var(--pink-100, #f9c5d6); display: flex; justify-content: flex-end; flex-shrink: 0; }
.vm-close-btn { padding: .55rem 1.3rem; border-radius: 9px; border: 1.5px solid var(--pink-100, #f9c5d6); background: var(--petal, #ffeef4); font-size: .87rem; font-weight: 600; color: var(--hot-pink, #d6175a); cursor: pointer; transition: .2s; font-family: var(--ff-body); }
.vm-close-btn:hover { border-color: var(--bright-pink, #E8175D); background: var(--pink-100, #f9c5d6); }

.lightbox-overlay { position: fixed; inset: 0; z-index: 2000; background: rgba(0,0,0,.92); display: none; align-items: center; justify-content: center; padding: 1.5rem; box-sizing: border-box; }
.lightbox-overlay.open { display: flex; }
.lightbox-inner { position: relative; max-width: 100%; max-height: 100%; display: flex; align-items: center; justify-content: center; }
.lightbox-inner img { max-width: min(92vw,1100px); max-height: 88vh; object-fit: contain; border-radius: 10px; box-shadow: 0 24px 64px rgba(0,0,0,.6); display: block; }
.lightbox-close { position: fixed; top: 1.1rem; right: 1.3rem; width: 38px; height: 38px; border-radius: 50%; background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.25); color: #fff; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .2s; z-index: 2001; }
.lightbox-close:hover { background: rgba(255,255,255,.22); }

.fade-up { animation: fadeUp .42s ease both; }
.d1 { animation-delay: .05s; } .d2 { animation-delay: .12s; } .d3 { animation-delay: .2s; } .d4 { animation-delay: .28s; }
@keyframes fadeUp { from { opacity:0; transform: translateY(12px); } to { opacity:1; transform: none; } }

.ann-dismiss-btn {
    width: 24px; height: 24px;
    border-radius: 6px;
    border: 1.5px solid var(--pink-100, #f9c5d6);
    background: #fff;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
    flex-shrink: 0;
    opacity: .55;
}

.ann-dismiss-btn:hover {
    border-color: #e04867;
    background: #fff0f0;
    opacity: 1;
}

.ann-dismiss-btn svg { width: 12px; height: 12px; color: #e04867; }

.ann-show-hidden-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: .6rem 1rem;
    border-radius: 12px;
    border: 1.5px dashed var(--pink-100, #f9c5d6);
    background: var(--petal, #ffeef4);
    font-size: .78rem;
    font-weight: 600;
    color: var(--hot-pink, #d6175a);
    cursor: pointer;
    transition: border-color .2s, background .2s;
}

.ann-show-hidden-bar.visible { display: flex; }
.ann-show-hidden-bar:hover { border-color: var(--bright-pink, #E8175D); background: var(--blush); }
.ann-show-hidden-bar svg { width: 14px; height: 14px; flex-shrink: 0; }

.hidden-modal-overlay {
    position: fixed; inset: 0; z-index: 800;
    display: none; align-items: center; justify-content: center;
    background: rgba(90,30,56,.38);
    backdrop-filter: blur(4px);
    padding: 1rem;
}
.hidden-modal-overlay.open { display: flex; }
.hidden-modal-box {
    background: #fff;
    border-radius: 18px;
    width: 100%; max-width: 480px;
    max-height: 82vh;
    display: flex; flex-direction: column;
    box-shadow: 0 24px 60px rgba(232,23,93,.18), 0 4px 16px rgba(0,0,0,.08);
    animation: modalIn .25s cubic-bezier(.34,1.3,.64,1) both;
    overflow: hidden;
}
@keyframes modalIn { from { opacity:0; transform: translateY(16px) scale(.97); } to { opacity:1; transform: none; } }
.hidden-modal-header {
    padding: .9rem 1.2rem;
    border-bottom: 1px solid var(--pink-100, #f9c5d6);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.hidden-modal-title {
    font-size: .95rem; font-weight: 800; color: var(--ink);
    display: flex; align-items: center; gap: .5rem;
}
.hidden-modal-title svg { width: 16px; height: 16px; color: var(--hot-pink, #d6175a); }
.hidden-modal-close {
    width: 30px; height: 30px; border-radius: 7px;
    border: 1px solid var(--pink-100, #f9c5d6);
    background: var(--petal, #ffeef4);
    color: var(--bright-pink, #E8175D);
    font-size: .8rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
}
.hidden-modal-close:hover { background: var(--pink-100, #f9c5d6); }
.hidden-modal-body {
    flex: 1; overflow-y: auto;
    padding: .75rem 1.2rem;
    display: flex; flex-direction: column; gap: .55rem;
}
.hidden-modal-body::-webkit-scrollbar { width: 4px; }
.hidden-modal-body::-webkit-scrollbar-thumb { background: var(--pink-200, #f4b8d0); border-radius: 99px; }
.hidden-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .65rem .85rem;
    border: 1px solid var(--pink-100, #f9c5d6);
    border-radius: 11px;
    background: #fff;
    transition: border-color .2s, background .2s;
}
.hidden-item:hover { border-color: var(--bright-pink, #E8175D); background: var(--blush, #fff5f9); }
.hidden-item-dot {
    width: 8px; height: 8px; border-radius: 50%;
    flex-shrink: 0;
}
.hidden-item-info { flex: 1; min-width: 0; }
.hidden-item-title {
    font-size: .85rem; font-weight: 700; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: .15rem;
}
.hidden-item-meta { font-size: .7rem; color: var(--ink-muted, #888); font-weight: 500; }
.hidden-unhide-btn {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .75rem; border-radius: 7px;
    border: 1.5px solid var(--pink-100, #f9c5d6);
    background: var(--petal, #ffeef4);
    color: var(--hot-pink, #d6175a);
    font-size: .72rem; font-weight: 700;
    cursor: pointer; transition: .2s;
    white-space: nowrap; flex-shrink: 0;
    font-family: var(--ff-body);
}
.hidden-unhide-btn:hover { background: var(--bright-pink, #E8175D); color: #fff; border-color: transparent; }
.hidden-modal-footer {
    padding: .75rem 1.2rem;
    border-top: 1px solid var(--pink-100, #f9c5d6);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0; background: #fffafd;
}
.hidden-modal-count { font-size: .75rem; color: var(--ink-muted, #888); font-weight: 600; }
.hidden-restore-all-btn {
    display: inline-flex; align-items: center; gap: .38rem;
    padding: .38rem .9rem; border-radius: 8px;
    border: none; background: var(--gradient-pink);
    color: #fff; font-size: .78rem; font-weight: 700;
    cursor: pointer; transition: .2s; font-family: var(--ff-body);
    box-shadow: 0 4px 12px rgba(232,23,93,.22);
}
.hidden-restore-all-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(232,23,93,.32); }
.hidden-empty {
    text-align: center; padding: 2rem 1rem;
    color: var(--ink-muted, #888); font-size: .84rem;
}

@media (max-width: 1100px) { .ann-main-layout { grid-template-columns: 1fr; } .ann-sidebar { position: static; } }
@media (max-width: 1100px) { .ann-stats-row { grid-template-columns: repeat(2, 1fr); } .ann-stat-num { font-size: 1.6rem; } }
@media (max-width: 900px) { .ann-stats-row { grid-template-columns: 1fr 1fr; } .ann-page { padding: 1.2rem 1rem; } .ann-stat-card { padding: 1rem 1.1rem; gap: .9rem; } .ann-stat-icon { width: 44px; height: 44px; } .ann-stat-icon img { width: 22px; height: 22px; } .ann-stat-num { font-size: 1.5rem; } }
@media (max-width: 600px) { .ann-stats-row { grid-template-columns: 1fr; } .ann-page { padding: 1rem; } .ann-stat-card { padding: 1rem 1.2rem; } .ann-stat-num { font-size: 1.75rem; } }
</style>
@endsection

@section('content')
@php
    $visibleAnnouncements = $announcements
        ->filter(fn ($a) => strtolower($a->status ?? 'active') !== 'closed')
        ->values();
@endphp
<div class="ann-page">

    <div class="ann-page-header fade-up d1">
        <div>
            <h1>Announcements</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
    </div>

    <div class="ann-stats-row fade-up d2">
        <div class="ann-stat-card">
            <div class="ann-stat-icon">
                <img src="{{ asset('icons/active.png') }}" alt="">
            </div>
            <div>
                <div class="ann-stat-label">Active Announcements</div>
                <div class="ann-stat-num">{{ $visibleAnnouncements->where('status','active')->count() }}</div>
                <div class="ann-stat-sub">Currently posted</div>
            </div>
        </div>
        <div class="ann-stat-card">
            <div class="ann-stat-icon">
                <img src="{{ asset('icons/pending.png') }}" alt="">
            </div>
            <div>
                <div class="ann-stat-label">Posted This Week</div>
                <div class="ann-stat-num">{{ $visibleAnnouncements->filter(fn ($a) => \Carbon\Carbon::parse($a->posted_at ?? $a->created_at)->isCurrentWeek())->count() }}</div>
                <div class="ann-stat-sub">New since Sunday</div>
            </div>
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
        <div class="ann-search-wrap">
            <img src="{{ asset('icons/search.png') }}" class="ann-search-icon" alt="">
            <input type="text" id="ann-search-input" placeholder="Search announcements..." oninput="applyDropdownFilters()">
        </div>
    </div>

    <div class="ann-main-layout fade-up d4">

        <div class="ann-list-panel" id="ann-list-panel">
            @php
                $sorted = $visibleAnnouncements->sortByDesc(fn($a) => $a->posted_at ?? $a->created_at)->values();
            @endphp
            @forelse($sorted as $ann)
                <div class="ann-row-card status-{{ $ann->status }}"
                     data-ann-id="{{ $ann->announcement_id }}"
                     data-status="{{ $ann->status }}"
                     data-priority="{{ strtolower($ann->priority ?? 'low') }}"
                     data-posted="{{ $ann->posted_at ?? $ann->created_at }}"
                     data-title="{{ strtolower($ann->title) }}"
                     data-content="{{ strtolower($ann->content) }}"
                     onclick="openViewModal({{ $ann->announcement_id }})">

                    <div class="ann-row-left">
                        <span class="ann-row-priority-dot prio-{{ strtolower($ann->priority ?? 'low') }}"
                              title="{{ ucfirst($ann->priority ?? 'low') }} priority"></span>
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
                        </div>
                    </div>

                    <div class="ann-row-right">
                        <span class="ann-row-time">
                            {{ \Carbon\Carbon::parse($ann->posted_at ?? $ann->created_at)->format('M j, Y') }}
                        </span>
                        <div style="display:flex;align-items:center;gap:.4rem;">
                            <button class="ann-view-btn" onclick="event.stopPropagation(); openViewModal({{ $ann->announcement_id }})">
                                <img src="{{ asset('icons/eye.png') }}" alt=""> View
                            </button>
                            <button class="ann-dismiss-btn" onclick="event.stopPropagation(); dismissAnnouncement({{ $ann->announcement_id }})" title="Hide this announcement">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="ann-list-empty">
                    <img src="{{ asset('icons/announce.png') }}" alt="">
                    No announcements yet.
                </div>
            @endforelse

            <div class="ann-show-hidden-bar" id="ann-show-hidden-bar" onclick="openHiddenModal()">
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    <span id="ann-hidden-count-label">1 hidden announcement</span>
                </div>
                <span style="font-size:.72rem;font-weight:700;text-decoration:underline;">Manage</span>
            </div>

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
                        $highCount = $visibleAnnouncements->where('priority','high')->count();
                        $modCount  = $visibleAnnouncements->where('priority','moderate')->count();
                        $lowCount  = $visibleAnnouncements->where('priority','low')->count();
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
                        <img src="{{ asset('icons/announce.png') }}" alt="">
                        Recent
                    </div>
                    <span style="font-size:.72rem;font-weight:700;background:var(--petal,#ffeef4);color:var(--hot-pink,#d6175a);padding:.12rem .5rem;border-radius:99px;border:1px solid var(--pink-100,#f9c5d6);">
                        {{ $visibleAnnouncements->count() }} total
                    </span>
                </div>
                <div class="ann-sidebar-body">
                    @forelse($visibleAnnouncements->sortByDesc(fn($r) => $r->posted_at ?? $r->created_at)->take(5) as $r)
                        <div class="ann-recent-item" onclick="openViewModal({{ $r->announcement_id }})">
                            <div class="ann-recent-title">{{ $r->title }}</div>
                            <div class="ann-recent-time">{{ \Carbon\Carbon::parse($r->posted_at ?? $r->created_at)->format('M j, Y') }}</div>
                        </div>
                    @empty
                        <div class="ann-recent-empty">No announcements yet.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('modals')

<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()">&#x2715;</button>
    <div class="lightbox-inner" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="">
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:560px;width:100%;padding:0;overflow:hidden;max-height:92vh;display:flex;flex-direction:column;">

        <div class="vm-header">
            <div class="vm-header-top">
                <div class="vm-title-group">
                    <div class="vm-icon"><img src="{{ asset('icons/announce.png') }}" alt=""></div>
                    <div>
                        <div class="vm-title">Announcement</div>
                        <div class="vm-sub" id="vm-sub-label">View details</div>
                    </div>
                </div>
                <button class="vm-close" onclick="closeModal('view-modal')">&#x2715;</button>
            </div>
            <div class="vm-tabs">
                <button class="vm-tab active" onclick="switchVmTab(this,'details')" id="vm-tab-details">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Details
                </button>
                <button class="vm-tab" onclick="switchVmTab(this,'files')" id="vm-tab-files">
                    <img src="{{ asset('icons/attach.png') }}" alt=""> Attachments
                    <span class="vm-tab-badge" id="vm-file-count">0</span>
                </button>
            </div>
        </div>

        <div class="vm-panels">
            <div class="vm-panel active" id="vm-panel-details">
                <div class="vm-ann-title" id="vm-ann-title"></div>
                <div id="vm-detail-rows"></div>
                <div class="vm-content-body" id="vm-content-body"></div>
            </div>
            <div class="vm-panel" id="vm-panel-files">
                <div class="vm-file-grid" id="vm-file-grid"></div>
            </div>
        </div>

        <div class="vm-footer">
            <button class="vm-close-btn" onclick="closeModal('view-modal')">Close</button>
        </div>

    </div>
</div>

<div class="action-loading-overlay" id="action-loading" style="position:fixed;inset:0;z-index:1200;display:none;align-items:center;justify-content:center;background:rgba(255,255,255,.72);backdrop-filter:blur(2px);">
    <div style="display:flex;align-items:center;flex-direction:column;gap:.75rem;padding:1.25rem 1.6rem;border:1px solid var(--pink-100,#f9c5d6);border-radius:12px;background:#fff;box-shadow:0 12px 32px rgba(26,26,46,.14);color:var(--ink,#1a1a2e);font-size:.9rem;font-weight:700;">
        <div style="width:86px;height:86px;border:3px solid var(--pink-100,#f9c5d6);border-radius:50%;background:var(--gradient-pink);display:flex;align-items:center;justify-content:center;box-shadow:0 10px 24px rgba(232,23,93,.25);animation:pulseLogo 1s ease-in-out infinite;">
            <img src="{{ asset('images/logo.png') }}" style="width:62px;height:62px;object-fit:contain;" alt="DormEase">
        </div>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="hidden-modal-overlay" id="hidden-modal" onclick="if(event.target===this)closeHiddenModal()">
    <div class="hidden-modal-box">
        <div class="hidden-modal-header">
            <div class="hidden-modal-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                Hidden Announcements
            </div>
            <button class="hidden-modal-close" onclick="closeHiddenModal()">&#x2715;</button>
        </div>
        <div class="hidden-modal-body" id="hidden-modal-body"></div>
        <div class="hidden-modal-footer">
            <span class="hidden-modal-count" id="hidden-modal-count"></span>
            <button class="hidden-restore-all-btn" onclick="restoreHidden()">Restore All</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const annData = @json($visibleAnnouncements->keyBy('announcement_id'));
const storageBase = "{{ asset('storage') }}";

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});

function applyDropdownFilters(changedEl) {
    if (changedEl) {
        changedEl.classList.toggle('has-value', changedEl.value !== '');
    }

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

        if (cardStatus === 'closed') show = false;
        if (status && cardStatus !== status) show = false;
        if (priority && cardPriority !== priority) show = false;
        if (date && weekStart && weekEnd && (cardPosted < weekStart || cardPosted > weekEnd)) show = false;
        if (q && !cardTitle.includes(q) && !cardContent.includes(q)) show = false;

        card.style.display = show ? '' : 'none';
    });

    applyHidden();
}

const HIDDEN_KEY = 'fd_hidden_announcements';

function getHidden() {
    try { return JSON.parse(localStorage.getItem(HIDDEN_KEY) || '[]'); } catch { return []; }
}

function saveHidden(ids) {
    localStorage.setItem(HIDDEN_KEY, JSON.stringify(ids));
}

function dismissAnnouncement(id) {
    showFdLoading('Hiding announcement...');
    setTimeout(() => {
        const numId = parseInt(id, 10);
        const hidden = getHidden().map(h => parseInt(h, 10));
        if (!hidden.includes(numId)) hidden.push(numId);
        saveHidden(hidden);
        applyHidden();
        hideFdLoading();
    }, 500);
}

function restoreHidden() {
    showFdLoading('Restoring all announcements...');
    setTimeout(() => {
        saveHidden([]);
        document.querySelectorAll('.ann-row-card').forEach(card => {
            if (card.dataset.status !== 'closed') {
                card.style.display = '';
            }
        });
        applyHidden();
        closeHiddenModal();
        hideFdLoading();
    }, 600);
}

function showFdLoading(message) {
    const overlay = document.getElementById('action-loading');
    document.getElementById('action-loading-text').textContent = message;
    overlay.style.display = 'flex';
}

function hideFdLoading() {
    document.getElementById('action-loading').style.display = 'none';
}

function unhideOne(id) {
    showFdLoading('Restoring announcement...');
    setTimeout(() => {
        const hidden = getHidden().filter(h => h !== id);
        saveHidden(hidden);
        const card = document.querySelector('.ann-row-card[data-ann-id="' + id + '"]');
        if (card) card.style.display = '';
        applyHidden();
        renderHiddenModal();
        hideFdLoading();
    }, 500);
}

function purgeHiddenMissing() {
    const hidden = getHidden().filter(id => !!annData[id]);
    if (hidden.length !== getHidden().length) saveHidden(hidden);
}

function applyHidden() {
    const hidden = getHidden().map(h => parseInt(h, 10));
    document.querySelectorAll('.ann-row-card').forEach(card => {
        const id = parseInt(card.dataset.annId, 10);
        if (hidden.includes(id)) {
            card.style.display = 'none';
        }
    });
    const bar   = document.getElementById('ann-show-hidden-bar');
    const label = document.getElementById('ann-hidden-count-label');
    if (hidden.length > 0) {
        bar.classList.add('visible');
        label.textContent = hidden.length + ' hidden announcement' + (hidden.length !== 1 ? 's' : '');
    } else {
        bar.classList.remove('visible');
    }
    updateEmptyState();
}

function openHiddenModal() {
    renderHiddenModal();
    document.getElementById('hidden-modal').classList.add('open');
}

function closeHiddenModal() {
    document.getElementById('hidden-modal').classList.remove('open');
}

function renderHiddenModal() {
    const hidden = getHidden();
    const body   = document.getElementById('hidden-modal-body');
    const count  = document.getElementById('hidden-modal-count');
    count.textContent = hidden.length + ' hidden announcement' + (hidden.length !== 1 ? 's' : '');
    if (!hidden.length) {
        body.innerHTML = '<div class="hidden-empty">No hidden announcements.</div>';
        return;
    }
    const prioColors = { high: '#e04867', moderate: '#f59e0b', low: '#1f9d69' };
    body.innerHTML = hidden.map(id => {
        const ann = annData[id];
        if (!ann) return '';
        const prio  = (ann.priority || 'low').toLowerCase();
        const color = prioColors[prio] || '#1f9d69';
        const date  = ann.posted_at || ann.created_at
            ? new Date(ann.posted_at || ann.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
            : '';
        return `<div class="hidden-item">
            <span class="hidden-item-dot" style="background:${color};"></span>
            <div class="hidden-item-info">
                <div class="hidden-item-title">${escHtml(ann.title || '')}</div>
                <div class="hidden-item-meta">${ucFirst(prio)} priority &nbsp;&middot;&nbsp; ${date}</div>
            </div>
            <button class="hidden-unhide-btn" onclick="unhideOne(${id})">Unhide</button>
        </div>`;
    }).filter(Boolean).join('');
}

function updateEmptyState() {
    const visible = document.querySelectorAll('.ann-row-card:not([style*="display: none"])').length;
    document.getElementById('ann-no-results').style.display = visible === 0 ? '' : 'none';
}

function switchVmTab(btn, tabId) {
    document.querySelectorAll('.vm-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.vm-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('vm-panel-' + tabId).classList.add('active');
}

function escHtml(v) {
    return String(v ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function formatDate(v) {
    if (!v) return '—';
    const d = new Date(v);
    return isNaN(d) ? v : d.toLocaleString([], { year:'numeric', month:'long', day:'numeric', hour:'numeric', minute:'2-digit' });
}

function getFiles(att) {
    if (!att) return [];
    return String(att).split(',').map(p => p.trim()).filter(Boolean);
}

function openLightbox(url) {
    document.getElementById('lightbox-img').src = url;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.getElementById('lightbox-img').src = '';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

function buildFilePreview(path) {
    const name    = path.split('/').pop();
    const ext     = (path.split('.').pop() || '').toLowerCase();
    const url     = path.startsWith('http') ? path : `${storageBase}/${encodeURI(path)}`;
    const isImage = ['jpg','jpeg','png','gif','webp','svg','bmp'].includes(ext);
    const isPdf   = ext === 'pdf';

    const expandSvg   = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>`;
    const openSvg     = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>`;
    const downloadSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>`;

    let body = '';
    if (isImage) {
        body = `<div class="vm-file-body"><img src="${url}" alt="${escHtml(name)}" loading="lazy" onclick="openLightbox('${url}')" title="Click to view full size" onerror="this.parentElement.innerHTML='<div class=&quot;vm-file-unsupported&quot;>Image could not be loaded.</div>'"></div>`;
    } else if (isPdf) {
        body = `<div class="vm-file-body"><iframe src="${url}" title="${escHtml(name)}"></iframe></div>`;
    } else {
        body = `<div class="vm-file-unsupported"><img src="{{ asset('icons/attach.png') }}" alt=""><span>No preview for <strong>.${ext}</strong> files.</span></div>`;
    }

    const actionBtn = isImage
        ? `<button class="vm-file-dl" onclick="openLightbox('${url}')" title="Expand">${expandSvg}</button>`
        : `<a href="${url}" target="_blank" class="vm-file-dl" title="Open">${openSvg}</a>`;

    return `
        <div class="vm-file-item">
            <div class="vm-file-bar">
                <div class="vm-file-name">
                    <img src="{{ asset('icons/attach.png') }}" alt="">
                    <span title="${escHtml(name)}">${escHtml(name)}</span>
                </div>
                <div class="vm-file-actions">
                    ${actionBtn}
                    <a href="${url}" download="${escHtml(name)}" class="vm-file-dl" title="Download">${downloadSvg}</a>
                </div>
            </div>
            ${body}
        </div>`;
}

function openViewModal(id) {
    const ann = annData[id];
    if (!ann) { showToast('Could not load announcement. Please refresh the page.', 'error'); return; }

    const files = getFiles(ann.attachment);

    document.getElementById('vm-sub-label').textContent = `#${id} · ${ucFirst(ann.priority || 'low')} priority`;
    document.getElementById('vm-ann-title').textContent  = ann.title || '';
    document.getElementById('vm-content-body').textContent = ann.content || '';
    document.getElementById('vm-file-count').textContent   = files.length;

    document.getElementById('vm-detail-rows').innerHTML = `
        <div class="vm-detail-row">
            <span class="vm-detail-label">Status</span>
            <span class="vm-detail-val">
                <span class="ann-badge badge-${ann.status || 'active'}">${ucFirst(ann.status || 'active')}</span>
            </span>
        </div>
        <div class="vm-detail-row">
            <span class="vm-detail-label">Priority</span>
            <span class="vm-detail-val">
                <span class="ann-badge badge-${(ann.priority || 'low').toLowerCase()}">${ucFirst(ann.priority || 'Low')}</span>
            </span>
        </div>
        <div class="vm-detail-row">
            <span class="vm-detail-label">Posted</span>
            <span class="vm-detail-val">${formatDate(ann.posted_at || ann.created_at)}</span>
        </div>
        <div class="vm-detail-row">
            <span class="vm-detail-label">Attachments</span>
            <span class="vm-detail-val">${files.length} file${files.length !== 1 ? 's' : ''}</span>
        </div>`;

    document.getElementById('vm-file-grid').innerHTML = files.length
        ? files.map(buildFilePreview).join('')
        : `<div class="vm-no-files"><img src="{{ asset('icons/attach.png') }}" alt=""><span>No attachments on this announcement.</span></div>`;

    document.querySelectorAll('.vm-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.vm-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('vm-tab-details').classList.add('active');
    document.getElementById('vm-panel-details').classList.add('active');

    openModal('view-modal');
}

function ucFirst(str) { return str ? str.charAt(0).toUpperCase() + str.slice(1) : ''; }

document.querySelectorAll('.ann-row-card[data-status="closed"]').forEach(card => card.remove());
purgeHiddenMissing();
applyHidden();

@if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
@if(session('error'))   showToast("{{ session('error') }}", 'error'); @endif

(function () {
    var POLL_URL      = '{{ route("frontdesk.announcements.poll") }}';
    var POLL_INTERVAL = 8000;
    var lastSignature = null;
    var pendingReload = false;

    function isUserBusy() {
        if (document.querySelector('.modal-overlay.open, .hidden-modal-overlay.open')) return true;
        var focused = document.activeElement;
        if (focused && (focused.tagName === 'INPUT' || focused.tagName === 'TEXTAREA' || focused.tagName === 'SELECT')) return true;
        return false;
    }

    function doReload() {
        location.reload();
    }

    function poll() {
        fetch(POLL_URL, { cache: 'no-store' })
            .then(function (res) { return res.ok ? res.json() : null; })
            .then(function (data) {
                if (!data) return;
                var sig = data.signature;
                if (lastSignature === null) {
                    lastSignature = sig;
                    return;
                }
                if (sig !== lastSignature) {
                    lastSignature = sig;
                    if (!isUserBusy()) {
                        doReload();
                    } else {
                        pendingReload = true;
                    }
                }
            })
            .catch(function () {});
    }

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden && pendingReload) {
            if (!isUserBusy()) {
                doReload();
            }
        }
    });

    document.querySelectorAll('.modal-overlay, .hidden-modal-overlay').forEach(function (el) {
        el.addEventListener('click', function () {
            setTimeout(function () {
                if (pendingReload && !isUserBusy()) {
                    doReload();
                }
            }, 300);
        });
    });

    document.querySelectorAll('.vm-close, .vm-close-btn, .hidden-modal-close').forEach(function (btn) {
        btn.addEventListener('click', function () {
            setTimeout(function () {
                if (pendingReload && !isUserBusy()) {
                    doReload();
                }
            }, 300);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            setTimeout(function () {
                if (pendingReload && !isUserBusy()) {
                    doReload();
                }
            }, 300);
        }
    });

    setInterval(poll, POLL_INTERVAL);
    poll();
})();
@endsection