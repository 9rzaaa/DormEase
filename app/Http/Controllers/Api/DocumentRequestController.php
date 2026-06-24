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
            ->where('hidden_from_tenant', false)
            ->orderBy('submitted_at', 'desc')
            ->get();

        return response()->json($records);
    }

    public function destroy(Request $request, $id)
    {
        $tenantId = $request->user()?->tenant_id;
        $documentRequest = DocumentRequest::where('tenant_id', $tenantId)
            ->where('doc_request_id', $id)
            ->first();

        if (!$documentRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Document request not found.',
            ], 404);
        }

        if ($documentRequest->status === 'pending') {
            $tenant = $request->user();
            $tenantName = trim($tenant?->first_name . ' ' . $tenant?->last_name);

            \App\Models\ArchiveDocu::create([
                'archivable_type' => 'document_request',
                'original_id'     => $documentRequest->doc_request_id,
                'archived_by'     => null,
                'archived_at'     => now(),
                'data'            => [
                    'doc_request_id' => $documentRequest->doc_request_id,
                    'tenant_id'      => $documentRequest->tenant_id,
                    'tenant_name'    => $tenantName,
                    'document_type'  => $documentRequest->document_type,
                    'category'       => $documentRequest->category,
                    'purpose'        => $documentRequest->purpose,
                    'delivery_type'  => $documentRequest->delivery_type,
                    'date_needed'    => $documentRequest->date_needed,
                    'attachment'     => $documentRequest->attachment,
                    'status'         => 'cancelled',
                    'admin_remarks'  => $documentRequest->admin_remarks,
                    'fulfilled_file' => $documentRequest->fulfilled_file,
                    'submitted_at'   => $documentRequest->submitted_at,
                    'processed_at'   => now(),
                ],
            ]);

            $documentRequest->delete();

            $reqLabel = '#DRQ-' . str_pad($id, 3, '0', STR_PAD_LEFT);
            NotificationHelper::sendToAll(
                type: 'document_request',
                message: "{$tenantName} cancelled pending document request {$reqLabel}.",
                ref_id: $id,
            );

            return response()->json([
                'success' => true,
                'message' => 'Pending request cancelled successfully.',
            ]);
        }

        if ($documentRequest->status === 'processing') {
            return response()->json([
                'success' => false,
                'message' => 'Processing requests cannot be cancelled by the tenant.',
            ], 403);
        }

        if (in_array($documentRequest->status, ['approved', 'ready', 'denied'])) {
            $documentRequest->update(['hidden_from_tenant' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Document request hidden.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'This request cannot be deleted.',
        ], 400);
    }
    public function resubmit(Request $request, $id)
{
    $tenantId = $request->user()->tenant_id;

    $documentRequest = DocumentRequest::where('tenant_id', $tenantId)
        ->where('doc_request_id', $id)
        ->first();

    if (!$documentRequest) {
        return response()->json([
            'success' => false,
            'message' => 'Document request not found.',
        ], 404);
    }

    if ($documentRequest->status !== 'resubmission') {
        return response()->json([
            'success' => false,
            'message' => 'Only requests marked for resubmission can be resubmitted.',
        ], 422);
    }

    $request->validate([
        'file' => [
            'required',
            'file',
            'max:10240',
            function ($attribute, $value, $fail) {
                $ext = strtolower($value->getClientOriginalExtension());
                if (!in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                    $fail('Only PDF, Word (.doc, .docx), or Excel (.xls, .xlsx) files are allowed.');
                }
            },
        ],
    ]);

    if ($documentRequest->attachment) {
        Storage::disk('public')->delete($documentRequest->attachment);
    }

    $newPath = $request->file('file')->store('document-requests/attachments', 'public');

    $documentRequest->update([
        'attachment'    => $newPath,
        'status'        => 'pending',
        'admin_remarks' => null,
        'submitted_at'  => now(),
        'processed_at'  => null,
    ]);

    $tenant = $request->user();
    NotificationHelper::sendToAll(
        type: 'document_request',
        message: "{$tenant->first_name} {$tenant->last_name} resubmitted a {$documentRequest->document_type} request.",
        ref_id: $documentRequest->doc_request_id,
    );

    return response()->json([
        'success' => true,
        'message' => 'File resubmitted successfully.',
        'data'    => $documentRequest,
    ]);
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
