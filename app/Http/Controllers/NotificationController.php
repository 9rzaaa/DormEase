<?php

namespace App\Http\Controllers;

use App\Http\ViewComposers\NotificationComposer;
use App\Models\EmergencyReport;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $query = Notification::where('staff_id', $staff->staff_id);

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $notifications = $query->orderByDesc('created_at')->paginate(20);

        return response()->json($notifications);
    }

    public function live(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $query = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', NotificationComposer::visibleTypesFor($staff->role));

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $notifications = (clone $query)
            ->orderByDesc('created_at')
            ->orderByDesc('notif_id')
            ->limit(Notification::MAX_ROWS)
            ->get()
            ->map(fn(Notification $notification) => $this->formatLiveNotification($notification))
            ->values();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => (clone $query)->where('is_read', 0)->count(),
        ]);
    }

    public function liveAlerts(Request $request)
    {
        $payload = $this->live($request)->getData(true);

        $latest = EmergencyReport::where('is_panic_alert', true)
            ->where('status', 'active')
            ->orderByDesc('reported_at')
            ->first();

        $reports = EmergencyReport::whereIn('urgency_level', ['critical', 'urgent'])
            ->where('status', 'active')
            ->orderByDesc('reported_at')
            ->take(5)
            ->get()
            ->map(fn ($report) => [
                'report_id'      => $report->report_id,
                'urgency_level'  => $report->urgency_level,
                'emergency_type' => $report->emergency_type,
                'location'       => $report->location,
                'reported_at'    => $report->reported_at?->format('Y-m-d H:i:s'),
            ])
            ->values();

        return response()->json(array_merge($payload, [
            'panic' => [
                'has_panic'   => (bool) $latest,
                'report_id'   => $latest?->report_id,
                'type'        => $latest?->emergency_type,
                'location'    => $latest?->location,
                'reported_at' => $latest?->reported_at?->format('Y-m-d H:i:s'),
            ],
            'critical' => ['reports' => $reports],
        ]));
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

    public function markAllRead(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $query = Notification::where('staff_id', $staff->staff_id)
            ->where('is_read', 0);

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $query->update(['is_read' => 1]);

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

        $type = $notification->type ?? '';

        $uiType = match (true) {
            $type === 'tenant_reserved'            => 'reservation',
            str_starts_with($type, 'maintenance')  => 'maintenance',
            str_starts_with($type, 'emergency')    => 'emergency',
            str_starts_with($type, 'billing')      => 'billing',
            str_starts_with($type, 'document')     => 'document',
            str_starts_with($type, 'announcement') => 'announcement',
            str_starts_with($type, 'visitor')      => 'visitor',
            str_starts_with($type, 'tenant')       => 'tenant',
            default                                => 'general',
        };

        $icon = match ($uiType) {
            'reservation'  => 'pending',
            'maintenance'  => 'maintenance',
            'emergency'    => 'warn',
            'billing'      => 'billing',
            'document'     => 'nav-docu',
            'announcement' => 'nav-announ',
            'visitor'      => 'nav-visit',
            'tenant'       => 'nav-tenants',
            default        => 'bell',
        };

        return [
            'id'         => $notification->notif_id,
            'raw_type'   => $type,
            'type'       => $uiType,
            'icon'       => asset("icons/{$icon}.png"),
            'message'    => $notification->message,
            'time'       => $createdAt->format('F j, Y \a\t g:i A'),
            'ago'        => $createdAt->diffForHumans(),
            'url'        => $notification->url ?? '',
            'isRead'     => (bool) $notification->is_read,
            'tenant_id'  => $notification->tenant_id,
            'created_at' => $createdAt->toIso8601String(),
        ];
    }
}
