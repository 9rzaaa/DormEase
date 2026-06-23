<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ]);

        $identifier  = trim($request->identifier);
        $throttleKey = 'login-attempts:' . Str::lower($identifier);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);
            return response()->json([
                'message' => "Too many failed login attempts. Your account has been temporarily locked. Please try again in {$minutes} minutes."
            ], 429);
        }

        $tenant = Tenant::where('account_id', $identifier)->first();

        if (!$tenant) {
            $isStaff = Staff::where('account_id', $identifier)
                ->orWhere('staff_code', $identifier)
                ->exists();

            if ($isStaff) {
                return response()->json([
                    'message' => 'Access denied. Admin and staff accounts cannot log in to the mobile application.'
                ], 403);
            }

            return response()->json(['message' => 'The Account ID you entered is not registered.'], 404);
        }

        if ($tenant->status === 'inactive' || !$tenant->is_active) {
            return response()->json([
                'message' => 'Your account has been deactivated. Please visit the admin office for reactivation.'
            ], 403);
        }

        if ($tenant->status === 'reserved') {
            return response()->json([
                'message' => 'Your account is currently in reserved status. You will be able to log in once your stay period begins.'
            ], 403);
        }

        if ($tenant->status === 'move_out') {
            return response()->json([
                'message' => 'Your account is inactive because you have checked out/moved out.'
            ], 403);
        }

        if (!Hash::check($request->password, $tenant->password_hash)) {
            RateLimiter::hit($throttleKey, 900);

            $retriesLeft = RateLimiter::retriesLeft($throttleKey, 5);
            if ($retriesLeft > 0) {
                return response()->json([
                    'message' => "Invalid password. You have {$retriesLeft} attempt(s) remaining before your account is locked."
                ], 401);
            } else {
                $seconds = RateLimiter::availableIn($throttleKey);
                $minutes = ceil($seconds / 60);
                return response()->json([
                    'message' => "Too many failed login attempts. Your account has been temporarily locked. Please try again in {$minutes} minutes."
                ], 429);
            }
        }

        RateLimiter::clear($throttleKey);

        if ($tenant->status === 'pending') {
            $tenant->markAccessed();
        } else {
            $tenant->update(['status' => 'active']);
        }
        $tenant->update(['last_login_at' => now()]);

        $token = $tenant->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'               => $tenant->tenant_id,
                'account_id'       => $tenant->account_id,
                'name'             => $tenant->first_name . ' ' . $tenant->last_name,
                'email'            => $tenant->email,
                'room'             => $tenant->room_number,
                'floor'            => $tenant->floor,
                'is_temp_password' => $tenant->is_temp_password,
                'role'             => 'tenant',
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
