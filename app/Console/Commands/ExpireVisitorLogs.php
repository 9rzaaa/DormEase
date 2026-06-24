<?php

namespace App\Console\Commands;

use App\Models\VisitorLog;
use App\Helpers\NotificationHelper;
use Illuminate\Console\Command;

class ExpireVisitorLogs extends Command
{
    protected $signature = 'visitors:expire';

    protected $description = 'Cancel pending or approved visitor logs that were never timed in and have passed their expiry window';

    public function handle(): int
    {
        $expired = VisitorLog::whereNull('arrival_time')
            ->whereIn('status', ['pending', 'approved'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        if ($expired->isEmpty()) {
            $this->info('No expired visitor logs found.');
            return self::SUCCESS;
        }

        foreach ($expired as $visitor) {
            $visitor->update([
                'status'           => 'cancelled',
                'cancelled_at'     => now(),
                'cancel_reason'    => 'expired',
            ]);

            NotificationHelper::sendToAll(
                type: 'visitor_expired',
                message: "Visit request for {$visitor->visitor_name} expired and was cancelled automatically.",
                ref_id: $visitor->visitor_id,
            );
        }

        $this->info("Expired {$expired->count()} visitor log(s).");

        return self::SUCCESS;
    }
}