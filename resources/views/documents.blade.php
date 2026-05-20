@extends('layout')

@section('title', 'DormEase: Document Management')
@section('page-title', 'Document Management')

@section('styles')
<style>
    .doc-subtitle {
        font-size: .9rem;
        font-weight: 600;
        color: var(--hot-pink);
        margin-top: .1rem;
    }

    .filter-bar {
        background: var(--white);
        border-bottom: 1.5px solid var(--baby-pink);
        padding: .85rem 2rem;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .filter-bar label {
        font-size: .8rem;
        color: var(--ink-muted);
        font-weight: 600;
        white-space: nowrap;
    }
    .filter-bar select,
    .filter-bar input[type="date"] {
        border: 1.5px solid var(--baby-pink);
        border-radius: 9px;
        padding: .45rem .85rem;
        font-size: .82rem;
        font-family: var(--ff-body);
        outline: none;
        background: var(--blush);
        color: var(--ink);
        cursor: pointer;
        transition: border-color .2s;
    }
    .filter-bar select:focus,
    .filter-bar input[type="date"]:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }
    .search-box {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--petal);
        border: 1.5px solid var(--baby-pink);
        border-radius: 9px;
        padding: .45rem .9rem;
        transition: border-color .2s;
    }
    .search-box:focus-within {
        border-color: var(--bright-pink);
        background: var(--white);
    }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        font-size: .82rem;
        width: 200px;
        font-family: var(--ff-body);
        color: var(--ink);
    }

    .doc-layout {
        display: flex;
        padding: 1.5rem 2rem;
        gap: 1.5rem;
        align-items: flex-start;
    }

    .type-sidebar {
        width: 210px;
        flex-shrink: 0;
        background: var(--white);
        border-radius: 14px;
        border: 1.5px solid var(--baby-pink);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    .type-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: .75rem 1rem;
        border: none;
        border-bottom: 1px solid var(--petal);
        background: transparent;
        color: var(--ink);
        font-size: .82rem;
        font-family: var(--ff-body);
        font-weight: 500;
        text-align: left;
        cursor: pointer;
        transition: background .15s, color .15s;
    }
    .type-btn:last-child { border-bottom: none; }
    .type-btn:hover:not(.active) { background: var(--blush); color: var(--hot-pink); }
    .type-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        font-weight: 700;
    }
    .type-count {
        background: var(--hot-pink);
        color: var(--white);
        border-radius: 20px;
        font-size: .7rem;
        font-weight: 800;
        padding: 1px 7px;
        min-width: 22px;
        text-align: center;
    }
    .type-btn.active .type-count {
        background: rgba(255,255,255,0.28);
    }

    .table-card {
        flex: 1;
        background: var(--white);
        border-radius: 14px;
        border: 1.5px solid var(--baby-pink);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.4rem;
        border-bottom: 1.5px solid var(--petal);
    }
    .table-card-header h2 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--hot-pink);
    }
    .btn-upload {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1.1rem;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border: none;
        border-radius: 9px;
        font-size: .82rem;
        font-weight: 700;
        font-family: var(--ff-body);
        cursor: pointer;
        box-shadow: var(--shadow-pink-btn);
        transition: opacity .2s, transform .15s;
    }
    .btn-upload:hover { opacity: .9; transform: translateY(-1px); }

    .doc-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
    .doc-table thead tr { background: var(--petal); }
    .doc-table th {
        padding: .75rem 1.2rem;
        text-align: left;
        font-weight: 700;
        color: var(--ink-muted);
        font-size: .75rem;
        white-space: nowrap;
    }
    .doc-table th .sort-arrow { color: var(--gray); margin-left: 3px; }
    .doc-table td {
        padding: .85rem 1.2rem;
        border-bottom: 1px solid var(--petal);
        color: var(--ink);
        vertical-align: middle;
    }
    .doc-table tbody tr:last-child td { border-bottom: none; }
    .doc-table tbody tr:hover { background: var(--blush); }

    .doc-title-cell {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-weight: 600;
    }
    .doc-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .action-btns { display: flex; align-items: center; gap: .6rem; }
    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--gray);
        padding: 0;
        display: flex;
        align-items: center;
        transition: color .15s;
    }
    .action-btn:hover { color: var(--hot-pink); }
    .action-btn.delete:hover { color: var(--red); }

    .empty-state {
        padding: 3rem;
        text-align: center;
        color: var(--ink-muted);
        font-size: .9rem;
    }

    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: 1.1rem;
        border-top: 1.5px solid var(--petal);
    }
    .page-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        color: var(--ink-muted);
        font-size: .82rem;
        font-weight: 500;
        font-family: var(--ff-body);
        cursor: pointer;
        transition: all .15s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .page-btn:hover:not(:disabled) { border-color: var(--hot-pink); color: var(--hot-pink); }
    .page-btn.active {
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border-color: transparent;
        font-weight: 700;
    }
    .page-btn:disabled { opacity: .4; cursor: not-allowed; }
    .page-prev-next {
        padding: 0 .9rem;
        width: auto;
        font-size: .8rem;
        font-weight: 600;
    }

    .modal-field select {
        width: 100%;
        padding: .6rem .85rem;
        border-radius: 9px;
        border: 1.5px solid var(--baby-pink);
        font-family: var(--ff-body);
        font-size: .87rem;
        color: var(--ink);
        outline: none;
        background: var(--blush);
        transition: border-color .2s;
    }
    .modal-field select:focus {
        border-color: var(--bright-pink);
        background: var(--white);
    }
    .modal-field input[type="file"] {
        padding: .45rem .85rem;
        cursor: pointer;
    }

    .detail-row {
        display: flex;
        gap: 1rem;
        padding: .55rem 0;
        border-bottom: 1px solid var(--petal);
        font-size: .85rem;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-label {
        min-width: 130px;
        color: var(--ink-muted);
        font-weight: 600;
        font-size: .78rem;
    }
    .detail-value { color: var(--ink); font-weight: 500; }
    .btn-view-file {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        margin-top: 1rem;
        padding: .55rem 1.2rem;
        background: linear-gradient(135deg, var(--bright-pink), var(--hot-pink));
        color: var(--white);
        border-radius: 9px;
        font-size: .84rem;
        font-weight: 700;
        text-decoration: none;
        transition: opacity .2s;
    }
    .btn-view-file:hover { opacity: .88; }
</style>
@endsection

@section('content')

<div style="padding: 1.2rem 2rem .4rem; background: var(--white); border-bottom: 1.5px solid var(--baby-pink);">
    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--ink);">Document Management</h1>
    <p class="doc-subtitle">Sanctissimo Rosario Ladies Dormitory</p>
