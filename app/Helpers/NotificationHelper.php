<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Staff;

class NotificationHelper
{
    private const FRONTDESK_ALLOWED_TYPES = [
        'announcement_new',
        'visitor_registration',
        'visitor_checkin',
        'visitor_checkout',
        'visitor_cancelled',
        'emergency_new',
        'emergency_updated',
    ];

    public static function send(int $staff_id, string $type, string $message, ?int $ref_id = null): void
    {
        Notification::makeRoomFor(1, staffId: $staff_id);

        Notification::create([
            'staff_id'   => $staff_id,
            'type'       => $type,
            'message'    => $message,
            'ref_id'     => $ref_id,
            'is_read'    => 0,
            'created_at' => now(),
        ]);

        Notification::pruneToLimit(staffId: $staff_id);
    }

    public static function sendToAll(string $type, string $message, ?int $ref_id = null): void
    {
        $allStaff = Staff::where('is_active', 1)
            ->whereIn('role', ['admin', 'secretary', 'frontdesk'])
            ->get();

        foreach ($allStaff as $staff) {
            if (!self::roleAllowsNotification($staff, $type)) {
                continue;
            }

            $prefs = [];

            if (!empty($staff->notification_preferences)) {
                $prefs = is_array($staff->notification_preferences)
                    ? $staff->notification_preferences
                    : json_decode($staff->notification_preferences, true);
            }

            $enabled = $prefs[$type] ?? true;

            if ($enabled) {
                self::send($staff->staff_id, $type, $message, $ref_id);
            }
        }
    }

    private static function roleAllowsNotification(Staff $staff, string $type): bool
    {
        if ($staff->role !== 'frontdesk') {
            return true;
        }

        return in_array($type, self::FRONTDESK_ALLOWED_TYPES, true);
    }
}
