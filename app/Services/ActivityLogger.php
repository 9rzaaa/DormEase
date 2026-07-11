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
        $target = self::targetLabel($module, $routeName, $path);
        $verb = self::actionLabel($action);

        return trim("{$verb} {$target}");
    }

    private static function actionLabel(string $action): string
    {
        return match ($action) {
            'create' => 'Created',
            'update' => 'Updated',
            'delete' => 'Deleted',
            'archive' => 'Archived',
            'restore' => 'Restored',
            'reactivate' => 'Reactivated',
            'reset_password' => 'Reset password for',
            'checkout' => 'Checked out',
            'timein', 'time_in' => 'Timed in',
            'time_out' => 'Timed out',
            'acknowledge' => 'Acknowledged',
            'clear_now' => 'Cleared',
            'read_all' => 'Marked all read in',
            'notify_tenant' => 'Notified tenant from',
            'request_resubmission' => 'Requested resubmission for',
            'resubmit' => 'Resubmitted',
            default => Str::of($action)->replace('_', ' ')->title()->toString(),
        };
    }

    private static function targetLabel(string $module, string $routeName, string $path): string
    {
        if (str_contains($routeName, 'reset-password')) {
            return str_starts_with($routeName, 'staff.') ? 'staff account' : 'tenant account';
        }

        if (str_contains($routeName, 'attendance.clear')) {
            return 'staff attendance logs';
        }

        if (str_contains($routeName, 'keywords')) {
            return str_contains($routeName, 'emergency') ? 'emergency keyword' : 'maintenance keyword';
        }

        if (str_contains($routeName, 'terms')) {
            return str_contains($routeName, 'emergency') ? 'emergency term' : 'maintenance term';
        }

        $labels = [
            'auth' => 'session',
            'tenants' => 'tenant record',
            'staff' => 'staff record',
            'rooms' => 'room record',
            'billing' => 'billing record',
            'visitors' => 'visitor log',
            'announcements' => 'announcement',
            'documents' => 'document',
            'document_requests' => 'document request',
            'downloadable_forms' => 'downloadable form',
            'maintenance' => 'maintenance request',
            'emergency' => 'emergency report',
            'profile' => 'profile',
            'settings' => 'settings',
            'notifications' => 'notifications',
            'contact_inquiries' => 'contact inquiry',
            'frontdesk' => 'front desk record',
            'admin' => 'admin record',
        ];

        $module = str_replace('-', '_', $module);

        if ($module === 'document-requests') {
            $module = 'document_requests';
        }

        if ($module === 'downloadable-forms') {
            $module = 'downloadable_forms';
        }

        return $labels[$module] ?? Str::of($module ?: $path)->replace(['-', '_'], ' ')->lower()->append(' record')->toString();
    }

    private static function normalize(string $value): string
    {
        return Str::of($value)->lower()->replace([' ', '-'], '_')->limit(60, '')->toString();
    }
}
