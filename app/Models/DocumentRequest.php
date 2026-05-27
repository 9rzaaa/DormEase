<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'doc_request_id';

    protected $fillable = [
        'tenant_id',
        'document_type',
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

    protected $appends = ['tenant_name'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    public function getTenantNameAttribute()
    {
        try {
            return $this->tenant
                ? $this->tenant->first_name . ' ' . $this->tenant->last_name
                : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}