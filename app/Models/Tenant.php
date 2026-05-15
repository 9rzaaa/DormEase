<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Tenant extends Authenticatable
{
    use HasApiTokens;
    protected $primaryKey = 'tenant_id';

    protected $fillable = [
        'account_id',
        'password_hash',
        'is_temp_password',
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'profile_photo',
        'room_number',
        'floor',
        'stay_type',
        'move_in_date',
        'move_out_date',
        'status',
        'is_active',
        'last_login_at',
        'notes',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public static function generateAccountId(): string
    {
        $year   = now()->year;
        $prefix = "TNT-{$year}-";

        $last = self::where('account_id', 'like', "{$prefix}%")
            ->orderBy('account_id', 'desc')
            ->first();

        if (!$last) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) substr($last->account_id, -3);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
    public static function generateTempPassword(): string
    {
        return Str::random(8);
    }

    public function waterBillings()
    {
        return $this->hasMany(WaterBilling::class, 'tenant_id', 'tenant_id');
    }
}
