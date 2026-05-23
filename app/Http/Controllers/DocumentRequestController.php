<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            return response()->json($documentRequest);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}