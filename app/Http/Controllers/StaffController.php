<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\ArchivedStaff;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        Staff::where('is_on_leave', true)
            ->whereNotNull('leave_end')
            ->whereDate('leave_end', '<', $today)
            ->update([
                'is_on_leave' => false,
                'leave_start' => null,
                'leave_end'   => null,
                'leave_note'  => null,
                'duty_status' => 'on_duty',
            ]);

        Staff::where('is_on_leave', true)
            ->where(function ($q) use ($today) {
                $q->whereNull('leave_start')
                  ->orWhereDate('leave_start', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('leave_end')
                  ->orWhereDate('leave_end', '>=', $today);
            })
            ->where('duty_status', '!=', 'off_duty')
            ->update(['duty_status' => 'off_duty']);

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
                'is_on_leave'    => $s->is_on_leave,
                'leave_start'    => $s->leave_start?->toDateString(),
                'leave_end'      => $s->leave_end?->toDateString(),
                'leave_note'     => $s->leave_note,
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
                'is_on_leave'    => $s->is_on_leave,
                'leave_start'    => $s->leave_start?->toDateString(),
                'leave_end'      => $s->leave_end?->toDateString(),
                'leave_note'     => $s->leave_note,
                'is_active'      => $s->is_active,
                'inactivated_at' => $s->inactivated_at,
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
                'is_on_leave'       => $r->is_on_leave,
                'leave_start'       => $r->leave_start?->toDateString(),
                'leave_end'         => $r->leave_end?->toDateString(),
                'leave_note'        => $r->leave_note,
                'is_active'         => $r->is_active,
                'archived_at'       => $r->archived_at,
            ];
        });

        $activeStaff = $staff->where('is_active', true);

        $attendanceLogs = StaffAttendance::orderByDesc('login_at')->take(200)->get()->map(function ($a) {
            $duration = null;
            if ($a->login_at && $a->logout_at) {
                $mins = (int) $a->login_at->diffInMinutes($a->logout_at);
                $duration = ($mins >= 60)
                    ? floor($mins / 60) . 'h ' . ($mins % 60) . 'm'
                    : $mins . 'm';
            }
            return [
                'attendance_id'  => $a->attendance_id,
                'staff_id'       => $a->staff_id,
                'staff_name'     => $a->staff_name,
                'role'           => $a->role,
                'shift_schedule' => $a->shift_schedule,
                'login_at'       => $a->login_at?->toDateTimeString(),
                'logout_at'      => $a->logout_at?->toDateTimeString(),
                'duty_status'    => $a->duty_status,
                'duration'       => $duration,
            ];
        });

        return view('staff', [
            'staffList'       => $staffList,
            'totalStaff'      => $activeStaff->count(),
            'onDutyCount'     => $activeStaff->where('duty_status', 'on_duty')->count(),
            'offDutyCount'    => $activeStaff->where('duty_status', 'off_duty')->count(),
            'onLeaveCount'    => $activeStaff->where('is_on_leave', true)->count(),
            'deletedArchive'  => $deletedArchive,
            'inactiveArchive' => $inactiveArchive,
            'attendanceLogs'  => $attendanceLogs,
        ]);
    }

    public function poll()
    {
        $today = now()->toDateString();

        Staff::where('is_on_leave', true)
            ->whereNotNull('leave_end')
            ->whereDate('leave_end', '<', $today)
            ->update([
                'is_on_leave' => false,
                'leave_start' => null,
                'leave_end'   => null,
                'leave_note'  => null,
                'duty_status' => 'on_duty',
            ]);

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
                'is_on_leave'    => $s->is_on_leave,
                'leave_start'    => $s->leave_start?->toDateString(),
                'leave_end'      => $s->leave_end?->toDateString(),
                'leave_note'     => $s->leave_note,
                'is_active'      => $s->is_active,
                'created_at'     => $s->created_at,
            ];
        })->values();

        $activeStaff = $staff->where('is_active', true);

        return response()->json([
            'staffList'      => $staffList,
            'totalStaff'     => $activeStaff->count(),
            'onDutyCount'    => $activeStaff->where('duty_status', 'on_duty')->count(),
            'offDutyCount'   => $activeStaff->where('duty_status', 'off_duty')->count(),
        ]);
    }

    private function shiftTimes(?string $schedule): array
    {
        if ($schedule === 'Day') {
            return ['shift_start' => '06:00:00', 'shift_end' => '18:00:00'];
        }
        if ($schedule === 'Night') {
            return ['shift_start' => '18:00:00', 'shift_end' => '06:00:00'];
        }
        return ['shift_start' => null, 'shift_end' => null];
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:staff,email',
            'role'           => 'required|string|max:50',
            'contact_number' => ['nullable', 'string', 'regex:/^09\d{2}-\d{3}-\d{4}$/', 'unique:staff,contact_number'],
            'shift_schedule' => 'nullable|string|max:50',
        ], [
            'contact_number.unique' => 'This mobile number is already registered to another staff member.',
        ]);

        if ($request->role === 'admin') {
            $adminCount = Staff::where('role', 'admin')
                ->where('is_active', true)
                ->count();

            if ($adminCount >= 2) {
                return back()
                    ->withErrors(['role' => 'Cannot add more admins. Maximum of 2 active admin accounts allowed.'])
                    ->withInput();
            }
        }

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $suffix = '';
        for ($i = 0; $i < 6; $i++) {
            $suffix .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $tempPassword = 'Staff@' . $suffix;

        $shiftTimes = $this->shiftTimes($request->shift_schedule);

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
            'shift_start'      => $shiftTimes['shift_start'],
            'shift_end'        => $shiftTimes['shift_end'],
            'duty_status'      => 'off_duty',
            'is_active'        => true,
        ]);

        $staff->refresh();

        return redirect()->route('staff.index')
            ->with('success', 'Staff account created successfully.')
            ->with('new_staff_name', $staff->first_name . ' ' . $staff->last_name)
            ->with('new_email', $staff->email)
            ->with('new_staff_id', 'ST-' . str_pad($staff->staff_id, 3, '0', STR_PAD_LEFT))
            ->with('new_temp_password', $tempPassword);
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $today = now()->toDateString();

        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => [
                'required',
                'email',
                Rule::unique('staff', 'email')->ignore($staff->staff_id, 'staff_id'),
            ],
            'role'           => 'required|string|max:50',
            'contact_number' => [
                'nullable',
                'string',
                'regex:/^09\d{2}-\d{3}-\d{4}$/',
                Rule::unique('staff', 'contact_number')->ignore($staff->staff_id, 'staff_id'),
            ],
            'shift_schedule' => 'nullable|string|max:50',
            'duty_status'    => 'nullable|string|max:50',
            'is_active'      => 'nullable|boolean',
            'is_on_leave'    => 'nullable|boolean',
            'leave_start'    => 'nullable|date',
            'leave_end'      => 'nullable|date|after_or_equal:leave_start',
            'leave_note'     => 'nullable|string|max:255',
        ], [
            'email.unique'           => 'This email is already registered to another staff member.',
            'contact_number.unique'  => 'This mobile number is already registered to another staff member.',
        ]);

        $willBeAdmin       = $request->role === 'admin';
        $willBeActive      = $request->boolean('is_active');
        $wasAlreadyAdmin   = $staff->role === 'admin' && $staff->is_active;
        $becomingAdmin     = $willBeAdmin && $willBeActive && ! $wasAlreadyAdmin;

        if ($becomingAdmin) {
            $adminCount = Staff::where('role', 'admin')
                ->where('is_active', true)
                ->where('staff_id', '!=', $staff->staff_id)
                ->count();

            if ($adminCount >= 2) {
                return back()
                    ->withErrors(['role' => 'Cannot set this account to admin. Maximum of 2 active admin accounts allowed.'])
                    ->withInput();
            }
        }

        $isBeingDeactivated = $request->is_active == '0' && $staff->is_active;
        $isBeingReactivated = $request->is_active == '1' && ! $staff->is_active;

        $shiftTimes = $this->shiftTimes($request->shift_schedule);

        $isOnLeave = $request->boolean('is_on_leave');

        $staff->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'role'           => $request->role,
            'contact_number' => $request->contact_number,
            'shift_schedule' => $request->shift_schedule,
            'shift_start'    => $shiftTimes['shift_start'],
            'shift_end'      => $shiftTimes['shift_end'],
            'duty_status'    => ($isOnLeave && (!$request->leave_start || $request->leave_start <= $today)) ? 'off_duty' : ($request->duty_status ?? $staff->duty_status),
            'is_on_leave'    => $isOnLeave,
            'leave_start'    => $isOnLeave ? $request->leave_start : null,
            'leave_end'      => $isOnLeave ? $request->leave_end   : null,
            'leave_note'     => $isOnLeave ? $request->leave_note  : null,
            'is_active'      => $request->is_active,
            'inactivated_at' => $isBeingDeactivated ? now() : ($isBeingReactivated ? null : $staff->inactivated_at),
        ]);

        if ($isBeingDeactivated) {
            $this->terminateActiveSessions($staff);
        }

        $message = $isBeingReactivated
            ? $staff->first_name . ' ' . $staff->last_name . '\'s account has been reactivated.'
            : 'Staff details updated successfully.';

        return redirect()->route('staff.index')
            ->with('success', $message)
            ->with('edit_staff_id', $staff->staff_id);
    }

    public function resetPassword($id)
    {
        $staff = Staff::findOrFail($id);

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $suffix = '';
        for ($i = 0; $i < 6; $i++) {
            $suffix .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $tempPassword = 'Staff@' . $suffix;

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

    public function reactivate($id)
    {
        $staff = Staff::findOrFail($id);

        if ($staff->is_active) {
            return redirect()->route('staff.index')->with('success', 'Staff is already active.');
        }

        $staff->update([
            'is_active'      => true,
            'inactivated_at' => null,
        ]);

        return redirect()->route('staff.index')
            ->with('success', $staff->first_name . ' ' . $staff->last_name . '\'s account has been reactivated.');
    }

    private function terminateActiveSessions(Staff $staff): void
    {
        $staff->updateQuietly(['duty_status' => 'off_duty']);

        StaffAttendance::where('staff_id', $staff->staff_id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()
            ?->update(['logout_at' => now()]);

        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', $staff->staff_id)
                ->delete();
        }
    }

    public function clearAttendance()
    {
        $count = StaffAttendance::count();
        StaffAttendance::truncate();

        return response()->json([
            'success' => true,
            'message' => "Cleared {$count} attendance record(s).",
        ]);
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        $name = "{$staff->first_name} {$staff->last_name}";

        ArchivedStaff::create([
            'original_staff_id' => $staff->original_staff_id ?? $staff->staff_id,
            'account_id'        => $staff->account_id,
            'staff_code'        => $staff->staff_code,
            'first_name'        => $staff->first_name,
            'last_name'         => $staff->last_name,
            'email'             => $staff->email,
            'role'              => $staff->role,
            'contact_number'    => $staff->contact_number,
            'shift_schedule'    => $staff->shift_schedule,
            'duty_status'       => $staff->duty_status,
            'is_on_leave'       => $staff->is_on_leave,
            'leave_start'       => $staff->leave_start,
            'leave_end'         => $staff->leave_end,
            'leave_note'        => $staff->leave_note,
            'is_active'         => $staff->is_active,
            'archived_at'       => now(),
        ]);

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', "{$name} has been removed.");
    }
}
