<?php

namespace App\Http\Controllers;

use App\Models\WaterBilling;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BillingHistoryController extends Controller
{
    public function index(Request $request)
    {
        $selectedFloor  = $request->get('floor', '');
        $selectedStatus = $request->get('status', '');
        $selectedMonth  = $request->get('month', '');
        $search         = $request->get('search', '');
        $perPage        = 6;

        $allTenants = Tenant::whereIn('status', ['active', 'pending'])
            ->whereNotNull('floor')
            ->orderBy('floor')
            ->orderBy('room_number')
            ->get();

        $floors = $allTenants->pluck('floor')->unique()->sort()->values();

        $distinctMonths = WaterBilling::selectRaw('DATE_FORMAT(billing_month, "%Y-%m-01") as month_val')
            ->groupByRaw('DATE_FORMAT(billing_month, "%Y-%m-01")')
            ->orderByDesc('month_val')
            ->pluck('month_val');

        $detailQuery = WaterBilling::with('tenant')
            ->orderByDesc('billing_month')
            ->orderBy('floor')
            ->orderBy('tenant_id');

        if ($selectedFloor !== '') {
            $detailQuery->where('floor', $selectedFloor);
        }

        if ($selectedStatus !== '') {
            $detailQuery->where('payment_status', $selectedStatus);
        }

        if ($selectedMonth !== '') {
            $detailQuery->whereRaw(
                "DATE_FORMAT(billing_month, '%Y-%m-01') = ?",
                [$selectedMonth]
            );
        }

        if ($search !== '') {
            $detailQuery->whereHas('tenant', function ($q) use ($search) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%']);
            });
        }

        $allRecords = $detailQuery->get();

        $grouped = $allRecords->groupBy(function ($b) {
            return Carbon::parse($b->billing_month)->format('Y-m-01');
        })->sortKeysDesc();

        $monthKeys   = $grouped->keys()->values();
        $totalMonths = $monthKeys->count();
        $page        = max(1, (int) $request->get('page', 1));
        $offset      = ($page - 1) * $perPage;
        $pageKeys    = $monthKeys->slice($offset, $perPage)->values();
        $totalPages  = (int) ceil($totalMonths / $perPage);

        $historyGroups = [];

        foreach ($pageKeys as $monthKey) {
            $monthBillings = $grouped->get($monthKey, collect());
            $carbonDate    = Carbon::parse($monthKey);

            $floorGroups = [];

            foreach ($monthBillings->groupBy('floor')->sortKeys() as $floor => $floorBillings) {
                $firstBilling = $floorBillings->first();

                $rooms = [];
                foreach ($floorBillings->groupBy(function ($b) {
                    return $b->tenant->room_number ?? '?';
                })->sortKeys() as $roomNumber => $roomBillings) {

                    $tenantRows = $roomBillings->map(function ($b) {
                        if ($b->tenant->status === 'inactive') {
                            $paymentStatus = 'inactive-tenant';
                        } else {
                            $paymentStatus = strtolower($b->payment_status ?? 'unpaid');
                        }
                        return [
                            'billing_id'             => $b->billing_id,
                            'name'                   => trim(($b->tenant->first_name ?? '') . ' ' . ($b->tenant->last_name ?? '')),
                            'room_share'             => $b->room_share ?? 0,
                            'payment_status'         => $paymentStatus,
                            'payment_reference_code' => $b->payment_reference_code,
                            'payment_submitted_at'   => $b->payment_submitted_at
                                ? Carbon::parse($b->payment_submitted_at)->format('M d, Y h:i A')
                                : null,
                            'proof_of_payment_url'   => $b->proof_of_payment
                                ? Storage::disk('public')->url($b->proof_of_payment)
                                : null,
                            'rejection_reason' => $b->rejection_reason,
                            'dot_class' => match ($paymentStatus) {
                                'paid'       => 'dot-green',
                                'overdue'    => 'dot-red',
                                'rejected'   => 'dot-red',
                                'not billed' => 'dot-gray',
                                default      => 'dot-orange',
                            },
                        ];
                    })->values()->toArray();

                    $rooms[] = [
                        'room_number'          => $roomNumber,
                        'floor'                => $floor,
                        'occupants_in_room'    => count($tenantRows),
                        'prev_reading'         => $firstBilling->prev_reading ?? 0,
                        'curr_reading'         => $firstBilling->curr_reading ?? 0,
                        'floor_consumption_m3' => $firstBilling->floor_consumption_m3 ?? 0,
                        'total_floor_bill'     => $firstBilling->total_floor_bill ?? 0,
                        'due_date'             => $firstBilling->due_date
                            ? Carbon::parse($firstBilling->due_date)->format('M d, Y')
                            : '—',
                        'tenants' => $tenantRows,
                    ];
                }

                $paidCount    = $floorBillings->where('payment_status', 'paid')->count();
                $unpaidCount  = $floorBillings->whereIn('payment_status', ['unpaid', 'overdue'])->count();
                $totalCount   = $floorBillings->count();

                $floorGroups[] = [
                    'floor'                => $floor,
                    'submeter_label'       => "Floor {$floor} - Submeter #{$floor}",
                    'floor_consumption_m3' => number_format($firstBilling->floor_consumption_m3 ?? 0, 2),
                    'total_floor_bill'     => $floorBillings->sum('room_share'),
                    'room_count'           => count($rooms),
                    'paid_count'           => $paidCount,
                    'unpaid_count'         => $unpaidCount,
                    'total_tenants'        => $totalCount,
                    'due_date'             => $firstBilling->due_date
                        ? Carbon::parse($firstBilling->due_date)->format('M d, Y')
                        : '—',
                    'rooms' => $rooms,
                ];
            }

            $monthTotalBill   = collect($floorGroups)->sum('total_floor_bill');
            $monthPaidCount   = collect($floorGroups)->sum('paid_count');
            $monthUnpaidCount = collect($floorGroups)->sum('unpaid_count');
            $monthTenants     = collect($floorGroups)->sum('total_tenants');

            $historyGroups[] = [
                'month_key'      => $monthKey,
                'month_label'    => $carbonDate->format('F Y'),
                'month_short'    => $carbonDate->format('M Y'),
                'total_bill'     => $monthTotalBill,
                'paid_count'     => $monthPaidCount,
                'unpaid_count'   => $monthUnpaidCount,
                'total_tenants'  => $monthTenants,
                'floor_groups'   => $floorGroups,
            ];
        }

        $summaryByMonth = [];
        foreach ($distinctMonths as $mk) {
            $mBillings = WaterBilling::whereRaw("DATE_FORMAT(billing_month, '%Y-%m-01') = ?", [$mk])
                ->whereHas('tenant', fn($q) => $q->whereIn('status', ['active', 'pending']))
                ->get();
            $summaryByMonth[$mk] = [
                'label'        => Carbon::parse($mk)->format('M Y'),
                'total_bill'   => $mBillings->sum('room_share'),
                'paid_count'   => $mBillings->where('payment_status', 'paid')->count(),
                'total_count'  => $mBillings->count(),
            ];
        }

        $months = collect($distinctMonths)->map(function ($m) {
            return [
                'key'   => $m,
                'label' => Carbon::parse($m)->format('F Y'),
            ];
        })->values();

        return view('billing-history', compact(
            'historyGroups',
            'floors',
            'selectedFloor',
            'selectedStatus',
            'search',
            'totalMonths',
            'totalPages',
            'page',
            'perPage',
            'summaryByMonth',
            'distinctMonths',
            'months',
            'selectedMonth',
        ));
    }
    public function exportAll(Request $request)
    {
        $selectedFloor  = $request->get('floor', '');
        $selectedStatus = $request->get('status', '');
        $selectedMonth  = $request->get('month', '');
        $search         = $request->get('search', '');

        $detailQuery = WaterBilling::with('tenant')
            ->orderByDesc('billing_month')
            ->orderBy('floor')
            ->orderBy('tenant_id');

        if ($selectedFloor !== '') {
            $detailQuery->where('floor', $selectedFloor);
        }

        if ($selectedStatus !== '') {
            $detailQuery->where('payment_status', $selectedStatus);
        }

        if ($selectedMonth !== '') {
            $detailQuery->whereRaw(
                "DATE_FORMAT(billing_month, '%Y-%m-01') = ?",
                [$selectedMonth]
            );
        }

        if ($search !== '') {
            $detailQuery->whereHas('tenant', function ($q) use ($search) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%']);
            });
        }

        $allRecords = $detailQuery->get();

        $grouped = $allRecords->groupBy(function ($b) {
            return Carbon::parse($b->billing_month)->format('Y-m-01');
        })->sortKeysDesc();

        $historyGroups = [];

        foreach ($grouped->keys() as $monthKey) {
            $monthBillings = $grouped->get($monthKey, collect());
            $carbonDate    = Carbon::parse($monthKey);

            $floorGroups = [];

            foreach ($monthBillings->groupBy('floor')->sortKeys() as $floor => $floorBillings) {
                $firstBilling = $floorBillings->first();

                $rooms = [];
                foreach ($floorBillings->groupBy(function ($b) {
                    return $b->tenant->room_number ?? '?';
                })->sortKeys() as $roomNumber => $roomBillings) {

                    $tenantRows = $roomBillings->map(function ($b) {
                        $paymentStatus = $b->tenant->status === 'inactive'
                            ? 'inactive-tenant'
                            : strtolower($b->payment_status ?? 'unpaid');

                        return [
                            'name'                   => trim(($b->tenant->first_name ?? '') . ' ' . ($b->tenant->last_name ?? '')),
                            'room_share'             => $b->room_share ?? 0,
                            'payment_status'         => $paymentStatus,
                            'payment_reference_code' => $b->payment_reference_code,
                            'payment_submitted_at'   => $b->payment_submitted_at
                                ? Carbon::parse($b->payment_submitted_at)->format('M d, Y h:i A')
                                : null,
                        ];
                    })->values()->toArray();

                    $rooms[] = [
                        'room_number' => $roomNumber,
                        'occupants_in_room' => count($tenantRows),
                        'tenants'     => $tenantRows,
                    ];
                }

                $floorGroups[] = [
                    'floor'                => $floor,
                    'floor_consumption_m3' => number_format($firstBilling->floor_consumption_m3 ?? 0, 2),
                    'total_floor_bill'     => $floorBillings->sum('room_share'),
                    'due_date'             => $firstBilling->due_date
                        ? Carbon::parse($firstBilling->due_date)->format('M d, Y')
                        : '—',
                    'rooms' => $rooms,
                ];
            }

            $historyGroups[] = [
                'month_key'    => $monthKey,
                'month_label'  => $carbonDate->format('F Y'),
                'floor_groups' => $floorGroups,
            ];
        }

        return response()->json(['history_groups' => $historyGroups]);
    }
}
