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
use App\Http\Controllers\FDProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BillingHistoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ArchiveSettingsController;
use App\Http\Controllers\RoomController; 

// public pages
Route::get('/', fn() => view('public.home'))->name('home');
Route::get('/safety-features', fn() => view('public.safety-features'))->name('safety.features');
Route::get('/faqs', fn() => view('public.faqs'))->name('faqs');
Route::get('/features', fn() => view('public.features'))->name('features');
Route::get('/gallery', fn() => view('public.gallery'))->name('gallery');
Route::redirect('/register', '/login')->name('register');

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

    $user = \App\Models\Staff::where('email', $email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found with that email.'])->withInput();
    }

    if (!\Illuminate\Support\Facades\Hash::check($password, $user->password_hash)) {
        return back()->withErrors(['email' => 'Incorrect password.'])->withInput();
    }

    $staffRoles = ['frontdesk'];
    $adminRoles = ['admin', 'secretary'];
    if (in_array($user->role, $adminRoles, true) && $role !== 'admin') {
        return back()->withErrors(['email' => 'Invalid role for this account.'])->withInput();
    }
    if (in_array($user->role, $staffRoles, true) && $role !== 'frontdesk') {
        return back()->withErrors(['email' => 'Invalid role for this account.'])->withInput();
    }

    if (!$user->is_active) {
        return back()->withErrors(['email' => 'Your account has been temporarily deactivated. Please contact your administrator to reactivate your account.'])->withInput();
    }

    Auth::guard('staff')->login($user, request()->boolean('remember'));
    request()->session()->regenerate();

    $now = now();
    $dutyStatus = $user->duty_status;

    if ($user->shift_start && $user->shift_end) {
        $shiftStart = \Carbon\Carbon::createFromTimeString($user->shift_start);
        $shiftEnd   = \Carbon\Carbon::createFromTimeString($user->shift_end);

        $currentTime = \Carbon\Carbon::createFromTimeString($now->format('H:i:s'));

        $isNightShift = $shiftEnd->lessThan($shiftStart);

        if ($isNightShift) {
            $withinShift = $currentTime->greaterThanOrEqualTo($shiftStart) || $currentTime->lessThan($shiftEnd);
        } else {
            $withinShift = $currentTime->between($shiftStart, $shiftEnd);
        }

        if ($withinShift) {
            $dutyStatus = 'on_duty';
        }
    }

    $user->updateQuietly([
        'last_login_at' => $now,
        'duty_status'   => $dutyStatus,
    ]);

    \App\Models\StaffAttendance::create([
        'staff_id'       => $user->staff_id,
        'staff_name'     => $user->first_name . ' ' . $user->last_name,
        'role'           => $user->role,
        'shift_schedule' => $user->shift_schedule,
        'login_at'       => $now,
        'logout_at'      => null,
        'duty_status'    => $dutyStatus,
    ]);

    if ($role === 'frontdesk' && $user->is_temp_password) {
        session()->flash('prompt_temp_password', true);
    }

    return in_array($user->role, $staffRoles, true)
        ? redirect()->route('frontdesk.dashboard')
        : redirect()->route('dashboard');
});

