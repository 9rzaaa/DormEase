<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::where('status', 'active')
            ->latest('posted_at')
            ->get()
            ->map(function ($a) {
                return [
                    'id'         => $a->announcement_id,
                    'title'      => $a->title,
                    'preview'    => $a->content,
                    'priority'   => ucfirst($a->priority),  // 'low' → 'Low'
                    'date'       => $a->posted_at
                        ? \Carbon\Carbon::parse($a->posted_at)
                        ->format('F j, Y · g:i A')
                        : null,
                    'attachments' => $a->attachment,
                    'files'      => $a->attachment
                        ? count(explode(',', $a->attachment))
                        : 0,
                    'image'      => null,
                    'pinned'     => false,
                    'read'       => false,
                ];
            });

        return response()->json($announcements);
    }
}
