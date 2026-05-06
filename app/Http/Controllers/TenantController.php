<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::orderBy('created_at', 'desc')->get();
        return view('tenants', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:tenants,email|max:100',
            'password'       => 'required|string|min:6',
            'contact_number' => 'nullable|string|max:20',
            'room_number'    => 'required|string|max:20',
            'move_in_date'   => 'required|date',
        ]);

        Tenant::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'password_hash'  => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'room_number'    => $request->room_number,
            'move_in_date'   => $request->move_in_date,
            'is_active'      => true,
        ]);

        return redirect()->route('tenants')->with('success', 'Tenant added successfully!');
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:tenants,email,'.$id.',tenant_id|max:100',
            'contact_number' => 'nullable|string|max:20',
            'room_number'    => 'required|string|max:20',
            'move_in_date'   => 'required|date',
            'is_active'      => 'boolean',
        ]);

        $data = $request->only([
            'first_name', 'last_name', 'email',
            'contact_number', 'room_number', 'move_in_date', 'is_active'
        ]);

        // Only update password if a new one was provided
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $tenant->update($data);

        return redirect()->route('tenants')->with('success', 'Tenant updated successfully!');
    }

    public function destroy($id)
    {
        Tenant::findOrFail($id)->delete();
        return redirect()->route('tenants')->with('success', 'Tenant deleted.');
    }
}