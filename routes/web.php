<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TenantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FrontdeskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRequestController;

// public pages
Route::get('/', fn() => view('public.home'))->name('home');
Route::get('/safety-features', fn() => view('public.safety-features'))->name('safety.features');
Route::get('/faqs', fn() => view('public.faqs'))->name('faqs');
Route::get('/features', fn() => view('public.features'))->name('features');

// auth
Route::get('/login', function () {
    if (Auth::guard('staff')->check()) {
        $user = Auth::guard('staff')->user();
        return $user->role === 'frontdesk'
            ? redirect()->route('frontdesk.dashboard')
            : redirect()->route('dashboard');
    }
    return view('login');
})->name('login');

Route::post('/login', function () {
    $email    = request('email');
    $password = request('password');
    $role     = request('role');

    $user = \App\Models\Staff::where('email', $email)
        ->where('is_active', true)
        ->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found with that email.'])->withInput();
    }

    if (!\Illuminate\Support\Facades\Hash::check($password, $user->password_hash)) {
        return back()->withErrors(['email' => 'Incorrect password.'])->withInput();
    }

    if ($user->role !== $role) {
        return back()->withErrors(['email' => 'Invalid role for this account.'])->withInput();
    }

    Auth::guard('staff')->login($user, request()->boolean('remember'));
    request()->session()->regenerate();

    return $role === 'frontdesk'
        ? redirect()->route('frontdesk.dashboard')
        : redirect()->route('dashboard');
});

Route::post('/logout', function () {
    Auth::guard('staff')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// protected (staff)
Route::middleware('auth:staff')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // tenants
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{id}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/tenants/{id}/reset-password', [TenantController::class, 'resetPassword'])->name('tenants.reset-password');

    // announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::post('/announcements/{id}/archive', [AnnouncementController::class, 'archive'])->name('announcements.archive');
    Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore'])->name('announcements.restore');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // visitors
    Route::get('/visitors', [VisitorController::class, 'adminIndex'])->name('visitors.index');
    Route::post('/visitors/store', [VisitorController::class, 'store']);
    Route::post('/visitors/checkout/{id}', [VisitorController::class, 'checkout']);

    // staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff', [StaffController::class, 'store']);
    Route::put('/staff/{id}', [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);
    Route::post('/staff/{id}/reset-password', [StaffController::class, 'resetPassword']);

    // billing
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/', [BillingController::class, 'index'])->name('index');
        Route::post('/log', [BillingController::class, 'log']);
        Route::post('/update-status', [BillingController::class, 'updateStatus']);
        Route::post('/update-full', [BillingController::class, 'updateFull']);
    });

    // documents (admin ui)
    Route::get('/documents', [DocumentController::class, 'page'])->name('documents.index');
    Route::get('/admin/documents', [DocumentController::class, 'index']);
    Route::post('/admin/documents', [DocumentController::class, 'store']);
    Route::get('/admin/documents/{document}', [DocumentController::class, 'show']);
    Route::put('/admin/documents/{document}', [DocumentController::class, 'update']);
    Route::delete('/admin/documents/{document}', [DocumentController::class, 'destroy']);

    // document requests (admin)
    Route::get('/admin/document-requests', [DocumentRequestController::class, 'index']);
    Route::match(['put', 'post'], '/admin/document-requests/{documentRequest}', [DocumentRequestController::class, 'update']);

    // maintenance
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::put('/maintenance/{id}', [MaintenanceController::class, 'update']);
    Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy']);

    // emergency
    Route::get('/emergency', [EmergencyController::class, 'adminIndex'])->name('emergency.index');
    Route::match(['put', 'post'], '/emergency/{id}', [EmergencyController::class, 'update']);
    Route::delete('/emergency/{id}', [EmergencyController::class, 'destroy']);

    // frontdesk
    Route::get('/frontdesk/dashboard', [FrontdeskController::class, 'index'])->name('frontdesk.dashboard');
    Route::get('/frontdesk/visitors', [VisitorController::class, 'index']);
    Route::get('/frontdesk/tenants', [TenantController::class, 'frontdeskIndex']);
    Route::get('/frontdesk/emergency', [EmergencyController::class, 'frontdeskIndex']);
    Route::post('/frontdesk/emergency', [EmergencyController::class, 'store']);
    Route::put('/frontdesk/emergency/{id}', [EmergencyController::class, 'update']);
    Route::delete('/frontdesk/emergency/{id}', [EmergencyController::class, 'destroy']);
    Route::get('/frontdesk/announcements', [AnnouncementController::class, 'frontdeskIndex']);

    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'password']);
    Route::put('/profile/deactivate', [ProfileController::class, 'deactivate']);

    // settings
    Route::get('/settings', fn() => view('settings'))->name('settings.index');
});