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