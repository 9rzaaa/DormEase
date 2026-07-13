<?php

namespace App\Services;

use App\Models\ArchiveExport;
use App\Models\WaterBilling;
use App\Models\VisitorLog;
use App\Models\Announcement;
use App\Models\ArchivedTenant;
use App\Models\ArchivedMaintReq;
use App\Models\ArchivedEmergencyReport;
use App\Models\ArchivedStaff;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArchiveExportService
{
    private array $moduleConfig = [
        'water_billing'       => ['model' => WaterBilling::class,            'column' => 'billing_month'],
        'visitor_logs'        => ['model' => VisitorLog::class,              'column' => 'arrival_time'],
        'announcements'       => ['model' => Announcement::class,            'column' => 'posted_at'],
        'tenant_archive'      => ['model' => ArchivedTenant::class,          'column' => 'archived_at'],
        'maintenance_archive' => ['model' => ArchivedMaintReq::class,        'column' => 'archived_at'],
        'emergency_archive'   => ['model' => ArchivedEmergencyReport::class, 'column' => 'archived_at'],
        'staff_archive'       => ['model' => ArchivedStaff::class,           'column' => 'archived_at'],
    ];

    public function export(string $module, int $retentionDays, ?int $exportedBy = null): array
    {
        $config = $this->moduleConfig[$module] ?? null;

        if (!$config) {
            return ['deleted' => 0, 'export' => null];
        }

        $cutoff = Carbon::now()->subDays($retentionDays);
        $model  = $config['model'];
        $column = $config['column'];

        $query = $this->buildQuery($module, $model, $column, $cutoff);
        $records = $query->get();
        $count = $records->count();

        if ($count === 0) {
            return ['deleted' => 0, 'export' => null];
        }

        $payload  = gzencode($records->toJson(), 9);
        $fileName = $module . '_' . Carbon::now()->format('Ymd_His') . '.json.gz';
        $s3Key    = 'archive-exports/' . $module . '/' . $fileName;

        Storage::disk('s3')->put($s3Key, $payload);

        $export = ArchiveExport::create([
            'module'       => $module,
            's3_key'       => $s3Key,
            'file_name'    => $fileName,
            'record_count' => $count,
            'date_from'    => $records->min($column),
            'date_to'      => $records->max($column),
            'exported_by'  => $exportedBy,
        ]);

        $deleteQuery = $this->buildQuery($module, $model, $column, $cutoff);

        if ($module === 'announcements') {
            $deleteQuery->forceDelete();
        } else {
            $deleteQuery->delete();
        }

        return ['deleted' => $count, 'export' => $export];
    }

    private function buildQuery(string $module, string $model, string $column, Carbon $cutoff)
    {
        if ($module === 'announcements') {
            return $model::withTrashed()->where($column, '<', $cutoff);
        }

        if ($module === 'visitor_logs') {
            return $model::where(function ($q) use ($column, $cutoff) {
                $q->where($column, '<', $cutoff)
                    ->orWhere(function ($q2) use ($cutoff) {
                        $q2->whereNull('arrival_time')
                            ->where('date_of_visit', '<', $cutoff->toDateString());
                    });
            });
        }

        return $model::where($column, '<', $cutoff);
    }
}