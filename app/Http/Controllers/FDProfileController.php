<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        if (!Hash::check($request->current_password, $staff->password_hash)) {
            return back()
                ->with('error', 'Current password is incorrect.')
                ->with('prompt_temp_password', true);
        }
        $staff->update([
            'password_hash'    => Hash::make($request->password),
            'is_temp_password' => false,
        ]);
        session()->forget('prompt_temp_password');
        return back()->with('success', 'Password updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $staff = auth('staff')->user();
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($staff->profile_picture) {
            Storage::disk('public')->delete($staff->profile_picture);
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $staff->update(['profile_picture' => $path]);
        return back()->with('success', 'Profile picture updated.');
    }
}