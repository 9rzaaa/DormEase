{{--
    DormEase shared popup system
    Include this partial once per page: @include('partials._confirm-pop-ups')
    Requires: the page's CSS variables (--gradient-pink, --pink-100, --ink, etc.)
    and a <meta name="csrf-token" content="{{ csrf_token() }}"> tag in the layout head.
--}}
<style>
.action-loading-overlay { position: fixed; inset: 0; z-index: 1200; display: none; align-items: center; justify-content: center; background: rgba(255,255,255,.72); backdrop-filter: blur(2px); }
.action-loading-overlay.open { display: flex; }
.action-loading-box { display: flex; align-items: center; flex-direction: column; gap: .75rem; padding: 1.25rem 1.6rem; border: 1px solid var(--pink-100); border-radius: 12px; background: var(--white); box-shadow: 0 12px 32px rgba(26,26,46,.14); color: var(--ink); font-size: .9rem; font-weight: 700; }
.loading-logo-wrap { width: 86px; height: 86px; border: 3px solid var(--pink-50, var(--pink-100)); border-radius: 50%; background: var(--gradient-pink); display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 24px rgba(232,23,93,.25); animation: pulseLogo 1s ease-in-out infinite; flex-shrink: 0; }
.loading-logo-wrap img { width: 62px; height: 62px; object-fit: contain; }
.is-loading { opacity: .75; pointer-events: none; }
@keyframes pulseLogo { 0%, 100% { transform: scale(1); box-shadow: 0 10px 24px rgba(232,23,93,.25); } 50% { transform: scale(1.07); box-shadow: 0 14px 32px rgba(232,23,93,.45); } }
@keyframes modalIn { from { opacity: 0; transform: translateY(18px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }

.confirm-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); backdrop-filter: blur(4px); z-index: 9500; display: none; align-items: center; justify-content: center; }
.confirm-overlay.open { display: flex; }
.confirm-box { background: var(--white); border-radius: 22px; padding: 1.8rem; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,.2); animation: modalIn .28s cubic-bezier(.34,1.3,.64,1) both; }
.confirm-box-title { font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: .5rem; }
.confirm-box-body { font-size: .86rem; color: var(--ink-muted); line-height: 1.6; margin-bottom: 1.4rem; }
.confirm-box-actions { display: flex; gap: .6rem; justify-content: flex-end; }
.btn-confirm-yes { padding: .6rem 1.3rem; border-radius: 12px; border: none; background: var(--gradient-pink); color: var(--white); font-size: .86rem; font-weight: 700; cursor: pointer; font-family: inherit; transition: transform .2s; }
.btn-confirm-yes:hover { transform: translateY(-1px); }
.btn-confirm-yes.danger { background: #e04867; box-shadow: 0 8px 20px rgba(224,72,103,.25); }
.btn-confirm-no { padding: .6rem 1.1rem; border-radius: 12px; border: 1.5px solid var(--pink-100); background: var(--white); color: var(--ink-muted); font-size: .86rem; font-weight: 600; cursor: pointer; font-family: inherit; }
.btn-confirm-no:hover { border-color: var(--bright-pink); color: var(--hot-pink); }

.success-box { text-align: center; }
.success-popup-icon { width: 56px; height: 56px; border-radius: 50%; background: #e8faf5; border: 2px solid #8ce0bb; display: flex; align-items: center; justify-content: center; margin: 0 auto .85rem; box-shadow: 0 8px 24px rgba(31,157,105,.18); }
.success-box .confirm-box-title { color: #1a7a52; font-size: 1.05rem; }
.success-box .confirm-box-body { margin-bottom: 1.1rem; }
.success-box .confirm-box-actions { justify-content: center; }
.success-box .btn-confirm-yes { background: linear-gradient(135deg, #1f9d69, #4ecb8d); box-shadow: 0 8px 20px rgba(31,157,105,.25); min-width: 120px; }
</style>

<div class="action-loading-overlay" id="action-loading" aria-live="polite" aria-hidden="true">
    <div class="action-loading-box">
        <span class="loading-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="DormEase">
        </span>
        <span id="action-loading-text">Please wait...</span>
    </div>
</div>

<div class="confirm-overlay" id="confirm-dialog">
    <div class="confirm-box">
        <div class="confirm-box-title" id="confirm-title">Are you sure?</div>
        <div class="confirm-box-body" id="confirm-body"></div>
        <div class="confirm-box-actions">
            <button type="button" class="btn-confirm-no" id="confirm-no">Cancel</button>
            <button type="button" class="btn-confirm-yes" id="confirm-yes">Confirm</button>
        </div>
    </div>
</div>

<div class="confirm-overlay" id="success-dialog">
    <div class="confirm-box success-box">
        <div class="success-popup-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#1f9d69" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="confirm-box-title" id="success-title">Success</div>
        <div class="confirm-box-body" id="success-body"></div>
        <div class="confirm-box-actions">
            <button type="button" class="btn-confirm-yes" id="success-ok">OK</button>
        </div>
    </div>
</div>

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

function showActionLoading(message) {
    var overlay = document.getElementById('action-loading');
    document.getElementById('action-loading-text').textContent = message || 'Please wait...';
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
}

function hideActionLoading() {
    var overlay = document.getElementById('action-loading');
    overlay.classList.remove('open');
    overlay.setAttribute('aria-hidden', 'true');
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

function showConfirm(title, body, onConfirm, options) {
    options = options || {};
    document.getElementById('confirm-title').textContent = title || 'Are you sure?';
    document.getElementById('confirm-body').textContent = body || '';
    var yesBtn = document.getElementById('confirm-yes');
    yesBtn.textContent = options.confirmLabel || 'Confirm';
    yesBtn.classList.toggle('danger', !!options.danger);
    document.getElementById('confirm-dialog').classList.add('open');
    var close = function() {
        document.getElementById('confirm-dialog').classList.remove('open');
        yesBtn.classList.remove('danger');
        yesBtn.onclick = null;
        document.getElementById('confirm-no').onclick = null;
    };
    yesBtn.onclick = function() { close(); if (onConfirm) onConfirm(); };
    document.getElementById('confirm-no').onclick = close;
}

function confirmAndSubmitForm(form, title, body, options) {
    showConfirm(title, body, function() {
        setFormLoading(form, form.dataset.loadingMessage || 'Please wait...');
        form.submit();
    }, options);
}

function showSuccessPopup(title, message) {
    document.getElementById('success-title').textContent = title || 'Success';
    document.getElementById('success-body').textContent = message || 'Action completed successfully.';
    var dialog = document.getElementById('success-dialog');
    dialog.classList.add('open');
    var close = function() { dialog.classList.remove('open'); };
    document.getElementById('success-ok').onclick = close;
    dialog.onclick = function(e) { if (e.target === dialog) close(); };
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form[data-loading-message]').forEach(function(form) {
        if (form.dataset.confirmBound) return;
        form.dataset.confirmBound = '1';
        form.addEventListener('submit', function() {
            if (this.dataset.skipAutoLoading === '1') return;
            setFormLoading(this, this.dataset.loadingMessage || 'Please wait...');
        });
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key !== 'Escape') return;
    var successDialog = document.getElementById('success-dialog');
    if (successDialog && successDialog.classList.contains('open')) {
        successDialog.classList.remove('open');
        return;
    }
    var confirmDialog = document.getElementById('confirm-dialog');
    if (confirmDialog && confirmDialog.classList.contains('open')) {
        confirmDialog.classList.remove('open');
    }
});

@if(session('success') && !session('new_account_id') && !session('reset_account_id'))
    document.addEventListener('DOMContentLoaded', function() { showSuccessPopup('Success', @json(session('success'))); });
@endif

@if(session('error'))
    document.addEventListener('DOMContentLoaded', function() { showToast(@json(session('error')), 'error'); });
@endif

@if($errors->any() && !session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        var firstError = @json($errors->first());
        if (firstError) showToast(firstError, 'error');
    });
@endif
</script>