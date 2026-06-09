<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Helpers\NotificationHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ActivateReservedTenants extends Command
{
    protected $signature = 'tenants:activate-reserved';
    protected $description = 'Automatically move reserved tenants to active on their estimated move-in date';

    public function handle(): void
    {
        $today = Carbon::today();

        $tenants = Tenant::where('status', 'reserved')
            ->whereNotNull('estimated_move_in_date')
            ->whereDate('estimated_move_in_date', '<=', $today)
            ->get();

        foreach ($tenants as $tenant) {
            $tenant->update([
                'status'       => 'active',
                'is_active'    => true,
                'move_in_date' => $tenant->move_in_date ?? $today->toDateString(),
            ]);

            NotificationHelper::sendToAll(
                type: 'tenant_activated',
                message: "Tenant {$tenant->first_name} {$tenant->last_name} has been automatically moved in.",
                ref_id: $tenant->tenant_id,
            );
        }

        $this->info("Activated {$tenants->count()} reserved tenant(s).");
    }
}