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
        'emergency' => '/tenant/emergencyhistory',
        'visitor' => '/tenant/visitors',
    ];

    public function sendToTenant(
        Tenant|int $tenant,
        string $type,
        string $title,
        string $body,
        ?int $refId = null,
        ?string $route = null,
        array $extraData = []
    ): void {
        $tenantId = $tenant instanceof Tenant ? $tenant->tenant_id : $tenant;
        $route ??= self::ROUTES[$type] ?? '/tenant/notifications';

        Notification::makeRoomFor(1, tenantId: $tenantId);

        Notification::create([
            'tenant_id' => $tenantId,
            'type' => $type,
            'message' => $body,
            'ref_id' => $refId,
            'is_read' => 0,
            'created_at' => now(),
        ]);

        Notification::pruneToLimit(tenantId: $tenantId);

        $unreadCount = Notification::where('tenant_id', $tenantId)
            ->where('is_read', 0)
            ->count();

        $tokens = DeviceToken::where('tenant_id', $tenantId)
            ->pluck('expo_push_token')
            ->filter()
            ->values();

        if ($tokens->isEmpty()) {
            return;
        }

        $messages = $tokens->map(fn(string $token) => $this->formatPushMessage(
            $token,
            $type,
            $title,
            $body,
            $unreadCount,
            $route,
            $refId,
            $extraData
        ))->all();

        $this->sendExpoMessages($messages);
    }

    public function sendPushOnlyToTenant(
        Tenant|int $tenant,
        string $type,
        string $title,
        string $body,
        ?int $refId = null,
        ?string $route = null,
        array $extraData = []
    ): int {
        $tenantId = $tenant instanceof Tenant ? $tenant->tenant_id : $tenant;
        $route ??= self::ROUTES[$type] ?? '/tenant/notifications';

        $unreadCount = Notification::where('tenant_id', $tenantId)
            ->where('is_read', 0)
            ->count();

        $tokens = DeviceToken::where('tenant_id', $tenantId)
            ->pluck('expo_push_token')
            ->filter()
            ->values();

        if ($tokens->isEmpty()) {
            return 0;
        }

        $messages = $tokens->map(fn(string $token) => $this->formatPushMessage(
            $token,
            $type,
            $title,
            $body,
            $unreadCount,
            $route,
            $refId,
            $extraData
        ))->all();

        $this->sendExpoMessages($messages);

        return count($messages);
    }

    public function sendToAllTenants(
        string $type,
        string $title,
        string $body,
        ?int $refId = null,
        ?string $route = null,
        array $extraData = []
    ): void {
        $route ??= self::ROUTES[$type] ?? '/tenant/notifications';

        Tenant::where('is_active', true)
            ->select('tenant_id')
            ->chunkById(500, function ($tenants) use ($type, $title, $body, $refId, $route, $extraData) {
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

                foreach ($tenantIds as $tenantId) {
                    Notification::makeRoomFor(1, tenantId: $tenantId);
                }

                foreach (array_chunk($notifications, 100) as $notificationChunk) {
                    Notification::insert($notificationChunk);
                }

                $unreadCounts = Notification::whereIn('tenant_id', $tenantIds)
                    ->where('is_read', 0)
                    ->select('tenant_id', \DB::raw('count(*) as count'))
                    ->groupBy('tenant_id')
                    ->pluck('count', 'tenant_id')
                    ->all();

                $messages = DeviceToken::whereIn('tenant_id', $tenantIds)
                    ->select('expo_push_token', 'tenant_id')
                    ->get()
                    ->filter(fn($dt) => !empty($dt->expo_push_token))
                    ->unique('expo_push_token')
                    ->map(fn($dt) => $this->formatPushMessage(
                        $dt->expo_push_token,
                        $type,
                        $title,
                        $body,
                        $unreadCounts[$dt->tenant_id] ?? 0,
                        $route,
                        $refId,
                        $extraData
                    ))
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
                $responseBody = $response->body();
                Log::warning('Expo push notification request was rejected.', [
                    'status' => $response->status(),
                    'body' => $responseBody,
                    'message_count' => count($messages),
                ]);

                // Hybrid fallback: If too many Experience IDs are mixed in the same request, send them individually
                if (str_contains($responseBody, 'PUSH_TOO_MANY_EXPERIENCE_IDS')) {
                    Log::info('Falling back to sending push notifications individually due to mixed Experience IDs.');
                    foreach ($messages as $message) {
                        $this->sendIndividualExpoMessage($message);
                    }
                }
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

    private function sendIndividualExpoMessage(array $message): void
    {
        try {
            $response = Http::withOptions([
                'verify' => (bool) config('services.expo.verify_ssl', true),
            ])
                ->timeout(3)
                ->acceptJson()
                ->post(self::EXPO_PUSH_URL, [$message]);

            if ($response->failed()) {
                Log::warning('Individual Expo push notification request was rejected.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'token' => $message['to'] ?? null,
                ]);
            } else {
                $tickets = $response->json('data', []);
                $ticketId = $tickets[0]['id'] ?? null;
                $token = $message['to'] ?? null;

                if ($ticketId && $token) {
                    $this->logExpoReceipts([$ticketId => $token]);
                }
            }
        } catch (\Throwable $error) {
            Log::warning('Individual Expo push notification failed.', [
                'message' => $error->getMessage(),
                'token' => $message['to'] ?? null,
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

    private function formatPushMessage(
        string $token,
        string $type,
        string $title,
        string $body,
        int $badge,
        string $route,
        ?int $refId,
        array $extraData = []
    ): array {
        $message = [
            'to'        => $token,
            'sound'     => $type === 'emergency' ? 'siren.wav' : 'default',
            'channelId' => $type === 'emergency' ? 'emergency_alert' : 'default',
            'priority'  => 'high',
            'title'     => $title,
            'body'      => $body,
            'badge'     => $badge,
            'data'      => array_merge([
                'type'   => $type,
                'route'  => $route,
                'ref_id' => $refId,
            ], $extraData),
        ];

        if ($type === 'emergency') {
            $message['ios'] = [
                'sound' => [
                    'critical' => true,
                    'name'     => 'siren.wav',
                    'volume'   => 1.0,
                ],
            ];
        }

        return $message;
    }
}
