<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Helpers\NotificationHelper;
use App\Services\TenantPushNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledAnnouncements extends Command
{
    protected $signature = 'announcements:publish-scheduled';

    protected $description = 'Publish announcements whose scheduled time has passed';

    public function handle()
    {
        $due = Announcement::where('status', 'scheduled')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($due as $announcement) {
            $announcement->update([
                'status'    => 'active',
                'posted_at' => $announcement->posted_at ?? now(),
            ]);

            try {
                NotificationHelper::sendToAll(
                    type: 'announcement_new',
                    message: 'New announcement posted: ' . $announcement->title,
                    ref_id: $announcement->announcement_id,
                );

                app(TenantPushNotificationService::class)->sendToAllTenants(
                    type: 'announcement',
                    title: 'New announcement posted',
                    body: $announcement->title,
                    refId: $announcement->announcement_id,
                    route: '/tenant/announcements',
                );
            } catch (\Throwable $error) {
                Log::error('Scheduled announcement notification failed.', [
                    'announcement_id' => $announcement->announcement_id,
                    'message'         => $error->getMessage(),
                ]);
            }
        }

        $this->info($due->count() . ' announcement(s) published.');
    }
}