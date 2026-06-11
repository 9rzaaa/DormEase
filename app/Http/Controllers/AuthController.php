<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|max:255',
            'password' => 'required|string',
            'role'     => 'required|in:admin,frontdesk',
        ]);
        $credentials = $request->only('email', 'password');
        $submittedRole = $request->input('role');

        if (Auth::guard('staff')->attempt($credentials)) {
            $user = Auth::guard('staff')->user();

            if ($user->role !== $submittedRole) {
                Auth::guard('staff')->logout();
                return back()->withErrors([
                    'email' => 'Invalid role selected for this account.',
                ])->withInput($request->only('email'));
            }

            if (isset($user->is_active) && ! $user->is_active) {
                Auth::guard('staff')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Your account has been temporarily deactivated. Please contact your administrator to reactivate your account.',
                ])->withInput($request->only('email'));
            }

            if ($user->is_temp_password) {
                $request->session()->regenerate();
                return redirect('/change-password')
                    ->with('notice', 'You are using a temporary password. Please set a new one to continue.');
            }

            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/frontdesk/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }
}