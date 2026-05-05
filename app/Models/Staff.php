<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    public $timestamps = false;

    protected $fillable = [
        'staff_code',
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'role',
        'contact_number',
        'shift_schedule',
        'duty_status',
        'attachment',
        'is_active',
    ];

    protected $hidden = ['password_hash'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}