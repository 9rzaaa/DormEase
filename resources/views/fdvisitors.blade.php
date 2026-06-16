@extends('fdlayout')

@section('title', 'DormEase: Visitor Logs')
@section('page-title', 'Visitor Logs')

@section('styles')
<style>
    .dorm-name { font-size: 1rem; font-weight: 600; color: var(--bright-pink); margin-top: .2rem; }

    .btn-primary {
        display: flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        color: var(--white); border: none; font-size: .87rem; font-weight: 700;
        box-shadow: 0 3px 12px rgba(232,23,93,.3);
        transition: opacity .2s, transform .15s; cursor: pointer;
    }
    .btn-primary:hover { opacity: .9; transform: translateY(-1px); }

    .btn-archive-open {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--hot-pink);
        border: 1.5px solid var(--pink-light);
        font-size: .87rem; font-weight: 600;
        cursor: pointer; transition: border-color .2s, color .2s;
        font-family: var(--ff-body);
    }
    .btn-archive-open:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .btn-archive-open img { width: 14px; height: 14px; object-fit: contain; opacity: .6; }
    .btn-archive-open:hover img { opacity: 1; }

    .btn-outline {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        background: var(--white); color: var(--bright-pink);
        border: 1.5px solid var(--pink-light);
        font-size: .87rem; font-weight: 700; cursor: pointer; transition: .2s;
    }
    .btn-outline:hover { border-color: var(--bright-pink); color: var(--bright-pink); background: var(--pink-bg); }

    .stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.2rem; }

    .stat-box {
        background: var(--bright-pink); border-radius: 18px; border: none;
        box-shadow: 0 8px 18px rgba(0,0,0,.05), 0 18px 40px rgba(232,23,93,.25);
        padding: 1.4rem 1.5rem; display: flex; align-items: center; gap: 1.2rem;
        box-sizing: border-box; min-width: 0; overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-box:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,23,93,.35); }

    .stat-icon-circle {
        width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
        background: var(--white); display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,.15);
    }
    .stat-icon-circle img {
        width: 28px; height: 28px; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .stat-num { font-size: 2rem; font-weight: 700; color: var(--white); line-height: 1; letter-spacing: -.03em; }
    .stat-label { font-size: .85rem; color: rgba(247,245,245,.967); margin-top: .1rem; font-weight: 600; }

    .table-card { background: var(--white); border-radius: 16px; border: 1px solid var(--bright-pink); box-shadow: var(--shadow); overflow: hidden; }

    .table-header {
        padding: 1.2rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1px solid var(--bright-pink);
        flex-wrap: wrap; gap: .8rem;
    }

    .table-controls { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }

    .sort-wrap { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--ink-muted); font-weight: 500; }

    .sort-select {
        padding: .45rem .8rem; border-radius: 9px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        font-family: var(--ff-body); font-size: .83rem; color: var(--ink-muted);
        outline: none; cursor: pointer;
    }
    .sort-select:focus { border-color: var(--bright-pink); }

    .date-wrap { display: flex; align-items: center; gap: .4rem; font-size: .82rem; color: var(--ink-muted); font-weight: 500; }

    .date-input {
        padding: .45rem .7rem; border-radius: 9px;
        border: 1.5px solid var(--pink-light);
        font-family: var(--ff-body); font-size: .82rem; color: var(--ink); outline: none;
    }
    .date-input:focus { border-color: var(--bright-pink); }

    .search-wrap { position: relative; }
    .search-wrap input {
        padding: .48rem .9rem .48rem 2.2rem;
        border-radius: 9px; border: 1.5px solid var(--pink-light);
        font-family: var(--ff-body); font-size: .85rem; color: var(--ink);
        background: var(--pink-bg); outline: none; width: 210px;
        transition: border-color .2s, width .3s;
    }
    .search-wrap input:focus { border-color: var(--bright-pink); width: 250px; }
    .search-icon {
        position: absolute; left: .65rem; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; object-fit: contain; pointer-events: none;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--pink-100); }
    th {
        padding: .75rem 1rem; text-align: left;
        font-size: .73rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
        border-bottom: 1px solid var(--bright-pink);
    }
    td { padding: .85rem 1rem; font-size: .875rem; color: var(--ink); border-bottom: 1px solid var(--border); vertical-align: middle; }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: var(--pink-bg); }
    tbody tr:last-child td { border-bottom: none; }
    .td-name { font-weight: 600; }
    .td-sub  { font-size: .78rem; color: var(--ink-muted); margin-top: .1rem; }

    .badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: .25rem .7rem; border-radius: 7px;
        font-size: .74rem; font-weight: 700; white-space: nowrap;
    }
    .badge-inside    { background: #e8f4ff; color: #1a6fbf; border: 1.5px solid #90c3ef; }
    .badge-approved  { background: #e8faf5; color: var(--green); border: 1.5px solid var(--green); }
    .badge-pending   { background: #fff9e6; color: #c8960c; border: 1.5px solid #f0c040; }
    .badge-rejected  { background: #fff0f0; color: var(--red); border: 1.5px solid var(--blush); }
    .badge-completed { background: var(--gray-light); color: var(--ink-muted); border: 1.5px solid var(--gray); }

    th:nth-child(7),
    th:nth-child(8) { text-align: center; }
    td:nth-child(7),
    td:nth-child(8) { text-align: center; }

    .action-group { display: inline-flex; align-items: center; gap: .4rem; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s, background .2s;
    }
    .act-btn img { width: 14px; height: 14px; object-fit: contain; opacity: .55; }
    .act-btn:hover { border-color: var(--bright-pink); background: var(--pink-bg); }
    .act-btn:hover img { opacity: 1; }
    .act-btn.green:hover { border-color: var(--green); background: #f0fdf8; }
    .act-btn.red:hover   { border-color: var(--red); background: #fff0f0; }
    .act-btn.blue:hover  { border-color: #1a6fbf; background: #e8f4ff; }
    .act-btn[disabled]   { opacity: .35; cursor: not-allowed; pointer-events: none; }

    .table-footer {
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid var(--border); flex-wrap: wrap; gap: .5rem;
    }
    .table-showing { font-size: .8rem; color: var(--ink-muted); }

    .pagination { display: flex; align-items: center; gap: .35rem; }
    .page-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        font-size: .83rem; font-weight: 600; color: var(--bright-pink);
        cursor: pointer; transition: border-color .2s, background .2s, color .2s;
        display: flex; align-items: center; justify-content: center;
    }
    .page-btn:hover { border-color: var(--bright-pink); background: var(--pink-card); }
    .page-btn.active { background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink)); color: var(--white); border-color: var(--hot-pink); }
    .page-btn:disabled { opacity: .4; cursor: default; }
    .page-ellipsis { font-size: .85rem; color: var(--ink-muted); padding: 0 .2rem; }

    .empty-state { text-align: center; padding: 2.5rem; color: var(--ink-muted); font-size: .88rem; }

    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-field.full { grid-column: 1 / -1; }
    .modal-field label { display: block; font-size: .8rem; font-weight: 700; color: var(--ink-muted); margin-bottom: .35rem; }
    .modal-field input,
    .modal-field select {
        width: 100%; padding: .65rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
        font-size: .88rem; color: var(--ink); background: var(--pink-bg); outline: none;
        transition: border-color .2s; box-sizing: border-box;
    }
    .modal-field input:focus,
    .modal-field select:focus { border-color: var(--bright-pink); background: var(--white); }
    .modal-field .hint { font-size: .74rem; color: var(--ink-muted); margin-top: .3rem; }

    .modal-section-title {
        font-size: .78rem; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: .07em;
        margin: 1.2rem 0 .6rem;
        padding-bottom: .4rem;
        border-bottom: 1px solid var(--border);
    }

    .status-select {
        padding: .4rem .7rem; border-radius: 8px;
        border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
        font-size: .83rem; color: var(--ink); outline: none; cursor: pointer; width: 100%;
    }
    .status-select:focus { border-color: var(--bright-pink); }

    .visitor-modal {
        display: none; position: fixed; inset: 0;
        background: rgba(20,0,10,.55);
        align-items: center; justify-content: center;
        z-index: 9999; padding: 20px;
        backdrop-filter: blur(3px);
    }

    .visitor-modal-card {
        background: var(--white); width: 600px; max-width: 100%;
        max-height: 92vh;
        border-radius: 24px;
        box-shadow: 0 24px 64px rgba(232,23,93,.18), 0 8px 24px rgba(0,0,0,.1);
        position: relative;
        animation: modalFade .25s cubic-bezier(.22,1,.36,1);
        display: flex; flex-direction: column;
        overflow: hidden;
    }

    @keyframes modalFade {
        from { opacity: 0; transform: translateY(14px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .vmodal-header {
        padding: 1.2rem 1.8rem 1rem;
        display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
        flex-shrink: 0;
        background: linear-gradient(135deg, #fff5f9 0%, #ffffff 100%);
        border-radius: 24px 24px 0 0;
    }
    .vmodal-header-info { flex: 1; min-width: 0; }
    .vmodal-header-name {
        font-size: 1.25rem; font-weight: 800; color: var(--black);
        letter-spacing: -.02em; line-height: 1.2;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .vmodal-header-id { font-size: .78rem; font-weight: 700; color: var(--hot-pink); margin-top: .25rem; letter-spacing: .04em; }
    .vmodal-header-badges { display: flex; gap: .4rem; margin-top: .35rem; flex-wrap: wrap; }
    .vmodal-header-badge {
        font-size: .7rem; font-weight: 700; padding: .22rem .65rem;
        border-radius: 99px; background: var(--petal); color: var(--hot-pink);
        border: 1px solid var(--baby-pink); letter-spacing: .02em;
    }
    .vmodal-close-btn {
        width: 32px; height: 32px; border-radius: 9px;
        border: 1.5px solid var(--gray-light); background: var(--white);
        color: var(--ink-muted); font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: border-color .2s, color .2s, background .2s;
        line-height: 1; flex-shrink: 0; margin-top: .1rem;
    }
    .vmodal-close-btn:hover { border-color: var(--hot-pink); color: var(--hot-pink); background: #fff0f5; }

    .vmodal-tabs {
        display: flex;
        border-top: 1px solid var(--bright-pink);
        border-bottom: 1px solid var(--bright-pink);
        background: var(--white);
        padding: 0 1.2rem;
        flex-shrink: 0;
    }
    .vmodal-tab {
        padding: .8rem 1.1rem; font-size: .8rem; font-weight: 700;
        color: var(--ink-muted); background: none; border: none;
        border-bottom: 2.5px solid transparent; margin-bottom: -1px;
        cursor: pointer; transition: color .2s, border-color .2s;
        font-family: var(--ff-body); letter-spacing: .02em;
    }
    .vmodal-tab:hover { color: var(--hot-pink); }
    .vmodal-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }

    .vmodal-body {
        padding: 1.2rem 1.8rem;
        flex: 1;
        overflow-y: auto;
        min-height: 0;
    }
    .vmodal-body::-webkit-scrollbar { width: 4px; }
    .vmodal-body::-webkit-scrollbar-track { background: transparent; }
    .vmodal-body::-webkit-scrollbar-thumb { background: #f5b8cf; border-radius: 99px; }

    .vmodal-tab-panel { display: none; }
    .vmodal-tab-panel.active { display: block; }

    .vmodal-section-label {
        font-size: .67rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: .1em; color: var(--hot-pink);
        margin: 1rem 0 .55rem;
    }
    .vmodal-section-label:first-child { margin-top: 0; }

    .vmodal-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem .8rem; }

    .vmodal-info-item {
        background: #fff5f9; border: 1px solid #fce4ef;
        border-radius: 12px; padding: .7rem 1rem; transition: background .15s;
    }
    .vmodal-info-item:hover { background: #ffeef5; }
    .vmodal-info-item.full { grid-column: 1 / -1; }
    .vmodal-info-item-label {
        font-size: .65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--hot-pink); margin-bottom: .22rem; opacity: .8;
    }
    .vmodal-info-item-value { font-size: .88rem; font-weight: 600; color: var(--black); line-height: 1.35; }

    .vmodal-time-row { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: .6rem .8rem; }

    .vmodal-photo-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: .25rem 0;
    }

    .vmodal-photo-frame {
        width: 100%;
        aspect-ratio: 4 / 3;
        background: #fff5f9;
        border: 1.5px solid #fce4ef;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .vmodal-photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 12px;
    }

    .vmodal-photo-no {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--ink-muted);
    }

    .vmodal-photo-no-icon {
        font-size: 2.4rem;
        margin-bottom: .45rem;
        opacity: .3;
        display: block;
    }

    .vmodal-photo-no p { margin: 0; font-size: .83rem; font-weight: 600; color: var(--ink-muted); }

    .vmodal-photo-actions { display: flex; gap: .65rem; }

    .vmodal-photo-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.2rem; border-radius: 10px;
        font-size: .82rem; font-weight: 700; cursor: pointer;
        transition: .2s; font-family: var(--ff-body); text-decoration: none;
    }
    .vmodal-photo-btn-primary { background: var(--hot-pink); color: var(--white); border: none; }
    .vmodal-photo-btn-primary:hover { background: #c8144f; }
    .vmodal-photo-btn-outline { background: var(--white); color: var(--hot-pink); border: 1.5px solid var(--baby-pink); }
    .vmodal-photo-btn-outline:hover { border-color: var(--hot-pink); background: #fff7fb; }

    .photo-lightbox {
        display: none; position: fixed; inset: 0;
        background: rgba(10,0,6,.88); z-index: 10001;
        align-items: center; justify-content: center;
        padding: 20px; backdrop-filter: blur(6px);
        animation: lbFade .2s ease;
    }
    @keyframes lbFade { from { opacity: 0; } to { opacity: 1; } }

    .photo-lightbox-inner {
        position: relative; max-width: min(860px, 100%); max-height: 90vh;
        display: flex; flex-direction: column; align-items: center; gap: 1rem;
    }
    .photo-lightbox-inner img {
        max-width: 100%; max-height: 78vh; object-fit: contain;
        border-radius: 14px; box-shadow: 0 24px 80px rgba(0,0,0,.6);
        animation: lbImg .25s cubic-bezier(.22,1,.36,1);
    }
    @keyframes lbImg { from { transform: scale(.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    .photo-lightbox-close {
        position: absolute; top: -14px; right: -14px;
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3);
        color: var(--white); font-size: 1.2rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center; transition: background .2s;
    }
    .photo-lightbox-close:hover { background: rgba(255,255,255,.28); }

    .photo-lightbox-caption { font-size: .78rem; color: rgba(255,255,255,.55); font-weight: 500; text-align: center; }

    .photo-lightbox-open-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .45rem 1.1rem; border-radius: 9px; font-size: .8rem; font-weight: 700;
        cursor: pointer; background: rgba(255,255,255,.12); color: var(--white);
        border: 1.5px solid rgba(255,255,255,.25); text-decoration: none;
        transition: background .2s; font-family: var(--ff-body);
    }
    .photo-lightbox-open-btn:hover { background: rgba(255,255,255,.22); }

    .archive-backdrop {
        position: fixed; inset: 0;
        background: rgba(232, 23, 93, 0.15); backdrop-filter: blur(3px);
        z-index: 499; opacity: 0; pointer-events: none; transition: opacity .38s ease;
    }
    .archive-backdrop.open { opacity: 1; pointer-events: auto; }

    .archive-drawer {
        position: fixed; top: 0; right: 0; bottom: 0;
        width: min(680px, 100vw); background: var(--blush, #fff5f8);
        z-index: 500; display: flex; flex-direction: column;
        transform: translateX(100%); transition: transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow: -8px 0 40px rgba(0,0,0,.18);
    }
    .archive-drawer.open { transform: translateX(0); }

    .archive-drawer-header {
        padding: 1.6rem 1.8rem 1.2rem;
        border-bottom: 1.5px solid var(--pink-light);
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1rem; flex-shrink: 0; background: var(--white);
    }
    .archive-drawer-title { font-size: 1.2rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; line-height: 1.2; }
    .archive-drawer-sub { font-size: .78rem; color: var(--ink-muted); margin-top: .25rem; font-weight: 500; }

    .archive-close-btn {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--white); border: 1.5px solid var(--pink-light);
        color: var(--hot-pink); font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: border-color .2s, background .2s; flex-shrink: 0;
    }
    .archive-close-btn:hover { border-color: var(--bright-pink); background: var(--pink-bg); }

    .archive-tabs {
        display: flex; gap: 0; padding: 0 1.8rem;
        border-bottom: 1.5px solid var(--pink-light);
        flex-shrink: 0; background: var(--white);
    }
    .archive-tab {
        padding: .85rem 1.2rem; font-size: .82rem; font-weight: 700;
        color: var(--ink-muted); background: none; border: none;
        border-bottom: 2px solid transparent; margin-bottom: -1.5px;
        cursor: pointer; transition: color .2s, border-color .2s;
        display: flex; align-items: center; gap: .5rem;
        letter-spacing: .02em; font-family: var(--ff-body);
    }
    .archive-tab:hover { color: var(--hot-pink); }
    .archive-tab.active { color: var(--hot-pink); border-bottom-color: var(--hot-pink); }
    .archive-tab-count {
        font-size: .68rem; font-weight: 800; padding: .1rem .45rem; border-radius: 99px;
        background: var(--pink-light); color: var(--ink-muted); letter-spacing: .02em;
    }
    .archive-tab.active .archive-tab-count { background: var(--hot-pink); color: var(--white); }

    .archive-search-bar { padding: 1rem 1.8rem .8rem; flex-shrink: 0; }
    .archive-search-inner { position: relative; display: flex; align-items: center; }
    .archive-search-inner input {
        width: 100%; padding: .55rem .9rem .55rem 2.2rem;
        border-radius: 10px; border: 1.5px solid var(--pink-light);
        background: var(--white); color: var(--ink);
        font-size: .83rem; font-family: var(--ff-body); outline: none; transition: border-color .2s;
    }
    .archive-search-inner input::placeholder { color: var(--ink-muted); }
    .archive-search-inner input:focus { border-color: var(--bright-pink); }
    .archive-search-icon {
        position: absolute; left: .75rem; width: 13px; height: 13px;
        opacity: .4; pointer-events: none;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .archive-list {
        flex: 1; overflow-y: auto; padding: 0 1.8rem 1.8rem;
        display: flex; flex-direction: column; gap: .75rem;
    }
    .archive-list::-webkit-scrollbar { width: 4px; }
    .archive-list::-webkit-scrollbar-track { background: transparent; }
    .archive-list::-webkit-scrollbar-thumb { background: var(--pink-light); border-radius: 99px; }

    .archive-card {
        background: var(--white); border: 1.5px solid var(--pink-light);
        border-radius: 14px; padding: 1rem 1.1rem;
        transition: background .2s, border-color .2s, transform .2s;
        animation: archiveSlideIn .3s ease both;
    }
    @keyframes archiveSlideIn {
        from { opacity: 0; transform: translateX(12px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .archive-card:hover {
        background: var(--pink-bg); border-color: var(--bright-pink);
        box-shadow: 0 6px 18px rgba(232,23,93,.12); transform: translateY(-1px);
    }

    .archive-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: .8rem; margin-bottom: .5rem; }
    .archive-card-id { font-size: .78rem; font-weight: 800; color: var(--hot-pink); letter-spacing: .02em; }
    .archive-card-time { font-size: .7rem; color: var(--ink-muted); font-weight: 500; white-space: nowrap; flex-shrink: 0; }
    .archive-card-visitor { font-size: .88rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
    .archive-card-tenant { font-size: .75rem; color: var(--ink-muted); margin-top: .1rem; }

    .archive-card-meta { display: flex; align-items: center; gap: .5rem; margin-top: .6rem; flex-wrap: wrap; }
    .archive-pill {
        font-size: .68rem; font-weight: 700; padding: .18rem .55rem; border-radius: 99px;
        letter-spacing: .03em; text-transform: uppercase;
        display: inline-flex; align-items: center; justify-content: center; line-height: 1; vertical-align: middle;
    }
    .archive-pill-purpose   { background: var(--pink-bg); color: var(--hot-pink); border: 1px solid var(--pink-light); }
    .archive-pill-completed { background: #f0f0f0; color: #555; border: 1px solid #ddd; }
    .archive-pill-deleted   { background: #fff0f0; color: var(--red); border: 1px solid #ffc8d0; }

    .archive-card-footer {
        display: flex; align-items: center; gap: .4rem;
        margin-top: .7rem; padding-top: .6rem;
        border-top: 1px solid var(--pink-light);
        font-size: .7rem; color: var(--ink-muted); font-weight: 500;
    }
    .archive-card-footer span { color: var(--ink); font-weight: 600; }

    .archive-empty { text-align: center; padding: 3rem 1rem; color: var(--ink-muted); font-size: .85rem; }
    .archive-empty-icon {
        width: 40px; height: 40px; margin: 0 auto .75rem;
        opacity: .25; display: block; object-fit: contain;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }

    .archive-footer {
        padding: .9rem 1.8rem; border-top: 1.5px solid var(--pink-light);
        background: var(--white); display: flex; align-items: center; justify-content: space-between;
        flex-shrink: 0; flex-wrap: wrap; gap: .5rem;
    }
    .archive-count-label { font-size: .75rem; color: var(--ink-muted); font-weight: 600; }
    .archive-export-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .75rem; font-weight: 700; color: var(--hot-pink);
        background: var(--white); border: 1.5px solid var(--pink-light);
        border-radius: 8px; padding: .35rem .85rem;
        cursor: pointer; transition: border-color .2s, color .2s; font-family: var(--ff-body);
    }
    .archive-export-btn:hover { border-color: var(--bright-pink); color: var(--bright-pink); }
    .archive-export-btn img { width: 12px; height: 12px; object-fit: contain; opacity: .6; }

    @media (max-width: 900px) {
        .stats-row  { grid-template-columns: 1fr; }
        .modal-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; }
        .archive-drawer { width: 100vw; }
        .archive-tabs { padding: 0 1rem; }
        .archive-drawer-header { padding: 1.2rem 1rem .9rem; }
        .archive-list { padding: 0 1rem 1.2rem; }
        .archive-search-bar { padding: .8rem 1rem .6rem; }
        .archive-footer { padding: .75rem 1rem; }
        .vmodal-time-row { grid-template-columns: 1fr 1fr; }
    }

    .action-loading-overlay {
        position: fixed; inset: 0; z-index: 1200;
        display: none; align-items: center; justify-content: center;
        background: rgba(255,255,255,.72); backdrop-filter: blur(2px);
    }
    .action-loading-overlay.open { display: flex; }

    .action-loading-box {
        display: flex; align-items: center; flex-direction: column;
        gap: .75rem; padding: 1.25rem 1.6rem;
        border: 1px solid var(--border); border-radius: 12px;
        background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14);
        color: var(--ink); font-size: .9rem; font-weight: 700;
    }

    .loading-logo-wrap {
        width: 86px; height: 86px;
        border: 3px solid var(--pink-light); border-radius: 50%;
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 24px rgba(232,23,93,.25);
        animation: pulseLogo 1s ease-in-out infinite; flex-shrink: 0;
    }
    .loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }
    .is-loading { opacity: .75; pointer-events: none; }

    @keyframes pulseLogo {
        0%, 100% { transform: scale(1); box-shadow: 0 10px 24px rgba(232,23,93,.25); }
        50%       { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); }
    }

    .visitor-legend-wrap {
        position: static;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        flex-shrink: 0;
    }
    .visitor-legend-wrap img {
        width: 15px; height: 15px; object-fit: contain; opacity: .55;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
        transition: opacity .2s;
    }
    .visitor-legend-wrap:hover img { opacity: 1; }
    .visitor-legend-popup {
        display: none; position: fixed;
        background: var(--white); border: 1.5px solid var(--baby-pink);
        border-radius: 14px;
        box-shadow: 0 12px 32px rgba(232,23,93,.13), 0 2px 8px rgba(0,0,0,.07);
        padding: .75rem .9rem; min-width: 360px; z-index: 99999;
    }
    .vlp-title {
        font-size: .67rem; font-weight: 800; color: var(--bright-pink);
        text-transform: uppercase; letter-spacing: .08em;
        margin-bottom: .45rem; padding-bottom: .35rem; border-bottom: 1.5px solid #fce4ef;
    }
    .vlp-row {
        display: flex; align-items: flex-start; gap: .6rem;
        padding: .32rem 0; border-bottom: 1px solid #fce4ef;
    }
    .vlp-row:last-child { border-bottom: none; }
    .vlp-badge { flex-shrink: 0; min-width: 100px; display: flex; align-items: center; }
    .vlp-desc { font-size: .73rem; color: var(--ink-muted); font-weight: 500; line-height: 1.45; padding-top: .1rem; }

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-light); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
    .export-menu button:hover { background: var(--pink-bg); color: var(--bright-pink); }

    #add-modal .modal {
        max-width: 580px;
        border-radius: 22px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(232,23,93,.18), 0 8px 24px rgba(0,0,0,.1);
    }

    .add-modal-header {
        background: linear-gradient(135deg, #fff0f6 0%, #fff8fb 100%);
        padding: 1.4rem 1.8rem 1.1rem;
        border-bottom: 1.5px solid var(--pink-light);
        display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
    }

    .add-modal-header-left { display: flex; align-items: center; gap: .85rem; }

    .add-modal-icon-wrap {
        width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 16px rgba(232,23,93,.3);
    }
    .add-modal-icon-wrap img { width: 22px; height: 22px; object-fit: contain; filter: brightness(0) invert(1); }

    .add-modal-title-block {}
    .add-modal-title { font-size: 1.1rem; font-weight: 800; color: var(--ink); letter-spacing: -.02em; line-height: 1.2; }
    .add-modal-sub   { font-size: .75rem; color: var(--ink-muted); font-weight: 500; margin-top: .18rem; }

    .add-modal-close {
        width: 32px; height: 32px; border-radius: 9px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        color: var(--ink-muted); font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: border-color .2s, color .2s, background .2s; flex-shrink: 0;
    }
    .add-modal-close:hover { border-color: var(--hot-pink); color: var(--hot-pink); background: #fff0f5; }

    .add-modal-body { padding: 1.4rem 1.8rem; }

    .add-modal-section {
        font-size: .67rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: .1em; color: var(--hot-pink);
        margin: 1.15rem 0 .65rem; padding-bottom: .4rem;
        border-bottom: 1.5px solid #fce4ef;
    }
    .add-modal-section:first-child { margin-top: 0; }

    .add-modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
    .add-modal-grid .amf-full { grid-column: 1 / -1; }

    .amf { display: flex; flex-direction: column; gap: .3rem; }

    .amf label {
        font-size: .75rem; font-weight: 700; color: var(--ink-muted);
        display: flex; align-items: center; gap: .3rem;
    }
    .amf label .req { color: var(--red); font-size: .8rem; line-height: 1; }

    .amf-input-wrap { position: relative; }

    .amf-input-wrap input,
    .amf-input-wrap select,
    .amf-input-wrap .amf-select-display {
        width: 100%; padding: .62rem .9rem; border-radius: 10px;
        border: 1.5px solid var(--pink-light); font-family: var(--ff-body);
        font-size: .875rem; color: var(--ink); background: var(--pink-bg); outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s; box-sizing: border-box;
    }
    .amf-input-wrap input:focus,
    .amf-input-wrap select:focus { border-color: var(--bright-pink); background: var(--white); box-shadow: 0 0 0 3px rgba(232,23,93,.08); }

    .amf-input-wrap input.valid   { border-color: var(--green) !important; background: #f0fdf8 !important; }
    .amf-input-wrap input.invalid,
    .amf-input-wrap select.invalid,
    .amf-input-wrap .amf-select-display.invalid { border-color: var(--red) !important; background: #fff5f5 !important; box-shadow: 0 0 0 3px rgba(220,38,38,.07) !important; }

    .amf-hint { font-size: .72rem; color: var(--ink-muted); line-height: 1.4; }
    .amf-error { font-size: .72rem; color: var(--red); font-weight: 600; line-height: 1.4; display: none; }
    .amf-error.show { display: block; }

    .amf-status-icon {
        position: absolute; right: .75rem; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; display: none; pointer-events: none;
    }
    .amf-status-icon.show { display: block; }

    .amf-char-count {
        font-size: .68rem; color: var(--ink-muted); text-align: right; font-weight: 500;
    }

    .tenant-search-wrap { position: relative; }

    .tenant-search-input {
        width: 100%; padding: .62rem 2.2rem .62rem .9rem;
        border-radius: 10px; border: 1.5px solid var(--pink-light);
        font-family: var(--ff-body); font-size: .875rem; color: var(--ink);
        background: var(--pink-bg); outline: none; box-sizing: border-box;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .tenant-search-input:focus { border-color: var(--bright-pink); background: var(--white); box-shadow: 0 0 0 3px rgba(232,23,93,.08); }
    .tenant-search-input.valid   { border-color: var(--green) !important; background: #f0fdf8 !important; }
    .tenant-search-input.invalid { border-color: var(--red) !important; background: #fff5f5 !important; box-shadow: 0 0 0 3px rgba(220,38,38,.07) !important; }

    .tenant-search-chevron {
        position: absolute; right: .75rem; top: 50%; transform: translateY(-50%) rotate(0deg);
        width: 16px; height: 16px; pointer-events: none; transition: transform .2s;
        opacity: .45;
        filter: brightness(0) saturate(100%) invert(23%) sepia(92%) saturate(3204%) hue-rotate(329deg) brightness(95%) contrast(96%);
    }
    .tenant-search-chevron.open { transform: translateY(-50%) rotate(180deg); }

    .tenant-dropdown {
        position: absolute; top: calc(100% + 5px); left: 0; right: 0; z-index: 900;
        background: var(--white); border: 1.5px solid var(--pink-light);
        border-radius: 12px; box-shadow: 0 12px 32px rgba(232,23,93,.13);
        max-height: 200px; overflow-y: auto;
        display: none;
    }
    .tenant-dropdown.open { display: block; }
    .tenant-dropdown::-webkit-scrollbar { width: 4px; }
    .tenant-dropdown::-webkit-scrollbar-thumb { background: #f5b8cf; border-radius: 99px; }

    .tenant-option {
        padding: .65rem 1rem; cursor: pointer; font-size: .875rem; color: var(--ink);
        transition: background .15s; border-bottom: 1px solid var(--pink-light);
        display: flex; align-items: center; justify-content: space-between; gap: .5rem;
    }
    .tenant-option:last-child { border-bottom: none; }
    .tenant-option:hover, .tenant-option.focused { background: var(--pink-bg); color: var(--hot-pink); }
    .tenant-option.selected { background: #fff0f7; }

    .tenant-option-name { font-weight: 600; }
    .tenant-option-room { font-size: .75rem; color: var(--ink-muted); background: var(--pink-light); padding: .1rem .45rem; border-radius: 6px; font-weight: 600; flex-shrink: 0; }

    .tenant-option-empty { padding: .9rem 1rem; font-size: .83rem; color: var(--ink-muted); text-align: center; font-weight: 500; }

    .tenant-option mark {
        background: #ffe4ef; color: var(--hot-pink); border-radius: 3px;
        padding: 0 1px; font-weight: 800;
    }

    .add-modal-footer {
        padding: 1rem 1.8rem 1.4rem;
        display: flex; align-items: center; justify-content: flex-end; gap: .65rem;
        border-top: 1.5px solid var(--pink-light); background: #fefcfe;
    }

    .amf-btn-cancel {
        padding: .6rem 1.3rem; border-radius: 10px;
        border: 1.5px solid var(--pink-light); background: var(--white);
        color: var(--ink-muted); font-size: .87rem; font-weight: 700;
        cursor: pointer; transition: border-color .2s, color .2s; font-family: var(--ff-body);
    }
    .amf-btn-cancel:hover { border-color: var(--bright-pink); color: var(--bright-pink); }

    .amf-btn-submit {
        padding: .6rem 1.5rem; border-radius: 10px;
        background: linear-gradient(135deg, var(--hot-pink), var(--bright-pink));
        color: var(--white); border: none; font-size: .87rem; font-weight: 700;
        cursor: pointer; box-shadow: 0 4px 14px rgba(232,23,93,.32);
        transition: opacity .2s, transform .15s; font-family: var(--ff-body);
        display: inline-flex; align-items: center; gap: .4rem;
    }
    .amf-btn-submit:hover { opacity: .9; transform: translateY(-1px); }
    .amf-btn-submit:disabled { opacity: .55; cursor: not-allowed; transform: none; }
</style>
@endsection

@section('content')

<div class="page-body">

    <div class="page-header fade-up d1">
        <div>
            <h1>Visitor Logs</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openModal('add-modal')">
                + Add Walk-in Visitor
            </button>

            <button class="btn-archive-open" onclick="openArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>

            <div class="export-dropdown" id="export-dropdown-main">
                <button class="btn-outline" onclick="toggleExportDropdown('export-dropdown-main')">
                    <img src="{{ asset('icons/export.png') }}" alt=""> Export
                </button>
                <div class="export-menu" id="export-menu-main">
                    <button onclick="exportVisitorsCsv(); closeAllExportDropdowns()">Export as CSV</button>
                    <button onclick="exportVisitorsPdf(); closeAllExportDropdowns()">Export as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row fade-up d2">
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/visitor.png') }}" alt="">
            </div>
            <div>
                <div class="stat-num">{{ $visitorsToday ?? 0 }}</div>
                <div class="stat-label">Visitors Today</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon-circle">
                <img src="{{ asset('icons/nav-db.png') }}" alt="">
            </div>
            <div>
                <div class="stat-num">{{ $currentlyInside ?? 0 }}</div>
                <div class="stat-label">Currently Inside</div>
            </div>
        </div>
    </div>

    <div class="table-card fade-up d3">
        <div class="table-header">
            <div class="table-controls">
                <div class="sort-wrap">
                    Sort By:
                    <select class="sort-select" id="sort-select" onchange="sortTable()">
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="name">Name A-Z</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <div class="date-wrap">
                    From:
                    <input type="date" class="date-input" id="date-from" onchange="filterTable()">
                    to
                    <input type="date" class="date-input" id="date-to" onchange="filterTable()">
                    <button type="button" id="date-clear-btn-fd" onclick="clearDates()" style="display:none;background:none;border:none;cursor:pointer;color:var(--bright-pink);font-size:.8rem;font-weight:700;padding:0 .2rem;font-family:var(--ff-body);line-height:1;flex-shrink:0;" title="Clear dates">&#x2715;</button>
                    <div id="date-error-fd" style="display:none;position:fixed;background:#fff0f4;border:1.5px solid #ffc2d1;border-radius:8px;padding:.3rem .75rem;font-size:.75rem;font-weight:700;color:#b0163a;white-space:nowrap;z-index:99999;box-shadow:0 4px 12px rgba(232,23,93,.12);">End date cannot be before start date.</div>
                </div>
                <div class="visitor-legend-wrap" id="fd-visitor-legend-trigger">
                    <img src="{{ asset('icons/info.png') }}" alt="Status Guide">
                    <div class="visitor-legend-popup" id="fd-visitor-legend-popup">
                        <div class="vlp-title">Status Guide</div>
                        <div class="vlp-row">
                            <span class="vlp-badge"><span class="badge badge-approved">Approved</span></span>
                            <span class="vlp-desc">Visit approved and expected but visitor has not yet arrived.</span>
                        </div>
                        <div class="vlp-row">
                            <span class="vlp-badge"><span class="badge badge-inside">Inside</span></span>
                            <span class="vlp-desc">Visitor has checked in and is currently inside the dormitory.</span>
                        </div>
                        <div class="vlp-row">
                            <span class="vlp-badge"><span class="badge badge-pending">Pending</span></span>
                            <span class="vlp-desc">Visit registered but not yet approved or acted on.</span>
                        </div>
                        <div class="vlp-row">
                            <span class="vlp-badge"><span class="badge badge-completed">Completed</span></span>
                            <span class="vlp-desc">Visitor has checked out. Visit is done and archived.</span>
                        </div>
                        <div class="vlp-row">
                            <span class="vlp-badge"><span class="badge badge-rejected">Rejected</span></span>
                            <span class="vlp-desc">Visit was rejected, cancelled, or denied entry by staff.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-wrap">
                <img src="{{ asset('icons/search.png') }}" class="search-icon" alt="">
                <input type="text" id="search-input" placeholder="Search by name, tenant, room..." oninput="filterTable()">
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Visitor Name</th>
                        <th>Date &amp; Time In</th>
                        <th>Date &amp; Time Out</th>
                        <th>Purpose of Visit</th>
                        <th>Tenant Visited</th>
                        <th>Logged By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="visitor-tbody"></tbody>
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

<div class="archive-backdrop" id="archive-backdrop" onclick="closeArchive()"></div>

<div class="archive-drawer" id="archive-drawer">
    <div class="archive-drawer-header">
        <div>
            <div class="archive-drawer-title">Archive &amp; History</div>
            <div class="archive-drawer-sub">Record of completed and cancelled visitor logs</div>
        </div>
        <button class="archive-close-btn" onclick="closeArchive()">&#x2715;</button>
    </div>

    <div class="archive-tabs">
        <button class="archive-tab active" id="atab-completed" onclick="switchArchiveTab('completed')">
            Completed
            <span class="archive-tab-count" id="acount-completed">0</span>
        </button>
        <button class="archive-tab" id="atab-deleted" onclick="switchArchiveTab('deleted')">
            Deleted
            <span class="archive-tab-count" id="acount-deleted">0</span>
        </button>
        <button class="archive-tab" id="atab-cancelled" onclick="switchArchiveTab('cancelled')">
            Cancelled
            <span class="archive-tab-count" id="acount-cancelled">0</span>
        </button>
    </div>

    <div class="archive-search-bar">
        <div class="archive-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="archive-search-icon" alt="">
            <input type="text" id="archive-search" placeholder="Search archived visitor logs..." oninput="renderArchive()">
        </div>
    </div>

    <div class="archive-list" id="archive-list"></div>

    <div class="archive-footer">
        <div class="archive-count-label" id="archive-count-label">0 records</div>
        <div class="export-dropdown" id="export-dropdown-archive">
            <button class="archive-export-btn" onclick="toggleExportDropdown('export-dropdown-archive')">
                <img src="{{ asset('icons/export.png') }}" alt="">
                Export
            </button>
            <div class="export-menu" id="export-menu-archive">
                <button onclick="exportArchiveCsv(); closeAllExportDropdowns()">Export as CSV</button>
                <button onclick="exportArchivePdf(); closeAllExportDropdowns()">Export as PDF</button>
            </div>
        </div>
    </div>
</div>

<div id="visitorDetailModal" class="visitor-modal">
    <div class="visitor-modal-card">

        <div class="vmodal-header">
            <div class="vmodal-header-info">
                <div class="vmodal-header-name" id="vmodalHeaderName">—</div>
                <div class="vmodal-header-id"   id="vmodalHeaderId">LOG-0000</div>
                <div class="vmodal-header-badges" id="vmodalHeaderBadges"></div>
            </div>
            <button class="vmodal-close-btn" onclick="closeVisitorDetailModal()">&#x2715;</button>
        </div>

        <div class="vmodal-tabs">
            <button class="vmodal-tab active" id="vmtab-info"  onclick="switchVModalTab('info')">Visitor Info</button>
            <button class="vmodal-tab"        id="vmtab-photo" onclick="switchVModalTab('photo')">ID Photo</button>
        </div>

        <div class="vmodal-body">

            <div class="vmodal-tab-panel active" id="vmpanel-info">
                <div class="vmodal-section-label">Personal</div>
                <div class="vmodal-info-grid" id="vminfo-personal"></div>

                <div class="vmodal-section-label">Visit Details</div>
                <div class="vmodal-info-grid" id="vminfo-visit"></div>

                <div class="vmodal-section-label">Schedule &amp; Attendance</div>
                <div class="vmodal-info-grid vmodal-time-row" id="vminfo-schedule"></div>

                <div class="vmodal-section-label">Log Info</div>
                <div class="vmodal-info-grid" id="vminfo-log"></div>
            </div>

            <div class="vmodal-tab-panel" id="vmpanel-photo">
                <div class="vmodal-section-label">ID Verification</div>
                <div class="vmodal-info-grid" id="vminfo-idtype" style="margin-bottom:1rem;"></div>
                <div class="vmodal-photo-panel" id="vminfo-photo"></div>
            </div>

        </div>
    </div>
</div>

<div id="photoLightbox" class="photo-lightbox" onclick="closeLightbox(event)">
    <div class="photo-lightbox-inner">
        <button class="photo-lightbox-close" onclick="closeLightboxBtn()">&#x2715;</button>
        <img id="lightboxImg" src="" alt="ID Photo">
        <div style="display:flex;gap:.7rem;align-items:center;">
            <div class="photo-lightbox-caption" id="lightboxCaption">ID Photo</div>
            <a id="lightboxOpenLink" href="#" target="_blank" rel="noopener" class="photo-lightbox-open-btn">
                Open full image &#x2197;
            </a>
        </div>
    </div>
</div>

<div class="modal-overlay" id="add-modal">
    <div class="modal" style="max-width:580px;border-radius:22px;padding:0;overflow:hidden;box-shadow:0 24px 64px rgba(232,23,93,.18),0 8px 24px rgba(0,0,0,.1);">

        <div class="add-modal-header">
            <div class="add-modal-header-left">
                <div class="add-modal-icon-wrap">
                    <img src="{{ asset('icons/visitor.png') }}" alt="">
                </div>
                <div class="add-modal-title-block">
                    <div class="add-modal-title">Add Walk-in Visitor</div>
                    <div class="add-modal-sub">Log a new visitor arriving at the dormitory</div>
                </div>
            </div>
            <button class="add-modal-close" onclick="closeModal('add-modal'); resetAddForm()">&#x2715;</button>
        </div>

        <form method="POST" action="{{ route('visitors.store') }}" id="add-visitor-form" novalidate>
            @csrf

            <div class="add-modal-body">

                <div class="add-modal-section">Visitor Information</div>

                <div class="add-modal-grid">

                    <div class="amf amf-full">
                        <label for="av_visitor_name">
                            Visitor Full Name <span class="req">*</span>
                        </label>
                        <div class="amf-input-wrap">
                            <input
                                type="text"
                                id="av_visitor_name"
                                name="visitor_name"
                                placeholder="e.g. Maria Santos"
                                maxlength="100"
                                autocomplete="off"
                                value="{{ old('visitor_name') }}"
                                oninput="avValidateName(this)"
                                onblur="avValidateName(this, true)"
                            >
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <div class="amf-error" id="av_visitor_name_err">Please enter the visitor's full name (letters and spaces only).</div>
                            <div class="amf-char-count" id="av_name_count">0 / 100</div>
                        </div>
                    </div>

                    <div class="amf">
                        <label for="av_contact_no">Contact Number</label>
                        <div class="amf-input-wrap">
                            <input
                                type="text"
                                id="av_contact_no"
                                name="contact_no"
                                placeholder="e.g. 09123456789"
                                maxlength="15"
                                autocomplete="off"
                                value="{{ old('contact_no') }}"
                                oninput="avValidateContact(this)"
                                onblur="avValidateContact(this, true)"
                            >
                        </div>
                        <div class="amf-error" id="av_contact_err">Enter a valid PH number (e.g. 09XXXXXXXXX or +639XXXXXXXXX).</div>
                        <div class="amf-hint">Optional — for emergency contact</div>
                    </div>

                    <div class="amf">
                        <label for="av_id_type">ID Type <span class="req">*</span></label>
                        <div class="amf-input-wrap">
                            <select id="av_id_type" name="id_type" onchange="avValidateIdType(this)" onblur="avValidateIdType(this, true)">
                                <option value="">Select ID Type</option>
                                <option value="School ID" {{ old('id_type') === 'School ID' ? 'selected' : '' }}>School ID</option>
                                <option value="Government ID" {{ old('id_type') === 'Government ID' ? 'selected' : '' }}>Government ID</option>
                                <option value="Passport" {{ old('id_type') === 'Passport' ? 'selected' : '' }}>Passport</option>
                                <option value="Driver's License" {{ old('id_type') === "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                                <option value="Other" {{ old('id_type') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="amf-error" id="av_id_err">Please select an ID type.</div>
                    </div>

                </div>

                <div class="add-modal-section" style="margin-top:1.2rem;">Visit Details</div>

                <div class="add-modal-grid">

                    <div class="amf amf-full">
                        <label>Tenant to Visit <span class="req">*</span></label>
                        <div class="tenant-search-wrap">
                            <input
                                type="text"
                                id="av_tenant_search"
                                class="tenant-search-input"
                                placeholder="Type tenant name to search..."
                                autocomplete="off"
                                oninput="avFilterTenants()"
                                onfocus="avOpenTenantDropdown()"
                                onblur="avOnTenantBlur()"
                                onkeydown="avTenantKeyNav(event)"
                            >
                            <img src="{{ asset('icons/arrow-down.png') }}" class="tenant-search-chevron" id="av_tenant_chevron" alt="">
                            <input type="hidden" name="tenant_id" id="av_tenant_id" value="{{ old('tenant_id') }}">
                            <div class="tenant-dropdown" id="av_tenant_dropdown"></div>
                        </div>
                        <div class="amf-error" id="av_tenant_err">Please select a tenant to visit.</div>
                    </div>

                    <div class="amf amf-full">
                        <label for="av_purpose">Purpose of Visit <span class="req">*</span></label>
                        <div class="amf-input-wrap">
                            <select
                                id="av_purpose"
                                name="purpose"
                                onchange="avValidatePurpose(this)"
                                onblur="avValidatePurpose(this, true)"
                            >
                                <option value="">Select Purpose</option>
                                <option value="Visiting Tenant" {{ old('purpose') === 'Visiting Tenant' ? 'selected' : '' }}>Visiting Tenant</option>
                                <option value="Food Delivery" {{ old('purpose') === 'Food Delivery' ? 'selected' : '' }}>Food Delivery</option>
                                <option value="Laundry Pickup" {{ old('purpose') === 'Laundry Pickup' ? 'selected' : '' }}>Laundry Pickup</option>
                                <option value="Package Delivery" {{ old('purpose') === 'Package Delivery' ? 'selected' : '' }}>Package Delivery</option>
                                <option value="Other" {{ old('purpose') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="amf-error" id="av_purpose_err">Please select a purpose for the visit.</div>
                    </div>

                    <div class="amf amf-full">
                        <label for="av_arrival_time">Time In <span class="req">*</span></label>
                        <div class="amf-input-wrap">
                            <input
                                type="datetime-local"
                                id="av_arrival_time"
                                name="arrival_time"
                                value="{{ old('arrival_time', now()->format('Y-m-d\TH:i')) }}"
                                onchange="avValidateArrival(this)"
                                onblur="avValidateArrival(this, true)"
                            >
                        </div>
                        <div class="amf-error" id="av_arrival_err">Time in cannot be set in the future.</div>
                        <div class="amf-hint">Status will automatically be set to "Inside" upon logging.</div>
                    </div>

                </div>

            </div>

            <div class="add-modal-footer">
                <button type="button" class="amf-btn-cancel" onclick="closeModal('add-modal'); resetAddForm()">Cancel</button>
                <button type="submit" class="amf-btn-submit" id="av_submit_btn" onclick="return avSubmit(event)">
                    Log Visitor
                </button>
            </div>

        </form>
    </div>
</div>

<div class="modal-overlay" id="timein-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Log Time In</div>
            <button class="modal-close" onclick="closeModal('timein-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Log time in for <strong id="timein-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="timein-form" action="" data-loading-message="Logging time in...">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Time In</label>
                <input type="datetime-local" name="arrival_time" id="timein-input" required>
                <div class="hint">Status will automatically change to "Inside"</div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('timein-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Confirm Time In</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="timeout-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Log Time Out</div>
            <button class="modal-close" onclick="closeModal('timeout-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Log time out for <strong id="timeout-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="timeout-form" action="" data-loading-message="Logging time out...">
            @csrf
            <div class="modal-field">
                <label>Time Out</label>
                <input type="datetime-local" name="departure_time" id="timeout-input" required>
                <div class="hint">Status will automatically change to "Completed"</div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('timeout-modal')">Cancel</button>
                <button type="submit" class="btn-submit" style="background:var(--green);">Confirm Time Out</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="status-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Update Visitor Status</div>
            <button class="modal-close" onclick="closeModal('status-modal')">&#x2715;</button>
        </div>
        <p style="font-size:.9rem;color:var(--ink-muted);line-height:1.6;margin-bottom:1rem;">
            Update status for <strong id="status-name" style="color:var(--ink);"></strong>
        </p>
        <form method="POST" id="status-form" action="">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Status</label>
                <select name="status" id="status-select" class="status-select">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('status-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Status</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function showActionLoading(message) {
        var overlay = document.getElementById('action-loading');
        document.getElementById('action-loading-text').textContent = message || 'Please wait...';
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
    }

    function setFormLoading(form, message) {
        form.querySelectorAll('button[type="submit"]').forEach(function(btn) {
            btn.textContent = 'Please wait...';
            btn.disabled    = true;
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

    var visitors          = @json($visitors);
    var completedVisitors = @json($completedVisitors);
    var deletedVisitors   = @json($deletedVisitors);
    var cancelledVisitors = @json($cancelledVisitors);
    var allTenants        = @json($tenants);

    var PER_PAGE    = 7;
    var currentPage = 1;
    var filtered    = visitors.slice();
    var archiveTab  = 'completed';
    var _rowMap     = {};

    function fmtDateTime(d) {
        if (!d) return '&mdash;';
        var dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
             + ', ' + dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }

    function fmtDateTimePlain(d) {
        if (!d) return '—';
        var dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
             + ' ' + dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
        var dt = new Date(d);
        return dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' })
             + ' ' + dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }

    function fmtDate(s) {
        if (!s) return '—';
        var d = new Date(s + 'T00:00:00');
        return d.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function fmtTime(s) {
        if (!s) return '—';
        var parts = s.split(':');
        var hour  = parseInt(parts[0], 10);
        return (hour % 12 || 12) + ':' + parts[1] + ' ' + (hour >= 12 ? 'PM' : 'AM');
    }

    function badge(status) {
        var map = {
            'inside':    '<span class="badge badge-inside">Inside</span>',
            'approved':  '<span class="badge badge-approved">Approved</span>',
            'pending':   '<span class="badge badge-pending">Pending</span>',
            'rejected':  '<span class="badge badge-rejected">Rejected</span>',
            'completed': '<span class="badge badge-completed">Completed</span>',
            'cancelled': '<span class="badge badge-rejected">Cancelled</span>',
            'deleted':   '<span class="badge badge-rejected">Deleted</span>',
        };
        return map[status] || '<span class="badge badge-pending">' + (status || '') + '</span>';
    }

    function renderTable() {
        var start    = (currentPage - 1) * PER_PAGE;
        var pageData = filtered.slice(start, start + PER_PAGE);
        var tbody    = document.getElementById('visitor-tbody');

        if (pageData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="empty-state">No visitor logs found.</td></tr>';
        } else {
            tbody.innerHTML = pageData.map(function(v) {
                var canTimein  = !v.arrival_time && v.status !== 'rejected';
                var canTimeout = v.arrival_time && !v.departure_time;
                _rowMap[v.visitor_id] = v;

                return '<tr>'
                    + '<td class="td-name">' + (v.visitor_name || '') + '</td>'
                    + '<td>' + fmtDateTime(v.arrival_time) + '</td>'
                    + '<td>' + (v.departure_time ? fmtDateTime(v.departure_time) : '&mdash;') + '</td>'
                    + '<td>' + (v.purpose || '&mdash;') + '</td>'
                    + '<td>'
                        + '<div class="td-name">' + (v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '&mdash;') + '</div>'
                        + (v.tenant && v.tenant.room_number ? '<div class="td-sub">Rm ' + v.tenant.room_number + '</div>' : '')
                    + '</td>'
                    + '<td>'
                        + '<div class="td-name">' + (v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '&mdash;') + '</div>'
                    + '</td>'
                    + '<td>' + badge(v.status) + '</td>'
                    + '<td>'
                        + '<div class="action-group">'
                            + '<button class="act-btn" title="View Details" onclick="viewVisitorDetail(_rowMap[' + v.visitor_id + '])">'
                                + '<img src="{{ asset('icons/eye.png') }}" alt="View">'
                            + '</button>'
                            + '<button class="act-btn green" title="Log Time In" ' + (!canTimein ? 'disabled' : '') + ' onclick="openTimein(' + v.visitor_id + ', \'' + (v.visitor_name || '').replace(/'/g, "\\'") + '\')">'
                                + '<img src="{{ asset('icons/check.png') }}" alt="Time In">'
                            + '</button>'
                            + '<button class="act-btn blue" title="Log Time Out" ' + (!canTimeout ? 'disabled' : '') + ' onclick="openTimeout(' + v.visitor_id + ', \'' + (v.visitor_name || '').replace(/'/g, "\\'") + '\')">'
                                + '<img src="{{ asset('icons/logout.png') }}" alt="Time Out">'
                            + '</button>'
                            + '<button class="act-btn" title="Notify Tenant" ' + (!v.tenant_id ? 'disabled' : '') + ' onclick="notifyTenant(' + v.visitor_id + ', this)">'
                                + '<img src="{{ asset('icons/bell.png') }}" alt="Notify">'
                            + '</button>'
                        + '</div>'
                    + '</td>'
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
        var pg   = document.getElementById('pagination');
        var html = '';
        html += '<button class="page-btn" onclick="goPage(' + (currentPage - 1) + ')" ' + (currentPage === 1 ? 'disabled' : '') + '>&#8249;</button>';
        for (var i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += '<button class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goPage(' + i + ')">' + i + '</button>';
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += '<span class="page-ellipsis">&#8230;</span>';
            }
        }
        html += '<button class="page-btn" onclick="goPage(' + (currentPage + 1) + ')" ' + (currentPage === totalPages || totalPages === 0 ? 'disabled' : '') + '>&#8250;</button>';
        pg.innerHTML = html;
    }

    function goPage(p) {
        var totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        renderTable();
    }

    var _fdFilterDebounce  = null;
    var _fdArchiveDebounce = null;

    function filterTable() {
        clearTimeout(_fdFilterDebounce);
        _fdFilterDebounce = setTimeout(_runFdFilters, 180);
    }

    function sortTable() { filterTable(); }

    function clearDates() {
        document.getElementById('date-from').value                 = '';
        document.getElementById('date-to').value                   = '';
        document.getElementById('date-from').style.borderColor     = '';
        document.getElementById('date-to').style.borderColor       = '';
        document.getElementById('date-error-fd').style.display     = 'none';
        document.getElementById('date-clear-btn-fd').style.display = 'none';
        filterTable();
    }

    function _runFdFilters() {
        var q        = document.getElementById('search-input').value.toLowerCase();
        var from     = document.getElementById('date-from').value;
        var to       = document.getElementById('date-to').value;
        var sort     = document.getElementById('sort-select').value;
        var dateErr  = document.getElementById('date-error-fd');
        var clearBtn = document.getElementById('date-clear-btn-fd');
        var fromEl   = document.getElementById('date-from');
        var toEl     = document.getElementById('date-to');

        if (from && to && from > to) {
            dateErr.style.visibility = 'hidden';
            dateErr.style.display    = 'block';
            var rect = toEl.getBoundingClientRect();
            dateErr.style.top        = (rect.bottom + 6) + 'px';
            dateErr.style.left       = rect.left + 'px';
            dateErr.style.visibility = '';
            fromEl.style.borderColor = '#ffc2d1';
            toEl.style.borderColor   = '#ffc2d1';
            return;
        }

        dateErr.style.display    = 'none';
        fromEl.style.borderColor = '';
        toEl.style.borderColor   = '';
        clearBtn.style.display   = (from || to) ? 'inline' : 'none';

        filtered = visitors.filter(function(v) {
            var matchQ = !q
                || (v.visitor_name || '').toLowerCase().includes(q)
                || (v.purpose || '').toLowerCase().includes(q)
                || (v.tenant ? (v.tenant.first_name + ' ' + v.tenant.last_name).toLowerCase().includes(q) : false)
                || (v.tenant && v.tenant.room_number ? String(v.tenant.room_number).toLowerCase().includes(q) : false);

            var arrDate   = v.arrival_time ? v.arrival_time.substring(0, 10) : (v.date_of_visit || '');
            var matchFrom = !from || arrDate >= from;
            var matchTo   = !to   || arrDate <= to;

            return matchQ && matchFrom && matchTo;
        });

        if (sort === 'newest') filtered.sort(function(a, b) { return new Date(b.arrival_time || b.date_of_visit || 0) - new Date(a.arrival_time || a.date_of_visit || 0); });
        if (sort === 'oldest') filtered.sort(function(a, b) { return new Date(a.arrival_time || a.date_of_visit || 0) - new Date(b.arrival_time || b.date_of_visit || 0); });
        if (sort === 'name')   filtered.sort(function(a, b) { return (a.visitor_name || '').localeCompare(b.visitor_name || ''); });
        if (sort === 'status') filtered.sort(function(a, b) { return (a.status || '').localeCompare(b.status || ''); });

        currentPage = 1;
        renderTable();
    }

    function vmInfoItem(label, value, full) {
        return '<div class="vmodal-info-item' + (full ? ' full' : '') + '">'
            + '<div class="vmodal-info-item-label">' + label + '</div>'
            + '<div class="vmodal-info-item-value">' + value + '</div>'
            + '</div>';
    }

    function switchVModalTab(tab) {
        ['info', 'photo'].forEach(function(t) {
            document.getElementById('vmtab-' + t).classList.toggle('active',   t === tab);
            document.getElementById('vmpanel-' + t).classList.toggle('active', t === tab);
        });
    }

    function viewVisitorDetail(v) {
        document.getElementById('vmodalHeaderName').textContent = v.visitor_name || '—';
        document.getElementById('vmodalHeaderId').textContent   = 'LOG-' + String(v.visitor_id).padStart(4, '0');

        var bBadges = '';
        if (v.status)  bBadges += '<span class="vmodal-header-badge">' + v.status.replace(/\b\w/g, function(c) { return c.toUpperCase(); }) + '</span>';
        if (v.purpose) bBadges += '<span class="vmodal-header-badge">' + v.purpose + '</span>';
        document.getElementById('vmodalHeaderBadges').innerHTML = bBadges;

        document.getElementById('vminfo-personal').innerHTML =
            vmInfoItem('Full Name',    v.visitor_name || '—')
            + vmInfoItem('Contact No.', v.contact_no  || '—');

        var tenantName = v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '—';
        var roomNum    = v.tenant && v.tenant.room_number ? 'Rm ' + v.tenant.room_number : '—';

        document.getElementById('vminfo-visit').innerHTML =
            vmInfoItem('Purpose',        v.purpose  || '—')
            + vmInfoItem('Tenant Visited', tenantName)
            + vmInfoItem('Room',           roomNum);

        var timeInVal  = v.arrival_time   ? fmtDateTimePlain(v.arrival_time)   : '<span style="color:#bbb;font-style:italic;font-size:.8rem">Not yet</span>';
        var timeOutVal = v.departure_time ? fmtDateTimePlain(v.departure_time) : (v.arrival_time ? '<span style="color:#c8960c;font-weight:700">Still Inside</span>' : '—');

        document.getElementById('vminfo-schedule').innerHTML =
            vmInfoItem('Expected Date', fmtDate(v.date_of_visit))
            + vmInfoItem('Expected Time', fmtTime(v.time_of_visit))
            + vmInfoItem('Time In',  timeInVal)
            + vmInfoItem('Time Out', timeOutVal);

        var staffName = v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '—';
        document.getElementById('vminfo-log').innerHTML =
            vmInfoItem('Status',    badge(v.status))
            + vmInfoItem('Logged By', staffName);

        document.getElementById('vminfo-idtype').innerHTML =
            vmInfoItem('ID Type', v.id_type || '—', true);

        var photoArea = '';
        if (v.id_photo) {
            var src = v.id_photo.startsWith('http') ? v.id_photo : '/storage/' + v.id_photo;
            window.__currentPhotoSrc = src;
            photoArea =
                '<div class="vmodal-photo-frame">'
                    + '<img src="' + src + '" alt="ID Photo" id="vmodal-id-photo"'
                    + ' onerror="document.getElementById(\'vmodal-id-photo\').style.display=\'none\'; document.getElementById(\'vmodal-photo-error\').style.display=\'flex\';">'
                    + '<div id="vmodal-photo-error" class="vmodal-photo-no" style="display:none;">'
                        + '<p>Could not load photo.</p>'
                    + '</div>'
                + '</div>'
                + '<div class="vmodal-photo-actions">'
                    + '<button class="vmodal-photo-btn vmodal-photo-btn-primary" onclick="openLightbox(window.__currentPhotoSrc, \'' + (v.id_type || 'ID Photo') + '\')">'
                        + 'View Photo'
                    + '</button>'
                    + '<a class="vmodal-photo-btn-outline vmodal-photo-btn" href="' + src + '" target="_blank" rel="noopener">'
                        + 'Open Full Image &#x2197;'
                    + '</a>'
                + '</div>';
        } else {
            photoArea =
                '<div class="vmodal-photo-frame">'
                    + '<div class="vmodal-photo-no">'
                        + '<p>No ID photo uploaded.</p>'
                    + '</div>'
                + '</div>';
        }
        document.getElementById('vminfo-photo').innerHTML = photoArea;

        switchVModalTab('info');
        document.getElementById('visitorDetailModal').style.display = 'flex';
    }

    function closeVisitorDetailModal() {
        document.getElementById('visitorDetailModal').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('visitorDetailModal')) closeVisitorDetailModal();
    });

    function openLightbox(src, caption) {
        document.getElementById('lightboxImg').src             = src;
        document.getElementById('lightboxOpenLink').href       = src;
        document.getElementById('lightboxCaption').textContent = caption || 'ID Photo';
        document.getElementById('photoLightbox').style.display = 'flex';
    }

    function closeLightbox(e) {
        if (e.target === document.getElementById('photoLightbox')) {
            document.getElementById('photoLightbox').style.display = 'none';
        }
    }

    function closeLightboxBtn() {
        document.getElementById('photoLightbox').style.display = 'none';
    }

    function openTimein(id, name) {
        document.getElementById('timein-name').textContent = name;
        document.getElementById('timein-form').action      = '/visitors/timein/' + id;
        document.getElementById('timein-input').value      = new Date().toISOString().slice(0, 16);
        closeVisitorDetailModal();
        openModal('timein-modal');
    }

    function openTimeout(id, name) {
        document.getElementById('timeout-name').textContent = name;
        document.getElementById('timeout-form').action      = '/visitors/checkout/' + id;
        document.getElementById('timeout-input').value      = new Date().toISOString().slice(0, 16);
        closeVisitorDetailModal();
        openModal('timeout-modal');
    }

    function notifyTenant(id, btn) {
        if (!id || !btn || btn.disabled) return;
        btn.disabled = true;
        showToast('Sending tenant push notification...', '');

        fetch('/visitors/' + id + '/notify-tenant', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(function(res) {
            return res.json().then(function(data) { return { ok: res.ok, data: data }; });
        })
        .then(function(result) {
            showToast(result.data.message || (result.ok ? 'Tenant notified.' : 'Unable to notify tenant.'), result.ok ? 'success' : 'error');
        })
        .catch(function() {
            showToast('Unable to notify tenant right now.', 'error');
        })
        .finally(function() {
            btn.disabled = false;
        });
    }

    function exportVisitorsCsv() {
        var rows = [['Visitor Name', 'Time In', 'Time Out', 'Purpose', 'Tenant', 'Room', 'Logged By', 'Status']];
        visitors.forEach(function(v) {
            rows.push([
                v.visitor_name   || '',
                v.arrival_time   || '',
                v.departure_time || '',
                v.purpose        || '',
                v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '',
                v.tenant && v.tenant.room_number ? v.tenant.room_number : '',
                v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '',
                v.status || '',
            ]);
        });
        var csv  = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var blob = new Blob([csv], { type: 'text/csv' });
        var a    = document.createElement('a');
        a.href   = URL.createObjectURL(blob);
        a.download = 'dormease-visitors.csv';
        a.click();
        URL.revokeObjectURL(a.href);
        showToast('Visitors exported as CSV!', 'success');
    }

    function exportVisitorsPdf() {
        if (!visitors.length) { showToast('No data to export.', 'error'); return; }
        var win = window.open('', '_blank');
        if (!win) { showToast('PDF export was blocked. Please allow popups for this site.', 'error'); return; }
        var rows = visitors.map(function(v) {
            return '<tr>'
                + '<td>' + (v.visitor_name || '') + '</td>'
                + '<td>' + (v.arrival_time   ? fmtDatePlain(v.arrival_time)   : '') + '</td>'
                + '<td>' + (v.departure_time ? fmtDatePlain(v.departure_time) : 'Still Inside') + '</td>'
                + '<td>' + (v.purpose || '') + '</td>'
                + '<td>' + (v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '') + '</td>'
                + '<td>' + (v.tenant && v.tenant.room_number ? v.tenant.room_number : '') + '</td>'
                + '<td>' + (v.staff ? v.staff.first_name + ' ' + v.staff.last_name : '') + '</td>'
                + '<td>' + (v.status || '') + '</td>'
                + '</tr>';
        }).join('');
        win.document.write('<!DOCTYPE html><html><head><title>Visitor Logs</title>'
            + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<p>Visitor Logs - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
            + '<table><thead><tr><th>Visitor Name</th><th>Time In</th><th>Time Out</th><th>Purpose</th><th>Tenant</th><th>Room</th><th>Logged By</th><th>Status</th></tr></thead>'
            + '<tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
    }

    function openArchive() {
        document.getElementById('acount-completed').textContent = completedVisitors.length;
        document.getElementById('acount-deleted').textContent   = deletedVisitors.length;
        document.getElementById('acount-cancelled').textContent = cancelledVisitors.length;
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        switchArchiveTab('completed');
    }

    function closeArchive() {
        document.getElementById('archive-drawer').classList.remove('open');
        document.getElementById('archive-backdrop').classList.remove('open');
    }

    function switchArchiveTab(tab) {
        archiveTab = tab;
        document.getElementById('atab-completed').classList.toggle('active', tab === 'completed');
        document.getElementById('atab-deleted').classList.toggle('active',   tab === 'deleted');
        document.getElementById('atab-cancelled').classList.toggle('active', tab === 'cancelled');
        document.getElementById('archive-search').value = '';
        renderArchive();
    }

    function renderArchive() {
        clearTimeout(_fdArchiveDebounce);
        _fdArchiveDebounce = setTimeout(_runFdRenderArchive, 150);
    }

    function _runFdRenderArchive() {
        var q = document.getElementById('archive-search').value.toLowerCase();

        var data;
        if (archiveTab === 'completed') {
            data = completedVisitors;
        } else if (archiveTab === 'deleted') {
            data = deletedVisitors;
        } else {
            data = cancelledVisitors;
        }

        var result = data.filter(function(v) {
            return (v.visitor_name || '').toLowerCase().includes(q)
                || (v.purpose || '').toLowerCase().includes(q)
                || (v.tenant ? (v.tenant.first_name + ' ' + v.tenant.last_name).toLowerCase().includes(q) : false)
                || (v.tenant && v.tenant.room_number ? (v.tenant.room_number + '').toLowerCase().includes(q) : false);
        });

        var list = document.getElementById('archive-list');
        document.getElementById('archive-count-label').textContent = result.length + ' record' + (result.length !== 1 ? 's' : '');

        if (result.length === 0) {
            list.innerHTML = '<div class="archive-empty">'
                + '<img class="archive-empty-icon" src="{{ asset('icons/visitor.png') }}" alt="">'
                + 'No ' + archiveTab + ' visitor logs found.'
                + '</div>';
            return;
        }

        var pillClass   = archiveTab === 'completed' ? 'archive-pill-completed' : 'archive-pill-deleted';
        var pillLabel   = archiveTab === 'completed' ? 'Completed' : (archiveTab === 'deleted' ? 'Deleted' : 'Cancelled');
        var footerLabel = archiveTab === 'completed' ? 'Checked out on' : (archiveTab === 'deleted' ? 'Deleted on' : 'Cancelled on');

        list.innerHTML = result.map(function(v, i) {
            var tenantName = v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : null;
            var roomNum    = v.tenant && v.tenant.room_number ? v.tenant.room_number : null;
            var logTime    = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
            var footerDate = archiveTab === 'completed'
                ? (v.departure_time ? fmtDatePlain(v.departure_time) : fmtDatePlain(v.arrival_time))
                : archiveTab === 'cancelled'
                    ? (v.cancelled_at ? fmtDatePlain(v.cancelled_at) : logTime)
                    : logTime;

            return '<div class="archive-card" style="animation-delay:' + (i * 0.04) + 's;">'
                + '<div class="archive-card-top">'
                    + '<div class="archive-card-id">LOG-' + String(v.visitor_id).padStart(4, '0') + '</div>'
                    + '<div class="archive-card-time">' + logTime + '</div>'
                + '</div>'
                + '<div class="archive-card-visitor">' + (v.visitor_name || '&mdash;') + '</div>'
                + (tenantName ? '<div class="archive-card-tenant">Visited: ' + tenantName + (roomNum ? ' - Rm ' + roomNum : '') + '</div>' : '')
                + '<div class="archive-card-meta">'
                    + '<span class="archive-pill archive-pill-purpose">' + (v.purpose || 'Other') + '</span>'
                    + '<span class="archive-pill ' + pillClass + '">' + pillLabel + '</span>'
                + '</div>'
                + '<div class="archive-card-footer">'
                    + footerLabel + ': <span>' + footerDate + '</span>'
                + '</div>'
                + '</div>';
        }).join('');
    }

    function exportArchiveCsv() {
        var data;
        if (archiveTab === 'completed') {
            data = completedVisitors;
        } else if (archiveTab === 'deleted') {
            data = deletedVisitors;
        } else {
            data = cancelledVisitors;
        }

        if (!data.length) { showToast('No archive data to export.', 'error'); return; }

        var label;
        if (archiveTab === 'completed') {
            label = 'Checked Out On';
        } else if (archiveTab === 'deleted') {
            label = 'Deleted On';
        } else {
            label = 'Cancelled On';
        }

        var rows = [['Log ID', 'Visitor Name', 'Contact No.', 'Purpose', 'Tenant', 'Room', 'Time In', 'Time Out', 'Status', label]];
        data.forEach(function(v) {
            var logTime    = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
            var footerDate = archiveTab === 'completed'
                ? (v.departure_time ? fmtDatePlain(v.departure_time) : fmtDatePlain(v.arrival_time))
                : archiveTab === 'cancelled'
                    ? (v.cancelled_at ? fmtDatePlain(v.cancelled_at) : logTime)
                    : logTime;
            rows.push([
                'LOG-' + String(v.visitor_id).padStart(4, '0'),
                v.visitor_name   || '',
                v.contact_no     || '',
                v.purpose        || '',
                v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '',
                v.tenant && v.tenant.room_number ? v.tenant.room_number : '',
                v.arrival_time   || '',
                v.departure_time || '',
                v.status         || '',
                footerDate,
            ]);
        });
        var csv = rows.map(function(r) { return r.map(function(c) { return '"' + String(c).replace(/"/g, '""') + '"'; }).join(','); }).join('\n');
        var a   = document.createElement('a');
        a.href  = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
        a.download = 'dormease-visitors-' + archiveTab + '-archive.csv';
        a.click();
        URL.revokeObjectURL(a.href);
        showToast('Archive exported as CSV!', 'success');
    }

    function exportArchivePdf() {
        var data;
        if (archiveTab === 'completed') {
            data = completedVisitors;
        } else if (archiveTab === 'deleted') {
            data = deletedVisitors;
        } else {
            data = cancelledVisitors;
        }

        if (!data.length) { showToast('No archive data to export.', 'error'); return; }

        var tabLabel;
        if (archiveTab === 'completed') {
            tabLabel = 'Completed';
        } else if (archiveTab === 'deleted') {
            tabLabel = 'Deleted';
        } else {
            tabLabel = 'Cancelled';
        }

        var footerHead;
        if (archiveTab === 'completed') {
            footerHead = 'Checked Out On';
        } else if (archiveTab === 'deleted') {
            footerHead = 'Deleted On';
        } else {
            footerHead = 'Cancelled On';
        }

        var win  = window.open('', '_blank');
        var rows = data.map(function(v) {
            var logTime    = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
            var footerDate = archiveTab === 'completed'
                ? (v.departure_time ? fmtDatePlain(v.departure_time) : fmtDatePlain(v.arrival_time))
                : archiveTab === 'cancelled'
                    ? (v.cancelled_at ? fmtDatePlain(v.cancelled_at) : logTime)
                    : logTime;
            return '<tr>'
                + '<td>LOG-' + String(v.visitor_id).padStart(4, '0') + '</td>'
                + '<td>' + (v.visitor_name || '') + '</td>'
                + '<td>' + (v.contact_no || '') + '</td>'
                + '<td>' + (v.purpose || '') + '</td>'
                + '<td>' + (v.tenant ? v.tenant.first_name + ' ' + v.tenant.last_name : '') + '</td>'
                + '<td>' + (v.tenant && v.tenant.room_number ? v.tenant.room_number : '') + '</td>'
                + '<td>' + (v.arrival_time   ? fmtDatePlain(v.arrival_time)   : '') + '</td>'
                + '<td>' + (v.departure_time ? fmtDatePlain(v.departure_time) : '') + '</td>'
                + '<td>' + (v.status || '') + '</td>'
                + '<td>' + footerDate + '</td>'
                + '</tr>';
        }).join('');
        win.document.write('<!DOCTYPE html><html><head><title>Visitor Logs Archive - ' + tabLabel + '</title>'
            + '<style>body{font-family:sans-serif;font-size:12px;padding:24px}h2{color:#E8175D;margin-bottom:4px}p{color:#888;margin-bottom:16px;font-size:11px}table{width:100%;border-collapse:collapse}th{background:#fce8f1;color:#E8175D;padding:8px;text-align:left;font-size:11px;text-transform:uppercase}td{padding:7px 8px;border-bottom:1px solid #fce4ec;vertical-align:top}</style>'
            + '</head><body>'
            + '<h2>Sanctissimo Rosario Ladies Dormitory</h2>'
            + '<p>Visitor Logs Archive - ' + tabLabel + ' - exported ' + new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</p>'
            + '<table><thead><tr><th>Log ID</th><th>Visitor Name</th><th>Contact No.</th><th>Purpose</th><th>Tenant</th><th>Room</th><th>Time In</th><th>Time Out</th><th>Status</th><th>' + footerHead + '</th></tr></thead>'
            + '<tbody>' + rows + '</tbody></table>'
            + '</body></html>');
        win.document.close();
        win.print();
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
        var spaceBelow = window.innerHeight - rect.bottom;
        if (spaceBelow >= (menu.offsetHeight || 80) + 6) {
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
        if (!e.target.closest('.export-dropdown')) closeAllExportDropdowns();
    });

    var _avSelectedTenantId   = null;
    var _avTenantDropdownOpen = false;
    var _avTenantFocusIdx     = -1;
    var _avBlurTimer          = null;

    function avShowErr(id, show) {
        var el = document.getElementById(id);
        if (el) el.classList.toggle('show', !!show);
    }

    function avSetFieldState(input, state) {
        if (!input) return;
        input.classList.remove('valid', 'invalid');
        if (state === 'valid')   input.classList.add('valid');
        if (state === 'invalid') input.classList.add('invalid');
    }

    function avValidateName(input, strict) {
        var v     = input.value;
        var count = document.getElementById('av_name_count');
        if (count) count.textContent = v.length + ' / 100';

        var trimmed = v.trim();
        var valid   = /^[A-Za-zÀ-ÖØ-öø-ÿ\s'\-\.]+$/.test(trimmed) && trimmed.length >= 2;

        if (strict || trimmed.length > 0) {
            avSetFieldState(input, valid ? 'valid' : 'invalid');
            avShowErr('av_visitor_name_err', !valid);
        } else {
            avSetFieldState(input, '');
            avShowErr('av_visitor_name_err', false);
        }
        return valid && trimmed.length > 0;
    }

    function avValidateContact(input, strict) {
        var v = input.value.trim();
        if (!v) {
            avSetFieldState(input, '');
            avShowErr('av_contact_err', false);
            return true;
        }
        var valid = /^(09|\+?639)\d{9}$/.test(v.replace(/[\s\-]/g, ''));
        if (strict || v.length > 3) {
            avSetFieldState(input, valid ? 'valid' : 'invalid');
            avShowErr('av_contact_err', !valid);
        }
        return valid;
    }

    function avValidateIdType(select, strict) {
        var valid = select.value !== '';
        if (strict || select.value) {
            avSetFieldState(select, valid ? 'valid' : 'invalid');
            avShowErr('av_id_err', !valid);
        } else {
            avSetFieldState(select, '');
            avShowErr('av_id_err', false);
        }
        return valid;
    }

    function avValidatePurpose(select, strict) {
        var valid = select.value !== '';
        if (strict || select.value) {
            avSetFieldState(select, valid ? 'valid' : 'invalid');
            avShowErr('av_purpose_err', !valid);
        }
        return valid;
    }

    function avValidateArrival(input, strict) {
        var v   = input.value;
        var now = new Date();
        var sel = v ? new Date(v) : null;
        if (!v) {
            if (strict) { avSetFieldState(input, 'invalid'); avShowErr('av_arrival_err', true); }
            return false;
        }
        var valid = sel <= now;
        avSetFieldState(input, valid ? 'valid' : 'invalid');
        avShowErr('av_arrival_err', !valid);
        return valid;
    }

    function avValidateTenant() {
        var valid = !!_avSelectedTenantId;
        var inp   = document.getElementById('av_tenant_search');
        if (inp) inp.classList.toggle('invalid', !valid);
        avShowErr('av_tenant_err', !valid);
        return valid;
    }

    function avHighlightMatch(text, query) {
        if (!query) return _escHtml(text);
        var escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        return _escHtml(text).replace(new RegExp('(' + escaped + ')', 'gi'), '<mark>$1</mark>');
    }

    function _escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function avBuildDropdown(query) {
        var dd   = document.getElementById('av_tenant_dropdown');
        var q    = (query || '').toLowerCase().trim();
        var list = allTenants.filter(function(t) {
            var name = (t.first_name + ' ' + t.last_name).toLowerCase();
            return !q || name.includes(q);
        });

        if (!list.length) {
            dd.innerHTML = '<div class="tenant-option-empty">No tenants found for "' + _escHtml(query) + '"</div>';
        } else {
            dd.innerHTML = list.map(function(t, i) {
                var fullName = t.first_name + ' ' + t.last_name;
                var selected = String(t.tenant_id) === String(_avSelectedTenantId);
                return '<div class="tenant-option' + (selected ? ' selected' : '') + '" '
                    + 'data-id="' + t.tenant_id + '" '
                    + 'data-name="' + _escHtml(fullName) + '" '
                    + 'data-idx="' + i + '" '
                    + 'onmousedown="avSelectTenant(event, \'' + t.tenant_id + '\', \'' + _escHtml(fullName) + '\')">'
                    + '<span class="tenant-option-name">' + avHighlightMatch(fullName, query) + '</span>'
                    + (t.room_number ? '<span class="tenant-option-room">Rm ' + _escHtml(String(t.room_number)) + '</span>' : '')
                    + '</div>';
            }).join('');
        }
        _avTenantFocusIdx = -1;
    }

    function avOpenTenantDropdown() {
        clearTimeout(_avBlurTimer);
        var dd  = document.getElementById('av_tenant_dropdown');
        var chv = document.getElementById('av_tenant_chevron');
        avBuildDropdown(document.getElementById('av_tenant_search').value);
        dd.classList.add('open');
        if (chv) chv.classList.add('open');
        _avTenantDropdownOpen = true;
    }

    function avCloseTenantDropdown() {
        var dd  = document.getElementById('av_tenant_dropdown');
        var chv = document.getElementById('av_tenant_chevron');
        dd.classList.remove('open');
        if (chv) chv.classList.remove('open');
        _avTenantDropdownOpen = false;
        _avTenantFocusIdx     = -1;
    }

    function avOnTenantBlur() {
        _avBlurTimer = setTimeout(function() {
            avCloseTenantDropdown();
            if (!_avSelectedTenantId) {
                document.getElementById('av_tenant_search').value = '';
            }
            avValidateTenant();
        }, 180);
    }

    function avSelectTenant(e, id, name) {
        e.preventDefault();
        clearTimeout(_avBlurTimer);
        _avSelectedTenantId = id;
        document.getElementById('av_tenant_id').value        = id;
        document.getElementById('av_tenant_search').value    = name;
        document.getElementById('av_tenant_search').classList.remove('invalid');
        document.getElementById('av_tenant_search').classList.add('valid');
        avShowErr('av_tenant_err', false);
        avCloseTenantDropdown();
    }

    function avFilterTenants() {
        if (!_avTenantDropdownOpen) avOpenTenantDropdown();
        _avSelectedTenantId = null;
        document.getElementById('av_tenant_id').value = '';
        document.getElementById('av_tenant_search').classList.remove('valid', 'invalid');
        avBuildDropdown(document.getElementById('av_tenant_search').value);
    }

    function avTenantKeyNav(e) {
        var dd      = document.getElementById('av_tenant_dropdown');
        var options = dd.querySelectorAll('.tenant-option');
        if (!options.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!_avTenantDropdownOpen) avOpenTenantDropdown();
            _avTenantFocusIdx = Math.min(_avTenantFocusIdx + 1, options.length - 1);
            avHighlightOption(options);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            _avTenantFocusIdx = Math.max(_avTenantFocusIdx - 1, 0);
            avHighlightOption(options);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (_avTenantFocusIdx >= 0 && options[_avTenantFocusIdx]) {
                var opt = options[_avTenantFocusIdx];
                avSelectTenant(e, opt.dataset.id, opt.dataset.name);
            }
        } else if (e.key === 'Escape') {
            avCloseTenantDropdown();
        }
    }

    function avHighlightOption(options) {
        options.forEach(function(o, i) { o.classList.toggle('focused', i === _avTenantFocusIdx); });
        if (_avTenantFocusIdx >= 0 && options[_avTenantFocusIdx]) {
            options[_avTenantFocusIdx].scrollIntoView({ block: 'nearest' });
        }
    }

    function avSubmit(e) {
        var nameOk    = avValidateName(document.getElementById('av_visitor_name'), true);
        var contactOk = avValidateContact(document.getElementById('av_contact_no'), true);
        var tenantOk  = avValidateTenant();
        var idOk      = avValidateIdType(document.getElementById('av_id_type'), true);
        var purposeOk = avValidatePurpose(document.getElementById('av_purpose'), true);
        var arrivalOk = avValidateArrival(document.getElementById('av_arrival_time'), true);

        if (!nameOk || !contactOk || !tenantOk || !idOk || !purposeOk || !arrivalOk) {
            e.preventDefault();
            return false;
        }
        showActionLoading('Logging visitor...');
        return true;
    }

    function resetAddForm() {
        var form = document.getElementById('add-visitor-form');
        if (form) form.reset();
        _avSelectedTenantId = null;
        var si = document.getElementById('av_tenant_search');
        if (si) { si.value = ''; si.classList.remove('valid', 'invalid'); }
        var ti = document.getElementById('av_tenant_id');
        if (ti) ti.value = '';
        avCloseTenantDropdown();
        ['av_visitor_name','av_contact_no','av_id_type','av_purpose','av_arrival_time'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.classList.remove('valid', 'invalid');
        });
        ['av_visitor_name_err','av_contact_err','av_tenant_err','av_id_err','av_purpose_err','av_arrival_err'].forEach(function(id) {
            avShowErr(id, false);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var ni = document.getElementById('av_arrival_time');
        if (ni && !ni.value) ni.value = new Date().toISOString().slice(0, 16);

        var oldTenant = '{{ old('tenant_id') }}';
        if (oldTenant) {
            var found = allTenants.find(function(t) { return String(t.tenant_id) === String(oldTenant); });
            if (found) {
                _avSelectedTenantId = oldTenant;
                document.getElementById('av_tenant_id').value     = oldTenant;
                document.getElementById('av_tenant_search').value = found.first_name + ' ' + found.last_name;
                document.getElementById('av_tenant_search').classList.add('valid');
            }
        }
    });

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });
    @endif

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ $errors->first() }}', 'error');
            openModal('add-modal');
        });
    @endif

    filtered = visitors.slice();
    renderTable();

    (function() {
        var popup = document.getElementById('fd-visitor-legend-popup');
        if (!popup) return;
        document.body.appendChild(popup);
        popup.style.display  = 'none';
        popup.style.position = 'fixed';
        popup.style.zIndex   = '99999';
        var hideTimer  = null;
        var popupWidth = 360;
        document.querySelectorAll('#fd-visitor-legend-trigger').forEach(function(wrap) {
            wrap.addEventListener('mouseenter', function() {
                clearTimeout(hideTimer);
                popup.style.visibility = 'hidden';
                popup.style.display    = 'block';
                var popupH = popup.offsetHeight || 220;
                popup.style.display    = 'none';
                popup.style.visibility = '';
                var rect = wrap.getBoundingClientRect();
                var left = rect.left;
                if (left + popupWidth > window.innerWidth - 12) left = window.innerWidth - popupWidth - 12;
                if (left < 8) left = 8;
                var spaceBelow = window.innerHeight - rect.bottom;
                var top = spaceBelow >= popupH + 10 ? rect.bottom + 8 : Math.max(8, rect.top - popupH - 8);
                popup.style.top  = top + 'px';
                popup.style.left = left + 'px';
                popup.style.display = 'block';
            });
            wrap.addEventListener('mouseleave', function() {
                hideTimer = setTimeout(function() { popup.style.display = 'none'; }, 150);
            });
        });
        popup.addEventListener('mouseenter', function() { clearTimeout(hideTimer); });
        popup.addEventListener('mouseleave', function() {
            hideTimer = setTimeout(function() { popup.style.display = 'none'; }, 150);
        });
    })();
</script>
@endsection