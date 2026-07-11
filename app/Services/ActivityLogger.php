<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityLogger
{
    public static function log(string $module, string $action, string $description, array $properties = [], ?Request $request = null, ?Staff $staff = null): void
    {
        try {
            $request ??= request();
            $staff ??= Auth::guard('staff')->user();

            ActivityLog::create([
                'staff_id'    => $staff?->staff_id,
                'staff_name'  => $staff ? trim($staff->first_name . ' ' . $staff->last_name) : null,
                'staff_role'  => $staff?->role,
                'module'      => self::normalize($module),
                'action'      => self::normalize($action),
                'description' => Str::limit($description, 255, ''),
                'method'      => $request?->method(),
                'route_name'  => $request?->route()?->getName(),
                'path'        => $request?->path(),
                'ip_address'  => $request?->ip(),
                'user_agent'  => $request ? Str::limit((string) $request->userAgent(), 1000, '') : null,
                'properties'  => $properties ?: null,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public static function describeRequest(Request $request): array
    {
        $routeName = (string) $request->route()?->getName();
        $path = trim($request->path(), '/');
        $method = strtoupper($request->method());
        $segments = array_values(array_filter(explode('/', $path)));
        $module = self::moduleFromRoute($routeName, $segments);
        $action = self::actionFromRequest($method, $routeName, $segments);
        $description = self::description($module, $action, $routeName, $path);

        return [$module, $action, $description];
    }

    private static function moduleFromRoute(string $routeName, array $segments): string
    {
        if (str_starts_with($routeName, 'frontdesk.')) {
            return 'frontdesk';
        }

        $first = $segments[0] ?? 'system';
        if ($first === 'admin') {
            return $segments[1] ?? 'admin';
        }

        return $first ?: 'system';
    }

    private static function actionFromRequest(string $method, string $routeName, array $segments): string
    {
        foreach (['restore', 'reactivate', 'archive', 'reset-password', 'checkout', 'timein', 'time-in', 'time-out', 'acknowledge', 'clear-now', 'read-all', 'notify-tenant', 'request-resubmission', 'resubmit'] as $keyword) {
            if (str_contains($routeName, $keyword) || in_array($keyword, $segments, true)) {
                return str_replace('-', '_', $keyword);
            }
        }

        return match ($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => strtolower($method),
        };
    }

    private static function description(string $module, string $action, string $routeName, string $path): string
    {
        $label = Str::of($module)->replace(['-', '_'], ' ')->title();
        $verb = Str::of($action)->replace('_', ' ')->title();

        return trim("{$verb} in {$label}" . ($routeName ? " ({$routeName})" : " ({$path})"));
    }

    private static function normalize(string $value): string
    {
        return Str::of($value)->lower()->replace([' ', '-'], '_')->limit(60, '')->toString();
    }
}
