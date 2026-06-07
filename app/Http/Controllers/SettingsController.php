<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $archiveSettings = \App\Models\ArchiveSetting::all()->keyBy('module');

        return view('settings', compact('staff', 'notifPrefs', 'archiveSettings'));
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

    public function frontdeskIndex()
    {
        $staff = Auth::guard('staff')->user();

        $defaultPrefs = [
            'emergency_new'    => true,
            'visitor_registration' => true,
            'visitor_checkin'  => true,
            'visitor_checkout' => true,
            'announcement_new' => true,
        ];

        $notifPrefs = $defaultPrefs;
        if (!empty($staff->notification_preferences)) {
            $saved = is_array($staff->notification_preferences)
                ? $staff->notification_preferences
                : json_decode($staff->notification_preferences, true);
            $notifPrefs = array_merge($defaultPrefs, $saved ?? []);
        }

        return view('fdsettings', compact('staff', 'notifPrefs'));
    }

    public function frontdeskUpdateNotifications(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $keys = [
            'emergency_new',
            'visitor_registration',
            'visitor_checkin',
            'visitor_checkout',
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
