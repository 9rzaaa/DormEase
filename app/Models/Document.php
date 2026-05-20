<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'document_type',
        'tenant_name',
        'file_path',
        'file_name',
        'file_type',
        'status',
        'uploaded_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function uploader()
    {
        return $this->belongsTo(Staff::class, 'uploaded_by');
    }
}