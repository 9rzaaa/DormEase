<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveDocu extends Model
{
    protected $table = 'archive_docus';

    protected $primaryKey = 'archive_id';

    public $timestamps = false;

    protected $fillable = [
        'archivable_type',
        'original_id',
        'archived_by',
        'archived_at',
        'data',
    ];

    protected $casts = [
        'data'        => 'array',
        'archived_at' => 'datetime',
    ];
}