<?php

namespace App\Http\Controllers;

use App\Models\ArchiveDocu;
use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\DownloadableForm;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper;
use App\Services\TenantPushNotificationService;

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
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        $archivedDocuments = ArchiveDocu::where('archivable_type', 'document')
            ->orderBy('archived_at', 'desc')
            ->get();

        $archivedRequests  = ArchiveDocu::where('archivable_type', 'document_request')
            ->orderBy('archived_at', 'desc')
            ->get();

        return view('documents', compact('docTypes', 'tenants', 'archivedDocuments', 'archivedRequests'));
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
            ref_id: $doc->document_id,
        );

        $this->notifyTenantsForDocument(
            document: $doc,
            title: 'New document uploaded',
            body: "A new {$doc->document_type} document is available in your documents.",
            route: '/tenant/documents',
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
        $previousVisibility = $document->visibility;
        $previousTenantId = $document->tenant_id;

        $validated = $request->validate([
            'title'         => 'sometimes|required|string|max:255',
            'document_type' => 'sometimes|required|string|max:255',
            'visibility'    => 'sometimes|required|in:all,specific,admin',
            'tenant_id'     => 'nullable|exists:tenants,tenant_id',
        ]);

        $document->update($validated);
        $document->load('tenant');

        $this->notifyTenantsForDocument(
            document: $document,
            title: 'Document updated',
            body: "{$document->title} was updated in your documents.",
            fallbackVisibility: $previousVisibility,
            fallbackTenantId: $previousTenantId,
        );

        return response()->json($document);
    }

    public function destroy(Document $document)
    {
        $document->load('tenant');

        ArchiveDocu::create([
            'archivable_type' => 'document',
            'original_id'     => $document->document_id,
            'archived_by'     => auth('staff')->id(),
            'archived_at'     => now(),
            'data'            => [
                'document_id'   => $document->document_id,
                'title'         => $document->title,
                'document_type' => $document->document_type,
                'visibility'    => $document->visibility,
                'tenant_id'     => $document->tenant_id,
                'tenant_name'   => $document->tenant_name,
                'file_path'     => $document->file_path,
                'date_posted'   => $document->date_posted,
            ],
        ]);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        $this->notifyTenantsForDocument(
            document: $document,
            title: 'Document removed',
            body: "{$document->title} was removed from your documents.",
        );

        return response()->json(['message' => 'Deleted successfully']);
    }

    private function notifyTenantsForDocument(
        Document $document,
        string $title,
        string $body,
        ?string $fallbackVisibility = null,
        ?int $fallbackTenantId = null,
        string $route = '/tenant/documents',
    ): void {
        $pushService = app(TenantPushNotificationService::class);
        $visibility = $document->visibility;

        if ($visibility === 'all' || $fallbackVisibility === 'all') {
            $pushService->sendToAllTenants(
                type: 'document',
                title: $title,
                body: $body,
                refId: $document->document_id,
                route: $route,
            );

            return;
        }

        $tenantId = $visibility === 'specific'
            ? $document->tenant_id
            : ($fallbackVisibility === 'specific' ? $fallbackTenantId : null);

        if (!$tenantId) {
            return;
        }

        $pushService->sendToTenant(
            tenant: $tenantId,
            type: 'document',
            title: $title,
            body: $body,
            refId: $document->document_id,
            route: $route,
        );
    }

    public function archiveIndex(Request $request)
    {
        try {
            $type  = $request->query('type');
            $query = ArchiveDocu::orderBy('archived_at', 'desc');

            if ($type && in_array($type, ['document', 'document_request'])) {
                $query->where('archivable_type', $type);
            }

            return response()->json($query->get());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function archiveDestroy(ArchiveDocu $archiveDocu)
    {
        $archiveDocu->delete();
        return response()->json(['message' => 'Archive record removed.']);
    }

    public function indexRequests()
    {
        try {
            $requests = DocumentRequest::with('tenant')
                ->orderBy('submitted_at', 'desc')
                ->get()
                ->map(function ($req) {
                    return array_merge($req->toArray(), [
                        'tenant_name' => $req->tenant_name ?? 'Unknown',
                    ]);
                });
            return response()->json($requests);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateRequest(Request $request, $id)
    {
        try {
            $docRequest = DocumentRequest::findOrFail($id);

            $validated = $request->validate([
                'status'              => 'required|in:pending,processing,approved,ready,denied,resubmission',
                'admin_remarks'       => 'nullable|string',
                'rejection_reason'    => 'nullable|string',
                'allow_resubmission'  => 'nullable|boolean',
                'fulfilled_file'      => 'nullable|file|mimes:pdf|max:20480',
            ]);

            $oldStatus = $docRequest->status;
            $newStatus = $validated['status'];

            $fulfilledFile = null;
            if ($request->hasFile('fulfilled_file')) {
                $fulfilledFile = $request->file('fulfilled_file')->store('fulfilled-documents', 'public');
                $docRequest->fulfilled_file = $fulfilledFile;
            }

            $docRequest->status = $newStatus;
            $docRequest->admin_remarks = $validated['admin_remarks'] ?? null;
            $docRequest->processed_at = now();
            $docRequest->save();

            if ($newStatus === 'denied' || $newStatus === 'resubmission') {
                ArchiveDocu::create([
                    'archivable_type' => 'document_request',
                    'original_id'     => $docRequest->doc_request_id,
                    'archived_by'     => auth('staff')->id(),
                    'archived_at'     => now(),
                    'data'            => array_merge($docRequest->toArray(), [
                        'rejection_reason' => $validated['rejection_reason'] ?? null,
                        'allow_resubmission' => $validated['allow_resubmission'] ?? false,
                        'tenant_name'   => $docRequest->tenant_name ?? 'Unknown',
                    ]),
                ]);
            }

            return response()->json([
                'message' => 'Request updated successfully',
                'data'    => $docRequest,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroyRequest($id)
    {
        try {
            $docRequest = DocumentRequest::findOrFail($id);

            ArchiveDocu::create([
                'archivable_type' => 'document_request',
                'original_id'     => $docRequest->doc_request_id,
                'archived_by'     => auth('staff')->id(),
                'archived_at'     => now(),
                'data'            => array_merge($docRequest->toArray(), [
                    'tenant_name' => $docRequest->tenant_name ?? 'Unknown',
                ]),
            ]);

            if ($docRequest->fulfilled_file) {
                Storage::disk('public')->delete($docRequest->fulfilled_file);
            }

            $docRequest->delete();

            return response()->json(['message' => 'Request archived successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function indexForms()
    {
        try {
            $forms = DownloadableForm::orderBy('label')->get()->map(function ($form) {
                $form->url = Storage::disk('public')->url($form->file_path);
                return $form;
            });
            return response()->json($forms);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeForm(Request $request)
    {
        try {
            $request->validate([
                'label' => 'required|string|max:255',
                'file'  => 'required|file|mimes:pdf|max:20480',
            ]);

            $path = $request->file('file')->store('downloadable-forms', 'public');

            $form = DownloadableForm::create([
                'label'     => $request->label,
                'file_path' => $path,
            ]);

            $form->url = Storage::disk('public')->url($path);

            return response()->json($form, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateForm(Request $request, $id)
    {
        try {
            $request->validate(['label' => 'required|string|max:255']);

            $form = DownloadableForm::findOrFail($id);
            $form->update(['label' => $request->label]);

            return response()->json($form);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroyForm($id)
    {
        try {
            $form = DownloadableForm::findOrFail($id);
            if (str_starts_with($form->file_path, 'downloadable-forms/')) {
                Storage::disk('public')->delete($form->file_path);
            }

            $form->delete();

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
