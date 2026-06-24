<?php
namespace App\Http\Controllers;
use App\Models\VisitorLog;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;
use App\Services\TenantPushNotificationService;
use Carbon\Carbon;
use App\Services\VisitorExpiryService;
use App\Models\AppSetting;

class VisitorController extends Controller
{
    public function index()
    {
        $allVisitors = VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('arrival_time')
            ->get();

        $visitors = $this->formatVisitorLogs(
            $allVisitors->whereNotIn('status', ['completed', 'deleted', 'cancelled'])
        );

        $completedVisitors = $this->formatVisitorLogs(
            $allVisitors->where('status', 'completed')
        );

        $deletedVisitors = $this->formatVisitorLogs(
            $allVisitors->where('status', 'deleted')
        );

        $cancelledVisitors = $this->formatVisitorLogs(
            $allVisitors->where('status', 'cancelled')
        );

        $visitorsToday = VisitorLog::where(function ($q) {
            $q->whereDate('date_of_visit', Carbon::today())
              ->orWhereDate('arrival_time', Carbon::today());
        })->count();
        $currentlyInside = VisitorLog::whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->where('status', 'inside')
            ->count();
        $tenants = Tenant::where('is_active', true)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        $overnightExtend = AppSetting::isEnabled(VisitorExpiryService::SETTING_KEY);

        return view('fdvisitors', compact(
            'visitors',
            'completedVisitors',
            'deletedVisitors',
            'cancelledVisitors',
            'visitorsToday',
            'currentlyInside',
            'tenants',
            'overnightExtend'
        ));
    }

    public function adminIndex()
    {
        $allVisitors = VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('arrival_time')
            ->get();

        $visitors = $this->formatVisitorLogs(
            $allVisitors->whereNotIn('status', ['completed', 'deleted', 'cancelled'])
        );

        $completedVisitors = $this->formatVisitorLogs(
            $allVisitors->where('status', 'completed')
        );

        $deletedVisitors = $this->formatVisitorLogs(
            $allVisitors->where('status', 'deleted')
        );

        $cancelledVisitors = $this->formatVisitorLogs(
            $allVisitors->where('status', 'cancelled')
        );

        $visitorsToday = VisitorLog::where(function ($q) {
            $q->whereDate('date_of_visit', Carbon::today())
              ->orWhereDate('arrival_time', Carbon::today());
        })->count();
        $currentlyInside = VisitorLog::whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->where('status', 'inside')
            ->count();
        $tenants = Tenant::where('is_active', true)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        return view('visitors', [
            'visitors'          => $visitors,
            'logs'              => $visitors,
            'completedVisitors' => $completedVisitors,
            'deletedVisitors'   => $deletedVisitors,
            'cancelledVisitors' => $cancelledVisitors,
            'visitorsToday'     => $visitorsToday,
            'currentlyInside'   => $currentlyInside,
            'tenants'           => $tenants,
            'overnightExtend'   => AppSetting::isEnabled(VisitorExpiryService::SETTING_KEY),
        ]);
    }

    public function poll()
    {
        $signature = VisitorLog::selectRaw('COUNT(*) as cnt, MAX(arrival_time) as latest, MAX(departure_time) as latest_out, SUM(CASE WHEN status = \'inside\' THEN 1 ELSE 0 END) as inside_cnt')
            ->first();

        $overnightExtend = AppSetting::isEnabled(VisitorExpiryService::SETTING_KEY);

        return response()->json([
            'signature'       => ($signature->cnt ?? 0) . '-' . ($signature->latest ?? '0') . '-' . ($signature->latest_out ?? '0') . '-' . ($signature->inside_cnt ?? 0) . '-' . ($overnightExtend ? '1' : '0'),
            'overnightExtend' => $overnightExtend,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->filled('contact_no')) {
            $request->merge(['contact_no' => preg_replace('/\D/', '', $request->contact_no)]);
        }

        $request->validate([
            'visitor_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÀ-ÖØ-öø-ÿ\s\'\-\.]+$/u',
                function ($attribute, $value, $fail) {
                    $parts = array_filter(explode(' ', trim($value)));
                    if (count($parts) < 2) {
                        $fail('The visitor full name must contain at least a first name and a last name.');
                    }
                }
            ],
            'tenant_id'    => 'required|exists:tenants,tenant_id',
            'purpose'      => 'required|string|max:100',
            'contact_no'   => ['nullable', 'regex:/^09\d{9}$/'],
            'id_type'      => 'required|string|max:50',
            'arrival_time' => 'required|date',
            'status'       => 'nullable|string|max:20',
        ], [
            'visitor_name.regex' => 'The visitor name must contain only letters, spaces, and basic punctuation (like hyphens, periods, or apostrophes).',
            'id_type.required'   => 'Please select an ID type.',
            'contact_no.regex'   => 'The contact number must be a valid PH mobile number (e.g. 09123456789).',
        ]);

        $arrivalTime = $request->filled('arrival_time')
            ? Carbon::parse($request->arrival_time)
            : now();

        $visitor = VisitorLog::create([
            'visitor_name'  => $request->visitor_name,
            'tenant_id'     => $request->tenant_id,
            'confirmed_by'  => Auth::guard('staff')->id(),
            'purpose'       => $request->purpose,
            'relationship' => $request->relationship,
            'contact_no'    => $request->contact_no,
            'id_type'       => $request->id_type,
            'date_of_visit' => $arrivalTime->toDateString(),
            'time_of_visit' => $arrivalTime->format('H:i:s'),
            'arrival_time'  => $arrivalTime,
            'status'        => $request->status ?? 'inside',
            'expires_at'    => null,
        ]);

        $tenant = Tenant::find($request->tenant_id);
        NotificationHelper::sendToAll(
            type: 'visitor_checkin',
            message: "{$request->visitor_name} checked in to visit {$tenant->first_name} {$tenant->last_name}.",
            ref_id: $visitor->visitor_id,
        );

        app(TenantPushNotificationService::class)->sendToTenant(
            tenant: $request->tenant_id,
            type: 'visitor',
            title: 'Visitor checked in',
            body: "{$request->visitor_name} has checked in.",
            refId: $visitor->visitor_id,
            route: '/tenant/visitors',
        );

        return redirect()->back()
            ->with('success', 'Visitor logged successfully.');
    }

