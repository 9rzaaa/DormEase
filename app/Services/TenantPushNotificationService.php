<?php

namespace App\Services;

use App\Models\DeviceToken;
use App\Models\Notification;
use App\Models\Tenant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TenantPushNotificationService
{
    private const EXPO_PUSH_URL = 'https://exp.host/--/api/v2/push/send';
    private const EXPO_RECEIPT_URL = 'https://exp.host/--/api/v2/push/getReceipts';

    private const ROUTES = [
        'announcement' => '/tenant/announcements',
        'document' => '/tenant/records',
        'bill' => '/tenant/water-bill',
        'payment' => '/tenant/water-bill',
        'maintenance' => '/tenant/maintenancehistory',
        'emergency' => '/tenant/emergency',
        'visitor' => '/tenant/visitors',
    ];

    public function sendToTenant(
        Tenant|int $tenant,
        string $type,
        string $title,
        string $body,
        ?int $refId = null,
        ?string $route = null
    ): void {
        $tenantId = $tenant instanceof Tenant ? $tenant->tenant_id : $tenant;
        $route ??= self::ROUTES[$type] ?? '/tenant/notifications';

        Notification::create([
            'tenant_id' => $tenantId,
            'type' => $type,
            'message' => $body,
            'ref_id' => $refId,
            'is_read' => 0,
            'created_at' => now(),
        ]);

        $tokens = DeviceToken::where('tenant_id', $tenantId)
            ->pluck('expo_push_token')
            ->filter()
            ->values();

        if ($tokens->isEmpty()) {
            return;
        }

        $messages = $tokens->map(fn(string $token) => [
            'to' => $token,
            'sound' => 'default',
            'channelId' => 'default',
            'priority' => 'high',
            'title' => $title,
            'body' => $body,
            'data' => [
                'type' => $type,
                'route' => $route,
                'ref_id' => $refId,
            ],
        ])->all();

        $this->sendExpoMessages($messages);
    }

    public function sendToAllTenants(
        string $type,
        string $title,
        string $body,
        ?int $refId = null,
        ?string $route = null
    ): void {
        $route ??= self::ROUTES[$type] ?? '/tenant/notifications';

        Tenant::where('is_active', true)
            ->select('tenant_id')
            ->chunkById(500, function ($tenants) use ($type, $title, $body, $refId, $route) {
                $tenantIds = $tenants->pluck('tenant_id')->all();

                if (empty($tenantIds)) {
                    return;
                }

                $createdAt = now();
                $notifications = array_map(fn(int $tenantId) => [
                    'tenant_id' => $tenantId,
                    'type' => $type,
                    'message' => $body,
                    'ref_id' => $refId,
                    'is_read' => 0,
                    'created_at' => $createdAt,
                ], $tenantIds);

                foreach (array_chunk($notifications, 100) as $notificationChunk) {
                    Notification::insert($notificationChunk);
                }

                $messages = DeviceToken::whereIn('tenant_id', $tenantIds)
                    ->pluck('expo_push_token')
                    ->filter()
                    ->unique()
                    ->map(fn(string $token) => [
                        'to' => $token,
                        'sound' => 'default',
                        'channelId' => 'default',
                        'priority' => 'high',
                        'title' => $title,
                        'body' => $body,
                        'data' => [
                            'type' => $type,
                            'route' => $route,
                            'ref_id' => $refId,
                        ],
                    ])
                    ->values()
                    ->all();

                Log::info('Prepared tenant push notification chunk.', [
                    'type' => $type,
                    'tenant_count' => count($tenantIds),
                    'message_count' => count($messages),
                ]);

                foreach (array_chunk($messages, 100) as $messageChunk) {
                    $this->sendExpoMessages($messageChunk);
                }
            }, 'tenant_id');
    }

    private function sendExpoMessages(array $messages): void
    {
        if (empty($messages)) {
            return;
        }

        try {
            $response = Http::withOptions([
                'verify' => (bool) config('services.expo.verify_ssl', true),
            ])
                ->timeout(3)
                ->acceptJson()
                ->post(self::EXPO_PUSH_URL, $messages);

            if ($response->failed()) {
                Log::warning('Expo push notification request was rejected.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'message_count' => count($messages),
                ]);
            } else {
                $tickets = $response->json('data', []);
                $failedTickets = collect($tickets)
                    ->filter(fn($ticket) => ($ticket['status'] ?? null) !== 'ok')
                    ->values()
                    ->all();

                if (!empty($failedTickets)) {
                    Log::warning('Expo push notification tickets failed.', [
                        'status' => $response->status(),
                        'failed_tickets' => $failedTickets,
                        'message_count' => count($messages),
                    ]);
                    return;
                }

                $ticketTokenMap = collect($tickets)
                    ->mapWithKeys(function ($ticket, $index) use ($messages) {
                        $ticketId = $ticket['id'] ?? null;

                        if (!$ticketId || empty($messages[$index]['to'])) {
                            return [];
                        }

                        return [$ticketId => $messages[$index]['to']];
                    })
                    ->all();

                Log::info('Expo push notification request accepted.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'message_count' => count($messages),
                    'ticket_ids' => array_keys($ticketTokenMap),
                ]);

                $this->logExpoReceipts($ticketTokenMap);
            }
        } catch (\Throwable $error) {
            Log::warning('Expo push notification failed.', [
                'message' => $error->getMessage(),
                'message_count' => count($messages),
            ]);
        }
    }

    private function logExpoReceipts(array $ticketTokenMap): void
    {
        $ticketIds = array_keys($ticketTokenMap);

        if (empty($ticketIds)) {
            return;
        }

        try {
            sleep(2);

            $response = Http::withOptions([
                'verify' => (bool) config('services.expo.verify_ssl', true),
            ])
                ->timeout(5)
                ->acceptJson()
                ->post(self::EXPO_RECEIPT_URL, [
                    'ids' => $ticketIds,
                ]);

            $receipts = $response->json('data', []);
            $deadTokens = [];

            foreach ($receipts as $ticketId => $receipt) {
                if (($receipt['details']['error'] ?? null) === 'DeviceNotRegistered') {
                    $deadTokens[] = $ticketTokenMap[$ticketId] ?? null;
                }
            }

            $deadTokens = array_values(array_filter($deadTokens));

            if (!empty($deadTokens)) {
                DeviceToken::whereIn('expo_push_token', $deadTokens)->delete();
            }

            Log::info('Expo push notification receipts checked.', [
                'status' => $response->status(),
                'body' => $response->body(),
                'ticket_count' => count($ticketIds),
                'deleted_stale_token_count' => count($deadTokens),
            ]);
        } catch (\Throwable $error) {
            Log::warning('Expo push notification receipt check failed.', [
                'message' => $error->getMessage(),
                'ticket_count' => count($ticketIds),
            ]);
        }
    }
}
