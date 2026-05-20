<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document_type'   => 'required|string|max:255',
            'purpose'         => 'nullable|string',
            'delivery_type'   => 'nullable|in:digital,printed',
            'date_needed'     => 'nullable|date',
        ]);

        $documentRequest = DocumentRequest::create([
            'tenant_id'     => $request->user()->tenant_id,
            'document_type' => $request->document_type,
            'purpose'       => $request->purpose,
            'delivery_type' => $request->delivery_type,
            'date_needed'   => $request->date_needed,
            'status'        => 'pending',
            'submitted_at'  => now(),
        ]);

        return response()->json([
            'message' => 'Request submitted successfully.',
            'data'    => $documentRequest,
        ], 201);
    }
}