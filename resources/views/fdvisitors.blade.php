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

    .vmodal-time-row { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: .6rem .8rem; margin-top: .55rem; }

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

    .export-dropdown { position: relative; display: inline-flex; }
    .export-menu { display: none; background: var(--white); border: 1.5px solid var(--pink-light); border-radius: 12px; box-shadow: 0 8px 24px rgba(232,23,93,.15); min-width: 160px; overflow: hidden; }
    .export-menu.open { display: block; }
    .export-menu button { display: block; width: 100%; padding: .65rem 1rem; background: none; border: none; text-align: left; font-size: .84rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: background .15s; font-family: var(--ff-body); }
    .export-menu button:hover { background: var(--pink-bg); color: var(--bright-pink); }
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
    <div class="modal" style="max-width:540px;">
        <div class="modal-header">
            <div class="modal-title">Add Walk-in Visitor</div>
            <button class="modal-close" onclick="closeModal('add-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('visitors.store') }}" data-loading-message="Logging visitor...">
            @csrf
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Visitor Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="visitor_name" placeholder="e.g. Maria Santos" required value="{{ old('visitor_name') }}">
                </div>
                <div class="modal-field">
                    <label>Contact No.</label>
                    <input type="text" name="contact_no" placeholder="e.g. 0912-345-6789" value="{{ old('contact_no') }}">
                </div>
                <div class="modal-field">
                    <label>Tenant to Visit <span style="color:var(--red)">*</span></label>
                    <select name="tenant_id" required>
                        <option value="">Select Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id') == $tenant->tenant_id ? 'selected' : '' }}>
                                {{ $tenant->first_name }} {{ $tenant->last_name }}
                                @if($tenant->room_number) &mdash; Rm {{ $tenant->room_number }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-field">
                    <label>Purpose of Visit <span style="color:var(--red)">*</span></label>
                    <select name="purpose" required>
                        <option value="">Select Purpose</option>
                        <option value="Visiting Tenant">Visiting Tenant</option>
                        <option value="Food Delivery">Food Delivery</option>
                        <option value="Laundry Pickup">Laundry Pickup</option>
                        <option value="Package Delivery">Package Delivery</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>ID Type</label>
                    <select name="id_type">
                        <option value="">Select ID Type</option>
                        <option value="School ID">School ID</option>
                        <option value="Government ID">Government ID</option>
                        <option value="Passport">Passport</option>
                        <option value="Driver's License">Driver's License</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Time In <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="arrival_time" required value="{{ old('arrival_time', now()->format('Y-m-d\TH:i')) }}">
                    <div class="hint">Status will auto-set to "Inside"</div>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('add-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Log Visitor</button>
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

    var PER_PAGE    = 7;
    var currentPage = 1;
    var filtered    = visitors.slice();
    var archiveTab  = 'completed';

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
                var safeV      = JSON.stringify(v).replace(/'/g, "&#39;");

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
                            + '<button class="act-btn" title="View Details" onclick=\'viewVisitorDetail(' + safeV + ')\'>'
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

    function filterTable() {
        var q    = document.getElementById('search-input').value.toLowerCase();
        var from = document.getElementById('date-from').value;
        var to   = document.getElementById('date-to').value;

        filtered = visitors.filter(function(v) {
            var matchQ = !q
                || (v.visitor_name || '').toLowerCase().includes(q)
                || (v.purpose || '').toLowerCase().includes(q)
                || (v.tenant ? (v.tenant.first_name + ' ' + v.tenant.last_name).toLowerCase().includes(q) : false)
                || (v.tenant && v.tenant.room_number ? (v.tenant.room_number + '').toLowerCase().includes(q) : false);

            var arrDate   = v.arrival_time ? v.arrival_time.substring(0, 10) : (v.date_of_visit || '');
            var matchFrom = !from || arrDate >= from;
            var matchTo   = !to   || arrDate <= to;

            return matchQ && matchFrom && matchTo;
        });

        currentPage = 1;
        renderTable();
    }

    function sortTable() {
        var val = document.getElementById('sort-select').value;
        if (val === 'newest') filtered.sort(function(a, b) { return new Date(b.arrival_time || b.date_of_visit) - new Date(a.arrival_time || a.date_of_visit); });
        if (val === 'oldest') filtered.sort(function(a, b) { return new Date(a.arrival_time || a.date_of_visit) - new Date(b.arrival_time || b.date_of_visit); });
        if (val === 'name')   filtered.sort(function(a, b) { return (a.visitor_name || '').localeCompare(b.visitor_name || ''); });
        if (val === 'status') filtered.sort(function(a, b) { return (a.status || '').localeCompare(b.status || ''); });
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
                    + '<a class="vmodal-photo-btn vmodal-photo-btn-outline" href="' + src + '" target="_blank" rel="noopener">'
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
        var win  = window.open('', '_blank');
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
        document.getElementById('archive-drawer').classList.add('open');
        document.getElementById('archive-backdrop').classList.add('open');
        document.getElementById('acount-completed').textContent = completedVisitors.length;
        document.getElementById('acount-deleted').textContent   = deletedVisitors.length;
        document.getElementById('acount-cancelled').textContent = cancelledVisitors.length;
        renderArchive();
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
        var q    = document.getElementById('archive-search').value.toLowerCase();
        
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
            var logTime = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
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

        var rows  = [['Log ID', 'Visitor Name', 'Contact No.', 'Purpose', 'Tenant', 'Room', 'Time In', 'Time Out', 'Status', label]];
        data.forEach(function(v) {
            var logTime = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
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
            var logTime = v.arrival_time ? fmtDatePlain(v.arrival_time) : (v.date_of_visit ? fmtDate(v.date_of_visit) + ' ' + (v.time_of_visit ? fmtTime(v.time_of_visit) : '') : '—');
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

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });
    @endif

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() { openModal('add-modal'); });
    @endif

    filtered = visitors.slice();
    renderTable();
</script>
@endsection