<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs'; // IMPORTANT (your DB table)

    protected $primaryKey = 'visitor_id';

    protected $fillable = [
        'visitor_name',
        'contact_no',
        'purpose',
        'id_type',
        'date_of_visit',
        'arrival_time',
        'departure_time',
        'status',
        'tenant_id',
        'staff_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}