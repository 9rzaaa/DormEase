<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn() => view('login'));

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

    if ($role === 'frontdesk') {
        return redirect('/frontdesk/dashboard');
    }

    return redirect('/dashboard');
});

Route::get('/frontdesk/dashboard', function () {
    if (!Auth::guard('staff')->check()) return redirect('/');
    return view('frontdeskdb');
});

Route::get('/dashboard', function () {
    if (!Auth::guard('staff')->check()) return redirect('/');
    return view('dashboard');
})->name('dashboard');

Route::get('/tenants', function () {
    if (!Auth::guard('staff')->check()) return redirect('/');
    return view('tenants');
})->name('tenants');

Route::get('/documents', function () {
    if (!Auth::guard('staff')->check()) return redirect('/');
    return view('documents');
})->name('documents');

Route::post('/logout', function () {
    Auth::guard('staff')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout'); // ✅ add this

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/frontdesk/dashboard', fn() => view('frontdeskdb'))
        ->name('frontdesk.dashboard');

    Route::get('/tenants', fn() => view('tenants'))->name('tenants');

    Route::get('/documents', fn() => view('documents'))->name('documents');

    // 👉 OPTIONAL: direct redirect routes between pages
    Route::get('/tenants-to-documents', function () {
        return redirect()->route('documents');
    });

    Route::get('/documents-to-tenants', function () {
        return redirect()->route('tenants');
    });

});