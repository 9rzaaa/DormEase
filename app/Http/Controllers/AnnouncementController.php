<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use App\Helpers\NotificationHelper;

class AnnouncementController extends Controller
{
    public function index()
    {
        $staff         = Auth::guard('staff')->user();
        $announcements = Announcement::latest('posted_at')->get();
        return view('announcements', [
            'staff'         => $staff,
            'announcements' => $announcements,
        ]);
    }

    public function frontdeskIndex()
    {
        $staff         = Auth::guard('staff')->user();
        $announcements = Announcement::latest('posted_at')->get();
        return view('fdannouncement', [
            'staff'         => $staff,
            'announcements' => $announcements,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'priority' => 'nullable|in:low,moderate,high',
            'status'   => 'nullable|in:active,closed',
            'files.*'  => 'nullable|file|max:5120',
        ]);

        $attachment = null;
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('announcements', 'public');
            }
            $attachment = implode(',', $paths);
        }

        Announcement::create([
            'posted_by'  => Auth::guard('staff')->id(),
            'title'      => $request->title,
            'content'    => $request->content,
            'priority'   => $request->priority ?? 'low',
            'status'     => $request->status ?? 'active',
            'attachment' => $attachment,
            'posted_at'  => now(),
        ]);

        NotificationHelper::sendToAll(
            type: 'announcement_new',
            message: 'New announcement posted: ' . $request->title,
        );

        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';

        return redirect()->route($route)
            ->with('success', 'Announcement posted successfully.');
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'priority' => 'nullable|in:low,moderate,high',
            'status'   => 'nullable|in:active,closed',
            'files.*'  => 'nullable|file|max:5120',
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
                $existing = $announcement->attachment
                    ? array_filter(array_map('trim', explode(',', $announcement->attachment)))
                    : [];
                $attachment = implode(',', array_merge($existing, $paths));
            }
        }

        $announcement->update([
            'title'      => $request->title,
            'content'    => $request->content,
            'priority'   => $request->priority ?? 'low',
            'status'     => $request->status ?? 'active',
            'attachment' => $attachment,
        ]);

        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';

        return redirect()->route($route)
            ->with('success', 'Announcement updated successfully.');
    }

    public function archive(Request $request, $id)
    {
        Announcement::findOrFail($id)->update(['status' => 'closed']);
        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';
        return redirect()->route($route)
            ->with('success', 'Announcement archived.');
    }

    public function restore(Request $request, $id)
    {
        Announcement::findOrFail($id)->update(['status' => 'active']);
        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';
        return redirect()->route($route)
            ->with('success', 'Announcement restored.');
    }

    public function destroy(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        if ($announcement->attachment) {
            foreach (explode(',', $announcement->attachment) as $path) {
                Storage::disk('public')->delete(trim($path));
            }
        }
        $announcement->delete();
        $route = $request->input('_from') === 'frontdesk'
            ? 'frontdesk.announcements'
            : 'announcements.index';
        return redirect()->route($route)
            ->with('success', 'Announcement deleted.');
    }
}