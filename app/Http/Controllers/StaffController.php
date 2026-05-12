<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderByDesc('staff_id')->get();

        $staffList = $staff->map(function ($s) {
            return [
                'staff_id'       => $s->staff_id,
                'first_name'     => $s->first_name,
                'last_name'      => $s->last_name,
                'email'          => $s->email,
                'role'           => $s->role,
                'contact_number' => $s->contact_number,
                'shift_schedule' => $s->shift_schedule,
                'duty_status'    => $s->duty_status,
                'is_active'      => $s->is_active,
                'created_at'     => $s->created_at,
            ];
        });

        return view('staff', [
            'staffList'    => $staffList,
            'totalStaff'   => $staff->count(),
            'onDutyCount'  => $staff->where('duty_status', 'on_duty')->count(),
            'offDutyCount' => $staff->where('duty_status', 'off_duty')->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:staff,email',
            'role'           => 'required|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'shift_schedule' => 'nullable|string|max:50',
        ]);

        $tempPassword = 'Staff@' . strtoupper(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6));

        $staff = Staff::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'password_hash'    => Hash::make($tempPassword),
            'is_temp_password' => true,
            'role'             => $request->role,
            'contact_number'   => $request->contact_number,
            'shift_schedule'   => $request->shift_schedule,
            'duty_status'      => 'off_duty',
            'is_active'        => true,
        ]);

        $staff->refresh();

        return redirect()->route('staff.index')
            ->with('success', 'Staff account created successfully.')
            ->with('new_email', $staff->email)
            ->with('new_staff_id', 'ST-' . str_pad($staff->staff_id, 3, '0', STR_PAD_LEFT))
            ->with('new_temp_password', $tempPassword);
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => [
                'required',
                'email',
                Rule::unique('staff', 'email')->ignore($staff->staff_id, 'staff_id'),
            ],
            'role'           => 'required|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'shift_schedule' => 'nullable|string|max:50',
            'duty_status'    => 'nullable|string|max:50',
            'is_active'      => 'nullable|boolean',
        ]);

        $staff->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'role'           => $request->role,
            'contact_number' => $request->contact_number,
            'shift_schedule' => $request->shift_schedule,
            'duty_status'    => $request->duty_status,
            'is_active'      => $request->is_active,
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff details updated successfully.');
    }

    public function resetPassword($id)
    {
        $staff = Staff::findOrFail($id);

        $tempPassword = 'Staff@' . strtoupper(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6));

        $staff->update([
            'password_hash'    => Hash::make($tempPassword),
            'is_temp_password' => true,
        ]);

        return response()->json([
            'success'             => true,
            'reset_email'         => $staff->email,
            'reset_staff_id'      => 'ST-' . str_pad($staff->staff_id, 3, '0', STR_PAD_LEFT),
            'reset_temp_password' => $tempPassword,
        ]);
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        $name = "{$staff->first_name} {$staff->last_name}";

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', "{$name} has been removed.");
    }
}