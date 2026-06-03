<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use App\Helpers\NotificationHelper;
use App\Services\TenantPushNotificationService;

class AnnouncementController extends Controller
{
    public function index()
    {
        $staff          = Auth::guard('staff')->user();
        $announcements  = Announcement::latest('posted_at')->get();
        $scheduled      = Announcement::whereNotNull('scheduled_at')
                            ->where('scheduled_at', '>', now())
                            ->where('status', 'scheduled')
                            ->latest('scheduled_at')
                            ->get();
        $deletedArchive = Announcement::onlyTrashed()->latest('deleted_at')->get();

        return view('announcements', [
            'staff'          => $staff,
            'announcements'  => $announcements,
            'scheduled'      => $scheduled,
            'deletedArchive' => $deletedArchive,
        ]);
    }

    public function frontdeskIndex()
    {
        $staff          = Auth::guard('staff')->user();
        $announcements  = Announcement::latest('posted_at')->get();
        $scheduled      = Announcement::whereNotNull('scheduled_at')
                            ->where('scheduled_at', '>', now())
                            ->where('status', 'scheduled')
                            ->latest('scheduled_at')
                            ->get();
        $deletedArchive = Announcement::onlyTrashed()->latest('deleted_at')->get();

        return view('fdannouncement', [
            'staff'          => $staff,
            'announcements'  => $announcements,
            'scheduled'      => $scheduled,
            'deletedArchive' => $deletedArchive,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'priority'     => 'nullable|in:low,moderate,high',
            'status'       => 'nullable|in:active,closed,scheduled',
            'scheduled_at' => 'nullable|date|after:now',
            'files.*'      => 'nullable|file|max:5120',
        ]);

        $attachment = null;
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('announcements', 'public');
            }
            $attachment = implode(',', $paths);
        }

        $isScheduled  = $request->filled('scheduled_at');
        $status       = $isScheduled ? 'scheduled' : ($request->status ?? 'active');
        $scheduledAt  = $isScheduled ? $request->scheduled_at : null;
        $postedAt     = $isScheduled ? null : now();

        $announcement = Announcement::create([
            'posted_by'    => Auth::guard('staff')->id(),
            'title'        => $request->title,
            'content'      => $request->content,
            'priority'     => $request->priority ?? 'low',
            'status'       => $status,
            'attachment'   => $attachment,
            'posted_at'    => $postedAt,
            'scheduled_at' => $scheduledAt,
        ]);

        if (!$isScheduled) {
            app()->terminating(function () use ($announcement, $request) {
                try {
                    NotificationHelper::sendToAll(
                        type: 'announcement_new',
                        message: 'New announcement posted: ' . $request->title,
                        ref_id: $announcement->announcement_id,
                    );

                    app(TenantPushNotificationService::class)->sendToAllTenants(
                        type: 'announcement',
                        title: 'New announcement posted',
                        body: $request->title,
                        refId: $announcement->announcement_id,
                        route: '/tenant/announcements',
                    );
                } catch (\Throwable $error) {
                    Log::error('Announcement notifications failed after posting.', [
                        'announcement_id' => $announcement->announcement_id,
                        'message'         => $error->getMessage(),
                    ]);
                }
            });
        }

        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';

        $message = $isScheduled
            ? 'Announcement scheduled for ' . \Carbon\Carbon::parse($scheduledAt)->format('F j, Y g:i A') . '.'
            : 'Announcement posted successfully.';

        return redirect()->route($route)->with('success', $message);
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'priority'     => 'nullable|in:low,moderate,high',
            'status'       => 'nullable|in:active,closed,scheduled',
            'scheduled_at' => 'nullable|date',
            'files.*'      => 'nullable|file|max:5120',
        ]);

        $attachment = $announcement->attachment;
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('announcements', 'public');
            }

            if ($request->boolean('replace_attachments')) {
                if ($announcement->attachment) {
                    foreach (explode(',', $announcement->attachment) as $path) {
                        Storage::disk('public')->delete(trim($path));
                    }
                }
                $attachment = implode(',', $paths);
            } else {
                $existing   = $announcement->attachment
                    ? array_filter(array_map('trim', explode(',', $announcement->attachment)))
                    : [];
                $attachment = implode(',', array_merge($existing, $paths));
            }
        }

        $isScheduled  = $request->filled('scheduled_at');
        $status       = $isScheduled ? 'scheduled' : ($request->status ?? 'active');
        $scheduledAt  = $isScheduled ? $request->scheduled_at : null;

        $announcement->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'priority'     => $request->priority ?? 'low',
            'status'       => $status,
            'attachment'   => $attachment,
            'scheduled_at' => $scheduledAt,
        ]);

        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';

        return redirect()->route($route)->with('success', 'Announcement updated successfully.');
    }

    public function archive(Request $request, $id)
    {
        Announcement::findOrFail($id)->update(['status' => 'closed']);
        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';
        return redirect()->route($route)->with('success', 'Announcement closed.');
    }

    public function restore(Request $request, $id)
    {
        Announcement::findOrFail($id)->update(['status' => 'active']);
        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';
        return redirect()->route($route)->with('success', 'Announcement restored.');
    }

    public function destroy(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';
        return redirect()->route($route)->with('success', 'Announcement deleted.');
    }
}