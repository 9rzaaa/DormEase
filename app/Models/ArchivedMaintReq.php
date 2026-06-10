<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedMaintReq extends Model
{
    protected $table = 'archived_maintenance_requests';

    public $timestamps = false;

    protected $fillable = [
        'original_id',
        'archive_type',
        'tenant_id',
        'tenant_name',
        'room_number',
        'issue_type',
        'description',
        'urgency_level',
        'status',
        'admin_notes',
        'assigned_to',
        'photo_path',
        'submitted_at',
        'resolved_at',
        'archived_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'resolved_at'  => 'datetime',
        'archived_at'  => 'datetime',
    ];
}
