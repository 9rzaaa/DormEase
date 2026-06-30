@extends('layout')

@section('title', 'DormEase: Manage Tenants')
@section('page-title', 'Manage Tenants')

@section('styles')
<style>
.page-body {
    padding: 1.8rem 1.8rem 1.8rem 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
    background: var(--soft-bg);
    box-sizing: border-box;
    max-width: 100%;
    min-width: 0;
}
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--black);
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0;
}
.page-header .dorm-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bright-pink);
    margin-top: .2rem;
}
.header-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
    flex-wrap: wrap;
}
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: var(--gradient-pink);
    color: var(--white);
    border: none;
    font-size: .87rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(232,23,93,.25);
    transition: .2s ease;
    white-space: nowrap;
    text-decoration: none;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 35px rgba(232,23,93,.35);
}
.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.2rem;
    border-radius: 12px;
    background: var(--white);
    color: var(--hot-pink);
    border: 1.5px solid var(--pink-100);
    font-size: .87rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    white-space: nowrap;
}
.btn-outline:hover {
    border-color: var(--bright-pink);
    color: var(--bright-pink);
}
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
    box-sizing: border-box;
}
.stat-box {
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
.stat-icon-circle {
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
.stat-icon-circle img {
    width: 28px;
    height: 28px;
    object-fit: contain;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.stat-num { font-size: 2rem; font-weight: 700; color: var(--white); line-height: 1; }
.stat-label { font-size: .8rem; color: rgba(247,245,245,.967); margin-bottom: .15rem; font-weight: 700; }
.stat-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(232,23,93,.35);
}
.stat-sub { font-size: .73rem; color: rgba(248,246,246,.955); font-weight: 600; margin-top: .15rem; }
.table-card {
    background: var(--white);
    border-radius: 18px;
    border: 1px solid var(--bright-pink);
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,.05), 0 18px 45px rgba(232,23,93,.15);
    box-sizing: border-box;
    min-width: 0;
}
.icon-sm { width: 16px; height: 16px; object-fit: contain; }
.btn-outline .icon-sm {
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.table-header {
    padding: 1.2rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .8rem;
    background: var(--white);
    border-bottom: 1px solid var(--bright-pink);
}
.table-title { font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0; }
.table-date { font-size: .78rem; color: var(--bright-pink); margin-top: .1rem; }
.table-controls { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }
.search-wrap { position: relative; display: flex; text-align: left; }
.search-wrap input {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    font-size: .85rem;
    width: 150px;
    outline: none;
    background: var(--white);
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    color: var(--ink);
    text-align: left;
}
.sort-select {
    padding: .5rem .9rem;
    border-radius: 10px;
    border: 1px solid var(--pink-100);
    font-size: .82rem;
    font-weight: 400;
    background: var(--white);
    color: var(--ink-muted);
    cursor: pointer;
    outline: none;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23E8175D' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .7rem center;
    padding-right: 2rem;
}
.sort-select:focus { box-shadow: 0 0 0 2px rgba(232,23,93,.25); }
.modal-field select.auto-updated {
    border-color: var(--bright-pink);
    box-shadow: 0 0 0 3px rgba(232,23,93,.12);
    transition: border-color .3s, box-shadow .3s;
}
.table-wrap { overflow-x: auto; background: var(--white); -webkit-overflow-scrolling: touch; }
table { width: 100%; border-collapse: collapse; background: var(--white); min-width: 700px; }
thead tr { background: var(--blush); border-bottom: 1px solid var(--bright-pink); }
th {
    padding: .75rem 1rem;
    font-size: .75rem;
    font-weight: 600;
    color: var(--bright-pink);
    letter-spacing: .04em;
    text-transform: uppercase;
    white-space: nowrap;
    background: var(--blush);
    text-align: left;
    vertical-align: middle;
}
td {
    padding: .85rem 1rem;
    font-size: .875rem;
    border-bottom: 1px solid var(--pink-100);
    color: var(--ink);
    text-align: left;
    vertical-align: middle;
}
th:nth-child(2), td:nth-child(2) { text-align: center; }
th:nth-child(3), td:nth-child(3) { text-align: center; }
th:nth-child(6), td:nth-child(6) { text-align: center; }
th:nth-child(6), td:nth-child(6) { text-align: center; }
th:nth-child(7), td:nth-child(7) { text-align: center; }
th:nth-child(8), td:nth-child(8) { text-align: center; }
.td-center { text-align: center; }
tbody tr:hover { background: var(--soft-bg); }
.badge { display: inline-flex; align-items: center; padding: .28rem .75rem; border-radius: 999px; font-size: .75rem; font-weight: 700; }
.badge-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-pending  { background: #eef4ff; color: #3b6fd4; border: 1px solid #a8c4f5; }
.badge-inactive { background: #fff0f0; color: #e04867; border: 1px solid var(--pink-200); }
.badge-moveout    { background: var(--petal); color: var(--hot-pink); border: 1px solid #ff9db0; }
.badge-reserved   { background: #fff8e0; color: #9a6200; border: 1px solid #f0c840; }
.badge-temp     { background: #fff3b0; color: #5a3d00; border: 1px solid #ffd84d; font-weight: 700; box-shadow: 0 4px 10px rgba(255,216,77,.25); }
.tenant-section-pill-pink { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--pink-200); }
.tenant-section-bar-pink  { background: var(--gradient-pink); }
.action-group { display: flex; align-items: center; gap: .4rem; flex-wrap: nowrap; justify-content: center; }
.act-btn {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: 1px solid var(--pink-100);
    background: var(--white);
    cursor: pointer;
    transition: .2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    flex-shrink: 0;
}
.act-btn:hover { border-color: var(--bright-pink); box-shadow: 0 6px 14px rgba(232,23,93,.15); }
.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .9rem 1.2rem;
    flex-wrap: wrap;
    gap: .5rem;
    border-top: 1px solid var(--pink-100);
}
.table-showing { font-size: .8rem; color: #b06080; }
.pagination { display: flex; align-items: center; gap: .3rem; flex-wrap: wrap; }
.page-btn {
    min-width: 32px; height: 32px; padding: 0 .5rem;
    border-radius: 8px; border: 1.5px solid var(--pink-100);
    background: var(--white); color: var(--hot-pink);
    font-size: .82rem; font-weight: 600; cursor: pointer; transition: .2s;
}
.page-btn:hover:not(:disabled) { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.page-btn.active { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.page-btn:disabled { opacity: .4; cursor: default; }
.modal-overlay {
    position: fixed; inset: 0; z-index: 800;
    display: none; align-items: center; justify-content: center;
    background: rgba(90,30,56,.38);
    backdrop-filter: blur(4px);
    padding: 1rem;
}
.modal-overlay.open { display: flex; }
.modal {
    background: var(--white);
    border-radius: 20px;
    width: 100%; max-width: 540px;
    box-shadow: 0 24px 60px rgba(232,23,93,.18), 0 4px 16px rgba(0,0,0,.08);
    display: flex; flex-direction: column;
    max-height: 92vh;
    overflow: hidden;
    animation: modalIn .28s cubic-bezier(.34,1.3,.64,1) both;
}
@keyframes modalIn {
    from { opacity: 0; transform: translateY(18px) scale(.97); }
    to   { opacity: 1; transform: translateY(0)   scale(1);    }
}
.modal-header {
    padding: .6rem .9rem .6rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.modal-title {
    font-size: 1.1rem; font-weight: 800; color: var(--ink);
    letter-spacing: -.02em; display: flex; align-items: center; gap: .5rem;
}
.modal-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1.5px solid var(--pink-100); background: var(--petal);
    color: var(--bright-pink); font-size: 1rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s, color .2s, border-color .2s; flex-shrink: 0;
}
.modal-close:hover { background: var(--bright-pink); color: var(--white); border-color: var(--bright-pink); }
.modal-body {
    flex: 1; overflow-y: auto; padding: .65rem .9rem;
    scrollbar-width: thin; scrollbar-color: var(--pink-200) transparent;
}
.modal-body::-webkit-scrollbar { width: 5px; }
.modal-body::-webkit-scrollbar-track { background: transparent; }
.modal-body::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }
.modal-section { margin-bottom: .65rem; }
.modal-section-title {
    font-size: .7rem; font-weight: 800; color: var(--bright-pink);
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .55rem; padding-bottom: .3rem;
    border-bottom: 1.5px solid var(--petal);
    display: flex; align-items: center; gap: .4rem;
}
.modal-section-title::before {
    content: '';
    display: inline-block; width: 3px; height: 12px;
    background: var(--gradient-pink); border-radius: 2px;
}
.modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .45rem; }
.modal-field { display: flex; flex-direction: column; gap: .25rem; }
.modal-field.full { grid-column: 1 / -1; }
.modal-field label {
    font-size: .72rem; font-weight: 700; color: var(--hot-pink);
    text-transform: uppercase; letter-spacing: .04em;
}
.modal-field input,
.modal-field select {
    width: 100%; padding: .5rem .8rem; border-radius: 10px;
    border: 1.5px solid var(--pink-100); background: #fffafd;
    font-size: .875rem; color: #5a1e38; outline: none;
    box-sizing: border-box; transition: border-color .2s, box-shadow .2s, background .2s;
    font-family: inherit;
}
.modal-field input:hover, .modal-field select:hover { border-color: var(--pink-200); background: #fff5f9; }
.modal-field input:focus, .modal-field select:focus {
    border-color: var(--bright-pink);
    box-shadow: 0 0 0 3px rgba(232,23,93,.1);
    background: var(--white);
}
.modal-field input::placeholder { color: #c4a0af; }
.modal-field input.field-invalid {
    border-color: #e04867;
    box-shadow: 0 0 0 3px rgba(224,72,103,.12);
    background: #fff5f6;
}
.field-error { line-height: 1.4; }
.status-select-wrap { position: relative; }
.status-dot {
    position: absolute; left: .75rem; top: 50%; transform: translateY(-50%);
    width: 8px; height: 8px; border-radius: 50%; pointer-events: none;
    transition: background .2s;
}
.status-select-wrap select { padding-left: 1.9rem; }
.modal-info-banner {
    background: linear-gradient(135deg, #fff5f9 0%, #ffe8f2 100%);
    border: 1.5px solid var(--pink-100); border-radius: 10px;
    padding: .55rem .8rem; font-size: .8rem; color: #7a3050; line-height: 1.5;
    display: flex; gap: .55rem; align-items: flex-start; margin-bottom: .9rem;
}
.modal-warn-banner {
    background: #fff9e6; border: 1.5px solid #f0c040; border-radius: 10px;
    padding: .55rem .8rem; font-size: .8rem; color: #7a5400; line-height: 1.5;
    display: flex; gap: .55rem; align-items: flex-start;
}
.modal-footer {
    padding: .55rem .9rem;
    border-top: 1.5px solid var(--pink-100);
    display: flex; align-items: center; justify-content: flex-end; gap: .55rem;
    flex-shrink: 0; background: #fffafd;
}
.btn-cancel {
    padding: .6rem 1.25rem; border-radius: 10px;
    border: 1.5px solid var(--pink-100); background: var(--white);
    color: var(--ink-muted); font-size: .875rem; font-weight: 600;
    cursor: pointer; transition: .2s; font-family: inherit;
}
.btn-cancel:hover { border-color: var(--bright-pink); color: var(--hot-pink); background: var(--petal); }
.btn-submit {
    padding: .6rem 1.4rem; border-radius: 10px;
    border: none; background: var(--gradient-pink);
    color: var(--white); font-size: .875rem; font-weight: 700;
    cursor: pointer; transition: .2s; font-family: inherit;
    box-shadow: 0 8px 20px rgba(232,23,93,.25);
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 12px 28px rgba(232,23,93,.35); }
.btn-submit:active { transform: translateY(0); }
.view-row { display: flex; justify-content: space-between; align-items: center; padding: .6rem 0; border-bottom: 1px solid var(--pink-100); gap: .5rem; }
.view-row:last-child { border-bottom: none; }
.view-label { font-size: .72rem; font-weight: 700; color: var(--hot-pink); text-transform: uppercase; letter-spacing: .04em; flex-shrink: 0; }
.view-val { font-size: .875rem; color: #5a1e38; font-weight: 500; text-align: right; word-break: break-word; }
.credentials-box { background: var(--soft-bg); border: 1.5px solid var(--pink-100); border-radius: 12px; padding: 1rem 1.2rem; margin-bottom: 1rem; }
.credentials-box h4 { font-size: .8rem; font-weight: 700; color: var(--hot-pink); text-transform: uppercase; letter-spacing: .04em; margin-bottom: .75rem; }
.credential-row { display: flex; align-items: center; justify-content: space-between; padding: .5rem 0; border-bottom: 1px solid var(--pink-100); gap: .5rem; flex-wrap: wrap; }
.credential-row:last-child { border-bottom: none; }
.credential-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; margin-bottom: .15rem; }
.credential-value { font-size: .92rem; font-weight: 700; color: var(--ink); font-family: monospace; word-break: break-all; }
.copy-btn { padding: .3rem .75rem; border-radius: 7px; border: 1.5px solid var(--pink-100); background: var(--white); color: var(--hot-pink); font-size: .75rem; font-weight: 700; cursor: pointer; transition: .2s; flex-shrink: 0; }
.copy-btn:hover { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.credentials-warning { background: #fff9e6; border: 1px solid #f0c040; border-radius: 10px; padding: .75rem 1rem; font-size: .82rem; color: #7a5400; margin-bottom: 1rem; line-height: 1.5; }
.delete-warning { background: #fff0f0; border: 1px solid var(--pink-200); border-radius: 10px; padding: .75rem 1rem; font-size: .85rem; color: #e04867; margin-bottom: 1rem; }
.tenant-section { background: var(--white); border-radius: 18px; border: 1px solid var(--bright-pink); overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,.05), 0 18px 45px rgba(232,23,93,.15); box-sizing: border-box; min-width: 0; }
.tenant-section-header { padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer; user-select: none; transition: background .2s; gap: 1rem; }
.tenant-section-header:hover { background: var(--blush); }
.tenant-section-title { display: flex; align-items: center; gap: .65rem; }
.tenant-section-label { font-size: 1rem; font-weight: 800; color: var(--ink); letter-spacing: -.01em; }
.tenant-section-pill { font-size: .7rem; font-weight: 800; padding: .22rem .6rem; border-radius: 99px; letter-spacing: .03em; }
.tenant-section-pill-overdue { background: #fff0f0; color: #e04867; border: 1px solid var(--pink-200); }
.tenant-section-pill-active { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.tenant-section-pill-pending { background: #fff9e6; color: #c8960c; border: 1px solid #f0c040; }
.tenant-section-chevron { transition: transform .25s cubic-bezier(.4,0,.2,1); flex-shrink: 0; }
.tenant-section-chevron.open { transform: rotate(180deg); }
.tenant-section-body { border-top: 1px solid var(--pink-100); }
.tenant-section-empty { padding: 2rem; text-align: center; font-size: .85rem; color: var(--ink-muted); }
.tenant-section-bar { height: 3px; width: 100%; }
.tenant-section-bar-active { background: linear-gradient(90deg, #1f9d69, #4ecb8d); }
.tenant-section-bar-pending { background: linear-gradient(90deg, #f0c040, #ffd84d); }

.tv-header { display: flex; align-items: center; gap: 1rem; padding-bottom: 1rem; margin-bottom: 1rem; border-bottom: 1.5px solid var(--petal); }
.tv-avatar { width: 58px; height: 58px; border-radius: 50%; background: var(--gradient-pink); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.3rem; letter-spacing: .02em; flex-shrink: 0; box-shadow: 0 8px 20px rgba(232,23,93,.25); }
.tv-header-info { flex: 1; min-width: 0; }
.tv-name { font-size: 1.15rem; font-weight: 800; color: var(--ink); letter-spacing: -.01em; line-height: 1.25; }
.tv-account-id { font-size: .78rem; color: var(--bright-pink); font-family: monospace; font-weight: 700; margin-top: .2rem; letter-spacing: .03em; }
.tv-header-badges { display: flex; gap: .4rem; margin-top: .55rem; flex-wrap: wrap; }
.tv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-bottom: 1.1rem; }
.tv-grid:last-child { margin-bottom: 0; }
.tv-item { background: #fffafd; border: 1.5px solid var(--pink-100); border-radius: 12px; padding: .65rem .85rem; transition: border-color .2s, background .2s; }
.tv-item:hover { border-color: var(--pink-200); background: #fff5f9; }
.tv-item.full { grid-column: 1 / -1; }
.tv-item-label { font-size: .68rem; font-weight: 800; color: var(--hot-pink); text-transform: uppercase; letter-spacing: .06em; margin-bottom: .3rem; }
.tv-item-value { font-size: .9rem; font-weight: 600; color: #5a1e38; word-break: break-word; line-height: 1.4; }
.room-occupant-card {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .65rem .85rem;
    background: #fffafd;
    border: 1.5px solid var(--pink-100);
    border-radius: 12px;
    transition: border-color .2s, background .2s;
}
.room-occupant-card:hover { border-color: var(--pink-200); background: #fff5f9; }
.room-occupant-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--gradient-pink);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .78rem;
    font-weight: 800;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(232,23,93,.2);
}
.room-occupant-name { font-size: .88rem; font-weight: 700; color: var(--ink); line-height: 1.25; }
.room-occupant-sub  { font-size: .72rem; color: var(--ink-muted); margin-top: .1rem; }
.overdue-date {
    color: #e04867;
    font-weight: 700;
    text-decoration: underline dotted #e04867;
    text-decoration-thickness: 1.5px;
    cursor: pointer;
    position: relative;
    transition: color .15s;
}
.overdue-date:hover { color: #b0163a; }
.overdue-date-tooltip {
    display: none;
    position: fixed;
    background: var(--ink);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
    padding: .5rem .75rem;
    border-radius: 8px;
    max-width: 280px;
    white-space: normal;
    line-height: 1.45;
    box-shadow: 0 8px 20px rgba(0,0,0,.18);
    z-index: 9999;
    pointer-events: none;
}
.overdue-date-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: var(--ink);
}

@keyframes pulseGreen {
    0%, 100% { box-shadow: 0 0 0 3px rgba(31,157,105,.2); }
    50%       { box-shadow: 0 0 0 5px rgba(31,157,105,.3); }
}
.fade-up { animation: fadeIn .45s ease both; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
.d1 { animation-delay: .05s; }
.d2 { animation-delay: .12s; }
.d3 { animation-delay: .2s; }
.tenant-archive-drawer {
    position: fixed; top: 0; right: 0; bottom: 0;
    width: min(660px, 100vw);
    background: var(--soft-bg);
    z-index: 500;
    display: flex; flex-direction: column;
    transform: translateX(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    box-shadow: -8px 0 40px rgba(214,51,117,.15);
}
.tenant-archive-drawer.open { transform: translateX(0); }
.tenant-archive-backdrop {
    position: fixed; inset: 0;
    background: rgba(232,23,93,.18);
    backdrop-filter: blur(3px);
    z-index: 499; opacity: 0; pointer-events: none;
    transition: opacity .38s ease;
}
.tenant-archive-backdrop.open { opacity: 1; pointer-events: auto; }
.tad-header { padding: 1.6rem 1.8rem 1.2rem; border-bottom: 1px solid var(--pink-100); display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-shrink: 0; }
.tad-title { font-size: 1.3rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; line-height: 1.2; }
.tad-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .25rem; font-weight: 500; }
.tad-close { width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--pink-100); background: var(--petal); color: var(--bright-pink); font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s, color .2s; flex-shrink: 0; }
.tad-close:hover { background: var(--pink-100); color: var(--hot-pink); }
.tad-tabs { display: flex; gap: 0; padding: 0 1.8rem; border-bottom: 1px solid var(--pink-100); flex-shrink: 0; background: var(--white); }
.tad-tab { padding: .85rem 1.1rem; font-size: .82rem; font-weight: 700; color: var(--ink-muted); background: none; border: none; border-bottom: 2.5px solid transparent; margin-bottom: -1px; cursor: pointer; transition: color .2s, border-color .2s; display: flex; align-items: center; gap: .45rem; letter-spacing: .01em; font-family: var(--ff-body); white-space: nowrap; }
.tad-tab:hover { color: var(--hot-pink); }
.tad-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }
.tad-tab-count { font-size: .68rem; font-weight: 800; padding: .1rem .45rem; border-radius: 99px; background: var(--petal); color: var(--ink-muted); letter-spacing: .02em; min-width: 18px; text-align: center; }
.tad-tab.active .tad-tab-count { background: var(--bright-pink); color: var(--white); }
.tad-search-bar { padding: 1rem 1.8rem .8rem; flex-shrink: 0; }
.tad-search-inner { position: relative; display: flex; align-items: center; }
.tad-search-inner input { width: 100%; padding: .55rem .9rem .55rem 2.2rem; border-radius: 10px; border: 1px solid var(--pink-100); background: var(--white); color: var(--ink); font-size: .83rem; font-family: var(--ff-body); outline: none; transition: border-color .2s, background .2s; box-sizing: border-box; }
.tad-search-inner input::placeholder { color: var(--ink-muted); }
.tad-search-inner input:focus { border-color: var(--bright-pink); background: var(--blush); }
.tad-search-icon { position: absolute; left: .75rem; width: 13px; height: 13px; opacity: .5; pointer-events: none; }
.tad-list { flex: 1; overflow-y: auto; padding: 0 1.8rem 1.8rem; display: flex; flex-direction: column; gap: .75rem; }
.tad-list::-webkit-scrollbar { width: 4px; }
.tad-list::-webkit-scrollbar-track { background: transparent; }
.tad-list::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }
.tad-card { background: var(--white); border: 1px solid var(--pink-100); border-radius: 14px; padding: 1rem 1.1rem; transition: background .2s, border-color .2s; animation: tadSlideIn .3s ease both; }
@keyframes tadSlideIn { from { opacity: 0; transform: translateX(12px); } to { opacity: 1; transform: translateX(0); } }
.tad-card:hover { background: var(--blush); border-color: var(--bright-pink); }
.tad-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: .8rem; margin-bottom: .5rem; }
.tad-card-id { font-size: .75rem; font-weight: 800; color: var(--bright-pink); letter-spacing: .02em; font-family: monospace; }
.tad-card-time { font-size: .7rem; color: var(--ink-muted); font-weight: 500; white-space: nowrap; flex-shrink: 0; }
.tad-card-name { font-size: .9rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
.tad-card-email { font-size: .73rem; color: var(--ink-muted); margin-top: .1rem; }
.tad-card-meta { display: flex; align-items: center; gap: .45rem; margin-top: .6rem; flex-wrap: wrap; }
.tad-pill { font-size: .68rem; font-weight: 700; padding: .18rem .55rem; border-radius: 99px; letter-spacing: .03em; text-transform: uppercase; }
.tad-pill-room     { background: var(--petal);   color: var(--ink-muted); border: 1px solid var(--pink-100); }
.tad-pill-stay     { background: var(--pink-100); color: var(--hot-pink);  border: 1px solid var(--pink-200); }
.tad-pill-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.tad-pill-pending  { background: #fff9e6; color: #c8960c; border: 1px solid #f0c040; }
.tad-pill-moveout    { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--pink-200); }
.tad-pill-inactive   { background: var(--blush); color: var(--ink-muted); border: 1px solid var(--pink-100); }
.tad-pill-reserved   { background: #fff8e0; color: #9a6200; border: 1px solid #f0c840; }
.tad-card-archived { display: flex; align-items: center; gap: .4rem; margin-top: .75rem; padding-top: .6rem; border-top: 1px solid var(--pink-100); font-size: .7rem; color: var(--ink-muted); font-weight: 500; }
.tad-card-archived span { color: var(--bright-pink); font-weight: 600; }
.tad-empty { text-align: center; padding: 3rem 1rem; color: var(--ink-muted); font-size: .85rem; }
.tad-empty-icon { width: 40px; height: 40px; margin: 0 auto .75rem; opacity: .3; display: block; }
.tad-footer { padding: .9rem 1.8rem; border-top: 1px solid var(--pink-100); background: var(--white); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; flex-wrap: wrap; gap: .5rem; }
.tad-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
.tad-export-btn { display: inline-flex; align-items: center; gap: .4rem; font-size: .75rem; font-weight: 700; color: var(--bright-pink); background: var(--petal); border: 1px solid var(--pink-100); border-radius: 8px; padding: .35rem .85rem; cursor: pointer; transition: background .2s, color .2s, border-color .2s; font-family: var(--ff-body); }
.tad-export-btn:hover { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.tad-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .7; }
.log-card { background: var(--white); border: 1px solid var(--pink-100); border-radius: 12px; padding: .75rem 1rem; display: flex; align-items: center; gap: .85rem; transition: background .2s, border-color .2s; animation: tadSlideIn .3s ease both; }
.log-card:hover { background: var(--blush); border-color: var(--bright-pink); }
.log-action-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.log-action-icon.in  { background: #e8faf5; border: 1.5px solid #8ce0bb; }
.log-action-icon.out { background: #fff0f4; border: 1.5px solid #ffc2d1; }
.log-info { flex: 1; min-width: 0; }
.log-name { font-size: .87rem; font-weight: 700; color: var(--ink); }
.log-meta { font-size: .72rem; color: var(--ink-muted); margin-top: .15rem; }
.log-time-col { font-size: .7rem; font-weight: 600; color: var(--ink-muted); text-align: right; flex-shrink: 0; white-space: nowrap; }
.tad-pill-timein  { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.tad-pill-timeout { background: #fff0f4; color: #b0163a; border: 1px solid #ffc2d1; }
.export-dropdown { position: relative; display: inline-flex; }
.export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-100); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
.export-menu.open { display: block; }
.export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
.export-menu button:hover { background: var(--petal); color: var(--hot-pink); }
.action-loading-overlay { position: fixed; inset: 0; z-index: 1200; display: none; align-items: center; justify-content: center; background: rgba(255,255,255,.72); backdrop-filter: blur(2px); }
.action-loading-overlay.open { display: flex; }
.action-loading-box { display: flex; align-items: center; flex-direction: column; gap: .75rem; padding: 1.25rem 1.6rem; border: 1px solid var(--border); border-radius: 12px; background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14); color: var(--ink); font-size: .9rem; font-weight: 700; }
.loading-logo-wrap { width: 86px; height: 86px; border: 3px solid var(--pink-50); border-radius: 50%; background: var(--gradient-pink); display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 24px rgba(232,23,93,.25); animation: pulseLogo 1s ease-in-out infinite; flex-shrink: 0; }
.loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }
.is-loading { opacity: .75; pointer-events: none; }
@keyframes pulseLogo { 0%, 100% { transform: scale(1); box-shadow: 0 10px 24px rgba(232,23,93,.25); } 50% { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); } }
@media (max-width: 1100px) { .stats-row { grid-template-columns: repeat(3, 1fr); } .stat-num { font-size: 1.6rem; } }
@media (max-width: 900px) { .page-body { padding: 1.2rem 1rem 1.2rem 1.2rem; gap: 1.2rem; } .stats-row { grid-template-columns: 1fr 1fr; } .modal-grid { grid-template-columns: 1fr; } .stat-box { padding: 1rem 1.1rem; gap: .9rem; } .stat-icon-circle { width: 44px; height: 44px; } .stat-icon-circle img { width: 22px; height: 22px; } .stat-num { font-size: 1.5rem; } }
@media (max-width: 680px) { .page-body { padding: 1rem .75rem 1rem 1rem; gap: 1rem; } .page-header h1 { font-size: 1.5rem; } .stats-row { grid-template-columns: 1fr; } .stat-box { padding: 1rem 1.2rem; } .stat-num { font-size: 1.75rem; } .table-header { padding: 1rem; flex-direction: column; align-items: flex-start; } .table-controls { width: 100%; } .search-wrap { flex: 1; } .search-wrap input { width: 100%; } .sort-select { flex: 1; min-width: 0; } .table-footer { flex-direction: column; align-items: flex-start; gap: .6rem; } .pagination { width: 100%; justify-content: center; } .btn-primary, .btn-outline { font-size: .82rem; padding: .55rem 1rem; } }
@media (max-width: 480px) { .page-body { padding: .8rem .6rem .8rem .8rem; gap: .9rem; } .page-header { gap: .6rem; } .page-header h1 { font-size: 1.3rem; } .header-actions { width: 100%; } .header-actions .btn-primary, .header-actions .btn-outline { flex: 1; justify-content: center; } .stat-box { gap: .75rem; padding: .9rem 1rem; } .stat-label { font-size: .72rem; } .stat-sub { font-size: .67rem; } .credentials-box { padding: .75rem .9rem; } .table-controls { flex-direction: column; align-items: stretch; } .search-wrap input { width: 100%; } .sort-select { width: 100%; } .tad-tabs { padding: 0 1rem; } .tad-tab { padding: .75rem .75rem; font-size: .76rem; } .modal-grid { grid-template-columns: 1fr; } .modal-footer { flex-direction: column-reverse; } .btn-cancel, .btn-submit { width: 100%; justify-content: center; } }
@media (max-width: 360px) { .stat-icon-circle { display: none; } .act-btn { width: 28px; height: 28px; } .stat-num { font-size: 1.4rem; } .stat-box { padding: .75px; } }
@media (max-width: 768px) { .action-group { flex-direction: column; gap: .25rem; } .act-btn { width: 28px; height: 28px; } }
@media (max-width: 700px) { .tad-header { padding: 1.2rem 1rem .9rem; } .tad-list { padding: 0 1rem 1.2rem; } .tad-search-bar { padding: .8rem 1rem .6rem; } .tad-footer { padding: .75rem 1rem; } }
.status-legend-wrap { position: relative; display: inline-flex; align-items: center; cursor: pointer; flex-shrink: 0; }
.status-legend-wrap svg { display: block; opacity: .75; transition: opacity .2s; }
.status-legend-wrap:hover svg { opacity: 1; }
.status-legend-popup { display: none; position: absolute; top: calc(100% + 10px); left: 50%; transform: translateX(-50%); background: var(--white); border: 1.5px solid var(--pink-100); border-radius: 14px; box-shadow: 0 12px 32px rgba(232,23,93,.13), 0 2px 8px rgba(0,0,0,.07); padding: .75rem .9rem; min-width: 280px; z-index: 600; pointer-events: none; }
.status-legend-wrap:hover .status-legend-popup, .status-legend-popup.open { display: block; }
.slp-title { font-size: .67rem; font-weight: 800; color: var(--bright-pink); text-transform: uppercase; letter-spacing: .08em; margin-bottom: .55rem; padding-bottom: .4rem; border-bottom: 1.5px solid var(--petal); }
.slp-row { display: flex; align-items: flex-start; gap: .6rem; padding: .35rem 0; border-bottom: 1px solid var(--pink-100); }
.slp-row:last-child { border-bottom: none; }
.slp-row .badge { flex-shrink: 0; width: 88px; justify-content: center; text-align: center; white-space: nowrap; }
.slp-desc { font-size: .75rem; color: var(--ink-muted); font-weight: 500; line-height: 1.45; padding-top: .15rem; }
.inside-indicator { display: inline-flex; align-items: center; gap: .35rem; font-size: .75rem; font-weight: 700; }
.inside-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; display: inline-block; }
.dot-inside { background: #1f9d69; box-shadow: 0 0 0 3px rgba(31,157,105,.2); animation: pulseGreen 2s infinite; }
.dot-outside { background: #c8c8d4; }
.slp-row .inside-indicator { flex-shrink: 0; width: 88px; justify-content: center; text-align: center; white-space: nowrap; }
@media (max-width: 680px) { .status-legend-popup { left: auto; right: 0; transform: none; } }
.addf-item { display: block; width: 100%; padding: .6rem 1rem; background: none; border: none; text-align: left; font-size: .82rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); border-bottom: 1px solid var(--pink-100); }
.addf-item:last-child { border-bottom: none; }
.addf-item:hover { background: var(--blush); color: var(--hot-pink); }
.addf-item.active { background: var(--petal); color: var(--hot-pink); }
.modal-title img {
    width: 25px;
    height: 25px;
    filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
}
.vacation-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: .6rem .85rem;
    border-radius: 12px;
    background: #fffafd;
    border: 1.5px solid var(--pink-100);
    transition: border-color .2s, background .2s;
}
.vacation-toggle-row:has(#edit-is-on-vacation:checked) {
    background: #fff0f6;
    border-color: var(--bright-pink);
}
.vacation-toggle-row:has(#edit-change-room-toggle:checked) {
    background: #fff0f6;
    border-color: var(--bright-pink);
}
.vacation-toggle-label {
    display: flex;
    flex-direction: column;
    gap: .15rem;
}
.vacation-toggle-title {
    font-size: .875rem;
    font-weight: 700;
    color: var(--ink);
}
.vacation-toggle-sub {
    font-size: .72rem;
    color: var(--ink-muted);
    font-weight: 500;
}
.vacation-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
}
.vacation-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.vacation-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: #e0d0d8;
    border-radius: 999px;
    transition: background .22s;
}
.vacation-slider::before {
    content: '';
    position: absolute;
    height: 18px;
    width: 18px;
    left: 3px;
    top: 3px;
    background: #fff;
    border-radius: 50%;
    transition: transform .22s;
    box-shadow: 0 2px 6px rgba(0,0,0,.18);
}
.vacation-switch input:checked + .vacation-slider {
    background: var(--gradient-pink);
}
.vacation-switch input:checked + .vacation-slider::before {
    transform: translateX(20px);
}
.tenant-photo-wrap {
    position: relative;
    width: 72px;
    height: 72px;
    flex-shrink: 0;
}
.tenant-photo-img {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid var(--pink-100);
    box-shadow: 0 4px 14px rgba(232,23,93,.18);
    display: block;
}
.tenant-photo-placeholder {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: 2px dashed var(--pink-200);
    background: #fffafd;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    gap: .2rem;
}
.tenant-photo-placeholder:hover {
    border-color: var(--bright-pink);
    background: #fff0f6;
}
.tenant-photo-placeholder span {
    font-size: .58rem;
    font-weight: 700;
    color: var(--bright-pink);
    text-transform: uppercase;
    letter-spacing: .05em;
    text-align: center;
    line-height: 1.3;
}
.tenant-photo-edit-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--gradient-pink);
    border: 2px solid var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(232,23,93,.3);
    transition: transform .15s;
}
.tenant-photo-edit-btn:hover {
    transform: scale(1.12);
}
.tenant-photo-edit-btn svg {
    width: 10px;
    height: 10px;
    stroke: #fff;
    fill: none;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.tenant-photo-img {
    cursor: pointer;
    transition: transform .18s, box-shadow .18s;
}
.tenant-photo-img:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 22px rgba(232,23,93,.3);
}
.photo-lightbox {
    position: fixed;
    inset: 0;
    z-index: 9000;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(20,0,10,.82);
    backdrop-filter: blur(6px);
    padding: 2rem;
}
.photo-lightbox.open {
    display: flex;
}
.photo-lightbox-img {
    max-width: min(80vw, 480px);
    max-height: 80vh;
    border-radius: 20px;
    box-shadow: 0 24px 64px rgba(0,0,0,.4);
    animation: photoLightboxIn .25s cubic-bezier(.22,1,.36,1);
}
@keyframes photoLightboxIn {
    from { opacity: 0; transform: scale(.92); }
    to   { opacity: 1; transform: scale(1); }
}
.photo-lightbox-close {
    position: fixed;
    top: 1.6rem;
    right: 1.8rem;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.12);
    color: var(--white);
    font-size: 1.05rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
}
.photo-lightbox-close:hover {
    background: rgba(255,255,255,.25);
}
.moveout-warning-bar {
    display: none;
    align-items: flex-start;
    gap: .6rem;
    padding: .65rem .85rem;
    border-radius: 10px;
    background: #fff0f4;
    border: 1.5px solid #ffc2d1;
    margin-bottom: .5rem;
}
.moveout-warning-bar.visible {
    display: flex;
}
.moveout-warning-bar p {
    font-size: .8rem;
    font-weight: 600;
    color: #b0163a;
    margin: 0 0 .35rem;
    line-height: 1.45;
    transition: color .2s;
}
.moveout-warning-bar small {
    font-size: .72rem;
    color: #c0163a;
    font-weight: 500;
    transition: color .2s;
}
.extend-stay-row {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-wrap: wrap;
    margin-top: .5rem;
}
.extend-stay-btn {
    padding: .38rem .9rem;
    border-radius: 8px;
    border: 1.5px solid var(--pink-100);
    background: var(--white);
    color: var(--hot-pink);
    font-size: .78rem;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: background .2s, border-color .2s, color .2s;
    white-space: nowrap;
}
.extend-stay-btn:hover {
    background: var(--gradient-pink);
    color: var(--white);
    border-color: transparent;
}
.req-indicator {
    display: inline-flex;
    align-items: center;
    gap: .28rem;
    font-size: .67rem;
    font-weight: 800;
    color: var(--bright-pink);
    text-transform: uppercase;
    letter-spacing: .05em;
    vertical-align: middle;
    margin-left: .18rem;
    opacity: .7;
}
.field-req-star {
    color: var(--bright-pink);
    font-size: .75rem;
    font-weight: 900;
    line-height: 1;
    margin-left: .18rem;
    opacity: .75;
    vertical-align: middle;
    pointer-events: none;
    user-select: none;
}
.form-progress-bar {
    width: 100%;
    height: 3px;
    background: var(--pink-100);
    border-radius: 99px;
    overflow: hidden;
    margin-bottom: .55rem;
    flex-shrink: 0;
}
.form-progress-fill {
    height: 100%;
    border-radius: 99px;
    transition: width .35s cubic-bezier(.4,0,.2,1), background .35s;
}
.form-progress-wrap {
    padding: .5rem .9rem .1rem;
    display: flex;
    flex-direction: column;
    gap: .2rem;
    flex-shrink: 0;
    border-bottom: 1px solid var(--pink-100);
    background: #fffafd;
}
.form-progress-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .68rem;
    font-weight: 700;
    color: var(--ink-muted);
}
.form-progress-label span.ready {
    color: #1f9d69;
    font-weight: 800;
}
.form-progress-label span.partial {
    color: var(--bright-pink);
}
.modal-field label .field-req-star {
    color: var(--bright-pink);
    font-size: .75rem;
    font-weight: 900;
    margin-left: .15rem;
    opacity: .8;
    vertical-align: middle;
}
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div>
            <h1>Manage Tenants</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openModal('add-modal')">+ Add Tenant</button>
            <button class="btn-outline" onclick="openAdminLogDrawer()">
                <img src="{{ asset('icons/archive.png') }}" class="icon-sm" alt="Log">
                Entry / Exit Log
            </button>
            <button class="btn-outline" onclick="openRoomsDrawer()">
                <img src="{{ asset('icons/bed.png') }}" class="icon-sm" alt="Rooms">
                Manage Rooms
            </button>
            <button class="btn-outline" onclick="openTenantArchive()">
                <img src="{{ asset('icons/archive.png') }}" class="icon-sm" alt="Archive">
                Archive / History
            </button>
            <div class="export-dropdown" id="export-dropdown-main">
                <button class="btn-outline" onclick="toggleExportDropdown('export-dropdown-main')">
                    <img src="{{ asset('icons/export.png') }}" class="icon-sm" alt="Export">
                    Export
                </button>
                <div class="export-menu" id="export-menu-main">
                    <button onclick="exportTenants(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportTenantsPDF(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/tenants.png') }}" class="icon-md" alt="tenants">
            </div>
            <div>
                <div class="stat-label">Total Tenants</div>
                <div class="stat-num" id="count-total">{{ $totalTenants }}</div>
                <div class="stat-sub">Currently Registered</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/bed.png') }}" class="icon-md" alt="units">
            </div>
            <div>
                <div class="stat-label">Active Tenants</div>
                <div class="stat-num" id="count-active">{{ $activeCount }}</div>
                <div class="stat-sub">Currently Active</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/pending.png') }}" class="icon-md" alt="reserved">
            </div>
            <div>
                <div class="stat-label">Reserved</div>
                <div class="stat-num">{{ $reservedCount }}</div>
                <div class="stat-sub">Room Held, Incoming</div>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1rem;" class="fade-up d3">

        <div style="background:var(--white);border-radius:18px;border:1px solid var(--pink-100);padding:.85rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.8rem;box-shadow:0 4px 12px rgba(0,0,0,.04);">
            <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Search tenants..." oninput="applyFilters()">
                </div>
                <select class="sort-select" id="sort-select" onchange="applyFilters()">
                    <option value="newest">Sort by: Newest</option>
                    <option value="oldest">Sort by: Oldest</option>
                    <option value="floor">Sort by: Floor</option>
                    <option value="name">Sort by: Name</option>
                    <option value="room">Sort by: Room</option>
                </select>
                <select class="sort-select" id="floor-filter" onchange="applyFilters()">
                    <option value="">All Floors</option>
                </select>
                <select class="sort-select" id="status-filter" onchange="setStatusFilter(this.value)">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="vacation">On Vacation</option>
                </select>
                <div class="status-legend-wrap" id="status-legend-trigger">
                    <img src="{{ asset('icons/info.png') }}" style="width:15px;height:15px;object-fit:contain;opacity:.75;transition:opacity .2s;filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);">
                    <div class="status-legend-popup" id="status-legend-popup">
                    <div class="slp-title">Status Guide</div>
                    <div class="slp-row"><span class="badge badge-active">Active</span><span class="slp-desc">Currently occupying a room and account is fully active.</span></div>
                    <div class="slp-row"><span class="badge badge-pending">Pending</span><span class="slp-desc">Tenant has moved in and has login credentials, but hasn't logged into the app yet.</span></div>
                    <div class="slp-row"><span class="badge badge-reserved">Reserved</span><span class="slp-desc">Room is held for this tenant. Move-in is upcoming.</span></div>
                    <div class="slp-row"><span class="badge badge-moveout">Move Out</span><span class="slp-desc">Tenant has vacated. Record is archived in History.</span></div>
                    <div class="slp-row"><span class="badge badge-inactive">Inactive</span><span class="slp-desc">Account is disabled. Tenant cannot log in to the portal.</span></div>
                    <div class="slp-title" style="margin-top:.6rem;">Location Guide</div>
                    <div class="slp-row"><span class="inside-indicator"><span class="inside-dot dot-inside"></span><span style="color:#1f9d69;">Inside</span></span><span class="slp-desc">Tenant has timed in and is currently inside the dormitory.</span></div>
                    <div class="slp-row"><span class="inside-indicator"><span class="inside-dot dot-outside"></span><span style="color:var(--ink-muted);">Outside</span></span><span class="slp-desc">Tenant has timed out, or hasn't timed in yet today.</span></div>
                </div>
                </div>
            </div>
            <div id="table-date" style="display:inline-flex;align-items:center;gap:.4rem;padding:.3rem .85rem;border-radius:999px;background:var(--petal);border:1.5px solid var(--pink-100);font-size:.75rem;font-weight:700;color:var(--hot-pink);flex-shrink:0;white-space:nowrap;"></div>
        </div>

        <div class="tenant-section" id="section-active">
            <div class="tenant-section-bar tenant-section-bar-pink"></div>
            <div class="tenant-section-header" onclick="toggleSection('active')">
                <div class="tenant-section-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2.2" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span class="tenant-section-label">Active Tenants</span>
                    <span class="tenant-section-pill tenant-section-pill-pink" id="pill-active">0</span>
                </div>
                <svg class="tenant-section-chevron open" id="chevron-active" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="tenant-section-body" id="body-active">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Account ID</th>
                                <th>Tenant Name</th>
                                <th>Floor &amp; Room No.</th>
                                <th>Move-In Date</th>
                                <th>Move-Out Date</th>
                                <th>Contact No.</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-active"></tbody>
                    </table>
                </div>
                <div class="table-footer" style="border-top:1px solid var(--pink-100);">
                    <div class="table-showing" id="showing-active"></div>
                    <div class="pagination" id="pagination-active"></div>
                </div>
            </div>
        </div>

        <div class="tenant-section" id="section-reserved">
            <div class="tenant-section-bar tenant-section-bar-pink"></div>
            <div class="tenant-section-header" onclick="toggleSection('reserved')">
                <div class="tenant-section-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2.2" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span class="tenant-section-label">Reserved Tenants</span>
                    <span class="tenant-section-pill tenant-section-pill-pink" id="pill-reserved">0</span>
                    <span class="tenant-section-pill" id="pill-reserved-overdue" style="display:none;background:#fff0f0;color:#e04867;border:1px solid var(--pink-200);">0 overdue</span>
                </div>
                <svg class="tenant-section-chevron open" id="chevron-reserved" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="tenant-section-body" id="body-reserved">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Account ID</th>
                                <th>Tenant Name</th>
                                <th>Floor &amp; Room No.</th>
                                <th>Est. Move-In</th>
                                <th>Move-Out Date</th>
                                <th>Contact No.</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-reserved"></tbody>
                    </table>
                </div>
                <div class="table-footer" style="border-top:1px solid var(--pink-100);">
                    <div class="table-showing" id="showing-reserved"></div>
                    <div class="pagination" id="pagination-reserved"></div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('modals')
<div class="modal-overlay" id="pdf-preview-modal" style="z-index:9000;">
    <div class="modal" style="max-width:520px;width:95%;padding:1.25rem;">
        <div class="modal-header" style="margin-bottom:.85rem;">
            <div class="modal-title">Document Preview</div>
            <div style="display:flex;align-items:center;gap:.6rem;">
                <button class="btn-submit" style="padding:.45rem 1rem;font-size:.82rem;" onclick="downloadPdfFromPreview()">Download</button>
                <button class="modal-close" onclick="closePdfPreview()">&#x2715;</button>
            </div>
        </div>
        <div style="width:100%;border-radius:10px;overflow:hidden;border:1.5px solid var(--pink-100);background:var(--soft-bg);">
            <iframe id="pdf-preview-iframe" src="" style="width:100%;height:520px;border:none;display:block;"></iframe>
        </div>
        <div style="margin-top:.85rem;font-size:.76rem;color:var(--ink-muted);text-align:center;">
            Use the <strong>Download</strong> button above to save the PDF, or use your browser's built-in print option inside the preview.
        </div>
    </div>
</div>
<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="tenant-archive-backdrop" id="rooms-backdrop" onclick="closeRoomsDrawer()"></div>

<div class="tenant-archive-drawer" id="rooms-drawer">
    <div class="tad-header">
        <div>
            <div class="tad-title">Manage Rooms</div>
            <div class="tad-sub">Room list, capacity, and occupancy</div>
        </div>
        <button class="tad-close" onclick="closeRoomsDrawer()">&#x2715;</button>
    </div>
    <div style="padding:.75rem 1.8rem .5rem;flex-shrink:0;display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap;">
        <div class="tad-search-inner" style="flex:1;max-width:260px;">
            <img src="{{ asset('icons/search.png') }}" class="tad-search-icon" alt="">
            <input type="text" id="rooms-search" placeholder="Search room..." oninput="renderRooms()">
        </div>
        <button class="btn-primary" style="font-size:.8rem;padding:.5rem 1rem;" onclick="openAddRoomModal()">+ Add Room</button>
    </div>
    <div style="padding:.4rem 1.8rem .2rem;flex-shrink:0;" id="rooms-stats-bar">
        <button onclick="toggleRoomsStats()" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:.55rem .85rem;border-radius:12px;border:1px solid var(--pink-100);background:var(--white);cursor:pointer;font-family:inherit;transition:background .2s,border-color .2s;" id="rooms-stats-toggle" onmouseover="this.style.background='var(--blush)';this.style.borderColor='var(--bright-pink)';" onmouseout="this.style.background='var(--white)';this.style.borderColor='var(--pink-100)';">
            <div style="display:flex;align-items:center;gap:.6rem;">
                <span style="display:inline-block;width:3px;height:12px;background:var(--gradient-pink);border-radius:2px;flex-shrink:0;"></span>
                <span style="font-size:.75rem;font-weight:800;color:var(--ink);letter-spacing:-.01em;">Overview</span>
                <span id="rooms-stats-summary-pill" style="font-size:.68rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:var(--petal);color:var(--hot-pink);border:1px solid var(--pink-100);"></span>
            </div>
            <svg id="rooms-stats-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2.5" style="transition:transform .25s;flex-shrink:0;"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div id="rooms-stats-panel" style="display:none;padding:.75rem 0 .35rem;display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;">
            <div style="background:var(--white);border:1px solid var(--pink-100);border-radius:12px;padding:.65rem .8rem;text-align:center;">
                <div style="font-size:.67rem;font-weight:700;color:var(--hot-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.3rem;">Total Rooms</div>
                <div id="rstat-total" style="font-size:1.4rem;font-weight:800;color:var(--ink);line-height:1;">0</div>
            </div>
            <div style="background:var(--white);border:1px solid var(--pink-100);border-radius:12px;padding:.65rem .8rem;text-align:center;">
                <div style="font-size:.67rem;font-weight:700;color:var(--hot-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.3rem;">Occupied Slots</div>
                <div id="rstat-occupied" style="font-size:1.4rem;font-weight:800;color:var(--ink);line-height:1;">0</div>
                <div id="rstat-pct" style="font-size:.68rem;font-weight:700;color:var(--ink-muted);margin-top:.2rem;">0%</div>
            </div>
            <div style="background:var(--white);border:1px solid var(--pink-100);border-radius:12px;padding:.65rem .8rem;text-align:center;">
                <div style="font-size:.67rem;font-weight:700;color:var(--hot-pink);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.3rem;">Available</div>
                <div id="rstat-vacant" style="font-size:1.4rem;font-weight:800;color:#1f9d69;line-height:1;">0</div>
                <div id="rstat-cap" style="font-size:.68rem;font-weight:700;color:var(--ink-muted);margin-top:.2rem;">of 0 slots</div>
            </div>
        </div>
    </div>
    <div style="padding:.5rem 1.8rem .35rem;flex-shrink:0;display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;" id="rooms-floor-filters">
        <button class="page-btn active" id="rfloor-all" onclick="setRoomFloor('')">All</button>
        <div id="rfloor-btn-group" style="display:contents;"></div>
        <div id="rfloor-more-wrap" style="position:relative;display:none;">
            <button class="page-btn" id="rfloor-more-btn" onclick="toggleFloorMoreDropdown()" style="display:flex;align-items:center;gap:.3rem;">
                More
                <svg id="rfloor-more-chevron" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--hot-pink)" stroke-width="2.8" style="flex-shrink:0;transition:transform .2s;"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="rfloor-more-menu" style="display:none;position:absolute;top:calc(100% + 6px);left:0;background:var(--white);border:1.5px solid var(--pink-100);border-radius:12px;box-shadow:0 8px 24px rgba(232,23,93,.13);min-width:110px;overflow:hidden;z-index:600;"></div>
        </div>
    </div>
    <div class="tad-list" id="rooms-list"></div>
    <div class="tad-footer">
        <div class="tad-count-label" id="rooms-count-label">0 rooms</div>
        <div style="display:flex;align-items:center;gap:.5rem;">
            <div style="font-size:.73rem;color:var(--ink-muted);" id="rooms-summary"></div>
            <div class="export-dropdown" id="export-dropdown-rooms">
                <button class="tad-export-btn" onclick="toggleExportDropdown('export-dropdown-rooms')">
                    <img src="{{ asset('icons/export.png') }}" alt="">
                    Export
                </button>
                <div class="export-menu" id="export-menu-rooms">
                    <button onclick="exportRoomsCSV(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportRoomsPDF(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="add-room-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/bed.png') }}" class="icon-sm" alt="">
                Add Room
            </div>
            <button class="modal-close" onclick="closeModal('add-room-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="form-progress-wrap" id="ar-progress-wrap">
                <div class="form-progress-label">
                    <span id="ar-progress-text">Fill in required fields</span>
                    <span id="ar-progress-count" class="partial"></span>
                </div>
                <div class="form-progress-bar">
                    <div class="form-progress-fill" id="ar-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                </div>
            </div>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Room Number <span class="field-req-star">*</span></label>
                    <input type="text" id="ar-number" placeholder="e.g. 308" inputmode="numeric" maxlength="5" class="room-number-input">
                </div>
                <div class="modal-field">
                    <label>Floor</label>
                    <select id="ar-floor" style="pointer-events:none;opacity:.65;cursor:default;background:#f5f0f3;">
                        <option value="">Auto-detected</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Capacity (pax) <span class="field-req-star">*</span></label>
                    <input type="number" id="ar-capacity" min="1" max="10" placeholder="e.g. 3">
                </div>
                <div class="modal-field">
                    <label>Room Type</label>
                    <select id="ar-stay-type" style="pointer-events:none;opacity:.65;cursor:default;background:#f5f0f3;">
                        <option value="Solo Room">Solo Room</option>
                        <option value="Shared Room">Shared Room</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('add-room-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitAddRoom()">Add Room</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-room-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/bed.png') }}" class="icon-sm" alt="">
                Edit Room
            </div>
            <button class="modal-close" onclick="closeModal('edit-room-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="er-id">
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Room Number</label>
                    <input type="text" id="er-number" inputmode="numeric" maxlength="5" class="room-number-input">
                </div>
                <div class="modal-field">
                    <label>Floor</label>
                    <select id="er-floor">
                        <option value="2">Floor 2</option>
                        <option value="3">Floor 3</option>
                        <option value="4">Floor 4</option>
                        <option value="5">Floor 5</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Capacity (pax)</label>
                    <input type="number" id="er-capacity" min="1" max="10">
                </div>
                <div class="modal-field">
                    <label>Room Type</label>
                    <select id="er-stay-type" style="pointer-events:none;opacity:.65;cursor:default;background:#f5f0f3;">
                        <option value="Solo Room">Solo Room</option>
                        <option value="Shared Room">Shared Room</option>
                    </select>
                </div>
                <div class="modal-field full">
                    <label>Status</label>
                    <select id="er-active">
                        <option value="1">Active</option>
                        <option value="0">Closed / Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('edit-room-modal')">Cancel</button>
            <button class="btn-submit" onclick="submitEditRoom()">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="view-room-modal">
    <div class="modal" style="max-width:480px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/bed.png') }}" class="icon-sm" alt="">
                Room Details
            </div>
            <button class="modal-close" onclick="closeModal('view-room-modal')">&#x2715;</button>
        </div>
        <div class="modal-body" id="view-room-content"></div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('view-room-modal')">Close</button>
            <button class="btn-submit" id="view-room-edit-btn" onclick="">Edit Room</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-room-modal">
    <div class="modal" style="max-width:380px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/delete.png') }}" class="icon-sm" alt="">
                Delete Room
            </div>
            <button class="modal-close" onclick="closeModal('delete-room-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">This room will be permanently removed. This cannot be undone.</div>
            <p style="font-size:.9rem;color:var(--ink-muted);margin:0;">Delete <strong id="dr-label" style="color:var(--ink);"></strong>?</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('delete-room-modal')">Cancel</button>
            <button class="btn-submit" style="background:#e04867;" onclick="submitDeleteRoom()">Delete</button>
        </div>
    </div>
</div>

<div class="tenant-archive-backdrop" id="admin-log-backdrop" onclick="closeAdminLogDrawer()"></div>

<div class="tenant-archive-drawer" id="admin-log-drawer">
    <div class="tad-header">
        <div>
            <div class="tad-title">Entry / Exit Log</div>
            <div class="tad-sub">Real-time record of tenant time-ins and time-outs</div>
        </div>
        <button class="tad-close" onclick="closeAdminLogDrawer()">&#x2715;</button>
    </div>
    <div class="tad-search-bar">
        <div class="tad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="tad-search-icon" alt="">
            <input type="text" id="admin-log-search" placeholder="Search by name, room..." oninput="renderAdminLogDrawer()">
        </div>
    </div>
    <div style="padding: 0 1.8rem .75rem; flex-shrink: 0; display: flex; align-items: center; justify-content: space-between; gap: .5rem; flex-wrap: wrap; border-bottom: 1px solid var(--pink-100); margin-bottom: .2rem;">
        <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
            <button class="page-btn active" id="admin-log-filter-all"     onclick="setAdminLogFilter('')">All</button>
            <button class="page-btn"        id="admin-log-filter-timein"  onclick="setAdminLogFilter('time_in')">Time In</button>
            <button class="page-btn"        id="admin-log-filter-timeout" onclick="setAdminLogFilter('time_out')">Time Out</button>
        </div>
        <div style="position:relative; display:inline-flex; align-items:center;">
            <button id="admin-date-dropdown-btn" onclick="toggleAdminDateDropdown()" style="display:inline-flex;align-items:center;gap:.45rem;padding:.38rem .85rem;border-radius:99px;border:1.5px solid var(--pink-100);background:var(--white);color:var(--hot-pink);font-size:.78rem;font-weight:700;cursor:pointer;font-family:inherit;transition:border-color .2s,background .2s;white-space:nowrap;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span id="admin-date-dropdown-label">All Dates</span>
                <svg id="admin-date-dropdown-chevron" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" style="flex-shrink:0;transition:transform .2s;"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="admin-date-dropdown-menu" style="display:none;position:absolute;top:calc(100% + 6px);right:0;left:auto;background:var(--white);border:1.5px solid var(--pink-100);border-radius:12px;box-shadow:0 8px 24px rgba(232,23,93,.13);min-width:150px;overflow:hidden;z-index:600;">
                <button onclick="setAdminDateFilter('all')"       class="addf-item active" data-val="all">All Dates</button>
                <button onclick="setAdminDateFilter('today')"     class="addf-item"        data-val="today">Today</button>
                <button onclick="setAdminDateFilter('yesterday')" class="addf-item"        data-val="yesterday">Yesterday</button>
                <button onclick="setAdminDateFilter('week')"      class="addf-item"        data-val="week">This Week</button>
            </div>
        </div>
    </div>
    <div class="tad-list" id="admin-log-list"></div>
    <div class="tad-footer">
        <div class="tad-count-label" id="admin-log-count-label">0 records</div>
        <div class="export-dropdown" id="export-dropdown-admin-log">
            <button class="tad-export-btn" onclick="toggleExportDropdown('export-dropdown-admin-log')">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
            <div class="export-menu" id="export-menu-admin-log">
                <button onclick="exportAdminLog('csv'); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportAdminLog('pdf'); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

<div class="tenant-archive-backdrop" id="tad-backdrop" onclick="closeTenantArchive()"></div>

<div class="tenant-archive-drawer" id="tad-drawer">
    <div class="tad-header">
        <div>
            <div class="tad-title">Archive / History</div>
            <div class="tad-sub">Records of deleted, inactive, and moved-out tenants</div>
        </div>
        <button class="tad-close" onclick="closeTenantArchive()">&#x2715;</button>
    </div>
    <div class="tad-tabs">
        <button class="tad-tab active" id="ttab-deleted" onclick="switchTenantArchiveTab('deleted')">
            Deleted <span class="tad-tab-count" id="tcount-deleted">0</span>
        </button>
        <button class="tad-tab" id="ttab-inactive" onclick="switchTenantArchiveTab('inactive')">
            Inactive <span class="tad-tab-count" id="tcount-inactive">0</span>
        </button>
        <button class="tad-tab" id="ttab-moveout" onclick="switchTenantArchiveTab('move_out')">
            Move Out <span class="tad-tab-count" id="tcount-moveout">0</span>
        </button>
    </div>
    <div class="tad-search-bar">
        <div class="tad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="tad-search-icon" alt="">
            <input type="text" id="tad-search" placeholder="Search archived tenants..." oninput="renderTenantArchive()">
        </div>
    </div>
    <div class="tad-list" id="tad-list"></div>
    <div class="tad-footer">
        <div class="tad-count-label" id="tad-count-label">0 records</div>
        <div class="export-dropdown" id="export-dropdown-archive">
            <button class="tad-export-btn" onclick="toggleExportDropdown('export-dropdown-archive')">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
            <div class="export-menu" id="export-menu-archive">
                <button onclick="exportTenantArchive('csv'); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportTenantArchive('pdf'); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

@if(session('new_account_id'))
<div class="modal-overlay open" id="credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/nav-tenants.png') }}" class="icon-sm" alt="">
                Tenant Account Created
            </div>
            <button class="modal-close" onclick="closeModal('credentials-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
                The account for <strong style="color:var(--ink);">{{ session('new_tenant_name') }}</strong>
                has been created. Please provide the following credentials to the tenant:
            </p>
            <div class="credentials-box">
                <h4>Login Credentials</h4>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Account ID</div>
                        <div class="credential-value" id="cred-account-id">{{ session('new_account_id') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('cred-account-id', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Temporary Password</div>
                        <div class="credential-value" id="cred-temp-password">{{ session('new_temp_password') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('cred-temp-password', this)">Copy</button>
                </div>
            </div>
            <div class="credentials-warning">
                This temporary password will <strong>not be shown again</strong>.
                Please write it down or inform the tenant immediately.
                The tenant will be prompted to change their password on first login.
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="printCredentialSlip('new')">Print / Save as PDF</button>
            <button class="btn-submit" onclick="closeModal('credentials-modal')">Got it, I've noted the credentials</button>
        </div>
    </div>
</div>
@endif

@if(session('reset_account_id'))
<div class="modal-overlay open" id="reset-credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/reset.png') }}" class="icon-sm" alt="">
                Password Reset Successfully
            </div>
            <button class="modal-close" onclick="closeModal('reset-credentials-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
                The password for <strong style="color:var(--ink);">{{ session('reset_tenant_name') }}</strong>
                has been reset. Please provide the new temporary credentials to the tenant:
            </p>
            <div class="credentials-box">
                <h4>New Temporary Credentials</h4>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Account ID</div>
                        <div class="credential-value" id="reset-account-id">{{ session('reset_account_id') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('reset-account-id', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">New Temporary Password</div>
                        <div class="credential-value" id="reset-temp-password">{{ session('reset_temp_password') }}</div>
                    </div>
                    <button class="copy-btn" onclick="copyText('reset-temp-password', this)">Copy</button>
                </div>
            </div>
            <div class="credentials-warning">
                This temporary password will <strong>not be shown again</strong>.
                Please inform the tenant of their new password immediately.
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="printCredentialSlip('reset')">Print / Save as PDF</button>
            <button class="btn-submit" onclick="closeModal('reset-credentials-modal')">Got it, I've noted the credentials</button>
        </div>
    </div>
</div>
@endif

<div class="modal-overlay" id="add-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/tenants.png') }}" class="icon-sm" alt="">
                Add New Tenant
            </div>
            <button class="modal-close" onclick="closeModal('add-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('tenants.store') }}" data-loading-message="Adding tenant..." style="display:contents;" onsubmit="return validateAddTenantForm(event)">
            @csrf
            <input type="hidden" name="add_mode" id="add-mode-input" value="moved_in">
            <div style="flex-shrink:0;background:#fffafd;border-top:1.5px solid var(--pink-100);border-bottom:1.5px solid var(--pink-100);">
    <div style="display:flex;">
        <div id="add-step-btn-1" onclick="goAddStep(1)" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.4rem;padding:.45rem .5rem .45rem;cursor:pointer;border-bottom:3px solid var(--bright-pink);transition:border-color .2s,background .2s;">
            <div style="display:flex;align-items:center;justify-content:center;width:18px;height:18px;border-radius:50%;background:var(--gradient-pink);flex-shrink:0;" id="add-step-circle-1">
                <span style="font-size:.6rem;font-weight:800;color:#fff;">1</span>
            </div>
            <span style="font-size:.72rem;font-weight:700;color:var(--bright-pink);white-space:nowrap;" id="add-step-label-1">Personal Info</span>
        </div>
        <div id="add-step-btn-2" onclick="goAddStep(2)" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.4rem;padding:.45rem .5rem .45rem;cursor:pointer;border-bottom:3px solid var(--pink-100);transition:border-color .2s,background .2s;">
            <div style="display:flex;align-items:center;justify-content:center;width:18px;height:18px;border-radius:50%;background:var(--pink-100);flex-shrink:0;" id="add-step-circle-2">
                <span style="font-size:.6rem;font-weight:800;color:var(--hot-pink);">2</span>
            </div>
            <span style="font-size:.72rem;font-weight:700;color:var(--ink-muted);white-space:nowrap;" id="add-step-label-2">Room &amp; Stay</span>
        </div>
    </div>
</div>
            <div class="modal-body">
                <div class="form-progress-wrap" id="add-progress-wrap">
                    <div class="form-progress-label">
                        <span id="add-progress-text">Fill in required fields</span>
                        <span id="add-progress-count" class="partial"></span>
                    </div>
                    <div class="form-progress-bar">
                        <div class="form-progress-fill" id="add-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                    </div>
                </div>
                <div id="add-step-panel-1">
                    <div class="modal-info-banner" style="margin-bottom:.75rem;">
                        <span>Account ID and temporary password will be <strong>auto-generated</strong> and shown to you after saving.</span>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.9rem;" id="add-mode-selector">
                        <button type="button" id="add-mode-btn-movedin" onclick="setAddMode('moved_in')" style="display:flex;flex-direction:column;align-items:flex-start;gap:.3rem;padding:.7rem .9rem;border-radius:12px;border:2px solid var(--bright-pink);background:linear-gradient(135deg,#fff0f6,#ffe4ef);cursor:pointer;transition:all .2s;font-family:inherit;text-align:left;">
                            <div style="display:flex;align-items:center;gap:.45rem;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <span style="font-size:.78rem;font-weight:800;color:#E8175D;letter-spacing:.01em;">Moved In</span>
                            </div>
                            <span style="font-size:.7rem;color:#a0405e;font-weight:500;line-height:1.35;">Tenant is already occupying a room</span>
                        </button>
                        <button type="button" id="add-mode-btn-reservation" onclick="setAddMode('reservation')" style="display:flex;flex-direction:column;align-items:flex-start;gap:.3rem;padding:.7rem .9rem;border-radius:12px;border:2px solid var(--pink-100);background:var(--white);cursor:pointer;transition:all .2s;font-family:inherit;text-align:left;">
                            <div style="display:flex;align-items:center;gap:.45rem;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9a6200" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <span style="font-size:.78rem;font-weight:800;color:#9a6200;letter-spacing:.01em;">Reservation</span>
                            </div>
                            <span style="font-size:.7rem;color:#7a5200;font-weight:500;line-height:1.35;">Room held, tenant moves in later</span>
                        </button>
                    </div>
                    <div class="modal-section">
                        <div class="modal-section-title">Personal Information</div>
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label>First Name <span class="field-req-star">*</span></label>
                                <input type="text" name="first_name" placeholder="e.g. Maria" required maxlength="100" value="{{ old('first_name') }}" autocomplete="given-name">
                            </div>
                            <div class="modal-field">
                                <label>Last Name <span class="field-req-star">*</span></label>
                                <input type="text" name="last_name" placeholder="e.g. Ramos" required maxlength="100" value="{{ old('last_name') }}" autocomplete="family-name">
                            </div>
                            <div class="modal-field full">
                                <label>Email Address <span class="field-req-star">*</span></label>
                                <input type="email" name="email" id="add-email" placeholder="e.g. maria@email.com" required value="{{ old('email') }}" autocomplete="email">
                                <span class="field-error" id="add-email-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            </div>
                            <div class="modal-field full">
                                <label>Contact No. <span class="field-req-star">*</span></label>
                                <input type="text" name="contact_number" id="add-contact" placeholder="e.g. 0912-345-6789 or +63 912-345-6789" maxlength="18" required value="{{ old('contact_number') }}">
                                <span class="field-error" id="add-contact-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            </div>
                            <div class="modal-field full">
                                <label>Parent / Guardian Contact No.</label>
                                <input type="text" name="guardian_number" id="add-guardian" placeholder="e.g. 0912-345-6789 or +63 912-345-6789" maxlength="18" value="{{ old('guardian_number') }}">
                                <span class="field-error" id="add-guardian-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            </div>
                            <div class="modal-field full">
                                <label>Referred By</label>
                                <select id="add-referred-source" onchange="handleReferredSource('add')" style="margin-bottom:.4rem;">
                                    <option value="">Not referred / N/A</option>
                                    <option value="current">Current Tenant</option>
                                    <option value="former">Former Tenant</option>
                                    <option value="other">Other</option>
                                </select>
                                <input type="hidden" name="referred_by" id="add-referred-by-value" value="{{ old('referred_by') }}">
                                <select id="add-referred-current-select" style="display:none;" onchange="syncReferredSelect('add-referred-current-select','add-referred-by-value')">
                                    <option value="">Select current tenant...</option>
                                </select>
                                <select id="add-referred-former-select" style="display:none;" onchange="syncReferredSelect('add-referred-former-select','add-referred-by-value')">
                                    <option value="">Select former tenant...</option>
                                </select>
                                <input type="text" id="add-referred-other-input" style="display:none;" placeholder="Enter name..." maxlength="150" oninput="document.getElementById('add-referred-by-value').value=this.value">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="add-step-panel-2" style="display:none;">
                    <div class="modal-section">
                        <div class="modal-section-title">Room &amp; Stay Details</div>
                        <div class="modal-grid">
                            <div class="modal-field full">
                                <label>Stay Type <span class="field-req-star">*</span></label>
                                <select name="stay_type" id="add-stay-type-select" onchange="onAddStayTypeChange()">
                                    <option value="" disabled selected>Select type</option>
                                    <option value="Solo Room"   {{ old('stay_type') === 'Solo Room'   ? 'selected' : '' }}>Solo Room</option>
                                    <option value="Shared Room" {{ old('stay_type') === 'Shared Room' ? 'selected' : '' }}>Shared Room</option>
                                </select>
                            </div>
                            <div class="modal-field full" id="add-room-suggest-wrap" style="display:none;">
                                <div id="add-room-suggest"></div>
                            </div>
                            <div class="modal-field">
                                <label>Room No.</label>
                                <input type="text" id="add-room-number-input" name="room_number" placeholder="e.g. 304" inputmode="numeric" maxlength="10" class="room-number-input" value="{{ old('room_number') }}">
                            </div>
                            <div class="modal-field">
                                <label>Floor</label>
                                <select name="floor" id="add-floor-select" style="pointer-events:none;opacity:.65;cursor:default;background:#f5f0f3;">
                                    <option value="">Select floor</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>Floor {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="modal-field full" id="add-room-hint-wrap" style="display:none;">
                                <div id="add-room-hint"></div>
                            </div>
                            <div class="modal-field full" id="add-est-movein-wrap" style="display:none;">
                                <label>Estimated Move-In Date</label>
                                <input type="date" name="estimated_move_in_date" id="add-estimated-move-in" value="{{ old('estimated_move_in_date') }}">
                                <span class="field-error" id="add-estimated-move-in-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            </div>
                            <div class="modal-field full" id="add-movein-wrap">
                                <label>Move-In Date <span class="field-req-star">*</span></label>
                                <input type="date" name="move_in_date" id="add-move-in-date" value="{{ old('move_in_date') }}">
                            </div>
                            <div class="modal-field full" id="add-moveout-wrap">
                                <label>Move-Out Date</label>
                                <input type="date" name="move_out_date" id="add-move-out-date" value="{{ old('move_out_date') }}">
                                <span id="add-moveout-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            </div>
                            <div class="modal-field full" id="add-stay-duration-wrap" style="display:none;">
                                <div id="add-stay-duration-display"></div>
                            </div>
                            <div class="modal-field full" id="add-reservation-notes-wrap" style="display:none;">
                                <label>Reservation Notes</label>
                                <input type="text" name="reservation_notes" id="add-reservation-notes" placeholder="e.g. Confirmed via call, move-in after graduation" maxlength="500" value="{{ old('reservation_notes') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content:space-between;">
                <button type="button" class="btn-outline" id="add-btn-back" style="display:none;" onclick="goAddStep(1)">&#8592; Back</button>
                <div style="margin-left:auto;display:flex;align-items:center;gap:.55rem;">
                    <button type="button" class="btn-submit" id="add-btn-next" onclick="goAddStep(2)">Next &#8594;</button>
                    <button type="submit" class="btn-submit" id="add-btn-submit" style="display:none;">Add Tenant</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal" style="max-width:580px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/person.png') }}" class="icon-sm" alt="">
                Tenant Details
            </div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div class="modal-body" id="view-content"></div>
        <div class="modal-footer" style="justify-content:space-between;">
            <button class="btn-submit" onclick="switchToEdit()">Edit</button>
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/edit.png') }}" class="icon-sm" alt="Edit">
                Edit Tenant
            </div>
            <button class="modal-close" onclick="closeModal('edit-modal')">&#x2715;</button>
        </div>
        <form method="POST" id="edit-form" action="" data-loading-message="Saving changes..." style="display:contents;" onsubmit="return interceptMoveOut(event)">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-progress-wrap" id="edit-progress-wrap">
                    <div class="form-progress-label">
                        <span id="edit-progress-text">Fill in required fields</span>
                        <span id="edit-progress-count" class="partial"></span>
                    </div>
                    <div class="form-progress-bar">
                        <div class="form-progress-fill" id="edit-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                    </div>
                </div>
                <div class="modal-section">
                    <div class="modal-section-title">Personal Information</div>
                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>First Name <span class="field-req-star">*</span></label>
                            <input type="text" name="first_name" id="edit-first-name" placeholder="First name" required>
                        </div>
                        <div class="modal-field">
                            <label>Last Name <span class="field-req-star">*</span></label>
                            <input type="text" name="last_name" id="edit-last-name" placeholder="Last name" required>
                        </div>
                        <div class="modal-field full">
                            <label>Email Address <span class="field-req-star">*</span></label>
                            <input type="email" name="email" id="edit-email" placeholder="Email address" required>
                            <span class="field-error" id="edit-email-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                        </div>
                        <div class="modal-field full">
                            <label>Contact No. <span class="field-req-star">*</span></label>
                            <input type="text" name="contact_number" id="edit-contact" placeholder="e.g. 0912-345-6789 or +63 912-345-6789" maxlength="18" required>
                            <span class="field-error" id="edit-contact-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                        </div>
                        <div class="modal-field full">
                            <label>Parent / Guardian Contact No.</label>
                            <input type="text" name="guardian_number" id="edit-guardian" placeholder="e.g. 0912-345-6789 or +63 912-345-6789" maxlength="18">
                            <span class="field-error" id="edit-guardian-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                        </div>
                        <div class="modal-field full">
                            <label>Referred By</label>
                            <select id="edit-referred-source" onchange="handleReferredSource('edit')" style="margin-bottom:.4rem;">
                                <option value="">Not referred / N/A</option>
                                <option value="current">Current Tenant</option>
                                <option value="former">Former Tenant</option>
                                <option value="other">Other</option>
                            </select>
                            <input type="hidden" name="referred_by" id="edit-referred-by-value">
                            <select id="edit-referred-current-select" style="display:none;" onchange="syncReferredSelect('edit-referred-current-select','edit-referred-by-value')">
                                <option value="">Select current tenant...</option>
                            </select>
                            <select id="edit-referred-former-select" style="display:none;" onchange="syncReferredSelect('edit-referred-former-select','edit-referred-by-value')">
                                <option value="">Select former tenant...</option>
                            </select>
                            <input type="text" id="edit-referred-other-input" style="display:none;" placeholder="Enter name..." maxlength="150" oninput="document.getElementById('edit-referred-by-value').value=this.value">
                        </div>
                    </div>
                </div>
                <div class="modal-section">
                    <div class="modal-section-title">Room &amp; Stay Details</div>
                    <div class="modal-grid">
                        <div class="modal-field full">
                            <div class="vacation-toggle-row" id="edit-room-toggle-row">
                                <div class="vacation-toggle-label">
                                    <span class="vacation-toggle-title">Change Room</span>
                                    <span class="vacation-toggle-sub" id="edit-room-toggle-sub">No room currently assigned</span>
                                </div>
                                <label class="vacation-switch">
                                    <input type="checkbox" id="edit-change-room-toggle" onchange="toggleEditRoomChange(this)">
                                    <span class="vacation-slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="modal-field full">
                            <label>Stay Type</label>
                            <select name="stay_type" id="edit-stay-type" onchange="onEditStayTypeChange()">
                                <option value="" disabled>Select type</option>
                                <option value="Solo Room">Solo Room</option>
                                <option value="Shared Room">Shared Room</option>
                            </select>
                        </div>
                        <div class="modal-field full" id="edit-room-suggest-wrap" style="display:none;">
                            <div id="edit-room-suggest"></div>
                        </div>
                        <div class="modal-field">
                            <label>Room No.</label>
                            <input type="text" name="room_number" id="edit-room" placeholder="e.g. 304" inputmode="numeric" maxlength="10" class="room-number-input" @error('room_number') style="border-color:#e04867;box-shadow:0 0 0 3px rgba(224,72,103,.15);" @enderror>
                            <span class="field-error" id="edit-room-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            @error('room_number')
                                <span style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-field">
                            <label>Floor</label>
                            <select name="floor" id="edit-floor" style="pointer-events:none;opacity:.65;cursor:default;background:#f5f0f3;">
                                <option value="">Select floor</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">Floor {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-field full" id="edit-room-hint-wrap" style="display:none;">
                            <div id="edit-room-hint"></div>
                        </div>
                        <div class="modal-field" id="edit-movein-wrap">
                            <label>Move-In Date</label>
                            <input type="date" name="move_in_date" id="edit-date">
                        </div>
                        <div class="modal-field full">
                            <div class="moveout-warning-bar" id="edit-moveout-warning">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:.1rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <div>
                                    <p id="edit-moveout-warning-text">This tenant's move-out date has passed.</p>
                                    <small>The account will be automatically archived at midnight if no action is taken.</small>
                                    <div class="extend-stay-row">
                                        <button type="button" class="extend-stay-btn" onclick="extendStay(30)">+30 days</button>
                                        <button type="button" class="extend-stay-btn" onclick="extendStay(60)">+60 days</button>
                                        <button type="button" class="extend-stay-btn" onclick="extendStay(90)">+90 days</button>
                                        <button type="button" class="extend-stay-btn" onclick="extendStay(180)">+6 months</button>
                                        <button type="button" class="extend-stay-btn" onclick="extendStay(365)">+1 year</button>
                                    </div>
                                    <div style="font-size:.72rem;color:var(--ink-muted);margin-top:.3rem;font-weight:500;">To change rooms, update the Room No. field above.</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-field">
                            <label>Move-Out Date</label>
                            <input type="date" name="move_out_date" id="edit-moveout" @error('move_out_date') style="border-color:#e04867;box-shadow:0 0 0 3px rgba(224,72,103,.15);" @enderror>
                            <span class="field-error" id="edit-moveout-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            @error('move_out_date')
                                <span style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-field full" id="edit-stay-duration-wrap" style="display:none;">
                            <div id="edit-stay-duration-display"></div>
                        </div>
                        <div class="modal-field full" id="edit-est-movein-wrap" style="display:none;">
                            <label>Estimated Move-In Date</label>
                            <input type="date" name="estimated_move_in_date" id="edit-estimated-move-in" @error('estimated_move_in_date') style="border-color:#e04867;box-shadow:0 0 0 3px rgba(224,72,103,.15);" @enderror>
                            <span class="field-error" id="edit-estimated-move-in-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                            @error('estimated_move_in_date')
                                <span style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-field full" id="edit-reservation-notes-wrap" style="display:none;">
                            <label>Reservation Notes</label>
                            <input type="text" name="reservation_notes" id="edit-reservation-notes" placeholder="e.g. Confirmed via call, move-in after graduation" maxlength="500">
                        </div>
                    </div>
                </div>
                <div class="modal-section">
                    <div class="modal-section-title">Account Status</div>
                    <div class="modal-grid">
                        <div class="modal-field full">
                            <label>Status</label>
                            <div class="status-select-wrap">
                                <span class="status-dot" id="edit-status-dot"></span>
                                <select name="status" id="edit-status" onchange="updateStatusDot(this); toggleReservationFields('edit');">
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="reserved" id="edit-status-reserved-option">Reserved</option>
                                    <option value="move_out">Move Out</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-warn-banner" style="margin-top:.8rem;">
                        <span style="font-size:1rem;flex-shrink:0;"></span>
                        <span>Setting to <strong>Reserved</strong> holds the assigned room and counts toward occupancy. Setting to <strong>Inactive</strong> blocks mobile login. Setting to <strong>Move Out</strong> archives the record.</span>
                    </div>
                    <div id="edit-pending-reserved-warn" style="display:none;margin-top:.6rem;background:#fff9e6;border:1.5px solid #f0c040;border-radius:10px;padding:.55rem .8rem;font-size:.8rem;color:#7a5400;line-height:1.5;">
                        This tenant has no login credentials yet. Setting status to <strong>Pending</strong> has no effect until you use <strong>Tag as Moved In</strong> to generate their account.
                    </div>
                </div>
                <div class="modal-section" id="edit-vacation-section">
                    <div class="modal-section-title">Vacation</div>
                    <div class="vacation-toggle-row">
                        <div class="vacation-toggle-label">
                            <span class="vacation-toggle-title">On Vacation</span>
                            <span class="vacation-toggle-sub">Tenant is temporarily away from the dormitory</span>
                        </div>
                        <label class="vacation-switch">
                            <input type="checkbox" name="is_on_vacation" id="edit-is-on-vacation" value="1" onchange="toggleVacationNote()">
                            <span class="vacation-slider"></span>
                        </label>
                    </div>
                    <div class="modal-field full" id="edit-vacation-note-wrap" style="display:none;margin-top:.6rem;">
                        <label>Vacation Note <span style="font-weight:500;color:var(--ink-muted);text-transform:none;letter-spacing:0;">(optional)</span></label>
                        <input type="text" name="vacation_note" id="edit-vacation-note" placeholder="e.g. Home for semestral break, back Nov 5" maxlength="200">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content:space-between;">
               <button type="submit" class="btn-submit">Save Changes</button>
               <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
           </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="tag-movedin-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">
                <span style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:10px;background:var(--petal);flex-shrink:0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </span>
                Tag as Moved In
            </div>
            <button class="modal-close" onclick="closeModal('tag-movedin-modal')">&#x2715;</button>
        </div>
        <div class="modal-body" style="padding-top:.2rem;">
            <p style="font-size:.92rem;color:var(--ink);font-weight:600;margin:0 0 .6rem;">
                Tag <strong id="tag-movedin-name" style="color:var(--bright-pink);"></strong> as moved in?
            </p>
            <div class="modal-info-banner" style="margin-bottom:.6rem;">
                <span>A new <strong>Account ID</strong> and <strong>temporary password</strong> will be generated. The tenant's status will change to <strong>Pending</strong> until their first login.</span>
            </div>
            <p style="font-size:.78rem;color:var(--ink-muted);margin:0;line-height:1.5;">Make sure the assigned room is correct before proceeding. This action cannot be undone.</p>
        </div>
        <form method="POST" id="tag-movedin-form" action="" data-loading-message="Tagging as moved in..." style="display:contents;">
            @csrf
            <div class="modal-footer" style="justify-content:space-between;">
                <button type="button" class="btn-cancel" onclick="closeModal('tag-movedin-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Confirm</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="reschedule-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">
                <span style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:10px;background:var(--petal);flex-shrink:0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </span>
                Reschedule Reservation
            </div>
            <button class="modal-close" onclick="closeModal('reschedule-modal')">&#x2715;</button>
        </div>
        <form method="POST" id="reschedule-form" action="" data-loading-message="Rescheduling reservation..." style="display:contents;">
            @csrf
            <div class="modal-body">
                <p style="font-size:.9rem;color:var(--ink);font-weight:600;margin:0 0 .6rem;">
                    Update the estimated move-in date for <strong id="reschedule-name" style="color:var(--bright-pink);"></strong>.
                </p>
                <div class="modal-field">
                    <label>New Estimated Move-In Date</label>
                    <input type="date" name="estimated_move_in_date" id="reschedule-date" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('reschedule-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save New Date</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="reset-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/reset.png') }}" class="icon-sm" alt="Reset">
                Reset Password
            </div>
            <button class="modal-close" onclick="closeModal('reset-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <p style="font-size:.9rem;color:var(--ink-muted);margin-bottom:0;">
                Are you sure you want to reset the password for
                <strong id="reset-name" style="color:var(--ink);"></strong>?
                A new temporary password will be generated.
            </p>
        </div>
        <form method="POST" id="reset-form" action="" data-loading-message="Resetting password..." style="display:contents;">
            @csrf
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('reset-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:var(--bright-pink);color:var(--white);box-shadow:0 8px 20px rgba(232,23,93,.3);">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/delete.png') }}" class="icon-sm" alt="Delete">
                Delete Tenant
            </div>
            <button class="modal-close" onclick="closeModal('delete-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">Warning: This action cannot be undone. The tenant record will be permanently removed.</div>
            <p style="font-size:.9rem;color:#b06080;margin:0;">Are you sure you want to delete <strong id="delete-name" style="color:#5a1e38;"></strong>?</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <form method="POST" id="delete-form" action="" data-loading-message="Deleting tenant..." style="display:contents;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-submit" style="background:#e04867;box-shadow:0 8px 20px rgba(224,72,103,.3);">Delete</button>
            </form>
        </div>
    </div>
</div>

<div class="modal-overlay" id="moveout-verify-modal">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">
                <span style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;flex-shrink:0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </span>
                Confirm Move Out
            </div>
            <button class="modal-close" onclick="closeMoveOutVerify()">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div id="moveout-verify-tenant-bar" style="display:flex;align-items:center;gap:.85rem;padding:.75rem 1rem;border-radius:12px;background:#fffafd;border:1.5px solid var(--pink-100);margin-bottom:1rem;">
                <div id="moveout-verify-avatar" style="width:42px;height:42px;border-radius:50%;background:var(--gradient-pink);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.95rem;flex-shrink:0;box-shadow:0 4px 12px rgba(232,23,93,.2);"></div>
                <div style="flex:1;min-width:0;">
                    <div id="moveout-verify-name" style="font-size:.95rem;font-weight:800;color:var(--ink);line-height:1.2;"></div>
                    <div id="moveout-verify-meta" style="font-size:.75rem;color:var(--ink-muted);margin-top:.2rem;font-weight:500;"></div>
                </div>
                <div id="moveout-verify-date-pill" style="display:none;flex-shrink:0;padding:.3rem .75rem;border-radius:99px;background:var(--petal);border:1.5px solid var(--pink-100);font-size:.72rem;font-weight:700;color:var(--hot-pink);"></div>
            </div>

            <div id="moveout-bills-section" style="display:none;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.65rem;padding-bottom:.45rem;border-bottom:1.5px solid #fff0f4;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span style="font-size:.72rem;font-weight:800;color:#e04867;text-transform:uppercase;letter-spacing:.07em;">Unpaid Bills Detected</span>
                    <span id="moveout-bills-count-pill" style="font-size:.65rem;font-weight:800;padding:.15rem .5rem;border-radius:99px;background:#fff0f0;color:#e04867;border:1px solid var(--pink-200);"></span>
                </div>
                <div style="background:#fff0f4;border:1.5px solid #ffc2d1;border-radius:12px;padding:.7rem .85rem;margin-bottom:.75rem;">
                    <p style="font-size:.82rem;font-weight:700;color:#b0163a;margin:0 0 .2rem;line-height:1.4;">This tenant has outstanding balance.</p>
                    <p style="font-size:.76rem;color:#c0163a;margin:0;font-weight:500;line-height:1.45;">Moving out without settling the balance will leave bills unresolved. You may still proceed or print the bill slip for reference.</p>
                </div>
                <div id="moveout-bills-list" style="display:flex;flex-direction:column;gap:.4rem;margin-bottom:.75rem;max-height:220px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:var(--pink-200) transparent;"></div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:.6rem .9rem;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;">
                    <span style="font-size:.8rem;font-weight:700;color:#b0163a;">Total Outstanding</span>
                    <span id="moveout-bills-total" style="font-size:1.1rem;font-weight:800;color:#e04867;"></span>
                </div>
            </div>

            <div id="moveout-clear-section" style="display:none;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:.55rem;padding:.75rem 1rem;border-radius:12px;background:#e8faf5;border:1.5px solid #8ce0bb;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.2" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <div>
                        <p style="font-size:.82rem;font-weight:700;color:#1a7a52;margin:0 0 .1rem;">No outstanding balance.</p>
                        <p style="font-size:.74rem;color:#2e9e68;margin:0;font-weight:500;">All bills have been settled. Safe to proceed with move-out.</p>
                    </div>
                </div>
            </div>

            <div style="background:#fff9e6;border:1.5px solid #f0c040;border-radius:10px;padding:.6rem .85rem;font-size:.78rem;color:#7a5400;line-height:1.5;">
                Setting status to <strong>Move Out</strong> will archive this tenant record. This action takes effect immediately on save.
            </div>
        </div>
        <div class="modal-footer" style="justify-content:space-between;">
            <button type="button" id="moveout-print-btn" style="display:none;padding:.55rem 1.1rem;border-radius:10px;border:1.5px solid var(--pink-100);background:var(--white);color:var(--hot-pink);font-size:.82rem;font-weight:700;cursor:pointer;font-family:inherit;transition:background .2s,border-color .2s,color .2s;" onmouseover="this.style.background='var(--petal)';this.style.borderColor='var(--bright-pink)';" onmouseout="this.style.background='var(--white)';this.style.borderColor='var(--pink-100)';" onclick="printMoveOutBillSlip()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="vertical-align:-2px;margin-right:.35rem;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print Bill Slip
            </button>
            <div style="display:flex;align-items:center;gap:.55rem;margin-left:auto;">
                <button type="button" class="btn-cancel" onclick="closeMoveOutVerify()">Cancel</button>
                <button type="button" id="moveout-confirm-btn" style="padding:.6rem 1.4rem;border-radius:10px;border:none;background:#e04867;color:var(--white);font-size:.875rem;font-weight:700;cursor:pointer;font-family:inherit;box-shadow:0 8px 20px rgba(224,72,103,.25);transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 12px 28px rgba(224,72,103,.35)';" onmouseout="this.style.transform='';this.style.boxShadow='0 8px 20px rgba(224,72,103,.25)';" onclick="confirmMoveOut()">Confirm Move Out</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="renew-modal">
    <div class="modal" style="max-width:460px;">
        <div class="modal-header">
            <div class="modal-title">
                <span style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:10px;background:var(--petal);flex-shrink:0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                </span>
                Renew Tenant Stay
            </div>
            <button class="modal-close" onclick="closeModal('renew-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="form-progress-wrap" id="renew-progress-wrap">
                <div class="form-progress-label">
                    <span id="renew-progress-text">Fill in required fields</span>
                    <span id="renew-progress-count" class="partial"></span>
                </div>
                <div class="form-progress-bar">
                    <div class="form-progress-fill" id="renew-progress-fill" style="width:0%;background:var(--gradient-pink);"></div>
                </div>
            </div>
            <p style="font-size:.92rem;color:var(--ink);font-weight:600;margin:0 0 .75rem;">
                Renewing stay for <strong id="renew-tenant-name" style="color:var(--bright-pink);"></strong>
            </p>
            <div class="modal-info-banner" style="margin-bottom:.85rem;">
                <span>A new <strong>Account ID</strong> and <strong>temporary password</strong> will be generated. The tenant's status will be set to <strong>Pending</strong> until their first login. Their previous record will remain in the archive for reference.</span>
            </div>
            <div class="modal-grid">
                <div class="modal-field full">
                    <label>Stay Type</label>
                    <select id="renew-stay-type" onchange="onRenewStayTypeChange()" style="width:100%;padding:.5rem .8rem;border-radius:10px;border:1.5px solid var(--pink-100);background:#fffafd;font-size:.875rem;color:#5a1e38;outline:none;box-sizing:border-box;transition:border-color .2s,box-shadow .2s,background .2s;font-family:inherit;">
                        <option value="" disabled selected>Select type</option>
                        <option value="Solo Room">Solo Room</option>
                        <option value="Shared Room">Shared Room</option>
                    </select>
                </div>
                <div class="modal-field full" id="renew-room-suggest-wrap" style="display:none;">
                    <div id="renew-room-suggest"></div>
                </div>
                <div class="modal-field full">
                    <label>Room No.</label>
                    <input type="text" id="renew-room" placeholder="e.g. 304" inputmode="numeric" maxlength="10" class="room-number-input">
                    <span id="renew-room-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                </div>
                <div class="modal-field full" id="renew-stay-duration-wrap" style="display:none;">
                    <div id="renew-stay-duration-display"></div>
                </div>
                <div class="modal-field full" id="renew-room-hint-wrap" style="display:none;">
                    <div id="renew-room-hint"></div>
                </div>
                <div class="modal-field">
                    <label>New Move-In Date <span class="field-req-star">*</span></label>
                    <input type="date" id="renew-move-in" required>
                    <span id="renew-move-in-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                </div>
                <div class="modal-field">
                    <label>New Move-Out Date <span class="field-req-star">*</span></label>
                    <input type="date" id="renew-move-out" required>
                    <span id="renew-move-out-error" style="font-size:.75rem;color:#e04867;font-weight:600;margin-top:.2rem;display:none;"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('renew-modal')">Cancel</button>
            <button type="button" class="btn-submit" onclick="submitRenewTenant()">Renew &amp; Generate Credentials</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="renew-credentials-modal">
    <div class="modal" style="max-width:460px;">
        <div class="modal-header">
            <div class="modal-title">
                <img src="{{ asset('icons/nav-tenants.png') }}" class="icon-sm" alt="">
                Tenant Renewed Successfully
            </div>
            <button class="modal-close" onclick="closeModal('renew-credentials-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <p style="font-size:.88rem;color:var(--ink-muted);margin-bottom:1rem;">
                The account for <strong id="renew-cred-name" style="color:var(--ink);"></strong> has been renewed. Provide these credentials to the tenant:
            </p>
            <div class="credentials-box">
                <h4>New Login Credentials</h4>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Account ID</div>
                        <div class="credential-value" id="renew-cred-account-id"></div>
                    </div>
                    <button class="copy-btn" onclick="copyText('renew-cred-account-id', this)">Copy</button>
                </div>
                <div class="credential-row">
                    <div>
                        <div class="credential-label">Temporary Password</div>
                        <div class="credential-value" id="renew-cred-password"></div>
                    </div>
                    <button class="copy-btn" onclick="copyText('renew-cred-password', this)">Copy</button>
                </div>
            </div>
            <div class="credentials-warning">
                This temporary password will <strong>not be shown again</strong>. Inform the tenant immediately.
            </div>
            <div id="renew-cred-photo-suggest" style="display:none;margin-top:.75rem;background:linear-gradient(135deg,#fff5f9 0%,#ffe8f2 100%);border:1.5px solid var(--pink-100);border-radius:12px;padding:.8rem .9rem;">
                <div style="display:flex;align-items:flex-start;gap:.6rem;">
                    <div style="width:30px;height:30px;border-radius:8px;background:var(--petal);border:1.5px solid var(--pink-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.1rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.8rem;font-weight:800;color:var(--ink);margin-bottom:.2rem;letter-spacing:-.01em;">Tenant photo</div>
                        <div style="font-size:.75rem;color:#7a3050;line-height:1.5;margin-bottom:.65rem;">Upload or update the tenant photo for this renewed account. JPG or PNG, max 4MB.</div>
                        <div id="renew-cred-photo-preview-wrap" style="display:none;margin-bottom:.65rem;">
                            <div style="font-size:.7rem;font-weight:700;color:var(--hot-pink);text-transform:uppercase;letter-spacing:.04em;margin-bottom:.4rem;">Current photo</div>
                            <div style="position:relative;display:inline-block;">
                                <img id="renew-cred-photo-preview-img" src="" alt="Tenant photo" style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid var(--pink-100);box-shadow:0 4px 12px rgba(232,23,93,.15);display:block;">
                                <div id="renew-cred-photo-preview-check" style="position:absolute;bottom:0;right:0;width:18px;height:18px;border-radius:50%;background:#1f9d69;border:2px solid #fff;display:flex;align-items:center;justify-content:center;">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
                            <button type="button" id="renew-cred-upload-btn" onclick="triggerRenewPhotoUpload()" style="display:inline-flex;align-items:center;gap:.4rem;padding:.42rem 1rem;border-radius:8px;border:none;background:var(--gradient-pink);color:var(--white);font-size:.78rem;font-weight:700;cursor:pointer;font-family:inherit;transition:opacity .2s,transform .2s;box-shadow:0 4px 12px rgba(232,23,93,.2);">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span id="renew-cred-upload-btn-label">Upload Photo</span>
                            </button>
                            <span style="font-size:.72rem;color:#b06080;font-weight:500;">JPG or PNG, max 4MB</span>
                        </div>
                        <div id="renew-cred-upload-status" style="display:none;margin-top:.45rem;font-size:.75rem;font-weight:600;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('renew-credentials-modal')">Close</button>
            <button class="btn-submit" onclick="closeModal('renew-credentials-modal')">Got it</button>
        </div>
    </div>
</div>

<input type="file" id="tenant-photo-upload-input" accept="image/jpg,image/jpeg,image/png" style="display:none;" onchange="submitTenantPhoto(this)">
<input type="file" id="renew-photo-upload-input" accept="image/jpg,image/jpeg,image/png" style="display:none;" onchange="submitRenewPhoto(this)">

<div class="photo-lightbox" id="photo-lightbox" onclick="if(event.target===this){closePhotoLightbox();}">
    <button class="photo-lightbox-close" onclick="closePhotoLightbox()">&#x2715;</button>
    <img class="photo-lightbox-img" id="photo-lightbox-img" src="" alt="">
</div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
function showToast(message, type) {
    var existing = document.getElementById('dormease-toast');
    if (existing) existing.remove();
    var toast = document.createElement('div');
    toast.id = 'dormease-toast';
    var bg = type === 'success' ? '#1f9d69' : type === 'error' ? '#e04867' : '#5a1e38';
    toast.style.cssText = 'position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:flex;align-items:center;gap:.65rem;padding:.75rem 1.2rem;border-radius:14px;background:' + bg + ';color:#fff;font-size:.875rem;font-weight:700;box-shadow:0 8px 28px rgba(0,0,0,.18);opacity:0;transform:translateY(12px);transition:opacity .25s,transform .25s;max-width:360px;line-height:1.4;font-family:inherit;';
    var icon = type === 'success'
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
    toast.innerHTML = icon + '<span>' + message + '</span>';
    document.body.appendChild(toast);
    requestAnimationFrame(function() {
        requestAnimationFrame(function() {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });
    });
    setTimeout(function() {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(12px)';
        setTimeout(function() { if (toast.parentNode) toast.remove(); }, 300);
    }, 4000);
}
var _pdfBlobUrl = null;
var _pdfDownloadName = 'document.pdf';

function openPdfPreview(blobUrl, downloadName) {
    _pdfBlobUrl = blobUrl;
    _pdfDownloadName = downloadName || 'document.pdf';
    document.getElementById('pdf-preview-iframe').src = blobUrl;
    openModal('pdf-preview-modal');
}

function closePdfPreview() {
    closeModal('pdf-preview-modal');
    document.getElementById('pdf-preview-iframe').src = '';
    if (_pdfBlobUrl) { URL.revokeObjectURL(_pdfBlobUrl); _pdfBlobUrl = null; }
}

function downloadPdfFromPreview() {
    if (!_pdfBlobUrl) return;
    var a = document.createElement('a');
    a.href = _pdfBlobUrl;
    a.download = _pdfDownloadName;
    a.click();
}
function printCredentialSlip(type) {
    var accountId, tempPassword, tenantName;
    if (type === 'new') {
        accountId    = document.getElementById('cred-account-id').textContent.trim();
        tempPassword = document.getElementById('cred-temp-password').textContent.trim();
        tenantName   = '{{ session("new_tenant_name") }}';
    } else {
        accountId    = document.getElementById('reset-account-id').textContent.trim();
        tempPassword = document.getElementById('reset-temp-password').textContent.trim();
        tenantName   = '{{ session("reset_tenant_name") }}';
    }

    var today = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    var { jsPDF } = window.jspdf;

    var W = 80, H = 148;
    var doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: [W, H], compress: true });
    doc.setProperties({ title: 'Credentials - ' + tenantName, author: 'DormEase', creator: 'DormEase' });

    var pink   = [232, 23, 93];
    var ink    = [26, 26, 46];
    var muted  = [140, 100, 120];
    var white  = [255, 255, 255];
    var petal  = [255, 243, 248];
    var border = [244, 184, 208];
    var warn   = [255, 249, 230];
    var warnTx = [122, 84, 0];
    var warnBd = [240, 192, 64];

    doc.setFillColor(pink[0], pink[1], pink[2]);
    doc.rect(0, 0, W, 28, 'F');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(5.5);
    doc.setTextColor(white[0], white[1], white[2]);
    doc.text('SANCTISSIMO ROSARIO LADIES DORMITORY', W / 2, 8, { align: 'center' });

    doc.setFontSize(11);
    doc.text('Login Credentials', W / 2, 15, { align: 'center' });

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6.5);
    doc.setTextColor(255, 210, 230);
    doc.text('DormEase Tenant Portal', W / 2, 21.5, { align: 'center' });

    var y = 33;

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.setTextColor(ink[0], ink[1], ink[2]);
    doc.text(tenantName, W / 2, y, { align: 'center' });

    y += 3.5;
    doc.setDrawColor(border[0], border[1], border[2]);
    doc.setLineWidth(0.3);
    doc.line(6, y, W - 6, y);

    y += 5.5;

    function drawField(label, value) {
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(5.5);
        doc.setTextColor(pink[0], pink[1], pink[2]);
        doc.text(label.toUpperCase(), 6, y);

        y += 1.8;

        doc.setFillColor(petal[0], petal[1], petal[2]);
        doc.setDrawColor(border[0], border[1], border[2]);
        doc.setLineWidth(0.4);
        doc.roundedRect(6, y, W - 12, 10.5, 1.8, 1.8, 'FD');

        doc.setFont('courier', 'bold');
        doc.setFontSize(10);
        doc.setTextColor(ink[0], ink[1], ink[2]);
        doc.text(value, W / 2, y + 7, { align: 'center' });

        y += 14.5;
    }

    drawField('Account ID', accountId);
    drawField('Temporary Password', tempPassword);

    doc.setFillColor(warn[0], warn[1], warn[2]);
    doc.setDrawColor(warnBd[0], warnBd[1], warnBd[2]);
    doc.setLineWidth(0.3);
    doc.roundedRect(6, y, W - 12, 18, 1.8, 1.8, 'FD');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(6);
    doc.setTextColor(warnTx[0], warnTx[1], warnTx[2]);
    doc.text('Important', 11, y + 5.5);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(5.8);
    var warnLines = doc.splitTextToSize(
        'This is a temporary password. You will be prompted to change it on your first login. Keep this slip private and do not share it with anyone.',
        W - 16
    );
    doc.text(warnLines, 9, y + 10, { lineHeightFactor: 1.6 });

    y += 22;

    doc.setDrawColor(border[0], border[1], border[2]);
    doc.setLineWidth(0.3);
    doc.line(6, y, W - 6, y);

    y += 4.5;

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(5.5);
    doc.setTextColor(muted[0], muted[1], muted[2]);
    doc.text('Issued: ' + today, 6, y);

    doc.setFont('helvetica', 'bold');
    doc.setTextColor(pink[0], pink[1], pink[2]);
    doc.text('DormEase', W - 6, y, { align: 'right' });

    var safeName = (tenantName || 'tenant').replace(/[^a-zA-Z0-9\s]/g, '').replace(/\s+/g, '-').toLowerCase();
    var blobUrl = doc.output('bloburl');
    openPdfPreview(blobUrl, 'credentials-' + safeName + '.pdf');
}

var tenants = {!! json_encode($tenants, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
var billingData = {!! json_encode($billingData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
var PER_PAGE = 8;
var currentTenant = null;
var sectionState = { active: true, reserved: true };
var sectionPages = { active: 1, reserved: 1 };
var sectionData  = { active: [], reserved: [] };
var addCurrentStep = 1;
var selectedRoomNumber = null;
var editOriginalRoomNumber = null;
var editOriginalStayType = null;

var EMAIL_REGEX = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/;

function validateEmailField(inputId, errorId, excludeTenantId) {
    var input = document.getElementById(inputId);
    var error = document.getElementById(errorId);
    if (!input || !error) return true;
    var val = input.value.trim();
    var msg = '';
    if (!val) {
        msg = input.required ? 'Email address is required.' : '';
    } else if (val.indexOf('@') === -1) {
        msg = 'Email must contain an "@" symbol.';
    } else if (val.indexOf(' ') !== -1) {
        msg = 'Email cannot contain spaces.';
    } else if ((val.match(/@/g) || []).length > 1) {
        msg = 'Email cannot contain more than one "@".';
    } else if (!EMAIL_REGEX.test(val)) {
        msg = 'Please enter a valid email address (e.g. name@example.com).';
    }
    if (!msg && val) {
        var duplicate = tenants.find(function(t) {
            if (excludeTenantId && t.tenant_id == excludeTenantId) return false;
            if (t.status === 'inactive') return false;
            return (t.email || '').toLowerCase() === val.toLowerCase();
        });
        if (duplicate) {
            msg = 'This email is already in use by ' + duplicate.first_name + ' ' + duplicate.last_name + '.';
        }
    }
    if (msg) {
        input.classList.add('field-invalid');
        error.textContent = msg;
        error.style.display = 'block';
        return false;
    }
    input.classList.remove('field-invalid');
    error.style.display = 'none';
    error.textContent = '';
    return true;
}

function formatMobileSegment(digits) {
    if (digits.length > 10) digits = digits.substring(0, 10);
    if (digits.length > 3 && digits.length <= 6) {
        return digits.substring(0, 3) + '-' + digits.substring(3);
    }
    if (digits.length > 6) {
        return digits.substring(0, 3) + '-' + digits.substring(3, 6) + '-' + digits.substring(6);
    }
    return digits;
}

function formatZeroNine(digits) {
    if (digits.length > 11) digits = digits.substring(0, 11);
    if (digits.length > 4 && digits.length <= 7) {
        return digits.substring(0, 4) + '-' + digits.substring(4);
    }
    if (digits.length > 7) {
        return digits.substring(0, 4) + '-' + digits.substring(4, 7) + '-' + digits.substring(7);
    }
    return digits;
}

function usesIntlPhoneFormat(rawValue, digits) {
    var trimmed = (rawValue || '').trim();
    return trimmed.charAt(0) === '+' || (digits.length >= 2 && digits.substring(0, 2) === '63');
}

function formatPhoneNumber(rawValue) {
    var trimmed = (rawValue || '').trim();
    var digits = rawValue.replace(/\D/g, '');

    if (usesIntlPhoneFormat(rawValue, digits)) {
        if (trimmed === '+') return '+';
        if (digits.startsWith('63')) {
            digits = digits.substring(0, 12);
        } else if (digits.startsWith('6')) {
            digits = ('63' + digits.substring(1)).substring(0, 12);
        } else if (trimmed.charAt(0) === '+') {
            digits = ('63' + digits).substring(0, 12);
        }
        var local = digits.startsWith('63') ? digits.substring(2) : '';
        return '+63' + (local ? ' ' + formatMobileSegment(local) : '');
    }

    return formatZeroNine(digits);
}

function validatePhoneField(inputId, errorId, required) {
    var input = document.getElementById(inputId);
    var error = document.getElementById(errorId);
    if (!input || !error) return true;
    var val = input.value.trim();
    var digits = val.replace(/\D/g, '');
    var msg = '';
    if (!val) {
        msg = required ? 'Contact number is required.' : '';
    } else if (usesIntlPhoneFormat(val, digits)) {
        if (digits.length !== 12 || !digits.startsWith('63') || digits.charAt(2) !== '9') {
            msg = 'Use +63 followed by a 10-digit mobile number (e.g. +63 912-345-6789).';
        } else if (!/^[0-9+\-\s]+$/.test(val)) {
            msg = 'Contact number can only contain numbers, +, spaces, and dashes.';
        }
    } else if (digits.length !== 11 || !digits.startsWith('09')) {
        msg = 'Use 11 digits starting with 09 (e.g. 0912-345-6789).';
    } else if (!/^[0-9-]+$/.test(val)) {
        msg = 'Contact number can only contain numbers and dashes.';
    }
    if (msg) {
        input.classList.add('field-invalid');
        error.textContent = msg;
        error.style.display = 'block';
        return false;
    }
    input.classList.remove('field-invalid');
    error.style.display = 'none';
    error.textContent = '';
    return true;
}

function attachPhoneFormatter(inputId, errorId, required) {
    var input = document.getElementById(inputId);
    if (!input) return;
    if (input._phoneFormatterAttached) return;
    input._phoneFormatterAttached = true;
    input.addEventListener('input', function() {
        var cursorAtEnd = this.selectionStart === this.value.length;
        var formatted = formatPhoneNumber(this.value);
        this.value = formatted;
        if (cursorAtEnd) {
            this.setSelectionRange(this.value.length, this.value.length);
        }
        validatePhoneField(inputId, errorId, required);
    });
    input.addEventListener('blur', function() {
        validatePhoneField(inputId, errorId, required);
    });
    input.addEventListener('keypress', function(e) {
        if (e.which === 8) return;
        var char = String.fromCharCode(e.which);
        var pos = this.selectionStart;
        if (char === '+' && pos === 0 && this.value.indexOf('+') === -1) return;
        if (/[0-9]/.test(char)) return;
        e.preventDefault();
    });
}

function attachEmailValidator(inputId, errorId, excludeTenantIdFn) {
    var input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener('input', function() {
        var exId = excludeTenantIdFn ? excludeTenantIdFn() : null;
        validateEmailField(inputId, errorId, exId);
    });
    input.addEventListener('blur', function() {
        var exId = excludeTenantIdFn ? excludeTenantIdFn() : null;
        validateEmailField(inputId, errorId, exId);
    });
}

function validateMoveOutDate(moveInId, moveOutId, errorId) {
    var moveIn  = document.getElementById(moveInId);
    var moveOut = document.getElementById(moveOutId);
    var error   = document.getElementById(errorId);
    if (!moveIn || !moveOut || !error) return true;
    var moveInVal  = moveIn.value;
    var moveOutVal = moveOut.value;
    if (!moveOutVal) {
        moveOut.classList.remove('field-invalid');
        error.style.display = 'none';
        error.textContent = '';
        return true;
    }
    if (moveInVal && moveOutVal < moveInVal) {
        moveOut.classList.add('field-invalid');
        error.textContent = 'Move-out date cannot be earlier than move-in date.';
        error.style.display = 'block';
        return false;
    }
    moveOut.classList.remove('field-invalid');
    error.style.display = 'none';
    error.textContent = '';
    return true;
}

function attachMoveOutValidator(moveInId, moveOutId, errorId) {
    var moveIn  = document.getElementById(moveInId);
    var moveOut = document.getElementById(moveOutId);
    if (!moveIn || !moveOut) return;
    moveOut.addEventListener('change', function() { validateMoveOutDate(moveInId, moveOutId, errorId); });
    moveIn.addEventListener('change', function() { validateMoveOutDate(moveInId, moveOutId, errorId); });
}

function validateEstimatedMoveInDate(inputId, errorId) {
    var input = document.getElementById(inputId);
    var error = document.getElementById(errorId);
    if (!input || !error) return true;
    var val = input.value;
    if (!val) {
        input.classList.remove('field-invalid');
        error.style.display = 'none';
        error.textContent = '';
        return true;
    }
    var today = new Date();
    today.setHours(0,0,0,0);
    var est = new Date(val + 'T00:00:00');
    if (est < today) {
        input.classList.add('field-invalid');
        error.textContent = 'Estimated move-in date cannot be earlier than today.';
        error.style.display = 'block';
        return false;
    }
    input.classList.remove('field-invalid');
    error.style.display = 'none';
    error.textContent = '';
    return true;
}

function attachEstimatedMoveInValidator(inputId, errorId) {
    var input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener('change', function() { validateEstimatedMoveInDate(inputId, errorId); });
}

function triggerTenantPhotoUpload(tenantId) {
    var input = document.getElementById('tenant-photo-upload-input');
    input.dataset.tenantId = tenantId;
    input.value = '';
    input.click();
}

async function submitTenantPhoto(input) {
    var tenantId = input.dataset.tenantId;
    var file     = input.files[0];
    if (!file) return;

    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (allowedTypes.indexOf(file.type) === -1) {
        showPhotoValidationModal('Invalid file type. Only JPG and PNG photos are accepted.');
        input.value = '';
        return;
    }

    var maxBytes = 4 * 1024 * 1024;
    if (file.size > maxBytes) {
        showPhotoValidationModal('File is too large. Maximum allowed size is 4MB.');
        input.value = '';
        return;
    }

    showActionLoading('Uploading photo...');

    var formData = new FormData();
    formData.append('tenant_photo', file);

    try {
        var res = await fetch('/tenants/' + tenantId + '/upload-photo', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData,
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Upload failed.');

        var idx = tenants.findIndex(function(t) { return t.tenant_id == tenantId; });
        if (idx !== -1) {
            tenants[idx].tenant_photo = data.tenant_photo;
            currentTenant = tenants[idx];
        }

        var img = document.getElementById('view-tenant-photo-img');
        if (img) {
            img.src = data.url + '?t=' + Date.now();
        } else {
            viewTenant(currentTenant);
        }

        applyFilters();
        showToast('Photo uploaded successfully.', 'success');
    } catch (e) {
        showToast(e.message, 'error');
    } finally {
        document.getElementById('action-loading').classList.remove('open');
    }
}

function renderMoveOutDateView(dateStr) {
    if (!dateStr) return '\u2014';
    var today   = new Date();
    today.setHours(0, 0, 0, 0);
    var moveout = new Date(dateStr + 'T00:00:00');
    var diff    = Math.floor((moveout - today) / 86400000);
    var formatted = fmtDate(dateStr);
    if (diff < 0) {
        var overdueDays = Math.abs(diff);
        var overdueLabel = overdueDays === 1 ? '1 day overdue' : overdueDays + ' days overdue';
        return '<span style="display:inline-flex;align-items:center;gap:.45rem;flex-wrap:wrap;">'
            + '<span style="color:#e04867;font-weight:700;">' + formatted + '</span>'
            + '<span style="display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:99px;background:#fff0f2;border:1px solid #ffc2ce;font-size:.68rem;font-weight:800;color:#c0163a;">'
                + '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#c0163a" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
                + overdueLabel
            + '</span>'
        + '</span>';
    }
    if (diff === 0) {
        return '<span style="display:inline-flex;align-items:center;gap:.45rem;flex-wrap:wrap;">'
            + '<span style="color:#c8960c;font-weight:700;">' + formatted + '</span>'
            + '<span style="display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:99px;background:#fff9e6;border:1px solid #f0c040;font-size:.68rem;font-weight:800;color:#9a6200;">'
                + '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9a6200" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
                + 'Today'
            + '</span>'
        + '</span>';
    }
    if (diff <= 7) {
        return '<span style="display:inline-flex;align-items:center;gap:.45rem;flex-wrap:wrap;">'
            + '<span style="color:#c8960c;font-weight:700;">' + formatted + '</span>'
            + '<span style="display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:99px;background:#fff9e6;border:1px solid #f0c040;font-size:.68rem;font-weight:800;color:#9a6200;">'
                + '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9a6200" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
                + 'In ' + diff + ' day' + (diff === 1 ? '' : 's')
            + '</span>'
        + '</span>';
    }
    if (diff <= 14) {
        return '<span style="display:inline-flex;align-items:center;gap:.45rem;flex-wrap:wrap;">'
            + '<span style="color:#9a6200;font-weight:600;">' + formatted + '</span>'
            + '<span style="display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:99px;background:#fff8e0;border:1px solid #f0c840;font-size:.68rem;font-weight:700;color:#9a6200;">'
                + 'In ' + diff + ' days'
            + '</span>'
        + '</span>';
    }
    return '<span style="color:#5a1e38;font-weight:500;">' + formatted + '</span>';
}

function checkMoveoutWarning() {
    var moveoutInput = document.getElementById('edit-moveout');
    var warningBar   = document.getElementById('edit-moveout-warning');
    var warningText  = document.getElementById('edit-moveout-warning-text');
    var warnSmall    = warningBar ? warningBar.querySelector('small') : null;
    if (!moveoutInput || !warningBar) return;
    var val = moveoutInput.value;
    if (!val) {
        warningBar.classList.remove('visible');
        warningBar.style.background = '#fff0f4';
        warningBar.style.borderColor = '#ffc2d1';
        if (warningText) warningText.style.color = '#b0163a';
        if (warnSmall) warnSmall.style.color = '#c0163a';
        return;
    }
    var today   = new Date();
    today.setHours(0, 0, 0, 0);
    var moveout = new Date(val + 'T00:00:00');
    var diff    = Math.floor((moveout - today) / 86400000);
    if (diff < 0) {
        var dayLabel = Math.abs(diff) === 1 ? '1 day ago' : Math.abs(diff) + ' days ago';
        if (warningText) warningText.textContent = 'This tenant\'s move-out date has passed (' + dayLabel + ').';
        if (warnSmall) warnSmall.textContent = 'The account will be automatically archived at midnight if no action is taken.';
        warningBar.style.background = '#fff0f4';
        warningBar.style.borderColor = '#ffc2d1';
        if (warningText) warningText.style.color = '#b0163a';
        if (warnSmall) warnSmall.style.color = '#c0163a';
        warningBar.classList.add('visible');
    } else if (diff === 0) {
        if (warningText) warningText.textContent = 'This tenant\'s move-out date is today.';
        if (warnSmall) warnSmall.textContent = 'Extend their stay now to keep their account active past tonight.';
        warningBar.style.background = '#fff9e6';
        warningBar.style.borderColor = '#f0c040';
        if (warningText) warningText.style.color = '#9a6200';
        if (warnSmall) warnSmall.style.color = '#c8960c';
        warningBar.classList.add('visible');
    } else if (diff <= 7) {
        if (warningText) warningText.textContent = 'Move-out date is in ' + diff + ' day' + (diff === 1 ? '' : 's') + '.';
        if (warnSmall) warnSmall.textContent = 'Use the extend buttons below if the tenant is renewing their stay.';
        warningBar.style.background = '#fff9e6';
        warningBar.style.borderColor = '#f0c040';
        if (warningText) warningText.style.color = '#9a6200';
        if (warnSmall) warnSmall.style.color = '#c8960c';
        warningBar.classList.add('visible');
    } else {
        warningBar.classList.remove('visible');
    }
}

function calcStayDuration(moveInVal, moveOutVal) {
    if (!moveInVal || !moveOutVal) return null;
    var start = new Date(moveInVal + 'T00:00:00');
    var end   = new Date(moveOutVal + 'T00:00:00');
    if (isNaN(start) || isNaN(end) || end <= start) return null;
    var years  = 0, months = 0, days = 0;
    var y = end.getFullYear() - start.getFullYear();
    var m = end.getMonth()    - start.getMonth();
    var d = end.getDate()     - start.getDate();
    if (d < 0) {
        m--;
        var prevMonth = new Date(end.getFullYear(), end.getMonth(), 0);
        d += prevMonth.getDate();
    }
    if (m < 0) { y--; m += 12; }
    years  = y;
    months = m;
    days   = d;
    var parts = [];
    if (years  > 0) parts.push(years  + ' yr'    + (years  !== 1 ? 's' : ''));
    if (months > 0) parts.push(months + ' mo'    + (months !== 1 ? 's' : ''));
    if (days   > 0) parts.push(days   + ' day'   + (days   !== 1 ? 's' : ''));
    if (parts.length === 0) return '0 days';
    return parts.join(', ');
}

function renderStayDuration(wrapId, displayId, moveInVal, moveOutVal) {
    var wrap    = document.getElementById(wrapId);
    var display = document.getElementById(displayId);
    if (!wrap || !display) return;
    var dur = calcStayDuration(moveInVal, moveOutVal);
    if (!dur) { wrap.style.display = 'none'; display.innerHTML = ''; return; }
    var start = new Date(moveInVal + 'T00:00:00');
    var end   = new Date(moveOutVal + 'T00:00:00');
    var totalDays = Math.round((end - start) / 86400000);
    display.innerHTML =
        '<div style="display:flex;align-items:center;gap:.55rem;padding:.5rem .8rem;border-radius:10px;background:#f0faf6;border:1.5px solid #8ce0bb;">'
            + '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'
            + '<div style="flex:1;min-width:0;">'
                + '<span style="font-size:.75rem;font-weight:800;color:#1a7a52;">Stay duration: ' + dur + '</span>'
                + '<span style="font-size:.72rem;color:#2e9e68;margin-left:.5rem;font-weight:500;">(' + totalDays + ' total day' + (totalDays !== 1 ? 's' : '') + ')</span>'
            + '</div>'
        + '</div>';
    wrap.style.display = '';
}

function attachStayDuration(moveInId, moveOutId, displayId) {
    var wrapId  = displayId.replace('-display', '-wrap');
    var moveIn  = document.getElementById(moveInId);
    var moveOut = document.getElementById(moveOutId);
    if (!moveIn || !moveOut) return;
    function update() {
        renderStayDuration(wrapId, displayId, moveIn.value, moveOut.value);
    }
    moveIn.addEventListener('change', update);
    moveOut.addEventListener('change', update);
    moveIn.addEventListener('input', update);
    moveOut.addEventListener('input', update);
}

function extendStay(days) {
    var moveoutInput = document.getElementById('edit-moveout');
    if (!moveoutInput) return;
    var base = moveoutInput.value
        ? new Date(moveoutInput.value + 'T00:00:00')
        : new Date();
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    if (base < today) base = new Date(today);
    base.setDate(base.getDate() + days);
    var yyyy = base.getFullYear();
    var mm   = String(base.getMonth() + 1).padStart(2, '0');
    var dd   = String(base.getDate()).padStart(2, '0');
    moveoutInput.value = yyyy + '-' + mm + '-' + dd;
    moveoutInput.dispatchEvent(new Event('change'));
    checkMoveoutWarning();
    validateMoveOutDate('edit-date', 'edit-moveout', 'edit-moveout-error');
    renderStayDuration('edit-stay-duration-wrap', 'edit-stay-duration-display', document.getElementById('edit-date').value, moveoutInput.value);
}

function showPhotoValidationModal(message) {
    var existing = document.getElementById('photo-validation-modal');
    if (existing) existing.remove();

    var overlay = document.createElement('div');
    overlay.id = 'photo-validation-modal';
    overlay.style.cssText = 'position:fixed;inset:0;z-index:900;display:flex;align-items:center;justify-content:center;background:rgba(90,30,56,.38);backdrop-filter:blur(4px);padding:1rem;';

    overlay.innerHTML =
        '<div style="background:var(--white);border-radius:20px;width:100%;max-width:400px;box-shadow:0 24px 60px rgba(232,23,93,.18),0 4px 16px rgba(0,0,0,.08);overflow:hidden;animation:modalIn .28s cubic-bezier(.34,1.3,.64,1) both;">'
            + '<div style="padding:.9rem 1.1rem .6rem;display:flex;align-items:center;justify-content:space-between;">'
                + '<div style="display:flex;align-items:center;gap:.55rem;">'
                    + '<div style="width:34px;height:34px;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;display:flex;align-items:center;justify-content:center;flex-shrink:0;">'
                        + '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
                    + '</div>'
                    + '<span style="font-size:1rem;font-weight:800;color:var(--ink);letter-spacing:-.02em;">Photo Upload Error</span>'
                + '</div>'
                + '<button onclick="document.getElementById(\'photo-validation-modal\').remove()" style="width:30px;height:30px;border-radius:8px;border:1.5px solid var(--pink-100);background:var(--petal);color:var(--bright-pink);font-size:.95rem;cursor:pointer;display:flex;align-items:center;justify-content:center;font-family:inherit;">&#x2715;</button>'
            + '</div>'
            + '<div style="padding:.5rem 1.1rem 1rem;">'
                + '<div style="background:#fff0f4;border:1.5px solid #ffc2d1;border-radius:12px;padding:.85rem 1rem;margin-bottom:1rem;">'
                    + '<p style="font-size:.88rem;color:#b0163a;font-weight:600;margin:0 0 .35rem;">' + message + '</p>'
                + '</div>'
                + '<div style="background:#fffafd;border:1.5px solid var(--pink-100);border-radius:12px;padding:.8rem 1rem;">'
                    + '<p style="font-size:.72rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.07em;margin:0 0 .6rem;">Photo requirements</p>'
                    + '<div style="display:flex;flex-direction:column;gap:.4rem;">'
                        + '<div style="display:flex;align-items:center;gap:.55rem;">'
                            + '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>'
                            + '<span style="font-size:.8rem;color:var(--ink);">Accepted formats: JPG, JPEG, PNG</span>'
                        + '</div>'
                        + '<div style="display:flex;align-items:center;gap:.55rem;">'
                            + '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>'
                            + '<span style="font-size:.8rem;color:var(--ink);">Maximum file size: 4MB</span>'
                        + '</div>'
                        + '<div style="display:flex;align-items:center;gap:.55rem;">'
                            + '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>'
                            + '<span style="font-size:.8rem;color:var(--ink);">Clear, well-lit front-facing photo recommended</span>'
                        + '</div>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div style="padding:.6rem 1.1rem .8rem;border-top:1.5px solid var(--pink-100);display:flex;justify-content:flex-end;background:#fffafd;">'
                + '<button onclick="document.getElementById(\'photo-validation-modal\').remove()" style="padding:.6rem 1.4rem;border-radius:10px;border:none;background:var(--gradient-pink);color:var(--white);font-size:.875rem;font-weight:700;cursor:pointer;font-family:inherit;box-shadow:0 8px 20px rgba(232,23,93,.25);">Got it</button>'
            + '</div>'
        + '</div>';

    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) overlay.remove();
    });

    document.body.appendChild(overlay);
}

function toggleVacationNote() {
    var cb   = document.getElementById('edit-is-on-vacation');
    var wrap = document.getElementById('edit-vacation-note-wrap');
    wrap.style.display = cb.checked ? '' : 'none';
    if (!cb.checked) {
        document.getElementById('edit-vacation-note').value = '';
    }
    enableSubmit('#edit-modal .btn-submit');
}

function validateAddTenantForm(e) {
    var emailOk    = validateEmailField('add-email', 'add-email-error', null);
    var contactOk  = validatePhoneField('add-contact', 'add-contact-error', true);
    var guardianOk = validatePhoneField('add-guardian', 'add-guardian-error', false);
    var moveOutOk  = validateMoveOutDate('add-move-in-date', 'add-move-out-date', 'add-moveout-error');
    var estOk      = validateEstimatedMoveInDate('add-estimated-move-in', 'add-estimated-move-in-error');
    var mode       = document.getElementById('add-mode-input').value;
    var stayType   = document.getElementById('add-stay-type-select').value;
    var moveInDate = document.getElementById('add-move-in-date').value;

    if (!stayType) {
        e.preventDefault();
        var staySelect = document.getElementById('add-stay-type-select');
        staySelect.classList.add('field-invalid');
        staySelect.focus();
        showToast('Please select a stay type.', 'error');
        return false;
    }

    if (mode === 'moved_in' && !moveInDate) {
        e.preventDefault();
        var miInput = document.getElementById('add-move-in-date');
        miInput.classList.add('field-invalid');
        miInput.focus();
        showToast('Please enter a move-in date.', 'error');
        return false;
    }

    var moveOutVal = document.getElementById('add-move-out-date').value;
    if (!moveOutVal && moveInDate) {
        var d = new Date(moveInDate + 'T00:00:00');
        d.setFullYear(d.getFullYear() + 1);
        var autoMoveOut = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
        document.getElementById('add-move-out-date').value = autoMoveOut;
    }

    if (!emailOk || !contactOk || !guardianOk || !moveOutOk || !estOk) {
        e.preventDefault();
        if (!emailOk) {
            document.getElementById('add-email').focus();
        } else if (!contactOk) {
            document.getElementById('add-contact').focus();
        } else if (!guardianOk) {
            document.getElementById('add-guardian').focus();
        } else if (!moveOutOk) {
            document.getElementById('add-move-out-date').focus();
        } else if (!estOk) {
            document.getElementById('add-estimated-move-in').focus();
        }
        return false;
    }
    return true;
}

function validateEditTenantForm(e) {
    var emailOk    = validateEmailField('edit-email', 'edit-email-error', currentTenant ? currentTenant.tenant_id : null);
    var contactOk  = validatePhoneField('edit-contact', 'edit-contact-error', true);
    var guardianOk = validatePhoneField('edit-guardian', 'edit-guardian-error', false);
    var moveOutOk  = validateMoveOutDate('edit-date', 'edit-moveout', 'edit-moveout-error');
    var estOk      = validateEstimatedMoveInDate('edit-estimated-move-in', 'edit-estimated-move-in-error');
    if (!emailOk || !contactOk || !guardianOk || !moveOutOk || !estOk) {
        e.preventDefault();
        if (!emailOk) {
            document.getElementById('edit-email').focus();
        } else if (!contactOk) {
            document.getElementById('edit-contact').focus();
        } else if (!guardianOk) {
            document.getElementById('edit-guardian').focus();
        } else if (!moveOutOk) {
            document.getElementById('edit-moveout').focus();
        } else if (!estOk) {
            document.getElementById('edit-estimated-move-in').focus();
        }
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
   attachEmailValidator('add-email', 'add-email-error', null);
    attachEmailValidator('edit-email', 'edit-email-error', function() { return currentTenant ? currentTenant.tenant_id : null; });
    attachPhoneFormatter('add-contact', 'add-contact-error', true);
    attachPhoneFormatter('add-guardian', 'add-guardian-error', false);
    attachMoveOutValidator('add-move-in-date', 'add-move-out-date', 'add-moveout-error');
    attachStayDuration('add-move-in-date', 'add-move-out-date', 'add-stay-duration-display');
    var addMoveInEl = document.getElementById('add-move-in-date');
    if (addMoveInEl) {
        addMoveInEl.addEventListener('change', function() {
            var moveOutEl = document.getElementById('add-move-out-date');
            if (moveOutEl && !moveOutEl.value && this.value) {
                var d = new Date(this.value + 'T00:00:00');
                d.setFullYear(d.getFullYear() + 1);
                moveOutEl.value = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
            }
        });
    }
    attachMoveOutValidator('edit-date', 'edit-moveout', 'edit-moveout-error');
    attachStayDuration('edit-date', 'edit-moveout', 'edit-stay-duration-display');
    attachEstimatedMoveInValidator('add-estimated-move-in', 'add-estimated-move-in-error');
    attachEstimatedMoveInValidator('edit-estimated-move-in', 'edit-estimated-move-in-error');
});

function showActionLoading(message) {
    var overlay = document.getElementById('action-loading');
    document.getElementById('action-loading-text').textContent = message || 'Please wait...';
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
}

function setFormLoading(form, message) {
    form.querySelectorAll('button[type="submit"]').forEach(function(btn) {
        btn.textContent = 'Please wait...';
        btn.disabled = true;
        btn.classList.add('is-loading');
    });
    form.querySelectorAll('button:not([type="submit"])').forEach(function(btn) {
        btn.disabled = true;
        btn.classList.add('is-loading');
    });
    showActionLoading(message);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form[data-loading-message]').forEach(function(form) {
        form.addEventListener('submit', function() {
            if (this.id === 'edit-form' && !_moveOutPendingSubmit) {
                var statusSel = document.getElementById('edit-status');
                if (statusSel && statusSel.value === 'move_out') {
                    return;
                }
            }
            setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
        });
    });
});

document.getElementById('table-date').textContent =
    'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

document.addEventListener('DOMContentLoaded', function() {
    var editForm = document.getElementById('edit-form');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            console.log('EDIT FORM SUBMIT FIRED');
            console.log('action:', this.action);
            console.log('status value:', document.getElementById('edit-status').value);
            console.log('estimated_move_in_date value:', document.getElementById('edit-estimated-move-in').value);
        });
    }
});

function openModal(id)  { document.getElementById(id).classList.add('open'); }

function openPhotoLightbox(url) {
    document.getElementById('photo-lightbox-img').src = url;
    document.getElementById('photo-lightbox').classList.add('open');
}

function closePhotoLightbox() {
    document.getElementById('photo-lightbox').classList.remove('open');
    document.getElementById('photo-lightbox-img').src = '';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    if (id === 'add-modal') {
        var w = document.getElementById('add-room-hint-wrap');
        var h = document.getElementById('add-room-hint');
        if (w) w.style.display = 'none';
        if (h) h.innerHTML = '';
        var sw = document.getElementById('add-room-suggest-wrap');
        var sb = document.getElementById('add-room-suggest');
        if (sw) sw.style.display = 'none';
        if (sb) sb.innerHTML = '';
        var aw = document.getElementById('add-est-movein-wrap');
        var an = document.getElementById('add-reservation-notes-wrap');
        var am = document.getElementById('add-movein-wrap');
        if (aw) aw.style.display = 'none';
        if (an) an.style.display = 'none';
        if (am) am.style.display = '';
        var amo = document.getElementById('add-move-out-date');
        var amoErr = document.getElementById('add-moveout-error');
        if (amo) { amo.value = ''; amo.classList.remove('field-invalid'); }
        if (amoErr) { amoErr.style.display = 'none'; amoErr.textContent = ''; }
        var ae = document.getElementById('add-email');
        var aeErr = document.getElementById('add-email-error');
        if (ae) ae.classList.remove('field-invalid');
        if (aeErr) { aeErr.style.display = 'none'; aeErr.textContent = ''; }
        var ac = document.getElementById('add-contact');
        var acErr = document.getElementById('add-contact-error');
        if (ac) ac.classList.remove('field-invalid');
        if (acErr) { acErr.style.display = 'none'; acErr.textContent = ''; }
        var ag = document.getElementById('add-guardian');
        var agErr = document.getElementById('add-guardian-error');
        if (ag) { ag.value = ''; ag.classList.remove('field-invalid'); }
        if (agErr) { agErr.style.display = 'none'; agErr.textContent = ''; }
        var ast = document.getElementById('add-stay-type-select');
        if (ast) ast.classList.remove('field-invalid');
        var ami = document.getElementById('add-move-in-date');
        if (ami) ami.classList.remove('field-invalid');
        if (ac) ac.classList.remove('field-invalid');
        if (acErr) { acErr.style.display = 'none'; acErr.textContent = ''; }
        var modeInput = document.getElementById('add-mode-input');
        if (modeInput) modeInput.value = 'moved_in';
        setAddMode('moved_in');
        goAddStep(1);
        var addSrc = document.getElementById('add-referred-source');
        if (addSrc) {
            addSrc.value = '';
            ['current-select','former-select'].forEach(function(s) {
                var el = document.getElementById('add-referred-' + s);
                if (el) { el.style.display = 'none'; el.selectedIndex = 0; }
            });
            var oi = document.getElementById('add-referred-other-input');
            if (oi) { oi.style.display = 'none'; oi.value = ''; }
            var hv = document.getElementById('add-referred-by-value');
            if (hv) hv.value = '';
        }
        selectedRoomNumber = null;
        document.querySelectorAll('#add-modal .btn-submit').forEach(function(b) {
            b.disabled = false; b.style.opacity = ''; b.style.cursor = ''; b.title = '';
        });
    }
    if (id === 'renew-modal') {
        var rSuggestWrap = document.getElementById('renew-room-suggest-wrap');
        var rSuggestBox  = document.getElementById('renew-room-suggest');
        var rHintWrap    = document.getElementById('renew-room-hint-wrap');
        var rHint        = document.getElementById('renew-room-hint');
        if (rSuggestWrap) rSuggestWrap.style.display = 'none';
        if (rSuggestBox)  rSuggestBox.innerHTML = '';
        if (rHintWrap)    rHintWrap.style.display = 'none';
        if (rHint)        rHint.innerHTML = '';
        var rSt = document.getElementById('renew-stay-type');
        if (rSt) rSt.value = '';
    }
    if (id === 'edit-modal') {
        var w2 = document.getElementById('edit-room-hint-wrap');
        var h2 = document.getElementById('edit-room-hint');
        if (w2) w2.style.display = 'none';
        if (h2) h2.innerHTML = '';
        var ew = document.getElementById('edit-est-movein-wrap');
        var en = document.getElementById('edit-reservation-notes-wrap');
        if (ew) ew.style.display = 'none';
        if (en) en.style.display = 'none';
        document.querySelectorAll('#edit-modal .btn-submit').forEach(function(b) {
            b.disabled = false; b.style.opacity = ''; b.style.cursor = ''; b.title = '';
        });
        selectedRoomNumber = null;
        editOriginalRoomNumber = null;
        editOriginalStayType = null;
        var roomToggleReset = document.getElementById('edit-change-room-toggle');
        if (roomToggleReset) roomToggleReset.checked = false;
    }
}

function goAddStep(step) {
    if (step === 2) {
        var firstName = document.querySelector('#add-modal input[name="first_name"]');
        var lastName  = document.querySelector('#add-modal input[name="last_name"]');
        var email     = document.querySelector('#add-modal input[name="email"]');
        var contact   = document.getElementById('add-contact');
        if (!firstName.value.trim() || !lastName.value.trim() || !email.value.trim() || !contact.value.trim()) {
            firstName.reportValidity();
            lastName.reportValidity();
            email.reportValidity();
            contact.reportValidity();
            return;
        }
        if (!validateEmailField('add-email', 'add-email-error')) {
            document.getElementById('add-email').focus();
            return;
        }
        if (!validatePhoneField('add-contact', 'add-contact-error', true)) {
            document.getElementById('add-contact').focus();
            return;
        }
        var fnVal = firstName.value.trim();
        var lnVal = lastName.value.trim();
        var namePattern = /^[a-zA-Z\s\-'.]+$/;
        if (!namePattern.test(fnVal)) {
            firstName.classList.add('field-invalid');
            firstName.setCustomValidity('First name can only contain letters, spaces, hyphens, apostrophes, and periods.');
            firstName.reportValidity();
            firstName.setCustomValidity('');
            return;
        }
        if (!namePattern.test(lnVal)) {
            lastName.classList.add('field-invalid');
            lastName.setCustomValidity('Last name can only contain letters, spaces, hyphens, apostrophes, and periods.');
            lastName.reportValidity();
            lastName.setCustomValidity('');
            return;
        }
        firstName.classList.remove('field-invalid');
        lastName.classList.remove('field-invalid');
    }
    if (step === 1) {
        if (!validateMoveOutDate('add-move-in-date', 'add-move-out-date', 'add-moveout-error')) {
            return;
        }
    }
    addCurrentStep = step;
    document.getElementById('add-step-panel-1').style.display = step === 1 ? '' : 'none';
    document.getElementById('add-step-panel-2').style.display = step === 2 ? '' : 'none';
    document.getElementById('add-btn-next').style.display     = step === 1 ? '' : 'none';
    document.getElementById('add-btn-back').style.display     = step === 2 ? '' : 'none';
    document.getElementById('add-btn-submit').style.display   = step === 2 ? '' : 'none';

    var circle1 = document.getElementById('add-step-circle-1');
    var label1  = document.getElementById('add-step-label-1');
    var btn1    = document.getElementById('add-step-btn-1');
    var circle2 = document.getElementById('add-step-circle-2');
    var label2  = document.getElementById('add-step-label-2');
    var btn2    = document.getElementById('add-step-btn-2');

    if (step === 1) {
        btn1.style.borderBottomColor  = 'var(--bright-pink)';
        circle1.style.background      = 'var(--gradient-pink)';
        circle1.querySelector('span').style.color = '#fff';
        label1.style.color            = 'var(--bright-pink)';
        btn2.style.borderBottomColor  = 'var(--pink-100)';
        circle2.style.background      = 'var(--pink-100)';
        circle2.querySelector('span').style.color = 'var(--hot-pink)';
        label2.style.color            = 'var(--ink-muted)';
    } else {
        btn1.style.borderBottomColor  = '#8ce0bb';
        circle1.style.background      = '#8ce0bb';
        circle1.querySelector('span').style.color = '#fff';
        label1.style.color            = '#1f9d69';
        btn2.style.borderBottomColor  = 'var(--bright-pink)';
        circle2.style.background      = 'var(--gradient-pink)';
        circle2.querySelector('span').style.color = '#fff';
        label2.style.color            = 'var(--bright-pink)';
        if (document.getElementById('add-stay-type-select').value) {
            onAddStayTypeChange();
        }
    }
}

function toggleReservationFields(context) {
    if (context === 'add') {
        var mode = document.getElementById('add-mode-input').value;
        if (mode === 'reservation') {
            document.getElementById('add-movein-wrap').style.display = 'none';
            document.getElementById('add-est-movein-wrap').style.display = '';
            document.getElementById('add-reservation-notes-wrap').style.display = '';
        } else {
            document.getElementById('add-movein-wrap').style.display = '';
            document.getElementById('add-est-movein-wrap').style.display = 'none';
            document.getElementById('add-reservation-notes-wrap').style.display = 'none';
        }
    } else {
        var status = document.getElementById('edit-status').value;
        var show = status === 'reserved';
        document.getElementById('edit-est-movein-wrap').style.display = show ? '' : 'none';
        document.getElementById('edit-reservation-notes-wrap').style.display = show ? '' : 'none';
        document.getElementById('edit-movein-wrap').style.display = show ? 'none' : '';
    }
}

document.querySelectorAll('.modal-overlay').forEach(function(m) {
    m.addEventListener('click', function(e) {
        if (e.target !== m) return;
        if (m.id === 'pdf-preview-modal') { closePdfPreview(); return; }
        m.classList.remove('open');
    });
});

function updateStatusDot(select) {
    var dot = document.getElementById('edit-status-dot');
    if (!dot) return;
    var colors = { active:'#1f9d69', pending:'#c8960c', reserved:'#d4a000', move_out:'#E8175D', inactive:'#e04867' };
    dot.style.background = colors[select.value] || '#ccc';
}

function statusBadge(status) {
    var map = {
        active:   '<span class="badge badge-active">Active</span>',
        pending:  '<span class="badge badge-pending">Pending</span>',
        reserved: '<span class="badge badge-reserved">Reserved</span>',
        move_out: '<span class="badge badge-moveout">Move Out</span>',
        inactive: '<span class="badge badge-inactive">Inactive</span>',
    };
    return map[status] || ('<span class="badge badge-inactive">' + status + '</span>');
}

function tempBadge(isTemp) {
    return isTemp ? '<span class="badge badge-temp">Temp Pass</span>' : '';
}

function vacationBadge(isOnVacation) {
    return isOnVacation ? '<span class="badge" style="background:#FFF3CD; color:#856404; border:1px solid #FFEBAA;">Vacation</span>' : '';
}

function escapeHtml(str) {
    if (!str) return '\u2014';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
function fmtDate(d) {
    if (!d) return '\u2014';
    return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function normalizeContactDisplay(raw) {
    if (!raw) return '\u2014';
    var digits = raw.replace(/\D/g, '');
    if (digits.length === 12 && digits.substring(0, 2) === '63') {
        digits = '0' + digits.substring(2);
    }
    if (digits.length === 11 && digits.substring(0, 2) === '09') {
        return digits.substring(0, 4) + '-' + digits.substring(4, 7) + '-' + digits.substring(7, 11);
    }
    return raw;
}

function escapeJs(str) {
    return String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"');
}

function buildRows(list) {
    if (list.length === 0) {
        return '<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>';
    }
    return list.map(function(t) {
        var floorRoom = (t.floor && t.room_number) ? (t.floor + '-' + t.room_number) : (t.room_number || '\u2014');
        var insideDot = t.status === 'reserved' ? '' : (t.is_inside
    ? '<span title="Inside" style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#1f9d69;box-shadow:0 0 0 2.5px rgba(31,157,105,.22);animation:pulseGreen 2s infinite;flex-shrink:0;margin-left:.35rem;vertical-align:middle;"></span>'
    : '<span title="Outside" style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#d0d0dc;flex-shrink:0;margin-left:.35rem;vertical-align:middle;"></span>');
        var nameCell = '<div style="display:flex;flex-direction:column;align-items:center;gap:.2rem;">'
            + '<span style="display:inline-flex;align-items:center;gap:0;">' + t.first_name + ' ' + t.last_name + insideDot + '</span>'
            + (t.is_temp_password && t.status !== 'reserved' ? tempBadge(true) : '')
            + '</div>';
        var col4;
        if (t.status === 'reserved') {
            if (t.estimated_move_in_date) {
                if (isOverdue(t.estimated_move_in_date)) {
                    var ov       = daysOverdue(t.estimated_move_in_date);
                    var roomRef  = t.room_number ? 'Rm. ' + t.room_number : 'this room';
                    var tooltipText = roomRef + ' held ' + ov + ' day' + (ov !== 1 ? 's' : '') + ' past expected move-in. Click to reschedule.';
                    col4 = '<span class="overdue-date" onclick="openRescheduleModal(' + t.tenant_id + ', \'' + escapeJs(t.first_name + ' ' + t.last_name) + '\', \'' + t.estimated_move_in_date + '\')">'
                        + fmtDate(t.estimated_move_in_date)
                        + '<span class="overdue-date-tooltip">' + tooltipText + '</span>'
                        + '</span>';
                } else {
                    col4 = '<span style="font-size:.78rem;color:#9a6200;font-weight:600;">' + fmtDate(t.estimated_move_in_date) + '</span>';
                }
            } else {
                col4 = '\u2014';
            }
        } else {
            col4 = fmtDate(t.move_in_date);
        }
       var isReserved = t.status === 'reserved';
        var dataAttr = 'data-tenant=\'' + JSON.stringify(t).replace(/'/g, "&#39;") + '\'';
        var actions = ''
            + '<button class="act-btn" title="View" ' + dataAttr + ' onclick="viewTenant(JSON.parse(this.dataset.tenant))"><img src="{{ asset("icons/eye.png") }}" class="icon-sm"></button>'
            + '<button class="act-btn" title="Edit" ' + dataAttr + ' onclick="openEditModal(JSON.parse(this.dataset.tenant))"><img src="{{ asset("icons/edit.png") }}" class="icon-sm"></button>';

        if (isReserved) {
            actions += '<button class="act-btn" title="Tag as Moved In" data-tenant-id="' + t.tenant_id + '" data-tenant-name="' + escapeJs(t.first_name + ' ' + t.last_name) + '" onclick="openTagMovedInModal(' + t.tenant_id + ', \'' + escapeJs(t.first_name + ' ' + t.last_name) + '\')">'
                + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E8175D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-sm"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>'
                + '</button>';
        } else {
            actions += '<button class="act-btn" title="Reset Password" onclick="openResetModal(' + t.tenant_id + ', \'' + escapeJs(t.first_name + ' ' + t.last_name) + '\')"><img src="{{ asset("icons/reset.png") }}" class="icon-sm"></button>';
        }

        actions += '<button class="act-btn" title="Delete" onclick="openDeleteModal(' + t.tenant_id + ', \'' + escapeJs(t.first_name + ' ' + t.last_name) + '\')"><img src="{{ asset("icons/delete.png") }}" class="icon-sm"></button>';

        if (!isReserved) {
            actions += '<button class="act-btn" title="Bill Slip" ' + dataAttr + ' onclick="printBillSlip(JSON.parse(this.dataset.tenant))"><img src="{{ asset("icons/billing.png") }}" class="icon-sm" style="filter:brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);"></button>';
        }

        return '<tr id="admin-tenant-row-' + t.tenant_id + '">'
            + '<td>' + (t.account_id || '\u2014') + '</td>'
            + '<td id="admin-inside-cell-' + t.tenant_id + '">' + nameCell + '</td>'
            + '<td>' + floorRoom + '</td>'
            + '<td>' + col4 + '</td>'
            + '<td>' + (t.move_out_date ? fmtDate(t.move_out_date) : '\u2014') + '</td>'
            + '<td>' + normalizeContactDisplay(t.contact_number) + '</td>'
            + '<td>' + (t.is_on_vacation ? vacationBadge(true) : statusBadge(t.status)) + '</td>'
            + '<td><div class="action-group">' + actions + '</div></td></tr>';
    }).join('');
}

function buildPagination(group, currentPage, total) {
    var totalPages = Math.ceil(total / PER_PAGE);
    if (totalPages <= 1) return '';
    var html = '<button class="page-btn" onclick="goPage(\'' + group + '\',' + (currentPage - 1) + ')" ' + (currentPage === 1 ? 'disabled' : '') + '>\u2039</button>';
    for (var i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += '<button class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goPage(\'' + group + '\',' + i + ')">' + i + '</button>';
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += '<span style="color:var(--ink-muted);padding:0 .2rem">\u2026</span>';
        }
    }
    html += '<button class="page-btn" onclick="goPage(\'' + group + '\',' + (currentPage + 1) + ')" ' + (currentPage === totalPages ? 'disabled' : '') + '>\u203a</button>';
    return html;
}

function renderSection(group) {
    var data     = sectionData[group];
    var page     = sectionPages[group];
    var start    = (page - 1) * PER_PAGE;
    var pageData = data.slice(start, start + PER_PAGE);
    var total    = data.length;
    var from     = total === 0 ? 0 : start + 1;
    var to       = Math.min(start + PER_PAGE, total);
    document.getElementById('tbody-' + group).innerHTML      = buildRows(pageData);
    document.getElementById('showing-' + group).textContent  = total === 0 ? 'No entries' : 'Showing ' + from + ' to ' + to + ' of ' + total;
    document.getElementById('pagination-' + group).innerHTML = buildPagination(group, page, total);
    document.getElementById('pill-' + group).textContent     = total;
    if (group === 'reserved') {
        var overdueCount = data.filter(function(t) { return isOverdue(t.estimated_move_in_date); }).length;
        var overduePill  = document.getElementById('pill-reserved-overdue');
        if (overduePill) {
            if (overdueCount > 0) {
                overduePill.textContent  = overdueCount + ' overdue';
                overduePill.style.display = '';
            } else {
                overduePill.style.display = 'none';
            }
        }
    }
}

function goPage(group, p) {
    var totalPages = Math.ceil(sectionData[group].length / PER_PAGE);
    if (p < 1 || p > totalPages) return;
    sectionPages[group] = p;
    renderSection(group);
}

function toggleSection(group) {
    sectionState[group] = !sectionState[group];
    var body    = document.getElementById('body-' + group);
    var chevron = document.getElementById('chevron-' + group);
    if (sectionState[group]) {
        body.style.display = '';
        chevron.classList.add('open');
    } else {
        body.style.display = 'none';
        chevron.classList.remove('open');
    }
}

var statusFilter = '';

function enforceRoomNumberInput(input) {
    input.addEventListener('keydown', function(e) {
        var allowed = ['Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Tab','Home','End'];
        if (allowed.indexOf(e.key) !== -1) return;
        if (e.ctrlKey || e.metaKey) return;
        if (!/^\d$/.test(e.key)) e.preventDefault();
    });
    input.addEventListener('input', function() {
        var clean = this.value.replace(/\D/g, '');
        if (this.value !== clean) this.value = clean;
    });
    input.addEventListener('paste', function(e) {
        e.preventDefault();
        var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        var maxLen = parseInt(this.getAttribute('maxlength')) || 10;
        var combined = (this.value + pasted).substring(0, maxLen);
        this.value = combined;
        this.dispatchEvent(new Event('input'));
    });
}

function validateRoomNumberField(input) {
    var val = input.value.trim();
    if (val.length > 0 && val.length < 3) {
        input.classList.add('field-invalid');
        return false;
    }
    input.classList.remove('field-invalid');
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.room-number-input').forEach(function(inp) {
        enforceRoomNumberInput(inp);
        inp.addEventListener('blur', function() { validateRoomNumberField(this); });
        inp.addEventListener('input', function() { if (this.value.length >= 4) this.classList.remove('field-invalid'); });
    });
    var renewRoomInput = document.getElementById('renew-room');
    if (renewRoomInput && !renewRoomInput._enforced) {
        renewRoomInput._enforced = true;
        enforceRoomNumberInput(renewRoomInput);
        renewRoomInput.addEventListener('blur', function() { validateRoomNumberField(this); });
        renewRoomInput.addEventListener('input', function() { if (this.value.length >= 4) this.classList.remove('field-invalid'); });
    }
});
    function setStatusFilter(val) {
    statusFilter = val;
    applyFilters();
}

function applyFilters() {
    var q     = document.getElementById('search-input').value.toLowerCase();
    var sort  = document.getElementById('sort-select').value;
    var floor = document.getElementById('floor-filter').value;
    (function() {
        var sel = document.getElementById('floor-filter');
        var existingVals = Array.from(sel.options).map(function(o) { return o.value; });
        var allFloors = tenants
            .filter(function(t) { return t.floor; })
            .map(function(t) { return parseInt(t.floor, 10); })
            .filter(function(f) { return !isNaN(f); });
        var uniqueFloors = allFloors.filter(function(f, i, a) { return a.indexOf(f) === i; }).sort(function(a,b){return a-b;});
        uniqueFloors.forEach(function(f) {
            if (existingVals.indexOf(String(f)) === -1) {
                var opt = document.createElement('option');
                opt.value = f;
                opt.textContent = 'Floor ' + f;
                sel.appendChild(opt);
                existingVals.push(String(f));
            }
        });
    })();
    var base = tenants.filter(function(t) {
        if (t.status === 'inactive' || t.status === 'move_out') return false;
        var matchesSearch =
            (t.first_name + ' ' + t.last_name).toLowerCase().indexOf(q) !== -1 ||
            (t.account_id  || '').toLowerCase().indexOf(q) !== -1 ||
            (t.room_number || '').toLowerCase().indexOf(q) !== -1 ||
            (t.email || '').toLowerCase().indexOf(q) !== -1 ||
            (t.contact_number || '').toLowerCase().indexOf(q) !== -1;
        var matchesFloor = floor === '' || String(t.floor) === floor;
        return matchesSearch && matchesFloor;
    });
    function sortList(arr) {
        var a = arr.slice();
        if (sort === 'newest') a.sort(function(x,y){ return new Date(y.created_at)-new Date(x.created_at); });
        if (sort === 'oldest') a.sort(function(x,y){ return new Date(x.created_at)-new Date(y.created_at); });
        if (sort === 'name')   a.sort(function(x,y){ return x.first_name.localeCompare(y.first_name); });
        if (sort === 'room')   a.sort(function(x,y){ return (x.room_number||'').localeCompare(y.room_number||''); });
        if (sort === 'floor')  a.sort(function(x,y){ return parseInt(x.floor||0)-parseInt(y.floor||0); });
        return a;
    }
    sectionData.active = sortList(base.filter(function(t) {
        if (t.status !== 'active' && t.status !== 'pending') return false;
        if (statusFilter === '' || statusFilter === 'active' || statusFilter === 'pending') {
            return statusFilter === '' ? true : t.status === statusFilter;
        }
        if (statusFilter === 'vacation') {
            return t.is_on_vacation;
        }
        return false;
    }));
    sectionData.reserved = sortList(base.filter(function(t) {
        if (t.status !== 'reserved') return false;
        if (statusFilter === '' || statusFilter === 'reserved') return true;
        if (statusFilter === 'vacation') {
            return t.is_on_vacation;
        }
        return false;
    }));
    sectionPages.active   = 1;
    sectionPages.reserved = 1;
    renderSection('active');
    renderSection('reserved');
}

function initials(t) {
    return (t.first_name.charAt(0) + t.last_name.charAt(0)).toUpperCase();
}

function viewTenant(t) {
    currentTenant = t;
    var floorRoom = (t.floor && t.room_number) ? (t.floor + '-' + t.room_number) : (t.room_number || '\u2014');
    var reservationItems = '';
    if (t.status === 'reserved') {
        reservationItems += '<div class="tv-item"><div class="tv-item-label">Est. Move-In</div><div class="tv-item-value" style="color:#9a6200;">' + fmtDate(t.estimated_move_in_date) + '</div></div>';
        if (t.reservation_notes) {
            reservationItems += '<div class="tv-item full"><div class="tv-item-label">Reservation Notes</div><div class="tv-item-value">' + t.reservation_notes + '</div></div>';
        }
    }

    var photoHtml;
    if (t.tenant_photo) {
        photoHtml = '<div class="tenant-photo-wrap">'
            + '<img src="/storage/' + t.tenant_photo + '" class="tenant-photo-img" id="view-tenant-photo-img" alt="Tenant Photo">'
            + '<div class="tenant-photo-edit-btn" title="Change photo. Accepted: JPG, PNG. Max 4MB." onclick="triggerTenantPhotoUpload(' + t.tenant_id + ')">'
                + '<svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>'
            + '</div>'
            + '</div>';
    } else {
        photoHtml = '<div class="tenant-photo-placeholder" onclick="triggerTenantPhotoUpload(' + t.tenant_id + ')" title="Upload photo. Accepted: JPG, PNG. Max 4MB.">'
            + '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--bright-pink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>'
            + '<span>JPG or PNG<br>Max 4MB</span>'
            + '</div>';
    }

    document.getElementById('view-content').innerHTML =
        '<div class="tv-header">'
            + photoHtml
            + '<div class="tv-header-info">'
                + '<div class="tv-name">' + escapeHtml(t.first_name) + ' ' + escapeHtml(t.last_name) + '</div>'
                + '<div class="tv-account-id">' + (t.account_id || '\u2014') + '</div>'
                + '<div class="tv-header-badges">' + statusBadge(t.status) + (t.is_temp_password && t.status !== 'reserved' ? tempBadge(true) : '') + vacationBadge(t.is_on_vacation) + '</div>'
            + '</div>'
        + '</div>'
        + '<div class="modal-section-title">Personal Information</div>'
        + '<div class="tv-grid">'
            + '<div class="tv-item full"><div class="tv-item-label">Email</div><div class="tv-item-value">' + t.email + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Contact No.</div><div class="tv-item-value">' + normalizeContactDisplay(t.contact_number) + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Guardian Contact No.</div><div class="tv-item-value">' + normalizeContactDisplay(t.guardian_number) + '</div></div>'
            + '<div class="tv-item full"><div class="tv-item-label">Referred By</div><div class="tv-item-value">' + escapeHtml(t.referred_by) + '</div></div>'
        + '</div>'
        + '<div class="modal-section-title">Room &amp; Stay Details</div>'
        + '<div class="tv-grid">'
            + '<div class="tv-item"><div class="tv-item-label">Floor &amp; Room</div><div class="tv-item-value">' + floorRoom + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Stay Type</div><div class="tv-item-value">' + (t.stay_type || '\u2014') + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Move-In Date</div><div class="tv-item-value">' + fmtDate(t.move_in_date) + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Move-Out Date</div><div class="tv-item-value">' + renderMoveOutDateView(t.move_out_date) + '</div></div>'
            + reservationItems
        + '</div>'
        + '<div class="modal-section-title">Account Status</div>'
        + '<div class="tv-grid">'
            + (t.status !== 'reserved' ? '<div class="tv-item full"><div class="tv-item-label">Password Status</div><div class="tv-item-value">' + (t.is_temp_password ? 'Temporary - not yet changed by tenant' : 'Changed by tenant') + '</div></div>' : '')
            + (t.is_on_vacation ? '<div class="tv-item full"><div class="tv-item-label">Vacation Details</div><div class="tv-item-value">On Vacation' + (t.vacation_note ? ' (' + escapeHtml(t.vacation_note) + ')' : '') + '</div></div>' : '')
        + '</div>';
    var viewPhotoImg = document.getElementById('view-tenant-photo-img');
    if (viewPhotoImg) {
        viewPhotoImg.onclick = function() { openPhotoLightbox(viewPhotoImg.src); };
    }
    openModal('view-modal');
}

function switchToEdit() {
    if (currentTenant) {
        closeModal('view-modal');
        setTimeout(function() { openEditModal(currentTenant); }, 200);
    }
}

function lockEditRoomFields(locked) {
    var roomInput = document.getElementById('edit-room');
    var stayType  = document.getElementById('edit-stay-type');
    [roomInput, stayType].forEach(function(el) {
        if (!el) return;
        if (locked) {
            el.style.pointerEvents = 'none';
            el.style.opacity = '.65';
            el.style.cursor = 'default';
            el.style.background = '#f5f0f3';
        } else {
            el.style.pointerEvents = '';
            el.style.opacity = '';
            el.style.cursor = '';
            el.style.background = '';
        }
    });
}

function toggleEditRoomChange(checkboxEl) {
    var enabled     = checkboxEl.checked;
    var roomInput   = document.getElementById('edit-room');
    var stayTypeEl  = document.getElementById('edit-stay-type');
    var suggestWrap = document.getElementById('edit-room-suggest-wrap');
    var suggestBox  = document.getElementById('edit-room-suggest');
    var hintWrap    = document.getElementById('edit-room-hint-wrap');
    var hintBox     = document.getElementById('edit-room-hint');
    var roomError   = document.getElementById('edit-room-error');
    var roomSub     = document.getElementById('edit-room-toggle-sub');

    lockEditRoomFields(!enabled);

    if (enabled) {
        if (roomSub) {
            roomSub.textContent = editOriginalRoomNumber
                ? 'Reassigning from Rm. ' + editOriginalRoomNumber
                : 'Pick a room for this tenant';
        }
        if (stayTypeEl.value) onEditStayTypeChange();
        if (roomInput.value.trim()) roomInput.dispatchEvent(new Event('input'));
    } else {
        roomInput.value  = editOriginalRoomNumber || '';
        stayTypeEl.value = editOriginalStayType   || '';
        if (suggestWrap) suggestWrap.style.display = 'none';
        if (suggestBox)  suggestBox.innerHTML = '';
        if (hintWrap)    hintWrap.style.display = 'none';
        if (hintBox)     hintBox.innerHTML = '';
        if (roomError)   { roomError.style.display = 'none'; roomError.textContent = ''; }
        roomInput.classList.remove('field-invalid');
        selectedRoomNumber = null;
        if (roomSub) {
            roomSub.textContent = editOriginalRoomNumber
                ? 'Tenant stays in Rm. ' + editOriginalRoomNumber
                : 'No room currently assigned';
        }
        document.querySelectorAll('#edit-modal .btn-submit').forEach(function(b) {
            b.disabled = false; b.style.opacity = ''; b.style.cursor = ''; b.title = '';
        });
    }
}

function openEditModal(t) {
    currentTenant = t;
    document.querySelectorAll('#edit-modal .btn-submit').forEach(function(b) {
        b.disabled = false; b.style.opacity = ''; b.style.cursor = ''; b.title = '';
    });
    var ew = document.getElementById('edit-room-hint-wrap');
    var eh = document.getElementById('edit-room-hint');
    if (ew) ew.style.display = 'none';
    if (eh) eh.innerHTML = '';

    var old = {
        first_name:             '{{ old("first_name") }}',
        last_name:              '{{ old("last_name") }}',
        email:                  '{{ old("email") }}',
        contact_number:         '{{ old("contact_number") }}',
        guardian_number:        '{{ old("guardian_number") }}',
        room_number:            '{{ old("room_number") }}',
        floor:                  '{{ old("floor") }}',
        stay_type:              '{{ old("stay_type") }}',
        move_in_date:           '{{ old("move_in_date") }}',
        move_out_date:          '{{ old("move_out_date") }}',
        estimated_move_in_date: '{{ old("estimated_move_in_date") }}',
        reservation_notes:      '{{ old("reservation_notes") }}',
        referred_by:            '{{ old("referred_by") }}',
        status:                 '{{ old("status") }}',
    };
    var hasOld = {{ session('edit_tenant_id') ? 'true' : 'false' }} && String(t.tenant_id) === '{{ session("edit_tenant_id", "") }}';
    var hasRoomServerError = hasOld && {{ $errors->has('room_number') ? 'true' : 'false' }};

    document.getElementById('edit-form').action             = '/tenants/' + t.tenant_id;
    document.getElementById('edit-first-name').value        = hasOld && old.first_name             ? old.first_name             : (t.first_name || '');
    document.getElementById('edit-last-name').value         = hasOld && old.last_name              ? old.last_name              : (t.last_name  || '');
    document.getElementById('edit-email').value             = hasOld && old.email                  ? old.email                  : (t.email      || '');
    document.getElementById('edit-room').value              = hasOld && old.room_number            ? old.room_number            : (t.room_number || '');
    document.getElementById('edit-floor').value             = hasOld && old.floor                  ? old.floor                  : (t.floor      || '');
    document.getElementById('edit-stay-type').value         = hasOld && old.stay_type              ? old.stay_type              : (t.stay_type  || '');
    document.getElementById('edit-date').value              = hasOld && old.move_in_date           ? old.move_in_date           : (t.move_in_date  || '');
    document.getElementById('edit-moveout').value           = hasOld && old.move_out_date          ? old.move_out_date          : (t.move_out_date || '');
    document.getElementById('edit-contact').value           = hasOld && old.contact_number         ? old.contact_number         : (t.contact_number || '');
    document.getElementById('edit-guardian').value          = hasOld && old.guardian_number        ? old.guardian_number        : (t.guardian_number || '');
    document.getElementById('edit-estimated-move-in').value = hasOld && old.estimated_move_in_date ? old.estimated_move_in_date : (t.estimated_move_in_date || '');
    document.getElementById('edit-reservation-notes').value = hasOld && old.reservation_notes      ? old.reservation_notes      : (t.reservation_notes || '');
    document.getElementById('edit-status').value = hasOld && old.status ? old.status : (t.status || 'pending');
    var reservedOption = document.getElementById('edit-status-reserved-option');
    if (reservedOption) {
        var hasCredentials = !!(t.account_id);
        reservedOption.disabled = hasCredentials;
        reservedOption.title = hasCredentials ? 'Cannot revert to Reserved: this tenant already has login credentials.' : '';
        reservedOption.textContent = hasCredentials ? 'Reserved (unavailable)' : 'Reserved';
    }
    var editStatusSel = document.getElementById('edit-status');
    editStatusSel.onchange = function() {
        updateStatusDot(this);
        toggleReservationFields('edit');
        var noAccount = !currentTenant || !currentTenant.account_id;
        var warn = document.getElementById('edit-pending-reserved-warn');
        if (warn) warn.style.display = (this.value === 'pending' && noAccount) ? '' : 'none';
    };
    restoreReferredBy('edit', hasOld && old.referred_by ? old.referred_by : (t.referred_by || ''));

    var vacationCb   = document.getElementById('edit-is-on-vacation');
    var vacationNote = document.getElementById('edit-vacation-note');
    var vacationWrap = document.getElementById('edit-vacation-note-wrap');
    if (vacationCb) {
        vacationCb.checked = !!t.is_on_vacation;
        vacationNote.value = t.vacation_note || '';
        vacationWrap.style.display = t.is_on_vacation ? '' : 'none';
    }

    updateStatusDot(document.getElementById('edit-status'));
    toggleReservationFields('edit');
    attachPhoneFormatter('edit-contact', 'edit-contact-error', true);
    attachPhoneFormatter('edit-guardian', 'edit-guardian-error', false);
    checkMoveoutWarning();
    var editMoveoutEl = document.getElementById('edit-moveout');
    if (editMoveoutEl && !editMoveoutEl._moveoutWarningAttached) {
        editMoveoutEl._moveoutWarningAttached = true;
        editMoveoutEl.addEventListener('change', checkMoveoutWarning);
        editMoveoutEl.addEventListener('input',  checkMoveoutWarning);
    }
    openModal('edit-modal');

    var editSuggestWrap = document.getElementById('edit-room-suggest-wrap');
    var editSuggestBox  = document.getElementById('edit-room-suggest');
    if (editSuggestWrap) editSuggestWrap.style.display = 'none';
    if (editSuggestBox) editSuggestBox.innerHTML = '';

    selectedRoomNumber     = null;
    editOriginalRoomNumber = document.getElementById('edit-room').value || null;
    editOriginalStayType   = document.getElementById('edit-stay-type').value || null;

    var roomToggle  = document.getElementById('edit-change-room-toggle');
    var roomSub     = document.getElementById('edit-room-toggle-sub');
    var roomInputEl = document.getElementById('edit-room');
    var stayTypeEl  = document.getElementById('edit-stay-type');

    if (roomToggle) roomToggle.checked = false;
    lockEditRoomFields(true);
    if (roomSub) {
        roomSub.textContent = editOriginalRoomNumber
            ? 'Tenant stays in Rm. ' + editOriginalRoomNumber
            : 'No room currently assigned';
    }

    if (editOriginalRoomNumber && window.getRoomsCache) {
        window.getRoomsCache(function(rooms) {
            var actualRoom = rooms.find(function(r) { return r.room_number.toLowerCase() === editOriginalRoomNumber.toLowerCase(); });
            if (actualRoom && actualRoom.stay_type && roomToggle && !roomToggle.checked) {
                stayTypeEl.value     = actualRoom.stay_type;
                editOriginalStayType = actualRoom.stay_type;
            }
        });
    }

    if (hasRoomServerError && roomToggle) {
        roomToggle.checked = true;
        lockEditRoomFields(false);
        if (roomSub) {
            roomSub.textContent = editOriginalRoomNumber
                ? 'Reassigning from Rm. ' + editOriginalRoomNumber
                : 'Pick a room for this tenant';
        }
        if (stayTypeEl.value) onEditStayTypeChange();
        if (roomInputEl.value.trim()) roomInputEl.dispatchEvent(new Event('input'));
    }

    var editEmail = document.getElementById('edit-email');
    var editEmailError = document.getElementById('edit-email-error');
    if (editEmail) editEmail.classList.remove('field-invalid');
    if (editEmailError) { editEmailError.style.display = 'none'; editEmailError.textContent = ''; }
    var editContact = document.getElementById('edit-contact');
    var editContactError = document.getElementById('edit-contact-error');
    if (editContact) editContact.classList.remove('field-invalid');
    if (editContactError) { editContactError.style.display = 'none'; editContactError.textContent = ''; }
    var editGuardian = document.getElementById('edit-guardian');
    var editGuardianError = document.getElementById('edit-guardian-error');
    if (editGuardian) editGuardian.classList.remove('field-invalid');
    if (editGuardianError) { editGuardianError.style.display = 'none'; editGuardianError.textContent = ''; }
    var editMoveout = document.getElementById('edit-moveout');
    var editMoveoutError = document.getElementById('edit-moveout-error');
    if (editMoveout) editMoveout.classList.remove('field-invalid');
    if (editMoveoutError) { editMoveoutError.style.display = 'none'; editMoveoutError.textContent = ''; }
    var editEstError = document.getElementById('edit-estimated-move-in-error');
    if (editEstError) { editEstError.style.display = 'none'; editEstError.textContent = ''; }
    var editEst = document.getElementById('edit-estimated-move-in');
    if (editEst) editEst.classList.remove('field-invalid');
}

function openTagMovedInModal(id, name) {
    document.getElementById('tag-movedin-name').textContent = name;
    document.getElementById('tag-movedin-form').action = '/tenants/' + id + '/tag-moved-in';
    openModal('tag-movedin-modal');
}

function openRescheduleModal(id, name, currentDate) {
    document.getElementById('reschedule-name').textContent = name;
    document.getElementById('reschedule-form').action = '/tenants/' + id + '/reschedule';
    document.getElementById('reschedule-date').value = currentDate || '';
    openModal('reschedule-modal');
}

function isOverdue(dateStr) {
    if (!dateStr) return false;
    var today = new Date();
    today.setHours(0,0,0,0);
    var est = new Date(dateStr + 'T00:00:00');
    return est < today;
}

function daysOverdue(dateStr) {
    var today = new Date();
    today.setHours(0,0,0,0);
    var est = new Date(dateStr + 'T00:00:00');
    var diff = Math.floor((today - est) / 86400000);
    return diff;
}

function openResetModal(id, name) {
    document.getElementById('reset-name').textContent = name;
    document.getElementById('reset-form').action = '/tenants/' + id + '/reset-password';
    openModal('reset-modal');
}

function openDeleteModal(id, name) {
    document.getElementById('delete-name').textContent = name;
    document.getElementById('delete-form').action = '/tenants/' + id;
    openModal('delete-modal');
}

function exportTenants() {
    var data = sectionData.active.concat(sectionData.reserved);
    var rows = [['Account ID','First Name','Last Name','Email','Room','Floor','Move-In Date','Move-Out Date','Contact','Status']];
    data.forEach(function(t) {
        rows.push([t.account_id||'',t.first_name,t.last_name,t.email,t.room_number||'',t.floor||'',t.move_in_date||'',t.move_out_date||'',t.contact_number||'',t.status]);
    });
    var csv = rows.map(function(r) { return r.map(function(v) { return '"' + String(v).replace(/"/g,'""') + '"'; }).join(','); }).join('\n');
    var blob = new Blob([csv], { type: 'text/csv' });
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'dormease-tenants.csv';
    a.click();
}

function exportTenantsPDF() {
    var data = sectionData.active.concat(sectionData.reserved);
    var win = window.open('', '_blank');
    var rows = data.map(function(t) {
        return '<tr><td>' + (t.account_id||'') + '</td><td>' + t.first_name + ' ' + t.last_name + '</td><td>' + (t.floor && t.room_number ? t.floor+'-'+t.room_number : (t.room_number||'')) + '</td><td>' + fmtDate(t.move_in_date) + '</td><td>' + (t.move_out_date ? fmtDate(t.move_out_date) : '\u2014') + '</td><td>' + (t.contact_number||'') + '</td><td>' + t.status + '</td></tr>';
    }).join('');
    win.document.write('<!DOCTYPE html><html><head><title>Tenants</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec}</style></head><body><h2>Sanctissimo Rosario Ladies Dormitory</h2><p>Tenant List as of ' + new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'}) + '</p><table><thead><tr><th>Account ID</th><th>Name</th><th>Floor &amp; Room</th><th>Move-In</th><th>Move-Out</th><th>Contact</th><th>Status</th></tr></thead><tbody>' + rows + '</tbody></table></body></html>');
    win.document.close();
    win.print();
}

function copyText(elementId, btn) {
    var text = document.getElementById(elementId).textContent;
    navigator.clipboard.writeText(text).then(function() {
        btn.textContent = 'Copied';
        setTimeout(function() { btn.textContent = 'Copy'; }, 2000);
    });
}

@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('edit_tenant_id'))
            var t = tenants.find(function(x) { return x.tenant_id == {{ session('edit_tenant_id') }}; });
            if (t) { openEditModal(t); }
        @else
            openModal('add-modal');
        @endif
    });
@endif

@if(session('success') && !session('new_account_id') && !session('reset_account_id'))
    document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });
@endif

var roomsData = [];

function syncReferredSelect(selectId, hiddenId) {
    document.getElementById(hiddenId).value = document.getElementById(selectId).value;
}

function handleReferredSource(ctx) {
    var source = document.getElementById(ctx + '-referred-source').value;
    var ids = ['current-select', 'former-select', 'other-input'];
    ids.forEach(function(s) {
        document.getElementById(ctx + '-referred-' + s).style.display = 'none';
    });
    document.getElementById(ctx + '-referred-by-value').value = '';
    if (source === 'current') {
        var sel = document.getElementById(ctx + '-referred-current-select');
        sel.style.display = '';
        populateReferredSelect(sel, 'current');
    } else if (source === 'former') {
        var sel2 = document.getElementById(ctx + '-referred-former-select');
        sel2.style.display = '';
        populateReferredSelect(sel2, 'former');
    } else if (source === 'other') {
        document.getElementById(ctx + '-referred-other-input').style.display = '';
    }
}

function populateReferredSelect(selectEl, type) {
    var existing = Array.from(selectEl.options).map(function(o) { return o.value; });
    if (existing.length > 1) return;
    if (type === 'current') {
        tenants.filter(function(t) {
            return t.status === 'active' || t.status === 'pending' || t.status === 'reserved';
        }).sort(function(a, b) {
            return (a.first_name + ' ' + a.last_name).localeCompare(b.first_name + ' ' + b.last_name);
        }).forEach(function(t) {
            var opt = document.createElement('option');
            var label = t.first_name + ' ' + t.last_name + (t.room_number ? ' (Rm.' + t.room_number + ')' : '');
            opt.value = label;
            opt.textContent = label;
            selectEl.appendChild(opt);
        });
    } else {
        var formerSource = (typeof deletedTenantArchive !== 'undefined' ? deletedTenantArchive : [])
            .concat(typeof inactiveTenantArchive !== 'undefined' ? inactiveTenantArchive : [])
            .concat(typeof moveoutTenantArchive  !== 'undefined' ? moveoutTenantArchive  : []);
        formerSource.sort(function(a, b) {
            return (a.first_name + ' ' + a.last_name).localeCompare(b.first_name + ' ' + b.last_name);
        }).forEach(function(t) {
            var opt = document.createElement('option');
            var label = t.first_name + ' ' + t.last_name + (t.room_number ? ' (Rm.' + t.room_number + ', former)' : ' (former)');
            opt.value = label;
            opt.textContent = label;
            selectEl.appendChild(opt);
        });
    }
}

function restoreReferredBy(ctx, val) {
    var sourceEl  = document.getElementById(ctx + '-referred-source');
    var hiddenEl  = document.getElementById(ctx + '-referred-by-value');
    var curSel    = document.getElementById(ctx + '-referred-current-select');
    var frmSel    = document.getElementById(ctx + '-referred-former-select');
    var otherInp  = document.getElementById(ctx + '-referred-other-input');
    hiddenEl.value = val;
    curSel.style.display   = 'none';
    frmSel.style.display   = 'none';
    otherInp.style.display = 'none';
    if (!val) { sourceEl.value = ''; return; }
    var isCurrent = tenants.some(function(t) {
        var label = t.first_name + ' ' + t.last_name + (t.room_number ? ' (Rm.' + t.room_number + ')' : '');
        return label === val;
    });
    var isFormer = val.indexOf('(former)') !== -1;
    if (isCurrent) {
        sourceEl.value = 'current';
        curSel.style.display = '';
        populateReferredSelect(curSel, 'current');
        curSel.value = val;
    } else if (isFormer) {
        sourceEl.value = 'former';
        frmSel.style.display = '';
        populateReferredSelect(frmSel, 'former');
        frmSel.value = val;
    } else {
        sourceEl.value = 'other';
        otherInp.style.display = '';
        otherInp.value = val;
    }
}

var roomsFloorFilter = '';
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function openRoomsDrawer() {
    document.getElementById('rooms-drawer').classList.add('open');
    document.getElementById('rooms-backdrop').classList.add('open');
    document.getElementById('rooms-search').value = '';
    fetchRooms();
}

function closeRoomsDrawer() {
    document.getElementById('rooms-drawer').classList.remove('open');
    document.getElementById('rooms-backdrop').classList.remove('open');
}

var RFLOOR_MAX_BTNS = 5;
var _floorMoreOpen = false;

function toggleFloorMoreDropdown() {
    _floorMoreOpen = !_floorMoreOpen;
    var menu    = document.getElementById('rfloor-more-menu');
    var chevron = document.getElementById('rfloor-more-chevron');
    menu.style.display = _floorMoreOpen ? 'block' : 'none';
    chevron.style.transform = _floorMoreOpen ? 'rotate(180deg)' : '';
}

function closeFloorMoreDropdown() {
    _floorMoreOpen = false;
    var menu    = document.getElementById('rfloor-more-menu');
    var chevron = document.getElementById('rfloor-more-chevron');
    if (menu)    menu.style.display = 'none';
    if (chevron) chevron.style.transform = '';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#rfloor-more-wrap')) closeFloorMoreDropdown();
});

function rebuildFloorFilters(floors) {
    var btnGroup  = document.getElementById('rfloor-btn-group');
    var moreWrap  = document.getElementById('rfloor-more-wrap');
    var moreMenu  = document.getElementById('rfloor-more-menu');
    if (!btnGroup || !moreWrap || !moreMenu) return;

    btnGroup.innerHTML = '';
    moreMenu.innerHTML = '';
    closeFloorMoreDropdown();

    var visible = floors.slice(0, RFLOOR_MAX_BTNS);
    var overflow = floors.slice(RFLOOR_MAX_BTNS);

    visible.forEach(function(f) {
        var btn = document.createElement('button');
        btn.className = 'page-btn';
        btn.id = 'rfloor-' + f;
        btn.textContent = 'Floor ' + f;
        btn.onclick = function() { setRoomFloor(f); };
        btnGroup.appendChild(btn);
    });

    if (overflow.length > 0) {
        moreWrap.style.display = '';
        overflow.forEach(function(f) {
            var item = document.createElement('button');
            item.className = 'addf-item';
            item.id = 'rfloor-' + f;
            item.textContent = 'Floor ' + f;
            item.onclick = function() { setRoomFloor(f); closeFloorMoreDropdown(); };
            moreMenu.appendChild(item);
        });
    } else {
        moreWrap.style.display = 'none';
    }

    syncFloorActiveState();
}

function syncFloorActiveState() {
    document.querySelectorAll('[id^="rfloor-"]').forEach(function(el) {
        if (el.id === 'rfloor-all') return;
        if (el.id === 'rfloor-more-btn') return;
        if (el.tagName === 'DIV') return;
        var f = el.id.replace('rfloor-', '');
        var isActive = (roomsFloorFilter !== '' && String(roomsFloorFilter) === String(f));
        el.classList.toggle('active', isActive);
    });
    var allBtn = document.getElementById('rfloor-all');
    if (allBtn) allBtn.classList.toggle('active', roomsFloorFilter === '');

    var moreBtn = document.getElementById('rfloor-more-btn');
    if (moreBtn) {
        var moreMenu = document.getElementById('rfloor-more-menu');
        var overflowActive = moreMenu && moreMenu.querySelector('.active') !== null;
        moreBtn.classList.toggle('active', overflowActive);
    }
}

function setRoomFloor(floor) {
    roomsFloorFilter = floor;
    syncFloorActiveState();
    closeFloorMoreDropdown();
    renderRooms();
}

async function fetchRooms() {
    try {
        const res = await fetch('/rooms', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
        roomsData = await res.json();
        var floors = [...new Set(roomsData.map(r => r.floor))].sort(function(a,b){return a-b;});
        rebuildFloorFilters(floors);
        renderRooms();
    } catch {
        document.getElementById('rooms-list').innerHTML = '<div class="tad-empty">Failed to load rooms.</div>';
    }
}

var roomsStatsOpen = false;

function toggleRoomsStats() {
    roomsStatsOpen = !roomsStatsOpen;
    var panel   = document.getElementById('rooms-stats-panel');
    var chevron = document.getElementById('rooms-stats-chevron');
    if (roomsStatsOpen) {
        panel.style.display = 'grid';
        chevron.style.transform = 'rotate(180deg)';
    } else {
        panel.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
    }
}

function updateRoomsStats(data) {
    var totalRooms  = data.length;
    var totalCap    = data.reduce(function(s, r) { return s + r.capacity; }, 0);
    var totalOcc    = data.reduce(function(s, r) { return s + r.occupancy; }, 0);
    var totalVacant = totalCap - totalOcc;
    var pct         = totalCap > 0 ? Math.round((totalOcc / totalCap) * 100) : 0;
    var pill = document.getElementById('rooms-stats-summary-pill');
    if (pill) pill.textContent = totalOcc + '/' + totalCap + ' slots \u00b7 ' + pct + '%';
    var el = document.getElementById('rstat-total');
    if (el) el.textContent = totalRooms;
    el = document.getElementById('rstat-occupied');
    if (el) el.textContent = totalOcc;
    el = document.getElementById('rstat-pct');
    if (el) { el.textContent = pct + '%'; el.style.color = pct >= 100 ? '#e04867' : pct >= 75 ? '#c8960c' : '#E8175D'; }
    el = document.getElementById('rstat-vacant');
    if (el) { el.textContent = totalVacant; el.style.color = totalVacant === 0 ? '#e04867' : '#1f9d69'; }
    el = document.getElementById('rstat-cap');
    if (el) el.textContent = 'of ' + totalCap + ' slots';
}

function renderRooms() {
    const q    = document.getElementById('rooms-search').value.toLowerCase();
    const list = document.getElementById('rooms-list');

    let data = roomsData.filter(r => {
        const matchFloor  = roomsFloorFilter === '' || String(r.floor) === String(roomsFloorFilter);
        const matchSearch = !q || r.room_number.includes(q) || String(r.floor).includes(q);
        return matchFloor && matchSearch;
    });

    const totalCapacity  = data.reduce((s, r) => s + r.capacity, 0);
    const totalOccupancy = data.reduce((s, r) => s + r.occupancy, 0);

    document.getElementById('rooms-count-label').textContent = data.length + ' room' + (data.length !== 1 ? 's' : '');
    document.getElementById('rooms-summary').textContent     = totalOccupancy + ' / ' + totalCapacity + ' occupied';
    updateRoomsStats(data);

    if (!data.length) {
        list.innerHTML = '<div class="tad-empty">No rooms found.</div>';
        return;
    }

    const floors = [...new Set(data.map(r => r.floor))].sort();

    list.innerHTML = floors.map(floor => {
        const floorRooms     = data.filter(r => r.floor === floor);
        const floorOccupied  = floorRooms.reduce((s, r) => s + r.occupancy, 0);
        const floorCapacity  = floorRooms.reduce((s, r) => s + r.capacity, 0);
        const floorAvailable = floorRooms.filter(r => r.is_active && (r.capacity - r.occupancy) > 0).length;
        const floorTotal     = floorRooms.length;

        const cards = floorRooms.map(r => {
            const isFull  = r.occupancy >= r.capacity;
            const isEmpty = r.occupancy === 0;
            const pct     = r.capacity > 0 ? Math.round((r.occupancy / r.capacity) * 100) : 0;

            const occupancyColor  = isFull ? '#e04867' : pct >= 75 ? '#f0a500' : pct >= 40 ? '#c8960c' : '#1f9d69';
            const occupancyBg     = isFull ? '#fff0f2' : pct >= 75 ? '#fffbf0' : pct >= 40 ? '#fffdf0' : '#f0faf6';
            const occupancyBorder = isFull ? '#ffc2ce' : pct >= 75 ? '#ffd88a' : pct >= 40 ? '#f0e080' : '#8ce0bb';

            const reservedCount = r.reserved_occupancy || 0;
            const activeCount   = r.occupancy - reservedCount;

            const slotsAvailable = r.capacity - r.occupancy;
            const availBg        = !r.is_active ? '#f5f5f5' : isFull ? '#fff0f2' : '#f0faf6';
            const availBorder    = !r.is_active ? '#d0d0d0' : isFull ? '#ffc2ce' : '#8ce0bb';
            const availColor     = !r.is_active ? '#999'    : isFull ? '#c0163a' : '#1a5a38';
            const availText      = !r.is_active ? 'Closed'  : isFull ? '0 of ' + r.capacity + ' available' : slotsAvailable + ' of ' + r.capacity + ' available';

            var personIcons = Array.from({ length: r.capacity }, (_, i) => {
                let iconFilter, titleText;
                if (i < activeCount) {
                    iconFilter = isFull
                        ? 'brightness(0) saturate(100%) invert(35%) sepia(80%) saturate(800%) hue-rotate(315deg) brightness(90%)'
                        : pct >= 75
                            ? 'brightness(0) saturate(100%) invert(60%) sepia(60%) saturate(600%) hue-rotate(5deg) brightness(95%)'
                            : 'brightness(0) saturate(100%) invert(45%) sepia(60%) saturate(500%) hue-rotate(115deg) brightness(85%)';
                    titleText = 'Occupied';
                } else if (i < activeCount + reservedCount) {
                    iconFilter = 'brightness(0) saturate(100%) invert(55%) sepia(80%) saturate(600%) hue-rotate(5deg) brightness(105%)';
                    titleText = 'Reserved';
                } else {
                    iconFilter = 'brightness(0) saturate(100%) invert(85%) sepia(5%) saturate(200%) hue-rotate(0deg) brightness(105%)';
                    titleText = 'Vacant';
                }
                return `<img src="{{ asset('icons/person.png') }}" style="width:18px;height:18px;object-fit:contain;filter:${iconFilter};transition:filter .2s;flex-shrink:0;" title="${titleText}">`;
            }).join('');

            const statusDot = r.is_active
                ? `<span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#1f9d69;box-shadow:0 0 0 2px #e8faf5;flex-shrink:0;"></span>`
                : `<span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#e04867;box-shadow:0 0 0 2px #fff0f0;flex-shrink:0;"></span>`;

            const statusLabel = r.is_active
                ? `<span style="font-size:.67rem;font-weight:700;color:#1f9d69;letter-spacing:.03em;">Active</span>`
                : `<span style="font-size:.67rem;font-weight:700;color:#e04867;letter-spacing:.03em;">Closed</span>`;

            const vacantCount = r.capacity - r.occupancy;
            const vacantLabel = isEmpty
                ? `<span style="font-size:.68rem;font-weight:600;color:#1f9d69;">All vacant</span>`
                : isFull
                    ? `<span style="font-size:.68rem;font-weight:700;color:#e04867;">Full</span>`
                    : `<span style="font-size:.68rem;font-weight:600;color:var(--ink-muted);">${vacantCount} slot${vacantCount !== 1 ? 's' : ''} free</span>`;

            return `<div onclick="openViewRoomModal(this)" data-room='${JSON.stringify(r).replace(/'/g, "&#39;")}' style="background:var(--white);border:1.5px solid var(--pink-100);border-radius:16px;padding:1rem 1.05rem .85rem;transition:border-color .22s,box-shadow .22s;display:flex;flex-direction:column;gap:.7rem;position:relative;overflow:hidden;cursor:pointer;" onmouseover="this.style.borderColor='var(--bright-pink)';this.style.boxShadow='0 6px 24px rgba(232,23,93,.10)'" onmouseout="this.style.borderColor='var(--pink-100)';this.style.boxShadow='none'">
                <div style="position:absolute;top:0;left:0;right:0;height:3px;background:${isFull ? 'linear-gradient(90deg,#e04867,#ff6b8a)' : pct >= 75 ? 'linear-gradient(90deg,#f0a500,#ffd060)' : isEmpty ? 'linear-gradient(90deg,#d0d0d8,#e8e8f0)' : 'linear-gradient(90deg,#1f9d69,#4ecb8d)'};border-radius:16px 16px 0 0;"></div>
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;padding-top:.15rem;">
                    <div style="display:flex;flex-direction:column;gap:.2rem;">
                        <div style="display:flex;align-items:center;gap:.45rem;">
                            <span style="font-size:1rem;font-weight:900;color:var(--ink);letter-spacing:-.02em;">Rm.${r.room_number}</span>
                            <div style="display:flex;align-items:center;gap:.25rem;">${statusDot}${statusLabel}</div>
                        </div>
                        <span style="font-size:.7rem;font-weight:600;color:var(--ink-muted);letter-spacing:.02em;">${r.stay_type}</span>
                    </div>
                    <div style="display:flex;gap:.25rem;flex-shrink:0;">
                       <button class="act-btn" title="Edit" onclick="event.stopPropagation();openEditRoomModal(JSON.parse(this.closest('[data-room]').dataset.room))" style="width:28px;height:28px;border-radius:8px;"><img src="{{ asset('icons/edit.png') }}" class="icon-sm"></button>
                        <button class="act-btn" title="Delete" onclick="event.stopPropagation();openDeleteRoomModal(${r.id}, 'Rm.${r.room_number}')" style="width:28px;height:28px;border-radius:8px;"><img src="{{ asset('icons/delete.png') }}" class="icon-sm"></button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:.3rem;min-height:22px;">${personIcons}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:.45rem .6rem;border-radius:9px;background:${occupancyBg};border:1px solid ${occupancyBorder};">
                    <div style="display:flex;align-items:baseline;gap:.3rem;">
                        <span style="font-size:1.05rem;font-weight:800;color:${occupancyColor};line-height:1;">${r.occupancy}</span>
                        <span style="font-size:.7rem;font-weight:600;color:${occupancyColor};opacity:.75;">/ ${r.capacity} occupied</span>
                    </div>
                    ${vacantLabel}
                </div>
                <div style="display:flex;align-items:center;gap:.45rem;padding:.35rem .6rem;border-radius:8px;background:${availBg};border:1px solid ${availBorder};">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="${availColor}" stroke-width="2.5" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span style="font-size:.7rem;font-weight:700;color:${availColor};">${availText}</span>
                </div>
            </div>`;
        }).join('');

        const floorPct        = floorCapacity > 0 ? Math.round((floorOccupied / floorCapacity) * 100) : 0;
        const floorAvailColor = floorAvailable === 0 ? '#c0163a' : floorAvailable === floorTotal ? '#1a5a38' : '#7a5000';
        const floorAvailBg    = floorAvailable === 0 ? '#fff0f2' : floorAvailable === floorTotal ? '#f0faf6' : '#fffbf0';
        const floorAvailBorder= floorAvailable === 0 ? '#ffb3c0' : floorAvailable === floorTotal ? '#8ce0bb' : '#f0c040';

        return `<div style="margin-bottom:.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.65rem;padding-top:.1rem;flex-wrap:wrap;gap:.4rem;">
                <div style="display:flex;align-items:center;gap:.6rem;">
                    <span style="display:inline-block;width:3px;height:14px;background:var(--gradient-pink);border-radius:2px;flex-shrink:0;"></span>
                    <span style="font-size:.72rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.09em;">Floor ${floor}</span>
                </div>
                <div style="display:flex;align-items:center;gap:.45rem;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:.35rem;">
                        <span style="font-size:.68rem;font-weight:800;padding:.18rem .55rem;border-radius:99px;letter-spacing:.02em;background:${floorPct >= 100 ? '#fff0f2' : floorPct >= 75 ? '#fffbf0' : floorPct === 0 ? '#f0faf6' : '#fce8f1'};color:${floorPct >= 100 ? '#e04867' : floorPct >= 75 ? '#c8960c' : floorPct === 0 ? '#1f9d69' : '#E8175D'};border:1px solid ${floorPct >= 100 ? '#ffc2ce' : floorPct >= 75 ? '#ffd88a' : floorPct === 0 ? '#8ce0bb' : '#f4b8d0'};">${floorOccupied}/${floorCapacity} occupied</span>
                        <span style="font-size:.67rem;font-weight:700;color:var(--ink-muted);">${floorPct}%</span>
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.18rem .55rem;border-radius:99px;background:${floorAvailBg};border:1px solid ${floorAvailBorder};">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="${floorAvailColor}" stroke-width="2.8" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span style="font-size:.67rem;font-weight:800;color:${floorAvailColor};">${floorAvailable} of ${floorTotal} rooms available</span>
                    </span>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;">${cards}</div>
        </div>`;
    }).join('');
}

function syncRoomType(capacityId, stayTypeId) {
    var cap = parseInt(document.getElementById(capacityId).value, 10);
    var sel = document.getElementById(stayTypeId);
    if (!sel || isNaN(cap)) return;
    sel.value = cap === 1 ? 'Solo Room' : 'Shared Room';
    sel.classList.add('auto-updated');
    setTimeout(function() { sel.classList.remove('auto-updated'); }, 700);
}

document.addEventListener('DOMContentLoaded', function() {
    var arCap = document.getElementById('ar-capacity');
    if (arCap) {
        enforceRoomNumberInput(arCap);
        arCap.addEventListener('input',  function() { syncRoomType('ar-capacity', 'ar-stay-type'); });
        arCap.addEventListener('change', function() { syncRoomType('ar-capacity', 'ar-stay-type'); });
    }
    var erCap = document.getElementById('er-capacity');
    if (erCap) {
        enforceRoomNumberInput(erCap);
        erCap.addEventListener('input',  function() { syncRoomType('er-capacity', 'er-stay-type'); });
        erCap.addEventListener('change', function() { syncRoomType('er-capacity', 'er-stay-type'); });
    }
});

function openAddRoomModal() {
    document.getElementById('ar-number').value    = '';
    document.getElementById('ar-floor').value     = '';
    document.getElementById('ar-capacity').value  = '';
    document.getElementById('ar-stay-type').value = 'Shared Room';
    openModal('add-room-modal');
    setTimeout(function() {
        var arNum = document.getElementById('ar-number');
        if (arNum && !arNum._floorAutoSet) {
            arNum._floorAutoSet = true;
            arNum.addEventListener('input', function() {
                var val = this.value.trim();
                var floorSel = document.getElementById('ar-floor');
                if (!floorSel || val.length < 3) return;
                var derivedFloor = val.length > 2 ? parseInt(val.slice(0, val.length - 2), 10) : null;
                if (derivedFloor && derivedFloor >= 1 && derivedFloor <= 99) {
                    var opt = Array.from(floorSel.options).find(function(o) { return parseInt(o.value, 10) === derivedFloor; });
                    if (opt) {
                        floorSel.value = String(derivedFloor);
                    } else {
                        var newOpt = document.createElement('option');
                        newOpt.value = derivedFloor;
                        newOpt.textContent = 'Floor ' + derivedFloor;
                        floorSel.appendChild(newOpt);
                        floorSel.value = String(derivedFloor);
                    }
                }
            });
        }
    }, 0);
}

async function submitAddRoom() {
    const number   = document.getElementById('ar-number').value.trim();
    const floor    = document.getElementById('ar-floor').value;
    const capacity = document.getElementById('ar-capacity').value;
    const stayType = document.getElementById('ar-stay-type').value;
    if (!number || !floor || !capacity) { showToast('Please fill in all fields.', 'error'); return; }
    if (parseInt(floor, 10) > 99) { showToast('Floor cannot exceed 99.', 'error'); return; }
    if (number.length < 3) { showToast('Room number must be at least 3 digits.', 'error'); document.getElementById('ar-number').classList.add('field-invalid'); return; }
    const duplicate = roomsData.find(function(r) { return r.room_number.toLowerCase() === number.toLowerCase(); });
    if (duplicate) { showToast('Room ' + number + ' already exists on Floor ' + duplicate.floor + '.', 'error'); document.getElementById('ar-number').classList.add('field-invalid'); return; }
    showActionLoading('Adding room...');
    try {
        const res = await fetch('/rooms', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ room_number: number, floor, capacity, stay_type: stayType }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Failed to add room.');
        closeModal('add-room-modal');
        showToast('Room added successfully.', 'success');
        fetchRooms();
    } catch (e) {
        showToast(e.message, 'error');
    } finally {
        document.getElementById('action-loading').classList.remove('open');
    }
}

function openViewRoomModal(el) {
    var r = JSON.parse(el.dataset.room);
    var occupants = tenants.filter(function(t) {
        return t.room_number === r.room_number
            && t.status !== 'inactive'
            && t.status !== 'move_out';
    });

    var isFull    = r.occupancy >= r.capacity;
    var pct       = r.capacity > 0 ? Math.round((r.occupancy / r.capacity) * 100) : 0;
    var slotsLeft = r.capacity - r.occupancy;

    var barColor  = isFull ? '#e04867' : pct >= 75 ? '#f0a500' : '#1f9d69';
    var statusDot = r.is_active
        ? '<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#1f9d69;box-shadow:0 0 0 2px #e8faf5;flex-shrink:0;"></span><span style="font-size:.75rem;font-weight:700;color:#1f9d69;">Active</span>'
        : '<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#e04867;box-shadow:0 0 0 2px #fff0f0;flex-shrink:0;"></span><span style="font-size:.75rem;font-weight:700;color:#e04867;">Closed</span>';

    var occupantRows = '';
    if (occupants.length === 0) {
        occupantRows = '<div style="text-align:center;padding:1.5rem 1rem;color:var(--ink-muted);font-size:.85rem;background:#fffafd;border:1.5px dashed var(--pink-100);border-radius:12px;">No tenants currently assigned to this room.</div>';
    } else {
        occupantRows = '<div style="display:flex;flex-direction:column;gap:.5rem;">'
            + occupants.map(function(t) {
                var av  = (t.first_name.charAt(0) + t.last_name.charAt(0)).toUpperCase();
                var sub = (t.stay_type || '') + (t.move_in_date ? ' &nbsp;&middot;&nbsp; Moved in ' + fmtDate(t.move_in_date) : '') + (t.estimated_move_in_date && t.status === 'reserved' ? ' &nbsp;&middot;&nbsp; Est. ' + fmtDate(t.estimated_move_in_date) : '');
                var overdueTag = '';
                if (t.status === 'reserved' && isOverdue(t.estimated_move_in_date)) {
                    var ov = daysOverdue(t.estimated_move_in_date);
                    overdueTag = ' <span style="font-size:.65rem;font-weight:800;padding:.15rem .45rem;border-radius:99px;background:#fff0f0;color:#e04867;border:1px solid var(--pink-200);">' + ov + 'd overdue</span>';
                }
                return '<div class="room-occupant-card">'
                    + '<div class="room-occupant-avatar">' + av + '</div>'
                    + '<div style="flex:1;min-width:0;">'
                        + '<div class="room-occupant-name">' + t.first_name + ' ' + t.last_name + overdueTag + '</div>'
                        + '<div class="room-occupant-sub">' + sub + '</div>'
                    + '</div>'
                    + statusBadge(t.status)
                    + '</div>';
            }).join('')
            + '</div>';
    }

    document.getElementById('view-room-content').innerHTML =
        '<div style="display:flex;align-items:center;gap:1rem;padding-bottom:1rem;margin-bottom:1rem;border-bottom:1.5px solid var(--petal);">'
            + '<div style="width:52px;height:52px;border-radius:14px;background:var(--gradient-pink);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 16px rgba(232,23,93,.22);">'
                + '<img src="{{ asset("icons/bed.png") }}" style="width:26px;height:26px;object-fit:contain;filter:brightness(0) invert(1);">'
            + '</div>'
            + '<div style="flex:1;min-width:0;">'
                + '<div style="font-size:1.3rem;font-weight:900;color:var(--ink);letter-spacing:-.02em;line-height:1.1;">Room ' + r.room_number + '</div>'
                + '<div style="display:flex;align-items:center;gap:.5rem;margin-top:.3rem;">' + statusDot + '</div>'
            + '</div>'
        + '</div>'

        + '<div class="modal-section-title">Room Info</div>'
        + '<div class="tv-grid" style="margin-bottom:1rem;">'
            + '<div class="tv-item"><div class="tv-item-label">Floor</div><div class="tv-item-value">Floor ' + r.floor + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Type</div><div class="tv-item-value">' + (r.stay_type || 'N/A') + '</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Capacity</div><div class="tv-item-value">' + r.capacity + ' pax</div></div>'
            + '<div class="tv-item"><div class="tv-item-label">Available Slots</div><div class="tv-item-value" style="color:' + (isFull ? '#e04867' : '#1f9d69') + ';font-weight:700;">' + (isFull ? 'Full' : slotsLeft + ' of ' + r.capacity + ' free') + '</div></div>'
        + '</div>'

        + '<div style="margin-bottom:1rem;">'
            + '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.4rem;">'
                + '<span style="font-size:.72rem;font-weight:700;color:var(--hot-pink);text-transform:uppercase;letter-spacing:.04em;">Occupancy</span>'
                + '<span style="font-size:.75rem;font-weight:700;color:var(--ink);">' + r.occupancy + ' / ' + r.capacity + ' &nbsp;(' + pct + '%)</span>'
            + '</div>'
            + '<div style="height:6px;background:var(--pink-100);border-radius:99px;overflow:hidden;">'
                + '<div style="height:100%;width:' + pct + '%;background:' + barColor + ';border-radius:99px;transition:width .4s;"></div>'
            + '</div>'
        + '</div>'

        + '<div class="modal-section-title">Tenants (' + occupants.length + ')</div>'
        + occupantRows;

    document.getElementById('view-room-edit-btn').onclick = function() {
        closeModal('view-room-modal');
        setTimeout(function() { openEditRoomModal(r); }, 180);
    };

    openModal('view-room-modal');
}

function openEditRoomModal(r) {
    document.getElementById('er-id').value        = r.id;
    document.getElementById('er-number').value    = r.room_number;
    document.getElementById('er-floor').value     = r.floor;
    document.getElementById('er-capacity').value  = r.capacity;
    document.getElementById('er-stay-type').value = r.stay_type;
    document.getElementById('er-active').value    = r.is_active ? '1' : '0';
    openModal('edit-room-modal');
    syncRoomType('er-capacity', 'er-stay-type');
}

async function submitEditRoom() {
    const id       = document.getElementById('er-id').value;
    const number   = document.getElementById('er-number').value.trim();
    const floor    = document.getElementById('er-floor').value;
    const capacity = document.getElementById('er-capacity').value;
    const stayType = document.getElementById('er-stay-type').value;
    const isActive = document.getElementById('er-active').value === '1';
    if (!number || !floor || !capacity) { showToast('Please fill in all fields.', 'error'); return; }
    if (number.length < 3) { showToast('Room number must be at least 3 digits.', 'error'); document.getElementById('er-number').classList.add('field-invalid'); return; }
    if (parseInt(floor, 10) > 99) { showToast('Floor cannot exceed 99.', 'error'); return; }
    showActionLoading('Saving room...');
    try {
        const res = await fetch('/rooms/' + id, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ room_number: number, floor, capacity, stay_type: stayType, is_active: isActive }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Failed to update room.');
        closeModal('edit-room-modal');
        showToast('Room updated successfully.', 'success');
        fetchRooms();
    } catch (e) {
        showToast(e.message, 'error');
    } finally {
        document.getElementById('action-loading').classList.remove('open');
    }
}

let deleteRoomId = null;
function openDeleteRoomModal(id, label) {
    deleteRoomId = id;
    document.getElementById('dr-label').textContent = label;
    openModal('delete-room-modal');
}

async function submitDeleteRoom() {
    showActionLoading('Deleting room...');
    try {
        const res = await fetch('/rooms/' + deleteRoomId, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Failed to delete room.');
        closeModal('delete-room-modal');
        showToast('Room deleted.', 'success');
        fetchRooms();
    } catch (e) {
        showToast(e.message, 'error');
    } finally {
        document.getElementById('action-loading').classList.remove('open');
    }
}

(function() {
    var roomsCache = null;

    function getRoomsCache(cb) {
        if (roomsCache) { cb(roomsCache); return; }
        fetch('/rooms', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } })
            .then(function(r) { return r.json(); })
            .then(function(data) { roomsCache = data; cb(data); })
            .catch(function() { cb([]); });
    }

    window.getRoomsCache = getRoomsCache;

    function invalidateRoomsCache() { roomsCache = null; }

    var origFetchRooms = window.fetchRooms;
    window.fetchRooms = function() {
        invalidateRoomsCache();
        return origFetchRooms ? origFetchRooms() : undefined;
    };

    var originalSubmitAddRoom = window.submitAddRoom;
    window.submitAddRoom = function() { invalidateRoomsCache(); return originalSubmitAddRoom(); };
    var originalSubmitEditRoom = window.submitEditRoom;
    window.submitEditRoom = function() { invalidateRoomsCache(); return originalSubmitEditRoom(); };
    var originalSubmitDeleteRoom = window.submitDeleteRoom;
    window.submitDeleteRoom = function() { invalidateRoomsCache(); return originalSubmitDeleteRoom(); };

    function buildHint(rooms, typedRoom, excludeTenantId) {
        if (!typedRoom || typedRoom.trim() === '') return { state: 'empty', html: '' };
        var q    = typedRoom.trim().toLowerCase();
        var room = rooms.find(function(r) { return r.room_number.toLowerCase() === q; });
        if (!room) {
            var suggestions = rooms.filter(function(r) {
                return r.room_number.toLowerCase().indexOf(q) !== -1 && r.is_active;
            }).slice(0, 3);
            var suggHtml = '';
            if (suggestions.length) {
                suggHtml = '<div style="margin-top:.55rem;display:flex;flex-wrap:wrap;gap:.35rem;">'
                    + suggestions.map(function(s) {
                        return '<button type="button" class="room-hint-suggest-btn" data-room="' + s.room_number + '" style="padding:.28rem .7rem;border-radius:8px;border:1.5px solid var(--pink-100);background:var(--white);color:var(--hot-pink);font-size:.74rem;font-weight:700;cursor:pointer;font-family:inherit;transition:.15s;" onmouseover="this.style.background=\'var(--gradient-pink)\';this.style.color=\'var(--white)\';this.style.borderColor=\'transparent\';" onmouseout="this.style.background=\'var(--white)\';this.style.color=\'var(--hot-pink)\';this.style.borderColor=\'var(--pink-100)\';">'
                            + 'Rm.' + s.room_number + ' (Fl.' + s.floor + ')'
                            + '</button>';
                    }).join('')
                    + '</div>';
            }
            return {
                state: 'notfound',
                html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;">'
                    + '<img src="/icons/info.png" style="width:16px;height:16px;object-fit:contain;flex-shrink:0;margin-top:.1rem;filter:brightness(0) saturate(100%) invert(35%) sepia(80%) saturate(800%) hue-rotate(315deg) brightness(90%);">'
                    + '<div style="flex:1;min-width:0;">'
                    + '<div style="font-size:.8rem;font-weight:700;color:#b0163a;line-height:1.4;">Room <span style="font-family:monospace;">' + typedRoom.trim() + '</span> does not exist.</div>'
                    + '<div style="font-size:.74rem;color:#b0163a;margin-top:.2rem;">Open <strong>Manage Rooms</strong> to add it, then come back and assign the tenant.'
                    + (suggHtml ? '<br>Or pick a nearby match:' : '') + '</div>'
                    + suggHtml
                    + '</div></div>'
            };
        }
        if (!room.is_active) {
            return {
                state: 'inactive',
                html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;">'
                    + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.2" style="flex-shrink:0;margin-top:.1rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
                    + '<div><div style="font-size:.8rem;font-weight:700;color:#b0163a;">Room <span style="font-family:monospace;">' + room.room_number + '</span> is currently closed.</div>'
                    + '<div style="font-size:.74rem;color:#b0163a;margin-top:.15rem;">Reopen it in <strong>Manage Rooms</strong> before assigning tenants.</div></div></div>'
            };
        }
        var isOwnRoom = !!(excludeTenantId && currentTenant && currentTenant.tenant_id == excludeTenantId
            && currentTenant.room_number && currentTenant.room_number.toLowerCase() === room.room_number.toLowerCase()
            && currentTenant.status !== 'inactive' && currentTenant.status !== 'move_out');
        var effectiveOccupancy = isOwnRoom ? Math.max(0, room.occupancy - 1) : room.occupancy;
        var remaining = room.capacity - effectiveOccupancy;
        if (isOwnRoom) {
            var otherCount = effectiveOccupancy;
            return {
                state: 'current',
                html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#eef4ff;border:1.5px solid #a8c4f5;">'
                    + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b6fd4" stroke-width="2.2" style="flex-shrink:0;margin-top:.1rem;"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>'
                    + '<div style="flex:1;min-width:0;">'
                    + '<div style="font-size:.8rem;font-weight:700;color:#2952a3;">Room <span style="font-family:monospace;">' + room.room_number + '</span> is currently assigned to this tenant.</div>'
                    + '<div style="font-size:.74rem;color:#3b6fd4;margin-top:.2rem;">' + otherCount + ' other slot' + (otherCount !== 1 ? 's' : '') + ' occupied besides this one, out of ' + room.capacity + ' total. Leave it as is to keep them here, or choose a different room above.</div>'
                    + '</div></div>'
            };
        }
        if (remaining <= 0) {
            return {
                state: 'full',
                html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;">'
                    + '<img src="/icons/info.png" style="width:16px;height:16px;object-fit:contain;flex-shrink:0;margin-top:.1rem;filter:brightness(0) saturate(100%) invert(35%) sepia(80%) saturate(800%) hue-rotate(315deg) brightness(90%);">'
                    + '<div><div style="font-size:.8rem;font-weight:700;color:#b0163a;">Room <span style="font-family:monospace;">' + room.room_number + '</span> is at full capacity.</div>'
                    + '<div style="font-size:.74rem;color:#b0163a;margin-top:.15rem;">' + room.occupancy + ' of ' + room.capacity + ' slots occupied. Choose a different room or increase capacity in <strong>Manage Rooms</strong>.</div></div></div>'
            };
        }
        var barPct   = Math.round((effectiveOccupancy / room.capacity) * 100);
        var barColor = barPct >= 75 ? '#f0a500' : '#1f9d69';
        return {
            state: 'available',
            html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#f0faf6;border:1.5px solid #8ce0bb;">'
                + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.2" style="flex-shrink:0;margin-top:.1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
                + '<div style="flex:1;min-width:0;">'
                + '<div style="font-size:.8rem;font-weight:700;color:#1a7a52;">Room <span style="font-family:monospace;">' + room.room_number + '</span> available: ' + remaining + ' of ' + room.capacity + ' slot' + (room.capacity !== 1 ? 's' : '') + ' free.</div>'
                + '<div style="margin-top:.45rem;display:flex;align-items:center;gap:.6rem;">'
                + '<div style="flex:1;height:5px;background:#c8f0de;border-radius:99px;overflow:hidden;"><div style="height:100%;width:' + barPct + '%;background:' + barColor + ';border-radius:99px;transition:width .3s;"></div></div>'
                + '<span style="font-size:.7rem;font-weight:700;color:#1a7a52;">' + effectiveOccupancy + '/' + room.capacity + '</span>'
                + '</div>'
                + '<div style="font-size:.72rem;color:#2e9e68;margin-top:.2rem;">' + room.stay_type + ' &nbsp;&middot;&nbsp; Floor ' + room.floor + '</div>'
                + '</div></div>'
        };
    }

    function applySelectedHighlight() {
        if (!selectedRoomNumber) return;
        document.querySelectorAll('#add-room-suggest .room-chip-selectable').forEach(function(el) {
            if (el.dataset.room === selectedRoomNumber) {
                el.style.borderColor = '#f0c040';
                el.style.background  = '#fffbf0';
            } else {
                el.style.borderColor = el.dataset.defaultBorder;
                el.style.background  = el.dataset.defaultBg;
            }
        });
    }

    function attachRoomHint(inputId, hintId, wrapId, submitBtnSelector, excludeTenantIdFn, floorSelectId) {
        var input = document.getElementById(inputId);
        var hint  = document.getElementById(hintId);
        var wrap  = document.getElementById(wrapId);
        if (!input || !hint || !wrap) return;
        var debounceTimer = null;
        var lastVal = '';
        input.addEventListener('input', function() {
            var val = this.value.trim();
            if (floorSelectId) {
                var floorSelect = document.getElementById(floorSelectId);
                if (floorSelect && val.length >= 3) {
                    var derivedFloor = parseInt(val.slice(0, val.length - 2), 10);
                    if (derivedFloor >= 1) {
                        var existingOpt = Array.from(floorSelect.options).find(function(o) { return parseInt(o.value, 10) === derivedFloor; });
                        if (existingOpt) {
                            floorSelect.value = String(derivedFloor);
                        } else {
                            var dynOpt = document.createElement('option');
                            dynOpt.value = derivedFloor;
                            dynOpt.textContent = 'Floor ' + derivedFloor;
                            floorSelect.appendChild(dynOpt);
                            floorSelect.value = String(derivedFloor);
                        }
                    }
                }
            }
            if (val === lastVal) return;
            lastVal = val;
            clearTimeout(debounceTimer);
            if (!val) {
                wrap.style.display = 'none';
                hint.innerHTML = '';
                enableSubmit(submitBtnSelector);
                return;
            }
            debounceTimer = setTimeout(function() {
                getRoomsCache(function(rooms) {
                    var excludeId = excludeTenantIdFn ? excludeTenantIdFn() : null;
                    var result = buildHint(rooms, val, excludeId);
                    if (!result.html) {
                        wrap.style.display = 'none';
                        hint.innerHTML = '';
                        enableSubmit(submitBtnSelector);
                    } else {
                        hint.innerHTML = result.html;
                        wrap.style.display = 'block';
                        if (result.state === 'full' || result.state === 'notfound' || result.state === 'inactive') {
                            disableSubmit(submitBtnSelector);
                        } else {
                            enableSubmit(submitBtnSelector);
                        }
                        wrap.querySelectorAll('.room-hint-suggest-btn').forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                input.value = this.dataset.room;
                                input.dispatchEvent(new Event('input'));
                            });
                        });
                    }
                });
            }, 320);
        });
    }

    function disableSubmit(selector) {
        document.querySelectorAll(selector).forEach(function(btn) {
            btn.disabled = true; btn.style.opacity = '.45'; btn.style.cursor = 'not-allowed';
            btn.title = 'Resolve the room issue before saving.';
        });
    }

    function enableSubmit(selector) {
        document.querySelectorAll(selector).forEach(function(btn) {
            btn.disabled = false; btn.style.opacity = ''; btn.style.cursor = ''; btn.title = '';
        });
    }

    function renderRoomSuggestions(stayType, boxId, inputId, excludeId) {
        var wrap = document.getElementById(boxId + '-wrap');
        var box  = document.getElementById(boxId);
        if (!stayType || !wrap || !box) return;
        getRoomsCache(function(rooms) {
            var matched = rooms.filter(function(r) {
                return r.stay_type === stayType;
            }).map(function(r) {
                var isCurrent = !!(excludeId && currentTenant && currentTenant.room_number
                    && currentTenant.room_number.toLowerCase() === r.room_number.toLowerCase()
                    && currentTenant.status !== 'inactive' && currentTenant.status !== 'move_out');
                var effOccupancy = r.occupancy;
                if (isCurrent) {
                    effOccupancy = Math.max(0, effOccupancy - 1);
                }
                return Object.assign({}, r, { occupancy: effOccupancy, isCurrent: isCurrent });
            }).sort(function(a, b) {
                if (a.isCurrent !== b.isCurrent) return a.isCurrent ? -1 : 1;
                var aUnavail = (!a.is_active || (a.capacity - a.occupancy) <= 0) ? 1 : 0;
                var bUnavail = (!b.is_active || (b.capacity - b.occupancy) <= 0) ? 1 : 0;
                if (aUnavail !== bUnavail) return aUnavail - bUnavail;
                return parseInt(a.room_number) - parseInt(b.room_number);
            });

            if (!matched.length) { wrap.style.display = 'none'; box.innerHTML = ''; return; }

            var availCount = matched.filter(function(r) {
                return r.is_active && (r.capacity - r.occupancy) > 0;
            }).length;

            var currentRoom = matched.find(function(r) { return r.isCurrent; });
            var currentBanner = currentRoom
                ? '<div style="display:flex;align-items:center;gap:.5rem;padding:.5rem .7rem;border-radius:9px;background:#eef4ff;border:1.5px solid #a8c4f5;margin-bottom:.6rem;">'
                    + '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b6fd4" stroke-width="2.2" style="flex-shrink:0;"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>'
                    + '<span style="font-size:.74rem;font-weight:700;color:#2952a3;">This tenant is currently in Rm.' + currentRoom.room_number + '.</span>'
                    + '</div>'
                : '';

            var html = '<div style="background:#f9f4fb;border:1.5px solid var(--pink-100);border-radius:12px;padding:.7rem .85rem;">'
                + '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem;">'
                + '<div style="font-size:.68rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.07em;">All rooms \u00b7 ' + stayType + '</div>'
                + '<div style="font-size:.68rem;font-weight:700;color:#1f9d69;">' + availCount + ' available</div>'
                + '</div>'
                + currentBanner
                + '<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:.4rem;">';

            matched.forEach(function(r) {
                var remaining  = r.capacity - r.occupancy;
                var isFull     = remaining <= 0;
                var isInactive = !r.is_active;
                var unavail    = (isFull || isInactive) && !r.isCurrent;
                var pct        = r.capacity > 0 ? Math.round((r.occupancy / r.capacity) * 100) : 0;
                var chipBg, chipBorder, chipColor, badgeBg, badgeColor, badgeText, cursor, clickAttr;
                var stayTypeSelectId = boxId === 'edit-room-suggest' ? 'edit-stay-type' : (boxId === 'renew-room-suggest' ? 'renew-stay-type' : 'add-stay-type-select');
                if (r.isCurrent) {
                    chipBg = '#eef4ff'; chipBorder = '#a8c4f5'; chipColor = '#2952a3';
                    badgeBg = '#dce8fb'; badgeColor = '#2952a3'; badgeText = 'Current';
                    cursor = 'pointer'; clickAttr = 'onclick="selectSuggestedRoom(\'' + r.room_number + '\', \'' + inputId + '\', \'' + boxId + '\', \'' + stayTypeSelectId + '\', ' + (excludeId || 'null') + ')"';
                } else if (isInactive) {
                    chipBg = '#f5f5f5'; chipBorder = '#d0d0d0'; chipColor = '#999';
                    badgeBg = '#efefef'; badgeColor = '#999'; badgeText = 'Closed';
                    cursor = 'not-allowed'; clickAttr = '';
                } else if (isFull) {
                    chipBg = '#fff0f2'; chipBorder = '#ffb3c0'; chipColor = '#c0163a';
                    badgeBg = '#ffe0e6'; badgeColor = '#c0163a'; badgeText = 'Full';
                    cursor = 'not-allowed'; clickAttr = '';
                } else if (pct >= 75) {
                    chipBg = '#fffbf0'; chipBorder = '#f0c040'; chipColor = '#7a5000';
                    badgeBg = '#fff3cc'; badgeColor = '#8a5c00'; badgeText = remaining + ' left';
                    cursor = 'pointer'; clickAttr = 'onclick="selectSuggestedRoom(\'' + r.room_number + '\', \'' + inputId + '\', \'' + boxId + '\', \'' + stayTypeSelectId + '\', ' + (excludeId || 'null') + ')"';
                } else {
                    chipBg = '#f0faf6'; chipBorder = '#8ce0bb'; chipColor = '#1a5a38';
                    badgeBg = '#d4f2e4'; badgeColor = '#1a5a38'; badgeText = remaining + ' free';
                    cursor = 'pointer'; clickAttr = 'onclick="selectSuggestedRoom(\'' + r.room_number + '\', \'' + inputId + '\', \'' + boxId + '\', \'' + stayTypeSelectId + '\', ' + (excludeId || 'null') + ')"';
                }
                var isSelected    = (selectedRoomNumber === r.room_number) && !unavail;
                var displayBorder = isSelected ? 'var(--bright-pink)' : chipBorder;
                var displayBg     = isSelected ? '#fff0f6' : chipBg;
                var ringStyle     = isSelected ? 'box-shadow:0 0 0 3px rgba(232,23,93,.16);' : '';
                var hoverIn  = unavail ? '' : 'onmouseover="this.style.borderColor=\'var(--bright-pink)\';this.style.background=\'#fff0f6\';"';
                var hoverOut = unavail ? '' : 'onmouseout="if(\'' + r.room_number + '\'===selectedRoomNumber){this.style.borderColor=\'var(--bright-pink)\';this.style.background=\'#fff0f6\';}else{this.style.borderColor=\'' + chipBorder + '\';this.style.background=\'' + chipBg + '\';}";';
                var chipClass = unavail ? '' : 'room-chip-selectable';
                var chipData  = unavail ? '' : 'data-room="' + r.room_number + '" data-default-border="' + chipBorder + '" data-default-bg="' + chipBg + '"';
                var checkMark = isSelected
                    ? '<div style="position:absolute;top:5px;right:5px;width:15px;height:15px;border-radius:50%;background:var(--gradient-pink);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 5px rgba(232,23,93,.4);">'
                        + '<svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>'
                        + '</div>'
                    : '';
                html += '<div ' + clickAttr + ' ' + chipClass + ' ' + chipData + ' ' + hoverIn + ' ' + hoverOut
                    + ' style="position:relative;display:flex;flex-direction:column;gap:.3rem;padding:.5rem .6rem;border-radius:10px;border:1.5px solid '
                    + displayBorder + ';background:' + displayBg + ';cursor:' + cursor + ';transition:border-color .15s,background .15s,box-shadow .15s;user-select:none;' + ringStyle + '">'
                    + checkMark
                    + '<div style="display:flex;align-items:center;justify-content:space-between;gap:.25rem;">'
                        + '<span style="font-size:.82rem;font-weight:800;color:' + chipColor + ';">Rm.' + r.room_number + '</span>'
                        + (r.floor ? '<span style="font-size:.62rem;font-weight:600;color:' + chipColor + ';opacity:.7;">Fl.' + r.floor + '</span>' : '')
                    + '</div>'
                    + '<div style="display:inline-flex;align-items:center;justify-content:center;padding:.18rem .45rem;border-radius:6px;background:' + badgeBg + ';border:1px solid ' + chipBorder + ';">'
                        + '<span style="font-size:.66rem;font-weight:800;color:' + badgeColor + ';letter-spacing:.02em;">' + badgeText + '</span>'
                    + '</div>'
                    + '<div style="height:3px;background:#e0e0e0;border-radius:99px;overflow:hidden;">'
                        + '<div style="height:100%;width:' + pct + '%;background:' + (r.isCurrent ? '#3b6fd4' : isFull ? '#e04867' : pct >= 75 ? '#f0a500' : '#1f9d69') + ';border-radius:99px;"></div>'
                    + '</div>'
                    + '</div>';
            });

            html += '</div></div>';
            box.innerHTML = html;
            wrap.style.display = 'block';
        });
    }

    window.onAddStayTypeChange = function() {
        var stayType    = document.getElementById('add-stay-type-select').value;
        var suggestWrap = document.getElementById('add-room-suggest-wrap');
        if (!stayType) { if (suggestWrap) suggestWrap.style.display = 'none'; return; }
        renderRoomSuggestions(stayType, 'add-room-suggest', 'add-room-number-input', null);
    };

    window.onRenewStayTypeChange = function() {
        var stayType    = document.getElementById('renew-stay-type').value;
        var suggestWrap = document.getElementById('renew-room-suggest-wrap');
        if (!stayType) { if (suggestWrap) suggestWrap.style.display = 'none'; return; }
        renderRoomSuggestions(stayType, 'renew-room-suggest', 'renew-room', null);
    };

    window.onEditStayTypeChange = function() {
        var stayType    = document.getElementById('edit-stay-type').value;
        var suggestWrap = document.getElementById('edit-room-suggest-wrap');
        if (!stayType) { if (suggestWrap) suggestWrap.style.display = 'none'; return; }
        var excludeId = currentTenant ? currentTenant.tenant_id : null;
        renderRoomSuggestions(stayType, 'edit-room-suggest', 'edit-room', excludeId);
    };

    window.selectSuggestedRoom = function(roomNumber, inputId, suggestBoxId, stayTypeSelectId, excludeId) {
        var input = document.getElementById(inputId);
        if (!input) return;
        selectedRoomNumber = roomNumber;
        input.value = roomNumber;
        var stayType = document.getElementById(stayTypeSelectId).value;
        if (stayType) {
            renderRoomSuggestions(stayType, suggestBoxId, inputId, excludeId);
        }
        input.dispatchEvent(new Event('input'));
    };

    document.addEventListener('DOMContentLoaded', function() {
        attachRoomHint(
            'add-room-number-input', 'add-room-hint', 'add-room-hint-wrap',
            '#add-modal .btn-submit', null, 'add-floor-select'
        );
        var addRoomInput = document.getElementById('add-room-number-input');
        if (addRoomInput) {
            addRoomInput.addEventListener('input', function() { toggleReservationFields('add'); });
        }
        attachRoomHint(
            'edit-room', 'edit-room-hint', 'edit-room-hint-wrap',
            '#edit-modal .btn-submit',
            function() { return currentTenant ? currentTenant.tenant_id : null; },
            'edit-floor'
        );
    });
})();

function setAddMode(mode) {
    document.getElementById('add-mode-input').value = mode;
    var btnMovedIn     = document.getElementById('add-mode-btn-movedin');
    var btnReservation = document.getElementById('add-mode-btn-reservation');
    if (mode === 'moved_in') {
        btnMovedIn.style.border         = '2px solid var(--bright-pink)';
        btnMovedIn.style.background     = 'linear-gradient(135deg,#fff0f6,#ffe4ef)';
        btnReservation.style.border     = '2px solid var(--pink-100)';
        btnReservation.style.background = 'var(--white)';
    } else {
        btnReservation.style.border     = '2px solid #f0c040';
        btnReservation.style.background = 'linear-gradient(135deg,#fffdf0,#fff8dc)';
        btnMovedIn.style.border         = '2px solid var(--pink-100)';
        btnMovedIn.style.background     = 'var(--white)';
    }
    toggleReservationFields('add');
}

(function() {
    var activeTooltip = null;

    document.addEventListener('mouseover', function(e) {
        var el = e.target.closest('.overdue-date');
        if (!el) return;
        var tooltip = el.querySelector('.overdue-date-tooltip');
        if (!tooltip) return;
        activeTooltip = tooltip;
        tooltip.style.display = 'block';
        positionOverdueTooltip(el, tooltip);
    });

    document.addEventListener('mousemove', function(e) {
        if (!activeTooltip) return;
        var el = e.target.closest('.overdue-date');
        if (!el) return;
        positionOverdueTooltip(el, activeTooltip);
    });

    document.addEventListener('mouseout', function(e) {
        var el = e.target.closest('.overdue-date');
        if (!el) return;
        var tooltip = el.querySelector('.overdue-date-tooltip');
        if (tooltip) tooltip.style.display = 'none';
        activeTooltip = null;
    });

    function positionOverdueTooltip(el, tooltip) {
        var rect       = el.getBoundingClientRect();
        var tipWidth   = tooltip.offsetWidth  || 280;
        var tipHeight  = tooltip.offsetHeight || 60;
        var spaceAbove = rect.top;
        var spaceBelow = window.innerHeight - rect.bottom;
        var left       = rect.left + (rect.width / 2) - (tipWidth / 2);

        left = Math.max(8, Math.min(left, window.innerWidth - tipWidth - 8));

        var top;
        var arrow = tooltip.querySelector('::after');

        if (spaceAbove >= tipHeight + 12) {
            top = rect.top - tipHeight - 10;
            tooltip.style.setProperty('--arrow-top', '100%');
        } else {
            top = rect.bottom + 10;
            tooltip.style.setProperty('--arrow-top', '-10px');
        }

        tooltip.style.left = left + 'px';
        tooltip.style.top  = top  + 'px';
    }
})();

var _renewCredNewTenantId = null;

function triggerRenewPhotoUpload() {
    var input = document.getElementById('renew-photo-upload-input');
    input.value = '';
    input.click();
}

async function submitRenewPhoto(input) {
    var tenantId = _renewCredNewTenantId;
    if (!tenantId) {
        showRenewPhotoStatus('error', 'No tenant ID found. Please close and try again.');
        input.value = '';
        return;
    }
    var file = input.files[0];
    if (!file) return;

    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (allowedTypes.indexOf(file.type) === -1) {
        showRenewPhotoStatus('error', 'Invalid file type. Only JPG and PNG are accepted.');
        input.value = '';
        return;
    }
    if (file.size > 4 * 1024 * 1024) {
        showRenewPhotoStatus('error', 'File is too large. Maximum size is 4MB.');
        input.value = '';
        return;
    }

    var btn = document.getElementById('renew-cred-upload-btn');
    var btnLabel = document.getElementById('renew-cred-upload-btn-label');
    if (btn) { btn.disabled = true; btn.style.opacity = '.65'; }
    if (btnLabel) btnLabel.textContent = 'Uploading...';
    showRenewPhotoStatus('loading', 'Uploading photo...');

    var formData = new FormData();
    formData.append('tenant_photo', file);

    try {
        var res = await fetch('/tenants/' + tenantId + '/upload-photo', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData,
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Upload failed.');

        var previewWrap = document.getElementById('renew-cred-photo-preview-wrap');
        var previewImg  = document.getElementById('renew-cred-photo-preview-img');
        if (previewWrap && previewImg) {
            previewImg.src = data.url + '?t=' + Date.now();
            previewWrap.style.display = '';
        }

        if (btnLabel) btnLabel.textContent = 'Change Photo';
        showRenewPhotoStatus('success', 'Photo uploaded successfully.');

        var idx = tenants.findIndex(function(t) { return t.tenant_id == tenantId; });
        if (idx !== -1) tenants[idx].tenant_photo = data.tenant_photo;
        applyFilters();
    } catch (e) {
        showRenewPhotoStatus('error', e.message || 'Upload failed. Please try again.');
        if (btnLabel) btnLabel.textContent = 'Try Again';
    } finally {
        if (btn) { btn.disabled = false; btn.style.opacity = ''; }
    }
}

function showRenewPhotoStatus(type, message) {
    var el = document.getElementById('renew-cred-upload-status');
    if (!el) return;
    var colorMap = { success: '#1f9d69', error: '#e04867', loading: '#7a3050' };
    el.style.color = colorMap[type] || '#7a3050';
    el.textContent = message;
    el.style.display = '';
    if (type === 'success') {
        setTimeout(function() { el.style.display = 'none'; }, 5000);
    }
}

function openRenewModal(id, name, roomNumber, stayType) {
    renewTenantId = id;
    document.getElementById('renew-tenant-name').textContent = name;
    var today = new Date();
    var yyyy  = today.getFullYear();
    var mm    = String(today.getMonth() + 1).padStart(2, '0');
    var dd    = String(today.getDate()).padStart(2, '0');
    var todayStr = yyyy + '-' + mm + '-' + dd;
    document.getElementById('renew-move-in').value  = todayStr;
    var oneYearOut = new Date(today);
    oneYearOut.setFullYear(oneYearOut.getFullYear() + 1);
    var oneYearStr = oneYearOut.getFullYear() + '-' + String(oneYearOut.getMonth()+1).padStart(2,'0') + '-' + String(oneYearOut.getDate()).padStart(2,'0');
    document.getElementById('renew-move-out').value = oneYearStr;
    document.getElementById('renew-room').value     = roomNumber || '';
    document.getElementById('renew-move-in').classList.remove('field-invalid');
    document.getElementById('renew-move-out').classList.remove('field-invalid');
    document.getElementById('renew-room').classList.remove('field-invalid');
    document.getElementById('renew-move-in-error').style.display  = 'none';
    document.getElementById('renew-move-out-error').style.display = 'none';
    document.getElementById('renew-room-error').style.display     = 'none';

    var stayTypeSel = document.getElementById('renew-stay-type');
    if (stayTypeSel) {
        stayTypeSel.value = stayType || '';
        var suggestWrap = document.getElementById('renew-room-suggest-wrap');
        var suggestBox  = document.getElementById('renew-room-suggest');
        if (suggestWrap) suggestWrap.style.display = 'none';
        if (suggestBox)  suggestBox.innerHTML = '';
        if (stayType) {
            setTimeout(function() { onRenewStayTypeChange(); }, 80);
        }
    }

    var hintWrap = document.getElementById('renew-room-hint-wrap');
    var hint     = document.getElementById('renew-room-hint');
    if (hintWrap) hintWrap.style.display = 'none';
    if (hint)     hint.innerHTML = '';

    openModal('renew-modal');
    renderStayDuration('renew-stay-duration-wrap', 'renew-stay-duration-display', document.getElementById('renew-move-in').value, document.getElementById('renew-move-out').value);
    setTimeout(function() {
        var moveInEl  = document.getElementById('renew-move-in');
        var moveOutEl = document.getElementById('renew-move-out');
        if (moveInEl && !moveInEl._renewValidatorAttached) {
            moveInEl._renewValidatorAttached = true;
            moveInEl.addEventListener('change', function() {
                validateRenewDates();
                if (this.value && !moveOutEl.value) {
                    var d = new Date(this.value + 'T00:00:00');
                    d.setFullYear(d.getFullYear() + 1);
                    moveOutEl.value = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
                }
                renderStayDuration('renew-stay-duration-wrap', 'renew-stay-duration-display', moveInEl.value, moveOutEl.value);
            });
            moveOutEl.addEventListener('change', function() {
                validateRenewDates();
                renderStayDuration('renew-stay-duration-wrap', 'renew-stay-duration-display', moveInEl.value, moveOutEl.value);
            });
        }
        var renewRoomInput = document.getElementById('renew-room');
        if (renewRoomInput && !renewRoomInput._renewHintAttached) {
            renewRoomInput._renewHintAttached = true;
            var debounce = null;
            renewRoomInput.addEventListener('input', function() {
                var val = this.value.trim();
                clearTimeout(debounce);
                var hintWrap2 = document.getElementById('renew-room-hint-wrap');
                var hint2     = document.getElementById('renew-room-hint');
                if (!val) {
                    if (hintWrap2) hintWrap2.style.display = 'none';
                    if (hint2)     hint2.innerHTML = '';
                    return;
                }
                debounce = setTimeout(function() {
                    (function(roomsCache) {
                        var fn = typeof getRoomsCache === 'function' ? getRoomsCache : function(cb) { cb(roomsCache || []); };
                        fn(function(rooms) {
                            var result = buildHint(rooms, val, null);
                            if (!result || !result.html) {
                                if (hintWrap2) hintWrap2.style.display = 'none';
                                if (hint2)     hint2.innerHTML = '';
                            } else {
                                if (hint2)     hint2.innerHTML = result.html;
                                if (hintWrap2) hintWrap2.style.display = 'block';
                                if (hintWrap2) hintWrap2.querySelectorAll('.room-hint-suggest-btn').forEach(function(btn) {
                                    btn.addEventListener('click', function() {
                                        renewRoomInput.value = this.dataset.room;
                                        renewRoomInput.dispatchEvent(new Event('input'));
                                    });
                                });
                            }
                        });
                    })();
                }, 320);
            });
        }
    }, 0);
}

function validateRenewDates() {
    var moveIn  = document.getElementById('renew-move-in').value;
    var moveOut = document.getElementById('renew-move-out').value;
    var errEl   = document.getElementById('renew-move-out-error');
    var outEl   = document.getElementById('renew-move-out');
    if (moveOut && moveIn && moveOut < moveIn) {
        outEl.classList.add('field-invalid');
        errEl.textContent = 'Move-out date cannot be earlier than move-in date.';
        errEl.style.display = 'block';
        return false;
    }
    outEl.classList.remove('field-invalid');
    errEl.style.display = 'none';
    errEl.textContent = '';
    return true;
}

var _renewInFlight = false;
async function submitRenewTenant() {
    if (_renewInFlight) return;
    _renewInFlight = true;
    var moveIn  = document.getElementById('renew-move-in').value;
    var moveOut = document.getElementById('renew-move-out').value;
    var room    = document.getElementById('renew-room').value.trim();
    var valid   = true;

    document.getElementById('renew-move-in-error').style.display  = 'none';
    document.getElementById('renew-move-out-error').style.display = 'none';
    document.getElementById('renew-room-error').style.display     = 'none';
    document.getElementById('renew-move-in').classList.remove('field-invalid');
    document.getElementById('renew-move-out').classList.remove('field-invalid');
    document.getElementById('renew-room').classList.remove('field-invalid');

    if (!moveIn) {
        document.getElementById('renew-move-in-error').textContent = 'Move-in date is required.';
        document.getElementById('renew-move-in-error').style.display = 'block';
        document.getElementById('renew-move-in').classList.add('field-invalid');
        valid = false;
    }

    if (!moveOut) {
        document.getElementById('renew-move-out-error').textContent = 'Move-out date is required.';
        document.getElementById('renew-move-out-error').style.display = 'block';
        document.getElementById('renew-move-out').classList.add('field-invalid');
        valid = false;
    }

    if (moveOut && moveIn && moveOut < moveIn) {
        document.getElementById('renew-move-out-error').textContent = 'Move-out date cannot be earlier than move-in date.';
        document.getElementById('renew-move-out-error').style.display = 'block';
        document.getElementById('renew-move-out').classList.add('field-invalid');
        valid = false;
    }

    if (room && room.length < 3) {
        document.getElementById('renew-room-error').textContent = 'Room number must be at least 3 digits.';
        document.getElementById('renew-room-error').style.display = 'block';
        document.getElementById('renew-room').classList.add('field-invalid');
        valid = false;
    }

    if (!valid) {
        if (!moveIn) document.getElementById('renew-move-in').focus();
        return;
    }

    var submitBtn = document.querySelector('#renew-modal .btn-submit');
    if (submitBtn) { submitBtn.disabled = true; submitBtn.style.opacity = '.65'; submitBtn.textContent = 'Processing...'; }

    showActionLoading('Renewing tenant stay...');

    try {
        var res;
        try {
            res = await fetch('/tenants/' + renewTenantId + '/renew', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ move_in_date: moveIn, move_out_date: moveOut || null, room_number: room || null }),
            });
        } catch (networkErr) {
            throw new Error('Network error. Check your connection and try again.');
        }
        var data;
        try {
            data = await res.json();
        } catch (parseErr) {
            throw new Error('Unexpected server response. The server may have returned an error page instead of JSON.');
        }
        if (!res.ok) {
            var errMsg = data.message || 'Failed to renew tenant.';
            if (res.status === 404) {
                throw new Error('No move-out record found for this tenant. Make sure the tenant has been marked as moved out first.');
            }
            if (res.status === 422) {
                if (errMsg.toLowerCase().indexOf('full') !== -1 || errMsg.toLowerCase().indexOf('room') !== -1) {
                    document.getElementById('renew-room-error').textContent = errMsg;
                    document.getElementById('renew-room-error').style.display = 'block';
                    document.getElementById('renew-room').classList.add('field-invalid');
                    document.getElementById('renew-room').focus();
                }
                throw new Error(errMsg);
            }
            if (res.status === 401) {
                throw new Error('Session expired. Please refresh the page and log in again.');
            }
            throw new Error(errMsg);
        }

        var tenantName = document.getElementById('renew-tenant-name').textContent;

        closeModal('renew-modal');

        document.getElementById('renew-cred-name').textContent       = tenantName;
        document.getElementById('renew-cred-account-id').textContent = data.account_id;
        document.getElementById('renew-cred-password').textContent   = data.temp_password;

        var photoSuggestWrap = document.getElementById('renew-cred-photo-suggest');
        if (photoSuggestWrap) {
            if (data.new_tenant_id) {
                _renewCredNewTenantId = data.new_tenant_id;
                photoSuggestWrap.style.display = '';
                var previewWrap = document.getElementById('renew-cred-photo-preview-wrap');
                if (previewWrap) previewWrap.style.display = 'none';
                var statusEl = document.getElementById('renew-cred-upload-status');
                if (statusEl) statusEl.style.display = 'none';
                var btnLabel = document.getElementById('renew-cred-upload-btn-label');
                if (btnLabel) btnLabel.textContent = 'Upload Photo';
                var btn = document.getElementById('renew-cred-upload-btn');
                if (btn) { btn.disabled = false; btn.style.opacity = ''; }
            } else {
                _renewCredNewTenantId = null;
                photoSuggestWrap.style.display = 'none';
            }
        }

        openModal('renew-credentials-modal');

        moveoutTenantArchive = moveoutTenantArchive.filter(function(r) { return r.id !== renewTenantId; });
        document.getElementById('tcount-moveout').textContent = moveoutTenantArchive.length;
        renderTenantArchive();

        showToast(tenantName + ' has been renewed successfully.', 'success');
    } catch (e) {
        var msg = e.message || 'An unexpected error occurred. Please try again.';
        showToast(msg, 'error');
        if (submitBtn) { submitBtn.disabled = false; submitBtn.style.opacity = ''; submitBtn.textContent = 'Renew & Generate Credentials'; }
    } finally {
        _renewInFlight = false;
        document.getElementById('action-loading').classList.remove('open');
    }
}

