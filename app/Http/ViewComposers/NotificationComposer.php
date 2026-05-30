<?php

namespace App\Http\ViewComposers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer
{
    const FRONTDESK_TYPES = [
        'announcement_new',
        'visitor_checkin',
        'visitor_checkout',
        'emergency_new',
        'emergency_updated',
        'maintenance_new',
        'maintenance_updated',
    ];

    public function compose(View $view): void
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff) {
            $view->with('notifications', collect());
            $view->with('unreadNotifCount', 0);
            $view->with('staff', null);
            return;
        }

        $notifications = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', self::FRONTDESK_TYPES)
            ->orderByDesc('created_at')
            ->get();

        $unreadNotifCount = Notification::where('staff_id', $staff->staff_id)
            ->whereIn('type', self::FRONTDESK_TYPES)
            ->where('is_read', 0)
            ->count();

        $view->with('notifications', $notifications);
        $view->with('unreadNotifCount', $unreadNotifCount);
        $view->with('staff', $staff->fresh());
    }
}
