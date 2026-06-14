<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantLogController extends Controller
{
    public function timeIn(Request $request, $id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $tenant = Tenant::findOrFail($id);
        if ($tenant->is_inside) {
            return response()->json(['error' => 'Tenant is already inside.'], 422);
        }

        $staff = Auth::guard('staff')->user();

        TenantLog::create([
            'tenant_id'   => $tenant->tenant_id,
            'account_id'  => $tenant->account_id,
            'first_name'  => $tenant->first_name,
            'last_name'   => $tenant->last_name,
            'room_number' => $tenant->room_number,
            'floor'       => $tenant->floor,
            'action'      => 'time_in',
            'logged_at'   => now(),
            'logged_by'   => $staff ? $staff->name : 'Front Desk',
        ]);

        $tenant->update(['is_inside' => true]);

        return response()->json([
            'message'   => $tenant->first_name . ' ' . $tenant->last_name . ' timed in.',
            'is_inside' => true,
        ]);
    }

    public function timeOut(Request $request, $id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $tenant = Tenant::findOrFail($id);
        if (!$tenant->is_inside) {
            return response()->json(['error' => 'Tenant is already outside.'], 422);
        }

        $staff = Auth::guard('staff')->user();

        TenantLog::create([
            'tenant_id'   => $tenant->tenant_id,
            'account_id'  => $tenant->account_id,
            'first_name'  => $tenant->first_name,
            'last_name'   => $tenant->last_name,
            'room_number' => $tenant->room_number,
            'floor'       => $tenant->floor,
            'action'      => 'time_out',
            'logged_at'   => now(),
            'logged_by'   => $staff ? $staff->name : 'Front Desk',
        ]);

        $tenant->update(['is_inside' => false]);

        return response()->json([
            'message'   => $tenant->first_name . ' ' . $tenant->last_name . ' timed out.',
            'is_inside' => false,
        ]);
    }

    public function logs(Request $request)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $logs = TenantLog::orderByDesc('logged_at')
            ->limit(500)
            ->get();

        return response()->json($logs);
    }
}