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
                DB::raw('MONTH(billing_month) as month'),
                DB::raw('YEAR(billing_month) as year'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN room_share ELSE 0 END) as collected'),
                DB::raw('SUM(CASE WHEN payment_status = "unpaid" THEN room_share ELSE 0 END) as unpaid')
            )
            ->where('billing_month', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $chartLabels    = [];
        $chartCollected = [];
        $chartUnpaid    = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $found = $monthlyBilling->first(function ($row) use ($month) {
                return (int)$row->month === (int)$month->month
                    && (int)$row->year  === (int)$month->year;
            });

            $chartLabels[]    = $month->format('M Y');
            $chartCollected[] = $found ? (float)$found->collected : 0;
            $chartUnpaid[]    = $found ? (float)$found->unpaid    : 0;
        }

        return view('dashboard', [
            'staff'               => $staff,
            'totalTenants'        => Tenant::where('is_active', true)->count(),
            'pendingPayments'     => DB::table('water_billing')->where('payment_status', 'unpaid')->count(),
            'pendingMaintenance'  => MaintenanceRequest::whereIn('status', ['pending', 'in-progress'])->count(),
            'unresolvedReports'   => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'maintenanceRequests' => MaintenanceRequest::with('tenant')
                ->whereIn('status', ['pending', 'in-progress'])
                ->latest('submitted_at')
                ->take(3)
                ->get(),
            'announcements'       => Announcement::latest('posted_at')->take(3)->get(),
            'notifications'    => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->latest('created_at')->take(4)->get(),
            'unreadNotifCount' => Notification::where('staff_id', $staff->staff_id)->where('is_read', false)->count(),
            'latestEmergency'     => EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'      => EmergencyReport::latest('reported_at')->get(),
            'recentActivities'    => VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get(),
            'chartLabels'         => $chartLabels,
            'chartCollected'      => $chartCollected,
            'chartUnpaid'         => $chartUnpaid,
        ]);
    }
}
