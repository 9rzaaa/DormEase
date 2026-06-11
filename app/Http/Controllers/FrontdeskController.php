<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use App\Models\EmergencyReport;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FrontdeskController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $visitorRows = VisitorLog::selectRaw('DATE(arrival_time) as date_key, COUNT(*) as cnt')
            ->where('arrival_time', '>=', Carbon::today()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(arrival_time)'))
            ->orderBy(DB::raw('DATE(arrival_time)'))
            ->get()
            ->keyBy('date_key');

        $chartLabels   = [];
        $chartVisitors = [];
        for ($i = 6; $i >= 0; $i--) {
            $day             = Carbon::today()->subDays($i);
            $key             = $day->format('Y-m-d');
            $chartLabels[]   = $day->format('D d');
            $chartVisitors[] = $visitorRows->has($key) ? (int) $visitorRows->get($key)->cnt : 0;
        }

        $visitorsByHour = VisitorLog::selectRaw('HOUR(arrival_time) as hour, COUNT(*) as cnt')
            ->whereDate('arrival_time', Carbon::today())
            ->groupBy(DB::raw('HOUR(arrival_time)'))
            ->orderBy(DB::raw('HOUR(arrival_time)'))
            ->get()
            ->map(fn($row) => ['hour' => (int) $row->hour, 'cnt' => (int) $row->cnt])
            ->values();

        $emergencyByType = EmergencyReport::selectRaw('status, count(*) as cnt')
        ->groupBy('status')
        ->get();

        $tenantsByFloor = Tenant::where('status', 'active')
            ->whereNotNull('floor')
            ->selectRaw('floor, COUNT(*) as cnt')
            ->groupBy('floor')
            ->orderBy('floor')
            ->get()
            ->map(fn($row) => ['floor' => $row->floor, 'cnt' => (int) $row->cnt])
            ->values();

        return view('frontdeskdb', [
            'staff'             => $staff,
            'totalTenants'      => Tenant::where('status', 'active')->count(),
            'occupiedUnits'     => Tenant::where('status', 'active')->whereNotNull('room_number')->distinct('room_number')->count('room_number'),
            'totalUnits'        => \App\Models\Room::count() ?: 25,
            'visitorsToday'     => VisitorLog::whereDate('arrival_time', Carbon::today())->count(),
            'activeEmergencies' => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'latestEmergency'   => EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'    => EmergencyReport::latest('reported_at')->take(10)->get(),
            'announcements'     => Announcement::latest('posted_at')->take(3)->get(),
            'unreadNotifCount'  => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->count(),
            'recentActivities'  => VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get(),
            'notifications'     => Notification::where('staff_id', $staff->staff_id)->latest()->take(6)->get(),
            'chartLabels'       => $chartLabels,
            'chartVisitors'     => $chartVisitors,
            'visitorsByHour'    => $visitorsByHour,
            'emergencyByType'   => $emergencyByType,
            'tenantsByFloor'    => $tenantsByFloor,
        ]);
    }
}