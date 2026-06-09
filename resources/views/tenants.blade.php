@extends('layout')

@section('title', 'DormEase: Manage Tenants')
@section('page-title', 'Manage Tenants')

@section('styles')
<style>
.page-body {
    padding: 1.8rem 2rem;
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
th:nth-child(7), td:nth-child(7) { text-align: center; }
th:nth-child(8), td:nth-child(8) { text-align: center; }
tbody tr:hover { background: var(--soft-bg); }
.badge { display: inline-flex; align-items: center; padding: .28rem .75rem; border-radius: 999px; font-size: .75rem; font-weight: 700; }
.badge-active   { background: #e8faf5; color: #1f9d69; border: 1px solid #8ce0bb; }
.badge-pending  { background: #fff9e6; color: #c8960c; border: 1px solid #f0c040; }
.badge-inactive { background: #fff0f0; color: #e04867; border: 1px solid var(--pink-200); }
.badge-moveout  { background: var(--petal); color: var(--hot-pink); border: 1px solid #ff9db0; }
.badge-temp     { background: #fff3b0; color: #5a3d00; border: 1px solid #ffd84d; font-weight: 700; box-shadow: 0 4px 10px rgba(255,216,77,.25); }
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
    padding: .85rem 1.1rem .75rem;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1.5px solid var(--pink-100);
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
    flex: 1; overflow-y: auto; padding: .9rem 1.1rem;
    scrollbar-width: thin; scrollbar-color: var(--pink-200) transparent;
}
.modal-body::-webkit-scrollbar { width: 5px; }
.modal-body::-webkit-scrollbar-track { background: transparent; }
.modal-body::-webkit-scrollbar-thumb { background: var(--pink-200); border-radius: 99px; }
.modal-section { margin-bottom: .9rem; }
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
.modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .55rem; }
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
    padding: .7rem 1.1rem;
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
.tad-pill-moveout  { background: var(--petal); color: var(--hot-pink); border: 1px solid var(--pink-200); }
.tad-pill-inactive { background: var(--blush); color: var(--ink-muted); border: 1px solid var(--pink-100); }
.tad-card-archived { display: flex; align-items: center; gap: .4rem; margin-top: .75rem; padding-top: .6rem; border-top: 1px solid var(--pink-100); font-size: .7rem; color: var(--ink-muted); font-weight: 500; }
.tad-card-archived span { color: var(--bright-pink); font-weight: 600; }
.tad-empty { text-align: center; padding: 3rem 1rem; color: var(--ink-muted); font-size: .85rem; }
.tad-empty-icon { width: 40px; height: 40px; margin: 0 auto .75rem; opacity: .3; display: block; }
.tad-footer { padding: .9rem 1.8rem; border-top: 1px solid var(--pink-100); background: var(--white); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; flex-wrap: wrap; gap: .5rem; }
.tad-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
.tad-export-btn { display: inline-flex; align-items: center; gap: .4rem; font-size: .75rem; font-weight: 700; color: var(--bright-pink); background: var(--petal); border: 1px solid var(--pink-100); border-radius: 8px; padding: .35rem .85rem; cursor: pointer; transition: background .2s, color .2s, border-color .2s; font-family: var(--ff-body); }
.tad-export-btn:hover { background: var(--gradient-pink); color: var(--white); border-color: transparent; }
.tad-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .7; }
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
@media (max-width: 900px) { .page-body { padding: 1.2rem 1.2rem; gap: 1.2rem; } .stats-row { grid-template-columns: 1fr 1fr; } .modal-grid { grid-template-columns: 1fr; } .stat-box { padding: 1rem 1.1rem; gap: .9rem; } .stat-icon-circle { width: 44px; height: 44px; } .stat-icon-circle img { width: 22px; height: 22px; } .stat-num { font-size: 1.5rem; } }
@media (max-width: 680px) { .page-body { padding: 1rem; gap: 1rem; } .page-header h1 { font-size: 1.5rem; } .stats-row { grid-template-columns: 1fr; } .stat-box { padding: 1rem 1.2rem; } .stat-num { font-size: 1.75rem; } .table-header { padding: 1rem; flex-direction: column; align-items: flex-start; } .table-controls { width: 100%; } .search-wrap { flex: 1; } .search-wrap input { width: 100%; } .sort-select { flex: 1; min-width: 0; } .table-footer { flex-direction: column; align-items: flex-start; gap: .6rem; } .pagination { width: 100%; justify-content: center; } .btn-primary, .btn-outline { font-size: .82rem; padding: .55rem 1rem; } }
@media (max-width: 480px) { .page-body { padding: .8rem; gap: .9rem; } .page-header { gap: .6rem; } .page-header h1 { font-size: 1.3rem; } .header-actions { width: 100%; } .header-actions .btn-primary, .header-actions .btn-outline { flex: 1; justify-content: center; } .stat-box { gap: .75rem; padding: .9rem 1rem; } .stat-label { font-size: .72rem; } .stat-sub { font-size: .67rem; } .credentials-box { padding: .75rem .9rem; } .table-controls { flex-direction: column; align-items: stretch; } .search-wrap input { width: 100%; } .sort-select { width: 100%; } .tad-tabs { padding: 0 1rem; } .tad-tab { padding: .75rem .75rem; font-size: .76rem; } .modal-grid { grid-template-columns: 1fr; } .modal-footer { flex-direction: column-reverse; } .btn-cancel, .btn-submit { width: 100%; justify-content: center; } }
@media (max-width: 360px) { .stat-icon-circle { display: none; } .act-btn { width: 28px; height: 28px; } .stat-num { font-size: 1.4rem; } .stat-box { padding: .75rem; } }
@media (max-width: 768px) { .action-group { flex-direction: column; gap: .25rem; } .act-btn { width: 28px; height: 28px; } }
@media (max-width: 700px) { .tad-header { padding: 1.2rem 1rem .9rem; } .tad-list { padding: 0 1rem 1.2rem; } .tad-search-bar { padding: .8rem 1rem .6rem; } .tad-footer { padding: .75rem 1rem; } }
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
                <img src="{{ asset('icons/pending.png') }}" class="icon-md" alt="pending">
            </div>
            <div>
                <div class="stat-label">Pending Tenants</div>
                <div class="stat-num">{{ $pendingCount }}</div>
                <div class="stat-sub">Not Yet Logged In</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div>
                <div class="table-title">All Tenants</div>
                <div class="table-date" id="table-date"></div>
            </div>
            <div class="table-controls">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Search..." oninput="applyFilters()">
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
                    @for($i = 2; $i <= 5; $i++)
                    <option value="{{ $i }}">Floor {{ $i }}</option>
                    @endfor
                </select>
                <select class="sort-select" id="status-filter" onchange="applyFilters()">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>

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
                <tbody id="tenant-tbody"></tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="table-showing" id="showing-label"></div>
            <div class="pagination" id="pagination"></div>
        </div>
    </div>

</div>
@endsection

@section('modals')
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

    <div style="padding:.5rem 1.8rem;flex-shrink:0;display:flex;gap:.5rem;flex-wrap:wrap;" id="rooms-floor-filters">
        <button class="page-btn active" id="rfloor-all" onclick="setRoomFloor('')">All</button>
        <button class="page-btn" id="rfloor-2" onclick="setRoomFloor(2)">Floor 2</button>
        <button class="page-btn" id="rfloor-3" onclick="setRoomFloor(3)">Floor 3</button>
        <button class="page-btn" id="rfloor-4" onclick="setRoomFloor(4)">Floor 4</button>
        <button class="page-btn" id="rfloor-5" onclick="setRoomFloor(5)">Floor 5</button>
    </div>

    <div class="tad-list" id="rooms-list"></div>

    <div class="tad-footer">
        <div class="tad-count-label" id="rooms-count-label">0 rooms</div>
        <div style="font-size:.73rem;color:var(--ink-muted);" id="rooms-summary"></div>
    </div>
</div>

<div class="modal-overlay" id="add-room-modal">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title">Add Room</div>
            <button class="modal-close" onclick="closeModal('add-room-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Room Number</label>
                    <input type="text" id="ar-number" placeholder="e.g. 308">
                </div>
                <div class="modal-field">
                    <label>Floor</label>
                    <select id="ar-floor">
                        <option value="">Select</option>
                        <option value="2">Floor 2</option>
                        <option value="3">Floor 3</option>
                        <option value="4">Floor 4</option>
                        <option value="5">Floor 5</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Capacity (pax)</label>
                    <input type="number" id="ar-capacity" min="1" max="10" placeholder="e.g. 3">
                </div>
                <div class="modal-field">
                    <label>Stay Type</label>
                    <select id="ar-stay-type">
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
            <div class="modal-title">Edit Room</div>
            <button class="modal-close" onclick="closeModal('edit-room-modal')">&#x2715;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="er-id">
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Room Number</label>
                    <input type="text" id="er-number">
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
                    <label>Stay Type</label>
                    <select id="er-stay-type">
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

<div class="modal-overlay" id="delete-room-modal">
    <div class="modal" style="max-width:380px;">
        <div class="modal-header">
            <div class="modal-title">Delete Room</div>
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
            <div class="modal-title">Tenant Account Created</div>
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
            <button class="btn-submit" onclick="closeModal('credentials-modal')">Got it, I've noted the credentials</button>
        </div>
    </div>
</div>
@endif

@if(session('reset_account_id'))
<div class="modal-overlay open" id="reset-credentials-modal">
    <div class="modal" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-title">Password Reset Successfully</div>
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
            <button class="btn-submit" onclick="closeModal('reset-credentials-modal')">Got it, I've noted the credentials</button>
        </div>
    </div>
</div>
@endif

<div class="modal-overlay" id="add-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Add New Tenant</div>
            <button class="modal-close" onclick="closeModal('add-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('tenants.store') }}" data-loading-message="Adding tenant..." style="display:contents;">
            @csrf
            <div class="modal-body">
                <div class="modal-info-banner">
                    <span>Account ID and temporary password will be <strong>auto-generated</strong> and shown to you after saving.</span>
                </div>
                <div class="modal-section">
                    <div class="modal-section-title">Personal Information</div>
                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>First Name</label>
                            <input type="text" name="first_name" placeholder="e.g. Maria" required value="{{ old('first_name') }}" autocomplete="given-name">
                        </div>
                        <div class="modal-field">
                            <label>Last Name</label>
                            <input type="text" name="last_name" placeholder="e.g. Ramos" required value="{{ old('last_name') }}" autocomplete="family-name">
                        </div>
                        <div class="modal-field full">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="e.g. maria@email.com" required value="{{ old('email') }}" autocomplete="email">
                        </div>
                        <div class="modal-field full">
                            <label>Contact No.</label>
                            <input type="text" name="contact_number" placeholder="e.g. 0912-345-6789" value="{{ old('contact_number') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-section">
                    <div class="modal-section-title">Room &amp; Stay Details</div>
                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>Room No.</label>
                            <input type="text" id="add-room-number-input" name="room_number" placeholder="e.g. 304" value="{{ old('room_number') }}">
                        </div>
                        <div class="modal-field">
                            <label>Floor</label>
                            <select name="floor">
                                <option value="">Select floor</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>Floor {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-field full">
                            <label>Stay Type</label>
                            <select name="stay_type">
                                <option value="">Select type</option>
                                <option value="Bed Spacer" {{ old('stay_type') === 'Bed Spacer' ? 'selected' : '' }}>Bed Spacer</option>
                                <option value="Solo Room"  {{ old('stay_type') === 'Solo Room'  ? 'selected' : '' }}>Solo Room</option>
                                <option value="Shared Room"{{ old('stay_type') === 'Shared Room'? 'selected' : '' }}>Shared Room</option>
                            </select>
                        </div>
                        <div class="modal-field full">
                            <label>Move-In Date</label>
                            <input type="date" name="move_in_date" value="{{ old('move_in_date') }}">
                        </div>
                        <div class="modal-field full" id="add-room-hint-wrap" style="display:none;">
                            <div id="add-room-hint"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Add Tenant</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Tenant Details</div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div class="modal-body" id="view-content"></div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" onclick="switchToEdit()">Edit</button>
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
        <form method="POST" id="edit-form" action="" data-loading-message="Saving changes..." style="display:contents;">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="modal-section">
                    <div class="modal-section-title">Personal Information</div>
                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>First Name</label>
                            <input type="text" name="first_name" id="edit-first-name" placeholder="First name" required>
                        </div>
                        <div class="modal-field">
                            <label>Last Name</label>
                            <input type="text" name="last_name" id="edit-last-name" placeholder="Last name" required>
                        </div>
                        <div class="modal-field full">
                            <label>Email Address</label>
                            <input type="email" name="email" id="edit-email" placeholder="Email address" required>
                        </div>
                        <div class="modal-field full">
                            <label>Contact No.</label>
                            <input type="text" name="contact_number" id="edit-contact" placeholder="e.g. 0912-345-6789">
                        </div>
                    </div>
                </div>
                <div class="modal-section">
                    <div class="modal-section-title">Room &amp; Stay Details</div>
                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>Room No.</label>
                            <input type="text" name="room_number" id="edit-room" placeholder="e.g. 304">
                        </div>
                        <div class="modal-field">
                            <label>Floor</label>
                            <select name="floor" id="edit-floor">
                                <option value="">Select floor</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">Floor {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-field full">
                            <label>Stay Type</label>
                            <select name="stay_type" id="edit-stay-type">
                                <option value="">Select type</option>
                                <option value="Bed Spacer">Bed Spacer</option>
                                <option value="Solo Room">Solo Room</option>
                                <option value="Shared Room">Shared Room</option>
                            </select>
                        </div>
                        <div class="modal-field">
                            <label>Move-In Date</label>
                            <input type="date" name="move_in_date" id="edit-date">
                        </div>
                        <div class="modal-field full" id="edit-room-hint-wrap" style="display:none;">
                            <div id="edit-room-hint"></div>
                        </div>
                        <div class="modal-field">
                            <label>Move-Out Date</label>
                            <input type="date" name="move_out_date" id="edit-moveout">
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
                                <select name="status" id="edit-status" onchange="updateStatusDot(this)">
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="move_out">Move Out</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-warn-banner" style="margin-top:.8rem;">
                        <span style="font-size:1rem;flex-shrink:0;"></span>
                        <span>Setting status to <strong>Inactive</strong> will block the tenant from logging into the mobile app. Setting to <strong>Move Out</strong> saves a record to archive history.</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
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
                <button type="submit" class="btn-submit" style="background:#f0c040;color:#1a1a2e;box-shadow:0 8px 20px rgba(240,192,64,.3);">Reset Password</button>
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

@endsection

@section('scripts')
<script>
var tenants = @json($tenants);
var PER_PAGE = 8;
var currentPage = 1;
var filtered = [];
var currentTenant = null;

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
            setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
        });
    });
});

