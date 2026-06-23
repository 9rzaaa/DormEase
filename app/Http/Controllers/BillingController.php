<?php

namespace App\Http\Controllers;

use App\Models\WaterBilling;
use App\Models\WaterRate;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Helpers\NotificationHelper;
use App\Services\TenantPushNotificationService;

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

        $selectedCarbon = Carbon::parse($selectedMonth);

        $monthExists = collect($months)->contains('value', $selectedMonth);

        if (!$monthExists) {
            array_unshift($months, [
                'value'    => $selectedMonth,
                'label'    => $selectedCarbon->format('F Y'),
                'selected' => true,
            ]);

            $months = array_map(function ($m) use ($selectedMonth) {
                $m['selected'] = $m['value'] === $selectedMonth;
                return $m;
            }, $months);
        }

        $allTenants = Tenant::whereIn('status', ['active', 'pending', 'inactive', 'reserved'])
            ->whereNotNull('floor')
            ->orderBy('floor')
            ->orderBy('room_number')
            ->get();

        $floors = $allTenants->pluck('floor')->unique()->sort()->values();

        $activeFloors = $allTenants->where('status', 'active')->pluck('floor')->unique()->sort()->values();

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

        $activeTenantIds = $allTenants->whereIn('status', ['active', 'pending'])->pluck('tenant_id');
        $totalBill    = number_format($billings->values()->unique('floor')->sum('total_floor_bill'), 2, '.', '');
        $totalTenants = $activeTenantIds->count();
        $unpaidCount  = $billings->whereIn('tenant_id', $activeTenantIds)->whereIn('payment_status', ['unpaid', 'overdue'])->count();
        $overdueCount = $billings->whereIn('tenant_id', $activeTenantIds)->where('payment_status', 'overdue')->count();
        $billingGroups = [];

        foreach ($allTenants->groupBy('floor') as $floor => $floorTenants) {

            if ($selectedFloor && $floor != $selectedFloor) {
                continue;
            }

            $rooms   = [];
            $pastDue = 0;

            $floorBilling = $billings->first(fn($b) => $b->floor == $floor);

            $isDueDatePassed = $floorBilling?->due_date
                ? Carbon::parse($floorBilling->due_date)->lt(now()->startOfDay())
                : false;

            foreach ($floorTenants->groupBy('room_number') as $roomNumber => $roomTenants) {

                $tenantRows = $roomTenants->map(function ($tenant) use ($billings) {

                    $billing = $billings->get($tenant->tenant_id);

                    if ($tenant->status === 'inactive') {
                        $paymentStatus = 'inactive-tenant';
                        $dotClass = 'dot-gray';
                    } else {
                        $paymentStatus = $billing
                            ? strtolower($billing->payment_status ?? 'unpaid')
                            : 'not billed';

                        $dotClass = match ($paymentStatus) {
                            'paid'       => 'dot-green',
                            'overdue'    => 'dot-red',
                            'rejected'   => 'dot-red',
                            'not billed' => 'dot-gray',
                            default      => 'dot-orange',
                        };
                    }

                    return [
                        'billing_id'             => $billing?->billing_id,
                        'tenant_id'              => $tenant->tenant_id,
                        'name'                   => trim($tenant->first_name . ' ' . $tenant->last_name),
                        'is_temp_password'       => (bool) $tenant->is_temp_password,
                        'room_share'             => number_format($billing?->room_share ?? 0, 2, '.', ''),
                        'payment_status'         => $paymentStatus,
                        'proof_of_payment'       => $billing?->proof_of_payment,
                        'proof_of_payment_url'   => $billing?->proof_of_payment
                            ? Storage::disk('public')->url($billing->proof_of_payment)
                            : null,
                        'payment_reference_code' => $billing?->payment_reference_code,
                        'payment_submitted_at'   => $billing?->payment_submitted_at
                            ? Carbon::parse($billing->payment_submitted_at)->format('M d, Y h:i A')
                            : null,
                        'rejection_reason'       => $billing?->rejection_reason,
                        'dot_class'              => $dotClass,
                    ];
                })->values()->toArray();

                if (
                    $isDueDatePassed
                    && collect($tenantRows)->contains(
                        fn($t) => in_array($t['payment_status'], ['unpaid', 'overdue'])
                    )
                ) {
                    $pastDue++;
                }

                $rooms[] = [
                    'room_number'          => $roomNumber,
                    'floor'                => $floor,
                    'prev_reading'         => $floorBilling?->prev_reading ?? 0,
                    'curr_reading'         => $floorBilling?->curr_reading ?? 0,
                    'floor_consumption_m3' => number_format($floorBilling?->floor_consumption_m3 ?? 0, 2, '.', ''),
                    'rooms_sharing'        => $floorBilling?->rooms_sharing ?? 0,
                    'occupants_in_room'    => collect($tenantRows)->where('payment_status', '!=', 'pending-tenant')->where('payment_status', '!=', 'inactive-tenant')->count(),
                    'total_floor_bill'     => number_format($floorBilling?->total_floor_bill ?? 0, 2, '.', ''),
                    'due_date'             => $floorBilling?->due_date
                        ? Carbon::parse($floorBilling->due_date)->format('M d, Y')
                        : '—',
                    'tenants' => $tenantRows,
                ];
            }

            $billingGroups[] = [
                'floor'                => $floor,
                'submeter_label'       => "Floor {$floor} - Submeter #{$floor}",
                'floor_consumption_m3' => $floorBilling
                    ? number_format($floorBilling->floor_consumption_m3 ?? 0, 2)
                    : '0.00',
                'total_floor_bill'     => number_format(collect($rooms)->sum(
                    fn($r) => collect($r['tenants'])->sum('room_share')
                ), 2, '.', ''),
                'room_count'     => count($rooms),
                'past_due_count' => $pastDue,
                'due_date'       => $floorBilling?->due_date
                    ? Carbon::parse($floorBilling->due_date)->format('M d, Y')
                    : '—',
                'rooms' => $rooms,
            ];
        }

        $prevMonth = Carbon::parse($selectedMonth)->subMonth();
        $lastMonthReadings = WaterBilling::whereYear('billing_month', $prevMonth->year)
            ->whereMonth('billing_month', $prevMonth->month)
            ->whereIn('floor', $activeFloors->all())
            ->get()
            ->groupBy('floor')
            ->map(fn($rows) => (float) ($rows->first()->curr_reading ?? 0));

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
            'unloggedFloors',
            'lastMonthReadings'
        ));
    }

    public function poll(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m-01'));
        $selectedFloor = $request->get('floor', '');

        $billings = WaterBilling::whereYear('billing_month', Carbon::parse($selectedMonth)->year)
            ->whereMonth('billing_month', Carbon::parse($selectedMonth)->month)
            ->when($selectedFloor !== '', fn($q) => $q->where('floor', $selectedFloor))
            ->get(['billing_id', 'payment_status', 'updated_at']);

        $signature = $billings->isEmpty()
            ? '0'
            : (string) $billings->count() . '-' . (string) $billings->max('updated_at');

        return response()->json([
            'signature' => $signature,
        ]);
    }

    public function log(Request $request)
    {
        try {
            if (!Auth::guard('staff')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff not authenticated.'
                ], 401);
            }

            $request->validate([
                'billing_month'          => 'required|date',
                'due_date'               => 'required|date|after_or_equal:billing_month',
                'maynilad_total_m3'      => 'required|numeric|min:0.01',
                'maynilad_total_amount'  => 'required|numeric|min:0.01',
                'floor_readings'         => 'required|array|min:1',
                'floor_readings.*.floor' => 'required|integer|min:1|distinct',
                'floor_readings.*.prev'  => 'required|numeric|min:0',
                'floor_readings.*.curr'  => 'required|numeric|min:0|gte:floor_readings.*.prev',
            ]);

            $billingMonthDate = Carbon::parse($request->billing_month)->startOfMonth();
            $ratePerM3        = $request->maynilad_total_amount / $request->maynilad_total_m3;
            $staffId          = Auth::guard('staff')->id();
            $readings         = collect($request->floor_readings)->map(function ($entry) {
                return [
                    'floor' => (int) $entry['floor'],
                    'prev'  => (float) $entry['prev'],
                    'curr'  => (float) $entry['curr'],
                ];
            });
            $floors = $readings->pluck('floor')->unique()->values();

            DB::transaction(function () use ($readings, $floors, $billingMonthDate, $ratePerM3, $staffId, $request) {

                $rate = WaterRate::updateOrCreate(
                    ['effective_month' => $billingMonthDate->format('Y-m-01')],
                    ['rate_per_m3'     => round($ratePerM3, 2)]
                );

                $tenantsByFloor = Tenant::whereIn('status', ['active', 'pending'])
                    ->whereIn('floor', $floors->all())
                    ->get()
                    ->groupBy('floor');

                WaterBilling::whereIn('floor', $floors->all())
                    ->whereDate('billing_month', $billingMonthDate->format('Y-m-d'))
                    ->delete();

                $billingRows = [];

                foreach ($readings as $entry) {
                    $floor = $entry['floor'];
                    $prev  = $entry['prev'];
                    $curr  = $entry['curr'];

                    if ($curr < $prev) {
                        throw new \Exception(
                            "Current reading cannot be lower than previous reading for floor {$floor}."
                        );
                    }

                    $consumption    = max(0, $curr - $prev);
                    $totalFloorBill = round($consumption * round($ratePerM3, 2), 2);
                    $tenants        = $tenantsByFloor->get($floor, collect());

                    if ($tenants->isEmpty()) {
                        continue;
                    }

                    $roomsSharing    = $tenants->pluck('room_number')->filter()->unique()->count();
                    $occupantsByRoom = $tenants->groupBy('room_number')->map->count();
                    $perTenantShare  = round($totalFloorBill / $tenants->count(), 2);

                    foreach ($tenants as $tenant) {
                        $billingRows[] = [
                            'tenant_id'            => $tenant->tenant_id,
                            'rate_id'              => $rate->rate_id,
                            'inputted_by'          => $staffId,
                            'billing_month'        => $billingMonthDate->format('Y-m-d'),
                            'floor'                => $floor,
                            'floor_consumption_m3' => $consumption,
                            'prev_reading'         => $prev,
                            'curr_reading'         => $curr,
                            'total_floor_bill'     => $totalFloorBill,
                            'rooms_sharing'        => $roomsSharing,
                            'occupants_in_room'    => $occupantsByRoom->get($tenant->room_number, 1),
                            'room_share'           => $perTenantShare,
                            'payment_status'       => 'unpaid',
                            'due_date'             => $request->due_date,
                        ];
                    }
                }

                if (!empty($billingRows)) {
                    WaterBilling::insert($billingRows);
                }
            });

            // Notify all admin staff that billing has been logged
            $monthLabel = $billingMonthDate->format('F Y');
            NotificationHelper::sendToAll(
                type: 'billing_overdue',
                message: "Water billing for {$monthLabel} has been logged.",
            );

            $pushService = app(TenantPushNotificationService::class);
            WaterBilling::whereIn('floor', $floors->all())
                ->whereDate('billing_month', $billingMonthDate->format('Y-m-d'))
                ->get()
                ->unique('tenant_id')
                ->each(function (WaterBilling $billing) use ($pushService, $monthLabel) {
                    $pushService->sendToTenant(
                        tenant: $billing->tenant_id,
                        type: 'bill',
                        title: 'Water bill ready',
                        body: "Your water bill for {$monthLabel} is ready to view.",
                        refId: $billing->billing_id,
                        route: '/tenant/water-bill',
                    );
                });

            return response()->json([
                'success' => true,
                'message' => 'Water billing logged successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
                'message' => collect($e->errors())->flatten()->first(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
            'billing_id'                         => 'required|integer',
            'prev_reading'                       => 'required|numeric|min:0',
            'curr_reading'                       => 'required|numeric|min:0|gte:prev_reading',
            'due_date'                           => 'required|date',
            'payment_status'                     => 'required|string|in:unpaid,pending,paid,overdue,rejected',
            'status_updates'                     => 'nullable|array',
            'status_updates.*.billing_id'        => 'required_with:status_updates|integer',
            'status_updates.*.payment_status'    => 'required_with:status_updates|string|in:unpaid,pending,paid,overdue,rejected',
            'status_updates.*.rejection_reason'  => 'nullable|string|max:500',
        ]);

        $billing   = WaterBilling::findOrFail($request->billing_id);
        $rate      = WaterRate::where('effective_month', Carbon::parse($billing->billing_month)->format('Y-m-01'))->first();
        $ratePerM3 = $rate?->rate_per_m3 ?? 0;

        $consumption = max(0, $request->curr_reading - $request->prev_reading);
        $total       = round($consumption * round($ratePerM3, 2), 2);

        $count = WaterBilling::where('floor', $billing->floor)
            ->whereYear('billing_month', Carbon::parse($billing->billing_month)->year)
            ->whereMonth('billing_month', Carbon::parse($billing->billing_month)->month)
            ->whereHas('tenant', fn($q) => $q->whereIn('status', ['active', 'pending']))
            ->count();

        $share = $count > 0 ? round($total / $count, 2) : 0;

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

        if ($request->filled('status_updates')) {
            foreach ($request->status_updates as $statusUpdate) {
                $billingToUpdate = WaterBilling::findOrFail($statusUpdate['billing_id']);

                if ($statusUpdate['payment_status'] === 'paid' && empty($billingToUpdate->proof_of_payment) && !$request->boolean('force_paid_without_proof')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Proof of payment is required before marking a tenant as paid.',
                        'requires_proof_confirmation' => true,
                    ], 422);
                }

                $rejectionReason = $statusUpdate['rejection_reason'] ?? null;
                $isRejected = $statusUpdate['payment_status'] === 'rejected';

                $billingToUpdate->update([
                    'payment_status'   => $statusUpdate['payment_status'],
                    'rejection_reason' => $isRejected ? $rejectionReason : null,
                ]);
                Payment::where('billing_id', $billingToUpdate->billing_id)
                    ->where('tenant_id', $billingToUpdate->tenant_id)
                    ->update([
                        'status'       => $statusUpdate['payment_status'],
                        'confirmed_by' => $statusUpdate['payment_status'] === 'paid' ? Auth::id() : null,
                    ]);

                if ($statusUpdate['payment_status'] === 'paid') {
                    $tenant = Tenant::find($billingToUpdate->tenant_id);
                    NotificationHelper::sendToAll(
                        type: 'billing_overdue',
                        message: "Tenant {$tenant->first_name} {$tenant->last_name} has paid their water bill.",
                        ref_id: $billingToUpdate->billing_id,
                    );

                    app(TenantPushNotificationService::class)->sendToTenant(
                        tenant: $billingToUpdate->tenant_id,
                        type: 'payment',
                        title: 'Payment verified',
                        body: 'Your water bill payment has been verified.',
                        refId: $billingToUpdate->billing_id,
                        route: '/tenant/water-bill',
                    );
                }

                if ($isRejected) {
                    $tenant = Tenant::find($billingToUpdate->tenant_id);
                    $reasonText = $rejectionReason ? " Reason: {$rejectionReason}" : '';
                    NotificationHelper::sendToAll(
                        type: 'billing_overdue',
                        message: "Tenant {$tenant->first_name} {$tenant->last_name}'s payment was rejected.{$reasonText}",
                        ref_id: $billingToUpdate->billing_id,
                    );

                    app(TenantPushNotificationService::class)->sendToTenant(
                        tenant: $billingToUpdate->tenant_id,
                        type: 'payment',
                        title: 'Payment rejected',
                        body: "Your water bill payment was rejected.{$reasonText} Please resubmit.",
                        refId: $billingToUpdate->billing_id,
                        route: '/tenant/water-bill',
                    );
                }
            }
        } else {
            if ($request->payment_status === 'paid' && empty($billing->proof_of_payment) && !$request->boolean('force_paid_without_proof')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proof of payment is required before marking a tenant as paid.',
                    'requires_proof_confirmation' => true,
                ], 422);
            }

            $billing->update(['payment_status' => $request->payment_status]);
            Payment::where('billing_id', $billing->billing_id)
                ->where('tenant_id', $billing->tenant_id)
                ->update([
                    'status' => $request->payment_status,
                    'confirmed_by' => $request->payment_status === 'paid' ? Auth::id() : null,
                ]);

            if ($request->payment_status === 'paid') {
                $tenant = Tenant::find($billing->tenant_id);
                NotificationHelper::sendToAll(
                    type: 'billing_overdue',
                    message: "Tenant {$tenant->first_name} {$tenant->last_name} has paid their water bill.",
                    ref_id: $billing->billing_id,
                );

                app(TenantPushNotificationService::class)->sendToTenant(
                    tenant: $billing->tenant_id,
                    type: 'payment',
                    title: 'Payment verified',
                    body: 'Your water bill payment has been verified.',
                    refId: $billing->billing_id,
                    route: '/tenant/water-bill',
                );
            }
        }

        return response()->json([
            'success'    => true,
            'room_share' => $share
        ]);
    }
}
