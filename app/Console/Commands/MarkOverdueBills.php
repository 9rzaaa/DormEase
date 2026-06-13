<?php

namespace App\Console\Commands;

use App\Models\WaterBilling;
use App\Services\TenantPushNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkOverdueBills extends Command
{
    protected $signature   = 'bills:mark-overdue';
    protected $description = 'Mark unpaid water bills past their due date as overdue and notify tenants';

    public function handle(TenantPushNotificationService $pushService): void
    {
        $today = Carbon::today()->toDateString();

        $billings = WaterBilling::whereDate('due_date', '<', $today)
            ->whereIn('payment_status', ['unpaid', 'rejected'])
            ->get();

        if ($billings->isEmpty()) {
            $this->info('No overdue bills found. Nothing to update.');
            return;
        }

        $count = 0;

        foreach ($billings as $billing) {
            $billing->update(['payment_status' => 'overdue']);

            $amount  = number_format($billing->room_share, 2);
            $month   = Carbon::parse($billing->billing_month)->format('F Y');
            $dueDate = Carbon::parse($billing->due_date)->format('F d, Y');

            $pushService->sendToTenant(
                tenant: $billing->tenant_id,
                type: 'bill',
                title: 'Water Bill Overdue',
                body: "Your water bill of ₱{$amount} for {$month} was due on {$dueDate} and is now overdue. Please settle immediately.",
                refId: $billing->billing_id,
                route: '/tenant/water-bill',
            );

            $count++;
        }

        $this->info("Marked {$count} bill(s) as overdue and notified the respective tenant(s).");
    }
}
