<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\ArchivedTenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;

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

        $billingData = \App\Models\WaterBilling::whereIn('payment_status', ['unpaid', 'overdue'])
            ->get()
            ->groupBy('tenant_id')
            ->map(function($bills) {
                return $bills->values()->map(function($b) {
                    return [
                        'billing_id'     => $b->billing_id,
                        'billing_month'  => $b->billing_month?->format('Y-m-d'),
                        'due_date'       => $b->due_date?->format('Y-m-d'),
                        'room_share'     => $b->room_share,
                        'payment_status' => $b->payment_status,
                    ];
                })->toArray();
            });

        return view('tenants', [
            'tenants'         => $tenants,
            'billingData'     => $billingData,
            'totalTenants'    => $tenants->count(),
            'activeCount'     => $tenants->where('status', 'active')->count(),
            'pendingCount'    => $tenants->where('status', 'pending')->count(),
            'reservedCount'   => $tenants->where('status', 'reserved')->count(),
            'deletedArchive'  => $deletedArchive,
            'inactiveArchive' => $inactiveArchive,
            'moveoutArchive'  => $moveoutArchive,
            'insideCount'     => \App\Models\Tenant::where('is_inside', true)->count(),
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
            'email' => [
                'required',
                'email',
                Rule::unique('tenants', 'email')->where(fn ($q) => $q->where('status', '!=', 'inactive')),
            ],
            'contact_number'         => 'nullable|string|max:20',
            'room_number'            => 'nullable|string|max:20',
            'floor'                  => 'nullable|integer|min:1|max:5',
            'stay_type'              => 'nullable|string|max:50',
            'move_in_date'           => 'nullable|date',
            'move_out_date'          => 'nullable|date',
            'estimated_move_in_date' => 'nullable|date|after_or_equal:today',
            'reservation_notes'      => 'nullable|string|max:500',
            'referred_by'            => 'nullable|string|max:150',
        ]);

        if ($request->filled('move_in_date') && $request->filled('move_out_date')) {
            if ($request->move_out_date < $request->move_in_date) {
                return back()->withErrors(['move_out_date' => 'Move-out date cannot be earlier than move-in date.'])->withInput();
            }
        }

        if ($request->filled('room_number')) {
            $room = \App\Models\Room::where('room_number', trim($request->room_number))
                ->where('is_active', true)
                ->first();

            if (!$room) {
                return back()->withErrors(['room_number' => 'This room does not exist or is inactive.'])->withInput();
            }

            $request->merge(['floor' => $room->floor]);
        }

        $isReserved = $request->input('add_mode') === 'reservation';

        try {
            [$tenant, $accountId, $tempPassword] = \Illuminate\Support\Facades\DB::transaction(function () use ($request, $isReserved) {
                if ($request->filled('room_number')) {
                    $room = \App\Models\Room::where('room_number', trim($request->room_number))
                        ->where('is_active', true)
                        ->lockForUpdate()
                        ->first();

                    if (!$room) {
                        throw new \RuntimeException('ROOM_NOT_FOUND');
                    }

                    $occupancy = \App\Models\Tenant::whereNotIn('status', ['inactive', 'move_out'])
                        ->where('room_number', trim($request->room_number))
                        ->lockForUpdate()
                        ->count();

                    if ($occupancy >= $room->capacity) {
                        throw new \RuntimeException("ROOM_FULL:{$room->capacity}");
                    }
                }

                $accountId    = Tenant::generateAccountId();
                $tempPassword = Tenant::generateTempPassword();

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
                    'referred_by'            => $request->referred_by,
                    'status'                 => $isReserved ? 'reserved' : 'pending',
                    'is_active'              => true,
                ]);

                return [$tenant, $accountId, $tempPassword];
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'ROOM_NOT_FOUND') {
                return back()->withErrors(['room_number' => 'This room does not exist or is inactive.'])->withInput();
            }
            if (str_starts_with($e->getMessage(), 'ROOM_FULL:')) {
                $cap = substr($e->getMessage(), 10);
                return back()->withErrors(['room_number' => "Room {$request->room_number} is already at full capacity ({$cap} pax)."])->withInput();
            }
            throw $e;
        }

        $notifMessage = $isReserved
            ? "New reservation: {$tenant->first_name} {$tenant->last_name} has reserved a room (Rm. {$tenant->room_number})."
            : "New tenant {$tenant->first_name} {$tenant->last_name} has been added.";

        NotificationHelper::sendToAll(
            type: $isReserved ? 'tenant_reserved' : 'tenant_new',
            message: $notifMessage,
            ref_id: $tenant->tenant_id,
        );

        if ($isReserved) {
            return redirect()->route('tenants.index')
                ->with('success', 'Reservation created successfully.');
        }

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
            'estimated_move_in_date' => 'nullable|date|after_or_equal:today',
            'reservation_notes'      => 'nullable|string|max:500',
            'referred_by'            => 'nullable|string|max:150',
            'status'                 => 'required|in:active,pending,reserved,move_out,inactive',
        ], [], [
            'first_name'    => 'first name',
            'last_name'     => 'last name',
            'email'         => 'email address',
            'floor'         => 'floor',
            'stay_type'     => 'stay type',
            'move_in_date'  => 'move-in date',
            'move_out_date' => 'move-out date',
        ]);

        if ($request->filled('move_in_date') && $request->filled('move_out_date')) {
            if ($request->move_out_date < $request->move_in_date) {
                return back()->withErrors(['move_out_date' => 'Move-out date cannot be earlier than move-in date.'])->withInput();
            }
        }

        if ($request->filled('room_number')) {
            $roomNumber = trim($request->room_number);
            $request->merge(['room_number' => $roomNumber]);

            $room = \App\Models\Room::where('room_number', $roomNumber)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();

            if (!$room) {
                return back()->withErrors(['room_number' => 'This room does not exist or is inactive.'])->withInput()->with('edit_tenant_id', $id);
            }

            if ($request->status !== 'inactive' && $request->status !== 'move_out') {
                $occupancyCount = \App\Models\Tenant::whereNotIn('status', ['inactive', 'move_out'])
                    ->where('room_number', $roomNumber)
                    ->where('tenant_id', '!=', $id)
                    ->lockForUpdate()
                    ->count();

                if ($occupancyCount >= $room->capacity) {
                    return back()->withErrors(['room_number' => "Room {$roomNumber} is already at full capacity ({$room->capacity} pax)."])->withInput()->with('edit_tenant_id', $id);
                }
            }

            $request->merge(['floor' => $room->floor]);
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
            'referred_by'            => $request->referred_by,
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

    public function tagAsMovedIn($id)
    {
        $tenant = Tenant::findOrFail($id);

        if ($tenant->status !== 'reserved') {
            return redirect()->route('tenants.index')
                ->with('success', 'Tenant is not in reserved status.');
        }

        if ($request_room = $tenant->room_number) {
            $room = \App\Models\Room::where('room_number', $request_room)
                ->where('is_active', true)
                ->first();

            if (!$room) {
                return redirect()->route('tenants.index')
                    ->with('error', 'Assigned room no longer exists or is inactive.');
            }

            $occupancy = Tenant::whereNotIn('status', ['inactive', 'move_out'])
                ->where('room_number', $request_room)
                ->where('tenant_id', '!=', $tenant->tenant_id)
                ->count();

            if ($occupancy >= $room->capacity) {
                return redirect()->route('tenants.index')
                    ->with('error', "Room {$request_room} is already at full capacity.");
            }
        }

        $accountId    = Tenant::generateAccountId();
        $tempPassword = Tenant::generateTempPassword();

        $tenant->update([
            'account_id'             => $accountId,
            'password_hash'          => Hash::make($tempPassword),
            'is_temp_password'       => true,
            'status'                 => 'pending',
            'move_in_date'           => $tenant->move_in_date ?? now()->format('Y-m-d'),
            'estimated_move_in_date' => null,
            'reservation_notes'      => null,
        ]);

        NotificationHelper::sendToAll(
            type: 'tenant_moved_in',
            message: "{$tenant->first_name} {$tenant->last_name} has been tagged as moved in.",
            ref_id: $tenant->tenant_id,
        );

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant tagged as moved in successfully.')
            ->with('new_account_id',    $accountId)
            ->with('new_temp_password', $tempPassword)
            ->with('new_tenant_name',   $tenant->first_name . ' ' . $tenant->last_name);
    }

    public function reschedule(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        if ($tenant->status !== 'reserved') {
            return redirect()->route('tenants.index')
                ->with('success', 'Tenant is not in reserved status.');
        }

        $request->validate([
            'estimated_move_in_date' => 'required|date',
        ]);

        $tenant->update([
            'estimated_move_in_date' => $request->estimated_move_in_date,
        ]);

        NotificationHelper::sendToAll(
            type: 'tenant_reservation_rescheduled',
            message: "Reservation for {$tenant->first_name} {$tenant->last_name} has been rescheduled to " . \Carbon\Carbon::parse($request->estimated_move_in_date)->format('M d, Y') . ".",
            ref_id: $tenant->tenant_id,
        );

        return redirect()->route('tenants.index')
            ->with('success', 'Reservation rescheduled successfully.');
    }

    public function reactivate($id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if (Auth::guard('staff')->user()->role !== 'admin') {
            return redirect()->route('tenants.index')->with('error', 'Unauthorized. Admin access required.');
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

        ArchivedTenant::where('original_id', $tenant->tenant_id)
            ->where('archive_type', 'inactive')
            ->delete();

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
            'contact_number' => ['required', 'string', 'regex:/^(?=.*\d)[0-9\-\+\s]{7,20}$/'],
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

        $oldPhoto = $tenant->profile_photo;

        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        try {
            $tenant->update(['profile_photo' => $path]);
        } catch (\Exception $e) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'Failed to update profile photo.'], 500);
        }

        if ($oldPhoto && $oldPhoto !== $path) {
            Storage::disk('public')->delete($oldPhoto);
        }

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

        \Illuminate\Support\Facades\DB::transaction(function () use ($tenant) {
            $this->archiveTenant($tenant, 'deleted');

            \App\Models\TenantLog::where('tenant_id', $tenant->tenant_id)->delete();
            \App\Models\WaterBilling::where('tenant_id', $tenant->tenant_id)
                ->whereIn('payment_status', ['unpaid', 'overdue'])
                ->update(['tenant_id' => null]);

            $tenant->tokens()->delete();
            $tenant->delete();
        });

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

        return view('fdtenant', [
            'tenants'        => $tenants,
            'totalTenants'   => $tenants->count(),
            'activeCount'    => $tenants->where('status', 'active')->count(),
            'pendingCount'   => $tenants->where('status', 'pending')->count(),
            'occupiedUnits'  => $occupiedUnits,
            'vacantUnits'    => $totalUnits - $occupiedUnits,
            'totalUnits'     => $totalUnits,
            'activeOccupied' => Tenant::where('status', 'active')->whereNotNull('room_number')->distinct('room_number')->count('room_number'),
            'insideCount'    => Tenant::where('is_inside', true)->count(),
            'deletedArchive' => $deletedArchive,
            'inactiveArchive'=> $inactiveArchive,
            'moveoutArchive' => $moveoutArchive,
        ]);
    }

    public function updateNotes(Request $request, $id)
    {
        if (!Auth::guard('staff')->check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

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

        $passwordHash = $tenant ? $tenant->password_hash : '$2y$10$invalidsaltinvalidsaltinvalidsalt.';

        if (!$tenant || !Hash::check($request->password, $passwordHash)) {
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
        $tenant->markAccessed();
        $tenant = $tenant->fresh();

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