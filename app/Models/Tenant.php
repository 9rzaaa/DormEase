<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Tenant extends Authenticatable
{
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
    ];

    protected $hidden = [
        'password_hash',
    ];

    // tells Laravel to use password_hash column for authentication
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // ── Auto-generate Account ID ──────────────────────────────────────────────
    // format: TNT-2026-001, TNT-2026-002, TNT-2026-003...
    public static function generateAccountId(): string
    {
        $year   = now()->year;
        $prefix = "TNT-{$year}-";

        // find the last account ID for this year
        $last = self::where('account_id', 'like', "{$prefix}%")
            ->orderBy('account_id', 'desc')
            ->first();

        if (!$last) {
            // first tenant this year
            $nextNumber = 1;
        } else {
            // extract the number from the last account ID and increment
            $lastNumber = (int) substr($last->account_id, -3);
            $nextNumber = $lastNumber + 1;
        }

        // pad with zeros to always be 3 digits — 001, 002, 003...
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    // ── Auto-generate Temporary Password ─────────────────────────────────────
    // format: 8 character random string e.g. Xk9mP2qL
    public static function generateTempPassword(): string
    {
        return Str::random(8);
    }
}
