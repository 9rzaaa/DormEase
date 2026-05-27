<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $table      = 'announcements';
    protected $primaryKey = 'announcement_id';
    public $timestamps    = false;

    protected $fillable = [
        'posted_by',
        'title',
        'content',
        'priority',
        'status',
        'attachment',
        'posted_at',
        'deleted_at',
    ];

    protected $casts = [
        'posted_at'  => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getIdAttribute()
    {
        return $this->announcement_id;
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'posted_by', 'staff_id');
    }
}