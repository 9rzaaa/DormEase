<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\ArchivedStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderByDesc('staff_id')->get();

        $staffList = $staff->where('is_active', true)->map(function ($s) {
            return [
                'staff_id'       => $s->staff_id,
                'account_id'     => $s->account_id,
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
        })->values();

        $inactiveArchive = $staff->where('is_active', false)->map(function ($s) {
            return [
                'staff_id'       => $s->staff_id,
                'account_id'     => $s->account_id,
                'first_name'     => $s->first_name,
                'last_name'      => $s->last_name,
                'email'          => $s->email,
                'role'           => $s->role,
                'contact_number' => $s->contact_number,
                'shift_schedule' => $s->shift_schedule,
                'duty_status'    => $s->duty_status,
                'is_active'      => $s->is_active,
                'created_at'     => $s->created_at,
                'updated_at'     => $s->updated_at,
            ];
        })->values();

        $deletedArchive = ArchivedStaff::orderByDesc('archived_at')->get()->map(function ($r) {
            return [
                'original_staff_id' => $r->original_staff_id,
                'account_id'        => $r->account_id,
                'staff_code'        => $r->staff_code,
                'first_name'        => $r->first_name,
                'last_name'         => $r->last_name,
                'email'             => $r->email,
                'role'              => $r->role,
                'contact_number'    => $r->contact_number,
                'shift_schedule'    => $r->shift_schedule,
                'duty_status'       => $r->duty_status,
                'is_active'         => $r->is_active,
                'archived_at'       => $r->archived_at,
            ];
        });

        $activeStaff = $staff->where('is_active', true);

        return view('staff', [
            'staffList'       => $staffList,
            'totalStaff'      => $activeStaff->count(),
            'onDutyCount'     => $activeStaff->where('duty_status', 'on_duty')->count(),
            'offDutyCount'    => $activeStaff->where('duty_status', 'off_duty')->count(),
            'deletedArchive'  => $deletedArchive,
            'inactiveArchive' => $inactiveArchive,
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
            'staff_code'       => 'ST-' . str_pad((Staff::max('staff_id') ?? 0) + 1, 3, '0', STR_PAD_LEFT),
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

        ArchivedStaff::create([
            'original_staff_id' => $staff->staff_id,
            'account_id'        => $staff->account_id,
            'staff_code'        => $staff->staff_code,
            'first_name'        => $staff->first_name,
            'last_name'         => $staff->last_name,
            'email'             => $staff->email,
            'role'              => $staff->role,
            'contact_number'    => $staff->contact_number,
            'shift_schedule'    => $staff->shift_schedule,
            'duty_status'       => $staff->duty_status,
            'is_active'         => $staff->is_active,
            'archived_at'       => now(),
        ]);

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', "{$name} has been removed.");
    }
}