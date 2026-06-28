<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $primaryKey = 'contact_inquiry_id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'inquiry_type',
        'message',
        'status',
        'handled_by',
        'handled_at',
        'ip_address',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];

    public function handler()
    {
        return $this->belongsTo(Staff::class, 'handled_by', 'staff_id');
    }
}
