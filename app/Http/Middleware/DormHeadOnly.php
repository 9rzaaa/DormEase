<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DormHeadOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('staff')->user();

        if (!$user || !in_array($user->role, ['admin'])) {
            abort(403, 'Access restricted to dorm head only.');
        }

        return $next($request);
    }
}