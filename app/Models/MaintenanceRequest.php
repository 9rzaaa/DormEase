<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $table = 'maintenance_requests';
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id', 'input_type', 'issue_type', 'description',
        'urgency_level', 'status', 'assigned_to',
        'admin_notes', 'submitted_at', 'resolved_at',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}