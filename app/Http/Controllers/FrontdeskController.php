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
            'announcements'     => Announcement::whereIn('status', ['active', 'scheduled'])->latest('posted_at')->take(3)->get(),
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
    public function dashboardData()
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

        $latestEmergency = EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first();
        $allEmergencies  = EmergencyReport::latest('reported_at')->take(10)->get();

        $emergencyItems = $allEmergencies->map(function ($e) {
            return [
                'location'       => $e->location ?? 'Unknown Location',
                'emergency_type' => $e->emergency_type,
                'status'         => $e->status,
                'created_at'     => \Carbon\Carbon::parse($e->created_at)->format('F d, Y · g:i A'),
                'is_resolved'    => strtolower($e->status) === 'resolved',
            ];
        });

        $announcements = Announcement::whereIn('status', ['active', 'scheduled'])
            ->latest('posted_at')->take(3)->get()
            ->map(function ($ann) {
                return [
                    'title'      => $ann->title,
                    'content'    => $ann->content,
                    'priority'   => $ann->priority ?? 'low',
                    'status'     => $ann->status ?? 'active',
                    'posted_at'  => \Carbon\Carbon::parse($ann->posted_at)->format('F d, Y · g:i A'),
                    'attachment' => $ann->attachment ?? '',
                ];
            });

        $recentActivities = VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get()
            ->map(function ($log) {
                return [
                    'visitor_name'   => $log->visitor_name,
                    'status'         => $log->departure_time ? 'Checked Out' : 'Checked In',
                    'tenant'         => $log->tenant ? $log->tenant->first_name . ' ' . $log->tenant->last_name : 'N/A',
                    'arrival'        => \Carbon\Carbon::parse($log->arrival_time)->format('F d, Y, g:i A'),
                    'departure'      => $log->departure_time ? \Carbon\Carbon::parse($log->departure_time)->format('F d, Y, g:i A') : '',
                    'departure_time' => $log->departure_time,
                ];
            });

        $notifications = Notification::where('staff_id', $staff->staff_id)
            ->latest()->take(6)->get()
            ->map(function ($n) {
                $notifTypeLabel = match($n->type ?? '') {
                    'visitor_registration', 'visitor_checkin', 'visitor_checkout', 'visitor_cancelled' => 'visitor',
                    'emergency_new'    => 'emergency',
                    'announcement_new' => 'announcement',
                    default            => 'general',
                };
                $notifIcon = match($n->type ?? '') {
                    'visitor_registration', 'visitor_checkin', 'visitor_checkout', 'visitor_cancelled' => 'nav-visit',
                    'emergency_new'    => 'warn',
                    'announcement_new' => 'nav-announ',
                    default            => 'bell',
                };
                return [
                    'id'      => $n->notif_id,
                    'type'    => $notifTypeLabel,
                    'icon'    => $notifIcon,
                    'message' => $n->message,
                    'time'    => \Carbon\Carbon::parse($n->created_at)->format('F j, Y \a\t g:i A'),
                    'ago'     => \Carbon\Carbon::parse($n->created_at)->diffForHumans(),
                    'url'     => $n->url ?? '',
                    'isRead'  => (bool) $n->is_read,
                ];
            });

        $tenantsByFloor = Tenant::where('status', 'active')
            ->whereNotNull('floor')
            ->selectRaw('floor, COUNT(*) as cnt')
            ->groupBy('floor')
            ->orderBy('floor')
            ->get()
            ->map(fn($row) => ['floor' => $row->floor, 'cnt' => (int) $row->cnt])
            ->values();

        $emergencyByType = EmergencyReport::selectRaw('status, count(*) as cnt')
            ->groupBy('status')
            ->get()
            ->map(fn($row) => ['status' => $row->status, 'cnt' => (int) $row->cnt])
            ->values();

        return response()->json([
            'totalTenants'      => Tenant::where('status', 'active')->count(),
            'occupiedUnits'     => Tenant::where('status', 'active')->whereNotNull('room_number')->distinct('room_number')->count('room_number'),
            'totalUnits'        => \App\Models\Room::count() ?: 25,
            'visitorsToday'     => VisitorLog::whereDate('arrival_time', Carbon::today())->count(),
            'activeEmergencies' => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'latestEmergency'   => $latestEmergency ? [
                'location'       => $latestEmergency->location ?? 'Unknown Location',
                'emergency_type' => $latestEmergency->emergency_type,
                'status'         => $latestEmergency->status,
            ] : null,
            'allEmergencies'    => $emergencyItems,
            'announcements'     => $announcements,
            'recentActivities'  => $recentActivities,
            'notifications'     => $notifications,
            'chartLabels'       => $chartLabels,
            'chartVisitors'     => $chartVisitors,
            'tenantsByFloor'    => $tenantsByFloor,
            'emergencyByType'   => $emergencyByType,
            'unreadNotifCount'  => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->count(),
        ]);
    }
}