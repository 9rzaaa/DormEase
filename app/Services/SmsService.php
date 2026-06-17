<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * 
     *
     * @param string $number
     * @param string $message
     * @return bool
     */
    public static function send(string $number, string $message): bool
    {
        $driver = config('sms.driver', 'log');

        $cleanNumber = preg_replace('/\D/', '', $number);

        if (strlen($cleanNumber) === 11 && str_starts_with($cleanNumber, '09')) {
            $cleanNumber = '639' . substr($cleanNumber, 2);
        }
        if ($driver === 'log') {
            Log::info("SMS SENT TO {$cleanNumber} [Driver: {$driver}]: {$message}");
            return true;
        }
        if ($driver === 'semaphore') {
            $apiKey = config('sms.semaphore.api_key');
            $sender = config('sms.semaphore.sender_name', 'SEMAPHORE');

            if (empty($apiKey)) {
                Log::error("SMS failed: Semaphore API Key is not set.");
                return false;
            }

            try {
                $response = Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
                    'apikey' => $apiKey,
                    'number' => $cleanNumber,
                    'message' => $message,
                    'sendername' => $sender
                ]);
                if ($response->successful()) {
                    Log::info("SMS successfully sent to {$cleanNumber} via Semaphore.");
                    return true;
                }
                Log::error("SMS failed via Semaphore. Status: " . $response->status() . " Body: " . $response->body());
                return false;
            } catch (\Exception $e) {
                Log::error("SMS failed via Semaphore. Error: " . $e->getMessage());
                return false;
            }
        }

        if ($driver === 'twilio') {
            $sid = config('sms.twilio.sid');
            $token = config('sms.twilio.token');
            $from = config('sms.twilio.from');

            if (empty($sid) || empty($token) || empty($from)) {
                Log::error("SMS failed: Twilio credentials are not fully set.");
                return false;
            }
            try {
                $twilioNumber = '+' . $cleanNumber;
                $response = Http::withBasicAuth($sid, $token)
                    ->asForm()
                    ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                        'To' => $twilioNumber,
                        'From' => $from,
                        'Body' => $message,
                    ]);

                if ($response->successful()) {
                    Log::info("SMS successfully sent to {$cleanNumber} via Twilio.");
                    return true;
                }

                Log::error("SMS failed via Twilio. Status: " . $response->status() . " Body: " . $response->body());
                return false;
            } catch (\Exception $e) {
                Log::error("SMS failed via Twilio. Error: " . $e->getMessage());
                return false;
            }
        }

        Log::error("SMS failed: Unknown driver '{$driver}'.");
        return false;
    }
}
