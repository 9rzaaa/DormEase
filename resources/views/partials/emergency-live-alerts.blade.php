<script>
    (function() {
        function __escHtml(str) {
            return (str == null ? '' : String(str))
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function __beep() {
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                function sirenPulse(freqLow, freqHigh, start, dur) {
                    var o = ctx.createOscillator();
                    var g = ctx.createGain();
                    o.connect(g); g.connect(ctx.destination);
                    o.type = 'sawtooth';
                    o.frequency.setValueAtTime(freqLow, ctx.currentTime + start);
                    o.frequency.linearRampToValueAtTime(freqHigh, ctx.currentTime + start + dur * 0.5);
                    o.frequency.linearRampToValueAtTime(freqLow, ctx.currentTime + start + dur);
                    g.gain.setValueAtTime(0.85, ctx.currentTime + start);
                    g.gain.setValueAtTime(0.85, ctx.currentTime + start + dur - 0.03);
                    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + start + dur);
                    o.start(ctx.currentTime + start);
                    o.stop(ctx.currentTime + start + dur + 0.05);
                }
                sirenPulse(660, 1100, 0.00, 0.25);
                sirenPulse(660, 1100, 0.28, 0.25);
                sirenPulse(660, 1100, 0.56, 0.25);
                sirenPulse(660, 1100, 0.84, 0.30);
            } catch (e) {}
        }

        function __fireBrowserNotification(title, type, location) {
            if (typeof Notification !== 'undefined' && Notification.permission === 'granted') {
                try { new Notification(title, { body: type + ' \u2014 ' + location }); } catch (e) {}
            }
        }

        /* ── PANIC ALERTS ── */

        var __panicSeenIds = new Set();
        var __panicActiveReports = [];
        var __panicBeepInterval = null;
        var __panicRotateIndex = 0;
        var __panicRotateInterval = null;

        function __renderPanicBanner() {
            if (__panicActiveReports.length === 0) {
                var existing = document.getElementById('__panic-alert-banner');
                if (existing) existing.remove();
                if (__panicBeepInterval) { clearInterval(__panicBeepInterval); __panicBeepInterval = null; }
                if (__panicRotateInterval) { clearInterval(__panicRotateInterval); __panicRotateInterval = null; }
                __panicRotateIndex = 0;
                return;
            }

            if (__panicRotateIndex >= __panicActiveReports.length) __panicRotateIndex = 0;

            var existing = document.getElementById('__panic-alert-banner');
            if (!existing) {
                var banner = document.createElement('div');
                banner.id = '__panic-alert-banner';
                banner.style.cssText = 'position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.7);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
                banner.innerHTML = '<style>@keyframes __pp{0%,100%{box-shadow:0 0 0 0 rgba(255,45,120,.6),0 24px 60px rgba(255,45,120,.4)}50%{box-shadow:0 0 0 18px rgba(255,45,120,0),0 24px 60px rgba(255,45,120,.4)}}'
                    + '@keyframes __pf{0%{opacity:0;transform:translateY(4px);}100%{opacity:1;transform:translateY(0);}}</style>'
                    + '<div style="background:linear-gradient(135deg,#ff2d78,#c0303a);color:#fff;padding:2.5rem 2.8rem;border-radius:24px;max-width:460px;width:90vw;text-align:center;font-family:inherit;animation:__pp 1.5s infinite;">'
                    + '<div style="font-size:3.5rem;margin-bottom:.5rem;">&#9888;</div>'
                    + '<div id="__panic-count-label" style="font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;opacity:.85;margin-bottom:.4rem;"></div>'
                    + '<div id="__panic-rotate-content"></div>'
                    + '<button onclick="__dismissAllPanic()" style="margin-top:1.6rem;background:#fff;color:#c0303a;border:none;padding:.75rem 2.2rem;border-radius:12px;font-size:.9rem;font-weight:800;cursor:pointer;font-family:inherit;">Acknowledge &amp; Dismiss All</button>'
                    + '</div>';
                document.body.appendChild(banner);
            }

            __updatePanicContent();

            if (!__panicRotateInterval && __panicActiveReports.length > 1) {
                __panicRotateInterval = setInterval(function() {
                    __panicRotateIndex = (__panicRotateIndex + 1) % __panicActiveReports.length;
                    __updatePanicContent();
                }, 2000);
            } else if (__panicActiveReports.length <= 1 && __panicRotateInterval) {
                clearInterval(__panicRotateInterval);
                __panicRotateInterval = null;
                __panicRotateIndex = 0;
            }
        }

        function __updatePanicContent() {
            var count = __panicActiveReports.length;
            var r = __panicActiveReports[__panicRotateIndex];
            if (!r) return;

            var countLabel = document.getElementById('__panic-count-label');
            var content = document.getElementById('__panic-rotate-content');
            if (!countLabel || !content) return;

            countLabel.textContent = count === 1
                ? 'Panic Alert'
                : 'Panic Alert (' + (__panicRotateIndex + 1) + ' of ' + count + ')';

            content.style.animation = 'none';
            void content.offsetWidth;
            content.style.animation = '__pf .3s ease';
            var formattedTime = __formatTime12h(r.reported_at);

            content.innerHTML = '<div style="font-size:1.6rem;font-weight:800;line-height:1.2;margin-bottom:.5rem;">' + __escHtml(r.type || 'Emergency') + '</div>'
                + '<div style="font-size:1rem;opacity:.9;font-weight:600;margin-bottom:.75rem;">' + __escHtml(r.location || 'unknown') + '</div>'
                + '<div style="font-size:.75rem;opacity:.75;font-weight:500;letter-spacing:.02em;">Reported: ' + __escHtml(formattedTime) + '</div>';
        }

        window.__dismissAllPanic = function() {
            var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
            __panicActiveReports.forEach(function(r) {
                sessionStorage.setItem('panicDismissed_' + r.report_id, '1');
                if (r.report_id) {
                    fetch('/emergency/' + r.report_id + '/acknowledge', {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }
                    }).catch(function(e) {});
                }
            });
            __panicActiveReports = [];
            __renderPanicBanner();
        };

        function __handlePanicData(data) {
            var incoming = (data && data.reports) ? data.reports : [];

            var stillActiveIds = incoming.map(function(r) { return r.report_id; });
            __panicActiveReports = __panicActiveReports.filter(function(r) {
                return stillActiveIds.indexOf(r.report_id) !== -1;
            });

            var changed = false;

            incoming.forEach(function(r) {
                if (sessionStorage.getItem('panicDismissed_' + r.report_id)) return;

                var alreadyShown = __panicActiveReports.some(function(existing) {
                    return existing.report_id === r.report_id;
                });
                if (alreadyShown) return;

                __panicActiveReports.push(r);
                changed = true;

                if (!__panicSeenIds.has(r.report_id)) {
                    __panicSeenIds.add(r.report_id);
                    __fireBrowserNotification('Panic Alert', r.type, r.location);
                }
            });

            if (changed) {
                __beep();
                if (__panicBeepInterval) clearInterval(__panicBeepInterval);
                __panicBeepInterval = setInterval(__beep, 3000);
            }

            __renderPanicBanner();
        }

        /* ── CRITICAL / URGENT ALERTS ── */

        var __criticalSeenIds = new Set();
        var __criticalActiveReportsByLevel = { critical: [], urgent: [] };
        var __criticalBeepInterval = null;
        var __criticalRotateIndex = 0;
        var __criticalRotateInterval = null;
        var __criticalActiveLevel = null;

        function __criticalAccent(level) {
            return level === 'critical'
                ? { grad: '#ff2d78,#c0303a', solid: '#c0303a', label: 'Critical Emergency' }
                : { grad: '#f59e0b,#c07800', solid: '#c07800', label: 'Urgent Emergency' };
        }

        function __renderCriticalBanner() {
            __criticalActiveLevel = __criticalActiveReportsByLevel.critical.length > 0
                ? 'critical'
                : (__criticalActiveReportsByLevel.urgent.length > 0 ? 'urgent' : null);

            if (!__criticalActiveLevel) {
                var existing = document.getElementById('__critical-alert-banner');
                if (existing) existing.remove();
                if (__criticalBeepInterval) { clearInterval(__criticalBeepInterval); __criticalBeepInterval = null; }
                if (__criticalRotateInterval) { clearInterval(__criticalRotateInterval); __criticalRotateInterval = null; }
                __criticalRotateIndex = 0;
                return;
            }

            var activeReports = __criticalActiveReportsByLevel[__criticalActiveLevel] || [];
            if (__criticalRotateIndex >= activeReports.length) __criticalRotateIndex = 0;

            var existing = document.getElementById('__critical-alert-banner');
            if (!existing) {
                var banner = document.createElement('div');
                banner.id = '__critical-alert-banner';
                banner.style.cssText = 'position:fixed;inset:0;z-index:99998;background:rgba(0,0,0,.7);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
                banner.innerHTML = '<style>@keyframes __cp{0%,100%{box-shadow:0 0 0 0 rgba(255,45,120,.6),0 24px 60px rgba(255,45,120,.4)}50%{box-shadow:0 0 0 18px rgba(255,45,120,0),0 24px 60px rgba(255,45,120,.4)}}'
                    + '@keyframes __cf{0%{opacity:0;transform:translateY(4px);}100%{opacity:1;transform:translateY(0);}}</style>'
                    + '<div id="__critical-box" style="padding:2.5rem 2.8rem;border-radius:24px;max-width:460px;width:90vw;text-align:center;font-family:inherit;color:#fff;animation:__cp 1.5s infinite;">'
                    + '<div style="font-size:3.5rem;margin-bottom:.5rem;">&#9888;</div>'
                    + '<div id="__critical-count-label" style="font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;opacity:.85;margin-bottom:.4rem;"></div>'
                    + '<div id="__critical-rotate-content"></div>'
                    + '<button id="__critical-dismiss-btn" onclick="__dismissAllCritical()" style="margin-top:1.6rem;background:#fff;border:none;padding:.75rem 2.2rem;border-radius:12px;font-size:.9rem;font-weight:800;cursor:pointer;font-family:inherit;">Acknowledge &amp; Dismiss All</button>'
                    + '</div>';
                document.body.appendChild(banner);
            }

            __updateCriticalContent();

            if (!__criticalRotateInterval && activeReports.length > 1) {
                __criticalRotateInterval = setInterval(function() {
                    var reports = __criticalActiveReportsByLevel[__criticalActiveLevel] || [];
                    if (reports.length === 0) return;
                    __criticalRotateIndex = (__criticalRotateIndex + 1) % reports.length;
                    __updateCriticalContent();
                }, 2000);
            } else if (activeReports.length <= 1 && __criticalRotateInterval) {
                clearInterval(__criticalRotateInterval);
                __criticalRotateInterval = null;
                __criticalRotateIndex = 0;
            }
        }

        function __updateCriticalContent() {
            var level = __criticalActiveLevel;
            var activeReports = level ? (__criticalActiveReportsByLevel[level] || []) : [];
            var count = activeReports.length;
            var r = activeReports[__criticalRotateIndex];
            if (!r) return;

            var box = document.getElementById('__critical-box');
            var countLabel = document.getElementById('__critical-count-label');
            var content = document.getElementById('__critical-rotate-content');
            var btn = document.getElementById('__critical-dismiss-btn');
            if (!box || !countLabel || !content) return;

            var accent = __criticalAccent(level);
            box.style.background = 'linear-gradient(135deg,' + accent.grad + ')';
            if (btn) btn.style.color = accent.solid;
            if (btn) btn.innerHTML = 'Acknowledge &amp; Dismiss ' + (level === 'critical' ? 'Critical' : 'Urgent') + ' Alerts';

            countLabel.textContent = count === 1
                ? accent.label
                : accent.label + ' (' + (__criticalRotateIndex + 1) + ' of ' + count + ')';

            var formattedTime = __formatTime12h(r.reported_at);

            content.style.animation = 'none';
            void content.offsetWidth;
            content.style.animation = '__cf .3s ease';
            content.innerHTML = '<div style="font-size:1.6rem;font-weight:800;line-height:1.2;margin-bottom:.5rem;">' + __escHtml(r.emergency_type) + '</div>'
                + '<div style="font-size:1rem;opacity:.9;font-weight:600;margin-bottom:.75rem;">' + __escHtml(r.location) + '</div>'
                + '<div style="font-size:.75rem;opacity:.75;font-weight:500;letter-spacing:.02em;">Reported: ' + __escHtml(formattedTime) + '</div>';
        }

        function __formatTime12h(dateStr) {
            if (!dateStr) return '';
            var d = new Date(dateStr);
            if (isNaN(d)) return dateStr;
            var hours = d.getHours(), mins = d.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            mins = mins < 10 ? '0' + mins : mins;
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear() + ' \u2014 ' + hours + ':' + mins + ' ' + ampm;
        }

        window.__dismissAllCritical = function() {
            var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
            var level = __criticalActiveLevel;
            var reportsToDismiss = level ? (__criticalActiveReportsByLevel[level] || []) : [];
            reportsToDismiss.forEach(function(r) {
                sessionStorage.setItem('criticalDismissed_' + r.report_id, '1');
                if (r.report_id) {
                    fetch('/emergency/' + r.report_id + '/acknowledge', {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }
                    }).catch(function(e) {});
                }
            });
            if (level) __criticalActiveReportsByLevel[level] = [];
            __criticalRotateIndex = 0;
            __renderCriticalBanner();
        };

        function __handleCriticalData(data) {
            var incoming = (data && data.reports) ? data.reports : [];

            var stillActiveIds = incoming.map(function(r) { return r.report_id; });
            ['critical', 'urgent'].forEach(function(level) {
                __criticalActiveReportsByLevel[level] = __criticalActiveReportsByLevel[level].filter(function(r) {
                    return stillActiveIds.indexOf(r.report_id) !== -1;
                });
            });

            var changed = false;

            incoming.forEach(function(r) {
                if ((r.emergency_type || '').toLowerCase() === 'panic alert') return;
                if (r.is_panic_alert) return;
                if (sessionStorage.getItem('criticalDismissed_' + r.report_id)) return;
                if (r.urgency_level !== 'critical' && r.urgency_level !== 'urgent') return;

                var levelReports = __criticalActiveReportsByLevel[r.urgency_level];
                var alreadyShown = levelReports.some(function(existing) {
                    return existing.report_id === r.report_id;
                });
                if (alreadyShown) return;

                levelReports.push(r);
                changed = true;

                if (!__criticalSeenIds.has(r.report_id)) {
                    __criticalSeenIds.add(r.report_id);
                    var accent = __criticalAccent(r.urgency_level);
                    __fireBrowserNotification(accent.label, r.emergency_type, r.location);
                }
            });

            if (changed) {
                __beep();
                if (__criticalBeepInterval) clearInterval(__criticalBeepInterval);
                __criticalBeepInterval = setInterval(__beep, 3000);
            }

            __renderCriticalBanner();
        }

        window.__processLiveEmergencyAlerts = function(panic, critical) {
            __handlePanicData(panic);
            __handleCriticalData(critical);
        };

        function __requestEmergencyNotificationPermission() {
            if (typeof Notification === 'undefined' || Notification.permission !== 'default') return;

            try {
                var permissionRequest = Notification.requestPermission();
                if (permissionRequest && typeof permissionRequest.catch === 'function') {
                    permissionRequest.catch(function() {});
                }
            } catch (e) {}
        }

        if (typeof Notification !== 'undefined' && Notification.permission === 'default') {
            ['click', 'keydown', 'touchstart'].forEach(function(eventName) {
                document.addEventListener(eventName, __requestEmergencyNotificationPermission, { once: true, passive: true });
            });
        }
    })();
</script>
