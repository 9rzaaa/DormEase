<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceRequest;
use App\Helpers\NotificationHelper;

class MaintenanceController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $requests = MaintenanceRequest::with('tenant')
            ->latest('submitted_at')
            ->get()
            ->map(function ($r) {
                return [
                    'id'            => $r->request_id,
                    'tenant_name'   => optional($r->tenant)->first_name . ' ' . optional($r->tenant)->last_name,
                    'room_number'   => $r->room_number,
                    'issue_type'    => $r->issue_type,
                    'description'   => $r->description,
                    'urgency'       => $r->urgency_level,
                    'status'        => $r->status,
                    'admin_remarks' => $r->admin_notes,
                    'created_at' => $r->submitted_at ? $r->submitted_at->format('Y-m-d H:i:s') : null,
                ];
            });

        $stats = [
            'total'       => MaintenanceRequest::count(),
            'urgent'      => MaintenanceRequest::where('urgency_level', 'urgent')->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in-progress')->count(),
            'resolved'    => MaintenanceRequest::where('status', 'resolved')->count(),
        ];

        return view('maintenance', compact('staff', 'requests', 'stats'));
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

        NotificationHelper::sendToAll(
            type: 'maintenance_new',
            message: "Maintenance request #{$maintenance->request_id} status updated to {$request->status}.",
            ref_id: $maintenance->request_id,
        );
        
        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request updated successfully.');
    }

    public function destroy($id)
    {
        MaintenanceRequest::findOrFail($id)->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request deleted.');
    }
}