document.getElementById('table-date').textContent =
    'as of ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    if (id === 'add-modal') {
        var w = document.getElementById('add-room-hint-wrap');
        var h = document.getElementById('add-room-hint');
        if (w) w.style.display = 'none';
        if (h) h.innerHTML = '';
        document.querySelectorAll('#add-modal .btn-submit').forEach(function(b) {
            b.disabled = false; b.style.opacity = ''; b.style.cursor = ''; b.title = '';
        });
    }
    if (id === 'edit-modal') {
        var w2 = document.getElementById('edit-room-hint-wrap');
        var h2 = document.getElementById('edit-room-hint');
        if (w2) w2.style.display = 'none';
        if (h2) h2.innerHTML = '';
        document.querySelectorAll('#edit-modal .btn-submit').forEach(function(b) {
            b.disabled = false; b.style.opacity = ''; b.style.cursor = ''; b.title = '';
        });
    }
}

document.querySelectorAll('.modal-overlay').forEach(function(m) {
    m.addEventListener('click', function(e) { if (e.target === m) m.classList.remove('open'); });
});

function updateStatusDot(select) {
    var dot = document.getElementById('edit-status-dot');
    if (!dot) return;
    var colors = { active:'#1f9d69', pending:'#c8960c', move_out:'#E8175D', inactive:'#e04867' };
    dot.style.background = colors[select.value] || '#ccc';
}

