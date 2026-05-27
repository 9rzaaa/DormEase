<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper;

class DocumentController extends Controller
{
    private const TYPES = [
        'Voucher',
        'Turnover Sheet',
        'Tenant Info Sheet',
        'Sleepover of Non-Tenants',
        'Letter for Renewal',
        'Guards Form',
        'Approval to Leave After Curfew',
        'After Curfew Arrivals',
        'Move In/Out List',
    ];

    public function page()
    {
        $fromDb   = Document::distinct()->pluck('document_type')->filter()->values()->toArray();
        $docTypes = collect(array_unique(array_merge(self::TYPES, $fromDb)))->values();

        $tenants = Tenant::select('tenant_id', 'first_name', 'last_name', 'room_number')
                        ->orderBy('first_name')
                        ->get();

        return view('documents', compact('docTypes', 'tenants'));
    }

    public function index(Request $request)
    {
        try {
            $docs = Document::with('tenant')->orderBy('date_posted', 'desc')->get();
            return response()->json($docs);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'visibility'    => 'required|in:all,specific,admin',
            'tenant_id'     => 'nullable|exists:tenants,tenant_id',
            'file'          => 'nullable|file|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        $doc = Document::create([
            'title'         => $validated['title'],
            'document_type' => $validated['document_type'],
            'visibility'    => $validated['visibility'],
            'tenant_id'     => $validated['tenant_id'] ?? null,
            'file_path'     => $filePath,
            'uploaded_by'   => auth('staff')->id(),
            'date_posted'   => now(),
        ]);

        $doc->load('tenant');
        NotificationHelper::sendToAll(
        type: 'document_request',
        message: "New document uploaded: {$doc->title}",
        ref_id: $doc->id,
    );
        return response()->json($doc, 201);
    }

    public function show(Document $document)
    {
        $document->load('tenant');
        return response()->json($document);
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title'         => 'sometimes|required|string|max:255',
            'document_type' => 'sometimes|required|string|max:255',
            'visibility'    => 'sometimes|required|in:all,specific,admin',
            'tenant_id'     => 'nullable|exists:tenants,tenant_id',
        ]);

        $document->update($validated);
        $document->load('tenant');
        return response()->json($document);
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}