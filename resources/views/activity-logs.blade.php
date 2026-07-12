@extends('layout')

@section('title', 'DormEase: Activity Logs')
@section('page-title', 'Activity Logs')

@section('styles')
<style>
    .page-body { padding: 1.8rem 2rem; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
    .page-header h1 { font-size: 2rem; font-weight: 700; color: var(--black); letter-spacing: -.02em; line-height: 1.15; }
    .page-header .dorm-name { font-size: 1rem; font-weight: 600; color: var(--hot-pink); margin-top: .2rem; }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
    .stat-box {
        background: var(--gradient-pink);
        border-radius: 20px;
        border: none;
        box-shadow: var(--shadow-stats);
        padding: 1.6rem 1.8rem;
        display: flex; align-items: center; gap: 1.4rem;
        min-width: 0; overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(232,23,93,.35); }
    .stat-icon-circle {
        width: 72px; height: 72px; border-radius: 50%;
        background: var(--white);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; border: 2px solid var(--white);
    }
    .stat-icon-circle img {
        width: 34px; height: 34px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(11%) sepia(93%) saturate(6000%) hue-rotate(327deg) brightness(95%);
    }
    .stat-num { font-size: 2.2rem; font-weight: 700; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; color: var(--white); font-weight: 700; margin-top: .2rem; }
    .stat-sub { font-size: .76rem; color: var(--white); font-weight: 500; margin-top: .15rem; }

    .table-card {
        background: var(--white);
        border-radius: 18px;
        border: 1px solid var(--bright-pink);
        box-shadow: 0 2px 16px rgba(232,23,93,.07);
        overflow: hidden;
    }
    .table-header {
        padding: 1.1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        background: var(--white); flex-wrap: wrap; gap: .8rem;
        border-bottom: 1px solid var(--bright-pink);
    }
    .table-title { font-size: 1rem; font-weight: 800; color: var(--ink); }
    .table-date { font-size: .75rem; color: var(--ink-muted); margin-top: .15rem; }
    .table-controls { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }

    .search-wrap input,
    .sort-select {
        height: 36px;
        border-radius: 10px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        font-family: var(--ff-body);
        font-size: .82rem;
        font-weight: 600;
        color: var(--ink);
        outline: none;
        box-shadow: 0 2px 8px rgba(232,23,93,.05);
    }
    .search-wrap input { padding: .45rem .85rem; width: 220px; }
    .sort-select {
        padding: .45rem 1.8rem .45rem .75rem;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF2D78' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .6rem center;
    }
    .search-wrap input:focus,
    .sort-select:focus { border-color: var(--bright-pink); box-shadow: 0 2px 8px rgba(232,23,93,.08); }
    .search-wrap input::placeholder { color: var(--gray); }

    .btn-primary,
    .btn-outline {
        height: 36px;
        display: inline-flex; align-items: center; justify-content: center; gap: .45rem;
        padding: 0 .95rem; border-radius: 10px;
        font-size: .82rem; font-weight: 700;
        white-space: nowrap;
    }
    .btn-primary { background: var(--gradient-pink); color: var(--white); border: none; box-shadow: var(--shadow-pink-btn); }
    .btn-outline { background: var(--white); color: var(--ink-muted); border: 1.5px solid var(--gray-light); }
    .btn-outline:hover { border-color: var(--hot-pink); color: var(--hot-pink); }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; table-layout: fixed; min-width: 1060px; }
    th {
        padding: .75rem .85rem;
        text-align: center;
        font-size: .78rem;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        white-space: nowrap;
        background: var(--blush);
        border-bottom: 1px solid var(--bright-pink);
    }
    td {
        padding: .8rem .85rem;
        font-size: .875rem;
        color: var(--ink);
        vertical-align: middle;
        text-align: center;
    }
    tbody tr { border-bottom: 2px solid var(--baby-pink); transition: background .15s; }
    tbody tr:hover { background: #fff7fb; }
    tbody tr:last-child { border-bottom: none; }

    .td-main { font-weight: 700; color: var(--ink); }
    .td-muted { color: var(--ink-muted); font-size: .78rem; margin-top: .14rem; word-break: break-word; }
    .td-desc { text-align: left; }
    .badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .28rem .75rem; border-radius: 7px;
        font-size: .75rem; font-weight: 700; white-space: nowrap;
    }
    .badge-module { background: var(--petal); color: var(--hot-pink); border: 1.5px solid var(--baby-pink); }
    .badge-action { background: var(--gray-light); color: var(--badge-frontdesk-text); border: 1.5px solid var(--badge-frontdesk-border); }
    .empty-state { padding: 2rem; color: var(--ink-muted); font-weight: 700; text-align: center; }
    .table-footer {
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid var(--border); flex-wrap: wrap; gap: .75rem;
    }
    .table-showing { font-size: .8rem; color: var(--ink-muted); }
    .pagination {
        display: flex;
        align-items: center;
        gap: .35rem;
        flex-wrap: wrap;
    }
    .page-btn {
        min-width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1.5px solid var(--gray-light);
        background: var(--white);
        color: var(--ink-muted);
        font-size: .83rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 .55rem;
        transition: border-color .2s, background .2s, color .2s;
    }
    .page-btn:hover { border-color: var(--hot-pink); color: var(--hot-pink); }
    .page-btn.active { background: var(--gradient-pink); color: var(--white); border-color: var(--hot-pink); }
    .page-btn.disabled { opacity: .45; pointer-events: none; }

    @media (max-width: 980px) {
        .stats-row { grid-template-columns: 1fr; }
        .table-controls { width: 100%; }
        .search-wrap, .search-wrap input, .sort-select { width: 100%; }
        .btn-primary, .btn-outline { flex: 1; }
    }