</div>

<div class="filter-bar">
    <label>Filter By:</label>
    <select id="filter-status">
        <option value="">All</option>
        <option value="Active">Active</option>
        <option value="Archived">Archived</option>
    </select>

    <label>Document Type:</label>
    <select id="filter-type">
        <option value="">All</option>
        @foreach([
            'Voucher','Turnover Sheet','Tenant Info Sheet',
            'Sleepover of Non-Tenants','Letter for Renewal','Guards Form',
            'Approval to Leave After Curfew','After Curfew Arrivals','Move In/Out List'
        ] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>

    <label>From:</label>
    <input type="date" id="filter-from">
    <label>to</label>
    <input type="date" id="filter-to">

    <div class="search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--hot-pink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="search-input" placeholder="Search by Title or Tenant">
    </div>
</div>

<div class="doc-layout">

    <div class="type-sidebar" id="type-sidebar">
        <button class="type-btn active" data-type="" onclick="setType(this, '')">
            All Documents <span class="type-count" id="count-all">0</span>
        </button>
        @foreach([
            'Voucher','Turnover Sheet','Tenant Info Sheet',
            'Sleepover of Non-Tenants','Letter for Renewal','Guards Form',
            'Approval to Leave After Curfew','After Curfew Arrivals','Move In/Out List'
        ] as $type)
        <button class="type-btn" data-type="{{ $type }}" onclick="setType(this, '{{ $type }}')">
            {{ $type }}
            <span class="type-count" id="count-{{ Str::slug($type) }}">0</span>
        </button>
        @endforeach
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h2>Documents</h2>
            <button class="btn-upload" onclick="openModal('upload-modal')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Upload New Document
            </button>
        </div>

        <table class="doc-table">
            <thead>
                <tr>
                    <th>Title <span class="sort-arrow">↓</span></th>
                    <th>Document Type <span class="sort-arrow">↓</span></th>
                    <th>Tenant Name <span class="sort-arrow">↓</span></th>
                    <th>Date Posted <span class="sort-arrow">↓</span></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="doc-tbody">
                <tr><td colspan="5" class="empty-state">Loading…</td></tr>
            </tbody>
        </table>

        <div class="pagination-wrap" id="pagination"></div>
    </div>
</div>

@endsection

@section('modals')

<div class="modal-overlay" id="upload-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Upload New Document</div>
            <button class="modal-close" onclick="closeModal('upload-modal')">✕</button>
        </div>
        <div class="modal-field">
            <label>Title *</label>
            <input type="text" id="upload-title" placeholder="e.g. SR-Receipt-Feb2026">
        </div>
        <div class="modal-field">
            <label>Document Type *</label>
            <select id="upload-type">
                @foreach([
                    'Voucher','Turnover Sheet','Tenant Info Sheet',
                    'Sleepover of Non-Tenants','Letter for Renewal','Guards Form',
                    'Approval to Leave After Curfew','After Curfew Arrivals','Move In/Out List'
                ] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-field">
            <label>Tenant Name</label>
            <input type="text" id="upload-tenant" placeholder="Leave blank for admin uploads">
        </div>
        <div class="modal-field">
            <label>File (max 20MB)</label>
            <input type="file" id="upload-file">
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('upload-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitUpload()">Upload Document</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Document Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">✕</button>
        </div>
        <div id="view-modal-body"></div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Edit Document</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
        </div>
        <input type="hidden" id="edit-id">
        <div class="modal-field">
            <label>Title *</label>
            <input type="text" id="edit-title">
        </div>
        <div class="modal-field">
            <label>Document Type *</label>
            <select id="edit-type">
                @foreach([
                    'Voucher','Turnover Sheet','Tenant Info Sheet',
                    'Sleepover of Non-Tenants','Letter for Renewal','Guards Form',
                    'Approval to Leave After Curfew','After Curfew Arrivals','Move In/Out List'
                ] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-field">
            <label>Tenant Name</label>
            <input type="text" id="edit-tenant">
        </div>
        <div class="modal-field">
            <label>Status</label>
            <select id="edit-status">
                <option value="Active">Active</option>
                <option value="Archived">Archived</option>
            </select>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitEdit()">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Delete Document</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;">
            Are you sure you want to delete this document? This cannot be undone.
        </p>
        <input type="hidden" id="delete-id">
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <button class="btn-submit" style="background:var(--red);" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

const TYPE_COLORS = {
    'Voucher':                          '#FF6BA8',
    'Turnover Sheet':                   '#E8175D',
    'Tenant Info Sheet':                '#FF2D78',
    'Sleepover of Non-Tenants':         '#A06CD5',
    'Letter for Renewal':               '#4ECDC4',
    'Guards Form':                      '#45B7D1',
    'Approval to Leave After Curfew':   '#F7B731',
    'After Curfew Arrivals':            '#FC5C65',
    'Move In/Out List':                 '#26de81',
};

let state = {
    type: '',
    status: '',
    search: '',
    from: '',
    to: '',
    page: 1,
    perPage: 9,
};

function debounce(fn, ms) {
    let t;
    return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
}

document.getElementById('filter-status').addEventListener('change', e => { state.status = e.target.value; state.page = 1; fetchDocs(); });
document.getElementById('filter-type').addEventListener('change',   e => { state.type   = e.target.value; state.page = 1; syncSidebar(); fetchDocs(); });
document.getElementById('filter-from').addEventListener('change',   e => { state.from   = e.target.value; state.page = 1; fetchDocs(); });
document.getElementById('filter-to').addEventListener('change',     e => { state.to     = e.target.value; state.page = 1; fetchDocs(); });
document.getElementById('search-input').addEventListener('input', debounce(e => { state.search = e.target.value; state.page = 1; fetchDocs(); }, 350));

function setType(btn, type) {
    document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    state.type = type;
    state.page = 1;
    document.getElementById('filter-type').value = type;
    fetchDocs();
}

function syncSidebar() {
    document.querySelectorAll('.type-btn').forEach(b => {
        b.classList.toggle('active', b.dataset.type === state.type);
    });
}

async function fetchDocs() {
    const tbody = document.getElementById('doc-tbody');
    tbody.innerHTML = `<tr><td colspan="5" class="empty-state">Loading…</td></tr>`;

    const params = new URLSearchParams();
    if (state.type)   params.set('document_type', state.type);
    if (state.status) params.set('status',         state.status);
    if (state.search) params.set('search',         state.search);
    if (state.from)   params.set('from',           state.from);
    if (state.to)     params.set('to',             state.to);
    params.set('page',     state.page);
    params.set('per_page', state.perPage);

    try {
        const res  = await fetch(`/api/documents?${params}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        renderTable(data.data || []);
        renderPagination(data.last_page || 1, data.current_page || 1);
        renderCounts(data.counts || {});
    } catch {
        tbody.innerHTML = `<tr><td colspan="5" class="empty-state" style="color:var(--red)">Failed to load documents.</td></tr>`;
    }
}

function renderTable(docs) {
    const tbody = document.getElementById('doc-tbody');
    if (!docs.length) {
        tbody.innerHTML = `<tr><td colspan="5" class="empty-state">No documents found.</td></tr>`;
        return;
    }
    tbody.innerHTML = docs.map(doc => {
        const color = TYPE_COLORS[doc.document_type] || '#B5B7C0';
        const date  = doc.created_at
            ? new Date(doc.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
            : '—';
        return `
        <tr>
            <td>
                <div class="doc-title-cell">
                    <span class="doc-dot" style="background:${color}"></span>
                    ${esc(doc.title)}
                </div>
            </td>
            <td>${esc(doc.document_type)}</td>
            <td>${esc(doc.tenant_name || '—')}</td>
            <td style="white-space:nowrap">${date}</td>
            <td>
                <div class="action-btns">
                    <button class="action-btn" title="View" onclick='viewDoc(${JSON.stringify(doc)})'>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <button class="action-btn" title="Edit" onclick='editDoc(${JSON.stringify(doc)})'>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="action-btn delete" title="Delete" onclick="promptDelete(${doc.id})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

function renderCounts(counts) {
    const total = Object.values(counts).reduce((a, b) => a + b, 0);
    document.getElementById('count-all').textContent = total;
    document.querySelectorAll('.type-btn[data-type]').forEach(btn => {
        const t  = btn.dataset.type;
        if (!t) return;
        const el = btn.querySelector('.type-count');
        if (el) el.textContent = counts[t] || 0;
    });
}

function renderPagination(totalPages, current) {
    const wrap = document.getElementById('pagination');
    if (totalPages <= 1) { wrap.innerHTML = ''; return; }

    let html = `<button class="page-btn page-prev-next" ${current === 1 ? 'disabled' : ''} onclick="goPage(${current - 1})">‹ Previous</button>`;
    for (let i = 1; i <= totalPages; i++) {
        if (totalPages > 7 && i > 4 && i < totalPages - 1) {
            if (i === 5) html += `<span style="color:var(--gray);padding:0 4px">…</span>`;
            continue;
        }
        html += `<button class="page-btn ${i === current ? 'active' : ''}" onclick="goPage(${i})">${i}</button>`;
    }
    html += `<button class="page-btn page-prev-next" ${current === totalPages ? 'disabled' : ''} onclick="goPage(${current + 1})">Next ›</button>`;
    wrap.innerHTML = html;
}

function goPage(p) { state.page = p; fetchDocs(); }

function viewDoc(doc) {
    const date = doc.created_at
        ? new Date(doc.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
        : '—';
    document.getElementById('view-modal-body').innerHTML = `
        <div class="detail-row"><span class="detail-label">Title</span><span class="detail-value">${esc(doc.title)}</span></div>
        <div class="detail-row"><span class="detail-label">Document Type</span><span class="detail-value">${esc(doc.document_type)}</span></div>
        <div class="detail-row"><span class="detail-label">Tenant Name</span><span class="detail-value">${esc(doc.tenant_name || '—')}</span></div>
        <div class="detail-row"><span class="detail-label">Date Posted</span><span class="detail-value">${date}</span></div>
        <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value">${esc(doc.status || 'Active')}</span></div>
        ${doc.file_path ? `<a class="btn-view-file" href="/storage/${doc.file_path}" target="_blank">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            Open File
        </a>` : '<p style="margin-top:.8rem;font-size:.82rem;color:var(--gray)">No file attached.</p>'}
    `;
    openModal('view-modal');
}

function editDoc(doc) {
    document.getElementById('edit-id').value     = doc.id;
    document.getElementById('edit-title').value  = doc.title;
    document.getElementById('edit-type').value   = doc.document_type;
    document.getElementById('edit-tenant').value = doc.tenant_name || '';
    document.getElementById('edit-status').value = doc.status || 'Active';
    openModal('edit-modal');
}

async function submitEdit() {
    const id     = document.getElementById('edit-id').value;
    const title  = document.getElementById('edit-title').value.trim();
    const type   = document.getElementById('edit-type').value;
    const tenant = document.getElementById('edit-tenant').value.trim();
    const status = document.getElementById('edit-status').value;

    if (!title) { showToast('Title is required', 'error'); return; }

    try {
        const res = await fetch(`/api/documents/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ title, document_type: type, tenant_name: tenant, status }),
        });
        if (!res.ok) throw new Error();
        closeModal('edit-modal');
        showToast('Document updated', 'success');
        fetchDocs();
    } catch { showToast('Update failed', 'error'); }
}

async function submitUpload() {
    const title  = document.getElementById('upload-title').value.trim();
    const type   = document.getElementById('upload-type').value;
    const tenant = document.getElementById('upload-tenant').value.trim();
    const file   = document.getElementById('upload-file').files[0];

    if (!title) { showToast('Title is required', 'error'); return; }

    const fd = new FormData();
    fd.append('title', title);
    fd.append('document_type', type);
    if (tenant) fd.append('tenant_name', tenant);
    if (file)   fd.append('file', file);

    try {
        const res = await fetch('/api/documents', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        });
        if (!res.ok) throw new Error();
        closeModal('upload-modal');
        document.getElementById('upload-title').value  = '';
        document.getElementById('upload-tenant').value = '';
        document.getElementById('upload-file').value   = '';
        showToast('Document uploaded', 'success');
        fetchDocs();
    } catch { showToast('Upload failed', 'error'); }
}

function promptDelete(id) {
    document.getElementById('delete-id').value = id;
    openModal('delete-modal');
}

async function confirmDelete() {
    const id = document.getElementById('delete-id').value;
    try {
        const res = await fetch(`/api/documents/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error();
        closeModal('delete-modal');
        showToast('Document deleted', 'success');
        fetchDocs();
    } catch { showToast('Delete failed', 'error'); }
}

function esc(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

fetchDocs();
</script>
@endsection