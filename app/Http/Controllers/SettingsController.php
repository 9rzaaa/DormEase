<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        $defaultPrefs = [
            'maintenance_new'    => true,
            'emergency_new'      => true,
            'visitor_checkin'    => false,
            'visitor_checkout'   => false,
            'billing_overdue'    => true,
            'document_request'   => true,
            'announcement_new'   => false,
        ];

        $notifPrefs = $defaultPrefs;
        if (!empty($staff->notification_preferences)) {
            $saved = is_array($staff->notification_preferences)
                ? $staff->notification_preferences
                : json_decode($staff->notification_preferences, true);
            $notifPrefs = array_merge($defaultPrefs, $saved ?? []);
        }

        return view('settings', compact('staff', 'notifPrefs'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email'            => 'required|email|max:255',
            'current_password' => 'required|string',
        ]);

        $staff = Auth::guard('staff')->user();

        if (!Hash::check($request->current_password, $staff->password_hash)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->with('open_tab', 'account')
                ->withInput();
        }

        $exists = \App\Models\Staff::where('email', $request->email)
            ->where('staff_id', '!=', $staff->staff_id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['email' => 'That email is already in use.'])
                ->with('open_tab', 'account')
                ->withInput();
        }

        $staff->email = $request->email;
        $staff->save();

        return back()
            ->with('success', 'Email updated successfully.')
            ->with('open_tab', 'account');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $staff = Auth::guard('staff')->user();

        if (!Hash::check($request->current_password, $staff->password_hash)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->with('open_tab', 'account')
                ->withInput();
        }

        $staff->password_hash = Hash::make($request->new_password);
        $staff->save();

        return back()
            ->with('success', 'Password updated successfully.')
            ->with('open_tab', 'account');
    }

    public function updateNotifications(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $keys = [
            'maintenance_new',
            'emergency_new',
            'visitor_checkin',
            'visitor_checkout',
            'billing_overdue',
            'document_request',
            'announcement_new',
        ];

        $prefs = [];
        foreach ($keys as $key) {
            $prefs[$key] = $request->boolean($key);
        }

        $staff->notification_preferences = json_encode($prefs);
        $staff->save();

        return back()
            ->with('success', 'Notification preferences saved.')
            ->with('open_tab', 'notifications');
    }
}