<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Helpers\NotificationHelper;
use Illuminate\Console\Command;

class NotifyUpcomingMoveOuts extends Command
{
    protected $signature   = 'tenants:notify-upcoming-moveouts';
    protected $description = 'Notify admins of tenants whose move-out date is within 3 days';

    public function handle()
    {
        $upcoming = Tenant::whereIn('status', ['active', 'pending'])
            ->whereNotNull('move_out_date')
            ->whereDate('move_out_date', '>', now()->toDateString())
            ->whereDate('move_out_date', '<=', now()->addDays(3)->toDateString())
            ->get();

        foreach ($upcoming as $tenant) {
            $daysLeft = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($tenant->move_out_date)->startOfDay());
            $label    = $daysLeft === 0 ? 'today' : ($daysLeft === 1 ? 'tomorrow' : "in {$daysLeft} days");

            NotificationHelper::sendToAll(
                type: 'tenant_moveout_reminder',
                message: "{$tenant->first_name} {$tenant->last_name} (Rm. {$tenant->room_number}) is scheduled to move out {$label} on " . \Carbon\Carbon::parse($tenant->move_out_date)->format('M j, Y') . ".",
                ref_id: $tenant->tenant_id,
            );

            $this->info("Reminded: {$tenant->first_name} {$tenant->last_name} — moves out {$label}");
        }

        $this->info("Done. {$upcoming->count()} reminder(s) sent.");
    }
}