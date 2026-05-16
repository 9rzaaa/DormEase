<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\EmergencyReport;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\VisitorLog;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        return view('dashboard', [
            'staff'               => $staff,
            'totalTenants'        => Tenant::where('is_active', true)->count(),
            'pendingPayments'     => Payment::where('status', 'pending')->count(),
            'pendingMaintenance'  => MaintenanceRequest::whereIn('status', ['pending', 'in_progress'])->count(),
            'unresolvedReports'   => EmergencyReport::where('status', '!=', 'resolved')->count(),
            'maintenanceRequests' => MaintenanceRequest::with('tenant')
                ->whereIn('status', ['pending', 'in_progress'])
                ->latest('submitted_at')
                ->take(3)
                ->get(),
            'announcements'       => Announcement::latest('posted_at')->take(3)->get(),
            'notifications'       => Notification::where('is_read', false)->latest('created_at')->take(4)->get(),
            'unreadNotifCount'    => Notification::where('is_read', false)->count(),
            'latestEmergency'     => EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'      => EmergencyReport::latest('reported_at')->get(),
            'recentActivities'    => VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get(),
        ]);
    }
}
