<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Staff;

class NotificationHelper
{
    public static function send(int $staff_id, string $type, string $message, ?int $ref_id = null): void
    {
        Notification::create([
            'staff_id'   => $staff_id,
            'type'       => $type,
            'message'    => $message,
            'ref_id'     => $ref_id,
            'is_read'    => 0,
            'created_at' => now(),
        ]);
    }

    public static function sendToAll(string $type, string $message, ?int $ref_id = null): void
    {
        $allStaff = Staff::where('is_active', 1)->where('role', 'admin')->get();

        foreach ($allStaff as $staff) {
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
}