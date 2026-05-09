<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table      = 'announcements';
    protected $primaryKey = 'announcement_id';
    public $timestamps    = false;

    protected $fillable = [
        'posted_by', 'title', 'content',
        'priority', 'status', 'attachment', 'posted_at',
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