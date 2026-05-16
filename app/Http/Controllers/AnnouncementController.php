<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;

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

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'priority'    => 'nullable|in:low,moderate,high',
            'status'      => 'nullable|in:active,closed',
            'files.*'     => 'nullable|file|max:5120',
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

        return redirect()->route('announcements.index')
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
        ]);

        $announcement->update([
            'title'    => $request->title,
            'content'  => $request->content,
            'priority' => $request->priority ?? 'low',
            'status'   => $request->status ?? 'active',
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function archive($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['status' => 'closed']);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement archived.');
    }

    public function restore($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['status' => 'active']);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement restored.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->attachment) {
            foreach (explode(',', $announcement->attachment) as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted.');
    }
}
