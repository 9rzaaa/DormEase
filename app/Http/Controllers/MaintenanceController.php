<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceRequest;
use App\Models\ArchivedMaintReq;
use App\Helpers\NotificationHelper;
use App\Services\TenantPushNotificationService;

class MaintenanceController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $requests = MaintenanceRequest::with('tenant')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->latest('submitted_at')
            ->get()
            ->map(function ($r) {
                return [
                    'id'                        => $r->request_id,
                    'tenant_name'               => trim(optional($r->tenant)->first_name . ' ' . optional($r->tenant)->last_name),
                    'room_number'               => $r->room_number,
                    'issue_type'                => $r->issue_type,
                    'description'               => $r->description,
                    'urgency'                   => $r->urgency_level,
                    'status'                    => $r->status,
                    'admin_remarks'             => $r->admin_notes,
                    'photo_url'                 => $r->photo_path ? asset('storage/' . $r->photo_path) : null,
                    'resubmission_requested_at' => $r->resubmission_requested_at
                                                        ? $r->resubmission_requested_at->format('Y-m-d H:i:s')
                                                        : null,
                    'created_at'                => $r->submitted_at ? $r->submitted_at->format('Y-m-d H:i:s') : null,
                ];
            });

        $stats = [
            'total'       => MaintenanceRequest::count(),
            'urgent'      => MaintenanceRequest::whereNotIn('status', ['resolved', 'closed'])->where('urgency_level', 'urgent')->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in-progress')->count(),
            'resolved'    => ArchivedMaintReq::where('archive_type', 'resolved')->count(),
        ];

        $closedArchive = ArchivedMaintReq::where('archive_type', 'closed')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $resolvedArchive = ArchivedMaintReq::where('archive_type', 'resolved')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $deletedArchive = ArchivedMaintReq::where('archive_type', 'deleted')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        return view('maintenance', compact('staff', 'requests', 'stats', 'closedArchive', 'resolvedArchive', 'deletedArchive'));
    }

    private function formatArchive(ArchivedMaintReq $r): array
    {
        return [
            'id'            => $r->original_id,
            'archive_id'    => $r->id,
            'tenant_name'   => $r->tenant_name,
            'room_number'   => $r->room_number,
            'issue_type'    => $r->issue_type,
            'description'   => $r->description,
            'urgency'       => $r->urgency_level,
            'status'        => $r->status,
            'admin_remarks' => $r->admin_notes,
            'photo_url'     => $r->photo_path
                ? asset('storage/' . $r->photo_path)
                : null,
            'created_at'    => $r->submitted_at ? $r->submitted_at->format('Y-m-d H:i:s') : null,
            'archived_at'   => $r->archived_at ? $r->archived_at->format('Y-m-d H:i:s') : null,
        ];
    }

    public function update(Request $request, $id)
    {
        $maintenance = MaintenanceRequest::findOrFail($id);

        $request->validate([
            'status'        => 'required|in:pending,in-progress,resolved,closed',
            'urgency'       => 'required|in:low,moderate,urgent',
            'admin_remarks' => 'nullable|string|max:1000',
        ]);

        $adminNotes = $request->admin_remarks;

        $updates = [
            'status'        => $request->status,
            'urgency_level' => $request->urgency,
            'admin_notes'   => $adminNotes,
        ];

        if ($adminNotes !== $maintenance->admin_notes) {
            $updates['admin_notes_at'] = filled($adminNotes) ? now() : null;
        }

        $maintenance->update($updates);

        if ($request->status === 'closed') {
            app(TenantPushNotificationService::class)->sendToTenant(
                tenant: $maintenance->tenant_id,
                type: 'maintenance',
                title: 'Maintenance request closed',
                body: "Your maintenance request #REQ-" . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT) . " has been closed.",
                refId: $maintenance->request_id,
                route: '/tenant/maintenancehistory',
            );

            $this->archiveRequest($maintenance, 'closed');
            $maintenance->delete();

            return redirect()->route('maintenance.index')
                ->with('success', 'Request closed and moved to archive.');
        }

        if ($request->status === 'resolved') {
            app(TenantPushNotificationService::class)->sendToTenant(
                tenant: $maintenance->tenant_id,
                type: 'maintenance',
                title: 'Maintenance request resolved',
                body: "Your maintenance request #REQ-" . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT) . " has been resolved.",
                refId: $maintenance->request_id,
                route: '/tenant/maintenancehistory',
            );

            NotificationHelper::sendToAll(
                'maintenance_update',
                "Maintenance request #REQ-" . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT) . " has been resolved.",
                $maintenance->request_id
            );

            $this->archiveRequest($maintenance, 'resolved');
            $maintenance->delete();

            return redirect()->route('maintenance.index')
                ->with('success', 'Request resolved and moved to archive.');
        }

        NotificationHelper::sendToAll(
            'maintenance_update',
            "Maintenance request #REQ-" . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT) . " status updated to {$request->status}.",
            $maintenance->request_id
        );

        app(TenantPushNotificationService::class)->sendToTenant(
            tenant: $maintenance->tenant_id,
            type: 'maintenance',
            title: 'Maintenance request updated',
            body: "Your maintenance request is now {$request->status}.",
            refId: $maintenance->request_id,
            route: '/tenant/maintenancehistory',
        );

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request updated successfully.');
    }

    public function destroy($id)
    {
        $maintenance = MaintenanceRequest::findOrFail($id);
        $this->archiveRequest($maintenance, 'deleted');
        $maintenance->delete();

        NotificationHelper::sendToAll(
            'maintenance_deleted',
            "Maintenance request #REQ-" . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT) . " has been deleted and archived.",
            $maintenance->request_id
        );

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request deleted and archived.');
    }

    public function requestResubmission(Request $request, $id)
    {
        $maintenance = MaintenanceRequest::findOrFail($id);

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $maintenance->update([
            'resubmission_requested_at' => now(),
            'resubmission_reason'       => $request->reason,
        ]);

        $reqLabel = '#REQ-' . str_pad($maintenance->request_id, 3, '0', STR_PAD_LEFT);

        app(TenantPushNotificationService::class)->sendToTenant(
            tenant: $maintenance->tenant_id,
            type: 'maintenance',
            title: 'Photo resubmission requested',
            body: "The admin has requested a new photo for your maintenance request {$reqLabel}. Reason: {$request->reason}. Please resubmit.",
            refId: $maintenance->request_id,
            route: '/tenant/maintenanceresubmit',
        );

        NotificationHelper::sendToAll(
            'maintenance_resubmission',
            "Photo resubmission requested for {$reqLabel}.",
            $maintenance->request_id
        );

        return response()->json(['success' => true]);
    }
    
    private function archiveRequest(MaintenanceRequest $r, string $type): void
    {
        ArchivedMaintReq::create([
            'original_id'   => $r->request_id,
            'archive_type'  => $type,
            'tenant_id'     => $r->tenant_id,
            'tenant_name'   => trim(optional($r->tenant)->first_name . ' ' . optional($r->tenant)->last_name),
            'room_number'   => $r->room_number,
            'issue_type'    => $r->issue_type,
            'description'   => $r->description,
            'urgency_level' => $r->urgency_level,
            'status'        => $r->status,
            'admin_notes'   => $r->admin_notes,
            'assigned_to'   => $r->assigned_to,
            'photo_path'    => $r->photo_path,
            'submitted_at'  => $r->submitted_at,
            'resolved_at'   => $r->resolved_at,
            'archived_at'   => now(),
        ]);
    }
}