Route::post('/logout', function () {
    $user = Auth::guard('staff')->user();
    if ($user) {
        $user->updateQuietly(['duty_status' => 'off_duty']);

        \App\Models\StaffAttendance::where('staff_id', $user->staff_id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()
            ?->update(['logout_at' => now()]);
    }
    Auth::guard('staff')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::post('/frontdesk/profile/dismiss-temp-password', function () {
    return response()->json(['ok' => true]);
})->name('fdprofile.dismissTempPassword')->middleware('auth:staff');



// forgot pass
Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verify'])->name('forgot-password.verify');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset'])->name('forgot-password.reset');

// protected (staff)
Route::middleware('auth:staff')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // tenants
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{id}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/tenants/{id}/reset-password', [TenantController::class, 'resetPassword'])->name('tenants.reset-password');
    Route::middleware('dormhead')->post('/tenants/{id}/reactivate', [TenantController::class, 'reactivate'])->name('tenants.reactivate');
    Route::post('/tenants/{id}/time-in',  [App\Http\Controllers\TenantLogController::class, 'timeIn']);
    Route::post('/tenants/{id}/time-out', [App\Http\Controllers\TenantLogController::class, 'timeOut']);
    Route::get('/tenant-logs',            [App\Http\Controllers\TenantLogController::class, 'logs']);
    Route::middleware('auth:staff')->group(function () {
        Route::get('/rooms',          [RoomController::class, 'index']);
        Route::post('/rooms',         [RoomController::class, 'store']);
        Route::put('/rooms/{id}',     [RoomController::class, 'update']);
        Route::delete('/rooms/{id}',  [RoomController::class, 'destroy']);
    });

    // announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::post('/announcements/{id}/archive', [AnnouncementController::class, 'archive'])->name('announcements.archive');
    Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore'])->name('announcements.restore');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // visitors
    Route::get('/visitors', [VisitorController::class, 'adminIndex'])->name('visitors.index');
    Route::post('/visitors/store', [VisitorController::class, 'store'])->name('visitors.store');
    Route::post('/visitors/checkout/{id}', [VisitorController::class, 'checkout'])->name('visitors.checkout');
    Route::post('/visitors/{id}/notify-tenant', [VisitorController::class, 'notifyTenant'])->name('visitors.notify-tenant');
    Route::put('/visitors/timein/{id}', [VisitorController::class, 'timein'])->name('visitors.timein');
    Route::put('/visitors/{id}/status', [VisitorController::class, 'updateStatus'])->name('visitors.status');

    // staff
    Route::middleware('dormhead')->group(function () {
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('/staff/{id}/reset-password', [StaffController::class, 'resetPassword'])->name('staff.reset-password');
        Route::post('/staff/{id}/reactivate', [StaffController::class, 'reactivate'])->name('staff.reactivate');
        Route::post('/staff/attendance/clear', [StaffController::class, 'clearAttendance'])->name('staff.attendance.clear');
    });

    // billing
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/', [BillingController::class, 'index'])->name('index');
        Route::post('/log', [BillingController::class, 'log'])->name('log');
        Route::post('/update-status', [BillingController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/update-full', [BillingController::class, 'updateFull'])->name('updateFull');
        Route::get('/history', [BillingHistoryController::class, 'index'])->name('history');
        Route::get('/receipt/{billingId}', [ReceiptController::class, 'download'])->name('receipt');
    });

    // documents
    Route::get('/documents', [DocumentController::class, 'page'])->name('documents.index');
    Route::get('/admin/documents', [DocumentController::class, 'index'])->name('admin.documents.index');
    Route::post('/admin/documents', [DocumentController::class, 'store'])->name('admin.documents.store');
    Route::get('/admin/documents/{document}', [DocumentController::class, 'show'])->name('admin.documents.show');
    Route::put('/admin/documents/{document}', [DocumentController::class, 'update'])->name('admin.documents.update');
    Route::delete('/admin/documents/{document}', [DocumentController::class, 'destroy'])->name('admin.documents.destroy');
    Route::post('/admin/document-requests/{documentRequest}/resubmit', [DocumentRequestController::class, 'resubmit']);

    // document requests
    Route::get('/admin/document-requests', [DocumentRequestController::class, 'index'])->name('admin.document-requests.index');
    Route::match(['put', 'post'], '/admin/document-requests/{documentRequest}', [DocumentRequestController::class, 'update'])->name('admin.document-requests.update');
    Route::delete('/admin/document-requests/{documentRequest}', [DocumentRequestController::class, 'destroy'])->name('admin.document-requests.destroy');

    // document archive 
    Route::get('/admin/archive-docus', [DocumentController::class, 'archiveIndex'])->name('admin.archive-docus.index');
    Route::delete('/admin/archive-docus/{archiveDocu}', [DocumentController::class, 'archiveDestroy'])->name('admin.archive-docus.destroy');

    // downloadable forms CRUD
    Route::get('/admin/downloadable-forms',          [DocumentController::class, 'indexForms'])->name('admin.forms.index');
    Route::post('/admin/downloadable-forms',         [DocumentController::class, 'storeForm'])->name('admin.forms.store');
    Route::put('/admin/downloadable-forms/{id}',     [DocumentController::class, 'updateForm'])->name('admin.forms.update');
    Route::delete('/admin/downloadable-forms/{id}',  [DocumentController::class, 'destroyForm'])->name('admin.forms.destroy');

    // maintenance
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::put('/maintenance/{id}', [MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy');

    // emergency
    Route::get('/emergency', [EmergencyController::class, 'adminIndex'])->name('emergency.index');
    Route::match(['put', 'post'], '/emergency/{id}', [EmergencyController::class, 'update'])->name('emergency.update');
    Route::delete('/emergency/{id}', [EmergencyController::class, 'destroy'])->name('emergency.destroy');
    Route::get('/emergency/poll-panic', [EmergencyController::class, 'pollPanic'])->name('emergency.poll-panic');
    Route::get('/emergency/poll-critical', [EmergencyController::class, 'pollCritical']);

    // frontdesk
    Route::get('/frontdesk/dashboard', [FrontdeskController::class, 'index'])->name('frontdesk.dashboard');
    Route::get('/frontdesk/visitors', [VisitorController::class, 'index'])->name('frontdesk.visitors');
    Route::get('/frontdesk/tenants', [TenantController::class, 'frontdeskIndex'])->name('frontdesk.tenants');
    Route::get('/frontdesk/emergency', [EmergencyController::class, 'frontdeskIndex'])->name('frontdesk.emergency');
    Route::post('/frontdesk/emergency', [EmergencyController::class, 'store'])->name('frontdesk.emergency.store');
    Route::put('/frontdesk/emergency/{id}', [EmergencyController::class, 'update'])->name('frontdesk.emergency.update');
    Route::delete('/frontdesk/emergency/{id}', [EmergencyController::class, 'destroy'])->name('frontdesk.emergency.destroy');
    Route::get('/frontdesk/announcements', [AnnouncementController::class, 'frontdeskIndex'])->name('frontdesk.announcements');
    Route::get('/frontdesk/emergency/poll-panic', [EmergencyController::class, 'pollPanic'])->middleware('auth:staff');
    Route::get('/emergency/poll-critical', [EmergencyController::class, 'pollCritical']);

    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
    Route::put('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.updateEmail');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.updateNotifications');
    Route::middleware('dormhead')->group(function () {
        Route::put('/settings/archive', [ArchiveSettingsController::class, 'update'])->name('settings.archive.update');
        Route::post('/settings/archive/clear-now', [ArchiveSettingsController::class, 'clearNow'])->name('settings.archive.clearNow');
    });

    // notifications
    Route::get('/notifications/live', [NotificationController::class, 'live'])->name('notifications.live');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    //front desk profile
    Route::get('/frontdesk/profile', [FDProfileController::class, 'index'])->name('fdprofile.index');
    Route::put('/frontdesk/profile/info', [FDProfileController::class, 'updateInfo'])->name('fdprofile.updateInfo');
    Route::put('/frontdesk/profile/password', [FDProfileController::class, 'updatePassword'])->name('fdprofile.updatePassword');
    Route::get('/frontdesk/settings', [SettingsController::class, 'frontdeskIndex'])->name('frontdesk.settings.index');
    Route::put('/frontdesk/settings/notifications', [SettingsController::class, 'frontdeskUpdateNotifications'])->name('frontdesk.settings.updateNotifications');
    Route::put('/frontdesk/profile/avatar', [FDProfileController::class, 'updateAvatar'])->name('fdprofile.avatar');
    
    Route::patch('/tenants/{id}/notes', [TenantController::class, 'updateNotes'])->name('tenants.notes');
});