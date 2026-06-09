<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expo_push_token' => 'required|string|max:255',
            'platform' => 'nullable|string|max:30',
            'device_name' => 'nullable|string|max:255',
        ]);

        $token = DeviceToken::updateOrCreate(
            ['expo_push_token' => $validated['expo_push_token']],
            [
                'tenant_id' => $request->user()->tenant_id,
                'platform' => $validated['platform'] ?? null,
                'device_name' => $validated['device_name'] ?? null,
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'Device token saved.',
            'device_token_id' => $token->id,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'expo_push_token' => 'required|string|max:255',
        ]);

        DeviceToken::where('tenant_id', $request->user()->tenant_id)
            ->where('expo_push_token', $request->expo_push_token)
            ->delete();

        return response()->json(['message' => 'Device token removed.']);
    }
}
