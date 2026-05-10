<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'account_id' => 'required|string',
            'password'   => 'required|string',
        ]);

        $tenant = Tenant::where('account_id', $request->account_id)
            ->where('is_active', 1)
            ->first();

        if (!$tenant || !Hash::check($request->password, $tenant->password_hash)) {
            return response()->json([
                'message' => 'Invalid Account ID or password.'
            ], 401);
        }

        // ✅ Update status to active + record last login time
        $tenant->update([
            'status'        => 'active',
            'last_login_at' => now(),
        ]);

        $token = $tenant->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'               => $tenant->tenant_id,
                'account_id'       => $tenant->account_id,
                'name'             => $tenant->first_name . ' ' . $tenant->last_name,
                'email'            => $tenant->email,
                'room'             => $tenant->room_number,
                'is_temp_password' => $tenant->is_temp_password, // ✅ useful for mobile
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
