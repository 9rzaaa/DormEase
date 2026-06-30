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
use App\Http\ViewComposers\NotificationComposer;
use Carbon\Carbon;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $activeTenantIds = Tenant::whereIn('status', ['active', 'pending'])->pluck('tenant_id');

    $monthlyBilling = DB::table('water_billing')
        ->select(
            DB::raw('DATE_FORMAT(billing_month, "%Y-%m") as period'),
            DB::raw('SUM(CASE WHEN payment_status = "paid" THEN room_share ELSE 0 END) as collected'),
            DB::raw('SUM(CASE WHEN payment_status != "paid" THEN room_share ELSE 0 END) as unpaid')
        )
        ->whereIn('tenant_id', $activeTenantIds)
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

        $tenantsByFloor = Tenant::whereIn('status', ['active', 'pending'])
            ->selectRaw('SUBSTRING(room_number, 1, 1) as floor, COUNT(*) as cnt')
            ->groupBy(DB::raw('SUBSTRING(room_number, 1, 1)'))
            ->orderBy(DB::raw('SUBSTRING(room_number, 1, 1)'))
            ->get();

        $maintenanceByUrgency = MaintenanceRequest::whereIn('status', ['pending', 'in-progress'])
            ->selectRaw('urgency_level, COUNT(*) as cnt')
            ->groupBy('urgency_level')
            ->orderByRaw("FIELD(urgency_level, 'urgent', 'moderate', 'low')")
            ->get();

        $visitorsByDay = VisitorLog::selectRaw('DATE(arrival_time) as date_key, DAYNAME(arrival_time) as day, COUNT(*) as cnt')
            ->where('arrival_time', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(arrival_time)'), DB::raw('DAYNAME(arrival_time)'))
            ->orderBy(DB::raw('DATE(arrival_time)'))
            ->get()
            ->map(function ($row) {
                return [
                    'day' => $row->day . ' ' . \Carbon\Carbon::parse($row->date_key)->format('d'),
                    'cnt' => $row->cnt,
                ];
            });

        $now = now();
        $currentTime = Carbon::createFromTimeString($now->format('H:i:s'));

        $nowTime = $now->format('H:i:s');

        $expectedAbsent = Staff::where('is_active', true)
            ->whereNotNull('shift_start')
            ->whereNotNull('shift_end')
            ->where('duty_status', '!=', 'on_duty')
            ->where(function ($q) use ($nowTime) {
                $q->where(function ($q2) use ($nowTime) {
                    $q2->whereRaw('shift_end > shift_start')
                       ->whereRaw('? BETWEEN shift_start AND shift_end', [$nowTime]);
                })->orWhere(function ($q2) use ($nowTime) {
                    $q2->whereRaw('shift_end < shift_start')
                       ->where(function ($q3) use ($nowTime) {
                           $q3->whereRaw('? >= shift_start', [$nowTime])
                              ->orWhereRaw('? < shift_end', [$nowTime]);
                       });
                });
            })
            ->count();

        return view('dashboard', [
            'staff'                => $staff,
            'totalTenants'         => Tenant::whereIn('status', ['active', 'pending'])->count(),
            'pendingPayments'      => DB::table('water_billing')->whereIn('tenant_id', $activeTenantIds)->where('payment_status', '!=', 'paid')->count(),
            'pendingMaintenance'   => MaintenanceRequest::whereIn('status', ['pending', 'in-progress'])->count(),
            'unresolvedReports'    => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'maintenanceRequests'  => MaintenanceRequest::with('tenant')
                ->whereIn('status', ['pending', 'in-progress'])
                ->orderBy('submitted_at', 'desc')
                ->take(3)
                ->get(),
            'announcements'        => Announcement::latest('posted_at')->take(3)->get(),
            'notifications'        => Notification::where('staff_id', $staff->staff_id)
                ->whereIn('type', NotificationComposer::visibleTypesFor($staff->role))
                ->latest('created_at')
                ->take(4)
                ->get(),
            'unreadNotifCount'     => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->count(),
            'latestEmergency'      => EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'       => EmergencyReport::latest('reported_at')->take(50)->get(),
            'recentActivities'     => VisitorLog::with('tenant')->whereNotNull('arrival_time')->latest('arrival_time')->take(5)->get(),
            'chartLabels'          => $chartLabels,
            'chartCollected'       => $chartCollected,
            'chartUnpaid'          => $chartUnpaid,
            'tenantsByFloor'       => $tenantsByFloor,
            'maintenanceByUrgency' => $maintenanceByUrgency,
            'visitorsByDay'        => $visitorsByDay,
            'expectedAbsent'       => $expectedAbsent,
        ]);
    }
}
