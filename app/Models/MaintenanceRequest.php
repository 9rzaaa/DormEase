<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $table = 'maintenance_requests';
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'room_number',
        'input_type',
        'issue_type',
        'description',
        'urgency_level',
        'status',
        'admin_notes',
        'admin_notes_at',
        'assigned_to',
        'photo_path',
        'submitted_at',
        'resolved_at',
        'resubmission_requested_at',
    ];

    protected $casts = [
        'submitted_at'              => 'datetime',
        'resolved_at'               => 'datetime',
        'admin_notes_at'            => 'datetime',
        'resubmission_requested_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}
