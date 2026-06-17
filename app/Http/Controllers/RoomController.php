<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('floor')->orderBy('room_number')->get();

        $occupancy = Tenant::whereNotIn('status', ['inactive', 'move_out'])
            ->whereNotNull('room_number')
            ->selectRaw('room_number, COUNT(*) as count')
            ->groupBy('room_number')
            ->pluck('count', 'room_number');

        $reservedOccupancy = Tenant::where('status', 'reserved')
            ->whereNotNull('room_number')
            ->selectRaw('room_number, COUNT(*) as count')
            ->groupBy('room_number')
            ->pluck('count', 'room_number');

        return response()->json($rooms->map(fn($r) => [
            'id'                => $r->id,
            'room_number'       => $r->room_number,
            'floor'             => $r->floor,
            'capacity'          => $r->capacity,
            'stay_type'         => $r->stay_type,
            'is_active'         => $r->is_active,
            'occupancy'         => $occupancy[$r->room_number] ?? 0,
            'reserved_occupancy'=> $reservedOccupancy[$r->room_number] ?? 0,
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number',
            'floor'       => 'nullable|integer|min:1|max:99',
            'capacity'    => 'required|integer|min:1|max:10',
            'stay_type'   => 'required|in:Solo Room,Shared Room',
        ]);
        $roomNum = trim($request->room_number);
        $derivedFloor = strlen($roomNum) > 2
            ? (int) substr($roomNum, 0, strlen($roomNum) - 2)
            : (int) $request->floor;
        if ($derivedFloor < 1 || $derivedFloor > 99) {
            return response()->json(['message' => 'Could not determine a valid floor from the room number.'], 422);
        }
        $room = Room::create([
            'room_number' => $roomNum,
            'floor'       => $derivedFloor,
            'capacity'    => $request->capacity,
            'stay_type'   => $request->stay_type,
            'is_active'   => true,
        ]);

        return response()->json(['message' => 'Room added successfully.', 'room' => $room]);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $id,
            'floor'       => 'nullable|integer|min:1|max:99',
            'capacity'    => 'required|integer|min:1|max:10',
            'stay_type'   => 'required|in:Solo Room,Shared Room',
            'is_active'   => 'required|boolean',
        ]);
        $roomNum = trim($request->room_number);
        $derivedFloor = strlen($roomNum) > 2
            ? (int) substr($roomNum, 0, strlen($roomNum) - 2)
            : (int) $request->floor;
        if ($derivedFloor < 1) {
            return response()->json(['message' => 'Could not determine a valid floor from the room number.'], 422);
        }

        $currentOccupancy = Tenant::whereNotIn('status', ['inactive', 'move_out'])
            ->where('room_number', $room->room_number)
            ->count();

        if ($request->capacity < $currentOccupancy) {
            return response()->json([
                'message' => "Cannot reduce capacity to {$request->capacity}. Room currently has {$currentOccupancy} active tenant(s).",
            ], 422);
        }

        $room->update([
            'room_number' => $roomNum,
            'floor'       => $derivedFloor,
            'capacity'    => $request->capacity,
            'stay_type'   => $request->stay_type,
            'is_active'   => $request->is_active,
        ]);

        return response()->json(['message' => 'Room updated successfully.', 'room' => $room]);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $occupancy = Tenant::whereNotIn('status', ['inactive', 'move_out'])
            ->where('room_number', $room->room_number)
            ->count();

        if ($occupancy > 0) {
            return response()->json([
                'message' => "Cannot delete room {$room->room_number}. It still has {$occupancy} active tenant(s).",
            ], 422);
        }

        $room->delete();

        return response()->json(['message' => 'Room deleted successfully.']);
    }
}