    public function checkout(Request $request, $id)
    {
        $request->validate([
            'departure_time' => 'nullable|date',
        ]);

        $visitor = VisitorLog::findOrFail($id);
        if ($visitor->departure_time) {
            return back()->with('error', 'Visitor has already checked out.');
        }

        $visitor->update([
            'departure_time' => $request->departure_time ?? now(),
            'confirmed_by'   => $visitor->confirmed_by ?: Auth::guard('staff')->id(),
            'status'         => 'completed',
        ]);

        NotificationHelper::sendToAll(
            type: 'visitor_checkout',
            message: "{$visitor->visitor_name} has checked out.",
            ref_id: $visitor->visitor_id,
        );

        app(TenantPushNotificationService::class)->sendToTenant(
            tenant: $visitor->tenant_id,
            type: 'visitor',
            title: 'Visitor checked out',
            body: "{$visitor->visitor_name} has checked out.",
            refId: $visitor->visitor_id,
            route: '/tenant/visitors',
        );

        return back()->with('success', 'Visitor checked out successfully.');
    }

    public function timein(Request $request, $id)
    {
        $request->validate([
            'arrival_time' => 'required|date',
        ]);

        $visitor = VisitorLog::findOrFail($id);

        $visitor->update([
            'arrival_time'  => $request->arrival_time,
            'date_of_visit' => Carbon::parse($request->arrival_time)->toDateString(),
            'time_of_visit' => Carbon::parse($request->arrival_time)->format('H:i:s'),
            'confirmed_by'  => Auth::guard('staff')->id(),
            'status'        => 'inside',
        ]);

        $visitor->load('tenant');
        $tenantName = $visitor->tenant
            ? trim("{$visitor->tenant->first_name} {$visitor->tenant->last_name}")
            : 'a tenant';

        NotificationHelper::sendToAll(
            type: 'visitor_checkin',
            message: "{$visitor->visitor_name} checked in to visit {$tenantName}.",
            ref_id: $visitor->visitor_id,
        );

        app(TenantPushNotificationService::class)->sendToTenant(
            tenant: $visitor->tenant_id,
            type: 'visitor',
            title: 'Visitor checked in',
            body: "{$visitor->visitor_name} has checked in.",
            refId: $visitor->visitor_id,
            route: '/tenant/visitors',
        );

        return back()->with('success', 'Visitor time in logged successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,inside,completed,deleted',
        ]);

        $visitor = VisitorLog::findOrFail($id);
        $updates = ['status' => $request->status];

        if ($request->status === 'approved') {
            $updates['expires_at'] = now()->addHours(24);
        }

        $visitor->update($updates);

        return back()->with('success', 'Visitor status updated successfully.');
    }

    public function updateOvernightExtend(Request $request)
    {
        $request->validate([
            'enabled' => 'required|in:0,1',
        ]);

        AppSetting::setValue(VisitorExpiryService::SETTING_KEY, $request->enabled);

        return response()->json([
            'enabled' => (bool) $request->enabled,
        ]);
    }

    public function notifyTenant($id)
    {
        $visitor = VisitorLog::with('tenant')->findOrFail($id);

        if (!$visitor->tenant_id || !$visitor->tenant) {
            return response()->json([
                'message' => 'This visitor is not linked to a tenant.',
            ], 422);
        }

        if (in_array($visitor->status, ['completed', 'deleted', 'rejected'], true)) {
            return response()->json([
                'message' => 'This visitor can no longer be announced to the tenant.',
            ], 422);
        }

        $visitorName = $visitor->visitor_name ?: 'Your visitor';
        $tokenCount = app(TenantPushNotificationService::class)->sendPushOnlyToTenant(
            tenant: $visitor->tenant_id,
            type: 'visitor',
            title: 'Visitor arriving soon',
            body: "{$visitorName} is coming soon. Please prepare to receive them.",
            refId: $visitor->visitor_id,
            route: '/tenant/visitors',
        );

        return response()->json([
            'message' => $tokenCount > 0
                ? 'Tenant push notification sent.'
                : 'No active push notification device found for this tenant.',
            'sent' => $tokenCount > 0,
        ]);
    }

    private function formatVisitorLogs($visitors)
    {
        return collect($visitors)->map(function (VisitorLog $visitor) {
            $data = $visitor->toArray();

            $data['id'] = $visitor->visitor_id;

            if ($visitor->tenant) {
                $tenantName = trim($visitor->tenant->first_name . ' ' . $visitor->tenant->last_name);
                $data['tenant'] = array_merge($visitor->tenant->toArray(), [
                    'name'      => $tenantName,
                    'full_name' => $tenantName,
                ]);
            }

            if ($visitor->staff) {
                $staffName = trim($visitor->staff->first_name . ' ' . $visitor->staff->last_name);
                $data['staff'] = array_merge($visitor->staff->toArray(), [
                    'name'      => $staffName,
                    'full_name' => $staffName,
                ]);
            }

            return $data;
        })->values();
    }
}