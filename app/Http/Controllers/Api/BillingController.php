<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\WaterBilling;
use App\Models\WaterRate;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BillingController extends Controller
{
    // ── GET /api/water-bill ───────────────────────────────────────────────────
    // Returns current billing, breakdown, and payment history
    // for the authenticated tenant.
    public function tenantBill()
    {
        /** @var Tenant $tenant */
        $tenant = Auth::user();

        if (!$tenant || !$tenant->is_active) {
            return response()->json(['message' => 'Tenant not found.'], 404);
        }

        // ── Current billing (most recent record) ──────────────────────────────
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

        // ── Water rate for breakdown ──────────────────────────────────────────
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

        // ── Payment history (up to 6 records after the current one) ──────────
        $historyBillings = WaterBilling::where('tenant_id', $tenant->tenant_id)
            ->orderByDesc('billing_month')
            ->skip(1)
            ->take(6)
            ->get();

        // ── Build response ────────────────────────────────────────────────────
        $currentBillingData = [
            'id'             => $currentBilling->billing_id,
            'room_number'    => $tenant->room_number,
            'billing_period' => Carbon::parse($currentBilling->billing_month)->format('F Y'),
            'as_of'          => now()->format('F d, Y'),
            'amount_due'     => number_format($currentBilling->room_share, 2),
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

        $historyData = $historyBillings->map(fn($b) => [
            'id'     => $b->billing_id,
            'month'  => Carbon::parse($b->billing_month)->format('M Y'),
            'amount' => number_format($b->room_share, 2),
            'status' => ucfirst($b->payment_status ?? 'unpaid'),
        ])->values()->toArray();

        return response()->json([
            'current_billing' => $currentBillingData,
            'breakdown'       => $breakdownData,
            'payment_history' => $historyData,
        ]);
    }

    // ── POST /api/water-bill/pay ──────────────────────────────────────────────
    // Submits payment proof for admin verification.
    public function tenantPay(Request $request)
    {
        $request->validate([
            'billing_id' => 'required|integer',
            'proof_of_payment' => 'required|image|max:4096',
            'reference_code' => 'required|string|max:100',
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
