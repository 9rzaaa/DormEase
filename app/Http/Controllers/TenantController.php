<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    // ── Show all tenants ──────────────────────────────────────────────────────
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

    // ── Add new tenant ────────────────────────────────────────────────────────
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

        // auto-generate account ID and temporary password
        $accountId   = Tenant::generateAccountId();
        $tempPassword = Tenant::generateTempPassword();

        $tenant = Tenant::create([
            'account_id'      => $accountId,
            'password_hash'   => Hash::make($tempPassword),
            'is_temp_password' => true,
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'contact_number'  => $request->contact_number,
            'room_number'     => $request->room_number,
            'floor'           => $request->floor,
            'stay_type'       => $request->stay_type,
            'move_in_date'    => $request->move_in_date,
            'status'          => 'pending',
            'is_active'       => true,
        ]);

        // pass the plain text temp password back to the view
        // so admin can see it and give it to the tenant
        // this is the ONLY time the plain text password is visible
        return redirect()->route('tenants.index')
            ->with('success', "Tenant account created successfully.")
            ->with('new_account_id', $accountId)
            ->with('new_temp_password', $tempPassword)
            ->with('new_tenant_name', $tenant->first_name . ' ' . $tenant->last_name);
    }

    // ── Edit tenant ───────────────────────────────────────────────────────────
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

    // ── Reset tenant password ─────────────────────────────────────────────────
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
            ->with('reset_account_id',   $tenant->account_id)
            ->with('reset_temp_password', $tempPassword)
            ->with('reset_tenant_name',   $tenant->first_name . ' ' . $tenant->last_name);
    }

    // ── Delete tenant ─────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant account deleted successfully.');
    }
}
