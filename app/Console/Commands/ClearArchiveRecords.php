<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArchiveSetting;
use App\Services\ArchiveExportService;
use App\Helpers\NotificationHelper;
use Carbon\Carbon;

class ClearArchiveRecords extends Command
{
    protected $signature   = 'archive:clear';
    protected $description = 'Export and clear archive records based on retention settings';

    private array $moduleLabels = [
        'water_billing'       => 'Water Billing',
        'visitor_logs'        => 'Visitor Logs',
        'announcements'       => 'Announcements',
        'tenant_archive'      => 'Tenant Archive',
        'maintenance_archive' => 'Maintenance Archive',
        'emergency_archive'   => 'Emergency Archive',
        'staff_archive'       => 'Staff Archive',
    ];

    public function handle(ArchiveExportService $exportService): void
    {
        $settings = ArchiveSetting::where('is_enabled', true)->get();

        foreach ($settings as $setting) {
            if (!array_key_exists($setting->module, $this->moduleLabels)) {
                continue;
            }

            $label = $this->moduleLabels[$setting->module];
            $clearDate = Carbon::now()->subDays($setting->retention_days - $setting->warn_days_before);

            if ($clearDate->isToday()) {
                NotificationHelper::sendToAll(
                    type: 'billing_overdue',
                    message: "Scheduled auto-clear for {$label} will run in {$setting->warn_days_before} day(s) on " . Carbon::now()->addDays($setting->warn_days_before)->format('F d, Y') . ". Records older than {$setting->retention_days} days will be exported and removed. Disable the setting to cancel.",
                );
            }

            $result = $exportService->export($setting->module, $setting->retention_days);

            $setting->last_cleared_at = Carbon::now();
            $setting->save();

            if ($result['deleted'] > 0) {
                NotificationHelper::sendToAll(
                    type: 'billing_overdue',
                    message: "Auto-clear completed for {$label}. {$result['deleted']} record(s) older than {$setting->retention_days} days were exported and removed.",
                );
            }

            $this->info("Processed: {$label}");
        }
    }
}