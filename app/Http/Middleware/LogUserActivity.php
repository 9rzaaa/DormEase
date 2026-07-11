<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    private array $ignoredPrefixes = [
        'session/check',
        'notifications/live',
        'live-alerts',
        'emergency/poll',
        'maintenance/poll',
        'visitors/poll',
        'tenants/live',
        'staff/poll',
        'frontdesk/dashboard/data',
        'frontdesk/announcements/poll',
        'frontdesk/emergency/poll',
        'frontdesk/tenants/live',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldLog($request, $response)) {
            [$module, $action, $description] = ActivityLogger::describeRequest($request);

            ActivityLogger::log($module, $action, $description, [
                'status_code' => $response->getStatusCode(),
                'input' => $this->safeInput($request),
            ], $request);
        }

        return $response;
    }

    private function shouldLog(Request $request, Response $response): bool
    {
        if (! $request->user('staff')) {
            return false;
        }

        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return false;
        }

        if ($response->getStatusCode() >= 500) {
            return false;
        }

        $path = trim($request->path(), '/');
        foreach ($this->ignoredPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return false;
            }
        }

        return true;
    }

    private function safeInput(Request $request): array
    {
        return collect($request->except([
            '_token',
            '_method',
            'password',
            'password_confirmation',
            'current_password',
            'new_password',
            'new_password_confirmation',
            'master_password',
            'temp_password',
        ]))->map(function ($value) {
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                return [
                    'file' => $value->getClientOriginalName(),
                    'mime' => $value->getClientMimeType(),
                    'size' => $value->getSize(),
                ];
            }

            if (is_array($value)) {
                return '[array]';
            }

            return is_scalar($value) ? (string) $value : '[' . get_debug_type($value) . ']';
        })->all();
    }
}
