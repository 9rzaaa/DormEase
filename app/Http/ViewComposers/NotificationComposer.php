<?php
namespace App\Http\ViewComposers;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class NotificationComposer
{
    public function compose(View $view): void
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff) {
            $view->with('notifications', collect());
            $view->with('unreadNotifCount', 0);
            return;
        }
        $notifications = Notification::where('staff_id', $staff->staff_id)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
        $unreadNotifCount = Notification::where('staff_id', $staff->staff_id)
            ->where('is_read', 0)
            ->count();
        $view->with('notifications', $notifications);
        $view->with('unreadNotifCount', $unreadNotifCount);
    }
}