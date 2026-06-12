<?php

namespace App\Console\Commands;

use App\Models\WaterBilling;
use App\Services\TenantPushNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyBillDueReminder extends Command
{
    protected $signature   = 'bills:notify-due-reminder';
    protected $description = 'Send push notifications to tenants whose water bill due date is 3 days away';

    public function handle(TenantPushNotificationService $pushService): void
    {
        $targetDate = Carbon::today()->addDays(3)->toDateString();

        $billings = WaterBilling::whereDate('due_date', $targetDate)
            ->whereIn('payment_status', ['unpaid', 'rejected'])
            ->get();

        if ($billings->isEmpty()) {
            $this->info("No bills due on {$targetDate}. Nothing to remind.");
            return;
        }

        $count = 0;

        foreach ($billings as $billing) {
            $amount    = number_format($billing->room_share, 2);
            $dueDate   = Carbon::parse($billing->due_date)->format('F d, Y');
            $month     = Carbon::parse($billing->billing_month)->format('F Y');

            $pushService->sendToTenant(
                tenant: $billing->tenant_id,
                type: 'bill',
                title: 'Water Bill Due Soon',
                body: "Your water bill of ₱{$amount} for {$month} is due on {$dueDate}. Please pay before it becomes overdue.",
                refId: $billing->billing_id,
                route: '/tenant/water-bill',
            );

            $count++;
        }

        $this->info("Due reminder sent to {$count} tenant(s) with bills due on {$targetDate}.");
    }
}
