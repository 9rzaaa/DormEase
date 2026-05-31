<?php

namespace App\Http\Controllers;

use App\Http\ViewComposers\NotificationComposer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $notifications = Notification::where('staff_id', $staff->staff_id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($notifications);
    }

    public function live()
    {
        $staff = Auth::guard('staff')->user();

        $query = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', NotificationComposer::visibleTypesFor($staff->role));

        $notifications = (clone $query)
            ->orderByDesc('created_at')
            ->orderByDesc('notif_id')
            ->limit(20)
            ->get()
            ->map(fn(Notification $notification) => $this->formatLiveNotification($notification))
            ->values();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => (clone $query)->where('is_read', 0)->count(),
        ]);
    }

    public function markRead($id)
    {
        $staff = Auth::guard('staff')->user();

        $notif = Notification::where('notif_id', $id)
            ->where('staff_id', $staff->staff_id)
            ->firstOrFail();

        $notif->update(['is_read' => 1]);

        if (request()->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return $notif->url ? redirect($notif->url) : back();
    }

    public function markAllRead()
    {
        $staff = Auth::guard('staff')->user();

        Notification::where('staff_id', $staff->staff_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        if (request()->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }

    public function destroy($id)
    {
        $staff = Auth::guard('staff')->user();

        Notification::where('notif_id', $id)
            ->where('staff_id', $staff->staff_id)
            ->delete();

        if (request()->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }

    private function formatLiveNotification(Notification $notification): array
    {
        $createdAt = $notification->created_at
            ? \Carbon\Carbon::parse($notification->created_at)
            : now();

        $uiType = match ($notification->type) {
            'maintenance_new', 'maintenance_update', 'maintenance_updated', 'maintenance_deleted' => 'maintenance',
            'emergency_new', 'emergency_updated' => 'emergency',
            'billing_overdue' => 'billing',
            'document_request' => 'document',
            'announcement_new' => 'announcement',
            'visitor_registration', 'visitor_checkin', 'visitor_checkout' => 'visitor',
            default => 'general',
        };

        $icon = match ($uiType) {
            'maintenance' => 'maintenance',
            'emergency' => 'warn',
            'billing' => 'billing',
            'document' => 'nav-docu',
            'announcement' => 'nav-announ',
            'visitor' => 'nav-visit',
            default => 'bell',
        };

        return [
            'id' => $notification->notif_id,
            'raw_type' => $notification->type,
            'type' => $uiType,
            'icon' => asset("icons/{$icon}.png"),
            'message' => $notification->message,
            'time' => $createdAt->format('F j, Y \a\t g:i A'),
            'ago' => $createdAt->diffForHumans(),
            'url' => $notification->url ?? '',
            'isRead' => (bool) $notification->is_read,
            'created_at' => $createdAt->toIso8601String(),
        ];
    }
}
