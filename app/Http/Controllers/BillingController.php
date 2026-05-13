<?php

namespace App\Http\Controllers;

use App\Models\WaterBilling;
use App\Models\WaterRate;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // After building $months array, also ensure the selectedMonth has an entry:
        $selectedCarbon = Carbon::parse($selectedMonth);
        $monthExists = collect($months)->contains('value', $selectedMonth);
        if (!$monthExists) {
            array_unshift($months, [
                'value'    => $selectedMonth,
                'label'    => $selectedCarbon->format('F Y'),
                'selected' => true,
            ]);
            // Re-mark selected
            $months = array_map(function ($m) use ($selectedMonth) {
                $m['selected'] = $m['value'] === $selectedMonth;
                return $m;
            }, $months);
        }

        $allTenants = Tenant::where('is_active', true)
            ->whereNotNull('floor')
            ->orderBy('floor')
            ->orderBy('room_number')
            ->get();

        $floors       = $allTenants->pluck('floor')->unique()->sort()->values();
        $activeFloors = $floors;

        $loggedFloors = WaterBilling::whereYear('billing_month', Carbon::parse($selectedMonth)->year)
            ->whereMonth('billing_month', Carbon::parse($selectedMonth)->month)
            ->distinct()
            ->pluck('floor');

        $unloggedFloors = $activeFloors->diff($loggedFloors)->values();

        $billings = WaterBilling::with('tenant')
            ->whereYear('billing_month', Carbon::parse($selectedMonth)->year)
            ->whereMonth('billing_month', Carbon::parse($selectedMonth)->month)
            ->get()
            ->keyBy('tenant_id');

        $totalBill    = $billings->sum('room_share');
        $totalTenants = $allTenants->count();
        $unpaidCount  = $billings->where('payment_status', 'unpaid')->count();
        $overdueCount = $billings->where('payment_status', 'overdue')->count();

        $billingGroups = [];

        foreach ($allTenants->groupBy('floor') as $floor => $floorTenants) {

            if ($selectedFloor && $floor != $selectedFloor) continue;

            $rooms = [];
            $pastDue = 0;

            $floorBilling = $billings->first(fn($b) => $b->floor == $floor);

            foreach ($floorTenants->groupBy('room_number') as $roomNumber => $roomTenants) {

                $tenantRows = $roomTenants->map(function ($tenant) use ($billings) {

                    $billing = $billings->get($tenant->tenant_id);

                    $paymentStatus = $billing
                        ? strtolower($billing->payment_status ?? 'unpaid')
                        : 'not billed';

                    return [
                        'billing_id'     => $billing?->billing_id,
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

                if (collect($tenantRows)->contains(fn($t) => in_array($t['payment_status'], ['unpaid', 'overdue']))) {
                    $pastDue++;
                }

                $rooms[] = [
                    'room_number'          => $roomNumber,
                    'floor'                => $floor,
                    'prev_reading'         => $floorBilling?->prev_reading ?? 0,
                    'curr_reading'         => $floorBilling?->curr_reading ?? 0,
                    'floor_consumption_m3' => $floorBilling?->floor_consumption_m3 ?? 0,
                    'rooms_sharing'        => $floorBilling?->rooms_sharing ?? 0,
                    'occupants_in_room'    => count($tenantRows),
                    'total_floor_bill'     => $floorBilling?->total_floor_bill ?? 0,
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
                'total_floor_bill'     => collect($rooms)->sum(
                    fn($r) =>
                    collect($r['tenants'])->sum('room_share')
                ),
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
            'billing_month'          => 'required|date',
            'due_date'               => 'required|date',
            'maynilad_total_m3'      => 'required|numeric|min:0.01',
            'maynilad_total_amount'  => 'required|numeric|min:0.01',
            'floor_readings'         => 'required|array|min:1',
            'floor_readings.*.floor' => 'required|integer|min:1',
            'floor_readings.*.prev'  => 'required|numeric|min:0',
            'floor_readings.*.curr'  => 'required|numeric|min:0|gte:floor_readings.*.prev',
        ]);

        $billingMonthDate = Carbon::parse($request->billing_month)->startOfMonth();

        $ratePerM3 = $request->maynilad_total_amount / $request->maynilad_total_m3;

        DB::transaction(function () use ($request, $billingMonthDate, $ratePerM3) {

            $rate = WaterRate::updateOrCreate(
                ['effective_month' => $billingMonthDate->format('Y-m-01')],
                ['rate_per_m3' => round($ratePerM3, 4)]
            );

            foreach ($request->floor_readings as $entry) {

                $floor = (int) $entry['floor'];
                $prev  = (float) $entry['prev'];
                $curr  = (float) $entry['curr'];

                $consumption = max(0, $curr - $prev);
                $totalFloorBill = round($consumption * $ratePerM3, 2);

                $tenants = Tenant::where('is_active', true)
                    ->where('floor', $floor)
                    ->get();

                if ($tenants->isEmpty()) continue;

                $perTenantShare = round($totalFloorBill / $tenants->count(), 2);

                WaterBilling::where('floor', $floor)
                    ->whereYear('billing_month', $billingMonthDate->year)
                    ->whereMonth('billing_month', $billingMonthDate->month)
                    ->delete();

                foreach ($tenants as $tenant) {
                    WaterBilling::create([
                        'tenant_id'            => $tenant->tenant_id,
                        'rate_id'              => $rate->rate_id,
                        'inputted_by'          => Auth::guard('staff')->id(),
                        'billing_month'        => $billingMonthDate,
                        'floor'                => $floor,
                        'floor_consumption_m3' => $consumption,
                        'prev_reading'         => $prev,
                        'curr_reading'         => $curr,
                        'total_floor_bill'     => $totalFloorBill,
                        'rooms_sharing'        => $tenants->count(),
                        'occupants_in_room'    => 1,
                        'room_share'           => $perTenantShare,
                        'payment_status'       => 'unpaid',
                        'due_date'             => $request->due_date,
                    ]);
                }
            }
        });

        $message = "Water billing logged successfully.";

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'billing_ids' => 'required|array',
            'statuses'    => 'required|array',
        ]);

        foreach ($request->billing_ids as $i => $id) {
            WaterBilling::where('billing_id', $id)
                ->update(['payment_status' => $request->statuses[$i]]);
        }

        return response()->json(['success' => true]);
    }

    public function updateFull(Request $request)
    {
        $request->validate([
            'billing_id'     => 'required|integer',
            'prev_reading'   => 'required|numeric|min:0',
            'curr_reading'   => 'required|numeric|min:0|gte:prev_reading',
            'due_date'       => 'required|date',
            'payment_status' => 'required|string',
        ]);

        $billing = WaterBilling::findOrFail($request->billing_id);

        $rate = WaterRate::where('effective_month', Carbon::parse($billing->billing_month)->format('Y-m-01'))
            ->first();

        $ratePerM3 = $rate?->rate_per_m3 ?? 0;

        $consumption = max(0, $request->curr_reading - $request->prev_reading);
        $total = round($consumption * $ratePerM3, 2);

        $count = WaterBilling::where('floor', $billing->floor)
            ->whereYear('billing_month', Carbon::parse($billing->billing_month)->year)
            ->whereMonth('billing_month', Carbon::parse($billing->billing_month)->month)
            ->count();

        $share = $count ? round($total / $count, 2) : 0;

        WaterBilling::where('floor', $billing->floor)
            ->whereYear('billing_month', Carbon::parse($billing->billing_month)->year)
            ->whereMonth('billing_month', Carbon::parse($billing->billing_month)->month)
            ->update([
                'prev_reading'         => $request->prev_reading,
                'curr_reading'         => $request->curr_reading,
                'floor_consumption_m3' => $consumption,
                'total_floor_bill'     => $total,
                'room_share'           => $share,
                'due_date'             => $request->due_date,
            ]);

        $billing->update(['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'room_share' => $share
        ]);
    }
}
