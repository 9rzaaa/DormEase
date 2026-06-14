<?php

namespace App\Console\Commands;

use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Models\Staff;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyOverdueReservations extends Command
{
    protected $signature   = 'reservations:notify-overdue';
    protected $description = 'Send daily overdue reservation notifications to admin staff';

    public function handle(): void
    {
        $overdue = Tenant::where('status', 'reserved')
            ->whereNotNull('estimated_move_in_date')
            ->whereDate('estimated_move_in_date', '<', Carbon::today())
            ->get();

        if ($overdue->isEmpty()) {
            return;
        }

        $adminStaff = Staff::where('is_active', 1)
            ->where('role', 'admin')
            ->get();

        foreach ($overdue as $tenant) {
            $daysOver = Carbon::today()->diffInDays(Carbon::parse($tenant->estimated_move_in_date));
            $room     = $tenant->room_number ?? 'unassigned room';
            $message  = "Reservation overdue: {$tenant->first_name} {$tenant->last_name} (Rm. {$room}) is {$daysOver} day" . ($daysOver !== 1 ? 's' : '') . " past the expected move-in date.";

            foreach ($adminStaff as $staff) {
                $alreadySent = Notification::where('staff_id', $staff->staff_id)
                    ->where('type', 'reservation_overdue')
                    ->where('ref_id', $tenant->tenant_id)
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                if ($alreadySent) {
                    continue;
                }

                NotificationHelper::send(
                    staff_id: $staff->staff_id,
                    type: 'reservation_overdue',
                    message: $message,
                    ref_id: $tenant->tenant_id,
                );
            }
        }
    }
}