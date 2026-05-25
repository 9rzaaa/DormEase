<?php
namespace App\Helpers;
use App\Models\Notification;

class NotificationHelper
{
    public static function send(int $staff_id, string $type, string $message, int $ref_id = null)
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
}