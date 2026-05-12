<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    // visitor_logs table has no created_at / updated_at columns
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
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
