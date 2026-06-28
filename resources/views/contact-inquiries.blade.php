@extends('layout')

@section('title', 'DormEase: Contact Inquiries')
@section('page-title', 'Contact Inquiries')

@section('styles')
<style>
/* ── Page Shell ────────────────────────────────────────────────────── */
.ci-page {
    padding: 1.8rem 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    background: var(--soft-bg, #fdf6f9);
    box-sizing: border-box;
}

/* ── Page Header ───────────────────────────────────────────────────── */
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

/* ── Stat Cards  (mirrors .ann-stat-card) ──────────────────────────── */
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

/* ── Filter Bar ────────────────────────────────────────────────────── */
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

/* ── Card List ─────────────────────────────────────────────────────── */
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

/* ── Pagination ────────────────────────────────────────────────────── */
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

/* ── View Modal ────────────────────────────────────────────────────── */
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

/* detail rows */
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

/* update status panel */
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

/* ── Fade-up animation (same as ann-page) ──────────────────────────── */
.fade-up { animation: fadeUp .42s ease both; }
.d1 { animation-delay: .05s; }
.d2 { animation-delay: .12s; }
.d3 { animation-delay: .2s;  }
.d4 { animation-delay: .28s; }
@keyframes fadeUp { from { opacity:0; transform: translateY(12px); } to { opacity:1; transform: none; } }

/* ── Action loading overlay ────────────────────────────────────────── */
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

/* ── Responsive ────────────────────────────────────────────────────── */
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

    {{-- ── Page Header ── --}}
    <div class="ci-page-header fade-up d1">
        <div>
            <h1>Contact Inquiries</h1>
            <div class="dorm-name">Messages submitted from the public Contact Us form</div>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
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

    {{-- ── Filter Bar ── --}}
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

    {{-- ── Inquiry Cards ── --}}
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
                    </div>
                </div>
            </article>
        @empty
            <div class="ci-empty">No contact inquiries found.</div>
        @endforelse
    </div>

    {{-- ── Pagination ── --}}
    @if($inquiries->hasPages())
        <div class="ci-pagination">
            {{ $inquiries->links() }}
        </div>
    @endif

</div>
@endsection

@section('modals')

{{-- ── View / Update Modal ── --}}
<div id="ci-view-modal" onclick="if(event.target===this) closeCiModal()">
    <div class="ci-modal-box">

        {{-- Header --}}
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

        {{-- Body --}}
        <div class="ci-modal-body">

            {{-- Tab 0: Details --}}
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

            {{-- Tab 1: Full Message --}}
            <div class="ci-modal-panel" id="ci-panel-1">
                <div class="ci-view-message" id="ci-v-message"></div>
            </div>

            {{-- Tab 2: Update Status --}}
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

        {{-- Footer --}}
        <div class="ci-modal-footer">
            <div class="ci-modal-footer-left" id="ci-modal-footer-label"></div>
            <div style="display:flex;gap:.5rem;">
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

{{-- ── Loading overlay ── --}}
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
    ];
}
@endphp
<script>
/* ── Inquiry data from server ── */
const ciData = {!! json_encode($ciDataMap, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

/* ── Loading overlay ── */
function showCiLoading() {
    document.getElementById('ci-loading').classList.add('open');
}

/* ── Modal open / close ── */
function openCiModal(id) {
    const d = ciData[id];
    if (!d) return;

    /* header */
    document.getElementById('ci-modal-name').textContent = d.name;
    document.getElementById('ci-modal-sub').textContent  =
        ucFirst(d.inquiry_type.replace('_',' ')) + ' · ' + ucFirst(d.status);

    /* details tab */
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

    /* message tab */
    document.getElementById('ci-v-message').textContent = d.message;

    /* footer label */
    document.getElementById('ci-modal-footer-label').textContent =
        'ID #' + d.id + ' · ' + d.created_at;

    /* update status form */
    document.getElementById('ci-update-form').action = d.update_url;
    selectCiStatus(d.status);
    document.querySelector('#ci-update-form textarea[name="note"]').value = '';

    /* show first tab */
    switchCiTab(0);

    document.getElementById('ci-view-modal').classList.add('open');
}

function closeCiModal() {
    document.getElementById('ci-view-modal').classList.remove('open');
}

/* ── Tab switcher ── */
let _ciTab = 0;
function switchCiTab(idx) {
    _ciTab = idx;
    [0, 1, 2].forEach(i => {
        document.getElementById('ci-tab-' + i).classList.toggle('active', i === idx);
        document.getElementById('ci-panel-' + i).classList.toggle('active', i === idx);
    });
}

/* ── Status pill selector ── */
function selectCiStatus(val) {
    document.querySelectorAll('.ci-status-pill').forEach(p => {
        p.className = 'ci-status-pill';
        if (p.dataset.val === val) p.classList.add('sel-' + val);
    });
    document.getElementById('ci-status-input').value = val;
}

/* ── Helpers ── */
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

/* ── Toast (reuse if global showToast exists, else noop) ── */
@if(session('success'))
    if (typeof showToast === 'function') showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
    if (typeof showToast === 'function') showToast("{{ session('error') }}", 'error');
@endif
</script>
@endsection