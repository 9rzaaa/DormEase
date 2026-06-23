<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $table      = 'staff';
    protected $primaryKey = 'staff_id';
    public $timestamps    = false;

    protected $fillable = [
        'staff_code',
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'is_temp_password',
        'role',
        'position',
        'account_id',
        'contact_number',
        'shift_schedule',
        'shift_start',
        'shift_end',
        'last_login_at',
        'duty_status',
        'is_on_leave',
        'leave_start',
        'leave_end',
        'leave_note',
        'attachment',
        'profile_picture',
        'is_active',
        'inactivated_at',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'is_temp_password' => 'boolean',
        'is_active'        => 'boolean',
        'is_on_leave'      => 'boolean',
        'leave_start'      => 'date',
        'leave_end'        => 'date',
        'inactivated_at' => 'datetime',
        'last_login_at'  => 'datetime',
        'shift_start'    => 'string',
        'shift_end'      => 'string',
    ];

    public function setContactNumberAttribute($value)
    {
        if (!$value) {
            $this->attributes['contact_number'] = null;
            return;
        }

        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) === 12 && str_starts_with($digits, '63')) {
            $digits = '0' . substr($digits, 2);
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '09')) {
            $this->attributes['contact_number'] = substr($digits, 0, 4) . '-' . substr($digits, 4, 3) . '-' . substr($digits, 7, 4);
            return;
        }

        $this->attributes['contact_number'] = $value;
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    protected static function booted(): void
    {
        static::created(function (Staff $staff) {
            if (! $staff->account_id) {
                $staff->updateQuietly([
                    'account_id' => 'STF-' . str_pad($staff->staff_id, 4, '0', STR_PAD_LEFT),
                ]);
            }
        });
    }
}