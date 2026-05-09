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
    .btn-post img { width: 16px; height: 16px; filter: brightness(0) invert(1); }

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
        cursor: pointer; transition: background .2s;
    }
    .compose-tool-btn:hover { background: var(--pink-card); }
    .compose-tool-btn img { width: 16px; height: 16px; opacity: .6; }

    .filters-row { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
    .filter-btn {
        display: flex; align-items: center; gap: .4rem;
        padding: .42rem .9rem;
        border-radius: 8px; border: 1.5px solid var(--border);
        background: var(--white); font-size: .82rem; font-weight: 600;
        color: var(--ink-muted); cursor: pointer; transition: border-color .2s, color .2s;
    }
    .filter-btn img { width: 14px; height: 14px; opacity: .6; }
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
    .kanban-col-header .col-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--pink); flex-shrink: 0; }
    .kanban-col-header .col-title { font-size: .9rem; font-weight: 700; color: var(--ink); flex: 1; }
    .kanban-col-header .col-count { font-size: .78rem; font-weight: 700; color: var(--pink); background: var(--pink-card); border-radius: 20px; padding: .1rem .55rem; }

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
    .ann-files img { width: 12px; height: 12px; opacity: .5; }

    .empty-col { text-align: center; padding: 2rem 1rem; color: var(--ink-muted); font-size: .83rem; }
    .empty-col .empty-icon { width: 36px; height: 36px; opacity: .3; margin: 0 auto .5rem; }

    .ann-menu-wrap { position: relative; }
    .ann-dropdown {
        position: absolute; right: 0; top: 100%;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 10px; box-shadow: 0 8px 24px rgba(26,26,46,.12);
        z-index: 200; min-width: 150px;
        display: none; flex-direction: column; overflow: hidden;
    }
    .ann-dropdown.open { display: flex; }
    .ann-dropdown-item {
        padding: .6rem 1rem; font-size: .82rem; font-weight: 500;
        color: var(--ink); cursor: pointer; transition: background .15s;
        border: none; background: none; text-align: left; width: 100%;
        display: flex; align-items: center; gap: .5rem;
    }
    .ann-dropdown-item img { width: 14px; height: 14px; opacity: .7; }
    .ann-dropdown-item:hover { background: var(--pink-bg); color: var(--pink); }
    .ann-dropdown-item.danger { color: var(--red); }
    .ann-dropdown-item.danger:hover { background: #fff0f0; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(26,26,46,.45); backdrop-filter: blur(4px); z-index: 300; display: none; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal { background: var(--white); border-radius: 20px; padding: 2rem; width: 90%; max-width: 520px; box-shadow: 0 20px 60px rgba(26,26,46,.2); animation: fadeUp .3s ease; max-height: 90vh; overflow-y: auto; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
    .modal-title  { font-size: 1.15rem; font-weight: 700; color: var(--ink); }
    .modal-close  { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
    .modal-close:hover { color: var(--red); }
    .modal-field { margin-bottom: 1rem; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .35rem; }
    .modal-field input, .modal-field select, .modal-field textarea {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: #fafafa; outline: none;
        transition: border-color .2s;
    }
    .modal-field input:focus, .modal-field select:focus, .modal-field textarea:focus { border-color: var(--pink); }
    .modal-field textarea { resize: vertical; min-height: 100px; }
    .modal-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.5rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-cancel:hover { border-color: var(--pink); color: var(--pink); }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; transition: background .2s; }
    .btn-submit:hover { background: #a8446c; }
    .btn-danger { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--red); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; }

    .view-row { display: flex; justify-content: space-between; align-items: flex-start; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; flex-shrink: 0; margin-right: 1rem; }
    .view-val   { font-weight: 600; color: var(--ink); text-align: right; }

    .delete-warning { background: #fff0f0; border: 1px solid var(--blush); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--red); line-height: 1.6; }

    @media (max-width: 1100px) { .columns-wrapper { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 700px)  { .columns-wrapper { grid-template-columns: 1fr; } .page-body { padding: 1rem; } }

    .fade-up { animation: fadeUp .45s ease both; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.2s;} .d4{animation-delay:.28s;}
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
            <img src="{{ asset('icons/announce.png') }}" alt=""> Post New Announcement
        </button>
    </div>

    <div class="compose-card fade-up d2">
        <div class="compose-top">
            <div class="compose-avatar">{{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}</div>
            <input class="compose-title-input" type="text" placeholder="Write a quick announcement title..." id="quick-title" onclick="openModal('post-modal')" readonly>
            <button class="compose-close" onclick="openModal('post-modal')">
                <img src="{{ asset('icons/edit.png') }}" style="width:16px;height:16px;opacity:.5;" alt="">
            </button>
        </div>
        <textarea class="compose-body-input" id="quick-desc" placeholder="What do you want to announce?" rows="2" onclick="openModal('post-modal')" readonly></textarea>
        <div class="compose-footer">
            <div class="compose-tools">
                <button class="compose-tool-btn" title="Priority" onclick="openModal('post-modal')">
                    <img src="{{ asset('icons/flag.png') }}" alt="">
                </button>
                <button class="compose-tool-btn" title="Attach file" onclick="openModal('post-modal')">
                    <img src="{{ asset('icons/attach.png') }}" alt="">
                </button>
            </div>
            <button class="btn-post" style="padding:.4rem 1rem;font-size:.8rem;" onclick="openModal('post-modal')">
                <img src="{{ asset('icons/announce.png') }}" alt=""> Post
            </button>
        </div>
    </div>

    <div class="filters-row fade-up d3">
        <button class="filter-btn active" onclick="setFilter(this,'all')">
            <img src="{{ asset('icons/filter.png') }}" alt=""> All
        </button>
        <button class="filter-btn" onclick="setFilter(this,'week')">
            <img src="{{ asset('icons/calendar.png') }}" alt=""> This Week
        </button>
        <button class="filter-btn" onclick="setFilter(this,'month')">
            <img src="{{ asset('icons/calendar.png') }}" alt=""> This Month
        </button>
        <button class="filter-btn" onclick="setFilter(this,'high')">
            <img src="{{ asset('icons/warning.png') }}" alt=""> High Priority
        </button>
        <button class="filter-btn" onclick="setFilter(this,'low')">
            <img src="{{ asset('icons/check.png') }}" alt=""> Low Priority
        </button>
    </div>

    <div class="columns-wrapper fade-up d4">

        <div class="kanban-col">
            <div class="kanban-col-header">
                <span class="col-dot"></span>
                <span class="col-title">All</span>
                <span class="col-count">{{ $announcements->count() }}</span>
            </div>
            <div class="kanban-col-body">
                @forelse($announcements as $ann)
                    <div class="ann-card" onclick="openViewModal({{ $ann->announcement_id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-all-{{ $ann->announcement_id }}')">•••</button>
                                <div class="ann-dropdown" id="menu-all-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->announcement_id }}, event)">
                                        <img src="{{ asset('icons/edit.png') }}" alt=""> Edit
                                    </button>
                                    @if($ann->status !== 'closed')
                                        <button class="ann-dropdown-item" onclick="submitForm('archive-{{ $ann->announcement_id }}', event)">
                                            <img src="{{ asset('icons/archive.png') }}" alt=""> Archive
                                        </button>
                                    @else
                                        <button class="ann-dropdown-item" onclick="submitForm('restore-{{ $ann->announcement_id }}', event)">
                                            <img src="{{ asset('icons/restore.png') }}" alt=""> Restore
                                        </button>
                                    @endif
                                    <button class="ann-dropdown-item danger" onclick="openDeleteModal({{ $ann->announcement_id }}, '{{ addslashes($ann->title) }}', event)">
                                        <img src="{{ asset('icons/delete.png') }}" alt=""> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ann-title">{{ $ann->title }}</div>
                        <div class="ann-desc">{{ $ann->content }}</div>
                        <div class="ann-footer">
                            <span class="ann-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F j, Y · g:i A') }}</span>
                            @if($ann->attachment)
                                <span class="ann-files">
                                    <img src="{{ asset('icons/attach.png') }}" alt="">
                                    {{ count(explode(',', $ann->attachment)) }} file(s)
                                </span>
                            @endif
                        </div>
                    </div>

                    <form id="archive-{{ $ann->announcement_id }}" method="POST" action="{{ route('announcements.archive', $ann->announcement_id) }}" style="display:none;">@csrf</form>
                    <form id="restore-{{ $ann->announcement_id }}" method="POST" action="{{ route('announcements.restore', $ann->announcement_id) }}" style="display:none;">@csrf</form>

                @empty
                    <div class="empty-col">
                        <img class="empty-icon" src="{{ asset('icons/announce.png') }}" alt="">
                        <div>No announcements yet</div>
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
                    <div class="ann-card" onclick="openViewModal({{ $ann->announcement_id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-act-{{ $ann->announcement_id }}')">•••</button>
                                <div class="ann-dropdown" id="menu-act-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->announcement_id }}, event)">
                                        <img src="{{ asset('icons/edit.png') }}" alt=""> Edit
                                    </button>
                                    <button class="ann-dropdown-item" onclick="submitForm('archive-{{ $ann->announcement_id }}', event)">
                                        <img src="{{ asset('icons/archive.png') }}" alt=""> Archive
                                    </button>
                                    <button class="ann-dropdown-item danger" onclick="openDeleteModal({{ $ann->announcement_id }}, '{{ addslashes($ann->title) }}', event)">
                                        <img src="{{ asset('icons/delete.png') }}" alt=""> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ann-title">{{ $ann->title }}</div>
                        <div class="ann-desc">{{ $ann->content }}</div>
                        <div class="ann-footer">
                            <span class="ann-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F j, Y · g:i A') }}</span>
                            @if($ann->attachment)
                                <span class="ann-files">
                                    <img src="{{ asset('icons/attach.png') }}" alt="">
                                    {{ count(explode(',', $ann->attachment)) }} file(s)
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-col">
                        <img class="empty-icon" src="{{ asset('icons/check.png') }}" alt="">
                        <div>No active announcements</div>
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
                    <div class="ann-card" style="opacity:.75;" onclick="openViewModal({{ $ann->announcement_id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-cls-{{ $ann->announcement_id }}')">•••</button>
                                <div class="ann-dropdown" id="menu-cls-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="submitForm('restore-{{ $ann->announcement_id }}', event)">
                                        <img src="{{ asset('icons/restore.png') }}" alt=""> Restore
                                    </button>
                                    <button class="ann-dropdown-item danger" onclick="openDeleteModal({{ $ann->announcement_id }}, '{{ addslashes($ann->title) }}', event)">
                                        <img src="{{ asset('icons/delete.png') }}" alt=""> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ann-title">{{ $ann->title }}</div>
                        <div class="ann-desc">{{ $ann->content }}</div>
                        <div class="ann-footer">
                            <span class="ann-date">{{ \Carbon\Carbon::parse($ann->posted_at)->format('F j, Y · g:i A') }}</span>
                            @if($ann->attachment)
                                <span class="ann-files">
                                    <img src="{{ asset('icons/attach.png') }}" alt="">
                                    {{ count(explode(',', $ann->attachment)) }} file(s)
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-col">
                        <img class="empty-icon" src="{{ asset('icons/archive.png') }}" alt="">
                        <div>No closed announcements</div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@section('modals')

<div class="modal-overlay" id="post-modal">
    <div class="modal">
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
                <label>Content *</label>
                <textarea name="content" placeholder="Write your announcement here..." required></textarea>
            </div>
            <div class="modal-grid-2">
                <div class="modal-field">
                    <label>Priority</label>
                    <select name="priority">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status">
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

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Edit Announcement</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
        </div>
        <form method="POST" id="edit-form">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Title *</label>
                <input type="text" name="title" id="edit-title" required>
            </div>
            <div class="modal-field">
                <label>Content *</label>
                <textarea name="content" id="edit-content" required></textarea>
            </div>
            <div class="modal-grid-2">
                <div class="modal-field">
                    <label>Priority</label>
                    <select name="priority" id="edit-priority">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status" id="edit-status">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title" id="view-modal-title">Announcement</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-modal-content"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" id="view-edit-btn">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Delete Announcement</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <div class="delete-warning">This action cannot be undone. The announcement will be permanently removed.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);">Are you sure you want to delete <strong id="delete-ann-name" style="color:var(--ink);"></strong>?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <form method="POST" id="delete-form" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const annData = @json($announcements->keyBy('announcement_id'));

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    function toggleMenu(e, id) {
        e.stopPropagation();
        const menu   = document.getElementById(id);
        const isOpen = menu.classList.contains('open');
        document.querySelectorAll('.ann-dropdown').forEach(d => d.classList.remove('open'));
        if (!isOpen) menu.classList.add('open');
    }
    document.addEventListener('click', () => {
        document.querySelectorAll('.ann-dropdown').forEach(d => d.classList.remove('open'));
    });

    function setFilter(btn, type) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function submitForm(formId, e) {
        e.stopPropagation();
        document.getElementById(formId).submit();
    }

    function openViewModal(id) {
        const ann = annData[id];
        if (!ann) return;
        document.getElementById('view-modal-title').textContent = ann.title;
        document.getElementById('view-modal-content').innerHTML = `
            <div class="view-row"><span class="view-label">Priority</span><span class="view-val"><span class="priority-tag priority-${(ann.priority||'low').toLowerCase()}">${ucFirst(ann.priority||'low')}</span></span></div>
            <div class="view-row"><span class="view-label">Status</span><span class="view-val">${ucFirst(ann.status||'active')}</span></div>
            <div class="view-row"><span class="view-label">Posted</span><span class="view-val">${ann.posted_at||''}</span></div>
            <div style="margin-top:1rem;font-size:.9rem;color:var(--ink-muted);line-height:1.7;">${ann.content}</div>
        `;
        document.getElementById('view-edit-btn').onclick = () => { closeModal('view-modal'); openEditModal(id, new Event('click')); };
        openModal('view-modal');
    }

    function openEditModal(id, e) {
        e.stopPropagation();
        const ann = annData[id];
        if (!ann) return;
        document.getElementById('edit-form').action  = `/announcements/${id}`;
        document.getElementById('edit-title').value   = ann.title;
        document.getElementById('edit-content').value = ann.content;
        document.getElementById('edit-priority').value = ann.priority || 'low';
        document.getElementById('edit-status').value   = ann.status   || 'active';
        openModal('edit-modal');
    }

    function openDeleteModal(id, name, e) {
        e.stopPropagation();
        document.getElementById('delete-ann-name').textContent = name;
        document.getElementById('delete-form').action = `/announcements/${id}`;
        openModal('delete-modal');
    }

    function ucFirst(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    }

    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif
</script>
@endsection