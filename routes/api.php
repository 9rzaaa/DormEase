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

    // visitors
    Route::get('/visitors',                 [VisitorController::class, 'index']);
    Route::post('/visitors',                [VisitorController::class, 'store']);
    Route::patch('/visitors/{id}/checkout', [VisitorController::class, 'checkout']);

    // billing
    Route::get('/water-bill',      [BillingController::class, 'tenantBill']);
    Route::post('/water-bill/pay', [BillingController::class, 'tenantPay']);

    // document request
    Route::get('/document-requests', [DocumentRequestController::class, 'index']);
    Route::post('/document-requests', [DocumentRequestController::class, 'store']);
    Route::match(['put', 'post'], '/document-requests/{documentRequest}', [DocumentRequestController::class, 'update']);

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

        $request->validate([
            'email'          => 'required|email|unique:tenants,email,' . $user->tenant_id . ',tenant_id',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $user->update([
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return response()->json(['message' => 'Profile updated successfully.']);
    });
});
