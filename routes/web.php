<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn() => view('login'));

Route::post('/login', function () {
    $email    = request('email');
    $password = request('password');
    $role     = request('role'); // 'admin' or 'frontdesk'

    $user = \App\Models\User::where('email', $email)->first();

    if (!$user) {
        return back()->withErrors(['email' => '❌ No account found with that email.'])->withInput();
    }

    if (!\Auth::attempt(['email' => $email, 'password' => $password])) {
        return back()->withErrors(['email' => '❌ Incorrect password. Please try again.'])->withInput();
    }

    request()->session()->regenerate();

    // Redirect based on selected role
    if ($role === 'frontdesk') {
        return redirect('/frontdesk/dashboard');
    }
    return redirect('/dashboard');
});

Route::get('/frontdesk/dashboard', function () {
    if (!\Auth::check()) return redirect('/');
    return view('frontdeskdb');
});

// ✅ Dashboard route (named)
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('dashboard');
})->name('dashboard');

// ✅ NEW: Tenants / Manage page route
Route::get('/tenants', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('tenants'); // loads manage.blade.php
})->name('tenants');

Route::get('/documents', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('documents');
})->name('documents');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});