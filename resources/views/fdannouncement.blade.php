@extends('fdlayout')

@section('title', 'DormEase: Announcements')
@section('page-title', 'Announcements')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        background: var(--pink-bg);
        box-sizing: border-box;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header-text h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.15;
        margin: 0;
    }

    .page-header-text .dorm-sub {
        font-size: .95rem;
        font-weight: 600;
        color: var(--bright-pink);
        margin-top: .2rem;
    }

    .filter-bar {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: .45rem 1.8rem .45rem .75rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        color: var(--ink);
        font-size: .81rem;
        font-weight: 600;
        font-family: var(--ff-body);
        cursor: pointer;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .6rem center;
        transition: border-color .2s;
        box-shadow: 0 2px 8px rgba(255,45,120,.07);
    }

    .filter-select:focus {
        border-color: var(--bright-pink);
    }

    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-box input {
        padding: .45rem .85rem .45rem 2rem;
        border-radius: 10px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        font-size: .82rem;
        color: var(--ink);
        outline: none;
        width: 180px;
        font-family: var(--ff-body);
        transition: border-color .2s, width .3s;
        box-shadow: 0 2px 8px rgba(255,45,120,.07);
    }

    .search-box input:focus {
        border-color: var(--bright-pink);
        width: 220px;
    }

    .search-icon {
        position: absolute;
        left: .6rem;
        width: 14px;
        height: 14px;
        object-fit: contain;
        opacity: .4;
        pointer-events: none;
    }

    .columns-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        align-items: start;
    }

    .col-section {
        display: flex;
        flex-direction: column;
        gap: .8rem;
    }

    .col-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding-bottom: .5rem;
        border-bottom: 2px solid var(--bright-pink);
    }

    .col-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--bright-pink);
        flex-shrink: 0;
    }

    .col-dot.closed { background: var(--ink-muted); }

    .col-title {
        font-size: .85rem;
        font-weight: 800;
        color: var(--ink);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .col-count {
        margin-left: auto;
        background: var(--pink-100);
        color: var(--hot-pink);
        font-size: .72rem;
        font-weight: 800;
        padding: .15rem .55rem;
        border-radius: 999px;
        border: 1px solid var(--pink-200);
    }

    .ann-card {
        background: var(--white);
        border-radius: 16px;
        border: 2px solid var(--pink-200);
        padding: 1.1rem 1.2rem;
        display: flex;
        flex-direction: column;
        gap: .6rem;
        box-shadow: 0 3px 12px rgba(255,45,120,.07);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        cursor: default;
    }

    .ann-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255,45,120,.13);
        border-color: var(--bright-pink);
    }

    .ann-card.closed-card {
        opacity: .85;
        border-color: #e8e8e8;
    }

    .ann-card.closed-card:hover {
        border-color: var(--pink-200);
        box-shadow: 0 6px 18px rgba(0,0,0,.06);
    }

    .ann-priority {
        display: inline-flex;
        align-items: center;
        padding: .18rem .55rem;
        border-radius: 6px;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        width: fit-content;
    }

    .priority-low      { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .priority-moderate { background: #fff8e1; color: #c07800; border: 1px solid #ffd54f; }
    .priority-high     { background: #fff0f0; color: #c0303a; border: 1px solid #ffc8d0; }

    .ann-title {
        font-size: .97rem;
        font-weight: 800;
        color: var(--ink);
        line-height: 1.3;
    }

    .ann-content {
        font-size: .82rem;
        color: var(--ink-muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ann-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
        flex-wrap: wrap;
        margin-top: .2rem;
    }

    .ann-meta {
        font-size: .75rem;
        color: var(--ink-muted);
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .ann-actions {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .act-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1.5px solid var(--pink-200);
        background: var(--white);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
        font-family: var(--ff-body);
    }

    .act-btn:hover {
        border-color: var(--bright-pink);
        box-shadow: 0 3px 10px rgba(255,45,120,.15);
    }

    .act-btn img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .file-chip {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .18rem .55rem;
        border-radius: 6px;
        background: var(--pink-50);
        border: 1px solid var(--pink-200);
        font-size: .7rem;
        color: var(--ink-muted);
        font-weight: 600;
    }

    .file-chip img {
        width: 11px;
        height: 11px;
        opacity: .5;
    }

    .empty-col {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--ink-muted);
        font-size: .85rem;
        background: var(--white);
        border-radius: 14px;
        border: 2px dashed var(--pink-200);
    }

    .view-detail-row {
        display: flex;
        flex-direction: column;
        gap: .18rem;
        padding: .65rem 0;
        border-bottom: 1px solid var(--pink-100);
    }

    .view-detail-row:last-child { border-bottom: none; }

    .view-detail-label {
        font-size: .7rem;
        font-weight: 800;
        color: var(--bright-pink);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .view-detail-val {
        font-size: .875rem;
        color: var(--ink);
        font-weight: 500;
        line-height: 1.6;
    }

    .fade-up { animation: fdFadeUp .45s ease both; }
    @keyframes fdFadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .12s; }
    .d3 { animation-delay: .2s; }

    @media (max-width: 800px) {
        .columns-wrap { grid-template-columns: 1fr; }
        .page-body { padding: 1.2rem 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-text">
            <h1>Announcements</h1>
            <div class="dorm-sub">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
    </div>

    <div class="filter-bar fade-up d2">
        <div class="search-box">
            <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
            <input type="text" id="search-input" placeholder="Search announcements..." oninput="applyFilters()">
        </div>
        <select class="filter-select" id="priority-filter" onchange="applyFilters()">
            <option value="">All Priorities</option>
            <option value="high">High</option>
            <option value="moderate">Moderate</option>
            <option value="low">Low</option>
        </select>
        <select class="filter-select" id="sort-select" onchange="applyFilters()">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
        </select>
    </div>

    <div class="columns-wrap fade-up d3">
        <div class="col-section">
            <div class="col-header">
                <span class="col-dot"></span>
                <span class="col-title">All</span>
                <span class="col-count" id="active-count">0</span>
            </div>
            <div id="active-col" style="display:flex;flex-direction:column;gap:.8rem;"></div>
        </div>
        <div class="col-section">
            <div class="col-header">
                <span class="col-dot closed"></span>
                <span class="col-title">Closed</span>
                <span class="col-count" id="closed-count">0</span>
            </div>
            <div id="closed-col" style="display:flex;flex-direction:column;gap:.8rem;"></div>
        </div>
    </div>

</div>
@endsection

@section('modals')

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div class="modal-title">Announcement Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-content"></div>
        <div class="modal-actions" style="margin-top:1rem;">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const announcements = @json($announcements);
    let filtered = [...announcements];

    function priorityBadge(p) {
        const map = {
            low:      '<span class="ann-priority priority-low">Low</span>',
            moderate: '<span class="ann-priority priority-moderate">Moderate</span>',
            high:     '<span class="ann-priority priority-high">High</span>',
        };
        return map[p] ?? '<span class="ann-priority priority-low">Low</span>';
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d).toLocaleDateString('en-US', {
            month: 'short', day: 'numeric', year: 'numeric',
            hour: 'numeric', minute: '2-digit'
        });
    }

    function escHtml(str) {
        return (str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
    }

    function fileCount(attachment) {
        if (!attachment) return 0;
        return attachment.split(',').filter(f => f.trim()).length;
    }

    function buildCard(r) {
        const isClosed = r.status === 'closed';
        const files    = fileCount(r.attachment);
        return `
            <div class="ann-card ${isClosed ? 'closed-card' : ''}">
                <div>${priorityBadge(r.priority)}</div>
                <div class="ann-title">${escHtml(r.title)}</div>
                <div class="ann-content">${escHtml(r.content)}</div>
                <div class="ann-footer">
                    <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
                        <div class="ann-meta">
                            <span>${fmtDate(r.posted_at)}</span>
                        </div>
                        <div class="file-chip">
                            <img src="{{ asset('icons/attach.png') }}" alt="">
                            ${files} file${files !== 1 ? 's' : ''}
                        </div>
                    </div>
                    <div class="ann-actions">
                        <button class="act-btn" title="View" onclick='viewAnn(${JSON.stringify(r)})'>
                            <img src="{{ asset('icons/eye.png') }}" alt="View">
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function renderCols() {
        const active = filtered.filter(r => r.status !== 'closed');
        const closed = filtered.filter(r => r.status === 'closed');

        document.getElementById('active-count').textContent = active.length;
        document.getElementById('closed-count').textContent = closed.length;

        document.getElementById('active-col').innerHTML = active.length
            ? active.map(buildCard).join('')
            : '<div class="empty-col">No active announcements.</div>';

        document.getElementById('closed-col').innerHTML = closed.length
            ? closed.map(buildCard).join('')
            : '<div class="empty-col">No closed announcements.</div>';
    }

    function applyFilters() {
        const q        = document.getElementById('search-input').value.toLowerCase();
        const priority = document.getElementById('priority-filter').value;
        const sort     = document.getElementById('sort-select').value;

        filtered = announcements.filter(r => {
            const matchSearch =
                (r.title   ?? '').toLowerCase().includes(q) ||
                (r.content ?? '').toLowerCase().includes(q);
            const matchPriority = !priority || r.priority === priority;
            return matchSearch && matchPriority;
        });

        if (sort === 'newest') filtered.sort((a, b) => new Date(b.posted_at) - new Date(a.posted_at));
        if (sort === 'oldest') filtered.sort((a, b) => new Date(a.posted_at) - new Date(b.posted_at));

        renderCols();
    }

    function viewAnn(r) {
        const files = r.attachment
            ? r.attachment.split(',').filter(f => f.trim()).map(f =>
                `<a href="/storage/${f.trim()}" target="_blank" style="color:var(--bright-pink);font-size:.82rem;">${f.trim().split('/').pop()}</a>`
              ).join('<br>')
            : '—';

        document.getElementById('view-content').innerHTML = `
            <div class="view-detail-row">
                <div class="view-detail-label">Title</div>
                <div class="view-detail-val" style="font-weight:700;">${escHtml(r.title)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Priority</div>
                <div class="view-detail-val">${priorityBadge(r.priority)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Status</div>
                <div class="view-detail-val">${r.status === 'closed'
                    ? '<span class="ann-priority" style="background:#f5f5f5;color:#666;border:1px solid #ddd;">Closed</span>'
                    : '<span class="ann-priority" style="background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7;">Active</span>'}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Content</div>
                <div class="view-detail-val" style="white-space:pre-wrap;">${escHtml(r.content)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Posted</div>
                <div class="view-detail-val">${fmtDate(r.posted_at)}</div>
            </div>
            <div class="view-detail-row">
                <div class="view-detail-label">Attachments</div>
                <div class="view-detail-val">${files}</div>
            </div>
        `;
        openModal('view-modal');
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () =>
            showToast('{{ session("success") }}', 'success')
        );
    @endif

    applyFilters();
</script>
@endsection