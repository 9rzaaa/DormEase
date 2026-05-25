<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Staff;

class NotificationService
{
    public static function send(string $type, string $message, string $url = null): void
    {
        $staff = Staff::where('is_active', true)->get();

        foreach ($staff as $member) {
            if (!self::wantsNotification($member, $type)) {
                continue;
            }

            Notification::create([
                'staff_id' => $member->staff_id,
                'type'     => $type,
                'message'  => $message,
                'url'      => $url,
            ]);
        }
    }

    public static function sendTo(int $staffId, string $type, string $message, string $url = null): void
    {
        Notification::create([
            'staff_id' => $staffId,
            'type'     => $type,
            'message'  => $message,
            'url'      => $url,
        ]);
    }

    private static function wantsNotification(Staff $member, string $type): bool
    {
        $prefs = $member->notification_preferences;

        if (empty($prefs)) {
            return true;
        }

        $map = is_array($prefs) ? $prefs : json_decode($prefs, true);

        $defaults = [
            'maintenance_new'  => true,
            'emergency_new'    => true,
            'visitor_checkin'  => false,
            'visitor_checkout' => false,
            'billing_overdue'  => true,
            'document_request' => true,
            'announcement_new' => false,
        ];

        $merged = array_merge($defaults, $map ?? []);

        return !empty($merged[$type]);
    }
}