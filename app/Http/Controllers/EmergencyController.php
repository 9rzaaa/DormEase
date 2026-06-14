<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\ArchivedEmergencyReport;
use App\Models\EmergencyReport;
use App\Models\Tenant;
use App\Services\TenantPushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyController extends Controller
{
    public function adminIndex()
    {
        $reports = $this->mapReports(EmergencyReport::where('status', 'active')->orderBy('reported_at', 'desc')->get());
        $totalCount    = $this->mapReports(EmergencyReport::orderBy('reported_at', 'desc')->get())->count();
        $criticalCount = EmergencyReport::where('status', 'active')->whereIn('urgency_level', ['critical', 'urgent'])->count();
        $resolvedCount = ArchivedEmergencyReport::where('archive_type', 'resolved')->count();
        $panicCount    = EmergencyReport::where('is_panic_alert', true)->where('status', 'active')->count();
        $closedArchive   = $this->archiveCollection('closed');
        $resolvedArchive = $this->archiveCollection('resolved');
        $deletedArchive  = $this->archiveCollection('deleted');

        return view('emergency', compact(
            'reports',
            'totalCount',
            'criticalCount',
            'resolvedCount',
            'panicCount',
            'closedArchive',
            'resolvedArchive',
            'deletedArchive'
        ));
    }

    public function frontdeskIndex()
    {
        $staff = Auth::guard('staff')->user();
        $reports = $this->mapReports(EmergencyReport::where('status', 'active')->orderBy('reported_at', 'desc')->get());
        $totalCount    = $this->mapReports(EmergencyReport::orderBy('reported_at', 'desc')->get())->count();
        $criticalCount = EmergencyReport::where('status', 'active')->whereIn('urgency_level', ['critical', 'urgent'])->count();
        $panicCount = EmergencyReport::where('is_panic_alert', true)->where('status', 'active')->count();
        $closedArchive   = $this->archiveCollection('closed');
        $resolvedArchive = $this->archiveCollection('resolved');
        $deletedArchive  = $this->archiveCollection('deleted');

        return view('fdemergency', compact(
            'staff',
            'reports',
            'totalCount',
            'criticalCount',
            'panicCount',
            'closedArchive',
            'resolvedArchive',
            'deletedArchive'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'emergency_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'tenant_id' => 'nullable|integer|exists:tenants,tenant_id',
            'is_panic_alert' => 'nullable|boolean',
            'urgency_level' => 'nullable|in:moderate,urgent,critical',
        ]);

        $report = EmergencyReport::create([
            'tenant_id' => $validated['tenant_id'] ?? null,
            'is_panic_alert' => $request->boolean('is_panic_alert'),
            'emergency_type' => $validated['emergency_type'],
            'urgency_level' => $validated['urgency_level'] ?? null,
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'],
            'status' => 'active',
            'reported_at' => now(),
        ]);

        NotificationHelper::sendToAll(
            type: 'emergency_new',
            message: "Emergency reported: {$report->emergency_type} at {$report->location}.",
            ref_id: $report->report_id,
        );

        return redirect()->route('frontdesk.emergency')
            ->with('success', 'Emergency report filed successfully.');
    }

    public function update(Request $request, $id)
    {
        $report = EmergencyReport::findOrFail($id);
        $validated = $request->validate([
            'status'      => 'required|in:active,resolved,closed',
            'admin_notes' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
        ]);

        $report->update([
            'admin_notes' => $validated['admin_notes'] ?? null,
            'location'    => (!empty($validated['location'])) ? $validated['location'] : $report->location,
        ]);

        if ($validated['status'] === 'closed') {
            if ($report->tenant_id) {
                app(TenantPushNotificationService::class)->sendToTenant(
                    tenant: $report->tenant_id,
                    type: 'emergency',
                    title: 'Emergency Report Closed',
                    body: "Your emergency report ({$report->emergency_type}) has been closed.",
                    refId: $report->report_id,
                    route: '/tenant/emergency',
                );
            }
            $this->archiveReport($report, 'closed');
            $report->delete();
            return response()->json(['success' => true, 'archived' => true]);
        }

        if ($validated['status'] === 'resolved') {
            if ($report->tenant_id) {
                app(TenantPushNotificationService::class)->sendToTenant(
                    tenant: $report->tenant_id,
                    type: 'emergency',
                    title: 'Emergency Report Resolved',
                    body: "Your emergency report ({$report->emergency_type}) has been resolved.",
                    refId: $report->report_id,
                    route: '/tenant/emergency',
                );
            }
            NotificationHelper::sendToAll(
                type: 'emergency_new',
                message: "Emergency report #{$report->report_id} has been resolved.",
                ref_id: $report->report_id,
            );
            $report->resolved_at = now();
            $report->save();
            $report->resolved_at = now();
            $report->save();
            $this->archiveReport($report, 'resolved');
            $report->delete();
            return response()->json(['success' => true, 'archived' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $report = EmergencyReport::findOrFail($id);
        $this->archiveReport($report, 'deleted');
        $report->delete();

        return response()->json(['success' => true]);
    }

    private function formatArchive(ArchivedEmergencyReport $report): array
    {
        return [
            'id' => $report->original_id,
            'archive_id' => $report->id,
            'archived_by_staff_id' => $report->archived_by_staff_id,
            'archived_by_name' => $report->archived_by_name,
            'archived_by_role' => $report->archived_by_role,
            'archived_by_label' => $this->archivedByLabel($report->archived_by_role, $report->archived_by_name),
            'tenant_name' => $report->tenant_name,
            'room_number' => $report->room_number,
            'is_panic_alert' => $report->is_panic_alert,
            'emergency_type' => $report->emergency_type ?? '-',
            'urgency_level' => $report->urgency_level ?? 'moderate',
            'description' => $report->description ?? '-',
            'location' => $report->location ?? '-',
            'status' => $this->normalizeStatus($report->status),
            'admin_notes' => $report->admin_notes ?? '',
            'reported_at' => $report->reported_at ? $report->reported_at->format('Y-m-d H:i:s') : null,
            'resolved_at' => $report->resolved_at ? $report->resolved_at->format('Y-m-d H:i:s') : null,
            'archived_at' => $report->archived_at ? $report->archived_at->format('Y-m-d H:i:s') : null,
        ];
    }

    private function archiveCollection(string $type)
    {
        return ArchivedEmergencyReport::where('archive_type', $type)
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($report) => $this->formatArchive($report));
    }

    private function archiveReport(EmergencyReport $report, string $type): void
    {
        $tenant = $report->tenant;
        $tenantName = $tenant
            ? trim($tenant->first_name . ' ' . $tenant->last_name)
            : 'Front Desk';
        $staff = Auth::guard('staff')->user() ?? Auth::guard('admin')->user();

        ArchivedEmergencyReport::create([
            'original_id' => $report->report_id,
            'archive_type' => $type,
            'archived_by_staff_id' => $staff?->staff_id,
            'archived_by_name' => $staff ? trim($staff->first_name . ' ' . $staff->last_name) : null,
            'archived_by_role' => $staff?->role ?? 'admin',
            'tenant_id' => $report->tenant_id,
            'tenant_name' => $tenantName,
            'room_number' => $tenant->room_number ?? '-',
            'is_panic_alert' => $report->is_panic_alert,
            'emergency_type' => $report->emergency_type,
            'urgency_level' => $report->urgency_level,
            'description' => $report->description,
            'location' => $report->location,
            'status' => $this->normalizeStatus($report->status),
            'admin_notes' => $report->admin_notes,
            'reported_at' => $report->reported_at,
            'resolved_at' => $report->resolved_at,
            'archived_at' => now(),
        ]);
    }

    private function normalizeStatus(?string $status): string
    {
        return match ($status) {
            'resolved' => 'resolved',
            'closed' => 'closed',
            default => 'active',
        };
    }

    private function archivedByLabel(?string $role, ?string $name): string
    {
        $roleLabel = match ($role) {
            'admin' => 'Admin',
            'frontdesk' => 'Front Desk',
            default => $role ? ucfirst($role) : 'Unknown',
        };

        return $name ? "{$roleLabel} - {$name}" : $roleLabel;
    }

    private function mapReports($reports)
    {
        $tenantIds = $reports->pluck('tenant_id')->filter()->unique();
        $tenantMap = Tenant::whereIn('tenant_id', $tenantIds)->get()->keyBy('tenant_id');

        return $reports->map(function ($report) use ($tenantMap) {
            $tenant = $tenantMap->get($report->tenant_id);

            if ($tenant) {
                $tenantName = trim($tenant->first_name . ' ' . $tenant->last_name);
                $roomNumber = $tenant->room_number ?? '-';
            } elseif (!$report->tenant_id) {
                $tenantName = 'Front Desk';
                $roomNumber = '-';
            } else {
                $tenantName = '-';
                $roomNumber = '-';
            }

            return [
                'report_id' => $report->report_id,
                'tenant_id' => $report->tenant_id,
                'tenant_name' => $tenantName,
                'room_number' => $roomNumber,
                'is_panic_alert' => $report->is_panic_alert,
                'emergency_type' => $report->emergency_type ?? '-',
                'urgency_level' => $report->urgency_level ?? 'moderate',
                'description' => $report->description ?? '-',
                'location' => $report->location ?? '-',
                'status' => $this->normalizeStatus($report->status),
                'admin_notes' => $report->admin_notes ?? '',
                'reported_at' => $report->reported_at,
                'resolved_at' => $report->resolved_at,
            ];
        })->values();
    }

    public function acknowledge($id)
    {
        $report = EmergencyReport::find($id);
        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Report not found'], 404);
        }

        if (!$report->tenant_id) {
            return response()->json(['success' => true, 'message' => 'No tenant associated with this report']);
        }

        $alreadySent = \App\Models\Notification::where('tenant_id', $report->tenant_id)
            ->where('type', 'emergency')
            ->where('ref_id', $report->report_id)
            ->where('message', 'like', '%acknowledged%')
            ->exists();

        if (!$alreadySent) {
            app(TenantPushNotificationService::class)->sendToTenant(
                tenant: $report->tenant_id,
                type: 'emergency',
                title: 'Emergency Report Acknowledged',
                body: "Staff has acknowledged your emergency report ({$report->emergency_type}) and is responding.",
                refId: $report->report_id,
                route: '/tenant/emergency',
            );

            return response()->json(['success' => true, 'notified' => true]);
        }

        return response()->json(['success' => true, 'notified' => false]);
    }

    public function pollPanic()
    {
        $latest = EmergencyReport::where('is_panic_alert', true)
            ->where('status', 'active')
            ->orderByDesc('reported_at')
            ->first();

        return response()->json([
            'has_panic' => (bool) $latest,
            'report_id' => $latest?->report_id,
            'type'      => $latest?->emergency_type,
            'location'  => $latest?->location,
            'reported_at' => $latest?->reported_at?->format('Y-m-d H:i:s'),
        ]);
    }

    public function pollCritical()
    {
        $reports = EmergencyReport::whereIn('urgency_level', ['critical', 'urgent'])
            ->where('status', 'active')
            ->orderByDesc('reported_at')
            ->take(5)
            ->get()
            ->map(fn($r) => [
                'report_id'     => $r->report_id,
                'urgency_level' => $r->urgency_level,
                'emergency_type' => $r->emergency_type,
                'location'      => $r->location,
                'reported_at'   => $r->reported_at?->format('Y-m-d H:i:s'),
            ]);

        return response()->json(['reports' => $reports]);
    }
}
