<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    private function getStaff()
    {
        return Auth::guard('staff')->user();  // ← was using session('staff_id'), which was always null
    }

    public function index()
    {
        $staff = $this->getStaff();

        if (! $staff) {
            return redirect('/login')->with('error', 'Please log in first.');
        }

        return view('profile', compact('staff'));
    }

    public function update(Request $request)
    {
        $staff = $this->getStaff();

        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|max:150|unique:staff,email,' . $staff->staff_id . ',staff_id',
            'contact_number' => 'nullable|string|max:30',
        ]);

        $staff->first_name     = $request->first_name;
        $staff->last_name      = $request->last_name;
        $staff->email          = $request->email;
        $staff->contact_number = $request->contact_number;
        $staff->save();

        return redirect()->route('profile.index')
                         ->with('success', 'Profile updated successfully!');
    }

    public function password(Request $request)
    {
        $staff = $this->getStaff();

        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (! Hash::check($request->current_password, $staff->password_hash)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $staff->password_hash = Hash::make($request->password);
        $staff->save();

        return redirect()->route('profile.index')
                         ->with('success', 'Password updated successfully!');
    }

    public function deactivate()
    {
        $staff = $this->getStaff();

        $staff->is_active = false;
        $staff->save();

        Auth::guard('staff')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')
                ->with('success', 'Your account has been deactivated.');
    }
}