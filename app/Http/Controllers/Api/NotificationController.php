<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('tenant_id', $request->user()->tenant_id)
            ->orderByDesc('created_at')
            ->paginate(30);

        return response()->json($notifications);
    }

    public function markRead(Request $request, int $id)
    {
        Notification::where('tenant_id', $request->user()->tenant_id)
            ->where('notif_id', $id)
            ->update(['is_read' => 1]);

        return response()->json(['ok' => true]);
    }

    public function markAllRead(Request $request)
    {
        Notification::where('tenant_id', $request->user()->tenant_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['ok' => true]);
    }
}
