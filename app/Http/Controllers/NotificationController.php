<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $notifications = Notification::where('staff_id', $staff->staff_id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($notifications);
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

    public function markAllRead()
    {
        $staff = Auth::guard('staff')->user();

        Notification::where('staff_id', $staff->staff_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

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
}