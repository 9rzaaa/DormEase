<script>
    (function() {
        var latestSeenNotificationId = null;
        var firstLiveNotificationLoad = true;
        var pollTimer = null;

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
                var item = document.createElement('div');
                item.className = 'notif-dd-item' + (notif.isRead ? '' : ' unread');
                item.innerHTML =
                    (notif.isRead
                        ? '<div style="width:7px;flex-shrink:0;"></div>'
                        : '<div class="notif-unread-dot"></div>') +
                    '<div class="notif-dd-icon">' +
                        '<img src="' + escapeHtml(notif.icon) + '" alt="" onerror="this.src=\'{{ asset("icons/bell.png") }}\'">' +
                    '</div>' +
                    '<div class="notif-dd-body">' +
                        '<div class="notif-dd-msg">' + escapeHtml(notif.message) + '</div>' +
                        '<div class="notif-dd-time">' + escapeHtml(notif.ago) + '</div>' +
                    '</div>';
                item.addEventListener('click', function() {
                    openNotifDetail(notif);
                    notif.isRead = true;
                    item.classList.remove('unread');
                });
                list.appendChild(item);
            });
        }

        function showLiveNotice(notifications) {
            var newest = notifications[0];
            if (!newest || newest.isRead) return;

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

                    if (allowNotice && newestId && (!latestSeenNotificationId || newestId > latestSeenNotificationId)) {
                        showLiveNotice(notifications);
                    }

                    if (newestId) {
                        latestSeenNotificationId = Math.max(latestSeenNotificationId || 0, newestId);
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
            renderLiveNotifications(false);
            pollTimer = setInterval(function() {
                renderLiveNotifications(true);
            }, 5000);
        });

        window.addEventListener('beforeunload', function() {
            if (pollTimer) clearInterval(pollTimer);
        });
    })();
</script>
