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
            'email' => 'required|email|max:255',
        ]);

        $email = trim(strtolower($request->email));

        $staff = Staff::where('email', $email)
            ->whereIn('role', ['admin', 'secretary'])
            ->where('is_active', true)
            ->first();

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'If that email belongs to an active admin account, you may proceed.',
            ]);
        }

        session(['fp_verified_email' => $email]);

        return response()->json(['success' => true]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('fp_verified_email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please start the reset process again.',
            ]);
        }

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

        session()->forget('fp_verified_email');

        return response()->json(['success' => true]);
    }
}