<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number', 'floor', 'capacity', 'stay_type', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'room_number', 'room_number')
            ->whereNotIn('status', ['inactive', 'move_out']);
    }

    public function getOccupancyAttribute(): int
    {
        return $this->tenants()->count();
    }

    public function getIsFullAttribute(): bool
    {
        return $this->occupancy >= $this->capacity;
    }
}