<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantLog extends Model
{
    public $timestamps = false;

    protected $table = 'tenant_logs';

    protected $fillable = [
        'tenant_id',
        'account_id',
        'first_name',
        'last_name',
        'room_number',
        'floor',
        'action',
        'logged_at',
        'logged_by',
        'device_id',
        'hardware_device_type',
        'raw_payload',
    ];

    protected $casts = [
        'logged_at'   => 'datetime',
        'raw_payload' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}