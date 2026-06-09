<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    protected $table      = 'staff_attendance';
    protected $primaryKey = 'attendance_id';
    public $timestamps    = false;

    protected $fillable = [
        'staff_id',
        'staff_name',
        'role',
        'shift_schedule',
        'login_at',
        'logout_at',
        'duty_status',
    ];

    protected $casts = [
        'login_at'  => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }
}