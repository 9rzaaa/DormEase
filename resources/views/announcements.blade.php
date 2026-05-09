@extends('layout')

@section('title', 'DormEase — Announcements')
@section('page-title', 'Announcements')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        flex: 1;
    }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
    .page-header-left h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header-left .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }

    .btn-post {
        display: flex; align-items: center; gap: .5rem;
        padding: .55rem 1.2rem;
        background: var(--pink); color: var(--white);
        border: none; border-radius: 10px;
        font-size: .87rem; font-weight: 700;
        cursor: pointer; transition: background .2s, transform .15s;
        white-space: nowrap;
    }
    .btn-post:hover { background: #a8446c; transform: translateY(-1px); }

    .compose-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.2rem 1.4rem;
        box-shadow: var(--shadow);
    }
    .compose-top {
        display: flex; align-items: center; gap: .8rem;
        border-bottom: 1px solid var(--border);
        padding-bottom: .9rem; margin-bottom: .7rem;
    }
    .compose-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, var(--pink-400), var(--pink-600));
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .compose-title-input {
        flex: 1; border: none; outline: none;
        font-family: var(--ff-body); font-size: .95rem;
        font-weight: 600; color: var(--ink);
        background: transparent;
    }
    .compose-title-input::placeholder { color: var(--gray); font-weight: 400; }
    .compose-close {
        background: none; border: none; cursor: pointer;
        color: var(--gray); font-size: 1rem; transition: color .2s;
    }
    .compose-close:hover { color: var(--red); }
    .compose-body-input {
        width: 100%; border: none; outline: none; resize: none;
        font-family: var(--ff-body); font-size: .87rem;
        color: var(--ink-muted); background: transparent;
        min-height: 48px; line-height: 1.6;
    }
    .compose-body-input::placeholder { color: var(--gray); }
    .compose-footer {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: .7rem; padding-top: .7rem;
        border-top: 1px solid var(--border);
    }
    .compose-tools { display: flex; gap: .5rem; }
    .compose-tool-btn {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--pink-bg); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: .9rem; transition: background .2s;
    }
    .compose-tool-btn:hover { background: var(--pink-card); }

    .filters-row { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
    .filter-btn {
        display: flex; align-items: center; gap: .4rem;
        padding: .42rem .9rem;
        border-radius: 8px; border: 1.5px solid var(--border);
        background: var(--white); font-size: .82rem; font-weight: 600;
        color: var(--ink-muted); cursor: pointer; transition: border-color .2s, color .2s;
    }
    .filter-btn:hover { border-color: var(--pink); color: var(--pink); }
    .filter-btn.active { border-color: var(--pink); color: var(--pink); background: var(--pink-card); }

    .columns-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1.2rem;
        align-items: start;
    }

    .kanban-col {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .kanban-col-header {
        padding: .9rem 1.2rem;
        display: flex; align-items: center; gap: .6rem;
        border-bottom: 2px solid var(--pink);
    }
    .kanban-col-header .col-dot {
        width: 9px; height: 9px; border-radius: 50%;
        background: var(--pink); flex-shrink: 0;
    }
    .kanban-col-header .col-title {
        font-size: .9rem; font-weight: 700; color: var(--ink); flex: 1;
    }
    .kanban-col-header .col-count {
        font-size: .78rem; font-weight: 700;
        color: var(--pink); background: var(--pink-card);
        border-radius: 20px; padding: .1rem .55rem;
    }

    .kanban-col-body { padding: .9rem; display: flex; flex-direction: column; gap: .75rem; }

    .ann-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: box-shadow .2s, transform .15s;
        position: relative;
    }
    .ann-card:hover { box-shadow: 0 6px 20px rgba(202,93,134,.14); transform: translateY(-2px); }

    .ann-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: .55rem; }

    .priority-tag {
        font-size: .68rem; font-weight: 700;
        padding: .18rem .55rem; border-radius: 5px;
        border: 1.5px solid; letter-spacing: .03em; text-transform: capitalize;
    }
    .priority-low      { color: var(--green);  border-color: var(--green);  background: #f0fdf8; }
    .priority-moderate { color: var(--salmon); border-color: var(--salmon); background: #fff6f2; }
    .priority-high     { color: var(--red);    border-color: var(--red);    background: #fff0f0; }

    .ann-menu-btn {
        background: none; border: none; cursor: pointer;
        color: var(--gray); font-size: 1.1rem; padding: 0 .2rem;
        transition: color .2s; line-height: 1;
    }
    .ann-menu-btn:hover { color: var(--pink); }

    .ann-title { font-size: .92rem; font-weight: 700; color: var(--ink); margin-bottom: .35rem; line-height: 1.35; }
    .ann-desc  { font-size: .8rem; color: var(--ink-muted); line-height: 1.55; margin-bottom: .7rem;
                 display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .ann-footer { display: flex; align-items: center; justify-content: space-between; }
    .ann-date   { font-size: .73rem; color: var(--ink-muted); }
    .ann-files  { display: flex; align-items: center; gap: .3rem; font-size: .73rem; color: var(--ink-muted); }
    .ann-files svg { opacity: .6; }

    .empty-col {
        text-align: center; padding: 2rem 1rem;
        color: var(--ink-muted); font-size: .83rem;
    }
    .empty-col .empty-icon { font-size: 2rem; margin-bottom: .5rem; opacity: .4; }

    .ann-menu-wrap { position: relative; }
    .ann-dropdown {
        position: absolute; right: 0; top: 100%;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 10px; box-shadow: 0 8px 24px rgba(26,26,46,.12);
        z-index: 200; min-width: 140px;
        display: none; flex-direction: column; overflow: hidden;
    }
    .ann-dropdown.open { display: flex; }
    .ann-dropdown-item {
        padding: .6rem 1rem; font-size: .82rem; font-weight: 500;
        color: var(--ink); cursor: pointer; transition: background .15s;
        border: none; background: none; text-align: left; width: 100%;
    }
    .ann-dropdown-item:hover { background: var(--pink-bg); color: var(--pink); }
    .ann-dropdown-item.danger { color: var(--red); }
    .ann-dropdown-item.danger:hover { background: #fff0f0; }

    @media (max-width: 1100px) {
        .columns-wrapper { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 700px) {
        .columns-wrapper { grid-template-columns: 1fr; }
        .page-body { padding: 1rem; }
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-left">
            <h1>Announcements</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <button class="btn-post" onclick="openModal('post-modal')">
            ＋ Post New Announcement
        </button>
    </div>

    <div class="compose-card fade-up d2">
        <div class="compose-top">
            <div class="compose-avatar">{{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}</div>
            <input class="compose-title-input" type="text" placeholder="Title" id="quick-title">
            <button class="compose-close" onclick="document.getElementById('quick-title').value='';document.getElementById('quick-desc').value=''">✕</button>
        </div>
        <textarea class="compose-body-input" id="quick-desc" placeholder="Description" rows="2"></textarea>
        <div class="compose-footer">
            <div class="compose-tools">
                <button class="compose-tool-btn" title="Priority">🚩</button>
                <button class="compose-tool-btn" title="Attach file">🔗</button>
                <button class="compose-tool-btn" title="Schedule">🕐</button>
            </div>
            <button class="btn-post" style="padding:.4rem 1rem;font-size:.8rem;" onclick="openModal('post-modal')">
                Post New Announcement
            </button>
        </div>
    </div>

    <div class="filters-row fade-up d3">
        <button class="filter-btn active" onclick="setFilter(this,'all')">≡ Filter</button>
        <button class="filter-btn" onclick="setFilter(this,'week')">📅 This Week</button>
        <button class="filter-btn" onclick="setFilter(this,'month')">📅 This Month</button>
        <button class="filter-btn" onclick="setFilter(this,'high')">🔴 High Priority</button>
        <button class="filter-btn" onclick="setFilter(this,'low')">🟢 Low Priority</button>
    </div>

    <div class="columns-wrapper fade-up d4">

        <div class="kanban-col">
            <div class="kanban-col-header">
                <span class="col-dot"></span>
                <span class="col-title">All</span>
                <span class="col-count">{{ $announcements->count() }}</span>
            </div>
            <div class="kanban-col-body" id="col-all">
                @forelse($announcements as $ann)
                    <div class="ann-card" onclick="openViewModal({{ $ann->id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-{{ $ann->id }}')">•••</button>
                                <div class="ann-dropdown" id="menu-{{ $ann->id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->id }}, event)">✏️ Edit</button>
                                    <button class="ann-dropdown-item" onclick="archiveAnn({{ $ann->id }}, event)">📦 Archive</button>
                                    <button class="ann-dropdown-item danger" onclick="deleteAnn({{ $ann->id }}, event)">🗑 Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="ann-title">{{ $ann->title }}</div>
                        <div class="ann-desc">{{ $ann->description }}</div>
                        <div class="ann-footer">
                            <span class="ann-date">{{ \Carbon\Carbon::parse($ann->created_at ?? now())->format('F j, Y · g:i A') }}</span>
                            <span class="ann-files">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                                {{ $ann->files_count ?? 0 }} files
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-col">
                        <div class="empty-icon">📢</div>
                        No announcements yet
                    </div>
                @endforelse
            </div>
        </div>

        <div class="kanban-col">
            <div class="kanban-col-header">
                <span class="col-dot" style="background:var(--green)"></span>
                <span class="col-title">Active</span>
                <span class="col-count" style="color:var(--green);background:#f0fdf8;">
                    {{ $announcements->where('status','active')->count() }}
                </span>
            </div>
            <div class="kanban-col-body">
                @forelse($announcements->where('status','active') as $ann)
                    <div class="ann-card" onclick="openViewModal({{ $ann->id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-a-{{ $ann->id }}')">•••</button>
                                <div class="ann-dropdown" id="menu-a-{{ $ann->id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->id }}, event)">✏️ Edit</button>
                                    <button class="ann-dropdown-item" onclick="archiveAnn({{ $ann->id }}, event)">📦 Archive</button>
                                    <button class="ann-dropdown-item danger" onclick="deleteAnn({{ $ann->id }}, event)">🗑 Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="ann-title">{{ $ann->title }}</div>
                        <div class="ann-desc">{{ $ann->description }}</div>
                        <div class="ann-footer">
                            <span class="ann-date">{{ \Carbon\Carbon::parse($ann->created_at ?? now())->format('F j, Y · g:i A') }}</span>
                            <span class="ann-files">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                                {{ $ann->files_count ?? 0 }} files
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-col">
                        <div class="empty-icon">✅</div>
                        No active announcements
                    </div>
                @endforelse
            </div>
        </div>

        <div class="kanban-col">
            <div class="kanban-col-header">
                <span class="col-dot" style="background:var(--gray)"></span>
                <span class="col-title">Closed</span>
                <span class="col-count" style="color:var(--ink-muted);background:var(--gray-light);">
                    {{ $announcements->where('status','closed')->count() }}
                </span>
            </div>
            <div class="kanban-col-body">
                @forelse($announcements->where('status','closed') as $ann)
                    <div class="ann-card" style="opacity:.75;" onclick="openViewModal({{ $ann->id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-c-{{ $ann->id }}')">•••</button>
                                <div class="ann-dropdown" id="menu-c-{{ $ann->id }}">
                                    <button class="ann-dropdown-item" onclick="restoreAnn({{ $ann->id }}, event)">♻️ Restore</button>
                                    <button class="ann-dropdown-item danger" onclick="deleteAnn({{ $ann->id }}, event)">🗑 Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="ann-title">{{ $ann->title }}</div>
                        <div class="ann-desc">{{ $ann->description }}</div>
                        <div class="ann-footer">
                            <span class="ann-date">{{ \Carbon\Carbon::parse($ann->created_at ?? now())->format('F j, Y · g:i A') }}</span>
                            <span class="ann-files">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                                {{ $ann->files_count ?? 0 }} files
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-col">
                        <div class="empty-icon">🗄</div>
                        No closed announcements
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection


@section('modals')

<div class="modal-overlay" id="post-modal">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">Post New Announcement</div>
            <button class="modal-close" onclick="closeModal('post-modal')">✕</button>
        </div>

        <form method="POST" action="{{ route('announcements.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-field">
                <label>Title *</label>
                <input type="text" name="title" placeholder="e.g. Water Interruption Notice" required>
            </div>
            <div class="modal-field">
                <label>Description *</label>
                <textarea name="description" placeholder="Write your announcement here..." required></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="modal-field">
                    <label>Priority</label>
                    <select name="priority" style="width:100%;padding:.6rem .85rem;border-radius:9px;border:1.5px solid var(--gray-light);font-family:var(--ff-body);font-size:.87rem;color:var(--ink);outline:none;">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status" style="width:100%;padding:.6rem .85rem;border-radius:9px;border:1.5px solid var(--gray-light);font-family:var(--ff-body);font-size:.87rem;color:var(--ink);outline:none;">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-field">
                <label>Attach Files (optional)</label>
                <input type="file" name="files[]" multiple style="padding:.5rem .85rem;">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('post-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Post Announcement</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title" id="view-title">Announcement</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <p id="view-priority" style="margin-bottom:.8rem;"></p>
        <p id="view-desc" style="font-size:.9rem;color:var(--ink-muted);line-height:1.7;margin-bottom:1rem;"></p>
        <p id="view-date" style="font-size:.78rem;color:var(--ink-muted);"></p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function setFilter(btn, type) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function toggleMenu(e, id) {
        e.stopPropagation();
        const menu = document.getElementById(id);
        const isOpen = menu.classList.contains('open');
        document.querySelectorAll('.ann-dropdown').forEach(d => d.classList.remove('open'));
        if (!isOpen) menu.classList.add('open');
    }
    document.addEventListener('click', () => {
        document.querySelectorAll('.ann-dropdown').forEach(d => d.classList.remove('open'));
    });

    const annData = @json($announcements->keyBy('id'));

    function openViewModal(id) {
        const ann = annData[id];
        if (!ann) return;
        document.getElementById('view-title').textContent    = ann.title;
        document.getElementById('view-desc').textContent     = ann.description;
        document.getElementById('view-priority').innerHTML   =
            `<span class="priority-tag priority-${(ann.priority||'low').toLowerCase()}">${ann.priority||'Low'}</span>`;
        document.getElementById('view-date').textContent     = ann.created_at || '';
        openModal('view-modal');
    }

    function openEditModal(id, e)  { e.stopPropagation(); showToast('Edit coming soon', ''); }
    function archiveAnn(id, e)     { e.stopPropagation(); showToast('Archived!', 'success'); }
    function restoreAnn(id, e)     { e.stopPropagation(); showToast('Restored!', 'success'); }
    function deleteAnn(id, e)      { e.stopPropagation(); showToast('Deleted!', 'error'); }

    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif
</script>
@endsection