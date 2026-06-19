<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CustomEmergencyKeyword extends Model
{
    protected $table = 'custom_emergency_keywords';
    protected $fillable = [
        'keyword', 'emergency_type', 'urgency_level', 'added_by_staff_id',
    ];
}