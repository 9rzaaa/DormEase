<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DownloadableForm;
use Illuminate\Support\Facades\Storage;

class DocumentRequestController extends Controller
{
    public function index(Request $request)
    {
        $records = DocumentRequest::where('tenant_id', $request->user()->tenant_id)
            ->orderBy('submitted_at', 'desc')
            ->get();

        return response()->json($records);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'category'      => 'nullable|in:form,certificate',
            'purpose'       => 'nullable|string',
            'delivery_type' => 'nullable|in:digital,printed',
            'date_needed'   => 'nullable|date',
            'attachment'    => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                                ->store('document-requests/attachments', 'public');
        }

        $deliveryType = $request->input('delivery_method') ?? $request->input('delivery_type');

        $documentRequest = DocumentRequest::create([
            'tenant_id'     => $request->user()->tenant_id,
            'document_type' => $request->document_type,
            'category'      => $request->category,
            'purpose'       => $request->purpose,
            'delivery_type' => $deliveryType,
            'date_needed'   => $request->date_needed,
            'attachment'    => $attachmentPath,
            'status'        => 'pending',
            'submitted_at'  => now(),
        ]);

        $tenant = $request->user();
        NotificationHelper::sendToAll(
            type: 'document_request',
            message: "New {$documentRequest->document_type} request from {$tenant->first_name} {$tenant->last_name}.",
            ref_id: $documentRequest->doc_request_id,
        );

        return response()->json([
            'message' => 'Request submitted successfully.',
            'data'    => $documentRequest,
        ], 201);
    }

    public function tenantDocuments(Request $request)
{
    $tenantId = $request->user()->tenant_id;

    $docs = Document::where(function ($q) use ($tenantId) {
            $q->where('visibility', 'all')
              ->orWhere(function ($q2) use ($tenantId) {
                  $q2->where('visibility', 'specific')
                     ->where('tenant_id', $tenantId);
              });
        })
        ->orderByDesc('created_at')
        ->get(['document_id', 'title', 'document_type', 'file_path', 'visibility', 'created_at']);

    return response()->json($docs);
}
public function tenantForms()
{
    $forms = DownloadableForm::orderBy('label')->get()->map(function ($f) {
        // Files in public/forms/ are static — use asset()
        // Files in downloadable-forms/ are in Laravel storage
        $url = str_starts_with($f->file_path, 'forms/')
            ? asset($f->file_path)
            : Storage::disk('public')->url($f->file_path);

        return [
            'id'        => $f->id,
            'label'     => $f->label,
            'file_path' => $f->file_path,
            'url'       => $url,
        ];
    });

    return response()->json($forms);
}
}
