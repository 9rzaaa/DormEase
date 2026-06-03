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
            Notification::makeRoomFor();

            Notification::create([
                'staff_id' => $member->staff_id,
                'type'     => $type,
                'message'  => $message,
                'url'      => $url,
            ]);

            Notification::pruneToLimit();
        }
    }

    public static function sendTo(int $staffId, string $type, string $message, string $url = null): void
    {
        Notification::makeRoomFor();

        Notification::create([
            'staff_id' => $staffId,
            'type'     => $type,
            'message'  => $message,
            'url'      => $url,
        ]);

        Notification::pruneToLimit();
    }

    private static function wantsNotification(Staff $member, string $type): bool
    {
        $prefs = $member->notification_preferences;

        $adminDefaults = [
            'maintenance_new'  => true,
            'emergency_new'    => true,
            'visitor_checkin'  => false,
            'visitor_checkout' => false,
            'billing_overdue'  => true,
            'document_request' => true,
            'announcement_new' => false,
        ];

        $frontdeskDefaults = [
            'emergency_new'    => true,
            'visitor_registration' => true,
            'visitor_checkin'  => true,
            'visitor_checkout' => true,
            'announcement_new' => true,
        ];

        $defaults = $member->role === 'frontdesk' ? $frontdeskDefaults : $adminDefaults;

        if (empty($prefs)) {
            return $defaults[$type] ?? false;
        }

        $map    = is_array($prefs) ? $prefs : json_decode($prefs, true);
        $merged = array_merge($defaults, $map ?? []);

        if ($member->role === 'frontdesk' && !array_key_exists($type, $frontdeskDefaults)) {
            return false;
        }

        return !empty($merged[$type]);
    }
}
