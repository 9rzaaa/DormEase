<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\ArchivedTenant;
use Illuminate\Console\Command;

class AutoMarkMoveOut extends Command
{
    protected $signature   = 'tenants:auto-moveout';
    protected $description = 'Automatically mark tenants as move_out when their move_out_date has passed';

    public function handle()
    {
        $tenants = Tenant::whereIn('status', ['active', 'pending'])
            ->whereNotNull('move_out_date')
            ->whereDate('move_out_date', '<=', now()->toDateString())
            ->get();

        foreach ($tenants as $tenant) {
            ArchivedTenant::create([
                'original_id'    => $tenant->tenant_id,
                'archive_type'   => 'move_out',
                'account_id'     => $tenant->account_id,
                'first_name'     => $tenant->first_name,
                'last_name'      => $tenant->last_name,
                'email'          => $tenant->email,
                'contact_number' => $tenant->contact_number,
                'room_number'    => $tenant->room_number,
                'floor'          => $tenant->floor,
                'stay_type'      => $tenant->stay_type,
                'move_in_date'   => $tenant->move_in_date,
                'move_out_date'  => $tenant->move_out_date,
                'status'         => 'move_out',
                'archived_at'    => now(),
            ]);

            $tenant->update([
                'status'    => 'move_out',
                'is_active' => false,
            ]);

            $this->info("Marked move_out: {$tenant->first_name} {$tenant->last_name} ({$tenant->account_id})");
        }

        $this->info("Done. {$tenants->count()} tenant(s) processed.");
    }
}