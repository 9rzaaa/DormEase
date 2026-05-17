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

Route::get('/', fn() => view('public.home'))->name('home');
Route::get('/safety-features', fn() => view('public.safety-features'))->name('safety.features');
Route::get('/faqs', fn() => view('public.faqs'))->name('faqs');

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
        return back()->withErrors(['email' => 'Incorrect password. Please try again.'])->withInput();
    }

    if ($user->role !== $role) {
        return back()->withErrors(['email' => 'Access denied. Invalid role for this account.'])->withInput();
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

Route::middleware('auth:staff')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tenants',                      [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants',                     [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{id}',                 [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{id}',              [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/tenants/{id}/reset-password', [TenantController::class, 'resetPassword'])->name('tenants.reset-password');

    Route::get('/announcements',               [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements',              [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{id}',          [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::post('/announcements/{id}/archive', [AnnouncementController::class, 'archive'])->name('announcements.archive');
    Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore'])->name('announcements.restore');
    Route::delete('/announcements/{id}',       [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/visitors',                [VisitorController::class, 'adminIndex'])->name('visitors.index');
    Route::post('/visitors/store',         [VisitorController::class, 'store'])->name('visitors.store');
    Route::post('/visitors/checkout/{id}', [VisitorController::class, 'checkout'])->name('visitors.checkout');

    Route::get('/staff',                      [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff',                     [StaffController::class, 'store'])->name('staff.store');
    Route::put('/staff/{id}',                 [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}',              [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::post('/staff/{id}/reset-password', [StaffController::class, 'resetPassword'])->name('staff.reset-password');

    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/',               [BillingController::class, 'index'])->name('index');
        Route::post('/log',           [BillingController::class, 'log'])->name('log');
        Route::post('/update-status', [BillingController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/update-full',   [BillingController::class, 'updateFull'])->name('updateFull');
    });

    Route::get('/documents',   fn() => view('documents'))->name('documents.index');
    Route::get('/maintenance', fn() => view('maintenance'))->name('maintenance.index');
    Route::get('/emergency',   fn() => view('emergency'))->name('emergency.index');
    Route::get('/settings',    fn() => view('settings'))->name('settings.index');

    Route::get('/frontdesk/dashboard', [FrontdeskController::class, 'index'])->name('frontdesk.dashboard');
    Route::get('/frontdesk/visitors', [VisitorController::class, 'index'])->name('frontdesk.visitors');
    Route::get('/frontdesk/tenants', [TenantController::class, 'frontdeskIndex'])->name('frontdesk.tenants');
    Route::patch('/tenants/{id}/notes', [TenantController::class, 'updateNotes'])->name('tenants.notes');

    // View profile page
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');
    // Update personal info + photo
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    // Change password
    Route::put('/profile/password', [ProfileController::class, 'password'])
        ->name('profile.password');
    // Deactivate account
    Route::put('/profile/deactivate', [ProfileController::class, 'deactivate'])
        ->name('profile.deactivate');
});
