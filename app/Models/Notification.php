<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notif_id';
    public $timestamps = false;
    protected $fillable = [
        'tenant_id', 'staff_id', 'type', 'message',
        'ref_id', 'is_read', 'created_at',
    ];
}