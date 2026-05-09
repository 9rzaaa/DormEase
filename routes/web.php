<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TenantController;

Route::get('/', fn() => view('public.home'))->name('home');
Route::get('/login', fn() => view('login'))->name('login');

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
    return redirect('/');
})->name('logout');

Route::middleware('auth:staff')->group(function () {

    Route::get('/dashboard', function () {
        $staff = Auth::guard('staff')->user();
        return view('dashboard', [
            'staff'               => $staff,
            'totalTenants'        => \App\Models\Tenant::where('is_active', true)->count(),
            'pendingPayments'     => \App\Models\Payment::where('status', 'pending')->count(),
            'pendingMaintenance'  => \App\Models\MaintenanceRequest::whereIn('status', ['pending', 'in_progress'])->count(),
            'unresolvedReports'   => \App\Models\EmergencyReport::where('status', '!=', 'resolved')->count(),
            'maintenanceRequests' => \App\Models\MaintenanceRequest::with('tenant')
                ->whereIn('status', ['pending', 'in_progress'])
                ->latest('submitted_at')
                ->take(3)
                ->get(),
            'announcements'       => \App\Models\Announcement::latest('posted_at')->take(3)->get(),
            'notifications'       => \App\Models\Notification::where('is_read', false)->latest('created_at')->take(4)->get(),
            'unreadNotifCount'    => \App\Models\Notification::where('is_read', false)->count(),
            'latestEmergency'     => \App\Models\EmergencyReport::where('status', '!=', 'resolved')->latest('reported_at')->first(),
            'allEmergencies'      => \App\Models\EmergencyReport::latest('reported_at')->get(),
            'recentActivities'    => \App\Models\VisitorLog::with('tenant')->latest('arrival_time')->take(5)->get(),
        ]);
    })->name('dashboard');

    Route::get('/frontdesk/dashboard', fn() => view('frontdeskdb'))
        ->name('frontdesk.dashboard');

    Route::get('/tenants',         [TenantController::class, 'index'])->name('tenants');
    Route::post('/tenants',        [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{id}',    [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    Route::get('/documents',   fn() => view('documents'))->name('documents');
    Route::get('/maintenance', fn() => view('maintenance'))->name('maintenance');
    Route::get('/emergency',   fn() => view('emergency'))->name('emergency');
    Route::get('/billing',     fn() => view('billing'))->name('billing');
    Route::get('/visitors',    fn() => view('visitors'))->name('visitors');
    Route::get('/staff',       fn() => view('staff'))->name('staff');
    Route::get('/settings',    fn() => view('settings'))->name('settings');

    Route::get('/announcements', function () {
        $staff = Auth::guard('staff')->user();
        return view('announcements', [
            'staff'            => $staff,
            'unreadNotifCount' => \App\Models\Notification::where('is_read', false)->count(),
            'announcements'    => \App\Models\Announcement::orderBy('posted_at', 'desc')->get(),
        ]);
    })->name('announcements');

    Route::post('/announcements', function () {
        \App\Models\Announcement::create([
            'title'     => request('title'),
            'content'   => request('description'),
            'priority'  => request('priority', 'low'),
            'status'    => request('status', 'active'),
            'posted_by' => Auth::guard('staff')->id(),
            'posted_at' => now(),
        ]);
        return redirect()->route('announcements')->with('success', 'Announcement posted successfully!');
    })->name('announcements.store');

    Route::put('/announcements/{id}', function ($id) {
        $ann = \App\Models\Announcement::findOrFail($id);
        $ann->update([
            'title'    => request('title'),
            'content'  => request('description'),
            'priority' => request('priority', $ann->priority),
            'status'   => request('status', $ann->status),
        ]);
        return redirect()->route('announcements')->with('success', 'Announcement updated!');
    })->name('announcements.update');

    Route::patch('/announcements/{id}/archive', function ($id) {
        \App\Models\Announcement::findOrFail($id)->update(['status' => 'closed']);
        return redirect()->route('announcements')->with('success', 'Announcement archived.');
    })->name('announcements.archive');

    Route::patch('/announcements/{id}/restore', function ($id) {
        \App\Models\Announcement::findOrFail($id)->update(['status' => 'active']);
        return redirect()->route('announcements')->with('success', 'Announcement restored.');
    })->name('announcements.restore');

    Route::delete('/announcements/{id}', function ($id) {
        \App\Models\Announcement::findOrFail($id)->delete();
        return redirect()->route('announcements')->with('success', 'Announcement deleted.');
    })->name('announcements.destroy');

});