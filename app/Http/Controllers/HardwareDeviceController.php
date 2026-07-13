<?php

namespace App\Http\Controllers;

use App\Models\HardwareDevice;
use App\Models\Tenant;
use App\Models\TenantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HardwareDeviceController extends Controller
{
    public function index()
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $devices = HardwareDevice::orderBy('floor')->orderBy('device_name')->get();

        return response()->json($devices);
    }

    public function store(Request $request)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'device_name' => 'required|string|max:100',
            'device_type' => 'required|in:rfid,fingerprint,face_recognition,pin',
            'location'    => 'nullable|string|max:200',
            'floor'       => 'nullable|integer|min:1|max:99',
        ]);

        $device = HardwareDevice::create([
            'device_name'      => $request->device_name,
            'device_type'      => $request->device_type,
            'location'         => $request->location,
            'floor'            => $request->floor,
            'device_token'     => HardwareDevice::generateToken(),
            'is_active'        => true,
        ]);

        return response()->json([
            'message' => 'Device registered successfully.',
            'device'  => $device,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $device = HardwareDevice::findOrFail($id);

        $request->validate([
            'device_name' => 'sometimes|string|max:100',
            'device_type' => 'sometimes|in:rfid,fingerprint,face_recognition,pin',
            'location'    => 'nullable|string|max:200',
            'floor'       => 'nullable|integer|min:1|max:99',
            'is_active'   => 'sometimes|boolean',
        ]);

        $device->update($request->only(['device_name', 'device_type', 'location', 'floor', 'is_active']));

        return response()->json([
            'message' => 'Device updated successfully.',
            'device'  => $device->fresh(),
        ]);
    }

    public function regenerateToken($id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $device = HardwareDevice::findOrFail($id);
        $device->update(['device_token' => HardwareDevice::generateToken()]);

        return response()->json([
            'message'      => 'Token regenerated successfully.',
            'device_token' => $device->device_token,
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $device = HardwareDevice::findOrFail($id);
        $device->delete();

        return response()->json(['message' => 'Device removed successfully.']);
    }

    public function ping(Request $request)
    {
        $token  = $request->header('X-Device-Token') ?? $request->input('device_token');
        $device = HardwareDevice::where('device_token', $token)->first();

        if (!$device) {
            return response()->json(['error' => 'Invalid device token.'], 401);
        }

        if (!$device->is_active) {
            return response()->json(['error' => 'Device is disabled.'], 403);
        }

        $device->update([
            'last_ping_at' => now(),
            'ip_address'   => $request->ip(),
            'firmware_version' => $request->input('firmware_version') ?? $device->firmware_version,
        ]);

        return response()->json([
            'message'   => 'Ping received.',
            'server_time' => now()->toISOString(),
        ]);
    }

    public function deviceTimeIn(Request $request, $tenantId)
    {
        $token  = $request->header('X-Device-Token') ?? $request->input('device_token');
        $device = HardwareDevice::where('device_token', $token)->where('is_active', true)->first();

        if (!$device) {
            return response()->json(['error' => 'Invalid or inactive device token.'], 401);
        }

        $tenant = Tenant::where('tenant_id', $tenantId)->first();

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found.'], 404);
        }

        if (!in_array($tenant->status, ['active', 'pending'])) {
            return response()->json(['error' => 'Tenant account is not active.'], 422);
        }

        if ($tenant->is_on_vacation) {
            return response()->json(['error' => 'Tenant is on vacation.'], 422);
        }

        if ($tenant->is_inside) {
            return response()->json(['error' => 'Tenant is already inside.'], 422);
        }

        $tenant->update(['is_inside' => true]);

        $device->update(['last_ping_at' => now(), 'ip_address' => $request->ip()]);

        TenantLog::create([
            'tenant_id'            => $tenant->tenant_id,
            'account_id'           => $tenant->account_id,
            'first_name'           => $tenant->first_name,
            'last_name'            => $tenant->last_name,
            'room_number'          => $tenant->room_number,
            'floor'                => $tenant->floor,
            'action'               => 'time_in',
            'logged_at'            => now(),
            'logged_by'            => $device->device_name,
            'device_id'            => $device->id,
            'hardware_device_type' => $device->device_type,
            'raw_payload'          => $request->input('raw_payload') ? json_decode(json_encode($request->input('raw_payload'))) : null,
        ]);

        return response()->json([
            'message'   => $tenant->first_name . ' ' . $tenant->last_name . ' timed in via ' . $device->device_type . '.',
            'tenant_id' => $tenant->tenant_id,
            'is_inside' => true,
        ]);
    }

    public function deviceTimeOut(Request $request, $tenantId)
    {
        $token  = $request->header('X-Device-Token') ?? $request->input('device_token');
        $device = HardwareDevice::where('device_token', $token)->where('is_active', true)->first();

        if (!$device) {
            return response()->json(['error' => 'Invalid or inactive device token.'], 401);
        }

        $tenant = Tenant::where('tenant_id', $tenantId)->first();

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found.'], 404);
        }

        if (!$tenant->is_inside) {
            return response()->json(['error' => 'Tenant is already outside.'], 422);
        }

        $tenant->update(['is_inside' => false]);

        $device->update(['last_ping_at' => now(), 'ip_address' => $request->ip()]);

        TenantLog::create([
            'tenant_id'            => $tenant->tenant_id,
            'account_id'           => $tenant->account_id,
            'first_name'           => $tenant->first_name,
            'last_name'            => $tenant->last_name,
            'room_number'          => $tenant->room_number,
            'floor'                => $tenant->floor,
            'action'               => 'time_out',
            'logged_at'            => now(),
            'logged_by'            => $device->device_name,
            'device_id'            => $device->id,
            'hardware_device_type' => $device->device_type,
            'raw_payload'          => $request->input('raw_payload') ? json_decode(json_encode($request->input('raw_payload'))) : null,
        ]);

        return response()->json([
            'message'   => $tenant->first_name . ' ' . $tenant->last_name . ' timed out via ' . $device->device_type . '.',
            'tenant_id' => $tenant->tenant_id,
            'is_inside' => false,
        ]);
    }

    public function deviceLookupByIdentifier(Request $request)
    {
        $token  = $request->header('X-Device-Token') ?? $request->input('device_token');
        $device = HardwareDevice::where('device_token', $token)->where('is_active', true)->first();

        if (!$device) {
            return response()->json(['error' => 'Invalid or inactive device token.'], 401);
        }

        $request->validate([
            'identifier' => 'required|string|max:255',
        ]);

        $identifier = $request->input('identifier');

        $tenant = Tenant::where('account_id', $identifier)
            ->whereIn('status', ['active', 'pending'])
            ->first();

        if (!$tenant) {
            return response()->json(['error' => 'No active tenant found for this identifier.'], 404);
        }

        return response()->json([
            'tenant_id'   => $tenant->tenant_id,
            'first_name'  => $tenant->first_name,
            'last_name'   => $tenant->last_name,
            'room_number' => $tenant->room_number,
            'floor'       => $tenant->floor,
            'is_inside'   => $tenant->is_inside,
        ]);
    }
}