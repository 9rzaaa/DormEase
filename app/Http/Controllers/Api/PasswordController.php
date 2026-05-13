<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function change(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $tenant = $request->user();

        if (!Hash::check($request->current_password, $tenant->password_hash)) {
            return response()->json([
                'message' => 'Current password is incorrect.'
            ], 422);
        }

        $tenant->update([
            'password_hash'    => Hash::make($request->new_password),
            'is_temp_password' => false,
        ]);

        return response()->json([
            'message' => 'Password changed successfully.'
        ]);
    }
}
