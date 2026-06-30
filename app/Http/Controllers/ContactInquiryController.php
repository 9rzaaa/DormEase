<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $type = $request->query('type', 'all');
        $search = trim((string) $request->query('search', ''));

        $baseQuery = ContactInquiry::query();

        $inquiries = ContactInquiry::query()
            ->with('handler')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($type !== 'all', fn ($query) => $query->where('inquiry_type', $type))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $deletedInquiries = ContactInquiry::onlyTrashed()
            ->with('handler')
            ->latest('deleted_at')
            ->get();

        return view('contact-inquiries', [
            'inquiries' => $inquiries,
            'stats' => [
                'total' => (clone $baseQuery)->count(),
                'new' => (clone $baseQuery)->where('status', 'new')->count(),
                'read' => (clone $baseQuery)->where('status', 'read')->count(),
                'resolved' => (clone $baseQuery)->where('status', 'resolved')->count(),
            ],
            'status' => $status,
            'type' => $type,
            'search' => $search,
            'deletedInquiries' => $deletedInquiries,
        ]);
    }

    public function destroy(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('contact-inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }

    public function updateStatus(Request $request, ContactInquiry $contactInquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,read,resolved'],
        ]);

        $status = $validated['status'];

        $contactInquiry->update([
            'status' => $status,
            'handled_by' => $status === 'new' ? null : auth('staff')->id(),
            'handled_at' => $status === 'new' ? null : now(),
        ]);

        return back()->with('success', 'Inquiry status updated.');
    }
}