(function () {
    var liveFingerprint = null;
    var pollInterval = 5000;

    function anyOverlayOpen() {
        return !!document.querySelector('.modal-overlay.open')
            || document.getElementById('tad-drawer').classList.contains('open')
            || document.getElementById('rooms-drawer').classList.contains('open')
            || document.getElementById('admin-log-drawer').classList.contains('open');
    }

    function checkForTenantUpdates() {
        if (anyOverlayOpen()) return;

        fetch('{{ route("tenants.live") }}', { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (liveFingerprint === null) {
                    liveFingerprint = data.fingerprint;
                    return;
                }
                if (data.fingerprint === liveFingerprint) return;

                liveFingerprint = data.fingerprint;
                tenants = data.tenants;

                var totalEl = document.getElementById('count-total');
                var activeEl = document.getElementById('count-active');
                if (totalEl) totalEl.textContent = data.totalTenants;
                if (activeEl) activeEl.textContent = data.activeCount;

                var keepActivePage   = sectionPages.active;
                var keepReservedPage = sectionPages.reserved;
                applyFilters();
                sectionPages.active   = Math.min(keepActivePage,   Math.max(1, Math.ceil(sectionData.active.length   / PER_PAGE)));
                sectionPages.reserved = Math.min(keepReservedPage, Math.max(1, Math.ceil(sectionData.reserved.length / PER_PAGE)));
                renderSection('active');
                renderSection('reserved');
            })
            .catch(function () {});
    }

    checkForTenantUpdates();
    setInterval(checkForTenantUpdates, 15000);
})();

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search-input').value = '';
    document.getElementById('floor-filter').value = '';
    document.getElementById('sort-select').value = 'newest';
    document.getElementById('status-filter').value = '';
    applyFilters();

    document.querySelectorAll('#add-modal input[required], #edit-modal input[required]').forEach(function(inp) {
        inp.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('field-invalid');
            } else {
                this.classList.remove('field-invalid');
            }
        });
        inp.addEventListener('input', function() {
            if (this.value.trim()) this.classList.remove('field-invalid');
        });
    });
});

