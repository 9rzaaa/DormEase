<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Tenant extends Authenticatable
{
    protected $table = 'tenants';
    protected $primaryKey = 'tenant_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password_hash',
        'contact_number', 'room_number', 'floor',
        'stay_type', 'move_in_date', 'is_active',
    ];

    protected $hidden = ['password_hash'];

    public function getAuthPassword() { return $this->password_hash; }
}