function statusBadge(status) {
    var map = {
        active:   '<span class="badge badge-active">Active</span>',
        pending:  '<span class="badge badge-pending">Pending</span>',
        move_out: '<span class="badge badge-moveout">Move Out</span>',
        inactive: '<span class="badge badge-inactive">Inactive</span>',
    };
    return map[status] || ('<span class="badge badge-inactive">' + status + '</span>');
}

function tempBadge(isTemp) {
    return isTemp ? '<span class="badge badge-temp">Temp Pass</span>' : '';
}

function fmtDate(d) {
    if (!d) return '\u2014';
    return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function escapeJs(str) {
    return String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"');
}

function renderTable() {
    var start = (currentPage - 1) * PER_PAGE;
    var pageData = filtered.slice(start, start + PER_PAGE);
    var tbody = document.getElementById('tenant-tbody');
    if (pageData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ink-muted);">No tenants found.</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(function(t) {
            var floorRoom = (t.floor && t.room_number) ? (t.floor + '-' + t.room_number) : (t.room_number || '\u2014');
            var nameCell = '<div style="display:flex;flex-direction:column;align-items:center;gap:.25rem;"><span>' + t.first_name + ' ' + t.last_name + '</span>' + (t.is_temp_password ? tempBadge(true) : '') + '</div>';
            return '<tr>'
                + '<td>' + (t.account_id || '\u2014') + '</td>'
                + '<td>' + nameCell + '</td>'
                + '<td>' + floorRoom + '</td>'
                + '<td>' + fmtDate(t.move_in_date) + '</td>'
                + '<td>' + (t.move_out_date ? fmtDate(t.move_out_date) : '\u2014') + '</td>'
                + '<td>' + (t.contact_number || '\u2014') + '</td>'
                + '<td>' + statusBadge(t.status) + '</td>'
                + '<td><div class="action-group">'
                    + '<button class="act-btn" title="View" onclick=\'viewTenant(' + JSON.stringify(t) + ')\'><img src="{{ asset('icons/eye.png') }}" class="icon-sm"></button>'
                    + '<button class="act-btn" title="Edit" onclick=\'openEditModal(' + JSON.stringify(t) + ')\'><img src="{{ asset('icons/edit.png') }}" class="icon-sm"></button>'
                    + '<button class="act-btn" title="Reset Password" onclick="openResetModal(' + t.tenant_id + ', \'' + escapeJs(t.first_name + ' ' + t.last_name) + '\')"><img src="{{ asset('icons/reset.png') }}" class="icon-sm"></button>'
                    + '<button class="act-btn" title="Delete" onclick="openDeleteModal(' + t.tenant_id + ', \'' + escapeJs(t.first_name + ' ' + t.last_name) + '\')"><img src="{{ asset('icons/delete.png') }}" class="icon-sm"></button>'
                + '</div></td>'
                + '</tr>';
        }).join('');
    }
    var total = filtered.length;
    var from  = total === 0 ? 0 : start + 1;
    var to    = Math.min(start + PER_PAGE, total);
    document.getElementById('showing-label').textContent = 'Showing data ' + from + ' to ' + to + ' of ' + total + ' entries';
    renderPagination();
}

