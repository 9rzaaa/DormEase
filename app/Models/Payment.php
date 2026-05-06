<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    protected $fillable = [
        'billing_id', 'tenant_id', 'confirmed_by', 'payment_method',
        'amount_paid', 'proof_of_payment', 'reference_number',
        'payment_date', 'status',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}