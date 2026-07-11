@extends('layout')

@section('title', 'DormEase: Activity Logs')
@section('page-title', 'Activity Logs')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        background: var(--blush);
        flex: 1;
    }

    .logs-shell {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .logs-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .logs-title h1 {
        font-size: 1.8rem;
        line-height: 1.15;
        color: var(--black);
        font-weight: 800;
    }

    .logs-title p {
        color: var(--ink-muted);
        font-size: .9rem;
        margin-top: .25rem;
    }

    .logs-count {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        color: var(--hot-pink);
        border-radius: 8px;
        padding: .55rem .8rem;
        font-weight: 800;
        font-size: .85rem;
        box-shadow: var(--shadow);
    }

    .filter-card,
    .table-card {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 12px;
        box-shadow: var(--shadow);
    }

    .filter-card {
        padding: 1rem;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1.3fr repeat(3, minmax(150px, .7fr)) auto;
        gap: .75rem;
        align-items: end;
    }

    .filter-field label {
        display: block;
        color: var(--ink-muted);
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: .35rem;
    }

    .filter-field input,
    .filter-field select {
        width: 100%;
        border: 1.5px solid var(--baby-pink);
        border-radius: 8px;
        padding: .58rem .7rem;
        color: var(--ink);
        font: inherit;
        outline: none;
        background: var(--white);
    }

    .filter-field input:focus,
    .filter-field select:focus {
        border-color: var(--hot-pink);
        box-shadow: 0 0 0 3px rgba(232, 23, 93, .12);
    }

    .filter-actions {
        display: flex;
        gap: .45rem;
        align-items: center;
    }

    .btn-filter,
    .btn-reset {
        height: 39px;
        border-radius: 8px;
        padding: 0 .9rem;
        font-size: .82rem;
        font-weight: 800;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn-filter {
        background: var(--gradient-pink);
        color: var(--white);
        box-shadow: var(--shadow-pink-btn);
    }

    .btn-reset {
        background: var(--petal);
        color: var(--hot-pink);
        border: 1.5px solid var(--baby-pink);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .logs-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 980px;
    }

    .logs-table th {
        text-align: left;
        background: var(--pink-50);
        color: var(--hot-pink);
        padding: .8rem .9rem;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        border-bottom: 1.5px solid var(--baby-pink);
        white-space: nowrap;
    }

    .logs-table td {
        padding: .75rem .9rem;
        border-bottom: 1px solid var(--petal);
        color: var(--ink);
        font-size: .84rem;
        vertical-align: top;
    }

    .logs-table tr:hover td {
        background: var(--pink-bg-soft);
    }

    .log-main {
        font-weight: 800;
        color: var(--black);
        margin-bottom: .18rem;
    }

    .log-sub {
        color: var(--ink-muted);
        font-size: .75rem;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: .22rem .55rem;
        font-size: .7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: 1px solid var(--baby-pink);
        background: var(--petal);
        color: var(--hot-pink);
        white-space: nowrap;
    }

    .pill.action {
        background: #f5f7ff;
        border-color: #dce4ff;
        color: #4056a1;
    }

    .empty-state {
        text-align: center;
        padding: 2.4rem 1rem;
        color: var(--ink-muted);
        font-weight: 700;
    }

    .pagination-wrap {
        padding: .8rem 1rem;
    }

    @media (max-width: 980px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }
        .filter-actions {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 620px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
        .filter-actions {
            flex-wrap: wrap;
        }
        .btn-filter,
        .btn-reset {
            flex: 1;
        }
    }
</style>
@endsection

@section('content')
<main class="page-body">
    <div class="logs-shell">
        <div class="logs-header">
            <div class="logs-title">
                <h1>System Activity Logs</h1>
                <p>Track staff sign-ins and important actions across DormEase.</p>
            </div>
            <div class="logs-count">{{ number_format($logs->total()) }} log{{ $logs->total() === 1 ? '' : 's' }}</div>
        </div>

        <form class="filter-card" method="GET" action="{{ route('activity-logs.index') }}">
            <div class="filter-grid">
                <div class="filter-field">
                    <label for="search">Search</label>
                    <input id="search" name="search" value="{{ request('search') }}" placeholder="Search description, staff, route, IP">
                </div>
                <div class="filter-field">
                    <label for="module">Module</label>
                    <select id="module" name="module">
                        <option value="">All modules</option>
                        @foreach($modules as $module)
                            <option value="{{ $module }}" @selected(request('module') === $module)>{{ Str::of($module)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label for="action">Action</label>
                    <select id="action" name="action">
                        <option value="">All actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" @selected(request('action') === $action)>{{ Str::of($action)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label for="staff_id">Staff</label>
                    <select id="staff_id" name="staff_id">
                        <option value="">All staff</option>
                        @foreach($staffOptions as $staff)
                            <option value="{{ $staff->staff_id }}" @selected((string) request('staff_id') === (string) $staff->staff_id)>
                                {{ $staff->first_name }} {{ $staff->last_name }} ({{ Str::of($staff->role)->title() }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button class="btn-filter" type="submit">Filter</button>
                    <a class="btn-reset" href="{{ route('activity-logs.index') }}">Reset</a>
                </div>
            </div>
        </form>

        <section class="table-card">
            <div class="table-wrap">
                <table class="logs-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Staff</th>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Route</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <div class="log-main">{{ $log->created_at?->format('M d, Y') }}</div>
                                    <div class="log-sub">{{ $log->created_at?->format('g:i A') }}</div>
                                </td>
                                <td>
                                    <div class="log-main">{{ $log->staff_name ?: 'System' }}</div>
                                    <div class="log-sub">{{ $log->staff_role ? Str::of($log->staff_role)->title() : 'No role' }}</div>
                                </td>
                                <td><span class="pill">{{ Str::of($log->module)->replace('_', ' ')->title() }}</span></td>
                                <td><span class="pill action">{{ Str::of($log->action)->replace('_', ' ')->title() }}</span></td>
                                <td>
                                    <div class="log-main">{{ $log->description }}</div>
                                    <div class="log-sub">{{ $log->method }} {{ $log->path }}</div>
                                </td>
                                <td>{{ $log->route_name ?: '-' }}</td>
                                <td>{{ $log->ip_address ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">No activity logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">
                {{ $logs->links() }}
            </div>
        </section>
    </div>
</main>
@endsection