function renderPagination() {
    var totalPages = Math.ceil(filtered.length / PER_PAGE);
    var pg = document.getElementById('pagination');
    var html = '<button class="page-btn" onclick="goPage(' + (currentPage - 1) + ')" ' + (currentPage === 1 ? 'disabled' : '') + '>\u2039</button>';
    for (var i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += '<button class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goPage(' + i + ')">' + i + '</button>';
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += '<span style="color:var(--ink-muted);padding:0 .2rem">\u2026</span>';
        }
    }
    html += '<button class="page-btn" onclick="goPage(' + (currentPage + 1) + ')" ' + (currentPage === totalPages || totalPages === 0 ? 'disabled' : '') + '>\u203a</button>';
    pg.innerHTML = html;
}

function goPage(p) {
    var totalPages = Math.ceil(filtered.length / PER_PAGE);
    if (p < 1 || p > totalPages) return;
    currentPage = p;
    renderTable();
}

function applyFilters() {
    var q      = document.getElementById('search-input').value.toLowerCase();
    var sort   = document.getElementById('sort-select').value;
    var floor  = document.getElementById('floor-filter').value;
    var status = document.getElementById('status-filter').value;

    filtered = tenants.filter(function(t) {
        if (t.status === 'inactive' || t.status === 'move_out') return false;
        var matchesSearch =
            (t.first_name + ' ' + t.last_name).toLowerCase().indexOf(q) !== -1 ||
            (t.account_id  || '').toLowerCase().indexOf(q) !== -1 ||
            (t.room_number || '').toLowerCase().indexOf(q) !== -1 ||
            (t.email || '').toLowerCase().indexOf(q) !== -1 ||
            (t.contact_number || '').toLowerCase().indexOf(q) !== -1;
        var matchesFloor  = floor  === '' || String(t.floor) === floor;
        var matchesStatus = status === '' || t.status === status;
        return matchesSearch && matchesFloor && matchesStatus;
    });

    if (sort === 'newest') filtered.sort(function(a, b) { return new Date(b.created_at) - new Date(a.created_at); });
    if (sort === 'oldest') filtered.sort(function(a, b) { return new Date(a.created_at) - new Date(b.created_at); });
    if (sort === 'name')   filtered.sort(function(a, b) { return a.first_name.localeCompare(b.first_name); });
    if (sort === 'room')   filtered.sort(function(a, b) { return (a.room_number || '').localeCompare(b.room_number || ''); });
    if (sort === 'floor')  filtered.sort(function(a, b) { return parseInt(a.floor || 0) - parseInt(b.floor || 0); });

    currentPage = 1;
    renderTable();
}

