<?php

namespace App\Http\Controllers;

use App\Models\ArchiveSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ArchiveSettingsController extends Controller
{
    private array $moduleLabels = [
        'water_billing'       => 'Water Billing',
        'visitor_logs'        => 'Visitor Logs',
        'announcements'       => 'Announcements',
        'tenant_archive'      => 'Tenant Archive',
        'maintenance_archive' => 'Maintenance Archive',
        'emergency_archive'   => 'Emergency Archive',
        'staff_archive'       => 'Staff Archive',
    ];

    public function update(Request $request)
    {
        if (Auth::guard('staff')->user()?->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'modules.*.module'           => 'required|string',
            'modules.*.is_enabled'       => 'required|boolean',
            'modules.*.retention_days'   => 'required|integer|min:30|max:3650',
            'modules.*.warn_days_before' => 'required|integer|min:1|max:30',
        ], [], [
            'modules.*.retention_days'   => 'Retention Days',
            'modules.*.warn_days_before' => 'Warn Before Days',
        ]);

        $staffId = Auth::guard('staff')->id();

        foreach ($request->modules as $row) {
            ArchiveSetting::where('module', $row['module'])->update([
                'is_enabled'       => $row['is_enabled'],
                'retention_days'   => $row['retention_days'],
                'warn_days_before' => $row['warn_days_before'],
                'updated_by'       => $staffId,
                'updated_at'       => Carbon::now(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Archive settings saved.']);
    }

    public function clearNow(Request $request)
    {
        if (Auth::guard('staff')->user()?->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'module'         => 'required|string',
            'retention_days' => 'nullable|integer|min:1|max:3650',
        ]);

        $moduleConfig = [
            'water_billing'       => ['model' => \App\Models\WaterBilling::class,            'column' => 'billing_month'],
            'visitor_logs'        => ['model' => \App\Models\VisitorLog::class,              'column' => 'arrival_time'],
            'announcements'       => ['model' => \App\Models\Announcement::class,            'column' => 'posted_at'],
            'tenant_archive'      => ['model' => \App\Models\ArchivedTenant::class,          'column' => 'archived_at'],
            'maintenance_archive' => ['model' => \App\Models\ArchivedMaintReq::class,        'column' => 'archived_at'],
            'emergency_archive'   => ['model' => \App\Models\ArchivedEmergencyReport::class, 'column' => 'archived_at'],
            'staff_archive'       => ['model' => \App\Models\ArchivedStaff::class,           'column' => 'archived_at'],
        ];

        $setting = ArchiveSetting::where('module', $request->module)->firstOrFail();
        $config  = $moduleConfig[$request->module] ?? null;

        if (!$config) {
            return response()->json(['success' => false, 'message' => 'Unknown module.'], 422);
        }

        $retentionDays = $request->filled('retention_days')
            ? (int) $request->retention_days
            : $setting->retention_days;

        $cutoff = Carbon::now()->subDays($retentionDays);
        $model  = $config['model'];
        $column = $config['column'];

        if ($request->module === 'announcements') {
            $deleted = $model::withTrashed()->where($column, '<', $cutoff)->count();
            $model::withTrashed()->where($column, '<', $cutoff)->forceDelete();
        } else {
            $deleted = $model::where($column, '<', $cutoff)->count();
            $model::where($column, '<', $cutoff)->delete();
        }

        $setting->last_cleared_at = Carbon::now();
        $setting->updated_by      = Auth::guard('staff')->id();
        $setting->updated_at      = Carbon::now();
        $setting->save();

        $label = $this->moduleLabels[$request->module] ?? $request->module;

        \App\Helpers\NotificationHelper::sendToAll(
            type: 'billing_overdue',
            message: "Manual clear completed for {$label}. {$deleted} record(s) older than {$retentionDays} days have been permanently deleted.",
        );

        return response()->json([
            'success'          => true,
            'message'          => "Cleared {$deleted} record(s) from {$label}.",
            'last_cleared_at'  => $setting->last_cleared_at->format('M d, Y h:i A'),
        ]);
    }
}