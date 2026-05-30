<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedEmergencyReport extends Model
{
    protected $table = 'archived_emergency_reports';

    public $timestamps = false;

    protected $fillable = [
        'original_id',
        'archive_type',
        'archived_by_staff_id',
        'archived_by_name',
        'archived_by_role',
        'tenant_id',
        'tenant_name',
        'room_number',
        'is_panic_alert',
        'emergency_type',
        'urgency_level',
        'description',
        'location',
        'status',
        'admin_notes',
        'reported_at',
        'resolved_at',
        'archived_at',
    ];

    protected $casts = [
        'is_panic_alert' => 'boolean',
        'reported_at'    => 'datetime',
        'resolved_at'    => 'datetime',
        'archived_at'    => 'datetime',
    ];
}
