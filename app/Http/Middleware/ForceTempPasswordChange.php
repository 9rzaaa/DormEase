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
            'fdprofile.index',
            'fdprofile.updatePassword',
            'fdprofile.dismissTempPassword',
            'session.check',
            'logout',
        ];
        if (in_array($request->route()?->getName(), $allowedRoutes, true)) {
            return $next($request);
        }
        $redirectRoute = $staff->role === 'frontdesk' ? 'fdprofile.index' : 'profile.index';
        return redirect()
            ->route($redirectRoute)
            ->with('error', 'You must set a new password before continuing.');
    }
}
