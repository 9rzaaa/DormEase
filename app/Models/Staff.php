<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $table = 'staff';
    protected $primaryKey = 'staff_id';

    public $timestamps = false;

    protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password_hash',
    'is_temp_password',
    'role',
    'position',
    'contact_number',
    'shift_schedule',
    'duty_status',
    'attachment',
    'is_active',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'is_temp_password' => 'boolean',
        'is_active'        => 'boolean',
    ];

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