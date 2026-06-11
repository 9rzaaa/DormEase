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

    public static function makeRoomFor(int $incomingRows = 1, ?int $tenantId = null, ?int $staffId = null): void
    {
        $keepRows = max(0, self::MAX_ROWS - $incomingRows);
        $query = self::scopeRecipient(self::query(), $tenantId, $staffId);

        if ($keepRows === 0) {
            $query->delete();
            return;
        }

        $keepIds = self::scopeRecipient(self::query(), $tenantId, $staffId)
            ->orderByDesc('created_at')
            ->orderByDesc('notif_id')
            ->limit($keepRows)
            ->pluck('notif_id');

        self::scopeRecipient(self::query(), $tenantId, $staffId)
            ->whereNotIn('notif_id', $keepIds)
            ->delete();
    }

    public static function pruneToLimit(?int $tenantId = null, ?int $staffId = null): void
    {
        self::makeRoomFor(0, $tenantId, $staffId);
    }

    private static function scopeRecipient($query, ?int $tenantId, ?int $staffId)
    {
        if ($tenantId !== null) {
            return $query->where('tenant_id', $tenantId);
        }

        if ($staffId !== null) {
            return $query->where('staff_id', $staffId);
        }

        return $query;
    }
}
