<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\MaintenanceRequest;
use App\Models\EmergencyReport;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\VisitorLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $monthlyBilling = DB::table('water_billing')
            ->select(
                DB::raw('DATE_FORMAT(billing_month, "%Y-%m") as period'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN room_share ELSE 0 END) as collected'),
                DB::raw('SUM(CASE WHEN payment_status = "unpaid" THEN room_share ELSE 0 END) as unpaid')
            )
            ->where('billing_month', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy(DB::raw('DATE_FORMAT(billing_month, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(billing_month, "%Y-%m")'))
            ->get()
            ->keyBy('period');

        $chartLabels    = [];
        $chartCollected = [];
        $chartUnpaid    = [];

        for ($i = 5; $i >= 0; $i--) {
            $month  = Carbon::now()->subMonths($i);
            $key    = $month->format('Y-m');
            $found  = $monthlyBilling->get($key);

            $chartLabels[]    = $month->format('M Y');
            $chartCollected[] = $found ? (float) $found->collected : 0;
            $chartUnpaid[]    = $found ? (float) $found->unpaid    : 0;
        }

        $tenantsByFloor = Tenant::where('is_active', true)
            ->selectRaw('SUBSTRING(room_number, 1, 1) as floor, COUNT(*) as cnt')
            ->groupBy(DB::raw('SUBSTRING(room_number, 1, 1)'))
            ->orderBy(DB::raw('SUBSTRING(room_number, 1, 1)'))
            ->get();

        $maintenanceByUrgency = MaintenanceRequest::whereIn('status', ['pending', 'in-progress'])
            ->selectRaw('urgency_level, COUNT(*) as cnt')
            ->groupBy('urgency_level')
            ->orderByRaw("FIELD(urgency_level, 'urgent', 'moderate', 'low')")
            ->get();

        $visitorsByDay = VisitorLog::selectRaw('DAYNAME(arrival_time) as day, COUNT(*) as cnt')
            ->where('arrival_time', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(arrival_time)'), DB::raw('DAYNAME(arrival_time)'))
            ->orderBy(DB::raw('DATE(arrival_time)'))
            ->get()
            ->map(function ($row) {
                return [
                    'day' => $row->day,
                    'cnt' => $row->cnt,
                ];
            });

        return view('dashboard', [
            'staff'                => $staff,
            'totalTenants'         => Tenant::where('is_active', true)->count(),
            'pendingPayments'      => DB::table('water_billing')->where('payment_status', 'unpaid')->count(),
            'pendingMaintenance'   => MaintenanceRequest::whereIn('status', ['pending', 'in-progress'])->count(),
            'unresolvedReports'    => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'maintenanceRequests'  => MaintenanceRequest::with('tenant')
                ->whereIn('status', ['pending', 'in-progress'])
                ->latest('submitted_at')
                ->take(3)
                ->get(),
            'announcements'        => Announcement::latest('posted_at')->take(3)->get(),
            'notifications'        => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->latest('created_at')->take(4)->get(),
            'unreadNotifCount'     => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->count(),
            'latestEmergency'      => EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'       => EmergencyReport::latest('reported_at')->get(),
            'recentActivities'     => VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get(),
            'chartLabels'          => $chartLabels,
            'chartCollected'       => $chartCollected,
            'chartUnpaid'          => $chartUnpaid,
            'tenantsByFloor'       => $tenantsByFloor,
            'maintenanceByUrgency' => $maintenanceByUrgency,
            'visitorsByDay'        => $visitorsByDay,
        ]);
    }
}