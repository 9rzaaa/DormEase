<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

    /**
     * Blade page
     */
    public function page()
    {
        return view('documents');
    }

    /**
     * API: GET /api/documents
     */
    public function index(Request $request)
    {
        $query = Document::query()->latest();

        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('tenant_name', 'like', "%{$s}%");
            });
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $perPage   = min((int) $request->get('per_page', 9), 50);
        $paginated = $query->paginate($perPage);

        $counts = Document::selectRaw('document_type, COUNT(*) as total')
            ->groupBy('document_type')
            ->pluck('total', 'document_type')
            ->toArray();

        return response()->json(
            array_merge($paginated->toArray(), ['counts' => $counts])
        );
    }

    /**
     * API: POST /api/documents
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'document_type' => ['required', Rule::in(self::TYPES)],
            'tenant_name'   => 'nullable|string|max:255',
            'status'        => 'nullable|in:Active,Archived',
            'file'          => 'nullable|file|max:20480',
        ]);

        $filePath = $fileName = $fileType = null;

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getMimeType();
            $filePath = $file->store('documents', 'public');
        }

        $doc = Document::create([
            'title'         => $validated['title'],
            'document_type' => $validated['document_type'],
            'tenant_name'   => $validated['tenant_name'] ?? null,
            'status'        => $validated['status'] ?? 'Active',
            'file_path'     => $filePath,
            'file_name'     => $fileName,
            'file_type'     => $fileType,
            'uploaded_by'   => auth('staff')->id(),
        ]);

        return response()->json($doc, 201);
    }

    /**
     * API: GET /api/documents/{document}
     */
    public function show(Document $document)
    {
        return response()->json($document);
    }

    /**
     * API: PUT /api/documents/{document}
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title'         => 'sometimes|required|string|max:255',
            'document_type' => ['sometimes', 'required', Rule::in(self::TYPES)],
            'tenant_name'   => 'nullable|string|max:255',
            'status'        => 'nullable|in:Active,Archived',
        ]);

        $document->update($validated);

        return response()->json($document);
    }

    /**
     * API: DELETE /api/documents/{document}
     */
    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}