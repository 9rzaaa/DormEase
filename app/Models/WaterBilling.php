<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterBilling extends Model
{
    protected $table      = 'water_billing';
    protected $primaryKey = 'billing_id';

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'rate_id',      
        'inputted_by',
        'billing_month',
        'floor',
        'floor_consumption_m3',
        'prev_reading',
        'curr_reading',
        'total_floor_bill',
        'rooms_sharing',
        'occupants_in_room',
        'room_share',
        'payment_status',
        'proof_of_payment',
        'payment_reference_code',
        'payment_submitted_at',
        'due_date',
    ];

    protected $casts = [
        'billing_month'        => 'date',
        'due_date'             => 'date',
        'floor_consumption_m3' => 'decimal:2',
        'prev_reading'         => 'decimal:2',
        'curr_reading'         => 'decimal:2',
        'total_floor_bill'     => 'decimal:2',
        'room_share'           => 'decimal:2',
        'payment_submitted_at'  => 'datetime',
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
    public function rate()
    {
        return $this->belongsTo(WaterRate::class, 'rate_id', 'rate_id');
    }

    public function inputtedBy()
    {
        return $this->belongsTo(Staff::class, 'inputted_by', 'staff_id');
    }
}
