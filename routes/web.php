<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\StaffController;

Route::get('/', fn() => view('public.home'))->name('home');

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

    Route::get('/dashboard',           [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/frontdesk/dashboard', fn() => view('frontdeskdb'))->name('frontdesk.dashboard');

    Route::get('/tenants',                      [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants',                     [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{id}',                 [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{id}',              [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/tenants/{id}/reset-password', [TenantController::class, 'resetPassword'])->name('tenants.reset-password');

    Route::get('/announcements',                    [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements',                   [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{id}',               [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::post('/announcements/{id}/archive',      [AnnouncementController::class, 'archive'])->name('announcements.archive');
    Route::post('/announcements/{id}/restore',      [AnnouncementController::class, 'restore'])->name('announcements.restore');
    Route::delete('/announcements/{id}',            [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/documents',  fn() => view('documents'))->name('documents.index');
    Route::get('/maintenance', fn() => view('maintenance'))->name('maintenance.index');
    Route::get('/emergency',  fn() => view('emergency'))->name('emergency.index');
    Route::get('/billing',    fn() => view('billing'))->name('billing.index');
    Route::get('/visitors',   fn() => view('visitors'))->name('visitors.index');
    Route::get('/staff',         [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff',        [StaffController::class, 'store'])->name('staff.store');
    Route::put('/staff/{id}',    [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::post('/staff/{id}/reset-password', [StaffController::class, 'resetPassword'])->name('staff.reset-password');
    Route::get('/settings',   fn() => view('settings'))->name('settings.index'); 
});

    Route::get('/visitors', [VisitorController::class, 'index'])
    ->name('visitors.index');
    Route::post('/visitors/store', [VisitorController::class, 'store'])
    ->name('visitors.store');
    Route::post('/visitors/checkout/{id}', [VisitorController::class, 'checkout'])
    ->name('visitors.checkout');

    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/',              [BillingController::class, 'index'])->name('index');
        Route::post('/log',          [BillingController::class, 'log'])->name('log');
        Route::post('/update-status',[BillingController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/update-full',  [BillingController::class, 'updateFull'])->name('updateFull');
    });
