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
        'description', 'location', 'status',
        'admin_notes', 'reported_at', 'resolved_at',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}