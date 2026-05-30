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
        $staff = Staff::where('email', $request->email)
            ->where('role', 'admin')
            ->where('is_active', true)
            ->first();
        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'No active admin account found with that email address.',
            ], 404);
        }
        return response()->json(['success' => true]);
    }
    public function reset(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        $staff = Staff::where('email', $request->email)
            ->where('role', 'admin')
            ->where('is_active', true)
            ->first();
        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ], 404);
        }
        if (Hash::check($request->password, $staff->password_hash)) {
            return response()->json([
                'success'       => false,
                'same_password' => true,
                'message'       => 'This is your current password. Please choose a different one.',
            ]);
        }
        $staff->update([
            'password_hash'    => Hash::make($request->password),
            'is_temp_password' => false,
        ]);
        return response()->json(['success' => true]);
    }
}