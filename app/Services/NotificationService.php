<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Staff;

class NotificationService
{
    public static function send(string $type, string $message, string $url = null): void
    {
        $staff = Staff::where('is_active', true)
            ->whereIn('role', ['admin', 'secretary', 'frontdesk'])
            ->get();

        foreach ($staff as $member) {
            if (!self::wantsNotification($member, $type)) {
                continue;
            }
            Notification::makeRoomFor(1, staffId: $member->staff_id);

            Notification::create([
                'staff_id' => $member->staff_id,
                'type'     => $type,
                'message'  => $message,
                'url'      => $url,
            ]);

            Notification::pruneToLimit(staffId: $member->staff_id);
        }
    }

    public static function sendTo(int $staffId, string $type, string $message, string $url = null): void
    {
        Notification::makeRoomFor(1, staffId: $staffId);

        Notification::create([
            'staff_id' => $staffId,
            'type'     => $type,
            'message'  => $message,
            'url'      => $url,
        ]);

        Notification::pruneToLimit(staffId: $staffId);
    }

    private static function wantsNotification(Staff $member, string $type): bool
    {
        $prefs = $member->notification_preferences;

        $adminDefaults = [
            'maintenance_new'  => true,
            'maintenance_resubmission' => true,
            'emergency_new'    => true,
            'visitor_checkin'  => false,
            'visitor_checkout' => false,
            'visitor_cancelled' => true,
            'billing_overdue'  => true,
            'document_request' => true,
            'announcement_new' => false,
        ];

        $frontdeskDefaults = [
            'emergency_new'    => true,
            'visitor_registration' => true,
            'visitor_checkin'  => true,
            'visitor_checkout' => true,
            'visitor_cancelled' => true,
            'announcement_new' => true,
        ];

        $isFrontdeskRole = $member->role === 'frontdesk';
        $defaults = $isFrontdeskRole ? $frontdeskDefaults : $adminDefaults;

        if (empty($prefs)) {
            return $defaults[$type] ?? false;
        }

        $map    = is_array($prefs) ? $prefs : json_decode($prefs, true);
        $merged = array_merge($defaults, $map ?? []);

        if ($isFrontdeskRole && !array_key_exists($type, $frontdeskDefaults)) {
            return false;
        }

        return !empty($merged[$type]);
    }
}
