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

        $query = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', NotificationComposer::visibleTypesFor($staff->role));

        if ($request->filled('type')) {
            $type = $request->type;
            if ($type === 'reservation') {
                $query->where('type', 'tenant_reserved');
            } else {
                $query->where('type', 'like', $type . '%');
            }
        }

        $notifications = $query->orderByDesc('created_at')->paginate(20);

        if ($staff->role === 'frontdesk') {
            return view('fdnotifications', compact('notifications'));
        }

        return view('notifications', compact('notifications'));
    }

    public function live(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $query = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', NotificationComposer::visibleTypesFor($staff->role))
            ->where('created_at', '>=', now()->subDays(3));

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

        $panicReports = EmergencyReport::where('is_panic_alert', true)
            ->where('status', 'active')
            ->orderByDesc('reported_at')
            ->get(['report_id', 'emergency_type', 'location', 'reported_at'])
            ->map(fn ($report) => [
                'report_id'   => $report->report_id,
                'type'        => $report->emergency_type,
                'location'    => $report->location,
                'reported_at' => $report->reported_at?->format('Y-m-d H:i:s'),
            ])
            ->values();

        $reports = EmergencyReport::whereIn('urgency_level', ['critical', 'urgent'])
            ->where('status', 'active')
            ->orderByDesc('reported_at')
            ->get()
            ->map(fn ($report) => [
                'report_id'      => $report->report_id,
                'urgency_level'  => $report->urgency_level,
                'is_panic_alert' => $report->is_panic_alert,
                'emergency_type' => $report->emergency_type,
                'location'       => $report->location,
                'reported_at'    => $report->reported_at?->format('Y-m-d H:i:s'),
            ])
            ->values();

        return response()->json(array_merge($payload, [
            'panic' => [
                'has_panic' => $panicReports->isNotEmpty(),
                'reports'   => $panicReports,
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
            $type === 'reservation_overdue'        => 'reservation_overdue',
            str_starts_with($type, 'maintenance')  => 'maintenance',
            str_starts_with($type, 'emergency')    => 'emergency',
            str_starts_with($type, 'billing')      => 'billing',
            str_starts_with($type, 'document')     => 'document',
            str_starts_with($type, 'announcement') => 'announcement',
            str_starts_with($type, 'visitor')      => 'visitor',
            $type === 'tenant_moveout_reminder'    => 'moveout_reminder',
            str_starts_with($type, 'tenant')       => 'tenant',
            default                                => 'general',
        };

        $icon = match ($uiType) {
            'reservation'         => 'pending',
            'reservation_overdue' => 'pending',
            'maintenance'         => 'maintenance',
            'emergency'           => 'warn',
            'billing'             => 'billing',
            'document'            => 'nav-docu',
            'announcement'        => 'nav-announ',
            'visitor'             => 'nav-visit',
            'moveout_reminder'    => 'pending',
            'tenant'              => 'nav-tenants',
            default               => 'bell',
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
