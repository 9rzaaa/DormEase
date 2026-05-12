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

                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                // parse all attachments into an array
                $attachments = $a->attachment
                    ? array_map('trim', explode(',', $a->attachment))
                    : [];

                // separate images from other files
                $images = array_values(array_filter($attachments, function ($file) use ($imageExtensions) {
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    return in_array($ext, $imageExtensions);
                }));

                $otherFiles = array_values(array_filter($attachments, function ($file) use ($imageExtensions) {
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    return !in_array($ext, $imageExtensions);
                }));

                return [
                    'id'          => $a->announcement_id,
                    'title'       => $a->title,
                    'preview'     => $a->content,
                    'priority'    => ucfirst($a->priority),
                    'date'        => $a->posted_at
                        ? \Carbon\Carbon::parse($a->posted_at)->format('F j, Y · g:i A')
                        : null,
                    // first image as card preview
                    'image'       => !empty($images)
                        ? url('storage/' . $images[0])
                        : null,
                    // all attachments for detail modal (images + other files)
                    'attachments' => $a->attachment ?? null,
                    // only non-image files counted as "files"
                    'files'       => count($otherFiles),
                    'pinned'      => false,
                    'read'        => false,
                ];
            });

        return response()->json($announcements);
    }
}