<?php

namespace App\Http\Controllers;

use App\Models\ArchiveDocu;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper;

class DocumentRequestController extends Controller
{
    public function index()
    {
        try {
            $requests = DocumentRequest::with('tenant')
                            ->orderBy('submitted_at', 'desc')
                            ->get();
            return response()->json($requests);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, DocumentRequest $documentRequest)
    {
        try {
            $validated = $request->validate([
                'status'         => 'required|in:pending,processing,approved,ready,denied',
                'admin_remarks'  => 'nullable|string|max:1000',
                'fulfilled_file' => 'nullable|file|max:20480',
            ]);

            $validated['processed_at'] = now();

            if ($request->hasFile('fulfilled_file')) {
                if ($documentRequest->fulfilled_file) {
                    Storage::disk('public')->delete($documentRequest->fulfilled_file);
                }
                $validated['fulfilled_file'] = $request->file('fulfilled_file')
                                                   ->store('document-requests', 'public');
            }

            $documentRequest->update($validated);
            $documentRequest->load('tenant');

            NotificationHelper::sendToAll(
                type: 'document_request',
                message: "Document request from {$documentRequest->tenant->first_name} {$documentRequest->tenant->last_name} is now {$documentRequest->status}.",
                ref_id: $documentRequest->id,
            );

            return response()->json($documentRequest);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(DocumentRequest $documentRequest)
    {
        try {
            $documentRequest->load('tenant');

            ArchiveDocu::create([
                'archivable_type' => 'document_request',
                'original_id'     => $documentRequest->doc_request_id,
                'archived_by'     => auth('staff')->id(),
                'archived_at'     => now(),
                'data'            => [
                    'doc_request_id' => $documentRequest->doc_request_id,
                    'tenant_id'      => $documentRequest->tenant_id,
                    'tenant_name'    => $documentRequest->tenant_name,
                    'document_type'  => $documentRequest->document_type,
                    'purpose'        => $documentRequest->purpose,
                    'delivery_type'  => $documentRequest->delivery_type,
                    'date_needed'    => $documentRequest->date_needed,
                    'attachment'     => $documentRequest->attachment,
                    'status'         => $documentRequest->status,
                    'admin_remarks'  => $documentRequest->admin_remarks,
                    'fulfilled_file' => $documentRequest->fulfilled_file,
                    'submitted_at'   => $documentRequest->submitted_at,
                    'processed_at'   => $documentRequest->processed_at,
                ],
            ]);

            if ($documentRequest->fulfilled_file) {
                Storage::disk('public')->delete($documentRequest->fulfilled_file);
            }

            $documentRequest->delete();

            return response()->json(['message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}