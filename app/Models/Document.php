<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_id';
    public $timestamps = false;

    protected $fillable = [
        'uploaded_by',
        'tenant_id',
        'title',
        'document_type',
        'visibility',
        'file_path',
        'file_size',
    ];

    protected $appends = ['tenant_name'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    public function uploader()
    {
        return $this->belongsTo(Staff::class, 'uploaded_by');
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