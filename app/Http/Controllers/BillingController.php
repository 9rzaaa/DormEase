<?php

namespace App\Http\Controllers;

use App\Models\WaterBilling;
use App\Models\WaterRate;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m-01'));
        $selectedFloor = $request->get('floor', '');

        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date  = now()->startOfMonth()->subMonths($i);
            $value = $date->format('Y-m-d');
            $months[] = [
                'value'    => $value,
                'label'    => $date->format('F Y'),
                'selected' => $value === $selectedMonth,
            ];
        }

        $allTenants = Tenant::where('is_active', true)
            ->whereNotNull('floor')
            ->orderBy('floor')
            ->orderBy('room_number')
            ->get();

        $floors = $allTenants->pluck('floor')->unique()->sort()->values();

        $activeFloors = $floors;

        $loggedFloors = WaterBilling::whereYear('billing_month',  Carbon::parse($selectedMonth)->year)
            ->whereMonth('billing_month', Carbon::parse($selectedMonth)->month)
            ->distinct()
            ->pluck('floor');

        $unloggedFloors = $activeFloors->diff($loggedFloors)->values();

        $query = WaterBilling::with('tenant')
            ->whereYear('billing_month',  Carbon::parse($selectedMonth)->year)
            ->whereMonth('billing_month', Carbon::parse($selectedMonth)->month);

        if ($selectedFloor) {
            $query->where('floor', $selectedFloor);
        }

        $billings = $query->get()->keyBy('tenant_id');

        $totalBill    = $billings->sum('room_share');
        $totalTenants = $allTenants->count();
        $unpaidCount  = $billings->where('payment_status', 'unpaid')->count();
        $overdueCount = $billings->where('payment_status', 'overdue')->count();

        $tenantsByFloor = $allTenants->groupBy('floor');
        $billingGroups  = [];

        foreach ($tenantsByFloor as $floor => $floorTenants) {

            if ($selectedFloor && $floor != $selectedFloor) continue;

            $byRoom       = $floorTenants->groupBy('room_number');
            $rooms        = [];
            $pastDue      = 0;
            $floorTotal   = 0;

            $floorBilling = $billings->first(fn($b) => $b->floor == $floor);

            foreach ($byRoom as $roomNumber => $roomTenants) {

                $tenantRows = $roomTenants->map(function ($tenant) use ($billings) {
                    $billing       = $billings->get($tenant->tenant_id);
                    $paymentStatus = $billing
                        ? strtolower($billing->payment_status ?? 'unpaid')
                        : 'not billed';

                    return [
                        'billing_id'     => $billing?->billing_id ?? null,
                        'tenant_id'      => $tenant->tenant_id,
                        'name'           => trim($tenant->first_name . ' ' . $tenant->last_name),
                        'room_share'     => $billing?->room_share ?? 0,
                        'payment_status' => $paymentStatus,
                        'dot_class'      => match ($paymentStatus) {
                            'paid'       => 'dot-green',
                            'overdue'    => 'dot-red',
                            'not billed' => 'dot-gray',
                            default      => 'dot-orange',
                        },
                    ];
                })->values()->toArray();

                $hasPastDue = collect($tenantRows)
                    ->contains(fn($t) => in_array($t['payment_status'], ['unpaid', 'overdue']));

                if ($hasPastDue) $pastDue++;

                $floorTotal += collect($tenantRows)->sum('room_share');

                $rooms[] = [
                    'room_number'          => $roomNumber,
                    'floor'                => $floor,
                    'prev_reading'         => $floorBilling?->prev_reading         ?? 0,
                    'curr_reading'         => $floorBilling?->curr_reading         ?? 0,
                    'floor_consumption_m3' => $floorBilling?->floor_consumption_m3 ?? 0,
                    'rooms_sharing'        => $floorBilling?->rooms_sharing        ?? 0,
                    'occupants_in_room'    => count($tenantRows),
                    'total_floor_bill'     => $floorBilling?->total_floor_bill     ?? 0,
                    'due_date'             => $floorBilling?->due_date
                        ? Carbon::parse($floorBilling->due_date)->format('M d, Y')
                        : '—',
                    'tenants'              => $tenantRows,
                ];
            }

            $billingGroups[] = [
                'floor'                => $floor,
                'submeter_label'       => "Floor {$floor} – Submeter #{$floor}",
                'floor_consumption_m3' => $floorBilling
                    ? number_format($floorBilling->floor_consumption_m3 ?? 0, 2)
                    : '0.00',
                'total_floor_bill'     => $floorTotal,
                'room_count'           => count($rooms),
                'past_due_count'       => $pastDue,
                'due_date'             => $floorBilling?->due_date
                    ? Carbon::parse($floorBilling->due_date)->format('M d, Y')
                    : '—',
                'rooms'                => $rooms,
            ];
        }

        return view('billing', compact(
            'billingGroups',
            'months',
            'floors',
            'totalBill',
            'unpaidCount',
            'overdueCount',
            'totalTenants',
            'allTenants',
            'selectedMonth',
            'selectedFloor',
            'activeFloors',
            'unloggedFloors'
        ));
    }
    public function log(Request $request)
    {
        $request->validate([
            'floor'         => 'required|integer|min:1',
            'billing_month' => 'required|date',
            'prev_reading'  => 'required|numeric|min:0|max:99999.99',
            'curr_reading'  => 'required|numeric|min:0|max:99999.99|gte:prev_reading',
            'rooms_sharing' => 'required|integer|min:1',
            'due_date'      => 'required|date',
        ]);

        $rate        = WaterRate::orderBy('effective_month', 'desc')->first();
        $consumption = $request->curr_reading - $request->prev_reading;
        $totalBill   = $consumption * ($rate?->rate_per_m3 ?? 0);

        $tenants = Tenant::where('is_active', true)
            ->where('floor', $request->floor)
            ->get();

        if ($tenants->isEmpty()) {
            return redirect()->back()
                ->withErrors(['floor' => 'No active tenants found on Floor ' . $request->floor . '.']);
        }

        $byRoom = $tenants->groupBy('room_number');

        WaterBilling::where('floor', $request->floor)
            ->whereYear('billing_month',  Carbon::parse($request->billing_month)->year)
            ->whereMonth('billing_month', Carbon::parse($request->billing_month)->month)
            ->delete();

        foreach ($tenants as $tenant) {
            $occupantsInRoom = $byRoom[$tenant->room_number]->count();
            $roomShare       = ($request->rooms_sharing > 0 && $occupantsInRoom > 0)
                ? $totalBill / $request->rooms_sharing / $occupantsInRoom
                : 0;

            WaterBilling::create([
                'tenant_id'            => $tenant->tenant_id,
                'rate_id'              => $rate?->rate_id,
                'inputted_by'          => Auth::guard('staff')->id(),
                'billing_month'        => $request->billing_month,
                'floor'                => $request->floor,
                'floor_consumption_m3' => $consumption,
                'prev_reading'         => $request->prev_reading,
                'curr_reading'         => $request->curr_reading,
                'total_floor_bill'     => $totalBill,
                'rooms_sharing'        => $request->rooms_sharing,
                'occupants_in_room'    => $occupantsInRoom,
                'room_share'           => $roomShare,
                'payment_status'       => 'unpaid',
                'due_date'             => $request->due_date,
            ]);
        }

        return redirect()->route('billing.index')
            ->with('success', "Floor {$request->floor} billing logged and distributed to {$tenants->count()} tenants.");
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'billing_ids' => 'required|array',
            'statuses'    => 'required|array',
        ]);

        $billingIds = $request->billing_ids;
        $statuses   = $request->statuses;

        if (count($billingIds) !== count($statuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Mismatched billing IDs and statuses.',
            ], 422);
        }

        foreach ($billingIds as $index => $billingId) {
            WaterBilling::where('billing_id', (int) $billingId)
                ->update(['payment_status' => $statuses[$index]]);
        }

        return response()->json(['success' => true]);
    }
    public function updateFull(Request $request)
    {
        $request->validate([
            'billing_id'        => 'required|integer',
            'prev_reading'      => 'required|numeric|min:0',
            'curr_reading'      => 'required|numeric|min:0|gte:prev_reading',
            'rooms_sharing'     => 'required|integer|min:1',
            'occupants_in_room' => 'required|integer|min:1',
            'due_date'          => 'required|date',
            'payment_status'    => 'required|string',
        ]);

        $billing = WaterBilling::where('billing_id', $request->billing_id)->firstOrFail();
        $rate    = WaterRate::orderBy('effective_month', 'desc')->first();

        $consumption    = $request->curr_reading - $request->prev_reading;
        $totalFloorBill = $consumption * ($rate?->rate_per_m3 ?? 0);
        $roomShare      = $totalFloorBill / $request->rooms_sharing / $request->occupants_in_room;

        $billing->update([
            'prev_reading'         => $request->prev_reading,
            'curr_reading'         => $request->curr_reading,
            'floor_consumption_m3' => $consumption,
            'total_floor_bill'     => $totalFloorBill,
            'rooms_sharing'        => $request->rooms_sharing,
            'occupants_in_room'    => $request->occupants_in_room,
            'room_share'           => $roomShare,
            'due_date'             => $request->due_date,
            'payment_status'       => $request->payment_status,
        ]);

        return response()->json(['success' => true, 'room_share' => $roomShare]);
    }
}