<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private function formatNotif(Notification $n): array
    {
        return [
            'notif_id'   => $n->notif_id,
            'type'       => $n->type,
            'message'    => $n->message,
            'ref_id'     => $n->ref_id,
            'is_read'    => $n->is_read,
            'tenant_id'  => $n->tenant_id,
            'created_at' => $n->created_at
                ? Carbon::parse($n->created_at, 'Asia/Manila')
                ->toIso8601String()
                : null,
        ];
    }

    public function index(Request $request)
    {
        $paginator = Notification::where('tenant_id', $request->user()->tenant_id)
            ->orderByDesc('created_at')
            ->paginate(30);

        $paginator->getCollection()->transform(
            fn(Notification $n) => $this->formatNotif($n)
        );

        return response()->json($paginator);
    }

    public function unreadCount(Request $request)
    {
        $count = Notification::where('tenant_id', $request->user()->tenant_id)
            ->where('is_read', 0)
            ->count();

        return response()->json(['count' => $count]);
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
