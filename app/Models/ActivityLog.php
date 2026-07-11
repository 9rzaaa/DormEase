<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'staff_id',
        'staff_name',
        'staff_role',
        'module',
        'action',
        'description',
        'method',
        'route_name',
        'path',
        'ip_address',
        'user_agent',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];
}
