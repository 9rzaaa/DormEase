<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedTenant extends Model
{
    protected $table = 'archived_tenants';
    public $timestamps = false;
    protected $fillable = [
        'original_id',
        'archive_type',
        'account_id',
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'room_number',
        'floor',
        'stay_type',
        'move_in_date',
        'move_out_date',
        'status',
        'archived_at',
    ];
    protected $casts = [
        'move_in_date'  => 'date',
        'move_out_date' => 'date',
        'archived_at'   => 'datetime',
    ];
}