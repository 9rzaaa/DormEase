<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTenantActive
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = $request->user();

        if ($tenant && !$tenant->is_active) {
            return response()->json([
                'error'   => 'account_deactivated',
                'message' => 'Your account has been temporarily deactivated. Please visit the admin office for reactivation.',
            ], 403);
        }

        return $next($request);
    }
}