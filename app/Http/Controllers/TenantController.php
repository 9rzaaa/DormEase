<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();

        return view('tenants', [
            'tenants'        => $tenants,
            'totalTenants'   => Tenant::count(),
            'occupiedUnits'  => Tenant::whereNotNull('room_number')->count(),
            'totalUnits'     => 25,
            'pendingCount'   => Tenant::where('is_active', false)->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'room_number'    => 'nullable|string|max:50',
            'move_in_date'   => 'nullable|date',
            'contact_number' => 'nullable|string|max:20',
        ]);

        Tenant::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'room_number'    => $request->room_number,
            'move_in_date'   => $request->move_in_date,
            'contact_number' => $request->contact_number,

            'is_active'      => true,
        ]);

        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant added successfully.');
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'room_number'    => 'nullable|string|max:50',
            'move_in_date'   => 'nullable|date',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $tenant->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'room_number'    => $request->room_number,
            'move_in_date'   => $request->move_in_date,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant updated successfully.');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant deleted successfully.');
    }
}