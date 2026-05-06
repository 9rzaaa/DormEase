<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'announcement_id';
    public $timestamps = false;

    protected $fillable = [
        'posted_by', 'title', 'content',
        'priority', 'status', 'attachment', 'posted_at',
    ];
}