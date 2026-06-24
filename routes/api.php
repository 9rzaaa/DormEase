<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\DocumentRequestController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\EmergencyController;
use App\Http\Controllers\Api\DeviceTokenController;
use App\Http\Controllers\Api\NotificationController;

// public route
Route::post('/login', [AuthController::class, 'login']);

// protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/device-tokens', [DeviceTokenController::class, 'store']);
    Route::delete('/device-tokens', [DeviceTokenController::class, 'destroy']);

    // notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead']);

    // announcements
    Route::get('/announcements', [AnnouncementController::class, 'index']);

    // change passoword
    Route::post('/change-password', [PasswordController::class, 'change']);

    Route::middleware('tenant.not_on_vacation')->group(function () {
        // visitors
        Route::get('/visitors',                 [VisitorController::class, 'index']);
        Route::post('/visitors',                [VisitorController::class, 'store']);
        Route::patch('/visitors/{id}/checkout', [VisitorController::class, 'checkout']);
        Route::patch('/visitors/{id}/cancel',   [VisitorController::class, 'cancel']);
        Route::delete('/visitors/{id}',         [VisitorController::class, 'destroy']);

        // billing
        Route::get('/water-bill',      [BillingController::class, 'tenantBill']);
        Route::post('/water-bill/pay', [BillingController::class, 'tenantPay']);

        // document request
        Route::get('/document-requests', [DocumentRequestController::class, 'index']);
        Route::post('/document-requests', [DocumentRequestController::class, 'store']);
        Route::match(['put', 'post'], '/document-requests/{documentRequest}', [DocumentRequestController::class, 'update']);
        Route::post('/document-requests/{id}/resubmit', [DocumentRequestController::class, 'resubmit']);
        Route::delete('/document-requests/{id}', [DocumentRequestController::class, 'destroy']);

        // document forms
        Route::get('/tenant/documents', [DocumentRequestController::class, 'tenantDocuments']);
        Route::get('/tenant/forms', [DocumentRequestController::class, 'tenantForms']);

        // maintenance
        Route::get('/maintenance', [MaintenanceController::class, 'index']);
        Route::post('/maintenance', [MaintenanceController::class, 'store']);
        Route::post('/maintenance/{id}/resubmit-photo', [MaintenanceController::class, 'resubmitPhoto']);
        Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy']);

        // emergency
        Route::get('/emergency', [EmergencyController::class, 'index']);
        Route::post('/emergency', [EmergencyController::class, 'store']);
        Route::delete('/emergency/{id}', [EmergencyController::class, 'destroy']);
    });

    // profile
    Route::post('/profile/photo', function (Request $request) {
        $request->validate([
            'profile_photo' => 'required|image|max:2048',
        ]);

        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $user->update(['profile_photo' => $path]);

        return response()->json(['profile_photo' => $path]);
    });

    Route::post('/profile/update', function (Request $request) {
        $user = $request->user();

        if ($request->filled('contact_number')) {
            $request->merge([
                'contact_number' => preg_replace('/\D/', '', $request->contact_number),
            ]);
        }

        $request->validate([
            'email'          => 'required|email|unique:tenants,email,' . $user->tenant_id . ',tenant_id',
            'contact_number' => ['nullable', 'regex:/^09\d{9}$/'],
        ], [
            'contact_number.regex' => 'The contact number must be exactly 11 digits and start with 09 (e.g. 0912-345-6789).',
        ]);

        $user->update([
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return response()->json(['message' => 'Profile updated successfully.']);
    });

    Route::patch('/vacation-status', function (Request $request) {
        $tenant = $request->user();

        $request->validate([
            'is_on_vacation' => 'required|boolean',
            'vacation_note'  => 'nullable|string|max:150',
        ]);

        $isOnVacation = (bool) $request->input('is_on_vacation');
        $vacationNote = $request->input('vacation_note');

        if ($isOnVacation) {
            $errors = [];

            if ($tenant->hasUnpaidBills()) {
                $errors[] = "You have unpaid or pending bills.";
            }
            if ($tenant->hasOngoingMaintenance()) {
                $errors[] = "You have ongoing maintenance requests.";
            }
            if ($tenant->hasOngoingDocuments()) {
                $errors[] = "You have active document requests.";
            }
            if ($tenant->hasActiveVisitors()) {
                $errors[] = "You have upcoming or active registered visitors.";
            }

            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot set status to vacation. Preconditions not met.',
                    'errors'  => $errors,
                ], 422);
            }
        }

        $tenant->update([
            'is_on_vacation' => $isOnVacation,
            'vacation_note'  => $isOnVacation ? $vacationNote : null,
        ]);

        $tenantName = trim($tenant->first_name . ' ' . $tenant->last_name);
        if ($isOnVacation) {
            \App\Helpers\NotificationHelper::sendToAll(
                type: 'tenant_vacation_on',
                message: "{$tenantName} is now on vacation/break (" . ($vacationNote ?: 'No details') . ").",
                ref_id: $tenant->tenant_id,
            );
        } else {
            \App\Helpers\NotificationHelper::sendToAll(
                type: 'tenant_vacation_off',
                message: "{$tenantName} has returned from vacation/break.",
                ref_id: $tenant->tenant_id,
            );
        }

        return response()->json([
            'success'        => true,
            'is_on_vacation' => $tenant->is_on_vacation,
            'vacation_note'  => $tenant->vacation_note,
        ]);
    });
});