function viewTenant(t) {
    currentTenant = t;
    var floorRoom = (t.floor && t.room_number) ? (t.floor + '-' + t.room_number) : (t.room_number || '\u2014');
    document.getElementById('view-content').innerHTML =
        '<div class="view-row"><span class="view-label">Account ID</span><span class="view-val" style="font-family:monospace">' + (t.account_id || '\u2014') + '</span></div>'
        + '<div class="view-row"><span class="view-label">Full Name</span><span class="view-val">' + t.first_name + ' ' + t.last_name + '</span></div>'
        + '<div class="view-row"><span class="view-label">Email</span><span class="view-val">' + t.email + '</span></div>'
        + '<div class="view-row"><span class="view-label">Contact No.</span><span class="view-val">' + (t.contact_number || '\u2014') + '</span></div>'
        + '<div class="view-row"><span class="view-label">Floor &amp; Room No.</span><span class="view-val">' + floorRoom + '</span></div>'
        + '<div class="view-row"><span class="view-label">Stay Type</span><span class="view-val">' + (t.stay_type || '\u2014') + '</span></div>'
        + '<div class="view-row"><span class="view-label">Move-In Date</span><span class="view-val">' + fmtDate(t.move_in_date) + '</span></div>'
        + '<div class="view-row"><span class="view-label">Move-Out Date</span><span class="view-val">' + fmtDate(t.move_out_date) + '</span></div>'
        + '<div class="view-row"><span class="view-label">Status</span><span class="view-val">' + statusBadge(t.status) + '</span></div>'
        + '<div class="view-row"><span class="view-label">Password Status</span><span class="view-val">' + (t.is_temp_password ? tempBadge(true) + ' Not yet changed' : 'Changed by tenant') + '</span></div>';
    openModal('view-modal');
}

function switchToEdit() {
    if (currentTenant) {
        closeModal('view-modal');
        setTimeout(function() { openEditModal(currentTenant); }, 200);
    }
}

