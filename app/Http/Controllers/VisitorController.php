<?php

namespace App\Http\Controllers;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    public function index()
    {
        $logs = VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('date_of_visit')
            ->orderByDesc('visitor_id')
            ->get()
            ->each(function ($v) {
                if ($v->tenant) {
                    $v->tenant->full_name = trim(
                        ($v->tenant->first_name ?? '') . ' ' . ($v->tenant->last_name ?? '')
                    ) ?: ($v->tenant->name ?? '—');
                }
                if ($v->staff) {
                    $v->staff->full_name = trim(
                        ($v->staff->first_name ?? '') . ' ' . ($v->staff->last_name ?? '')
                    ) ?: ($v->staff->name ?? '—');
                }
            });

        $visitorsToday = VisitorLog::whereDate('date_of_visit', today())->count();

        $currentlyInside = VisitorLog::whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->count();

        return view('visitors', compact('logs', 'visitorsToday', 'currentlyInside'));
    }

    public function checkIn(VisitorLog $visitor)
    {
        if ($visitor->arrival_time) {
            return back()->with('error', 'Visitor has already checked in.');
        }

        $visitor->update([
            'arrival_time' => now(),
            'confirmed_by' => Auth::id(),
            'status'       => 'inside',
        ]);

        return back()->with('success', 'Visitor checked in.');
    }

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