<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notif_id';
    public $timestamps = false;
    private const MAX_ROWS = 100;

    protected $fillable = [
        'tenant_id', 'staff_id', 'type', 'message',
        'ref_id', 'is_read', 'created_at',
    ];

    public static function makeRoomFor(int $incomingRows = 1): void
    {
        $keepRows = max(0, self::MAX_ROWS - $incomingRows);

        if ($keepRows === 0) {
            self::query()->delete();
            return;
        }

        $keepIds = self::query()
            ->orderByDesc('created_at')
            ->orderByDesc('notif_id')
            ->limit($keepRows)
            ->pluck('notif_id');

        self::query()
            ->whereNotIn('notif_id', $keepIds)
            ->delete();
    }

    public static function pruneToLimit(): void
    {
        self::makeRoomFor(0);
    }
}
