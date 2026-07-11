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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
                'id'               => $b->billing_id,
                'billing_period'   => Carbon::parse($b->billing_month)->format('F Y'),
                'due_date'         => $b->due_date
                    ? Carbon::parse($b->due_date)->format('F d, Y')
                    : '—',
                'amount'           => number_format($b->room_share, 2),
                'status'           => ucfirst($b->payment_status ?? 'unpaid'),
                'rejection_reason' => $b->rejection_reason,
            ];
        })->values()->toArray();

        $currentBillingData = [
            'id'               => $currentBilling->billing_id,
            'room_number'      => $tenant->room_number,
            'billing_period'   => Carbon::parse($currentBilling->billing_month)->format('F Y'),
            'as_of'            => now()->format('F d, Y'),
            'amount_due'       => number_format($currentBilling->room_share + $totalPastDue, 2),
            'due_date'         => $currentBilling->due_date
                ? Carbon::parse($currentBilling->due_date)->format('F d, Y')
                : '—',
            'status'           => ucfirst($currentBilling->payment_status ?? 'unpaid'),
            'rejection_reason' => $currentBilling->rejection_reason,
            'proof_of_payment' => $currentBilling->proof_of_payment
                ? Storage::disk('public')->url($currentBilling->proof_of_payment)
                : null,
            'reference_code'   => $currentBilling->payment_reference_code,
            'payment_submitted_at' => $currentBilling->payment_submitted_at
                ? Carbon::parse($currentBilling->payment_submitted_at)->format('F d, Y h:i A')
                : null,
            'current_charges'  => number_format($currentBilling->room_share, 2),
            'past_due_amount'  => number_format($totalPastDue, 2),
            'past_due_bills'   => $pastDueBillsData,
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
                'rejection_reason' => $b->rejection_reason,
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
        $isCash = $request->payment_method === 'cash';

        $request->validate([
            'billing_id' => 'required|integer',
            'proof_of_payment' => $isCash ? 'nullable|image|mimes:jpg,jpeg,png|max:4096' : 'required|image|mimes:jpg,jpeg,png|max:4096',
            'reference_code' => $isCash ? 'nullable|string|max:100' : 'required|string|max:100',
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

        $path = null;
        if ($request->hasFile('proof_of_payment')) {
            if ($billing->proof_of_payment) {
                Storage::disk('public')->delete($billing->proof_of_payment);
            }
            $path = $request->file('proof_of_payment')->store('payment_proofs', 'public');
        } else if ($isCash) {
            if ($billing->proof_of_payment) {
                Storage::disk('public')->delete($billing->proof_of_payment);
            }
            $path = null;
        } else {
            $path = $billing->proof_of_payment;
        }

        // If it's a cash payment and no reference code is provided, set a default reference code
        $refCode = $request->reference_code;
        if ($isCash && empty($refCode)) {
            $refCode = 'CASH-' . strtoupper(uniqid());
        }

        $billing->update([
            'payment_status' => 'pending',
            'proof_of_payment' => $path,
            'payment_reference_code' => $refCode,
            'payment_submitted_at' => now(),
            'rejection_reason' => null,
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
                'reference_number' => $refCode,
                'payment_date' => now(),
                'status' => 'pending',
            ]
        );

        NotificationHelper::sendToAll(
            type: 'billing_overdue',
            message: $isCash
                ? "{$tenant->first_name} {$tenant->last_name} submitted a cash payment request for water billing."
                : "{$tenant->first_name} {$tenant->last_name} submitted payment proof for water billing.",
            ref_id: $billing->billing_id,
        );

        return response()->json([
            'success' => true,
            'message' => $isCash
                ? 'Cash payment request submitted for verification.'
                : 'Payment proof submitted for verification.',
            'status' => 'Pending',
        ]);
    }

    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'billing_id' => 'required|integer',
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

        $amount = (float) $billing->room_share;
        $totalPayable = round($amount / 0.984992, 2);
        $surcharge = round($totalPayable - $amount, 2);

        $totalPayableCentavos = (int) round($totalPayable * 100);
        $surchargeCentavos = (int) round($surcharge * 100);
        $baseCentavos = (int) round($amount * 100);

        $secretKey = config('services.paymongo.secret_key');
        if (empty($secretKey) || $secretKey === 'sk_test_placeholder_key') {
            return response()->json(['message' => 'PayMongo gateway secret key is not configured.'], 500);
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($secretKey . ':'),
            ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $tenant->first_name . ' ' . $tenant->last_name,
                            'email' => $tenant->email,
                            'phone' => $tenant->contact_number ?? '',
                        ],
                        'line_items' => [
                            [
                                'amount' => $baseCentavos,
                                'currency' => 'PHP',
                                'name' => 'Water Bill Room Share - ' . $billing->billing_month,
                                'quantity' => 1,
                            ],
                            [
                                'amount' => $surchargeCentavos,
                                'currency' => 'PHP',
                                'name' => 'Payment Gateway Surcharge (1.34% QR Ph)',
                                'quantity' => 1,
                            ]
                        ],
                        'payment_method_types' => ['qrph'],
                        'success_url' => 'dormease://payment-success',
                        'cancel_url' => 'dormease://payment-cancelled',
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'description' => 'Water Bill Payment for Floor ' . $billing->floor . ', Period ' . $billing->billing_month,
                    ]
                ]
            ]);

            if ($response->failed()) {
                Log::error('PayMongo Checkout Session Creation Failed', [
                    'body' => $response->body(),
                    'status' => $response->status()
                ]);
                return response()->json([
                    'message' => 'Unable to create payment session. Please try again later.'
                ], 502);
            }

            $sessionData = $response->json()['data'];
            $sessionId = $sessionData['id'];
            $checkoutUrl = $sessionData['attributes']['checkout_url'];

            $billing->update([
                'payment_reference_code' => $sessionId,
                'payment_status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'checkout_url' => $checkoutUrl,
                'session_id' => $sessionId,
            ]);
        } catch (\Exception $e) {
            Log::error('PayMongo Checkout API Exception', [
                'exception' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Server error connecting to payment gateway.'], 500);
        }
    }

    public function handlePayMongoWebhook(Request $request)
    {
        $signature = $request->header('Paymongo-Signature');
        $webhookSigKey = config('services.paymongo.webhook_sig');

        if (!$signature || empty($webhookSigKey) || $webhookSigKey === 'whsec_placeholder_key') {
            Log::warning('PayMongo Webhook Rejected: Missing signature or configuration.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $parts = explode(',', $signature);
        $timestamp = null;
        $signatureVal = null;
        foreach ($parts as $part) {
            if (strpos($part, 't=') === 0) {
                $timestamp = substr($part, 2);
            } elseif (strpos($part, 'te=') === 0) {
                $signatureVal = substr($part, 3);
            }
        }

        if (!$timestamp || !$signatureVal) {
            Log::warning('PayMongo Webhook Rejected: Invalid signature format.');
            return response()->json(['message' => 'Invalid signature format'], 400);
        }

        $payload = $request->getContent();
        $comparisonSignature = hash_hmac('sha256', $timestamp . '.' . $payload, $webhookSigKey);

        if (!hash_equals($signatureVal, $comparisonSignature)) {
            Log::warning('PayMongo Webhook Rejected: Signature mismatch.', [
                'expected' => $comparisonSignature,
                'received' => $signatureVal,
            ]);
            return response()->json(['message' => 'Signature mismatch'], 401);
        }

        $data = $request->json()->all();
        $event = $data['data']['attributes']['type'] ?? '';

        Log::info('PayMongo Webhook Received', ['event' => $event]);

        if ($event === 'checkout_session.payment.paid') {
            $checkoutSession = $data['data']['attributes']['data'] ?? null;
            if ($checkoutSession) {
                $sessionId = $checkoutSession['id'];
                $payments = $checkoutSession['attributes']['payments'] ?? [];
                $paymentDetails = !empty($payments) ? $payments[0] : null;
                $paymentId = $paymentDetails['id'] ?? 'PAY-' . strval(uniqid());
                $amountPaidCentavos = $paymentDetails['attributes']['amount'] ?? 0;
                $amountPaid = $amountPaidCentavos / 100;

                $billing = WaterBilling::where('payment_reference_code', $sessionId)->first();

                if ($billing) {
                    $billing->update([
                        'payment_status' => 'paid',
                        'payment_submitted_at' => $billing->payment_submitted_at ?? now(),
                    ]);

                    Payment::updateOrCreate(
                        [
                            'billing_id' => $billing->billing_id,
                        ],
                        [
                            'tenant_id' => $billing->tenant_id,
                            'confirmed_by' => null, // null means automated system verified it
                            'payment_method' => 'QR Ph (PayMongo)',
                            'amount_paid' => $billing->room_share, // Base amount we receive
                            'proof_of_payment' => null,
                            'reference_number' => $paymentId,
                            'payment_date' => now(),
                            'status' => 'success',
                        ]
                    );

                    $tenant = Tenant::find($billing->tenant_id);
                    $tenantName = $tenant ? $tenant->first_name . ' ' . $tenant->last_name : 'Tenant';

                    NotificationHelper::sendToAll(
                        type: 'billing_paid',
                        message: "Tenant {$tenantName} has paid their water bill (₱" . number_format($billing->room_share, 2) . ").",
                        ref_id: $billing->billing_id,
                    );

                    if ($tenant) {
                        try {
                            app(\App\Services\TenantPushNotificationService::class)->sendToTenant(
                                tenant: $billing->tenant_id,
                                type: 'payment',
                                title: 'Payment Confirmed',
                                body: "Your water bill payment of ₱" . number_format($billing->room_share, 2) . " has been verified.",
                                route: '/tenant/water-bill'
                            );
                        } catch (\Exception $e) {
                            Log::error('Webhook Push Notification Error', ['error' => $e->getMessage()]);
                        }
                    }

                    Log::info('PayMongo Automated Verification Successful', [
                        'billing_id' => $billing->billing_id,
                        'session_id' => $sessionId
                    ]);
                } else {
                    Log::warning('PayMongo Webhook: Billing record not found for session ID.', [
                        'session_id' => $sessionId
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
