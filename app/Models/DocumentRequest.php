<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    protected $primaryKey = 'doc_request_id';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'document_type',
        'category',
        'purpose',
        'delivery_type',
        'date_needed',
        'attachment',
        'status',
        'admin_remarks',
        'fulfilled_file',
        'submitted_at',
        'processed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
        'date_needed'  => 'date',
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