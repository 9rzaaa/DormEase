<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FDProfileController extends Controller
{
    public function index()
    {
        $staff = auth('staff')->user();

        return view('fdprofile', compact('staff'));
    }

    public function updateInfo(Request $request)
    {
        $staff = auth('staff')->user();

        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:staff,email,' . $staff->staff_id . ',staff_id',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $staff->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $staff = auth('staff')->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $staff->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $staff->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function deactivate()
    {
        $staff = auth('staff')->user();

        $staff->update([
            'status' => 'inactive',
        ]);

        auth('staff')->logout();

        return redirect('/')->with('success', 'Account deactivated successfully.');
    }
}