function openEditModal(t) {
    currentTenant = t;
    document.getElementById('edit-form').action       = '/tenants/' + t.tenant_id;
    document.getElementById('edit-first-name').value  = t.first_name || '';
    document.getElementById('edit-last-name').value   = t.last_name  || '';
    document.getElementById('edit-email').value       = t.email      || '';
    document.getElementById('edit-room').value        = t.room_number || '';
    document.getElementById('edit-floor').value       = t.floor      || '';
    document.getElementById('edit-stay-type').value   = t.stay_type  || '';
    document.getElementById('edit-date').value        = t.move_in_date  || '';
    document.getElementById('edit-moveout').value     = t.move_out_date || '';
    document.getElementById('edit-contact').value     = t.contact_number || '';
    document.getElementById('edit-status').value      = t.status || 'pending';
    updateStatusDot(document.getElementById('edit-status'));
    openModal('edit-modal');
    var editRoomInput = document.getElementById('edit-room');
    if (editRoomInput && editRoomInput.value.trim()) {
        setTimeout(function() { editRoomInput.dispatchEvent(new Event('input')); }, 50);
    }
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
    var rows = [['Account ID','First Name','Last Name','Email','Room','Floor','Move-In Date','Move-Out Date','Contact','Status']];
    filtered.forEach(function(t) {
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
    var win = window.open('', '_blank');
    var rows = filtered.map(function(t) {
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
    document.addEventListener('DOMContentLoaded', function() { openModal('add-modal'); });
@endif

@if(session('success') && !session('new_account_id') && !session('reset_account_id'))
    document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });
@endif

var roomsData = [];
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

function setRoomFloor(floor) {
    roomsFloorFilter = floor;
    document.querySelectorAll('[id^="rfloor-"]').forEach(b => b.classList.remove('active'));
    document.getElementById('rfloor-' + (floor === '' ? 'all' : floor)).classList.add('active');
    renderRooms();
}

async function fetchRooms() {
    try {
        const res  = await fetch('/rooms', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
        roomsData  = await res.json();
        renderRooms();
    } catch {
        document.getElementById('rooms-list').innerHTML = '<div class="tad-empty">Failed to load rooms.</div>';
    }
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

    if (!data.length) {
        list.innerHTML = '<div class="tad-empty">No rooms found.</div>';
        return;
    }

    const floors = [...new Set(data.map(r => r.floor))].sort();

    list.innerHTML = floors.map(floor => {
        const floorRooms = data.filter(r => r.floor === floor);
        const cards = floorRooms.map(r => {
            const pct     = r.capacity > 0 ? Math.round((r.occupancy / r.capacity) * 100) : 0;
            const isFull  = r.occupancy >= r.capacity;
            const barColor= isFull ? '#e04867' : pct >= 50 ? '#f0c040' : '#1f9d69';
            const statusPill = r.is_active
                ? '<span style="font-size:.65rem;font-weight:800;background:#e8faf5;color:#1f9d69;border:1px solid #8ce0bb;border-radius:99px;padding:.1rem .45rem;">Active</span>'
                : '<span style="font-size:.65rem;font-weight:800;background:#fff0f0;color:#e04867;border:1px solid #ffc8d0;border-radius:99px;padding:.1rem .45rem;">Closed</span>';

            return `<div style="background:var(--white);border:1px solid var(--pink-100);border-radius:12px;padding:.85rem 1rem;transition:border-color .2s;" onmouseover="this.style.borderColor='var(--bright-pink)'" onmouseout="this.style.borderColor='var(--pink-100)'">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;gap:.5rem;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <span style="font-size:.9rem;font-weight:800;color:var(--ink);">Rm.${r.room_number}</span>
                        ${statusPill}
                    </div>
                    <div style="display:flex;gap:.3rem;">
                        <button class="act-btn" title="Edit" onclick='openEditRoomModal(${JSON.stringify(r)})'><img src="{{ asset('icons/edit.png') }}" class="icon-sm"></button>
                        <button class="act-btn" title="Delete" onclick="openDeleteRoomModal(${r.id}, 'Rm.${r.room_number}')"><img src="{{ asset('icons/delete.png') }}" class="icon-sm"></button>
                    </div>
                </div>
                <div style="font-size:.73rem;color:var(--ink-muted);margin-bottom:.55rem;">${r.stay_type} &nbsp;·&nbsp; ${r.capacity} pax</div>
                <div style="display:flex;align-items:center;gap:.6rem;">
                    <div style="flex:1;height:6px;background:var(--petal);border-radius:99px;overflow:hidden;">
                        <div style="height:100%;width:${pct}%;background:${barColor};border-radius:99px;transition:width .3s;"></div>
                    </div>
                    <span style="font-size:.72rem;font-weight:700;color:${isFull ? '#e04867' : 'var(--ink-muted)'};">${r.occupancy}/${r.capacity}</span>
                </div>
            </div>`;
        }).join('');

        return `<div style="margin-bottom:.25rem;">
            <div style="font-size:.7rem;font-weight:800;color:var(--bright-pink);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.5rem;padding-top:.25rem;">Floor ${floor}</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;">${cards}</div>
        </div>`;
    }).join('');
}

function openAddRoomModal() {
    document.getElementById('ar-number').value   = '';
    document.getElementById('ar-floor').value    = '';
    document.getElementById('ar-capacity').value = '';
    document.getElementById('ar-stay-type').value = 'Shared Room';
    openModal('add-room-modal');
}

async function submitAddRoom() {
    const number   = document.getElementById('ar-number').value.trim();
    const floor    = document.getElementById('ar-floor').value;
    const capacity = document.getElementById('ar-capacity').value;
    const stayType = document.getElementById('ar-stay-type').value;

    if (!number || !floor || !capacity) { showToast('Please fill in all fields.', 'error'); return; }

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

function openEditRoomModal(r) {
    document.getElementById('er-id').value        = r.id;
    document.getElementById('er-number').value    = r.room_number;
    document.getElementById('er-floor').value     = r.floor;
    document.getElementById('er-capacity').value  = r.capacity;
    document.getElementById('er-stay-type').value = r.stay_type;
    document.getElementById('er-active').value    = r.is_active ? '1' : '0';
    openModal('edit-room-modal');
}

async function submitEditRoom() {
    const id       = document.getElementById('er-id').value;
    const number   = document.getElementById('er-number').value.trim();
    const floor    = document.getElementById('er-floor').value;
    const capacity = document.getElementById('er-capacity').value;
    const stayType = document.getElementById('er-stay-type').value;
    const isActive = document.getElementById('er-active').value === '1';

    if (!number || !floor || !capacity) { showToast('Please fill in all fields.', 'error'); return; }

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

    function invalidateRoomsCache() {
        roomsCache = null;
    }

    var origFetchRooms = window.fetchRooms;
    window.fetchRooms = function() {
        invalidateRoomsCache();
        return origFetchRooms ? origFetchRooms() : undefined;
    };

    var originalSubmitAddRoom = window.submitAddRoom;
    window.submitAddRoom = function() {
        invalidateRoomsCache();
        return originalSubmitAddRoom();
    };
    var originalSubmitEditRoom = window.submitEditRoom;
    window.submitEditRoom = function() {
        invalidateRoomsCache();
        return originalSubmitEditRoom();
    };
    var originalSubmitDeleteRoom = window.submitDeleteRoom;
    window.submitDeleteRoom = function() {
        invalidateRoomsCache();
        return originalSubmitDeleteRoom();
    };

    function buildHint(rooms, typedRoom, excludeTenantId) {
        if (!typedRoom || typedRoom.trim() === '') {
            return { state: 'empty', html: '' };
        }
        var q = typedRoom.trim().toLowerCase();
        var room = rooms.find(function(r) {
            return r.room_number.toLowerCase() === q;
        });
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
                    + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.2" style="flex-shrink:0;margin-top:.1rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
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
        var effectiveOccupancy = room.occupancy;
        if (excludeTenantId) {
            var currentTenantInRoom = tenants.find(function(t) {
                return t.tenant_id === excludeTenantId && t.room_number && t.room_number.toLowerCase() === q;
            });
            if (!currentTenantInRoom) {
            }
        }
        var remaining = room.capacity - effectiveOccupancy;
        if (remaining <= 0) {
            return {
                state: 'full',
                html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#fff0f4;border:1.5px solid #ffc2d1;">'
                    + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e04867" stroke-width="2.2" style="flex-shrink:0;margin-top:.1rem;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
                    + '<div><div style="font-size:.8rem;font-weight:700;color:#b0163a;">Room <span style="font-family:monospace;">' + room.room_number + '</span> is at full capacity.</div>'
                    + '<div style="font-size:.74rem;color:#b0163a;margin-top:.15rem;">' + room.occupancy + ' of ' + room.capacity + ' slots occupied. Choose a different room or increase capacity in <strong>Manage Rooms</strong>.</div></div></div>'
            };
        }
        var barPct = Math.round((effectiveOccupancy / room.capacity) * 100);
        var barColor = barPct >= 75 ? '#f0a500' : '#1f9d69';
        return {
            state: 'available',
            html: '<div style="display:flex;align-items:flex-start;gap:.6rem;padding:.65rem .8rem;border-radius:10px;background:#f0faf6;border:1.5px solid #8ce0bb;">'
                + '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.2" style="flex-shrink:0;margin-top:.1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
                + '<div style="flex:1;min-width:0;">'
                + '<div style="font-size:.8rem;font-weight:700;color:#1a7a52;">Room <span style="font-family:monospace;">' + room.room_number + '</span> available &mdash; ' + remaining + ' of ' + room.capacity + ' slot' + (room.capacity !== 1 ? 's' : '') + ' free.</div>'
                + '<div style="margin-top:.45rem;display:flex;align-items:center;gap:.6rem;">'
                + '<div style="flex:1;height:5px;background:#c8f0de;border-radius:99px;overflow:hidden;"><div style="height:100%;width:' + barPct + '%;background:' + barColor + ';border-radius:99px;transition:width .3s;"></div></div>'
                + '<span style="font-size:.7rem;font-weight:700;color:#1a7a52;">' + effectiveOccupancy + '/' + room.capacity + '</span>'
                + '</div>'
                + '<div style="font-size:.72rem;color:#2e9e68;margin-top:.2rem;">' + room.stay_type + ' &nbsp;&middot;&nbsp; Floor ' + room.floor + '</div>'
                + '</div></div>'
        };
    }

    function attachRoomHint(inputId, hintId, wrapId, submitBtnSelector, excludeTenantIdFn) {
        var input = document.getElementById(inputId);
        var hint  = document.getElementById(hintId);
        var wrap  = document.getElementById(wrapId);
        if (!input || !hint || !wrap) return;

        var debounceTimer = null;
        var lastVal = '';

        input.addEventListener('input', function() {
            var val = this.value.trim();
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
            btn.disabled = true;
            btn.style.opacity = '.45';
            btn.style.cursor  = 'not-allowed';
            btn.title = 'Resolve the room issue before saving.';
        });
    }

    function enableSubmit(selector) {
        document.querySelectorAll(selector).forEach(function(btn) {
            btn.disabled = false;
            btn.style.opacity = '';
            btn.style.cursor  = '';
            btn.title = '';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        attachRoomHint(
            'add-room-number-input',
            'add-room-hint',
            'add-room-hint-wrap',
            '#add-modal .btn-submit',
            null
        );
        attachRoomHint(
            'edit-room',
            'edit-room-hint',
            'edit-room-hint-wrap',
            '#edit-modal .btn-submit',
            function() { return currentTenant ? currentTenant.tenant_id : null; }
        );
    });
})();

filtered = tenants.filter(function(t) { return t.status !== 'inactive' && t.status !== 'move_out'; });
renderTable();

var deletedTenantArchive  = @json($deletedArchive);
var inactiveTenantArchive = @json($inactiveArchive);
var moveoutTenantArchive  = @json($moveoutArchive);
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
    var map = { active:'tad-pill-active', pending:'tad-pill-pending', move_out:'tad-pill-moveout', inactive:'tad-pill-inactive' };
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
            : '';
        return '<div class="tad-card" style="animation-delay:' + (i*0.04) + 's;">'
            + '<div class="tad-card-top"><div class="tad-card-id">' + (r.account_id||'\u2014') + '</div><div class="tad-card-time">' + (r.move_in_date ? fmtDate(r.move_in_date) : '\u2014') + '</div></div>'
            + '<div class="tad-card-name">' + r.first_name + ' ' + r.last_name + '</div>'
            + '<div class="tad-card-email">' + (r.email||'\u2014') + '</div>'
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
        win.document.write('<!DOCTYPE html><html><head><title>Archive - '+tabLabel[tenantArchiveTab]+'</title><style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec}</style></head><body><h2>Tenant Archive - '+tabLabel[tenantArchiveTab]+'</h2><p>Sanctissimo Rosario Ladies Dormitory &mdash; exported '+new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})+'</p><table><thead><tr><th>Account ID</th><th>Name</th><th>Email</th><th>Room</th><th>Stay Type</th><th>Status</th><th>'+labelMap[tenantArchiveTab]+'</th></tr></thead><tbody>'+rows+'</tbody></table></body></html>');
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

function getMenuForDropdown(id) {
    return Array.from(document.querySelectorAll('.export-menu')).find(function(m) {
        return m._sourceDropdownId === id;
    }) || document.querySelector('#' + id + ' .export-menu');
}

function positionExportMenu(dropdown) {
    var btn  = dropdown.querySelector('button');
    var menu = getMenuForDropdown(dropdown.id);
    var rect = btn.getBoundingClientRect();
    if (!menu._movedToBody) {
        menu._sourceDropdownId = dropdown.id;
        document.body.appendChild(menu);
        menu._movedToBody = true;
    }
    menu.style.position = 'fixed';
    menu.style.zIndex   = '99999';
    menu.style.right    = (window.innerWidth - rect.right) + 'px';
    menu.style.left     = 'auto';
    menu.style.minWidth = rect.width + 'px';
    menu.style.top    = 'auto';
    menu.style.bottom = 'auto';
    var menuHeight = menu.offsetHeight || 80;
    var spaceBelow = window.innerHeight - rect.bottom;
    if (spaceBelow >= menuHeight + 6) {
        menu.style.top    = (rect.bottom + 6) + 'px';
        menu.style.bottom = 'auto';
    } else {
        menu.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
        menu.style.top    = 'auto';
    }
}

function toggleExportDropdown(id) {
    var dropdown = document.getElementById(id);
    var menu     = getMenuForDropdown(id);
    var isOpen   = menu.classList.contains('open');
    closeAllExportDropdowns();
    if (!isOpen) {
        positionExportMenu(dropdown);
        getMenuForDropdown(id).classList.add('open');
    }
}

function closeAllExportDropdowns() {
    document.querySelectorAll('.export-menu').forEach(function(m) { m.classList.remove('open'); });
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.export-dropdown')) {
        closeAllExportDropdowns();
    }
});
</script>
@endsection