<?php

namespace App\Http\Controllers;

use App\Models\VisitorLog;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $logs = VisitorLog::with(['tenant', 'staff'])
            ->latest('arrival_time')
            ->get();

        $visitorsToday = VisitorLog::whereDate('arrival_time', today())
            ->count();

        $currentlyInside = VisitorLog::whereNull('departure_time')
            ->count();

        return view('visitors', [
            'logs' => $logs,
            'visitorsToday' => $visitorsToday,
            'currentlyInside' => $currentlyInside,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'contact_no'   => 'nullable|string|max:255',
            'purpose'      => 'nullable|string|max:255',
            'id_type'      => 'nullable|string|max:255',
            'tenant_id'    => 'nullable|exists:users,id',
        ]);

        VisitorLog::create([
            'visitor_name' => $request->visitor_name,
            'contact_no'   => $request->contact_no,
            'purpose'      => $request->purpose,
            'id_type'      => $request->id_type,

            'date_of_visit' => now()->toDateString(),

            'arrival_time' => now(),

            'status' => 'inside',

            'tenant_id' => $request->tenant_id,

            'staff_id' => auth()->id(),
        ]);

        return redirect()->back()
            ->with('success', 'Visitor logged successfully.');
    }

    public function checkout($id)
    {
        $visitor = VisitorLog::findOrFail($id);

        $visitor->update([
            'departure_time' => now(),
            'status' => 'approved',
        ]);

        return redirect()->back()
            ->with('success', 'Visitor checked out.');
    }
}