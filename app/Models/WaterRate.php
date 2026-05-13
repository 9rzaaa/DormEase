<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterRate extends Model
{
    protected $table      = 'water_rates';
    protected $primaryKey = 'rate_id';

    public $timestamps = false;

    protected $fillable = [
        'rate_per_m3',
        'effective_month',
    ];

    protected $casts = [
        'effective_month' => 'date',
        'rate_per_m3'     => 'decimal:2',
    ];

    public function billings()
    {
        return $this->hasMany(WaterBilling::class, 'rate_id', 'rate_id');
    }
}