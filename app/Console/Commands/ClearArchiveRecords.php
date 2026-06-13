<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArchiveSetting;
use App\Models\WaterBilling;
use App\Models\VisitorLog;
use App\Models\Announcement;
use App\Models\ArchivedTenant;
use App\Models\ArchivedMaintReq;
use App\Models\ArchivedEmergencyReport;
use App\Models\ArchivedStaff;
use App\Helpers\NotificationHelper;
use Carbon\Carbon;

class ClearArchiveRecords extends Command
{
    protected $signature   = 'archive:clear';
    protected $description = 'Clear archive records based on retention settings';

    private array $moduleConfig = [
        'water_billing'      => ['model' => WaterBilling::class,            'column' => 'billing_month'],
        'visitor_logs'       => ['model' => VisitorLog::class,              'column' => 'arrival_time'],
        'announcements'      => ['model' => Announcement::class,            'column' => 'posted_at'],
        'tenant_archive'     => ['model' => ArchivedTenant::class,          'column' => 'archived_at'],
        'maintenance_archive'=> ['model' => ArchivedMaintReq::class,        'column' => 'archived_at'],
        'emergency_archive'  => ['model' => ArchivedEmergencyReport::class, 'column' => 'archived_at'],
        'staff_archive'      => ['model' => ArchivedStaff::class,           'column' => 'archived_at'],
    ];

    private array $moduleLabels = [
        'water_billing'       => 'Water Billing',
        'visitor_logs'        => 'Visitor Logs',
        'announcements'       => 'Announcements',
        'tenant_archive'      => 'Tenant Archive',
        'maintenance_archive' => 'Maintenance Archive',
        'emergency_archive'   => 'Emergency Archive',
        'staff_archive'       => 'Staff Archive',
    ];

    public function handle(): void
    {
        $settings = ArchiveSetting::where('is_enabled', true)->get();

        foreach ($settings as $setting) {
            $config = $this->moduleConfig[$setting->module] ?? null;
            if (!$config) {
                continue;
            }

            $label      = $this->moduleLabels[$setting->module];
            $cutoff     = Carbon::now()->subDays($setting->retention_days);
            $clearDate = Carbon::now()->subDays($setting->retention_days - $setting->warn_days_before);

            if ($clearDate->isToday()) {
                NotificationHelper::sendToAll(
                    type: 'billing_overdue',
                    message: "Scheduled auto-clear for {$label} will run in {$setting->warn_days_before} day(s) on " . Carbon::now()->addDays($setting->warn_days_before)->format('F d, Y') . ". Records older than {$setting->retention_days} days will be permanently deleted. Disable the setting to cancel.",
                );
            }

            $model  = $config['model'];
            $column = $config['column'];

            if ($setting->module === 'announcements') {
                $model::withTrashed()->where($column, '<', $cutoff)->forceDelete();
            } elseif ($setting->module === 'visitor_logs') {
                $model::where(function($query) use ($column, $cutoff) {
                    $query->where($column, '<', $cutoff)
                          ->orWhere(function($q) use ($cutoff) {
                              $q->whereNull('arrival_time')
                                ->where('date_of_visit', '<', $cutoff->toDateString());
                          });
                })->delete();
            } else {
                $model::where($column, '<', $cutoff)->delete();
            }

            $setting->last_cleared_at = Carbon::now();
            $setting->save();

            NotificationHelper::sendToAll(
                type: 'billing_overdue',
                message: "Auto-clear completed for {$label}. Records older than {$setting->retention_days} days have been permanently deleted.",
            );

            $this->info("Cleared: {$label}");
        }
    }
}