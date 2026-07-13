<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HardwareDevice extends Model
{
    protected $fillable = [
        'device_name',
        'device_type',
        'location',
        'floor',
        'device_token',
        'is_active',
        'last_ping_at',
        'firmware_version',
        'ip_address',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'last_ping_at'  => 'datetime',
    ];

    public static function generateToken(): string
    {
        return Str::random(64);
    }

    public function logs()
    {
        return $this->hasMany(TenantLog::class, 'device_id');
    }
}