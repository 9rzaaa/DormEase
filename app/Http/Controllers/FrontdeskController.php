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
        ]);
    }
}
