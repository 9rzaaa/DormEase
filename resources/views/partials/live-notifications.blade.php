<script>
    (function() {
        var latestSeenNotificationId = null;
        var firstLiveNotificationLoad = true;
        var pollTimer = null;
        var emergencyPollTimer = null;
        var notificationAudioContext = null;
        var notificationSoundUnlocked = false;
        var queuedNotificationSound = false;

        function escapeHtml(value) {
            return (value == null ? '' : String(value))
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function setBadge(unreadCount) {
            var bell = document.getElementById('notif-bell');
            if (!bell) return;

            var badge = document.getElementById('notif-badge');
            if (unreadCount > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'notif-badge';
                    badge.id = 'notif-badge';
                    bell.appendChild(badge);
                }
                badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            } else if (badge) {
                badge.remove();
            }
        }

        function setHeader(unreadCount) {
            var header = document.querySelector('.notif-dropdown-header');
            var title = document.querySelector('.notif-dropdown-title');
            if (!header || !title) return;

            title.innerHTML = 'Notifications' + (unreadCount > 0
                ? ' <span style="color:var(--ink-muted);font-weight:500;font-size:.78rem;">(' + unreadCount + ' unread)</span>'
                : '');

            var button = header.querySelector('.notif-mark-all');
            if (unreadCount > 0 && !button) {
                button = document.createElement('button');
                button.className = 'notif-mark-all';
                button.type = 'button';
                button.textContent = 'Mark all read';
                button.onclick = markAllRead;
                header.appendChild(button);
            } else if (unreadCount === 0 && button) {
                button.remove();
            }
        }

        function renderNotifications(notifications) {
            var list = document.querySelector('.notif-dropdown-list');
            if (!list) return;

            if (!notifications.length) {
                list.innerHTML = '<div class="notif-empty">No notifications yet.</div>';
                return;
            }

            list.innerHTML = '';
            notifications.forEach(function(notif) {
                var isReservation = notif.type === 'reservation' || notif.raw_type === 'tenant_reserved';

                var resolvedIcon = notif.icon;
                if (isReservation && (!resolvedIcon || resolvedIcon === '')) {
                    resolvedIcon = '{{ asset("icons/pending.png") }}';
                }

                var item = document.createElement('div');
                item.className = 'notif-dd-item'
                    + (notif.isRead ? '' : ' unread')
                    + (isReservation ? ' reservation' : '');

                var dotHtml = notif.isRead
                    ? '<div style="width:7px;flex-shrink:0;"></div>'
                    : '<div class="notif-unread-dot"></div>';

                var iconHtml = '<div class="notif-dd-icon' + (isReservation ? ' reservation-icon' : '') + '">'
                    + '<img src="' + escapeHtml(resolvedIcon) + '" alt="" onerror="this.src=\'{{ asset("icons/bell.png") }}\'">'
                    + '</div>';

                var typeLabelHtml = isReservation
                    ? '<div class="notif-dd-type-label reservation">New Reservation</div>'
                    : '';

                var bodyHtml = '<div class="notif-dd-body">'
                    + typeLabelHtml
                    + '<div class="notif-dd-msg">' + escapeHtml(notif.message) + '</div>'
                    + '<div class="notif-dd-time">' + escapeHtml(notif.ago) + '</div>'
                    + '</div>';

                item.innerHTML = dotHtml + iconHtml + bodyHtml;

                item.addEventListener('click', (function(n, ri) {
                    return function() {
                        var typeMap = {
                            'tenant_reserved':  'reservation',
                            'reservation':      'reservation',
                            'reservation_overdue': 'reservation_overdue',
                            'maintenance':      'maintenance',
                            'emergency':        'emergency',
                            'billing':          'billing',
                            'document':         'document',
                            'announcement':     'announcement',
                            'visitor':          'visitor',
                            'moveout_reminder': 'moveout_reminder',
                            'tenant':           'tenant',
                        };
                        var mappedType = typeMap[n.type] || typeMap[n.raw_type];
                        if (!mappedType) {
                            var keys = Object.keys(typeMap);
                            for (var i = 0; i < keys.length; i++) {
                                if ((n.type && n.type.indexOf(keys[i]) === 0) || (n.raw_type && n.raw_type.indexOf(keys[i]) === 0)) {
                                    mappedType = typeMap[keys[i]];
                                    break;
                                }
                            }
                        }
                        var notifForModal = {
                            id:      n.id,
                            type:    mappedType || n.type || 'general',
                            icon:    ri,
                            message: n.message,
                            time:    n.time || '',
                            ago:     n.ago || '',
                            url:     n.url || '',
                            isRead:  n.isRead,
                        };
                        openNotifDetail(notifForModal);
                        n.isRead = true;
                        item.classList.remove('unread');
                    };
                })(notif, resolvedIcon));

                list.appendChild(item);
            });
        }

        function getNotificationAudioContext() {
            if (!notificationAudioContext) {
                var AudioContextCtor = window.AudioContext || window.webkitAudioContext;
                if (!AudioContextCtor) return null;
                notificationAudioContext = new AudioContextCtor();
            }

            return notificationAudioContext;
        }

        function playNotificationSound() {
            try {
                var ctx = getNotificationAudioContext();
                if (!ctx) return;

                if (ctx.state === 'suspended') {
                    queuedNotificationSound = true;
                    ctx.resume().then(function() {
                        notificationSoundUnlocked = true;
                        if (queuedNotificationSound) {
                            queuedNotificationSound = false;
                            playNotificationSound();
                        }
                    }).catch(function() {});
                    return;
                }

                notificationSoundUnlocked = true;
                queuedNotificationSound = false;

                var now = ctx.currentTime;
                [
                    { frequency: 740, start: 0, duration: 0.12 },
                    { frequency: 980, start: 0.14, duration: 0.18 },
                ].forEach(function(tone) {
                    var oscillator = ctx.createOscillator();
                    var gain = ctx.createGain();

                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(tone.frequency, now + tone.start);
                    gain.gain.setValueAtTime(0.001, now + tone.start);
                    gain.gain.exponentialRampToValueAtTime(0.18, now + tone.start + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + tone.start + tone.duration);

                    oscillator.connect(gain);
                    gain.connect(ctx.destination);
                    oscillator.start(now + tone.start);
                    oscillator.stop(now + tone.start + tone.duration + 0.04);
                });
            } catch (e) {}
        }

        function unlockNotificationSound() {
            if (notificationSoundUnlocked && !queuedNotificationSound) return;

            try {
                var ctx = getNotificationAudioContext();
                if (!ctx) return;

                ctx.resume().then(function() {
                    notificationSoundUnlocked = true;
                    if (queuedNotificationSound) {
                        queuedNotificationSound = false;
                        playNotificationSound();
                    }
                }).catch(function() {});
            } catch (e) {}
        }

        function showLiveNotice(notifications) {
            var newest = notifications[0];
            if (!newest) return;
            if (newest.isRead) return;
            if (!latestSeenNotificationId) return;
            if (Number(newest.id) <= latestSeenNotificationId) return;

            playNotificationSound();

            if (typeof showToast === 'function') {
                showToast(newest.message || 'New notification', 'success');
            }

            if (typeof Notification !== 'undefined' && Notification.permission === 'granted') {
                try {
                    new Notification('DormEase notification', {
                        body: newest.message || 'New notification',
                        icon: newest.icon || '{{ asset("icons/bell.png") }}',
                    });
                } catch (e) {}
            }
        }

        function renderLiveNotifications(allowNotice) {
            fetch('{{ route("notifications.live") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || '',
                },
                cache: 'no-store',
            })
                .then(function(response) { return response.ok ? response.json() : null; })
                .then(function(payload) {
                    if (!payload) return;

                    var notifications = payload.notifications || [];
                    var newestId = notifications.length ? Number(notifications[0].id) : null;

                    renderNotifications(notifications);
                    setBadge(Number(payload.unread_count || 0));
                    setHeader(Number(payload.unread_count || 0));

                    if (firstLiveNotificationLoad) {
                        latestSeenNotificationId = newestId;
                        firstLiveNotificationLoad = false;
                        return;
                    }

                    if (allowNotice && newestId && latestSeenNotificationId && newestId > latestSeenNotificationId) {
                        showLiveNotice(notifications);
                    }

                    if (newestId) {
                        latestSeenNotificationId = Math.max(latestSeenNotificationId || 0, newestId);
                    }
                })
                .catch(function() {});
        }

        function escapeBannerHtml(value) {
            return (value == null ? '' : String(value))
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        function pollEmergencyAlerts() {
            fetch('/live-alerts', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || '',
                },
                cache: 'no-store',
            })
            .then(function(response) { return response.ok ? response.json() : null; })
            .then(function(payload) {
                if (!payload) return;
                if (typeof window.__processLiveEmergencyAlerts === 'function') {
                    window.__processLiveEmergencyAlerts(
                        payload.panic    || null,
                        payload.critical || { reports: [] }
                    );
                }
            })
            .catch(function() {});
        }

        window.markAllRead = function() {
            fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            }).then(function() {
                renderLiveNotifications(false);
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            ['click', 'keydown', 'touchstart'].forEach(function(eventName) {
                document.addEventListener(eventName, unlockNotificationSound, { once: true, passive: true });
            });

            renderLiveNotifications(false);
            pollTimer = setInterval(function() {
                renderLiveNotifications(true);
            }, 5000);

            pollEmergencyAlerts();
            emergencyPollTimer = setInterval(pollEmergencyAlerts, 5000);
        });

        window.addEventListener('beforeunload', function() {
            if (pollTimer) clearInterval(pollTimer);
            if (emergencyPollTimer) clearInterval(emergencyPollTimer);
        });
    })();
</script>
