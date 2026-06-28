<?php

namespace App\Http\Middleware;

use App\Models\StaffAttendance;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStaffAccountIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff && ! ($staff->is_active ?? false)) {
            $staff->updateQuietly(['duty_status' => 'off_duty']);

            StaffAttendance::where('staff_id', $staff->staff_id)
                ->whereNull('logout_at')
                ->latest('login_at')
                ->first()
                ?->update(['logout_at' => now()]);

            Auth::guard('staff')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your account has been deactivated. Please log in again.',
                ], 401);
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been deactivated. Please contact your administrator to reactivate your account.',
            ]);
        }

        return $next($request);
    }
}
