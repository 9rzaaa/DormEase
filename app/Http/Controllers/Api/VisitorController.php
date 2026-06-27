<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    public function index(Request $request)
    {
        $user     = $request->user();
        $tenantId = $user?->tenant_id ?? $user?->id;

        $tenantName = trim(($user?->first_name ?? '') . ' ' . ($user?->last_name ?? ''))
            ?: $user?->name
            ?: 'Unknown';

        $logs = VisitorLog::where('tenant_id', $tenantId)
            ->where('hidden_from_tenant', false)
            ->orderByDesc('date_of_visit')
            ->orderByDesc('visitor_id')
            ->get()
            ->map(fn($v) => [
                'id'             => $v->visitor_id,
                'visitor_name'   => $v->visitor_name,
                'contact_no'     => $v->contact_no,
                'purpose'        => $v->purpose,
                'relationship'   => $v->relationship,
                'id_type'        => $v->id_type,
                'id_photo'       => $v->id_photo
                    ? asset('storage/' . $v->id_photo)
                    : null,
                'date_of_visit'  => $v->date_of_visit,
                'time_of_visit'  => $v->time_of_visit,
                'arrival_time'   => $v->arrival_time,
                'departure_time' => $v->departure_time,
                'status'         => $v->status,
                'tenant_name'    => $tenantName,
            ]);

        $visitorsToday = VisitorLog::where('tenant_id', $tenantId)
            ->where('hidden_from_tenant', false)
            ->whereDate('date_of_visit', today())
            ->count();

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

    public function store(Request $request)
    {
        $request->validate([
            'visitor_name'  => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÀ-ÖØ-öø-ÿ\s\'\-\.]+$/u',
                function ($attribute, $value, $fail) {
                    $parts = array_filter(explode(' ', trim($value)));
                    if (count($parts) < 2) {
                        $fail('The visitor full name must contain at least a first name and a last name.');
                    }
                }
            ],
            'contact_no'    => ['required', 'digits:11', 'regex:/^09\d{9}$/'],
            'purpose'       => 'required|string|max:255',
            'relationship'  => 'required|string|max:255',
            'id_type'       => 'required|string|max:255',
            'id_photo'      => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'date_of_visit' => 'required|date',
            'time_of_visit' => 'required|string|max:20',
        ], [
            'visitor_name.regex' => 'The visitor name must contain only letters, spaces, and basic punctuation (like hyphens, periods, or apostrophes).',
        ]);

        $user     = $request->user();
        $tenantId = $user?->tenant_id ?? $user?->id;

        $tenantName = trim(($user?->first_name ?? '') . ' ' . ($user?->last_name ?? ''))
            ?: $user?->name
            ?: 'Unknown';

        $photoPath = null;
        if ($request->hasFile('id_photo')) {
            $photoPath = $request->file('id_photo')
                ->store('visitor_ids', 'public');
        }

        $visitor = VisitorLog::create([
            'visitor_name'  => $request->visitor_name,
            'contact_no'    => $request->contact_no,
            'purpose'       => $request->purpose,
            'relationship'  => $request->relationship,
            'id_type'       => $request->id_type,
            'id_photo'      => $photoPath,
            'date_of_visit' => $request->date_of_visit ?? now()->toDateString(),
            'time_of_visit' => $request->time_of_visit ?? now()->format('H:i'),
            'arrival_time'  => null,
            'status'        => 'pending',
            'tenant_id'     => $tenantId,
            'expires_at'    => now()->addHours(24),
        ]);

        NotificationHelper::sendToAll(
            type: 'visitor_registration',
            message: "{$tenantName} registered visitor {$request->visitor_name}.",
            ref_id: $visitor->visitor_id,
        );

        return response()->json([
            'message' => 'Visitor registered successfully.',
            'visitor' => [
                'id'            => $visitor->visitor_id,
                'visitor_name'  => $visitor->visitor_name,
                'contact_no'    => $visitor->contact_no,
                'purpose'       => $visitor->purpose,
                'relationship'  => $visitor->relationship,
                'id_type'       => $visitor->id_type,
                'id_photo'      => $visitor->id_photo
                    ? asset('storage/' . $visitor->id_photo)
                    : null,
                'date_of_visit' => $visitor->date_of_visit,
                'time_of_visit' => $visitor->time_of_visit,
                'arrival_time'  => null,
                'status'        => $visitor->status,
                'tenant_name'   => $tenantName,
            ],
        ], 201);
    }

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
            'status'         => 'completed',
        ]);

        NotificationHelper::sendToAll(
            type: 'visitor_checkout',
            message: "{$visitor->visitor_name} has checked out.",
            ref_id: $visitor->visitor_id,
        );

        return response()->json([
            'message' => 'Visitor checked out successfully.',
            'visitor' => [
                'id'             => $visitor->visitor_id,
                'status'         => $visitor->status,
                'departure_time' => $visitor->departure_time,
            ],
        ]);
    }

    public function cancel($id, Request $request)
    {
        $user = $request->user();
        $tenantId = $user?->tenant_id ?? $user?->id;

        $visitor = VisitorLog::where('visitor_id', $id)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        if ($visitor->arrival_time) {
            return response()->json(['message' => 'Visitor has already checked in.'], 422);
        }

        if (in_array($visitor->status, ['cancelled', 'completed', 'rejected'], true)) {
            return response()->json(['message' => 'Visitor registration cannot be cancelled in its current state.'], 422);
        }

        $visitor->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $tenantName = trim(($user?->first_name ?? '') . ' ' . ($user?->last_name ?? '')) ?: 'Unknown';

        NotificationHelper::sendToAll(
            type: 'visitor_cancelled',
            message: "{$tenantName} cancelled visitor registration for {$visitor->visitor_name}.",
            ref_id: $visitor->visitor_id,
        );

        return response()->json([
            'message' => 'Visitor registration cancelled successfully.',
            'visitor' => [
                'id'     => $visitor->visitor_id,
                'status' => $visitor->status,
            ],
        ]);
    }

    public function destroy($id, Request $request)
    {
        $tenantId = $request->user()?->tenant_id ?? $request->user()?->id;

        $visitor = VisitorLog::where('visitor_id', $id)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        if (!in_array($visitor->status, ['completed', 'cancelled'], true)) {
            return response()->json(['message' => 'Only completed or cancelled visitor logs can be hidden from your view.'], 422);
        }

        $visitor->update([
            'hidden_from_tenant' => true,
        ]);

        return response()->json([
            'message' => 'Visitor log removed from your view.',
        ]);
    }
}
