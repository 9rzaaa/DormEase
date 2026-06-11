<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = trim(strtolower($request->email));

        $staff = Staff::where('email', $email)
            ->whereIn('role', ['admin', 'secretary'])
            ->where('is_active', true)
            ->first();

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'No active admin account found with that email address.',
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = trim(strtolower($request->email));

        $staff = Staff::where('email', $email)
            ->whereIn('role', ['admin', 'secretary'])
            ->where('is_active', true)
            ->first();

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ]);
        }

        if (Hash::check($request->password, $staff->password_hash)) {
            return response()->json([
                'success'       => false,
                'same_password' => true,
                'message'       => 'This is your current password. Please choose a different one.',
            ]);
        }

        $staff->updateQuietly([
            'password_hash'    => Hash::make($request->password),
            'is_temp_password' => false,
        ]);

        return response()->json(['success' => true]);
    }
}