var deletedTenantArchive  = {!! json_encode($deletedArchive,  JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
var inactiveTenantArchive = {!! json_encode($inactiveArchive, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
var moveoutTenantArchive  = {!! json_encode($moveoutArchive,  JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
var tenantArchiveTab = 'deleted';

function fmtDatePlain(d) {
    if (!d) return '\u2014';
    var dt = new Date(d);
    return dt.toLocaleDateString('en-US',{month:'2-digit',day:'2-digit',year:'numeric'}) + ' ' + dt.toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit',hour12:true});
}

function openTenantArchive() {
    document.getElementById('tad-drawer').classList.add('open');
    document.getElementById('tad-backdrop').classList.add('open');
    document.getElementById('tad-search').value = '';
    document.getElementById('tcount-deleted').textContent  = deletedTenantArchive.length;
    document.getElementById('tcount-inactive').textContent = inactiveTenantArchive.length;
    document.getElementById('tcount-moveout').textContent  = moveoutTenantArchive.length;
    renderTenantArchive();
}

function closeTenantArchive() {
    document.getElementById('tad-drawer').classList.remove('open');
    document.getElementById('tad-backdrop').classList.remove('open');
}

function switchTenantArchiveTab(tab) {
    tenantArchiveTab = tab;
    document.getElementById('ttab-deleted').classList.toggle('active',  tab === 'deleted');
    document.getElementById('ttab-inactive').classList.toggle('active', tab === 'inactive');
    document.getElementById('ttab-moveout').classList.toggle('active',  tab === 'move_out');
    document.getElementById('tad-search').value = '';
    renderTenantArchive();
}

function statusPillClass(status) {
    var map = { active:'tad-pill-active', pending:'tad-pill-pending', reserved:'tad-pill-reserved', move_out:'tad-pill-moveout', inactive:'tad-pill-inactive' };
    return map[status] || 'tad-pill-inactive';
}

function renderTenantArchive() {
    var q = document.getElementById('tad-search').value.toLowerCase();
    var source;
    if (tenantArchiveTab === 'deleted')  source = deletedTenantArchive;
    if (tenantArchiveTab === 'inactive') source = inactiveTenantArchive;
    if (tenantArchiveTab === 'move_out') source = moveoutTenantArchive;
    var data = source.filter(function(r) {
        return (r.account_id||'').toLowerCase().indexOf(q) !== -1 ||
               (r.first_name+' '+r.last_name).toLowerCase().indexOf(q) !== -1 ||
               (r.email||'').toLowerCase().indexOf(q) !== -1 ||
               (r.room_number||'').toLowerCase().indexOf(q) !== -1 ||
               (r.stay_type||'').toLowerCase().indexOf(q) !== -1;
    });
    var list = document.getElementById('tad-list');
    document.getElementById('tad-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');
    if (data.length === 0) {
        var labelMap = { deleted:'deleted', inactive:'inactive', move_out:'move out' };
        list.innerHTML = '<div class="tad-empty"><img class="tad-empty-icon" src="{{ asset('icons/tenants.png') }}" alt="">No ' + labelMap[tenantArchiveTab] + ' records found.</div>';
        return;
    }
    var archiveLabelMap = { deleted:'Deleted on', inactive:'Marked inactive on', move_out:'Moved out on' };
    var archiveLabel = archiveLabelMap[tenantArchiveTab];
    list.innerHTML = data.map(function(r, i) {
        var roomPill = (r.floor && r.room_number) ? '<span class="tad-pill tad-pill-room">'+r.floor+'-'+r.room_number+'</span>' : (r.room_number ? '<span class="tad-pill tad-pill-room">'+r.room_number+'</span>' : '');
        var stayPill = r.stay_type ? '<span class="tad-pill tad-pill-stay">'+r.stay_type+'</span>' : '';
        var isAdmin = {{ Auth::guard('staff')->user()?->role === 'admin' ? 'true' : 'false' }};
        var reactivateForm = tenantArchiveTab === 'inactive' && r.id && isAdmin
            ? '<form method="POST" action="/tenants/' + r.id + '/reactivate" style="margin-top:.75rem;" onsubmit="this.querySelector(\'button\').disabled=true;showActionLoading(\'Reactivating account...\');">'
                + '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                + '<button type="submit" style="width:100%;padding:.45rem 0;border-radius:8px;border:none;background:var(--gradient-pink);color:var(--white);font-size:.76rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);letter-spacing:.02em;">Reactivate Account</button>'
                + '</form>'
            : tenantArchiveTab === 'move_out' && r.id && isAdmin
            ? '<button type="button" onclick="openRenewModal(' + r.id + ', \'' + escapeJs(r.first_name + ' ' + r.last_name) + '\', \'' + escapeJs(r.room_number || '') + '\', \'' + escapeJs(r.stay_type || '') + '\')" style="width:100%;margin-top:.75rem;padding:.45rem 0;border-radius:8px;border:1.5px solid var(--pink-100);background:var(--white);color:var(--hot-pink);font-size:.76rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);letter-spacing:.02em;transition:background .2s,color .2s,border-color .2s;" onmouseover="this.style.background=\'var(--gradient-pink)\';this.style.color=\'var(--white)\';this.style.borderColor=\'transparent\';" onmouseout="this.style.background=\'var(--white)\';this.style.color=\'var(--hot-pink)\';this.style.borderColor=\'var(--pink-100)\';">Renew Stay</button>'
            : '';
        var archivePhotoHtml = r.tenant_photo
            ? '<img src="/storage/' + r.tenant_photo + '" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:1.5px solid var(--pink-100);flex-shrink:0;box-shadow:0 2px 8px rgba(232,23,93,.12);" alt="">'
            : '<div style="width:38px;height:38px;border-radius:50%;background:var(--gradient-pink);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.78rem;flex-shrink:0;box-shadow:0 2px 8px rgba(232,23,93,.12);">' + (r.first_name.charAt(0) + r.last_name.charAt(0)).toUpperCase() + '</div>';

        return '<div class="tad-card" style="animation-delay:' + (i*0.04) + 's;">'
            + '<div class="tad-card-top" style="align-items:center;">'
                + archivePhotoHtml
                + '<div style="flex:1;min-width:0;">'
                    + '<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;margin-bottom:.2rem;">'
                        + '<div class="tad-card-id">' + (r.account_id||'\u2014') + '</div>'
                        + '<div class="tad-card-time">' + (r.move_in_date ? fmtDate(r.move_in_date) : '\u2014') + '</div>'
                    + '</div>'
                    + '<div class="tad-card-name">' + r.first_name + ' ' + r.last_name + '</div>'
                    + '<div class="tad-card-email">' + (r.email||'\u2014') + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="tad-card-meta">' + roomPill + stayPill + '<span class="tad-pill ' + statusPillClass(r.status) + '">' + (r.status||'\u2014') + '</span></div>'
            + '<div class="tad-card-archived">' + archiveLabel + ': <span>' + fmtDatePlain(r.archived_at) + '</span></div>'
            + reactivateForm
            + '</div>';
    }).join('');
}

function exportTenantArchive(format) {
    var source;
    if (tenantArchiveTab === 'deleted')  source = deletedTenantArchive;
    if (tenantArchiveTab === 'inactive') source = inactiveTenantArchive;
    if (tenantArchiveTab === 'move_out') source = moveoutTenantArchive;
    var labelMap = { deleted:'Deleted On', inactive:'Marked Inactive On', move_out:'Moved Out On' };
    if (format === 'pdf') {
        var win = window.open('', '_blank');
        var tabLabel = { deleted:'Deleted', inactive:'Inactive', move_out:'Move Out' };
        var rows = source.map(function(r) {
            return '<tr><td>'+(r.account_id||'')+'</td><td>'+r.first_name+' '+r.last_name+'</td><td>'+(r.email||'')+'</td><td>'+(r.floor&&r.room_number?r.floor+'-'+r.room_number:(r.room_number||''))+'</td><td>'+(r.stay_type||'')+'</td><td>'+(r.status||'')+'</td><td>'+(r.archived_at||'')+'</td></tr>';
        }).join('');
        win.document.write('<!DOCTYPE html><html><head><title>Archive - '+tabLabel[tenantArchiveTab]+'</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec}</style></head><body><h2>Tenant Archive - '+tabLabel[tenantArchiveTab]+'</h2><p>Sanctissimo Rosario Ladies Dormitory, exported '+new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})+'</p><table><thead><tr><th>Account ID</th><th>Name</th><th>Email</th><th>Room</th><th>Stay Type</th><th>Status</th><th>'+labelMap[tenantArchiveTab]+'</th></tr></thead><tbody>'+rows+'</tbody></table></body></html>');
        win.document.close();
        win.print();
        return;
    }
    var rows = [['Account ID','First Name','Last Name','Email','Contact','Floor','Room','Stay Type','Move-In','Move-Out','Status',labelMap[tenantArchiveTab]]];
    source.forEach(function(r) {
        rows.push([r.account_id||'',r.first_name,r.last_name,r.email||'',r.contact_number||'',r.floor||'',r.room_number||'',r.stay_type||'',r.move_in_date||'',r.move_out_date||'',r.status||'',r.archived_at||'']);
    });
    var csv = rows.map(function(r) { return r.map(function(c) { return '"'+String(c).replace(/"/g,'""')+'"'; }).join(','); }).join('\n');
    var a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'tenants_' + tenantArchiveTab + '_archive.csv';
    a.click();
}

var _exportMenuPortal = null;

function getExportPortal() {
    if (!_exportMenuPortal) {
        _exportMenuPortal = document.createElement('div');
        _exportMenuPortal.id = 'export-menu-portal';
        _exportMenuPortal.style.cssText = 'position:fixed;z-index:99999;top:0;left:0;width:0;height:0;overflow:visible;';
        document.body.appendChild(_exportMenuPortal);
    }
    return _exportMenuPortal;
}

var _activeExportDropdownId = null;
var _portalMenuEl = null;

function toggleExportDropdown(id) {
    if (_activeExportDropdownId === id && _portalMenuEl) {
        closeAllExportDropdowns();
        return;
    }
    closeAllExportDropdowns();
    var dropdown = document.getElementById(id);
    var sourceMenu = dropdown.querySelector('.export-menu');
    if (!sourceMenu) return;

    _portalMenuEl = sourceMenu.cloneNode(true);
    _portalMenuEl.classList.add('open');
    _portalMenuEl.style.cssText = 'display:block;position:fixed;z-index:99999;background:var(--white);border:1.5px solid var(--pink-100);border-radius:12px;box-shadow:0 8px 24px rgba(232,23,93,.15);min-width:160px;overflow:hidden;';
    _portalMenuEl.setAttribute('data-portal-for', id);

    _portalMenuEl.querySelectorAll('button').forEach(function(btn, i) {
        var original = sourceMenu.querySelectorAll('button')[i];
        if (original) {
            btn.onclick = original.onclick;
        }
    });

    getExportPortal().appendChild(_portalMenuEl);
    _activeExportDropdownId = id;

    var btnEl = dropdown.querySelector('button');
    var rect  = btnEl.getBoundingClientRect();
    var menuHeight = 0;
    _portalMenuEl.style.visibility = 'hidden';
    _portalMenuEl.style.top = '-9999px';
    document.body.offsetHeight;
    menuHeight = _portalMenuEl.offsetHeight || 80;
    _portalMenuEl.style.visibility = '';

    var spaceBelow = window.innerHeight - rect.bottom;
    _portalMenuEl.style.right = (window.innerWidth - rect.right) + 'px';
    _portalMenuEl.style.left  = 'auto';
    _portalMenuEl.style.minWidth = rect.width + 'px';

    if (spaceBelow >= menuHeight + 6) {
        _portalMenuEl.style.top    = (rect.bottom + 6) + 'px';
        _portalMenuEl.style.bottom = 'auto';
    } else {
        _portalMenuEl.style.top    = 'auto';
        _portalMenuEl.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
    }
}

function closeAllExportDropdowns() {
    if (_portalMenuEl) {
        _portalMenuEl.remove();
        _portalMenuEl = null;
    }
    _activeExportDropdownId = null;
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.export-dropdown') && !e.target.closest('#export-menu-portal')) {
        closeAllExportDropdowns();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var lb = document.getElementById('photo-lightbox');
        if (lb && lb.classList.contains('open')) closePhotoLightbox();
    }
});

var adminLogData    = [];
var adminLogFilter  = '';
var adminDateFilter = 'all';

function openAdminLogDrawer() {
    document.getElementById('admin-log-drawer').classList.add('open');
    document.getElementById('admin-log-backdrop').classList.add('open');
    fetchAdminLogs();
}

function closeAdminLogDrawer() {
    document.getElementById('admin-log-drawer').classList.remove('open');
    document.getElementById('admin-log-backdrop').classList.remove('open');
}

function setAdminLogFilter(val) {
    adminLogFilter = val;
    document.getElementById('admin-log-filter-all').classList.toggle('active',     val === '');
    document.getElementById('admin-log-filter-timein').classList.toggle('active',  val === 'time_in');
    document.getElementById('admin-log-filter-timeout').classList.toggle('active', val === 'time_out');
    renderAdminLogDrawer();
}

function toggleAdminDateDropdown() {
    var menu    = document.getElementById('admin-date-dropdown-menu');
    var chevron = document.getElementById('admin-date-dropdown-chevron');
    var isOpen  = menu.style.display !== 'none';
    menu.style.display      = isOpen ? 'none' : 'block';
    chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
}

function setAdminDateFilter(val) {
    adminDateFilter = val;
    var labels = { all: 'All Dates', today: 'Today', yesterday: 'Yesterday', week: 'This Week' };
    document.getElementById('admin-date-dropdown-label').textContent = labels[val] || 'All Dates';
    document.getElementById('admin-date-dropdown-menu').style.display = 'none';
    document.getElementById('admin-date-dropdown-chevron').style.transform = '';
    document.querySelectorAll('.addf-item').forEach(function(b) {
        b.classList.toggle('active', b.dataset.val === val);
    });
    renderAdminLogDrawer();
}

function matchesAdminDateFilter(loggedAt) {
    if (adminDateFilter === 'all') return true;
    var d         = new Date(loggedAt);
    var now       = new Date();
    var today     = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    var yesterday = new Date(today); yesterday.setDate(today.getDate() - 1);
    var weekStart = new Date(today); weekStart.setDate(today.getDate() - today.getDay());
    if (adminDateFilter === 'today')     return d >= today;
    if (adminDateFilter === 'yesterday') return d >= yesterday && d < today;
    if (adminDateFilter === 'week')      return d >= weekStart;
    return true;
}

async function fetchAdminLogs() {
    document.getElementById('admin-log-list').innerHTML = '<div class="tad-empty">Loading...</div>';
    try {
        var res = await fetch('/tenant-logs', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
        adminLogData = await res.json();
        renderAdminLogDrawer();
    } catch(e) {
        document.getElementById('admin-log-list').innerHTML = '<div class="tad-empty">Failed to load logs.</div>';
    }
}

function renderAdminLogDrawer() {
    var q    = document.getElementById('admin-log-search').value.toLowerCase();
    var data = adminLogData.filter(function(l) {
        var matchFilter = adminLogFilter === '' || l.action === adminLogFilter;
        var matchDate   = matchesAdminDateFilter(l.logged_at);
        var matchSearch = !q
            || (l.first_name + ' ' + l.last_name).toLowerCase().indexOf(q) !== -1
            || (l.room_number || '').toLowerCase().indexOf(q) !== -1
            || (l.account_id  || '').toLowerCase().indexOf(q) !== -1;
        return matchFilter && matchDate && matchSearch;
    });
    document.getElementById('admin-log-count-label').textContent = data.length + ' record' + (data.length !== 1 ? 's' : '');
    var list = document.getElementById('admin-log-list');
    if (data.length === 0) {
        list.innerHTML = '<div class="tad-empty"><img class="tad-empty-icon" src="{{ asset("icons/tenants.png") }}" alt="">No log records found.</div>';
        return;
    }
    var inSvg  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>';
    var outSvg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b0163a" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>';
    var grouped = {};
    var order   = [];
    data.forEach(function(l) {
        var dt  = new Date(l.logged_at);
        var key = dt.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
        if (!grouped[key]) { grouped[key] = []; order.push(key); }
        grouped[key].push(l);
    });
    var today     = new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    var yesterday = new Date(Date.now() - 86400000).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    var html = '';
    var globalIdx = 0;
    order.forEach(function(dateKey) {
        var label    = dateKey === today ? 'Today' : dateKey === yesterday ? 'Yesterday' : dateKey;
        var inCount  = grouped[dateKey].filter(function(l) { return l.action === 'time_in'; }).length;
        var outCount = grouped[dateKey].filter(function(l) { return l.action === 'time_out'; }).length;
        html += '<div style="position:sticky;top:0;z-index:10;background:var(--soft-bg);padding:.55rem 0 .4rem;margin-bottom:.3rem;">'
            + '<div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">'
                + '<div style="display:flex;align-items:center;gap:.5rem;">'
                    + '<span style="display:inline-block;width:3px;height:13px;background:var(--gradient-pink);border-radius:2px;flex-shrink:0;"></span>'
                    + '<span style="font-size:.72rem;font-weight:800;color:var(--ink);letter-spacing:-.01em;">' + label + '</span>'
                + '</div>'
                + '<div style="display:flex;align-items:center;gap:.35rem;">'
                    + (inCount  ? '<span style="font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:#e8faf5;color:#1f9d69;border:1px solid #8ce0bb;">' + inCount  + ' in</span>'  : '')
                    + (outCount ? '<span style="font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:#fff0f4;color:#b0163a;border:1px solid #ffc2d1;">' + outCount + ' out</span>' : '')
                + '</div>'
            + '</div>'
        + '</div>';
        grouped[dateKey].forEach(function(l) {
            var isIn      = l.action === 'time_in';
            var roomLabel = (l.floor && l.room_number)
                ? 'Floor ' + l.floor + ' \u00b7 Rm ' + l.room_number
                : (l.room_number ? 'Rm ' + l.room_number : 'No room');
            var timeOnly  = new Date(l.logged_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            html += '<div class="log-card" style="animation-delay:' + (globalIdx * 0.02) + 's;margin-bottom:.5rem;">'
                + '<div class="log-action-icon ' + (isIn ? 'in' : 'out') + '">' + (isIn ? inSvg : outSvg) + '</div>'
                + '<div class="log-info">'
                    + '<div class="log-name">' + l.first_name + ' ' + l.last_name + '</div>'
                    + '<div class="log-meta">' + roomLabel + ' &nbsp;&middot;&nbsp; '
                        + '<span class="tad-pill ' + (isIn ? 'tad-pill-timein' : 'tad-pill-timeout') + '" style="font-size:.65rem;">' + (isIn ? 'Time In' : 'Time Out') + '</span>'
                    + '</div>'
                + '</div>'
                + '<div class="log-time-col">' + timeOnly + '<br><span style="font-size:.65rem;color:var(--ink-muted);">' + (l.logged_by || '') + '</span></div>'
            + '</div>';
            globalIdx++;
        });
    });
    list.innerHTML = html;
}

function updateFormProgress(formId, fields) {
    var filled = fields.filter(function(f) {
        var el = document.getElementById(f);
        return el && el.value && el.value.trim() !== '';
    }).length;
    var total  = fields.length;
    var pct    = total > 0 ? Math.round((filled / total) * 100) : 0;
    var fill   = document.getElementById(formId + '-fill');
    var text   = document.getElementById(formId + '-text');
    var count  = document.getElementById(formId + '-count');
    if (!fill || !text || !count) return;
    fill.style.width = pct + '%';
    if (pct === 100) {
        fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
        text.textContent = 'All required fields filled';
        text.className = 'ready';
        count.textContent = filled + '/' + total;
        count.className = 'ready';
    } else if (pct >= 50) {
        fill.style.background = 'var(--gradient-pink)';
        text.textContent = 'Almost there';
        text.className = 'partial';
        count.textContent = filled + '/' + total;
        count.className = 'partial';
    } else {
        fill.style.background = 'var(--gradient-pink)';
        text.textContent = 'Fill in required fields';
        text.className = '';
        count.textContent = filled + '/' + total;
        count.className = '';
    }
}

function attachAddModalProgress() {
    var step1Fields = ['add-modal input[name="first_name"]', 'add-modal input[name="last_name"]', 'add-email'];
    var step2Fields = ['add-stay-type-select', 'add-move-in-date'];

    function getStep1Vals() {
        var fn = document.querySelector('#add-modal input[name="first_name"]');
        var ln = document.querySelector('#add-modal input[name="last_name"]');
        var em = document.getElementById('add-email');
        var co = document.getElementById('add-contact');
        return [fn, ln, em, co].filter(Boolean);
    }

    function getStep2Vals() {
        return [
            document.getElementById('add-stay-type-select'),
            document.getElementById('add-move-in-date')
        ].filter(Boolean);
    }

    function refreshProgress() {
        if (addCurrentStep === 1) {
            var els    = getStep1Vals();
            var filled = els.filter(function(e) { return e.value && e.value.trim() !== ''; }).length;
            var total  = els.length;
            var pct    = total > 0 ? Math.round((filled / total) * 100) : 0;
            var fill   = document.getElementById('add-progress-fill');
            var text   = document.getElementById('add-progress-text');
            var count  = document.getElementById('add-progress-count');
            if (!fill) return;
            fill.style.width = pct + '%';
            if (pct === 100) {
                fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
                if (text) { text.textContent = 'Step 1 complete'; text.className = 'ready'; }
                if (count) { count.textContent = filled + '/' + total; count.className = 'ready'; }
            } else {
                fill.style.background = 'var(--gradient-pink)';
                if (text) { text.textContent = 'Fill in required fields'; text.className = ''; }
                if (count) { count.textContent = filled + '/' + total; count.className = 'partial'; }
            }
        } else {
            var mode   = document.getElementById('add-mode-input') ? document.getElementById('add-mode-input').value : 'moved_in';
            var st     = document.getElementById('add-stay-type-select');
            var mi     = document.getElementById('add-move-in-date');
            var est    = document.getElementById('add-estimated-move-in');
            var checkEls = [st];
            if (mode === 'moved_in') {
                checkEls.push(mi);
            } else {
                checkEls.push(est);
            }
            var filled2 = checkEls.filter(function(e) { return e && e.value && e.value.trim() !== ''; }).length;
            var total2  = checkEls.length;
            var pct2    = total2 > 0 ? Math.round((filled2 / total2) * 100) : 0;
            var fill2   = document.getElementById('add-progress-fill');
            var text2   = document.getElementById('add-progress-text');
            var count2  = document.getElementById('add-progress-count');
            if (!fill2) return;
            fill2.style.width = pct2 + '%';
            if (pct2 === 100) {
                fill2.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
                if (text2) { text2.textContent = 'Step 2 complete'; text2.className = 'ready'; }
                if (count2) { count2.textContent = filled2 + '/' + total2; count2.className = 'ready'; }
            } else {
                fill2.style.background = 'var(--gradient-pink)';
                if (text2) { text2.textContent = 'Fill in required fields'; text2.className = ''; }
                if (count2) { count2.textContent = filled2 + '/' + total2; count2.className = 'partial'; }
            }
        }
    }

    var addModal = document.getElementById('add-modal');
    if (!addModal) return;
    addModal.addEventListener('input', refreshProgress);
    addModal.addEventListener('change', refreshProgress);

    var origGoAddStep = window.goAddStep;
    window.goAddStep = function(step) {
        origGoAddStep(step);
        setTimeout(refreshProgress, 50);
    };

    var origSetAddMode = window.setAddMode;
    window.setAddMode = function(mode) {
        origSetAddMode(mode);
        setTimeout(refreshProgress, 50);
    };

    refreshProgress();
}

function attachEditModalProgress() {
    var fields = ['edit-first-name', 'edit-last-name', 'edit-email', 'edit-contact'];

    function refreshEditProgress() {
        var filled = fields.filter(function(id) {
            var el = document.getElementById(id);
            return el && el.value && el.value.trim() !== '';
        }).length;
        var total = fields.length;
        var pct   = total > 0 ? Math.round((filled / total) * 100) : 0;
        var fill  = document.getElementById('edit-progress-fill');
        var text  = document.getElementById('edit-progress-text');
        var count = document.getElementById('edit-progress-count');
        if (!fill) return;
        fill.style.width = pct + '%';
        if (pct === 100) {
            fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
            if (text)  { text.textContent = 'Required fields complete'; text.className = 'ready'; }
            if (count) { count.textContent = filled + '/' + total; count.className = 'ready'; }
        } else {
            fill.style.background = 'var(--gradient-pink)';
            if (text)  { text.textContent = 'Fill in required fields'; text.className = ''; }
            if (count) { count.textContent = filled + '/' + total; count.className = 'partial'; }
        }
    }

    var editModal = document.getElementById('edit-modal');
    if (!editModal) return;
    editModal.addEventListener('input', refreshEditProgress);
    editModal.addEventListener('change', refreshEditProgress);
    refreshEditProgress();

    var origOpenEditModal = window.openEditModal;
    window.openEditModal = function(t) {
        origOpenEditModal(t);
        setTimeout(refreshEditProgress, 80);
    };
}

function attachAddRoomProgress() {
    var fields = ['ar-number', 'ar-capacity'];

    function refreshArProgress() {
        var filled = fields.filter(function(id) {
            var el = document.getElementById(id);
            return el && el.value && el.value.trim() !== '';
        }).length;
        var total = fields.length;
        var pct   = total > 0 ? Math.round((filled / total) * 100) : 0;
        var fill  = document.getElementById('ar-progress-fill');
        var text  = document.getElementById('ar-progress-text');
        var count = document.getElementById('ar-progress-count');
        if (!fill) return;
        fill.style.width = pct + '%';
        if (pct === 100) {
            fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
            if (text)  { text.textContent = 'Required fields complete'; text.className = 'ready'; }
            if (count) { count.textContent = filled + '/' + total; count.className = 'ready'; }
        } else {
            fill.style.background = 'var(--gradient-pink)';
            if (text)  { text.textContent = 'Fill in required fields'; text.className = ''; }
            if (count) { count.textContent = filled + '/' + total; count.className = 'partial'; }
        }
    }

    var arModal = document.getElementById('add-room-modal');
    if (!arModal) return;
    arModal.addEventListener('input', refreshArProgress);
    arModal.addEventListener('change', refreshArProgress);

    var origOpenAddRoomModal = window.openAddRoomModal;
    window.openAddRoomModal = function() {
        origOpenAddRoomModal();
        setTimeout(refreshArProgress, 50);
    };
}

function attachRenewProgress() {
    var fields = ['renew-move-in', 'renew-move-out'];

    function refreshRenewProgress() {
        var filled = fields.filter(function(id) {
            var el = document.getElementById(id);
            return el && el.value && el.value.trim() !== '';
        }).length;
        var total = fields.length;
        var pct   = total > 0 ? Math.round((filled / total) * 100) : 0;
        var fill  = document.getElementById('renew-progress-fill');
        var text  = document.getElementById('renew-progress-text');
        var count = document.getElementById('renew-progress-count');
        if (!fill) return;
        fill.style.width = pct + '%';
        if (pct === 100) {
            fill.style.background = 'linear-gradient(90deg,#1f9d69,#4ecb8d)';
            if (text)  { text.textContent = 'Required fields complete'; text.className = 'ready'; }
            if (count) { count.textContent = filled + '/' + total; count.className = 'ready'; }
        } else {
            fill.style.background = 'var(--gradient-pink)';
            if (text)  { text.textContent = 'Fill in required fields'; text.className = ''; }
            if (count) { count.textContent = filled + '/' + total; count.className = 'partial'; }
        }
    }

    var renewModal = document.getElementById('renew-modal');
    if (!renewModal) return;
    renewModal.addEventListener('input', refreshRenewProgress);
    renewModal.addEventListener('change', refreshRenewProgress);

    var origOpenRenewModal = window.openRenewModal;
    window.openRenewModal = function(id, name, roomNumber, stayType) {
        origOpenRenewModal(id, name, roomNumber, stayType);
        setTimeout(refreshRenewProgress, 80);
    };
}

document.addEventListener('DOMContentLoaded', function() {
    attachAddModalProgress();
    attachEditModalProgress();
    attachAddRoomProgress();
    attachRenewProgress();
});

function exportAdminLog(format) {
    var q    = document.getElementById('admin-log-search').value.toLowerCase();
    var data = adminLogData.filter(function(l) {
        var matchFilter = adminLogFilter === '' || l.action === adminLogFilter;
        var matchDate   = matchesAdminDateFilter(l.logged_at);
        var matchSearch = !q
            || (l.first_name + ' ' + l.last_name).toLowerCase().indexOf(q) !== -1
            || (l.room_number || '').toLowerCase().indexOf(q) !== -1;
        return matchFilter && matchDate && matchSearch;
    });

    if (format === 'pdf') {
        var win = window.open('', '_blank');
        var actionLabel = { '': 'All', 'time_in': 'Time In', 'time_out': 'Time Out' };
        var dateLabel   = { all: 'All Dates', today: 'Today', yesterday: 'Yesterday', week: 'This Week' };
        var subtitle    = 'Filter: ' + (actionLabel[adminLogFilter] || 'All') + '  \u2022  Date: ' + (dateLabel[adminDateFilter] || 'All Dates');
        var rows = data.map(function(l) {
            var isIn = l.action === 'time_in';
            return '<tr>'
                + '<td>' + l.first_name + ' ' + l.last_name + '</td>'
                + '<td>' + (l.account_id || '') + '</td>'
                + '<td>' + (l.floor ? 'Floor ' + l.floor : '') + '</td>'
                + '<td>' + (l.room_number || '') + '</td>'
                + '<td style="color:' + (isIn ? '#1f9d69' : '#b0163a') + ';font-weight:700;">' + (isIn ? 'Time In' : 'Time Out') + '</td>'
                + '<td>' + (l.logged_at ? new Date(l.logged_at).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }) : '') + '</td>'
                + '</tr>';
        }).join('');
        var dateLabelMap = { all: 'All Dates', today: 'Today', yesterday: 'Yesterday', week: 'This Week' };
        var subtitle  = 'Filter: ' + (actionLabel[adminLogFilter] || 'All') + '  &nbsp;&bull;&nbsp;  Date: ' + (dateLabelMap[adminDateFilter] || 'All Dates');
        win.document.write('<!DOCTYPE html><html><head><title>Entry / Exit Log</title>'
            + '<style>'
            + 'body{font-family:sans-serif;font-size:12px;padding:24px;color:#1a1a2e}'
            + 'h2{color:#E8175D;margin:0 0 2px;font-size:16px}'
            + '.sub{color:#888;font-size:11px;margin-bottom:4px}'
            + '.meta{color:#b06080;font-size:10px;margin-bottom:16px}'
            + 'table{width:100%;border-collapse:collapse}'
            + 'thead tr{background:#fce8f1}'
            + 'th{padding:8px 10px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#E8175D;letter-spacing:.04em}'
            + 'td{padding:7px 10px;border-bottom:1px solid #fce4ec;font-size:11px}'
            + 'tbody tr:nth-child(even){background:#fff8fb}'
            + '</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<div class="sub">Entry / Exit Log</div>'
            + '<div class="meta">' + subtitle + ' &nbsp;&bull;&nbsp; Exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</div>'
            + '<table><thead><tr>'
            + '<th>Name</th><th>Account ID</th><th>Floor</th><th>Room</th><th>Action</th><th>Date / Time</th>'
            + '</tr></thead><tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
        return;
    }

    var rows = [['Name', 'Account ID', 'Floor', 'Room', 'Action', 'Logged At']];
    data.forEach(function(l) {
        rows.push([l.first_name + ' ' + l.last_name, l.account_id || '', l.floor || '', l.room_number || '', l.action, l.logged_at || '']);
    });
    var csv = rows.map(function(r) { return r.map(function(v) { return '"' + String(v).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
    var a   = document.createElement('a');
    a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'tenant-entry-exit-log.csv';
    a.click();
}

function exportRoomsCSV() {
    var data = roomsData;
    if (!data || !data.length) { showToast('No room data to export.', 'error'); return; }
    var tenantsByRoom = {};
    tenants.forEach(function(t) {
        if (!t.room_number || t.status === 'inactive' || t.status === 'move_out') return;
        if (!tenantsByRoom[t.room_number]) tenantsByRoom[t.room_number] = [];
        tenantsByRoom[t.room_number].push(t.first_name + ' ' + t.last_name + ' (' + t.status + ')');
    });
    var rows = [['Room No.', 'Floor', 'Type', 'Capacity', 'Occupied', 'Available', 'Status', 'Tenants']];
    data.forEach(function(r) {
        var occupied  = r.occupancy || 0;
        var available = r.capacity - occupied;
        var status    = !r.is_active ? 'Closed' : occupied >= r.capacity ? 'Full' : available === r.capacity ? 'Vacant' : 'Partial';
        var tenantList = (tenantsByRoom[r.room_number] || []).join('; ');
        rows.push([r.room_number, 'Floor ' + r.floor, r.stay_type, r.capacity, occupied, available, status, tenantList]);
    });
    var csv = rows.map(function(r) { return r.map(function(v) { return '"' + String(v).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
    var a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'dormease-rooms-' + new Date().toISOString().slice(0,10) + '.csv';
    a.click();
}

function exportRoomsPDF() {
    var data = roomsData;
    if (!data || !data.length) { showToast('No room data to export.', 'error'); return; }

    var tenantsByRoom = {};
    tenants.forEach(function(t) {
        if (!t.room_number || t.status === 'inactive' || t.status === 'move_out') return;
        if (!tenantsByRoom[t.room_number]) tenantsByRoom[t.room_number] = [];
        tenantsByRoom[t.room_number].push({ name: t.first_name + ' ' + t.last_name, status: t.status });
    });

    var sortedFloors = [...new Set(data.map(r => r.floor))].sort(function(a,b){return a-b;});
    var totalOcc = data.reduce(function(s,r){return s+r.occupancy;},0);
    var totalCap = data.reduce(function(s,r){return s+r.capacity;},0);
    var pct      = totalCap > 0 ? Math.round(totalOcc/totalCap*100) : 0;
    var today    = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

    var rows = sortedFloors.map(function(fl) {
        var floorRooms = data.filter(function(r){ return r.floor === fl; });
        var floorOcc   = floorRooms.reduce(function(s,r){return s+r.occupancy;},0);
        var floorCap   = floorRooms.reduce(function(s,r){return s+r.capacity;},0);
        var floorPct   = floorCap > 0 ? Math.round(floorOcc/floorCap*100) : 0;

        var cards = floorRooms.map(function(r) {
            var occ       = r.occupancy || 0;
            var isFull    = occ >= r.capacity;
            var isEmpty   = occ === 0;
            var slotsLeft = r.capacity - occ;
            var roomPct   = r.capacity > 0 ? Math.round(occ/r.capacity*100) : 0;

            var barColor  = !r.is_active ? '#c8c8d4' : isFull ? '#e04867' : roomPct >= 75 ? '#f59e0b' : '#1f9d69';
            var statusLabel = !r.is_active ? 'Closed' : isFull ? 'Full' : isEmpty ? 'Vacant' : 'Active';
            var statusBg    = !r.is_active ? '#f3f4f6' : isFull ? '#fff0f0' : isEmpty ? '#e8faf5' : '#e8faf5';
            var statusColor = !r.is_active ? '#888'    : isFull ? '#e04867' : isEmpty ? '#1f9d69' : '#1f9d69';
            var statusBorder= !r.is_active ? '#d0d0d8' : isFull ? '#ffb3c0' : isEmpty ? '#8ce0bb' : '#8ce0bb';

            var tenantList = tenantsByRoom[r.room_number] || [];
            var tenantRows = tenantList.length === 0
                ? '<div style="font-size:10px;color:#aaa;font-style:italic;padding:4px 0;">No tenants assigned</div>'
                : tenantList.map(function(t) {
                    var sc = t.status === 'active' ? '#1f9d69' : t.status === 'reserved' ? '#9a6200' : '#888';
                    return '<div style="display:flex;align-items:center;justify-content:space-between;padding:3px 0;border-bottom:1px solid #fce8f1;font-size:10px;">'
                        + '<span style="color:#3a0e22;font-weight:600;">\u2022 ' + t.name + '</span>'
                        + '<span style="color:' + sc + ';font-weight:700;font-size:9px;text-transform:uppercase;letter-spacing:.03em;">' + t.status + '</span>'
                        + '</div>';
                }).join('');

            var barW = Math.max(roomPct, 0);

            return '<div style="background:#fff;border:1.5px solid #f4b8d0;border-radius:10px;padding:10px 12px;break-inside:avoid;">'
                + '<div style="height:3px;background:' + barColor + ';border-radius:3px 3px 0 0;margin:-10px -12px 8px;"></div>'
                + '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">'
                    + '<span style="font-size:13px;font-weight:800;color:#1a1a2e;">Rm. ' + r.room_number + '</span>'
                    + '<span style="font-size:9px;font-weight:700;padding:2px 7px;border-radius:99px;background:' + statusBg + ';color:' + statusColor + ';border:1px solid ' + statusBorder + ';">' + statusLabel + '</span>'
                + '</div>'
                + '<div style="font-size:9.5px;color:#888;margin-bottom:6px;">' + r.stay_type + ' &nbsp;&middot;&nbsp; Floor ' + r.floor + '</div>'
                + '<div style="background:#f0e0e8;border-radius:3px;height:4px;margin-bottom:5px;">'
                    + '<div style="height:4px;width:' + barW + '%;background:' + barColor + ';border-radius:3px;min-width:' + (occ > 0 ? '4' : '0') + 'px;"></div>'
                + '</div>'
                + '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">'
                    + '<span style="font-size:10px;font-weight:700;color:' + barColor + ';">' + occ + '/' + r.capacity + ' occupied</span>'
                    + '<span style="font-size:9.5px;color:#888;">' + (isFull ? 'No slots free' : slotsLeft + ' slot' + (slotsLeft !== 1 ? 's' : '') + ' free') + '</span>'
                + '</div>'
                + '<div style="background:#fff5f9;border-radius:6px;padding:5px 7px;">' + tenantRows + '</div>'
                + '</div>';
        }).join('');

        return '<div style="margin-bottom:20px;">'
            + '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;padding-bottom:6px;border-bottom:2px solid #fce8f1;">'
                + '<div style="display:flex;align-items:center;gap:8px;">'
                    + '<div style="width:3px;height:16px;background:#E8175D;border-radius:2px;"></div>'
                    + '<span style="font-size:12px;font-weight:800;color:#E8175D;text-transform:uppercase;letter-spacing:.08em;">Floor ' + fl + '</span>'
                + '</div>'
                + '<span style="font-size:10px;font-weight:700;color:#888;">' + floorOcc + '/' + floorCap + ' occupied &nbsp;&middot;&nbsp; ' + floorPct + '%</span>'
            + '</div>'
            + '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">' + cards + '</div>'
            + '</div>';
    }).join('');

    var win = window.open('', '_blank');
    win.document.write('<!DOCTYPE html><html><head><title>Room Overview</title>'
        + '<style>'
        + 'body{font-family:"Segoe UI",Arial,sans-serif;margin:0;padding:0;background:#fff;-webkit-print-color-adjust:exact;print-color-adjust:exact;}'
        + '.header{background:#E8175D;color:#fff;padding:18px 24px 14px;}'
        + '.header h1{margin:0 0 3px;font-size:16px;font-weight:800;letter-spacing:-.01em;}'
        + '.header p{margin:0;font-size:10.5px;opacity:.82;}'
        + '.summary-bar{display:flex;gap:16px;padding:10px 24px;background:#fff5f9;border-bottom:1.5px solid #fce8f1;}'
        + '.summary-item{display:flex;flex-direction:column;gap:1px;}'
        + '.summary-item .val{font-size:16px;font-weight:800;color:#E8175D;line-height:1;}'
        + '.summary-item .lbl{font-size:9px;font-weight:700;color:#b06080;text-transform:uppercase;letter-spacing:.05em;}'
        + '.content{padding:18px 24px;}'
        + '@media print{body{padding:0;}.header{-webkit-print-color-adjust:exact;print-color-adjust:exact;}}'
        + '</style>'
        + '</head><body>'
        + '<div class="header">'
            + '<h1>Sanctissimo Rosario Ladies Dormitory</h1>'
            + '<p>Room Overview &nbsp;&middot;&nbsp; Exported ' + today + '</p>'
        + '</div>'
        + '<div class="summary-bar">'
            + '<div class="summary-item"><div class="val">' + data.length + '</div><div class="lbl">Total Rooms</div></div>'
            + '<div class="summary-item"><div class="val">' + totalOcc + '</div><div class="lbl">Occupied Slots</div></div>'
            + '<div class="summary-item"><div class="val">' + (totalCap - totalOcc) + '</div><div class="lbl">Available Slots</div></div>'
            + '<div class="summary-item"><div class="val">' + pct + '%</div><div class="lbl">Occupancy Rate</div></div>'
            + '<div class="summary-item"><div class="val">' + data.filter(function(r){return r.is_active && r.occupancy >= r.capacity;}).length + '</div><div class="lbl">Full Rooms</div></div>'
            + '<div class="summary-item"><div class="val">' + data.filter(function(r){return !r.is_active;}).length + '</div><div class="lbl">Closed Rooms</div></div>'
        + '</div>'
        + '<div class="content">' + rows + '</div>'
        + '</body></html>');
    win.document.close();
    win.print();
}

function fmtDateTime(d) {
    if (!d) return '\u2014';
    var dt = new Date(d);
    return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
        + ' ' + dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
}

var _moveOutPendingSubmit = false;
var _moveOutBillsCache    = null;
var _moveOutTenantCache   = null;

function interceptMoveOut(e) {
    var statusSel = document.getElementById('edit-status');
    if (!statusSel || statusSel.value !== 'move_out') {
        return validateEditTenantForm(e);
    }
    if (_moveOutPendingSubmit) {
        _moveOutPendingSubmit = false;
        return validateEditTenantForm(e);
    }
    e.preventDefault();
    if (!validateEditTenantForm({ preventDefault: function() {} })) {
        return false;
    }
    openMoveOutVerify();
    return false;
}

function openMoveOutVerify() {
    if (!currentTenant) return;
    var t         = currentTenant;
    var bills     = billingData[String(t.tenant_id)] || [];
    var unpaid    = Array.isArray(bills) ? bills.filter(function(b) { return b.payment_status === 'unpaid' || b.payment_status === 'overdue'; }) : [];
    _moveOutBillsCache  = unpaid;
    _moveOutTenantCache = t;

    var initials = (t.first_name.charAt(0) + t.last_name.charAt(0)).toUpperCase();
    document.getElementById('moveout-verify-avatar').textContent = initials;
    document.getElementById('moveout-verify-name').textContent   = t.first_name + ' ' + t.last_name;

    var roomLabel = (t.floor && t.room_number) ? 'Floor ' + t.floor + ', Rm. ' + t.room_number : (t.room_number ? 'Rm. ' + t.room_number : 'No room assigned');
    document.getElementById('moveout-verify-meta').textContent = roomLabel + (t.stay_type ? ' \u00b7 ' + t.stay_type : '');

    var moveoutVal = document.getElementById('edit-moveout').value;
    var datePill   = document.getElementById('moveout-verify-date-pill');
    if (moveoutVal) {
        datePill.textContent  = 'Move out: ' + fmtDate(moveoutVal);
        datePill.style.display = '';
    } else {
        datePill.style.display = 'none';
    }

    var billsSection = document.getElementById('moveout-bills-section');
    var clearSection = document.getElementById('moveout-clear-section');
    var printBtn     = document.getElementById('moveout-print-btn');

    if (unpaid.length > 0) {
        billsSection.style.display = '';
        clearSection.style.display = 'none';
        printBtn.style.display     = '';

        document.getElementById('moveout-bills-count-pill').textContent = unpaid.length + ' bill' + (unpaid.length !== 1 ? 's' : '');

        var total = unpaid.reduce(function(s, b) { return s + parseFloat(b.room_share || 0); }, 0);
        document.getElementById('moveout-bills-total').textContent = '\u20b1' + total.toFixed(2);

        var listEl = document.getElementById('moveout-bills-list');
        listEl.innerHTML = unpaid.map(function(b) {
            var isOverdue  = b.payment_status === 'overdue';
            var badgeBg    = isOverdue ? '#fff0f0' : '#fff9e6';
            var badgeColor = isOverdue ? '#e04867' : '#c8960c';
            var badgeBorder= isOverdue ? 'var(--pink-200)' : '#f0c040';
            var badgeText  = isOverdue ? 'Overdue' : 'Unpaid';
            var monthStr   = b.billing_month ? (function() {
                var s = String(b.billing_month).trim();
                if (s.length === 7) s = s + '-01';
                var dt = new Date(s + 'T00:00:00');
                return isNaN(dt.getTime()) ? b.billing_month : dt.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            })() : '\u2014';
            var dueStr     = b.due_date ? fmtDate(b.due_date) : '\u2014';
            return '<div style="display:flex;align-items:center;justify-content:space-between;padding:.6rem .85rem;border-radius:10px;background:var(--white);border:1.5px solid var(--pink-100);gap:.75rem;">'
                + '<div style="flex:1;min-width:0;">'
                    + '<div style="font-size:.82rem;font-weight:700;color:var(--ink);line-height:1.3;">' + monthStr + '</div>'
                    + '<div style="font-size:.71rem;color:var(--ink-muted);margin-top:.15rem;">Due: ' + dueStr + '</div>'
                + '</div>'
                + '<div style="display:flex;align-items:center;gap:.5rem;flex-shrink:0;">'
                    + '<span style="font-size:.65rem;font-weight:800;padding:.2rem .55rem;border-radius:99px;background:' + badgeBg + ';color:' + badgeColor + ';border:1px solid ' + badgeBorder + ';">' + badgeText + '</span>'
                    + '<span style="font-size:.88rem;font-weight:800;color:#e04867;">\u20b1' + parseFloat(b.room_share || 0).toFixed(2) + '</span>'
                + '</div>'
                + '</div>';
        }).join('');
    } else {
        billsSection.style.display = 'none';
        clearSection.style.display = '';
        printBtn.style.display     = 'none';
    }

    openModal('moveout-verify-modal');
}

function closeMoveOutVerify() {
    closeModal('moveout-verify-modal');
    _moveOutPendingSubmit = false;
}

function confirmMoveOut() {
    closeModal('moveout-verify-modal');
    _moveOutPendingSubmit = true;
    var form = document.getElementById('edit-form');
    if (form) {
        showActionLoading('Saving changes...');
        form.querySelectorAll('button[type="submit"]').forEach(function(b) { b.disabled = true; });
        form.submit();
    }
}

function printMoveOutBillSlip() {
    var t     = _moveOutTenantCache;
    var bills = _moveOutBillsCache;
    if (!t || !bills) return;
    printBillSlip(t);
}

function printBillSlip(t) {
    var tenantBills = billingData[String(t.tenant_id)] || [];
    if (!Array.isArray(tenantBills)) tenantBills = [];
    tenantBills.sort(function(a, b) { return new Date(a.billing_month) - new Date(b.billing_month); });

    var total     = tenantBills.reduce(function(s, b) { return s + parseFloat(b.room_share || 0); }, 0);
    var today     = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    var floorRoom = (t.floor && t.room_number) ? (t.floor + '-' + t.room_number) : (t.room_number || 'N/A');

    function fmtMonth(d) {
        if (!d) return '-';
        var s = String(d).trim();
        if (s.length === 7) s = s + '-01';
        var dt = new Date(s + 'T00:00:00');
        if (isNaN(dt.getTime())) return '-';
        return dt.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    }

    function fmtDateSlip(d) {
        if (!d) return '-';
        var s = String(d).trim();
        if (s.length === 7) s = s + '-01';
        var dt = new Date(s + 'T00:00:00');
        if (isNaN(dt.getTime())) return '-';
        return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    var { jsPDF } = window.jspdf;

    var rowH    = 14;
    var baseH   = 175;
    var extraH  = tenantBills.length > 0 ? tenantBills.length * rowH : 0;
    var sigH    = tenantBills.length > 0 ? 44 : 0;
    var totalH  = Math.max(148, baseH + extraH + sigH);

    var W = 80;
    var doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: [W, totalH], compress: true });
    doc.setProperties({ title: 'Bill Slip - ' + t.first_name + ' ' + t.last_name, author: 'DormEase', creator: 'DormEase' });

    var pink    = [232, 23, 93];
    var ink     = [26, 26, 46];
    var muted   = [140, 100, 120];
    var white   = [255, 255, 255];
    var petal   = [255, 243, 248];
    var border  = [244, 184, 208];
    var green   = [31, 157, 105];
    var greenBg = [232, 250, 245];
    var greenBd = [140, 224, 187];
    var warn    = [255, 249, 230];
    var warnTx  = [122, 84, 0];
    var warnBd  = [240, 192, 64];
    var red     = [224, 72, 103];
    var redBg   = [255, 240, 244];
    var redBd   = [255, 194, 209];
    var amber   = [240, 165, 0];
    var amberBg = [255, 251, 240];
    var amberBd = [240, 192, 64];

    doc.setFillColor(pink[0], pink[1], pink[2]);
    doc.rect(0, 0, W, 28, 'F');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(5.5);
    doc.setTextColor(white[0], white[1], white[2]);
    doc.text('SANCTISSIMO ROSARIO LADIES DORMITORY', W / 2, 8, { align: 'center' });

    doc.setFontSize(11);
    doc.text('Outstanding Bill Slip', W / 2, 15, { align: 'center' });

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6.5);
    doc.setTextColor(255, 210, 230);
    doc.text('DormEase Billing System', W / 2, 21.5, { align: 'center' });

    var y = 33;

    doc.setFillColor(petal[0], petal[1], petal[2]);
    doc.setDrawColor(border[0], border[1], border[2]);
    doc.setLineWidth(0.4);
    doc.roundedRect(6, y, W - 12, 22, 2, 2, 'FD');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.setTextColor(ink[0], ink[1], ink[2]);
    doc.text(t.first_name + ' ' + t.last_name, 10, y + 6.5);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6);
    doc.setTextColor(pink[0], pink[1], pink[2]);
    doc.text('Account ID: ', 10, y + 11.5);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(ink[0], ink[1], ink[2]);
    doc.text(t.account_id || '-', 10 + doc.getTextWidth('Account ID: '), y + 11.5);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6);
    doc.setTextColor(pink[0], pink[1], pink[2]);
    doc.text('Room: ', 10, y + 15.5);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(ink[0], ink[1], ink[2]);
    doc.text(floorRoom + (t.stay_type ? '  \u00b7  ' + t.stay_type : ''), 10 + doc.getTextWidth('Room: '), y + 15.5);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6);
    doc.setTextColor(pink[0], pink[1], pink[2]);
    doc.text('Status: ', 10, y + 19.5);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(ink[0], ink[1], ink[2]);
    doc.text(t.status ? t.status.charAt(0).toUpperCase() + t.status.slice(1) : '-', 10 + doc.getTextWidth('Status: '), y + 19.5);

    y += 27;

    if (tenantBills.length === 0) {
        doc.setFillColor(greenBg[0], greenBg[1], greenBg[2]);
        doc.setDrawColor(greenBd[0], greenBd[1], greenBd[2]);
        doc.setLineWidth(0.4);
        doc.roundedRect(6, y, W - 12, 18, 2, 2, 'FD');

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(9);
        doc.setTextColor(green[0], green[1], green[2]);
        doc.text('No Outstanding Balance', W / 2, y + 8, { align: 'center' });

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(6.5);
        doc.setTextColor(green[0], green[1], green[2]);
        doc.text('All bills have been settled.', W / 2, y + 13, { align: 'center' });

        y += 23;
    } else {
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(5.5);
        doc.setTextColor(pink[0], pink[1], pink[2]);
        doc.text('UNPAID / OVERDUE BILLS', 6, y);

        y += 2.5;

        doc.setDrawColor(border[0], border[1], border[2]);
        doc.setLineWidth(0.3);
        doc.line(6, y, W - 6, y);

        y += 3;

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(5.5);
        doc.setTextColor(pink[0], pink[1], pink[2]);
        doc.text('Billing Period', 6, y);
        doc.text('Due Date', 43, y);
        doc.text('Amount', W - 6, y, { align: 'right' });

        y += 1.5;
        doc.setDrawColor(border[0], border[1], border[2]);
        doc.setLineWidth(0.3);
        doc.line(6, y, W - 6, y);

        tenantBills.forEach(function(b, i) {
            var isOD     = b.payment_status === 'overdue';
            var rowBg    = i % 2 === 0 ? petal : white;
            var badgeBg  = isOD ? redBg : amberBg;
            var badgeBd  = isOD ? redBd : amberBd;
            var badgeTx  = isOD ? red : [200, 150, 12];
            var badgeLbl = isOD ? 'Overdue' : 'Unpaid';

            y += 1;
            doc.setFillColor(rowBg[0], rowBg[1], rowBg[2]);
            doc.rect(6, y, W - 12, rowH - 2, 'F');

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(7);
            doc.setTextColor(ink[0], ink[1], ink[2]);
            doc.text(fmtMonth(b.billing_month), 7, y + 5);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(4.8);
            var badgeTextW = doc.getTextWidth(badgeLbl);
            var badgeW     = badgeTextW + 3;
            doc.setFillColor(badgeBg[0], badgeBg[1], badgeBg[2]);
            doc.setDrawColor(badgeBd[0], badgeBd[1], badgeBd[2]);
            doc.setLineWidth(0.3);
            doc.roundedRect(7, y + 6.3, badgeW, 3.8, 1, 1, 'FD');
            doc.setTextColor(badgeTx[0], badgeTx[1], badgeTx[2]);
            doc.text(badgeLbl, 7 + (badgeW / 2), y + 9, { align: 'center' });

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(6.5);
            doc.setTextColor(muted[0], muted[1], muted[2]);
            doc.text(fmtDateSlip(b.due_date), 43, y + 5);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(7);
            doc.setTextColor(red[0], red[1], red[2]);
            doc.text('PHP ' + parseFloat(b.room_share || 0).toFixed(2), W - 7, y + 5.4, { align: 'right' });

            y += rowH;

            doc.setDrawColor(border[0], border[1], border[2]);
            doc.setLineWidth(0.2);
            doc.line(6, y - 1, W - 6, y - 1);
        });

        y += 2;

        doc.setFillColor(pink[0], pink[1], pink[2]);
        doc.roundedRect(6, y, W - 12, 12, 2, 2, 'F');

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(6.5);
        doc.setTextColor(255, 220, 235);
        doc.text('Total Outstanding', 10, y + 7.5);

        doc.setFontSize(9.5);
        doc.setTextColor(white[0], white[1], white[2]);
        doc.text('PHP ' + total.toFixed(2), W - 9, y + 7.8, { align: 'right' });

        y += 17;

        doc.setFillColor(warn[0], warn[1], warn[2]);
        doc.setDrawColor(warnBd[0], warnBd[1], warnBd[2]);
        doc.setLineWidth(0.3);
        doc.roundedRect(6, y, W - 12, 14, 1.8, 1.8, 'FD');

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(5.8);
        doc.setTextColor(warnTx[0], warnTx[1], warnTx[2]);
        var warnLines = doc.splitTextToSize('Please settle your outstanding balance at the admin office. Bring this slip as reference.', W - 16);
        doc.text(warnLines, 9, y + 5, { lineHeightFactor: 1.6 });

        y += 19;

        doc.setDrawColor(border[0], border[1], border[2]);
        doc.setLineWidth(0.3);
        doc.setLineDash([1.5, 1.5]);
        doc.line(6, y, W - 6, y);
        y += 8;
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(5.5);
        doc.setTextColor(muted[0], muted[1], muted[2]);
        doc.text('Tenant Signature over Printed Name', W / 2, y, { align: 'center' });
        y += 14;
        doc.line(6, y, W - 6, y);
        y += 8;
        doc.text('Admin / Staff Signature & Date', W / 2, y, { align: 'center' });
        doc.setLineDash([]);

        y += 8;
    }

    doc.setDrawColor(border[0], border[1], border[2]);
    doc.setLineWidth(0.3);
    doc.line(6, y, W - 6, y);

    y += 4.5;

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(5.5);
    doc.setTextColor(muted[0], muted[1], muted[2]);
    doc.text('Issued: ' + today, 6, y);

    doc.setFont('helvetica', 'bold');
    doc.setTextColor(pink[0], pink[1], pink[2]);
    doc.text('DormEase', W - 6, y, { align: 'right' });

    var safeName = (t.first_name + '-' + t.last_name).replace(/[^a-zA-Z0-9\-]/g, '').toLowerCase();
    var blobUrl = doc.output('bloburl');
    openPdfPreview(blobUrl, 'bill-slip-' + safeName + '.pdf');
}
</script>
@endsection