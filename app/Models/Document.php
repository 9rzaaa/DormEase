<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $primaryKey = 'document_id';

    protected $fillable = [
        'title',
        'document_type',
        'visibility',
        'tenant_id',
        'file_path',
        'uploaded_by',
        'date_posted',
    ];

    protected $casts = [
        'date_posted' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    public function getTenantNameAttribute()
    {
        if ($this->tenant) {
            return $this->tenant->first_name . ' ' . $this->tenant->last_name;
        }
        return null;
    }

    protected $appends = ['tenant_name'];
}