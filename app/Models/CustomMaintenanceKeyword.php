<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomMaintenanceKeyword extends Model
{
    protected $table = 'custom_maintenance_keywords';
    protected $fillable = [
        'keyword', 'issue_type', 'urgency_level', 'added_by_staff_id',
    ];
    protected $appends = ['added_by_name', 'added_at_formatted'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'added_by_staff_id', 'staff_id');
    }

    public function getAddedByNameAttribute()
    {
        if (!$this->staff) {
            return 'Unknown';
        }

        return trim($this->staff->first_name . ' ' . $this->staff->last_name);
    }

    public function getAddedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('F j, Y') : null;
    }
}