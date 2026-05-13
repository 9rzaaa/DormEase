<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * GET /api/visitors
     * Returns the authenticated tenant's visitor logs + today's stats.
     */
    public function index(Request $request)
    {
        $tenantId = $request->user()?->tenant_id ?? $request->user()?->id;

        $logs = VisitorLog::where('tenant_id', $tenantId)
            ->orderByDesc('date_of_visit')
            ->orderByDesc('visitor_id')
            ->get()
            ->map(fn($v) => [
                'id'             => $v->visitor_id,
                'visitor_name'   => $v->visitor_name,
                'contact_no'     => $v->contact_no,
                'purpose'        => $v->purpose,
                'id_type'        => $v->id_type,
                'id_photo'       => $v->id_photo
                    ? asset('storage/' . $v->id_photo)
                    : null,
                'date_of_visit'  => $v->date_of_visit,
                'time_of_visit'  => $v->time_of_visit,
                'arrival_time'   => $v->arrival_time,   // null until front desk checks in
                'departure_time' => $v->departure_time,
                'status'         => $v->status,
            ]);

        // FIX: count by date_of_visit (the expected date), not arrival_time
        // arrival_time is null until front desk checks them in
        $visitorsToday = VisitorLog::where('tenant_id', $tenantId)
            ->whereDate('date_of_visit', today())
            ->count();

        // Active = checked in but not yet checked out
        $activePasses = VisitorLog::where('tenant_id', $tenantId)
            ->whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->count();

        return response()->json([
            'visitors_today' => $visitorsToday,
            'active_passes'  => $activePasses,
            'logs'           => $logs,
        ]);
    }

    /**
     * POST /api/visitors
     * Tenant registers a new visitor.
     * arrival_time stays NULL — front desk sets it on check-in.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visitor_name'  => 'required|string|max:255',
            'contact_no'    => 'nullable|string|max:255',
            'purpose'       => 'nullable|string|max:255',
            'id_type'       => 'nullable|string|max:255',
            'id_photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'date_of_visit' => 'nullable|date',
            'time_of_visit' => 'nullable|string|max:20',
        ]);

        $tenantId = $request->user()?->tenant_id ?? $request->user()?->id;

        $photoPath = null;
        if ($request->hasFile('id_photo')) {
            $photoPath = $request->file('id_photo')
                ->store('visitor_ids', 'public');
        }

        $visitor = VisitorLog::create([
            'visitor_name'  => $request->visitor_name,
            'contact_no'    => $request->contact_no,
            'purpose'       => $request->purpose,
            'id_type'       => $request->id_type,
            'id_photo'      => $photoPath,
            'date_of_visit' => $request->date_of_visit ?? now()->toDateString(),
            'time_of_visit' => $request->time_of_visit ?? now()->format('H:i'),
            'arrival_time'  => null,    // FIX: was "now()" — front desk sets this, not the tenant
            'status'        => 'pending',
            'tenant_id'     => $tenantId,
        ]);

        return response()->json([
            'message' => 'Visitor registered successfully.',
            'visitor' => [
                'id'            => $visitor->visitor_id,
                'visitor_name'  => $visitor->visitor_name,
                'contact_no'    => $visitor->contact_no,
                'purpose'       => $visitor->purpose,
                'id_type'       => $visitor->id_type,
                'id_photo'      => $visitor->id_photo
                    ? asset('storage/' . $visitor->id_photo)
                    : null,
                'date_of_visit' => $visitor->date_of_visit,
                'time_of_visit' => $visitor->time_of_visit,
                'arrival_time'  => null,    // not checked in yet
                'status'        => $visitor->status,
            ],
        ], 201);
    }

    /**
     * PATCH /api/visitors/{id}/checkout
     * Front desk checks a visitor out.
     */
    public function checkout($id, Request $request)
    {
        $tenantId = $request->user()?->tenant_id ?? $request->user()?->id;

        $visitor = VisitorLog::where('visitor_id', $id)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        if (! $visitor->arrival_time) {
            return response()->json(['message' => 'Visitor has not checked in yet.'], 422);
        }

        if ($visitor->departure_time) {
            return response()->json(['message' => 'Visitor has already checked out.'], 422);
        }

        $visitor->update([
            'departure_time' => now(),
            'status'         => 'completed', // FIX: was 'approved'
        ]);

        return response()->json([
            'message' => 'Visitor checked out successfully.',
            'visitor' => [
                'id'             => $visitor->visitor_id,
                'status'         => $visitor->status,
                'departure_time' => $visitor->departure_time,
            ],
        ]);
    }
}