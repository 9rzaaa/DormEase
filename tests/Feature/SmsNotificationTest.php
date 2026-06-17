<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SmsNotificationTest extends TestCase
{
    public function test_it_logs_sms_when_driver_is_log()
    {
        config(['sms.driver' => 'log']);
        Log::spy();

        \App\Services\SmsService::send('0918-765-4321', 'Test emergency alert for John Doe');

        Log::shouldHaveReceived('info')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'SMS SENT TO 639187654321')
                    && str_contains($message, 'Test emergency alert for John Doe');
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

        \App\Services\SmsService::send('0918-765-4322', 'Test emergency alert for Jane Doe');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.semaphore.co/api/v4/messages'
                && $request['apikey'] === 'test_api_key'
                && $request['number'] === '639187654322'
                && str_contains($request['message'], 'Test emergency alert for Jane Doe')
                && $request['sendername'] === 'TEST_SENDER';
        });
    }
}
