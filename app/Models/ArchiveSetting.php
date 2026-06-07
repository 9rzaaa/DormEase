<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveSetting extends Model
{
    protected $table = 'archive_settings';

    public $timestamps = false;

    protected $fillable = [
        'module',
        'is_enabled',
        'retention_days',
        'warn_days_before',
        'last_cleared_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled'      => 'boolean',
        'last_cleared_at' => 'datetime',
        'updated_at'      => 'datetime',
    ];
}