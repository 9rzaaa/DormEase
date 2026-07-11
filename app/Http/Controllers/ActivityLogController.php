<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Staff;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query()->latest();

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('staff_name', 'like', "%{$search}%")
                    ->orWhere('route_name', 'like', "%{$search}%")
                    ->orWhere('path', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('activity-logs', [
            'logs' => $logs,
            'modules' => ActivityLog::select('module')->distinct()->orderBy('module')->pluck('module'),
            'actions' => ActivityLog::select('action')->distinct()->orderBy('action')->pluck('action'),
            'staffOptions' => Staff::orderBy('first_name')->orderBy('last_name')->get(['staff_id', 'first_name', 'last_name', 'role']),
        ]);
    }
}
