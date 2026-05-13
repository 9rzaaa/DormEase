<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterBilling extends Model
{
    protected $table      = 'water_billing';  // ERD table name — no 's'
    protected $primaryKey = 'billing_id';     // ERD PK

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',             // ERD: tenant_id FK → tenants
        'rate_id',               // ERD: rate_id FK  → water_rates
        'inputted_by',           // ERD: inputted_by FK → staff
        'billing_month',         // ERD: billing_month (date)
        'floor',                 // ERD: floor (tinyint)
        'floor_consumption_m3',  // ERD: floor_consumption_m3 (decimal)
        'prev_reading',          // ERD: prev_reading (decimal)
        'curr_reading',          // ERD: curr_reading (decimal)
        'total_floor_bill',      // ERD: total_floor_bill (decimal)
        'rooms_sharing',         // ERD: rooms_sharing (int)
        'occupants_in_room',     // ERD: occupants_in_room (int)
        'room_share',            // ERD: room_share (decimal)
        'payment_status',        // ERD: payment_status (varchar)
        'due_date',              // ERD: due_date (date)
    ];

    protected $casts = [
        'billing_month'        => 'date',
        'due_date'             => 'date',
        'floor_consumption_m3' => 'decimal:2',
        'prev_reading'         => 'decimal:2',
        'curr_reading'         => 'decimal:2',
        'total_floor_bill'     => 'decimal:2',
        'room_share'           => 'decimal:2',
    ];

    /* ── Relationships ── */

    // ERD: tenant_id FK → tenants (tenant_id PK)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    // ERD: rate_id FK → water_rates (rate_id PK)
    public function rate()
    {
        return $this->belongsTo(WaterRate::class, 'rate_id', 'rate_id');
    }

    // ERD: inputted_by FK → staff (staff_id PK)
    public function inputtedBy()
    {
        return $this->belongsTo(Staff::class, 'inputted_by', 'staff_id');
    }
}