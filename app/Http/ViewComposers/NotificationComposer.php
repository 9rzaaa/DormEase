<?php

namespace App\Http\ViewComposers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer
{
    const ADMIN_TYPES = [
        'announcement_new',
        'visitor_registration',
        'visitor_checkin',
        'visitor_checkout',
        'visitor_cancelled',
        'emergency_new',
        'emergency_updated',
        'maintenance_new',
        'maintenance_resubmission',
        'maintenance_update',
        'maintenance_updated',
        'maintenance_deleted',
        'document_request',
        'billing_overdue',
        'tenant_new',
        'tenant_activated',
        'tenant_updated',
        'tenant_reactivated',
        'tenant_deleted',
        'tenant_reserved',
        'tenant_vacation_on',
        'tenant_vacation_off',
        'reservation_overdue',
        'tenant_moveout_reminder',
    ];
    const FRONTDESK_TYPES = [
        'announcement_new',
        'visitor_registration',
        'visitor_checkin',
        'visitor_checkout',
        'visitor_cancelled',
        'emergency_new',
        'emergency_updated',
        'tenant_new',
        'tenant_activated',
        'tenant_updated',
        'tenant_reactivated',
        'tenant_deleted',
        'tenant_reserved',
        'tenant_vacation_on',
        'tenant_vacation_off',
    ];

    public static function visibleTypesFor(?string $role): array
    {
        return $role === 'frontdesk' ? self::FRONTDESK_TYPES : self::ADMIN_TYPES;
    }

    public function compose(View $view): void
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff) {
            $view->with('notifications', collect());
            $view->with('unreadNotifCount', 0);
            $view->with('staff', null);
            return;
        }

        $types = self::visibleTypesFor($staff->role);

        $notifications = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', $types)
            ->where('created_at', '>=', now()->subDays(3))
            ->orderByDesc('created_at')
            ->get();

        $unreadNotifCount = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', $types)
            ->where('is_read', 0)
            ->where('created_at', '>=', now()->subDays(3))
            ->count();

        $view->with('notifications', $notifications);
        $view->with('unreadNotifCount', $unreadNotifCount);
        $view->with('staff', $staff->fresh());
    }
}