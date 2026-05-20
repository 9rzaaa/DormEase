<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $table = 'maintenance_requests';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tenant_id',
        'room_number',
        'issue_type',
        'description',
        'urgency',
        'status',
        'admin_remarks',
        'assigned_to',
        'submitted_at',
        'resolved_at',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}