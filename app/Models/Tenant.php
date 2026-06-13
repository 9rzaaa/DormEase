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
        'referred_by',
        'profile_photo',
        'room_number',
        'floor',
        'stay_type',
        'move_in_date',
        'move_out_date',
        'estimated_move_in_date',
        'reservation_notes',
        'status',
        'is_active',
        'last_login_at',
        'notes',
        'is_inside',
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
        return \Illuminate\Support\Facades\DB::transaction(function () use ($prefix) {
            $last = self::where('account_id', 'like', "{$prefix}%")
                ->lockForUpdate()
                ->orderBy('account_id', 'desc')
                ->first();
            $nextNumber = 1;
            if ($last) {
                $matches = [];
                if (preg_match('/(\d{3})$/', $last->account_id, $matches)) {
                    $nextNumber = (int) $matches[1] + 1;
                }
            }
            return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }
    public static function generateTempPassword(): string
    {
        return Str::random(8);
    }

    public function waterBillings()
    {
        return $this->hasMany(WaterBilling::class, 'tenant_id', 'tenant_id');
    }

    public function markAccessed(): void
    {
        if ($this->status === 'pending') {
            $this->update(['status' => 'active']);
            \App\Helpers\NotificationHelper::sendToAll(
                type: 'tenant_activated',
                message: "{$this->first_name} {$this->last_name} has logged in and their account is now active.",
                ref_id: $this->tenant_id,
            );
        }
    }
}
