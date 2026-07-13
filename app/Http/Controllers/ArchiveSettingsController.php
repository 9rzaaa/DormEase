<?php

namespace App\Http\Controllers;

use App\Models\ArchiveSetting;
use App\Models\ArchiveExport;
use App\Services\ArchiveExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    public function clearNow(Request $request, ArchiveExportService $exportService)
    {
        if (Auth::guard('staff')->user()?->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'module'         => 'required|string',
            'retention_days' => 'nullable|integer|min:1|max:3650',
        ]);

        if (!array_key_exists($request->module, $this->moduleLabels)) {
            return response()->json(['success' => false, 'message' => 'Unknown module.'], 422);
        }

        $setting = ArchiveSetting::where('module', $request->module)->firstOrFail();

        $retentionDays = $request->filled('retention_days')
            ? (int) $request->retention_days
            : $setting->retention_days;

        $result = $exportService->export($request->module, $retentionDays, Auth::guard('staff')->id());

        $setting->last_cleared_at = Carbon::now();
        $setting->updated_by      = Auth::guard('staff')->id();
        $setting->updated_at      = Carbon::now();
        $setting->save();

        $label = $this->moduleLabels[$request->module];

        if ($result['deleted'] === 0) {
            return response()->json([
                'success'         => true,
                'message'         => "No {$label} records older than {$retentionDays} days were found.",
                'last_cleared_at' => $setting->last_cleared_at->format('M d, Y h:i A'),
            ]);
        }

        \App\Helpers\NotificationHelper::sendToAll(
            type: 'billing_overdue',
            message: "Manual export completed for {$label}. {$result['deleted']} record(s) older than {$retentionDays} days were exported to backup storage and removed from the live table.",
        );

        return response()->json([
            'success'         => true,
            'message'         => "Exported and cleared {$result['deleted']} record(s) from {$label}.",
            'last_cleared_at' => $setting->last_cleared_at->format('M d, Y h:i A'),
        ]);
    }

    public function exports()
    {
        if (Auth::guard('staff')->user()?->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $exports = ArchiveExport::orderByDesc('created_at')->get()->map(function ($e) {
            return [
                'id'           => $e->id,
                'module'       => $e->module,
                'label'        => $this->moduleLabels[$e->module] ?? $e->module,
                'file_name'    => $e->file_name,
                'record_count' => $e->record_count,
                'date_from'    => optional($e->date_from)->format('M d, Y'),
                'date_to'      => optional($e->date_to)->format('M d, Y'),
                'created_at'   => $e->created_at->format('M d, Y h:i A'),
            ];
        });

        return response()->json(['success' => true, 'exports' => $exports]);
    }

    public function downloadExport($id)
    {
        if (Auth::guard('staff')->user()?->role !== 'admin') {
            abort(403);
        }

        $export = ArchiveExport::findOrFail($id);
        $url = Storage::disk('s3')->temporaryUrl($export->s3_key, now()->addMinutes(10));

        return redirect($url);
    }
}