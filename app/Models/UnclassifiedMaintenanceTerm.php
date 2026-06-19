<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnclassifiedMaintenanceTerm extends Model
{
    protected $table = 'unclassified_maintenance_terms';
    protected $fillable = [
        'request_id', 'description_snapshot', 'status',
    ];
}