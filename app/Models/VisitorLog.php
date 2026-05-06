<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs';
    protected $primaryKey = 'visitor_id';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id', 'confirmed_by', 'visitor_name', 'contact_no',
        'purpose', 'id_type', 'id_photo', 'date_of_visit',
        'time_of_visit', 'arrival_time', 'departure_time', 'status',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}