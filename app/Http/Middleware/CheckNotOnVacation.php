<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNotOnVacation
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = $request->user();

        if ($tenant && $tenant->is_on_vacation) {
            return response()->json([
                'error'   => 'on_vacation',
                'message' => 'Access restricted. You cannot access this feature while on vacation. Please turn off your vacation status in your profile.',
            ], 403);
        }

        return $next($request);
    }
}
