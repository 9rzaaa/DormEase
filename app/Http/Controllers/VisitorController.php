<?php
namespace App\Http\Controllers;
use App\Models\VisitorLog;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class VisitorController extends Controller
{
    public function index()
    {
        $visitors = VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('arrival_time')
            ->get();
        $visitorsToday   = VisitorLog::whereDate('arrival_time', Carbon::today())->count();
        $currentlyInside = VisitorLog::whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->count();
        $tenants = Tenant::where('is_active', true)
            ->orderBy('first_name')
            ->get();
        return view('fdvisitors', compact(
            'visitors',
            'visitorsToday',
            'currentlyInside',
            'tenants'
        ));
    }

    public function adminIndex()
    {
        $visitors = VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('arrival_time')
            ->get();
        $visitorsToday   = VisitorLog::whereDate('arrival_time', Carbon::today())->count();
        $currentlyInside = VisitorLog::whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->count();
        $tenants = Tenant::where('is_active', true)
            ->orderBy('first_name')
            ->get();
        return view('visitors', [
            'visitors'        => $visitors,
            'logs'            => $visitors,
            'visitorsToday'   => $visitorsToday,
            'currentlyInside' => $currentlyInside,
            'tenants'         => $tenants,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:100',
            'tenant_id'    => 'required|exists:tenants,tenant_id',
            'purpose'      => 'required|string|max:100',
            'contact_no'   => 'nullable|string|max:20',
            'id_type'      => 'nullable|string|max:50',
            'status'       => 'nullable|string|max:20',
        ]);
        VisitorLog::create([
            'visitor_name'  => $request->visitor_name,
            'tenant_id'     => $request->tenant_id,
            'confirmed_by'  => Auth::guard('staff')->id(),
            'purpose'       => $request->purpose,
            'contact_no'    => $request->contact_no,
            'id_type'       => $request->id_type,
            'date_of_visit' => Carbon::today(),
            'arrival_time'  => now(),
            'status'        => $request->status ?? 'approved',
        ]);
        return redirect()->route('visitors.index')
            ->with('success', 'Visitor logged successfully.');
    }

    public function checkout($id)
    {
        $visitor = VisitorLog::findOrFail($id);
        if ($visitor->departure_time) {
            return back()->with('error', 'Visitor has already checked out.');
        }
        $visitor->update([
            'departure_time' => now(),
            'status'         => 'completed',
        ]);
        return redirect()->route('visitors.index')
            ->with('success', 'Visitor checked out successfully.');
    }
}