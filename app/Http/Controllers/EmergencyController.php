<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmergencyReport;
use App\Models\Tenant;
use Carbon\Carbon;
class EmergencyController extends Controller
{
    public function adminIndex()
    {
        $reports = EmergencyReport::orderBy('reported_at', 'desc')->get();
        $tenantIds = $reports->pluck('tenant_id')->filter()->unique();
        $tenantMap = Tenant::whereIn('tenant_id', $tenantIds)
            ->get()
            ->keyBy('tenant_id');
        $reports = $reports->map(function ($r) use ($tenantMap) {
            $tenant = $tenantMap->get($r->tenant_id);
            if ($tenant) {
                $tenantName = trim($tenant->first_name . ' ' . $tenant->last_name);
                $roomNumber = $tenant->room_number ?? '—';
            } elseif ($r->input_type === 'frontdesk') {
                $tenantName = 'Front Desk';
                $roomNumber = '—';
            } else {
                $tenantName = '—';
                $roomNumber = '—';
            }
            return [
                'report_id'      => $r->report_id,
                'tenant_id'      => $r->tenant_id,
                'tenant_name'    => $tenantName,
                'room_number'    => $roomNumber,
                'is_panic_alert' => $r->is_panic_alert,
                'emergency_type' => $r->emergency_type ?? '—',
                'input_type'     => $r->input_type ?? 'manual',
                'description'    => $r->description ?? '—',
                'location'       => $r->location ?? '—',
                'status'         => $r->status ?? 'pending',
                'admin_notes'    => $r->admin_notes ?? '',
                'reported_at'    => $r->reported_at,
                'resolved_at'    => $r->resolved_at,
            ];
        })->values();
        $totalCount    = $reports->count();
        $criticalCount = $reports->whereIn('status', ['pending', 'active', 'ongoing'])->count();
        $resolvedCount = $reports->where('status', 'resolved')->count();
        return view('emergency', compact(
            'reports',
            'totalCount',
            'criticalCount',
            'resolvedCount'
        ));
    }

    public function frontdeskIndex()
    {
        $staff = Auth::guard('staff')->user();
        $reports = EmergencyReport::orderBy('reported_at', 'desc')->get();
        $tenantIds = $reports->pluck('tenant_id')->filter()->unique();
        $tenantMap = Tenant::whereIn('tenant_id', $tenantIds)
            ->get()
            ->keyBy('tenant_id');
        $reports = $reports->map(function ($r) use ($tenantMap) {
            $tenant = $tenantMap->get($r->tenant_id);
            if ($tenant) {
                $tenantName = trim($tenant->first_name . ' ' . $tenant->last_name);
                $roomNumber = $tenant->room_number ?? '—';
            } elseif ($r->input_type === 'frontdesk') {
                $tenantName = 'Front Desk';
                $roomNumber = '—';
            } else {
                $tenantName = '—';
                $roomNumber = '—';
            }
            return [
                'report_id'      => $r->report_id,
                'tenant_id'      => $r->tenant_id,
                'tenant_name'    => $tenantName,
                'room_number'    => $roomNumber,
                'is_panic_alert' => $r->is_panic_alert,
                'emergency_type' => $r->emergency_type ?? '—',
                'input_type'     => $r->input_type ?? '—',
                'description'    => $r->description ?? '—',
                'location'       => $r->location ?? '—',
                'status'         => $r->status ?? 'pending',
                'admin_notes'    => $r->admin_notes ?? '',
                'reported_at'    => $r->reported_at,
                'resolved_at'    => $r->resolved_at,
            ];
        })->values();
        $totalCount    = $reports->count();
        $activeCount   = $reports->whereIn('status', ['pending', 'active', 'ongoing'])->count();
        $resolvedCount = $reports->where('status', 'resolved')->count();
        $panicCount    = $reports->where('is_panic_alert', true)->count();
        return view('fdemergency', compact(
            'staff',
            'reports',
            'totalCount',
            'activeCount',
            'resolvedCount',
            'panicCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'emergency_type' => 'required|string|max:255',
            'location'       => 'required|string|max:255',
            'description'    => 'nullable|string',
            'tenant_id'      => 'nullable|integer|exists:tenants,tenant_id',
            'is_panic_alert' => 'nullable|boolean',
        ]);
        EmergencyReport::create([
            'tenant_id'      => $request->tenant_id,
            'is_panic_alert' => $request->boolean('is_panic_alert'),
            'emergency_type' => $request->emergency_type,
            'input_type'     => 'frontdesk',
            'description'    => $request->description,
            'location'       => $request->location,
            'status'         => 'pending',
            'reported_at'    => now(),
        ]);
        return redirect()->route('frontdesk.emergency')
            ->with('success', 'Emergency report filed successfully.');
    }

    public function update(Request $request, $id)
    {
        \Log::info('Method: ' . $request->method());
        \Log::info('Input: ' . json_encode($request->all()));

        $report = EmergencyReport::findOrFail($id);
        $request->validate([
            'status'      => 'required|string',
            'admin_notes' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
        ]);
        $resolvedAt = $report->resolved_at;
        if ($request->status === 'resolved' && !$resolvedAt) {
            $resolvedAt = now();
        } elseif ($request->status !== 'resolved') {
            $resolvedAt = null;
        }
        $report->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
            'location'    => $request->location ?? $report->location,
            'resolved_at' => $resolvedAt,
        ]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        EmergencyReport::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}