<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\WaterBilling;
use App\Models\WaterRate;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function tenantBill()
    {
        /** @var Tenant $tenant */
        $tenant = Auth::user();

        if (!$tenant || !$tenant->is_active) {
            return response()->json(['message' => 'Tenant not found.'], 404);
        }

        $currentBilling = WaterBilling::where('tenant_id', $tenant->tenant_id)
            ->orderByDesc('billing_month')
            ->first();

        if (!$currentBilling) {
            return response()->json([
                'current_billing' => null,
                'breakdown'       => null,
                'payment_history' => [],
            ]);
        }

        $rate = WaterRate::find($currentBilling->rate_id);

        $floorTenants = Tenant::where('is_active', true)
            ->where('floor', $currentBilling->floor)
            ->whereNotNull('room_number')
            ->get();

        $roomsSharing = $floorTenants
            ->pluck('room_number')
            ->unique()
            ->count();

        $occupantsInRoom = $floorTenants
            ->where('room_number', $tenant->room_number)
            ->count();

        $historyBillings = WaterBilling::where('tenant_id', $tenant->tenant_id)
            ->orderByDesc('billing_month')
            ->skip(1)
            ->take(6)
            ->get();

        $historyPayments = Payment::where('tenant_id', $tenant->tenant_id)
            ->whereIn('billing_id', $historyBillings->pluck('billing_id'))
            ->orderByDesc('payment_date')
            ->get()
            ->keyBy('billing_id');

        $pastDueBillings = WaterBilling::where('tenant_id', $tenant->tenant_id)
            ->where('billing_month', '<', $currentBilling->billing_month)
            ->whereIn('payment_status', ['unpaid', 'overdue', 'rejected'])
            ->orderBy('billing_month')
            ->get();

        $totalPastDue = $pastDueBillings->sum('room_share');

        $pastDueBillsData = $pastDueBillings->map(function ($b) {
            return [
                'id'             => $b->billing_id,
                'billing_period' => Carbon::parse($b->billing_month)->format('F Y'),
                'due_date'       => $b->due_date
                    ? Carbon::parse($b->due_date)->format('F d, Y')
                    : '—',
                'amount'         => number_format($b->room_share, 2),
                'status'         => ucfirst($b->payment_status ?? 'unpaid'),
            ];
        })->values()->toArray();

        $currentBillingData = [
            'id'             => $currentBilling->billing_id,
            'room_number'    => $tenant->room_number,
            'billing_period' => Carbon::parse($currentBilling->billing_month)->format('F Y'),
            'as_of'          => now()->format('F d, Y'),
            'amount_due'     => number_format($currentBilling->room_share + $totalPastDue, 2),
            'due_date'       => $currentBilling->due_date
                ? Carbon::parse($currentBilling->due_date)->format('F d, Y')
                : '—',
            'status'         => ucfirst($currentBilling->payment_status ?? 'unpaid'),
            'proof_of_payment' => $currentBilling->proof_of_payment
                ? Storage::disk('public')->url($currentBilling->proof_of_payment)
                : null,
            'reference_code' => $currentBilling->payment_reference_code,
            'payment_submitted_at' => $currentBilling->payment_submitted_at
                ? Carbon::parse($currentBilling->payment_submitted_at)->format('F d, Y h:i A')
                : null,
            'current_charges' => number_format($currentBilling->room_share, 2),
            'past_due_amount' => number_format($totalPastDue, 2),
            'past_due_bills'  => $pastDueBillsData,
        ];

        $breakdownData = [
            'room_number'       => $tenant->room_number,
            'floor_consumption' => number_format($currentBilling->floor_consumption_m3, 2),
            'water_rate'        => number_format($rate?->rate_per_m3 ?? 0, 2),
            'total_floor_bill'  => number_format($currentBilling->total_floor_bill, 2),
            'rooms_sharing'     => $roomsSharing,
            'room_share'        => number_format($currentBilling->room_share, 2),
            'occupants'         => $occupantsInRoom,
        ];

        $historyData = $historyBillings->map(function ($b) use ($historyPayments) {
            $payment = $historyPayments->get($b->billing_id);
            $paymentDate = $payment?->payment_date ?? $b->payment_submitted_at;

            return [
                'id'               => $b->billing_id,
                'month'            => Carbon::parse($b->billing_month)->format('M Y'),
                'amount'           => number_format($payment?->amount_paid ?? $b->room_share, 2),
                'status'           => ucfirst($b->payment_status ?? 'unpaid'),
                'reference_number' => $payment?->reference_number ?? $b->payment_reference_code,
                'payment_date'     => $paymentDate
                    ? Carbon::parse($paymentDate)->format('M d, Y h:i A')
                    : null,
                'payment_method'   => $payment?->payment_method,
            ];
        })->values()->toArray();

        return response()->json([
            'current_billing' => $currentBillingData,
            'breakdown'       => $breakdownData,
            'payment_history' => $historyData,
        ]);
    }

    public function tenantPay(Request $request)
    {
        $request->validate([
            'billing_id' => 'required|integer',
            'proof_of_payment' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'reference_code' => 'required|string|max:100',
            'payment_method' => 'nullable|string|max:100',
        ], [
            'proof_of_payment.required' => 'Please upload your proof of payment.',
            'proof_of_payment.image' => 'The proof of payment must be a valid image file.',
            'proof_of_payment.mimes' => 'Only JPG and PNG images are allowed.',
            'proof_of_payment.max' => 'The proof of payment image size must not exceed 4 MB.',
            'reference_code.required' => 'Please enter the payment reference code.',
        ]);

        /** @var Tenant $tenant */
        $tenant = Auth::user();

        if (!$tenant || !$tenant->is_active) {
            return response()->json(['message' => 'Tenant not found.'], 404);
        }

        $billing = WaterBilling::where('billing_id', $request->billing_id)
            ->where('tenant_id', $tenant->tenant_id)
            ->first();

        if (!$billing) {
            return response()->json(['message' => 'Billing record not found.'], 404);
        }

        if (strtolower($billing->payment_status) === 'paid') {
            return response()->json(['message' => 'Already verified as paid.'], 422);
        }

        if ($billing->proof_of_payment) {
            Storage::disk('public')->delete($billing->proof_of_payment);
        }

        $path = $request->file('proof_of_payment')->store('payment_proofs', 'public');

        $billing->update([
            'payment_status' => 'pending',
            'proof_of_payment' => $path,
            'payment_reference_code' => $request->reference_code,
            'payment_submitted_at' => now(),
        ]);

        Payment::updateOrCreate(
            [
                'billing_id' => $billing->billing_id,
                'tenant_id' => $tenant->tenant_id,
            ],
            [
                'confirmed_by' => null,
                'payment_method' => $request->payment_method,
                'amount_paid' => $billing->room_share,
                'proof_of_payment' => $path,
                'reference_number' => $request->reference_code,
                'payment_date' => now(),
                'status' => 'pending',
            ]
        );

        NotificationHelper::sendToAll(
            type: 'billing_overdue',
            message: "{$tenant->first_name} {$tenant->last_name} submitted payment proof for water billing.",
            ref_id: $billing->billing_id,
        );

        return response()->json([
            'success' => true,
            'message' => 'Payment proof submitted for verification.',
            'status' => 'Pending',
        ]);
    }
}
