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
        $visitors = $this->formatVisitorLogs(VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('arrival_time')
            ->get());
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
        $visitors = $this->formatVisitorLogs(VisitorLog::with(['tenant', 'staff'])
            ->orderByDesc('arrival_time')
            ->get());
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
            'arrival_time' => 'nullable|date',
            'status'       => 'nullable|string|max:20',
        ]);

        $arrivalTime = $request->filled('arrival_time')
            ? Carbon::parse($request->arrival_time)
            : now();

        VisitorLog::create([
            'visitor_name'  => $request->visitor_name,
            'tenant_id'     => $request->tenant_id,
            'confirmed_by'  => Auth::guard('staff')->id(),
            'purpose'       => $request->purpose,
            'contact_no'    => $request->contact_no,
            'id_type'       => $request->id_type,
            'date_of_visit' => $arrivalTime->toDateString(),
            'time_of_visit' => $arrivalTime->format('H:i:s'),
            'arrival_time'  => $arrivalTime,
            'status'        => $request->status ?? 'inside',
        ]);

        return redirect()->back()
            ->with('success', 'Visitor logged successfully.');
    }

    public function checkout(Request $request, $id)
    {
        $request->validate([
            'departure_time' => 'nullable|date',
        ]);

        $visitor = VisitorLog::findOrFail($id);
        if ($visitor->departure_time) {
            return back()->with('error', 'Visitor has already checked out.');
        }

        $visitor->update([
            'departure_time' => $request->departure_time ?? now(),
            'confirmed_by'   => $visitor->confirmed_by ?: Auth::guard('staff')->id(),
            'status'         => 'completed',
        ]);

        return back()->with('success', 'Visitor checked out successfully.');
    }

    public function timein(Request $request, $id)
    {
        $request->validate([
            'arrival_time' => 'required|date',
        ]);

        $visitor = VisitorLog::findOrFail($id);

        $visitor->update([
            'arrival_time'  => $request->arrival_time,
            'date_of_visit' => Carbon::parse($request->arrival_time)->toDateString(),
            'time_of_visit' => Carbon::parse($request->arrival_time)->format('H:i:s'),
            'confirmed_by'  => Auth::guard('staff')->id(),
            'status'        => 'inside',
        ]);

        return back()->with('success', 'Visitor time in logged successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,inside,completed',
        ]);

        VisitorLog::findOrFail($id)->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Visitor status updated successfully.');
    }

    private function formatVisitorLogs($visitors)
    {
        return $visitors->map(function (VisitorLog $visitor) {
            $data = $visitor->toArray();

            $data['id'] = $visitor->visitor_id;

            if ($visitor->tenant) {
                $tenantName = trim($visitor->tenant->first_name . ' ' . $visitor->tenant->last_name);
                $data['tenant'] = array_merge($visitor->tenant->toArray(), [
                    'name'      => $tenantName,
                    'full_name' => $tenantName,
                ]);
            }

            if ($visitor->staff) {
                $staffName = trim($visitor->staff->first_name . ' ' . $visitor->staff->last_name);
                $data['staff'] = array_merge($visitor->staff->toArray(), [
                    'name'      => $staffName,
                    'full_name' => $staffName,
                ]);
            }

            return $data;
        })->values();
    }
}
