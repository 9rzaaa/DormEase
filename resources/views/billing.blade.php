@extends('layout')

@section('title', 'DormEase — Water Billing')
@section('page-title', 'Water Billing')

@section('styles')
<style>
    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--ink); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--pink); margin-top: .2rem; }

    .stats-card {
        background: var(--white); border-radius: 16px;
        border: 1px solid var(--border); box-shadow: var(--shadow);
        padding: 2rem 1.5rem;
        display: flex; align-items: stretch; justify-content: stretch;
        gap: 0; flex-wrap: wrap; width: 100%;
    }
    .stat-item {
        display: flex; align-items: center; gap: 1.2rem;
        flex: 1; justify-content: center;
        min-width: 200px;
        padding: .5rem 2rem;
    }
    .stat-icon-circle { width: 85px; height: 85px; border-radius: 50%; background: var(--pink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .icon-md { width: 50px; height: 50px; object-fit: contain; }
    .stat-label { font-size: .85rem; color: var(--ink-muted); font-weight: 500; }
    .stat-num   { font-size: 2.2rem; font-weight: 700; color: var(--ink); line-height: 1; letter-spacing: -.03em; }
    .stat-sub   { font-size: .78rem; color: var(--pink); font-weight: 600; margin-top: .2rem; }
    .stat-divider { width: 1px; background: var(--border); align-self: stretch; flex-shrink: 0; margin: .5rem 0; }

    .filters-row { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
    .filter-select {
        padding: .5rem .9rem; border-radius: 9px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
        outline: none; cursor: pointer; transition: border-color .2s;
    }
    .filter-select:focus { border-color: var(--pink); }
    .btn-filter {
        display: flex; align-items: center; gap: .4rem;
        padding: .5rem 1.1rem; border-radius: 9px;
        background: var(--pink); color: var(--white);
        border: none; font-size: .85rem; font-weight: 700; cursor: pointer;
        transition: background .2s;
    }
    .btn-filter:hover { background: #a8446c; }
    .btn-outline {
        display: flex; align-items: center; gap: .4rem;
        padding: .5rem 1.1rem; border-radius: 9px;
        background: var(--white); color: var(--ink-muted);
        border: 1.5px solid var(--gray-light); font-size: .85rem; font-weight: 600;
        cursor: pointer; transition: border-color .2s, color .2s;
    }
    .btn-outline:hover { border-color: var(--pink); color: var(--pink); }
    .btn-primary {
        display: flex; align-items: center; gap: .4rem;
        padding: .5rem 1.1rem; border-radius: 9px;
        background: var(--pink); color: var(--white);
        border: none; font-size: .85rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 12px rgba(202,93,134,.3);
        transition: background .2s, transform .15s;
    }
    .btn-primary:hover { background: #a8446c; transform: translateY(-1px); }
    .ms-auto { margin-left: auto; }

    .floor-group { background: var(--white); border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; margin-bottom: .5rem; }
    .floor-header {
        padding: .85rem 1.2rem;
        display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
        background: var(--pink-bg); border-bottom: 1px solid var(--border);
    }
    .floor-name { font-size: .92rem; font-weight: 700; color: var(--pink); }
    .floor-m3   { font-size: .78rem; color: var(--ink-muted); }
    .floor-meta { font-size: .82rem; color: var(--ink-muted); }
    .floor-due  { font-size: .82rem; font-weight: 700; color: var(--ink); margin-left: auto; }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--pink-bg); }
    th {
        padding: .6rem 1rem;
        text-align: center;
        font-size: .72rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
    }
    td {
        padding: .75rem 1rem; font-size: .86rem; color: var(--ink);
        border-bottom: 1px solid var(--border); vertical-align: middle;
        text-align: center;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #fdf5f8; }

    .td-check { width: 36px; }
    .td-room  { font-weight: 600; color: var(--ink-muted); font-size: .82rem; text-align: center; }
    .tenant-name { font-size: .86rem; font-weight: 500; color: var(--ink); }

    .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .dot-green  { background: #2ec27e; }
    .dot-orange { background: #f0a500; }
    .dot-red    { background: var(--red); }

    .badge { display: inline-flex; align-items: center; justify-content: center; padding: .22rem .65rem; border-radius: 6px; font-size: .72rem; font-weight: 700; white-space: nowrap; }
    .badge-paid    { background: #e8faf5; color: var(--green);  border: 1.5px solid var(--green); }
    .badge-unpaid  { background: #fff9e6; color: #c8960c;       border: 1.5px solid #f0c040; }
    .badge-overdue { background: #fff0f0; color: var(--red);    border: 1.5px solid var(--blush); }
    .badge-pending { background: #f0f4ff; color: #4a6cf7;       border: 1.5px solid #a0b4fb; }

    .td-status-col { display: flex; flex-direction: column; gap: .25rem; align-items: center; }

    .tenant-row {
        display: flex; align-items: center; gap: .5rem; justify-content: center;
    }
    .td-tenants {
        display: flex; flex-direction: column; gap: .1rem; align-items: center;
    }

    .btn-update {
        padding: .38rem .9rem; border-radius: 8px;
        background: var(--pink); color: var(--white);
        border: none; font-size: .78rem; font-weight: 700; cursor: pointer;
        transition: background .2s; white-space: nowrap;
    }
    .btn-update:hover { background: #a8446c; }

    .modal-overlay {
        position: fixed; inset: 0; background: rgba(26,26,46,.45);
        backdrop-filter: blur(4px); z-index: 300;
        display: none; align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: var(--white); border-radius: 20px;
        padding: 2rem; width: 90%; max-width: 500px;
        box-shadow: 0 20px 60px rgba(26,26,46,.2);
        animation: fadeUp .3s ease; max-height: 90vh; overflow-y: auto;
        scrollbar-width: thin; scrollbar-color: var(--pink) transparent;
    }
    .modal::-webkit-scrollbar { width: 6px; }
    .modal::-webkit-scrollbar-track { background: transparent; }
    .modal::-webkit-scrollbar-thumb { background: var(--pink); border-radius: 20px; }
    .modal::-webkit-scrollbar-thumb:hover { background: #a8446c; }

    @keyframes fadeUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
    .modal-title  { font-size: 1.15rem; font-weight: 700; color: var(--ink); }
    .modal-close  { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-muted); }
    .modal-close:hover { color: var(--red); }
    .modal-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field { margin-bottom: 0; }
    .modal-field.full { grid-column: 1/-1; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 600; color: var(--ink); margin-bottom: .35rem; }
    .modal-field input, .modal-field select {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--gray-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: #fafafa; outline: none;
        transition: border-color .2s; box-sizing: border-box;
    }
    .modal-field input:focus, .modal-field select:focus { border-color: var(--pink); background: var(--white); }
    .modal-actions { display: flex; gap: .7rem; margin-top: 1.5rem; justify-content: flex-end; }
    .btn-cancel { padding: .6rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--gray-light); background: none; font-size: .87rem; font-weight: 600; color: var(--ink-muted); cursor: pointer; }
    .btn-cancel:hover { border-color: var(--pink); color: var(--pink); }
    .btn-submit { padding: .6rem 1.4rem; border-radius: 9px; border: none; background: var(--pink); color: var(--white); font-size: .87rem; font-weight: 700; cursor: pointer; }
    .btn-submit:hover { background: #a8446c; }

    .view-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--border); font-size: .88rem; }
    .view-row:last-child { border-bottom: none; }
    .view-label { color: var(--ink-muted); font-weight: 500; }
    .view-val   { font-weight: 600; color: var(--ink); }

    .empty-floor { padding: 1.5rem; text-align: center; color: var(--ink-muted); font-size: .88rem; }

    @keyframes fadeIn { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
    .fade-up { animation: fadeIn .45s ease both; }
    .d1{animation-delay:.05s;} .d2{animation-delay:.12s;} .d3{animation-delay:.2s;} .d4{animation-delay:.28s;}

    .dot-gray { background: #bbb; }
    .badge-not-billed { background: #f5f5f5; color: #999; border: 1.5px solid #ddd; }   
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <h1>Water Billing</h1>
        <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
    </div>

    <div class="stats-card fade-up d2">
        <div class="stat-item">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/billing.png') }}" class="icon-md" alt="billing">
            </div>
            <div>
                <div class="stat-label">Water Consumption</div>
                <div class="stat-num">₱ {{ number_format($totalBill, 0) }}</div>
                <div class="stat-sub">This Month</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/pending.png') }}" class="icon-md" alt="unpaid">
            </div>
            <div>
                <div class="stat-label">Unpaid Tenants</div>
                <div class="stat-num">{{ $unpaidCount }}</div>
                <div class="stat-sub">Out of {{ $totalTenants }} tenants</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/warn.png') }}" class="icon-md" alt="overdue">
            </div>
            <div>
                <div class="stat-label">Overdue Tenants</div>
                <div class="stat-num">{{ $overdueCount }}</div>
                <div class="stat-sub">Out of {{ $totalTenants }} tenants</div>
            </div>
        </div>
    </div>

    <div class="filters-row fade-up d3">
        <select class="filter-select" id="filter-floor" onchange="applyFilters()">
            <option value="">All Floors</option>
            @foreach($floors as $floor)
                <option value="{{ $floor }}" {{ $selectedFloor == $floor ? 'selected' : '' }}>
                    Floor {{ $floor }}
                </option>
            @endforeach
        </select>
        <select class="filter-select" id="filter-month" onchange="applyFilters()">
            @foreach($months as $m)
                <option value="{{ $m['value'] }}" {{ $m['selected'] ? 'selected' : '' }}>
                    {{ $m['label'] }}
                </option>
            @endforeach
        </select>
        <button class="btn-filter" onclick="applyFilters()">≡ Filter</button>
        <button class="btn-primary ms-auto" onclick="openModal('log-modal')">Log Water Consumption</button>
        <button class="btn-outline" onclick="exportBilling()">
            <img src="{{ asset('images/export.png') }}" alt="Export" class="inline-block w-4 h-4 mr-1">
            Export
        </button>
    </div>

    <div id="billing-groups" class="fade-up d4">
        @forelse($billingGroups as $group)
        <div class="floor-group" data-floor="{{ $group['floor'] }}">
            <div class="floor-header">
                <span class="floor-name">{{ $group['submeter_label'] }}</span>
                <span class="floor-m3">{{ $group['floor_consumption_m3'] }} m³</span>
                <span class="floor-meta">Total: ₱{{ number_format($group['total_floor_bill'], 2) }}</span>
                <span class="floor-meta">{{ $group['room_count'] }} rooms – {{ $group['past_due_count'] }} Past Due</span>
                <span class="floor-due">Due: {{ $group['due_date'] }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="td-check"><input type="checkbox"></th>
                        <th>Room No.</th>
                        <th>Tenants</th>
                        <th>Room Share (Per Tenant)</th>
                        <th>Occupants</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($group['rooms'] as $room)
                    <tr>
                        <td class="td-check"><input type="checkbox"></td>
                        <td class="td-room">{{ $room['room_number'] }}</td>
                        <td>
                            <div class="td-tenants">
                                @foreach($room['tenants'] as $t)
                                <div class="tenant-row">
                                    <span class="tenant-name">{{ $t['name'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="td-tenants">
                                @foreach($room['tenants'] as $t)
                                <div class="tenant-row">
                                    <span class="dot {{ $t['dot_class'] }}"></span>
                                    <span>{{ number_format($t['room_share'], 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td>{{ $room['occupants_in_room'] }}</td>
                        <td>
                            <div class="td-status-col">
                                @foreach($room['tenants'] as $t)
                                    <span class="badge badge-{{ $t['payment_status'] }}">
                                        {{ ucfirst($t['payment_status']) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <button class="btn-update" onclick="openUpdateModal({{ json_encode($room) }})">
                                Update/View
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="empty-floor">No rooms found for this floor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--ink-muted);">No billing data for this period.</div>
        @endforelse
    </div>

</div>
@endsection

@section('modals')

<div class="modal-overlay" id="log-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Log Water Reading</div>
            <button class="modal-close" onclick="closeModal('log-modal')">✕</button>
        </div>
        <form method="POST" action="{{ route('billing.log') }}">
            @csrf
            <div class="modal-grid">
                <div class="modal-field full">
                    <label>Floor</label>
                    <select name="floor" required onchange="updateTenantPreview(this.value)">
                        <option value="">Select floor</option>
                        @foreach($activeFloors as $f)
                            <option value="{{ $f }}">
                                Floor {{ $f }}
                                {{ $unloggedFloors->contains($f) ? '⚠ Not yet logged' : '✓ Already logged' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-field full" id="tenant-preview" style="display:none;">
                    <label>Tenants on this floor</label>
                    <div id="tenant-preview-list"
                        style="background:#fafafa;border:1.5px solid var(--gray-light);border-radius:10px;padding:.75rem 1rem;font-size:.85rem;color:var(--ink);line-height:2;max-height:160px;overflow-y:auto;">
                    </div>
                </div>
                <div class="modal-field">
                    <label>Billing Month</label>
                    <input type="date" name="billing_month" required value="{{ now()->format('Y-m-01') }}">
                </div>
                <div class="modal-field">
                    <label>Due Date</label>
                    <input type="date" name="due_date" required>
                </div>
                <div class="modal-field">
                    <label>Previous Reading (m³)</label>
                    <input type="number" step="0.01" name="prev_reading" placeholder="0.00" required>
                </div>
                <div class="modal-field">
                    <label>Current Reading (m³)</label>
                    <input type="number" step="0.01" name="curr_reading" placeholder="0.00" required>
                </div>
                <div class="modal-field full">
                    <label>Rooms Sharing Submeter</label>
                    <input type="number" name="rooms_sharing" placeholder="e.g. 4" required>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('log-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Log & Distribute</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="update-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Update / View Billing</div>
            <button class="modal-close" onclick="closeModal('update-modal')">✕</button>
        </div>
        <form id="update-form">
            @csrf
            <div id="update-content"></div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('update-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>

    function applyFilters() {
        const floor = document.getElementById('filter-floor').value;
        document.querySelectorAll('.floor-group').forEach(g => {
            g.style.display = (!floor || g.dataset.floor == floor) ? '' : 'none';
        });
    }

    function openUpdateModal(room) {

        let html = `
            <div class="modal-grid" style="margin-bottom:1rem;">
                <div class="modal-field">
                    <label>Room</label>
                    <input type="text" value="${room.room_number}" disabled style="background:#f0f0f0;color:var(--ink-muted);">
                </div>
                <div class="modal-field">
                    <label>Floor</label>
                    <input type="text" value="${room.floor}" disabled style="background:#f0f0f0;color:var(--ink-muted);">
                </div>
                <div class="modal-field">
                    <label>Previous Reading (m³)</label>
                    <input type="number" step="0.01" id="edit-prev" value="${parseFloat(room.prev_reading).toFixed(2)}" oninput="recalcShare()">
                </div>
                <div class="modal-field">
                    <label>Current Reading (m³)</label>
                    <input type="number" step="0.01" id="edit-curr" value="${parseFloat(room.curr_reading).toFixed(2)}" oninput="recalcShare()">
                </div>
                <div class="modal-field">
                    <label>Floor Consumption (m³)</label>
                    <input type="text" id="edit-consumption" value="${parseFloat(room.floor_consumption_m3).toFixed(2)}" disabled style="background:#f0f0f0;color:var(--ink-muted);">
                </div>
                <div class="modal-field">
                    <label>Total Floor Bill (₱)</label>
                    <input type="text" id="edit-total-bill" value="${parseFloat(room.total_floor_bill).toFixed(2)}" disabled style="background:#f0f0f0;color:var(--ink-muted);">
                </div>
                <div class="modal-field">
                    <label>Rooms Sharing</label>
                    <input type="number" id="edit-rooms" value="${room.rooms_sharing}" min="1" oninput="recalcShare()">
                </div>
                <div class="modal-field">
                    <label>Occupants in Room</label>
                    <input type="number" id="edit-occupants" value="${room.occupants_in_room}" min="1" oninput="recalcShare()">
                </div>
                <div class="modal-field">
                    <label>Room Share Per Tenant (₱)</label>
                    <input type="text" id="edit-room-share" value="${parseFloat(room.tenants[0]?.room_share ?? 0).toFixed(2)}" disabled style="background:#f0f0f0;color:var(--ink-muted);">
                </div>
                <div class="modal-field">
                    <label>Due Date</label>
                    <input type="date" id="edit-due-date" value="${room.due_date !== '—' ? new Date(room.due_date).toISOString().split('T')[0] : ''}">
                </div>
            </div>
        `;

        room.tenants.forEach(function(t) {
            html += `
                <div style="margin-top:1rem;padding:1rem;border:1px solid var(--border);border-radius:12px;background:#fafafa;overflow:hidden;">
                    <div class="view-row">
                        <span class="view-label">Tenant</span>
                        <span class="view-val">${t.name}</span>
                    </div>
                    <div class="view-row">
                        <span class="view-label">Room Share</span>
                        <span class="view-val tenant-share-display">₱${parseFloat(t.room_share).toFixed(2)}</span>
                    </div>
                    <div class="modal-field" style="margin-top:1rem;">
                        <label>Payment Status</label>
                        <select class="status-select" data-billing-id="${t.billing_id}">
                            <option value="unpaid"  ${t.payment_status === 'unpaid'  ? 'selected' : ''}>Unpaid</option>
                            <option value="paid"    ${t.payment_status === 'paid'    ? 'selected' : ''}>Paid</option>
                            <option value="overdue" ${t.payment_status === 'overdue' ? 'selected' : ''}>Overdue</option>
                            <option value="pending" ${t.payment_status === 'pending' ? 'selected' : ''}>Pending</option>
                        </select>
                    </div>
                </div>
            `;
        });

        document.getElementById('update-form').dataset.billingId = room.tenants[0]?.billing_id ?? '';
        document.getElementById('update-content').innerHTML = html;
        openModal('update-modal');
    }

    function recalcShare() {
        const prev        = parseFloat(document.getElementById('edit-prev')?.value) || 0;
        const curr        = parseFloat(document.getElementById('edit-curr')?.value) || 0;
        const consumption = Math.max(0, curr - prev);
        document.getElementById('edit-consumption').value = consumption.toFixed(2);
    }

    document.getElementById('update-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const billing_id     = this.dataset.billingId;
        const prev_reading   = document.getElementById('edit-prev').value;
        const curr_reading   = document.getElementById('edit-curr').value;
        const rooms_sharing  = document.getElementById('edit-rooms').value;
        const occupants      = document.getElementById('edit-occupants').value;
        const due_date       = document.getElementById('edit-due-date').value;
        const firstSelect    = document.querySelector('.status-select');
        const payment_status = firstSelect ? firstSelect.value : 'unpaid';

        if (!billing_id) { showToast('No billing record found.', 'error'); return; }

        try {
            const response = await fetch("{{ route('billing.updateFull') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    billing_id        : parseInt(billing_id),
                    prev_reading      : parseFloat(prev_reading),
                    curr_reading      : parseFloat(curr_reading),
                    rooms_sharing     : parseInt(rooms_sharing),
                    occupants_in_room : parseInt(occupants),
                    due_date          : due_date,
                    payment_status    : payment_status,
                })
            });

            if (!response.ok) {
                const errText = await response.text();
                console.error('HTTP ' + response.status, errText);
                showToast('Server error ' + response.status, 'error');
                return;
            }

            const data = await response.json();

            if (data.success) {
                showToast('Billing updated successfully!', 'success');
                closeModal('update-modal');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast('Failed to update.', 'error');
            }

        } catch (err) {
            console.error('Fetch error:', err);
            showToast('Network error.', 'error');
        }
    });

    function exportBilling() {
        showToast('Billing data exported!', 'success');
    }

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    document.querySelectorAll('.modal-overlay').forEach(function(m) {
        m.addEventListener('click', function(e) {
            if (e.target === m) m.classList.remove('open');
        });
    });

    function showToast(msg, type) {
        const t = document.getElementById('toast');
        if (!t) return;
        t.textContent = msg;
        t.className = 'toast ' + (type || '');
        setTimeout(() => t.classList.add('show'), 10);
        setTimeout(() => t.classList.remove('show'), 3200);
    }

const tenantsByFloor = @json(
    $allTenants->groupBy('floor')->map(fn($tenants) =>
        $tenants->map(fn($t) => [
            'name'        => $t->first_name . ' ' . $t->last_name,
            'room_number' => $t->room_number,
        ])->values()
    )
);

function updateTenantPreview(floor) {
    const preview     = document.getElementById('tenant-preview');
    const previewList = document.getElementById('tenant-preview-list');

    if (!floor || !tenantsByFloor[floor]) {
        preview.style.display = 'none';
        return;
    }

    const tenants = tenantsByFloor[floor];
    previewList.innerHTML = tenants
        .map(t => `<div>Room ${t.room_number} &nbsp;—&nbsp; ${t.name}</div>`)
        .join('');

    preview.style.display = '';
}

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session("success") }}', 'success');
        });
    @endif

</script>
@endsection