<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\ArchivedTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::orderBy('created_at', 'desc')->get();

        $deletedArchive  = ArchivedTenant::where('archive_type', 'deleted')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $inactiveArchive = ArchivedTenant::where('archive_type', 'inactive')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $moveoutArchive  = ArchivedTenant::where('archive_type', 'move_out')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        return view('tenants', [
            'tenants'         => $tenants,
            'totalTenants'    => $tenants->count(),
            'activeCount'     => $tenants->where('status', 'active')->count(),
            'pendingCount'    => $tenants->where('status', 'pending')->count(),
            'reservedCount'   => $tenants->where('status', 'reserved')->count(),
            'deletedArchive'  => $deletedArchive,
            'inactiveArchive' => $inactiveArchive,
            'moveoutArchive'  => $moveoutArchive,
        ]);
    }

    private function formatArchive(ArchivedTenant $r): array
    {
        return [
            'id'             => $r->original_id,
            'archive_id'     => $r->id,
            'account_id'     => $r->account_id,
            'first_name'     => $r->first_name,
            'last_name'      => $r->last_name,
            'email'          => $r->email,
            'contact_number' => $r->contact_number,
            'room_number'    => $r->room_number,
            'floor'          => $r->floor,
            'stay_type'      => $r->stay_type,
            'move_in_date'   => $r->move_in_date?->format('Y-m-d'),
            'move_out_date'  => $r->move_out_date?->format('Y-m-d'),
            'status'         => $r->status,
            'archived_at'    => $r->archived_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function archiveTenant(Tenant $t, string $type): void
    {
        ArchivedTenant::create([
            'original_id'    => $t->tenant_id,
            'archive_type'   => $type,
            'account_id'     => $t->account_id,
            'first_name'     => $t->first_name,
            'last_name'      => $t->last_name,
            'email'          => $t->email,
            'contact_number' => $t->contact_number,
            'room_number'    => $t->room_number,
            'floor'          => $t->floor,
            'stay_type'      => $t->stay_type,
            'move_in_date'   => $t->move_in_date,
            'move_out_date'  => $t->move_out_date,
            'status'         => $t->status,
            'archived_at'    => now(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'             => 'required|string|max:100',
            'last_name'              => 'required|string|max:100',
            'email'                  => 'required|email|unique:tenants,email',
            'contact_number'         => 'nullable|string|max:20',
            'room_number'            => 'nullable|string|max:20',
            'floor'                  => 'nullable|integer|min:1|max:5',
            'stay_type'              => 'nullable|string|max:50',
            'move_in_date'           => 'nullable|date',
            'estimated_move_in_date' => 'nullable|date',
            'reservation_notes'      => 'nullable|string|max:500',
        ]);

        if ($request->filled('room_number')) {
            $room = \App\Models\Room::where('room_number', $request->room_number)
                ->where('is_active', true)
                ->first();

            if (!$room) {
                return back()->withErrors(['room_number' => 'This room does not exist or is inactive.'])->withInput();
            }

            $occupancyQuery = \App\Models\Tenant::whereNotIn('status', ['inactive', 'move_out'])
                ->where('room_number', $request->room_number);

            if ($occupancyQuery->count() >= $room->capacity) {
                return back()->withErrors(['room_number' => "Room {$request->room_number} is already at full capacity ({$room->capacity} pax)."])->withInput();
            }
        }

        $accountId    = Tenant::generateAccountId();
        $tempPassword = Tenant::generateTempPassword();

        $isReserved = $request->input('add_mode') === 'reservation';

        $tenant = Tenant::create([
            'account_id'             => $accountId,
            'password_hash'          => Hash::make($tempPassword),
            'is_temp_password'       => true,
            'first_name'             => $request->first_name,
            'last_name'              => $request->last_name,
            'email'                  => $request->email,
            'contact_number'         => $request->contact_number,
            'room_number'            => $request->room_number,
            'floor'                  => $request->floor,
            'stay_type'              => $request->stay_type,
            'move_in_date'           => $request->move_in_date,
            'estimated_move_in_date' => $request->estimated_move_in_date,
            'reservation_notes'      => $request->reservation_notes,
            'status'                 => $isReserved ? 'reserved' : 'pending',
            'is_active'              => true,
        ]);

        NotificationHelper::sendToAll(
            type: 'tenant_new',
            message: "New tenant {$tenant->first_name} {$tenant->last_name} has been added.",
            ref_id: $tenant->tenant_id,
        );

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant account created successfully.')
            ->with('new_account_id',    $accountId)
            ->with('new_temp_password', $tempPassword)
            ->with('new_tenant_name',   $tenant->first_name . ' ' . $tenant->last_name);
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'first_name'             => 'required|string|max:100',
            'last_name'              => 'required|string|max:100',
            'email'                  => 'required|email|unique:tenants,email,' . $id . ',tenant_id',
            'contact_number'         => 'nullable|string|max:20',
            'room_number'            => 'nullable|string|max:20',
            'floor'                  => 'nullable|integer|min:1|max:5',
            'stay_type'              => 'nullable|string|max:50',
            'move_in_date'           => 'nullable|date',
            'move_out_date'          => 'nullable|date',
            'estimated_move_in_date' => 'nullable|date',
            'reservation_notes'      => 'nullable|string|max:500',
            'status'                 => 'required|in:active,pending,reserved,move_out,inactive',
        ]);

        if ($request->filled('room_number')) {
            $room = \App\Models\Room::where('room_number', $request->room_number)
                ->where('is_active', true)
                ->first();

            if (!$room) {
                return back()->withErrors(['room_number' => 'This room does not exist or is inactive.'])->withInput();
            }

            $occupancyQuery = \App\Models\Tenant::whereNotIn('status', ['inactive', 'move_out'])
                ->where('room_number', $request->room_number)
                ->where('tenant_id', '!=', $id);

            if ($occupancyQuery->count() >= $room->capacity) {
                return back()->withErrors(['room_number' => "Room {$request->room_number} is already at full capacity ({$room->capacity} pax)."])->withInput();
            }
        }
        
        $previousStatus = $tenant->status;

        $tenant->update([
            'first_name'             => $request->first_name,
            'last_name'              => $request->last_name,
            'email'                  => $request->email,
            'contact_number'         => $request->contact_number,
            'room_number'            => $request->room_number,
            'floor'                  => $request->floor,
            'stay_type'              => $request->stay_type,
            'move_in_date'           => $request->move_in_date,
            'move_out_date'          => $request->move_out_date,
            'estimated_move_in_date' => $request->estimated_move_in_date,
            'reservation_notes'      => $request->reservation_notes,
            'status'                 => $request->status,
            'is_active'              => $request->status !== 'inactive',
        ]);

        $fresh = $tenant->fresh();

        if ($previousStatus !== 'inactive' && $request->status === 'inactive') {
            $this->archiveTenant($fresh, 'inactive');
        }

        if ($previousStatus !== 'move_out' && $request->status === 'move_out') {
            $this->archiveTenant($fresh, 'move_out');
        }

        NotificationHelper::sendToAll(
            type: 'tenant_updated',
            message: "Tenant {$tenant->first_name} {$tenant->last_name} information has been updated.",
            ref_id: $tenant->tenant_id,
        );

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant information updated successfully.');
    }

    public function reactivate($id)
    {
        if (\Illuminate\Support\Facades\Auth::guard('staff')->user()?->role !== 'admin') {
            return redirect()->route('tenants.index')->with('error', 'Unauthorized.');
        }

        $tenant = Tenant::findOrFail($id);

        if ($tenant->status !== 'inactive') {
            return redirect()->route('tenants.index')
                ->with('success', 'Tenant is already active.');
        }

        $tenant->update([
            'status'    => 'active',
            'is_active' => true,
        ]);

        NotificationHelper::sendToAll(
            type: 'tenant_reactivated',
            message: "Tenant {$tenant->first_name} {$tenant->last_name} account has been reactivated.",
            ref_id: $tenant->tenant_id,
        );

        return redirect()->route('tenants.index')
            ->with('success', "Tenant {$tenant->first_name} {$tenant->last_name} has been reactivated.");
    }

    public function apiUpdateProfile(Request $request)
    {
        $tenant = $request->user();

        $request->validate([
            'email'          => 'required|email|unique:tenants,email,' . $tenant->tenant_id . ',tenant_id',
            'contact_number' => 'required|string|digits:11',
        ]);

        $tenant->update([
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return response()->json([
            'message'        => 'Contact info updated successfully.',
            'email'          => $tenant->email,
            'contact_number' => $tenant->contact_number,
        ]);
    }

    public function apiUpdatePhoto(Request $request)
    {
        $tenant = $request->user();

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($tenant->profile_photo) {
            Storage::disk('public')->delete($tenant->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $tenant->update(['profile_photo' => $path]);

        return response()->json([
            'message'       => 'Profile photo updated successfully.',
            'profile_photo' => $path,
        ]);
    }

    public function resetPassword($id)
    {
        $tenant       = Tenant::findOrFail($id);
        $tempPassword = Tenant::generateTempPassword();

        $tenant->update([
            'password_hash'    => Hash::make($tempPassword),
            'is_temp_password' => true,
        ]);

        return redirect()->route('tenants.index')
            ->with('success', 'Password reset successfully.')
            ->with('reset_account_id',    $tenant->account_id)
            ->with('reset_temp_password', $tempPassword)
            ->with('reset_tenant_name',   $tenant->first_name . ' ' . $tenant->last_name);
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $this->archiveTenant($tenant, 'deleted');
        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant account deleted and archived.');
    }

    public function frontdeskIndex()
    {
        $tenants = Tenant::where('is_active', true)
            ->orderBy('first_name')
            ->get();

        $deletedArchive  = ArchivedTenant::where('archive_type', 'deleted')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $inactiveArchive = ArchivedTenant::where('archive_type', 'inactive')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $moveoutArchive  = ArchivedTenant::where('archive_type', 'move_out')
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn($r) => $this->formatArchive($r));

        $totalUnits    = 25;
        $occupiedUnits = Tenant::where('is_active', true)->whereNotNull('room_number')->distinct('room_number')->count('room_number');
        $vacantUnits   = $totalUnits - $occupiedUnits;

        return view('fdtenant', [
            'tenants'         => $tenants,
            'totalTenants'    => $tenants->count(),
            'activeCount'     => $tenants->where('status', 'active')->count(),
            'pendingCount'    => $tenants->where('status', 'pending')->count(),
            'occupiedUnits'   => $occupiedUnits,
            'vacantUnits'     => $vacantUnits,
            'totalUnits'      => $totalUnits,
            'activeOccupied'  => Tenant::where('status', 'active')->whereNotNull('room_number')->distinct('room_number')->count('room_number'),
            'deletedArchive'  => $deletedArchive,
            'inactiveArchive' => $inactiveArchive,
            'moveoutArchive'  => $moveoutArchive,
        ]);
    }

    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $tenant = Tenant::findOrFail($id);
        $tenant->update(['notes' => $request->notes]);

        return response()->json(['message' => 'Note saved successfully.']);
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'account_id' => 'required|string',
            'password'   => 'required|string',
        ]);

        $tenant = Tenant::where('account_id', $request->account_id)->first();

        if (!$tenant || !Hash::check($request->password, $tenant->password_hash)) {
            return response()->json([
                'error'   => 'invalid_credentials',
                'message' => 'Account ID or password is incorrect.',
            ], 401);
        }

        if ($tenant->status === 'pending') {
            return response()->json([
                'error'   => 'account_pending',
                'message' => 'Your account is pending activation. Please visit the admin office to complete your registration.',
            ], 403);
        }

        if (!$tenant->is_active) {
            return response()->json([
                'error'   => 'account_deactivated',
                'message' => 'Your account has been temporarily deactivated. Please visit the admin office for reactivation.',
            ], 403);
        }

        $tenant->update(['last_login_at' => now()]);

        $token = $tenant->createToken('tenant-app')->plainTextToken;

        return response()->json([
            'message'          => 'Login successful.',
            'token'            => $token,
            'is_temp_password' => $tenant->is_temp_password,
            'tenant' => [
                'tenant_id'              => $tenant->tenant_id,
                'account_id'             => $tenant->account_id,
                'first_name'             => $tenant->first_name,
                'last_name'              => $tenant->last_name,
                'email'                  => $tenant->email,
                'contact_number'         => $tenant->contact_number,
                'profile_photo'          => $tenant->profile_photo,
                'room_number'            => $tenant->room_number,
                'floor'                  => $tenant->floor,
                'stay_type'              => $tenant->stay_type,
                'status'                 => $tenant->status,
                'estimated_move_in_date' => $tenant->estimated_move_in_date,
                'reservation_notes'      => $tenant->reservation_notes,
            ],
        ]);
    }
}