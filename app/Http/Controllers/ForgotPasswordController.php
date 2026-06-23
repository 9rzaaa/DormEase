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

        session([
            'fp_verified_email' => $email,
            'fp_verified_at'    => now()->timestamp,
            'fp_master_verified' => false,
        ]);

        return response()->json([
            'success'               => true,
            'requires_master_password' => true,
        ]);
    }

    public function verifyMaster(Request $request)
    {
        $request->validate([
            'master_password' => 'required|string',
        ]);

        $email = session('fp_verified_email');
        $verifiedAt = session('fp_verified_at');

        if (!$email || !$verifiedAt || (now()->timestamp - $verifiedAt) > 900) {
            session()->forget(['fp_verified_email', 'fp_verified_at', 'fp_master_verified']);
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

        $masterInput = $request->master_password;

        $masterMatches = Hash::check($masterInput, $staff->master_password ?? '');

        $recoveryMatches = false;
        if (!$masterMatches && $staff->recovery_code) {
            $recoveryMatches = Hash::check($masterInput, $staff->recovery_code);
        }

        if (!$masterMatches && !$recoveryMatches) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect master password. If you forgot it, use your recovery code instead.',
            ]);
        }

        if ($recoveryMatches) {
            $staff->updateQuietly(['recovery_code' => null]);
        }

        session(['fp_master_verified' => true]);

        return response()->json(['success' => true]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email         = session('fp_verified_email');
        $verifiedAt    = session('fp_verified_at');
        $masterVerified = session('fp_master_verified');

        if (!$email || !$verifiedAt || (now()->timestamp - $verifiedAt) > 900) {
            session()->forget(['fp_verified_email', 'fp_verified_at', 'fp_master_verified']);
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please start the reset process again.',
            ]);
        }

        if (!$masterVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Master password verification required before resetting your password.',
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

        session()->forget(['fp_verified_email', 'fp_verified_at', 'fp_master_verified']);

        return response()->json(['success' => true]);
    }
}