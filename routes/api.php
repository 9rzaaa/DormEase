<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\PasswordController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\DocumentRequestController;
use App\Http\Controllers\Api\MaintenanceController;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

// ── Protected routes (requires Sanctum token) ─────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/announcements', [AnnouncementController::class, 'index']);

    Route::post('/change-password', [PasswordController::class, 'change']);

    Route::get('/visitors',                 [VisitorController::class, 'index']);
    Route::post('/visitors',                [VisitorController::class, 'store']);
    Route::patch('/visitors/{id}/checkout', [VisitorController::class, 'checkout']);

    Route::get('/water-bill',      [BillingController::class, 'tenantBill']);
    Route::post('/water-bill/pay', [BillingController::class, 'tenantPay']);

    // ── Document Requests ─────────────────────────────────────────────────────
    Route::post('/document-requests', [DocumentRequestController::class, 'store']);

    Route::get('/maintenance', [MaintenanceController::class, 'index']);
    Route::post('/maintenance', [MaintenanceController::class, 'store']);

    // ── Profile ───────────────────────────────────────────────────────────────
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
