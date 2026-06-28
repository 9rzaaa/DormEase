@extends('layout')

@section('title', 'DormEase: Contact Inquiries')
@section('page-title', 'Contact Inquiries')

@section('styles')
<style>
    .page-body {
        padding: 1.8rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
        background: var(--blush);
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

    .ci-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(140px, 1fr));
        gap: 1rem;
    }
    .ci-stat {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        box-shadow: var(--shadow);
    }
    .ci-stat-label {
        font-size: .7rem;
        font-weight: 800;
        color: var(--ink-muted);
        letter-spacing: .07em;
        text-transform: uppercase;
    }
    .ci-stat-num {
        margin-top: .35rem;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--hot-pink);
        line-height: 1;
    }

    .ci-filter {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) 160px 170px auto;
        gap: .75rem;
        align-items: end;
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-radius: 16px;
        padding: 1rem;
        box-shadow: var(--shadow);
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
        border: 1.5px solid var(--baby-pink);
        border-radius: 10px;
        background: var(--blush);
        color: var(--ink);
        font-family: var(--ff-body);
        font-size: .88rem;
        padding: .65rem .8rem;
        outline: none;
    }
    .ci-field input:focus,
    .ci-field select:focus {
        border-color: var(--bright-pink);
        background: var(--white);
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
        padding: .62rem 1rem;
        border: 0;
        border-radius: 10px;
        background: var(--gradient-pink);
        color: var(--white);
        font-size: .84rem;
        font-weight: 800;
        cursor: pointer;
        white-space: nowrap;
    }
    .ci-btn.secondary {
        background: var(--petal);
        color: var(--hot-pink);
        border: 1.5px solid var(--baby-pink);
    }

    .ci-list {
        display: flex;
        flex-direction: column;
        gap: .9rem;
    }
    .ci-card {
        background: var(--white);
        border: 1.5px solid var(--baby-pink);
        border-left: 5px solid var(--baby-pink);
        border-radius: 16px;
        padding: 1.1rem;
        box-shadow: var(--shadow);
    }
    .ci-card.status-new { border-left-color: var(--hot-pink); }
    .ci-card.status-read { border-left-color: #f59e0b; }
    .ci-card.status-resolved { border-left-color: var(--green); }
    .ci-card-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: .85rem;
    }
    .ci-sender {
        min-width: 0;
    }
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
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        background: var(--petal);
        color: var(--hot-pink);
        border: 1px solid var(--baby-pink);
    }
    .ci-badge.status-new { background: #fff0f6; color: var(--hot-pink); }
    .ci-badge.status-read { background: #fff8e6; color: #a15c00; border-color: #f8d78b; }
    .ci-badge.status-resolved { background: #effdf6; color: #16835b; border-color: #a6e7d8; }
    .ci-message {
        color: var(--ink);
        font-size: .9rem;
        line-height: 1.65;
        white-space: pre-wrap;
        padding: .85rem;
        border-radius: 12px;
        background: var(--blush);
        border: 1px solid var(--border-pink-mid);
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
    .ci-status-form {
        display: flex;
        gap: .5rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .ci-status-form select {
        border: 1.5px solid var(--baby-pink);
        border-radius: 9px;
        background: var(--white);
        padding: .48rem .65rem;
        font-family: var(--ff-body);
        font-weight: 700;
        color: var(--ink);
    }
    .ci-empty {
        background: var(--white);
        border: 1.5px dashed var(--baby-pink);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        color: var(--ink-muted);
        font-weight: 700;
    }
    .ci-pagination {
        display: flex;
        justify-content: flex-end;
    }
    .ci-pagination nav { display: flex; gap: .35rem; align-items: center; flex-wrap: wrap; }
    .ci-pagination span,
    .ci-pagination a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 .65rem;
        border-radius: 9px;
        border: 1.5px solid var(--baby-pink);
        background: var(--white);
        color: var(--ink-muted);
        font-size: .8rem;
        font-weight: 800;
    }
    .ci-pagination span[aria-current="page"] span {
        border: 0;
        background: transparent;
        color: inherit;
        min-width: 0;
        height: auto;
        padding: 0;
    }
    .ci-pagination span[aria-current="page"] {
        background: var(--gradient-pink);
        color: var(--white);
        border-color: transparent;
    }

    @media (max-width: 960px) {
        .ci-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ci-filter { grid-template-columns: 1fr 1fr; }
        .ci-filter-actions { grid-column: 1 / -1; }
    }
    @media (max-width: 640px) {
        .page-body { padding: 1.2rem; }
        .ci-stats,
        .ci-filter { grid-template-columns: 1fr; }
        .ci-card-head { flex-direction: column; }
        .ci-badges { justify-content: flex-start; }
        .ci-status-form,
        .ci-status-form select,
        .ci-status-form .ci-btn { width: 100%; }
    }
</style>
@endsection

@section('content')
<main class="page-body">
    <div class="page-header">
        <div class="page-header-text">
            <h1>Contact Inquiries</h1>
            <div class="dorm-sub">Messages submitted from the public Contact Us form</div>
        </div>
    </div>

    <div class="ci-stats">
        <div class="ci-stat">
            <div class="ci-stat-label">Total</div>
            <div class="ci-stat-num">{{ $stats['total'] }}</div>
        </div>
        <div class="ci-stat">
            <div class="ci-stat-label">New</div>
            <div class="ci-stat-num">{{ $stats['new'] }}</div>
        </div>
        <div class="ci-stat">
            <div class="ci-stat-label">Read</div>
            <div class="ci-stat-num">{{ $stats['read'] }}</div>
        </div>
        <div class="ci-stat">
            <div class="ci-stat-label">Resolved</div>
            <div class="ci-stat-num">{{ $stats['resolved'] }}</div>
        </div>
    </div>

    <form class="ci-filter" method="GET" action="{{ route('contact-inquiries.index') }}">
        <div class="ci-field">
            <label for="search">Search</label>
            <input id="search" type="search" name="search" value="{{ $search }}" placeholder="Name, email, phone, or message">
        </div>
        <div class="ci-field">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="all" @selected($status === 'all')>All</option>
                <option value="new" @selected($status === 'new')>New</option>
                <option value="read" @selected($status === 'read')>Read</option>
                <option value="resolved" @selected($status === 'resolved')>Resolved</option>
            </select>
        </div>
        <div class="ci-field">
            <label for="type">Inquiry Type</label>
            <select id="type" name="type">
                <option value="all" @selected($type === 'all')>All types</option>
                <option value="general" @selected($type === 'general')>General</option>
                <option value="reservation" @selected($type === 'reservation')>Reservation</option>
                <option value="concern" @selected($type === 'concern')>Concern</option>
                <option value="feedback" @selected($type === 'feedback')>Feedback</option>
                <option value="maintenance" @selected($type === 'maintenance')>Maintenance</option>
            </select>
        </div>
        <div class="ci-filter-actions">
            <button class="ci-btn" type="submit">Apply</button>
            <a class="ci-btn secondary" href="{{ route('contact-inquiries.index') }}">Reset</a>
        </div>
    </form>

    <div class="ci-list">
        @forelse($inquiries as $inquiry)
            <article class="ci-card status-{{ $inquiry->status }}">
                <div class="ci-card-head">
                    <div class="ci-sender">
                        <div class="ci-name">{{ $inquiry->name }}</div>
                        <div class="ci-meta">
                            <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>
                            @if($inquiry->phone)
                                <span>{{ $inquiry->phone }}</span>
                            @endif
                            <span>{{ $inquiry->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>
                    <div class="ci-badges">
                        <span class="ci-badge">{{ str_replace('_', ' ', $inquiry->inquiry_type) }}</span>
                        <span class="ci-badge status-{{ $inquiry->status }}">{{ $inquiry->status }}</span>
                    </div>
                </div>

                <div class="ci-message">{{ $inquiry->message }}</div>

                <div class="ci-card-foot">
                    <div class="ci-handler">
                        @if($inquiry->handler)
                            Handled by {{ $inquiry->handler->first_name }} {{ $inquiry->handler->last_name }}
                            @if($inquiry->handled_at)
                                on {{ $inquiry->handled_at->format('M j, Y g:i A') }}
                            @endif
                        @else
                            Not yet handled
                        @endif
                    </div>
                    <form class="ci-status-form" method="POST" action="{{ route('contact-inquiries.update-status', $inquiry) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" aria-label="Inquiry status">
                            <option value="new" @selected($inquiry->status === 'new')>New</option>
                            <option value="read" @selected($inquiry->status === 'read')>Read</option>
                            <option value="resolved" @selected($inquiry->status === 'resolved')>Resolved</option>
                        </select>
                        <button class="ci-btn" type="submit">Update</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="ci-empty">No contact inquiries found.</div>
        @endforelse
    </div>

    @if($inquiries->hasPages())
        <div class="ci-pagination">
            {{ $inquiries->links() }}
        </div>
    @endif
</main>
@endsection
