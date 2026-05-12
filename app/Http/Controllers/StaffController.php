<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staffList = Staff::latest()->get();

        $totalStaff = $staffList->count();

        $onDutyCount = $staffList
            ->where('duty_status', 'on_duty')
            ->count();

        $offDutyCount = $staffList
            ->where('duty_status', 'off_duty')
            ->count();

        return view('staff', compact(
            'staffList',
            'totalStaff',
            'onDutyCount',
            'offDutyCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:staff,email',
            'role'           => 'required|string',
            'shift_schedule' => 'nullable|string',
            'contact_number' => 'nullable|string|max:20',
        ]);

        Staff::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'role'           => $request->role,
            'shift_schedule' => $request->shift_schedule,
            'contact_number' => $request->contact_number,
            'duty_status'    => 'off_duty',
            'is_active'      => 1,
        ]);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff added successfully.');
    }
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:staff,email,' . $id . ',staff_id',
            'role'           => 'required|string',
            'shift_schedule' => 'nullable|string',
            'contact_number' => 'nullable|string|max:20',
            'duty_status'    => 'nullable|string',
            'is_active'      => 'nullable|boolean',
        ]);

        $staff->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'role'           => $request->role,
            'shift_schedule' => $request->shift_schedule,
            'contact_number' => $request->contact_number,
            'duty_status'    => $request->duty_status,
            'is_active'      => $request->is_active,
        ]);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        $staff->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }
}