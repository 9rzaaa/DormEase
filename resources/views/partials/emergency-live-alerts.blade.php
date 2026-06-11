<script>
    (function() {
        var __panicLastId = null;
        var __panicBeepInterval = null;

        function __escHtml(str) {
            return (str == null ? '' : String(str))
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function __buildPanicAudio() {
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                function beep(freq, start, dur) {
                    var o = ctx.createOscillator();
                    var g = ctx.createGain();
                    o.connect(g); g.connect(ctx.destination);
                    o.frequency.value = freq; o.type = 'sine';
                    g.gain.setValueAtTime(0.4, ctx.currentTime + start);
                    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + start + dur);
                    o.start(ctx.currentTime + start);
                    o.stop(ctx.currentTime + start + dur + 0.05);
                }
                beep(880, 0, 0.18); beep(880, 0.22, 0.18); beep(1100, 0.44, 0.28);
            } catch (e) {}
        }

        function __formatPanicTime(dateStr) {
            if (!dateStr) return '';
            var match = String(dateStr).match(/^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/);
            var d = match
                ? new Date(Number(match[1]), Number(match[2]) - 1, Number(match[3]), Number(match[4]), Number(match[5]), Number(match[6] || 0))
                : new Date(dateStr);
            if (isNaN(d)) return dateStr;
            var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            var hours = d.getHours(), mins = d.getMinutes(), secs = d.getSeconds();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear()
                + ' ' + String(hours).padStart(2, '0') + ':' + String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0') + ' ' + ampm;
        }

        function __showPanicBanner(type, location, reportedAt) {
            if (__panicBeepInterval) clearInterval(__panicBeepInterval);
            __panicBeepInterval = setInterval(__buildPanicAudio, 3000);
            var formattedReportedAt = __formatPanicTime(reportedAt);
            var banner = document.createElement('div');
            banner.id = '__panic-alert-banner';
            banner.style.cssText = 'position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.7);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
            banner.innerHTML = '<style>@keyframes __pp{0%,100%{box-shadow:0 0 0 0 rgba(255,45,120,.6),0 24px 60px rgba(255,45,120,.4)}50%{box-shadow:0 0 0 18px rgba(255,45,120,0),0 24px 60px rgba(255,45,120,.4)}}</style>'
                + '<div style="background:linear-gradient(135deg,#ff2d78,#c0303a);color:#fff;padding:2.5rem 2.8rem;border-radius:24px;max-width:460px;width:90vw;text-align:center;font-family:inherit;animation:__pp 1.5s infinite;">'
                + '<div style="font-size:3.5rem;margin-bottom:.5rem;">&#9888;</div>'
                + '<div style="font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;opacity:.85;margin-bottom:.4rem;">Panic Alert</div>'
                + '<div style="font-size:1.6rem;font-weight:800;line-height:1.2;margin-bottom:.5rem;">' + __escHtml(type) + '</div>'
                + '<div style="font-size:1rem;opacity:.9;font-weight:600;margin-bottom:.75rem;">' + __escHtml(location) + '</div>'
                + '<div style="font-size:.75rem;opacity:.75;font-weight:500;margin-bottom:2rem;letter-spacing:.02em;">Reported: ' + __escHtml(formattedReportedAt) + '</div>'
                + '<button onclick="__dismissPanic()" style="background:#fff;color:#c0303a;border:none;padding:.75rem 2.2rem;border-radius:12px;font-size:.9rem;font-weight:800;cursor:pointer;font-family:inherit;">Acknowledge &amp; Dismiss</button>'
                + '</div>';
            document.body.appendChild(banner);
        }

        window.__dismissPanic = function() {
            var banner = document.getElementById('__panic-alert-banner');
            if (banner) banner.remove();
            if (__panicBeepInterval) { clearInterval(__panicBeepInterval); __panicBeepInterval = null; }
            sessionStorage.setItem('panicDismissed_' + __panicLastId, '1');
        };

        function __firePanicBrowserNotification(type, location) {
            if (typeof Notification !== 'undefined' && Notification.permission === 'granted') {
                try { new Notification('Panic Alert', { body: type + ' \u2014 ' + location }); } catch (e) {}
            }
        }

        function __handlePanicData(data) {
            if (!data || !data.has_panic) return;
            if (data.report_id === __panicLastId) return;
            if (sessionStorage.getItem('panicDismissed_' + data.report_id)) return;
            if (document.getElementById('__panic-alert-banner')) return;

            __panicLastId = data.report_id;
            __buildPanicAudio();
            __showPanicBanner(data.type, data.location, data.reported_at);
            __firePanicBrowserNotification(data.type, data.location);
        }

        var __criticalSeen = new Set();
        var __criticalQueue = [];
        var __criticalActive = false;
        var __criticalBeepInterval = null;

        function __criticalEscHtml(str) {
            return (str == null ? '' : String(str))
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        function __criticalBeep() {
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                function beep(freq, start, dur) {
                    var o = ctx.createOscillator();
                    var g = ctx.createGain();
                    o.connect(g); g.connect(ctx.destination);
                    o.frequency.value = freq; o.type = 'sine';
                    g.gain.setValueAtTime(0.4, ctx.currentTime + start);
                    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + start + dur);
                    o.start(ctx.currentTime + start);
                    o.stop(ctx.currentTime + start + dur + 0.05);
                }
                beep(880, 0, 0.18); beep(880, 0.22, 0.18); beep(1100, 0.44, 0.28);
            } catch (e) {}
        }

        function __fireCriticalBrowserNotification(report) {
            if (typeof Notification === 'undefined' || Notification.permission !== 'granted') return;

            try {
                var isCritical = report.urgency_level === 'critical';
                new Notification(isCritical ? 'Critical Emergency' : 'Urgent Emergency', {
                    body: (report.emergency_type || 'Emergency report') + ' - ' + (report.location || 'Location unavailable'),
                });
            } catch (e) {}
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

        function __showNextCritical() {
            if (__criticalActive || __criticalQueue.length === 0) return;
            __criticalActive = true;
            var report = __criticalQueue.shift();
            var isCritical = report.urgency_level === 'critical';
            if (__criticalBeepInterval) clearInterval(__criticalBeepInterval);
            __criticalBeep();
            __criticalBeepInterval = setInterval(__criticalBeep, 3000);
            var accentColor = isCritical ? '#ff2d78,#c0303a' : '#f59e0b,#c07800';
            var accentSolid = isCritical ? '#c0303a' : '#c07800';
            var label       = isCritical ? 'Critical Emergency' : 'Urgent Emergency';
            var formattedTime = __formatTime12h(report.reported_at);
            var overlay = document.createElement('div');
            overlay.id = '__critical-alert-overlay';
            overlay.__reportId = report.report_id;
            overlay.style.cssText = 'position:fixed;inset:0;z-index:99998;background:rgba(0,0,0,.7);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
            overlay.innerHTML = '<style>@keyframes __cp{0%,100%{box-shadow:0 0 0 0 rgba(255,45,120,.6),0 24px 60px rgba(255,45,120,.4)}50%{box-shadow:0 0 0 18px rgba(255,45,120,0),0 24px 60px rgba(255,45,120,.4)}}</style>'
                + '<div style="background:linear-gradient(135deg,' + accentColor + ');color:#fff;padding:2.5rem 2.8rem;border-radius:24px;max-width:460px;width:90vw;text-align:center;font-family:inherit;animation:__cp 1.5s infinite;">'
                + '<div style="font-size:3.5rem;margin-bottom:.5rem;">&#9888;</div>'
                + '<div style="font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;opacity:.85;margin-bottom:.4rem;">' + label + '</div>'
                + '<div style="font-size:1.6rem;font-weight:800;line-height:1.2;margin-bottom:.5rem;">' + __criticalEscHtml(report.emergency_type) + '</div>'
                + '<div style="font-size:1rem;opacity:.9;font-weight:600;margin-bottom:.75rem;">' + __criticalEscHtml(report.location) + '</div>'
                + '<div style="font-size:.75rem;opacity:.75;font-weight:500;margin-bottom:2rem;letter-spacing:.02em;">Reported: ' + __criticalEscHtml(formattedTime) + '</div>'
                + '<button onclick="__dismissCritical()" style="background:#fff;color:' + accentSolid + ';border:none;padding:.75rem 2.2rem;border-radius:12px;font-size:.9rem;font-weight:800;cursor:pointer;font-family:inherit;">Acknowledge &amp; Dismiss</button>'
                + '</div>';
            document.body.appendChild(overlay);
        }

        window.__dismissCritical = function() {
            var overlay = document.getElementById('__critical-alert-overlay');
            if (!overlay) return;
            if (__criticalBeepInterval) { clearInterval(__criticalBeepInterval); __criticalBeepInterval = null; }
            sessionStorage.setItem('criticalDismissed_' + overlay.__reportId, '1');
            overlay.remove();
            __criticalActive = false;
            __showNextCritical();
        };

        function __handleCriticalData(data) {
            (data && data.reports ? data.reports : []).forEach(function(r) {
                if ((r.emergency_type || '').toLowerCase() === 'panic alert') return;
                if (__criticalSeen.has(r.report_id)) return;
                if (sessionStorage.getItem('criticalDismissed_' + r.report_id)) return;

                __criticalSeen.add(r.report_id);
                __fireCriticalBrowserNotification(r);
                __criticalQueue.push(r);
                __showNextCritical();
            });
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
