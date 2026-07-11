<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedStaff extends Model
{
    protected $table = 'staff_archive';
    public $timestamps = false;

    protected $fillable = [
        'original_staff_id',
        'account_id',
        'staff_code',
        'first_name',
        'last_name',
        'email',
        'role',
        'contact_number',
        'staff_address',
        'valid_id_path',
        'profile_picture',
        'shift_schedule',
        'duty_status',
        'is_on_leave',
        'leave_start',
        'leave_end',
        'leave_note',
        'is_active',
        'archived_at',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_on_leave' => 'boolean',
        'leave_start' => 'date',
        'leave_end'   => 'date',
        'archived_at' => 'datetime',
    ];
}
