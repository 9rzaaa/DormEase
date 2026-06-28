<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceTempPasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $staff = auth('staff')->user();

        if (! $staff || ! $staff->is_temp_password) {
            return $next($request);
        }

        $allowedRoutes = [
            'profile.index',
            'profile.password',
            'logout',
        ];

        if (in_array($request->route()?->getName(), $allowedRoutes, true)) {
            return $next($request);
        }

        return redirect()
            ->route('profile.index')
            ->with('error', 'You must set a new password before continuing.');
    }
}