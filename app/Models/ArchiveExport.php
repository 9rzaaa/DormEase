<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveExport extends Model
{
    protected $table = 'archive_exports';

    protected $fillable = [
        'module',
        's3_key',
        'file_name',
        'record_count',
        'date_from',
        'date_to',
        'exported_by',
    ];

    protected $casts = [
        'date_from' => 'datetime',
        'date_to'   => 'datetime',
    ];
}