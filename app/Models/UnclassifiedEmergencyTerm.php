<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UnclassifiedEmergencyTerm extends Model
{
    protected $table = 'unclassified_emergency_terms';
    protected $fillable = [
        'report_id', 'description_snapshot', 'status',
    ];
}