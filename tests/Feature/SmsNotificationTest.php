<?php

namespace Tests\Feature;

use App\Models\EmergencyReport;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SmsNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_sms_when_driver_is_log()
    {
        config(['sms.driver' => 'log']);
        Log::spy();

        $tenant = Tenant::create([
            'account_id' => 'TNT-2026-999',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password_hash' => bcrypt('password'),
            'contact_number' => '0917-123-4567',
            'guardian_number' => '0918-765-4321',
            'room_number' => '101',
            'stay_type' => 'student',
            'status' => 'active',
        ]);

        $report = EmergencyReport::create([
            'tenant_id' => $tenant->tenant_id,
            'is_panic_alert' => false,
            'emergency_type' => 'Medical',
            'urgency_level' => 'critical',
            'location' => 'Room 101',
            'reported_at' => now(),
        ]);

        Log::shouldHaveReceived('info')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'SMS SENT TO 639187654321')
                    && str_contains($message, 'John Doe')
                    && str_contains($message, 'Medical');
            });
    }

    public function test_it_sends_sms_via_semaphore()
    {
        config([
            'sms.driver' => 'semaphore',
            'sms.semaphore.api_key' => 'test_api_key',
            'sms.semaphore.sender_name' => 'TEST_SENDER',
        ]);

        Http::fake([
            'api.semaphore.co/*' => Http::response(['status' => 'success'], 200),
        ]);

        $tenant = Tenant::create([
            'account_id' => 'TNT-2026-998',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'password_hash' => bcrypt('password'),
            'contact_number' => '0917-123-4567',
            'guardian_number' => '0918-765-4322',
            'room_number' => '102',
            'stay_type' => 'student',
            'status' => 'active',
        ]);

        $report = EmergencyReport::create([
            'tenant_id' => $tenant->tenant_id,
            'is_panic_alert' => false,
            'emergency_type' => 'Fire',
            'urgency_level' => 'critical',
            'location' => 'Room 102',
            'reported_at' => now(),
        ]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.semaphore.co/api/v4/messages'
                && $request['apikey'] === 'test_api_key'
                && $request['number'] === '639187654322'
                && str_contains($request['message'], 'Jane Doe')
                && str_contains($request['message'], 'Fire')
                && $request['sendername'] === 'TEST_SENDER';
        });
    }
}