</style>
@endsection

@section('content')
<main class="page-body">
    <div class="page-header">
        <div>
            <h1>Activity Logs</h1>
            <div class="dorm-name">System and user activity history</div>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-icon-circle"><img src="{{ asset('icons/clock.png') }}" alt=""></div>
            <div>
                <div class="stat-num">{{ number_format($totalLogs) }}</div>
                <div class="stat-label">Total Logs</div>
                <div class="stat-sub">All recorded activities</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle"><img src="{{ asset('icons/calendar.png') }}" alt=""></div>
            <div>
                <div class="stat-num">{{ number_format($todayLogs) }}</div>
                <div class="stat-label">Today</div>
                <div class="stat-sub">Activities recorded today</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle"><img src="{{ asset('icons/staff.png') }}" alt=""></div>
            <div>
                <div class="stat-num">{{ number_format($staffActors) }}</div>
                <div class="stat-label">Staff Actors</div>
                <div class="stat-sub">Staff with recorded actions</div>
            </div>
        </div>
    </div>

    <section class="table-card">
        <form class="table-header" method="GET" action="{{ route('activity-logs.index') }}">
            <div>
                <div class="table-title">Recent Activity</div>
                <div class="table-date">{{ number_format($logs->total()) }} matching record{{ $logs->total() === 1 ? '' : 's' }}</div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <input name="search" value="{{ request('search') }}" placeholder="Search activity">
                </div>
                <select class="sort-select" name="module">
                    <option value="">All modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" @selected(request('module') === $module)>{{ \Illuminate\Support\Str::of($module)->replace('_', ' ')->title() }}</option>
                    @endforeach
                </select>
                <select class="sort-select" name="action">
                    <option value="">All actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>{{ \Illuminate\Support\Str::of($action)->replace('_', ' ')->title() }}</option>
                    @endforeach
                </select>
                <select class="sort-select" name="staff_id">
                    <option value="">All staff</option>
                    @foreach($staffOptions as $staff)
                        <option value="{{ $staff->staff_id }}" @selected((string) request('staff_id') === (string) $staff->staff_id)>
                            {{ $staff->first_name }} {{ $staff->last_name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn-primary" type="submit">Filter</button>
                <a class="btn-outline" href="{{ route('activity-logs.index') }}">Reset</a>
            </div>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:150px;">Date & Time</th>
                        <th style="width:180px;">Staff</th>
                        <th style="width:130px;">Module</th>
                        <th style="width:130px;">Action</th>
                        <th>Activity</th>
                        <th style="width:135px;">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <div class="td-main">{{ $log->created_at?->format('M d, Y') }}</div>
                                <div class="td-muted">{{ $log->created_at?->format('g:i A') }}</div>
                            </td>
                            <td>
                                <div class="td-main">{{ $log->staff_name ?: 'System' }}</div>
                                <div class="td-muted">{{ $log->staff_role ? \Illuminate\Support\Str::of($log->staff_role)->title() : 'No role' }}</div>
                            </td>
                            <td><span class="badge badge-module">{{ \Illuminate\Support\Str::of($log->module)->replace('_', ' ')->title() }}</span></td>
                            <td><span class="badge badge-action">{{ \Illuminate\Support\Str::of($log->action)->replace('_', ' ')->title() }}</span></td>
                            <td class="td-desc">
                                <div class="td-main">{{ $log->description }}</div>
                                <div class="td-muted">{{ $log->method }} /{{ $log->path }}</div>
                            </td>
                            <td>{{ $log->ip_address ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">No activity logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="table-showing">
                Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
            </div>
            <div class="pagination">
                @if($logs->onFirstPage())
                    <span class="page-btn disabled">&lt;</span>
                @else
                    <a class="page-btn" href="{{ $logs->previousPageUrl() }}" rel="prev">&lt;</a>
                @endif

                @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                    @if($page === $logs->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a class="page-btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($logs->hasMorePages())
                    <a class="page-btn" href="{{ $logs->nextPageUrl() }}" rel="next">&gt;</a>
                @else
                    <span class="page-btn disabled">&gt;</span>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection
