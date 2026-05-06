<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:admin,frontdesk',
        ]);

        $staff = Staff::where('email', $request->email)
                      ->where('is_active', true)
                      ->first();

        if (!$staff || !Hash::check($request->password, $staff->password_hash)) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        if ($staff->role !== $request->role) {
            return back()
                ->withErrors(['email' => 'Access denied. You are not authorized for this portal.'])
                ->onlyInput('email');
        }

        Auth::guard('staff')->login($staff, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended('/staff/dashboard');
    }
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}