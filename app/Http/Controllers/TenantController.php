<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::orderBy('created_at', 'desc')->get();

        return view('tenants', [
            'tenants'      => $tenants,
            'totalTenants' => $tenants->count(),
            'activeCount'  => $tenants->where('status', 'active')->count(),
            'pendingCount' => $tenants->where('status', 'pending')->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:tenants,email',
            'contact_number' => 'nullable|string|max:20',
            'room_number'    => 'nullable|string|max:20',
            'floor'          => 'nullable|integer|min:1|max:5',
            'stay_type'      => 'nullable|string|max:50',
            'move_in_date'   => 'nullable|date',
        ]);

        $accountId    = Tenant::generateAccountId();
        $tempPassword = Tenant::generateTempPassword();

        $tenant = Tenant::create([
            'account_id'       => $accountId,
            'password_hash'    => Hash::make($tempPassword),
            'is_temp_password' => true,
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'contact_number'   => $request->contact_number,
            'room_number'      => $request->room_number,
            'floor'            => $request->floor,
            'stay_type'        => $request->stay_type,
            'move_in_date'     => $request->move_in_date,
            'status'           => 'pending',
            'is_active'        => true,
        ]);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant account created successfully.')
            ->with('new_account_id',    $accountId)
            ->with('new_temp_password', $tempPassword)
            ->with('new_tenant_name',   $tenant->first_name . ' ' . $tenant->last_name);
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:tenants,email,' . $id . ',tenant_id',
            'contact_number' => 'nullable|string|max:20',
            'room_number'    => 'nullable|string|max:20',
            'floor'          => 'nullable|integer|min:1|max:5',
            'stay_type'      => 'nullable|string|max:50',
            'move_in_date'   => 'nullable|date',
            'move_out_date'  => 'nullable|date',
            'status'         => 'required|in:active,pending,move_out,inactive',
        ]);

        $tenant->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'room_number'    => $request->room_number,
            'floor'          => $request->floor,
            'stay_type'      => $request->stay_type,
            'move_in_date'   => $request->move_in_date,
            'move_out_date'  => $request->move_out_date,
            'status'         => $request->status,
            'is_active'      => $request->status !== 'inactive',
        ]);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant information updated successfully.');
    }

    public function apiUpdateProfile(Request $request)
    {
        /** @var Tenant $tenant */
        $tenant = $request->user();

        $request->validate([
            'email'          => 'required|email|unique:tenants,email,' . $tenant->tenant_id . ',tenant_id',
            'contact_number' => 'required|string|digits:11',
        ]);

        $tenant->update([
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return response()->json([
            'message'        => 'Contact info updated successfully.',
            'email'          => $tenant->email,
            'contact_number' => $tenant->contact_number,
        ]);
    }

    public function apiUpdatePhoto(Request $request)
    {
        /** @var Tenant $tenant */
        $tenant = $request->user();

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($tenant->profile_photo) {
            Storage::disk('public')->delete($tenant->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        $tenant->update(['profile_photo' => $path]);

        return response()->json([
            'message'       => 'Profile photo updated successfully.',
            'profile_photo' => $path,
        ]);
    }

    public function resetPassword($id)
    {
        $tenant       = Tenant::findOrFail($id);
        $tempPassword = Tenant::generateTempPassword();

        $tenant->update([
            'password_hash'    => Hash::make($tempPassword),
            'is_temp_password' => true,
        ]);

        return redirect()->route('tenants.index')
            ->with('success', 'Password reset successfully.')
            ->with('reset_account_id',    $tenant->account_id)
            ->with('reset_temp_password', $tempPassword)
            ->with('reset_tenant_name',   $tenant->first_name . ' ' . $tenant->last_name);
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant account deleted successfully.');
    }
    public function frontdeskIndex()
    {
    $tenants = Tenant::where('is_active', true)
        ->orderBy('first_name')
        ->get();

    $totalUnits    = 25;
    $occupiedUnits = Tenant::where('is_active', true)->whereNotNull('room_number')->distinct('room_number')->count('room_number');
    $vacantUnits   = $totalUnits - $occupiedUnits;

    return view('fdtenant', [
        'tenants'       => $tenants,
        'totalTenants'  => $tenants->count(),
        'activeCount'   => $tenants->where('status', 'active')->count(),
        'pendingCount'  => $tenants->where('status', 'pending')->count(),
        'occupiedUnits' => $occupiedUnits,
        'vacantUnits'   => $vacantUnits,
        'totalUnits'    => $totalUnits,
    ]);
    }
}