<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStaffRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::guard('staff')->user();

        if (!$user || !in_array($user->role, $roles, true)) {
            $redirect = ($user && $user->role === 'frontdesk')
                ? route('frontdesk.dashboard')
                : route('dashboard');

            return redirect($redirect)->with('error', 'You do not have access to that page.');
        }

        return $next($request);
    }
}