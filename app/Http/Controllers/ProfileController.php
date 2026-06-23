<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $staff = auth('staff')->user();
        return view('profile', compact('staff'));
    }

    public function update(Request $request)
    {
        $staff = auth('staff')->user();
        if ($request->filled('contact_number')) {
            $request->merge([
                'contact_number' => preg_replace('/\D/', '', $request->contact_number),
            ]);
        }
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:staff,email,' . $staff->staff_id . ',staff_id',
            'contact_number' => ['nullable', 'regex:/^09\d{9}$/'],
        ], [
            'contact_number.regex' => 'Contact number must be 11 digits and start with 09 (e.g. 09123456789).',
        ]);

        $staff->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number ? preg_replace('/\D/', '', $request->contact_number) : null,
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
            return back()->with('error', 'Current password is incorrect.');
        }

        $staff->update(['password_hash' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $staff = auth('staff')->user();
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file     = $request->file('avatar');
        $mime     = $file->getMimeType();
        $base64   = base64_encode(file_get_contents($file->getRealPath()));
        $dataUrl  = "data:{$mime};base64,{$base64}";
        $staff->update(['profile_picture' => $dataUrl]);
        return back()->with('success', 'Profile picture updated.');
    }

    public function deactivate()
    {
        $staff = auth('staff')->user();

        $staff->update(['status' => 'inactive']);

        auth('staff')->logout();

        return redirect('/')->with('success', 'Account deactivated successfully.');
    }
}