<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyReport extends Model
{
    protected $table = 'emergency_reports';
    protected $primaryKey = 'report_id';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id', 'is_panic_alert', 'emergency_type', 'input_type',
        'description', 'location', 'status', 'urgency_level',
        'admin_notes', 'reported_at', 'resolved_at',
    ];

    protected $casts = [
        'is_panic_alert' => 'boolean',
        'reported_at'    => 'datetime',
        'resolved_at'    => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    protected static function booted()
    {
        static::created(function ($report) {
            if ($report->tenant_id && $report->tenant) {
                $tenant = $report->tenant;
                $guardianNumber = $tenant->guardian_number;

                if ($guardianNumber) {
                    $tenantName = "{$tenant->first_name} {$tenant->last_name}";
                    $type = $report->emergency_type;
                    $location = $report->location ?: "Room {$tenant->room_number}";
                    $urgency = strtoupper($report->urgency_level ?: 'moderate');
                    
                    $message = "DormEase EMERGENCY ALERT: Tenant {$tenantName} (Room {$tenant->room_number}) has submitted a {$urgency} emergency report. Type: {$type}. Location: {$location}.";
                    
                    try {
                        \App\Services\SmsService::send($guardianNumber, $message);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Failed to send guardian SMS for report {$report->report_id}: " . $e->getMessage());
                    }
                }
            }
        });
    }
}

