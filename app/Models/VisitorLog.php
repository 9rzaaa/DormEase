<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\Staff;

class VisitorLog extends Model
{
    public $timestamps = false;

    public function getUpdatedAtColumn()
    {
        return null;
    }

    public function getCreatedAtColumn()
    {
        return null;
    }

    protected $primaryKey = 'visitor_id';

    protected $fillable = [
        'tenant_id',
        'confirmed_by',
        'visitor_name',
        'contact_no',
        'purpose',
        'id_type',
        'id_photo',
        'date_of_visit',
        'time_of_visit',
        'arrival_time',
        'departure_time',
        'status',
        'hidden_from_tenant',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'confirmed_by', 'staff_id');
        }
}
