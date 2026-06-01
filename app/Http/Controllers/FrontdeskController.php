<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use App\Models\EmergencyReport;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\VisitorLog;
use Carbon\Carbon;

class FrontdeskController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $chartLabels = [];
        $chartVisitors = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $chartLabels[] = $day->format('D');
            $chartVisitors[] = VisitorLog::whereDate('arrival_time', $day)->count();
        }

        $visitorsByHour = collect(range(0, 23))->map(function ($hour) {
            return [
                'hour' => $hour,
                'cnt'  => VisitorLog::whereDate('arrival_time', Carbon::today())
                    ->whereRaw('HOUR(arrival_time) = ?', [$hour])
                    ->count(),
            ];
        })->filter(fn($h) => $h['cnt'] > 0)->values();

        $emergencyByType = EmergencyReport::selectRaw('status, count(*) as cnt')
        ->groupBy('status')
        ->get();

        $tenantsByFloor = Tenant::where('is_active', true)
            ->whereNotNull('room_number')
            ->get()
            ->groupBy(fn($t) => substr($t->room_number, 0, 1))
            ->map(fn($group, $floor) => ['floor' => $floor, 'cnt' => $group->count()])
            ->values();

        return view('frontdeskdb', [
            'staff'             => $staff,
            'totalTenants'      => Tenant::where('is_active', true)->count(),
            'occupiedUnits'     => Tenant::whereNotNull('room_number')->where('is_active', true)->count(),
            'totalUnits'        => 25,
            'visitorsToday'     => VisitorLog::whereDate('arrival_time', Carbon::today())->count(),
            'activeEmergencies' => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'latestEmergency'   => EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'    => EmergencyReport::latest('reported_at')->take(10)->get(),
            'announcements'     => Announcement::latest('posted_at')->take(3)->get(),
            'unreadNotifCount'  => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->count(),
            'recentActivities'  => VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get(),
            'notifications'     => Notification::where('staff_id', $staff->staff_id)->latest()->take(8)->get(),
            'chartLabels'       => $chartLabels,
            'chartVisitors'     => $chartVisitors,
            'visitorsByHour'    => $visitorsByHour,
            'emergencyByType'   => $emergencyByType,
            'tenantsByFloor'    => $tenantsByFloor,
        ]);
    }
}