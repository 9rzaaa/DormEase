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
        'guardian_number',
        'referred_by',
        'profile_photo',
        'tenant_photo',
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
        'is_on_vacation',
        'vacation_note',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'is_on_vacation' => 'boolean',
    ];

    public function setContactNumberAttribute($value)
    {
        $this->attributes['contact_number'] = $this->normalizePhone($value);
    }

    public function setGuardianNumberAttribute($value)
    {
        $this->attributes['guardian_number'] = $this->normalizePhone($value);
    }

    private function normalizePhone($value): ?string
    {
        if (!$value) return null;
        $digits = preg_replace('/\D/', '', $value);
        if (strlen($digits) === 12 && str_starts_with($digits, '63')) {
            $digits = '0' . substr($digits, 2);
        }
        if (strlen($digits) === 11 && str_starts_with($digits, '09')) {
            return substr($digits, 0, 4) . '-' . substr($digits, 4, 3) . '-' . substr($digits, 7, 4);
        }
        return $value;
    }

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

    public function hasUnpaidBills(): bool
    {
        return WaterBilling::where('tenant_id', $this->tenant_id)
            ->where('payment_status', '!=', 'paid')
            ->exists();
    }

    public function hasOngoingMaintenance(): bool
    {
        return MaintenanceRequest::where('tenant_id', $this->tenant_id)
            ->whereIn('status', ['pending', 'in-progress'])
            ->exists();
    }

    public function hasOngoingDocuments(): bool
    {
        return DocumentRequest::where('tenant_id', $this->tenant_id)
            ->whereIn('status', ['pending', 'processing', 'approved', 'resubmission'])
            ->exists();
    }

    public function hasActiveVisitors(): bool
    {
        return VisitorLog::where('tenant_id', $this->tenant_id)
            ->whereNotIn('status', ['completed', 'deleted', 'cancelled', 'rejected'])
            ->exists();
    }
}

