<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->latest('arrival_time')
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
                'arrival_time'   => $v->arrival_time,
                'departure_time' => $v->departure_time,
                'status'         => $v->status,
            ]);

        $visitorsToday = VisitorLog::where('tenant_id', $tenantId)
            ->whereDate('arrival_time', today())
            ->count();

        // active = checked in but not yet checked out
        $activePasses = VisitorLog::where('tenant_id', $tenantId)
            ->whereIn('status', ['inside', 'pending'])
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
     * Registers a new visitor. Accepts multipart/form-data so id_photo can
     * be uploaded as a file alongside the other fields.
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

        // store photo if provided
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
            'arrival_time'  => now(),
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
                'arrival_time'  => $visitor->arrival_time,
                'status'        => $visitor->status,
            ],
        ], 201);
    }

    /**
     * PATCH /api/visitors/{id}/checkout
     * Marks a visitor as checked out (sets departure_time + status = approved).
     */
    public function checkout($id, Request $request)
    {
        $tenantId = $request->user()?->tenant_id ?? $request->user()?->id;

        // only allow checkout of the tenant's own visitors
        $visitor = VisitorLog::where('visitor_id', $id)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        $visitor->update([
            'departure_time' => now(),
            'status'         => 'approved',
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
