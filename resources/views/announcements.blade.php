@extends('layout')

@section('title', 'DormEase: Announcements')
@section('page-title', 'Announcements')

@section('styles')
<style>
    .page-body{
        padding:1.8rem 2rem;
        display:flex;
        flex-direction:column;
        gap:1.5rem;
        flex:1;
    }

    .page-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:1rem;
    }

    .page-header-left h1{
        font-size:2rem;
        font-weight:700;
        color:var(--black);
        letter-spacing:-.02em;
        line-height:1.15;
    }

    .page-header-left .dorm-name{
        font-size:1rem;
        font-weight:600;
        color:var(--hot-pink);
        margin-top:.2rem;
    }

    .header-actions{
        display:flex;
        align-items:center;
        gap:.75rem;
        flex-wrap:wrap;
        flex-shrink:0;
    }

    .btn-post{
        display:flex;
        align-items:center;
        gap:.5rem;
        padding:.55rem 1.2rem;
        background:var(--hot-pink);
        color:var(--white);
        border:none;
        border-radius:10px;
        font-size:.87rem;
        font-weight:700;
        cursor:pointer;
        transition:.2s;
        white-space:nowrap;
    }

    .btn-post:hover{
        background:var(--bright-pink);
        transform:translateY(-1px);
    }

    .btn-post img,
    .compose-tool-btn img,
    .filter-btn img,
    .ann-dropdown-item img,
    .ann-files img{
        width:16px;
        height:16px;
        object-fit:contain;
    }

    .btn-archive-open{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        padding:.6rem 1.2rem;
        border-radius:12px;
        background:var(--white);
        color:var(--hot-pink);
        border:1.5px solid var(--pink-100);
        font-size:.87rem;
        font-weight:600;
        cursor:pointer;
        transition:.2s;
        white-space:nowrap;
        font-family:var(--ff-body);
        letter-spacing:.01em;
    }

    .btn-archive-open:hover{
        border-color:var(--bright-pink);
        color:var(--bright-pink);
    }

    .btn-archive-open img{
        width:14px;
        height:14px;
        object-fit:contain;
    }

    .compose-card{
        background:var(--white);
        border:1px solid var(--border);
        border-radius:16px;
        padding:1.2rem 1.4rem;
        box-shadow:var(--shadow);
    }

    .compose-top{
        display:flex;
        align-items:center;
        gap:.8rem;
        border-bottom:1px solid var(--border);
        padding-bottom:.9rem;
        margin-bottom:.7rem;
    }

    .compose-avatar{
        width:36px;
        height:36px;
        border-radius:50%;
        background:var(--gradient-pink);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:14px;
        font-weight:700;
        color:var(--white);
        flex-shrink:0;
    }

    .compose-title-input{
        flex:1;
        border:none;
        outline:none;
        background:transparent;
        font-size:.95rem;
        font-weight:550;
        color:var(--ink);
    }

    .compose-title-input::placeholder,
    .compose-body-input::placeholder{
        color:var(--gray);
    }

    .compose-close{
        background:none;
        border:none;
        cursor:pointer;
    }

    .compose-body-input{
        width:100%;
        border:none;
        outline:none;
        resize:none;
        background:transparent;
        min-height:48px;
        line-height:1.6;
        font-size:.87rem;
        color:var(--ink-muted);
    }

    .compose-footer{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-top:.7rem;
        padding-top:.7rem;
        border-top:1px solid var(--border);
    }

    .compose-tools{
        display:flex;
        gap:.5rem;
    }

    .compose-tool-btn{
        width:32px;
        height:32px;
        border-radius:8px;
        background:var(--white);
        border:1px solid var(--border);
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition:.2s;
    }

    .compose-tool-btn:hover{
        border-color:var(--hot-pink);
        background:var(--pink-bg);
    }

    .filters-row{
        display:flex;
        align-items:center;
        gap:.75rem;
        flex-wrap:wrap;
    }

    .filter-btn{
        display:flex;
        align-items:center;
        gap:.4rem;
        padding:.42rem .9rem;
        border-radius:8px;
        border:1.5px solid var(--border);
        background:var(--white);
        font-size:.82rem;
        font-weight:600;
        color:var(--ink-muted);
        cursor:pointer;
        transition:.2s;
    }

    .filter-btn:hover,
    .filter-btn.active{
        border-color:var(--hot-pink);
        color:var(--hot-pink);
        background:var(--pink-bg);
    }

    .columns-wrapper{
        display:grid;
        grid-template-columns:1fr 1fr 1fr 1fr;
        gap:1.2rem;
        align-items:start;
    }

    .kanban-col{
        background:var(--white);
        border:1px solid var(--border);
        border-radius:16px;
        box-shadow:var(--shadow);
        overflow:visible;
    }

    .kanban-col-header{
        padding:.9rem 1.2rem;
        display:flex;
        align-items:center;
        gap:.6rem;
        border-bottom:2px solid var(--hot-pink);
    }

    .kanban-col-header.sched-header{
        border-bottom-color:var(--hot-pink);
    }

    .col-dot{
        width:9px;
        height:9px;
        border-radius:50%;
        background:var(--hot-pink);
        flex-shrink:0;
    }

    .col-title{
        font-size:.9rem;
        font-weight:700;
        color:var(--ink);
        flex:1;
    }

    .col-count{
        font-size:.78rem;
        font-weight:700;
        color:var(--hot-pink);
        background:var(--pink-50);
        border-radius:20px;
        padding:.1rem .55rem;
    }

    .col-count-sched{
        font-size:.78rem;
        font-weight:700;
        color:var(--hot-pink);
        background:var(--pink-50);
        border-radius:20px;
        padding:.1rem .55rem;
    }

    .kanban-col-body{
        padding:.9rem;
        display:flex;
        flex-direction:column;
        gap:.75rem;
    }

    .ann-card{
        background:var(--white);
        border:1px solid var(--border);
        border-radius:12px;
        padding:1rem;
        cursor:pointer;
        transition:.2s;
        position:relative;
    }

    .ann-card:hover{
        box-shadow:0 6px 20px rgba(232,23,93,.12);
        transform:translateY(-2px);
    }

    .ann-card.sched-card{
        border-color:var(--pink-100);
        background:var(--blush);
    }

    .ann-card.sched-card:hover{
        box-shadow:0 6px 20px rgba(232,23,93,.12);
    }

    .ann-card-top{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        margin-bottom:.55rem;
    }

    .priority-tag{
        font-size:.68rem;
        font-weight:700;
        padding:.18rem .55rem;
        border-radius:5px;
        border:1.5px solid;
        letter-spacing:.03em;
    }

    .priority-low{
        color:var(--green);
        border-color:var(--green);
        background:#f0fdf8;
    }

    .priority-moderate{
        color:#f59e0b;
        border-color:#f59e0b;
        background:#fff8eb;
    }

    .priority-high{
        color:var(--red);
        border-color:var(--red);
        background:#fff0f0;
    }

    .ann-menu-btn{
        width:30px;
        height:30px;
        border:1px solid transparent;
        border-radius:8px;
        background:var(--white);
        cursor:pointer;
        color:var(--ink-muted);
        font-size:1.25rem;
        font-weight:800;
        line-height:1;
        transition:.2s;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .ann-menu-btn:hover,
    .ann-menu-btn.active{
        color:var(--hot-pink);
        border-color:var(--hot-pink);
        background:var(--pink-bg);
    }

    .ann-menu-wrap{
        position:relative;
        flex-shrink:0;
    }

    .ann-title{
        font-size:.92rem;
        font-weight:700;
        color:var(--ink);
        margin-bottom:.35rem;
        line-height:1.35;
    }

    .ann-desc{
        font-size:.8rem;
        color:var(--ink-muted);
        line-height:1.55;
        margin-bottom:.7rem;
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }

    .ann-footer{
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:.3rem;
    }

    .ann-date,
    .ann-files{
        font-size:.73rem;
        color:var(--ink-muted);
    }

    .sched-badge{
        display:inline-flex;
        align-items:center;
        gap:.3rem;
        font-size:.7rem;
        font-weight:700;
        color:var(--hot-pink);
        background:var(--petal);
        border:1px solid var(--pink-200);
        border-radius:6px;
        padding:.18rem .5rem;
        letter-spacing:.02em;
    }

    .sched-badge svg{
        width:11px;
        height:11px;
        flex-shrink:0;
    }

    .ann-dropdown{
        position:absolute;
        right:0;
        top:calc(100% + .35rem);
        background:var(--white);
        border:1px solid var(--border);
        border-radius:10px;
        box-shadow:0 8px 24px rgba(26,26,46,.12);
        z-index:500;
        min-width:150px;
        display:none;
        flex-direction:column;
        overflow:hidden;
    }

    .ann-dropdown.open{
        display:flex;
    }

    .ann-dropdown-item{
        padding:.6rem 1rem;
        font-size:.82rem;
        font-weight:500;
        color:var(--ink);
        cursor:pointer;
        transition:.15s;
        border:none;
        background:none;
        text-align:left;
        width:100%;
        display:flex;
        align-items:center;
        gap:.5rem;
    }

    .ann-dropdown-item:hover{
        background:var(--pink-bg);
        color:var(--hot-pink);
    }

    .ann-dropdown-item.danger{
        color:var(--red);
    }

    .ann-dropdown-item.danger:hover{
        background:#fff0f0;
    }

    .modal-field input:focus,
    .modal-field select:focus,
    .modal-field textarea:focus{
        border-color:var(--hot-pink);
        outline:none;
    }

    #edit-modal .modal-close{
        display:none;
    }

    .modal-field textarea{
        resize:vertical;
        min-height:100px;
    }

    .modal-grid-2{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:1rem;
    }

    .modal-actions{
        display:flex;
        gap:.7rem;
        margin-top:1.5rem;
        justify-content:flex-end;
    }

    .btn-cancel{
        padding:.6rem 1.2rem;
        border-radius:9px;
        border:1.5px solid var(--border);
        background:var(--white);
        font-size:.87rem;
        font-weight:600;
        color:var(--hot-pink);
        cursor:pointer;
        transition:.2s;
    }

    .btn-cancel:hover{
        border-color:var(--hot-pink);
        color:var(--hot-pink);
        background:var(--pink-bg);
    }

    .btn-submit{
        padding:.6rem 1.4rem;
        border-radius:9px;
        border:none;
        background:var(--hot-pink);
        color:var(--white);
        font-size:.87rem;
        font-weight:700;
        cursor:pointer;
        transition:.2s;
    }

    .btn-submit:hover{
        background:var(--bright-pink);
    }

    .btn-danger{
        padding:.6rem 1.4rem;
        border-radius:9px;
        border:none;
        background:var(--red);
        color:var(--white);
        font-size:.87rem;
        font-weight:700;
        cursor:pointer;
    }

    .view-row{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        padding:.65rem 0;
        border-bottom:1px solid var(--border);
        font-size:.88rem;
    }

    .view-row:last-child{
        border-bottom:none;
    }

    .view-label{
        color:var(--ink-muted);
        font-weight:500;
    }

    .view-val{
        font-weight:600;
        color:var(--ink);
        text-align:right;
    }

    .view-title{
        font-size:1.35rem;
        font-weight:800;
        color:var(--ink);
        line-height:1.25;
        margin-bottom:.65rem;
    }

    .view-content{
        margin-top:1rem;
        white-space:pre-wrap;
        font-size:.92rem;
        color:var(--ink-muted);
        line-height:1.75;
    }

    .attachment-grid{
        margin-top:1rem;
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(160px, 1fr));
        gap:.8rem;
    }

    .attachment-card{
        border:1px solid var(--border);
        border-radius:10px;
        overflow:hidden;
        background:var(--white);
    }

    .attachment-card img{
        width:100%;
        max-height:360px;
        object-fit:contain;
        display:block;
        background:var(--gray-light);
    }

    .attachment-link{
        display:flex;
        align-items:center;
        gap:.45rem;
        padding:.7rem .85rem;
        color:var(--hot-pink);
        font-size:.82rem;
        font-weight:700;
        text-decoration:none;
        word-break:break-word;
    }

    .attachment-link img{
        width:16px;
        height:16px;
        flex-shrink:0;
    }

    .inline-edit-form{
        display:none;
        margin-top:1rem;
        border-top:1px solid var(--border);
        padding-top:1rem;
    }

    .inline-edit-form.open{
        display:block;
    }

    .current-files-note{
        margin-top:.35rem;
        font-size:.76rem;
        color:var(--ink-muted);
        line-height:1.5;
    }

    .action-loading-overlay{
        position:fixed;
        inset:0;
        z-index:1200;
        display:none;
        align-items:center;
        justify-content:center;
        background:rgba(255,255,255,.72);
        backdrop-filter:blur(2px);
    }

    .action-loading-overlay.open{
        display:flex;
    }

    .action-loading-box{
        display:flex;
        align-items:center;
        flex-direction:column;
        gap:.75rem;
        padding:1.25rem 1.6rem;
        border:1px solid var(--border);
        border-radius:12px;
        background:var(--white);
        box-shadow:0 12px 32px rgba(26,26,46,.14);
        color:var(--ink);
        font-size:.9rem;
        font-weight:700;
    }

    .loading-logo-wrap{
        width:86px;
        height:86px;
        border:3px solid var(--pink-50);
        border-radius:50%;
        background:var(--gradient-pink);
        display:flex;
        align-items:center;
        justify-content:center;
        box-shadow:0 10px 24px rgba(232,23,93,.25);
        animation:pulseLogo 1s ease-in-out infinite;
        flex-shrink:0;
    }

    .loading-logo-wrap img{
        width:62px;
        height:62px;
        object-fit:contain;
    }

    .loading-spinner{
        width:18px;
        height:18px;
        border:3px solid var(--pink-50);
        border-top-color:var(--hot-pink);
        border-radius:50%;
        animation:spin .75s linear infinite;
    }

    .is-loading{
        opacity:.75;
        pointer-events:none;
    }

    .delete-warning{
        background:#fff0f0;
        border:1px solid #ffd6d6;
        border-radius:12px;
        padding:1rem;
        margin-bottom:1rem;
        font-size:.88rem;
        color:var(--red);
        line-height:1.6;
    }

    .empty-col{
        text-align:center;
        padding:2rem 1rem;
        color:var(--ink-muted);
        font-size:.83rem;
    }

    .empty-icon{
        width:36px;
        height:36px;
        opacity:.3;
        margin:0 auto .5rem;
    }

    .schedule-toggle-row{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:.7rem .9rem;
        background:var(--petal);
        border:1.5px solid var(--pink-100);
        border-radius:10px;
        margin-bottom:.9rem;
        cursor:pointer;
        transition:background .2s,border-color .2s;
        user-select:none;
    }

    .schedule-toggle-row:hover{
        background:var(--blush);
        border-color:var(--pink-200);
    }

    .schedule-toggle-label{
        display:flex;
        align-items:center;
        gap:.55rem;
        font-size:.87rem;
        font-weight:700;
        color:var(--hot-pink);
    }

    .schedule-toggle-label svg{
        width:16px;
        height:16px;
        flex-shrink:0;
    }

    .schedule-toggle-switch{
        width:36px;
        height:20px;
        border-radius:99px;
        background:var(--pink-200);
        position:relative;
        transition:background .2s;
        flex-shrink:0;
    }

    .schedule-toggle-switch.on{
        background:var(--hot-pink);
    }

    .schedule-toggle-switch::after{
        content:'';
        position:absolute;
        top:2px;
        left:2px;
        width:16px;
        height:16px;
        border-radius:50%;
        background:var(--white);
        transition:transform .2s;
        box-shadow:0 1px 3px rgba(0,0,0,.2);
    }

    .schedule-toggle-switch.on::after{
        transform:translateX(16px);
    }

    .schedule-fields{
        display:none;
        padding:.8rem;
        background:var(--blush);
        border:1.5px solid var(--pink-100);
        border-radius:10px;
        margin-bottom:.9rem;
        gap:.8rem;
        flex-direction:column;
    }

    .schedule-fields.open{
        display:flex;
    }

    .schedule-fields .modal-field{
        margin-bottom:0;
    }

    .schedule-fields .modal-field label{
        color:var(--hot-pink);
        font-weight:600;
    }

    .schedule-fields input[type="datetime-local"]{
        width:100%;
        box-sizing:border-box;
        border:1.5px solid var(--pink-100);
        border-radius:9px;
        padding:.55rem .85rem;
        font-size:.88rem;
        color:var(--ink);
        background:var(--white);
        font-family:var(--ff-body);
        transition:border-color .15s;
    }

    .schedule-fields input[type="datetime-local"]:focus{
        border-color:var(--hot-pink);
        outline:none;
    }

    .schedule-note{
        font-size:.75rem;
        color:var(--bright-pink);
        margin-top:.35rem;
        line-height:1.5;
    }

    .ann-archive-drawer{
        position:fixed;
        top:0;right:0;bottom:0;
        width:min(660px,100vw);
        background:var(--soft-bg);
        z-index:500;
        display:flex;
        flex-direction:column;
        transform:translateX(100%);
        transition:transform .38s cubic-bezier(.4,0,.2,1);
        box-shadow:-8px 0 40px rgba(214,51,117,.15);
    }

    .ann-archive-drawer.open{transform:translateX(0);}

    .ann-archive-backdrop{
        position:fixed;inset:0;
        background:rgba(232,23,93,.18);
        backdrop-filter:blur(3px);
        z-index:499;
        opacity:0;pointer-events:none;
        transition:opacity .38s ease;
    }

    .ann-archive-backdrop.open{opacity:1;pointer-events:auto;}

    .aad-header{
        padding:1.6rem 1.8rem 1.2rem;
        border-bottom:1px solid var(--pink-100);
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:1rem;
        flex-shrink:0;
    }

    .aad-title{
        font-size:1.3rem;
        font-weight:800;
        color:var(--ink);
        letter-spacing:-.02em;
        line-height:1.2;
    }

    .aad-sub{
        font-size:.78rem;
        color:var(--ink-muted);
        margin-top:.25rem;
        font-weight:500;
    }

    .aad-close{
        width:34px;height:34px;
        border-radius:8px;
        border:1px solid var(--pink-100);
        background:var(--petal);
        color:var(--bright-pink);
        font-size:1rem;
        cursor:pointer;
        display:flex;align-items:center;justify-content:center;
        transition:background .2s,color .2s;
        flex-shrink:0;
    }

    .aad-close:hover{background:var(--pink-100);color:var(--hot-pink);}

    .aad-search-bar{
        padding:1rem 1.8rem .8rem;
        flex-shrink:0;
    }

    .aad-search-inner{
        position:relative;
        display:flex;
        align-items:center;
    }

    .aad-search-inner input{
        width:100%;
        padding:.55rem .9rem .55rem 2.2rem;
        border-radius:10px;
        border:1px solid var(--pink-100);
        background:var(--white);
        color:var(--ink);
        font-size:.83rem;
        font-family:var(--ff-body);
        outline:none;
        transition:border-color .2s,background .2s;
        box-sizing:border-box;
    }

    .aad-search-inner input::placeholder{color:var(--ink-muted);}
    .aad-search-inner input:focus{border-color:var(--bright-pink);background:var(--blush);}

    .aad-search-icon{
        position:absolute;left:.75rem;
        width:13px;height:13px;
        opacity:.5;pointer-events:none;
    }

    .aad-list{
        flex:1;
        overflow-y:auto;
        padding:0 1.8rem 1.8rem;
        display:flex;
        flex-direction:column;
        gap:.75rem;
    }

    .aad-list::-webkit-scrollbar{width:4px;}
    .aad-list::-webkit-scrollbar-track{background:transparent;}
    .aad-list::-webkit-scrollbar-thumb{background:var(--pink-200);border-radius:99px;}

    .aad-card{
        background:var(--white);
        border:1px solid var(--pink-100);
        border-radius:14px;
        padding:1rem 1.1rem;
        transition:background .2s,border-color .2s;
        animation:aadSlideIn .3s ease both;
    }

    @keyframes aadSlideIn{
        from{opacity:0;transform:translateX(12px);}
        to{opacity:1;transform:translateX(0);}
    }

    .aad-card:hover{background:var(--blush);border-color:var(--bright-pink);}

    .aad-card-top{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:.8rem;
        margin-bottom:.5rem;
    }

    .aad-card-id{
        font-size:.75rem;
        font-weight:800;
        color:var(--bright-pink);
        letter-spacing:.02em;
        font-family:monospace;
    }

    .aad-card-time{
        font-size:.7rem;
        color:var(--ink-muted);
        font-weight:500;
        white-space:nowrap;
        flex-shrink:0;
    }

    .aad-card-title{
        font-size:.9rem;
        font-weight:700;
        color:var(--ink);
        line-height:1.3;
        margin-bottom:.2rem;
    }

    .aad-card-desc{
        font-size:.75rem;
        color:var(--ink-muted);
        line-height:1.5;
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }

    .aad-card-meta{
        display:flex;
        align-items:center;
        gap:.45rem;
        margin-top:.6rem;
        flex-wrap:wrap;
    }

    .aad-pill{
        font-size:.68rem;
        font-weight:700;
        padding:.18rem .55rem;
        border-radius:99px;
        letter-spacing:.03em;
        text-transform:uppercase;
    }

    .aad-pill-low     {background:#f0fdf8;color:var(--green);border:1px solid #8ce0bb;}
    .aad-pill-moderate{background:#fff8eb;color:#c8960c;border:1px solid #f0c040;}
    .aad-pill-high    {background:#fff0f0;color:var(--red);border:1px solid #ffd6d6;}
    .aad-pill-active  {background:var(--petal);color:var(--hot-pink);border:1px solid var(--pink-200);}
    .aad-pill-closed  {background:var(--blush);color:var(--ink-muted);border:1px solid var(--pink-100);}
    .aad-pill-scheduled{background:var(--petal);color:var(--hot-pink);border:1px solid var(--pink-200);}

    .aad-card-deleted{
        display:flex;
        align-items:center;
        gap:.4rem;
        margin-top:.75rem;
        padding-top:.6rem;
        border-top:1px solid var(--pink-100);
        font-size:.7rem;
        color:var(--ink-muted);
        font-weight:500;
    }

    .aad-card-deleted span{color:var(--bright-pink);font-weight:600;}

    .aad-empty{
        text-align:center;
        padding:3rem 1rem;
        color:var(--ink-muted);
        font-size:.85rem;
    }

    .aad-empty-icon{
        width:40px;height:40px;
        margin:0 auto .75rem;
        opacity:.3;
        display:block;
    }

    .aad-footer{
        padding:.9rem 1.8rem;
        border-top:1px solid var(--pink-100);
        background:var(--white);
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-shrink:0;
        flex-wrap:wrap;
        gap:.5rem;
    }

    .aad-count-label{
        font-size:.75rem;
        color:var(--ink-muted);
        font-weight:600;
    }

    .aad-export-btn{
        display:inline-flex;
        align-items:center;
        gap:.4rem;
        font-size:.75rem;
        font-weight:700;
        color:var(--bright-pink);
        background:var(--petal);
        border:1px solid var(--pink-100);
        border-radius:8px;
        padding:.35rem .85rem;
        cursor:pointer;
        transition:background .2s,color .2s,border-color .2s;
        font-family:var(--ff-body);
    }

    .aad-export-btn:hover{background:var(--gradient-pink);color:var(--white);border-color:transparent;}
    .aad-export-btn img{width:12px;height:12px;object-fit:contain;opacity:.7;}

    @keyframes fadeUp{
        from{opacity:0;transform:translateY(15px);}
        to{opacity:1;transform:translateY(0);}
    }

    @keyframes spin{
        to{transform:rotate(360deg);}
    }

    @keyframes pulseLogo{
        0%,100%{transform:scale(1);}
        50%{transform:scale(1.06);}
    }

    .fade-up{animation:fadeUp .45s ease both;}

    .modal-field select{
        width:100%;
        box-sizing:border-box;
        border:1.5px solid var(--border);
        border-radius:9px;
        padding:.55rem .85rem;
        font-size:.88rem;
        color:var(--ink);
        background:var(--white);
        appearance:none;
        -webkit-appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right .85rem center;
        padding-right:2.2rem;
        cursor:pointer;
        transition:border-color .15s;
    }

    .modal-field select:focus{border-color:var(--hot-pink);outline:none;}
    .modal-field select:hover{border-color:var(--hot-pink);}

    .modal-grid-2{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:1rem;
        margin-bottom:.9rem;
    }

    .d1{animation-delay:.05s;}
    .d2{animation-delay:.12s;}
    .d3{animation-delay:.2s;}
    .d4{animation-delay:.28s;}

    @media(max-width:1300px){
        .columns-wrapper{grid-template-columns:1fr 1fr;}
    }

    @media(max-width:700px){
        .columns-wrapper{grid-template-columns:1fr;}
        .page-body{padding:1rem;}
        .modal-grid-2{grid-template-columns:1fr;}
        .aad-header{padding:1.2rem 1rem .9rem;}
        .aad-list{padding:0 1rem 1.2rem;}
        .aad-search-bar{padding:.8rem 1rem .6rem;}
        .aad-footer{padding:.75rem 1rem;}
    }
</style>
@endsection

@section('content')
<div class="page-body">

    <div class="page-header fade-up d1">
        <div class="page-header-left">
            <h1>Announcements</h1>
            <div class="dorm-name">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-actions">
            <button class="btn-archive-open" onclick="openAnnArchive()">
                <img src="{{ asset('icons/archive.png') }}" alt="">
                Archive / History
            </button>
            <button class="btn-post" onclick="openModal('post-modal')">
                <img src="{{ asset('icons/announce.png') }}" alt=""> Post New Announcement
            </button>
        </div>
    </div>

    <div class="compose-card fade-up d2">
        <div class="compose-top">
            <div class="compose-avatar">
                @if($staff->profile_picture)
                    <img src="{{ $staff->profile_picture }}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                @else
                    {{ strtoupper(substr($staff->first_name ?? 'A', 0, 1)) }}
                @endif
            </div>
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
                <button class="compose-tool-btn" onclick="openModal('post-modal')" title="Schedule announcement">
                    <img src="{{ asset('icons/clock.png') }}" alt="">
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
            <img src="{{ asset('icons/lowprio.png') }}" alt=""> Low Priority
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
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-all-{{ $ann->announcement_id }}')" aria-label="Announcement actions">...</button>
                                <div class="ann-dropdown" id="menu-all-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->announcement_id }}, event)">
                                        <img src="{{ asset('icons/edit.png') }}" alt=""> Edit
                                    </button>
                                    @if($ann->status !== 'closed')
                                        <button class="ann-dropdown-item" onclick="submitForm('close-{{ $ann->announcement_id }}', event)">
                                            <img src="{{ asset('icons/archive.png') }}" alt=""> Close
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

                    <form id="close-{{ $ann->announcement_id }}" method="POST" action="{{ route('announcements.archive', $ann->announcement_id) }}" style="display:none;">@csrf</form>
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
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-act-{{ $ann->announcement_id }}')" aria-label="Announcement actions">...</button>
                                <div class="ann-dropdown" id="menu-act-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->announcement_id }}, event)">
                                        <img src="{{ asset('icons/edit.png') }}" alt=""> Edit
                                    </button>
                                    <button class="ann-dropdown-item" onclick="submitForm('close-{{ $ann->announcement_id }}', event)">
                                        <img src="{{ asset('icons/archive.png') }}" alt=""> Close
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
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-cls-{{ $ann->announcement_id }}')" aria-label="Announcement actions">...</button>
                                <div class="ann-dropdown" id="menu-cls-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->announcement_id }}, event)">
                                        <img src="{{ asset('icons/edit.png') }}" alt=""> Edit
                                    </button>
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
                        <img class="empty-icon" src="{{ asset('icons/check.png') }}" alt="">
                        <div>No closed announcements</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="kanban-col">
            <div class="kanban-col-header sched-header">
                <span class="col-dot" style="background:var(--hot-pink)"></span>
                <span class="col-title">Scheduled</span>
                <span class="col-count-sched">{{ $scheduled->count() }}</span>
            </div>
            <div class="kanban-col-body">
                @forelse($scheduled as $ann)
                    <div class="ann-card sched-card" onclick="openViewModal({{ $ann->announcement_id }})">
                        <div class="ann-card-top">
                            <span class="priority-tag priority-{{ strtolower($ann->priority ?? 'low') }}">
                                {{ ucfirst($ann->priority ?? 'Low') }}
                            </span>
                            <div class="ann-menu-wrap">
                                <button class="ann-menu-btn" onclick="toggleMenu(event, 'menu-sched-{{ $ann->announcement_id }}')" aria-label="Announcement actions">...</button>
                                <div class="ann-dropdown" id="menu-sched-{{ $ann->announcement_id }}">
                                    <button class="ann-dropdown-item" onclick="openEditModal({{ $ann->announcement_id }}, event)">
                                        <img src="{{ asset('icons/edit.png') }}" alt=""> Edit / Reschedule
                                    </button>
                                    <button class="ann-dropdown-item" onclick="submitForm('publish-now-{{ $ann->announcement_id }}', event)">
                                        <img src="{{ asset('icons/announce.png') }}" alt=""> Publish Now
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
                            <span class="sched-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ \Carbon\Carbon::parse($ann->scheduled_at)->format('M j, Y · g:i A') }}
                            </span>
                            @if($ann->attachment)
                                <span class="ann-files">
                                    <img src="{{ asset('icons/attach.png') }}" alt="">
                                    {{ count(explode(',', $ann->attachment)) }} file(s)
                                </span>
                            @endif
                        </div>
                    </div>

                    <form id="publish-now-{{ $ann->announcement_id }}" method="POST" action="{{ route('announcements.restore', $ann->announcement_id) }}" style="display:none;">@csrf</form>

                @empty
                    <div class="empty-col">
                        <img class="empty-icon" src="{{ asset('icons/calendar.png') }}" alt="">
                        <div>No scheduled announcements</div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@section('modals')

<div class="ann-archive-backdrop" id="aad-backdrop" onclick="closeAnnArchive()"></div>

<div class="ann-archive-drawer" id="aad-drawer">
    <div class="aad-header">
        <div>
            <div class="aad-title">Archive / History</div>
            <div class="aad-sub">Record of deleted announcements</div>
        </div>
        <button class="aad-close" onclick="closeAnnArchive()">&#x2715;</button>
    </div>

    <div class="aad-search-bar">
        <div class="aad-search-inner">
            <img src="{{ asset('icons/search.png') }}" class="aad-search-icon" alt="">
            <input type="text" id="aad-search" placeholder="Search archived announcements..." oninput="renderAnnArchive()">
        </div>
    </div>

    <div class="aad-list" id="aad-list"></div>

    <div class="aad-footer">
        <div class="aad-count-label" id="aad-count-label">0 records</div>
        <button class="aad-export-btn" onclick="exportAnnArchive()">
            <img src="{{ asset('icons/export.png') }}" alt="">
            Export CSV
        </button>
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

<div class="modal-overlay" id="post-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Post New Announcement</div>
            <button class="modal-close" onclick="closeModal('post-modal')">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('announcements.store') }}" enctype="multipart/form-data" data-loading-message="Please wait...">
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
                <div class="modal-field" id="post-status-field">
                    <label>Status</label>
                    <select name="status" id="post-status-select">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            <div class="schedule-toggle-row" onclick="toggleSchedule('post')">
                <span class="schedule-toggle-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Schedule for later
                </span>
                <span class="schedule-toggle-switch" id="post-sched-switch"></span>
            </div>

            <div class="schedule-fields" id="post-sched-fields">
                <div class="modal-field">
                    <label>Publish Date &amp; Time</label>
                    <input type="datetime-local" name="scheduled_at" id="post-scheduled-at">
                    <div class="schedule-note">The announcement will go live automatically at this time.</div>
                </div>
            </div>

            <div class="modal-field">
                <label>Attach Files (optional)</label>
                <input type="file" name="files[]" multiple style="padding:.5rem .85rem;">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('post-modal')">Cancel</button>
                <button type="submit" class="btn-submit" id="post-submit-btn">Post Announcement</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Edit Announcement</div>
            <button class="modal-close" onclick="closeModal('edit-modal')">&#x2715;</button>
        </div>
        <form method="POST" id="edit-form" enctype="multipart/form-data" data-loading-message="Please wait...">
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
                <div class="modal-field" id="edit-status-field">
                    <label>Status</label>
                    <select name="status" id="edit-status">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            <div class="schedule-toggle-row" onclick="toggleSchedule('edit')">
                <span class="schedule-toggle-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Schedule for later
                </span>
                <span class="schedule-toggle-switch" id="edit-sched-switch"></span>
            </div>

            <div class="schedule-fields" id="edit-sched-fields">
                <div class="modal-field">
                    <label>Publish Date &amp; Time</label>
                    <input type="datetime-local" name="scheduled_at" id="edit-scheduled-at">
                    <div class="schedule-note">The announcement will go live automatically at this time.</div>
                </div>
            </div>

            <div class="modal-field">
                <label>Add Image / Files (optional)</label>
                <input type="file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx" style="padding:.5rem .85rem;">
                <div class="current-files-note" id="edit-current-files"></div>
            </div>
            <div class="modal-field">
                <label style="display:flex;align-items:center;gap:.45rem;font-weight:600;">
                    <input type="checkbox" name="replace_attachments" value="1" style="width:auto;">
                    Replace existing files with the new upload
                </label>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-modal')">Cancel</button>
                <button type="submit" class="btn-submit" id="edit-submit-btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="view-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title" id="view-modal-title">Announcement</div>
            <button class="modal-close" onclick="closeModal('view-modal')">&#x2715;</button>
        </div>
        <div id="view-modal-content"></div>
        <form method="POST" id="view-edit-form" class="inline-edit-form" enctype="multipart/form-data" data-loading-message="Please wait...">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label>Title *</label>
                <input type="text" name="title" id="view-edit-title" required>
            </div>
            <div class="modal-field">
                <label>Content *</label>
                <textarea name="content" id="view-edit-content" required></textarea>
            </div>
            <div class="modal-grid-2">
                <div class="modal-field">
                    <label>Priority</label>
                    <select name="priority" id="view-edit-priority">
                        <option value="low">Low</option>
                        <option value="moderate">Moderate</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label>Status</label>
                    <select name="status" id="view-edit-status">
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            <div class="schedule-toggle-row" onclick="toggleSchedule('view-edit')">
                <span class="schedule-toggle-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Schedule for later
                </span>
                <span class="schedule-toggle-switch" id="view-edit-sched-switch"></span>
            </div>

            <div class="schedule-fields" id="view-edit-sched-fields">
                <div class="modal-field">
                    <label>Publish Date &amp; Time</label>
                    <input type="datetime-local" name="scheduled_at" id="view-edit-scheduled-at">
                    <div class="schedule-note">The announcement will go live automatically at this time.</div>
                </div>
            </div>

            <div class="modal-field">
                <label>Add Image / Files (optional)</label>
                <input type="file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx" style="padding:.5rem .85rem;">
                <div class="current-files-note" id="view-current-files"></div>
            </div>
            <div class="modal-field">
                <label style="display:flex;align-items:center;gap:.45rem;font-weight:600;">
                    <input type="checkbox" name="replace_attachments" value="1" style="width:auto;">
                    Replace existing files with the new upload
                </label>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('view-modal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
        <div class="modal-actions">
            <button class="btn-cancel" id="view-close-btn" onclick="closeModal('view-modal')">Close</button>
            <button class="btn-submit" id="view-edit-btn">Edit</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-modal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Delete Announcement</div>
            <button class="modal-close" onclick="closeModal('delete-modal')">&#x2715;</button>
        </div>
        <div class="delete-warning">This action cannot be undone. The announcement will be permanently removed.</div>
        <p style="font-size:.9rem;color:var(--ink-muted);">Are you sure you want to delete <strong id="delete-ann-name" style="color:var(--ink);"></strong>?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <form method="POST" id="delete-form" style="display:inline;" data-loading-message="Please wait...">
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
    const annData           = @json($announcements->merge($scheduled)->keyBy('announcement_id'));
    const deletedAnnArchive = @json($deletedArchive);
    const storageBaseUrl    = "{{ asset('storage') }}";

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
    });

    document.querySelectorAll('form[data-loading-message]').forEach(form => {
        form.addEventListener('submit', () => {
            setFormLoading(form, form.dataset.loadingMessage || 'Processing...');
        });
    });

    function toggleMenu(e, id) {
        e.stopPropagation();
        const menu   = document.getElementById(id);
        const isOpen = menu.classList.contains('open');
        document.querySelectorAll('.ann-menu-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.ann-dropdown').forEach(d => d.classList.remove('open'));
        if (!isOpen) {
            menu.classList.add('open');
            e.currentTarget.classList.add('active');
        }
    }

    document.addEventListener('click', () => {
        document.querySelectorAll('.ann-menu-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.ann-dropdown').forEach(d => d.classList.remove('open'));
    });

    function setFilter(btn, type) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const now   = new Date();
        const cards = document.querySelectorAll('.ann-card');

        cards.forEach(card => {
            const id  = getCardId(card);
            const ann = annData[id];
            if (!ann) return;

            const postedAt = new Date(ann.posted_at || ann.scheduled_at);
            let show = false;

            if (type === 'all') {
                show = true;
            } else if (type === 'week') {
                const weekAgo = new Date(now);
                weekAgo.setDate(now.getDate() - 7);
                show = postedAt >= weekAgo;
            } else if (type === 'month') {
                show = postedAt.getMonth() === now.getMonth() &&
                       postedAt.getFullYear() === now.getFullYear();
            } else if (type === 'high') {
                show = (ann.priority || '').toLowerCase() === 'high';
            } else if (type === 'low') {
                show = (ann.priority || '').toLowerCase() === 'low';
            }

            card.style.display = show ? '' : 'none';
        });

        document.querySelectorAll('.kanban-col').forEach(col => {
            const visible = col.querySelectorAll('.ann-card:not([style*="display: none"])').length;
            const countEl = col.querySelector('.col-count, .col-count-sched');
            if (countEl) countEl.textContent = visible;

            let emptyEl = col.querySelector('.empty-col.filter-empty');
            const body  = col.querySelector('.kanban-col-body');
            const hasStaticEmpty = col.querySelector('.empty-col:not(.filter-empty)');

            if (visible === 0) {
                if (hasStaticEmpty) {
                    hasStaticEmpty.style.display = '';
                } else {
                    if (!emptyEl) {
                        emptyEl = document.createElement('div');
                        emptyEl.className = 'empty-col filter-empty';
                        emptyEl.innerHTML = '<div>No announcements match this filter.</div>';
                        body.appendChild(emptyEl);
                    }
                    emptyEl.style.display = '';
                }
            } else {
                if (hasStaticEmpty) hasStaticEmpty.style.display = 'none';
                if (emptyEl) emptyEl.style.display = 'none';
            }
        });
    }

    function getCardId(card) {
        const match = card.getAttribute('onclick')?.match(/openViewModal\((\d+)\)/);
        return match ? match[1] : null;
    }

    function submitForm(formId, e) {
        e.stopPropagation();
        showActionLoading('Please wait...');
        document.getElementById(formId).submit();
    }

    function setFormLoading(form, message) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.textContent = 'Please wait...';
            submitButton.disabled = true;
            submitButton.classList.add('is-loading');
        }
        form.querySelectorAll('button:not([type="submit"])').forEach(button => {
            button.disabled = true;
            button.classList.add('is-loading');
        });
        showActionLoading(message);
    }

    function showActionLoading(message) {
        const overlay = document.getElementById('action-loading');
        document.getElementById('action-loading-text').textContent = message;
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
    }

    function schedIsOn(prefix) {
        return document.getElementById(prefix + '-sched-switch').classList.contains('on');
    }

    function toggleSchedule(prefix, forceState) {
        const sw     = document.getElementById(prefix + '-sched-switch');
        const fields = document.getElementById(prefix + '-sched-fields');
        const input  = document.getElementById(prefix + '-scheduled-at');

        const turnOn = forceState !== undefined ? forceState : !sw.classList.contains('on');

        if (turnOn) {
            sw.classList.add('on');
            fields.classList.add('open');
            input.required = true;

            if (prefix === 'post') {
                const statusField = document.getElementById('post-status-field');
                if (statusField) statusField.style.display = 'none';
            }
            if (prefix === 'edit') {
                const statusField = document.getElementById('edit-status-field');
                if (statusField) statusField.style.display = 'none';
            }
        } else {
            sw.classList.remove('on');
            fields.classList.remove('open');
            input.required = false;
            input.value = '';

            if (prefix === 'post') {
                const statusField = document.getElementById('post-status-field');
                if (statusField) statusField.style.display = '';
            }
            if (prefix === 'edit') {
                const statusField = document.getElementById('edit-status-field');
                if (statusField) statusField.style.display = '';
            }
        }
    }

    function openViewModal(id) {
        const ann = annData[id];
        if (!ann) return;
        document.getElementById('view-modal-title').textContent = ann.title;
        hideInlineEdit();
        fillInlineEditForm(ann, id);

        const isScheduled = ann.status === 'scheduled' && ann.scheduled_at;

        document.getElementById('view-modal-content').innerHTML = `
            <div class="view-title">${escapeHtml(ann.title || '')}</div>
            <div class="view-row"><span class="view-label">Priority</span><span class="view-val"><span class="priority-tag priority-${(ann.priority||'low').toLowerCase()}">${ucFirst(ann.priority||'low')}</span></span></div>
            <div class="view-row"><span class="view-label">Status</span><span class="view-val">${ucFirst(ann.status||'active')}</span></div>
            ${isScheduled
                ? `<div class="view-row"><span class="view-label">Scheduled For</span><span class="view-val" style="color:var(--hot-pink);">${formatDate(ann.scheduled_at)}</span></div>`
                : `<div class="view-row"><span class="view-label">Posted</span><span class="view-val">${formatDate(ann.posted_at)}</span></div>`
            }
            <div class="view-content">${escapeHtml(ann.content || '')}</div>
            ${renderAttachments(ann.attachment)}
        `;
        document.getElementById('view-edit-btn').onclick = () => showInlineEdit();
        openModal('view-modal');
    }

    function openEditModal(id, e) {
        e.stopPropagation();
        const ann = annData[id];
        if (!ann) return;
        document.getElementById('edit-form').reset();
        document.getElementById('edit-form').action   = `/announcements/${id}`;
        document.getElementById('edit-title').value   = ann.title;
        document.getElementById('edit-content').value = ann.content;
        document.getElementById('edit-priority').value = ann.priority || 'low';
        document.getElementById('edit-status').value   = ann.status   || 'active';
        document.getElementById('edit-current-files').textContent = filesNote(ann.attachment);

        const isScheduled = ann.status === 'scheduled' && ann.scheduled_at;
        if (isScheduled) {
            const dt = new Date(ann.scheduled_at);
            const local = new Date(dt.getTime() - dt.getTimezoneOffset() * 60000)
                .toISOString()
                .slice(0, 16);
            document.getElementById('edit-scheduled-at').value = local;
            toggleSchedule('edit', true);
        } else {
            toggleSchedule('edit', false);
        }

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

    function fillInlineEditForm(ann, id) {
        document.getElementById('view-edit-form').action       = `/announcements/${id}`;
        document.getElementById('view-edit-title').value       = ann.title   || '';
        document.getElementById('view-edit-content').value     = ann.content || '';
        document.getElementById('view-edit-priority').value    = ann.priority || 'low';
        document.getElementById('view-edit-status').value      = ann.status   || 'active';
        document.getElementById('view-current-files').textContent = filesNote(ann.attachment);

        const isScheduled = ann.status === 'scheduled' && ann.scheduled_at;
        if (isScheduled) {
            const dt = new Date(ann.scheduled_at);
            const local = new Date(dt.getTime() - dt.getTimezoneOffset() * 60000)
                .toISOString()
                .slice(0, 16);
            document.getElementById('view-edit-scheduled-at').value = local;
            toggleSchedule('view-edit', true);
        } else {
            toggleSchedule('view-edit', false);
        }
    }

    function showInlineEdit() {
        document.getElementById('view-edit-form').classList.add('open');
        document.getElementById('view-edit-btn').style.display  = 'none';
        document.getElementById('view-close-btn').style.display = 'none';
    }

    function hideInlineEdit() {
        const form = document.getElementById('view-edit-form');
        if (!form) return;
        form.classList.remove('open');
        form.reset();
        toggleSchedule('view-edit', false);
        document.getElementById('view-edit-btn').style.display  = '';
        document.getElementById('view-close-btn').style.display = '';
    }

    function getAttachments(attachment) {
        if (!attachment) return [];
        return String(attachment).split(',').map(path => path.trim()).filter(Boolean);
    }

    function filesNote(attachment) {
        const total = getAttachments(attachment).length;
        return total
            ? `${total} existing file(s). Upload new files to add more, or tick replace to change them.`
            : 'No image or file attached yet.';
    }

    function renderAttachments(attachment) {
        const files = getAttachments(attachment);
        if (!files.length) return '<div class="current-files-note">No image or file attached.</div>';

        return `<div class="attachment-grid">${files.map(path => {
            const url  = `${storageBaseUrl}/${encodeURI(path)}`;
            const name = path.split('/').pop();
            if (isImage(path)) {
                return `<div class="attachment-card"><a href="${url}" target="_blank" rel="noopener"><img src="${url}" alt="${escapeHtml(name)}"></a></div>`;
            }
            return `<div class="attachment-card"><a class="attachment-link" href="${url}" target="_blank" rel="noopener"><img src="{{ asset('icons/attach.png') }}" alt=""> ${escapeHtml(name)}</a></div>`;
        }).join('')}</div>`;
    }

    function isImage(path) {
        return /\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(path || '');
    }

    function formatDate(value) {
        if (!value) return '';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return value;
        return date.toLocaleString([], { year:'numeric', month:'long', day:'numeric', hour:'numeric', minute:'2-digit' });
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function fmtDatePlain(d) {
        if (!d) return '—';
        const dt   = new Date(d);
        const date = dt.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
        const time = dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        return `${date} ${time}`;
    }

    function openAnnArchive() {
        document.getElementById('aad-drawer').classList.add('open');
        document.getElementById('aad-backdrop').classList.add('open');
        document.getElementById('aad-search').value = '';
        renderAnnArchive();
    }

    function closeAnnArchive() {
        document.getElementById('aad-drawer').classList.remove('open');
        document.getElementById('aad-backdrop').classList.remove('open');
    }

    function renderAnnArchive() {
        const q = document.getElementById('aad-search').value.toLowerCase();

        const data = deletedAnnArchive.filter(r =>
            (r.title   || '').toLowerCase().includes(q) ||
            (r.content || '').toLowerCase().includes(q) ||
            (r.priority|| '').toLowerCase().includes(q) ||
            (r.status  || '').toLowerCase().includes(q)
        );

        const list = document.getElementById('aad-list');
        document.getElementById('aad-count-label').textContent =
            `${data.length} record${data.length !== 1 ? 's' : ''}`;

        if (data.length === 0) {
            list.innerHTML = `<div class="aad-empty">
                <img class="aad-empty-icon" src="{{ asset('icons/announce.png') }}" alt="">
                No archived announcements found.
            </div>`;
            return;
        }

        list.innerHTML = data.map((r, i) => `
            <div class="aad-card" style="animation-delay:${i * 0.04}s;">
                <div class="aad-card-top">
                    <div class="aad-card-id">#${r.announcement_id}</div>
                    <div class="aad-card-time">${r.posted_at ? fmtDate(r.posted_at.split('T')[0]) : (r.scheduled_at ? fmtDate(r.scheduled_at.split('T')[0]) : '—')}</div>
                </div>
                <div class="aad-card-title">${escapeHtml(r.title || '')}</div>
                <div class="aad-card-desc">${escapeHtml(r.content || '')}</div>
                <div class="aad-card-meta">
                    <span class="aad-pill aad-pill-${(r.priority || 'low').toLowerCase()}">${ucFirst(r.priority || 'low')}</span>
                    <span class="aad-pill aad-pill-${(r.status || 'active').toLowerCase()}">${ucFirst(r.status || 'active')}</span>
                    ${r.attachment
                        ? `<span class="aad-pill aad-pill-closed">${r.attachment.split(',').length} file(s)</span>`
                        : ''}
                </div>
                <div class="aad-card-deleted">
                    Deleted on: <span>${fmtDatePlain(r.deleted_at)}</span>
                </div>
            </div>
        `).join('');
    }

    function exportAnnArchive() {
        const rows = [['ID', 'Title', 'Content', 'Priority', 'Status', 'Posted At', 'Scheduled At', 'Deleted On']];
        deletedAnnArchive.forEach(r => {
            rows.push([
                r.announcement_id,
                r.title        || '',
                r.content      || '',
                r.priority     || '',
                r.status       || '',
                r.posted_at    || '',
                r.scheduled_at || '',
                r.deleted_at   || '',
            ]);
        });
        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
        const a   = document.createElement('a');
        a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'announcements_deleted_archive.csv';
        a.click();
    }

    document.getElementById('post-modal').addEventListener('shown', () => {
        toggleSchedule('post', false);
    });

    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif
</script>
@endsection