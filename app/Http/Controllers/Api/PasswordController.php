<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function change(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
                function ($attribute, $value, $fail) use ($request) {
                    if (Hash::check($value, $request->user()->password_hash)) {
                        $fail('The new password must be different from your current password.');
                    }
                }
            ],
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

