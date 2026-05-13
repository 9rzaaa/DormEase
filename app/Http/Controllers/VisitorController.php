<?php

namespace App\Http\Controllers;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    /**
     * GET /visitors
     * Admin sees ALL visitor logs with tenant + staff names.
     */
    public function index()
    {
        $logs = VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('date_of_visit')
            ->orderByDesc('visitor_id')
            ->get();

        // Visitors today = expected visits for today (date_of_visit, not arrival_time)
        $visitorsToday = VisitorLog::whereDate('date_of_visit', today())->count();

        // Currently inside = checked in (arrival_time set) but not yet checked out
        $currentlyInside = VisitorLog::whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->count();

        return view('visitors', compact('logs', 'visitorsToday', 'currentlyInside'));
    }

    /**
     * PATCH /visitors/{visitor}/check-in
     * Front desk checks a visitor in — sets arrival_time and confirmed_by.
     */
    public function checkIn(VisitorLog $visitor)
    {
        if ($visitor->arrival_time) {
            return back()->with('error', 'Visitor has already checked in.');
        }

        $visitor->update([
            'arrival_time'  => now(),
            'confirmed_by'  => Auth::id(),  // the staff member who confirmed them
            'status'        => 'inside',
        ]);

        return back()->with('success', 'Visitor checked in.');
    }

    /**
     * PATCH /visitors/{visitor}/check-out
     * Front desk checks a visitor out.
     */
    public function checkOut(VisitorLog $visitor)
    {
        if (! $visitor->arrival_time) {
            return back()->with('error', 'Visitor has not checked in yet.');
        }

        if ($visitor->departure_time) {
            return back()->with('error', 'Visitor has already checked out.');
        }

        $visitor->update([
            'departure_time' => now(),
            'status'         => 'completed',
        ]);

        return back()->with('success', 'Visitor checked out.');
    }
}